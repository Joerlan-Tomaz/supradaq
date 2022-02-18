/*
 * DNIT
 * SIGACONT
 * Programador:Sergio Ricardo
 * Data:15/08/2017 20:18
 *
 * captcha /
 * =======================================================
 * Alterações efetuadas:(Programador,Data,Descrição da alteração!)
 * -------------------------------------------------------
 * -------------------------------------------------------
 */
//-----------------------------------------------------------------------------------------------------------------------------------------------
$(document).ready(function () {
    //----------------------------------------------------------------------------------
    $("#reload").click(function () {

        $.ajax({
            type: 'POST',
            url: 'SolicitacaoAcesso/codigoCaptcha',
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $("img#img").remove();
                var id = Math.random();
                $('<img id="img" src="assets/captcha/captcha.php?id=' + id + '"/>').appendTo("#imgdiv");
                id = '';
            }
        });

        //$("img#img").remove();
        //var id = Math.random();
        //$('<img id="img" src="assets/captcha/captcha.php?id='+id+'"/>').appendTo("#imgdiv");
        //id ='';
    });



    //-------------------------------------------------------------------------------------   
    $('#btn-enviar').click(function () {
        //    var emailFilter=/^.+@.+\..{2,}$/;
        //    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/;
        //    var name    = $("#acesso-nome"    ).val();
        //    var email   = $("#acesso-email"   ).val();
        //    var empresa = $("#acesso-empresa" ).val();
        //    var captcha = $("#acesso-captcha" ).val();

        //    if (name == '' || email == '' || empresa == '' || captcha == '' || (!(emailFilter.test(email))||email.match(illegalChars))){
        //       $.notify('Erro [ Todos os campos são obrigatórios ]', "error"); 
        //       msgEnvio(1);
        //    }else{
        //     $.ajax({
        //             method: "POST",
        //             url: "/supra/captcha/un_cadaccess.php?name="+name+"&email="+email+"&empresa="+empresa+"&captcha="+captcha+"&operacao=inserir"
        //             }).done(function(resultado){
        //                 try {
        //                 if(resultado == 1) {
        //                         $.notify(' [ Solicitação efetuada com sucesso,favor aguardar o contato do Administrador ]', "success"); 
        //                         msgEnvio(0);

        //                 }else{
        //                         $.notify(' [ Faltando algum campo obrigatório ]', "error"); 
        //                         msgEnvio(1);
        //                 }
        //                 } catch (e) {
        //                     alert('<p>Ouve algum erro na requisição</p>');
        //                 }
        //             });
        //    }   

        var emailFilter = /^.+@.+\..{2,}$/;
        var illegalChars = /[\(\)\<\>\,\;\:\\\/\"\[\]]/;

        acessoNome = $("#acesso-nome").val();
        acessoEmail = $("#acesso-email").val();
        acessoEmpresa = $("#acesso-empresa").val();
        acessoCpf = $("#acesso-cpf").val();
        acessoTelefone = $("#acesso-telefone").val();
        acessoCoordenacao = $("#acesso-coordenacao").val();
        acessoCaptcha = $("#acesso-captcha").val();
        acessoUF = $("#acesso-uf").val();
        acessoMotivo = $("#acesso-motivo").val();

        //validação de email
        usuario = acessoEmail.substring(0, acessoEmail.indexOf("@"));
        dominio = acessoEmail.substring(acessoEmail.indexOf("@") + 1, acessoEmail.length);
        if (acessoNome == "" || (!(emailFilter.test(acessoEmail)) || acessoEmail.match(illegalChars)) == "" || acessoEmpresa == "" || acessoCpf == "" || acessoTelefone == "" || acessoCoordenacao == "" || acessoCaptcha == "" || acessoUF == "" || acessoMotivo == "") {
            $.notify("Todos os campos sao obrigatórios!", "warning");
            return false;
        }
        if ((usuario.length >= 1) &&
                (dominio.length >= 3) &&
                (usuario.search("@") == -1) &&
                (dominio.search("@") == -1) &&
                (usuario.search(" ") == -1) &&
                (dominio.search(" ") == -1) &&
                (dominio.search(".") != -1) &&
                (dominio.indexOf(".") >= 1) &&
                (dominio.lastIndexOf(".") < dominio.length - 1)) {
            dominio = dominio.split(".");
            dominio = dominio[0];
            if (dominio == "gmail" || dominio == "outlook" || dominio == "hotmail" || dominio == "live" || dominio == "uol" || dominio == "bol"
                    || dominio == "yahoo" || dominio == "ymail" || dominio == "globomail") {
                $.notify("E-mail inválido!", "warning");
                return false;
            }
        }
        //-------------------------------------------------------------------------------------   
        var serializedData = new FormData();
        serializedData = $("#formularioAcesso").serializeArray();

        $.ajax({
            type: 'POST',
            url: 'SolicitacaoAcesso/insereSolicitacao',
            data: serializedData,
            dataType: 'json',
            success: function (resultado) {
                //try {
                if (resultado == 1) {
                    $.notify(' [ Solicitação efetuada com sucesso,favor aguardar o contato do Administrador ]', "success");
                    msgEnvio(0);
                }
                if (resultado == 2) {
                    $.notify(' [ CPF Inválido ]', "warning");
                    return false;
                }
                if (resultado == 3) {
                    $.notify(' [ Captcha Inválido ]', "warning");
                    return false;
                }
                if (resultado == 4) {
                    $.notify(' [ E-mail Cadastrado ]', "warning");
                    return false;
                }
                if (resultado == 5) {
                    $.notify(' [ E-mail Inválido ]', "warning");
                    return false;
                }
                //    else{
                //        $.notify(' [ Faltando algum campo obrigatório ]', "error"); 
                //        msgEnvio(1);
                //    }
                //} catch (e) {
                //    alert('<p>Ouve algum erro na requisição</p>');
                //}

                //$.notify('Solicitado com sucesso!', "success"); 
            }, error: function (data) {
                $.notify('Erro no Envio', "warning");
                console.log(data);
            }
        });

    });
});

//-------------------------------------------------------------------------------------
function msgEnvio(cod) {

    var cod = cod;

    $('.mensagem-acesso-inicio').addClass('hidden');
    $('.form-acesso').addClass('hidden');
    $('.mensagem-acesso-envio').removeClass('hidden');

    if (cod == 1) {

        $('.msg-erro').show();
        $('#messagem').text('Não foi possível enviar sua solicitação.');
        $('.btn-tentar').show();

    } else if (cod == 2) {

        $('.msg-erro').show();
        $('#messagem').text('E-mail já cadastrado.');
        $('.btn-tentar').show();

    } else if (cod == 0) {
        $('.msg-erro').remove();
        $('.msg-sucesso').show();
        $("img#img").remove();
        var id = Math.random();
        $('<img id="img" src="assets/login2017/captcha/captcha.php?id=' + id + '"/>').appendTo("#imgdiv");
        id = '';

    }

}    