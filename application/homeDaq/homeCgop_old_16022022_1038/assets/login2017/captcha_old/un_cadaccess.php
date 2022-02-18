<?php
/*
 * DNIT
 * CGCONT -
 * classe un_cadaccess.php
 * Programador: Sergio Ricardo
 * Data: 15/08/2017 15:35
 */

//----------------------------------------------------------------------------------------------------------------------------------------------
include_once ("include_verificasession.php");
//----------------------------------------------------------------------------------------------------------------------------------------------
$name    = isset ( $_REQUEST ['name'    ] ) ? $_REQUEST ['name'     ] : NULL;
$email   = isset ( $_REQUEST ['email'   ] ) ? $_REQUEST ['email'    ] : NULL;
$empresa = isset ( $_REQUEST ['empresa' ] ) ? $_REQUEST ['empresa'  ] : NULL;
$captcha = isset ( $_REQUEST ['captcha' ] ) ? $_REQUEST ['captcha'  ] : NULL;
$operacao= isset ( $_REQUEST ['operacao'] ) ? $_REQUEST ['operacao' ] : NULL;
//----------------------------------------------------------------------------------------------------------------------------------------------
$captcha_session=$_SESSION['captcha'];
//----------------------------------------------------------------------------------------------------------------------------------------------
if($operacao =='inserir' and ($captcha_session == $captcha) and !empty($name) and !empty($email) and !empty($empresa) ){
    $access=($name.';'.$email.';'.$empresa.';'.$captcha."\n");
    $fp = fopen("data/data.txt", "a");
    $escreve = fwrite($fp, $access);
    fclose($fp);
    $retorno=1;
   
}else{
    $retorno=2;
}
//----------------------------------------------------------------------------------------------------------------------------------------------    
if (
	($_POST ['operacao'] == 'inserir')){
        header('Content-type: application/json');
        die ( json_encode ( $retorno ) );
    }
?>