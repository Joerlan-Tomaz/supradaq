<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_controle_fluviometrico extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}


//---------------------------------------------------------------------------------------------
	public function insereControleFluv($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("id_contrato_obra", $dados["idContrato"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("infraestrutura", $dados["infraestrutura"]);

		$this->db->set("dia", $dados["dia"]);
		$this->db->set("manha", $dados["manha"]);
		$this->db->set("manha_nivel", $dados["manha_nivel"]);
		$this->db->set("jusante_manha", $dados["jusante_manha"]);
		$this->db->set("tarde", $dados["tarde"]);
		$this->db->set("tarde_nivel", $dados["tarde_nivel"]);
		$this->db->set("jusante_tarde", $dados["jusante_tarde"]);

		$this->db->set("publicar", "S");
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->insert("CGOB_TB_CONTROLE_FLUVIOMETRICO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function recuperaControleFluv($dados)
	{
		$SQL = "
          SELECT
            l.id_controle_fluviometrico,
            l.manha,
            l.manha_nivel,
            l.jusante_manha,
            l.tarde,
            l.tarde_nivel,
            l.jusante_tarde,
            l.dia,    
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome,
       		concat(DATEPART(YEAR,l.periodo_referencia ),'-',DATEPART(MONTH,l.periodo_referencia ),'-',l.dia) as diaSemana
            FROM CGOB_TB_CONTROLE_FLUVIOMETRICO AS l
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario
          
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";

		if (!empty($dados["id_controle_fluviometrico"])) {
			$SQL .= " AND l.id_controle_fluviometrico = '" . $dados["id_controle_fluviometrico"] . "' ";
		}

		if (!empty($dados["infraestrutura"])) {
			$SQL .= " AND l.infraestrutura = '" . $dados["infraestrutura"] . "' ";
		}

		if (!empty($dados["idContrato"])) {
			$SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
		}

		if (!empty($dados["periodo"])) {
			$SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
		}

		$SQL .= " ORDER BY l.dia ASC";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function excluirDia($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_controle_fluviometrico", $dados['id_controle_fluviometrico']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicacao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_CONTROLE_FLUVIOMETRICO");
		return true;
	}

	public function Recuperadiasmes($dados)
	{
		$SQL = "
          SELECT count (1) conte 
            FROM CGOB_TB_CONTROLE_FLUVIOMETRICO 

            WHERE (publicar like '%S%' or publicar is NULL)
            AND periodo_referencia = '" . $dados["periodo"] . "'  
            AND id_contrato_obra = " . $dados["id_contrato_obra"] . "
            ";
		$query = $this->db->query($SQL);
		return $query->result();
	}


	//---------------------------------------------------------------------------------------------
	public function ConsultaControleFluv($dados)
	{
		$SQL = "
			SELECT 
				CASE
					WHEN COUNT(id_controle_fluviometrico) >= 1 THEN 'S' 
					ELSE 'N'
				END conte_id
			FROM CGOB_TB_CONTROLE_FLUVIOMETRICO 
			WHERE id_contrato_obra = '" . $dados["idContrato"] . "'
			AND periodo_referencia = '" . $dados["periodo"] . "' 
			AND infraestrutura = '". $dados["infraestrutura"] ."'
			";

		if(isset($dados["dia"])){
			$SQL .= "AND dia = '" . $dados["dia"] . "'";
		}
		$query = $this->db->query($SQL);
		return $query->result();
	}

	//-----------------------------------------------------------------------------------------
	public function alteraControleFluv($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->where("dia", $dados["dia"]);
		$this->db->where("id_contrato_obra", $dados["idContrato"]);
		$this->db->where("periodo_referencia", $dados["periodo"]);
		$this->db->where("infraestrutura", $dados["infraestrutura"]);

		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("dia", $dados["dia"]);
		$this->db->set("manha", $dados["manha"]);
		$this->db->set("manha_nivel", $dados["manha_nivel"]);
		$this->db->set("jusante_manha", $dados["jusante_manha"]);
		$this->db->set("tarde", $dados["tarde"]);
		$this->db->set("tarde_nivel", $dados["tarde_nivel"]);
		$this->db->set("jusante_tarde", $dados["jusante_tarde"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("publicar", "S");
		$this->db->set("data_publicacao", NULL);
		$this->db->set("id_usuario_publicar", NULL);

		$this->db->update("CGOB_TB_CONTROLE_FLUVIOMETRICO");
		$this->db->trans_complete();

		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function insereNaoAtividade($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set('id_contrato_obra', $dados['idContrato']);
		$this->db->set('periodo_referencia', $dados['periodo']);
		$this->db->set('publicar', 'S');
		$this->db->set('flag_atividade', 'N');
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set('id_usuario', $dados['idUsuario']);

		$this->db->insert("CGOB_TB_CONTROLE_FLUVIOMETRICO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function confereAtividade($dados)
	{
		$SQL = "
        SELECT
            con.id_controle_fluviometrico,
            CASE
                WHEN con.flag_atividade = 'N' THEN 'Sem Atividade'
                WHEN con.flag_atividade = 'S' THEN 'Com Atividade'
                ELSE 'Sem Registros'
            END as situacao
        FROM CGOB_TB_CONTROLE_FLUVIOMETRICO AS con
        WHERE con.id_contrato_obra=" . $dados['idContrato'] . "
        AND con.periodo_referencia='" . $dados["periodo"] . "'
        AND con.publicar = 'S'
        ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//---------------------------------------------------------------------------------------------
	public function EditarControleFluv($dados)
	{
		$SQL = "
			SELECT 
				*
			FROM CGOB_TB_CONTROLE_FLUVIOMETRICO 
			WHERE id_contrato_obra = '" . $dados["idContrato"] . "'
			AND periodo_referencia = '" . $dados["periodo"] . "' 
			AND infraestrutura = '". $dados["infraestrutura"] ."'";

		$query = $this->db->query($SQL);
		return $query->result();
	}
}//fecha
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Pedro Correia
//# Data: 27/01/2020 13:00
//########################################################################################################################################################################################################################
