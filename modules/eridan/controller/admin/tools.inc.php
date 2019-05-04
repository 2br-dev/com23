<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Eridan\Controller\Admin;

/**
* Содержит действия по обслуживанию
*/
class Tools extends \RS\Controller\Admin\Front
{
    /**
     * Удаление несвязанных характеристик
     *
     * @return \RS\Controller\Result\Standard
     */
    function actionAjaxToggleInNum()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0);
        
        $product = new \Catalog\Model\Orm\Product($id);
        $product['inStock'] = !$product['inStock'];
        
        $product->update();
        
        
        return $this->result->setSuccess(true)->addMessage(t('Товар обновлен'));
    }

    /**
    * Переключение поля "Проверено" в пункте меню "Заказы оплаченные on-line"
    * 
    * @return \RS\Controller\Result\Standard
    */
    function actionAjaxToggleCheckedByAccountant()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0);
        
        $order = new \Shop\Model\Orm\Order($id);
        $order['checked_by_accountant'] = !$order['checked_by_accountant'];
        
        $order->update();
        
        return $this->result->setSuccess(true)->addMessage(t('Проверено'));       
    }

    /**
    * Переключает значение удаленного региона у адреса
    * 
    */
    function actionToggleUserAddress()
    {
        $id = $this->request('id', TYPE_INTEGER, 0);
        $name = $this->request('name', TYPE_STRING, '');
        $adress = new \Shop\Model\Orm\Address($id);
        
        if ($adress['id']){
             $adress[$name] = !$adress[$name];
             $adress->update(); 
        }
    }
}