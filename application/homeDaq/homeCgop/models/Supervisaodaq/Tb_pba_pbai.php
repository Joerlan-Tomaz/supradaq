<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_pba_pbai extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


	//---------------------------------------------------------------------------------------

    public function populaPba() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_PBA");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function populaPbai() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_PBAI");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    //---------------------------------------------------------------------------------------

    public function inserePbaPbai($dados) {
	        date_default_timezone_set("America/Sao_Paulo");

	        if(isset($dados["id_pba_pbai"]) && isset($dados["idContrato"])){
				$this->db->where("id_pba_pbai", $dados["id_pba_pbai"]);
				$this->db->where("id_contrato_obra", $dados["idContrato"]);
			}
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);

	        if (!empty($dados["descricao"])) {
	            $this->db->set("descricao", $dados["descricao"]);
	        }
	        if (!empty(  $dados["tipo"])) {
	            $this->db->set("tipo",  $dados["tipo"] );
	        }
	        if (!empty(  $dados["nome_infraestrutura"])) {
	            $this->db->set("nome_infraestrutura",  $dados["nome_infraestrutura"] );
	        }
	        if (!empty(  $dados["status"])) {
	            $this->db->set("status",  $dados["status"] );
	        }
	        if (!empty($dados["id_arquivo"])) {
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
       		}

	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
			if(isset($dados["id_pba_pbai"]) && isset($dados["idContrato"])){
				$this->db->where("id_pba_pbai", $dados["id_pba_pbai"]);
				$this->db->where("id_contrato_obra", $dados["idContrato"]);
	        	$this->db->update("CGOB_TB_PBA_PBAI");
			}else{
	        	$this->db->insert("CGOB_TB_PBA_PBAI");
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

    public function alteraPbaPbai($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->where("id_pba_pbai", $dados["id_pba_pbai"]);
        $this->db->where("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);

		if (!empty($dados["descricao"])) {
			$this->db->set("descricao", $dados["descricao"]);
		}
		if (!empty(  $dados["tipo"])) {
			$this->db->set("tipo",  $dados["tipo"] );
		}
		if (!empty(  $dados["status"])) {
			$this->db->set("status",  $dados["status"] );
		}
		if (!empty($dados["id_arquivo"])) {
			$this->db->set("id_arquivo", $dados["id_arquivo"]);
		}

        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);

        $this->db->update("CGOB_TB_PBA_PBAI");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//---------------------------------------------------------------------------------------

    public function recuperaPbaPbai($dados) {
        $SQL = "
          SELECT
            r.nome_infraestrutura,
            r.id_pba_pbai,
            r.tipo,
            r.status,
            r.descricao,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS ultima_alteracao,
            q.nome_arquivo,
            q.id_arquivo,
           convert(varchar(10),r.periodo_referencia,103) AS referencia,
            q.nomeOriginalArquivo as arquivo,
            (select desc_nome from TB_USUARIO where id_usuario=r.id_usuario) as nome
            FROM CGOB_TB_PBA_PBAI AS r
            LEFT JOIN CGOB_TB_ARQUIVO AS q ON q.id_arquivo = r.id_arquivo
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["id_pba_pbai"])) {
            $SQL .= " AND r.id_pba_pbai = '" . $dados["id_pba_pbai"] . "' ";
        }
        
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//---------------------------------------------------------------------------------------

    public function Recupera_editarPbaPbai($dados) {
         $SQL = "
                  SELECT
                    r.id_pba_pbai,
                    r.desc_pba_pbai
                    -- s.id_pbai
                    FROM CGOB_TB_PBA_PBAI AS r
                    -- INNER JOIN CGOB_TB_PBA AS s ON s.id_pba = r.id_pbai
                    
                WHERE r.id_pba_pbai ='". $dados["id_pba_pbai"]. "'";
               
                $query = $this->db->query($SQL);
                return $query->result();
    }
//---------------------------------------------------------------------------------------

   
  public function excluirPbaPbai($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_pba_pbai", $dados['id_pba_pbai']);
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_PBA_PBAI");
        
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
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
