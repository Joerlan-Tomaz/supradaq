<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_uf extends Table_model {

    protected $table = 'TB_UF';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function recuperaUF($dados) {
        $SQL = "
            SELECT * FROM TB_UF 
            WHERE uf = '" . $dados["uf"] . "'";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function populaUF() {
        $SQL = "
            SELECT * FROM TB_UF ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

}
