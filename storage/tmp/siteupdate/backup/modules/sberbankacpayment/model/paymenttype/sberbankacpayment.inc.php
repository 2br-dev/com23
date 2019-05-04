<?php
namespace SberbankACPayment\Model\PaymentType;
use \RS\Orm\Type;
use \Shop\Model\Orm\Transaction;
use \Shop\Model\PaymentType\ResultException;
use \SberbankACPayment\Model\Orm;

/**
* Способ оплаты - SberbankACPayment
*/
class SberbankACPayment extends \Shop\Model\PaymentType\AbstractType
{

    const TEST_SERVER = '3dsec.sberbank.ru';
    const PROD_SERVER = 'securepayments.sberbank.ru';

    const NAME = 'SberbankACPayment';

    /**
    * Возвращает название расчетного модуля (типа доставки)
    *
    * @return string
    */
    function getTitle()
    {
        return t('Оплата по карте (Сбербанк)');
    }

    /**
    * Возвращает описание типа оплаты. Возможен HTML
    *
    * @return string
    */
    function getDescription()
    {
        return t('Оплата по карте через интернет-эквайринг Сбербанка');
    }

    /**
    * Возвращает идентификатор данного типа оплаты. (только англ. буквы)
    *
    * @return string
    */
    function getShortName()
    {
        return self::NAME;
    }

    /**
    * Отправка данных с помощью POST?
    *
    */
    function isPostQuery()
    {
        return false;
    }

    /**
    * Возвращает ORM объект для генерации формы или null
    *
    * @return \RS\Orm\FormObject | null
    */
    function getFormObject()
    {
        $properties = new \RS\Orm\PropertyIterator(array(
            'login' => new Type\Varchar(array(
                'maxLength' => 255,
                'description' => t('Логин'),
                'hint' => t('аккаунт с окончанием на -api')

            )),
            'password' => new Type\Varchar(array(
                'description' => t('Пароль'),
                'hint' => t('Выдаётся Сбербанком')
            )),
            'testmode' => new Type\Integer(array(
                'maxLength' => 1,
                'description' => t('Тестовый режим'),
                'checkboxview' => array(1,0),
            )),
            '__help__' => new Type\Mixed(array(
                'description' => t(''),
                'visible' => true,
                'template' => '%sberbankacpayment%/form/payment/sberbankacpayment/help.tpl'
            )),
        ));

        return new \RS\Orm\FormObject($properties);
    }


    /**
    * Возвращает true, если данный тип поддерживает проведение платежа через интернет
    *
    * @return bool
    */
    function canOnlinePay()
    {
        return true;
    }

    public function getServer() {
        return $this->getOption('testmode')?self::TEST_SERVER:self::PROD_SERVER;
    }

    /**
    * Возвращает URL для перехода на сайт сервиса оплаты
    *
    * @param Transaction $transaction - ORM объект транзакции
    * @return string
    */
    function getPayUrl(\Shop\Model\Orm\Transaction $transaction)
    {

        $order      = $transaction->getOrder(); //Данные о заказе
        /**
        * @var mixed
        */
        $inv_id     = $transaction->id;
        $router     = \RS\Router\Manager::obj();

        $out_summ   = round($transaction->cost, 2);
        $success_url = $router->getUrl('shop-front-onlinepay', array(
                'Act'            => 'success',
                'transaction'    => $inv_id,
                'PaymentType'    => $this->getShortName(),
            ), true);

        $fail_url = $router->getUrl('shop-front-onlinepay', array(
                'Act'            => 'fail',
                'transaction'    => $inv_id,
                'PaymentType'    => $this->getShortName(),
            ), true);

        $server = $this->getServer();
        $url = "https://{$server}/payment/rest/register.do";

        $data = array(
            'userName'      => $this->getOption('login'),
            'password'      => $this->getOption('password'),
            'orderNumber'   => $order->order_num.'/'.$inv_id,
            'amount'        => $out_summ*100,
            'returnUrl'     => $success_url,
            'failUrl'       => $fail_url,
            'description'   => 'Оплата заказа №'.$order->order_num,
        );
        $data = http_build_query($data);
        $context_options = array (
        'http' => array (
            'method'    => 'POST',
            'header'    => "Content-type: application/x-www-form-urlencoded\r\n"
                        . "Content-Length: " . strlen($data) . "\r\n",
            'content'   => $data
            )
        );
        $context = stream_context_create($context_options);
        $result = file_get_contents($url, false, $context);
        //$result = '{"orderId":"53331108-cf57-4ff1-a015-495dcf94fd43","formUrl":"https://3dsec.sberbank.ru/payment/merchants/test/payment_ru.html?mdOrder=53331108-cf57-4ff1-a015-495dcf94fd43"}';
        $result = json_decode($result);

        if(!$result || (isset($result->errorCode) && $result->errorCode!=0)){
            if(!$result) {
                $error_msg = 'Сетевая ошибка';
            } else {
                $error_msg = $result->errorMessage;
            }
            $fail = $router->getUrl('shop-front-onlinepay', array(
               'Act'            => 'fail',
               'transaction'    => $inv_id,
               'PaymentType'    => $this->getShortName(),
               'msg'            => $error_msg,
            ), true);
            return $fail;
        } else {
            $trans = new \SberbankACPayment\Model\Orm\Transaction();
            $trans['sberbank_id']       = $result->orderId;
            $trans['transaction_id']    = $inv_id;
            $trans['order_id']          = $order->order_num;
            $trans->insert();

            return  $result->formUrl;
        }
    }

    /**
    * Возвращает ID заказа исходя из REQUEST-параметров соотвествующего типа оплаты
    * Используется только для Online-платежей
    *
    * @return mixed
    */
    function getTransactionIdFromRequest(\RS\Http\Request $request)
    {
        $inv_id = $request->request('transaction', TYPE_INTEGER, 0);
        if($inv_id){
            return $inv_id;
        }
        $order = $request->request('orderNumber', TYPE_STRING, "");
        $data = explode('/', $order);
        if(isset($data[1])) {
            return $data[1];
        } else {
            return 0;
        }
    }

    /**
    * Обработка возврата покупателя с формы сбербанка
    *
    * @param \Shop\Model\Orm\Transaction $transaction - объект транзакции
    * @param \RS\Http\Request $request - объект запросов
    * @return string
    */
    function onResult(\Shop\Model\Orm\Transaction $transaction, \RS\Http\Request $request)
    {
        $router     = \RS\Router\Manager::obj();
        $app = \RS\Application\Application::getInstance(); //Получили экземпляр класса страница
        
        $trans = new \SberbankACPayment\Model\Orm\Transaction();
        $trans->load($transaction->id);
        
        $server = $this->getServer();
        $url = "https://{$server}/payment/rest/getOrderStatus.do";

        $data = array(
        'userName'=>$this->getOption('login'),
        'password'=>$this->getOption('password'),
        'orderId'=>$trans['sberbank_id']
        );
        $data = http_build_query($data);
        $context_options = array (
        'http' => array (
            'method'    => 'POST',
            'header'    => "Content-type: application/x-www-form-urlencoded\r\n"
                        . "Content-Length: " . strlen($data) . "\r\n",
            'content'   => $data
            )
        );
        $context = stream_context_create($context_options);
        $result = file_get_contents($url, false, $context);
        
        file_put_contents(\Setup::$PATH.'/sberlog.txt', "\n".date('Y-m-d H:i:s').'request:'.$url, FILE_APPEND);
        
        /*$result = '{"expiration":"201512","approvalCode":"000000","Pan":"123456**6740",
"Amount":1000,"cardholderName":"yrey rgre","OrderStatus":2,"authCode":2,
"OrderNumber":"132353464","depositAmount":500,"Ip":"127.0.0.1"}';*/
        $result = json_decode($result);
        $errno = 0;
        if(!$result||(isset($result->errorCode)&&$result->errorCode!=0)) {
            if(!$result){
                $msg = 'Не удалось получить состояние оплаты, ошибка сети';
                $errno = 0;
                $app = \RS\Application\Application::getInstance();
                $app->headers
                ->cleanHeaders()
                ->setStatusCode('500','Network Error')
                ->sendHeaders();
            } else {
                $msg = $result->errorMessage;
                $errno = -2;
            }
        } else {
            
            file_put_contents(\Setup::$PATH.'/sberlog.txt', "\n".date('Y-m-d H:i:s').'result:'.print_r($result, true), FILE_APPEND);
            
            $errno = $result->OrderStatus;
            switch($result->OrderStatus){
                case 0:$msg = 'Оплата ещё не получена';break;
                case 2:$msg = 'Спасибо за оплату';break;
                case 3:$msg = 'Авторизация отменена';break;
                case 4:$msg = 'По транзакции была проведена операция возврата';break;
                case 5:$msg = 'Инициирована авторизация через ACS банка-эмитента';break;
                case 6:$msg = 'Авторизация отклонена';break;
                default: $msg = 'Состояние оплаты неизвестно';
            }
            if($result->OrderStatus == 2){
                $transaction['status']   = $transaction::STATUS_SUCCESS;
                $transaction->update();
                
                $order = $transaction->getOrder();
                $array_of_transaction =  \RS\Orm\Request::make()
                        ->from(new \SberbankACPayment\Model\Orm\Transaction)
                        ->where(array('order_id'=>$order->order_num))
                        ->objects();
                        
                foreach($array_of_transaction as $sb_transaction){
                    $sb_transaction['status'] = 1;
                    $sb_transaction->update();
                }
                return '1';
            }
            if(in_array($result->OrderStatus,array(3,4,6))){
                $trans = new \SberbankACPayment\Model\Orm\Transaction();
                $trans->load($transaction->id);
                $trans['status'] = 1;
                $trans->update();
            }

        }
        $exception = new ResultException(t($msg), 1);
        if($errno == 0 || $errno == 5) {
            $exception->setUpdateTransaction(false);
        }
        $exception->setResponse($msg);
        throw $exception;

    }

    /**
    * Вызывается при открытии страницы неуспешного проведения платежа
    * Используется только для Online-платежей
    *
    * @param \Shop\Model\Orm\Transaction $transaction
    * @param \RS\Http\Request $request
    * @return void
    */
    function onFail(\Shop\Model\Orm\Transaction $transaction, \RS\Http\Request $request)
    {

        $error = $request->get('msg',TYPE_STRING, '');
        if($error) {
            throw new \Exception($error);
        }
    }

    /**
    * Запуск проверки статуса оплаты
    */
    function onSuccess(\Shop\Model\Orm\Transaction $transaction, \RS\Http\Request $request) {
        $host = $request->server('HTTP_HOST', TYPE_STRING);
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
                        ? 1 : 0;
        $port = $https?443:80;
        $ssl = $https?'ssl://':'';
        $fp = @fsockopen($ssl.$host, $port, $errno, $errstr, 30);
        if($fp) {
            stream_set_blocking($fp, 0);
            $url = '/onlinepay/SberbankACPayment/result/?transaction='.$transaction->id;
            $out = "GET $url HTTP/1.1\r\n";
            $out .= "Host: ".$host."\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
        }
    }

}
