//######################################################################################################################################################################################## 
//# DNIT
//# componenteambientalView.js
//# Desenvolvedor:jordana de Alencar
//# Data: 12/11/2019 17:53
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
    CKEDITOR.replace('componenteAmbiental', {
        //removePlugins: 'toolbar, elementspath, resize',
        height: 200
    });
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //--------------------------------------------------------------------------
    $('#novo_componenteAmbiental').hide();
    $('#cadastroComponenteAmbiental').hide();
    $('#searchdate').hide();
	confereNaoAtividade();
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        recuperaComponenteAmbiental();
    });
    //--------------------------------------------------------------------------
    recuperaComponenteAmbiental();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaComponenteAmbiental();
        document.getElementById("datepicker").disabled = false;
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
            $('#novo_componenteAmbiental').hide();
            $('#cadastroComponenteAmbiental').show();
            document.getElementById("datepicker").disabled = true;
            $('#searchdate').show();
            $('#btnInclusao').hide();
			$('#btnNoAtividade').hide();
        }
    });
    //--------------------------------------------------------------------------
    $("#insereComponenteAmbiental").click(function () {
        //------------------ Verificação de campos -----------------------------
        fileUpload = $("#fileUpload").val();
        var componenteAmbiental = CKEDITOR.instances['componenteAmbiental'].getData();
        if (fileUpload == "" || componenteAmbiental == "") {
            if (fileUpload == '') {
                document.getElementById('fileUpload').style.borderColor = 'red';
            } else {
                document.getElementById('fileUpload').style.borderColor = '#d2d6de';
            }
            $.notify("Insira os campos necessários!", "warning");
            return false;
        }
        document.getElementById('fileUpload').style.borderColor = '#d2d6de';
        //----------------------------------------------------------------------
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();
        form.append('arquivo', $('#fileUpload')[0].files[0]);
        form.append('periodo', termo);
        form.append('resumoComponenteAmbiental', componenteAmbiental);
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR COMPONENTE AMBIENTAL]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/MonitoramentoInsereDaq',
                    data: form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $.notify(data.mensagem, data.notify);                       
                        $('#cadastroComponenteAmbiental').hide();
                        $('#novo_componenteAmbiental').show();

                        var tblComponenteAmbiental = $("#tableComponenteAmbiental").DataTable();
                        tblComponenteAmbiental.ajax.reload();
                        $("#searchdate").click();
                        $('#fileUpload').val("");
                        CKEDITOR.instances['componenteAmbiental'].setData("");
						confereNaoAtividade();
                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");  
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
			bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
				if (result === true) {
					$.ajax({
						type: 'POST',
						url: base_url + 'index_cgob.php/MonitoramentoNaoAtividadeDaq',
						data: {
							periodo: termo
						},
						dataType: 'json',
						success: function (data) {
							$.notify("Cadastrado", "success");
							var tblComponenteAmbiental = $("#tableComponenteAmbiental").DataTable();
							tblComponenteAmbiental.ajax.reload();
							confereNaoAtividade();

						}, error: function (data) {
							$.notify('Falha no cadastro', "warning");
						}
					});
				}
			});
		}
	});
});
//------------------------------------------------------------------------------
function anexoAmbiental(nome_arquivo) {
    // $.ajax({
    //     url: 'anexoAmbiental',
    //     type: 'POST',
    //     data: {nome_arquivo: nome_arquivo},
    //     success: function (data) {
            var arquivo = base_url+'/application/homeDaq/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            // excluirArq(nome_arquivo);
        // }, error: function (data) {
        //     $.notify('Falha no download!', "warning");
        // }
    // });
}
//------------------------------------------------------------------------------
function recuperaComponenteAmbiental() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_componenteAmbiental').show();
    $('#cadastroComponenteAmbiental').hide();
    $('#tableComponenteAmbiental').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/MonitoramentoRetornaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify", "width": "50%"},
            {data: 'ARQUIVO', "width": "25%"},
            {data: 'NOME', "sClass": "text-center", "width": "10%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirArquivo(id_arquivo, id_resumo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'index_cgob.php/MonitoramentoExcluirDaq',
                    data: {id_arquivo: id_arquivo, id_resumo: id_resumo},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Removido com sucesso!', "success");
                        var tblComponenteAmbiental = $("#tableComponenteAmbiental").DataTable();
                        tblComponenteAmbiental.ajax.reload();
						confereNaoAtividade();
                    }, error: function (jqXHR, textStatus, errorMessage) {
                        $.notify('Ocorreu um erro: ' + errorMessage, "warning");
                    }
                });
            }
        });
    }
}
function excluirArq(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/excluirArq',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Excluido com Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
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
		url: base_url + "index_cgob.php/MonitoramentoConfereAtvDaq",
		data: {periodo: termo, status: status},
		dataType: "json",
		success: function (data) {
			if (data.situacao === "Com Atividade") {
				if ($("#btnInclusao").length){
					document.getElementById("btnInclusao").disabled = false;
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
//-----------------------------------------------------------------------------
