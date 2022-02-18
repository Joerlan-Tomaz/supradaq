<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_sicro_supervisora extends CI_Model {

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
            (SELECT top 1 id_sicro_supervisora FROM CGOB_TB_SICRO_RELACAO_SR 
            WHERE id_sicro = s.id_sicro AND id_contrato_obra = '". $dados["idContrato"] ."'
           ) as chek
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
            
            //$this->db->set("periodo_referencia", $dados["periodo"]);//codigo item e tipo
            $this->db->insert("CGOB_TB_SICRO_RELACAO_SR");
            
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

    public function RecuperaRelacaoMobilizacao_Supervisora($dados) {
        $SQL = "
          SELECT
            sr.id_sicro_supervisora as id_relacao_supervisora,
            sr.cod_sicro,
            sr.item,
            sr.tipo,
            scqtd.qtd_terceiro, 
            scqtd.qtd_proprio 
           
            FROM CGOB_TB_SICRO_RELACAO_SR AS sr 
            FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS scqtd ON scqtd.id_sicro_supervisora = sr.id_sicro_supervisora AND scqtd.publicar like '%S%' AND scqtd.periodo_referencia = '" . $dados["periodo"] . "'
           
        WHERE sr.item ='". $dados["item"]. "'

        AND sr.id_contrato_obra = " . $dados["idContrato"] . "


        ";


        $query = $this->db->query($SQL);
        return $query->result();
    }

        public function RecuperaMobilizacaoSupervisora($dados) {
        $SQL = "
          SELECT
            sr.id_sicro_quantidade_sr as id,
            s.cod_sicro,
            s.item,
            s.tipo,
            sr.qtd_proprio,
            sr.qtd_terceiro,
            concat( CONVERT(CHAR(10),sr.ultima_alteracao , 103),' ', CONVERT(CHAR(8),sr.ultima_alteracao , 114)) AS ultima_alteracao,
            u.DESC_NOME as nome
            FROM CGOB_TB_SICRO_RELACAO_SR AS s
            INNER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro_supervisora = sr.id_sicro_supervisora
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

///---------------------------------------------------------> atualiza o item se ja tiver no periodo, ou insere um novo com outro perido.

     public function GravaRelacao($dados) {
            date_default_timezone_set("America/Sao_Paulo");

            if ($this->db->where("id_sicro_supervisora", $dados["id_relacao_supervisora"])){
            $this->db->where("id_sicro_supervisora", $dados["id_relacao_supervisora"]);
            $this->db->where("periodo_referencia", $dados["periodo"]);
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);
            $this->db->set("id_contrato_obra", $dados["idContrato"]);
            $this->db->set("qtd_proprio",  $dados["qtd_proprio"] );
            $this->db->set("qtd_terceiro",  $dados["qtd_terceiro"] );
            $this->db->set("publicar", "S");
            $this->db->update("CGOB_TB_SICRO_QUANTIDADE_SR");
            }

            if ($this->db->affected_rows()==0) {
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);
            $this->db->set("id_contrato_obra", $dados["idContrato"]);
            $this->db->set("qtd_proprio",  $dados["qtd_proprio"] );
            $this->db->set("qtd_terceiro",  $dados["qtd_terceiro"] );
            $this->db->set("id_sicro_supervisora", $dados["id_relacao_supervisora"]);
            $this->db->set("publicar", "S");
            $this->db->set("periodo_referencia", $dados["periodo"]);
            $this->db->insert("CGOB_TB_SICRO_QUANTIDADE_SR");
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






    public function trashconstrutora($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_sicro_quantidade_sr", $dados['id']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_SICRO_QUANTIDADE_SR");
        return true;
    }







}//fecha model
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 04/02/2020 16:00
//########################################################################################################################################################################################################################