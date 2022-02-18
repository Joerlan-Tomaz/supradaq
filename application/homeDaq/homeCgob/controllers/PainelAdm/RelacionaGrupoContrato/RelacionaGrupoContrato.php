<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RelacionaGrupoContrato extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Tb_usuario');
        // $this->load->model('homeDa/SolicitacaoAcesso/Tb_solicitacao_acesso');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
    }
    public function mostraViewRelacionaGrupoContrato(){
        $this->load->view('/homeAdministracao/RelacionaGrupoContrato/relacionaGrupoContratoView');
    }


}
