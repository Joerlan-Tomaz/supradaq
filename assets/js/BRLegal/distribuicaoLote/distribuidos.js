var id_usuario = '';
var dadosContratoUser;
var codigoContrato;
$(document).ready(function () {
    readContratoUser()
})

function readContratoUser(value) {
    $.ajax({
        type: 'POST',
        url: 'readDistribuidos',
        dataType: 'json',
        data: {CodigoContratoUsuario: value},
        success: function (data) {
            var columns = [
                {data: 'Contrato'},
                {data: 'LoteLicitacao'},
                {data: 'TipoContrato'},
                {data: 'NomeUsuario'},
                {data: 'Email'},
                {data: 'btnUpdate'}
            ]
            insertInTable('#tableUserContrato', data, columns)
        }
    });
}

function insertSelectContrato() {
    $("#selectContrato").val(codigoContrato);
}

function readContratoUserID(value) {
    $.ajax({
        type: 'POST',
        url: 'readDistribuidos',
        dataType: 'json',
        data: {CodigoContratoUsuario: value},
        success: function (data) {
            codigoContrato = data[0].CodigoContrato;
            id_usuario = data[0].CodigoContratoUsuario;
            $("#nomeUsuario").val(data[0].NomeUsuario);
            $("#emailUsuario").val(data[0].Email);
            $("#ContratoUsuario").val(data[0].CodigoContrato);
            $("#selectTipoContrato").val(data[0].CodigoTipoContrato);
            readTipoContratos(data[0].CodigoTipoContrato)
            setTimeout("insertSelectContrato()", 1000)
        }
    });
}

function modal(codigoContrato, codigoTipoContato, codigoUsuario) {
    $('#modalDetails').modal();
    readDistribuidosRodoviaDetails(codigoContrato, codigoTipoContato)
    readDistribuidosSNVDetails(codigoContrato, codigoTipoContato)
    readContratoUserID(codigoUsuario)
}

function readDistribuidosSNVDetails(value, value2) {
    $.ajax({
        type: 'POST',
        url: 'readDistribuidosSNVDetails',
        dataType: 'json',
        data: {CodigoContrato: value, CodigoTipoContrato: value2},
        success: function (data) {
            var columns = [
                {data: 'UF'},
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'TrechoInicial'},
                {data: 'TrechoFinal'},
                {data: 'KmInicial'},
                {data: 'KmFinal'},
                {data: 'Extensao'}
            ]
            insertInTable('#tableTrechoUser', data, columns)
        }
    });
}

function readDistribuidosRodoviaDetails(value, value2) {

    $.ajax({
        type: 'POST',
        url: 'readDistribuidosRodoviaDetails',
        dataType: 'json',
        data: {CodigoContrato: value, CodigoTipoContrato: value2},
        success: function (data) {
            console.log(data)
            var columns = [
                {data: 'UF'},
                {data: 'Rodovia'},
                {data: 'Extensao'}
            ]
            insertInTable('#tableRodoviaUser', data, columns)
        },
        error: function (data) {
            console.error(data);
        }
    });
}

function readTipoContratos(value) {
    $("#selectContrato").empty();
    $.ajax({
        type: 'POST',
        url: 'readTipoContrato',
        dataType: 'json',
        data: {tipo: value},
        success: function (data) {
            $("#selectContrato").append('<option value="">Selecione um contrato</option>')
            for (var i = 0; i < data.length; i++) {
                var dados = data[i];
                $("#selectContrato").append('<option value="' + dados.CodigoContrato + '">' + dados.Contrato + '</option>')
            }
        }
    });
}

function save() {
    var codigoContrato = $("#selectContrato").val();
    var nomeUsuario = $("#nomeUsuario").val();
    var emailUsuario = $("#emailUsuario").val();
    $.ajax({
        type: 'POST',
        url: 'update',
        dataType: 'json',
        data: {
            CodigoContrato: codigoContrato,
            NomeUsuario: nomeUsuario,
            Email: emailUsuario,
            CodigoContratoUsuario: id_usuario
        },
        success: function (data) {
            alert(data.message)
            $('#modalDetails').modal('hide');
        }
    });
}

function deleteNow() {
    var r = confirm("Deseja realmente excluir?");
    if (r == true) {
        $.ajax({
            type: 'POST',
            url: "delete",
            data: {CodigoContratoUsuario: id_usuario},
            dataType: "json",
            success: function (data) {
                alert(data.message)
                $('#modalDetails').modal('hide');
            },
            error: function (data) {
                console.error(data);
            }
        });
    }

}

