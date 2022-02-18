<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

define("CACHE_DIR", APPPATH . 'cache/');

if (!function_exists('array_combo')) {

    /**
     * Função para combinar dois arrays no mesmo índice
     * @access public 
     * @author Herisson Silva <herisson.dev@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2019. 
     * @param Array1 $array Array bidimensional que receberá o $array2
     * @param Array2 $array Array bidimensional que será inserido em $array1
     * @return Array() array$ contendo o $array2 em seu respectivo índice
     */
    function array_combo($array1, $array2) {
        $return = array();
        for ($cont = 0; $cont < count($array1); $cont++) {
            if (is_array($array1[$cont])) {
                $element = array();
                foreach($array1[$cont] as $key => $item){
                    $element[$key] = $item;
                }
                
                foreach($array2[$cont] as $key => $item){
                    $element[$key] = $item;
                }
                
                $return[] = $element;
                
            }else{
                $return[] = array($array1[$cont], $array2[$cont]);
            }
        }

        return $return;
    }

}