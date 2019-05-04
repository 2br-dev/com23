<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/

namespace RS\Html\Debug;

/**
* Выдает информацию о модуле
*/
class Info extends AbstractButton
{
    function __construct($mod_name, $ctrl_name)
    {
        CApp::getInstance()->addCss( 'common/debug.tooltip.css','tooltip', BP_COMMON);
        CApp::getInstance()->addJs( 'jquery.tooltip.js','tooltip', BP_COMMON);
        
        $mod = new CModule_Item($mod_name);
        $config = $mod->getConfig();
        $this->icon_url = \Setup::$RESOURCE_PATH.'/img/debug/about.png';
        $info = array(
            "Информация о модуле",
            "Название: {$config['name']}",
            "Описание: {$config['description']}",
            "Класс: {$mod_name}",
            "Версия: {$config['version']}",
            "Автор: {$config['author']}",
            "Контроллер: {$ctrl_name}"
        );
        
        $this->title = implode('<br/>', $info);
        $this->attr['class'] .= ' debug-hint';
    }
    
    function getView()
    {
        $this->href = 'JavaScript:;';
        $url = '/'.\Setup::$ADMIN_SECTION."/debug.php?Act=showVars&toolgroup={$this->uniq_group}";
        $this->attr['onclick'] = "window.open('$url','popup', 'width=400,height=300,scrollbars=yes')";
                
        return parent::getView();
        
    }
        
}

