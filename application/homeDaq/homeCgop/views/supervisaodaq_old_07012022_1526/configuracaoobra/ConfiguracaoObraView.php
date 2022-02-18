<link rel="stylesheet" href="<?php echo(base_url('assets/css/road.css'))?>" /> 


<style>
    .road-way {
        background: url(' <?= base_url ("assets/img/road/roads.png") ?> ') no-repeat; 
    } 
    .road-page {    
        background: url(' <?= base_url ("assets/img/road/bg-page.png") ?> ') center bottom no-repeat;
        background-size: cover;
        background-position: fixed;
    }
    .road-page .road-container {    
        background: url(' <?= base_url ("assets/img/road/bg-map.png") ?> ') center 125% no-repeat;
        width: 100%;
        background-size: 105vw 55vh;
    }.road-menu ul li .road-ico {    
        background: url(' <?= base_url ("assets/img/road/pl-gray.png") ?> ') center center no-repeat;
    }
    .road-menu ul li a {   
        background: url(' <?= base_url ("assets/img/road/bg-text-menu.png") ?> ') right center no-repeat;
    }
    .road-way {
        background: url(' <?= base_url ("assets/img/road/roads.png") ?> ') no-repeat;
        background-position: -400px 50px;
        background-size: 130vw 50vh;
    }
    .road-menu ul li.envio .road-ico {    
        background: url(' <?= base_url ("assets/img/road/pl-blue.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.status-ok .road-ico {    
        background: url(' <?= base_url ("assets/img/road/pl-green.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.pendencia .road-ico, .road-menu ul li:hover .road-ico {    
        background: url(' <?= base_url ("assets/img/road/pl-orange.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.reprovado .road-ico {   
        background: url(' <?= base_url ("assets/img/road/pl-red.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.envio .road-status {    
        background: url(' <?= base_url ("assets/img/road/check-e.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.status-ok .road-status {    
        background: url(' <?= base_url ("assets/img/road/check-ok.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.pendencia .road-status {    
        background: url(' <?= base_url ("assets/img/road/check-warn.png") ?> ') center center no-repeat;
    }.road-menu ul li.reprovado .road-status {   
        background: url(' <?= base_url ("assets/img/road/check-no.png") ?> ') center center no-repeat;
    }

    .content-wrapper {
        padding: 0 0px;
        padding-top: 70px !important;
    }
</style> 

<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/configuracao/configuracaoView.js'))?>"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/justificativaempreendimento/justificativaempreendimento.js'))?>" type="text/javascript"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/mapasituacao/mapasituacao.js" type="text/javascript'))?>"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/georreferenciamento/georreferenciamento.js'))?>" type="text/javascript"></script> 
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/pontodepassagem/pontodepassagem.js'))?>" type="text/javascript"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/ocorrenciaprojeto/ocorrenciaprojeto.js'))?>" type="text/javascript"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/diagramapontopassagem/diagramapontopassagem.js'))?>" type="text/javascript"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/dadossegmento/dadossegmento.js'))?>" type="text/javascript"></script> 
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/portariasfiscais/portariasfiscais.js'))?>" type="text/javascript"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/art/art.js'))?>" type="text/javascript"></script>

<div class="content-wrapper">
    <div class="road-page">
        <div class="road-container">
            <div class="container-fluid">
                <div class="road-info row">
                    <div class="col-md-12">
                        <h1 id="tituloConfiguracao"></h1>
                        <p id="objetoContratoConfig"></p>
                    </div>
                </div>
                <div class="road-menu row">
                    <div class="col-xs-12 col-md-6">
                        <ul class="list-unstyled">
                            <li class="justificativa">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/just.png'))?>" /></span>
                                <a href="javascript:void(0);" onclick="rotaJustificativaEmpreendimentoDaq()"><span>Justificativa do empreendimento</span></a>
                                <span class="road-status"></span>
                            </li>
                            <li class="mapa">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/mapa.png'))?>" /></span>
                                <a href="javascript:void(0);" onclick="rotaMapaSituacaoDaq()"><span>Mapa de situação</span></a>
                                <span class="road-status"></span>
                            </li>
                            
                            <li class="geo">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/geo.png'))?>" /></span>
                                <a href="" data-toggle="modal" onclick="rotaGeorreferenciamentoDaq()"><span>Eixos Georreferenciados</span></a>
                                <span class="road-status"></span>
                            </li>
                            <li class="pontos">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/passagem.png'))?>" /></span>
                                <a href="" data-toggle="modal" onclick="rotaPontoPassagemDaq()"><span>Pontos de Passagem</span></a>
                                <span class="road-status"></span>
                            </li>
                            <li class="diagrama">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/diagrama.png'))?>" /></span>
                                <a href="" data-toggle="modal" onclick="rotaOcorrenciaProjetoDaq()"><span>Ocorrências de Projeto</span></a>
                                <span class="road-status"></span>
                            </li>
                            <li>
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/resumo.png'))?>" /></span>
                                <a href="" data-toggle="modal" onclick="rotaDiagramaPontoPassagemDaq()"><span>Diagrama de Pontos de Passagem e de Ocorrências de Projeto</span></a>
                                <span class="road-status"></span>
                            </li>
                          <!--   <li class="oae">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/oae.png'))?>"/></span>
                                <a href="" data-toggle="modal" onclick="rotaDadosSegmentoDaq()"><span>Dados Segmento</span></a>
                                <span class="road-status"></span>
                            </li> -->
                            <li class="art">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/art.png'))?>" /></span>
                                <a href="" data-toggle="modal" onclick="rotaArtDaq()"><span>ART de Supervisão</span></a>
                                <span class="road-status"></span>
                            </li>
                            <li class="portarias">
                                <span class="road-ico"><img src="<?php echo(base_url('assets/img/road/port.png'))?>" /></span>
                                <a href="" data-toggle="modal" onclick="rotaPortariasFiscaisDaq()"><span>Portarias de fiscais</span></a>
                                <span class="road-status"></span>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="road-info">
                            <div class="box-info">
                                <h3 id="informacao" style= "width: 100%;">Informação</h3>
                                <span id="checkJustificativa" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Justificativa de Empreendimento <br>
                                <span id="checkMapaSituacao" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Mapa de Situação<br>
                                <span id="checkGeorreferenciamento" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Eixos Georreferenciados<br>
                                <span id="checkPontoPassagem" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Pontos de Passagem<br>
                                <span id="checkDiagramaOcorrencia" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Ocorrências de Projeto<br>
                                <span id="checkDiagramaPontoPassagem" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Diagrama de Pontos de Passagem Ocorrências de Projeto<br>
                               <!--  <span id="checkDadosSegmento" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Dados Segmento<br> -->
                                <span id="checkART" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> ART de Supervisão<br>
                                <span id="checkPortariasFiscais" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Portarias de Fiscais<br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <!-- <div class="road-way"></div> -->
        </div> 
    </div>
</div>     
