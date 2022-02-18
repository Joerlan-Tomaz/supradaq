
$(document).ready(function () {
    //---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    $('#table_contrato_supervisao').dataTable({
        "bProcessing": true,
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
        "sAjaxSource": base_url + "index_cgob.php/TabelaContratoDaq",
        
        "aoColumns": [
            {data: 'CONTRATO'},
            {data: 'SUPERVISORA'},
            {data: 'BRUF'},
            {data: 'STATUS'}
        ]
    });

});