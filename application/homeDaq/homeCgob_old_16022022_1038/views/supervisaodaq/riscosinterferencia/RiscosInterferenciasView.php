<script src="<?php echo(base_url("application/homeDaq/homeCgob/assets/js/supervisaodaq/riscosinterferencias/riscosinterferenciasView.js")) ?>" type="text/javascript"></script>	
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Riscos e Interferências</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Riscos e Interferências</li>
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
                            Deve ser realizada a gestão de toda e qualquer situação que possa impactar a execução da obra, tais como desapropriações, 
                            restrições ambientais, interferências com serviços públicos, necessidade de revisão de projeto, restrição financeira, 
                            diminuição do ritmo/paralisação unilateral das obras por parte da Construtora, patologias precoces no pavimento, entre outros.
								<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                Resumo: informar, de forma clara e concisa, os impactos e principais tratativas referentes às interferências. 
                                Realizar análise crítica quanto à relevância das interferências no atendimento ao término contratual. 
                                Descrever a situação atual do risco, com quais ações já foram tomadas até o momento para minimizar/sanar o risco.<br>
                                As informações deverão ser apresentadas nos relatórios de acompanhamento, 
                                até o Relatório do mês de referência em que foram classificadas como sanadas ou mitigadas/não ocorridas.
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
                          
                            <div class="col-xs-12 col-md-2">
                                <div>
                                    <button type="button" name="btnNoAtividade" id="btnNoAtividade" class="btn btn-block btn-info">Não houve atividade no mês</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="nova_interferencia" style="display: none">
                        <div class="col-md-12 table-responsive" >
                            <table id="tableInterferencia" class="table table-striped">
                                <thead>
                                    <tr> 
                                        <th>#</th>
                                        <th>Tipo</th>
                                        <th>Grau de Impacto</th>
                                        <th>Classificação</th>
                                        <th>Eixo</th>
                                        <th>Hidrovia</th>
                                        <th>km inicial </th>
                                        <th>km final</th>
                                        <th>Previsão Solução</th>
                                        <th>Data Limite</th>
                                        <th>Descrição/Providência</th>
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

<script type="text/javascript">

        jQuery(function($) {
      $(document).on('keypress', 'input.only-number', function(e) {
        var $this = $(this);
        var key = (window.event)?event.keyCode:e.which;
        
        var km = $this.data('accept-comma');
        
        var maskm = (typeof km !== 'undefined' && (km == true || km == 1)?true:false);

            if((key > 47 && key < 58)
          
          || (key == 44 && maskm)) {
            return true;
        } else {
                return (key == 8 || key == 0)?true:false;
            }
      });
    });
</script>
                    <div id="cadastroInterferencia" style="display: none">
                        <form method="post" class="submitAjax" name="formularioInterferencia" id="formularioInterferencia">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Assunto</label>
                                                <input id="descricao" name="descricao" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Tipo</label>
                                                <select class="form-control" name="tipoInterferencia" id="tipoInterferencia"></select>
                                            </div> 
                                        </div>

                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Classificação</label>
                                                <select class="form-control" name="classificacao" id="classificacao">
                                                </select>
                                            </div> 
                                        </div>     
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Grau de Impacto  <b class="description-header" style="font-size: 15px;"><span class="label_grau_impacto" style="font-size: 15px;"></span></b></i></label>      
                                                <select class="form-control" name="grauImpacto" id="grauImpacto">
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Hidrovia</label>
                                                <input id="br" name="br" class="form-control" type="text">
                                            </div> 
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Efeito</label>
                                                <select class="form-control" name="efeito" id="efeito">
                                                    <option value="">Selecione</option>
                                                    <option value="Positivo">Positivo</option>
                                                    <option value="Negativo">Negativo</option>
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Tipo de Eixo</label>
                                                <select class="form-control" name="tipoEixo" id="tipoEixo">
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Km Inicial</label>
                                                <input id="kmInicial"  Placeholder="" name="kmInicial" maxlength="8" data-accept-comma="1" class="form-control only-number" type="text">
                                            </div> 
                                        </div>
                                      
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Km Final</label>
                                                <input id="kmFinal" Placeholder="" name="kmFinal" maxlength="8" data-accept-comma="1" class="form-control only-number" type="text">
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <label>Previsão da Solução</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="previsaoSolucao" name="previsaoSolucao" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <label>Data Limite</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="dataLimite" name="dataLimite" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Impacto de Custo</label>
                                                <select id="impactoCusto" name="impactoCusto" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Sim</option>
                                                    <option value="0">Não</option>
                                                </select>       
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Impacto de Prazo</label>
                                                <select id="impactoPrazo" name="impactoPrazo" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Sim</option>
                                                    <option value="0">Não</option>
                                                </select>     
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Resumo</label>
                                                 <textarea id="resumoInterferencias" name="resumoInterferencias" rows="2" style="min-width: 100%"></textarea>   
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                 <label>Providência</label>
                                                 <textarea id="providencia" name="providencia" rows="2" style="min-width: 100%"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </form>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-block btn-primary" id="insereInterferencia" name="insereInterferencia">Salvar</button>  
                        </div>  
                    </div>
                        <div class="row" id="naohouveatividademes">
                            <div class="col-md-12 table-responsive">
                                <table id="tableNaohouveAtividadeMes" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Atividade</th>
                                            <th>Usuário</th>
                                            <th>Atualização</th> 
                                            <th>Ações</th>   
                                        </tr>
                                    </thead>
                                    <tbody></tbody>                              
                                </table>       
                            </div>                        
                        </div>
                </div>

                 <!-- editar -->
                   
                    <div  id="EditarcadastroInterferencia" style="display: none">
                        <hr> 
                       <div  class="card-body">
                        <form method="post" class="submitAjax" name="formularioInterferenciaEditar" id="formularioInterferenciaEditar">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Assunto</label>
                                                <input id="descricaoEditar" name="descricaoEditar" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Tipo</label>
                                                <select class="form-control" name="tipoInterferenciaEditar" id="tipoInterferenciaEditar"></select>
                                            </div> 
                                        </div>

                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Classificação</label>
                                                <select class="form-control" name="classificacaoEditar" id="classificacaoEditar">
                                                </select>
                                            </div> 
                                        </div>     
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Grau de Impacto  <b class="description-header" style="font-size: 15px;"><span class="label_grau_impacto_editar" style="font-size: 15px;"></span></b></i></label>      
                                                <select class="form-control" name="grauImpactoEditar" id="grauImpactoEditar">
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Hidrovia</label>
                                                <input id="brEditar" name="brEditar" class="form-control" type="text">
                                            </div> 
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Efeito</label>
                                                <select class="form-control" name="efeitoEditar" id="efeitoEditar">
                                                    <option value="">Selecione</option>
                                                    <option value="Positivo">Positivo</option>
                                                    <option value="Negativo">Negativo</option>
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Tipo de Eixo</label>
                                                <select class="form-control" name="tipoEixoEditar" id="tipoEixoEditar">
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Km Inicial</label>
                                                <input id="kmInicialEditar" name="kmInicialEditar" maxlength="9" onkeydown="FormataMoeda(this, 7, event)" onkeypress="return maskKeyPress(event)" class="form-control" type="text">
                                            </div> 
                                        </div>
                                          
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                <label>Km Final</label>
                                                <input id="kmFinalEditar" name="kmFinalEditar" maxlength="9" onkeydown="FormataMoeda(this, 7, event)" onkeypress="return maskKeyPress(event)" class="form-control" type="text">
                                            </div> 
                                        </div>
                                              
                                        <div class="col-md-6">
                                            <label>Previsão da Solução</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="previsaoSolucaoEditar" name="previsaoSolucaoEditar" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <label>Data Limite</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="dataLimiteEditar" name="dataLimiteEditar" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Impacto de Custo</label>
                                                <select id="impactoCustoEditar" name="impactoCustoEditar" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Sim</option>
                                                    <option value="0">Não</option>
                                                </select>       
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Impacto de Prazo</label>
                                                <select id="impactoPrazoEditar" name="impactoPrazoEditar" class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="1">Sim</option>
                                                    <option value="0">Não</option>
                                                </select>     
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Resumo</label>
                                                 <textarea id="resumoInterferenciasEditar" name="resumoInterferenciasEditar" rows="2" style="min-width: 100%"></textarea>   
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                 <label>Providência</label>
                                                 <textarea id="providenciaEditar" name="providenciaEditar" rows="2" style="min-width: 100%"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                               
                            </div>
                        </form>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-block btn-primary" id="editarInterferencia" name="editarInterferencia">Editar</button>  
                            <input id="idEditar" name="idEditar" type="hidden">
                        </div>
                       </div>
                    </div>                
                    
                    <!-- fim editar -->
            </div> 
        </div>
    </section>
</div>

<div id="solucionarInterferencia" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Solucionar Interferência</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" name="formProvidenciaInterferencia" id="formProvidenciaInterferencia">
                    <div class="row">  
                        <input type="hidden" id="id_interferenciaModal">
                        <!--<div class="col-md-4">
                            <div class="form-group">
                                <span class='badge badge-success' style='border-radius: 50px; box-shadow: 1px 3px 7px #545454;' data-toggle='tooltip' title='Concluído' data-placement='top'><i class='fa fa-check'></i></span> <label id="statusProvidencia"></label>
                            </div>
                        </div>-->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Providência</label>
                                <textarea id="providenciaInterferencia" name="providenciaInterferencia" rows="5" style="min-width: 100%"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" id="btnInsereSolucaoInterferencia" onclick="insereProvidencia();">Salvar</button>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <table id="tableProvidencias" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <td style="width: 80%">Descrição</td>
                                            <td>Ação</td>
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

<div id="descricaoInterferencia" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Descrição</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <font id="descricaoInterferencia_modal"></font>
            </div>
        </div>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Providência</h4>                
            </div>
            <div class="modal-body">
                <font id="providenciaInterferencia_modal"></font>
            </div>
        </div>
    </div>
</div>

