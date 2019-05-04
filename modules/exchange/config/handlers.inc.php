<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Exchange\Config;
use \RS\Orm\Type as OrmType;

/**
* Класс предназначен для объявления событий, которые будет прослушивать данный модуль и обработчиков этих событий.
* @ingroup Catalog
*/
class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this
            ->bind('getmenus')
            ->bind('getroute');
    }
    
    public static function getRoute($routes) 
    {
        $routes[] = new \RS\Router\Route('exchange-front-gate', array(
            '/site{site_id}/exchange/',
        ), null, t('Шлюз обмена данными'), true);
        
        return $routes;
    }
    
    /**
    * Возвращает пункты меню этого модуля в виде массива
    * 
    */
    public static function getMenus($items)
    {
        $items[] = array(
                'typelink'  => 'separator',
                'alias'     => 'products_separator',
                'parent'    => 'products',
                'sortn'     => 6
            );
        $items[] = array(
                'title'     => t('Обмен данными с 1С'),
                'alias'     => 'exchange',
                'link'      => '%ADMINPATH%/exchange-ctrl/',
                'typelink'  => 'link',
                'parent'    => 'products',
                'sortn'     => 8
            );
        return $items;
    }    
    
}