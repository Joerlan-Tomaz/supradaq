//##############################################################################
//# DNIT
//# diagramapontopassagemView.js
//# Desenvolvedor:Jordana Alencar
//# Data:02/12/19 
//##############################################################################
//------------------------------------------------------------------------------
$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});

	$("#datepicker").on("changeDate", function () {
		recuperaDiagramaPontoPassagem();
	});
	//------------------ biblioteca fancybox -----------------------------------
	$("[data-fancybox]").fancybox({
		buttons: ["zoom", "download", "close"]
	});
	//--------------------------------------------------------------------------
	recuperaDiagramaPontoPassagem();
	// document.getElementById("datepicker").disabled = true;
	//--------------------------------------------------------------------------
	$("#fileUploadDiagramaPontoPassagem").change(function () {
		//-------------------------------------------------------------------------
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
			//-------------------------------------------------------------------------
			var form = new FormData();
			form.append('arquivo', $('#fileUploadDiagramaPontoPassagem')[0].files[0]);
			form.append('periodo', termo);
			//----------------------------------------------------------------------
			bootbox.confirm("Confirmar operação [INSERIR DIAGRAMA DE PONTO DE PASSAGEM OCORRÊNCIA DE PROJETO]?", function (result) {
				if (result === true) {
					$.ajax({
						type: "POST",
						url: base_url + "index_cgop.php/DiagramaPPInsereDaq",
						data: form,
						dataType: "json",
						contentType: false,
						processData: false,
						success: function (data) {
							$.notify(data.mensagem, data.notify);
							$("#fileUploadDiagramaPontoPassagem").val("");
							var table = $("#tableDiagramaPontoPassagem").DataTable();
							table.ajax.reload();
						}, error: function (data) {
							$.notify("Falha no cadastro,arquivo pode estar extensão não permitida!", "warning");
						}
					});
				}
			});
		}
	});
	//--------------------------------------------------------------------------
	$("#btnVoltar").click(function () {
		// document.getElementById("datepicker").disabled = false;
		$("#exibesupervisaocont").empty();
		$("#exibesupervisaocont").load("index_cgop.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
	});
});

//------------------------------------------------------------------------------
function anexoDiagrama(nome_arquivo) {
	$.ajax({
		url: 'anexoDiagrama',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/arquivoDaq/img/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
			excluirDiagrama(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function recuperaDiagramaPontoPassagem() {
	//-----------------------------------------------------------------------
	document.getElementById("datepicker").disabled = false;
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker("getDate");
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$("#tableDiagramaPontoPassagem").dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/DiagramaPPRecuperaDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "ARQUIVO", "sClass": "text-justify", width: "60%"},
			{data: "NOME", "sClass": "text-center", width: "15%"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center", width: "15%"},
			{data: "ACAO", "sClass": "text-center", width: "10%"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirDiagramaPontoPassagem(id_arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR MAPA DE SITUAÇÃO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/DiagramaPPExcluirDaq",
					data: {id_arquivo: id_arquivo},
					dataType: "json",
					success: function (data) {
						$.notify("Excluído com sucesso!", "success");
						var tableDiagramaPontoPassagem = $("#tableDiagramaPontoPassagem").DataTable();
						tableDiagramaPontoPassagem.ajax.reload();
					}, error: function (data) {
						$.notify("Falha no cadastro", "warning");
					}
				});
			}
		});
	}
}

function excluirDiagrama(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/excluirDiagrama',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			// $.notify('Excluido com Sucesso!', "success");
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//-----------------------------------------------------------------------------
