<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Shop\Model\OrmType;

use RS\Orm\Type\User;
use Shop\Model\Orm\Order;

/**
 * Поле - поиск ID заказа по строке
 */
class SelectOrder extends User
{
    function __construct(array $options = null)
    {
        $this->view_attr = array('size' => 40, 'placeholder' => t('id, номер заказа, ФИО'));
        parent::__construct($options);
    }

    /**
     * @return Order
     */
    function getSelectedObject()
    {
        $deal_id = ($this->get()>0) ? $this->get() : null;
        if ($deal_id>0) {
            if (!isset(self::$cache[$deal_id])) {
                $deal = new Order($deal_id);
                self::$cache[$deal_id] = $deal;
            }
            return self::$cache[$deal_id];
        }
        return new Order();
    }

    /**
     * Возвращает URL, который будет возвращать результат поиска
     *
     * @return string
     */
    function getRequestUrl()
    {
        return $this->request_url ?: \RS\Router\Manager::obj()->getAdminUrl('ajaxSearchOrder', null, 'shop-tools');
    }

    /**
     * Возвращает наименование найденного объекта
     *
     * @return string
     */
    function getPublicTitle()
    {
        $order = $this->getSelectedObject();

        return t('Заказ №%num от %date', array(
            'num' => $order['order_num'],
            'date' => date('d.m.Y', strtotime($order['date_of']))
        ));
    }

    /**
     * Возвращает класс иконки zmdi
     *
     * @return string
     */
    function getIconClass()
    {
        return 'assignment';
    }
}