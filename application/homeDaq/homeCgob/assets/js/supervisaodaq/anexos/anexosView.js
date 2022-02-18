//######################################################################################################################################################################################################################## 
//# DNIT
//# anexosView.js
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
    //--------------------------------------------------------
    $.ajaxSetup({ cache: false });
    //------------------------------------------------------- 
    $('#novo_anexo').hide();
    $('#cadastroAnexos').hide();
    $("#searchdate").hide();
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        $.ajaxSetup({ cache: false });
        recuperaAnexo();
       
    });
    //-------------------------------------------------------
    recuperaAnexo();
    //-------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaAnexo();
        document.getElementById("datepicker").disabled = false;
        $("#btnInclusao").show();
        $("#searchdate").hide();
    });
    //--------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $('#novo_anexo').hide();
            $('#cadastroAnexos').show();
            document.getElementById("datepicker").disabled = true;
            $("#btnInclusao").hide();
            $("#searchdate").show();
         }
    });
    //-------------------------------------------------------------------- 
    $("#insereAnexos").click(function () {
        tipo_documento = $("#tipo_documento").val();
        anexo = $("#fileUpload").val();
        if (tipo_documento == "" || anexo == "") {
            if (tipo_documento === '') {
                document.getElementById('tipo_documento').style.borderColor = 'red';
            } else {
                document.getElementById('tipo_documento').style.borderColor = '#d2d6de';
            }
            if (anexo === '') {
                document.getElementById('fileUpload').style.borderColor = 'red';
            } else {
                document.getElementById('fileUpload').style.borderColor = '#d2d6de';
            }
            $.notify("Por favor, informe os campos necessários", 'warning');
            return false;
        }

        document.getElementById('tipo_documento').style.borderColor = '#d2d6de';
        document.getElementById('fileUpload').style.borderColor = '#d2d6de';

        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }

        var form = new FormData();
        form.append('arquivo', $('#fileUpload')[0].files[0]);
        form.append('periodo', termo);

        var serializedData = $("#formularioAnexos").serializeArray();
        for (i = 0; i < serializedData.length; i++) {
            form.append(serializedData[i].name, serializedData[i].value);
        }
        //----------------------------------------------------------------------------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR ANEXO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/insereAnexoDaq',
                    data: form,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $.notify(data.mensagem, data.notify);
                        $('#cadastroAnexos').hide();
                        $('#novo_anexo').show();
                        document.getElementById("fileUpload").value = "";
                        document.getElementById("tipo_documento").value = "";
                        var tableAnexos = $("#tableAnexos").DataTable();
                        document.getElementById("datepicker").disabled = false;
                        tableAnexos.ajax.reload();
                        if (document.getElementById) {
                            var dt = $("#datepicker").datepicker('getDate');
                            if (dt.toString() == "Invalid Date") {
                                $("#datepicker").datepicker("setDate", new Date());
                                return;
                            }
                            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                        }
                        checkCabecalho(termo);
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                    }
                });
            }
        });

    });
});
//--------------------------------------------------------------------
function recuperaAnexo() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    checkCabecalho(termo);
    $('#novo_anexo').show();
    $('#cadastroAnexos').hide();
    $('#tableAnexos').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/RecuperaAnexosDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'ARQUIVO'},
            {data: 'TIPOARQUIVO', "sClass": "text-center"},
            {data: 'NOME', "sClass": "text-center"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center"},
            {data: 'ACAO', "sClass": "text-center"}
        ]
    });
}
//------------------------------------------------------------------------------
function anexorecupera(nome_arquivo) {
    $.ajax({
        url: 'anexorecupera',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.download = nome_arquivo;
            anchor.href = arquivo;
            anchor.click();
            $.notify('Download!', "success");
            excluiranexo(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//--------------------------------------------------------------------       
function excluirArquivo(id_arquivo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
   
        bootbox.confirm("Confirmar operação [EXCLUIR REGISTRO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/excluirArquivoDaq',
                    data: {id_arquivo: id_arquivo},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var tableAnexos = $("#tableAnexos").DataTable();
                        tableAnexos.ajax.reload();
                        if (document.getElementById) {
                            var dt = $("#datepicker").datepicker('getDate');
                            if (dt.toString() == "Invalid Date") {
                                $("#datepicker").datepicker("setDate", new Date());
                                return;
                            }
                            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                        }
                        checkCabecalho(termo);
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
}
//--------------------------------------------------------------------       
function checkCabecalho(termo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RecuperaAnexosDaq',
        data: {periodo: termo},
        dataType: 'json',
        success: function (data) {
            if (data.Terraplanagem === "Cheio") {
                 if ($("#spanAnexoObrigatorio").length){ 
                   document.getElementById("spanAnexoObrigatorio").style.visibility = 'visible';
                 }
            } else {
                if ($("#spanAnexoObrigatorio").length){ 
                   document.getElementById("spanAnexoObrigatorio").style.visibility = 'hidden';
                }
            }
             if ($("#smlSescoesTranversais").length){ 
              document.getElementById("smlSescoesTranversais").style.visibility = 'hidden';
             }
            
            if ($("#smlMemoriaCalculo").length){ 
              document.getElementById("smlMemoriaCalculo").style.visibility = 'hidden';
            }
            if ($("#smlPlanilhaEquilibrio").length){ 
              document.getElementById("smlPlanilhaEquilibrio").style.visibility = 'hidden';
            }
            
            $.each(data, function (i, item) {
                for (var i = 0; i < item.length; i++) {
                    switch (item[i].TIPOARQUIVO) {
                        case "Seções Transversais":
                               if ($("#smlSescoesTranversais").length){
                                 document.getElementById("smlSescoesTranversais").classList = 'label pull-right bg-green';
                               }
                             if ($("#smlSescoesTranversais").length){
                               document.getElementById("smlSescoesTranversais").style.visibility = 'visible';
                             }
                            break;
                        
                        case "Memória de Cálculo da(s) Medição(ões)":
                            if ($("#smlMemoriaCalculo").length){
                              document.getElementById("smlMemoriaCalculo").classList = 'label pull-right bg-green';
                            }
                            if ($("#smlMemoriaCalculo").length){
                              document.getElementById("smlMemoriaCalculo").style.visibility = 'visible';
                            }
                            if ($("#spanAnexoObrigatorio").length){
                              document.getElementById("spanAnexoObrigatorio").style.visibility = 'hidden';
                            }
                            break;
                        case "Planilha de Equilíbrio Econômico-Financeiro":
                            if ($("#smlPlanilhaEquilibrio").length){ 
                              document.getElementById("smlPlanilhaEquilibrio").classList = 'label pull-right bg-green';
                            }
                            if ($("#smlPlanilhaEquilibrio").length){
                              document.getElementById("smlPlanilhaEquilibrio").style.visibility = 'visible';
                            }
                            break;
                        
                    }
                }
            });
        }
    });
}
function excluiranexo(nome_arquivo) {
    $.ajax({
        url: 'excluiranexo',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//-----------------------------------------------------------------------------
