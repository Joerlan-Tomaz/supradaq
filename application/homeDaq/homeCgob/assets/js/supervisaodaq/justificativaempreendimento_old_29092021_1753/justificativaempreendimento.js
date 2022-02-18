function rotaJustificativaEmpreendimentoDaq(){ 
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgob.php/JustificativaDaq").slideUp(3).delay(3).fadeIn("slow");
}
