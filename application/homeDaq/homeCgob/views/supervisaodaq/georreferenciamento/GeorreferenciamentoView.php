<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/georreferenciamento/georreferenciamentoView.js'))?>" type="text/javascript"></script>
<style>

 .loader {
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Eixos Georreferenciados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"> <?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Georreferenciamento</li>
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
                        <font size="3">Devem ser descritos todos os componentes do objeto contratado, com informações de coordenadas geográficas.
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                        <div class="mostrar"> 
                            - Canal de Navegação<br>
                            
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
                    <form method="post" name="formularioConfigGeorreferenciamento" id="formularioConfigGeorreferenciamento">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome/Apelido</label><br>
                                    <input  type="text"  class="form-control" id="nome_apelido" name="nome_apelido" placeholder="Nome/Apelido do EIXO">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Eixo</label><br>
                                    <select class="form-control" id="eixo" name="eixo" required>
                                       <!--   <option value="">Selecione</option>
                                        <option value="Secundário">Secundário</option>
                                        <option value="Principal">Principal</option>
                                        <option value="Ramo">Ramo</option>
                                        <option value="Acesso">Acesso</option>
                                        <option value="Alça">Alça</option>
                                        <option value="Variante">Variante</option>
                                        <option value="Contorno">Contorno</option>
                                        <option value="Contorno">Implantação</option>
                                        <option value="Contorno">Manutenção</option>
                                        <option value="Contorno">Ampliação</option> -->
                                    </select>
                                </div>
                            </div>
                                                   
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Arquivo</label> <small> (.xlsx)</small><br>
                                    <input  type="file" accept=".xlsx" class="form-control" id="fileUploadConfigGeorreferenciamento" name="fileUploadConfigGeorreferenciamento">
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
                                    <a href="<?php 
                                    $path_arq = base_url("index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQMODELO?arq='Modelo_Geo_Eixo_Daq.xlsx'");
                                    $arquivo = "<a href=".$path_arq." target='_blank'>Modelo_Geo_Eixo_Daq.xlsx<a>";
                                    echo base_url("index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQMODELO") ?>?arq=Modelo_Geo_Eixo_Daq.xlsx" download><span class="right badge badge-info">Baixe o modelo de planilha</span></a>
                                </div>
                            </div>                       
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tableGeorreferenciamento" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">Arquivo</th>
                                        <th style="width: 25px;">Total de Linhas</th>
                                        <th style="width: 5px;">Detalhes</th>
                                        <th style="width: 20px;">Usuário</th>
                                        <th style="width: 10px;">Atualização</th>
                                        <th style="width: 5px;">Ações</th>
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
<div id="detalhesGeorreferenciamento" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalhes</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table id="tableDetalhesGeorreferenciamento" class="table table-striped" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Nome/Apelido</th>
                            <th>Eixo</th>
                            <th>Km</th>
                            <th>Estaca</th>
                            <th>Coordenadas</th>
                            <th>Fuso UTM</th>
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
