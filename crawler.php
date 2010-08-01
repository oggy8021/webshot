<?php

//crawler.php

require 'debug.php';
require 'shotdb.php';

$ret = null;

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

	$resultset = SearchShotTabGetFlag();

//	foreach ($resutset as $cnt

}

CloseShotDb();

?>
