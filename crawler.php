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
	debugCon ('Nothing ShotDb');
	return FALSE;

}

//tableが存在するかチェック
if (! EnableShotTab() )
{
	//tableが存在しない
	//tableを作る
	//create_table
	debugCon ('Nothing ShotTab');
	return FALSE;

} else {

	$resultset = SearchShotTabGetFlag();

	foreach ($resultset as $row => $rec)
	{
		print $rec["md5"] . $rec["flag"] . $rec["ins_date"] . $rec["shot_date"] . $rec["url"] . "\n";

		//仮想画面でFirefoxを起動する
		$cmd = 'ps -ef | grep "/usr/lib/firefox" | grep "display :5"';
		system($cmd, $ret);
		if (! $ret) {
			$cmd = '/usr/lib/firefox-3.6/firefox -UILocale ja -display :5 -width 800 -height 600 -p "webshot" &';
			system($cmd, $ret);
			if (! $ret) {
				debugCon('Failed Running Firefox');
				return FALSE;
			}
		}

		//対象のURLにアクセスする
		//Image::Magickでスクリーンショットを撮る
		//撮った画像を縮小する
		//shotdb更新
	}
}

CloseShotDb();

?>
