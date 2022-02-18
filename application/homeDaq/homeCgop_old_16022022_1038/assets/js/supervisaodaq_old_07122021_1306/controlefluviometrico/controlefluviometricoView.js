//######################################################################################################################################################################################################################## 
//# DNIT
//# controleFluviometricoView.js
//# Desenvolvedor:Pedro Correia
//########################################################################################################################################################################################################################

$().ready(function () {
	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$('#novo_controleFluviometrico').hide();
	$('#cadastroControleFluviometrico').hide();
	$('#searchdate').hide();
	confereNaoAtividade();
	//--------------------------------------------------------------------------
	Recuperadiasmes();
	//--------------------------------------------------------------------------
	$('#datepicker').on("changeDate", function () {
		recuperaControleFluv();
	});
	//--------------------------------------------------------------------------
	recuperaControleFluv();
	//--------------------------------------------------------------------------
	$("#searchdate").click(function () {
		recuperaControleFluv();
		$('#searchdate').hide();
		$('#btnInclusao').show();
		$('#btnNoAtividade').show();
	});
	//--------------------------------------------------------------------------
	$("#btnInclusao").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			document.getElementById("datepicker").disabled = true;
			$('#novo_controleFluviometrico').hide();
			$('#cadastroControleFluviometrico').show();
			$('#searchdate').show();
			$('#btnInclusao').hide();
			$('#btnNoAtividade').hide();
			if (document.getElementById) {
				var dt = $("#datepicker").datepicker('getDate');
				if (dt.toString() == "Invalid Date") {
					$("#datepicker").datepicker("setDate", new Date());
					return;
				}

				function getMesExtenso(mes) {
					var arrayMes = new Array(12);
					arrayMes[0] = "Jan";
					arrayMes[1] = "Feb";
					arrayMes[2] = "Mar";
					arrayMes[3] = "Apr";
					arrayMes[4] = "May";
					arrayMes[5] = "Jun";
					arrayMes[6] = "Jul";
					arrayMes[7] = "Aug";
					arrayMes[8] = "Sep";
					arrayMes[9] = "Oct";
					arrayMes[10] = "Nov";
					arrayMes[11] = "Dec";
					return arrayMes[mes];
				}

				var ano = dt.getFullYear();
				var mes = dt.getMonth() + 1;
				var mesext = getMesExtenso(dt.getMonth());
			}


			var linhas = document.getElementById('tableCadastroControleFluviometrico').rows;
			var qtdLinhas = (linhas.length - 1);
			var x = 1;

			for (var j = 0; j < qtdLinhas; j++) {
				document.getElementById('tableCadastroControleFluviometrico').deleteRow(x);
			}

			var lastDay = (new Date(ano, mes, 0)).getDate();
			for (i = 1; i <= lastDay; i++) {
				var d = new Date(mesext + i + ',' + ano); //instanciada passando uma string
				var days = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"];

				var newRow = $("<tr>");
				var cols = "";
				cols += "<td>Dia " + i + " - " + days[d.getDay()] + "</td>";
				cols += "<td style='text-align: center;'>Manhã</td>";
				cols += "<td>";
				cols += "   <select class='form-control' name='cp_manha_" + i + "' id='cp_manha_" + i + "' required>";
				cols += "       <option value=''>Selecione.. </option>";
				cols += "       <option value='A'>Acima da média histórica</option>";
				cols += "       <option value='B'>Acima do mesmo dia do ano anterior</option>";
				cols += "       <option value='C'>Na média</option>";
				cols += "       <option value='D'>Abaixo do mesmo dia do ano anterior</option>";
				cols += "       <option value='E'>Não houveram atividades</option>";
				cols += "   </select>";
				cols += "</td>";
				cols += "<td style='text-align: center;'><input type='text' className='form-control' name='nivel_manha_" + i + "' id='nivel_manha_" + i + "' placeholder='Nivel(cm)'></td>";
				cols += "<td style='text-align: center;'>Tarde</td>";
				cols += "<td>";
				cols += "   <select class='form-control' name='cp_tarde_" + i + "' id='cp_tarde_" + i + "' required>";
				cols += "       <option value=''>Selecione.. </option>";
				cols += "       <option value='A'>Acima da média histórica</option>";
				cols += "       <option value='B'>Acima do mesmo dia do ano anterior</option>";
				cols += "       <option value='C'>Na média</option>";
				cols += "       <option value='D'>Abaixo do mesmo dia do ano anterior</option>";
				cols += "       <option value='E'>Não houveram atividades</option>";
				cols += "   </select>";
				cols += "</td>";
				cols += "<td style='text-align: center;'><input type='text' className='form-control' name='nivel_tarde_" + i + "' id='nivel_tarde_" + i + "' placeholder='Nivel(cm)'></td>";

				newRow.append(cols);
				$("#tableCadastroControlePluviometrico").append(newRow);
			}
		}
	});
	//--------------------------------------------------------------------------
	$("#insereControleFluviometrico").click(function () {

		var termo = new Object();
		if (document.getElementById) {
			var dt = $("#datepicker").datepicker('getDate');
			if (dt.toString() == "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			termo.name = "periodo";
			termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
			var ano = dt.getFullYear();
			var mes = dt.getMonth() + 1;
		}
		var serializedData = $("#formularioControleFluviometrico").serializeArray();
		serializedData.push(termo);

		var totalDias = new Object();
		var lastDay = (new Date(ano, mes, 0)).getDate();

		totalDias.name = "totalDias";
		totalDias.value = lastDay;
		serializedData.push(totalDias);
		//----------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [INSERIR CONTROLE FLUVIOMÉTRICO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/ControleFluvInsereDaq',
					data: serializedData,
					dataType: 'json',
					success: function (data) {
						$.notify('Controle Fluviométrico Cadastrado com Sucesso', "success");
						$('#novo_controleFluviometrico').show();
						$('#cadastroControleFluviometrico').hide();
						var tableControleFluviometrico = $("#tableControleFluviometrico").DataTable();
						tableControleFluviometrico.ajax.reload();
						document.getElementById("datepicker").disabled = false;
						recuperaControleFluv();
						$('#searchdate').hide();
						$('#btnInclusao').show();
						Recuperadiasmes();
						$('#btnNoAtividade').hide();
						confereNaoAtividade();

					}, error: function (data) {
						$.notify('Erro no Envio', "warning");

					}
				});
			}
		});
	});

	$("#btnNoAtividade").click(function () {
		var relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			if (document.getElementById) {
				var dt = $("#datepicker").datepicker('getDate');
				if (dt.toString() == "Invalid Date") {
					$("#datepicker").datepicker("setDate", new Date());
					return;
				}
				var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
			}
			//----------------------------------------------------------------------------------------------------------------------------------------
			bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
				if (result === true) {
					$.ajax({
						type: 'POST',
						url: base_url + 'index_cgop.php/ControleFluvNaoAtividadeDaq',
						data: {
							periodo: termo
						},
						dataType: 'json',
						success: function (data) {
							$.notify("Cadastrado", "success");
							var tableControleFluviometrico = $("#tableControleFluviometrico").DataTable();
							tableControleFluviometrico.ajax.reload();
							confereNaoAtividade();
						}, error: function (data) {
							$.notify('Falha no cadastro', "warning");
						}
					});
				}
			});
		}
	});
})

function editar(infraestrutura, eclusa){
	if(infraestrutura == 'null'){
		infraestrutura = $('#infraestrutura').val();
	}
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		if (document.getElementById) {
			var dt = $("#datepicker").datepicker('getDate');
			if (dt.toString() == "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
		}
		//----------------------------------------------------------------------------------------------------------------------------------------
		bootbox.confirm("Confirmar operação [EDITAR CONTROLE FLUVIOMÊTRICO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/ControleFluvEditar',
					data: {
						periodo: termo, infraestrutura: infraestrutura
					},
					dataType: 'json',
					success: function (data) {
						$('#infraestrutura').val(infraestrutura);
						document.getElementById("datepicker").disabled = true;
						$('#novo_controleFluviometrico').hide();
						$('#cadastroControleFluviometrico').show();
						$('#searchdate').show();
						$('#btnInclusao').hide();
						$('#btnNoAtividade').hide();
						if (document.getElementById) {
							function getMesExtenso(mes) {
								var arrayMes = new Array(12);
								arrayMes[0] = "Jan";
								arrayMes[1] = "Feb";
								arrayMes[2] = "Mar";
								arrayMes[3] = "Apr";
								arrayMes[4] = "May";
								arrayMes[5] = "Jun";
								arrayMes[6] = "Jul";
								arrayMes[7] = "Aug";
								arrayMes[8] = "Sep";
								arrayMes[9] = "Oct";
								arrayMes[10] = "Nov";
								arrayMes[11] = "Dec";
								return arrayMes[mes];
							}
							var ano = dt.getFullYear();
							var mes = dt.getMonth() + 1;
							var mesext = getMesExtenso(dt.getMonth());
						}
						var linhas = document.getElementById('tableCadastroControleFluviometrico').rows;
						var qtdLinhas = (linhas.length - 1);
						var x = 1;

						for (var j = 0; j < qtdLinhas; j++) {
							document.getElementById('tableCadastroControleFluviometrico').deleteRow(x);
						}

						var lastDay = (new Date(ano, mes, 0)).getDate();

						$("#tableCadastroControleFluviometrico > tbody"). empty();
						var newRow = $("<tr>");
						var cabecalho = "";

						cabecalho += "<th style='width: 10%;'>Dia</th>"
						cabecalho += "<th style='width: 5%;'>Período</th>"
						cabecalho += "<th style='width: 30%;'>Descrição</th>"
						if(eclusa == 'sim'){
							$("#jusante").html('IP4/outros');
							$("#jusante").attr('onclick', 'editar("null", "não");');
							cabecalho += "<th style='width: 5%;'>Montante(cm)</th>"
							cabecalho += "<th style='width: 5%;'>Jusante(cm)</th>"
						}else{
							$("#jusante").html('Eclusa');
							$("#jusante").attr('onclick', 'editar("null", "sim");');
							cabecalho += "<th style='width: 5%;'>Nível(cm)</th>"
						}
						cabecalho += "<th style='width: 5%;'>Período</th>"
						cabecalho += "<th style='width: 30%;'>Descrição</th>"
						cabecalho += "<th style='width: 5%;'>Montante(cm)</th>"
						if(eclusa == 'sim'){
							cabecalho += "<th style='width: 5%;'>Montante(cm)</th>"
							cabecalho += "<th style='width: 5%;'>Jusante(cm)</th>"
						}else{
							cabecalho += "<th style='width: 5%;'>Nível(cm)</th>"
						}

						newRow.append(cabecalho);
						$("#tableCadastroControleFluviometrico").append(newRow);

						for (i = 1; i <= lastDay; i++) {
							var d = new Date(mesext + i + ',' + ano); //instanciada passando uma string
							var days = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"];

							var newRow = $("<tr>");
							var cols = "";

							cols += "<td>Dia " + i + " - " + days[d.getDay()] + "</td>";
							cols += "<td style='text-align: center;'>Manhã</td>";
							cols += "<td>";
							cols += "   <select class='form-control' name='cp_manha_" + i + "' id='cp_manha_" + i + "' required>";
							cols += "       <option value='Selecione'>Selecione.. </option>";
							cols += "       <option value='Acima da média histórica'>Acima da média histórica</option>";
							cols += "       <option value='Acima do mesmo dia do ano anterior'>Acima do mesmo dia do ano anterior</option>";
							cols += "       <option value='Na média'>Na média</option>";
							cols += "       <option value='Abaixo do mesmo dia do ano anterior'>Abaixo do mesmo dia do ano anterior</option>";
							cols += "       <option value='Não houveram atividades'>Não houveram atividades</option>";
							cols += "   </select>";
							cols += "</td>";
							cols += "<td style='text-align: center;'><input type='text' className='form-control' name='nivel_manha_" + i + "' id='nivel_manha_" + i + "' placeholder='Nivel(cm)'></td>";
							if(eclusa == 'sim'){
								cols += "<td style='text-align: center;'><input type='text' className='form-control' name='jusante_manha_" + i + "' id='jusante_manha_" + i + "' placeholder='Nivel(cm)'></td>";
							}
							cols += "<td style='text-align: center;'>Tarde</td>";
							cols += "<td>";
							cols += "   <select class='form-control' name='cp_tarde_" + i + "' id='cp_tarde_" + i + "' required>";
							cols += "       <option value='Selecione'>Selecione.. </option>";
							cols += "       <option value='Acima da média histórica'>Acima da média histórica</option>";
							cols += "       <option value='Acima do mesmo dia do ano anterior'>Acima do mesmo dia do ano anterior</option>";
							cols += "       <option value='Na média'>Na média</option>";
							cols += "       <option value='Abaixo do mesmo dia do ano anterior'>Abaixo do mesmo dia do ano anterior</option>";
							cols += "       <option value='Não houveram atividades'>Não houveram atividades</option>";
							cols += "   </select>";
							cols += "</td>";
							cols += "<td style='text-align: center;'><input type='text' className='form-control' name='nivel_tarde_" + i + "' id='nivel_tarde_" + i + "' placeholder='Nivel(cm)'></td>";
							if(eclusa == 'sim'){
								cols += "<td style='text-align: center;'><input type='text' className='form-control' name='jusante_tarde_" + i + "' id='jusante_tarde_" + i + "' placeholder='Nivel(cm)'></td>";
							}
							newRow.append(cols);
							$("#tableCadastroControleFluviometrico").append(newRow);

							if(typeof(data[i]) != "undefined" && data[i] !== null) {
								$("#cp_manha_" + i + "").val(data[i]['manha']);
								$("#nivel_manha_" + i + "").val(data[i]['manha_nivel']);
								$("#jusante_manha_" + i + "").val(data[i]['jusante_manha']);
								$("#cp_tarde_" + i + "").val(data[i]['tarde']);
								$("#nivel_tarde_" + i + "").val(data[i]['tarde_nivel']);
								$("#jusante_tarde_" + i + "").val(data[i]['jusante_tarde']);
							}
						}
					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");
					}
				});
			}
		});
	}
}
//------------------------------------------------------------------------------
function recuperaControleFluv() {
	Recuperadiasmes();
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	document.getElementById("datepicker").disabled = false;

	$('#novo_controleFluviometrico').show();
	$('#cadastroControleFluviometrico').hide();
	$('#tableControleFluviometrico').dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/ControleFluvRecuperaDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: 'infraestrutura', "sClass": "text-center", "width": "20%"},
			{data: 'dias', "sClass": "text-right", "width": "65%"},
			{data: 'nome', "sClass": "text-center", "width": "15%"},
			{data: 'ultima_alteracao', "sClass": "text-center", "width": "15%"},
			{data: 'acao', "sClass": "text-center"}
		]
	});
}

//------------------------------------------------------------------------------
function excluirDia(id_controle_fluviometrico) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR DIA DE CONTROLE FLUVIOMÉTRICO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/ControleFluvExcluirDaq',
					data: {id_controle_fluviometrico: id_controle_fluviometrico},
					dataType: 'json',
					success: function (data) {
						$.notify('Excluído com Sucesso', "success");
						var tableControleFluviometrico = $("#tableControleFluviometrico").DataTable();
						tableControleFluviometrico.ajax.reload();
						Recuperadiasmes();
						confereNaoAtividade();
					}, error: function (data) {
						$.notify('Erro no Envio', "warning");
					}
				});
			}
		});
	}
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function Recuperadiasmes() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() === "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}

		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/ControleFluvDiaDaq?periodo=' + termo,
		dataType: 'json',
		success: function (data) {
			if (data.conte == true) {
				$("#btnInclusao").attr("disabled", true);
			} else {
				$("#btnInclusao").attr("disabled", false);
			}
		}, error: function (data) {
			$.notify('falha na consulta', "warning");
		}
	});
}

function confereNaoAtividade() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	//-----------------------------------------------------------------
	var status = $("#filtroStatus").val();
	//-----------------------------------------------------------------
	$.ajax({
		type: "POST",
		url: base_url + "index_cgop.php/ControleFluvConfereAtvDaq",
		data: {periodo: termo, status: status},
		dataType: "json",
		success: function (data) {
			if (data.situacao === "Com Atividade") {
				if ($("#btnInclusao").length) {
					document.getElementById("btnInclusao").disabled = false;
				}
				if ($("#btnNoAtividade").length) {
					document.getElementById("btnNoAtividade").disabled = true;
				}
			} else if (data.situacao === "Sem Atividade") {
				if ($("#btnInclusao").length) {
					document.getElementById("btnInclusao").disabled = true;
				}
				if ($("#btnNoAtividade").length) {
					document.getElementById("btnNoAtividade").disabled = true;
				}
			} else if ("Sem Registros") {
				if ($("#btnInclusao").length) {
					document.getElementById("btnInclusao").disabled = false;
				}
				if ($("#btnNoAtividade").length) {
					document.getElementById("btnNoAtividade").disabled = false;
				}
			}
		}
	});
}
