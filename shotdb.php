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

function SearchShotTabFromMd5($md5, &$rec) {
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

		//resultset������
		$cnt = 0;
		if ($cnt > 0)
		{
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
		} else {
			DumpError($cnt);
			return 0;
		}
	}
	
}//SearchShotTabGetFlag


function InsertShotTab($md5, $url) {
	global $con;

	$flag = 0;	//���擾

	$result = mysql_query("INSERT INTO shottab(md5, flag, ins_date, url) VALUES ('$md5', $flag, now(), '$url' )", $con);
	if (! $result)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
		return TRUE;
	}
	
}//InsertShotTab


function UpdateShotTab($md5) {
	global $con;

	$result = mysql_query("BEGIN", $con);

	$result = mysql_query("update shottab set flag = 1 where md5 = '$md5'", $con);
	if (! $result)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	}

	$result = mysql_query("update shottab set shot_date = now() where md5 = '$md5'", $con);
	if (! $result)
	{
		DumpError(__FUNCTION__);
		return FALSE;
	} else {
		$result = mysql_query("END", $con);
		return TRUE;
	}
	
}//UpdateShotTab


function CloseShotDb() {
	global $con;
	mysql_close ($con);

}//CloseShotDb


function DumpError($func) {
	global $con;

	print $func . mysql_errno($con) . ": " . mysql_error($con);

}//DumpError


?>
