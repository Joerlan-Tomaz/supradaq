<?php
/*
 * Classe model Tb_analise_relatorio. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage CI_Model 
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_analise_relatorio extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}


	//---------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------------
	public function recuperaContrato()
	{
		$SQL = "
        SELECT 
            id_contrato_obra as id_contrato,
            CONCAT(nu_con_formatado,'-',no_empresa)as contrato,
            CONCAT(descricao_br,'',sg_uf_unidade_local) as bruf
            ,nu_con_formatado_supervisor
        FROM CGOB_TB_CONTRATO_OBRA
      ";

		$SQL .= " ORDER BY id_contrato_obra DESC";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function recuperaStatus($dados)
	{
		$SQL = "
        SELECT 
            ar.id_relatorio_edit as relatorio,
            ar.id_aceite as aceite,
            ar.roteiro_analise,
            ar.perfil,
            (SELECT CONCAT(CONVERT(CHAR(10), ultima_alteracao , 103),' ', CONVERT(CHAR(8), ultima_alteracao , 114)) FROM CGOB_TB_HISTORICO_RELATORIO WHERE id_aceite in ('andamento') AND roteiro_analise in ('fechar_relatorio') AND perfil in ('analista') AND id_contrato_obra = '" . $dados["id"] . "' AND periodo_referencia = '" . $dados["periodo"] . "') AS fechamento,
            CONCAT(CONVERT(CHAR(10), ar.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ar.ultima_alteracao , 114)) AS ultima_alteracao,
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = ar.id_usuario) AS nome,
            (select count(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO WHERE id_aceite in ('conclusao') AND roteiro_analise in ('fechar_relatorio') AND id_contrato_obra = '" . $dados["id"] . "' AND periodo_referencia = '" . $dados["periodo"] . "') as versao
        FROM CGOB_TB_HISTORICO_RELATORIO as ar
            WHERE ar.id_relatorio_edit = (SELECT MAX(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO where id_contrato_obra = '" . $dados["id"] . "' AND periodo_referencia = '" . $dados["periodo"] . "' ) 
      ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function recuperaContratoAnalise($dados)
	{
		$SQL = "
        SELECT
            co.id_contrato_obra as id_contrato,
            CONCAT(co.nu_con_formatado,'-',co.no_empresa)as contrato,
            CONCAT(co.descricao_br,'',co.sg_uf_unidade_local) as bruf,
            CASE WHEN (co.nu_con_formatado_supervisor is null or co.nu_con_formatado_supervisor like '') THEN
                    '- -'
                    ELSE (SELECT concat(cs.nu_con_formatado,'-',cs.no_empresa) FROM CGOB_TB_CONTRATO_SUPERVISORA as cs WHERE co.nu_con_formatado_supervisor = cs.nu_con_formatado)
                END as nu_con_formatado_supervisor,
            ar.id_relatorio_edit as relatorio,
            ar.id_aceite as aceite,
            ar.roteiro_analise,
            ar.perfil,
            (SELECT CONVERT(VARCHAR(10), ultima_alteracao , 103) FROM CGOB_TB_HISTORICO_RELATORIO  WHERE id_relatorio_edit = (SELECT MAX(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO  where id_aceite in ('aguardando análise') AND roteiro_analise in ('fechar_relatorio') AND id_contrato_obra = id_contrato_obra AND periodo_referencia = '" . $dados["periodo"] . "'))  AS fechamento,
            CONCAT(CONVERT(CHAR(10), ar.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ar.ultima_alteracao , 114)) AS ultima_alteracao,
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = ar.id_usuario) AS nome,
            (select count(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO WHERE id_aceite in ('aprovado') AND roteiro_analise in ('fechar_relatorio') AND id_contrato_obra = co.id_contrato_obra AND periodo_referencia = '" . $dados["periodo"] . "') as versao
        FROM CGOB_TB_HISTORICO_RELATORIO as ar
        INNER JOIN CGOB_TB_CONTRATO_OBRA as co ON co.id_contrato_obra = ar.id_contrato_obra
            WHERE ar.id_relatorio_edit = (SELECT MAX(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO where id_contrato_obra = co.id_contrato_obra AND periodo_referencia = '" . $dados["periodo"] . "' ) ";

		if(isset($dados['uf']) && $dados['uf'] != ''){
			$SQL .= " AND co.sg_uf_unidade_local = '" . $dados["uf"] . "'";
		}

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function recuperaAnaliseEdit($dados)
	{
		$SQL = "
        SELECT 
            id_relatorio_edit as id_relatorio,
            id_aceite,
            desc_analise_aceite  
        FROM CGOB_TB_HISTORICO_RELATORIO
              WHERE publicar = 'S' AND id_contrato_obra = '" . $dados["id_contrato_obra"] . "' AND id_roteiro = '" . $dados["id_modulo"] . "'
      ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function recuperaStatusModulo($dados)
	{
		$SQL = "
        SELECT 
            ar.id_relatorio_edit as relatorio,
            ar.id_aceite as aceite,
            ar.roteiro_analise,
            CONCAT(CONVERT(CHAR(10), ar.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ar.ultima_alteracao , 114)) AS ultima_alteracao,
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = ar.id_usuario) AS nome,
            (select count(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO WHERE id_aceite in ('conclusao') AND roteiro_analise in ('fechar_relatorio') AND id_contrato_obra = '" . $dados["id"] . "' AND periodo_referencia = '" . $dados["periodo"] . "') as versao
        FROM CGOB_TB_HISTORICO_RELATORIO as ar
            WHERE ar.id_relatorio_edit = (SELECT MAX(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO where ar.publicar = 'S'AND  id_contrato_obra = '" . $dados["id"] . "' AND periodo_referencia = '" . $dados["periodo"] . "' AND id_roteiro = '" . $dados["id_modulo"] . "' ) 
      ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------

	public function insereResumo($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("id_contrato_obra", $dados["id_contrato"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("id_aceite", $dados["aceite"]);
		$this->db->set("perfil", $dados["id_perfil_analise"]);

		if (!empty($dados["roteiro"])) {
			$this->db->set("roteiro_analise", $dados["roteiro"]);
		}
		if (!empty($dados["id_modulo"])) {
			$this->db->set("id_roteiro", $dados["id_modulo"]);
		}
		if (!empty($dados["resumo"])) {
			$this->db->set("desc_analise_aceite", $dados["resumo"]);
		}
		$this->db->set("publicar", "S");
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->insert("CGOB_TB_HISTORICO_RELATORIO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

//-------------------------------------------------------------------------------------------------------
	public function alteraResumo($dados)
	{
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->where("id_relatorio_edit", $dados["id_relatorio"]);
		$this->db->where("id_roteiro", $dados["id_modulo"]);
		$this->db->where("id_contrato_obra", $dados["id_contrato"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("desc_analise_aceite", $dados["resumo"]);
		$this->db->set("id_aceite", $dados["aceite"]);
		$this->db->update("CGOB_TB_HISTORICO_RELATORIO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

//-------------------------------------------------------------------------------------------------------
	public function recuperarHistoricoAnalises($dados)
	{
		$SQL = "
        SELECT 
        ad.periodo_referencia as periodo,
        ad.id_aceite as aceite, 
        ad.desc_analise_aceite as desc_analise,
        (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO  WHERE id_roteiro = ad.id_roteiro) AS modulo,
        (SELECT desc_perfil FROM TB_PERFIL  WHERE id_perfil = ad.perfil) AS perfil,
        (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = ad.id_usuario) AS nome,
        ad.roteiro_analise,
        CONCAT(CONVERT(CHAR(10), ad.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ad.ultima_alteracao , 114)) AS ultima_alteracao  
        FROM CGOB_TB_HISTORICO_RELATORIO as ad
            WHERE ad.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' AND periodo_referencia = '" . $dados["periodo"] . "'
      ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function recuperaDados($dados)
	{
		$SQL = "
        SELECT 
           us.EMAIL 
        FROM CGOB_TB_HISTORICO_RELATORIO as an
        INNER JOIN TB_USUARIO as us on an.id_usuario = us.id_usuario
              WHERE id_relatorio_edit = (SELECT MIN(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO WHERE id_contrato_obra = '" . $dados["id_contrato"] . "' AND id_aceite in ('aguardando análise') AND perfil in ('1')) 
      ";

		$query = $this->db->query($SQL);
		return $query->result_array();
	}

//-------------------------------------------------------------------------------------------------------

	public function ExcluirRetificado($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_relatorio_edit", $dados['id']);
		$this->db->set("publicar", "N");
		$this->db->set("data_publicar", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_publicar", $dados['id_usuario']);
		$this->db->update("CGOB_TB_HISTORICO_RELATORIO");
		return true;
	}

//-------------------------------------------------------------------------------------------------------
	public function validar($dados)
	{
		$SQL = "
        SELECT 
            count(id_relatorio_edit) as id
        FROM CGOB_TB_HISTORICO_RELATORIO
              WHERE id_contrato_obra = '" . $dados["id"] . "' AND perfil in ('2')
      ";

		$query = $this->db->query($SQL);
		return $query->result_array();
	}

//-------------------------------------------------------------------------------------------------------
	public function returnTecnicodaq($dados)
	{
		$SQL = "
        SELECT 
        ad.periodo_referencia as periodo,
        ad.id_aceite as aceite, 
        ad.desc_analise_aceite as desc_analise,
        (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO  WHERE id_roteiro = ad.id_roteiro) AS modulo,
        (SELECT desc_perfil FROM TB_PERFIL  WHERE id_perfil = ad.perfil) AS perfil,
        (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = ad.id_usuario) AS nome,
        ad.roteiro_analise,
        CONCAT(CONVERT(CHAR(10), ad.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ad.ultima_alteracao , 114)) AS ultima_alteracao  
        FROM CGOB_TB_HISTORICO_RELATORIO as ad
            WHERE ad.id_contrato_obra = '" . $dados["id_contrato"] . "' AND periodo_referencia = '" . $dados["periodo"] . "' ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function returnEstruturaldaq($dados)
	{
		$SQL = "
        SELECT 
        ad.periodo_referencia as periodo,
        ad.id_aceite as aceite, 
        ad.desc_analise_aceite as desc_analise,
        (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO  WHERE id_roteiro = ad.id_roteiro) AS modulo,
        (SELECT desc_perfil FROM TB_PERFIL  WHERE id_perfil = ad.perfil) AS perfil,
        (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = ad.id_usuario) AS nome,
        ad.roteiro_analise,
        CONCAT(CONVERT(CHAR(10), ad.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ad.ultima_alteracao , 114)) AS ultima_alteracao  
        FROM CGOB_TB_HISTORICO_RELATORIO as ad
            WHERE ad.id_contrato_obra = '" . $dados["id_contrato"] . "' AND periodo_referencia = '" . $dados["periodo"] . "'
            AND perfil in ('2')
      ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function confereStatusAnalise($dados)
	{
		$SQL = "
        SELECT 
            count(id_relatorio_edit) as result
        FROM CGOB_TB_HISTORICO_RELATORIO
              WHERE publicar = 'S' AND id_contrato_obra = '" . $dados["id"] . "' AND id_aceite in ('retificado')
      ";

		$query = $this->db->query($SQL);
		return $query->result_array();
	}

//-------------------------------------------------------------------------------------------------------
	public function AndamentoReciboDaq($dados)
	{
		$SQL = "
        SELECT 
           id_aceite,
            perfil 
        FROM CGOB_TB_HISTORICO_RELATORIO
              WHERE publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '" . $dados["periodo"] . "'
      and id_aceite in('aprovado') and 
              perfil in('2','3')
      ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
}//Fecha
//#######################################################################################################################################
//# DNIT - AQUAVIARIO
//# Data: 27/08/2020 
//#######################################################################################################################################
