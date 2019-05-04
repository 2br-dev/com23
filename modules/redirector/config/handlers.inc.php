<?php
namespace Redirector\Config;

/**
* Класс содержит обработчики событий, на которые подписан модуль
*/
class Handlers extends \RS\Event\HandlerAbstract
{
    /**
    * Добавляет подписку на события
    * 
    * @return void
    */
    function init()
    {
        $this
            ->bind('start')  //событие сбора маршрутов модулей
            ->bind('getmenus'); //событие сбора пунктов меню для административной панели
    }
    
    /**
    * Производим редирект, если необходимо
    */
    public static function start() 
    {        
        $api = new \Redirector\Model\RedirectApi();
        $api->applyRedirect();
    }

    /**
    * Возвращает пункты меню этого модуля в виде массива
    * @param array $items - массив с пунктами меню
    * @return array
    */
    public static function getMenus($items)
    {
        $items[] = array(
            'title' => t('301 редиректы'),
            'alias' => 'redirector',
            'link' => '%ADMINPATH%/redirector-ctrl/',
            'parent' => 'modules',
            'typelink' => 'link',
        );
        return $items;
    }
}