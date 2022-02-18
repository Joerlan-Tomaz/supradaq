<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/licencasambientais/licencasambientaisView.js')) ?>" type="text/javascript"></script>	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Licenças</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Licenças</li>
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
                            Deverá ser apresentada a cópia de todas as licenças do empreendimento,
                            bem como das áreas de apoio, e outras que vierem a ser exigidas pelo órgão ambiental, assim como suas respectivas prorrogações. 
                            </font>
                        </h2>
                        <div class="row">
                             <div class="col-xs-12 col-md-1">
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div> 
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div>
                            </div>
                             <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="voltar" id="voltar" onclick="rotaGestaoAmbientalDaq()" class='btn btn-block btn-secondary' ><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
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
                    <div class="row" id="novo_licencaAmbiental">
                        <div class="col-md-12 table-responsive">
                            <table id="tableLicencasAmbientais" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nome da Infraestrutura</th>
                                        <th>Número Licença</th>
                                        <th>Tipo de Licença</th>
                                        <th>Vigência</th>
                                        <th>Solicitada Renovação?</th>
                                        <th>Resumo</th>
                                        <th>Arquivo</th>
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

                    <div id="cadastroLicencasAmbientais">
                        <form method="post" name="formularioLicencaAmbiental" id="formularioLicencaAmbiental">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Arquivos permitidos: PDF</label>
                                        <input class="form-control" type="file" id="fileUpload" name="arquivo" accept=".pdf">
                                    </div> 
                                </div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Nome da Infraestrutura</label>
										<select id="nome_infraestrutura" name="nome_infraestrutura" class="form-control"></select>
									</div>
								</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Número da Licença</label>
                                        <input id="licenca" name="licenca" maxlength='100' class="form-control" type="text">                                                               
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select id="tipo" name="tipo" class="form-control"></select>                                                             
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Órgão Emissor</label>
                                        <input id="orgaoEmissor" name="orgaoEmissor" maxlength='100' class="form-control" type="text">                                                               
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Data da Emissão</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="dataEmissao" name="dataEmissao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                        </div>                                                        
                                    </div> 
                                </div>  
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Início de Vigêngia</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="inicioVigencia" name="inicioVigencia" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Término de Vigêngia</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="terminoVigencia" name="terminoVigencia" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Solicitada Renovação</label>
                                        <select id="solicitacaoDataRenovacao" name="solicitacaoDataRenovacao" class="form-control">
                                            <option value="">Selecione</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>
                                        </select>                                                             
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Data da Solicitação</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="dataSolicitacaoRenovacao" name="dataSolicitacaoRenovacao" type="text" data-provide="datepicker" disabled class="datepicker form-control" required="true">                                                   
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <label>Resumo</label>
                                    <textarea id="status_detalhado" name="status_detalhado" rows="5" style="min-width: 100%"></textarea>                                                          
                                </div>  
                                <div class="col-md-6">    
                                    <label>Condicionantes Ambientais</label>
                                    <textarea id="condicionantes_ambientais" name="condicionantes_ambientais" rows="5" style="min-width: 100%"></textarea>                                                          
                                </div> 
                                <div class="col-md-1">
                                    <br>
                                    <button type="button" name="insereLicencaAmbiental" id="insereLicencaAmbiental" class="btn btn-block btn-primary">Salvar</button>
                                </div>
                            </div> 
                        </form>   
                    </div>
                    <!-- editar --> 
                    
                    <div id="editarLicencasAmbientais">
                        <form method="post" name="formularioLicencaAmbientalEditar" id="formularioLicencaAmbientalEditar">
                            <div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Nome da Infraestrutura</label>
										<select id="nome_infraestruturaEditar" name="nome_infraestruturaEditar" class="form-control"></select>
									</div>
								</div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Número da Licença</label>
                                        <input id="licenca_Editar" name="licenca_Editar" class="form-control" type="text">                                                               
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select id="tipo_Editar" name="tipo_Editar" class="form-control"></select>                                                             
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Orgão Emissor</label>
                                        <input id="orgaoEmissor_Editar" name="orgaoEmissor_Editar" class="form-control" type="text">                                                               
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Data da Emissão</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="dataEmissao_Editar" name="dataEmissao_Editar" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                        </div>                                                        
                                    </div> 
                                </div>  
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Início de Vigêngia</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="inicioVigencia_Editar" name="inicioVigencia_Editar" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Término de Vigêngia</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="terminoVigencia_Editar" name="terminoVigencia_Editar" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Solicitada Renovação</label>
                                        <select id="solicitacaoDataRenovacao_Editar" name="solicitacaoDataRenovacao_Editar" class="form-control">
                                            <option value="">Selecione</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>
                                        </select>                                                             
                                    </div> 
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Data da Solicitação</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="dataSolicitacaoRenovacao_Editar" name="dataSolicitacaoRenovacao_Editar" type="text" data-provide="datepicker" disabled class="datepicker form-control" required="true">                                                   
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <label>Resumo</label>
                                    <textarea id="status_detalhado_Editar" name="status_detalhado_Editar" rows="5" style="min-width: 100%"></textarea>                                                          
                                </div>  
                                <div class="col-md-6">    
                                    <label>Condicionantes Ambientais</label>
                                    <textarea id="condicionantes_ambientais_Editar" name="condicionantes_ambientais_Editar" rows="5" style="min-width: 100%"></textarea>                                                          
                                </div> 
                                <div class="col-md-1">
                                    <br>
                                    <button type="button" name="editarLicencaAmbiental" id="editarLicencaAmbiental" class="btn btn-block btn-primary">Editar</button>
                                    <input type="hidden" id="editar" name="editar">
                                </div>
                            </div> 
                        </form>   
                    </div>
                    
                    <!-- fim editar -->
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
</div>
