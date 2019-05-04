<?php
namespace JSScripts\Config;
use \RS\Orm\Type;

/**
* Конфигурационный файл модуля
*/
class File extends \RS\Orm\ConfigObject
{
    function _init()
    {
        parent::_init()->append(array(
            'head_scripts' => new Type\Text(array(
                'description' => t('HTML-код для размещения в секции HEAD'),
                'hint' => t('Здесь можно разместить инструкции по подключению сторонних скриптов, например &lt;script type="text/javascript" src="..."&gt;. Если необходимо разместить несколько кодов, то размещайте каждый новый скрипт с новой строки.')
            )),
            'footer_scripts' => new Type\Text(array(
                'description' => t('HTML-код для размещения в конце страницы, перед закрывающим тегом BODY'),
                'hint' => t('Если необходимо разместить несколько кодов, то размещайте каждый код с новой строки')
            ))
        ));
    }
}