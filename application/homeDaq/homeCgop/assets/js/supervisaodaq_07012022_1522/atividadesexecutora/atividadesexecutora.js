//######################################################################################################################################################################################## 
//# DNIT
//# atividadeconstrutora.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 01/07/2020 
//########################################################################################################################################################################################
$().ready(function () {
   $.ajaxSetup({ cache: false });
});
//------------------------------------------------------------------
function rotaAtividadeExecutoraOperacaoDaq(){
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/AtividadeExecutoraOperacaoDaq").slideUp(3).delay(3).fadeIn("slow");
    //$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}

function rotaAtividadeExecutoraManutencaoDaq(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/AtividadeExecutoraManutencaoDaq").slideUp(3).delay(3).fadeIn("slow");
	//$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}

function rotaAtividadeExecutoraRegularizacaoDaq(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/AtividadeExecutoraRegularizacaoDaq").slideUp(3).delay(3).fadeIn("slow");
	//$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}

function rotaAtividadeExecutoraAssessoramentoDaq(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/AtividadeExecutoraAssessoramentoDaq").slideUp(3).delay(3).fadeIn("slow");
	//$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}

function rotaConformidadeDosProdutosEntreguesDaq(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/ConformidadeDosProdutosEntreguesDaq").slideUp(3).delay(3).fadeIn("slow");
	//$( "body" ).addClass( "sidebar-mini sidebar-collapse" );
}
