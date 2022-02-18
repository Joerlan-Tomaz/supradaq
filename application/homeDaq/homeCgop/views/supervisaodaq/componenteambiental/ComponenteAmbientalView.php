<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/componenteambiental/componenteambientalView.js')) ?>" type="text/javascript"></script>  	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Monitoramento Ambiental</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Monitoramento Ambiental</li>
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
                        <h6>
                           O monitoramento ambiental objetiva munir a fiscalização com procedimentos que permitam identificar, 
                            acessar e possibilitar o cumprimento da legislação ambiental aplicável e de outros instrumentos legais e normativos.
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>  
                                Caso exista Supervisão/Gerenciadora Ambiental, deverão ser anexados todos os Registros de Não Conformidade lavrados,
                                até que o seu respectivo Atestado de Conformidade seja emitido pela Supervisão Ambiental e anexado ao relatório da operação.<br>
                                Deve ser incluído ainda resumo de todos os fatos ambientais relevante ocorridos no período.
                            </div>
                        </h6>

                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div>
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i>Voltar</button>
                                </div>  
                            </div>
                           
                        </div>                  
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_componenteAmbiental">
                        <div class="col-md-12 table-responsive">
                            <table id="tableComponenteAmbiental" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Resumo</th>
                                        <th>Arquivo</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th> 
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>                               
                            </table>     
                        </div>                  
                    </div>
                    <div id="cadastroComponenteAmbiental">
                        <form method="post" name="formularioComponenteAmbiental" id="formularioComponenteAmbiental">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> 
                                    <label>Arquivo</label> 
                                    
                                        <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=".pdf,.docx,.xlsx">
                                        <small>Arquivos permitidos: Word/PDF/Excel  </small>
                                        <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                    </div>
                                </div>
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea id="componenteAmbiental" name="componenteAmbiental" rows="5" style="min-width: 100%"></textarea>                                                          
                                    </div> 
                                </div> 
                            </div>
                        </form> 
                        <div class='col-md-1'>
                            <input type='button' name='insereComponenteAmbiental' id='insereComponenteAmbiental' class='btn btn-block btn-primary' value="Salvar">
                        </div>
                    </div>         
                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
    <!-- /.content -->
</div>
