//######################################################################################################################################################################################## 
//# DNIT
//# rncView.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 31/03/2020
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    $('#searchdate').hide();
    //--------------------------------------------------------------------------
    $("[data-fancybox]").fancybox({
        buttons: ["download", "fullScreen", "zoom", "close"]
    });
    //--------------------------------------------------------------------------
    CKEDITOR.replace("status_detalhado", {height: 200});
    CKEDITOR.replace("desc_rnc", {height: 200});
    CKEDITOR.replace("sugestao_providencia", {height: 200});
    CKEDITOR.replace("providencia", {height: 200});
    //--------------------------------------------------------------------------
    $("#nova_rnc").hide();
    $("#cadastroRnc").hide();
  
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
         $.ajaxSetup({ cache: false });
        recuperaRNC();
    });
    //--------------------------------------------------------------------------
    recuperaRNC();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaRNC();
         $('#searchdate').hide();
        $('#btnInclusao').show();
        $('#btnNoAtividade').show();
    });
    //--------------------------------------------------------------------------
    $("#filtroStatus").change(function () {
        recuperaRNC();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        var relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $("#nova_rnc").hide();
            $("#cadastroRnc").show();
            $("#registroFotografico").hide();
            $("#rncAbertas").hide();
            populaGravidade();
            populaNatureza();
           // populaObra();
           // populaPavimento();
            populaTipoEixo();
            document.getElementById("datepicker").disabled = true;
            $('#searchdate').show();
            $('#btnInclusao').hide();
            $('#btnNoAtividade').hide();
        }
    });
    //--------------------------------------------------------------------------
    $("#insereRnc").click(function () {
        insereRnc();       
    });
    //--------------------------------------------------------------------------    
    $("#insereRncFotografico").click(function () {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        //----------------------------------------------------------------------------------------------------        
       var dta_atualizacao = $('#dta_atualizacao').val();
       var id_rnc = $('#id_rnc').val();
        //-----------------------------------------------------
         descricao_foto00 = $("#descricao_foto00").val();
         descricao_foto01 = $("#descricao_foto01").val();
         descricao_foto02 = $("#descricao_foto02" ).val();
         descricao_foto03 = $("#descricao_foto03" ).val();
        
        var form = new FormData();
        for (i = 0; i < $('#fileUpload')[0].files.length; i++) {
            form.append('arquivo[]', $('#fileUpload')[0].files[i]);
            form.append('descricao[]', document.getElementById('descricao_foto0' + i).value);
        }
        
        form.append('periodo', termo);
        form.append('dta_atualizacao', dta_atualizacao);
        form.append('id_rnc', id_rnc);
        form.append('descricao_foto00', descricao_foto00);
        form.append('descricao_foto01', descricao_foto01);
        form.append('descricao_foto02', descricao_foto02);
        form.append('descricao_foto03', descricao_foto03);
        
        //----------------------------------------------------------------------------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR FOTOS]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/RncInsereFotoDaq',
                    data: form,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.mensagem === "Arquivo Enviado") {
                            document.getElementById("fileUpload").value = "";
                            document.getElementById("descricao_foto00").value = "";
                            document.getElementById("descricao_foto01").value = "";
                            document.getElementById("descricao_foto02").value = "";
                            document.getElementById("descricao_foto03").value = "";
                            document.getElementById("dta_atualizacao").value = "";
                            document.getElementById("uploadPreview0").src = "../assets/img/users/default_photo.png";
                            document.getElementById("uploadPreview1").src = "../assets/img/users/default_photo.png";
                            document.getElementById("uploadPreview2").src = "../assets/img/users/default_photo.png";
                            document.getElementById("uploadPreview3").src = "../assets/img/users/default_photo.png";
                            $('#registroFotografico').hide();
                            $('#nova_rnc').show();
                            var tableRnc = $("#tableRnc").DataTable();
                            tableRnc.ajax.reload();
                            $('#searchdate').hide();
                            $('#btnInclusao').show();
                            $('#btnNoAtividade').show();
                        }
                        $.notify(data.mensagem, data.notify);
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                    }
                });
            }
        });
    });
    //-------------------------------------------------------------------- 
    $("#btnInsereSolucaoRNC").click(function () {
        btnInsereSolucaoRNC();        
    });
    //-------------------------------------------------------------------- 
    $("#btnNoAtividade").click(function () {
        var relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
    //----------------------------------------------------------------------------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/RncNaoAtividadeDaq',
                    data: {
                        periodo: termo
                    },
                    dataType: 'json',
                    success: function (data) {
                        $.notify("Cadastrado", "success");
                        var tableRnc = $("#tableRnc").DataTable();
                        tableRnc.ajax.reload();
                        confereNaoAtividade();
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                    }
                });
            }
        });
    }
});
//------------------------------------------------------------------------------------------------------------------------------------------
$("#tipoEixo").change(function () {
  var id_eixo = $("#tipoEixo").val();
});

});
//------------------------------------------------------------------------
function recuperaRNC() {
    document.getElementById("datepicker").disabled = false;
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    //-------------------------------------------------------------------------------------------
    confereNaoAtividade();
    var status = $("#filtroStatus").val();
    $("#nova_rnc").show();
    $("#cadastroRnc").hide();
    $("#registroFotografico").hide();
    $("#registroFotograficoInserido").hide();
    $("#tableRnc").dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/RncRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push(
                    {"name": "periodo", "value": termo},
                    {"name": "status", "value": status}
            );
        },
        "aoColumns": [
            {data: "PERIODO", "sClass": "text-center", "width": "10%"},
            {data: "STATUS", "sClass": "text-center", "width": "10%"},
            {data: "KM", "sClass": "text-center", "width": "10%"},
            {data: "NATUREZA", "sClass": "text-center", "width": "10%"},
            {data: "GRAU", "sClass": "text-center", "width": "10%"},
            {data: "FOTOS", "sClass": "text-center", "width": "10%"},
            {data: "SITUACAO", "sClass": "text-center", "width": "10%"},
            {data: "DATA_ATUALIZACAO", "sClass": "text-center", "width": "10%"},
            {data: "USUARIO", "sClass": "text-center", "width": "10%"},
            {data: "ATUALIZACAO", "sClass": "text-center", "width": "10%"},
            {data: "ACAO", "sClass": "text-center", "width": "15%"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirRNC(id_rnc,id_providencia) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
    bootbox.confirm("Confirmar operação [EXCLUIR RNC]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/RncExcluirDaq',
                data: {id_rnc: id_rnc, id_providencia: id_providencia},
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluído com sucesso!', "success");
                    var tableRnc = $("#tableRnc").DataTable();
                    tableRnc.ajax.reload();
                    confereNaoAtividade();
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                }
            });
        }
    });
}
}
function excluiratividade(id) {
    bootbox.confirm("Confirmar operação [EXCLUIR NÃO ATIVIDADE]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/RncExcluiAtvDaq',
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluído com sucesso!', "success");
                    var tableRnc = $("#tableRnc").DataTable();
                    tableRnc.ajax.reload();
                    confereNaoAtividade();
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function excluirProvidencia(id_providencia) {
    bootbox.confirm("Confirmar operação [EXCLUIR RNC]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: base_url + 'index_cgop.php/RncExcluiProvDaq',
                data: {id_providencia: id_providencia},
                dataType: 'json',
                success: function (data) {
                    $.notify('Excluído com sucesso!', "success");
                    var tableSugestaoRNC = $("#tableSugestaoRNC").DataTable();
                    tableSugestaoRNC.ajax.reload();
                    var tableRnc = $("#tableRnc").DataTable();
                    tableRnc.ajax.reload();
                     $("#btnInsereSolucaoRNC").prop("disabled", false);
                    // confereNaoAtividade();
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------------
function confereNaoAtividade() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    //-----------------------------------------------------------------
        var status = $("#filtroStatus").val();
    //-----------------------------------------------------------------
    $.ajax({
        type: "POST",
        url: base_url + "index_cgop.php/RncConfereAtvDaq",
        data: {periodo: termo, status: status},
        dataType: "json",
        success: function (data) {
            if (data.situacao === "Com RNC") {
                 if ($("#btnInclusao").length){ 
                   document.getElementById("btnInclusao").disabled = false;
                 }
                if ($("#btnNoAtividade").length){ 
                  document.getElementById("btnNoAtividade").disabled = true;
                }
            } else if (data.situacao === "Não Atividade") {
                 if ($("#btnInclusao").length){ 
                  document.getElementById("btnInclusao").disabled = true;
                 }
                if ($("#btnNoAtividade").length){ 
                  document.getElementById("btnNoAtividade").disabled = true;
                }
            } else if ("Sem Registros") {
                 if ($("#btnInclusao").length){ 
                   document.getElementById("btnInclusao").disabled = false;
                 }
                if ($("#btnNoAtividade").length){ 
                  document.getElementById("btnNoAtividade").disabled = false;
                }
            }
        }
    });
}
//------------------------------------------------------------------------------
function rotaDocRNC(id_rnc) {
var dt = $("#datepicker").datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
  
    jan = window.open(base_url + 'index_cgop.php/RncImpDaq?periodo=' + termo + '&id='+id_rnc, 'jan', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=100, LEFT=450, WIDTH=740, HEIGHT=500');
 
}
//------------------------------------------------------------------------------
function fotos(id_rnc) {
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
    $('#searchdate').show();
    $('#btnInclusao').hide();
    $('#btnNoAtividade').hide();
    RecuperaFotos(id_rnc);
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RncFotosDaq',
        data: {id_rnc: id_rnc},
        dataType: 'json',
        success: function (data) {
            $('#nova_rnc').hide();
          
                document.getElementById("fileUpload").style.visibility = "visible";
                document.getElementById("insereRncFotografico").style.visibility = "visible";
                document.getElementById("descricao_foto00").value = "";
                document.getElementById("descricao_foto01").value = "";
                document.getElementById("descricao_foto02").value = "";
                document.getElementById("descricao_foto03").value = "";
                document.getElementById("uploadPreview0").src = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                document.getElementById("uploadPreview1").src = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                document.getElementById("uploadPreview2").src = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                document.getElementById("uploadPreview3").src = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                document.getElementById("fancyFoto0").href = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                document.getElementById("fancyFoto1").href = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                document.getElementById("fancyFoto2").href = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                document.getElementById("fancyFoto3").href = base_url + "application/homeDaq/assets/img/users/default_photo.png";
                $('#registroFotografico').show();
                $('#registroFotograficoInserido').hide();
            
        }, error: function (data) {
            $.notify('Erro no Envio', "warning");
        }
    });
    }
}

//------------------------------------------------------------------------------
function alteraFoto(id_arquivo, i) {
    fileAlteraFoto = document.getElementById('fileAlteraFoto' + i).value;
    descricaoAlteraFoto = document.getElementById('descricaoAlteraFoto' + i).value;
    if (fileAlteraFoto == "" || descricaoAlteraFoto == "") {
        if (fileAlteraFoto === '') {
            document.getElementById('fileAlteraFoto' + i).style.borderColor = 'red';
        } else {
            document.getElementById('fileAlteraFoto' + i).style.borderColor = '#d2d6de';
        }
        if (descricaoAlteraFoto === '') {
            document.getElementById('descricaoAlteraFoto' + i).style.borderColor = 'red';
        } else {
            document.getElementById('descricaoAlteraFoto' + i).style.borderColor = '#d2d6de';
        }
        $.notify("Por favor, informe os campos necessários", 'warning');
        return false;
    }
    document.getElementById('fileAlteraFoto' + i).style.borderColor = '#d2d6de';
    document.getElementById('descricaoAlteraFoto' + i).style.borderColor = '#d2d6de';
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    var form = new FormData();
    form.append('arquivo', $('#fileAlteraFoto' + i)[0].files[0]);
    form.append('descricao', document.getElementById('descricaoAlteraFoto' + i).value);
    form.append('periodo', termo);
    form.append('id_arquivo', id_arquivo);
    //----------------------------------------------------------------------------------------------------------------------------------------
    bootbox.confirm("Confirmar operação [ALTERAR FOTO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: '',
                data: form,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                    $.notify(data.mensagem, data.notify);
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });
}
//------------------------------------------------------------------------  
function PreviewImage() {
    var x = document.getElementById("fileUpload").files;
    if (x.length > 4) {
        $.notify('Numero de arquivo superior ao permitido', "warning");
        document.getElementById("fileUpload").value = "";
    } else if (x.length < 4) {
        $.notify('Numero de arquivo inferior ao permitido', "warning");
        document.getElementById("fileUpload").value = "";
    } else if (x.length === 4) {
        var tamanhoPost = 0;
        var maxSize = 1024 * 1024 * 15;
        for (i = 0; i < x.length; i++) {
            tamanhoPost += x[i].size;
        }
        if (tamanhoPost < maxSize) {
            for (i = 0; i < x.length; i++) {
                if (x[i].type === "image/jpeg") {
                    PreviewImage2(i);
                } else {
                    $.notify('Arquivo não suportado', "warning");
                }
            }
        } else {
            $.notify('Os arquivos superam o limite de tamanho(5mb)', "warning");
        }
    }
}
function PreviewImage2(i) {
    oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("fileUpload").files[i]);
    oFReader.onload = function (oFREvent) {
        document.getElementById("uploadPreview" + i).src = oFREvent.target.result;
        document.getElementById("fancyFoto" + i).href = oFREvent.target.result;
    };
}
function PreviewImage3(i) {
    oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("fileAlteraFoto" + i).files[0]);
    oFReader.onload = function (oFREvent) {
        document.getElementById("imgAlteraFoto" + i).src = oFREvent.target.result;
        document.getElementById("imgAlteraFotoFancy" + i).href = oFREvent.target.result;
    };
}
//------------------------------------------------------------------------   
function modalSituacao(id_rnc, situacao_providencia) {
    $("#solucionarRNC").modal();
    document.getElementById("desc_rnc").value = "";
    document.getElementById("providencia").value = "";
    document.getElementById("dt_fechamento").value = "";
    document.getElementById("dt_atualizacao").value = "";
    $("#id_regnconformidade").val(id_rnc);
    $("#idrgn").val(id_rnc);
    $("#statusProvidencia").val(situacao_providencia);
    if (situacao_providencia == "Fechado") {
        $("#statusProvidencia").prop("disabled", true);
        $("#btnInsereSolucaoRNC").prop("disabled", true);
        CKEDITOR.instances["desc_rnc"].setReadOnly(true);
    } else {
        $("#statusProvidencia").prop("disabled", false);
        $("#btnInsereSolucaoRNC").prop("disabled", false);
        CKEDITOR.instances["desc_rnc"].setReadOnly(false);
    }
    $("#tableSugestaoRNC").dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/RncConsultaSugestaoDaq",
        "fnServerParams": function (aoData) {
            aoData.push(
                    {"name": "id_rnc", "value": id_rnc},
                    {"name": "status", "value": situacao_providencia});
        },
        "aoColumns": [
            {data: "DESCRICAO"},
            {data: "PROVIDENCIA"},
            {data: "DATA_ATUALIZACAO", "sClass": "text-center"},
            {data: "USUARIO", "sClass": "text-center"},
            {data: "ATUALIZACAO", "sClass": "text-center"},
            {data: "ACAO", "sClass": "text-center"}
        ]
    });
}

//------------------------------------------------------------------------   
function populaGravidade() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RncGravidadeDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=grau]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_gravidade.length; i++) {
                servico.append('<option value="' + data.id_gravidade[i] + '">' + data.desc_gravidade[i] + '</option>');
            }
        }
    })
}
//------------------------------------------------------------------------------
function populaNatureza() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RncNaturezaDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=natureza]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_natureza.length; i++) {
                servico.append('<option value="' + data.id_natureza[i] + '">' + data.desc_natureza[i] + '</option>');
            }
        }
    })
}
//------------------------------------------------------------------------------
function populaObra() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RncObraDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=obra]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_obra.length; i++) {
                servico.append('<option value="' + data.id_obra[i] + '">' + data.desc_obra[i] + '</option>');
            }
        }
    })
}
//------------------------------------------------------------------------------
function populaPavimento() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/RncPavimentoDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=pavimento]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_rnc_pavimento.length; i++) {
                servico.append('<option value="' + data.id_rnc_pavimento[i] + '">' + data.desc_rnc_pavimento[i] + '</option>');
            }
        }
    })
}
//------------------------------------------------------------------------------
function populaTipoEixo() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/LicencasAmbientaisTipoDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=tipoEixo]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_tipo_licenca.length; i++) {
                servico.append('<option value="' + data.id_tipo_licenca[i] + '">' + data.desc_tipo_licenca[i] + '</option>');
            }
        }
    })
}
//------------------------------------------------------------------------------
function anexoRnc(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgop.php/anexoRnc',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/img/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluiRnc(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function insereRnc(){
        //------------------ Verificação de campos ----------------------------------
            var grau = $('#grau').val();
            if (grau == "") {
                $.notify("O campo [ Gravidade ] é obrigatório!", "warning");
                document.getElementById('grau').style.borderColor = 'red';
                $("#grau").focus();
                return false;
               
            } else {
                document.getElementById('grau').style.borderColor = '#d2d6de';
            }
            
            var data_atividade = $('#data_atividade').val();
            if (data_atividade == "") {
                $.notify("O campo [ Data do Registro ] é obrigatório!", "warning");
                document.getElementById('data_atividade').style.borderColor = 'red';
                $("#data_atividade").focus();
                return false;
               
            } else {
                document.getElementById('data_atividade').style.borderColor = '#d2d6de';
            }
            
            var natureza = $('#natureza').val();
            if (natureza == "") {
                $.notify("O campo [ Natureza ] é obrigatório!", "warning");
                document.getElementById('natureza').style.borderColor = 'red';
                $("#natureza").focus();
                return false;
               
            } else {
                document.getElementById('natureza').style.borderColor = '#d2d6de';
            }
                      
            
            var tipoEixo = $('#tipoEixo').val();
            if (tipoEixo == "") {
                $.notify("O campo [ Tipo de Eixo ] é obrigatório!", "warning");
                document.getElementById('tipoEixo').style.borderColor = 'red';
                $("#tipoEixo").focus();
                return false;
               
            } else {
                document.getElementById('tipoEixo').style.borderColor = '#d2d6de';
            }
            
            var km = $('#km').val();
            if (km == "") {
                $.notify("O campo [ Km ] é obrigatório!", "warning");
                document.getElementById('km').style.borderColor = 'red';
                $("#km").focus();
                return false;
               
            } else {
                document.getElementById('km').style.borderColor = '#d2d6de';
            }
            
            var coord_UTM_N = $('#coord_UTM_N').val();
            if (coord_UTM_N == "") {
                $.notify("O campo [ Latitude ] é obrigatório!", "warning");
                document.getElementById('coord_UTM_N').style.borderColor = 'red';
                $("#coord_UTM_N").focus();
                return false;
               
            } else {
                document.getElementById('coord_UTM_N').style.borderColor = '#d2d6de';
            }
            
            var coord_UTM_E = $('#coord_UTM_E').val();
            if (coord_UTM_E == "") {
                $.notify("O campo [ Longitude ] é obrigatório!", "warning");
                document.getElementById('coord_UTM_E').style.borderColor = 'red';
                $("#coord_UTM_E").focus();
                return false;
               
            } else {
                document.getElementById('coord_UTM_E').style.borderColor = '#d2d6de';
            }
            
            var data_atualizacao = $('#data_atualizacao').val();
            var data_fechamento = $('#data_fechamento').val();
            
            var status_detalhado = CKEDITOR.instances['status_detalhado'].getData();       
            if (status_detalhado == '') {
                 $.notify("O campo [Descrição] é obrigatório!", "warning");
                document.getElementById('status_detalhado').style.borderColor = 'red';
                $("#status_detalhado").focus();
                return false;
            } else {
                document.getElementById('status_detalhado').style.borderColor = '#d2d6de';
            }
            
            var sugestao_providencia = CKEDITOR.instances['sugestao_providencia'].getData();       
            if (sugestao_providencia == '') {
                 $.notify("O campo [ Sugestão de Providências ] é obrigatório!", "warning");
                document.getElementById('sugestao_providencia').style.borderColor = 'red';
                $("#sugestao_providencia").focus();
                return false;
            } else {
                document.getElementById('sugestao_providencia').style.borderColor = '#d2d6de';
            }

			var strData = $('#data_fechamento').val();
			var partesData = strData.split("/");
			var data = new Date(partesData[2], partesData[1] - 1, partesData[0]);
			if(data < new Date()){
				$.notify("O campo [Data de Fechamento] não pode ser menor, ou igual a data atual!", 'warning');
				return false;
			}
        //--------------------------------------------------------------------------
        // var km_foto = $("#km").val();
        // var km_foto = validaKM(km_foto, "");
        // if (km_foto.retornoInicial == false) {
        //     $.notify("KM não pertence ao segmento!", "warning");
        //     document.getElementById("km").style.borderColor = "red";
        //     return false;
        // }
        //---------------- Validação de formulario -------------------------
       
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
           
        }
       
        //------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR RNC]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgop.php/RncInsereDaq",
                    data: {
                            grau: grau,
                            data_atividade: data_atividade,
                            natureza: natureza,
                            // obra: obra,
                            // pavimento: pavimento,
                            tipoEixo: tipoEixo,
                            km: km,
                            coord_UTM_N: coord_UTM_N,
                            coord_UTM_E: coord_UTM_E,
                            data_atualizacao: data_atualizacao,
                            data_fechamento: data_fechamento,
                            periodo: termo,
                            status_detalhado: status_detalhado,
                            sugestao_providencia: sugestao_providencia
                            
                        },
                    dataType: "json",
                    success: function (data) {
                        $.notify("RNC Inserido", "success");
                                $("#cadastroRnc").hide();
                                $("#nova_rnc").show();

                                recuperaRNC();
                                 document.getElementById("datepicker").disabled = true;
                            $('#searchdate').hide();
                            $('#btnInclusao').show();
                            $('#btnNoAtividade').show();
                        document.formularioRnc.reset();
                        CKEDITOR.instances["status_detalhado"].setData("");
                        confereNaoAtividade();
                    }, error: function (data) {
                        $.notify("Não foi possível Inserir", "warning");
                    }
                });
            }
        });
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function btnInsereSolucaoRNC(){
    var relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
    var id_rnc = $('#idrgn').val();
    $("#id_rnc").val(id_rnc);
    var dt_atualizacao= $('#dt_atualizacao').val();
    if (status_detalhado == '') {
            $.notify("O campo [Data de Atualização] é obrigatório!", "warning");
        document.getElementById('dt_atualizacao').style.borderColor = 'red';
        $("#dt_atualizacao").focus();
        return false;
    } else {
        document.getElementById('dt_atualizacao').style.borderColor = '#d2d6de';
    }
    var dt_fechamento= $('#dt_fechamento').val();          
    var descricao = CKEDITOR.instances['desc_rnc'].getData();
    if (descricao == '') {
            $.notify("O campo [ Descrição ] é obrigatório!", "warning");
        document.getElementById('descricao').style.borderColor = 'red';
        $("#descricao").focus();
        return false;
    } 
    var providencia = CKEDITOR.instances['providencia'].getData();  
    if (providencia == '') {
            $.notify("O campo [ Providência ] é obrigatório!", "warning");
        document.getElementById('providencia').style.borderColor = 'red';
        $("#providencia").focus();
        return false;
    }
	var strData = $('#dt_fechamento').val();
	var partesData = strData.split("/");
	var data = new Date(partesData[2], partesData[1] - 1, partesData[0]);
	if(data < new Date()){
		$.notify("O campo [Data de Fechamento] não pode ser menor, ou igual a data atual!", 'warning');
		return false;
	}

    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        
    }
    
    //-------------------------------------------------------------------- 
    bootbox.confirm("Confirmar operação [INSERIR SOLUÇÃO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: "POST",
                url: base_url + "index_cgop.php/RncInsereProvidenciaDaq",
                data: {
                    dt_atualizacao: dt_atualizacao,
                    dt_fechamento: dt_fechamento,
                    descricao: descricao,
                    providencia: providencia,
                    periodo: termo,
                    id_rnc: id_rnc
                },
                dataType: "json",
                success: function (data) {
                    $.notify("Providência Inserida", "success");
                    
                    var tableSugestaoRNC = $("#tableSugestaoRNC").DataTable();
                    tableSugestaoRNC.ajax.reload();
                  
                    var tableRnc = $("#tableRnc").DataTable();
                    tableRnc.ajax.reload();
             
                    $("#btnInsereSolucaoRNC").prop("disabled", true);
                        $("#solucionarRNC").modal("hide");
                        recuperaRNC();
                    
                }, error: function (data) {
                    $.notify("Erro no Envio", "warning");
                }
            });
        }
    });
}
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function RecuperaFotos(id_rnc){
    $("#id_rnc").val(id_rnc);
    $("#tablefotos").dataTable({
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
        "sAjaxSource": base_url + "index_cgop.php/RncRecuperaFotoDaq?id_rnc="+id_rnc,
        "aoColumns": [
            {data: "conte"},
            {data: "foto"},
            {data: "nome_arquivo"},
            {data: "desc_arquivo"},
            {data: "data_atualizacao_foto"},
            {data: "desc_nome"},
            {data: "ultima_alteracao"},
            {data: "acao"}      
            
        ]
    });
}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------
function excluiRnc(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgop.php/excluiRnc',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            //$.notify('Excluido com Sucesso!', "success");
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}

function excluirFoto(id_rnc_foto, id_arquivo) {
    bootbox.confirm("Confirmar operação [EXCLUIR FOTO]?", function (result) {
        if (result === true) {
            $.ajax({
                type: "POST",
                url: base_url + "index_cgop.php/RncExcluirFotoDaq",
                data: {id_rnc_foto: id_rnc_foto, id_arquivo: id_arquivo},
                dataType: "json",
                success: function (data) {
                    $.notify("Excluído com sucesso!", "success");
                    var table = $("#tablefotos").DataTable();
                    table.ajax.reload();
                }, error: function (data) {
                    $.notify("Falha no cadastro", "warning");
                }
            });
        }
    });
}
