<?php
namespace evSourceBuster\Config;

/**
* Класс отвечает за установку и обновление модуля
*/
class Install extends \RS\Module\AbstractInstall
{
function install()
    {
        
        $result = parent::install();
        if ($result) {
            $user = new \Users\Model\Orm\User();   
            Handlers::ormInitUsersUser($user);
            $user->dbUpdate();
            
            $order = new \Shop\Model\Orm\Order();
            Handlers::ormInitShopOrder($order);
            $order->dbUpdate();
            
            $one = new \Catalog\Model\Orm\OneClickItem();
            Handlers::ormInitCatalogOneClickItem($one);
            $one->dbUpdate();  
        }
        
        return $result;
    }
    
    /**
    * Функция обновления модуля, вызывается только при обновлении
    */
    function update()
    {
        $result = parent::update();
        if ($result) {
            $user = new \Users\Model\Orm\User();   
            Handlers::ormInitUsersUser($user);
            $user->dbUpdate();
            
            $order = new \Shop\Model\Orm\Order();
            Handlers::ormInitShopOrder($order);
            $order->dbUpdate();
            
            $one = new \Catalog\Model\Orm\OneClickItem();
            Handlers::ormInitCatalogOneClickItem($one);
            $one->dbUpdate();  
             
            
        }
        return $result;
    }     
}