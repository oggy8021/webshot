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
	//   wordpress設定ファイルにあるのと同じ
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

function SearchShotTabFromMd5($md5, &$rec) {
	global $con;

	$result = mysql_query("SELECT md5, flag, ins_date, shot_date, url FROM shottab WHERE md5 = '$md5'", $con);
	if (! $result)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
		//MD5衝突しない前提で、1行
		$row = mysql_fetch_assoc($result);
		$rec["flag"] = $row["flag"];
		$rec["ins_date"] = $row["ins_date"];
		$rec["shot_date"] = $row["shot_date"];
		$rec["url"] = $row["url"];
		return TRUE;
	}
	
}//SearchShotDbFromMd5


function SearchShotTabGetFlag() {
	global $con;

	$result = mysql_query("SELECT md5, flag, ins_date, shot_date, url FROM shottab WHERE flag = 0 ORDER BY ins_date", $con);
	if (! $result)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
		$rowcnt = mysql_num_rows($result);

		//resultset初期化
		$cnt = 0;
		while ($cnt < $rowcnt)
		{
			$resultset[$cnt] = array("md5" => "", "flag" => 0, "ins_date" => 0, "shot_date" => 0, "url" => "");
			$cnt++;
		}

		//fetch
		$cnt = 0;
		while ($row = mysql_fetch_assoc($result))
		{
			$resultset["$cnt"]["md5"] = $row["md5"];
			$resultset["$cnt"]["flag"] = $row["flag"];
			$resultset["$cnt"]["ins_date"] = $row["ins_date"];
			$resultset["$cnt"]["shot_date"] = $row["shot_date"];
			$resultset["$cnt"]["url"] = $row["url"];
			$cnt++;
		}
		return $resultset;
	}
	
}//SearchShotTabGetFlag


function InsertShotTab($md5, $url) {
	global $con;

	$flag = 0;	//未取得
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
