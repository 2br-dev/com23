<?php

// Переменные из формы голосования
$mark = $_POST['mark'];
$comment = $_POST['comment'];
$vote_id = $_POST['vote_id'];

$coockie_life_time = 155520000; //Время жизни куков 60 * 60 * 24 * 30 * 6 = 155520000 - 0.5 года
$user_ip = $_SERVER['REMOTE_ADDR'];

$error = array(); // Ошибка - такой пользователь уже голосовал

// подключение к бд
$hostname = "localhost";
$db_user = "akvatoria_new";
$db_name = "akvatoria_new";
$db_password = "38180067";

$link = mysql_connect($hostname, $db_user, $db_password) or die("Cannot connect to the database");
mysql_select_db($db_name) or die("Cannot select the database");

$query = "SELECT * FROM `akv_vote`";
$result = mysql_query($query);

// Проверяем - голосовал ли этот пользователь ранее
if (mysql_num_rows($result)>0){
	while ($data_vote = mysql_fetch_assoc($result)) {
		if ($data_vote['user'] == $user_ip){
			$error['old_user'] = 1;
			$error['success'] = 0;			
		}
	}
}

// если пользователь не голосовал - то записываем результат в бд
if ($error['old_user'] != 1){
	mysql_query("INSERT INTO `akv_vote` SET `user` = '".$_SERVER['REMOTE_ADDR']."', `mark` = '".$mark."', `comment` = '".$comment."'");
	// Устанавливаем куки
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != ""){
		$hash =	md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_X_FORWARDED_FOR']).$vote_id;
	}
	else{
		$hash =	md5($_SERVER['REMOTE_ADDR']).$vote_id;		
	}

	$coockie_param = "vote_".$vote_id;
	setcookie($coockie_param, $hash, time()+$coockie_life_time);
	$error['success'] = 1;
	$error['old_user'] = 0;	
}

else {
	// Устанавливаем куки
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != ""){
		$hash =	md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_X_FORWARDED_FOR']).$vote_id;
	}
	else{
		$hash =	md5($_SERVER['REMOTE_ADDR']).$vote_id;		
	}

	$coockie_param = "vote_".$vote_id;
	setcookie($coockie_param, $hash, time()+$coockie_life_time);	
}

echo json_encode($error);

