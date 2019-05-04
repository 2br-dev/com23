<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Eridan\Controller\Admin;

use \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Toolbar,
    \RS\Html\Filter,
    \RS\Html\Table,
    \RS\Html\Tree,
    \Shop\Model;
    
/**
* Контроллер Управление заказами
*/
class OrdersPaidOnlineCtrl extends \Shop\Controller\Admin\OrderCtrl
{
    /**
    * Хелпер главной панели
    * 
    */
    function helperIndex()
    {
        $helper = parent::helperIndex();
        $helper->setTopToolbar(new Toolbar\Element());

        $helper->addCsvButton('eridan-orderspaidonline');
        
        //$edit_href = $this->router->getAdminPattern('edit', array(':id' => '@id'));       
        
        /**
        * @var \Shop\Model\OrderApi $api
        */
        $api = $this->api;
        

        $api->queryObj()->where(array(
            'is_payed' => 1,
            'payment' => $this->getModuleConfig()->online_payment
        ));
        
        $helper
            ->setTopHelp(t('Здесь отображаются заказы которые были оплачены on-line.'))             
            ->viewAsTable()
            ->setTopTitle(t('Заказы оплаченные on-line'))
            ->setTable(new Table\Element(array(
            'Columns' => array(
                new TableType\Viewed(null, $this->api->getMeterApi()),
                new TableType\Text('order_num', t('Номер'), array('Sortable' => SORTABLE_BOTH) ),
                new TableType\Datetime('dateof', t('Дата оформления'), array('Sortable' => SORTABLE_BOTH, 'CurrentSort' => SORTABLE_DESC)),
                new TableType\Usertpl('totalcost', t('Сумма'), '%shop%/order_totalcost_cell.tpl', array('Sortable' => SORTABLE_BOTH)),
                new TableType\Usertpl('user_id', t('Покупатель'), '%shop%/order_user_cell.tpl'),             
                new Table\Type\Userfunc('address', t('Адрес'), function($address, $_this){
                    $addr = $_this->getRow()->getAddress();
                    return $addr['address'];
                }),
                new TableType\Userfunc('user_phone', t('Телефон покупателя'), function($user_phone, $_this){
                    /**
                    * @var \Users\Model\Orm\User
                    */
                    $user  = $_this->getRow()->getUser(); //Пользователь совершивший покупку
                    return $user['phone'];
                }, array('hidden' => false)),
                new Table\Type\Text('admin_comments', t('Комментарий администратора')),
                new TableType\Yesno('checked_by_accountant', t('Проверено'), array('Sortable' => SORTABLE_BOTH, 'toggleUrl' => \RS\Router\Manager::obj()->getAdminPattern('ajaxToggleCheckedByAccountant', array(':id' => '@id'), 'eridan-tools'))) 
                         
            )
        )));        
        
        

        $payments = array('' => t('Любая')) + \Shop\Model\PaymentApi::staticSelectList();
        $deliveries = array('' => t('Любая')) + \Shop\Model\DeliveryApi::staticSelectList();         
        
        
        $helper->setFilter(new Filter\Control( array(
             'Container' => new Filter\Container( array( 
                                'Lines' =>  array(
                                    new Filter\Line( array('Items' => array(
                                                            new Filter\Type\Text('order_num', '№'),
                                                            new Filter\Type\DateRange('dateof', t('Дата оформления')),
                                                            new Filter\Type\Text('totalcost', t('Сумма'), array('showtype' => true))
                                                        )
                                    )),
                                    
                                ),
                                'SecContainer' => new Filter\Seccontainer( array(
                                    'Lines' => array(
                                        new Filter\Line( array('Items' => array(
                                                new Filter\Type\User('user_id', t('Пользователь')),
                                                //Поиск по добавленной таблице с пользователями
                                                new \Shop\Model\HtmlFilterType\UserFIO('user_fio', t('ФИО пользователя'), array('searchType' => '%like%')),
                                                //Поиск по добавленной таблице с товарами заказа
                                                new \Shop\Model\HtmlFilterType\Product('PRODUCT.title', t('Наименование товара'), array('searchType' => '%like%')),
                                                new \Shop\Model\HtmlFilterType\Product('PRODUCT.barcode', t('Артикул товара'), array('searchType' => '%like%')),
                                                //Поиск по добавленной таблице с пользователями
                                                new \Shop\Model\HtmlFilterType\UserPhone('USER.phone', t('Телефон пользователя'), array('searchType' => '%like%')),
                                        ))),
                                        new Filter\Line( array('Items' => array(
                                                new Filter\Type\User('manager_user_id', t('Менеджер')),
                                                new Filter\Type\Select('payment', t('Оплата'), $payments),
                                                new Filter\Type\Select('delivery', t('Доставка'), $deliveries),
                                                new Filter\Type\Select('is_mobile_checkout', t('Заказ через моб. приложение'), array(
                                                    '' => t('Не важно'),
                                                    1 => t('Да'),
                                                    0 => t('Нет')
                                                )),
                                        ))),                                        
                                    )
                                ))
                            )),
            'Caption' => t('Поиск по заказам')
        )));
              
        return $helper;
    }
    
}
