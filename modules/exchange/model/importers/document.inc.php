<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Exchange\Model\Importers;
use \RS\Helper\Tools as Tools;

/**
* Импорт документа заказа
*/

class Document extends \Exchange\Model\Importers\AbstractImporter
{
    static public $pattern = '/КоммерческаяИнформация\/Документ$/i';
    static public $title    = 'Импорт заказа';
    
    public function import(\XMLReader $reader)
    {  
        \Exchange\Model\Log::w(t("Импорт документа заказа: ").$this->getSimpleXML()->Номер);
        $config = \RS\Config\Loader::byModule($this);
        $order_id = (int)$this->getSimpleXML()->Номер;
        $order = new \Shop\Model\Orm\Order($order_id);
        if ($order['id']) {
            // Проведен ли заказ
            $is_provided  = false;
            $is_payed     = false;
            $is_shipped   = false;
            $is_cancelled = false;
            foreach($this->getSimpleXML()->ЗначенияРеквизитов->ЗначениеРеквизита as $one){
                switch ($one->Наименование) {
                    case 'Проведен':
                        if($one->Значение == 'true') {
                            $is_provided = true;
                        }
                        break;
                    case 'Номер оплаты по 1С':
                        if(!empty($one->Значение)) {
                            $is_payed = true;
                        }
                        break;
                    case 'Номер отгрузки по 1С':
                        if(!empty($one->Значение)) {
                            $is_shipped = true;
                        }
                        break;
                    case $config['order_flag_cancel_requisite_name']:
                        if($one->Значение == 'true') {
                            $is_cancelled = true;
                        }
                        break;
                }
                
                // Обновляем статус заказа, если включена соответствующая опция
                if ($one->Наименование == 'Статус заказа' && $this->getConfig()->order_update_ststus) {
                    $status = \Shop\Model\Orm\UserStatus::loadByWhere(array(
                                                                        'title' => (string)$one->Значение,
                                                                        'site_id' => \RS\Site\Manager::getSiteId()
                                                                    ));
                    if ($status['id']) {
                        $order->status = $status['id'];
                    }
                }
            } 
            
            // Если проведен и стоит настройка для переключения в нужный статус заказа
            
            // Устанавливаем статус заказа в соответствии с настройкой "Статус, в который переводить заказ при получении флага "Проведён" от "1С:Предприятие"
            if ($is_provided && $this->getConfig()->sale_final_status_on_delivery) {
                $order->status = (string)$this->getConfig()->sale_final_status_on_delivery;
            }
            // Устанавливаем статус заказа в соответствии с настройкой "Статус, в который переводить заказ при получении оплаты от "1С:Предприятие"
            if ($is_payed && $this->getConfig()->sale_final_status_on_pay) {
                $order->status = (string)$this->getConfig()->sale_final_status_on_pay;
            }
            // Устанавливаем статус заказа в соответствии с настройкой "Статус, в который переводить заказ при получении отгрузки от "1С:Предприятие"
            if ($is_shipped && $this->getConfig()->sale_final_status_on_shipment) {
                $order->status = (string)$this->getConfig()->sale_final_status_on_shipment;
            }
            // Устанавливаем статус заказа в соответствии с настройкой "Статус, в который переводить заказ при получении флага "Отменён" "1С:Предприятие"
            if ($is_cancelled && $this->getConfig()->sale_final_status_on_cancel) {
                $order->status = (string)$this->getConfig()->sale_final_status_on_cancel;
            }
            $order->update();
        }
    }
}
