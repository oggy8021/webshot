<?php 

// shotdb.php

$hostname = 'localhost';
$dbuser = 'shuser';
$db_ident = '';
$dbname = 'shotdb';

$con = null;

function ConnectShotDb() {
	global $con;
	// TODO
	//   wordpress�ݒ�t�@�C���ɂ���̂Ɠ���
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
	global $con;

	$result = mysql_query("SELECT md5, flag, ins_date, shot_date, url FROM shottab WHERE md5 = {$md5}", $con);
	if (! $result)
	{
		return FALSE;
	} else {
		// TODO
		//   �����s�A���Ă�����E�E�Efetch
		// TODO
		//   flag��Ԃ��ׂ���, INTO��H
		return TRUE;
	}
}

function InsertShotTab($md5, $url) {
	global $con;

	$flag = 0;	//���擾
	$ins_date = time();

	$result = mysql_query("INSERT INTO shottab(md5, flag, ins_date, url) VALUES ({$md5}, {$flag}, {$ins_date}, {$url} ) ", $con);
}

function CloseShotDb() {
	global $con;
	mysql_close ($con);
}

?>
