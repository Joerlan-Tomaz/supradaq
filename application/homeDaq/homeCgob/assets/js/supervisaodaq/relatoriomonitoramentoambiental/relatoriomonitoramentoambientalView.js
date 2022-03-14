$().ready(function () {
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$("#novo_RelatorioMonitoramentoAmbiental").hide();
	$("#cadastroRelatorioMonitoramentoAmbiental").hide();
	$("#searchdate").hide();
	confereNaoAtividade();
	$('#btnRecuperaUltimo').hide();
	//--------------------------------------------------------------------------
	$("#datepicker").on("changeDate", function () {
		recuperaRelatorioMonitoramentoAmbiental();
		confereNaoAtividade();
		$('#btnRecuperaUltimo').hide();
	});
	//--------------------------------------------------------------------------
	recuperaRelatorioMonitoramentoAmbiental();
	//--------------------------------------------------------------------------
	$("#searchdate").click(function () {
		recuperaRelatorioMonitoramentoAmbiental();
		document.getElementById("datepicker").disabled = false;
		$("#btnInclusao").show();
		$("#searchdate").hide();
		$('#btnNoAtividade').show();
	});

	$("#btnInclusao").click(function () {
		var relatorio = confereRelatorio();
		$('#numeroSeiRelMonitAmbiental').val('');
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			$("#novo_RelatorioMonitoramentoAmbiental").hide();
			$("#cadastroRelatorioMonitoramentoAmbiental").show();
			document.getElementById("datepicker").disabled = true;
			$("#btnInclusao").hide();
			$("#searchdate").show();
			$('#btnRecuperaUltimo').show();
			$('#btnNoAtividade').hide();
		}
	})

    $("#insereRelatorioMonitoramentoAmbiental").click(function () {
        if ($('#numeroSeiRelMonitAmbiental').val() == "") {
            $.notify("Insira os campos necessários!", "warning");
            return false;
        }
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        var form = new FormData();
        form.append('periodo', termo);
        form.append('numeroSeiRelMonitAmbiental', $('#numeroSeiRelMonitAmbiental').val());
        bootbox.confirm("Confirmar operação [INSERIR RELATÓRIO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/RelatorioMonitoramentoAmbientalInsereDaq',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
						$.notify('Cadastro Efetuado', "success");
						$('#cadastroRelatorioMonitoramentoAmbiental').hide();
						$('#novo_RelatorioMonitoramentoAmbiental').show();
						var tableRelatorioMonitoramentoAmbiental = $("#tableRelatorioMonitoramentoAmbiental").DataTable();
						tableRelatorioMonitoramentoAmbiental.ajax.reload();
						$("#searchdate").click();
						confereNaoAtividade();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });

    });
    //--------------------------------------------------------------------------

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
			bootbox.confirm("Confirmar operação [NÃO HOUVERAM ATIVIDADES ESTE MÊS]?", function (result) {
				if (result === true) {
					$.ajax({
						type: 'POST',
						url: base_url + 'index_cgob.php/RelatorioMonitoramentoAmbientalNaoAtividadeDaq',
						data: {
							periodo: termo
						},
						dataType: 'json',
						success: function (data) {
							$.notify("Cadastrado", "success");
							var tableRelatorioMonitoramentoAmbiental = $("#tableRelatorioMonitoramentoAmbiental").DataTable();
							tableRelatorioMonitoramentoAmbiental.ajax.reload();
							confereNaoAtividade();
						}, error: function (data) {
							$.notify('Falha no cadastro', "warning");
						}
					});
				}
			});
		}
	});

    $("#btnRecuperaUltimo").click(function () {
        btnRecuperaUltimo();
    });
    //--------------------------------------------------------------------------
});
//------------------------------------------------------------------------------

function recuperaRelatorioMonitoramentoAmbiental() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_RelatorioMonitoramentoAmbiental').show();
    $('#cadastroRelatorioMonitoramentoAmbiental').hide();
    $('#tableRelatorioMonitoramentoAmbiental').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/RelatorioMonitoramentoAmbientalRetornaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify", "width": "50%"},
            {data: 'NOME', "sClass": "text-center", "width": "10%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirResumo(id_resumo) {
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgob.php/RelatorioMonitoramentoAmbientalExcluirDaq",
                    data: {id_resumo: id_resumo},
                    dataType: "json",
                    success: function (data) {
                        $.notify("Removido com sucesso!", "success");
                        var table = $("#tableRelatorioMonitoramentoAmbiental").DataTable();
                        table.ajax.reload();
						confereNaoAtividade();
                    }, error: function (jqXHR, textStatus, errorMessage) {
                        $.notify("Ocorreu um erro: " + errorMessage, "warning");
                    }
                });
            }
        });
    }
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
		url: base_url + "index_cgob.php/RelatorioMonitoramentoAmbientalConfereAtvDaq",
		data: {periodo: termo, status: status},
		dataType: "json",
		success: function (data) {
			if (data.situacao === "Com Atividade") {
				if ($("#btnInclusao").length){
					/*desabilitado para permitir apenas um registro cadastrado*/
					document.getElementById("btnInclusao").disabled = true;
				}
				if ($("#btnNoAtividade").length){
					document.getElementById("btnNoAtividade").disabled = true;
				}
			} else if (data.situacao === "Sem Atividade") {
				if ($("#btnInclusao").length){
					document.getElementById("btnInclusao").disabled = true;
				}
				if ($("#btnNoAtividade").length){
					document.getElementById("btnNoAtividade").disabled = true;
				}
			} else if ("Sem Registros") {
				if ($("#btnInclusao").length){
					document.getElementById("btnInclusao").disabled = false;
				}
				if ($("#btnNoAtividade").length){
					document.getElementById("btnNoAtividade").disabled = false;
				}
			}
		}
	});
}
