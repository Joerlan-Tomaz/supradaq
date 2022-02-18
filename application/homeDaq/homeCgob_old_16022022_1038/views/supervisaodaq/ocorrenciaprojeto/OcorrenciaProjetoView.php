<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/ocorrenciaprojeto/ocorrenciaprojetoView.js'))?>" type="text/javascript"></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ocorrências de Projeto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"> <?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Ocorrências de Projeto</li>
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
                        <font size="3">                        
                        Deverá contemplar:
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                        <div class='mostrar'> 
                            jazidas, pedreiras, usinas, aguadas, instalações industriais, mercados abastecedores, fontes de materiais betuminosos, “filler”, dope, áreas de empréstimo, bota-fora, canteiro, ou qualquer outra informação relevante ao andamento da obra. 
                            É importante ressaltar que ocorrências que foram ou serão incluídas em Revisões de Projeto em Fase de Obra devem ser atualizadas e informadas no diagrama de localização das ocorrências.
                        </div>
                        </font>
                    </h2>
                    <div class="row">
                        <div class="col-xs-12 col-md-1">
                            <button type="button" name="btnVoltar" id="btnVoltar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                        </div>
                    </div>                  
                </div>
                <div class="card-body">
                    <form method="post" name="formularioConfigOcorrenciaProjetos" id="formularioConfigOcorrenciaProjetos">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Arquivo</label> <small> (.xlsx)</small><br>
                                    <input class="form-control" id="fileOcorrenciaProjeto_planilha" name="fileOcorrenciaProjeto_planilha" type="file" accept=".xlsx">
                                    <h6 id="linhasCarregadas" class="description-header"></h6>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <button type="button" name="btnInsere" id="btnInsere" class="btn btn-block btn-primary">Salvar</button>
                                <input type="hidden" id="hdnArquivo" name="hdnArquivo">
                                <input type="hidden" id="hdnidArquivo" name="hdnidArquivo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="<?php echo base_url("index_cgob.php/Supervisaodaq/Arquivo/Modelo") ?>?arq=Modelo_Geo_OcorrenciaProj.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha</span></a>
                                </div>
                            </div>                       
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tableOcorrenciaProjeto" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Arquivo</th>
                                        <th>Total de Linhas</th>
                                        <th>Detalhes</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>     
                        </div>                  
                    </div>
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
</div>

<div id="detalhesOcorrenciaProjeto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 80% !important">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalhes</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table id="tableDetalhesOcorrenciaProjeto" class="table table-striped" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Estaca</th>
                            <th>Coordenadas</th>
                            <th>Km</th>
                            <th>Usuário</th>
                            <th>Atualização</th>
                        </tr>
                    </thead>
                    <tbody></tbody>                               
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
