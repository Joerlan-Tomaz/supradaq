<script src="<?php echo(base_url('assets/js/homeDaq/administracao/atualizaSupPerfilPermissao/atualizaSupPerfilView.js')) ?>" type="text/javascript"></script>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Configurar Acesso do Perfil</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active">Configurar Acesso do Perfil</li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="card card-default">
				<div id="cadastroPerfil" style="display: none;">
					<form method="post" name="formularioPerfil" id="formularioPerfil">
						<div class="row">
							<div class="col-md-12">
								<form method="post" name="formularioPerfil" id="formularioPerfil">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label>Nome Perfil</label>
												<input id="desc_perfil" type="text" class="form-control" name="desc_perfil">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Coordenação</label>
												<input id="coordenacao" type="text" class="form-control" name="coordenacao">
											</div>
										</div>
									</div>
									<div id="campoTelas"></div>
								</form>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-1">
							<button type="button" name="inserePerfil" id="inserePerfil" class="btn btn-block btn-primary">Salvar</button>
						</div>
						<div class="col-md-1">
							<button type="button" name="cancelarPerfil" id="cancelarPerfil" class="btn btn-block btn-secondary" onclick="cancelarInserir()">Cancelar</button>
						</div>
					</div>
				</div>
				<div id="cadastroTela" style="display: none;">
					<form method="post" name="formularioTela" id="formularioTela">
						<div class="row">
							<div class="col-md-12">
								<form method="post" name="formularioTela" id="formularioTela">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Supervisão</label>
												<select class="form-control" name="supervisao" id="supervisao" required>
													<option value="">Selecione..</option>
													<option value="DAQ">DAQ</option>
													<option value="DIF">DIF</option>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Menu</label>
												<select class="form-control" name="menu" id="menu" required>
													<option value="">Selecione..</option>
													<option value="Administrativo">Administrativo</option>
													<option value="Análise de Relatório">Análise de Relatório</option>
													<option value="Documentação">Documentação</option>
													<option value="Painéis Gerenciais">Painéis Gerenciais</option>
													<option value="Relatório de Supervisão">Relatório de Supervisão</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Nome Tela</label>
												<input id="tela" type="text" class="form-control" name="tela">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-1">
							<button type="button" name="insereTela" id="insereTela" class="btn btn-block btn-primary">Salvar</button>
						</div>
						<div class="col-md-1">
							<button type="button" name="cancelarTela" id="cancelarTela" class="btn btn-block btn-secondary" onclick="cancelarInserir()">Cancelar</button>
						</div>
					</div>
				</div>
				<div class="card-header">
					<div class="row">
						<div class="col-xs-12 col-md-2">
							<div id="incluirPerfil">
								<button type="button" name="btnInclusaoPerfil" id="btnInclusaoPerfil" class="btn btn-block btn-primary">Novo Perfil</button>
							</div>
						</div>
						<div class="col-xs-12 col-md-2">
							<div id="incluirTela">
								<button type="button" name="btnInclusaoTela" id="btnInclusaoTela" class="btn btn-block btn-danger">Nova Tela</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card-body">
					<div class="row" id="divPerfil">
						<div class="col-md-12 table-responsive">
							<table id="tabelaPerfil" class="table table-striped col-md-12" style="width: 100%">
								<thead>
								<tr>
									<th>Perfil</th>
									<th>Coordernação</th>
									<th>Status</th>
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
	</section>
</div>

<!-- MODAL ATUALIZA PERFIL E PERMISSÕES -->
<div class="modal fade" id="modalAtualizaPerfilPermissoes" tabindex="-1" role="dialog" aria-labelledby="configuracao" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form method="post" name="formPerfilTelas" id="formPerfilTelas">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Alterar Permissão Perfil</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" name="formAtualizaPerfil" id="formAtualizaPerfil">
						<input type="hidden" id="id_perfil" name="id_perfil">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Perfil</label>
									<input id="nomePerfil" type="text" class="form-control" name="nomePerfil" disabled value="">
								</div>
							</div>
							<div class="col-md-12" id="vincularTelas">

							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="alteraPerfilTelas()">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>
