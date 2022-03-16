$().ready(function () {
	$.ajaxSetup({ cache: false });
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaRelatorioMonitoramentoAmbiental(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/RelatorioMonitoramentoAmbientalDaq").slideUp(3).delay(3).fadeIn("slow");
}
