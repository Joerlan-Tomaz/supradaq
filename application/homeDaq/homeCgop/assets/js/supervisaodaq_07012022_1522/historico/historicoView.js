//######################################################################################################################################################################################################################## 
//# DNIT
//# historicoView.js
//# Desenvolvedor:Jordana de Alencar
//# Data: 02/09/2019
//########################################################################################################################################################################################################################
$().ready(function () {
    $.ajaxSetup({ cache: false });   
    $('#searchdate').hide();
   //--------------------------------------------------------------------------
   CKEDITOR.replace('descricao_historico', {
       height: 250
   });
   //--------------------------------------------------------------------------
   $(".mostrar").hide();
   $(".ocultar").click(function () {
       $(this).next(".mostrar").slideToggle(600);
   });
   //--------------------------------------------------------------------------
   $('#novo_historico').show();
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
   $("#searchdate").click(function () {
    recuperaHistorico();
    document.getElementById("datepicker").disabled = false;
       $('#novo_historico').show();
       $('#cadastroHistorico').hide();
       $('#searchdate').hide();
       $('#btnInclusao').show();
   });
   //--------------------------------------------------------------------------
   $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
           $('#novo_historico').hide();
           $('#cadastroHistorico').show();
           document.getElementById("datepicker").disabled = true;
           CKEDITOR.instances['descricao_historico'].setData("");
           $("#id_resumo").val("");
           $('#searchdate').show();
           $('#btnInclusao').hide();
          }
   });
   //--------------------------------------------------------------------------
   $("#insereHistorico").click(function () {
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
       //------------------ Verificação de campos -----------------------------
       var resumo = CKEDITOR.instances['descricao_historico'].getData();
       if (resumo == "") {
           if (resumo == '') {
               document.getElementById('descricao_historico').style.borderColor = 'red';
           } else {
               document.getElementById('descricao_historico').style.borderColor = '#d2d6de';
           }
           $.notify("Informe os campos necessários", "warning");
           return false;
       }
       document.getElementById('descricao_historico').style.borderColor = '#d2d6de';
       //---------------- Validação de formulario -----------------------------
       var serializedData = new Object();
       serializedData = $("#formularioConfigHistorico").serializeArray();
       serializedData[1].value = resumo;
       serializedData.push(termo);
       //----------------------------------------------------------------------
       bootbox.confirm("Confirmar operação [INSERIR HISTÓRICO]?", function (result) {
           if (result == true) {
               $.ajax({
                   type: 'POST',
                   url: base_url + 'index_cgop.php/ResumoInsereDaq',
                   data: serializedData,
                   dataType: 'json',
                   success: function (data) {
                       $.notify('Cadastrado com sucesso!', "success");
                       CKEDITOR.instances['descricao_historico'].setData();
                       document.getElementById("datepicker").disabled = false;
                       $('#novo_historico').show();
                       $('#cadastroHistorico').hide();
                       $("#id_resumo").val("");
                       $('#btnInclusao').show();
                       $('#searchdate').hide();
                       var table = $("#tabelaHistorico").DataTable();
                       table.ajax.reload();
                   }, error: function (data) {
                       $.notify('Falha no cadastro', "warning");
                   }
               });
           }
       });
   });
});
//------------------------------------------------------------------------------
function recuperaHistorico() {

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

    var table = $('#tabelaHistorico').DataTable();
    table.destroy();
    $('#tabelaHistorico').dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/ResumoRecuperaDaq?periodo="+termo,
        "aoColumns": [
            {data: "RESUMO", "sClass": "text-justify", "width": "70%"},
            {data: "NOME", "sClass": "text-center", "width": "10%"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
            {data: "ACAO", "sClass": "text-center", "width": "10%"}
        ]
    });
}

//------------------------------------------------------------------------------
function editarResumo(id_resumo) {
  relatorio = confereRelatorio();
     if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else { 
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/ResumoEditarDaq',
        data: {id_resumo: id_resumo},
        dataType: 'json',
        success: function (data) {
            $('#btnInclusao').hide();
            $('#searchdate').show();
            $('#novo_historico').hide();
            $('#cadastroHistorico').show();
            document.getElementById("datepicker").disabled = true;
            var resumo = data.resumo;
            $("#id_resumo").val(data.id_resumo);
            CKEDITOR.instances['descricao_historico'].setData(resumo);
        }, error: function (data) {
            $.notify('Falha na alteração', "warning");
        }
    });
  }
}

//------------------------------------------------------------------------------
function excluirHistorico(id_resumo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
    bootbox.confirm("Confirmar operação [EXCLUIR HISTÓRICO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/ResumoExcluirDaq',
                data: {id_resumo: id_resumo},
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluido com sucesso!', "success");
                    var tableHistorico = $("#tabelaHistorico").DataTable();
                    tableHistorico.ajax.reload();
                }, error: function (data) {
                    $.notify('Falha na exclusão', "warning");
                }
            });
        }
    });
  }
}
