<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/relaorioansupervisao/relaorioansupervisao.js')) ?>"
		type="text/javascript"></script>

<style>

	.analiseA {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 11px;
		text-decoration: none;
		color: #015175;
		font-style: normal;
		font-weight: bold;
	}

	a.analiseA:hover {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 11px;
		text-decoration: underline;
		color: #015175;
		font-style: normal;
		font-weight: bold;
	}

	.analiseB {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 11px;
		text-decoration: none;
		color: #015175;
		font-style: normal;
		font-weight: normal;
	}

	a.analiseB:hover {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 11px;
		text-decoration: underline;
		color: #015175;
		font-style: normal;
	}
</style>

<!-- Main content -->
<div class="content-wrapper" style="min-height: 430px;margin-left: 0px;">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Análise de Relatórios</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
						<li class="breadcrumb-item active">Análise de Relatórios</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="card card-default">

				<div class="card-body">
					<form method="post" name="formulario">
						<!--linha-->
						<div class="analiseA">
							<div class="row">
								<div class="col-xs-6 col-md-6 analiseA">
									<div class="input-group date">
										<input type="text" id="datepicker" name="datepicker"
											   class="form-control analiseA">
										<span class="input-group-btn">
                                        <button type="button" name="searchdate" id="searchdate" class="btn btn-flat"
												style="border-radius: 0.25rem;color:white; background-color: #015175; border-color: #015175;" onclick="recuperaAnaliseContrato()"><i
													class="fa fa-search"></i>
                                        </button>
                                    </span>
									</div>
								</div>
								<div class="col-xs-6 col-md-6 analiseA">
									<div class="input-group">
										<select class="form-control analiseA" name="pesquisaruf" id="pesquisaruf">
											<option value="">Todas UFs</option>
											<option value="AC">Acre</option>
											<option value="AL">Alagoas</option>
											<option value="AP">Amapá</option>
											<option value="AM">Amazonas</option>
											<option value="BA">Bahia</option>
											<option value="CE">Ceará</option>
											<option value="DF">Distrito Federal</option>
											<option value="ES">Espírito Santo</option>
											<option value="GO">Goiás</option>
											<option value="MA">Maranhão</option>
											<option value="MT">Mato Grosso</option>
											<option value="MS">Mato Grosso do Sul</option>
											<option value="MG">Minas Gerais</option>
											<option value="PA">Pará</option>
											<option value="PB">Paraíba</option>
											<option value="PR">Paraná</option>
											<option value="PE">Pernambuco</option>
											<option value="PI">Piauí</option>
											<option value="RJ">Rio de Janeiro</option>
											<option value="RN">Rio Grande do Norte</option>
											<option value="RS">Rio Grande do Sul</option>
											<option value="RO">Rondônia</option>
											<option value="RR">Roraima</option>
											<option value="SC">Santa Catarina</option>
											<option value="SP">São Paulo</option>
											<option value="SE">Sergipe</option>
											<option value="TO">Tocantins</option>
										</select>
										<span class="input-group-btn">
                                        <button type="button" name="btnuf" id="btnuf" class="btn btn-flat"
												style="border-radius: 0.25rem; color:white; background-color: #015175; border-color: #015175;" onclick="recuperaAnaliseContrato()"><i
													class="fa fa-search"></i>
                                        </button>
                                    </span>
									</div>
								</div>

							</div>
						</div>
					</form>
				</div>
			</div>
			<!--linha-->
			<!--table-->
			<div class="card card-default">
				<div class="card-body">
					<div class="box-body" id="analiseContrato">
						<div class="col-md-12 table-responsive">
							<table id="tableAnaliseContrato" class=" table table-bordered table-striped table-hover">
								<thead>
								<tr class="analiseA">
									<td width="1%">#</td>
									<td width="30%">Contrato</td>
									<td width="30%">Supervisora</td>
									<td width="5%">BR/UF</td>
									<td width="5%">Fechamento</td>
									<td width="15%">Status/Versão</td>
									<td width="25%">Ações</td>
								</tr>
								</thead>
								<tbody class="analiseB"></tbody>
							</table>
						</div>
					</div>
					<!--Dados Contrato-->
					<div class="row" id="exibeDadosContrato">
						<div class="col-md-3">
							<div class="description-block border-right" style="min-height: 50px;">
								<b class="description-header"><span class="label_contrato"></span> </b>
							</div>

						</div>
						<div class="col-md-3">
							<div class="description-block border-right" style="min-height: 50px;">
								<b class="description-header"><span class="label_supervisora"></span></b>
							</div>

						</div>
						<div class="col-md-3">
							<div class="description-block border-right" style="min-height: 50px;">
								<b class="description-header"><span class="label_rp"></span> <span
											class="label_versao"></span> </b>
							</div>

						</div>
						<div class="col-md-3">
							<div class="description-block border-right" style="min-height: 50px;">
								<b class="description-header"><span class="label_uf"></span> </b>
							</div>
						</div>
					</div>
					<br><br>

					<div class="row">
						<div class="col-md-2">
						</div>
						<div class="col-xs-5 col-md-4 ">
							<div class="form-group">
								<button type="button" name="btnHistorico" id="btnHistorico"
										class="btn btn-block btn-primary"
										style="color: #6c757d;background-color: white; border-color: #6c757d; border-radius: 1.25rem;">
									Historico <i class="fas fa-list"></i></button>
								<input type="hidden" id="id_contrato_historico" name="id_contrato_historico">
							</div>
						</div>

						<div class="col-xs-5 col-md-4 ">
							<button type="button" name="btnConcluir" id="btnConcluir" class="btn btn-block btn-primary"
									onclick="ModalconcluirAnalise()"
									style="color: #6c757d;background-color: white; border-color:#6c757d; border-radius: 1.25rem;">
								Concluir Análise <i class="fa fa-pencil-square-o"></i></button>
						</div>
						<div class="col-md-2">
						</div>

					</div>
					<br><br>

					<!--Dados do modulo-->
					<div class="row" id="modulos_analise">
						<div class="col-md-12 table-responsive">
							<table id="table_modulos_analise" class=" table table-striped">
								<thead>
								<tr class="analiseA">
									<td width="5%">#</td>
									<td width="25%"><b>Módulo</b></td>
									<td width="25%"><b>Usuário</b></td>
									<td width="25%"><b>Atualização</b></td>
									<td width="10%"><b>Ações</b></td>

								</tr>
								</thead>
								<tbody class="analiseB"></tbody>
							</table>
						</div>
					</div>
				</div>

				<!--Fecha div-->
			</div>
		</div>
		<!-- Modais abaixo -->

		<div class="modal fade" id="modalAceiteEditar" role="dialog">
			<div class="modal-dialog modal-lg" style=" width: 50%;">

				<div class="modal-content" style="border-radius: 1.25rem;">
					<div class="modal-header"
						 style="border-top-left-radius: 1rem !important; border-top-right-radius: 1rem !important;">
						<h5 class="modal-title" id="descModulo"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body" id="cadastroHistorico">
						<form method="post" name="formularioEditar" id="formularioEditar">
							<div class="row">
								<input type="hidden" id="id_modulo" name="id_modulo">
								<input type="hidden" id="descModuloEditar" name="descModuloEditar">
								<input type="hidden" id="id_relatorio" name="id_relatorio">
								<input type="hidden" id="id_contrato" name="id_contrato">
								<div class="col-md-12">
									<!--  <label class="radio-inline analiseA"style="font-size:16px;"><input  name="aceite" type="radio" value="Aceite">Aceite</label> -->
									<label class="radio-inline analiseA" style="font-size:16px;"><input name="aceite"
																										type="radio"
																										value="retificado"
																										checked>Não
										Aceite</label>
								</div>
								<div class="col-md-12 ">
									<div class="form-group">
										<label></label>
										<textarea rows="8" type="text" id="descEditarMotivoAnalise"
												  name="descEditarMotivoAnalise"
												  class="form-control "
												  placeholder="DESCREVA O MOTIVO DO [ NÃO ACEITE ]">
                           </textarea>
									</div>
								</div>
								<div class="col-md-12">
									<button type="button" name="insereAceite" id="insereAceite" class="btn btn-primary"
											style="background-color: #015175; border-color: #015175;width: 100%;">
										<i class="fa fa-floppy-o" aria-hidden="true" style="font-size:14px;"></i>
										Salvar
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalHisticoAnalise" role="dialog">
			<div class="modal-dialog modal-lg" style=" width: 100%;">

				<div class="modal-content" style="border-radius: 1.25rem;">
					<div class="modal-header"
						 style="border-top-left-radius: 1rem !important; border-top-right-radius: 1rem !important;">
						<h5 class="modal-title">Histórico de Análises</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="col-xs-12">
							<div class="box">
								<div class="box-body">
									<div class="container-fluid">
										<div class="table-responsive">
											<table id="tableHistoricoAnalises"
												   class="table table-bordered table-striped table-hover"
												   style="width: 100%;">
												<thead>
												<tr class="analiseA">
													<td style="width: 5%;">#</td>
													<td style="width: 10%;">Referência</td>
													<td style="width: 30%;">Aceite</td>
													<td style="width: 40%;">Analise</td>
													<td style="width: 10%;">Módulo</td>
													<td style="width: 10%;">Usuário</td>
													<td style="width: 10%;">Perfil</td>
													<td style="width: 10%;">Atualização</td>
												</tr>
												</thead>
												<tbody class="analiseB"></tbody>
											</table>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalFinalizarRelatorio" role="dialog">
			<div class="modal-dialog modal-lg" style=" width: 50%;">

				<div class="modal-content" style="border-radius: 1.25rem;">
					<div class="modal-header"
						 style="border-top-left-radius: 1rem !important; border-top-right-radius: 1rem !important;">
						<h5 class="modal-title">Concluir Análise</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body">
						<form method="post" name="formulariofinalizar" id="formulariofinalizar">
							<div class="row">
								<input type="hidden" id="id_contrato_concluir" name="id_contrato_concluir">

								<div class="col-md-12">
									<label class="radio-inline analiseA" style="font-size:16px;"><input name="aceite"
																										id="aprovado"
																										type="radio"
																										value="aprovado"
																										checked>Aprovar</label>
									<label class="radio-inline analiseA" style="font-size:16px;"><input name="aceite"
																										id="reprovado"
																										type="radio"
																										value="reprovado">Reprovar</label>
								</div>

								<div class="col-md-12 ">
									<div class="form-group">
										<label style="font-size:16px;">Descreva o motivo</label>
										<textarea rows="8" type="text" id="descfinalizarMotivoAnalise"
												  name="descfinalizarMotivoAnalise"
												  class="form-control " placeholder="Descreva o motivo">
                           </textarea>
									</div>
								</div>
								<div class="col-md-12">
									<button type="button" name="insereFinalizar" id="insereFinalizar"
											class="btn btn-primary"
											style="    background-color: #015175; border-color: #015175; width: 100%;">
										<i class="fa fa-check" aria-hidden="true" style="font-size:12px;"></i>
										Concluir
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Modais acima -->
	</section>
</div>
<br>
<br>
<footer class="main-footer" style="margin-bottom: 0px;bottom: 0; position: fixed; width: 86%;">
	<strong>SUPRA Aquaviário ©2020. DNIT - Departamento Nacional de Infraestrutura de Transportes</a>. <b>Versão</b> 1.0</strong>
</footer>



