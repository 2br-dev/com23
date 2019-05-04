<?php
namespace SocialAuth\Config;

use \RS\Orm\Type,
\RS\Html\Toolbar\Button;

/**
* Класс предназначен для объявления событий, которые будет прослушивать данный модуль и обработчиков этих событий.
*/
class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this->bind('getroute');
    }
    
    
    /**
    * Получает новые маршруты в системе
    * 
    * @param array $routes - массив установленных маршрутов
    */
    public static function getRoute($routes) 
    {
        //Просмотр категории продукции
        $routes[] = new \RS\Router\Route('socialauth-front-auth', array(
            '/socialauth/'
        ), null, t('Авторизация через соц. сети'));
        
        return $routes;
    }
}