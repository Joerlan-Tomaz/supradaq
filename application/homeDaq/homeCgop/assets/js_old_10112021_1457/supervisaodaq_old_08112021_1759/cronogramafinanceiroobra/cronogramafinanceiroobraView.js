//######################################################################################################################################################################################## 
//# DNIT
//# cronogramafinanceiroobraView.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 09/03/2018 19:35
//########################################################################################################################################################################################
//------------------------------------------------------------------------------
var qtdeCampos = 0;
//------------------------------------------------------------------------------
$().ready(function () {
	$("#incluir").show();
	$("#btnPesquisar").hide();
	$("#btnPublicar").hide();
	$('#cadastraCronogramaFinanceiroObra').hide();
	$('#visualizar_cronogramafinanceiroobra').hide();
	$('#visualizar_cronogramaagrupado').show();
	$('#exibeCronogramaFinanceiroObra').hide();
	//--------------------------------------------------------------------------
	$('#anoreferente').datepicker({
		format: "yyyy",
		startView: 1,
		minViewMode: 2,
		language: "pt-BR",
		autoclose: true
	});
	$("#anoreferente").datepicker("setDate", new Date());
	//--------------------------------------------------------------------------
	//saldos();
	//recuperaCronograma();
	ContaNaoPublicado();
	RecuperaCronogramaAgrupado();

	//--------------------------------------------------------------------------
	$('#btnVisualizar').click(function () {
		btnVisualizar();
	});

	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	//--------------------------------------------------------------------------
	$("#btnPesquisar").click(function () {
		btnPesquisar();
		$("#btnInclusao").show();
		$("#btnPesquisar").hide();
		$("#btnPublicar").hide();
		$("#btnVoltar").show();
		$('#exibeCronogramaFinanceiroObra').hide();
	});
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {

		btnInclusao();
		$("#btnPesquisar").show();
		$("#btnPublicar").show();
		$("#btnVoltar").hide();
		$("#btnInclusao").hide();
		$('#exibeCronogramaFinanceiroObra').show();

		$('#versao').val('');
		$('#id_cronograma').val('');

		$("#obra").val('Selecione');
		$("#servico").val('');
		$("#tipo").val('');

		document.getElementById("servico").disabled = true;
		document.getElementById("tipo").disabled = true;
		$("#campoPai").html("");
		$("#insereCronogramaFinanceiroObra").hide();

	});
	//--------------------------------------------------------------------------
	$("#btn_salvaredicao").click(function () {
		btn_salvaredicao();
	});
	//--------------------------------------------------------------------------
	$("#insereCronogramaFinanceiroObra").click(function () {
		var id_cronograma = $('#id_cronograma').val();
		var versao = $('#versao').val();

		if (id_cronograma != '' | versao != '') {
			insereCronogramaFinanceiroObraVersao(id_cronograma, versao);
		} else {
			insereCronogramaFinanceiroObra();
		}


	});
	//--------------------------------------------------------------------------
	$("#adicionaCamposValor").click(function () {
		adicionaCamposValor();
	});
	//--------------------------------------------------------------------------
	$("#btnPublicar").click(function () {
		if (verificaCronograma() == true) {
			$.notify('Cronograma já publicado,não pode ser alterado', "warning");
		} else {
			publicar();
		}
	});
});

//------------------------------------------------------------------------------
function recuperaCronograma() {
	$('#table_visualizar_cronogramafinanceiroobra').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFinanceiroRetornaDaq",
		"aoColumns": [
			{data: 'valor_previsto', "sClass": "text-center"},
			{data: 'usuario', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});
}

//------------------------------------------------------------------------------
function PublicarCronograma_naopublicado(id_cronograma, versao, id_cronograma_financeiro_versao) {
	bootbox.confirm("Confirmar operação [PUBLICAR CRONOGRAMA]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFinanceiroPublicarDaq?id_cronograma=' + id_cronograma + '&versao=' + versao + '&id_cronograma_financeiro_versao=' + id_cronograma_financeiro_versao,
				dataType: 'json',
				success: function (data) {
					$.notify('Publicado!', "success");
					ContaNaoPublicado();
					$('#visualizar_cronogramafinanceiroobra').hide();
					var table_naopublicado = $("#table_visualizar_cronogramaagrupado_naopublicado").DataTable();
					table_naopublicado.ajax.reload();

					var table_publicado = $("#table_visualizar_cronogramaagrupado_publicado").DataTable();
					table_publicado.ajax.reload();

				}, error: function (data) {
					$.notify('Falha na operação PublicarCronograma', "warning");

				}
			});
		}
	});
}

//------------------------------------------------------------------------------
function RecuperaeditarCronograma(id_cronograma_financeiro) {

	$('#editarcronograma').modal('show');
	$("#editarId").val(id_cronograma_financeiro);
	$('#table_editar_cronogramafinanceiroobra').dataTable({
		"bProcessing": false,
		"destroy": true,
		"bFilter": false,
		"bInfo": false,
		"bLengthChange": false,
		"bPaginate": false,
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por página",
			"sZeroRecords": "Nenhum registro encontrado",
			"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
			"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros)",
			"sSearch": "Pesquisar: ",
			"pageLength": 1,
			"oPaginate": {
				"sFirst": "Início",
				"sPrevious": "Anterior",
				"sNext": "Próximo",
				"sLast": "Último"
			}
		},
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFinanceiroEditarDaq?id_cronograma_financeiro=" + id_cronograma_financeiro,
		"aoColumns": [
			{data: 'valor_previsto', "sClass": "text-center"},
			{data: 'usuario', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"}
		]
	});

}

//------------------------------------------------------------------------------
function saldos(id_cronograma, versao) {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroSaldoDaq?id_cronograma=' + id_cronograma + '&versao=' + versao,
		dataType: 'json',
		success: function (data) {
			var valor_pi = parseFloat(data.pi);
			var valor_saldo = parseFloat(data.saldo);
			var valor_saldo_lancar = parseFloat(data.saldo_lancar);
			$('.label_pi').text("R$ " + valor_pi.toFixed(2).replace(".", ",").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
			$('.label_saldo').text("R$ " + valor_saldo.toFixed(2).replace(".", ",").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
			$('.label_saldo_lancar').text("R$ " + valor_saldo_lancar.toFixed(2).replace(".", ",").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));

		}, error: function (data) {
			$.notify('Falha', "warning");
		}
	});
}

//------------------------------------------------------------------------------
// clique do botao novo
function btnInclusao() {
	$('#novo_cronogramafinanceiroobra').hide();
	$('#visualizar_cronogramafinanceiroobra').hide();
	$('#visualizar_cronogramaagrupado').hide();
	$('#cadastraCronogramaFinanceiroObra').show();
	$("#incluir").hide();
	$("#search").show();
	//populaTipoEixo();
	saldos(0, 0);
	RecuperaDetalhadoIncluir();
	//--------------------------------------------------------------------------
	$("#obra").val('Selecione');
	$("#servico").val('');
	$("#tipo").val('');

	document.getElementById("servico").disabled = true;
	document.getElementById("tipo").disabled = true;
	$("#campoPai").html("");
	$("#insereCronogramaFinanceiroObra").hide();

	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroObraDaq',
		dataType: 'json',
		success: function (data) {
			var obra = $('select[id=obra]');
			obra.html('');
			obra.append('<option value="Selecione" selected >Selecione</option>');
			for (i = 0; i < data.id_obra.length; i++) {
				obra.append('<option value="' + data.id_obra[i] + '">' + data.obra[i] + '</option>');
			}
		}
	});
}

//------------------------------------------------------------------------------
function btnPesquisar() {
	$('#visualizar_cronogramaagrupado').show();
	$('#visualizar_cronogramafinanceiroobra').hide();
	$('#cadastraCronogramaFinanceiroObra').hide();
	ContaNaoPublicado();
	RecuperaCronogramaAgrupado();
	$("#incluir").show();
	$("#search").hide();
	//recuperaCronograma();
	$('#versao').val('');
	$('#id_cronograma').val('');
}

//------------------------------------------------------------------------------
function insereCronogramaFinanceiroObra() {
	var valor = 0;
	for (var numero = 1; numero <= 12; numero++) {
		num = $("#valorprev" + numero).val().replace(',', '.');
		if (num == '') {
			valor++;
		}
	}
	if (valor == 12) {
		for (var numero = 1; numero <= 12; numero++) {
			document.getElementById("valorprev" + numero).style.borderColor = 'red';
		}
		$.notify("Os Campos [Valor Previsto] estão vazios!", "warning");
		return false;
	}
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroVersaoDaq',
		dataType: 'json',
		success: function (data) {
			var id_cronograma = data.id_cronograma;
			var versao = data.versao;
			$('#id_cronograma').val(id_cronograma);
			$('#versao').val(versao);

			var serializedData = $("#formularioCronogramaFinanceiroObra").serializeArray();
			bootbox.confirm("Confirmar operação [INSERIR CRONOGRAMA FINANCEIRO DE OBRA]?", function (result) {
				if (result === true) {
					$.ajax({
						type: 'POST',
						url: base_url + 'index_cgop.php/CronogramaFinanceiroInsereDaq',
						data: serializedData,
						dataType: 'json',
						success: function (data) {
							$('#id_cronograma').val(id_cronograma);
							$('#versao').val(versao);
							$.notify('Cronograma financeiro, Aquaviário, cadastrado com sucesso!', "success");
							// $("#anoreferente").val("");
							$("#obra").val("Selecione");
							$("#servico").val("");
							$("#tipo").val("");
							document.getElementById("servico").disabled = true;
							document.getElementById("tipo").disabled = true;
							$("#campoPai").html("");
							$("#insereCronogramaFinanceiroObra").hide();

							saldos(id_cronograma, versao);
							RecuperaDetalhadoIncluir();

						}, error: function (data) {
							$.notify('Falha no cadastro', "warning");

						}
					});
				}
			});


		}
	});

}

function insereCronogramaFinanceiroObra_old() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroVersaoDaq',
		dataType: 'json',
		success: function (data) {
			var id_cronograma = data.id_cronograma;
			var versao = data.versao;

		}
	});
	$('#id_cronograma').val(id_cronograma);
	$('#versao').val(versao);

	if (id_cronograma == '') {
		id_cronograma = 0;
	}
	if (versao == '') {
		versao = 0;
	}
	if ($('#eixo').val() == 'Selecione' | $('#servico').val() == 'Todos') {
		$.notify('Campos [Eixo] e [Serviço] são obrigatórios!', "warning");
	} else {
		var serializedData = $("#formularioCronogramaFinanceiroObra").serializeArray();
		bootbox.confirm("Confirmar operação [INSERIR CRONOGRAMA FINANCEIRO DE OBRA]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/CronogramaFinanceiroInsereDaq',
					data: serializedData,
					dataType: 'json',
					success: function (data) {
						$('#id_cronograma').val(id_cronograma);
						$('#versao').val(versao);
						$.notify('Cronograma  cadastrado com sucesso!', "success");
						$("#campoPai").html("");
						// $("#anoreferente").val("");
						$("#servico").val("Todos");
						$("#insereCronogramaFinanceiroObra").hide();
						saldos(id_cronograma, versao);
						RecuperaDetalhadoIncluir();

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
function insereCronogramaFinanceiroObraVersao(id_cronograma, versao) {
	var valor = 0;
	for (var numero = 1; numero <= 12; numero++) {
		num = $("#valorprev" + numero).val().replace(',', '.');
		if (num == '') {
			valor++;
		}
	}
	if (valor == 12) {
		for (var numero = 1; numero <= 12; numero++) {
			document.getElementById("valorprev" + numero).style.borderColor = 'red';
		}
		$.notify("Os Campos [Valor Previsto] estão vazios!", "warning");
		return false;
	}
	var serializedData = $("#formularioCronogramaFinanceiroObra").serializeArray();
	bootbox.confirm("Confirmar operação [INSERIR CRONOGRAMA FINANCEIRO DE OBRA]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFinanceiroInsereVersaoDaq?id_cronograma=' + id_cronograma + '&versao=' + versao,
				data: serializedData,
				dataType: 'json',
				success: function (data) {
					$.notify('[Cronograma Financeiro Aquaviário], Cadastrado com sucesso!', "success");

					$("#obra").val("Selecione");
					$("#servico").val("");
					$("#tipo").val("");
					document.getElementById("servico").disabled = true;
					document.getElementById("tipo").disabled = true;
					$("#campoPai").html("");
					$("#insereCronogramaFinanceiroObra").hide();

					saldos(id_cronograma, versao);
					RecuperaDetalhadoIncluir();

				}, error: function (data) {
					$.notify('Falha no cadastro', "warning");

				}
			});
		}
	});

}

//------------------------------------------------------------------------------
function adicionaCamposValor() {

	if ($("#obra").val() == "Selecione") {
		$.notify("Informe o campo [Obra]", "warning");
		document.getElementById("obra").style.borderColor = "red";
		return false
	} else {
		document.getElementById("obra").style.borderColor = "gray";
	}

	if ($("#servico").val() == "Selecione") {
		$.notify("Informe o campo [Serviço]", "warning");
		document.getElementById("servico").style.borderColor = "red";
		return false
	} else {
		document.getElementById("servico").style.borderColor = "gray";
	}
	if ($("#tipo").val() == "Selecione" || $("#tipo").val() == "") {
		$.notify("Informe o campo [Tipo]", "warning");
		document.getElementById("tipo").style.borderColor = "red";
		return false
	} else {
		document.getElementById("tipo").style.borderColor = "gray";
	}

	if (true) {
		var meses = ["Janeiro", "Fevereiro", "Marco", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
		for (var numero = 1; numero <= 12; numero++)
			if (!$("#filho" + numero)[0]) {
				$("#campoPai").append(
					"<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 row form-group' id='filho" + numero + "'>" +
					"   <div class='col-md-3'>" +
					"       <label for='valor'>Mês:</label>" +
					"       <input type='hidden' id='mes" + numero + "' name='mes[" + numero + "]' value='" + numero + "' ><input class='form-control' type='text' id='mes" + numero + "' name='mes[]' value='" + meses[numero - 1] + "' disabled>" +
					"   </div>" +
					"   <div class='col-md-3'>" +
					"       <label for='valor'>Valor Previsto:</label>" +
					"       <div class='input-group date'>" +
					"           <div class='input-group-prepend'>" +
					"               <span class='input-group-text'>R$</span>" +
					"           </div>" +
					"           <input class='form-control' type='text' id='valorprev" + numero + "' name='valorprev[" + numero + "]' value='' maxlength='20' onkeydown='FormataMoeda(this, 15, event)' onkeypress='return maskKeyPress(event)'>" +
					"       </div>" +
					"   </div>" +
					"   <div class='col-md-3'>" +
					"           <input style='margin-top: 25px;' class='btn btn-block btn-info' type='button' onclick='removerCampo(" + numero + ")' value='Remover'>" +
					"   </div>" +
					"</div>"
				);
				qtdeCampos++;
			}
		$("#insereCronogramaFinanceiroObra").show();
	}
}

//------------------------------------------------------------------------------
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

//------------------------------------------------------------------------------
function ExcluirAvancoInternoIncluir(id_cronograma_financeiro) {
	bootbox.confirm("Confirmar operação [EXCLUIR CRONOGRAMA]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFinanceiroTrashavanDaq?id_cronograma_financeiro=' + id_cronograma_financeiro,

				dataType: 'json',
				success: function (data) {
					$.notify('Cronograma Excluído com sucesso!', "success");
					var table_detalhado = $("#table_visualizar_cronogramafinanceiroobra").DataTable();
					table_detalhado.ajax.reload();

					var table_agrupado = $("#table_visualizar_cronogramaagrupado_naopublicado").DataTable();
					table_agrupado.ajax.reload();

					var id_cronograma = $('#id_cronograma').val();
					var versao = $('#versao').val();
					saldos(id_cronograma, versao);
				}, error: function (data) {
					$.notify('Falha', "warning");

				}
			});
		}
	});
}

//------------------------------------------------------------------------------
function ExcluirAvancoExternoPublicado(id_cronograma_financeiro) {
	bootbox.confirm("Confirmar operação [EXCLUIR CRONOGRAMA]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/CronogramaFinanceiroTrashavanDaq?id_cronograma_financeiro=' + id_cronograma_financeiro,

				dataType: 'json',
				success: function (data) {
					$.notify('Cronograma Excluído com sucesso!', "success");
					var table_detalhado = $("#table_visualizar_cronogramafinanceiroobra").DataTable();
					table_detalhado.ajax.reload();

					var table_agrupado = $("#table_visualizar_cronogramaagrupado_naopublicado").DataTable();
					table_agrupado.ajax.reload();

				}, error: function (data) {
					$.notify('Falha', "warning");

				}
			});
		}
	});
}

//------------------------------------------------------------------------------
function btn_salvaredicao() {
	var valor_previsto = $('#valor_previsto').val();
	var id = $("#editarId").val();
	if ((!valor_previsto) && (!id)) {
		$.notify('Campo [Total Acumulado já Planejado] é obrigatório!', "warning");
	} else {
		bootbox.confirm("Confirmar operação [EDITAR CRONOGRAMA]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/CronogramaFinanceiroGravaEditaDaq',
					data: {id_cronograma: id, valor_previsto: valor_previsto},
					dataType: 'json',
					success: function (data) {
						$.notify('Cronograma Editado com sucesso!', "success");
						var table_detalhado = $("#table_visualizar_cronogramafinanceiroobra").DataTable();
						table_detalhado.ajax.reload();

						var table_naopublicado = $("#table_visualizar_cronogramaagrupado_naopublicado").DataTable();
						table_naopublicado.ajax.reload();
						var id_cronograma = $('#id_cronograma').val();
						var versao = $('#versao').val();
						saldos(id_cronograma, versao);
					}, error: function (data) {
						$.notify('Não foi possível editar', "warning");
					}
				});
			}
		});
	}
}

//------------------------------------------------------------------------------
function verificaCronograma() {
	var retorno = false;
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroRetornaDaq',
		dataType: 'json',
		async: false,
		success: function (data) {
			if (data.cronograma == "publicado") {
				retorno = true;
			}
		}, error: function (data) {
			$.notify('Falha na operação verificaCronograma', "warning");
		}
	});
	return retorno;
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFinanceiroNpublicadoDaq",
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'total_pi_a', "sClass": "text-center"},
			{data: 'valor_previsto', "sClass": "text-center"},
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFinanceiroPublicadoDaq",
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'total_pi_a', "sClass": "text-center"},
			{data: 'valor_previsto', "sClass": "text-center"},
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
function RecuperaDetalhado_naopublicado(id_cronograma, linha, conte) {
	for (i = 1; i <= conte; i++) {
		$('#detalhar_naopublicado_' + i).css({"background-color": "#F4F4F4"});
	}
	$('#detalhar_naopublicado_' + linha).css({"background-color": "#b0bed9"});

	$('#visualizar_cronogramafinanceiroobra').show();
	var table = $('#table_visualizar_cronogramafinanceiroobra').DataTable();
	table.destroy();

	var linha = linha - 1;
	var table = $('#table_visualizar_cronogramaagrupado_naopublicado').DataTable();
	table.rows().deselect();
	table.row(':eq(' + linha + ')', {page: 'current'}).select();

	var table_publicado = $('#table_visualizar_cronogramaagrupado_publicado').DataTable();
	table_publicado.rows().deselect();


	var $table_visualizar_cronogramafinanceiroobra = $('#table_visualizar_cronogramafinanceiroobra');
	$($table_visualizar_cronogramafinanceiroobra).show('slow');
	$(window).scrollTo('#table_visualizar_cronogramafinanceiroobra', 1500, {offset: -50});

	$('#table_visualizar_cronogramafinanceiroobra').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFinanceiroRetornaDaq?excluir=1&id_cronograma=" + id_cronograma,
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'ano', "sClass": "text-center"},
			{data: 'mes', "sClass": "text-center"},
			{data: 'valor_previsto', "sClass": "text-center"},
			{data: 'usuario', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaDetalhado_publicado(id_cronograma, linha, conte) {
	for (i = 1; i <= conte; i++) {
		$('#detalhar_publicado_' + i).css({"background-color": "#F4F4F4"});
	}
	$('#detalhar_publicado_' + linha).css({"background-color": "#b0bed9"});


	$('#visualizar_cronogramafinanceiroobra').show();
	var table = $('#table_visualizar_cronogramafinanceiroobra').DataTable();
	table.destroy();

	var table = $("#table_visualizar_cronogramaagrupado_naopublicado").DataTable();
	table.ajax.reload();

	var linha = linha - 1;
	var table = $('#table_visualizar_cronogramaagrupado_publicado').DataTable();
	table.rows().deselect();
	table.row(':eq(' + linha + ')', {page: 'current'}).select();

	var table_naopublicado = $('#table_visualizar_cronogramaagrupado_naopublicado').DataTable();
	table_naopublicado.rows().deselect();


	var $table_visualizar_cronogramafinanceiroobra = $('#table_visualizar_cronogramafinanceiroobra');
	$($table_visualizar_cronogramafinanceiroobra).show('slow');
	$(window).scrollTo('#table_visualizar_cronogramafinanceiroobra', 1500, {offset: -50});

	$('#table_visualizar_cronogramafinanceiroobra').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFinanceiroRetornaDaq?id_cronograma=" + id_cronograma,
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'ano', "sClass": "text-center"},
			{data: 'mes', "sClass": "text-center"},
			{data: 'valor_previsto', "sClass": "text-center"},
			{data: 'usuario', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaDetalhadoIncluir() {
	var id_cronograma = $('#id_cronograma').val();


	$('#visualizar_cronogramafinanceiroobra').show();
	$('#table_visualizar_cronogramafinanceiroobra').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/CronogramaFinanceiroRetornaDaq?excluir=2&id_cronograma=" + id_cronograma,
		"aoColumns": [
			{data: 'n', "sClass": "text-center"},
			{data: 'obra', "sClass": "text-center"},
			{data: 'servico', "sClass": "text-center"},
			{data: 'tipo', "sClass": "text-center"},
			{data: 'ano', "sClass": "text-center"},
			{data: 'mes', "sClass": "text-center"},
			{data: 'valor_previsto', "sClass": "text-center"},
			{data: 'usuario', "sClass": "text-center"},
			{data: 'versao', "sClass": "text-center"},
			{data: 'ultima_alteracao', "sClass": "text-center"},
			{data: 'publicar', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"}
		]
	});
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function ContaNaoPublicado() {

	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroContaNDaq',
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

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Inserir nao_publicado
function insere(id_cronograma, versao) {
	$('#novo_cronogramafinanceiroobra').hide();
	// $('#visualizar_cronogramafinanceiroobra').hide();
	$('#visualizar_cronogramaagrupado').hide();
	$('#cadastraCronogramaFinanceiroObra').show();
	$("#incluir").hide();
	$("#search").show();
	$("#id_cronograma").val(id_cronograma);
	$("#versao").val(versao);
	$("#btnInclusao").hide();
	$("#btnPesquisar").show();
	$("#btnVoltar").hide();
	$('#exibeCronogramaFinanceiroObra').show();
	saldos(id_cronograma, versao);
	RecuperaDetalhadoIncluir();
	//--------------------------------------------------------------------------
	$("#obra").val('Selecione');
	$("#servico").val('');
	$("#tipo").val('');

	document.getElementById("servico").disabled = true;
	document.getElementById("tipo").disabled = true;
	$("#campoPai").html("");
	$("#insereCronogramaFinanceiroObra").hide();

	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroObraDaq',
		dataType: 'json',
		success: function (data) {
			var obra = $('select[id=obra]');
			obra.html('');
			obra.append('<option value="Selecione" selected >Selecione</option>');
			for (i = 0; i < data.id_obra.length; i++) {
				obra.append('<option value="' + data.id_obra[i] + '">' + data.obra[i] + '</option>');
			}
		}
	});
}

$("#obra").change(function () {
	$("#insereCronogramaFinanceiroObra").hide();
	RecuperaSevico();
	$("#tipo").html("");
	document.getElementById("tipo").disabled = true;
	$("#campoPai").html("");

});

function RecuperaSevico(id_obra) {
	var id_obra = $("#obra").val();
	if (id_obra !== "") {
		document.getElementById("servico").disabled = false;

		$.ajax({
			type: 'POST',
			url: base_url + 'index_cgop.php/CronogramaFinanceiroServicoDaq',
			data: {id_obra: id_obra},
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

$("#servico").change(function () {
	$("#campoPai").html("");
	$("#insereCronogramaFinanceiroObra").hide();

	var id_servico = $("#servico").val();

	var id_obra = $("#obra").val();
	if ((id_obra == 1 && id_servico == 8) || (id_obra == 1 && id_servico == 9) || (id_obra == 1 && id_servico == 10) ||
		(id_obra == 1 && id_servico == 11) || (id_obra == 1 && id_servico == 12) || (id_obra == 1 && id_servico == 16) ||

		(id_obra == 5 && id_servico == 8) || (id_obra == 5 && id_servico == 9) || (id_obra == 5 && id_servico == 10) ||
		(id_obra == 5 && id_servico == 11) || (id_obra == 5 && id_servico == 12) || (id_obra == 5 && id_servico == 16)) {
		document.getElementById("tipo").disabled = false;
		tipo();
	} else {
		$("#tipo").html("");
		document.getElementById("tipo").disabled = true;
	}
});

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function tipo(servico) {
	var servico = $("#servico").val();
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/CronogramaFinanceiroTipoDaq',
		data: {servico: servico},
		dataType: 'json',
		success: function (data) {
			var tipo = $('select[id=tipo]');
			tipo.html('');
			tipo.append('<option value="Selecione" selected >Selecione</option>');
			for (i = 0; i < data.id_tipo.length; i++) {
				tipo.append('<option value="' + data.tipo[i] + '">' + data.tipo[i] + '</option>');
			}
		}
	});
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function MsgPublicar(id_cronograma, linha, conte) {
	for (i = 1; i <= conte; i++) {
		$('#detalhar_naopublicado_' + i).css({"background-color": "#F4F4F4"});
	}
	$('#detalhar_naopublicado_' + linha).css({"background-color": "#b0bed9"});


	var linha = linha - 1;
	var table = $('#table_visualizar_cronogramaagrupado_naopublicado').DataTable();
	table.rows().deselect();
	table.row(':eq(' + linha + ')', {page: 'current'}).select();

	var table_publicado = $('#table_visualizar_cronogramaagrupado_publicado').DataTable();
	table_publicado.rows().deselect();


	$.notify('Não permitido! Para ação [PUBLICAR], o [Valor Acumulado Planejado] deve ser igual ao [Total (PI+A)] ', "warning");

}
