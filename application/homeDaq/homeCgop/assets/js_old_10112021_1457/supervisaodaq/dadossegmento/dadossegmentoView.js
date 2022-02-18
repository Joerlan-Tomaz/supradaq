//######################################################################################################################################################################################################################## 
//# DNIT
//# historicoView.js
//# Desenvolvedor:Jordana de Alencar
//# Data: 02/09/2019
//########################################################################################################################################################################################################################
$().ready(function () {
    $.ajaxSetup({ cache: false });   
    
   //--------------------------------------------------------------------------
  //CKEDITOR.replace("trecho", {height: 250});
   //--------------------------------------------------------------------------
   $(".mostrar").hide();
   $(".ocultar").click(function () {
       $(this).next(".mostrar").slideToggle(600);
   });
   $('#btnPesquisar').hide();
   //--------------------------------------------------------------------------
   $('#novo_dados').show();
   $('#cadastroHistorico').hide();
   //--------------------------------------------------------------------------
   //--------------------------------------------------------------------------
   $('#datepicker').on("changeDate", function () {
      $.ajaxSetup({ cache: false });
      recuperaHistorico();
   });
   //--------------------------------------------------------------------------
   recuperaHistorico();
   //--------------------------------------------------------------------------
   $("#btnPesquisar").click(function () {
     btnPesquisar();
       $("#btnPesquisar").hide();
         $("#btnVoltar").show();
   });
   //--------------------------------------------------------------------------
   $("#btnInclusao").click(function () {
           $('#novo_dados').hide();
           $('#cadastroHistorico').show();
           document.getElementById("datepicker").disabled = true;
            //CKEDITOR.instances['trecho'].setData("");
           $("#id_resumo").val("");
           $("#btnPesquisar").show();
           $('#btnVoltar').hide();
           $('#btnInclusao').hide();
   });
   //--------------------------------------------------------------------------
   $("#insereDados").click(function () {
        //------------------ Validação de campos vazios ----------------------------

        if ($('#kminicial').val() == '') {
            $.notify('Campo [KM Inicial / % ] é obrigatório!', "warning");
            return false;
        }
        
        if ($('#kmfinal').val() == '') {
            $.notify('Campo [KM Final / % ] é obrigatório!', "warning");
            return false;
        }

        if ($('#tipo_documento').val() == '') {
            $.notify('Campo [UF] é obrigatório!', "warning");
            return false;
        }

        if ($('#trecho').val() == '') {
            $.notify('Campo [Trecho] é obrigatório!', "warning");
            return false;
        }

        if ($('#kminicialS').val() == '') {
            $.notify('Campo [Km Inicial] é obrigatório!', "warning");
            return false;
        }

        if ($('#kmfinalS').val() == '') {
            $.notify('Campo [Km Final] é obrigatório!', "warning");
            return false;
        }


       //------------------ Verificação de campos ----------------------------
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
      
       //---------------- Validação de formulario -----------------------------
       var serializedData = new Object();
       serializedData = $("#formularioConfigHistorico").serializeArray();
       
       serializedData.push(termo);
       //----------------------------------------------------------------------
       bootbox.confirm("Confirmar operação [INSERIR Dados Segmento]?", function (result) {
           if (result == true) {
               $.ajax({
                   type: 'POST',
                   url: 'homeDaq/Supervisaodaq/DadosSegmento/DadosSegmento/insereResumo',
                   data: serializedData,
                   dataType: 'json',
                   success: function (data) {
                       $.notify('Cadastrado com sucesso!', "success");
                      // CKEDITOR.instances['trecho'].setData();
                       document.getElementById("datepicker").disabled = false;
                       $('#novo_dados').show();
                       $('#cadastroHistorico').hide();
                       $("#id_resumo").val("");
                       $('#btnInclusao').show();
                       btnPesquisar();
                       var table = $("#tabeladadossegmento").DataTable();
                       table.ajax.reload();
                   }, error: function (data) {
                       $.notify('Falha no cadastro', "warning");
                   }
               });
           }
       });
   });
     //--------------------------------------------------------------------------
    $("#btnVoltar").click(function () {
        $("#exibesupervisaocont").empty();
        $("#exibesupervisaocont").load("homeDaq/Supervisaodaq/Supervisaodaqctr/retornaConfiguracao").slideUp(3).delay(3).fadeIn("slow");
    });
});

function btnPesquisar() {
    $('#novo_dados').show();
    $("#cadastroHistorico").hide();
    $("#btnInclusao").show();
    $("#btnPesquisar").hide();
   
     recuperaHistorico();
}
//------------------------------------------------------------------------------
function recuperaHistorico() {
 $("#btnVoltar").show();
//-----------------------------------------------------------
       if (document.getElementById) {
           var dt = $("#datepicker").datepicker('getDate');
           if (dt.toString() === "Invalid Date") {
               $("#datepicker").datepicker("setDate", new Date());
               return;
           }
           var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
       }
       //------------------ Verificação de campos -----------------------------

    var table = $('#tabeladadossegmento').DataTable();
    table.destroy();
    $('#tabeladadossegmento').dataTable({
        "bProcessing": true,
        "bFilter": true,
        "bInfo": true,
        "bLengthChange": true,
        "bPaginate": true,
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
        "sAjaxSource": "homeDaq/Supervisaodaq/DadosSegmento/DadosSegmento/recuperaResumo?periodo="+termo,
        "aoColumns": [
            {data: 'KMINICIAL', "sClass": "text-center", "width": "20%"},
            {data: 'KMFINAL', "sClass": "text-center", "width": "20%"},
            {data: 'UF', "sClass": "text-center", "width": "10%"},
            {data: 'DESCRICAO', "sClass": "text-center", "width": "10%"},
            {data: 'NOME', "sClass": "text-center", "width": "15%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "10%"},
            {data: 'ACAO', "sClass": "text-center", "width": "5%"}
            
        ]
    });
}
//------------------------------------------------------------------------------
function modalStatus(id_resumo) {
    $("#modalStatus").modal("show");
    $.ajax({
        type: "POST",
        url: "homeDaq/Supervisaodaq/DadosSegmento/DadosSegmento/modalStatus",
        data: {id_resumo: id_resumo},
        dataType: "json",
        success: function (data) {
            $("#status_modal").html(data.descricao);
        }
    });
}
//-----------------------------------------------------------------------------

function editarResumo(id_resumo) { 
    $.ajax({
        type: 'POST',
        url: 'homeDaq/Supervisaodaq/Historico/Historico/editarResumo',
        data: {id_resumo: id_resumo},
        dataType: 'json',
        success: function (data) {
            $('#btnInclusao').hide();
            $("#btnPesquisar").show();
            $("#btnVoltar").hide();
            $('#novo_dados').hide();
            $('#cadastroHistorico').show();
            document.getElementById("datepicker").disabled = true;
            var resumo = data.resumo;
            $("#id_resumo").val(data.id_resumo);
            // CKEDITOR.instances['descricao_historico'].setData(resumo);
        }, error: function (data) {
            $.notify('Falha na alteração', "warning");
        }
    });
}

//------------------------------------------------------------------------------
function excluirResumo(id_resumo) {
    bootbox.confirm("Confirmar operação [EXCLUIR DADOS SEGMENTO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: 'homeDaq/Supervisaodaq/DadosSegmento/DadosSegmento/excluirResumo',
                data: {id_resumo: id_resumo},
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluido com sucesso!', "success");
                    var tableHistorico = $("#tabeladadossegmento").DataTable();
                    tableHistorico.ajax.reload();
                }, error: function (data) {
                    $.notify('Falha na exclusão', "warning");
                }
            });
        }
    });
}
//dados segmento
