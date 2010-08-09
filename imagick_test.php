<?php

require 'debug.php';

$shotimg = new Imagick();
$shotimg->readImage('/var/www/html/image/webshot/org.jpg');
debugCon('1');

//$shotimg->implodeImage;
//$shotimg->resizeImage(400, 300, imagick::FILTER_MITCHELL, false);
$shotimg->thumbnailImage(400, 300);
$shotimg->roundCorners(20, 10);
//$colors = $shotimg->getImageColors();
//debugCon("$colors");
debugCon('2');

$shotimg->writeImage('/var/www/html/image/webshot/org.jpg');
debugCon('3');

//$shotimg->destroy();
//debugCon('4');

?>
