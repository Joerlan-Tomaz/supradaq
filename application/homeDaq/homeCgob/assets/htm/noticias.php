<?php 
/*
Programador: Sergio Ricardo  
Sistema Intranet
Data: 31/01/2016
*/
include_once("../class/un_persistente.class");
include_once("../inc/un_funcoes.inc");
include_once("../inc/un_const.inc");
include_once("../class/un_db.class");
include_once("../class/un_erro.class");

   $obDb = new TDb();
   $Comando   = " SELECT ID_USUARIO,DESC_TITULONOTICIA,DESC_ASSUNTO,DESC_NOTICIA,FLAG_PUBLICAR, "; 
   $Comando  .= " concat( CONVERT(CHAR(10), DATA_CADASTRONOTICIA , 103),' ', CONVERT(CHAR(8), DATA_CADASTRONOTICIA , 114)) as DATA_CADASTRONOTICIA "; 
   $Comando  .= " FROM TB_NOTICIA ";
   $Comando  .= " WHERE FLAG_PUBLICAR = 'S' ";
   $Comando  .= " ORDER BY ID_NOTICIA DESC "; 
   //$Comando  .= " LIMIT 0,10 ";          
   $obErro = $obDb->Executa($Comando,$Lista);
   if (!$obErro->IsOk()){
		echo "db.Executa()".$obErro->GetDescricao();
	}
	//PRINT_R($Lista);
	//echo "<br>";
	//DIE("---->>>". $Comando);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Notícias</title>
<style type=text/css>body{scrollbar-face-color: #ffffff; scrollbar-shadow-color: #cccccc; scrollbar-highlight-color: #cccccc; scrollbar-3dlight-color: #cccccc; scrollbar-darkshadow-color: #cccccc;scrollbar-track-color: #cccccc; scrollbar-arrow-color: #cccccc;}</style>
<link href="../css/stili_template04.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body  bgcolor="#FFFFFF">
<table>
<font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
<?php
	if (!$Lista->EOF ()){
	     $Registros = 0;
	
	while (!$Lista->EOF ()):
?>
<tr>
 
 <td align="left">				      
<b><?php echo $Lista->Campo('DESC_TITULONOTICIA');?></b><br>
<?php echo $Lista->Campo('DESC_NOTICIA');?><br>
Data:<?php echo $Lista->Campo('DATA_CADASTRONOTICIA');?><br><br>

<?php
   $Lista->Proximo();
   $Registros++;
   endwhile;
   }
       

?>

  </td>
  </tr>
  </font >
</table>  
  
</body>
</html>
