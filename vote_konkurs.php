<?php
// если куки не установлены - то устанавливаем, иначе DIE
$category           =   $_POST['category'];
$for                =   $_POST['id'];
$coockie_life_time  =   60 * 60 * 24 * 30;
$session_id         =   $_COOKIE['PHPSESSID'];
$ip                 =   $_SERVER['REMOTE_ADDR'];



if ($category == 'young') {
  if($_COOKIE['vote_young'] != 'voted') {
    setcookie('vote_young', 'voted', time() + $coockie_life_time);
  } else {
    echo 'voted';
    die();
  } 
}
if ($category == 'old') {
  if($_COOKIE['vote_old'] != 'voted') {
    setcookie('vote_old', 'voted', time() + $coockie_life_time); 
  } else {
    echo 'voted';
    die();
  }  
}


// подключение к бд
$servername = "localhost";
$username = "akvatoria_new";
$dbname = "akvatoria_new";
$password = "38180067";
    
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}   



// циклично назначаем переменные, чтобы выводить в результате в шаблоне
if ($_COOKIE['vote_young'] == 'voted') {
  for ($i = 1; $i <= 6; $i++) {
    $count = "SELECT * FROM `akv_vote` WHERE `vote` = '$i' AND `vote_category` = 'young'";
    $result = mysqli_query($conn, $count);
    ${'result_young_'.$i} = mysqli_num_rows($result);
  }
}
if ($_COOKIE['vote_old'] == 'voted') {
  for ($i = 1; $i <= 6; $i++) {
    $count = "SELECT * FROM `akv_vote` WHERE `vote` = '$i' AND `vote_category` = 'old'";
    $result = mysqli_query($conn, $count);
    ${'result_old_'.$i} = mysqli_num_rows($result);
  }
}

// проверяем есть ли запись ID сессии в БД, если нет то DIE

$voted_session = "SELECT * FROM `akv_vote` WHERE `session` = '$session_id' AND `vote_category` = '$category'";
$result = mysqli_query($conn, $voted_session);
$num_rows = mysqli_num_rows($result);
if ($num_rows != 0) {
  echo "voted";
  die();
}    
// тоже самое с IP
$voted_ip = "SELECT * FROM `akv_vote` WHERE `ip` = '$ip' AND `vote_category` = '$category'";
$result = mysqli_query($conn, $voted_ip);
$num_rows = mysqli_num_rows($result);
if ($num_rows != 0) {
  echo "voted";
  die();
}   
//записываем голос в БД
$sql = "INSERT INTO `akv_vote` (`for`, `ip`, `vote`, `vote_category`, `session`) VALUES ('$for', '$ip', 1, '$category','$session_id')";
if ($conn->query($sql) === true) {
  echo "success";
} 
$conn->close();

?>