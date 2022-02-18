<?php
include_once ("inc/include_verificasession.php");
include_once ("inc/un_funcoes.inc");
include_once ("class/un_db.class");
include_once ("class/un_form.class");
include_once ('class/un_persistente.class');
// ##############################################################################################################################################################
set_time_limit ( 0 );
ini_set ( 'memory_limit', "64M" );
// ##############################################################################################################################################################
// filtrando variaveis recebidas
foreach ( $_REQUEST as $indice => $value ) {
	$_REQUEST [$indice] = addslashes ( $_REQUEST [$indice] );
}
// ##############################################################################################################################################################
$nume_matricula = $_SESSION ['nume_matricula'];
$id_usuario = $_SESSION ['id_usuario'];
$desc_nome = utf8_encode ( $_SESSION ['desc_nome'] );
$email = $_SESSION ['email'];
$desc_siglasetor = isset ( $_SESSION ['desc_siglasetor'] ) ? $_SESSION ['desc_siglasetor'] : NULL;
$inIdMenu = $_SESSION ['inIdMenu'];
$dt_Ultacesso = $_SESSION ['dt_Ultacesso'];
$boAlteraSenha = $_SESSION ['boAlteraSenha'];
$strUrl = $_SESSION ['strUrl'];
// ##########################################################################################################################################################
$id = isset ( $_POST ['id'] ) ? $_POST ['id'] : NULL;
$inIdContratoObra = \filter_var ( isset ( $_GET ['inIdContratoObra'] ) ? $_GET ['inIdContratoObra'] : NULL, \FILTER_VALIDATE_INT );
// ##########################################################################################################################################################
if (empty ( $id ) and (empty ( $inIdContratoObra ))) {
	$cbxNuCon = isset ( $_SESSION ['cbxNuCon'] ) ? $_SESSION ['cbxNuCon'] : NULL;
	$inIdContratoObra = isset ( $_SESSION ['inIdContratoObra'] ) ? $_SESSION ['inIdContratoObra'] : NULL;
	$stContrato = isset ( $_SESSION ['stContrato'] ) ? $_SESSION ['stContrato'] : NULL;
}
if (! empty ( $inIdContratoObra ) and (empty ( $cbxNuCon ) or empty ( $stContrato ))) {
	// ###############################################################################################################################################################
	$obDb = new TDb ();
	$stComando = "SELECT c.CONTRATO CONTRATO
    ,c.ID_CONTRATO_OBRA ID_CONTRATO_OBRA
    ,c.CONSTRUTORA
    ,C.SUPERVISORA
    ,c.br
    ,c.uf
FROM TB_CONTRATO_OBRA c
WHERE c.id_contrato_obra =" . $inIdContratoObra;
	
	$obErro = $obDb->Executa ( $stComando, $ListaContrato );
	if (! $obErro->IsOk ()) {
		echo "db.Executa()" . $obErro->GetDescricao ();
	}
	
	$_SESSION ['cbxNuCon'] = $ListaContrato->Campo ( "ID_CONTRATO_OBRA" );
	$_SESSION ['inIdContratoObra'] = $ListaContrato->Campo ( "ID_CONTRATO_OBRA" );
	$_SESSION ['stContrato'] = $ListaContrato->Campo ( "CONTRATO" );
	$_SESSION ['id'] = $ListaContrato->Campo ( "ID_CONTRATO_OBRA" );
	$_SESSION ['edtContrato'] = $ListaContrato->Campo ( "CONTRATO" );
	$stContrato = $ListaContrato->Campo ( "CONTRATO" );
}

// #########################################################################################################################################################################################################################################################################
$obDb = new TDb ();
$Comando = " SELECT u.flag_primeiro_acesso,u.ID_PERFIL, u.CODI_SENHA, u.DESC_NOME, u.ID_USUARIO, concat (CONVERT (VARCHAR(10), u.data_ultimoacesso, 1)  ,  ' ' ,   CONVERT (VARCHAR(10), u.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO,u.FLAG_ALTERASENHA,u.email FROM TB_USUARIO u WHERE u.email ='" . $nume_matricula . "'";
$obErro = $obDb->Executa ( $Comando, $ListaUsuario );
if (! $obErro->IsOk ()) {
	echo "db.Executa()" . $obErro->GetDescricao ();
}
$boPrimeiroAcesso = $ListaUsuario->Campo ( "FLAG_PRIMEIRO_ACESSO" );
$id_perfil = $ListaUsuario->Campo ( "ID_PERFIL" );
// ###############################################################################################################################################################
if ($boPrimeiroAcesso == 'S' and $id_perfil == 0 and $_SERVER ['PHP_SELF'] != '/sigacont/sigacont/profile.php') {
	$obDb = new TDb ();
	$Comando = " UPDATE TB_USUARIO SET id_perfil=2 WHERE ID_USUARIO = " . $id_usuario;
	$obErro = $obDb->Executa ( $Comando, $ListaUsuario );
	if (! $obErro->IsOk ()) {
		echo "db.Executa()" . $obErro->GetDescricao ();
		exit ();
	} else {
		header ( "location: /sigacont/sigacont/profile.php?stOperacao=2&idPerfil=0" );
		exit();
	}
	// ###############################################################################################################################################################
} else if (! empty ( $id )) {
	// ###############################################################################################################################################################
	if ($id_perfil == 1) {
		$obDb = new TDb ();
		$stComando = "SELECT c.CONTRATO CONTRATO
    ,c.ID_CONTRATO_OBRA ID_CONTRATO_OBRA
    ,c.CONSTRUTORA
    ,C.SUPERVISORA
    ,c.br
    ,c.uf
    ,CONCAT (
        c.br
        ,' / '
        ,c.uf
        ) AS bruf
    ,CONCAT (
        s.km_inicial
        ,' ao '
        ,s.km_final
        ) AS km
FROM TB_CONTRATO_OBRA c
    ,tb_siac_segmento s
WHERE c.contrato = s.contrato
    AND c.contrato LIKE '%" . $id . "%'";
		$obErro = $obDb->Executa ( $stComando, $obRsNuContrato );
		if (! $obErro->IsOk ())
			echo "db.Executa()" . $obErro->GetDescricao ();
		// ###############################################################################################################################################################
	}
	
	if (! $obRsNuContrato->EOF ()) {
		$stContrato = trim ( $obRsNuContrato->Campo ( "CONTRATO" ) );
		$_SESSION ['cbxNuCon'] = $obRsNuContrato->Campo ( "ID_CONTRATO_OBRA" );
		$_SESSION ['inIdContratoObra'] = $obRsNuContrato->Campo ( "ID_CONTRATO_OBRA" );
		$_SESSION ['stContrato'] = $obRsNuContrato->Campo ( "CONTRATO" );
		$_SESSION ['id'] = $obRsNuContrato->Campo ( "ID_CONTRATO_OBRA" );
		$_SESSION ['edtContrato'] = $obRsNuContrato->Campo ( "CONTRATO" );
	}
}

if ($id_perfil == 2) {
	$obDb = new TDb ();
	$stComando = "SELECT c.CONTRATO CONTRATO
    ,c.ID_CONTRATO_OBRA ID_CONTRATO_OBRA
    ,c.CONSTRUTORA
    ,c.SUPERVISORA
    ,CONCAT (
        c.br
        ,' / '
        ,c.uf
        ) AS bruf
    ,CONCAT (
        s.km_inicial
        ,' ao '
        ,s.km_final
        ) AS km
FROM TB_CONTRATO_OBRA c
    ,tb_siac_segmento s
WHERE c.contrato = s.contrato
    AND c.id_contrato_obra IN (
        SELECT id_contrato_obra
        FROM tb_contrato_supervisora
        WHERE id_supervisora = (
                SELECT id_supervisora
                FROM tb_usuario
                WHERE id_usuario = " . $id_usuario . "
                )
        )";
	$obErro = $obDb->Executa ( $stComando, $ListaContratoIdPerfil2 );
	if (! $obErro->IsOk ())
		echo "db.Executa()" . $obErro->GetDescricao ();
}

// ###############################################################################################################################################################
date_default_timezone_set ( 'America/Sao_Paulo' );

/*
 * $obDb = new TDb ();
 * $Comando = " SELECT COUNT(*) CONTE";
 * $Comando .= " FROM TB_HISTORICOLOGIN ";
 * $Comando .= " WHERE ID_USUARIO =" . $id_usuario;
 * $Comando .= " GROUP BY ID_USUARIO";
 * $obErro = $obDb->Executa ( $Comando, $linha );
 * $inAcessos = $linha->Campo ( 'CONTE' );
 */
// ## fim
// ## quantidade de recibos do usuário

$stPaginaVoltar = 'javascript:popup();';
define ( "K_NAVEGACAO", "Menu Principal" );

// #########################################################
// ### HISTORICO DE ACESSOS
/*
 * $obDb = new TDb ();
 * $Comando = " SELECT CODI_SENHA, DESC_NOME, ID_USUARIO, DATA_ULTIMOACESSO";
 * $Comando .= " FROM TB_USUARIO ";
 * $Comando .= " WHERE email ='" . $nume_matricula . "' ";
 * // $Comando .= " CODI_SENHA = '".$codi_senha."'";
 * $obErro = $obDb->Executa ( $Comando, $linha );
 */
// die($Comando);
// print_r($linha);
// ##########################################################
if (! empty ( $inIdContratoObra )) {
	$faltaConfiguracao = false;
	
	$obDb = new TDb ();
	$Comando = "SELECT sum(qtd_geo) qtd_geo
    ,sum(qtd_passagem) qtd_passagem
    ,sum(qtd_oae) qtd_oae
    ,sum(qtd_ocorrencia) qtd_ocorrencia
    ,sum(qtd_mapa) qtd_mapa
    ,sum(qtd_art) qtd_art
FROM (
    SELECT id_contrato_obra
        ,count(id_configoae) qtd_oae
        ,0 qtd_passagem
        ,0 qtd_geo
        ,0 qtd_ocorrencia
        ,0 qtd_mapa
        ,0 qtd_art
    FROM tb_config_oae
    GROUP BY id_contrato_obra
    
    UNION ALL
    
    SELECT id_contrato_obra
        ,0
        ,count(id_pontopassagem) qtd_passagem
        ,0
        ,0
        ,0
        ,0
    FROM tb_config_pontopassagem
    GROUP BY id_contrato_obra
    
    UNION ALL
    
    SELECT id_contrato_obra
        ,0 qtd_oae
        ,0 qtd_passagem
        ,0 qtd_geo
        ,sum(qtd_Ocor) qtd_ocorrencia
        ,sum(qtd_Mapa) qtd_mapa
        ,sum(qtd_ART) qtd_art
    FROM (
        SELECT id_contrato_obra
            ,sum(CASE 
                    WHEN roteiro = 'Mapa_Situacao'
                        THEN 1
                    ELSE 0
                    END) qtd_Mapa
            ,sum(CASE 
                    WHEN roteiro = 'Diagrama_Ocorrencia'
                        THEN 1
                    ELSE 0
                    END) qtd_Ocor
            ,sum(CASE 
                    WHEN roteiro = 'Anexo_Art'
                        THEN 1
                    ELSE 0
                    END) qtd_ART
        FROM TB_ARQUIVO a
        GROUP BY id_contrato_obra
            ,roteiro
        ) a
    GROUP BY id_contrato_obra
    
    UNION ALL
    
    SELECT id_contrato_obra
        ,0
        ,0
        ,count(id_georeferenciamento) qtd_geo
        ,0
        ,0
        ,0
    FROM tb_config_georeferenciamento
    GROUP BY id_contrato_obra
    ) a
WHERE id_contrato_obra = " . $inIdContratoObra;
	$obErro = $obDb->Executa ( $Comando, $ListaConfiguracaoFaltando );
	if (! $obErro->IsOk ()) {
		echo "Erro = " . $obErro->GetDescricao ();
	}
	
	if ($ListaConfiguracaoFaltando->Campo ( "QTD_OAE" ) == 0 or $ListaConfiguracaoFaltando->Campo ( "QTD_PASSAGEM" ) == 0 or $ListaConfiguracaoFaltando->Campo ( "QTD_GEO" ) == 0 or $ListaConfiguracaoFaltando->Campo ( "QTD_ART" ) == 0 or $ListaConfiguracaoFaltando->Campo ( "QTD_MAPA" ) == 0 or $ListaConfiguracaoFaltando->Campo ( "QTD_OCORRENCIA" ) == 0) {
		$faltaConfiguracao = true;
		
		if ($_SERVER ['PHP_SELF'] != "/sigacont/fm_config_contrato.php") {
			header ( "location: /sigacont/fm_config_contrato.php" );
			exit();
		}
	}
}
// ##########################################################

?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="http://servicos.dnit.gov.br/sigacont/img/favicon-2.png" />
<link rel="icon" href="http://servicos.dnit.gov.br/sigacont/img/favicon-2.png" type="image/x-icon" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>DNIT | SIGACONT</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="/sigacont/bootstrap/css/bootstrap.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="/sigacont/css/font-awesome/font-awesome.min.css">

<!-- Ionicons -->
<link rel="stylesheet" href="/sigacont/css/ionicons/ionicons.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="/sigacont/dist/css/AdminLTE.min.css">

<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        <link rel="stylesheet" href="/sigacont/dist/css/skins/skin-blue-light.min.css">
-->
<link rel="stylesheet" href="/sigacont/dist/css/skins/skin-blue.min.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="/sigacont/plugins/notify/notify.css">

<link href="/sigacont/css/estilos.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/sigacont/plugins/datepicker/datepicker3.css">

<link rel="stylesheet" href="/sigacont/plugins/bootstrap-select/bootstrap-select.min.css">
</script>

<!-- jQuery 1.12.4 -->
<script type="text/javascript" src="/sigacont/plugins/jQuery/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="/sigacont/plugins/jQueryUI/jquery-ui.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="/sigacont/bootstrap/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="/sigacont/dist/js/app.min.js"></script>

<!-- Notify -->
<script src="/sigacont/plugins/notify/notify.js" type="text/javascript"></script>
<script src="/sigacont/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

<script type="text/javascript" src="/sigacont/sigacont/spin.min.js"></script>

<script type="text/javascript" src="/sigacont/inc/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>

<script src="/sigacont/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/sigacont/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/sigacont/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/sigacont/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="/sigacont/plugins/bootstrap-select/bootstrap-select.min.js"></script>

<script>
$(function () {
	   

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
  
    $("[data-mask]").inputmask();

  });
  
$(".ion-help-circled").prop("title", $(".box-title").text());

$(document).ready(function(){
       abrirMenu();

       var spinner = new Spinner({
    	   lines: 13 // The number of lines to draw
    	   , length: 13 // The length of each line
    	   , width: 8 // The line thickness
    	   , radius: 17 // The radius of the inner circle
    	   , scale: 1 // Scales overall size of the spinner
    	   , corners: 1 // Corner roundness (0..1)
    	   , color: '#FFF' // #rgb or #rrggbb or array of colors
    	   , opacity: 0.25 // Opacity of the lines
    	   , rotate: 0 // The rotation offset
    	   , direction: 1 // 1: clockwise, -1: counterclockwise
    	   , speed: 1 // Rounds per second
    	   , trail: 60 // Afterglow percentage
    	   , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
    	   , zIndex: 2e9 // The z-index (defaults to 2000000000)
    	   , className: 'spinner' // The CSS class to assign to the spinner
    	   , top: '50%' // Top position relative to parent
    	   , left: '50%' // Left position relative to parent
    	   , shadow: false // Whether to render a shadow
    	   , hwaccel: false // Whether to use hardware acceleration
    	   , position: 'absolute' // Element positioning
    	   }).spin(document.getElementById('spinLoading'));

       
   	$(document).bind("ajaxSend", function(){
		$("#spinLoading").show();
	}).bind("ajaxComplete", function(){
		$("#spinLoading").hide();
	});
});

function abrirMenu(){
       var url = document.URL;

       url = url.substring(0, url.lastIndexOf(".php") + 4);
       url = url.substring(url.lastIndexOf("/") + 1);
	   if (url.indexOf("?") >= 0)
			url = url.substring(0, url.indexOf("?"));
		if (url.indexOf("fm_") == 0)
			url = "te_" + url.substring(url.indexOf("fm_") + 3);
	   while(url.indexOf("#") >= 0)
		   url = url.replace("#", "");
	   
       if (url.length != 0){
             var sidebar = $(".sidebar-menu");

             var todosA = sidebar.find("a");
             for ( var i in todosA) {
                    var a = $(todosA[i]);
            var link = $(todosA[i]).attr("href");

            if (link && link.indexOf(url) >= 0) {
            var li = a.parent("li");

            if (li.children("a[href='#']").length == 0)
                li = a.parent("li").parent("ul").parent("li");
            
                do {
                   a = $(li.children("a[href='#']")[0]);
                   a.click();
                                  
                   li = li.parent("ul").parent("li");
                   if (li.children("a[href='#']").length == 0)
                       li = li.parent("ul").parent("li");
                } while (li.length != 0);
			break;
            }
        }
       }
}

function passaId(inIdContratoObra){
  $('#gridSystemModal').modal('hide');
  
  window.location="/sigacont/index.php?inIdContratoObra="+inIdContratoObra;
}

<?php
if (! empty ( $id )) {
	echo "\$(document).ready(function() { \$('#gridSystemModal').modal('show'); });";
}
?>
</script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div id="spinLoading" style="display: none; z-index: 10000; border: 1px solid #666; width: 120px; height: 120px; position: fixed; top: calc(50% - 60px); left: calc(50% - 60px); border-radius: 14px; box-shadow: black 2px 2px 40px; opacity: 0.75; background-color: #3c8dbc;"></div>
	<div class="wrapper">
		<header class="main-header">
			<a href="/sigacont/index.php" class="logo"> <!-- mini logo for sidebar mini 50x50 pixels --> <span class="logo-mini">&nbsp;</span> <!-- logo for regular state and mobile devices --> <span class="logo-lg"></span>
			</a>

			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> </a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="hidden-xs"><?=$desc_nome?></span><span class="visible-xs"><?=explode(' ',trim($desc_nome))[0]?></span>
						</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<p><?= $desc_nome?>
									<small>Ultimo acesso em <?=$dt_Ultacesso?></small>
									</p>
								</li>
								<li class="user-body"></li>
								<li class="user-footer">
									<div class='pull-left'>
										<a href="/sigacont/sigacont/profile.php?stOperacao=2" class="btn btn-default btn-flat">Perfil</a>
									</div>
									<div class="pull-right">
										<a href="/sigacont/default.php" class="btn btn-default btn-flat">Sair</a>
									</div>
								</li>
							</ul></li>
					</ul>
				</div>
			</nav>
		</header>
		<aside class="main-sidebar">
			<section class="sidebar">
<?php if ($id_perfil == 1){?> 
				<form name="formModalContrato" action="#" method="post" class="sidebar-form">
					<div class="input-group">
						<input type="text" name="id" class="form-control" placeholder="<?= (empty($stContrato)? "Pesquisar Contrato..." : $stContrato) ?>"> <span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</div>
				</form>
				<ul class="sidebar-menu">
					<li class="treeview"><a href="#"><i class="fa fa-link"></i> <span>Administrativo</span> <i class="fa fa-angle-left pull-right"></i> </a>
						<ul class="treeview-menu">
							<li class="treeview"><a href="/sigacont/sigacont/te_pesqrecibo.php"> <i class="fa fa-search"></i> Pesquisar Recibo
							</a></li>
							<li class="treeview"><a href="#"><i class="fa fa-users"></i> Gestão de Usuários <i class="fa fa-angle-left pull-right"></i> </a>
								<ul class="treeview-menu">
									<li><a href="/sigacont/sigacont/te_cadusuario.php"><i class="fa fa-circle-o"></i>Usuários</a></li>
									<!-- Junção da função Pesquisa na tela de Novo Usuário -->
									<!--<li><a href="/sigacont/sigacont/te_pesqacesso_usuario.php"><i class="fa fa-circle-o"></i>Pesquisar Usuário</a></li>-->
								</ul></li>
						</ul></li>
<?php
} else {
	?>
					<form name="formModalContrato" action="#" method="post" class="sidebar-form">
						<select class="selectpicker" data-live-search="true" onchange="passaId($(this).val());">
<?php
	echo '<option disabled ' . (!isset ( $_SESSION ['edtContrato'] ) ? 'selected' : '') . '>Selecione um Contrato</option>';

	while ( ! $ListaContratoIdPerfil2->EOF () ) {
		echo '<option ' . (isset ( $_SESSION ['edtContrato'] ) and $_SESSION ['edtContrato'] == $ListaContratoIdPerfil2->Campo ( "CONTRATO" ) ? 'selected' : '') . ' value="' . $ListaContratoIdPerfil2->Campo ( "ID_CONTRATO_OBRA" ) . '">' . $ListaContratoIdPerfil2->Campo ( "CONTRATO" ) . '</option>';
		$ListaContratoIdPerfil2->Proximo ();
	}
	?>
							</select>
					</form>
	<?php
}
if ($id_perfil != 0 and ! empty ( $inIdContratoObra )) {
	if ($faltaConfiguracao == true) {
		?> 	
	<script>$.notify("É necessário configurar o contrato <?=$stContrato?> antes de poder continuar.<?=$ListaConfiguracaoFaltando->Campo ( "QTD_GEO" ) == 0 ? "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Não há Georreferenciamento cadastrados." : ""?><?=$ListaConfiguracaoFaltando->Campo ( "QTD_PASSAGEM" ) == 0 ? "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Não há Pontos de Passagens cadastrados." : ""?><?=$ListaConfiguracaoFaltando->Campo ( "QTD_OCORRENCIA" ) == 0 ? "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Não há Diagrama de Ocorrências cadastrados." : ""?><?=$ListaConfiguracaoFaltando->Campo ( "QTD_MAPA" ) == 0 ? "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Não há Mapa de Situação cadastrados." : ""?><?=$ListaConfiguracaoFaltando->Campo ( "QTD_OAE" ) == 0 ? "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Não há OAE's cadastradas." : ""?><?=$ListaConfiguracaoFaltando->Campo ( "QTD_ART" ) == 0 ? "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;Não há ART cadastradas." : ""?>","error");</script>
					<ul class="sidebar-menu">
						<li class="treeview"><a href="#"> <i class="fa fa-cogs"></i> <span>Configurações</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="/sigacont/sigacont/te_cadgeoreferenciamento.php"><i class="fa fa-map-marker"></i> Georreferenciamento</a></li>
								<li><a href="/sigacont/sigacont/te_cadpontopassagem.php"><i class="fa fa-map-marker"></i> Pontos de Passagem</a></li>
								<li><a href="/sigacont/sigacont/te_caddiagrama_ocorrencia.php"><i class="fa fa-circle-o"></i> Diagrama de Ocorrências</a></li>
								<li><a href="/sigacont/sigacont/te_cadmapa_situacao.php"><i class="fa fa fa-map-o"></i> Mapa de Situação</a></li>
								<li><a href="/sigacont/sigacont/te_cadconfigoae.php"><i class="fa fa-plus"></i> Cadastro de OAE´s</a></li>
								<li><a href="/sigacont/sigacont/te_cadanexo_art.php"><i class="fa fa-paperclip"></i> ART</a></li>
							</ul></li>
	<?php
	} else {
		?>
						<ul class="sidebar-menu">
							<li class="treeview"><a href="#"> <i class="fa fa-street-view"></i> <span>Superintendência</span> <i class="fa fa-angle-left pull-right"></i>
							</a>
								<ul class="treeview-menu">
									<li><a href="/sigacont/sigacont/te_cadlicitacao.php"><i class="fa fa-plus"></i> Novas Licitações/Convênios</a></li>
								</ul></li>
							<li class="treeview"><a href="#"> <i class="fa fa-cogs"></i> <span>Configurações</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<!-- Tela de Supervisora migrada pra tela de Perfil -->
									<!-- <li><a href="/sigacont/sigacont/te_cadconfigsupervisora.php"><i class="fa fa-plus"></i> Supervisoras</a></li>  -->
									<li><a href="/sigacont/sigacont/te_cadgeoreferenciamento.php"><i class="fa fa-map-marker"></i> Georreferenciamento</a></li>
									<li><a href="/sigacont/sigacont/te_cadpontopassagem.php"><i class="fa fa-map-marker"></i> Pontos de Passagem</a></li>
									<li><a href="/sigacont/sigacont/te_caddiagrama_ocorrencia.php"><i class="fa fa-circle-o"></i> Diagrama de Ocorrências</a></li>
									<li><a href="/sigacont/sigacont/te_cadmapa_situacao.php"><i class="fa fa fa-map-o"></i> Mapa de Situação</a></li>
									<li><a href="/sigacont/sigacont/te_cadconfigoae.php"><i class="fa fa-plus"></i> Cadastro de OAE´s</a></li>
									<li><a href="/sigacont/sigacont/te_cadanexo_art.php"><i class="fa fa-paperclip"></i> ART</a></li>
								</ul></li>
							<li class="treeview"><a href="#"> <i class="fa fa-line-chart"></i> <span>Planejamento</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="/sigacont/sigacont/te_cadcronograma_financeiro.php"><i class="fa fa-line-chart"></i> Cronograma Financeiro</a></li>
									<li><a href="/sigacont/sigacont/te_cadcronograma_fisico_is.php"><i class="fa fa-line-chart"></i> Cronograma Físico</a></li>
								</ul></li>

							<li><a href="/sigacont/sigacont/te_cadlicenca_ambiental.php"><i class="fa fa-pagelines"></i><span>Licença ambiental</span></a></li>
							<li class="treeview"><a href="#"><i class="fa fa-road"></i><span>Relatório de supervisão</span><i class="fa fa-angle-left pull-right"></i> </a>
								<ul class="treeview-menu">

									<li class="treeview"><a href="/sigacont/sigacont/te_cadresumo.php"><i class="fa fa-file-text-o"></i> Resumo</a></li>
									<li class="treeview"><a href="#"><i class="fa fa-paper-plane-o"></i> Atividades da Supervisora <i class="fa fa-angle-left pull-right"></i> </a>
										<ul class="treeview-menu">
											<li><a href="/sigacont/sigacont/te_cadapresentacao.php"><i class="fa fa-circle-o"></i> Apresentação</a></li>
											<li><a href="/sigacont/sigacont/te_cadatividade_executada.php"><i class="fa fa-circle-o"></i> Atividades Executadas</a></li>
											<li><a href="/sigacont/sigacont/te_cadpessoal_supervisora.php"><i class="fa fa-circle-o"></i> Relação de Mobilização</a></li>

										</ul></li>
									<li class="treeview"><a href="#"><i class="fa fa-wrench"></i>Atividades da Construtora <i class="fa fa-angle-left pull-right"></i> </a>
										<ul class="treeview-menu">
											<li><a href="/sigacont/sigacont/te_cadapresentacao_construtora.php"><i class="fa fa-circle-o"></i> Apresentação</a></li>
											<li><a href="/sigacont/sigacont/te_cadavanco_fisico_is.php"><i class="fa fa-circle-o"></i> Avanço Físico de Obra</a></li>
											<li><a href="/sigacont/sigacont/te_cadoae_is.php"><i class="fa fa-circle-o"></i> OAE</a></li>
											<li><a href="/sigacont/sigacont/te_cadinterferencia.php"><i class="fa fa-circle-o"></i> Interferências Executivas</a></li>
											<li><a href="/sigacont/sigacont/te_cadrfpo.php"><i class="fa fa-circle-o"></i> RPFO</a></li>
											<li><a href="/sigacont/sigacont/te_cadresumo_projeto.php"><i class="fa fa-circle-o"></i> Resumo dos Projetos</a></li>
											<li><a href="/sigacont/sigacont/te_cadrelacao_obra.php"><i class="fa fa-circle-o"></i> Relação de Mobilização</a></li>
											<li><a href="/sigacont/sigacont/te_cadservicos_executados.php"><i class="fa fa-circle-o"></i> Serviços Executados</a></li>
											<li><a href="/sigacont/sigacont/te_cadatividades_criticas.php"><i class="fa fa-circle-o"></i> Atividades Críticas</a></li>
											<li><a href="/sigacont/sigacont/te_cadrnc.php"><i class="fa fa-circle-o"></i> RNC</a></li>
											<li><a href="/sigacont/sigacont/te_caddocumentacao_fotografica.php"><i class="fa fa-circle-o"></i> Documentação Fotográfica</a></li>
											<li><a href="/sigacont/sigacont/te_caddiario_obra.php"><i class="fa fa-circle-o"></i> Diário de Obra</a></li>
											<li><a href="/sigacont/sigacont/te_cadensaio_laboratorio.php"><i class="fa fa-circle-o"></i> Ensaios de Laboratório</a></li>
											<li><a href="/sigacont/sigacont/te_cadcontrole_pluviometrico.php"><i class="fa fa-circle-o"></i> Controle Pluviométrico</a></li>
											<li><a href="/sigacont/sigacont/te_cadcomponente_ambiental.php"><i class="fa fa-circle-o"></i> Componente Ambiental</a></li>
											<li><a href="/sigacont/sigacont/te_cadconclusao_comentario.php"><i class="fa fa-circle-o"></i> Conclusão e Comentários</a></li>
										</ul></li>
									<!-- /.third level-->

									<li class="treeview"><a href="/sigacont/sigacont/te_cadatas_correspondencia.php"><i class="fa fa-envelope-o"></i>Atas e Correspondências</a></li>
									<li class="treeview"><a href="/sigacont/sigacont/te_cadconclusao_geral_empreendimento.php"><i class="fa fa-check-square-o"></i>Conclusão Geral</a></li>
									<li class="treeview"><a href="/sigacont/sigacont/te_cadanexo_supervisao.php"><i class="fa fa-paperclip"></i>Anexos</a></li>
									<li class="treeview"><a href="/sigacont/sigacont/te_cadtermo_encerramento.php"><i class="fa fa-legal"></i>Termo de Encerramento</a></li>
								</ul></li>
							<li class="treeview"><a href="#"> <i class="fa fa-print"></i><span>Imprimir relatório</span><i class="fa fa-angle-left pull-right"></i>
							</a>
								<ul class="treeview-menu">
									<!--<li><a href="/sigacont/sigacont/te_cadrecibo.php"><i class="fa fa-file-text-o"></i>Recibo</a></li>-->
									<li><a href="/sigacont/sigacont/te_cadrecibo_supervisao.php"><i class="fa fa-bar-chart"></i>Relatório de supervisão</a></li>
								</ul></li>
							<li class="treeview"><a href="#"> <i class="fa fa-truck"></i> <span>Gerenciamento</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="/sigacont/sigacont/te_painel.php"><i class="fa fa-dashboard"></i>Painel</a></li>
									<li><a href="/sigacont/sigacont/te_diagrama_unifilar.php"><i class="fa fa-line-chart"></i>Diagrama unifilar</a></li>
									<li class="treeview"><a href="/sigacont/sigacont/te_download_mapa.php"><i class="fa fa-globe"></i><span>Mapas</span></a></li>
									<li class="treeview"><a href="/sigacont/sigacont/fm_cadbriefing.php"><i class="fa fa-newspaper-o"></i><span>Briefing</span></a></li>
								</ul></li>
<?php
	}
}
?>
				</ul>
			
			</section>
		</aside>

		<div id="gridSystemModal" class="modal fade bd-example-modal-sm modal-primary" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title text-center" id="gridModalLabel">SELECIONE O CONTRATO E NAVEGUE PELO SISTEMA</h4>
					</div>

					<div class="modal-body">
						<div class="container-fluid bd-example-row">
<?php
$Registros = 0;
while ( ! empty ( $obRsNuContrato ) && ! $obRsNuContrato->EOF () ) {
	?>
							 <div class="row <?=($Registros % 2 == 0 ? "par" : "impar")?>">
								<div class="col-md-4">
									<a style="color: white;" href="javascript:passaId('<?=$obRsNuContrato->Campo("ID_CONTRATO_OBRA"); ?>');"><?=$obRsNuContrato->Campo("CONTRATO"); ?></a>
								</div>
								<div class="col-md-4">
									<a style="color: white;" href="javascript:passaId('<?=$obRsNuContrato->Campo("ID_CONTRATO_OBRA"); ?>');"><?=utf8_encode($obRsNuContrato->Campo("BRUF")); ?></a>
								</div>
								<div class="col-md-4">
									<a style="color: white;" href="javascript:passaId('<?=$obRsNuContrato->Campo("ID_CONTRATO_OBRA"); ?>');"><?=utf8_encode($obRsNuContrato->Campo("KM")); ?></a>
								</div>
							</div>
<?php
	$obRsNuContrato->Proximo ();
	$Registros ++;
}
?>
  
    </div>
					</div>
				</div>
			</div>
		</div>
		<!--#############modal###############-->

		<div class="content-wrapper">
			<section class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12">
							<h6>

								<a href="/sigacont/index.php"><i class="fa fa-dashboard"></i> Home</a> > <?= isset ( $_SESSION ['edtContrato'] ) ? $_SESSION ['edtContrato'] : NULL;?>
							</h6>
						</div>
					</div>
				</div>

				<div class="box box-primary">
					<div class="row">
						<div class="col-md-12">