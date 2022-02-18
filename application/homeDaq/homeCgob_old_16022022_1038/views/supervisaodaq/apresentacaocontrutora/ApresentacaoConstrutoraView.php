<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/apresentacaoconstrutora/apresentacaoconstrutoraView.js'))?>" type="text/javascript"></script>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Apresentação Construtora</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Apresentação Construtora</li>
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
                            <font size="3">Nesta seção devem ser fornecidas, as informações referentes à identificação da obra.
                            </font>
                        </h2>
                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" class="btn btn-block btn-primary" id="abreApresentacao" name="abreApresentacao">Editar</button>
                                </div>
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="fa fa-search"></i> Pesquisar</button>
                                </div>  
                            </div>
                           
                        </div>                  
                    </form>
                </div>
                <div class="card-body">
                    <div id="exibeApresentacaoConstrutora" style="display:none">
                        <div class="row invoice-info">                                        
                            <div class="col-sm-4 invoice-col">
                                <dl>
                                    <dt>Contrato Construção</dt>
                                    <dd><span id="as_contrato" style=" font-size: 30px; font-weight: 600;"></span></dd>
                                    <dt>Empresa</dt>
                                    <dd><span id="as_empresa"></span></dd>
                                    <dt>Processo Administrativo Base</dt>
                                    <dd><span id="as_processo_base"></span></dd>
                                    <dt>Objeto</dt>
                                    <dd><span id="as_objeto"></span></dd>
                                   <!-- <dt>Localização</dt>
                                    <dd><span id="as_localizacao"></span></dd>-->
                                </dl>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <dl>
                                    <dt>Data Base</dt>
                                    <dd><span id="as_data_base"></span></dd>                                   
                                    <dt>Data Publicação da Licitação no DOU</dt>
                                    <dd><span id="as_data_publicacao"></span></dd>
                                    <dt>Data da publicação do resultado da licitação no DOU</dt>
                                    <dd><span id="as_publicacao_DOU"></span></dd>
                                    <dt>Data Assinatura</dt>
                                    <dd><span id="as_data_assinatura"></span></dd>
                                    <dt>Ordem de Inicio Serviços</dt>
                                    <dd><span id="as_ordem_inicial"></span></dd>
                                    <dt>Prazo Inicial de Execução</dt>
                                    <dd><span id="as_prazo_inicial"></span></dd>                                    
                                    <dt>Data Inicial de Término Contrato</dt>
                                    <dd><span id="as_termino_inicial"></span></dd>                                   
                                                                        
                                </dl>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <dl>
                                    <dt>Total dias Aditados</dt>
                                    <dd><span id="as_dias_aditados"></span></dd>
                                    <dt>Total dias Paralisados</dt>
                                    <dd><span id="as_dias_paralisados"></span></dd>
                                    <dt>Data de Término Atualizada</dt>
                                    <dd><span id="as_termino_atualizada"></span></dd>
                                    <dt>Valor a PI do contrato</dt>
                                    <dd>R$ <span id="as_valor_PI"></span></dd>
                                    <dt>Valor Total Aditado do Contrato</dt>
                                    <dd>R$ <span id="as_valor_aditado"></span></dd>
                                    <dt>Valor de Reajuste do Contrato</dt>
                                    <dd>R$ <span id="as_valor_reajuste"></span></dd>
                                    <dt>Valor Atualizado do Contrato(PI+A+R)</dt>
                                    <dd>R$ <span id="as_valor_atualizado"></span></dd>
                                </dl>
                            </div>
                        </div>

                    </div>          

                </div> 
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default" style="min-height: 340px;">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills p-2">
                                <li class="nav-item"><a class="nav-link active" href="#Fiscais" data-toggle="tab">Fiscais</a></li>
                                <li class="nav-item"><a class="nav-link" href="#Aditivos" data-toggle="tab">Aditivos</a></li>
                                <li class="nav-item"><a class="nav-link" href="#Localizacao" data-toggle="tab">Localização</a></li>
                               <!--  <li class="nav-item"><a class="nav-link" href="#ResponsavelTecnico" data-toggle="tab">Responsável Técnico</a></li> -->
                                <li class="nav-item"><a class="nav-link" href="#ParalisacaoReinicio" data-toggle="tab">Paralisação/Reinício</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="Fiscais">
                                <div class="table-responsive">
                                    <table id="tableAsFiscal" class="table table-striped"  style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Unidade Federativa</th>
                                                <th>Nome Fiscal</th>
                                                <th>E-mail</th>
                                                <th>Telefone</th>
                                                <th>Titularidade</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="Aditivos">
                                <div class="table-responsive">
                                    <table id="tableAsAditivo" class="table table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Número do Termo</th>
                                                <th>Data Assinatura</th>
                                                <th>Objeto Termo</th>
                                                <th>Dias Aditados</th>
                                                <th>Valor Aditado</th>
                                                <th>Usuário</th>
                                                <th>Periodo de Referência</th>
                                                <th>Atualização</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-primary" onclick="modalasAditivo()">Incluir Aditivo</button>                                                 
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Localizacao">
                                <div class="table-responsive">
                                    <table id="tableAsLocalizacao" class="table table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Hidrovia</th>
                                                <th>PNV</th>
                                                <!-- <th>Final</th> -->
                                                <th>Extensão</th>
                                                <th>Usuário</th>
                                                <th>Periodo de Referência</th>
                                                <th>Atualização</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-primary" onclick="modalasLocalizacao()">Incluir Localização </button>                                                          
                                    </div>
                                </div>
                            </div>
                     <!--        <div class="tab-pane" id="ResponsavelTecnico">
                                <div class="table-responsive">
                                    <table id="tableAsResponsavelTecnico" class="table table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Nome do Profissional</th>
                                                <th>Nº ART</th>
                                                <th>Forma de Registro</th>
                                                <th>Participação Técnica</th>
                                                <th>Data de Registro</th>
                                                <th>Data da Baixa</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-primary" onclick="modalasResponsavelTecnico()">Incluir Responsável Técnico</button>                                                          
                                    </div>
                                </div>
                            </div> -->
                            <div class="tab-pane" id="ParalisacaoReinicio">
                                    <div class="table-responsive">
                                       <table id="tableAsParalisacaoReinicio" class="table table-striped" style="width: 100%">
                                            <thead>
                                                <tr> 
                                                <th>Documento</th>    
                                                <th>Tipo Documento</th>
                                                <th>Data</th>
                                                <th>Motivação</th>
                                                <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>                               
                                        </table>       
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-block btn-primary" id="btnModalparalisacaoreinicio" name="btnModalparalisacaoreinicio">Incluir</button>                                                          
                                        </div>
                                    </div>
                                    <iframe id="invisible" style="display:none;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- PARALISAÇÃO/REINICIO-->
<div id="ModalasParalisacaoReinicio" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style=" width: 80%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Paralisação/Reinício</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioParalisacaoReinicio" id="formularioParalisacaoReinicio">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo documento</label>
                                <select class="form-control" name="tipo_documento" id="tipo_documento">
                                    <option value="">Selecione</option>
                                    <option value="paralisacao">Ordem de paralisação</option>
                                    <option value="reinicio">Ordem de reinício</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <div class="form-group">
                                <label>Data de Paralisação/Reinício</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <input id="dataparalisacaoreinicio" name="dataparalisacaoreinicio" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                    </div> 
                            </div>
                         </div>     
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Motivação</label>
                                    <textarea rows="8" type="text" id="motivacao_paralisacaoreinicio" name="motivacao_paralisacaoreinicio" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Arquivo </label><small> permitidos: Word/PDF/Excel</small>
                                    <input class="form-control" id="fileUploadParalisacaoReinicio" name="fileUploadParalisacaoReinicio" type="file" accept=".pdf,.docx,.xlsx">
                                    <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btgravaParalisacaoreinicio" name="btgravaParalisacaoreinicio">Salvar</button>
                    </div>
            </div>
           
       

    </div>
</div>

<!-- fim PARALISAÇÃO/REINICIO--> 

<div class="modal fade" id="asApresentacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apresentação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioApresentacao" id="formularioApresentacao">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Contrato</label>
                                <input type="hidden" id="numero_contrato" name="numero_contrato">
                                <input type="text" class="form-control" id="numero_supervisao" name="numero_supervisao" placeholder="Contrato" disabled="">
                            </div>

                            <div class="form-group">
                                <label>Empresa</label>
                                <input type="text" class="form-control" id="empresa_supervisora" name="empresa_supervisora" maxlength='200'placeholder="Empresa">
                            </div>

                            <div class="form-group">
                                <label>Processo Administrativo Base</label>
                                <input type="text" class="form-control" id="num_processo_base" name="num_processo_base" maxlength='100' placeholder="Processo Administrativo Base">
                            </div>

                            <div class="form-group">
                                <label>Objeto</label>
                                <textarea rows="12" cols="50" type="text" id="objeto_contrato" name="objeto_contrato" class="form-control" maxlength='2000' placeholder="Objeto"></textarea>
                            </div>

                        </div>

                        <div class="col-sm-4 invoice-col">
                            <div class="form-group">
                                <label>Data Base</label>

                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_base" name="data_base" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                             <div class="form-group">
                                <label>Data Publicação da Licitação no DOU</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_publicacao_dou" name="data_publicacao_dou" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                            <div class="form-group">
                                <label>Data da publicação do resultado da licitação no DOU</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_resultado_licitacao_dou" name="data_resultado_licitacao_dou" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                            <div class="form-group">
                                <label>Data Assinatura</label>

                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_assinatura" name="data_assinatura" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                            <div class="form-group">
                                <label>Ordem de Inicio Serviços</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="ordem_inicio_servicos" name="ordem_inicio_servicos" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                           
  <!--                           <div class="form-group">
                                <label>Prazo Inicial de Execução</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="prazo_inicial_execucao" name="prazo_inicial_execucao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div> -->
                            <div class="form-group">
                                <label>Prazo Inicial de Execução</label>
                                <input type="number" class="form-control len" id="prazo_inicial_execucao" name="prazo_inicial_execucao" maxlength="5" min="0" max ="10000" placeholder="Prazo Inicial de Execução">
                            </div>
                            <div class="form-group">
                                <label>Data Inicial de Término Contrato</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_inicial_termino" name="data_inicial_termino" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Total dias Aditados</label>
                                <input type="number" class="form-control leng" id="total_dias_aditados" name="total_dias_aditados" maxlength="5" min="0" max ="10000"placeholder="Total dias Aditados">
                            </div>

                            <div class="form-group">
                                <label>Total dias Paralisados</label>
                                <input type="number" class="form-control lengh" id="total_dias_paralisados" name="total_dias_paralisados" maxlength="5" min="0" max ="10000"placeholder="Total dias Paralisados">
                            </div> 
                             <div class="form-group">
                                <label>Data de Término Atualizada</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_termino_atualizada" name="data_termino_atualizada" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>

                            <div class="form-group">
                                <label>Valor a PI do contrato</label>
                                <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                <input type="text" class="form-control" id="valor_pi_contrato" name="valor_pi_contrato" maxlength='20' onkeydown="FormataMoeda(this, 15, event)" onkeypress="return maskKeyPress(event)" placeholder="Valor a PI do contrato">
                            </div>
                        </div>

                            <div class="form-group">
                                 <label>Valor Total Adititado do Contrato</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                               
                                <input type="text" class="form-control" id="valor_total_aditivado_contrato" name="valor_total_aditivado_contrato" maxlength='20' onkeydown="FormataMoeda(this, 15, event)" onkeypress="return maskKeyPress(event)" placeholder="Valor Total Aditivado do Contrato">
                            </div>
                        </div>

                            <div class="form-group">
                                <label>Valor de Reajuste do Contrato</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                <input type="text" class="form-control" id="valor_reajuste_contrato" name="valor_reajuste_contrato" maxlength='20' onkeydown="FormataMoeda(this, 15, event)" onkeypress="return maskKeyPress(event)" placeholder="Valor de Reajuste do Contrato">
                            </div>
                            </div>
                            <div class="form-group">
                                <label>Valor atualizado Contrato(PI+A+R)</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                <input type="text" class="form-control" id="valor_atualizado_contrato" name="valor_atualizado_contrato" maxlength='20' onkeydown="FormataMoeda(this, 15, event)" onkeypress="return maskKeyPress(event)"placeholder="Valor atualizado Contrato(PI+A+R)">
                            </div>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="gravaApresentacao" name="gravaApresentacao">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--MODAIS APRESENTAÇÃO SUPERVISORA E CONSTRUTORA-->
<!--Apresentação-->
<div class="modal fade" id="asApresentacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apresentação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioApresentacao" id="formularioApresentacao">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Contrato</label>
                                <input type="hidden" id="numero_contrato" name="numero_contrato" value="00 00035/2013">
                                <input type="text" class="form-control" id="numero_supervisao" name="numero_supervisao" placeholder="Contrato" disabled="">
                            </div>

                            <div class="form-group">
                                <label>Empresa</label>
                                <input type="text" class="form-control" id="empresa_supervisora" name="empresa_supervisora" placeholder="Empresa">
                            </div>

                            <div class="form-group">
                                <label>Processo Administrativo Base</label>
                                <input type="text" class="form-control" id="num_processo_base" name="num_processo_base" placeholder="Processo Administrativo Base">
                            </div>

                            <div class="form-group">
                                <label>Objeto</label>
                                <textarea rows="12" cols="50" type="text" id="objeto_contrato" name="objeto_contrato" class="form-control" placeholder="Objeto"></textarea>
                            </div>

                        </div>

                        <div class="col-sm-4 invoice-col">
                            <div class="form-group">
                                <label>Data Base</label>

                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_base" name="data_base" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                             <div class="form-group">
                                <label>Data Publicação da Licitação no DOU</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_publicacao_dou" name="data_publicacao_dou" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                            <div class="form-group">
                                <label>Data da publicação do resultado da licitação no DOU</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_resultado_licitacao_dou" name="data_resultado_licitacao_dou" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                            <div class="form-group">
                                <label>Data Assinatura</label>

                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_assinatura" name="data_assinatura" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                            <div class="form-group">
                                <label>Ordem de Inicio Serviços</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="ordem_inicio_servicos" name="ordem_inicio_servicos" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>
                           
                            <div class="form-group">
                                <label>Prazo Inicial de Execução</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="prazo_inicial_execucao" name="prazo_inicial_execucao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>

                            

                            <div class="form-group">
                                <label>Data Inicial de Término Contrato</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_inicial_termino" name="data_inicial_termino" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Total dias Aditados</label>
                                <input type="text" class="form-control" id="total_dias_aditados" name="total_dias_aditados" placeholder="Total dias Aditados">
                            </div>

                            <div class="form-group">
                                <label>Total dias Paralisados</label>
                                <input type="text" class="form-control" id="total_dias_paralisados" name="total_dias_paralisados" placeholder="Total dias Paralisados">
                            </div> 
                             <div class="form-group">
                                <label>Data de Término Atualizada</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_termino_atualizada" name="data_termino_atualizada" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>

                            <div class="form-group">
                                <label>Valor a PI do contrato</label>
                                <input type="text" class="form-control" id="valor_pi_contrato" name="valor_pi_contrato" placeholder="Valor a PI do contrato">
                            </div>

                            <div class="form-group">
                                <label>Valor Total Adititado do Contrato</label>
                                <input type="text" class="form-control" id="valor_total_aditivado_contrato" name="valor_total_aditivado_contrato" placeholder="Valor Total Aditivado do Contrato">
                            </div>

                            <div class="form-group">
                                <label>Valor de Reajuste do Contrato</label>
                                <input type="text" class="form-control" id="valor_reajuste_contrato" name="valor_reajuste_contrato" placeholder="Valor de Reajuste do Contrato">
                            </div>
                            <div class="form-group">
                                <label>Valor atualizado Contrato(PI+A+R)</label>
                                <input type="text" class="form-control" id="valor_atualizado_contrato" name="valor_atualizado_contrato" placeholder="Valor atualizado Contrato(PI+A+R)">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="gravaApresentacao" name="gravaApresentacao">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Aditivo-->
<div id="asAditivo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style=" width: 80%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Termo Aditivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioAditivo" id="formularioAditivo">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Número do Termo</label>
                                <input type="text" class="form-control" id="numero_termo" name="numero_termo" placeholder="Número do Termo">
                            </div>
                            <div class="form-group">
                                <label>Data Assinatura</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_assinatura_ta" name="data_assinatura_ta" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div>                                                        
                            </div> 
                            <div class="form-group">
                                <label>Data Término Atualizada</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_termino_atualizada_ta" name="data_termino_atualizada_ta" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div>                                                        
                            </div>
                            <div class="form-group">
                                <label>Objeto do Termo</label>
                                <textarea rows="8" cols="50" type="text" id="objeto_termo" name="objeto_termo" class="form-control" placeholder="Objeto" ></textarea></div>
                        </div>

                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Dias Aditados</label>
                                    <input type="text" class="form-control" id="dias_aditados_ta" name="dias_aditados_ta" placeholder="Dias Aditados">
                                </div>
                                <div class="form-group">
                                    <!--<input type="text" class="form-control" id="valor_aditado" name="valor_aditado" placeholder="Prazo Inicial">-->
                                    <label>Valor Aditado</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input id="valor_aditado" name="valor_aditado" class="form-control" maxlength='20' onkeydown="FormataMoeda(this, 15, event)" onkeypress="return maskKeyPress(event)" placeholder="Valor Aditado">
                                    </div>
                                </div>                           
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Valor Atualizado</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input id="valor_atualizado_ta" name="valor_atualizado_ta" class="form-control" maxlength='20' onkeydown="FormataMoeda(this, 15, event)" onkeypress="return maskKeyPress(event)" placeholder="Valor Atualizado">
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label>Motivação do Aditivo</label>
                                <textarea rows="8" cols="50" type="text" id="motivacao_aditivo" name="motivacao_aditivo" class="form-control" placeholder="Motivação"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="gravaAditivo()">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!--Fiscal-->
<div id="asFiscal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style=" width: 80%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Fiscal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioFiscal" id="formularioFiscal">
                    <div class="row">                       

                        <div class="col-sm-6">

                            <div class="form-group">
                                <label>Nome Fiscal</label>
                                <input type="text" class="form-control" id="nome_fiscal" name="nome_fiscal" placeholder="Nome Fiscal">
                            </div>

                            <div class="form-group">
                                <label>Email Fiscal</label>
                                <input type="text" class="form-control" id="email_fiscal" name="email_fiscal" placeholder="Email Fiscal">
                            </div>

                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" class="form-control" id="telefone_fiscal" name="telefone_fiscal" placeholder="Telefone">
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control" id="status_fiscal" name="status_fiscal" placeholder="Status Fiscal">
                            </div>

                            <div class="form-group">
                                <label>Data Substituição</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_substituicao_fiscal" name="data_substituicao_fiscal" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div> 
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Unidade Local</label>
                                <select class="form-control" name="unidade_local_fiscal" id="unidade_local_fiscal">
                                    <option value="">Selecione</option>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR">PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Portaria Designação</label>
                                <input type="text" class="form-control" id="portaria_designacao" name="portaria_designacao" placeholder="Portaria Designação">
                            </div>

                            <div class="form-group">
                                <label>Data Portaria</label>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="data_portaria" name="data_portaria" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Titularidade</label>
                                <input type="text" class="form-control" id="titularidade" name="titularidade" placeholder="Titularidade">
                            </div>                        

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="gravaFiscal()">Salvar</button>
            </div>
        </div>

    </div>
</div>
<!--Localização-->
<div id="asLocalizacao" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style=" width: 80%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Localização</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioLocalizacao" id="formularioLocalizacao">
                    <div class="row">                   

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label>Hidrovia</label>
								<select class="form-control" name="hidrovia" id="hidrovia"></select>
                            </div>

                            <div class="form-group">
                                <label>PNV</label>
                                <input type="text" class="form-control" id="pnv_inicial" name="pnv_inicial" placeholder="PNV">
                            </div>

                            <!-- <div class="form-group">
                                <label>PNV Final</label>
                                <input type="text" class="form-control" id="pnv_final" name="pnv_final" placeholder="PNV Final">
                            </div> -->
                           
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Coordenada Inicial</label>
                                <input type="text" class="form-control" id="coordenada_inicial" name="coordenada_inicial" placeholder="Coordenada Inicial">
                            </div>

                            <div class="form-group">
                                <label>Coordenada Final</label>
                                <input type="text" class="form-control" id="coordenada_final" name="coordenada_final" placeholder="Coordenada Final">
                            </div>

                           <!--  <div class="form-group">
                                <label>Km Inicial</label>
                                <input type="text" class="form-control" id="km_inicial" name="km_inicial" placeholder="Km Inicial">
                            </div> -->

                        </div>

                        <div class="col-sm-4">
                           <!--  <div class="form-group">
                                <label>Estaca Inicial</label>
                                <input type="text" class="form-control" id="estaca_inicial" name="estaca_inicial" placeholder="Estaca Inicial">
                            </div>

                            <div class="form-group">
                                <label>Estaca Final</label>
                                <input type="text" class="form-control" id="estaca_final" name="estaca_final" placeholder="Estaca Final">
                            </div> -->

                            <div class="form-group">
                                <label>Município</label>
                                <input type="text" class="form-control" id="km_final" name="km_final" placeholder="Município">
                            </div> 
                             <div class="form-group">
                                <label>Extensão/Área</label>
                                <input type="text" class="form-control" id="extensao" name="extensao" placeholder="Extensão">
                            </div>
                             
                        </div>
                        

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="gravaLocalizacao()">Salvar</button>
            </div>
        </div>

    </div>
</div>
<!--Responsáveis técnicos-->
<!-- <div id="asResponsavelTecnico" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style=" width: 80%;">

       
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Responsável Técnico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioResponsavelTecnico" id="formularioResponsavelTecnico">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Empresa</label>
                                <input type="text" class="form-control" id="empresa_responsavel_tecnico" name="empresa_responsavel_tecnico" placeholder="Empresa">
                            </div>

                            <div class="form-group">
                                <label>Nome do Profissional</label>
                                <input type="text" class="form-control" id="nome_responsavel_tecnico" name="nome_responsavel_tecnico" placeholder="Nome do Profissional">
                            </div>

                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" class="form-control" id="email_responsavel_tecnico" name="email_responsavel_tecnico" placeholder="Email Fiscal">
                            </div>

                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" class="form-control" id="telefone_responsavel_tecnico" name="telefone_responsavel_tecnico" placeholder="Telefone">
                            </div>

                            <div class="form-group">
                                <label>CREA</label>
                                <input type="text" class="form-control" id="CREA_responsavel_tecnico" name="CREA_responsavel_tecnico" placeholder="CREA">
                            </div>

                            <div class="form-group">
                                <label>RNP</label>
                                <input type="text" class="form-control" id="RNP_responsavel_tecnico" name="RNP_responsavel_tecnico" placeholder="RNP">
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Número ART</label>
                                <input type="text" class="form-control" id="n_art_responsavel_tecnico" name="n_art_responsavel_tecnico" placeholder="Número ART">
                            </div>

                            <div class="form-group">
                                <label>UF Registro</label>
                                <select class="form-control" name="uf_registro_responsavel_tecnico" id="uf_registro_responsavel_tecnico">
                                    <option value="">Selecione</option>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR">PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Participação Técnica</label>
                                <input type="text" class="form-control" id="participacao_tecnica_tecnico" name="participacao_tecnica_tecnico" placeholder="Participação Técnica">
                            </div>

                            <div class="form-group">
                                <label>Forma Registro</label>
                                <input type="text" class="form-control" id="forma_registro_responsavel_tecnico" name="forma_registro_responsavel_tecnico" placeholder="Forma Registro">
                            </div>     

                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control" id="status_responsavel_tecnico" name="status_responsavel_tecnico" placeholder="Status">
                            </div>
                            
                            <div class="form-group">
                                <label>Data de Registro</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <input id="dataregistro" name="dataregistro" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                    </div> 
                            </div>
                            <div class="form-group">
                                <label>Data da Baixa</label>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <input id="databaixa" name="databaixa" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                    </div> 
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="gravaResponsavelTecnico()">Salvar</button>
            </div>
        </div>

    </div>
</div> -->
<!--INFORMAÇÃO ADITIVO-->
<div id="modalObjetoMotivacaoAditivo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informações Aditivo</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Objeto do Termo</label>
                        <div class="table-responsive">
                            <p id="objeto_modal" style="text-align: justify"></p>
                        </div>   
                    </div>
                    <div class="col-md-6">
                        <label>Motivação do Aditivo</label>
                        <div class="table-responsive">
                            <p id="motivacao_modal" style="text-align: justify"></p>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!--MODAIS APRESENTAÇÃO SUPERVISORA E CONSTRUTORA FIM-->
<div id="modalConclusaoGeral" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Solucionar Registro de Não Conformidade</h4>
            </div>
            <div class="modal-body">
                <form method="post" name="formSolucaoRnc" id="formSolucaoRnc">                 
                    <input type="hidden" id="id_resumo" name="id_resumo">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Anexo</label>
                                <input type="file" id="fileUpload" accept=".PDF" multiple="" onchange="confereArquivos()" class="form-group">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-primary" id="btnInsereAnexoConclusaoGeral" name="btnInsereAnexoConclusaoGeral">Salvar</button>
                        </div>
                        <div class="col-md-1">
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <table id="tableAnexoConclusao" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td width="20%">Anexo</td>
                                            <td width="20%">Usuário</td>
                                            <td width="20%">Atualização</td>
                                            <td width="9%">Ações</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>                               
                                </table>     
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <script type="text/javascript">
            var max = document.querySelector(".len");
            var maxx = document.querySelector(".leng");
            var maxxx = document.querySelector(".lengh");
            var x = maxNumber(10000);
            max.addEventListener('keyup', x);
            max.addEventListener('blur', x);
            maxx.addEventListener('keyup', x);
            maxx.addEventListener('blur', x);
            maxxx.addEventListener('keyup', x);
            maxxx.addEventListener('blur', x);

            function maxNumber(max){
                var running = false;
                return function () {
                    if (running) return;
                    running = true;
                    if (parseFloat(this.value) > max) {
                        this.value = 10000;
                    }
                    running = false;
                };
            }
            </script>
            </div>
        </div>
    </div>
</div>
        
    </section>
    <!-- /.content -->
</div>
