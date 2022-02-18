$(document).ready(function () {
    $("#btn-entrar").click(function () {
        //alert('oi===='+serializedData);
        if ($("#nume_matricula").val() == "") {
            $.notify("Por favor, informe o seu \"Email\".", 'info');
            $("#nume_matricula").focus();
            return false;
        }
        if ($("#codi_senha").val() == "") {
            $.notify("Por favor, informe a sua \"Senha\".", 'info');
            $("#codi_senha").focus();
            return false;
        }
        var BASE_URL = '<?php echo base_url(); ?>';
        var serializedData = $("#form_login").serialize();
        $.ajax({
            url: 'index.php/Login/validar_login',
            type: 'POST',
            data: serializedData,
            success: function (retorno) {
                if (retorno == false) {
                    $.notify('Usuário nao encontrado', "warning");      
                    
                }else {
                    $.ajax({
                        url: 'index.php/Login/ajax_redirect',
                        type: 'POST',
                        data: {location: 'index.php/Home'}
                    });
                }

            }
        });
    });
    //--------------------------------------------------------------------------
    $("#acesso-coordenacao").change(function () {
        if (this.value == "CGCONT") {
            $("#emailSolicitacao").text("supra.construcao@dnit.gov.br");
            $("#emailSolicitacao").attr("href", "mailto:supra.construcao@dnit.gov.br")
        } else if (this.value == "CGMRR") {
            $("#emailSolicitacao").text("supra.manutencao@dnit.gov.br");
            $("#emailSolicitacao").attr("href", "mailto:supra.manutencao@dnit.gov.br")
        } else if (this.value == "CGPERT") {
            $("#emailSolicitacao").text("supra.operacoes@dnit.gov.br");
            $("#emailSolicitacao").attr("href", "mailto:supra.operacoes@dnit.gov.br")
        }
    });
});
//------------------------------------------------------------------------------
$(document).keypress(function (e) {
    if (e.which == 13) {
        $("#btn-entrar").click();
    }
});
