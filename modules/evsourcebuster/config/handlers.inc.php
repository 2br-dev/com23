<?php

namespace evSourceBuster\Config;

use \RS\Html\Table\Type as TableType,
    \RS\Html\Filter;

class Handlers extends \RS\Event\HandlerAbstract
{

    function init()
    {
        $this->bind('controller.beforewrap')
                ->bind('controller.front.beforewrap') //для старых версий
                ->bind('orm.init.shop-order')
                ->bind('orm.beforewrite.shop-order') 
                ->bind('orm.init.catalog-oneclickitem')
                ->bind('orm.beforewrite.catalog-oneclickitem')
                ->bind('orm.init.users-user')
                ->bind('orm.beforewrite.users-user')   
                ->bind('controller.exec.shop-admin-orderctrl.index')
                ->bind('controller.exec.users-admin-ctrl.index')
                ->bind('controller.exec.catalog-admin-oneclickctrl.index')
        ;
    }

    /**
     * Подключаем JS файлы
     */
    public static function controllerFrontBeforewrap()
    {
        $router = \RS\Router\Manager::obj();
        if (!$router->isAdminZone()) {
            ///подключаем скрипты            
            $app = \RS\Application\Application::getInstance();
            $app->addJs('%evsourcebuster%/sourcebuster.min.js', 'sourcebuster')
                ->addJs('%evsourcebuster%/sbjs.js', 'sbjs_start');
        }
    }

    public static function controllerBeforewrap($data)
    {
        $router = \RS\Router\Manager::obj();
        if (!$router->isAdminZone()) {
            ///подключаем скрипт            
            $config = \RS\Config\Loader::byModule('evsourcebuster');
            static::controllerFrontBeforewrap();
            return $data;
        };
    }
     
    
     /**
     * Заполняем допполя 
     */
    public static function ormBeforeWriteCatalogOneclickitem($params)
    {
      return static::saveData($params);
    }   
    
    
    /**
     * Заполняем допполя 
     */
    public static function ormBeforeWriteShopOrder($params)
    {
      return static::saveData($params);
    }

    

    /*
     * Заполняем допполя 
     */
    public static function ormBeforeWriteUsersUser($params)
    {
      return static::saveData($params);
    }
         
    
    private static function saveData($params)
    {
       if ($params['flag'] == \RS\Orm\AbstractObject::INSERT_FLAG) { //Если это создание 
            /**
             * Получаем из параметра ORM объект
             * @var \Catalog\Model\Orm\Product
             */

            $utm = array(
                'utm_first' => \RS\Http\Request::commonInstance()->cookie('sbjs_first', TYPE_STRING),
                'utm_current' => \RS\Http\Request::commonInstance()->cookie('sbjs_current', TYPE_STRING),
            );
            $orm = $params['orm'];
            $orm->source_info = json_encode($utm);
        }                         
    
    }
    
    
     /**
     * Добавляем в таблицу "Заказы в 1 клик"  источник перехода
     */
    public static function controllerExecCatalogAdminOneClickCtrlIndex($helper)
    {
        /**
         * @var $table \RS\Html\Table\Element
         */
        $table = $helper['table']->getTable();
        $column = new \RS\Html\Table\Type\Usertpl('source_info', t('Источник перехода'), '%evsourcebuster%/form/utm_table_row.tpl', array('Sortable' => SORTABLE_BOTH, 'hidden' => true)); 
        $table->addColumn($column, -1);

    }
             
          /**
     * Добавляем в таблицу "Заказы"  источник перехода
     */
    public static function controllerExecShopAdminOrderCtrlIndex($helper)
    {
        /**
         * @var $table \RS\Html\Table\Element
         */
        $table = $helper['table']->getTable();
        $column = new \RS\Html\Table\Type\Usertpl('source_info', t('Источник перехода'), '%evsourcebuster%/form/utm_table_row.tpl', array('Sortable' => SORTABLE_BOTH, 'hidden' => true)); 
        $table->addColumn($column, -1);

    }
     /**
     * Добавляем в таблицу Пользователи источник перехода
     */
    public static function controllerExecUsersAdminCtrlIndex($helper)
    {
        /**
         * @var $table \RS\Html\Table\Element
         */
        $table = $helper['table']->getTable();
        $column = new \RS\Html\Table\Type\Usertpl('source_info', t('Источник перехода'), '%evsourcebuster%/form/utm_table_row.tpl', array('Sortable' => SORTABLE_BOTH, 'hidden' => true)); 
        $table->addColumn($column, -1);

    }
 
    /*
     * Дополнительные поля для заказа в 1 клик
     */
    public static function ormInitCatalogOneclickitem(\Catalog\Model\Orm\OneClickItem $orm_order)
    {                                                                                 
    
    
        $orm_order->getPropertyIterator()->append(array(//Добавляем свойства к объекту 
         t('Источник перехода'),
            'source_info' => new \RS\Orm\Type\Text(array(
                'maxLength' => '255',
                'MeVisible' => false,
                'ReadOnly' => true,
                'infoVisible' => true,
                'description' => t('Источник перехода'),
                'template' => '%evsourcebuster%/form/utm_item_1click.tpl'
                ))
        ));
    }

   
    /*
     * Дополнительные поля для заказа 
     */
    public static function ormInitShopOrder(\Shop\Model\Orm\Order $orm_order)
    {                                                                                 
    
    
        $orm_order->getPropertyIterator()->append(array(//Добавляем свойства к объекту 
         t('Источник перехода'),
            'source_info' => new \RS\Orm\Type\Text(array(
                'maxLength' => '255',
                'MeVisible' => false,
                'ReadOnly' => true,
                'infoVisible' => true,
                'description' => t('Источник перехода'),
                'template' => '%evsourcebuster%/form/utm_item_order.tpl'
                ))
        ));
    }
    
    /*
     * Дополнительные поля для пользователя
     */
    public static function ormInitUsersUser(\Users\Model\Orm\User $orm_user)
    {
        $orm_user->getPropertyIterator()->append(array(//Добавляем свойства к объекту
            t('Источник перехода'), //Закладка, появится в форме редактирования товара
            'source_info' => new \RS\Orm\Type\Text(array(
                'maxLength' => '255',
                'MeVisible' => false,
                'ReadOnly' => true,
                'description' => t('Источник перехода'),
                'template' => '%evsourcebuster%/form/utm_item_user.tpl'
                )
            )
        ));
    }

}
