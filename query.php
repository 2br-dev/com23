<?php

define("DB_HOST", "localhost");
define("DB_USER", "akvatoria_new");
define("DB_PASSWORD", "38180067");
define("DB_DATABASE", "akvatoria_new");

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
	or die("Could not connect : " . mysql_error());

mysql_select_db(DB_DATABASE)
	or die("Could not select database");

$query_id = "SELECT id FROM akv_product WHERE maindir = 2";
$id = mysql_query($query_id) or die ("Query failed:" . mysql_error());


while($line = mysql_fetch_assoc($id)){

	foreach ($line as $key => $value) {
		print "<pre>$key - $value</pre>";
	}
}
//foreach ($product as $key => $value) {
	//print "<pre>$key</pre>";
//}

/*print "<table>\n";
while($line = mysql_fetch_array($result)){
	print "\t<tr>\n";
	foreach ($line as $key) {
		print "\t\t<td>$key</td>\n";
	}
	print "\t</tr>\n";
}
print "</table>\n"; */

mysql_free_result($result);
mysql_close($con);

?>


