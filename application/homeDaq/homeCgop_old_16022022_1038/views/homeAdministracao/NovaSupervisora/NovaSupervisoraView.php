<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo(base_url('assets/js/homeDaq/homeCgop/administracao/novasupervisora/novasupervisora.js')) ?>" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $('input').keypress(function (e) {
            var code = null;
            code = (e.keyCode ? e.keyCode : e.which);                
            return (code == 13) ? false : true;
        });
    });
</script>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nova Supervisora</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
                        <li class="breadcrumb-item active">Nova Supervisora</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formNovaSupervisora" id="formNovaSupervisora">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" id="nome_novaSupervisora" name="nome_novaSupervisora">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>&nbsp;</label><br>
                                    <button type="button" class="btn btn-primary" onclick="insereNovasupervisora()">Inserir Supervisora</button>
                                </div>
                            </div>
                        </div>                  
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <table id="table_supervisora" class="table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="table_supervisora">
                                <thead>
                                    <tr role="row">
                                        <th style="width: 5%">#</th>
                                        <th style="width: 60%">Nome</th>
                                        <th style="width: 20%">Data da Criação</th>
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
