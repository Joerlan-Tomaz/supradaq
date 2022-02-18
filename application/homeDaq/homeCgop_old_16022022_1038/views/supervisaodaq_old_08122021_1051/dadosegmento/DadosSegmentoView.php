<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/dadossegmento/dadossegmentoView.js')) ?>" type="text/javascript"></script>    
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dados segmento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaDaq()">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"> <?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Dados segmento</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h6>
                             Deverão apresentar Dados Segmento contratual referente a contratos de obras que tenha BR com  Km inicial e Km Final e (Porcentagem) Inicial e Final  do trecho conforme especificação do contrato.
                          <!--   <div class='ocultar' style="color: #0ccdd6"><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                
                            </div> -->
                        </h6>

                    <div class="row">
                        <div class="col-xs-12 col-md-1">
                                <div id="incluir">
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div> 
                                <div> 
                                  <button type="button" name="btnPesquisar" id="btnPesquisar" class='btn btn-block btn-secondary' ><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
                                </div>  
                               
                        </div> 
                        <div class="col-xs-12 col-md-1">                              
                                <div> 
                                  <button type="button" name="btnVoltar" id="btnVoltar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                        </div>   
                    
                    </div>            
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_dados">
                        <div class="col-md-12">
                            <table id="tabeladadossegmento" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Km Inicial / % </th>
                                        <th>Km Final / % </th>
                                        <th>UF</th>
                                        <th>Trecho</th>
                                        <th>Usuário</th>
                                        <th>Atualização</th>
                                        <th>Ações</th>   
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>                  
                    </div>

                    <div id="cadastroHistorico">
                      <div class="col-md-12"><hr>
                        <form method="post" name="formularioConfigHistorico" id="formularioConfigHistorico">
                            <input class="form-control" type="hidden" id="id_resumo" name="id_resumo">
                            <div class="row">
                                 <div class="col-md-2"> 
                                            <div class="form-group">
                                                <label>Km Inicial / %</label>
                                                <select id="kminicial" name="kminicial" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="%">%</option>
                                                    <option value="KM">KM</option>
                                                 </select>                                                    
                                            </div> 
                                        </div>
                                        <div class="col-md-2"> 
                                            <div class="form-group">
                                                <label>Km Final / %</label>
                                                <select id="kmfinal" name="kmfinal"  class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="%">%</option>
                                                    <option value="KM">KM</option>
                                                </select>                                                      
                                            </div> 
                                        </div>

                                        <div class="col-md-2"> 
                                            <div class="form-group">
                                                <label>UF</label>
                                                <select class="form-control" name="tipo_documento" id="tipo_documento">
                                                    <option value="">Selecione</option>
                                                    <option value="Acre">Acre</option>
                                                    <option value="Alagoas">Alagoas</option>
                                                    <option value="Amapá">Amapá</option>
                                                    <option value="Amazonas">Amazonas</option>
                                                    <option value="Bahia">Bahia</option>
                                                    <option value="Ceará">Ceará</option>
                                                    <option value="Distrito Federal">Distrito Federal</option>
                                                    <option value="Espírito Santo">Espírito Santo</option>
                                                    <option value="Goiás">Goiás</option>
                                                    <option value="Maranhão">Maranhão</option>
                                                    <option value="Mato Grosso">Mato Grosso</option>
                                                    <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
                                                    <option value="Minas Gerais">Minas Gerais</option>
                                                    <option value="Pará">Pará</option>
                                                    <option value="Paraíba">Paraíba</option>
                                                    <option value="Paraná">Paraná</option>
                                                    <option value="Pernambuco">Pernambuco</option>
                                                    <option value="Piauí">Piauí</option>
                                                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                                                    <option value="Rio Grande do Norte">Rio Grande do Norte</option>
                                                    <option value="Rio Grande do Sul">Rio Grande do Sul</option>
                                                    <option value="Rondônia">Rondônia</option>
                                                    <option value="Roraima">Roraima</option>
                                                    <option value="Santa Catarina">Santa Catarina</option>
                                                    <option value="São Paulo">São Paulo</option>
                                                    <option value="Sergipe">Sergipe</option>
                                                    <option value="Tocantins">Tocantins</option>
                                                </select>                                                          
                                            </div>
                                        </div>

                                        <div class="col-md-2"> 
                                            <div class="form-group">
                                                <label>Trecho</label>
                                                <input id="trecho" name="trecho" class="form-control" type="text">                                                        
                                            </div> 
                                        </div>
                            </div> 
                             <div class="row">
                                       <div class="col-md-2"> 
                                            <div class="form-group">
                                                <label></label>
                                                <input id="kminicialS" name="kminicialS" class="form-control" type="text">
                                            </div> 
                                        </div>
                                        <div class="col-md-2"> 
                                            <div class="form-group">
                                                <label></label>
                                                <input id="kmfinalS" name="kmfinalS" class="form-control" type="text">                                                        
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div   rows="4" style="height: 17px;">
                              </div> 
                            <div class="row">
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-block btn-primary" name="insereDados" id="insereDados">Salvar</button>
                                </div>
                             </div>   
                        </form>                         
                    </div>          
                </div> 
            </div>
        </div>
    </section>
</div>
<!--Modal Status-->
<div id="modalStatus" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Descrição</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <!--<label>Status</label>-->
                    <div class="table-responsive">
                        <p id="status_modal" style="text-align: justify"></p>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>

