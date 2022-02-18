<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/home/perfilUsuario.js')) ?>"></script>
<div class="content-wrapper" style="margin-left: 0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Meu Perfil</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <div id="exibeFoto"></div>
                            </div>

                            <p class="text-muted text-center" id="dataUltimoAcessoPerfil">Último Acesso </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>E-mail</b> <a class="float-right" id="emailPerfil">-</a>
                                </li>
                                <li class="list-group-item">
                                    <b>CPF</b> <a class="float-right" id="cpfPerfil">-</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Telefone</b> <a class="float-right" id="telefonePerfil">-</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block" onclick="alterasenhaModal()">
                                <i class="fa fa-key" aria-hidden="true"></i> Alterar senha
                            </a>
                        </div>
                    </div>

                    <!-- About Me Box -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Sobre mim
                                <a href="#" class="btn btn-primary btn-sm pull-right" onclick="sobreMimModal()">
                                    <i class="fa fa-cogs"></i>
                                </a>
                            </h3>              
                        </div>
                        <div class="card-body">
                            <strong><i class="fa fa-book mr-1"></i> Formação</strong>

                            <p class="text-muted">
                                <span id="formacaoPerfil"></span>
                            </p>

                            <hr>

                            <strong><i class="fa fa-dot-circle-o margin-r-5"></i> Área de Atuação</strong>

                            <p class="text-muted"><span id="areaAtuacaoPerfil"></span></p>

                            <hr>
                            <strong><i class="fa fa-phone-square margin-r-5"></i> Telefone Adicional</strong>

                            <p class="text-muted"><span id="telefoneAdicionalPerfil"></span></p>

                            <hr>

                            <strong><i class="fa fa-map-marker mr-1"></i> Localização</strong>

                            <p class="text-muted"><span id="localizacaoPerfil"></span></p>

                            <hr>

                            <strong><i class="fa fa-file-text-o mr-1"></i> Curriculo Resumido</strong>

                            <p class="text-muted"><span id="curriculoResumidoPerfil"></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Mensagens</a></li>
                                <li class="nav-item"><a id="abrirlinhatempo" class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="active tab-pane" id="activity">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-block btn-primary" href="javascript:void(0);" onclick="PerfilMensagem();">Incluir</button>
                                        </div> 
                                    </div>
                                    <br>
                                    <div class='row'>
                                        <div class='col-xs-12 col-sm-12 col-md-12'> 

                                            <div id="accordion">       
                                                <div id="MensagemPerfil"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="timeline">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">

                                            <ul class="timeline" id="LinhaTempoPerfil"></ul>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="alterasenhaModal" tabindex="-1" role="dialog" aria-labelledby="disciplina" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formNovaSenha" id="formNovaSenha">                
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
                        <button type="button" name="btnAlterarsenha" class="btn btn-block btn-warning " onClick="alterarSenha()">
                            <i class="fa fa-key" aria-hidden="true"></i> Alterar Senha
                        </button>
                    </div> 
                </form> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sobreMimModal" tabindex="-1" role="dialog" aria-labelledby="disciplina" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sobre Mim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="formSobreMim" id="formSobreMim">
                    <div class="row">  

                        <div class="col-md-12" >     
                            <div class="form-group">
                                <label>Foto de Perfil <small>Arquivos permitidos: .jpg,.jpeg  </small></label><br>
                                <input type="file" id="fileUpload" name="fileUpload" accept=".jpg,.jpeg">
                            </div>
                        </div>                     

                        <div class="col-md-6">
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Titularidade</label>
                                        <select class="form-control" name="titularidade"  id="titularidade">
                                            <option value="">Selecione</option>
                                            <option value="Técnico">Técnico</option>
                                            <option value="Graduação">Graduação</option>
                                            <option value="Especialização">Especializa&ccedil;&atilde;o</option>
                                            <option value="Mestrado">Mestrado</option>
                                            <option value="Doutorado">Doutorado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Formação</label>
                                        <input type="text" class="form-control" id="formacao" name="formacao" placeholder="Formação">
                                    </div>   
                                </div>
                            </div>
                            <hr>

                            <div class="row"> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Localização</label>
                                        <select  class='form-control' name='localizacao' id='localizacao'>
                                            <option value="">Selecione</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="PR">Paraná</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="TO">Tocantins </option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telefone Adicional</label>
                                        <input type="text" class="form-control" id="telefone_adicional" name="telefone_adicional" placeholder="Telefone Adicional">
                                    </div>   
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Área de Atuação</label>
                                <input type="text" class="form-control" id="area_atuacao" name="area_atuacao" placeholder="Área de Atuação">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Curriculo Resumido</label>
                                <textarea rows="9" cols="50" type="text" id="curriculo_resumido" name="curriculo_resumido" class="form-control" placeholder="Curriculo Resumido"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="alteraSobreMim()"  >Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPerfilMensagem" tabindex="-1" role="dialog" aria-labelledby="painel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mensagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" name="formularioMensagem" id="formularioMensagem">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>De </label>
                                <select class="form-control" name="id_usuario_remetente" id="id_usuario_remetente" disabled>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Para</label>
                                <select class="form-control" name="id_usuario_destinatario" id="id_usuario_destinatario">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assunto</label>
                                <textarea rows="2" type="text" id="assunto_mensagem" name="assunto_mensagem" class="form-control">
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea rows="5" type="text" id="descricao_mensagem" name="descricao_mensagem" class="form-control">
                                </textarea>
                            </div>
                        </div>


                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="gravaPerfilMensagem()"  >Salvar</button>
            </div>
        </div>
    </div>
</div>
