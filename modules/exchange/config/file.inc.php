<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Exchange\Config;
use \RS\Orm\Type;

class File extends \RS\Orm\ConfigObject
{
    const 
        RIGHT_EXCHANGE = 1,
        ACTION_NOTHING      = "nothing",
        ACTION_CLEAR_STOCKS = "clear_stocks",
        ACTION_DEACTIVATE   = "deactivate",
        ACTION_REMOVE       = "remove";
        

    public
        //Описывает за что отвечает каждый из 8-ми бит числа, обозначающего уровень доступа
        //Каждый модуль может определить свою таблицу значимости битов
        $access_bit = array(
            'Чтение', //1-й бит - будет означать Разрешение на Чтение
            'Права на импорт/экспорт' //2-й бит будет означать разрешение на Запись
        );
        
    function _init()
    {
        parent::_init()->append(array(
            'file_limit' => new Type\Integer(array(
                'maxLength' => '11',
                'description' => t('Размер единовременно загружаемой части файла (в байтах)'),
            )),
            'use_zip' => new Type\Integer(array(
                'description' => t('Использовать сжатие zip, если доступно'),
                'checkboxview' => array(1,0),
            )),
            'brand_property' => new Type\Integer(array(
                'maxLength' => '11',
                'description' => t('Характеристика отвечающая за производителя товара'),
                'list' => array(array('\Catalog\Model\PropertyApi', 'staticSelectList'), array(0 => t('Не выбрано'))),
            )),
            'import_brand' => new Type\Integer(array(
                'description' => t('Импортировать бренд товара из поля "Изготовитель"'),
                'checkboxview' => array(1,0),
                'default' => 0,
            )),
            'weight_property' => new Type\Integer(array(
                'maxLength' => '11',
                'description' => t('Характеристика отвечающая за вес товара'),
                'list' => array(array('\Catalog\Model\PropertyApi', 'staticSelectList'), array(0 => t('Не выбрано'))),
            )),
            'use_log' => new Type\Integer(array(
                'description' => t('Логировать обмен данными'),
                'hint' => t('Лог сохраняется в БД в таблице ...exchange_log, а также в файле /storage/exchange/exchange.log'),
                'checkboxView' => array(1,0)
            )),
            'history_depth' => new Type\Integer(array(
                'description' => t('Сколько последних обменов хранить на сайте?'),
                'hint' => t('Если установить "0" - файлы обмена не будут сохраняться в истории')
            )),
            'dont_check_sale_init' => new Type\Integer(array(
                'description' => t('Не проверять блокировку обмена при обработке файла заказов'),
                'checkboxview' => array(1,0),
                'default' => 0,
            )),
            t('Каталог товаров'),
                'catalog_element_action' => new Type\Varchar(array(
                    'maxLength' => '50',
                    'description' => t('Что делать с товарами, отсутствующими в файле импорта'),
                    'listfromarray' => array(array(
                            self::ACTION_NOTHING      => t('Ничего'),
                            self::ACTION_CLEAR_STOCKS => t('Обнулять остаток'),
                            self::ACTION_DEACTIVATE   => t('Деактивировать'),
                            self::ACTION_REMOVE       => t('Удалить')
                        )
                    ),
                )),
                'catalog_section_action' => new Type\Varchar(array(
                    'maxLength' => '50',
                    'description' => t('Что делать с категориями, отсутствующими в файле импорта'),
                    'listfromarray' => array(array(
                            self::ACTION_NOTHING    => t('Ничего'),
                            self::ACTION_DEACTIVATE => t('Деактивировать'),
                            self::ACTION_REMOVE     => t('Удалить')
                        )
                    ),
                )),
                'catalog_import_interval' => new Type\Integer(array(
                    'maxLength' => '10',
                    'description' => t('Интервал одного шага в секундах (0 - выполнять загрузку за один шаг):'),
                )),
                'is_unic_barcode' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Идентифицировать товары по артикулу и наименованию'),
                    'hint' => t('Используется для импорта уникальных идентификаторов'),
                    'checkboxview' => array(1,0),
                )),
                'is_unic_dirname' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Идентифицировать категории по наименованию'),
                    'hint' => t('Используется для импорта уникальных идентификаторов'),
                    'checkboxview' => array(1,0),
                )),
                'catalog_translit_on_add' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Транслитерировать символьный код из названия при добавлении товара или каталога'),
                    'checkboxview' => array(1,0),
                )),            
                'catalog_translit_on_update' => new Type\Integer(array(
                    'description' => t('Транслитерировать символьный код из названия при обновлении товара или каталога'),
                    'checkboxview' => array(1,0),
                    'template' => '%exchange%/config_translit_checkbox.tpl'
                )),
                'catalog_keep_spec_dirs' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Сохранять связь товаров со спецкатегориями'),
                    'checkboxview' => array(1,0),
                )),
                'catalog_update_parent' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Обновлять зависимости категорий друг от друга'),
                    'checkboxview' => array(1,0),
                )),    
                'product_update_dir' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Обновлять категории у товаров'),
                    'checkboxview' => array(1,0),
                )),      
                'dont_delete_prop' => new Type\Integer(array(
                    'maxLength' => 1,
                    'default' => 0,
                    'description' => t('Не удалять характеристики товаров созданные на сайте'),
                    'checkboxview' => array(1,0),
                )),     
                'dont_update_fields' => new Type\ArrayList(array(
                    'description' => t('Поля товара, которые не следует обновлять'),
                    'Attr' => array(array('size' => 5,'multiple' => 'multiple', 'class' => 'multiselect')),
                    'List' => array(array('\Exchange\Model\Api', 'getUpdatableProductFields')),     
                    'CheckboxListView' => true,
                    'runtime' => false,
                )),
                'dont_update_offer_fields' => new Type\ArrayList(array(
                    'description' => t('Поля комплектаций, которые не следует обновлять'),
                    'Attr' => array(array('size' => 5,'multiple' => 'multiple', 'class' => 'multiselect')),
                    'List' => array(array('\Exchange\Model\Api', 'getUpdatableOfferFields')),     
                    'CheckboxListView' => true,
                    'runtime' => false,
                )),
                'dont_update_group_fields' => new Type\ArrayList(array(
                    'description' => t('Поля категории, которые не следует обновлять'),
                    'Attr' => array(array('size' => 5,'multiple' => 'multiple', 'class' => 'multiselect')),
                    'List' => array(array('\Exchange\Model\Api', 'getUpdatableGroupFields')),     
                    'CheckboxListView' => true,
                    'runtime' => false,
                )),                
                'multi_separator_fields' => new Type\Varchar(array(
                    'description' => t('Разделитель множественного значения в строке 1С'),
                    'maxLength' => 1,
                    'hint' => t('Включает обработку множественного свойства.<br/> 
                        При указании в свойстве 1С, типа строка, данного разделителя,<br/> 
                        оно будет воспринято как множемтвенное свойство'),
                    'Attr' => array(array('size' => '5')), 
                    'default' => '', 
                    'runtime' => false
                )), 
                'allow_insert_multioffers' => new Type\Integer(array(
                    'maxLength' => 1,
                    'default' => 0,
                    'description' => t('Использовать импорт многомерных комплектаций'),
                    'hint' => t('Позволяет включить импорт многомерных комплектаций из 1С.<br/> При включении опции, включается опция<br/> "Не удалять характеристики созданные на сайте"'),
                    'checkboxview' => array(1,0),
                )),    
                'unique_offer_barcode' => new Type\Integer(array(
                    'maxLength' => 1,
                    'default' => 0,
                    'description' => t('Уникализировать артикул комплектации при обмене?'),
                    'hint' => t('Добавляет уникальное окончание к артикулу переданному из 1С'),
                    'checkboxview' => array(1,0),
                )),
                'sort_offers_by_title' => new Type\Integer(array(
                    'maxLength' => 1,
                    'default' => 0,
                    'description' => t('Сортировать комплектации по наименованию'),
                    'hint' => t('Сортирует комплектации товаров методом NaturalSort (с учетом чисел в строках)'),
                    'checkboxview' => array(1,0),
                )),
                'cat_for_catless_porducts' => new Type\Integer(array(
                    'description' => t('Категория для товаров без категории?'),
                    'List' => array(array('\Catalog\Model\Dirapi', 'staticSelectList')),
                )),
                
            t('Заказы'),
                'sale_export_only_payed' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Выгружать только оплаченные заказы'),
                    'checkboxview' => array(1,0),
                )),
                'sale_export_statuses' => new Type\ArrayList(array(
                    'description' => t('Выгружать заказы со статусами'),
                    'Attr' => array(array('size' => 10,'multiple' => 'multiple', 'class' => 'multiselect')),
                    'List' => array(array('\Shop\Model\UserStatusApi', 'staticSelectList')),
                    'runtime' => false,
                )),
                'sale_final_status_on_delivery' => new Type\Integer(array(
                    'description' => t('Статус, в который переводить заказ при получении флага "Проведён" от "1С:Предприятие"'),
                    'List' => array(array('\Shop\Model\UserStatusApi', 'staticSelectList'), array(0 => t('-Не выбрано-'))),
                )),
                'sale_final_status_on_pay' => new Type\Integer(array(
                    'description' => t('Статус, в который переводить заказ при получении оплаты от "1С:Предприятие"'),
                    'List' => array(array('\Shop\Model\UserStatusApi', 'staticSelectList'), array(0 => t('-Не выбрано-'))),
                )),
                'sale_final_status_on_shipment' => new Type\Integer(array(
                    'description' => t('Статус, в который переводить заказ при получении отгрузки от "1С:Предприятие"'),
                    'List' => array(array('\Shop\Model\UserStatusApi', 'staticSelectList'), array(0 => t('-Не выбрано-'))),
                )),
                'sale_final_status_on_cancel' => new Type\Integer(array(
                    'description' => t('Статус, в который переводить заказ при получении флага "Отменён" от "1С:Предприятие"'),
                    'List' => array(array('\Shop\Model\UserStatusApi', 'staticSelectList'), array(0 => t('-Не выбрано-'))),
                )),
                'order_flag_cancel_requisite_name' => new Type\Varchar(array(
                    'description' => t('Название реквизита, содержащего флаг "Отменён"'),
                    'hint' => t('В некоторых редакциях 1С УТ 10.3 флаг "Отменён" имеет отличное наименование'),
                    'listFromArray' => array(array(
                        'Отменен' => t('Отменен'), 
                        'ПометкаУдаления' => t('ПометкаУдаления'),
                    )),
                )),
                'sale_replace_currency' => new Type\Varchar(array(
                    'maxLength' => '50',
                    'description' => t('Заменять валюту при выгрузке в "1С:Предприятие" на'),
                )),
                'order_update_ststus' => new Type\Integer(array(
                    'maxLength' => 1,
                    'default' => 0,
                    'description' => t('Обновлять статусы заказов при обмене'),
                    'checkboxview' => array(1,0),
                )),
                'export_timezone' => new Type\Varchar(array(
                    'description' => t('Выгружать заказы в часовом поясе'),
                    'default' => 'default',
                    'list' => array(function() {
                        $list = \DateTimeZone::listIdentifiers();
                        $result = array('default' => t('По умолчанию'));
                        foreach($list as $item) {
                            $time = new \DateTime('now', new \DateTimeZone($item));
                            $result[$item] = $item." (UTC".$time->format('P').")";
                        }
                        return $result;
                    })
                )),
                'uniq_delivery_id' => new Type\Integer(array(
                    'maxLength' => '1',
                    'description' => t('Уникализировать id доставки при экспорте<br>(для сервиса МойСклад)'),
                    'checkboxview' => array(1,0),
                )),
        ));
    }
    
    /**
    * Возвращает значения свойств по-умолчанию
    * 
    * @return array
    */
    public static function getDefaultValues()
    {
        return parent::getDefaultValues() + array(
            'use_zip'       => \Exchange\Model\Api::isZipAvailable() ? 1 : 0,
            'catalog_element_action'        => self::ACTION_NOTHING,
            'catalog_section_action'        => self::ACTION_NOTHING,
            'sale_export_statuses'  => array(), // По умолчанию все статусы заказов
            'tools' => array(
                array(
                    'url' => \RS\Router\Manager::obj()->getAdminUrl('ajaxFindBrands', array(), 'exchange-ctrl'),
                    'title' => t('Обновить бренды из характеристик'),
                    'description' => t('Собирает характеристики брендов и добавляет бренды')
                ),
            )
        );
    }
    
    
    /**
    * Срабатывает перед записью конфига
    * 
    * @param string $flag - insert или update
    */
    function beforeWrite($flag){
        //Добавим условия зависимости для импорта многомерных комплектаций 
        if ($this['allow_insert_multioffers'] && !$this['dont_delete_prop']){
            $this['dont_delete_prop'] = 1;
        }
    }
}