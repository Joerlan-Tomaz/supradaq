var uf;
var rodovia;
var km1;
var km2;
var dadosTabela = {};
var codVersao;
var dtImportacao;

$(document).ready(function () {
    $('#spinner').hide();
    $('#spinner2').hide();
    $('#divVersoes').hide();
    consutaSNV_Edital();
    var navegador = get_browser();
    if (navegador.name !== "Chrome") {
        alert("Algumas funcinalidades podem não ter um bom funcionamento neste navegador, sugerimos o Chrome.")
    }
    recuperaDadosVersoes();
});

function get_browser() {
    var ua = navigator.userAgent, tem, M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if (/trident/i.test(M[1])) {
        tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
        return {name: 'IE', version: (tem[1] || '')};
    }
    if (M[1] === 'Chrome') {
        tem = ua.match(/\bOPR\/(\d+)/)
        if (tem != null) {
            return {name: 'Opera', version: tem[1]};
        }
    }
    M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
    if ((tem = ua.match(/version\/(\d+)/i)) != null) {
        M.splice(1, 1, tem[1]);
    }
    return {
        name: M[0],
    };
}

function consutaSNV_Edital() {
    // montaFiltros();
    $('#spinner').show();
    $('#example1').dataTable({
        "destroy": true,
        "bProcessing": true,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            },
            "sProcessing": "Carregando ...\n\n"
        },
        "sAjaxSource": "SNV_Edital/consultaBRLegal2SNVEdital",

        "fnServerParams": function (aoData) {
            aoData.push(
                    {"name": "etapa", "value": $("#Etapa").val()},
                    {"name": "lote", "value": $("#Lote").val()},
                    {"name": "uf", "value": $("#Estado").val()},
                    {"name": "br", "value": $("#Rodovia").val()},
                    {"name": "km2", "value": $("#KMFinal").val()},
                    {"name": "km1", "value": $("#KMInicial").val()},
                    {"name": "versao", "value": $('#visualizarVersao').val()}
            )
        },
        "aoColumns": [
            {data: 'Etapa'},
            {data: 'LoteEdital'},
            {data: 'UF'},
            {data: 'Rodovia'},
            {data: 'SNV'},
            {data: 'LocalInicio'},
            {data: 'LocalFim'},
            {
                data: 'KmInicial',
                render: function ( data, type, row ) {
                    return data.toFixed(2);
                }
            },
            {
                data: 'KmFinal',
                render: function ( data, type, row ) {
                    return data.toFixed(2);
                }
            },
            {
                data: 'Extensao',
                render: function ( data, type, row ) {
                    return data.toFixed(2);
                }
            },
            {data: 'SuperficieFederal'},
            {data: 'Superficie'},
            {data: 'Versao'}
        ]
    });
    $('#spinner').hide();
}

function montaFiltros() {
    $.ajax({
        type: 'POST',
        url: 'mountFilters',
        dataType: 'json',
        data: {
            "etapa": $("#Etapa").val(),
            "lote": $("#Lote").val(),
            "uf": $("#Estado").val(),
            "br": $("#Rodovia").val(),
            "km2": $("#KMFinal").val(),
            "km1": $("#KMInicial").val()
        },
        processData: false,
        contentType: false,
        success: function (data) {
            var ufs = JSON.parse(data.ufs);
            var etapas = JSON.parse(data.etapas);
            var lotes = JSON.parse(data.lotes);
            var rodovias = JSON.parse(data.rodovias);
            $('#Estado').html('<option value="">Estado</option>');
            ufs.forEach(function (item) {
                $('#Estado').append('<option value="' + item.UF + '">' + item.UF + '</option>');
            });
            $('#Lote').html('<option value="">Lote</option>');
            lotes.forEach(function (item) {
                $('#Lote').append('<option value="' + item.Lote + '">' + item.Lote + '</option>');
            });
            $('#Etapa').html('<option value="">Etapa</option>');
            etapas.forEach(function (item) {
                $('#Etapa').append('<option value="' + item.Etapa + '">' + item.Etapa + '</option>');
            });
            $('#Rodovia').html('<option value="">Rodovia</option>');
            rodovias.forEach(function (item) {
                $('#Rodovia').append('<option value="' + item.Rodovia + '">' + item.Rodovia + '</option>');
            });
        },
        error: function (error) {
            error.log(error);
        }
    });
}

function carregarArquivo() {
    $('#spinner2').show();
    var form = new FormData();
    var arquivo = $('#fupload')[0].files[0];
    form.append('fupload', arquivo);
     form.append('versao',  $('#versao').val());
    $.ajax({
        type: 'POST',
        url: 'SNV_Edital/uploadDadosExcel',
        dataType: 'json',
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
//            dadosTabela = data;
            $('#linhasCarregadas').text(dadosTabela.length);
            $('#spinner2').hide();
        }
    });
}

$('#fupload').on('change', function () {
    var arquivo = $('#fupload').val();
    if (arquivo != '') {
        var arquivo = $('#fupload')[0].files[0];
        $('#arquviSelecionado').text(arquivo.name);
    }
});

function importarDados() {
    // verifica se a versao foi digitada
    var versao = $('#versao').val();
    if (versao === null || versao === '') {
        alert('Digite a versão, antes de importar os dados.');
    } else {
        $('#spinner2').show();
        $.ajax({
            type: 'POST',
            url: 'SNV_Edital/insertDadosExcel',
            dataType: 'json',
            data: {
                versao: versao,
                arrTabela: JSON.stringify(dadosTabela),
            },
            success: function (data) {
            },
            error: function (data) {
            },
            complete: function (data) {
                $('#spinner2').hide();
                 location.reload();
            }
        });
    }
}

function modalExcluirVersao(versao, dataImportacao) {
    codVersao = versao;
    dtImportacao = dataImportacao;
    $('#modalExcluirVersao').modal('show');
}

function modalImportar() {
    $('#modalImportar').modal('show');
}

function deleteVersao() {
    $.ajax({
        url: "SNV_Edital/excluirVersao",
        type: "POST",
        data: {
            versao: codVersao,
            importacao: dtImportacao
        },
        dataType: 'json',
        success: function (data) {
        },
        complete: function (data) {
            console.log(data);
            location.reload();
        }
    });
}

function recuperaDadosVersoes() {
    uf = $("#FiltroEstado").val();
    rodovia = $("#FiltoRodovia").val();
    km1 = $("#FiltroKMInicial").val();
    km2 = $("#FiltroKMFinal").val();
    $.ajax({
        type: 'POST',
        url: 'SNV_Edital/buscaVersoesSNV',
        dataType: 'json',
        data: {uf: uf, rodovia: rodovia, kmInicial: km1, kmFinal: km2},
        success: function (result) {
            let data = Object.values(JSON.parse(JSON.stringify(result)));
            let card = $('#cardVersaoSNV');
            let versaoAntiga = '';
            card.append('<div class="card-body  bg-defaut"><h4 class="card-title">Importações:</h4><table id="tabVersaoSNV" class="table-sm" style="width:100%;"><thead></thead><tbody></tbody></table></div>');
            
            let tbody = $('#tabVersaoSNV tbody');           
            data.forEach(function (item) {
                if (versaoAntiga != item.Versao) {
                    tbody.append('<tr><td class="fa fa-plus detalhes" id="' + item.Versao + '" onclick="toggleVersao(\'' + item.Versao + '\')"> Versão: ' + item.Versao + '</a></td></tr>');
                }
               tbody.append('<tr style="display:none;" class="' + item.Versao + '"><td></td>&nbsp;<td>' + item.DataImportacao + '</td><td>&nbsp</td><td><button type="button" id="tableBtnExcluir" onclick="modalExcluirVersao(\'' + item.Versao + '\',' + '\'' + item.DataImportacao + '\')" ' +
                        'class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td></tr>');
                versaoAntiga = item.Versao;
            });
            $('#divVersoes').show();
        },
        error: function (result) {
            console.log(result);
        }
    });

}

function toggleVersao(param) {
    $('.' + param).toggle();
    $('#' + param).toggleClass("fa fa-plus");
    $('#' + param).toggleClass("fa fa-minus");
}

function visualizarImportacao(versao) {
    $('#visualizarVersao').val(JSON.stringify(versao));
    consutaSNV_Edital();
}