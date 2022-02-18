<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Msg_resposta extends CI_Model{

    public function insereResposta($dados) {
        date_default_timezone_set('America/Sao_Paulo');

        $this->db->set("id_mensagem", $dados['id_mensagem']);        
        $this->db->set("resposta", $dados['resposta']);
        $this->db->set("id_usuario", $dados['id_usuario']);
        $this->db->set("id_destinatario", $dados['id_destinatario']);
        $this->db->set("publicar", $dados['publicar']);
        $this->db->set("data_cadastro", date("Y-m-d H:i:s"));
        $this->db->set("flag_lido", $dados['flag_lido']);
        //$this->db->set("data_lido", date("Y-m-d H:i:s"));

        $this->db->insert("MSG_RESPOSTA");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function excluiResposta($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_resposta", $dados['id_resposta']);
        $this->db->set("publicar", "N");
        //$this->db->set("id_usuario", $dados['id_usuario']);
        //$this->db->set("data_cadastro", date("Y-m-d H:i:s"));        
        $this->db->update("MSG_RESPOSTA");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function atualizaRespostaLida($dados) {
       date_default_timezone_set('America/Sao_Paulo');
       $this->db->where("id_destinatario", $dados['id_usuario']);
       $this->db->set("flag_lido", "S");
       $this->db->set("data_lido", date("Y-m-d H:i:s"));
       $this->db->update("MSG_RESPOSTA");
       $this->db->trans_complete();
       if ($this->db->trans_status() === true) {
           $this->db->trans_commit();
           return true;
       } else {
           $this->db->trans_rollback();
           return false;
       }
    }
    
}