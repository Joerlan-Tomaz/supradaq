<!-- evita cache js -->
<meta http-equiv="cache-control" content="max-age=0"/>
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="expires" content="0"/>
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/>
<meta http-equiv="pragma" content="no-cache"/>
<!-- evita cache js -->
<!--INFORMACOES CONTRATO-->
<script>
	// //----------------------------------------------- ROTAS --------------------------------------------------------
	function rotaSupervisaoDaq() {
		$("#exibe").empty();
		$("#exibe").load("HomeSupervisaoDaq").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotaRelatorioSupervisaoDaq() {
		$("#exibe").empty();
		$("#exibe").load("HomeRelatorioDaq").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotaDocumentacaoDaq() {
		$("#exibe").empty();
		$("#exibe").load("HomeDocumentacaoDaq").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotahomePainelAdm() {
		$("#exibe").empty();
		$("#exibe").load("HomePainelDaq").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotahomePainelGerencial() {
		$("#exibe").empty();
		$("#exibe").load("homePainelGerencial").slideUp(3).delay(3).fadeIn("slow");
	}
	// //----------------------------------------------- DIF --------------------------------------------------------
	function rotaSupervisaoAnaliseDif() {
		$("#exibe").empty();
		$("#exibe").load("DifAnaliseSupervisao").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotaPainelGerencialDif() {
		$("#exibe").empty();
		$("#exibe").load("homePainelGerencialDif").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotaHomeObra() {
		$("#exibesupervisaocont").load("Home/homeInfoContratoDif").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotahomePainelAdmDif() {
		$("#exibe").empty();
		$("#exibe").load("DifPainelAdmDif").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotaConfiguracaoObraDif(){
		$("#exibesupervisaocont").empty();
		$('#exibesupervisaocont').load("Home/homeConfiguracaoObraDif").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotaDocumentacaoDif(){
		$("#exibesupervisaocont").empty();
		$("#exibesupervisaocont").load("DifDocumentacao").slideUp(3).delay(3).fadeIn("slow");
	}
	function rotaSupervisaoDif() {
		$("#exibe").empty();
		$("#exibe").load("KjUi-AvSdCLKuWPZpTjyRvPksBd5cHiDeDSurAy04ps").slideUp(3).delay(3).fadeIn("slow");
	}
</script>


<div id="exibe">
	<style>
		.btn-pushmenu {
			display: none !important;
		}
	</style>

	<link rel="stylesheet" type="text/css" href="<?php echo(base_url('assets/css/default.css')) ?>"/>
	<div class="main">
		<?php if(count($this->session->permissao_telas_daq ) > 0){ ?>
			<ul class="cbp-ig-grid" style="min-height: 600px;">
			<?php foreach($this->session->permissao_telas_daq as $acesso){
				if($acesso->tela == 'Menu Administrativo' && $acesso->supervisao == 'DAQ'){ ?>
					<li id="rotahomePainelAdm">
						<a href="javascript:void(0);" onclick="rotahomePainelAdm()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_configuracoes"></span>
							<h3 class="cbp-ig-title">Administrativo</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Relatório de Supervisão' && $acesso->supervisao == 'DAQ'){ ?>
					<li id="rotaSupervisaoDaq">
						<a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_doc4"></span>
							<h3 class="cbp-ig-title">Relatórios de Supervisão</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Painéis Gerenciais' && $acesso->supervisao == 'DAQ'){ ?>
					<li id="rotahomePainelGerencial">
						<a href="javascript:void(0);" onclick="rotahomePainelGerencial()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_rel_digitais"></span>
							<h3 class="cbp-ig-title">Painéis Gerenciais</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Análise de Relatório' && $acesso->supervisao == 'DAQ'){ ?>
					<li id="rotaRelatorioSupervisaoDaq">
						<a href="javascript:void(0);" onclick="rotaRelatorioSupervisaoDaq()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_doc3"></span>
							<h3 class="cbp-ig-title">Análise de Relatório</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Documentação' && $acesso->supervisao == 'DAQ'){ ?>
					<li id="rotaDocumentacaoDaq">
						<a href="javascript:void(0);" onclick="rotaDocumentacaoDaq()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_doc2"></span>
							<h3 class="cbp-ig-title">Documentação</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php } } ?>
			</ul>v
		<?php }  ?>
<!--			// =========================================== DIF =========================================-->
<!--			// =========================================== DIF =========================================-->
<!--			// =========================================== DIF =========================================-->
		<?php if(count($this->session->permissao_telas_dif ) > 0){ ?>
			<ul class="cbp-ig-grid" style="min-height: 600px;">
			<?php foreach($this->session->permissao_telas_dif as $acesso){
				if($acesso->tela == 'Menu Administrativo' && $acesso->supervisao == 'DIF'){ ?>
					<li>
						<a href="javascript:void(0);" onclick="rotahomePainelAdmDif()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_configuracoes"></span>
							<h3 class="cbp-ig-title">Administrativo</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Relatório de Supervisão' && $acesso->supervisao == 'DIF'){ ?>
					<li>
						<a href="javascript:void(0);" onclick="rotaSupervisaoDif()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_doc4"></span>
							<h3 class="cbp-ig-title">Relatórios de Supervisão</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Painéis Gerenciais' && $acesso->supervisao == 'DIF'){ ?>
					<li>
						<a  href="javascript:void(0);" onclick="rotaPainelGerencialDif()" >
							<span class="cbp-ig-icon cbp-ig-icon-ico_rel_digitais"></span>
							<h3 class="cbp-ig-title">Painéis Gerenciais</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Análise de Relatório' && $acesso->supervisao == 'DIF'){ ?>
					<li>
						<a href="javascript:void(0);" onclick="rotaSupervisaoAnaliseDif()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_doc3"></span>
							<h3 class="cbp-ig-title">Análise de Relatório</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php }
				if($acesso->tela == 'Menu Documentação' && $acesso->supervisao == 'DIF'){ ?>
					<li>
						<a href="javascript:void(0);" onclick="rotaDocumentacaoDif()">
							<span class="cbp-ig-icon cbp-ig-icon-ico_doc2"></span>
							<h3 class="cbp-ig-title">Documentação</h3>
							<span class="cbp-ig-category"></span>
						</a>
					</li>
				<?php } }?>
			</ul>
		<?php }?>
	</div>
	<footer>
		<p class="text-right">
			<img src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/logos_dnit_cinza_semfundo.png')) ?>" width="20%"/>
		</p>
	</footer>

