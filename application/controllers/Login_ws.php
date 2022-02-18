<?php

use core\controllers\ControllerJWTAuth;

defined('BASEPATH') or exit('No direct script access allowed');

class Login_ws extends ControllerJWTAuth {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('array');
        $this->load->helper('verify_key_exists_and_return_identity_value');
    }

    public function informacao_usuario_ws() {

        $retorno["desc_nome"] = $this->session->desc_nome;
        $retorno["id_perfil"] = $this->session->id_perfil;
        $retorno["email"] = $this->session->email;
        $retorno["id_usuario"] = $this->session->id_usuario;
        $retorno["dt_Ultacesso"] = $this->session->dt_Ultacesso;
        $retorno["empresa"] = $this->session->empresa;
        $retorno["periodo_referencia"] = $this->session->periodo_referencia;
        $retorno["idContrato"] = $this->session->idContrato;
        $retorno["telefone"] = $this->session->telefone;
        $retorno["cpf"] = $this->session->cpf;

        $this->load->helper('tratamento_resposta_ws');
        $retorno = tratamento_resposta_ws(true, null, $retorno);
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($retorno));
    }

}
