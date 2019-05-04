<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Tags\Config;

class Install extends \RS\Module\AbstractInstall
{
    /**
    * Функция обновления модуля, вызывается только при обновлении
    */
    function update()
    {
        $result = parent::update();
        $this->patch20004();
        return $result;
    }
    
    /**
    * Патч прописывает alias ко всем тегам словам у которых нет этого
    * 
    */
    function patch20004()
    {
        if (\Setup::$INSTALLED && !\RS\HashStore\Api::get('MODULE_TAG_PATCH_20004')) {
            try {
                //Получим теги ранне созданные без alias
                $tags = \RS\Orm\Request::make()
                        ->from(new \Tags\Model\Orm\Word())
                        ->where('alias IS NULL')
                        ->objects();
                if (!empty($tags)){
                    foreach($tags as $tag){
                       $tag->update(); //При обновлении появится alias 
                    }
                }
                \RS\HashStore\Api::set('MODULE_TAG_PATCH_20004', true);
            } catch (\RS\Exception $e) {}
        }
    }
}
