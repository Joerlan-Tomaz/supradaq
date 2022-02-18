//######################################################################################################################################################################################## 
//# DNIT
//# apresentacaoconstrutoraView.js
//# Desenvolvedor:Jordana Alencar
//# Data: 10/10/2018 09:59
//########################################################################################################################################################################################
$().ready(function () {
    //--------------------------------------------------------------------------
     $('#searchdate').hide();
    //--------------------------------------------------------------------------
       if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    //--------------------------------------------------------------------------
     $("#abreApresentacao").click(function () {
        abreApresentacao();
    });
     //--------------------------------------------------------------------------
     $("#gravaApresentacao").click(function () {
        gravaApresentacao();
    });
    //--------------------------------------------------------------------------
    
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RecuperaApresentacaoConstrutoraDaq?periodo='+termo,
        dataType: 'json',
        success: function (data) {

            $("span[id='as_contrato']").html(data.contrato);
            $("span[id='as_empresa']").html(data.empresa);
            $("span[id='as_processo_base']").html(data.processo_base);
            $("span[id='as_objeto']").html(data.objeto);
            $("span[id='as_localizacao']").html(data.localizacao);

            $("span[id='as_data_base']").html(data.data_base);
            $("span[id='as_data_publicacao']").html(data.data_publicacao);
            $("span[id='as_publicacao_DOU']").html(data.publicacao_licitacao_DOU); 
            $("span[id='as_data_assinatura']").html(data.data_assinatura);
            $("span[id='as_ordem_inicial']").html(data.ordem_inicial);
            $("span[id='as_prazo_inicial']").html(data.prazo_inicial);
            $("span[id='as_termino_inicial']").html(data.termino_inicial);

            $("span[id='as_dias_aditados']").html(data.dias_aditados);
            $("span[id='as_dias_paralisados']").html(data.dias_paralisados);
            $("span[id='as_termino_atualizada']").html(data.termino_atualizada);
            $("span[id='as_valor_PI']").html(data.valor_PI);
            $("span[id='as_valor_aditado']").html(data.valor_aditado);
            $("span[id='as_valor_reajuste']").html(data.valor_reajuste);
            $("span[id='as_valor_atualizado']").html(data.valor_atualizado);

            if (data.contrato != "") {
                var x = document.getElementById('exibeApresentacaoConstrutora');
                if (x.style.display === 'none') {
                    x.style.display = 'block';
                }
            } else {
                $.notify('Relacionar contrato de construção a obra no sistema!', "danger");
            }

        }
    });

   
    //Apresentação Construtora table Aditivo------------------------------------
    $('#tableAsAditivo').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/RetornaAditivoDaq",
        "aoColumns": [
            {data: 'NUMERO_TERMO', "sClass": "text-center", "width": "15%"},
            {data: 'DATA_ASSINATURA', "sClass": "text-center", "width": "10%"},
            {data: 'OBJETO_TERMO', "sClass": "text-center", "width": "10%"},
            {data: 'DIAS_ADITADOS', "sClass": "text-center", "width": "10%"},
            {data: 'VALOR_ADITADO', "sClass": "text-center", "width": "10%"},
            {data: 'USUARIO', "sClass": "text-center", "width": "10%"},
            {data: 'PERIODO_REFERENCIA', "sClass": "text-center", "width": "15%"},
            {data: 'ATUALIZACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });

    //Apresentação Construtora table Fiscal-------------------------------------
    $('#tableAsFiscal').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/RetornaPortariasFiscaisDaq?contrato_fiscalizado=Obra",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'estado', "sClass": "text-center"},
            {data: 'nomeFiscal', "sClass": "text-center"},
            {data: 'email', "sClass": "text-center"},
            {data: 'telefone', "sClass": "text-center"},
            {data: 'titularidade', "sClass": "text-center"},
            {data: 'status', "sClass": "text-center"}
        ]
    });

    //Apresentação Construtora table Localizacao--------------------------------
    $('#tableAsLocalizacao').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/RetornaLocalizacaoDaq",
        "aoColumns": [
            {data: 'HIDROVIA', "sClass": "text-center"},
            {data: 'INICIAL', "sClass": "text-center"},
            //{data: 'FINAL', "sClass": "text-center"},
            {data: 'EXTENSAO', "sClass": "text-center"},
            {data: 'USUARIO', "sClass": "text-center", "width": "10%"},
            {data: 'PERIODO_REFERENCIA', "sClass": "text-center", "width": "15%"},
            {data: 'ATUALIZACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
        ]
    });

    //Apresentação Supervisora table Responsavel Tecnico------------------------
    $('#tableAsResponsavelTecnico').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/RetornaResponsaveltecnicoDaq",
        "aoColumns": [
            {data: 'nome_fiscal', "sClass": "text-center"},
            {data: 'n_art', "sClass": "text-center"},
            {data: 'forma_registro', "sClass": "text-center"},
            {data: 'participacao_tecnica', "sClass": "text-center"},
            {data: 'data_registro', "sClass": "text-center", "width": "10%"},
            {data: 'data_baixa', "sClass": "text-center", "width": "15%"}
            
        ]
    });
    
    $('#tableAsParalisacaoReinicio').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/RetornaParalisacaoReinicioDaq?id_roteiro=18",
        "aoColumns": [
            {data: 'documento', "sClass": "text-center", "width": "10%"},
            {data: 'tipo_documento', "sClass": "text-center", "width": "10%"},
            {data: 'data_paralisacao_reinicio', "sClass": "text-center", "width": "10%"},
            {data: 'motivacao', "sClass": "text-center", "width": "80%"},
            {data: 'acao', "sClass": "text-center", "width": "10%"}
        ]
    });
    //--------------------------------------------------------------------------
    $("#btnModalparalisacaoreinicio").click(function () {
        modalParalisacaoReinicio();
    });
    //--------------------------------------------------------------------------
    CKEDITOR.replace('motivacao_paralisacaoreinicio', {
        height: 200
    });
	CKEDITOR.replace('objeto_termo', {
		height: 200
	});
	CKEDITOR.replace('motivacao_aditivo', {
		height: 200
	});
    //--------------------------------------------------------------------------  
    $("#btgravaParalisacaoreinicio").click(function () {
        btgravaParalisacaoreinicio();
    });

	$.ajax({
		url: base_url + 'index_cgop.php/RetornoSelectHidrovia',
		type: 'POST',
		dataType: 'json',
		data: {uf: this.value},
		success: function (obj) {
			if (obj != null) {
				// var data = obj.data;
				var selectbox = $('#hidrovia');
				selectbox.find('option').remove();
				$('<option>').val('').text('Selecione.. ').appendTo(selectbox);
				$.each(obj, function (i, d) {
					$('<option>').val(d.hidrovia).text(d.hidrovia).appendTo(selectbox);
				});
			}
		}, error: function (data) {
			$.notify('Falha ao carregar hidrovias', "warning");
		}
	});

});
//------------------------------------------------------------------------------
function modalasAditivo() {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $("#asAditivo").modal("show");
    }
}
//------------------------------------------------------------------------------
function modalasFiscal() {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $("#asFiscal").modal("show");
    }
}
//------------------------------------------------------------------------------
function modalasLocalizacao() {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $("#asLocalizacao").modal("show");
    }
}
//------------------------------------------------------------------------------
function modalasResponsavelTecnico() {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $("#asResponsavelTecnico").modal("show");
    }
}
//-------------------------------------------------------------------------------
function atualizaConstrutora() {
      if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RecuperaApresentacaoConstrutoraDaq?periodo='+termo,
        dataType: 'json',
        success: function (data) {

            $("span[id='as_contrato']").html(data.contrato);
            $("span[id='as_empresa']").html(data.empresa);
            $("span[id='as_processo_base']").html(data.processo_base);
            $("span[id='as_objeto']").html(data.objeto);
            $("span[id='as_data_base']").html(data.data_base);
            $("span[id='as_data_assinatura']").html(data.data_assinatura);
            $("span[id='as_data_publicacao']").html(data.data_publicacao);
            $("span[id='as_prazo_inicial']").html(data.prazo_inicial);
            $("span[id='as_ordem_inicial']").html(data.ordem_inicial);
            $("span[id='as_termino_inicial']").html(data.termino_inicial);
            $("span[id='as_termino_atualizada']").html(data.termino_atualizada);
            $("span[id='as_licitacao']").html(data.licitacao);
            $("span[id='as_publicacao_DOU']").html(data.publicacao_licitacao_DOU);

            $("span[id='as_dias_aditados']").html(data.dias_aditados);
            $("span[id='as_dias_paralisados']").html(data.dias_paralisados);
            $("span[id='as_valor_PI']").html(data.valor_PI);
            $("span[id='as_valor_aditado']").html(data.valor_aditado);
            $("span[id='as_valor_reajuste']").html(data.valor_reajuste);
            $("span[id='as_valor_atualizado']").html(data.valor_atualizado);
        }
    });
}
//------------------------------------------------------------------------------
function abreApresentacao() {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $('#asApresentacao').modal('show');
       if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RecuperaApresentacaoConstrutoraDaq?periodo='+termo,
        dataType: 'json',
           
            success: function (data) {
                $("#numero_contrato").val(data.contrato);
                $("#numero_supervisao").val(data.contrato);
                $("#empresa_supervisora").val(data.empresa);
                $("#num_processo_base").val(data.processo_base);
                $("#objeto_contrato").val(data.objeto);

                $("#data_assinatura").val(data.data_assinatura);
                $("#data_publicacao_dou").val(data.data_publicacao);
                $("#prazo_inicial_execucao").val(data.prazo_inicial);
                $("#ordem_inicio_servicos").val(data.ordem_inicial);
                $("#data_inicial_termino").val(data.termino_inicial);
                $("#data_termino_atualizada").val(data.termino_atualizada);
                $("#data_licitacao").val(data.licitacao);
                $("#data_resultado_licitacao_dou").val(data.publicacao_licitacao_DOU);

                $("#total_dias_aditados").val(data.dias_aditados);
                $("#total_dias_paralisados").val(data.dias_paralisados);
                $("#valor_pi_contrato").val(data.valor_PI);
                $("#valor_total_aditivado_contrato").val(data.valor_aditado);
                $("#valor_reajuste_contrato").val(data.valor_reajuste);
                $("#data_base").val(data.data_base);
                $("#valor_atualizado_contrato").val(data.valor_atualizado);

            }
        });
    }
}

function abreApresentacao_old() {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $('#asApresentacao').modal('show');
        $.ajax({
            type: 'POST',
            url: '',
            dataType: 'json',
            success: function (data) {

                $("#numero_contrato").val(data.contrato);
                $("#numero_supervisao").val(data.contrato);
                $("#empresa_supervisora").val(data.empresa);
                $("#num_processo_base").val(data.processo_base);
                $("#objeto_contrato").val(data.objeto);
                $("#localizacao_ap").val(data.localizacao);

                $("#data_assinatura").val(data.data_assinatura);
                $("#data_publicacao_dou").val(data.data_publicacao);
                $("#prazo_inicial_execucao").val(data.prazo_inicial);
                $("#ordem_inicio_servicos").val(data.ordem_inicial);
                $("#data_inicial_termino").val(data.termino_inicial);
                $("#data_termino_atualizada").val(data.termino_atualizada);
                $("#data_licitacao").val(data.licitacao);
                $("#data_resultado_licitacao_dou").val(data.publicacao_licitacao_DOU);

                $("#total_dias_aditados").val(data.dias_aditados);
                $("#total_dias_paralisados").val(data.dias_paralisados);
                $("#valor_pi_contrato").val(data.valor_PI);
                $("#valor_total_aditivado_contrato").val(data.valor_aditado);
                $("#valor_reajuste_contrato").val(data.valor_reajuste);

            }
        });
    }
}
//------------------------------------------------------------------------------
function gravaApresentacao() {

    var serializedData = new FormData();
    serializedData = $("#formularioApresentacao").serializeArray();

    var termo = new Object();
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        termo.name = "periodo";

    }

    serializedData.push(termo);

    bootbox.confirm("Confirma operação [EDITAR APRESENTAÇÃO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/insereApresentacaoconstrutoraDaq',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $('#asApresentacao').modal('hide');
                    $.notify('Cadastrado com sucesso!', "success");
                    atualizaConstrutora();
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                    
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function gravaAditivo() {
    serializedData = validaformulario("formularioAditivo");
    if (serializedData == false) {
        $.notify("Por favor, informe os campos necessários", 'warning');
        return false;
    }
        var num = $('#dias_aditados_ta').val();
            if (num.trim() !== ""){
            var regra = /^[0-9]+$/;
            if (num.match(regra)){
            }else {
                 $.notify("Permitido Somente Números [Dias Aditados]!", "warning");
                 document.getElementById('dias_aditados_ta').style.borderColor = "red";
                 return false;
                }
            }
    var termo = new Object();
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        termo.name = "periodo";
    }
    serializedData.push(termo);
    bootbox.confirm("Confirmar operação [INSERIR ADITIVO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/insereAditivoDaq',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $('#asAditivo').modal('hide');
                    $.notify('Cadastrado com sucesso!', "success");
                    var tblAditivo = $("#tableAsAditivo").DataTable();
                    tblAditivo.ajax.reload();
                    $('#formularioAditivo').trigger("reset");
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function excluirAditivo(id_termo_aditivo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR TERMO ADITIVO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/excluirAditivoDaq',
                    data: {id_termo_aditivo: id_termo_aditivo},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var table = $("#tableAsAditivo").DataTable();
                        table.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
     }
}
//------------------------------------------------------------------------------
function gravaFiscal() {
    //------------------ Verificação de campos ---------------------------------
    serializedData = validaformulario("formularioFiscal");
    if (serializedData == false) {
        $.notify("Por favor, informe os campos necessários", 'warning');
        return false;
    }
    //--------------------------------------------------------------------------
    var termo = new Object();
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        termo.name = "periodo";
    }
    serializedData.push(termo);
    //--------------------------------------------------------------------------
    bootbox.confirm("Confirmar operação [INSERIR FISCAL]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: '',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $('#asFiscal').modal('hide');
                    $.notify('Cadastrado com sucesso!', "success");
                    var tblFiscal = $("#tableAsFiscal").DataTable();
                    tblFiscal.ajax.reload();
                    $('#formularioFiscal').trigger("reset");
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function excluirFiscal(id_fiscal_dnit) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR FISCAL]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: {id_fiscal_dnit: id_fiscal_dnit},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var table = $("#tableAsFiscal").DataTable();
                        table.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------
function gravaLocalizacao() {
    //------------------ Verificação de campos ---------------------------------
    //serializedData = validaformulario("formularioLocalizacao");
    // if (serializedData == false) {
    //     $.notify("Por favor, informe os campos necessários", 'warning');
    //     return false;
    // }
    var serializedData = new FormData();
    serializedData = $("#formularioLocalizacao").serializeArray();
    if($("#hidrovia").val()== ""){
    $.notify("Informe o campo [HIDROVIA]", "warning");
    document.getElementById('hidrovia').style.borderColor = "red";
    return false
    }
    //--------------------------------------------------------------------------
    var termo = new Object();
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        termo.name = "periodo";
    }
    serializedData.push(termo);
    //--------------------------------------------------------------------------
    bootbox.confirm("Confirmar operação [INSERIR LOCALIZAÇÃO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/insereLocalizacaoDaq',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $('#asLocalizacao').modal('hide');
                    $.notify('Cadastrado com sucesso!', "success");
                    var tblLocalizacao = $("#tableAsLocalizacao").DataTable();
                    tblLocalizacao.ajax.reload();
                    $('#formularioLocalizacao').trigger("reset");
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function excluirLocalizacao(id_localizacao) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR LOCALIZAÇÃO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/excluirLocalizacaoDaq',
                    data: {id_localizacao: id_localizacao},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var table = $("#tableAsLocalizacao").DataTable();
                        table.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------
function gravaResponsavelTecnico() {
    //------------------ Verificação de campos ---------------------------------
    serializedData = validaformulario("formularioResponsavelTecnico");
    if (serializedData == false) {
        $.notify("Por favor, informe os campos necessários", 'warning');
        return false;
    }
    var termo = new Object();
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        termo.name = "periodo";
    }
    serializedData.push(termo);
    bootbox.confirm("Confirmar operação [INSERIR RESPONSÁVEL TÉCNICO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/insereResponsavelTecnicoDaq',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $('#asResponsavelTecnico').modal('hide');
                    $.notify('Cadastrado com sucesso!', "success");
                    var tblResponsavelTecnico = $("#tableAsResponsavelTecnico").DataTable();
                    tblResponsavelTecnico.ajax.reload();
                    $('#formularioResponsavelTecnico').trigger("reset");
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function excluirResponsaveltecnico(id_responsavel_tecnico) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR RESPONSÁVEL TÉCNICO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/excluirResponsaveltecnicoDaq',
                    data: {id_responsavel_tecnico: id_responsavel_tecnico},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var table = $("#tableAsResponsavelTecnico").DataTable();
                        table.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function modalObjetoMotivacaoAditivo(id_termo_aditivo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/modalObjetoMotivacaoAditivoDaq',
        data: {id_termo_aditivo: id_termo_aditivo},
        dataType: 'json',
        success: function (data) {
            $("#objeto_modal").html(data.objeto);
            $("#motivacao_modal").html(data.motivacao);
            $("#modalObjetoMotivacaoAditivo").modal("show");
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function modalParalisacaoReinicio(){
    $("#ModalasParalisacaoReinicio").modal("show");
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btgravaParalisacaoreinicio(){
        
        if($("#tipo_documento").val()== ""){
            $.notify("Informe o campo [Tipo documento]", "warning");
            document.getElementById("tipo_documento").style.borderColor = "red";
            return false
        }else{
             document.getElementById("tipo_documento").style.borderColor = "gray";
        }
        
        if($("#dataparalisacaoreinicio").val()== ""){
            $.notify("Informe o campo [Data de Paralisação/Reinicio]", "warning");
            document.getElementById("dataparalisacaoreinicio").style.borderColor = "red";
            return false
        }else{
             document.getElementById("dataparalisacaoreinicio").style.borderColor = "gray";
        }
      
        if(CKEDITOR.instances['motivacao_paralisacaoreinicio'].getData() == ""){
            $.notify("Informe o campo [Motivação]", "warning");
            return false
        }else{
            var motivacao = CKEDITOR.instances['motivacao_paralisacaoreinicio'].getData();
        }
        
       
        if( $("#fileUploadParalisacaoReinicio").val() == ""){
            $.notify("Informe o campo [Arquivo]", "warning");
            document.getElementById("fileUploadParalisacaoReinicio").style.borderColor = "red";
            return false
        }else{
             document.getElementById("fileUploadParalisacaoReinicio").style.borderColor = "gray";
        }
        
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker("getDate");
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        var form = new FormData();
        form.append('arquivo', $('#fileUploadParalisacaoReinicio')[0].files[0]);
        form.append('periodo', termo);
        form.append('motivacao', motivacao);
        

        var serializedData = $("#formularioParalisacaoReinicio").serializeArray();
        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }
        
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgop.php/insereParalisacaoReinicioConstrucaoDaq',
            data: form,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
              $.notify(data.mensagem, data.notify); 
               document.formularioParalisacaoReinicio.reset();
               CKEDITOR.instances['motivacao_paralisacaoreinicio'].setData("");
              $("#ModalasParalisacaoReinicio").modal("hide");
               
               var table = $("#tableAsParalisacaoReinicio").DataTable();
               table.ajax.reload();               
            }, error: function (data) {
                $.notify('Erro no Envio', "warning");
                 
            }
        });
}
//------------------------------------------------------------------------------
function recuperareinicio(nome_arquivo) {
    $.ajax({
        url: 'recuperareinicio',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluirparalizacao(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//------------------------------------------------------------------------------
function excluirparalizacao(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgop.php/excluirparalizacao',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Excluido com Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function excluirParalisacaoReinicio(id_paralisacaoreinicio,id_arquivo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
    bootbox.confirm("Confirmar operação [EXCLUIR PARALISAÇÃO/REINICIO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/excluirParalisacaoReinicioDaq?id_paralisacaoreinicio='+id_paralisacaoreinicio+'&id_arquivo='+id_arquivo,
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluido com sucesso!', "success");
                    var table = $("#tableAsParalisacaoReinicio").DataTable();
                    table.ajax.reload();
                }, error: function (data) {
                    $.notify('Falha na exclusão', "warning");
                }
            });
        }
    });
}
}
