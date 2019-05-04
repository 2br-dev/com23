<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Catalog\Model\Behavior;

class UsersUser extends \RS\Behavior\BehaviorAbstract
{
    /**
    * Возвращает объект персонального типа цены пользователя для указанного сайта,
    * если сайт не указан, то для текущего сайта.
    * 
    * @param integer $site_id - id сайта
    * @return \Catalog\Model\Orm\Typecost
    */
    function getUserTypeCost($site_id = null)
    {
        $user = $this->owner;
        $user_cost = unserialize($user['cost_id']);
        
        $cost_id = (isset($user_cost[$site_id])) ? $user_cost[$site_id] : $user_cost[\RS\Site\Manager::getSiteId()];
        $user_type_cost = new \Catalog\Model\Orm\Typecost($cost_id);
        
        return $user_type_cost;
    }
}
