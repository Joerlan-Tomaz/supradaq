<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_portaria_fiscais extends CI_Model {

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
		$this->db->order_by("estado");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function populaTitularidade() {
        $this->db->select("*");
        //$this->db->where("publicar", "S");
        $this->db->from("CGOB_TB_TITULARIDADE");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

	public function inserePortariasFiscais($dados) {
	        date_default_timezone_set("America/Sao_Paulo");
	        $this->db->set("id_contrato_obra", $dados["idContrato"]);
	        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
	        $this->db->set("id_usuario", $dados["idUsuario"]);

	        if (!empty($dados["num_portaria"])) {
	            $this->db->set("num_portaria", $dados["num_portaria"]);
	        }
            if (!empty($dados["nome_fiscal"])) {
                $this->db->set("nome_fiscal", $dados["nome_fiscal"]);
            }
            if (!empty($dados["email"])) {
                $this->db->set("email", $dados["email"]);
            }
            if (!empty($dados["telefone"])) {
                $this->db->set("telefone", $dados["telefone"]);
            }
            if (!empty($dados["data_portaria"])) {
                $this->db->set("data_portaria", $dados["data_portaria"]);
            }
       
	        if (!empty(  $dados["unidade_local"] )) {
	            $this->db->set("id_uf",  $dados["unidade_local"] );
	        }
            if (!empty(  $dados["contrato_fiscalizado"] )) {
                $this->db->set("contrato_fiscalizado",  $dados["contrato_fiscalizado"] );
            }
            if (!empty(  $dados["titularidade"] )) {
                $this->db->set("id_titularidade",  $dados["titularidade"] );
            }
	        if (!empty($dados["id_arquivo"])) {
            $this->db->set("id_arquivo", $dados["id_arquivo"]);
       		}

	        $this->db->set("publicar", "S");
	        $this->db->set("periodo_referencia", $dados["periodo"]);
	        $this->db->insert("CGOB_TB_PORTARIA_FISCAIS");
	        $this->db->trans_complete();
	        if ($this->db->trans_status() === true) {
	            $this->db->trans_commit();
	            return $this->db->insert_id();
	        } else {
	            $this->db->trans_rollback();
	            return false;
	        }
	    }

	public function recuperaPortariasFiscais($dados) {
        $SQL = "
          SELECT
            l.id_portaria_fiscal,
            c.nu_con_formatado,
             CASE WHEN (c.nu_con_formatado_supervisor is null or c.nu_con_formatado_supervisor like '') THEN
                    '/' 
                    ELSE c.nu_con_formatado_supervisor
                END as numero_supervisora,
            l.nome_fiscal,
            l.email,
            l.telefone,
            s.titularidade,
            l.contrato_fiscalizado,
            uf.estado,
            convert(varchar(10),l.data_portaria,103) AS portaria,
            a.id_arquivo,
            a.nome_arquivo,
            a.nomeOriginalArquivo as arquivo,
            (select desc_nome from TB_USUARIO where id_usuario=l.id_usuario) as nome,
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao
            FROM CGOB_TB_PORTARIA_FISCAIS AS l
            INNER JOIN CGOB_TB_UF AS uf ON uf.id_uf = l.id_uf
            INNER JOIN CGOB_TB_TITULARIDADE AS s ON s.id_titularidade = l.id_titularidade
            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
            INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.id_contrato_obra = l.id_contrato_obra
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";

     
        if (!empty($dados["id_portaria_fiscal"])) {
            $SQL .= " AND l.id_portaria_fiscal = '" . $dados["id_portaria_fiscal"] . "' ";
        }
        
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $SQL .= " ORDER BY l.ultima_alteracao DESC";
        //echo('<pre>');
        //die($SQL);
        $query = $this->db->query($SQL);
        return $query->result();
    }





   public function excluirPortariasFiscais($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_portaria_fiscal", $dados['id_portaria_fiscal']);
        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_PORTARIA_FISCAIS");
        
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
