//######################################################################################################################################################################################################################## 
//# DNIT
//# configuracaoView.js
//# Desenvolvedor:Jordana ALencar
//# Data: 17/12/2019
//########################################################################################################################################################################################################################
$().ready(function () {
    returnCheckConfiguracao();
    //--------------------------------------------------------------------------
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
});
//--------------------------------------------------------------------------
function returnCheckConfiguracao() {

    $.ajax({
        url: base_url + 'index_cgop.php/returnCheckConfiguracaoDaq',
        type: 'POST',
        dataType: 'json',
        success: function (data) {

           
            $("#tituloConfiguracao").text(data.programa)
            $("#objetoContratoConfig").text(data.objeto_contratacao)

            if (data.justificativa == 1) {
//                document.getElementById("checkJustificativa").classList = 'badge badge-success';
                $('#checkJustificativa').addClass('badge badge-success');
            } else {
//                document.getElementById("checkJustificativa").classList = 'badge badge-secondary';
                $('#checkJustificativa').addClass('badge badge-secondary');
            }

            if (data.MapaSituacao == 1) {
//                document.getElementById("checkMapaSituacao").classList = 'badge badge-success';
                $('#checkMapaSituacao').addClass('badge badge-success');
            } else  {
//                document.getElementById("checkMapaSituacao").classList = 'badge badge-secondary';
                $('#checkMapaSituacao').addClass('badge badge-secondary');
            }
             
             if (data.georreferenciados == 1) {
//                document.getElementById("checkGeorreferenciamento").classList = 'badge badge-success';
                $('#checkGeorreferenciamento').addClass('badge badge-success');
            } else {
//                document.getElementById("checkGeorreferenciamento").classList = 'badge badge-secondary';
                $('#checkGeorreferenciamento').addClass('badge badge-secondary');
            }

             if (data.PontoPassagem == 1) {
//                document.getElementById("checkPontoPassagem").classList = 'badge badge-success';
                $('#checkPontoPassagem').addClass('badge badge-success');
            } else   {
//                document.getElementById("checkPontoPassagem").classList = 'badge badge-secondary';
                $('#checkPontoPassagem').addClass('badge badge-secondary');
            }

            if (data.Ocorrencia == 1) {
//                document.getElementById("checkDiagramaOcorrencia").classList = 'badge badge-success';
                $('#checkDiagramaOcorrencia').addClass('badge badge-success');
            } else  {
//                document.getElementById("checkDiagramaOcorrencia").classList = 'badge badge-secondary';
                $('#checkDiagramaOcorrencia').addClass('badge badge-secondary');
            }

            if (data.Diagramas == 1) {
//                document.getElementById("checkDiagramaPontoPassagem").classList = 'badge badge-success';
                $('#checkDiagramaPontoPassagem').addClass('badge badge-success');
            } else  {
//                document.getElementById("checkDiagramaPontoPassagem").classList = 'badge badge-secondary';
                $('#checkDiagramaPontoPassagem').addClass('badge badge-secondary');
            }


            if (data.ART == 1) {
//                document.getElementById("checkART").classList = 'badge badge-success';
                $('#checkART').addClass('badge badge-success');
            } else{
//                document.getElementById("checkART").classList = 'badge badge-secondary';
                $('#checkART').addClass('badge badge-secondary');
            }

            if (data.PortariasFiscais == 1) {
//                document.getElementById("checkPortariasFiscais").classList = 'badge badge-success';
                $('#checkPortariasFiscais').addClass('badge badge-success');
            } else {
//                document.getElementById("checkPortariasFiscais").classList = 'badge badge-secondary';
                $('#checkPortariasFiscais').addClass('badge badge-secondary');
            }

        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}
