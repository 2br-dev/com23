<?php
namespace Redirector\Controller\Admin;

use \RS\Html\Table\Type as TableType,
    \RS\Html\Toolbar\Button as ToolbarButton,
    \RS\Html\Filter,
    \RS\Html\Table;
    
/**
* Контроллер списка правил для 301 редиректов
*/
class Ctrl extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        //Устанавливаем, с каким API будет работать CRUD контроллер
        parent::__construct(new \Redirector\Model\RedirectApi());
    }
    
    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopHelp(t('Используйте 301 редиректы, если страницы вашего сайта окончательно поменяли свой URL. Здесь можно задать простой список, состоящий из старого и нового относительного пути к странице, а также регулярное выражение(для опытных пользователей). Регулярное выражение - это маска, с которой будет сравниваться адрес. В случае соответствия URL заданной маске произойдет 301 редирект на новый указанный адрес.'));
        $helper->setTopToolbar($this->buttons(array('add'), array('add' => t('Добавить правило'))));
        $helper->setTopTitle(t('Правила для 301 редиректов')); //Установим заголовок раздела
        $helper->addCsvButton('redirector-rules');
        
        //Отобразим таблицу со списком объектов
        $helper->setTable(new Table\Element(array(
            'Columns' => array(
                    new TableType\Checkbox('id'),
                    new TableType\Text('source_url', t('Старый адрес'), array('Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id')), 'LinkAttr' => array('class' => 'crud-edit'))),
                    new TableType\Text('destination_url', t('Новый адрес'), array('Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id')), 'LinkAttr' => array('class' => 'crud-edit'))),
                    new TableType\StrYesno('is_source_regex', t('Регулярное выражение'), array('Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id')), 'LinkAttr' => array('class' => 'crud-edit'))),
                    new TableType\Text('sortn', t('Приоритет'), array('Sortable' => SORTABLE_BOTH, 'tdAttr' => array('class' => 'cell-sgray'))),                    
                    new TableType\Text('id', '№', array('Sortable' => SORTABLE_BOTH, 'CurrentSort' => SORTABLE_DESC, 'tdAttr' => array('class' => 'cell-sgray'))),
                    new TableType\Actions('id', array(
                            new TableType\Action\Edit($this->router->getAdminPattern('edit', array(':id' => '~field~'))),
                        ),
                        array('SettingsUrl' => $this->router->getAdminUrl('tableOptions'))
                    ), 
        ))));
        
        //Добавим фильтр значений в таблице по названию
        $helper->setFilter(new Filter\Control( array(
            'Container' => new Filter\Container( array( 
                                'Lines' =>  array(
                                    new Filter\Line( array('items' => array(
                                            new Filter\Type\Text('source_url', t('Старый адрес'), array('SearchType' => '%like%')),
                                            new Filter\Type\Text('destination_url', t('Новый адрес'), array('SearchType' => '%like%')),
                                        )
                                    ))
                                ),
                            ))
        )));

        return $helper;
    }

}
