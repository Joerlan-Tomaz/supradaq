<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DadosSegmento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_dados_segmento');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    //------------------------------------------------------------------------------------
 #-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
    public function recuperaResumo() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");  
        $retorno["data"] = Array();
        $Dados = $this->Tb_dados_segmento->Recuperaresumo($dados); 
      
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
               
                $descricao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'modalStatus(". $lista->id_resumo.")'><i class = 'fa fa-eye'></i></button>";
                 $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirResumo(" . $lista->id_resumo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                 $km1 ="" . $lista->km_inicialS . "" . $lista->km_inicial . "";
                  $km2 ="" . $lista->km_finalS . "" . $lista->km_final . "";

                $retorno["data"][] = array(
                    'KMINICIAL' => $km1,
                    'KMFINAL' => $km2,
                    'UF' => $lista->uf,
                    'DESCRICAO' => $descricao,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

 public function modalStatus () {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["periodo"] = $this->input->post_get('periodo');

        $DadosServico = $this->Tb_dados_segmento->modalStatus($dados);

        foreach ($DadosServico as $lista) {
            $dados['descricao']= $lista->trecho;   
        }
        echo (json_encode($dados));
    }


    public function insereResumo() {
         $dados["trecho"] = $this->input->post_get('trecho');
        $dados["km_inicial"] = $this->input->post_get('kminicial');
        $dados["km_final"] = $this->input->post_get('kmfinal');

        $dados["km_inicialS"] = $this->input->post_get('kminicialS');
        $dados["km_finalS"] = $this->input->post_get('kmfinalS');

        $dados["uf"] = $this->input->post_get('tipo_documento');
       
        
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["periodo"] = $this->input->post_get('periodo');
        
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["idContrato"] = $this->session->idContrato;

        if (!empty($dados["id_resumo"])) {
            $retorno = $this->Tb_dados_segmento->alteraResumo($dados);
        } else {
            $retorno = $this->Tb_dados_segmento->insereResumo($dados);
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
        $retorno = $this->Tb_dados_segmento->excluirResumo($dados);
        echo (json_encode($retorno));
    }

    // public function insereNaoAtividade() {
    //     $dados["idContrato"] = $this->session->idContrato;
    //     $dados["idUsuario"] = $this->session->id_usuario;
    //     $dados["roteiro"] = "22";
    //     $dados["periodo"] = $this->input->post_get('periodo');
    //     $dados["flag_atividade"] = "Não houve atividade este mês";
    //     $retorno = $this->Tb_resumo->insereResumo($dados);
    //     echo (json_encode($retorno));
    // }

}
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
