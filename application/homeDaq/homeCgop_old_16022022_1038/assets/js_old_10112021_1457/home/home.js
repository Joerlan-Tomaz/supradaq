$(document).ready(function () { 
	// $.ajax({
	//     method: "POST",
	//     url: base_url +'/Login/FotoMiniatura'
	// }).done(function (resultado) {
	//     try {
	//         resultado = resultado.replace(/\+g/, " ");
	//         resultado = unescape(resultado);
	//         $('#fotoMiniatura').html(resultado);

	//     } catch (e) {
	//         $('#fotoMiniatura').html('<p>Ouve algum erro na requisição</p>');
	//     }
	// });
	//----------------------------------------------------------------------------------------------------------------------------------
	var horario = new Date();

	if ((horario.getHours() >= 01) && (horario.getHours() < 12)) {
		$('#turno').text('Bom dia, ');

	} else if ((horario.getHours() >= 12) && (horario.getHours() < 18)) {
		$('#turno').text('Boa tarde, ');

	} else if ((horario.getHours() >= 18) && (horario.getHours() < 20)) {
		$('#turno').text('Boa noite, ');

	} else if ((horario.getHours() >= 20) && (horario.getHours() < 23)) {
		$('#turno').text('Boa noite, ');

	} else {
		$('#turno').text('Bom dia, ');
	}
	$('input').not('#auto').keypress(function (e) {
		if (e.which == 13) { // se pressionar enter
			// console.log('pode submeter'); // aqui pode submeter o form
		}
	});

//-----------------------------------------------------------------------------------------------------------------------------------
//    var scroll_pos = 0;
//    $(document).scroll(function () {
//        scroll_pos = $(this).scrollTop();
//        if (scroll_pos > 80) {
//            $(".headerPrincipal").css('background-color', 'rgba(0,0,0,.5)');
//        } else {
//            $(".headerPrincipal").css('background-color', 'rgba(0,0,0,.2)');
//        }
//    });

	//-----------------------------------------------------------------------------------------------------------------------------------

   // $("#exibe").load("HomeGeral").slideUp(3).delay(3).fadeIn("slow");

    //-----------------------------------------------------------------------------------------------------------------------------------
    $(document).on('keyup', '.num_inteiro', function (e) {
        e.preventDefault();
        $(this).val($(this).val().replace(/\D/g, ''));
    });
    $(document).on('keyup', '.percentual', function (e) {
        e.preventDefault();
        var tecla = ( window.event ) ? e.keyCode : e.which;
        var ctrlDown = e.ctrlKey||e.metaKey;
        var texto = $(this).val();
        texto = texto.replace('.', ',');
        texto = texto.replace('-', '');
        texto = texto.replace(' ', '');
        if (ctrlDown && tecla == 86) {
            $(this).val(texto);
            return false;
        }
        var fimStr = texto.length - 1;
        var textoAntes = texto.substring(0, fimStr);
        var indexvir = textoAntes.indexOf(",");
        var indexpon = textoAntes.indexOf(".");
        if ( tecla == 44 || tecla == 46 || tecla == 110 || tecla == 188 || tecla == 194 || tecla == 190){
            if (indexvir !== -1 || indexpon !== -1) {
                $(this).val(textoAntes);
                return false;
            }
        } else {
            if ( tecla == 8 ){
                return true;
            }
            if ((tecla > 95 && tecla < 106) || (tecla > 47 && tecla < 58)){
                if (indexvir !== -1){
                    textoAntes = texto.substring(0, indexvir + 6);
                    $(this).val(textoAntes);
                }
//                var vPercentual = parseFloat(texto.replace(',', '.'));
//                if (vPercentual > 100){
//                    vPercentual = 100;
//                    $(this).val(vPercentual);
//                }
                return true;
            } else {
                var ultimoCaracter = texto.substring(fimStr);
                if ((ultimoCaracter == '0') || (ultimoCaracter == '1') || (ultimoCaracter == '2') || (ultimoCaracter == '3') || (ultimoCaracter == '4') ||
                    (ultimoCaracter == '5') || (ultimoCaracter == '6') || (ultimoCaracter == '7') || (ultimoCaracter == '8') || (ultimoCaracter == '9') || (ultimoCaracter == ',') ){
                    $(this).val(texto.replace('-', ''));
                } else {
                    $(this).val(textoAntes.replace('-', ''));
                }
                return false;
            }
        }
    });
});
//------------------------------------------------------------------------------
function rota_Cgob() { 
    $("#exibe").empty();
    $("#exibe").load(base_url + "index_cgob.php/Home/homeCgob").slideUp(3).delay(3).fadeIn("slow");
   
}
//------------------------------------------------------------------------------
function rota_Cgop() { 
    $("#exibe").empty();
    $("#exibe").load(base_url + "index_cgop.php/Home/homeCgob").slideUp(3).delay(3).fadeIn("slow");
   
}
//------------------------------------------------------------------------------

//-----------------------------------------ROTAS COMUNS DIF/DAQ--------------------------------------
/*function rotaHome() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/JbnsgCdGG-1h4IXjlVTT3w").slideUp(3).delay(3).fadeIn("slow");
}*/
function rotaHome() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/Home/homeCgob").slideUp(3).delay(3).fadeIn("slow");
}

function rotaPerfil() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/L-nk35tmdwwbkJHiufA9Rw").slideUp(3).delay(3).fadeIn("slow");
}

//-------------------------------------------------------------------------------------------------
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

//-------------------------------------------------------------------------------------------------
function alterarSenhaPrimeiroLogin() {
	if ($("#edtAtual").val() == "") {
		$.notify("Por favor, informe a senha atual", 'info');
		$("#edtAtual").focus();
		return false;
	} else if ($("#edtNova").val() == "") {
		$.notify("Por favor, informe sua nova senha", 'info');
		$("#edtNova").focus();
		return false;
	} else if ($("#edtConfirmar").val() == "") {
		$.notify("Por favor, confirme sua nova senha", 'info');
		$("#edtConfirmar").focus();
		return false;
	} else if ($("#edtConfirmar").val() !== $("#edtNova").val()) {
		$.notify("As senhas nao correspondem", 'info');
		document.getElementById('edtConfirmar').style.borderColor = 'red';
		document.getElementById('edtNova').style.borderColor = 'red';
		return false;
	}
	document.getElementById('edtConfirmar').style.borderColor = '#d2d6de';
	document.getElementById('edtNova').style.borderColor = '#d2d6de';
	//---------------- Validação de formulario ---------------------------------
	var serializedData = new FormData();
	serializedData = $("#formNovaSenhaPrimeiroLogin").serializeArray();
	//--------------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [ALTERAR SENHA]?", function (result) {
		if (result == true) {
			$.ajax({
				type: 'POST',
				url: 'sax06gu0XKFsklBxlSnO1A',
				data: serializedData,
				dataType: 'json',
				success: function (data) {
					$.notify(data.mensagem, data.notify);
					$("#alterasenhaModal").modal("hide");
					window.location.reload()
				}, error: function (data) {

				}
			});
		}
	});
}


//Função para redirecionar página
function redirecionamento(url) {
	// setTimeout(function () {

	window.location = url;
	//setTimeout(function () {
	// rotaContagem();
	//});
	//  }, 0);
}

$(document).ajaxStart(function () {
	$(".log").show();
});

$(document).ajaxStop(function () {
	$(".log").hide();
});
