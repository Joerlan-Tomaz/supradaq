<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/cronogramafinanceiroobra/cronogramafinanceiroobraView.js'))?>" type="text/javascript"></script>

   
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/cronograma/cronograma.js'))?>"></script>


<div oncontextmenu="return false">   
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cronograma Financeiro da Operação</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                       <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Cronograma Financeiro de Obra</li>
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
								O Cronograma financeiro deverá ser inserido no SUPRA com seus valores previstos por disciplina de serviços, sem reajustes.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                As disciplinas estabelecidas foram determinadas de forma a prover uma visão gerencial do planejamento e controle das operações,
                                facilitando a apuração dos avanços, desvios e previsões de término. <br>
                                A padronização dos itens será de suma importância para posteriores comparativos entre os diversos contratos do DNIT. <br>
                                Tais disciplinas podem estar diferentes em alguns pontos da planilha contratual. Quando isto ocorrer devem ser feitas adaptações necessárias, 
                                agrupando ou desmembrando itens da planilha contratual de forma que este se adeque as disciplinas de serviço estabelecidas. <br>
                                Para tanto, o SUPRA disponibilizará orientações básicas para tais adaptações, além da descrição de cada disciplina de serviços.<br>
                            </div>
                            </font>
                        </h2>
                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary" title="Publique todos cronogramas para criar uma novo!">Novo</button>
                                </div>
                                <div> 
                                  <button type="button" name="btnPesquisar" id="btnPesquisar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
                            <div class="col-xs-12 col-md-1">
                                <!--<div>
                                    <button type="button" name="btnPublicar" id="btnPublicar" class="btn btn-block btn-primary">Publicar Cronograma</button>
                                </div>-->
                                 <div> 
                                  <button type="button" name="btnVoltar" id="btnVoltar" onclick="rotaCronogramaDaq()" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button> 
                                 </div>
                            </div>
                        </div>   
                    </form>
                </div>

                <div class="card-body">    
                    <div class="row invoice-info" id="exibeCronogramaFinanceiroObra">                                        
                        <div class="col-md-4 border-right">
                            <div class="description-block">
                                <b class="description-header" style="font-size: 20px;"><span class="label_pi" style="font-size: 20px;"></span></b><br>
                                <span class="description-text">Valor Total (PI Vigente)</span>
                            </div>
                        </div>
                        <div class="col-md-4 border-right">
                            <div class="description-block">
                                <b class="description-header" style="font-size: 20px;"><span class="label_saldo_lancar" style="font-size: 20px;"> </b><br>
                                <span class="description-text">Saldo a lançar</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="description-block">
                                <b class="description-header" style="font-size: 20px;"><span class="label_saldo" style="font-size: 20px;"></span></b><br>
                                <span class="description-text">Total Previsto</span>
                            </div>
                        </div>
                    </div> 
                    <!-- cronogramas agrupados -->
                    <div class="row" id="visualizar_cronogramaagrupado">
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Não Publicados</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_cronogramaagrupado_naopublicado" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Total (PI+A)</th>
                                        <th>Total Acumulado Planejado</th>
                                        <th>Versão</th>                                        
                                        <th>Usuário</th>
                                        <th>Data Cronograma</th>
                                        <th>Publicado</th>
                                        <th>Data Publicação</th>
                                        <th>Usuario Publicação</th>
                                        <th>Detalhado</th>
                                        <th>Inserir</th>
                                        <th>Publicar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-12">
                                    <h3>Publicados</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_cronogramaagrupado_publicado" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Total (PI+A)</th>
                                        <th>Total Acumulado Planejado</th>
                                        <th>Versão</th>                                        
                                        <th>Usuário</th>
                                        <th>Data Cronograma</th>
                                        <th>Publicado</th>
                                        <th>Data Publicação</th>
                                        <th>Usuario Publicação</th>
                                        <th>Detalhado</th>
                                        <th>Inserir</th>
                                        <th>Publicar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>        
                    </div>
                    <!-- fim cronogramsa agrupados -->
                   

                    <div class="row" id="cadastraCronogramaFinanceiroObra">
                        <div class="col-md-12"><hr>
                            <form method="post" name="formularioCronogramaFinanceiroObra" id="formularioCronogramaFinanceiroObra">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>Ano</label>
                                            <input id="anoreferente" type="text" class="form-control" name="anoreferente">                                                        
                                        </div> 
                                    </div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Nome da Infraestrutura</label>
											<select id="infraestrutura" name="infraestrutura" class="form-control"></select>
										</div>
									</div>
                                    <div class="col-md-3">  
                                        <div class="form-group">
                                            <label>Operação</label>
                                            <select class="form-control" name="operacao" id="operacao" required> </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">  
                                        <div class="form-group">
                                            <label>Serviço</label>
                                            <select class="form-control" name="servico" id="servico" required> </select> 
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <select class="form-control" name="tipo" id="tipo" required> </select> 
                                        </div> 
                                    </div>
                                    <div class="col-md-3">  
                                        <label>&nbsp;</label>
                                        <button type="button" name="adicionaCamposValor" id="adicionaCamposValor" class="btn btn-block btn-info">Adicionar Campos</button>                                    
                                    </div>
                                </div>  
                                <hr>
                                <div id="campoPai"></div>
                            </form>
                        </div>
                        <div class="col-md-1" style="margin-top: 15px;">  
                            <button type="button" name="insereCronogramaFinanceiroObra" id="insereCronogramaFinanceiroObra" class="btn btn-block btn-primary" style="display: none">Salvar</button>
                            <input type="hidden" id="id_cronograma" name="id_cronograma">
                            <input type="hidden" id="versao" name="versao" >
                        </div> 
                    </div>
                    
                     <div class="row" id="visualizar_cronogramafinanceiroobra">
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Detalhado</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_cronogramafinanceiroobra" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Infraestrutura</th>
                                        <th>Operação</th>
                                        <th>Serviço</th>
                                        <th>Tipo</th>
                                        <th>Ano</th>
                                        <th>Mês</th>
                                        <th>Total Acumulado já Planejado</th>
                                        <th>Usuário</th>                                        
                                        <th>Versão do Cronograma</th>
                                        <th>Atualização</th>
                                        <th>Publicar</th>
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

<!--modal editar cronograma--> 
<div class="modal fade" id="editarcronograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <form id="editar_cronograma">
                             <table id="table_editar_cronogramafinanceiroobra" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Total Acumulado já Planejado</th>
                                        <th>Usuário</th>                                        
                                        <th>Versão do Cronograma</th>
                                        <th>Atualização</th>
                                        <th>Publicar</th>                                        
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                         </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="btn_salvaredicao" id="btn_salvaredicao" class="btn btn-primary btn-sm" data-dismiss="modal">Salvar</button>
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Fechar</button>
                <input type="hidden" id="editarId" name="editarId">
            </div>
        </div>
    </div>
</div>

</div>
