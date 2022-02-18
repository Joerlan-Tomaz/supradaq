<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Apresentacaosupervisora extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    //-------------------------------------------Recupera-----------------------------------------

     public function RecuperaApresentacaoSupervisora(){
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        
        $dadosContrato = $this->Tb_apresentacao_supervisora->RecuperaApresentacaoSupervisora($dados);

        foreach ($dadosContrato as $lista) {

            if ($lista->publi_result == '' ){
                    $lista->publi_result = "- -";
            }
            if($lista->publi_dou == ''){
                    $lista->publi_dou = "- -";
                }

            $dados["data_base"] = $lista->data_base;
            $dados["contrato"] = $lista->contrato;
            $dados["empresa_supervisora"] = $lista->nome_empresa;
            $dados["processo_base"] = $lista->processo_adm;
            $dados["objeto"] = $lista->objeto;
            $dados["localizacao"] = $lista->localizacao;
           
            $dados["data_assinatura"] = $lista->data_ass;
            $dados["ordem_inicial"] = $lista->ordem_inicial;
            $dados["prazo_inicial"] = $lista->prazo_inicial;
            $dados["termino_inicial"] = $lista->data_inicial_term;
            $dados["termino_atualizada"] = $lista->dt_termino_atualizada;

            $dados["data_publicacao"] = $lista->publi_dou;
            $dados["publicacao_licitacao_DOU"] = $lista->publi_result;

            $dados["dias_aditados"] = $lista->dias_aditados;
            $dados["dias_paralisados"] = $lista->total_paralisados; 
            $dados["valor_PI"] = number_format($lista->valor_pi_contrato,2,",",".");
            $dados["valor_aditado"] =number_format($lista->valor_total_aditado,2,",",".");
            $dados["valor_reajuste"] =number_format($lista->valor_reajuste,2,",",".");
            $dados["valor_atualizado"] =number_format($lista->valor_atz_pir,2,",",".");
        }
   
        echo (json_encode($dados));
    }

//-------------------------------------------Insere-----------------------------------------

    public function insereApresentacaosupervisora() {
        $dados["id_apresentacao"] = $this->input->post_get('id_apresentacao');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;

        $dados["data_base"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_base")))));  
        $dados["nome_empresa"] = $this->input->post_get('empresa_supervisora');
        $dados["num_processo_adm"] = $this->input->post_get('num_processo_base');
        $dados["objeto"] = $this->input->post_get('objeto_contrato');
        $dados["data_assinatura"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_assinatura")))));
        $dados["data_inicial_termino"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_inicial_termino")))));   
        
        $dados["ordem_inicio_servicos"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("ordem_inicio_servicos")))));  

        $dados["prazo_inicial_execucao"] = $this->input->post_get('prazo_inicial_execucao');  
        $dados["data_term_atualizada"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_term_atualizada")))));  
        $dados["data_publi_dou"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_publicacao_dou")))));
        
        $dados["data_publi_dou_result"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_resultado_licitacao_dou")))));
        $dados["total_dias_aditados"] = $this->input->post_get('total_dias_aditados');
        $dados["total_dias_paralisados"] = $this->input->post_get('total_dias_paralisados');


        $dados["valor_pi_contrato"] = str_replace(",", ".", str_replace(".", "", $this->input->post_get("valor_pi_contrato")));
        $dados["valor_total_aditado"] = str_replace(",", ".", str_replace(".", "", $this->input->post_get("valor_total_aditivado_contrato")));
        $dados["valor_reajuste_contrato"] = str_replace(",", ".", str_replace(".", "", $this->input->post_get("valor_reajuste_contrato")));
        $dados["valor_atualizado"] = str_replace(",", ".", str_replace(".", "", $this->input->post_get("valor_atualizado_contrato")));
      
    
            $retorno = $this->Tb_apresentacao_supervisora->insereApresentacaosupervisora($dados);
        
        echo (json_encode($retorno));
                        
    }

    public function recuperaPortariasFiscais(){
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["contrato_fiscalizado"] = $this->input->post_get("contrato_fiscalizado");

        $Dados = $this->Tb_apresentacao_supervisora->recuperaPortariasFiscais($dados);
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
        
                $retorno["data"][] = array(
                    'estado' => $lista->estado,
                    'nomeFiscal' => $lista->nome_fiscal,
                    'email' => $lista->email,
                    'telefone' => $lista->telefone, 
                    'titularidade' => $lista->titularidade, 
                    'status' => $lista->publicar
                );
            }
        }
        echo (json_encode($retorno));

    }








}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 20/01/2020 13:00
//########################################################################################################################################################################################################################
