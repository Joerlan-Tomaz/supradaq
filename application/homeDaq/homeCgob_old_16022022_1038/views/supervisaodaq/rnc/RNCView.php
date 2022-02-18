<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/rnc/rncView.js')) ?>" type="text/javascript"></script>
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>RNC</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);"
													   onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a>
						</li>
						<li class="breadcrumb-item active">RNC</li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="card card-default">
				<div class="card-header">
					<h6>
						Devem ser registradas as fichas de ocorrências de campo identificando todas as ocorrências de
						não conformidades encontradas
						pela empresa Supervisora em relação aos serviços das empresas executoras, seja pelo não
						cumprimento do
						Projeto Executivo ou pelas normas técnicas vigentes, sugerindo soluções.
						<div class='ocultar'><u>[+/-] Leia mais...</u></div>
						<div class='mostrar'>
							Deve-se ater ao registro fotográfico no campo apropriado, com inserção de 04 fotos, com
							respectivas descrições e localizações. <br>
							As RNC’s deverão ser gerenciadas na ferramenta SUPRA, sendo utilizado módulo específico para
							registro e gerenciamento das mesmas,
							que deverão ser acompanhadas até que sejam efetivamente sanadas.<br>
						</div>
					</h6>

					<div class="row">
						<div class="col-xs-12 col-md-1">
							<div>
								<button type="button" name="btnInclusao" id="btnInclusao"
										class="btn btn-block btn-primary">Incluir
								</button>
							</div>
							<div>
								<button type="button" name="searchdate" id="searchdate"
										class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i>
									Voltar
								</button>
							</div>
						</div>
						<div class="col-xs-12 col-md-2">
							<div>
								<button type="button" name="btnNoAtividade" id="btnNoAtividade"
										class="btn btn-block btn-info">Não houve atividades
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card-body">
					<div class="row" id="nova_rnc">
						<!-- <div class="col-md-2">
							<select class="form-control" id="filtroStatus">
								<option value="periodoReferencia">Por período de referência</option>
								<option value="Aberto">Aberto</option>
								<option value="Fechado">Fechada</option>
							</select>
						</div> -->
						<div class="col-md-12 table-responsive">
							<table id="tableRnc" class="table table-striped">
								<thead>
								<tr>
									<th>Período de Referência</th>
									<th>Status</th>
									<th>Km</th>
									<th>Natureza</th>
									<th>Grau</th>
									<th>Fotos</th>
									<th>Atualizar</th>
									<th>Data de Atualização</th>
									<th>Usuário</th>
									<th>Última Edição</th>
									<th>Ações</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>

					<div id="cadastroRnc">
						<form method="post" name="formularioRnc" id="formularioRnc">
							<div class="row">
								<div class="col-12 col-md-4">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Data do Registro</label>
												<div class="input-group date">
													<div class="input-group-prepend">
														<span class="input-group-text"><i
																	class="fa fa-calendar"></i></span>
													</div>
													<input id="data_atividade" name="data_atividade" type="text"
														   data-provide="datepicker" class="datepicker form-control"
														   required="true">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Gravidade</label>
												<select class="form-control" name="grau" id="grau">
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Natureza</label>
												<select class="form-control" name="natureza" id="natureza"></select>
											</div>
										</div>

										<!--        <div class="col-md-3">
												   <div class="form-group">
													   <label>Obra</label>
													   <select class="form-control" name="obra" id="obra"></select>
												   </div>
											   </div>

											   <div class="col-md-3">
												   <div class="form-group">
													   <label>Pavimento</label>
													   <select class="form-control" name="pavimento" id="pavimento"></select>
												   </div>
											   </div> -->
									</div>
									<!-- <small>Localização</small>
									<div class="col-md-12" style="border-top: 1px solid #f4f6f9;"></div> -->

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Tipo Eixo</label>
												<select class="form-control" name="tipoEixo" id="tipoEixo">
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Km</label>
												<input id="km" name="km" maxlength='9' class="form-control" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Latitude</label>
												<input id="coord_UTM_N" name="coord_UTM_N" maxlength="10"
													   class="form-control" type="text">
											</div>
										</div>
										<div class="col-md-6">

											<div class="form-group">
												<label>Longitude</label>
												<input id="coord_UTM_E" name="coord_UTM_E" maxlength="10"
													   class="form-control" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Data de Atualização</label>
												<div class="input-group date">
													<div class="input-group-prepend">
														<span class="input-group-text"><i
																	class="fa fa-calendar"></i></span>
													</div>
													<input id="data_atualizacao" name="data_atualizacao" type="text"
														   data-provide="datepicker" class="datepicker form-control"
														   required="true">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Data de Fechamento</label>
												<div class="input-group date">
													<div class="input-group-prepend">
														<span class="input-group-text"><i
																	class="fa fa-calendar"></i></span>
													</div>
													<input id="data_fechamento" name="data_fechamento" type="text"
														   data-provide="datepicker" class="datepicker form-control"
														   required="true">
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-12 col-md-8" style="border-left: 1px solid #f4f6f9;">
									<div class="form-group">
										<label>Descrição</label>
										<textarea id="status_detalhado" name="status_detalhado" rows="5"
												  style="min-width: 100%"></textarea>
									</div>
									<div class="form-group">
										<label>Sugestão de Providências</label>
										<textarea id="sugestao_providencia" name="sugestao_providencia" rows="5"
												  style="min-width: 100%"></textarea>
									</div>
								</div>


							</div>
							<div class="col-md-1">
								<div class="form-group">
									<button type="button" name="insereRnc" id="insereRnc"
											class="btn btn-block btn-primary">Salvar
									</button>
								</div>
							</div>
						</form>
					</div>

					<form id="form_fotos" method="post" enctype="multipart/form-data">
						<div class="row form-group" style="display:none;" id="registroFotografico">

							<div class="col-md-6">
								<small>Documentação Fotográfica (4 fotos com formato JPEG/JPG) </small>
								<div style="border-top: 1px solid white;"></div>
								<br>
								<div class="col-md-12">
									<div class="form-group">
										<input type="file" class="form-control" id="fileUpload" name="fileUpload"
											   accept=".jpg,.jpeg" onchange="PreviewImage();" multiple="4">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<small>Data de Atualização </small>
								<div style="border-top: 1px solid white;"></div>
								<br>
								<div class="form-group">
									<div class="input-group date">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										</div>
										<input id="dta_atualizacao" name="dta_atualizacao" type="text"
											   data-provide="datepicker" class="datepicker form-control" required="true"
											   placeholder="Data de Atualização">
									</div>
								</div>
							</div>


							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group" style="text-align: center;">
											<a id='fancyFoto0' href='assets/img/users/default_photo.png'
											   data-fancybox='group'>
												<img src="assets/img/users/default_photo.png" alt="img01" width="200px"
													 height="180px" id="uploadPreview0">
											</a>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Descrição</label>
											<input id="descricao_foto00" name="descricao_foto00" class="form-control"
												   type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-12">
									<div class="form-group" style="text-align: center;">
										<a id='fancyFoto1' href='assets/img/users/default_photo.png'
										   data-fancybox='group'>
											<img src="assets/img/users/default_photo.png" alt="img02"
												 id="uploadPreview1" data-caption='' width="200px" height="180px">
										</a>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Descrição</label>
										<input id="descricao_foto01" name="descricao_foto01" class="form-control"
											   type="text">
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="col-md-12">
									<div class="form-group" style="text-align: center;">
										<a id='fancyFoto2' href='assets/img/users/default_photo.png'
										   data-fancybox='group'>
											<img src="assets/img/users/default_photo.png" alt="img03" width="200px"
												 height="180px" id="uploadPreview2">
										</a>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Descrição</label>
										<input id="descricao_foto02" name="descricao_foto02" class="form-control"
											   type="text">
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="col-md-12">
									<div class="form-group" style="text-align: center;">
										<a id='fancyFoto3' href='assets/img/users/default_photo.png'
										   data-fancybox='group'>
											<img src="assets/img/users/default_photo.png" alt="img04" width="200px"
												 height="180px" id="uploadPreview3">
										</a>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Descrição</label>
										<input id="descricao_foto03" name="descricao_foto03" class="form-control"
											   type="text">
									</div>
								</div>
							</div>

							<div class="col-md-1">
								<button type="button" name="insereRncFotografico" id="insereRncFotografico"
										class="btn btn-block btn-primary">Salvar
								</button>
								<input type="hidden" id="id_rnc" name="id_rnc">
							</div>
							<hr>
							<div class="col-md-12">
								<div class="form-group">
									<table id="tablefotos" class="table table-striped" style="width: 100%">
										<thead>
										<tr>
											<th>#</th>
											<th>Foto</th>
											<th>Nome</th>
											<th>Descricao</th>
											<th>Data de Atualização</th>
											<th>Usuário</th>
											<th>Última Edição</th>
											<th>Ação</th>
										</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</form>
					<div class="row" style="display:none;" id="registroFotograficoInserido">
						<div class="col-md-12">
							<table id="tableFotos" class="table table-striped">
								<thead>
								<tr>
									<td style="width: 20%">Foto</td>
									<td>Descrição</td>
									<td></td>
									<td></td>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<iframe id="invisible" style="display:none;"></iframe>
	</section>
</div>
<div id="solucionarRNC" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" style=" width: 80%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Solucionar Registro de Não Conformidade</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="post" name="formSolucaoRnc" id="formSolucaoRnc">
					<input type="hidden" id="id_regnconformidade" name="id_regnconformidade">
					<div class="row">
						<div class="col-md-6">
							<label>Data de Atualização</label>
							<div class="input-group date">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								</div>
								<input id="dt_atualizacao" name="dt_atualizacao" type="text" data-provide="datepicker"
									   class="datepicker form-control" required="true">
							</div>
						</div>
						<div class="col-md-6">
							<label>Data de Fechamento</label>
							<div class="input-group date">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								</div>
								<input id="dt_fechamento" name="dt_fechamento" type="text" data-provide="datepicker"
									   class="datepicker form-control" required="true">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Descrição</label>
								<textarea rows="5" style="width: 100%" type="text" id="desc_rnc" name="desc_rnc"
										  class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Providências</label>
								<textarea rows="5" style="width: 100%" type="text" id="providencia" name="providencia"
										  class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-1">
							<button type="button" class="btn btn-primary" id="btnInsereSolucaoRNC"
									name="btnInsereSolucaoRNC">Salvar
							</button>
							<input id="idrgn" name="idrgn" type="hidden">
						</div>
						<div class="col-md-1">
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<table id="tableSugestaoRNC" class="table table-striped" style="width: 100%">
									<thead>
									<tr>
										<th>Descrição</th>
										<th>Providência</th>
										<th>Data de Atualização</th>
										<th>Usuário</th>
										<th>Última Edição</th>
										<th>Ações</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>
