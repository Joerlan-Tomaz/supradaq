<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class TermoEncerramento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_termo_encerramento');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
 public function insereTermoEncerramento() {
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["relatorio_supervisao"] = $this->input->post_get('relatorioSupervisao');
        $dados["numero_paginas"] = $this->input->post_get('numPaginas');
        $dados["local"] = $this->input->post_get('local');
        $dados["inicio"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("inicio")))));
        $dados["termino"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("termino")))));
       
        $dados["id_termo"] = $this->input->post_get('id_termo');
       
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["idContrato"] = $this->session->idContrato;

        $relatorio_supervisao = $this->input->post_get('relatorioSupervisao');
        $numero_paginas = $this->input->post_get('numPaginas');
        $local = $this->input->post_get('local');
        $inicio = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("inicio")))));
        $termino = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("termino")))));

        $DadosServico = $this->Tb_termo_encerramento->RecuperaTextoPadrao($dados); 
    
          foreach ($DadosServico as $lista) {
      
                $nu_con_formatado= $lista->nu_con_formatado;
                $ds_objeto= $lista->ds_objeto;
            }

        $dados["texto"] = "
        Este volume, denominado Relatório Mensal de Supervisão nº $relatorio_supervisao                         
        é parte integrante do contrato $nu_con_formatado ,
        cujo objeto é : $ds_objeto,
        e é composto de $numero_paginas
        páginas, incluindo esta.             
        <br><br> 
        $local,
        $inicio a 
        $termino.            
        ";
            $retorno = $this->Tb_termo_encerramento->insereTermoEncerramento($dados);
        
        echo (json_encode($retorno));
    }


     public function RecuperaTermoEncerramento() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");

        $DadosTermo = $this->Tb_termo_encerramento->RecuperaTermoEncerramento($dados);   
        $retorno["data"] = Array();

        if (!empty($DadosTermo)) {
            foreach ($DadosTermo as $lista) {
               //  $resumo ="Este volume, denominado Relatório Mensal de Supervisão nº (" . $lista->relatorio_supervisao . "), é parte integrante do contrato (" . $lista->nu_con_formatado . "), cujo objeto é: ". $lista->ds_objeto ." e é composto de (" . $lista->numero_paginas . ") páginas, incluindo esta.            
               // <br><br>            
               //   (" . $lista->local . "), (" . $lista->inicio . ") a (" . $lista->termino . ") ";
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirTermoEncerramento(" . $lista->id_termo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'RESUMO' =>  $lista->texto_encerramento,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

    public function textoPadrao() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
      
        $DadosServico = $this->Tb_termo_encerramento->RecuperaTextoPadrao($dados); 
    
          foreach ($DadosServico as $lista) {
      
        $nu_con_formatado = $lista->nu_con_formatado;
        $ds_objeto = $lista->ds_objeto;
       
    }
        $retorno["textoPadrao"] = "Este volume, denominado Relatório Mensal de Supervisão nº
                                 <input type='text' class='' id='relatorioSupervisao' name='relatorioSupervisao' style='width:3%'>,
                                 é parte integrante do contrato $nu_con_formatado ,
                                 cujo objeto é : $ds_objeto,
                                 e é composto de 
                                 <input type='text' class='' id='numPaginas' name='numPaginas' style='width:3%'>
                                 páginas, incluindo esta.             
                                 <br><br>            
                                 <input type='text' class='' id='local' name='local' style='width:10%' placeholder='Local'> ,             
                                 <input type='text' class='' id='inicio' name='inicio' style='width:10%' placeholder='Início' data-provide='datepicker'class='datepicker'> a             
                                 <input type='text' class='' id='termino' name='termino' style='width:10%' placeholder='Término' data-provide='datepicker' class='datepicker'>";

            echo (json_encode($retorno));
    }



       public function excluirTermoEncerramento() {
        $dados["id_termo"] = $this->input->post_get('id_termo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_termo_encerramento->excluirTermoEncerramento($dados);
        echo (json_encode($retorno));
    }
  

}//fecha classe
 
 // * DNIT-SUPRA
 // * Programador: Jordana Alencar
 // * Data: 01/11/19 17:30
