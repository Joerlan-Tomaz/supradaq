//############################################################################ 
//# 
//# DNIT
//# relacaomobilizacaoconstrutoraview.js
//# Desenvolvedor:jordana Alencar 
//# Data:20/12/2019 
//# 
//############################################################################ 
$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$('#searchdate').hide();
	//--------------------------------------------------------------------
	$('#nova_relacaoMobilizacao').hide();
	$('#cadastroRelacaoMobilizacao').hide();
	$('#cadastraritens').hide();
	$('#tableRelacao').hide();
	document.getElementById("sicro").disabled = true;
	document.getElementById("tipo").disabled = true;
	//--------------------------------------------------------------------
	searchdate();
	//--------------------------------------------------------------------
	$("#datepicker").change(function () {
		searchdate();
	});
	//--------------------------------------------------------------------
	$("#item").change(function () {
		RecuperaRelacaoMobilizacao_Construcao();
	});
	//--------------------------------------------------------------------
	$("#searchdate").click(function () {
		searchdate();
		$('#searchdate').hide();
		$('#btnInclusao').show();
		$('#btnCadastroItens').show();
	});
	//--------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			btnInclusao();
			document.getElementById("datepicker").disabled = true;
			$('#searchdate').show();
			$('#btnInclusao').hide();
			$('#btnCadastroItens').hide();
			$('#tableRelacao').hide();
		}
	});
	//--------------------------------------------------------------------
	$("#insereRelacaoMobilizacao").click(function () {
		insereRelacaoMobilizacao();
	});
	//--------------------------------------------------
	$("#itemcadastro").change(function () {
		if ($("#itemcadastro").val() != 'Selecione') {
			document.getElementById("sicro").disabled = false;
			document.getElementById("tipo").disabled = false;
			$("#sicro").val("");
			$("#tipo").val("");
			Recupera_relacao_item_cadastro();
		} else {
			document.getElementById("sicro").disabled = true;
			document.getElementById("tipo").disabled = true;
		}
	});
	//--------------------------------------------------
	$("#btnCadastroItens").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			$('#nova_relacaoMobilizacao').hide();
			$('#cadastroRelacaoMobilizacao').hide();
			$('#cadastraritens').show();
			Recupera_item_cadastro();
		}
	});
	//---------------------------------------------------
	$("#sicro").on("input", function () {
		Recupera_relacao_item_cadastro();
	});
	//---------------------------------------------------
	$("#tipo").on("input", function () {

		Recupera_relacao_item_cadastro();
	});

});

//#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function trashsupervisora(id) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR]?", function (result) {
			if (result === true) {
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
					url: base_url + 'index_cgop.php/MobilizacaoConstrutoraExcluiDaq',
					data: {
						id: id
					},
					dataType: 'json',
					success: function (data) {
						if (data === true) {
							$.notify('[EXCLUIR MOBILIZAÇÃO CONSTRUTORA] efetuado com  sucesso!', "success");
							//-------------------------------------------------------
							$('#cadastroRelacaoMobilizacao').hide();
							$('#nova_relacaoMobilizacao').show();
							var table = $('#tableRelacaoMobilizacao').DataTable();
							table.ajax.reload();

							//-------------------------------------------------------

						} else {
							$.notify('Falha excluir', "warning");

						}
					}
				});
			}
		});
	}
}

//#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function searchdate() {

	document.getElementById("datepicker").disabled = false;
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

	}
	$('#tableRelacao').hide();
	$('#nova_relacaoMobilizacao').show();
	$('#cadastroRelacaoMobilizacao').hide();
	$('#cadastraritens').hide();
	var table = $('#tableRelacaoMobilizacao').DataTable();
	table.destroy();
	$('#tableRelacaoMobilizacao').dataTable({
		"bProcessing": false,
		"pageLength": 100,
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por página",
			"sZeroRecords": "Nenhum registro encontrado",
			"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
			"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros)",
			"sSearch": "Pesquisar: ",
			"pageLength": 100,
			"oPaginate": {
				"sFirst": "Início",
				"sPrevious": "Anterior",
				"sNext": "Próximo",
				"sLast": "Último"
			}
		},
		"sAjaxSource": base_url + "index_cgop.php/MobilizacaoConstrutoraRetornaDaq",
		"fnServerParams":
			function (aoData) {
				aoData.push(
					{"name": "periodo", "value": termo}
				);
			},
		"aoColumns": [
			{data: 'id', "sClass": "text-center", "width": "5%"},
			{data: 'nome_infraestrutura', "sClass": "text-center", "width": "5%"},
			{data: 'cod_sicro', "sClass": "text-center", "width": "15%"},
			{data: 'item', "sClass": "text-center", "width": "15%"},
			{data: 'tipo', "sClass": "left", "width": "25%"},
			{data: 'qtd_proprio', "sClass": "text-center", "width": "10%"},
			{data: 'qtd_terceiro', "sClass": "text-center", "width": "10%"},
			{data: 'nome', "sClass": "text-center", "width": "10%"},
			{data: 'ultima_alteracao', "sClass": "text-center", "width": "10%"},
			{data: 'acoes', "sClass": "text-center", "width": "5%"}
		]
	});
}

//#-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function btnInclusao() {
	$('#nova_relacaoMobilizacao').hide();
	$('#cadastraritens').hide();
	$('#cadastroRelacaoMobilizacao').show();
	populaInfraEstrutura();
	//-------------------------------------------------------------------------------------------------------------------------
	item = $("#item").val('Selecione');
	//-------------------------------------------------------------------------------------------------------------------------
	var table = $('#tableCadastroRelacaoMobilizacao').DataTable();
	table.destroy();
	//-------------------------------------------------------------------------------------------------------------------------
	// $('#cadastroRelacaoMobilizacao').hide();
	//-------------------------------------------------------------------------------------------------------------------------
	Recupera_item();
	//-------------------------------------------------------------------------------------------------------------------------

}

//#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function insereRelacaoMobilizacao() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

	}

	bootbox.confirm("Confirmar operação [INSERIR RELAÇÃO]?", function (result) {
		if (result === true) {
			var serializedData = $("#formularioRelacaoMobilizacao").serialize();
			$.ajax({
				type: 'POST',
				url: base_url + 'index_cgop.php/MobilizacaoConstrutoraGravaDaq',
				data: {
					data: serializedData,
					periodo: termo,
					nome_infraestrutura: $('#nome_infraestrutura').val()
				},
				dataType: 'json',
				success: function (data) {

					$.notify(data.mensagem, data.notify);
					//-------------------------------------------------------
					$('#cadastroRelacaoMobilizacao').hide();
					//---------------------------------------
					//  $('#cadastroRelacaoMobilizacao').hide();
					//   $('#nova_relacaoMobilizacao').show();
					//    document.getElementById("datepicker").disabled = false;
					searchdate();
					$('#searchdate').hide();
					$('#btnInclusao').show();
					$('#tableRelacao').hide();
					//-------------------------------------------------------

				}
			});
		}
	});

}

//#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function Recupera_item() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/MobilizacaoConstrutoraItemDaq',
		dataType: 'json',
		success: function (data) {
			var item = $('select[id=item]');
			item.html('');
			item.append('<option value="Selecione" selected >Selecione</option>');
			for (i = 0; i < data.item.length; i++) {
				item.append('<option value="' + data.item[i] + '">' + data.item[i] + '</option>');

			}
		}
	});
}

//#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function RecuperaRelacaoMobilizacao_Construcao() {
	if ($("#item").val() != 'Selecione') {
		$('#tableRelacao').show();
		item = $("#item").val();
		if (document.getElementById) {
			var dt = $("#datepicker").datepicker('getDate');
			if (dt.toString() == "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

		}
//--------------------------------------------------------------------------------------------------------------------------
		var table = $('#tableCadastroRelacaoMobilizacao').DataTable();
		table.destroy();
		$('#tableCadastroRelacaoMobilizacao').dataTable({
			"bProcessing": false,
			"bFilter": false,
			"bLengthChange": false,
			"pageLength": 300,
			"oLanguage": {
				"sLengthMenu": "Mostrar _MENU_ registros por página",
				"sZeroRecords": "Nenhum registro encontrado",
				"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
				"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
				"sInfoFiltered": "(filtrado de _MAX_ registros)",
				"sSearch": "Pesquisar: ",
				"pageLength": 50,
				"oPaginate": {
					"sFirst": "Início",
					"sPrevious": "Anterior",
					"sNext": "Próximo",
					"sLast": "Último"
				}
			},
			"sAjaxSource": base_url + "index_cgop.php/MobilizacaoConstrutoraRelacaoDaq?item=" + item,
			"fnServerParams":
				function (aoData) {
					aoData.push(
						{"name": "periodo", "value": termo}
					);
				},
			"aoColumns": [
				{data: 'id_relacao_supervisora', "sClass": "text-center", "width": "5%"},
				{data: 'cod_sicro', "sClass": "text-center", "width": "10%"},
				{data: 'item', "sClass": "text-center", "width": "20%"},
				{data: 'tipo', "sClass": "text-center", "width": "50%"},
				{data: 'qtd_proprio', "sClass": "text-center", "width": "15%"},
				{data: 'qtd_terceiro', "sClass": "text-center", "width": "15%"}

			]

		});
	} else {
		$.notify('Selecione o item', "warning");
	}
}

function populaInfraEstrutura() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/LicencasAmbientaisNomeInfraDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=nome_infraestrutura]');
			servico.html('');
			servico.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.id_tipo_licenca.length; i++) {
				servico.append('<option value="' + data.id_tipo_licenca[i] + '">' + data.desc_tipo_licenca[i] + '</option>');
			}
		}
	});
}
//#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#




