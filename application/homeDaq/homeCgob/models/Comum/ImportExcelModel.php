<?php

class ImportExcelModel extends CI_Model
{

    private $db2;

    function __construct(){
        parent::__construct();
        $this->db2 = $this->load->database('CGPERT', TRUE);
    }
    
    public function insertDadosExcel($dados, $tabela)
    {
        //initialize transaction
        $this->db2->trans_begin();        
        $fields = $this->db2->field_data($tabela);
        foreach($dados as $dado => $value){
            foreach($fields as $field){
                $campo = $field->name;
                if(array_key_exists($campo, $value) && ($field->type == 'decimal' || $field->type == 'int')){
                    if($value[$campo] === NULL || $value[$campo] === ''){
                        $dados[$dado][$campo] = 0;
                    }
                }
            }
        }
        $this->db2->db_debug = false;
        $this->db2->insert_batch($tabela, $dados);
        //make transaction complete
        $this->db2->trans_complete();
        //check if transaction status TRUE or FALSE
        if ($this->db->trans_status() === FALSE) {
            //if something went wrong, rollback everything
            $this->db2->trans_rollback();
            return FALSE;
        } else {
            //if everything went right, commit the data to the database
            $this->db2->trans_commit();
            return TRUE;
        }
    }
}