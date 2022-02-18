<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class AtividadesConstrutora extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_resumo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
  
    #-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
    public function RecuperaAtividadesConstrutora() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "12";
        
        $Dados = $this->Tb_resumo->Recuperaresumo($dados);   
        $retorno["data"] = Array();
      
        if (!empty($Dados)) {
            foreach ($Dados as $i => $lista) {
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='editarAtividadeConstrutora(" . $lista->id_resumo . ");' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fa fa-pencil'></i></button>";
                $acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirAtividadeConstrutora(" . $lista->id_resumo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'RESUMO' => $lista->resumo,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao, 
                    'ACAO' => $acao
                );

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '23';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
            }
		} else {
			$dados["id_tela_formulario"] = '23';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
        echo (json_encode($retorno));
    }


    public function insereAtividadesConstrutora() {
        $dados["resumo"] = $this->input->post_get('servicoExecutado');
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["roteiro"] = "12";
        $dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
        $dados["idContrato"] = $this->session->idContrato;

        if (!empty($dados["id_resumo"])) {
            $retorno = $this->Tb_resumo->alteraResumo($dados);
        } else {
            $retorno = $this->Tb_resumo->insereResumo($dados);
        }

		$dados["id_tela_formulario"] = 23;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);
        echo (json_encode($retorno));
    }

    public function editarAtividadeConstrutora() {
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $Recuperaresumo = $this->Tb_resumo->Recuperaresumo($dados);
        foreach ($Recuperaresumo as $r) {
            $dados["resumo"] = $r->resumo;
        }
        echo (json_encode($dados));
    }

    public function excluirAtividadeConstrutora() {
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
        $retorno = $this->Tb_resumo->excluirResumo($dados);
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
