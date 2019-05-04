<?php
    require_once('setup.inc.php');

    $sub_query = \RS\Orm\Request::make()
                    ->select('SUM(amount_bottle_inOrder)')
                    ->from(new \Shop\Model\Orm\OrderItem(), "I")
                    ->where(array(
                        'I.type' => 'product'
                    ))
                    ->where('amount_bottle_inOrder > 0')
                    ->where('O.id = I.order_id')
                    ->groupby('order_id')
                    ->toSql();

    \RS\Orm\Request::make()
        ->update()
        ->from(new \Shop\Model\Orm\Order(), "O")
        ->set("amount_bottles = (".$sub_query.")")
        ->exec();