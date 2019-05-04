<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Config;
use \RS\Orm\Type as OrmType;

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
            ->bind('orm.init.catalog-warehouse')
            ->bind('orm.init.menu-menu')
            ->bind('orm.beforewrite.shop-order')
            ->bind('init.api.menu-block-menu')
            ->bind('getroute')  //событие сбора маршрутов модулей
            ->bind('getmenus') //событие сбора пунктов меню для административной панели
            ->bind('product.getwarehouses', null, null, 10)
            ->bind('order.getwarehouses', null, 'productGetWarehouses')
            ->bind('menu.gettypes')
            ->bind('getpages')
            ->bind('start');
    }
    
    /**
    * Добавляет к складу поле "Филиал"
    */
    public static function ormInitCatalogWarehouse(\Catalog\Model\Orm\WareHouse $warehouse)
    {
        $warehouse->getPropertyIterator()->append(array(
            t('Основные'),
            'affiliate_id' => new OrmType\Integer(array(
                'description' => t('Филиал'),
                'allowEmpty' => false,
                'default' => 0,
                'list' => array(array('\Affiliate\Model\AffiliateApi', 'staticSelectList'), t('Не задано')),
                'hint' => t('Информация об остатке на складе в карточке товара и оформлении заказа будет отображаться только при выборе данного филиала')
            ))
        ));
    }
    
    /**
    * Добавляем фильтр по филиалу к пунктам меню
    * 
    * @param Menu\Controller\Block\Menu $menu_block_controller
    */
    public static function initApiMenuBlockMenu($menu_block_controller)
    {
        $affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        if ($affiliate['id']) {
            $menu_block_controller->api->setFilter(array(
                array(
                    'affiliate_id' => 0,
                    '|affiliate_id' => $affiliate['id']
                )
            ));
        }
    }
    
    /**
    * Добавим связь пунктов меню с филиалами
    * 
    * @param \Menu\Model\Orm\Menu $menu
    * @return void
    */
    public static function ormInitMenuMenu(\Menu\Model\Orm\Menu $menu)
    {
        $menu->getPropertyIterator()->append(array(
            t('Основные'),
            'affiliate_id' => new OrmType\Integer(array(
                'description' => t('Филиал'),
                'allowEmpty' => false,
                'default' => 0,
                'list' => array(array('\Affiliate\Model\AffiliateApi', 'staticSelectList'), t('Не задано')),
                'hint' => t('Данный пункт меню будет отображаться только при выборе указанного филиала')
            ))            
        ));
    }
    
    /**
    * Сохраняет в заказе сведения о выбранном на момент оформления филиале
    */
    public static function ormBeforewriteShopOrder($params)
    {
        if (!\RS\Router\Manager::obj()->isAdminZone() && $params['flag'] == \RS\Orm\AbstractObject::INSERT_FLAG) {
            $affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
            if ($affiliate['id']) {
                /**
                * @var \Shop\Model\Orm\Order
                */
                $order = $params['orm'];
                $order->addExtraInfoLine(
                    t('Выбранный город при оформлении'), 
                    $affiliate['title'], 
                    array('id' => $affiliate['id']), 
                    'affiliate'
                );
            }
        }
    }
    
    /**
    * Возвращает маршруты данного модуля. Откликается на событие getRoute.
    * @param array $routes - массив с объектами маршрутов
    * @return array of \RS\Router\Route
    */
    public static function getRoute(array $routes) 
    {        
        $routes[] = new \RS\Router\Route('affiliate-front-change', '/change-affiliate/{affiliate}/', null, t('Смена текущего филиала'));
        $routes[] = new \RS\Router\Route('affiliate-front-contacts', '/contacts/{affiliate}/', null, t('Контакты филиала'));
        $routes[] = new \RS\Router\Route('affiliate-front-affiliates', '/affiliates/', null, t('Выбор филиалов'));
        
        return $routes;
    }

    /**
    * Возвращает пункты меню этого модуля в виде массива
    * @param array $items - массив с пунктами меню
    * @return array
    */
    public static function getMenus($items)
    {
        $items[] = array(
            'title' => t('Филиалы в городах'),
            'alias' => 'affiliate',
            'link' => '%ADMINPATH%/affiliate-ctrl/',
            'parent' => 'modules',
            'typelink' => 'link',
        );
        return $items;
    }
    
    /**
    * Обрабатывает событие выборки складов для оторажения в карточке товара
    * 
    * @param mixed $params
    */
    public static function productGetWarehouses($params)
    {
        $affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
        if ($affiliate['id']) {
            $params['warehouse_api']->setFilter(array(
                array(
                    'affiliate_id' => 0,
                    '|affiliate_id' => $affiliate['id']
                )
            ));
        }
    }
    
    /**
    * Добавляет в систему собственный тип меню
    * 
    * @param \Affiliate\Model\MenuType\Affiliate[] $types
    * @return \Affiliate\Model\MenuType\Affiliate[]
    */
    public static function menuGetTypes($types)
    {
        $types[] = new \Affiliate\Model\MenuType\Affiliate();
        return $types;
    }
    
    /**
    * Устанавливает тип цен по умолчанию
    */
    public static function start()
    {
        $config = \RS\Config\Loader::byModule('affiliate');
        if (!\RS\Router\Manager::obj()->isAdminZone() && $config['installed']) {
            $affiliate = \Affiliate\Model\AffiliateApi::getCurrentAffiliate();
            if ($affiliate['cost_id']) {
                \Catalog\Model\CostApi::setSessionDefaultCost($affiliate['cost_id']);
            }
        }
    }
    
    /**
    * Добавляет страницы контактов филиалов в sitemap.xml
    */
    public static function getPages($pages)
    {
        $api = new \Affiliate\Model\AffiliateApi();
        $api->setFilter(array(
            'public' => 1,
            'clickable' => 1
        ));
        
        $list = $api->getListAsArray();
        
        $router = \RS\Router\Manager::obj();
        foreach($list as $item) {
            $url = $router->getUrl('affiliate-front-contacts', array('affiliate' => $item['alias']));
            $pages[$url] = array(
                'loc' => $url
            );
        }
        return $pages;
    }
}