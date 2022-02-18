<script src="<?php echo(base_url("application/homeDaq/homeCgop/assets/js/supervisaodaq/pgq/pgqView.js")) ?>" type="text/javascript"></script>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>PGQ - Programa de Gestão da Qualidade</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">PGQ</li>
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
                            Deve ser anexado cópia do PGQ elaborado pela construtora. Caso a construtora disponibilize o PGQ a empresa fiscalizadora deve encaminhar ofício
                            ao fiscal do contrato notificando a necessidade de uma cópia do PGQ.
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
                            
                          
                        </div>                
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_PGQ">
                        <div class="col-md-12 table-responsive">
                            <table id="tablePGQ" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Observação</th>
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
  
                    <div class="row" id="cadastroPGQ">
                                <div class="col-md-6">
                                    <small> arquivos permitidos: (.pdf)</small>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <input class="form-control" type="file" id="fileUpload" name="arquivo" accept=".pdf,.PDF">

                                    </div>
                                    <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea id="pgq" name="pgq" rows="5" style="min-width: 100%"></textarea>                                                          
                            </div> 
                        </div> 
                        <div class="col-md-1">  
                            <button type="button" name="inserePGQ" id="inserePGQ" class="btn btn-block btn-primary">Salvar</button>
                        </div>
                    </div>             

                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
    <!-- /.content -->
</div>
