<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/atividadesexecutora/atividadesExecutoraView.js')) ?>"
		type="text/javascript"></script>
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Atividades da Executora - Assessoramento Especializado</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);"
													   onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a>
						</li>
						<li class="breadcrumb-item active">Atividades da Executora - Assessoramento Especializado</li>
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
								A empresa supervisora deverá anexar planilha com as atividades desempenhadas pela
								executora no âmbito de Assessoramento Especializado.
								<!--								<div class='ocultar'><u>[+/-] Leia mais...</u></div>-->
								<div class='mostrar'>
								</div>
							</font>
						</h2>

						<div class="row">
							<div class="col-xs-12 col-md-1">
								<div>
									<button type="button" name="btnInclusao" id="btnInclusao"
											class="btn btn-block btn-primary" disabled="true">Incluir
									</button>
								</div>
								<div>
									<button type="button" name="searchdate" id="searchdate"
											class='btn btn-block btn-secondary'><i
												class="far fa-arrow-alt-circle-left"></i> Voltar
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="card-body">

					<div class="row" id="novo_AtividadesExecutora">
						<div class="col-md-12">
							<table id="tableAtividadesExecutora" class="table table-striped">
								<thead>
								<tr>
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
					<div id="cadastroAtividadesExecutora">
						<form method="post" name="formularioAtividadesExecutora" id="formularioAtividadesExecutora">
							<input type="hidden" name="tipo_atividade" id="tipo_atividade" value="Assessoramento Especializado">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Arquivo</label><small> permitidos: Excel</small>
										<input class="form-control" type="file" id="fileUpload" name="fileUpload"
											   accept=".xlsx">
										<small><i class="fas fa-info-circle" style='color:green'></i> tamanho max(5mb)
										</small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<a href='javascript:void(0);' onclick="ModeloGeo('Modelo de Formulário - Assessoramento Especializado.xlsx')" ><span class="right badge badge-info">Baixe o modelo de planilha</span></a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
									<button type="button" name="insereAtividade" id="insereAtividade"
											class="btn btn-block btn-primary">Salvar
									</button>
								</div>
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
