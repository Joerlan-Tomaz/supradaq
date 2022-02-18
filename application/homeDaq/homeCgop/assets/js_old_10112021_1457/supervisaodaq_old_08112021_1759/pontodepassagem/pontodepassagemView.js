//##############################################################################
//# DNIT
//# pontopassagemView.js
//# Desenvolvedor:Jordana de Alencar
//# Data:01/01/2020 
//##############################################################################
//------------------------------------------------------------------------------
$().ready(function () {
	var dadosTabelaPP = {};
	//--------------------------------------------------------------------------
	recuperaPontoPassagem();
	// document.getElementById("datepicker").disabled = true;
	//--------------------------------------------------------------------------
	$("#btnInsere").prop('disabled', true);
	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$("#datepicker").on("changeDate", function () {
		recuperaPontoPassagem();
	});
	//--------------------------------------------------------------------------
	$("#fileUploadConfigPontosPassagem").change(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			fileUploadConfigPontosPassagem();
		}
	});
	//--------------------------------------------------------------------------
	$("#btnInsere").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			btnInsere();
		}
	});

	//--------------------------------------------------------------------------
	$("#btnVoltar").click(function () {
		// document.getElementById("datepicker").disabled = false;
		$("#exibesupervisaocont").empty();
		$("#exibesupervisaocont").load(base_url + "index_cgop.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
	});
});

//------------------------------------------------------------------------------
function recuperaPontoPassagem() {
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
	$("#tablePontoPassagem").dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/PontoPassagemRecuperaDaq?periodo=" + termo,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "ARQUIVO"},
			{data: "TOTAL", "sClass": "text-center"},
			{data: "DETALHES", "sClass": "text-center"},
			{data: "NOME", "sClass": "text-center"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center"},
			{data: "ACAO", "sClass": "text-center"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirPontoPassagem(id_arquivo, arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR REGISTROS DE PONTO DE PASSAGEM DO ARQUIVO  '" + arquivo + "']?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/PontoPassagemExcluiDaq",
					data: {id_arquivo: id_arquivo},
					dataType: "json",
					success: function (data) {
						$.notify("Excluido com sucesso!", "success");
						var table = $("#tablePontoPassagem").DataTable();
						table.ajax.reload();
					}, error: function (data) {
						$.notify("Falha na exclusão", "warning");
					}
				});
			}
		});
	}
}

function anexoPontoPass(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/anexoPontoPass',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/application/homeDaq/arquivoDaq/arq/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
			excluirpp(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

function ModeloPontoPassagem(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/ModeloPontoPassagem',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/arquivoDaq/arq/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
			excluirpp(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function dividirDadosTabelaExcel(base, max) {
	var arrayOfArrays = [];
	for (var i = 0; i < base.length; i += max) {
		arrayOfArrays.push(base.slice(i, i + max));
	}
	return arrayOfArrays;
}

//------------------------------------------------------------------------------
function detalhesPontoPassagem(id_arquivo) {
	$("#detalhesPontoPassagem").modal("show");
	$("#tableDetalhesPontoPassagem").dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/PontoPassagemDetalhesDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "id_arquivo", "value": id_arquivo});
		},
		"aoColumns": [
			{data: "NOME", "sClass": "text-center"},
			{data: "TIPO", "sClass": "text-center"},
			{data: "ESTACA", "sClass": "text-center"},
			{data: "COORDENADAS", "sClass": "text-center"},
			{data: "KM", "sClass": "text-center"},
			{data: "USUARIO", "sClass": "text-center"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center"}
		]
	});
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function fileUploadConfigPontosPassagem() {
	$("#btnInsere").prop('disabled', true);
	//------------------ Verificação de campos -----------------------------
	if ($("#fileUploadConfigPontosPassagem").val() == "") {
		$("#fileUploadConfigPontosPassagem").css("borderColor", "red");
		$.notify("Preencha os campos obrigatórios", "warning");
		return false;
	} else {
		$("#fileUploadConfigPontosPassagem").css("borderColor", "#d2d6de");
	}
	//-----------------------------------------------------------------------------
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
	form.append("arquivo", $("#fileUploadConfigPontosPassagem")[0].files[0]);
	form.append('periodo', termo);
	//----------------------------------------------------------------------
	//  bootbox.confirm("Confirmar operação [INSERIR GEORREFERENCIAMENTO]?", function (result) {
	//  if (result === true) {
	$.ajax({
		type: "POST",
		url: base_url + "index_cgop.php/PontoPassagemInsereDaq",
		dataType: "json",
		data: form,
		dataType: "json",
		contentType: false,
		processData: false,
		async: false,
		success: function (data) {
			$.notify("Arquivo selecionado com sucesso!", "success");
			$("#hdnArquivo").val("");
			$("#hdnArquivo").val(data.nomeArquivo);
			$("#hdnidArquivo").val("");
			$("#hdnidArquivo").val(data.id_arquivo);
			$("#btnInsere").prop('disabled', false);
			$("#linhasCarregadas").text("Arquivo selecionado com sucesso,click em [Salvar] e aguarde atualização dos dados, 1 minuto aproximadamente!...........");
			$("#linhasCarregadas").css("color", "green");
		},
		error: function (data) {
			$.notify("Falha no cadastro", "warning");
		}
	});
	//    }
	//  });
}

//------------------------------------------------------------------------------
function excluirpp(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/excluirpp',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			//$.notify('Excluido com Sucesso!', "success");
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//-----------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnInsere() {
	$('#spinner').show();
	//------------------ Verificação de campos -----------------------------
	if ($("#fileUploadConfigPontosPassagem").val() == "") {
		$("#fileUploadConfigPontosPassagem").css("borderColor", "red");
		$.notify("O campo [Arquivo] é obrigatório!", "warning");
		return false;
	} else {
		$("#fileUploadConfigPontosPassagem").css("borderColor", "#d2d6de");
	}
	//---------------- Validação de formulario -----------------------------
	var form = new FormData();
	form.append("arquivo", $("#fileUploadConfigPontosPassagem")[0].files[0]);
	var nomeArquivo = $("#hdnArquivo").val();
	var idArquivo = $("#hdnidArquivo").val();

	//----------------------------------------------------------------------
	// bootbox.confirm("Confirmar operação [INSERIR GEORREFERENCIAMENTO]?", function (result) {
	//  if (result === true) {
	$.ajax({
		type: "POST",
		url: base_url + "index_cgop.php/PontoPassagemInsereDadosDaq?nomeArquivo=" + nomeArquivo + "&idArquivo=" + idArquivo,
		dataType: "json",
		data: form,
		dataType: "json",
		contentType: false,
		processData: false,
		async: false,
		success: function (data) {
			if (data == true) {
				$.notify("Dados atualizados com sucesso!", "success");
				$("#linhasCarregadas").text("Dados atualizados com sucesso!");
				$("#linhasCarregadas").css("color", "green");
				$("#btnInsere").prop('disabled', true);
				$("#fileUploadConfigPontosPassagem").val("");
				recuperaPontoPassagem();
			} else {
				$.notify(data.mensagem, data.notify);
				$("#linhasCarregadas").css("color", "red");
				$("#linhasCarregadas").text("É permitido somente planilhas preenchidas e Modelo!");
				$("#btnInsere").prop('disabled', true);
				$("#fileUploadConfigPontosPassagem").val("");
				recuperaPontoPassagem();
			}

		},
		error: function (data) {
			$.notify("Falha no cadastro, verifique se as colunas estão preenchidas!", "warning");
			$("#linhasCarregadas").text("Falha no cadastro");
			$('#spinner').hide();

		}
	});
	//  }
	//  });
}

