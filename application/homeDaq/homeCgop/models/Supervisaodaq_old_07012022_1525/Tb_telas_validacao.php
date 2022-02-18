<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_telas_validacao extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

	public function busca_validacao_tela($dados){
		$SQL = "SELECT * FROM CGOB_TB_TELAS_FORMULARIO as tf
				INNER JOIN CGOB_TB_TELAS_VALIDACAO AS tv 
					ON tv.id_tela_formulario = tf.id_tela_formulario
				WHERE validar_formulario = 'S'
				AND tf.id_tela_formulario = " . $dados['id_tela_formulario'] ."
				AND tv.periodo = '" . $dados['periodo'] ."'
				AND tv.id_contrato_obra = " . $this->session->idContrato;
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function inserir_validacao($dados){
		$dados['id_contrato_obra'] = $this->session->idContrato;
		$dadosValidacao = $this->busca_validacao_tela($dados);

		if(isset($dados['nome_usuario'])){
			$SQL = "SELECT id_usuario FROM TB_USUARIO WHERE DESC_NOME LIKE '%".$dados['nome_usuario']."%'";
			$query = $this->db->query($SQL);
			$dadosUsuario =  $query->result();
			$dados['id_usuario'] = $dadosUsuario[0]->id_usuario;
		}

		if(count($dadosValidacao) == 0){
			$this->inserir($dados);
		}else{
			$dados['id_tela_validacao'] = $dadosValidacao[0]->id_tela_validacao;
			$this->alterar($dados);
		}
	}

	public function inserir($dados){
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("id_usuario", (isset($dados['id_usuario'])) ? $dados['idUsuario'] : $this->session->id_usuario_daq_cgop);
		$this->db->set("id_tela_formulario", $dados["id_tela_formulario"]);
		$data_alteracao = (isset($dados['data_ultima_alteracao'])) ? date("Y-m-d H:i:s", strtotime(str_replace("/", "-", ($dados['data_ultima_alteracao'])))) : date("Y-m-d H:i:s");
		$this->db->set("data_ultima_alteracao", $data_alteracao);
		$this->db->set("id_contrato_obra", $this->session->idContrato);
		$this->db->set("periodo", $dados["periodo"]);
		$this->db->set("id_usuario_analise", "");
		$this->db->set("data_analise", "");

		$this->db->insert("CGOB_TB_TELAS_VALIDACAO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function alterar($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set("id_usuario", (isset($dados['id_usuario'])) ? $dados['id_usuario'] : $this->session->id_usuario_daq_cgop);
		$data_alteracao = (isset($dados['data_ultima_alteracao'])) ? date("Y-m-d H:i:s", strtotime(str_replace("/", "-", ($dados['data_ultima_alteracao'])))) : date("Y-m-d H:i:s");
		$this->db->set("data_ultima_alteracao", $data_alteracao);
		$this->db->set("id_usuario_analise", null);
		$this->db->set("data_analise", null);
		$this->db->where("id_tela_formulario", $dados['id_tela_formulario']);
		$this->db->where("periodo", $dados['periodo']);
		$this->db->where("data_ultima_alteracao < '" . $data_alteracao . "'");

		$this->db->update("CGOB_TB_TELAS_VALIDACAO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function limparValidacao($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$dados['id_contrato_obra'] = (isset($dados['id_contrato_obra'])) ? $dados['id_contrato_obra'] : $this->session->idContrato;
		$this->db->where("id_tela_formulario", $dados['id_tela_formulario']);
		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("periodo", $dados['periodo']);

		$this->db->delete("CGOB_TB_TELAS_VALIDACAO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function busca_qtd_validacoes(){
		$SQL = "SELECT * FROM CGOB_TB_TELAS_FORMULARIO as tf
				WHERE validar_formulario = 'S'";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function busca_tela($dados){
		$SQL = "SELECT * FROM CGOB_TB_TELAS_FORMULARIO as tf
				INNER JOIN CGOB_TB_TELAS_VALIDACAO AS tv
					ON tv.id_tela_formulario = tf.id_tela_formulario
				WHERE validar_formulario = 'S'
				AND tv.id_contrato_obra = " . $this->session->idContrato ."
				AND tv.periodo = '" . $dados["periodo"] . "' ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function valida_formulario($dados){
		$dados['id_contrato_obra'] = $this->session->idContrato;
		$dados['periodo'] = $dados["periodo"];
		$quantidadeTelas = $this->busca_qtd_validacoes();
		$telas_validadas = $this->busca_tela($dados);

		if(count($quantidadeTelas) == count($telas_validadas) ){
			return count($telas_validadas);
		}else{
			return count($telas_validadas);
		}
	}

	public function buscaTelas(){
		$SQL = "SELECT * FROM CGOB_TB_TELAS_FORMULARIO as tf
				WHERE validar_formulario = 'S'";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function BuscaValidacao($dados){
		$SQL = "SELECT tv.*, us.*, us2.DESC_NOME as nome_analise FROM CGOB_TB_TELAS_VALIDACAO as tv
					INNER JOIN TB_USUARIO us ON us.id_usuario = tv.id_usuario
					LEFT JOIN TB_USUARIO us2 ON us2.id_usuario = tv.id_usuario
				WHERE tv.id_contrato_obra = " . $this->session->idContrato ."
				AND tv.periodo = '" . $dados["periodo"] . "' 
				AND tv.id_tela_formulario = " . $dados['id_tela_formulario'];
                //echo('<pre>');
                //die($SQL);
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function busca_tela_analise($dados){
                if(!empty($this->session->idContrato)){
                    $idContrato=$this->session->idContrato;
                }
                if(!empty($dados['id_contrato_obra'])){
                    $idContrato=$dados['id_contrato_obra'];
                }
               
		$SQL = "SELECT * FROM CGOB_TB_TELAS_FORMULARIO as tf
				INNER JOIN CGOB_TB_TELAS_VALIDACAO AS tv
					ON tv.id_tela_formulario = tf.id_tela_formulario
				LEFT JOIN TB_USUARIO as us ON us.id_usuario = tv.id_usuario
				LEFT JOIN TB_USUARIO as us2 ON us2.id_usuario = tv.id_usuario_analise
				WHERE validar_formulario = 'S'
				AND tv.id_contrato_obra = " . $idContrato ."
				AND tv.periodo = '" . $dados["periodo"] . "' ";
               // echo('<pre>');
               // die($SQL);
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function insereAnalise($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set("id_usuario_analise", $dados['idUsuario']);
		$this->db->set("data_analise", date("Y-m-d H:i:s"));

		$this->db->where("id_tela_formulario", $dados['id_tela_formulario']);
		$this->db->where("id_contrato_obra", $dados['id_contrato']);
		$this->db->where("periodo", $dados['periodo']);

		$this->db->update("CGOB_TB_TELAS_VALIDACAO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Pedro Henrique
//# Data: 25/12/2021 14:00
//########################################################################################################################################################################################################################
