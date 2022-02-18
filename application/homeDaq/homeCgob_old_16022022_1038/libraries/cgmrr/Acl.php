<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author herisson.c.silva
 */
class Acl {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('table_model');
        $this->CI->load->model('homeCgmrr/tb_contratos');
        $this->CI->load->model('homeCgmrr/tb_permissoes');
    }

    public function init() {
        $this->tela();
        $this->contrato();
    }

    public function contrato() {
        if (isset($this->CI->session->id_usuario) && isset($this->CI->session->idContrato) && !$this->CI->tb_contratos->validaContratoUsuario($this->CI->session->id_usuario, $this->CI->session->idContrato)) {
            if (!is_null($this->CI->input->get_request_header("token"))) {
                $this->CI->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array("status" => false, "mensagem" => "Usuário sem permissão para acessar este contrato.")))->_display();
                $this->CI->session->sess_destroy();
                exit;
            } elseif ($this->CI->input->is_ajax_request()) {
                $this->CI->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array("status" => false, "mensagem" => "Usuário sem permissão para acessar este contrato.")))->_display();
                exit;
            } else {
                $this->CI->session->unset_userdata(array('idContrato', 'num_contrato'));
                redirect(base_url('/cgmrr/relatorio-supervisao?contrato=1'));
            }
        }
        return $this;
    }

    public function tela() {
        $permissoes = $this->CI->tb_permissoes->getAcessoSubModuloAndTela($this->CI->session->id_usuario, $this->CI->router->fetch_class(), $this->CI->router->fetch_method());
        if (count((array)$permissoes) == 0 || ($permissoes->visualizar==false || $permissoes->cadastrar_editar==false)) {
            if (!is_null($this->CI->input->get_request_header("token"))) {
                $this->CI->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array("status" => false, "mensagem" => "Usuário sem permissão para acessar esta página.")))->_display();
                $this->CI->session->sess_destroy();
                exit;
            } elseif ($this->CI->input->is_ajax_request()) {
                $this->CI->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array("status" => false, "mensagem" => "Usuário sem permissão para acessar esta página.")))->_display();
                exit;
            } else {
                echo $this->CI->load->template('home', 'homeCgmrr/relatorioSupervisao/sem_permissao', array(), array(), TRUE);
                exit;
            }
        }
    }

}
