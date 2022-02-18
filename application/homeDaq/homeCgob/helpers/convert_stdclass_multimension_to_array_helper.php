<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('convert_stdclass_multimension_to_array_value')) {

    
     /**
     * Esta função converte uma stdclass multidimensional para um array simples
     * Esta função usa recursividade, desta maneira devemos passar o array por referência.
     * @access public 
     * @author Rodolfo Romão <rodolforomao@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2019. 
     * @param obj (Array sdtclass), &$array (Array a ser retornado).
     * @return Retorna o valor ou o erro.
     */
    function convert_stdclass_multimension_to_array_value($obj, &$arr)
    {

        if (!is_object($obj) && !is_array($obj))
        {
            $arr = $obj;
            return $arr;
        }

        foreach ($obj as $key => $value)
        {
            if (!empty($value))
            {
                $arr[$key] = array();
                convert_stdclass_multimension_to_array_value($value, $arr[$key]);
            } else
            {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }

}
