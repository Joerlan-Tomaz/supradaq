<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('importar_excel')) 
{
    
//    $array = array
//                (
//                    "JANEIRO",
//                    "FEVEREIRO",
//                    "MARCO",
//                    "ABRIL",
//                    "MAIO",
//                    "JUNHO",
//                    "JULHO",
//                    "AGOSTO",
//                    "SETEMBRO",
//                    "OUTUBRO",
//                    "NOVEMBRO",
//                    "DEZEMBRO"
//                );
//    $array = array
//                (
//                    "IDENTIFICADOR",
//                    "TIPO",
//                    "ELEMENTO",
//                    "REFERENCIA",
//                    "INDICADORES",
//                    "RESPONSAVEL",
//                    "ORIGEM",
//                    "UNIDADE DE MEDIDA",
//                    "INDICE"
//                );
//    $arrayColunasNomes = array
//                (
//                    0 => "IDENTIFICADOR",
//                    1 => "TIPO",
//                    2 => "ELEMENTO",
//                    3 => "REFERENCIA",
//                    4 => "INDICADORES",
//                    5 => "RESPONSAVEL",
//                    6 => "ORIGEM",
//                    7 => "UNIDADE",
//                    8 => "INDICE",
//                    9 => "DATA",
//                    10 => "PERIODO"
//                );
    
    function procurar($dados, $array, $numberMatches, $debug = false)
    {
        $linhaMatched = -1;
        $qntLinhas = Count($dados);
        $qntEncontradas = 0;
        $lastLine = -1;

        if($qntLinhas > 0)
        {
            foreach($dados as $key => $linhaExcel)
            {
                foreach($linhaExcel as $item)
                {
                    if(!empty($item) && $item != null)
                    {
                        foreach($array as $itemTag)
                        {
                            if(!empty($itemTag) && $itemTag != null)
                            {
                                $value1 = strtoupper($this->tiraracentos($item));
                                $value2 = strtoupper($this->tiraracentos($itemTag));
                                if($debug)
                                {
                                    var_dump($value1);
                                    var_dump($value2);
                                    var_dump(strstr($value1,$value2));
                                }                        
                                if(strstr($value1,$value2))
                                {
                                    if($lastLine == -1)
                                        $lastLine = $key;

                                    if($lastLine == $key)
                                    {
                                        $qntEncontradas++;
                                    }
                                    else
                                    {
                                        $lastLine = -1;
                                    }
                                    
                                    if($qntEncontradas == $numberMatches)
                                    {
                                        return $key;
                                    }

                                    $lastLine = $key;
                                }
                            }
                        }
                    }
                }
            }
            $linhaMatched = -1;
        }

        return $linhaMatched;
    }
    
    function procurarmes($dados, $array, $numberMatches, $retornaExpressaoInteira = true)
    {
        $linhaMatched = -1;
        $qntLinhas = Count($dados);
        $qntEncontradas = 0;
        $lastLine = -1;

        if($qntLinhas > 0)
        {
            foreach($dados as $item)
            {
                foreach($array as $itemTag)
                {
                    $value1 = strtoupper($this->tiraracentos($item));
                    $value2 = strtoupper($this->tiraracentos($itemTag));
                    if(strstr($value1,$value2))
                    {
                        $qntEncontradas++;

                        if($qntEncontradas == $numberMatches)
                        {
                            // Retorna a expressão inteira: "Fevereiro de 2019" ou
                            // Retorna só o mês "Fevereiro"
                            if($retornaExpressaoInteira)
                                return $value1;
                            else
                                return $value2;
                        }
                    }
                }
            }
            
            $linhaMatched = -1;
        }

        return $linhaMatched;
    }

    function procurarcoluna($dados, $array, $coluna)
    {
        $linhaMatched = -1;
        $qntLinhas = Count($dados);
        $colunaVerificada = 0;
        $lastLine = -1;

        if($qntLinhas > 0 && $coluna >= 0)
        {
            $itemTag = $array[$coluna];
            $value2 = strtoupper($this->tiraracentos($itemTag));

            foreach($dados as $item)
            {
                $value1 = strtoupper($this->tiraracentos($item));
                if(strstr($value1,$value2))
                {
                    return $colunaVerificada;
                }
                $colunaVerificada++;
            }
            
            $linhaMatched = -1;
        }

        return $linhaMatched;
    }
    
    function formatarmesreferencia($mesReferencia, $array)
    {
        if($mesReferencia != null && !empty($mesReferencia))
        {
            $expressaoRegular = "/[0-9]{4}/";
            $ano = null;
            if(preg_match($expressaoRegular,$mesReferencia, $ano))
                $ano = $ano[0];
            
            $mesReferencia  = $this->procurarMes(array($mesReferencia), $array, 1, false);
            $mesEmAnalise = 1;
            foreach($array as $item)
            {
                if(strstr($mesReferencia,$item))
                {
                    break;
                }
                $mesEmAnalise++;
            }
            
            $periodoReferencia = $ano . "-" . $mesEmAnalise . "-". "01";
            $periodoReferencia = date('Y-m-d', strtotime($periodoReferencia));
            
            return $periodoReferencia;

        }
        return false;
    }
    
    function tiraracentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }
    
}
