<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/cronograma/cronograma.js'))?>"></script>

<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/cronogramafisico/cronogramafisicoView.js'))?>" type="text/javascript"></script>	
<div oncontextmenu="return false">   
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cronograma Físico </h1>
                </div>
               <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                       <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Cronograma Físico</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h2>
                            <font size="3"> 
                            O Cronograma físico deverá ser inserido no SUPRA com seus valores previstos por disciplina de serviços, 
                            existindo um cronograma separado para cada lado de cada infraestrutura cadastrada em “Configurações > Eixos Georreferenciados”. <br>
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                As disciplinas estabelecidas foram determinadas de forma a prover uma visão gerencial do planejamento e controle das operações,
                                facilitando a apuração dos avanços, desvios e previsões de término.<br>
                                Tais disciplinas podem estar diferentes em alguns pontos da planilha contratual.<br>
                                Quando isto ocorrer, devem ser feitas adaptações necessárias, agrupando ou desmembrando itens da planilha contratual de forma que este 
                                se adeque as disciplinas de serviço estabelecida. Para tanto, o SUPRA disponibilizará orientações básicas para tais adaptações.<br>
                                A padronização dos itens será de suma importância para posteriores comparativos entre contratos os diversos contratos do DNIT.<br>
                            </div>
                            </font>
                        </h2>
                        <div class="row">
                             <div class="col-xs-12 col-md-1">
                                 <div> 
                                  <button type="button" name="btnVoltar" id="btnVoltar" onclick="rotaCronogramaDaq()" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button> 
                                 </div>
                                  <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
                            <div class="col-xs-12 col-md-1">                                
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
                
                <div class="card-body" id="exibeEixoLado">    
                  
                   <div>
                   	<label>Eixo:&nbsp;&nbsp;</label><span class="label_eixo" style="font-size: 20px;"></span> <!--<label>Intervenção :</label>-->
                   </div>
                    <hr> 
                </div>
               <div class="card-body">
                    <!-- cronogramas agrupados -->
                    <div class="row" id="visualizar_cronogramaagrupado">
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Não Publicados</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_cronogramaagrupado_naopublicado" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th> 
                                        <th>Nome da Infraestrutura/Eixo</th>
                                        <th>Versão</th>
                                        <th>Usuário</th>
                                        <th>Publicado</th>
                                        <th>Detalhado</th>
                                        <th>Inserir</th>
                                        <th>Publicar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div> 
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                                <div class="col-sm-6">
                                    <h3>Publicados</h3>
                                </div>
                            </div>
                            <table id="table_visualizar_cronogramaagrupado_publicado" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th> 
                                        <th>Nome da Infraestrutura/Eixo</th>
                                        <th>Versão</th>
                                        <th>Usuário</th>
                                        <th>Data Cronograma</th>
                                        <th>Publicado</th>
                                        <th>Data Publicação</th>
                                        <th>Usuario Publicação</th>
                                        <th>Detalhado</th>
                                        <th>Inserir</th>
                                        <th>Publicar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                
                    </div>
                    <!-- fim cronogramsa agrupados -->
                    <div class="row card" id="visualizar_cronogramafisico_eixo">
                        
                        <div class="col-md-12 table-responsive">
                            <div class="card-header">
                            <div class="col-sm-6">
                                <h3>Detalhado</h3>
                            </div>
                        </div>
                            <table id="table_visualizar_cronogramafisico_eixo" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th> 
                                        <th>Operação</th>
                                        <th>Serviço</th>
                                        <th>Tipo</th> 
                                        <th>Mês/Ano</th>
                                        <th>Executou</th>
                                        <th>Unidade Total</th><!--inicial final--><!--meta -->
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Versão</th> 
                                        <th>Publicado</th>
                                       <!-- <th>Ação</th> -->
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>
                    
                    <!-- formulario para cronograma existente -->
                    <div class="row" id="cadastraCronogramaFisico">
                        <div class="col-md-12">
                            <form method="post" name="formularioCronogramaFisico" id="formularioCronogramaFisico">
                                <div class="row">
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Ano</label>
                                            <input id="valanoreferente" type="text" class="form-control" name="valanoreferente" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">  
                                        <div class="form-group">
                                            <label>Operação</label>
                                            <select class="form-control" name="operacao" id="operacao" required> </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">  
                                        <div class="form-group">
                                            <label>Serviço</label>
                                            <select class="form-control" name="servico" id="servico" required> </select> 
                                        </div> 
                                    </div>
                                    <div class="col-md-3">  
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <select class="form-control" name="tipo" id="tipo" required> </select> 
                                        </div> 
                                    </div>
                                    <div class="col-md-3">  
                                        <label>&nbsp;</label>
                                        <button type="button" name="adicionaCamposValor" id="adicionaCamposValor" class="btn btn-block btn-info">Adicionar Campos</button>
                                        <input type="hidden" id="medicao" name="medicao">                                    
                                    </div>
                                </div>  <br>
                              
                                <div id="campoPai"></div>
								<input type="hidden" id="id_cronograma" name="id_cronograma">
								<input type="hidden" id="versao" name="versao" >
								<input type="hidden" name="nome_eixo" id="nome_eixo"/>
                            </form>
                        </div>
                        <div class="col-md-1" style="margin-top: 15px;">  
                            <button type="button" name="btninsereCronogramaFisico" id="btninsereCronogramaFisico" class="btn btn-block btn-primary" style="display: none">Salvar</button>  
                        </div>
                    </div>
                     <!-- fim formulario para cronograma existente -->
                    <br>
                    <!-- formulario para cronograma novo -->
                     <div class="row" id="cadastraCronogramaFisicoNovo">
                        <div class="col-md-12">
                            <form method="post" name="formularioCronogramaFisicoNovo" id="formularioCronogramaFisicoNovo">
                                <div class="row">

                                    <div class="col-md-2">  
                                        <label>&nbsp;</label>
                                        <button type="button" name="adicionaCamposValorNovo" id="adicionaCamposValorNovo" class="btn btn-block btn-info">Adicionar Campos</button>                                    
                                    </div>
                                </div>  
                              
                                <div id="campoPaiNovo"></div>
                            </form>
                        </div>
                        <div class="col-md-1" style="margin-top: 15px;">  
                            <button type="button" name="insereCronogramaFisicoNovo" id="insereCronogramaFisicoNovo" class="btn btn-block btn-primary" style="display: none">Salvar</button>                              
                        </div> 
                    </div>
                    <!-- fim formulario para cronograma novo -->
                    <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                    
                    <div class="row card" id="itens_inseridos">
                        <div class="col-md-12 table-responsive">
                            <table id="table_itens_inseridos" class="table table-striped" style="width: 100%">
                                 <br>
                                    <div class="col-sm-6">
                                      <h5>Itens Inseridos</h5>
                                    </div>
                                 
                                <thead>
                                    <tr>
                                        <th>#</th> 
                                        <th>Unidade Total</th><!--Inicial Final--> <!--meta -->   
                                        <th>Operação</th> <!--Obra -->
                                        <th>Serviço</th>                                   
                                        <th>Tipo</th>    <!--Tipo -->                                 
                                        <th>Executou</th>    <!--Tipo -->                                 
                                        <th>Mês/Ano</th>
                                        <th>Publicar</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>
                    <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                </div>
            </div>
        </div>
 <!--modal editar cronograma--> 
<div class="modal fade" id="editarcronograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="editar_cronograma">
                             <table id="table_editar_cronograma" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Km Inicial</th>
                                        <th>Km Final</th>
                                        <th>Usuário</th>                                        
                                        <th>Atualização</th>                                  
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                         </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="btn_salvaredicao" id="btn_salvaredicao" class="btn btn-primary btn-sm" data-dismiss="modal">Salvar</button>
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Fechar</button>
                <input type="hidden" id="editarId" name="editarId">
            </div>
        </div>
    </div>
</div>
    </section>
</div>
</div>
