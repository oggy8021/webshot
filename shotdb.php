<?php 

// shotdb.php

$hostname = 'localhost';
$dbuser = 'shuser';
$db_ident = '';
$dbname = 'shotdb';

$con = null;

function ConnectShotDb() {
	// TODO
	//   wordpressÝ’èƒtƒ@ƒCƒ‹‚É‚ ‚é‚Ì‚Æ“¯‚¶
	$con = mysql_connect ($hostname, $dbuser, $db_ident);
	if (! $con)
	{
		print mysql_errno($con) . ": " . mysql_error($con). "\n";
		return FALSE;
	} else {
		mysql_select_db ($dbname, $con);
		return TRUE;
	}
}

function EnableShotTab() {
	return TRUE;
}

function CloseShotDb() {
	mysql_close ($con);
}

?>
