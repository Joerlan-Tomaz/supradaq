//------------------------------------------------------------------------------
$(document).ready(function () {
	$('#table_altera_usuario').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/painelAdmRecuperaInfoUsuario",
		"aoColumns": [
			{data: 'nome', "sClass": "text-center"},
			{data: 'email', "sClass": "text-center"},
			{data: 'perfil', "sClass": "text-center"},
			{data: 'supervisora', "sClass": "text-center"},
			{data: 'empresa', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"},
		]
	});

	$('#supervisora_atualizaPerfil').change(function () {
		tabelaContratos();
	});

	$('#perfil_atualizaPerfil').change(function () {
		tabelaContratos();
	});

});

function tabelaContratos() {
	var tipo = '';
	$("#tabelaContratos").html('');
	if (($('#perfil_atualizaPerfil').val() == 1 || $('#perfil_atualizaPerfil').val() == 2)) {
		$('#selectSupervisora').show();
		if ($('#supervisora_atualizaPerfil').val() != '') {
			tipo = 'supervisao';
		}
	} else if($('#perfil_atualizaPerfil').val() != ''){
		tipo = 'todos';
		$('#supervisora_atualizaPerfil').val('');
		$('#selectSupervisora').hide();
	}
	if (tipo != '') {
		$.ajax({
			type: 'POST',
			url: base_url + 'index_cgop.php/painelAdmBuscaContratosUsuario',
			dataType: 'json',
			data: {tipo: tipo, id_supervisora: $('#supervisora_atualizaPerfil').val(),id_usuario:$("#id_usuario_PerfilPermissao").val()},
			async: false,
			success: function (data) {

				var table = '<h4 style="text-align: center">Contratos Autorizados</h4><table  class="table table-striped" style="width: 100%;" border="1">' +
					'<tr><th style="text-align: center">' +
					'<input type="checkbox" id="selecionarTodos" name="selecionarTodos" onclick="checkTodos(this.checked)" class="marcar" title="Selecionar Todos"> </th>' +
					'<th>Nome Contrato</th></tr>';
				for (var i = 0; i < data.length; i++) {
					var checked = '';
					if (data[i].ativo == 'S') {
						checked = ' checked="checked" ';
					}
					table += '<tr>';
					table += '<td style="text-align: center">';
					table += '<input type="checkbox" id="contrato_' + data[i].id_contrato_obra + '" name="id_contrato[]" class="marcar" value="' + data[i].id_contrato_obra + '" ' + checked + '></td>';
					table += '<td>' + data[i].nome + '</td>';
					table += '</tr>';
				}
				table += '</table>';
				$("#tabelaContratos").html(table);
			}, error: function (data) {
				$.notify('Falha na consulta', "warning");
			}
		});
	}
}

//------------------------------------------------------------------------------
function modalAtualizaPerfil(id_usuario) {
	$('#selectSupervisora').hide();
	$("#id_usuario_PerfilPermissao").val(id_usuario);
	populaPerfil(id_usuario);
	populaSupervisora(id_usuario);
	tabelaContratos();
	$("#modalAtualizaPerfilPermissoes").modal("show");
}

//------------------------------------------------------------------------------
function populaPerfil(id_usuario) {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/painelAdmPopulaPerfil',
		dataType: 'json',
		data: {id_usuario: id_usuario},
		async: false,
		success: function (data) {
			var inputOrigem = $('select[id=perfil_atualizaPerfil]');
			inputOrigem.html('');
			inputOrigem.append("<option value=''>Selecione</option>");
			for (var i = 0; i < data.perfil.length; i++) {
				inputOrigem.append("<option value='" + data.codigoPerfil[i] + "' " + data.perfilAtivo[i] + ">" + data.perfil[i] + "</option>");
			}
		}, error: function (data) {
			$.notify('Falha na consulta', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function populaSupervisora(id_usuario) {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/painelAdmPopulaSupervisora',
		dataType: 'json',
		data: {id_usuario: id_usuario},
		async: false,
		success: function (data) {
			var inputOrigem = $('select[id=supervisora_atualizaPerfil]');
			inputOrigem.html('');
			inputOrigem.append("<option value=''>Selecione</option>");
			inputOrigem.append("<option value='0' selected>00 00000/0000 - CONTARATO SEM SUPERVISÃO</option>");
			for (var i = 0; i < data.id_supervisora.length; i++) {
				inputOrigem.append("<option value='" + data.id_supervisora[i] + "' " + data.supervisaoAtiva[i] + ">" + data.nome_supervisora[i] + "</option>");
			}
		}, error: function (data) {
			$.notify('Falha na consulta', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function alteraPerfilPermissao() {
	var serializedData = $("#formAtualizaPerfil").serializeArray();
	bootbox.confirm("Confirmar operação [ALTERAR PERFIL/PERMISSÃO]?", function (result) {
		if (result === true) {
			$.ajax({
				type: 'POST',
				url: base_url + "index_cgop.php/painelAdmAlteraPerfilPermissao",
				data: serializedData,
				dataType: 'json',
				success: function (data) {
					$.notify('Solicitação Aceita!', "success");
					$("#modalAtualizaPerfilPermissoes").modal("hide");
					var table = $("#table_altera_usuario").DataTable();
					table.ajax.reload();
				}, error: function (data) {
					$.notify('Falha no cadastro', "warning");
				}
			});
		}
	});
}

function checkTodos(marcardesmarcar) {
	$('.marcar').each(function () {
		this.checked = marcardesmarcar;
	});
}
