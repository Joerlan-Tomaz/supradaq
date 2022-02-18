<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class GestaoTratativa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_gestao_tratativa');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

 //------------------------------------------------------------------------------------

    public function populaOrigem() {
            $DadosServico = $this->Tb_gestao_tratativa->populaOrigem();
            $n = 0;
            foreach ($DadosServico as $lista) {
                $dados['id_origem'][$n] = $lista->id_origem;
                $dados['desc_origem'][$n] = str_replace("_", " ", $lista->desc_origem);
                $n++;
            }
            echo (json_encode($dados));
        }

    public function populaResponsaveis() {
            $DadosServico = $this->Tb_gestao_tratativa->populaResponsaveis();
            $n = 0;
            foreach ($DadosServico as $lista) {
                $dados['id_responsavel'][$n] = $lista->id_responsavel;
                $dados['desc_responsavel'][$n] = str_replace("_", " ", $lista->desc_responsavel);
                $n++;
            }
            echo (json_encode($dados));
        }


public function insereGestaoTratativa() {
        $dados["id_gestao_tratativa"] = $this->input->post_get('id_gestao_tratativa');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["status_gestao"] = "Aberto";

        $dados["origem"] = $this->input->post_get('origem');

        $dados["data_solicitacao"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataSolicitacao")))));
        $dados["data_pactuada"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataPactuada")))));
        $dados["nova_data_pactuada"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("novaDataPactuada")))));
        $dados["data_termino"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataTermino")))));

        $dados["assunto_tratativa"] = $this->input->post_get('assunto');
        $dados["responsavel"] = $this->input->post_get('responsavel');
        $dados["desc_status"] = $this->input->post_get('status');

        if (empty($dados["id_gestao_tratativa"])) {
            $retorno = $this->Tb_gestao_tratativa->insereGestaoTratativa($dados);
        }
        echo (json_encode($retorno));
                        
    }

     public function recuperaGestaoTratativa() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");

        $Dados = $this->Tb_gestao_tratativa->recuperaGestaoTratativa($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                if ($lista->st == "" or NULL){
                    $lista->st = "Aberto";

                     $providencia = "<button type='button' class='btn btn-danger' href='javascript:void(0);'  onclick=\"modalSituacao({$lista->id_gestao_tratativa},'{$lista->st}')\"; data-toggle='tooltip' data-placement='top'><i class='fa fa-close'></i></button>";

                     $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='ReturnEditarGestaoTratativa(" . $lista->id_gestao_tratativa . ");' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fa fa-pencil'></i></button>";

                  } 
                  else {
                     $lista->st = "Fechado";

                      $providencia = "<button type='button' class='btn btn-success' href='javascript:void(0);' onclick=\"modalSituacao({$lista->id_gestao_tratativa},'{$lista->st}')\"; data-toggle='tooltip' data-placement='top'><i class='fa fa-check'></i></button>";

                      $acao = "<button type='button' class='btn btn-default' data-toggle='tooltip' title='Gestão tratativa Fechada não pode ser alterado' data-placement='top'><i class='fa fa-pencil'></i></button>";
                  }
                  
                 $descricao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'modalStatus(". $lista->id_gestao_tratativa.")'><i class = 'fa fa-eye'></i></button>";
                
                
                $acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirGestaoTratativa(". $lista->id_gestao_tratativa.")'><i class = 'fa fa-trash'></i></button>";
            
                $retorno["data"][] = array(
                    'PERIODO' => $lista->periodo_referencia,
                    'STATUS' =>  $lista->st,
                    'ASSUNTO' => $lista->assunto,
                    'ORIGEM' => $lista->origem,
                    'RESPONSAVEL' => $lista->responsavel,
                    'DATA_SOLICITACAO' => $lista->solicitacao,
                    'DATA_TERMINO' => $lista->data_termino,
                    'DESCRICAO' => $descricao,
                    'PROVIDENCIA' => $providencia,
                    'USUARIO' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

        public function modalStatus () {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["id_gestao_tratativa"] = $this->input->post_get('id_gestao_tratativa');
        $dados["periodo"] = $this->input->post_get('periodo');

        $DadosServico = $this->Tb_gestao_tratativa->modalStatus($dados);

        foreach ($DadosServico as $lista) {
            $dados['descricao']= $lista->desc_status;   
        }
        echo (json_encode($dados));
    }

    public function insereProvidencia() {
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_gestao_tratativa"] = $this->input->post_get('id_gestao_tratativa');

        $dados["status"] = $this->input->post_get('status');
        $dados["providencia"] = $this->input->post_get('providencia');
                        
           if (!empty($dados["id_gestao_tratativa"])) {
            $this->Tb_gestao_tratativa->insereProvidencia($dados);
        }
        $retorno['status']= $this->input->post_get('status');
        echo (json_encode($retorno));
            
    }
//------------------------------------------------------------------------------------------------------
    public function gestao_tratativaNaoAtv(){
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["atividade"] = false;
        $dados["gestao"] = false;
        $NaoAtividade = $this->Tb_gestao_tratativa->gestao_tratativaNaoAtv($dados);
        $dados["data"] = array();

        if(!empty($NaoAtividade)){
            $dados["atividade"] = true;
            foreach($NaoAtividade as $lista){

                $dados["data"][] = array(
                    'atividademes' => $lista->atividademes,
                    'ultima_alteracao' => $lista->ultima_alteracao,
                    'usuario' => $lista->nome,
                    'acoes' => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"NaoHouveAtividadedaq({$lista->id})\">
                    <i class='fa fa-trash'></i></a>"
                );
            }  
        }else{
			$Dados = $this->Tb_gestao_tratativa->recuperaGestaoTratativa($dados);

			if(count($Dados) > 0){
				$dados['gestao'] = true;
			}
		}
        echo (json_encode($dados));
    }
//------------------------------------------------------------------------------------------------------
     public function recuperaProvidencia() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["id_gestao_tratativa"] = $this->input->post_get('id_gestao_tratativa');
        $dados["st"]= $this->input->post_get('st');

        $Dados = $this->Tb_gestao_tratativa->recuperaProvidencia($dados);   
        $retorno["data"] = Array();
         if (  $dados["st"]=== "Fechado"){
                    $acao = "--";
                }else {foreach ($Dados as $lista) {
                     $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirProvidencia(". $lista->id_providencia.")'><i class = 'fa fa-trash'></i></button>";
               } }

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
               
                $retorno["data"][] = array(
                    'status'=> $lista->st,
                    'DESCRICAO' => $lista->providencia,
                    'USUARIO' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

       public function excluirProvidencia() {
        $dados["id_providencia"] = $this->input->post_get('id_providencia');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_gestao_tratativa->excluirProvidencia($dados);
        echo (json_encode($retorno));
    }
//------------------------------------------------------------------------------------------------------
       public function excluirGestaoTratativa() {
        $dados["id_gestao_tratativa"] = $this->input->post_get('id_gestao_tratativa');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_gestao_tratativa->excluirGestaoTratativa($dados);
        echo (json_encode($retorno));
    }

//------------------------------------------------------------------------------------------------------
    public function insereNaoAtividade(){
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["periodo"] = $this->input->post_get('periodo');
        $retorno = $this->Tb_gestao_tratativa->insereNaoAtividadeGestao($dados);
        echo (json_encode($retorno));
    }


//-------------------------------------------------------------------------------------------------------------
    public function NaoHouveAtividadedaq(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_contrato"] = $this->session->idContrato;
        $dados["id"] = $this->input->post_get('id');
        $retorno = $this->Tb_gestao_tratativa->NaoHouveAtividadedaq($dados);
        echo (json_encode($retorno));

    }
//--------------------------------------------------------------------------------------------------------------

        public function ReturnEditarGestaoTratativa() {

            $dados["id_licenca_ambiental"] = $this->input->post_get('id_licenca_ambiental');
            $dados["idContrato"] = $this->session->idContrato;
            $dados["periodo"] = $this->input->post_get("periodo");
            
            $DadosServico  = $this->Tb_gestao_tratativa->recuperaGestaoTratativa($dados);
        
              foreach ($DadosServico as $lista) {
          
            $dados['id_gestao_tratativa']= $lista->id_gestao_tratativa;
            $dados['origem_edita']= $lista->id_origem;
            $dados['dataSolicitacao_edita']= $lista->solicitacao;
            $dados['assunto_edita']= $lista->assunto;
            $dados['responsavel_edita']= $lista->id_responsavel;
            $dados['dataPactuada_edita']= $lista->data_pactuada;
            
            $dados['novaDataPactuada_edita']= $lista->nova_data_pactuada;
            $dados['dataTermino_edita']= $lista->data_termino;
            $dados['status_edita']= $lista->desc_status;
        }
        echo (json_encode($dados));
    }

    public function editarGestaoTratativa() {

        $dados["id_gestao_tratativa"] = $this->input->post_get('editar');
        $dados["idUsuario"] = $this->session->id_usuario_daq;

       
        $dados["novaDataPactuada_edita"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("novaDataPactuada_edita")))));
        $dados["dataTermino_edita"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataTermino_edita")))));
        $dados["status_edita"] = $this->input->post_get('status_edita');
        
        $retorno = $this->Tb_gestao_tratativa->editarGestao($dados);
       
        echo (json_encode($retorno));

    }


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################

 
