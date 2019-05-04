<?php

define("DB_HOST", "localhost");
define("DB_USER", "akvatoria_new");
define("DB_PASSWORD", "38180067");
define("DB_DATABASE", "akvatoria_new");

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
	or die("Could not connect : " . mysql_error());

mysql_select_db(DB_DATABASE)
	or die("Could not select database");

$query = "SE:ECT * FROM 'akv_product'";
$result = mysql_query($query) or die ("Query failed:" . mysql_error());

print "<table>\n";
while($line = mysql_fetch_array($result)){
	print "\t<tr>\n";
	foreach ($line as $key) {
		print "\t\t<td>$key</td>\n";
	}
	print "\t</tr>\n";
}
print "</table>\n";

mysql_free_result($result);
mysql_close($link);

?>


