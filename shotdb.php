<?php 

// shotdb.php

function __construct()
{
	$con = null;
}

function ConnectShotDb() {
	global $con;

	$hostname = 'localhost';
	$dbuser = 'shuser';
	$db_ident = '';

	// TODO
	//   wordpress�ݒ�t�@�C���ɂ���̂Ɠ���
	$con = mysql_connect ($hostname, $dbuser, $db_ident);
	if (! $con)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
//		mysql_select_db ($dbname, $con);
		return TRUE;
	}

}//ConnectShotDb

function EnableShotTab() {
	global $con;

	$dbname = 'shotdb';

	mysql_select_db ($dbname, $con);
	if (! $con)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
		return TRUE;
	}

}//EnableShotTab

function SearchShotTab($md5, &$rec) {
	global $con;

	$result = mysql_query("SELECT md5, flag, ins_date, shot_date, url FROM shottab WHERE md5 = '$md5'", $con);
	if (! $result)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
		//MD5�Փ˂��Ȃ��O��ŁA1�s
		$row = mysql_fetch_assoc($result);
		$rec["flag"] = $row["flag"];
		$rec["ins_date"] = $row["ins_date"];
		$rec["shot_date"] = $row["shot_date"];
		$rec["url"] = $row["url"];
		return TRUE;
	}
	
}//SearchUrlMatchedGraph


function InsertShotTab($md5, $url) {
	global $con;

	$flag = 0;	//���擾
	$ins_date = time();

	$result = mysql_query("INSERT INTO shottab(md5, flag, ins_date, url) VALUES ('$md5', $flag, $ins_date, '$url' )", $con);
	if (! $result)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
		return TRUE;
	}
	
}//InsertShotTab


function CloseShotDb() {
	global $con;
	mysql_close ($con);

}//CloseShotDb


function DumpError($func) {
	global $con;

	print $func . mysql_errno($con) . ": " . mysql_error($con);

}//DumpError


?>
