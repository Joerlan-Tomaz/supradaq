//##############################################################################
//# DNIT
//# portariasfiscaisView.js
//# Desenvolvedora:Jordana de Alencar.
//# Data:26/11/19 14:48:00
//##############################################################################
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$("#datepicker").on("changeDate", function () {
		recuperaPortariasFiscais();
	});
	//--------------------------------------------------------------------------
	recuperaPortariasFiscais();
	// document.getElementById("datepicker").disabled = true;

	//-----------------------------------------------VALIDAÇAO DAQ---------------------------
	$("#inserePortariaFiscal").click(function () {
		var serializedData = validaformulario("formularioPortariaFiscal");
		var arquivo = $("#fileUpload").val();
		if (serializedData == false || arquivo == "") {
			if (arquivo == "") {
				document.getElementById("fileUpload").style.borderColor = "red";
			} else {
				document.getElementById("fileUpload").style.borderColor = "#d2d6de";
			}
			$.notify("Preencha todos os campos!", "warning");
			return false;
		}
		var num = $('#telefone').val();
		if (num.trim() !== "") {
			var regra = /^[0-9]+$/;
			if (num.match(regra)) {
			} else {
				$.notify("Permitido Somente Números [Telefone]!", "warning");
				document.getElementById('telefone').style.borderColor = "red";
				return false;
			}
		}
		var num = $('#n_portaria').val();
		// if (num.trim() !== "") {
		// 	var regra = /^[0-9]+$/;
		// 	if (num.match(regra)) {
		// 	} else {
		// 		$.notify("Permitido Somente Números [Portaria]!", "warning");
		// 		document.getElementById('n_portaria').style.borderColor = "red";
		// 		return false;
		// 	}
		// }
		var nome = $('#nome').val();
		var regra = /^[0-9]+$/;
		if ((nome.match(regra))) {
			$.notify("Digite o [Nome] Completo (Texto)!", "warning");
			document.getElementById('nome').style.borderColor = "red";
			return false;
		}

		var email = $('#email').val();
		var a = email.indexOf("@");
		//var b = email.indexOf(".com");
		if ((a == -1)) {
			$.notify("Digite Um Campo de [E-mail] Valido!", "warning");
			document.getElementById('email').style.borderColor = "red";
			return false;
		}

		var datanew = $("#data_portaria").datepicker("getDate");
		if (datanew.toString() === "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var diapor = datanew.getDate();
		var mespor = datanew.getMonth() + 1;
		var anopor = datanew.getFullYear();

		var d = new Date(anopor + ',' + mespor + ',' + diapor);
		if (d > new Date()) {
			$.notify("O Campo [Data Portaria] Não deve ser superior a [Data Atual]!", "warning");
			document.getElementById('data_portaria').style.borderColor = "red";
			return false;
		}
		document.getElementById("fileUpload").style.borderColor = "#d2d6de";
		//----------------------------------------------------------------------
		if (document.getElementById) {
			var dt = $("#datepicker").datepicker("getDate");
			if (dt.toString() === "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
		}
		//---------------- Validação de formulario -----------------------------
		var form = new FormData();
		form.append("arquivo", $("#fileUpload")[0].files[0]);
		form.append("periodo", termo);
		for (i = 0; i < serializedData.length; i++) {
			form.append(serializedData[i].name, serializedData[i].value);
		}
		//----------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [INSERIR PORTARIAS DE FISCAIS]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/PortariasFiscaisInsereDaq",
					data: form,
					dataType: "json",
					contentType: false,
					processData: false,
					success: function (data) {
						$.notify(data.mensagem, data.notify);
						document.formularioPortariaFiscal.reset();
						btnPesquisar();
					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");
					}
				});
			}
		});
	});
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			$("#nova_portariafiscal").hide();
			$("#cadastro_portariafiscal").show();
			$("#incluir").hide();
			$("#search").show();
			populaUF();
			// $("#btnVoltar").hide();
			$("#btnVoltar").show();
		}
	});
	//--------------------------------------------------------------------------
	$("#btnPesquisar").click(function () {
		btnPesquisar();
		$("#btnVoltar").show();
	});
	//--------------------------------------------------------------------------
	$("#btnVoltar").click(function () {
		// document.getElementById("datepicker").disabled = false;
		$("#exibesupervisaocont").empty();
		$("#exibesupervisaocont").load(base_url + "index_cgop.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
	});
	//-------------------------------------------------------------------------
	populaTitularidade();
});

//------------------------------------------------------------------------------
function btnPesquisar() {
	$("#nova_portariafiscal").show();
	$("#cadastro_portariafiscal").hide();
	$("#incluir").show();
	$("#search").hide();
	recuperaPortariasFiscais();
}

function validaEmail(field) {
	usuario = field.value.substring(0, field.value.indexOF("@"));
	dominio = field.value.substring(field.value.indexOF("@") + 1, field.value.length);
	if ((usuario.length >= 1) && (dominio.length >= 3) && (usuario.search("@") == -1) && (dominio.search("@") == -1) &&
		(usuario.search(" ") == -1) && (dominio.search(" ") == -1) && (dominio.search(".") != -1) && (dominio.indexOF(".") >= -1) &&
		(dominio.lastIndexOf(".") < dominio.length - 1)) {
		document.getElementById("email").innerHTML = "E-mail valido";
		alert("Email valido");
	} else {
		document.getElementById("email").innerHTML = "<font color='red'>Email invalido</font>";
		alert("E-mail invalido");
	}

}

function anexoPortarias(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/anexoPortarias',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/arquivoDaq/arq/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
			excluirPortaria(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function recuperaPortariasFiscais() {
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
	$("#tablePortariaFiscal").dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/PortariasFiscaisRecuperaDaq?periodo=" + termo,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "nomeFiscal"},
			{data: "email", "sClass": "text-center"},
			{data: "telefone", "sClass": "text-center"},
			{data: "titularidade", "sClass": "text-center"},
			{data: "contrato", "sClass": "text-center"},
			{data: "data_portaria", "sClass": "text-center"},
			{data: "arquivo", "sClass": "text-center"},
			{data: "acao", "sClass": "text-center"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirPortariasFiscais(id_portaria_fiscal, id_arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR PORTARIAS DE FISCAIS]?", function (result) {
			if (result === true) {
				$.ajax({
					type: "POST",
					url: base_url + "index_cgop.php/PortariasFiscaisExcluiDaq",
					data: {id_portaria_fiscal: id_portaria_fiscal, id_arquivo: id_arquivo},
					dataType: "json",
					success: function (data) {
						$.notify("Excluído com sucesso!", "success");
						var table = $("#tablePortariaFiscal").DataTable();
						table.ajax.reload();
					}, error: function (data) {
						$.notify("Falha no cadastro", "warning");
					}
				});
			}
		});
	}
}

//------------------------------------------------------------------------------
function populaUF() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/PortariasFiscaisUfDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=unidade_local]');
			servico.html('');
			servico.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.id_uf.length; i++) {
				servico.append('<option value="' + data.id_uf[i] + '">' + data.estado[i] + '</option>');
			}
		}
	});
}

//------------------------------------------------------------------------------
function populaTitularidade() {
	$.ajax({
		type: 'POST',
		url: base_url + "index_cgop.php/PortariasFiscaisTitularidadeDaq",
		dataType: 'json',
		success: function (data) {
			var titularidade = $('select[id=titularidade]');
			titularidade.html('');
			titularidade.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.id_titularidade.length; i++) {
				titularidade.append('<option value="' + data.id_titularidade[i] + '">' + data.titularidade[i] + '</option>');
			}
		}
	});
}

//------------------------------------------------------------------------------
function excluirPortaria(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/excluirPortaria',
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
