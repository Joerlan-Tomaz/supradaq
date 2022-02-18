<!-- evita cache js -->
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<!-- evita cache js -->

<script src="<?php echo(base_url("application/homeDaq/homeCgob/assets/js/paineladm/paineladm.js")) ?>" type="text/javascript"></script>
<style>
    .btnAndamento{
        position: fixed;
        top: 133px;
        left: 60px;
        z-index: 11;
    }

    .btnCircular{
        height: 55px;
        width: 40px;
        border-bottom-right-radius: 90px;
        border-top-right-radius: 90px;
    }

</style>

<div id="menu">
    <aside class="main-sidebar sidebar-dark-primary elevation-4">        
        <!-- Sidebar -->
        <div class="sidebar" style="font-size: 14px;">
            <!-- Sidebar Menu -->
            <nav class="mt-2" id="menuRelatorioSupervisao">
                <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <br>
                        <h4 align="center" style="color: white">Painel Administrativo</h4>
                        <hr>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaSolicitacaoAcesso()" class="nav-link">
                            <i class="nav-icon fa fa-user-plus" aria-hidden="true"></i>
                            <p>Solicitação de Acesso</p>
                        </a>
                    </li>
				<!--	<li class="nav-item">
						<a href="javascript:void(0);" onclick="rotaAtualizaPerfil()" class="nav-link">
							<i class="nav-icon nav-icon fa fa-refresh" aria-hidden="true"></i>
							<p style="font-size: 11px;">Configurar Acesso do Pefil</p>
						</a>
					</li>-->
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaAtualizaSupPerfilPermissao()" class="nav-link">
                            <i class="nav-icon nav-icon fa fa-refresh" aria-hidden="true"></i>
                            <p style="font-size: 11px;">Vincular Perfil à Usuário</p>
                        </a>
                    </li>
<!--                    <li class="nav-item">-->
<!--                        <a href="javascript:void(0);" onclick="rotaNovaSupervisora()" class="nav-link">-->
<!--                            <i class="nav-icon fa fa-plus" aria-hidden="true"></i>-->
<!--                            <p style="font-size: 11px;">Nova Supervisora</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="javascript:void(0);" onclick="rotaRelacionarGrupoContrato()" class="nav-link" style="font-size: 13px;">-->
<!--                            <i class="nav-icon fa fa-copy"></i>-->
<!--                            <p>Relacionar Grupo de Contratos</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="javascript:void(0);" onclick="rotaRelacaoContratoUsuario()" class="nav-link">-->
<!--                            <i class="nav-icon fa fa-user-cog"></i>-->
<!--                            <p>Relacionar Contrato ao Usuário</p>-->
<!--                        </a>-->
<!--                    </li>-->
                </ul>
            </nav>
        </div>
    </aside>
</div>
<div id="resultadosupervisao">
    <div id="exibesupervisaocont" style="min-height: 570px;"></div>
</div>
<br>
<br>
<br>
<br>
<footer class="main-footer" style="margin-bottom: 0px;bottom: 0; position: fixed; width: 86%;">
    <div class="pull-right hidden-xs">
        <b>Versão</b> 1.0
    </div>
    <strong>SUPRA © 2016-<?php echo date("Y"); ?>. <a href="http://supra.dnit.gov.br/" target="_blank">DNIT - Departamento Nacional de Infraestrutura de Transportes</a>.</strong>
</footer>
<!--modal contratos--> 
