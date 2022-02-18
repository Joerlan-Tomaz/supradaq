<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/documentacaofotografica/documentacaofotograficaView.js')) ?>" type="text/javascript"></script>	
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Documentação Fotográfica</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Documentação Fotográfica</li>
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
                            O Relatório Fotográfico deverá ser compatível com o período de referência do relatório, 
                            sendo composto de fotos coloridas das infraestruturas.
                            As fotos devem ser acompanhadas da localização georreferenciada e de um breve relato sobre o serviço executado
<!--							<div class='ocultar'><u>[+/-] Leia mais...</u></div>-->
                            <div class='mostrar'>
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
                    <div class="row" id="nova_docFotografico">
                        <div class="col-md-12" >
                            <table id="tableDocFotografico" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Imagem</th>
<!--                                        <th>Km</th>-->
                                        <th>Descrição</th>
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

                    <div class="row" id="cadastroDocFotografico">
                        <form class="col-md-12" method="post" name="formularioDocFotografico" id="formularioDocFotografico">
                            <div class="col-md-5" id="divFileInsert">     
                                <div class="form-group">
                                    <small>Arquivos permitidos: jpeg  </small><br>
                                    <input class="form-control" type="file" id="fileUpload" name="fileUpload" accept=".jpg,.jpeg" multiple="">
                                    <small>*Verificar as configurações do dispositivo para que a imagem contenha a data em que foi registrada.</small><br>
                                </div>
                            </div>
                            <div class="row" id="cadastroFotos">
                            </div>
                        </form> 
                        <div class=' col-md-1'>
                            <input type='button' name='insereDocFotografico' id='insereDocFotografico' class='btn btn-block btn-primary' value="Salvar" style="display: none">
                        </div>

                    </div>        

                </div> 
            </div>
        </div>
        <iframe id="invisible" style="display:none;"></iframe>
    </section>
    <!-- /.content -->
</div>
