<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/relatorio/relatorioView.js'))?>" type="text/javascript"></script>
<style>
    .connecting-line {
        height: 2px;
        background: silver;
        position: absolute;
        margin: 0% 13% auto;
        left: 0;
        right: 0;
        top: 58%;
    }

    .circle-line{
        width: 75px;
        height: 75px;
        border-radius: 50px;    
        box-shadow: 2px 2px 5px silver;
    }

    .aprovado{
        background: white;
        color: #015175;
        border: 3px solid #015175; 
    }
    .reprovado{
        background: white;
        border: 3px solid #a74e4c;
        color: #a74e4c;
    }
    .nao_preenchido{
        background: white;
        border: 3px solid silver;
        color: silver;
    }
    .emelaboracao{
        background: white;
        color: #015175;
        border: 3px solid #015175; 
    }
    .vcenter{
        display: inline-grid;
        align-items: center;
        justify-content: center;
    }

    .btn-xs{
        padding: 0px;
        margin: 5px 0px;
    }

</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Imprimir Relatório</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Imprimir Relatório</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-default">
                
                <div class="card-body">

                    <div class="row" style="min-height: 220px;">  

                        <div class="connecting-line"></div>    
                                            
<!--Elaboracao-->
                        <div class="col-xs-1 col-sm-2 col-md-3 vcenter">
                          <div class="row vcenter">
                              <div class="col-md-12">
                               <span class="info-box-icon circle-line nao_preenchido elaboracao" data-toggle="tooltip" title="Elaboração" data-placement="top"><i class="fa fa-gears"></i></span>
                              </div>
                              
                              <div class="col-md-12" id="elaboracao"> 
                               <span class="badge badge-warning">Em Elaboração</span>
                              </div>
                                <div class="col-md-12" id="correcao"> 
                               <span class="badge badge-warning">Em Retificação</span>
                              </div>
<!--                                   <div class="col-md-12">
                                    <span class="badge badge-warning">Em Análise</span>
                                </div> -->
                            </div>
                        </div>

                        <div class="col-xs-1 col-sm-2 col-md-3 vcenter">
                            <div class="row vcenter" >
                                <div class="col-md-12">
                                    <span class="info-box-icon circle-line nao_preenchido conclusao" data-toggle="tooltip" title="Conclusão" data-placement="top"><i class="fa fa-check"></i></span>
                                </div>
                                <div class="col-md-12">                                                               
                                    <button type="button" name="Concluirrelatorio" id="Concluirrelatorio" type="button" class="btn btn-xs btn-block btn-sm btn-primary">Enviar</button>                                                                
                                </div>
                                <div class="col-md-12" id="aguardandoanalise">
                                    <span class="badge badge-warning">Aguardando Análise</span>
                                </div>
                                <div class="col-md-12" id="aguardandoanaliseFiscal">
                                    <span class="badge badge-warning">Aguardando Análise Técnica</span>
                                </div>
                                <div class="col-md-12" id="aguardandoanaliseResponsavel">
                                    <span class="badge badge-warning">Aguardando Análise Estrutural</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-1 col-sm-4 col-md-3 vcenter" style="background: white;border: 2px solid silver;border-radius: 20px; height: 125px; top: 41px;">
                            <div class="row vcenter" > 
                                 <div class="col-md-12" style="bottom: 35px; min-height: 100px;">
                                    <span class="info-box-icon circle-line nao_preenchido analisetecnica" data-toggle="tooltip" title="Análise Técnica" data-placement="top"><b style="font-size: 13px;">Análise <br>Técnica</b></span>
                                    <button type="button" name="GerarResultadoTecnico" id="GerarResultadoTecnico" class="btn btn-xs btn-block btn-sm btn-primary">Resultado</button>
                                 
                                </div>
                                <div class="col-md-12" style="bottom: 20px;">
                                    <span class="info-box-icon circle-line nao_preenchido analiseestrutural" data-toggle="tooltip" title="Análise Estrutural" data-placement="top"><b style="font-size: 13px;">Análise Estrutural</b></span>
                                  <button type="button" name="GerarResultadoEstrutural" id="GerarResultadoEstrutural" class="btn btn-xs btn-block btn-sm btn-primary">Resultado</button>       
                                
                                      
                                </div> 
                            </div>
                        </div>
<!--Imprimir-->
                        <div class="col-xs-1 col-sm-2 col-md-3 vcenter">
                            <div class="row vcenter">
                                <div class="col-md-12">
                                    <span class="info-box-icon circle-line nao_preenchido impressora" data-toggle="tooltip" title="Aceite" data-placement="top"><i class="fa fa-print"></i></span>
                                </div>
                                <div class="col-md-12">
									<div id="botaoRelatorio"></div>
									<div id="botaoRecibo"></div>
                                </div>
                            </div>  
                        </div>
      
                    </div>	            

                </div> 
            </div>
    <!--Dados Contrato-->       
            <div class="row">  
                <div class="col-md-3">
                    <div class="description-block border-right" style="min-height: 50px;">
                        <b class="description-header"><span class="label_contrato" style="color: gray;"></span>  </b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="description-block border-right" style="min-height: 50px;">
                        <b class="description-header"><span class="label_supervisora" style="color: gray;"></span></b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="description-block border-right" style="min-height: 50px;">
                        <b class="description-header"><span class="label_rp" style="color: gray;"></span> <span class="label_versao" style="color: gray;"></span> </b>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="description-block">
                        <b class="description-header"><span class="label_bruf" style="color: gray;"></span> </b>
                    </div>
                </div>
            </div><br>
<!--Dados do modulo-->
            <div class="card card-default">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableRelatorio" class="table table-striped">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><b>Módulo</b></td>
                                    <td><b>Usuário</b></td>                 
                                    <td><b>Atualização</b></td>   
                                    <td style="width: 10%;"><b>Status</b></td>   
                                </tr>
                            </thead>
                            	
                        </table> 
                    </div>

                </div>

                <div class="card-footer"><!-- <a href="javascript:void(0);" class="btn btn-primary float-right " onClick="finalizarRelatorio();">Enviar Relatório</a> -->
                    <!-- <button type="button" name="Concluirrelatorio" id="Concluirrelatorio" type="button" class="btn btn-xs btn-block btn-sm btn-primary">Concluir</button>  -->    
                </div>   
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="ModalResultadoAnalise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document" style=" width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><h3>Resultado</h3></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="card-body">
                        <div class="box-body">
                                <div class="container-fluid">
                                    <div class="table-responsive" >
                                        <table id="HistoricoAnalise" class="table table-bordered table-striped table-hover " style="width: 100%" >
                                            <thead>
                                                <tr>                                 
                                                    <td style="width: 5%;">#</td>
                                                    <td style="width: 10%;">Módulo</td>
                                                    <td style="width: 30%;">Análise</td>
                                                    <td style="width: 40%;">Referência</td>
                                                    <td style="width: 10%;">Data</td>
                                                    <td style="width: 40%;">Responsável</td>           
                                                </tr>                                                       
                                            </thead>
                                            <tbody></tbody>                                             
                                        </table>         
                                    </div>   
                                    <!-- /.box-body -->
                                </div>
                        </div>
                    </div>    
            </div>
        </div>
    </div>
</div>  
