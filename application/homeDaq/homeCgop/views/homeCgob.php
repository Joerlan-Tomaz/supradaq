<!-- evita cache js -->
<meta http-equiv="cache-control" content="max-age=0"/>
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="expires" content="0"/>
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/>
<meta http-equiv="pragma" content="no-cache"/>
<!-- evita cache js -->
<!--INFORMACOES CONTRATO-->
<script src="<?php echo(base_url("application/homeDaq/homeCgop/assets/js/supervisaodaq/supervisaodaq.js")) ?>"></script>


<div id="exibe">
	<style>
		.btn-pushmenu {
			display: none !important;
		}
	</style>

	<link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/css/defaultHome.css')) ?>"/>

	<div class="main">
		<ul class="cbp-ig-grid" style="min-height: 600px;">
			<?php
			foreach($permissao_telas as $acesso){
			if($acesso->tela == 'Menu Administrativo'){ ?>
				<li id="rotahomePainelAdm">
					<a href="javascript:void(0);" onclick="rotahomePainelAdm()">
						<span class="cbp-ig-icon cbp-ig-icon-ico_configuracoes"></span>
						<h3 class="cbp-ig-title">Administrativo</h3>
						<span class="cbp-ig-category"></span>
					</a>
				</li>
			<?php }
			if($acesso->tela == 'Menu Relatório de Supervisão'){ ?>
				<li id="rotaSupervisaoDaq">
					<a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">
						<span class="cbp-ig-icon cbp-ig-icon-ico_doc4"></span>
						<h3 class="cbp-ig-title">Relatórios de Supervisão</h3>
						<span class="cbp-ig-category"></span>
					</a>
				</li>
			<?php }
			if($acesso->tela == 'Menu Painéis Gerenciais'){ ?>
			<li id="rotahomePainelGerencial">
				<a href="javascript:void(0);" onclick="rotahomePainelGerencial()">
					<span class="cbp-ig-icon cbp-ig-icon-ico_rel_digitais"></span>
					<h3 class="cbp-ig-title">Painéis Gerenciais</h3>
					<span class="cbp-ig-category"></span>
				</a>
			</li>
			<?php }
			if($acesso->tela == 'Menu Análise de Relatório'){ ?>
			<li id="rotaRelatorioSupervisaoDaq">
				<a href="javascript:void(0);" onclick="rotaRelatorioSupervisaoDaq()">
					<span class="cbp-ig-icon cbp-ig-icon-ico_doc3"></span>
					<h3 class="cbp-ig-title">Análise de Relatório</h3>
					<span class="cbp-ig-category"></span>
				</a>
			</li>
			<?php }
			if($acesso->tela == 'Menu Documenteção'){ ?>
			<li id="rotaDocumentacaoDaq">
				<a href="javascript:void(0);" onclick="rotaDocumentacaoDaq()">
					<span class="cbp-ig-icon cbp-ig-icon-ico_doc2"></span>
					<h3 class="cbp-ig-title">Documentação</h3>
					<span class="cbp-ig-category"></span>
				</a>
			</li>
			<?php } }?>
		</ul>
	</div>
	<footer>
		<p class="text-right">
			<img src="<?php echo(base_url('assets/img/logos_dnit_branco_.png')) ?>" width="20%"/>
		</p>
	</footer>

