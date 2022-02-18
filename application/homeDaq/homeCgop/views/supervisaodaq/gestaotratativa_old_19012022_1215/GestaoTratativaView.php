<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/gestaotratativas/gestaotratativasView.js')) ?>" type="text/javascript"></script>  	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestão de Tratativas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Gestão de Tratativas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h2>
                            <font size="3">
                            O relatório de Supervisão deve apresentar todas as tratativas relevantes em andamento no período.
                            Todas as ações relevantes determinadas em diário de operações, atas de reunião, documentos oficiais e
                            e-mails oficiais devem ser registradas e atualizadas mensalmente.
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
                    <div class="row" id="novo_gestaotratativa">
<!--                         <div class="col-md-2">
                            <select class="form-control" id="filtroStatus">
                                <option value="periodoReferencia">Por período de referência</option>
                                <option value="Aberto">Aberta</option>
                                <option value="Fechado">Fechada</option>
                            </select>
                        </div> -->
                        <div class="col-md-12 table-responsive">
                            <table id="tableGestaoTratativa" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Período de Referência</th>
                                        <th>Status</th> 
                                        <th>Assunto</th>
                                        <th>Origem</th>
                                        <th>Responsável</th>
                                        <th>Data de Solicitação</th>
                                        <th>Data de Término</th>
                                        <th>Descrição</th>
                                        <th>Providência</th> 
                                        <th>Usuário</th> 
                                        <th>Atualização</th> 
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>                               
                            </table>     
                        </div>                  
                    </div>

                    <div id="cadastro_gestaotratativa">
                        <form method="post" name="formGestaoTratativa" id="formGestaoTratativa">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Origem</label>
                                                <select id="origem" name="origem" class="form-control"></select>                                                             
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Data de Solicitação</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="dataSolicitacao" name="dataSolicitacao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                                        
                                            </div> 
                                        </div> 
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Assunto</label>
                                                <input id="assunto" name="assunto" class="form-control" type="text">                                                               
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Responsável</label>
                                                <select id="responsavel" name="responsavel" class="form-control"></select>                                                             
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Data Pactuada</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="dataPactuada" name="dataPactuada" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                           
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Nova Data Pactuada</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="novaDataPactuada" name="novaDataPactuada" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                           
                                            </div>
                                        </div>
                                        <div class="col-md-12"> 
                                            <div class="form-group">
                                                <label>Data de Término</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="dataTermino" name="dataTermino" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8" style="border-left: 1px solid #f4f6f9;">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <textarea id="status" name="status" rows="5" style="min-width: 100%"></textarea>     
                                    </div> 
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    <button type="button" name="insereGestaoTratativa" id="insereGestaoTratativa" class="btn btn-block btn-primary">Salvar</button>
                                </div>
                            </div> 
                        </form>   
                    </div>
                    <!-- Editar -->


                    <div id="cadastro_gestaotratativa_edita">
                        <form method="post" name="formGestaoTratativa_edita" id="formGestaoTratativa_edita">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Origem</label>
                                                <select id="origem_edita" name="origem_edita" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Ata de Reunião</option>
                                                    <option value="2">Diário de Operações</option>
                                                    <option value="3">Documento</option>
                                                    <option value="4">Construtora</option>
                                                    <option value="5">Documento DNIT</option>
                                                    <option value="6">Documento Externo</option>
                                                    <option value="7">Documento Supervisora</option>
                                                </select>                                                             
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Data de Solicitação</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="dataSolicitacao_edita" name="dataSolicitacao_edita" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                                        
                                            </div> 
                                        </div> 
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Assunto</label>
                                                <input id="assunto_edita" name="assunto_edita" class="form-control" type="text">                                                               
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Responsável</label>
                                                <select id="responsavel_edita" name="responsavel_edita" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Supervisora</option>
                                                    <option value="2">Construtora</option>
                                                    <option value="3">Projetista</option>
                                                    <option value="4">Construtora</option>
                                                    <option value="5">DNIT</option>
                                                    <option value="6">Outro</option>
                                                </select>                                                             
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Data Pactuada</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="dataPactuada_edita" name="dataPactuada_edita" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                           
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Nova Data Pactuada</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="novaDataPactuada_edita" name="novaDataPactuada_edita" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                           
                                            </div>
                                        </div>
                                        <div class="col-md-12"> 
                                            <div class="form-group">
                                                <label>Data de Término</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="dataTermino_edita" name="dataTermino_edita" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                                </div>                                           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8" style="border-left: 1px solid #f4f6f9;">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <textarea id="status_edita" name="status_edita" rows="5" style="min-width: 100%"></textarea>     
                                    </div> 
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    <button type="button" name="editarGestaoTratativa" id="editarGestaoTratativa" class="btn btn-block btn-primary">Salvar</button>
                                    <input type="hidden" id="editar" name="editar">
                                </div>
                            </div> 
                        </form>   
                    </div>



                    <!-- Editar -->
                    <div class="row" id="naohouveatividademes">
                        <div class="col-md-12 table-responsive">
                            <table id="tableNaohouveAtividadeMes" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Atividade</th>
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
    </section>
</div>
<!--Modal Status-->
<div id="modalStatus" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Descrição</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <!--<label>Status</label>-->
                    <div class="table-responsive">
                        <p id="status_modal" style="text-align: justify"></p>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal Situação-->
<div id="modalSituacao" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style=" width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Providência</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioProvidencia" id="formularioProvidencia">
                    <input type="hidden" id="id_gestao_tratativa" name="id_gestao_tratativa">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="situacao_gestao_tratativa" name="situacao_gestao_tratativa" >
                                <option value="">Selecione</option>
                                <option value="Aberto">Aberto</option>
                                <option value="Fechado">Fechado</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">  
                                <label>Providência</label>
                                <textarea id="providencia" name="providencia" rows="5" style="min-width: 100%"></textarea>                                                          
                            </div>  
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-primary" id="insereProvidencia" name="insereProvidencia">Salvar</button>
                        </div>
                        <div class="col-md-1">
                        </div> 
                        <div class="col-md-12 table-responsive">
                            <div class="form-group">
                                <table id="tableProvidenciaGestaotratativa" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Providência</th>
                                            <th>Usuário</th> 
                                            <th>Atualização</th> 
                                            <th>Ação</th>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>                               
                                </table>     
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
