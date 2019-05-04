<?php
/*
require('setup.inc.php');

$user = \Users\Model\Orm\User::loadByWhere(array('e_mail' => 'super@super.ru'));

$user['name'] = 'super';
$user['surname'] = 'super';
$user['e_mail'] = 'super@super.ru';
$user['changepass'] = true;

$user['login'] = 'super@super.ru';
$user['openpass'] = 'gfhjkm32';

$user['phone'] = '1234567';

$user['no_send_notice'] = true;

if (!empty($user['id'])) {
    $res = $user->update();
} else {
    $res = $user->insert();
}

if ($res) {
    var_dump('success');
} else {
    var_dump($user->getErrors());
}
$user->linkGroup(array('supervisor'));
*/