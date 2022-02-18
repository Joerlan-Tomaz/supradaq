<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_AtasCorrespondencia extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}
	//---------------------------------------------------------------------------------------

	public function insereAtasCorrespondencias($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("id_contrato_obra", $dados["idContrato"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);

		if (!empty($dados["numero_documento"])) {
			$this->db->set("numero_documento", $dados["numero_documento"]);
		}
		if (!empty($dados["assunto"])) {
			$this->db->set("assunto", $dados["assunto"]);
		}
		if (!empty($dados["data_atividade"])) {
			$this->db->set("data_atividade", $dados["data_atividade"]);
		}
		if (!empty($dados["desc_atas_correspondecia"])) {
			$this->db->set("desc_atas_correspondecia", $dados["desc_atas_correspondecia"]);
		}

		if (!empty($dados["tipo"])) {
			$this->db->set("tipo_documento", $dados["tipo"]);
		}
		if (!empty($dados["id_arquivo"])) {
			$this->db->set("id_arquivo", $dados["id_arquivo"]);
		}

		$this->db->set("publicar", "S");
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->insert("CGOB_TB_ATAS_CORRESPONDENCIAS");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}


	public function recuperaAtasCorrespondencias($dados)
	{
		$SQL = "
	          SELECT
	            l.id_atas_correspondencias,
	            l.tipo_documento,
	            l.assunto,
	            l.desc_atas_correspondecia,
	            l.numero_documento,
	            l.id_arquivo,
	            a.nome_arquivo,
	            a.nomeOriginalArquivo,
	            u.DESC_NOME as nome,
	             concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao
	            FROM CGOB_TB_ATAS_CORRESPONDENCIAS AS l
	            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario
	            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
	        WHERE (l.publicar like '%S%' or l.publicar is NULL)
	        ";


		if (!empty($dados["id_atas_correspondencias"])) {
			$SQL .= " AND l.id_atas_correspondencias = '" . $dados["id_atas_correspondencias"] . "' ";
		}

		if (!empty($dados["idContrato"])) {
			$SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
		}

		if (!empty($dados["periodo"])) {
			$SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
		}

		$SQL .= " ORDER BY l.ultima_alteracao DESC";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function excluirArquivo($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_atas_correspondencias", $dados['id_atas_correspondencias']);
		$this->db->where("id_arquivo", $dados['id_arquivo']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicacao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_ATAS_CORRESPONDENCIAS");

		$this->db->where("id_arquivo", $dados['id_arquivo']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicacao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_ARQUIVO");


		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function insereNaoAtividade($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set('id_contrato_obra', $dados['idContrato']);
		$this->db->set('periodo_referencia', $dados['periodo']);
		$this->db->set('publicar', 'S');
		$this->db->set('flag_atividade', 'N');
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set('id_usuario', $dados['idUsuario']);

		$this->db->insert("CGOB_TB_ATAS_CORRESPONDENCIAS");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
	//----------------------------------------------------------------------------------------------------------------------
	public function buscaNaoAtividade($dados){
		$SQL = "
        SELECT
        id_atas_correspondencias as id 
        ,CASE WHEN flag_atividade = 'N' THEN 'Não houve atividade no mês' END atividademes
        ,CONCAT(CONVERT(CHAR(10), ultima_alteracao , 103),' ', CONVERT(CHAR(8), ultima_alteracao , 114)) AS ultima_alteracao
        ,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
        FROM CGOB_TB_ATAS_CORRESPONDENCIAS AS af
        WHERE publicar = 'S' AND flag_atividade = 'N' AND id_contrato_obra =" . $dados["idContrato"] ." AND periodo_referencia ='" .$dados["periodo"] ."'          
        ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function excluirNaoAtividade($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_atas_correspondencias", $dados['id']);
		$this->db->set('flag_atividade', 'S');
		$this->db->set("publicar", "N");
		$this->db->set("data_publicacao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_ATAS_CORRESPONDENCIAS");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
}//fecha model
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//######################################################################################################################################################################################################################## 
