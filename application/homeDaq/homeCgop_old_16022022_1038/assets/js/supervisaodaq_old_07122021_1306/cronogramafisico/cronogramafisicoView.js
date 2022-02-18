//######################################################################################################################################################################################################################## 
//# DNIT- AQUAVIARIO - FALCONI
//# cronogramafisicoView.js
//# Desenvolvedora:Jordana Alencar
//# Data: 01/04/2020 
//# Data: 03/08/2020 
//########################################################################################################################################################################################################################
//------------------------------------------------------------------------------
var qtdeCampos = 0;
//------------------------------------------------------------------------------
$().ready(function () {
	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$("#searchdate").hide();
	$("#btnPublicar").hide();
	$("#exibeEixoLado").hide();
	$("#itens_inseridos").hide();
	// $('#exibeCronogramaFinanceiroObra').show();
	$('#visualizar_cronogramafisico_eixo').hide();
	$('#visualizar_cronogramaagrupado').show();
	$('#exibePk').show();
	$('#cadastraCronogramaFisico').hide();
	$('#cadastraCronogramaFisicoNovo').hide();
	//-------------------------------------------------------------------------
	RecuperaCronogramaAgrupado();
	TotalServicoAquaviario();
	ContaNaoPublicado();
	//--------------------------------------------------------------------------
	$('#valanoreferente').datepicker({
		format: "yyyy",
		startView: 1,
		minViewMode: 2,
		language: "pt-BR",
		autoclose: true
	});
	$("#valanoreferente").datepicker("setDate", new Date());
	//--------------------------------------------------------------------------
	$('#valanoreferenteNovo').datepicker({
		format: "yyyy",
		startView: 1,
		minViewMode: 2,
		language: "pt-BR",
		autoclose: true
	});
	$("#valanoreferenteNovo").datepicker("setDate", new Date());
	//--------------------------------------------------------------------------
	//--------------------------------------------------------------------------
	$("#searchdate").click(function () {
		$('#eixo').val('');
		$('#lado').val('');
		$('#id_cronograma').val('');
		$('#versao').val('');
		$("#itens_inseridos").hide();
		// $("#exibeCronogramaFinanceiroObra").show();
		$("#searchdate").hide();
		$("#btnPublicar").hide();
		// $('#visualizar_cronogramafisico_eixo').show();
		$('#cadastraCronogramaFisico').hide();
		$("#btnVoltar").show();
		$("#exibeEixoLado").hide();
		$("#btnInclusao").show();
		$("#visualizar_cronogramaagrupado").show();
		$("#exibePk").show();
		$('#visualizar_cronogramafisico_eixo').hide();
		TotalServicoAquaviario();
		RecuperaCronogramaAgrupado();
		ContaNaoPublicado();

		$('.label_Total').text("");
		$('.label_Inicial').text("");
		$('.label_Final').text("");


	});
	//--------------------------------------------------------------------------
	$("#btninsereCronogramaFisico").click(function () {

		if ($("#valanoreferente").val() == "") {
			$.notify("Informe o campo [Ano]", "warning");
			document.getElementById("valanoreferente").style.borderColor = "red";
			return false
		} else {
			document.getElementById("valanoreferente").style.borderColor = "gray";
		}

		if ($("#operacao").val() == "Selecione") {
			$.notify("Informe o campo [Operação]", "warning");
			document.getElementById("operacao").style.borderColor = "red";
			return false
		} else {
			document.getElementById("operacao").style.borderColor = "gray";
		}

		if ($("#servico").val() == "Selecione") {
			$.notify("Informe o campo [Serviço]", "warning");
			document.getElementById("servico").style.borderColor = "red";
			return false
		} else {
			document.getElementById("servico").style.borderColor = "gray";
		}

		var id_cronograma = $('#id_cronograma').val();
		var versao = $('#versao').val();
		var nome_eixo = $('#nome_eixo').val();

		if (id_cronograma == 0 | versao == 0) {
			insereCronogramaFisicoNovo(nome_eixo);
		} else {
			insereCronogramaFisico(id_cronograma, versao, nome_eixo);
		}
	});
	//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	$("#insereCronogramaFisicoNovo").click(function () {
		insereCronogramaFisicoNovo();

	});
	//--------------------------------------------------------------------------
	$("#adicionaCamposValor").click(function () {
		var obra = $('#obra').val();
		var servico = $('#servico').val();
		adicionaCamposValor(obra, servico);
		ListaItensInseridos();
	});
	//--------------------------------------------------------------------------
	$("#adicionaCamposValorNovo").click(function () {
		adicionaCamposValorNovo();
	});
	//--------------------------------------------------------------------------
	$("#btnVoltar").click(function () {
		$('#visualizar_cronogramafisico').hide();
		rotaCronogramaDaq();
	});
	//--------------------------------------------------------------------------
	$("#btn_salvaredicao").click(function () {
		btn_salvaredicao();
	});
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		btnInclusao();
	});
	//--------------------------------------------------------------------------
	$('#eixoNovo').change(function () {
		var eixo = $('#eixoNovo').val();
		RecuperaLadoNovo(eixo);
	});
});

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function removerCampo(id) {
	var objPai = document.getElementById("campoPai");
	var objFilho = document.getElementById("filho" + id);
	//Removendo o DIV com id específico do nó-pai:
	var removido = objPai.removeChild(objFilho);
	qtdeCampos--;
	if (qtdeCampos == 12) {
		$("input[name='btnAdiciona']").attr('disabled', true);
	} else {
		$("input[name='btnAdiciona']").attr('disabled', false);
	}
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function removerCampoNovo(id) {
	var objPai = document.getElementById("campoPaiNovo");
	var objFilho = document.getElementById("filho" + id);
	//Removendo o DIV com id específico do nó-pai:
	var removido = objPai.removeChild(objFilho);
	qtdeCampos--;
	if (qtdeCampos == 12) {
		$("input[name='btnAdiciona']").attr('disabled', true);
	} else {
		$("input[name='btnAdiciona']").attr('disabled', false);
	}
}

//------------------------------------------------------------------------------
$("#operacao").change(function () {
	$("#btninsereCronogramaFisico").hide();
	RecuperaSevico();
	$("#tipo").html("");
	document.getElementById("tipo").disabled = true;
	$("#campoPai").html("");

});

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaObra() {
	$("#obra").val('Selecione');
	$("#servico").val('Selecione');

	document.getElementById("servico").disabled = true;
	document.getElementById("tipo").disabled = true;
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroOperacaoDaq',
		dataType: 'json',
		success: function (data) {
			var operacao = $('select[id=operacao]');
			operacao.html('');
			operacao.append('<option value="Selecione" selected >Selecione</option>');
			for (i = 0; i < data.id_operacao.length; i++) {
				operacao.append('<option value="' + data.id_operacao[i] + '">' + data.operacao[i] + '</option>');
			}
		}
	});
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaSevico(id_obra) {
	var id_operacao = $("#operacao").val();
	if (id_operacao !== "") {
		document.getElementById("servico").disabled = false;

		$.ajax({
			type: 'POST',
			url: base_url + 'index_cgop.php/CronogramaFinanceiroServicoOperacaoDaq',
			data: {id_operacao: id_operacao},
			dataType: 'json',
			success: function (data) {
				var servico = $('select[id=servico]');
				servico.html('');
				servico.append('<option value="Selecione" selected >Selecione</option>');
				for (i = 0; i < data.id_servico.length; i++) {
					servico.append('<option value="' + data.id_servico[i] + '">' + data.servico[i] + '</option>');
				}
				$("#servico").val('Selecione');
			}

		});
	} else {
		document.getElementById("servico").disabled = true;
		document.getElementById("tipo").disabled = true;
	}
}

$("#tipo").change(function () {
	ListaItensInseridos();
});

$("#servico").change(function () {
	$("#campoPai").html("");
	$("#btninsereCronogramaFisico").hide();
	tipo();

});

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function tipo() {
	var id_servico = $("#servico").val();
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroTipoOperacaoDaq',
		data: {id_servico: id_servico},
		dataType: 'json',
		success: function (data) {
			if(typeof(data.id_tipo) != "undefined" && data.id_tipo !== null) {
				var tipo = $('select[id=tipo]');
				tipo.html('');
				tipo.append('<option value="Selecione" selected >Selecione</option>');
				for (i = 0; i < data.id_tipo.length; i++) {
					tipo.append('<option value="' + data.id_tipo[i] + '">' + data.tipo[i] + '</option>');
				}
				document.getElementById("tipo").disabled = false;
				ListaItensInseridos();
			} else {
				$("#tipo").html('');
				document.getElementById("tipo").disabled = true;
			}
		}
	});
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function insereCronogramaFisico(id_cronograma, versao, nome_eixo) {
	if ($("#valanoreferente").val() == "") {
		$.notify("Informe o campo [Ano]", "warning");
		document.getElementById("valanoreferente").style.borderColor = "red";
		return false
	} else {
		document.getElementById("valanoreferente").style.borderColor = "gray";
	}

	if ($("#operacao").val() == "Selecione") {
		$.notify("Informe o campo [Operação]", "warning");
			document.getElementById("operacao").style.borderColor = "red";
		return false
	} else {
		document.getElementById("operacao").style.borderColor = "gray";
	}

	if ($("#servico").val() == "Selecione") {
		$.notify("Informe o campo [Serviço]", "warning");
		document.getElementById("servico").style.borderColor = "red";
		return false
	} else {
		document.getElementById("servico").style.borderColor = "gray";
	}
	var medicao = $("#medicao").val();
	var valor = 0;
	var somafinal = 0;
	for (var numero = 1; numero <= 12; numero++) {
		num = $("#valor_medido" + numero).val();
		if (num == '') {
			valor++;
		}
	}
	if (valor == 12) {
		for (var numero = 1; numero <= 12; numero++) {
			document.getElementById("valor_medido" + numero).style.borderColor = 'red';
		}
		$.notify("Os Campos [" + medicao + " Total] estão vazios!", "warning");
		return false;
	}
	//----------------------------------------------------------------------------------------------------------------//
	for (i = 1; i <= 12; i++) {
		if ($("#valor_medido" + i).length) {
			var final = $("#valor_medido" + i).val();
			nan = $("#valor_medido" + i).val().replace('.', '');
			var res = nan.replace(',', '.');
			var inni = $("#valor_medido" + i).val().replace('.', '');
			inni = parseFloat(inni);
			if (Number.isNaN(inni)) {
			} else {
				somafinal = somafinal + parseFloat(inni);
			}
			if (somafinal > 100.00) {
				document.getElementById("valor_medido" + i).style.borderColor = 'red';
				$.notify("Ocorreu um erro [O total do mês não deve ser superior a 100%!]", "warning");
				return false;
			} else {
				document.getElementById("valor_medido" + i).style.borderColor = '#d2d6de';
			}
		}
	}
	var serializedData = $("#formularioCronogramaFisico").serializeArray();
	bootbox.confirm("Confirmar operação [INSERIR CRONOGRAMA FÍSICO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFisicoInsereDaq?nome_eixo=' + nome_eixo + '&id_cronograma=' + id_cronograma + '&versao=' + versao,
				data: serializedData,
				dataType: 'json',
				success: function (data) {
					$.notify('Cadastrado com sucesso!', "success");
					$("#campoPai").html("");
					$("#btninsereCronogramaFisico").hide();

					TotalServicoAquaviario(id_cronograma, versao, nome_eixo);
					ServicosInseridosAquaviario(id_cronograma, versao, nome_eixo);
					$("#operacao").val("Selecione");
					$("#servico").val("");
					$("#tipo").val("");
					document.getElementById("servico").disabled = true;
					document.getElementById("tipo").disabled = true;

				}, error: function (data) {
					$.notify('Falha no cadastro', "warning");
				}
			});
		}
	});
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function Validar_Porcentagem(nome_eixo, id_operacao, id_servico, versao, final) {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFisicoVPorcentDaq',
		data: {
			id_operacao: id_operacao,nome_eixo: nome_eixo, id_servico: id_servico, versao: versao, final: final, tipo: $('#tipo').val()
		},
		dataType: 'json',
		async: false,
		success: function (data) {
			retorno = data;
		}, error: function (data) {
			retorno = 'Erro no processamento!';
		}
	});
	return retorno;
}

//--------------------------------------------------------Inserir nova versao------------------------------------------------
function insereCronogramaFisicoNovo(nome_eixo) {

	if ($("#valanoreferente").val() == "") {
		$.notify("Informe o campo [Ano]", "warning");
		document.getElementById("valanoreferente").style.borderColor = "red";
		return false
	} else {
		document.getElementById("valanoreferente").style.borderColor = "gray";
	}

	if ($("#operacao").val() == "Selecione") {
		$.notify("Informe o campo [Operação]", "warning");
		document.getElementById("operacao").style.borderColor = "red";
		return false
	} else {
		document.getElementById("operacao").style.borderColor = "gray";
	}

	if ($("#servico").val() == "Selecione") {
		$.notify("Informe o campo [Serviço]", "warning");
		document.getElementById("servico").style.borderColor = "red";
		return false
	} else {
		document.getElementById("servico").style.borderColor = "gray";
	}
	var medicao = $("#medicao").val();
	var id_operacao = $("#operacao").val();
	var valor = 0;
	var somafinal = 0;
	for (var numero = 1; numero <= 12; numero++) {
		num = $("#valor_medido" + numero).val();
		if (num == '') {
			valor++;
		}
	}
	if (valor == 12) {
		for (var numero = 1; numero <= 12; numero++) {
			document.getElementById("valor_medido" + numero).style.borderColor = 'red';
		}
		$.notify("Os Campos [" + medicao + " Total] estão vazios!", "warning");
		return false;
	}
	if (medicao == '%') {
		for (i = 1; i <= 12; i++) {
			if ($("#valor_medido" + i).length) {
				nan = $("#valor_medido" + i).val().replace('.', '');
				var res = nan.replace(',', '.');
				somafinal = somafinal + parseFloat(res);
			}
			if (somafinal > 100.00) {
				document.getElementById("valor_medido" + i).style.borderColor = 'red';
				$.notify("Ocorreu um erro [O total do mês não deve ser superior a 100%!]", "warning");
				return false;
			} else {
				document.getElementById("valor_medido" + i).style.borderColor = '#d2d6de';
			}
		}
		//----------------------------------------------------------------------------------------------//
	}
	//--------------------------------------------------------------------------------------
	var serializedData = $("#formularioCronogramaFisico").serializeArray();
	bootbox.confirm("Confirmar operação [INSERIR CRONOGRAMA FÍSICO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFisicoInsereNovoDaq?nome_eixo=' + nome_eixo,
				data: serializedData,
				dataType: 'json',
				success: function (data) {
					$.notify('Cadastrado com sucesso!', "success");
					$("#campoPai").html("");
					$("#campoPaiNovo").html("");
					$("#btninsereCronogramaFisico").hide();
					$("#insereCronogramaFisicoNovo").hide();

					TotalServicoAquaviario(data.id_cronograma, data.versao, nome_eixo);
					ServicosInseridosAquaviario(data.id_cronograma, data.versao, nome_eixo)
					$("#operacao").val("Selecione");
					$("#servico").html("");
					$("#tipo").html("");
					document.getElementById("servico").disabled = true;
					document.getElementById("tipo").disabled = true;

					$('#id_cronograma').val(data.id_cronograma);
					$('#versao').val(data.versao);
				}, error: function (data) {
					$.notify('Falha no cadastro', "warning");

				}
			});
		}
	});

}

//------------------------------------------------------------------------------
function adicionaCamposValor(obra, servico) {

	if ($("#operacao").val() == "Selecione") {
		$.notify("Informe o campo [Operação]", "warning");
		document.getElementById("operacao").style.borderColor = "red";
		return false
	} else {
		document.getElementById("operacao").style.borderColor = "gray";
	}

	if ($("#servico").val() == "Selecione") {
		$.notify("Informe o campo [Serviço]", "warning");
		document.getElementById("servico").style.borderColor = "red";
		return false
	} else {
		document.getElementById("servico").style.borderColor = "gray";
	}
	if ($("#tipo").val() == "Selecione") {
		$.notify("Informe o campo [Tipo]", "warning");
		document.getElementById("tipo").style.borderColor = "red";
		return false
	} else {
		document.getElementById("tipo").style.borderColor = "gray";
	}
//----------------------------------------------------------------------------------------
	if (true) {
		var medicao;
		var inp_user;

		if (obra == 1) {
			medicao = '%';
			inp_user = medicao + " Total";
		}

		if ((obra == 2 && servico == 4) || (obra == 2 && servico == 8)) {
			medicao = 'KM';
			inp_user = medicao + " Total";
		}
		if ((obra == 2 && servico == 5) || (obra == 2 && servico == 6) || (obra == 2 && servico == 7)) {
			medicao = 'M³';
			inp_user = medicao + " Total";
		}

		if ((obra == 3 && servico == 3) || (obra == 3 && servico == 7)) {
			medicao = 'KM';
			inp_user = medicao + " Total";

		}
		if (obra == 3 && servico == 4) {
			medicao = 'M³';
			inp_user = medicao + " Total";
		}
		if (obra == 3 && servico == 5) {
			medicao = '%';
			inp_user = medicao + " Total";
		}
		if (obra == 3 && servico == 6) {
			medicao = 'SN';
			inp_user = "Sim ou Não";
		}

		if (obra == 4 && servico == 3) {
			medicao = 'KM';
			inp_user = medicao + " Total";
		}

		if (obra == 5) {
			medicao = '%';
			inp_user = medicao + " Total";
		}

		if ((obra == 6 && servico == 2) || (obra == 6 && servico == 3) || (obra == 6 && servico == 6) || (obra == 6 && servico == 8)) {
			medicao = 'KM';
			inp_user = medicao + " Total";
		}
		if ((obra == 6 && servico == 4) || (obra == 6 && servico == 5) || (obra == 6 && servico == 7) || (obra == 6 && servico == 9)) {
			medicao = 'UNID.';
			inp_user = medicao + " Total";
		}

		if (obra == 7) {
			medicao = '%';
			inp_user = medicao + " Total";
		}

		if (obra == 8) {
			medicao = 'UNID.';
			inp_user = medicao + " Total";
		}

		if (obra == 9) {
			medicao = '%';
			inp_user = medicao + " Total";
		}

		if (obra == 3 && servico == 6) {

			$("#btninsereCronogramaFisico").show();
			var meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
			for (var numero = 1; numero <= 12; numero++) {
				if (!$("#filho" + numero)[0]) {
					$("#campoPai").append(
						"<div class='row form-group' id='filho" + numero + "'>" +
						"   <div class='col-md-2'>" +
						"       <label for='valor'>Mês:</label><input type='hidden' id='mes" + numero + "' name='mes[" + numero + "]' value='" + numero + "' ><input class='form-control' type='text' id='mes" + numero + "' name='mes[]' value='" + meses[numero - 1] + "' disabled>" +
						"   </div>" +
						"   <div class='col-md-3'>" +
						"           <label for='valor_medido'>% :</label><select class='form-control' id='valor_medido" + numero + "' name='valor_medido[" + numero + "]' ><option value=''>Selecione</option><option value='1'>Sim</option><option value='2'>Não</option></select>" +
						"   </div>" +
						"   <div class='col-md-3'>" +
						"           <label>&nbsp;</label><input  class='btn btn-block btn-info' type='button' onclick='removerCampo(" + numero + ")' value='Remover'>" +
						"   </div>" +
						"</div>"
					);
					qtdeCampos++;
				}
				$('#medicao').val(medicao);
			}
			if (qtdeCampos == 12) {
				$("input[name='btnAdiciona']").attr('disabled', true);
				qtdeCampos = 0;
			} else {
				$("input[name='btnAdiciona']").attr('disabled', false);
			}
		} else {

			$("#btninsereCronogramaFisico").show();
			var meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
			for (var numero = 1; numero <= 12; numero++) {
				if (!$("#filho" + numero)[0]) {
					$("#campoPai").append(
						"<div class='row form-group' id='filho" + numero + "'>" +
						"   <div class='col-md-2'>" +
						"       <label for='valor'>Mês:</label><input type='hidden' id='mes" + numero + "' name='mes[" + numero + "]' value='" + numero + "' ><input class='form-control' type='text' id='mes" + numero + "' name='mes[]' value='" + meses[numero - 1] + "' disabled>" +
						"   </div>" +
						"   <div class='col-md-3'>" +
						"           <label for='valor_medido'>% :</label><input class='form-control' type='text' id='valor_medido" + numero + "' name='valor_medido[" + numero + "]'  onkeydown='FormataMoeda(this, 10, event)' onkeypress='return maskKeyPress(event)' value=''>" +
						"   </div>" +
						"   <div class='col-md-3'>" +
						"           <label>&nbsp;</label><input  class='btn btn-block btn-info' type='button' onclick='removerCampo(" + numero + ")' value='Remover'>" +
						"   </div>" +
						"</div>"
					);
					qtdeCampos++;
				}
				$('#medicao').val(medicao);
			}
			if (qtdeCampos == 12) {
				$("input[name='btnAdiciona']").attr('disabled', true);
				qtdeCampos = 0;
			} else {
				$("input[name='btnAdiciona']").attr('disabled', false);
			}
		}
	}
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function adicionaCamposValorNovo() {
	if ($('#servicoNovo').val() == 'Selecione' | $('#eixo').val() == 'Selecione') {
		$.notify('Os Campo [Eixo - Lado] ,[Ano] e [Serviço] são obrigatórios!', "warning");
	} else {
		$("#insereCronogramaFisicoNovo").show();
		var meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
		for (var numero = 1; numero <= 12; numero++) {
			if (!$("#filho" + numero)[0]) {
				$("#campoPaiNovo").append(
					"<div class='row form-group' id='filho" + numero + "'>" +
					"   <div class='col-md-3'>" +
					"       <input type='hidden' id='mes" + numero + "' name='mes[" + numero + "]' value='" + numero + "' ><input class='form-control' type='text' id='mes" + numero + "' name='mes[]' value='" + meses[numero - 1] + "' disabled>" +
					"   </div>" +
					"   <div class='col-md-3'>" +
					"           <label for='val_medido_inicial'>Inicial:</label><input class='form-control' type='text' id='valor_medido_inicial" + numero + "' name='valor_medido_inicial" + numero + "' value=''>" +
					"   </div>" +
					"   <div class='col-md-3'>" +
					"           <label for='valor_medido_fim'>Final:</label><input class='form-control' type='text' id='valor_medido_fim" + numero + "' name='valor_medido_fim" + numero + "' value=''>" +
					"   </div>" +
					"   <div class='col-md-3'>" +
					"           <label>&nbsp;</label><input  class='btn btn-block btn-info' type='button' onclick='removerCampoNovo(" + numero + ")' value='Remover'>" +
					"   </div>" +
					"</div>"
				);
				qtdeCampos++;
			}
		}
		if (qtdeCampos == 12) {
			$("input[name='btnAdiciona']").attr('disabled', true);
			qtdeCampos = 0;
		} else {
			$("input[name='btnAdiciona']").attr('disabled', false);
		}
	}
}

//------------------------------------------------------------------------------
function excluirItem(id_cronograma_fisico, id_cronograma, versao, nome_eixo) {
	bootbox.confirm("Confirmar operação [EXCLUIR ITEM]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFisicoItemExcluiDaq',
				data: {
					id_cronograma_fisico: id_cronograma_fisico,
					id_cronograma: id_cronograma,
					versao: versao,
					nome_eixo: nome_eixo
				},
				dataType: 'json',
				success: function (data) {

					$("#versao").val(versao);
					$("#id_cronograma").val(id_cronograma);
					$('.label_Total').text("");
					$('.label_Inicial').text("");
					$('.label_Final').text("");
					$("#campoPai").html("");
					$("#servico").html("");
					$("#tipo").html("");
					document.getElementById("servico").disabled = true;
					document.getElementById("tipo").disabled = true;
					TotalServicoAquaviario(id_cronograma, versao, nome_eixo);
					RecuperaObra();
					$('#cadastraCronogramaFisico').show();
					$("#searchdate").show();
					$("#btnVoltar").hide();
					$("#btnInclusao").hide();
					$("#exibeEixoLado").show();
					$("#visualizar_cronogramaagrupado").hide();
					$("#exibePk").hide();
					$("#versao").val(versao);
					$("#id_cronograma").val(id_cronograma);
					$('#visualizar_cronogramafisico_eixo').hide();
					$("#nome_eixo").val(nome_eixo);
					ServicosInseridosAquaviario(id_cronograma, versao, nome_eixo);
					RecuperaGeorreferenciamento(nome_eixo);

					$.notify('Excluído com sucesso!', "success");
				}, error: function (data) {
					$.notify('Falha', "warning");
				}
			});
		}
	});
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function TotalServicoAquaviario(id_cronograma, versao, nome_eixo) {
	var id_cronograma = $('#id_cronograma').val();
	var versao = $('#versao').val();

	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFisicoTotalDaq?id_cronograma=' + id_cronograma + '&versao=' + versao + '&nome_eixo=' + nome_eixo,
		dataType: 'json',
		success: function (data) {
			$('.label_Total').text(data.total);
			$('.label_Inicial').text(data.inicial);
			$('.label_Final').text(data.final);
		}, error: function (data) {
			$.notify('Falha na consulta', "warning");

		}
	});
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function ServicosInseridosAquaviario(id_cronograma, versao, nome_eixo) {
	var id_cronograma = $('#id_cronograma').val();
	var versao = $('#versao').val();
	//--------------------------------------------------
	$('#itens_inseridos').show();
	//--------------------------------------------------
	$('#table_itens_inseridos').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFisicoRetornaServicoDaq?id_cronograma=" + id_cronograma + '&versao=' + versao + '&nome_eixo=' + nome_eixo,
		"aoColumns": [
			{data: 'conte', "sClass": "text-center"},
			{data: 'medida', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'executora', "sClass": "text-center"},
			{data: 'mes_ano', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"},
			{data: 'usuario', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaCronogramaAgrupado() {
	var table = $('#table_visualizar_cronogramaagrupado_naopublicado').DataTable();
	table.destroy();
	$('#table_visualizar_cronogramaagrupado_naopublicado').dataTable({
		"bProcessing": false,
		"bFilter": false,
		"bInfo": false,
		"bLengthChange": false,
		"pageLength": 100,
		"destroy": true,
		"bSort": false,
		"bPaginate": false,
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por página",
			"sZeroRecords": "Nenhum registro encontrado",
			"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
			"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros)",
			"sSearch": "Pesquisar: ",
			"pageLength": 100,
			"oPaginate": {
				"sFirst": "Início",
				"sPrevious": "Anterior",
				"sNext": "Próximo",
				"sLast": "Último"
			}
		},
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFisicoPublicadoNDaq",
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'eixo', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'desc_nome', "sClass": "text-center"},
			{data: 'publicado', "sClass": "text-center"},
			{data: 'detalhar', "sClass": "text-center"},
			{data: 'inserir', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"}
		]
	});

	var table = $('#table_visualizar_cronogramaagrupado_publicado').DataTable();
	table.destroy();
	$('#table_visualizar_cronogramaagrupado_publicado').dataTable({
		"bProcessing": false,
		"bFilter": false,
		"bInfo": false,
		"bLengthChange": false,
		"pageLength": 100,
		"destroy": true,
		"bSort": false,
		"bPaginate": false,
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por página",
			"sZeroRecords": "Nenhum registro encontrado",
			"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
			"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros)",
			"sSearch": "Pesquisar: ",
			"pageLength": 100,
			"oPaginate": {
				"sFirst": "Início",
				"sPrevious": "Anterior",
				"sNext": "Próximo",
				"sLast": "Último"
			}
		},
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFisicoPublicadoDaq",
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'eixo', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'desc_nome', "sClass": "text-center"},
			{data: 'data_cronograma', "sClass": "text-center"},
			{data: 'publicado', "sClass": "text-center"},
			{data: 'data_publicar', "sClass": "text-center"},
			{data: 'nome_publicar', "sClass": "text-center"},
			{data: 'detalhar', "sClass": "text-center"},
			{data: 'inserir', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"}
		]
	});
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function DetalhadoNaoPublicado(id_cronograma, versao, nome_eixo, linha, conte) {
	//--------------------------------------------------------------------------------------------------------
	for (i = 1; i <= conte; i++) {
		$('#detalhar_naopublicado_' + i).css({"background-color": "#F4F4F4"});
	}
	$('#detalhar_naopublicado_' + linha).css({"background-color": "#b0bed9"});

	$('#visualizar_cronogramafisico_eixo').show();
	var table = $('#table_visualizar_cronogramafisico_eixo').DataTable();
	table.destroy();


	var linha = linha - 1;
	var table = $('#table_visualizar_cronogramaagrupado_naopublicado').DataTable();
	table.rows().deselect();
	table.row(':eq(' + linha + ')', {page: 'current'}).select();

	var table_visualizar_cronogramaagrupado_publicado = $('#table_visualizar_cronogramaagrupado_publicado').DataTable();
	table_visualizar_cronogramaagrupado_publicado.rows().deselect();


	var $table_visualizar_cronogramafisico_eixo = $('#table_visualizar_cronogramafisico_eixo');
	$($table_visualizar_cronogramafisico_eixo).show('slow');
	$(window).scrollTo('#table_visualizar_cronogramafisico_eixo', 1500, {offset: -50});

	$('#table_visualizar_cronogramafisico_eixo').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFisicoDetalhadoNPDaq?id_cronograma=" + id_cronograma + '&versao=' + versao + '&nome_eixo=' + nome_eixo,
		"aoColumns": [
			{data: 'conte', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'mes_ano', "sClass": "text-center"},
			{data: 'executora', "sClass": "text-center"},
			{data: 'medida', "sClass": "text-center"},
			{data: 'desc_nome', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'publicado', "sClass": "text-center"}

		]
	});
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function DetalhadoPublicado(id_cronograma, versao, id_operacao, linha, conte) {
	//-------------------------------------------------------------------------------------------------------
	for (i = 1; i <= conte; i++) {
		$('#detalhar_publicado_' + i).css({"background-color": "#F4F4F4"});
	}
	$('#detalhar_publicado_' + linha).css({"background-color": "#b0bed9"});

	$('#visualizar_cronogramafisico_eixo').show();
	var table = $('#table_visualizar_cronogramafisico_eixo').DataTable();
	table.destroy();

	var linha = linha - 1;
	var table = $('#table_visualizar_cronogramaagrupado_publicado').DataTable();
	table.rows().deselect();
	table.row(':eq(' + linha + ')', {page: 'current'}).select();

	var table_visualizar_cronogramaagrupado_naopublicado = $('#table_visualizar_cronogramaagrupado_naopublicado').DataTable();
	table_visualizar_cronogramaagrupado_naopublicado.rows().deselect();

	var $table_visualizar_cronogramafisico_eixo = $('#table_visualizar_cronogramafisico_eixo');
	$($table_visualizar_cronogramafisico_eixo).show('slow');
	$(window).scrollTo('#table_visualizar_cronogramafisico_eixo', 1500, {offset: -50});

	$('#table_visualizar_cronogramafisico_eixo').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFisicoDetalhadoDaq?id_cronograma=" + id_cronograma + '&versao=' + versao + '&id_operacao=' + id_operacao,
		"aoColumns": [
			{data: 'conte', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'mes_ano', "sClass": "text-center"},
			{data: 'executora', "sClass": "text-center"},
			{data: 'medida', "sClass": "text-center"},
			{data: 'desc_nome', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'publicado', "sClass": "text-center"}


		]
	});
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function ContaNaoPublicado() {

	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFisicoContaDaq',
		dataType: 'json',
		async: false,
		success: function (data) {
			if (data.conte_naopublicado >= 1) {
				$("#btnInclusao").attr("disabled", true);

			} else {
				$("#btnInclusao").attr("disabled", false);

			}
		}, error: function (data) {
			$.notify('Falha na operação ContaNaoPublicado', "warning");
		}
	});

}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function inserirCronograma(id_cronograma, versao, nome_eixo) {
	$("#versao").val(versao);
	$("#id_cronograma").val(id_cronograma);
	$('.label_Total').text("");
	$('.label_Inicial').text("");
	$('.label_Final').text("");
	$("#campoPai").html("");
	$("#servico").html("");
	$("#tipo").html("");

	document.getElementById("servico").disabled = true;
	document.getElementById("tipo").disabled = true;

	$("#searchdate").show();
	$("#exibeEixoLado").show();
	$('#cadastraCronogramaFisico').show();

	$("#exibePk").hide();
	$("#btnVoltar").hide();
	$("#btnInclusao").hide();
	$("#btninsereCronogramaFisico").hide();
	$("#visualizar_cronogramaagrupado").hide();
	$('#visualizar_cronogramafisico_eixo').hide();
// $("#exibeCronogramaFinanceiroObra").hide();
	$("#versao").val(versao);
	$("#id_cronograma").val(id_cronograma);
	$("#nome_eixo").val(nome_eixo);

	RecuperaObra();
	TotalServicoAquaviario(id_cronograma, versao, nome_eixo);
	ServicosInseridosAquaviario(id_cronograma, versao, nome_eixo);
	// RecuperaGeorreferenciamento(id_operacao);
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function PublicarCronograma_naopublicado(id_cronograma, versao, nome_eixo) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	bootbox.confirm("Confirmar operação [PUBLICAR CRONOGRAMA]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFisicoPublicarDaq?id_cronograma=' + id_cronograma + '&versao=' + versao + '&nome_eixo=' + nome_eixo + '&periodo=' + termo,
				dataType: 'json',
				success: function (data) {
					$.notify('Cronograma publicado!', "success");
					ContaNaoPublicado();
					$('#visualizar_cronogramafisico_eixo').hide();
					var table_naopublicado = $("#table_visualizar_cronogramaagrupado_naopublicado").DataTable();
					table_naopublicado.ajax.reload();

					var table_publicado = $("#table_visualizar_cronogramaagrupado_publicado").DataTable();
					table_publicado.ajax.reload();
					$('.label_Total').text("");
					$('.label_Inicial').text("");
					$('.label_Final').text("");

				}, error: function (data) {
					$.notify('Falha na operação PublicarCronograma', "warning");

				}
			});
		}
	});
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaGeorreferenciamento(nome_eixo) {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFisicoGeoDaq?nome_eixo=' + nome_eixo,
		dataType: 'json',
		success: function (data) {
			$('.label_km').text(data.km);
			$('.label_ext').text(data.ext);
		}, error: function (data) {
			$.notify('Falha', "warning");

		}
	});

}

function MsgPublicar(linha, conte) {
//--------------------------------------------------------------------------------------------------------
	for (i = 1; i <= conte; i++) {
		$('#publicado_naopublicado_' + i).css({"background-color": "#F4F4F4"});
	}
	$('#publicado_naopublicado_' + linha).css({"background-color": "#b0bed9"});

	$('#visualizar_cronogramafisico_eixo').show();
	var table = $('#table_visualizar_cronogramafisico_eixo').DataTable();
	table.destroy();


	var linha = linha - 1;
	var table = $('#table_visualizar_cronogramaagrupado_naopublicado').DataTable();
	table.rows().deselect();
	table.row(':eq(' + linha + ')', {page: 'current'}).select();

	var table_visualizar_cronogramaagrupado_publicado = $('#table_visualizar_cronogramaagrupado_publicado').DataTable();
	table_visualizar_cronogramaagrupado_publicado.rows().deselect();


	$.notify('Não permitido! Para ação [PUBLICAR], o [Valor do Serviço em Percentual] deve ser igual a [100%] ', "warning");

}

function ListaItensInseridos() {
	var servico = $("#servico").val();
	var tipo = $("#tipo").val();
	var nome_eixo = $("#nome_eixo").val();
	var somafinal = 0;
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFisicoRetornaItensDaq?servico=' + servico + '&tipo=' + tipo + '&nome_eixo=' + nome_eixo,
		dataType: 'json',
		success: function (data) {
			for (j = 1; j <= 12; j++) {
				$('#valor_medido'+j).val('');
			}
			$.each(data, function (i, d) {
				$('#valor_medido'+d.mes).val(d.vm);
				if ($("#valor_medido" + d.mes).length) {
					nan = $("#valor_medido" + d.mes).val().replace('.', '');
					var res = nan.replace(',', '.');
					somafinal = somafinal + parseFloat(res);
				}
			});
		}, error: function (data) {
			$.notify('Falha', "warning");

		}
	});

}
