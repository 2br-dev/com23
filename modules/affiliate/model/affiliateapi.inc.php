<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Model;

/**
* Класс для организации выборок ORM объекта.
* В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
*/
class AffiliateApi extends \RS\Module\AbstractModel\TreeCookieList
{
    const
        SESSION_GEOIP_AFFILIATE_ID = 'affiliate_geoip',
        COOKIE_AFFILIATE_ID = 'affiliate',
        COOKIE_ALREADY_SELECT = 'affiliate_already_select';
    
    protected static
        $need_recheck = false,
        $current_affiliate;
    
    protected
        $sub_tools;
        
    function __construct()
    {
        parent::__construct(new Orm\Affiliate, array(
            'parentField' => 'parent_id',
            'nameField' => 'title',
            'aliasField' => 'alias',
            'sortField' => 'sortn',
            'defaultOrder' => 'sortn',
            'multisite' => true
        ));
    }
    
    /**
    * Возвращает данные для отображения в административной панели
    * 
    * @return array
    */
    function getTreeData()
    {
        if ($this->sub_tools) {
            $this->getAllCategory();
            //Исключаем пункт "Добавить дочерний элемент" из элементов не корневого уровня
            foreach($this->cat as $item) {
                if ($item['parent_id'] > 0) {
                    $item['treeTools'] = $this->sub_tools;
                }
            }
        }
        
        $tree = $this->getTreeList(0);
        return $tree;
    }
    
    /**
    * Устанавливает состав инструментов для отображения в админ. панели 
    * для не корневых филиалов
    * 
    * @param \RS\Html\Table\Type\Actions $tools
    * @return void
    */
    function setSubTools(\RS\Html\Table\Type\Actions $tools)
    {
        $this->sub_tools = $tools;
    }
    
    /**
    * Аналог getSelectList, только для статичского вызова
    * 
    * @param int $parent_id = id корневого элемента дерева
    * @param array $first = значения, которые нужно добавить в начало списка
    * @return array
    */
    static function staticSelectList($parent_id = 0, $first = array())
    {
        if (gettype($parent_id) == 'string') { // для совместимости
            $first = array(0 => $parent_id);
            $parent_id = 0;
        }
        return parent::staticSelectList($parent_id, (array) $first);
    }
    
    /**
    * Возвращает список элементов первого уровня + корневой элемент
    * 
    * @return array
    */
    static function staticRootList()
    {
        $_this = new self();
        $_this->setFilter('parent_id', 0);
        $root = $_this->getListAsResource()->fetchSelected('id', 'title');
        
        return array(0 => t('Верхний уровень')) + $root;
    }        
    
    /**
    * Возвращает объект текущего филиала
    * 
    * @return \Affiliate\Model\Orm\Affiliate
    */
    public static function getCurrentAffiliate()
    {
        if (!isset(self::$current_affiliate)) {
            $config = \RS\Config\Loader::byModule('affiliate');
            $request = \RS\Http\Request::commonInstance();
            $cookie_affiliate_id = $request->cookie(self::COOKIE_AFFILIATE_ID, TYPE_INTEGER);
            
            if ($cookie_affiliate_id) { //Читаем из cookie
                self::$current_affiliate = new Orm\Affiliate($cookie_affiliate_id);
            } 
            
            if (empty(self::$current_affiliate['id'])) {
                if ($config->use_geo_ip) { //Определяем по GEO IP
                    $affiliate = self::getAffiliateByIp($request->server('REMOTE_ADDR')); //'31.181.15.239'
                }
                
                if (empty($affiliate)) { //Используем филиал по-умолчанию
                    $api = new self();
                    $affiliate = $api->getCleanQueryObject()
                        ->where(array(
                            'is_default' => 1
                        ))->object() ?: new Orm\Affiliate();
                }
                self::$current_affiliate = $affiliate;
            }
        }
        return self::$current_affiliate;
    }
    
    /**
    * Устанавливает текущий филиал
    * 
    * @param Orm\Affiliate $affiliate_id - id филиала
    * @param boolean $write_to_cookie - записывать в куки? true - да
    * @return void
    */
    public static function setCurrentAffiliate(Orm\Affiliate $affiliate, $write_to_cookie = false)
    {
        self::$current_affiliate = $affiliate;
        
        if ($write_to_cookie){
            $request = \RS\Http\Request::commonInstance();
            $app = \RS\Application\Application::getInstance();
            $app->headers->addCookie(self::COOKIE_AFFILIATE_ID, $affiliate['id'], time() + 60*60*24*365*5, '/');
        }
        return true;
    }
    
    /**
    * Возвращает true, если необходимо подтвердить у пользователя его город
    * 
    * @return bool
    */
    public static function needRecheck()
    {
        $config = \RS\Config\Loader::byModule('affiliate');
        $http = \RS\Http\Request::commonInstance();
        
        //Филиал выбирался непосредственно пользователем ранее
        $cookie_affiliate_id = $http->cookie(self::COOKIE_AFFILIATE_ID, TYPE_INTEGER);
        //Диалог подтверждения филиала был показан ранее
        $already_city_select = $http->cookie(self::COOKIE_ALREADY_SELECT, TYPE_INTEGER);
        
        return $config->confirm_city_select && !$cookie_affiliate_id && !$already_city_select;
    }
    
    /**
    * Возвращает город по IP адресу
    * 
    * @param string $ip - IP адрес
    * @param bool $use_session_cache - кэшировать результат в сессии
    * @return \Affiliate\Model\Orm\Affiliate | false
    */
    public static function getAffiliateByIp($ip, $use_session_cache = true)
    {        
        if (!isset($_SESSION[self::SESSION_GEOIP_AFFILIATE_ID])) 
        {
            //Определяем город по названию            
            $geoIp = new \Main\Model\GeoIpApi();
            $city = $geoIp->getCityByIp($ip);
            
            if ($city !== false) {
                $affiliate_id = \RS\Orm\Request::make()
                    ->select('id')
                    ->from(new Orm\Affiliate)
                    ->where(array(
                        'skip_geolocation' => 0,
                        'clickable' => 1,
                        'public' => 1,
                        'title' => $city
                    ))->exec()->getOneField('id');
            } else {
                $affiliate_id = null;
            }
            
            if ($city === false || !$affiliate_id) { 
                //Определяем ближайший город по координатам
                if ($coord = $geoIp->getCoordByIp($ip)) {                    
                    $affiliate_id = self::getNearAffiliate($coord['lat'], $coord['lng']);
                }
            }
            $_SESSION[self::SESSION_GEOIP_AFFILIATE_ID] = $affiliate_id;
        }
        
        if ($_SESSION[self::SESSION_GEOIP_AFFILIATE_ID]) {
            return Orm\Affiliate::loadSingle( $_SESSION[self::SESSION_GEOIP_AFFILIATE_ID] );
        }
        return false;
    }
    
    /**
    * Возвращает ближайший для указанных коорднат Филиал
    * 
    * @param float $lat - широта
    * @param float $lng - долгота
    * @return \Affiliate\Model\Orm\Affiliate | false
    */
    public static function getNearAffiliate($lat, $lng)
    {
        $config = \RS\Config\Loader::byModule(__CLASS__);
        $delta = $config->coord_max_distance;
        $lat = (float)$lat;
        $lng = (float)$lng;
        
        //Загружаем все филиалы в допустимом квадрате
        $affiliates = \RS\Orm\Request::make()
            ->select('coord_lng, coord_lat, id')
            ->from(new Orm\Affiliate())
            ->where("'#lng_from' <= coord_lng AND coord_lng <= '#lng_to'", array(
                'lng_from' => $lng - $delta,
                'lng_to' => $lng + $delta
            ))
            ->where("'#lat_from' <= coord_lat AND coord_lat <= '#lat_to'", array(
                'lat_from' => $lat - $delta,
                'lat_to' => $lat + $delta
            ))->exec()->fetchAll();
            
        if (!$affiliates) return false;
        
        //Находим ближайший по расстоянию
        $min_distance = null;
        $affiliate_id = false;
        foreach($affiliates as $row) {
            $a = pow(abs($row['coord_lat'] - $lat), 2);
            $b = pow(abs($row['coord_lng'] - $lng), 2);
            $distance = sqrt($a + $b);
            if ($min_distance === null || $min_distance > $distance) {
                $min_distance = $distance;
                $affiliate_id = $row['id'];
            }
        }
        return $affiliate_id;
    }    
}