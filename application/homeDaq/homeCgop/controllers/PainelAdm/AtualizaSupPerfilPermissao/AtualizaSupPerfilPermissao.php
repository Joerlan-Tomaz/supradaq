<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AtualizaSupPerfilPermissao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Tb_usuario');
        $this->load->model('/SolicitacaoAcesso/Tb_solicitacao_acesso');
        $this->load->model('/SolicitacaoAcesso/Tb_usuario_contrato_obra');
		$this->load->model('/Supervisaodaq/Tb_contrato_supervisora');
		$this->load->model('/Supervisaodaq/Tb_contrato_obra');
        // $this->load->model('Tb_uf');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
    }
    
    public function mostraViewAtualizaSupPerfilPermissao(){
        $this->load->view('/homeAdministracao/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissaoView');
    }

    public function RecuperaInfoUsuario() {
        $info_usuarios = $this->Tb_usuario->RecuperaInfoUsuario();
        $retorno["data"] = array();
        foreach ($info_usuarios as $lista){
            $acao = "<a href='javascript:void(0);'><span class='btn btn-default' title='Motivação' onclick=\"modalAtualizaPerfil('".$lista->id_usuario."')\"><i class='fa fa-navicon'></i></span></a>";

            $retorno['data'][] = array(
                'nome' => $lista->DESC_NOME,
                'email' => $lista->EMAIL,
                'perfil' => $lista->desc_perfil,
                'supervisora' => $lista->no_empresa,
                'empresa' => $lista->empresa,
                'acao' => $acao
            );
        }
        echo (json_encode($retorno));
    }

    public function populaPerfil() {
        $dadosPerfil = $this->Tb_usuario->populaPerfil();
        $dadosUsuario = $this->Tb_usuario->buscaUsuario($_REQUEST);
        $dados = array();
        foreach ($dadosPerfil as $i => $lista) {
            $dados["perfil"][$i] = $lista->desc_perfil;
            $dados["codigoPerfil"][$i] = $lista->id_perfil;
            $dados["perfilAtivo"][$i] = (isset($dadosUsuario[0]->ID_PERFIL_DAQ) && $dadosUsuario[0]->ID_PERFIL_DAQ == $lista->id_perfil) ? 'selected' : '';
        }
        echo(json_encode($dados));
    }

    public function populaSupervisora() {
        $dadosSupervisao = $this->Tb_contrato_supervisora->buscaSupervisoras();
		$supervisaoUsuario = $this->Tb_usuario->buscaSupervisoraUsuario();
        foreach ($dadosSupervisao as $i => $lista) {
            $dados["nome_supervisora"][$i] = $lista->nome_supervisora;
            $dados["id_supervisora"][$i] = $lista->id_contrato_supervisora;
			if(is_array($supervisaoUsuario) && count($supervisaoUsuario) > 1){
				$dados["supervisaoAtiva"][$i] = '';
			}else{
				$dados["supervisaoAtiva"][$i] = (isset($supervisaoUsuario[0]->id_contrato_supervisora) && $supervisaoUsuario[0]->id_contrato_supervisora == $lista->id_contrato_supervisora) ? 'selected' : '';
			}
        }
        echo(json_encode($dados));
    }

    public function alteraPerfilPermissao_old() {
		if($this->Tb_usuario->alteraPerfilPermissao($_REQUEST,'DAQ') && $this->Tb_usuario_contrato_obra->vinculaUsuarioContratoObra($_REQUEST)){
                #--------------------------------------------------------------#
                #Recupera os dados do usuario para criar acesso no SUPRA    
                $Dados = $this->Tb_usuario->RecuperaDadosDaqParaAcessoSupra($_REQUEST); 
                
               
                
                foreach ($Dados as $lista) {
                    $dados["id_usuario"] = $lista->ID_USUARIO;
                    $dados["nome"] = $lista->DESC_NOME;
                    $dados["email"] = $lista->email;
                    $dados["empresa"] = $lista->empresa;
                    $dados["cpf"] = $lista->cpf;
                    $dados["telefone"] = $lista->telefone;
                    $dados["uf"] = $this->input->post_get('uf');
                }
                $this->Tb_usuario->insereUsuarioAcessoSupra($dados); 
                #--------------------------------------------------------------#
			echo (json_encode(true));
		}else{
			echo (json_encode(false));
		}
    }
    
    public function alteraPerfilPermissao() {
		if($this->Tb_usuario->alteraPerfilPermissao($_REQUEST,'DAQ') && $this->Tb_usuario_contrato_obra->vinculaUsuarioContratoObra($_REQUEST)){
                #--------------------------------------------------------------#
                #Recupera os dados do usuario para criar acesso no SUPRA    
                $Dados = $this->Tb_usuario->RecuperaDadosDaqParaAcessoSupra($_REQUEST); 
               // print_r($Dados);
               /// die();
                foreach ($Dados as $lista) {
                    $dados["id_usuario"] = $lista->ID_USUARIO;
                    $dados["nome"] = $lista->DESC_NOME;
                    $dados["email"] = $lista->email;
                    $dados["empresa"] = $lista->empresa;
                    $dados["cpf"] = $lista->cpf;
                    $dados["telefone"] = $lista->telefone;
                    $dados["id_uf"] = $this->input->post_get('uf');
                }
                #Verifica se usuário já tem cadastro no supra    
                $DadosSupra = $this->Tb_usuario->RecuperaDadosGestaoSupra($_REQUEST);
                

                foreach ($DadosSupra as $lista) {
                    $id_usuario_gestao_supra = $lista->ID_USUARIO;
                }
                if(empty($id_usuario_gestao_supra)){
                $this->Tb_usuario->insereUsuarioAcessoSupra($dados);
                }
                #--------------------------------------------------------------#
                	echo (json_encode(true));
		}else{
			echo (json_encode(false));
		}
    }
    
    
    
    

    public function buscaContratosUsuario(){
		$dados = $this->Tb_contrato_obra->buscaContratosUsuario();

		echo(json_encode($dados));
	}
}
