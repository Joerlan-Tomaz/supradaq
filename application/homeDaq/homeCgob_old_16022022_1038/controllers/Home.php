<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	private $view = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('ControleSessao');
		$this->load->database('DAQ', TRUE);
		$this->load->model("Tb_usuario");
		$this->load->model('SolicitacaoAcesso/Tb_perfil');
		$sessao = new ControleSessao();
		$sessao->verificaSessaoTempo();
	}


#------------------------------------------------------------------------------#    
	public function home_Daq()
	{
		$retornoDaq = $this->Tb_usuario->recuperaUsuarioSessao();

		foreach ($retornoDaq as $lista) {
			$id_perfil_daq = $lista->id_perfil;
		}
		$data = array('Codigo' => "0", 'CodigoAviso' => "0", 'IdPerfil' => $id_perfil_daq, 'idUsuario' => $this->session->id_usuario_daq);

		$qntPerfisCOORDENACOES = (!empty($id_perfil_daq));
		if ($qntPerfisCOORDENACOES == 1) {
			if ($this->session->nav == "1") {
				$this->load->view("Home/home_Daq", $data);
			} else {
				$this->load->view("home_daq", $data);
			}
		}
	}

	public function homeCgob()
	{

//------------------------------------------------------------------------------       
		$dados = array('Codigo' => "0", 'CodigoAviso' => "0", 'id_perfil_daq' => $this->session->id_perfildaq);
		$dados['id_usuario'] = $this->session->id_usuario_daq;
		$dadosUsuario = $this->Tb_usuario->buscaUsuario($dados);
		$permissoesTelasDAQ = ($dadosUsuario[0]->ID_PERFIL != null) ? $this->Tb_perfil->buscaPermissoesTelas($dadosUsuario[0]->ID_PERFIL) : array();
		$permissoesContratosDaq = $this->Tb_perfil->buscaPermissoesUsuarioContrato($dadosUsuario[0]->ID_USUARIO);
		$dados['permissao_telas'] = $permissoesTelasDAQ;

//------------------------------------------------------------------------------        
		$this->load->view('homeCgob', $dados);
	}

#-------------------------------------------------------------------------------#    


	public function home()
	{
		$this->load->database();
		$this->load->model("Tb_usuario");
		$this->load->model('homeDaq/SolicitacaoAcesso/Tb_perfil');
		$this->load->model('homeDif/SolicitacaoAcesso/Tb_usuario_contrato_obra');

		$retorno = $this->Tb_usuario->recuperaUsuarioSessao();
		$this->atualizaSessao();
		$data = array('Codigo' => "0", 'CodigoAviso' => "0", 'IdPerfil' => $this->session->id_perfil);

		foreach ($retorno as $lista) {
			if ($lista->FLAG_ALTERASENHA == "S") {
				$prazoSenha = date("Y-m-d H:i:s", $lista->prazoSenha);
				$prazoSenha = date('Y-m-d H:i:s', strtotime("+5 days", strtotime($prazoSenha)));
				if (strtotime($prazoSenha) < strtotime(date('Y-m-d H:i:s'))) {
					$data = array('Codigo' => 1, 'CodigoAviso' => 1, 'MensagemAviso' => "Altere sua senha!", 'IdPerfil' => $this->session->id_perfil);
				} else if (strtotime($prazoSenha) > strtotime(date('Y-m-d H:i:s'))) {
					$data_inicio = new DateTime($prazoSenha);
					$data_fim = new DateTime((date('Y-m-d H:i:s')));

					$dateInterval = $data_inicio->diff($data_fim);
					$dateInterval = $dateInterval->days + 1;
					if ($dateInterval <= 1) {
						$mensagem = "Altere sua senha em " . $dateInterval . " dia!";
					} else {
						$mensagem = "Altere sua senha em " . $dateInterval . " dias!";
					}
					$data = array('Codigo' => "1", 'CodigoAviso' => 1, 'MensagemAviso' => $mensagem, 'IdPerfil' => $this->session->id_perfil);
				}
			} else if ($lista->FLAG_ALTERASENHA == "N") {
				$prazoSenha = date("Y-m-d H:i:s", $lista->prazoSenha);
				$prazoSenha = date('Y-m-d H:i:s', strtotime("+4 month", strtotime($prazoSenha)));
				$avisoSenha = date('Y-m-d H:i:s', strtotime("-15 days", strtotime($prazoSenha)));
				if (strtotime($prazoSenha) < strtotime(date('Y-m-d H:i:s'))) {
					$this->Tb_usuario->expiraPrazoSenha();
					$this->Tb_usuario->novoPrazo();
					$data = array('CodigoAviso' => 1, 'MensagemAviso' => "Sua senha expirou!");
				} else if (strtotime($prazoSenha) > strtotime(date('Y-m-d H:i:s')) && strtotime($avisoSenha) < strtotime(date('Y-m-d H:i:s'))) {
					$data_inicio = new DateTime($prazoSenha);
					$data_fim = new DateTime((date('Y-m-d H:i:s')));

					$dateInterval = $data_inicio->diff($data_fim);
					$dateInterval = $dateInterval->days + 1;
					if ($dateInterval <= 1) {
						$mensagem = "Sua senha irá expirar em " . $dateInterval . " dia!";
					} else {
						$mensagem = "Sua senha irá expirar em " . $dateInterval . " dias!";
					}
					$data = array('Codigo' => "0", 'CodigoAviso' => 1, 'MensagemAviso' => $mensagem, 'IdPerfil' => $this->session->id_perfil);
				}
			}
		}

		if (count($this->session->permissao_telas_daq) == 1 && $this->session->permissao_telas_daq[0]->supervisao == 'DAQ') {
			if ($this->session->permissao_telas_daq[0]->tela == 'Menu Administrativo') {
				$this->load->view('homeDaq/homePainelAdm');
			} else if ($this->session->permissao_telas_daq[0]->tela == 'Menu Relatório de Supervisão') {
				$this->load->view('homeDaq/homeSupervisaoDaq');
			} else if ($this->session->permissao_telas_daq[0]->tela == 'Menu Painéis Gerenciais') {
				$this->load->view('homeDaq/painelgerencialdaq/homePainelGerencialView');
			} else if ($this->session->permissao_telas_daq[0]->tela == 'Menu Análise de Relatório') {
				$this->load->view('homeDaq/supervisaodaq/relatorioSupervisao/RelatorioSupervisaoView');
			} else if ($this->session->permissao_telas_daq[0]->tela == 'Menu Documenteção') {
				$this->load->view('homeDaq/documentacao/homeDocumentacaoView');
			}
		} else if (count($this->session->permissao_telas_dif) == 1 && $this->session->permissao_telas_dif[0]->supervisao == 'DIF') {
			if ($this->session->permissao_telas_dif[0]->tela == 'Menu Administrativo') {
				$this->load->view('HomeCgdif/homePainelAdm');
			} else if ($this->session->permissao_telas_dif[0]->tela == 'Menu Relatório de Supervisão') {
				$this->load->view('HomeCgdif/homeSupervisaoDif');
			} else if ($this->session->permissao_telas_dif[0]->tela == 'Menu Painéis Gerenciais') {
				$this->load->view('HomeCgdif/painelgerencialdif/painelGerencialView');
			} else if ($this->session->permissao_telas_dif[0]->tela == 'Menu Análise de Relatório') {
				$this->load->view('HomeCgdif/SupervisaoDif/supervisaoanalise/supervisaoanalise');
			} else if ($this->session->permissao_telas_dif[0]->tela == 'Menu Documenteção') {
				$this->load->view('HomeCgdif/SupervisaoDif/documentacao/DocumentacaoView');
			}
		} else {
			$this->load->view('newHome');
		}
//        $this->load->view("home", $data);
	}


	//------------------------------------------------------------------------------------------------------------------
	public function FotoMiniatura()
	{

		$Dados = $this->Tb_usuario->RecuperaFotoUsuario();

		if (!empty($Dados)) {

			foreach ($Dados as $lista) {
				echo '<img src="/supra/assets/img/users/' . $lista->foto . '" alt="" style="width: 45px; border-radius: 50%;height: 45px;">';
			}
		} else {
			echo '<img src="../../assets/img/users/default_user.png" alt="" style="width: 45px; border-radius: 50%;height: 45px;">';
		}
	}

	public function atualizaSessao()
	{
		$dados['id_usuario'] = $this->session->id_usuario;
		try {
			$dadosUsuario = $this->Tb_usuario->buscaUsuario($dados);

			$permissoesTelasDAQ = ($dadosUsuario[0]->ID_PERFIL_DAQ != null) ? $this->Tb_perfil->buscaPermissoesTelas($dadosUsuario[0]->ID_PERFIL_DAQ) : array();
			$permissoesContratosDaq = $this->Tb_perfil->buscaPermissoesUsuarioContrato($dadosUsuario[0]->ID_USUARIO);

			$permissoesTelasDIF = ($dadosUsuario[0]->ID_PERFIL_DIF != null) ? $this->Tb_usuario_contrato_obra->buscaPermissoesTelas($dadosUsuario[0]->ID_PERFIL_DIF) : array();
			$permissoesContratosDif = $this->Tb_usuario_contrato_obra->buscaPermissoesUsuarioContrato($dadosUsuario[0]->ID_USUARIO);

			$log = array(
				'desc_nome' => $dadosUsuario[0]->DESC_NOME,
				'id_perfil' => $dadosUsuario[0]->ID_PERFIL,
				'id_perfil_daq' => $dadosUsuario[0]->ID_PERFIL_DAQ,
				'id_perfil_dif' => $dadosUsuario[0]->ID_PERFIL_DIF,
				'email' => $dadosUsuario[0]->email,
				'id_usuario' => $dadosUsuario[0]->ID_USUARIO,
				'dt_Ultacesso' => $dadosUsuario[0]->DATA_ULTIMOACESSO,
				'boAlteraSenha' => $dadosUsuario[0]->FLAG_ALTERASENHA,
				'stPerfilFecharRelatorio' => $dadosUsuario[0]->fechar_relatorio,
				'empresa' => $dadosUsuario[0]->empresa,
				'id_uf' => $dadosUsuario[0]->id_uf,
				'alteraSenha' => $dadosUsuario[0]->FLAG_ALTERASENHA,
				'coordenacao' => $dadosUsuario[0]->coordenacao,
				'perfil_usuario' => $dadosUsuario[0]->perfil_usuario,
				'permissao_telas_daq' => $permissoesTelasDAQ,
				'permissao_telas_dif' => $permissoesTelasDIF,
				'permissao_contratos_daq' => $permissoesContratosDaq,
				'permissao_contratos_dif' => $permissoesContratosDif
			);

			$this->session->set_userdata($log);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

} 
