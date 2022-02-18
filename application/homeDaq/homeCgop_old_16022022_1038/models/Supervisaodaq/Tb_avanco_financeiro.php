<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_avanco_financeiro extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

//------------------------------------------------------------------
	public function recuperaVersao($dados)
	{
		$SQL = "
		SELECT
		versao
		FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO
		WHERE id_cronograma_financeiro_versao = (SELECT MAX(id_cronograma_financeiro_versao) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO where publicar_cronograma = 'S' AND id_contrato_obra = '" . $dados["idContrato"] . "') 
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------
	public function recuperaObra()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

//-----------------------------------------------Servicos----------------------------------------------
	public function recuperaObraConstrucao($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_CONSTRUCAO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 1");

		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//-------------------------------------------------------------------------------------------
	public function recuperaObraDerrocagem($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_DERROCAMENTO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 2");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraDragagem($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_DRAGAGEM as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 3");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraDesobstrucao($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_DESOBSTRUCAO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 4");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraRecuperacao($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_RECUPERACAO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 5");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraMonitoramento($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_MONITORAMENTO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 6");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraNavioHaider($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 7");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraSinalHidro($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 8");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraEclusas($dados)
	{
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_ECLUSAS as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = " . $dados["idContrato"] . " AND af.versao = " . $dados["versao"] . " AND
			af.id_obra = 9");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

//-------------------------------------------------------------------------
	public function recuperaTipo()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_TIPO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	public function recuperaTipoEstruturaNaval()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_TIPO_ESTRUTURA_NAVAL");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
//----------------------------------------------------------------------------------------------------------------------------	

	// public function recuperaMedicao($dados){
	// 	$SQL = "
	// 	SELECT DISTINCT
	// 	ma.nume_medicao,
	//     (CONVERT(CHAR(10),(CAST(ma.data_termino_medicao AS DATE)),103))as data_termino_medicao,
	//     (CONVERT(CHAR(10),(CAST(ma.data_processamento_medicao AS DATE)),103))as data_processamento_medicao,
	// 	ma.valor_pi_medicao
	// 	FROM CGOB_TB_SIAC_MEDICAO_MAIOR as ma
	// 	INNER JOIN CGOB_TB_CONTRATO_OBRA as c on c.nu_con_formatado = ma.contrato
	// 	WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND ma.nume_medicao = (SELECT MAX(nume_medicao) 
	// 	FROM CGOB_TB_SIAC_MEDICAO_MAIOR 
	// 	INNER JOIN CGOB_TB_CONTRATO_OBRA as c on c.nu_con_formatado = contrato WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . ")
	// 	";
	// 	$query = $this->db->query($SQL);
	// 	return $query->result();
	// }
	// public function ValorAvanco($dados) {
	// 	$SQL = "
	// 	SELECT 
	// 	SUM(valor) as valor_lancado
	// 	from CGOB_TB_AVANCO_FINANCEIRO 
	// 	WHERE (publicar_versao = 'N' AND publicar = 'S'AND publicar_versao is NULL) AND id_contrato_obra = " . $dados["id_contrato_obra"] . " 
	// 	AND nume_medicao = " . $dados["numemedicao"] . " 
	// 	";
	// 	$query = $this->db->query($SQL);
	// 	return $query->result_array();
	// }
	// public function RecuperaMedicaoNaopublicado($dados){
	// 	$SQL = "
	//        SELECT DISTINCT
	// 	ma.nume_medicao,
	//     (CONVERT(CHAR(10),(CAST(ma.data_termino_medicao AS DATE)),103))as data_termino_medicao,
	//     (CONVERT(CHAR(10),(CAST(ma.data_processamento_medicao AS DATE)),103))as data_processamento_medicao,
	// 	ma.valor_pi_medicao,
	// 	CASE WHEN (SUM(af.valor)) IS NULL THEN 0 else (SUM(af.valor)) END valor,
	// 	CASE
	//            WHEN af.publicar_versao = 'N' THEN 0
	//            WHEN af.publicar_versao = 'S' THEN 1
	//            WHEN af.publicar_versao IS NULL THEN 2
	//        END as publicar_versao
	// 	FROM CGOB_TB_SIAC_MEDICAO_MAIOR as ma
	// 	INNER JOIN CGOB_TB_CONTRATO_OBRA as c on c.nu_con_formatado = ma.contrato
	// 	full outer join CGOB_TB_AVANCO_FINANCEIRO as af on  ma.nume_medicao = af.nume_medicao
	// 	WHERE c.id_contrato_obra = " . $dados["id_contrato_obra"] . "
	// 	AND (af.publicar_versao = 'N' AND af.publicar = 'S' OR af.publicar IS NULL) 
	// 	AND ma.nume_medicao = (SELECT MAX(nume_medicao) 
	// 	FROM CGOB_TB_SIAC_MEDICAO_MAIOR 
	// 	INNER JOIN CGOB_TB_CONTRATO_OBRA as c on c.nu_con_formatado = contrato WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . ")
	// 	GROUP BY  ma.nume_medicao,ma.data_termino_medicao, ma.data_processamento_medicao, ma.valor_pi_medicao, publicar_versao
	// 	";

	// 	$query = $this->db->query($SQL);
	// 	return $query->result();
	// }
//----------------------------------------------------------------------------------------------------------------------------
	public function RecuperaMedicaoNaopublicadobk($dados)
	{
		$SQL = "
        SELECT DISTINCT
		ma.nume_medicao as numemedicao,
	    (CONVERT(CHAR(10),(CAST(ma.data_termino_medicao AS DATE)),103))AS data_termino_medicao,
	    (CONVERT(CHAR(10),(CAST(ma.data_processamento_medicao AS DATE)),103))AS data_processamento_medicao,
		ma.valor_pi_medicao,

		(SELECT SUM(valor) FROM CGOB_TB_AVANCO_FINANCEIRO 
				WHERE  nume_medicao = (SELECT MAX(nume_medicao) 
		FROM CGOB_TB_SIAC_MEDICAO_MAIOR 
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.nu_con_formatado = contrato WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . ")

		AND (publicar_versao = 'N' AND publicar = 'S')AND id_contrato_obra = " . $dados["id_contrato_obra"] . ") valor,

		(SELECT CASE WHEN publicar_versao = 'S' THEN 1 END FROM CGOB_TB_AVANCO_FINANCEIRO 
		        WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " 
		        AND (publicar ='S' and publicar_versao = 'S') ) publicar_versao


		FROM CGOB_TB_SIAC_MEDICAO_MAIOR AS ma
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.nu_con_formatado = ma.contrato
		WHERE c.id_contrato_obra = " . $dados["id_contrato_obra"] . "
		AND ma.nume_medicao = (SELECT MAX(nume_medicao) 
		FROM CGOB_TB_SIAC_MEDICAO_MAIOR 
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.nu_con_formatado = contrato WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . ")
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------------
	public function RecuperaMedicaoNaopublicado($dados)
	{
		$SQL = "
		SELECT DISTINCT ma.nume_medicao as numemedicao, 
		CONCAT(month (ma.data_termino_medicao),'/',year(ma.data_termino_medicao))AS data_termino_medicao, 
		CONCAT(month (ma.data_processamento_medicao),'/',year(ma.data_processamento_medicao))AS data_processamento_medicao,  
		ma.valor_pi_medicao, 
		(SELECT SUM(valor) FROM CGOB_TB_AVANCO_FINANCEIRO 
				WHERE  nume_medicao = ma.nume_medicao 
		AND (publicar_versao = 'N' AND publicar = 'S')AND id_contrato_obra = " . $dados["id_contrato_obra"] . ") valor,
		(SELECT count(publicar_versao) FROM CGOB_TB_AVANCO_FINANCEIRO 
		        WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " 
		        AND (publicar ='S' and publicar_versao = 'S') and nume_medicao = ma.nume_medicao  ) publicar_versao
		FROM CGOB_TB_SIAC_MEDICAO_MAIOR AS ma
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.nu_con_formatado = ma.contrato 
		WHERE c.id_contrato_obra = " . $dados["id_contrato_obra"] . "
		";
		$SQL .= " ORDER BY ma.nume_medicao desc";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function RecuperaMedicaopublicado($dados)
	{
		$SQL = "
        SELECT DISTINCT
		ap.nume_medicao as numemedicao,
	    CONCAT(month (ma.data_termino_medicao),'/',year(ma.data_termino_medicao))AS data_termino_medicao,
	    (CONVERT(CHAR(10),(CAST(ma.data_processamento_medicao AS DATE)),103))AS data_processamento_medicao,
		ma.valor_pi_medicao,
		SUM(af.valor) as valor,
		af.infraestrutura
		FROM CGOB_TB_AVANCO_FINANCEIRO_PUBLICAR AS ap
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON ap.id_contrato_obra = c.id_contrato_obra
		INNER JOIN CGOB_TB_SIAC_MEDICAO_MAIOR AS ma ON c.nu_con_formatado = ma.contrato
		     AND  ma.nume_medicao = ap.nume_medicao
		FULL OUTER JOIN CGOB_TB_AVANCO_FINANCEIRO AS af ON  ap.nume_medicao = af.nume_medicao AND ap.id_contrato_obra = af.id_contrato_obra
		
		WHERE ap.id_contrato_obra = " . $dados["id_contrato_obra"] . "

		AND (af.publicar_versao  = 'S' AND af.publicar = 'S') 
		
		GROUP BY  ap.nume_medicao,ma.data_termino_medicao, ma.data_processamento_medicao, ma.valor_pi_medicao, af.infraestrutura
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}
//----------------------------------------------------------------------------------------------------------------------------

	// public function recuperaServico($dados) {
	// 	$this->db->select("s.servico");
	// 	$this->db->select("s.id_servico as id");
	//        $this->db->from("CGOB_TB_SERVICO as s");
	// 	$this->db->join("CGOB_TB_CRONOGRAMA_FINANCEIRO as cf", "s.id_servico = cf.servico");
	// 	$this->db->where("cf.publicar_versao", "S");
	//        $this->db->where("cf.id_contrato_obra", $dados["id_contrato_obra"]);
	// 	$consulta = $this->db->get();
	// 	$resultado = $consulta->result();
	// 	return $resultado;
	// }
//----------------------------------------------------------------------------------------------------------------------------

	public function RecuperaMedicaoNumeMedicao($dados)
	{
		$SQL = "
		SELECT DISTINCT 
		ma.nume_medicao as numemedicao, 
		(CONVERT(CHAR(02),(CAST(ma.data_termino_medicao AS DATE)),101))AS data_termino_medicao, 
		(CONVERT(CHAR(10),(CAST(ma.data_processamento_medicao AS DATE)),103))AS data_processamento_medicao, 
		ma.valor_pi_medicao, 
		(SELECT SUM(valor) FROM CGOB_TB_AVANCO_FINANCEIRO 
				WHERE  nume_medicao = " . $dados["numemedicao"] . " AND (publicar_versao = 'N' AND publicar  = 'S') AND id_contrato_obra = " . $dados["id_contrato_obra"] . "  ) valor
		FROM CGOB_TB_SIAC_MEDICAO_MAIOR AS ma 
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.nu_con_formatado = ma.contrato 
		WHERE c.id_contrato_obra = " . $dados["id_contrato_obra"] . "
		AND ma.nume_medicao = " . $dados["numemedicao"] . "

        ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function insereAvanco($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("id_contrato_obra", $dados["id_contrato_obra"]);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));

		$this->db->set("nume_medicao", $dados["numemedicao"]);
		$this->db->set("ano", $dados["ano"]);
		$this->db->set("mes", $dados["mes"]);
		$this->db->set("infraestrutura", $dados['infraestrutura']);
		$this->db->set("id_operacao", $dados['id_operacao']);
		$this->db->set("id_servico", $dados['id_servico']);
		$this->db->set("id_tipo", $dados['id_tipo']);
		$this->db->set("valor", $dados["valor"]);

		$this->db->set("publicar", "S");
		$this->db->set("publicar_versao", "N");
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->insert("CGOB_TB_AVANCO_FINANCEIRO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

//----------------------------------------------------------------------------------------------------------------------------
	public function nu_medicao($dados)
	{
		$SQL = "
		SELECT DISTINCT 
		ma.nume_medicao as numemedicao,
		month (ma.data_termino_medicao)as mes_medicao,
		year(ma.data_termino_medicao) as ano_medicao, 
		(CONVERT(CHAR(02),(CAST(ma.data_termino_medicao AS DATE)),101))AS data_termino_medicao, 
		(CONVERT(CHAR(10),(CAST(ma.data_processamento_medicao AS DATE)),103))AS data_processamento_medicao
		FROM CGOB_TB_SIAC_MEDICAO_MAIOR AS ma 
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.nu_con_formatado = ma.contrato 
		WHERE c.id_contrato_obra = " . $dados["id_contrato_obra"] . "
		AND ma.nume_medicao = " . $dados["numemedicao"] . "
        ";

		$query = $this->db->query($SQL);
		return $query->result_array();
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function RecuperaDetalhado($dados)
	{
		$SQL = "
		SELECT DISTINCT
		af.id_avanco_financeiro AS id,
		af.valor,
		op.nome_operacao,
		se.servico,
		tp.tipo,
		CONCAT(CONVERT(CHAR(10), af.ultima_alteracao , 103),' ', CONVERT(CHAR(8), af.ultima_alteracao , 114)) AS ultima_alteracao,
        (SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
		FROM CGOB_TB_AVANCO_FINANCEIRO AS af
		INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = af.id_operacao
        INNER JOIN CGOB_TB_OPERACAO_SERVICO AS se ON se.id_servico = af.id_servico
        LEFT JOIN CGOB_TB_OPERACAO_TIPO AS tp ON tp.id_tipo = af.id_tipo
		WHERE (af.publicar = 'S' OR af.publicar IS NULL) AND af.id_contrato_obra = " . $dados["id_contrato_obra"] . " AND  af.nume_medicao = " . $dados["numemedicao"] . "
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function PublicarNaopublicado($dados)
	{
		$this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("nume_medicao", $dados['numemedicao']);
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->insert("CGOB_TB_AVANCO_FINANCEIRO_PUBLICAR");

		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("nume_medicao", $dados['numemedicao']);
		$this->db->where("publicar", "S");
		$this->db->set("publicar_versao", "S");
		$this->db->set("data_publicar_versao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar_versao", $dados["idUsuario"]);
		if (!empty($dados["id_avanco_financeiro_publicar"])) {
			$this->db->set("id_avanco_financeiro_publicar", $dados["id_avanco_financeiro_publicar"]);
		}
		$this->db->update("CGOB_TB_AVANCO_FINANCEIRO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}

	}

//----------------------------------------------------------------------------------------------------------------------------
	public function excluirAvanco($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_avanco_financeiro", $dados['id']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_AVANCO_FINANCEIRO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function buscaInfraestruturas($dados)
	{
		$SQL = "SELECT DISTINCT nome_infraestrutura 
					FROM CGOB_TB_CRONOGRAMA_FINANCEIRO
				WHERE id_contrato_obra = {$dados["idContrato"]}
				AND periodo_referencia = '" . $dados["periodo"] . "' ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaOperacao($dados)
	{
		$SQL = "SELECT DISTINCT cf.id_operacao, op.nome_operacao 
					FROM SUPRA_DAQ.dbo.CGOB_TB_CRONOGRAMA_FINANCEIRO cf
				INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = cf.id_operacao
					WHERE id_contrato_obra = " . $dados['id_contrato'] . " 
					  AND nome_infraestrutura = '" . $dados['infraestrutura'] . "'";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaServico($dados)
	{
		$SQL = "SELECT DISTINCT se.id_servico, se.servico
					FROM SUPRA_DAQ.dbo.CGOB_TB_CRONOGRAMA_FINANCEIRO cf
				INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = cf.id_operacao
				INNER JOIN CGOB_TB_OPERACAO_SERVICO AS se ON se.id_servico = cf.id_servico
					WHERE cf.id_contrato_obra = " . $dados['id_contrato'] . " 
					  AND cf.nome_infraestrutura = '" . $dados['infraestrutura'] . "'
					  AND op.id_operacao = " . $dados['id_operacao'] . " ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaTipoInfra($dados)
	{
		$SQL = "SELECT DISTINCT tp.id_tipo, tp.tipo
					FROM SUPRA_DAQ.dbo.CGOB_TB_CRONOGRAMA_FINANCEIRO cf
				INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = cf.id_operacao
				INNER JOIN CGOB_TB_OPERACAO_SERVICO AS se ON se.id_servico = cf.id_servico
				LEFT JOIN CGOB_TB_OPERACAO_TIPO AS tp ON tp.id_tipo = cf.id_tipo_operacao
					WHERE cf.id_contrato_obra = " . $dados['id_contrato'] . " 
					  AND cf.nome_infraestrutura = '" . $dados['infraestrutura'] . "'
					  AND op.id_operacao = " . $dados['id_operacao'] . " 
					  AND se.id_servico = " . $dados['id_servico'] . " ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 18/01/2020 13:00
//########################################################################################################################################################################################################################
