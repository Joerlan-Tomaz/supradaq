<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/atividadesexecutora/atividadesExecutoraView.js')) ?>"
		type="text/javascript"></script>
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Atividades da Executora - Operação</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);"
													   onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a>
						</li>
						<li class="breadcrumb-item active">Atividades da Executora - Operação</li>
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
								executora no âmbito de operação.
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
							<input type="hidden" name="tipo_atividade" id="tipo_atividade" value="Operação">
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
								<div class="col-md-3">
									<div class="form-group">
										<a href="<?php echo base_url("index_cgob.php/Supervisaodaq/Arquivo/Modelo") ?>?arq=Modelo de Formulário de Operação.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha IP4</span></a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<a href="<?php echo base_url("index_cgob.php/Supervisaodaq/Arquivo/Modelo") ?>?arq=Modelo de Formulário de Operação - eclusas.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha Eclusa</span></a>
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
