<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Partnership\Config;
use \RS\Orm\Type;

/**
* Конфигурационный файл модуля
* @ingroup Partnership
*/
class File extends \RS\Orm\ConfigObject
{
    function _init()
    {
        parent::_init()->append(array(
            'main_title' => new Type\Varchar(array(
                'description' => t('Название для основного сайта'),
                'hint' => t('Используется в качестве "Названия партнёра" при нахождении на основном сайте.'),
            ))
        ));
    }
}
