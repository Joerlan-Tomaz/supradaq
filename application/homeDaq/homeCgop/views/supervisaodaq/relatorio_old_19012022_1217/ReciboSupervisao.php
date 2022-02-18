<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>DNIT | SUPRA</title>

<link rel="stylesheet" href="<?php echo (base_url('application/homeDaq/homeCgop/assets/css/homeDaq/recibo/estilos.css')) ?>" />
<link rel="stylesheet" href="<?php echo (base_url('application/homeDaq/homeCgop/assets/css/homeDaq/recibo/bootstrap.min.css')) ?>" />
<link rel="stylesheet" href="<?php echo (base_url('application/homeDaq/homeCgop/assets/css/homeDaq/recibo/print.css')) ?>" />
<style>
    .tabela>thead>tr>td, .tabela>thead>tr>td {
        color: white;
        background-color:#015175; 

    }
    .fundoCinzaCabecalho {
        background-color: #015175;
        font-weight: bold;
        -webkit-print-color-adjust: exact;
    }
/*.body{
-wedkit-print-color-adjust: exact;
}*/
</style>

    </head>
    <body class="A4">
        <!--CAPA RELATORIO-->
        <section id="relatorio" class="sheet padding-10mm">

            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <img src="<?php echo (base_url('assets/img/LogoDNIT.png')) ?>" style="width: 50%">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 center">
                     <img src="<?php echo (base_url('assets/img/brasao.png')) ?>" style="width: 50%;bottom: 20px;position: relative;">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 right">
                    <img src="<?php echo (base_url('assets/img/brazilflag.png')) ?>" style="width: 25%;bottom: 10px;position: relative;">
                </div>
            </div>
            <div class="row center titulo">
                <div class="col-md-12">
                    <span>DEPARTAMENTO NACIONAL DE INFRAESTRUTURA DE TRANSPORTES - DNIT</span>
                </div>		
                <div class="col-md-12">
                    <span>COORDENAÇÃO GERAL DE CONSTRUÇÃO AQUAVIÁRIA</span>
                </div>
                <div class="col-md-12">
                    <span>PERÍODO REFERÊNCIA - <?= $periodo_referencia ?> <b></b></span>
                </div>


                <div class="col-md-12 titulo-relatorio">
                    RECIBO - RELATÓRIO DE SUPERVISÃO AQUAVIÁRIA
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
              
                    <table class="pull-left"> 
                        <tbody>
                            <tr>
                                <td style=" width: 170px;"><b>Contrato : </b></td>
                                <td> <?= $n_contrato_obra ?></td>
                                     
                            </tr>
                            <tr>
                                <td><b>Construtora:</b></td>
                                <td> <?= $empresa_obra ?></td>
                               
                            </tr>
                            <tr>
                                <td><b>Supervisora:</b></td>
                                <td> <?= $empresa_super; ?> / <?= $nu_contrato_super; ?>  </td>  
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td><b>Período Ref. </b></td>
                                <td> <?= $periodo_referencia ?></td>
                               
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td><b>Hidrovia:</b></td>
                                <td> <?= $hidrovia_localizacao ?></td>
                              
                            </tr>
                            <tr>
                                <td><b>Municipio:</b></td>
                                <td> <?= $municio_localizacao ?></td>
                              
                            </tr>
                            <tr>
                                <td><b>Extensão/Área:</b></td>
                                <td> <?= $extensao_localizacao ?></td>
                              
                            </tr>
                        </tbody>					  						  	
                    </table>
                </div>
        
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table class="tabela bordaCompleta" style=" width: 100%;margin-top: 5%;">
                        <thead class="center fundoCinzaCabecalho">
                            <tr>
                                <td>#</td>
                                <td>Módulo</td>
                                <td>Usuário</td>                 
                                <td>Atualizacao</td>   
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        
                        $j= 1;
                        foreach ($DadosRelatorioDaq as $key ) {
   
                                   $modulo = $key->modulo;   
                                   $usuario = $key->usuario;   
                                   $ultima_alteracao = $key->ultima_alteracao; 
                                 
                        ?>
                        <tr>
                            <td> <?= $j++; ?> </td>
                            <td> <?= $modulo; ?>  </td>
                            <td> <?= $usuario; ?>  </td>
                            <td> <?= $ultima_alteracao; ?>  </td>
                        </tr>
                            
                          <?php } ?> 
  
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        
<section id="relatorio-reprovado" class="sheet padding-10mm">
            <div class="row center">
                <div class="col-md-12 titulo-relatorio">
                    HISTÓRICO DE APROVAÇÕES DO RELATÓRIO
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 pull-right">
                    <span><?= $fechamento; ?></span>
                    <br><br>
                    <span><b>Versão</b></span><br>
                    <span><?= $versao; ?></span>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table class="tabela bordaCompleta" style=" width: 100%;margin-top: 5%;">
                        <thead class="center fundoCinzaCabecalho">
                            <tr>
                                <td>#</td>
                                <td>Aceite</td>
                                <td>Módulo</td>
                                <td>Análise</td>                 
                                <td>Usuário</td>                 
                                <td>Data</td>   
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        
                        $j= 1;
                        foreach ($DadosHistorico as $key ) {
   
                                   $aceite = $key->aceite;   
                                   $modulo = $key->modulo;   
                                   $analise = $key->desc_analise;   
                                   $roteiro = $key->nome;   
                                   $ultima_alteracao = $key->ultima_alteracao; 
                                 
                        ?>
                        <tr>
                            <td> <?= $j++; ?> </td>
                            <td> <?= $aceite; ?>  </td>
                            <td> <?= $modulo; ?>  </td>
                            <td> <?= $analise; ?>  </td>
                            <td> <?= $roteiro; ?>  </td>
                            <td> <?= $ultima_alteracao; ?>  </td>
                        </tr>
                            
                          <?php } ?> 
  

                        </tbody>
                    </table>
                </div>
            </div>
        </section> 

    

</body>