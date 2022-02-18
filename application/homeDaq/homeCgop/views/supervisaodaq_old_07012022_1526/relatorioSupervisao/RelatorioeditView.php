<html>
<!--
/*
 * @e-mail. 
 * @author Jordana Alencar
 * @copyright  © 2020, DNIT | AQUAVIARIO.  
 */
-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Emaildaq</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                    <td bgcolor="#fffff" style="padding: 30px 30px 30px 30px; background-color: white;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <td width="75%" align="center">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <!--provisorio link do dnit="http://supra.dnit.gov.br/assets/img/colocar base_url src="<?php //echo (base_url('assets/img/LogoDNIT.png')) ?>"--> 
                                    <tr>
                                        <td>
                                            <img src="http://supra.dnit.gov.br/assets/img/LogoDNIT.png" alt="Dnit" width="50" height="" style="display: block;" border="0"/>
                                        </td>
                                        <td style="font-size: 0; line-height: 0;" width="20"> 
                                        </td>
                                        <td> 
                                            <img src="http://supra.dnit.gov.br/assets/img/brasao.png" alt="brasao" width="50" height="" style="display: block;" border="0"/>
                                        </td>
                                        <td style="font-size: 0; line-height: 0;" width="20"> 
                                        </td>
                                        <td>
                                            <img src="http://supra.dnit.gov.br/assets/img/brazilflag.png" alt="brazilflag" width="50" height="" style="display: block;" border="0"/>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <tr>
                                <td bgcolor="#ffffff" style="padding: 10px 10px 10px 10px;">
                                </td>
                            </tr>
                                <tr>
                                    <td bgcolor="#ffffff" width="75%"  align="center" style="color: black; font-family: Arial, sans-serif; font-size: 17px;">
                                        <b>Notificação de Inconsistência</b>
                                    </td>
                                </tr>
                            </table>
                    </td>
                    <!---------------------------------------------------------------->
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px;">
                                            <b>Módulo:</b> <?= $modulo ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">

                                          <b>Retificar:</b>  <?= $resumo ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px 10 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">

                                           <?= $date ?>

                                        </td>
                                    </tr>                                    <tr>
                                    <td style="padding: 10px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">

                                          Análise: <?= $nomeanalise ?> Perfil: <?= $perfil_usuario?>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#015175" style="padding: 15px 15px 15px 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="75%" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;">
                                            <font color="#ffffff">DNIT</font> - Departamento Nacional de Infraestrutura de Transportes. 
                                        </td>
                                        <td width="75%" align="right" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" >
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                  SUPRA AQUAVIÁRIO ®2020 Versão 1.0 
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                  </table>
              </td>
          </tr>
      </table>
  </body>
</html>


