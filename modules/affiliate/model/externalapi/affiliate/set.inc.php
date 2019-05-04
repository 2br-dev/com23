<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Model\ExternalApi\Affiliate;

/**
* Устанавливает текущий филлиал, который потом будет использоваться в Вашем приложении
*/
class Set extends \ExternalApi\Model\AbstractMethods\AbstractMethod
{
    const
        RIGHT_LOAD = 1;
        
    protected
        $token_require = false; //Токен не обязателен
    
    /**
    * Возвращает комментарии к кодам прав доступа
    * 
    * @return [
    *     КОД => КОММЕНТАРИЙ,
    *     КОД => КОММЕНТАРИЙ,
    *     ...
    * ]
    */
    public function getRightTitles()
    {
        return array(
            self::RIGHT_LOAD => t('Установка текущего филлиала')
        );
    }
    

    /**
    * Устанавливает текущий филлиал, который потом будет использоваться в Вашем приложении
    * 
    * @example GET /api/methods/affiliate.set?affiliate_id=1
    * 
    * Ответ:
    * <pre>
    * {
    *  "response": {
    *     "success" : true
    *  }  
    *}
    * </pre>
    * 
    * @return array Возвращает true, если удалось установить текщуй филлиал
    */
    protected function process($token = null, $affiliate_id)
    {
        $api = new \Affiliate\Model\AffiliateApi();
        $api->setFilter('public', 1);
        $affiliate = $api->getById($affiliate_id, 'id');             
        $response['response']['success'] = ($affiliate['id']) ? \Affiliate\Model\AffiliateApi::setCurrentAffiliate($affiliate, true) : false;
                  
        return $response;
    }
}