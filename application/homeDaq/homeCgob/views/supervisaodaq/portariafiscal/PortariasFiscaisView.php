<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/portariasfiscais/portariasfiscaisView.js'))?>" type="text/javascript"></script>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Portarias de Fiscais</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Portarias de Fiscais</li>
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
                        Devem ser anexadas as portarias de designação dos fiscais do DNIT responsáveis pela fiscalização dos contratos de Supervisão e de obras Aquaviarias.
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                        <div class='mostrar'> 
                            Caso haja alteração do fiscal do contrato, deverá ser apresentada a nova portaria de designação.<br>
                             Devem ser anexadas, inclusive, as portarias obsoletas, sendo as mesmas identificadas pelo nome do documento. 

                        </div>
                        </font>
                    </h2>

                    <div class="row">
                        <div class="col-xs-12 col-md-1" id="incluir" >
                            <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                        </div>
                        <div class="col-xs-12 col-md-1" id="search" style="display: none;">
                            <button type="button" name="searchdate" id="btnPesquisar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
                        </div>
                        <div class="col-xs-12 col-md-1">
                            <button type="button" name="searchdate" id="btnVoltar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row" id="nova_portariafiscal">
                        <div class="col-md-12 table-responsive" >
                            <table id="tablePortariaFiscal" class="table table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nome Fiscal</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>Titularidade</th>
                                        <th>Contrato</th>
                                        <th>Data Portaria</th>
                                        <th>Arquivo</th>
                                        <th>Ações</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>                               
                            </table>      
                        </div>                  
                    </div>

                    <div id="cadastro_portariafiscal" style="display: none;">
                        <form method="post" name="formularioPortariaFiscal" id="formularioPortariaFiscal">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Unidade Federativa</label>
                                        <select class="form-control" name="unidade_local" id="unidade_local"></select>
                                    </div>
                                </div>
                                <div class="col-md-2"> 
                                    <div class="form-group">
                                        <label>Número da Portaria Designação:</label>
                                        <input id="n_portaria" name="n_portaria" class="form-control" type="text"> 
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data Portaria</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="data_portaria" name="data_portaria" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Contrato Fiscalizado</label>
                                        <select class="form-control" name="contrato_fiscalizado" id="contrato_fiscalizado">
                                            <option value="">Selecione</option>
                                            <option value="Obra">Obra</option>
                                            <option value="Supervisão">Supervisão</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Titularidade</label>
                                        <select class="form-control" name="titularidade" id="titularidade"></select>                                            
                                        
                                    </div>
                                </div>  
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Nome Fiscal</label>
                                        <input id="nome" name="nome" class="form-control" type="text">                                                        
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><b>@</b></span>
                                            </div>
                                            <input id="email" name="email" type="email" class="form-control">                                                   
                                        </div> 
                                    </div>
                                </div> 
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Telefone:</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input id="telefone" name="telefone" class="form-control" type="tel">  
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-md-2">
                                    <label>Status</label>
                                    <input type="text" class="form-control" id="status_fiscal" name="status_fiscal" placeholder="Status Fiscal">
                                </div>
                                <div class="col-md-2">
                                    <label>Data Substituição</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <input id="data_substituicao" name="data_substituicao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                    </div> 
                                </div>-->
                                <div class="col-md-6">
                                    <label>Portaria</label><small> arquivos permitidos: (.pdf)</small>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=".pdf">

                                    </div>
                                    <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">  
                                    <br>
                                    <button type="button" name="inserePortariaFiscal" id="inserePortariaFiscal" class="btn btn-block btn-primary">Salvar</button>
                                </div>    
                            </div>                     
                        </form>
                    </div>         
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
    <!-- /.content -->
</div>
