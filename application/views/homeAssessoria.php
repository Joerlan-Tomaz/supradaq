<style>
    .btn-pushmenu{
        display: none !important;
    } 
    .divisao{
        width: 49% !important;
    }
    @media (max-width: 767px){
        .divisao{
            width: 100% !important;
        }
    } 
</style>
<link rel="stylesheet" type="text/css" href="<?php echo (base_url('assets/css/defaultHome.css')) ?>" />
<div class="main">
    <ul class="cbp-ig-grid" style="min-height: 600px;">
        <li class="divisao">
            <a href="javascript:void(0);" onclick="rota_Dispeo()">	
                <span class="cbp-ig-icon cbp-ig-icon-ico_coin"></span>
                <h3 class="cbp-ig-title">Orçamento</h3>
                <span class="cbp-ig-category"></span>
            </a>
        </li>

        
        <li class="divisao">
            <a href="javascript:void(0);" onclick="rotaSalaSituacaoAce()">	
                <span class="cbp-ig-icon cbp-ig-icon-ico_sala_situacao"></span>
                <h3 class="cbp-ig-title">Sala de Situação - ACE</h3>
                <span class="cbp-ig-category"></span>
            </a>
        </li>


                
        <?php

        if (!empty($this->session->id_organizador)) {?>
            <!-- <li class="divisao">
                <a  href="<= base_url('homeDir/HomeDir/homeOrganizadorProcessos') ?>">
                    <span class='fa fa-cubes org-processo cbp-ig-icon-ico_organizador_processos'></span>
                    <h3 class="cbp-ig-title">Organizador de Processos</h3>
                    <span class="cbp-ig-category"></span>
                </a>
            </li> -->
            <li class="divisao">
                <a href="<?= base_url('assessoria_org/gestao-medicoes') ?>">
                    <span class="org-processo cbp-ig-icon" style="padding: 0px;">
                        <!-- <img class="img" style="width: 150px;" src="/supra/assets/img/icones/icone_gestaoMedicoes.png"> -->
                        <img class="img" style="width: 150px;" src="<?php echo (base_url('assets/img/icones/icone_gestaoMedicoes.png')) ?>" >
                    </span>
                    <h3 class="cbp-ig-title" style="padding: 10px 0;">SIAMED</h3>
                    <span class="cbp-ig-category"></span>
                </a>
            </li>

        <?php 
        } ?>

        <?php 
            if ($this->session->id_gestao_demandas) { 
        ?>

            <li class="divisao">
                <a href="javascript:void(0);" onclick="rotaGestaoDemandas()">	
                    <span class='cbp-ig-icon cbp-ig-icon-ico_gestao_demanda'></span>
                    <h3 class="cbp-ig-title">Gestão de Demandas</h3>
                    <span class="cbp-ig-category"></span>
                </a>
            </li>

        <?php 
        } ?>

    </ul> 
</div>
<footer>
    <p class="text-right">
        <img src="<?php echo (base_url('assets/img/logos_dnit_branco_.png')) ?>"  width="23%">
    </p>
</footer>