<?php 

// webshot

require 'debug.php';
require 'shotdb.php';

function webshot ($url) 
{
	$ret = null;

	debug($url);
	$md5url = md5($url);
	debug($md5url);

	//db�����݂��邩�`�F�b�N
	if (! ConnectShotDb() )
	{
		//db�����݂��Ȃ�
		//db�����
		//create_db
		debug ("Failed ConnectShotDb");
		return FALSE;

	}

	//table�����݂��邩�`�F�b�N
	if (! EnableShotTab() )
	{
		//table�����݂��Ȃ�
		//table�����
		//create_table
		debug ("Failed EnableShotDb");
		return FALSE;

	} else {
		//url�����`�F�b�N����
		if (! SearchUrlMatchedGraph($md5url))
		{
			//url�ɑΉ�����摜������
			$ret = InsertShotTab($md5url, $url);
			if (! $ret)
			{
				debug("Failed InsertShotTab");
			} else {
				debug("Matched Record");
				print "<img src=\"./nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\"><HR><BR>";
			}

		} else {
			//url�ɑΉ�����摜������

		}

	}
}

?>
