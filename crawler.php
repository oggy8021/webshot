<?php

//crawler.php
// TODO:
//	�Â��X�i�b�v�V���b�g���Ď擾����
//	���ϐ��`�F�b�N

require 'debug.php';
require 'shotdb.php';

$display = ':5';
$profile = 'webshot';
$firefox = '/usr/bin/firefox';
$import = '/usr/bin/import';
$cachedir = '/var/www/html/image/webshot';

$ret = null;

if ("" === getenv('DISPLAY') )
{
	putenv("DISPLAY=$display.0");
	debugCon("Setting ENV{DISPLAY} = " . getenv('DISPLAY'));
}

//db�����݂��邩�`�F�b�N
if (FALSE === ConnectShotDb() )
{
	//db�����݂��Ȃ�
	//db�����
	//create_db
	debugCon ('Nothing ShotDb');
	return FALSE;

}

//table�����݂��邩�`�F�b�N
if (FALSE === EnableShotTab() )
{
	//table�����݂��Ȃ�
	//table�����
	//create_table
	debugCon ('Nothing ShotTab');
	return FALSE;

} else {

	//���z��ʂ�Firefox���N������
	$cmd = '/bin/ps -ef | grep "/usr/lib/firefox" | grep "display :5" | grep -v "grep" | grep -v "/bin/sh" | wc -l';
	$lastcon = exec($cmd, $ret);
//	debugCon($cmd);
//	debugCon($lastcon);
	if (0 === $lastcon)
	{
		$cmd = $firefox . ' -UILocale ja -display ' . $display . ' -width 800 -height 600 -p "' . $profile . '" >/dev/null &';
		passthru($cmd, $ret);
		debugCon("Starting ... Firefox");
		sleep(15);
		if (FALSE === $ret)
		{
			debugCon("Failed Running Firefox (ret = $ret)");
			return FALSE;
		}
	}
	debugCon('Firefox is already running');

	$resultset = SearchShotTabGetFlag();
	if (0 < $resultset)
	{
		debugCon('Starting ... crawler');
		foreach ($resultset as $row => $rec)
		{
			//print $rec["md5"] . $rec["flag"] . $rec["ins_date"] . $rec["shot_date"] . $rec["url"] . "\n";

			//�Ώۂ�URL�ɃA�N�Z�X����
			$cmd = $firefox .' -display ' . $display . ' -remote "openurl(' . $rec["url"] . ')" >/dev/null &';
			$lastcon = exec($cmd, $ret);
			if (FALSE === $ret)
			{
				debugCon('Failed Open Url (url = ' . $rec["url"] . ')');
			} else {
				debugCon("URL opening ... Firefox");
				sleep(10);
			}

			//ImageMagick�ŃX�N���[���V���b�g���B��
			$imgpath = $cachedir . '/' . $rec["md5"] . '.png';
			$cmd = $import .' -display ' . $display . ' -window root ' . $imgpath;
			$lastcon = exec($cmd, $ret);
			if (FALSE === $ret)
			{
				debugCon('Failed Snapshot (url = ' . $rec["url"] . ')');
			}
			debugCon("Success ... Snapshot");

			//�B�����摜�����H�i�k��/�p��/�e�j����
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
			debugCon("Success ... Image Convert");

			//shotdb�X�V
			if (FALSE === UpdateShotTab($rec["md5"]) )
			{
				debugCon ('Failed to update ShotTab');
				return FALSE;
			} else {
				debugCon("Success to update ... ShotTab");
			}

			//about:blank
			$url = 'about:blank';
			$cmd = $firefox .' -display ' . $display . ' -remote "openurl(' . $url . ')" >/dev/null &';

			sleep(5);

		}
	} else {
		debugCon('No need ... crawler');
	}
	return TRUE;
}

CloseShotDb();

?>
