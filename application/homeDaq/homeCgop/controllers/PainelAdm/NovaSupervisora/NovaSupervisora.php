<?php

defined('BASEPATH') or exit('No direct script access allowed');

class NovaSupervisora extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Tb_usuario');
        $this->load->model('CadastraSolicitacaoAcesso/Tb_nova_supervisora');
        // $this->load->model('Tb_uf');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
    }
    
    public function mostraViewNovaSupervisora(){
        // $this->load->view('homeDaq/homeAdministracao/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissaoView');
        $this->load->view('/homeAdministracao/NovaSupervisora/NovaSupervisoraView');
    }

    public function RecuperaSupervisora() {
        $info_supervisora = $this->Tb_nova_supervisora->RecuperaSupervisora();
        $retorno["data"] = array();
        foreach ($info_supervisora as $lista){
            $retorno['data'][] = array(
                'id_supervisora' => $lista->id_supervisora,
                'nome_supervisora' => $lista->nome_supervisora,
                'data_criacao' => $lista->data_criacao,
            );
        }
        echo (json_encode($retorno));
    }

    public function insereNovasupervisora() {
        $dados["nome"] = $this->input->post_get('nome_novaSupervisora');
        $this->Tb_nova_supervisora->insereNovasupervisora($dados);
        echo (json_encode($dados));
    }
}
