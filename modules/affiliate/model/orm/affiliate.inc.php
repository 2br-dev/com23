<?php
/**
* ReadyScript (http://readyscript.ru)
*
* @copyright Copyright (c) ReadyScript lab. (http://readyscript.ru)
* @license http://readyscript.ru/licenseAgreement/
*/
namespace Affiliate\Model\Orm;
use \RS\Orm\Type;

/**
* Объект - филиал
*/
class Affiliate extends \RS\Orm\OrmObject
{
    protected static
        $table = 'affiliate';
    
    function _init()
    {
        parent::_init()->append(array(
            t('Основные'),
                'site_id' => new Type\CurrentSite(),
                'title' => new Type\Varchar(array(
                    'description' => t('Наименование(регион или город)'),
                    'checker' => array('ChkEmpty', t('Укажите URL имя')),
                    'attr' => array(array(
                                    'data-autotranslit' => 'alias'
                                )),
                    'meVisible' => false,
                    'index' => true
                )),
                'alias' => new Type\Varchar(array(
                    'description' => t('URL имя'),
                    'meVisible' => false,
                    'checker' => array('ChkEmpty', t('Укажите URL имя'))
                )),
                'parent_id' => new Type\Integer(array(
                    'description' => t('Родитель'),
                    'list' => array(array('\Affiliate\Model\AffiliateApi', 'staticRootList'))
                )),
                'clickable' => new Type\Integer(array(
                    'description' => t('Разрешить выбор данного филиала'),
                    'default' => 1,
                    'checkboxView' => array(1,0),
                    'hint' => t('Если снять флажок, то элемент будет считаться группой филиалов, которую нельзя выбрать'),
                )),
                'cost_id' => new Type\Integer(array(
                    'description' => t('Тип цен'),
                    'list' => array(array('\Catalog\Model\CostApi', 'staticSelectList'), array(0 => t('Не выбрано'))),
                    'hint' => t('Выбранный тип цен будет являться типом цен по-умолчанию, при выборе данного филиала'),
                )),
                'short_contacts' => new Type\Text(array(
                    'description' => t('Краткая контактная информация')
                )),
                'contacts' => new Type\Richtext(array(
                    'description' => t('Контактная информация')
                )),
                'coord_lng' => new Type\Decimal(array(
                    'maxLength' => 10,
                    'decimal' => 6,
                    'description' => t('Долгота'),
                    'allowempty' => true,
                    'requestType' => 'string',
                    'visible' => false,
                )),
                'coord_lat' => new Type\Decimal(array(
                    'maxLength' => 10,
                    'decimal' => 6,            
                    'description' => t('Широта'),
                    'allowempty' => true,
                    'visible' => false,
                    'requestType' => 'string',
                )),
                '_geo' => new Type\Mixed(array(
                    'description' => t('Расположение на карте'),
                    'visible' => true,
                    'template' => '%affiliate%/form/affiliate/geo.tpl'
                )),
                'skip_geolocation' => new Type\Integer(array(
                    'maxLength' => 1,
                    'description' => t('Не выбирать данный филиал с помощью геолокации'),
                    'default' => 0,
                    'allowEmpty' => false,
                    'checkboxView' => array(1,0)
                )),
                'sortn' => new Type\Integer(array(
                    'maxLength' => '11',
                    'description' => t('Порядк. №'),
                    'visible' => false,
                )),            
                'is_default' => new Type\Integer(array(
                    'maxLength' => 1,
                    'description' => t('Филиал по умолчанию'),
                    'meVisible' => false,
                    'checkboxView' => array(1,0),
                    'allowEmpty' => false,
                    'hint' => t('Будет выбран, если ни один филиал по геолокации не будет определен')
                )),
                'is_highlight' => new Type\Integer(array(
                    'maxLength' => 1,
                    'description' => t('Выделить филиал визуально'),
                    'checkboxView' => array(1,0)
                )),
                'public' => new Type\Integer(array(
                    'description' => t('Публичный'),
                    'default' => 1,
                    'checkboxView' => array(1,0)
                )),
            t('Мета-тэги'),
                'meta_title' => new Type\Varchar(array(
                    'maxLength' => '1000',
                    'description' => t('Заголовок'),
                )),
                'meta_keywords' => new Type\Varchar(array(
                    'maxLength' => '1000',
                    'description' => t('Ключевые слова'),
                )),
                'meta_description' => new Type\Varchar(array(
                    'maxLength' => '1000',
                    'viewAsTextarea' => true,
                    'description' => t('Описание'),
                ))
        ));
        
        $this->addIndex(array('site_id', 'alias'), self::INDEX_UNIQUE);
    }
    
    /**
    * Возвращает отладочные действия, которые можно произвести с объектом
    * 
    * @return RS\Debug\Action[]
    */
    public function getDebugActions()
    {
        return array(
            new \RS\Debug\Action\Edit(\RS\Router\Manager::obj()->getAdminPattern('edit', array(':id' => '{id}'), 'affiliate-ctrl')),
            new \RS\Debug\Action\Delete(\RS\Router\Manager::obj()->getAdminPattern('del', array(':chk[]' => '{id}'), 'affiliate-ctrl'))
        );
    }    
    
    function beforeWrite($flag)
    {        
        if ($this['coord_lng'] === '') $this['coord_lng'] = null;
        if ($this['coord_lat'] === '') $this['coord_lat'] = null;
        
        if ($flag == self::INSERT_FLAG && !$this->isModified('sortn'))
        {
            $q = \RS\Orm\Request::make()
                ->select('MAX(sortn) max_sort')
                ->from($this)
                ->where(array(
                    'site_id' => $this['site_id'],
                    'parent_id' => $this['parent_id'],
                ));
                
                $this['sortn'] = $q->exec()
                ->getOneField('max_sort', -1) + 1;
        }
    }
    
    function afterWrite($flag)
    {
        if ($this['is_default']) {
            //Флаг "по умолчанию", может быть только у одного филиала в рамках сайта
            \RS\Orm\Request::make()
                ->update($this)
                ->set('is_default = 0')
                ->where(array(
                    'site_id' => $this['site_id']
                ))
                ->where("id != '#id'", array('id' => $this['id']))
                ->exec();
        }
    }
    
    function delete()
    {
        if ($result = parent::delete()) {
            //Удаляем у складов ссылку на данный филиал
            \RS\Orm\Request::make()
                ->update(new \Catalog\Model\Orm\WareHouse())
                ->set(array('affiliate_id' => 0))
                ->where(array(
                    'affiliate_id' => $this['id']
                ))->exec();
        }
        return $result;
    }
    
    function cloneSelf()
    {
        $clone = parent::cloneSelf();
        unset($clone['alias']);
        return $clone;
    }
}