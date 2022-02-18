<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('check_table_exists'))
{

    /**
     * Returns values for $needle key in a multidimensional array, recursively.
     * More info and example: https://github.com/NinoSkopac/array_column_recursive
     *
     * @param array $haystack
     * @param string $needle
     * @return array
     */
    function check_table_exists($dbName = null, $tableName = null,  $schemaName = 'dbo')
    {
        if(!empty($dbName) && !empty($tableName) && !empty($schemaName))
        {
            $CI = & get_instance();
            if($CI->session->userdata('trancking_enable') !== null)
            {
                return $CI->session->userdata('trancking_enable');
            }
            $CI->db2 = $CI->load->database($dbName, TRUE);
            
            $SQL = "SELECT count(*) existe
                        FROM INFORMATION_SCHEMA.TABLES 
                    WHERE TABLE_SCHEMA = '".$schemaName."' 
                    AND  TABLE_NAME = '".$tableName."'";
            
            $resposta = $CI->db2->query($SQL)->result();
            
            if(!empty($resposta) && count($resposta))
            {
                $resposta = $resposta[0]->existe;
                if($resposta == true)
                {
                    $CI->load->library('session');
                    $CI->session->set_userdata('trancking_enable', true);
                    return true;
                }
            }
        }
        return false;
    }

}