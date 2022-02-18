
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {

    //Apresentação Supervisora table Responsavel Tecnico--------------------------------------------------------
    $('#tableWorkshop').dataTable({
        "bProcessing": false,
        "bFilter": true,
        "bInfo": true,
        "bLengthChange": true,
        "bPaginate": true,
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
        "sAjaxSource": "workshop/workshop/Tableworkshop",
        "aoColumns": [
            {data: 'NOME'},
            {data: 'EMAIL'},
            {data: 'TELEFONE'},
            {data: 'ORGAO'}
        ]
    });

});



function gravaWorkshop() {

    var serializedData = new FormData();
    serializedData = $("#formularioWorkshop").serializeArray();

    //bootbox.confirm("Confima operação [INSERIR RESPONSÁVEL TÉCNICO]?", function (result) {
     //   if (result === true) {
            $.ajax({
                type: 'POST',
                url: 'workshop/workshop/insereWorkshop',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $.notify('Cadastrado com sucesso!', "success");
                    var tblWorkshop = $("#tableWorkshop").DataTable();
                    tblWorkshop.ajax.reload();
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                    console.log(data);
                }
            });
     //   }
    //});
}