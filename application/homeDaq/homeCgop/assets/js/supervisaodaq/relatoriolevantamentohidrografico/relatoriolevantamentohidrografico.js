$().ready(function () {
	$.ajaxSetup({ cache: false });
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaRelatorioLevantamentoHidrografico(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/RelatorioLevantamentoHidrograficoDaq").slideUp(3).delay(3).fadeIn("slow");
}
