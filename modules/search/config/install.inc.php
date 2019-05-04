<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Search\Config;

class Install extends \RS\Module\AbstractInstall
{
    function update()
    {
        $this->patch20072();
        return parent::update();
    }
    
    /**
    * Патч для релиза 2.0.0.72 и ниже
    * Удаляет дубликаты из таблицы с поисковыми индексами, чтобы установить уникальный индекс
    */
    function patch20072()
    {
        if (\Setup::$INSTALLED && !\RS\HashStore\Api::get('MODULE_SEARCH_PATCH_20072')) {
            try {
                $search_index_orm = new \Search\Model\Orm\Index();
                $total = \RS\Orm\Request::make()
                    ->from($search_index_orm)
                    ->count();
                    
                $distinct = \RS\Orm\Request::make()
                    ->select('COUNT(DISTINCT result_class,entity_id) as cnt')
                    ->from($search_index_orm)
                    ->exec()->getOneField('cnt', 0);
                
                if ($total != $distinct) {
                    //Удаляем дубликаты
                    $sqls = array(
                        "CREATE TEMPORARY TABLE search_index_tmp AS SELECT * FROM (SELECT * FROM ".$search_index_orm->_getTable()." ORDER BY dateof DESC) as sorted_table GROUP BY result_class, entity_id",
                        "DELETE FROM ".$search_index_orm->_getTable(),
                        "INSERT INTO ".$search_index_orm->_getTable()." SELECT * FROM search_index_tmp",
                        "DROP TABLE search_index_tmp"
                    );
                    foreach($sqls as $sql) {
                        \RS\Db\Adapter::sqlExec($sql);
                    }
                }
                \RS\HashStore\Api::set('MODULE_SEARCH_PATCH_20072', true);
            } catch (\RS\Exception $e) {}
        }
    }
    
}
