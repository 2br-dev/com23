<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Controller\Front;

/**
* Контроллер - контакты филиала
*/
class Contacts extends \RS\Controller\Front
{
    public 
        $api;
        
    function init()
    {
        $this->api = new \Affiliate\Model\AffiliateApi();        
    }
    
    function actionIndex()
    {
        $affiliate_id = $this->url->get('affiliate', TYPE_STRING);
        $affiliate = $this->api->getById($affiliate_id);
        
        if (!$affiliate['public']) $this->e404(t('Филиал не найден'));
        
        //Записываем в маршрут текущий филиал для блок-контроллеров
        $this->router->getCurrentRoute()->affiliate = $affiliate;
        
        $this->app->breadcrumbs
                        ->addBreadCrumb(t('Контакты'));
                        
        $meta_title = $affiliate['meta_title'] ?: t('Контакты в городе %0', array($affiliate['title']));
        
        $this->app->title->addSection($meta_title);
        $this->app->meta->addKeywords($affiliate['meta_keywords'])
                        ->addDescriptions($affiliate['meta_description']);
        
        $this->view->assign(array(
            'affiliates' => $this->api->getTreeList(0),
            'affiliate' => $affiliate
        ));
        
        return $this->result->setTemplate('affiliate_contacts.tpl');
    }
}