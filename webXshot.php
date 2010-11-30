<?php 

/*
	Plugin Name: webXshot
	Plugin URI: http://oggy.no-ip.info/blog/
	Description: Snapshot to Web site. [Xvfb + Firefox + ImageMagick(Imagick)]
	Version: 1.0
	Author: oggy
	Author URI: http://oggy.no-ip.info/blog/
 */

require_once 'debuggy.php';
require_once 'shotdb.php';

function webXshot ($url, $title, $note) 
{
	$ret = null;
	$apdir = 'http://oggy.no-ip.info/blog/wp-content/plugins/webXshot';
	$cachedir = $apdir . '/cache';

	//入力値チェック
	$url = str_replace("\0", "", $url);
	if (! isUrl($url) )
	{
		debugHtml("不正なURLです $url");
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

		$imgString = '<p>';
		$imgString .= '<a href="' . $url . '" target="_blank">';
		//urlに対応するレコードがあった
		if (0 === $rec["flag"])
		{
			//urlに対応する画像が無い
			$imgString .= sprintf ("<img src=\"%s/nowp.png\" alt=\"NowPrinting\" title=\"NowPrinting\" class=\"alignleft\" />", $apdir);
		} else {
			//urlに対応する画像がある
			$imgString .= sprintf ("<img src=\"%s/%s.png\" alt=\"%s\" title=\"%s\" class=\"alignleft\" />", $cachedir, $md5url, $rec["url"], $rec["url"]);
		}
		
		if ("" != $title)
		{
			$imgString .= '<br />' . $title . '</a><br />';
		} else {
			$imgString .= '</a><br />';
		}

		if ("" != $note)
		{
			$imgString .= $note . '<br />';
		}

		//回り込み解除がカッコワルイ
		$imgString .= '</p><p class="clear"></p>';
		
	}
	CloseShotDb();
	
	return $imgString;
	
}//webXshot

function isUrl($text) {
	if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $text)) {
		return TRUE;
	} else {
		return FALSE;
	}

}//isUrl

?>
