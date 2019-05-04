<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Online\Controller\Admin;

/**
* Содержит действия по обслуживанию
*/
class Tools extends \RS\Controller\Admin\Front
{
    /**
    * Переключатель статуса on-line. Находися в верхней панли в админке
    */
    function actionToggleUserOnline() 
    {
        //$staus = $this->url->request('status', TYPE_INTEGER, -1);
        $user = \Rs\Application\Auth::getCurrentUser();
        $user['is_online'] = !$user['is_online'];
        $user['forced_offline'] = !$user['forced_offline'];
        $user->update();
        return true;
    } 
    
    /**
    * Обработка переключателя - Допущен к работе с заказами в админ. части - учетные записи пользователи
    */
    function actionAjaxToggleUserAllowedToOrder()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0);
        $user = new \Users\Model\Orm\User($id);  
        $user['allowed_to_orders'] = !$user['allowed_to_orders'];
        $user->update();

        return $this->result->setSuccess(true)->addMessage(t('Сохранено'));
    }
}