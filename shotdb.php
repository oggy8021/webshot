<?php 

// shotdb.php

require 'debug.php';

//wordpress設定ファイルにあるのと同じ
$con = mysql_connect('host', 'user', 'passwd') or debug(mysql_error());

debug('connected shotdb');

?>
