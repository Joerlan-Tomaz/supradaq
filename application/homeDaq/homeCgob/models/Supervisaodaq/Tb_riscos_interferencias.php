<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_riscos_interferencias extends CI_Model {

public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

	//---------------------------------------------------------------------------------------

    public function popula_TipoInterferencia() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_RISCOS_ITEM_TIPO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }


    public function recuperaClassificacao() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_RISCOS_ITEM_CLASSIFICACAO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

     public function recuperaGrauImpacto() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_RISCOS_ITEM_GRAU_IMPACTO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }


    public function populaTipoEixo() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        //$this->db->from("CGOB_TB_RISCOS_ITEM_EIXO");
        $this->db->from("CGOB_TB_CONFIG_ITEM_EIXO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

//-------------------------------------------------------------------------------------------------------------------
   
    public function insereNaoAtividadeRiscos($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->set('id_contrato_obra', $dados['idContrato']);
        $this->db->set('periodo_referencia', $dados['periodo']);
        $this->db->set('publicar', 'S');
        $this->db->set('flag_atividade', 'N');
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set('id_usuario', $dados['idUsuario']);

        $this->db->insert("CGOB_TB_RISCOS_INTERFERENCIAS");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------------------
    public function insereInterferencia($dados) {
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);
             
            if (!empty( $dados["assunto"])) {
                $this->db->set("assunto",  $dados["assunto"]);
            }
            if (!empty( $dados["km_inicial"])) {
                $this->db->set("km_inicial",  $dados["km_inicial"]);
            }
            if (!empty( $dados["km_final"])) {
                $this->db->set("km_final",  $dados["km_final"]);
            }
           
	        if (!empty( $dados["previsao_solucao"])) {
	            $this->db->set("previsao_solucao",  $dados["previsao_solucao"]);
	        }
            if (!empty( $dados["data_limite"])) {
                $this->db->set("data_limite",  $dados["data_limite"]);
            }
	       
	        if (!empty(  $dados["tipoInterferencia"] )) {
	            $this->db->set("id_tipo_interferencia",  $dados["tipoInterferencia"] );
	        }
	        if (!empty(  $dados["classificacao"] )) {
	            $this->db->set("id_classificacao",  $dados["classificacao"] );
	        }
            if (!empty(  $dados["grauImpacto"] )) {
                $this->db->set("id_grau_impacto",  $dados["grauImpacto"] );
            }
            if (!empty(  $dados["tipoEixo"] )) {
                $this->db->set("id_tipo_eixo",  $dados["tipoEixo"] );
            }

            if (!empty(  $dados["efeito"] )) {
                $this->db->set("efeito_interferencia",  $dados["efeito"] );
            }
            if (!empty(  $dados["br"] )) {
                $this->db->set("br",  $dados["br"] );
            }

            $this->db->set("impacto_custo",  $dados["impactoCusto"] );
            $this->db->set("impacto_prazo",  $dados["impactoPrazo"] );
        
            if (!empty( $dados["resumo"])) {
                $this->db->set("resumo",  $dados["resumo"]);
            }

             if (!empty( $dados["providencia"])) {
                $this->db->set("providencia",  $dados["providencia"]);
            }
        
	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_RISCOS_INTERFERENCIAS");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	    }

//------------------------------------------------------------------------------------------------------------------------

	   public function recuperaInterferencia($dados) {
        $SQL = "
          SELECT
            r.id_riscos_interferencias,
            convert(varchar(10),r.previsao_solucao,103) AS previsao_solucao,
            convert(varchar(10),r.data_limite,103) AS data_limite,
            r.km_inicial,
            r.km_final,
            r.br,
            t.desc_tipo,
            i.desc_grau_impacto,
            c.desc_classificacao,
            e.desc_tipo_eixo,
            r.resumo,
            r.providencia,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_RISCOS_INTERFERENCIAS AS r
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = r.id_usuario
            INNER JOIN CGOB_TB_RISCOS_ITEM_TIPO AS t ON t.id_tipo_interferencia = r.id_tipo_interferencia
            INNER JOIN CGOB_TB_RISCOS_ITEM_GRAU_IMPACTO AS i ON i.id_grau_impacto = r.id_grau_impacto
            INNER JOIN CGOB_TB_RISCOS_ITEM_CLASSIFICACAO AS c ON c.id_classificacao = r.id_classificacao
            INNER JOIN CGOB_TB_RISCOS_ITEM_EIXO AS e ON e.id_tipo_eixo = r.id_tipo_eixo
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

     
        if (!empty($dados["id_riscos_interferencias"])) {
            $SQL .= " AND r.id_riscos_interferencias = '" . $dados["id_riscos_interferencias"] . "' ";
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


     public function descricaoInterferencia($dados) {
        $SQL = "
          SELECT
            r.id_riscos_interferencias,
            r.resumo,
            r.providencia
            FROM CGOB_TB_RISCOS_INTERFERENCIAS AS r
        WHERE r.id_riscos_interferencias ='". $dados["id_riscos_interferencias"]. "'";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }
//---------------------------------------------------------------------------------------------------

 public function  RecuperaInterferenciaEditar($dados) {
        $SQL = "
          SELECT
            r.id_riscos_interferencias,
            r.assunto,
            convert(varchar(10),r.previsao_solucao,103) AS previsao_solucao,
            convert(varchar(10),r.data_limite,103) AS data_limite,
            r.km_inicial,
            r.km_final,
            r.resumo,
            r.providencia,
            t.id_tipo_interferencia,
            i.id_grau_impacto,
            c.id_classificacao,
            e.id_tipo_eixo,
            r.br,
            r.efeito_interferencia,
            r.impacto_custo,
            r.impacto_prazo
            FROM CGOB_TB_RISCOS_INTERFERENCIAS AS r
            INNER JOIN CGOB_TB_RISCOS_ITEM_TIPO AS t ON t.id_tipo_interferencia = r.id_tipo_interferencia
            INNER JOIN CGOB_TB_RISCOS_ITEM_GRAU_IMPACTO AS i ON i.id_grau_impacto = r.id_grau_impacto
            INNER JOIN CGOB_TB_RISCOS_ITEM_CLASSIFICACAO AS c ON c.id_classificacao = r.id_classificacao
            INNER JOIN CGOB_TB_RISCOS_ITEM_EIXO AS e ON e.id_tipo_eixo = r.id_tipo_eixo
            
            
        WHERE r.id_riscos_interferencias ='". $dados["id_riscos_interferencias"]. "'";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }
//----------------------------------------------------------------------------------------------------------------------
    public function recuperaRiscosAtividade($dados){
        $SQL = "
        SELECT
        id_riscos_interferencias as id 
        ,CASE WHEN flag_atividade = 'N' THEN 'Não houve atividade no mês' END atividademes
        ,CONCAT(CONVERT(CHAR(10), ultima_alteracao , 103),' ', CONVERT(CHAR(8), ultima_alteracao , 114)) AS ultima_alteracao
        ,(SELECT DESC_NOME FROM TB_USUARIO WHERE id_usuario = af.id_usuario) AS nome
        FROM CGOB_TB_RISCOS_INTERFERENCIAS AS af
        WHERE publicar = 'S' AND flag_atividade = 'N'AND id_contrato_obra =" . $dados["idContrato"] ." AND periodo_referencia ='" .$dados["periodo"] ."'          
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//----------------------------------------------------------------------------------------------------------------------
     public function editarInterferencia($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->where("id_riscos_interferencias", $dados["id_riscos_interferencias"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);

           
        $this->db->set("assunto", $dados["assunto"]);
          
        $this->db->set("km_inicial", $dados["km_inicial"]);
        
        $this->db->set("km_final", $dados["km_final"]);
        
        $this->db->set("resumo", $dados["resumo"]);
           
        $this->db->set("providencia", $dados["providencia"]);
          
        $this->db->set("br", $dados["br"]);
           
        $this->db->set("efeito_interferencia", $dados["efeito_interferencia"]);
            
        $this->db->set("impacto_custo",  $dados["impacto_custo"]);
            
        $this->db->set("impacto_prazo",  $dados["impacto_prazo"] );
            
            if (!empty(  $dados["tipoInterferenciaEditar"] )) {
                $this->db->set("id_tipo_interferencia",  $dados["tipoInterferenciaEditar"] );
            }
             if (!empty(  $dados["classificacaoEditar"] )) {
                $this->db->set("id_classificacao",  $dados["classificacaoEditar"] );
            }
             if (!empty(  $dados["grauImpactoEditar"] )) {
                $this->db->set("id_grau_impacto",  $dados["grauImpactoEditar"] );
            }
             if (!empty(  $dados["tipoEixoEditar"] )) {
                $this->db->set("id_tipo_eixo",  $dados["tipoEixoEditar"] );
            }
            
        
        $this->db->update("CGOB_TB_RISCOS_INTERFERENCIAS");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

//-----------------------------------------------------------------------------------------------------------

        public function excluirInterferencia($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_riscos_interferencias", $dados['id_riscos_interferencias']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_RISCOS_INTERFERENCIAS");
        return true;
    }

//-------------------------------------------------------------------------------------------------------------------
    
    public function NaoHouveAtividadedaq($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_riscos_interferencias", $dados['id']);
        $this->db->set('flag_atividade', 'S');
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_RISCOS_INTERFERENCIAS");

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