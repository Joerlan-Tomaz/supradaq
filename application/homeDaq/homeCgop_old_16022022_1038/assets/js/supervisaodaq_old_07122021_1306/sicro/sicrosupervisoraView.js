//############################################################################ 
//# 
//# DNIT
//# sicroView.js
//# Desenvolvedor:Jordana Alencar 
//# Data:01/12/2019 
//# 
//############################################################################ 
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$().ready(function () { 
    //------------------------------------------------------------------------
        $('#tableitens').hide();
    //------------------------------------------------------------------------
        $("#sicro").prop("disabled", true);
        $("#tipo").prop("disabled", true);
        $("#sicro").val("");
        $("#tipo").val("");
    //------------------------------------------------------------------------
        Recupera_item_cadastro();  
    //------------------------------------------------------------------------ 
        $("#itemcadastro").change(function () {
             if($("#itemcadastro").val() != 'Selecione'){
                $("#sicro").prop("disabled", false);
                $("#tipo").prop("disabled", false);
                $("#sicro").val("");
                $("#tipo").val("");
                Recupera_relacao_item_cadastro();   
            }else{
                $("#sicro").prop("disabled", true);
                $("#tipo").prop("disabled", true);
            }


        });
    //------------------------------------------------------------------------ 
        $("#sicro").on("input", function(){       
            Recupera_relacao_item_cadastro();
        });
    //------------------------------------------------------------------------  
        $("#tipo").on("input", function(){        
             Recupera_relacao_item_cadastro();
        });
    //------------------------------------------------------------------------    
});
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function Recupera_item_cadastro() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgop.php/SicroSupervisoraItemDaq',
        dataType: 'json',
        success: function (data) {
            var itemcadastro = $('select[id=itemcadastro]');
            itemcadastro.html('');
            itemcadastro.append('<option value="Selecione" selected >Selecione</option>');
            for (i = 0; i < data.item.length; i++) {
                itemcadastro.append('<option value="' + data.item[i] + '">' + data.item[i] + '</option>');

            }

        }

    });

}
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function Recupera_relacao_item_cadastro() {
    $('#tableitens').show(); 
    itemcadastro = $("#itemcadastro").val();
    sicro = $("#sicro").val();
    tipo = $("#tipo").val();
    var table = $('#tablecadastraritem').DataTable();
    table.destroy();
    $('#tablecadastraritem').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bLengthChange": false,
        "pageLength": 200,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 200,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgop.php/SicroSupervisoraRelacaoItemDaq?itemcadastro=" + itemcadastro +"&sicro="+sicro+"&tipo="+tipo,

        "aoColumns": [
            {data: 'conte'},
            {data: 'item'},
            {data: 'cod_sicro'},
            {data: 'tipo'},
            {data: 'unidade'},
            {data: 'acao'}
        ]

    });
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function CadastrarItem(id_sicro) {
            
    relatorio = confereRelatorio();
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
                bootbox.confirm("Confirmar operação [Cadastrar Item]?", function (result) {
                    if (result === true) {  
            
           $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgop.php/SicroSupervisoraCadastraItemDaq?id_sicro='+id_sicro,
                    data: {
                    periodo: termo
                },
                    dataType: 'json',
                    success: function (data) {
                        $.notify('[Cadastrado com sucesso]', "success");
                        var table = $('#tablecadastraritem').DataTable();
                        table.ajax.reload();
                       
                    }, error: function (data) {
                        $.notify('Falha no cadastro', "warning");
                        
                    }
            });
        }
        });
    }
        

}

