<?php
/**
 * Файл служит проверкой доступа по сессии,
 */
$user = \RS\Application\Auth::getCurrentUser();
if( !$user->isAdmin() ) {
	echo 'Отказано в доступе ';
	exit();
}

