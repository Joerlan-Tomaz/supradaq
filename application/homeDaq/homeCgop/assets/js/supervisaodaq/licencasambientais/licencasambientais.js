//######################################################################################################################################################################################## 
//# DNIT
//# licencasambientais.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 01/07/2020 
//########################################################################################################################################################################################

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaLicencasAmbientaisDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/LicencasAmbientaisDaq").slideUp(3).delay(3).fadeIn("slow");
    //$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}