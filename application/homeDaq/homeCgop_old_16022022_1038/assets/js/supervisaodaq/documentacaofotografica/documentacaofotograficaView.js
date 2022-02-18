//######################################################################################################################################################################################## 
//# DNIT
//# documentacaofotograficaView.js
//# Desenvolvedor:Jordana de Alencar 
//# Data: 10/10/2019 
//########################################################################################################################################################################################
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$().ready(function () {
	//--------------------------------------------------------------------------
	$.ajaxSetup({cache: false});
	//--------------------------------------------------------------------------
	$(".mostrar").hide();
	$(".ocultar").click(function () {
		$(this).next(".mostrar").slideToggle(600);
	});
	$('#searchdate').hide();
	//--------------------------------------------------------------------------
	$("[data-fancybox]").fancybox({
		buttons: ["fullScreen", "zoom", "download", "close"]
	});
	//-------------------------------------------------------
	$('#nova_docFotografico').hide();
	$('#cadastroDocFotografico').hide();
	//--------------------------------------------------------------------------
	$("#datepicker").on("changeDate", function () {
		$.ajaxSetup({cache: false});
		recuperaDocFotografica();
	});
	//--------------------------------------------------------------------------
	recuperaDocFotografica();
	//--------------------------------------------------------------------------
	$("#searchdate").click(function () {
		recuperaDocFotografica();
		document.getElementById("datepicker").disabled = false;
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
			$("#nova_docFotografico").hide();
			$("#cadastroDocFotografico").show();
			$("#divFileInsert").show();
			$("#cadastroFotos").html("");
			$("#insereDocFotografico").hide();
			document.getElementById("datepicker").disabled = true;
			if ($("#btnNoAtividade").length) {
				document.getElementById("btnNoAtividade").disabled = true;
			}
			$('#searchdate').show();
			$('#btnInclusao').hide();
			$('#btnNoAtividade').hide();
		}
	});
	//--------------------------------------------------------------------------
	$("#insereDocFotografico").click(function () {

		//-------------------------------------------------------------------------------------------------------------------------------------------------------
		//LATITUDE
		//-------------------------------------------------------------------------------------------------------------------------------------------------------
		if ($("#utmn_foto0").length) {
			var utmn_foto0 = $('#utmn_foto0').val();
			utmn_foto0 = parseInt(utmn_foto0);
			if (utmn_foto0 < (-100)) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto0").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto0").style.borderColor = 'green';
			}

			if (utmn_foto0 > 100) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto0").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto0").style.borderColor = 'green';
			}
		}

		if ($("#utmn_foto1").length) {
			var utmn_foto1 = $('#utmn_foto1').val();
			utmn_foto1 = parseInt(utmn_foto1);
			if (utmn_foto1 < (-100)) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto1").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto1").style.borderColor = 'green';
			}

			if (utmn_foto1 > 100) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto1").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto1").style.borderColor = 'green';
			}
		}

		if ($("#utmn_foto2").length) {
			var utmn_foto2 = $('#utmn_foto2').val();
			utmn_foto2 = parseInt(utmn_foto2);
			if (utmn_foto2 < (-100)) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto2").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto2").style.borderColor = 'green';
			}

			if (utmn_foto2 > 100) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto2").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto2").style.borderColor = 'green';
			}
		}

		if ($("#utmn_foto3").length) {
			var utmn_foto3 = $('#utmn_foto3').val();
			utmn_foto3 = parseInt(utmn_foto3);
			if (utmn_foto3 < (-100)) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto3").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto3").style.borderColor = 'green';
			}

			if (utmn_foto3 > 100) {
				$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utmn_foto3").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utmn_foto3").style.borderColor = 'green';
			}
		}

		//-------------------------------------------------------------------------------------------------------------------------------------------------------
		//LONGITUDE
		//-------------------------------------------------------------------------------------------------------------------------------------------------------
		if ($("#utme_foto0").length) {
			var utme_foto0 = $('#utme_foto0').val();
			utme_foto0 = parseInt(utme_foto0);
			if (utme_foto0 < (-100)) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto0").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto0").style.borderColor = 'green';
			}

			if (utme_foto0 > 100) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto0").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto0").style.borderColor = 'green';
			}
		}

		if ($("#utme_foto1").length) {
			var utme_foto1 = $('#utme_foto1').val();
			utme_foto1 = parseInt(utme_foto1);
			if (utme_foto1 < (-100)) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto1").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto1").style.borderColor = 'green';
			}

			if (utme_foto1 > 100) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto1").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto1").style.borderColor = 'green';
			}
		}

		if ($("#utme_foto2").length) {
			var utme_foto2 = $('#utme_foto2').val();
			utme_foto2 = parseInt(utme_foto2);
			if (utme_foto2 < (-100)) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto2").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto2").style.borderColor = 'green';
			}

			if (utme_foto2 > 100) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto2").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto2").style.borderColor = 'green';
			}
		}

		if ($("#utme_foto3").length) {
			var utme_foto3 = $('#utme_foto3').val();
			utme_foto3 = parseInt(utme_foto3);
			if (utme_foto3 < (-100)) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto3").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto3").style.borderColor = 'green';
			}

			if (utme_foto3 > 100) {
				$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
				document.getElementById("utme_foto3").style.borderColor = 'red';
				return false;
			} else {
				document.getElementById("utme_foto3").style.borderColor = 'green';
			}
		}

		if ($("#utmn_foto0").val() == '') {
			$.notify('O campo [Latitude] está vazio', "warning");
			document.getElementById("utmn_foto0").style.borderColor = 'red';
			return false;
		} else {
			document.getElementById("utmn_foto0").style.borderColor = 'green';
		}

		if ($("#utme_foto0").val() == '') {
			$.notify('O campo [Longitude] está vazio', "warning");
			document.getElementById("utme_foto0").style.borderColor = 'red';
			return false;
		} else {
			document.getElementById("utme_foto0").style.borderColor = 'green';
		}

		if (document.getElementById) {
			var dt = $("#datepicker").datepicker('getDate');
			if (dt.toString() == "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
		}
		var form = new FormData();
		for (i = 0; i < $('#fileUpload')[0].files.length; i++) {
			// km_foto = $("#km_foto" + i).val();
			// km_foto = validaKM(km_foto, "");
			// if (km_foto.retornoInicial == false) {
			//     $.notify('KM não pertence ao segmento!', "warning");
			//     document.getElementById("km_foto" + i).style.borderColor = 'red';
			//     return false;
			// }
			// document.getElementById("km_foto" + i).style.borderColor = '#d2d6de';
			form.append('arquivo[]', $('#fileUpload')[0].files[i]);
		}
		form.append('periodo', termo);

		serializedData = validaformulario("formularioDocFotografico");
		for (i = 0; i < serializedData.length; i++) {
			form.append(serializedData[i].name, serializedData[i].value);
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


		bootbox.confirm("Confirmar operação [INSERIR DOCUMENTAÇÃO FOTOGRÁFICA]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/DocFotograficoInsereDaq',
					data: form,
					dataType: 'json',
					contentType: false,
					processData: false,
					success: function (data) {
						$.notify(data.mensagem, data.notify);
						$("#cadastroFotos").hide();
						$("#insereDocFotografico").hide();
						document.getElementById("fileUpload").value = "";

					}, error: function (data) {
						$.notify('Erro no Envio', "warning");
					}
				});
			}
		});


	});
	//-------------------------------------------------------------------------
	$("#insereDocFotografico_old").click(function () {

		//---------------------------------------------------------------------
		var utmn_foto0 = $('#utmn_foto0').val();
		var utmn_foto1 = $('#utmn_foto1').val();
		var utmn_foto2 = $('#utmn_foto2').val();
		var utmn_foto3 = $('#utmn_foto3').val();
		//---------------------------------------------------------------------
		utmn_foto0 = parseInt(utmn_foto0);
		alert(utmn_foto0);
		if (utmn_foto0 < (-100)) {
			$.notify('O campo [Latitudeooo] deve ser entre [-100 e 100]', "warning");
			document.getElementById("utmn_foto0").style.borderColor = 'red';
			return false;
		} else {
			document.getElementById("utmn_foto0").style.borderColor = 'gray';
		}
		if (utmn_foto0 > 100) {
			$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
			document.getElementById("utmn_foto0").style.borderColor = 'red';
			return false;
		} else {
			document.getElementById("utmn_foto0").style.borderColor = 'gray';
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		serializedData = validaformulario("formularioDocFotografico");
		if (serializedData == false) {
			$.notify('Preencha os campos obrigatorios!', "warning");
			return false
		}
		if (document.getElementById) {
			var dt = $("#datepicker").datepicker('getDate');
			if (dt.toString() == "Invalid Date") {
				$("#datepicker").datepicker("setDate", new Date());
				return;
			}
			var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
		}
		var form = new FormData();
		for (i = 0; i < $('#fileUpload')[0].files.length; i++) {
			km_foto = $("#km_foto" + i).val();
			km_foto = validaKM(km_foto, "");
			if (km_foto.retornoInicial == false) {
				$.notify('KM não pertence ao segmento!', "warning");
				document.getElementById("km_foto" + i).style.borderColor = 'red';
				return false;
			}
			document.getElementById("km_foto" + i).style.borderColor = '#d2d6de';
			form.append('arquivo[]', $('#fileUpload')[0].files[i]);
		}
		form.append('periodo', termo);

		for (i = 0; i < serializedData.length; i++) {
			form.append(serializedData[i].name, serializedData[i].value);
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


		bootbox.confirm("Confirmar operação [INSERIR DOCUMENTAÇÃO FOTOGRÁFICA]?", function (result) {
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
						$("#cadastroFotos").hide();
						$("#insereDocFotografico").hide();
						document.getElementById("fileUpload").value = "";

					}, error: function (data) {
						$.notify('Erro no Envio', "warning");
					}
				});
			}
		});
	});
	//--------------------------------------------------------------------------
	$("#fileUpload").change(function () {
		$("#cadastroFotos").show();
		$("#insereDocFotografico").show();
		document.getElementById("insereDocFotografico").disabled = false;
		var x = document.getElementById("fileUpload").files;
		if (x.length > 4) {
			$.notify("Numero de arquivo superior ao permitido", "warning");
			document.getElementById("fileUpload").value = "";
		} else if (x.length <= 4) {
			var tamanhoPost = 0;
			var maxSize = 1024 * 1024 * 15;
			for (i = 0; i < x.length; i++) {
				tamanhoPost += x[i].size;
			}
			if (tamanhoPost < maxSize) {
				var cols = "";
				for (i = 0; i < x.length; i++) {
					if (x[i].type === "image/jpeg") {
						cols += "<div class='col-md-6 row form-group'>";
						cols += "   <div class='col-md-12'>";
						cols += "       <div class='form-group' style='text-align: center;'>";
						cols += "           <img alt='img01' src='' style='max-width: 40%; height: 225px;' id='uploadPreview" + i + "'>";
						cols += "       </div>";
						cols += "   </div>";
						cols += "   <div class='col-md-4'>";
						cols += "        <div class='form-group'>";
						cols += "            <label>Km</label>";
						cols += "            <input id='km_foto" + i + "' name='km_foto" + i + "' maxlength='10' class='form-control type='text'>";
						cols += "        </div>";
						cols += "    </div>";
						cols += "        <div class='col-md-4'>";
						cols += "            <div class='form-group'>";
						cols += "                <label>Latitude</label>";
						cols += "                <input id='utmn_foto" + i + "' name='utmn_foto" + i + "' maxlength='10' class='form-control' type='text'>";
						cols += "            </div>";
						cols += "        </div>";
						cols += "        <div class='col-md-4'>";
						cols += "            <div class='form-group'>";
						cols += "                <label>Longitude</label>";
						cols += "                <input id='utme_foto" + i + "' name='utme_foto" + i + "' maxlength='10' class='form-control' type='text'>";
						cols += "            </div>";
						cols += "        </div>";
						cols += "        <div class='col-md-12'>";
						cols += "            <div class='form-group'>";
						cols += "                <label>Descrição</label>";
						cols += "                <textarea id='descricao_foto" + i + "' name='descricao_foto" + i + "' rows='5' style='min - width: 100 % '></textarea>";
						cols += "            </div>";
						cols += "        </div>";
						cols += "    </div>";

						if ((i % 2) !== 0) {
							cols += "<div class='col-md-12'>";
							cols += "   <div style='border-top: 1px solid white;'></div>";
							cols += "</div>";
						}
					} else {
						$.notify("Arquivo não suportado", "warning");
					}
				}
				cols += "<div class='col-md-12'>";
				cols += "<br>";
				cols += "</div>";
				$("#cadastroFotos").html(cols);
				for (i = 0; i < x.length; i++) {
					PreviewImage2(i);
					CKEDITOR.replace("descricao_foto" + i, {
						height: 120
					});
				}
			} else {
				$.notify('Os arquivos superam o limite de tamanho(5mb)', "warning");
			}
		}

	});
	//--------------------------------------------------------------------------
	$("#btnNoAtividade").click(function () {
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
			//----------------------------------------------------------------------------------------------------------------------------------------
			bootbox.confirm("Confirmar operação [NÃO HOUVE ATIVIDADES ESTE MÊS]?", function (result) {
				if (result === true) {
					$.ajax({
						type: 'POST',
						url: '',
						data: {periodo: termo},
						dataType: 'json',
						success: function (data) {
							$.notify("Cadastrado", "success");
							var tableDocFotografico = $("#tableDocFotografico").DataTable();
							tableDocFotografico.ajax.reload();
							confereNaoAtividade();
						}, error: function (data) {
							$.notify('Falha no cadastro', "warning");
						}
					});
				}
			});
		}
	});
});

//------------------------------------------------------------------------------
function recuperaDocFotografica() {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}
		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
	}
	$("#nova_docFotografico").show();
	$("#cadastroDocFotografico").hide();
	// confereNaoAtividade();
	$("#tableDocFotografico").dataTable({
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
		"sAjaxSource": base_url + "index_cgop.php/DocFotograficoRecuperaDaq",
		"fnServerParams": function (aoData) {
			aoData.push({"name": "periodo", "value": termo});
		},
		"aoColumns": [
			{data: "IMAGEM", "sClass": "text-center", "width": "30%"},
			{data: "DESCRICAO", "sClass": "text-justify", "width": "40%"},
			{data: "USUARIO", "sClass": "text-center", "width": "10%"},
			{data: "ATUALIZACAO", "sClass": "text-center", "width": "10%"},
			{data: "ACAO", "sClass": "text-center", "width": "10%"}
		]
	});
}

//------------------------------------------------------------------------------
function anexoDoc(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/anexoDoc',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + '/arquivoDaq/img/' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
			excluirDoc(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

function PreviewImage2(i) {
	oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("fileUpload").files[i]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("uploadPreview" + i).src = oFREvent.target.result;
	};
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function excluirDocumentacao(id_documentacao_foto, id_arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		bootbox.confirm("Confirmar operação [EXCLUIR DOCUMENTAÇÃO]?", function (result) {
			if (result === true) {
				$.ajax({
					type: 'POST',
					url: base_url + 'index_cgop.php/DocFotograficoExcluirDaq',
					data: {id_documentacao_foto: id_documentacao_foto, id_arquivo: id_arquivo},
					dataType: 'json',
					success: function (data) {
						$.notify('Excluído com sucesso!', "success");
						var tableDocFotografico = $("#tableDocFotografico").DataTable();
						tableDocFotografico.ajax.reload();
						// confereNaoAtividade();
					}, error: function (data) {
						$.notify('Falha no cadastro', "warning");
					}
				});
			}
		});
	}
}

//------------------------------------------------------------------------------
function excluirDoc(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgop.php/excluirDoc',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			//$.notify('Excluido com Sucesso!', "success");
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

//------------------------------------------------------------------------------
function editarDocumentacao(id_arquivo) {
	relatorio = confereRelatorio();
	if (relatorio == 1) {
		mensagemRelatorioFechado();
	} else {
		$.ajax({
			type: "POST",
			url: base_url + "index_cgop.php/editarDocumentacaoDaq",
			data: {id_arquivo: id_arquivo},
			dataType: "json",
			success: function (data) {
				$("#nova_docFotografico").hide();
				$("#cadastroDocFotografico").show();
				$("#cadastroFotos").show();
				$("#divFileInsert").hide();
				document.getElementById("datepicker").disabled = true;
				document.getElementById("btnNoAtividade").disabled = true;

				var cols = "";
				cols += "<div class='col-md-6 row form-group'>";
				cols += "   <div class='col-md-12'>";
				cols += "       <div class='form-group' style='text-align: center;'>";
				cols += data.imagem;
				cols += "       </div>";
				cols += "   </div>";
				cols += "   <div class='col-md-3'>";
				cols += "        <div class='form-group'>";
				cols += "            <label>Km</label>";
				cols += "            <input id='km_foto_edit' name='km_foto_edit' maxlength='10' class='form-control type='text' value='" + data.km + "'>";
				cols += "        </div>";
				cols += "    </div>";
				cols += "        <div class='col-md-3'>";
				cols += "            <div class='form-group'>";
				cols += "                <label>Latitude</label>";
				cols += "                <input id='utmn_foto_edit' name='utmn_foto_edit' maxlength='10' class='form-control' type='text' value='" + data.coord_utm_n + "'>";
				cols += "            </div>";
				cols += "        </div>";
				cols += "        <div class='col-md-3'>";
				cols += "            <div class='form-group'>";
				cols += "                <label>Longitude</label>";
				cols += "                <input id='utme_foto_edit' name='utme_foto_edit' maxlength='10' class='form-control' type='text' value='" + data.coord_utm_e + "'>";
				cols += "            </div>";
				cols += "        </div>";
				cols += "        <div class='col-md-3'>";
				cols += "            <div class='form-group'>";
				cols += "                <label>Estaca</label>";
				cols += "                <input id='estaca_foto_edit' name='estaca_foto_edit' maxlength='10' class='form-control' type='text' value='" + data.estaca + "'>";
				cols += "            </div>";
				cols += "        </div>";
				cols += "        <div class='col-md-12'>";
				cols += "            <div class='form-group'>";
				cols += "                <label>Descrição</label>";
				cols += "                <textarea id='descricao_foto_edit' name='descricao_foto_edit' rows='5' style='min-width: 100%'></textarea>";
				cols += "            </div>";
				cols += "        </div>";
				cols += "        <div class='col-md-12'>";
				cols += "            <input id='id_arquivo' name='id_arquivo' type='hidden' value='" + data.id_arquivo + "'>";
				cols += "        </div>";
				cols += "<div class=' col-md-2'>";
				cols += "   <input type='button' onclick='alteraDocFotografico()' class='btn btn-block btn-primary' value='Salvar'>";
				cols += "</div>";
				cols += "    </div>";
				$("#cadastroFotos").html(cols);
				CKEDITOR.replace("descricao_foto_edit", {height: 120});
				CKEDITOR.instances["descricao_foto_edit"].setData(data.desc_arquivo);
			}, error: function (data) {
				$.notify('Falha no cadastro', "warning");
			}
		});
	}
}

//------------------------------------------------------------------------------
function alteraDocFotografico() {
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	//LATITUDE
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	var utmn_foto_edit = $('#utmn_foto_edit').val();
	utmn_foto_edit = parseInt(utmn_foto_edit);
	if (utmn_foto_edit < (-100)) {
		$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
		document.getElementById("utmn_foto_edit").style.borderColor = 'red';
		return false;
	} else {
		document.getElementById("utmn_foto_edit").style.borderColor = 'green';
	}

	if (utmn_foto_edit > 100) {
		$.notify('O campo [Latitude] deve ser entre [-100 e 100]', "warning");
		document.getElementById("utmn_foto_edit").style.borderColor = 'red';
		return false;
	} else {
		document.getElementById("utmn_foto_edit").style.borderColor = 'green';
	}
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	//LONGITUDE
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	var utme_foto_edit = $('#utme_foto_edit').val();
	utme_foto_edit = parseInt(utme_foto_edit);
	if (utme_foto_edit < (-100)) {
		$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
		document.getElementById("utme_foto_edit").style.borderColor = 'red';
		return false;
	} else {
		document.getElementById("utme_foto_edit").style.borderColor = 'green';
	}

	if (utme_foto_edit > 100) {
		$.notify('O campo [Longitude] deve ser entre [-100 e 100]', "warning");
		document.getElementById("utme_foto_edit").style.borderColor = 'red';
		return false;
	} else {
		document.getElementById("utme_foto_edit").style.borderColor = 'green';
	}
	//-------------------------------------------------------------------------------------------------------------------------------------------------------
	var serializedData = validaformulario("formularioDocFotografico");
	if (serializedData == false) {
		$.notify("Preencha os campos obrigatorios!", "warning");
		return false;
	}
	var km_foto = $("#km_foto_edit").val();
	var km_foto = validaKM(km_foto, "");
	if (km_foto.retornoInicial == false) {
		$.notify("KM não pertence ao segmento!", "warning");
		document.getElementById("km_foto_edit").style.borderColor = "red";
		return false;
	}
	document.getElementById("km_foto_edit").style.borderColor = "#d2d6de";
	//--------------------------------------------------------------------------
	bootbox.confirm("Confirmar operação [ALTERAR DOCUMENTAÇÃO FOTOGRÁFICA]?", function (result) {
		if (result === true) {
			$.ajax({
				type: "POST",
				url: base_url + "index_cgop.php/alteraDocumentacaoDaq",
				data: serializedData,
				dataType: "json",
				success: function (data) {
					$.notify("Alterado com sucesso!", "success");
					recuperaDocFotografica();
				}, error: function (data) {
					$.notify("Erro no Envio", "warning");
				}
			});
		}
	});
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function validarKm(i) {
	var valor = $("#km_foto" + i).val();
	var regra = /^[0-9]+$/;
	if (valor.match(regra)) {

	} else {
		$.notify("Campo[KM], Permitido somente números reais acima de 0!", "warning");
		$("#km_foto" + i).focus();
		return false;
	}
}

function validarutmn_foto(i) {
	var valor = $("#utmn_foto" + i).val();
	var regra = /^[0-9]+$/;
	if (valor.match(regra)) {

	} else {
		$.notify("Campo[Latitude],Permitido somente números reais acima de 0!", "warning");
		$("#km_foto" + i).focus();
		return false;
	}
}

function validarutme_foto(i) {
	var valor = $("#utme_foto" + i).val();
	var regra = /^[0-9]+$/;
	if (valor.match(regra)) {

	} else {
		$.notify("Campo[Longitude],Permitido somente números reais acima de 0!", "warning");
		$("#km_foto" + i).focus();
		return false;
	}
}

