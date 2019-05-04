<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Exchange\Model\Importers;
use \Exchange\Model\Log;
use \RS\Helper\Tools as Tools;

/**
* Импорт группы товаров
*/

class CatalogGroup extends \Exchange\Model\Importers\AbstractImporter
{
    static public $pattern = '/Классификатор\/Группы\/Группа$/i';
    static public $title    = 'Импорт Групп';
    protected
        $dir_list,
        $dir_list_from_xml;
    
    public function import(\XMLReader $reader)
    {
        $api = new \Catalog\Model\Dirapi();
        $tree = $api->getTreeList();
        if ($this->getConfig()->is_unic_dirname) {
            $this->dir_list = $this->getStringListId($tree);
            $this->dir_list_from_xml = $this->getStringListIdFromXml($this->getSimpleXML());
        }
        \Exchange\Model\Log::w(t("Импорт корневой группы: ").$this->getSimpleXML());
        $this->recursiveImport($this->getSimpleXML());
    }
    
    private function recursiveImport(\SimpleXMLElement $group, \Catalog\Model\Orm\Dir $parent_dir = null)
    {
        Log::indentInc();
        $dir = $this->importOneGroup($group, $parent_dir);
        if($group->Группы->Группа)    
        {
            foreach($group->Группы->Группа as $one)
            {
                $this->recursiveImport($one, $dir);
            }
        }
        Log::indentDec();
    }
    
    private function importOneGroup(\SimpleXMLElement $group, \Catalog\Model\Orm\Dir $parent_dir = null)
    {
        Log::w(t("Импорт группы: ").$group->Наименование);
        $dir = new \Catalog\Model\Orm\Dir();
        $dir->no_update_levels = true;

        // Если включена настройка "Идентифицировать категории по наименованию" - обновим xml_id категории
        if ($this->getConfig()->is_unic_dirname){
            if(isset($this->dir_list[$this->dir_list_from_xml[(string)$group->Ид]]))
            \RS\Orm\Request::make()
                ->update(new \Catalog\Model\Orm\Dir())
                ->set(array('xml_id' => $group->Ид))
                ->where(array(
                    'id' => $this->dir_list[$this->dir_list_from_xml[(string)$group->Ид]],
                    'site_id' => \RS\Site\Manager::getSiteId(),
                ))
                ->limit(1)
                ->exec();
        }

        $dir->site_id   = \RS\Site\Manager::getSiteId(); 
        $dir->parent    = $parent_dir ? $parent_dir->id : 0;
        $dir->public    = 1;
        $dir->name      = Tools::toEntityString($group->Наименование);
        $dir->xml_id    = $group->Ид;
        $dir->processed = 1;
        
        // Настройка "Транслитерировать символьный код из названия при _добавлении_ элемента или раздела"
        if($this->getConfig()->catalog_translit_on_add){
            $uniq_postfix = hexdec(substr(md5((string)$group->Ид), 0, 4));
            $dir->alias = \RS\Helper\Transliteration::str2url($dir->name)."-".$uniq_postfix;
        }

        $on_duplicate_update_fields = array('xml_id', 'name', 'public', 'processed');
        
        // Исключаем поля, которые помечены как "не обновлять" в настройках модуля
        $on_duplicate_update_fields = array_diff($on_duplicate_update_fields, (array)$this->getConfig()->dont_update_group_fields);        
        
        if($this->getConfig()->catalog_update_parent) {
            $on_duplicate_update_fields[] = 'parent';
        }
        
        // Настройка "Транслитерировать символьный код из названия при _обновлении_ элемента или раздела"
        if($this->getConfig()->catalog_translit_on_update){
            $on_duplicate_update_fields[] = 'alias';
        }
        
        $dir->insert(false, $on_duplicate_update_fields, array('xml_id', 'site_id'));
        
        if(!$dir->id){
            throw new \Exception("no id");
        }
        
        return $dir;
    }

    /**
     *  Возвращает пути к каждому элементу дерева (категории) в виде склеенных названий элемента и всех его родителей в xml.
     *
     * @param $tree array - элемент дерева
     * @param $path string - путь к элементу
     */
    function getStringListIdFromXml($tree, $path = '')
    {
        $result = array();
        $current_path = $path.$tree->Наименование;
        $result[(string)$tree->Ид] = $current_path;
        if($tree->Группы) {
            foreach ($tree->Группы->Группа as $group) {
                $result = array_merge($result, $this->getStringListIdFromXml($group, $current_path));
            }
        }
        return $result;
    }

    /**
     *  Возвращает пути к каждому элементу дерева (категории) в виде склеенных названий элемента и всех его родителей.
     *
     * @param $tree array - элемент дерева
     * @param $path string - путь к элементу
     */
    public function getStringListId($tree, $path = '')
    {
        $result = array();
        foreach ($tree as $node) {
            $current_path = $path.$node['fields']['name'];
            $result[$current_path] = $node['fields']['xml_id'];
            if(!empty($node['child'])) {
                $result = array_merge($result , $this->getStringListId($node['child'], $current_path));
            }
        }
        return $result;
    }
}