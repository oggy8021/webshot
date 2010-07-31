<?php 

// shotdb.php

require 'shotdb.php';

if (! ConnectShotDb())
{
	print "FALSE\n";
} else {
	print "TRUE\n";
}

?>
