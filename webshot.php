<?php 

// webshot

require 'debug.php';
//require 'db'層

function webshot ($url) 
{
	debug($url);
	$md5url = md5($url);
	debug($md5url);

	//dbが存在するかチェック
	//dbが存在しない
		//dbを作る
		//create_db

	//url部をチェックする
	//if (db.search($md5url)
		//urlに対応する画像がある
		
		//urlに対応する画像が無い
		print "<img src=\"./nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\"><HR><BR>";

};

?>
