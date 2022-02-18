<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/rotas.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/solicitaoacesso/solicitacaoacessoView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/atualizarperfilpermissoes/atualizarperfilpermissoesView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/novasupervisora/novasupervisoraView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/relacionargrupocontrato/relacionargrupocontratoView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/relarionausuariocontrato/relarionausuariocontratoView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/resetarbloquearsenha/resetarbloquearsenhaView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/alterausuario/alterausuarioView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/usuariosonline/usuariosonlineView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/codsicro/codsicroView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/mapasituacao/mapaSituacaoView.js')) ?>"></script>
<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/cgplan/cgplanView.js')) ?>"></script>

<script src="<?php echo (base_url('application/homeDaq/homeCgob/assets/js/administracao/telas/telas.js')) ?>"></script>
<script> var base_url = "<?php echo base_url(); ?>"</script>
<div>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <!-- Sidebar -->
        <div class="sidebar" style="font-size: 14px;">
            <br>
            <!-- Sidebar Menu -->
            <nav class="mt-2" id="menuRelatorioSupervisao">
                <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaSolicitaAcesso()" class="nav-link">
                            <i class="nav-icon fa fa-user-plus"></i>
                            <p>Solicitação de Acesso</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaAtualizaPerilPermissoes()" class="nav-link" style="font-size: 11px;">
                            <i class="nav-icon fa fa-refresh"></i>
                            <p>Atualizar Supervisora, Perfil e Permissões</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaNovaSupervisora()" class="nav-link">
                            <i class="nav-icon fa fa-plus"></i>
                            <p>Nova Supervisora</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaRelacionarGrupoContrato()" class="nav-link" style="font-size: 13px;">
                            <i class="nav-icon fa fa-copy"></i>
                            <p>Relacionar Grupo de Contratos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaRelacaoContratoUsuario()" class="nav-link">
                            <i class="nav-icon fa fa-user-cog"></i>
                            <p>Relacionar Contrato ao Usuário</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaResetarSenha()" class="nav-link">
                            <i class="nav-icon fa fa-user-lock"></i>
                            <p>Resetar / Bloquear Senha</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaAlteraUsuario()" class="nav-link">
                            <i class="nav-icon fa fa-address-book"></i>
                            <p>Dados de usuário</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaUsuariosOnline()"  class="nav-link">
                            <i class="nav-icon fa fa-plug"></i>
                            <p>Usuários Onlines</p>
                        </a>
                    </li>
                    <?php if ($this->session->id_perfil == 1) { ?>
                       <!-- <li class="nav-item sidebar-dropdown">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-desktop"></i>
                                <p>
                                    Telas
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview sidebar-submenu">
                                <li class="nav-item">
                                    <a href="javascript:void(0);" onclick="modalCoordenacao()"  class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Cadastrar Coordenação</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" onclick="modalModulo()"  class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Cadastrar Módulo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" onclick="modalSistema()"  class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Cadastrar Sistema</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" onclick="modalTela()"  class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>Cadastrar Telas</p>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                    <?php } ?>
                    <li class="nav-item sidebar-dropdown">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-download"></i>
                            <p>
                                Download Geo
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview sidebar-submenu">
                            <li class="nav-item">
                                <a href="<?php echo base_url("homeCgcont/Administracao/Georreferenciamento") ?>" download="" class="nav-link">
                                    <i class="nav-icon fa fa-map-marker"></i>
                                    <p>Georreferenciamento</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url("homeCgcont/Administracao/PontoPassagem") ?>" download=""  class="nav-link">
                                    <i class="nav-icon fa fa-map-marker"></i>
                                    <p>Ponto de Passagem</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url("homeCgcont/Administracao/OAE") ?>" download=""  class="nav-link">
                                    <i class="nav-icon fa fa-map-marker"></i>
                                    <p>OAE</p>
                                </a>
                            </li>
                        </ul>
                    </li>
               <!--     <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaCodSicro()"  class="nav-link">
                            <i class="nav-icon fa fa-barcode"></i>
                            <p>Cod-Sicro</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaMapaSituacaoAdm()"  class="nav-link">
                            <i class="nav-icon fa  fa-map-o"></i>
                            <p>Mapa de Situaçao</p>
                        </a>
                    </li>
                    
                     <li class="nav-item">
                        <a href="javascript:void(0);" onclick="rotaCgplan()"  class="nav-link">
                            <i class="nav-icon fas  fa-list"></i>
                            <p>CGPLAN</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</div>

<div>
    <div style="min-height: 916px;">
        <div class="content-wrapper" id="solicitacaoAcesso" style="display: none">
            <?php include("Solititaacesso/solititaAcessoView.php"); ?>
        </div>
        <div class="content-wrapper" id="atualizaPerfilPermissao" style="display: none">
            <?php include("Atualizaatualizaperfilpermissao/atualizaAtualizaPerfilPermissaoView.php"); ?>
        </div>
        <div class="content-wrapper" id="novaSupervisora" style="display: none">
            <?php include("Novasupervisora/novaSupervisoraView.php"); ?>
        </div>
        <div class="content-wrapper" id="relacionarGrupoContrato" style="display: none">
            <?php include("Relacionargrupocontrato/relacionarGrupoContratoView.php"); ?>
        </div>
        <div class="content-wrapper" id="relacionaContratoUsuario" style="display: none">
            <?php include("Relacionausuariocontrato/relacionaUsuarioContratoView.php"); ?>
        </div>
        <div class="content-wrapper" id="resetarBloquearSenha" style="display: none">
            <?php include("Resetarbloquearsenha/resetarbloquearsenhaView.php"); ?>
        </div>
        <div class="content-wrapper" id="alteraUsuario" style="display: none">
            <?php include("Alterausuario/alterausuarioView.php"); ?>
        </div>
        <div class="content-wrapper" id="usuarioOnline" style="display: none">
            <?php include("Usuarioonline/usuarioOnlineView.php"); ?>
        </div>
        <div class="content-wrapper" id="codSicro" style="display: none">
            <?php include("Codsicro/codSicroView.php"); ?>
        </div>
        <div class="content-wrapper" id="mapaSituacao" style="display: none">
            <?php include("Mapasituacao/mapaSituacaoView.php"); ?>
        </div>
        <div class="content-wrapper" id="cgplan" style="display: none">
            <?php include("Cgplan/cgplanView.php"); ?>
        </div>
    </div>
</div>
<br>
<br>
<footer class="main-footer" style="margin-bottom: 0px;bottom: 0; position: fixed; width: 86%;">
    <div class="pull-right hidden-xs">
        <b>Versão</b> 2.0
    </div>
    <strong>SUPRA © 2016-<?php echo date("Y"); ?>. <a href="http://supra.dnit.gov.br/" target="_blank">DNIT - Departamento Nacional de Infraestrutura de Transportes</a>.</strong>
</footer>
<!-------------------------------->

<!-- MODAl ADMINISTRAÇÃO - COORDENAÇÃO --> 
<div class="modal fade" id="modalCoordenacao" tabindex="-1" role="dialog" aria-labelledby="disciplina" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 60% !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Coordenação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formCoordenacao" id="formCoordenacao">  
                    <div class="row">
                        <div class="col-md-4">
                            <label>Coordenação</label>
                            <input type="text" class="form-control" id="txtCoordenacao" name="txtCoordenacao">
                        </div>         
                        <div class="col-md-1" style="margin-top: 10px;">
                            <br>
                            <input type='button' onclick='insereCoordenacao()' value='Salvar' class="btn btn-primary btn-block">
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row"> 
                    <div class='col-md-12'>
                        <div class="table-responsive">
                            <table id="tableCoordenacao" class="table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr class="">
                                        <th style='width:93%'>Coordenação</th>
                                        <th style='width:7%'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAl ADMINISTRAÇÃO - MÓDULO --> 
<div class="modal fade" id="modalModulo" tabindex="-1" role="dialog" aria-labelledby="disciplina" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 60% !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formModulo" id="formModulo">  
                    <div class="row">
                        <div class="col-md-4">
                            <label>Coordenação</label>
                            <select class="form-control" id="slcCoordenacao_modulo" name="slcCoordenacao_modulo"></select>
                        </div>    
                        <div class="col-md-4">
                            <label>Módulo</label>
                            <input type="text" class="form-control" id="txtModulo" name="txtModulo" disabled>                            
                        </div>  
                        <div class="col-md-1" style="margin-top: 10px;">
                            <br>
                            <input type='button' onclick='insereModulo()' id="btnSalvarModulo" value='Salvar' class="btn btn-primary btn-block" disabled>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row"> 
                    <div class='col-md-12'>
                        <div class="table-responsive">
                            <table id="tableModulo" class="table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr class="">
                                        <th style='width:45%'>Coordenação</th>
                                        <th style='width:45%'>Módulo</th>
                                        <th style='width:7%'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAl ADMINISTRAÇÃO - MÓDULO --> 
<div class="modal fade" id="modalSistema" tabindex="-1" role="dialog" aria-labelledby="disciplina" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 60% !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Sistema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formSistema" id="formSistema">  
                    <div class="row">
                        <div class="col-md-3">
                            <label>Coordenação</label>
                            <select class="form-control" id="slcCoordenacao_sistema" name="slcCoordenacao_sistema"></select>
                        </div>    
                        <div class="col-md-3">
                            <label>Módulo</label>
                            <select class="form-control" id="slcModulo_sistema" name="slcModulo_sistema" disabled>
                                <option value=''>Selecione</option>
                            </select>                          
                        </div>
                        <div class="col-md-3">
                            <label>Sistema</label>
                            <input type="text" class="form-control" id="txtSistema" name="txtSistema" disabled>                            
                        </div>
                        <div class="col-md-1" style="margin-top: 10px;">
                            <br>
                            <input type='button' onclick='insereSistema()' id="btnSalvarSistema" value='Salvar' class="btn btn-primary btn-block" disabled>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row"> 
                    <div class='col-md-12'>
                        <div class="table-responsive">
                            <table id="tableSistema" class="table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr class="">
                                        <th style='width:20%'>Coordenação</th>
                                        <th style='width:30%'>Módulo</th>
                                        <th style='width:40%'>Sistema</th>
                                        <th style='width:7%'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAl ADMINISTRAÇÃO - TELA --> 
<div class="modal fade" id="modalTela" tabindex="-1" role="dialog" aria-labelledby="disciplina" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 60% !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Telas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formTela" id="formTela">  
                    <div class="row">
                        <div class="col-md-3">
                            <label>Coordenação</label>
                            <select class="form-control" id="slcCoordenacao_tela" name="slcCoordenacao_Tela"></select>
                        </div>    
                        <div class="col-md-3">
                            <label>Módulo</label>
                            <select class="form-control" id="slcModulo_tela" name="slcModulo_Tela" disabled>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Sistema</label>
                            <select class="form-control" id="slcSistema_tela" name="slcSistema_Tela" disabled>
                            </select>                         
                        </div>
                        <div class="col-md-3">
                            <label>Sistema</label>
                            <input type="text" class="form-control" id="txtTela" name="txtTela" disabled>                            
                        </div>
                        <div class="col-md-1" style="margin-top: 10px;">
                            <br>
                            <input type='button' onclick='insereTela()' id="btnSalvarTela" value='Salvar' class="btn btn-primary btn-block" disabled>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row"> 
                    <div class='col-md-12'>
                        <div class="table-responsive">
                            <table id="tableTela" class="table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr class="">
                                        <th style='width:10%'>Coordenação</th>
                                        <th style='width:10%'>Módulo</th>
                                        <th style='width:35%'>Sistema</th>
                                        <th style='width:35%'>Tela</th>
                                        <th style='width:7%'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ATUALIZA PERFIL E PERMISSÕES -->
<div class="modal fade" id="modalAtualizaPerfilPermissoes" tabindex="-1" role="dialog" aria-labelledby="configuracao" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Perfil e Permissões</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formAtualizaPerfil" id="formAtualizaPerfil">
                    <input type="hidden" id="id_usuario_PerfilPermissao" name="id_usuario_PerfilPermissao">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Perfil</label>
                                <select class="form-control" name="perfil_atualizaPerfil" id="perfil_atualizaPerfil">
                                </select>
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Supervisora</label>
                                <select class="form-control" name="supervisora_atualizaPerfil" id="supervisora_atualizaPerfil">
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fechar Relatório</label>
                                <select class="form-control" name="fechaRelatorio_atualizaPerfil" id="fechaRelatorio_atualizaPerfil">
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Retifica Relatório</label>
                                <select class="form-control" name="refiticaRelatorio_atualizaPerfil" id="refiticaRelatorio_atualizaPerfil">
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                        </div>  
                    </div>                  
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="alteraPerfilPermissao()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL RELACIONA CONTRATO SUPERVISORA -->
<div class="modal fade" id="modalRelacionaGrupoContrato" tabindex="-1" role="dialog" aria-labelledby="configuracao" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Relação de Contratos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formContratoSupervisora" id="formContratoSupervisora">
                    <div class="form-group">
                        <input type="hidden" id="id_supervisora_modal" name="id_supervisora_modal">
                        <label>Contratos</label>
                        <select class="form-control select2" multiple="multiple" data-placeholder="Selecione o Contrato"
                                id="contratos_modalContratoSupervisora" name="contratos_modalContratoSupervisora[]" style="width: 100%;">                            
                        </select>
                    </div>                  
                </form>
                <div class="col-md-12">
                    <table id="tblContratoGrupo" class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 15%">Contrato</th>
                                <th style="width: 40%">Construtora</th>
                                <th style="width: 40%">Supervisora</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>                               
                    </table>       
                </div>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="insereRelacaoContratoSupervisora()" id="insereRelacaoContratoSupervisora" name="insereRelacaoContratoSupervisora">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR USUARIO -->
<div class="modal fade" id="modalAlteraUsuario" tabindex="-1" role="dialog" aria-labelledby="configuracao" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloUsuario_modal">Nome Ususario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formAlteraUsuario" id="formAlteraUsuario">                        
                    <input type="hidden" id="id_usuario_modal" name="id_usuario_modal">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nomeUsuario_modal" name="nomeUsuario_modal">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" class="form-control" id="emailUsuario_modal" name="emailUsuario_modal">
                    </div>
                    <div class="form-group">
                        <label>CPF</label>
                        <input type="text" class="form-control" id="cpfUsuario_modal" name="cpfUsuario_modal">
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" class="form-control" id="telefonUsuario_modal" name="telefonUsuario_modal">
                    </div>
                    <div class="form-group">
                        <label>Empresa</label>
                        <input type="text" class="form-control" id="empresaUsuario_modal" name="empresaUsuario_modal">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="alterarDadosUsuario()">Salvar</button>
            </div>
        </div>
    </div>
</div>
