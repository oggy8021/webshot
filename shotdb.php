<?php 

// shotdb.php

require 'debug.php';

//wordpress�ݒ�t�@�C���ɂ���̂Ɠ���
$con = mysql_connect('host', 'user', 'passwd') or debug(mysql_error());

debug('connected shotdb');

?>
