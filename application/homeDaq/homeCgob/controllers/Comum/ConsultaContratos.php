<?php

//use core\controllers\ControllerJWTAuthCgmrrRelatorioMensal;
//use core\controllers\ControllerJWTAuthAuth;

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RelatorioSupervisao
 *
 * @author herisson.c.silva
 */
class ConsultaContratos extends \core\controllers\ControllerJWTAuth {

    function __construct() {
        parent::__construct();
    }
    
    public function consultaContrato() 
    {
        // CGMRR e CGCONT
        $this->load->model('Comum/ConsultaContratosModel');
        
        $mensagem = null;
        $error = false;
        
        $resposta = $this->ConsultaContratosModel->getContratosAndEixos_ws_core($error,$mensagem);
        
        $resposta = $this->tratamento_resposta_ws(!$error, $mensagem, $resposta);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($resposta));
    }


    public function tratamento_resposta_ws($status, $mensagem, $dados) {
        $resposta = array
            (
            "status" => $status,
            "mensagem" => $mensagem,
            "resultado" => $dados
        );
        return $resposta;
    }

}
