<!-- PAGINA TROCA DE NOME PARA GARANTIAS E SEGUROS EM 25/04/2019 -->
<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/garantiascontratuais/garantiascontratuaisView.js')) ?>" type="text/javascript"></script>  	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestão Jurídica,Garantias e Seguros</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Gestão Jurídica,Garantias e Seguros</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h2>
                        <font size="3">
                       Neste item devem ser tratados os termos das Garantias contratuais (Apólice/Endosso de Seguro, caução ou fiança) e,
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                        <div class='mostrar'> 
                        se aplicável ao contrato, as demais “Garantias do Empreendimento”, tais como Apólices/Endossos de Seguro Risco Engenharia, Responsabilidade Civil e Responsabilidade Profissional, tanto para os contratos de Supervisão quanto para os supervisionados/gerenciados. ​

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
                       
                        <!--<div class="col-xs-12 col-md-3">
                            <div>
                                <button type="button" name="btnNoAtividade" id="btnNoAtividade" class="btn btn-block btn-info">Não houve atividade no mês</button>
                            </div>
                        </div>-->
                    </div>                
                </div>

                <div class="card-body">
                    <div class="row" id="novo_garantiacontratual">
                        <div class="col-md-12 table-responsive">
                            <table id="tableGarantiaContratual" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Guia</th>
                                        <th>Tipo de Garantia</th>
                                        <th>Processo</th>
                                        <th>Valor</th>
                                        <th>Início de Vigência</th> 
                                        <th>Término de Vigência</th> 
                                        <th>Data de Emissão</th> 
                                        <th>Observação</th> 
                                        <th>Situação</th> 
                                        <th>Providência</th> 
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

                    <div class="row" id="cadastroGarantiaContratual">
                        <form method="post" class="submitAjax" name="formularioGarantiasContratuais" id="formularioGarantiasContratuais">
                            <div class="row">
                                <div class="col-12 col-md-4 ">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Guia</label>
                                                <input id="guia" name="guia" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Processo</label>
                                                <input id="processo" name="processo" class="form-control" type="text">
                                            </div> 
                                        </div>  
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Tipo de Garantia</label>
                                                <select class="form-control" name="tipo_garantia" id="tipo_garantia">
                                                    <option value="1">teste</option>
                                                </select>
                                            </div> 
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Valor da Garantia</label>
                                                <div class="input-group date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">R$</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="valor_garantia" name="valor_garantia" maxlength='20' onkeydown="FormataMoeda(this, 15, event)" onkeypress="return maskKeyPress(event)" placeholder="Valor Inicial">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Início de Vigência</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="inicio_vigencia" name="inicio_vigencia" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <label>Término de Vigência</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="termino_vigencia" name="termino_vigencia" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Instituição Financeira/Seguradora</label>
                                                <input id="financeira_seguradora" name="financeira_seguradora" class="form-control" type="text">
                                            </div> 
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Número da Apólice</label>
                                                <input id="numero_apolice" name="numero_apolice" class="form-control" type="text">
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <label>Data emissão</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="data_emissao" name="data_emissao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-12 col-md-8" style="border-left: 1px solid #f4f6f9;">
                                    <div class="form-group">
                                        <label>Objeto</label>
                                        <textarea id="objeto" name="objeto" rows="5" style="min-width: 100%"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Observação</label>
                                        <textarea id="observacao" name="observacao" rows="5" style="min-width: 100%"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-block btn-primary" id="insereGarantiaContratual" name="insereGarantiaContratual">Salvar</button>  
                        </div> 
                    </div>          
                </div> 
            </div>
        </div>
    </section>
</div>
<div id="descricaoObservacaoObjeto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Observação / Objeto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Observação</label>
                        <div class="table-responsive">
                            <p id="garantia_contratual_observacao_modal" style="text-align: justify"></p>
                        </div>   
                    </div>
                    <div class="col-md-6">
                        <label>Objeto</label>
                        <div class="table-responsive">
                            <p id="garantia_contratual_objeto_modal" style="text-align: justify"></p>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal Situação-->
<div id="modalSituacao" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Providência</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioProvidencia" id="formularioProvidencia">
                    <input type="hidden" id="id_garantia_seguro" name="id_garantia_seguro">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="situacao_garantia_seguro" name="situacao_garantia_seguro" >
                                <option value="">Selecione</option>
                                <option value="Aberto">Aberto</option>
                                <option value="Fechado">Fechado</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">  
                                <label>Providência</label>
                                <textarea id="providencia" name="providencia" rows="5" style="min-width: 100%"></textarea>                                                          
                            </div>  
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-primary" id="insereProvidencia" name="insereProvidencia">Salvar</button>
                        </div>
                        <div class="col-md-1">
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <table id="tableProvidenciaGarantiaSeguro" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Providência</th>
                                            <th>Ação</th>   
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
        </div>
    </div>
</div>

<!--Modal Anexo-->
<div id="modalAnexo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Anexos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" name="formularioAnexo" id="formularioAnexo">
                    <input type="hidden" id="id_garantia_seguro_anexo" name="id_garantia_seguro_anexo">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Arquivo</label><small> permitidos: Word/PDF/Excel </small>
                                <input class="form-control" type="file" id="fileUpload" name="arquivo" accept=".pdf,.docx,.xlsx">
                                 <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <table id="tableAnexoGarantiaSeguro" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Anexo</th>
                                            <th>Usuário</th>
                                            <th>Atualização</th>
                                            <th>Ação</th>   
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
        </div>
    </div>
    <iframe id="invisible" style="display:none;"></iframe>
</div>
