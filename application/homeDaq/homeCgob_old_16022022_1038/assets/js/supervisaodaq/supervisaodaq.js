/*
 * DNIT
 * Programador:Jordana Alencar
 * Data:05/09/2019 14:04
 * */
/*
 * DNIT
 * Programador:Sergio Ricardo
 * Nova Arquitetura
 * Data:18/06/2021 12:09
 * */
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$(document).ready(function () {
	//--------------------------------------------------------------------------------------------------------------------------------------
	$.ajaxSetup({cache: false});
	//---------------------------------------------------------------------------------------------------------------------------------------
	$('#datepicker').datepicker({
		format: "MM yyyy",
		startView: 1,
		minViewMode: 1,
		language: "pt-BR",
		autoclose: true
	});
	var myDate = new Date()
	myDate.setMonth(myDate.getMonth() - 1);
	$("#datepicker").datepicker("setDate", myDate);

	Recuperatabelacontratos();
	//---------------------------------------------------------------------------------------------------------------------------------------
	$("#search").click(function () {
		search();
	});
	//---------------------------------------------------------------------------------------------------------------------------------------
	$("#searchidcontrato").click(function () {
		searchidcontrato();
	});
	//---------------------------------------------------------------------------------------------------------------------------------------
});

//Ao clicar no ENTER------------------------------------------------------------------------------
$(document).keypress(function (e) {
	if (e.which == 13) {
		$("#search").click();
	}
});

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function passaId(id) {
	$.ajax({
		url: base_url + 'index_cgob.php/ContratoSessionDaq',
		type: 'POST',
		data: {idContrato: id},
		success: function (data) {
			$("#exibesupervisaocont").empty();
			rotaInfoContrato();
			$('#supervisaocontContrato').modal('hide');
			$('#menuRelatorioSupervisao').show();
			$("#exibesupervisaocont").empty();
		}, error: function (data) {
			$.notify('Falha no cadastro', "warning");
		}
	});
}

//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function rotaHomeObra() {
	$("#exibesupervisaocont").load(base_url + "index_cgob.php/ContratoInfoDaq").slideUp(3).delay(3).fadeIn("slow");
}

// //--------------------------------------------------------------------------------------------------------------------------------------
function rotaSupervisaoDaq() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/HomeSupervisaoDaq").slideUp(3).delay(3).fadeIn("slow");      
}

function rotaRelatorioSupervisaoDaq() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/HomeRelatorioDaq").slideUp(3).delay(3).fadeIn("slow");
}

function rotaDocumentacaoDaq() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/HomeDocumentacaoDaq").slideUp(3).delay(3).fadeIn("slow");
}

function rotahomePainelAdm() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/HomePainelDaq").slideUp(3).delay(3).fadeIn("slow");
}

function rotahomePainelGerencial() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/homePainelGerencial").slideUp(3).delay(3).fadeIn("slow");
}

//--------------------------------------------------------------------------------------------------------------------------------------
function confereRelatorio() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() === "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	var retorno = "";
	$.ajax({
		url: base_url + 'index_cgob.php/ConfereRelatorioDaq',
		type: 'POST',
		data: {periodo: termo},
		async: false,
		success: function (data) {
			retorno = data;
		}, error: function (data) {
			$.notify('Falha no cadastro', "warning");
		}
	});

	return retorno;
}

//--------------------------------------------------------------------------------------------------------------------------------------
function mensagemRelatorioFechado() {
	$.notify('Relatório concluído. Para alterações solicite ao responsável técnico!', "warning");
}

// //--------------------------------------------------------------------------------------------------------------------------------------
function rotaInfoContrato() {
	$("#exibesupervisaocont").empty();
	$("#exibesupervisaocont").load(base_url + "index_cgob.php/ContratoInfoDaq").slideUp(3).delay(3).fadeIn("slow");
}

function rotaDaq() {
	$("#exibe").empty();
	$("#exibe").load(base_url + "index_cgob.php/HomeDaq").slideUp(3).delay(3).fadeIn("slow");
}

//Formatação de valor
function troca(str, strsai, strentra) {
	while (str.indexOf(strsai) > -1) {
		str = str.replace(strsai, strentra);
	}
	return str;
}

function FormataMoeda(campo, tammax, teclapres, caracter) {
	if (teclapres == null || teclapres == "undefined") {
		var tecla = -1;
	} else {
		var tecla = teclapres.keyCode;
	}

	if (caracter == null || caracter == "undefined") {
		caracter = ".";
	}

	vr = campo.value;
	if (caracter != "") {
		vr = troca(vr, caracter, "");
	}
	vr = troca(vr, "/", "");
	vr = troca(vr, ",", "");
	vr = troca(vr, ".", "");
	tam = vr.length;
	if (tecla > 0) {
		if (tam < tammax && tecla != 8) {
			tam = vr.length + 1;
		}

		if (tecla == 8) {
			tam = tam - 1;
		}
	}
	if (tecla == -1 || tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
		if (tam <= 2) {
			campo.value = vr;
		}
		if ((tam > 2) && (tam <= 5)) {
			campo.value = vr.substr(0, tam - 2) + ',' + vr.substr(tam - 2, tam);
		}
		if ((tam >= 6) && (tam <= 8)) {
			campo.value = vr.substr(0, tam - 5) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
		}
		if ((tam >= 9) && (tam <= 11)) {
			campo.value = vr.substr(0, tam - 8) + caracter + vr.substr(tam - 8, 3) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
		}
		if ((tam >= 12) && (tam <= 14)) {
			campo.value = vr.substr(0, tam - 11) + caracter + vr.substr(tam - 11, 3) + caracter + vr.substr(tam - 8, 3) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
		}
		if ((tam >= 15) && (tam <= 17)) {
			campo.value = vr.substr(0, tam - 14) + caracter + vr.substr(tam - 14, 3) + caracter + vr.substr(tam - 11, 3) + caracter + vr.substr(tam - 8, 3) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
		}
	}
}

function maskKeyPress(objEvent) {
	var iKeyCode;
	if (window.event) // IE
	{
		iKeyCode = objEvent.keyCode;
		if (iKeyCode >= 48 && iKeyCode <= 57)
			return true;
		return false;
	} else if (e.which) // Netscape/Firefox/Opera
	{
		iKeyCode = objEvent.which;
		if (iKeyCode >= 48 && iKeyCode <= 57)
			return true;
		return false;
	}


}

function BlockKeybord() {
	if (window.event) // IE
	{
		if ((event.keyCode < 48) || (event.keyCode > 57)) {
			event.returnValue = false;
		}
	} else if (e.which) // Netscape/Firefox/Opera
	{
		if ((event.which < 48) || (event.which > 57)) {
			event.returnValue = false;
		}
	}
}

function stringToNumber(v) {
	v = v.replace(/[^\d-]/g, '');
	ep = v.length - 2;
	x = v.slice(0, ep);
	y = v.slice(-2);
	v = x + '.' + y;
	return v * 1;
}

jQuery(function ($) {

	$(".sidebar-dropdown > a").click(function () {
		$(".sidebar-submenu").slideUp(200);
		if (
			$(this)
				.parent()
				.hasClass("active")
		) {
			$(".sidebar-dropdown").removeClass("active");
			$(this)
				.parent()
				.removeClass("active");
		} else {
			$(".sidebar-dropdown").removeClass("active");
			$(this)
				.next(".sidebar-submenu")
				.slideDown(200);
			$(this)
				.parent()
				.addClass("active");
		}
	});

	$(".sidebar-dropdown-children > a").click(function () {
		$(".sidebar-submenu-children").slideUp(200);
		if (
			$(this)
				.parent()
				.hasClass("active")
		) {
			$(".sidebar-dropdown-children").removeClass("active");
			$(this)
				.parent()
				.removeClass("active");
		} else {
			$(".sidebar-dropdown-children").removeClass("active");
			$(this)
				.next(".sidebar-submenu-children")
				.slideDown(200);
			$(this)
				.parent()
				.addClass("active");
		}
	});

	$(".sidebar-dropdown-children-two > a").click(function () {
		$(".sidebar-submenu-children-two").slideUp(200);
		if (
			$(this)
				.parent()
				.hasClass("active")
		) {
			$(".sidebar-dropdown-children-two").removeClass("active");
			$(this)
				.parent()
				.removeClass("active");
		} else {
			$(".sidebar-dropdown-children-two").removeClass("active");
			$(this)
				.next(".sidebar-submenu-children-two")
				.slideDown(200);
			$(this)
				.parent()
				.addClass("active");
		}
	});

	$("#close-sidebar").click(function () {
		$(".page-wrapper").removeClass("toggled");
	});
	$("#show-sidebar").click(function () {
		$(".page-wrapper").addClass("toggled");
	});

});

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function Recuperatabelacontratos() {
	$("#exibesupervisaocont").load(base_url + "index_cgob.php/ContratoDaq").slideUp(3).delay(3).fadeIn("slow");
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function search() {

	var tamanho = $("#q").val().length;
	var contrato = $("#q").val();


	if (tamanho >= 3) {
		$('#supervisaocontContrato').modal('show');
		$('#contrato_supervisao').dataTable({
			"bProcessing": false,
			"destroy": true,
			"bFilter": false,
			"bInfo": false,
			"bLengthChange": false,
			"bPaginate": false,
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
			"sAjaxSource": base_url + "index_cgob.php/ContratoRecuperaDaq?contrato=" + contrato,
			"fnServerParams":
				function (aoData) {
					aoData.push({"name": "contrato", "value": contrato});
				},
			"aoColumns": [
				{data: 'CONTRATO'},
				{data: 'SUPERVISORA'},
				{data: 'BRUF'},
				{data: 'STATUS'}
			]
		});
	} else {
		$.notify('Forneça 3 ou mais caracters para pesquisa', "warning");
	}
}

// //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

