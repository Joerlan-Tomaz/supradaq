<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('badge_status_relatorio'))
{

    /**
     * Função para criar o badge do status do relatório
     * @access public 
     * @author Herisson Silva <herisson.dev@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2019. 
     * @param id_status $id_status Int com o id do status
     * @param descricao_status $descricao_status String descrição do conteúdo do badge
     * @return String contendo o html do badge
     */
    function badge_status_relatorio($id_status, $descricao_status, $contexto = null)
    {
        $retorno = null;
        switch ($id_status)
        {
            case 1:
                $retorno = '<span class="badge badge-info">' . ( !empty($contexto) ? ($contexto == 'estrutural' ? 'E:' : 'T:') : '')  . $descricao_status . '</span>';
                break;

            case 2:
                $retorno = '<span class="badge badge-primary">' . ( !empty($contexto) ? ($contexto == 'estrutural' ? 'E:' : 'T:') : '')  . $descricao_status . '</span>';
                break;

            case 3:
            case 4:
                $retorno = '<span class="badge badge-warning">' . ( !empty($contexto) ? ($contexto == 'estrutural' ? 'E:' : 'T:') : '')  . $descricao_status . '</span>';
                break;

            case 5:
                $retorno = '<span class="badge badge-success">' . ( !empty($contexto) ? ($contexto == 'estrutural' ? 'E:' : 'T:') : '')  . $descricao_status . '</span>';
                break;

            case 7:
                $retorno = '<span class="badge badge-danger">' . ( !empty($contexto) ? ($contexto == 'estrutural' ? 'E:' : 'T:') : '')  . $descricao_status . '</span>';
                break;

            default:
                $retorno = '<span class="badge badge-secondary">' . ( !empty($contexto) ? ($contexto == 'estrutural' ? 'E:' : 'T:') : '')  . $descricao_status . '</span>';
                break;
        }
        return $retorno;
    }

}