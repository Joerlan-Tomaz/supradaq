var setSNVArr = new Array();
var codSNVArr = new Array();
var checksAtivo = false;
var totalRegistrosSNV = 0;
var percentSelecionado = 0;
var extensaoEntregue = 0;



function setSNV(param, CodSNV) {
    $('#select_' + param).val(1);
    $('#select_' + param).removeClass("selec")
    $('#select_' + param).next('span').remove();
    if (setSNVArr.indexOf(param) > -1) {
        removeArr(setSNVArr, param);
        $('#select_' + param).val(0);
    } else {
        setSNVArr.push(param);
    }
    sumSNVSelecionado()
    if (codSNVArr.indexOf(CodSNV) > -1) {
        removeArr(codSNVArr, CodSNV);
    } else {
        codSNVArr.push(CodSNV);
    }
    console.log(setSNVArr)
}

function removeArr(arr) {
    var what, a = arguments,
            L = a.length,
            ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax = arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function buscaIdsSNV() {
    $.ajax({
        type: 'POST',
        url: "readSNVID",
        data: {UF: UF, Rodovia: Rodovia, CodigoContratoSupervisao: CodigoContratoSupervisao},
        dataType: "json",
        success: function (data) {
            totalRegistrosSNV = data.length;
            for (i = 0; i < data.length; i++) {
                var codigo = data[i];
                if (setSNVArr.indexOf(codigo.CodigoSNVEdital) > -1) {
                    removeArr(setSNVArr, codigo.CodigoSNVEdital.toString());
                } else {
                    setSNVArr.push(codigo.CodigoSNVEdital.toString());
                    $('#select_' + codigo.CodigoSNVEdital).val(1);
                }
            }
            sumSNVSelecionado();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function buscaSNVCadastrados() {
    $.ajax({
        type: 'POST',
        url: "getSNVEntrega",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            setSNVArr = [];
            for (var i = 0; i < data.length; i++) {
                var v = data[i];
                $("#select_" + v.CodigoSNVEdital).val(v.CodigoEntregaIntersecoes);
                if (v.CodigoEntregaIntersecoes == 1) {
                    $("#Check" + v.CodigoSNVEdital).prop("checked", true);
                    setSNVArr.push(v.CodigoSNVEdital.toString())
                }
            }
            sumSNVSelecionado()
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function setAllSNV() {
    if (checksAtivo == false) {
        $('.Check').each(
                function () {
                    if ($(this).prop("checked", false))
                        $(this).prop("checked", true);
                }
        );
        checksAtivo = true;
        setSNVArr = [];
        buscaIdsSNV()
    } else {
        $('.Check').each(
                function () {
                    if ($(this).prop("checked"))
                        $(this).prop("checked", false);
                }
        );
        checksAtivo = false;
        setSNVArr = [];
        sumSNVSelecionado()
        $("#textSumSNV").text(" - 0 km")
    }
}

function setIntervencao(param) {
    codigoIntervencao = $("#select_" + param).val();
    if (codigoIntervencao == '1') {
        $("#Check" + param).prop("checked", true);
    } else {
        $("#Check" + param).prop("checked", false);
    }
}

function sumSNVSelecionado() {
    if (setSNVArr.length != 0) {
        $.ajax({
            type: 'POST',
            url: "countSNVSelecionado",
            data: {
                id: setSNVArr
            },
            dataType: "json",
            success: function (data) {
                $("#textSumSNV").text(" -  Extensão selecionada: " + data[0].somaExtensao + " km")
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}

function salvarEntregSNV() {
    var pushSNV = Object();
    if (setSNVArr.length == 0) {
        alert("nenhum snv foi selecionado!")
    } else {
        for (var i = 0; i < arrayCodigoSNVEdital.length; i++) {
            var select = $('#select_' + arrayCodigoSNVEdital[i]).val();
            if (select == 0) {
                $('#select_' + arrayCodigoSNVEdital[i]).next('span').remove();
                $('#select_' + arrayCodigoSNVEdital[i]).addClass("selec")
                $('#select_' + arrayCodigoSNVEdital[i]).after("<span style='font-size:9pt; color:red'>* obrigatório</span>")
            } else {
                $('#select_' + arrayCodigoSNVEdital[i]).removeClass("selec")
                $('#select_' + arrayCodigoSNVEdital[i]).next('span').remove();
                pushSNV[i] = {
                    CodigoSNVEdital: arrayCodigoSNVEdital[i],
                    CodigoEntregaIntersecoes: select
                }

            }
        }
    }
    if (arrayCodigoSNVEdital.length == Object.keys(pushSNV).length) {
        $.ajax({
            type: 'POST',
            url: "insertSNVEntregaSNV",
            data: {
                snv: pushSNV,
                UF: UF,
                Rodovia: Rodovia,
                CodigoContratoSupervisao: CodigoContratoSupervisao,
                CodigoEntrega: CodigoEntrega
            },
            dataType: "json",
            success: function (data) {
                alert(data)
            },
            error: function (data) {
                console.log(data);
            }
        });
    } else {
        alert("Preencha todos os campos de intervenções")
    }

}
