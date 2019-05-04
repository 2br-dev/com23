<?php
namespace Eridan\Config;
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
            ->bind('orm.init.shop-address')
			->bind('orm.init.shop-order') // Расширяет ORM объект - заказ. Добавляет дополнительные поля.			 
			->bind('orm.init.catalog-product') // Расширяет ORM объект - товар.
            ->bind('orm.init.shop-orderitem')           

            ->bind('controller.exec.shop-admin-orderctrl.index')
            ->bind('controller.exec.shop-admin-orderctrl.Edit')
            ->bind('controller.exec.catalog-admin-ctrl.index')
            ->bind('controller.exec.support-admin-topicsctrl.index')

            ->bind('orm.beforewrite.shop-orderitem')
            ->bind('orm.beforewrite.shop-order')
            ->bind('orm.afterwrite.shop-order') // обрабатывает объет - заказ перед записью в бд
            
            ->bind('getroute')
            ->bind('getmenus')
            ->bind('initialize')

            ->bind('cart.before.addorderdata', null, 'updatePrices')
            ->bind('cart.addproduct.after', null, 'updatePrices') 
            ->bind('cart.update.after', null, 'updatePrices')
            ->bind('cart.removeitem.after', null, 'updatePrices')
        //    ->bind('exchange.orderexport.after')
        ;
	}

     /**
    * Расширяем объект OrderItem
    * 
    * @var \Shop\Model\Orm\OrderItem $orderItem
    */    
    public static function ormInitShopOrderItem(\Shop\Model\Orm\OrderItem $orderItem)
    {
       $orderItem->getPropertyIterator()->append(array(
            // Добавляем поле - Количество бутылок воды в OrderItems
            'amount_bottle_inOrder' => new Type\Integer(array(
                'description' => t('Количество бутылок воды в заказе'),
                'index' => true,
                'default' => 0
            )),
       )); 
    }

    /**
    * Действия перед записью в бд объека OrderItem
    * 
    * @param mixed $param
    */
    public static function ormBeforeWriteShopOrderItem($param)
    {
        /**
        * 
        * @var \Shop\Model\Orm\OrderItem $productItem
        */
        $productItem = $param['orm'];
        
        // Получаем все элементы из категории вода
        $config = \RS\Config\Loader::byModule('eridan'); // Конфиг модуля Eridan
        $water_dir_id = $config['water_dir_id']; //Из конфига получаем id категории "Вода"
        //Получаем список товаров из категории "Вода"
        $product_list_waterDir = \RS\Orm\Request::make()
            ->select('id')
            ->from(new \Catalog\Model\Orm\Product())
            ->where(array(
                'maindir' => $water_dir_id    
            ))
            ->exec()
            ->fetchAll();
        
        // Помещаем id всех продуктов из категории "Вода" в один массив (для проверки)
        $array_id_product_waterDir = array();
        foreach($product_list_waterDir as $item){
           array_push($array_id_product_waterDir, $item['id']); 
        }
        
        // Проверка на соответствие товара в таблице order_items с id товара из категории "Вода"
        // $productItem['amount_bottle_inOrder'] - количество бутылок в записе таблицы бд OrderItem
        if(in_array($productItem['entity_id'], $array_id_product_waterDir)){
            $productItem['amount_bottle_inOrder'] = $productItem['amount'];
        }
        else{
            $productItem['amount_bottle_inOrder'] = 0;
        } 
    }

    /**
    * Генерирует идентификатор элемента заказа
    * 
    */
    public static function generateId()
    {
        $symb = array_merge(range('a', 'z'), range('0', '9'));
        return \RS\Helper\Tools::generatePassword(10, $symb);
    }

    /**
    * Действия после записи заказа
    * 
    * @param array $data - данные
    */
    public static function ormAfterWriteShopOrder($data)
    {
        $flag = $data['flag'];
        $config = \RS\Config\Loader::byModule('eridan');
        $water_dir_id = $config['water_dir_id'];
        $empty_bottle_id = $config['bottle_id'];
        /**
        * @var \Shop\Model\Orm\Order $order
        */
        $order = $data['orm'];
        if ($flag == $order::INSERT_FLAG){
            /**
             * Механизм подсчета бытылок воды в заказе
             */
            /**
             * @var \Shop\Model\Cart $cart
             */
            $cart = $order->getCart();
            $order_data = $cart->getOrderData();
            $product_items = $cart->getProductItems();
            $amount = 0;

            $items = array();
            foreach ($product_items as $uniq=>$item){
                /**
                 * @var \Catalog\Model\Orm\Product $product
                 */
                $product = $item['product'];
                if ($product['id'] && $product->getMainDir()->id == $water_dir_id && $product['id'] != $empty_bottle_id){
                    $amount += $item['cartitem']['amount'];
                }
            }

            if ($amount > 0){
                $order['amount_bottles'] = $amount;
            }
            else {
                $order['amount_bottles'] = 0;
            }

            //$order->update();

            if ($order['use_addr']){
                $address = new \Shop\Model\Orm\Address($order['use_addr']);
                
                if ($address['id'] && ($address['is_remote_region'] || $address['is_discount_region'])){  //Если это отдаленный регион или льготный адрес

                    $update_order = false;
                    
                    foreach($order_data['items'] as $uniq=>$item){
                        $items[$uniq] = array();

                        if ($address['is_discount_region']){
                            $product = $product_items[$uniq]['product'];
                            $new_product = new \Catalog\Model\Orm\Product($product['id']);
                            $day_og_week = date('w');

                            if (($day_og_week == $config['discount_day']) && ($config['discount_product_id'] == $product_items[$uniq]['product']['id'])){
                                $items[$uniq] = array(
                                    'single_cost' => $new_product->getCost('Льготная цена', null, null, false),
                                );
                                $update_order = true;
                            }
                        }
                    }
                    
                    if ($amount>0 && !$address['is_discount_region']){
                       
                       $product_doplata = new \Catalog\Model\Orm\Product($config['remote_region_product_id']);
                       $uniq = self::generateId();
                       $items[$uniq] = array(
                           'uniq' => $uniq,
                           'title' => $product_doplata['title'],
                           'entity_id' => $product_doplata['id'],
                           'type' => $cart::TYPE_PRODUCT,
                           'single_weight' => 0,
                           'single_cost' => $product_doplata->getCost(null, null, false),
                           'amount' => $amount,
                       );
                       $update_order = true;
                    }

                    $cart->updateOrderItems($items);
                    $cart->saveOrderData();

                    if ($update_order){
                        $order->update();
                    }
                }
            }
        }
    }

    /**
    * Инициализация объектов
    * 
    */
    public static function initialize()
    {
        // Расширяет класс \Users\Model\Orm\User
        \Users\Model\Orm\User::attachClassBehavior(new \Eridan\Model\Behavior\UsersUser());
    }

    /**
    * Расширяет объект Адрес
    * 
    * @param \Shop\Model\Orm\Address $address
    */
    public static function ormInitShopAddress(\Shop\Model\Orm\Address $address)
    {
        $address->getPropertyIterator()->append(array(
            // Добавляем отметку - отдаленный регион доставки
            'is_remote_region' => new Type\Integer(array(
                'maxLength' => '1',
                'description' => t('Отдаленный регион доставки?'),
                'CheckBoxView' => array(1,0),
                'meVisible' => false,
            )),
            'is_discount_region' => new Type\Integer(array(
                'maxLength' => '1',
                'description' => t('Льготный регион доставки?'),
                'CheckBoxView' => array(1,0),
                'meVisible' => false,
            ))
        ));
    }
    
    
    public static function exchangeOrderExportAfter($params)
    {
        /**
        * @var \SimpleXMLElement $xml
        */
        $xml = $params['xml'];   
        
        /** 
        * @var \Shop\Model\Orm\Order $order
        */
        $order = $params['order'];   
        $user = $order->getUser();
        $phone = $user['phone'];    
        
        $cnt = count($xml->Контрагенты->Контрагент->Контакты->Контакт);
        
        $xml->Контрагенты->Контрагент->Контакты->Контакт[$cnt]->Тип = "Телефон";
        $xml->Контрагенты->Контрагент->Контакты->Контакт[$cnt]->Значение = $phone;
    }
    
    public static function getMenus($items)
    {
         $items[] = array(
            'title' => t('Заказы оплаченные on-line'),
            'alias' => 'orderspaidonline',
            'link'  => '%ADMINPATH%/eridan-orderspaidonlinectrl/',
            'sortn' => 10,
            'parent' => 'orders',
            'typelink' => 'link'
         );
         
         return $items;
    }
    
    public static function getRoute(array $routes)
    {           
        $routes[] = new Router\Route('users-front-register', '/register/', array(
            'controller' => 'eridan-front-register'
        ), t('Регистрация пользователя'));

        $routes[] = new Router\Route('users-front-profile', '/my/', array(
            'controller' => 'eridan-front-profile'
        ), t('Профиль пользователя'));
        
        return $routes;
    }
    
    public static function ormInitUsersUser(\Users\Model\Orm\User $user) 
    {
        $for_company = array('is_company' => 1);
        $chk_depend = array(get_class($user), 'chkDepend');  

        $user->getPropertyIterator()->append(array(            
            t('Пустые бутылки'),
                'empty_bottle' => new Type\Integer(array(
                    'maxLength' => '5',                   
                    'default' =>  0,                      
                    'description' => t('Бутылки'),
                )),
            
            // Добавляем вкладку Адреса
            t('Адреса'),
                'user_address_list' => new Type\UserTemplate('%eridan%/users/user_address_list.tpl', null, array(
                    'meVisible' => false
                )),          
            t('Организация'),
               'company_ogrn' => new Type\Varchar(array(
                'maxLength' => '15',
                'description' => t('ОГРН\ОГРНИП'),
                'condition' => array('is_company' => 1),
                'Checker' => array($chk_depend, t('Заполните поле ОГРН/ОГРНИП'), 'chkPattern', $for_company, array('/^(\d{13}|\d{15})$/')),
                'attr' => array(array(
                    'size' => 20
                )),
                'meVisible' => false,
                )),                
        ));   
    }
    
    /**
    * Расширяем контроллер добавляем колонки
    * 
    * @param \Catalog\Controller\Admin\Ctrl $controller - контроллер
    */
    public static function controllerExecCatalogAdminCtrlIndex(\RS\Controller\Admin\Helper\CrudCollection $controller) 
    {
       /**
        * @var \RS\Html\Table\Element $table
        */
        $table   = $controller['table']->getTable();
        $columns = $table->getColumns();
        $last_column = array_pop($columns);
        $columns[] = new TableType\Yesno('inStock', t('В наличии'), array('Sortable' => SORTABLE_BOTH, 'toggleUrl' => \RS\Router\Manager::obj()->getAdminPattern('ajaxToggleInNum', array(':id' => '@id'), 'eridan-tools')));  
        $columns[] = $last_column; 
        $table->setColumns($columns);     
    }
    
    /**
    * Изменяем цену товара, в зависимости от его количества
    * 
    * @param mixed $params
    */
    public static function updatePrices($params)
    {
        $site = new \RS\Site\Manager();
        $site_id = $site->getSite();

        $cart = $params['cart'];
        if (!isset($cart->is_self_call)) {
            
            $cart->is_self_call = true;
            
            $cart = $params['cart'];
            $in_basket = $cart->getProductItems();
            $amount_voda = 0; // Для подсчета колличества товаров в Корзине из категории Вода
            $config = Loader::byModule(__CLASS__);
            
            // Подсчет общего колличесва бутылок воды
            foreach ($in_basket as $n => $item) {
               $amount  = $item['cartitem']['amount'];
               $product = $item['product'];
               // Если товар из категории Вода или Вода в анапе для сайта com23.ru
                   if ($product->getMainDir()->id == $config->water_dir_id) {
                        if (!$product['is_empty_bottle']){ // Исключаем количесвто пустых бутылей
                            $amount_voda = $amount_voda + $amount;
                        }
                   }
            }
            //Конец
        
            $update_products = array();
            foreach($in_basket as $n => $item) {
                $product = $item['product'];
                if ($cart->getMode() != $cart::MODE_SESSION){
                    $product = new \Catalog\Model\Orm\Product($product['id']);
                }
                //Вставляем логику установки цен для товаров из категории Вода или Вода в анапе для сайта com23.ru
                if ($product->getMainDir()->id == $config->water_dir_id && !$product['is_empty_bottle']) {
                    if ($amount_voda < 2 ) {
                        $cost = null;
                    } 
                    if ($amount_voda >= 2 && $amount_voda < 4) {
                        $cost = $product->getCost('Цена от 2-х бутылей', $item['cartitem']['offer'], false, true);
                    }
                    if ($amount_voda >= 4) {
                        $cost = $product->getCost('Цена от 4-х бутылей', $item['cartitem']['offer'], false, true);
                    }
                    
                    if ($cost) {
                       $update_products[$n] = array(
                           'price' => $cost
                       ); 
                    } else {
                        $update_products[$n] = array(
                           'price' => false
                       ); 
                    }
                }
               
            }
            
            $cart->update($update_products, null, false); 
            
            unset($cart->is_self_call);
        }
        
        return $params;
    }
    
    public static function controllerExecSupportAdminTopicsctrlIndex (\RS\Controller\Admin\Helper\CrudCollection $helper)
    {                                                                 
                                                             
    }
    
    
    public static function controllerExecShopAdminOrderCtrlEdit(\RS\Controller\Admin\Helper\CrudCollection $helper)
    {
        //Если оператор не приндлежит к группе "admins" то не показываем кнопку удалить при редактировании заказа 
        if (!\RS\Application\Auth::getCurrentUser()->inGroup('admins')) {
            $helper['bottomToolbar']->removeItem('delete');
            
        }
    }

    public static function controllerExecShopAdminOrderCtrlIndex(\RS\Controller\Admin\Helper\CrudCollection $helper)
    {
        //Если оператор не приндлежит к группе "admins" то не показываем кнопку удалить в списке заказов
        if (!\RS\Application\Auth::getCurrentUser()->inGroup('admins')) {
             $helper->setBottomToolbar(null);
             /**
             * @var \RS\Html\Toolbar\Element $toolbar
             */
             $toolbar = $helper['topToolbar'];
             
             $toolbar->removeItem(1);
        }
    }


	public static function ormInitShopOrder(\Shop\Model\Orm\Order $order)
	{
		$order->getPropertyIterator()->append(array(
			    'operator' => new Type\Mixed(array(
                    'template' => '%eridan%/admin/view_order_info.tpl',
                    'description' => '',
                    'infoVisible' => true
                )),
				'operator_id_inProcessing' => new Type\Varchar(array(
	                    'maxLength' => '255',
	                    'description' => t('Оператор, установивший статус заказа - В Обработке'),
	            )),

	            'operator_id_success' => new Type\Varchar(array(
	                    'maxLength' => '255',
	                    'description' => t('Оператор, установивший статус заказа - Выполнен и закрыт'),
	            )),

	            'operator_id_cancelled' => new Type\Varchar(array(
	                    'maxLength' => '255',
	                    'description' => t('Оператор, установивший статус заказа - Отменен'),
	            )),
	            
	            'change_order_status_inProcessing' => new Type\Varchar(array(
	            	'maxLength' => '255',
	            	'description' => t('Дата и время изменения статуса заказа - В обработке'),
	            )),

	            'change_order_status_success' => new Type\Varchar(array(
	            	'maxLength' => '255',
	            	'description' => t('Дата и время изменения статуса заказа - Выполнен и закрыт'),
	            )),

	            'change_order_status_cancelled' => new Type\Varchar(array(
	            	'maxLength' => '255',
	            	'description' => t('Дата и время изменения статуса заказа - Отменен'),
	            )),	
                
                'change_order_status_waitforpay' => new Type\Varchar(array(
                    'maxLength' => '255',
                    'description' => t('Дата и время изменения статуса заказа - Ожидает оплаты'),
                )), 
                
                'operator_id_waitforpay' => new Type\Varchar(array(
                        'maxLength' => '255',
                        'description' => t('Оператор, установивший статус заказа - Ожидает оплаты'),
                )),   

                'paid_time' => new Type\Varchar(array(
                    'maxLength' => '255',
                    'description' => t('Дата и время Оплаты заказа'),
                )),  
                
                'checked_by_accountant' => new Type\Integer(array(
                    'maxLength'     => 1,
                    'description'   => t('Проверено бухгалтером'),
                    'allowEmpty' => false
                )),  
                'amount_bottles' => new Type\Integer(array(
                    'maxLength'     => 11,
                    'description'   => t('Количество бутылок в заказе'),
                    'index'         => true,
                    'default' => 0,
                )),         
		));
	}
    
    /**
    * Устанавливает доставку по умолчанию в заказе
    * 
    * @param \Shop\Model\Orm\Order $order - объект заказа
    * @return string
    */
    public static function setDelivery(\Shop\Model\Orm\Order $order)
    {
        $address = $order->getAddress();
        $user = $order->getUser();
        
        $addr_region_id  = $order->getAddress()->region_id;
        $addr_country_id = $order->getAddress()->country_id;


        $api = new \OnePageOrder\Model\Api();
        
        if (!$addr_country_id) {
            //Получаем страну первую в списке
            $address['country_id'] = $api->getFirstCountryId();
        }
        
        if ($addr_country_id && !$addr_region_id) {
            //Получаем первый в списке регион
            $address['region_id'] = $api->getFirstRegionId($addr_country_id);
        }

        $delivery_api = new \Shop\Model\DeliveryApi();
        $delivery_list = $delivery_api->getCheckoutDeliveryList($user, $order, true, true);
        if (empty($order['delivery'])) {
            foreach ($delivery_list as $delivery) {
                if ($delivery['default']) {
                    $order['delivery'] = $delivery['id'];
                    break;
                }
            }
        }
        
        if (!isset($order['delivery']) || !isset($delivery_list[$order['delivery']])) {
            $new_delivery = reset($delivery_list);
            $order['delivery'] = $new_delivery['id'];
        }
    }

	// Функция обработки полей заказа перед записью в бд
	public static function ormBeforeWriteShopOrder($data)
    {		
		$user = \RS\Application\Auth::getCurrentUser(); // Авторизированный пользователь
		$flag = $data['flag']; // update или create
        /**
        * @var \Shop\Model\Orm\Order $order
        */
		$order = $data['orm']; // ORM объект - заказ
		$status = $order->getStatus(); // Получение статуса заказа
        
        $shop_config = \RS\Config\Loader::byModule('shop');
        
        if ($flag == $order::INSERT_FLAG && $shop_config['hide_delivery']){
            self::setDelivery($order); 
        }    
        
        
		// Если идет обновление заказа
		if ($flag == $order::UPDATE_FLAG){
			// Если заказу установлен статус - В оigработке и оператор, установивший этот статус не записан
			if ($status['type'] == 'inprogress' && $order['operator_id_inProcessing'] == NULL){
				$order['operator_id_inProcessing'] = $user['login']; // Записываем авторизированого пользователя
				$order['change_order_status_inProcessing'] = date("d.m.Y H:i:s"); // Записываем время изменения статуса
			}

			// Если заказу установлен статус - В обработке и оператор, установивший этот статус не записан
			if ($status['type'] == 'success' && $order['operator_id_success'] == NULL){
				$order['operator_id_success'] = $user['login'];
				$order['change_order_status_success'] = date("d.m.Y H:i:s");
			}

			// Если заказу установлен статус - Отменен и оператор, установивший этот статус не записан
			if ($status['type'] == 'cancelled' && $order['operator_id_cancelled'] == NULL){
				$order['operator_id_cancelled'] = $user['login'];
				$order['change_order_status_cancelled'] = date("d.m.Y H:i:s");
			}
            
            // Если заказу установлен статус - Ожидает оплату и оператор, установивший этот статус не записан
            if ($status['type'] == 'waitforpay' && $order['operator_id_waitforpay'] == NULL){
                $order['operator_id_waitforpay'] = $user['login'];
                $order['change_order_status_waitforpay'] = date("d.m.Y H:i:s");
            }

            if ($order['is_payed'] == 1 && $order['paid_time'] == NULL){
                $order['paid_time'] = date("d.m.Y H:i:s");
            }
		}
		// Далее полученная информация вносится в карточку заказа. Файл /modules/shop/view/orderview.tpl	 			
	    
    }


	public static function ormInitCatalogProduct(\Catalog\Model\Orm\Product $product) 
	{
		$product->getPropertyIterator()->append(array(
			t('Основные'),
				'inStock' => new Type\Integer(array(
					'maxLength' => '1',
					'index' => true,
					'default' =>  1,
					'CheckBoxView' => array(1,0),
					'description' => t('В наличии'),
				)),
                'is_empty_bottle' => new Type\Integer(array(
                   'description' => t('Это пустая тара?'),
                   'CheckBoxView' => array(1,0),
                )),
                
		));
	}	
}
?>