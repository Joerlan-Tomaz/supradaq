<?php

class UFModel extends CI_Model
{
    public $CoddigoBaseUF;
    public $Nome;
    public $Sigla;

    private $db2;
    
    function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('CGPERT', TRUE);
        $this->dbDnitSupra = $this->load->database('dnitSupra', true);
    }

    function getUFs($selectFields = '', $arrWhere = '', $orderBy = 'Sigla') {
        
        if($selectFields){
            $this->db2->select($selectFields);
        }

        $this->db2->order_by($orderBy);

        if($arrWhere != '' && $arrWhere != []) {
            $query = $this->db2->get_where('tblBaseUF', $arrWhere);
        } else {
            $query = $this->db2->get('tblBaseUF');
        }
        
        return $query->result();
    }

    function obterUFs($selectFields = '', $arrWhere = '', $orderBy = 'sigla_uf') {
        
        if($selectFields){
            $this->dbDnitSupra->select($selectFields);
        }

        $this->dbDnitSupra->order_by($orderBy);

        if($arrWhere != '' && $arrWhere != []) {
            $query = $this->dbDnitSupra->get_where('TB_UF', $arrWhere);
        } else {
            $query = $this->dbDnitSupra->get('TB_UF');
        }
        
        return $query->result();
    }

}