<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Partnership\Model\Orm;
use \RS\Orm\Type;

/**
* ORM объект - партнер
*/
class Partner extends \RS\Orm\OrmObject
{
    protected static
        $table = 'partnership';
    
    protected
        $before_partner;
    
    function _init()
    {
        parent::_init()->append(array(
            'site_id' => new Type\CurrentSite(),
            'title' => new Type\Varchar(array(
                'description' => t('Название партнера'),
                'checker' => array('chkEmpty', t('Укажите наименование партнера')),
            )),
            'is_reg_user' => new Type\Integer(array(
                'description' => t('Регистрировать нового пользователя?'),
                'visible' => false,
                'runtime' => true
            )),
            'user_id' => new Type\User(array(
                'description' => t('Пользователь'),
                'template' => '%partnership%/form/partner/user.tpl',
                'checker' => array(function($object, $value, $error) {
                    return ($object['is_reg_user'] == 0 && empty($value)) ? $error : true;
                    
                }, t('Партнер должен быть привязан к пользователю системы')),
                'attr' => array(array(
                    'placeholder' => t('Логин или Фамилия')
                ))
            )),
                'reg_user_name' => new Type\Varchar(array(
                    'description' => t('Имя'),
                    'visible' => false,
                    'runtime' => true
                )),
                'reg_user_surname' => new Type\Varchar(array(
                    'description' => t('Фамилия'),
                    'visible' => false,
                    'runtime' => true
                )),
                'reg_user_phone' => new Type\Varchar(array(
                    'description' => t('Телефон'),
                    'visible' => false,
                    'runtime' => true
                )),
                'reg_user_e_mail' => new Type\Varchar(array(
                    'description' => t('E-mail'),
                    'visible' => false,
                    'runtime' => true
                )),
                'reg_user_openpass' => new Type\Varchar(array(
                    'description' => t('Пароль'),
                    'visible' => false,
                    'runtime' => true
                )),
            'logo' => new Type\Image(array(
                'description' => t('Логотип')
            )),
            'slogan' => new Type\Varchar(array(
               'description' => t('Слоган')
            )),
            'contacts' => new Type\Richtext(array(
                'description' => t('Контактная информация')
            )),
            'price_base_id' => new Type\Integer(array(
                'description' => t('Базовая цена для расчета'),
                'list' => array(array('\Catalog\Model\CostApi','getEditList'))
            )),
            'price_inc_value' => new Type\Integer(array(
                'description' => t('Увеличения стоимости, %')
            )),
            'cost_type_id' => new Type\Integer(array(
                'description' => t('Привязанная к партнеру цена'),
                'visible' => false
            )),
            'domains' => new Type\Text(array(
               'description' => t('Доменные имена (через запятую или с новой строки)')
            )),
            'redirect_to_https' => new Type\Integer(array(
                'description' => t('Перенаправлять на https'),
                'hint' => t('При изменении данной опции, необходимо очистить кэш браузера'),
                'allowEmpty' => false,
                'checkboxView' => array(1,0)
            )),
            'theme' => new Type\Varchar(array(
                'description' => t('Тема оформления партнера'),
                'checker' => array('chkEmpty', t('Укажите тему оформления')),
                'attr' => array(array(
                    'readonly' => 'readonly'
                )),
                'template' => '%partnership%/form/partner/theme.tpl'
            )),
            'products' => new Type\ArrayList(array(
                'description' => t('Товары, доступные на сайте партнера'),
                'template' => '%partnership%/form/partner/products.tpl'
            )),
            '_products' => new Type\Text(array(
                'visible' => false
            )),
            'is_closed' => new Type\Integer(array(
                'description' => t('Закрыть доступ к сайту'),
                'hint' => t('Используйте данный флаг, чтобы закрыть доступ к сайту на время его разработки. Администраторы будут иметь доступ как на сайт, так и в административную панель.'),
                'template' => '%partnership%/form/partner/is_closed.tpl',
                'checkboxView' => array(1,0)
            )),
            'close_message' => new Type\Varchar(array(
                'description' => t('Причина закрытия сайта'),
                'hint' => t('Будет отображена пользователям'),
                'attr' => array(array(
                    'placeholder' => t('Причина закрытия сайта')
                )),
                'visible' => false
            )),
            t('Уведомления'),
                'notice_from' => new Type\Varchar(array(
                    'maxLength' => 255,
                    'description' => t("Будет указано в письме в поле  'От'"),
                    'hint' => t('Например: "Магазин ReadyScript&lt;robot@ваш-магазин.ru&gt;" или просто "robot@ваш-магазин.ru"')
                    
                )),
                'notice_reply' => new Type\Varchar(array(
                    'maxLength' => 255,
                    'description' => t("Куда присылать ответные письма? (поле Reply)"),
                    'hint' => t('Например: "Магазин ReadyScript&lt;support@ваш-магазин.ru&gt;" или просто "support@ваш-магазин.ru"')
                )),
        ));
    }
    
    function beforeWrite($flag)
    {
        if ($this['is_reg_user']) {
            //Регистрируем пользователя
            $user = new \Users\Model\Orm\User();
            $user->getFromArray($this->getValues(), 'reg_user_');
            if (!$user->validate()) {
                foreach($user->getErrorsByForm() as $key => $errors) {
                    $this->addErrors($errors, 'reg_user_'.$key);
                }
                return false;
            }
            if ($user->insert()) {
                $this['user_id'] = $user['id'];
            } else {
                throw new \RS\Exception(t('Пользователь не был создан'));
            }
        }
                
        if ($flag == self::INSERT_FLAG) {
            //Создаем тип цен партнера
            $cost_type = new \Catalog\Model\Orm\Typecost();
            $cost_type['title'] = t('Цена партнера %0', $this['title']);
            $cost_type['type'] = 'auto';
            $cost_type['val_znak'] = '+';
            $cost_type['val'] = $this['price_inc_value'];
            $cost_type['val_type'] = '%';
            $cost_type['depend'] = $this['price_base_id'];
            $cost_type['round'] = \Catalog\Model\Orm\Typecost::ROUND_CEIL_INT;
            $cost_type->insert();
            $this['cost_type_id'] = $cost_type['id'];
        }
        
        if ($flag == self::UPDATE_FLAG) {
            $this->before_partner = new self($this['id']);
            
        }
        $this['_products'] = serialize($this['products']);        
    }
    
    function afterWrite($flag)
    {
        if ($flag == self::UPDATE_FLAG) {
            //Обновляем тип цен партнера
            $cost_type = new \Catalog\Model\Orm\Typecost($this['cost_type_id']);
            $cost_type['val'] = $this['price_inc_value'];
            $cost_type['depend'] = $this['price_base_id'];
            $cost_type->update();
        }        
        
        if ($flag == self::INSERT_FLAG || $this->before_partner->getTheme() != $this->getTheme()) 
        {
            //создаем контекст для темы и устанавливаем её
            $theme = new \RS\Theme\Item($this->getTheme());
            $theme->setThisTheme(array(), null, null, false);
        }
    }
    
    /**
    * Возвращает список доменов, которые относятся к текущему сайту
    * 
    * @return array
    */
    function getDomainsList()
    {
        return preg_split('/[,\n\s]/', $this['domains'], null, PREG_SPLIT_NO_EMPTY);
    }
    
    /**
    * Возвращает главное доменное имя сайта
    * 
    * @return string
    */
    function getMainDomain()
    {
        $domains = $this->getDomainsList();
        return trim($domains[0]);
    }
    
    /**
    * Возвращает ссылку на корень партнёрского сайта
    * 
    * @param bool $absolute - Если true, то будет возвращена абсолютная ссылка, иначе относительная
    * @param bool $add_root_folder - Если true, то приписывает в конце папку, в которой находится скрипт
    * @param bool $force_https - Если true, то всегда возвращается с https, иначе в зависимости от текущего протокола
    * 
    * @return string
    */
    function getRootUrl($absolute = false, $add_root_folder = true, $force_https = false)
    {
        $domain = $this->getMainDomain();
        
        $folder = ($add_root_folder) ? \Setup::$FOLDER.'/' : '/';
        
        if ($force_https) {
            $protocol = 'https';
        } else {
            $protocol = \RS\Http\Request::commonInstance()->getProtocol();
        }
        
        return $absolute ? $protocol.'://'.$domain.$folder : $folder;
    }
    
    /**
    * Формирует абсолютный URL из относительного применительно к текущему сайту
    * 
    * @param string $relative_uri
    * @return string
    */
    function getAbsoluteUrl($relative_uri)
    {
        return $this->getRootUrl(true, false).ltrim($relative_uri, '/');
    }
    
    function afterObjectLoad()
    {
        $this['products'] = @unserialize($this['_products']);
    }
    
    function getProductsDialog()
    {
        return new \Catalog\Model\ProductDialog('products', false, $this['products'], true);
    }
    
    function delete()
    {
        if ($this['cost_type_id']<1) {
            $this->load($this['id']);
        }
        //Удаляем тип цены партнера
        \RS\Orm\Request::make()
            ->delete()
            ->from(new \Catalog\Model\Orm\Typecost)
            ->where(array('id' => $this['cost_type_id']))
            ->exec();
        
        //Удаляем идентификатор схемы блоков
        try {
            $theme = new \RS\Theme\Item($this->getTheme());
            $theme->removeContext();
        } catch(\RS\Theme\Exception $e) {}
            
        return parent::delete();
    }
    
    /**
    * Возвращает контекст темы для данного партнера
    * 
    * @return string
    */
    function getThemeContext()
    {
        return 'partner-'.$this['id'];
    }
    
    /**
    * Возвращает полный идентификатор темы
    * 
    * @return string
    */
    function getTheme()
    {
        return $this['theme'].';'.$this->getThemeContext();
    }

    /**
     * Возращает объект пользователя
     * @return \Users\Model\Orm\User
     */
    function getUser()
    {
        return new \Users\Model\Orm\User($this['user_id']);
    }
    
    /**
    * Возвращает список id категорий(вместе с их родителями), которые разрешены для показа на данном партнерском сайте
    * 
    * @return array
    */
    function getAllowFolderList($cache = true)
    {
        if ($cache) {
            return \RS\Cache\Manager::obj()
                        ->watchTables($this)
                        ->request(array($this, 'getAllowFolderList'), false, $this['id']);
            
        } else {
            $groups = isset($this['products']['group']) ? (array)$this['products']['group'] : array();
            if (!$groups) $groups = array(0);
            $ids = array_combine($groups, $groups);
            //Находим всех детей у выбранных категорий
            $find_childs = $groups;
            $childs = array();
            while(count($find_childs)) {
                $find_childs = \RS\Orm\Request::make()
                    ->select('id')
                    ->from(new \Catalog\Model\Orm\Dir())
                    ->whereIn('parent', $find_childs)
                    ->exec()->fetchSelected('id', 'id');
                $childs += $find_childs;
            }
            
            $find_ids = $groups;
            //Находим все родительские элементы
            while(count($find_ids)) {
                $parents = \RS\Orm\Request::make()
                    ->select('parent')
                    ->from(new \Catalog\Model\Orm\Dir())
                    ->whereIn('id', $find_ids)
                    ->exec()
                    ->fetchSelected('parent', 'parent');
                $ids += $parents;
                $find_ids = array();
                foreach($parents as $item) {
                    if ($item>0) {
                        $find_ids[] = $item;
                    }
                }
            };
            unset($ids[0]);
            $ids += $childs;
            
            return $ids;
        }
    }
    
    /**
    * Возвращает клонированный объект доставки
    * @return Delivery
    */
    function cloneSelf()
    {
        /**
        * @var \Shop\Model\Orm\Delivery
        */
        $clone = parent::cloneSelf();

        //Клонируем фото, если нужно
        if ($clone['logo']){
           /**
           * @var \RS\Orm\Type\Image
           */
           $clone['logo'] = $clone->__logo->addFromUrl($clone->__logo->getFullPath());
        }
        unset($clone['domains']);
        return $clone;
    }
}
