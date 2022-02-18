<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/termoencerramento/termoencerramentoView.js')) ?>" type="text/javascript"></script>    
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Termo de Encerramento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Termo de Encerramento</li>
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
                            Finalizando o Relatório Mensal, deve ser apresentado o Termo de Encerramento, identificando o Relatório e o número de folhas que o constituem.
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
                        </div>                  

                    </form>

                </div>

                <div class="card-body">

                    <div class="row" id="novo_TermoEncerramento">
                        <div class="col-md-12 table-responsive">
                            <table id="tableTermoEncerramento" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="60%">Resumo</th>
                                        <th width="15%" class="text-center">Usuário</th>
                                        <th width="15%" class="text-center">Atualização</th>
                                        <th width="10%" class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>
                        </div>                  
                    </div>

                    <div class="row" id="cadastroTermoEncerramento">
                        <div class="col-md-12">
                            <form method="post" name="formularioTermoEncerramento" id="formularioTermoEncerramento">
                                <!--<div class="form-group">
                                    <label>Descrição</label>
                                    <textarea id="TermoEncerramento" name="TermoEncerramento" rows="5" style="min-width: 100%"></textarea>                                                          
                                </div>-->
                                <div class="form-group">
                                    <p id="TermoEncerramento" name="TermoEncerramento"></p>                                                          
                                </div> 
                                <!--<div class="form-group">
                                    <input class="form-control" type="hidden" id="id_resumo" name="id_resumo">
                                </div>-->
                            </form> 
                        </div>
                        <div class="col-md-1">
                            <button type="button" name="insereTermoEncerramento" id="insereTermoEncerramento" class="btn btn-block btn-primary">Salvar</button>
                        </div> 
                    </div>          

                </div> 
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
