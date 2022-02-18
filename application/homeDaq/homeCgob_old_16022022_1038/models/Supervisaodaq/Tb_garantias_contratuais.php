<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_garantias_contratuais extends CI_Model {


public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

	//---------------------------------------------------------------------------------------

    public function populaTipoGarantia() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_TIPO_GARANTIA");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function insereGarantiaSeguro($dados) {
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);

            if (date("Y-m-d") > ($dados["termino_vigencia"])){
                $this->db->set("situacao", 'Não Vigente');
            }else{
                $this->db->set("situacao", 'Vigente');
            }

            if (!empty($dados["num_guia"])) {
                $this->db->set("num_guia", $dados["num_guia"]);
            }
            if (!empty(  $dados["tipo_garantia"] )) {
                $this->db->set("id_tipo_garantia",  $dados["tipo_garantia"] );
            }
            if (!empty($dados["processo"])) {
                $this->db->set("processo", $dados["processo"]);
            }
            if (!empty($dados["valor_garantia"])) {
                $this->db->set("valor_garantia", $dados["valor_garantia"]);
            }
	        
            if (!empty( $dados["inicio_vigencia"])) {
	            $this->db->set("inicio_vigencia",  $dados["inicio_vigencia"]);
	        }
            if (!empty( $dados["termino_vigencia"])) {
                $this->db->set("termino_vigencia",  $dados["termino_vigencia"]);
            }
            if (!empty( $dados["data_emissao"])) {
                $this->db->set("data_emissao",  $dados["data_emissao"]);
            }

            if (!empty($dados["instituicao"])) {
                $this->db->set("instituicao", $dados["instituicao"]);
            }
            if (!empty($dados["num_apolice"])) {
                $this->db->set("num_apolice", $dados["num_apolice"]);
            }
            if (!empty($dados["desc_objeto"])) {
                $this->db->set("desc_objeto", $dados["desc_objeto"]);
            }
            if (!empty($dados["desc_observacao"])) {
                $this->db->set("desc_observacao", $dados["desc_observacao"]);
            }
	    
	     
	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_GARANTIAS_SEGUROS");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	    }



	   public function recuperaGarantiaSeguro($dados) {
        $SQL = "
          SELECT
            r.id_garantia_seguro,
            r.num_guia ,
            g.desc_tipo_garantia,
            r.processo ,
            r.situacao,
            r.valor_garantia,
            convert(varchar(10),r.inicio_vigencia,103) AS inicio_vigencia,
            convert(varchar(10),r.termino_vigencia,103) AS termino_vigencia,
            convert(varchar(10),r.data_emissao,103) AS data_emissao,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome,
            (SELECT top 1 situacao FROM CGOB_TB_PROVIDENCIA_GARANTIAS WHERE id_garantia_seguro = r.id_garantia_seguro and situacao ='fechado' and publicar like '%S%') as st
            FROM CGOB_TB_GARANTIAS_SEGUROS AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            INNER JOIN CGOB_TB_TIPO_GARANTIA AS g ON g.id_tipo_garantia = r.id_tipo_garantia
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

     
        if (!empty($dados["id_garantia_seguro"])) {
            $SQL .= " AND r.id_garantia_seguro = '" . $dados["id_garantia_seguro"] . "' ";
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



     public function recuperaObservacaoObjeto($dados) {
        $SQL = "
          SELECT
            r.id_garantia_seguro,
            r.desc_objeto,
            r.desc_observacao
            FROM CGOB_TB_GARANTIAS_SEGUROS AS r
        WHERE r.id_garantia_seguro ='". $dados["id_garantia_seguro"]. "'";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


        public function insereProvidencia($dados) {
            date_default_timezone_set("America/Sao_Paulo");
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);

            if (!empty(  $dados["providencia_garantia"] )) {
                $this->db->set("providencia_garantia",  $dados["providencia_garantia"] );
            }
            if (!empty(  $dados["situacao"] )) {
                $this->db->set("situacao",  $dados["situacao"] );
            }
              if (!empty($dados["id_garantia_seguro"])) {
            $this->db->set("id_garantia_seguro", $dados["id_garantia_seguro"]);
            }
            $this->db->set("publicar", "S");
            $this->db->set("periodo_referencia", $dados["periodo"]);
            $this->db->insert("CGOB_TB_PROVIDENCIA_GARANTIAS");
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
                r.id_providencia_garantia,
                r.providencia_garantia as providencia,
                r.situacao as st,
                concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
                u.DESC_NOME as nome
                FROM CGOB_TB_PROVIDENCIA_GARANTIAS AS r
                INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
                WHERE (r.publicar like '%S%' or r.publicar is NULL)
            ";

            if (!empty($dados["id_garantia_seguro"])) {
                $SQL .= " AND r.id_garantia_seguro = '" . $dados["id_garantia_seguro"] . "' ";
            }

           
            $query = $this->db->query($SQL);
            return $query->result();
        }

        public function excluirGarantiaSeguro($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        
        $this->db->where("id_garantia_seguro", $dados['id_garantia_seguro']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_GARANTIAS_SEGUROS");

        $this->db->where("id_garantia_seguro", $dados['id_garantia_seguro']);
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

        public function insereAnexo($dados) {
            date_default_timezone_set("America/Sao_Paulo");
            $this->db->where("id_garantia_seguro", $dados['id_garantia_seguro']);
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
        
            $this->db->update("CGOB_TB_GARANTIAS_SEGUROS"); 
            return true;
        }


        public function recuperaAnexos($dados) {
        $SQL = "
          SELECT
            r.id_arquivo,
            r.nome_arquivo,
            r.nomeOriginalArquivo as arquivo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS atualizacao,
            u.DESC_NOME as nome
            FROM CGOB_TB_ARQUIVO AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["id_garantia_seguro"])) {
            $SQL .= " AND r.id_garantia_seguro = '" . $dados["id_garantia_seguro"] . "' ";
        }
                if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

       
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
        public function excluirProvidencia($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_providencia_garantia", $dados['id_providencia']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_PROVIDENCIA_GARANTIAS");
        return true;
    }









}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################