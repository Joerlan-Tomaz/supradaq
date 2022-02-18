$().ready(function () {
         $.ajaxSetup({ cache: false });
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function rotaRelatorioDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/RelatorioImprimirHomeDaq").slideUp(3).delay(3).fadeIn("slow");

}
