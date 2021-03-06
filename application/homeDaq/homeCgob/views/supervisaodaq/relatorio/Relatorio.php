<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DNIT | SUPRA</title>
	<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgob/assets/css/estilos.css')) ?>"/>
	<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgob/assets/css/print.css')) ?>"/>
	<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgob/assets/css/oae.css')) ?>"/>
	<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgob/assets/bootstrap/css/bootstrap.min.css')) ?>"/>
	<!-- Highcharts -->
	<!-- Highcharts -->
	<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/plugins/Highcharts-6.1.4/code/highcharts.js')) ?>"></script>
	<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/plugins/Highcharts-6.1.4/code/highcharts-more.js')) ?>"></script>
	<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/plugins/Highcharts-6.1.4/code/highcharts-3d.js')) ?>"></script>
	<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/plugins/Highcharts-6.1.4/code/modules/solid-gauge.js')) ?>"></script>
	<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/plugins/Highcharts-6.1.4/code/modules/stock.js')) ?>"></script>
	<!--jquery-------->
	<script type="text/javascript" src="<?php echo(base_url('application/homeDaq/homeCgob/assets/plugins/jQuery/jquery-1.12.4.min.js')) ?>"></script>
	<!--js------------>
	<script type="text/javascript">
		var base_url = '<?= base_url(); ?>';
	</script>
	<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/relatoriosupervisao/relatoriosupervisao.js')) ?>"></script>
	<script type="text/javascript">
		function anexoDownload(nome_arquivo) { 

			$.ajax({
				url: base_url + 'index_cgob.php/anexoDownload',
				type: 'POST',
				data: {nome_arquivo: nome_arquivo},
				success: function (data) {
					var arquivo = base_url + 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' + nome_arquivo; 
					var anchor = document.createElement('a');
					anchor.setAttribute("download", nome_arquivo);
					anchor.setAttribute("href", arquivo);
					anchor.click();
					excluiranexorelatorio(nome_arquivo);
				}, error: function (data) {
					$.notify('Falha no download!', "warning");
				}
			});
		}

		function excluiranexorelatorio(nome_arquivo) {
			$.ajax({
				url: base_url + 'index_cgob.php/excluiranexorelatorio',
				type: 'POST',
				data: {nome_arquivo: nome_arquivo},
				success: function (data) {
				}, error: function (data) {
					$.notify('Falha no download!', "warning");
				}
			});
		}
	</script>
        
</head>
<style>
	.tabela > thead > tr > td, .tabela > thead > tr > td {
		color: white;
		background-color: #015175;
	}

	.fundoCinzaCabecalho {
		background-color: #015175;
		font-weight: bold;
		-webkit-print-color-adjust: exact;
	}

	.pluviometricoB {
		background-color: #33fd33;
		-webkit-print-color-adjust: exact;
	}

	.pluviometricoC {
		background-color: #7bb3d4;
		-webkit-print-color-adjust: exact;
	}

	.pluviometricoI {
		background-color: #fb3a3a;
		-webkit-print-color-adjust: exact;
	}

	.pluviometricoIS {
		background-color: #FF0;
		-webkit-print-color-adjust: exact;
	}

	.pluviometricoNA {
		background-color: #9e9e9e;
		-webkit-print-color-adjust: exact;
	}

	.alert-danger {
		color: #17a2b8;
		background-color: #d0e5e8;
		border-color: #d0e5e8;
	}

	/*.body{
-wedkit-print-color-adjust: exact;
}*/
</style>
<section>
	<body class="A4">
	<!-- CAPA RELATORIO -->
	<section id="capa" class="sheet padding-10mm">
		<div class="row" style="letter-spacing: 3px; text-align: center;">
			<div class="col-xs-4 col-sm-4 col-md-4">
				<img src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/LogoDNIT.png')) ?>" style="width: 50%">
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4">
				<img src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/brasao.png')) ?>"
					 style="width: 50%;bottom: 20px;position: relative;">
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4">
				<img src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/brazilflag.png')) ?>"
					 style="width: 25%;bottom: 10px;position: relative;">
			</div>
		</div>
		<div class="row" style="letter-spacing: 3px; text-align: center;">
			<div class="col-md-12">
				<h1>REP??BLICA FEDERATIVA DO BRASIL</h1>
			</div>
			<div class="col-md-12">
				<h2>MINIST??RIO DA INFRAESTRUTURA</h2>
			</div>
			<div class="col-md-12">
				<h3>DEPARTAMENTO NACIONAL DE INFRAESTRUTURA DE TRANSPORTES - DNIT</h3>
			</div>
			<div class="col-md-12" style="margin-top: 10%;">
				<h2><b>RELAT??RIO DE SUPERVIS??O DE OBRAS AQUAVI??RIAS</b></h2>
			</div>
		</div>
		<br><br>
		<table style="width: 100%; border-spacing: 5px; border-collapse: separate; ">
			<tr style="line-height: 50px;">
				<td style="width: 90px" class="font12print">Hidrovia</td>
				<td style="width: 10px" class="font12print">:</td>
				<td class="font12print">       <?= $hidrovia_localizacao; ?>                </td>
			</tr>
			<tr style="line-height: 50px;">
				<td class="font12print">Municipio</td>
				<td class="font12print">:</td>
				<td class="font12print">      <?= $municio_localizacao; ?>                  </td>
			</tr>
			<tr style="line-height: 50px;">
				<td class="font12print">Extens??o/??rea</td>
				<td class="font12print">:</td>
				<td class="font12print">      <?= $extensao_localizacao; ?>                  </td>
			</tr>
			<tr style="line-height: 50px;">
				<td class="font12print">Empresa</td>
				<td class="font12print">:</td>
				<td class="font12print">         <?= $empresa_super; ?> / <?= $nu_contrato_super; ?>              </td>
			</tr>
			<tr>
				<td colspan="3">
					<p style="text-align: right; font-weight: bold; line-height: 50px;">RELAT??RIO PERI??DICO
						RP-N??<?= $relatorio_supervisao; ?></p>
					<p style="text-align: right; line-height: 50px;">PER??ODO REFER??NCIA
						- <?= $periodo_referencia; ?></p>
					<p style="text-align: right; line-height: 50px;">RELAT??RIO PRINCIPAL</p>
				</td>
			</tr>
		</table>
		<br><br>
		<div class="table-responsive">
			<table style="width:100%;" class="bordaCaixa bordaCelulas ">
				<tr>
					<td class="font12print">Lote:</td>
					<td class="font12print">Empresa executora: <?= $empresa_obra; ?> </td>
					<td class="font12print">N?? Contrato:</td>
				</tr>
				<tr>
					<td>&nbsp;</td>

					<td></td>
					<td><?= $n_contrato_obra; ?></td>
				</tr>
			</table>
		</div>
		<div style="width: 100%; position: absolute; bottom: 0px; text-aling:center;" class="center somentePrint">
			<b><?= $periodo_referencia; ?></b></div>
	</section>
	<!-- SUM??RIO -->
	<section id="sumario" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>SUM??RIO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#justificativa_empreendimento">1. JUSTIFICATIVA E APRESENTA????O DO EMPREENDIMENTO</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#mapa_situacao">2. MAPA DE SITUA????O</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#resumo_projeto">3. RESUMO DO PROJETO</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#resumo_projeto" class="subItem"><?= $reumo_projeto_obra; ?></a>
			</div>
		</div>
		<!--             <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_derrocamento" class="subItem">3.2 Derrocagem</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_dragagem" class="subItem">3.3 Dragagem</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_desobstrucao" class="subItem">3.4 Desobstru????o</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_dragagem_portos_maritimos" class="subItem">3.5 Recupera????o Portu??ria</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_construcao_estacao_passageiros" class="subItem">3.6 Monitoramento Hidrovi??rio</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_ remocao_navio_haider" class="subItem">3.7 Remo????o do Navio</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_sinalizacao_hidrovias" class="subItem">3.8 Implanta????o de Sinaliza????o em Hidrovias</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="#resumo_obras_eclusas" class="subItem">3.9 Recupera????o Eclusas e Barragens</a>
                </div>
            </div> -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#resumo_rpfo" class="subItem">3.2 REVIS??ES DE PROJETO EM FASE DE OBRAS - RPFO</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#diagrama_ocorrencias">4. DIAGRAMA DE OCORR??NCIAS E PONTOS DE PASSAGEM</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#historico">5. HIST??RICO</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#resumo_obra">6. INTRODU????O</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#atividade_supervisora">7. ATIVIDADE DA SUPERVISORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#atividade_supervisora" class="subItem">7.1 APRESENTA????O DA SUPERVISORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#relacao_mobilizacao_supervisora" class="subItem">7.2 RELA????O DE MOBILIZA????O DA SUPERVISORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#atividades_executadas_supervisora" class="subItem">7.3 ATIVIDADES EXECUTADAS PELA
					SUPERVISORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#atividade_construtora">8. ATIVIDADE DA CONSTRUTORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#atividade_construtora" class="subItem">8.1 APRESENTA????O DA CONSTRUTORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#relacao_mobilizacao_construtora" class="subItem">8.2 RELA????O DE MOBILIZA????O DA CONSTRUTORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#atividades_executadas_construtora" class="subItem">8.3 ATIVIDADES EXECUTADAS PELA
					CONSTRUTORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#construtora_fisico_financeiro">9. ACOMPANHAMENTO F??SICO-FINANCEIRO</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#construtora_fisico_financeiro" class="subItem">9.1 ACOMPANHAMENTO FINANCEIRO</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#construtora_acompanhamento_fisico" class="subItem">9.2 ACOMPANHAMENTO F??SICO</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#analise_critica_cronog_construtora">10. AN??LISE CR??TICA DOS CRONOGRAMAS</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#controle_pluviometrico">11. CONTROLE PLUVIOM??TRICO </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#resumo_avanco_fisico">12. RESUMO DE AVAN??O F??SICO </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#controle_pluviometrico_documentacao_fotografica">13. DOCUMENTA????O FOTOGR??FICA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#componente_ambiental">14. MONITORAMENTO AMBIENTAL </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#gestao_qualidade">15. GEST??O DA QUALIDADE </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#ensaio_laboratorio_construtora" class="subItem">15.1 ENSAIOS DE LABORAT??RIO DA CONSTRUTORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#ensaio_laboratorio_supervisora" class="subItem">15.2 ENSAIOS DE LABORAT??RIO DA SUPERVISORA</a>
			</div>
		</div>
		<!-- <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a href="#gestao_pvegq" class="subItem">11.3 PLANO DE VERIFICA????O DA EFETIVIDADE DA GEST??O DA QUALIDADE (PVEGQ)</a>
    </div>
</div> -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#gestao_rnc">16. REGISTROS DE N??O CONFORMIDADES ??? RNC</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#gestao_juridica_garantias_seguros">17. GEST??O JUR??DICA, GARANTIAS E SEGUROS </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#riscos_interferencias">18. GEST??O DE RISCOS E INTERFER??NCIAS </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#atas_correspondencias">19. ATAS E CORRESPOND??NCIAS </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#gestao_tratativas">20. GEST??O DE TRATATIVAS </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#conclusao_comentarios">21. CONCLUS??O E COMENT??RIOS</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#termo_encerramento">22. TERMO DE ENCERRAMENTO </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexos">23. ANEXOS </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_resumo" class="subItem">23.1 RESUMO DE PROJETOS </a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_rpfo" class="subItem">23.2 RPFO - Revis??o de projetos em fase de obra</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_monitoramento" class="subItem">23.3 MONITORAMENTO AMBIENTAL</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_pba" class="subItem">23.4 PBA/PBAI</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_licenciamneto" class="subItem">23.5 LICENCIAMENTO AMBIENTAL</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_lab_construtora" class="subItem">23.6 ENSAIOS DE LABORAT??RIO DA CONSTRUTORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_lab_supervisora" class="subItem">23.7 ENSAIOS DE LABORAT??RIO DA SUPERVISORA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_garantias" class="subItem">23.8 JUR??DICO, GARANTIAS E SEGUROS</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_atas" class="subItem">23.9 ATAS E CORRESPOND??NCIAS</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_art" class="subItem">23.10 ART VIGENTES SUPERVISORAS</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_fiscais" class="subItem">23.11 QUADRO DE FISCAIS DNIT</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_diario" class="subItem">23.12 DI??RIO DE OBRA</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#anexo_demais" class="subItem">23.13 DEMAIS ANEXOS</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#relatorioMonitoramentoAmbiental">24. RELAT??RIO DE MONITORAMENTO AMBIENTAL</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#boletimSemanalDragagem">25. BOLETIM SEMANAL DE DRAGAGEM</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#relatorioMensalDragagem">26. RELAT??RIO MENSAL DE DRAGAGEM</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="#relatorioLevantamentoHidrografico">27. RELAT??RIO DE LEVANTAMENTO HIDROGR??FICO</a>
			</div>
		</div>
	</section>
	<!-- 1. JUSTIFICATIVA E APRESENTA????O DO EMPREENDIMENTO -->
	<section id="justificativa_empreendimento" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>1. JUSTIFICATIVA E APRESENTA????O DO EMPREENDIMENTO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style="font:11px/21px Arial,tahoma,sans-serif;color:black">
				<?= $resumo_justificativa; ?>
			</div>
		</div>
	</section>
	<!--Item 2 - MAPA DE SITUA????O -->
	<section id="mapa_situacao" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>2. MAPA DE SITUA????O</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify">
				<?php
				if (!empty($mapa_situacao_nao_cadastrado)) {
					echo $mapa_situacao_nao_cadastrado;
				} else {
					?>
					<img src="<?php echo(base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $mapa_situacao)) ?>"
						 style="width: 100%">
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- Item 3 - RESUMO PROJETO -->
	<section id="resumo_projeto" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>3. RESUMO DO PROJETO</strong>
				</h3>
			</div>
		</div>
		<div id="resumo_derrocamento">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong><?= $reumo_projeto_obra; ?></strong>
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
					 style="font:11px/21px Arial,tahoma,sans-serif;color:black">
					<?= $reumo_projeto_obra_especifica; ?>
				</div>
			</div>
		</div>
		<div id="resumo_rpfo">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>3.2 REVIS??ES DE PROJETO EM FASE DE OBRAS - RPFO</strong>
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify">
					<tbody class="center">
					<tr>
						<?= $resumo_rpfo; ?>
					</tr>
					</tbody>
				</div>
			</div>
		</div>
	</section>
	<!-- Item 4 - DIAGRAMA DE OCORR??NCIAS E PONTOS DE PASSAGEM -->
	<section id="diagrama_ocorrencias" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>4. DIAGRAMA DE OCORR??NCIAS E PONTOS DE PASSAGEM</strong>
				</h3>
			</div>
		</div>
            <?php
            
           foreach ($diagrama_ocorrencia_pp as $lista) { 
                $diagrama_ocorrencia = $lista['diagrama_ocorrencia_pp'];
                ?>
                
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify">
				<tbody class="center">
				<tr>
					<?php
					if (!empty($diagrama_ocorrencia_pp_nao_cadastrado)) {
						echo $diagrama_ocorrencia_pp_nao_cadastrado;
					} else {
						$arquivoimg = 'index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $diagrama_ocorrencia;
                                                
						?>
						<img src="<?php echo(base_url($arquivoimg)) ?>" style="width: 100%">
					<?php } ?>
				</tr>
                                <hr>
				</tbody>
			</div>
		</div>
            <?php } ?>
	</section>
	<!-- Item 5 - HIST??RICO -->
	<section id="historico" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>5. HIST??RICO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style="font:11px/21px Arial,tahoma,sans-serif;color:black">
				<?= $historico_obra; ?>
			</div>
		</div>
	</section>
	<!-- Item 6 - Introdu????o -->
	<section id="resumo_obra" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>6. INTRODU????O</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $introducao_obra; ?>
			</div>
		</div>
	</section>
	<!--####################################################################################
######################### ATIVIDADES DA SUPERVISORA E SUBITENS #####################
#################################################################################### -->
	<!-- Item 7.1 - Apresenta????o supervisora -->
	<section id="atividade_supervisora" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>7. ATIVIDADES DA SUPERVISORA </strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>7.1 APRESENTA????O DA SUPERVISORA</strong>
				</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<?= $apresentacao_supervisora; ?>
			<?php if (!empty($apresentacao_supervisora_fiscais)) { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Fiscais</strong>
					</h3>
					<table class="tabela bordaCompleta" style="width: 100%;">
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Unidade Federativa</td>
							<td>Nome Fiscais</td>
							<td>E-mail</td>
							<td>Telefone</td>
							<td>Titularidade</td>
							<td>status</td>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($apresentacao_supervisora_fiscais as $lista) {
							$estadosupervisora = $lista->estado;
							$nomeFiscalsupervisora = $lista->nome_fiscal;
							$emailsupervisora = $lista->email;
							$telefonesupervisora = $lista->telefone;
							$titularidadesupervisora = $lista->titularidade;
							$statussupervisora = $lista->publicar; ?>
							<tr>
								<td> <?= $estadosupervisora; ?> </td>
								<td> <?= $nomeFiscalsupervisora; ?> </td>
								<td> <?= $emailsupervisora; ?>  </td>
								<td> <?= $telefonesupervisora; ?>  </td>
								<td> <?= $titularidadesupervisora; ?> </td>
								<td> <?= $statussupervisora; ?> </td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			<?php } ?>
			<?php if (!empty($apresentacao_supervisora_aditivos)) { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Aditivos</strong>
					</h3>
					<?php
					$cont = 1;
					foreach ($apresentacao_supervisora_aditivos as $lista) {
						$NUMERO_TERMO_SUPERVISORA = $lista->numero_termo;
						$DATA_ASSINATURA_SUPERVISORA = $lista->data_assinatura;
						$OBJETO_TERMO_SUPERVISORA = $lista->desc_objeto_termo;
						$DIAS_ADITADOS_SUPERVISORA = $lista->dias_aditados;
						$VALOR_ADITADO_SUPERVISORA = $lista->valor_aditado;
						?>
						<h3><?= $cont ?>?? Termo Aditivo</h3>
						<table class="tabela bordaCompleta" style="width: 100%;">
							<tr>
								<td class="bold">N??mero do Termo</td>
								<td><?= $NUMERO_TERMO_SUPERVISORA ?></td>
							</tr>
							<tr>
								<td class="bold" style="width: 50%;">Data Assinatura</td>
								<td style="width: 50%;"><?= $DATA_ASSINATURA_SUPERVISORA ?> </td>
							</tr>
							<tr>
								<td class="bold">Objeto Termo</td>
								<td><?= $OBJETO_TERMO_SUPERVISORA ?></td>
							</tr>
							<tr>
								<td class="bold">Dias Aditados</td>
								<td><?= $DIAS_ADITADOS_SUPERVISORA ?></td>
							</tr>
							<tr>
								<td class="bold">Valor Aditado</td>
								<td><?= 'R$' . number_format($VALOR_ADITADO_SUPERVISORA, 2, ',', '.') ?></td>
							</tr>
						</table> <br>
						<?php
						$cont++;
					}
					?>
				</div> <br>
			<?php } ?>
			<?php if (!empty($apresentacao_supervisora_resposavel)) { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Respons??veis T??cnicos</strong>
					</h3>
					<table class="tabela bordaCompleta" style="width: 100%;">
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Nome</td>
							<td>N?? ART</td>
							<td>Forma de Registro</td>
							<td>Participa????o T??cnica</td>
							<td>Data de Registro</td>
							<td>Data da Baixa</td>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($apresentacao_supervisora_resposavel as $key) {
							$NOME_FICAL_SUPER = $key->nome_profissional;
							$NUMERO_ART_SUPER = $key->num_art;
							$FORMA_REGIS_SUPER = $key->forma_registro;
							$PARTICIPACAO_TECNICA_SUPER = $key->participacao_tecnica;
							$DATA_REGISTRO_SUPER = $key->data_registro;
							$DATA_BAIXA_SUPER = $key->data_baixa; ?>
							<tr>
								<td> <?= $NOME_FICAL_SUPER; ?> </td>
								<td> <?= $NUMERO_ART_SUPER; ?> </td>
								<td> <?= $FORMA_REGIS_SUPER; ?>  </td>
								<td> <?= $PARTICIPACAO_TECNICA_SUPER; ?>  </td>
								<td> <?= $DATA_REGISTRO_SUPER; ?> </td>
								<td> <?= $DATA_BAIXA_SUPER; ?> </td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			<?php } ?>
			<?php if (!empty($apresentacao_supervisora_paralisacao)) { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Paralisa????o/Rein??cio</strong>
					</h3>
					<table class="tabela bordaCompleta" style="width: 100%;">
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Tipo Documento</td>
							<td>Data</td>
							<td>Motiva????o</td>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($apresentacao_supervisora_paralisacao as $key) {
							$TIPO_DOCUMENTO = $key->tipo_documento;
							$DATA_PARALIZACAO = $key->data_reinicio;
							$MOTIVACAO = $key->motivacao;
							?>
							<tr>
								<td> <?= $TIPO_DOCUMENTO; ?> </td>
								<td> <?= $DATA_PARALIZACAO; ?> </td>
								<td> <?= $MOTIVACAO; ?>  </td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			<?php } ?>
		</div>
	</section>
	<!--Item 7.2 RELA????O DE MOBILIZA????O DA SUPERVISORA -->
	<section id="relacao_mobilizacao_supervisora" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>7.2 RELA????O DE MOBILIZA????O DA SUPERVISORA</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta " style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">C??DIGO<br>SICRO</td>
						<td rowspan="2">PROFISS??ES</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_Supervisora_Pessoal as $key) {
						$CODIGO_SICRO = $key->cod_sicro;
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<td> <?= $CODIGO_SICRO; ?> </td>
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="3" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?></dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?> </dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $nu_contrato_super; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_super; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE EQUIPE</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">EQUIPAMENTOS</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_SUpervisora_Equipamento as $key) {
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<!--<td> <?= $CODIGO_SICRO; ?> </td>-->
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?></dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?></dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $nu_contrato_super; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_super; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE EQUIPAMENTOS</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">UNID.</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>ALUGADO</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>ALUGADO</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>ALUGADO</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_SUpervisora_Materiais as $key) {
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<!--<td> <?= $CODIGO_SICRO; ?> </td>-->
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?></dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?></dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $nu_contrato_super; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_super; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE MATERIAIS</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">UNID.</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>ALUGADO</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_SUpervisora_Atividade_Auxiliares as $key) {
//$CODIGO_SICRO = $key->cod_sicro;
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<!--<td> <?= $CODIGO_SICRO; ?> </td>-->
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?></dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?></dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $nu_contrato_super; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_super; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE ATIVIDADES</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!--Item 7.3 - ATIVIDADES EXECUTADAS PELA SUPERVISORA -->
	<section id="atividades_executadas_supervisora" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>7.3 ATIVIDADES EXECUTADAS PELA SUPERVISORA</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $atividadesupervisoraexecutada; ?>                  </div>
		</div>
	</section>
	<!--####################################################################################
######################### ATIVIDADES DA CONSTRUTORA E SUBITENS #####################
####################################################################################-->
	<!-- Item 8.1 Apresenta????o construtora-->
	<section id="atividade_construtora" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>8. ATIVIDADES DA CONSTRUTORA </strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>8.1 APRESENTA????O DA CONSTRUTORA</strong>
				</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<!------------------------------------------------------------------------------QUADRO-------------------------------->
			<?php foreach ($apresentacao_construtora as $lista) {
				$data_base = $lista->data_base;
				$contrato = $lista->contrato;
				$empresa = $lista->nome_empresa;
				$processo_base = $lista->processo_adm;
				$objeto = $lista->objeto;
				$localizacao = $lista->localizacao;
				$data_assinatura = $lista->data_ass;
				$ordem_inicial = $lista->ordem_inicial;
				$prazo_inicial = $lista->prazo_inicial;
				$termino_inicial = $lista->data_inicial_term;
				$termino_atualizada = $lista->dt_termino_atualizada;
				$data_publicacao = $lista->publi_dou;
				$publicacao_licitacao_DOU = $lista->publi_result;
				$dias_aditados = $lista->dias_aditados;
				$dias_paralisados = $lista->total_paralisados;
				$valor_PI = number_format($lista->valor_pi_contrato, 2, ",", ".");
				$valor_aditado = number_format($lista->valor_total_aditado, 2, ",", ".");
				$valor_reajuste = number_format($lista->valor_reajuste, 2, ",", ".");
				$valor_atualizado = number_format($lista->valor_atz_pir, 2, ",", ".");
				?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Informa????es Contratuais</strong>
					</h3>
					<table class="tabela bordaCompleta" style="width: 100%;">
						<tr>
							<td class="bold">Contrato Constru????o</td>
							<td> <?= $contrato; ?> </td>
						</tr>
						<tr>
							<td style="width: 50%;" class="bold">Empresa</td>
							<td style="width: 50%;"> <?= $empresa; ?> </td>
						</tr>
						<tr>
							<td class="bold">Processo Administrativo Base</td>
							<td> <?= $processo_base; ?> </td>
						</tr>
						<tr>
							<td class="bold">Objeto</td>
							<td> <?= $objeto; ?> </td>
						</tr>
						<tr>
							<td class="bold">Data Base</td>
							<td><?= $data_base; ?></td>
						</tr>
						<tr>
							<td class="bold">Data Publica????o da Licita????o no DOU</td>
							<td> <?= $data_publicacao; ?> </td>
						</tr>
						<tr>
							<td class="bold">Data da publica????o do resultado da licita????o no DOU</td>
							<td> <?= $publicacao_licitacao_DOU; ?> </td>
						</tr>
						<tr>
							<td class="bold">Data Assinatura</td>
							<td> <?= $data_assinatura; ?> </td>
						</tr>
						<tr>
							<td class="bold">Ordem de Inicio Servi??os</td>
							<td> <?= $ordem_inicial; ?> </td>
						</tr>
						<tr>
							<td class="bold">Prazo Inicial de Execu????o</td>
							<td><?= $prazo_inicial; ?></td>
						</tr>
						<tr>
							<td class="bold">Data Inicial de T??rmino Contrato</td>
							<td><?= $termino_inicial; ?></td>
						</tr>
						<tr>
							<td class="bold">Total dias Aditados</td>
							<td><?= $dias_aditados; ?></td>
						</tr>
						<tr>
							<td class="bold">Total dias Paralisados</td>
							<td><?= $dias_paralisados; ?></td>
						</tr>
						<tr>
							<td class="bold">Data de T??rmino Atualizada</td>
							<td><?= $termino_atualizada; ?></td>
						</tr>
						<tr>
							<td class="bold">Valor a PI do contrato</td>
							<td>R$ <?= $valor_PI; ?></td>
						</tr>
						<tr>
							<td class="bold">Valor Total Aditado do Contrato</td>
							<td>R$ <?= $valor_aditado; ?></td>
						</tr>
						<tr>
							<td class="bold">Valor de Reajuste do Contrato</td>
							<td>R$ <?= $valor_reajuste; ?></td>
						</tr>
						<tr>
							<td class="bold">Valor Atualizado do Contrato(PI+A+R)</td>
							<td>R$ <?= $valor_atualizado; ?></td>
						</tr>
					</table>
				</div>
			<?php } ?>
			<!----------------------------------------------------------->
			<?php if (!empty($apresentacao_construtora_fiscais)) { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Fiscais</strong>
					</h3>
					<table class="tabela bordaCompleta" style="width: 100%;">
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Unidade Federativa</td>
							<td>Nome Fiscal</td>
							<td>E-mail</td>
							<td>Telefone</td>
							<td>Titularidade</td>
							<td>Status</td>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($apresentacao_construtora_fiscais as $lista) {
							$ESTADOCONSTRUTORADAQ = $lista->estado;
							$NOMECONSTRUTORADAQ = $lista->nome_fiscal;
							$EMAILCONSTRUTORADAQ = $lista->email;
							$TELEFONECONSTRUTORADAQ = $lista->telefone;
							$TITULARIDADECONSTRUTORADAQ = $lista->titularidade;
							$STATUSCONSTRUTORADAQ = $lista->publicar;
							?>
							<tr>
								<td><?= $ESTADOCONSTRUTORADAQ ?></td>
								<td><?= $NOMECONSTRUTORADAQ ?></td>
								<td><?= $EMAILCONSTRUTORADAQ ?></td>
								<td><?= $TELEFONECONSTRUTORADAQ ?></td>
								<td><?= $TITULARIDADECONSTRUTORADAQ ?></td>
								<td><?= $STATUSCONSTRUTORADAQ ?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			<?php } ?>
			<!-------------------------------------------------------------------------->
			<?php if (!empty($apresentacao_construtora_aditivo)) { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Aditivos</strong>
					</h3>
					<?php
					$cont = 1;
					foreach ($apresentacao_construtora_aditivo as $lista) {
						$NUMERO_TERMO_CONSTRUTORA = $lista->numero_termo;
						$DATA_ASSINATURA_CONSTRUTORA = $lista->data_assinatura;
						$OBJETO_TERMO_CONSTRUTORA = $lista->descricao;
						$DIAS_ADITADOS_CONSTRUTORA = $lista->dias_aditados;
						$VALOR_ADITADO_CONSTRUTORA = $lista->valor_aditado;
						?>
						<h3><?= $cont ?>?? Termo Aditivo</h3>
						<table class="tabela bordaCompleta" style="width: 100%;">
							<tr>
								<td class="bold">N??mero do Termo</td>
								<td><?= $NUMERO_TERMO_CONSTRUTORA ?></td>
							</tr>
							<tr>
								<td class="bold" style="width: 50%;">Data Assinatura</td>
								<td style="width: 50%;"><?= $DATA_ASSINATURA_CONSTRUTORA ?> </td>
							</tr>
							<tr>
								<td class="bold">Objeto Termo</td>
								<td><?= $OBJETO_TERMO_CONSTRUTORA ?></td>
							</tr>
							<tr>
								<td class="bold">Dias Aditados</td>
								<td><?= $DIAS_ADITADOS_CONSTRUTORA ?></td>
							</tr>
							<tr>
								<td class="bold">Valor Aditado</td>
								<td><?= 'R$' . number_format($VALOR_ADITADO_CONSTRUTORA, 2, ',', '.') ?></td>
							</tr>
						</table> <br>
						<?php
						$cont++;
					}
					?>
				</div> <br>
			<?php } ?>
			<!------------------------------------------------------------>
			<?php if (!empty($apresentacao_construtora_localizacao)) { ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Localiza????o</strong>
					</h3>
					<?php
					foreach ($apresentacao_construtora_localizacao as $lista) {
						$HIDROVIACONSTRUTORA = $lista->hidrovia;
						$INICIALCONSTRUTORA = $lista->inicial;
						$STATUSCONSTRUTORA = $lista->extensao;
						?>
						<table class="tabela bordaCompleta" style="width: 100%;">
							<tbody>
							<tr>
								<td class="bold">Hidrovia</td>
								<td style="width: 50%;"><?= $HIDROVIACONSTRUTORA ?></td>
							</tr>
							<tr>
								<td class="bold">PNV</td>
								<td style="width: 50%;"><?= $INICIALCONSTRUTORA ?></td>
							</tr>
							<tr>
								<td class="bold">Extens??o/??rea</td>
								<td style="width: 50%;"><?= $STATUSCONSTRUTORA ?></td>
							</tr>
							</tbody>
						</table> <br>
						<?php
					}
					?>
				</div> <br>
			<?php } ?>
			<!-------------------------------------------------------------------------------------->
			<?php if (!empty($apresentacao_contrutora_paralisacao)) {
				?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
					<h3>
						<strong>Paralisa????o/Rein??cio</strong>
					</h3>
					<table class="tabela bordaCompleta" style="width: 100%;">
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Tipo Documento</td>
							<td>Data</td>
							<td>Motiva????o</td>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($apresentacao_contrutora_paralisacao as $lista) {
							$TIPO_DOCUMENTO = $lista->tipo_documento;
							$DATA = $lista->data_reinicio;
							$MOTIVACAO = $lista->motivacao;
							?>
							<tr>
								<td><?= $TIPO_DOCUMENTO ?></td>
								<td><?= $DATA ?></td>
								<td><?= $MOTIVACAO ?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			<?php } ?>
			<!-------------------------------------------------------------------------------------------------------------->
	</section>
	<!-- Item 8.2 -->
	<section id="relacao_mobilizacao_construtora" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>8.2 RELA????O DE MOBILIZA????O DA CONSTRUTORA</strong>
				</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">C??DIGO<br>SICRO</td>
						<td rowspan="2">PROFISS??ES</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_Construtora_Pessoal as $key) {
						$CODIGO_SICRO = $key->cod_sicro;
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<td> <?= $CODIGO_SICRO; ?> </td>
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="3" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?></dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?></dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $n_contrato_obra; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_obra; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE EQUIPE</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">EQUIPAMENTOS</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_Construtora_Equipamento as $key) {
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<!--<td> <?= $CODIGO_SICRO; ?> </td>-->
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?></dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?></dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $n_contrato_obra; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_obra; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE EQUIPAMENTOS</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">UNID.</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_Construtora_Atividade_Auxiliares as $key) {
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<!--<td> <?= $CODIGO_SICRO; ?> </td>-->
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?> </dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?></dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $n_contrato_obra; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_obra; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE ATIVIDADES AUXILIARES</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<thead class="center fundoCinzaCabecalho">
					<tr>
						<td rowspan="2">GRUPO</td>
						<td rowspan="2">UNID.</td>
						<td colspan="3">M??S ANTERIOR</td>
						<td colspan="3">M??S ATUAL</td>
						<td colspan="3">VARIA????O<br></td>
					</tr>
					<tr>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
						<td>PR??PRIOS</td>
						<td>TERCEIROS</td>
						<td>TOTAL</td>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($Mobilizacao_SICRO_Construtora_Materiais as $key) {
						$TIPO = $key->tipo;
						$GRUPO = $key->item;
						$PROPRIO_ANTERIOR = $key->qtd_proprio_anterior;
						$TERCEIRO_ANTERIOR = $key->qtd_terceiro_anterior;
						$TOTAL_ANTERIOR = $key->total_anterior;
						$PROPRIO_ATUAL = $key->qtd_proprio_atual;
						$TERCEIRO_ATUAL = $key->qtd_terceiro_atual;
						$TOTAL_ATUAL = $key->total_atual;
						if ($PROPRIO_ATUAL >= $PROPRIO_ANTERIOR) {
							$PROPRIO_VARIACAO = ($PROPRIO_ATUAL - $PROPRIO_ANTERIOR);
						}
						if ($PROPRIO_ANTERIOR >= $PROPRIO_ATUAL) {
							$PROPRIO_VARIACAO = ($PROPRIO_ANTERIOR - $PROPRIO_ATUAL);
						}
						if ($TERCEIRO_ATUAL >= $TERCEIRO_ANTERIOR) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ATUAL - $TERCEIRO_ANTERIOR);
						}
						if ($TERCEIRO_ANTERIOR >= $TERCEIRO_ATUAL) {
							$TERCEIRO_VARIACAO = ($TERCEIRO_ANTERIOR - $TERCEIRO_ATUAL);
						}
						$TOTAL_VARIACAO = $PROPRIO_VARIACAO + $TERCEIRO_VARIACAO;
						?>
						<tr>
							<td> <?= $GRUPO; ?> </td>
							<!--<td> <?= $CODIGO_SICRO; ?> </td>-->
							<td> <?= $TIPO; ?>  </td>
							<td> <?= $PROPRIO_ANTERIOR; ?>  </td>
							<td> <?= $TERCEIRO_ANTERIOR; ?>  </td>
							<td> <?= $TOTAL_ANTERIOR; ?>  </td>
							<td> <?= $PROPRIO_ATUAL; ?>  </td>
							<td> <?= $TERCEIRO_ATUAL; ?>  </td>
							<td> <?= $TOTAL_ATUAL; ?>  </td>
							<td> <?= $PROPRIO_VARIACAO; ?>  </td>
							<td> <?= $TERCEIRO_VARIACAO; ?>  </td>
							<td> <?= $TOTAL_VARIACAO; ?>  </td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2" rowspan="2">
							<dl class="dl-horizontal">
								<dt>Hidrovia</dt>
								<dd><?= $hidrovia_localizacao; ?></dd>
								<dt>Municipio</dt>
								<dd><?= $municio_localizacao; ?></dd>
								<dt>Extens??o/??rea</dt>
								<dd><?= $extensao_localizacao; ?></dd>
								<dt>Contrato</dt>
								<dd><?= $n_contrato_obra; ?></dd>
								<dt>Empresa</dt>
								<dd><?= $empresa_obra; ?></dd>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELA????O DE MATERIAIS</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia; ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									<img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>" style="width: 150px">
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!--------------------------------------------------------------------------------------------------------------------->
	<section id="atividades_executadas_construtora" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>8.3 ATIVIDADES EXECUTADAS PELA CONSTRUTORA</strong>
				</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style="font:11px/21px Arial,tahoma,sans-serif;color:black">
				<?= $atividadeconstrutoraexecutada; ?>
			</div>
		</div>
	</section>
	<section id="construtora_fisico_financeiro" class="sheet fullpage">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>9. ACOMPANHAMENTO F??SICO-FINANCEIRO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>9.1 ACOMPANHAMENTO FINANCEIRO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
				a) Cronograma/Avan??o Financeiro
				<br> <br>
				<!--------------------------------------------------------------------------------------------------TABELA E PREENCHIDA COM ALGUM FOR--->

				<?php $y = 1;
				if (empty($anoacompanhemtofinanceiro)) { ?>
					<tr class="center">
						<div class="alert alert-danger" role="alert">[9.1 ACOMPANHAMENTO FINANCEIRO] n??o cadastrado!
						</div>
					</tr>
				<?php } else {
					if (!empty($anoacompanhemtofinanceiro)) {
						foreach ($anoacompanhemtofinanceiro as $anoacompanhentofinanceiro_key) {
							$anobreak = $anoacompanhentofinanceiro_key;

							?>
							<table class="tabela bordaCompleta deslocarEsquerda table80" style="width: 100%;">
							<thead class="center fundoCinzaCabecalho">
							<tr>
								<td colspan="3">VALOR TOTAL VIGENTE(PI+A) R$ <?= $Valor_Inicial_Adit_Reajustes ?></td>
								<td colspan="12">CRONOGRAMA FINANCEIRO (em milhares de reais)</td>
								<td rowspan="2">TOTAL(R$)</td>
							</tr>
							<tr>
								<td>C??D</td>
								<td colspan="2">OBRA/SERVI??O</td>
								<td>Jan/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Fev/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Mar/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Abr/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Mai/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Jun/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Jul/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Ago/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Set/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Out/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Nov/<?= $anoacompanhentofinanceiro_key->ano ?></td>
								<td>Dez/<?= $anoacompanhentofinanceiro_key->ano ?></td>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach ($acpfinanceiroavancocronograma as $acompanhamentofisico_key) {
								if ($acompanhamentofisico_key->ano === $anoacompanhentofinanceiro_key->ano) {
									$atribuirPreFinanceiro = 0;
									$atribuirRelFinanceiro = 0;
									$breakrealizado = $mes;
									$breakrealizadoano = date('y', strtotime($acompanhamentofisico_key->ano));
									$anofisico = $acompanhamentofisico_key->ano;
									$servicoobraacompanhamento = $acompanhamentofisico_key->servico;
									?>
									<tr>
										<td class="center" rowspan="1"><?= $y++ ?></td>
										<td rowspan="1"><b><?= $servicoobraacompanhamento ?></b></td>
										<td>
											<div>
												Previsto Mensal
											</div>
											<br>
											<div>
												Concluido Mensal
											</div>
											<hr>
											<div>
												Previsto Acumulado
											</div>
											<br>
											<div>
												Realizado Acumulado
											</div>
										</td>
										<?php
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'previsto_0' . $j;
											$cm = 'concluido_0' . $j;
											$mm = '0' . $j;
											if ($j >= 10) {
												$pm = 'previsto_' . $j;
												$cm = 'concluido_' . $j;
												$mm = $j;
											}
											$previsto = $acompanhamentofisico_key->$pm;
											$realizado = $acompanhamentofisico_key->$cm;
											$atribuirPreFinanceiro = $atribuirPreFinanceiro + $previsto;
											$atribuirRelFinanceiro = $atribuirRelFinanceiro + $realizado;
											?>
											<td>
												<div class="tagAzul" style="max-width: 100px;">
													<?php if (0 < $previsto) {
														print (number_format($previsto, 2, ",", "."));
													} else {
														echo '--';
													} ?>
												</div>
												<br>
												<div class="tagVerdeClaro" style="max-width: 100px;">
													<?php if (0 < $realizado) {
														print(number_format($realizado, 2, ",", "."));
													} else {
														echo '--';
													}
													?>
												</div>
												<hr>
												<div class="tagAzul" style="max-width: 100px;">
													<?php if (0 < ($atribuirPreFinanceiro)) {
														$acumulado = ($atribuirPreFinanceiro);
														print(number_format($acumulado, 2, ",", "."));
													} else {
														echo '--';
													} ?>
												</div>
												<br>
												<div class="tagVerdeClaro" style="max-width: 100px;">
													<?php if (0 < ($atribuirRelFinanceiro)) {
														$acumulado02 = ($atribuirRelFinanceiro);
//														if ($ano > $breakrealizadoano) {
															print(number_format($acumulado02, 2, ",", "."));
//														}
//														if ($ano == $breakrealizadoano) {
//															if ($mm <= $mes) {
//																print(number_format($acumulado02, 2, ",", "."));
//															}
//														}
													} else {
														echo '--';
													}
													?>
												</div>
											</td>
											<?php
										}
										?>
										<td>
											<div class="nameAzul" style="max-width: 100px;">
												<?php $acumulado = ($atribuirPreFinanceiro);
												print(number_format($acumulado, 2, ",", ".")) ?>
											</div>
											<br>
											<div class="nameVerdeClaro" style="max-width: 100px;">
												<?php $acumulado = ($atribuirRelFinanceiro);
												print(number_format($acumulado, 2, ",", ".")) ?>
											</div>
											<hr>
											<div class="nameAzul" style="max-width: 100px;">
												<?php $acumulado = ($atribuirPreFinanceiro);
												print(number_format($acumulado, 2, ",", ".")) ?>
											</div>
											<br>
											<div class="nameVerdeClaro" style="max-width: 100px;">
												<?php $acumulado13 = ($atribuirRelFinanceiro);
												print(number_format($acumulado13, 2, ",", ".")) ?>
											</div>
										</td>
									</tr>
									<?php
								}
							}
							?>
							<?php
							foreach ($acompanhamentofinanceirov as $acompanhamentofisico_key) {
								if ($acompanhamentofisico_key->ano === $anoacompanhentofinanceiro_key->ano) {
									$atribuirValprevisto = 0;
									$atribuirValexecutado = 0;
									$breakrealizado = $mes;
									?>
									<tr>
										<td rowspan="9" style="transform: rotate(270deg)">SERVI??OS CONSOLIDADOS</td>
										<td rowspan="4">
											<div>
												Valor Previsto Mensal
											</div>
											<br>
											<div>
												Valor Executado Mensal
											</div>
											<br>
											<div>
												Valor Previsto Acumulado
											</div>
											<br>
											<div>
												Valor Exec. Acumulado
											</div>
										</td>
										<td rowspan="4">(R$ em milhares)</td>
										<?php
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'previsto_0' . $j;
											$mm = '0' . $j;
											if ($j >= 10) {
												$pm = 'previsto_' . $j;
												$mm = $j;
											}
											$previstomensal = $acompanhamentofisico_key->$pm;
											$atribuirValprevisto = $atribuirValprevisto + $previstomensal;
											?>
											<td><?php
												print (intval($previstomensal)) ?></td>

											<?php
										}
										?>
										<td><?php $valortotal = 0;
											$valortotal = ($atribuirValprevisto);
											if ($valortotal > 0) {
											}
											print (intval($valortotal)) ?></td>
									</tr>
									<tr>
										<?php
										for ($j = 1; $j <= 12; $j++) {
											$em = 'executado_0' . $j;
											if ($j >= 10) {
												$em = 'executado_' . $j;
											}
											$executadomensal = $acompanhamentofisico_key->$em;
											$atribuirValexecutado = $atribuirValexecutado + $executadomensal;
											?>
											<td><?php
												print (intval($executadomensal)) ?></td>

											<?php
										}
										?>

										<td><?php $valortotal = 0;
											$valortotal = ($atribuirValexecutado);
											if ($valortotal > 0) {
											}
											print (intval($valortotal)) ?></td>
									</tr>
									<tr>
										<?php
										$atribuirValprevistoAcumulado = 0;
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'previsto_0' . $j;
											if ($j >= 10) {
												$pm = 'previsto_' . $j;

											}
											$previstoacumulado = $acompanhamentofisico_key->$pm;
											$atribuirValprevistoAcumulado = $atribuirValprevistoAcumulado + $previstoacumulado;
											?>
											<td>
												<?php

												print(intval($atribuirValprevistoAcumulado));
												?>
											</td>
											<?php
										}
										?>
										<td><?php $acumulado = ($atribuirValprevistoAcumulado);
											print(intval($acumulado)) ?>
										</td>
									</tr>
									<tr>
										<?php
										$atribuirValexecutadoAcumulado = 0;
										for ($j = 1; $j <= 12; $j++) {
											$em = 'executado_0' . $j;
											if ($j >= 10) {
												$em = 'executado_' . $j;
											}
											$executadoacumulado = $acompanhamentofisico_key->$em;
											$atribuirValexecutadoAcumulado = $atribuirValexecutadoAcumulado + $executadoacumulado;
											?>
											<td><?php
												print (intval($atribuirValexecutadoAcumulado)) ?></td>

											<?php
										}
										?>
										<td><?php $acumulado = ($atribuirValexecutadoAcumulado);
											print(intval($acumulado)) ?>
										</td>
									</tr>
									<tr>

										<td rowspan="4">
											<div>
												Percent. Previsto
											</div>
											<br>
											<div>
												Percent. Executado
											</div>
											<br>
											<div>
												Percent. Previsto Acumulado
											</div>
											<br>
											<div>
												Percent. Exec. Acumulado
											</div>
										</td>
										<td rowspan="4">%</td>
										<?php
										$atribuirPercentprevisto = 0;
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'percentprev_0' . $j;
											if ($j >= 10) {
												$pm = 'percentprev_' . $j;

											}
											$percentmensal = $acompanhamentofisico_key->$pm;
											$atribuirPercentprevisto = $atribuirPercentprevisto + $percentmensal;
											?>
											<td><?php
												print (round($percentmensal, 2) . '%') ?></td>
											<?php
										}
										?>
										<td><?php $valortotal = 0;
											$valortotal = ($atribuirPercentprevisto);
											if ($valortotal > 0) {
											}
											print (round($valortotal, 2) . '%') ?></td>
									</tr>
									<tr>
										<?php
										$atribuirPercentexecutado = 0;
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'percentex_0' . $j;
											if ($j >= 10) {
												$pm = 'percentex_' . $j;

											}
											$percentexecutadomensal = $acompanhamentofisico_key->$pm;
											$atribuirPercentexecutado = $atribuirPercentexecutado + $percentexecutadomensal;
											?>
											<td><?php
												print (round($percentexecutadomensal, 2) . '%') ?></td>
											<?php
										}
										?>

										<td><?php $valortotal = 0;
											$valortotal = ($atribuirPercentexecutado);
											if ($valortotal > 0) {
											}
											print (round($valortotal, 2) . '%') ?></td>
									</tr>
									<tr>
										<?php
										$atribuirPercentprevistoAcumulado = 0;
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'percentprev_0' . $j;
											if ($j >= 10) {
												$pm = 'percentprev_' . $j;

											}
											$percentacumulado = $acompanhamentofisico_key->$pm;
											$atribuirPercentprevistoAcumulado = $atribuirPercentprevistoAcumulado + $percentacumulado;
											?>
											<td>
												<?php
												$acumulado01 = ($atribuirPercentprevistoAcumulado);
												print(round($acumulado01, 2) . '%');
												?>
											</td>
											<?php
										}
										?>
										<td><?php $acumulado = ($atribuirPercentprevistoAcumulado);
											print(round($acumulado, 2) . '%') ?>
										</td>
									</tr>
									<tr>
										<?php
										$atribuirPercentexecutadoAcumulado = 0;
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'percentex_0' . $j;
											if ($j >= 10) {
												$pm = 'percentex_' . $j;

											}
											$percentexecutadoacumulado = $acompanhamentofisico_key->$pm;
											$atribuirPercentexecutadoAcumulado = $atribuirPercentexecutadoAcumulado + $percentexecutadoacumulado;
											?>
											<td>
												<?php
												$acumulado01 = ($atribuirPercentexecutadoAcumulado);
												print(round($acumulado01, 2) . '%');
												?>
											</td>
											<?php
										}
										?>
										<td><?php $acumulado = ($atribuirPercentexecutadoAcumulado);
											print(round($acumulado, 2) . '%') ?>
										</td>
									</tr>
									<tr>

										<td rowspan="4">
											<div>
												IDFin (??ndice de Desempenho Financeiro)
											</div>
											<br>

										</td>
										<td rowspan="4"></td>
										<?php
										$atribuirprevistoidf = 0.0;
										$atribuirexecutadoidf = 0.0;
										$atribuir_total_idf_fin = 0.0;
										for ($j = 1; $j <= 12; $j++) {
											$pm = 'previsto_0' . $j;
											$em = 'executado_0' . $j;
											$mm = '0' . $j;
											if ($j >= 10) {
												$pm = 'previsto_' . $j;
												$em = 'executado_' . $j;
												$mm = $j;
											}
											$previstomensalidf = $acompanhamentofisico_key->$pm;
											$executadomensalidf = $acompanhamentofisico_key->$em;
                                                                                        
                                                                                        if( $previstomensalidf > 0.0 and $executadomensalidf > 0.0){
                                                                                            
											$atribuirprevistoidf = $atribuirprevistoidf + $previstomensalidf;
											$atribuirexecutadoidf = $atribuirexecutadoidf + $executadomensalidf;
                                                                                        if(($atribuirexecutadoidf > 0.0) and ($atribuirprevistoidf > 0.0)){
											$atribuir_total_idf_fin = $atribuir_total_idf_fin + @($atribuirexecutadoidf / $atribuirprevistoidf);
                                                                                        }else{
                                                                                        $atribuir_total_idf_fin = $atribuir_total_idf_fin;    
                                                                                        }
                                                                                        
                                                                                        }
                                                                                       /*  if( $previstomensalidf > 0.0 and $executadomensalidf > 0.0){
                                                                                        echo('previstomensalidf=='.$previstomensalidf);
                                                                                        echo('<br>');
                                                                                        echo('executadomensalidf=='.$executadomensalidf);
                                                                                        echo('<br>');
                                                                                        echo('atribuirprevistoidf=='.$atribuirprevistoidf);
                                                                                        echo('<br>');
                                                                                        echo('atribuirexecutadoidf=='.$atribuirexecutadoidf);
                                                                                        echo('<br>');
                                                                                        echo('atribuir_total_idf_fin=='.$atribuir_total_idf_fin);
                                                                                        echo('<br>');
                                                                                        echo('(atribuirexecutadoidf / atribuirprevistoidf)=='.($atribuirexecutadoidf / $atribuirprevistoidf));
                                                                                        echo('<br>');
                                                                                         }*/
                                                                                        
                                                                                        
                                                                                       
											?>
											<td><?php $mensalvaloridf1 = 0;
												if ($executadomensalidf > 0 && $previstomensalidf > 0) {
													$mensalvaloridf1 = $previstomensalidf / $executadomensalidf;
												}
												print (round($mensalvaloridf1, 2)) ?></td>
											<?php
										}
                                                                                 
                                                                                
										?>

										<td><?php 
                                                                                       // echo('==='.$atribuir_total_idf_fin);
                                                                                       // echo('<br>');
                                                                                        $valoidf = 0.0;                                                                                        
											$valoidf = $atribuir_total_idf_fin;
											print (round($valoidf, 2));
											?></td>
									</tr>

									</tbody>
									</table> <br>
									<hr>
								<?php }
							}
						}
					}
				} ?>

			</div>
		</div>
	</section>
	<section class="sheet padding-10mm">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify">
		</div>
		<span style="color:#e91e63;font-weight: bold;font-size: 17px;">Curva 'S'</span>
		<div class="table-responsive">
			<table class="tabela bordaCompleta" style="width: 100%;">
				<tbody>
				<tr>
					<td style="text-align: -webkit-center; text-align:-moz-center;">
						<div id="curve_chart" style="min-height: 600px;"></div>
					</td>
				</tr>
				<tr>
					<td style="background-color: #015175;color:white;">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6" style="border-right: 1px solid black;">
								<dl class="dl-horizontal">
									<dt>Hidrovia</dt>
									<dd><?= $hidrovia_localizacao; ?></dd>
									<dt>Municipio</dt>
									<dd><?= $municio_localizacao; ?></dd>
									<dt>Extens??o/??rea</dt>
									<dd><?= $extensao_localizacao; ?></dd>
									<dt>Contrato</dt>
									<dd><?= $n_contrato_obra; ?></dd>
									<dt>Empresa</dt>
									<dd><?= $empresa_obra; ?></dd>
								</dl>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6">
								<dl class="dl-horizontal">
									<dt>M??s de refer??ncia</dt>
									<dd><?= $periodo_referencia ?></dd>
									<dt>Vers??o</dt>
									<dd><? ?></dd>
								</dl>
								<br>
								<dl class="dl-horizontal">
									<dd><img src="<?php echo(base_url('assets/img/LogoDNIT.png')) ?>"
											 style="width: 150px"></dd>
								</dl>
							</div>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</section>
	<section id="construtora_acompanhamento_fisico" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>9.2 ACOMPANHAMENTO F??SICO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify ">
				a) Cronograma/Avan??o F??sico
				<br> <br>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="tabela bordaCompleta deslocarEsquerda table80" style="width: 100%;">
						<?php $i = 1;
						if (empty($anoacompanhemtofisico)) { ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[9.2 ACOMPANHAMENTO FISICO] n??o
									cadastrado!
								</div>
							</tr>
						<?php } else {
							if (!empty($anoacompanhemtofisico)) {
								foreach ($anoacompanhemtofisico as $anoacompanhemtofisico_key) {
									?>
									<thead class="center fundoCinzaCabecalho">
									<tr>
										<td colspan="3">Canal de Navega????o</td>
										<td colspan="12">ACOMPANHAMENTO F??SICO</td>
										<td rowspan="2">TOTAL</td>
									</tr>
									<tr>
										<td>C??D</td>
										<td colspan="2">OBRA/SERVI??O</td>
										<td>Jan/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Fev/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Mar/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Abr/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Mai/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Jun/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Jul/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Ago/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Set/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Out/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Nov/<?= $anoacompanhemtofisico_key->ano ?></td>
										<td>Dez/<?= $anoacompanhemtofisico_key->ano ?></td>
									</tr>
									</thead>
									<?php
									foreach ($acpfisicoavancocronograma as $acompanhamentofisico_key) {
										$atribuir_pre = 0;
										$atribuir_rel = 0;
										$restanteatribuir = 0;
										$atribuir_pre_idf = 0;
										$atribuir_rel_idf = 0;
										$atribuir_total_idf = 0;
										if ($acompanhamentofisico_key->ano === $anoacompanhemtofisico_key->ano) {
											$breakrealizadomes = date('m', strtotime($acompanhamentofisico_key->mesbreak));
											$breakrealizadoano = date('y', strtotime($acompanhamentofisico_key->mesbreak));
											$unidademedida = $acompanhamentofisico_key->unidade_medida;
											$servicoobraacompanhamento = $acompanhamentofisico_key->servico;
											?>
											<tbody>
											<tr>
												<td class="center" rowspan="2"><?= $i++ ?></td>
												<td rowspan="2"><b><?php echo $servicoobraacompanhamento ?></b></td>
												<td>
													<div>
														Previsto Mensal
													</div>
													<br>
													<div>
														Concluido Mensal
													</div>
													<hr>
													<div>
														Previsto Acumulado
													</div>
													<br>
													<div>
														Realizado Acumulado
													</div>
												</td>
												<?php
												for ($j = 1; $j <= 12; $j++) {
													$pm = 'previsto_0' . $j;
													$cm = 'concluido_0' . $j;
													$mm = '0' . $j;
													if ($j >= 10) {
														$pm = 'previsto_' . $j;
														$cm = 'concluido_' . $j;
														$mm = $j;
													}

													$previsto = $acompanhamentofisico_key->$pm;
													$realizado = $acompanhamentofisico_key->$cm;
													$atribuir_pre = $atribuir_pre + $previsto;
													$atribuir_rel = $atribuir_rel + $realizado;
													?>
													<td>
														<div class="tagAzul" style="max-width: 100px;">
															<?php if (0 < $previsto) {
																print (number_format($previsto, 2, ",", ".") . $unidademedida);
															} else {
																echo '--';
															} ?>
														</div>
														<br>
														<div class="tagVerdeClaro" style="max-width: 100px;">
															<?php if (0 < $realizado) {
																print(number_format($realizado, 2, ",", ".") . $unidademedida);
															} else {
																echo '--';
															} ?>
														</div>
														<hr>
														<div class="tagAzul" style="max-width: 100px;">
															<?php if (0 < ($atribuir_pre)) {
																$acumulado = ($atribuir_pre);
																print(number_format($acumulado, 2, ",", ".") . $unidademedida);
															} else {
																echo '--';
															} ?>
														</div>
														<br>
														<div class="tagVerdeClaro" style="max-width: 100px;">
															<?php if (0 < ($atribuir_rel)) {
																$acumulado02 = ($atribuir_rel);
																if ($ano > $breakrealizadoano) {
																	print(number_format($acumulado02, 2, ",", ".") . $unidademedida);
																} else if ($ano == $breakrealizadoano) {
																	if ($mm <= $mes) {
																		print(number_format($acumulado02, 2, ",", ".") . $unidademedida);
																	} else {
																		echo '--';
																	}
																} else {
																	echo '--';
																}
															} else {
																echo '--';
															}
															?>
														</div>
													</td>
													<?php
												}
												?>
												<td>
													<div class="nameAzul" style="max-width: 100px;">
														<?php 
                                                                                                                if($atribuir_pre <= 100){ 
                                                                                                                $acumulado = ($atribuir_pre);
                                                                                                                }else{
                                                                                                                $acumulado = 100;    
                                                                                                                }
														print(number_format($acumulado, 2, ",", ".") . $unidademedida) ?>
													</div>
													<br>
													<div class="nameVerdeClaro" style="max-width: 100px;">
														<?php
                                                                                                                if($atribuir_rel <= 100){
                                                                                                                $acumulado = ($atribuir_rel);
                                                                                                                }else{
                                                                                                                $acumulado = 100;    
                                                                                                                }
														print(number_format($acumulado, 2, ",", ".") . $unidademedida) ?>
													</div>
													<hr>
													<div class="nameAzul" style="max-width: 100px;">
														<?php
                                                                                                                if($atribuir_pre <= 100){
                                                                                                                $acumulado = ($atribuir_pre);
                                                                                                                }else{
                                                                                                                $acumulado = 100;    
                                                                                                                }
														print(number_format($acumulado, 2, ",", ".") . $unidademedida) ?>
													</div>
													<br>
													<div class="nameVerdeClaro" style="max-width: 100px;">
														<?php $acumulado13 = ($atribuir_rel);
														print(number_format($acumulado13, 2, ",", ".") . $unidademedida) ?>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div>
														A Concluir
													</div>
												</td>
												<?php
												for ($j = 1; $j <= 12; $j++) {
													$pm = 'previsto_0' . $j;
													$cm = 'concluido_0' . $j;
													if ($j >= 10) {
														$pm = 'previsto_' . $j;
														$cm = 'concluido_' . $j;
													}
													$mm = '0' . $j;
													$previsto = $acompanhamentofisico_key->$pm;
													$realizado = $acompanhamentofisico_key->$cm;
													$restanteatribuir = $restanteatribuir + ($realizado - $previsto);
													?>
													<td>
														<div class="tagDefault" style="max-width: 100px;">
															<?php
															if ($realizado >= $previsto) {
																$restanteconcluir = ($realizado - $previsto);
															}
															if ($previsto >= $realizado) {
																$restanteconcluir = ($previsto - $realizado);
															}
															print(number_format($restanteconcluir, 2, ",", ".") . $unidademedida) ?>
														</div>
													</td>
													<?php
												}
												?>
												<td>
													<div class="nameDefault">
														<?php $restanteconcluirtotal = ($restanteatribuir);
														print(number_format($restanteconcluirtotal, 2, ",", ".") . $unidademedida) ?>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div>

													</div>
												</td>
												<td colspan="2">
													<div>
														IDFis (??ndice de Desempenho F??sico)
													</div>
												</td>
												<?php
												for ($j = 1; $j <= 12; $j++) {
													$pm = 'previsto_0' . $j;
													$cm = 'concluido_0' . $j;
													if ($j >= 10) {
														$pm = 'previsto_' . $j;
														$cm = 'concluido_' . $j;
													}
													$mm = '0' . $j;
													$previsto = $acompanhamentofisico_key->$pm;
													$realizado = $acompanhamentofisico_key->$cm;
													$atribuir_pre_idf = $atribuir_pre_idf + $previsto;
													$atribuir_rel_idf = $atribuir_rel_idf + $realizado;
                                                                                                        if ($atribuir_pre_idf > 0.0 and $atribuir_rel_idf > 0.0) {
													$atribuir_total_idf = $atribuir_total_idf + ($atribuir_rel_idf / $atribuir_pre_idf);
                                                                                                        }else{
                                                                                                        $atribuir_total_idf = $atribuir_total_idf;    
                                                                                                        }
													?>
													<td><?php $mensalvaloridf = 0.0;
														if ($atribuir_pre_idf > 0.0 and $atribuir_rel_idf > 0.0) {
															$mensalvaloridf = $atribuir_rel_idf / $atribuir_pre_idf;
														}
														print (round($mensalvaloridf, 2)) ?></td>
													<?php
												}
												?>
												<td><?php $valoidf = 0.0;
													$valoidf = $atribuir_total_idf;
													print (round($valoidf, 2));
													?></td>
											</tr>
										<?php }
									}
								} ?>
								</tbody>
							<?php }
						} ?>
					</table>
					<br>
					<hr>
				</div>
			</div>
		</div>
	</section>
	<section id="analise_critica_cronog_construtora" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>10. AN??LISE CR??TICA DOS CRONOGRAMAS</strong>
				</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $analise_critica_cronograma; ?>
			</div>
		</div>
	</section>
	<section id="controle_pluviometrico" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>11. CONTROLE PLUVIOM??TRICO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<tbody>
					<tr>
						<td colspan="12">
							<br>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<table class="bordaCompleta center tabela" style=" width: 100%;">
									<tr class="centerBold">
										<td>DIAS</td>
										<?php echo $total_dias ?>
									</tr>
									<tr>
										<td>Manh??/Tarde/Noite</td>
										<?php echo $status_dia ?>
									</tr>
								</table>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="  margin: 2% 0%;">
								Conven????o: <br>
								<table class="bordaCompleta center tabela" style=" width: 40%;">
									<tr class="centerBold">
										<td>TEMPO</td>
										<td>LEGENDA - LETRA</td>
									</tr>
									<tr class="pluviometricoB">
										<td>BOM</td>
										<td>"B"</td>
									</tr>
									<tr class="pluviometricoIS">
										<td>INSTAVEL</td>
										<td>"S"</td>
									</tr>
									<tr class="pluviometricoC">
										<td>CHUVA</td>
										<td>"C"</td>
									</tr>
									<tr class="pluviometricoI">
										<td>IMPRATIC??VEL</td>
										<td>"I"</td>
									</tr>

									<tr class="pluviometricoNA">
										<td>N??O HOUVERAM ATIVIDADES</td>
										<td>"N/A"</td>
									</tr>
								</table>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="  margin: 2% 0%;">
								Resumo: <br>
								<table class="bordaCompleta center tabela" style=" width: 40%;">
									<tr class="centerBold">
										<td>PER??ODO</td>
										<td class="pluviometricoB">B</td>
										<td class="pluviometricoIS">S</td>
										<td class="pluviometricoC">C</td>
										<td class="pluviometricoI">I</td>
										<td class="pluviometricoNA">N/A</td>
									</tr>
									<tr>
										<td>Manh??/Tarde/Noite</td>
										<td class="pluviometricoB"><?= $total_bom ?> </td>
										<td class="pluviometricoIS"><?= $total_instavel ?> </td>
										<td class="pluviometricoC"><?= $total_chuva ?> </td>
										<td class="pluviometricoI"><?= $total_imp ?> </td>
										<td class="pluviometricoNA"><?= $total_nhouveatividade ?> </td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3" rowspan="2">
							<dl class="dl-horizontal">
								<dl class="dl-horizontal">
									<dt>Hidrovia</dt>
									<dd><?= $hidrovia_localizacao; ?></dd>
									<dt>Municipio</dt>
									<dd><?= $municio_localizacao; ?></dd>
									<dt>Extens??o/??rea</dt>
									<dd><?= $extensao_localizacao; ?></dd>
									<dt>Contrato</dt>
									<dd><?= $nu_contrato_super; ?></dd>
									<dt>Empresa</dt>
									<dd><?= $empresa_super; ?></dd>
								</dl>
							</dl>
						</td>
						<td colspan="9">
							<div class="col-md-12 center">
								<h2><b>RELAT??RIO PLUVIOM??TRICO</b></h2>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<div class="col-md-12 center">
								<div class="col-md-6">
									<?= $periodo_referencia ?>
								</div>
								<div class="col-md-6" style=" border-left: 1px solid black;">
									VERS??O 1
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section id="resumo_avanco_fisico" class="sheet padding-10mm">
		<div class="row" id="resumo_avanco_fisico">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>12. RESUMO DE AVAN??O F??SICO</strong>
				</h3>
			</div>
		</div>
		<br>
		<div class="table-responsive">
			<table class="tabela bordaCompleta table80" style="width: 100%;">
				<thead class="center fundoCinzaCabecalho">
				<tr>
					<td rowspan="2">Disciplina Obra-Servi??o</td>
					<td colspan="3">Eixo Canal de Navega????o</td>
				</tr>
				<tr>
					<td>Conclu??do</td>

					<td>A Concluir</td>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($dadosresumoavancofisico as $dadosresumoavancofisico_key) {
					$dadosresumoavancofisico_servico = $dadosresumoavancofisico_key->servico;
					$dadosresumoavancofisico_unidade_medida = $dadosresumoavancofisico_key->unidade;
					$dadosresumoavancofisico_executado = $dadosresumoavancofisico_key->executado;
					$dadosresumoavancofisico_concluir = $dadosresumoavancofisico_key->concluir;
					?>
					<tr>
						<td><?php print $dadosresumoavancofisico_servico ?></td>


						<td><?php print $dadosresumoavancofisico_executado ?></td>


						<td><?php print ($dadosresumoavancofisico_concluir . $dadosresumoavancofisico_unidade_medida); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</section>
	<section id="controle_pluviometrico_documentacao_fotografica" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>13. DOCUMENTA????O FOTOGR??FICA</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify">
				<div class="row">
					<?php
					if (empty($DocumentacaoFotografica)) { ?>
						<tr class="center">
							<div class="alert alert-danger" role="alert">[13. DOCUMENTA????O FOTOGR??FICA] n??o
								cadastrado!
							</div>
						</tr>
					<?php } else {
						$j = 1;
						foreach ($DocumentacaoFotografica as $DocumentacaoFotografica) {
							?>
							<div class="col-md-6">
								<table class="tabela bordaCompleta" style="width: 100%">
									<thead class="fundoCinzaCabecalho">
									<tr class="center">
										<td colspan="3">FOTO <?= $j++; ?></td>
									</tr>
									<tr>
										<td>Disciplina</td>
										<td>Estaca:<?php echo $DocumentacaoFotografica->estaca ?></td>
										<td>Km: <?php echo $DocumentacaoFotografica->km ?></td>
									</tr>
									<tr>
										<td colspan="2" style='font:11px/21px Arial,tahoma,sans-serif;'>
											Descri????o: <?php echo $DocumentacaoFotografica->descricao ?></td>
										<td>Data: <?php echo $DocumentacaoFotografica->atualizacao ?></td>
									</tr>
									<tr>
										<td>Coordenada</td>
										<td>Lat: <?php echo $DocumentacaoFotografica->latitude ?></td>
										<td>Long: <?php echo $DocumentacaoFotografica->longitude ?></td>
									</tr>
									</thead>
									<tbody class="center">
									<tr>
										<td colspan="3"><img
													src="<?php echo(base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $DocumentacaoFotografica->nome_arquivo)) ?>"
													style="width: 100%; height: 372px;"></td>
									</tr>
									</tbody>
								</table>
							</div>
						<?php }
					} ?>
				</div>
			</div>
		</div>
	</section>
	<section id="componente_ambiental" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>14. MONITORAMENTO AMBIENTAL</strong>
				</h3>
			</div>
		</div>
		<div class="table-responsive">
			<table class="tabela bordaCompleta" style="width: 100%;">
				<tbody>
				<?php
				if (empty($LicencasAmbientais)){ ?>
					<tr class="center">
						<div class="alert alert-danger" role="alert">[14. MONITORAMENTO AMBIENTAL] n??o cadastrado!</div>
					</tr>
				<?php }else{ ?>
				<thead class="center fundoCinzaCabecalho">
				<tr>
					<td colspan="8">LICEN??AS AMBIENTAIS VIGENTES</td>
				</tr>
				<tr>
					<td>N??</td>
					<td>Tipo</td>
					<td>??rg??o Emissor</td>
					<td>Data Emiss??o</td>

					<td>Vig??ncia</td>
					<td>Resumo</td>
					<td>Condicionantes</td>
				</tr>
				</thead>
				<?php
				foreach ($LicencasAmbientais as $key) {
					$LICENCAVIGENTE = $key->licenca;
					$TIPOVIGENTE = $key->tipo;
					$EMISSORVIGENTE = $key->orgao_emissor;
					$DATAVIGENTE = $key->data_emissao;
					$TERMINOVIGENTE = $key->termino_vigencia;
					$VIGENCIA = $key->vigencia;
					$REUMOAMBIENTAL = $key->resumo;
					$CONDICIONANTEVIGENTE = $key->condicionantes_ambientais;
					?>
					<tr>
						<td><?= $LICENCAVIGENTE ?></td>
						<td><?= $TIPOVIGENTE ?></td>
						<td><?= $EMISSORVIGENTE ?></td>
						<td><?= $DATAVIGENTE ?></td>
						<td><?= $VIGENCIA ?></td>
						<td><?= $REUMOAMBIENTAL ?></td>
						<td><?= $CONDICIONANTEVIGENTE ?></td>
					</tr>
				<?php }
				} ?>
				</tbody>
			</table>
		</div>
	</section>
	<section id="gestao_qualidade" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>15. GEST??O DA QUALIDADE</strong>
				</h3>
			</div>
		</div>
		<div class="row" id="ensaio_laboratorio_construtora">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>15.1 ENSAIOS DE LABORAT??RIO DA CONSTRUTORA</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $EnsaioConstrutora; ?>
			</div>
		</div>
		<div class="row" id="ensaio_laboratorio_supervisora">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>15.2 ENSAIOS DE LABORAT??RIO DA SUPERVISORA</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $EnsaioSupervisora; ?>
			</div>
		</div>
		<!-- 11.4 REGISTROS DE N??O CONFORMIDADES ??? RNC -->
		<div class="row" id="gestao_rnc">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>16. REGISTROS DE N??O CONFORMIDADES ??? RNC</strong>
				</h3>
			</div>
		</div>
		<div class="table-responsive">
			<table class="tabela bordaCompleta" style="width: 100%;">
				<tbody>
				<?php
				if (empty($RNC)){ ?>
					<tr class="center">
						<div class="alert alert-danger" role="alert">[16. REGISTROS DE N??O CONFORMIDADES ??? RNC] - N??o
							houve atividade no m??s
						</div>
					</tr>
				<?php }else{ ?>
				<thead class="center fundoCinzaCabecalho">
				<tr>
					<td>N??</td>
					<td>Data Emiss??o</td>
					<td>Eixo</td>
					<td>Natureza</td>
					<td>Gravidade</td>
					<td>Localiza????o</td>
					<td>Status</td>
					<td>Data de Atualiza????o</td>
					<td>Data de Fechamento</td>
				</tr>
				</thead>
				<?php $n = 1;
				foreach ($RNC as $dadosRNC) { ?>
					<tr>
						<td><?= $n++ ?></td>
						<td><?= $dadosRNC->data_registro ?></td>
						<td><?= $dadosRNC->desc_tipo_eixo ?></td>
						<td><?= $dadosRNC->desc_natureza ?></td>
						<td><?= $dadosRNC->desc_gravidade ?></td>
						<td><?= $dadosRNC->ref ?></td>
						<td><?= $dadosRNC->status ?></td>
						<td><?= $dadosRNC->dtatualizacao ?></td>
						<td><?= $dadosRNC->dtfechamento ?></td>
					</tr>
				<?php }
				} ?>
				</tbody>
			</table>
		</div>
	</section>
	<section id="gestao_juridica_garantias_seguros" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>17. GEST??O JUR??DICA, GARANTIAS E SEGUROS</strong>
				</h3>
			</div>
		</div>
		<div class="table-responsive">
			<table class="tabela bordaCompleta" style="width: 100%;">
				<tbody>
				<?php
				if (empty($GarantiasSeguros)){ ?>
					<tr class="center">
						<div class="alert alert-danger" role="alert">[17. GEST??O JUR??DICA, GARANTIAS E SEGUROS] n??o
							cadastrado!
						</div>
					</tr>
				<?php }else{ ?>
				<thead class="center fundoCinzaCabecalho">
				<tr>
					<td rowspan="2">Guia</td>
					<td rowspan="2">Tipo Garantia</td>
					<td rowspan="2">Processo</td>
					<td rowspan="2">Valor da Garantia</td>
					<td colspan="2">Vig??ncia da Garantia</td>
					<td colspan="3">Documento de Garantia</td>
					<td rowspan="2">Objeto</td>
					<td rowspan="2">Observa????o</td>
					<td rowspan="2">Situa????o</td>
				</tr>
				<tr>
					<td>Inicio</td>
					<td>Fim</td>
					<td>Institui????o Financeira/Seguradora</td>
					<td>N??mero Ap??lice</td>
					<td>Data Emiss??o</td>
				</tr>
				</thead>
				<?php foreach ($GarantiasSeguros as $key) {
					$GARANTIASEGUROSNUMGUIA = $key->num_guia;
					$GARANTIASEGUROSTIPO = $key->desc_tipo_garantia;
					$GARANTIASEGUROSPROCESSO = $key->processo;
					$GARANTIASEGUROSVALOR = $key->valor_garantia;
					$GARANTIASEGUROSINICIO = $key->inicio_vigencia;
					$GARANTIASEGUROSTERMINO = $key->termino_vigencia;
					$GARANTIASEGUROSINSTITUICAO = $key->instituicao;
					$GARANTIASEGUROSAPOLICE = $key->num_apolice;
					$GARANTIASEGUROSDATAEMISSAO = $key->data_emissao;
					$GARANTIASEGUROSOBJETO = $key->desc_objeto;
					$GARANTIASEGUROSOBS = $key->desc_observacao;
					$GARANTIASEGUROSSITUACAO = $key->situacao;
					?>
					<tr>
						<td><?= $GARANTIASEGUROSNUMGUIA ?></td>
						<td><?= $GARANTIASEGUROSTIPO ?></td>
						<td><?= $GARANTIASEGUROSPROCESSO ?></td>
						<td><?= $GARANTIASEGUROSVALOR ?></td>
						<td><?= $GARANTIASEGUROSINICIO ?></td>
						<td><?= $GARANTIASEGUROSTERMINO ?></td>
						<td><?= $GARANTIASEGUROSINSTITUICAO ?></td>
						<td><?= $GARANTIASEGUROSAPOLICE ?></td>
						<td><?= $GARANTIASEGUROSDATAEMISSAO ?></td>
						<td><?= $GARANTIASEGUROSOBJETO ?></td>
						<td><?= $GARANTIASEGUROSOBS ?></td>
						<td><?= $GARANTIASEGUROSSITUACAO ?></td>
					</tr>
				<?php }
				} ?>
				</tbody>
			</table>
		</div>
	</section>
	<!-- fim 12. GEST??O JUR??DICA, GARANTIAS E SEGUROS -->
	<!-- inicio 13. GEST??O DE RISCOS E INTERFER??NCIAS -->
	<section id="riscos_interferencias" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>18. GEST??O DE RISCOS E INTERFER??NCIAS</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
				<table class="tabela bordaCompleta" style="width: 100%">
					<tbody>
					<?php
					if (empty($RiscosInterferencias)){ ?>
						<tr class="center">
							<div class="alert alert-danger" role="alert">[18. GEST??O DE RISCOS E INTERFER??NCIAS] N??o
								houve atividade no m??s
							</div>
						</tr>
					<?php } else { ?>
					<thead class="fundoCinzaCabecalho">
					<tr class="center">
						<td>Tipo</td>
						<td>Classifica????o</td>
						<td>Descri????o</td>
						<td>Km Inicial</td>
						<td>Km Final</td>
						<td>Grau de Impacto</td>
						<td>Previs??o de Solu????o</td>
						<td>Data Limite</td>
						<td>Impacto em custo?</td>
						<td>Impacto em prazo?</td>
					</tr>
					</thead>
					<?php foreach ($RiscosInterferencias as $key) {
						$TIPO_INTERFERENCIA = $key->desc_tipo;
						$TIPO_CLASSIFICACAO = $key->desc_classificacao;
						$RESUMORISCOS = $key->resumo;
						$INICIALRISCOS = $key->km_inicial;
						$FINALRISCOS = $key->km_final;
						$TIPO_GRAUIMPACTORISCOS = $key->desc_grau_impacto;
						$SOLUCAORISCOS = $key->previsao_solucao;
						$DATA_LIMITERISCOS = $key->data_limite;
						$IMPACTO_CUSTORISCOS = $key->impacto_custo;
						$IMPACTO_PRAZORISCOS = $key->impacto_prazo;
						if ($IMPACTO_CUSTORISCOS === '1') {
							$IMPACTO_CUSTORISCOS = "Sim";
						}
						if ($IMPACTO_CUSTORISCOS === '0') {
							$IMPACTO_CUSTORISCOS = "N??o";
						}
						if ($IMPACTO_PRAZORISCOS === '1') {
							$IMPACTO_PRAZORISCOS = "Sim";
						}
						if ($IMPACTO_PRAZORISCOS === '0') {
							$IMPACTO_PRAZORISCOS = "N??o";
						} ?>
						<tr class="center">
							<td><?= $TIPO_INTERFERENCIA ?></td>
							<td><?= $TIPO_CLASSIFICACAO ?></td>
							<td><?= $RESUMORISCOS ?></td>
							<td><?= $INICIALRISCOS ?></td>
							<td><?= $FINALRISCOS ?></td>
							<td><?= $TIPO_GRAUIMPACTORISCOS ?></td>
							<td><?= $SOLUCAORISCOS ?></td>
							<td><?= $DATA_LIMITERISCOS ?></td>
							<td><?= $IMPACTO_CUSTORISCOS ?></td>
							<td><?= $IMPACTO_PRAZORISCOS ?></td>
						</tr>
					<?php }
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section id="atas_correspondencias" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>19. ATAS E CORRESPOND??NCIAS</strong>
				</h3>
			</div>
		</div>
		<div class="table-responsive">
			<table class="tabela bordaCompleta" style="width: 100%;">
				<tbody>
				<?php
				if (empty($AtasCorrespondencias)){ ?>
					<tr class="center">
						<div class="alert alert-danger" role="alert">[19. ATAS E CORRESPOND??NCIAS] n??o cadastrado!</div>
					</tr><?php } else { ?>
				<thead class="center fundoCinzaCabecalho">
				<tr>
					<td>Tipo</td>
					<td>N??</td>
					<td>Data</td>
					<td>Assunto</td>
					<td>Descri????o</td>
				</tr>
				</thead>
				<?php foreach ($AtasCorrespondencias as $key) {
					$TIPOATASCORRESPONDENCIA = $key->tipo_documento;
					$NUMEROATASCORRESPONDENCIA = $key->numero_documento;
					$DATAATASCORRESPONDENCIA = $key->data_atividade;
					$ASSUNTOATASCORRESPONDENCIA = $key->assunto;
					$DESCRICAOATASCORRESPONDENCIA = $key->desc_atas_correspondecia;
					?>
					<tr>
						<td><?= $TIPOATASCORRESPONDENCIA ?></td>
						<td><?= $NUMEROATASCORRESPONDENCIA ?></td>
						<td><?= $DATAATASCORRESPONDENCIA ?></td>
						<td><?= $ASSUNTOATASCORRESPONDENCIA ?></td>
						<td><?= $DESCRICAOATASCORRESPONDENCIA ?></td>
					</tr>
				<?php }
				} ?>
				</tbody>
			</table>
		</div>
	</section>
	<section id="gestao_tratativas" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>20. GEST??O DE TRATATIVAS</strong>
				</h3>
			</div>
		</div>
		<div class="table-responsive">
			<table class="tabela bordaCompleta" style="width: 100%;">
				<tbody>
				<?php
				if (empty($GestaoTratativas)){ ?>
					<tr class="center">
						<div class="alert alert-danger" role="alert">[20. GEST??O DE TRATATIVAS] N??o houve atividade no
							m??s!
						</div>
					</tr>
				<?php }else{ ?>
				<thead class="center fundoCinzaCabecalho">
				<tr>
					<td>Origem</td>
					<td>Data da Solicita????o</td>
					<td>Assunto</td>
					<td>Provid??ncia</td>
					<td>Respons??vel</td>
					<td>Data Pactuada</td>
					<td>Nova Data Pactuada</td>
					<td>Status</td>
					<td>Data de T??rmino</td>
				</tr>
				</thead>
				<?php foreach ($GestaoTratativas as $key) { ?>
					<tr>
						<td><?= $key->origem ?></td>
						<td><?= $key->data_solicitacao ?></td>
						<td><?= $key->assunto_tratativa ?></td>
						<td><?= $key->providencia ?></td>
						<td><?= $key->responsavel ?></td>
						<td><?= $key->data_pactuada ?></td>
						<td><?= $key->nova_data_pactuada ?></td>
						<td><?= $key->status ?></td>
						<td><?= $key->data_termino ?></td>
					</tr>
				<?php }
				} ?>
				</tbody>
			</table>
		</div>
	</section>
	<section id="conclusao_comentarios" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>21. CONCLUS??O E COMENT??RIOS</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $resumo_conclusao; ?>
			</div>
		</div>
	</section>
	<section id="termo_encerramento" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>22. TERMO DE ENCERRAMENTO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $texto_encerramento; ?>
			</div>
		</div>
	</section>
	<section id="anexos" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>23. ANEXOS</strong>
				</h3>
			</div>
		</div>

		<!-- fim 18. ANEXOS -->
		<!-- <section id="anexo_resumo" class="sheet padding-10mm"> -->
		<div id="anexo_resumo">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.1 RESUMO DE PROJETO</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($resumoprojetoAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.1 RESUMO DE PROJETO] n??o cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">Tipo</td>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($resumoprojetoAnexo as $resumoprojetoAnexo) {
							if (!empty($resumoprojetoAnexo->nomeOriginalArquivo)) {
								$nomeArquivo = $resumoprojetoAnexo->nomeOriginalArquivo . "." . @end(explode(".", $resumoprojetoAnexo->nome_arquivo));
							} else {
								$nomeArquivo = $resumoprojetoAnexo->nome_arquivo;
							}
							?>
							<tr>
								<td><?= $resumoprojetoAnexo->desc_tipo_obra ?></td>
								<td><?= $resumoprojetoAnexo->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $resumoprojetoAnexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="resumo_avanco_fisico" class="sheet padding-10mm"> -->
		<div id="resumo_avanco_fisico">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.2 RPFO - Revis??o de projetos em fase de obra
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($rpfoprojetoAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.2 RPFO - Revis??o de projetos em fase de
									obra] - N??o houve atividade no m??s
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($rpfoprojetoAnexo as $key) {
							if (!empty($key->nomeOriginalArquivo)) {
								$nomeArquivo = $key->nomeOriginalArquivo . "." . @end(explode(".", $key->nome_arquivo));
							} else {
								$nomeArquivo = $key->nome_arquivo;
							}
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $key->nome_arquivo;
							?>
							<tr>
								<td><?= $key->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $key->nome_arquivo ?>')"><?= $nomeArquivo ?></a></td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_monitoramento" class="sheet padding-10mm"> -->
		<div id="anexo_monitoramento">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.3 MONITORAMENTO AMBIENTAL
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($monitoramentoAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.3 MONITORAMENTO AMBIENTAL] n??o
									cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($monitoramentoAnexo as $monitoramentoambital) {
							if (!empty($monitoramentoambital->arquivo)) {
								$nomeArquivo = $monitoramentoambital->arquivo . "." . @end(explode(".", $monitoramentoambital->nome_arquivo));
							} else {
								$nomeArquivo = $monitoramentoambital->nome_arquivo;
							}
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $monitoramentoambital->nome_arquivo;
							?>
							<tr>
								<td><?= $monitoramentoambital->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $monitoramentoambital->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_pba" class="sheet padding-10mm"> -->
		<div id="anexo_pba">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.4 PBA/PBAI
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($pbapbaiAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.4 PBA/PBAI] n??o cadastrado!</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($pbapbaiAnexo as $pbapbaianexos) {
							if (!empty($pbapbaianexos->arquivo)) {
								$nomeArquivo = $pbapbaianexos->arquivo . "." . @end(explode(".", $pbapbaianexos->nome_arquivo));
							} else {
								$nomeArquivo = $pbapbaianexos->nome_arquivo;
							}
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $pbapbaianexos->nome_arquivo;
							?>
							<tr>
								<td><?= $pbapbaianexos->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $pbapbaianexos->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_licenciamneto" class="sheet padding-10mm"> -->
		<div id="anexo_licenciamneto">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.5 LICENCIAMENTO AMBIENTAL
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($licencasambientaisAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.5 LICENCIAMENTO AMBIENTAL] n??o
									cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">N??mero</td>
							<td rowspan="2">Tipo</td>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($licencasambientaisAnexo as $licencasambientaisAnexo) {
							if (!empty($licencasambientaisAnexo->nomeOriginalArquivo)) {
								$nomeArquivo = $licencasambientaisAnexo->nomeOriginalArquivo . "." . @end(explode(".", $licencasambientaisAnexo->nome_arquivo));
							} else {
								$nomeArquivo = $licencasambientaisAnexo->nome_arquivo;
							}
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $licencasambientaisAnexo->nome_arquivo;
							?>
							<tr>
								<td><?= $licencasambientaisAnexo->licenca ?></td>
								<td><?= $licencasambientaisAnexo->tipo ?></td>
								<td><?= $licencasambientaisAnexo->atualizacao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $licencasambientaisAnexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_lab_construtora" class="sheet padding-10mm"> -->
		<div id="anexo_lab_construtora">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.6 ENSAIOS DE LABORAT??RIO DA CONSTRUTORA
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($ensaiodelaboratorioconstrutoraAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.6 ENSAIOS DE LABORAT??RIO DA
									CONSTRUTORA] n??o cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($ensaiodelaboratorioconstrutoraAnexo as $ensaiodelaboratorioconstrutoraAnexo) {
							if (!empty($ensaiodelaboratorioconstrutoraAnexo->arquivo)) {
								$nomeArquivo = $ensaiodelaboratorioconstrutoraAnexo->arquivo . "." . @end(explode(".", $ensaiodelaboratorioconstrutoraAnexo->nome_arquivo));
							} else {
								$nomeArquivo = $ensaiodelaboratorioconstrutoraAnexo->nome_arquivo;
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $ensaiodelaboratorioconstrutoraAnexo->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $ensaiodelaboratorioconstrutoraAnexo->nome_arquivo;
							?>
							<tr>
								<td><?= $ensaiodelaboratorioconstrutoraAnexo->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $ensaiodelaboratorioconstrutoraAnexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_lab_supervisora" class="sheet padding-10mm"> -->
		<div id="anexo_lab_supervisora">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.7 ENSAIOS DE LABORAT??RIO DA SUPERVISORA
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($ensaiodelaboratoriosupervisorAanexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.7 ENSAIOS DE LABORAT??RIO DA
									SUPERVISORA] n??o cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($ensaiodelaboratoriosupervisorAanexo as $ensaiodelaboratoriosupervisorAanexo) {
							if (!empty($ensaiodelaboratoriosupervisorAanexo->arquivo)) {
								$nomeArquivo = $ensaiodelaboratoriosupervisorAanexo->arquivo . "." . @end(explode(".", $ensaiodelaboratoriosupervisorAanexo->nome_arquivo));
							} else {
								$nomeArquivo = $ensaiodelaboratoriosupervisorAanexo->nome_arquivo;
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $ensaiodelaboratoriosupervisorAanexo->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $ensaiodelaboratoriosupervisorAanexo->nome_arquivo;
							?>
							<tr>
								<td><?= $ensaiodelaboratoriosupervisorAanexo->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $ensaiodelaboratoriosupervisorAanexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<section id="anexos_rnc" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>23.8 REGISTROS DE N??O CONFORMIDADES ??? RNC</strong>
				</h3>
			</div>
		</div>
		<?php if (empty($registronconformidadesrncanexo)) { ?>
			<div class="alert alert-danger" role="alert">[23.8 REGISTROS DE N??O CONFORMIDADES ??? RNC] - N??o houve
				atividade no m??s!
			</div>
		<?php } else {
			?>
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
			<div class="col-xs-12 col-sm-12 col-md-12 smallFont" style="padding: 10px;">
				<div class="col-xs-2 col-sm-2 col-md-2" style="margin-top: 16px;">
					<img src="<?php echo(base_url('assets/img/dnit2.png')) ?>">
				</div>
				<div class="col-xs-8 col-sm-8 col-md-8" style="line-height: 1em;">
					REP??BLICA FEDERATIVA DO BRASIL<br>
					MINIST??RIO DOS TRANSPORTES<br>
					DEPARTAMENTO NACIONAL DE INFRAESTRUTURA DOS TRANSPORTES<br>
					DIRETORIA DE INFRAESTRUTURA AQU??VIARIA
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2" style="margin-top: 15px;">N?? -</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 headerTabela fundoCinzaCabecalho" style=" color:white;">REGISTRO
				DE N??O CONFORMIDADE
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 semPadding">
			<div class="col-xs-1 col-sm-1 col-md-1 headerTabelaVertical fundoCinzaCabecalho" style=" color:white;">
				Identifica????o
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 pull-right tamanho100-25"
				 style="padding: 10px; border-right: 1px solid #333;">
			<table class="col-xs-12 col-sm-12 col-md-12 tabela ">
			<?php foreach ($registronconformidadesrncanexo as $registronconformidadesrncanexo) {
				$CONTRATO = $registronconformidadesrncanexo->nu_con_formatado;
				$COORDENADA_LATITUDE = $registronconformidadesrncanexo->latitude;
				$COORDENADA_LONGITUDE = $registronconformidadesrncanexo->longitude;
				$DESC_NATUREZA = $registronconformidadesrncanexo->desc_tipo_obra;
				$DESC_GRAVIDADE = $registronconformidadesrncanexo->desc_gravidade;
				$DATA_REGISTRO = $registronconformidadesrncanexo->data_registro;
				$KM_RNC = $registronconformidadesrncanexo->km;
				$STATUS_REGISTRO = $registronconformidadesrncanexo->status;
				$PROBLEMA = $registronconformidadesrncanexo->descricao;
				$PROVIDENCIA = $registronconformidadesrncanexo->providencia;
				$DESC_TIPO_EIXO = $registronconformidadesrncanexo->desc_tipo_eixo;
				?>
				<tr>
					<td class="labelForm">Data:</td>
					<td colspan="5"><?= $DATA_REGISTRO ?></td>
					<td class="labelForm">Status:</td>
					<td colspan="2"><?= $STATUS_REGISTRO ?></td>
				</tr>
				<tr>
					<td class="labelForm">Hidrovia:</td>
					<td><?= $hidrovia_localizacao; ?></td>
				</tr>
				<tr>
					<td class="labelForm">Supervisora:</td>
					<td colspan="6">
						<?= $empresa_super; ?>
					</td>
					<td class="labelForm">Contrato:</td>
					<td><?= $nu_contrato_super ?></td>
				</tr>
				<tr>
					<td class="labelForm">Construtora:</td>
					<td colspan="6">
						<?= $empresa_obra ?>
					</td>
					<td class="labelForm">Contrato:</td>
					<td> <?= $CONTRATO ?> </td>
				</tr>
				<tr>
					<td class="labelForm">Coord. Latitude:</td>
					<td><?= $COORDENADA_LATITUDE ?></td>
					<td class="labelForm">Coord. Longitude:</td>
					<td><?= $COORDENADA_LONGITUDE ?></td>
					<td class="labelForm">Km:</td>
					<td><?= $KM_RNC ?></td>
				</tr>
				<tr>
					<td class="labelForm">Eixo:</td>
					<td colspan="4"><?= $DESC_TIPO_EIXO ?></td>
				</tr>
				<tr>
					<td class="labelForm">Natureza:</td>
					<td colspan="4"><?= $DESC_NATUREZA ?></td>
					<td class="labelForm">Grau:</td>
					<td colspan="3"><?= $DESC_GRAVIDADE ?></td>
				</tr>
				</table>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 headerTabela fundoCinzaCabecalho" style=" color:white;">
					Descri????o da Ocorr??ncia
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 semPadding"
					 style="min-height: 100px; border-right: 1px solid #333;">
					<div class="col-xs-1 col-sm-1 col-md-1 headerTabelaVertical fundoCinzaCabecalho"
						 style=" color:white;">Observa????es
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 pull-right headerTabela font12print tamanho100-25"
						 style="text-align: left; border-top: 0; border-left: 0; border-right: 0;">Problema Identificado
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 pull-right font12print tamanho100-25"
						 style="min-height: 140px; font:11px/21px Arial,tahoma,sans-serif;color:black">
						<?= $PROBLEMA ?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 pull-right headerTabela font12print tamanho100-25 fundoCinzaCabecalho"
						 style=" color:white;text-align: left; border-top: 0; border-left: 0; border-right: 0; border-top: 1px solid black;">
						Provid??ncia
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 pull-right font12print tamanho100-25"
						 style="min-height: 140px; font:11px/21px Arial,tahoma,sans-serif;color:black">
						<?= $PROVIDENCIA ?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 headerTabela fundoCinzaCabecalho" style=" color:white;">
					Documenta????o Fotogr??fica
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="headerTabelaVertical fundoCinzaCabecalho"
						 style=" color:white; border-top: 1px solid #333;">Fotos
					</div>
					<?php
					$j = 0;
					foreach ($registronconformidadesrncfotoanexo as $registronconformidadesrncfotoanexo) {
						?>
						<div class="col-xs-6 col-sm-6 col-md-6 semPadding" style=" left:9px;">
							<table class="tabela bordaCompleta" style="width: 100%">
								<thead class="fundoCinzaCabecalho">
								<tr class="center">
									<td colspan="3">FOTO <?= $j++ ?></td>
								</tr>
								<tr>
									<td colspan="2">Descri????o:<?= $registronconformidadesrncfotoanexo->descricao ?></td>
									<td>Data:<?= $registronconformidadesrncfotoanexo->data_atualizacao ?></td>
								</tr>
								</thead>
								<tbody class="center">
								<tr>
									<td colspan="3"><img
												src="<?php echo(base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $registronconformidadesrncfotoanexo->nome_arquivo)) ?>"
												style="width: 100%; height: 372px;"></td>
								</tr>
								</tbody>
							</table>
						</div>
					<?php } ?>
				</div>
				</div>
				</div>
			<?php }
		} ?>
	</section>
	<section id="resumo_avanco_fisico" class="sheet padding-10mm">
		<div id="resumo_avanco_fisico">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.9 Jur??dica,Garantias e Seguros
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($infoGarantiasSeguros)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.9 Jur??dica,Garantias e Seguros] n??o
									cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Tipo Doc.</td>
							<td>Atualiza????o</td>
							<td>Download</td>
						</tr>
						</thead>
						<?php foreach ($infoGarantiasSeguros as $infoGarantiasSeguros) {
							if (!empty($infoGarantiasSeguros->arquivo)) {
								$nomeArquivo = $infoGarantiasSeguros->arquivo . "." . @end(explode(".", $infoGarantiasSeguros->nome_arquivo));
							} else {
								$nomeArquivo = $infoGarantiasSeguros->nome_arquivo;
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $infoGarantiasSeguros->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $infoGarantiasSeguros->nome_arquivo;
							?>
							<tr>
								<td><?= $infoGarantiasSeguros->tipo ?></td>
								<td><?= $infoGarantiasSeguros->atualizacao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $infoGarantiasSeguros->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_atas" class="sheet padding-10mm"> -->
		<div id="anexo_atas">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.10 ATAS E CORRESPOND??NCIAS
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($atascorrespondenciasAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.10 ATAS E CORRESPOND??NCIAS] n??o
									cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Tipo de Documento</td>
							<td>N??mero do Documento</td>
							<td>Atualiza????o</td>
							<td>Download</td>
						</tr>
						</thead>
						<?php foreach ($atascorrespondenciasAnexo as $atascorrespondenciasanexo) {
							if (!empty($atascorrespondenciasanexo->nomeOriginalArquivo)) {
								$nomeArquivo = $atascorrespondenciasanexo->nomeOriginalArquivo . "." . @end(explode(".", $atascorrespondenciasanexo->nome_arquivo));
							} else {
								$nomeArquivo = $atascorrespondenciasanexo->nome_arquivo;
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $atascorrespondenciasanexo->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $atascorrespondenciasanexo->nome_arquivo;
							?>
							<tr>
								<td><?= $atascorrespondenciasanexo->tipo_documento ?></td>
								<td><?= $atascorrespondenciasanexo->numero_documento ?></td>
								<td><?= $atascorrespondenciasanexo->atualizacao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $atascorrespondenciasanexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_art" class="sheet padding-10mm"> -->
		<div id="anexo_art">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.11 ART VIGENTES SUPERVISORA
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($artvigentesAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.11 ART VIGENTES SUPERVISORA] n??o
									cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">N?? ART</td>
							<td rowspan="2">Participa????oT??cnica</td>
							<td rowspan="2">Data de Registro</td>
							<td rowspan="2">Nome do Profissional</td>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($artvigentesAnexo as $artvigentesnexo) {
							if (!empty($artvigentesnexo->nomeOriginalArquivo)) {
								$nomeArquivo = $artvigentesnexo->nomeOriginalArquivo . "." . @end(explode(".", $artvigentesnexo->nome_arquivo));
							} else {
								$nomeArquivo = $artvigentesnexo->nome_arquivo;
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $artvigentesnexo->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $artvigentesnexo->nome_arquivo;
							?>
							<tr>
								<td><?= $artvigentesnexo->num_art ?></td>
								<td><?= $artvigentesnexo->participacao_tecnica ?></td>
								<td><?= $artvigentesnexo->data_registro ?></td>
								<td><?= $artvigentesnexo->nome_profissional ?></td>
								<td><?= $artvigentesnexo->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $artvigentesnexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="anexo_fiscais" class="sheet padding-10mm"> -->
		<div id="anexo_fiscais">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.12 QUADRO DE FISCAIS DNIT
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($portariafiscaisquadroAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.12 QUADRO DE FISCAIS DNIT] n??o
									cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>UF</td>
							<td>N?? da portaria de designa????o</td>
							<td>Data da portaria</td>
							<td>Contrato fiscalizado</td>
							<td>Titularidade</td>
							<td>Nome do fiscal</td>
							<td>Email</td>
							<td>Telefone</td>
							<td>Download</td>
						</tr>
						</thead>
						<?php foreach ($portariafiscaisquadroAnexo as $portariafiscaisquadroanexo) {
							if (!empty($portariafiscaisquadroanexo->arquivo)) {
								$nomeArquivo = $portariafiscaisquadroanexo->arquivo . "." . @end(explode(".", $portariafiscaisquadroanexo->nome_arquivo));
							} else {
								$nomeArquivo = $portariafiscaisquadroanexo->nome_arquivo;
							}
							if ($portariafiscaisquadroanexo->contrato_fiscalizado == 'Supervis??o') {
								$contrato = "" . $portariafiscaisquadroanexo->numero_supervisora . "-" . $portariafiscaisquadroanexo->contrato_fiscalizado . "";
							}
							if ($portariafiscaisquadroanexo->contrato_fiscalizado == 'Obra') {
								$contrato = "" . $portariafiscaisquadroanexo->nu_con_formatado . "-" . $portariafiscaisquadroanexo->contrato_fiscalizado . "";
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $portariafiscaisquadroanexo->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $portariafiscaisquadroanexo->nome_arquivo;
							?>
							<tr>
								<td><?= $portariafiscaisquadroanexo->estado ?></td>
								<td><?= $portariafiscaisquadroanexo->num_portaria ?></td>
								<td><?= $portariafiscaisquadroanexo->portaria ?></td>
								<td><?= $contrato ?></td>
								<td><?= $portariafiscaisquadroanexo->titularidade ?></td>
								<td><?= $portariafiscaisquadroanexo->nome_fiscal ?></td>
								<td><?= $portariafiscaisquadroanexo->email ?></td>
								<td><?= $portariafiscaisquadroanexo->telefone ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $portariafiscaisquadroanexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="resumo_avanco_fisico" class="sheet padding-10mm"> -->
		<div id="resumo_avanco_fisico">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.13 DI??RIO DE OBRA
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($infodiariodeobraAnexo)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.13 DI??RIO DE OBRA] n??o cadastrado!
								</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td rowspan="2">Atualiza????o</td>
							<td colspan="3">Download</td>
						</tr>
						</thead>
						<?php foreach ($infodiariodeobraAnexo as $infodiariodeobraAnexo) {
							if (!empty($infodiariodeobraAnexo->arquivo)) {
								$nomeArquivo = $infodiariodeobraAnexo->arquivo . "." . @end(explode(".", $infodiariodeobraAnexo->nome_arquivo));
							} else {
								$nomeArquivo = $infodiariodeobraAnexo->nome_arquivo;
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $infodiariodeobraAnexo->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $infodiariodeobraAnexo->nome_arquivo;
							?>
							<tr>
								<td><?= $infodiariodeobraAnexo->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $infodiariodeobraAnexo->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- </section> -->
		<!-- <section id="resumo_avanco_fisico" class="sheet padding-10mm">  -->
		<div id="resumo_avanco_fisico">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
					<h3>
						<strong>23.14 DEMAIS ANEXOS
						</strong>
					</h3>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
					<table class="tabela bordaCompleta table80" style="width: 100%;">
						<tbody>
						<?php
						if (empty($infodemaisanexos)){ ?>
							<tr class="center">
								<div class="alert alert-danger" role="alert">[23.14 DEMAIS ANEXOS] n??o cadastrado!</div>
							</tr>
						<?php }else{ ?>
						<thead class="center fundoCinzaCabecalho">
						<tr>
							<td>Tipo Anexo</td>
							<td>Atualiza????o</td>
							<td>Download</td>
						</tr>
						</thead>
						<?php foreach ($infodemaisanexos as $infodemaisanexos) {
							if (!empty($infodemaisanexos->arquivo)) {
								$nomeArquivo = $infodemaisanexos->arquivo . "." . @end(explode(".", $infodemaisanexos->nome_arquivo));
							} else {
								$nomeArquivo = $infodemaisanexos->nome_arquivo;
							}
							$arquivos = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $infodemaisanexos->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
							$arquivo = 'index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=' . $infodemaisanexos->nome_arquivo;
							?>
							<tr>
								<td><b><?= $infodemaisanexos->desc_arquivo ?></b></td>
								<td><?= $infodemaisanexos->ultima_alteracao ?></td>
								<td><a href='javascript:void(0);'
									   onclick="anexoDownload('<?= $infodemaisanexos->nome_arquivo ?>')"><?= $nomeArquivo ?></a>
								</td>
							</tr>
						<?php }
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<section id="relatorioMonitoramentoAmbiental" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>24. RELAT??RIO DE MONITORAMENTO AMBIENTAL</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $texto_relatorio_monitoramento_ambiental; ?>
			</div>
		</div>
	</section>

	<section id="boletimSemanalDragagem" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>25. BOLETIM SEMANAL DE DRAGAGEM</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $texto_boletim_semanal_dragagem; ?>
			</div>
		</div>
	</section>

	<section id="relatorioMensalDragagem" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>26. RELAT??RIO MENSAL DE DRAGAGEM</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $texto_relatorio_mensal_dragagem; ?>
			</div>
		</div>
	</section>

	<section id="relatorioLevantamentoHidrografico" class="sheet padding-10mm">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
				<h3>
					<strong>27. RELAT??RIO DE LEVANTAMENTO HIDROGR??FICO</strong>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify"
				 style='font:11px/21px Arial,tahoma,sans-serif;color:black'>
				<?= $texto_relatorio_levantamento_hidrografico; ?>
			</div>
		</div>
	</section>

	<!-- 11. GEST??O DA QUALIDADE -->
	<!--             <section id="gestao_qualidade" class="sheet padding-10mm">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>11. GEST??O DA QUALIDADE</strong>
</h3>
</div>
</div> -->
	<!-- 11.1 ENSAIOS DE LABORAT??RIO DA CONSTRUTORA -->
	<!--                 <div class="row" id="ensaio_laboratorio_construtora">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>11.1 ENSAIOS DE LABORAT??RIO DA CONSTRUTORA</strong>
</h3>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify" style ='font:11px/21px Arial,tahoma,sans-serif;color:black'>
<div class="alert alert-danger" role="alert">[11.1 ENSAIOS DE LABORAT??RIO DA CONSTRUTORA] n??o cadastrado!</div>
</div>
</div>   -->
	<!-- 11.2 ENSAIOS DE LABORAT??RIO DA SUPERVISORA -->
	<!--                 <div class="row" id="ensaio_laboratorio_supervisora">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>11.2 ENSAIOS DE LABORAT??RIO DA SUPERVISORA</strong>
</h3>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify" style ='font:11px/21px Arial,tahoma,sans-serif;color:black'>
<div class="alert alert-danger" role="alert">[11.2 ENSAIOS DE LABORAT??RIO DA SUPERVISORA] n??o cadastrado!</div>
</div>
</div>
-->
	<!-- 11.3 PLANO DE VERIFICA????O DA EFETIVIDADE DA GEST??O DA QUALIDADE (PVEGQ) -->
	<!--                <div class="row" id="gestao_pvegq">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>11.3 PLANO DE VERIFICA????O DA EFETIVIDADE DA GEST??O DA QUALIDADE (PVEGQ)</strong>
</h3>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify" style ='font:11px/21px Arial,tahoma,sans-serif;color:black'>
<div class="alert alert-danger" role="alert">[11.3 PLANO DE VERIFICA????O DA EFETIVIDADE DA GEST??O DA QUALIDADE (PVEGQ)] n??o cadastrado!</div>
</div>
</div> -->
	<!-- 11.4 REGISTROS DE N??O CONFORMIDADES ??? RNC -->
	<!--                 <div class="row" id="gestao_rnc">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>11.4 REGISTROS DE N??O CONFORMIDADES ??? RNC</strong>
</h3>
</div>
</div>
<div class="table-responsive">
<table class="tabela bordaCompleta" style="width: 100%;">
<tbody>
 <tr class="center">
<div class="alert alert-danger" role="alert">[11.4 REGISTROS DE N??O CONFORMIDADES ??? RNC] n??o cadastrado!</div>
</tr>
</tbody>
</table>
</div>
</section> -->
	<!-- 12. GEST??O JUR??DICA, GARANTIAS E SEGUROS -->
	<!--             <section id="gestao_juridica_garantias_seguros" class="sheet padding-10mm">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>12. GEST??O JUR??DICA, GARANTIAS E SEGUROS</strong>
</h3>
</div>
</div>
<div class="table-responsive">
<table class="tabela bordaCompleta" style="width: 100%;">
<tbody>
<tr class="center">
<div class="alert alert-danger" role="alert">[12. GEST??O JUR??DICA, GARANTIAS E SEGUROS] n??o cadastrado!</div>
</tr>
</tbody>
</table>
</div>
</section> -->
	<!-- 13. GEST??O DE RISCOS E INTERFER??NCIAS -->
	<!--             <section id="riscos_interferencias" class="sheet padding-10mm">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>13. GEST??O DE RISCOS E INTERFER??NCIAS</strong>
</h3>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
<table class="tabela bordaCompleta" style="width: 100%">
<tbody>
        <tr class="center">
<div class="alert alert-danger" role="alert">[13. GEST??O DE RISCOS E INTERFER??NCIAS] n??o cadastrado!</div>
</tr>
</tbody>
</table>
</div>
</div>
</section>
-->
	<!-- 14. ATAS E CORRESPOND??NCIAS -->
	<!--             <section id="atas_correspondencias" class="sheet padding-10mm">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>14. ATAS E CORRESPOND??NCIAS</strong>
</h3>
</div>
</div>
<div class="table-responsive">
<table class="tabela bordaCompleta" style="width: 100%;">
<tbody>
<tr class="center">
<div class="alert alert-danger" role="alert">[14. ATAS E CORRESPOND??NCIAS] n??o cadastrado!</div>
</tr>
</tbody>
</table>
</div>
</section>
-->
	<!-- 15. GEST??O DE TRATATIVAS -->
	<!--             <section id="gestao_tratativas" class="sheet padding-10mm">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>15. GEST??O DE TRATATIVAS</strong>
</h3>
</div>
</div>
<div class="table-responsive">
<table class="tabela bordaCompleta" style="width: 100%;">
<tbody>
<tr class="center">
<div class="alert alert-danger" role="alert">[15. GEST??O DE TRATATIVAS] n??o cadastrado!</div>
</tr>
</tbody>
</table>
</div>
</section> -->
	<!-- 16. CONCLUS??O E COMENT??RIOS -->
	<!--             <section id="conclusao_comentarios" class="sheet padding-10mm">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">
<h3>
<strong>16. CONCLUS??O E COMENT??RIOS</strong>
</h3>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify" style ='font:11px/21px Arial,tahoma,sans-serif;color:black'>
<div class="alert alert-danger" role="alert">[16. CONCLUS??O E COMENT??RIOS] n??o cadastrado!</div>
</div>
</div>
</section> -->
	</body>
</section>
