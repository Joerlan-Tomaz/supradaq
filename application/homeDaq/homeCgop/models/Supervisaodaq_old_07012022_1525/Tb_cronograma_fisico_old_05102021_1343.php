<?php
/*
 * Classe model Tb_cronograma_fisico. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage model 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_cronograma_fisico extends CI_Model {

	public function __construct()
	{
		parent ::__construct();
		$this->db = $this->load->database('DAQ', TRUE); 
	}

//---------------------------------------------------------------------------------------------------------
	// public function CronogramaPublicado($dados){
	// 	$SQL = "
	// 	SELECT
	// 		v.id_cronograma,
	// 		v.versao,
	// 		v.id_eixo,
	// 		tpe.eixo,
	// 		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = v.id_usuario) AS nome,
	// 		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = v.id_usuario_publicar) AS nome_publi, 
	// 		concat( CONVERT(CHAR(10),v.ultima_alteracao , 103),' ', CONVERT(CHAR(8),v.ultima_alteracao , 114)) AS data_cronograma,
	// 		concat( CONVERT(CHAR(10),v.data_publicar , 103),' ', CONVERT(CHAR(8),v.data_publicar , 114)) AS data_publicacao
	// 	FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO as v
	// 	INNER JOIN CGOB_TB_CONFIG_ITEM_EIXO tpe ON tpe.id_eixo = v.id_eixo
	// 	WHERE (v.publicar_cronograma = 'S') AND v.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'

	// 	";
	// 	$query = $this->db->query($SQL);
	// 	return $query->result();
	// }

//---------------------------------------------------------------------------------------------
	public function recuperaObra() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
//-----------------------------------------------Servicos----------------------------------------------
	public function recuperaObraConstrucao() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_CONSTRUCAO");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
    //---------------------------------------------------------------------------------------------
	public function recuperaObraDerrocagem() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_DERROCAMENTO");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraDragagem() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_DRAGAGEM");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraDesobstrucao() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_DESOBSTRUCAO");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraRecuperacao() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_RECUPERACAO");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraMonitoramento() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_MONITORAMENTO");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraNavioHaider() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraSinalHidro() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO");
		$this->db->where("unidade !=", 'N/A');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	//---------------------------------------------------------------------------------------------
	public function recuperaObraEclusas() {
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_ECLUSAS");
		$this->db->where("unidade !=", 'N/A');
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
//---------------------------------------------------------------------------------------------
		public function Validar_Porcentagem($dados) {
		$SQL = "
		SELECT
		SUM(cf.valor_medido) as valor
		FROM CGOB_TB_CRONOGRAMA_FISICO cf
		WHERE (cf.publicar = 'S') AND cf.publicar_versao = 'N' AND cf.id_obra ='" . $dados["id_obra"] . "'  AND cf.id_servico ='" . $dados["id_servico"] . "'  AND cf.versao ='" . $dados["versao"] . "' AND cf.id_contrato_obra = " . $dados["id_contrato_obra"] . "
		";
		$query = $this->db->query($SQL);
		return $query->result_array();
	}
//---------------------------------------------------------------------------------------------
		public function publicar_porcentagem($dados) {
		$SQL = "
		SELECT
		CASE 
		 WHEN (SUM(valor_medido) < 100) THEN 'false'
		
		 WHEN (SUM(valor_medido) is null or SUM(valor_medido) like '' or (SUM(valor_medido) >= 100)) THEN 'true'		 
		 
		 END as result
		FROM CGOB_TB_CRONOGRAMA_FISICO 
		WHERE (publicar like '%S%' and publicar_versao like '%N%') AND unidade_medida in ('%') AND id_contrato_obra = " . $dados["id_contrato_obra"] . "

		group by id_obra, id_servico

		HAVING SUM(valor_medido) < 100
		";
		$query = $this->db->query($SQL);
		return $query->result_array();
	}
//---------------------------------------------------------------------------------------------
	public function CronogramaPublicado($dados){
		$SQL = "
		SELECT
		v.id_eixo,
		tpe.eixo,
		MIN (g.km) as menor,
		MAX (g.km) as maior,
		MAX(g.km)-MIN(g.km) as extensao,
		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = MAX(v.id_usuario)) AS nome,
		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = MAX(v.id_usuario_publicar)) AS nome_publi, 
		MAX(v.id_cronograma) as id_cronograma,
		MAX(v.versao) as versao,
		MAX(concat( CONVERT(CHAR(10),v.ultima_alteracao , 103),' ', CONVERT(CHAR(8),v.ultima_alteracao , 114))) AS data_cronograma,
		MAX(concat( CONVERT(CHAR(10),v.data_publicar , 103),' ', CONVERT(CHAR(8),v.data_publicar , 114))) AS data_publicacao
		FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO as v 
		INNER JOIN CGOB_TB_CONFIG_ITEM_EIXO as tpe ON tpe.id_eixo = v.id_eixo
		FULL OUTER JOIN CGOB_TB_CONFIG_GEORREFERENCIAMENTO AS g ON v.id_eixo = g.eixo
		WHERE v.publicar_cronograma = 'S' AND v.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
		group by v.id_eixo, tpe.eixo
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}
//---------------------------------------------------------------------------------------------------
	public function recuperaEixo($dados){
		$SQL = "
		SELECT 
		cg.id_contrato_obra as idContrato,
		cg.eixo as id_eixo, 
		ci.eixo as nome
		FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO  AS cg
		INNER JOIN CGOB_TB_CONFIG_ITEM_EIXO AS ci ON cg.eixo = ci.id_eixo
		WHERE cg.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
		AND cg.eixo = " . $dados["id_eixo"] ."
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}
//---------------------------------------------------------------------------------------------------
	public function CronogramaNaoPublicado($dados) {
		$SQL = "
		SELECT 
		distinct(g.eixo) as id_eixo,
		item.eixo,
		MAX (g.km) as maior,
		MAX(g.km)-MIN(g.km) as extensao,
		v.id_usuario, 
		CASE 
			WHEN v.versao IS NULL THEN '0' 
			ELSE v.versao 
			END as versao, 
			CASE 
			WHEN v.id_cronograma IS NULL THEN '0' 
			ELSE v.id_cronograma 
			END as id_cronograma, 
			CASE 
			WHEN v.publicar_cronograma IS NULL OR v.publicar_cronograma = 'N' THEN 'Não' 
			WHEN v.publicar_cronograma = 'S' THEN 'Sim' 
			ELSE v.publicar_cronograma 
		END as publicado, 
		(SELECT u.desc_nome FROM TB_USUARIO AS u WHERE u.id_usuario= v.id_usuario) nome,
		(SELECT count(1)publicar_versao FROM CGOB_TB_CRONOGRAMA_FISICO as f WHERE f.id_eixo = g.eixo and f.publicar_versao = 'N' and f.publicar = 'S' and f.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' and f.versao = v.versao) publicar

		FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO AS g
		INNER JOIN CGOB_TB_CONFIG_ITEM_EIXO AS item ON item.id_eixo = g.eixo
		FULL OUTER JOIN CGOB_TB_CRONOGRAMA_FISICO_VERSAO AS v  ON v.id_eixo = g.eixo AND v.publicar_cronograma = 'N' AND v.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
		WHERE (g.publicar = 'S' OR g.publicar IS NULL) AND g.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
		";

		$SQL .= " group by g.eixo,item.eixo, v.id_usuario, v.versao, v.id_cronograma,v.publicar_cronograma ";
		
		$query = $this->db->query($SQL);
		return $query->result();
	}
//---------------------------------------------------------------------------------------------
	public function recuperaVersao($dados){
		$SQL = "
		SELECT
		id_cronograma_fisico_versao, 
		versao, 
		id_cronograma, 
		publicar_cronograma
		FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO
		WHERE id_cronograma_fisico_versao = (SELECT MAX(id_cronograma_fisico_versao) FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO where id_contrato_obra = '". $dados["id_contrato_obra"] ."' and id_eixo= '1') 
		";
		$query = $this->db->query($SQL);
		return $query->result();
	}
//---------------------------------------------------------------------------------------------
	public function insereVersao($dados){
		$this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_eixo", $dados['id_eixo']);
		$this->db->set("publicar_cronograma", "N");
		$this->db->set("versao", $dados['versao']);
		$this->db->set("id_cronograma", $dados['id_cronograma']);
		$this->db->insert("CGOB_TB_CRONOGRAMA_FISICO_VERSAO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//---------------------------------------------------------------------------------------------
	public function insereCronogramaFisico($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("id_eixo", $dados["id_eixo"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("publicar", "S");
		$this->db->set("id_servico", $dados['id_servico']);
		$this->db->set("id_obra", $dados['id_obra']);
		$this->db->set("tipo_obra", $dados['tipo']);
		$this->db->set("unidade_medida", $dados["medicao"]);
		//$this->db->set("valor_inicial", $dados['valor_inicial']);
		$this->db->set("valor_medido", $dados['valor_medido']);
		$this->db->set("extensao_total", $dados['total']);
		$this->db->set("ano", $dados['ano']);
		$this->db->set("mes", $dados['mes']);
		$this->db->set("id_cronograma_fisico_versao", $dados['id_cronograma_fisico_versao']);
		$this->db->set("versao", $dados['versao']);
		$this->db->set("id_cronograma", $dados['id_cronograma']);
		$this->db->set("publicar_versao", "N");
		$this->db->insert("CGOB_TB_CRONOGRAMA_FISICO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			//return $this->db->insert_id();;
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

//-------------------------------------------------------------------------------------------------
	public function ServicosInseridosAquaviario($dados){
		$SQL = "
		SELECT 
		distinct(cf.id_cronograma_fisico),
		CONCAT(cf.valor_medido,'',cf.unidade_medida) as unidade_total,
		cf.id_eixo,
		cf.versao,
		cf.id_cronograma,
		cf.tipo_obra,
		cf.id_obra,
		cf.id_servico,
		cf.valor_medido as vm,
		cf.unidade_medida as un,
		CASE
			WHEN cf.id_obra = 1 THEN 'Construção Portuária'
			WHEN cf.id_obra = 2 THEN 'Derrocagem'
			WHEN cf.id_obra = 3 THEN 'Dragagem'
			WHEN cf.id_obra = 4 THEN 'Desobstrução'
			WHEN cf.id_obra = 5 THEN 'Recuperação Portuária'
			WHEN cf.id_obra = 6 THEN 'Monitoramento Hidroviário'
			WHEN cf.id_obra = 7 THEN 'Remoção Navio'
			WHEN cf.id_obra = 8 THEN 'Implantação de Sinalização em Hidrovias'
			WHEN cf.id_obra = 9 THEN 'Recuperação Eclusas e Barragens'
		END desc_obra, 
		CASE 
			WHEN cf.id_obra = 1 THEN (SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE cf.id_servico = i.id_obra)
			WHEN cf.id_obra = 2 THEN (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE cf.id_servico = od.id_obra)
			WHEN cf.id_obra = 3 THEN (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE cf.id_servico = odra.id_obra)
			WHEN cf.id_obra = 4 THEN (SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE cf.id_servico = odes.id_obra)
			WHEN cf.id_obra = 5 THEN (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE cf.id_servico = opm.id_obra)
			WHEN cf.id_obra = 6 THEN (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE cf.id_servico = ocp.id_obra)
			WHEN cf.id_obra = 7 THEN (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE cf.id_servico = onh.id_obra)
			WHEN cf.id_obra = 8 THEN (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE cf.id_servico = osh.id_obra)
			WHEN cf.id_obra = 9 THEN (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE cf.id_servico = oe.id_obra)
		END AS desc_servico,
		CASE
			WHEN cf.mes = 1 THEN concat('Janeiro','/',cf.ano)
			WHEN cf.mes = 2 THEN concat('Fevereiro','/',cf.ano)
			WHEN cf.mes = 3 THEN concat('Março','/',cf.ano)
			WHEN cf.mes = 4 THEN concat('Abril','/',cf.ano)
			WHEN cf.mes = 5 THEN concat('Maio','/',cf.ano)
			WHEN cf.mes = 6 THEN concat('Junho','/',cf.ano)
			WHEN cf.mes = 7 THEN concat('Julho','/',cf.ano)
			WHEN cf.mes = 8 THEN concat('Agosto','/',cf.ano)
			WHEN cf.mes = 9 THEN concat('Setembro','/',cf.ano)
			WHEN cf.mes = 10 THEN concat('Outubro','/',cf.ano)
			WHEN cf.mes = 11 THEN concat('Novembro','/',cf.ano)
			WHEN cf.mes = 12 THEN concat('Dezembro','/',cf.ano)
		END as mes_ano, 
		CASE
		WHEN cf.publicar_versao = 'N' THEN 'Não Publicado'
		WHEN cf.publicar_versao = 'S' THEN 'Publicado'
		END as publicar, 
		u.DESC_NOME as nome, 
		concat( CONVERT(CHAR(10),cf.ultima_alteracao , 103),' ', CONVERT(CHAR(8),cf.ultima_alteracao , 114)) AS ultima_alteracao
		FROM CGOB_TB_CRONOGRAMA_FISICO cf
		
		INNER JOIN TB_USUARIO AS u ON u.id_usuario = cf.id_usuario
		INNER JOIN CGOB_TB_CRONOGRAMA_FISICO_VERSAO as v on v.versao = cf.versao
		WHERE cf.publicar = 'S'AND cf.publicar_versao = 'N' AND cf.id_eixo = '" . $dados["id_eixo"] . "'
		";
		
		if (!empty($dados["id_contrato_obra"])) {	
			$SQL .= "AND cf.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' ";
		}
	
		$query = $this->db->query($SQL);
		return $query->result();
	}

//---------------------------------------------------------------------------------------------------------
	public function TotalServicoAquaviario($dados){	
		$SQL ="
		SELECT
		SUM(cf.extensao_total) as executado_total,
		MAX(cf.valor_medido) as valor_medido
		FROM CGOB_TB_CRONOGRAMA_FISICO as cf
		WHERE cf.publicar = 'S' AND cf.publicar_versao = 'N' AND cf.id_eixo = '1' AND cf.id_contrato_obra = '". $dados["id_contrato_obra"] ."'
		";

		if (!empty($dados["id_cronograma"])) {
			$SQL .= " AND cf.id_cronograma = '" . $dados["id_cronograma"] . "' ";
		}
		if (!empty($dados["versao"])) {
			$SQL .= " AND cf.versao = '" . $dados["versao"] . "' ";
		}
		
		$query = $this->db->query($SQL);
		return $query->result_array();
	}	
//---------------------------------------------------------------------------------------------------------
	public function excluirItem($dados){
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_cronograma_fisico", $dados['id_cronograma_fisico']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_CRONOGRAMA_FISICO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//---------------------------------------------------------------------------------------------------------
	public function RecuperaGeorreferenciamento($dados){
		$SQL = "
		SELECT 
		id_cronograma_fisico,
		id_eixo
		FROM CGOB_TB_CRONOGRAMA_FISICO
		WHERE id_eixo = " .$dados["id_eixo"]. "
		AND id_contrato_obra =" .$dados['idContrato']
		;

		$query = $this->db->query($SQL);
		return $query->result();
	}
//---------------------------------------------------------------------------------------------------------
	public function DetalhadoNaoPublicado($dados){
		$SQL = "
		SELECT 
		cf.id_cronograma_fisico,
		cf.tipo_obra,
		CASE
			WHEN cf.id_obra = 1 THEN 'Construção Portuária'
			WHEN cf.id_obra = 2 THEN 'Derrocagem'
			WHEN cf.id_obra = 3 THEN 'Dragagem'
			WHEN cf.id_obra = 4 THEN 'Desobstrução'
			WHEN cf.id_obra = 5 THEN 'Recuperação Portuária'
			WHEN cf.id_obra = 6 THEN 'Monitoramento Hidroviário'
			WHEN cf.id_obra = 7 THEN 'Remoção Navio'
			WHEN cf.id_obra = 8 THEN 'Implantação de Sinalização em Hidrovias'
			WHEN cf.id_obra = 9 THEN 'Recuperação Eclusas e Barragens'
		END desc_obra, 
		CASE 
			WHEN cf.id_obra = 1 THEN (SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE cf.id_servico = i.id_obra)
			WHEN cf.id_obra = 2 THEN (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE cf.id_servico = od.id_obra)
			WHEN cf.id_obra = 3 THEN (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE cf.id_servico = odra.id_obra)
			WHEN cf.id_obra = 4 THEN (SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE cf.id_servico = odes.id_obra)
			WHEN cf.id_obra = 5 THEN (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE cf.id_servico = opm.id_obra)
			WHEN cf.id_obra = 6 THEN (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE cf.id_servico = ocp.id_obra)
			WHEN cf.id_obra = 7 THEN (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE cf.id_servico = onh.id_obra)
			WHEN cf.id_obra = 8 THEN (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE cf.id_servico = osh.id_obra)
			WHEN cf.id_obra = 9 THEN (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE cf.id_servico = oe.id_obra)
		END AS desc_servico, 
		CASE
			WHEN cf.mes = 1 THEN concat('Janeiro','/',cf.ano)
			WHEN cf.mes = 2 THEN concat('Fevereiro','/',cf.ano)
			WHEN cf.mes = 3 THEN concat('Março','/',cf.ano)
			WHEN cf.mes = 4 THEN concat('Abril','/',cf.ano)
			WHEN cf.mes = 5 THEN concat('Maio','/',cf.ano)
			WHEN cf.mes = 6 THEN concat('Junho','/',cf.ano)
			WHEN cf.mes = 7 THEN concat('Julho','/',cf.ano)
			WHEN cf.mes = 8 THEN concat('Agosto','/',cf.ano)
			WHEN cf.mes = 9 THEN concat('Setembro','/',cf.ano)
			WHEN cf.mes = 10 THEN concat('Outubro','/',cf.ano)
			WHEN cf.mes = 11 THEN concat('Novembro','/',cf.ano)
			WHEN cf.mes = 12 THEN concat('Dezembro','/',cf.ano)
		END as mes_ano, 
		CONCAT(cf.valor_medido,'',cf.unidade_medida) as unidade_total,
		cf.id_obra,
		cf.id_servico,
		cf.valor_medido,
		cf.unidade_medida as un,
		CASE
			WHEN cf.publicar_versao = 'N' THEN 'Não Publicado'
			WHEN cf.publicar_versao = 'S' THEN 'Publicado'
		END as publicar, 
		u.DESC_NOME as nome, 
		concat( CONVERT(CHAR(10),cf.ultima_alteracao , 103),' ', CONVERT(CHAR(8),cf.ultima_alteracao , 114)) AS ultima_alteracao,
		cf.versao
		FROM CGOB_TB_CRONOGRAMA_FISICO cf
		INNER JOIN TB_USUARIO AS u ON u.id_usuario = cf.id_usuario
		WHERE cf.publicar_versao = 'N' and cf.publicar = 'S'
		";
		
		if (!empty($dados["id_contrato_obra"])) {	
			$SQL .= " AND cf.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' ";
		}
		if (!empty($dados["id_eixo"])) {
			$SQL .= " AND cf.id_eixo = '" . $dados["id_eixo"] . "' ";
		}
		if (!empty($dados["id_cronograma"])) {
			$SQL .= " AND cf.id_cronograma = '" . $dados["id_cronograma"] . "' ";
		}
		if (!empty($dados["versao"])) {
			$SQL .= " AND cf.versao = '" . $dados["versao"] . "' ";
		}
		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------
	public function PublicarCronograma_naopublicado($dados){
		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']); 
		$this->db->where("id_cronograma", $dados['id_cronograma']);
		$this->db->where("versao", $dados['versao']);
		$this->db->where("publicar", "S");
		$this->db->where("publicar_versao", "N");
		$this->db->where("id_eixo", $dados['id_eixo']);
		$this->db->set("publicar_versao", "S");
		$this->db->set("data_publicar_versao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar_versao", $dados["id_usuario"]);
		$this->db->update("CGOB_TB_CRONOGRAMA_FISICO");

		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("id_cronograma", $dados['id_cronograma']);
		$this->db->where("versao", $dados['versao']);
		$this->db->where("id_eixo", $dados['id_eixo']);
		$this->db->where("publicar_cronograma", "N");
		$this->db->set("publicar_cronograma", "S");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados["id_usuario"]);
		$this->db->update("CGOB_TB_CRONOGRAMA_FISICO_VERSAO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}
//-----------------------------------------------------------------------------------------------------------------
	public function acompanhementofisico($dados){
		$SQL = "
		with previsto as (
			SELECT cf.id_obra as obra,
	 	'p' as identit, CASE WHEN cf.id_obra = 1 THEN CONCAT('Construção Portuária-',(SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE cf.id_servico = i.id_obra))
		WHEN cf.id_obra = 2 THEN CONCAT('Derrocagem-', (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE cf.id_servico = od.id_obra))
			WHEN cf.id_obra = 3 THEN CONCAT('Dragagem-', (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE cf.id_servico = odra.id_obra))
		WHEN cf.id_obra = 4 THEN CONCAT('Desobstrução-',(SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE cf.id_servico = odes.id_obra))
		WHEN cf.id_obra = 5 THEN CONCAT('Recuperação Portuária -', (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE cf.id_servico = opm.id_obra))
		WHEN cf.id_obra = 6 THEN CONCAT('Monitoramento Hidroviário-', (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE cf.id_servico = ocp.id_obra))
		WHEN cf.id_obra = 7 THEN CONCAT('Remoção Navio-', (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE cf.id_servico = onh.id_obra))
		WHEN cf.id_obra = 8 THEN CONCAT('Implantação de Sinalização em Hidrovias-', (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE cf.id_servico = osh.id_obra))
		WHEN cf.id_obra = 9 THEN CONCAT('Recuperação Eclusas e Barragens -',  (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE cf.id_servico = oe.id_obra))
		END servico,
		cf.unidade_medida,
		cf.ano,
		cf.mes,
		'2015-01-01' as maior,
		sum(cf.valor_medido) as valormedido
			FROM CGOB_TB_CRONOGRAMA_FISICO cf
			WHERE cf.publicar_versao like '%S%' and cf.publicar like '%S%' AND cf.id_contrato_obra= '" . $dados["id_contrato_obra"] . "' and cf.versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FISICO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "' and publicar_versao like '%S%' and publicar like '%S%') 
			group by cf.id_obra, cf.id_servico, cf.ano, cf.mes, cf.unidade_medida
		union all
			select
			af.obra as obra, 
			'c' as identit, CASE WHEN af.obra = 1 THEN CONCAT('Construção Portuária-',(SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE af.servico = i.id_obra))
			WHEN af.obra = 2 THEN CONCAT('Derrocagem-',(SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE af.servico = od.id_obra))
			WHEN af.obra = 3 THEN CONCAT('Dragagem-',(SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE af.servico = odra.id_obra))
			WHEN af.obra = 4 THEN CONCAT('Desobstrução-',(SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE af.servico = odes.id_obra))
			WHEN af.obra = 5 THEN CONCAT('Recuperação Portuária -',(SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE af.servico = opm.id_obra))
			WHEN af.obra = 6 THEN CONCAT('Monitoramento Hidroviário-',(SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE af.servico = ocp.id_obra))
			WHEN af.obra = 7 THEN CONCAT('Remoção Navio-',(SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE af.servico = onh.id_obra))
			WHEN af.obra = 8 THEN CONCAT('Implantação de Sinalização em Hidrovias-',(SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE af.servico = osh.id_obra))
			WHEN af.obra = 9 THEN CONCAT('Recuperação Eclusas e Barragens -',(SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE af.servico = oe.id_obra))
			END  servico,
			af.unidade_medida,
		year(af.periodo_referencia) as ano,
			af.mes,
			max(convert(varchar(10),af.periodo_referencia)) AS maior ,
		sum(af.val_final)as valormedido
		FROM CGOB_TB_AVANCO_FISICO af
			WHERE af.publicar_versao = 'S' AND af.publicar like '%S%' AND af.id_contrato_obra= '" . $dados["id_contrato_obra"] . "' AND af.versao = (SELECT MAX(versao) FROM CGOB_TB_AVANCO_FISICO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "') 
		group by af.obra, af.servico, year(af.periodo_referencia),af.mes, af.unidade_medida, af.periodo_referencia
		)select servico, ano, unidade_medida, isnull(SUM(CASE WHEN mes = 1 and identit ='p' 
		THEN valormedido ELSE 0 END),0) previsto_01, isnull(SUM(CASE WHEN mes = 2 and identit ='p' 
		THEN valormedido ELSE 0 END),0) previsto_02, isnull(SUM(CASE WHEN mes = 3 and identit ='p' 
				THEN valormedido ELSE 0 END),0) previsto_03,isnull(SUM(CASE WHEN mes = 4 and identit ='p' 
				THEN valormedido ELSE 0 END),0) previsto_04,isnull(SUM(CASE WHEN mes = 5 and identit ='p' 
				THEN valormedido ELSE 0 END),0) previsto_05,isnull(SUM(CASE WHEN mes = 6 and identit ='p' 
				THEN valormedido ELSE 0 END),0) previsto_06,isnull(SUM(CASE WHEN mes = 7 and identit ='p'
				THEN valormedido ELSE 0 END),0) previsto_07,isnull(SUM(CASE WHEN mes = 8 and identit ='p' 
				THEN valormedido ELSE 0 END),0) previsto_08,isnull(SUM(CASE WHEN mes = 9 and identit ='p' 
				THEN valormedido ELSE 0 END),0) previsto_09,isnull(SUM(CASE WHEN mes = 10 and identit ='p'
				THEN valormedido ELSE 0 END),0) previsto_10,isnull(SUM(CASE WHEN mes = 11 and identit ='p' 
				THEN valormedido ELSE 0 END),0) previsto_11,isnull(SUM(CASE WHEN mes = 12 and identit ='p' 
				THEN valormedido ELSE 0 END),0)previsto_12,isnull(SUM(CASE WHEN mes = 1 and identit ='c' 
				THEN valormedido ELSE 0 END),0) concluido_01,isnull(SUM(CASE WHEN mes = 2 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_02,isnull(SUM(CASE WHEN mes = 3 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_03,isnull(SUM(CASE WHEN mes = 4 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_04,isnull(SUM(CASE WHEN mes = 5 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_05,isnull(SUM(CASE WHEN mes = 6 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_06,isnull(SUM(CASE WHEN mes = 7 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_07,isnull(SUM(CASE WHEN mes = 8 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_08,isnull(SUM(CASE WHEN mes = 9 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_09,isnull(SUM(CASE WHEN mes = 10 and identit ='c'
				 THEN valormedido ELSE 0 END),0) concluido_10,isnull(SUM(CASE WHEN mes = 11 and identit ='c' 
				 THEN valormedido ELSE 0 END),0) concluido_11,isnull(SUM(CASE WHEN mes = 12 and identit ='c' 
				 THEN valormedido ELSE 0 END),0)concluido_12,
				 	max(maior) as mesbreak
			from previsto group by obra, servico, ano, unidade_medida order by ano";
				$query = $this->db->query($SQL);
		return $query->result(); 
	}
	public function acompanhementofiisico($dados){
		$SQL = " with previsto as (
		SELECT
	 CASE WHEN cf.id_obra = 1 THEN CONCAT('Construção Portuária-',(SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE cf.id_servico = i.id_obra))
			WHEN cf.id_obra = 2 THEN CONCAT('Derrocagem-', (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE cf.id_servico = od.id_obra))
			WHEN cf.id_obra = 3 THEN CONCAT('Dragagem-', (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE cf.id_servico = odra.id_obra))
			WHEN cf.id_obra = 4 THEN CONCAT('Desobstrução-',(SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE cf.id_servico = odes.id_obra))
			WHEN cf.id_obra = 5 THEN CONCAT('Recuperação Portuária -', (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE cf.id_servico = opm.id_obra))
			WHEN cf.id_obra = 6 THEN CONCAT('Monitoramento Hidroviário-', (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE cf.id_servico = ocp.id_obra))
			WHEN cf.id_obra = 7 THEN CONCAT('Remoção Navio-', (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE cf.id_servico = onh.id_obra))
			WHEN cf.id_obra = 8 THEN CONCAT('Implantação de Sinalização em Hidrovias-', (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE cf.id_servico = osh.id_obra))
			WHEN cf.id_obra = 9 THEN CONCAT('Recuperação Eclusas e Barragens -',  (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE cf.id_servico = oe.id_obra))
		END servico,
		cf.ano,cf.mes,cf.unidade_medida,
		sum(cf.valor_medido) as valor_medido,
		(select isnull(SUM(valor_medido),0) from CGOB_TB_CRONOGRAMA_FISICO where ano = cf.ano) as ttano
		 
			FROM CGOB_TB_CRONOGRAMA_FISICO cf
			WHERE cf.publicar_versao = 'S' AND cf.id_contrato_obra= '" . $dados["id_contrato_obra"] . "' and cf.versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FISICO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "') 
			group by cf.id_obra, cf.id_servico, cf.ano, cf.mes, cf.unidade_medida
		),
		concluido as (
				select CASE WHEN af.obra = 1 THEN CONCAT('Construção Portuária-',(SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE af.servico = i.id_obra))
			WHEN af.obra = 2 THEN CONCAT('Derrocagem-',(SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE af.servico = od.id_obra))
			WHEN af.obra = 3 THEN CONCAT('Dragagem-',(SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE af.servico = odra.id_obra))
			WHEN af.obra = 4 THEN CONCAT('Desobstrução-',(SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE af.servico = odes.id_obra))
			WHEN af.obra = 5 THEN CONCAT('Recuperação Portuária -',(SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE af.servico = opm.id_obra))
			WHEN af.obra = 6 THEN CONCAT('Monitoramento Hidroviário-',(SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE af.servico = ocp.id_obra))
			WHEN af.obra = 7 THEN CONCAT('Remoção Navio-',(SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE af.servico = onh.id_obra))
			WHEN af.obra = 8 THEN CONCAT('Implantação de Sinalização em Hidrovias-',(SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE af.servico = osh.id_obra))
			WHEN af.obra = 9 THEN CONCAT('Recuperação Eclusas e Barragens -',(SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE af.servico = oe.id_obra))
			END AS servico,
		year(af.periodo_referencia) as ano,
			af.mes,af.unidade_medida,
		sum(af.val_final)as val_final,
				 (select isnull(SUM(val_final),0) from CGOB_TB_AVANCO_FISICO where year(periodo_referencia)  = year(af.periodo_referencia) ) as ttano
		FROM CGOB_TB_AVANCO_FISICO af
			WHERE af.publicar_versao = 'S' AND af.id_contrato_obra= '" . $dados["id_contrato_obra"] . "'
		group by af.obra, af.servico, year(af.periodo_referencia),af.mes, af.unidade_medida
		)select p.servico, p.ano,p.unidade_medida, isnull(SUM(CASE WHEN p.mes = 1 
		THEN p.valor_medido ELSE 0 END),0) previsto_01, isnull(SUM(CASE WHEN p.mes = 2  THEN p.valor_medido ELSE 0 END),0) previsto_02,isnull(SUM(CASE WHEN p.mes = 3  
		 	THEN p.valor_medido ELSE 0 END),0) previsto_03,isnull(SUM(CASE WHEN p.mes = 4  
		 	THEN p.valor_medido ELSE 0 END),0) previsto_04,isnull(SUM(CASE WHEN p.mes = 5 
		 	THEN p.valor_medido ELSE 0 END),0) previsto_05,isnull(SUM(CASE WHEN p.mes = 6  
		 	THEN p.valor_medido ELSE 0 END),0) previsto_06,isnull(SUM(CASE WHEN p.mes = 7  
		 	THEN p.valor_medido ELSE 0 END),0) previsto_07,isnull(SUM(CASE WHEN p.mes = 8  
		 	THEN p.valor_medido ELSE 0 END),0) previsto_08,isnull(SUM(CASE WHEN p.mes = 9  
		 	THEN p.valor_medido ELSE 0 END),0) previsto_09,isnull(SUM(CASE WHEN p.mes = 10 
			THEN p.valor_medido ELSE 0 END),0) previsto_10,isnull(SUM(CASE WHEN p.mes = 11  
		 	THEN p.valor_medido ELSE 0 END),0) previsto_11,isnull(SUM(CASE WHEN p.mes = 12  
		 	THEN p.valor_medido ELSE 0 END),0)previsto_12,isnull(SUM(CASE WHEN c.mes = 1 
		 	THEN c.val_final ELSE 0 END),0) concluido_01,isnull(SUM(CASE WHEN c.mes = 2  
			THEN c.val_final ELSE 0 END),0) concluido_02,isnull(SUM(CASE WHEN c.mes = 3  
			 THEN c.val_final ELSE 0 END),0) concluido_03,isnull(SUM(CASE WHEN c.mes = 4  
			 THEN c.val_final ELSE 0 END),0) concluido_04,isnull(SUM(CASE WHEN c.mes = 5 
			 THEN c.val_final ELSE 0 END),0) concluido_05,isnull(SUM(CASE WHEN c.mes = 6  
			 THEN c.val_final ELSE 0 END),0) concluido_06,isnull(SUM(CASE WHEN c.mes = 7  
			 THEN c.val_final ELSE 0 END),0) concluido_07,isnull(SUM(CASE WHEN c.mes = 8  
			 THEN c.val_final ELSE 0 END),0) concluido_08,isnull(SUM(CASE WHEN c.mes = 9  
			 THEN c.val_final ELSE 0 END),0) concluido_09,isnull(SUM(CASE WHEN c.mes = 10 
			 THEN c.val_final ELSE 0 END),0) concluido_10,isnull(SUM(CASE WHEN c.mes = 11  
			 THEN c.val_final ELSE 0 END),0) concluido_11,isnull(SUM(CASE WHEN c.mes = 12  
			 THEN c.val_final ELSE 0 END),0)concluido_12
			from previsto as p
				left join concluido as c on c.servico = p.servico and p.ano = c.ano and c.mes =p.mes
		group by p.servico,p.ano,p.unidade_medida";
				$query = $this->db->query($SQL);
		return $query->result();
	}
	public function acompanhementofisicocf($dados){
		$SQL = "
		SELECT 
		CASE
		WHEN cf.id_obra = 1 THEN CONCAT('Construção Portuária-',(SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE cf.id_servico = i.id_obra))
		WHEN cf.id_obra = 2 THEN CONCAT('Derrocagem-',(SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE cf.id_servico = od.id_obra))
		WHEN cf.id_obra = 3 THEN CONCAT('Dragagem-',(SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE cf.id_servico = odra.id_obra))
		WHEN cf.id_obra = 4 THEN CONCAT('Desobstrução-',(SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE cf.id_servico = odes.id_obra))
		WHEN cf.id_obra = 5 THEN CONCAT('Recuperação Portuária-',(SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE cf.id_servico = opm.id_obra))
		WHEN cf.id_obra = 6 THEN CONCAT('Monitoramento Hidroviário-',(SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE cf.id_servico = ocp.id_obra))
		WHEN cf.id_obra = 7 THEN CONCAT('Remoção Navio-',(SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE cf.id_servico = onh.id_obra))
		WHEN cf.id_obra = 8 THEN CONCAT('Implantação de Sinalização em Hidrovias-',(SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE cf.id_servico = osh.id_obra))
		WHEN cf.id_obra = 9 THEN CONCAT('Recuperação Eclusas e Barragens-',(SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE cf.id_servico = oe.id_obra))
		END servico,cf.ano,isnull(SUM(CASE WHEN cf.mes = 1 THEN cf.valor_medido ELSE 0 END),0) previsto_01,isnull(SUM(CASE WHEN cf.mes = 2  THEN cf.valor_medido ELSE 0 END),0) previsto_02,isnull(SUM(CASE WHEN cf.mes = 3  THEN cf.valor_medido ELSE 0 END),0) previsto_03,isnull(SUM(CASE WHEN cf.mes = 4  THEN cf.valor_medido ELSE 0 END),0) previsto_04,isnull(SUM(CASE WHEN cf.mes = 5 THEN cf.valor_medido ELSE 0 END),0) previsto_05,isnull(SUM(CASE WHEN cf.mes = 6  THEN cf.valor_medido ELSE 0 END),0) previsto_06,isnull(SUM(CASE WHEN cf.mes = 7  THEN cf.valor_medido ELSE 0 END),0) previsto_07,isnull(SUM(CASE WHEN cf.mes = 8  THEN cf.valor_medido ELSE 0 END),0) previsto_08,isnull(SUM(CASE WHEN cf.mes = 9  THEN cf.valor_medido ELSE 0 END),0) previsto_09,isnull(SUM(CASE WHEN cf.mes = 10 THEN cf.valor_medido ELSE 0 END),0) previsto_10,isnull(SUM(CASE WHEN cf.mes = 11  THEN cf.valor_medido ELSE 0 END),0) previsto_11,isnull(SUM(CASE WHEN cf.mes = 12  THEN cf.valor_medido ELSE 0 END),0)previsto_12 ,cf.unidade_medida
		FROM CGOB_TB_CRONOGRAMA_FISICO cf
		WHERE cf.publicar_versao = 'S' AND cf.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' and cf.versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FISICO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "') 
			group by cf.id_obra, cf.id_servico, cf.ano, cf.unidade_medida
			union all SELECT CASE
			WHEN af.obra = 1 THEN CONCAT('Construção Portuária-',(SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE af.servico = i.id_obra))
			WHEN af.obra = 2 THEN CONCAT('Derrocagem-',(SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE af.servico = od.id_obra))
			WHEN af.obra = 3 THEN CONCAT('Dragagem-',(SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE af.servico = odra.id_obra))
			WHEN af.obra = 4 THEN CONCAT('Desobstrução-',(SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE af.servico = odes.id_obra))
			WHEN af.obra = 5 THEN CONCAT('Recuperação Portuária-',(SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE af.servico = opm.id_obra))
			WHEN af.obra = 6 THEN CONCAT('Monitoramento Hidroviário-',(SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE af.servico = ocp.id_obra))
			WHEN af.obra = 7 THEN CONCAT('Remoção Navio-',(SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE af.servico = onh.id_obra))
			WHEN af.obra = 8 THEN CONCAT('Implantação de Sinalização em Hidrovias-',(SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE af.servico = osh.id_obra))
			WHEN af.obra = 9 THEN CONCAT('Recuperação Eclusas e Barragens-',(SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE af.servico = oe.id_obra))
		END AS servico,year(af.periodo_referencia) as ano,isnull(SUM(CASE WHEN af.mes = 1 THEN af.val_final ELSE 0 END),0) concluido_01,isnull(SUM(CASE WHEN af.mes = 2 THEN af.val_final ELSE 0 END),0) concluido_02,isnull(SUM(CASE WHEN af.mes = 3 THEN af.val_final ELSE 0 END),0) concluido_03,isnull(SUM(CASE WHEN af.mes = 4 THEN af.val_final ELSE 0 END),0) concluido_04,isnull(SUM(CASE WHEN af.mes = 5 THEN af.val_final ELSE 0 END),0) concluido_05,isnull(SUM(CASE WHEN af.mes = 6 THEN af.val_final ELSE 0 END),0) concluido_06,isnull(SUM(CASE WHEN af.mes = 7 THEN af.val_final ELSE 0 END),0) concluido_07,isnull(SUM(CASE WHEN af.mes = 8 THEN af.val_final ELSE 0 END),0) concluido_08,isnull(SUM(CASE WHEN af.mes = 9 THEN af.val_final ELSE 0 END),0) concluido_09,isnull(SUM(CASE WHEN af.mes = 10 THEN af.val_final ELSE 0 END),0) concluido_10,isnull(SUM(CASE WHEN af.mes = 11 THEN af.val_final ELSE 0 END),0) concluido_11,isnull(SUM(CASE WHEN af.mes = 12 THEN af.val_final ELSE 0 END),0) concluido_12,
		af.unidade_medida
		 		FROM CGOB_TB_AVANCO_FISICO af
		WHERE af.publicar = 'S' AND af.id_contrato_obra= '" . $dados["id_contrato_obra"] . "'
			group by af.obra, af.servico, af.periodo_referencia,af.unidade_medida";
				$query = $this->db->query($SQL);
		return $query->result();
	}
	public function anoacompanhemtofisico($dados){
		$SQL = "
	select distinct ano from CGOB_TB_CRONOGRAMA_FISICO where publicar_versao like '%S%' and publicar like '%S%' and id_contrato_obra = '" . $dados["id_contrato_obra"] . "' AND versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FISICO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "' and publicar_versao like '%S%' and publicar like '%S%')  ";
					$query = $this->db->query($SQL);
		return $query->result(); 
	}

	public function mesacompanhemtofisico($dados){
		$SQL = "
	select max(mes) from CGOB_TB_AVANCO_FISICO where publicar_versao like '%S%' and publicar like '%S%' and id_contrato_obra = '" . $dados["id_contrato_obra"] . "' 
	and af.versao = (SELECT MAX(versao) FROM CGOB_TB_AVANCO_FISICO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "' AND periodo_referencia <= '". $dados["periodo"] ."')
	";
					$query = $this->db->query($SQL);
		return $query->result(); 
	}
//-----------------------------------------------------------------------------------------------------------------
	public function DetalhadoPublicado($dados){
		$SQL = "
		SELECT 
		cf.id_cronograma_fisico,
		cf.tipo_obra,
		CASE
			WHEN cf.id_obra = 1 THEN 'Construção Portuária'
			WHEN cf.id_obra = 2 THEN 'Derrocagem'
			WHEN cf.id_obra = 3 THEN 'Dragagem'
			WHEN cf.id_obra = 4 THEN 'Desobstrução'
			WHEN cf.id_obra = 5 THEN 'Recuperação Portuária'
			WHEN cf.id_obra = 6 THEN 'Monitoramento Hidroviário'
			WHEN cf.id_obra = 7 THEN 'Remoção Navio'
			WHEN cf.id_obra = 8 THEN 'Implantação de Sinalização em Hidrovias'
			WHEN cf.id_obra = 9 THEN 'Recuperação Eclusas e Barragens'
		END desc_obra, 
		CASE 
			WHEN cf.id_obra = 1 THEN (SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE cf.id_servico = i.id_obra)
			WHEN cf.id_obra = 2 THEN (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE cf.id_servico = od.id_obra)
			WHEN cf.id_obra = 3 THEN (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE cf.id_servico = odra.id_obra)
			WHEN cf.id_obra = 4 THEN (SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE cf.id_servico = odes.id_obra)
			WHEN cf.id_obra = 5 THEN (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE cf.id_servico = opm.id_obra)
			WHEN cf.id_obra = 6 THEN (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE cf.id_servico = ocp.id_obra)
			WHEN cf.id_obra = 7 THEN (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE cf.id_servico = onh.id_obra)
			WHEN cf.id_obra = 8 THEN (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE cf.id_servico = osh.id_obra)
			WHEN cf.id_obra = 9 THEN (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE cf.id_servico = oe.id_obra)
		END AS desc_servico, 
		CASE
			WHEN cf.mes = 1 THEN concat('Janeiro','/',cf.ano)
			WHEN cf.mes = 2 THEN concat('Fevereiro','/',cf.ano)
			WHEN cf.mes = 3 THEN concat('Março','/',cf.ano)
			WHEN cf.mes = 4 THEN concat('Abril','/',cf.ano)
			WHEN cf.mes = 5 THEN concat('Maio','/',cf.ano)
			WHEN cf.mes = 6 THEN concat('Junho','/',cf.ano)
			WHEN cf.mes = 7 THEN concat('Julho','/',cf.ano)
			WHEN cf.mes = 8 THEN concat('Agosto','/',cf.ano)
			WHEN cf.mes = 9 THEN concat('Setembro','/',cf.ano)
			WHEN cf.mes = 10 THEN concat('Outubro','/',cf.ano)
			WHEN cf.mes = 11 THEN concat('Novembro','/',cf.ano)
			WHEN cf.mes = 12 THEN concat('Dezembro','/',cf.ano)
			END as mes_ano, 
		CONCAT(cf.valor_medido,'',cf.unidade_medida) as unidade_total,
		cf.id_obra,
		cf.id_servico,
		cf.valor_medido,
		cf.unidade_medida as un,
		CASE
			WHEN cf.publicar_versao = 'N' THEN 'Não Publicado'
			WHEN cf.publicar_versao = 'S' THEN 'Publicado'
		END as publicar, 
		u.DESC_NOME as nome, 
		concat( CONVERT(CHAR(10),cf.ultima_alteracao , 103),' ', CONVERT(CHAR(8),cf.ultima_alteracao , 114)) AS ultima_alteracao,
		cf.versao
		FROM CGOB_TB_CRONOGRAMA_FISICO cf
		INNER JOIN TB_USUARIO AS u ON u.id_usuario = cf.id_usuario
		WHERE cf.publicar_versao = 'S' ";
		
		if (!empty($dados["id_contrato_obra"])) {	
			$SQL .= " AND cf.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' ";
		}
		if (!empty($dados["id_eixo"])) {
			$SQL .= " AND cf.id_eixo = '" . $dados["id_eixo"] . "' ";
		}
		if (!empty($dados["id_cronograma"])) {
			$SQL .= " AND cf.id_cronograma = '" . $dados["id_cronograma"] . "' ";
		}
		if (!empty($dados["versao"])) {
			$SQL .= " AND cf.versao = '" . $dados["versao"] . "' ";
		}
		$query = $this->db->query($SQL);
		return $query->result();
	}
//-----------------------------------------------------------------------------------------------------------------
	public function ContaNaoPublicado($dados){
		$SQL = "
		SELECT c.id_contrato_obra, 
		CASE WHEN (SELECT count(1)conte_naopublicado FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO 
		WHERE id_contrato_obra = '" .$dados["id_contrato_obra"]. "' AND publicar_cronograma = 'N') >= 1 THEN 1
		WHEN 
		(SELECT count(1)conte_naopublicado FROM CGOB_TB_CRONOGRAMA_FISICO_VERSAO 
		WHERE id_contrato_obra = '" .$dados["id_contrato_obra"]. "' AND publicar_cronograma = 'N') = 0 THEN 0
		END as conte_naopublicado
		FROM CGOB_TB_CONTRATO_OBRA AS c
		WHERE c.id_contrato_obra=". $dados['id_contrato_obra']
		;

		$query = $this->db->query($SQL);
		return $query->result();
	}






}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT - FALCONI - AQUAVIARIO
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/04/2020 
//########################################################################################################################################################################################################################
