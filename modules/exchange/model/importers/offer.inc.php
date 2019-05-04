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
* Импорт предложения из пакета предложений
*/

class Offer extends \Exchange\Model\Importers\AbstractImporter
{
    static public $pattern  = '/Предложения\/Предложение$/i';
    static public $title    = 'Импорт товарных предложений';
    static public $product_barcode_by_xml_id = array();
    
    static private $_cache_import_hash    = null; //Кэш по хэшам импорта
    
    private $sXML;
    
    public function init()
    {
        if (self::$_cache_import_hash == null) {
            self::$_cache_import_hash = \RS\Orm\Request::make()
                ->select('xml_id, import_hash')
                ->from(new \Catalog\Model\Orm\Offer())
                ->where('xml_id > "" and import_hash > ""')
                ->where(array('site_id' => \RS\Site\Manager::getSiteId()))
                ->exec()->fetchSelected('xml_id', 'import_hash');
        }
    }
    
    public function import(\XMLReader $reader)
    {
        $import_hash = md5($this->getSimpleXML()->asXML());
        $xml_id = (string) $this->getSimpleXML()->Ид;
        
        if (isset(self::$_cache_import_hash[$xml_id]) && self::$_cache_import_hash[$xml_id] == $import_hash) {
            \Exchange\Model\Log::w(t("Нет изменений в предложении: ").$this->getSimpleXML()->Наименование);
            \RS\Orm\Request::make()
                ->update(new \Catalog\Model\Orm\Offer())
                ->set(array('processed' => 1))
                ->where(array(
                    'xml_id' => $xml_id,
                    'site_id' => \RS\Site\Manager::getSiteId(),
                ))
                ->exec();
        } else {
            \Exchange\Model\Log::w(t("Импорт предложения: ").$this->getSimpleXML()->Наименование);
            
            $default_warehouse_id = \Catalog\Model\WareHouseApi::getDefaultWareHouse()->id;
            
            // Обрезанный xml_id (то, что до символа #)
            $product_xml_id = $this->getProductXMLId();
            /*
            * @var \Catalog\Model\Orm\Product
            */
            $product = \Catalog\Model\Orm\Product::loadByWhere(
                array(
                    'xml_id' => $product_xml_id,
                    'site_id' => \RS\Site\Manager::getSiteId(),
                )
            );
            
            
            // Возможно это старая версия и XML_ID предложения совпадает с XML_ID товара
            if(!$product->id){
                $product = \Catalog\Model\Orm\Product::loadByWhere(
                    array(
                        'xml_id' => (string)$this->getSimpleXML()->Ид,
                        'site_id' => \RS\Site\Manager::getSiteId(),
                    )
                );
            }
           
            if(!$product->id){
                \Exchange\Model\Log::w(t("Не удалось загрузить товар '").$product_xml_id);
                return;
            }
            
            $barcode = Tools::toEntityString($this->getSimpleXML()->Артикул);
            $title = Tools::toEntityString($this->getSimpleXML()->Наименование);
            // Если включена настройка "Идентифицировать товары по артикулу" - обновим xml_id комплектации
            if ($this->getConfig()->is_unic_barcode && !empty($barcode)) {
                \RS\Orm\Request::make()
                    ->update(new \Catalog\Model\Orm\Offer())
                    ->set(array('xml_id' => $xml_id))
                    ->where(array(
                        'barcode' => $barcode,
                        'title' => $title
                    ))
                    ->limit(1)
                    ->exec();
            }
            
            // Добавляем запись в таблицу product_offer (Ценовое предложение)
            $offer_api     = new \Catalog\Model\OfferApi();
            $product_offer = new \Catalog\Model\Orm\Offer();
            
            $product_offer->site_id     = \RS\Site\Manager::getSiteId();
            $product_offer->product_id  = $product->id;
            $product_offer->title       = $title;
            $product_offer->barcode     = $barcode;
            $product_offer->num         = (string) $this->getSimpleXML()->Количество;
            $product_offer->xml_id      = (string) $this->getSimpleXML()->Ид; //Уникальный идентификатор в 1С
            $product_offer->sku         = (string) $this->getSimpleXML()->Штрихкод;
            $product_offer->processed   = 1; //Флаг обработанной комплектации
            $product_offer->import_hash = $import_hash;
            
            //Добавим базовую единицу если включена опция использовать единицы измерения комплектаций
            if ($this->getCatalogConfig()->use_offer_unit){
                $this->getBaseUnit($product_offer);
            }
            
            //Если установлен флаг уникализировать артикулы у комплектаций. Сложим артикул товара и уникальный "хвост"
            if ($this->getConfig()->unique_offer_barcode){
               $uniq_tail = strtoupper(mb_substr(md5($product_offer->xml_id), 0, 6));
               $product_offer->barcode = $this->getProductBarcodeByXMLId()."-".$uniq_tail;
            }
            
            // Записываем сериализованные Цены в pricedata
            $pricedata = array();
            if (isset($this->getSimpleXML()->Цены->Цена)) {
                foreach($this->getSimpleXML()->Цены->Цена as $one)
                {
                    $typecost = \Catalog\Model\Orm\Typecost::loadByWhere(array(
                        'site_id'   => \RS\Site\Manager::getSiteId(),
                        'xml_id' => $one->ИдТипаЦены,
                    ));
                    $currency = \Catalog\Model\Orm\Currency::loadByWhere(array(
                        'site_id'   => \RS\Site\Manager::getSiteId(),
                        'title'     => (string)$one->Валюта,
                    ));
                    $pricedata[$typecost->id] = array(
                        'znak'  => '=',
                        'original_value' => (string)$one->ЦенаЗаЕдиницу,
                        'unit'  => $currency->id
                    );
                }
            }
               
            $product_offer->pricedata_arr = array( 'price' => $pricedata );
            
            // Записываем сериализованные Характеристики в propsdata
            $props_nodes = $this->getSimpleXML()->ХарактеристикиТовара->ХарактеристикаТовара;
            if($props_nodes != null){
                $props = array();
                foreach($props_nodes as $one){
                    $props[Tools::toEntityString((string)$one->Наименование)] = Tools::toEntityString((string)$one->Значение);
                } 
                $product_offer->propsdata = serialize($props);
            }
            
            // Если схема больше 2.07 и Характеристики хранятся в файле import.xml и отсуствуют в offers.xml
            if(($props_nodes == null) && isset($_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_NO_OFFER_PARAMS_FLAG]) && $_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_NO_OFFER_PARAMS_FLAG]){
                // Флаг, что характеристики не используются и нужно нумеровать все характеристики от 0
                $product_offer->cml_207_no_offer_params = true; 
            }

            $stock_num = array();
            $summary_num = 0;
            // Записываем сведения о количества товара на складе, если сведения об этом присутствуют
            // Для версии 2.07
            $stock_node = $this->getSimpleXML()->Склад;
            if (!count($stock_node)) {
                //Для версии 2.05
                $stock_node = $this->getSimpleXML()->КоличествоНаСкладах->КоличествоНаСкладе;
            }else{
                $product_offer->cml_207_no_offer_params = true;
            }
            
            if (count($stock_node)) {
                \Exchange\Model\Log::w(t("Импорт остатков по складам для торгового предложения: ").$this->getSimpleXML()->Наименование);
                foreach ($stock_node as $one){
                    $warehouse_xml_id = (string)($one->ИдСклада ?: $one['ИдСклада']);
                    $warehouse_stock  = (int) preg_replace("/[^\d\.,^-]/", '', ($one->Количество ?: $one['КоличествоНаСкладе']));
                    $warehouse_id     = $this->getWarehouseByXMLId($warehouse_xml_id);
                    $stock_num[$warehouse_id]   = $warehouse_stock;
                    $summary_num += $warehouse_stock;
                }
            }
            
            
            //Если в XML не было тега <Количество> с общим остатком для комплектации, то считаем его самостоятельно 
            //суммируя остатки на складах
            if (!$product_offer->num) {
                $product_offer->num = $summary_num;
            }
            
            if (!count($stock_node)) {
                //Если информации по складам - нет, то привязываем остаток к складу по умолчанию
                $stock_num = array(
                    $default_warehouse_id => $product_offer['num']
                );
            }
            
            $product_offer['stock_num'] = $stock_num;
            
            //Поля которые, будут обновлены при совпадении строки
            $on_duplicate_update_fields = array_diff(array('title', 'barcode', 'pricedata', 'propsdata', 'num', 'processed', 'import_hash', 'sku'), (array)$this->getConfig()->dont_update_offer_fields);
            
            // Вставка _ИЛИ_ обновление товарного предложения (комплектации)
            //  $product['num'] += $product_offer->num;
            $product_offer->dont_reset_hash = true;
            $product_offer->insert(false, $on_duplicate_update_fields, array('site_id', 'xml_id'));
            // Получим настоящий sortn
            $product_offer['sortn'] = \RS\Orm\Request::make()
                                        ->select('sortn')
                                        ->from(new \Catalog\Model\Orm\Offer())
                                        ->where("id = {$product_offer->id}")
                                        ->exec()->getOneField('sortn');
            
            // Если это основная комплектация - обновим цены продукта
            if($product_offer['sortn'] == 0){
                \Exchange\Model\Log::w(t("Импортируем цены в таблицу product_x_cost для товара [id={$product->id}]"));

                // Импортируем цены в таблицу product_x_cost
                $excost_array = array();
                if (isset($this->getSimpleXML()->Цены->Цена)) {
                    foreach($this->getSimpleXML()->Цены->Цена as $one)
                    {
                        $typecost = \Catalog\Model\Orm\Typecost::loadByWhere(
                            array(
                                'xml_id'    => $one->ИдТипаЦены,
                                'site_id'   => \RS\Site\Manager::getSiteId(),
                            )
                        );
                        
                        $currency = \Catalog\Model\Orm\Currency::loadByWhere(
                            array(
                                'site_id'   => \RS\Site\Manager::getSiteId(),
                                'title'     => (string)$one->Валюта,
                            )
                        );
                        
                        $excost_array[$typecost->id] = array(
                            'cost_original_val'      => (string)$one->ЦенаЗаЕдиницу,
                            'cost_original_currency' => $currency->id
                        );
                    }
                }
                
                $product->excost = $excost_array;
                if (!empty($product_offer['barcode'])) {
                    $product['barcode'] = $product_offer['barcode'];
                }
                if (!empty($product_offer['sku'])) {
                    $product['sku'] = $product_offer['sku'];
                }
                $product->no_update_dir_counter = true;
                $product->is_exchange_action = true;
                $product->update();
            }
        }
    }
    
    
    /**
    * Импорт единиц измерения
    * 
    * @param \Catalog\Model\Orm\Offer $offer - комплектация
    */
    private function getBaseUnit(\Catalog\Model\Orm\Offer $offer)
    {
        if(!(string)$this->getSimpleXML()->БазоваяЕдиница){   // Если единицы нет, ничего не делаем
            return;
        }
        $code        = $this->getSimpleXML()->БазоваяЕдиница['Код'];
        $inter_sokr  = $this->getSimpleXML()->БазоваяЕдиница['МеждународноеСокращение'];
        $full_title  = $this->getSimpleXML()->БазоваяЕдиница['НаименованиеПолное'];
        $short_title = (string)$this->getSimpleXML()->БазоваяЕдиница;
        
        if (empty($full_title)){ //Если полного наименования не указано.
            $full_title = $short_title;
        }
        
        // Получаем идентификатор единицы изменерия по коду
        if (!empty($code)){    
            $unit_id = \Exchange\Model\Importers\CatalogProduct::getUnitIdByCode($code);    
        }elseif (!empty($short_title)){ // Получаем идентификатор единицы изменерия по полному наименованию
            $unit_id = \Exchange\Model\Importers\CatalogProduct::getUnitIdByName($short_title);  
        }
        
        if($unit_id === false){
            // Если единицы измерения еще нет - вставляем
            $unit = new \Catalog\Model\Orm\Unit();
            $unit->code     = $code;
            $unit->icode    = $inter_sokr;
            $unit->title    = $full_title;
            $unit->stitle   = $short_title;
            $unit->insert();
            $unit_id = $unit->id;
        }
        $offer->unit = $unit_id;
    }
    
    /**
    * Возвращает артикул товара к которой привязана комплектация
    * 
    */
    private function getProductBarcodeByXMLId($xml_id = false)
    {
        if (!$xml_id){
            $xml_id = $this->getProductXMLId();
        }
        if (!isset(self::$product_barcode_by_xml_id[$xml_id])){
            self::$product_barcode_by_xml_id[$xml_id] = \RS\Orm\Request::make()
                    ->select('barcode')
                    ->from(new \Catalog\Model\Orm\Product())
                    ->where(array(
                       'site_id' => \RS\Site\Manager::getSiteId(),
                       'xml_id' => $xml_id
                    ))->exec()
                    ->getOneField('barcode', '');
        }
        return self::$product_barcode_by_xml_id[$xml_id];
    }
    
    /**
    * Получает XML_ID товара из XML в файле
    */
    private function getProductXMLId()
    {
        // Получаем XML-идентификатор товара (первую часть до решетки)
        $xml_id = (string) $this->getSimpleXML()->Ид;
        $xml_id_arr = explode("#", $xml_id);
        return $xml_id_arr[0];
   }
   
   /**
   * Получает ID склада из базы и помещает значение в сессию 
   * 
   * @param string $xml_id - XML_ID склада
   */
   private function getWarehouseByXMLId($xml_id)
   {
       if (!isset($_SESSION[\Exchange\Model\Importers\Warehouse::SESS_KEY_WAREHOUSE_IDS][$xml_id])) {
          $id = \RS\Orm\Request::make()
                    ->from(new \Catalog\Model\Orm\WareHouse())
                    ->where(array(
                        'site_id' => \RS\Site\Manager::getSiteId(),
                        'xml_id'  => $xml_id,
                    ))
                    ->exec()
                    ->getOneField('id',0);
                    
          $_SESSION[\Exchange\Model\Importers\Warehouse::SESS_KEY_WAREHOUSE_IDS][$xml_id] = $id;
       }
      return $_SESSION[\Exchange\Model\Importers\Warehouse::SESS_KEY_WAREHOUSE_IDS][$xml_id];
   }
    
}