<?php
/*
 * Classe controller Dadoscontratoctr. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, FALCONI | DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Dadoscontratoctr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_dados_contrato');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }


//-------------------------------------------------------------------------------------------------------
public function adicionaDadosInicio() {  
    $dados["idContrato"] = $this->session->idContrato;
    $DadosInicio = $this->Tb_dados_contrato->adicionaDadosInicio($dados);

    $retorno["data"] = Array();
    foreach ($DadosInicio as $lista) {
            if($lista->atacado == ''){
                $lista->atacado = '0';
            }
            //  if($lista->extensao_previsto == ''){
            //     $lista->extensao_previsto = '00';
            // }
        $retorno["data"][] = array(
        $dados["nome_obra"] = $lista->nome_obra,
        $dados["nome_servico"] = $lista->nome_servico,
        $dados["previsto"] = $lista->valor_cronograma,
        $dados["atacado"] = $lista->atacado,
        $dados["executado"] = 0,
        $dados["extesao_total"] = $lista->valor_cronograma,
        $dados["unidade_medida"] = $lista->unidade_medida
       );
    }
    echo (json_encode($retorno)); 
}

//-------------------------------------------------------------------------------------------------------
}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT-Falconi AQUAVIARIO
//# Dadoscontratoctr.php
//# Desenvolvedora:Jordana Alencar
//# Data: 27/05/2020 19:00
//# Data: 04/08/2020 06:00
//########################################################################################################################################################################################################################
