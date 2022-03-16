//############################################################################  
//# DNIT- AQUAVIARIO
//# relatorioview.js
//# @Jordana Alencar
//# Data:07/07/2020
//############################################################################ 
$().ready(function () {

    //-------------------------------------------------------
    $('#elaboracao').hide();
    $('#correcao').hide();  
    $('#Concluirrelatorio').hide(); //finalizarRelatorio
    $('#aguardandoanalise').hide();
    $('#aguardandoanaliseFiscal').hide();
    $('#aguardandoanaliseResponsavel').hide(); 
//texto do resultado tecnico estrutural
    $('#resultadotecnico').hide();
    $('#resultadoestrutural').hide();
    // $('#GerarRelatorio').hide();
    $("#GerarRecibo").hide();
    $("#GerarResultadoTecnico").hide();
    $("#GerarResultadoEstrutural").hide();
	botaoRelatorio();
    //-------------------------------------------------------
    elaboracaorelatorio();
    //-------------------------------------------------------
    $("#searchdate").click(function () {
       elaboracaorelatorio();
    });
    //-------------------------------------------------------
    $("#GerarResultadoEstrutural").click(function () {
        GerarResultadoEstrutural();
    });
    //-------------------------------------------------------
    $("#GerarResultadoTecnico").click(function () {
        GerarResultadoTecnico();
    });    
    //-------------------------------------------------------
    $("#GerarRelatorio").click(function () {
        returnRelatorio();
    });
    //-------------------------------------------------------
    $("#GerarRecibo").click(function () { 
        returnRecibo();
    });
    //-------------------------------------------------------
    $("#GerarResultado").click(function () {
        GerarResultado();
    });
        $('#datepicker').on("changeDate", function() {
        elaboracaorelatorio();
    });
    //-------------------------------------------------------
     $("#Concluirrelatorio").click(function () {
        finalizarRelatorio();
    });
});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function searchdate() {
    var dt = $("#datepicker").datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    //-----------------------------------------------------------------------------------------------------------------------
    elaboracao(termo);
    dadosContrato(termo);
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function elaboracao(termo) {

var dt = $("#datepicker").datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    //--------------------------------------------------
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioResultadoDaq',
        data: {periodo: termo},
        dataType: 'json',
        success: function (data) {
           
             if (data.relaboracao >= 1 & data.relaboracao < 32) {
                $('.elaboracao').removeClass('nao_preenchido').addClass('emelaboracao');
                $('.elaboracao').removeClass('aprovado').addClass('emelaboracao');
                $('.conclusao').removeClass('aprovado').addClass('nao_preenchido');
                $('#aguardandoanalise').hide();
                $('#aguardandoanaliseFiscal').hide();
                $('#aguardandoanaliseResponsavel').hide();  
                // $('#GerarRelatorio').hide();
                $("#GerarRecibo").hide();  
                $('#Concluirrelatorio').hide();
                $('#correcao').hide();
                
            }
            if(data.relaboracao < 32){
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.impressora').removeClass('aprovado').addClass('nao_preenchido'); 
                $('#GerarResultadoEstrutural').hide();
                $('#GerarResultadoTecnico').hide();
                // $('#GerarRelatorio').hide();
                $("#GerarRecibo").hide();
                $('#aguardandoanalise').hide();
                $('#aguardandoanaliseFiscal').hide();
                $('#aguardandoanaliseResponsavel').hide();  
                $('#Liberarrelatorio').hide();
                $('#elaboracao').show();
                $('#correcao').hide();  
            }
            if (data.relaboracao >= 32) {
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('reprovado').addClass('nao_preenchido'); 
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analisetecnica').removeClass('reprovado').addClass('nao_preenchido');
				if(data.perfil == 2){
					$('#Concluirrelatorio').show();
				}
                $('#elaboracao').hide();
                $('#GerarRecibo').hide();
                $('#GerarResultadoTecnico').hide();
                $('#GerarResultadoEstrutural').hide();  
                $('#Liberarrelatorio').hide();             
            }
            if(data.relaboracao == 0){
                $('.elaboracao').removeClass('nao_preenchido').addClass('nao_preenchido');
                $('.elaboracao').removeClass('aprovado').addClass('nao_preenchido');
                $('.elaboracao').removeClass('emelaboracao').addClass('nao_preenchido');
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.conclusao').removeClass('aprovado').addClass('nao_preenchido');
                $('.conclusao').removeClass('nao_preenchido').addClass('nao_preenchido');
                $('.impressora').removeClass('aprovado').addClass('nao_preenchido'); 
                $('#GerarResultadoEstrutural').hide();
                $('#GerarResultadoTecnico').hide();
                $('#GerarRecibo').hide();
                // $('#GerarRelatorio').hide();
                $('#aguardandoanalise').hide(); 
                $('#aguardandoanaliseFiscal').hide(); 
                $('#Liberarrelatorio').hide();
                $('#elaboracao').hide();  
                $('#correcao').hide();  
                $('#Concluirrelatorio').hide(); 
                $('#aguardandoanaliseResponsavel').hide();
            }
            
        }, error: function (data) {
            $.notify('Falha ', "warning");
            
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function conclusao(termo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioConclusaoDaq',
        data: {
            periodo: termo
        },
        dataType: 'json',
        success: function (data) {
            if (data.roteiro == 'liberar_relatorio' || data.roteiro == 'fechar_relatorio' || data.roteiro == 'aceite_supervisora' || data.roteiro == 'analise_') {
                $('.conclusao').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line aprovado');
                //analisetecnica(termo);
            } else {
                $('.conclusao').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line nao_preenchido');

            }

        }, error: function (data) {
            $.notify('Falha ', "warning");
            
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function analisetecnica(termo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioTecnicaDaq',
        data: {
            periodo: termo
        },
        dataType: 'json',
        success: function (data) {
            if (data.analise_fiscal == 2 && data.cont_aceite_fiscal_nok >= 1) {
                $('.analisetecnica').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line reprovado');
                $('#resultadotecnico').show();

            } else if (data.analise_fiscal == 2 && data.cont_aceite_fiscal_nok == 0) {
                $('.analisetecnica').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line aprovado');
                $('#resultadotecnico').hide();
                analiseestrutural(termo);
            } else {
                $('.analisetecnica').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line nao_preenchido');
                $('#resultadotecnico').hide();
            }

        }, error: function (data) {
            $.notify('Falha ', "warning");
            
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function analiseestrutural(termo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioEstruturalDaq',
        data: {
            periodo: termo
        },
        dataType: 'json',
        success: function (data) {
            if (data.inicio_analise_cgcont == 2 && data.cont_aceite_analista_nok >= 1) {
                $('.analiseestrutural').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line reprovad');
                $('#resultadoestrutural').show();

            } else if (data.inicio_analise_cgcont == 2 && data.cont_aceite_analista_nok == 0) {
                $('.analiseestrutural').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line aprovado');
                $('#resultadoestrutural').hide();
                imprimir(termo);

            } else {
                $('.analiseestrutural').removeClass('info-box-icon circle-line nao_preenchido').addClass('info-box-icon circle-line nao_preenchido');
                $('#resultadoestrutural').hide();
            }

        }, error: function (data) {
            $.notify('Falha ', "warning");
            
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function imprimir() {
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
        url: base_url + 'index_cgob.php/RelatorioImprimirDaq',
        data: {
            periodo: termo
        },
        dataType: 'json',
        success: function (data) {
            if (data.analise_cord == 2 && data.status_aceite_fiscal == 0 && data.analise_fiscal == 2 && data.status_aceite_fiscal == 0 && data.roteiro != 'liberar_relatorio') {
                $('.imprimir').removeClass('bg-default').addClass('bg-blue');
                $('#imprimir').show();

            } else {
                $('.imprimir').removeClass('bg-default').addClass('bg-default');
                // $('#imprimir').hide();
            }

        }, error: function (data) {
            $.notify('Falha ', "warning");
            
        }
    });
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function dadosContrato() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker("getDate");
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $.ajax({
        type: 'POST',
        url:base_url + 'index_cgob.php/RelatorioVersaoDaq',
        data: {
            periodo: termo
        },
        dataType: 'json',
        success: function (data) {
            val_contrato = data.contrato;
            var label_contrato = val_contrato;
            $('.label_contrato').text(label_contrato);
            //---------------------------------------------
            val_supervisora = data.supervisora;
            var label_supervisora = val_supervisora;
            $('.label_supervisora').text(label_supervisora);
            //----------------------------------------------
            val_rp = data.rp;
            var label_rp = val_rp;
            $('.label_rp').text(label_rp);
            //----------------------------------------------
            val_versao = data.versao;
            var label_versao = val_versao;
            $('.label_versao').text(label_versao);
            //----------------------------------------------
            val_uf = data.uf;
            var label_uf = val_uf;
            $('.label_uf').text(label_uf);
            //----------------------------------------------
            dadosRelatorio(termo)
            
        }, error: function (data) {
            $.notify('Falha', "warning");
            
        }
    });
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function dadosRelatorio() {

        if (document.getElementById) {
        var dt = $("#datepicker").datepicker("getDate");
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    
    var table = $('#tableRelatorio').DataTable();
    table.destroy();
    //---------------------------------------------------------
    $('#tableRelatorio').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "paging": false,
        "sAjaxSource": base_url + "index_cgob.php/RelatorioModulosDaq",
        "fnServerParams":
        function (aoData) {
            aoData.push(
                    {"name": "periodo", "value": termo}
            );
        },
        "aoColumns": [
            {data: 'cont'},
            {data: 'modulo'},
            {data: 'nome'},
            {data: 'data'},
            {data: 'acao',"sClass": "text-center"}

        ]
    });
}
 //----------------------------------------------------------------------------------------------//
function perfil() {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioValidaDaq',
        dataType: 'json',
        async: false,
        success: function (data) {
            retorno = data;
        }, error: function (data) {
           
        }
    });
    return retorno;
}
//----------------------------------------------------------------------
function finalizarRelatorio() {  
        if (document.getElementById) {
            var dt = $("#datepicker").datepicker('getDate');
            if (dt.toString() == "Invalid Date") {
                $("#datepicker").datepicker("setDate", new Date());
                return;
            }
            var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        }
//---------------------------------------------------------------------
     var Validar = perfil();
     if (Validar != true) {
        $.notify(Validar.mensagem, "warning");
         return false;
    }
    //----------------------------------------------------------------------------------------------------------------//
        bootbox.confirm("Confirmar a operação [ENVIAR RELATORIO]?", function (result) {
            if (result === true) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'index_cgob.php/RelatorioFinalizarDaq?periodo='+termo,
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Relatório concluido , aguardando análise...', "success");
						$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
						$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
						$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
						$('#correcao').hide();
						$('#aguardandoanalise').show();
						$('#Concluirrelatorio').hide();
						$('#elaboracao').hide();
						$('#reaberto').hide();
						// $('#GerarRelatorio').hide();
						$('#correcao').hide();
                    }, error: function (data) {
                        $.notify("Falha no cadastro", "warning");
                         
                    }
                });
            }
        });
    }
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function returnRecibo() {

    var dt = $("#datepicker").datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    
    jan = window.open(base_url + 'index_cgob.php/RelatorioReciboDaq?periodo=' + termo, 'jan', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=100, LEFT=left, WIDTH=800, HEIGHT=500');
}

function returnRelatorio() { 

    var dt = $("#datepicker").datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";    
  
    
        jan = window.open(base_url + 'index_cgob.php/ImpressaoRelatorioDaq?periodo=' + termo, 'jan', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=100, LEFT=left, WIDTH=800, HEIGHT=500');
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function GerarResultado() {
    jan = window.open(base_url + 'index_cgob.php/RelatorioResultadoModalDaq', 'jan', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=100, LEFT=left, WIDTH=800, HEIGHT=500');
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
// function reciboDaq() {
//     $.ajax({
//         type: 'POST',
//         url: 'ReciboValidaDaq',
//         dataType: 'json',
//         async: false,
//         success: function (data) {
//             retorno = data;
//         }, error: function (data) {
           
//         }
//     });
//     return retorno;
// }
//----------------------------------------------------------------------
function elaboracaorelatorio(){ 
    if(document.getElementById){
        var dt = $( "#datepicker" ).datepicker('getDate');
        if (dt.toString() == "Invalid Date"){
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }

        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1)>9? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
        
    }

    dadosContrato(termo);
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioElaboracaoDaq?periodo='+termo,
        dataType: 'json',
        success: function (data) {
			if(data.data == 'reaberto'){
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
				$('.analisetecnica').removeClass('nao_preenchido').addClass('reprovado');
				$('.analiseestrutural').removeClass('nao_preenchido').addClass('reprovado');
				$('.impressora').removeClass('nao_preenchido').addClass('reprovado');
				$('#GerarResultadoEstrutural').show();
				$('#GerarResultadoTecnico').show();
				$('#correcao').hide();
				$('#aguardandoanalise').hide();
				if(data.perfil == 2){
					$('#Concluirrelatorio').show();
				}
				$('#elaboracao').hide();
				$('#reaberto').show();
				// botaoRelatorio();
				$('#aguardandoanaliseResponsavel').hide();
				$('#aguardandoanaliseFiscal').hide();
			}
            if(data.data == 'Aprovado'){
                $('#Concluirrelatorio').hide(); 
                $('#aguardandoanalise').hide(); 
                $('.analisetecnica').removeClass('nao_preenchido').addClass('aprovado');
                $('.analisetecnica').removeClass('reprovado').addClass('aprovado');  
                $('.analiseestrutural').removeClass('nao_preenchido').addClass('aprovado'); 
                $('.analiseestrutural').removeClass('reprovado').addClass('aprovado'); 
                $('.impressora').removeClass('nao_preenchido').addClass('aprovado'); 
                $('.impressora').removeClass('reprovado').addClass('aprovado');
                $('#GerarResultadoEstrutural').hide();
                $('#GerarResultadoTecnico').hide();
                $('#Liberarrelatorio').hide(); 
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('#elaboracao').hide();
                // botaoRelatorio();
                botaoRecibo();
                $('#aguardandoanaliseResponsavel').hide();
                $('#aguardandoanaliseFiscal').hide(); 
                   
            }
            if(data.data == 'Reprovado'){ 
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('#elaboracao').hide();
                $('#Concluirrelatorio').hide(); 
                $('#aguardandoanalise').hide(); 
                $('.analisetecnica').removeClass('nao_preenchido').addClass('reprovado'); 
                $('.analiseestrutural').removeClass('nao_preenchido').addClass('reprovado'); 
                $('.impressora').removeClass('nao_preenchido').addClass('reprovado'); 
                $('#GerarResultadoEstrutural').show();
                $('#GerarResultadoTecnico').show();
                // $('#GerarRelatorio').hide();
                // $("#GerarRecibo").hide();
                $('#Liberarrelatorio').show();
                $('#aguardandoanaliseResponsavel').hide();
                $('#aguardandoanaliseFiscal').hide();
            }
            if(data.data == 'ReprovadoAnalista'){
                $('#Concluirrelatorio').hide();
                $('#aguardandoanalise').hide();
                $('.analisetecnica').removeClass('nao_preenchido').addClass('aprovado');
                $('.analiseestrutural').removeClass('nao_preenchido').addClass('reprovado');
                $('.impressora').removeClass('nao_preenchido').addClass('reprovado');
                $('#GerarResultadoEstrutural').show();
                $('#GerarResultadoTecnico').hide();
                // $('#GerarRecibo').hide();
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                // $('#GerarRelatorio').hide();
                $('#aguardandoanaliseResponsavel').hide();
				$('#Liberarrelatorio').show();
            }
            if(data.data == 'ReprovadoFiscal' || data.data == 'ReprovadoFiscalEstrutural'){
                if(data.data == 'ReprovadoFiscal'){
					$('#GerarResultadoTecnico').show();
					$('.analisetecnica').removeClass('nao_preenchido').addClass('reprovado');
				}else{
                	$('#GerarResultadoEstrutural').show();
					$('.analiseestrutural').removeClass('nao_preenchido').addClass('reprovado');
				}
                $('#Concluirrelatorio').hide();
                $('#aguardandoanalise').hide();
                $('.impressora').removeClass('nao_preenchido').addClass('reprovado');
                $('#Liberarrelatorio').show();
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('#aguardandoanaliseFiscal').hide();
				if(data.perfil == 2){
					$('#Concluirrelatorio').show();
				}
            }
            if(data.data == 'liberar_relatorio'){ 
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('#correcao').show();
                $('#aguardandoanalise').hide();
				if(data.perfil == 2){
					$('#Concluirrelatorio').show();
				}
                $('#elaboracao').hide();
                // botaoRelatorio();
                $('#aguardandoanaliseResponsavel').hide();
                $('#aguardandoanaliseFiscal').hide();
            }
            if(data.data == 'fechar_relatorio'){
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');  
                $('#correcao').hide(); 
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analisetecnica').removeClass('reprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('reprovado').addClass('nao_preenchido'); 
                $('#GerarResultadoEstrutural').hide();
                $('#GerarResultadoTecnico').hide();   
                // $('#GerarRecibo').hide();
                $('#Liberarrelatorio').hide(); 
                // $('#aguardandoanalise').show();
                $('#Concluirrelatorio').hide(); 
                $('#elaboracao').hide(); 
                // $('#GerarRelatorio').hide();
                $('#aguardandoanaliseResponsavel').hide();
                $('#aguardandoanaliseFiscal').hide();
				if(data.perfil == 2){
					$('#Concluirrelatorio').show();
				}
            }
           
            if(data.data == 'Elaboracao'){
                elaboracao();
            }
            if(data.data == 'aguardando_analise'){
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('#correcao').hide();
                $('#aguardandoanalise').show();
                $('#Concluirrelatorio').hide();
                $('#elaboracao').hide();
                // $('#GerarRelatorio').hide();
                $('#correcao').hide();
				$('#GerarResultadoTecnico').show();

            }
            if(data.data == 'aguardando_analise_fiscal'){
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido');
                $('.analisetecnica').removeClass('reprovado').addClass('nao_preenchido');
                $('.analiseestrutural').removeClass('nao_preenchido').addClass('aprovado');
                $('.analiseestrutural').removeClass('reprovado').addClass('aprovado');
                $('#Concluirrelatorio').hide();
                $('#correcao').hide();
                $('#aguardandoanaliseFiscal').show();
                $('#aguardandoanaliseResponsavel').hide();
                // $('#GerarRelatorio').hide();
                $('#aguardandoanalise').show();
            }
            if(data.data == 'aguardando_analise_analista'){
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.analisetecnica').removeClass('nao_preenchido').addClass('aprovado'); 
                $('.analisetecnica').removeClass('reprovado').addClass('aprovado'); 
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido');
                $('.analiseestrutural').removeClass('reprovado').addClass('nao_preenchido');  
                $('#Concluirrelatorio').hide(); 
                $('#correcao').hide(); 
                $('#aguardandoanaliseResponsavel').show();
                $('#aguardandoanaliseFiscal').hide(); 
                // $('#GerarRelatorio').hide();
            }
            if(data.data == null){
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.analisetecnica').removeClass('nao_preenchido').addClass('aprovado');
				$('.analiseestrutural').removeClass('nao_preenchido').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('.impressora').removeClass('nao_preenchido').addClass('aprovado');
				$('#GerarResultadoTecnico').show();
				$('#GerarResultadoEstrutural').show();
                                botaoRecibo();
			}
           
        }, error: function (data) {
            $.notify('Falha recuperar relatorio', "warning");
           
        }
        
});
}

function botaoRelatorio(){
	$('#botaoRelatorio').html('<button type="button" name="GerarRelatorio" id="GerarRelatorio" type="button" class="btn btn-xs btn-block btn-sm btn-primary">Relatório</button>');
}

function botaoRecibo(){ 
	$('#botaoRecibo').html('<button type="button" onclick = "GerarRelatorio()" name="GerarRecibo" id="GerarRecibo" class="btn btn-block btn-xs btn-sm btn-primary">Recibo</button>');
}
//#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function GerarResultadoEstrutural(){
    if(document.getElementById){
        var dt = $( "#datepicker" ).datepicker('getDate');
        if (dt.toString() == "Invalid Date"){
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }

        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1)>9? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    //---------------------------------------------------------
    $("#ModalResultadoAnalise").modal(); 
    //---------------------------------------------------------
    var table = $('#HistoricoAnalise').DataTable();
    table.destroy();
    //---------------------------------------------------------
    $('#HistoricoAnalise').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "paging": false,
        "sAjaxSource": base_url + "index_cgob.php/RelatorioResultadoEstruturalDaq",
        "fnServerParams":
                function (aoData) {
                    aoData.push(
                            {"name": "periodo", "value": termo}
                    );
                },
        "aoColumns": [
            {data: 'cont'},
            {data: 'modulo'},
            {data: 'motivo'},
            {data: 'referencia'},
            {data: 'data'},
            {data: 'responsavel'}

        ]
    });
}
//#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function GerarResultadoTecnico(){
    if(document.getElementById){
        var dt = $( "#datepicker" ).datepicker('getDate');
        if (dt.toString() == "Invalid Date"){
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }

        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1)>9? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    //---------------------------------------------------------
    $("#ModalResultadoAnalise").modal(); 
    //---------------------------------------------------------
    var table = $('#HistoricoAnalise').DataTable();
    table.destroy();
    //---------------------------------------------------------
    $('#HistoricoAnalise').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "paging": false,
        "sAjaxSource": base_url + "index_cgob.php/RelatorioResultadoTecnicoDaq",
        "fnServerParams":
                function (aoData) {
                    aoData.push(
                            {"name": "periodo", "value": termo}
                    );
                },
        "aoColumns": [
            {data: 'cont'},
            {data: 'modulo'},
            {data: 'motivo'},
            {data: 'referencia'},
            {data: 'data'},
            {data: 'responsavel'}

        ]
    });
}
//-----------------------------------------------------------------------
function GerarRelatorio(){
    returnRecibo();
}
