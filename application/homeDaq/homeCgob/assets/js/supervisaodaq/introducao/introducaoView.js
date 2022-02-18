//######################################################################################################################################################################################################################## 
//# DNIT
//# introducaoView.js
//# Desenvolvedor:Jordana Alencar
//# Data: 17/09/2019
//########################################################################################################################################################################################################################
$().ready(function () {
    $.ajaxSetup({ cache: false });   
    $('#searchdate').hide();
   //--------------------------------------------------------------------------
   CKEDITOR.replace('descricao_introducao', {
       height: 250
   });
   //--------------------------------------------------------------------------
   $(".mostrar").hide();
   $(".ocultar").click(function () {
       $(this).next(".mostrar").slideToggle(600);
   });
   //--------------------------------------------------------------------------
   $('#novo_introducao').show();
   $('#cadastroIntroducao').hide();
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
       $('#novo_introducao').show();
       document.getElementById("datepicker").disabled = false;
       $('#cadastroIntroducao').hide();
       $('#searchdate').hide();
       $('#btnInclusao').show();
   });
   //--------------------------------------------------------------------------
   $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
           $('#novo_introducao').hide();
           $('#cadastroIntroducao').show();
           document.getElementById("datepicker").disabled = true;
           CKEDITOR.instances['descricao_introducao'].setData("");
           $("#id_resumo").val("");
           $('#searchdate').show();
           $('#btnInclusao').hide();
        }
   });
   //--------------------------------------------------------------------------
   $("#insereIntroducao").click(function () {
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
       var introducao = CKEDITOR.instances['descricao_introducao'].getData();
       if (introducao == "") {
           if (introducao == '') {
               document.getElementById('3').style.borderColor = 'red';
           } else {
               document.getElementById('descricao_introducao').style.borderColor = '#d2d6de';
           }
           $.notify("Informe os campos necessários", "warning");
           return false;
       }
       document.getElementById('descricao_introducao').style.borderColor = '#d2d6de';
       //---------------- Validação de formulario -----------------------------
       var serializedData = new Object();
       serializedData = $("#formularioConfigIntroducao").serializeArray();
       serializedData[1].value = introducao;
       serializedData.push(termo);
       //----------------------------------------------------------------------
       bootbox.confirm("Confirmar operação [INSERIR INTRODUÇÃO]?", function (result) {
           if (result == true) {
               $.ajax({
                   type: 'POST',
                   url: base_url + 'index_cgob.php/IntroducaoInsereDaq',
                   data: serializedData,
                   dataType: 'json',
                   success: function (data) {
                       $.notify('Cadastrado com sucesso!', "success");
                       CKEDITOR.instances['descricao_introducao'].setData();
                       document.getElementById("datepicker").disabled = false;
                       $('#novo_introducao').show();
                       $('#cadastroIntroducao').hide();
                       $("#id_resumo").val("");
                       $('#btnInclusao').show();
                       $('#searchdate').hide();
                       var table = $("#tabelaIntroducao").DataTable();
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

    var table = $('#tabelaIntroducao').DataTable();
    table.destroy();
    $('#tabelaIntroducao').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "pageLength": 100,
        "destroy": true,
        "bSort": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 100,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/IntroducaoRecuperaDaq?periodo="+termo,
        "aoColumns": [
            {data: 'RESUMO', "sClass": "text-justify", "width": "60%"},
            {data: 'NOME', "sClass": "text-center", "width": "15%"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center", "width": "15%"},
            {data: 'ACAO', "sClass": "text-center", "width": "10%"}
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
        url: base_url + 'index_cgob.php/IntroducaoEditarDaq',
        data: {id_resumo: id_resumo},
        dataType: 'json',
        success: function (data) {
            $('#btnInclusao').hide();
            $('#searchdate').show();
            $('#novo_introducao').hide();
            $('#cadastroIntroducao').show();
            document.getElementById("datepicker").disabled = true;
            var resumo = data.resumo;
            $("#id_resumo").val(data.id_resumo);
            CKEDITOR.instances['descricao_introducao'].setData(resumo);
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
    bootbox.confirm("Confirmar operação [EXCLUIR INTRODUÇÃO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgob.php/IntroducaoExcluirDaq',
                data: {id_resumo: id_resumo},
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluido com sucesso!', "success");
                    var tableIntroducao = $("#tabelaIntroducao").DataTable();
                    tableIntroducao.ajax.reload();
                }, error: function (data) {
                    $.notify('Falha na exclusão', "warning");
                }
            });
        }
    });
  }
}
