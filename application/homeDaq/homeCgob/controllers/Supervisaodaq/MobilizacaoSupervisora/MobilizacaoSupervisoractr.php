<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class MobilizacaoSupervisoractr extends CI_Controller {

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


     public function RecuperaRelacaoMobilizacao_Supervisora() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["item"] = $this->input->post_get("item");

        $dadosMobi = $this->Tb_sicro_supervisora->RecuperaRelacaoMobilizacao_Supervisora($dados);
        $dados["data"] = Array();

        $i = 1;
        if (!empty($dadosMobi)) {
            foreach ($dadosMobi as $lista) {
               
                 $dados["data"][] = array(     
                    'id_relacao_supervisora'=> $i . "<input type='hidden' name='id_relacao_supervisora'   value=" . $lista->id_relacao_supervisora . " >" ,
                    'cod_sicro' =>$lista->cod_sicro,
                    'item'=>$lista->item,
                    'tipo'=>$lista->tipo,
                    'qtd_proprio'=>"<input type='text' name='qtd_proprio'  value=$lista->qtd_proprio>",
                    'qtd_terceiro' => "<input type='text' name='qtd_terceiro'  value=$lista->qtd_terceiro>"
                );
                $i++;
            }
        }
        echo (json_encode($dados));
    }


public function GravaRelacao() {
        $lista = $this->input->post("data");
        $lista = explode("&", $lista);
        $numRegs = count($lista);
        $n = 0;
        foreach ($lista as $valor) {
            $conte = strpos($valor, "=");
            if ($conte == 22) {
                $id_relacao_supervisora = substr($valor, 23);
            }

            if ($conte == 11) {
                $campoProprio = substr($valor, 12);
                if (empty($campoProprio)) {
                    $campoProprio = 0;
                }
            }
            if ($conte == 12) {
                $campoTerceiro = substr($valor, 13);
                if (empty($campoTerceiro)) {
                    $campoTerceiro = 0;
                }
            }

            $n++;
            if ($n == 3) {
                $dados["id_relacao_supervisora"] = $id_relacao_supervisora;
                $dados["qtd_proprio"] = $campoProprio;
                $dados["qtd_terceiro"] = $campoTerceiro;
                $dados["periodo"] = $this->input->post('periodo');
                $dados["idUsuario"] = $this->session->id_usuario_daq;
                $dados["idContrato"] = $this->session->idContrato;
                // if ($campoProprio == 0 and $campoTerceiro == 0) {
                   
                // } else {
                    $this->Tb_sicro_supervisora->GravaRelacao($dados);
                    $retorno["mensagem"] = "Relação Mobilização cadastrada com sucesso!";
                    $retorno["notify"] = "success"; 
                //}

                $n = 0;
            }
        }
        echo (json_encode($retorno));
    }

    public function RecuperaMobilizacaoSupervisora() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
       

        $dadosMobi = $this->Tb_sicro_supervisora->RecuperaMobilizacaoSupervisora($dados);
        $dados["data"] = Array();

        $i = 1;
        if (!empty($dadosMobi)) {
            foreach ($dadosMobi as $lista) {
               
                 $dados["data"][] = array(     
                    'id'=>$i,
                    'cod_sicro' =>$lista->cod_sicro,
                    'item'=>$lista->item,
                    'tipo'=>$lista->tipo,
                    'qtd_proprio'=>$lista->qtd_proprio,
                    'qtd_terceiro' => $lista->qtd_terceiro,
                    "desc_nome" => $lista->nome,
                    "ultima_alteracao" => $lista->ultima_alteracao,
                    "acoes" => "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick=\"trashconstrutora({$lista->id})\">
                                 <i class = 'fa fa-trash'></i></button >"
                );
                $i++;
            }
        }
        echo (json_encode($dados));
    }


        public function trashconstrutora() {
        $dados["id"] = $this->input->post_get('id');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_sicro_supervisora->trashconstrutora($dados);
        echo (json_encode($retorno));
    }






}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 11/12/2019
//######################################################################################################################################################################################################################## 
  
