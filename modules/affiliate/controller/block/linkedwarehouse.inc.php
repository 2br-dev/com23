<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Controller\Block;

/**
* Блок - связанные склады(магазины)
*/
class LinkedWarehouse extends \RS\Controller\StandartBlock
{
    protected static
        $controller_title = 'Связанные склады(магазины)',        //Краткое название контроллера
        $controller_description = 'Отображает связанные с филиалом склады на странице контактов филиала';  //Описание контроллера
        
    protected
        $default_params = array(
            'indexTemplate' => 'blocks/linkedwarehouse/linked_warehouse.tpl',
        );
    
    function actionIndex()
    {
        $affiliate = @$this->router->getCurrentRoute()->affiliate;

        if ($affiliate instanceof \Affiliate\Model\Orm\Affiliate) {
            $warehouse_api = new \Catalog\Model\WareHouseApi();
            $warehouse_api->setFilter(array(
                'public' => 1,
                'affiliate_id' => $affiliate['id']
            ));
            $warehouses = $warehouse_api->getList();
        } else {
            $warehouses = array();
        }
        
        $this->view->assign(array(
            'warehouses' => $warehouses,
            'affiliate' => $affiliate
        ));
        
        return $this->result->setTemplate( $this->getParam('indexTemplate') );
    }
}