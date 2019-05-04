<?php
namespace Redirector\Model\Orm;
use \RS\Orm\Type;

/**
* ORM объект
*/
class RedirectRule extends \RS\Orm\OrmObject
{
    protected static
        $table = 'redirect_rule';
    
    function _init()
    {
        parent::_init()->append(array(
            'site_id' => new Type\CurrentSite(),
            'source_url' => new Type\Varchar(array(
                'description' => t('Старый адрес'),
                'hint' => t('Используйте относительные адреса. Например, /category/printer')
            )),
            'is_source_regex' => new Type\Integer(array(
                'description' => t('Использовать регулярные выражения'),
                'hint' => t('Если установлен данный флажок, то в поле Старый адрес можно использовать регулярные выражения.<br>
                            Слеш будет автоматически экранироваться. Остальные спец.символы необходимо экранировать согласно правилам PCRE.<br>
                            В Новом адресе можно использовать \1, \2, ... для вставки найденных частей<br>
                            Пример регулярного выражения Старого адреса: /catalog/cat-([0-9]+)'),
                'checkboxView' => array(1,0)
            )),
            'cut_query_string' => new Type\Integer(array(
                'description' => t('Не учитывать query_string'),
                'hint' => t('Исходный URL будет обрезан до знака `?`'),
                'allowEmpty' => false,
                'checkboxView' => array(1,0),
                'default' => 0,
                'maxLength' => 1
            )),
            'destination_url' => new Type\Varchar(array(
                'description' => t('Новый адрес'),
                'hint' => t('Используйте относительные адреса. Например, /catalog/printer/')
            )),
            'sortn' => new Type\Integer(array(
                'description' => t('Порядок'),
                'default' => 100,
                'hint' => t('Чем меньше порядковый номер, тем раньше будет обрабатываться правило')
            ))
        ));
    }
}
