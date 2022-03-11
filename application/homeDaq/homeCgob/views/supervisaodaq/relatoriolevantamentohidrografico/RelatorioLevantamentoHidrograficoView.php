<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/relatoriolevantamentohidrografico/relatoriolevantamentohidrograficoView.js')) ?>" type="text/javascript"></script>
<div oncontextmenu="return false">
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Relatório de Levantamento Hidrográfico</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Relatório de Levantamento Hidrográfico</li>
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
                            	bla bla bla
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
								bla bla bla 2
                            </div>
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
							<div class="col-xs-12 col-md-2">
								<div>
									<button type="button" name="btnNoAtividade" id="btnNoAtividade"
											class="btn btn-block btn-info">Não houveram atividades
									</button>
								</div>
							</div>
                        </div>
                    </form>
                </div>

                <div class="card-body">

                    <div class="row" id="novo_RelatorioLevantamentoHidrografico">
                        <div class="col-md-12 table-responsive">
                            <table id="tableRelatorioLevantamentoHidrografico" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Número SEI</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div id="cadastroRelatorioLevantamentoHidrografico">
                        <div class="col-md-12">
                            <form method="post" name="formularioRelatorioLevantamentoHidrografico" id="formularioRelatorioLevantamentoHidrografico">
                                <div class="form-group">
                                    <label>Número SEI</label>
                                    <textarea id="numeroSeiRelatorioLevantamentoHidrografico" name="numeroSeiRelatorioLevantamentoHidrografico" rows="2" style="min-width: 100%"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1">
                            <button type="button" name="insereRelatorioLevantamentoHidrografico" id="insereRelatorioLevantamentoHidrografico" class="btn btn-block btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
