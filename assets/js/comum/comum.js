//Função para validar se é um número
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

//Função para validar variáveis vazias
function isNullOrWhiteSpace(value) {
    return value === null || value === "" || value === undefined || (isNumber(value) ? isNaN(value) : false || value === false);
}

function calculaDifrenciaDeAno(ano1, ano2){
    //formato do brasil 'pt-br'
    moment.locale('pt-br');
    //setando data1
    var _ano1 = moment(ano1, 'YYYY');
    //setando data2
    var _ano2 = moment(ano2, 'YYYY');
    //tirando a diferenca da data2 - data1 em dias
    var diff  = _ano2.diff(_ano1, 'year');
    
    return diff;
}

//Função para validar número após divisão
//Caso o divisão seja NaN o retorno da função para zero
function validarNumParaDivisao(vlr) {
    var valor = parseFloat(vlr.toFixed(2));
    if (!Number.isNaN(valor)) {
        return valor;
    } else {
        return 0;
    }
}

function limitarNumeros(d, casas) {
    var aux = Math.pow(10, casas)
    return Math.floor(d * aux) / aux
}

//Função para renderizar design do datatables 
//Parâmetro: id da table, scrollX quando a table for muito largo habilitar a rolagem horizontal
function renderizarDesignDataTables(id) {
   // $.fn.dataTable.ext.errMode = "throw";
    $("#" + id).DataTable({
        "processing": false,
        "responsive": true,
        "autoWidth": true,
        "destroy": true,
        "ordering": false,
        "stateSave": false,
        "displayLength": 10,
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
        'scrollXInner': '100%',  /**/
        dom:
        "<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-7'l><'col-xs-12 col-sm-12 col-md-12 col-lg-5'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-7'i><'col-xs-12 col-sm-12 col-md-12 col-lg-5'p>>",
        renderer: 'bootstrap',
        sType: 'brazilian',
        oLanguage: {
            sLengthMenu: '_MENU_',
            sInfo: 'Mostrando <strong>_START_</strong>-<strong>_END_</strong> de <strong>_TOTAL_</strong> registros',
            sInfoFiltered: '(Filtro de _MAX_ registros)',
            sSearch: 'Pesquisar: ',
            sZeroRecords: 'Nenhum registro encontrado',
            sProcessing: 'Processando',
            sLoadingRecords: 'Nenhum registro encontrado',
            sInfoEmpty: 'Mostrando <strong>_START_</strong>-<strong>_END_</strong> de <strong>_TOTAL_</strong> registros',
            oPaginate: {
                sPrevious: '<i class="fa fa-angle-left"></i>',
                sNext: '<i class="fa fa-angle-right"></i>'
            }
        }
    });
}

function carregarMapa(id_select, camada) {
    require([
        "esri/layers/ArcGISDynamicMapServiceLayer", "esri/map", "esri/geometry/Extent", "esri/IdentityManager", "esri/graphicsUtils", "esri/tasks/query", "esri/tasks/QueryTask",
        "esri/graphic", "esri/layers/FeatureLayer", "dojo/on", "dojo/dom", "dojo/domReady!"
    ], function (
        ArcGISDynamicMapServiceLayer, Map, Extent, esriId, graphicsUtils, Query, QueryTask, Graphic, FeatureLayer, on, dom
    ) {

        initialExtent = new Extent({
            xmin: -16079904.766291741,
            ymin: -7007746.75318313,
            xmax: 2705259.30506818,
            ymax: 2316347.705153331,
            "spatialReference": {
                "wkid": 102100
            }
        });

        map = new Map("map", {
            basemap: "topo",
            sliderPosition: "top-left",
            minZoom: 0,
            maxZoom: 10,
            logo: false,
            autoResize: true,
            showAttribution: false,
            extent: initialExtent
        });

        map.on("load", function () {
            map.disableMapNavigation();
            map.disableKeyboardNavigation();
            map.disablePan();
            map.disableRubberBandZoom();
            map.disableScrollWheelZoom();
        });

        esriId.registerToken({
            server: "http://servicos.dnit.gov.br/arcgis/rest/services/Contratos/servico_contratos/MapServer/",
            token: "djwid6KaAyOg-Zp8sTUFPjxAS2ncgIF0FREbkCKROW4AS7-6UZpvxcvFn0ny87aK",
            expires: 1556908236011,
            ssl: false
        });

        var layer = new ArcGISDynamicMapServiceLayer("http://servicos.dnit.gov.br/arcgis/rest/services/Contratos/servico_contratos/MapServer/", {
            id: "servico"
        });

        layer.setVisibleLayers([-1]);
        map.addLayers([layer]);

        if (!isNullOrWhiteSpace(id_select)) {
            on(dom.byId("" + id_select + ""), "change", function (evt) {
                var select = evt.target
                carregarMapaComContrato(select[select.selectedIndex].text, 0);
            });

            var screenshotButton = document.getElementById("btnPDF");
            if (!isNullOrWhiteSpace(screenshotButton)) {
                screenshotButton.addEventListener("click", takeScreenshot);
            }
        }
    });
}

function carregarMapaComContrato(num_contrato, camada) {
    require([
        "esri/graphicsUtils", "esri/tasks/query", "esri/tasks/QueryTask"
    ], function (
        graphicsUtils, Query, QueryTask
    ) {
            map.getLayer("servico").setVisibleLayers([0]);
            var layerDefs = [];
            layerDefs[0] = "contrato = '" + num_contrato + "'";
            map.getLayer("servico").setLayerDefinitions(layerDefs);

            var queryTask = new QueryTask("http://servicos.dnit.gov.br/arcgis/rest/services/Contratos/servico_contratos/MapServer/" + camada);
            var query = new Query();

            query.outFields = ["*"];
            query.returnGeometry = true;
            query.where = "contrato = '" + num_contrato + "'";
            queryTask.on("complete", function (result) {
                featureSet = result.featureSet;
                if (featureSet.features.length > 0) {
                    var extent = graphicsUtils.graphicsExtent(featureSet.features);
                    extent.spatialReference.wkid = 4326;
                    extent.spatialReference.latestWkid = 4326
                    map.setExtent(extent, true);
                }
                else {

                }
            });

            queryTask.execute(query);
        });
}

function inserirAlertaBootstrap(msg, tipoErro, modal) {
    var timeOut;
    limparEsconderAlertaBootstrap();
    clearTimeout(timeOut);
    if (modal) {
        if (tipoErro) {
            $('#SPANMsgErroModal').html(msg);
            $('#DIVMsgErroModal').show();
            timeOut = setTimeout(function () {
                $('#DIVMsgErroModal').hide();
                $('#SPANMsgErroModal').html('');
            }, 8000);
        } else {
            $('#SPANmsgSuccessModal').html(msg);
            $('#msgSuccessModal').show();
            timeOut = setTimeout(function () {
                $('#msgSuccessModal').hide();
                $('#SPANmsgSuccessModal').html('');
            }, 8000);
        }
        $('div.modal').scrollTop(0);
    } else {
        if (tipoErro) {
            $('#SPANMsgErro').html(msg);
            $('#DIVMsgErro').show();
            timeOut = setTimeout(function () {
                $('#DIVMsgErro').hide();
                $('#SPANMsgErro').html('');
            }, 8000);
        } else {
            $('#SPANmsgSuccess').html(msg);
            $('#msgSuccess').show();
            timeOut = setTimeout(function () {
                $('#msgSuccess').hide();
                $('#SPANmsgSuccess').html('');
            }, 8000);
        }
        window.scrollTo(0, 0);
    }
}

function limparEsconderAlertaBootstrap() {
    $('#DIVMsgErroModal').hide();
    $('#SPANMsgErroModal').html('');
    $('#msgSuccessModal').hide();
    $('#SPANmsgSuccessModal').html('');
    $('#DIVMsgErro').hide();
    $('#SPANMsgErro').html('');
    $('#msgSuccess').hide();
    $('#SPANmsgSuccess').html('');
}

//Função para formatar valor percentual no gráfico pia
function formatarValorGraficoPia(valor) {
    var vlr = valor.toFixed(2).replace('.', ',');
    if ((vlr != null) && (vlr != '')) {
        return vlr + '%';
    } else {
        return 0;
    }
}

function tranformarValorInputVirgulaEmPonto(element){
    var valueInput = element.value;
    valueInput = replaceAllComman(valueInput);
    valueInput = tratarPontoeVirgula(valueInput);
    document.getElementById(element.id).value = valueInput;
}

function tratarPontoeVirgula(_value)
{
    while((_value.match(/\./g) || []).length > 1)
    {
        _value = _value.replace(".","");
    }
    return _value;
}

function replaceAllComman(_value)
{
    while((_value.match(/\,/g) || []).length > 0)
    {
        _value = _value.replace(",",".");
    }
    return _value;
}