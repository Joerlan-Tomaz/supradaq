//##############################################################################
//# DNIT
//# ocorrenciaprojetoView.js
//# Desenvolvedor:Jordana de Alencar
//------------------------------------------------------------------------------
$().ready(function () {
    var dadosTabela = {};
    //--------------------------------------------------------------------------
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    $("#datepicker").on("changeDate", function () {
        recuperaOcorrenciaProjeto();
    });
    //--------------------------------------------------------------------------
    recuperaOcorrenciaProjeto();
    // document.getElementById("datepicker").disabled = true;
    //--------------------------------------------------------------------------
    $("#btnInsere").click(function () {
		relatorio = confereRelatorio();
		if (relatorio == 1) {
			mensagemRelatorioFechado();
		} else {
			btnInsere();
		}
     });
    $("#btnInsere_old").click(function () {
//------------------ Verificação de campos -----------------------------
        if ($("#fileOcorrenciaProjeto_planilha").val() == "") {
            $("#fileOcorrenciaProjeto_planilha").css("borderColor", "red");
            $.notify("Insira o arquivo", "warning");
            return false;
        } else {
            $("#fileOcorrenciaProjeto_planilha").css("borderColor", "#d2d6de");
        }
//---------------- Validação de formulario -----------------------------
        var form = new FormData();
        form.append("arquivo", $("#fileOcorrenciaProjeto_planilha")[0].files[0]);
        //----------------------------------------------------------------------
       
    });
    //-------------------- contagem Linhas -------------------------------------
     $("#fileOcorrenciaProjeto_planilha").change(function () {
		 relatorio = confereRelatorio();
		 if (relatorio == 1) {
			 mensagemRelatorioFechado();
		 } else {
			 fileOcorrenciaProjeto_planilha();
		 }
     });
    $("#fileOcorrenciaProjeto_planilha_old").change(function () {
        var arquivo = $("#fileOcorrenciaProjeto_planilha").val();
        if (arquivo != "") {
            var arquivo = $("#fileOcorrenciaProjeto_planilha")[0].files[0];
            $("#nomeArquivo").text(arquivo.name);
        }
        var form = new FormData();
        form.append("arquivo", $("#fileOcorrenciaProjeto_planilha")[0].files[0]);
        $.ajax({
            type: "POST",
            url: base_url + "index_cgop.php/OcorrenciaProjetoContagemDaq",
            data: form,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                dadosTabela = data;
                $("#linhasCarregadas").text("Número de linhas a serem adicionadas: " + dadosTabela.length);
            }, error: function (data) {
                $.notify("Verifique o modelo do arquivo!", "warning");
            }
        });
    });
    //--------------------------------------------------------------------------
    $("#btnVoltar").click(function () {
        $("#exibesupervisaocont").empty();
        $("#exibesupervisaocont").load(base_url + "index_cgop.php/ConfiguracaoMenuDaq").slideUp(3).delay(3).fadeIn("slow");
    });
});
//------------------------------------------------------------------------------
function recuperaOcorrenciaProjeto() {
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
    $("#tableOcorrenciaProjeto").dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/OcorrenciaProjetoRecuperaDaq?periodo="+termo,
             "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: "ARQUIVO"},
            {data: "TOTAL", "sClass": "text-center"},
            {data: "DETALHES", "sClass": "text-center"},
            {data: "NOME", "sClass": "text-center"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center"},
            {data: "ACAO", "sClass": "text-center"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirOcorrenciaProjeto(id_arquivo, arquivo) {relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR REGISTROS DE OCORRÊNCIA DE PROJETO DO ARQUIVO  '" + arquivo + "']?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/OcorrenciaProjetoExcluirDaq',
					data: {id_arquivo: id_arquivo},
					dataType: 'json',
					success: function (data) {
						$.notify('Excluído com sucesso!', "success");
						var tableOcorrenciaProjeto = $("#tableOcorrenciaProjeto").DataTable();
						tableOcorrenciaProjeto.ajax.reload();
					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");
					}
				});
			}
		});
	}
}
//------------------------------------------------------------------------------
function dividirDadosTabelaExcel(base, max) {
    var arrayOfArrays = [];
    for (var i = 0; i < base.length; i += max) {
        arrayOfArrays.push(base.slice(i, i + max));
    }
    return arrayOfArrays;
}
//------------------------------------------------------------------------------
function detalhesOcorrenciaProjeto(id_arquivo) {
    $("#detalhesOcorrenciaProjeto").modal("show");
    $("#tableDetalhesOcorrenciaProjeto").dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/OcorrenciaProjetoDetalhesDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "id_arquivo", "value": id_arquivo});
        },
        "aoColumns": [
            {data: "NOME", "sClass": "text-center"},
            {data: "TIPO", "sClass": "text-center"},
            {data: "ESTACA", "sClass": "text-center"},
            {data: "COORDENADAS", "sClass": "text-center"},
            {data: "KM", "sClass": "text-center"},
            {data: "USUARIO", "sClass": "text-center"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center"}
        ]
    });
}
//------------------------------------------------------------------------------
function anexoProjeto(nome_arquivo) {
    $.ajax({
        url: 'anexoProjeto',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluirOcorrecia(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//------------------------------------------------------------------------------
function ModeloOcorrenciaProjeto(nome_arquivo) {
    $.ajax({
        url: 'ModeloOcorrenciaProjeto',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluirOcorrecia(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function fileOcorrenciaProjeto_planilha(){
      $("#btnInsere").prop('disabled', true);
     //------------------ Verificação de campos -----------------------------
        if ($("#fileOcorrenciaProjeto_planilha").val() == "") {
            $("#fileOcorrenciaProjeto_planilha").css("borderColor", "red");
            $.notify("Preencha os campos obrigatórios", "warning");
            return false;
        } else {
            $("#fileOcorrenciaProjeto_planilha").css("borderColor", "#d2d6de");
        }
        //-----------------------------------------------------------------------------
              if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();
        form.append("arquivo", $("#fileOcorrenciaProjeto_planilha")[0].files[0]);
        form.append('periodo', termo);
        //----------------------------------------------------------------------
      //  bootbox.confirm("Confirmar operação [INSERIR GEORREFERENCIAMENTO]?", function (result) {
          //  if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/OcorrenciaProjetoInsereDaq",
                    dataType: "json",
                    data: form,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function (data) {
                        $.notify("Arquivo selecionado com sucesso!", "success");
                        $("#hdnArquivo").val("");
                        $("#hdnArquivo").val(data.nomeArquivo);
                        $("#hdnidArquivo").val("");
                        $("#hdnidArquivo").val(data.id_arquivo);
                        $("#btnInsere").prop('disabled', false);
                        $("#linhasCarregadas").text("Arquivo selecionado com sucesso,click em [Salvar] e aguarde atualização dos dados, 1 minuto aproximadamente!...........");
                        $("#linhasCarregadas").css("color", "green");
                    },
                    error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                    }
                });
        //    }
      //  });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnInsere(){
     $('#spinner').show();
    //------------------ Verificação de campos -----------------------------
        if ($("#fileOcorrenciaProjeto_planilha").val() == "") {
            $("#fileOcorrenciaProjeto_planilha").css("borderColor", "red");
            $.notify("O campo [Arquivo] é obrigatório!", "warning");
            return false;
        } else {
            $("#fileOcorrenciaProjeto_planilha").css("borderColor", "#d2d6de");
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();
        form.append("arquivo", $("#fileOcorrenciaProjeto_planilha")[0].files[0]);
        var nomeArquivo = $("#hdnArquivo").val();
        var idArquivo = $("#hdnidArquivo").val();
       
        //----------------------------------------------------------------------
       // bootbox.confirm("Confirmar operação [INSERIR GEORREFERENCIAMENTO]?", function (result) {
          //  if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/OcorrenciaProjetoInsereDadosDaq?nomeArquivo="+nomeArquivo+"&idArquivo="+idArquivo,
                    dataType: "json",
                    data: form,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function (data) {
                        if (data == true){
                        $.notify("Dados atualizados com sucesso!", "success");
                        $("#linhasCarregadas").text("Dados atualizados com sucesso!");
                        $("#linhasCarregadas").css("color", "green");
                        $("#btnInsere").prop('disabled', true);
                        $("#fileOcorrenciaProjeto_planilha").val("");
                        recuperaOcorrenciaProjeto();
                        
                    }
                    else{
                             $.notify(data.mensagem, data.notify);
                             $("#linhasCarregadas").css("color", "red");
                             $("#linhasCarregadas").text("É permitido somente planilhas preenchidas e Modelo!");
                             $("#btnInsere").prop('disabled', true);
                             $("#fileOcorrenciaProjeto_planilha").val("");
                              recuperaOcorrenciaProjeto();
                        }
                    },
                    error: function (data) {
                        $.notify("Falha no cadastro, verifique se as colunas estão preenchidas!", "warning");
                        $("#linhasCarregadas").text("Falha no cadastro");
                        $('#spinner').hide();
                         
                    }
                });
          //  }
      //  });
}
//-----------------------------------------------------------------------------
function excluirOcorrecia(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgop.php/excluirOcorrecia',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Excluido com Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//-----------------------------------------------------------------------------
