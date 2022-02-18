<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_configuracao_georreferenciamento extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

//----------------------------------------------------------------------------------

    // public function insereTipoEixo($dados) {
    //     $this->db->set("id_tipo", $dados['config_geo_eixo']);
    //     $this->db->set("nome", $dados['config_geo_nome']);
    //     $this->db->set("lado", $dados['config_geo_lado']);
    //     $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
    //     $this->db->set("id_usuario", $dados['id_usuario']);
    //     $this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
    //     $this->db->set("roteiro", $dados['roteiro']);
    //     $this->db->insert("TB_CONFIG_GERREFERENCIAMENTO_TIPO");
    //     return true;
    // }

     public function populaTipoeixo() {
        $this->db->select("*");
        $this->db->from("CGOB_TB_CONFIG_ITEM_EIXO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }


    public function maxID_Tipoeixo($dados) {
        $this->db->select("*");
        $this->db->limit("1");
        $this->db->from("TB_CONFIG_GERREFERENCIAMENTO_TIPO");
        $this->db->where("id_contrato_obra", $dados["id_contrato_obra"]);
        $this->db->where("roteiro", $dados['roteiro']);
        $this->db->order_by("id_georreferenciamento_tipo desc");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function recuperaDetalhesGeorreferenciamento($dados) {
        $SQL = "            
            SELECT 
                nome_eixo
                ,estaca
                ,concat(coordenada_norte,'/',coordenada_leste) AS coordenadas
                ,CONCAT(CONVERT(CHAR(10), ultima_alteracao , 103),' ', CONVERT(CHAR(8), ultima_alteracao , 114)) as ultima_alteracao 
                ,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = geo.id_usuario) AS desc_nome
                ,km
                ,id_arquivo
                ,fuso
            FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO AS geo
            WHERE (publicar = 'S' OR publicar IS NULL)
            AND id_arquivo = " . $dados["id_arquivo"] . "
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function recuperaGeorreferencimento($dados) {
        $SQL = "            
            SELECT
            id_contrato_obra
                ,id_arquivo
                ,nome_arquivo
                ,CONCAT(CONVERT(CHAR(10), a.ultima_alteracao , 103),' ', CONVERT(CHAR(8), a.ultima_alteracao , 114)) as ultima_alteracao 
                ,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = a.id_usuario) AS desc_nome
                ,nomeOriginalArquivo
                ,(SELECT count(*) FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO WHERE id_contrato_obra = " . $dados["id_contrato"] . " AND (publicar = 'S' OR publicar IS NULL) AND id_arquivo = a.id_arquivo) AS total
                ,(SELECT geo.nome_eixo FROM CGOB_TB_CONFIG_GEORREFERENCIAMENTO as geo WHERE geo.id_contrato_obra = " . $dados["id_contrato"] . " AND (geo.publicar = 'S' OR geo.publicar IS NULL) AND geo.id_arquivo = a.id_arquivo GROUP BY geo.nome_eixo) AS nome
                ,case when (select desc_status from CGOB_TB_STATUS_OPERACAO where id_status_operacao=a.id_status_operacao) is NULL then '--' else (select desc_status from CGOB_TB_STATUS_OPERACAO where id_status_operacao=a.id_status_operacao) end status_operacao
                ,case when (select desc_status from CGOB_TB_STATUS_OPERACAO where id_status_operacao=a.id_status_fabrica_gelo) is NULL then '--' else (select desc_status from CGOB_TB_STATUS_OPERACAO where id_status_operacao=a.id_status_fabrica_gelo) end status_fabrica_gelo
		,case when (select desc_tipo from [CGOB_TB_OBRA_TIPO_ESTRUTURA_NAVAL] where id_tipo=a.id_tipo) is NULL then '--' else (select desc_tipo from [CGOB_TB_OBRA_TIPO_ESTRUTURA_NAVAL] where id_tipo=a.id_tipo) end desc_tipo
                ,id_tipo
            FROM CGOB_TB_ARQUIVO as a

            WHERE id_contrato_obra = " . $dados["id_contrato"] . " AND roteiro in ('17','GEORREFERENCIAMENTO') AND (publicar = 'S' OR publicar IS NULL)
            ";

             if (!empty($dados["periodo"])) {
            $SQL .= " AND a.periodo_referencia = '" . $dados["periodo"] . "' ";
        }
        $SQL .= " ORDER BY ultima_alteracao desc";
        //echo('<pre>');
        //die($SQL);
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function excluirGeorreferencimento($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->where("id_arquivo", $dados["id_arquivo"]);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados["id_usuario"]);
        $this->db->update("CGOB_TB_CONFIG_GEORREFERENCIAMENTO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function gravarDadosGeorreferenciamento($dados, $dadosComplemento) {

        $dados = $this->insertVersao($dados, $dadosComplemento);
        $this->db->insert_batch("TB_CONFIG_GEOREFERENCIAMENTO", $dados);

        $this->db->trans_complete();
        //check if transaction status TRUE or FALSE
        if ($this->db->trans_status() === FALSE) {
            //if something went wrong, rollback everything
            $this->db->trans_rollback();
            return FALSE;
        } else {
            //if everything went right, commit the data to the database
            $this->db->trans_commit();
            return TRUE;
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
    
     public function inserirdadosOLD($dados) {
        ini_set('max_execution_time', 300); 
        set_time_limit(300);
        $this->db->set("estaca", $dados['estaca']);
        $this->db->set("fracao_estaca", $dados['fracao_estaca']);
        $this->db->set("km", $dados['km']);
        $this->db->set("coordenada_norte", $dados['latitude']);
        $this->db->set("coordenada_leste", $dados['longitude']);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados['id_usuario']);
        $this->db->set("id_contrato_obra", $dados['id_contrato_obra']);
        $this->db->insert("TB_CONFIG_GEOREFERENCIAMENTO");
        return true;
    }
    
    public function inserirdados($dados) {
        ini_set('max_execution_time', 300); 
        set_time_limit(300);
        $this->db->insert_batch("CGOB_TB_CONFIG_GEORREFERENCIAMENTO", $dados);
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
