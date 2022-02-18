function insertInTable(table, dados, columns) {
    $(table + 'tbody').empty();
    $(table).DataTable({
        "destroy": true,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "scrollX": true,
        "autoWidth": true,
        "scrollCollapse": true,
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
        data: dados,
        "aoColumns": columns
    });
}
