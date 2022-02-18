<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('procurar_linha_value'))
{

    function procurar_linha_value($dadosExcel, $arrayTags, $arrayNegTags = array(), $linhaCabecalho = 0)
    {
        $total = count($dadosExcel);

        // Inicializa com número de linha inválido
        $linha = -1;
        $procuraLinha = true;
        $count = 0;

        foreach ($dadosExcel as $key => $linhaExcel)
        {
          if($count >= $linhaCabecalho){ 
            foreach ($linhaExcel as $celulaExcel)
            {
                foreach ($arrayTags as $itemStr)
                {
                    $value1 = strtoupper($celulaExcel);
                    $value2 = strtoupper($itemStr);
                    if (strstr($value1, $value2))
                    {
                        $hasNegTag = false;
                        foreach($arrayNegTags as $negTag)
                        {
                            $value2 = strtoupper($negTag);
                            if (strstr($value1, $value2))
                            {
                               $hasNegTag = true;
                            }
                        }
                        // Caso não exista a tag negativa (tag ignorada), ai sim retorna a linha.
                        if($hasNegTag == false)
                        {
                            return $key;
                        }
                    }
                }
              }
            }
            $count++;
        }

        return $linha;
    }

}

if (!function_exists('limpar_index_value'))
{

    function limpar_index_value($dadosExcel, $indexStart = 0, $indexFinal = 0)
    {
        $total = count($dadosExcel);
        for ($cont = $indexStart; $cont <= $indexFinal; $cont++)
        {
            unset($dadosExcel[$cont]);
        }
        return $dadosExcel;
    }

}