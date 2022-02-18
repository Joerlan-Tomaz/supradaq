/*
 * DNIT
 * SUPRA  
 * home - home.js
 * Programador: Sergio Ricardo
 * Data: 23/07/18 17:27
 */
//----------------------------------------------------------------------------------------------------------------------------------

$(document).ready(function () {

    $.ajax({
        method: "POST",
        url: base_url +'/Login/FotoMiniatura'
    }).done(function (resultado) {
        try {
            resultado = resultado.replace(/\+g/, " ");
            resultado = unescape(resultado);
            $('#fotoMiniatura').html(resultado);

        } catch (e) {
            $('#fotoMiniatura').html('<p>Ouve algum erro na requisição</p>');
        }
    });
    //----------------------------------------------------------------------------------------------------------------------------------	
    var horario = new Date();

    if ((horario.getHours() >= 01) && (horario.getHours() < 12)) {
        $('#turno').text('Bom dia, ');

    } else if ((horario.getHours() >= 12) && (horario.getHours() < 18)) {
        $('#turno').text('Boa tarde, ');

    } else if ((horario.getHours() >= 18) && (horario.getHours() < 20)) {
        $('#turno').text('Boa noite, ');

    } else if ((horario.getHours() >= 20) && (horario.getHours() < 23)) {
        $('#turno').text('Boa noite, ');

    } else {
        $('#turno').text('Bom dia, ');
    }

    $(window).scroll(function(){
        if ($(this).scrollTop() > 30) {
            $('.headerPrincipal').addClass('header-black');
        } else {
            $('.headerPrincipal').removeClass('header-black');
        }
    });

//-----------------------------------------------------------------------------------------------------------------------------------
//    var scroll_pos = 0;
//    $(document).scroll(function () {
//        scroll_pos = $(this).scrollTop();
//        if (scroll_pos > 80) {
//            $(".headerPrincipal").css('background-color', 'rgba(0,0,0,.5)');
//        } else {
//            $(".headerPrincipal").css('background-color', 'rgba(0,0,0,.2)');
//        }
//    });

    //-----------------------------------------------------------------------------------------------------------------------------------
    // alert('ola q tal 1');
    //$("#exibe").html("Este é o novo texto heehe!");
    // jQuery("#exibe").load( "/supra/app/home/index.php" ).slideUp( 3 ).delay( 3 ).fadeIn( "slow" ); 
    //jQuery("#exibe").load( "http://localhost:8080/Ci/application/views/home/index.php" ).slideUp( 3 ).delay( 3 ).fadeIn( "slow" ); 
    // $(".exibe").load( "<?php echo(base_url()).'application/views/home/index.php'?>" ).slideUp( 3 ).delay( 3 ).fadeIn( "slow" ); 
    // var site_url = "<?php echo base_url('application/home1'); ?>";
    // $("#exibe").load( site_url ).slideUp( 3 ).delay( 3 ).fadeIn( "slow" ); 
    // ("#exibe").load( "<?php echo base_url()."application/views/home/index.php";?>" ).slideUp( 3 ).delay( 3 ).fadeIn( "slow" ); 
    // $("#exibe").load("<?php $this->load->view('home/index'); ?>").slideUp(3).delay(3).fadeIn("slow");
    //$("#exibe").load("http://localhost:8080/Ci/application/views/home/index.php");
    //$("#exibe").load("http://localhost:8080/Ci/application/views/home/index.php");
    // $("#exibe").load("index.php/Application").slideUp(3).delay(3).fadeIn("slow");
    $("#exibe").load("Home/home").slideUp(3).delay(3).fadeIn("slow");
});

// function rotaDir() {
//     $.ajax({
//         url: 'http://localhost:8080/Ci/index.php/application/ajax_redirect',
//         type: 'POST',
//         data: {
//             location: 'index.php/application/homeDir'
//         }
//     });
// }

function rotaHome() { 
    $("#exibe").empty();
    $("#exibe").load("Home/home").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária');
}

function rotaPerfil() {
    $("#exibe").empty();
    $("#exibe").load("Home/homePerfil").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ PERFIL ]');
}

function rotaWorkShop() {
    $("#exibe").empty();
    $("#exibe").load("Home/workshop").slideUp(3).delay(3).fadeIn("slow");
}

function rotaCgcont() { 
    $("#exibe").empty();
    $("#exibe").load("Home/homeCgcont").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ CONSTRUÇÃO ]');
}

//Modulo antigo
function rota_Assessoria() { 
    $("#exibe").empty();
    $("#exibe").load("Home/homeAssessoria").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ ASSESSORIA ]');
   
}

function rota_Cgcont() { 
    $("#exibe").empty();
    $("#exibe").load(base_url + "index_cgcont.php/HomeCgcont/homeCgcont").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ CONSTRUÇÃO ]');
}

function rotaCgmrr() {
    $("#exibe").empty();
//    $("#exibe").load("HomeCgmrr/HomeCgmrr").slideUp(3).delay(3).fadeIn("slow");
    //$("#exibe").load(base_url + "index_cgmrr.php/homeCgmrr").slideUp(3).delay(3).fadeIn("slow");
    $("#exibe").load(base_url + "cgmrr/home").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ MANUTENÇÃO ]');
}

function rota_Cgmrr() {
    $("#exibe").empty();
    $("#exibe").load(base_url_cgmrr + "cgmrr/home").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ MANUTENÇÃO ]');
}

function rotaImr() {
    $("#exibe").empty();
    $("#exibe").load("homeImr/HomeImr").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ IMR ]');
}


//-------------------------------------------------------------------------------------------------

function alterarSenhaPrimeiroLogin() {
    if ($("#edtAtual").val() == "") {
        $.notify("Por favor, informe a senha atual", 'info');
        $("#edtAtual").focus();
        return false;
    } else if ($("#edtNova").val() == "") {
        $.notify("Por favor, informe sua nova senha", 'info');
        $("#edtNova").focus();
        return false;
    } else if ($("#edtConfirmar").val() == "") {
        $.notify("Por favor, confirme sua nova senha", 'info');
        $("#edtConfirmar").focus();
        return false;
    } else if ($("#edtConfirmar").val() !== $("#edtNova").val()) {
        $.notify("As senhas nao correspondem", 'info');
        document.getElementById('edtConfirmar').style.borderColor = 'red';
        document.getElementById('edtNova').style.borderColor = 'red';
        return false;
    }
    document.getElementById('edtConfirmar').style.borderColor = '#d2d6de';
    document.getElementById('edtNova').style.borderColor = '#d2d6de';
    //---------------- Validação de formulario ---------------------------------
    var serializedData = new FormData();
    serializedData = $("#formNovaSenhaPrimeiroLogin").serializeArray();
    //--------------------------------------------------------------------------
    bootbox.confirm("Confima operação [ALTERAR SENHA]?", function (result) {
        if (result == true) {
            $.ajax({
                type: 'POST',
                url: 'Login/alterasenha',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $.notify(data.mensagem, data.notify);
                    $("#alterasenhaModal").modal("hide");
                    window.location.reload()
                }, error: function (data) {

                }
            });
        }
    });
}

/**
 * GENTILEZA NAO MEXER NA ROTA DA CGPERT
 */
function rotaCgpert() {
    $("#exibe").empty();
    $("#exibe").load("homeCgpert/CgpertHome").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ OPERAÇÕES ]');
}

function rotaDir() {
    $("#exibe").empty();
    $("#exibe").load("Home/homeDir").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária - [ ASSESSORIA ]');
}

function rota_Dir() { 
    $("#exibe").empty();
    $("#exibe").load("Home/home_Dir").slideUp(3).delay(3).fadeIn("slow");
    $(".titulo-logo").text('Diretoria de Infraestrutura Rodoviária');
}
/*DIRETORIA DAQ-->Sergio Ricardo - 16/06/2021 13:42*/
function rota_Daq() { 
    $("#exibe").empty();
    $("#exibe").load(base_url + "index_cgob.php/Home/home_Daq").slideUp(3).delay(3).fadeIn("slow"); 
    $(".titulo-logo").text('Diretoria de Infraestrutura Aquaviária');
    
}
/*DIRETORIA DIF-->Sergio Ricardo - 04/08/2021 14:42*/
function rota_Dif() { 
    $("#exibe").empty();
    $("#exibe").load(base_url + "index_confer.php/Home/home_Dif").slideUp(3).delay(3).fadeIn("slow"); 
    $(".titulo-logo").text('Diretoria de Infraestrutura Ferroviária');
    
}


//Função para carregar a contagem de tráfego
function rotaContagem() {
    $("#exibe").empty();
    $("#exibe").load("homeCgpert/Contagem/ContagemTrafego/Contagem").slideUp(3).delay(3).fadeIn("slow");
}

//Função para carregar a Ficha de Verificação
function rotaFichaDeVerificacao() {
    $("#exibe").empty();
    $.ajax({
        url: 'homeCgpert/Contagem/ContagemTrafego/Contagem', /** <<<<<<------------- CGPERT ?!?!?? */
        type: 'GET',
        dataType: 'HTML',
        async: false,
        cache: false,
        success: function (response) {
            $("#exibe").html(response);
        },
        error: function (e) {
            console.log(e);
        }
    });
}

//Função para carregar a Não Conformidades
function rotaNaoConformidades() {
    $("#exibe").empty();
    $("#exibe").load("homeCgpert/NaoConformidades/NaoConformidades/Index").slideUp(3).delay(3).fadeIn("slow");
}

function rotaNaoAtlas() {
    $("#exibe").empty();
    $("#exibe").load("homeCgmrr/Atlas/Atlas/index").slideUp(3).delay(3).fadeIn("slow");
}


//Função para redirecionar página
function redirecionamento(url) {
    // setTimeout(function () {

    window.location = url;
    //setTimeout(function () {
    // rotaContagem();
    //});
    //  }, 0);
}

/*  setTimeout(function () {
 $("#exibe").empty();
 $("#exibe").load("homeCgpert/Contagem/ContagemTrafego/Contagem").slideUp(3).delay(3).fadeIn("slow");
 }, 0); */
$(document).ajaxStart(function () {
    $(".log").show();
});

$(document).ajaxStop(function () {
    $(".log").hide();
});
