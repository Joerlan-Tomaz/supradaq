<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_licencas_ambientais extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}


	//---------------------------------------------------------------------------------------

	public function populaTipoLicenca()
	{
		$this->db->select("*");
		//$this->db->where("publicar", "S");
		$this->db->from("CGOB_TB_TIPO_LICENCA_AMBIENTAL");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	public function populaNomeInfra()
	{
		$SQL = "SELECT geo.nome_eixo
				FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO as geo
				WHERE (geo.publicar = 'S' OR geo.publicar IS NULL)
					AND id_contrato_obra = {$this->session->idContrato}
				GROUP BY geo.nome_eixo";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function insereLicencasAmbientais($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("id_contrato_obra", $dados["idContrato"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);

		if (!empty($dados["num_licenca_ambiental"])) {
			$this->db->set("num_licenca_ambiental", $dados["num_licenca_ambiental"]);
		}
		if (!empty($dados["orgao_emissor"])) {
			$this->db->set("orgao_emissor", $dados["orgao_emissor"]);
		}
		if (!empty($dados["data_emissao"])) {
			$this->db->set("data_emissao", $dados["data_emissao"]);
		}
		if (!empty($dados["inicio_vigencia"])) {
			$this->db->set("inicio_vigencia", $dados["inicio_vigencia"]);
		}
		if (!empty($dados["termino_vigencia"])) {
			$this->db->set("termino_vigencia", $dados["termino_vigencia"]);
		}
		if (!empty($dados["data_solicitacao"])) {
			$this->db->set("data_solicitacao", $dados["data_solicitacao"]);
		}
		if (!empty($dados["renovacao_solicitada"])) {
			$this->db->set("renovacao_solicitada", $dados["renovacao_solicitada"]);
		}
		if (!empty($dados["resumo_licenca_ambiental"])) {
			$this->db->set("resumo_licenca_ambiental", $dados["resumo_licenca_ambiental"]);
		}
		if (!empty($dados["condicionantes_ambientais"])) {
			$this->db->set("condicionantes_ambientais", $dados["condicionantes_ambientais"]);
		}
		if (!empty($dados["tipo"])) {
			$this->db->set("id_tipo_licenca", $dados["tipo"]);
		}
		if (!empty($dados["id_arquivo"])) {
			$this->db->set("id_arquivo", $dados["id_arquivo"]);
		}
		if (!empty($dados["nome_infraestrutura"])) {
			$this->db->set("nome_infraestrutura", $dados["nome_infraestrutura"]);
		}

		$this->db->set("publicar", "S");
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->insert("CGOB_TB_LICENCAS_AMBIENTAIS");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function recuperaLicencasAmbientais($dados)
	{
		$SQL = "
          SELECT
            l.id_licenca_ambiental,
            l.num_licenca_ambiental as licenca,
            l.orgao_emissor,
            convert(varchar(10),l.data_emissao,103) AS data_emissao,
            l.termino_vigencia,
            l.condicionantes_ambientais,
            s.desc_tipo_licenca as tipo,
            a.id_arquivo,
            convert(varchar(10),l.inicio_vigencia,103) AS vigencia,
            l.renovacao_solicitada as solicitadarenovada,
            l.resumo_licenca_ambiental as resumo,
            a.nomeOriginalArquivo,
            a.nome_arquivo,
            convert(varchar(10),l.periodo_referencia,103) AS referencia,
            (select DESC_NOME from TB_USUARIO where id_usuario=l.id_usuario) as nome,
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao,
            nome_infraestrutura
            FROM CGOB_TB_LICENCAS_AMBIENTAIS AS l
            INNER JOIN CGOB_TB_TIPO_LICENCA_AMBIENTAL AS s ON s.id_tipo_licenca = l.id_tipo_licenca
            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
        WHERE (l.publicar like '%S%')
        ";


		if (!empty($dados["id_licenca_ambiental"])) {
			$SQL .= " AND l.id_licenca_ambiental = '" . $dados["id_licenca_ambiental"] . "' ";
		}

		if (!empty($dados["idContrato"])) {
			$SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
		}

		$SQL .= " ORDER BY l.ultima_alteracao DESC";
		//echo('<pre>');
		//die($SQL);
		$query = $this->db->query($SQL);
		return $query->result();
	}


	public function RecuperaLicencaEditar($dados)
	{
		$SQL = "
          SELECT
            r.id_licenca_ambiental,
            r.num_licenca_ambiental,
            r.orgao_emissor,
            convert(varchar(10),r.data_emissao,103) AS data_emissao,
            convert(varchar(10),r.termino_vigencia,103) AS termino_vigencia,
            convert(varchar(10),r.inicio_vigencia,103) AS inicio_vigencia,
            convert(varchar(10),r.data_solicitacao,103) AS data_solicitacao, 
            r.renovacao_solicitada,
            r.resumo_licenca_ambiental,
            r.condicionantes_ambientais,
            s.id_tipo_licenca
            FROM CGOB_TB_LICENCAS_AMBIENTAIS AS r
            INNER JOIN CGOB_TB_TIPO_LICENCA_AMBIENTAL AS s ON s.id_tipo_licenca = r.id_tipo_licenca
            
        WHERE r.id_licenca_ambiental ='" . $dados["id_licenca_ambiental"] . "'";

		$query = $this->db->query($SQL);
		return $query->result();
	}


	public function editarLicencaAmbiental($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->where("id_licenca_ambiental", $dados["id_licenca_ambiental"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);

		if (!empty($dados["num_licenca_ambiental"])) {
			$this->db->set("num_licenca_ambiental", $dados["num_licenca_ambiental"]);
		}
		if (!empty($dados["orgao_emissor"])) {
			$this->db->set("orgao_emissor", $dados["orgao_emissor"]);
		}

		if (!empty($dados["data_emissao"])) {
			$this->db->set("data_emissao", $dados["data_emissao"]);
		}
		if (!empty($dados["inicio_vigencia"])) {
			$this->db->set("inicio_vigencia", $dados["inicio_vigencia"]);
		}
		if (!empty($dados["termino_vigencia"])) {
			$this->db->set("termino_vigencia", $dados["termino_vigencia"]);
		}
		if (!empty($dados["data_solicitacao"])) {
			$this->db->set("data_solicitacao", $dados["data_solicitacao"]);
		}

		if (!empty($dados["renovacao_solicitada"])) {
			$this->db->set("renovacao_solicitada", $dados["renovacao_solicitada"]);
		}
		if (!empty($dados["resumo_licenca_ambiental"])) {
			$this->db->set("resumo_licenca_ambiental", $dados["resumo_licenca_ambiental"]);
		}
		if (!empty($dados["condicionantes_ambientais"])) {
			$this->db->set("condicionantes_ambientais", $dados["condicionantes_ambientais"]);
		}
		if (!empty($dados["tipo"])) {
			$this->db->set("id_tipo_licenca", $dados["tipo"]);
		}
		if (!empty($dados["id_arquivo"])) {
			$this->db->set("id_arquivo", $dados["id_arquivo"]);
		}

		$this->db->update("CGOB_TB_LICENCAS_AMBIENTAIS");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}


	public function excluirArquivo($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_licenca_ambiental", $dados['id_licenca_ambiental']);
		$this->db->where("id_arquivo", $dados['id_arquivo']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicacao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_LICENCAS_AMBIENTAIS");

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


}//fecha model
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
