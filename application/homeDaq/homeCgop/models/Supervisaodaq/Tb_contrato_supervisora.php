<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_contrato_supervisora extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

	public function dadosSupervisoraPainelGerencial($dados)
	{
		$SQL = "SELECT cs.*,
					cs.ds_fas_contrato  AS statusSupervisao,
					cs.nu_con_formatado AS sup_contrato,
					cs.no_empresa AS supervisao_nome,
					cs.ds_objeto AS sup_objetivo,
					cs.modalidade_licitacao AS sup_regime,
					cs.nu_edital AS sup_edital,
					CONVERT(CHAR(10),cs.dt_base , 103) AS sup_mesBase,
					cs.ds_tip_intervencao AS sup_tp_intervencao,
					CONVERT(CHAR(10),cs.dt_assinatura , 103) AS sup_assinatura,
					(CONVERT(CHAR(10),(CAST(cs.dt_inicio AS DATE)),103)) AS sup_ordem_inicio,
					CONVERT(CHAR(10),cs.dt_ter_prv , 103) AS sup_data_termino_servico,
					CONVERT(CHAR(10),cs.dt_termino_vigencia , 103) AS sup_data_termino_vigencia,
       				nu_dia_paralisacao AS sup_dias_paralisados,
       				nu_dia_prorrogacao AS sup_dias_aditados
				FROM CGOB_TB_CONTRATO_SUPERVISORA as cs
				WHERE cs.nu_con_formatado = (SELECT nu_con_formatado_supervisor FROM CGOB_TB_CONTRATO_OBRA where id_contrato_obra = " . $dados['id_contrato_obra'] . ")";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function gerencialSupervisaoResumoFinanceiro($dados)
	{
		$SQL = "SELECT
					Valor_Inicial as valor_pi, 
					Valor_Total_de_Aditivos as aditivos, 
					Valor_Total_de_Reajuste as reajustamento,
					Valor_Inicial_Adit_Reajustes as valor_total, 
					Valor_PI_Medicao as total_medido, 
					Valor_Medicao_PI_R as total_medido_piar,
					Valor_Reajuste_Medicao as valor_medir,
					Valor_Empenhado as total_empenhado,
					Valor_Saldo as saldo_empenhado, 
					(Valor_Saldo - valor_empenhado) as a_empenhar
				FROM CGOB_TB_CONTRATO_SUPERVISORA
				WHERE nu_con_formatado = (SELECT nu_con_formatado_supervisor 
				          FROM CGOB_TB_CONTRATO_OBRA 
				          WHERE id_contrato_obra = ".$dados['id_contrato_obra']." )";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function buscaSupervisoras(){
		$SQL = "SELECT id_contrato_supervisora, CONCAT(nu_con_formatado,' - ',no_empresa) as nome_supervisora
					FROM CGOB_TB_CONTRATO_SUPERVISORA
				ORDER BY no_empresa";

		$query = $this->db->query($SQL);
		return $query->result();
	}

}//Fecha
//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO
//# Desenvolvedora:Pedro Correia
//# Data: 04/03/2021
//########################################################################################################################################################################################################################


