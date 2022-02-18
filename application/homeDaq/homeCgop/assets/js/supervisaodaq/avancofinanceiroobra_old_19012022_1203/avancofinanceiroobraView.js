//######################################################################################################################################################################################## 
//# DNIT
//# avancofinanceiroobraView.js
//# Desenvolvedor:jordana alencar 
//# Data: 12/03/2020 10:00
//########################################################################################################################################################################################
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$().ready(function () {
	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	//--------------------------------------------------------------------------
	$('#searchdate').hide();
	$('#visualizar_cronograma_avanco_detalhado').hide();
	$('#visualizar_cronograma_avanco_incluir').hide();
	$('#naohouveatividademes').hide();
	$('#table_detalhar').hide();
	$('#cadastrarAvanco').hide();
	$('#table_detalhar_avanco').hide();
	$("#btnNoAtividade").hide();
	//--------------------------------------------------------------------------
	$('#datepicker').on("changeDate", function () {
		$.ajaxSetup({cache: false});
		RecuperaMedicao();
		// table_naohouveatividademes();
	});
	//--------------------------------------------------------------------------
	// RecuperaCronogramaAgrupado();
	RecuperaMedicao();
	// table_naohouveatividademes();
	//--------------------------------------------------------------------------
	$("#btnAvanco").click(function () {
		btnAvanco();
	});
	//--------------------------------------------------------------------------
	$("#btnNoAtividade").click(function () {
		btnNoAtividade();
	});
	//--------------------------------------------------------------------------
	$("#searchdate").click(function () {
		RecuperaMedicao();
		$('#btnNoAtividade').hide();
		$('#searchdate').hide();
		$('#visualizar_medicao').show();
		$('#table_detalhar').hide();
		$('#cadastrarAvanco').hide();
		$('#numemedicao').val('');
		$('#table_detalhar_avanco').hide();
	});
	//--------------------------------------------------------------------------
	$("#btninsereAvanco").click(function () {
		btninsereAvanco();
	});
});

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaMedicao() {
	// confereNaoAtividade();
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var table_naopublicado = $('#table_visualizar_medicao_naopublicado').DataTable();
	table_naopublicado.destroy();

	$('#table_visualizar_medicao_naopublicado').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/AvancoFinNaoPublicadoDaq?periodo=" + termo,
		"aoColumns": [
			{data: 'nume_medicao', "sClass": "text-center"},
			{data: 'infraestrutura', "sClass": "text-center"},
			{data: 'mes_referencia', "sClass": "text-center"},
			{data: 'valor_medicao', "sClass": "text-center"},
			{data: 'data_processamento_medicao', "sClass": "text-center"},
			{data: 'valor_lancado', "sClass": "text-center"},
			{data: 'publicado', "sClass": "text-center"},
			{data: 'detalhar', "sClass": "text-center"},
			{data: 'incluir', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"}
		]
	});
	//------------------------------------------------------------------------------------------------------------------------------
	var table_publicado = $('#table_visualizar_medicao_publicado').DataTable();
	table_publicado.destroy();

	$('#table_visualizar_medicao_publicado').dataTable({
		"bProcessing": false,
		"pageLength": 100,
		"destroy": true,
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
		"sAjaxSource": base_url + "index_cgop.php/AvancoFinPublicadoDaq?periodo=" + termo,
		"aoColumns": [
			{data: 'nume_medicao', "sClass": "text-center"},
			{data: 'infraestrutura', "sClass": "text-center"},
			{data: 'mes_referencia', "sClass": "text-center"},
			{data: 'valor_medicao', "sClass": "text-center"},
			{data: 'data_processamento_medicao', "sClass": "text-center"},
			{data: 'valor_lancado', "sClass": "text-center"},
			{data: 'publicado', "sClass": "text-center"},
			{data: 'detalhar', "sClass": "text-center"},
			{data: 'incluir', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"}
		]
	});

}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaMedicaoNumeMedicao(numemedicao) {
	// confereNaoAtividade();
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var table = $('#table_visualizar_detalhar').DataTable();
	table.destroy();

	$('#table_visualizar_detalhar').dataTable({
		"bProcessing": false,
		"pageLength": 100,
		"destroy": true,
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
		"sAjaxSource": base_url + "index_cgop.php/AvancoFinNumMedicaoDaq?periodo=" + termo + "&numemedicao=" + numemedicao,
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'nume_medicao', "sClass": "text-center"},
			{data: 'mes_referencia', "sClass": "text-center"},
			{data: 'valor_medicao', "sClass": "text-center"},
			{data: 'data_processamento_medicao', "sClass": "text-center"},
			{data: 'valor_lancado', "sClass": "text-center"}
		]
	});

}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaDetalhadoNaopublicado(numemedicao, linha, conte) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	//----------------------------------------------------------------------
	$('#table_detalhar_avanco').show();
	var table = $('#table_visualizar_avanco').DataTable();
	table.destroy();
	//----------------------------------------------------------------------
	var table_visualizar_avanco = $('#table_visualizar_avanco');
	$(table_visualizar_avanco).show('slow');
	$(window).scrollTo('#table_visualizar_avanco', 1500, {offset: -50});
	//----------------------------------------------------------------------

	$('#table_visualizar_avanco').dataTable({
		"bProcessing": false,
		"pageLength": 100,
		"destroy": true,
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
		"sAjaxSource": base_url + "index_cgop.php/AvancoFinDetalhadoDaq?excluir=1&periodo=" + termo + "&numemedicao=" + numemedicao,
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'valor', "sClass": "text-center"},
			{data: 'desc_nome', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});

}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaDetalhadoPublicado(numemedicao, linha, conte) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	//----------------------------------------------------------------------
	$('#table_detalhar_avanco').show();
	var table = $('#table_visualizar_avanco').DataTable();
	table.destroy();

	//----------------------------------------------------------------------
	var table_visualizar_avanco = $('#table_visualizar_avanco');
	$(table_visualizar_avanco).show('slow');
	$(window).scrollTo('#table_visualizar_avanco', 1500, {offset: -50});
	//----------------------------------------------------------------------

	$('#table_visualizar_avanco').dataTable({
		"bProcessing": false,
		"pageLength": 100,
		"destroy": true,
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
		"sAjaxSource": base_url + "index_cgop.php/AvancoFinDetalhadoDaq?periodo=" + termo + "&numemedicao=" + numemedicao,
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'valor', "sClass": "text-center"},
			{data: 'desc_nome', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});

}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function RecuperaincluirAvanco(numemedicao, linha, conte) {
	$('#btnNoAtividade').hide();
	$('#searchdate').show();
	$('#visualizar_medicao').hide();
	$('#table_detalhar').show();
	RecuperaMedicaoNumeMedicao(numemedicao);
	$('#cadastrarAvanco').show();
	$("#obra").val('');
	$("#servico").val('');
	$("#tipo").val('');
	populaInfraEstruturaEditar();
	document.getElementById("servico").disabled = true;
	document.getElementById("tipo").disabled = true;

	$('#numemedicao').val(numemedicao);
	// $('#table_detalhar_avanco').hide();
	$('#valor').val("");
	itensInseridos(numemedicao);

}

function btninsereAvanco() {

	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var numemedicao = $('#numemedicao').val();
	//--------------------------------------------------------------------
	if ($("#infraestrutura").find(":selected").text() == 'Selecione') {
		$.notify("Informe o campo [Nome da Infraestrutura]", "warning");
		document.getElementById("infraestrutura").style.borderColor = "red";
		return false
	} else {
		document.getElementById("infraestrutura").style.borderColor = "gray";
	}
	if ($("#operacao").find(":selected").text() == 'Selecione') {
		$.notify("Informe o campo [Operacao]", "warning");
		document.getElementById("operacao").style.borderColor = "red";
		return false
	} else {
		document.getElementById("operacao").style.borderColor = "gray";
	}
	if ($("#servico").find(":selected").text() == 'Selecione') {
		$.notify("Informe o campo [Serviço]", "warning");
		document.getElementById("servico").style.borderColor = "red";
		return false
	} else {
		document.getElementById("servico").style.borderColor = "gray";
	}

	if ($("#valor").val() == "") {
		$.notify("Informe o campo [Valor]", "warning");
		document.getElementById("valor").style.borderColor = "red";
		return false
	} else {
		document.getElementById("valor").style.borderColor = "gray";
	}

//----------------------------------------------------------------------------
	if (true) {
		var valor = parseInt($('#valor').val());
		if (valor <= 0) {
			$.notify('Campo [Valor] deve ser maior que 0!', "warning");
			document.getElementById("valor").style.borderColor = "red";
			return false;
		} else {
			document.getElementById("valor").style.borderColor = "gray";
		}
		document.getElementById("servico").style.borderColor = "gray";
		document.getElementById("valor").style.borderColor = "gray";
		var serializedData = $("#formularioAvanco").serializeArray();
		bootbox.confirm("Confirmar operação [INSERIR AVANÇO FINANCEIRO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/AvancoFinInsereDaq?periodo=' + termo + '&numemedicao=' + numemedicao,
					data: serializedData,
					dataType: 'json',
					success: function (data) {
						$.notify('Avanço cadastrado com sucesso!', "success");
						var table = $("#table_visualizar_detalhar").DataTable();
						table.ajax.reload();
						$("#obra").val('');
						$("#servico").val('');
						$("#tipo").val('');
						document.getElementById("servico").disabled = true;
						document.getElementById("tipo").disabled = true;
						$('#valor').val("");
						itensInseridos(numemedicao);

					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");

					}
				});
			}
		});
	}
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function ExcluirAvancoInterno(id) {

	bootbox.confirm("Confirmar operação [EXCLUIR AVANÇO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AvancoFinExcluirDaq?id=' + id,
				dataType: 'json',
				success: function (data) {
					$.notify('[EXCLUIR] efetuado com  sucesso!', "success");


					var table1 = $("#table_visualizar_avanco").DataTable();
					table1.ajax.reload();


					var table_visualizar_detalhar = $("#table_visualizar_detalhar").DataTable();
					table_visualizar_detalhar.ajax.reload();


				}, error: function (data) {
					$.notify('Falha na operação', "warning");

				}
			});
		}
	});
}

function ExcluirAvancoExterno(id) {

	bootbox.confirm("Confirmar operação [EXCLUIR AVANÇO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AvancoFinExcluirDaq?id=' + id,
				dataType: 'json',
				success: function (data) {
					$.notify('[EXCLUIR] efetuado com  sucesso!', "success");


					var table_naopublicado = $("#table_visualizar_medicao_naopublicado").DataTable();
					table_naopublicado.ajax.reload();

					var table_publicado = $("#table_visualizar_medicao_publicado").DataTable();
					table_publicado.ajax.reload();

					var table1 = $("#table_visualizar_avanco").DataTable();
					table1.ajax.reload();


				}, error: function (data) {
					$.notify('Falha na operação', "warning");

				}
			});
		}
	});
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function PublicarNaopublicado(numemedicao, linha, conte) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}

	$('#table_detalhar_avanco').hide();

	bootbox.confirm("Confirmar operação [Publicar]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AvancoFinPublicarDaq?numemedicao=' + numemedicao + '&periodo=' + termo,
				dataType: 'json',
				success: function (data) {
					$.notify('[PUBLICAR] efetuado com  sucesso!', "success");

					var table_naopublicado = $("#table_visualizar_medicao_naopublicado").DataTable();
					table_naopublicado.ajax.reload();

					var table_publicado = $("#table_visualizar_medicao_publicado").DataTable();
					table_publicado.ajax.reload();


				}, error: function (data) {
					$.notify('Falha na operação', "warning");

				}
			});
		}
	});
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function itensInseridos(numemedicao) {
	$('#table_detalhar_avanco').show();
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var table = $('#table_visualizar_avanco').DataTable();
	table.destroy();
	$('#table_visualizar_avanco').dataTable({
		"bProcessing": false,
		"pageLength": 100,
		"destroy": true,
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
		"sAjaxSource": base_url + "index_cgop.php/AvancoFinDetalhadoDaq?excluir=2&periodo=" + termo + "&numemedicao=" + numemedicao,
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'valor', "sClass": "text-center"},
			{data: 'desc_nome', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function MsgPublicar(numemedicao, linha, conte) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}

	//----------------------------------------------------------------------
	$.notify('Não permitido! Para ação [PUBLICAR], o [Valor Lançado] deve ser igual ao [Valor Medição] ', "warning");

}

function populaInfraEstruturaEditar() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var periodo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/AvancoFinBuscaInfra',
		dataType: 'json',
		data: {
			periodo: periodo
		},
		success: function (data) {
			var infra = $('select[id=infraestrutura]');
			infra.html('');
			infra.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.nome_infraestrutura.length; i++) {
				infra.append('<option value="' + data.nome_infraestrutura[i] + '">' + data.nome_infraestrutura[i] + '</option>');
			}
			var operacao = $('select[id=operacao]');
			operacao.html('');
			document.getElementById("operacao").disabled = true;
			var servico = $('select[id=servico]');
			servico.html('');
			document.getElementById("servico").disabled = true;
			var tipo = $('select[id=tipo]');
			tipo.html('');
			document.getElementById("tipo").disabled = true;
		}
	});
}

function buscaOperacao(infraestrutura) {
	if (infraestrutura !== "") {
		$.ajax({
			type: 'POST',
			url: base_url + 'index_cgop.php/AvancoFinBuscaOperacao',
			data: {infraestrutura: infraestrutura},
			dataType: 'json',
			success: function (data) {
				document.getElementById("operacao").disabled = false;
				var operacao = $('select[id=operacao]');
				operacao.html('');
				operacao.append('<option value="Selecione" selected >Selecione</option>');
				for (i = 0; i < data.id_operacao.length; i++) {
					operacao.append('<option value="' + data.id_operacao[i] + '">' + data.operacao[i] + '</option>');
				}
				var servico = $('select[id=servico]');
				servico.html('');
				document.getElementById("servico").disabled = true;
				var tipo = $('select[id=tipo]');
				tipo.html('');
				document.getElementById("tipo").disabled = true;
			}
		});
	} else {
		document.getElementById("operacao").disabled = true;

	}
}

function buscaServico(id_operacao) {
	if (id_operacao !== "") {
		document.getElementById("servico").disabled = false;
		$.ajax({
			type: 'POST',
			url: base_url + 'index_cgop.php/AvancoFinBuscaServico',
			data: {infraestrutura:$("#infraestrutura").val(), id_operacao: id_operacao},
			dataType: 'json',
			success: function (data) {
				var servico = $('select[id=servico]');
				servico.html('');
				servico.append('<option value="" selected >Selecione</option>');
				for (i = 0; i < data.id_servico.length; i++) {
					servico.append('<option value="' + data.id_servico[i] + '">' + data.servico[i] + '</option>');
				}
				var tipo = $('select[id=tipo]');
				tipo.html('');
				document.getElementById("tipo").disabled = true;
			}
		});
	} else {
		document.getElementById("servico").disabled = true;
		document.getElementById("tipo").disabled = true;

	}
}

function buscaTipo(servico) {
	if (servico !== "") {
		$.ajax({
			type: 'POST',
			url: base_url + 'index_cgop.php/AvancoFinBuscaTipo',
			data: {infraestrutura:$("#infraestrutura").val(), id_operacao: $("#operacao").val(), servico: servico},
			dataType: 'json',
			success: function (data) {
				var tipo = $('select[id=tipo]');
				if(data.id_tipo[0] != null){
					document.getElementById("tipo").disabled = false;
					tipo.html('');
					tipo.append('<option value="" selected >Selecione</option>');
					for (i = 0; i < data.id_tipo.length; i++) {
						tipo.append('<option value="' + data.id_tipo[i] + '">' + data.tipo[i] + '</option>');
					}
				}else{
					tipo.html('');
					document.getElementById("tipo").disabled = true;
				}
			}
		});
	}else{
		document.getElementById("tipo").disabled = true;
	}

}
