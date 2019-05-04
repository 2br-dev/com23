<?php
namespace JSScripts\Config;
use \RS\Application\Application,
    \RS\Helper\Tools;

class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this->bind('controller.beforewrap');
    }
    
    public static function controllerBeforewrap($params) 
    {
        if (!\RS\Router\Manager::obj()->isAdminZone()) {
            $config = \RS\Config\Loader::byModule(__CLASS__);
            if ($config->head_scripts) {
                Application::getInstance()->setAnyHeadData(Tools::unEntityString($config->head_scripts));
            }
            
            if ($config->footer_scripts) {
                $params['body'] .= Tools::unEntityString($config->footer_scripts);
            }
            return $params;
        }
    }    
}
