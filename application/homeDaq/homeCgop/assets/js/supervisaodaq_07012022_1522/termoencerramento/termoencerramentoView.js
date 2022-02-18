//######################################################################################################################################################################################################################## 
//# DNIT
//# termoencerramentoView.js
//# Desenvolvedor:Jordana de ALencar 
//# Data: 10/10/2019 13:00
//########################################################################################################################################################################################################################
$().ready(function () {
//    CKEDITOR.replace('TermoEncerramento', {
//        height: 250
//    });
    //--------------------------------------------------------------------------
    $('#novo_TermoEncerramento').hide();
    $('#cadastroTermoEncerramento').hide();
     $("#searchdate").hide();
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        recuperaTermoEncerramento();
    });
    //--------------------------------------------------------------------------
    recuperaTermoEncerramento();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaTermoEncerramento();
        document.getElementById("datepicker").disabled = false;
        $("#btnInclusao").show();
        $("#searchdate").hide();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
           var termo = new Object();
            if (document.getElementById) {
                var dt = $("#datepicker").datepicker('getDate');
                if (dt.toString() === "Invalid Date") {
                    $("#datepicker").datepicker("setDate", new Date());
                    return;
                }
                termo.name = "periodo";
                termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
            }
            
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/TermoEncerramentoTextoDaq?periodo='+termo,
                dataType: 'json',
                success: function (data) {
                    $('#novo_TermoEncerramento').hide();
                    $('#cadastroTermoEncerramento').show();
                    document.getElementById("datepicker").disabled = true;
                    //document.getElementById("id_resumo").value = "";
                    $("#TermoEncerramento").html(data.textoPadrao);
                    $("#btnInclusao").hide();
                    $("#searchdate").show();
                }, error: function (data) {
                    $.notify('Falha na consulta', "warning");
                }
            });

       }
    });
    //--------------------------------------------------------------------------
    $("#insereTermoEncerramento").click(function () {
        //------------------ Verificação de campos -----------------------------
        //----------------------------------------------------------------------
        var termo = new Object();
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        //---------------- Validação de formulario -----------------------------
        var serializedData = validaformulario("formularioTermoEncerramento");
        if (serializedData == false) {
            $.notify("Informe os campos necessários!", 'warning');
            return false;
        }
        serializedData.push(termo);
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR TERMO DE ENCERRAMENTO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/TermoEncerramentoInsereDaq',
                    data: serializedData,
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Termo de encerramento cadastrado!', "success");
//                        CKEDITOR.instances['TermoEncerramento'].setData("");
                        $('#cadastroTermoEncerramento').hide();
                        $('#novo_TermoEncerramento').show();
                        var tableTermoEncerramento = $("#tableTermoEncerramento").DataTable();
                        tableTermoEncerramento.ajax.reload();

                        document.getElementById("datepicker").disabled = false;
                        document.getElementById("btnInclusao").disabled = false;
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    });
    //--------------------------------------------------------------------------
});
//------------------------------------------------------------------------------
function excluirTermoEncerramento(id_termo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR TERMO DE ENCERRAMENTO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/TermoEncerramentoExcluirDaq',
                    data: {
                        id_termo: id_termo
                    },
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Termo de encerramento excluído!', "success");
                        $('#cadastroTermoEncerramento').hide();
                        $('#novo_TermoEncerramento').show();
                        var tableTermoEncerramento = $("#tableTermoEncerramento").DataTable();
                        tableTermoEncerramento.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha na exclusão', "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------
function recuperaTermoEncerramento() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_TermoEncerramento').show();
    $('#cadastroTermoEncerramento').hide();
    $('#tableTermoEncerramento').dataTable({
        "bProcessing": false,
        "pageLength": 10,
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
        "sAjaxSource": base_url + "index_cgop.php/TermoEncerramentoRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify"},
            {data: 'NOME', "sClass": "text-center"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center"},
            {data: 'ACAO', "sClass": "text-center"}
        ]
    });
}
//------------------------------------------------------------------------------
function editarTermoEncerramento(id_termo) {
    // relatorio = confereRelatorio();
    // if (relatorio == 1) {
    //     mensagemRelatorioFechado();
    // } else {
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgop.php/TermoEncerramentoEditarDaq',
            data: {id_termo: id_termo},
            dataType: 'json',
            success: function (data) {
                document.getElementById("datepicker").disabled = true;

                $('#novo_TermoEncerramento').hide();
                $('#cadastroTermoEncerramento').show();

                var texto = data.texto;
                $("#id_resumo").val(data.id_termo);
                CKEDITOR.instances['TermoEncerramento'].setData(texto);
            }, error: function (data) {
                $.notify('Falha na exclusão', "warning");
            }
        });
   // }
}
