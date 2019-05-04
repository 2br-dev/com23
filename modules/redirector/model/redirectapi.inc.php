<?php
namespace Redirector\Model;

/**
* Класс для организации выборок ORM объекта.
* В этом классе рекомендуется также реализовывать любые дополнительные методы, связанные с заявленной в конструкторе моделью
*/
class RedirectApi extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new Orm\RedirectRule());
    }
    
    /**
    * Выполняет 301 редирект согласно правилам, заведенным в панели управления
    * @return void
    */
    function applyRedirect()
    {
        if (\RS\Router\Manager::obj()->isAdminZone()) return;
        
        //Редиректы будут работать только в клиентской части
        $rules = $this->getRules();
        $request_uri = \RS\Http\Request::commonInstance()->server('REQUEST_URI');
        foreach($rules as $rule) {

            $request_uri = ($rule['cut_query_string']) ? strtok($request_uri, '?') : $request_uri;
            $destination_url = \RS\Helper\Tools::unEntityString($rule['destination_url']);
            $source_url = \RS\Helper\Tools::unEntityString($rule['source_url']);

            $redirect = false;
            if ($rule['is_source_regex']) {
                $source_url = str_replace('/', '\/', $source_url);
                if (preg_match('/'.$source_url.'/', $request_uri , $match)) {
                    for($n=1; $n < count($match); $n++) {
                        $destination_url = str_replace('\\'.$n, $match[$n], $destination_url);
                    }
                    $redirect = $destination_url;
                }
            } else {
                if ($request_uri == $rule['source_url']) {
                    $redirect = $destination_url;
                }
            }
            
            if ($redirect !== false) {
                header('Location:'.$redirect, true, 301);
                exit;
            }
        };
    }
    
    function getRules($cache = false)
    {
        if ($cache) {
            \RS\Cache\Manager::obj()
                ->expire(0)            
                ->watchTables($this->obj_instance)
                ->request(array($this, 'getRules'), false);
        } else {
            return \RS\Orm\Request::make()
                ->from($this->obj_instance)
                ->where(array('site_id' => \RS\Site\Manager::getSiteId()))
                ->orderby('sortn')
                ->exec()->fetchAll();
        }
    }
    
}