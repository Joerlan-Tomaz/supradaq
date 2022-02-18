<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/conclusaogeral/conclusaogeralView.js')) ?>" type="text/javascript"></script>  
<div oncontextmenu="return false"> 
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Conclusão e Comentários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Conclusão e Comentários</li>
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
                            Deverá ser feito o registro de fatos marcantes ou que estejam a exigir uma decisão do DNIT, ocorridos ao longo do período a que corresponde o relatório.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                A empresa supervisora deverá emitir parecer quanto à adequabilidade das equipes, equipamentos e instalações em relação ao 
                                estágio da obra e cronogramas vigentes. <br>
                                Deverão ser sempre incluídos possíveis problemas identificados que possam vir a afetar o andamento dos serviços, 
                                incluindo sugestão para mitigá-los. É importante destacar desde quando os fatos marcantes estão sendo alertados até a sua resolução total.
                            </div>
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
                          <!--    <div class="col-xs-12 col-md-1">
                                <div> 
                                  <button type='button' name="btnRecuperaUltimo" id="btnRecuperaUltimo"  class='btn btn-default' data-toggle='tooltip' title='Recupera os dados do período referência anterior' data-placement='top'><i class='fa fa-search'></i></button>
                                </div>  
                            </div> -->
                        </div>                

                    </form>

                </div>

                <div class="card-body">

                    <div class="row" id="novo_ConclusaoGeral">
                        <div class="col-md-12 table-responsive">
                            <table id="tableConclusaoGeral" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Resumo</th>
                                        <!--<th>Arquivo</th>-->
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th> 
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>       
                        </div>  
                    </div>

                    <div id="cadastroConclusaoGeral">
                        <div class="col-md-12">
                            <form method="post" name="formularioConclusaoGeral" id="formularioConclusaoGeral">
                                <!--<div class="form-group">
                                    <small>Arquivos permitidos: Word/PDF/Excel  </small><br>
                                    <input type="file" id="fileUpload" name="fileUpload" accept=".pdf,.docx, .xlsx" class="form-control">
                                </div>-->
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea id="conclusaoGeral" name="conclusaoGeral" rows="5" style="min-width: 100%"></textarea>                                                          
                                </div> 
                            </form>
                        </div>
                        <div class="col-md-1">  
                            <button type="button" name="insereConclusaoGeral" id="insereConclusaoGeral" class="btn btn-block btn-primary">Salvar</button>
                        </div> 
                    </div>          
                </div> 
            </div>
        </div>
    </section>
</div>
</div>
