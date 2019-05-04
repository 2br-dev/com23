<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Catalog\Controller\Block;

use Catalog\Model\Dirapi;
use \RS\Orm;

class TopCategories extends \RS\Controller\StandartBlock
{
    protected static
        $controller_title = 'Выборка категорий',
        $controller_description = 'Отображает изображения и названия некоторых выбранных категорий';

    protected
        $default_params = array(
            'indexTemplate' => 'blocks/topcategories/top_categories.tpl', //Должен быть задан у наследника
            'category_ids' => array(),
            'sort_by_title' => ''
        );

    /**
     * @var Dirapi
     */
    public $dir_api;


    function getParamObject()
    {
        return parent::getParamObject()->appendProperty(array(
            'category_ids' => new Orm\Type\ArrayList(array(
                'description' => t('Отображать категории'),
                'list' => array(array('\Catalog\Model\DirApi', 'staticSelectList')),
                'checkboxListView' => true
            )),
            'sort' => new Orm\Type\Varchar(array(
                'description' => t('Сортировка'),
                'listFromArray' => array(array(
                    '' => t('Без сортировки'),
                    'id' => t('Идентификатор'),
                    'name' => t('Наименование'),
                    'sortn' => t('Порядок в административной панели')
                ))
            ))
        ));
    }

    function init()
    {
        $this->dir_api = new Dirapi();
    }

    function actionIndex()
    {
        $sort_by_title = $this->getParam('sort');
        if ($dir_ids = $this->getParam('category_ids')) {
            $this->dir_api->setFilter('id', $dir_ids, 'in');
            if (!empty($sort_by_title)){
                $this->dir_api->setOrder($this->getParam('sort'));
            }
        }

        $this->view->assign(array(
            'categories' => $this->dir_api->getList()
        ));

        return $this->result->setTemplate( $this->getParam('indexTemplate') );
    }
}