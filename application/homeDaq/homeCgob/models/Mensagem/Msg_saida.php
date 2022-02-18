<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Msg_saida extends CI_Model{

    public function insereSaida($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        
        $this->db->set("id_mensagem", $dados['id_mensagem']);
        $this->db->set("id_destinatario", $dados['id_usuario_destinatario']);
        $this->db->set("id_contrato_obra", $dados['idContrato']);
        $this->db->set("id_roteiro", $dados['id_roteiro']);
        $this->db->set("flag_lido", $dados['flag_lido']);
        //$this->db->set("data_lido", date("Y-m-d H:i:s"));

        $this->db->insert("MSG_SAIDA");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function atualizaMensagemLida($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_destinatario", $dados['id_usuario']);
        $this->db->where("id_roteiro", $dados['id_roteiro']);
        $this->db->set("flag_lido", "S");
        $this->db->set("data_lido", date("Y-m-d H:i:s"));
        $this->db->update("MSG_SAIDA");
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