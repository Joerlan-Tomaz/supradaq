$().ready(function () {
	$.ajaxSetup({ cache: false });
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaBoletimSemanalDragagem(){
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgop.php/BoletimSemanalDragagemDaq").slideUp(3).delay(3).fadeIn("slow");
}
