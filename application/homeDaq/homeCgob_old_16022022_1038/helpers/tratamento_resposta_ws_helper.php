<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('tratamento_resposta_ws')) 
{
    
    function tratamento_resposta_ws($status, $mensagem, $dados) 
    {
        $resposta = array
            (
            "status" => $status,
            "mensagem" => $mensagem,
            "resultado" => $dados
        );
        return $resposta;
    }

}
