<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace RS\Html\Debug;

class Edit extends AbstractButton
{
    function __construct($edit_href)
    {
        $this->icon_url = \Setup::$RESOURCE_PATH.'/img/debug/edit.png';
        $this->href = $edit_href;
        $this->title = 'Редактировать';
        $this->attr['target'] = '_blank';
    }
}

