<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Imprimirrelatorioctr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_relatorio');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
//----------------------------------------------------View------------------------------------------------------
   


}
