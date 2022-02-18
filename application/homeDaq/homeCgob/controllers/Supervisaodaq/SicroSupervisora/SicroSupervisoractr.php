<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class SicroSupervisoractr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_sicro_supervisora');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    //------------------------------------------------------------------------------------

    public function Recupera_item_cadastro() {
            $DadosServico = $this->Tb_sicro_supervisora->Recupera_item_cadastro();
            $n = 0;
            foreach ($DadosServico as $lista) {
                $dados['id_tipo_sicro'][$n] = $lista->id_tipo_sicro;
                $dados['item'][$n] = str_replace("_", " ", $lista->item);
                $n++;
            }
            echo (json_encode($dados));
    }

    public function Recupera_relacao_item_cadastro() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["itemcadastro"] = $this->input->post_get("itemcadastro");
        $dados["sicro"] = $this->input->post_get("sicro");
        $dados["tipo"] = $this->input->post_get("tipo");

        $dadosSicro = $this->Tb_sicro_supervisora->Recupera_relacao_item_cadastro($dados);   
        $dados["data"] = Array();

        $i = 1;
        if (!empty($dadosSicro)) {
            foreach ($dadosSicro as $lista) {

                if ($lista->chek == "" or NULL){
                     $acao= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick =\" CadastrarItem({$lista->id_sicro})\" style='font-size: 13px'><i class = 'fas fa-plus' style='width: 56px'></i></button >";
                  } 
                  else {
                     $acao= "<button type='button' class='btn btn-default' style='font-size: 13px'><i class = 'fas fa-check' style='width: 56px; color:green'></i></button >";
                  }
                $dados["data"][] = array(     
                    'conte'=> $i,
                    'item'=>$lista->item,
                    'cod_sicro' =>$lista->cod_sicro,
                    'tipo'=>$lista->tipo,
                    'unidade'=>$lista->unidade,
                    'acao' => $acao
                );
                $i++;
            }
        }
        echo (json_encode($dados));
    }


     public function CadastrarItem() {
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_sicro"] = $this->input->post_get('id_sicro');

        $item = $this->Tb_sicro_supervisora->item_sicro($dados);
            foreach ($item as $key) {
                # code...
                $dados["cod_sicro"] = $key->cod_sicro;
                $dados["item"] = $key->item;
                $dados["tipo"] = $key->tipo;
            }

            $retorno = $this->Tb_sicro_supervisora->CadastrarItem($dados);
        
        echo (json_encode($retorno));
            
    }





}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedora:Jordana de Alencar
//# Data: 28/01/2019 15:00
//######################################################################################################################################################################################################################## 
  
