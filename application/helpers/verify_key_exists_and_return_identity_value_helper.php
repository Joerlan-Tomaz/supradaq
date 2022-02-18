<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!defined('FORMAT_NUMBER_RESPONSE'))
{
    define('FORMAT_NUMBER_RESPONSE', 0);
}
if (!defined('SHORT_STRING_RESPONSE'))
{
    define('SHORT_STRING_RESPONSE', 1);
}
if (!defined('LONG_STRING_RESPONSE'))
{
    define('LONG_STRING_RESPONSE', 2);
}
if (!defined('ARRAY_INDEX_RESPONSE'))
{
    define('ARRAY_INDEX_RESPONSE', 3);
    define('ARRAY_INDEX_RETURN', -1);
}
if (!defined('BOOLEAN_RESPONSE'))
{
    define('BOOLEAN_RESPONSE', 4);
    define('BOOLEAN_RESPONSE_RETURN', false);
}

if (!function_exists('verify_key_exists_and_return_identity_value')) {

    
     /**
     * Função para verificar se o índice existe e retorna o valor caso encontre.
     * Caso não encontre, a função permite você retorna um erro padrão.
     * @access public 
     * @author Rodolfo Romão <rodolforomao@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2019. 
     * @param array, key (a ser validado1), Tipo do Dado (Para retorno do erro)
     * @return Retorna o valor ou o erro.
     */
    function verify_key_exists_and_return_identity_value($array, $key, $dataType = 0)
    {
        if(!empty($array) && ($key == 0 || !empty($key)))
        {
            if(array_key_exists($key, $array))
            {
                if($array instanceof stdClass )
                    return $array->$key;
                else
                return $array[$key];
            }
        }
        // number
        if($dataType == FORMAT_NUMBER_RESPONSE)
            return 0;
        else if($dataType == SHORT_STRING_RESPONSE)
            return "Sem dados";
        else if($dataType == LONG_STRING_RESPONSE)
            return "Não foi cadatrada nenhum informação para este item.";
        else if($dataType == ARRAY_INDEX_RESPONSE)
            return ARRAY_INDEX_RETURN;
        else if($dataType == BOOLEAN_RESPONSE)
            return BOOLEAN_RESPONSE_RETURN;
    }

}
