<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Localizacao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora_localizacao');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }


    //-------------------------------------------Insere-----------------------------------------

    public function insereLocalizacao() {
        $dados["id_localizacao"] = $this->input->post_get('id_localizacao');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
        $dados["roteiro"] = "19";
        $dados["id_apresentacao"] = $this->input->post_get('id_apresentacao');
        
        $dados["hidrovia"] = $this->input->post_get('hidrovia');
        $dados["pnv_inicial"] = $this->input->post_get('pnv_inicial');
        $dados["pnv_final"] = $this->input->post_get('pnv_final');
        $dados["coordenada_inicial"] = $this->input->post_get('coordenada_inicial');
        $dados["coordenada_final"] = $this->input->post_get('coordenada_final');
        $dados["extensao"] = $this->input->post_get('extensao');
        $dados["estaca_inicial"] = $this->input->post_get('estaca_inicial');
        $dados["estaca_final"] = $this->input->post_get('estaca_final');
        $dados["km_inicial"] = $this->input->post_get('km_inicial');
        $dados["km_final"] = $this->input->post_get('km_final');

        
        if (empty($dados["id_localizacao"])) {
            $retorno = $this->Tb_apresentacao_supervisora_localizacao->insereLocalizacao($dados);
        }
        echo (json_encode($retorno));
                        
    }

    //-------------------------------------------Recupera-----------------------------------------

    public function Tablelocalizacao() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "19";

        $Dados = $this->Tb_apresentacao_supervisora_localizacao->Tablelocalizacao($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {

                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirLocalizacao(".$lista->id_localizacao.");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";

                $retorno["data"][] = array(

                    'HIDROVIA'=> $lista->hidrovia,
                    'INICIAL'=> $lista->inicial,
                    'FINAL'=>$lista->final,
                    'KM_INICIAL'=>$lista->km_inicial,
                    'KM_FINAL' =>$lista->km_final,
                    'EXTENSAO'=>$lista->extensao, 
                    'USUARIO'=> $lista->nome,
                    'PERIODO_REFERENCIA'=>$lista->periodo_referencia,
                    'ATUALIZACAO'=> $lista->atualizacao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }


     public function excluirLocalizacao() {
        $dados["id_localizacao"] = $this->input->post_get('id_localizacao');
        $dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
        $retorno = $this->Tb_apresentacao_supervisora_localizacao->excluirLocalizacao($dados);
        echo (json_encode($retorno));
    }



}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 15/01/2020 13:00
//########################################################################################################################################################################################################################
