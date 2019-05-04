<?php
namespace Test\Config;
 
class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this->bind('orm.init.catalog-product');
    }
     
    /**
    * Обработчик события "Инициализация ORM объекта Товар".
    * Не забудьте переустановить модуль каталог через меню Веб-сайт->Настройка модулей. Каталог товаров -> переустановить
    * 
    * @param \Catalog\Model\Orm\Product
    * @return void
    */
    public static function ormInitCatalogProduct(\Catalog\Model\Orm\Product $orm_product)
    {
        $orm_product->getPropertyIterator()->append(array( //Добавляем свойства к объекту
            'Сертификат', //Закладка, появится в форме редактирования товара
             
            'test_property' => new \RS\Orm\Type\RichText(array( //Тип поля.
                'description' => 'Текстовое поле', //Название поля
            )),
			
			'test_image' => new \RS\Orm\Type\Image(array(
				'max_file_size' => 10000000,
				'allow_file_types' => array('image/pjpeg', 'image/jpeg', 'image/png', 'image/gif'),
				'description' => 'Картинка'			
			))
        ));
    }
}