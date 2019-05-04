<?php
namespace MetaValidation\Config;
use \RS\Application\Application;

class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this->bind('start');
    }
    
    public static function start() 
    {
        $config = \RS\Config\Loader::byModule(__CLASS__);                
        if (!\RS\Router\Manager::obj()->isAdminZone() && $config->meta_tags) {
            $meta = Application::getInstance()->meta;
            foreach($config->meta_tags['name'] as $n => $data) {
                $meta->add(array(
                    'name' => $data, 
                    'content' => $config->meta_tags['content'][$n]
                ));
            }
        }
    }    
}
