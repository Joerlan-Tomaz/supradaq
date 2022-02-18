<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/pbapbai/pbapbaiView.js')) ?>" type="text/javascript"></script>
	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>PBA / PBAI</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"> <?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">PBA / PBAI</li>
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
                            Deverá ser apresentada a cópia de do PBA/PBAI no formato pdf, além de breve resumo descritivo contendo a data de elaboração do mesmo, 
                            empresa/contrato elaborador e valor de implementação.
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
                             <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="voltar" id="voltar" onclick="rotaGestaoAmbientalDaq()" class='btn btn-block btn-secondary' ><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
                                </div>
                            </div>
                           
                        </div>                 
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_pbapbai">
                        <div class="col-md-12 table-responsive">
                            <table id="tablePbaPbai" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Resumo</th>
                                        <th>Arquivo</th>
                                        <th>PBA</th>
                                        <th>PBAI</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>
                        </div>                  
                    </div>
                    <form method="post" name="formularioPbaPbai" id="formularioPbaPbai">
                        <div id="cadastroPbaPbai">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select id="tipopbapabi" name="tipopbapabi" class="form-control" >
                                        <option value="Selecione" selected>Selecione</option>
                                        <option value="pba">PBA</option>
                                        <option value="pbai">PBAI</option>
                                        </select>                                                       
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>PBA</label>
                                        <select id="pba" name="pba" class="form-control"></select>                                                       
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>PBAI</label>
                                        <select id="pbai" name="pbai" class="form-control"></select>                                                       
                                    </div> 
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Arquivo</label><small> arquivos permitidos: (.pdf,.docx)</small>
                                        <input type="file" id="fileUpload" name="fileUpload" class="form-control" accept=".pdf,.docx"> 
                                        <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>                                         
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea rows="8" type="text" id="resumoPbaPbai" name="resumoPbaPbai" class="form-control"></textarea>
                                    </div> 
                                </div>
                            </div>  
                            <div class="row">   
                                <div class="col-md-1">  
                                    <label>&nbsp;</label>
                                    <button type="button" name="inserePbaPbai" id="inserePbaPbai" class="btn btn-block btn-primary">Salvar</button>
                                    <button type="button" name="editarPbaPbai" id="editarPbaPbai" class="btn btn-block btn-primary">Editar</button>
                                    <input type="hidden" name="hdn_pbapbai" id="hdn_pbapbai">
                                    <input type="hidden" name="hdn_pbapbaiarquivo" id="hdn_pbapbaiarquivo">
                                </div>   
                            </div> 
                        </div>   
                    </form>                        
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
</div>
