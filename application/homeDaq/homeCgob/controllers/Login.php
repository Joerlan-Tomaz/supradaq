<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database('DAQ', TRUE);
        $this->load->model('Tb_usuario');
//		$this->load->model('homeDif/Supervisaodif/Tb_perfil');
//		$this->load->model('homeDaq/SolicitacaoAcesso/Tb_perfil');
        $this->load->model('Mensagem/Msg_entrada');
        $this->load->model('Mensagem/Msg_saida');
        $this->load->model('Mensagem/Msg_resposta');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {

        if (!empty($this->session->id_usuario)) {
            redirect(base_url("Home"));
        } else {
            $this->load->view('login');
        }
    }

    public function validar_login() {
        $email = $this->input->post('nume_matricula');
        $senha = $this->input->post('codi_senha');
        $retorno = $this->Tb_usuario->validar_login($email, md5($senha));
        if (!empty($retorno) && $this->atualizaSessao($retorno[0]->ID_USUARIO)) {
			$retorno = true;
        } else {
			$retorno = false;
        }

        die (json_encode($retorno, true));
    }

    public function ajax_redirect($location = '') {
        $retorno = $this->Tb_usuario->recuperaUsuarioSessao();

        if (empty($retorno)) {
            $this->Tb_usuario->iniciaSessaoInsert();
        } else {
            foreach ($retorno as $r) {
                $dados["data"] = date('Y-m-d H:i:s', $r->timestamp);
            }
            $this->Tb_usuario->finalizaSessao($dados);
            $this->Tb_usuario->iniciaSessaoUpdate();
        }
        $this->Tb_usuario->alteraUltimoAcesso();
        $this->Tb_usuario->historicoLogin();

        $location = $this->input->post('location'
                . '');
        $location = empty($location) ? '/' : $location;
        if (strpos($location, '/') !== 0 || strpos($location, '://') !== false) {
            if (!function_exists('base_url')) {
                $this->load->helper('url');
            }

            $location = base_url($location);
        }
        $script = "window.location='{$location}';";
        $this->output->enable_profiler(false)
                ->set_content_type('application/x-javascript')
                ->set_output($script);
    }

    public function alterasenha() {
        $dados["id_usuario"] = $this->session->id_usuario;
        $dados["edtAtual"] = md5($this->input->post_get("edtAtual"));

        $validaSenha = $this->Tb_usuario->validaSenha($dados);
        $count = count($validaSenha);

        if ($count > 0) {
            $dados["senhaNova"] = md5($this->input->post_get("edtNova"));
            if (!empty($dados["senhaNova"])) {
                $this->Tb_usuario->alteraSenha($dados);
                $this->Tb_usuario->novoPrazo($dados);
                $dados["mensagem"] = "Senha alterada com sucesso!";
                $dados["notify"] = "success";
            } else {
                $dados["mensagem"] = "Erro durante alteração!";
                $dados["notify"] = "warning";
            }
        } else {
            $dados["mensagem"] = "Senha atual nao corresponde!";
            $dados["notify"] = "warning";
        }

        die(json_encode($dados, true));
    }

    public function buscaUsuario() {
        $dados["id_usuario"] = $this->session->id_usuario;

        $buscaUsuario = $this->Tb_usuario->buscaUsuario($dados);
        foreach ($buscaUsuario as $u) {
            $dados["DATA_ULTIMOACESSO"] = $u->DATA_ULTIMOACESSO;
            $dados["email"] = $u->email;

            $cpf = preg_replace("/[^0-9]/", "", $u->cpf);
            $bloco_1 = substr($cpf, 0, 3);
            $bloco_2 = substr($cpf, 3, 3);
            $bloco_3 = substr($cpf, 6, 3);
            $dig_verificador = substr($cpf, -2);
            $dados["cpf"] = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;

            $dados["telefone"] = $u->TELEFONE;

            $dados["titularidade"] = $u->titularidade;
            $dados["formacao"] = $u->formacao;
            $dados["area_atuacao"] = $u->area_atuacao;
            $dados["localizacao"] = $u->localizacao;
            $dados["curriculo_resumido"] = $u->curriculo_resumido;
            $dados["telefone_adicional"] = $u->telefone_adicional;

            if (!empty($u->id_upload)) {
                $dados["foto"] = "<img class='profile-user-img img-responsive img-circle' src='" . base_url("assets/img/users/") . $u->id_upload . "' alt='' style='height: 100px;'>";
            } else {
                $dados["foto"] = "<img class='profile-user-img img-responsive img-circle' src='" . base_url("assets/img/users/default_user.png") . "' alt=''>";
            }
        }

        die(json_encode($dados, true));
    }

    public function FotoMiniatura() {

        $qtdMensagem = $this->Tb_usuario->RecuperaQtdMensagem();
        $num = 0;
        if (!empty($qtdMensagem)) {

            foreach ($qtdMensagem as $lista) {
                $num += $lista->qtdMensagem;
            }
        }

        //--------------------------------------

        $Dados = $this->Tb_usuario->RecuperaFotoUsuario();

        if (!empty($Dados)) {

            foreach ($Dados as $lista) {
                echo "<span style='position: relative;  font-size: 9px; padding: 2px 3px;  background-color: #00a65a !important;   border-radius: .25em;  left: 50px;bottom: 15px;'>" . $num . "</span> <img src='" . base_url("assets/img/users/") . $lista->id_upload . "' alt='' style='width: 45px; border-radius: 50%;height: 45px;'>";
            }
        } else {
            echo "<span style='position: relative;  font-size: 9px; padding: 2px 3px;  background-color: #00a65a !important;   border-radius: .25em;  left: 50px;bottom: 15px;'>" . $num . "</span> <img src='" . base_url("assets/img/users/default_user.png") . "' alt='' style='width: 45px; border-radius: 50%;height: 45px;'>";
        }
    }

    public function logout() {
        $dados["data"] = date('Y-m-d H:i:s');
        if(isset($this->session->id_usuario)){
        	$this->Tb_usuario->finalizaSessao($dados);
		}
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function alteraSobreMim() {
        $dados['telefone'] = $this->input->post_get("telefone_adicional");
        $dados['titularidade'] = $this->input->post_get("titularidade");
        $dados['formacao'] = $this->input->post_get("formacao");
        $dados['area_atuacao'] = $this->input->post_get("area_atuacao");
        $dados['localizacao'] = $this->input->post_get("localizacao");
        $dados['curriculo_resumido'] = $this->input->post_get("curriculo_resumido");
        $dados['foto'] = null;
        $dados['id_upload'] = null;
        $dados['id_usuario'] = $this->session->id_usuario;

        if (isset($_FILES['arquivo'])) {
            $arquivo = $_FILES['arquivo'];
            $maxsize = 1024 * 1024 * 5;
            if ($maxsize > $arquivo["size"]) {
                $extensao = @end(explode('.', $arquivo["name"]));
                if (($extensao === "jpg") || ($extensao === "jpeg")) {
                    $dir = FCPATH . "assets/img/users/";
                    $nameArray = explode('.', $arquivo["name"]);
                    $nName = count($nameArray) - 1;
                    $name = "";
                    for ($i = 0; $i < $nName; $i++) {
                        $name .= $nameArray[$i] . ".";
                    }
                    $dados['foto'] = $arquivo["name"];
                    $dados['id_upload'] = $nomeArquivo;
                    $name = substr_replace($name, '', -1);
                    $nomeArquivo = mt_rand() . "_" . $this->session->id_usuario . ".$extensao";
                    move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);
                }
            }
        }


        $dadosUsuario = $this->Tb_usuario->RecuperaFotoUsuario();

        if (empty($dadosUsuario)) {
            $insert = $this->Tb_usuario->insereSobreMim($dados);
        } else {
            $insert = $this->Tb_usuario->alteraSobreMim($dados);
        }


        $retorno["mensagem"] = "Cadastro Realizado com Sucesso!";
        $retorno["notify"] = "success";

        echo (json_encode($retorno));
    }

    public function LinhaTempo() {

        $DadosLinhaTempo = $this->Tb_usuario->RecuperaLinhaTempo();

        $dados["id"] = array();
        if (!empty($DadosLinhaTempo)) {
            $n = 0;
            foreach ($DadosLinhaTempo as $lista) {
                $dados ['supervisora'] [$n] = $lista->supervisora;
                $dados ['fiscal'] [$n] = $lista->fiscal;
                $dados ['motivo'] [$n] = $lista->motivo;
                $dados ['idrelatorio'] [$n] = $lista->idrelatorio;
                $dados ['aceite'] [$n] = $lista->aceite;
                $dados ['id'] [$n] = $lista->id;
                $dados ['id_contrato_obra'] [$n] = $lista->id_contrato_obra;
                $dados ['data_cadastro'] [$n] = $lista->data_cadastro;
                $dados ['nome'] [$n] = $lista->nome;
                $dados ['roteiro'] [$n] = $lista->roteiro;
                $dados ['contrato'] [$n] = $lista->contrato;
                $dados ['id_roteiro'] [$n] = $lista->id_roteiro;
                $n++;
            }
        }

        echo (json_encode($dados));
    }

    public function atualizaMensagemLida() {
        $dados["id_roteiro"] = '2';
        $dados['id_usuario'] = $this->session->id_usuario;
        $this->Msg_saida->atualizaMensagemLida($dados);

        $retorno = $this->Msg_resposta->atualizaRespostaLida($dados);

        echo (json_encode($retorno));
    }

    public function MensagemPerfil() {

        $DadosMensagem = $this->Tb_usuario->RecuperaMensagemPerfil();
        $dados["id_mensagem"] = array();
        $n = 0;
        foreach ($DadosMensagem as $lista) {
            $dados ['id_mensagem'] [$n] = $lista->id_mensagem;
            $dados ['remetente'] [$n] = $lista->remetente;
            $dados ['id_remetente'] [$n] = $lista->id_remetente;
            $dados ['assunto'] [$n] = $lista->assunto;
            $dados ['mensagem'] [$n] = $lista->mensagem;
            $dados ['data_cadastro'] [$n] = $lista->data_cadastro;
            $dados ['destinatario'] [$n] = $lista->destinatario;
            $dados ['id_destinatario'] [$n] = $lista->id_destinatario;
            $dados ['id_roteiro'] [$n] = $lista->id_roteiro;
            $dados ['flag_lido'] [$n] = $lista->flag_lido;
            $dados ['data_lido'] [$n] = $lista->data_lido;

            $n++;
        }

        echo (json_encode($dados));
    }

    public function RecuperaRemetente() {

        $DadosRemetente = $this->Tb_usuario->RecuperaRemetente();

        foreach ($DadosRemetente as $lista) {
            $dados ['id_usuario'] = $lista->id_usuario;
            $dados ['desc_nome'] = $lista->desc_nome;
        }

        echo (json_encode($dados));
    }

    public function RecuperaDestinatario() {

        $DadosDestinatario = $this->Tb_usuario->RecuperaDestinatario();
        $n = 0;
        foreach ($DadosDestinatario as $lista) {
            $dados ['id_usuario'] [$n] = $lista->id_usuario;
            $dados ['desc_nome'] [$n] = $lista->desc_nome;
            $n++;
        }
        echo (json_encode($dados));
    }

    public function insereMensagem() {

        //INSERE TABLE MSG_ENTRADA
        $dados["id_usuario_remetente"] = $this->session->id_usuario;
        $dados["assunto_mensagem"] = $this->input->post_get('assunto_mensagem');
        $dados["descricao_mensagem"] = $this->input->post_get('descricao_mensagem');

        $this->Msg_entrada->insereEntrada($dados);

        //RECUPERAR ID MENSAGEM
        $dados["idUsuario"] = $this->session->id_usuario;
        $DadosMensagem = $this->Msg_entrada->RecuperaDadosMensagem($dados);
        foreach ($DadosMensagem as $lista) {
            $id_mensagem = $lista->id_mensagem;
        }

        //INSERE TABLE MSG_SAIDA
        $dados["id_mensagem"] = $id_mensagem;
        $dados["id_usuario_destinatario"] = $this->input->post_get('id_usuario_destinatario');
        $dados["idContrato"] = null;
        $dados["id_roteiro"] = 2; //perfil usuario
        $dados["flag_lido"] = 'N';

        $retorno = $this->Msg_saida->insereSaida($dados);

        echo (json_encode($retorno));
    }

    public function PerfilResposta() {
        $dados["id_mensagem"] = $this->input->post_get('id_mensagem');

        $DadosResposta = $this->Tb_usuario->RecuperaPerfilResposta($dados);
        $dados["id_resposta"] = array();
        $n = 0;
        foreach ($DadosResposta as $lista) {
            $dados ['id_resposta'] [$n] = $lista->id_resposta;
            $dados ['resposta'] [$n] = $lista->resposta;
            $dados ['usuario'] [$n] = $lista->usuario;
            $dados ['data_cadastro'] [$n] = $lista->data_cadastro;

            if ($lista->id_usuario == $this->session->id_usuario) {
                $dados ['send_by_me'] [$n] = 1;  //True
            } else {
                $dados ['send_by_me'] [$n] = 2;  //False
            }

            if (!empty($lista->id_upload)) {
                $dados["foto"] [$n] = $lista->id_upload;
            } else {
                $dados["foto"] [$n] = "default_user.png";
            }

            $n++;
        }

        echo (json_encode($dados));
    }

    public function insereResposta() {

        //INSERE TABLE MSG_RESPOSTA
        $dados["id_mensagem"] = $this->input->post_get('id_mensagem');

        if ($this->input->post_get('id_destinatario') == $this->session->id_usuario) {
            $dados["id_destinatario"] = $this->input->post_get('id_remetente');
        } else {
            $dados["id_destinatario"] = $this->input->post_get('id_destinatario');
        }
        //$dados["id_destinatario"] = $this->input->post_get('id_destinatario');
        //$dados["id_remetente"] = $this->input->post_get('id_remetente');

        $dados["resposta"] = $this->input->post_get('resposta');
        $dados["id_usuario"] = $this->session->id_usuario;
        $dados["publicar"] = 'S';
        $dados["flag_lido"] = 'N';

        $retorno = $this->Msg_resposta->insereResposta($dados);

        echo (json_encode($retorno));
    }

    public function excluiResposta() {

        $dados["id_resposta"] = $this->input->post_get('id_resposta');
        $dados["id_usuario"] = $this->session->id_usuario;
        $retorno = $this->Msg_resposta->excluiResposta($dados);

        echo (json_encode($retorno));
    }

    public function atualizaSessao($id_usuario){
		$this->load->model('homeDaq/SolicitacaoAcesso/Tb_perfil');
		$this->load->model('homeDif/SolicitacaoAcesso/Tb_usuario_contrato_obra');
    	$dados['id_usuario'] = $id_usuario;
    	try{
			$dadosUsuario = $this->Tb_usuario->buscaUsuario($dados);
			$permissoesTelasDAQ = ($dadosUsuario[0]->ID_PERFIL_DAQ != null) ? $this->Tb_perfil->buscaPermissoesTelas($dadosUsuario[0]->ID_PERFIL_DAQ) : array();
			$permissoesContratosDaq = $this->Tb_perfil->buscaPermissoesUsuarioContrato($dadosUsuario[0]->ID_USUARIO);

			$permissoesTelasDIF = ($dadosUsuario[0]->ID_PERFIL_DIF != null) ? $this->Tb_usuario_contrato_obra->buscaPermissoesTelas($dadosUsuario[0]->ID_PERFIL_DIF) : array();
			$permissoesContratosDif = $this->Tb_usuario_contrato_obra->buscaPermissoesUsuarioContrato($dadosUsuario[0]->ID_USUARIO);

			$log = array(
				'desc_nome' => $dadosUsuario[0]->DESC_NOME,
				'id_perfil' => $dadosUsuario[0]->ID_PERFIL,
				'id_perfil_daq' => $dadosUsuario[0]->ID_PERFIL_DAQ,
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
		}catch (Exception $e){
    		return false;
		}
	}
}
