<?php
namespace Redirector\Model\CsvSchema;
use \RS\Csv\Preset,
    \Redirector\Model\Orm;

/**
* Схема экспорта/импорта характеристик в CSV
*/
class Rules extends \RS\Csv\AbstractSchema
{
    function __construct()
    {
        parent::__construct(new Preset\Base(array(
            'ormObject' => new Orm\RedirectRule(),
            'excludeFields' => array('id', 'site_id'),
            'multisite' => true,
            'searchFields' => array('source_url')            
        )));
    }
    
}
?>