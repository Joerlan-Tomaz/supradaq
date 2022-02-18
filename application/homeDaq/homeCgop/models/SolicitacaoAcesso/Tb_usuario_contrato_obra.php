<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_usuario_contrato_obra extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

//-------------------------------------------------------------------------------------------------------
	public function vinculaUsuarioContratoObra($dados)
	{
		if (isset($_REQUEST["id_contrato"])) {
			foreach ($_REQUEST["id_contrato"] as $contratos) {
				$SQL = "SELECT * FROM TB_USUARIO_CONTRATO_OBRA
							WHERE id_usuario = {$dados["id_usuario_PerfilPermissao"]}
							AND id_contrato_obra = {$contratos}";
				$resultado = $this->db->query($SQL)->result();

				if (count($resultado) == 0) {
					date_default_timezone_set('America/Sao_Paulo');
					$this->db->set("id_usuario", $dados["id_usuario_PerfilPermissao"]);
					$this->db->set("id_contrato_obra", $contratos);
					$this->db->set("data_alteracao", date("Y-m-d H:i:s"));
					$this->db->set("id_usuario_alteracao", $this->session->id_usuario_daq_cgop);
					$this->db->set("ativo", 'S');
					$this->db->insert("TB_USUARIO_CONTRATO_OBRA");
				} else {
					date_default_timezone_set('America/Sao_Paulo');
					$this->db->where("id_usuario", $dados["id_usuario_PerfilPermissao"]);
					$this->db->where("id_contrato_obra", $contratos);
					$this->db->set("data_alteracao", date("Y-m-d H:i:s"));
					$this->db->set("id_usuario_alteracao", $this->session->id_usuario_daq_cgop);
					$this->db->set("ativo", 'S');
					$this->db->update("TB_USUARIO_CONTRATO_OBRA");
				}
			}

			$SQL = "SELECT * FROM TB_USUARIO_CONTRATO_OBRA 
							WHERE id_usuario = {$dados["id_usuario_PerfilPermissao"]}
							AND id_contrato_obra NOT IN (" . implode(',', $_REQUEST["id_contrato"]) . ")";
			$contratosRemovidos = $this->db->query($SQL)->result();

			if (count($contratosRemovidos) != 0) {
				foreach ($contratosRemovidos as $remover) {
					date_default_timezone_set('America/Sao_Paulo');
					$this->db->set("data_alteracao", date("Y-m-d H:i:s"));
					$this->db->set("id_usuario_alteracao", $this->session->id_usuario_daq_cgop);
					$this->db->set("ativo", 'N');
					$this->db->where("id_usuario_contrato_obra", $remover->id_usuario_contrato_obra);
					$this->db->update("TB_USUARIO_CONTRATO_OBRA");
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

}//Fecha
//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO/FERROVIÁRIO
//# Desenvolvedora:Eduardo Rocha Vargas
//# Data: 08/09/2020
//########################################################################################################################################################################################################################


