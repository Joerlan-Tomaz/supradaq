//######################################################################################################################################################################################## 
//# DNIT
//# AtividadesExecutoraView.js
//# Desenvolvedor:Jordana Alencar
//# Data: 10/10/2019 13:00
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
	//-------------------------------------------------------
	$.ajaxSetup({cache: false});
	//-------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	//-------------------------------------------------------
	$('#novo_AtividadesExecutora').hide();
	$('#cadastroAtividadesExecutora').hide();
	$('#searchdate').hide();
	//--------------------------------------------------------------------------
	$('#datepicker').on("changeDate", function () {
		$.ajaxSetup({cache: false});
		recuperaAtividadeExecutora();
	});
	//-------------------------------------------------------
	recuperaAtividadeExecutora();
	document.getElementById("btnInclusao").disabled = false;
	//-------------------------------------------------------
	$("#searchdate").click(function () {
		recuperaAtividadeExecutora();
		// confereNaoAtividade();
		$('#searchdate').hide();
		$('#btnInclusao').show();
		$('#btnNoAtividade').show();
	});
	//--------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			$('#novo_AtividadesExecutora').hide();
			$('#cadastroAtividadesExecutora').show();
			document.getElementById("datepicker").disabled = true;
			$('#searchdate').show();
			$('#btnInclusao').hide();
			$('#btnNoAtividade').hide();
		}
	});

	//--------------------------------------------------------------------
	$("#insereAtividade").click(function () {
		fileUpload = $("#fileUpload").val();
		if (fileUpload == "") {
			if (fileUpload === '') {
				document.getElementById('fileUpload').style.borderColor = 'red';
			} else {
				document.getElementById('fileUpload').style.borderColor = '#d2d6de';
			}
			$.notify("Insira o anexo de Diario de obra", 'warning');
			return false;
		}
		document.getElementById('fileUpload').style.borderColor = '#d2d6de';
		bootbox.confirm("Confirmar operação [INSERIR DOCUMENTO]?", function (result) {
			if (result === true) {
				if (document.getElementById) {
					var dt = $("#datepicker").datepicker('getDate');
					if (dt.toString() == "Invalid Date") {
						$("#datepicker").datepicker("setDate", new Date());
						return;
					}
					var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
				}
				var tipo_atividade = $('#tipo_atividade').val();
				var form = new FormData();
				form.append('arquivo', $('#fileUpload')[0].files[0]);
				form.append('periodo', termo);
				form.append('tipo_atividade', tipo_atividade);
				var serializedData = $("#formularioEnsaioLaboratorio").serializeArray();
				for (i = 0; i < serializedData.length; i++) {
					form.append(serializedData[i].name, serializedData[i].value);
				}
				$.ajax({
					url: base_url + 'index_cgob.php/AtividadeExecutoraInsereDaq',
					type: "POST",
					data: form,
					dataType: 'json',
					contentType: false,
					processData: false,
					success: function (data) {
						$.notify(data.mensagem, data.notify);
						$("#fileUpload").val("");
						$('#cadastroAtividadesExecutora').hide();
						$('#novo_AtividadesExecutora').show();
						var tableAtividadesExecutora = $("#tableAtividadesExecutora").DataTable();
						tableAtividadesExecutora.ajax.reload();
						document.getElementById("datepicker").disabled = false;
						// confereNaoAtividade();
					}, error: function (data) {
						$.notify('Erro no Envio', "warning");
					}
				});
			}
		});
	});
});

//--------------------------------------------------------------------
function recuperaAtividadeExecutora() {
	document.getElementById("datepicker").disabled = false;
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var tipo_atividade = $('#tipo_atividade').val();
	$('#novo_AtividadesExecutora').show();
	$('#cadastroAtividadesExecutora').hide();
	$('#tableAtividadesExecutora').dataTable({
		"bProcessing": false,
		"bFilter": false,
		"bInfo": false,
		"bLengthChange": false,
		"bPaginate": false,
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
		"sAjaxSource": base_url + "index_cgob.php/AtividadeExecutoraRecuperaDaq",
		"fnServerParams": function (aoData) {
			aoData.push(
				{"name": "periodo", "value": termo},
				{"name": "tipo_atividade", "value": tipo_atividade}
			);
		},
		"aoColumns": [
			{data: 'ARQUIVO', "width": "40%"},
			{data: 'NOME', "sClass": "text-center", "width": "20%"},
			{data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "20%"},
			{data: 'ACAO', "sClass": "text-center", "width": "5%"}
		]
	});
	// confereNaoAtividade();
}

//--------------------------------------------------------------------
function excluirArquivo(id_arquivo) {
	bootbox.confirm("Confirmar operação [EXCLUIR ARQUIVO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgob.php/AtividadeExecutoraExcluirDaq',
				data: {id_arquivo: id_arquivo},
				dataType: 'json',
				success: function (data) {
					$.notify('Excluido com sucesso!', "success");
					var tableAtividadesExecutora = $("#tableAtividadesExecutora").DataTable();
					tableAtividadesExecutora.ajax.reload();
					// confereNaoAtividade();
				}, error: function (data) {
					$.notify('Falha no cadastro', "warning");
				}
			});
		}
	});
}

//-----------------------------------------------
function baixarModelo(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgob.php/baixarModelo',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/arquivoDaq/arq/' + nome_arquivo;
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
