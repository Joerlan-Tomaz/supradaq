<?php
if(is_null($this->session->id_usuario)){
	redirect(base_url("Login/logout"));
}

if (!isset($is_ajax) or $is_ajax === false) {
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
            <title>SUPRA - Página Inicial</title>
            <meta name="description" content="SUPRA - Página Inicial" />
            <meta name="keywords" content="supra, supervisão, avançada" />
            <meta name="author" content="DIR" />
            <meta http-equiv="cache-control" content="max-age=0" />
            <meta http-equiv="cache-control" content="no-cache" />
            <meta http-equiv="expires" content="0" />
            <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
            <meta http-equiv="pragma" content="no-cache" />
            <link rel="shortcut icon" href="<?php echo (base_url('assets/img/favicon-2.png')) ?>" />
            <link rel="icon" href="<?php echo (base_url('assets/img/favicon-2.png')) ?> " type="image/x-icon" />
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
           
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

            <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/font-awesome/css/font-awesome.min.css')) ?>">   
            <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/dist/css/adminlte.css')) ?>">   
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">  
            
             <!-- Calendario -->
             <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/fullcalendar/fullcalendar.min.css')) ?>">
            <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/fullcalendar/fullcalendar.print.css')) ?>"  media="print">

            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/all.css">
            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/brands.css">
            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/fontawesome.css">
            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/regular.css">
            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/solid.css">
            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/svg-with-js.css">
            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.css">
            <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.min.css">

            <!-- Calendario -->
            <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/fullcalendar/fullcalendar.min.css')) ?>">
            <link rel="stylesheet" href="<?php echo (base_url('assets/AdminLTE_300/plugins/fullcalendar/fullcalendar.print.css')) ?>"  media="print">  
            <?php
            if (isset($links_header)) {
                foreach ($links_header as $item) {
                    ?>
                    <link rel="stylesheet" href="<?= $item ?>">

                    <?php
                }
            }

            if (isset($scripts_header)) {
                foreach ($scripts_header as $item) {
                    ?>
                    <script src="<?= $item ?>" type="text/javascript"></script>
                    <?php
                }
            }
            ?>

            <?php
            if (isset($alerts)) {
                foreach ($alerts as $key => $item) {
                    ?><script type="text/javascript">
                        $(document).ready(function () {
                            $.notify("<?= $item ?>", '<?= $key ?>');
                        });
                    </script>
                    <?php
                }
            };
            ?>  

            <script type="text/javascript">
                var base_url = '<?= base_url();?>';
            </script>
        </head>

        <body class="sidebar-mini" <?php if (ENVIRONMENT != ('development' or 'local' or 'testing')) { ?>oncontextmenu="return false"<?php } ?>>
            <style>
                /* #spinner{
                    position: fixed;
                    height: 20%;
                    z-index: 1055;
                    top: 40%;
                    margin-bottom: auto;
                    margin-left: 40%;
                    margin-right: 45%;
                    background-color: white;
                    border-radius: 25px;
                    box-shadow: 1px 0px 10px silver;
                }  */
                #spinner {
                    position: fixed;
                    height: 17%;
                    z-index: 1055;
                    border-radius: 25px;
                    box-shadow: 2px 6px 15px #797676;
                    backdrop-filter: blur(5px);
                    top: 45%;
                    left: 50%;
                    padding: 25px;
                    transform: translate(-50%, -50%);
                    background: rgb(0 0 0 / 40%);
                }

                @media (max-width: 767px){
                    #spinner {
                        position: fixed;
                        height: 13%;
                        z-index: 1055;
                        border-radius: 25px;
                        box-shadow: 5px 11px 20px #797676;
                        backdrop-filter: blur(5px);
                        top: 50%;
                        left: 50%;
                        padding: 15px;
                        transform: translate(-50%, -50%);
                        background: rgb(0 0 0 / 40%);
                    }
                }


                body { padding-right: 0 !important }

                .modal-open {
                    padding-right: 0px !important;
                }
            </style>
            <img id="spinner" class="log" src="<?php echo (base_url('assets/img/spinner3.gif')) ?>" alt="">
            <div class="headerPrincipal no-print">  
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8">
                        <a href="<?= base_url('home'); ?>"><img src="<?php echo (base_url('assets/img/logo_site_branco.png')) ?>" style=" display: inline-block;
                            width: 185px;
                            height: auto;
                            margin: 13px 37px;">
                        </a>
                    
                        <span style="display: inline-block;margin: 10px 0;font-size: 14px;color: #fff;">
                            <span id="tipoDiretoria">DIRETORIA DE INFRAESTRUTURA</span> - <?php echo shell_exec("git log -1 --pretty=format:'%h - (%ci)'") ?>
                        </span>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-4">

                        <div class="pull-right">
                
                            <a class="nav-link" data-toggle="dropdown" href="#" style="color: white; text-align: center;">
                                <span id="resultado">
                                    <span id="fotoMiniatura"></span>
                                </span>  
                                <br>
                                <strong class="profileName">
                                    <span id="turno" ></span> <?php echo substr($this->session->desc_nome, 0, 60); ?>.
                                </strong>
                            </a>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <a class="dropdown-item">
                                    <div class="media" style=" font-size: 12px;">
                                        <div class="media-body">
                                            <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> Ultimo Acesso: <?= $this->session->dt_Ultacesso ?></p>
                                        </div>
                                    </div>
                                </a>
                                <!-- <a href="javascript:void(0);" onclick="rotaWorkShop()" class="dropdown-item">
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="text-sm">Cadastro 2º WorkShop Supra</p>
                                        </div>
                                    </div>
                                </a> -->
                                <a href="#" class="dropdown-item">
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="text-sm">Administrativo</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0);" onclick="rotaPerfil()" class="dropdown-item">
                                    <!-- Message Start -->
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="text-sm">Ver Perfil</p>
                                        </div>
                                    </div>
                                    <!-- Message End -->
                                </a>

                                <div class="dropdown-divider"></div>
                                <a href="<?php echo base_url("Login/logout") ?>" class="dropdown-item dropdown-footer">
                                    <i class="fa fa-fw fa-sign-out"></i> Sair
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="resultado">
                <div id="exibe" style="display:none;">
                    <?php
                } else {
                    if (isset($links_header)) {
                        foreach ($links_header as $item) {
                            ?>
                            <link rel="stylesheet" href="<?= $item ?>">

                            <?php
                        }
                    }

                    if (isset($scripts_header)) {
                        foreach ($scripts_header as $item) {
                            ?>
                            <script src="<?= $item ?>" type="text/javascript"></script>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if (isset($alerts)) {
                        foreach ($alerts as $key => $item) {
                            ?><script type="text/javascript">
                                    $(document).ready(function () {
                                        $.notify("<?= $item ?>", '<?= $key ?>');
                                    });
                            </script>
                            <?php
                        }
                    };
                }
                ?>
                <?= isset($menu_left) ? $menu_left : ""; ?>
<script src="<?php echo (base_url('assets/js/home/home.js')) ?>"></script>
<script src="<?php echo (base_url('assets/js/homeDaq/home.js')) ?>"></script>
<script src="<?php echo (base_url('assets/js/homeDif/geral/home.js')) ?>"></script>
