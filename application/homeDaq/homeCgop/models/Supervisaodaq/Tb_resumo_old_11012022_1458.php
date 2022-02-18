<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_resumo extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

    //--------------------------HISTORICO-INTRODUÇÂO--CONCLUSAOGERAL-------------------------------------------

    public function Recuperaresumo($dados) {
        $SQL = "
        SELECT
            r.id_resumo,
            r.resumo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_RESUMO AS r
            INNER JOIN TB_USUARIO as u on u.id_usuario = r.id_usuario
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";
       
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"]) && (!empty($dados["roteiro"]) && $dados["roteiro"] != 14)) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        if (!empty($dados["roteiro"])) {
            $SQL .= " AND r.id_roteiro in(" . $dados["roteiro"] . ")";
        }
     
        if (!empty($dados["id_resumo"])) {
            $SQL .= " AND r.id_resumo = '" . $dados["id_resumo"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";

        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function insereResumo($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("id_roteiro", $dados["roteiro"]);

        if (!empty($dados["resumo"])) {
            $this->db->set("resumo", $dados["resumo"]);
        }
        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("Cgob_Tb_resumo");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function alteraResumo($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->where("id_resumo", $dados["id_resumo"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("resumo", $dados["resumo"]);
        $this->db->update("Cgob_Tb_resumo");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function excluirResumo($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_resumo", $dados['id_resumo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("Cgob_Tb_resumo");
        return true;
    }
//--------------------------RESUMO-PROJETO--------------------------------------------
 public function Recuperaresumoprojeto($dados) {
        $SQL = "
          SELECT
            r.id_resumo,
            r.resumo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome,
            id_tipo_pavimento AS desc_tipo_obra,
            a.id_arquivo,
            a.nome_arquivo,
            a.nomeOriginalArquivo 
            FROM CGOB_TB_RESUMO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            LEFT JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo= r.id_arquivo
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        if (!empty($dados["roteiro"])) {
            $SQL .= " AND r.id_roteiro in(" . $dados["roteiro"] . ")";
        }
     
        if (!empty($dados["id_resumo"])) {
            $SQL .= " AND r.id_resumo = '" . $dados["id_resumo"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";
        //echo('<pre>');
        //die($SQL);

        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function Recuperaresumoprojeto_old_14102021_1230($dados) {
        $SQL = "
          SELECT
            r.id_resumo,
            r.resumo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome,
            t.desc_tipo_obra,
            a.id_arquivo,
            a.nome_arquivo,
            a.nomeOriginalArquivo 
            FROM CGOB_TB_RESUMO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            INNER JOIN CGOB_TB_OBRA AS t ON t.id_tipo_obra = r.id_tipo_pavimento
            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo= r.id_arquivo
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        if (!empty($dados["roteiro"])) {
            $SQL .= " AND r.id_roteiro in(" . $dados["roteiro"] . ")";
        }
     
        if (!empty($dados["id_resumo"])) {
            $SQL .= " AND r.id_resumo = '" . $dados["id_resumo"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";
        //echo('<pre>');
        //die($SQL);
       
        $query = $this->db->query($SQL);
        return $query->result();
    }

 public function insereResumoProjeto($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("id_roteiro", $dados["roteiro"]);

        if (!empty($dados["resumo"])) {
            $this->db->set("resumo", $dados["resumo"]);
        }

        if (!empty($dados["id_arquivo"])) {
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
        }

        if (!empty($dados["tipo_texto_resumo"])) {
            $this->db->set("id_tipo_pavimento", $dados["tipo_texto_resumo"]);
        }

        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("Cgob_Tb_resumo");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

        public function excluirResumoProjeto($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_resumo", $dados['id_resumo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("Cgob_Tb_resumo");
        return true;
    }

      public function populaTipoTexto() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_OBRA");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

  

        public function recuperaPGQ($dados) {
        $SQL = "
          SELECT
            r.id_resumo,
            r.resumo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome,
            a.id_arquivo,
            a.nome_arquivo,
            a.nomeOriginalArquivo as arquivo
            FROM CGOB_TB_RESUMO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            LEFT JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo= r.id_arquivo
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        if (!empty($dados["roteiro"])) {
            $SQL .= " AND r.id_roteiro in(" . $dados["roteiro"] . ")";
        }
     
        if (!empty($dados["id_resumo"])) {
            $SQL .= " AND r.id_resumo = '" . $dados["id_resumo"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


     public function inserePGQ($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("id_roteiro", $dados["roteiro"]);

        if (!empty($dados["resumo"])) {
            $this->db->set("resumo", $dados["resumo"]);
        }

        if (!empty($dados["id_arquivo"])) {
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
        }

        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("Cgob_Tb_resumo");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function excluirArquivo($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_resumo", $dados['id_resumo']);
		if (!empty($dados["id_arquivo"]) && $dados["id_arquivo"] != 0) {
			$this->db->where("id_arquivo", $dados['id_arquivo']);
		}
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_RESUMO");

		if (!empty($dados["id_arquivo"]) && $dados["id_arquivo"] != 0) {
			$this->db->where("id_arquivo", $dados['id_arquivo']);
			$this->db->set("publicar", "N");
			$this->db->set("data_publicacao", date("Y-m-d H:i:s"));
			$this->db->set("id_usuario_publicar", $dados['id_usuario']);
			$this->db->update("CGOB_TB_ARQUIVO");
		}

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

	public function insereNaoAtividade($dados){
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("id_contrato_obra", $dados["idContrato"]);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("id_roteiro", $dados["roteiro"]);

		$this->db->set("resumo", 'Não Houve Atividade');

		if (!empty($dados["id_arquivo"])) {
			$this->db->set("id_arquivo", $dados["id_arquivo"]);
		}

		$this->db->set("publicar", "S");
		$this->db->set("periodo_referencia", $dados["periodo"]);
		$this->db->insert("Cgob_Tb_resumo");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function confereAtividade($dados){
		$SQL = "
        SELECT
            res.id_resumo,
            CASE
                WHEN res.flag_atividade = 'N' THEN 'Sem Atividade'
                WHEN res.flag_atividade = 'S' THEN 'Com Atividade'
                ELSE 'Sem Registros'
            END as situacao
        FROM CGOB_TB_RESUMO AS res
        WHERE res.id_contrato_obra=". $dados['idContrato'] ."
        AND res.periodo_referencia='" . $dados["periodo"] . "'
        AND res.publicar = 'S'
        ";

		$query = $this->db->query($SQL);
		return $query->result();

	}

}
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
