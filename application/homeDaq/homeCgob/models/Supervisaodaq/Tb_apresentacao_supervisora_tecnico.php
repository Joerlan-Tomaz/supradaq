<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_apresentacao_supervisora_tecnico extends CI_Model {

public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


//---------------------------------------------------------------------------------------
 public function insereResponsavelTecnico($dados) {
            var_dump($dados);
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);
          $this->db->set("id_roteiro", $dados["roteiro"]);

	        if (!empty($dados["empresa"])) {
            $this->db->set("empresa", $dados["empresa"]);
       		}
       		if (!empty($dados["profissional"])) {
            $this->db->set("profissional", $dados["profissional"]);
       		}
       		if (!empty($dados["email"])) {
            $this->db->set("email", $dados["email"]);
       		}
       		if (!empty($dados["telefone"])) {
            $this->db->set("telefone", $dados["telefone"]);
       		}
       		if (!empty($dados["crea"])) {
            $this->db->set("crea", $dados["crea"]);
       		}
       		if (!empty($dados["rnp"])) {
            $this->db->set("rnp", $dados["rnp"]);
       		}
       		if (!empty($dados["num_art"])) {
            $this->db->set("num_art", $dados["num_art"]);
       		}
       		if (!empty($dados["uf_registro"])) {
            $this->db->set("uf_registro", $dados["uf_registro"]);
       		}
       		if (!empty($dados["part_tecnica"])) {
            $this->db->set("part_tecnica", $dados["part_tecnica"]);
       		}
       		if (!empty($dados["forma_registro"])) {
            $this->db->set("forma_registro", $dados["forma_registro"]);
       		}
       		if (!empty($dados["status"])) {
            $this->db->set("status", $dados["status"]);
       		}
       		if (!empty($dados["data_registro"])) {
            $this->db->set("data_registro", $dados["data_registro"]);
       		}
       		if (!empty($dados["data_baixa"])) {
            $this->db->set("data_baixa", $dados["data_baixa"]);
       		}

	        if (!empty($dados["id_apresentacao"])) {
            $this->db->set("id_apresentacao", $dados["id_apresentacao"]);
       		}

	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_RESPONSAVEL_TECNICO");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	 }


	 public function Tableresponsaveltecnico($dados) {
        $SQL = "
          SELECT
            l.id_responsavel_tecnico, 
            l.profissional, 
            l.num_art,
            l.forma_registro,
            l.part_tecnica,
            convert(varchar(10),l.data_registro,103) AS registro,
            convert(varchar(10),l.data_baixa,103) AS baixa,
            convert(varchar(10),l.periodo_referencia,103) AS periodo_referencia,
            u.DESC_NOME as nome,
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao
            FROM CGOB_TB_RESPONSAVEL_TECNICO AS l
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario 
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";

     
        if (!empty($dados["id_responsavel_tecnico"])) {
            $SQL .= " AND l.id_responsavel_tecnico = '" . $dados["id_responsavel_tecnico"] . "' ";
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


      public function recuperaART($dados) {
        
        $SQL = "
          SELECT
            l.id_art_supervisao,
            l.nome_profissional,
            l.num_art,
            l.forma_registro,
            l.participacao_tecnica,
            a.id_arquivo,
            convert(varchar(10),l.data_baixa,103) AS data_baixa,
            convert(varchar(10),l.data_registro,103) AS data_registro,
            a.nomeOriginalArquivo,
            a.nome_arquivo,
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_ART_SUPERVISAO AS l
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario
            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
        WHERE (l.publicar like '%S%')
        ";

     
        if (!empty($dados["id_art_supervisao"])) {
            $SQL .= " AND l.id_art_supervisao = '" . $dados["id_art_supervisao"] . "' ";
        }
        
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

      /*  if (!empty($dados["periodo"])) {
            $SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
        }*/

        $SQL .= " ORDER BY l.ultima_alteracao DESC";
       
       // echo('<pre>');
       // die($SQL);
        $query = $this->db->query($SQL);
        return $query->result();
    }




}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 16/01/2020 13:00
//########################################################################################################################################################################################################################