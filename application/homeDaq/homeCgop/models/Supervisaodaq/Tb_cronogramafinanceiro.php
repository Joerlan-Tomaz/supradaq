<?php
/*
 * Classe model Tb_cronogramafinanceiro. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage model 
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_cronogramafinanceiro extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}


//-------------------------------------------------Obraservico--------------------------------------------
	public function recuperaObra()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//-----------------------------------------------Servicos----------------------------------------------
	public function recuperaObraConstrucao()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_CONSTRUCAO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraDerrocagem()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_DERROCAMENTO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraDragagem()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_DRAGAGEM");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraDesobstrucao()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_DESOBSTRUCAO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraPortos()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_RECUPERACAO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraPassageiros()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_MONITORAMENTO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraNavioHaider()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraSinalHidro()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	//---------------------------------------------------------------------------------------------
	public function recuperaObraEclusas()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OBRA_ECLUSAS");
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

//---------------------------------------------------------------------------------------

	// public function recuperaServico() {
	// 	$this->db->select("*");
	// 	$this->db->from("CGOB_TB_SERVICO");
	// 	$consulta = $this->db->get();
	// 	$resultado = $consulta->result();
	// 	return $resultado;
	// }

//---------------------------------------------------------------------------------------
	public function recuperaSaldo($dados)
	{
		$SQL = "
		SELECT 
		SUM(valor_previsto) as valor_previsto
		from CGOB_TB_CRONOGRAMA_FINANCEIRO 
		WHERE (publicar = 'S' or publicar is NULL) AND id_contrato_obra = '" . $dados["id_contrato_obra"] . "' 
		AND id_cronograma = " . $dados["id_cronograma"] . "
		";

		$query = $this->db->query($SQL);
		return $query->result_array();
	}

//-----------------------------------------------------------------------------------------------------
	public function valorPI($dados)
	{
		$SQL_old_26012022_1150 = "
		SELECT 
		Valor_Inicial as valor_inicial
		FROM CGOB_TB_CONTRATO_OBRA 
        WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . "
        ";
        $SQL="SELECT
		(c.valor_inicial) + (c.Valor_Total_de_Aditivos) AS valor_inicial 
		FROM  CGOB_TB_CONTRATO_OBRA as c 
		WHERE  c.id_contrato_obra = " . $dados["id_contrato_obra"] . " ";        

		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------
	public function recuperaVersao($dados)
	{
		$SQL = "
		SELECT
		id_cronograma_financeiro_versao, 
		versao, 
		id_cronograma, 
		publicar_cronograma
		FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO
		WHERE id_cronograma_financeiro_versao = (SELECT MAX(id_cronograma_financeiro_versao) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "') 
		";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//--------------------------------------------------------------------------------------
	public function insereVersao($dados)
	{
		$this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("publicar_cronograma", "N");
		$this->db->set("versao", $dados['versao']);
		$this->db->set("id_cronograma", $dados['id_cronograma']);
		$this->db->insert("CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();;
		} else {
			$this->db->trans_rollback();
			return false;
		}

	}

//----------------------------------------------------------------------------------
	public function insereCronogramaFinanceiro($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("publicar", "S");
		$this->db->set("servico", $dados['servico']);

		$this->db->set("id_operacao", $dados['id_operacao']);
		$this->db->set("id_servico", $dados['id_servico']);
		$this->db->set("id_tipo_operacao", $dados['tipo']);
		$this->db->set("nome_infraestrutura", $dados['infraestrutura']);

		$this->db->set("valor_previsto", $dados['valorprev']);
		$this->db->set("ano", $dados['ano']);
		$this->db->set("mes", $dados['mes']);
		$this->db->set("id_cronograma_financeiro_versao", $dados['id_cronograma_financeiro_versao']);
		$this->db->set("versao", $dados['versao']);
		$this->db->set("id_cronograma", $dados['id_cronograma']);
		$this->db->set("publicar_versao", "N");

		$this->db->insert("CGOB_TB_CRONOGRAMA_FINANCEIRO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();;
		} else {
			$this->db->trans_rollback();
			return false;
		}

	}

//--------------------------------------------------------------------------------        
	public function PublicarCronograma_naopublicado($dados)
	{
		$this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->set("id_usuario", $dados["id_usuario"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_cronograma_financeiro_versao", $dados['id_cronograma_financeiro_versao']);
		$this->db->set("versao", $dados['versao']);
		$this->db->set("id_cronograma", $dados['id_cronograma']);
		$this->db->set("valor_inicial_aditivo", $dados['valor_inicial_aditivo']);
		$this->db->insert("CGOB_TB_CRONOGRAMA_FINANCEIRO_VALOR_TOTAL");

		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("id_cronograma", $dados['id_cronograma']);
		$this->db->where("publicar", "S");
		$this->db->set("publicar_versao", "S");
		$this->db->set("data_publicar_versao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar_versao", $dados["id_usuario"]);
		$this->db->update("CGOB_TB_CRONOGRAMA_FINANCEIRO");

		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("id_cronograma", $dados['id_cronograma']);
		$this->db->set("publicar_cronograma", "S");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados["id_usuario"]);
		$this->db->update("CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO");

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
	public function RecuperaCronogramaAgrupado_naopublicado($dados)
	{
		$SQL = "
		SELECT
		convert(varchar, SUM(convert(money, c.valor_inicial) + convert(money, c.Valor_Total_de_Aditivos)), 1) AS valor_inicial,
		convert(varchar, convert(money, (SELECT SUM(valor_previsto) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO 
		WHERE  id_cronograma = v.id_cronograma AND (publicar_versao = 'N' AND publicar = 'S')AND id_contrato_obra = " . $dados["id_contrato_obra"] . ")),1   ) AS valor_previsto,
		v.id_cronograma_financeiro_versao,
		v.versao,
		v.id_cronograma,
		concat( CONVERT(CHAR(10),v.ultima_alteracao , 103),' ', CONVERT(CHAR(8),v.ultima_alteracao , 114)) AS ultima_alteracao,
		u.DESC_NOME as nome
		FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO AS v
		INNER JOIN TB_USUARIO AS u ON u.id_usuario = v.id_usuario
		INNER JOIN CGOB_TB_CONTRATO_OBRA as c on c.id_contrato_obra = v.id_contrato_obra
		WHERE (v.publicar_cronograma = 'N')
		";

		if (!empty($dados["id_cronograma_financeiro_versao"])) {
			$SQL .= " AND v.id_cronograma_financeiro_versao = '" . $dados["id_cronograma_financeiro_versao"] . "' ";
		}

		if (!empty($dados["id_contrato_obra"])) {
			$SQL .= " AND c.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' ";
		}

		$SQL .= "GROUP BY  c.valor_inicial,v.id_cronograma_financeiro_versao, v.versao, v.id_cronograma, v.ultima_alteracao, u.DESC_NOME";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//--------------------------------------------------------------------------------------------------------------------------------------
	public function ContaNaoPublicado($dados)
	{
		$SQL = "
		SELECT c.id_contrato_obra, 
		CASE
		WHEN
		(SELECT count(1)conte_naopublicado FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO  WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND publicar_cronograma = 'N') >= 1 THEN 1
		WHEN 
		(SELECT count(1)conte_naopublicado FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO  WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND publicar_cronograma = 'N') = 0 THEN 0
		END as conte_naopublicado
		FROM CGOB_TB_CONTRATO_OBRA AS c
		WHERE c.id_contrato_obra=" . $dados['id_contrato_obra'];

		$query = $this->db->query($SQL);
		return $query->result();
	}

//---------------------------------------------------------------------------------------------------------------------------------------
	public function recuperaCronograma($dados)
	{
		$SQL = "
		SELECT
		v.nome_infraestrutura,
		s.servico,
		ot.tipo AS tipo_obra,
		op.nome_operacao AS desc_obra, 
		os.servico AS desc_servico,
		tipo AS desc_tipo,
		v.id_cronograma_financeiro,
		v.mes,
		v.ano,
		convert(varchar, convert(money,  v.valor_previsto), 1) as valor_previsto,
		v.versao,
		v.publicar_versao,
		CASE
            WHEN v.publicar_versao = 'N' THEN 'Não Publicado'
            WHEN v.publicar_versao = 'S' THEN 'Publicado'
        END as publicar_versao,
		concat( CONVERT(CHAR(10),v.ultima_alteracao , 103),' ', CONVERT(CHAR(8),v.ultima_alteracao , 114)) AS ultima_alteracao,
		u.DESC_NOME as nome
		FROM CGOB_TB_CRONOGRAMA_FINANCEIRO AS v
		INNER JOIN TB_USUARIO AS u ON u.id_usuario = v.id_usuario
		INNER JOIN CGOB_TB_SERVICO AS s ON s.id_servico = v.servico
		INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = v.id_operacao
        INNER JOIN CGOB_TB_OPERACAO_SERVICO AS os ON os.id_servico = v.id_servico
        LEFT JOIN CGOB_TB_OPERACAO_TIPO AS ot ON ot.id_tipo = v.id_tipo_operacao
		WHERE (v.publicar  = 'S') AND v.id_cronograma = '" . $dados["id_cronograma"] . "'
		";

		if (!empty($dados["id_cronograma_financeiro_versao"])) {
			$SQL .= " AND v.id_cronograma_financeiro_versao = '" . $dados["id_cronograma_financeiro_versao"] . "' ";
		}

		if (!empty($dados["id_contrato_obra"])) {
			$SQL .= " AND v.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' ";
		}

		$SQL .= " ORDER BY v.mes asc";

//echo '<pre>';
//var_dump($SQL);
//echo '</pre>';
//die;
		$query = $this->db->query($SQL);
		return $query->result();
	}

//---------------------------------------------------------------------------------------------------------------------------------------
	public function RecuperaeditarCronograma($dados)
	{
		$SQL = "
		SELECT
		convert(varchar, convert(money,  v.valor_previsto), 1) as valor_previsto,
		v.versao,
		concat( CONVERT(CHAR(10),v.ultima_alteracao , 103),' ', CONVERT(CHAR(8),v.ultima_alteracao , 114)) AS ultima_alteracao,
		u.DESC_NOME as nome
		FROM CGOB_TB_CRONOGRAMA_FINANCEIRO AS v
		INNER JOIN TB_USUARIO AS u ON u.id_usuario = v.id_usuario
		WHERE (v.publicar_versao = 'N' AND v.publicar  = 'S')
		";

		if (!empty($dados["id_cronograma_financeiro"])) {
			$SQL .= " AND v.id_cronograma_financeiro = '" . $dados["id_cronograma_financeiro"] . "' ";
		}

		$SQL .= " ORDER BY v.ultima_alteracao desc";

		$query = $this->db->query($SQL);
		return $query->result();
	}






	//----------------------------------------------------------------------------------------------------------------------------
	public function acompanhamentofinanceiro($dados)
	{
		$SQL = "
				with execucao as (
				SELECT cf.nome_infraestrutura                    as obra,
					   'p'                           as identit,
					   ot.tipo AS desc_tipo,
					   op.nome_operacao AS desc_obra,
					   os.servico AS servico,
					   cf.ano,
					   cf.mes,
					   sum(cf.valor_previsto) / 1000 as valortotal
				FROM CGOB_TB_CRONOGRAMA_FINANCEIRO cf
				 INNER JOIN CGOB_TB_SERVICO AS s ON s.id_servico = cf.servico
				 INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = cf.id_operacao
				 INNER JOIN CGOB_TB_OPERACAO_SERVICO AS os ON os.id_servico = cf.id_servico
				 LEFT JOIN CGOB_TB_OPERACAO_TIPO AS ot ON ot.id_tipo = cf.id_tipo_operacao
				WHERE cf.publicar_versao = 'S'
				  AND cf.publicar like '%S%'
				  and cf.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
				  and cf.versao = (SELECT MAX(versao)
								   FROM CGOB_TB_CRONOGRAMA_FINANCEIRO
								   where id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
									 and publicar_versao like '%S%'
									 and publicar like '%S%')
				group by cf.nome_infraestrutura, ot.tipo, op.nome_operacao, os.servico,  cf.ano, cf.mes
				union all
				select af.infraestrutura                    as obra,
					   'e'                           as identit,
					   ot.tipo AS desc_tipo,
					   op.nome_operacao AS desc_obra,
					   os.servico AS servico,
					   af.ano,
					   af.mes,
					   sum(af.valor) / 1000 as valortotal
				FROM CGOB_TB_AVANCO_FINANCEIRO af
						 INNER JOIN CGOB_TB_SERVICO AS s ON s.id_servico = af.id_servico
						 INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = af.id_operacao
						 INNER JOIN CGOB_TB_OPERACAO_SERVICO AS os ON os.id_servico = af.id_servico
						 LEFT JOIN CGOB_TB_OPERACAO_TIPO AS ot ON ot.id_tipo = af.id_tipo
				WHERE af.publicar_versao = 'S'
				  AND af.publicar like '%S%'
				  AND af.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'
				group by af.infraestrutura,ot.tipo, op.nome_operacao, os.servico, af.ano, af.mes
			)
			select concat(obra, ' - ', servico) as servico,
				   ano,
				   isnull(SUM(CASE
								  WHEN mes = 1 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_01,
				   isnull(SUM(CASE
								  WHEN mes = 2 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_02,
				   isnull(SUM(CASE
								  WHEN mes = 3 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_03,
				   isnull(SUM(CASE
								  WHEN mes = 4 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_04,
				   isnull(SUM(CASE
								  WHEN mes = 5 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_05,
				   isnull(SUM(CASE
								  WHEN mes = 6 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_06,
				   isnull(SUM(CASE
								  WHEN mes = 7 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_07,
				   isnull(SUM(CASE
								  WHEN mes = 8 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_08,
				   isnull(SUM(CASE
								  WHEN mes = 9 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_09,
				   isnull(SUM(CASE
								  WHEN mes = 10 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_10,
				   isnull(SUM(CASE
								  WHEN mes = 11 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_11,
				   isnull(SUM(CASE
								  WHEN mes = 12 and identit = 'p'
									  THEN valortotal
								  ELSE 0 END), 0) previsto_12,
				   isnull(SUM(CASE
								  WHEN mes = 1 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_01,
				   isnull(SUM(CASE
								  WHEN mes = 2 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_02,
				   isnull(SUM(CASE
								  WHEN mes = 3 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_03,
				   isnull(SUM(CASE
								  WHEN mes = 4 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_04,
				   isnull(SUM(CASE
								  WHEN mes = 5 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_05,
				   isnull(SUM(CASE
								  WHEN mes = 6 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_06,
				   isnull(SUM(CASE
								  WHEN mes = 7 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_07,
				   isnull(SUM(CASE
								  WHEN mes = 8 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_08,
				   isnull(SUM(CASE
								  WHEN mes = 9 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_09,
				   isnull(SUM(CASE
								  WHEN mes = 10 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_10,
				   isnull(SUM(CASE
								  WHEN mes = 11 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_11,
				   isnull(SUM(CASE
								  WHEN mes = 12 and identit = 'e'
									  THEN valortotal
								  ELSE 0 END), 0) concluido_12
			from execucao
			group by obra, servico, ano
			order by ano";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function anoacompanhentofinanceiro($dados)
	{
		$SQL = "
	select distinct ano from CGOB_TB_CRONOGRAMA_FINANCEIRO where publicar_versao like '%S%' and publicar like '%S%' and id_contrato_obra = '" . $dados["id_contrato_obra"] . "' AND versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "') ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function acompanhamentofinanceirov($dados)
	{
		$SQL = " with execucao as
	(SELECT c.valor_inicial/100000 as valor,cf.ano,cf.mes,
				'c' as identit,
				sum(cf.valor_previsto)/1000 as valor_previsto
			FROM CGOB_TB_CRONOGRAMA_FINANCEIRO cf
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.id_contrato_obra = cf.id_contrato_obra
			WHERE cf.publicar_versao = 'S'  AND cf.publicar like '%S%' and cf.id_contrato_obra= '" . $dados["id_contrato_obra"] . "' and cf.versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO where id_contrato_obra = '" . $dados["id_contrato_obra"] . "') 
		group by cf.ano,cf.mes, c.valor_inicial
		union all
			SELECT c.valor_inicial/100000 as valor,
				 year(af.data_termino_medicao) as ano,
				 month(af.data_termino_medicao) as mes,
				 'm' as identit,
				 sum(af.valor_pi_medicao)/1000 as valor_previsto
			FROM CGOB_TB_SIAC_MEDICAO_MAIOR af
		INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.nu_con_formatado = af.contrato
			WHERE c.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'		
			 group by year(af.data_termino_medicao), month(af.data_termino_medicao), c.valor_inicial 
				 )
			 select ano, valor, 
			 isnull(SUM(CASE WHEN mes = 1 and identit ='c' 
			 THEN valor_previsto ELSE 0 END),0) previsto_01,isnull(SUM(CASE WHEN mes = 2 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_02,isnull(SUM(CASE WHEN mes = 3 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_03,isnull(SUM(CASE WHEN mes = 4 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_04,isnull(SUM(CASE WHEN mes = 5 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_05,isnull(SUM(CASE WHEN mes = 6 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_06,isnull(SUM(CASE WHEN mes = 7  and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_07,isnull(SUM(CASE WHEN mes = 8 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_08,isnull(SUM(CASE WHEN mes = 9  and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_09,isnull(SUM(CASE WHEN mes = 10 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_10,isnull(SUM(CASE WHEN mes = 11 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_11,isnull(SUM(CASE WHEN mes = 12 and identit ='c'
			 THEN valor_previsto ELSE 0 END),0) previsto_12,
				isnull(SUM(CASE WHEN mes = 1 and identit ='m' 
				THEN valor_previsto ELSE 0 END),0) executado_01,isnull(SUM(CASE WHEN mes = 2 and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_02,isnull(SUM(CASE WHEN mes = 3 and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_03,isnull(SUM(CASE WHEN mes = 4  and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_04,isnull(SUM(CASE WHEN mes = 5  and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_05,isnull(SUM(CASE WHEN mes = 6  and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_06,isnull(SUM(CASE WHEN mes = 7  and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_07,isnull(SUM(CASE WHEN mes = 8  and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_08,isnull(SUM(CASE WHEN mes = 9 and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_09,isnull(SUM(CASE WHEN mes = 10 and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_10,isnull(SUM(CASE WHEN mes = 11 and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_11,isnull(SUM(CASE WHEN mes = 12 and identit ='m'
				 THEN valor_previsto ELSE 0 END),0) executado_12,
					isnull(SUM(CASE WHEN mes = 1 and identit ='c' 
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_01,isnull(SUM(CASE WHEN mes = 2 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_02,isnull(SUM(CASE WHEN mes = 3 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_03,isnull(SUM(CASE WHEN mes = 4 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_04,isnull(SUM(CASE WHEN mes = 5 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_05,isnull(SUM(CASE WHEN mes = 6 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_06,isnull(SUM(CASE WHEN mes = 7  and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_07,isnull(SUM(CASE WHEN mes = 8 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_08,isnull(SUM(CASE WHEN mes = 9  and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_09,isnull(SUM(CASE WHEN mes = 10 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_10,isnull(SUM(CASE WHEN mes = 11 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_11,isnull(SUM(CASE WHEN mes = 12 and identit ='c'
					 THEN valor_previsto/valor ELSE 0 END),0) percentprev_12,
					 isnull(SUM(CASE WHEN mes = 1 and identit ='m' 
				THEN valor_previsto/valor ELSE 0 END),0) percentex_01,isnull(SUM(CASE WHEN mes = 2 and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_02,isnull(SUM(CASE WHEN mes = 3 and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_03,isnull(SUM(CASE WHEN mes = 4  and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_04,isnull(SUM(CASE WHEN mes = 5  and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_05,isnull(SUM(CASE WHEN mes = 6  and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_06,isnull(SUM(CASE WHEN mes = 7  and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_07,isnull(SUM(CASE WHEN mes = 8  and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_08,isnull(SUM(CASE WHEN mes = 9 and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_09,isnull(SUM(CASE WHEN mes = 10 and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_10,isnull(SUM(CASE WHEN mes = 11 and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_11,isnull(SUM(CASE WHEN mes = 12 and identit ='m'
				 THEN valor_previsto/valor ELSE 0 END),0) percentex_12 from execucao group by ano, valor order by ano";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------------------------
	public function RecuperaCronogramaAgrupado_publicado($dados)
	{
		$SQL = "
		SELECT
		convert(varchar, SUM(convert(money, c.valor_inicial) + convert(money, c.Valor_Total_de_Aditivos)), 1) AS valor_inicial,
		convert(varchar, convert(money, (SELECT SUM(valor_previsto) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO 
		WHERE  id_cronograma = v.id_cronograma AND (publicar_versao = 'S' AND publicar = 'S')AND id_contrato_obra = " . $dados["id_contrato_obra"] . ")),1   ) AS valor_previsto,
		v.id_cronograma_financeiro_versao,
		v.versao,
		v.id_cronograma,
		concat( CONVERT(CHAR(10),v.ultima_alteracao , 103),' ', CONVERT(CHAR(8),v.ultima_alteracao , 114)) AS ultima_alteracao,
		concat( CONVERT(CHAR(10),v.data_publicar , 103),' ', CONVERT(CHAR(8),v.data_publicar , 114)) AS data_publicar,
		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = v.id_usuario) AS nome,
		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = v.id_usuario_publicar) AS nome_publi
		FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO AS v
		INNER JOIN CGOB_TB_CONTRATO_OBRA as c on c.id_contrato_obra = v.id_contrato_obra
		WHERE (v.publicar_cronograma = 'S')
		";

		if (!empty($dados["id_cronograma_financeiro_versao"])) {
			$SQL .= " AND v.id_cronograma_financeiro_versao = " . $dados["id_cronograma_financeiro_versao"] . " ";
		}

		if (!empty($dados["id_contrato_obra"])) {
			$SQL .= " AND c.id_contrato_obra = " . $dados["id_contrato_obra"] . " ";
		}

		$SQL .= "GROUP BY  c.valor_inicial, v.id_cronograma_financeiro_versao, v.versao, v.id_cronograma, v.ultima_alteracao, v.data_publicar, v.id_usuario, v.id_usuario_publicar";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//------------------------------------------------------------------------------------------------------------------------
	public function dadosresumoavancofisico($dados)
	{
		$SQL = "SELECT distinct concat(cronograma.obra,' - ',cronograma.desc_obra, ' - ', cronograma.servico, ' - ' , cronograma.desc_tipo) as  servico,
				   cronograma.unidade_medida                                        as  unidade,
				   concat(atacado.valoranterior, ' ', atacado.unidade_medida) as  executado,
				   CASE
					   WHEN (executado.valorexecutado is null or executado.valorexecutado like '') THEN
						   cronograma.valorcronograma
					   ELSE (cronograma.valorcronograma - executado.valorexecutado) END concluir
			from (select cf.nome_eixo                              as obra,
						 ot.tipo                                   AS desc_tipo,
						 op.nome_operacao                          AS desc_obra,
						 os.servico                                AS servico,
						 cf.unidade_medida,
						 concat(cf.ano, '-', format(cf.mes, '00')) as periodo,
						 sum(cf.valor_medido)                      as valorcronograma
				  FROM CGOB_TB_CRONOGRAMA_FISICO cf
					   INNER JOIN CGOB_TB_SERVICO AS s ON s.id_servico = cf.id_servico
					   INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = cf.id_operacao
					   INNER JOIN CGOB_TB_OPERACAO_SERVICO AS os ON os.id_servico = cf.id_servico
					   LEFT JOIN CGOB_TB_OPERACAO_TIPO AS ot ON ot.id_tipo = cf.id_tipo_operacao
				  WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . "
					and publicar_versao like '%S%'
					and publicar like '%S%'
					and cf.versao = (SELECT MAX(versao)
									 FROM CGOB_TB_CRONOGRAMA_FISICO
									 where id_contrato_obra = " . $dados["id_contrato_obra"] . "
									   and publicar_versao like '%S%'
									   and publicar like '%S%')
				  group by cf.nome_eixo, ot.tipo, op.nome_operacao, os.servico, cf.unidade_medida, cf.ano, cf.mes) cronograma
					 full outer join
				 (select af.infraestrutura                        as obra,
						 ot.tipo                                  AS desc_tipo,
						 op.nome_operacao                         AS desc_obra,
						 os.servico                               AS servico,
						 af.unidade_medida,
						 format(af.periodo_referencia, 'yyyy-MM') as periodo,
						 sum(af.val_final)                        as valoranterior
				  FROM CGOB_TB_AVANCO_FISICO af
						   INNER JOIN CGOB_TB_SERVICO AS s ON s.id_servico = af.id_servico
						   INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = af.id_operacao
						   INNER JOIN CGOB_TB_OPERACAO_SERVICO AS os ON os.id_servico = af.id_servico
						   LEFT JOIN CGOB_TB_OPERACAO_TIPO AS ot ON ot.id_tipo = af.id_tipo
				  WHERE af.publicar like '%S%'
					AND af.id_contrato_obra = " . $dados["id_contrato_obra"] . "
					AND af.periodo_referencia = '" . $dados["periodo"] . "'
					AND af.status in ('Atacado')
					AND af.versao = (SELECT MAX(versao)
									 FROM CGOB_TB_CRONOGRAMA_FISICO
									 where id_contrato_obra = " . $dados["id_contrato_obra"] . "
									   and publicar_versao like '%S%'
									   and publicar like '%S%')
				  group by af.infraestrutura, ot.tipo, op.nome_operacao, os.servico, af.unidade_medida,
						   format(af.periodo_referencia, 'yyyy-MM')
				 ) atacado
				 on cronograma.periodo = atacado.periodo and cronograma.servico = atacado.servico
					 full outer join
				 (select af.infraestrutura                        as obra,
						 ot.tipo                                  AS desc_tipo,
						 op.nome_operacao                         AS desc_obra,
						 os.servico                               AS servico,
						 ax.unidade_medida_exec,
						 format(af.periodo_referencia, 'yyyy-MM') as periodo,
						 sum(ax.val_final)                        as valorexecutado
				  FROM CGOB_TB_AVANCO_FISICO af
						   INNER JOIN CGOB_TB_SERVICO AS s ON s.id_servico = af.id_servico
						   INNER JOIN CGOB_TB_OPERACAO AS op ON op.id_operacao = af.id_operacao
						   INNER JOIN CGOB_TB_OPERACAO_SERVICO AS os ON os.id_servico = af.id_servico
						   LEFT JOIN CGOB_TB_OPERACAO_TIPO AS ot ON ot.id_tipo = af.id_tipo
						   inner join CGOB_TB_AVANCO_FISICO_EXECUTADO as ax on af.id_avanco_fisico = ax.id_avanco_fisico
				  WHERE (ax.publicar_versao like '%S%' or ax.publicar_versao is NULL)
					AND ax.publicar like '%S%'
					AND af.publicar like '%S%'
					AND af.id_contrato_obra = " . $dados["id_contrato_obra"] . "
					AND af.versao = (SELECT MAX(versao)
									 FROM CGOB_TB_CRONOGRAMA_FISICO
									 where id_contrato_obra = " . $dados["id_contrato_obra"] . "
									   and publicar_versao like '%S%'
									   and publicar like '%S%')
				  group by af.infraestrutura, ot.tipo, op.nome_operacao, os.servico, ax.unidade_medida_exec,
						   format(af.periodo_referencia, 'yyyy-MM')) executado
				 on cronograma.periodo = executado.periodo and cronograma.servico = executado.servico";
               // echo('<pre>');
               // die($SQL);
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------------------------
	public function buscadadosgrafico($dados)
	{
		$SQL = "
        select isnull(siac.medicao, cronograma.medicao) medicao,
        sum(valor_pi_medicao) over (ORDER BY isnull(siac.medicao, cronograma.medicao) ROWS UNBOUNDED PRECEDING) valor_pi_medicao,
		sum(valor_previsto) over (ORDER BY isnull(siac.medicao, cronograma.medicao) ROWS UNBOUNDED PRECEDING) valor_previsto
        FROM( SELECT format(siacm.data_processamento_medicao, 'yyyy-MM') medicao,
            SUM(siacm.valor_pi_medicao) valor_pi_medicao
        FROM CGOB_TB_SIAC_MEDICAO_MAIOR siacm INNER JOIN CGOB_TB_CONTRATO_OBRA co on siacm.contrato = co.nu_con_formatado
        WHERE co.id_contrato_obra = " . $dados["id_contrato_obra"] . " 
        GROUP BY FORMAT(siacm.data_processamento_medicao, 'yyyy-MM')
        ) siac FULL OUTER JOIN ( SELECT concat (crof.ano,'-',format(crof.mes, '00')) as medicao,
            convert(float, SUM(crof.valor_previsto)) as valor_previsto   
        FROM CGOB_TB_CRONOGRAMA_FINANCEIRO crof
          INNER JOIN CGOB_TB_CONTRATO_OBRA co on  crof.id_contrato_obra = co.id_contrato_obra
        WHERE  co.id_contrato_obra = " . $dados["id_contrato_obra"] . " and (crof.publicar_versao = 'S' AND crof.publicar = 'S')
        and crof.versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO where publicar_cronograma like'S' AND id_contrato_obra = '" . $dados["id_contrato_obra"] . "')
        GROUP BY concat (crof.ano,'-',format(crof.mes, '00'))
        ) cronograma on cronograma.medicao = siac.medicao ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------------------------
	public function buscadadosgraficoSupervisao($dados)
	{
		$SQL = "
        select isnull(siac.medicao, cronograma.medicao) medicao,
        sum(valor_pi_medicao) over (ORDER BY isnull(siac.medicao, cronograma.medicao) ROWS UNBOUNDED PRECEDING) valor_pi_medicao,
		sum(valor_previsto) over (ORDER BY isnull(siac.medicao, cronograma.medicao) ROWS UNBOUNDED PRECEDING) valor_previsto
        FROM( SELECT format(siacm.data_processamento_medicao, 'yyyy-MM') medicao,
            SUM(siacm.valor_pi_medicao) valor_pi_medicao
        FROM CGOB_TB_SIAC_MEDICAO_MAIOR siacm INNER JOIN CGOB_TB_CONTRATO_OBRA co on siacm.contrato = co.nu_con_formatado_supervisor
        WHERE co.id_contrato_obra = " . $dados["id_contrato_obra"] . " 
        GROUP BY FORMAT(siacm.data_processamento_medicao, 'yyyy-MM')
        ) siac FULL OUTER JOIN ( SELECT concat (crof.ano,'-',format(crof.mes, '00')) as medicao,
            convert(float, SUM(crof.valor_previsto)) as valor_previsto   
        FROM CGOB_TB_CRONOGRAMA_FINANCEIRO crof
          INNER JOIN CGOB_TB_CONTRATO_OBRA co on  crof.id_contrato_obra = co.id_contrato_obra
        WHERE  co.id_contrato_obra = " . $dados["id_contrato_obra"] . " and (crof.publicar_versao = 'S' AND crof.publicar = 'S')
        and crof.versao = (SELECT MAX(versao) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO where publicar_cronograma like'S' AND id_contrato_obra = '" . $dados["id_contrato_obra"] . "')
        GROUP BY concat (crof.ano,'-',format(crof.mes, '00'))
        ) cronograma on cronograma.medicao = siac.medicao ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------------------------
	public function buscardado($dados)
	{
		$SQL = "
		SELECT
		convert(varchar, convert(money,c.valor_inicial),1   ) as valor_inicial,
		convert(varchar, convert(money, (SELECT SUM(valor_previsto) FROM CGOB_TB_CRONOGRAMA_FINANCEIRO 
		WHERE  id_cronograma = v.id_cronograma AND (publicar_versao = 'S' AND publicar = 'S')AND id_contrato_obra = " . $dados["id_contrato_obra"] . ")),1   ) AS valor_previsto,
		v.id_cronograma_financeiro_versao,
		v.versao, v.id_cronograma,
		concat( CONVERT(CHAR(10),v.ultima_alteracao , 103),' ', CONVERT(CHAR(8),v.ultima_alteracao , 114)) AS ultima_alteracao,
		concat( CONVERT(CHAR(10),v.data_publicar , 103),' ', CONVERT(CHAR(8),v.data_publicar , 114)) AS data_publicar,
		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = v.id_usuario) AS nome,
		(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = v.id_usuario_publicar) AS nome_publi
		FROM CGOB_TB_CRONOGRAMA_FINANCEIRO_VERSAO AS v
		INNER JOIN CGOB_TB_CONTRATO_OBRA as c on c.id_contrato_obra = v.id_contrato_obra
		WHERE (v.publicar_cronograma = 'S')
		";
		if (!empty($dados["id_cronograma_financeiro_versao"])) {
			$SQL .= " AND v.id_cronograma_financeiro_versao = " . $dados["id_cronograma_financeiro_versao"] . " ";
		}
		if (!empty($dados["id_contrato_obra"])) {
			$SQL .= " AND c.id_contrato_obra = " . $dados["id_contrato_obra"] . " ";
		}
		$SQL .= "GROUP BY  c.valor_inicial, v.id_cronograma_financeiro_versao, v.versao, v.id_cronograma, v.ultima_alteracao, v.data_publicar, v.id_usuario, v.id_usuario_publicar";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//----------------------------------------------------------------------------------------------------------------------------------------
	public function excluirAvanco($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_cronograma_financeiro", $dados['id_cronograma_financeiro']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_CRONOGRAMA_FINANCEIRO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

//----------------------------------------------------------------------------------------------------------------------------------------
	public function editarCronograma($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->where("id_contrato_obra", $dados['id_contrato_obra']);
		$this->db->where("id_cronograma_financeiro", $dados['id_cronograma_financeiro']);

		$this->db->set("valor_previsto", $dados["valor_previsto"]);
		$this->db->set("id_usuario", $dados["id_usuario"]);
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));

		$this->db->update("CGOB_TB_CRONOGRAMA_FINANCEIRO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function recuperaEmpenho($dados) {
		$SQL = "SELECT CTSE.* FROM CGOB_TB_SIAC_EMPENHO as CTSE 
				INNER JOIN CGOB_TB_CONTRATO_OBRA as CTCO 
					ON ctco.nu_con_formatado = CTSE.NU_CON_FORMATADO
				WHERE CTCO.id_contrato_obra = '" . $dados["id_contrato_obra"] . "'";

		$query = $this->db->query($SQL);
		return $query->result_array();;
	}

	public function recuperaOperacao()
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OPERACAO");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	public function RecuperaServicoOperacao($dados)
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OPERACAO_SERVICO");
		$this->db->where("id_operacao", $dados['id_operacao']);
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	public function RecuperaTipoOperacao($dados)
	{
		$this->db->select("*");
		$this->db->from("CGOB_TB_OPERACAO_TIPO");
		$this->db->where("id_servico", $dados['id_servico']);
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Pedro Correia
//# Data: 06/08/2021 13:00
//########################################################################################################################################################################################################################
