<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_users extends Table_model {

    protected $table = 'TB_USUARIO';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function getById($id_usuario) {
        $this->db->from($this->table);
        $this->db->where('id_usuario', $id_usuario);

        return $this->db->get()->result_array();
    }

    public function validar_login($email, $senha) {
        $SQL = "
            SELECT 
                u.empresa,
                u.fechar_relatorio,
                u.flag_primeiro_acesso,
                u.ID_PERFIL,
                u.CODI_SENHA,
                u.DESC_NOME,
                u.ID_USUARIO,
                CONCAT (CONVERT(VARCHAR(10),u.data_ultimoacesso, 1),' ',CONVERT(VARCHAR(10), u.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO,
                u.FLAG_ALTERASENHA,
                u.email, 
                u.TELEFONE,
                u.cpf
            FROM tb_usuario u 
            WHERE email = '$email'
            AND CODI_SENHA = '$senha'";
        $query = $this->db->query($SQL);
        $retorno = $query->result_array();

        if (count($retorno) > 0) {
            $log = array(
                'desc_nome' => $retorno[0]["DESC_NOME"],
                'id_perfil' => $retorno[0]["ID_PERFIL"],
                'email' => $retorno[0]["email"],
                'id_usuario' => $retorno[0]["ID_USUARIO"],
                'dt_Ultacesso' => $retorno[0]["DATA_ULTIMOACESSO"],
                'boAlteraSenha' => $retorno[0]["FLAG_ALTERASENHA"],
                'stPerfilFecharRelatorio' => $retorno[0]["fechar_relatorio"],
                'empresa' => $retorno[0]["empresa"],
                'telefone' => $retorno[0]["TELEFONE"],
                'cpf' => $retorno[0]["cpf"],
            );
        } else {
            $log = false;
        }
        return $log;
    }

}
