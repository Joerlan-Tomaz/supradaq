//######################################################################################################################################################################################## 
//# DNIT
//# gestaotratativasView.js
//# Desenvolvedor:Jordana de Alencar
//# Data: 10/10/2019 13:00
//########################################################################################################################################################################################
/*--------------------------------------------------------------------------- */
$().ready(function () {
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //--------------------------------------------------------------------------
    CKEDITOR.replace("providencia", {height: 200});
    CKEDITOR.replace("status", {height: 200});
    CKEDITOR.replace("status_edita", {height: 200});
    //--------------------------------------------------------------------------
    $("#novo_gestaotratativa").hide();
    $("#cadastro_gestaotratativa").hide();
    $("#searchdate").hide();
    $("#cadastro_gestaotratativa_edita").hide();
    //--------------------------------------------------------------------------
    $("#datepicker").on("changeDate", function () {
        recuperaGestaoTratativa();
    });
    //--------------------------------------------------------------------------
    recuperaGestaoTratativa();
	table_naohouveatividademes();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaGestaoTratativa();
        $("#datepicker").prop("disabled", false);
        $("#btnInclusao").show();
        $("#searchdate").hide();
        $('#btnNoAtividade').show();
        $("#cadastro_gestaotratativa_edita").hide();
    });
    //--------------------------------------------------------------------------
    $("#filtroStatus").change(function () {
        recuperaGestaoTratativa();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        var relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $("#novo_gestaotratativa").hide();
            $("#cadastro_gestaotratativa").show();
            populaOrigem();
            populaResponsaveis();
            populaInfraEstrutura();
            $("#datepicker").prop("disabled", true);
            $("#btnInclusao").hide();
            $('#btnNoAtividade').hide();
            $("#searchdate").show();
        }
    });
     $("#editarGestaoTratativa").click(function () {
        $("#cadastro_gestaotratativa_edita").show();
        editarGestaoTratativa();
    });
    //--------------------------------------------------------------------------
    $("#btnNoAtividade").click(function () {
        btnNoAtividade();
    });
    //--------------------------------------------------------------------------
    $("#insereGestaoTratativa").click(function () {
         //------------------ Verificação de campos -----------------------------
        var nome_infraestrutura = $('#nome_infraestrutura').val();
        if (nome_infraestrutura == "") {
            $.notify("O campo [Nome da Infraestrutura] é obrigatório!", "warning");
            document.getElementById('nome_infraestrutura').style.borderColor = 'red';
            return false;

        } else {
            document.getElementById('origem').style.borderColor = '#d2d6de';
        }
        var origem = $('#origem').val();
        if (origem == "") {
            $.notify("O campo [Origem] é obrigatório!", "warning");
            document.getElementById('origem').style.borderColor = 'red';
            return false;

        } else {
            document.getElementById('origem').style.borderColor = '#d2d6de';
        }
        
        var dataSolicitacao = $('#dataSolicitacao').val();
        if (dataSolicitacao == "") {
                $.notify("O campo [Data de Solicitação] é obrigatório!", "warning");
                document.getElementById('dataSolicitacao').style.borderColor = 'red';
                return false;
               
            } else {
                document.getElementById('dataSolicitacao').style.borderColor = '#d2d6de';
        }
        
        var assunto = $('#assunto').val();
        if (assunto == "") {
                $.notify("O campo [Assunto] é obrigatório!", "warning");
                document.getElementById('assunto').style.borderColor = 'red';
                return false;
               
            } else {
                document.getElementById('assunto').style.borderColor = '#d2d6de';
        }
        
        var responsavel = $('#responsavel').val();
        if (responsavel == "") {
                $.notify("O campo [Responsável] é obrigatório!", "warning");
                document.getElementById('responsavel').style.borderColor = 'red';
                return false;
               
            } else {
                document.getElementById('responsavel').style.borderColor = '#d2d6de';
        }
        
        // var dataPactuada = $('#dataPactuada').val();
       /* if (dataPactuada == "") {
                $.notify("O campo [Data Pactuada] é obrigatório!", "warning");
                document.getElementById('dataPactuada').style.borderColor = 'red';
                return false;

            } else {
                document.getElementById('dataPactuada').style.borderColor = '#d2d6de';
        }*/

        var status = CKEDITOR.instances['status'].getData();
       
        if (status == '') {
             $.notify("O campo [Status] é obrigatório!", "warning");
            document.getElementById('status').style.borderColor = 'red';
            return false;
        } else {
            document.getElementById('status').style.borderColor = '#d2d6de';
        }

        var novaDataPactuada = $('#novaDataPactuada').val(); 
        var dataTermino = $('#dataTermino').val(); 
        
     //----------------------------------------------------------------------
        //------------------ Verificação de campos -----------------------------
        //var serializedData = validaformulario("formGestaoTratativa");
        var serializedData = $("#formGestaoTratativa").serializeArray();
        if (serializedData == false) {
            $.notify("Preencha os campos obrigatórios", "warning");
            return false;
        }
        //----------------------------------------------------------------------
        var termo = new Object();
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker("getDate");
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        serializedData.push(termo);
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR GESTÃO DE TRATATIVAS]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/GestaoTratativaInsereDaq",
                    data: serializedData,
                    dataType: "json",
                    success: function (data) {
                        document.formGestaoTratativa.reset();
                        $("#cadastro_gestaotratativa").hide();
                        $("#novo_gestaotratativa").show();
                        $.notify("Cadastrado com sucesso!", "success");
                        var table = $("#tableGestaoTratativa").DataTable();
                        table.ajax.reload();
                        $("#searchdate").click();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    });
    //-------------------------------------------------------------------- 
    $("#insereProvidencia").click(function () {
        if($("#situacao_gestao_tratativa").val()== "" || $("#situacao_gestao_tratativa").val()== "Selecione"){
            document.getElementById('situacao_gestao_tratativa').style.borderColor = 'red';
            $.notify("Informe o campo [Status]", "warning");
            return false
        }else {
                document.getElementById('situacao_gestao_tratativa').style.borderColor = '#d2d6de';
        }
        var providencia = CKEDITOR.instances['providencia'].getData();
   
        if (providencia == '') {
             $.notify("O campo [providencia] é obrigatório!", "warning");
            document.getElementById('providencia').style.borderColor = 'red';
            return false;
        } else {
            document.getElementById('providencia').style.borderColor = '#d2d6de';
        }
        var relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            var situacao_gestao_tratativa = $("#situacao_gestao_tratativa").val();
            var id_gestao_tratativa = $("#id_gestao_tratativa").val();
            var providencia = CKEDITOR.instances["providencia"].getData();
            //----------------------------------------------------------------------
            if (document.getElementById) {
                var dt = $("#datepicker").datepicker("getDate");
                if (dt.toString() === "Invalid Date") {
                    $("#datepicker").datepicker("setDate", new Date());
                    return;
                }
                var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
            }
            //-------------------------------------------------------------------- 
            bootbox.confirm("Confirmar operação [INSERIR PROVIDÊNCIA]?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "index_cgop.php/GestaoTratativaInsereProvDaq",
                        data: {
                            status: situacao_gestao_tratativa,
                            id_gestao_tratativa: id_gestao_tratativa,
                            providencia: providencia,
                            periodo: termo
                        },
                        dataType: "json",
                        success: function (data) {
                            $.notify("Cadastrado com Sucesso!", "success");
                            var table = $("#tableGestaoTratativa").DataTable();
                            table.ajax.reload();
                            tableprovidencia = $("#tableProvidenciaGestaotratativa").DataTable();
                            tableprovidencia.ajax.reload();
                            document.formularioProvidencia.reset();
                            CKEDITOR.instances["providencia"].setData("");
                            if (data.status == "Fechado") {
                                $("#modalSituacao").modal("hide");
                                recuperaGestaoTratativa();
                            }
                        }, error: function (data) {
                            $.notify("Erro no Envio", "warning");
                        }
                    });
                }
            });
         }
    });
});
function btnNoAtividade() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

    }
    //----------------------------------------------------------------------------------------------------------------------------------------
    bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADE NO MÊS]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/GestaoTratativaInsereAtividadeDaq',
                data: {
                    periodo: termo
                },
                dataType: 'json',
                success: function (data) {

                    $.notify('Cadastrado com sucesso!', "success");
                    table_naohouveatividademes();
                   
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                    
                }
            });
        }
    });
}
//------------------------------------------------------------------------------------------------------------------------------

function ReturnEditarGestaoTratativa(id_gestao_tratativa) {
    
if (document.getElementById) {
    var dt = $("#datepicker").datepicker("getDate");
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    bootbox.confirm("Confirmar operação [EDITAR GESTÂO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/GestaoTratativaReturnEditarDaq',
                data: {id_gestao_tratativa: id_gestao_tratativa, periodo: termo},
                dataType: 'json',
                success: function (data) {
                    $("#searchdate").show();
                    $('#btnInclusao').hide();
                    $('#novo_gestaotratativa').hide();
                    $('#cadastro_gestaotratativa_edita').show();

                    $("#origem_edita").val(data.origem_edita);
                    $("#dataSolicitacao_edita").val(data.dataSolicitacao_edita);
                    $("#assunto_edita").val(data.assunto_edita);
                    $("#responsavel_edita").val(data.responsavel_edita);
                    $("#dataPactuada_edita").val(data.dataPactuada_edita);

                    $("#novaDataPactuada_edita").val(data.novaDataPactuada_edita);
                    $("#dataTermino_edita").val(data.dataTermino_edita);
                    CKEDITOR.instances["status_edita"].setData(data.status_edita);
                  
                    $("#origem_edita").prop('disabled', true);
                    $("#dataSolicitacao_edita").prop('disabled', true);
                    $("#assunto_edita").prop('disabled', true);
                    $("#responsavel_edita").prop('disabled', true);
                    $("#dataPactuada_edita").prop('disabled', true);
                    $("#editar").val(id_gestao_tratativa);
                    
                }, error: function (data) {
                    $.notify('Falha na edição', "warning");
                }
            });
        }
    });
}

//------------------------------------------------------------------------------
function editarGestaoTratativa() {
//------------------ Verificação de campos -----------------------------
        var serializedData = validaformulario("formGestaoTratativa_edita");
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
        bootbox.confirm("Confirmar operação [INSERIR GESTÃO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/GestaoTratativaEditarDaq",
                    data: form,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        document.formGestaoTratativa.reset();
                        CKEDITOR.instances["status"].setData("");
                        
                        $("#cadastro_gestaotratativa_edita").hide();
                        $("#novo_gestaotratativa").show();
                        $.notify("Editado  com sucesso!", "success");
                        recuperaGestaoTratativa()
                        $("#searchdate").click();
                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                    }
                });
            }
        });    
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function table_naohouveatividademes() { 
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
        url: base_url + 'index_cgop.php/GestaoTratativaNaoAtividadeDaq?periodo='+termo,
        data: {periodo: termo},
        dataType: 'json',
        success: function (data) {
            if (data.atividade == true) {
                 $("#btnNoAtividade").attr("disabled", true);
                 $("#btnInclusao").attr("disabled", true);
                 $('#searchdate').hide();
                 $('#novo_gestaotratativa').hide();
                 $('#cadastro_gestaotratativa').hide();
                 $('#naohouveatividademes').show();
                 
                var table = $('#tableNaohouveAtividadeMes').DataTable();
                table.destroy();

                $('#tableNaohouveAtividadeMes').dataTable({
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
                    "sAjaxSource": base_url + "index_cgop.php/GestaoTratativaNaoAtividadeDaq?periodo="+termo,
                    "aoColumns": [
                        {data: 'atividademes'},
                        {data: 'usuario'},
                        {data: 'ultima_alteracao'},
                        {data: 'acoes'}

                    ]
                });
            } else if(data.gestao == true){
                // $("#naohouveatividademes").hide();
                $("#btnNoAtividade").attr("disabled", true);
                $("#btnInclusao").attr("disabled", false);
                $('#novo_gestaotratativa').show();
                $('#cadastro_gestaotratativa').hide();
                $('#naohouveatividademes').hide();
            } else {
				$("#naohouveatividademes").hide();
				$("#btnNoAtividade").attr("disabled", false);
				$("#btnInclusao").attr("disabled", false);
				$('#novo_gestaotratativa').show();
				$('#cadastro_gestaotratativa').hide();
				$('#naohouveatividademes').hide();
			}
        }
    });
}
//------------------------------------------------------------------------------
function recuperaGestaoTratativa() {
    table_naohouveatividademes();
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $("#novo_gestaotratativa").show();
    $("#cadastro_gestaotratativa").hide();
    var status = $("#filtroStatus").val();
    $("#tableGestaoTratativa").dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/GestaoTratativaRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push(
                    {"name": "periodo", "value": termo},
                    {"name": "status", "value": status}
            );
        },
        "aoColumns": [
            {data: "PERIODO", "sClass": "text-center", "width": "10%"},
            {data: "INFRAESTRUTURA", "sClass": "text-center", "width": "10%"},
            {data: "STATUS", "sClass": "text-center", "width": "10%"},
            {data: "ASSUNTO", "sClass": "text-justify", "width": "20%"},
            {data: "ORIGEM", "sClass": "text-center", "width": "10%"},
            {data: "RESPONSAVEL", "sClass": "text-center", "width": "10%"},
            {data: "DATA_SOLICITACAO", "sClass": "text-center", "width": "15%"},
            {data: "DATA_TERMINO", "sClass": "text-center", "width": "15%"},
            {data: "DESCRICAO", "sClass": "text-center", "width": "10%"},
            {data: "PROVIDENCIA", "sClass": "text-center", "width": "10%"},
            {data: "USUARIO", "sClass": "text-center", "width": "10%"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
            {data: "ACAO", "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirGestaoTratativa(id_gestao_tratativa) {
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/GestaoTratativaExcluirDaq",
                    data: {id_gestao_tratativa: id_gestao_tratativa},
                    dataType: "json",
                    success: function (data) {
                        $.notify("Removido com sucesso!", "success");
						table_naohouveatividademes();
                        var table = $("#tableGestaoTratativa").DataTable();
                        table.ajax.reload();
                    }, error: function (jqXHR, textStatus, errorMessage) {
                        $.notify("Ocorreu um erro: " + errorMessage, "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------
function populaOrigem() {
    $.ajax({
        type: "POST",
        url: base_url + "index_cgop.php/GestaoTratativaOriginDaq",
        dataType: "json",
        success: function (data) {
            var servico = $('select[id=origem]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_origem.length; i++) {
                servico.append('<option value="' + data.id_origem[i] + '">' + data.desc_origem[i] + '</option>');
            }
        }
    });
}
//------------------------------------------------------------------------------
function populaResponsaveis() {
    $.ajax({
        type: "POST",
        url: base_url + "index_cgop.php/GestaoTratativaRespDaq",
        dataType: "json",
        success: function (data) {
            var servico = $('select[id=responsavel]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_responsavel.length; i++) {
                servico.append('<option value="' + data.id_responsavel[i] + '">' + data.desc_responsavel[i] + '</option>');
            }
        }
    });
}
//------------------------------------------------------------------------------
function modalStatus(id_gestao_tratativa) {
    $("#modalStatus").modal("show");
    $.ajax({
        type: "POST",
        url: base_url + "index_cgop.php/GestaoTratativaModalDaq",
        data: {id_gestao_tratativa: id_gestao_tratativa},
        dataType: "json",
        success: function (data) {
            $("#status_modal").html(data.descricao);
        }
    });
}
//------------------------------------------------------------------------------   
function modalSituacao(id_gestao_tratativa, st) {
    $("#modalSituacao").modal();
    $("#id_gestao_tratativa").val(id_gestao_tratativa);
    $("#situacao_gestao_tratativa").val(st);
    if (st == "Fechado") {
        $("#situacao_gestao_tratativa").prop("disabled", true);
        $("#insereProvidencia").prop("disabled", true);
        CKEDITOR.instances["providencia"].setReadOnly(true);
    } else {
        $("#situacao_gestao_tratativa").prop("disabled", false);
        $("#insereProvidencia").prop("disabled", false);
        CKEDITOR.instances["providencia"].setReadOnly(false);
    }
    $('#tableProvidenciaGestaotratativa').dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/GestaoTratativaRecuperaProvDaq",
        "fnServerParams": function (aoData) {
             aoData.push(
                    {"name": "id_gestao_tratativa", "value": id_gestao_tratativa},
                    {"name": "st", "value": st});
        },
        "aoColumns": [
            {data: "DESCRICAO", "sClass": "text-justify", "width": "50%"},
            {data: "USUARIO", "sClass": "text-center", "width": "20%"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "20%"},
            {data: "ACAO", "sClass": "text-center", "width": "10%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirProvidencia(id_providencia) {
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/GestaoTratativaExcluirProvDaq",
                    data: {id_providencia: id_providencia},
                    dataType: "json",
                    success: function (data) {
                        $.notify("Removido com sucesso!", "success");
                        var table = $("#tableProvidenciaGestaotratativa").DataTable();
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

function NaoHouveAtividadedaq(id) {
    bootbox.confirm("Confirmar operação [EXCLUIR]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/GestaoTratativaNaoAtvDaq?id=' + id,
                dataType: 'json',
                success: function (data) {
                    $.notify('[EXCLUIR] efetuado com  sucesso!', "success");
                   table_naohouveatividademes();
                }, error: function (data) {
                    $.notify('Falha na operação', "warning");
                    
                }
            });
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function populaInfraEstrutura() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/LicencasAmbientaisNomeInfraDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=nome_infraestrutura]');
			servico.html('');
			servico.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.id_tipo_licenca.length; i++) {
				servico.append('<option value="' + data.id_tipo_licenca[i] + '">' + data.desc_tipo_licenca[i] + '</option>');
			}
		}
	});
}
