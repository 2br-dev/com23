<?php
namespace SberbankACPayment\Config;
use \RS\Orm\Type as OrmType;

/**
* Класс предназначен для объявления событий, которые будет прослушивать данный модуль и обработчиков этих событий.
*/
class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this
            ->bind('payment.gettypes')
            ->bind('order.change')
            ->bind('cron');
            //->bind('start');
    }


    public static function paymentGetTypes($list)
    {
        $list[] = new \SberbankACPayment\Model\PaymentType\SberbankACPayment();
        return $list;
    }

    public static function orderChange($dataEvent, $event)
    {
        //отмена транзации
        $order = $dataEvent['order'];
        $order_before = $dataEvent['order_before'];
        $payment = $order->getPayment()->getTypeObject();
        if (
            $payment->getShortName() == \SberbankACPayment\Model\PaymentType\SberbankACPayment::NAME
            && $order_before['status'] != $order['status']
            && $order->getStatus()->type == \Shop\Model\Orm\UserStatus::STATUS_CANCELLED ) {
                $server = $payment->getServer();
                $url = "https://{$server}/payment/rest/reverse.do";
                $transactions =  \RS\Orm\Request::make()
                        ->from(new \SberbankACPayment\Model\Orm\Transaction)
                        ->where('order_id='.$order['id'])
                        ->orderby('transaction_id desc')
                        ->objects();
                $data = array(
                    'userName'=>$payment->getOption('login'),
                    'password'=>$payment->getOption('password'),
                    'orderId'=>$transactions[0]['sberbank_id']
                );
                $data = http_build_query($data);
                $context_options = array (
                'http' => array (
                    'method' => 'POST',
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                        . "Content-Length: " . strlen($data) . "\r\n",
                    'content' => $data
                    )
                );
                $context = stream_context_create($context_options);
                $result = file_get_contents($url, false, $context);
            }

    }
    
    public static function cron()
    {
        $array_of_transaction =  \RS\Orm\Request::make()
            ->from(new \SberbankACPayment\Model\Orm\Transaction)
            ->where(array(
                    'status'=>0
                ))
            ->orderby('transaction_id')
            ->objects();
        
        $request = \RS\Http\Request::commonInstance();
        
        foreach($array_of_transaction as $sber_transaction) {
            $transaction = new \Shop\Model\Orm\Transaction($sber_transaction['transaction_id']);
            if ($transaction['id']) {
                $transaction->onResult($request);
            }
        }        
    }
    
    /**
    * Отправка запроса на проверку статуса транзакций
    */
    public static function start(){
        $folder = \Setup::$PATH.'/storage/tmp';
        $randname  = $folder.'/sber_timer.txt';
        
        if (file_exists($randname)){
            $f = fopen($randname,'a+');
            $time = fread($f,10);
            if ($time+60*1 < time()){
                ftruncate($f,0);
                fwrite($f,time());
                fclose($f);
            } else {
                return;
            }
        } else {
            $f = @fopen($randname,'w');
            if($f) {
                fwrite($f,time());
                fclose($f);
            }
        }
        
        file_put_contents(\Setup::$PATH.'/sberlog.txt', "\n".date('Y-m-d H:i:s').' run - ', FILE_APPEND);
        
        $array_of_transaction =  \RS\Orm\Request::make()
                        ->from(new \SberbankACPayment\Model\Orm\Transaction)
                        ->where(array(
                                'status'=>0
                            ))
                        ->orderby('transaction_id')
                        ->objects();
                        
        $router     = \RS\Router\Manager::obj();
        $request = \RS\Http\Request::commonInstance();
        $host = $request->server('HTTP_HOST', TYPE_STRING);
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
                        ? 1 : 0;
        $port = $https?443:80;
        $ssl = $https?'ssl://':'';

        file_put_contents(\Setup::$PATH.'/sberlog.txt', "\n".date('Y-m-d H:i:s').' array - '.print_r($array_of_transaction, true), FILE_APPEND);
        
        foreach($array_of_transaction as $transaction){
            
            file_put_contents(\Setup::$PATH.'/sberlog.txt', "\n".date('Y-m-d H:i:s').' start - '.$ssl.$host.':'.$port, FILE_APPEND);
            
            $fp = @fsockopen($ssl.$host, $port, $errno, $errstr, 30);
            stream_set_blocking($fp, 0);
            $url = '/onlinepay/SberbankACPayment/result/?transaction='.$transaction['transaction_id'];
            $out = "GET $url HTTP/1.1\r\n";
            $out .= "Host: ".$host."\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
            
            file_put_contents(\Setup::$PATH.'/sberlog.txt', "\n".date('Y-m-d H:i:s').' end - '.$ssl.$host.':'.$port, FILE_APPEND);
        }

    }
}