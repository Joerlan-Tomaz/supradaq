<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/diarioobra/diarioobraView.js')) ?>" type="text/javascript"></script>  	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Diário da Operação</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Diário da Operação</li>
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
                        <h2>
                            <font size="3">
                            Diário de operação é um documento de informação, controle e orientação, preparado de forma contínua e simultânea à execução da operação,
                            cujo teor consiste no registro sistemático.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'> 
                                Objetivo, sintético e diário dos serviços executados (delimitados por estaqueamentos) e dos eventos ocorridos no âmbito da obra, 
                                bem como de observações e comentários pertinentes, sujeitando-se às normas e procedimentos sistematizados, 
                                e que deverá obrigatoriamente ser preenchido pelo Engenheiro Fiscal do Contrato, Empresa Construtora e a Supervisora. <br>
                                Deverá constar no Relatório de Supervisão a cópia do Diário de Obra, 
                                conforme o modelo constante no normativo DNIT 097/2007 – PRO - Elaboração de Diário de Obra do DNIT.  
                            </div>
                            </font>
                        </h2>

                        <div class="row">
                             <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary" disabled="true">Incluir</button>
                                </div>
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_diarioObra">
                        <div class="col-md-12">
                            <table id="tableDiarioObra" class="table table-striped">
                                <thead>
                                    <tr>
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
                    <div id="cadastroDiarioObra">
                        <form method="post" name="formularioDiarioObra" id="formularioDiarioObra">
                            <div class="row">   
                                <div class="col-md-12">         
                                    <div class="form-group">
                                        <label>Arquivo</label><small> permitidos: Word/PDF/Excel</small>
                                        <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=".pdf,.docx,.xlsx">
                                        <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                    </div>
                                </div>                                 
                            </div>
                            <div class="row"> 
                                <div class="col-md-1">
                                    <button type="button" name="insereDiarioObra" id="insereDiarioObra" class="btn btn-block btn-primary">Salvar</button>
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
