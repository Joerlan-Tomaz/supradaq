<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/atascorrespondencias/atascorrespondenciasView.js')) ?>"
		type="text/javascript"></script>
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Atas e Correspondências</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);"
													   onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a>
						</li>
						<li class="breadcrumb-item active">Atas e Correspondências</li>
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
								Deverão ser incluídas nesta seção, separadamente, cópias das correspondências recebidas
								e enviadas ao longo do
								período a que corresponde o Relatório Mensal que, por sua importância, mereçam ser
								registradas.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
								<div class='mostrar'>
									Deverão ser incluídas ainda cópias das Atas de Reunião que ocorram entre partes
									interessadas no empreendimento
									(Convenente, empresa executora, supervisão de obras, fiscalização do Convênio pelo
									DNIT, sociedade civil, etc). <br>
									Deve ser apresentado um resumo das principais resoluções e providências pactuadas
									nas correspondências e atas de reunião.
								</div>
							</font>
						</h2>

						<div class="row">
							<div class="col-xs-12 col-md-1">
								<div>
									<button type="button" name="btnInclusao" id="btnInclusao"
											class="btn btn-block btn-primary">Incluir
									</button>
								</div>
								<div>
									<button type="button" name="searchdate" id="searchdate"
											class='btn btn-block btn-secondary'><i
												class="far fa-arrow-alt-circle-left"></i> Voltar
									</button>
								</div>
							</div>
							<div class="col-xs-12 col-md-2">
								<div>
									<button type="button" name="btnNoAtividade" id="btnNoAtividade"
											class="btn btn-block btn-info">Não houve atividade no mês
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="card-body">
					<div class="row" id="nova_atascorrespondencias">
						<div class="col-md-12 table-responsive">
							<table id="tableAtasCorrespondencias" class="table table-striped">
								<thead>
								<tr>
									<th>Tipo Documento</th>
									<th>Número Documento</th>
									<th>Assunto</th>
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

					<div id="cadastroAtasCorrespondencias">
						<form method="post" name="formularioAtasCorrespondencias" id="formularioAtasCorrespondencias">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label>Arquivo</label><small> permitidos: Word/PDF/Excel</small>
										<input class="form-control" type="file" id="fileUpload" name="fileUpload"
											   accept=".pdf,.docx,.xlsx">
										<small><i class="fas fa-info-circle" style='color:green'></i> tamanho max(5mb)
										</small>
									</div>

								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Tipo de Documento</label>
												<select class="form-control" name="tipo_documento" id="tipo_documento">
													<option value="">Selecione</option>
													<option>Correspondência Recebida</option>
													<option>Correspondência Enviada</option>
													<option>Atas</option>
													<option>Construtora</option>
													<option>Supervisora de Obra</option>
													<option>Supervisora/Gerenciadora Ambiental</option>
													<option>Gerenciadora</option>
													<option>DNIT</option>
													<option>Externo</option>
													<option>Ata de Reunião</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>Número do Documento</label>
												<input id="num_documento" name="num_documento" maxlength="10"
													   class="form-control" type="text">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>Assunto</label>
												<input id="assunto" name="assunto" class="form-control"
													   type="text">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>Data da Atividade</label>
												<div class="input-group date">
													<div class="input-group-prepend">
														<span class="input-group-text"><i
																	class="fa fa-calendar"></i></span>
													</div>
													<input id="data_ata" name="data_ata" type="text"
														   data-provide="datepicker" class="datepicker form-control"
														   required="true">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-8" style="border-left: 1px solid #f4f6f9;">
									<div class="form-group">
										<label>Descrição</label>
										<textarea id="status_detalhado" name="status_detalhado" rows="5"
												  style="min-width: 100%"></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-1">
								<button type="button" name="insereAtasCorrespondencias" id="insereAtasCorrespondencias"
										class="btn btn-block btn-primary">Salvar
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<iframe id="invisible" style="display:none;"></iframe>
	</section>
	<!-- /.content -->
</div>
