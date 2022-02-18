<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_gestao_tratativa extends CI_Model {

public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

	//---------------------------------------------------------------------------------------

    public function populaOrigem() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_ORIGEM");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }


    public function populaResponsaveis() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_RESPONSAVEL");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function insereGestaoTratativa($dados) {
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);
             $this->db->set("status_gestao", $dados["status_gestao"]);

	        if (!empty( $dados["data_solicitacao"])) {
	            $this->db->set("data_solicitacao",  $dados["data_solicitacao"]);
	        }
	        if (!empty( $dados["data_pactuada"]) and $dados["data_pactuada"] != '1969-12-31' ) {
	            $this->db->set("data_pactuada",  $dados["data_pactuada"]);
	        }
	        if (!empty( $dados["nova_data_pactuada"]) and $dados["nova_data_pactuada"]!='1969-12-31') {
	            $this->db->set("nova_data_pactuada",  $dados["nova_data_pactuada"]);
	        }
	        if (!empty( $dados["data_termino"])) {
	            $this->db->set("data_termino",  $dados["data_termino"]);
	        }
	    
	        if (!empty(  $dados["origem"] )) {
	            $this->db->set("id_origem",  $dados["origem"] );
	        }
	        if (!empty(  $dados["responsavel"] )) {
	            $this->db->set("id_responsavel",  $dados["responsavel"] );
	        }
	        if (!empty($dados["assunto_tratativa"])) {
	            $this->db->set("assunto_tratativa", $dados["assunto_tratativa"]);
	        }
	        if (!empty($dados["desc_status"])) {
	            $this->db->set("desc_status", $dados["desc_status"]);
	        }

	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_GESTAO_TRATATIVAS");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	    }

//----------------------------------------------------------------------------------------------------------------------
    public function gestao_tratativaNaoAtv($dados){
        $SQL = "
        SELECT
        id_gestao_tratativa as id 
        ,CASE WHEN flag_atividade = 'N' THEN 'Não houve atividade no mês' END atividademes
        ,CONCAT(CONVERT(CHAR(10), ultima_alteracao , 103),' ', CONVERT(CHAR(8), ultima_alteracao , 114)) AS ultima_alteracao
        ,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
        FROM CGOB_TB_GESTAO_TRATATIVAS AS af
        WHERE publicar = 'S' AND flag_atividade = 'N'AND id_contrato_obra =" . $dados["idContrato"] ." AND periodo_referencia ='" .$dados["periodo"] ."'          
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

	   public function recuperaGestaoTratativa($dados) {
        $SQL = "
          SELECT
            r.id_gestao_tratativa,
            convert(varchar(10),r.data_pactuada,103) as data_pactuada,
            convert(varchar(10),r.nova_data_pactuada,103) as nova_data_pactuada,
            convert(varchar(10),r.data_termino,103) as data_termino,
            r.desc_status,
            r.assunto_tratativa as assunto,
            convert(varchar(10),r.periodo_referencia,103) AS periodo_referencia,
            convert(varchar(10),r.data_solicitacao,103) AS solicitacao,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            r.status_gestao,
            u.DESC_NOME as nome,
            s.desc_origem as origem,
            l.desc_responsavel as responsavel,
            r.id_responsavel,
            r.id_origem,
            (SELECT top 1 status FROM CGOB_TB_PROVIDENCIA 
            WHERE id_gestao_tratativa = r.id_gestao_tratativa 
            and status ='fechado') as st
            FROM CGOB_TB_GESTAO_TRATATIVAS AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            INNER JOIN CGOB_TB_ORIGEM AS s ON s.id_origem = r.id_origem
            INNER JOIN CGOB_TB_RESPONSAVEL AS l ON l.id_responsavel = r.id_responsavel
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

     
        if (!empty($dados["id_gestao_tratativa"])) {
            $SQL .= " AND r.id_gestao_tratativa = '" . $dados["id_gestao_tratativa"] . "' ";
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


    public function status ($dados){
        $SQL = "

          SELECT 
          r.status 
          FROM CGOB_TB_PROVIDENCIA as r 
          inner join CGOB_TB_GESTAO_TRATATIVAS AS t on t.id_gestao_tratativa = r.id_gestao_tratativa
          WHERE (r.status like '%fechado%') ";

           if (!empty($dados["id_gestao_tratativa"])) {
            $SQL .= " AND r.id_gestao_tratativa = '" . $dados["id_gestao_tratativa"] . "' ";
        }
         return $query->result();
         $query = $this->db->query($SQL);

    }

     public function modalStatus($dados) {
        $SQL = "
          SELECT
            r.id_gestao_tratativa,
            r.assunto_tratativa
            FROM CGOB_TB_GESTAO_TRATATIVAS AS r
        WHERE r.id_gestao_tratativa ='". $dados["id_gestao_tratativa"]. "'";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }
    
    public function insereNaoAtividadeGestao($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->set('id_contrato_obra', $dados['idContrato']);
        $this->db->set('periodo_referencia', $dados['periodo']);
        $this->db->set('publicar', 'S');
        $this->db->set('flag_atividade', 'N');
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set('id_usuario', $dados['idUsuario']);

        $this->db->insert("CGOB_TB_GESTAO_TRATATIVAS");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

        public function insereProvidencia($dados) {
            date_default_timezone_set("America/Sao_Paulo");
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);

            if (!empty(  $dados["providencia"] )) {
                $this->db->set("providencia",  $dados["providencia"] );
            }
            if (!empty(  $dados["status"] )) {
                $this->db->set("status",  $dados["status"] );
            }
              if (!empty($dados["id_gestao_tratativa"])) {
            $this->db->set("id_gestao_tratativa", $dados["id_gestao_tratativa"]);
            }
            $this->db->set("publicar", "S");
            $this->db->set("periodo_referencia", $dados["periodo"]);
            $this->db->insert("CGOB_TB_PROVIDENCIA");
            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $this->db->trans_commit();
                return $this->db->insert_id();
            } else {
                $this->db->trans_rollback();
                return false;
            }
        }

     public function recuperaProvidencia($dados) {
        $SQL = "
          SELECT
            r.id_providencia,
            r.providencia,
            r.status as st,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_PROVIDENCIA AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["id_gestao_tratativa"])) {
            $SQL .= " AND r.id_gestao_tratativa = '" . $dados["id_gestao_tratativa"] . "' ";
        }

       
        $query = $this->db->query($SQL);
        return $query->result();
    }

 public function excluirProvidencia($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_providencia", $dados['id_providencia']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_PROVIDENCIA");
        return true;
    }

    public function excluirGestaoTratativa($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_gestao_tratativa", $dados['id_gestao_tratativa']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_GESTAO_TRATATIVAS");

        $this->db->where("id_gestao_tratativa", $dados['id_gestao_tratativa']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_PROVIDENCIA");

        $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $this->db->trans_commit();
                return true;
            }else {
                $this->db->trans_rollback();
                return false;
            }
        }


//--------------------------------------------------------------------------------------------------------------------
    public function NaoHouveAtividadedaq($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_gestao_tratativa", $dados['id']);
        $this->db->set('flag_atividade', 'S');
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_GESTAO_TRATATIVAS");

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }


public function editarGestao($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->where("id_gestao_tratativa", $dados["id_gestao_tratativa"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);

            if (!empty($dados["novaDataPactuada_edita"])) {
                $this->db->set("nova_data_pactuada", $dados["novaDataPactuada_edita"]);
            }
            if (!empty( $dados["dataTermino_edita"])) {
                $this->db->set("data_termino", $dados["dataTermino_edita"]);
            }

            if (!empty( $dados["status_edita"])) {
                $this->db->set("desc_status", $dados["status_edita"]);
            }
            
        $this->db->update("CGOB_TB_GESTAO_TRATATIVAS");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }



}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
