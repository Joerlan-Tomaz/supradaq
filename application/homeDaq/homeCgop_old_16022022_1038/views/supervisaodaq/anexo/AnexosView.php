<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/anexos/anexosView.js')) ?>" type="text/javascript"></script>  

	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Demais Anexos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li><li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item active">Demais Anexos</li>                      
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">

                        <div class="row">
                             <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div>
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                             </div>                          
                        </div>
                        <br>
                        <div class="row invoice-info" id="exibeAvancoFisicoObra">                                        

                            <div class="col-md-4 border-right">
                                <div class="description-block">
                                    <b class="description-header" style="font-size: 14px;">MEMÓRIA DE CÁLCULO DA(S) MEDIÇÃO(ÕES) <small id='smlMemoriaCalculo' class="label pull-right bg-yellow" style="visibility: hidden"><i class="fa fa-check"></i></small></b><br>
                                    <span class="description-text">Anexo 01</span><br>
                                    <span id='spanAnexoObrigatorio' style="visibility: hidden" class="label bg-yellow">*Anexo Obrigatorio</span>
                                </div>
                            </div>

                            <div class="col-md-4 border-right">
                                <div class="description-block">
                                    <b class="description-header" style="font-size: 15px;">PLANILHA DE EQUILÍBRIO ECONÔMICO-FINANCEIRO <small id='smlPlanilhaEquilibrio' class="label pull-right bg-yellow" style="visibility: hidden"><i class="fa fa-check"></i></small></b><br>
                                    <span class="description-text">Anexo 02</span>
                                </div>
                            </div>

<!--                            <div class="col-md-2 border-right">
                                <div class="description-block">
                                    <b class="description-header" style="font-size: 15px;">ENSAIOS E RESUMOS LABORATORIAIS <small id='smlEnsaioResumo' class="label pull-right bg-yellow" style="visibility: hidden"><i class="fa fa-check"></i></small></b><br>
                                    <span class="description-text">Anexo 03</span>
                                </div>
                            </div>-->

                            <div class="col-md-4">
                                <div class="description-block ">
                                    <b class="description-header" style="font-size: 15px;">SEÇÕES TRANSVERSAIS <small id='smlSescoesTranversais' class="label pull-right bg-yellow" style="visibility: hidden"><i class="fa fa-check"></i></small></b><br>
                                    <span class="description-text">Anexo 03</span>
                                </div>

                            </div>

                          <!--   <div class="col-md-3">
                                <div class="description-block">
                                    <b class="description-header" style="font-size: 15px;">PVEGQ<small id='smlPVEGQ' class="label pull-right bg-yellow" style="visibility: hidden"><i class="fa fa-check"></i></small></b><br>
                                    <span class="description-text">Anexo 04</span>
                                </div>
                            </div> -->
                        </div>


                    </form>

                </div>

                <div class="card-body">

                    <div class="row" id="novo_anexo">
                        <div class="col-md-12 table-responsive" >
                            <table id="tableAnexos" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Arquivo</th>
                                        <th style="width: 20%" class="text-center">Tipo de Anexo</th>
                                        <th style="width: 10%" class="text-center">Usuário</th>                 
                                        <th style="width: 10%" class="text-center">Atualização</th>   
                                        <th style="width: 5%" class="text-center">Ações</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>                               
                            </table>       
                        </div>                  
                    </div>

                    <div id="cadastroAnexos">
                        <form method="post" name="formularioAnexos" id="formularioAnexos">
                            <div class="row">                                                           

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Anexo</label>
                                        <select class="form-control" name="tipo_documento" id="tipo_documento">
                                            <option value="">Selecione</option>
                                            <option>Memória de Cálculo da(s) Medição(ões)</option>
                                            <option>Planilha de Equilíbrio Econômico-Financeiro</option>
                                            <!--<option>Ensaios e Resumos Laboratorias</option>-->
                                            <option>Seções Transversais</option>
                                            <option>Outros</option>
                                           <!--  <option>PVEGQ</option> -->
                                        </select>                                                          
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Arquivos permitidos: Word/PDF/Excel  </label> 
                                        <input class="form-control" id="fileUpload" name="fileUpload" type="file" accept=".pdf,.docx,.xlsx">
                                        <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" name="insereAnexos" id="insereAnexos" class="btn btn-block btn-primary">Salvar</button>
                            </div>
                        </form> 

                    </div>         

                </div> 
            </div>
            <iframe id="invisible" style="display:none;"></iframe>
        </div>
    </section>
    <!-- /.content -->
</div>
