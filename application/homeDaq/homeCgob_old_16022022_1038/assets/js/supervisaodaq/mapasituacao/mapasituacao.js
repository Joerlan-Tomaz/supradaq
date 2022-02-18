function rotaMapaSituacaoDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgob.php/MapaSituacaoDaq").slideUp(3).delay(3).fadeIn("slow");
}
