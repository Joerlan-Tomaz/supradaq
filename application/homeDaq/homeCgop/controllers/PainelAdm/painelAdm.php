<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supervisaodaqctr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_contrato_obra');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    public function homePainelAdm() {
        $this->load->view('homePainelAdm');
    }
}
