<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_sicro_construcao extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


	//---------------------------------------------------------------------------------------

	 public function Recupera_item_cadastro() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_SICRO_ITEM");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

        public function Recupera_relacao_item_cadastro($dados) {
        $SQL = "
          SELECT
            s.id_sicro,
            s.item,
            s.cod_sicro,
            s.tipo,
            s.unidade,
            (SELECT top 1 id_sicro_construcao FROM CGOB_TB_SICRO_RELACAO 
            WHERE id_sicro = s.id_sicro AND id_contrato_obra = '". $dados["idContrato"] ."'
           ) as chek,
           (SELECT top 1 id_usuario FROM CGOB_TB_SICRO_RELACAO 
            WHERE id_sicro = s.id_sicro AND id_contrato_obra = '". $dados["idContrato"] ."'
           ) as id_usuario,
           (SELECT top 1 ultima_alteracao FROM CGOB_TB_SICRO_RELACAO 
            WHERE id_sicro = s.id_sicro AND id_contrato_obra = '". $dados["idContrato"] ."'
           ) as ultima_alteracao
            FROM CGOB_TB_SICRO AS s
           
        WHERE s.item ='". $dados["itemcadastro"]. "'
        ";

     
        if (!empty($dados["id_sicro"])) {
            $SQL .= " AND s.id_sicro = '" . $dados["id_sicro"] . "' ";
        }

        if (!empty($dados["itemcadastro"])) {
            $SQL .= " AND s.item = '" . $dados["itemcadastro"] . "' ";
        }

        if (!empty($dados["sicro"])) {
            $SQL .= " AND s.cod_sicro LIKE '%". $dados["sicro"]. "%' ";
        }

        if (!empty($dados["tipo"])) {
            $SQL .= " AND s.tipo LIKE '%". $dados["tipo"]. "%'";
        }

        $SQL .= " ORDER BY s.item DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


     public function CadastrarItem($dados) {
            date_default_timezone_set("America/Sao_Paulo");
            $this->db->set("id_contrato_obra", $dados["idContrato"]);
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);
            $this->db->set("cod_sicro", $dados["cod_sicro"]);
            $this->db->set("item", $dados["item"]);
            $this->db->set("tipo", $dados["tipo"]);
          
              
            $this->db->set("id_sicro", $dados["id_sicro"]);
            
            //$this->db->set("periodo_referencia", $dados["periodo"]);
            $this->db->insert("CGOB_TB_SICRO_RELACAO");
            
            if ($this->db->trans_status() === true) {
                $this->db->trans_commit();
                $this->db->trans_complete();
                //return $this->db->insert_id();
                return true;
            } else {
                $this->db->trans_rollback();
                return false;
            }
        }


        public function item_sicro($dados) {
            $SQL ="
                SELECT 
                s.cod_sicro,
                s.item,
                s.tipo
                FROM CGOB_TB_SICRO as s
                WHERE id_sicro = ".$dados['id_sicro']
            ;
        
        $query = $this->db->query($SQL);
        return $query->result();
    }


//------------------------------------------Mobilização---------------------------------------------------------------

    public function RecuperaRelacaoMobilizacao_Construcao($dados) {
        $SQL = "
          SELECT
            sr.id_sicro_construcao as id_relacao_supervisora,
            sr.cod_sicro,
            sr.item,
            sr.tipo,
            scqtd.qtd_terceiro, 
            scqtd.qtd_proprio 
            FROM CGOB_TB_SICRO_RELACAO AS sr
            FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE AS scqtd ON scqtd.id_sicro_construcao = sr.id_sicro_construcao AND scqtd.publicar like '%S%' AND scqtd.periodo_referencia = '" . $dados["periodo"] . "'
           
        WHERE sr.item ='". $dados["item"]. "'

        AND sr.id_contrato_obra=" . $dados["idContrato"] . "

        
        ";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }

 public function RecuperaMobilizacaoConstrucao($dados) {
        $SQL = "
          SELECT
            sr.id_sicro_quantidade as id,
            sr.nome_infraestrutura,
            s.cod_sicro,
            s.item,
            s.tipo,
            sr.qtd_proprio,
            sr.qtd_terceiro,
            concat( CONVERT(CHAR(10),sr.ultima_alteracao , 103),' ', CONVERT(CHAR(8),sr.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_SICRO_RELACAO AS s
            INNER JOIN CGOB_TB_SICRO_QUANTIDADE AS sr ON s.id_sicro_construcao = sr.id_sicro_construcao
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = sr.id_usuario
           
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND sr.id_contrato_obra = " . $dados["idContrato"] . "
        ";

        if (!empty($dados["periodo"])) {
            $SQL .= " AND sr.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $SQL .= " ORDER BY s.item DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


    public function GravaRelacao($dados) {
            date_default_timezone_set("America/Sao_Paulo");
             if ($this->db->where("id_sicro_construcao", $dados["id_relacao_supervisora"])){
            $this->db->where("id_sicro_construcao", $dados["id_relacao_supervisora"]);
            $this->db->where("periodo_referencia", $dados["periodo"]);
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);
            $this->db->set("id_contrato_obra", $dados["idContrato"]);
            $this->db->set("qtd_proprio",  $dados["qtd_proprio"] );
            $this->db->set("qtd_terceiro",  $dados["qtd_terceiro"] );
            $this->db->set("publicar", "S");
            $this->db->set("periodo_referencia", $dados["periodo"]);
		    $this->db->set("nome_infraestrutura", $dados["nome_infraestrutura"]);
            $this->db->update("CGOB_TB_SICRO_QUANTIDADE");
            }

            if ($this->db->affected_rows()==0) {
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);
            $this->db->set("id_contrato_obra", $dados["idContrato"]);
            $this->db->set("qtd_proprio",  $dados["qtd_proprio"] );
            $this->db->set("qtd_terceiro",  $dados["qtd_terceiro"] );
            $this->db->set("id_sicro_construcao", $dados["id_relacao_supervisora"]);
            $this->db->set("publicar", "S");
            $this->db->set("periodo_referencia", $dados["periodo"]);
			$this->db->set("nome_infraestrutura", $dados["nome_infraestrutura"]);
            $this->db->insert("CGOB_TB_SICRO_QUANTIDADE");
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $this->db->trans_commit();
                return $this->db->insert_id();
            } else {
                $this->db->trans_rollback();
                return false;
            }
        }





        public function trashsupervisora($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_sicro_quantidade", $dados['id']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_SICRO_QUANTIDADE");
        return true;
    }

























}//fecha model
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 28/01/2020 16:00
//########################################################################################################################################################################################################################
