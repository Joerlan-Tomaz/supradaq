<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Consulta_Contrato_SIAC extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Comum/ConsultaContratoSIACModel', 'contrato');
    }

    public function consultaContratoSIAC() {
        $dados['contrato'] = $this->input->post_get("contrato");
        $arrContratos = $this->contrato->consultaContratoSIAC($dados);
        if (empty($arrContratos)) {
            $arrContratos = 0;
        }
        echo json_encode($arrContratos);
    }

    public function consultaContratoSIAC_SK_CONTRATO() {
        $dados['contrato'] = $this->input->post_get("codigoSKContrato");
        $arrContratos = $this->contrato->consultaContratoSIAC_SK_CONTRATO($dados);
        //echo '<pre>'; print_r($arrContratos); die;
        echo json_encode($arrContratos);
    }

}
