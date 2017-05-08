<?php
$w = isset($_GET['w']) ? intval($_GET['w']) : 320;
$h = isset($_GET['h']) ? intval($_GET['h']) : 50;

if ($w < 1 || $h < 1) {
        echo "bad w: $w & h: $h";
        exit;
}

$text = "$w x $h ";
$date = date('Y-m-d H:i:s');

$im = imagecreate($w, $h);
$background_color = imagecolorallocate($im, 0, rand(1, 255), rand(1, 255));
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 3, 10, 10, $text, $text_color);
imagestring($im, 3, 5, 25, $date, $text_color);

header("Content-Type: image/png");
imagepng($im);
imagedestroy($im);
