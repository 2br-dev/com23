<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Partnership\Config;
use \RS\Orm\Type as OrmType;
use \RS\Html\Filter as Filter;
use \RS\Html\Table\Type as TableType;

class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this
            ->bind('getroute')
            ->bind('getmenus')
            ->bind('orm.init.shop-order')
            ->bind('orm.init.catalog-oneclickitem')
            ->bind('orm.init.menu-menu')
            ->bind('orm.init.shop-reservation')
            ->bind('orm.init.shop-transaction')
            ->bind('orm.beforewrite.catalog-oneclickitem')
            ->bind('orm.beforewrite.shop-reservation')
            ->bind('orm.beforewrite.shop-order')
            ->bind('orm.beforewrite.shop-transaction')
            ->bind('orm.afterwrite.shop-order')
            ->bind('init.dirapi.catalog-block-category')
            ->bind('init.api.catalog-front-listproducts')
            ->bind('init.api.menu-block-menu')
            ->bind('theme.getcontextlist')
            ->bind('mailer.alerts.beforesend')
            ->bind('controller.exec.catalog-admin-oneclickctrl.index')
            ->bind('controller.exec.shop-admin-reservationctrl.index')
            ->bind('start', null, null, 11);
    }
    
    public static function getRoute($routes)
    {
        $routes[] = new \RS\Router\Route('partnership-front-profile', array(
            '/profile-partner/',
        ), null, t('Профиль партнера'));
        
        return $routes;
    }
    
    /**
    * Определяет ID партнера для текущей сессии
    */
    public static function start()
    {
        $config = \RS\Config\Loader::byModule('partnership');
        if ($config['installed']) {
            $partner = \Partnership\Model\Api::setCurrentPartner();
            if ($partner) {
                \RS\Theme\Manager::setCurrentTheme($partner->getTheme());
                \RS\Application\Application::getInstance()->initThemePath();
                \Catalog\Model\CostApi::setSessionDefaultCost($partner['cost_type_id']);
                if ($partner['logo']) {
                    $site = \RS\Config\Loader::getSiteConfig();
                    $site['logo'] = $partner['logo'];
                    $site['slogan'] = $partner['slogan'];
                }

                if ($partner['is_closed']
                    && !\RS\Application\Auth::getCurrentUser()->isAdmin())
                {
                    $closed_controller = new \Site\Controller\Front\SiteClosed();
                    echo $closed_controller->renderClosePage($partner);
                    exit;
                }
            }
        }
    }

    /**
     * Добавляем колонку с партнёрами в купить в один клик
     *
     *
     * @param \RS\Controller\Admin\Helper\CrudCollection $helper - объект помошника
     * @param \RS\Event\Event $event - событие
     */
    public static function controllerExecCatalogAdminOneClickCtrlIndex($helper, $event)
    {
        /**
         * @var \RS\Html\Table\Element $table
         */
        $table = $helper['table']->getTable();

        //Добавлем партнерский сайт для отображения
        $partners_list = \Partnership\Model\Api::staticSelectList(); //Список потрёрских сайтов в системе
        $table->addColumn(new TableType\Userfunc('partner_id', t('Партнерский сайт'), function ($partner_id) use ($partners_list){
            if ($partner_id > 0){
                return isset($partners_list[$partner_id]) ? $partners_list[$partner_id] : "";
            }
            return "";
        }, array('Sortable' => SORTABLE_BOTH, 'CurrentSort' => SORTABLE_ASC)), -1);

        /**
         * @var \RS\Html\Filter\Container
         */
        $container = $helper['filter']->getContainer();
        //Добавим партнерский сайт, если он присутствует
        $partners_list = array('' => t('-Не выбрано-')) + \Partnership\Model\Api::staticSelectList(); //Список потрёрских сайтов в системе
        $container->addLine(new \RS\Html\Filter\Line(array(
            'Items' => array(
                new Filter\Type\Select('partner_id', t('Партнерский сайт'), $partners_list)
            )
        )));

        $container->cleanItemsCache();
    }

    /**
     * Добавляем колонку с партнёрами в купить в один клик
     *
     *
     * @param \RS\Controller\Admin\Helper\CrudCollection $helper - объект помошника
     * @param \RS\Event\Event $event - событие
     */
    public static function controllerExecShopAdminReservationCtrlIndex($helper, $event)
    {
        /**
         * @var \RS\Html\Table\Element $table
         */
        $table       = $helper['table']->getTable();

        //Добавлем партнерский сайт для отображения
        $partners_list = \Partnership\Model\Api::staticSelectList(); //Список потрёрских сайтов в системе
        $table->addColumn(new TableType\Userfunc('partner_id', t('Партнерский сайт'), function ($partner_id) use ($partners_list){
            if ($partner_id > 0){
                return isset($partners_list[$partner_id]) ? $partners_list[$partner_id] : "";
            }
            return "";
        }, array('Sortable' => SORTABLE_BOTH, 'CurrentSort' => SORTABLE_ASC)), -1);

        /**
         * @var \RS\Html\Filter\Container
         */
        $container = $helper['filter']->getContainer();
        //Добавим партнерский сайт, если он присутствует
        $partners_list = array('' => t('-Не выбрано-')) + \Partnership\Model\Api::staticSelectList(); //Список потрёрских сайтов в системе
        $container->addLine(new \RS\Html\Filter\Line(array(
            'Items' => array(
                new Filter\Type\Select('partner_id', t('Партнерский сайт'), $partners_list)
            )
        )));

        $container->cleanItemsCache();
    }

    /**
     * Добавляем в ORM объект сведения о том на каком парнёрском сайте сохранен объект
     *
     * @param string $flag - insert или update
     * @param \RS\Orm\AbstractObject $object - объект ORM с которым работаем
     */
    private static function addPartnerColumnToOrm($flag, \RS\Orm\AbstractObject $object)
    {
        $partner = \Partnership\Model\Api::getCurrentPartner();
        if ($partner) {
            if ($flag == \RS\Orm\AbstractObject::INSERT_FLAG) {
                $object['partner_id'] = $partner['id'];
            }
        }
    }
    
    /**
    * Добавляет в заказ сведения о партнерском сайте
    *
    * @param array $params - массив с параметрами перед записью
    */
    public static function ormBeforeWriteShopOrder($params)
    {
        self::addPartnerColumnToOrm($params['flag'], $params['orm']);
        $partner = \Partnership\Model\Api::getCurrentPartner();
        if ($partner) {
            $order = $params['orm'];
            $order->addExtraInfoLine(t('Оформлен от партнера'), $partner['title'], array(
                'partner_id' => $partner['id']
            ));
        }
    }

    /**
     * Добавляет в предзаказ сведения о партнерском сайте
     *
     * @param array $params - массив с параметрами перед записью
     */
    public static function ormBeforeWriteShopReservation($params)
    {
        self::addPartnerColumnToOrm($params['flag'], $params['orm']);
    }

    /**
     * Добавляет в купить в один клик сведения о партнерском сайте
     *
     * @param array $params - массив с параметрами перед записью
     */
    public static function ormBeforeWriteCatalogOneClickItem($params)
    {
        self::addPartnerColumnToOrm($params['flag'], $params['orm']);
    }

    /**
     * Добавляет в транзакцию сведения о партнерском сайте
     *
     * @param array $params - массив с параметрами перед записью
     */
    public static function ormBeforeWriteShopTransaction($params)
    {
        self::addPartnerColumnToOrm($params['flag'], $params['orm']);
    }
    
    /**
    * Отправляем уведомление администратору партнерского сайта
    */
    public static function ormAfterwriteShopOrder($params)
    {
        $order = $params['orm'];
        if ($order['partner_id'] && $params['flag'] == 'insert') {
            $notice = new \Partnership\Model\Notice\CheckoutPartner();
            $notice->init($order);
            \Alerts\Model\Manager::send($notice);
        }
    }

    /**
     * Добавляем к заказу дополнительную колонку - партнер ID
     *
     * @param \Shop\Model\Orm\Order $orm_order - объект заказа
     */
    public static function ormInitShopOrder(\Shop\Model\Orm\Order $orm_order)
    {
        $orm_order->getPropertyIterator()->append(array(
            'partner_id' => new OrmType\Integer(array(
                'description' => t('ID партнера'),
                'meVisible' => false,
            ))
        ));
    }
    
    /**
     * Добавляем к предзаказу дополнительную колонку - партнер ID
     *
     * @param \Shop\Model\Orm\Reservation $orm_reserve - объект предзаказа
     */
    public static function ormInitShopReservation(\Shop\Model\Orm\Reservation $orm_reserve)
    {
        $orm_reserve->getPropertyIterator()->append(array(
            'partner_id' => new OrmType\Integer(array(
                'maxLength' => '11',
                'description' => t('Партнёрский сайт'),
                'default' => 0,
                'template' => '%partnership%/form/partner/partner_id.tpl'
            ))
        ));
    }

    /**
     * Добавляем к купить в один клик дополнительную колонку - партнер ID
     *
     * @param \Catalog\Model\Orm\OneClickItem $orm_one_click - объект покупки в один клик
     */
    public static function ormInitCatalogOneClickItem(\Catalog\Model\Orm\OneClickItem $orm_one_click)
    {
        $orm_one_click->getPropertyIterator()->append(array(
            'partner_id' => new OrmType\Integer(array(
                'maxLength' => '11',
                'description' => t('Партнёрский сайт'),
                'default' => 0,
                'template' => '%partnership%/form/partner/partner_id.tpl'
            ))
        ));
    }
    
    /**
    * Добавим связь пунктов меню с партнёскими сайтами
    * 
    * @param \Menu\Model\Orm\Menu $menu
    * @return void
    */
    public static function ormInitMenuMenu(\Menu\Model\Orm\Menu $menu)
    {
        $default_list = array(
            0 => t('- Не задан -'),
            '-1' => t('Основной сайт')
        );
        $menu->getPropertyIterator()->append(array(
            t('Основные'),
            'partner_id' => new OrmType\Integer(array(
                'description' => t('Партнёрский сайт'),
                'allowEmpty' => false,
                'default' => 0,    
                'listFromArray' => array($default_list + \Partnership\Model\Api::staticSelectList()),
                'hint' => t('Если указан - данный пункт меню будет отображаться только при выборе указанного партнёрского сайта')
            ))
        ));
    }
    
    /**
     * Добавляем к транзакции дополнительную колонку - партнер ID
     *
     * @param \Shop\Model\Orm\Transaction $orm_transaction - объект транзакции
     */
    public static function ormInitShopTransaction(\Shop\Model\Orm\Transaction $orm_transaction)
    {
        $orm_transaction->getPropertyIterator()->append(array(
            'partner_id' => new OrmType\Integer(array(
                'maxLength' => '11',
                'description' => t('Партнёрский сайт'),
                'default' => 0,
                'template' => '%partnership%/form/partner/partner_id.tpl'
            ))
        ));
    }
    
    /**
    * Возвращает контексты тем, которые добавляет данный модуль
    */
    public static function themeGetContextList($contexts)
    {
        $config = \RS\Config\Loader::byModule('partnership');
        if ($config['installed']) {
            $api = new \Partnership\Model\Api();
            foreach($api->getList() as $partner) {
                $theme_data = \RS\Theme\Manager::parseThemeValue($partner['theme']);
                $contexts[$partner->getThemeContext()] = array(
                    'title' => $partner['title'],
                    'theme' => $theme_data['theme']
                );
            }
        }
        return $contexts;
    }
    
    public static function initDirapiCatalogBlockCategory($controller)
    {
        $partner = \Partnership\Model\Api::getCurrentPartner();
        if ($partner) {
            $ids = $partner->getAllowFolderList();
            if (!empty($ids)) {
                $controller->api->setFilter('id', $ids, 'in');
            }
        }
    }
    
    public static function initApiCatalogFrontListProducts($controller)
    {
        $partner = \Partnership\Model\Api::getCurrentPartner();
        if ($partner) {
            $dirs = $partner->getAllowFolderList();
            if (!empty($dirs)) {
                $controller->api->setFilter('dir', $dirs, 'in');
                if (isset($controller->dirapi)) { // в контроллере catalog-block-searchline нет dirapi
                    $controller->dirapi->setFilter('id', $dirs, 'in');
                }
            }
        }
    }
    
    /**
    * Добавляем фильтр по партнёрскому сайту к пунктам меню
    * 
    * @param Menu\Controller\Block\Menu $menu_block_controller
    */
    public static function initApiMenuBlockMenu($menu_block_controller)
    {
        $partner = \Partnership\Model\Api::getCurrentPartner();
        $partner_id = ($partner['id']) ?: '-1';
        $menu_block_controller->api->setFilter(array(
            array(
                'partner_id' => 0,
                '|partner_id' => $partner_id,
            )
        ));
    }
    
    /**
    * Возвращает пункты меню этого модуля в виде массива
    * 
    */
    public static function getMenus($items)
    {
        $items[] = array(
                'title' => t('Партнерские сайты'),
                'alias' => 'partnership',
                'link' => '%ADMINPATH%/partnership-ctrl/',
                'parent' => 'modules',
                'sortn' => 3,
                'typelink' => 'link',
            );
        return $items;
    }
    
    /**
    * Подменяет поля from и reply-to в письме уведомления
    * 
    */
    public static function mailerAlertsBeforesend($params)
    {
        switch ($params['notice']->getSelfType()) {
            case 'shop-orderchange':
                $partner = new \Partnership\Model\Orm\Partner($params['notice']->order->partner_id);
                break;
            default:
                $partner = \Partnership\Model\Api::getCurrentPartner();
        }
      
        if (!empty($partner['id'])) {
            $api = new \Partnership\Model\Api();
            if (!empty($partner['notice_from'])) {
                $params['mailer']->FromName = $api->getPartnerNoticeParsed($partner['notice_from'], false);
                $params['mailer']->From = $api->getPartnerNoticeParsed($partner['notice_from'], true);
            }
            if (!empty($partner['notice_reply'])) {
                $params['mailer']->clearReplyTos();
                $params['mailer']->addReplyTo($api->getPartnerNoticeParsed($partner['notice_reply'], true), $api->getPartnerNoticeParsed($partner['notice_reply'], false));
            }
        }
    }
}

