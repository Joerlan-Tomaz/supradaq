//##############################################################################
//# DNIT
//# justificativaempreendimentoView.js
//# Desenvolvedor:Jordana de Alencar
//# Data:27/11/19
//##############################################################################
//------------------------------------------------------------------------------
$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$("#btnPesquisar").hide();
	$("#datepicker").on("changeDate", function () {
		recuperaJustificativa();
	});
	//--------------------------------------------------------------------------
	CKEDITOR.replace("descricao_config_justificativa", {height: 250});
	//--------------------------------------------------------------------------
	recuperaJustificativa();
	// document.getElementById("datepicker").disabled = true;
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			bootbox.confirm("Confirmar operação [INCLUIR JUSTIFICATIVA DE EMPREENDIMENTO]?", function (result) {
				if (result === true) {
					CKEDITOR.instances["descricao_config_justificativa"].setData("");
					$("#id_resumo").val("");
					$("#pesquisaJustificativaEmpreendimento").hide();
					$("#cadastroJustificativaEmpreendimento").show();
					$("#incluir").hide();
					$("#btnPesquisar").show();
					$("#btnVoltar").hide();
				}
			});
		}
	});
	//--------------------------------------------------------------------------
	$("#btnPesquisar").click(function () {
		$("#pesquisaJustificativaEmpreendimento").show();
		$("#cadastroJustificativaEmpreendimento").hide();
		$("#incluir").show();
		$("#btnPesquisar").hide();
		$("#btnVoltar").show();
		recuperaJustificativa();
	});
	//--------------------------------------------------------------------------
	$("#insereJustificativa").click(function () {
		//inserir periodo referencia
		var termo = new Object();
		if (document.getElementById) {
			var dt = $("#datepicker").datepicker('getDate');
			if (dt.toString() === "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			termo.name = "periodo";
			termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
		}
		//------------------ Verificação de campos -----------------------------
		var resumo = CKEDITOR.instances["descricao_config_justificativa"].getData();
		if (resumo == "") {
			if (resumo == "") {
				document.getElementById("descricao_config_justificativa").style.borderColor = "red";
			} else {
				document.getElementById("descricao_config_justificativa").style.borderColor = "#d2d6de";
			}
			$.notify("Informe os campos necessários", "warning");
			return false;
		}
		document.getElementById("descricao_config_justificativa").style.borderColor = "#d2d6de";
		//---------------- Validação de formulario -----------------------------
		var serializedData = new Object();
		serializedData = $("#formularioConfigJustificativa").serializeArray();
		serializedData[0].value = resumo;
		serializedData.push(termo);
		//----------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [INSERIR JUSTIFICATIVA DE EMPREENDIMENTO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/JustificativaInsereDaq",
					data: serializedData,
					dataType: "json",
					success: function (data) {
						$.notify("Cadastrado com sucesso!", "success");
						CKEDITOR.instances["descricao_config_justificativa"].setData("");
						$("#id_resumo").val("");
						$("#pesquisaJustificativaEmpreendimento").show();
						$("#cadastroJustificativaEmpreendimento").hide();
						$("#incluir").show();
						$("#btnPesquisar").hide();
						$("#btnVoltar").show();
						var tableJustificativa = $("#tableJustificativa").DataTable();
						tableJustificativa.ajax.reload();
					}, error: function (data) {
						$.notify("Falha no cadastro", "warning");
					}
				});
			}
		});
	});
	//--------------------------------------------------------------------------
	$("#btnVoltar").click(function () {
		// document.getElementById("datepicker").disabled = false;
		$("#exibesupervisaocont").empty();
		$("#exibesupervisaocont").load(base_url + "index_cgop.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
	});
});

//------------------------------------------------------------------------------
function recuperaJustificativa() {
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
	$("#tableJustificativa").dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/JustificativaRecuperaDaq?periodo=" + termo,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "RESUMO", "sClass": "text-justify", "width": "60%"},
			{data: "NOME", "sClass": "text-center", "width": "15%"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "15%"},
			{data: "ACAO", "sClass": "text-center", "width": "10%"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirJustificativa(id_resumo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR JUSTIFICATIVA DE EMPREENDIMENTO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/JustificativaExcluirDaq",
					data: {id_resumo: id_resumo},
					dataType: "json",
					success: function (data) {
						$.notify("Excluído com sucesso!", "success");
						var tableJustificativa = $("#tableJustificativa").DataTable();
						tableJustificativa.ajax.reload();
					}, error: function (data) {
						$.notify("Falha na exclusão", "warning");
					}
				});
			}
		});
	}
}

//------------------------------------------------------------------------------
function editarJustificativa(id_resumo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR JUSTIFICATIVA DE EMPREENDIMENTO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/JustificativaEditarDaq",
					data: {id_resumo: id_resumo},
					dataType: "json",
					success: function (data) {
						$("#pesquisaJustificativaEmpreendimento").hide();
						$("#cadastroJustificativaEmpreendimento").show();
						$("#incluir").hide();
						$("#btnPesquisar").show();
						$("#btnVoltar").hide();
						var resumo = data.resumo;
						$("#id_resumo").val(data.id_resumo);
						CKEDITOR.instances["descricao_config_justificativa"].setData(resumo);
					}, error: function (data) {
						$.notify("Falha na exclusão", "warning");
					}
				});
			}
		});
	}

}

