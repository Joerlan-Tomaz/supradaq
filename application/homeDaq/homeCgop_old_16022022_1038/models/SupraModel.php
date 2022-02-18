<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Recupera todos acidentes de determinado ano, uf, km
 * 
 * Organiza ranking por estado, rodovia, classificacao, tipo, ups e
 * custo medio gerencial
 * 
 */
class SupraModel extends CI_Model
{
    function __construct(){
        parent::__construct();
        //$this->db2 = $this->load->database('CGPERT', TRUE);
    }

    public function formatJSONDataTable($arrDados){
        $arr['data'] = [];
        $cont = 0;
        foreach($arrDados as $arrLinha){
            $arr['data'][$cont] = [];
            foreach(array_keys($arrLinha) as $key){
                array_push($arr['data'][$cont],['name'=>$key,'value'=>$arrLinha[$key]]);
            }
            $cont++;
        }

        echo '<pre>'; print_r($arr); die;
        return json_encode($arr);
    }
}
