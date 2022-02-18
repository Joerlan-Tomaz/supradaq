//######################################################################################################################################################################################################################## 
//# DNIT
//# licencasambientaisView.js
//# Desenvolvedor:jordana alencar
//# Data: 10/10/2019 
//########################################################################################################################################################################################################################
/*--------------------------------------------------------------------------- */
$().ready(function () {
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //--------------------------------------------------------------------------
    $("#searchdate").hide();
    $("#btnNoAtividade").hide();
    //--------------------------------------------------------------------------
    CKEDITOR.replace("status_detalhado", {height: 200});
    CKEDITOR.replace("condicionantes_ambientais", {height: 200});
    CKEDITOR.replace("status_detalhado_Editar", {height: 200});
    CKEDITOR.replace("condicionantes_ambientais_Editar", {height: 200});
    //--------------------------------------------------------------------------
    $("#novo_licencaAmbiental").hide();
    $("#cadastroLicencasAmbientais").hide();
    $("#editarLicencasAmbientais").hide();
    
    //--------------------------------------------------------------------------
    $("#datepicker").on("changeDate", function () {
        recuperaLicencaAmbiental();
    });
    //--------------------------------------------------------------------------
    recuperaLicencaAmbiental();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaLicencaAmbiental();
        document.getElementById("datepicker").disabled = false;
        $("#voltar").show();
        $("#searchdate").hide();
        $("#btnInclusao").show();
        $("#editarLicencasAmbientais").hide();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
       // var relatorio = confereRelatorio();
      //  if (relatorio == 1) {
        //    mensagemRelatorioFechado();
    //    } else {
            $("#novo_licencaAmbiental").hide();
            $("#cadastroLicencasAmbientais").show();
            populaTipoLicenca();
            $("#datepicker").prop("disabled", true);
            $("#btnNoAtividade").prop("disabled", true);
            $("#voltar").hide();
            $("#searchdate").show();
            $("#btnInclusao").hide();
            
      //  }
    });
    //--------------------------------------------------------------------------
    $("#editarLicencaAmbiental").click(function () {
        editarLicencaAmbiental();
    });
    //--------------------------------------------------------------------------
    $("#solicitacaoDataRenovacao").change(function () {
        if (this.value == "Sim") {
            document.getElementById("dataSolicitacaoRenovacao").disabled = false;
        } else {
            document.getElementById("dataSolicitacaoRenovacao").disabled = true;
            document.getElementById("dataSolicitacaoRenovacao").style.borderColor = "#d2d6de";
        }
    });
    //--------------------------------------------------------------------------
    $("#solicitacaoDataRenovacao_Editar").change(function () {
        if (this.value == "Sim") {
            document.getElementById("dataSolicitacaoRenovacao_Editar").disabled = false;
        } else {
            document.getElementById("dataSolicitacaoRenovacao_Editar").disabled = true;
            document.getElementById("dataSolicitacaoRenovacao_Editar").style.borderColor = "#d2d6de";
        }
    });
    //--------------------------------------------------------------------------
    $("#insereLicencaAmbiental").click(function () {
        //------------------ Verificação de campos -----------------------------
        var serializedData = validaformulario("formularioLicencaAmbiental");
        var fileUpload = $("#fileUpload").val();
        if (serializedData == false || fileUpload == "") {
            if (fileUpload == "") {
                document.getElementById("fileUpload").style.borderColor = "red";
            } else {
                document.getElementById("fileUpload").style.borderColor = "#d2d6de";
            }
            $.notify("Preencha os campos obrigatórios", "warning");
            return false;
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();
        form.append("arquivo", $("#fileUpload")[0].files[0]);
        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }
        document.getElementById("fileUpload").style.borderColor = "#d2d6de";
        //----------------------------------------------------------------------
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker("getDate");
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        //---------------- Validação de formulario -----------------------------
        form.append("arquivo", $("#fileUpload")[0].files[0]);
        form.append("periodo", termo);
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR LICENÇA AMBIENTAL]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/LicencasAmbientaisInsereDaq",
                    data: form,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        document.formularioLicencaAmbiental.reset();
                        CKEDITOR.instances["status_detalhado"].setData("");
                        CKEDITOR.instances["condicionantes_ambientais"].setData("");
                        $("#cadastroLicencasAmbientais").hide();
                        $("#novo_licencaAmbiental").show();
                        $.notify(data.mensagem, data.notify);
                        recuperaLicencaAmbiental()
                        $("#searchdate").click();
                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                    }
                });
            }
        });
    });
    //--------------------------------------------------------------------------
    function anexoLicencas(nome_arquivo) {
        $.ajax({
            url: 'anexoLicencas',
            type: 'POST',
            data: {nome_arquivo: nome_arquivo},
            success: function (data) {
                var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
                var anchor = document.createElement('a');
                anchor.setAttribute("download", nome_arquivo);
                anchor.setAttribute("href", arquivo);
                anchor.click();
                $.notify('Download!', "success");
                excluirLicensas(nome_arquivo);
            }, error: function (data) {
                $.notify('Falha no download!', "warning");
            }
        });
    }
    //--------------------------------------------------------------------------
    $("#btnNoAtividade").click(function () {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker("getDate");
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        var relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            //------------------------------------------------------------------
            bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "index_cgop.php/insereNaoAtividadelsDaq",
                        data: {periodo: termo},
                        dataType: "json",
                        success: function (data) {
                            $.notify("Não houve este mês!", "success");
                            var table = $("#tableLicencasAmbientais").DataTable();
                            table.ajax.reload();
                            confereNaoAtividade();
                        }, error: function (data) {
                            $.notify("Falha no cadastro", "warning");
                        }
                    });
                }
            });
        }
    });
});

//------------------------------------------------------------------------------
function excluirLicensas(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgop.php/excluirLicensas',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Excluido com Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//-----------------------------------------------------------------------------
//------------------------------------------------------------------------------
function recuperaLicencaAmbiental() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker("getDate");
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    
    // confereNaoAtividade();
    $("#novo_licencaAmbiental").show();
    $("#cadastroLicencasAmbientais").hide();
    $("#tableLicencasAmbientais").dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/LicencasAmbientaisRecuperaDaq?periodo="+termo,
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: "LICENCA", "sClass": "text-center", "width": "10%"},
            {data: "TIPO", "sClass": "text-center", "width": "10%"},
            {data: "DATA_VIGENCIA", "sClass": "text-center", "width": "10%"},
            {data: "SOLICITACAO_RENOVACAO_CADASTRO", "sClass": "text-center", "width": "2%"},
            {data: "OBSERVACAO", "sClass": "text-justify", "width": "40%"},
            {data: "ARQUIVO", "width": "20%"},
            {data: "NOME", "sClass": "text-center", "width": "10%"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
            {data: "ACAO", "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirArquivo(id_licenca_ambiental, id_arquivo) {
    // relatorio = confereRelatorio();
    // if (relatorio == 1) {
    //     mensagemRelatorioFechado();
    // } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/LicencasAmbientaisExcluirDaq",
                    data: {id_licenca_ambiental: id_licenca_ambiental, id_arquivo: id_arquivo},
                    dataType: "json",
                    success: function (data) {
                        $.notify("Removido com sucesso!", "success");
                        var table = $("#tableLicencasAmbientais").DataTable();
                        table.ajax.reload();
                        //confereNaoAtividade();
                    }, error: function (jqXHR, textStatus, errorMessage) {
                        $.notify("Ocorreu um erro: " + errorMessage, "warning");
                    }
                });
            }
        });
    //}
}
//------------------------------------------------------------------------------
function RecuperaLicencaEditar(id_licenca_ambiental) {
    // relatorio = confereRelatorio();
    // if (relatorio == 1) {
    //     mensagemRelatorioFechado();
    // } else {
        if (document.getElementById) {
        var dt = $("#datepicker").datepicker("getDate");
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
         populaTipoLicencaEditar();
        bootbox.confirm("Confirmar operação [EDITAR LICENÇA]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/LicencasAmbientaisRecEditarDaq",
                    data: {id_licenca_ambiental: id_licenca_ambiental , periodo: termo},
                    dataType: "json",
                    success: function (data) {
                      //------------------------------------------------------------------------------
                      $("#btnInclusao").hide();
                      $("#voltar").hide();
                      $("#searchdate").show();
                      $("#novo_licencaAmbiental").hide();
                      $("#cadastroLicencasAmbientais").hide();
                      $("#editarLicencasAmbientais").show();
                      //------------------------------------------------------------------------------
                      $("#licenca_Editar").val(data.licenca);
                      $("#licenca_Editar").prop('disabled', true);
                      $("#tipo_Editar").val(data.tipo);
                      $("#tipo_Editar").prop('disabled', true);
                      $("#orgaoEmissor_Editar").val(data.orgao_emissor);
                      $("#orgaoEmissor_Editar").prop('disabled', true);
                      $("#dataEmissao_Editar").val(data.emissao);
                      $("#dataEmissao_Editar").prop('disabled', true);
                      $("#terminoVigencia_Editar").val(data.termino_vigencia);
                      $("#terminoVigencia_Editar").prop('disabled', true);
                      $("#inicioVigencia_Editar").val(data.data_vigencia);
                      $("#inicioVigencia_Editar").prop('disabled', true);
                      $("#solicitacaoDataRenovacao_Editar").val(data.solicitacao_renovacao_cadastro);
                      $("#dataSolicitacaoRenovacao_Editar").val(data.data_solicitacao_renovacao);
                      CKEDITOR.instances['status_detalhado_Editar'].setData(data.observacoes);
                      CKEDITOR.instances['condicionantes_ambientais_Editar'].setData(data.condicionantes_ambientais);
                       $("#editar").val(id_licenca_ambiental);
                      //------------------------------------------------------------------------------                      
                      
                    }, error: function (jqXHR, textStatus, errorMessage) {
                        $.notify("Ocorreu um erro: " + errorMessage, "warning");
                    }
                });
            }
        });
    //}
}
//------------------------------------------------------------------------------
function editarLicencaAmbiental() {
//------------------ Verificação de campos -----------------------------
        var serializedData = validaformulario("formularioLicencaAmbientalEditar");
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();
        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }

        //----------------------------------------------------------------------
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker("getDate");
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR LICENÇA AMBIENTAL]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/LicencasAmbientaisEditarDaq",
                    data: form,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        document.formularioLicencaAmbiental.reset();
                        CKEDITOR.instances["status_detalhado"].setData("");
                        CKEDITOR.instances["condicionantes_ambientais"].setData("");
                        $("#cadastroLicencasAmbientais").hide();
                        $("#novo_licencaAmbiental").show();
                        $.notify("Editado  com sucesso!", "success");
                        recuperaLicencaAmbiental()
                        $("#searchdate").click();
                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                    }
                });
            }
        });    
}
//------------------------------------------------------------------------------
function populaTipoLicenca() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/LicencasAmbientaisTipoDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=tipo]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_tipo_licenca.length; i++) {
                servico.append('<option value="' + data.id_tipo_licenca[i] + '">' + data.desc_tipo_licenca[i] + '</option>');
            }
        }
    });
}
//------------------------------------------------------------------------------
function populaTipoLicencaEditar() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/LicencasAmbientaisTipoDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=tipo_Editar]');
             servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_tipo_licenca.length; i++) {
                servico.append('<option value="' + data.id_tipo_licenca[i] + '">' + data.desc_tipo_licenca[i] + '</option>');
            }
        }
    });
}
