//######################################################################################################################################################################################## 
//# DNIT
//# paineladm.js
//# Desenvolvedor:Eduardo Rocha Vargas
//# Data: 09/09/2020 
//########################################################################################################################################################################################
$().ready(function () {
    $.ajaxSetup({ cache: false });
 });
 
function rotaSolicitacaoAcesso(){
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/PainelAdm/Solitacaoacesso/SolitacaoAcesso/mostraViewSolicitacaoAcesso").slideUp(3).delay(3).fadeIn("slow");
}

function rotaAtualizaSupPerfilPermissao(){
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissao/mostraViewAtualizaSupPerfilPermissao").slideUp(3).delay(3).fadeIn("slow");
}

function rotaAtualizaPerfil(){
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfil/mostraViewPerfil").slideUp(3).delay(3).fadeIn("slow");
}

function rotaNovaSupervisora(){
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/PainelAdm/NovaSupervisora/NovaSupervisora/mostraViewNovaSupervisora").slideUp(3).delay(3).fadeIn("slow");
}

function rotaRelacionarGrupoContrato(){
    $("#exibesupervisaocont").empty();
    $("#exibesupervisaocont").load(base_url + "index_cgop.php/PainelAdm/RelacionaGrupoContrato/RelacionaGrupoContrato/mostraViewRelacionaGrupoContrato").slideUp(3).delay(3).fadeIn("slow");
}

// function rotaRelacaoContratoUsuario(){
//     $("#exibesupervisaocont").empty();
//     $("#exibesupervisaocont").load("homeDaq/PainelAdm/NovaSupervisora/NovaSupervisora/mostraViewNovaSupervisora").slideUp(3).delay(3).fadeIn("slow");
// }
