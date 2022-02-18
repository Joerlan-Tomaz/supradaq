<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_apresentacao_construtora_localizacao extends CI_Model {

public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


//---------------------------------------------------------------------------------------
    public function insereLocalizacao($dados) {
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);
          $this->db->set("id_roteiro", $dados["roteiro"]);

	        if (!empty($dados["hidrovia"])) {
            $this->db->set("hidrovia", $dados["hidrovia"]);
       		}
       		if (!empty($dados["pnv_inicial"])) {
            $this->db->set("pnv_inicial", $dados["pnv_inicial"]);
       		}
       		if (!empty($dados["pnv_final"])) {
            $this->db->set("pnv_final", $dados["pnv_final"]);
       		}
       		if (!empty($dados["coordenada_inicial"])) {
            $this->db->set("coordenada_inicial", $dados["coordenada_inicial"]);
       		}
       		if (!empty($dados["coordenada_final"])) {
            $this->db->set("coordenada_final", $dados["coordenada_final"]);
       		}
       		if (!empty($dados["extensao"])) {
            $this->db->set("extensao", $dados["extensao"]);
       		}
       		if (!empty($dados["estaca_inicial"])) {
            $this->db->set("estaca_inicial", $dados["estaca_inicial"]);
       		}
       		if (!empty($dados["estaca_final"])) {
            $this->db->set("estaca_final", $dados["estaca_final"]);
       		}
       		if (!empty($dados["km_inicial"])) {
            $this->db->set("km_inicial", $dados["km_inicial"]);
       		}
       		if (!empty($dados["km_final"])) {
            $this->db->set("km_final", $dados["km_final"]);
       		}

	        if (!empty($dados["id_apresentacao"])) {
            $this->db->set("id_apresentacao", $dados["id_apresentacao"]);
       		}

	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	 }


	 public function Tablelocalizacao($dados) {
        $SQL = "
          SELECT
            l.id_localizacao, 
            l.hidrovia,
            l.pnv_inicial as inicial,
            l.pnv_final as final,
            l.km_inicial,
            l.km_final,
            CASE WHEN (l.extensao is null or l.extensao like '') THEN
             '--' 
            ELSE l.extensao
            END as extensao,
            convert(varchar(10),l.periodo_referencia,103) AS periodo_referencia,
            u.DESC_NOME as nome,
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao
            FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO AS l
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario 
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";

     
        if (!empty($dados["id_localizacao"])) {
            $SQL .= " AND l.id_localizacao = '" . $dados["id_localizacao"] . "' ";
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


    public function excluirLocalizacao($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_localizacao", $dados['id_localizacao']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO");
        return true;
    }

}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 16/01/2020 13:00
//########################################################################################################################################################################################################################