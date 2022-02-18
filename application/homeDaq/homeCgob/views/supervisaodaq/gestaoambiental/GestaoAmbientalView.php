<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgob/assets/css/road.css'))?>"> 

<style>
    .road-way {
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/roads.png") ?> ') no-repeat; 
    } 
    .road-page {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/bg-page.png") ?> ') center bottom no-repeat;
        background-size: cover;
        background-position: fixed;
    }
    .road-page .road-container {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/bg-map.png") ?> ') center 125% no-repeat;
        width: 100%;
        background-size: 105vw 55vh;
    }.road-menu ul li .road-ico {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/pl-gray.png") ?> ') center center no-repeat;
    }
    .road-menu ul li a {   
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/bg-text-menu.png") ?> ') right center no-repeat;
    }
    .road-way {
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/roads.png") ?> ') no-repeat;
        background-position: -400px 50px;
        background-size: 130vw 50vh;
    }
    .road-menu ul li.envio .road-ico {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/pl-blue.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.status-ok .road-ico {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/pl-green.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.pendencia .road-ico, .road-menu ul li:hover .road-ico {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/pl-orange.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.reprovado .road-ico {   
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/pl-red.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.envio .road-status {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/check-e.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.status-ok .road-status {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/check-ok.png") ?> ') center center no-repeat;
    }
    .road-menu ul li.pendencia .road-status {    
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/check-warn.png") ?> ') center center no-repeat;
    }.road-menu ul li.reprovado .road-status {   
        background: url(' <?= base_url ("application/homeDaq/homeCgob/assets/img/road/check-no.png") ?> ') center center no-repeat;
    }
</style>    


<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/gestaoambiental/gestaoambientalView.js')) ?>" type="text/javascript"></script>
<!--GESTAO AMBIENTAL-->
<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/licencasambientais/licencasambientais.js')) ?>" type="text/javascript"></script>
<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/pbapbai/pbapbai.js')) ?>" type="text/javascript"></script>

<div class="content-wrapper">
    <div class="road-page">
        <div class="road-container">
            <div class="container-fluid">
                <div class="road-info row">
                    <div class="col-md-12">
                        <h1>Gestão Ambiental</h1>
                        <p></p>
                    </div>
                </div>
                <div class="road-menu row">
                    <div class="col-xs-12 col-md-6">
                        <ul class="list-unstyled">
                            <li class="justificativa">
                                <span class="road-ico"><img  src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/road/just.png'))?>" /></span>
                                <a href="javascript:void(0);" onclick="rotaLicencasAmbientaisDaq()"><span>Licenças Ambientais</span></a>
                                <span class="road-status"></span>
                            </li>
                            <li class="mapa">
                                <span class="road-ico"><img src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/road/mapa.png'))?>" /></span>
                                <a href="javascript:void(0);" onclick="rotaPbaPbaiDaq()"><span>PBA / PBAI</span></a>
                                <span class="road-status"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="road-info">
                            <div class="box-info">
                                <h3 style="width:100%">Informação</h3> 
                                <span id="checkLicencaAmbiental" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> Licença Ambiental<br>
                                <span id="checkPBAPBAI" class="badge badge-secondary" style="border-radius: 50px; box-shadow: 1px 3px 7px #545454; margin: 0px 10px;" data-toggle="tooltip" title="Pendente" data-placement="top"><i class="fa fa-check"></i></span> PBA / PBAI<br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="road-way"></div> -->
        </div> 
    </div>
</div>      