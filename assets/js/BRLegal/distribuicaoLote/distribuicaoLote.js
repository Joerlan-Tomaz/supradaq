var codigoExclusao;
var codUpdate;
var params = [];
var id_usuario = 0;
$(document).ready(function () {
    var optContrato = $("input[name='optContrato']:checked").val();
    console.log(optContrato)
})


function readPaging(dataContratos) {
    $('#tblContratos').DataTable({
        "destroy": true,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "language": {
            "emptyTable": "Nenhum registro encontrado"
        },
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
        },
        data: dataContratos,
        "aoColumns": [
            {data: 'UF'},
            {data: 'Rodovia'},
            {data: 'SNV'},
            {data: 'TrechoInicial'},
            {data: 'TrechoFinal'},
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
            {data: 'ContratoSupervisao'},
            {data: 'LoteSupervisao'},
            {data: 'ContratoExecucao'},
            {data: 'LoteExecucao'}

        ]
    });
}

function modalCreate() {
    $('#modalCreate').modal();
    $('#search').focus();
}

function readUser(value) {
    $("#selectUserSupra").empty();
    $.ajax({
        type: 'POST',
        url: 'DistribuicaoLote/readUser',
        dataType: 'json',
        data: {nome: value},
        success: function (data) {
            $("#divSelectUserSupra").css("display", "block")
            $("#selectUserSupra").append('<option value="">Selecione um usuário</option>')
            for (var i = 0; i < data.length; i++) {
                var dados = data[i];
                $("#selectUserSupra").append('<option value="' + dados.id_usuario + '">' + dados.DESC_NOME + '  (' + dados.EMAIL + ')</option>')
            }
        }
    });
}

function selectUser(value) {
    id_usuario = value;
    if (value != '')
        $("#formCadDistribuicao").css("display", "block")
    console.log(id_usuario)
}

function readTipoContratos(value) {
    $("#selectContrato").empty();
    $.ajax({
        type: 'POST',
        url: 'DistribuicaoLote/readTipoContrato',
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
    $.ajax({
        type: 'POST',
        url: 'DistribuicaoLote/save',
        dataType: 'json',
        data: {
            CodigoContrato: codigoContrato,
            CodigoUsuarioSupra: id_usuario
        },
        success: function (data) {
            alert(data.message)
             $('#modalCreate').modal('hide');
        }
    });
}

function create() {
    save($('#formCreate'), site_url + "/BRLegal/BRLegal2/Contrato/Home/save", $('#modalCreate'));
}

function modalUpdate(CodContrato) {
    codUpdate = CodContrato;
    $('#divFormUpdate').load('edit', {CodigoContrato: CodContrato}, function (result) {
        $('#modalUpdate').modal();
    });
    $('#searchContratoSIAC').focus();
}

function update() {
    //console.log($('#formUpdate').serializeArray());
    save($('#formUpdate'), site_url + "/BRLegal/BRLegal2/Contrato/Home/update", $('#modalUpdate'));
}

function modalDelete(param) {
    codigoExclusao = param;
    $('#modalDelete').modal();
}

function readOneContratoSIAC(searchSKContrato, form, div, action) {

    params = $(form).serializeArray();
    params.push({index: 0, name: 'SKContrato', value: searchSKContrato});

    $(div).load(action, params);
}

function buscaCEP() {
    buscaCEPCorreios($("[name='dataEmpresa[CEP]']"), $("[name='dataEmpresa[Logradouro]']"),
            $("[name='dataEmpresa[Municipio]']"), $("[name='dataEmpresa[Bairro]']"),
            $("[name='dataEmpresa[SgUF]']"));
}

function deleteNow() {
    $.ajax({
        type: 'POST',
        url: site_url + "/BRLegal/BRLegal2/Contrato/Home/delete",
        data: {CodigoContrato: codigoExclusao},
        dataType: "json",
        success: function (data) {
            $('#modalDelete').modal('hide');
            readPaging(JSON.parse(data.dataContratos));
            $.notify(data.message, data.msgClass);
        },
        error: function (data) {
            console.error(data);
        }
    });
}

