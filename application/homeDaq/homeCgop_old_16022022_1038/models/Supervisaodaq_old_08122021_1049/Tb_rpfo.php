<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_rpfo extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

//--------------------------RPFO------------------------------------------------------------------

  public function populaLocal() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
	  	$this->db->order_by('desc_local');
        $this->db->from("CGOB_TB_RPFO_ITEM_LOCAL");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

     public function populaStatus() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_RPFO_ITEM_STATUS");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }


    public function recuperaRpfo($dados) {
        $SQL = "
          SELECT
            r.id_rpfo,
            r.id_arquivo,
            r.numero_rpfo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            CONVERT(CHAR(10),r.data_parecer , 103) AS data_parecer,
            u.DESC_NOME as nome,
            s.desc_status as status,
            l.desc_local as local
            FROM CGOB_TB_RPFO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            LEFT JOIN CGOB_TB_RPFO_ITEM_STATUS AS s ON s.id_status = r.id_status
            LEFT JOIN CGOB_TB_RPFO_ITEM_LOCAL AS l ON l.id_local = r.id_local
        WHERE (r.publicar like '%S%' or r.publicar is NULL) AND flag_atividade = 'S'
        ";

        if (!empty($dados["id_rpfo"])) {
            $SQL .= " AND r.id_rpfo = '" . $dados["id_rpfo"] . "' ";
        }
        
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


 public function insereRpfo($dados) {

        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set('flag_atividade', 'S');

         if (!empty($dados["numero_rpfo"])) {
            $this->db->set("numero_rpfo", $dados["numero_rpfo"]);
        }
          if (!empty($dados["data_parecer"])) {
            $this->db->set("data_parecer", $dados["data_parecer"]);
        }
        if (!empty($dados["desc_motivacao"])) {
            $this->db->set("desc_motivacao", $dados["desc_motivacao"]);
        }
        if (!empty($dados["desc_status_detalhado"])) {
             $this->db->set("desc_status_detalhado", $dados["desc_status_detalhado"]);
        }
         if (!empty($dados["desc_analistas_responsaveis"])) {
             $this->db->set("desc_analistas_responsaveis", $dados["desc_analistas_responsaveis"]);
        }
         if (!empty($dados["id_arquivo"])) {
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
        }
         if (!empty($dados["local"])) {
            $this->db->set("id_local", $dados["local"]);
        }
         if (!empty($dados["status"])) {
            $this->db->set("id_status", $dados["status"]);
        }
       
        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_RPFO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }


 public function alteraRpfo($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["id_usuario"]);
        $this->db->set("numero_rpfo", $dados["numero_rpfo"]);
        $this->db->set("data_parecer", $dados["data_parecer"]);
        $this->db->set("desc_motivacao", $dados["desc_motivacao"]);
        $this->db->set("desc_status_detalhado", $dados["desc_status_detalhado"]);
        $this->db->set("desc_analistas_responsaveis", $dados["desc_analistas_responsaveis"]);

        $this->db->where("id_rpfo", $dados["id_rpfo"]);

        $this->db->update("CGOB_TB_RPFO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

 public function consultaObservacao($dados) {
        $SQL = "
          SELECT
            r.id_rpfo,
            r.ultima_alteracao,
            r.desc_motivacao, 
            r.desc_status_detalhado,
            r.desc_analistas_responsaveis
            FROM CGOB_TB_RPFO AS r
        WHERE r.id_rpfo ='". $dados["id_rpfo"]. "'";

        $query = $this->db->query($SQL);
        return $query->result();
    }


    public function recupera_Rpfo_edicao($dados) {
        $SQL = "
          SELECT
            r.id_rpfo,
            r.numero_rpfo,
            r.desc_motivacao, 
            r.desc_status_detalhado,
            r.desc_analistas_responsaveis,
            convert(varchar(10),r.data_parecer,103) AS data_parecer
            FROM CGOB_TB_RPFO AS r
            
        WHERE r.id_rpfo ='". $dados["id_rpfo"]. "'";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }

      public function excluirRpfo($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_rpfo", $dados['id_rpfo']);
        $this->db->set("publicar", "N");
        $this->db->set("flag_atividade", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_RPFO");
        
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
    public function excluiratividade($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_rpfo", $dados['id_rpfo']);
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->set("publicar", "N");
        $this->db->set("flag_atividade", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->update("CGOB_TB_RPFO");
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
    public function recupera($dados){
        $SQL = "
        SELECT
        rnc.id_rpfo
        FROM CGOB_TB_RPFO AS rnc
        WHERE (rnc.publicar like '%S%' OR rnc.publicar = 'S') and rnc.id_contrato_obra=". $dados['id_contrato_obra'] ."  AND flag_atividade = 'S'
        AND rnc.periodo_referencia='" . $dados["periodo"] . "'
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

//-------------------------------------------------------------------------------------------------------
    public function insereNaoAtividade($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->set('id_contrato_obra', $dados['id_contrato_obra']);
        if (!empty($dados["id_rpfo"])) {
            $this->db->set("id_rpfo", $dados["id_rpfo"]);
        }
        $this->db->set('periodo_referencia', $dados['periodo']);
        $this->db->set('publicar', 'S');
        $this->db->set('flag_atividade', 'N');
        $this->db->set('descricao_atv', 'Não houve atividade este mês');
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set('id_usuario', $dados['idUsuario']);
        $this->db->insert("CGOB_TB_RPFO");
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
    public function confereAtividade($dados){
        $SQL = "
        SELECT count(1)id_rpfo,
				   r.id_rpfo                                                                                          as id,
				   r.descricao_atv,
				   concat(CONVERT(CHAR(10), r.ultima_alteracao, 103), ' ',
						  CONVERT(CHAR(8), r.ultima_alteracao, 114))                                                  AS ultima_alteracao,
				   u.DESC_NOME
			FROM CGOB_TB_RPFO AS r
			 INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
        WHERE r.id_contrato_obra = ". $dados['id_contrato_obra'] ." 
        	AND r.flag_atividade = 'N' 
        	AND r.publicar = 'S'";

        $SQL .= "GROUP BY id_rpfo, descricao_atv, u.DESC_NOME,r.ultima_alteracao";

        $query = $this->db->query($SQL);
        return $query->result();
    }


	public function insereRpfoHistorico($dados) {
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("data_alteracao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("id_local", $dados["id_local"]);
		$this->db->set("id_status", $dados["id_status"]);
		$this->db->set("id_rpfo", $dados["id_rpfo"]);

		$this->db->insert("CGOB_TB_RPFO_HISTORICO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function recuperaRpfoHistorico($id_rpfo) {
		$SQL = "
          SELECT
			r.id_rpfo_historico,
			s.desc_status as status,
            l.desc_local as local,
			r.data_alteracao,
			u.DESC_NOME as nome,
            concat( CONVERT(CHAR(10),r.data_alteracao , 103),' ', CONVERT(CHAR(8),r.data_alteracao , 114)) AS data_alteracao
            FROM CGOB_TB_RPFO_HISTORICO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            INNER JOIN CGOB_TB_RPFO_ITEM_STATUS AS s ON s.id_status = r.id_status
            INNER JOIN CGOB_TB_RPFO_ITEM_LOCAL AS l ON l.id_local = r.id_local
        WHERE r.id_rpfo ='". $id_rpfo. "'
        AND r.data_exclusao IS NULL";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function inserirArquivoHistorico($dados){

		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("datahora_inclusao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario", $dados["idUsuario"]);
		$this->db->set("id_rpfo_historico", $dados["id_rpfo_historico"]);
		$this->db->set("id_arquivo", $dados["id_arquivo"]);

		$this->db->insert("CGOB_TB_RPFO_ANEXO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return $this->db->insert_id();
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function recuperaRpfoAnexos($id_rpfoHistorico) {
		$SQL = "SELECT
				a.id_rpfo_anexo,
				a.id_arquivo,
				concat( CONVERT(CHAR(10),a.datahora_inclusao , 103),' ', CONVERT(CHAR(8),a.datahora_inclusao , 114)) AS data_inclusao,
				u.DESC_NOME as nome,
				r.nome_arquivo,
				r.nomeOriginalArquivo
			FROM CGOB_TB_RPFO_ANEXO AS a
				INNER JOIN TB_USUARIO AS u ON u.id_usuario = a.id_usuario
				INNER JOIN CGOB_TB_ARQUIVO AS r ON r.id_arquivo = a.id_arquivo
        WHERE a.id_rpfo_historico ='". $id_rpfoHistorico. "'
        AND a.data_exclusao IS NULL";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function excluirHistorico($idHistorico){
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("data_exclusao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_exclusao", $this->session->id_usuario_daq);

		$this->db->where("id_rpfo_historico", $idHistorico);

		$this->db->update("CGOB_TB_RPFO_HISTORICO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function excluirAnexo($id_rpfo_anexo){
		date_default_timezone_set("America/Sao_Paulo");
		$this->db->set("data_exclusao", date("Y-m-d H:i:s"));
		$this->db->set("id_usuario_exclusao", $this->session->id_usuario_daq);

		$this->db->where("id_rpfo_anexo", $id_rpfo_anexo);

		$this->db->update("CGOB_TB_RPFO_ANEXO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

}//fecha class

//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
