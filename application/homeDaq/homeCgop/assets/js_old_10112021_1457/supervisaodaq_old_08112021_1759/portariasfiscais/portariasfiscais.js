function rotaPortariasFiscaisDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/PortariaFiscalDaq").slideUp(3).delay(3).fadeIn("slow");
}
