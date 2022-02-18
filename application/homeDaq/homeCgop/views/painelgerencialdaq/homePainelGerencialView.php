<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgop/assets/css/painelgerencial.css')) ?>">
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/painelgerencial/painelgerencial.js')) ?>"
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/relatorio/relatorioView.js'))?>" type="text/javascript"></script>
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

<input type="hidden" id="id_contrato_obra" value="" name="id_contrato_obra">
<div oncontextmenu="return false">
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-md-2">
                        <div class="form-group">
                            <select class="form-control" name="uf_filtro" id="uf_filtro"">
                            <option value="Todos">UF</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="contrato_filtro" id="contrato_filtro">
                                <option value="">Contrato</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="content-wrapper" style="margin-left: 0px; padding-top: 0px !important;" id="dadosContratos">

    <!-- Main content -->
    <section class="content" style=" top: 10px; position: relative;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills p-2">
                                <li class="nav-item"><a class="nav-link active show" href="#tab_obra" data-toggle="tab">Obra</a>
                                </li>
                                <li class="nav-item"><a id="painel_supervisao" class="nav-link" href="#tab_supervisao"
                                                        data-toggle="tab">Supervisão</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tab_obra">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 border-right">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5>
														<span class="pull-right badge badge-success"
                                                              id="statusObra"></span>
                                                    </h5>
                                                    <h2 id="nu_con_formatado"></h2>
                                                </div>
                                                <div class="col-12 border-bottom">
                                                    <dl>
                                                        <dd>
                                                            <small>Contratada - Obra</small>
                                                        </dd>
                                                        <dt id="no_empresa"></dt>
                                                    </dl>
                                                </div>
                                                <div class="col-12 border-bottom">
                                                    <dl>
                                                        <dd>
                                                            <small>Município/UF</small>
                                                        </dd>
                                                        <dt id="municipioUf"></dt>
                                                    </dl>
                                                </div>
                                                <div class="col-12 border-bottom">
                                                    <dl>
                                                        <dd>
                                                            <small>Hidrovia</small>
                                                        </dd>
                                                        <dt id="hidrovia"></dt>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-9">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <small>Objeto do Contrato</small>
                                                    <br>
                                                    <b id="objetivo_contrato"></b>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Modalidade da licitação /Regime de Execução</small>
                                                    <br>
                                                    <b id="modalidade"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Número do Edital</small>
                                                    <br>
                                                    <b id="nu_edital"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Mês Base</small>
                                                    <br>
                                                    <b id="mesBase"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Tipo de Intervenção</small>
                                                    <br>
                                                    <b id="tipoIntervencao"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Assinatura</small>
                                                    <br>
                                                    <b id="assinatura"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Ordem de Início</small>
                                                    <br>
                                                    <b id="ordemInicio"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Dias Paralisados</small>
                                                    <br>
                                                    <b id="diasParalisados"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Dias Aditados</small>
                                                    <br>
                                                    <b id="diasAditados"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Data de Término dos Serviços</small>
                                                    <br>
                                                    <b id="dataTerminoServico"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Data de Término de Vigência</small>
                                                    <br>
                                                    <b id="dataTerminoVigencia"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Dias a Vencer</small>
                                                    <br>
                                                    <b id="diasVencer"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Unidade Fiscalizadora</small>
                                                    <br>
                                                    <b id="unidadeFiscalizadora"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Fiscal</small>
                                                    <br>
                                                    <b id="fiscal"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>E-mail</small>
                                                    <br>
                                                    <b id="email"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Telefone</small>
                                                    <br>
                                                    <b id="telefone"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>PBA</small>
                                                    <br>
                                                    <b id="pba"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>PBAI</small>
                                                    <br>
                                                    <b id="pbai"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <small>Supervisão</small>
                                                    <br>
                                                    <b id="supervisao"></b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Aba Interna -->
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Custom Tabs -->
                                            <div class="card" style="background-color: #f4f6f9;">
                                                <div class="card-header d-flex p-0">
                                                    <ul class="nav nav-pills p-2">
                                                        <li class="nav-item"><a class="nav-link active"
                                                                                href="#obra_resumo" data-toggle="tab">Resumo</a>
                                                        </li>
                                                        <li class="nav-item"><a id="painel_obra_aditivos"
                                                                                class="nav-link" href="#obra_aditivos"
                                                                                data-toggle="tab">Aditivos</a></li>
                                                        <li class="nav-item"><a id="painel_obra_ambiental"
                                                                                class="nav-link" href="#obra_ambiental"
                                                                                data-toggle="tab">Ambiental</a></li>
                                                        <li class="nav-item"><a id="painel_obra_interferencias"
                                                                                class="nav-link"
                                                                                href="#obra_interferencias"
																				data-toggle="tab">Interferências</a></li>
                                                        <li class="nav-item"><a id="painel_obra_fotos" class="nav-link"
                                                                                href="#obra_fotos" data-toggle="tab">Fotos</a>
                                                        </li>
                                                        <li class="nav-item"><a id="painel_obra_relatorio" class="nav-link"
                                                                                href="#obra_relatorio" data-toggle="tab">Relatório</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="card-body">
                                                    <div class="tab-content">
                                                        <!-- TAB Resumo -->
                                                        <div class="tab-pane active" id="obra_resumo">

                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="min-height: 540px;">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">
                                                                                <i class="fa fa-dollar"></i>
                                                                                Financeiro
                                                                            </h3>
                                                                        </div>

                                                                        <div class="card-body" style="font-size: 12px;">
                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor PI </span><br>
                                                                                            <b id="valor_pi"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Aditivos</span><br>
                                                                                            <b id="aditivos"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Reajustamento</span><br>
                                                                                            <b id="reajustamento"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor Total</span><br>
                                                                                            <b id="valor_total"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Total Medido (PI + A) </span><br>
                                                                                            <b id="total_medido"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Total Medido (PI + A + R) </span><span
                                                                                                    class="legMedidoPiRA"></span><br>
                                                                                            <b id="total_medido_piar"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor a Medir </span><span
                                                                                                    class="legValorAMedir"></span><br>
                                                                                            <b id="valor_medir"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
																							<span>Total Empenhado <span
                                                                                                        class="legEmpenhar"></span></span><br>
                                                                                            <b id="total_empenhado"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Saldo de Empenho</span><br>
                                                                                            <b id="saldo_empenhado"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>A Empenhar</span><br>
                                                                                            <b id="a_empenhar"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-8" style="display: block">
                                                                                    <div id="grafico_obra_dados_financeiros"
                                                                                         style="margin: 0 auto;  max-width: 400px;  min-width: 380px;"
                                                                                         data-highcharts-chart="0">
                                                                                        <figure class="highcharts-figure">
                                                                                            <div id="graficoFinanceiro"></div>
                                                                                        </figure>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="min-height: 540px;">
                                                                        <div class="card-header"
                                                                             style="padding: 10px 0px 10px 20px;">
                                                                            <h3 class="card-title">
                                                                                <i class="fa fa-bar-chart-o"></i>
                                                                                CURVA 'S'
                                                                                <div class="col-md-1 pull-right"
                                                                                     title="Cronograma Financeiro"><a
                                                                                            href="javascript:void(0);"
                                                                                            onclick="PainelFinanceiro();"><img
                                                                                                src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/icones/item2.png'))?>"
                                                                                                alt=""
                                                                                                data-toggle="tooltip"
                                                                                                title="Cronograma Financeiro"
                                                                                                data-placement="top"
                                                                                                height="32" width="32"
                                                                                                data-original-title="Cronograma Financeiro"></a>
                                                                                </div>
                                                                                <div class="col-md-1 pull-right"
                                                                                     title="Cronograma Físico"><a
                                                                                            href="javascript:void(0);"
                                                                                            onclick="PainelFisico();"><img
                                                                                                src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/icones/item1.png'))?>"
                                                                                                alt=""
                                                                                                data-toggle="tooltip"
                                                                                                title="Cronograma Físico"
                                                                                                data-placement="top"
                                                                                                height="32" width="32"
                                                                                                data-original-title="Cronograma Físico"></a>
                                                                                </div>
                                                                                <div class="col-md-1 pull-right"
                                                                                     title="Empenho"><a
                                                                                            href="javascript:void(0);"
                                                                                            onclick="PainelEmpenhoRAP();"><img
                                                                                                src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/icones/item3.png'))?>"
                                                                                                alt=""
                                                                                                data-toggle="tooltip"
                                                                                                title="Empenho/RAP"
                                                                                                data-placement="top"
                                                                                                height="32" width="32"
                                                                                                data-original-title="Empenho/RAP"></a>
                                                                                </div>
                                                                                <div class="col-md-1 pull-right"><a
                                                                                            href="javascript:void(0);"
                                                                                            onclick="PainelMedicao();"><img
                                                                                                src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/icones/item5.png'))?>"
                                                                                                alt=""
                                                                                                data-toggle="tooltip"
                                                                                                title="Medição"
                                                                                                data-placement="top"
                                                                                                height="32" width="32"
                                                                                                data-original-title="Medição"></a>
                                                                                </div>
                                                                                <div class="col-md-1 pull-right"><a
                                                                                            href="javascript:void(0);"
                                                                                            onclick="PainelIDFin();"><img
                                                                                                src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/icones/item4.png'))?>"
                                                                                                alt=""
                                                                                                data-toggle="tooltip"
                                                                                                title="IDFIN"
                                                                                                data-placement="top"
                                                                                                height="32" width="32"
                                                                                                data-original-title="IDFIN"></a>
                                                                                </div>
                                                                            </h3>
                                                                        </div>
                                                                        <div class="card-body" style="display: block">
                                                                            <figure class="highcharts-figure">
                                                                                <div id="grafico_obra_curva_s"></div>
                                                                            </figure>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <!--<div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-xs-12 col-sm-12 col-md-12">

                                                                            <div class="card card-default">
                                                                                <div class="card-header"
                                                                                     style="padding: 10px 10px 0px 20px">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <h3 class="card-title">
                                                                                                <i class="fa fa-ship"></i>
                                                                                                Operação
                                                                                            </h3>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <select class="form-control"
                                                                                                    name="hidrovia_obra_filtro"
                                                                                                    id="hidrovia_obra_filtro">
                                                                                                <option value="1"
                                                                                                        selected="selected">
                                                                                                    Canal de Navegação
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="pull-right">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="card-body"
                                                                                     style="height: 300px; overflow-y: auto;">
                                                                                    <div id="painelHidrovia"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-xs-12 col-sm-12 col-md-12">

                                                                            <div class="card card-default">
                                                                                <div class="card-header"
                                                                                     style="padding: 10px 10px 0px 20px">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <h3 class="card-title">
                                                                                                <i class="fa fa-ship"></i>
                                                                                                Status de Operação
                                                                                            </h3>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="pull-right">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <?php if( ($id_perfil==5)  or ($id_perfil==9)){  ?>
                                                                                            <table id="tableGeorreferenciamento" class="table table-striped" style="width: 100%">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="width: 5px;">Nome da Infraestrutura</th>
                                                                                                        <th style="width: 5px;">Tipo</th>
                                                                                                        <th style="width: 25px;">Definir Tipo</th>
                                                                                                        <th style="width: 25px;">Status</th>                                                                                                        
                                                                                                        <th style="width: 25px;">Definir Status</th>
                                                                                                        <th style="width: 25px;">Status Fábrica de Gelo</th>
                                                                                                        <th style="width: 25px;">Definir Status Fábrica de Gelo</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody style="font-size: 12px"></tbody>                               
                                                                                            </table>
                                                                                            <?php }else{ ?>
                                                                                            <table id="tableGeorreferenciamentoUserComum" class="table table-striped" style="width: 100%">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="width: 5px;">Nome da Infraestrutura</th>
                                                                                                        <th style="width: 5px;">Tipo</th>
                                                                                                        <th style="width: 25px;">Status</th>                                                                                                        
                                                                                                        <th style="width: 25px;">Status Fábrica de Gelo</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody style="font-size: 12px"></tbody>                               
                                                                                            </table>
                                                                                            <?php } ?>
                                                                                        </div>                  
                                                                                    </div>
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <div class="card card-default">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">
                                                                                <i class="fa fa-file-text-o"></i>
                                                                                Resumo
                                                                                <small class="pull-right text-muted"><i
                                                                                        class="fa fa-clock-o"
                                                                                        id="dataResumo"></i></small>
                                                                                <?php if( ($id_perfil==5)  or ($id_perfil==9)){  ?>
                                                                                <div class="col-md-1 pull-right"
                                                                                     title="Inserir Resumo"><a
                                                                                        href="javascript:void(0);"
                                                                                        onclick="inserirResumo();">
                                                                                        <i class="fa fa-pencil"
                                                                                           style="color: #0c0c0c"
                                                                                           id="dataResumo"></i></a>
                                                                                </div>
                                                                                <?php } ?>
                                                                                                                                                                
                                                                            </h3>
                                                                        </div>
                                                                        <div class="card-body"
                                                                             style="height: 300px; overflow-y: auto; font-size: 12px;"
                                                                             id="resumo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- TAB Aditivos -->
                                                        <div class="tab-pane" id="obra_aditivos">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="min-height: 540px; ">
                                                                        <div class="card-body">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor PI </span><br>
                                                                                            <b id="obra_valor_pi"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Aditivos</span><br>
                                                                                            <b id="obra_valor_aditivos"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Reajustamento</span><br>
                                                                                            <b id="obra_reajustamento"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor Total</span><br>
                                                                                            <b id="obra_valor_total"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-10">
                                                                                    <figure class="highcharts-figure">
                                                                                        <div id="ObraAditivoPizza"></div>
                                                                                    </figure>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="height: 540px;overflow-y: auto; font-size:14px;">
                                                                        <div class="card-body">

                                                                            <table id="tableObraAditivo" class="table table-striped" style="width: 100%">
                                                                                <thead>
                                                                                    <tr role="row">
                                                                                        <th>Nº</th>
                                                                                        <th>Data Assinatura</th>
                                                                                        <th>Objeto</th>
                                                                                        <th>Impacto Financeiro</th>
                                                                                        <th>Dias Prorrogados</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- TAB Ambiental -->
                                                        <div class="tab-pane" id="obra_ambiental">
                                                            <div class="card card-default"
                                                                 style="min-height: 540px; font-size:14px;">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 table-responsive"
                                                                             id="tableObraAmbiental">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- TAB Interferências -->
                                                        <div class="tab-pane" id="obra_interferencias">
                                                            <div class="card card-default"
                                                                 style="min-height: 540px; font-size:14px;">
                                                                <div class="card-body">
                                                                    <div class="table-responsive"
                                                                         id="tableObraInterferencias">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- TAB Fotos -->
                                                        <div class="tab-pane" id="obra_fotos">
                                                            <div class="row" id="periodoFotos">
                                                            </div>
                                                        </div>
														<!-- TAB Relatorio -->
														<div class="tab-pane" id="obra_relatorio">
															<div class="form-group col-md-1">
																<h5 class="text-sm text-black">Período de referência</h5>
																<input type="text" name="datepicker" id="datepicker" class="form-control">
															</div>
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




														</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Aba Interna -->

                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_supervisao">

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 border-right">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5>
														<span class="pull-right badge badge-success"
                                                              id="statusSupervisao"></span></h5>
                                                    <h2 id="sup_contrato"></h2>
                                                </div>
                                                <div class="col-12 border-bottom">
                                                    <dl>
                                                        <dd>
                                                            <small>Supervisão</small>
                                                        </dd>
                                                        <dt id="supervisao_nome"></dt>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-9">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <small>Objeto do Contrato</small>
                                                    <br>
                                                    <b id="sup_objetivo"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Modalidade da licitação /Regime de Execução</small>
                                                    <br>
                                                    <b id="sup_regime"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Número do Edital</small>
                                                    <br>
                                                    <b id="sup_edital"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Mês Base</small>
                                                    <br>
                                                    <b id="sup_mesBase"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Tipo de Intervenção</small>
                                                    <br>
                                                    <b id="sup_tp_intervencao"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Assinatura</small>
                                                    <br>
                                                    <b id="sup_assinatura"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Ordem de Início</small>
                                                    <br>
                                                    <b id="sup_ordem_inicio"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Dias Paralisados</small>
                                                    <br>
                                                    <b id="sup_dias_paralisados"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Dias Aditados</small>
                                                    <br>
                                                    <b id="sup_dias_aditados"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Data de Término dos Serviços</small>
                                                    <br>
                                                    <b id="sup_data_termino_servico"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Data de Término de Vigência</small>
                                                    <br>
                                                    <b id="sup_data_termino_vigencia"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Dias a Vencer</small>
                                                    <br>
                                                    <b id="sup_dias_vencer"></b>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Unidade Fiscalizadora</small>
                                                    <br>
                                                    <b id="sup_unidade_fiscalizadora"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Fiscal</small>
                                                    <br>
                                                    <b id="sup_fiscal"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>E-mail</small>
                                                    <br>
                                                    <b id="sup_email"></b>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <small>Telefone</small>
                                                    <br>
                                                    <b id="sup_telefone"></b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Custom Tabs -->
                                            <div class="card" style="background-color: #f4f6f9;">
                                                <div class="card-header d-flex p-0">
                                                    <ul class="nav nav-pills p-2">
                                                        <li class="nav-item"><a class="nav-link active"
                                                                                href="#superv_resumo" data-toggle="tab">Resumo</a>
                                                        </li>
                                                        <li class="nav-item"><a id="painel_superv_aditivos"
                                                                                class="nav-link" href="#superv_aditivos"
                                                                                data-toggle="tab">Aditivos</a></li>
                                                        <li class="nav-item"><a class="nav-link" href="#superv_art"
                                                                                data-toggle="tab">ART</a></li>
                                                    </ul>
                                                </div>

                                                <div class="card-body">
                                                    <div class="tab-content">
                                                        <!-- TAB Supervisão Resumo -->
                                                        <div class="tab-pane active" id="superv_resumo">

                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="min-height: 540px;">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">
                                                                                <i class="fa fa-dollar"></i>
                                                                                Financeiro
                                                                            </h3>
                                                                        </div>

                                                                        <div class="card-body" style="font-size: 12px;">
                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor PI </span><br>
                                                                                            <b id="sup_valor_pi"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Aditivos</span><br>
                                                                                            <b id="sup_valor_aditivos"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Reajustamento</span><br>
                                                                                            <b id="sup_reajustamento"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor Total</span><br>
                                                                                            <b id="sup_valor_total"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Total Medido (PI + A) </span><br>
                                                                                            <b id="sup_valor_medido"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Total Medido (PI + A + R) </span><span
                                                                                                    class="legMedidoPiRA"></span><br>
                                                                                            <b id="sup_valor_medido_piar"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor a Medir </span><span
                                                                                                    class="legValorAMedir"></span><br>
                                                                                            <b id="sup_valor_medir"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
																							<span>Total Empenhado <span
                                                                                                        class="legEmpenhar"></span></span><br>
                                                                                            <b id="sup_total_empenhado"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Saldo de Empenho</span><br>
                                                                                            <b id="sup_saldo_empenhado"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>A Empenhar</span><br>
                                                                                            <b id="sup_saldo_empenhar"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-8">
                                                                                    <div id="grafico_obra_dados_supervisao_financeiro"
                                                                                         style="margin: 0 auto;  max-width: 400px;  min-width: 380px; display: block;"
                                                                                         data-highcharts-chart="0">
                                                                                        <figure class="highcharts-figure">
                                                                                            <div id="graficoSupervisaoFinanceiro"></div>
                                                                                        </figure>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="min-height: 540px;">
                                                                        <div class="card-header"
                                                                             style="padding: 10px 10px 0px 20px;">
                                                                            <h3 class="card-title">
                                                                                <i class="fa fa-bar-chart-o"></i>
                                                                                CURVA 'S'
                                                                                <div class="col-md-1 pull-right"
                                                                                title="Empenho"><a
                                                                                href="javascript:void(0);"
                                                                                onclick="PainelEmpenhoRAPSupervisora();"><img
                                                                                src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/icones/item3.png'))?>"
                                                                                alt=""
                                                                                data-toggle="tooltip"
                                                                                title="Empenho/RAP"
                                                                                data-placement="top"
                                                                                height="32" width="32"
                                                                                data-original-title="Empenho/RAP"></a>
                                                                                </div>
                                                                                <div class="col-md-1 pull-right"><a
                                                                                href="javascript:void(0);"
                                                                                onclick="PainelMedicaoSupervisora();"><img
                                                                                src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/icones/item5.png'))?>"
                                                                                alt=""
                                                                                data-toggle="tooltip"
                                                                                title="Medição"
                                                                                data-placement="top"
                                                                                height="32" width="32"
                                                                                data-original-title="Medição"></a>
                                                                                </div>
                                                                               	                                                                                
                                                                            </h3>
                                                                        </div>
																		<div class="card-body" style="display: block">
																			<figure class="highcharts-figure">
																				<div id="grafico_supervisao_curva_s"></div>
																			</figure>
																		</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!--															<div class="row">-->
                                                            <!--																<div class="col-md-12">-->
                                                            <!--																	<div class="card card-default"-->
                                                            <!--																		 style="height: 540px;overflow-y: auto; font-size:14px;">-->
                                                            <!--																		<div class="card-header">-->
                                                            <!--																			<h3 class="card-title">-->
                                                            <!--																				<i class="fa fa-list"></i>-->
                                                            <!--																				Contratos Sob Supervisão-->
                                                            <!--																			</h3>-->
                                                            <!--																		</div>-->
                                                            <!--																		<div class="card-body">-->
                                                            <!--																			<div class="table-responsive">-->
                                                            <!--																				<table id="tableSupervResumo"-->
                                                            <!--																					   class="table table-striped"-->
                                                            <!--																					   style="width: 100%;">-->
                                                            <!--																					<thead>-->
                                                            <!--																					<tr role="row">-->
                                                            <!--																						<th>Contrato</th>-->
                                                            <!--																						<th>Status</th>-->
                                                            <!--																						<th>Contratada</th>-->
                                                            <!--																						<th>Objeto</th>-->
                                                            <!--																						<th>Segmento</th>-->
                                                            <!--																						<th>Subtrecho</th>-->
                                                            <!--																						<th>Valor Atual</th>-->
                                                            <!--																						<th>Vencimento</th>-->
                                                            <!--																					</tr>-->
                                                            <!--																					</thead>-->
                                                            <!--																					<tbody>-->
                                                            <!--																					</tbody>-->
                                                            <!--																				</table>-->
                                                            <!--																			</div>-->
                                                            <!--																		</div>-->
                                                            <!--																	</div>-->
                                                            <!--																</div>-->
                                                            <!--															</div>-->
                                                        </div>
                                                        <!-- TAB Supervisão Aditivos -->
                                                        <div class="tab-pane" id="superv_aditivos">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="min-height: 540px; ">
                                                                        <div class="card-body">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor PI </span><br>
                                                                                            <b id="sup_aditivo_valor_pi"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Aditivos</span><br>
                                                                                            <b id="sup_aditivo_aditivos"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Reajustamento</span><br>
                                                                                            <b id="sup_aditivo_reajustamento"></b>
                                                                                        </div>
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                            <span>Valor Total</span><br>
                                                                                            <b id="sup_aditivo_valor_total"></b>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-10">
                                                                                    <figure class="highcharts-figure">
                                                                                        <div id="SupervisaoAditivoPizza"></div>
                                                                                    </figure>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="card card-default"
                                                                         style="height: 540px;overflow-y: auto; font-size:14px;">
                                                                        <div class="card-body">

                                                                            <table id="tableSupervAditivo" class="table table-striped" style="width: 100%">
                                                                                <thead>
                                                                                <tr role="row">
                                                                                    <th>Nº</th>
                                                                                    <th>Data Assinatura</th>
                                                                                    <th>Objeto</th>
                                                                                    <th>Impacto Financeiro</th>
                                                                                    <th>Dias Prorrogados</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- TAB Supervisão ART -->
                                                        <div class="tab-pane" id="superv_art"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--MODAIS PAINEL GERENCIAL------------------------------------------------------------------------------------------------------------- -->
        <div class="modal fade" id="modalPainelIDFin_old_11112021_0904" tabindex="-1" role="dialog" aria-labelledby="painel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">IDFin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div id="grafico_obra_idfin_old_11112021_0926"
                             style="margin: 0 auto;  max-width: 400px;  min-width: 380px;">
                            <figure class="highcharts-figure">
                                <div id="graficoIDFin"></div>
                            </figure>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                                <span>Índice </span><br>
                                <b><span id="val_indice"></span></b>
                            </div>
                            <div class="col-md-2">
                                <span class="legIdfinRed"></span><br>
                                <b>0 à 1 (Obra em atraso) </b>
                            </div>
                            <div class="col-md-2">
                                <span class="legIdfinGreen"></span><br>
                                <b>1 à 10 (Obra adiantada)</b>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPainelMedicao_old_11112021_1027" tabindex="-1" role="dialog" aria-labelledby="painel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Medição</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" id="tabelaMedicoes"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalPainelMedicao" tabindex="-1" role="dialog" aria-labelledby="painel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Medição</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">

                                <table id="tableMedicoes" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th>Nº Medição</th>
                                            <th>Processamento Medição</th>
                                            <th>Término Medição</th>
                                            <th>Valor PI</th>
                                            <th>Valor Reajuste</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>      
                            </div>        

                        </div>
                    </div>
                </div>
            </div>
        <div class="modal fade" id="modalPainelMedicaoSupervisora" tabindex="-1" role="dialog" aria-labelledby="painel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Medição</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">

                                <table id="tableMedicoesSupervisora" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th>Nº Medição</th>
                                            <th>Processamento Medição</th>
                                            <th>Término Medição</th>
                                            <th>Valor PI</th>
                                            <th>Valor Reajuste</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>      
                            </div>        

                        </div>
                    </div>
                </div>
            </div>
        <div class="modal fade" id="modalPainelEmpenhoRAP" tabindex="-1" role="dialog" aria-labelledby="painel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Empenho/RAP</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <h4><strong>Empenhos</strong></h4>
                                <div class="col-md-12 table-responsive">              
                                    <table id="tableEmpenhos" class="table table-striped" style="width: 100%; font-size:15px;">
                                        <thead>
                                            <tr role="row">
                                                <th>Nota</th>
                                                <th>Emissão</th>
                                                <th>Inicial</th>
                                                <th>Ajuste</th>
                                                <th>Consumido</th>
                                                <th>Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                       
                                            <tr role="row">
                                                <th>Total</th>
                                                <th></th>
                                                <th><span class="somavalor_empenho_inicial"></span></th>
                                                <th><span class="somavalor_empenho_ajuste"></span></th>
                                                <th><span class="somavalor_empenho_consumido"></span></th>
                                                <th><span class="somavalor_empenho_saldo"></span></th>
                                            </tr>
                                       
                                        <tfoot>
                                        
                                       
                                    </tfoot>
                                    </table>
                                    
                    </table>

                                </div>

                            </div>

                            <div class="row">
                                <h4><strong>RAP</strong></h4>
                                <div class="col-md-12 table-responsive">             

                                    <table id="tableRap" class="table table-striped" style="width: 100%; font-size:15px;">
                                        <thead>
                                            <tr role="row">
                                                <th>Nota</th>
                                                <th>Emissão</th>
                                                <th>Inicial</th>
                                                <th>Ajuste</th>
                                                <th>Consumido</th>
                                                <th>Saldo</th>
                                        </thead>
                                        <tbody>                                            
                                        </tbody>
                                         <tr role="row">
                                                <th>Total</th>
                                                <th></th>
                                                <th><span class="somarap_valor_empenho_inicial"></span></th>
                                                <th><span class="somarap_valor_empenho_ajuste"></span></th>
                                                <th><span class="somarap_valor_empenho_consumido"></span></th>
                                                <th><span class="somarap_valor_empenho_saldo"></span></th>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalPainelEmpenhoRAPSupervisora" tabindex="-1" role="dialog" aria-labelledby="painel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Empenho/RAP</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <h4><strong>Empenhos</strong></h4>
                                <div class="col-md-12 table-responsive">              
                                    <table id="tableEmpenhosSupervisora" class="table table-striped" style="width: 100%; font-size:15px;">
                                        <thead>
                                            <tr role="row">
                                                <th>Nota</th>
                                                <th>Emissão</th>
                                                <th>Inicial</th>
                                                <th>Ajuste</th>
                                                <th>Consumido</th>
                                                <th>Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                       
                                            <tr role="row">
                                                <th>Total</th>
                                                <th></th>
                                                <th><span class="somavalor_empenho_inicial"></span></th>
                                                <th><span class="somavalor_empenho_ajuste"></span></th>
                                                <th><span class="somavalor_empenho_consumido"></span></th>
                                                <th><span class="somavalor_empenho_saldo"></span></th>
                                            </tr>
                                       
                                        <tfoot>
                                        
                                       
                                    </tfoot>
                                    </table>
                                    
                    </table>

                                </div>

                            </div>

                            <div class="row">
                                <h4><strong>RAP</strong></h4>
                                <div class="col-md-12 table-responsive">             

                                    <table id="tableRapSupervisora" class="table table-striped" style="width: 100%; font-size:15px;">
                                        <thead>
                                            <tr role="row">
                                                <th>Nota</th>
                                                <th>Emissão</th>
                                                <th>Inicial</th>
                                                <th>Ajuste</th>
                                                <th>Consumido</th>
                                                <th>Saldo</th>
                                        </thead>
                                        <tbody>                                            
                                        </tbody>
                                         <tr role="row">
                                                <th>Total</th>
                                                <th></th>
                                                <th><span class="somarap_valor_empenho_inicial"></span></th>
                                                <th><span class="somarap_valor_empenho_ajuste"></span></th>
                                                <th><span class="somarap_valor_empenho_consumido"></span></th>
                                                <th><span class="somarap_valor_empenho_saldo"></span></th>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="modal fade" id="modalPainelFisico" tabindex="-1" role="dialog" aria-labelledby="painel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="max-width: 90% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cronograma Físico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--refazendo cronograma fisico-------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                        <section id="construtora_acompanhamento_fisico" class="sheet padding-10mm">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
                                    <h3>
                                        <strong>ACOMPANHAMENTO FÍSICO</strong>
                                    </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify">
                                    Cronograma/Avanço Físico
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive" id="tabelaAvancoFisico">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPainelFinanceiro" tabindex="-1" role="dialog" aria-labelledby="painel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="max-width: 90% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cronograma Financeiro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="construtora_fisico_financeiro">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
                                    <h3>
                                        <strong>ACOMPANHAMENTO FINANCEIRO</strong>
                                    </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive"
                                     id="tabelaAcompanhamentoFinanceiro">
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPainelFotos" tabindex="-1" role="dialog" aria-labelledby="painel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloFotos"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="carouselFotos"></div>
                    </div>
                </div>
            </div>
        </div>
		<div class="modal fade" id="modalPainelEmpenho" tabindex="-1" role="dialog" aria-labelledby="painel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document" style="max-width: 90% !important;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Empenho/RAP</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<!--refazendo cronograma fisico-------------------------------------------------------------------------------------------------------------------------------------------------------------------->
						<section id="construtora_empenho" class="sheet padding-10mm">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="table-responsive" id="tabelaEmpenho">
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
        <!--FIM MODAIS PAINEL GERENCIAL------------------------------------------------------------------------------------------------------------- -->
    </section>
    <!-- /.content -->
</div>
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

<!--INFORMAÇÃO ADITIVO-->
<div id="modalObraResumo" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Inserir Resumo</h4>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<textarea rows="8" type="text" id="textoResumo" name="textoResumo" class="form-control"></textarea>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<button type="button" class="btn btn-block btn-primary" name="salvarResumo" id="salvarResumo">Salvar</button>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<!--MODAIS PAINEL GERENCIAL------------------------------------------------------------------------------------------------------------- --> 
            <div class="modal fade" id="modalPainelIDFin" tabindex="-1" role="dialog" aria-labelledby="painel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">IDFin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div id="grafico_obra_idfin" style="margin: 0 auto;  max-width: 400px;  min-width: 380px;"></div>  
                            <div class="row justify-content-center">
                                <div class="col-md-2">

                                    <span>Índice </span><br>
                                    <b><span id="val_indice"></span></b>
                                </div> 
                                <div class="col-md-2">
                                    <span class="legIdfinRed"></span><br>
                                    <b>0 à 1 (Obra em atraso) </b>

                                </div> 
                                <div class="col-md-2">
                                    <span class="legIdfinGreen"></span><br>
                                    <b>1 à 10 (Obra adiantada)</b>
                                </div> 

                            </div>              
                        </div>
                    </div>
                </div>
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

