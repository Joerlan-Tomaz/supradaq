//######################################################################################################################################################################################################################## 
//# DNIT
//# resumoprojetoView.js
//# Desenvolvedor:jordana
//# Data: 10/10/2019 09:59
//########################################################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
     $('#searchdate').hide();
     //$('#btnNoAtividade').hide();
    //--------------------------------------------------------------------------
    CKEDITOR.replace('descricao_resumoProjeto', {
        //removePlugins: 'toolbar, elementspath, resize',
        height: 250
    });
    //--------------------------------------------------------------------------
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    //--------------------------------------------------------------------------
    $('#novo_resumoProjeto').show();
    $('#cadastroResumoProjeto').hide();
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        $.ajaxSetup({cache: false});
        recuperaResumoProjeto();
    });
    //--------------------------------------------------------------------------
    recuperaResumoProjeto();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaResumoProjeto();
        $('#novo_resumoProjeto').show();
        $('#cadastroResumoProjeto').hide();
        $('#searchdate').hide();
        $('#btnInclusao').show();
       // $('#btnNoAtividade').show();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            $('#novo_resumoProjeto').hide();
            $('#cadastroResumoProjeto').show();
            populaTipoTexto();
            //document.getElementById("datepicker").disabled = true;           
            //CKEDITOR.instances['descricao_resumoProjeto'].setData("");
             //$('#id_resumo').val(""); 
             $('#searchdate').show();
             $('#btnInclusao').hide();
            // $('#btnNoAtividade').hide();
        }   
    });
    //--------------------------------------------------------------------------
    $("#insereResumo").click(function () { 
        //------------------ Verificação de campos -----------------------------
       // var serializedData = validaformulario("formularioResumoProjeto");
        var serializedData = $("#formularioResumoProjeto").serializeArray();
      /*  var fileUpload = $("#fileUpload").val();
        if (serializedData == false || fileUpload == "") {
            if (fileUpload == "") {
                document.getElementById("fileUpload").style.borderColor = "red";
            } else {
                document.getElementById("fileUpload").style.borderColor = "#d2d6de";
            }
            $.notify("Preencha os campos obrigatórios", "warning");
            return false;
        }*/
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR RESUMO DE PROJETO]?", function (result) {
            if (result === true) {
                //---------------- Validação de formulario -----------------------------
                var form = new FormData();
                form.append("arquivo", $("#fileUpload")[0].files[0]);
                for (i = 0; i < serializedData.length; i++) {
                    form.append(serializedData[i].name, serializedData[i].value);
                }
                document.getElementById("fileUpload").style.borderColor = "#d2d6de";
                //----------------------------------------------------------------------
                if (document.getElementById) {
                    var dt = $("#datepicker").datepicker("getDate");
                    if (dt.toString() === "Invalid Date") {
                        $("#datepicker").datepicker("setDate", new Date());
                        return;
                    }
                    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
                }
                //---------------- Validação de formulario -----------------------------
                form.append("arquivo", $("#fileUpload")[0].files[0]);
                form.append("periodo", termo);
                $.ajax({
                    type: "POST",
                    url: base_url + "index_cgob.php/ResumoProjetoinsereDaq",
                    data: form,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (data) {
                        $.notify(data.mensagem, data.notify);
                        CKEDITOR.instances["descricao_resumoProjeto"].setData();
                        //document.getElementById("datepicker").disabled = false;
                        $("#novo_resumoProjeto").show();
                        $("#cadastroResumoProjeto").hide();
                        var table = $("#tableResumo").DataTable();
						$('#btnInclusao').show();
                        table.ajax.reload();
                        
                        document.formularioResumoProjeto.reset();
                        $("#searchdate").hide();
                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                    }
                });
            }
        });
    });
    //--------------------------------------------------------------------------
    $("#btnNoAtividade").click(function () {
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
      
            //------------------------------------------------------------------
            bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
                if (result === true) {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'index_cgob.php/ResumoProjetoNHADaq',
                        data: {periodo: termo},
                        dataType: 'json',
                        success: function (data) {
                            $.notify("Não houve atividades este mês!", "success");
                            var table = $("#tableResumo").DataTable();
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
function recuperaResumoProjeto() {
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
    $("#tableResumo").dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/ResumoProjetoRecuperaDaq?periodo="+termo,
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: "RESUMO", "sClass": "text-justify", "width": "40%"},
            {data: "TIPO", "sClass": "text-center", "width": "15%"},
            {data: "ARQUIVO", "sClass": "text-center", "width": "20%"},
            {data: "NOME", "sClass": "text-center", "width": "10%"},
            {data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "10%"},
            {data: "ACAO", "sClass": "text-center", "width": "5%"}
        ]
    });
}
//------------------------------------------------------------------------------
function anexoResumo(nome_arquivo) {
    $.ajax({
        url: 'anexoResumo',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            excluirResumo(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
//------------------------------------------------------------------------------
function editarResumoProjeto(id_resumo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/ResumoProjetoEditarDaq',
        data: {id_resumo: id_resumo},
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=tipo_texto_resumo]');
            servico.html('');
            servico.append("<option value='" + data.tipo + "'>" + data.tipo + "</option>");
            $('#btnInclusao').hide();
            $('#novo_resumoProjeto').hide();
            $('#cadastroResumoProjeto').show();

            var resumo = data.resumo;
            $("#id_resumo").val(data.id_resumo);
            CKEDITOR.instances['descricao_resumoProjeto'].setData(resumo);
        }, error: function (data) {
            $.notify('Falha na exclusão', "warning");
        }
    });
}
//------------------------------------------------------------------------------
function excluirArquivo(id_resumo, id_arquivo) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {

        bootbox.confirm("Confirmar operação [EXCLUIR RESUMO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/ResumoProjetoExcluirDaq',
                    data: {id_resumo: id_resumo, id_arquivo: id_arquivo},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com sucesso!', "success");
                        var tblResumo = $("#tableResumo").DataTable();
                        tblResumo.ajax.reload();
                       
                    }, error: function (data) {
                        $.notify('Falha na exclusão', "warning");
                    }
                });
            }
        });
    }
}

function excluirResumo(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/excluirResumo',
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
//------------------------------------------------------------------------------
function populaTipoTexto() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/ResumoProjetoTipoDaq',
        dataType: 'json',
        success: function (data) {
            var servico = $('select[id=tipo_texto_resumo]');
            servico.html('');
            servico.append('<option value="" selected >Selecione</option>');
            for (i = 0; i < data.id_tipo_pavimento.length; i++) {
                servico.append('<option value="' + data.id_tipo_pavimento[i] + '">' + data.desc_tipo_pavimento[i] + '</option>');
            }
        }
    })
}
//------------------------------------------------------------------------------
function validaformulario(formulario) {
    var serializedData = $("#" + formulario + "").serializeArray();
    var verificadorForm = new Array();
    for (var i = 0; i < serializedData.length; i++) {
        if (CKEDITOR.instances[serializedData[i].name]) {
            serializedData[i].value = CKEDITOR.instances[serializedData[i].name].getData();
        }
        var nome = serializedData[i].name;
        var valor = serializedData[i].value;
        if (valor === '') {
            document.getElementById(nome).style.borderColor = 'red';
            verificadorForm.push(false);
        } else {
            document.getElementById(nome).style.borderColor = '#d2d6de';
            verificadorForm.push(true);
        }
    }
    for (var i = 0; i < verificadorForm.length; i++) {
        if (verificadorForm[i] == false) {
            return false
        }
    }
    return serializedData;
}
