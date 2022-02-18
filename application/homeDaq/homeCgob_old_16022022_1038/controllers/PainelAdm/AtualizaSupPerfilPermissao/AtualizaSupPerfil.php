<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AtualizaSupPerfil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/SolicitacaoAcesso/Tb_perfil');
        $this->load->model('/SolicitacaoAcesso/Tb_Tela_Acesso');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
    }

	public function mostraViewPerfil(){
		$this->load->view('/homeAdministracao/AtualizaSupPerfilPermissao/mostraViewPerfil');
	}

	public function recuperaPerfil(){
		$todosPerfil = $this->Tb_perfil->buscaDadosPerfil();

		$retorno = array();
		if(count($todosPerfil) > 0){
			foreach($todosPerfil as $i => $perfil){
				$retorno['data'][$i]['perfil'] = $perfil->desc_perfil;
				$retorno['data'][$i]['coordenacao'] = $perfil->coordenacao;
				$retorno['data'][$i]['status'] = ($perfil->status == 'S') ? 'Ativo' : 'Inativo';
				$retorno['data'][$i]['usuario'] = ($perfil->usuario == null) ? '' : $perfil->usuario;
				$retorno['data'][$i]['alteracao'] = ($perfil->ultima_atualizacao == null) ? '' : $perfil->ultima_atualizacao;

				$acao = "<a href='javascript:void(0);'><span class='btn btn-default' title='Alterar Perfil' onclick=\"alterarPerfil(".$perfil->id_perfil.",'".$perfil->desc_perfil."')\"><i class='fa fa-navicon'></i></span></a>";
				$retorno['data'][$i]['acao'] = $acao;
			}
		}
		echo (json_encode($retorno));
	}

	public function painelAdmInserirTela(){
    	$inserirTela = $this->Tb_Tela_Acesso->inserirTela();

		echo (json_encode($inserirTela));
	}

	public function painelAdmTelas(){
    	$telas = $this->Tb_Tela_Acesso->buscaTelas();

		echo (json_encode($telas));
	}

	public function painelAdmInserirPerfil(){
    	$perfil = $this->Tb_perfil->inserirPerfil();

		echo (json_encode($perfil));
	}

	public function painelAdmVincularPerfilTela(){
    	$vincularTela = $this->Tb_perfil->vincularPerfil();

		echo (json_encode($vincularTela));

	}
}
