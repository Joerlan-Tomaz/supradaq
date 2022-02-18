//######################################################################################################################################################################################################################## 
//# DNIT - FALCONI - AQUAVIARIO
//# relaorioansupervisao.js
//# Desenvolvedora:Jordana Alencar
//# Data: 27/08/2020
//########################################################################################################################################################################################################################
//---------------------------------------------------------------------------------------------------------------------------------------------
$().ready(function () {
	//------------------------------------------------------------------------------------------------------------------------------------
	$.ajaxSetup({cache: false});
	//------------------------------------------------------------------------------------------------------------------------------------
	$('[data-toggle="tooltip"]').tooltip();
	//--------------------------------------------
	$('#datepicker').datepicker({
		format: "MM yyyy",
		startView: 1,
		minViewMode: 1,
		language: "pt-BR",
		autoclose: true
	});
	var myDate = new Date()
	myDate.setMonth(myDate.getMonth() - 1);
	$("#datepicker").datepicker("setDate", myDate);
	//----------------------------------------------------------------------------------------------------------------------------------------
	$("#btnHistorico").hide();
	$("#btnConcluir").hide();
	$("#exibeDadosContrato").hide();
	$('#modulos_analise').hide();
	$("#btnVoltar2").hide();
	document.getElementById("datepicker").disabled = false;
	document.getElementById("pesquisaruf").disabled = false;
	recuperaAnaliseContrato();
	//-------------------------------------------------------
	$('#datepicker').on("changeDate", function () {
		recuperaAnaliseContrato();
	});
	//-------------------------------------------------------
	$("#pesquisaruf").change(function () {
		recuperaAnaliseContrato();
	});
});

//----------------------------------------------------------------------------------------------------------------------------------------
function recuperaAnaliseContrato() {
	$('#analiseContrato').show();

	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var uf = document.getElementById("pesquisaruf").options[document.getElementById("pesquisaruf").selectedIndex].value;
	var table = $('#tableAnaliseContrato').DataTable();
	table.destroy();
	$('#tableAnaliseContrato').dataTable({
		"bProcessing": false,
		"pageLength": 10,
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
		"sAjaxSource": base_url + "index_cgop.php/AnaliseContratoDaq?uf=" + uf,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: 'historico', "sClass": "text-left"},
			{data: 'contrato', "sClass": "text-left"},
			{data: 'supervisora', "sClass": "text-left"},
			{data: 'bruf', "sClass": "text-left"},
			{data: 'fechamento', "sClass": "text-left"},
			{data: 'status', "sClass": "text-left"},
			{data: 'acoes', "sClass": "text-left"},
		]
	});
	$("#btnHistorico").hide();
	$("#btnConcluir").hide();
	$("#exibeDadosContrato").hide();
	$('#modulos_analise').hide();
	$("#btnVoltar").show();
	$("#btnVoltar2").hide();
}

//----------------------------------------------------------------------------------------------------------------------------

function iniciarAnalise(id_contrato) {

	//---------------------------------------------------------------------
	var Validar = ordemperfil(id_contrato);
	if (Validar != true) {
		$.notify(Validar.mensagem, "warning");
		return false;
	}
	//----------------------------------------------------------------------------------------------//
	bootbox.confirm("Adicionar relátorio para análise?", function (result) {
		if (result == true) {

			var dt = $("#datepicker").datepicker('getDate');
			if (dt.toString() == "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
			var uf = document.getElementById("pesquisaruf").options[document.getElementById("pesquisaruf").selectedIndex].value;

			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AnaliseConfirmarDaq?periodo=' + termo + '&id_contrato=' + id_contrato,
				dataType: 'json',
				success: function (data) {
					$.notify('Sucesso!! [Relatorio em Análise]', "success");
					$("#btnHistorico").show();
					$("#btnConcluir").show();
					$("#exibeDadosContrato").show();
					$('#modulos_analise').show();
					$("#analiseContrato").hide();
					$("#btnVoltar").hide();
					$("#btnVoltar2").show();
					// document.getElementById("datepicker").disabled = true;
					// document.getElementById("pesquisaruf").disabled = true;
					$('#id_contrato_historico').val(id_contrato);
					$('#id_contrato_concluir').val(id_contrato);
					dadosContrato(id_contrato);

				}, error: function (data) {
					$.notify('Não foi possível realizar a operação.', "warning");
				}
			});
		}
	});
}

function continuarAnalise(id_contrato) {
	//----------------------------------------------------------------------------------------------//
	bootbox.confirm("Continuar análise?", function (result) {
		if (result == true) {
			if (document.getElementById) {
				var dt = $("#datepicker").datepicker('getDate');
				if (dt.toString() == "Invalid Date") {
					$("#datepicker").datepicker("setDate", new Date());
					return;
				}
				var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
			}
			var uf = document.getElementById("pesquisaruf").options[document.getElementById("pesquisaruf").selectedIndex].value;
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AnaliseConfirmarDaq?periodo=' + termo + '&id_contrato=' + id_contrato,
				dataType: 'json',
				success: function (data) {
					$.notify('Sucesso![Relatorio retomado para Análise]', "success");
					$("#btnHistorico").show();
					$("#btnConcluir").show();
					$("#exibeDadosContrato").show();
					$('#modulos_analise').show();
					$("#analiseContrato").hide();
					$("#btnVoltar").hide();
					$("#btnVoltar2").show();
					document.getElementById("datepicker").disabled = true;
					document.getElementById("pesquisaruf").disabled = true;
					$('#id_contrato_historico').val(id_contrato);
					$('#id_contrato_concluir').val(id_contrato);
					dadosContrato(id_contrato);

				}, error: function (data) {
					$.notify('Não foi possível realizar a operação.', "warning");
				}
			});
		}
	});
}

//--------------------------------------------------------------------
function inserirAnalise(id_contrato) {
//----------------------------------------------------------------------------------------------//
//validarInserir(id_contrato);
//----------------------------------------------------------------------------------------------// 
	$("#btnHistorico").show();
	$("#btnConcluir").show();
	$("#exibeDadosContrato").show();
	$('#modulos_analise').show();
	$("#analiseContrato").hide();
	$("#btnVoltar").hide();
	$("#btnVoltar2").show();
	document.getElementById("datepicker").disabled = true;
	document.getElementById("pesquisaruf").disabled = true;
	$('#id_contrato_historico').val(id_contrato);
	$('#id_contrato_concluir').val(id_contrato);
	dadosContrato(id_contrato);
	//ModalhistoricoAnalise(id_contrato);
}

//--------------------------------------------------------------------
$("#btnVoltar2").click(function () {
	$("#btnHistorico").hide();
	$("#btnConcluir").hide();
	$("#exibeDadosContrato").hide();
	$('#modulos_analise').hide();
	$("#btnVoltar2").hide();
	$("#btnVoltar").show();
	recuperaAnaliseContrato();
	document.getElementById("datepicker").disabled = false;
	document.getElementById("pesquisaruf").disabled = false;

});

//----------------------------------------------------------------------------------------------//
function ordemperfil(id_contrato) {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/AnalisePerfilDaq',
		data: {
			id_contrato: id_contrato
		},
		dataType: 'json',
		async: false,
		success: function (data) {
			retorno = data;
		}, error: function (data) {

		}
	});
	return retorno;
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function dadosContrato(id_contrato) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker("getDate");
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/AnaliseVersaoDaq',
		data: {
			periodo: termo, id_contrato: id_contrato
		},
		dataType: 'json',
		success: function (data) {
			val_contrato = data.contrato;
			var label_contrato = val_contrato;
			$('.label_contrato').text(label_contrato);
			//---------------------------------------------
			val_supervisora = data.supervisora;
			var label_supervisora = val_supervisora;
			$('.label_supervisora').text(label_supervisora);
			//----------------------------------------------
			val_rp = data.rp;
			var label_rp = val_rp;
			$('.label_rp').text(label_rp);
			//----------------------------------------------
			val_versao = data.versao;
			var label_versao = val_versao;
			$('.label_versao').text(label_versao);
			//----------------------------------------------
			val_uf = data.uf;
			var label_uf = val_uf;
			$('.label_uf').text(label_uf);
			//----------------------------------------------
			dadosRelatorio(id_contrato)
		}, error: function (data) {
			$.notify('Não foi possível realizar a operação.', "warning");
		}
	});
}

//---------------------------------------------------------------------
function dadosRelatorio(id_contrato) {

	if (document.getElementById) {
		var dt = $("#datepicker").datepicker("getDate");
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}

	var table = $('#table_modulos_analise').DataTable();
	table.destroy();
	//---------------------------------------------------------
	$('#table_modulos_analise').dataTable({
		"bProcessing": false,
		"bFilter": false,
		"bInfo": false,
		"bLengthChange": false,
		"paging": false,
		"sAjaxSource": base_url + "index_cgop.php/AnaliseModulosDaq?id_contrato=" + id_contrato,
		"fnServerParams": function (aoData) {
			aoData.push(
				{"name": "periodo", "value": termo}
			);
		},
		"aoColumns": [
			{data: 'cont', "sClass": "text-left"},
			{data: 'modulo', "sClass": "text-left"},
			{data: 'nome', "sClass": "text-left"},
			{data: 'data', "sClass": "text-left"},
			{data: 'acao', "sClass": "text-left"}
		]
	});
}

//--------------------------------------------------------------------------
function EditarAnalise(id_modulo, modulo, id_contrato) {

	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/AnaliseEditarDaq',
		data: {id_modulo: id_modulo, id_contrato: id_contrato},
		dataType: 'json',
		success: function (data) {

			$("#modalAceiteEditar").modal("show");
			$('#id_modulo').val(id_modulo);
			$('#descModuloEditar').val(modulo);
			$('#id_contrato').val(id_contrato);
			$('#descEditarMotivoAnalise').val("");
			$("#descModulo").text("Módulo: " + modulo);

			var resumo = data.resumo;
			$("#id_relatorio").val(data.id_relatorio);
			$("#descEditarMotivoAnalise").val(resumo);
		}, error: function (data) {
			$.notify('Não foi possível realizar a operação.', "warning");
		}
	});

}

//--------------------------------------------------------------------------
$("#insereAceite").click(function () {
	insereAceite();
});

//-------------------------------------------------------------------------------------------------------
function insereAceite() {
	var termo = new Object();
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		termo.name = "periodo";
		termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}

	var aceite = $('input[name="aceite"]:checked').val();

	var serializedData = $("#formularioEditar").serializeArray();
	serializedData.push(termo);

	bootbox.confirm("Confirma cadastrado [ Retificar ]?", function (result) {
		if (result == true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AnaliseInsereEditarDaq',
				data: serializedData,
				dataType: 'json',
				success: function (data) {
					$("#modalAceiteEditar").modal("hide");
					$.notify('Cadastrado com sucesso!', "success");
					var table_modulos_analise = $("#table_modulos_analise").DataTable();
					table_modulos_analise.ajax.reload();

				}, error: function (data) {
					$.notify('Não foi possível realizar a operação.', "warning");

				}
			});
		}
	});
}

//------------------------------------------------------------------------------
function ModalconcluirAnalise() {
	var id_contrato = $('#id_contrato_concluir').val();

	$("#modalFinalizarRelatorio").modal("show");

	var Validar = confereAprovar(id_contrato);

	if (Validar == 1) {
		document.getElementById("aprovado").disabled = false;
		document.getElementById("reprovado").disabled = false;

	} else {
		document.getElementById("aprovado").disabled = true;
		document.getElementById("reprovado").disabled = false;
	}

}

//------------------------------------------------------------------------------
function confereAprovar(id_contrato) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker("getDate");
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/ConfereAnaliseDaq',
		data: {
			periodo: termo, id_contrato: id_contrato
		},
		dataType: 'json',
		async: false,
		success: function (data) {
			retorno = data;
		}, error: function (data) {

		}
	});
	return retorno;
}

//--------------------------------------------------------------------------
$("#insereFinalizar").click(function () {
	insereFinalizar();
});

//--------------------------------------------------------------------------
$("#btnHistorico").click(function () {
	ModalhistoricoAnalise();
});

//------------------------------------------------------------------------------
function ModalhistoricoAnalise() {

	if (document.getElementById) {
		var dt = $("#datepicker").datepicker("getDate");
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var id = $("#id_contrato_historico").val();
	$("#modalHisticoAnalise").modal("show");

	var table = $('#tableHistoricoAnalises').DataTable();
	table.destroy();
	$('#tableHistoricoAnalises').dataTable({
		"bProcessing": false,
		"pageLength": 10,
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
		"sAjaxSource": base_url + "index_cgop.php/AnaliseHistoricoDaq?id_contrato=" + id,
		"fnServerParams": function (aoData) {
			aoData.push(
				{"name": "periodo", "value": termo}
			);
		},
		"aoColumns": [
			{data: 'cont', "sClass": "text-center"},
			{data: 'referencia', "sClass": "text-center"},
			{data: 'aceite', "sClass": "text-center"},
			{data: 'analise', "sClass": "text-center"},
			{data: 'modulo', "sClass": "text-center"},
			{data: 'nome', "sClass": "text-center"},
			{data: 'perfil', "sClass": "text-center"},
			{data: 'data', "sClass": "text-center"},

		]
	});
}

//------------------------------------------------------------------------------
function insereFinalizar() {

	var serializedData = new FormData();
	serializedData = $("#formulariofinalizar").serializeArray();

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
	bootbox.confirm("Confirmar operação [CONCLUIR ANÁLISE]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AnaliseConclusaoDaq',
				data: serializedData,
				dataType: 'json',
				success: function (data) {
					$('#modalFinalizarRelatorio').modal('hide');
					$.notify('Cadastrado com sucesso!', "success");

				}, error: function (data) {
					$.notify('Não foi possível realizar a operação.', "warning");

				}
			});
		}
	});
}

//------------------------------------------------------------------------------------------------------------
function retornaRelatorio(id_contrato) {
	var id = id_contrato;

	var dt = $("#datepicker").datepicker('getDate');
	if (dt.toString() == "Invalid Date") {
		$("#datepicker").datepicker("setDate", new Date());
		return;
	}
	var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

	jan = window.open(base_url + 'index_cgop.php/ImpressaoRelatorioDaq?periodo=' + termo + '&id=' + id, 'jan', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=100, LEFT=left, WIDTH=800, HEIGHT=500');

}

//------------------------------------------------------------------------------------------------------------
function retornaPainel() {
	// document.getElementById("datepicker").disabled = false;
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load("").slideUp(3).delay(3).fadeIn("slow");
};

//------------------------------------------------------------------------------------------------------------
function ExcluirRetificado(id) {
	if (id == '') {
		$.notify('Não é possível excluir!', "warning");
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR NÃO ACEITE]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/AnaliseExcluirDaq',
					data: {
						id: id
					},
					dataType: 'json',
					success: function (data) {
						$("#modalAceiteEditar").modal("hide");
						$.notify('[EXCLUIR NÃO ACEITE] efetuado com  sucesso!', "success");

						var table_modulos_analise = $("#table_modulos_analise").DataTable();
						table_modulos_analise.ajax.reload();

					}, error: function (data) {
						//$('#spinner').hide();
						$.notify('Não foi possível realizar a operação.[EXCLUIR NÃO ACEITE]', "warning");

					}
				});
			}
		});
	}
}
