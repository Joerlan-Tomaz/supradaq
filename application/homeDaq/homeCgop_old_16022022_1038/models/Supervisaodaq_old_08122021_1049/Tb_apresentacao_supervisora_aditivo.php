<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_apresentacao_supervisora_aditivo extends CI_Model {

public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

	//---------------------------------------------------------------------------------------
    public function insereAditivo($dados) {
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);
          $this->db->set("id_roteiro", $dados["roteiro"]);

	         if (!empty($dados["numero_termo"])) {
            $this->db->set("numero_termo", $dados["numero_termo"]);
       		}
       		 if (!empty($dados["desc_objeto_termo"])) {
            $this->db->set("desc_objeto_termo", $dados["desc_objeto_termo"]);
       		}
       		 if (!empty($dados["dias_aditados"])) {
            $this->db->set("dias_aditados", $dados["dias_aditados"]);
       		}
       		 if (!empty($dados["valor_aditado"])) {
            $this->db->set("valor_aditado", $dados["valor_aditado"]);
       		}
       		 if (!empty($dados["valor_atualizado"])) {
            $this->db->set("valor_atualizado", $dados["valor_atualizado"]);
       		}
       		 if (!empty($dados["desc_motivacao_aditivo"])) {
            $this->db->set("desc_motivacao_aditivo", $dados["desc_motivacao_aditivo"]);
       		}
       		 if (!empty($dados["data_assinatura"])) {
            $this->db->set("data_assinatura", $dados["data_assinatura"]);
       		}
       		 if (!empty($dados["data_termino_atualizada"])) {
            $this->db->set("data_termino_atualizada", $dados["data_termino_atualizada"]);
       		}

	        if (!empty($dados["id_apresentacao"])) {
            $this->db->set("id_apresentacao", $dados["id_apresentacao"]);
       		}

	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	 }


	public function Tableaditivo($dados) {
        $SQL = "
          SELECT
            l.id_termo_aditivo, 
            l.numero_termo,
            convert(varchar(10),l.data_assinatura,103) AS data_assinatura,
            l.dias_aditados,
            l.desc_objeto_termo,
            l.valor_aditado,
            convert(varchar(10),l.periodo_referencia,103) AS periodo_referencia,
            u.DESC_NOME as nome,
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao
            FROM CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO AS l
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario 
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";

     
        if (!empty($dados["id_termo_aditivo"])) {
            $SQL .= " AND l.id_termo_aditivo = '" . $dados["id_termo_aditivo"] . "' ";
        }
        
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        if (!empty($dados["roteiro"])) {
            $SQL .= " AND l.id_roteiro in(" . $dados["roteiro"] . ")";
        }

        $SQL .= " ORDER BY l.ultima_alteracao DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


    public function modalObjetoMotivacaoAditivo($dados) {
        $SQL = "
          SELECT
            r.id_termo_aditivo,
            r.desc_objeto_termo,
            r.desc_motivacao_aditivo
            FROM CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO AS r
        WHERE r.id_termo_aditivo ='". $dados["id_termo_aditivo"]. "'";

         if (!empty($dados["roteiro"])) {
            $SQL .= " AND r.id_roteiro in(" . $dados["roteiro"] . ")";
        }

        $query = $this->db->query($SQL);
        return $query->result();
    }




     public function excluirAditivo($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_termo_aditivo", $dados['id_termo_aditivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO");
        return true;
    }



}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 15/01/2020 13:00
//########################################################################################################################################################################################################################