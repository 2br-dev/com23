<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Controller\Admin;

use \RS\Html\Tree,
    \RS\Html\Toolbar,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Table\Type as TableType;
    
/**
* Контроллер Управление списком магазинов сети
*/
class Ctrl extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new \Affiliate\Model\AffiliateApi());
    }
    
    function helperIndex()
    {
        $helper = parent::helperIndex();
        $helper->setTopTitle(t('Филиалы в городах'));
        $helper->setTopHelp($this->view->fetch('admin_help.tpl'));
        $helper->setTopToolbar(new Toolbar\Element( array(
            'Items' => array(
                new ToolbarButton\Add($this->router->getAdminUrl('add'), t('добавить филиал'))
            )
        )));        
        $helper->addCsvButton('affiliate-affiliate');
        
        $tools = new TableType\Actions('id', array(
                new TableType\Action\Edit($this->router->getAdminPattern('edit', array(':id' => '@id')),null, array(
                        'attr' => array(
                            '@data-id' => '@id'
                        )
                    )),
                new TableType\Action\DropDown(array(
                    'clone' => array(
                        'title' => t('Клонировать'),
                        'attr' => array(
                            'class' => 'crud-add',
                            '@href' => $this->router->getAdminPattern('clone', array(':id' => '@id')),
                        )
                    ),
                    'add_child' => array(
                        'title' => t('Добавить дочерний элемент'),
                        'attr' => array(
                            '@href' => $this->router->getAdminPattern('add', array(':pid' => '@id')),
                            'class' => 'crud-add'
                        )
                    ),
                    'set_default' => array(
                        'title' => t('Установить по умолчанию'),
                        'attr' => array(
                            '@href' => $this->router->getAdminPattern('setDefault', array(':id' => '@id')),
                            'class' => 'crud-get'
                        )
                    ),
                    'contact_page' => array(
                        'title' => t('Показать контакты на сайте'),
                        'attr' => array(
                            '@href' => $this->router->getUrlPattern('affiliate-front-contacts', array(':affiliate' => '@alias')),
                            'target' => '_blank'
                        )
                    ),
                )),
        ));
        
        //Формируем список действий для дочерних элементов
        $sub_tools = clone $tools;
        $actions = $sub_tools->getActions();
        $actions[1]->removeItem('add_child'); //Исключаем пункт "Добавить дочерний элемент"        
        $this->api->setSubTools($sub_tools);  //Устанавливаем список действий для дочерних элементов
        
        $helper->setBottomToolbar($this->buttons(array('multiedit', 'delete')));
        $helper->viewAsTree();
        $helper->setTreeListFunction('getTreeData');
        $helper->setTree(new Tree\Element( array(
            'maxLevels'     => 2,
            'disabledField' => 'public',
            'disabledValue' => '0',        
            'activeField'   => 'id',
            'sortIdField'   => 'id',
            'hideFullValue' => true,
            'sortable'      => true,            
            'sortUrl'       => $this->router->getAdminUrl('move'),
            'mainColumn'    => new TableType\Usertpl('title', t('Название'), '%affiliate%/tree_column.tpl'),
            'tools' => $tools
        )));
        
        return $helper;
    }
    
    function actionAdd($primaryKey = null, $returnOnSuccess = false, $helper = null)
    {
        $parent = $this->url->get('pid', TYPE_INTEGER, null);        
        $obj = $this->api->getElement();
        
        if ($parent) {
            $obj['parent_id'] = $parent;
        }
        
        $title = $obj['id'] ? t('Редактировать филиал {title}') : t('Добавить филиал');
        $this->getHelper()->setTopTitle($title);
        
        return parent::actionAdd($primaryKey, $returnOnSuccess, $helper);
    }
    
    function actionMove()
    {
        $from = $this->url->request('from', TYPE_INTEGER);
        $to = $this->url->request('to', TYPE_INTEGER);
        $flag = $this->url->request('flag', TYPE_STRING); //Указывает выше или ниже элемента to находится элемент from
        $parent = $this->url->request('parent', TYPE_INTEGER);
        
        if ($this->api->moveElement($from, $to, $flag, null, $parent)) {
            $this->result->setSuccess(true);
        } else {
            $this->result->setSuccess(false)->setErrors($this->api->getErrorsStr());
        }
        
        return $this->result->getOutput();
    }        
    
    function actionSetDefault()
    {
        if ($access_error = \RS\AccessControl\Rights::CheckRightError($this, ACCESS_BIT_WRITE)) {
            return $this->result->setSuccess(false);
        }
        
        $id = $this->url->request('id', TYPE_INTEGER);
        $affiliate = new \Affiliate\Model\Orm\Affiliate($id);
        if (!$affiliate['id']) $this->e404();
        
        $affiliate['is_default'] = 1;
        $this->result->setSuccess($affiliate->update());
        if (!$this->result->isSuccess()) {
            $this->result->addEMessage($affiliate->getErrorsStr());
        }
        return $this->result;
    }
}
