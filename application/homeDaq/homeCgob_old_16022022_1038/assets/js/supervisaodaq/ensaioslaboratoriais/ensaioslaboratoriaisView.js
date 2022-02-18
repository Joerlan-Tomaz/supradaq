//######################################################################################################################################################################################## 
//# DNIT
//# ensaioslaboratoriaisView.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 01/12/2019 
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //------------------------------------------------------- 
    CKEDITOR.replace('ensaioLaboratorio', {
        //removePlugins: 'toolbar, elementspath, resize',
        height: 200
    });
    //--------------------------------------------------------------------
    $('#novo_ensaioLaboratorio').hide();
    $('#cadastroEnsaioLaboratorio').hide();
    $('#searchdate').hide();
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        $.ajaxSetup({cache: false});
        recuperaEnsaios();
    });
    //--------------------------------------------------------------------
    recuperaEnsaios();
    //--------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaEnsaios();
        document.getElementById("datepicker").disabled = false;
        $('#searchdate').hide();
        $('#btnInclusao').show();
        $('#btnNoAtividade').show();
    });
    //--------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $('#novo_ensaioLaboratorio').hide();
            $('#cadastroEnsaioLaboratorio').show();
            document.getElementById("datepicker").disabled = true;
            if ($("#btnNoAtividade").length) {
                document.getElementById("btnNoAtividade").disabled = true;
            }
            $('#searchdate').show();
            $('#btnInclusao').hide();
            $('#btnNoAtividade').hide();
        }
    });
    //-------------------------------------------------------------------- 
    $("#insereEnsaioLaboratorio").click(function () {
        //------------------ Verificação de campos -----------------------------------------
        fileUpload = $("#fileUpload").val();
        var ensaioLaboratorio = CKEDITOR.instances['ensaioLaboratorio'].getData();
        if (fileUpload == "" || ensaioLaboratorio == "") {
            if (fileUpload == '') {
                document.getElementById('fileUpload').style.borderColor = 'red';
            } else {
                document.getElementById('fileUpload').style.borderColor = '#d2d6de';
            }
            $.notify("Insira os campos necessários!", "warning");
            return false;
        }
        document.getElementById('fileUpload').style.borderColor = '#d2d6de';
        //----------------------------------------------------------------------------------------------------------------------------------------
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
        form.append('arquivo', $('#fileUpload')[0].files[0]);
        form.append('periodo', termo);
        form.append('resumoEnsaioLaboratorio', ensaioLaboratorio);
        //----------------------------------------------------------------------------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR ENSAIOS DE LABORATÓRIOS]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/EnsaioSupInsereDaq',
                    data: form,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $.notify(data.mensagem, data.notify);
                        CKEDITOR.instances['ensaioLaboratorio'].setData("");
                        document.getElementById("fileUpload").value = "";
                        $('#novo_ensaioLaboratorio').show();
                        $('#cadastroEnsaioLaboratorio').hide();
                        var tableEnsaioLaboratorio = $("#tableEnsaioLaboratorio").DataTable();
                        tableEnsaioLaboratorio.ajax.reload();
                        // confereNaoAtividade();
                        document.getElementById("datepicker").disabled = false;
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                    }
                });
            }
        });
    });
    //--------------------------------------------------------------------       
    $("#btnNoAtividade").click(function () {
        // relatorio = confereRelatorio();
        // if (relatorio == 1) {
        //     mensagemRelatorioFechado();
        // } else {
            if (document.getElementById) {
                var dt = $("#datepicker").datepicker('getDate');
                if (dt.toString() == "Invalid Date") {
                    $("#datepicker").datepicker("setDate", new Date());
                    return;
                }
                var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
            }
            //----------------------------------------------------------------------------------------------------------------------------------------
            bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'index_cgob.php/EnsaioSupInsereNHADaq',
                        data: {periodo: termo},
                        dataType: 'json',
                        success: function (data) {
                            $.notify(data.mensagem, data.notify);
                            var tableEnsaioLaboratorio = $("#tableEnsaioLaboratorio").DataTable();
                            tableEnsaioLaboratorio.ajax.reload();
                            $('#novo_ensaioLaboratorio').show();
                            $('#cadastroEnsaioLaboratorio').hide();
                            confereNaoAtividade();
                        }, error: function (data) {
                            $.notify('Falha no cadastro', "warning");
                        }
                    });
                }
            });
        // }
    });
});
//-------------------------------------------------------------------- 
function anexoEnsaiosup(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/anexoEnsaiosup',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluirEnsaioSup(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//--------------------------------------------------------------------       
function recuperaEnsaios() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_ensaioLaboratorio').show();
    $('#cadastroEnsaioLaboratorio').hide();
   ;
    $('#tableEnsaioLaboratorio').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/EnsaioSupRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify", "width": "50%"},
            {data: 'ARQUIVO', "width": "25%"},
            {data: 'NOME', "sClass": "text-center", "width": "10%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });
}

//--------------------------------------------------------------------       
function excluirArquivo(id_resumo, id_arquivo,) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/EnsaioSupExcluirDaq',
                    data: {id_resumo: id_resumo, id_arquivo: id_arquivo},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var tableEnsaioLaboratorio = $("#tableEnsaioLaboratorio").DataTable();
                        tableEnsaioLaboratorio.ajax.reload();
                        // confereNaoAtividade();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------
function excluirEnsaioSup(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/excluirEnsaioSup',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Excluido com Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//------------------------------------------------------------------------------
