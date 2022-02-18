<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_dados_segmento extends CI_Model {

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
            r.km_inicial,
            r.km_final,
            r.km_inicialS,
            r.km_finalS,
            r.uf,
            r.trecho,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_DADOS_SEGMENTO AS r
            INNER JOIN TB_USUARIO as u on u.id_usuario = r.id_usuario
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

    public function insereResumo($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        

        
            $this->db->set("km_inicial", $dados["km_inicial"]);
         
            $this->db->set("km_final", $dados["km_final"]);

            $this->db->set("km_inicialS", $dados["km_inicialS"]);
         
            $this->db->set("km_finalS", $dados["km_finalS"]);
        
            $this->db->set("uf", $dados["uf"]);
         
            $this->db->set("trecho", $dados["trecho"]);
        

        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_DADOS_SEGMENTO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    // public function alteraResumo($dados) {
    //     date_default_timezone_set("America/Sao_Paulo");
    //     $this->db->where("id_resumo", $dados["id_resumo"]);
    //     $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
    //     $this->db->set("id_usuario", $dados["idUsuario"]);
    //     $this->db->set("resumo", $dados["resumo"]);
    //     $this->db->update("Cgob_Tb_resumo");
    //     $this->db->trans_complete();
    //     if ($this->db->trans_status() === true) {
    //         $this->db->trans_commit();
    //         return true;
    //     } else {
    //         $this->db->trans_rollback();
    //         return false;
    //     }
    // }

  public function modalStatus($dados) {
        $SQL = "
          SELECT
            r.id_resumo,
            r.trecho
            FROM CGOB_TB_DADOS_SEGMENTO AS r
        WHERE r.id_resumo ='". $dados["id_resumo"]. "'";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function excluirResumo($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_resumo", $dados['id_resumo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_DADOS_SEGMENTO");
        return true;
    }
}
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
