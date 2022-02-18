//######################################################################################################################################################################################## 
//# DNIT
//# pgqView.js
//# Desenvolvedor:Jordana Alencar
//# Data: 10/10/2019
//########################################################################################################################################################################################
$().ready(function () {
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    $("#searchdate").hide();
    //--------------------------------------------------------------------------
    CKEDITOR.replace("pgq", {height: 250});
    //--------------------------------------------------------------------------
    $("#novo_PGQ").hide();
    $("#cadastroPGQ").hide();
    //--------------------------------------------------------------------------
    $("#datepicker").on("changeDate", function () {
        recuperaPGQ();
    });
    //--------------------------------------------------------------------------
    recuperaPGQ();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaPGQ();
         $("#btnInclusao").show();
         $("#searchdate").hide();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        // relatorio = confereRelatorio();
        // if (relatorio == 1) {
        //     mensagemRelatorioFechado();
        // } else {
            $("#novo_PGQ").hide();
            $("#cadastroPGQ").show();
            document.getElementById("datepicker").disabled = true;
            $("#btnInclusao").hide();
            $("#searchdate").show();
        //}
    });

//--------------------------------------------------------------------------
    $("#inserePGQ").click(function () {
        var fileUpload = $("#fileUpload").val();
        var descricao = CKEDITOR.instances["pgq"].getData();
        if (fileUpload == "" || descricao == "") {
            if (fileUpload === "") {
                document.getElementById("fileUpload").style.borderColor = "red";
            } else {
                document.getElementById("fileUpload").style.borderColor = "#d2d6de";
            }
            $.notify("Preencha os campos necessários!", "warning");
            return false;
        }
        document.getElementById("fileUpload").style.borderColor = "#d2d6de";
        bootbox.confirm("Confirmar operação [INSERIR PGQ]?", function (result) {
            if (result === true) {
                if (document.getElementById) {
                    var dt = $("#datepicker").datepicker("getDate");
                    if (dt.toString() == "Invalid Date") {
                        $("#datepicker").datepicker("setDate", new Date());
                        return;
                    }
                    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                }

                var form = new FormData();
                form.append("arquivo", $("#fileUpload")[0].files[0]);
                form.append("resumo", descricao);
                form.append("periodo", termo);
                $.ajax({
                    url: base_url + "index_cgob.php/PGQInsereDaq",
                    type: "POST",
                    data: form,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $.notify(data.mensagem, data.notify);
                        CKEDITOR.instances["pgq"].setData("");
                        document.getElementById("datepicker").disabled = false;
                        $("#fileUpload").val("");
                        $("#cadastroPGQ").hide();
                        $("#novo_PGQ").show();
                        var tablePGQ = $("#tablePGQ").DataTable();
                        $("#searchdate").click();
                        tablePGQ.ajax.reload();
                        //confereNaoAtividade();
                    }, error: function (data) {
                        $.notify("Erro no Envio", "warning");
                    }
                });
            }
        });
    });
});
//------------------------------------------------------------------------------
function anexoPgq(nome_arquivo) {
    $.ajax({
        url: 'anexoPgq',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluirPgq(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//------------------------------------------------------------------------------
 function modalConfigPGQ() {
    $("#modalConfigPGQ").modal("show");
    recuperaPGQ();
 }
//------------------------------------------------------------------------------
function recuperaPGQ() {
   document.getElementById("datepicker").disabled = false;
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_PGQ').show();
    $('#cadastroPGQ').hide();
    $('#tablePGQ').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/PGQRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'OBSERVACAO', "sClass": "text-justify", "width": "55%"},
            {data: 'ARQUIVO', "width": "20%"},
            {data: 'NOME', "sClass": "text-center", "width": "10%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });
    // confereNaoAtividade();
}
//------------------------------------------------------------------------------

function excluirArquivo(id_resumo, id_arquivo) {
    // relatorio = confereRelatorio();
    // if (relatorio == 1) {
    //     mensagemRelatorioFechado();
    // } else {

        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/PGQExcluirDaq',
                    data: {id_resumo: id_resumo, id_arquivo: id_arquivo},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var tablePGQ = $("#tablePGQ").DataTable();
                        tablePGQ.ajax.reload();
                       
                    }, error: function (data) {
                        $.notify('Falha na exclusão', "warning");
                    }
                });
            }
        });
    //}
}

function excluirPgq(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/excluirPgq',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Excluido com Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
