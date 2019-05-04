<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace RS\Html\Debug;

class Cache extends AbstractButton
{
    function __construct($mod_name)
    {
        $this->icon_url = \Setup::$RESOURCE_PATH.'/img/debug/cache.png';
        $this->title = 'Очистить кэш';
    }
}

