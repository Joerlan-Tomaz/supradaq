<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/controlepluviometrico/controlepluviometricoView.js')) ?>" type="text/javascript"></script>   
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Controle Pluviométrico</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Controle Pluviométrico</li>
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
                            O controle pluviométrico deverá ser incluído diariamente no SUPRA. Este controle deverá conter todos os dias do mês (inclusive os domingos e feriados).
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                As informações devem ser compatíveis com o Diário de Obras.<br>
                                No caso de o contrato de obras estar paralisado no trecho supervisionado, não é necessária a apresentação do controle pluviométrico.<br>
                                O controle pluviométrico deve ser apresentado no relatório de supervisão conforme RM -  17.
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
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_controlepluviometrico">
                        <div class="col-md-12 table-responsive">
                            <table id="tableControlePluviometrico" class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Dia</th>
                                        <th>Situação</th>
<!--                                        <th>Tarde</th>
                                        <th>Noite</th>-->
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

                    <div class="row" id="cadastroControlePluviometrico">
                        <div class="col-md-12">                     
                            <form method="post" name="formularioControlePluviometrico" id="formularioControlePluviometrico">
                                <table id="tableCadastroControlePluviometrico" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <td style="width: 10%;"></td>
                                            <td style="width: 10%;"></td>
                                            <td style="width: 50%;"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>                               
                                </table> 
                            </form>
                        </div>
                        <div class="col-md-1">  
                            <button type="button" name="insereControlePluviometrico" id="insereControlePluviometrico" class="btn btn-block btn-primary">Salvar</button>
                        </div>
                    </div>          

                </div> 
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
