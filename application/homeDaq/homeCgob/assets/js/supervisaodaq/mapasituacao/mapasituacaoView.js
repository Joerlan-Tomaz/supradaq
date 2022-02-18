//##############################################################################
//# DNIT
//# mapasituacaoView.js
//# Desenvolvedor:Jordana alencar
//# Data:28/11/19 15:50
//##############################################################################
//------------------------------------------------------------------------------
$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});

	$("#datepicker").on("changeDate", function () {
		recuperaMapaSituacao();
	});
	//------------------ biblioteca fancybox -----------------------------------
	$("[data-fancybox]").fancybox({
		buttons: ["zoom", "download", "close"],
		caption: function (instance, item) {
			return $(this).parent().find('.card-text').html();
		}
	});
	//--------------------------------------------------------------------------
	recuperaMapaSituacao();
	// document.getElementById("datepicker").disabled = true;
	//--------------------------------------------------------------------------
	$("#fileUploadConfigMapa").change(function () {
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
			//---------------- Validação de formulario -----------------------------
			var form = new FormData();
			for (i = 0; i < $("#fileUploadConfigMapa")[0].files.length; i++) {
				form.append("arquivo", $("#fileUploadConfigMapa")[0].files[i]);
			}
			form.append('periodo', termo);
			//----------------------------------------------------------------------
			bootbox.confirm("Confirmar operação [INSERIR MAPA DE SITUAÇÃO]?", function (result) {
				if (result === true) {
					$.ajax({
						type: "POST",
						url: base_url + "index_cgob.php/MapaSituacaoInsereDaq",
						data: form,
						dataType: "json",
						contentType: false,
						processData: false,
						success: function (data) {
							$.notify(data.mensagem, data.notify);
							$("#fileUploadConfigMapa").val("");
							var tableMapaSituacao = $("#tableMapaSituacao").DataTable();
							tableMapaSituacao.ajax.reload();
						}, error: function (data) {
							$.notify("Falha no cadastro", "warning");
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
		$("#exibesupervisaocont").load(base_url + "index_cgob.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
	});
});

//------------------------------------------------------------------------------
function anexoMapas(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgob.php/anexoMapas',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + 'application/homeDaq/arquivoDaq/img/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.download = nome_arquivo;
			anchor.href = arquivo;
			anchor.click();
			$.notify('Download!', "success");
			excluirMapas(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function recuperaMapaSituacao() {
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
	$("#tableMapaSituacao").dataTable({
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
		"sAjaxSource": base_url + "index_cgob.php/MapaSituacaoRecuperaDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "ARQUIVO", "sClass": "text-justify", "width": "60%"},
			{data: "NOME", "sClass": "text-center", "width": "10%"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
			{data: "ACAO", "sClass": "text-center", "width": "10%"}
		]
	});
}

//-----------------------------------------------------------------------------
function excluirMapas(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgob.php/excluirMapas',
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
function excluirArquivo(id_arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [MAPA SITUAÇÃO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgob.php/MapaSituacaoExcluirDaq',
					data: {id_arquivo: id_arquivo},
					dataType: 'json',
					success: function (data) {
						$.notify('Excluído com sucesso!', "success");
						var tableMapaSituacao = $("#tableMapaSituacao").DataTable();
						tableMapaSituacao.ajax.reload();

					}, error: function (data) {
						$.notify('Falha na exclusão', "warning");
					}
				});
			}
		});
	}
}
