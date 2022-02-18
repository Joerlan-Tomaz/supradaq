<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_Tela_Acesso extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

	function inserirTela(){
		$this->db->set("supervisao", $_REQUEST['supervisao']);
		$this->db->set("menu", $_REQUEST["menu"]);
		$this->db->set("tela", $_REQUEST["tela"]);
		$this->db->insert("TB_TELA_ACESSO");
		return true;
	}

	public function buscaTelas(){
		$SQL = "SELECT *, 
       		(SELECT TOP 1ativo FROM TB_PERFIL_ACESSO TAP 
       			WHERE id_perfil = {$_REQUEST['id_perfil']} 
							AND TAP.id_tela_acesso = TPA1.id_tela_acesso
           ORDER BY data_atualizacao DESC) as ativo
			FROM TB_TELA_ACESSO TPA1
			ORDER BY supervisao,menu,tela";

		$query = $this->db->query($SQL);
		return $query->result();
	}

}//Fecha
//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO/FERROVIÁRIO
//# Desenvolvedora:Eduardo Rocha Vargas
//# Data: 08/09/2020
//########################################################################################################################################################################################################################


