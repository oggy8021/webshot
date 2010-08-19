<?php 

require 'webshot.php';

webshot("http://www.yahoo.co.jp");
print "<hr>";
webshot("http://www.goo.ne.jp");
print "<hr>";
webshot("about:blank");
print "<hr>";
webshot("../../../etc/password");

?>
