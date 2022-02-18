<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_ocorrencia_projeto extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

//----------------------------------------------------------------------------------


    public function detalhesOcorrenciaProjeto($dados) {
        $SQL = "            
            SELECT 
                nome
                ,estaca
                ,concat(coordenada_norte,'/',coordenada_leste) AS coordenadas
                ,CONCAT(CONVERT(CHAR(10), ultima_alteracao , 103),' ', CONVERT(CHAR(8), ultima_alteracao , 114)) as ultima_alteracao 
                ,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = geo.id_usuario) AS desc_nome
                ,km
                ,id_arquivo
                ,tipo
            FROM CGOB_TB_OCORRENCIA_PROJETO AS geo

            WHERE (publicar = 'S' OR publicar IS NULL)
            AND id_arquivo = " . $dados["id_arquivo"] . "
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function recuperaOcorrenciaProjeto($dados) {
        $SQL = "            
            SELECT  
                id_arquivo
                ,nome_arquivo
                ,CONCAT(CONVERT(CHAR(10), a.ultima_alteracao , 103),' ', CONVERT(CHAR(8), a.ultima_alteracao , 114)) as ultima_alteracao 
                ,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = a.id_usuario) AS desc_nome
                ,nomeOriginalArquivo
                ,(SELECT count(*) FROM CGOB_TB_OCORRENCIA_PROJETO WHERE id_contrato_obra = " . $dados["id_contrato"] . " AND (publicar = 'S' OR publicar IS NULL) AND id_arquivo = a.id_arquivo) AS total
            FROM CGOB_TB_ARQUIVO as a

            WHERE id_contrato_obra = " . $dados["id_contrato"] . " AND roteiro in ('21','OCORRENCIAPROJETO') AND (publicar = 'S' OR publicar IS NULL) 
            ";

             if (!empty($dados["periodo"])) {
                $SQL .= " AND a.periodo_referencia = '" . $dados["periodo"] . "' ";
            }
        $SQL .= " ORDER BY ultima_alteracao desc";
        
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function excluirOcorrenciaProjeto($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->where("id_arquivo", $dados["id_arquivo"]);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados["id_usuario"]);
        $this->db->update("CGOB_TB_OCORRENCIA_PROJETO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

 

    function insertVersao($dados, $dadosComplemento) {
        date_default_timezone_set('America/Sao_Paulo');
        for ($i = 0; $i < count($dados); $i++) {
            $dados[$i]["id_usuario"] = $dadosComplemento["id_usuario"];
            $dados[$i]["id_contrato_obra"] = $dadosComplemento["id_contrato_obra"];
            $dados[$i]["id_georreferenciamento_tipo"] = $dadosComplemento["id_georreferenciamento_tipo"];
            $dados[$i]["id_arquivo"] = $dadosComplemento["id_arquivo"];
            $dados[$i]["ultima_alteracao"] = date("Y-m-d H:i:s");
            $dados[$i]["publicar"] = "S";
        }
        return $dados;
    }
    
 
    
    public function inserirdados($dados) {
        ini_set('max_execution_time', 300); 
        set_time_limit(300);
        $this->db->insert_batch("CGOB_TB_OCORRENCIA_PROJETO", $dados);
        return true;
    }
    #----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
     public function RecuperaNomeEixo($dados) {
        $SQL = "            
            SELECT count (nome_eixo) conte                
            FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO AS geo

            WHERE (publicar = 'S' OR publicar IS NULL)
            AND nome_eixo = '" . $dados["nome_eixo"] . "'";
        $query = $this->db->query($SQL);
        return $query->result();
    }
}
