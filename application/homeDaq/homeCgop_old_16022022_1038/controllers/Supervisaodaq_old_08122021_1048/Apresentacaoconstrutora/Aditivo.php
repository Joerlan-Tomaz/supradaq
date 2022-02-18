<?php
/*
 * Classe controller Aditivo. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Aditivo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_apresentacao_construtora_aditivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

//-------------------------------------------Insere-----------------------------------------

    public function insereAditivo() {
        $dados["id_termo_aditivo"] = $this->input->post_get('id_termo_aditivo');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_apresentacao"] = $this->input->post_get('id_apresentacao');
        $dados["roteiro"] = "18";
        
        $dados["numero_termo"] = $this->input->post_get('numero_termo');
        $dados["desc_objeto_termo"] = $this->input->post_get('objeto_termo');
        $dados["dias_aditados"] = $this->input->post_get('dias_aditados_ta');
        //$dados["valor_aditado"] = $this->input->post_get('valor_aditado');
        $dados["valor_aditado"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor_aditado")));
        $dados["valor_atualizado"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor_atualizado_ta")));
        //$dados["valor_atualizado"] = $this->input->post_get('valor_atualizado_ta');
        $dados["desc_motivacao_aditivo"] = $this->input->post_get('motivacao_aditivo');

        $dados["data_assinatura"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_assinatura_ta")))));
        $dados["data_termino_atualizada"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_termino_atualizada_ta")))));
      

        if (empty($dados["id_termo_aditivo"])) {
            $retorno = $this->Tb_apresentacao_construtora_aditivo->insereAditivo($dados);
        }
        echo (json_encode($retorno));
                        
    }

//-------------------------------------------Recupera-----------------------------------------


 public function Tableaditivo() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "18";

        $Dados = $this->Tb_apresentacao_construtora_aditivo->Tableaditivo($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {

                $descricao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick ='modalObjetoMotivacaoAditivo(".$lista->id_termo_aditivo.")'><i class = 'fa fa-eye'></i></button >";

                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirAditivo(".$lista->id_termo_aditivo.");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";

                $retorno["data"][] = array(

                    'NUMERO_TERMO'=> $lista->numero_termo,
                    'DATA_ASSINATURA'=> $lista->data_assinatura,
                    'OBJETO_TERMO'=>$descricao, 
                    'DIAS_ADITADOS'=>$lista->dias_aditados,
                    'VALOR_ADITADO'=> "R$".number_format($lista->valor_aditado,2,",","."), 
                    'USUARIO'=> $lista->nome,
                    'PERIODO_REFERENCIA'=>$lista->periodo_referencia,
                    'ATUALIZACAO'=> $lista->atualizacao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }


      public function modalObjetoMotivacaoAditivo() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["id_termo_aditivo"] = $this->input->post_get('id_termo_aditivo');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["roteiro"] = "18";

        $DadosServico = $this->Tb_apresentacao_construtora_aditivo->modalObjetoMotivacaoAditivo($dados);

        foreach ($DadosServico as $lista) {
            $dados['objeto']= $lista->desc_objeto_termo;
            $dados['motivacao']= $lista->desc_motivacao_aditivo;
        }
        echo (json_encode($dados));
    }

      public function excluirAditivo() {
        $dados["id_termo_aditivo"] = $this->input->post_get('id_termo_aditivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_apresentacao_construtora_aditivo->excluirAditivo($dados);
        echo (json_encode($retorno));
    }




}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 15/01/2020 13:00
//########################################################################################################################################################################################################################
