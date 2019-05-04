<?php
namespace Eridan\Config;
use \RS\Orm\Type;

/**
* Кофигурационный файл для дополнительного модуля
*/
class File extends \RS\Orm\ConfigObject
{
	function _init()
    {
         parent::_init()->append(array(    
            'water_dir_id' => new Type\Integer(array(
                'description' => t('Категория, в которой располагается вода для сайта com23.ru'),
                'hint' => t('Товары из этой категории имеют градацию цен'),
                'list' => array(array('\Catalog\Model\Dirapi','staticSelectList')),
            )),
            
            'bottle_id' => new Type\Integer(array(
                'description' => t('id товара бутылка для сайта com23.ru'),
            )),
            
            'online_payment' => new Type\Integer(array(
                'description' => t('онлайн оплаты'),
                'list' => array(array('\Shop\Model\PaymentApi','staticSelectList')),
            )),
            'remote_region_product_id' =>new Type\Integer(array(
                'description' => t('Доплата за доставку в отдаленный район')
            )),
            'discount_day' => new Type\Integer(array(
                'description' => t('День для льготной цены'),
                'listFromArray' => array(array(
                    0 => t('Воскресение'),
                    1 => t('Понедельник'),
                    2 => t('Вторник'),
                    3 => t('Среда'),
                    4 => t('Четверг'),
                    5 => t('Пятница'),
                    6 => t('Суббота')
                ))
            )),
            'discount_product_id' =>new Type\Integer(array(
                 'description' => t('Товар для льготной категории')
            )),  
        ));
    }

    /**
     * Возвращает объект бутылки
     *
     * @return \Catalog\Model\Orm\Product
     */
    function getBottleProduct()
    {
        return new \Catalog\Model\Orm\Product($this['bottle_id']);
    }	
}
?>