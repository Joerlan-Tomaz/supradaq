<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/controlefluviometrico/controlefluviometricoView.js')) ?>"
		type="text/javascript"></script>
<style>
	label {
		display: inline-block;
		width: 5em;
	}
</style>
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Status de Operação</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);"
													   onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a>
						</li>
						<li class="breadcrumb-item active">Status de Operação</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="card card-default">
				<div class="card-header">
					<form method="post" name="formulario">
						<h6>
							O status de operação deverá ser incluído diariamente no SUPRA. Este controle deverá conter todos os dias do mês (inclusive os domingos e feriados).
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
							<div class='mostrar'>
								As informações devem ser compatíveis com o Diário de Operações.<br>
								No caso de o contrato de Operações estar paralisado no trecho supervisionado, não é necessária a apresentação do controle Fluviométrico.<br>
								O controle Fluviométrico deve ser apresentado no relatório de supervisão conforme RM -  17.
							</div>
						</h6>

						<div class="row">
							<div class="col-xs-12 col-md-1">
								<div>
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
					<div class="row" id="novo_controleFluviometrico">
						<div class="col-md-12 table-responsive">
							<table id="tableControleFluviometrico" class="table table-striped">
								<thead>
								<tr class="text-center">
									<th>Infraestrutura</th>
									<th>Dias</th>
									<th>Usuário</th>
									<th>Atualização</th>
									<th>Ações</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<a class="dias" style="border: 2px solid #DCDCDC;padding: 2px; background-color: #DCDCDC; color: #DCDCDC">XX</a> Sem Preenchimento &nbsp;&nbsp;
							<a class="dias" style="border: 2px solid #37bf48;padding: 2px; background-color: #37bf48; color: #37bf48">XX</a> Em Operação&nbsp;&nbsp;
							<a class="dias" style="border: 2px solid #c13259;padding: 2px; background-color: #c13259; color: #c13259">XX</a> Fora de Operação&nbsp;&nbsp;
							<a class="dias" style="border: 2px solid #7e757d;padding: 2px; background-color: #7e757d; color: #7e757d">XX</a> Não Aplicável
						</div>
					</div>

					<div class="row" id="cadastroControleFluviometrico">
						<div class="col-md-12">
							<form method="post" name="formularioControleFluviometrico"
								  id="formularioControleFluviometrico">
								<input type="hidden" name="infraestrutura" id="infraestrutura" value="" />
                                                                
								<div class="row">
                                                                    <div class="col-xs-12 col-md-1">
                                                                        <div>
                                                                        </div>
                                                                        <div>
                                                                            <button type="button" name="ip4" id="ip4"
                                                                                    class='btn btn-block btn-primary' onclick="editar('null', 'sim');"> IP4
                                                                            </button>
                                                                        </div>                                                                               

                                                                    </div>
                                                                    <div class="col-xs-12 col-md-1">
                                                                        <div>
                                                                        </div>
                                                                        <div>
                                                                            <button type="button" name="jusante" id="jusante"
                                                                                    class='btn btn-block btn-primary' onclick="editar('null', 'sim');"> Eclusa
                                                                            </button>
                                                                        </div>                                                                               

                                                                    </div>
								</div>
                                                                <br>
								<table id="tableCadastroControleFluviometrico" class="table table-striped" style="width: 100%;">
									<tbody>
									</tbody>
								</table>
							</form>
						</div>
						<div class="col-md-1">
							<button type="button" name="insereControleFluviometrico" id="insereControleFluviometrico"
									class="btn btn-block btn-primary">Salvar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
