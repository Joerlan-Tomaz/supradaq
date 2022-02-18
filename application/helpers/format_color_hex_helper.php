<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('format_color_hex')) {

    /**
     * Função para verificar se um hexadecimal possui 6 casas
     * @access public 
     * @author Herisson Silva <herisson.dev@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2019. 
     * @param Cor $cor hex hexadecimal c/ casas <= 6
     * @return Cor $cor String hexadecimal c/ 6 casas
     */
    function format_color_hex($cor) {
        $qtd_char = strlen($cor);
        if ($qtd_char < 6) {
            $zero = null;

            for ($cont2 = 1; $cont2 <= 6 - strlen($cor); $cont2++) {
                $zero .= '0';
            }

            $cor = (string) $zero . $cor;
        }
        
        if($qtd_char > 6){
            $cor = substr((string)$cor, 0, 6-$qtd_char);
        }
        
        return $cor;
    }

}