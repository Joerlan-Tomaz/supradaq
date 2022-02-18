//------------------------------------------------------------------------------
$(document).ready(function (){
    $('#table_supervisora').dataTable({
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
        "sAjaxSource": base_url + "/homeDaq/PainelAdm/NovaSupervisora/NovaSupervisora/RecuperaSupervisora",
        "aoColumns": [
            {data: 'id_supervisora', "sClass": "text-center"},
            {data: 'nome_supervisora', "sClass": "text-center"},
            {data: 'data_criacao', "sClass": "text-center"},
        ]
    });
});

//------------------------------------------------------------------------------
function insereNovasupervisora() {
    var nome_novaSupervisora = $("#nome_novaSupervisora").val();
    if (nome_novaSupervisora == "") {
        $.notify("Informe o nome da nova supervisora!", "warning");
        document.getElementById("nome_novaSupervisora").style.borderColor = 'red';
        return false;
    }
    document.getElementById("nome_novaSupervisora").style.borderColor = '#d2d6de';
    bootbox.confirm("Confirmar operação [INSERIR NOVA SUPERVISORA]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + "homeDaq/PainelAdm/NovaSupervisora/NovaSupervisora/insereNovasupervisora",
                data: {nome_novaSupervisora: nome_novaSupervisora},
                dataType: 'json',
                success: function (data) {
                    $.notify('Nova Supervisora Cadastrada!', "success");
                    $("#nome_novaSupervisora").val("");
                    var table = $("#table_supervisora").DataTable();
                    table.ajax.reload();
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                }
            });
        }
    });
}
