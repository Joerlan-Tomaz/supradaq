<script src="<?php echo (base_url("application/homeDaq/homeCgob/assets/js/supervisaodaq/tabelacontrato.js")) ?>"></script>
<div class="content-wrapper" style="min-height: 430px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Selecione o contrato</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item active">Painel de Contratos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <table id="table_contrato_supervisao" class="table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="table_contrato_supervisao_info">
                                <thead>
                                    <tr role="row">
                                        <td width="20%">Contrato</td>
                                        <td width="20%">Supervisora</td>
                                        <td width="9%">UF</td>                 
                                        <td width="10%">Status</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </section>

</div> 
