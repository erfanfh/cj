<?php

session_start();
function generateCaptchaCode($length)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captchaCode = '';

    for ($i = 0; $i < $length; $i++) {
        $captchaCode .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $captchaCode;
}

$captchaLength = isset($_SESSION['captcha_length']) ? $_SESSION['captcha_length'] : 6;
$captchaCode = generateCaptchaCode($captchaLength);
$_SESSION['captcha_code'] = $captchaCode;
$width = 150;
$height = 50;
$image = imagecreatetruecolor($width, $height);
$backgroundColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);

imagefill($image, 0, 0, $backgroundColor);

imagettftext($image, 20, rand(-10, 10), 10, 30, $textColor, '../Fonts/Vazir/Vazir.ttf', $captchaCode);


for ($i = 0; $i < 10; $i++) {

    $lineColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));

    imagesetpixel($image, rand(0, $width), rand(0, $height), $lineColor);

    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);

}
header('Content-type: image/png');

imagepng($image);
imagedestroy($image);