<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Config;
use RS\Orm\Type;

/**
* Класс конфигурации модуля
*/
class File extends \RS\Orm\ConfigObject
{
    function _init()
    {
        parent::_init()->append(array(
            'use_geo_ip' => new Type\integer(array(
                'description' => t('Использовать GeoIP для определения ближайшего филиала?'),
                'checkboxView' => array(1,0)
            )),            
            'coord_max_distance' => new Type\Real(array(
                'description' => t('Максимально допустимое отклонение широты и долготы филиала от пользователя, в градусах'),
                'hint' => t('Если филиал будет отдален от координат пользователя более, чем на указанную здесь величину, то он не будет автоматически выбран')
            )),
            'confirm_city_select' => new Type\Integer(array(
                'description' => t('Запрашивать подтверждение города у пользователя'),
                'checkboxView' => array(1,0),
                'hint' => t('Запрашивается только один раз при первом посещении сайта')
            ))
        ));
    }
}