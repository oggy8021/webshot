<?php 

// shotdb.php

require 'debug.php';

//wordpressÝ’èƒtƒ@ƒCƒ‹‚É‚ ‚é‚Ì‚Æ“¯‚¶
$con = mysql_connect('host', 'user', 'passwd') or debug(mysql_error());

debug('connected shotdb');

?>
