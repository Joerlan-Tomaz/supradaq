<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_apresentacao_paralisacao_reinicio extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


	//---------------------------------------------------------------------------------------

		public function insereParalisacaoReinicio($dados) {
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);
            $this->db->set("id_roteiro", $dados["roteiro"]);

	        if (!empty($dados["tipo_documento"])) {
	            $this->db->set("tipo_documento", $dados["tipo_documento"]);
	        }
	        if (!empty($dados["motivacao"])) {
	            $this->db->set("motivacao", $dados["motivacao"]);
	        }
	        if (!empty($dados["data_reinicio"])) {
	            $this->db->set("data_reinicio", $dados["data_reinicio"]);
	        }

	        if (!empty($dados["id_arquivo"])) {
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
       		}

	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_APRESENTACAO_PARALISACAO_REINICIO");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	    }


	    public function tableAsParalisacaoReinicio($dados) {
        $SQL = "
          SELECT
            r.id_paralisacaoreinicio,
            r.motivacao,
            r.tipo_documento,
            convert(varchar(10),r.data_reinicio,103) AS data_reinicio,
            q.nome_arquivo,
            q.id_arquivo,
            q.nomeOriginalArquivo as arquivo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_APRESENTACAO_PARALISACAO_REINICIO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            INNER JOIN CGOB_TB_ARQUIVO AS q ON q.id_arquivo = r.id_arquivo

        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

     
        if (!empty($dados["id_paralisacaoreinicio"])) {
            $SQL .= " AND r.id_paralisacaoreinicio = '" . $dados["id_paralisacaoreinicio"] . "' ";
        }
        
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        if (!empty($dados["roteiro"])) {
            $SQL .= " AND r.id_roteiro in(" . $dados["roteiro"] . ")";
        }

        $SQL .= " ORDER BY r.data_reinicio DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }



     public function excluirParalisacaoReinicio($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_paralisacaoreinicio", $dados['id_paralisacaoreinicio']);
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_APRESENTACAO_PARALISACAO_REINICIO");
        
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

}//fecha model
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 17/01/2020 13:00
//########################################################################################################################################################################################################################