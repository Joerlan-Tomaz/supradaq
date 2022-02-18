//############################################################################ 
//# 
//# DNIT
//# atividadessupervisoraView.js
//# Desenvolvedor:Jordana de Alencar
//# Data:11/11/2019 10:50
//# 
//############################################################################ 
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
     $('#searchdate').hide();
    CKEDITOR.replace('descAtividadesExecutadas', {
        //removePlugins: 'toolbar, elementspath, resize',
        height: 250
    });
    //--------------------------------------------------------------------------------------------------------------------------------------------
    $('#cadastroAtividade').hide();
    $('#btnRecuperaUltimo').hide();
    //--------------------------------------------------------------------------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        recuperaAtividadeSupervisora();
         $('#btnRecuperaUltimo').hide();
    });
    //--------------------------------------------------------------------------------------------------------------------------------------------  
    recuperaAtividadeSupervisora();
    //--------------------------------------------------------------------------------------------------------------------------------------------
    $("#searchdate").click(function () {
        //----------------------------------------------------------------------------------------------------------------------------------------
        $('#nova_atividade').show();
        $('#cadastroAtividade').hide();
        document.getElementById("datepicker").disabled = false;
        recuperaAtividadeSupervisora();
        $('#searchdate').hide();
        $('#btnInclusao').show();
        $('#btnRecuperaUltimo').hide();
        
    });
    //--------------------------------------------------------------------------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $('#nova_atividade').hide();
            $('#cadastroAtividade').show();
            document.getElementById("datepicker").disabled = true;
            CKEDITOR.instances['descAtividadesExecutadas'].setData("");
            $("#id_resumo").val("");
            $('#searchdate').show();
            $('#btnInclusao').hide();
            $('#btnRecuperaUltimo').show();
        }
    });
    //--------------------------------------------------------------------------------------------------------------------------------------------
    $("#insereAtividadesExecutadas").click(function () {
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
        //------------------ Verificação de campos -----------------------------------------------------------------------------------------------
        var descAtividadesExecutadas = CKEDITOR.instances['descAtividadesExecutadas'].getData();
        if (descAtividadesExecutadas == "") {
            if (descAtividadesExecutadas === '') {
                document.getElementById('descAtividadesExecutadas').style.borderColor = 'red';
            } else {
                document.getElementById('descAtividadesExecutadas').style.borderColor = '#d2d6de';
            }
            $.notify("Por favor, informe os campos necessários", 'warning');
            return false;
        }
        document.getElementById('descAtividadesExecutadas').style.borderColor = '#d2d6de';
        //---------------- Validação de formulario -----------------------------------------------------------------------------------------------
        var serializedData = new Object();
        serializedData = $("#formularioAtividadesExecutadas").serializeArray();
        serializedData[0].value = descAtividadesExecutadas;
        serializedData.push(termo);
        //----------------------------------------------------------------------------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR ATIVIDADES DA SUPERVISORA]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/AtividadeSupInsereDaq',
                    data: serializedData,
                    dataType: 'json',
                    success: function (data) {
                        $('#cadastroAtividade').hide();
                        $('#nova_atividade').show();
                        $.notify('Cadastrado com sucesso!', "success");
                        var atividadesexecutadas = $("#atividadesexecutadas").DataTable();
                        atividadesexecutadas.ajax.reload();
                        CKEDITOR.instances['descAtividadesExecutadas'].setData("");
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
    //--------------------------------------------------------------------------------------------------------------------------------------------
    $("#btnRecuperaUltimo").click(function () {
        btnRecuperaUltimo();
    });
});
function excluirAtividadeSupervisora(id_resumo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [[EXCLUIR ATIVIDADES DA SUPERVISORA]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/AtividadeSupExcluirDaq',
                    data: {
                        id_resumo: id_resumo
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#cadastroResumo').hide();
                        $('#novo_resumo').show();
                        $.notify('Excluido com sucesso!', "success");
                        var atividadesexecutadas = $("#atividadesexecutadas").DataTable();
                        atividadesexecutadas.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha na exclusão', "warning");
                    }
                });
            }
        });
     }
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function recuperaAtividadeSupervisora() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() === "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#atividadesexecutadas').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
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
        "sAjaxSource": base_url + "index_cgob.php/AtividadeSupRetornaDaq",
        "fnServerParams":
                function (aoData) {
                    aoData.push(
                            {"name": "periodo", "value": termo}
                    );
                },
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify", "width": "60%"},
            {data: 'NOME', "sClass": "text-center", "width": "15%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "15%"},
            {data: 'ACAO', "sClass": "text-center", "width": "10%"}
        ]
    });
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function editarAtividadeSupervisora(id_resumo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        $('#searchdate').show();
        $('#btnInclusao').hide();
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgob.php/AtividadeSupEditarDaq',
            data: {id_resumo: id_resumo},
            dataType: 'json',
            success: function (data) {
                document.getElementById("datepicker").disabled = true;
                $('#nova_atividade').hide();
                $('#cadastroAtividade').show();

                var resumo = data.resumo;
                $("#id_resumo").val(data.id_resumo);
                CKEDITOR.instances['descAtividadesExecutadas'].setData(resumo);
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
            url: base_url + 'index_cgob.php/RecuperaSupAtvUltimo?periodo='+termo,
            dataType: 'json',
            success: function (data) {
               if(data.resumo != null){
                CKEDITOR.instances['descAtividadesExecutadas'].setData(data.resumo);
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
