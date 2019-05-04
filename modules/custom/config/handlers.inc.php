<?php
namespace Custom\Config;

use \RS\Orm\Type;

/**
* Класс предназначен для объявления событий, которые будет прослушивать данный модуль и обработчиков этих событий.
*/
class Handlers extends \RS\Event\HandlerAbstract
{
    function init()
    {
        $this
            ->bind('api.product.getlist.success')
            ->bind('api.product.getlist.before')
            ->bind('api.product.getrecommendedlist.success')
            ->bind('api.favorite.getlist.before')
            ->bind('api.favorite.getlist.success');
    }

    /**
     * Добавляет минимальную и максимальную цену
     *
     * @param integer $product - id товара
     * @throws \RS\Db\Exception
     * @throws \RS\Event\Exception
     */
    public static function addProductMinMax(&$product)
    {
        $orm = new \Catalog\Model\Orm\Product($product['id']);
        $orm->fillCost();

        $product['cost_second_format'] = $orm->getCost('Цена от 2-х бутылей')." ".$orm->getCurrency();
        $product['cost_third_format']  = $orm->getCost('Цена от 4-х бутылей')." ".$orm->getCurrency();
    }

    /**
     * Подвешиваемся на получение списка товаров для мобильного приложения,
     *
     * @param array $data - массив данных
     * @return array
     * @throws \RS\Db\Exception
     * @throws \RS\Event\Exception
     */
    public static function apiFavoriteGetListBefore($data)
    {
        /**
         * @var \Catalog\Model\ExternalApi\Favorite\GetList $controller
         */
        $controller = $data['method'];
        $controller->favorite_api->queryObj()->where(array(
            'inStock' => 1
        ));
    }


    /**
     * Подвешиваемся на получение списка товаров для мобильного приложения,
     *
     * @param array $data - массив данных
     * @return array
     * @throws \RS\Db\Exception
     * @throws \RS\Event\Exception
     */
    public static function apiFavoriteGetListSuccess($data)
    {
        if (!empty($data['result']['response']['list'])){
            $list = $data['result']['response']['list'];
            foreach ($list as &$product) {
                self::addProductMinMax($product);
            }
            $data['result']['response']['list'] = $list;
        }
        return $data;
    }


    /**
     * Подвешиваемся на получение списка рекоммендуемых товаров для мобильного приложения,
     *
     * @param array $data - массив данных
     * @return array
     * @throws \RS\Db\Exception
     * @throws \RS\Event\Exception
     */
    public static function apiProductGetRecommendedListSuccess($data)
    {
        if (!empty($data['result']['response']['list'])){
            $list = $data['result']['response']['list'];
            foreach ($list as $k=>$product){
                if (!$product['inStock']){
                    unset($list[$k]);
                }
            }
            foreach ($list as &$product) {
                self::addProductMinMax($product);
            }

            $data['result']['response']['list'] = $list;
        }
        return $data;
    }

    /**
     * Подвешиваемся на получение списка товаров для мобильного приложения,
     *
     * @param array $data - массив данных
     * @return array
     * @throws \RS\Db\Exception
     * @throws \RS\Event\Exception
     */
    public static function apiProductGetListBefore($data)
    {
        /**
         * @var \Catalog\Model\ExternalApi\Product\GetList $controller
         */
        $controller = $data['method'];
        $controller->getDaoObject()->queryObj()->where(array(
            'inStock' => 1
        ));
    }

    /**
     * Подвешиваемся на получение списка товаров для мобильного приложения,
     *
     * @param array $data - массив данных
     * @return array
     * @throws \RS\Db\Exception
     * @throws \RS\Event\Exception
     */
    public static function apiProductGetListSuccess($data)
    {
        if (!empty($data['result']['response']['list'])){
            $list = $data['result']['response']['list'];
            foreach ($list as &$product) {
                self::addProductMinMax($product);
            }
            $data['result']['response']['list'] = $list;
        }
        return $data;
    }
}