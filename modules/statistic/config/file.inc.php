<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Statistic\Config;
use \RS\Orm\Type;

class File extends \RS\Orm\ConfigObject
{
    function _init()
    {
        parent::_init()->append(array(
            'consider_orders_status' => new Type\ArrayList(array(
                'runtime' => false,
                'description' => t('Учитывать в отчетах заказы в следующих статусах (удерживая CTRL можно выбрать несколько)'),
                'Attr' => array(array('size' => 10,'multiple' => 'multiple', 'class' => 'multiselect')),
                'list' => array(array('\Shop\Model\UserStatusApi', 'staticSelectList'), array('0' => t('- все статусы -'))),            
            ))
        ));
    }    
}