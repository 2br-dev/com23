<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Statistic\Controller\Admin;
use \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Toolbar,
    \RS\Html\Tree,
    \RS\Html\Table;

/**
 * Класс контроллера типов источников
 * @package Statistic\Controller\Admin
 */
class SourceTypesCtrl extends \RS\Controller\Admin\Crud
{

    /**
     * @var \Statistic\Model\SourceTypeDirsApi $dir_api
     */
    protected $dir_api;
    protected $dir; //Выбранная категория
    /**
     * @var \Statistic\Model\SourceTypesApi $api
     */
    protected $api;
        
    function __construct()
    {
        parent::__construct(new \Statistic\Model\SourceTypesApi());
        $this->dir_api = new \Statistic\Model\SourceTypeDirsApi();
    }
    
    function actionIndex()
    {
        if (!$this->dir_api->getOneItem($this->dir)) {
            $this->dir = 0; //Если категории не существует, то выбираем пункт "Все"
        }
        $this->api->setFilter('parent_id', $this->dir);            
        
        return parent::actionIndex();
    }
    
    function helperIndex()
    {        
        $helper = parent::helperIndex();
        $helper->setTopTitle(t('Типы источников пользователей'));
        $this->dir = $this->url->request('dir', TYPE_INTEGER);
        $helper->setTopToolbar($this->buttons(array('add'), array('add' => t('добавить тип'))));

        $helper['topToolbar']->addItem(new ToolbarButton\Button(
            $this->router->getAdminUrl('ajaxUpdateSourceTypes', null, 'statistic-tools'),
            t('Обновить источники'),
            array(
                'attr' => array(
                    'class' => 'crud-get'
                )
            )
        ));

        $helper->setTopHelp(t('Здесь указываются правила, по которым опознаётся источник приходящего пользователя. Когда пользователь впервые попадает на сайт, 
        к нему привязывается информация о том, откуда он перешел и дополнительные пареметры UTM меток, если они есть. Далее, когда происходят события оформления заказа или 
        покупки в одик клик или же отработала форма обратной связи, то сохраненная ранее информация об источнике приписывается к соответствующему объекту. В данном разделе вы можете управлять справочником источников. Для описания источника ReadyScript может анализировать заголовок REFERER, а также UTM метки. 
        Информация о том, какие источники привели к целевому действию можно просмотреть в отчетах статистики.'));
        $helper->addCsvButton('statistic-sourcetypes');
        $helper->setBottomToolbar($this->buttons(array('multiedit', 'delete')));
        $helper->viewAsTableTree();
        
        $helper->setTable(new Table\Element(array(
                'Columns' => array(
                    new TableType\Checkbox('id', array('showSelectAll' => true)),
                    new TableType\Text('sortn', t('Вес'), array('sortField' => 'id', 'Sortable' => SORTABLE_ASC,'CurrentSort' => SORTABLE_ASC,'ThAttr' => array('width' => '20'))),
                    new TableType\Text('title', t('Название'), array('LinkAttr' => array('class' => 'crud-edit'), 'Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id', 'dir' => $this->dir)))),
                    new TableType\Text('referer_site', t('Домен'), array('LinkAttr' => array('class' => 'crud-edit'), 'Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id', 'dir' => $this->dir)))),
                    new TableType\Text('id', '№', array('TdAttr' => array('class' => 'cell-sgray'))),
                    new TableType\Actions('id', array(
                        new TableType\Action\Edit($this->router->getAdminPattern('edit', array(':id' => '~field~', 'dir' => $this->dir)), null, 
                        array(
                            'attr' => array(
                            '@data-id' => '@id'
                        ))),
                        new TableType\Action\DropDown(array(
                            array(
                                'title' => t('Клонировать'),
                                'attr' => array(
                                    'class' => 'crud-add',
                                    '@href' => $this->router->getAdminPattern('clone', array(':id' => '~field~')),
                                )
                            ),  
                            array(
                                'title' => t('удалить'),
                                'class' => 'crud-get',
                                'attr' => array(
                                    '@href' => $this->router->getAdminPattern('del', array(':chk[]' => '@id')),
                                )
                            ),
                        ))),
                        array('SettingsUrl' => $this->router->getAdminUrl('tableOptions'))
                        ),                                        
                )
        )));
        
        $helper->setTreeListFunction('selectTreeList');
        $helper->setTree(new Tree\Element( array(
            'activeField' => 'id',
            'disabledField' => 'hidden',
            'disabledValue' => '1',
            'activeValue' => $this->dir,
            'noExpandCollapseButton' => true,
            'rootItem' => array(
                'id' => 0,
                'title' => t('Без группы'),
                'noOtherColumns' => true,
                'noCheckbox' => true,
                'noDraggable' => true,
                'noRedMarker' => true
            ),
            'sortUrl' => $this->router->getAdminUrl('move_dir'),
            'mainColumn' => new TableType\Text('title', t('Название'), array('href' => $this->router->getAdminPattern(false, array(':dir' => '@id', 'c' => $this->url->get('c', TYPE_ARRAY))) )),
            'tools' => new TableType\Actions('id', array(
                new TableType\Action\Edit($this->router->getAdminPattern('edit_dir', array(':id' => '~field~')), null, array(
                    'attr' => array(
                        '@data-id' => '@id'
                ))),
                new TableType\Action\DropDown(array(
                        array(
                            'title' => t('Клонировать категорию'),
                            'attr' => array(
                                'class' => 'crud-add',
                                '@href' => $this->router->getAdminPattern('clonedir', array(':id' => '~field~')),
                            )
                        ),                              
                )),
            )),
            'headButtons' => array(
                array(
                    'text' => t('Название группы'),
                    'tag' => 'span',
                    'attr' => array(
                        'class' => 'lefttext'
                    )
                ),            
                array(
                    'attr' => array(
                        'title' => t('Создать категорию'),
                        'href' => $this->router->getAdminUrl('add_dir'),
                        'class' => 'add crud-add'
                    )
                ),
            ),
        )), $this->dir_api);
        
        $helper->setTreeBottomToolbar(new Toolbar\Element( array(
            'Items' => array(
                new ToolbarButton\Delete(null, null, array('attr' => 
                    array('data-url' => $this->router->getAdminUrl('del_dir'))
                )),
        ))));

        $helper->setTreeFilter(new Filter\Control( array(
            'Container' => new Filter\Container( array(
                'Lines' =>  array(
                    new Filter\Line( array('Items' => array(
                            new Filter\Type\Text('title', t('Название'), array('SearchType' => '%like%')),
                        )
                    ))
                ),
            )),
            'ToAllItems' => array('FieldPrefix' => $this->dir_api->defAlias()),
            'filterVar' => 'c',
            'Caption' => t('Поиск по группам')
        )));

        $helper->setFilter(new Filter\Control(array(
            'Container' => new Filter\Container( array(
                'Lines' =>  array(
                    new Filter\Line( array('Items' => array(
                        new Filter\Type\Text('title', t('Название'), array('SearchType' => '%like%')),
                    )
                    ))
                ))),
            'ToAllItems' => array('FieldPrefix' => $this->api->defAlias()),
            'AddParam' => array('hiddenfields' => array('dir' => $this->dir)),
            'Caption' => t('Поиск по типам')
        )));

        
        return $helper;
    }
    
    function actionAdd_dir($primaryKey = null)
    {
        return parent::actionAdd($primaryKey);
    }
    
    function helperAdd_Dir()
    {
        $this->api = $this->dir_api;
        return parent::helperAdd();
    }
    
    function actionEdit_dir()
    {
        $id = $this->url->get('id', TYPE_INTEGER, 0);
        if ($id) $this->dir_api->getElement()->load($id);
        return $this->actionAdd_dir($id);        
    }

    function helperEdit_Dir()
    {
        return $this->helperAdd_dir();
    }

    /**
     * Добавление типа источника
     *
     * @param null $primaryKey
     * @param bool $returnOnSuccess
     * @param null $helper
     * @return bool|\RS\Controller\Result\Standard
     */
    function actionAdd($primaryKey = null, $returnOnSuccess = false, $helper = null)
    {
        $dir = $this->url->request('dir', TYPE_INTEGER);
        if ($primaryKey === null) {
            $elem = $this->api->getElement();
            $elem['parent_id'] = $dir;
        }
        
        $this->getHelper()->setTopTitle($primaryKey ? t('Редактировать тип {title}') : t('Добавить тип'));
        
        return parent::actionAdd($primaryKey, $returnOnSuccess, $helper);
    }

    /**
     * Удаление категорий
     *
     * @return mixed
     */
    function actionDel_dir()
    {
        $ids = $this->url->request('chk', TYPE_ARRAY, array(), false);
        $this->dir_api->del($ids);
        return $this->result->setSuccess(true)->getOutput();
    }

    /**
     * Клонирование директории
     *
     * @return bool|\RS\Controller\Result\Standard
     * @throws \RS\Controller\ExceptionPageNotFound
     */
    function actionCloneDir()
    {
        $this->setHelper( $this->helperAdd_dir() );
        $id = $this->url->get('id', TYPE_INTEGER);
        $elem = $this->dir_api->getElement();
        
        if ($elem->load($id)) {
            $clone = $elem->cloneSelf();
            $this->dir_api->setElement($clone);
            $clone_id = $clone['id'];

            return $this->actionAdd_dir($clone_id);
        } else {
            $this->e404();
        }
    }
}

