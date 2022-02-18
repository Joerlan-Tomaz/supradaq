var UFSelecionada = '';
var rodoviaSelecionada = '';
var EditalLotePNCVSelecionado = '';
var EditalPNCVSelecionado = '121';
var mesAmostra = '';
var anoAmostra = '2018';
var LoteSelecionado = ''


$(document).ready(function () {
    populaLoteUF(UFSelecionada);

    AutoLoad(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);

    $("#situacaoEdital").change(function () {     
        EditalPNCVSelecionado = $("#situacaoEdital option:selected").val();   
     
        AutoLoad(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);
    });


    $("#mesAmostra").change(function () {
        mesAmostra = $("#mesAmostra option:selected").val();
        anoAmostra = $("#anoAmostra option:selected").val();
        InvalidacaoImagemTipoErro_Ex(mesAmostra, anoAmostra, EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
        InvalidacaoImagemTipoErro(mesAmostra, anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        ResponsbilidadeOperadora(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        FatoresExogenos(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        potencialmenteValidas(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        TotalImagensInvalidas(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        RankProcesso(mesAmostra, anoAmostra, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
        // PotencialmenteValidasTabela(mesAmostra, anoAmostra, UFSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    });

    $("#anoAmostra").change(function () {
        mesAmostra = $("#mesAmostra option:selected").val();
        anoAmostra = $("#anoAmostra option:selected").val();
        InvalidacaoImagemTipoErro_Ex(mesAmostra, anoAmostra, EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
        InvalidacaoImagemTipoErro(mesAmostra, anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        ResponsbilidadeOperadora(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        FatoresExogenos(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        potencialmenteValidas(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        TotalImagensInvalidas(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        TotalImagensAmostra(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        ResponsbilidadeOperadora_Ex(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        FatoresExogenos_Ex(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        potencialmenteValidas_Ex(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
        RankProcesso(mesAmostra, anoAmostra, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
    });

    $("#anoInfracoes").change(function () {
        mesInfracoes = $("#mesInfracoes option:selected").val();
        anoInfracoes = $("#anoInfracoes option:selected").val();
        tableEquipamentoInfracao(mesInfracoes, anoInfracoes, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    });

    $("#mesInfracoes").change(function () {
        mesInfracoes = $("#mesInfracoes option:selected").val();
        anoInfracoes = $("#anoInfracoes option:selected").val();
        tableEquipamentoInfracao(mesInfracoes, anoInfracoes, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    });

    $("#LoteME").change(function () {
        EditalLotePNCVSelecionado = '';
        UFSelecionada = '';
        LoteSelecionado = $("#LoteME option:selected").val();
        RelatorioME_Lote(UFSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, LoteSelecionado);
    });

    $("#SRME").change(function () {
        EditalLotePNCVSelecionado = '';
        LoteSelecionado = '';
        UFSelecionada = $("#SRME option:selected").val();
        RelatorioME_SR(UFSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, LoteSelecionado);
    });

});

//Limpar Filtros
$(document).ready(function () {
    $("#resetfull").click(function () {
        UFSelecionada = '';
        rodoviaSelecionada = '';
        anoAmostra = '2018';
        mesAmostra = '';
        EditalPNCVSelecionado = '121';
        EditalLotePNCVSelecionado = '';
        populaLoteUF(UFSelecionada);

        AutoLoad(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);

        $('.txtuf').text('Brasil');
        // populaRodovia(UFSelecionada);
        document.getElementById("mapaEstado").src = "map/brasil.png";

        if (rodoviaSelecionada === "") {
            var inputOrigem = $('select[id=rodovia]');
            inputOrigem.html('');
            inputOrigem.append('<option selected>Selecione um Estado no mapa!</option>');
        }
    });
});

//Recupera uf selecioanda do mapa do Brasil
$(document).ready(function () {
    $("a[rel='link']").click(function () {
        uf = ($(this).attr('xlink:href'));
        UFSelecionada = uf.replace("#", "");
       

        // document.getElementById("mapaEstado").src = "map/" + UFSelecionada + ".png";

        if (UFSelecionada === 'ro') { fed = 'Rondônia'; };
        if (UFSelecionada === 'ac') { fed = 'Acre'; };
        if (UFSelecionada === 'am') { fed = 'Amazonas'; };
        if (UFSelecionada === 'rr') { fed = 'Roraima'; };
        if (UFSelecionada === 'pa') { fed = 'Pará'; };
        if (UFSelecionada === 'ap') { fed = 'Amapá'; };
        if (UFSelecionada === 'to') { fed = 'Tocantins'; };
        if (UFSelecionada === 'ma') { fed = 'Maranhão'; };
        if (UFSelecionada === 'pi') { fed = 'Piauí'; };
        if (UFSelecionada === 'ce') { fed = 'Ceará'; };
        if (UFSelecionada === 'rn') { fed = 'Rio Grande do Norte'; };
        if (UFSelecionada === 'pb') { fed = 'Paraíba'; };
        if (UFSelecionada === 'pe') { fed = 'Pernambuco'; };
        if (UFSelecionada === 'al') { fed = 'Alagoas'; };
        if (UFSelecionada === 'se') { fed = 'Sergipe'; };
        if (UFSelecionada === 'ba') { fed = 'Bahia'; };
        if (UFSelecionada === 'mg') { fed = 'Minas Gerais' };
        if (UFSelecionada === 'es') { fed = 'Espírito Santo' };
        if (UFSelecionada === 'rj') { fed = 'Rio de Janeiro' };
        if (UFSelecionada === 'sp') { fed = 'São Paulo' };
        if (UFSelecionada === 'pr') { fed = 'Paraná' };
        if (UFSelecionada === 'sc') { fed = 'Santa Catarina'; };
        if (UFSelecionada === 'rs') { fed = 'Rio Grande do Sul'; };
        if (UFSelecionada === 'ms') { fed = 'Mato Grosso do Sul'; };
        if (UFSelecionada === 'mt') { fed = 'Mato Grosso'; };
        if (UFSelecionada === 'go') { fed = 'Goiás'; };
        if (UFSelecionada === 'df') { fed = 'Distrito Federal'; };

        $('.txtuf').text(fed); //Popula campo Estado Selecionado
        populaRodovia(UFSelecionada);
        populaLoteUF(UFSelecionada);

        AutoLoad(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);

    });
});

//popula Select com a rodovia de acordo com uf do estado
function populaRodovia(UFSelecionada) {
    $.ajax({
        type: 'post',
        url: 'controller/controle_Base_Rodovia_UF',
        data: {
            baserodoviauf: 'baserodoviauf',
            uf: UFSelecionada
        },
        dataType: 'json',
        success: function (data) {

            if (data.rodovia != "null") {
                var inputOrigem = $('select[id=rodovia]');
                inputOrigem.html('');
                inputOrigem.append("<option value='' selected>Todos</option>");

                for (i = 0; i < data.rodovia.length; i++) {
                    inputOrigem.append('<option value="' + data.rodovia[i] + '">' + data.rodovia[i] + '</option>');
                }
            }

        }
    });
};

function populaLoteUF(UFSelecionada) {
    $.ajax({
        type: 'post',
        url: 'controller/controle_PNCV',
        data: {
            buscaEditalLoteUF: 'buscaEditalLoteUF',
            uf: UFSelecionada
        },
        dataType: 'json',
        success: function (data) {
            var inputOrigem = $('select[id=editalLote]');
            inputOrigem.html('');
            inputOrigem.append("<option value='' selected>Todos</option>");

            for (i = 0; i < data.EditalLote.length; i++) {
                inputOrigem.append('<option value="' + data.EditalLote[i] + '">' + data.EditalLote[i] + '</option>');
            }

        }
    });
};

//captura o valor da rodovia selecionada
$(document).ready(function () {
    $("#rodovia").change(function () {
        rodoviaSelecionada = $("#rodovia option:selected").val();
        AutoLoad(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);
    });
    //verifica se a uf foi selecioanda
    // $("#rodovia").click(function () {
    //     rodoviaSelecionada = $("#rodovia option:selected").val();
    //     if (rodoviaSelecionada === null) {
    //         var inputOrigem = $('select[id=rodovia]');
    //         inputOrigem.html('');
    //         inputOrigem.append('<option selected>Selecione um Estado no mapa!</option>');
    //     };
    // });

});

$(document).ajaxStart(function () {
    $(".log").show();
});

$(document).ajaxStop(function () {
    $(".log").hide();
});

function AutoLoad(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado) {
    var Aba = document.getElementById("Aba").value;

    if (Aba == 'Afericao') {
        Afericao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);
    } else if (Aba == 'Equipamento') {
        Equipamento(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);
    } else if (Aba == 'Auditoria') {
        Auditoria(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);
    } else if (Aba == 'RegistroInfracao') {
        RegistroInfracao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);
    } else if (Aba == 'EME') {
        EME(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado);
    }
}

function Afericao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado) {
    document.getElementById("Aba").value = "Afericao";
    TotalAfericaoINMETROVencidas(EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
    TotalAfericaoINMETROVencidasMes(EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
    TotalAfericaoINMETROVencidasAVencer(EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
    caled(EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
}

function Equipamento(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado) {
    document.getElementById("Aba").value = "Equipamento";
    EquipamentoSituacao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    FaixaSituacao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    IncidenciaParalisacao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    OperandoCancladosPorAno(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    MediasDias(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    MediaDiasParalisacao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
}

function Auditoria(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado) {
    document.getElementById("Aba").value = "Auditoria";
    TotalImagensInvalidas(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    InvalidacaoImagemTipoErro(mesAmostra, anoAmostra, EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
    ResponsbilidadeOperadora(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    FatoresExogenos(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    potencialmenteValidas(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    TotalImagensAmostra(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    ResponsbilidadeOperadora_Ex(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    FatoresExogenos_Ex(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    InvalidacaoImagemTipoErro_Ex(mesAmostra, anoAmostra, EditalLotePNCVSelecionado, UFSelecionada, rodoviaSelecionada, EditalPNCVSelecionado);
    potencialmenteValidas_Ex(anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    RankProcesso(mesAmostra, anoAmostra, EditalPNCVSelecionado);
}

function RegistroInfracao(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado) {
    document.getElementById("Aba").value = "RegistroInfracao";
    ImagensValidasTipoEquipamento(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    TempoEnvioSIOR(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
    tableEquipamentoInfracao(mesAmostra, anoAmostra, UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado);
}

function EME(UFSelecionada, rodoviaSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, mesAmostra, mesAmostra, LoteSelecionado) {
    document.getElementById("Aba").value = "EME";
    RelatorioME_Lote(UFSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, LoteSelecionado);
    RelatorioME_SR(UFSelecionada, EditalLotePNCVSelecionado, EditalPNCVSelecionado, LoteSelecionado);
}