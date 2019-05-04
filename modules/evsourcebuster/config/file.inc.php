<?php

namespace evSourceBuster\Config;

use \RS\Orm\Type;

class File extends \RS\Orm\ConfigObject {
    /*   
     * Возвращает значения свойств по-умолчанию
     * 
     * @return array  
     */

    function _init() {
        parent::_init()->append(array(
   
            'utm_source' => new Type\Text(array('description' => t('Соответствие UTM меток и источника перехода. Только для разработчиков.'),
                'hint' => t('Введите JSON условия, разделив их символом ";". Соответствием всем UTM меткам необязательно,'
                        . ' достаточно ввести необходимый набор для идентификации.'),
                'default' => '{"source":"источник","medium":"тип",'
                . '"campaign":"кампания","name":"Название","code":"код источника"}',
                'cols' => 100,
                'rows' => 40
                    )),
        ));
    }

    public static function getDefaultValues() {
        return array(
            'name' => t('Источник перехода пользователя'),
            'description' => t('Используется Sourcebuster.js'),
            'is_system' => 0,
            'version' => '1.9.2.0',
            'author' => 'Yaroslav Ponomarev. ev-lab.ru'
        );
    }

}

?>
