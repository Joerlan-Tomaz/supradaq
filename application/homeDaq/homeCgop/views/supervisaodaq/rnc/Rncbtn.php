<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DNIT | SUPRA</title>

	<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgop/assets/css/estilos.css')) ?>"/>
	<link rel="stylesheet" href="<?php echo(base_url('application/homeDaq/homeCgop/assets/css/print.css')) ?>"/>
	<link rel="stylesheet"
		  href="<?php echo(base_url('application/homeDaq/homeCgop/assets/bootstrap/css/bootstrap.min.css')) ?>"/>
	<!--jquery-------->
	<script type="text/javascript"
			src="<?php echo(base_url('application/homeDaq/homeCgop/assets/plugins/jQuery/jquery-1.12.4.min.js')) ?>"></script>
	<!--js------------>

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

</style>

<body style="background-color: white !important; ">
<div class="col-xs-12 col-sm-12 col-md-12 smallFont" style="padding: 10px;">
	<div class="col-xs-2 col-sm-2 col-md-2" style="margin-top: 16px;">
		<img src="<?php echo(base_url('assets/img/dnit2.png')) ?>">
	</div>
	<div class="col-xs-8 col-sm-8 col-md-8" style="line-height: 1em;">
		REPÚBLICA FEDERATIVA DO BRASIL<br>
		MINISTÉRIO DOS TRANSPORTES<br>
		DEPARTAMENTO NACIONAL DE INFRAESTRUTURA DOS TRANSPORTES<br>
		DIRETORIA DE INFRAESTRUTURA AQUÁVIARIA
	</div>
	<div class="col-xs-2 col-sm-2 col-md-2" style="margin-top: 15px;">Nº -</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 headerTabela fundoCinzaCabecalho" style=" color:white;">REGISTRO DE NÃO
	CONFORMIDADE
</div>
<div class="col-xs-12 col-sm-12 col-md-12 semPadding">
	<div class="col-xs-1 col-sm-1 col-md-1 headerTabelaVertical fundoCinzaCabecalho" style=" color:white;">
		Identificação
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 pull-right tamanho100-25"
		 style="padding: 10px; border-right: 1px solid #333;">
		<table class="col-xs-12 col-sm-12 col-md-12 tabela ">
			<?php foreach ($registronconformidadesrnc

			as $registronconformidadesrncanexo) {
			$CONTRATO = $registronconformidadesrncanexo->nu_con_formatado;
			$COORDENADA_LATITUDE = $registronconformidadesrncanexo->latitude;
			$COORDENADA_LONGITUDE = $registronconformidadesrncanexo->longitude;
			//        $DESC_NATUREZA = $registronconformidadesrncanexo->desc_tipo_obra;
			$DESC_GRAVIDADE = $registronconformidadesrncanexo->desc_gravidade;
			$DATA_REGISTRO = $registronconformidadesrncanexo->data_registro;
			$KM_RNC = $registronconformidadesrncanexo->km;
			$STATUS_REGISTRO = $registronconformidadesrncanexo->status;
			$PROBLEMA = $registronconformidadesrncanexo->descricao;
			$PROVIDENCIA = $registronconformidadesrncanexo->sugestao_providencia;
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
			<!--<tr>
				<td class="labelForm">Eixo:</td>
				<td colspan="4"></td>
			</tr>-->
                        <tr>
				<td class="labelForm">Infraestrutura:</td>
				<td colspan="4"><?= $DESC_TIPO_EIXO ?></td>
			</tr>
			<tr>
				<td class="labelForm">Grau:</td>
				<td colspan="3"><?= $DESC_GRAVIDADE ?></td>
			</tr>
		</table>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 headerTabela fundoCinzaCabecalho" style=" color:white;">Descrição da
	Ocorrência
</div>
<div class="col-xs-12 col-sm-12 col-md-12 semPadding" style="min-height: 100px; border-right: 1px solid #333;">
	<div class="col-xs-1 col-sm-1 col-md-1 headerTabelaVertical fundoCinzaCabecalho" style=" color:white;">Observações
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 pull-right headerTabela fundoCinzaCabecalho font12print tamanho100-25"
		 style="text-align: left; border-top: 0; border-left: 0; border-right: 0;color:white;">Problema Identificado
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 pull-right font12print tamanho100-25"
		 style="min-height: 140px; font:11px/21px Arial,tahoma,sans-serif;color:black">
		<?= $PROBLEMA ?>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 pull-right headerTabela font12print tamanho100-25 fundoCinzaCabecalho"
		 style=" color:white;text-align: left; border-top: 0; border-left: 0; border-right: 0; border-top: 1px solid black;">
		Providência
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 pull-right font12print tamanho100-25"
		 style="min-height: 140px; font:11px/21px Arial,tahoma,sans-serif;color:black">
		<?= $PROVIDENCIA ?>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 headerTabela fundoCinzaCabecalho" style=" color:white;">Documentação
	Fotográfica
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
	<div class="headerTabelaVertical fundoCinzaCabecalho" style=" color:white; border-top: 1px solid #333;">Fotos</div>
	<?php
	$j = 1;
	foreach ($registronconformidadesrncFoto as $registronconformidadesrncfotoanexo) { ?>
		<div class="col-xs-6 col-sm-6 col-md-6 semPadding" style=" left:9px;">
			<table class="tabela bordaCompleta" style="width: 100%">
				<thead class="fundoCinzaCabecalho">
				<tr class="center">
					<td colspan="3">FOTO <?= $j++ ?></td>
				</tr>
				<tr>
					<td colspan="2">Descrição:<?= $registronconformidadesrncfotoanexo->descricao ?></td>
					<td>Data:<?= $registronconformidadesrncfotoanexo->data_atualizacao ?></td>
				</tr>
				</thead>
				<tbody class="center">
				<tr>
					<td colspan="3"><img class="img-responsive"
										 src="<?php echo(base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $registronconformidadesrncfotoanexo->nome_arquivo)) ?>"
										 style="width: 100%; height: 360px;"></td>
				</tr>
				</tbody>
			</table>
		</div>
	<?php } ?>
</div>

<?php } ?>

</body>
