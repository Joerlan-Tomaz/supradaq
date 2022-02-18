<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_contrato_obra extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

//-------------------------------------------------------------------------------------------------------
	public function RecuperaTabelaContratoSuper()
	{
		$SQL = "
        SELECT 
            co.id_contrato_obra as id_contrato
            ,co.nu_con_formatado as contrato
            ,co.no_empresa as nomecontrato
            ,co.descricao_br as bruf
            ,co.ds_fas_contrato as situacao
            ,co.sg_uf_unidade_local
            ,co.nu_con_formatado_supervisor,
            cs.no_empresa as nomesuper
        FROM CGOB_TB_CONTRATO_OBRA as co
        full outer join CGOB_TB_CONTRATO_SUPERVISORA as cs ON co.nu_con_formatado_supervisor = cs.nu_con_formatado
      ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function RecuperaTabelaContrato()
	{
		$SQL = "
        SELECT 
            co.id_contrato_obra as id_contrato
            ,co.nu_con_formatado as contrato
            ,co.no_empresa as nomecontrato
            ,co.descricao_br as bruf
            ,co.ds_fas_contrato as situacao
            ,co.sg_uf_unidade_local,
            CASE WHEN (co.nu_con_formatado_supervisor is null or co.nu_con_formatado_supervisor like '') THEN '- -'
                    ELSE (SELECT concat(cs.nu_con_formatado,'-',cs.no_empresa) FROM CGOB_TB_CONTRATO_SUPERVISORA as cs WHERE co.nu_con_formatado_supervisor = cs.nu_con_formatado)
                END as nu_con_formatado_supervisor
			,co.sg_uf as uf
        FROM CGOB_TB_CONTRATO_OBRA as co
		INNER JOIN TB_USUARIO_CONTRATO_OBRA TUCO on co.id_contrato_obra = TUCO.id_contrato_obra
		WHERE TUCO.ativo = 'S'
        AND TUCO.id_usuario = '{$this->session->id_usuario_daq}'
		GROUP BY co.id_contrato_obra,co.nu_con_formatado,co.no_empresa,co.descricao_br,co.ds_fas_contrato,co.sg_uf_unidade_local,
			co.nu_con_formatado_supervisor,co.sg_uf
      ";

		$SQL .= " ORDER BY co.id_contrato_obra DESC";
                //echo('<pre>');
                //echo($SQL);
                //die();
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function RecuperaDadosContrato($dados)
	{
		$SQL = "
        SELECT 
            id_contrato_obra as id_contrato,
            nu_con_formatado as numero_contrato,
            no_empresa as nome_empresa,
            Valor_Inicial as valor_inicial,
            Valor_Inicial_Adit_Reajustes as valor_total,
            Valor_Total_de_Aditivos as valor_total_aditivo,
            Valor_Total_de_Reajuste as valor_total_reajuste,
            Valor_Medicao_PI_R as total_medido,
            Valor_Empenhado as total_empenhado,
            (CONVERT(CHAR(10),(CAST( dt_termino_vigencia AS DATE)),103))as vigencia,
            ds_fas_contrato as situacao
        FROM CGOB_TB_CONTRATO_OBRA
      WHERE id_contrato_obra=" . $dados["idContrato"];

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function RecuperaContrato($dados)
	{
		$SQL = "
        SELECT 
        r.id_contrato_obra as id_contrato,
        r.nu_con_formatado,
        r.no_empresa as nomecontrato,
        CASE WHEN (r.nu_con_formatado_supervisor is null or r.nu_con_formatado_supervisor like '') THEN
                    '- -'
                    ELSE (SELECT concat(cs.nu_con_formatado,'-',cs.no_empresa) 
                    		FROM CGOB_TB_CONTRATO_SUPERVISORA as cs 
                    		WHERE r.nu_con_formatado_supervisor = cs.nu_con_formatado)
                END as nu_con_formatado_supervisor,
        r.descricao_br as bruf,
        r.ds_fas_contrato as situacao
        FROM CGOB_TB_CONTRATO_OBRA AS r
		INNER JOIN TB_USUARIO_CONTRATO_OBRA TUCO on r.id_contrato_obra = TUCO.id_contrato_obra
		WHERE TUCO.ativo = 'S' 
        AND TUCO.id_usuario = '{$this->session->id_usuario_daq}'
        AND (r.nu_con_formatado LIKE '%" . $dados["contrato_busca"] . "%'
        OR r.no_empresa LIKE '%" . $dados["contrato_busca"] . "%'
        OR r.nu_con_formatado_supervisor LIKE '%" . $dados["contrato_busca"] . "%'
        OR r.descricao_br LIKE '%" . $dados["contrato_busca"] . "%'
        OR r.ds_fas_contrato LIKE '%" . $dados["contrato_busca"] . "%')
        GROUP BY r.id_contrato_obra,r.nu_con_formatado,r.no_empresa,r.nu_con_formatado_supervisor,r.descricao_br,r.ds_fas_contrato
        ";
       // echo('<PRE>');
       // die($SQL);
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function confereGestaoAmbiental($dados)
	{
		$SQL = "
        SELECT c.id_contrato_obra, 
        CASE
            WHEN
        (SELECT top 1 (id_licenca_ambiental)
        FROM CGOB_TB_LICENCAS_AMBIENTAIS AS la 
        WHERE 
        la.id_contrato_obra = c.id_contrato_obra 
        AND la.publicar = 'S') >= 1 THEN '1'
            ELSE 0 
        END as licenca_ambiental,

        CASE 
            WHEN
        (SELECT top 1 (id_pba_pbai)
        FROM CGOB_TB_PBA_PBAI AS pb 
        WHERE pb.id_contrato_obra = c.id_contrato_obra 
        AND pb.publicar = 'S') >= 1 THEN '1'
            ELSE 0
        END as pba_pbai

        FROM CGOB_TB_CONTRATO_OBRA AS c
        WHERE c.id_contrato_obra=" . $dados['id_contrato_obra'];
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function confereRelatorio($dados)
	{
		$SQL = "
        SELECT
        	id_roteiro AS ID, 
        	roteiro_analise
        FROM CGOB_TB_HISTORICO_RELATORIO
        WHERE id_relatorio_edit = (SELECT max(id_relatorio_edit) 
        								FROM CGOB_TB_HISTORICO_RELATORIO 
									WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " 
									AND periodo_referencia = '" . $dados["periodo"] . "' )
        ";

		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function returnCheckConfiguracao($dados)
	{
		$SQL = "
        SELECT 
        c.id_contrato_obra, 
        c.descricao_br as br,
        c.nm_programa as programa,
        c.ds_objeto as objeto_contratacao,
        CASE
            WHEN
        (SELECT top 1 (id_resumo) 
        FROM CGOB_TB_RESUMO AS r 
        WHERE 
         r.id_roteiro = 14
        AND r.id_contrato_obra = c.id_contrato_obra 
        AND r.publicar = 'S') >= 1 THEN '1'
            ELSE 0
        END as justificativa,
        CASE 
            WHEN
        (SELECT top 1 (id_arquivo)
        FROM CGOB_TB_ARQUIVO AS ms 
        WHERE  
         ms.roteiro = 15
        AND ms.id_contrato_obra = c.id_contrato_obra 
        AND ms.publicar = 'S') >= 1 THEN '1'
            ELSE 0
        END as mapa_situacao, 
        CASE 
            WHEN
        (SELECT top 1 (id_arquivo)
        FROM CGOB_TB_ARQUIVO AS eg
        WHERE  
         eg.roteiro = 17
        AND eg.id_contrato_obra = c.id_contrato_obra 
        AND eg.publicar = 'S') >= 1 THEN '1'
            ELSE 0           
        END as eixos_georreferenciados, 
        CASE 
            WHEN
        (SELECT top 1 (id_arquivo) 
        FROM CGOB_TB_ARQUIVO AS pp
        WHERE  
         pp.roteiro = 20
        AND pp.id_contrato_obra = c.id_contrato_obra 
        AND pp.publicar = 'S') >= 1 THEN '1'
            ELSE 0
        END as ponto_passagem, 
        
        CASE 
            WHEN
        (SELECT top 1 (id_arquivo)
        FROM CGOB_TB_ARQUIVO AS op
        WHERE 
         op.roteiro = 21
        AND op.id_contrato_obra = c.id_contrato_obra 
        AND op.publicar = 'S') >= 1 THEN '1'
            ELSE 0
        END as ocorrencias_projeto,  
       
        CASE 
            WHEN
        (SELECT top 1 (id_arquivo)
        FROM CGOB_TB_ARQUIVO AS di 
        WHERE 
         di.roteiro = 16
        AND di.id_contrato_obra = c.id_contrato_obra 
        AND di.publicar = 'S') >= 1 THEN '1'
            ELSE 0
        END as diagramas, 
       
        CASE 
            WHEN
        (SELECT top 1 (id_art_supervisao)
        FROM CGOB_TB_ART_SUPERVISAO AS art
        WHERE 
         art.id_contrato_obra = c.id_contrato_obra 
        AND art.publicar = 'S') >= 1 THEN '1'
            ELSE 0 
        END as art_supervisao, 
        
        CASE 
            WHEN
        (SELECT top 1 (id_portaria_fiscal)
        FROM CGOB_TB_PORTARIA_FISCAIS AS pf
        WHERE 
         pf.id_contrato_obra = c.id_contrato_obra 
        AND pf.publicar = 'S') >= 1 THEN '1'
            ELSE 0
        END as portaria_fiscais

      FROM CGOB_TB_CONTRATO_OBRA AS c
      WHERE c.id_contrato_obra=" . $dados['id_contrato_obra'];
		$query = $this->db->query($SQL);
		return $query->result();
	}

//-------------------------------------------------------------------------------------------------------
	public function returncheckCronogramas($dados)
	{
		$SQL = "
        SELECT 
       
        CASE 
            WHEN
        (SELECT top 1 (id_cronograma_financeiro)
        FROM CGOB_TB_CRONOGRAMA_FINANCEIRO AS financeiro
        WHERE financeiro.id_contrato_obra = " . $dados['id_contrato_obra'] . "
        AND financeiro.publicar = 'S' AND publicar_versao = 'S') >= 1 THEN '1'
            ELSE 0
        END as cronograma_financeiro_obra,
        CASE 
            WHEN
        (SELECT top 1 (id_cronograma_fisico)
        FROM CGOB_TB_CRONOGRAMA_FISICO AS fisico
        WHERE fisico.id_contrato_obra = " . $dados['id_contrato_obra'] . "
        AND fisico.publicar = 'S' AND publicar_versao = 'S') >= 1 THEN '1'
            ELSE 0
        END as cronograma_fisico
        
        ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function ListaContratosPorUf($uf)
	{
		$SQL = "
        SELECT 
            co.id_contrato_obra as id_contrato
            ,co.nu_con_formatado as contrato
            ,co.no_empresa as nomecontrato
            ,co.descricao_br as bruf
            ,co.ds_fas_contrato as situacao
            ,co.sg_uf_unidade_local,
            CASE WHEN (co.nu_con_formatado_supervisor is null or co.nu_con_formatado_supervisor like '') THEN '- -'
                    ELSE (SELECT concat(cs.nu_con_formatado,'-',cs.no_empresa) 
                    	FROM CGOB_TB_CONTRATO_SUPERVISORA as cs 
                    WHERE co.nu_con_formatado_supervisor = cs.nu_con_formatado)
                END as nu_con_formatado_supervisor
        FROM CGOB_TB_CONTRATO_OBRA as co
			WHERE co.sg_uf_unidade_local = '" . $uf . "'";

		$SQL .= " ORDER BY id_contrato_obra DESC";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function BuscaUf()
	{
		$SQL = "
        SELECT 
            estado, uf 
        FROM CGOB_TB_UF";

		$SQL .= " ORDER BY uf ASC";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function dadosContratoPainelGerencial()
	{
		$SQL = "SELECT 
            con.*,
				concat(con.no_municipio, '/', con.sg_uf_unidade_local) as municipioUf,
				CONVERT(CHAR(10),con.dt_base , 103) as mesBase,
				CONVERT(CHAR(10),con.dt_assinatura , 103) as assinatura,
				(CONVERT(CHAR(10),(CAST(con.dt_inicio AS DATE)),103)) as ordemInicio,
				CONVERT(CHAR(10),con.dt_ter_prv , 103) as dataTerminoServico,
				CONVERT(CHAR(10),con.dt_termino_vigencia , 103) as dataTerminoVigencia,
				pf.*,
       			(SELECT CASE WHEN (r.id_pba is null or r.id_pba like '') THEN '--'
					 ELSE (select desc_pba from CGOB_TB_PBA AS a where a.id_pba = r.id_pba)
					END as desc_pba
				FROM CGOB_TB_PBA_PBAI AS r
				WHERE (r.publicar like '%S%' or r.publicar is NULL)
				  AND r.id_contrato_obra = con.id_contrato_obra
				ORDER BY r.ultima_alteracao ASC
				OFFSET 1 ROWS) AS pba,
       			(SELECT CASE WHEN (r.id_pbai is null or r.id_pbai like '') THEN '--'
					 ELSE (select desc_pbai from CGOB_TB_PBAI AS i where i.id_pbai = r.id_pbai)
					END as desc_pbai
				FROM CGOB_TB_PBA_PBAI AS r
				WHERE (r.publicar like '%S%' or r.publicar is NULL)
				  AND r.id_contrato_obra = con.id_contrato_obra
				ORDER BY r.ultima_alteracao ASC
				OFFSET 1 ROWS) AS pbai,
		   (SELECT l.hidrovia as h
			FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO AS l
			WHERE (l.publicar like '%S%' or l.publicar is NULL)
			  AND l.id_localizacao = (SELECT MAX(l2.id_localizacao)
									  FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO l2
									  where l2.publicar = 'S'
										AND l2.id_contrato_obra = con.id_contrato_obra)) as hidrovia
			FROM CGOB_TB_CONTRATO_OBRA con
				 LEFT JOIN CGOB_TB_UF AS uf ON uf.id_uf = con.co_uf
				 LEFT JOIN CGOB_TB_PORTARIA_FISCAIS AS pf ON pf.id_contrato_obra = con.id_contrato_obra
					AND pf.id_titularidade = 1 AND pf.publicar = 'S'
        WHERE con.id_contrato_obra = " . $_REQUEST['id_contrato_obra'];

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaGerencialObraFinanceiro($dados)
	{
		$SQL = "
        SELECT 
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
        FROM CGOB_TB_CONTRATO_OBRA
      WHERE id_contrato_obra=" . $dados["idContrato"];

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function buscaContratosUsuario()
	{
		$SQL = "SELECT con.id_contrato_obra, 
       			CONCAT(con.nu_con_formatado, ' - ', con.no_empresa) as nome,
       			(SELECT ativo FROM TB_USUARIO_CONTRATO_OBRA uco WHERE uco.id_usuario = {$_REQUEST['id_usuario']} AND uco.id_contrato_obra = con.id_contrato_obra) as ativo
					FROM CGOB_TB_CONTRATO_OBRA as con
							 LEFT JOIN CGOB_TB_CONTRATO_SUPERVISORA as sup 
								 ON con.nu_con_formatado_supervisor = sup.nu_con_formatado
					where 1 = 1";
		if ($_REQUEST['tipo'] == 'supervisao') {
			$SQL .= " AND sup.id_contrato_supervisora = " . $_REQUEST['id_supervisora'];
		}
		$SQL .= "GROUP BY con.id_contrato_obra, CONCAT(con.nu_con_formatado, ' - ', con.no_empresa)
				order by CONCAT(con.nu_con_formatado, ' - ', con.no_empresa)";

		$query = $this->db->query($SQL);
		return $query->result();
	}

}//Fecha
//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO
//# Desenvolvedora:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################


