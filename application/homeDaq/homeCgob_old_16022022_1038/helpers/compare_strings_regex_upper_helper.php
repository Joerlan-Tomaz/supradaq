<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('compare_strings_regex_upper')) {

    
     /**
     * Verifica se uma string é igual a outra, ignorando caracteres  
     * especiais e ignorando maúsculas e minúsculas
     * @access public 
     * @author Rodolfo Romão <rodolforomao@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2019. 
     * @param array, key (a ser validado1), Tipo do Dado (Para retorno do erro)
     * @return Retorna o valor ou o erro.
     */
    function compare_strings_regex_upper($item1,$item2)
    {
        $item1 = preg_replace('/[^A-Za-z0-9]/', "", strtoupper($item1));
        $item2 = preg_replace('/[^A-Za-z0-9]/', "", strtoupper($item2));
        
        if ($item1 == $item2)
        {
            return true;
        }
        
        return false;
    }

}
