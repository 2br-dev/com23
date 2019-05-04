<?php
namespace Online\Config;
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
        $this
            ->bind('orm.init.users-user')
            ->bind('orm.init.shop-order')

            ->bind('start')
            ->bind('cron')
            ->bind('getmenus')
            
            ->bind('user.logout')
            
            ->bind('controller.exec.users-admin-ctrl.index')
            ->bind('controller.beforeexec.shop-admin-orderctrl')
            ->bind('controller.exec.shop-admin-orderctrl.index')
            
            ->bind('orm.beforewrite.shop-order')
            ->bind('initialize');
    }

    /**
    * Расширение объектов
    */
    public static function initialize()
    {
        \Shop\Model\Orm\Order::attachClassBehavior(new \Online\Model\Behavior\ShopOrder());
    }

    /**
    * Функция проверяет какие операторы находятся онлайн. Возвращает того оператора, у которого наименьшее время последнего заказа
    */
    public static function getOperatorsOnline()
    {
        $operators_online = \RS\Orm\Request::make()
                            ->select('U.*, MIN(last_order_time) as last_time')
                            ->from(new \Users\Model\Orm\User(), 'U')
                            ->where(array(
                                'is_online' => 1,
                                'allowed_to_orders' => 1                                
                            ))
                            ->groupby('last_order_time')
                            ->object();
        
        return $operators_online;
    }

    /**  
    * проверка времени. Проверяем попадает ли текущее время в нужный интервал
    *
    */
    public static function checkCurrentTime()
    {
        $current_time = getdate();
        if($current_time['hours'] >= 8 && $current_time['hours'] <= 19){
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
    * Расширяем обеъкт Пользователя, добовляем новые поля и вкладки
    * 
    * @param \Users\Model\Orm\User $user
    */
    public static function ormInitUsersUser(\Users\Model\Orm\User $user)
    {
        $user->getPropertyIterator()->append(array(
            'is_online' => new Type\Integer(array(
                'maxLenght' => '2',
                'default' => 0,
                'description' => t('Оператор онлайн')
            )),
            'forced_offline' => new Type\Integer(array(
                'maxlenght' => '2',
                'default' => 0,
                'description' => t('Принудительно офлайн')
            )),
            'last_order_time' => new Type\Varchar(array(
                'description' => t('Время последнего назначенного заказа'),
                'maxlength' => 255
            )),
            'allowed_to_orders' => new Type\Integer(array(
                'description' => t('Допущен к работе с заказами'),
                'maxLingth' => 1,
                'default' => 1,
                'CheckBoxView' => array(0,1)

            )),
            t('Дата и время последней активности'),
                'time_last_activity' => new Type\Varchar(array(
                    'description' => t('Дата и время последней активности'),
                    'maxLength' => '255',
                    'default' => '0'

                )),  
        ));
    }

    /**
    * Расширяем объект Заказы. Добавляем новые поля
    * @param \Shop\Model\Orm\Order $order
    */
    public static function ormInitShopOrder(\Shop\Model\Orm\Order $order)
    {
        $order->getPropertyIterator()->append(array(
            //Дата доставки
            'date_delivery' => new Type\Date(array(
                'description' => t('Дата доставки')
            )),
            //Период доставки
            'period_delivery' => new Type\Varchar(array(
                'description' => t('Период доставки'),
                'maxLength'   => 10  
            )),
            //Звонок от оператора
            'need_to_call' => new Type\Integer(array(
                'description' => t('Нужен звонок от оператора'),
                'maxLength' => '1'
            )),
            'operator_to_manage' => new Type\Integer(array(
                'description' => t('Назначенный оператор обработки заказа'),
                'maxlength' => 11,
            )),
        ));
    }

    /**
    * при каждом обновление страницы пишем дату и время последней активности пользователя
    */
    public static function start()
    {
        \RS\Application\Application::getInstance()->addJs('%online%/online.js', null, null, false, array('footer' => 'footer'));
        $working_time_interval = self::checkCurrentTime();
        $need_group = 'com23operator';

        if(\RS\Application\Auth::isAuthorize()){            
            $current_user = \RS\Application\Auth::getCurrentUser();

            if(($current_user->inGroup($need_group) && $current_user['allowed_to_orders'])){
                if($working_time_interval){
                    $time = time(); 
                    $current_user['time_last_activity'] = $time;             

                    if(!$current_user['forced_offline']){
                        if(!$current_user['is_online']){
                            $current_user['is_online'] = 1;
                            $current_user['last_order_time'] = time();
                        }                  
                    }

                    $current_user->update();                                       
                }

                $header_panel = \RS\Controller\Admin\Helper\HeaderPanel::getInstance();
                $style = 'color: #fff; font-weight: bold; padding: 5px 12px 9px 10px; border-radius: 16px; display: inline;';
                if($current_user['is_online']){
                    $header_panel_item_title = 'on-line';
                    $style .= 'background: green;';
                }
                else{
                    $header_panel_item_title = 'off-line';
                    $style .= 'background: red;'; 
                }
                $router = \RS\Router\Manager::obj();
                $header_panel->addItem(
                    $header_panel_item_title, 
                    null, 
                    array(
                        'id'=>'user_online_status', 
                        'style' => $style, 
                        'data-url' => $router->getAdminUrl('ToggleUserOnline', [], 'online-tools')
                        )
                );               
            }  
            if($current_user->inGroup('admins')) {
                $header_panel = \RS\Controller\Admin\Helper\HeaderPanel::getInstance();
                $style = 'color: #fff; font-weight: bold; padding: 5px 12px 9px 10px; border-radius: 16px; display: inline;';
                if($current_user['is_online']){
                    $header_panel_item_title = 'on-line';
                    $style .= 'background: green;';
                }
                else{
                    $header_panel_item_title = 'off-line';
                    $style .= 'background: red;'; 
                }
                $router = \RS\Router\Manager::obj();
                $header_panel->addItem(
                    $header_panel_item_title, 
                    null, 
                    array(
                        'id'=>'user_online_status', 
                        'style' => $style, 
                        'data-url' => $router->getAdminUrl('ToggleUserOnline', [], 'online-tools')
                        )
                );   
            }     
        }        
    }

    /**
    * Планировщик заданий 
    */
    public static function cron($params)
    {       
        foreach($params['minutes'] as $minute){
            /**
            * каждые 5 минут проверяет пользователей онлайн на время последней активности.
            */
            if(($minute % 5) == 0){
                $all_users_online = \RS\Orm\Request::make()
                                    ->from(new \Users\Model\Orm\User())
                                    ->where(array(
                                        'is_online' => 1
                                    ))->exec()->fetchAll();
                
                if(count($all_users_online) > 0){
                    foreach($all_users_online as $user){
                        /**
                        * Если время последней активности пользователя 15 мин. и боле (900 сек.) то переводим его в "оф-лайн"
                        * Ежедневно после 20:00 в течении 5 минут переводим всех операторов в оф-лайн принудительно
                        */
                        if((($params['current_time'] - $user['time_last_activity']) >= 900) || ($minute >= 1200 && $minute <= 1205)){
                            \RS\Orm\Request::make()
                                ->update(new \Users\Model\Orm\User())
                                ->set(array(
                                    'is_online' => 0
                                ))
                                ->where(array(
                                    'id' => $user['id']
                                ))->exec();
                        }
                    }
                } 
            }

            /**
            * Ежедневно в 8:05(485 минута от 00:00) распределяем заказы накопленные с 20:00 до 08:00
            * Или если по какой то причине в рабочее время все были оф-лайн и накопились заказы, 
            *то в период с 8:00 до 20:00 они попадут первому оператору, который станет онлайн. Проверка каждую минуту.
            */
            if($minute > 480 && $minute < 1200){
                $all_orders_without_operator = \RS\Orm\Request::make()
                    ->from(new \Shop\Model\Orm\Order())
                    ->where(array(
                        'operator_to_manage' => -1
                    ))->exec()->fetchAll();
                    //file_put_contents(\Setup::$ROOT."/file.log", var_export(count($all_orders_without_operator), true));
                if(count($all_orders_without_operator) > 0){
                    $time = time();
                    foreach($all_orders_without_operator as $order){
                        $time = $time + 1; 
                        $user = self::getOperatorsOnline();                        
                        /**
                        * Назначаем заказу оператора
                        */
                        if($user){
                            \RS\Orm\Request::make()
                                ->update(new \Shop\Model\Orm\Order())
                                ->set(array(
                                    'operator_to_manage' => $user['id']
                                ))
                                ->where(array(
                                    'id' => $order['id']
                                ))->exec(); 
                            /**
                            * Обновляем флаг - время последнего заказа у оператора
                            */
                            \RS\Orm\Request::make()
                                ->update(new \Users\Model\Orm\User())
                                ->set(array(
                                    'last_order_time' => $time
                                ))
                                ->where(array(
                                    'id' => $user['id']
                                ))->exec();  
                        }           
                    }
                }    
            }           
        }      
    } 

    /**
    * Добавляем новые пункты меню в административную панель
    * 
    * @param mixed $items - массив установленных ранее меню
    */
    public static function getMenus($items)
    {
         // Все заказы без возомжности администрированя
         $items[] = array(
            'title' => t('Все заказы'),
            'alias' => 'allordersnotadmin',
            'link'  => '%ADMINPATH%/online-allordersctrl/',
            'sortn' => 100,
            'parent' => null,
            'typelink' => 'link'
         );
         
         return $items;
    }

    /* 
    * переключаем флаг онлайн пользователю при выходи из учетной записи
    * @param array $data    
    */
    public static function userLogout($data)
    {
        /**
        * 
        * @var \Users\Model\Orm\User $user
        */
        $user = $data['user'];        
        $need_group = 'com23operator';

        if($user->inGroup($need_group)){            
            $user['is_online'] = 0; 
            $user['forced_offline'] = 0;
            $user->update();   
        } 
    }

    /**
    * Добавляем переключатель - Допущен к работе с заказами - в список учетных записей
    */
    public static function controllerExecUsersAdminCtrlIndex(\RS\Controller\Admin\Helper\CrudCollection $controller)
    {
        /**
        * @var \RS\Html\Table\Element $table
        */
        $table = $controller['table']->getTable();
        $columns = $table->getColumns();
        $last_column = array_pop($columns);
        $columns[] = new TableType\UserFunc('allowed_to_orders', t('Допущен к работе с заказами'), function($value, $field){
            /**
            * @var \Users\Model\Orm\User $user
            */
            $user = $field->getRow();
            $user_id = $user['id']; 
            $group = 'com23operator';           

            if ($user->inGroup($group))
            {
                if($user['allowed_to_orders']){
                    $switch = 'on';
                }
                else{
                    $switch = '';
                }
                return '<div class="toggle-switch rs-switch crud-switch '.$switch.'" data-url="/admin/online-tools/?id='.$user_id.'&do=AjaxToggleUserAllowedToOrder">
                            <label class="ts-helper"></label>
                        </div>';
            }

            return "<p>недоступно</p>";
        });
        $columns[] = $last_column; 
        $table->setColumns($columns);
    }

    /* обновляем флаг онлайн пользователю при заходе на страницу Заказы в админ. панели
    *
    * @param array $params
    */     
    public static function controllerBeforeExecShopAdminOrderCtrl($params)
    {
        /**
        * 
        * @var \Users\Model\Orm\User $user
        */
        $user = \RS\Application\Auth::getCurrentUser();       
        $need_group = 'com23operator';
        $working_time_interval = self::checkCurrentTime();
        $op = self::getOperatorsOnline(); 
        // var_dump($working_time_interval);
        // var_dump($op);
        // exit();
               
        if($working_time_interval){
            if(($user->inGroup($need_group)) && $user['allowed_to_orders']){
                if($user['forced_offline']){
                    $user['is_online'] = 0;
                }
                else{
                    if(!$user['is_online']){
                        $user['is_online'] = 1;
                        $user['last_order_time'] = time();
                    }
                }
            }
        }                     
        $user->update();
    }

    /**
    * @param \RS\Controller\Admin\Helper\CrudCollection $helper 
    */
    public static function controllerExecShopAdminOrderCtrlIndex($helper)
    {
        /**
        * @var \Users\Model\Orm\User $user
        */
        $user = \RS\Application\Auth::getCurrentUser(); 
        
        
        if($user->inGroup('com23operator') && \RS\Application\Auth::isAuthorize()){                          
            $helper->getApi(null)->queryObj()
            ->where("operator_to_manage = {$user['id']} OR operator_to_manage = -100");
        } 
    }

    /**
    * Функция обработки полей заказа перед записью в бд
    * 
    * @param mixed $data
    */
    public static function ormBeforeWriteShopOrder($data)
    {
        $flag = $data['flag']; // update или create
        $router = \RS\Router\Manager::obj();
        $isAdminRoute = $router->isAdminZone();
        /**
        * @var \Shop\Model\Orm\Order $order
        */
        $order = $data['orm']; // ORM объект - заказ
        if ($flag == $order::INSERT_FLAG){
            //Проверяем если заказ не из админ-панели
            if($isAdminRoute) {
                $user = \RS\Application\Auth::getCurrentUser();
                $order['operator_to_manage'] = $user['id'];
            }
            else {            
                // Определяем операторов со статусом онлайн
                $operators_online = self::getOperatorsOnline();       

                if($operators_online){
                    $order['operator_to_manage'] = $operators_online['id'];
                    $operators_online['last_order_time'] = time();
                    $operators_online->update();
                }
                else{
                    $order['operator_to_manage'] = -1;
                }
            }
        }
    }
}
?>