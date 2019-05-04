<?php
namespace Brbr\Model;

class Api extends \RS\Module\AbstractModel\EntityList
{
    function __construct()
    {
        parent::__construct(new \Brbr\Model\Orm\Vote(), array(
            'multisite' => true
        ));
    }

    /**
     * Возвращает список отфильтрованный по категории
     *
     * @return \Brbr\Model\Orm\Vote[]
     * @throws \RS\Orm\Exception
     */
    function getKonkursListByCategory()
    {
        $list = \RS\Orm\Request::make()
                    ->from(new \Brbr\Model\Orm\Vote())
                    ->where(array(
                        'site_id' => \RS\Site\Manager::getSiteId()
                    ))
            ->orderby('category ASC, id ASC')
            ->objects(null, 'category', true);

        return $list ? $list : array();
    }
}