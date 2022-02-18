<?php
/*
 * DNIT
 * CGCONT -
 * classe captcha.php
 * Programador: Sergio Ricardo
 * Data: 15/08/2017 15:35
 */
//----------------------------------------------------------------------------------------------------------------------------------------------
//include_once ("include_verificasession.php");
//-----------------------------------------------------------------------------------------------------------------------------------------------
$codigoCaptcha = substr(md5( time()) ,0,9);
//$_SESSION['captcha'] = $codigoCaptcha;

$imagemCaptcha = imagecreatefrompng("fundocaptch.png");

$fonteCaptcha = imageloadfont("anonymous.gdf");

$corCaptcha = imagecolorallocate($imagemCaptcha,255,0,0);

imagestring($imagemCaptcha,$fonteCaptcha,15,5,$codigoCaptcha,$corCaptcha);


header("Content-type: image/png");

imagepng($imagemCaptcha);

imagedestroy($imagemCaptcha);






?>