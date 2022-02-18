<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class JustificativaEmpreendimentos extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_resumo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
  
    #-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
    public function recuperaJustificativa() {
        $dados["idContrato"] = $this->session->idContrato;
        //$dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "14";

        $Dados = $this->Tb_resumo->Recuperaresumo($dados);   
        $retorno["data"] = Array();
      
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='editarJustificativa(" . $lista->id_resumo . ");' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fa fa-pencil'></i></button>";
                $acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirJustificativa(" . $lista->id_resumo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'RESUMO' => $lista->resumo,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao, 
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }


    public function insereResumo() {
        $dados["resumo"] = $this->input->post_get('descricao_config_justificativa');
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["roteiro"] = "14";
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["idContrato"] = $this->session->idContrato;

        if (!empty($dados["id_resumo"])) {
            $retorno = $this->Tb_resumo->alteraResumo($dados);
        } else {
            $retorno = $this->Tb_resumo->insereResumo($dados);
        }
        echo (json_encode($retorno));
    }

    public function editarResumo() {
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $Recuperaresumo = $this->Tb_resumo->Recuperaresumo($dados);
        foreach ($Recuperaresumo as $r) {
            $dados["resumo"] = $r->resumo;
        }
        echo (json_encode($dados));
    }

    public function excluirResumo() {
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_resumo->excluirResumo($dados);
        echo (json_encode($retorno));
    }


}
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
