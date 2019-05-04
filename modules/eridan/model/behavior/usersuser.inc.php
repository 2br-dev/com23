<?php
namespace Eridan\Model\Behavior;
use \RS\Orm\Type;

/**
* Объект - Расширения пользователя
*/
class UsersUser extends \RS\Behavior\BehaviorAbstract
{  
        
    /**
    * Получает список адресов оформленных заказов
    * 
    * @return array|false
    */
    function getUserAddress()
    {  
        $user = $this->owner; //Расширяемый объект, в нашем случае - пользователь. 
        return \RS\Orm\Request::make()
            ->from(new \Shop\Model\Orm\Address())
            ->where(array(
                'site_id' => \RS\Site\Manager::getSiteId(),
                'user_id' => $user['id'],
                'deleted' => 0,
            ))->objects();      
    }
}

