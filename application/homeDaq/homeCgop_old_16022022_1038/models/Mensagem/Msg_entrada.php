<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Msg_entrada extends CI_Model{

    public function RecuperaDadosMensagem($dados){
       
        $SQL = "
            SELECT MAX(id_mensagem) AS id_mensagem
            FROM MSG_ENTRADA 
            WHERE id_remetente = ".$dados["idUsuario"];            
          
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function insereEntrada($dados) {
        date_default_timezone_set('America/Sao_Paulo');
        
        $this->db->set("id_remetente", $dados['id_usuario_remetente']);
        $this->db->set("assunto", $dados['assunto_mensagem']);
        $this->db->set("mensagem", $dados['descricao_mensagem']);
        $this->db->set("data_cadastro", date("Y-m-d H:i:s"));

        $this->db->insert("MSG_ENTRADA");
        return true;
    }
    
}