$().ready(function () {
	$.ajaxSetup({ cache: false });
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaRelatorioMensalDragagem(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/RelatorioMensalDragagemDaq").slideUp(3).delay(3).fadeIn("slow");
}
