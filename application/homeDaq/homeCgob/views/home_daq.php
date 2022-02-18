<script src="<?php echo(base_url("application/homeDaq/homeCgob/assets/js/home/home.js")) ?>"></script>
<style>
    .btn-pushmenu{
        display: none !important;
    } 

</style>

<?php
    
    /*************** MONTAGEM DINÂMICA DA TELA ******************/
    
    //$moduloAssessoria = "Assessoria";
    $moduloConstrucao = "Obras";
    //$moduloManutencao = "Manutenção";
    $moduloOperacoes = "Operações";

    $listaModulos = array
            (
                //$moduloAssessoria => array("", "ASSESSORIA - Em desenvolvimento...", "assets/plugins/blocs/img/2.jpg"),
                $moduloConstrucao => array("rota_Cgob()", "CGOB", "application/homeDaq/homeCgob/assets/plugins/blocs/img/Obras.jpg"),
                //$moduloManutencao => array("", "MANUTENÇÃO - Em desenvolvimento...", "application/homeDaq/assets/plugins/blocs/img/1.jpg"),
                $moduloOperacoes => array("rota_Cgop()", "CGOP", "application/homeDaq/homeCgob/assets/plugins/blocs/img/Operacoes.jpg"),
            );

    /*************** PERFIS QUE POSSUEM RESTRIÇÕES DE VISUALIZAÇÃO DOS BOTÕES  ******************/
    
    $qntPerfisCOORDENACOES = (!empty($this->session->id_perfil)) + (!empty($this->session->id_perfil_cgmrr)) + (!empty($this->session->id_perfil_cgpert));
    $restricaoPadrao = true;
    
    if($this->session->id_perfil == 15 || $this->session->id_perfil == 1)
    {
        $restricaoPadrao = false;
    }
    
    if($restricaoPadrao)
    {
        // CGCONT 5: Fiscal 
        // CGCONT 6: Fiscal substituto
        // CGCONT 7: Responsável Supervisora
        // CGCONT 8: Analista Supervisora
        // CGMRR 47: Fiscal Externo - Superintendência e Contratado
        // CGMRR 48: Responsável Supervisora 
        // CGPERT 29 até 37 e 39: Usuários CGPERT
        $listaRestricoes = array( 
                   // $moduloAssessoria => array(5, 6, 7, 8, 47, 48),
                   // $moduloOperacoes => array(5, 6, 7, 8, 47, 48)
            );
    }
    else
    {
        $listaRestricoes = array( 
            );
    }
?>
<?php 
if ($Codigo == 0) { 
    ?>
    <?php if ($CodigoAviso == 1) { ?>
        <script>
            $.notify('<?php echo $MensagemAviso ?>', "warning");
        </script>
    <?php } ?>
    <!-- <div class="zoom">
        <a class="zoom-fab zoom-btn-large" id="zoomBtn">IMR</a>
        <ul class="zoom-menu">
                <li data-toggle="tooltip" data-placement="bottom" title="Início"><a href="javascript:void(0);" onclick="rotaImr()" class="zoom-fab zoom-btn-sm zoom-btn-supra scale-transition scale-out"><i class="fa fa-home"></i></a></li>
            <?php if (($IdPerfil != 5 and $IdPerfil != 6 and $IdPerfil != 9 and $IdPerfil != 3 and $IdPerfil != 8 and $IdPerfil != 7 and $IdPerfil != 2 and $IdPerfil != 14 and $IdPerfil != 54) and ( $IdPerfil == 1 or $IdPerfil == 15 or $IdPerfil == 38 or $IdPerfil == 55 or $IdPerfil == 56 )) { ?>
                <li data-toggle="tooltip" data-placement="bottom" title="Relatório"><a href="javascript:void(0);" onclick="rotaRelatorio()" class="zoom-fab zoom-btn-sm zoom-btn-supra scale-transition scale-out"><i class="fa fa-file"></i></a></li>
            <?php } ?>
            <?php if (($IdPerfil != 5 and $IdPerfil != 6 and $IdPerfil != 9 and $IdPerfil != 3 and $IdPerfil != 8 and $IdPerfil != 7 and $IdPerfil != 2 and $IdPerfil != 14 and $IdPerfil != 54) and ( $IdPerfil == 1 or $IdPerfil == 15 or $IdPerfil == 38 or $IdPerfil == 55 or $IdPerfil == 56 )) { ?>
                <li data-toggle="tooltip" data-placement="bottom" title="Análise"><a href="javascript:void(0);" onclick="" class="zoom-fab zoom-btn-sm zoom-btn-supra scale-transition scale-out"><i class="fa fa-search"></i></a></li>
            <?php } ?>
            <?php if ($IdPerfil != 9 and $IdPerfil != 8 and $IdPerfil != 7 and $IdPerfil != 2 and $IdPerfil != 14 and $IdPerfil != 52) { ?>
                <li data-toggle="tooltip" data-placement="bottom" title="Administrativo"><a href="javascript:void(0);" onclick="" class="zoom-fab zoom-btn-sm zoom-btn-supra scale-transition scale-out"><i class="fa fa-cogs"></i></a></li>
            <?php } ?>
            <?php if ($IdPerfil != 9 and $IdPerfil != 8 and $IdPerfil != 7 and $IdPerfil != 2 and $IdPerfil != 14 and $IdPerfil != 52) { ?>
                <li data-toggle="tooltip" data-placement="bottom" title="Impressão"><a href="javascript:void(0);" onclick="" class="zoom-fab zoom-btn-sm zoom-btn-supra scale-transition scale-out"><i class="fa fa-print"></i></a></li>
            <?php } ?>
        </ul>
    </div> -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url('assets/css/defaultHome.css')) ?>" />
    <div class="grid">	
        <?php 
            foreach($listaModulos as $key => $item)
            {
                $restricao = false;
                foreach($listaRestricoes as $keyRestricoes => $itemRestricoes)
                {
                    if($key == $keyRestricoes)
                    {
                        foreach($itemRestricoes as $itemIdPerfil)
                        {
                            if($itemIdPerfil == $this->session->id_perfil || $itemIdPerfil == $this->session->id_perfil_cgmrr)
                            {
                                $restricao = true;
                                if($key == 'Operações')
                                {
                                    if(!empty($this->session->id_perfil_cgpert) && 
                                      $this->session->id_perfil_cgpert >= 29 && $this->session->id_perfil_cgpert <= 39)
                                    {
                                        $restricao = false;
                                    }
                                }
                                break;
                            }
                        }
                        
                    }
                }
                if($restricao)
                    continue;

                // $link = '<a href="javascript:void(0);" onclick="'.$item[0].'">Veja mais</a>';
                // $classe = '';
                // if($key == 'Operações'){
                //     $classe = 'disabled';
                //     $link = '<a href="#" style="cursor: default;">Veja mais</a>';
                // }
                
        ?>
        <figure class="effect-lily">
            <img src="<?php echo (base_url($item[2])) ?>" alt=""/>
            <figcaption>
                <div class="grid-topic">
                    <h2><span><?= $key ?></span></h2>
                    <p><?= $item[1]?></p>
                </div>
                <a href="javascript:void(0);" onclick="<?= $item[0] ?>">Veja mais</a>
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
    <div class="modal fade" id="alteteraSenhaPrimeiroLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>                        
                </div>           
                <div class="modal-body">
                    <form method="post" name="formNovaSenhaPrimeiroLogin" id="formNovaSenhaPrimeiroLogin">                
                        <div class=" col-md-12">
                            <label>Atual</label>
                            <input type="password" class="form-control" name="edtAtual" id="edtAtual" placeholder="Senha atual">
                        </div>
                        <div class=" col-md-12">
                            <label>Nova</label>
                            <input type="password" class="form-control" name="edtNova" id="edtNova" placeholder="Nova senha">
                        </div>
                        <div class=" col-md-12">
                            <label>Confirmar</label>
                            <input type="password" class="form-control" name="edtConfirmar" id="edtConfirmar" placeholder="Confirmar senha">
                        </div>                            
                        <div class=" col-md-12">
                            <label></label>
                            <button type="button" name="btnAlterarsenhaPrimeiroLogin" class="btn btn-block btn-warning " onClick="alterarSenhaPrimeiroLogin()">
                                <i class="fa fa-key" aria-hidden="true"></i> Alterar Senha
                            </button>
                        </div> 
                    </form>                            
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- float-action-button -->
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/plugins/floating-action-button/src/js/index.js')) ?>"></script>
<footer>
    <p class="text-right">
        <img src="<?php echo (base_url('application/homeDaq/homeCgob/assets/img/logos_dnit_branco_.png')) ?>"  width="23%">
    </p>
</footer>
