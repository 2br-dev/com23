<?php
namespace SocialAuth\Controller\Block;
use \RS\Orm\Type;

/**
* Блок авторизации через соц. сети
*/
class AuthBlock extends \RS\Controller\StandartBlock
{
    protected static
        $controller_title = 'Блок авторизации через соц. сети',        //Краткое название контроллера
        $controller_description = 'Отображает ссылки для авторизации через соц. сети';  //Описание контроллера        
        
    protected
        $need_providers = array( //Провайдеры для перебора
            'vkontakte', 'odnoklassniki', 'mailru', 'facebook', 'twitter', 'google', 'yandex', 'livejournal', 'openid', 
            'lastfm', 'linkedin', 'liveid', 'soundcloud', 'steam', 'flickr', 'uid', 'youtube', 'webmoney', 'foursquare', 
            'tumblr', 'googleplus', 'dudu', 'vimeo', 'instagram', 'wargaming'
        ),
        $default_params = array(
            'vkontakte' => '1',
            'odnoklassniki' => '1',
            'mailru' => '1',
            'facebook' => '1',
            'twitter' => '0',
            'google' => '0',
            'yandex' => '0',
            'livejournal' => '0',
            'openid' => '0',
            'lastfm' => '0',
            'linkedin' => '0',
            'liveid' => '0',
            'soundcloud' => '0',
            'steam' => '0',
            'flickr' => '0',
            'uid' => '0',
            'youtube' => '0',
            'webmoney' => '0',
            'foursquare' => '0',
            'tumblr' => '0',
            'googleplus' => '0',
            'dudu' => '0',
            'vimeo' => '0',
            'instagram' => '0',
            'wargaming' => '0',
            'line_size' => '4',
            'show_type' => 'panel',
            'no_mobile_buttons' => 0,
            'indexTemplate' => 'blocks/authblock/authblock.tpl', //Должен быть задан у наследника
        );  
        
    /**
    * Возвращает ORM объект, содержащий настриваемые параметры или false в случае, 
    * если контроллер не поддерживает настраиваемые параметры
    * @return \RS\Orm\ControllerParamObject | false
    */
    function getParamObject()
    {
        
        return parent::getParamObject()->appendProperty(array(
            'line_size' => new Type\Integer(array(
                'description' => t('Количество ссылок в линии не спрятанных'),
                'default' => 4,
            )),
            'show_type' => new Type\Varchar(array(
                'description' => t('Вид'),
                'default' => 'panel',
                'listFromArray' => array(array(
                    'small' => 'Малые значки',
                    'panel' => 'Большие значки',
                    'window' => 'Линейка',
                ))
            )),
            'no_mobile_buttons' => new Type\Integer(array(
                'description' => t('Отключить мобильный вид?'),
                'CheckboxView' => array(1,0)
            )),
            'vkontakte' => new Type\Integer(array(
                'description' => t('Показывать ссылку Вконтакте?'),
                'CheckboxView' => array(1,0)
            )),
            'odnoklassniki' => new Type\Integer(array(
                'description' => t('Показывать ссылку Одноклассники?'),
                'CheckboxView' => array(1,0)
            )),
            'mailru' => new Type\Integer(array(
                'description' => t('Показывать ссылку Mail.ru?'),
                'CheckboxView' => array(1,0)
            )),
            'facebook' => new Type\Integer(array(
                'description' => t('Показывать ссылку Facebook?'),
                'CheckboxView' => array(1,0)
            )),
            'twitter' => new Type\Integer(array(
                'description' => t('Показывать ссылку Twitter?'),
                'CheckboxView' => array(1,0)
            )),
            'google' => new Type\Integer(array(
                'description' => t('Показывать ссылку Google?'),
                'CheckboxView' => array(1,0)
            )),
            'yandex' => new Type\Integer(array(
                'description' => t('Показывать ссылку Yandex?'),
                'CheckboxView' => array(1,0)
            )),
            'livejournal' => new Type\Integer(array(
                'description' => t('Показывать ссылку Livejournal?'),
                'CheckboxView' => array(1,0)
            )),
            'openid' => new Type\Integer(array(
                'description' => t('Показывать ссылку Open ID?'),
                'CheckboxView' => array(1,0)
            )),
            'lastfm' => new Type\Integer(array(
                'description' => t('Показывать ссылку Last FM?'),
                'CheckboxView' => array(1,0)
            )),
            'linkedin' => new Type\Integer(array(
                'description' => t('Показывать ссылку LinkedIn?'),
                'CheckboxView' => array(1,0)
            )),
            'liveid' => new Type\Integer(array(
                'description' => t('Показывать ссылку Liveid?'),
                'CheckboxView' => array(1,0)
            )),
            'soundcloud' => new Type\Integer(array(
                'description' => t('Показывать ссылку SoundCloud?'),
                'CheckboxView' => array(1,0)
            )),
            'steam' => new Type\Integer(array(
                'description' => t('Показывать ссылку Steam?'),
                'CheckboxView' => array(1,0)
            )),
            'flickr' => new Type\Integer(array(
                'description' => t('Показывать ссылку Flickr?'),
                'CheckboxView' => array(1,0)
            )),
            'uid' => new Type\Integer(array(
                'description' => t('Показывать ссылку Uid?'),
                'CheckboxView' => array(1,0)
            )),
            'youtube' => new Type\Integer(array(
                'description' => t('Показывать ссылку Youtube?'),
                'CheckboxView' => array(1,0)
            )),
            'webmoney' => new Type\Integer(array(
                'description' => t('Показывать ссылку Webmoney?'),
                'CheckboxView' => array(1,0)
            )),
            'foursquare' => new Type\Integer(array(
                'description' => t('Показывать ссылку Foursquare?'),
                'CheckboxView' => array(1,0)
            )),
            'tumblr' => new Type\Integer(array(
                'description' => t('Показывать ссылку Tumblr?'),
                'CheckboxView' => array(1,0)
            )),
            'googleplus' => new Type\Integer(array(
                'description' => t('Показывать ссылку Google Plus?'),
                'CheckboxView' => array(1,0)
            )),
            'dudu' => new Type\Integer(array(
                'description' => t('Показывать ссылку DuDu?'),
                'CheckboxView' => array(1,0)
            )),
            'vimeo' => new Type\Integer(array(
                'description' => t('Показывать ссылку Vimeo?'),
                'CheckboxView' => array(1,0)
            )),
            'instagram' => new Type\Integer(array(
                'description' => t('Показывать ссылку Instagram?'),
                'CheckboxView' => array(1,0)
            )),
            'wargaming' => new Type\Integer(array(
                'description' => t('Показывать ссылку Wargaming?'),
                'CheckboxView' => array(1,0)
            )),
            
        ));
    }     
    
    
    /**
    * Вывод блока
    * 
    */
    function actionIndex()
    {   
        //Получим все параметры, которые нужны
        $providers = array();
        foreach ($this->need_providers as $need_provider) {
            if ($this->getParam($need_provider) ) {
               $providers[] = $need_provider;
            }
        }
        //Если есть провайдеры
        if (!empty($providers)){ 
            $api            = new \SocialAuth\Model\Api();
            $providers_code = $api->getProvidersCode($providers, $this->getParam('line_size')); //Код с провайдерами
            
            $redirect_uri = urlencode($this->router->getUrl('socialauth-front-auth', array('redirect' => $this->url->getSelfUrl()), true));
            if (mb_stripos($this->url->getSelfUrl(), "auth") !== false){  //Если мы получили регистрацию со страницы авторизации по перенаправим на главную
                $redirect_uri = urlencode($this->router->getUrl('socialauth-front-auth', array('redirect' => "/"), true));
            } 
            $error        = urldecode($this->request('error', TYPE_STRING, false));
            
            $this->view->assign(array(
                'providers' => $providers, 
                'providers_code' => $providers_code, 
                'redirect_uri' => $redirect_uri, 
                'error' => $error, 
            ));
            return $this->result->setTemplate( $this->getParam('indexTemplate') );
        } 
    }
}
