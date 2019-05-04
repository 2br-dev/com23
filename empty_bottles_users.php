<?php
    require_once('setup.inc.php');

    \RS\Orm\Request::make()
        ->update()
        ->from(new \Users\Model\Orm\User(), "u")
        ->set("empty_bottle = -1")
        ->exec();