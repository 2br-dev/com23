<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Partnership\Controller\Block;
use \RS\Orm\Type;

/**
* Блок-контроллер Контакты
*/
class Contacts extends \RS\Controller\Block
{
    protected static
        $controller_title = 'Контакты партнера',
        $controller_description = 'Отображает раздел контакты для соответствующего партнера';
    
    function actionIndex()
    {
        if ($partner = \Partnership\Model\Api::getCurrentPartner()) {
            return $partner['contacts'];
        }
    } 
}