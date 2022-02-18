<script src="<?php echo(base_url("application/homeDaq/homeCgop/assets/js/supervisaodaq/resumoprojeto/resumoprojetoView.js")) ?>" type="text/javascript"></script> 
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
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
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
                            O resumo do Projeto Executivo deve ser abrangente ao expor informações julgadas relevantes à compreensão técnica da operação.
                            </font>
                        </h2>
                        <div class="row">
                           <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div> 
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_resumoProjeto">
                        <div class="col-md-12 table-responsive">
                            <table id="tableResumo" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nome da Infraestrutura</th>
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
                    <div  id="cadastroResumoProjeto">
                        <form method="post" name="formularioResumoProjeto" id="formularioResumoProjeto">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nome da Infraestrutura ou Eixo</label>
                                        <select class="form-control" id="tipo_texto_resumo" name="tipo_texto_resumo"></select>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
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
