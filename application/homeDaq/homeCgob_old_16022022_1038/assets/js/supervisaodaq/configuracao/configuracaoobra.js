//######################################################################################################################################################################################## 
//# DNIT
//# configuracaoobra.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 01/07/2020 
//########################################################################################################################################################################################
$().ready(function () {
   $.ajaxSetup({ cache: false });
});

function rotaConfiguracaoObraDaq(){
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgob.php/ConfiguracaoObraDaq").slideUp(3).delay(3).fadeIn("slow");
}