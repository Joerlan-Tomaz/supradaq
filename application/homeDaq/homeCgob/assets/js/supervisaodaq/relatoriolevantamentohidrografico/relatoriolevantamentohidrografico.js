$().ready(function () {
	$.ajaxSetup({ cache: false });
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaRelatorioLevantamentoHidrografico(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgob.php/RelatorioLevantamentoHidrograficoDaq").slideUp(3).delay(3).fadeIn("slow");
}
