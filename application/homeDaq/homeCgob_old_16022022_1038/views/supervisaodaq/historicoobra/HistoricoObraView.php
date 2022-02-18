<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/historico/historicoView.js')) ?>" type="text/javascript"></script>	
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Histórico da Obra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaDaq()">DAQ
                        </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"> <?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Histórico da Obra</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h6>
                            O histórico visa apresentar acontecimentos passados, contextualizando o leitor do relatório para melhor entendimento da execução das obras.
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                            <div class='mostrar'>
                                Em caso de obras remanescentes, devem ser fornecidas informações administrativas e serviços executados por contratos de obras anteriores.<br>
                                Além disso devem ser detalhados os motivos que levaram à não finalização dos serviços e necessidade de nova contratação, assim como
                                tratativas provenientes desta situação (instauração de PAAR, recebimentos parciais/definitivos, etc.).
                                Para o contrato de obras e de supervisão vigentes, devem ser inseridas todas e quaisquer informações julgadas relevantes, 
                                sejam marcos administrativos (termos aditivos, processos jurídicos), ambientais (liberação de licenças, de condicionantes), 
                                de desapropriações, financeiros, de projetos ou construtivos.<br>
                                Importante informar também os períodos de paralisação das obras e seus impactos nos serviços já realizados, seja em contratos 
                                anteriores ou no vigente.
                            </div>
                        </h6>

                        <div class="row">
                            <div class="col-xs-12 col-md-1">
                                <div>
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div>
                                <div> 
                                  <button type="button" name="searchdate" id="searchdate" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                            </div>
                        </div>                 
                    </form>
                </div>

                <div class="card-body">
                    <div class="row" id="novo_historico">
                        <div class="col-md-12 table-responsive">
                            <table id="tabelaHistorico" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Histórico da Obra</th>
                                        <th>Usuário</th>
                                        <th>Data da Atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>                  
                    </div>

                    <div id="cadastroHistorico">
                        <form method="post" name="formularioConfigHistorico" id="formularioConfigHistorico">
                            <input class="form-control" type="hidden" id="id_resumo" name="id_resumo">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        <textarea rows="8" type="text" id="descricao_historico" name="descricao_historico" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-block btn-primary" name="insereHistorico" id="insereHistorico">Salvar</button>
                                </div>
                            </div>
                        </form>                         
                    </div>          
                </div> 
            </div>
        </div>
    </section>
</div>
