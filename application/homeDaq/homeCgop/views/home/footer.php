<?php
if (!isset($is_ajax) or $is_ajax === false) {
    ?>
    <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/jquery/jquery.min.js')) ?>"></script>
    <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/bootstrap/js/bootstrap.bundle.min.js')) ?>"></script>
    <script src="<?php echo (base_url('assets/AdminLTE_300/dist/js/adminlte.js')) ?>"></script>

    <!-- JS Notify -->
    <script src="<?php echo (base_url('assets/plugins/notify/notify.js')) ?>" type="text/javascript"></script>
    <!-- JS Bootbox-->
    <script src="<?php echo (base_url('assets/plugins/bootbox/bootbox.min.js')) ?>" type="text/javascript"></script>
    <!-- JS Datatable
    <script src="<?php echo (base_url('assets/plugins/datatables/jquery.dataTables.min.js'))      ?>" type="text/javascript"></script>
    <script src="<?php echo (base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'))      ?>" type="text/javascript"></script>-->
    <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/datatables/jquery.dataTables.js')) ?>"></script>
    <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/datatables/dataTables.bootstrap4.js')) ?>"></script>
    <script src="<?php echo (base_url('assets/plugins/datatables/datatable_select/dataTables.select.min.js')) ?>"></script>

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
    <!-- JS ScrollTo -->
    <script src="<?php echo (base_url('assets/plugins/scrollTo/jquery.scrollTo.min.js')) ?>"></script>
    <!-- Highcharts -->
    <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/highcharts.js')) ?>"></script>       
    <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/highcharts-more.js')) ?>"></script>
    <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/highcharts-3d.js')) ?>"></script>
    <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/modules/solid-gauge.js')) ?>"></script>
    <script src="<?php echo (base_url('assets/plugins/Highcharts-6.1.4/code/modules/stock.js')) ?>"></script>
    <!-- Jquery Validation -->
    <script src="<?php echo (base_url('assets/plugins/jquery-validation/dist/jquery.validate.min.js')) ?>"></script>
    <!-- html2canvas -->
    <script src="<?php echo (base_url('assets/plugins/html2canvas/html2canvas.js')) ?>"></script>
    <!-- Mapa Brasil -->
    <script src="<?php echo (base_url('assets/plugins/mapa-svg/mapa-svg.js')) ?>"></script>
    
    <script type="text/javascript">

        var base_url = '<?= base_url();?>';

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });

        $(function () {
            $('[data-toggle="popover"]').popover();
        })
    
    </script>
    <script src="<?php echo (base_url('assets/js/home/home.js')) ?>"></script>

    <!-- daterangepicker 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>-->
    <script src="<?php echo (base_url('assets/js/moment.min.js')) ?>"></script>

    <!-- Arquivo comum com funções JS -->
    <script src="<?php echo (base_url('assets/js/comum/comum.js')) ?>"></script>

    <!-- Calendario -->
    <script src="<?php echo (base_url('assets/AdminLTE_300/plugins/fullcalendar/fullcalendar.min.js')) ?>"></script>

    <?php
    if (isset($links_footer)) {
        foreach ($links_footer as $item) {
            ?>
            <link rel="stylesheet" href="<?= $item ?>">

            <?php
        }
    }

    if (isset($scripts_footer)) {
        foreach ($scripts_footer as $item) {
            ?>
            <script src="<?= $item ?>" type="text/javascript"></script>
            <?php
        }
    }
    ?>
    </body>

    </html>
    <?php
} else {
    if (isset($links_footer)) {
        foreach ($links_footer as $item) {
            ?>
            <link rel="stylesheet" href="<?= $item ?>">

            <?php
        }
    }

    if (isset($scripts_footer)) {
        foreach ($scripts_footer as $item) {
            ?>
            <script src="<?= $item ?>" type="text/javascript"></script>
            <?php
        }
    }
}
?>