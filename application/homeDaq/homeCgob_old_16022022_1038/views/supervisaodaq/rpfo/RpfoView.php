<script src="<?php echo(base_url("application/homeDaq/homeCgob/assets/js/supervisaodaq/rpfo/rpfoView.js")) ?>" type="text/javascript"></script> 	
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>RPFO - Revisão de projetos em fase de obra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">RPFO</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h2>
                            <font size="3">
                            Devem ser inseridas informações de todas as RPFO aprovadas para o contrato de obras.
                            <div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                Caso esteja em trâmite solicitação de RPFO, deve ser realizada a gestão de todo o processo da RPFO, 
                                com todas as memórias de cálculo e fundamentação técnica que motivaram as modificações quantitativas e qualitativas, de cada proposta, 
                                conforme modelo adotado pelo DNIT, quando for o caso.
                            </div>
                            </font>
                        </h2>
                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div>
                                <div> 
                                    <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <div>
                                    <button type="button" name="btnNoAtividade" id="btnNoAtividade" class="btn btn-block btn-info" disabled="true">Não houve atividade no mês</button>
                                </div>
                            </div>
                        </div>                 
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_rpfo">
                        <div class="col-md-12 table-responsive">
                            <table id="tableRpfo" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>RPFO</th>
                                        <th>Local</th>
                                        <th>Status</th>
                                        <th>Previsão de Emissão de Parecer Conclusivo</th>
                                        <th>Observações</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row" id="cadastroRPFO">
                        <div class="col-md-12">
                            <form method="post" name="formRpfo" id="formRpfo" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Número</label>
                                           <!-- <select class="form-control" id="numero" name="numero"></select>-->
                                            <input type="text" class="form-control" name="numero" id="numero">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Previsão de Emissão de Parecer Conclusivo</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="parecerEmissao" name="parecerEmissao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Motivação</label>
                                            <textarea rows="8" type="text" id="motivacao" name="motivacao" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status detalhado</label>
                                            <textarea rows="8" type="text" id="statusDetalhado" name="statusDetalhado" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Analistas Responsáveis</label>
                                            <textarea rows="8" type="text" id="analistasResponsavel" name="analistasResponsavel" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-block btn-primary" name="insereRPFO" id="insereRPFO">Salvar</button>
                            <button type="button" class="btn btn-block btn-primary" name="alteraRPFO" id="alteraRPFO">Editar</button>
                            <input  type="hidden" id="id_rpfo" name="id_rpfo">
                        </div> 
                    </div>
                    <div class="row" id="cadastroRPFOHistorico">
                        <div class="col-md-12">
                            <form method="post" name="formRpfoHistorico" id="formRpfoHistorico">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Local</label>
                                            <select class="form-control" id="local" name="local"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Selecione.. </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input  type="hidden" id="id_rpfoHistorico" name="id_rpfoHistorico">
                            </form>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-block btn-primary" name="insereRPFOHistorico" id="insereRPFOHistorico">Salvar</button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-block btn-secondary" name="fecharRPFOHistorico" id="fecharRPFOHistorico">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="historico_rpfo">
                        <div class="col-md-12 table-responsive">
                            <table id="tableRpfoHistorico" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>RPFO</th>
                                        <th>Local</th>
                                        <th>Status</th>
                                        <th>Observações</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" id="cadastroRPFOAnexo">
                        <div class="col-md-12">
                            <form method="post" name="formRpfoAnexo" id="formRpfoAnexo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Arquivo</label><small> permitidos: Excel</small>
                                            <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=".xlsx">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <a href="<?php
                                                        $path_arq = base_url("index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQMODELO?arq='Modelo_RPFO.xlsx'");
                                                        $arquivo = "<a href=" . $path_arq . " target='_blank'>Modelo_RPFO.xlsx<a>";
                                                        echo base_url("index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQMODELO")
                                                        ?>?arq=Modelo_RPFO.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha</span></a>
                                                    </div>
                                                </div>                       
                                            </div>
                                            <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        </div>
                                    </div>
                                </div>
                                <input  type="hidden" id="id_rpfo_historico" name="id_rpfo_historico">
                            </form>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-block btn-primary" name="insereRPFOAnexo" id="insereRPFOAnexo">Salvar</button>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="anexos_rpfo">
                        <div class="col-md-12 table-responsive">
                            <table id="tableRpfoAnexo" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>RPFO</th>
                                        <th>Arquivo</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ação</th>
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
<!--Modal Status Detalhado-->
<div id="modalStatusDetalhado" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Observações</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Motivação</label>
                        <div class="table-responsive">
                            <p id="motivacao_modal_rpfo" style="text-align: justify"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Status Detalhado</label>
                        <div class="table-responsive">
                            <p id="status_detalhado_modal_rpfo" style="text-align: justify"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Analistas Responsáveis</label>
                        <div class="table-responsive">
                            <p id="analistas_responsavel_modal_rpfo" style="text-align: justify"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
