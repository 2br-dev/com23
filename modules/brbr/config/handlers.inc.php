<?php
namespace Brbr\Config;
use \RS\Orm\Type,
    \RS\Router,
    \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Table,
    \RS\Config\Loader;


/**
* Кофигурационный файл для дополнительного модуля
*/


class Handlers extends \RS\Event\HandlerAbstract
{
	function init()
	{
        //$this
        //    ->bind('getroute')
        //    ->bind('getmenus');
	}

    /**
     * Возвращает массив маршрутов для системы
     *
     * @param \RS\Router\Route[] $routes - массив установленных ранее маршрутов
     * @return \RS\Router\Route[]
     */
    public static function getRoute($routes)
    {
        //Отображение отдельно брендов
        $routes[] = new \RS\Router\Route('brbr-front-vote',
            '/konkurs/', null, t('Просмотр работ'));


        return $routes;
    }

    public static function getMenus($items)
    {
        $items[] = array(
            'title' => t('Конкурс'),
            'alias' => 'konkurs',
            'link' => '%ADMINPATH%/brbr-ctrl/',
            'sortn' => 100,
            'typelink' => 'link',
            'parent' => 0
        );
        return $items;
    }

}