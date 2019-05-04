<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Statistic\Model;
 
/**
* API функции для работы с группами типов источников
*/
class SourceTypeDirsApi extends \RS\Module\AbstractModel\EntityList
{
    public
        $uniq;

    function __construct()
    {
        parent::__construct(new Orm\SourceTypeDir(),array(
            'name_field' => 'title',
            'id_field' => 'id',
            'sort_field' => 'title',
            'multisite' => true,
            'defaultOrder' => 'title'
        ));
    }

    public static function selectList()
    {
        $_this = new self();
        return array(0 => t('Без группы'))+ $_this->getSelectList(0);
    }

    /**
     * Получает список категорий для дерева
     *
     * @return array
     */
    public function selectTreeList()
    {
        $list = array();
        $res = $this->getListAsResource();
        while($row = $res->fetchRow()) {
            $list[] = array('fields' => $row, 'child' => array());
        }
        return $list;
    }
}