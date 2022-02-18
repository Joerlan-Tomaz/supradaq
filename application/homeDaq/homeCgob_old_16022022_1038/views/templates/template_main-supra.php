
<?php
/*
 * DNIT
 * SIGACONT
 * Programador:Sergio Ricardo
 * Data:28/02/2018 1401
 *
 * controle de menu indexView /
 * =======================================================
 * Alterações efetuadas:(Programador,Data,Descrição da alteração!)
 * -------------------------------------------------------
 * -------------------------------------------------------
 */
#-------------------------------------------------------------------------------------------------------------------------------------------------------------#
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
#-------------------------------------------------------------------------------------------------------------------------------------------------------------#
#-------------------------------------------------------------------------------------------------------------------------------------------------------------#
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>SUPRA - CGPERT</title>
        <meta name="description" content="SUPRA - Página Inicial" />
        <meta name="keywords" content="supra, supervisão, avançada" />
        <meta name="author" content="DIR" />
        <link rel="shortcut icon" href="<?php echo (base_url('assetsassets/img/favicon-2.png'));?>" />
        <link rel="icon" href="<?php echo (base_url('assetsassets/img/favicon-2.png'));?>" type="image/x-icon" />

        <!-- CSS Home -->
        <link rel="stylesheet" type="text/css" href="<?php echo (base_url('assets/plugins/blocs/css/set1.css')) ?>" />
        <!-- CSS Home Coordenação -->
        <link rel="stylesheet" type="text/css" href="<?php echo (base_url('assets/css/default.css')) ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo (base_url('assets/css/component.css')) ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo (base_url('assets/css/style.css')) ?>" /> 
        <!-- CSS Notify -->
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/notify/notify.css')) ?>">
        <!-- CSS Datatables -->
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/datatables/dataTables.bootstrap4.css')) ?>">
        <!-- <link rel="stylesheet" href="<?php //echo (base_url('assets/plugins/datatables/dataTables.bootstrap.css'))    ?>"> -->
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/datatables/jquery.dataTables2.css')) ?>">
        <!-- CSS Wizard Steps -->
        <link href="<?php echo (base_url('assets/css/estilos_wizard.css')) ?>" rel="stylesheet" type="text/css">
        <!-- CSS Datepicker -->
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/datepicker/datepicker3.css')) ?>">
        <!-- CSS Select 2 -->
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css')) ?>">
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/select2/select2.css')) ?>">
        <!-- CSS Fancybox -->       

        <link rel="stylesheet" type="text/css" href="<?php echo (base_url('assets/plugins/fancybox/dist/jquery.fancybox.min.css')) ?>">
        <!-- Mapa Brasil -->
        <link href="<?php echo (base_url('assets/plugins/mapa-svg/mapa-svg.css')) ?>" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="<?php echo (base_url('assets/fontawesome/css/fontawesome.css')) ?>">   
        <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/dist/css/adminlte.css')) ?>">   
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">        
        
           <!-- fontawesome https://fontawesome.com/icons?d=gallery -->
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/all.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/brands.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/fontawesome.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/regular.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/solid.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/svg-with-js.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.min.css">
        
        <style> 
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
    </head>

    <body oncontextmenu="return false" class="" <?php if (ENVIRONMENT != ('development' or 'local' or 'testing')) { ?>oncontextmenu="return false"<?php } ?>>

        <div class="headerPrincipal">	
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">


                    <a href="<?php echo site_url('Home')?>"><img src="<?php echo (base_url('assets/img/logo_site_branco.png')) ?>" style=" width: 185px; top: 32px; position: relative; left: 8px;"></a>

                </div>
                <div class="col-xs-6 col-sm-4 col-md-5">

                    <span class="titulo">DIRETORIA DE INFRAESTRUTURA RODOVI&Aacute;RIA</span>

                </div>

                <div class="col-xs-6 col-sm-4 col-md-4">

                    <div class="pull-right"><br/><br/>
                        <span id="resultado">
                            <span id="exibeFotoMiniHome"></span>
                            <span style="clear: both;"></span>
                        </span>  
                        <a class="nav-link" data-toggle="dropdown" href="#" style="color: white;">
                            <strong class="profileName">
<!--                                <span id="turno" ></span> <?php echo substr($this->session->desc_nome, 0, 20); ?>.-->
                            </strong><br/>
                        </a>

                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a class="dropdown-item">
                                <div class="media" style=" font-size: 12px;">
                                    <div class="media-body">
<!--                                        <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> Ultimo Acesso: <?= $this->session->dt_Ultacesso ?></p>-->
                                    </div>
                                </div>
                            </a>
                            <a href="/supra/pages/SolicitaAcesso/index" class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-sm">Administrativo</p>
                                    </div>
                                </div>
                            </a>
                            <a href="/supra/pages/te_cadprofile_navegabilidade" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-sm">Ver Perfil</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="/supra/pages/un_cadlogout.php" class="dropdown-item dropdown-footer"><i class="fa fa-fw fa-sign-out"></i> Sair</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rightnavbar caminho">
                <?= $this->breadcrumbs->show(); ?>
            </div>	
        </div>	

        <div class="main">                
            <?= $contents ?>
        </div>

        <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/jquery/jquery.min.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/bootstrap/js/bootstrap.bundle.min.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/AdminLTE_300/dist/js/adminlte.js')) ?>"></script>


        <!-- JS Notify -->
        <script src="<?php echo (base_url('assets/plugins/notify/notify.js')) ?>" type="text/javascript"></script>
        <!-- JS Bootbox-->
        <script src="<?php echo (base_url('assets/plugins/bootbox/bootbox.min.js')) ?>" type="text/javascript"></script>
        <!-- JS Datatable
        <script src="<?php //echo (base_url('assets/plugins/datatables/jquery.dataTables.min.js'))    ?>" type="text/javascript"></script>
        <script src="<?php //echo (base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'))    ?>" type="text/javascript"></script>-->
        <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/datatables/jquery.dataTables.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/datatables/dataTables.bootstrap4.js')) ?>"></script>
        <!-- JS SPIN-->
        <script type="text/javascript" src="<?php echo (base_url('assets/js/spin.min.js')) ?>"></script>
        <!-- JS Datepicker e InputMask-->
        <script src="<?php echo (base_url('assets/plugins/datepicker/bootstrap-datepicker.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/plugins/input-mask/jquery.inputmask.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js')) ?>"></script>
        <!-- JS Select 2 -->
        <script src="<?php echo (base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/plugins/select2/select2.js')) ?>"></script>
        <!-- JS Fancybox -->   
        <script src="<?php echo (base_url('assets/plugins/fancybox/dist/jquery.fancybox.min.js')) ?>"></script>
        <!-- JS CK Editor -->
        <script src="<?php echo (base_url('assets/plugins/ckeditor/ckeditor.js')) ?>"></script>
        <!-- JS ScrollTo 
        <script src="<?php //echo (base_url('assets/plugins/scrollTo/jquery.scrollTo.min.js'))    ?>"></script>-->

        <!-- Highcharts -->
        <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/highcharts.js')) ?>"></script>       
        <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/highcharts-more.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/highcharts-3d.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/modules/solid-gauge.js')) ?>"></script>

        <!-- Mapa Brasil -->
        <script src="<?php echo (base_url('assets/plugins/mapa-svg/mapa-svg.js')) ?>"></script>

        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

        <script src="<?php echo (base_url('assets/js/home/home.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/js/homeCgcont/home.js')) ?>"></script>

        <!-- Arquivo comum com funções JS -->
        <script src="<?php echo (base_url('assets/js/comum/comum_js.js')) ?>"></script>

        <!-- Arquivo comum com funções JS -->
        <!--<script src="<?php echo (base_url('assets/js/homeCgpert/ContagemTrafego/contagemTrafego.js')) ?>"></script>-->
        <!--<script src="<?php echo (base_url('assets/js/homeCgpert/ContagemTrafego/datatablesContagemTrafego.js')) ?>"></script>-->

        <!--<script src="<?php echo (base_url('assets/js/homeCgpert/Pesagem/pesagem_grafico_cgpert.js')) ?>"></script>-->



        

        <!-- Carrega do loading -->
        <script>
            $(document)
                .ajaxStart(function () {
                    $('.loading').show();
                })
                .ajaxStop(function () {
                    setTimeout(function () { $('.loading').hide(); }, 800);
                });
		</script>
    </body>

</html>
