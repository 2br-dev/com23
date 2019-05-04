<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Eridan\Model;
use \Shop\Model\Orm\UserStatus,
    \RS\Module\AbstractModel;

/**
* API для работы с заказами
*/
class OrderApi extends \Shop\Model\OrderApi
{
    const
        /**
         * Идентификатор счетчика заказов
         */
        METER_ORDER = 'rs-admin-menu-allorders',

        ORDER_FILTER_ALL = 'all',
        ORDER_FILTER_SUCCESS = 'success',
        ORDER_FILTER_MOBILE = 'mobile',
        
        ORDER_SHOW_TYPE_NUM = 'num',
        ORDER_SHOW_TYPE_SUMM = 'summ',
        ORDER_SHOW_TYPE_BOTTLE = 'bottle';
        
    
    function __construct()
    {
        parent::__construct(new \Shop\Model\Orm\Order,
        array(
            'multisite' => true,
            'defaultOrder' => 'id DESC'
        ));
    }
    
    /**
    * Возвращает статистику по заказам
    * 
    * @return array
    */
    function getStatistic()
    {   
        $userStatusApi = new \Shop\Model\UserStatusApi();
        $userStatus = new \Shop\Model\Orm\UserStatus();
        $query = \RS\Orm\Request::make()
            ->select('COUNT(*) cnt')
            ->from($this->obj_instance);
        
        $queries = array();
        $queries['total_orders'] = $query;
        $queries['open_orders'] = clone $query->where("status NOT IN (#statuses)", array(
            'statuses' => implode(',', $userStatusApi::getStatusesIdByType($userStatus::STATUS_SUCCESS))
        ));
        $queries['closed_orders'] = clone $query->whereIn('status', $userStatusApi::getStatusesIdByType($userStatus::STATUS_SUCCESS));
        $queries['last_order_date'] = \RS\Orm\Request::make()
            ->select('dateof cnt')
            ->from($this->obj_instance)
            ->where(array('site_id' => \RS\Site\Manager::getSiteId()))
            ->orderby('dateof DESC')->limit(1);
        
        foreach($queries as &$one) {
            $one = $one->exec()->getOneField('cnt', 0);
        }
        return $queries;
    }
    
    /**
    * Возвращает года, за которые есть статистика
    * 
    * @param integer $lastrange максимальное количество годов в списке
    * @return array
    */
    function getOrderYears($order_filter = self::ORDER_FILTER_ALL, $lastrange = 5)
    {   
        $userStatusApi = new \Shop\Model\UserStatusApi();
        $userStatus = new \Shop\Model\Orm\UserStatus();
        $site_id = \RS\Site\Manager::getSiteId();
        $q = \RS\Orm\Request::make()
                ->select('YEAR(dateof) as year')
                ->from($this->obj_instance)
                ->where('dateof >= NOW()-INTERVAL #lastrange YEAR', array('lastrange' => $lastrange))
                ->where(array('site_id' => $site_id))
                ->groupby('YEAR(dateof)');
                
        if ($order_filter == self::ORDER_FILTER_SUCCESS) {
            $statuses_id = $userStatusApi::getStatusesIdByType($userStatus::STATUS_SUCCESS);
            $q->whereIn('status', $statuses_id);
        }
        
        return $q->exec()->fetchSelected(null, 'year');
    }
    
    /**
    * Возвращает даты заказов, сгруппированные по годам. Для видета статистики
    * 
    * @param string $order_filter фильтр заказов. Если all - то все заказы, success - только завершенные
    * @param mixed $lastrange
    * @param bool $cache - флаг кэширования, если true, то кэш будет использоваться
    * @return array
    */
    function ordersByYears($order_filter = self::ORDER_FILTER_ALL, $show_type = self::ORDER_SHOW_TYPE_NUM, $lastrange = 5, $cache = true)
    {
        $userStatusApi = new \Shop\Model\UserStatusApi();
        $userStatus = new \Shop\Model\Orm\UserStatus();
        $site_id = \RS\Site\Manager::getSiteId();
        
        if ($cache) {
            $result = \RS\Cache\Manager::obj()
                ->expire(300)
                ->request(array($this, 'ordersByYears'), $order_filter, $show_type, $lastrange, false, $site_id);
        } else {
            $q = \RS\Orm\Request::make()
                ->select('dateof, COUNT(*) cnt, SUM(totalcost) total_cost, SUM(amount_bottles) bottles')
                ->from($this->obj_instance)
                ->where('status <> 5')
                ->where('dateof >= NOW()-INTERVAL #lastrange YEAR', array('lastrange' => $lastrange))                
                ->where(array('site_id' => $site_id))
                ->groupby('YEAR(dateof), MONTH(dateof)')
                ->orderby('dateof'); 
            
            if ($order_filter == self::ORDER_FILTER_SUCCESS) {
                $statuses_id = $userStatusApi::getStatusesIdByType($userStatus::STATUS_SUCCESS);
                $q->whereIn('status', $statuses_id);
            }
            
            if ($order_filter == self::ORDER_FILTER_MOBILE) {
                $is_mobile_checkout_true = 1;                 
                $q->where('is_mobile_checkout = 1');
            }
            
            $res = $q->exec();
            $result = array();
            while($row = $res->fetchRow()) {
                if ($show_type == self::ORDER_SHOW_TYPE_NUM){
                    $show_y = $row['cnt'];
                }
                if ($show_type == self::ORDER_SHOW_TYPE_SUMM){
                    $show_y = $row['total_cost'];
                }
                if ($show_type == self::ORDER_SHOW_TYPE_BOTTLE){
                    $show_y = $row['bottles'];
                }
                $date = strtotime($row['dateof']);
                $year = date('Y', $date);
                $result[$year]['label'] = $year;
                $result[$year]['data'][date('n', $date)-1] = array(
                    'x' => mktime(4,0,0, date('n', $date), 1)*1000,
                    'y' => $show_y,
                    'pointDate' => $date*1000,
                    'total_cost' => $row['total_cost'],
                    'count' => $row['cnt'],
                    'bottles' => $row['bottles']
                );
            }
            
            //Добавляем нулевые месяцы
            foreach($result as $year=>$val) {
                $month_list = array();
                for($month=1; $month<=12; $month++) {
                    $month_list[$month-1] = isset($result[$year]['data'][$month-1])? $result[$year]['data'][$month-1] : array(
                        'x' => mktime(4,0,0, $month, 1)*1000,
                        'y' => 0,
                        'pointDate' => mktime(4,0,0, $month, 1, $year)*1000,
                        'total_cost' => 0,
                        'count' => 0,
                        'bottles' => 0
                    );
                }
                $result[$year]['data'] = $month_list;
            }

        }
        return $result;
    }
    
    /**
    * Возвращает даты заказов, сгруппированные по годам. Для видета статистики
    * 
    * @param mixed $lastrange
    * @param string $order_filter фильтр заказов. Если all - то все заказы, success - только завершенные
    * @param bool $cache - флаг кэширования, если true, то кэш будет использоваться
    * @return array
    */
    function ordersByMonth($order_filter = self::ORDER_FILTER_ALL, $show_type = self::ORDER_SHOW_TYPE_NUM, $lastrange = 1, $cache = true)
    {
        $userStatusApi = new \Shop\Model\UserStatusApi();
        $userStatus = new \Shop\Model\Orm\UserStatus();
        $site_id = \RS\Site\Manager::getSiteId();
        
        if ($cache) {
            $result = \RS\Cache\Manager::obj()
                ->expire(300)
                ->request(array($this, 'ordersByMonth'), $order_filter, $show_type, $lastrange, false, $site_id);
        } else {
            $currency = \Catalog\Model\CurrencyApi::getBaseCurrency()->stitle;
            $start_time = strtotime('-1 month');
            
            $q = \RS\Orm\Request::make()
                ->select('dateof, COUNT(*) cnt, SUM(totalcost) total_cost, SUM(amount_bottles) bottles')
                ->from($this->obj_instance)
                ->where('status <> 5')
                ->where("dateof >= '#starttime'", array('starttime' => date('Y-m-d', $start_time)))                
                ->where(array('site_id' => $site_id))
                ->groupby('DATE(dateof)')
                ->orderby('dateof');
            
            if ($order_filter == self::ORDER_FILTER_SUCCESS) {
                $statuses_id = $userStatusApi::getStatusesIdByType($userStatus::STATUS_SUCCESS);
                $q->whereIn('status', $statuses_id);
            }
            
            if ($order_filter == self::ORDER_FILTER_MOBILE) {
                $is_mobile_checkout_true = 1;                 
                $q->where('is_mobile_checkout = 1');
            }
            
            $res = $q->exec();
            $min_date = null;
            $max_date = null;
            $result = array();
            while($row = $res->fetchRow()) {
                $date = strtotime($row['dateof']);
                if ($min_date === null || $date<$min_date) {
                    $min_date = $date;
                }
                if ($max_date === null || $date>$max_date) {
                    $max_date = $date;
                }
                $ymd = date('Ymd', $date);
                if ($show_type == self::ORDER_SHOW_TYPE_NUM){
                    $show_y = $row['cnt'];
                }
                if ($show_type == self::ORDER_SHOW_TYPE_SUMM){
                    $show_y = $row['total_cost'];
                }
                if ($show_type == self::ORDER_SHOW_TYPE_BOTTLE){
                    $show_y = $row['bottles'];
                }
                $result[0][$ymd] = array(
                    'x' => $date*1000,
                    'y' => $show_y,
                    'total_cost' => $row['total_cost'],
                    'count' => $row['cnt'],
                    'bottles' => $row['bottles']
                );
            }
            
            //Заполняем пустые дни
            $i=0;
            $today = mktime(23,59,59);
            while( ($time = strtotime("+$i day",$start_time)) && $time <=$today ) {
                $ymd = date('Ymd', $time);
                if (!isset($result[0][$ymd])) {
                    $result[0][$ymd] = array(
                        'x' => $time*1000,
                        'y' => 0,
                        'total_cost' => 0,
                        'count' => 0,
                        'bottles' => 0
                    );
                }
                $i++;
            }
            ksort($result[0]);
            $result[0] = array_values($result[0]);
        }
        return $result;
    }    
    
  
}



