<?php 

$img  = isset ( $_REQUEST ['img'] ) ? $_REQUEST ['img'] : NULL;


if(!empty($img)){
$img=substr($img, 4);    
$img = "../login/login2017/imgs/$img";
if(file_exists($img)){ 

$exif = exif_imagetype($img); 
$mime = image_type_to_mime_type($exif);//Pega o mime type do arquivo 

header("Content-type: {$mime}"); 
echo file_get_contents($img); 

} 
}
?>
