//######################################################################################################################################################################################## 
//# DNIT
//# atividadecriticas.js
//# Desenvolvedor:Jordana de Alencar 
//# Data:11/11/2019 
//########################################################################################################################################################################################
$().ready(function () {
    CKEDITOR.replace('atividadesCriticas', {
        //removePlugins: 'toolbar, elementspath, resize',
        height: 250
    });
    $('#novo_AtividadesCriticas').hide();
    $('#cadastroAtividadesCriticas').hide();
    $('#searchdate').hide();
    $('#btnRecuperaUltimo').hide();
    //--------------------------------------------------------------------------------------------------------------------------------------------
    recuperaAtividadesCriticas();
    //-------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaAtividadesCriticas();
        document.getElementById("datepicker").disabled = false;
        document.getElementById("btnInclusao").disabled = false;
        $('#searchdate').hide();
        $('#btnInclusao').show();
        $('#btnRecuperaUltimo').hide();
    });
    //--------------------------------------------------------------------------
    $("#datepicker").change(function () {
        recuperaAtividadesCriticas();
        $('#btnRecuperaUltimo').hide();
    });
    //--------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $('#novo_AtividadesCriticas').hide();
            $('#cadastroAtividadesCriticas').show();
            document.getElementById("datepicker").disabled = true;
            document.getElementById("id_resumo").value = "";
            CKEDITOR.instances["atividadesCriticas"].setData("");
            $('#searchdate').show();
            $('#btnInclusao').hide();
            $('#btnRecuperaUltimo').show();
        }
    });
    //-------------------------------------------------------------------- 
    $("#insereAtividadesCriticas").click(function () {
        var termo = new Object();
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }

        //------------------ Verificação de campos -----------------------------------------
        var atividadesCriticas = CKEDITOR.instances['atividadesCriticas'].getData();
        if (atividadesCriticas == "") {
            if (atividadesCriticas === '') {
                document.getElementById('atividadesCriticas').style.borderColor = 'red';
            } else {
                document.getElementById('atividadesCriticas').style.borderColor = '#d2d6de';
            }
            $.notify("Por favor, informe os campos necessários", 'warning');
            return false;
        }
        //---------------- Validação de formulario -----------------------------------------------------------------------------------------------
        var serializedData = new Object();
        serializedData = $("#formularioAtividadeCritica").serializeArray();
        serializedData[0].value = atividadesCriticas;
        serializedData.push(termo);
        //----------------------------------------------------------------------------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR ATIVIDADE CRÍTICA]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/AtividadeCriticaInsereDaq',
                    data: serializedData,
                    dataType: 'json',
                    success: function (data) {
                        CKEDITOR.instances["atividadesCriticas"].setData("");
                        $('#cadastroAtividadesCriticas').hide();
                        $('#novo_AtividadesCriticas').show();
                        $.notify('Cadastrado com sucesso!', "success");
                        var tableAtividadesCriticas = $("#tableAtividadesCriticas").DataTable();
                        tableAtividadesCriticas.ajax.reload();
                        document.getElementById("datepicker").disabled = false;
                        document.getElementById("btnInclusao").disabled = false;
                        document.getElementById("searchdate").disabled = false;
                         $('#searchdate').hide();
                         $('#btnInclusao').show();
                         $('#btnRecuperaUltimo').hide();

                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });

    });
    //--------------------------------------------------------------------------
    $("#btnRecuperaUltimo").click(function () {
        btnRecuperaUltimo();
    });
    //--------------------------------------------------------------------------
});
//------------------------------------------------------------------------
function excluirAtividadesCriticas(id_resumo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR ATIVIDADE CRÍTICA]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/AtividadesCriticasExcluiDaq',
                    data: {id_resumo: id_resumo},
                    dataType: 'json',
                    success: function (data) {
                        $('#cadastroAtividadesCriticas').hide();
                        $('#novo_AtividadesCriticas').show();
                        $.notify('Excluido com sucesso!', "success");
                        var tableAtividadesCriticas = $("#tableAtividadesCriticas").DataTable();
                        tableAtividadesCriticas.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                        
                    }
                });
            }

        });
    }
}
//------------------------------------------------------------------------
function recuperaAtividadesCriticas() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_AtividadesCriticas').show();
    $('#cadastroAtividadesCriticas').hide();
    $('#tableAtividadesCriticas').dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/AtividadesCriticasRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify"},
            {data: 'NOME', "sClass": "text-center"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center"},
            {data: 'ACAO', "sClass": "text-center"}
        ]
    });
}
//--------------------------------------------------------------------       
function editarAtividadesCriticas(id_resumo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgop.php/AtividadesCriticasEditarDaq',
            data: {id_resumo: id_resumo},
            dataType: 'json',
            success: function (data) {
                document.getElementById("datepicker").disabled = true;
                 $('#searchdate').show();
                 $('#btnInclusao').hide();
                 $('#btnRecuperaUltimo').show();

                $('#novo_AtividadesCriticas').hide();
                $('#cadastroAtividadesCriticas').show();

                var resumo = data.resumo;
                $("#id_resumo").val(data.id_resumo);
                CKEDITOR.instances['atividadesCriticas'].setData(resumo);
            }, error: function (data) {
                $.notify('Falha na exclusão', "warning");
            }
        });
    }
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnRecuperaUltimo() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    bootbox.confirm("Confirmar operação [Recuperar dados do periodo referência anterior]?", function (result) {
      if (result === true) {
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgop.php/RecuperaCritUltimo?periodo='+termo,
            dataType: 'json',
            success: function (data) {
               if(data.resumo != null){
                CKEDITOR.instances['atividadesCriticas'].setData(data.resumo);
               }else{
               $.notify('Não foi encontrado informações do período anterior', "warning"); 
               }
            }, error: function (data) {
                $.notify('Falha na exclusão', "warning");
            }
        });
    }
    });
}
