<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/mobilizacaoconstrutora/mobilizacaoconstrutoraview.js'))?>" type="text/javascript"></script>	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Relação de Mobilização</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Relação de Mobilização</li>
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
                            Deve ser informado as equipes e equipamentos que trabalharam no período que
                            trata o relatório e compará-los com o efetivo do período anterior.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                O pessoal e equipamentos contratados pela executora através de subempreiteiras
                                e que executaram serviços diretamente relacionados à operação devem ser contabilizados na coluna apropriada.<br>
                            </div>
                            </font>
                        </h2>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div>
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
                          <!--  <div class="col-xs-12 col-md-2">
                                <div>
                                    <button type="button" name="btnCadastroItens" id="btnCadastroItens" class="btn btn-block btn-primary">Cadastrar novos itens</button>
                                </div>
                            </div>
                        </div>-->					
                    </form>
                </div>

                <div class="card-body">
                     <!-- cadastrar novos itens -->
                    <div class="row" id="cadastraritens">
                        <div class="col-md-3" >  
                            <div class="form-group">
                                <label>Selecione o item</label>
                                <select class="form-control" name="itemcadastro" id="itemcadastro" required></select>                                        
                            </div> 
                        </div>
                        <div class="col-md-3" >  
                            <div class="form-group">
                                <label>Código Sicro</label>
                                <input class="form-control" type="text" name="sicro" id="sicro">                                       
                            </div> 
                        </div>
                         <div class="col-md-3" >  
                            <div class="form-group">
                                <label>Tipo</label>
                                <input class="form-control" type="text" name="tipo" id="tipo">                                         
                            </div> 
                        </div>
                         <div class="col-md-12" style="font-size: small">
                            <table id="tablecadastraritem" class="table table-striped width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 26px;">#</th>
                                        <th style="width: 115px;">Item</th>
                                        <th style="width: 72px;">Código Sicro</th>
                                        <th style="width: 396px;">Tipo</th>
                                        <th style="width: 52px;">Unidade</th> 
                                        <th style="width: 55px;">Cadastrar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>     
                        </div>		
                    </div>
                    <!-- fim -->
                    <div class="row" id="nova_relacaoMobilizacao">
                        <div class="col-md-12" style="font-size: small">
                            <table id="tableRelacaoMobilizacao" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 26px;">#</th>
                                        <th style="width: 58px;">Cod.Sicro</th>
                                        <th style="width: 67px;">Item</th>
                                        <th style="width: 309px;">Tipo</th>
                                        <th style="width: 81px;">Qtd. Próprios</th> 
                                        <th style="width: 81px;">Qtd. Terceiros</th>  
                                        <th style="width: 101px;">Usuário</th>
                                        <th style="width: 104px;">Atualização</th>
                                        <th style="width: 41px;">Ações</th> 									
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>     
                        </div>					
                    </div>

                    <div class="row" id="cadastroRelacaoMobilizacao">
                        <div class="col-md-3" >  
                            <div class="form-group">
                                <label>Selecione o item</label>
                                <select class="form-control" name="item" id="item" required></select>                                        
                            </div> 
                        </div>
                    </div>    
                    <div class="col-md-12" id="tableRelacao" style="font-size: small">

                            <form method="post" name="formularioRelacaoMobilizacao" id="formularioRelacaoMobilizacao">
                                <table id="tableCadastroRelacaoMobilizacao" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td style="width: 31px;">#</td>
                                            <th style="width: 69px;">Cod.Sicro</th>
                                            <td style="width: 88px;">Item</td>
                                            <td style="width: 1307px;">Tipo</td>
                                            <td style="width: 247px;">Qtd. Próprios</td> 
                                            <td style="width: 247px;">Qtd. Terceiros</td>  									
                                        </tr>
                                    </thead>
                                    <tbody>								
                                    </tbody>                               
                                </table> 
                            </form>	                   
                       
                        <div class="col-md-1">	
                            <button type="button" name="insereRelacaoMobilizacao" id="insereRelacaoMobilizacao" class="btn btn-block btn-primary">Salvar</button>
                        </div> 
                    </div>
                    </div>          
                </div> 
            </div>
        </div>
    </section>
</div>
