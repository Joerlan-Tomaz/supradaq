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
$cpf     = isset ( $_REQUEST ['cpf'     ] ) ? $_REQUEST ['cpf'      ] : NULL;
$telefone= isset ( $_REQUEST ['telefone'] ) ? $_REQUEST ['telefone' ] : NULL;
$captcha = isset ( $_REQUEST ['captcha' ] ) ? $_REQUEST ['captcha'  ] : NULL;
$operacao= isset ( $_REQUEST ['operacao'] ) ? $_REQUEST ['operacao' ] : NULL;
//----------------------------------------------------------------------------------------------------------------------------------------------
$captcha_session=$_SESSION['captcha'];
//----------------------------------------------------------------------------------------------------------------------------------------------
date_default_timezone_set ( 'America/Sao_Paulo' );
$data = date ( "ymd H:i:s" );
//-----------------------------------------------------------------------------------------------------------------------------------------------
$name = str_replace    ( '<', '',         $name);
$name = str_replace    ( '>', '',         $name);
$name = str_replace    ( 'php', '',       $name);
$name = str_replace    ( '?', '',         $name);
$name = str_replace    ( 'script', '',    $name);
$name = str_replace    ( '@', '',         $name);
$name = str_replace    ( '\'', '',        $name);
//-----------------------------------------------------------------------------------------------------------------------------------------------
$empresa = str_replace ( '<', '',      $empresa);
$empresa = str_replace ( '>', '',      $empresa);
$empresa = str_replace ( 'php', '',    $empresa);
$empresa = str_replace ( '?', '',      $empresa);
$empresa = str_replace ( 'script', '', $empresa);
$empresa = str_replace ( '@', '',      $empresa);
$empresa = str_replace ( '\'', '',     $empresa);
//-----------------------------------------------------------------------------------------------------------------------------------------------
$email = str_replace ( '<', '',          $email);
$email = str_replace ( '>', '',          $email);
$email = str_replace ( 'php', '',        $email);
$email = str_replace ( '?', '',          $email);
$email = str_replace ( 'script', '',     $email);
$email = str_replace ( '\'', '',         $email);
//-----------------------------------------------------------------------------------------------------------------------------------------------
$cpf = str_replace ( '<', '',          $cpf );
$cpf = str_replace ( '>', '',          $cpf );
$cpf = str_replace ( 'php', '',        $cpf );
$cpf = str_replace ( '?', '',          $cpf );
$cpf = str_replace ( 'script', '',     $cpf );
$cpf = str_replace ( '\'', '',         $cpf );
//-----------------------------------------------------------------------------------------------------------------------------------------------
$telefone = str_replace ( '<', '',          $telefone );
$telefone = str_replace ( '>', '',          $telefone );
$telefone = str_replace ( 'php', '',        $telefone );
$telefone = str_replace ( '?', '',          $telefone );
$telefone = str_replace ( 'script', '',     $telefone );
$telefone = str_replace ( '\'', '',         $telefone );
//-----------------------------------------------------------------------------------------------------------------------------------------------
if($operacao =='inserir' and !empty($cpf) and !empty($telefone) and !empty($name) and !empty($email) and !empty($empresa) and ($captcha==$captcha_session)){
    $quebra = chr(13).chr(10);//essa é a quebra de linha
    $access=($captcha_session.';'.$name.';'.$email.';'.$empresa.';'.$captcha.';'.$data.';'.$cpf.';'.$telefone.$quebra);
    $fp = fopen("data/data.txt", "a");
    $escreve = fwrite($fp, $access);
    fclose($fp);
    $retorno=1;
   
}else{
    $retorno=2;
}
//----------------------------------------------------------------------------------------------------------------------------------------------    
if (
	($operacao == 'inserir')){
        
        header('Content-type: application/json');
        die ( json_encode ( $retorno ) );
    }
?>