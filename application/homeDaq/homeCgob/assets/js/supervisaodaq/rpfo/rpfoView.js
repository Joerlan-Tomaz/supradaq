//######################################################################################################################################################################################################################## 
//# DNIT
//# rpfoView.js
//# Desenvolvedor:jordana
//# Data: 10/10/2019 
//########################################################################################################################################################################################################################

$().ready(function () {
    $('#searchdate').hide();
    $('#cadastroRPFO_editar').hide();
    $('#alterarRpfo').hide();
    
    //--------------------------------------------------------------------------
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //--------------------------------------------------------------------------
    CKEDITOR.replace('motivacao', {
        height: 200
    });
    CKEDITOR.replace('statusDetalhado', {
        height: 200
    });
    CKEDITOR.replace('analistasResponsavel', {
        height: 200
    });
    //--------------------------------------------------------------------------
   /* $("#numero").select2({
        tags: true
    });*/
    //--------------------------------------------------------------------------
    $('#novo_rpfo').show();
    $('#cadastroRPFO').hide();
    $('#historico_rpfo').hide();
    $('#cadastroRPFOHistorico').hide();
    $('#cadastroRPFOAnexo').hide();
    $('#anexos_rpfo').hide();
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        $.ajaxSetup({cache: false});
        recuperaRpfo();
    });
    //--------------------------------------------------------------------------
    recuperaRpfo();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaRpfo();
        $('#novo_rpfo').show();
        $('#cadastroRPFO').hide();
        $('#searchdate').hide();
        $('#btnInclusao').show();
        $('#btnNoAtividade').show();
        $('#alteraRPFO').hide();
        $('#insereRPFO').show();

    });
    //--------------------------------------------------------------------------
    //  $("#status").change(function () { 
    //     if (this.value == "ACEITO" || this.value == "ACEITO COM PENDENCIA") {
    //        $('#aprovada').show();
    //        $('#andamento').hide();
    //        $("fileUpload").prop("disabled", false);
    //     } else {
    //        $('#aprovada').hide();
    //        $('#andamento').show();
    //        $("fileUpload").prop("disabled", false);
    //     }
    // });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
    	relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			relatorio = confereRelatorio();
			if (relatorio == 1) {
				mensagemRelatorioFechado();
			} else {
				$('#novo_rpfo').hide();
				$('#cadastroRPFO').show();
				// populaRPFO();
				//$("datepicker").prop("disabled", true);
				confereNaoAtividade();
				$('#searchdate').show();
				$('#btnInclusao').hide();
				$('#btnNoAtividade').hide();
				$('#alteraRPFO').hide();
				$('#insereRPFO').show();
				$('#historico_rpfo').hide();
				$('#cadastroRPFOHistorico').hide();
				$('#cadastroRPFOAnexo').hide();

				limpaCampos();
			}
		}
    });
    //--------------------------------------------------------------------------
     $("#insereRPFO").click(function () {
		 relatorio = confereRelatorio();
		 if (relatorio == 1) {
			 mensagemRelatorioFechado();
		 } else {
			 insereRPFO();
		 }
     });
	$("#insereRPFOHistorico").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			insereRPFOHistorico();
		}
	});
	$("#fecharRPFOHistorico").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			fecharRPFOHistorico();
		}
	});
	$("#insereRPFOAnexo").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			insereRPFOAnexo();
		}
	});

	$('#local').on('change', function() {
		var local = this.value;
		$.ajax({
			url: base_url + 'index_cgob.php/RpfoStatusDaq',
			type: 'POST',
			dataType: 'json',
			data: {uf: this.value},
			success: function (obj) {
				if (obj != null) {
					var selectbox = $('#status');
					selectbox.find('option').remove();
					$('<option>').val('').text('Selecione.. ').appendTo(selectbox);
					for (i = 0; i < obj.id_status.length; i++) {
						if(local == '7'){
							if(obj.id_status[i] == 6 || obj.id_status[i] == 7){
								selectbox.append('<option value="' + obj.id_status[i] + '">' + obj.desc_status[i] + '</option>');
							}
						}else {
							if(obj.id_status[i] < 6){
								selectbox.append('<option value="' + obj.id_status[i] + '">' + obj.desc_status[i] + '</option>');
							}
						}
					}
				}
			}, error: function (data) {
				$.notify('Falha no cadastro', "warning");
			}
		});
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
            //------------------------------------------------------------------
            bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "index_cgob.php/RpfoinsereNaoAtividadeDaq",
                        data: {periodo: termo},
                        dataType: "json",
                        success: function (data) {
                            $.notify("Não houve atividades este mês!", "success");
                            var table = $("#tableRpfo").DataTable();
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
    //--------------------------------------------------------------------------
     $("#alteraRPFO").click(function () {
         alteraRPFO();         
     });
});
//------------------------------------------------------------------------------
function recuperaRpfo() {

    $("datepicker").prop("disabled", false);
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    confereNaoAtividade();
    $('#tableRpfo').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/RpfoRecuperaDaq?periodo="+termo,
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'RPFO', "sClass": "text-justify", "width": "10%"},
            {data: 'LOCAL', "sClass": "text-center", "width": "10%"},
            {data: 'STATUS', "sClass": "text-center", "width": "10%"},
            {data: 'PARECER', "sClass": "text-center", "width": "10%"},
            {data: 'OBSERVACAO', "sClass": "text-center", "width": "10%"},
            {data: 'USUARIO', "sClass": "text-center", "width": "10%"},
            {data: 'ATUALIZACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirRpfo(id_rpfo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR RPFO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/RpfoExcluirDaq',
					data: {id_rpfo: id_rpfo},
					dataType: 'json',
					success: function (data) {
						confereNaoAtividade();
						$.notify(data.mensagem, data.notify);
						var table = $("#tableRpfo").DataTable();
						table.ajax.reload();
					}, error: function (data) {
						$.notify(data.mensagem, data.notify);
					}
				});
			}
		});
	}
}

function populaLocal() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RpfoLocalDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=local]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_local.length; i++) {
                servico.append('<option value="' + data.id_local[i] + '">' + data.desc_local[i] + '</option>');
            }
        }
    });
}
//------------------------------------------------------------------------------
function anexoRpfo(nome_arquivo) {
    var nome_arquivo = $('#arquivo_modal_rpfo').val();
    $.ajax({
        url: base_url + 'index_cgob.php/anexoRpfo',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluiRpfo(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
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
        url: base_url + 'index_cgob.php/RpfoConfereAtvDaq',
        data: {periodo: termo},
        dataType: 'json',
        success: function (data) {
            if (data.situacao === "Com Registro") {
                if ($("#btnInclusao").length) {
                    document.getElementById("btnInclusao").disabled = false;
                }
                if ($("#btnNoAtividade").length) {
                    document.getElementById("btnNoAtividade").disabled = true;
                }
            } else if (data.situacao === "Sem atividade") {
                if ($("#btnInclusao").length) {
                    document.getElementById("btnInclusao").disabled = true;
                }
                if ($("#btnNoAtividade").length) {
                    document.getElementById("btnNoAtividade").disabled = true;
                }
            } else if ("Sem Registros") {
                if ($("#btnInclusao").length) {
                    document.getElementById("btnInclusao").disabled = false;
                }
                if ($("#btnNoAtividade").length) {
                    document.getElementById("btnNoAtividade").disabled = false;
                }
            }
        }
    });
}
//------------------------------------------------------------------------------
function modalStatusDetalhado(id_rpfo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RpfoStatusDetalhadoDaq',
        data: {id_rpfo: id_rpfo},
        dataType: 'json',
        success: function (data) {
            $("#modalStatusDetalhado").modal("show");
            $("#status_detalhado_modal_rpfo").html(data.status_detalhado);
            $("#motivacao_modal_rpfo").html(data.motivacao);
            $("#analistas_responsavel_modal_rpfo").html(data.analista_responsavel);
        }
    });
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function insereRPFO(){
//------------------ Verificação de campos -----------------------------
        var serializedData = validaformulario("formRpfo");
       
        $("#formRpfo").serializeArray();
        if (serializedData == false) {
            $.notify("Preencha os campos obrigatórios", "warning");
            return false;
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();

        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }
        //--------------------------------------------------------------------------
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker("getDate");
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        form.append("periodo", termo);
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR RPFO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgob.php/RpfoInsereDaq",
                    data: form,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        $.notify(data.mensagem, data.notify);
                        CKEDITOR.instances["motivacao"].setData();
                        CKEDITOR.instances["statusDetalhado"].setData();
                        CKEDITOR.instances["analistasResponsavel"].setData();

                        $("#novo_rpfo").show();
                        $("#cadastroRPFO").hide();
                        var table = $("#tableRpfo").DataTable();
                        	table.ajax.reload();
                        confereNaoAtividade();
                        $('#searchdate').hide();
						$('#btnNoAtividade').show();
                        $('#btnInclusao').show();
						$('#historico_rpfo').hide();
						$('#cadastroRPFOHistorico').hide();
						$('#cadastroRPFOAnexo').hide();

                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                        // console.log(data);

                    }
                });
            }
        });
}
//------------------------------------------------------------------------------------------------------
function limpaCampos(){

    CKEDITOR.instances["motivacao"].setData("");

    CKEDITOR.instances["statusDetalhado"].setData("");

    CKEDITOR.instances["analistasResponsavel"].setData("");

    $("#numero").val("");

    $("#local").val("");

    $("#status").val("");

    $("#parecerEmissao").val("");
    $("#fileUpload").val("");

}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function editarRpfo(id_rpfo){
  relatorio = confereRelatorio();
     if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RpfoEdicaoDaq',
        data: {id_rpfo: id_rpfo},
        dataType: 'json',
        success: function (data) {
                      
            $('#alteraRPFO').show();
            $('#insereRPFO').hide();
            $('#searchdate').show();
            $('#btnInclusao').hide();
            $('#btnNoAtividade').hide();
            $("#numero").val(data.numero);
            $("#parecerEmissao").val(data.previsao);
            CKEDITOR.instances["motivacao"].setData(data.motivacao);
            CKEDITOR.instances["statusDetalhado"].setData(data.status_detalhado);
            CKEDITOR.instances["analistasResponsavel"].setData(data.analista_responsavel);

            $('#novo_rpfo').hide();
            $('#cadastroRPFO').show();
            $('#id_rpfo').val(data.id_rpfo);

        }, error: function (data) {
           $.notify("Falha na consulta", "warning");

        }
    });
 }
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function alteraRPFO(){
//------------------ Verificação de campos -----------------------------
        var serializedData = validaformulario("formRpfo");
       
        $("#formRpfo").serializeArray();
        if (serializedData == false) {
            $.notify("Preencha os campos obrigatórios", "warning");
            return false;
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();

        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }
        //--------------------------------------------------------------------------
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker("getDate");
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        form.append("periodo", termo);
        var id_rpfo = $('#id_rpfo').val();
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [EDITAR RPFO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgob.php/RpfoAlteraDaq?id_rpfo="+id_rpfo,
                    data: form,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        $.notify(data.mensagem, data.notify);
                        CKEDITOR.instances["motivacao"].setData();
                        CKEDITOR.instances["statusDetalhado"].setData();
                        CKEDITOR.instances["analistasResponsavel"].setData();

                        $("#novo_rpfo").show();
                        $("#cadastroRPFO").hide();
                        var table = $("#tableRpfo").DataTable();
                        table.ajax.reload();
                        $('#searchdate').hide();
                        $('#btnInclusao').show();
                    }, error: function (data) {
                        $.notify("Falha na edicao", "warning");

                    }
                });
            }
        });
}

function gestaoRpfo(id_rpfo){
	populaLocal();
	// populaStatus();
	$('#id_rpfoHistorico').val(id_rpfo);
	$('#alteraRPFOHistorico').hide();
	$('#historico_rpfo').show();
	$('#cadastroRPFOHistorico').show();
	recuperaRpfoHistorico(id_rpfo);
}

function insereRPFOHistorico(){
	var serializedData = validaformulario("formRpfoHistorico");
	if (serializedData == false) {
		$.notify("Preencha os campos obrigatórios", "warning");
		return false;
	}
	//---------------- Validação de formulario -----------------------------
	var form = new FormData();

	for (i = 0; i < serializedData.length; i++) {
		form.append(serializedData[i].name, serializedData[i].value);
	}
	bootbox.confirm("Confirmar operação [INSERIR RPFO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgob.php/RpfoInsereHistorico",
				data: form,
				dataType: "json",
				contentType: false,
				processData: false,
				cache: false,
				success: function (data) {
					$.notify(data.mensagem, data.notify);
					var table = $("#tableRpfoHistorico").DataTable();
						table.ajax.reload();
					var table = $("#tableRpfo").DataTable();
						table.ajax.reload();
					$('#searchdate').hide();
					$('#btnInclusao').show();
				}, error: function (data) {
					$.notify("Falha no cadastro", "warning");
				}
			});
		}
	});
}

//------------------------------------------------------------------------------
function recuperaRpfoHistorico(id_rpfo) {

	$("datepicker").prop("disabled", false);
	$('#tableRpfoHistorico').dataTable({
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
		"sAjaxSource": base_url + "index_cgob.php/RpfoRecuperaHistorico?id_prfo=" + id_rpfo ,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "id_prfo": id_rpfo});
		},
		"aoColumns": [
			{data: 'RPFO', "sClass": "text-justify", "width": "10%"},
			{data: 'LOCAL', "sClass": "text-center", "width": "10%"},
			{data: 'STATUS', "sClass": "text-center", "width": "10%"},
			{data: 'OBSERVACAO', "sClass": "text-center", "width": "10%"},
			{data: 'USUARIO', "sClass": "text-center", "width": "10%"},
			{data: 'ATUALIZACAO', "sClass": "text-center", "width": "10%"},
			{data: 'ACAO', "sClass": "text-center", "width": "5%"}
		]
	});
}

function anexoRpfo(id_rpfo_historico){
	$('#id_rpfo_historico').val(id_rpfo_historico);
	$('#anexos_rpfo').show();
	$('#cadastroRPFOAnexo').show();
	recuperaRpfoAnexo(id_rpfo_historico);
}

function insereRPFOAnexo(){
	var serializedData = validaformulario("formRpfoAnexo");

	if (serializedData == false) {
		$.notify("Preencha os campos obrigatórios", "warning");
		return false;
	}
	//---------------- Validação de formulario -----------------------------
	var form = new FormData();

	var fileUpload = $("#fileUpload").val();
	if (fileUpload === "") {
		document.getElementById("fileUpload").style.borderColor = "red";
		$.notify("Insira o arquivo!", "warning");
		return false;
	} else {
		document.getElementById("fileUpload").style.borderColor = '#d2d6de';
	}
	form.append("arquivo", $("#fileUpload")[0].files[0]);

	for (i = 0; i < serializedData.length; i++) {
		form.append(serializedData[i].name, serializedData[i].value);
	}
	//----------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [INSERIR ARQUIVO NO RPFO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgob.php/RpfoInserirArquivo",
				data: form,
				dataType: "json",
				contentType: false,
				processData: false,
				cache: false,
				success: function (data) {
					$.notify(data.mensagem, data.notify);
					var table = $("#tableRpfoHistorico").DataTable();
						table.ajax.reload();
					var table = $("#tableRpfoAnexo").DataTable();
						table.ajax.reload();
					$('#cadastroRPFOAnexo').hide();
					$('#id_rpfoHistorico').val($('#id_rpfoAnexo').val());
					// $('#cadastroRPFOHistorico').show();

				}, error: function (data) {
					$.notify("Falha no cadastro", "warning");
                                        console.log(data);
				}
			});
		}
	});
}


//------------------------------------------------------------------------------
function recuperaRpfoAnexo(id_rpfoHistorico) {

	$("datepicker").prop("disabled", false);
	$('#tableRpfoAnexo').dataTable({
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
		"sAjaxSource": base_url + "index_cgob.php/RpfoRecuperaAnexo?id_prfoHistorico=" + id_rpfoHistorico ,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "id_rpfoHistorico": id_rpfoHistorico});
		},
		"aoColumns": [
			{data: 'RPFO', "sClass": "text-justify", "width": "10%"},
			{data: 'ARQUIVO', "sClass": "text-center", "width": "10%"},
			{data: 'USUARIO', "sClass": "text-center", "width": "10%"},
			{data: 'ATUALIZACAO', "sClass": "text-center", "width": "10%"},
			{data: 'ACAO', "sClass": "text-center", "width": "5%"}
		]
	});
}

//------------------ Verificação -----------------------------
function modelorpfo(nome_arquivo) { 
	$.ajax({
        type: "POST",
        url: base_url + "index_cgob.php/RpfoModelo",
        data: {nome_arquivo: nome_arquivo},
        dataType: "json",
        success: function (data) {
            $.notify("Download com sucesso!", "success");
        }, error: function (data) {
            $.notify("Falha no download", "warning");
        }
    });
}
function anexoHistorico_old_12102021_1129(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgob.php/anexoGeo',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download realizado com sucesso!', "success");
			excluirGeo(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}
//------------------------------------------------------------------------------
function excluirRpfoHistorico(id_rpfoHistorico) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR HISTÓRICO RPFO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/RpfoExcluirHistorico',
					data: {id_rpfoHistorico: id_rpfoHistorico},
					dataType: 'json',
					success: function (data) {
						$.notify(data.mensagem, data.notify);
						var table = $("#tableRpfoHistorico").DataTable();
							table.ajax.reload();
						var table = $("#tableRpfo").DataTable();
							table.ajax.reload();
					}, error: function (data) {
						$.notify(data.mensagem, data.notify);
					}
				});
			}
		});
	}
}

//------------------------------------------------------------------------------
function excluirAnexo(id_rpfo_anexo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR ANEXO DO RPFO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/RpfoExcluirAnexo',
					data: {id_rpfo_anexo: id_rpfo_anexo},
					dataType: 'json',
					success: function (data) {
						$.notify(data.mensagem, data.notify);
						var table = $("#tableRpfoAnexo").DataTable();
							table.ajax.reload();
						var table = $("#tableRpfoHistorico").DataTable();
							table.ajax.reload();
					}, error: function (data) {
						$.notify(data.mensagem, data.notify);
					}
				});
			}
		});
	}
}

function fecharRPFOHistorico(){
	$('#historico_rpfo').hide();
	$('#cadastroRPFOHistorico').hide();
	$('#cadastroRPFOAnexo').hide();
	$('#anexos_rpfo').hide();
}
