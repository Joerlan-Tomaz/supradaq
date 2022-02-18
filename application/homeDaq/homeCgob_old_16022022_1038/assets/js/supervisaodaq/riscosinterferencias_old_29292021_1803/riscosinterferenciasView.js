//######################################################################################################################################################################################## 
//# DNIT
//# riscosinterferenciasView.js
//# Desenvolvedor:jordana de Alencar 
//# Data: 15/11/2019 
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	//--------------------------------------------------------------------------
	CKEDITOR.replace('resumoInterferencias', {
		height: 250
	});
	CKEDITOR.replace('providencia', {
		height: 250
	});
	CKEDITOR.replace('resumoInterferenciasEditar', {
		height: 250
	});
	CKEDITOR.replace('providenciaEditar', {
		height: 250
	});
	//--------------------------------------------------------------------------
	$('#nova_interferencia').hide();
	$('#cadastroInterferencia').hide();
	$('#EditarcadastroInterferencia').hide();
	$('#searchdate').hide();
	//--------------------------------------------------------------------------
	$('#datepicker').on("changeDate", function () {
		$.ajaxSetup({cache: false});
		recuperaInterferencias();
		// confereNaoAtividade();
	});
	//--------------------------------------------------------------------------
	recuperaInterferencias();
	// confereNaoAtividade();
	//--------------------------------------------------------------------------
	$("#searchdate").click(function () {
		recuperaInterferencias();
		// confereNaoAtividade();
		document.getElementById("datepicker").disabled = false;
		$('#searchdate').hide();
		$('#btnInclusao').show();
		$('#btnNoAtividade').show();
		$('#EditarcadastroInterferencia').hide();
	});
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			$('#nova_interferencia').hide();
			$('#cadastroInterferencia').show();
			document.getElementById("datepicker").disabled = true;
			if ($("#btnNoAtividade").length) {
				document.getElementById("btnNoAtividade").disabled = true;
			}
			recupera_TipoInterferencia();
			recupera_GrauImpacto();
			recupera_Classificacao();
			populaTipoEixo();
			// recuperaBr();
			$('#searchdate').show();
			$('#btnInclusao').hide();
			$('#btnNoAtividade').hide();
			$('#EditarcadastroInterferencia').hide();
		}
	});
	//--------------------------------------------------------------------------
	$("#btnNoAtividade").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			btnNoAtividade();
		}
	});
	//--------------------------------------------------------------------------
	$("#insereInterferencia").click(function () {
		if ($('#kmInicial').val() == '') {
			document.getElementById("kmInicial").disabled = true;
		}
		if ($('#kmFinal').val() == '') {
			document.getElementById("kmFinal").disabled = true;
		}
		//------------------ Verificação de campos -----------------------------
		serializedData = validaformulario("formularioInterferencia");
		if (serializedData == false) {
			$.notify('Preencha os campos obrigatorios', "warning");
			return false;
		}

		var strData = $('#previsaoSolucao').val();
		var partesData = strData.split("/");
		var data = new Date(partesData[2], partesData[1] - 1, partesData[0]);
		if (data <= new Date()) {
			$.notify("O campo [Previsao da Solução] não pode ser menor, ou igual a data atual!", 'warning');
			return false;
		}
		//---------------- Validação de formulario -----------------------------
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
		//----------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [INSERIR RISCO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/InterferenciaInsereDaq',
					data: serializedData,
					dataType: 'json',
					success: function (data) {
						$('#nova_interferencia').show();
						$('#cadastroInterferencia').hide();
						// var tableInterferencia = $("#tableInterferencia").DataTable();
						// tableInterferencia.ajax.reload();
						document.formularioInterferencia.reset();
						CKEDITOR.instances['resumoInterferencias'].setData("");
						CKEDITOR.instances['providencia'].setData("");
						$.notify('Cadastrado com sucesso!', "success");
						recuperaInterferencias();
						// confereNaoAtividade();
						document.getElementById("datepicker").disabled = false;
						document.getElementById("kmInicial").disabled = false;
						document.getElementById("kmFinal").disabled = false;
						$('#searchdate').hide();
						$('#btnInclusao').show();
						$('#btnNoAtividade').show();
						$('#EditarcadastroInterferencia').hide();
						$("input").val("");
						$("select").val("");
					}, error: function (data) {
						$.notify('Erro no Envio', "warning");
					}
				});
			}
		});
	});


	//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	$("#editarInterferencia").click(function () {
		//------------------ Verificação de campos -----------------------------
		serializedData = validaformulario("formularioInterferenciaEditar");
		if (serializedData == false) {
			$.notify('Preencha os campos obrigatorios', "warning");
			return false
		}

		var strData = $('#previsaoSolucaoEditar').val();
		var partesData = strData.split("/");
		var data = new Date(partesData[2], partesData[1] - 1, partesData[0]);
		if (data < new Date()) {
			$.notify("O campo [Previsao da Solução] não pode ser menor que a data atual!", 'warning');
			return false;
		}

		//---------------- Validação de formulario -----------------------------
		var id = $('#idEditar').val();
		//----------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [EDIÇÃO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/InterferenciaEditarDaq?id=' + id,
					data: serializedData,
					dataType: 'json',
					success: function (data) {
						$.notify('Cadastrado com sucesso!', "success");
						document.formularioInterferenciaEditar.reset();
						// CKEDITOR.instances['resumoInterferenciasEditar'].setData("");
						// CKEDITOR.instances['providenciaEditar'].setData("");
						recuperaInterferencias();
						// confereNaoAtividade();
						document.getElementById("datepicker").disabled = false;
						$('#searchdate').hide();
						$('#btnInclusao').show();
						$('#EditarcadastroInterferencia').hide();
						$("input").val("");
						$("select").val("");
					}, error: function (data) {
						$.notify('Erro no Envio', "warning");

					}
				});
			}
		});
	});
	//-------------------------------------------------------------------------------------------

	$("#fechareditarInterferencia").click(function () {
		document.getElementById("datepicker").disabled = false;
		$("#classificacaoEditar").val("");
		$("#grauImpactoEditar").val("");
		$('#previsaoSolucaoEditar').val("");
		$('#dataLimiteEditar').val("");
		$("#impactoCustoEditar").val("");
		$("#impactoPrazoEditar").val("");
		CKEDITOR.instances['providenciaEditar'].setData("");
		CKEDITOR.instances['resumoInterferenciasEditar'].setData("");
		$('#EditarcadastroInterferencia').hide();
		$("input").val("");
		$("select").val("");
	});

	//--------------------------------------------------------------------------

})

//------------------------------------------------------------------------------
function recupera_TipoInterferencia() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=tipoInterferencia]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_tipo_interferencia.length; i++) {
				servico.append('<option value="' + data.id_tipo_interferencia[i] + '">' + data.desc_tipo[i] + '</option>');
			}
		}
	})
}

//------------------------------------------------------------------------------
function recupera_TipoInterferenciaEditar() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=tipoInterferenciaEditar]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_tipo_interferencia.length; i++) {
				servico.append('<option value="' + data.id_tipo_interferencia[i] + '">' + data.desc_tipo[i] + '</option>');
			}
		}
	})
}

//------------------------------------------------------------------------------
function recupera_Classificacao() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoClassDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=classificacao]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_classificacao.length; i++) {
				servico.append('<option value="' + data.id_classificacao[i] + '">' + data.desc_classificacao[i] + '</option>');
			}
		}
	})
}

//------------------------------------------------------------------------------
function recupera_ClassificacaoEditar() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoClassDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=classificacaoEditar]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_classificacao.length; i++) {
				servico.append('<option value="' + data.id_classificacao[i] + '">' + data.desc_classificacao[i] + '</option>');
			}
		}
	})
}

//------------------------------------------------------------------------------
function recupera_GrauImpacto() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoGrauDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=grauImpacto]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_grau_impacto.length; i++) {
				servico.append('<option value="' + data.id_grau_impacto[i] + '">' + data.desc_grau_impacto[i] + '</option>');
			}
		}
	})
}

//------------------------------------------------------------------------------
function recupera_GrauImpactoEditar() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoGrauDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=grauImpactoEditar]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_grau_impacto.length; i++) {
				servico.append('<option value="' + data.id_grau_impacto[i] + '">' + data.desc_grau_impacto[i] + '</option>');
			}
		}
	})
}

//------------------------------------------------------------------------------
function populaTipoEixo() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoEixoDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=tipoEixo]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_tipo_eixo.length; i++) {
				servico.append('<option value="' + data.id_tipo_eixo[i] + '">' + data.desc_tipo_eixo[i] + '</option>');
			}
		}
	})
}

//------------------------------------------------------------------------------
function populaTipoEixoEditar() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaTipoEixoDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=tipoEixoEditar]');
			servico.html('');
			servico.append('<option value="" selected>Selecione</option>');
			for (i = 0; i < data.id_tipo_eixo.length; i++) {
				servico.append('<option value="' + data.id_tipo_eixo[i] + '">' + data.desc_tipo_eixo[i] + '</option>');
			}
		}
	})
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
		url: base_url + 'index_cgob.php/InterferenciaRecuperaAtvDaq?periodo=' + termo,
		data: {periodo: termo},
		dataType: 'json',
		success: function (data) {
			if (data.risco == true) {

				$("#btnNoAtividade").attr("disabled", true);
				$("#btnInclusao").attr("disabled", true);
				$('#searchdate').hide();
				$('#nova_interferencia').hide();
				$('#cadastroInterferencia').hide();
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
					"sAjaxSource": base_url + "index_cgob.php/InterferenciaRecuperaAtvDaq?periodo=" + termo,
					"aoColumns": [
						{data: 'atividademes'},
						{data: 'usuario'},
						{data: 'ultima_alteracao'},
						{data: 'acoes'}

					]
				});
			} else {
				$("#naohouveatividademes").hide();
				$("#btnNoAtividade").attr("disabled", false);
				$("#btnInclusao").attr("disabled", false);
				$('#nova_interferencia').show();
				$('#cadastroInterferencia').hide();
				$('#naohouveatividademes').hide();
			}
		}
	});
}

//------------------------------------------------------------------------------
function recuperaInterferencias() {
	table_naohouveatividademes();
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$('#nova_interferencia').show();
	$('#cadastroInterferencia').hide();
	$('#tableInterferencia').dataTable({
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
		"sAjaxSource": base_url + "index_cgob.php/InterferenciaRecuperaDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: 'CONTE', "sClass": "text-center"},
			{data: 'TIPO', "sClass": "text-center"},
			{data: 'GRAU_IMPACTO', "sClass": "text-center"},
			{data: 'CLASSIFICACAO'},
			{data: 'EIXO', "sClass": "text-center"},
			{data: 'BR', "sClass": "text-center"},
			{data: 'KMINICIAL', "sClass": "text-center"},
			{data: 'KMFIM', "sClass": "text-center"},
			{data: 'PREVISAO_SOLUCAO', "sClass": "text-center"},
			{data: 'DATA_LIMITE', "sClass": "text-center"},
			{data: 'RESUMO', "sClass": "text-center"},
			{data: 'USUARIO'},
			{data: 'ATUALIZACAO'},
			{data: 'ACAO', "sClass": "text-center"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirInterferencia(id_riscos_interferencias) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR RISCO E INTERFERÊNCIA]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/InterferenciaExcluirDaq',
					data: {id_riscos_interferencias: id_riscos_interferencias},
					dataType: 'json',
					success: function (data) {
						$.notify('Excluído com sucesso!', "success");
						var table = $("#tableInterferencia").DataTable();
						table.ajax.reload();
						$('#EditarcadastroInterferencia').hide();
						$("input").val("");
						$("select").val("");
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
//------------------------------------------------------------------------------   
function descricaoInterferencia(id_riscos_interferencias) {
	$("#descricaoInterferencia").modal("show");
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/InterferenciaDescricaoDaq',
		dataType: 'json',
		data: {id_riscos_interferencias: id_riscos_interferencias},
		success: function (data) {
			$("#descricaoInterferencia_modal").html(data.descricao);
			$("#providenciaInterferencia_modal").html(data.providencia);
		}
	});
}

//-----------------------------------------------------------------------------------------------------------------------
function recuperaInterferenciaEditar(id_riscos_interferencias, linha) {
	var linha = linha - 1;
	var table = $('#tableInterferencia').DataTable();
	table.rows().deselect();
	table.row(':eq(' + linha + ')', {page: 'current'}).select();

	bootbox.confirm("Confirmar operação [EDITAR]?", function (result) {
		if (result === true) {

			$.ajax({
				type: "POST",
				url: base_url + "index_cgob.php/InterferenciaRecuperaEditarDaq",
				data: {id_riscos_interferencias: id_riscos_interferencias},
				dataType: "json",
				success: function (data) {


					//------------------------------------------------------------------------------
					$('#nova_interferencia').show();
					$('#cadastroInterferencia').hide();
					$('#EditarcadastroInterferencia').show();
					$('#searchdate').hide();
					$('#btnInclusao').show();

					recupera_TipoInterferenciaEditar();
					recupera_GrauImpactoEditar();
					recupera_ClassificacaoEditar();
					populaTipoEixoEditar();
					//------------------------------------------------------------------------------

					$("#idEditar").val(id_riscos_interferencias);
					//------------------------------------------------------------------------------

					//-------------------------------------------------------------------------
					$("#descricaoEditar").val(data.descricao);
					$("#kmInicialEditar").val(data.kmInicial);
					$("#kmFinalEditar").val(data.kmFinal);
					$("#tipoInterferenciaEditar").val(data.desc_tipo_risco_interferenciar);
					$("#classificacaoEditar").val(data.desc_classificacao);
					$("#grauImpactoEditar").val(data.desc_grau_impacto);
					$("#brEditar").val(data.brEditar);
					$("#tipoEixoEditar").val(data.desc_eixo);
					$("#impactoCustoEditar").val(data.impacto_custo);
					$("#impactoPrazoEditar").val(data.impacto_prazo);
					$("#previsaoSolucaoEditar").val(data.previsao_solucao);
					$("#dataLimiteEditar").val(data.data_limite);

					CKEDITOR.instances['resumoInterferenciasEditar'].setData(data.resumo);
					CKEDITOR.instances['providenciaEditar'].setData(data.providencia);
					//-------------------------------------------------------------------------

				}, error: function (data) {
					$.notify("Falha ao recuperar", "warning");
				}
			});


		}


	});
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnNoAtividade() {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
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
					url: base_url + 'index_cgob.php/InterferenciaInsereAtvDaq',
					data: {
						periodo: termo
					},
					dataType: 'json',
					success: function (data) {
						$.notify('Cadastrado com sucesso!', "success");
						table_naohouveatividademes();
						$("input").val("");
						$("select").val("");
					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");
					}
				});
			}
		});
	}
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function NaoHouveAtividadedaq(id) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/InterferenciaAtvDaq?id=' + id,
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
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
