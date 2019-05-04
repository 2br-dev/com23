<?php
namespace Eridan\Controller\Front;

use \RS\Orm\Type;

class Register extends \Users\Controller\Front\Register
{
    protected
        /**
         * Поля, которые следует ожидать из POST
         */
        $use_post_keys = array('is_company', 'company', 'company_inn', 'company_ogrn',
                               'name', 'surname', 'midname', 'phone',
                               'e_mail', 'openpass', 'openpass_confirm', 'captcha', 'data');
                               
                               
    function actionIndex()
    {
        $this->app->breadcrumbs->addBreadCrumb(t('Регистрация'));
        
        $user = new \Users\Model\Orm\User();
        $user->usePostKeys($this->use_post_keys);
        //Добавим объекту пользователя 2 виртуальных поля
        $user->getPropertyIterator()->append(array(
            'openpass_confirm' => new Type\Varchar(array(
                'name' => 'openpass_confirm',
                'maxLength' => '100',
                'description' => t('Повтор пароля'),
                'runtime' => true,
                'Attr' => array(array('size' => '20', 'type' => 'password', 'autocomplete'=>'off')),
            )),
        ));
        
        $referer = \RS\Helper\Tools::cleanOpenRedirect( urldecode($this->url->request('referer', TYPE_STRING)) );
        
        $conf_userfields = $this->getModuleConfig()->getUserFieldsManager()
            ->setErrorPrefix('userfield_')
            ->setArrayWrapper('data');

        //Включаем капчу
        $user['__captcha']->setEnable(true);
        
        if ( $this->isMyPost() )
        {
            $user['changepass'] = 1;
            
            $user->checkData();
            $password = $this->url->request('openpass', TYPE_STRING);
            $password_confirm = $this->url->request('openpass_confirm', TYPE_STRING);
            
            if (strcmp($password, $password_confirm) != 0) {
                $user->addError(t('Пароли не совпадают'), 'openpass');
            }
            
            //Сохраняем дополнительные сведения о пользователе
            if (!$conf_userfields->check($user['data'])) {
                //Переносим ошибки в объект order
                foreach($conf_userfields->getErrors() as $form=>$errortext) {
                    $user->addError($errortext, $form);
                }
            }

            if (!$user->hasError() && $user->save()) {
                //Если пользователь уже зарегистрирован
                if (\RS\Application\Auth::login($user['login'], $password)) {
                    if ($this->url->request('dialogWrap', TYPE_INTEGER)) {
                        return $this->result
                                    ->addSection('closeDialog', true)
                                    ->addSection('reloadPage', true);
                    } else {
                        if (empty($referer)) $referer = \RS\Site\Manager::getSite()->getRootUrl();
                        $this->redirect($referer);
                    }
                }
            }          
        }
                      
        $this->view->assign(array(
            'conf_userfields' => $conf_userfields,
            'user'            => $user,
            'referer'         => urlencode($referer)
        ));
        
        return $this->result->setTemplate('%users%/register.tpl');
    }
                               
    /**
    * Возвращает объект с конфигурацией модуля, к которому относится данный контроллер
    * 
    * @return RS\Orm\ConfigObject
    */
    function getModuleConfig()
    {
        return \RS\Config\Loader::byModule('users');
    }
}
