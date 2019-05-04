<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace RS\Html\Debug;

class Options extends AbstractButton
{
    function __construct($mod_name)
    {
        $this->icon_url = \Setup::$RESOURCE_PATH.'/img/debug/options.png';
        $this->title = 'Настройки';
        $this->href = "/admin/MControl_Adm_Ctrl/?do=edit&mod=$mod_name";
        $this->attr['target'] = "_blank";
    }
}

