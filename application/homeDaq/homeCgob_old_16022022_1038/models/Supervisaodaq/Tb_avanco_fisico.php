<?php
/*
 * Classe model Tb_avanco_fisico. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage CI_Model 
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_avanco_fisico extends CI_Model {

	public function __construct()
	{
		parent ::__construct();
		$this->db = $this->load->database('DAQ', TRUE); 
	}

//----------------------------------------------------------------------------------------------------------------------------	

//@JordanaAlencar

//----------------------------------------------------------------------------------------------------------------------------

	public function recuperaEixo($dados) {
		$this->db->select('DISTINCT(g.eixo) as id');
		$this->db->select("item.eixo");
		$this->db->from("CGOB_TB_CONFIG_GEORREFERENCIAMENTO as g");
		$this->db->join("CGOB_TB_CONFIG_ITEM_EIXO as item", "item.id_eixo = g.eixo");
		$this->db->where("g.publicar", "S");
		$this->db->or_where("g.publicar is NULL");
		$this->db->where("g.id_contrato_obra", $dados["id_contrato_obra"]);   
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
//---------------------------------------------------------------------------------------------
	public function recuperaObra() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
//-----------------------------------------------Servicos----------------------------------------------
	public function recuperaObraConstrucao($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_CONSTRUCAO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 1");
		
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
    //-------------------------------------------------------------------------------------------
	public function recuperaObraDerrocagem($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_DERROCAMENTO as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 2");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraDragagem($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_DRAGAGEM as ob");
			$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 3 AND af.id_servico != 6 " );
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraDesobstrucao($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_DESOBSTRUCAO as ob");
			$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 4");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraRecuperacao($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_RECUPERACAO as ob");
			$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 5");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraMonitoramento($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_MONITORAMENTO as ob");
			$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 6");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraNavioHaider($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER as ob");
		$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 7");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraSinalHidro($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO as ob");
			$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 8");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraEclusas($dados) {
		$this->db->select("DISTINCT(ob.id_obra)");
		$this->db->select("ob.desc_obra");
		$this->db->from("CGOB_TB_OBRA_ECLUSAS as ob");
			$this->db->join("CGOB_TB_CRONOGRAMA_FISICO as af", "af.id_servico = ob.id_obra AND af.publicar_versao = 'S' AND
			af.publicar= 'S' AND af.id_contrato_obra = ".$dados["idContrato"]." AND af.versao = ".$dados["versao"]." AND
			af.id_obra = 9");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//-------------------------------------------------------------------
	// public function recuperaTipo($dados) {
	// 	$this->db->select("tipo_derrocagem");
	// 	$this->db->select("id_obra");
	// 	$this->db->from("CGOB_TB_OBRA_DERROCAMENTO");
	// 	$this->db->where("desc_obra", $dados["desc_obra"]);
	// 	$consulta = $this->db->get();
	// 	$resultado = $consulta->result();
	// 	return $resultado;
	// }

 // 	public function recuperaDesc($dados){
	// 	$SQL = "
	// 	SELECT 
	// 	desc_obra
	// 	FROM CGOB_TB_OBRA_DERROCAMENTO  AS cg
	// 	WHERE id_obra = '" . $dados["id_servico"] . "'
	// 	";
	// 	$query = $this->db->query($SQL);
	// 	return $query->result_array();
	// }

	public function recuperaTipo() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_TIPO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	public function recuperaTipoEstruturaNaval() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_TIPO_ESTRUTURA_NAVAL");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
//-------------------------------------------------------------------
		public function recuperaVersao($dados){
		$SQL = "
		SELECT
		versao
		FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO
		WHERE id_cronograma_fisico_versao = (SELECT MAX(id_cronograma_fisico_versao) FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO where publicar_cronograma = 'S'AND id_contrato_obra = '". $dados["idContrato"] ."') 
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------------

	// public function recuperaServico($dados) {
	// 	$this->db->select("s.desc_servico");
	// 	$this->db->select("cf.id_servico as id");
	// 	$this->db->from("CGOB_TB_CRONOGRAMA_FISICO as cf");
	// 	$this->db->join("CGOB_TB_CRONOGRAMA_FISICO_SERVICO as s", "s.id_servico = cf.id_servico");
	// 	$this->db->where("cf.publicar_versao", "S");
	// 	$this->db->where("cf.id_contrato_obra", $dados["id_contrato_obra"]);
	// 	$this->db->where("cf.id_eixo", $dados["id_eixo"]);
	// 	$consulta = $this->db->get();
	// 	$resultado = $consulta->result();
	// 	return $resultado;
	// }
//----------------------------------------------------------------------------------------------------------------------------
	// public function avancoaquaviarioatacado($dados){
	// 	$SQL = "
	// 	SELECT 
	// 	CASE
	// 	WHEN COUNT(id_avanco_fisico) >= 1 THEN 1 
	// 	ELSE 0
	// 	END conte_id
	// 	FROM CGOB_TB_AVANCO_FISICO 
	// 	WHERE publicar = 'S' AND ('" . $dados["val_inicial"] . "' >= (SELECT MIN(val_inicial) FROM CGOB_TB_AVANCO_FISICO where publicar = 'S' 
	// 	AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' 
	// 	AND servico = '" . $dados["servico"] . "' 
	// 	AND eixo = '" . $dados["eixo"] . "'
	// 	AND obra = '" . $dados["obra"] . "'
	// 	AND status = '" . $dados["status"] . "') 

	// 	AND '" . $dados["val_inicial"] . "' <= (SELECT MAX(val_final) FROM CGOB_TB_AVANCO_FISICO where publicar = 'S' 
	// 	AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' 
	// 	AND servico = '" . $dados["servico"] . "' 
	// 	AND eixo = '" . $dados["eixo"] . "'
	// 	AND obra = '" . $dados["obra"] . "'
	// 	AND status = '" . $dados["status"] . "') ) OR

	// 	('" . $dados["val_final"] . "' >= (SELECT MIN(val_inicial) FROM CGOB_TB_AVANCO_FISICO where publicar = 'S' 
	// 	AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' 
	// 	AND servico = '" . $dados["servico"] . "' 
	// 	AND eixo = '" . $dados["eixo"] . "'
	// 	AND obra = '" . $dados["obra"] . "'
	// 	AND status = '" . $dados["status"] . "')

	// 	AND '" . $dados["val_final"] . "' <= (SELECT MAX(val_final) FROM CGOB_TB_AVANCO_FISICO where publicar = 'S' 
	// 	AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' 
	// 	AND servico = '" . $dados["servico"] . "' 
	// 	AND eixo = '" . $dados["eixo"] . "'
	// 	AND obra = '" . $dados["obra"] . "'
	// 	AND status = '" . $dados["status"] . "') )

	// 	AND id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
	// 	AND servico = '" . $dados["servico"] . "' 
	// 	AND eixo = '" . $dados["eixo"] . "'
	// 	AND obra = '" . $dados["obra"] . "'
	// 	AND status = '" . $dados["status"] . "'
	// 	";
	
	// 	$query = $this->db->query($SQL);
	// 	return $query->result();
	// }


	public function avancoaquaviarioatacado($dados){
		$SQL = "
		SELECT 
		CASE
		WHEN COUNT(id_avanco_fisico) >= 1 THEN 1 
		ELSE 0
		END conte_id
		FROM CGOB_TB_AVANCO_FISICO 
		WHERE " . $dados["val_final"] . " = (SELECT val_final FROM CGOB_TB_AVANCO_FISICO where publicar = 'S' 
		AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' 
		AND servico = '" . $dados["servico"] . "' 
		AND eixo = '" . $dados["eixo"] . "'
		AND obra = '" . $dados["obra"] . "'
		AND status in ('Atacado','Executado pelo contrato anterior')) 
		";
	
		$query = $this->db->query($SQL);
		return $query->result();
	}
//------------------------------------------------------------------------------

	public function Cronograma_fisico($dados) {
		$SQL = "
		SELECT
		SUM(cf.valor_medido) as valor
		FROM CGOB_TB_CRONOGRAMA_FISICO cf
		WHERE (cf.publicar = 'S') AND cf.publicar_versao = 'S' AND cf.id_obra ='" . $dados["id_obra"] . "'  AND cf.id_servico ='" . $dados["id_servico"] . "'  AND cf.versao ='" . $dados["versao"] . "' AND cf.id_contrato_obra = " . $dados["idContrato"] . "
		"; 
		$query = $this->db->query($SQL);
		return $query->result_array();
	}
//-------------------------------------------------------------------------------------
		public function avancoaquaatacado($dados){
		$SQL = "
		SELECT 
		SUM(val_final) as val_atacado
		FROM CGOB_TB_AVANCO_FISICO 
		WHERE publicar = 'S' 
		AND id_contrato_obra = '". $dados["idContrato"] ."' 
		AND servico = '" . $dados["id_servico"] . "' 
		AND obra = '" . $dados["id_obra"] . "'
		AND status in ('Atacado','Executado pelo contrato anterior')
		AND versao ='" . $dados["versao"] . "'  
		";
		$query = $this->db->query($SQL);
		return $query->result_array();
	}
//----------------------------------------------------------------------------------------------------------------------------
	public function insere_avanco_aquaviario($dados){
		$this->db->set("id_contrato_obra", $dados["id_contrato_obra"]);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("publicar", "S");
		$this->db->set("publicar_versao", "N");
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->set("mes", $dados["mes"]);
		//$this->db->set("val_inicial", $dados["atacado_inicial"]);
		$this->db->set("val_final", $dados["atacado_final"]);
		$this->db->set("unidade_medida", $dados["medicao"]);
		$this->db->set("versao", $dados["versao"]);
		$this->db->set("eixo", $dados["id_eixo"]);
		$this->db->set("servico", $dados["id_servico"]);
		$this->db->set("obra", $dados['id_obra']);
		$this->db->set("tipo_obra", $dados['tipo']);
		$this->db->set("status", $dados["status"]);
		$this->db->set("extensao_atacado", $dados["extensao"]);
		$this->db->insert("CGOB_TB_AVANCO_FISICO");

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
	public function AvancoAquaviario_Trecho_Atacado($dados){
		$SQL = "
		SELECT 
		af.id_avanco_fisico as id,
		CONCAT(af.val_inicial,'',af.unidade_medida) as valInicial,
		CONCAT(af.val_final,'',af.unidade_medida) as valFinal,
		af.val_final,af.versao,
		af.extensao_atacado, 
		af.status,
		af.tipo_obra,
		af.unidade_medida as unidade,
		CASE
			WHEN af.obra = 1 THEN 'Construção Portuária'
			WHEN af.obra = 2 THEN 'Derrocagem'
			WHEN af.obra = 3 THEN 'Dragagem'
			WHEN af.obra = 4 THEN 'Desobstrução'
			WHEN af.obra = 5 THEN 'Recuperação Portuária'
			WHEN af.obra = 6 THEN 'Monitoramento Hidroviário'
			WHEN af.obra = 7 THEN 'Remoção Navio'
			WHEN af.obra = 8 THEN 'Implantação de Sinalização em Hidrovias'
			WHEN af.obra = 9 THEN 'Recuperação Eclusas e Barragens'
		END desc_obra,
		(SELECT  
		CASE
			WHEN mes = 01 THEN CONCAT('Janeiro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 02 THEN CONCAT('Fevereiro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 03 THEN CONCAT('Março',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 04 THEN CONCAT('Abril',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 05 THEN CONCAT('Maio',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 06 THEN CONCAT('Junho',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 07 THEN CONCAT('Julho',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 08 THEN CONCAT('Agosto',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 09 THEN CONCAT('Setembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 10 THEN CONCAT('Outubro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 11 THEN CONCAT('Novembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 12 THEN CONCAT('Dezembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
		END as executado
		FROM CGOB_TB_AVANCO_FISICO_EXECUTADO  WHERE id_avanco_fisico = af.id_avanco_fisico AND id_avanco_executado = (SELECT MAX(id_avanco_executado)FROM CGOB_TB_AVANCO_FISICO_EXECUTADO WHERE id_avanco_fisico = af.id_avanco_fisico )) AS executado,
		CASE
			WHEN af.mes = 01 THEN CONCAT('Janeiro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 02 THEN CONCAT('Fevereiro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 03 THEN CONCAT('Março',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 04 THEN CONCAT('Abril',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 05 THEN CONCAT('Maio',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 06 THEN CONCAT('Junho',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 07 THEN CONCAT('Julho',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 08 THEN CONCAT('Agosto',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 09 THEN CONCAT('Setembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 10 THEN CONCAT('Outubro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 11 THEN CONCAT('Novembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 12 THEN CONCAT('Dezembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
		END as atacado,
		CONCAT(CONVERT(CHAR(10), af.ultima_alteracao , 103),' ', CONVERT(CHAR(8), af.ultima_alteracao , 114)) AS ultima_alteracao,
		(SELECT eixo FROM CGOB_TB_CONFIG_ITEM_EIXO  WHERE id_eixo = af.eixo) AS eixo,
		CASE 
			WHEN af.obra = 1 THEN (SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE af.servico = i.id_obra)
			WHEN af.obra = 2 THEN (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE af.servico = od.id_obra)
			WHEN af.obra = 3 THEN (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE af.servico = odra.id_obra)
			WHEN af.obra = 4 THEN (SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE af.servico = odes.id_obra)
			WHEN af.obra = 5 THEN (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE af.servico = opm.id_obra)
			WHEN af.obra = 6 THEN (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE af.servico = ocp.id_obra)
			WHEN af.obra = 7 THEN (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE af.servico = onh.id_obra)
			WHEN af.obra = 8 THEN (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE af.servico = osh.id_obra)
			WHEN af.obra = 9 THEN (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE af.servico = oe.id_obra)
		END AS servico,
		(SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
		FROM CGOB_TB_AVANCO_FISICO AS af
		WHERE (af.publicar_versao = 'N' AND af.publicar = 'S') AND
		af.id_contrato_obra = " . $dados["id_contrato_obra"] . "
		AND af.versao ='" . $dados["versao"] . "'
		order by af.versao
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------
	public function recupera_medicao_aquaviario_executado($dados) {
		$SQL = "
		SELECT
		id_avanco_executado as id,
		CONCAT(val_inicial,'',unidade_medida_exec) as valInicial,
		CONCAT(val_final,'',unidade_medida_exec) as valFinal,
		unidade_medida_exec as med,
		val_final as vf,
		CASE
			WHEN mes = 01 THEN CONCAT('Janeiro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 02 THEN CONCAT('Fevereiro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 03 THEN CONCAT('Março',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 04 THEN CONCAT('Abril',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 05 THEN CONCAT('Maio',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 06 THEN CONCAT('Junho',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 07 THEN CONCAT('Julho',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 08 THEN CONCAT('Agosto',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 09 THEN CONCAT('Setembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 10 THEN CONCAT('Outubro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 11 THEN CONCAT('Novembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 12 THEN CONCAT('Dezembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
		END as periodo,
		status     
		FROM CGOB_TB_AVANCO_FISICO_EXECUTADO 
		WHERE publicar = 'S' AND id_avanco_fisico = " . $dados["id"] . " AND id_contrato_obra = " . $dados["id_contrato_obra"] . "
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}
//-----------------------------------------------------------------------------------------------------------------------
	public function recupera_insere($dados) {
		$SQL = "
		SELECT
		servico as id,
		obra     
		FROM CGOB_TB_AVANCO_FISICO
		WHERE publicar = 'S' AND id_avanco_fisico = " . $dados["id_executado"] . " AND id_contrato_obra = " . $dados["idContrato"] . "
		";
		$query = $this->db->query($SQL);
		return $query->result_array();
	}
//------------------------------------------------------------------------------------------------------------------------
	public function conferePeriodo($dados){
		$SQL = "
		SELECT 
		periodo_referencia,
		unidade_medida
		FROM CGOB_TB_AVANCO_FISICO 
		WHERE id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
		AND id_avanco_fisico = '" . $dados["id"] . "' 
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}
//------------------------------------------------------------Troquei 500X-----------------------------------------------------------
	// public function recuperametrica($dados) {
	// 	$SQL = "
	// 	SELECT
	// 	MIN (km) as menor,
	// 	MAX (km) as maior,
	// 	MAX(km)-MIN(km) as extensao
	// 	FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO 
	// 	WHERE (publicar like '%S%' or publicar is NULL) AND id_contrato_obra = " . $dados["id_contrato_obra"] . "
	// 	";
	// 	$query = $this->db->query($SQL);
	// 	return $query->result_array();
	// }
	public function medicaoexecutadatotal($dados) {
		$SQL = "
		SELECT
		af.extensao_atacado,
		(SELECT SUM(extensao_executado) FROM CGOB_TB_AVANCO_FISICO_EXECUTADO 
		WHERE publicar = 'S' AND id_avanco_fisico ='" . $dados["id"] . "' AND id_contrato_obra = " . $dados["id_contrato_obra"] . ") AS extensao_executada
		FROM CGOB_TB_AVANCO_FISICO AS af
		WHERE (af.publicar = 'S' or af.publicar is NULL) AND af.id_avanco_fisico ='" . $dados["id"] . "' AND af.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
		";

		$query = $this->db->query($SQL);
		return $query->result_array();;
	}
//-----------------------------------------------------------------------------------------------------------------------
	public function MedidaAtacado($dados) {
		$SQL = "
		SELECT
		af.val_inicial as Inicial_av,
		af.val_final as Final_av,
		af.extensao_atacado
		FROM CGOB_TB_AVANCO_FISICO AS af
		WHERE (af.publicar like '%S%' or af.publicar is NULL) and af.id_avanco_fisico ='" . $dados["id_avanco"] . "' AND id_contrato_obra = " . $dados["id_contrato_obra"] . "
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}
//-----------------------------------------------------------------------------------------------------------------------
	public function MedidaExecutado($dados) {
		$SQL = "
		SELECT
		af.val_inicial as Inicial_ex,
		af.val_final as Final_ex
		FROM CGOB_TB_AVANCO_FISICO_EXECUTADO AS af
		WHERE (af.publicar = 'S' or af.publicar is NULL) and af.id_avanco_fisico ='" . $dados["id_avanco"] . "' AND id_contrato_obra = " . $dados["id_contrato_obra"] . "
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-----------------------------------------------------------------------------------------------------------------
	public function returnExecutado($dados) {
		$SQL = "
		SELECT
		af.extensao_atacado,
		(SELECT SUM(extensao_executado) FROM CGOB_TB_AVANCO_FISICO_EXECUTADO 
		WHERE publicar = 'S' AND id_avanco_fisico ='" . $dados["id"] . "' AND id_contrato_obra = " . $dados["id_contrato_obra"] . ") AS extensao_executada
		FROM CGOB_TB_AVANCO_FISICO AS af
		WHERE (af.publicar = 'S' or af.publicar is NULL) AND af.id_avanco_fisico ='" . $dados["id"] . "' AND af.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}
//--------------------------------------------------------------------------------------------------------------------
	public function AtualizaAvanco($dados){
		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("id_avanco_fisico", $dados['id']);
		$this->db->where("publicar", "S");
		$this->db->set("extensao_executado", $dados['extensao_executada']);
		$this->db->set("publicar_versao", "S");
		$this->db->update("CGOB_TB_AVANCO_FISICO");

		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("id_avanco_fisico", $dados['id']);
		$this->db->where("publicar", "S");
		$this->db->set("publicar_versao", "S");
		$this->db->update("CGOB_TB_AVANCO_FISICO_EXECUTADO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//----------------------------------------------------------------------------------------------------------------------
	public function AvancoAquaviario_Trecho_Concluido($dados){
		$SQL = "
		SELECT 
		af.id_avanco_fisico as id,
		CONCAT(af.val_inicial,'',af.unidade_medida) as valInicial,
		CONCAT(af.val_final,'',af.unidade_medida) as valFinal,
		af.val_final,af.versao,
		af.unidade_medida,
		af.extensao_atacado, 
		af.status,
		af.tipo_obra,
		CASE
			WHEN af.obra = 1 THEN 'Construção Portuária'
			WHEN af.obra = 2 THEN 'Derrocagem'
			WHEN af.obra = 3 THEN 'Dragagem'
			WHEN af.obra = 4 THEN 'Desobstrução'
			WHEN af.obra = 5 THEN 'Recuperação Portuária'
			WHEN af.obra = 6 THEN 'Monitoramento Hidroviário'
			WHEN af.obra = 7 THEN 'Remoção Navio'
			WHEN af.obra = 8 THEN 'Implantação de Sinalização em Hidrovias'
			WHEN af.obra = 9 THEN 'Recuperação Eclusas e Barragens'
		END desc_obra,
		(SELECT  
		CASE
			WHEN mes = 01 THEN CONCAT('Janeiro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 02 THEN CONCAT('Fevereiro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 03 THEN CONCAT('Março',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 04 THEN CONCAT('Abril',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 05 THEN CONCAT('Maio',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 06 THEN CONCAT('Junho',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 07 THEN CONCAT('Julho',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 08 THEN CONCAT('Agosto',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 09 THEN CONCAT('Setembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 10 THEN CONCAT('Outubro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 11 THEN CONCAT('Novembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
			WHEN mes = 12 THEN CONCAT('Dezembro',' ',CAST(YEAR (periodo_referencia) as VARCHAR(4)))
		END as executado
		FROM CGOB_TB_AVANCO_FISICO_EXECUTADO  WHERE id_avanco_fisico = af.id_avanco_fisico AND id_avanco_executado = (SELECT MAX(id_avanco_executado)FROM CGOB_TB_AVANCO_FISICO_EXECUTADO WHERE id_avanco_fisico = af.id_avanco_fisico)) AS executado,
		CASE
			WHEN af.mes = 01 THEN CONCAT('Janeiro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 02 THEN CONCAT('Fevereiro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 03 THEN CONCAT('Março',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 04 THEN CONCAT('Abril',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 05 THEN CONCAT('Maio',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 06 THEN CONCAT('Junho',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 07 THEN CONCAT('Julho',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 08 THEN CONCAT('Agosto',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 09 THEN CONCAT('Setembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 10 THEN CONCAT('Outubro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 11 THEN CONCAT('Novembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 12 THEN CONCAT('Dezembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
		END as atacado,
		CONCAT(CONVERT(CHAR(10), af.ultima_alteracao , 103),' ', CONVERT(CHAR(8), af.ultima_alteracao , 114)) AS ultima_alteracao,
		(SELECT eixo FROM CGOB_TB_CONFIG_ITEM_EIXO  WHERE id_eixo = af.eixo) AS eixo,
		CASE 
			WHEN af.obra = 1 THEN (SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE af.servico = i.id_obra)
			WHEN af.obra = 2 THEN (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE af.servico = od.id_obra)
			WHEN af.obra = 3 THEN (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE af.servico = odra.id_obra)
			WHEN af.obra = 4 THEN (SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE af.servico = odes.id_obra)
			WHEN af.obra = 5 THEN (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE af.servico = opm.id_obra)
			WHEN af.obra = 6 THEN (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE af.servico = ocp.id_obra)
			WHEN af.obra = 7 THEN (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE af.servico = onh.id_obra)
			WHEN af.obra = 8 THEN (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE af.servico = osh.id_obra)
			WHEN af.obra = 9 THEN (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE af.servico = oe.id_obra)
		END AS servico,
		(SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
		FROM CGOB_TB_AVANCO_FISICO AS af
		WHERE (af.publicar_versao = 'S' AND af.publicar = 'S') AND
		af.id_contrato_obra = " . $dados["id_contrato_obra"] . "
		AND af.versao ='" . $dados["versao"] . "' 
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}
//----------------------------------------------------------------------------------------------------------------------
	public function insere_avanco_aquaviario_executado($dados){
		$this->db->set("id_contrato_obra", $dados["idContrato"]);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		//$this->db->set("val_inicial", $dados["inicial"]);
		$this->db->set("val_final", $dados["final"]);
		$this->db->set("id_servico", $dados["id"]);
		$this->db->set("id_obra", $dados["id_obra"]);
		$this->db->set("status","Executado");
		$this->db->set("mes", $dados["mes"]);
		$this->db->set("extensao_executado", $dados["extensao_executado"]);
		$this->db->set("unidade_medida_exec", $dados["medicaoexecutado"]);
		$this->db->set("publicar", "S");
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->set("id_avanco_fisico", $dados["id_executado"]);
		$this->db->insert("CGOB_TB_AVANCO_FISICO_EXECUTADO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//----------------------------------------------------------------------------------------------------------------------
	public function insere_avanco_aquaviario_executado_anterior($dados){
		$this->db->set("id_contrato_obra", $dados["idContrato"]);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		//$this->db->set("val_inicial", $dados["inicial_ca"]);
		$this->db->set("val_final", $dados["final_ca"]);
		$this->db->set("eixo", $dados["id_eixo"]);
		$this->db->set("servico", $dados["id_servico"]);
		$this->db->set("versao", $dados["versao"]);
		$this->db->set("obra", $dados['id_obra']);
		$this->db->set("tipo_obra", $dados['tipo']);
		$this->db->set("status", $dados["status"]);
		$this->db->set("unidade_medida", $dados["medicao"]);
		$this->db->set("mes", $dados["mes"]);
		$this->db->set("extensao_atacado_ca", $dados["extensao"]);
		$this->db->set("extensao_executado_ca", $dados["extensao"]);
		$this->db->set("publicar", "S");
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("periodo_referencia", $dados["periodo"]);

		$this->db->insert("CGOB_TB_AVANCO_FISICO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//----------------------------------------------------------------------------------------------------------------------
	public function AvancoAquaviario_Trecho_Concluido_Contrato_Anterior($dados){
		$SQL = "
		SELECT 
		af.id_avanco_fisico as id,
		CONCAT(af.val_inicial,'',af.unidade_medida) as valInicial,
		CONCAT(af.val_final,'',af.unidade_medida) as valFinal,
		af.val_final,af.versao,
		af.unidade_medida,
		af.extensao_atacado_ca, 
		af.extensao_executado_ca, 
		af.status,
		af.tipo_obra,
		CASE
			WHEN af.obra = 1 THEN 'Construção Portuária'
			WHEN af.obra = 2 THEN 'Derrocagem'
			WHEN af.obra = 3 THEN 'Dragagem'
			WHEN af.obra = 4 THEN 'Desobstrução'
			WHEN af.obra = 5 THEN 'Recuperação Portuária'
			WHEN af.obra = 6 THEN 'Monitoramento Hidroviário'
			WHEN af.obra = 7 THEN 'Remoção Navio'
			WHEN af.obra = 8 THEN 'Implantação de Sinalização em Hidrovias'
			WHEN af.obra = 9 THEN 'Recuperação Eclusas e Barragens'
		END desc_obra,
		CONCAT(CONVERT(CHAR(10), af.ultima_alteracao , 103),' ', CONVERT(CHAR(8), af.ultima_alteracao , 114)) AS ultima_alteracao,
		CASE
			WHEN af.mes = 01 THEN CONCAT('Janeiro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 02 THEN CONCAT('Fevereiro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 03 THEN CONCAT('Março',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 04 THEN CONCAT('Abril',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 05 THEN CONCAT('Maio',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 06 THEN CONCAT('Junho',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 07 THEN CONCAT('Julho',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 08 THEN CONCAT('Agosto',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 09 THEN CONCAT('Setembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 10 THEN CONCAT('Outubro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 11 THEN CONCAT('Novembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
			WHEN af.mes = 12 THEN CONCAT('Dezembro',' ',CAST(YEAR (af.periodo_referencia) as VARCHAR(4)))
		END as atacado_executado,
		(SELECT eixo FROM CGOB_TB_CONFIG_ITEM_EIXO  WHERE id_eixo = af.eixo) AS eixo,
		CASE 
			WHEN af.obra = 1 THEN (SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE af.servico = i.id_obra)
			WHEN af.obra = 2 THEN (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE af.servico = od.id_obra)
			WHEN af.obra = 3 THEN (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE af.servico = odra.id_obra)
			WHEN af.obra = 4 THEN (SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE af.servico = odes.id_obra)
			WHEN af.obra = 5 THEN (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE af.servico = opm.id_obra)
			WHEN af.obra = 6 THEN (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE af.servico = ocp.id_obra)
			WHEN af.obra = 7 THEN (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE af.servico = onh.id_obra)
			WHEN af.obra = 8 THEN (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE af.servico = osh.id_obra)
			WHEN af.obra = 9 THEN (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE af.servico = oe.id_obra)
		END AS servico,
		(SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
		FROM CGOB_TB_AVANCO_FISICO AS af
		WHERE af.publicar ='S' AND af.status like '%executado%'  AND
		af.id_contrato_obra = " . $dados["idContrato"] . " AND
		af.versao ='" . $dados["versao"] . "' 
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}
//----------------------------------------------------------------------------------------------------------------------
	public function trashContratoAnterior($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_avanco_fisico", $dados['id']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_AVANCO_FISICO");

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
	public function aquaviario_medicao_executado_concluido($dados) {
		$SQL = "
		SELECT
		ae.id_avanco_executado as id,
		CONCAT(ae.val_inicial,'',ae.unidade_medida_exec) as valInicial,
		CONCAT(ae.val_final,'',ae.unidade_medida_exec) as valFinal,
		ae.val_final as vf,
		ae.unidade_medida_exec as med,
		ae.id_avanco_fisico as id_tabular,
		CASE
			WHEN ae.mes = 01 THEN CONCAT('Janeiro',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 02 THEN CONCAT('Fevereiro',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 03 THEN CONCAT('Março',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 04 THEN CONCAT('Abril',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 05 THEN CONCAT('Maio',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 06 THEN CONCAT('Junho',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 07 THEN CONCAT('Julho',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 08 THEN CONCAT('Agosto',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 09 THEN CONCAT('Setembro',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 10 THEN CONCAT('Outubro',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 11 THEN CONCAT('Novembro',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
			WHEN ae.mes = 12 THEN CONCAT('Dezembro',' ',CAST(YEAR (ae.periodo_referencia) as VARCHAR(4)))
		END as periodo,
		ae.status     
		FROM CGOB_TB_AVANCO_FISICO_EXECUTADO AS ae
		WHERE ae.publicar = 'S' AND ae.id_avanco_fisico = " . $dados["id_tabular"] . " AND ae.id_contrato_obra = " . $dados["idContrato"] . "
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}
//----------------------------------------------------------------------------------------------------------------------
	public function trashmedicaoExecutado($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_avanco_executado", $dados['id']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_AVANCO_FISICO_EXECUTADO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//-----------------------------------------------------------------------------------------------------------------
	public function trashExecutadoConcluido($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_avanco_fisico", $dados['id_tabular']);
		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->set("publicar_versao", "N");
		$this->db->update("CGOB_TB_AVANCO_FISICO");

		$this->db->where("id_avanco_executado", $dados['id']);
		$this->db->set("publicar", "N");
		$this->db->set("publicar_versao", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_AVANCO_FISICO_EXECUTADO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//-----------------------------------------------------------------------------------------------------------------
	public function RecuperaExecutado($dados) {
		$SQL = "            
		SELECT count (id_avanco_executado) conte                
		FROM CGOB_TB_AVANCO_FISICO_EXECUTADO 
		WHERE (publicar = 'S' OR publicar IS NULL)
		AND id_avanco_fisico = '" . $dados["id"] . "'";
		$query = $this->db->query($SQL);
		return $query->result_array();
	}
//----------------------------------------------------------------------------------------------------------------------
	public function atacadodaqtrash($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_avanco_fisico", $dados['id']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_AVANCO_FISICO");

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
	public function AvancoAquaviario_naohouveatividademes($dados){
		$SQL = "
		SELECT
		id_avanco_fisico as id 
		,CASE WHEN flag_atividade = 'N' THEN 'Não houve atividade no mês' END atividademes
		,CONCAT(CONVERT(CHAR(10), ultima_alteracao , 103),' ', CONVERT(CHAR(8), ultima_alteracao , 114)) AS ultima_alteracao
		,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
		FROM CGOB_TB_AVANCO_FISICO AS af
		WHERE publicar = 'S' AND flag_atividade = 'N'AND id_contrato_obra =" . $dados["idContrato"] ." AND periodo_referencia ='" .$dados["periodo"] ."' 		  
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}
//-----------------------------------------------------------------------------------------------------------------------
	public function insere_naohouveatividademes($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set('id_contrato_obra', $dados['idContrato']);
		$this->db->set('periodo_referencia', $dados['periodo']);
		$this->db->set('publicar', 'S');
		$this->db->set('flag_atividade', 'N');
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set('id_usuario', $dados['idUsuario']);

		$this->db->insert("CGOB_TB_AVANCO_FISICO");
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
	public function NaoHouveAtividadedaq($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_avanco_fisico", $dados['id']);
		$this->db->set('flag_atividade', 'S');
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_AVANCO_FISICO");

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
//# DNIT - AQUAVIARIO - FALCONI
//# Desenvolvedora:Jordana de Alencar
//# Data: 06/06/2020 
//# Data: 03/08/2020 
//########################################################################################################################################################################################################################