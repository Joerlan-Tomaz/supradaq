
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/avancofinanceiroobra/avancofinanceiroobraView.js'))?>" type="text/javascript"></script>
<div oncontextmenu="return false">   
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Avanço Financeiro da Operação</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Avanço Financeiro da Operação</li>
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
                            A supervisora deverá inserir um avanço financeiro mensal para cada um dos itens cadastrados no cronograma financeiro da Operação.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class="mostrar">
                                Como o cronograma financeiro foi cadastrado de forma a dar uma visão gerencial da Operação, <br>
                                podendo alguns serviços terem sido agrupados ou desmembrados da planilha contratual, o avanço financeiro deverá seguir a mesma lógica. <br>
                                A soma dos valores de cada um dos serviços inseridos deverá ser igual ao valor medido no mês, sem reajustes.
                            </div>
                            </font>
                        </h2>
                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div> 
                                <div>
                                    <button type="button" name="btnNoAtividade" id="btnNoAtividade" class="btn btn-block btn-info">Não houve atividade no mês</button>
                                </div>
                            </div>                         
                        </div>            
                    </form>
                </div>

                <div class="card-body">    
                   <!-- medição -->
                    <div class="row" id="visualizar_medicao">
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Não Publicados</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_medicao_naopublicado" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nº Medição</th>                                        
                                        <th>Mês Ref.Medição</th>
                                        <th>Valor Medição</th>
                                        <th>Data Processamento</th>
                                        <th>Valor Lançado</th>
                                        <th>Publicado</th>
                                        <th>Detalhar</th>
                                        <th>Incluir</th> 
                                        <th>Publicar</th> 
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div> 
                        
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Publicados</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_medicao_publicado" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nº Medição</th>
										<th>Infraestrutura</th>
										<th>Mês Ref.Medição</th>
                                        <th>Valor Medição</th>
                                        <th>Data Processamento</th>
                                        <th>Valor Lançado</th>
                                        <th>Publicado</th>
                                        <th>Detalhar</th>
                                        <th>Incluir</th> 
                                        <th>Publicar</th> 
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>
                  
                    <!-- lançar avanço -->
                   <!-- avanço -->
                    <div class="row" id="table_detalhar">
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Agrupado</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_detalhar" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th> 
                                        <th>Nº Medição</th>                                        
                                        <th>Mês Ref.Medição</th>
                                        <th>Valor Medição</th>
                                        <th>Data Processamento</th>
                                        <th>Valor Lançado</th>                                                                                
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>
                    <!-- lançar avanço -->
                    
                    <div class="row" id="cadastrarAvanco">
                        <div class="col-md-12"><hr>
                            <form method="post" name="formularioAvanco" id="formularioAvanco">
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
                                    <div class="col-md-3">  
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <div class='input-group-prepend'><span class='input-group-text'>R$</span>
                                           <input class='form-control' type='text' id='valor' name='valor' maxlength='20' onkeydown='FormataMoeda(this, 15, event)' onkeypress='return maskKeyPress(event)'> </div>                                    
                                        </div> 
                                    </div> 
                                     
                                </div>
                                <div class="col-md-1">  
                                        <div class="form-group">
                                            <label></label>
                                            <button type="button" name="btninsereAvanco" id="btninsereAvanco" class="btn btn-block btn-primary">Salvar</button>   
                                            <input type="hidden" id="numemedicao" name="numemedicao">                                           
                                        </div> 
                                    </div> 
                            </form>
                        </div>
                    </div>
                     <!-- detalhar avanço -->
                    <div class="row" id="table_detalhar_avanco">
                        <div class="col-md-12 table-responsive">
                             <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Detalhado</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_avanco" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th> 
                                        <th>Operação</th>
                                        <th>Serviço</th>
										<th>Tipo</th>
										<th>Valor</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>                                                                                
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>
                    
                    
                    
                    
                    <!-- fim lançar avanço -->
                    <!-- fim cronogramsa agrupados -->
                    <div class="row" id="visualizar_cronograma_avanco_detalhado">
                        <div class="col-md-12 table-responsive">
                            <table id="table_visualizar_cronograma_avanco_detalhado" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th> 
                                        <th>Servico</th> 
                                        <th>Planejado</th>
                                        <th>Executado</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>                                        
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>
                     <div class="row" id="visualizar_cronograma_avanco_incluir">
                        <div class="card-body"> 
                            
                            <div class="col-md-12 table-responsive">
                                <form id="frmAvanco">
                                    <table id="table_visualizar_cronograma_avanco_incluir" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th> 
                                                <th>Servico</th> 
                                                <th>Planejado</th>
                                                <th>Executado</th>
                                                <th>Usuário</th>
                                                <th>Atualização</th>                                        
                                            </tr>
                                        </thead>
                                        <tbody></tbody>                               
                                    </table>
                                    
                                </form>
                               
                                <div class="col-md-1">
                                 <button type="button" name="btnAvanco" id="btnAvanco" class="btn btn-block btn-primary">Salvar</button>
                                 <input type='hidden' name='edtCronograma' id='edtCronograma'>
                                 <input type='hidden' name='edtVersao' id='edtVersao'>
                                </div>
                            
                            </div>
                            
                        </div>  
                         
                    </div>
                    
                      <div class="row" id="naohouveatividademes">
                        <div class="col-md-12">
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

<!--modal editar cronograma--> 
<div class="modal fade" id="editarcronograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
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
