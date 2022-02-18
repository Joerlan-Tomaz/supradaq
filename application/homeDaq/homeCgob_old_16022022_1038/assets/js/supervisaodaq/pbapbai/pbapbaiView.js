//######################################################################################################################################################################################## 
//# DNIT
//# pbapbiView.js
//# Desenvolvedor:jordana
//# Data: 10/10/2019 09:59
//########################################################################################################################################################################################
/*----------------------------------------------------------------------------*/
$().ready(function () { 
    CKEDITOR.replace("resumoPbaPbai", {height: 250});
    //--------------------------------------------------------------------------
    $("#novo_pbapbai").hide();
    $("#cadastroPbaPbai").hide();
    $("#searchdate").hide();   
    //--------------------------------------------------------------------------
    $("#datepicker").on("changeDate", function () {
        recuperaPbaPbai();
    });
    //--------------------------------------------------------------------------
    recuperaPbaPbai();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaPbaPbai();
        document.getElementById("btnInclusao").disabled = false;
         $("#searchdate").hide();
         $("#voltar").show();
         $('#btnInclusao').show();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
      //  relatorio = confereRelatorio();
      //  if (relatorio == 1) {
        //    mensagemRelatorioFechado();
      //  } else {
            document.getElementById("datepicker").disabled = true;
            $('#novo_pbapbai').hide();
            $('#cadastroPbaPbai').show();
            // populaPbaPbai();
            document.getElementById("pba").disabled = true;
            document.getElementById("pbai").disabled = true; 
            //populaPba();
            //populaPbai();
            $("#searchdate").show();
            $("#voltar").hide();
            $('#btnInclusao').hide();
            $('#inserePbaPbai').show();
            $('#editarPbaPbai').hide();
            //----------------------------------------------------
            $(".nomearquivo").text("");
            $('#pba').val("");
            $('#pbai').val("");
            CKEDITOR.instances["resumoPbaPbai"].setData(""); 

      //  }
    });
    //--------------------------------------------------------------------------
    // $("#inserePbaPbai").click(function () {
    //     inserePbaPbai();
    // });
    //--------------------------------------------------------------------------------------------------------------------------------------------------
    $("#editarPbaPbai").click(function () {
        alterarPbaPbai();
        $(".nomearquivo").text('');
    });
    //--------------------------------------------------------------------------
    $("#tipopbapabi").change(function () {
    if($("#tipopbapabi").val() == 'pba' && $("#tipopbapabi").val() != 'Selecione'){
        document.getElementById("pba").disabled = false;
        document.getElementById("pbai").disabled = true;
        $('#pbai').html("");
        populaPba(); 
    }else if($("#tipopbapabi").val() == 'pbai' && $("#tipopbapabi").val() != 'Selecione'){
        document.getElementById("pbai").disabled = false;
        document.getElementById("pba").disabled = true;
        $('#pba').html("");
         populaPbai();
    }else{ //--------------------------------------------------------------------------
        $('#pba').html("");
        $('#pbai').html("");
        document.getElementById("pba").disabled = true;
        document.getElementById("pbai").disabled = true;
        }
    });    
});
//------------------------------------------------------------------------------
function recuperaPbaPbai() {
    document.getElementById("datepicker").disabled = false;
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker("getDate");
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $("#novo_pbapbai").show();
    $("#cadastroPbaPbai").hide();
    $("#tablePbaPbai").dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/PbaPbaiRecuperaDaq?periodo="+termo,
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: "RESUMO", "sClass": "text-justify", "width": "40%"},
            {data: "ARQUIVO", "sClass": "text-center", "width": "15%"},
            {data: "PBA", "sClass": "text-center", "width": "10%"},
            {data: "PBAI", "sClass": "text-center", "width": "10%"},
            {data: "NOME", "sClass": "text-center", "width": "10%"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
            {data: "ACAO", "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirPbaPbai(id_pba_pbai, id_arquivo) {
    bootbox.confirm("Confirmar operação [EXCLUIR PBA / PBAI]?", function (result) {
        if (result === true) {
            $.ajax({
                type: "POST",
                url: base_url + "index_cgob.php/PbaPbaiExcluirDaq",
                data: {id_pba_pbai: id_pba_pbai, id_arquivo: id_arquivo},
                dataType: "json",
                success: function (data) {
                    $.notify("Excluido com sucesso!", "success");
                    var table = $("#tablePbaPbai").DataTable();
                    table.ajax.reload();
                }, error: function (data) {
                    $.notify("Falha na exclusão", "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function populaPba() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/PbaPbaiTipoPbaDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=pba]');
            servico.html('');
            servico.append('<option value="Selecione" selected >Selecione</option>');
            for (i = 0; i < data.id_pba.length; i++) {
                servico.append('<option value="' + data.id_pba[i] + '">' + data.desc_pba[i] + '</option>');
            }
        }
    });
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function populaPbai() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/PbaPbaiTipoPbaiDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=pbai]');
            servico.html('');
            servico.append('<option value="Selecione" selected >Selecione</option>');
            for (i = 0; i < data.id_pbai.length; i++) {
                servico.append('<option value="' + data.id_pbai[i] + '">' + data.desc_pbai[i] + '</option>');
            }
        }
    });
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function editarPbaPbai(id_pba_pbai, id_arquivo) {
    $('#hdn_pbapbai').val(id_pba_pbai); 
    $('#hdn_pbapbaiarquivo').val(id_arquivo);
    populaPba();
    $.ajax({
        type: "POST",
        url: base_url + "index_cgob.php/PbaPbaiEditarDaq",
        data: {id_pba_pbai: id_pba_pbai, id_arquivo: id_arquivo},
        dataType: "json",
        success: function (data) {
           
            document.getElementById("datepicker").disabled = true;
            $('#novo_pbapbai').hide();
            $('#cadastroPbaPbai').show();
            var pba = data.pba;
            if(pba != ''){
                $('#tipopbapabi').val("pba");
                $('#pba').val(data.pba);
                $('#pbai').html("");
                document.getElementById("pba").disabled = false;
                document.getElementById("pbai").disabled = true;
            }else{
                $('#tipopbapabi').val("pbai");
                populaPbai();
                $('#pbai').val(data.pbai);
                $('#pba').html("");
                document.getElementById("pbai").disabled = false;
                document.getElementById("pba").disabled = true;  
            }
            $("#searchdate").show();
            $("#voltar").hide();
            $(".nomearquivo").text(data.nomearquivo);
            $('#btnInclusao').hide();
            $('#inserePbaPbai').hide();
            $('#editarPbaPbai').show();
            //$('#pba').val(data.pba);
            //$('#pbai').val(data.pbai);
            CKEDITOR.instances["resumoPbaPbai"].setData(data.resumo); 
           
        }, error: function (data) {
            $.notify("Falha EDITAR", "warning");
        }
    });
       
}

$("#inserePbaPbai").click(function () {
        $('#hdn_pbapbai').val(0); 
        $('#hdn_pbapbaiarquivo').val(0);
        //----------------------------------------------------------------------
        var serializedData = validaformulario("formularioPbaPbai");
        
        if($("#tipopbapabi").val()== "Selecione"){
            $.notify("Informe o campo [Tipo].", "warning");
            document.getElementById("tipopbapabi").style.borderColor = "red";
            return false
        }else{
             document.getElementById("tipopbapabi").style.borderColor = "gray";
        }
        if($("#pba").val()== "Selecione"){
            $.notify("Informe o campo [PBA].", "warning");
            document.getElementById("pba").style.borderColor = "red";
            return false
        }else{
             document.getElementById("pba").style.borderColor = "gray";
        }
        if($("#pbai").val()== "Selecione"){
            $.notify("Informe o campo [PBAI].", "warning");
            document.getElementById("pbai").style.borderColor = "red";
            return false
        }else{
             document.getElementById("pbai").style.borderColor = "gray";
        }
        var descricao = CKEDITOR.instances["resumoPbaPbai"].getData();
         if (descricao == "") {
            $.notify("Informe o campo [Descrição].", "warning");
            return false;
        }
        //---------------- Validação de formulario -----------------------------
        var form = new FormData();
        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR PBA / PBAI]?", function (result) {
            if (result === true) {
                var form = new FormData();
                var arquivo = $("#fileUpload").val();

                if (arquivo !== "") {
                    form.append('arquivo', $('#fileUpload')[0].files[0]);
                }

                for (i = 0; i < serializedData.length; i++) {
                    form.append(serializedData[i].name, serializedData[i].value);
                }
                if (document.getElementById) {
                    var dt = $("#datepicker").datepicker('getDate');
                    if (dt.toString() === "Invalid Date") {
                        $("#datepicker").datepicker("setDate", new Date());
                        return;
                    }
                    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                }
                form.append('periodo', termo);
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/PbaPbaiInsereDaq',
                    data: form,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        document.formularioPbaPbai.reset();
                        document.getElementById("btnInclusao").disabled = false;
                        document.getElementById("datepicker").disabled = false;
                        $('#cadastroPbaPbai').hide();
                        $('#novo_pbapbai').show();
                        $.notify(data.mensagem, data.notify);
                        $('#btnInclusao').show();
                        $('#voltar').show();
                        $('#searchdate').hide();
                        var table = $("#tablePbaPbai").DataTable();
                        table.ajax.reload();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    });
//---------------------------------------------------------------------------------
function anexoPbaPbai(nome_arquivo) {
    $.ajax({
        url: 'anexoPbaPbai',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/application/homeDaq/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluirPba(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function alterarPbaPbai(){
    var id_pba_pbai = $('#hdn_pbapbai').val(); 
    if($('#hdn_pbapbaiarquivo').val() == 0 || $('#hdn_pbapbaiarquivo').val() ==''){
        $('#hdn_pbapbaiarquivo').val(0);
    }
    var id_arquivo  = $('#hdn_pbapbaiarquivo').val();
    
    var serializedData = validaformulario("formularioPbaPbai");
        
    if($("#tipopbapabi").val()== "Selecione"){
    $.notify("Informe o campo [Tipo].", "warning");
    document.getElementById("tipopbapabi").style.borderColor = "red";
    return false
    }else{
         document.getElementById("tipopbapabi").style.borderColor = "gray";
    }
    if($("#pba").val()== "Selecione"){
        $.notify("Informe o campo [PBA].", "warning");
        document.getElementById("pba").style.borderColor = "red";
        return false
    }else{
         document.getElementById("pba").style.borderColor = "gray";
    }
    if($("#pbai").val()== "Selecione"){
        $.notify("Informe o campo [PBAI].", "warning");
        document.getElementById("pbai").style.borderColor = "red";
        return false
    }else{
         document.getElementById("pbai").style.borderColor = "gray";
    }
    var descricao = CKEDITOR.instances["resumoPbaPbai"].getData();
     if (descricao == "") {

        $.notify("Informe o campo [Descrição].", "warning");
        return false;
    }
    //---------------- Validação de formulario -----------------------------
        var form = new FormData();
       
            var fileUpload = $("#fileUpload").val();
            if (fileUpload === "") {
                document.getElementById("fileUpload").style.borderColor = "red";
                $.notify("Insira o arquivo!", "warning");
                return false;
            } else {
                document.getElementById("fileUpload").style.borderColor = '#d2d6de';
            }
            form.append("arquivo", $("#fileUpload")[0].files[0]);
      
        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }
        //--
  bootbox.confirm("Confirmar operação [EDITAR PBA / PBAI]?", function (result) {
     if (result === true) {  
    $.ajax({
        type: "POST",
        url: "PbaPbaiExcluirDaq",
        data: {id_pba_pbai: id_pba_pbai, id_arquivo: id_arquivo},
        dataType: "json",
        success: function (data) {
           
            //----------------------------------------------------------
            //inserindo
                var form = new FormData();
                   var arquivo = $("#fileUpload").val();

                   if (arquivo !== "") {
                       form.append('arquivo', $('#fileUpload')[0].files[0]);
                   }

                   for (i = 0; i < serializedData.length; i++) {
                       form.append(serializedData[i].name, serializedData[i].value);
                   }
                   if (document.getElementById) {
                       var dt = $("#datepicker").datepicker('getDate');
                       if (dt.toString() === "Invalid Date") {
                           $("#datepicker").datepicker("setDate", new Date());
                           return;
                       }
                       var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                   }
                   form.append('periodo', termo);
                   $.ajax({
                       type: 'POST',
                       url: base_url + 'index_cgob.php/PbaPbaiInsereDaq',
                       data: form,
                       dataType: 'json',
                       contentType: false,
                       processData: false,
                       success: function (data) {
                           document.formularioPbaPbai.reset();
                           document.getElementById("btnInclusao").disabled = false;
                           document.getElementById("datepicker").disabled = false;
                           $('#cadastroPbaPbai').hide();
                           $('#novo_pbapbai').show();
                            $(".nomearquivo").text('');
                            $.notify(data.mensagem, data.notify);
                           
                           var table = $("#tablePbaPbai").DataTable();
                           table.ajax.reload();
                           $('#searchdate').hide();
                           $('#btnInclusao').show();
                            $('#btnInclusao').show();
                           $('#voltar').show();
                           $('#searchdate').hide();
                       }, error: function (data) {
                           $.notify('Falha no cadastro', "warning");
                       }
                   });
            //----------------------------------------------------------
        }, error: function (data) {
            $.notify("Falha na exclusão", "warning");
        }
    });
     }
    });
}
//------------------------------------------------------------------------------
function excluirPba(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/excluirPba',
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
