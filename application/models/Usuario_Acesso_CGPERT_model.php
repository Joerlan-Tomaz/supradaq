<?php

Class Usuario_Acesso_CGPERT_model extends CI_Model {

    private $db2;

    function __construct() {
        parent:: __construct();
        $this->db2 = $this->load->database('CGPERT_PERFIL', TRUE);
    }

    public function insertUser() {
        $dados['IP_address'] = $this->input->ip_address();
        $dados['CodigoUsuarioSessao'] = $this->session->id_usuario;
        $dados['Nome'] = $this->session->desc_nome;
        $dados['Email'] = $this->session->email;
        $dados['DtUltimoAcesso'] = $this->session->dt_Ultacesso;
        $dados['UF'] = $this->buscaUserUF($this->session->id_uf);
        $numero_de_bytes = 30;
        $restultado_bytes1 = random_bytes($numero_de_bytes);
        $dados['Token'] = bin2hex($restultado_bytes1);



        $this->db2->where('CodigoUsuarioSessao', $dados['CodigoUsuarioSessao']);
        $sql = 'IF EXISTS (';
        $sql .= $this->db2->get_compiled_select('tblUsuarioAcesso');
        $sql .= ') ';

        $this->db2->where('CodigoUsuarioSessao', $dados['CodigoUsuarioSessao']);
        $sql .= $this->db2->set($dados)->get_compiled_update('tblUsuarioAcesso');

        $sql .= ' ELSE ';
        $sql .= $this->db2->set($dados)->get_compiled_insert('tblUsuarioAcesso');

        $query = $this->db2->query($sql);
        $result = $query->result_array();

        $this->db2->trans_complete();
        if ($this->db2->trans_status() === FALSE) {
            $this->db2->trans_rollback();
            return FALSE;
        } else {
            $this->db2->trans_commit();
            return $dados['Token'];
        }
    }

    private function buscaUserUF($id_uf) {
        if ($id_uf != null && $id_uf != '') {
            $this->db->select('uf');
            $this->db->from('TB_UF');
            $this->db->where('id_uf', $id_uf);
            $query = $this->db->get();
            $uf = $query->row_array();
            if (count($uf) != 0) {
                return $uf['uf'];
            }
        }

        return null;
    }

}
