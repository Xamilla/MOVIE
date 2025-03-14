<?php
session_start();

$comb_string = '123456789abcdefghijklmnopqrstuvwxyz';
$code = getCode($comb_string, 4);

$_SESSION["captcha"] = $code; // Ensure this matches the session variable checked in login

$im = imagecreatetruecolor(50, 24);
$bg = imagecolorallocate($im, 255, 255, 255);
$fg = imagecolorallocate($im, 19, 78, 4);
imagefill($im, 0, 0, $bg);
imagestring($im, 5, 5, 5,  $code, $fg);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);

function getCode($valid_chars, $length)
{
    $random_string = "";
    $num_valid_chars = strlen($valid_chars);

    for ($i = 0; $i < $length; $i++) {
        $random_pick = mt_rand(1, $num_valid_chars);
        $random_char = $valid_chars[$random_pick - 1];
        $random_string .= $random_char;
    }

    return $random_string;
}
