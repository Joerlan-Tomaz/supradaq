//Função para validar se é um número
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

//Função para validar variáveis vazias
function isNullOrWhiteSpace(value) {
    return value === null || value === "" || value === undefined || (isNumber(value) ? isNaN(value) : false);
}

//Função para validar url local ou no servidor
function criarURL(controller, action) {  
    var url = location.protocol + '//' + location.host + (window.location.href.match(/supra/gi) ? '/supra/' : '/') + controller + '/' + action;                 
    return url;
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
function renderizarDesignDataTables(id, scrollX) {
    $.fn.dataTable.ext.errMode = "throw";
    $("#" + id).DataTable({
        'responsive': true,
        'autoWidth': true,
        'scrollX': scrollX,
        'scrollXInner': '100%',
        'destroy': true,
        'ordering': false,
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