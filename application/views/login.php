<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>SUPRA | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- <link rel="shortcut icon" href="http://supra.dnit.gov.br/supra/assets/img/favicon-2.png" />-->
        <link rel="icon" href="<?php echo (base_url('assets/img/favicon.ico')) ?>" type="image/x-icon" /> 
        <link rel="stylesheet" href="<?php echo (base_url('assets/bootstrap/css/bootstrap.min.css')) ?>" />
        <link rel="stylesheet" href="<?php echo (base_url('assets/css/font-awesome/font-awesome.min.css')) ?>" />
        <link rel="stylesheet" media="all" href="<?php echo (base_url('assets/login2020/animate.css')) ?>">
        <link rel="stylesheet" media="all" href="<?php echo (base_url('assets/login2020/login.css')) ?>">    
        <link rel="stylesheet" media="all" href="<?php echo (base_url('assets/login2020/orbe.css')) ?>"> 
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/notify/notify.css')) ?>">
        <script type="text/javascript" src="<?php echo (base_url('assets/plugins/jQuery/jquery-1.12.4.min.js')) ?>"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo (base_url('assets/bootstrap/js/bootstrap.min.js')) ?>"></script>

        <!-- Notify -->
        <link rel="stylesheet" href="<?php echo (base_url('assets/plugins/notify/notify.css')) ?>">
        <script src="<?php echo ('assets/plugins/notify/notify.js') ?>" type="text/javascript"></script>
        <script src="<?php echo ('assets/js/home/login.js') ?>" type="text/javascript"></script>
        <script src="<?php echo ('assets/login2020/validadores.js') ?>" type="text/javascript"></script>
    </head>

    <body class="paralax-pb" oncontextmenu="return false" cz-shortcut-listen="true" style="background-image:url('<?php echo (base_url('assets/login2020/imgs/login-tela.png')) ?>');">
        <canvas id="bg-canvas"></canvas>

        <div class="conteudo">

            <div id="slide1" class="slide-box">
                <div  class="slide login-pb">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <form name="form_login" id="form_login" class="form-login">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group form-pb">
                                                <label for="login-email">Email</label>
                                                <input type="email" class="form-control" name="nume_matricula" id="nume_matricula">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-pb">
                                                <label for="login-senha">Senha</label>
                                                <input type="password" class="form-control" name="codi_senha" id="codi_senha">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button type="button" id="btn-entrar" class="btn btn-dark btn-flat btn-block">Entrar</button>
                                            </div>
                                        </div>
                                        <?php
//                                        if($this->auth_ad->is_authenticated())
//                                        {
                                        ?>
<!--                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button type="button" id="btn-entrar" class="btn btn-dark btn-flat btn-block">Login Rápido</button>
                                            </div>
                                        </div>-->
                                        <?php
//                                        }
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="logo logo-supra">
                            <img src="<?php echo (base_url('assets/login2020/imgs/logo_supra2.png')) ?>" class="img-responsive">
                        </div>                       
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="trio-logos">
                                    <img src="<?php echo (base_url('assets/login2020/imgs/logos_dnit_branco.png')) ?>" class="img-responsive">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <nav class="nav-navbar"> 
                                    <ul id="nav">
                                        <li><a id="btn-video-pb" class="link-video link" href="#slide3" title="Vídeo">Vídeo</a></li>
                                        <li><a class="link-acesso link btn-link btn-acesso" href="#slide4" title="Solicitar Acesso">Solicitar Acesso</a></li>
                                    </ul>
                                    <ul class="portal-cidadao">
                                        <li><a class="link-pc" href="https://servicos.dnit.gov.br/portalcidadao" target="_blank" >Portal Cidadão</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>
            </div>           

            <div id="slide4" class="slide-box">
                <div class="slide acesso_">
                    <div class="content">
                        <div class="mensagem-acesso-inicio">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2>Solicitar Acesso</h2>
                                    <p class="form-acesso">
                                        Para novo acesso, preencha e envie o formulário abaixo.
                                        <br> Para saber mais sobre a plataforma acesse: <a href="<?php echo (base_url('assets/downloads/supra.zip')) ?>"> Apresentações e Manual </a>, para outros esclarecimentos envie um e-mail para: <a href="mailto:supra.construcao@dnit.gov.br"> supra.construcao@dnit.gov.br</a> | <a href="mailto:supra.manutencao@dnit.gov.br"> supra.manutencao@dnit.gov.br</a> | <a href="mailto:supra.operacao@dnit.gov.br"> supra.operacao@dnit.gov.br</a>
                                        | <a href="mailto:diretoria.aquaviaria@dnit.gov.br"> diretoria.aquaviaria@dnit.gov.br</a> | <a href="mailto:cgofer@dnit.gov.br"> cgofer@dnit.gov.br</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <form method="post" name="formularioAcesso" id="formularioAcesso">
                            <div class="form form-acesso">
                                <div class="row">
                                    <div class="col-sm-12">
        
                                        <div class="form-group form-supra">
                                            <label for="acesso-nome" class="">Nome completo</label>
                                            <input type="text" class="form-control" id="acesso-nome" name="acesso-nome">
                                        </div>
            
                                        <div class="form-group form-supra">
                                            <label for="acesso-email">E-mail</label>
                                            <input type="text" class="form-control" id="acesso-email" name="acesso-email">
                                        </div>
            
                                        <div class="form-group form-supra">
                                            <label for="acesso-empresa">Empresa</label>
                                            <input type="text" class="form-control" id="acesso-empresa" name="acesso-empresa">
                                        </div>
        
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group form-supra">
                                                    <label for="acesso-cpf">CPF</label>
                                                    <input type="text" class="form-control" id="acesso-cpf" name="acesso-cpf" maxlength="14">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group form-supra">
                                                    <label for="acesso-telefone">Telefone</label>
                                                    <input type="text" class="form-control" id="acesso-telefone" name="acesso-telefone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group form-supra">
                                                    <label for="acesso-coordenacao">Coordenação</label>
                                                    <select class="form-control" name="acesso-coordenacao" id="acesso-coordenacao" required>
                                                        <option value=""></option>
                                                        <option value="CGCONT">DIR - CGCONT</option>
                                                        <option value="CGMRR">DIR - CGMRR</option>
                                                        <option value="CGPERT">DIR - CGPERT</option>
                                                        <option value="CGOB">DAQ - CGOB</option>
														<option value="CGOP">DAQ - CGOP</option>
                                                        <option value="CGOFER">DIF - CGOFER</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group form-supra">
                                                    <label for="acesso-coordenacao">UF</label>
                                                    <select class="form-control" name="acesso-uf" id="acesso-uf" required>
                                                        <option value=""></option>
                                                        <option value="AC">Acre</option>
                                                        <option value="AL">Alagoas</option>
                                                        <option value="AP">Amapá</option>
                                                        <option value="AM">Amazonas</option>
                                                        <option value="BA">Bahia</option>
                                                        <option value="CE">Ceará</option>
                                                        <option value="DF">Distrito Federal</option>
                                                        <option value="ES">Espirito Santo</option>
                                                        <option value="GO">Goiás</option>
                                                        <option value="MA">Maranhão</option>
                                                        <option value="MS">Mato Grosso do Sul</option>
                                                        <option value="MT">Mato Grosso</option>
                                                        <option value="MG">Minas Gerais</option>
                                                        <option value="PA">Pará</option>
                                                        <option value="PB">Paraíba</option>
                                                        <option value="PR">Paraná</option>
                                                        <option value="PE">Pernambuco</option>
                                                        <option value="PI">Piauí</option>
                                                        <option value="RJ">Rio de Janeiro</option>
                                                        <option value="RN">Rio Grande do Norte</option>
                                                        <option value="RS">Rio Grande do Sul</option>
                                                        <option value="RO">Rondônia</option>
                                                        <option value="RR">Roraima</option>
                                                        <option value="SC">Santa Catarina</option>
                                                        <option value="SP">São Paulo</option>
                                                        <option value="SE">Sergipe</option>
                                                        <option value="TO">Tocantins</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group form-supra">
                                                    <label for="acesso-motivo">Motivo</label>
                                                    <input type="text" maxlength="50" class="form-control" id="acesso-motivo" name="acesso-motivo">
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="row seguranca">
                                            <div class="col-sm-12">
                                                <label for="acesso-empresa">Verificação de segurança</label>
                                            </div> 
                                        
                                            <div class="col-sm-5 col-xs-8">
                                                <div id="imgdiv" class="form-group">
                                                    <!-- <label for="acesso-empresa">Captcha</label> -->
                                                    <img id="img" src="<?php echo (base_url('assets/captcha/fundocaptch.png')) ?>" alt="código captcha">
                                                </div>                                                                                                                        
                                            </div>
                                            <div class="col-sm-2 col-xs-4">
                                                <div class="form-group" style="padding:10px;">
                                                    <a href="javascript:void(0);" id="reload" class="btn-link btn-reload btn-lg">
                                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                                    </a>
                                                    <span style="font-size:10px; display: block; text-align: center;">Recarregar</span>
                                                </div>                                            
                                            </div>                                    
                                            <div class="col-sm-5">
                                                <div class="form-group form-supra">
                                                    <label for="acesso-captcha" class="stacked">Informe o texto da imagem</label>    
                                                    <input type="text" class="form-control" id="acesso-captcha" name="acesso-captcha">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <a href="javascript:void(0);" id="btn-enviar" class="btn btn-dark btn-block">Solicitar</a>
                                        </div>
        
                                    </div>
                                </div>
                            </div>

                            <div class="msg-box">
                                <div class="msg-erro">
                                    <h4 class="messagem">Mensagem</h4>
                                    <button class="btn btn-warning btn-tentar">Tentar novamente</button>
                                </div>
        
                                <div class="msg-sucesso">
                                    <h4 class="messagem">Dados enviados com sucesso!</h4>
                                    <p>Em breve você receberá por e-mail a confirmaçao de seu acesso. Obrigado.</p>
                                    <p>Equipe Supra.</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <nav class="nav-navbar"> 
                                        <ul id="nav">
                                            <li><a class="link-supra link active" href="#slide1" title="Supra">Voltar</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </form>  
                    </div>
                </div>
            </div>
        </div>


        <div id="video-box" class="slide-box animated hidden">
            <div class="video-container">
                <button id="btn-video-close-pb" class="btn-close"><i class="fa fa-close"></i></button>
                <video id="video" controls="" preload="auto" poster="<?php echo (base_url('assets/login2020/video/tec-15.jpg')) ?>">
                    <source src="<?php echo (base_url('assets/login2020/video/supra.mp4')) ?>" type="video/mp4">
                </video>
            </div>
        </div>

        <script src="<?php echo (base_url('assets/login2020/bezierCanvas.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/login2020/login.js')) ?>"></script>
        <script src="<?php echo (base_url('assets/captcha/js/captcha.js')) ?>" type="text/javascript"></script>

    </body>

</html>
</html>