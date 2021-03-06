<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>SUPRA | Log in</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="shortcut icon" href="http://supra.dnit.gov.br/supra/assets/img/favicon-2.png" />
        <link rel="icon" href="<?php echo (base_url('assets/img/favicon-2.png')) ?>" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo (base_url('assets/bootstrap/css/bootstrap.min.css')) ?>" />
        <link rel="stylesheet" href="<?php echo (base_url('assets/css/font-awesome/font-awesome.min.css')) ?>" />
        <link rel="stylesheet" media="all" href="<?php echo (base_url('assets/login2017/animate.css')) ?>">
        <link rel="stylesheet" media="all" href="<?php echo (base_url('assets/login2017/login.css')) ?>">    
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/notify/notify.css')) ?>">

        <script type="text/javascript" src="<?php echo (base_url('assets/plugins/jQuery/jquery-1.12.4.min.js')) ?>"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo (base_url('assets/bootstrap/js/bootstrap.min.js')) ?>"></script>

        <!-- Notify -->
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/notify/notify.css')) ?>">
        <script src="<?php echo ('assets/plugins/notify/notify.js') ?>" type="text/javascript"></script>
        <script src="<?php echo ('assets/js/home/login.js') ?>" type="text/javascript"></script>
    </head>

    <body>
        <div id="particles-js"></div>

        <div class="conteudo">
            <div class="conteudo-container">
                <div class="row logos">
                    <div class="col-md-6">
                        <div class="logo logo-supra">
                            <img src="<?php echo (base_url('assets/login2017/imgs/supra-semfundo.png')) ?>" class="img-responsive" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="logo lista">
                            <ul>
                                <li>Informa????es em tempo real</li>
                                <li>Pain??is Gerenciais</li>
                                <li>Mapa Interativo</li>
                                <li>Integra????o entre as Diretorias do DNIT</li>
                                <li>Maior transpar??ncia</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center"></div>
                </div>
                <div class="row">
                    <div class="col-sm-8 text-center" style="left: 50px;"><button id="btn-login" class="btn btn-primary btn-lg btn-flat btn-block btn-login shadow"><i class="fa fa-sign-in pull-left" aria-hidden="true"></i> Acessar</button></div>
                </div>
            </div>
        </div>
        <div class="trio-logos">
            <img src="<?php echo (base_url('assets/login2017/imgs/logos_dnit_branco_semfundo.png')) ?>" class="img-responsive" />
        </div>


        <div id="login-box" class="hidden animated">
            <button id="btn-login-close" class="btn-close"><i class="fa fa-close"></i></button>
            <div class="conteudo-container">
                <div class="row">
                    <div class="col-sm-12">
                        <H2>Acesso Supra</H2>
                    </div>
                </div>
                <div class="row">
                    <form name="form_login" id="form_login" >
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="login-email">Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="email" class="form-control" placeholder="Email" name="nume_matricula" id="nume_matricula">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="login-senha">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" placeholder="Senha" name="codi_senha" id="codi_senha">
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <!--<a href="">Lembrar senha</a>-->
                            </div> 

                            <div class="form-group">

                                <button type="button" id="btn-entrar" class="btn btn-warning btn-block shadow">Entrar</button>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6 text-center">
                            <a class="btn btn-link btn-cancel">Cancelar</a>
                        </div> -->
                        <div class="col-sm-12 text-center">
                            <a href="javascript:void(0);" class="btn btn-link btn-acesso">Solicitar Acesso</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="acesso-box" class="hidden animated">
            <button id="btn-acesso-close" class="btn-close shadow"><i class="fa fa-close"></i></button>
            <div class="conteudo-container">

                <div class="mensagem-acesso-inicio">
                    <div class="row">
                        <div class="col-sm-12">
                            <H2>Solicita????o de Acesso - Supra</H2>
                            <p>
                                Para novo acesso, preencha e envie o formul??rio abaixo.
                                <br /> Para saber mais sobre a plataforma acesse: <a href="<?php echo (base_url('assets/downloads/supra.zip')) ?>"> Apresenta????es e Manual </a>, para outros esclarecimentos envie um e-mail para: <a id="emailSolicitacao" href=""> </a>.
                            </p>
                        </div>
                    </div>
                </div>
                <form method="post" name="formularioAcesso" id="formularioAcesso">
                    <div class="form form-acesso">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="acesso-nome">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" id="acesso-nome" name="acesso-nome" placeholder="Nome Completo">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="acesso-email">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                        <input type="email" class="form-control" id="acesso-email" name="acesso-email" placeholder="Email Institucional">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="acesso-empresa">Empresa</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-building" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" id="acesso-empresa" name="acesso-empresa" placeholder="Nome da empresa">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="acesso-cpf">Cpf</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" id="acesso-cpf" name="acesso-cpf" placeholder="Cpf" maxlength="14">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="acesso-telefone">Telefone</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" id="acesso-telefone" name="acesso-telefone" placeholder="Telefone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="acesso-coordenacao">Coordena????o</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users" aria-hidden="true"></i></span>
                                        <select class="form-control" name="acesso-coordenacao" id="acesso-coordenacao" required>
                                            <option value="">Selecione</option>
                                            <option value="CGCONT">CGCONT</option>
                                            <option value="CGMRR">CGMRR</option>
                                            <option value="CGPERT">CGPERT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="acesso-coordenacao">UF</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users" aria-hidden="true"></i></span>
                                        <select class="form-control" name="acesso-uf" id="acesso-uf" required>
                                            <option value="">Selecione</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amap??</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Cear??</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espirito Santo</option>
                                            <option value="GO">Goi??s</option>
                                            <option value="MA">Maranh??o</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Par??</option>
                                            <option value="PB">Para??ba</option>
                                            <option value="PR">Paran??</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piau??</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rond??nia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">S??o Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="acesso-motivo">Motivo</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-navicon" aria-hidden="true"></i></span>
                                        <input type="text" maxlength="50" class="form-control" id="acesso-motivo" name="acesso-motivo" placeholder="Motivo de Solicita????o">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="acesso-empresa">Verifica????o de seguran??a</label>
                                </div> 

                                <div class="col-sm-5 col-xs-8">
                                    <div id="imgdiv" class="form-group">
                                        <label for="acesso-captcha">Captcha</label>
                                        <img id="img" src="<?php echo (base_url('assets/captcha/fundocaptch.png')) ?>" alt="c??digo captcha" />
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-4">
                                    <div class="form-group" style="padding:10px;">
                                        <a href="javascript:void(0);" id="reload" class="btn btn-link btn-reload btn-lg">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </a>
                                        <span style="font-size:10px; display: block; text-align: center;">Recarregar</span>
                                    </div>

                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="acesso-captcha">Informe o texto da imagem</label>    
                                        <input type="text" class="form-control" id="acesso-captcha" name="acesso-captcha">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <a href="javascript:void(0);" id="btn-enviar" class="btn btn-warning btn-block shadow">Enviar</a>
                            </div>
                        </div>
                    </div>
                </form> 
                <!-- //form -->

                <div class="mensagem-acesso-envio hidden">
                    <div class="row">
                        <div class="col-sm-12">
                            <H2>Solicita????o de Acesso - Supra</H2>

                            <div class="msg-erro">
                                <h4 id="messagem">Mensagem</h4>
                                <button class="btn btn-link btn-tentar">Tentar novamente</button>
                            </div>

                            <div class="msg-sucesso">
                                <h4 id="messagem">Dados enviados com sucesso!</h4>
                                <p>Em breve voc?? receber?? por e-mail a confirma??ao de seu acesso. Obrigado.</p>
                                <p>Equipe Supra.</p>
                            </div>
                            <p>
                                Para saber mais sobre a plataforma acesse: <a href="<?php echo (base_url('assets/downloads/supra.zip')) ?>"> Apresenta????es e Manual </a>, para esclareciemntos envie um e-mail para: <a href="mailto:suporte.supra@dnit.gov.b"> suporte.supra@dnit.gov.br </a>.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- //mensagem-acesso -->
            </div>
            <!-- //container -->
        </div>

        <div id="video-box" class="hidden animated">
            <button id="btn-video-close" class="btn-close"><i class="fa fa-close"></i></button>
            <video id="video" controls controlsList="nodownload" preload="auto" poster="<?php echo (base_url('assets/login2017/video/tec-15.jpg')) ?>">
                <source src="<?php echo (base_url('assets/login2017/video/supra.mp4')) ?>" type="video/mp4" />
            </video>
        </div>

        <script src="<?php echo (base_url('assets/login2017/particles.min.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/login2017/login.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/captcha/js/captcha.js')) ?>" type="text/javascript"></script>


    </body>

</html>