//######################################################################################################################################################################################## 
//# DNIT
//# apresentacaosupervisora.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 01/07/2020 
//########################################################################################################################################################################################
$().ready(function () {
   $.ajaxSetup({ cache: false });
});
//------------------------------------------------------------------
function rotaApresentacaoSupervisoraDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgob.php/ApresentacaoSupervisoraDaq").slideUp(3).delay(3).fadeIn("slow");
    //$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}