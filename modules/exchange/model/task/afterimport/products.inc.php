<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Exchange\Model\Task\AfterImport;
use \Exchange\Model\Log;

/**
* Объект этого класса хранится в сессии, соотвественно все свойства объекта доступны 
* не только до окончания выполнения скрипта, но и в течении всей сессии
*/

class Products extends \Exchange\Model\Task\AbstractTask
{
    const DELETE_LIMIT = 100; // По сколько удалять продуктов за один раз
    
    protected 
        $productPartNum = 1000, //Количество товаров для обработки вконце импорта
        $filename;  
    
    
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    
    public function exec($max_exec_time = 0)
    {
        // выполняем действия после завершения импорта
        if(preg_match('/offers/iu',$this->filename)) {
            Log::w(t("Обновляем типы свойств и общий остаток товаров после загрузки offers.xml"));
            // Обновим типы свойств, если есть условие и строковые множественные свойства 
            $this->updatePropTypes();
            // Обновим количество товаров у которых есть в наличии комплектации
            $this->updateNumByOffers();
            // Обновление всех брендов из характеристик, если задан параметр "Производитель" в модуле обмена с 1С
            $config = \RS\Config\Loader::byModule($this);
            if ($config['brand_property']){
               $this->updateAllBrands($config['brand_property']); 
               $this->updateBrandsInProducts($config['brand_property']);
            }
            if (!$config['dont_delete_prop']){ //Удалять ли характеристику созданную на сайте
                $this->deletePropsCreatedOnSite();
            }
            //Удалим комплектации, которые есть у товара, но в 1С их уже нет.
            $this->deleteOffersNotUsedInProducts();
            
            //Для некоторых версий CommerceML обновим сортировочный индекс комплектаций
            $this->setOffersRightSortnIfNeed();
            
            if($config['sort_offers_by_title']){
                $this->setOffersSortnByTitle();
            }

            //Обновляем счетчики у категорий
            \Catalog\Model\Dirapi::updateCounts();
        }
        
        //Вызовем хук
        \RS\Event\Manager::fire('exchange.task.afterimport.products', array(
            'filename' => $this->filename
        )); 
            
        // Только для import.xml
        if(!preg_match('/import/iu', $this->filename)){ 
            Log::w(t("Ничего не делаем, так как это не import.xml"));
            return true;
        }

        // Если классификатор содержит только изменения, то ничего не делаем
        if(\Exchange\Model\Importers\Catalog::containsOnlyChanges()){
            Log::w(t("Ничего не делаем, так как классификатор содержит только изменения"));
            return true;
        }
        
        $config = \RS\Config\Loader::byModule($this);
        
        // Если установлена настройка "Что делать с элементами, отсутствующими в файле импорта -> Ничего не делать"
        if($config->catalog_element_action == \Exchange\Config\File::ACTION_NOTHING){
            Log::w(t("Ничего не делаем, так как установлена настройка Ничего не делать c элементами, отсутсвующими в файле импорта"));
            return true;
        }
        
        // Если установлена настройка "Что делать с элементами, отсутствующими в файле импорта -> Обнулять остаток"
        if($config->catalog_element_action == \Exchange\Config\File::ACTION_CLEAR_STOCKS){
            Log::w(t("Обнуляем остаток товаров, которые не учавствуют в файле импорта..."));
            // Получаем id товаров, не участвовавших в импорте
            $ids = \RS\Orm\Request::make()
                    ->select('id')
                    ->from(new \Catalog\Model\Orm\Product())
                    ->where(array(
                        'site_id'   => \RS\Site\Manager::getSiteId(),
                        'processed' => null,
                    ))
                    ->where('xml_id > ""')
                    ->exec()
                    ->fetchSelected(null, 'id');
            
            // Если есть товары, не участвовавшие в импорте - удалим линки остатков, кэш остатков у комплектаций и товаров
            if (!empty($ids)) {
                \RS\Orm\Request::make()
                    ->delete()
                    ->from(new \Catalog\Model\Orm\Xstock())
                    ->whereIn('product_id', $ids)
                    ->exec();
                \RS\Orm\Request::make()
                    ->update(new \Catalog\Model\Orm\Offer())
                    ->set(array('num' => 0))
                    ->whereIn('product_id', $ids)
                    ->exec();
                \RS\Orm\Request::make()
                    ->update(new \Catalog\Model\Orm\Product())
                    ->set(array('num' => 0))
                    ->whereIn('id', $ids)
                    ->exec();
            }
            
            return true;
        }
        
        // Если установлена настройка "Что делать с элементами, отсутствующими в файле импорта -> Удалять"
        if($config->catalog_element_action == \Exchange\Config\File::ACTION_REMOVE)
        {
            Log::w(t("Удаление товаров, которые не учавствуют в файле импорта..."));
            $apiCatalog = new \Catalog\Model\Api();

            while(true)
            {
                $ids = \RS\Orm\Request::make()
                    ->select('id')
                    ->from(new \Catalog\Model\Orm\Product())
                    ->where(array(
                        'site_id'   => \RS\Site\Manager::getSiteId(),
                        'processed' => null,
                    ))
                    ->where('xml_id > ""')
                    ->limit(self::DELETE_LIMIT)
                    ->exec()
                    ->fetchSelected(null, 'id');
                
                // Если не осталось больше товаров для удаления
                if(empty($ids)){
                    Log::w(t("Нет больше товаров для удаления"));
                    return true;
                }
                
                // Если превышено время выполнения
                if($this->isExceed()){
                    Log::w(t("Превышено время выполнения"));
                    return false;
                }
                
                $apiCatalog->multiDelete($ids);
                
            }
        }
        
        // Если установлена настройка "Что делать с элементами, отсутствующими в файле импорта -> Деактивировать"
        if($config->catalog_element_action == \Exchange\Config\File::ACTION_DEACTIVATE)
        {
            Log::w(t("Деактивация товаров, которые не учавствуют в файле импорта..."));

            // Скрываем товары
            $affected = \RS\Orm\Request::make()
                ->update(new \Catalog\Model\Orm\Product())
                ->set(array('public' => 0))
                ->where(array( 
                    'site_id'   => \RS\Site\Manager::getSiteId(),
                    'processed' => null,
                ))
                ->where('xml_id > ""')
                ->exec()->affectedRows();
            Log::w(t("Деактивировано товаров: ").$affected);
            return true;
        }
        
        throw new \Exception('Impossible 2!');
   }
   
   /**
   * Для некоторых версий CommerceML, где в комплектациях нет указания признака нулевой комплектации нужно обновить сортировочный индекс, который начинается с 1
   * 
   */
   private function setOffersRightSortnIfNeed()
   {
       $site_id = \RS\Site\Manager::getSiteId(); //текущий id сайта
       
       //Получим подзапрос
       $sub_query = \RS\Orm\Request::make()
                ->from(new \Catalog\Model\Orm\Offer(), 'B')
                ->where(array(
                    'B.sortn' => 0,
                ))
                ->where('B.product_id=A.product_id')->toSql(); 
       
       //Получим подзапрос с выборкой нужных элементов, где только товары без нулевой комплектации
       $product_ids = \RS\Orm\Request::make()
                ->select('A.product_id')
                ->from(new \Catalog\Model\Orm\Offer(), 'A')
                ->where(array(
                    'A.site_id' => $site_id,
                ))
                ->where('A.sortn>0 AND NOT EXISTS ('.$sub_query.')')
                ->groupby('product_id')
                ->exec()
                ->fetchSelected(null, 'product_id');
       \Exchange\Model\Log::w(t("Найдено товаров ").count($product_ids).t(" у которых нет нулевых комлектаций")); 
                
       
                
       //Если у нас есть уже набор товаров          
       if (!empty($product_ids)){
           
           // Разделим на части обработку
            $offset = 0;
            $part_ids   = array_slice($product_ids, $offset, $this->productPartNum);//id изменённых товаров
            while(!empty($part_ids)) {
               
               //Обновим записи сортировки уменьших сортировочный индекс где это нужно
               \RS\Orm\Request::make()
                        ->update()
                        ->from(new \Catalog\Model\Orm\Offer())
                        ->set('sortn=sortn-1')
                        ->whereIn('product_id', $part_ids)
                        ->exec(); 
                
               $offset += $this->productPartNum;
               $part_ids = array_slice($product_ids, $offset, $this->productPartNum);
           }
           \Exchange\Model\Log::w(t("Обновление товаров у которых нет нулевых комлектаций")); 
       }
   }
   
    /**
   * Сортировка комплектаций по наименованию (Natural Sort)
   * 
   * @return void
   */
    private function setOffersSortnByTitle(){
        // Получаем id продуктов, у которых были изменения в комплектациях
        $offer = new \Catalog\Model\Orm\Offer();             
        
        $products_id = \RS\Orm\Request::make()
                ->select('product_id')
                ->from($offer, 'O')
                ->where(array(
                    'O.site_id' => \RS\Site\Manager::getSiteId(),
                    'O.processed' => 1
                ))
                ->exec()
                ->fetchSelected('product_id', 'product_id');
                
        // Сортируем комлектации у полученых продуктов
        foreach($products_id as $id){
            
            // Выбираем все комплектации продукта
            $sort_arr = \RS\Orm\Request::make()
                    ->select('id, title')
                    ->from($offer, 'O')
                    ->where(array(
                        'O.product_id' => $id
                    ))
                    ->exec()
                    ->fetchSelected('id', 'title');
                    
            natsort($sort_arr);
                                       
            $i = 0;
            $val_str = array();
            foreach($sort_arr as $key => $title){
                $val_str[] = '('. $key . ',' . $i++ .')';
            }
            // Обновляем порядковые номера у комплектаций
            $query = 'INSERT INTO ' . $offer->_getTable() . ' (id, sortn) VALUES ' . implode(',', $val_str) . ' ON DUPLICATE KEY UPDATE sortn=VALUES(sortn);';
            \RS\Db\Adapter::sqlExec($query);
        }  
    }
   
   /**
   * Обновление всех брендов на основании значений характеристики
   * Функция сравнивает новые значения со старыми и если есть несовпадения, то удаляет их.
   * 
   * @param integer $brand_prop_id - id характеристики "Производителя"
   */
   private function updateAllBrands($brand_prop_id)
   {
      //Получим текущие бренды
      $brands = \RS\Orm\Request::make()
            ->select('title')
            ->from(new \Catalog\Model\Orm\Brand())
            ->where(array(
                'site_id' => \RS\Site\Manager::getSiteId(),
            ))->exec()
            ->fetchSelected(null,'title',false);
            
      
      //Получим доступные значения характеристики производителя
      $props = \RS\Orm\Request::make()
            ->select('DISTINCT (val_str) as val_str')
            ->from(new \Catalog\Model\Orm\Property\Link())
            ->where(array(
                'site_id' => \RS\Site\Manager::getSiteId(),
                'prop_id' => $brand_prop_id,
            ))
            ->where("val_str <> ''")
            ->exec()
            ->fetchSelected(null,'val_str',false);
      
      $new_brands = array_diff($props,$brands);      
      
      //Если есть различия, и появились новые бренды
      if (!empty($new_brands)){
         foreach($new_brands as $brand_title){
             $brand = new \Catalog\Model\Orm\Brand();
             $brand['title']  = $brand_title;
             $brand['alias']  = \RS\Helper\Transliteration::rus2translit($brand_title);
             $brand['public'] = 1;
             $brand->insert();
         } 
      } 
      
      \Exchange\Model\Log::w(t("Обновление сведений о брендах")); 
   }
   
   /**
   * Обновляет id брендов у товаров
   * 
   * @param integer $brand_prop_id - id характеристики "Производителя"
   */
   private function updateBrandsInProducts($brand_prop_id)
   {
      $prop  = new \Catalog\Model\Orm\Property\Link(); 
      $brand = new \Catalog\Model\Orm\Brand();
      
      try{
         $brand_query = '
             (SELECT B.id FROM '.$prop->_getTable().' AS L
                INNER JOIN '.$brand->_getTable().' AS B ON B.title = L.val_str
                WHERE prop_id='.$brand_prop_id.' AND B.site_id='.\RS\Site\Manager::getSiteId().' AND L.val_str != "" AND L.product_id = P.id LIMIT 1)
          ';
           
          $q = \RS\Orm\Request::make()
                ->update()
                ->from(new \Catalog\Model\Orm\Product(),'P')
                ->set('brand_id = '.$brand_query)
                ->where(array(
                    'P.site_id' => \RS\Site\Manager::getSiteId(),
                ))->exec(); 
      }catch(\Exception $e){
          if ($e->getCode() == 1242){          
            throw new \Exception(t('Ошибка при обновлении брендов у товара! 
            Убедитесь, что характеристика бренда имеет строковый тип.')
            ,$e->getCode());  
          }else{
            throw $e; 
          }
      } 
      \Exchange\Model\Log::w(t("Обновление брендов у товаров")); 
   }
   
   /**
   * Находит комплектации товара, которые отсуствуют в 1С, а на сайте ещё присутствуют и удаляет их
   * 
   */ 
   private function deleteOffersNotUsedInProducts(){
      \Exchange\Model\Log::w(t("Удаление комплектаций, которые отсутствуют в 1С, но есть на сайте"));   
      $offers_ids = (array)\RS\Orm\Request::make()
            ->select('O.id')
            ->from(new \Catalog\Model\Orm\Product(),'P')
            ->join(new \Catalog\Model\Orm\Offer(),"O.product_id=P.id","O")
            ->where(array(
                'P.site_id'   => \RS\Site\Manager::getSiteId(),
                'P.processed' => 1,
            ))
            ->where('O.processed IS NULL')
            ->exec()
            ->fetchSelected(null,'id');
            
      if (!empty($offers_ids)){
          \RS\Orm\Request::make()
                ->from(new \Catalog\Model\Orm\Offer())
                ->whereIn('id',$offers_ids)
                ->delete()
                ->exec();
      }
   }
   
   /**
   * Удаляет характеристики созданные на сайте
   * 
   */
   private function deletePropsCreatedOnSite()
   {
      \Exchange\Model\Log::w(t("Удаление характеристик созданных на сайте"));  
      \RS\Orm\Request::make()
          ->from(new \Catalog\Model\Orm\Property\Item())
          ->where(array(
              'site_id' => \RS\Site\Manager::getSiteId()
          ))
          ->where('xml_id IS NULL')
          ->delete()
          ->exec();
   }
   
   /**
    * Обновит количество товаров у которых есть в наличии комплектации комплектации.
    * Товары будут братся из сессии
    * 
    * @return void
    */
    private function updateNumByOffers()
    {
        if (!isset($_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_GOODS_IDS])){ //Если товаров для обновления не существует
            return false;
        }
        Log::w(t("Количество товаров обновления - ").count($_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_GOODS_IDS]));
        if (!empty($_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_GOODS_IDS])) {
            // Разделим на части обработку
            $offset = 0;
            $part_ids   = array_slice($_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_GOODS_IDS],$offset,$this->productPartNum);//id изменённых товаров
            $offer  = new \Catalog\Model\Orm\Offer();
            while(!empty($part_ids)) {
               
               // Собственно обновим количество товара
               $q = \RS\Orm\Request::make()
                    ->from(new \Catalog\Model\Orm\Product(),"P")
                    ->set("
                        P.num = (SELECT sum(num) as num FROM ".$offer->_getTable()." as O
                                    WHERE O.product_id = P.id AND O.site_id=".\RS\Site\Manager::getSiteId().")"
                    )
                    ->whereIn('id',$part_ids)
                    ->update()
                    ->exec();
               
                
               $offset += $this->productPartNum;
               $part_ids   = array_slice($_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_GOODS_IDS],$offset,$this->productPartNum);
            }
            $config = \RS\Config\Loader::byModule($this); //Загружаем конфиг
            // Проверим, выключен ли импорт многомерных комплектаций из 1С
            if (!$config['allow_insert_multioffers']) {
               // Очистим сессию
               unset($_SESSION[\Exchange\Model\Importers\CatalogProduct::SESS_KEY_GOODS_IDS]); 
            }
            
        }
        \Exchange\Model\Log::w(t("Обновление количества товаров комплектаций у товаров")); 
    }
            
    /**
    * Обновит типы свойств, если есть условие и строковые множественные свойства 
    * 
    * @return void
    */
    private function updatePropTypes() 
    {
        $config = \RS\Config\Loader::byModule($this); //Загружаем конфиг
        $separator = $config['multi_separator_fields']; //Получаем разделитель множественного свойства 
        
        if (!empty($separator)){ //Если разделитель задан и есть свойства для обновления, то обновим
            $props_ids = \Exchange\Model\Importers\CatalogProduct::getPropertiesToUpdate(); //Получаем свойства для обновления 
            
            foreach($props_ids as $property_id) {
                $property = new \Catalog\Model\Orm\Property\Item($property_id);
                if (!in_array($property['type'], \Catalog\Model\Orm\Property\Item::getListTypes())) {
                    //Обновим в базе тип характеристики
                    \RS\Orm\Request::make()
                        ->update($property)
                        ->set(array(
                            'type' => \Catalog\Model\Orm\Property\Item::TYPE_LIST
                        ))->exec();
                }
            }
        }
    }
}