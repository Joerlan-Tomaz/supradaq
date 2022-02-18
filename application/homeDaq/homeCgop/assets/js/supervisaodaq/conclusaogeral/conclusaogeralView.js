//######################################################################################################################################################################################## 
//# DNIT
//# conclusaogeralView.js
//# Desenvolvedor:Jordana Alencar 
//# Data: 10/10/2019 13:00
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
    //--------------------------------------------------------------------------
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //--------------------------------------------------------------------------
    CKEDITOR.replace("conclusaoGeral", {height: 250});
    //--------------------------------------------------------------------------
    $("#novo_ConclusaoGeral").hide();
    $("#cadastroConclusaoGeral").hide();
    $("#searchdate").hide();
    $('#btnRecuperaUltimo').hide();
    //--------------------------------------------------------------------------
    $("#datepicker").on("changeDate", function () {
        recuperaConclusaoGeral();
        $('#btnRecuperaUltimo').hide();
    });
    //--------------------------------------------------------------------------
    recuperaConclusaoGeral();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaConclusaoGeral();
        document.getElementById("datepicker").disabled = false;
        $("#btnInclusao").show();
        $("#searchdate").hide();
        $('#btnRecuperaUltimo').hide();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        var relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $("#novo_ConclusaoGeral").hide();
            $("#cadastroConclusaoGeral").show();
            document.getElementById("datepicker").disabled = true;
            $("#btnInclusao").hide();
            $("#searchdate").show();
            $('#btnRecuperaUltimo').show();
        }
    });
    //--------------------------------------------------------------------------
    $("#insereConclusaoGeral").click(function () {
        //------------------ Verificação de campos -----------------------------------------
        var conclusaoGeral = CKEDITOR.instances['conclusaoGeral'].getData();
//        fileUpload = $("#fileUpload").val();
        if (conclusaoGeral == "") {
            $.notify("Insira os campos necessários!", "warning");
            return false;
        }
        //document.getElementById('fileUpload').style.borderColor = '#d2d6de';
        //----------------------------------------------------------------------
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();
//        form.append('arquivo', $('#fileUpload')[0].files[0]);
        form.append('periodo', termo);
        form.append('resumoConclusaoGeral', conclusaoGeral);
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR CONCLUSÃO GERAL]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/ConclusaoInsereDaq',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        CKEDITOR.instances["conclusaoGeral"].setData("");
//                        $("#fileUpload").val("");
                        $('#cadastroConclusaoGeral').hide();
                        $('#novo_ConclusaoGeral').show();
                        $.notify('Cadastro Efetuado', "success");
                        var tableConclusaoGeral = $("#tableConclusaoGeral").DataTable();
                        tableConclusaoGeral.ajax.reload();

                        document.getElementById("datepicker").disabled = false;
                        document.getElementById("btnInclusao").disabled = false;
                        document.getElementById("searchdate").disabled = false;
                        $("#btnInclusao").show();
                        $("#searchdate").hide();
                        $('#btnRecuperaUltimo').hide();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });

    });
    //--------------------------------------------------------------------------
    $("#btnRecuperaUltimo").click(function () {
        btnRecuperaUltimo();
    });
    //--------------------------------------------------------------------------
});
//------------------------------------------------------------------------------
function recuperaConclusaoGeral() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_ConclusaoGeral').show();
    $('#cadastroConclusaoGeral').hide();
    $('#tableConclusaoGeral').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "destroy": true,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/ConclusaoRetornaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify", "width": "50%"},
            {data: 'NOME', "sClass": "text-center", "width": "10%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirResumo(id_resumo) {
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/ConclusaoExcluirDaq",
                    data: {id_resumo: id_resumo},
                    dataType: "json",
                    success: function (data) {
                        $.notify("Removido com sucesso!", "success");
                        var table = $("#tableConclusaoGeral").DataTable();
                        table.ajax.reload();
                    }, error: function (jqXHR, textStatus, errorMessage) {
                        $.notify("Ocorreu um erro: " + errorMessage, "warning");
                    }
                });
            }
        });
    }
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnRecuperaUltimo() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    bootbox.confirm("Confirmar operação [Recuperar dados do periodo referência anterior]?", function (result) {
      if (result === true) {
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgop.php/RecuperaConGeralDaqUltimo?periodo='+termo,
            dataType: 'json',
            success: function (data) {
               if(data.resumo != null){
                CKEDITOR.instances['conclusaoGeral'].setData(data.resumo);
               }else{
               $.notify('Não foi encontrado informações do período anterior', "warning"); 
               }
            }, error: function (data) {
                $.notify('Falha na exclusão', "warning");
            }
        });
    }
    });
}
