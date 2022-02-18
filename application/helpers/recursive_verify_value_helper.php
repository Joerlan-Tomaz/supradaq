<?php

if (!function_exists('recursive_verify_value'))
{
    $ci = get_instance();
    $ci->load->helper('verify_key_exists_and_return_identity_value');
    
    /**
     * Função para verificar se o índice existe e retorna o valor caso encontre.
     * Caso não encontre, a função permite você retorna um erro padrão.
     * @access public 
     * @author Rodolfo Romão <rodolforomao@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2020. 
     * @param array, key (a ser validado1), Tipo do Dado (Para retorno do erro)
     * @return Retorna o valor ou o erro.
     */
    function recursive_verify_value($value, $listIndex, $format = BOOLEAN_RESPONSE)
    {
        if (!empty($value))
        {
            $retorno = BOOLEAN_RESPONSE_RETURN;
            if($format == ARRAY_INDEX_RESPONSE)
            {
                $retorno = ARRAY_INDEX_RETURN;
            }
            
            foreach ($listIndex as $index)
            {
                $value = verify_key_exists_and_return_identity_value($value, $index, $format);
                if ($value === $retorno)
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
        return $value;
    }

}
