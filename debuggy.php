<?php

function debugHtml ($val)
{
	print "<BR><FONT COLOR=\"red\">[debug] :</FONT><strong>$val</strong><BR>\n";
}

function debugCon ($val)
{
	$today  = date("Y/m/d H:i:s");

	print "$today [debug] :$val.\n";
}

?>
