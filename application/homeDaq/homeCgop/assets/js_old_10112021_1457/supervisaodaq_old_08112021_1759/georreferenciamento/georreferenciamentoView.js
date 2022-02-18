//##############################################################################
//# DNIT
//# Desenvolvedor:Jordana Alencar
//# Data:09/10/2020
//##############################################################################
//------------------------------------------------------------------------------
$().ready(function () {
	var dadosTabela = {};
	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});

	//--------------------------------------------------------------------------
	$("#btnInsere").prop('disabled', true);
	//--------------------------------------------------------------------------
	recuperaGeorreferenciamento();
	populaHidrovia();
	//---------------------------------------------------------------------------
	$("#fileUploadConfigGeorreferenciamento").change(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			fileUploadConfigGeorreferenciamento();
		}
	});
	//---------------------------------------------------------------------------
	//---------------------------------------------------------------------------
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
		$("#exibesupervisaocont").empty();
		$("#exibesupervisaocont").load(base_url + "index_cgop.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
	});
});

//------------------------------------------------------------------------------
function recuperaGeorreferenciamento() {

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
	$("#tableGeorreferenciamento").dataTable({
		"bProcessing": false,
		"pageLength": 10,
		"destroy": true,
		// "scrollY": "300px",
		"scrollX": true,
		"scrollCollapse": true,
		"columnDefs": [
			{width: '20%', targets: 0}
		],
		"fixedColumns": true,
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
		"sAjaxSource": base_url + "index_cgop.php/GeorreferenciamentoRetornoDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "ARQUIVO", "sClass": "text-center", "width": "5%"},
			{data: "TOTAL", "sClass": "text-center", "width": "25%"},
			{data: "DETALHES", "sClass": "text-center", "width": "5%"},
			{data: "NOME", "sClass": "text-center", "width": "20%"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
			{data: "ACAO", "sClass": "text-center", "width": "5%"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirGeorreferenciamento(id_arquivo, arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR REGISTROS DE GEORREFERENCIAMENTO DO ARQUIVO  '" + arquivo + "']?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/GeorreferenciamentoExcluirDaq",
					data: {id_arquivo: id_arquivo},
					dataType: "json",
					success: function (data) {
						$.notify("Excluido com sucesso!", "success");
						var table = $("#tableGeorreferenciamento").DataTable();
						table.ajax.reload();
					}, error: function (data) {
						$.notify("Falha na exclusão", "warning");
					}
				});
			}
		});
	}
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
function detalhesGeorreferenciamento(id_arquivo) {
	$("#detalhesGeorreferenciamento").modal("show");
	$("#tableDetalhesGeorreferenciamento").dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/GeorreferenciamentoDetalhesDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "id_arquivo", "value": id_arquivo});
		},
		"aoColumns": [
			{data: "APELIDO", "sClass": "text-center"},
			{data: "EIXO", "sClass": "text-center"},
			{data: "KM", "sClass": "text-center"},
			{data: "ESTACA", "sClass": "text-center"},
			{data: "COORDENADAS", "sClass": "text-center"},
			{data: "LADO", "sClass": "text-center"},
			{data: "USUARIO", "sClass": "text-center"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center"}
		]
	});
}

//------------------ Verificação -----------------------------
function anexoGeo(nome_arquivo) {
	$.ajax({
		url: 'anexoGeo',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/application/homeDaq/arquivoDaq/arq/' + nome_arquivo;
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


//-----------------------------------------------
function ModeloGeo(nome_arquivo) {
    $.ajax({
        type: "POST",
        url: base_url + "index_cgop.php/GeorreferenciamentoModelo?arq="+nome_arquivo,
        data: {nome_arquivo: nome_arquivo},
        dataType: "json",
        success: function (data) {
            $.notify("Download com sucesso!", "success");
        }, error: function (data) {
            $.notify("Falha no download", "warning");
        }
    });
}
function ModeloGeo_old_12102021_0958(nome_arquivo) {
//    $.ajax({
//        url: 'ModeloGeoDif',
//        type: 'POST',
//        data: {nome_arquivo: nome_arquivo},
//        success: function (data) {
            var arquivo = base_url + 'application/homeDaq/arquivoDaq/arq/?arq='+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download realizado com sucesso!', "success");
//            excluirGeoDif(nome_arquivo);
//        }, error: function (data) {
//            $.notify('Falha no download!', "warning");
//        }
//    });
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function fileUploadConfigGeorreferenciamento() {
	$("#btnInsere").prop('disabled', true);
	//------------------ Verificação de campos -----------------------------
	if ($("#nome_apelido").val() == "") {
		$("#nome_apelido").css("borderColor", "red");
		$.notify("O campo [Nome/Apelido] é obrigatório!", "warning");
		$("#fileUploadConfigGeorreferenciamento").val("");
		return false;
	} else {
		$("#nome_apelido").css("borderColor", "#d2d6de");
		var nome_apelido = $("#nome_apelido").val();
		//---------------------------------------------------------------------------------------------------------------------------------
		//validando noe do eixo e eixo se ja existe
		$.ajax({
			type: "POST",
			url: base_url + "index_cgop.php/GeorreferenciamentoNomeEixoDaq?nome_apelido=" + nome_apelido,
			dataType: "json",
			dataType: "json",
			contentType: false,
			processData: false,
			async: false,
			success: function (data) {
				if (data.resultado == true) {
					$("#linhasCarregadas").text("[ Nome/Apelido ] já existe na base de dados!");
					$("#linhasCarregadas").css("color", "red");
					return false;
				} else {
					$("#linhasCarregadas").text("[ Nome/Apelido ] validado com sucesso!");
					$("#linhasCarregadas").css("color", "green");
					return true;
				}
			},
			error: function (data) {
				$.notify("Falha no cadastro", "warning");
				return false;

			}
		});
	}
	//--------------------------------------------------------------------------------------------------------------------------------------
	if ($("#eixo").val() == "") {
		$("#eixo").css("borderColor", "red");
		$.notify("O campo [Eixo] é obrigatório!", "warning");
		$("#fileUploadConfigGeorreferenciamento").val("");
		return false;
	} else {
		$("#eixo").css("borderColor", "#d2d6de");
	}
	//-----------------------------------------------------------------------------------------------------------
	if ($("#fileUploadConfigGeorreferenciamento").val() == "") {
		$("#fileUploadConfigGeorreferenciamento").css("borderColor", "red");
		$.notify("Preencha os campos obrigatórios", "warning");
		return false;
	} else {
		$("#fileUploadConfigGeorreferenciamento").css("borderColor", "#d2d6de");
	}

	//-------------------------------------------------------------------------
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
	form.append("arquivo", $("#fileUploadConfigGeorreferenciamento")[0].files[0]);
	form.append('periodo', termo);
	//----------------------------------------------------------------------
	//  bootbox.confirm("Confirmar operação [INSERIR GEORREFERENCIAMENTO]?", function (result) {
	//  if (result === true) {
	$.ajax({
		type: "POST",
		url: base_url + "index_cgop.php/GeorreferenciamentoinsereDaq",
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
			$("#linhasCarregadas").text("Arquivo selecionado com sucesso,click em [ Salvar ] e aguarde atualização dos dados, 1 minuto aproximadamente!...........");
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
function excluirGeo(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/excluirGeo',
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
//------------------------------------------------------------------------------
function populaHidrovia() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/GeorreferenciamentoHidroviaDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $("select[id=eixo]");
			servico.html('');
			servico.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.id_eixo.length; i++) {
				servico.append('<option value="' + data.id_eixo[i] + '">' + data.eixo[i] + '</option>');
			}
		}
	});
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnInsere() {
	populaHidrovia();
	//------------------ Verificação de campos -----------------------------
	if ($("#eixo").val() == "") {
		$("#eixo").css("borderColor", "red");
		$.notify("O campo [Eixo] é obrigatório!", "warning");
		$("#fileUploadConfigGeorreferenciamento").val("");
		return false;
	} else {
		$("#eixo").css("borderColor", "#d2d6de");
	}

	if ($("#nome_apelido").val() == "") {
		$("#nome_apelido").css("borderColor", "red");
		$.notify("O campo [Nome/Apelido] é obrigatório!", "warning");
		$("#fileUploadConfigGeorreferenciamento").val("");
		return false;
	} else {
		$("#nome_apelido").css("borderColor", "#d2d6de");
	}


	if ($("#fileUploadConfigGeorreferenciamento").val() == "") {
		$("#fileUploadConfigGeorreferenciamento").css("borderColor", "red");
		$.notify("O campo [Arquivo] é obrigatório!", "warning");
		return false;
	} else {
		$("#fileUploadConfigGeorreferenciamento").css("borderColor", "#d2d6de");
	}
	//---------------- Validação de formulario -----------------------------
	var form = new FormData();
	form.append("arquivo", $("#fileUploadConfigGeorreferenciamento")[0].files[0]);
	var nomeArquivo = $("#hdnArquivo").val();
	var idArquivo = $("#hdnidArquivo").val();
	var eixo = $("#eixo").val();
	var nome_apelido = $("#nome_apelido").val();
	//----------------------------------------------------------------------
	// bootbox.confirm("Confirmar operação [INSERIR GEORREFERENCIAMENTO]?", function (result) {
	//  if (result === true) {
	$.ajax({
		type: "POST",
		url: base_url + "index_cgop.php/GeorreferenciamentoDadosDaq?nomeArquivo=" + nomeArquivo + "&idArquivo=" + idArquivo + "&eixo=" + eixo + "&nome_apelido=" + nome_apelido,
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
				$("#fileUploadConfigGeorreferenciamento").val("");
				$("#nome_apelido").val("");
				$("#eixo").val("");
				recuperaGeorreferenciamento();

			} else {
				$.notify(data.mensagem, data.notify);
				$("#linhasCarregadas").css("color", "red");
				$("#linhasCarregadas").text("É permitido somente planilhas preenchidas e Modelo!");
				$("#btnInsere").prop('disabled', true);
				$("#fileUploadConfigGeorreferenciamento").val("");
				$("#nome_apelido").val("");
				$("#eixo").val("");
				recuperaGeorreferenciamento();
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

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

