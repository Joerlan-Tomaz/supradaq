//######################################################################################################################################################################################## 
//# DNIT
//# anexos.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 19/02/2020 
//########################################################################################################################################################################################
$().ready(function () {
   $.ajaxSetup({ cache: false });
});
//------------------------------------------------------------------

function rotaAnexosDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/AnexosHomeDaq").slideUp(3).delay(3).fadeIn("slow");
    //$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}