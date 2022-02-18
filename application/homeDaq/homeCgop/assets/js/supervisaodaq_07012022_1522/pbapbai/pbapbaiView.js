//######################################################################################################################################################################################## 
//# DNIT
//# pbapbiView.js
//# Desenvolvedor:jordana
//# Data: 10/10/2019 09:59
//########################################################################################################################################################################################
/*----------------------------------------------------------------------------*/
$().ready(function () {
	CKEDITOR.replace("descricao", {height: 250});
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
		// document.getElementById("datepicker").disabled = true;
		$('#novo_pbapbai').hide();
		$('#cadastroPbaPbai').show();
		// populaPbaPbai();
		// populaTipoLicenca();
		populaInfraEstrutura();
		// document.getElementById("pba").disabled = true;
		// document.getElementById("pbai").disabled = true;
		//populaPba();
		//populaPbai();
		$("#searchdate").show();
		$("#voltar").hide();
		$('#btnInclusao').hide();
		$('#inserePbaPbai').show();
		$('#editarPbaPbai').hide();
		//----------------------------------------------------
		$(".nomearquivo").text("");
		// $('#pba').val("");
		// $('#pbai').val("");
		CKEDITOR.instances["descricao"].setData("");

		//  }
	});
	//--------------------------------------------------------------------------------------------------------------------------------------------------
	$("#editarPbaPbai").click(function () {
		alterarPbaPbai();
		$('#editarPbaPbai').show();
		$(".nomearquivo").text('');
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
		"sAjaxSource": base_url + "index_cgop.php/PbaPbaiRecuperaDaq?periodo="+termo,
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "NOME_INFRAESTRUTURA", "sClass": "text-justify", "width": "15%"},
			{data: "RESUMO", "sClass": "text-justify", "width": "40%"},
			{data: "TIPO", "sClass": "text-center", "width": "20%"},
			{data: "STATUS", "sClass": "text-center", "width": "10%"},
			{data: "ARQUIVO", "sClass": "text-center", "width": "30%"},
			{data: "NOME", "sClass": "text-center", "width": "30%"},
			{data: "ULTIMA_ALTERACAO", "sClass": "text-center", "width": "25%"},
			{data: "ACAO", "sClass": "text-center", "width": "15%"}
		]
	});
}
//------------------------------------------------------------------------------
function excluirPbaPbai(id_pba_pbai, id_arquivo) {
	bootbox.confirm("Confirmar operação [EXCLUIR PBA / PBAI]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgop.php/PbaPbaiExcluirDaq",
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
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function editarPbaPbai(id_pba_pbai, id_arquivo) {
	$('#hdn_pbapbai').val(id_pba_pbai);
	$('#hdn_pbapbaiarquivo').val(id_arquivo);
	populaTipoLicenca();
	$.ajax({
		type: "POST",
		url: base_url + "index_cgop.php/PbaPbaiEditarDaq",
		data: {id_pba_pbai: id_pba_pbai, id_arquivo: id_arquivo},
		dataType: "json",
		success: function (data) {

			document.getElementById("datepicker").disabled = true;
			$('#novo_pbapbai').hide();
			$('#cadastroPbaPbai').show();
			$('#tipo').val(data.tipo);
			$('#status').val(data.status);
			CKEDITOR.instances["descricao"].setData(data.descricao);

			$("#searchdate").show();
			$("#voltar").hide();
			$(".nomearquivo").text(data.nomearquivo);
			$('#btnInclusao').hide();
			$('#inserePbaPbai').hide();
			$('#editarPbaPbai').show();

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

	if($("#nome_infraestrutura").val()== "Selecione"){
		$.notify("Informe o campo [Nome da Infraestrutura].", "warning");
		document.getElementById("nome_infraestrutura").style.borderColor = "red";
		return false
	}else{
		document.getElementById("nome_infraestrutura").style.borderColor = "gray";
	}
	if($("#tipo").val()== "Selecione"){
		$.notify("Informe o campo [Tipo].", "warning");
		document.getElementById("tipo").style.borderColor = "red";
		return false
	}else{
		document.getElementById("tipo").style.borderColor = "gray";
	}
	if($("#status").val()== "Selecione"){
		$.notify("Informe o campo [Tipo].", "warning");
		document.getElementById("status").style.borderColor = "red";
		return false
	}else{
		document.getElementById("status").style.borderColor = "gray";
	}
	var descricao = CKEDITOR.instances["descricao"].getData();
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
	bootbox.confirm("Confirmar operação [INSERIR PLANO AMBIENTAL]?", function (result) {
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
				url: base_url + 'index_cgop.php/PbaPbaiInsereDaq',
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
        
    if($("#tipo").val()== "Selecione"){
    $.notify("Informe o campo [Tipo].", "warning");
    document.getElementById("tipo").style.borderColor = "red";
    return false
    }else{
         document.getElementById("tipo").style.borderColor = "gray";
    }
    if($("#status").val()== "Selecione"){
        $.notify("Informe o campo [PBA].", "warning");
        document.getElementById("status").style.borderColor = "red";
        return false
    }else{
         document.getElementById("status").style.borderColor = "gray";
    }
    var descricao = CKEDITOR.instances["descricao"].getData();
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
                       url: base_url + 'index_cgop.php/PbaPbaiInsereDaq',
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
		url: base_url + 'index_cgop.php/excluirPba',
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
function populaTipoLicenca() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/LicencasAmbientaisTipoDaq',
		dataType: 'json',
		success: function (data) {
			var tipo = $('select[id=tipo]');
			tipo.html('');
			tipo.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.id_tipo_licenca.length; i++) {
				tipo.append('<option value="' + data.id_tipo_licenca[i] + '">' + data.desc_tipo_licenca[i] + '</option>');
			}
		}
	});
}
//------------------------------------------------------------------------------
function populaInfraEstrutura() {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgop.php/LicencasAmbientaisNomeInfraDaq',
		dataType: 'json',
		success: function (data) {
			var servico = $('select[id=nome_infraestrutura]');
			servico.html('');
			servico.append('<option value="" selected >Selecione</option>');
			for (i = 0; i < data.id_tipo_licenca.length; i++) {
				servico.append('<option value="' + data.id_tipo_licenca[i] + '">' + data.desc_tipo_licenca[i] + '</option>');
			}
		}
	});
}
