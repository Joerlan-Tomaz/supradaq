
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>SUPRA - CGPERT</title>

        <link rel="shortcut icon" href="<?php print base_url('assets') ?>/img/favicon-2.png" />
        <link rel="icon" href="<?php print base_url('assets') ?>/img/favicon-2.png" type="image/x-icon" />

        <meta name="description" content="SUPRA - CGPERT" />
        <meta name="keywords" content="supra, supervisão, avançada" />
        <meta name="author" content="DIR" />

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/font-awesome/css/font-awesome.min.css">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/AdminLTE_300/dist/css/adminlte.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/datatables/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/datatables/jquery.dataTables.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <!-- fancybox css -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/fancybox/dist/jquery.fancybox.min.css">

        <link rel="stylesheet" href="<?php print base_url('assets') ?>/css/ionicons/ionicons.min.css">

        <link rel="stylesheet" href="<?php print base_url('assets') ?>/plugins/ionsliderNew/css/ion.rangeSlider.css">
        <link rel="stylesheet" href="<?php print base_url('assets') ?>/plugins/ionsliderNew/css/ion.rangeSlider.skinHTML5.css">

        <!-- fontawesome https://fontawesome.com/icons?d=gallery -->
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/all.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/brands.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/fontawesome.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/regular.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/solid.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/svg-with-js.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.css">
        <link data-prerender="keep" rel="stylesheet" href="<?php print base_url('assets') ?>/fontawesome/css/v4-shims.min.css">

        <!-- jQuery -->
        <script src="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url('assets'); ?>/fancybox/dist/jquery.fancybox.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url('assets'); ?>/AdminLTE_300/dist/js/adminlte.min.js"></script>
        <!-- HighCharts -->
        <script src="<?php echo base_url('assets'); ?>/HighCharts/code/highcharts.js"></script>
        <script src="<?php echo base_url('assets'); ?>/HighCharts/code/highcharts-more.js"></script>
        <script src="<?php echo base_url('assets'); ?>/HighCharts/code/highcharts-3d.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/datatables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url('assets'); ?>/AdminLTE_300/plugins/datatables/dataTables.bootstrap4.js"></script>
        
        <!-- notify -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/plugins/notify/notify.css">
        <script src="<?php echo base_url('assets'); ?>/plugins/notify/notify.js"></script>

        <script>
            var base_url = '<?php echo base_url() ?>';
            var site_url = '<?php echo site_url() ?>';
            var base_url_cgpert = '<?php echo $this->config->item("base_url_cgpert")?>';
        </script>

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
            .dataTables_paginate .pagination .paginate_button {
                /* ul or ol with this class */
                display: inline-block;
                padding: 0;
                padding-left: 1px;
                margin: 0;
                float: left;
                font-size: 14px;
            }
        </style>
    </head>

    <body  class="hold-transition sidebar-mini sidebar-collapse">


        <!-- REQUIRED SCRIPTS -->

        <div  class="wrapper">

            <!-- Navbar -->
            <!--<nav class="main-header navbar navbar-expand navbar-light border-bottom bg-info" style="background-color: rgb(20,151,221) !important">-->
            <nav class="main-header navbar navbar-expand navbar-light border-bottom bg-dark">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url() ?>index.php/homeCgpert/Home/index" class="nav-link">Home</a>
                    </li>

                </ul>


            </nav>
            <!-- /.navbar -->
            <?= $contents ?> <!-- view content -->

        </div>
        <!-- ./wrapper -->

    </body>
</html>
