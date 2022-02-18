<!--<style>

figure.effect-lily:hover div.grid-topic {
    background-color: #f4f6f9e8;
    color: black;
}

figure.effect-lily:hover div.grid-topic p{
        color: black;
}

</style>-->
<link rel="stylesheet" type="text/css" href="<?php echo(base_url('application/homeDaq/homeCgob/assets/css/default.css')) ?>"/>
<?php

$moduloConstrucaoDif = "Construção ";
$moduloConstrucaoDaq = "Construção";

$listaModulos = array
(
		$moduloConstrucaoDif => array("rotaDif()", "DIF", "application/homeDaq/homeCgob/assets/plugins/blocs/img/DIF.jpg"),
		$moduloConstrucaoDaq => array("rotaDaq()", "DAQ", "application/homeDaq/homeCgob/assets/plugins/blocs/img/DAQ.jpg"),
);

// CGCONT 5: Fiscal
// CGCONT 6: Fiscal substituto
// CGCONT 7: Responsável Supervisora
// CGCONT 8: Analista Supervisora
// CGMRR 47: Fiscal Externo - Superintendência e Contratado
// CGMRR 48: Responsável Supervisora
$listaRestricoes = array(
		$moduloConstrucaoDif => array(),
		$moduloConstrucaoDaq => array()
);
?>
<?php
if ($Codigo == 0) {
	?>
	<?php if ($CodigoAviso == 1) { ?>
		<script>
			$.notify('<?php echo $MensagemAviso ?>', "warning");
		</script>
	<?php } ?>
	<div class="grid">
		<?php
		foreach ($listaModulos as $key => $item) {
			$restricao = false;
			foreach ($listaRestricoes as $keyRestricoes => $itemRestricoes) {
				if ($key == $keyRestricoes) {
					foreach ($itemRestricoes as $itemIdPerfil) {
						if ($itemIdPerfil == $this->session->id_perfil || $itemIdPerfil == $this->session->id_perfil_cgmrr) {
							$restricao = true;
							break;
						}
					}

				}
			}
			if ($restricao)
				continue;

			?>
			<figure class="effect-lily">
				<img src="<?php echo(base_url($item[2])) ?>" alt=""/>
				<figcaption>
					<div class="grid-topic">
						<h1><span><?= $key ?></span></h1>
						<p>
						<h2><?= $item[1] ?></h2></p>
					</div>
					<a href="javascript:void(0);" onclick="<?= $item[0] ?>">View more</a>
				</figcaption>
			</figure>
			<?php
		}
		?>
	</div>
<?php } else { ?>
	<script>
		$.notify('<?php echo $MensagemAviso ?>', "warning");
	</script>
	<script>
		$("#alteteraSenhaPrimeiroLogin").modal();
	</script>
	<div class="modal fade" id="alteteraSenhaPrimeiroLogin" tabindex="-1" role="dialog"
		 aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form method="post" name="formNovaSenhaPrimeiroLogin" id="formNovaSenhaPrimeiroLogin">
						<div class=" col-md-12">
							<label>Atual</label>
							<input type="password" class="form-control" name="edtAtual" id="edtAtual"
								   placeholder="Senha atual">
						</div>
						<div class=" col-md-12">
							<label>Nova</label>
							<input type="password" class="form-control" name="edtNova" id="edtNova"
								   placeholder="Nova senha">
						</div>
						<div class=" col-md-12">
							<label>Confirmar</label>
							<input type="password" class="form-control" name="edtConfirmar" id="edtConfirmar"
								   placeholder="Confirmar senha">
						</div>
						<div class=" col-md-12">
							<label></label>
							<button type="button" name="btnAlterarsenhaPrimeiroLogin" class="btn btn-block btn-warning "
									onClick="alterarSenhaPrimeiroLogin()">
								<i class="fa fa-key" aria-hidden="true"></i> Alterar Senha
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<style>

	.text-right {
		text-align: right !important;
	}

	p {
		margin-top: 0;
		margin-bottom: 1rem;
	}
</style>
<footer style="position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px;">
	<p class="text-right">
		<img src="<?php echo(base_url('application/homeDaq/homeCgob/assets/img/logos_dnit_cinza_semfundo.png')) ?>" width="20%">
	</p>
</footer>
