<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/justificativaempreendimento/justificativaempreendimentoView.js'))?>" type="text/javascript"></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Justificativa do Empreendimento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Justificativa do Empreendimento</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h2>
                        <font size="3">Descrever de forma clara a importância das obras para a região, informando todos os municípios impactados,
                        direta ou indiretamente pelo empreendimento,
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                        <div class='mostrar'> 
                            Ou seja, os municípios que se beneficiarão com a execução das obras, 
                            seja com a geração de empregos, maior mobilidade, aquecimento da economia local, dentre outros. 
                            Deve ser informado ainda, o número de pessoas impactadas e os benefícios econômicos e sociais consequentes das obras.</div>
                        </font>
                    </h2>
                    <div class="row">
                    <div class="col-xs-12 col-md-1">
                        <div id="incluir">
                            <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                        </div>
                        <div>
                            <button type="button" name="btnPesquisar" id="btnPesquisar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
                        </div>
                    </div>    
                        <div class="col-xs-12 col-md-1">
                        <div>
                            <button type="button" name="btnVoltar" id="btnVoltar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                        </div>
                    </div>                  
                </div>
            </div>

                <div class="card-body">
                    <div class="row" id="pesquisaJustificativaEmpreendimento">
                        <div class="col-md-12 table-responsive">
                            <table id="tableJustificativa" class="table table-striped col-md-12" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Resumo</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>                  
                    </div>

                    <div id="cadastroJustificativaEmpreendimento" style="display: none;">
                        <form method="post" name="formularioConfigJustificativa" id="formularioConfigJustificativa">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea rows="8" type="text" id="descricao_config_justificativa" name="descricao_config_justificativa" class="form-control"></textarea>
                                        <input type="hidden" id="id_resumo" name="id_resumo">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-1">
                                <button type="button" name="insereJustificativa" id="insereJustificativa" class="btn btn-block btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
</div>
