<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/introducao/introducaoView.js')) ?>" type="text/javascript"></script>	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Introdução</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"> <?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Introdução</li>
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
                        A introdução visa informar a caracterização das infraestruturas.
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
								Deve conter informações como dimensões das infraestruturas, capacidade, rio abrangente, PNV, entre outros.
                            </div>
                        </h6>

                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div>
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
                        </div>                 
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_introducao">
                        <div class="col-md-12 table-responsive" >
                            <table id="tabelaIntroducao" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Introdução</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>                  
                    </div>

                    <div id="cadastroIntroducao">
                        <form method="post" name="formularioConfigIntroducao" id="formularioConfigIntroducao">
                            <input class="form-control" type="hidden" id="id_resumo" name="id_resumo">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea rows="8" type="text" id="descricao_introducao" name="descricao_introducao" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-block btn-primary" name="insereIntroducao" id="insereIntroducao">Salvar</button>
                                </div>
                            </div>
                        </form>                         
                    </div>          
                </div> 
            </div>
        </div>
    </section>
</div>
