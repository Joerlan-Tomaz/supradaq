<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/atividadesupervisora/atividadesupervisoraView.js')) ?>" type="text/javascript"></script>  
<div oncontextmenu="return false">  
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Atividades da Supervisora</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Atividades da Supervisora</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h2>
                            <font size="3"> 
                            Indicar as atividades efetivamente executadas pela equipe de supervisão no período indicado. <br>
                            Para cada uma das atividades realizadas, indicar as infraestruturas a que se referem.
                            </font>
                        </h2>
                        <div class="row">
                             <div class="col-xs-12 col-md-2">
                                 <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div> 
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
<!--                             <div class="col-xs-12 col-md-1">
                                <div> 
                                  <button type='button' name="btnRecuperaUltimo" id="btnRecuperaUltimo"  class='btn btn-default' data-toggle='tooltip' title='Recupera os dados do período referência anterior' data-placement='top'><i class='fa fa-search'></i></button>
                                </div>  
                            </div> -->
                           
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row" id="nova_atividade">
                        <div class="col-md-12 table-responsive">
                            <table id="atividadesexecutadas" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Resumo</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>     
                        </div>					
                    </div>
                    <div class="row" id="cadastroAtividade">
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-12" id="cadastroAtividade">
                                    <form method="post" name="formularioAtividadesExecutadas" id="formularioAtividadesExecutadas">
                                        <div class="form-group">
                                            <label>Descrição</label>
                                            <textarea id="descAtividadesExecutadas" name="descAtividadesExecutadas" rows="5" style="min-width: 100%"></textarea>                                
                                        </div> 
                                        <div class="form-group">
                                            <input class="form-control" type="hidden" id="id_resumo" name="id_resumo">
                                        </div> 
                                    </form>	                   
                                </div>
                                <div class="col-md-1">	
                                    <button type="button" name="insereAtividadesExecutadas" id="insereAtividadesExecutadas" class="btn btn-block btn-primary">Salvar</button>
                                </div> 
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>
</div>
