<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_fotografica extends CI_Model {

	public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


    public function insereDocFotografico($dados) {
			        date_default_timezone_set("America/Sao_Paulo");
			        $this->db->set("id_contrato_obra", $dados["idContrato"]);
			        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
			        $this->db->set("id_usuario", $dados["idUsuario"]);

			        if (!empty($dados["km"])) {
			            $this->db->set("km", $dados["km"]);
			        }
			        if (!empty( $dados["latitude"])) {
			            $this->db->set("latitude", $dados["latitude"]);
			        }
			        if (!empty( $dados["longitude"])) {
			            $this->db->set("longitude", $dados["longitude"]);
			        }
			        if (!empty(  $dados["estaca"] )) {
			            $this->db->set("estaca",  $dados["estaca"] );
			        }
			        if (!empty(  $dados["descricao"] )) {
			            $this->db->set("descricao",  $dados["descricao"] );
			        }
			        if (!empty(  $dados["desc_arquivo"] )) {
			            $this->db->set("desc_arquivo",  $dados["desc_arquivo"] );
			        }
			        if (!empty($dados["id_arquivo"])) {
		            $this->db->set("id_arquivo", $dados["id_arquivo"]);
		       		}

			        $this->db->set("publicar", "S");
			        $this->db->set("periodo_referencia", $dados["periodo"]);
			        $this->db->insert("CGOB_TB_FOTOGRAFICA");
			        $this->db->trans_complete();
			        if ($this->db->trans_status() === true) {
			            $this->db->trans_commit();
			            return $this->db->insert_id();
			        } else {
			            $this->db->trans_rollback();
			            return false;
			        }
			    }

public function recuperaDocumentacao($dados) {
	        $SQL = "
	          SELECT
	           l.id_documentacao_foto,
	            l.descricao,
	            l.km,
	            l.id_arquivo,
	            a.nomeOriginalArquivo as arquivo,
	            a.nome_arquivo,
	            u.DESC_NOME as nome,
	             concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao
	            FROM CGOB_TB_FOTOGRAFICA AS l
	            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario
	            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
	        WHERE (l.publicar like '%S%' or l.publicar is NULL)
	        ";

	     
	        if (!empty($dados["id_documentacao_foto"])) {
	            $SQL .= " AND l.id_documentacao_foto = '" . $dados["id_documentacao_foto"] . "' ";
	        }
	        
	        if (!empty($dados["idContrato"])) {
	            $SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
	        }

	        if (!empty($dados["periodo"])) {
	            $SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
	        }

	        $SQL .= " ORDER BY l.ultima_alteracao DESC";
	       
	        $query = $this->db->query($SQL);
	        return $query->result();
	    }



 public function excluirDocumentacao($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_documentacao_foto", $dados['id_documentacao_foto']);
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_FOTOGRAFICA");
        
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_ARQUIVO");
 

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function getQtdFotosMesPainelGerencial($dados){
		$SQL = "
	          SELECT
					count(*) as qtd, 
	                l.periodo_referencia,
    				CAST(MONTH(l.periodo_referencia) AS VARCHAR(4)) AS mes,
    				CAST(YEAR(l.periodo_referencia) AS VARCHAR(4)) AS ano
				FROM CGOB_TB_FOTOGRAFICA AS l
						 INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario
						 INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
				WHERE (l.publicar like '%S%' or l.publicar is NULL)";

		if (!empty($dados["id_contrato_obra"])) {
			$SQL .= " AND l.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' ";
		}

		$SQL .= " GROUP BY l.periodo_referencia
					ORDER BY l.periodo_referencia ASC";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function getFotosPeriodoPainelGerencial($dados){
		$SQL = "
	          SELECT
					l.estaca,
				    concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao,
				    l.latitude, l.longitude, l.descricao,
				    l.id_arquivo,
	                CAST(MONTH(l.periodo_referencia) AS VARCHAR(4)) AS mes,
    				CAST(YEAR(l.periodo_referencia) AS VARCHAR(4)) AS ano,
	                a.nome_arquivo
				FROM CGOB_TB_FOTOGRAFICA AS l
						 INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario
						 INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
				WHERE (l.publicar like '%S%' or l.publicar is NULL)";

		if (!empty($dados["id_contrato_obra"])) {
			$SQL .= " AND l.id_contrato_obra = '" . $dados["id_contrato_obra"] . "' ";
		}

		if (!empty($dados["periodo"])) {
			$SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
		}

		$SQL .= " ORDER BY l.periodo_referencia ASC";

		$query = $this->db->query($SQL);
		return $query->result();
	}





}//Fecha Modal
