<?php
namespace MetaValidation\Config;
use \RS\Orm\Type;

/**
* Конфигурационный файл модуля
*/
class File extends \RS\Orm\ConfigObject
{
    function _init()
    {
        parent::_init()->append(array(
            'meta_tags' => new Type\ArrayList(array(
                'runtime' => false,
                'description' => '',
                'template' => '%metavalidation%/metatags.tpl'
            )),
        ));
    }
}