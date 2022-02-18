<?php

if (!defined('BASEPATH')) exit('Nenhum acesso de script direto permitido');

    //Função para formatar entrada do valor banco de dados
    function FormatarValorEntrada($valor){
        setlocale(LC_MONETARY, 'pt_BR', 'ptb');
        return number_format($valor, 2, ".", ",");
    }

    //Função para formatar saída do valor
    function FormatarValorDeSaida($valor){
        setlocale(LC_MONETARY, 'pt_BR', 'ptb');
        return isset($valor) ? number_format($valor, 2, ",", ".") : 0;
    }

    //Função para formatar saída do valor retirando as casas decimais
    function FormatarValorSemCasasDecimais($valor) {
        setlocale(LC_MONETARY, 'pt_BR', 'ptb');
        $vlr = floatval($valor);
        return number_format($vlr, 0, ',', '.');
    }

    //Função para formatar
    function FormataDataPadraoAmericano($date) {
        if (isset($date)) {
            $date = str_replace('-', '/', $date);
            setlocale(LC_ALL, 'pt_BR', 'ptb');
            return date('d-m-Y', strtotime($date));
        } else {
            return null;
        }
    }

    function FormataDataHora($date, $formatacao) {
        if (isset($date)) {
            setlocale(LC_ALL, 'pt_BR', 'ptb');
            if ($formatacao) {
                return date('d-m-Y H:i:s', strtotime($date)); //Formata a data com -
            } else {
                return date('d/m/Y H:i:s', strtotime($date)); //Formata a data com /
            }
        } else {
            return null;
        }
    }

    function GerarCodigoRandom($tamanho = 9, $maiusculas = true, $minusculo = true, $simbolos = false) {
        // Caracteres de cada tipo
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';

        // Variáveis internas
        $retorno = '';
        $caracteres = '';

        // Agrupamos todos os caracteres que poderão ser utilizados
        $caracteres .= $num;
        if ($maiusculas) $caracteres .= $lmai;
        if ($minusculo) $caracteres .= $lmin;
        if ($simbolos) $caracteres .= $simb;

        // Calculamos o total de caracteres possíveis
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            // Criamos um número aleatório de 1 até $len para pegar um dos caracteres
            $rand = mt_rand(1, $len);
            // Concatenamos um dos caracteres na variável $retorno
            $retorno .= $caracteres[$rand-1];
        }

        return $retorno;
    }

    function NomeDoMes($mes) {
        $primeiro = substr($mes, 0, 1);
        if($primeiro == "0") {
            $mes = str_replace("0", "", $mes);
        }
        $Mes = array(1 =>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

        return $Mes[$mes];
    }

    function FormatSizeUnits($bytes) {

        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

?>
