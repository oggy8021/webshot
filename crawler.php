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

	$resultset = SearchShotTabGetFlag();

	foreach ($resultset as $row => $rec)
	{
		print $rec["md5"] . $rec["flag"] . $rec["ins_date"] . $rec["shot_date"] . $rec["url"] . "\n";

		//���z��ʂ�Firefox���N������
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

		//�Ώۂ�URL�ɃA�N�Z�X����
		//Image::Magick�ŃX�N���[���V���b�g���B��
		//�B�����摜���k������
		//shotdb�X�V
	}
}

CloseShotDb();

?>
