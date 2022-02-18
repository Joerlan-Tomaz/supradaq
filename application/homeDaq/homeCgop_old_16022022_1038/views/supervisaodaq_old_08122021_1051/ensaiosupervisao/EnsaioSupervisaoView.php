<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/ensaioslaboratoriais/ensaioslaboratoriaisView.js')) ?>" type="text/javascript"></script>  
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ensaios Supervisão</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Ensaios Supervisão</li>
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
                        <h6>
                            Os ensaios devem ser apresentados de maneira completa, com todas as planilhas, laudos e outros documentos emitidos referentes aos ensaios laboratoriais executados.
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'> 
                                Os ensaios devem possuir os km iniciais e finais dos serviços a que se referem e devem, individualmente, 
                                possuir análise crítica dos resultados obtidos quanto a sua aceitação de acordo com o estabelecido no projeto. 
                                A Supervisora deve apresentar atestado de aprovação/reprovação dos resultados dos ensaios, de forma clara e concisa.<br>
                                Toda a documentação apresentada deverá estar assinada e carimbada pelo engenheiro responsável. 
                                Fica vedada a apresentação desta documentação com assinatura de qualquer outro profissional que não tenha anotação de 
                                responsabilidade técnica referente à supervisão das obras, conforme estabelece a Resolução n° 1.025, de 30 de outubro de 2009, do Confea.<br>
                                Deverá ser apresentada a certificação de calibração dos equipamentos utilizados nos ensaios laboratoriais no período.<br>
                                O controle mínimo exigido para verificação de qualidade de pavimento são: viga benkelman, fwd e perfilometro. 
                                Este controle deverá ser, obrigatoriamente, apresentado para a liberação do segmento ao tráfego.
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
                         
                           <!--  <div class="col-xs-12 col-md-3">
                                <div>
                                    <button type="button" name="btnNoAtividade" id="btnNoAtividade" class="btn btn-block btn-info" >Não houve atividade no mês</button>
                                </div>
                            </div> -->
                        </div>                 
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_ensaioLaboratorio">
                        <div class="col-md-12 table-responsive" >
                            <table id="tableEnsaioLaboratorio" class="table table-striped">
                                <thead>
                                    <tr>
                                        <!-- <th>Titulo</th> -->
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

                    <div id="cadastroEnsaioLaboratorio">
                        <form method="post" name="formularioEnsaioLaboratorio" id="formularioEnsaioLaboratorio">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Arquivo</label>
                                    <small> permitidos: Word/PDF/Excel</small>
                                        <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=".pdf,.docx,.xlsx">

                                        <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                    </div>
                                </div>
<!--                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input id="titulo" name="titulo" class="form-control" type="text">
                                    </div>
                                </div> -->
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea id="ensaioLaboratorio" name="ensaioLaboratorio" rows="5" style="min-width: 100%"></textarea>                                                          
                                    </div> 
                                </div> 
                            </div>
                        </form> 
                        <div class='col-md-1'>
                            <input type='button' name='insereEnsaioLaboratorio' id='insereEnsaioLaboratorio' class='btn btn-block btn-primary' value="Salvar">
                        </div>

                    </div>           

                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
    <!-- /.content -->
</div>
