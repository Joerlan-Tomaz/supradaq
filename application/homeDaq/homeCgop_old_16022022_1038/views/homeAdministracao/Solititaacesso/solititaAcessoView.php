<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/administracao/solicitaoacesso/solicitacaoacessoView.js')) ?>" type="text/javascript"></script>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Soliticação de Acesso</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
                        <li class="breadcrumb-item active">Solicitação de Acesso</li>
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
                            <table id="table_solicitacao_acesso" class="table dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="table_solicitacao_acesso">
                                <thead>
                                    <tr role="row">
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Empresa</th>
                                        <th>CPF</th>
                                        <th>Telefone</th>
                                        <th>Coordenação</th>
                                        <th>UF</th>
                                        <th>Motivação</th>
                                        <th>Ações</th>
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
