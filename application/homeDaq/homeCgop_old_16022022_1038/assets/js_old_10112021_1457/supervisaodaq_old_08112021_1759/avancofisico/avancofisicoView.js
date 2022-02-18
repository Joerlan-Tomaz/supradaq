//##################################################################################################################### 
//# DNIT - FALCONI - AQUAVIARIO
//# avancofisicoView.js
//# Desenvolvedora:Jordana Alencar
//# Data: 03/08/2020 
//######################################################################################################################
//----------------------------------------------------------------------------------------------------------------------
$().ready(function () { 
    //-------------------------------------------------------------------------- 
      $.ajaxSetup({ cache: false });
    //--------------------------------------------------------------------------  
     $(".mostrar").hide();
     $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
     });
    //--------------------------------------------------------------------------
     $('#searchdate').hide();
     $('#novo_avancofisico').hide();
     $('#cadastraAvancoFisicoObra').hide();
     $('#naohouveatividademes').hide();
     $('#contrato_anterior').hide();
     //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        $.ajaxSetup({cache: false});
        recuperaAvancoFisicoaquaviario();
    });
    //--------------------------------------------------------------------------
     recuperaAvancoFisicoaquaviario();
    //-------------------------------------------------------------------------- 
    $("#addExecutado").click(function () {
        $("#campoPaiExecutado").show();
        addExecutado();        
    });
    //--------------------------------------------------------------------------
    $("#insereavancofisicoexecutadoanterior").click(function () {
        insereavancofisicoexecutadoanterior();
    });
    //--------------------------------------------------------------------------
    $("#insereavancofisicoexecutado").click(function () {
        insereavancofisicoexecutado();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            btnInclusao();
            $('#searchdate').show();
            $('#btnInclusao').hide();
        }
    });
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaAvancoFisicoaquaviario();
        $('#searchdate').hide();
        $('#btnInclusao').show();
        $('#btnNoAtividade').show();
    });
    //--------------------------------------------------------------------------
    $("#eixo").change(function () {
    var id_eixo=$("#eixo").val(); 
        if (id_eixo !== "0" && id_eixo !== ""){
            obra();
        }       
    });
       //--------------------------------------------------------------------------
    $("#obra").change(function () {
        if (this.value !== "") {
            document.getElementById("servico").disabled = false;

             servico();
            $("#servico").val('');
            $("#tipo").val('');
            $("#status").val('');
            document.getElementById("tipo").disabled = true;  
            document.getElementById("status").disabled = true;  
        } else {
            document.getElementById("servico").disabled = true;            
        }
         qtdeCampos = 0;
        $('#cadastraAvancoFisicoObra').show();
        $("#insereAvancoFisicoObra").hide();
        $("#insereavancofisicoexecutadoanterior").hide();
        $("#campoPai").empty();
        $("#campoPaiExecutado").empty();
    });
    //--------------------------------------------------------------------------
    $("#servico").change(function () {
        qtdeCampos = 0;
        $('#cadastraAvancoFisicoObra').show();
        $("#insereAvancoFisicoObra").hide();
        $("#insereavancofisicoexecutadoanterior").hide();
        $("#campoPai").empty();
        $("#campoPaiExecutado").empty();
        var id_obra=$("#obra").val();
        var id_servico=$("#servico").val();

        if (id_servico !== "0") {
            document.getElementById("status").disabled = false;
        } else {
            document.getElementById("status").disabled = true;            
        }
      
        if ((id_obra == 1 && id_servico == 8)||(id_obra == 1 && id_servico == 9)||(id_obra == 1 && id_servico == 10)||
            (id_obra == 1 && id_servico == 11)||(id_obra == 1 && id_servico == 12)||(id_obra == 1 && id_servico == 16)||
            
            (id_obra == 5 && id_servico == 8)||(id_obra == 5 && id_servico == 9)||(id_obra == 5 && id_servico == 10)||
            (id_obra == 5 && id_servico == 11)||(id_obra == 5 && id_servico == 12)||(id_obra == 5 && id_servico == 16)) {
            document.getElementById("tipo").disabled = false;
            tipo();
        } else {
            document.getElementById("tipo").disabled = true;            
        }
    });
    //--------------------------------------------------------------------------
    //Adiciona table para Executado --------------------------------------------
    $("#status").change(function () {
        qtdeCampos = 0;
        $('#cadastraAvancoFisicoObra').show();
        $("#insereAvancoFisicoObra").hide();
        $("#insereavancofisicoexecutadoanterior").hide();
        $("#campoPai").empty();
        $("#campoPaiExecutado").empty();       
        status();
    });
    //--------------------------------------------------------------------------
    //Adiciona campos para Atacado e Executado pelo Contrato Anterior ----------
    $("#adicionaCamposKm").click(function () {
        var obra = $('#obra').val();
        var servico = $('#servico').val();
       adicionaCamposKm(obra,servico);
    });
    //--------------------------------------------------------------------------
    $("#insereAvancoFisicoObra").click(function () {
        insereAvancoFisicoObra();
       //avancoaquaviarioatacado();
    });
    //--------------------------------------------------------------------------
    $("#btnNoAtividade").click(function () {
        btnNoAtividade();
    });

});
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function recuperaAvancoFisicoaquaviario() {
    table_naohouveatividademes();
    document.getElementById("datepicker").disabled = false;
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $('#novo_avancofisico').show();
    $('#cadastraAvancoFisicoObra').hide();
    //---------------------------------------------------------------------------------------------------------------------------
    $('#tableAvancoFisico').dataTable({
        "bProcessing": false,
        "bFilter": true,
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
        "sAjaxSource": base_url + "index_cgop.php/AvancoFisicoAtacadoDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
           
           
            {data: 'eixo', "sClass": "text-center"},
            {data: 'obra', "sClass": "text-center"},
            {data: 'servico', "sClass": "text-center"},
            {data: 'tipo', "sClass": "text-center"},
            {data: 'versao', "sClass": "text-center"},
            {data: 'val_final_atacado', "sClass": "text-center"},
            {data: 'atacado_em', "sClass": "text-center"},
            {data: 'executado_em', "sClass": "text-center"},
            {data: 'usuario', "sClass": "text-center"},
            {data: 'data', "sClass": "text-center"},
            {data: 'acoes_executar', "sClass": "text-center"},
            {data: 'acoes_atacado', "sClass": "text-center"},
            {data: 'acoes_executado', "sClass": "text-center"}
            
        ]
    });
    
    $('#tableAvancoFisicoConcluidos').dataTable({
        "bProcessing": false,
        "bFilter": true,
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
        "sAjaxSource": base_url + "index_cgop.php/AvancoFisicoConcluidoDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
           
           
            {data: 'eixo', "sClass": "text-center"},
            {data: 'obra', "sClass": "text-center"},
            {data: 'servico', "sClass": "text-center"},
            {data: 'tipo', "sClass": "text-center"},
            {data: 'versao', "sClass": "text-center"},
            {data: 'val_final_atacado', "sClass": "text-center"},
            {data: 'atacado_em', "sClass": "text-center"},
            {data: 'executado_em', "sClass": "text-center"},
            {data: 'usuario', "sClass": "text-center"},
            {data: 'data', "sClass": "text-center"},
            {data: 'acoes_executado', "sClass": "text-center"}
            
        ]
    });
    
    tableAvancoFisicoContratoAnterior();
    
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function table_naohouveatividademes() { 
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
        url: 'AvancoFisicoAtividadeDaq?periodo='+termo,
        data: {periodo: termo},
        dataType: 'json',
        success: function (data) { 
            if (data.AVANCO == true) {
               
                 $("#btnNoAtividade").attr("disabled", true);
                 $("#btnInclusao").attr("disabled", true);
                 $('#searchdate').hide();
                 $('#exibeAvancoFisicoObra').hide();
                 $('#novo_avancofisico').hide();
                 $('#cadastraAvancoFisicoObra').hide();
                 $('#cadastraExecucao').hide();
                 $('#naohouveatividademes').show();
                 
                var table = $('#tableNaohouveAtividadeMes').DataTable();
                table.destroy();

                $('#tableNaohouveAtividadeMes').dataTable({
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
                    "sAjaxSource": base_url + "index_cgop.php/AvancoFisicoAtividadeDaq?periodo="+termo,
                    "aoColumns": [
                        {data: 'atividademes'},
                        {data: 'usuario'},
                        {data: 'ultima_alteracao'},
                        {data: 'acoes'}

                    ]
                });
            } else {
                $("#naohouveatividademes").hide();
                $("#btnNoAtividade").attr("disabled", false);
                $("#btnInclusao").attr("disabled", false);
                $('#novo_avancofisico').show();
                $('#cadastraAvancoFisicoObra').hide();
                $('#cadastraExecucao').hide();
                $('#naohouveatividademes').hide();
                $('#exibeAvancoFisicoObra').show();
            }
        }
    });
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function modalExecutado(id, valInicial, valFinal, unidade) {
    
    //--------------------------------------------------------------------------------------------------------------
     $('#qtdcamposexecutado').val("");
     $('#qtdcamposexecutadodeletado').val("");
     $('#medicaoexecutado').val(unidade);
    //--------------------------------------------------------------------------------------------------------------
         if (document.getElementById) {
                 var dt = $("#datepicker").datepicker('getDate');
                 if (dt.toString() == "Invalid Date") {
                     $("#datepicker").datepicker("setDate", new Date());
                     return;
                }
                var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";    } 
    
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgop.php/AvancoFisicoPeriodoDaq?id='+id+'&periodo='+termo,
            dataType: 'json',
            success: function (data) {               
                var periodo = data.periodo;
                var unidade = data.unidade;
                if(periodo=='MAIOR'){
                  $.notify('Período de Referência deve ser maior ao Período Atacado.', "warning");
                  return false;                  
                }else{
            //--------------------------------------------------------------------------------------------------------------
                if (id == '' || valInicial == '' || valFinal == '') {
                    $.notify('Falha,campos obrigatótios', "warning");
                } else {
                   
                    $("#modalExecutado").modal("show");
                    $("#id_executado").val(id);
                    $("#Mdokminicial").val(valInicial);
                    $("#Mdokmfinal").val(valFinal);
                    $("#titleModalExecutado").text("Atacado: " + valFinal );
                    qtdeCamposExecutado = 0;
                    $("#campoPaiExecutado").html("");
                    $('#tableExecutados').dataTable({
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
                        "sAjaxSource": base_url + "index_cgop.php/AvancoFisicoExecutadoDaq",
                        "fnServerParams": function (aoData) {
                            aoData.push({"name": "id_tabular", "value": id});
                        },
                        "aoColumns": [
                            {data: 'periodo_referencia', "sClass": "text-center"},
                            {data: 'status', "sClass": "text-center"},
                            {data: 'valFinal', "sClass": "text-center"},
                            {data: 'acoes', "sClass": "text-center"}
                        ]
                    });
                }

                //$("#insereavancofisicoexecutado").show();
                $("#id_executado").val(id);
               }
              
            }, error: function (data) {
                $.notify('Falha na consulta', "warning");
                  
            }
        });
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function modalVisualizarExecutado(id, valInicial, valFinal) {
    //--------------------------------------------------------------------------------------------------------------
    if (id == '' || valInicial == '' || valFinal == '') {
        $.notify('Falha,campos obrigatótios', "warning");
    } else {
        $("#modalVisualizarExecutado").modal("show");
        $("#id_executado").val(id);
        $("#titleModalVisualizarExecutado").text(" Atacado: " + valFinal);
        $('#tableVisualizarExecutados').dataTable({
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
            "sAjaxSource": base_url + "index_cgop.php/AvancoFisicoExecutadoDaq",
            "fnServerParams": function (aoData) {
                aoData.push({"name": "id_tabular", "value": id});
            },
            "aoColumns": [
                {data: 'periodo_referencia', "sClass": "text-center"},
                {data: 'status', "sClass": "text-center"},
                {data: 'valFinal', "sClass": "text-center"}
            ]
        });
    }
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function modalVisualizarExecutadoConcluido(id, valInicial, valFinal) {
    //--------------------------------------------------------------------------------------------------------------
    if (id == '' || valInicial == '' || valFinal == '') {
        $.notify('Falha,campos obrigatótios', "warning");
    } else {
        $("#modalVisualizarExecutadoConcluido").modal("show");
        $("#id_executado").val(id);
        $("#titleModalVisualizarExecutadoConcluido").text("Atacado: " + valFinal);
        $('#tableVisualizarExecutadosConcluido').dataTable({
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
            "sAjaxSource": base_url + "index_cgop.php/AvancoFisicoExConcluidoDaq",
            "fnServerParams": function (aoData) {
                aoData.push({"name": "id_tabular", "value": id});
            },
            "aoColumns": [
                {data: 'periodo_referencia', "sClass": "text-center"},
                {data: 'status', "sClass": "text-center"},
                {data: 'valFinal', "sClass": "text-center"},
                {data: 'acoes', "sClass": "text-center"}
            ]
        });
    }
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function addExecutado() {
        var medicaoexecutado = $('#medicaoexecutado').val();
        for (var qtdeCamposExecutado = 1; qtdeCamposExecutado <= 1; qtdeCamposExecutado++) {
        if (!$("#filhoexecutado" + qtdeCamposExecutado)[0]) {
            $("#campoPaiExecutado").append(
                    "<div class='row form-group' id='filhoexecutado" + qtdeCamposExecutado + "'>" +
                    "   <div class='col-md-3'>" +
                "           <label>"+(medicaoexecutado)+" Executado:</label><input class='form-control' type='text' id='executado_final" + qtdeCamposExecutado + "' name='executado_final[]'  onkeydown='FormataMoeda(this, 10, event)' onkeypress='return maskKeyPress(event)' >" +
                    "   </div>" +
                    "   <div class='col-md-3'>" +
                "           <label>Campo</label><input  class='btn btn-block btn-info' type='button' onclick='removerCampoExecutado(" + qtdeCamposExecutado + ")' value='Remover'>" +
                    "   </div>" +
                    "</div>"
                    );
            //qtdeCamposExecutado++;
        }
        //$('#medicao').val(medicao);
       
        $("#qtdcamposexecutado").val(qtdeCamposExecutado);

    }
    $("#insereavancofisicoexecutado").show();
    if (qtdeCamposExecutado == 1) {
        $("input[name='addExecutado']").attr('disabled', true);
        qtdeCamposExecutado = 0;
    } else {
        $("input[name='addExecutado']").attr('disabled', false);
    }
        
    }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function removerCampoExecutado(id) {
        var objPaiExecutado = document.getElementById("campoPaiExecutado");
        var objFilhoExecutado = document.getElementById("filhoexecutado" + id);
        var removidoExecutado = objPaiExecutado.removeChild(objFilhoExecutado);
        qtdeCamposExecutado--;
        var conte = $('#qtdcamposexecutado').val();
        conte = conte - 1;
        $('#qtdcamposexecutado').val(conte);
        $("#insereavancofisicoexecutado").hide();

    }
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function insereavancofisicoexecutado() {
        var termo = new Object();
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        var inicial;
        var final;
        var km = new Array();
        var conte_campos_executado = $('#qtdcamposexecutado').val();
        var id = $("#id_executado").val();
        //----------------------------------------------------------
        
        var final = $("#executado_final" + 1).val();
        var Validar = executado(id, inicial, final, termo.value);
                if (Validar != true) {
                    document.getElementById("executado_final" + 1).style.borderColor = 'red';
                    $.notify(Validar.mensagem, "warning");
                    return false;
                }else{
                    if ($("#executado_final" + 1).length){ 
                     document.getElementById("executado_final" + 1).style.borderColor = '#d2d6de';
                    }
                }
       
        if(final == ''){
            document.getElementById("executado_final" + 1).style.borderColor = 'red';
            $.notify("Ocorreu um erro [CAMPO VAZIO!]", "warning");
            return false;
            }else {
            document.getElementById("executado_final" + 1).style.borderColor = '#d2d6de';
        }
        //----------------------------------------------------------------------------------------------// 
        if (medicao == '%'){
            nan = $("#executado_final" + 1).val().replace('.','');
            var res = nan.replace(',','.');
            if(res > 100.00){
                   document.getElementById("executado_final" + 1).style.borderColor = 'red';
                    $.notify("Ocorreu um erro [A % total não deve ser superior a 100%!]", "warning");
                    return false;
            }else{
                    document.getElementById("executado_final" + 1).style.borderColor = '#d2d6de';
                }
                //----------------------------------------------------------------------------------------------// 
            }  
        //----------------------------------------------------------------------------------------------------------------//
        var serializedData = $("#formularioKMExecutado").serializeArray();
        serializedData.push(termo);
        var campos = new Object();
        campos.name = "campos";
        campos.value = conte_campos_executado;
        serializedData.push(campos);
        //----------------------------------------------------------------------------------------------------------------//
            bootbox.confirm("Confirmar operação [INSERIR AVANÇO FISÍCO EXECUTADO]?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'index_cgop.php/AvancoFisicoInsereExecutadoDaq?id='+id,
                        data: serializedData,
                        dataType: 'json',
                        success: function (data) {
                            $('#cadastraAvancoFisicoObra').hide();
                            $('#novo_avancofisico').show();
                            $.notify('Cadastrado com sucesso!', "success");
                            $("#insereavancofisicoexecutado").hide();
                            var tableExecutados = $("#tableExecutados").DataTable();
                            tableExecutados.ajax.reload();

                            var tableAvancoFisico = $("#tableAvancoFisico").DataTable();
                            tableAvancoFisico.ajax.reload();

                            var tableAvancoFisicoConcluidos = $("#tableAvancoFisicoConcluidos").DataTable();
                            tableAvancoFisicoConcluidos.ajax.reload();
                            $('#campoPaiExecutado').empty();
                            returnExecutadoaquaviario(id);
                            
                        }, error: function (data) {
                            $.notify('Falha no cadastro', "warning");
                             
                        }
                    });
                }
            });
    }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function btnInclusao() {
        qtdeCampos = 0;
        $('#novo_avancofisico').hide();
        $('#cadastraAvancoFisicoObra').show();
        $('#cadastraExecucao').hide();
        $("#insereAvancoFisicoObra").hide();
        $("#insereavancofisicoexecutado").hide();
        $("#insereavancofisicoexecutadoanterior").hide();
        $("#campoPai").empty();
        $("#campoPaiExecutado").empty();
        $("#eixo").val('');
        $("#obra").val('');
        $("#servico").val('');
        $("#tipo").val('');
        $("#status").val('');
        
        document.getElementById("datepicker").disabled = true;
        document.getElementById("servico").disabled = true;
        document.getElementById("obra").disabled = true;
        document.getElementById("status").disabled = true;   
        document.getElementById("tipo").disabled = true;   
        $.ajax({
            type: 'POST',
            url: base_url + 'index_cgop.php/AvancoFisicoEixoDaq',
            dataType: 'json',
            success: function (data) {
                var eixo = $('select[id=eixo]');
                eixo.html('');
                eixo.append('<option value="" selected >Selecione</option>');
                if (data.id_eixo) {
                    for (i = 0; i < data.id_eixo.length; i++) {
                        eixo.append('<option value="' + data.id_eixo[i] + '">' + data.eixo[i] + '</option>');
                    }
                }
                 
            }
        });
    }
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function obra(){
         var id_eixo=$("#eixo").val();
        if (this.value !== "") {
            document.getElementById("obra").disabled = false;
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoObraDaq',
                data: {id_eixo: id_eixo},
                dataType: 'json',
                success: function (data) {
                    var obra = $('select[id=obra]');
                    obra.html('');
                    obra.append('<option value="" selected >Selecione</option>');
                    for (i = 0; i < data.id_obra.length; i++) {
                        obra.append('<option value="' + data.id_obra[i] + '">' + data.obra[i] + '</option>');
                    }
                }
            });
        } else {
            document.getElementById("obra").disabled = true;
            document.getElementById("servico").disabled = true;
            document.getElementById("status").disabled = true;            
        }
    }
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function servico(){
         var id_obra=$("#obra").val();
        if (this.value !== "") {
            document.getElementById("servico").disabled = false;
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoServicoDaq',
                data: {id_obra: id_obra},
                dataType: 'json',
                success: function (data) {
                    var servico = $('select[id=servico]');
                    servico.html('');
                    servico.append('<option value="" selected >Selecione</option>');
                    for (i = 0; i < data.id_servico.length; i++) {
                        servico.append('<option value="' + data.id_servico[i] + '">' + data.servico[i] + '</option>');
                    }
                }
            });
        } else {
            document.getElementById("servico").disabled = true;
            document.getElementById("tipo").disabled = true;
            document.getElementById("status").disabled = true;            
        }
    }
//---------------------------------------------------------------------
     function tipo(){
        var servico=$("#servico").val();
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoTipoDaq',
                data: {servico: servico},
                dataType: 'json',
                success: function (data) {
                    var tipo = $('select[id=tipo]');
                    tipo.html('');
                    tipo.append('<option value="" selected >Selecione</option>');
                    for (i = 0; i < data.id_tipo.length; i++) {
                        tipo.append('<option value="' + data.tipo[i] + '">' + data.tipo[i] + '</option>');
                    }
                }
            });
        }
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function status(){
        var_executado =  $("#status").val();
        var_eixo = $("#eixo").val();
        var_servico = $("#servico").val();
        var_obra = $("#obra").val();
        var_tipo = $("#tipo").val();

        if (var_executado == 'Atacado') {
            $("#insereAvancoFisicoObra").hide();
            $("#insereavancofisicoexecutado").hide();
            $("#insereavancofisicoexecutadoanterior").hide();
            $("#campoPaiExecutado").empty();
            $("#campoPaiExecutado").hide();
            $('#cadastraExecucao').hide();
            $('#campoPai').empty();
            $('#campoPai').show();
        }
        if (var_executado == 'Executado') {
            $("#insereAvancoFisicoObra").hide();
            $("#insereavancofisicoexecutadoanterior").hide();
            $("#campoPaiExecutado").empty();
            $("#campoPaiExecutado").show();
            $('#cadastraExecucao').show();
            $('#campoPai').empty();
            $('#campoPai').hide();
            //--------------------------------------------
            if (document.getElementById) {
                var dt = $("#datepicker").datepicker('getDate');
                if (dt.toString() == "Invalid Date") {
                    $("#datepicker").datepicker("setDate", new Date());
                    return;
                }
                var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

            }
            $('#tableAvancoexecutado').dataTable({
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
                "sAjaxSource": "",
                "fnServerParams": function (aoData) {
                    aoData.push(
                            {"name": "eixo", "value": var_eixo},
                            {"name": "servico", "value": var_servico},
                            {"name": "periodo", "value": termo}
                    );
                },
                "aoColumns": [
                    {data: 'id'},
                    {data: 'eixo'},
                    {data: 'servico'},
                    {data: 'status_atacado'},
                    {data: 'km_inicial_atacado'},
                    {data: 'km_final_atacado'},
                    {data: 'extensao_atacado'},
                    {data: 'adicionar'}
                ]
            });
            //--------------------------------------------
        }
        if (var_executado == 'Executado pelo contrato anterior') {
            $("#insereAvancoFisicoObra").hide();
            $("#insereavancofisicoexecutado").hide();
            $("#campoPaiExecutado").empty();
            $("#campoPaiExecutado").hide();
            $('#cadastraExecucao').hide();
            $('#campoPai').empty();
            $('#campoPai').show();
        }
    }
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function adicionaCamposKm(obra, servico){
         if ($('#eixo').find(":selected").text() == 'Selecione' || $('#servico').find(":selected").text() == 'Selecione' || $('#servico').find(":selected").text() == 'Sem Serviço Publicado Obra'|| $('#status').find(":selected").text() == 'Selecione') {
            $.notify('Falha,campos obrigatótios', "warning");
        } else {
            if ($("#status").val() == "Atacado") {
                $("#insereAvancoFisicoObra").show();

            } else if ($("#status").val() == "Executado pelo contrato anterior") {
                $("#insereavancofisicoexecutadoanterior").show();
            }
//------------------------------------------------------------------------------------------------------
    var medicao;
    var inp_user;
    
    if (obra == 1){
            medicao = '%';
            inp_user  =  medicao + " Total";
        }
  
    if ( (obra == 2 && servico == 4) || (obra == 2 && servico == 8) ){
            medicao = 'KM';
            inp_user  =  medicao + " Total";
        }
        if( (obra == 2 && servico == 5) || ( obra == 2 && servico == 6 ) || ( obra == 2 && servico == 7 ) ){
            medicao ='M³';
            inp_user  =  medicao + " Total";
        }
         
    if ((obra == 3 && servico == 3)  ||  (obra == 3 && servico == 7) ){
            medicao = 'KM';
            inp_user  =  medicao + " Total";

        }
            if (obra == 3 && servico == 4){
                medicao = 'M³';
                inp_user  =  medicao + " Total";
            }   
            if (obra == 3 && servico == 5){
                medicao = '%';
                inp_user  =  medicao + " Total";
            }  
            if (obra == 3 && servico == 6){
                medicao = 'SN';
                inp_user  =  "Sim ou Não" ;
            }
    
    if (obra == 4 && servico == 3){
            medicao = 'KM';
            inp_user  =  medicao + " Total";
        }
    
    if (obra == 5){
            medicao = '%';
            inp_user  =  medicao + " Total";
        }
    
    if ( (obra == 6 && servico == 2) || ( obra == 6 && servico == 3) || ( obra == 6 && servico == 6) || ( obra == 6 && servico == 8) ){
            medicao = 'KM';
            inp_user  =  medicao + " Total";
        } 
        if ( (obra == 6 && servico == 4) || ( obra == 6 && servico == 5) || ( obra == 6 && servico == 7) || ( obra == 6 && servico == 9)) {
            medicao = 'UNID.';
            inp_user  =  medicao + " Total";
        }
    
    if(obra == 7){
        medicao = '%';
        inp_user  =  medicao + " Total";
        }
    
    if(obra == 8){
        medicao = 'UNID.';
        inp_user  =  medicao + " Total";
        }
    
    if(obra == 9){
        medicao = '%';
        inp_user  =  medicao + " Total";
        }
//--------------------------------------------------------------

            for (var numero = 1; numero <= 1; numero++) {
                if (!$("#filho" + numero)[0]) {
                    $("#campoPai").append(
                            "<div class='row form-group' id='filho" + numero + "'>" +
                            "   <div class='col-md-3'>" +
                        "           <label>"+(inp_user)+" :</label><input class='form-control' type='text' id='valor_final" + numero + "' name='valor_final[]'  onkeydown='FormataMoeda(this, 10, event)' onkeypress='return maskKeyPress(event)' >" +
                            "   </div>" +
                            "   <div class='col-md-3'>" +
                        "           <label>&nbsp;</label><input  class='btn btn-block btn-info' type='button' onclick='removerCampo(" + numero + ")' value='Remover'>" +
                            "   </div>" +
                            "</div>"
                            );
                    qtdeCampos++;
                }
                $('#medicao').val(medicao);
                $("#qtdeCampos").val(qtdeCampos);
            }
            if (qtdeCampos == 1) {
                $("input[name='btnAdiciona']").attr('disabled', true);
                qtdeCampos = 0;
            } else {
                $("input[name='btnAdiciona']").attr('disabled', false);
            }

        }
    }
//---------------------------------------------------------------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function removerCampo(id) {

    var objPai = document.getElementById("campoPai");
    var objFilho = document.getElementById("filho" + id);
    //Removendo o DIV com id específico do nó-pai:
    var removido = objPai.removeChild(objFilho);
    qtdeCampos--;
    $("#insereAvancoFisicoObra").hide();
    $("#insereavancofisicoexecutadoanterior").hide();

   
    }
//-----------------------------------------------------Vericar se ja tem registro no banco------------------------------------------------------------------------------------------------------------------------------------------------------------------
    function avancoaquaviarioatacado() {
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
    //------------------------------------------------------------------------------------------------------------------------------
        
    var medicao = $("#medicao").val();
    var id_obra = $("#obra").val();
    var id_servico = $("#servico").val();
    var final = $("#valor_final" + 1).val();
       
        if(final == ''){
            document.getElementById("valor_final" + 1).style.borderColor = 'red';
            $.notify("Ocorreu um erro [CAMPO VAZIO!]", "warning");
            return false;
            }else {
            document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
        }
        //----------------------------------------------------------------------------------------------// 
        if (medicao == '%'){
            nan = $("#valor_final" + 1).val().replace('.','');
            var res = nan.replace(',','.');
            if(res > 100.00){
                   document.getElementById("valor_final" + 1).style.borderColor = 'red';
                    $.notify("Ocorreu um erro [A % total não deve ser superior a 100%!]", "warning");
                    return false;
            }else{
                    document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
                }
                //----------------------------------------------------------------------------------------------// 
            }  
    //------------------------------------------------------------------------------------------------------------------------------
         var serializedData = $("#formularioAvancoFisicoObra").serializeArray();
         serializedData.push(termo);
       $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoVerificaAtacDaq',
                data: serializedData,
                dataType: 'json',
                success: function (data) { 
                if (data.conte_atacado > 0) {
                    
                    document.getElementById("valor_final"+ 1).style.borderColor = "red"; 
                    $.notify('Este serviço já foi concluido!', "warning");
                }else{
                   
                    document.getElementById("valor_final"+ 1).style.borderColor = "gray";   
                    
                   insereAvancoFisicoObra(); 
                }
                    
                }, error: function (data) {
                   $.notify('Falha na consulta', "warning");
                   
                }
            });
    }
//-----------------------------------------------INSERIR ATACADO-------------------------------------------------------------------------------
function insereAvancoFisicoObra() { 
    var termo = new Object();
    if (document.getElementById) {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
    }
//------------------------------------------------------------------------------------------------------------------------------   
    var medicao = $("#medicao").val();
    var id_obra = $("#obra").val();
    var id_servico = $("#servico").val();
    var final = $("#valor_final" + 1).val();
       
        if(final == ''){
            document.getElementById("valor_final" + 1).style.borderColor = 'red';
            $.notify("Ocorreu um erro [CAMPO VAZIO!]", "warning");
            return false;
            }else {
            document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
        }
        //----------------------------------------------------------------------------------------------//
        var Validar = Cronograma_fisico(id_obra, id_servico, final );
        if (Validar != true) {
            document.getElementById("valor_final" + 1).style.borderColor = 'red';
            $.notify(Validar.mensagem, "warning");
            return false;
        }else{
            if ($("#valor_final" + 1).length){ 
             document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
            }
        }
        //----------------------------------------------------------------------------------------------// 
        if (medicao == '%'){
            nan = $("#valor_final" + 1).val().replace('.','');
            var res = nan.replace(',','.');
            if(res > 100.00){
                   document.getElementById("valor_final" + 1).style.borderColor = 'red';
                    $.notify("Ocorreu um erro [A % total não deve ser superior a 100%!]", "warning");
                    return false;
            }else{
                    document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
                }
                //----------------------------------------------------------------------------------------------// 
            }  
    //----------------------------------------------------------------------------------------------------------------------------------------
    var serializedData = $("#formularioAvancoFisicoObra").serializeArray();
    serializedData.push(termo);
    //----------------------------------------------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------------------------------------------
    bootbox.confirm("Confirmar operação [INSERIR AVANÇO FISÍCO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoInsereAtacadoDaq',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $('#cadastraAvancoFisicoObra').hide();
                    $('#novo_avancofisico').show();
                    $.notify('Cadastrado com sucesso!', "success");
                    var tblAvancoFisico = $("#tableAvancoFisico").DataTable();
                    tblAvancoFisico.ajax.reload();
                    document.getElementById("datepicker").disabled = false;
                    $('#btnInclusao').show();
                    $('#searchdate').hide();
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                }
            });
        }
    });
}

function Cronograma_fisico(id_obra, id_servico, final) {
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
        url: base_url + 'index_cgop.php/AvancoFisicoCronValidaDaq?periodo='+termo,
        data: {
            id_obra: id_obra, id_servico: id_servico, final:final
        },
        dataType: 'json',
        async: false,
        success: function (data) {
            retorno = data;
        }, error: function (data) {
         
        }
    });
    return retorno;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnNoAtividade() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

    }
    //----------------------------------------------------------------------------------------------------------------------------------------
    bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADE NO MÊS]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoInsereAtividadeDaq',
                data: {
                    periodo: termo
                },
                dataType: 'json',
                success: function (data) {

                    $('#cadastraAvancoFisicoObra').hide();
                    $('#novo_avancofisico').show();
                    $.notify('Cadastrado com sucesso!', "success");
                    table_naohouveatividademes();
                   
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                    
                }
            });
        }
    });
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function executado(id, inicial, final, periodo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/AvancoFisicoMedidaExecDaq',
        data: {
            id: id, inicial: inicial, final: final, periodo: periodo
        },
        dataType: 'json',
        async: false,
        success: function (data) {
            retorno = data;
        }, error: function (data) {
           
        }
    });
    return retorno;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function trashmedicaoExecutado(id) {
    if (!id) {
        $.notify('[AINDA NÃO FOI EXECUTADO] não é possível excluir!', "warning");
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR EXECUTADO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#spinner').hide();
                        $('#cadastraAvancoFisicoObra').hide();
                        $('#novo_avancofisico').show();
                        $.notify('[EXCLUIR EXECUTADO] efetuado com  sucesso!', "success");
                         var tableAvancoFisico = $("#tableAvancoFisico").DataTable();
                        tableAvancoFisico.ajax.reload();
                        
                        var tableAvancoFisicoConcluidos = $("#tableAvancoFisicoConcluidos").DataTable();
                        tableAvancoFisicoConcluidos.ajax.reload();
                        
                    }, error: function (data) {
                        $('#spinner').hide();
                        $.notify('Falha [EXCLUIR EXECUTADO]', "warning");
                        
                    }
                });
            }
        });
    }
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function trashmedicaoExecutado(id) {
        bootbox.confirm("Confirmar operação [EXCLUIR]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/AvancoFisicoTrashExecDaq',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#spinner').hide();
                        $('#cadastraAvancoFisicoObra').hide();
                        $('#novo_avancofisico').show();
                        $.notify('[EXCLUIR EXECUTADO] efetuado com  sucesso!', "success");
                                                
                        var tableExecutados = $("#tableExecutados").DataTable();
                        tableExecutados.ajax.reload();
                        
                        var tableAvancoFisico = $("#tableAvancoFisico").DataTable();
                        tableAvancoFisico.ajax.reload();
                        
                        var tableAvancoFisicoConcluidos = $("#tableAvancoFisicoConcluidos").DataTable();
                        tableAvancoFisicoConcluidos.ajax.reload();
                        
                    }, error: function (data) {
                        $('#spinner').hide();
                        $.notify('Falha [EXCLUIR EXECUTADO]', "warning");
                        
                    }
                });
            }
        });
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function trashExecutadoConcluido(id, id_tabular) {
        bootbox.confirm("Confirmar operação [EXCLUIR]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/AvancoFisicoTrashConcluiDaq',
                    data: {
                        id: id,
                        id_tabular: id_tabular
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#spinner').hide();
                        $('#cadastraAvancoFisicoObra').hide();
                        $('#novo_avancofisico').show();
                        $.notify('[EXCLUIR EXECUTADO] efetuado com  sucesso!', "success");
                                                
                        var tableVisualizarExecutadosConcluido = $("#tableVisualizarExecutadosConcluido").DataTable();
                        tableVisualizarExecutadosConcluido.ajax.reload();
                        
                        var tableAvancoFisico = $("#tableAvancoFisico").DataTable();
                        tableAvancoFisico.ajax.reload();
                        
                        var tableAvancoFisicoConcluidos = $("#tableAvancoFisicoConcluidos").DataTable();
                        tableAvancoFisicoConcluidos.ajax.reload();
                        
                    }, error: function (data) {
                        $('#spinner').hide();
                        $.notify('Falha [EXCLUIR EXECUTADO]', "warning");
                    }
                });
            }
        });
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function atacadodaqtrash(id) {
$.ajax({
    type: 'POST',
    url: base_url + 'index_cgop.php/AvancoFisicoRetornExecutadoDaq',
    data: {
        id: id
    },
    dataType: 'json',
    success: function (data) {
      if (data.conte_executado == 'false'){
                bootbox.confirm("Confirmar operação [EXCLUIR ATACADO]?", function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'index_cgop.php/AvancoFisicoTrashAtacadoDaq',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                $('#spinner').hide();
                                $('#cadastraAvancoFisicoObra').hide();
                                $('#novo_avancofisico').show();
                                $.notify('[EXCLUIR ATACADO] efetuado com  sucesso!', "success");
                                var tableAvancoFisico = $("#tableAvancoFisico").DataTable();
                                    tableAvancoFisico.ajax.reload();

                                var tableAvancoFisicoConcluidos = $("#tableAvancoFisicoConcluidos").DataTable();
                                    tableAvancoFisicoConcluidos.ajax.reload();
                                 table_naohouveatividademes();

                                
                            }, error: function (data) {
                                $('#spinner').hide();
                                $.notify('Falha [EXCLUIR ATACADO]', "warning");
                                 
                            }
                        });
                    }
                });
      }else{
          $.notify('Para excluir trecho atacado o mesmo não poderá ter segmento executado.', "warning");
          return false;
      }
    }, error: function (data) {
        $('#spinner').hide();
        $.notify('Falha [EXCLUIR ATACADO]', "warning");
        
    }
});  
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function NaoHouveAtividadedaq(id) {
    bootbox.confirm("Confirmar operação [EXCLUIR]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoTrashAtividadeDaq?id=' + id,
                dataType: 'json',
                success: function (data) {
                    $.notify('[EXCLUIR] efetuado com  sucesso!', "success");
                   table_naohouveatividademes();
                }, error: function (data) {
                    $.notify('Falha na operação', "warning");
                    
                }
            });
        }
    });
}
//----------------------------------------------------CONTRATO ANTERIOR----------------------------------------------------------------------------------------------------------------------------------------------------------------------
function insereavancofisicoexecutadoanterior() { 
    var termo = new Object();
    if (document.getElementById) {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
    }
      var serializedData = Array();
      var serializedData = $("#formularioAvancoFisicoObra").serializeArray();
      serializedData.push(termo);
    //------------------------------------------------------------------------------------------------------------------------------------
    
    var medicao = $("#medicao").val();
    var id_obra = $("#obra").val();
    var id_servico = $("#servico").val();
    var final = $("#valor_final" + 1).val();
       
    if(final == ''){
        document.getElementById("valor_final" + 1).style.borderColor = 'red';
        $.notify("Ocorreu um erro [CAMPO VAZIO!]", "warning");
        return false;
        }else {
        document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
    }
    //----------------------------------------------------------------------------------------------//
    var Validar = Cronograma_fisico(id_obra, id_servico, final );
    if (Validar != true) {
        document.getElementById("valor_final" + 1).style.borderColor = 'red';
        $.notify(Validar.mensagem, "warning");
        return false;
    }else{
        if ($("#valor_final" + 1).length){ 
         document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
        }
    }
    //----------------------------------------------------------------------------------------------// 
    if (medicao == '%'){
        nan = $("#valor_final" + 1).val().replace('.','');
        var res = nan.replace(',','.');
        if(res > 100.00){
               document.getElementById("valor_final" + 1).style.borderColor = 'red';
                $.notify("Ocorreu um erro [A % total não deve ser superior a 100%!]", "warning");
                return false;
        }else{
                document.getElementById("valor_final" + 1).style.borderColor = '#d2d6de';
            }
            //----------------------------------------------------------------------------------------------// 
        }   
//------------------------------------------------------------------------------------------------------------------------------------
       
           //-------------------------------------------------------------------------------------------------
              bootbox.confirm("Confirmar operação [INSERIR AVANÇO FISÍCO EXECUTADO PELO CONTRATO ANTERIOR]?", function (result) {
                    if (result === true) {
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'index_cgop.php/AvancoFisicoInsereAnteriorDaq',
                            data: serializedData,
                            dataType: 'json',
                            success: function (data) {
                                $('#cadastraAvancoFisicoObra').hide();
                                $('#novo_avancofisico').show();
                                $.notify('Cadastrado com sucesso!', "success");
                                tableAvancoFisicoContratoAnterior();
                                document.getElementById("datepicker").disabled = false;
                                $('#btnInclusao').show();
                                $('#searchdate').hide();
                            }, error: function (data) {
                                $.notify('Falha no cadastro', "warning");
                            }
                        });
                    }
                });//-------------------------------------------------------------------------------------------------                   
            }
         
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function trashContratoAnterior(id) {
    bootbox.confirm("Confirmar operação [EXCLUIR [ Trechos Concluídos No Contrato Anterior ]]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/AvancoFisicoTrashAnteriorDaq?id=' + id,
                dataType: 'json',
                success: function (data) {
                    $.notify('[EXCLUIR] efetuado com  sucesso!', "success");
                   tableAvancoFisicoContratoAnterior();
                }, error: function (data) {
                    $.notify('Falha na operação', "warning");
                    
                }
            });
        }
    });
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function tableAvancoFisicoContratoAnterior(){
     $('#contrato_anterior').hide();
     var termo = new Object();
    if (document.getElementById) {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
    } 
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/AvancoFisicoRecuperaAnteriorDaq',
        dataType: 'json',
        success: function (data) {
                if (data.conte >= 1){
                      $('#contrato_anterior').show();
                      $('#tableAvancoFisicoContratoAnterior').dataTable({
                        "bProcessing": false,
                        "bFilter": true,
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
                        "sAjaxSource": base_url + "index_cgop.php/AvancoFisicoRecuperaAnteriorDaq",
                        "fnServerParams": function (aoData) {
                            aoData.push({"name": "periodo", "value": termo});
                        },
                        "aoColumns": [


                            {data: 'eixo', "sClass": "text-center"},
                            {data: 'obra', "sClass": "text-center"},
                            {data: 'servico', "sClass": "text-center"},
                            {data: 'tipo', "sClass": "text-center"},
                            {data: 'versao', "sClass": "text-center"},
                            {data: 'val_final_atacado', "sClass": "text-center"},
                            {data: 'atacado_em', "sClass": "text-center"},
                            {data: 'executado_em', "sClass": "text-center"},
                            {data: 'usuario', "sClass": "text-center"},
                            {data: 'data', "sClass": "text-center"},
                            {data: 'acoes', "sClass": "text-center"}

                        ]
                    });
                }else{
                    $('#contrato_anterior').hide();
                }
           
        }, error: function (data) {
            $.notify('Falha na consulta contrato anterior', "warning");
            
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function returnExecutadoaquaviario(id){
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/AvancoFisicoValidaExecDaq?id=' + id,
        dataType: 'json',
        success: function (data) {
            if(data.concluido == 1){
                 $("#modalExecutado").modal("hide");
                var tableExecutados = $("#tableExecutados").DataTable();
                tableExecutados.ajax.reload();

                var tableAvancoFisico = $("#tableAvancoFisico").DataTable();
                tableAvancoFisico.ajax.reload();

                var tableAvancoFisicoConcluidos = $("#tableAvancoFisicoConcluidos").DataTable();
                tableAvancoFisicoConcluidos.ajax.reload(); 
            }
        }, error: function (data) {
            $.notify('Falha na operação', "warning");
            
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
