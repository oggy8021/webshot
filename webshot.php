<?php 

// webshot

require 'debug.php';
require 'shotdb.php';

function webshot ($url) 
{
	debug($url);
	$md5url = md5($url);
	debug($md5url);

	//db�����݂��邩�`�F�b�N
	if (! ConnectShotDb() )
	{
		//db�����݂��Ȃ�
		//db�����
		//create_db

	}

	//table�����݂��邩�`�F�b�N
	if (! EnableShotTab() )
	{
		//table�����݂��Ȃ�
		//table�����
		//create_table
		;

	} else {
		//url�����`�F�b�N����
		if (! SearchUrlMatchedGraph($md5url))
		{
			$ret = InsertShotTab($md5url, $url);
			//url�ɑΉ�����摜������
			print "<img src=\"./nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\"><HR><BR>";

		} else {
			//url�ɑΉ�����摜������

		}

	}
}

?>
