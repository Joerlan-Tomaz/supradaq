<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_perfil extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

//-------------------------------------------------------------------------------------------------------
	public function buscaDadosPerfil()
	{
		$SQL = "
            SELECT PER.*,
			   (SELECT TOP 1 usu.DESC_NOME
				FROM TB_PERFIL_ACESSO PEA
						 INNER JOIN TB_USUARIO USU
									on PEA.id_usuario_atualizacao = USU.id_usuario
				WHERE PEA.id_perfil = PER.id_perfil) as usuario,
			   (SELECT TOP 1 CONCAT(CONVERT(VARCHAR(10),PEA.data_atualizacao, 1),' ',CONVERT(VARCHAR(10), PEA.data_atualizacao, 108))
				FROM TB_PERFIL_ACESSO PEA
				WHERE PEA.id_perfil = PER.id_perfil
				ORDER BY data_atualizacao DESC) as ultima_atualizacao
		FROM TB_PERFIL PER";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function inserirPerfil(){
		$this->db->set("desc_perfil", $_REQUEST['desc_perfil']);
		$this->db->set("coordenacao", $_REQUEST["coordenacao"]);
		$this->db->set("status", 'S');
		$this->db->insert("TB_PERFIL");
		return true;
	}

	public function vincularPerfil(){
		if(isset($_REQUEST['id_tela_acesso'])){
			foreach($_REQUEST['id_tela_acesso'] as $id_tela_acesso){
				$SQL = "SELECT * FROM TB_PERFIL_ACESSO
							WHERE id_perfil = {$_REQUEST['id_perfil']}
							AND id_tela_acesso = {$id_tela_acesso}
							AND ativo = 'S'";
				$resultado = $this->db->query($SQL)->result();
				if (count($resultado) == 0) {
					$this->db->set("id_perfil", $_REQUEST['id_perfil']);
					$this->db->set("id_tela_acesso", $id_tela_acesso);
					$this->db->set("ativo", 'S');
					$this->db->set("id_usuario_atualizacao", $this->session->id_usuario_daq_cgop);
					$this->db->set("data_atualizacao",  date("Y-m-d H:i:s"));
					$this->db->insert("TB_PERFIL_ACESSO");
				}
			}

			$SQL = "SELECT * FROM TB_PERFIL_ACESSO 
							WHERE id_perfil = {$_REQUEST['id_perfil']}
							AND ativo = 'S'
							AND id_tela_acesso NOT IN (" . implode(',', $_REQUEST["id_tela_acesso"]) . ")";
			$acessosRemovidos = $this->db->query($SQL)->result();

			if (count($acessosRemovidos) != 0) {
				foreach ($acessosRemovidos as $remover) {
					date_default_timezone_set('America/Sao_Paulo');
					$this->db->where("id_perfil_acesso", $remover->id_perfil_acesso);
					$this->db->set("ativo", 'N');
					$this->db->set("id_usuario_atualizacao", $this->session->id_usuario_daq_cgop);
					$this->db->set("data_atualizacao",  date("Y-m-d H:i:s"));
					$this->db->update("TB_PERFIL_ACESSO");
				}
			}
		}else{
			$SQL = "SELECT * FROM TB_PERFIL_ACESSO
							WHERE id_perfil = {$_REQUEST['id_perfil']}
							AND ativo = 'S'";
			$resultado = $this->db->query($SQL)->result();

			if (count($resultado) != 0) {
				foreach ($resultado as $remover) {
					date_default_timezone_set('America/Sao_Paulo');
					$this->db->where("id_perfil_acesso", $remover->id_perfil_acesso);
					$this->db->set("ativo", 'N');
					$this->db->set("id_usuario_atualizacao", $this->session->id_usuario_daq_cgop);
					$this->db->set("data_atualizacao",  date("Y-m-d H:i:s"));
					$this->db->update("TB_PERFIL_ACESSO");
				}
			}
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function buscaPermissoesTelas($id_perfil){
		$SQL = "SELECT TTA.id_tela_acesso, TTA.supervisao, TTA.menu, TTA.tela
				FROM TB_PERFIL_ACESSO PA
						 INNER JOIN TB_TELA_ACESSO TTA 
							 ON PA.id_tela_acesso = TTA.id_tela_acesso
				where PA.id_perfil = {$id_perfil}
				  and PA.ativo = 'S'
				ORDER BY TTA.menu,TTA.tela";
               // echo('<pre>');
               // die($SQL);
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function buscaPermissoesUsuarioContrato($id_usuario){
		$SQL = "SELECT TUCO.id_contrato_obra
				FROM TB_USUARIO_CONTRATO_OBRA TUCO
				where TUCO.id_usuario = {$id_usuario}
				  and TUCO.ativo = 'S';";

		$query = $this->db->query($SQL);
		return $query->result();
	}

}//Fecha
//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO/FERROVIÁRIO
//# Desenvolvedora:Eduardo Rocha Vargas
//# Data: 08/09/2020
//########################################################################################################################################################################################################################


