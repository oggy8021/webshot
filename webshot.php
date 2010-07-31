<?php 

// webshot

require 'debug.php';
require 'shotdb.php';

function webshot ($url) 
{
	debug($url);
	$md5url = md5($url);
	debug($md5url);

	//dbが存在するかチェック
	if (! ConnectShotDb() )
	{
		//dbが存在しない
		//dbを作る
		//create_db

	}

	//tableが存在するかチェック
	if (! EnableShotTab() )
	{
		//tableが存在しない
		//tableを作る
		//create_table
		;

	} else {
		//url部をチェックする
		//if (db.search($md5url)
			//urlに対応する画像がある
		
			//urlに対応する画像が無い
			print "<img src=\"./nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\"><HR><BR>";

	}
}

?>
