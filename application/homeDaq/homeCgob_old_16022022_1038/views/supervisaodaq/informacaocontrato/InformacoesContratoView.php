<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgob/assets/css/homeCgcont/ambientegestao/ambientegestao.css'))?>" />
<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/info/infoView.js'))?>" type="text/javascript"></script>  
<div class="content-wrapper" style="min-height: 430px;">
    <!-- Content Header (Page header) -->
    <div class="content-header" style="padding: 25px 0.5rem;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-8">
                    <h3 class="m-0 text-dark"><b><?php echo $this->session->numero_contrato ?></b> <?php echo $this->session->nome_empresa ?></h3>
                </div><!-- /.col -->
                <div class="col-md-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item active">Início</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
            <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <!------------------------------------------ VALOR TOTAL ----------------------------------------------------->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-dollar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Valor Total (PI + A + R)</span>
                                <span class="info-box-number">R$<?php 
                                    $dados["valor_total"] = $this->session->valor_total;
                                    $valor_total = $dados["valor_total"];
                                    echo number_format($valor_total, 2, ',', '.');
                                ?></span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                                <span class="progress-description">
                                    <?php 
                                        $dados["valor_total_aditivo"] = $this->session->valor_total_aditivo;
                                        $valor_total_aditivo = $dados["valor_total_aditivo"];
                                        echo number_format($valor_total_aditivo, 2, ',', '.')."(A) "; 
                                       
                                        $dados["valor_inicial"] = $this->session->valor_inicial;
                                        $valor_inicial = $dados["valor_inicial"];

                                        echo number_format($valor_total_aditivo / $valor_inicial * 100, 2, ',', '.')."% (A/PI)" ; 
                                    ?>  
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!------------------------------------------TOTAL MEDIDO----------------------------------------------------->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fa fa-database"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Medido (PI + A + R)</span>
                                 <span class="info-box-number">R$ <?php 
                                    $dados["total_medido"] = $this->session->total_medido;
                                    $total_medido = $dados["total_medido"];
                                    echo number_format($total_medido, 2, ',', '.');
                                ?></span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 
                                    <?php 
                                        $dados["valor_total"] = $this->session->valor_total;
                                        $valor_total = $dados["valor_total"];
                                        $dados["total_medido"] = $this->session->total_medido;
                                        $total_medido =  $dados["total_medido"];

                                        $por = number_format($total_medido / $valor_total * 100, 2)."%";
                                        echo  $por; 
                                    ?>"></div>
                                </div>
                                <span class="progress-description">
                                    <?php 
                                        $dados["valor_total"] = $this->session->valor_total;
                                        $valor_total = $dados["valor_total"];
                                        $dados["total_medido"] = $this->session->total_medido;
                                        $total_medido =  $dados["total_medido"];

                                        echo number_format($total_medido / $valor_total * 100, 2, ',', '.')."%" ; 
                                    ?>  Medido
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-------------------------------------------TOTAL EMPENHADO------------------------------------------------->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Empenhado</span>
                                <span class="info-box-number">R$ <?php 
                                    $dados["total_empenhado"] = $this->session->total_empenhado;
                                    $total_empenhado = $dados["total_empenhado"];
                                    echo number_format($total_empenhado, 2, ',', '.');
                                ?></span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 
                                    <?php 
                                        $dados["valor_total"] = $this->session->valor_total;
                                        $valor_total = $dados["valor_total"];
                                        $dados["total_empenhado"] = $this->session->total_empenhado;
                                        $total_empenhado =  $dados["total_empenhado"];

                                        $por = number_format($total_empenhado / $valor_total * 100, 2)."%";
                                        echo  $por; 

                                    ?>"></div>
                                </div>
                                <span class="progress-description">
                                    <?php 
                                        $dados["valor_total"] = $this->session->valor_total;
                                        $valor_total = $dados["valor_total"];
                                        $dados["total_empenhado"] = $this->session->total_empenhado;
                                        $total_empenhado =  $dados["total_empenhado"];

                                        echo number_format($total_empenhado / $valor_total * 100, 2, ',', '.')."%" ; 
                                    ?>  Empenhado
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-------------------------- ----------------STATUS CONTRATO-------------------------------------------------->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Vigência&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dias a Vencer</span>
                                <span class="info-box-number"> <?php echo $this->session->vigencia ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->session->diasvencer ?></span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    <?php echo $this->session->situacao ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
<!--                <div class="row" id="campo"></div>  -->
            </div>
        </section>
    </div>
     
                                
    

