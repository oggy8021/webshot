<?php 

// webshot

require 'debug.php';
require 'shotdb.php';

function webshot ($url) 
{
	$ret = null;
	$cachedir = 'http://oggy.no-ip.info/image/webshot';

	//入力値チェック
	$url = str_replace("\0", "", $url);
	if (! isUrl($url) )
	{
		debugHtml("不正なURLです");
		return FALSE;
	}

//	debugHtml($url);
	$md5url = md5($url);
//	debugHtml($md5url);

	//dbが存在するかチェック
	if (! ConnectShotDb() )
	{
		//dbが存在しない
		//dbを作る
		//create_db
		debugHtml ("Nothing ShotDb");
		return FALSE;

	}

	//tableが存在するかチェック
	if (! EnableShotTab() )
	{
		//tableが存在しない
		//tableを作る
		//create_table
		debugHtml ("Nothing ShotTab");
		return FALSE;

	} else {

		$rec = array("flag" => 0, "ins_date" => 0, "shot_date" => 0, "url" => "");

		$ret = SearchShotTabFromMd5($md5url, $rec);
//		debugHtml($ret);
		if (! $ret)
		{
//			debugHtml($url);
			//urlに対応するレコードがない
			$ret = InsertShotTab($md5url, $url);
			if (! $ret)
			{
				debugHtml("Failed InsertShotTab");
				return FALSE;
			}
		} 

		//urlに対応するレコードがあった
		if (! $rec["flag"])
		{
			//urlに対応する画像が無い
			printf ("<img src=\"%s/nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\" /><BR>\n", $cachedir);
		} else {
			//urlに対応する画像がある
			printf ("<img src=\"%s/%s.png\" ALT=\"%s\" TITLE=\"%s\" /><BR>\n", $cachedir, $md5url, $md5url, $md5url);
		}
	}
	
	CloseShotDb();
}

function isUrl($text) {
    if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $text)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

?>
