//######################################################################################################################################################################################## 
//# DNIT
//# conclusaogeral.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 19/02/2020 09:59
//########################################################################################################################################################################################
$().ready(function () {
   $.ajaxSetup({ cache: false });
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaConclusaoGeralDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgob.php/ConclusaoGeralDaq").slideUp(3).delay(3).fadeIn("slow");
    //$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}