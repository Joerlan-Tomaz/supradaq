<?php
/*
 * Classe controller Cronogramafinanceiroobractr. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, FALCONI | DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Cronogramafinanceiroobractr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_cronogramafinanceiro');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

//--------------------------------------------------------------------------------------------

    // public function recuperaServico() {
    //     $DadosServico = $this->Tb_cronogramafinanceiro->recuperaServico();
    //     $n = 0;
    //     foreach ($DadosServico as $lista) {
    //         $dados['id_servico'][$n] = $lista->id_servico;
    //         $dados['servico'][$n] = str_replace("_", " ", $lista->servico);
    //         $n++;
    //     }
    //     echo (json_encode($dados));
    // }
//------------------------------------------------------------------------------------------------------------------------
    public function RecuperaObra() {
        $DadosServico = $this->Tb_cronogramafinanceiro->recuperaObra();
        $n = 0;
        foreach ($DadosServico as $lista) {
            $dados['id_obra'][$n] = $lista->id_tipo_obra;
            $dados['obra'][$n] = str_replace("_", " ", $lista->desc_tipo_obra);
            $n++;
        }
        echo (json_encode($dados));
    }
//-------------------------------------------------------------------------------------------------------------------------
    public function recuperaServico() {
        $dados["id_obra"] = $this->input->post_get("id_obra");

        if ($dados["id_obra"] == 1){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraConstrucao();
        }
         if ($dados["id_obra"] == 2){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraDerrocagem($dados);
        }
         if ($dados["id_obra"] == 3){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraDragagem($dados);
        }
         if ($dados["id_obra"] == 4){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraDesobstrucao($dados);
        }
         if ($dados["id_obra"] == 5){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraPortos($dados);
        }
         if ($dados["id_obra"] == 6){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraPassageiros($dados);
        }
         if ($dados["id_obra"] == 7){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraNavioHaider($dados);
        }
         if ($dados["id_obra"] == 8){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraSinalHidro($dados);
        }
        if ($dados["id_obra"] == 9){
            $dadosServico = $this->Tb_cronogramafinanceiro->recuperaObraEclusas($dados);
        }
       
        $n = 0;
        foreach ($dadosServico as $lista) {
            $dados['id_servico'][$n] = $lista->id_obra;
            $dados['servico'][$n] = str_replace("_", " ", $lista->desc_obra);
            $n++;
        }
        echo (json_encode($dados));
    }
//-------------------------------------------------------------------------------------------------------------------------
    public function recuperaTipo() {
        $dados["id_servico"] = $this->input->post_get("servico");

        if ($dados["id_servico"] == 16){

                $dadosTipo = $this->Tb_cronogramafinanceiro->recuperaTipoEstruturaNaval($dados);

        } else{
                $dadosTipo = $this->Tb_cronogramafinanceiro->recuperaTipo($dados);
        }

        // $dados = $this->Tb_cronogramafinanceiro->recuperaDesc($dados);
        // $dados["desc_obra"]=$dados[0]["desc_obra"];

        $n = 0;
        foreach ($dadosTipo as $lista) {
            $dados['id_tipo'][$n] = $lista->id_tipo;
            $dados['tipo'][$n] = str_replace("_", " ", $lista->desc_tipo);
            $n++;
        }
        echo (json_encode($dados));
    }

//--------------------------------------------------------------------------------------------

     public function recuperaSaldo() {  
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["versao"] = $this->input->post_get('versao');
        
        $valorPI = $this->Tb_cronogramafinanceiro->valorPI($dados);
         
        foreach ($valorPI as $listasaldo) {
            $dados["pi"] = $listasaldo->valor_inicial;
        }
       
        $valorSaldo = $this->Tb_cronogramafinanceiro->recuperaSaldo($dados);

        if($valorSaldo[0]["valor_previsto"] == null){
            $dados["saldo"] = 0;
            $dados["saldo_lancar"] = $dados["pi"]; 

        } else{
            $dados["saldo"] = $valorSaldo[0]["valor_previsto"];
            $dados["saldo_lancar"] = (float) ($dados["pi"] - $dados["saldo"]);
              
        }; 
        echo (json_encode($dados));
    }
//------------------------------------------------------------------------------------------------------------------------

    public function Recuperadadosversao(){              
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = 1;
        $dados["versao"] = 1;

        $DadosVersao = $this->Tb_cronogramafinanceiro->recuperaVersao($dados);
        foreach ($DadosVersao as $lista) { 
            $dados['id_cronograma'] = $lista->id_cronograma + 1;
            $dados['versao'] = $lista->versao + 1;

        }
        echo (json_encode($dados));
    }

//-------------------------------------------------BotaoNovo-------------------------------------------------------------

    public function insereCronogramaFinanceiroObra(){
        $dados["id_contrato_obra"] = $this->session->idContrato;  
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');

        $DadosCronogramaFinanVersao = $this->Tb_cronogramafinanceiro->recuperaVersao($dados);

        if(!empty($DadosCronogramaFinanVersao)){ // se não for primeira versao

        foreach ($DadosCronogramaFinanVersao as $lista) {
            $dados["id_cronograma_financeiro_versao"] = $lista->id_cronograma_financeiro_versao;
            $dados["versao"] = $lista->versao;
            $dados["id_cronograma"] = $lista->id_cronograma;
            $dados["publicar_cronograma"] = $lista->publicar_cronograma;
        }
            if($dados["publicar_cronograma"] == 'S') {       // se o que receber tiver publicado versao anterior
                $dados["versao"] = $dados["versao"] + 1;
                $dados["id_cronograma"] = $dados["id_cronograma"] + 1;

                $Retorno = $this->Tb_cronogramafinanceiro->insereVersao($dados); 
            }
                  $dados["ano"] = $this->input->post_get("anoreferente");
                  $dados["servico"] = $this->input->post_get("servico");
                    $dados["id_servico"] = $this->input->post_get("servico");
                    $dados["id_obra"] = $this->input->post_get("obra");
                    $dados["tipo"] = $this->input->post_get("tipo");

                    for ($j = 1; $j <= 12; $j++) {
                        if (!empty($this->input->post("mes")[$j])) {
                            $dados["mes"] = $this->input->post("mes")[$j];
                            $dados["valorprev"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valorprev")[$j]));
                            if (!empty($this->input->post("valorprev")[$j])) {
                                $retorno = $this->Tb_cronogramafinanceiro->insereCronogramaFinanceiro($dados);
                            }
                        }
                    }
            die(json_encode($retorno));
        } 
        if(empty($DadosCronogramaFinanVersao)){ // se for primeira versao
            $dados["id_cronograma"] = 1;
            $dados["versao"] = 1;
            $dados["publicar_cronograma"] = "N";

            $Retorno = $this->Tb_cronogramafinanceiro->insereVersao($dados);

            $DadosCronogramaFinanVersao = $this->Tb_cronogramafinanceiro->recuperaVersao($dados);
            foreach ($DadosCronogramaFinanVersao as $lista) {
                $dados["versao"] = $lista->versao;
                $dados["id_cronograma"] = $lista->id_cronograma;
                $dados["publicar_cronograma"] = $lista->publicar_cronograma;
                $dados["id_cronograma_financeiro_versao"] = $lista->id_cronograma_financeiro_versao;
            }

                    $dados["ano"] = $this->input->post_get("anoreferente");
                    $dados["servico"] = $this->input->post_get("servico");

                    $dados["id_servico"] = $this->input->post_get("servico");
                    $dados["id_obra"] = $this->input->post_get("obra");
                    $dados["tipo"] = $this->input->post_get("tipo");

                    for ($j = 1; $j <= 12; $j++) {
                        if (!empty($this->input->post("mes")[$j])) {
                            $dados["mes"] = $this->input->post("mes")[$j];
                            $dados["valorprev"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valorprev")[$j]));
                            if (!empty($this->input->post("valorprev")[$j])) {
                                $retorno = $this->Tb_cronogramafinanceiro->insereCronogramaFinanceiro($dados);
                            }
                        }
                    }
                } 
            die(json_encode($retorno));
        }

//-------------------------------------------------botaoInsere------------------------------------------------------------------

    public function insereCronogramaFinanceiroObraVersao(){
        $dados["id_contrato_obra"] = $this->session->idContrato;  
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["versao"] = $this->input->post_get('versao');

        $DadosCronogramaFinanVersao = $this->Tb_cronogramafinanceiro->recuperaVersao($dados);

        if(!empty($DadosCronogramaFinanVersao)){ 

            foreach ($DadosCronogramaFinanVersao as $lista) {
                $dados["versao"] = $lista->versao;
                $dados["id_cronograma"] = $lista->id_cronograma;
                $dados["publicar_cronograma"] = $lista->publicar_cronograma;
                $dados["id_cronograma_financeiro_versao"] = $lista->id_cronograma_financeiro_versao;
            }
                    
                $dados["ano"] = $this->input->post_get("anoreferente");
                $dados["servico"] = $this->input->post_get("servico");

                    $dados["id_servico"] = $this->input->post_get("servico");
                    $dados["id_obra"] = $this->input->post_get("obra");
                    $dados["tipo"] = $this->input->post_get("tipo");

                for ($j = 1; $j <= 12; $j++) {
                    if (!empty($this->input->post("mes")[$j])) {
                        $dados["mes"] = $this->input->post("mes")[$j];
                        $dados["valorprev"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valorprev")[$j]));
                        if (!empty($this->input->post("valorprev")[$j])) {
                            $retorno = $this->Tb_cronogramafinanceiro->insereCronogramaFinanceiro($dados);
                        }
                    }
                } 
            die(json_encode($retorno));
        } 
    }

//-------------------------------------------------------------------------------------------------------------------------

    public function RecuperaCronogramaAgrupado_naopublicado() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_cronograma_financeiro_versao"] = $this->input->post_get("id_cronograma_financeiro_versao");

        $Dados = $this->Tb_cronogramafinanceiro->RecuperaCronogramaAgrupado_naopublicado($dados);   
        $retorno["data"] = Array();

        $conte = (count($Dados));

        if (!empty($Dados)) {
         $linha = 1;
         foreach ($Dados as $lista) {

            if ($lista->valor_previsto == $lista->valor_inicial){
                $publicar = "<button type='button' id='publicado_naopublicado_$linha' name='publicado_naopublicado_$linha' class='btn btn-default'  href='javascript:void(0);' onclick='PublicarCronograma_naopublicado(". $lista->id_cronograma."," . $lista->versao . ",".$lista->id_cronograma_financeiro_versao.")' data-toggle='tooltip' title='Publicar cronograma.' data-placement='top'><i class = 'fa fa-ship'></i></buttonx>";
            } else{
                $publicar = "<button href='javascript:void(0);' onclick='MsgPublicar(". $lista->id_cronograma."," . $linha . "," . $conte . ");' type='button' id='publicado_naopublicado_$linha' name='publicado_naopublicado_$linha' class='btn btn-default'  data-toggle='tooltip' title='Cronograma não pode ser publicado se o planejado não for igual ao total.' data-placement='top'>--</buttonx>";
            }

            $detalhar = "<button type='button' id='detalhar_naopublicado_$linha' name='detalhar_naopublicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaDetalhado_naopublicado(". $lista->id_cronograma."," . $linha . ",".$conte.")'><i class = 'fa fa-eye'></i></buttonx>";

            $inserir = "<button type='button' id='inserir_naopublicado_$linha' name='inserir_naopublicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='insere(". $lista->id_cronograma."," . $lista->versao . ")'><i class = 'fas fa-pencil-alt'></i></buttonx>";


            $retorno["data"][] = array(
                'n'=> $linha++,
                'total_pi_a'=> "R$".str_replace("-", ",", str_replace(",", ".", str_replace(".", "-",$lista->valor_inicial))),
                'valor_previsto'=> "R$".str_replace("-", ",", str_replace(",", ".", str_replace(".", "-",$lista->valor_previsto))),
                'versao'=> $lista->versao,
                'desc_nome'=> $lista->nome,
                'data_cronograma'=> $lista->ultima_alteracao,
                'publicado'=> "Não publicado", 
                'nome_publicar'=> "--",
                'data_publicar'=> "--",
                'cronograma'=> "Não publicado",
                'detalhar'=> $detalhar,
                'inserir'=> $inserir,
                'publicar'=> $publicar
            );
        }
    }
    echo (json_encode($retorno));
}


//-------------------------------------------------------------------------------------------------------------------------
    public function PublicarCronograma_naopublicado(){
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["versao"] = $this->input->post_get('versao');
        $dados["id_cronograma_financeiro_versao"] = $this->input->post_get('id_cronograma_financeiro_versao');

        $DadosSaldo = $this->Tb_cronogramafinanceiro->recuperaSaldo($dados);
        
        if(!empty($DadosSaldo)){
                $dados["valor_inicial_aditivo"] = $DadosSaldo[0]["valor_previsto"];
              
            if(isset($dados)){
                 $retorno = $this->Tb_cronogramafinanceiro->PublicarCronograma_naopublicado($dados);

                 echo (json_encode($retorno));
            }
        }
    }

//-------------------------------------------------------------------------------------------
    public function ContaNaoPublicado(){
        $dados["id_contrato_obra"] = $this->session->idContrato;

        $dadosContrato = $this->Tb_cronogramafinanceiro->ContaNaoPublicado($dados);
        foreach ($dadosContrato as $lista) {
            $dados['conte_naopublicado']= $lista->conte_naopublicado;  
        }
        echo (json_encode($dados));
    }

//---------------------------------------------------------------------------------------------

    public function recuperaCronograma() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["versao"] = $this->input->post_get('versao');
        $dados["id_cronograma_financeiro_versao"] = $this->input->post_get('id_cronograma_financeiro_versao');
        $excluir = $this->input->post_get("excluir");

        $Dados = $this->Tb_cronogramafinanceiro->recuperaCronograma($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
         $linha = 1;
         foreach ($Dados as $lista) {
         
            if ($excluir == 1){
                $acao = "<a data-toggle='tooltip' title='Editar' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick='RecuperaeditarCronograma(".$lista->id_cronograma_financeiro.")'> <i class='fa fa-pencil'></i></a>
                <a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);'
                 onclick='ExcluirAvancoExternoPublicado(" . $lista->id_cronograma_financeiro . ");'><i class='fa fa-trash'></i></a>";
            } 
            elseif ($excluir == 2){
                $acao = "<a data-toggle='tooltip' title='Editar' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick='RecuperaeditarCronograma(".$lista->id_cronograma_financeiro.")'> <i class='fa fa-pencil'></i></a>
                <a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);'
                 onclick='ExcluirAvancoInternoIncluir(" . $lista->id_cronograma_financeiro . ");'><i class='fa fa-trash'></i></a>";
            } else {
                    $acao ="<i class='fa fa-trash' title='Cronograma Publicado'></i>";
                }

                  if ($lista->tipo_obra == ''){
                    $lista->tipo_obra = "--";
                }

            $retorno["data"][] = array(
                'n'=> $linha++,
                'obra'=> $lista->desc_obra,
                'servico'=> $lista->desc_servico,
                'tipo'=> $lista->tipo_obra,
                'ano'=> $lista->ano,
                'mes'=> $lista->mes,
                'valor_previsto'=> "R$".str_replace("-", ",", str_replace(",", ".", str_replace(".", "-",$lista->valor_previsto))),
                'usuario'=> $lista->nome,
                'versao'=>  $lista->versao, 
                'publicar'=> $lista->publicar_versao,
                'ultima_alteracao'=> $lista->ultima_alteracao,
                'acao'=> $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

//---------------------------------------------------------------------------------------------------------------------------
    public function RecuperaeditarCronograma() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_cronograma_financeiro"] = $this->input->post_get("id_cronograma_financeiro");

        $Dados = $this->Tb_cronogramafinanceiro->RecuperaeditarCronograma($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                // setlocale(LC_MONETARY,"pt_BR");
                // money_format("The price is %i", $number);
                $valor_p = str_replace("-", ",", str_replace(",", ".", str_replace(".", "-",$lista->valor_previsto)));
                $retorno["data"][] = array(
                    'valor_previsto'=> "<input maxlength='20' onkeydown='FormataMoeda(this, 15, event)' onkeypress='return maskKeyPress(event)' type='text' name='valor_previsto' id='valor_previsto' placeholder=$valor_p>" ,
                    'usuario'=> $lista->nome,
                    'versao'=>  $lista->versao, 
                    'publicar'=> "Não publicado",
                    'ultima_alteracao'=> $lista->ultima_alteracao,
                    'cronograma'=> "Não publicado"
                );
            }
        }
        echo (json_encode($retorno));
    }

//-------------------------------------------------------------------------------------------------------------------------

    public function RecuperaCronogramaAgrupado_publicado() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_cronograma_financeiro_versao"] = $this->input->post_get("id_cronograma_financeiro_versao");

        $Dados = $this->Tb_cronogramafinanceiro->RecuperaCronogramaAgrupado_publicado($dados);   
        $retorno["data"] = Array();

        $conte = (count($Dados));

        if (!empty($Dados)) {
         $linha = 1;
         foreach ($Dados as $lista) {

            $detalhar = "<button type='button' id='detalhar_$linha' name='detalhar_$linha' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaDetalhado_publicado(". $lista->id_cronograma."," . $linha . ",".$conte.")'><i class = 'fa fa-eye'></i></buttonx>";

            $inserir = "<button type='button' id='inserir_$linha' name='inserir_$linha' class='btn btn-warning' data-toggle='tooltip' title='Cronograma publicado não pode ser alterado.' data-placement='top'>- -</buttonx>";

            $publicar = "<button type='button' id='publicado_$linha' name='publicado_$linha' class='btn btn-primary' data-toggle='tooltip' title='Cronograma publicado não pode ser alterado.' data-placement='top'><i class = 'fa fa-ship'></i></buttonx>";


            $retorno["data"][] = array(
                'n'=> $linha++,
                'total_pi_a'=> "R$".str_replace("-", ",", str_replace(",", ".", str_replace(".", "-",$lista->valor_inicial))),
                'valor_previsto'=> "R$".str_replace("-", ",", str_replace(",", ".", str_replace(".", "-",$lista->valor_previsto))),
                'versao'=> $lista->versao,
                'desc_nome'=> $lista->nome,
                'data_cronograma'=> $lista->ultima_alteracao,
                'publicado'=> "Publicado", 
                'nome_publicar'=> $lista->nome_publi,
                'data_publicar'=> $lista->data_publicar,
                'cronograma'=> "Publicado",
                'detalhar'=> $detalhar,
                'inserir'=> $inserir,
                'publicar'=> $publicar
                );
            }
        }
        echo (json_encode($retorno));
    }
//------------------------------------------------------------------------------------------------------------------------------

    public function excluirAvanco(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_cronograma_financeiro"] = $this->input->post_get('id_cronograma_financeiro');

        $retorno = $this->Tb_cronogramafinanceiro->excluirAvanco($dados);
        
        echo (json_encode($retorno));

    }

//--------------------------------------------------------------------------------------------------------------------------------
     public function editarCronograma(){
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma_financeiro"] = $this->input->post_get('id_cronograma');
        $dados["valor_previsto"] = str_replace(",", ".", str_replace(".", "", $this->input->post_get('valor_previsto')));
            $retorno = $this->Tb_cronogramafinanceiro->editarCronograma($dados);
        echo (json_encode($retorno));
    }


}//Fecha Classe
//######################################################################################################################################################################################################################## 
//# DNIT - Falconi-AQUAVIARIO
//# Cronogramafinanceiroctr.php
//# Desenvolvedora:Jordana de Alencar
//# Data: 09/03/2020 19:35
//########################################################################################################################################################################################################################
