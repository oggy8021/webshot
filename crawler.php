<?php

//crawler.php

require 'debug.php';
require 'shotdb.php';

$display = ':5';
$profile = 'webshot';
$firefox = '/usr/bin/firefox';
$import = '/usr/local/bin/import';
$cachedir = '/var/www/html/image/webshot';

$ret = null;

//db�����݂��邩�`�F�b�N
if (! ConnectShotDb() )
{
	//db�����݂��Ȃ�
	//db�����
	//create_db
	debugCon ('Nothing ShotDb');
	return FALSE;

}

//table�����݂��邩�`�F�b�N
if (! EnableShotTab() )
{
	//table�����݂��Ȃ�
	//table�����
	//create_table
	debugCon ('Nothing ShotTab');
	return FALSE;

} else {

	//���z��ʂ�Firefox���N������
	$cmd = '/bin/ps -ef | grep "/usr/lib/firefox" | grep "display :5"';
	$lastcon = exec($cmd, $ret);
	if ($ret)
	{
		$cmd = $firefox . ' -UILocale ja -display ' . $display . ' -width 800 -height 600 -p "' . $profile . '" >/dev/null &';
		passthru($cmd, $ret);
		sleep(15);
		if ($ret)
		{
			debugCon("Failed Running Firefox (ret = $ret)");
			return FALSE;
		}
	}

	$resultset = SearchShotTabGetFlag();

	foreach ($resultset as $row => $rec)
	{
		//print $rec["md5"] . $rec["flag"] . $rec["ins_date"] . $rec["shot_date"] . $rec["url"] . "\n";

		//�Ώۂ�URL�ɃA�N�Z�X����
		$cmd = $firefox .' -display ' . $display . ' -remote "openurl(' . $rec["url"] . ')" >/dev/null &';
		$lastcon = exec($cmd, $ret);
		if ($ret)
		{
			debugCon('Failed Open Url (url = ' . $rec["url"] . ')');
		} else {
			sleep(10);
		}

		//Image::Magick�ŃX�N���[���V���b�g���B��
		$cmd = $import .' -display ' . $display . ' -window root ' . $cachedir . '/' . $rec["md5"] . '.jpg';
		$lastcon = exec($cmd, $ret);
		if ($ret)
		{
			debugCon('Failed Snapshot (url = ' . $rec["url"] . ')');
		}

		//�B�����摜���k������
		//$shotimg = new Imagick($cachedir . '/' . $rec["md5"] . '.jpg');
		//$shotimg->thumbnailImage(400, 300, true);

		//shotdb�X�V
		

		debugCon($cmd);
		//$cmd = $firefox .' -display ' . $display . ' -remote "openurl(about:blank)" &';
		return TRUE;
	}
	return TRUE;
}

CloseShotDb();

?>
