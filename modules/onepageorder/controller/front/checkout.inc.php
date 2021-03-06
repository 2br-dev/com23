<?php
namespace OnePageOrder\Controller\Front;
use \RS\Application\Auth as AppAuth;

/**
* Контроллер Оформление заказа на одной странице 
*/
class Checkout extends \RS\Controller\Front
{
    public
        $api,
        $order_api,
        $shop_config,
        $theme,
        $order;
    
    function init()
    {
        $this->app->title->addSection(t('Оформление заказа'));
        
        $this->order       = \Shop\Model\Orm\Order::currentOrder();
        $this->api         = new \OnePageOrder\Model\Api();
        $this->order_api   = new \Shop\Model\OrderApi();
        $this->shop_config = \RS\Config\Loader::byModule('shop'); //Погрузка конфига магазина
        $this->theme       = \RS\Theme\Manager::getCurrentTheme('theme');
        
        if (!in_array($this->theme, array('default', 'perfume', 'fashion', 'young', 'flatlines'))) {
            $this->theme = $this->getModuleConfig()->default_template;
        }
        
        //Проверим, а не на партнёрском ли мы сайте
        if (\RS\Module\Manager::staticModuleExists('partnership') && \RS\Module\Manager::staticModuleEnabled('partnership') && ($partner = \Partnership\Model\Api::getCurrentPartner())){
            $this->theme = $partner['onepageorder_theme'];
        }
        
        $this->order->clearErrors();
        $this->view->assign('order', $this->order);
    }
    
    /**
    * Контроллер предварительной привязки заказа к сессии
    */
    function actionIndex()
    {
        $this->order->clear();
                 
        //Замораживаем объект "корзина" и привязываем его к заказу
        $frozen_cart = \Shop\Model\Cart::preOrderCart(null);
        $frozen_cart->splitSubProducts();
        $frozen_cart->mergeEqual();
        
        $this->order->linkSessionCart($frozen_cart);
        $this->order->setCurrency( \Catalog\Model\CurrencyApi::getCurrentCurrency() );
        
        $this->order['ip'] = $_SERVER['REMOTE_ADDR'];
        
        $this->order['expired'] = false;
        $this->order['user_type'] = $this->shop_config->default_checkout_tab;        
        
        $this->redirect($this->router->getUrl('shop-front-checkout', array('Act' => 'confirmpage')));
    }
    
    
    /**
    * Страница с офорлением заказа
    * 
    */
    function actionConfirmPage(){
       
       if ( !$this->order->getCart() ) $this->redirect(); 
       
       //Устанавливаем текущий шаг для блока "Текущий шаг"
       $this->router->getCurrentRoute()->current_step = 'finish';
       
       $logout = $this->url->request('logout', TYPE_BOOLEAN);
       $login  = $this->url->request('ologin', TYPE_BOOLEAN); //Предварительная авторизация
        
       if ($logout) { //Если нужно разлогинится
            AppAuth::logout();
            $this->order->clearErrors();
            $this->order->setAddress(new \Shop\Model\Orm\Address());
            $this->redirect($this->router->getUrl('shop-front-checkout', array('Act' => 'confirmpage')));
       }
       
       $captcha_config = \RS\Config\Loader::byModule('kaptcha');
       //Добавим хлебные крошки
       $this->app->breadcrumbs
                ->addBreadCrumb(t('Оформление заказа'));
       
       if (AppAuth::isAuthorize()) {
            $this->order['user_type'] = null;
       } else {
            $this->order['__code']->setEnable(true);
            
            if (empty($this->order['user_type'])) {
                $this->order['user_type'] = 'person';
                $this->order['reg_autologin'] = 1;
            }
       }
       
       //Добавим временно сведения об адресе, если адрес нам передан
       $this->order->setAddress($this->api->getOrderRightAddress($this->order, $this->url));
        
       //Запрашиваем дополнительные поля формы заказа, если они определены в конфиге модуля
       $order_fields_manager  = $this->order->getFieldsManager();
       $order_fields_manager->setValues($this->order['userfields_arr']);
        
       //Запрашиваем дополнительные поля формы регистрации, если они определены
       $reg_fields_manager = \RS\Config\Loader::byModule('users')->getUserFieldsManager();
       $reg_fields_manager->setErrorPrefix('regfield_');
       $reg_fields_manager->setArrayWrapper('regfields');
       if (!empty($this->order['regfields'])){
           $reg_fields_manager->setValues($this->order['regfields']);
       } 
       
       if ($this->url->isPost()) { //POST
          $this->order['only_pickup_points'] = $this->request('only_pickup_points', TYPE_INTEGER, 0); //Флаг использования только самовывоза  
          $this->order_api->addOrderExtraDataByStep($this->order, 'onepageorder', $this->url->request('order_extra', TYPE_ARRAY, array())); //Заносим дополнительные данные
       
          //Проверерим адрес и сведения о пользователе  
          $this->api->checkUserAndAdressFields($this->order, $order_fields_manager, $reg_fields_manager); 
          
          //Проверерим сведения о доставке
          if (!$this->shop_config['hide_delivery']) { //Если не указано скрывать доставку
              $this->api->checkDeliveryFields($this->order, $this->request('delivery_extra', TYPE_ARRAY, false), $this->request('warehouse',TYPE_INTEGER,0)); 
          }
          
          //Проверерим сведения о оплате 
          if (!$this->shop_config['hide_payment']) { //Если не указано скрывать доставку                          
              $this->api->checkPaymentFields($this->order);  
          }
          
          //Проверим, если нужны условия продаж
          if ($this->shop_config['require_license_agree'] && !$this->url->post('iagree', TYPE_INTEGER)) {
             $this->order->addError(t('Подтвердите согласие с условиями предоставления услуг'));
          }
          
          $this->order['comments'] = $this->url->request('comments', TYPE_STRING);
          
          if (!$this->order->hasError()){ //Если ошибок нет, проверим данные для подтверждения
             $sysdata     = array('step' => 'confirm');
             $work_fields = $this->order->useFields($sysdata + $_POST);
            
             $this->order->setCheckFields($work_fields); 
             if ( $this->order->checkData($sysdata, null, null, $work_fields) ) {
                $this->order['is_payed'] = 0;
                $this->order['delivery_new_query'] = 1; //Флаг определяющий, что нужно сделать запрос к системе доставки, если требуется.
                
                // запустим событие для модификации заказа и проверим ошибки
                $this->fireConfirmEvent();
                $this->checkCriticalErrors();
                
                //Создаем заказ в БД
                if (!$this->order->hasError() && $this->order->insert()) {
                    $this->order['expired'] = true; //заказ уже оформлен. больше нельзя возвращаться к шагам.
                    \Shop\Model\Cart::currentCart()->clean(); //Очищаем корзиу                    
                    $this->redirect($this->router->getUrl('shop-front-checkout', array('Act' => 'finish')));
                }
             }
          }
       }
       // запустим событие для модификации заказа и проверим ошибки
       $this->fireConfirmEvent();
       $this->checkCriticalErrors();
       
       $user = AppAuth::getCurrentUser();
       if (AppAuth::isAuthorize()) {
           //Получаем список адресов пользователя
           $addr_list = $this->api->getOrderAdressesByUserId($user['id']);
           if (count($addr_list)>0 && $this->order['use_addr'] === null) {
               $this->order['use_addr'] = $addr_list[0]['id'];
           }
           $this->view->assign('address_list', $addr_list);
           $this->order['user_id'] = AppAuth::getCurrentUser()->id;
       }
       
       if (!$this->url->isPost() && !$this->order['use_addr']){ //Если не используется заранее выбранный адрес.
           $this->order->setDefaultAddress(); 
       }
       
       if ($login) { //Покажем только ошибки авторизации, остальные скроем
           $login_err = $this->order->getErrorsByForm('login');
           $this->order->clearErrors();
           if (!empty($login_err)) $this->order->addErrors($login_err, 'login');
       }
       
       //Посмотрим есть ли варианты для доставки по адресу и для самовывоза
       $have_to_address_delivery = \Shop\Model\DeliveryApi::isHaveToAddressDelivery($this->order);
       $have_pickup_points = \Shop\Model\DeliveryApi::isHavePickUpPoints($this->order);
       $this->view->assign(array(
           'have_to_address_delivery' => $have_to_address_delivery,
           'have_pickup_points' => $have_pickup_points,
       ));
       
       if (!$this->url->isPost()) {
           if ($have_pickup_points && ($this->shop_config['myself_delivery_is_default'] || !$have_to_address_delivery)) {
               $this->order['only_pickup_points'] = true;
           } else {
               $this->order['only_pickup_points'] = false;
           }
       }
       
       $this->order['password']     = '';
       $this->order['reg_openpass'] = '';
       $this->order['reg_pass2']    = '';
       
       $cart          = $this->order->getCart(); //Получаем сведения о корзине пользователя
       
       $this->view->assign(array(
           'is_auth'         => AppAuth::isAuthorize(),
           'order'           => $this->order,
           'cart'            => $cart,
           'shop_config'     => $this->shop_config,
           
           'delivery_block'  => $this->getDeliveryBlock($this->order, $user),
           'payment_block'   => $this->getPaymentBlock($this->order, $user),
           'product_block'   => $this->getProductsBlock($this->order, $user),
           
           'user'            => $user,
           'conf_userfields' => $order_fields_manager,
           'reg_userfields'  => $reg_fields_manager,
           'order_extra'     => !empty($this->order['order_extra']) ? $this->order['order_extra'] : array(),
       ));    
        
       return $this->result->setTemplate( 'templates/'.$this->theme.'/checkout/confirm.tpl' );
    }
    
    /**
    * Проверяет заказ на наличие ошибок, при которых дальнейшее оформление заказа невозможно
    * 
    * @return void
    */
    protected function checkCriticalErrors() {
        $cart_data = $this->order['basket'] ? $this->order->getCart()->getCartData() : null;
       
        if ($cart_data === null || !count($cart_data['items']) || $cart_data['has_error'] || $this->order['expired']) {
            //Если корзина пуста или заказ уже оформлен или имеются ошибки в корзине, то выполняем redirect на главную сайта
            $this->redirect();
        }
    }
    
    /**
    * Запускает событие для дополнительной проверки/корректировки заказа
    * 
    * @return void
    */
    protected function fireConfirmEvent() {
        static $can_fire = true;
        
        if ($can_fire) { // событие сработает только 1 раз
            \RS\Event\Manager::fire('checkout.confirm', array(
                'order' => $this->order,
                'cart' => $this->order->getCart()
            ));
            $can_fire = false;    
        }
    }
    
    /**
    * Обновление блоков оформления заказа на одной странице
    * 
    */
    function actionUpdate(){
        if ( !$this->order->getCart() ){ //Если корзины нет, то перенаправим на главную
            return $this->result->setSuccess(false)->addSection('redirect',$this->redirect()); 
        }

        $delivery_extra = $this->request('delivery_extra',TYPE_ARRAY,false);
        if ($delivery_extra){
            $this->order->addExtraKeyPair('delivery_extra', $delivery_extra);
        }
        
        //Получим текущего пользователя
        $user = \RS\Application\Auth::getCurrentUser(); 

        //Запишем данные о доставке
        $this->order['only_pickup_points'] = $this->request('only_pickup_points', TYPE_INTEGER, 0); //Флаг использования только самовывоза  
        $this->order['delivery']  = $this->request('delivery', TYPE_INTEGER, 0);
        $this->order['payment']   = $this->request('payment', TYPE_INTEGER, 0);
        $this->order['warehouse'] = 0;
        //Только если указана доставка самовывоз мы указываем конкретный склад, если он задан
        if ($this->order['delivery'] && $this->order->getDelivery()->getTypeObject()->getShortName() == 'myself'){ 
            $this->order['warehouse'] = $this->request('warehouse', TYPE_INTEGER, 0);       
        }
        
        //Добавим сведения об адресе
        $this->order->setAddress($this->api->getOrderRightAddress($this->order, $this->url));

        \RS\Event\Manager::fire('checkout.confirm', array(
            'order' => $this->order,
            'cart' => $this->order->getCart()
        ));

        $delivery = $this->getDeliveryBlock($this->order, $user); //Получим блок доставки
        $payment  = $this->getPaymentBlock($this->order, $user);  //Получим блок оплат
        $products = $this->getProductsBlock($this->order, $user); //Получим блок c товарами

        return $this->result->setSuccess(true)
                    ->addSection('blocks',array(
                        'delivery' => $delivery,
                        'payment'  => $payment,
                        'products' => $products
                    ));
    }
    
    
    /**
    * Получает шаблон блок с доставками
    * 
    * @param \Shop\Model\Orm\Order $order - объект заказа
    * @param \Users\Model\Orm\User $user - объект текущего пользователя
    * 
    * @return string
    */
    private function getDeliveryBlock(\Shop\Model\Orm\Order $order, \Users\Model\Orm\User $user)
    {
        if (!$this->shop_config['hide_delivery']) { //Если доставку не нужно скрывать
            //Получим новый список доставок с учётом переданных параметров
            
            $use_addr = $this->url->request('use_addr', TYPE_INTEGER);
            $addr_region_id = $this->url->request('addr_region_id', TYPE_INTEGER, $order->getAddress()->region_id );
            $addr_country_id = $this->url->request('addr_country_id', TYPE_INTEGER, $order->getAddress()->country_id);

            $address = $order->getAddress();
            
            if ($use_addr > 0) {
                $addr_region_id = $order->getAddress()->region_id;
                $addr_country_id = $order->getAddress()->country_id;
            }
            
            if (!$addr_country_id) {
                //Получаем страну первую в списке
                $address['country_id'] = $this->api->getFirstCountryId();
            }
            
            if ($addr_country_id && !$addr_region_id) {
                //Получаем первый в списке регион
                $address['region_id'] = $this->api->getFirstRegionId($addr_country_id);
            }

            //Устанавливаем значения, которые пришли из request
            $user_type = $this->url->request('user_type', TYPE_STRING, $user['is_company'] ? 'company' : 'person');
            $user['is_company'] = $user_type == 'company';

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
            
            //Получим доступные склады
            $warehouses = $this->api->getWarehouses();
            
            $view = new \RS\View\Engine();
            $view->assign(array(
               'user' => $user, //Пользователь
               'order' => $order, //Заказ
               'delivery_list' => $delivery_list, //Список доставок
               'warehouses' => $warehouses, //Список складов
               'this_controller' => $this, //Контроллер
            ));
            return $view->fetch( "%onepageorder%/templates/{$this->theme}/checkout/deliveryblock.tpl" ); 
        }
        return '';
    }
    
    
    /**
    * Получает шаблон блок с оплатами
    * 
    * @param \Shop\Model\Orm\Order $order - объект заказа
    * @param \Users\Model\Orm\User $user - объект текущего пользователя
    */
    private function getPaymentBlock(\Shop\Model\Orm\Order $order, \Users\Model\Orm\User $user)
    {
        $user_type = $this->url->request('user_type', TYPE_STRING, $user['is_company'] ? 'company' : 'person');
        $user['is_company'] = $user_type == 'company';

        $payment_api = new \Shop\Model\PaymentApi();
        $payment_list = $payment_api->getCheckoutPaymentList($user, $order);

        //Найдём оплату по умолчанию, если оплата не была задана раннее
        if (!$order['payment']){
            foreach ($payment_list as $payment) {
               if ($payment['default_payment']){
                  $order['payment'] = $payment['id'];
                  continue; 
               } 
            }
        }

        if (!$this->shop_config['hide_payment']) { //Если оплату не нужно скрывать

            $view = new \RS\View\Engine();
            $view->assign(array(
               'user' => $user, //Пользователь
               'order' => $order, //Заказ
               'pay_list' => $payment_list, //Список оплат
            ));
            return $view->fetch( "%onepageorder%/templates/{$this->theme}/checkout/paymentblock.tpl" );
        }
        return '';
    }
    
    /**
    * Получает шаблон блок с товарами
    * 
    * @param \Shop\Model\Orm\Order $order - объект заказа
    * @param \Users\Model\Orm\User $user - объект текущего пользователя
    */
    private function getProductsBlock(\Shop\Model\Orm\Order $order, \Users\Model\Orm\User $user)
    {
        //Подгрузим конфиг магазина
        $shop_config = \RS\Config\Loader::byModule('shop');
        
        $view = new \RS\View\Engine();
        $view->assign(array(
           'user' => $user, //Пользователь
           'order' => $order, //Заказ
           'shop_config' => $shop_config, //Конфиг магазина
           'cart' => $order->getCart(), //Корзина
        ));
        return $view->fetch( "%onepageorder%/templates/{$this->theme}/checkout/productsblock.tpl" );
    }
    
    /**
    * Шаг 5. Создание заказа
    */
    function actionFinish()
    {
        $this->app->title->addSection(t('Заказ №%0 успешно оформлен',array($this->order->order_num)));
        
        //Добавим хлебные крошки
        $this->app->breadcrumbs
                    ->addBreadCrumb(t('Корзина')) 
                    ->addBreadCrumb(t('Адрес и контакты')) 
                    ->addBreadCrumb(t('Выбор доставки'))
                    ->addBreadCrumb(t('Выбор оплаты'))
                    ->addBreadCrumb(t('Завершение заказа'));
        
        $this->view->assign(array(
            'cart' => $this->order->getCart(),
            'alt' => 'alt',
            'statuses' => \Shop\Model\UserStatusApi::getStatusIdByType()
        ));
        
        return $this->result->setTemplate( '%shop%/checkout/finish.tpl' );
    }
    
    /**
    * Выполняет пользовательский статический метод у типа оплаты или доставки, 
    * если таковой есть у типа доставки 
    */
    function actionUserAct()
    {
        $module   = $this->request('module',TYPE_STRING, 'Shop'); //Имя модуля
        $type_obj = $this->request('typeObj',TYPE_INTEGER,0);     //0 - доставка (DeliveryType), 1 - оплата (PaymentType)
        $type_id  = $this->request('typeId',TYPE_INTEGER,0);      //id доставки или оплаты
        $class    = $this->request('class',TYPE_STRING,false);    //Класс для обращения
        $act      = $this->request('userAct',TYPE_STRING,false);  //Статический метод который нужно вызвать 
        $params   = $this->request('params',TYPE_ARRAY,array());  //Дополнительные параметры для передачи в метод
       
        if ($module && $act && $class){
           $typeobj = "DeliveryType"; 
           if ($type_obj == 1){
              $typeobj = "PaymentType";
           } 
            
           $delivery = '\\'.$module.'\Model\\'.$typeobj.'\\'.$class;     
           $data = $delivery::$act($this->order, $type_id, $params);
           
           if (!$this->order->hasError()){
              return $this->result->setSuccess(true)
                     ->addSection('data',$data);  
           }else{
              return $this->result->setSuccess(false)
                    ->addEMessage($this->order->getErrorsStr());   
           }
        }else{
           return $this->result->setSuccess(false)
                    ->addEMessage(t('Не установлен метод или объект доставки или оплаты')); 
        }
    }
    
    /**
    * Удаление адреса при оформлении заказа
    */
    function actionDeleteAddress()
    {
        $id = $this->url->request('id', TYPE_INTEGER, 0); //id адреса доставки
        if ($id){
           $address = new \Shop\Model\Orm\Address($id); 
           if ($address['user_id'] == $this->user['id']) {
               $address['deleted'] = 1;
               $address->update();
           }
           return $this->result->setSuccess(true);
        }
        return $this->result->setSuccess(false);
    }
    
    
    /**
    * Подбирает город по совпадению в переданной строке
    */
    function actionSearchCity()
    {
        $query       = $this->request('term', TYPE_STRING, false);
        $region_id   = $this->request('region_id', TYPE_INTEGER, false);
        $country_id  = $this->request('country_id', TYPE_INTEGER, false);
        
        if ($query!==false && $this->url->isAjax()){ //Если задана поисковая фраза и это аякс
            $cities = $this->order_api->searchCityByRegionOrCountry($query, $region_id, $country_id);
            
            $result_json = array();  
            if (!empty($cities)){
                foreach ($cities as $city){
                    $region  = $city->getParent();
                    $country = $region->getParent();
                    $result_json[] = array(
                        'value'      => $city['title'],
                        'label'      => preg_replace("%($query)%iu", '<b>$1</b>', $city['title']),
                        'id'         => $city['id'],
                        'zipcode'    => $city['zipcode'],
                        'region_id'  => $region['id'],
                        'country_id' => $country['id']
                    );
                }
            }
            
            $this->wrapOutput(false);
            $this->app->headers->addHeader('content-type', 'application/json');
            return json_encode($result_json);
        }
    }
}