<?php
namespace Online\Model\Behavior;
use \RS\Orm\Type;

/**
* Объект - Расширения пользователя
*/
class ShopOrder extends \RS\Behavior\BehaviorAbstract
{  
        
    /**
    * Получает список адресов оформленных заказов
    * 
    * @return array|false
    */
    function getOperatoToManage()
    {  
        /**
        * @var \Shop\Model\Orm\Order $order 
        */
        $order = $this->owner; //Расширяемый объект, в нашем случае - пользователь. 
        return \RS\Orm\Request::make()
            ->from(new \Users\Model\Orm\User())
            ->where(array(
                'id' => $order['operator_to_manage']
            ))->object();      
    }
}

