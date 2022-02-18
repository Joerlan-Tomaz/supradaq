//######################################################################################################################################################################################## 
//# DNIT
//# atividadesconstrutoraView.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 13/11/2018 14:10
//########################################################################################################################################################################################
$().ready(function () {
    //-------------------------------------------------------------------------- 
      $.ajaxSetup({ cache: false });
    //--------------------------------------------------------------------------
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    $('#searchdate').hide();
    $('#btnRecuperaUltimo').hide();
    //--------------------------------------------------------------------------
    CKEDITOR.replace('servicoExecutado', {
        //removePlugins: 'toolbar, elementspath, resize',
        height: 250
    });
    //--------------------------------------------------------------------------
    $('#novo_ServicoExecutado').hide();
    $('#cadastroServicoExecutado').hide();
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        recuperaServicosExecutados();
        $('#btnRecuperaUltimo').hide();
    });
    //--------------------------------------------------------------------------
    recuperaServicosExecutados();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaServicosExecutados();
        document.getElementById("datepicker").disabled = false;
        $('#searchdate').hide();
        $('#btnInclusao').show();
        $('#btnRecuperaUltimo').hide();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $('#novo_ServicoExecutado').hide();
            $('#cadastroServicoExecutado').show();
            document.getElementById("datepicker").disabled = true;
            document.getElementById("id_resumo").value = "";
            CKEDITOR.instances["servicoExecutado"].setData("");
             $('#searchdate').show();
             $('#btnInclusao').hide();
             $('#btnRecuperaUltimo').show();
        }
    });
    //-------------------------------------------------------------------- 
    $("#insereServicoExecutado").click(function () {
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
        var servicoExecutado = CKEDITOR.instances['servicoExecutado'].getData();
        if (servicoExecutado == "") {
            if (servicoExecutado === '') {
                document.getElementById('servicoExecutado').style.borderColor = 'red';
            } else {
                document.getElementById('servicoExecutado').style.borderColor = '#d2d6de';
            }
            $.notify("Informe o serviço executado", 'warning');
            return false;
        }
        document.getElementById('servicoExecutado').style.borderColor = '#d2d6de';
        //---------------- Validação de formulario -----------------------------------------------------------------------------------------------
        var serializedData = new Object();
        serializedData = $("#formularioAtividadeConstrutora").serializeArray();
        serializedData[0].value = servicoExecutado;
        serializedData.push(termo);
        //----------------------------------------------------------------------------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR ATIVIDADE CONSTRUTORA]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/AtividadesConstInsereDaq',
                    data: serializedData,
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Atividade da Construtora cadastrada!', "success");
                        CKEDITOR.instances["servicoExecutado"].setData("");
                        $('#cadastroServicoExecutado').hide();
                        $('#novo_ServicoExecutado').show();
                        var tableServicoExecutado = $("#tableServicoExecutado").DataTable();
                        tableServicoExecutado.ajax.reload();

                        document.getElementById("datepicker").disabled = false;
                        document.getElementById("btnInclusao").disabled = false;
                        document.getElementById("searchdate").disabled = false;
                        
                            recuperaServicosExecutados();
                            document.getElementById("datepicker").disabled = false;
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
//--------------------------------------------------------------------       
function excluirAtividadeConstrutora(id_resumo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR SERVIÇO EXECUTADO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/AtividadeConstExcluirDaq',
                    data: {
                        id_resumo: id_resumo
                    },
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        $('#cadastroServicoExecutado').hide();
                        $('#novo_ServicoExecutado').show();
                        var tableServicoExecutado = $("#tableServicoExecutado").DataTable();
                        tableServicoExecutado.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
}
//--------------------------------------------------------------------       
function recuperaServicosExecutados() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_ServicoExecutado').show();
    $('#cadastroServicoExecutado').hide();
    $('#tableServicoExecutado').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/AtividadesConstRecuperaDaq",
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
function editarAtividadeConstrutora(id_resumo) { 
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
         $('#searchdate').show();
         $('#btnInclusao').hide();
         $('#btnRecuperaUltimo').show();
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgob.php/AtividadeConstEditarDaq',
            data: {id_resumo: id_resumo},
            dataType: 'json',
            success: function (data) {
                document.getElementById("datepicker").disabled = true;

                $('#novo_ServicoExecutado').hide();
                $('#cadastroServicoExecutado').show();

                var resumo = data.resumo;
                $("#id_resumo").val(data.id_resumo);
                CKEDITOR.instances['servicoExecutado'].setData(resumo);
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
            url: base_url + 'index_cgob.php/RecuperaUltimoAtv?periodo='+termo,
            dataType: 'json',
            success: function (data) {               
               if(data.resumo != null){
                CKEDITOR.instances['servicoExecutado'].setData(data.resumo);
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
