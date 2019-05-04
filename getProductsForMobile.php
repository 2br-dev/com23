<?php

// подключение к бд
$hostname = "localhost";
$db_user = "akvatoria_new";
$db_name = "akvatoria_new";
$db_password = "38180067";

$link = mysql_connect($hostname, $db_user, $db_password) or die("Cannot connect to the database");
mysql_select_db($db_name) or die("Cannot select the database");

$query = "SELECT `product`.`id`, `product`.`title` 
		  FROM `akv_product` as `product`
		  
		  WHERE `product`.`public` = 1 
		  AND `product`.`site_id` = 1
		  AND `product`.`maindir` = 2";


$result = mysql_query($query);

$a = array();
$b = array();

if (mysql_num_rows($result)>0){
	while ($row = mysql_fetch_assoc($result)) {		
		//print "<pre>" . json_encode($data_vote, 64 | 256) . "</pre>";
		$b["productId"] = $row["id"];
        $b["productTitle"] = $row["title"];
        $b["productImage"] = "R.drawable.". $row['id'];
        array_push($a,$b);
	}

	echo json_encode($a, 64 | 256);
}

?>