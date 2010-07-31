<?php 

// webshot

require 'debug.php';
require 'shotdb.php';

function webshot ($url) 
{
	$ret = null;

	debug($url);
	$md5url = md5($url);
	debug($md5url);

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
		//url部をチェックする
		if (! SearchUrlMatchedGraph($md5url))
		{
			//urlに対応する画像が無い
			$ret = InsertShotTab($md5url, $url);
			if (! $ret)
			{
				debug("Failed InsertShotTab");
			} else {
				debug("Matched Record");
				print "<img src=\"./nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\"><HR><BR>";
			}

		} else {
			//urlに対応する画像がある
			;
		}

	}
	
	CloseShotDb;
}

?>
