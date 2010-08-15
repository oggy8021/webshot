<?php

//crawler.php
// TODO:
//	古いスナップショットを再取得する
//	SearchShotTabGetFlag()に、日付も条件として足せば良い

require 'debug.php';
require 'shotdb.php';

$display = ':5';
$profile = 'webshot';
$firefox = '/usr/bin/firefox';
$import = '/usr/bin/import';
$cachedir = '/var/www/html/image/webshot';

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

	//仮想画面でFirefoxを起動する
	$cmd = '/bin/ps -ef | grep "/usr/lib/firefox" | grep "display :5" | grep -v "grep" | grep -v "/bin/sh" | wc -l';
	$lastcon = exec($cmd, $ret);
	debugCon($cmd);
	debugCon($lastcon);
	if (! $lastcon)
	{
		$cmd = $firefox . ' -UILocale ja -display ' . $display . ' -width 800 -height 600 -p "' . $profile . '" >/dev/null &';
		passthru($cmd, $ret);
		debugCon("Starting ... Firefox");
		sleep(15);
		if ($ret)
		{
			debugCon("Failed Running Firefox (ret = $ret)");
			return FALSE;
		}
	}

	$resultset = SearchShotTabGetFlag();
	if ($resultset > 0)
	{
		foreach ($resultset as $row => $rec)
		{
			//print $rec["md5"] . $rec["flag"] . $rec["ins_date"] . $rec["shot_date"] . $rec["url"] . "\n";

			//対象のURLにアクセスする
			$cmd = $firefox .' -display ' . $display . ' -remote "openurl(' . $rec["url"] . ')" >/dev/null &';
			$lastcon = exec($cmd, $ret);
			if ($ret)
			{
				debugCon('Failed Open Url (url = ' . $rec["url"] . ')');
			} else {
				debugCon("URL opening ... Firefox");
				sleep(10);
			}

			//ImageMagickでスクリーンショットを撮る
			$imgpath = $cachedir . '/' . $rec["md5"] . '.png';
			$cmd = $import .' -display ' . $display . ' -window root ' . $imgpath;
			$lastcon = exec($cmd, $ret);
			if ($ret)
			{
				debugCon('Failed Snapshot (url = ' . $rec["url"] . ')');
			}

			//撮った画像を加工（縮小/角○/影）する
			$shotimg = new Imagick();
			$shotimg->readImage($imgpath);
			$shotimg->thumbnailImage(200, 150);
			$shotimg->roundCorners(5, 5);
			$shadow = $shotimg->clone();
			$shadow->setImageBackgroundColor( new ImagickPixel('black') );
			$shadow->shadowImage(80, 3, 5, 5);
			$shadow->compositeImage($shotimg, Imagick::COMPOSITE_OVER, 0, 0);
			$shadow->writeImage($imgpath);

			$shotimg->destroy();
			$shadow->destroy();

			//shotdb更新
			if (! UpdateShotTab($rec["md5"]) ) {
				debugCon ('Failed Update ShotDb');
				return FALSE;
			}

			//about:blank
			$url = 'about:blank';
			$cmd = $firefox .' -display ' . $display . ' -remote "openurl(' . $url . ')" >/dev/null &';

			sleep(5);

		}
	}
	return TRUE;
}

CloseShotDb();

?>
