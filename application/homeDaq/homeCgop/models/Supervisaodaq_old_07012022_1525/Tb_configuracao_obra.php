<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_configuracao_obra extends CI_Model {

     public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

//----------------------------------------------------------------------------------
    //TB_RESUMO
    public function RecuperacaoConfiguracao($dados) {
        $SQL = "
            SELECT  
                c.id_contrato_obra,
                c.contrato,
                c.construtora,
                concat(c.uf,'/',c.br) AS ufbr,
                c.uf,
                c.br, 
                r.id_resumo,
                r.resumo,
                r.roteiro,
                r.periodo_referencia AS referencia,
                u.desc_nome AS nome,
                CONCAT(CONVERT(CHAR(10), r.ultima_alteracao , 103),' ', CONVERT(CHAR(8), r.ultima_alteracao , 114)) AS ultima_alteracao,
                t.descricao AS tipo
            FROM 
                tb_resumo AS r
                
            LEFT JOIN tb_tipo_texto AS t
            ON r.tipo = t.id_tipotexto

            LEFT JOIN tb_contrato_obra AS c
            ON r.id_contrato_obra = c.id_contrato_obra

            LEFT JOIN tb_usuario AS u
            ON r.id_usuario = u.id_usuario                

            WHERE  (r.publicar like '%S%'  or  r.publicar is NULL) ";

        if (!empty($dados["id_resumo"])) {
            $SQL .= " AND r.id_resumo = '" . $dados["id_resumo"] . "' ";
        } else {
            $SQL .= "AND c.id_contrato_obra=" . $dados["idContrato"] . "    
            AND r.roteiro in(" . $dados["roteiro"] . ") ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao desc";

        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function insereConfiguracao($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("resumo", $dados["resumo"]);
        $this->db->set("roteiro", $dados["roteiro"]);
        if (!empty($dados["tipo_texto_resumo"])) {
            $this->db->set("tipo", $dados["tipo_texto_resumo"]);
        }
        $this->db->set("publicar", "s");
        $this->db->insert("Tb_resumo");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
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
        $this->db->update("Tb_resumo");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    //TB_ARQUIVO
    public function RecuperaConfiguracaoArquivo($dados) {
        $SQL = "
            SELECT 
                aq.id_arquivo,
                aq.id_contrato_obra,
                aq.desc_arquivo,
                aq.nome_arquivo,
                aq.tipo_arquivo,
                aq.nomeOriginalArquivo,
                aq.flag_atividade,
                aq.km,
                aq.coord_utm_n,
                aq.coord_utm_e,
                aq.coord_utm_fuso,
                aq.hemisferio,
                CONCAT(CONVERT(CHAR(10), aq.ultima_alteracao , 103),' ', CONVERT(CHAR(8), aq.ultima_alteracao , 114)) as ultima_alteracao,
                u.DESC_NOME
            FROM TB_ARQUIVO AS aq

            LEFT JOIN TB_USUARIO AS u
            ON u.id_usuario = aq.id_usuario
            
            WHERE aq.roteiro in(" . $dados["roteiro"] . ")
            AND aq.id_contrato_obra = " . $dados["idContrato"] . "
            AND (aq.publicar like '%S%' or aq.publicar is NULL) ";
        $SQL .= "ORDER BY aq.ultima_alteracao desc";

        $query = $this->db->query($SQL);
        return $query->result();
    }
     public function RecuperaConfiguracaoArquivoDiagrama($dados) {
        $SQL = "
            SELECT 
                aq.id_arquivo,
                aq.id_contrato_obra,
                aq.desc_arquivo,
                aq.nome_arquivo,
                aq.tipo_arquivo,
                aq.nomeOriginalArquivo,
                aq.flag_atividade,
                aq.km,
                aq.coord_utm_n,
                aq.coord_utm_e,
                aq.coord_utm_fuso,
                aq.hemisferio,
                CONCAT(CONVERT(CHAR(10), aq.ultima_alteracao , 103),' ', CONVERT(CHAR(8), aq.ultima_alteracao , 114)) as ultima_alteracao,
                (select DESC_NOME from TB_USUARIO where id_usuario=aq.id_usuario) DESC_NOME
            FROM TB_ARQUIVO AS aq
            
            WHERE aq.roteiro in('51','Diagrama_Ocorrencia')
            AND aq.id_contrato_obra = " . $dados["idContrato"] . "
            AND (aq.publicar like '%S%' or aq.publicar is NULL) ";
       
        //echo('<pre>');
        //die($SQL);
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function insereConfiguracaoImagem($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados['id_usuario']);
        $this->db->set("tipo_arquivo", $dados['tipo_arquivo']);
        $this->db->set("pasta_origem", $dados['pasta_origem']);
//        $this->db->set("data_foto", $dados['data_foto']);       
        $this->db->set("nome_arquivo", $dados['nome_arquivo']);
        $this->db->set("nomeOriginalArquivo", $dados['nomeOriginalArquivo']);
        $this->db->set("roteiro", $dados['roteiro']);
        $this->db->set("publicar", "s");
        $this->db->set("data_insercao", date("Y-m-d H:i:s"));
        $this->db->insert("TB_ARQUIVO");
        return true;
    }

    public function insereConfiguracao_Arquivo($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados['id_usuario']);
        $this->db->set("tipo_arquivo", $dados['tipo_arquivo']);
        $this->db->set("pasta_origem", $dados['pasta_origem']);
        $this->db->set("nome_arquivo", $dados['nome_arquivo']);
        $this->db->set("desc_arquivo", $dados["desc_arquivo"]);
        $this->db->set("id_upload", $dados["id_upload"]);
        $this->db->set("nomeOriginalArquivo", $dados['nomeOriginalArquivo']);
        $this->db->set("roteiro", $dados['roteiro']);
        $this->db->set("publicar", "N");
        $this->db->set("data_insercao", date("Y-m-d H:i:s"));
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_ARQUIVO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function insereConfiguracao_Arquivoupdate($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "S");
        $this->db->set("data_insercao", date("Y-m-d H:i:s"));
        $this->db->update("CGOB_TB_ARQUIVO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    //
    public function maxID_Arquivo($dados) {
        $this->db->select("*");
        $this->db->limit("1");
        $this->db->from("CGOB_TB_ARQUIVO");
        $this->db->where("roteiro", $dados["roteiro"]);
        $this->db->where("id_contrato_obra", $dados["id_contrato_obra"]);
        $this->db->order_by("id_arquivo desc");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function populaTipoEixo() {
        $this->db->select("*");
        $this->db->from("TB_TIPO_EIXO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

}
