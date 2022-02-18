//######################################################################################################################################################################################################################## 
//# DNIT
//# controlepluviometricoView.js
//# Desenvolvedor:Jordana de Alencar 
//########################################################################################################################################################################################################################

$().ready(function () {
    //--------------------------------------------------------------------------
    $(".mostrar").hide();
    $(".ocultar").click(function () {
        $(this).next(".mostrar").slideToggle(600);
    });
    $('#novo_controlepluviometrico').hide();
    $('#cadastroControlePluviometrico').hide();
    $('#searchdate').hide();
    //--------------------------------------------------------------------------
    Recuperadiasmes();
    //--------------------------------------------------------------------------
    $('#datepicker').on("changeDate", function () {
        recuperaControlePluv();
    });
    //--------------------------------------------------------------------------
    recuperaControlePluv();
    //--------------------------------------------------------------------------
    $("#searchdate").click(function () {
        recuperaControlePluv();
        $('#searchdate').hide();
        $('#btnInclusao').show();
    });
    //--------------------------------------------------------------------------
    $("#btnInclusao").click(function () {
        relatorio = confereRelatorio();
        if (relatorio == 1) {
            mensagemRelatorioFechado();
        } else {
            document.getElementById("datepicker").disabled = true;
            $('#novo_controlepluviometrico').hide();
            $('#cadastroControlePluviometrico').show();
            $('#searchdate').show();
            $('#btnInclusao').hide();
            if (document.getElementById) {
                var dt = $("#datepicker").datepicker('getDate');
                if (dt.toString() == "Invalid Date") {
                    $("#datepicker").datepicker("setDate", new Date());
                    return;
                }
                function getMesExtenso(mes){
                    var arrayMes = new Array(12);
                    arrayMes[0] = "Jan";
                    arrayMes[1] = "Feb";
                    arrayMes[2] = "Mar";
                    arrayMes[3] = "Apr";
                    arrayMes[4] = "May";
                    arrayMes[5] = "Jun";
                    arrayMes[6] = "Jul";
                    arrayMes[7] = "Aug";
                    arrayMes[8] = "Sep";
                    arrayMes[9] = "Oct";
                    arrayMes[10] = "Nov";
                    arrayMes[11] = "Dec";
                    return arrayMes[mes];
                }
                var ano = dt.getFullYear();
                var mes = dt.getMonth() + 1;
                var mesext = getMesExtenso(dt.getMonth());
            }

            
            var linhas = document.getElementById('tableCadastroControlePluviometrico').rows;
            var qtdLinhas = (linhas.length - 1);
            var x = 1;

            for (var j = 0; j < qtdLinhas; j++) {
                document.getElementById('tableCadastroControlePluviometrico').deleteRow(x);
            }

            var lastDay = (new Date(ano, mes, 0)).getDate();
            for (i = 1; i <= lastDay; i++) {
                var d = new Date(mesext + i +','+ano); //instanciada passando uma string 
                var days = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado" ];

                var newRow = $("<tr>");
                var cols = "";
                cols += "<td>Dia " + i + " - " + days[d.getDay()] + "</td>";
                cols += "<td style='text-align: center;'>";
             //   cols += "   <input name='naoAtividade_" + i + "'  value='4' type='checkbox'><br>";
             //   cols += "   <small for='checkbox'> Não houveram atividades</small>";
                cols += "</td>";
                cols += "<td>";
                cols += "   <select class='form-control' name='cp_manha_" + i + "' id='cp_manha_" + i + "' required>";
                cols += "       <option value=''></option>";
                cols += "       <option value='Bom'>Bom</option>";
                cols += "       <option value='Chuva'>Chuva</option>";
                cols += "       <option value='Impraticável'>Impraticável</option>";
                cols += "       <option value='Instavel'>Instável</option>";
                cols += "       <option value='Não houveram atividades'>Não houveram atividades</option>";
                cols += "   </select>";
                cols += "</td>";

                newRow.append(cols);
                $("#tableCadastroControlePluviometrico").append(newRow);
            }
        }
    });
    //--------------------------------------------------------------------------
    $("#insereControlePluviometrico").click(function () {
       
        var termo = new Object();
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            termo.name = "periodo";
            termo.value = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
            var ano = dt.getFullYear();
            var mes = dt.getMonth() + 1;
        }
       //var  serializedData = validaformulario("formularioControlePluviometrico");
        var serializedData = $("#formularioControlePluviometrico").serializeArray();
        serializedData.push(termo);

        var totalDias = new Object();
        var lastDay = (new Date(ano, mes, 0)).getDate();

        totalDias.name = "totalDias";
        totalDias.value = lastDay;
        serializedData.push(totalDias);
        //----------------------------------------------------------------------
        bootbox.confirm("Confirmar operação [INSERIR CONTROLE PLUVIOMÉTRICO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/ControlePluvInsereDaq',
                    data: serializedData,
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Controle Pluviométrico Cadastrado com Sucesso', "success");
                        $('#novo_controlepluviometrico').show();
                        $('#cadastroControlePluviometrico').hide();
                        var tableControlePluviometrico = $("#tableControlePluviometrico").DataTable();
                        tableControlePluviometrico.ajax.reload();
                        document.getElementById("datepicker").disabled = false;
                        recuperaControlePluv();
                        $('#searchdate').hide();
                        $('#btnInclusao').show();
                        Recuperadiasmes();
                        
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                        
                    }
                });
            }
        });
    });
})
//------------------------------------------------------------------------------
function recuperaControlePluv() {
   Recuperadiasmes();
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker('getDate');
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    document.getElementById("datepicker").disabled = false;

    $('#novo_controlepluviometrico').show();
    $('#cadastroControlePluviometrico').hide();
    $('#tableControlePluviometrico').dataTable({
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
        "sAjaxSource": base_url + "index_cgob.php/ControlePluvRecuperaDaq",
        "fnServerParams": function (aoData) {
            aoData.push({"name": "periodo", "value": termo});
        },
        "aoColumns": [
            {data: 'DIA', "sClass": "text-center"},
            {data: 'MANHA', "sClass": "text-center"},
//            {data: 'TARDE'},
//            {data: 'NOITE'},
            {data: 'NOME', "sClass": "text-center"},
            {data: 'ULTIMA_ALTERACAO', "sClass": "text-center"},
            {data: 'ACAO', "sClass": "text-center"}
        ]
    });
}
//------------------------------------------------------------------------------
function excluirDia(id_controle_pluviometrico) {
    relatorio = confereRelatorio();
    if (relatorio == 1) {
        mensagemRelatorioFechado();
    } else {
        bootbox.confirm("Confirmar operação [EXCLUIR DIA DE CONTROLE PLUVIOMÉTRICO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/ControlePluvExcluirDaq',
                    data: {id_controle_pluviometrico: id_controle_pluviometrico},
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Excluído com Sucesso', "success");
                        var tableControlePluviometrico = $("#tableControlePluviometrico").DataTable();
                        tableControlePluviometrico.ajax.reload();
                        Recuperadiasmes();
                    }, error: function (data) {
                        $.notify('Erro no Envio', "warning");
                    }
                });
            }
        });
    }
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function Recuperadiasmes(){
    if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() === "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
           
           var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
        $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/ControlePluvDiaDaq?periodo='+termo,
        dataType: 'json',
        success: function (data) {
         if(data.conte==true){
            $("#btnInclusao").attr("disabled", true); 
         }else{
            $("#btnInclusao").attr("disabled", false); 
         }
        }, error: function (data) {
            $.notify('falha na consulta', "warning");
        }
    });    
}
