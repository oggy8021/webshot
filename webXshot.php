<?php 

/*
	Plugin Name: webXshot
	Plugin URI: http://oggy.no-ip.info/blog/
	Description: Snapshot to Web site. [Xvfb + Firefox + ImageMagick(Imagick)]
	Version: 1.0
	Author: oggy
	Author URI: http://oggy.no-ip.info/blog/
 */

require 'debug.php';
require 'shotdb.php';

function webXshot ($url) 
{
	$ret = null;
	$apdir = 'http://oggy.no-ip.info/blog/wp-content/plugins/webXshot';
	$cachedir = 'http://oggy.no-ip.info/blog/wp-content/plugins/webXshot/cache';

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
	if (FALSE === ConnectShotDb() )
	{
		//dbが存在しない
		//dbを作る
		//create_db
		debugHtml ("Nothing ShotDb");
		return FALSE;

	}

	//tableが存在するかチェック
	if (FALSE === EnableShotTab() )
	{
		//tableが存在しない
		//tableを作る
		//create_table
		debugHtml ("Nothing ShotTab");
		return FALSE;

	} else {

		$rec = array("flag" => 0, "ins_date" => 0, "shot_date" => 0, "url" => "");

		$cnt = SearchShotTabFromMd5($md5url, $rec);
//		debugHtml($ret);
		if (0 === $cnt)
		{
//			debugHtml($url);
			//urlに対応するレコードがない
			$ret = InsertShotTab($md5url, $url);
			if (FALSE === $ret)
			{
				debugHtml("Failed InsertShotTab");
				return FALSE;
			}
		} 

		//urlに対応するレコードがあった
		if (0 === $rec["flag"])
		{
			//urlに対応する画像が無い
			printf ("<img src=\"%s/nowp.png\" ALT=\"Now Printing ... \" TITLE=\"\" /><BR>\n", $apdir);
		} else {
			//urlに対応する画像がある
			printf ("<img src=\"%s/%s.png\" ALT=\"%s\" TITLE=\"%s\" /><BR>\n", $cachedir, $md5url,  $rec["url"],  $rec["url"]);
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
