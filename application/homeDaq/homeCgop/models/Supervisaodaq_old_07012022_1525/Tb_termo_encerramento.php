<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_termo_encerramento extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

	    public function insereTermoEncerramento($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);

        if (!empty($dados["relatorio_supervisao"])) {
            $this->db->set("relatorio_supervisao", $dados["relatorio_supervisao"]);
        }
        if (!empty($dados["numero_paginas"])) {
            $this->db->set("numero_paginas", $dados["numero_paginas"]);
        }
        if (!empty($dados["local"])) {
            $this->db->set("local", $dados["local"]);
        }
        if (!empty( $dados["inicio"])) {
	            $this->db->set("inicio", $dados["inicio"]);
	    }
	    if (!empty( $dados["termino"])) {
	            $this->db->set("termino", $dados["termino"]);
	    }

          if (!empty( $dados["texto"])) {
                $this->db->set("texto_encerramento", $dados["texto"]);
        }
      
        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_TERMO_ENCERRAMENTO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

		public function RecuperaTermoEncerramento($dados){
        $SQL = "
        SELECT
            r.id_termo,
            r.texto_encerramento,
            u.DESC_NOME as nome,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao
            FROM CGOB_TB_TERMO_ENCERRAMENTO AS r
            INNER JOIN TB_USUARIO as u on u.id_usuario = r.id_usuario
            WHERE (r.publicar like '%S%' or r.publicar is NULL) AND r.id_contrato_obra = '" . $dados["idContrato"] . "' AND r.periodo_referencia = '" . $dados["periodo"] . "' 
       
        ";
       
        $SQL .= " ORDER BY r.ultima_alteracao DESC";

        $query = $this->db->query($SQL);
        return $query->result();
    }


        public function RecuperaTextoPadrao($dados){
        $SQL = "
        SELECT
            ds_objeto,
            nu_con_formatado
            FROM CGOB_TB_CONTRATO_OBRA 
            WHERE  id_contrato_obra = '" . $dados["idContrato"] . "' 
        ";
    
        $query = $this->db->query($SQL);
        return $query->result();
    }




      public function excluirTermoEncerramento($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_termo", $dados['id_termo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_TERMO_ENCERRAMENTO");
        return true;
    }

}
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
