<?php
namespace Test\Config;
use \RS\Orm\Type;
 
/**
* Конфигурационный файл модуля
*/
class File extends \RS\Orm\ConfigObject
{
    /**
    * Возвращает значения свойств по-умолчанию
    * 
    * @return array
    */
    public static function getDefaultValues()
    {
        return array(
            'name' => t('Доп. картинка в карточке'),
            'description' => t('Добавляет вкладку для доп. картинки'),
            'version' => '1.0.0.0',
            'author' => 'ReadyScript lab.'
        );
    }       
     
}