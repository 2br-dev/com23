<?php
namespace Brbr\Controller\Admin;

use \RS\Html\Table\Type as TableType,
    \RS\Html\Filter,
    \RS\Html\Table;

class Ctrl extends \RS\Controller\Admin\Crud
{
    function __construct()
    {
        parent::__construct(new \Brbr\Model\Api());
    }


    function helperIndex()
    {
        $helper = parent::helperIndex(); //Получим helper по-умолчанию
        $helper->setTopTitle(t('Конкурсные работы')); //Установим заголовок раздела
        $helper->setTopToolbar($this->buttons(array('add'), array('add' => t('добавить работу'))));
        //Установим, какие кнопки отобразить в нижней панели инструментов
        $helper->setBottomToolbar($this->buttons(array('multiedit', 'delete')));


        //Опишем колонки табличного представления данных
        $helper->setTable(new Table\Element(array(
            'Columns' => array(
                new TableType\Checkbox('id', array('showSelectAll' => true)), //Отображаем флажок "выделить элементы на всех страницах"
                new TableType\Text('title', t('Название'), array('Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id') ), 'LinkAttr' => array('class' => 'crud-edit') )),
                new TableType\Text('category', t('Категория'), array('Sortable' => SORTABLE_BOTH, 'href' => $this->router->getAdminPattern('edit', array(':id' => '@id') ), 'LinkAttr' => array('class' => 'crud-edit') )),
                new TableType\Text('id', '№', array('TdAttr' => array('class' => 'cell-sgray'))),
                new TableType\Actions('id', array(
                    //Опишем инструменты, которые нужно отобразить в строке таблицы пользователю
                    new TableType\Action\Edit($this->router->getAdminPattern('edit', array(':id' => '~field~')), null, array(
                        'attr' => array(
                            '@data-id' => '@id'
                        )))
                ),
                    //Включим отображение кнопки настройки колонок в таблице
                    array('SettingsUrl' => $this->router->getAdminUrl('tableOptions'))
                ),
            ),
            'TableAttr' => array(
                'data-sort-request' => $this->router->getAdminUrl('move')
            )

        )));

        //Опишем фильтр, который следует добавить
        $helper->setFilter(new Filter\Control(array(
            'Container' => new Filter\Container( array( //Контейнер визуального фильтра
                'Lines' =>  array(
                    new Filter\Line( array('Items' => array( //Одна линия фильтров
                        new Filter\Type\Text('id', '№'), //Фильтр по ID
                        new Filter\Type\Text('title', t('Название'), array('searchType' => '%like%')), //Фильтр по названию производителя
                    )
                    )),
                )
            )),
            'Caption' => t('Поиск по работам')
        )));

        return $helper;
    }


    /**
     * Открытие окна добавления и редактирования товара
     *
     * @param integer $primaryKeyValue - первичный ключ товара(если товар уже создан)
     * @return string
     */
    function actionAdd($primaryKeyValue = null, $returnOnSuccess = false, $helper = null)
    {
        /**
         * @var \Catalog\Model\Orm\Product $obj
         */
        $obj = $this->api->getElement();

        if ($primaryKeyValue <= 0 )
        {
            if ($primaryKeyValue == 0) {
                $obj->setTemporaryId();
            }
            $this->getHelper()->setTopTitle(t('Добавить работу'));
        } else {
            $this->getHelper()->setTopTitle(t('Редактировать работу ').'{title}');
        }

        return parent::actionAdd($primaryKeyValue, $returnOnSuccess, $helper);
    }
}