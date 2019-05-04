<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Partnership\Model;

class Api extends \RS\Module\AbstractModel\EntityList
{
    public static
        $current_partner;
        
    function __construct()
    {
        parent::__construct(new \Partnership\Model\Orm\Partner,
        array(
            'id_field' => 'id',
            'name_field' => 'title',
            'multiedit' => true
        ));
    }
    
    /**
    * Устанавливает id партнера, чей сайт открыт в данный момент
    * 
    * @return Orm\Partner
    */
    public static function setCurrentPartner(Orm\Partner $partner = null)
    {
        if ($partner === null) {
            $idnaconvert = new \RS\Helper\IdnaConvert();
            $_this = new self();
            $partners = $_this->getList();
            foreach($partners as $each_partner) {
                $domains = preg_split('/[\n,]/', $each_partner['domains'], -1, PREG_SPLIT_NO_EMPTY);
                $current_domain = strtolower($_SERVER['HTTP_HOST']);
                foreach($domains as $domain) {
                    if ( strtolower($domain) == $current_domain ||
                        strtolower($domain) == $idnaconvert->decode($current_domain)) {
                        $partner = $each_partner;
                        break;
                    }
                }
            }
        }

        return self::$current_partner = $partner;
    }
    
    /**
    * Возвращает текущего партнера или null
    * 
    * @return integer | null
    */
    public static function getCurrentPartner()
    {
        return self::$current_partner ? self::$current_partner : null;
    }
    
    /**
    * Возвращает true, если пользователь является партнером
    * 
    * @param integer $user_id
    * @return bool
    */
    public static function isUserPartner($user_id)
    {
        if ($partner = self::getCurrentPartner()) {
            return $partner['user_id'] === \RS\Application\Auth::getCurrentUser()->id;
        }
        return false;
    }
    
    /**
    * Возвращает разобранные данные партнёра для полей From или Reply уведомлений
    * 
    * @param string $property - свойство, которое нужно разобрать
    * @param $return_email - Если true, то вернет email, если false - то вернет надпись, если null - то вернет массив
    * @return mixed
    */
    public function getPartnerNoticeParsed($property, $return_email = null)
    {
        $result = array( 'line' => $property );
        if (preg_match('/^(.*?)<(.*)>$/', html_entity_decode($result['line']), $match)) {
            $result['string'] = $match[1];
            $result['email'] = $match[2];
        } else {
            $result['string'] = '';
            $result['email'] = $result['line'];
        }
        
        if ($return_email === null) return $result;
        return $return_email ? $result['email'] : $result['string']; 
    }
    
    /**
    * Аналог getSelectList, только для статичского вызова
    * 
    * @param array $first - значения, которые нужно добавить в начало списка
    * @return array
    */
    static function staticSelectList($first = array())
    {
        if ($first === true) { // для совместимости
            $first = array(0 => t('- Не выбрано -'));
        }
        return parent::staticSelectList($first);
    }
}
