//######################################################################################################################################################################################## 
//# DNIT
//# atascorrespondenciasView.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 10/10/2019 13:00
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$("#searchdate").hide();
	//--------------------------------------------------------------------------
	CKEDITOR.replace('status_detalhado', {
		//removePlugins: 'toolbar, elementspath, resize',
		height: 200
	});
	//--------------------------------------------------------------------------
	$('#nova_atascorrespondencias').hide();
	$('#cadastroAtasCorrespondencias').hide();
	//--------------------------------------------------------------------------
	$('#datepicker').on("changeDate", function () {
		recuperaAtaCorrespondencia();
	});
	//--------------------------------------------------------------------------
	recuperaAtaCorrespondencia();
	//--------------------------------------------------------------------------
	$("#searchdate").click(function () {
		recuperaAtaCorrespondencia();
		document.getElementById("datepicker").disabled = false;
		$("#btnInclusao").show();
		$('#btnNoAtividade').show();
		$("#searchdate").hide();
	});
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			$('#nova_atascorrespondencias').hide();
			$('#btnNoAtividade').hide();
			$('#cadastroAtasCorrespondencias').show();
			document.getElementById("datepicker").disabled = true;
			$("#btnInclusao").hide();
			$("#searchdate").show();
		}
	});
	//--------------------------------------------------------------------------
	$("#insereAtasCorrespondencias").click(function () {
		//------------------ Verificação de campos -----------------------------
		var serializedData = validaformulario("formularioAtasCorrespondencias");
		var fileUpload = $("#fileUpload").val();
		if (serializedData == false || fileUpload == "") {
			if (fileUpload == "") {
				document.getElementById("fileUpload").style.borderColor = "red";
			} else {
				document.getElementById("fileUpload").style.borderColor = "#d2d6de";
			}
			$.notify('Preencha os campos obrigatórios', "warning");
			return false;
		}

		//----------------------------------------------------------------------------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [INSERIR ATAS E CORRESPONDÊNCIAS]?", function (result) {
			//---------------- Validação de formulario -----------------------------
			var form = new FormData();
			form.append('arquivo', $('#fileUpload')[0].files[0]);
			for (i = 0; i < serializedData.length; i++) {
				form.append(serializedData[i].name, serializedData[i].value);
			}
			document.getElementById('fileUpload').style.borderColor = '#d2d6de';
			//----------------------------------------------------------------------
			if (document.getElementById) {
				var dt = $("#datepicker").datepicker('getDate');
				if (dt.toString() === "Invalid Date") {
					$("#datepicker").datepicker("setDate", new Date());
					return;
				}
				var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
			}
			//---------------- Validação de formulario -----------------------------
			form.append('arquivo', $('#fileUpload')[0].files[0]);
			form.append('periodo', termo);
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/AtasCorrespondenciaInseredaq',
					data: form,
					dataType: 'json',
					contentType: false,
					processData: false,
					cache: false,
					success: function (data) {
						document.getElementById("datepicker").disabled = false;
						$('#cadastroAtasCorrespondencias').hide();
						$('#nova_atascorrespondencias').show();
						$.notify(data.mensagem, data.notify);
						var tableAtasCorrespondencias = $("#tableAtasCorrespondencias").DataTable();
						tableAtasCorrespondencias.ajax.reload();
						CKEDITOR.instances['status_detalhado'].setData("");
						document.formularioAtasCorrespondencias.reset();
						$("#btnInclusao").show();
						$("#searchdate").hide();
						$("#btnNoAtividade").show();
						$("#btnNoAtividade").attr("disabled", true);
						table_naohouveatividademes();
					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");
					}
				});
			}
		});
	});

	$("#btnNoAtividade").click(function () {
		btnNoAtividade();
	});
});

//------------------------------------------------------------------------------
function AtasAnexo(nome_arquivo) {
	$.ajax({
		url: 'AtasAnexo',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/arquivoDaq/arq/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
			excluirAtas(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//--------------------------------------------------------------------
function recuperaAtaCorrespondencia() {
	table_naohouveatividademes();
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$('#nova_atascorrespondencias').show();
	$('#cadastroAtasCorrespondencias').hide();
	$('#tableAtasCorrespondencias').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/retornaAtasCorrespondenciasDaq?periodo=" + termo,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: 'TIPO_DOCUMENTO', "sClass": "text-justify", "width": "10%"},
			{data: 'DOCUMENTO', "sClass": "text-center", "width": "10%"},
			{data: 'RESUMO', "sClass": "text-justify", "width": "50%"},
			{data: 'ARQUIVO', "width": "25%"},
			{data: 'NOME', "sClass": "text-center", "width": "10%"},
			{data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "10%"},
			{data: 'ACAO', "sClass": "text-center", "width": "5%"}
		]
	});
}

//--------------------------------------------------------------------
function excluirArquivo(id_atas_correspondencias, id_arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url:  base_url + 'index_cgop.php/AtasExcluirDaq',
					data: {id_atas_correspondencias: id_atas_correspondencias, id_arquivo: id_arquivo},
					dataType: 'json',
					success: function (data) {
						table_naohouveatividademes();
						$.notify('Excluido com sucesso!', "success");
						var tableAtasCorrespondencias = $("#tableAtasCorrespondencias").DataTable();
						tableAtasCorrespondencias.ajax.reload();
					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");
					}
				});
			}
		});
	}
}

function excluirAtas(nome_arquivo) {
	$.ajax({
		url: 'excluirAtas',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			//$.notify('Excluido com Sucesso!', "success");
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function table_naohouveatividademes() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/AtasNaoAtividadeDaq',
		data: {periodo: termo},
		dataType: 'json',
		success: function (data) {
			if (data.atas == true) {
				$("#btnNoAtividade").attr("disabled", true);
				$("#btnInclusao").attr("disabled", true);
				$('#searchdate').hide();
				$('#nova_atascorrespondencias').hide();
				$('#cadastroAtasCorrespondencias').hide();
				$('#naohouveatividademes').show();

				var table = $('#tableNaohouveAtividadeMes').DataTable();
				table.destroy();
				$('#tableNaohouveAtividadeMes').dataTable({
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
					"sAjaxSource": base_url + "index_cgop.php/AtasNaoAtividadeDaq?periodo="+termo,
					"aoColumns": [
						{data: 'atividademes'},
						{data: 'usuario'},
						{data: 'ultima_alteracao'},
						{data: 'acoes'}

					]
				});
			} else {
				$("#naohouveatividademes").hide();
				$("#btnNoAtividade").show;
				$("#btnNoAtividade").attr("disabled", false);
				if(data.possuiAtas == true){
					$("#btnNoAtividade").attr("disabled", true);
				}
				$("#btnInclusao").attr("disabled", false);
				$('#nova_atascorrespondencias').show();
				$('#cadastroAtasCorrespondencias').hide();
				$('#naohouveatividademes').hide();
			}
		}
	});
}

function btnNoAtividade() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

	}
	//----------------------------------------------------------------------------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADE NO MÊS]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AtasInsereNaoAtividadeDaq',
				data: {
					periodo: termo
				},
				dataType: 'json',
				success: function (data) {
					$.notify('Cadastrado com sucesso!', "success");
					table_naohouveatividademes();

				}, error: function (data) {
					$.notify('Falha no cadastro', "warning");

				}
			});
		}
	});
}

function excluirNaoAtividade(id) {
	bootbox.confirm("Confirmar operação [EXCLUIR]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/AtasExcluirNaoAtividadeDaq?id=' + id,
				dataType: 'json',
				success: function (data) {
					table_naohouveatividademes();
					$.notify('[EXCLUIR] efetuado com  sucesso!', "success");
				}, error: function (data) {
					$.notify('Falha na operação', "warning");

				}
			});
		}
	});
}

//-----------------------------------------------------------------------------
