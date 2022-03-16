<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RelatorioLevantamentoHidrografico extends CI_Controller {

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

	 public function insereRelatorioLevantamentoHidrografico() {
		$dados["resumo"] = $this->input->post_get('numeroSeiRelatorioLevantamentoHidrografico');
		$dados["id_resumo"] = $this->input->post_get('id_resumo');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["roteiro"] = "38";
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["idContrato"] = $this->session->idContrato;
		if (empty($dados["id_resumo"])) {
			$retorno = $this->Tb_resumo->insereResumo($dados);
		}
		echo (json_encode($retorno));
	}

    public function recuperaRelatorioLevantamentoHidrografico() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "38";
        
        $Dados = $this->Tb_resumo->Recuperaresumo($dados);   
        $retorno["data"] = Array();
      
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirResumo(" . $lista->id_resumo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
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

    public function excluirRelatorioLevantamentoHidrografico() {
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
        $retorno = $this->Tb_resumo->excluirResumo($dados);
        echo (json_encode($retorno));
    }

	public function insereNaoAtividade(){
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["roteiro"] = "38";
		$retorno = $this->Tb_resumo->insereNaoAtividade($dados);
		echo (json_encode($retorno));
	}

	public function confereAtividade()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["roteiro"] = "38";

		$DadosControle = $this->Tb_resumo->recuperaPGQ($dados);
		$dados["data"] = array();

		$dadosNaoAtividade = $this->Tb_resumo->confereAtividade($dados);
		if (!empty($DadosControle)) {
			$dados["situacao"] = 'Com Atividade';
		} else if (!empty($dadosNaoAtividade) && $dadosNaoAtividade[0]->situacao != 'Sem Registros') {
			$dados["situacao"] = 'Sem Atividade';
		} else {
			$dados["situacao"] = 'Sem Registros';
		}
		echo(json_encode($dados));
	}

}
