<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/mapasituacao/mapasituacaoView.js'))?>" type="text/javascript"></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Mapa de Situação</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Mapa de Situação</li>
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
                        <font size="3">Deverá ser apresentado um mapa de situação do objeto contratual, referente a cada lote de obra,
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                        <div class='mostrar'> 
                            incluindo: 
                            - Mapa do Brasil, destacando-se onde se desenvolve o trecho; 
                            - Mapa da região de interesse dos trabalhos, com detalhes suficientes para caracterizar a sua situação dentro da malha viária regional.
                            A legenda do mapa de situação e principais pontos de passagem incluirão as informações: hidrovia, trecho, segmento, extensão e código do SNV. 
                            Todo o conjunto de informações deverá constar em folha única, tamanho A4, adotando o modelo RM -  2 e RM -  3. 
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
                    <form method="post" name="formularioConfigMapa" id="formularioConfigMapa">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Imagem</label> <small> (.png,.jpg,.jpeg)</small><br>
                                    <input class="form-control" id="fileUploadConfigMapa" name="fileUploadConfigMapa" type="file" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tableMapaSituacao" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
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
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
</div>
