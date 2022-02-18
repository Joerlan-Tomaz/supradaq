<script src="<?php echo(base_url("application/homeDaq/homeCgob/assets/js/supervisaodaq/resumoprojeto/resumoprojetoView.js")) ?>" type="text/javascript"></script> 
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Resumo do Projeto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Resumo do Pojeto</li>
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
                            O resumo do Projeto Executivo deve ser abrangente ao expor informações julgadas relevantes à compreensão técnica da obra.
                            </font>
                        </h2>
                        <div class="row">
                           <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div> 
                               <div>
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i></i> Voltar</button>
                                </div>
                            </div>
                            <!-- <div class="col-xs-12 col-md-2">
                                <div>
                                    <button type="button" name="btnNoAtividade" id="btnNoAtividade" class="btn btn-block btn-info" disabled="true">Não houve atividade no mês</button>
                                </div>
                            </div> -->
                        </div>                 
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_resumoProjeto">
                        <div class="col-md-12 table-responsive">
                            <table id="tableResumo" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Resumo</th>
                                        <th>Tipo</th>
                                        <th>Arquivo</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table> 
                        </div>                  
                    </div>
                    <div  id="cadastroResumoProjeto">
                        <form method="post" name="formularioResumoProjeto" id="formularioResumoProjeto">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Intervenções</label>
                                        <select class="form-control" id="tipo_texto_resumo" name="tipo_texto_resumo"></select>                                                       
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Arquivos permitidos: Excel  </label>                                                   
                                        <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=",.xlsx">
                                        <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                  <!--       <a href="http://supra.dnit.gov.br/homeCgcont/Arquivo/Modelo?arq=Projeto_Pista_NOVA_modelo.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha(Pavimento Novo)</span></a><br>
                                        <a href="http://supra.dnit.gov.br/homeCgcont/Arquivo/Modelo?arq=Projeto_Pista_EXISTENTE_modelo.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha(Pavimento Existente)</span></a>  -->
 <!--                                    <a href="homeDaq/Supervisaodaq/Arquivo/Modelo?arq=Projeto_Pista_NOVA_modelo.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha()</span></a>
                                    <br>
                                    <a href="homeDaq/Supervisaodaq/Arquivo/Modelo?arq=Projeto_Pista_EXISTENTE_modelo.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha()</span></a> -->

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea rows="8" type="text" id="descricao_resumoProjeto" name="descricao_resumoProjeto" class="form-control"></textarea>
                                    </div> 
                                </div>
                            </div>  
                            <div class="row">   
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-block btn-primary" name="insereResumo" id="insereResumo">Salvar</button>
                                </div>  
                            </div> 
                        </form>       
                    </div>   
                </div>          
            </div> 
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
</div>
