<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Administracaoctr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
    }

    public function solicitacaoAcesso() {
        $this->load->view('/homeAdministracao/Solititaacesso/solititaAcessoView');
    }

}
