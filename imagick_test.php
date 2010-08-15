<?php

require 'debug.php';

$shotimg = new Imagick();
$shotimg->readImage('/var/www/html/image/webshot/org.png');
$shotimg->thumbnailImage(200, 150);
$shotimg->roundCorners(5, 5);
$shadow = $shotimg->clone();
$shadow->setImageBackgroundColor( new ImagickPixel('black') );
//$shadow->shadowImage(80, 3, 5, 5);
$shadow->shadowImage(20, 3, 5, 5);
//$shadow->writeImage('/var/www/html/image/webshot/shd.png');
$shadow->compositeImage($shotimg, Imagick::COMPOSITE_OVER, 0, 0);
$shadow->writeImage('/var/www/html/image/webshot/org2.png');

$shotimg->destroy();
$shadow->destroy();

?>
