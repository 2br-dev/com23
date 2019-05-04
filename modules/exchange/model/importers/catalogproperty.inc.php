<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Exchange\Model\Importers;
use \RS\Helper\Tools as Tools;

/**
* Импорт справочника свойств товаров (не путать с характеристиками).
* В этом классе происходит импорт возможных названий свойств у товаров (справочник свойств).
* Импорт значений свойств для каждого конкретного товара происходит в другом месте при импорте товара.
*/

class CatalogProperty extends \Exchange\Model\Importers\AbstractImporter
{
    static public $pattern = array(
        '2.04' => '/Классификатор\/Свойства\/Свойство$/i',
        '2.03' => '/Классификатор\/Свойства\/СвойствоНоменклатуры$/i',
    );
    static public $title    = 'Импорт Свойств';
    
    const SESSION_PROP_ALLOWED_VALUES_KEY = 'SESSION_PROP_ALLOWED_VALUES_KEY';
    
    public function import(\XMLReader $reader)
    {
        \Exchange\Model\Log::w(t("Импорт свойства: ").$this->getSimpleXML()->Наименование);

        // Если совойство содержит справочник возможных значений, то сохраняем его в сессию
        if($this->getSimpleXML()->ВариантыЗначений->Справочник){
            // Восстанавливаем массив значений из сессии
            $stored_prop_values = (array) \Exchange\Model\Task\TaskQueue::getSessionVar(self::SESSION_PROP_ALLOWED_VALUES_KEY);
            
            foreach($this->getSimpleXML()->ВариантыЗначений->Справочник as $one){
                $stored_prop_values[(string)$one->ИдЗначения] = (string)$one->Значение;
            }
            
            // Сохраняем массив обратно в сессию
            \Exchange\Model\Task\TaskQueue::setSessionVar(self::SESSION_PROP_ALLOWED_VALUES_KEY, $stored_prop_values);
        }
        
        $product_property = new \Catalog\Model\Orm\Property\Item();
        $product_property->site_id  = \RS\Site\Manager::getSiteId(); 
        $product_property->type     = ($this->getSimpleXML()->ВариантыЗначений->Справочник) ? 'list' : 'string';
        $product_property->title    = Tools::toEntityString($this->getSimpleXML()->Наименование);
        $product_property->xml_id   = (string) $this->getSimpleXML()->Ид; 

        $product_property->insert(false, array('title'), array('xml_id', 'site_id'));
    }
    
    /**
    * Возвращает допустимое значение свойства из справочника допустимых значений, хранящегося в сессии.
    * 
    * @param string $xml_id Идентификатор значения в системе 1C
    */
    static public function getPropertyAllowedValueByXmlId($xml_id)
    {
        $stored_prop_values = (array) \Exchange\Model\Task\TaskQueue::getSessionVar(self::SESSION_PROP_ALLOWED_VALUES_KEY);
        return isset($stored_prop_values[$xml_id]) ? $stored_prop_values[$xml_id] : null;
    }
    
}