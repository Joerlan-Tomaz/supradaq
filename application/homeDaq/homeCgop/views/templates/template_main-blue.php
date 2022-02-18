<?php
$ip_server = $_SERVER['SERVER_NAME'];
if ($ip_server == '10.100.11.167') {
    $desc_nome = 'Desenvolvedor';
} else {
    /* include_once ("../inc/include_verificasession.php");
      include_once ("../inc/un_funcoes.inc");
      include_once ("../inc/un_const.inc");
      $desc_nome = utf8_encode($_SESSION ['desc_nome']);
      $dt_Ultacesso = $_SESSION ['dt_Ultacesso'];
      $boAlteraSenha = $_SESSION ['boAlteraSenha'];
      //echo($id_perfil);
      //keping user ID to be sent by url
      $userId = md5(date("Y-m-d H")) . $_SESSION ['id_usuario'] . md5(date("Y-m-d H:i")); */
    $dt_Ultacesso = date('Y-m-d');
    $desc_nome = 'Desenvolvedor';
}
?>
<!DOCTYPE html>
<html lang="pt" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <title>SUPRA - CGPERT</title>

        <meta name="description" content="SUPRA - CGPERT" />
        <meta name="keywords" content="supra, supervisão, avançada" />
        <meta name="author" content="DIR" />

        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/all.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/brands.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/fontawesome.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/regular.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/solid.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/svg-with-js.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.min.css">

        <link rel="shortcut icon" href="<?= $this->config->item('base_url_supra') ?>/img/favicon-2.png" />
        <link rel="icon" href="<?= $this->config->item('base_url_supra') ?>/img/favicon-2.png" type="image/x-icon" />

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/css/default.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/css/component.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/css/style.css" />
        <!-- Theme style -->

        <script src="<?php echo base_url('assets'); ?>/js/modernizr.custom.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('base_url_supra') ?>/plugins/jQuery/jquery-1.12.4.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/menu.css" type="text/css" media="screen"/>	
        <link rel="stylesheet" href="<?= $this->config->item('base_url_supra') ?>/3d-bold-navigation/css/reset.css"> <!-- CSS reset -->
        <link rel="stylesheet" href="<?= $this->config->item('base_url_supra') ?>/3d-bold-navigation/css/style.css"> <!-- Resource style -->		
    </head>
    <script type="text/javascript">

        function Mudarestado(el) {
            var display = document.getElementById(el).style.display;
            if (display == "none")
                document.getElementById(el).style.display = 'block';
            else
                document.getElementById(el).style.display = 'none';
        }

        $().ready(function () {
            document.oncontextmenu = document.body.oncontextmenu = function () {
                return false;
            }
            if (document.getElementById) {
                var exibeResultado = $('#exibeFotoMiniHome');
            }

/*             $.ajax({
                method: "POST",
                url: "<?= $this->config->item('base_url_supra') ?>/pages/un_cadprofile.php?operacao=fotoMiniHome"
            }).done(function (resultado) {
                try {
                    resultado = resultado.replace(/\+g/, " ");
                    resultado = unescape(resultado);
                    exibeResultado.html(resultado);

                } catch (e) {
                    exibeResultado.html('<p>Ouve algum erro na requisição</p>');
                }
            }); */
        });

        function redirectAssessoria() {
            window.location.href = "<?= $this->config->item('base_url_supra') ?>/home_dir/index";
        }

        function redirectContrucao() {
            window.location.href = "<?= $this->config->item('base_url_supra') ?>/home_cgcont/index";
        }

        function redirectManutencao() {
            location.reload();
        }

        function redirectOperacao() {
            window.location.href = "<?= $this->config->item('base_url_supra') ?>/home_cgpert/index";
        }


    </script>
    <style>
        *{
            margin:0;
            padding:0;
        }
        body{
            font-family:Arial;

        }
        .title{
            width:548px;
            height:119px;
            position:absolute;
            top:400px;
            left:150px;
            background:transparent url(menu/title.png) no-repeat top left;
        }
        a.back{
            background:transparent url(menu/back.png) no-repeat top left;
            position:fixed;
            width:150px;
            height:27px;
            outline:none;
            bottom:0px;
            left:0px;
        }
        #content{
            margin:0 auto;
        }

        a:hover{
            color:#4083ae !important;
        }

        .titulo{
            display: block;
            font-size: 20px;
            margin-top: 50px;
            margin-bottom: 20px;
            float: left;
            font-weight: bold;
            color: #fff;
        }

        .cd-nav li > a .cbp-ig-icon {
            color: #232d61;
        }
        .cd-nav li > a:hover .cbp-ig-icon {
            color: #fff;
        }
        .cd-nav li {
            height: calc((100vh - 380px)/3);
            min-height: 160px;
        }
        .resizeIcon{
            font-size: 13px !important;
        }

        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            list-style: none;
            border-radius: 0.25rem;
        }

        .breadcrumb-item + .breadcrumb-item {
            padding-left: 0.5rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            display: inline-block;
            padding-right: 0.5rem;
            color: #6c757d;
            content: "/";
        }

        .breadcrumb-item + .breadcrumb-item:hover::before {
            text-decoration: underline;
        }

        .breadcrumb-item + .breadcrumb-item:hover::before {
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

    </style>
    <body oncontextmenu="return false">
        <div class="container">
            <a href="#cd-nav" class="cd-nav-trigger">
                Menu<span><!-- used to create the menu icon --></span>
            </a> <!-- .cd-nav-trigger -->

            <nav class="cd-nav-container" id="cd-nav">
                <header>
                    <a href="#0" class="cd-close-nav">Close</a>
                </header>

                <ul class="cd-nav">
                    <li class="cd-selected">
                        <a href="javascript:void(0);" onclick="redirectAssessoria();">                          
                            <span class="cbp-ig-icon cbp-ig-icon-ico_assessoria2 resizeIcon" style="color:#fff"></span>                           
                            <em>Assessoria</em>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" onclick="redirectContrucao();">
                            <span class="cbp-ig-icon cbp-ig-icon-ico_caminhao resizeIcon"></span>
                            <em>Constru&ccedil;&atilde;o</em>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" onclick="redirectManutencao();">
                            <span class="cbp-ig-icon cbp-ig-icon-ico_cavalete resizeIcon"></span>
                            <em>Manuten&ccedil;&atilde;o</em>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" onclick="redirectOperacao();">
                            <span class="cbp-ig-icon cbp-ig-icon-ico_cone resizeIcon"></span>
                            <em>Opera&ccedil;&otilde;es</em>
                        </a>
                    </li>
                </ul> <!-- .cd-3d-nav -->
            </nav> 
            <header class="clearfix">			 
                <div class="esquerda"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets'); ?>/img/logo_supra.png"></a></div>
                <nav2>
                    <h6 class="titulo">DIRETORIA DE INFRAESTRUTURA RODOVI&Aacute;RIA</h6> </br>

                </nav2>	
                <div class="caminho">
                    <!--<ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>CGPERT</li>
                    </ul>-->
                    <?= $this->breadcrumbs->show(); ?>
                </div>		
                <div style="float: right; position: relative; right: 45px;"><br/><br/>
                    <span id="resultado">
                        <!-- <span id="exibeFotoMiniHome"></span> -->
                        <!-- <span style="clear: both;"></span> -->
                    </span>  
                    <strong style="color: white;">Olá, <a href="javascript:void(0);" onclick="Mudarestado('minhaDiv');"><?= $desc_nome ?>.</a></strong><br/>
                    <div id="minhaDiv" style="float: right; display: none">
                        <br/>
                        <li><small style="color: white;">Ultimo Acesso: <?= $dt_Ultacesso ?></small><br/></li>
                        <li><small><a href="<?= $this->config->item('base_url_supra') ?>/pages/te_cadprofile_navegabilidade">Ver Perfil</a></small><br/></li>
                        <li><small><a href="<?= $this->config->item('base_url_supra') ?>/pages/un_cadlogout.php">Sair</a></small><br/></li>
                    </div>
                </div>	
            </header>	

            <!-- conteudo - - - - -->
            <div class="main">                
                <?= $contents ?></div>
        </div>	
        <footer>
            <img src="<?= $this->config->item('base_url_supra') ?>/img/logos_dnit_branco_semfundo.png"  width="40%" style="float: right; position: relative; right: 70px;">
        </footer>
    </div>
</body>
</html>
