<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/avancofisico/avancofisicoView.js'))?>" type="text/javascript"></script>	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Avanço Físico</h1>
                </div>
                   <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
							<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                            <li class="breadcrumb-item active">Avanço Físico</li>
                        </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h2>
                            <font size="3"> 
                            O avanço físico das obras será inserido na ferramenta de acordo com o andamento mensal dos serviços na Operação.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                Todos os serviços que tiverem sido cadastrados no cronograma físico deverão ter suas informações de avanço inseridas na ferramenta 
                                à medida que estes forem executados. <br>
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
                                    <button type="button" name="btnNoAtividade" id="btnNoAtividade" class="btn btn-block btn-info">Não houve atividade no mês</button>
                                </div>
                            </div>
                          
                        </div>
                    </form>

                </div>

                <div class="card-body">

                
                    <div class="row" id="novo_avancofisico">
<!--                        <div class="col-md-12 table-responsive">-->
<!--                            <div class="card-header">-->
<!--                                <div class="col-sm-6">-->
<!--                                    <h3>Trechos Atacados</h3>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <table id="tableAvancoFisico" class="table table-striped" style="width: 100%">-->
<!--                                <thead>-->
<!--                                    <tr>-->
<!--                                       -->
<!--                                        <th>Eixo</th>-->
<!--                                        <th>Obra</th> -->
<!--                                        <th>Serviço</th>-->
<!--                                        <th>Tipo</th>-->
<!--                                        <th>Versão</th>-->
                                       <!-- <th>Unidade inicial Atacado</th> -->
<!--                                        <th>Unidade final Atacada</th> -->
<!--                                        <th>Atacado em</th>-->
<!--                                        <th>Última Execução em</th>-->
<!--                                        <th>Usuário</th>-->
<!--                                        <th>Atualização</th>-->
<!--                                        <th>Executar</th>-->
<!--                                        <th>Excluir Atacado</th>-->
<!--                                        <th>Visualizar Executado</th>-->
<!--                                        -->
<!--                                    </tr>-->
<!--                                </thead>-->
<!--                                <tbody></tbody>                              -->
<!--                            </table>       -->
<!--                        </div>-->
                        <!--<th>Anterior</th>-->
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Trechos Concluídos</h3>
                                </div>
                            </div>
                            <table id="tableAvancoFisicoConcluidos" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>

                                        <th>Infraestrutura</th>
                                        <th>Operação</th>
                                        <th>Serviço</th>
                                        <th>Tipo</th>
                                        <th>Versão</th>
                                        <th>Execução em</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Visualizar Executado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="col-md-12 table-responsive" id="contrato_anterior">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Trechos Concluídos No Contrato Anterior</h3>
                                </div>
                            </div>
                            <table id="tableAvancoFisicoContratoAnterior" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Infraestrutura</th>
                                        <th>Operação</th>
                                        <th>Serviço</th>
                                        <th>Tipo</th>
                                        <th>Versão</th>
                                        <th>Unidade final</th>
                                        <th>Atacado em</th>
                                        <th>Última Execução em</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row" id="cadastraAvancoFisicoObra">
                        <div class="col-md-12"><hr>
                            <form method="post" name="formularioAvancoFisicoObra" id="formularioAvancoFisicoObra">
                                <div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Nome da Infraestrutura</label>
											<select id="infraestrutura" name="infraestrutura" class="form-control" onchange="buscaOperacao(this.value);"></select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Operação</label>
											<select class="form-control" name="operacao" id="operacao" onchange="buscaServico(this.value);" disabled="true">
												<option value="" selected >Selecione</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Serviço</label>
											<select class="form-control" name="servico" id="servico" onchange="buscaTipo(this.value);" disabled="true">
												<option value="" selected >Selecione</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Tipo</label>
											<select class="form-control" name="tipo" id="tipo" disabled="true">
												<option value="" selected >Selecione</option>
											</select>
										</div>
									</div>
                                    <div class="col-md-4">  
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status" id="status" required disabled="true">
                                                <option value="" selected>Selecione</option>
                                                <option value="Atacado">Atacado</option>
                                                <option value="Executado pelo contrato anterior">Executado pelo contrato anterior</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">  
                                        <label>Campo</label>
                                        <button type="button" name="adicionaCamposKm" id="adicionaCamposKm" class="btn btn-block btn-info">Adicionar</button>
                                         <input type="hidden" id="qtdeCampos" name="qtdeCampos">
                                         <input type="hidden" id="medicao" name="medicao">
                                    </div>
                                </div>  
                                <!-- <hr> -->

                                <div id="campoPai"></div>

                                <div class="row" id="cadastraExecucao">
                                    <div class="col-md-12 table-responsive"><hr>
                                        <table id="tableAvancoexecutado" class="table table-striped" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Infraestrutura</th>
                                                    <th>Serviço</th>
                                                    <th>Status</th>
                                                    <th>Inicial</th>
                                                    <th>Final</th> 
                                                    <th>Extensão</th>   
                                                    <th>Adicionar Campos</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                           
                                            </tbody>                               
                                        </table>       
                                    </div>                  
                                </div>
                               
                            </form>
                        </div>
                        <div class="col-md-1" id="insereavancoatacado">
                            <button type="button" name="insereAvancoFisicoObra" id="insereAvancoFisicoObra" class="btn btn-block btn-primary" style="display: none">Salvar</button>
                            <button type="button" name="insereavancofisicoexecutadoanterior" id="insereavancofisicoexecutadoanterior" class="btn btn-block btn-primary" style="display: none">Salvar</button>
                            <input type="hidden" id="idAtacado" name="idAtacado">
                        </div>
                    </div>
                     <!-- Não houve atividade no mês -->
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
<!--------------------------------Modal Botao EXECUTAR -->
<div class="modal fade" id="modalExecutado" tabindex="-1" role="dialog" aria-labelledby="configuracao" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalExecutado"></h5>
                <h4 id="Mdomedida"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="tableExecutados" class="table dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Período</th>                                    
                                    <th>Status</th>
                                    <!-- <th>Unidade inicial Exc.</th> -->
                                    <th>Unidade Executada.</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>  
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <form method="post" name="formularioKMExecutado" id="formularioKMExecutado">
                            <input type="hidden" name="id_executado" id="id_executado"/>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" class="btn btn-block btn-primary" id="addExecutado" name="addExecutado">Adicionar Campo</button>
                                     <input type="hidden" id="qtdcamposexecutado" name="qtdcamposexecutado">
                                     <input type="hidden" id="qtdcamposexecutadodeletado" name="qtdcamposexecutadodeletado">
                                     <input type="hidden" id="medicaoexecutado" name="medicaoexecutado">
                                </div>
                            </div>
                            <div class="col-md-12" id="campoPaiExecutado"></div>
                        </form>
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-1">
                    <button type="button" name="insereavancofisicoexecutado" id="insereavancofisicoexecutado" class="btn btn-block btn-primary" style="display: none">Salvar</button>                   
                </div>
            </div>	
        </div>
    </div>
</div>
<!--------------------------------Modal Botao olho trecho atacados -->
<div class="modal fade" id="modalVisualizarExecutado" tabindex="-1" role="dialog" aria-labelledby="configuracao" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalVisualizarExecutado"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="tableVisualizarExecutados" class="table dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Período</th>                                    
                                    <th>Status</th>
                                    <!-- <th>Unidade inicial Exc.</th> -->
                                    <th>Unidade Executada.</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>  
                    </div>
                   
                </div>
            </div>
            
        </div>
    </div>
</div>
<!--------------------------------Modal Botao olho trecho concluido -->
<div class="modal fade" id="modalVisualizarExecutadoConcluido" tabindex="-1" role="dialog" aria-labelledby="configuracao" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModalVisualizarExecutadoConcluido"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="tableVisualizarExecutadosConcluido" class="table dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Período</th>                                    
                                    <th>Status</th>
                                    <!-- <th>Unidade inicial Concl.</th> -->
                                    <th>Unidade Concluida.</th>
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
</div>



<div class="modal fade" id="detalhesAvancoFisico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalhes Cronograma Físico da Obra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="tableDetalhesCronograma" class="table dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Versao</th>
                                    <th>Infraestrutura</th>
                                    <th>Serviço</th>                                   
                                    <th>Ano</th>
                                    <th>Mês</th>
                                    <th>Km inicial</th>
                                    <th>Km final</th>
                                    <th>Usuário</th>
                                    <th>Última Alteração</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>  
                    </div>
                </div>
                <div class="row" id="detalheSaldoAvanco">

                </div>
            </div>           
        </div>
    </div>
</div>

