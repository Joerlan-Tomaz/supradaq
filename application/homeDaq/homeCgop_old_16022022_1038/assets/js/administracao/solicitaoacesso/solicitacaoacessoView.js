//------------------------------------------------------------------------------
$(document).ready(function (){
    $('#table_solicitacao_acesso').dataTable({
        "bProcessing": false,
        "pageLength": 10,
        "destroy": true,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/solicitacaoacesso_table_solicitacao_acesso",
        "aoColumns": [
            {data: 'nome', "sClass": "text-center"},
            {data: 'email', "sClass": "text-center"},
            {data: 'empresa', "sClass": "text-center"},
            {data: 'cpf', "sClass": "text-center"},
            {data: 'telefone', "sClass": "text-center"},
            {data: 'coordenacao', "sClass": "text-center"},
            {data: 'uf', "sClass": "text-center"},
            {data: 'motivacao', "sClass": "text-center"},
            {data: 'acao', "sClass": "text-center"},
        ]
    });
});

function modal_motivacao_acesso(motivacao) {
    $("#modal_motivacao_acesso").modal("show");
    $("#descricao_motivacao_acesso").text(motivacao);
}

function insereUsuario(id, nome, email, empresa, cpf, telefone, coordenacao, id_uf) {     
    bootbox.confirm("Confirmar operação [ACEITAR SOLICITAÇÃO DE ACESSO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + "index_cgop.php/solicitacaoacesso_insereUsuario",
                data: {
                    id: id,
                    nome: nome,
                    email: email,
                    empresa: empresa,
                    cpf: cpf,
                    telefone: telefone,
                    coordenacao: coordenacao,
                    id_uf: id_uf              
                },
                dataType: 'json',
                success: function (data) {
                    $.notify('Solicitação Aceita!', "success");
                    var table = $("#table_solicitacao_acesso").DataTable();
                    table.ajax.reload();
                }, error: function (data) {
                    $.notify('Falha ao inserir o usuário!', "warning");
                }
            });
        }
    });
}

//------------------------------------------------------------------------------
function negaSolicitacao(id) {
    bootbox.confirm("Confirmar operação [NEGAR SOLICITAÇÃO DE ACESSO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + "index_cgop.php/solicitacaoacesso_negaSolicitacao",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    $.notify('Solicitação Negada!', "warning");
                    var table = $("#table_solicitacao_acesso").DataTable();
                    table.ajax.reload();
                }, error: function (data) {
                    $.notify('Falha ao negar a solicitação!', "warning");
                }
            });
        }
    });
}
