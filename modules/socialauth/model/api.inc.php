<?php
namespace SocialAuth\Model;

use \RS\Application\Auth as AuthApp;

/**
* Класс API функций для работы с авторизацией через соц. сети
*/
class Api
{
    protected
        $errors = array(),
        $config;
    
    /**
    * Конструктор класса
    * 
    */
    function __construct()
    {
        $this->config = \RS\Config\Loader::byModule($this);
    }
    
    /**
    * Получает код провайдеров для авторизации для блока
    * 
    * @param array $providers - массив провайдеров
    * @param integer $line_size - количество отображаемые социальных ссылок
    */
    function getProvidersCode($providers = array(), $line_size = 1)
    {
        $show_providers   = array_slice($providers, 0, $line_size); //Провайдеры для показа
        $hidden_providers = array_slice($providers, $line_size-1, count($providers)-$line_size); //Провайдеры скрытые
        
        $code = "providers=".implode(",", $show_providers);
        
        if (!empty($hidden_providers)){
           $code .= ";hidden=".implode(",", $hidden_providers); 
        }
        
        return $code;
    }
    
    /**
    * Получает пользователя по его E-mail
    * 
    * @param string $email - E-mail пользователя
    * @return \Users\Model\Orm\User
    */
    function getUserByEmail($email)
    {
        return \RS\Orm\Request::make()
                ->from(new \Users\Model\Orm\User())
                ->where(array(
                    'e_mail' => $email
                ))
                ->object();
    }
    
    /**
    * Авторизовывает пользователя
    * 
    * @param \Users\Model\Orm\User $user - объект пользователя
    */
    function authtorizeUser($user)
    {
        if (!self::isUserBanned($user)) { //Если не заблокирован, авторизуем
            AuthApp::setCurrentUser($user);
            \RS\Application\Application::getInstance()->headers->addCookie(AuthApp::COOKIE_AUTH_TICKET, AuthApp::getAuthTicket($user), time()+AuthApp::COOKIE_AUTH_TICKET_LIFETIME, '/');
        }else{
            $this->api->addError(t('Пользователь заблокирован!'));
        }
    }
    
    /**
    * Добавляет ошибку
    * 
    * @param string $text - текст ошибки
    */
    function addError($text)
    {
        $this->errors[] = $text;
    }
    
    /**
    * Возвращает массив с ошибками
    * 
    * @return array
    */
    function getErrors()
    {
        return $this->errors;
    }
    
    /**
    * Проверяет есть ли ошибки
    * 
    * @return boolean
    */
    function hasErrors()
    {
        return count($this->errors)>0 ? true : false;
    }
    
    /**
    * Получает ошибки в виде строки
    * 
    * @param string $glue - склейка
    */
    function getErrorsStr($glue="<br/>")
    {
        return implode($glue, $this->errors);
    }

    /**
    * Возвращает true, если пользователь заблокирован
    * Деавторизует пользователя, если он заблокирован
    * 
    * @param \Users\Model\Orm\User $user
    * @return boolean
    */
    private static function isUserBanned(\Users\Model\Orm\User $user)
    {
        if (!isset($user['ban_expire'])){ //Если нет вообще свойств связанных с банном
            return false;
        }
        
        $is_banned = $user['ban_expire'] !== null && strtotime($user['ban_expire']) > time();
        $session_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if ($is_banned && $session_user_id == $user['id']) {
            unset($_SESSION['user_id']);
        }
        return $is_banned;     
    }

}

