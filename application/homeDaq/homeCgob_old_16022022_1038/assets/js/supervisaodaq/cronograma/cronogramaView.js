$().ready(function () {
    returncheckCronogramas();
});
//--------------------------------------------------------------------------------------------------------------------------------------
function returncheckCronogramas() {
    $.ajax({
        url: base_url + 'index_cgob.php/returnCheckCronogramasDaq',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.cronograma_financeiro_obra == 1) {
//                document.getElementById("checkCronograma_financeiro_obra").classList = 'badge badge-success';
                $('#checkCronograma_financeiro_obra').addClass('badge badge-success');
            } else {
//                document.getElementById("checkCronograma_financeiro_obra").classList = 'badge badge-secondary';
                $('#checkCronograma_financeiro_obra').addClass('badge badge-secondary');
            }

            if (data.cronograma_fisico == 1) {
//                document.getElementById("checkCronograma_fisico_aquaviario").classList = 'badge badge-success';
                $('#checkCronograma_fisico_aquaviario').addClass('badge badge-success');
            } else {
//                document.getElementById("checkCronograma_fisico_aquaviario").classList = 'badge badge-secondary';
                $('#checkCronograma_fisico_aquaviario').addClass('badge badge-secondary');
            }
         
        }, error: function (data) {
            $.notify('Falha na consulta do cronograma', "warning");
        }
    });
}
