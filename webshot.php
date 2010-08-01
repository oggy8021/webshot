<?php 

// webshot

require 'debug.php';
require 'shotdb.php';

function webshot ($url) 
{
	$ret = null;

	debug($url);
	$md5url = md5($url);
//	debug($md5url);

	//dbが存在するかチェック
	if (! ConnectShotDb() )
	{
		//dbが存在しない
		//dbを作る
		//create_db
		debug ("Nothing ShotDb");
		return FALSE;

	}

	//tableが存在するかチェック
	if (! EnableShotTab() )
	{
		//tableが存在しない
		//tableを作る
		//create_table
		debug ("Nothing ShotTab");
		return FALSE;

	} else {

		$rec = array("flag" => 0, "ins_date" => 0, "shot_date" => 0, "url" => "");

		$ret = SearchShotTabFromMd5($md5url, $rec);
		if (! $ret)
		{
			//urlに対応するレコードがない
			$ret = InsertShotTab($md5url, $url);
			if (! $ret)
			{
				debug("Failed InsertShotTab");
				return FALSE;
			}
		} 

		//urlに対応するレコードがあった
		if (! $rec["flag"])
		{
			//urlに対応する画像が無い
			print "<img src=\"./nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\"><BR>";
		} else {
			//urlに対応する画像がある
			printf ("<img src=\"./%s.png\" ALT=\"%s\" TITLE=\"%s\"><HR><BR>", $md5url, $md5url, $md5url);
		}
	}
	
	CloseShotDb;
}

?>
