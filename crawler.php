<?php

//crawler.php

require 'debug.php';
require 'shotdb.php';

$ret = null;

//db�����݂��邩�`�F�b�N
if (! ConnectShotDb() )
{
	//db�����݂��Ȃ�
	//db�����
	//create_db
	debug ("Nothing ShotDb");
	return FALSE;

}

//table�����݂��邩�`�F�b�N
if (! EnableShotTab() )
{
	//table�����݂��Ȃ�
	//table�����
	//create_table
	debug ("Nothing ShotTab");
	return FALSE;

} else {

	$resultset = SearchShotTabGetFlag();

	foreach ($resultset as $row => $rec)
	{
		print $rec["md5"] . $rec["flag"] . $rec["ins_date"] . $rec["shot_date"] . $rec["url"] . "\n";
	}
}

CloseShotDb();

?>
