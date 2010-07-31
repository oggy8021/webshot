<?php 

// shotdb.php

$con = null;

function ConnectShotDb() {
	global $con;

	$hostname = 'localhost';
	$dbuser = 'shuser';
	$db_ident = '';
	$dbname = 'shotdb';

	// TODO
	//   wordpress設定ファイルにあるのと同じ
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

function SearchUrlMatchedGraph($md5) {

	$result = mysql_query("SELECT md5, flag, ins_date, shot_date, url FROM shottab WHERE md5 = {$md5}");
	if (! $result)
	{
		return FALSE;
	} else {
		// TODO
		//   複数行帰ってきたら・・・fetch
		// TODO
		//   flagを返すべきか, INTO句？
		return TRUE;
	}
	
}//SearchUrlMatchedGraph


function InsertShotTab($md5, $url) {

	$flag = 0;	//未取得
	$ins_date = time();

	$result = mysql_query("INSERT INTO shottab(md5, flag, ins_date, url) VALUES ({$md5}, {$flag}, {$ins_date}, {$url} ) ");
	if (! $result)
	{
		print mysql_errno($con) . ": " . mysql_error($con);
		return FALSE;
	} else {
		return TRUE;
	}
	
}//InsertShotTab


function CloseShotDb() {
	global $con;
	mysql_close ($con);
}

?>
