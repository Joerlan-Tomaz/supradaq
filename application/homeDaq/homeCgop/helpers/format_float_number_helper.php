<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!defined('CONST_TAG_1'))
{
    define('CONST_TAG_1', ',');
}

if (!defined('CONST_TAG_2'))
{
    define('CONST_TAG_2', '.');
}

if (!function_exists('format_float_number_value'))
{


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
    function format_float_number_value($value)
    {
        if (!empty($value))
        {
            $value = str_replace(CONST_TAG_1, CONST_TAG_2, $value);
            $qnt = substr_count($value, CONST_TAG_2);
            while ($qnt > 1)
            {
                $pos = strpos($value, CONST_TAG_2);

                if ($pos !== false)
                {
                    $value = substr($value, 0, $pos) . substr($value, ($pos + 1), strlen($value));
                }
                $qnt = substr_count($value, CONST_TAG_2);
            }
        }
        return $value;
    }

}
