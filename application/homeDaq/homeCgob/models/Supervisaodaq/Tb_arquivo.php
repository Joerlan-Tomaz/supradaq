<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_arquivo extends CI_Model {

public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


public function insereArquivo($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("nome_arquivo", $dados["nome_arquivo"]);
        if (!empty($dados["desc_arquivo"])) {
            $this->db->set("desc_arquivo", $dados["desc_arquivo"]);
            $this->db->set("tipo_arquivo", $dados["tipo_arquivo"]);
            $this->db->set("pasta_origem", $dados["pasta_origem"]);
            $this->db->set("id_upload", $dados["id_upload"]);
            $this->db->set("nomeOriginalArquivo", $dados["nomeOriginalArquivo"]);
        }
        if (!empty($dados["flag_atividade"])) {
            $this->db->set("flag_atividade", $dados["flag_atividade"]);
        }
        if (!empty($dados["num_documento"])) {
            $this->db->set("numero_doc", $dados["num_documento"]);
        }
        if (!empty($dados["data_ata"])) {
            $this->db->set("data_ata", $dados["data_ata"]);
        }
        if (!empty($dados["publicar"])) {
            $this->db->set("publicar", $dados["publicar"]);
        }
        if (!empty($dados["id_resumo"])) {
            $this->db->set("id_resumo", $dados["id_resumo"]);
        }
        if (!empty($dados["id_configoae"])) {
            $this->db->set("id_configoae", $dados["id_configoae"]);
        }
        if (!empty($dados["id_garantia_seguro"])) {
            $this->db->set("id_garantia_seguro", $dados["id_garantia_seguro"]);
        }
         if (!empty($dados["roteiro"])) {
            $this->db->set("roteiro", $dados["roteiro"]);
        }
        

        $this->db->set("data_insercao", date("Y-m-d H:i:s"));
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->set("publicar", "S");
        $this->db->insert("CGOB_TB_ARQUIVO");
        $this->id_arquivo = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

     public function recuperaArquivo($dados) {
        $SQL = "
          SELECT
            r.id_arquivo,
             concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome,
            r.nomeOriginalArquivo as arquivo,
            r.nome_arquivo,
            r.desc_arquivo
            FROM CGOB_TB_ARQUIVO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
        WHERE (r.publicar like '%S%')
        ";

        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        if (!empty($dados["roteiro"])) {
            $SQL .= " AND r.roteiro in(" . $dados["roteiro"] . ")";
        }
     
        if (!empty($dados["id_arquivo"])) {
            $SQL .= " AND r.id_arquivo = '" . $dados["id_arquivo"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }

      public function excluirArquivo($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_ARQUIVO");
        return true;
    }





}
// ---------------------------------------------------------------------------------------------------------------------------
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################