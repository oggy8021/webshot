<?php 

// shotdb.php

$hostname = '127.0.0.1';
$dbuser = 'shuser';
$db_ident = 'shuser!';
$dbname = 'shotdb';

$con = mysql_connect ($hostname, $dbuser, $db_ident);
if (! $con)
{
	print mysql_errno($con) . ": " . mysql_error($con). "\n";
	print "FALSE\n";
} else {
	mysql_select_db ($dbname, $con);
	print "TRUE\n";
}

?>
