<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Responsaveltecnico extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora_tecnico');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }


     //-------------------------------------------Insere-----------------------------------------

    // public function insereResponsavelTecnico() {
    //     $dados["id_responsavel_tecnico"] = $this->input->post_get('id_responsavel_tecnico');
    //     $dados["periodo"] = $this->input->post_get('periodo');
    //     $dados["idContrato"] = $this->session->idContrato;
    //     $dados["idUsuario"] = $this->session->id_usuario;
    //     $dados["roteiro"] = "19";

    //     $dados["id_apresentacao"] = $this->input->post_get('id_apresentacao');
        
    //     $dados["empresa"] = $this->input->post_get('empresa_responsavel_tecnico');
    //     $dados["profissional"] = $this->input->post_get('nome_responsavel_tecnico');
    //     $dados["email"] = $this->input->post_get('email_responsavel_tecnico');
    //     $dados["telefone"] = $this->input->post_get('telefone_responsavel_tecnico');
    //     $dados["crea"] = $this->input->post_get('CREA_responsavel_tecnico');
    //     $dados["rnp"] = $this->input->post_get('RNP_responsavel_tecnico');
    //     $dados["num_art"] = $this->input->post_get('n_art_responsavel_tecnico');
    //     $dados["uf_registro"] = $this->input->post_get('uf_registro_responsavel_tecnico');
    //     $dados["part_tecnica"] = $this->input->post_get('participacao_tecnica_tecnico');
    //     $dados["forma_registro"] = $this->input->post_get('forma_registro_responsavel_tecnico');
    //     $dados["status"] = $this->input->post_get('status_responsavel_tecnico');
    //     $dados["data_registro"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataregistro")))));
    //     $dados["data_baixa"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("databaixa")))));
        
    //     if (empty($dados["id_responsavel_tecnico"])) {
    //         $retorno = $this->Tb_responsavel_tecnico->insereResponsavelTecnico($dados);
    //     }
    //     echo (json_encode($retorno));
                        
    // }

    //-------------------------------------------Recupera-----------------------------------------

    public function Tableresponsaveltecnico() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "19";

        $Dados = $this->Tb_apresentacao_supervisora_tecnico->recuperaART($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {

                $retorno["data"][] = array(

                    'nome_fiscal'=> $lista->nome_profissional,
                    'n_art'=> $lista->num_art,
                    'forma_registro'=>$lista->forma_registro, 
                    'participacao_tecnica'=>$lista->participacao_tecnica, 
                    'data_registro'=>$lista->data_registro, 
                    'data_baixa'=>$lista->data_baixa, 
                    'USUARIO'=> $lista->nome,
                    'ATUALIZACAO'=> $lista->ultima_alteracao
                );
            }
        }
        echo (json_encode($retorno));
    }


    //  public function excluirResponsaveltecnico() {
    //     $dados["id_responsavel_tecnico"] = $this->input->post_get('id_responsavel_tecnico');
    //     $dados["id_usuario"] = $this->session->id_usuario;
    //     $retorno = $this->Tb_responsavel_tecnico->excluirResponsaveltecnico($dados);
    //     echo (json_encode($retorno));
    // }



}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 15/01/2020 13:00
//########################################################################################################################################################################################################################
