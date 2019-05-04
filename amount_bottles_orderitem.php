<?php
    require_once('setup.inc.php');
    /*
    \RS\Orm\Request::make()
        ->update()
        ->from(new \Shop\Model\Orm\OrderItem(), 'I')
        ->set("amount_bottle_inOrder = 0")
        ->exec();

    exit();
    */

    $config = \RS\Config\Loader::byModule('eridan');
    $product_water_id = $config['water_dir_id'];
    $empty_bottle_id = $config['bottle_id'];
    $sub_query = \RS\Orm\Request::make()
                    ->select('I.amount')
                    ->from(new \Catalog\Model\Orm\Product(), 'P')
                    ->where(array(
                        'P.maindir' => $product_water_id
                        )
                    )
                    ->where("P.maindir <>".$empty_bottle_id."")
                    ->where('P.id = I.entity_id')
                    ->where(array(
                        'I.type' => 'product'
                    ))
                    ->toSql();

    \RS\Orm\Request::make()
                    ->update()
                    ->from(new \Shop\Model\Orm\OrderItem(), 'I')
                    ->set("amount_bottle_inOrder = (".$sub_query.")")
                    ->exec();
