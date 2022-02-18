var inputPDF = '';
var dataTable = '';
var tblBD = '';

$(document).ready(function () {
    nextFocus('2')
})

function nextFocus(load) {
    var rota = '';
    if (load == '2')
        rota = "CadastroEntregas/readCadastroSNV?uf=" + UF + "&rodovia=" + Rodovia + "&CodigoContrato=" + CodigoContratoSupervisao;
    if (load == '3')
        rota = "CadastroEntregasEstudoPreliminares/readCadastroEstudoPreliminares?CodigoEntrega=" + CodigoEntrega;
    if (load == '4')
        rota = "CadastroEntregasProjetoExecucao/readProjetoExecucao?CodigoEntrega=" + CodigoEntrega;
    if (load == '5')
        rota = "CadastroEntregasDetalhamento/readDetalhamento?CodigoEntrega=" + CodigoEntrega;
    if (load == '6')
        rota = "CadastroEntregasPranchas/readCadastroPranchas?CodigoEntrega=" + CodigoEntrega;

    var guiaPagina = $('#guia').find('.bg-success');
    guiaPagina.removeClass('bg-success');
    $('#b_' + load).addClass('bg-success');
    $("#includ").load(base_url + "homeCgmrr/BRLegal/" + rota)
}

function importPDF(input, tbl) {
    inputPDF = input;
    tblBD = tbl;
    var file = _(input).files[0];
    var fileZise = _(input).files[0].size;
    if (fileZise > 20971520) {
        alert("Tamanho do arquivo não permitido!");
    } else {
        var formData = new FormData();
        formData.append("file", file);
        formData.append("tbl", tbl);
        formData.append("codigoEntrega", CodigoEntrega);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", base_url + "homeCgmrr/BRLegal/CadastroEntregasUploads/importPDF");
        ajax.send(formData);
    }
}

function progressHandler(event) {
    $("#progressBarEP" + inputPDF).css('display', 'block')
    var percent = (event.loaded / event.total) * 100;
    _("progressBarEP" + inputPDF).value = Math.round(percent)
    _("txtImportar" + inputPDF).innerHTML = "Aguarde ..."
}
function completeHandler(event) {
    _("progressBarEP" + inputPDF).value = 0;
    _("txtImportar" + inputPDF).innerHTML = event.target.responseText;
     readListPDF(tblBD,dataTable);
    $("#progressBarEP" + inputPDF).css('display', 'none')
}
function errorHandler(event) {
    _("txtImportar" + inputPDF).innerHTML = event.target.responseText;
    _("progressBarEP" + inputPDF).value = 0
}
function abortHandler(event) {
    _("txtImportar" + inputPDF).innerHTML = "Cancelado!"
}

function previewPDF(img) {
    varWindow = window.open(
            base_url + 'homeCgmrr/BRLegal/CadastroEntregasUploads/readPreviewPDF?img='+img,
            'pagina',
            "width=1000, height=1000, top=10, left=50, scrollbars=no ");
}

function readListPDF(tbl, dt) {
    dataTable = dt;
    $("#" + dataTable).empty();
    $(".demo1").empty();
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasUploads/getListPDF",
        data: {CodigoEntrega: CodigoEntrega, tbl: tbl},
        dataType: "json",
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                var cod = data[i];
                var item = '<tr>';
                item += '<td><i class="fas fa-file-pdf"></i></td>';
                item += '<td>' + cod.DataArquivoF + '</td>';
                item += '<td><i style="cursor: zoom-in" onclick="previewPDF(\'' + cod.Arquivo + '\')" class="fas fa-eye"></i></td>';
                item += '<td><i onclick="deletePDF(\'' + cod.Arquivo + '\',\'' + tbl + '\')" class="fas fa-trash-alt"></i></td> ';
                item += '</tr>';
                $("#" + dataTable).append(item);
            }
//            if (data.length >= 1) {
//                $(".demo1").append("<i class='fas fa-check'></i>")
//            } else {
//                $(".demo1").append("<i class='fas fa-times'></i>")
//            }
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function deletePDF(arquivo, tbl) {
    var r = confirm("Deseja realmente PDF?");
    if (r == true) {
        $.ajax({
            type: 'POST',
            url: base_url + "homeCgmrr/BRLegal/CadastroEntregasUploads/deletePDF",
            data: {Arquivo: arquivo, tbl: tbl},
            dataType: "json",
            success: function (data) {
                readListPDF(tbl,dataTable);
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
}

function deleteExcel(tbl) {
    var r = confirm("Deseja realmente os dados?");
    if (r == true) {
        $.ajax({
            type: 'POST',
            url: base_url + "homeCgmrr/BRLegal/CadastroEntregasUploads/deleteExcel",
            data: {CodigoEntrega: CodigoEntrega, tbl: tbl},
            dataType: "json",
            success: function (data) {
                location.reload()
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
}

function importarExcel(arquivo, tabela) {
    var form = new FormData();
    var xlsx = $('#' + arquivo)[0].files[0];
    form.append('xlsx', xlsx);
    form.append('tbl', tabela);
    form.append('CodigoEntrega', CodigoEntrega);
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasUploads/importarExcel",
        dataType: 'json',
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            alert(data)
        },
        error: function (data) {
            if(data.status){
                alert("Não foi possível importar o arquivo!, verique se está de acordo com o modelo.")
            }
            
        },
    });
}