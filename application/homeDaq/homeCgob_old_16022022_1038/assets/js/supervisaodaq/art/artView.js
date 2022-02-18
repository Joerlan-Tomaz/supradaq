//##############################################################################
//# DNIT
//# artView.js
//# Desenvolvedor:Jordana alencar
//##############################################################################
//------------------------------------------------------------------------------
$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$("#btnPesquisar").hide();
	$("#datepicker").on("changeDate", function () {
		recuperaART();
	});
	//--------------------------------------------------------------------------
	recuperaART();
	// document.getElementById("datepicker").disabled = true;
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			$("#pesquisaART").hide();
			$("#cadastraART").show();
			$("#incluir").hide();
			$("#btnPesquisar").show();
			$("#btnVoltar").hide();
			//populaUF_art();
			$("#insereConfigART").show();
			$("#editarConfigART").hide();
		}
	});
	//--------------------------------------------------------------------------
	$("#editarConfigART").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			editarConfigART();
		}
	});
	//--------------------------------------------------------------------------
	$("#btnPesquisar").click(function () {
		btnPesquisar();
		$("#btnPesquisar").hide();
		$("#btnVoltar").show();
		$("#insereConfigART").show();
		$("#editarConfigART").hide();
	});
	//--------------------------------------------------------------------------
	$("#insereConfigART").click(function () {
		//------------------ Verificação de campos -----------------------------
		/* var serializedData = validaformulario("formularioConfigART");
		 if (serializedData == false) {
			 $.notify("Preencha os campos obrigatorios!", "warning");
			 return false
		 }*/
		if ($("#config_ART_empresa").val() == "") {
			$.notify("Informe o campo [Empresa Contratada]", "warning");
			return false
		}
		if ($("#config_ART_nome").val() == "") {
			$.notify("Informe o campo [Nome do Profissional]", "warning");
			return false
		}
		if ($("#config_ART_email").val() == "") {
			$.notify("Informe o campo [E-mail]", "warning");
			return false
		}
		var email = $('#config_ART_email').val();
		var a = email.indexOf("@");
		// var b = email.indexOf(".com");
		// var c = email.indexOf(".gov");
		if ((a == -1)) {
			$.notify("Digite campo de [E-mail] valido!", "warning");
			document.getElementById('config_ART_email').style.borderColor = "red";
			return false;
		}
		if ($("#config_ART_telefone").val() == "") {
			$.notify("Informe o campo [Telefone]", "warning");
			return false
		}
		var num = $('#config_ART_telefone').val();
		if (num.trim() !== "") {
			var regra = /^[0-9]+$/;
			if (num.match(regra)) {
			} else {
				$.notify("Digite apenas números [Telefone]!", "warning");
				document.getElementById('config_ART_telefone').style.borderColor = "red";
				return false;
			}
		}
		if ($("#config_ART_CREA").val() == "") {
			$.notify("Informe o campo [CREA Nº]", "warning");
			return false
		}
		if ($("#config_ART_RNP").val() == "") {
			$.notify("Informe o campo [RNP]", "warning");
			return false
		}
		if ($("#config_ART_numero").val() == "") {
			$.notify("Informe o campo [Nº ART]", "warning");
			return false
		}

		if ($("#uf_registro").val() == "" || $("#uf_registro").val() == "Selecione") {
			$.notify("Informe o campo [UF Registro]", "warning");
			return false
		}
		if ($("#config_ART_participacao_tecnica").val() == "" || $("#config_ART_participacao_tecnica").val() == "Selecione") {
			$.notify("Informe o campo [Participação Técnica]", "warning");
			return false
		}
		if ($("#config_ART_forma_registro").val() == "" || $("#config_ART_forma_registro").val() == "Selecione") {
			$.notify("Informe o campo [Forma de Registro]", "warning");
			return false
		}
		if ($("#config_ART_data").val() == "") {
			$.notify("Informe o campo [Data de Registro]", "warning");
			return false
		}
		var data_baixa = $("#config_ART_dataBaixa").val();
		if (data_baixa !== "") {
			var datares = $("#config_ART_data").datepicker("getDate");
			var databx = $("#config_ART_dataBaixa").datepicker("getDate");
			// if (datanew.toString() === "Invalid Date") {
			//     $("#datepicker").datepicker("setDate", new Date());
			// return;
			// }
			var diabx = databx.getDate();
			var mesbx = databx.getMonth() + 1;
			var anobx = databx.getFullYear();
			var diare = datares.getDate();
			var mesre = datares.getMonth() + 1;
			var anore = datares.getFullYear();

			if (databx < datares) {
				$.notify("O Campo [Data Baixa] Deve ser superior a [Data de Registro]!", "warning");
				document.getElementById('config_ART_dataBaixa').style.borderColor = "red";
				return false;
			}
		}
		var serializedData = $("#formularioConfigART").serializeArray();
		fileUploadConfigART = $("#fileUploadConfigART").val();
		if (fileUploadConfigART == "") {
			document.getElementById("fileUploadConfigART").style.borderColor = "red";
			$.notify("Informe o arquivo", "warning");
			return false;
		} else {
			document.getElementById("fileUploadConfigART").style.borderColor = "#d2d6de";
		}
		var form = new FormData();
		form.append("arquivo", $("#fileUploadConfigART")[0].files[0]);
		for (i = 0; i < serializedData.length; i++) {
			form.append(serializedData[i].name, serializedData[i].value);
		}

		if (document.getElementById) {
			var dt = $("#datepicker").datepicker("getDate");
			if (dt.toString() === "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
		}
		form.append("periodo", termo);

		//----------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [INSERIR ART]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgob.php/insereARTdaq",
					data: form,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function (data) {
						$.notify(data.mensagem, data.notify);
						document.formularioConfigART.reset();
						btnPesquisar();
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
		$("#exibesupervisaocont").load("index_cgob.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
	});
});

function btnPesquisar() {
	$("#pesquisaART").show();
	$("#cadastraART").hide();
	$("#editarART").hide();
	$("#incluir").show();
	$("#btnPesquisar").hide();
	$("#btnVoltar").show();

	recuperaART();
}

//------------------------------------------------------------------------------
function artAnexo(nome_arquivo) {
	$.ajax({
		url: 'artAnexo',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/arquivoDaq/arq/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
			artexcluir(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function recuperaART() {
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
	$("#tableART").dataTable({
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
		"sAjaxSource": base_url + "index_cgob.php/recuperaARTDaq?periodo=" + termo,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "N_ART", "sClass": "text-center", "width": "1%"},
			{data: "FORMAREGISTRO", "sClass": "text-center", "width": "10%"},
			{data: "PARTICIPACAOTECNICA", "sClass": "text-center", "width": "10%"},
			{data: "DATAREGISTRO", "sClass": "text-center", "width": "10%"},
			{data: "NOMEPROFISSIONAL", "sClass": "text-center", "width": "10%"},
			{data: "DATABAIXA", "sClass": "text-center", "width": "10%"},
			{data: "ARQUIVO", "sClass": "text-center", "width": "20%"},
			{data: "USUARIO", "sClass": "text-center", "width": "20%"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
			{data: "ACAO", "sClass": "text-center", "width": "5%"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirART(id_art_supervisao, id_arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR ART]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgob.php/excluirARTDaq",
					data: {id_art_supervisao: id_art_supervisao, id_arquivo: id_arquivo},
					dataType: "json",
					success: function (data) {
						$.notify("Excluído com sucesso!", "success");
						var tableART = $("#tableART").DataTable();
						tableART.ajax.reload();
					}, error: function (data) {
						$.notify("Falha na exclusão", "warning");
					}
				});
			}
		});
	}
}

//------------------------------------------------------------------------------
function artexcluir(nome_arquivo) {
	$.ajax({
		url: 'artexcluir',
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
function populaUF_art() {
	$.ajax({
		type: "POST",
		url: base_url + "index_cgob.php/populaUFDaq",
		dataType: "json",
		success: function (data) {
			var servico = $("select[id=uf_registro]");
			servico.html("");
			servico.append("<option value='' selected >Selecione</option>");
			for (i = 0; i < data.id_uf.length; i++) {
				servico.append("<option value='" + data.estado[i] + "'>" + data.estado[i] + "</option>");
			}
		}
	});
}

//------------------------------------------------------------------------------
function populaUF_art_editar() {
	$.ajax({
		type: "POST",
		url: base_url + "index_cgob.php/populaUFDaq",
		dataType: "json",
		success: function (data) {
			var servico = $("select[id=uf_registro_Editar]");
			servico.html("");
			servico.append("<option value='' selected >Selecione</option>");
			for (i = 0; i < data.id_uf.length; i++) {
				servico.append("<option value='" + data.estado[i] + "'>" + data.estado[i] + "</option>");
			}
		}
	});
}

//--------------------------------------------------------------------------------------------------------
function RecuperaEditaART(id_art_supervisao, id_arquivo) {
	bootbox.confirm("Confirmar operação [EDITAR ART]?", function (result) {
		if (result === true) {

			$.ajax({
				type: "POST",
				url: base_url + "index_cgob.php/ArtEditarDaq",
				data: {id_art_supervisao: id_art_supervisao, id_arquivo: id_arquivo},
				dataType: "json",
				success: function (data) {

					//-------------------------------------------------------------------------
					//populaUF_art_editar();
					//-------------------------------------------------------------------------
					$("#editar").val(id_art_supervisao);
					//-------------------------------------------------------------------------
					$("#pesquisaART").hide();
					$("#cadastraART").hide();
					$("#editarART").show();
					$("#incluir").hide();
					$("#btnPesquisar").show();
					$("#btnVoltar").hide();

					//-------------------------------------------------------------------------
					$("#config_ART_empresa_Editar").val(data.empresaContratada);
					$("#config_ART_nome_Editar").val(data.nome_art);
					$("#config_ART_email_Editar").val(data.email);
					$("#config_ART_telefone_Editar").val(data.telefone);
					$("#config_ART_CREA_Editar").val(data.CREA);
					$("#config_ART_RNP_Editar").val(data.RPN);
					$("#config_ART_numero_Editar").val(data.n_ART);
					$("#uf_registro_Editar").val(data.id_uf);
					$("#config_ART_participacao_tecnica_Editar").val(data.ParticipacaoTecnica);
					$("#config_ART_forma_registro_Editar").val(data.formaRegistro);
					$("#config_ART_data_Editar").val(data.dataRegistro);
					$("#config_ART_dataBaixa_Editar").val(data.data_baixa);
					//-------------------------------------------------------------------------
					if (!data.data_baixa) {

						$("#editarConfigART").show();
					} else {
						$.notify("Campo [Data da Baixa] já está preenchido ,não pode ser editado.", "warning");

						$("#editarConfigART").hide();
					}
				}, error: function (data) {
					$.notify("Falha na exclusão", "warning");
				}
			});
		}
	});
}

//--------------------------------------------------------------------------------------------------------
function RecuperaDetalharART(id_art_supervisao, id_arquivo) {
	bootbox.confirm("Confirmar operação [Detalhar ART]?", function (result) {
		if (result === true) {

			$.ajax({
				type: "POST",
				url: base_url + "index_cgob.php/ArtEditarDaq",
				data: {id_art_supervisao: id_art_supervisao, id_arquivo: id_arquivo},
				dataType: "json",
				success: function (data) {

					//-------------------------------------------------------------------------
					//populaUF_art_editar();
					//-------------------------------------------------------------------------
					$("#editar").val(id_art_supervisao);
					//-------------------------------------------------------------------------
					$("#pesquisaART").hide();
					$("#cadastraART").hide();
					$("#editarART").show();
					$("#incluir").hide();
					$("#btnPesquisar").show();
					$("#btnVoltar").hide();

					//-------------------------------------------------------------------------
					$("#config_ART_empresa_Editar").val(data.empresaContratada);
					$("#config_ART_nome_Editar").val(data.nome_art);
					$("#config_ART_email_Editar").val(data.email);
					$("#config_ART_telefone_Editar").val(data.telefone);
					$("#config_ART_CREA_Editar").val(data.CREA);
					$("#config_ART_RNP_Editar").val(data.RPN);
					$("#config_ART_numero_Editar").val(data.n_ART);
					$("#uf_registro_Editar").val(data.id_uf);
					$("#config_ART_participacao_tecnica_Editar").val(data.ParticipacaoTecnica);
					$("#config_ART_forma_registro_Editar").val(data.formaRegistro);
					$("#config_ART_data_Editar").val(data.dataRegistro);
					$("#config_ART_dataBaixa_Editar").val(data.data_baixa);
					//-------------------------------------------------------------------------
					if (!data.data_baixa) {

						$("#editarConfigART").hide();
					} else {
						$.notify("Campo [Data da Baixa] já está preenchido ,não pode ser editado.", "warning");

						$("#editarConfigART").hide();
					}
				}, error: function (data) {
					$.notify("Falha na exclusão", "warning");
				}
			});
		}
	});
}

//--------------------------------------------------------------------------------------------------------
function RecuperaDarBaixaART(id_art_supervisao, id_arquivo) {
	bootbox.confirm("Confirmar operação [Dar Baixa  ART]?", function (result) {
		if (result === true) {

			$.ajax({
				type: "POST",
				url: base_url + "index_cgob.php/ArtEditarDaq",
				data: {id_art_supervisao: id_art_supervisao, id_arquivo: id_arquivo},
				dataType: "json",
				success: function (data) {

					//-------------------------------------------------------------------------
					//populaUF_art_editar();
					//-------------------------------------------------------------------------
					$("#editar").val(id_art_supervisao);
					//-------------------------------------------------------------------------
					$("#pesquisaART").hide();
					$("#cadastraART").hide();
					$("#editarART").show();
					$("#incluir").hide();
					$("#btnPesquisar").show();
					$("#btnVoltar").hide();

					//-------------------------------------------------------------------------
					$("#config_ART_empresa_Editar").val(data.empresaContratada);
					$("#config_ART_nome_Editar").val(data.nome_art);
					$("#config_ART_email_Editar").val(data.email);
					$("#config_ART_telefone_Editar").val(data.telefone);
					$("#config_ART_CREA_Editar").val(data.CREA);
					$("#config_ART_RNP_Editar").val(data.RPN);
					$("#config_ART_numero_Editar").val(data.n_ART);
					$("#uf_registro_Editar").val(data.id_uf);
					$("#config_ART_participacao_tecnica_Editar").val(data.ParticipacaoTecnica);
					$("#config_ART_forma_registro_Editar").val(data.formaRegistro);
					$("#config_ART_data_Editar").val(data.dataRegistro);
					$("#config_ART_dataBaixa_Editar").val(data.data_baixa);
					//-------------------------------------------------------------------------
					if (!data.data_baixa) {

						$("#editarConfigART").show();
					} else {
						$.notify("Campo [Data da Baixa] já está preenchido ,não pode ser editado.", "warning");

						$("#editarConfigART").hide();
					}
				}, error: function (data) {
					$.notify("Falha na exclusão", "warning");
				}
			});
		}
	});
}


//----------------------------------------------------------------------------------------------------------------
function editarConfigART() {
	var id_art_supervisao = $("#editar").val();
	if ($("#config_ART_empresa_Editar").val() == "") {
		$.notify("Informe o campo [Empresa Contratada]", "warning");
		return false
	}
	if ($("#config_ART_nome_Editar").val() == "") {
		$.notify("Informe o campo [Nome do Profissional]", "warning");
		return false
	}
	if ($("#config_ART_email_Editar").val() == "") {
		$.notify("Informe o campo [E-mail]", "warning");
		return false
	}
	if ($("#config_ART_telefone_Editar").val() == "") {
		$.notify("Informe o campo [Telefone]", "warning");
		return false
	}
	if ($("#config_ART_CREA_Editar").val() == "") {
		$.notify("Informe o campo [CREA Nº]", "warning");
		return false
	}
	if ($("#config_ART_RNP_Editar").val() == "") {
		$.notify("Informe o campo [RNP]", "warning");
		return false
	}
	if ($("#config_ART_numero_Editar").val() == "") {
		$.notify("Informe o campo [Nº ART]", "warning");
		return false
	}
	if ($("#uf_registro_Editar").val() == "" || $("#uf_registro_Editar").val() == "Selecione") {
		$.notify("Informe o campo [UF Registro]", "warning");
		return false
	}
	if ($("#config_ART_participacao_tecnica_Editar").val() == "" || $("#config_ART_participacao_tecnica_Editar").val() == "Selecione") {
		$.notify("Informe o campo [Participação Técnica]", "warning");
		return false
	}
	if ($("#config_ART_forma_registro_Editar").val() == "" || $("#config_ART_forma_registro_Editar").val() == "Selecione") {
		$.notify("Informe o campo [Forma de Registro]", "warning");
		return false
	}
	if ($("#config_ART_data_Editar").val() == "") {
		$.notify("Informe o campo [Data de Registro]", "warning");
		return false
	}
	var email = $('#config_ART_email_Editar').val();
	var a = email.indexOf("@");
	// var b = email.indexOf(".com");
	// var c = email.indexOf(".gov");
	if ((a == -1)) {
		$.notify("Digite campo de [E-mail] valido!", "warning");
		document.getElementById('config_ART_email_Editar').style.borderColor = "red";
		return false;
	}
	var num = $('#config_ART_telefone_Editar').val();
	if (num.trim() !== "") {
		var regra = /^[0-9]+$/;
		if (num.match(regra)) {
		} else {
			$.notify("Digite apenas números [Telefone]!", "warning");
			document.getElementById('config_ART_telefone_Editar').style.borderColor = "red";
			return false;
		}
	}
	var data_baixa = $("#config_ART_dataBaixa_Editar").val();
	if (data_baixa !== "") {
		var datares = $("#config_ART_data_Editar").datepicker("getDate");
		var databx = $("#config_ART_dataBaixa_Editar").datepicker("getDate");
		// if (datanew.toString() === "Invalid Date") {
		//     $("#datepicker").datepicker("setDate", new Date());
		// return;
		// }
		var diabx = databx.getDate();
		var mesbx = databx.getMonth() + 1;
		var anobx = databx.getFullYear();
		var diare = datares.getDate();
		var mesre = datares.getMonth() + 1;
		var anore = datares.getFullYear();

		if (databx < datares) {
			$.notify("O Campo [Data Baixa] Deve ser superior a [Data de Registro]!", "warning");
			document.getElementById('config_ART_dataBaixa_Editar').style.borderColor = "red";
			return false;
		}
	}
	var serializedData = $("#formularioConfigARTEditar").serializeArray();
	var form = new FormData();
	for (i = 0; i < serializedData.length; i++) {
		form.append(serializedData[i].name, serializedData[i].value);
	}

	//----------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [EDITAR ART]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgob.php/EditarArtDaq?id_art_supervisao=" + id_art_supervisao,
				data: form,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (data) {
					$.notify("Editado com sucesso!", "success");
					document.formularioConfigARTEditar.reset();
					btnPesquisar();
				}, error: function (data) {
					$.notify("Falha na edição", "warning");

				}
			});
		}
	});

}
