<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_art_supervisao extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


    //---------------------------------------------------------------------------------------

  public function populaUF() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_UF");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function insereART($dados) {
            date_default_timezone_set("America/Sao_Paulo");
            $this->db->set("id_contrato_obra", $dados["idContrato"]);
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);
 
            $this->db->set("nome_empresa", $dados["nome_empresa"]);
            $this->db->set("nome_profissional", $dados["nome_profissional"]);
            $this->db->set("email_art", $dados["email_art"]);
            $this->db->set("tel_art", $dados["tel_art"]);
            $this->db->set("num_crea", $dados["num_crea"]);
            $this->db->set("rnp_art", $dados["rnp_art"]);
            $this->db->set("num_art", $dados["num_art"]);
            $this->db->set("data_registro", $dados["data_registro"]);
            
            if ($dados['data_baixa'] != '1969-12-31') {
            $this->db->set("data_baixa", $dados["data_baixa"]);
            }
            //$this->db->set("data_baixa", $dados["data_baixa"]);
            $this->db->set("forma_registro", $dados["forma_registro"]);
            $this->db->set("participacao_tecnica", $dados["participacao_tecnica"]);
     

            if (!empty(  $dados["uf_registro"] )) {
                $this->db->set("id_codigo_uf",  $dados["uf_registro"] );
            }
            if (!empty($dados["id_arquivo"])) {
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
        }

        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_ART_SUPERVISAO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
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
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";

     
        if (!empty($dados["id_art_supervisao"])) {
            $SQL .= " AND l.id_art_supervisao = '" . $dados["id_art_supervisao"] . "' ";
        }
        
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        $SQL .= " ORDER BY l.ultima_alteracao DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


     public function  RecuperaEditaART($dados) {
        $SQL = "
          SELECT
            r.id_art_supervisao,
            r.nome_empresa,
            r.nome_profissional,
            r.email_art,
            r.tel_art,
            r.num_crea,
            r.rnp_art,
            r.num_art,
            r.participacao_tecnica,
            r.forma_registro,
            convert(varchar(10),r.data_registro,103) AS data_registro,
            convert(varchar(10),r.data_baixa,103) AS data_baixa,
            r.id_codigo_uf as estado
            FROM CGOB_TB_ART_SUPERVISAO AS r       
        WHERE r.id_art_supervisao ='". $dados["id_art_supervisao"]. "'";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


     public function editarART($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->where("id_art_supervisao", $dados["id_art_supervisao"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);

            if (!empty($dados["nome_empresa"])) {
                $this->db->set("nome_empresa", $dados["nome_empresa"]);
            }
            if (!empty( $dados["nome_profissional"])) {
                $this->db->set("nome_profissional", $dados["nome_profissional"]);
            }
            if (!empty( $dados["email_art"])) {
                $this->db->set("email_art", $dados["email_art"]);
            }
            if (!empty($dados["tel_art"])) {
                $this->db->set("tel_art", $dados["tel_art"]);
            }
            if (!empty( $dados["num_crea"])) {
                $this->db->set("num_crea", $dados["num_crea"]);
            }
            if (!empty( $dados["rnp_art"])) {
                $this->db->set("rnp_art", $dados["rnp_art"]);
            }
            if (!empty($dados["num_art"])) {
                $this->db->set("num_art", $dados["num_art"]);
            }
            if (!empty(  $dados["participacao_tecnica"] )) {
                $this->db->set("participacao_tecnica",  $dados["participacao_tecnica"]);
            }
            if (!empty(  $dados["forma_registro"] )) {
                $this->db->set("forma_registro",  $dados["forma_registro"] );
            }
            if (!empty(  $dados["data_registro"] )) {
                $this->db->set("data_registro",  $dados["data_registro"] );
            }
            if ($dados['data_baixa'] != '1969-12-31') {
            $this->db->set("data_baixa", $dados["data_baixa"]);
            }
            if (!empty($dados["id_codigo_uf"])) {
            $this->db->set("id_codigo_uf", $dados["id_codigo_uf"]);
            }
        
        $this->db->update("CGOB_TB_ART_SUPERVISAO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }



   public function excluirART($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_art_supervisao", $dados['id_art_supervisao']);
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_ART_SUPERVISAO");
        
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
//# Data: 01/11/2019 
//########################################################################################################################################################################################################################