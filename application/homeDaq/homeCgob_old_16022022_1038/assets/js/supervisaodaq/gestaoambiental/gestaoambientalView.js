//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana
//# Data: 20/12/2019
//########################################################################################################################################################################################################################

$().ready(function () {
    confereGestaoAmbiental();

});
//--------------------------------------------------------------------------------------------------------------------------------------
function confereGestaoAmbiental() {
    $.ajax({
        url: base_url + 'index_cgob.php/returnCheckGestaoAmbientalDaq',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            
            if (data.licenca_ambiental == '1') {
                document.getElementById("checkLicencaAmbiental").classList = 'badge badge-success';
            } else {
                document.getElementById("checkLicencaAmbiental").classList = 'badge badge-secondary';
            }
            if (data.pba_pbai == '1') {
                document.getElementById("checkPBAPBAI").classList = 'badge badge-success';
            } else {
                document.getElementById("checkPBAPBAI").classList = 'badge badge-secondary';
            }
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}