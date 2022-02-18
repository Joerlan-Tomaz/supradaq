<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/administracao/solicitaoacesso/solicitacaoacessoView.js')) ?>" type="text/javascript"></script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Relacionar Grupo de Contrato</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
                        <li class="breadcrumb-item active">Relacionar Grupo de Contrato</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary btn-sm" onclick="insereNovoGrupoContrato()">Novo Grupo de Contratos</button>
                            </div>
                        </div>                  
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="tblGrupoContrato" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 50%">Grupo de Contrato</th>
                                            <th style="width: 10%">Grupo</th>
                                            <th style="width: 5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>                               
                                </table>  
                            </div>                  
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</div>
