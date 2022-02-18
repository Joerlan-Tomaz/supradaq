//------------------------------------------------------------------------------
$(document).ready(function () {
	buscaTabelaPerfil();

	$("#btnInclusaoPerfil").click(function () {
		$("#cadastroPerfil").show();
		$("#incluirPerfil").hide();
		$("#cadastroTela").hide();
		$("#incluirTela").hide();
	});

	$("#btnInclusaoTela").click(function () {
		$("#cadastroPerfil").hide();
		$("#incluirPerfil").hide();
		$("#cadastroTela").show();
		$("#incluirTela").hide();
	});

	$("#inserePerfil").click(function(){
		inserirPerfil();
	});

	$("#insereTela").click(function(){
		inserirTela();
	});
});

function buscaTabelaPerfil(){
	$('#tabelaPerfil').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/painelAdmRecuperaPerfil",
		"aoColumns": [
			{data: 'perfil', "sClass": "text-center"},
			{data: 'coordenacao', "sClass": "text-center"},
			{data: 'status', "sClass": "text-center"},
			{data: 'usuario', "sClass": "text-center"},
			{data: 'alteracao', "sClass": "text-center"},
			{data: 'acao', "sClass": "text-center"},
		]
	});
}

function buscaTelas(id_perfil){
	$.ajax({
		type: "POST",
		url: base_url + "index_cgop.php/painelAdmTelas",
		data: {id_perfil: id_perfil},
		dataType: "json",
		success: function (data) {
			var table = '<h4 style="text-align: center">Telas Permitidas</h4><table  class="table table-striped" style="width: 100%;" border="1">' +
				'<tr><th style="text-align: center">' +
				'<input type="checkbox" id="selecionarTodos" name="selecionarTodos" onclick="checkTodos(this.checked)" class="marcar" title="Selecionar Todos"> </th>' +
				'<th>Supervisão</th>' +
				'<th>Menu</th>' +
				'<th>Tela</th>' +
				'</tr>';
			for (var i = 0; i < data.length; i++) {
				var checked = '';
				if (data[i].ativo == 'S') {
					checked = ' checked="checked" ';
				}
				table += '<tr>';
				table += '<td style="text-align: center">';
				table += '<input type="checkbox" id="id_tela_acesso_' + data[i].id_tela_acesso + '" name="id_tela_acesso[]" class="marcar" value="' + data[i].id_tela_acesso + '" ' + checked + '></td>';
				table += '<td>' + data[i].supervisao + '</td>';
				table += '<td>' + data[i].menu + '</td>';
				table += '<td>' + data[i].tela + '</td>';
				table += '</tr>';
			}
			table += '</table>';
			$("#vincularTelas").html(table);
		}, error: function (data) {
			$.notify("Falha no cadastro", "warning");
		}
	});
}

function inserirPerfil(){
	var serializedData = new Object();
	serializedData = $("#formularioPerfil").serializeArray();
	//----------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [INSERIR PERFIL]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgop.php/painelAdmInserirPerfil",
				data: serializedData,
				dataType: "json",
				success: function (data) {
					$.notify("Cadastrado com sucesso!", "success");
					$("#cadastroPerfil").hide();
					$("#incluirPerfil").show();
					$("#incluirTela").show();
				}, error: function (data) {
					$.notify("Falha no cadastro", "warning");
				}
			});
		}
	});
}

function inserirTela(){
	var serializedData = new Object();
	serializedData = $("#formularioTela").serializeArray();
	//----------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [INSERIR TELA]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgop.php/painelAdmInserirTela",
				data: serializedData,
				dataType: "json",
				success: function (data) {
					$.notify("Cadastrado com sucesso!", "success");
					$("#cadastroTela").hide();
					$("#incluirPerfil").show();
					$("#incluirTela").show();
				}, error: function (data) {
					$.notify("Falha no cadastro", "warning");
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

//------------------------------------------------------------------------------
function alterarPerfil(id_perfil,desc_perfil) {
	$('#selectSupervisora').hide();
	$('#id_perfil').val(id_perfil);
	$('#nomePerfil').val(desc_perfil);
	buscaTelas(id_perfil);
	$("#modalAtualizaPerfilPermissoes").modal("show");
}

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

function alteraPerfilTelas(){
	var serializedData = new Object();
	serializedData = $("#formPerfilTelas").serializeArray();
	//----------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [VINCULAR TELA(S) AO PERFIL]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgop.php/painelAdmVincularPerfilTela",
				data: serializedData,
				dataType: "json",
				success: function (data) {
					$.notify("Cadastrado com sucesso!", "success");
					var table = $("#tabelaPerfil").DataTable();
					table.ajax.reload();
					$("#modalAtualizaPerfilPermissoes").modal("hide");
				}, error: function (data) {
					$.notify("Falha no cadastro", "warning");
				}
			});
		}
	});
}

function cancelarInserir(){
	$('#formularioTela input').val("");
	$('#formularioTela select').val("");
	$('#formularioPerfil input').val("");
	$('#formularioPerfil select').val("");
	$("#cadastroTela").hide();
	$("#cadastroPerfil").hide();
	$("#incluirPerfil").show();
	$("#incluirTela").show();
}
