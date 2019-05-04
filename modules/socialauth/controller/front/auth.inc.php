<?php
namespace SocialAuth\Controller\Front;

use \RS\Application\Auth as AuthApp;

/**
* Контроллер отвечает за авторизацию через соц. сети на сайте
*/
class Auth extends \RS\Controller\Front
{    
    protected 
        $api;        
        
    function init()
    {
        $this->api = new \SocialAuth\Model\Api(); 
    }
    
    function actionIndex()
    {
        $redirect = urldecode($this->request('redirect', TYPE_STRING, false));
        $token = $this->request('token', TYPE_STRING);
        
        
        if (!empty($token)){
            //Запросим данные по выданному токену
            $result   = file_get_contents('http://ulogin.ru/token.php?token=' . $token . '&host=' . $_SERVER['HTTP_HOST']);
            $data     = @json_decode($result, true);
            
            if (isset($data['error'])) {
                $this->api->addError($data['error']);
            }else{ //Если ошибок нет, то разлогинем пользователя
                \RS\Application\Auth::logout();
            }
            
            $identity = $data['identity']; //уникальная строка определяющая конкретного пользователя соц. сети
            $email    = $data['email'];
            
            //Проверим есть ли E-mail и пробуем авторизоватся, или зарегистрироваться
            if (!empty($email)){
                /**
                * @var \Users\Model\Orm\User
                */
                $user = $this->api->getUserByEmail($email);
                if ($user){ //Если пользователь найден
                   $this->api->authtorizeUser($user); //Авторизуем
                }else{ //Если пользователь не найден, зарегистрируем
                   $user = new \Users\Model\Orm\User();
                   $user['name']     = $data['first_name'];
                   $user['surname']  = $data['last_name'];
                   $user['e_mail']   = $email;
                   $user['login']    = $email;
                   
                   $user['openpass'] = \RS\Helper\Tools::generatePassword(6);
                   if (isset($data['phone']) && !empty($data['phone'])) {
                      $user['phone'] = $data['phone']; 
                   }
                   if ($user->insert()){
                       $this->api->authtorizeUser($user);
                   }
                }
            }else{
                $this->api->addError(t('No E-mail has getted'));
                //Отправим уведомление почему не авторизовались
                $error_text = t('E-mail для авторизации не получен');
                if (strpos($redirect, "?") === false) { 
                   $redirect .= "?error=". urlencode($error_text); 
                }else{
                   $redirect .= "&error=". urlencode($error_text);  
                }
            }
            $this->redirect($redirect); //Перенесёмся обратно
        }
        echo "Error: No token getted! Redirect After 7 seconds
        <script type='text/javascript'>
           setTimeout(function (){
              document.location = '".$redirect."';  
           }, 7000);
        </script>
        ";
        exit();
    }
}
