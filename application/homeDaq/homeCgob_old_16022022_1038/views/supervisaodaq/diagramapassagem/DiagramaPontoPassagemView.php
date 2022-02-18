<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/diagramapontopassagem/diagramapontopassagemView.js'))?>" type="text/javascript"></script>	
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Diagrama de Pontos de Passagem e de Ocorrências de Projeto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Diagrama de Pontos de Passagem e de Ocorrências de Projeto</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h2>
                        <font size="3">Diagrama Unifilar de Ocorrências e Pontos de Passagem, em arquivo único, exibindo tais informações em folha única A4.
                        </font>
                    </h2>
                    <div class="row">
                        <div class="col-xs-12 col-md-1">
                            <button type="button" name="btnVoltar" id="btnVoltar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                        </div>
                    </div>                  
                </div>
                <div class="card-body">
                    <form method="post" name="formularioDiagramaPontoPassagem" id="formularioDiagramaPontoPassagem">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Arquivo</label> <small>(.png,.jpg,.jpeg)</small><br>
                                    <input class="form-control" id="fileUploadDiagramaPontoPassagem" name="fileUploadDiagramaPontoPassagem" type="file" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tableDiagramaPontoPassagem" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Arquivo</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
</div>
