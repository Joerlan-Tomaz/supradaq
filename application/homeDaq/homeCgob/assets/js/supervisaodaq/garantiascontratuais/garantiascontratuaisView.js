//######################################################################################################################################################################################################################## 
//# DNIT
//# garantiascontratuaisView.js
//# Desenvolvedor:Jordana de ALencar
//# Data: 10/10/2019 13:00
//########################################################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //--------------------------------------------------------------------------
    CKEDITOR.replace("observacao", {height: 120});
    CKEDITOR.replace("objeto", {height: 120});
    CKEDITOR.replace("providencia", {height: 120});
    //--------------------------------------------------------------------------
    $("#novo_garantiacontratual").hide();
    $("#cadastroGarantiaContratual").hide();
    $('#searchdate').hide();
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    $("#datepicker").on("changeDate", function () {
        recuperaGarantiaSeguro();
    });
    //--------------------------------------------------------------------------
    recuperaGarantiaSeguro();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaGarantiaSeguro();
        $('#searchdate').hide();
        $('#btnInclusao').show();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $('#novo_garantiacontratual').hide();
            $('#cadastroGarantiaContratual').show();
            populaTipoGarantia();
            document.getElementById("datepicker").disabled = true;
            //document.getElementById("btnNoAtividade").disabled = true;
            $('#searchdate').show();
            $('#btnInclusao').hide();
        }
    });
    //--------------------------------------------------------------------------
    $("#btnNoAtividade").click(function () {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            //----------------------------------------------------------------------
            bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: {periodo: termo},
                        dataType: 'json',
                        success: function (data) {
                            $.notify("Não houve garantia contratual este mês!", "success");
                            var tableGarantiaContratual = $("#tableGarantiaContratual").DataTable();
                            tableGarantiaContratual.ajax.reload();
                            confereNaoAtividade();
                        }, error: function (data) {
                            $.notify('Falha no cadastro', "warning");
                        }
                    });
                }
            });
        }
    });
    //--------------------------------------------------------------------------
    $("#insereGarantiaContratual").click(function () {
        var serializedData = validaformulario("formularioGarantiasContratuais");
        if (serializedData == false) {
            $.notify('Preencha os campos obrigatorios', "warning");
            return false;
        }
        var num = $('#numero_apolice').val();
            if (num.trim() !== ""){
            var regra = /^[0-9]+$/;
            if (num.match(regra)){
            }else {
                 $.notify("Permitido Somente Números [Número da Apólice]!", "warning");
                 document.getElementById('numero_apolice').style.borderColor = "red";
                 return false;
                }
            }
        bootbox.confirm("Confirmar operação [INSERIR GARANTIA CONTRATUAL]?", function (result) {
            if (result === true) {
                var termo = new Object();
                if (document.getElementById) {
                    var dt = $("#datepicker").datepicker('getDate');
                    if (dt.toString() == "Invalid Date") {
                        $("#datepicker").datepicker("setDate", new Date());
                        return;
                    }
                    termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                    termo.name = "periodo";
                }
                serializedData.push(termo);
                $.ajax({
                    url: base_url + 'index_cgob.php/GarantiaSeguroInsereDaq',
                    type: "POST",
                    data: serializedData,
                    dataType: 'json',
                    success: function (data) {
                        $.notify("Cadastrado com Sucesso!", "success");
                        //$.notify(data.mensagem, data.notify);
                        document.formularioGarantiasContratuais.reset();
                        CKEDITOR.instances['observacao'].setData("");
                        CKEDITOR.instances['objeto'].setData("");
                        $('#cadastroGarantiaContratual').hide();
                        $('#novo_garantiacontratual').show();
                        var tableGarantiaContratual = $("#tableGarantiaContratual").DataTable();
                        tableGarantiaContratual.ajax.reload();
                        document.getElementById("datepicker").disabled = false;
                        //confereNaoAtividade();
                         recuperaGarantiaSeguro();
                         $('#searchdate').hide();
                         $('#btnInclusao').show();
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                    }
                });
            }
        });
    });
    //--------------------------------------------------------------------------
    $("#insereProvidencia").click(function () {
        if($("#situacao_garantia_seguro").val()== "" || $("#situacao_garantia_seguro").val()== "Selecione"){
            document.getElementById('situacao_garantia_seguro').style.borderColor = 'red';
            $.notify("Informe o campo [Status]", "warning");
            return false
        }else {
                document.getElementById('situacao_garantia_seguro').style.borderColor = '#d2d6de';
        }
        var providencia = CKEDITOR.instances['providencia'].getData();
   
        if (providencia == '') {
             $.notify("O campo [providencia] é obrigatório!", "warning");
            document.getElementById('providencia').style.borderColor = 'red';
            return false;
        } else {
            document.getElementById('providencia').style.borderColor = '#d2d6de';
        }
        var situacao = $("#situacao_garantia_seguro").val();
        var id_garantia_seguro = $("#id_garantia_seguro").val();
        var providencia = CKEDITOR.instances['providencia'].getData();
        //---------------------------------------------------------------------- 
        //----------------------------------------------------------------------
            if (document.getElementById) {
                var dt = $("#datepicker").datepicker("getDate");
                if (dt.toString() === "Invalid Date") {
                    $("#datepicker").datepicker("setDate", new Date());
                    return;
                }
                var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
            }
        //-----------------------------------------------------------------------    
        bootbox.confirm("Confirmar operação [INSERIR PROVIDÊNCIA]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/GarantiaSeguroInsereProvDaq',
                    data: {situacao: situacao, id_garantia_seguro: id_garantia_seguro, providencia: providencia},
                    dataType: 'json',
                    success: function (data) {
                        $.notify("Cadastrado com Sucesso!", "success");
                        var table = $("#tableGarantiaContratual").DataTable();
                        table.ajax.reload();
                        tableprovidencia = $("#tableProvidenciaGarantiaSeguro").DataTable();
                        tableprovidencia.ajax.reload();
                        document.formularioProvidencia.reset();
                        CKEDITOR.instances['providencia'].setData("");    
                        if (data.situacao == "Fechado") {
                                $("#modalSituacao").modal("hide");
                                recuperaGarantiaSeguro();
                            }
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                    }
                });
            }
        });
    });
    //--------------------------------------------------------------------------
    function anexoGaratias(nome_arquivo) {
        $.ajax({
            url: base_url + 'index_cgob.php/anexoGaratias',
            type: 'POST',
            data: {nome_arquivo: nome_arquivo},
            success: function (data) {
                var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
                var anchor = document.createElement('a');
                anchor.setAttribute("download", nome_arquivo);
                anchor.setAttribute("href", arquivo);
                anchor.click();
                $.notify('Download!', "success");
                excluirGarantias(nome_arquivo);
            }, error: function (data) {
                $.notify('Falha no download!', "warning");
            }
        });
    }
    //--------------------------------------------------------------------------
    $("#fileUpload").change(function () {
        bootbox.confirm("Confirmar operação [INSERIR ANEXO]?", function (result) {
            if (result === true) {
                if (document.getElementById) {
                    var dt = $("#datepicker").datepicker('getDate');
                    if (dt.toString() == "Invalid Date") {
                        $("#datepicker").datepicker("setDate", new Date());
                        return;
                    }
                    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                }

                var form = new FormData();
                form.append("arquivo", $("#fileUpload")[0].files[0]);
                form.append("id_garantia_seguro", $("#id_garantia_seguro_anexo").val());
                form.append("periodo", termo);
                $.ajax({
                    url: base_url + "index_cgob.php/GarantiaSeguroInsereAnxDaq",
                    type: "POST",
                    data: form,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $.notify("Upload com Sucesso", "success");
                        $("#fileUpload").val("");
                        var table = $("#tableAnexoGarantiaSeguro").DataTable();
                        table.ajax.reload();
                    }, error: function (data) {
                        $.notify("Erro no Envio", "warning");
                    }
                });
            }
        });
    });
});

//------------------------------------------------------------------------------
function excluirGarantias(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/excluirGarantias',
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
//------------------------------------------------------------------------------
function populaTipoGarantia() {
    $.ajax({
        type: "POST",
        url: base_url + "index_cgob.php/GarantiaSeguroTipoDaq",
        dataType: "json",
        success: function (data) {
            var tipoGarantia = $('select[id=tipo_garantia]');
            tipoGarantia.html('');
            tipoGarantia.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_tipo_garantia.length; i++) {
                tipoGarantia.append('<option value="' + data.id_tipo_garantia[i] + '">' + data.desc_tipo_garantia[i] + '</option>');
            }
        }
    });
}
//------------------------------------------------------------------------------
function recuperaGarantiaSeguro() {
    document.getElementById("datepicker").disabled = false;
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_garantiacontratual').show();
    $('#cadastroGarantiaContratual').hide();
    $('#tableGarantiaContratual').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/GarantiaSeguroRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'guia', "sClass": "text-justify", "width": "10%"},
            {data: 'tipo_garantia', "width": "10%"},
            {data: 'processo', "sClass": "text-center", "width": "10%"},
            {data: 'valor_garantia', "sClass": "text-center", "width": "10%"},
            {data: 'inicio_vigencia', "sClass": "text-center", "width": "10%"},
            {data: 'termino_vigencia', "sClass": "text-center", "width": "10%"},
            {data: 'data_emissao', "sClass": "text-center", "width": "10%"},
            {data: 'observacao', "sClass": "text-center", "width": "5%"},
            {data: 'situacao', "sClass": "text-center", "width": "5%"},
            {data: 'providencia', "sClass": "text-center", "width": "5%"},
            {data: 'usuario', "sClass": "text-center", "width": "10%"},
            {data: 'ultima_alteracao', "sClass": "text-center", "width": "10%"},
            {data: 'acao', "sClass": "text-center", "width": "5%"}
        ]
    });
    //confereNaoAtividade();
}
//------------------------------------------------------------------------------   
function recuperaObservacaoObjeto(id_garantia_seguro) {
    $("#descricaoObservacaoObjeto").modal("show");
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/GarantiaSeguroObsObjDaq',
        dataType: 'json',
        data: {id_garantia_seguro: id_garantia_seguro},
        success: function (data) {
            $("#garantia_contratual_observacao_modal").html(data.observacao);
            $("#garantia_contratual_objeto_modal").html(data.objeto);
        }
    });
}
//------------------------------------------------------------------------------
function excluirGarantiaSeguro(id_garantia_seguro) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/GarantiaSeguroExcluirDaq',
                    data: {id_garantia_seguro: id_garantia_seguro},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluido com sucesso!', "success");
                        var tableGarantiaContratual = $("#tableGarantiaContratual").DataTable();
                        tableGarantiaContratual.ajax.reload();
                        confereNaoAtividade();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------
function confereNaoAtividade() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $.ajax({
        type: 'POST',
        url: '',
        data: {periodo: termo},
        dataType: 'json',
        success: function (data) {
            if (data.situacao === "Com Arquivo") {
                document.getElementById("btnInclusao").disabled = false;
                document.getElementById("btnNoAtividade").disabled = true;
            } else if (data.situacao === "Sem atividade") {
                document.getElementById("btnInclusao").disabled = true;
                document.getElementById("btnNoAtividade").disabled = true;
            } else if ("Sem Registros") {
                document.getElementById("btnInclusao").disabled = false;
                document.getElementById("btnNoAtividade").disabled = false;
            }
        }
    });
}
//------------------------------------------------------------------------------   
function modalSituacao(id_garantia_seguro, st) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
    $("#modalSituacao").modal();
    $("#id_garantia_seguro").val(id_garantia_seguro);
    $("#situacao_garantia_seguro").val(st);
    if (st == "Fechado") {
        $("#situacao_garantia_seguro").prop("disabled", true);
        $("#insereProvidencia").prop("disabled", true);
        CKEDITOR.instances["providencia"].setReadOnly(true);
    } else {
        $("#situacao_garantia_seguro").prop("disabled", false);
        $("#insereProvidencia").prop("disabled", false);
        CKEDITOR.instances["providencia"].setReadOnly(false);
    }
       
        $('#tableProvidenciaGarantiaSeguro').dataTable({
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
            "sAjaxSource": base_url + "index_cgob.php/GarantiaSeguroRecuperaProvDaq",
            "fnServerParams": function (aoData) {
                 aoData.push(
                    {"name": "id_garantia_seguro", "value": id_garantia_seguro},
                    {"name": "st", "value": st});
        },
            "aoColumns": [
                {data: 'DESCRICAO'},
                {data: 'ACAO', "sClass": "text-center"}
            ]
        });
    }
}
//------------------------------------------------------------------------------
function excluirProvidencia(id_providencia) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'index_cgob.php/GarantiaSeguroExcluiProvDaq',
                    data: {id_providencia: id_providencia},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Removido com sucesso!', "success");
                        var table = $("#tableProvidenciaGarantiaSeguro").DataTable();
                        table.ajax.reload();
                    }, error: function (jqXHR, textStatus, errorMessage) {
                        $.notify('Ocorreu um erro: ' + errorMessage, "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------   
function modalAnexo(id_garantia_seguro) {
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $("#modalAnexo").modal();
        $("#id_garantia_seguro_anexo").val(id_garantia_seguro);
        $("#tableAnexoGarantiaSeguro").dataTable({
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
            "sAjaxSource": base_url + "index_cgob.php/GarantiaSeguroRecuperaAnxDaq",
            "fnServerParams": function (aoData) {
                aoData.push({"name": "id_garantia_seguro", "value": id_garantia_seguro});
            },
            "aoColumns": [
                {data: "ARQUIVO"},
                {data: "NOME", "sClass": "text-center"},
                {data: "ULTIMA_ALTERACAO", "sClass": "text-center"},
                {data: "ACAO", "sClass": "text-center"}
            ]
        });
    }
}
//------------------------------------------------------------------------------
function excluirArquivo(id_arquivo) {
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR ANEXO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgob.php/GarantiaSeguroExluiAnxDaq",
                    data: {id_arquivo: id_arquivo},
                    dataType: "json",
                    success: function (data) {
                        $.notify("Excluído com sucesso!", "success");
                        var table = $("#tableAnexoGarantiaSeguro").DataTable();
                        table.ajax.reload();
                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                    }
                });
            }
        });
    }
}
