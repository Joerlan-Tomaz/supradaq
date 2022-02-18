<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/pbapbai/pbapbaiView.js')) ?>" type="text/javascript"></script>
	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Planos Ambientais e Outros</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"> <?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Planos Ambientais e Outros</li>
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
                            Deverá ser apresentada a cópia dos planos no formato pdf, além de breve resumo descritivo contendo a data de elaboração do mesmo,
                            empresa/contrato elaborador e valor de implementação.
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
                             <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="voltar" id="voltar" onclick="rotaGestaoAmbientalDaq()" class='btn btn-block btn-secondary' ><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
                                </div>
                            </div>
                           
                        </div>                 
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_pbapbai">
                        <div class="col-md-12 table-responsive">
                            <table id="tablePbaPbai" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
										<th>Nome da Infraestrutura</th>
										<th>Resumo</th>
										<th>Tipo</th>
										<th>Status</th>
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
                    <form method="post" name="formularioPbaPbai" id="formularioPbaPbai">
                        <div id="cadastroPbaPbai">
                            <div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Nome da Infraestrutura</label>
										<select id="nome_infraestrutura" name="nome_infraestrutura" class="form-control"></select>
									</div>
								</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select id="tipo" name="tipo" class="form-control">
											<option value="Selecione">Selecione</option>
											<option value="PAE – Plano de Ação de Emergência">PAE – Plano de Ação de Emergência</option>
											<option value="PEI – Plano de Emergência Individual">PEI – Plano de Emergência Individual</option>
											<option value="PSB – Plano de Segurança de Barragem">PSB – Plano de Segurança de Barragem</option>
											<option value="PBA – Plano Básico Ambiental">PBA – Plano Básico Ambiental</option>
											<option value="PBAI - Projeto Básico Ambiental Indígena">PBAI - Projeto Básico Ambiental Indígena</option>
										</select>
                                    </div> 
                                </div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Status</label>
										<select id="status" name="status" class="form-control">
											<option value="Selecione" selected>Selecione</option>
											<option value="1">Finalizado</option>
											<option value="2">Em Elaboração</option>
											<option value="2">Pendente</option>
										</select>
									</div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Arquivo</label><small> arquivos permitidos: (.pdf,.docx)</small>
                                        <input type="file" id="fileUpload" name="fileUpload" class="form-control" accept=".pdf,.docx"> 
                                        <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>                                         
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea rows="8" type="text" id="descricao" name="descricao" class="form-control"></textarea>
                                    </div> 
                                </div>
                            </div>  
                            <div class="row">   
                                <div class="col-md-1">  
                                    <label>&nbsp;</label>
                                    <button type="button" name="inserePbaPbai" id="inserePbaPbai" class="btn btn-block btn-primary">Salvar</button>
                                    <button type="button" name="editarPbaPbai" id="editarPbaPbai" class="btn btn-block btn-primary">Editar</button>
                                    <input type="hidden" name="hdn_pbapbai" id="hdn_pbapbai">
                                    <input type="hidden" name="hdn_pbapbaiarquivo" id="hdn_pbapbaiarquivo">
                                </div>   
                            </div> 
                        </div>   
                    </form>                        
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
</div>
