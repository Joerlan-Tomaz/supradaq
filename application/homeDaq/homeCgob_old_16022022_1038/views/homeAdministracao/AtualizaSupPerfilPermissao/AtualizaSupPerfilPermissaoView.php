<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/administracao/atualizaSupPerfilPermissao/atualizaSupPerfilPermissaoView.js')) ?>" type="text/javascript"></script>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vincular Perfil à Usuário</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item active">Vincular Perfil à Usuário</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <table id="table_altera_usuario" class="table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="table_altera_usuario">
                                <thead>
                                    <tr role="row">
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Perfil</th>
                                        <th>Supervisora</th>
                                        <th>Empresa</th>
                                        <th>Alterar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </section>
</div>


<div id="modal_motivacao_acesso" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Motivo de Solicitação</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <font id="descricao_motivacao_acesso"></font>
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
                        <div class="col-md-6" id="selectSupervisora">
                            <div class="form-group">
                                <label>Supervisora</label>
                                <select class="form-control" name="supervisora_atualizaPerfil" id="supervisora_atualizaPerfil">
                                </select>
                            </div>
                        </div>  
                        <div class="col-md-12" id="acessosPerfil">

                        </div>
						<div class="col-md-12" id="tabelaContratos">

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
