<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('array_sort')) {

/**
 * Função para ordenar um array bidimensional
 * @access public 
 * @author Herisson Silva <herisson.dev@gmail.com>
 * @version 0.1 
 * @copyright  GPL © 2019. 
 * @param Array $array Array bidimensional
 * @param String $on Chave que será utilizada como índice de ordenação
 * @param Expressao_regular $order Flags para tipo de ordenação.  Ver sort_flags em https://secure.php.net/manual/pt_BR/function.sort.php
 * @return Array() array bidimencional ordenado pela chave $on 
 */
    function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

}
