<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {

    private $view = array();

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('ControleSessao');
        $sessao = new ControleSessao();
        $sessao->verificaSessaoTempo();
    }

    public function index() {
        $log = array('nav' => $this->input->get("nav"),);
        $this->session->set_userdata($log);
        $this->load->template('home', 'home/home', $this->view);
    }

    public function home() {

        $this->load->database();
        $this->load->model("Tb_usuario");
        $viewHomeIsLoaded = false;

        $retorno = $this->Tb_usuario->recuperaUsuarioSessao();
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

        $qntPerfisCOORDENACOES = (!empty($this->session->id_perfil)) + (!empty($this->session->id_perfil_cgmrr)) + (!empty($this->session->id_perfil_cgpert));
        
        if($qntPerfisCOORDENACOES == 1)
        {
            // Tratamentos da CGCONT
            if ($this->session->id_perfil == 15 or $this->session->id_perfil == 14 or $this->session->id_perfil == 1 or $this->session->id_perfil == 3 or $this->session->id_perfil == 4) {
                if ($this->session->nav == "1") {
                    $this->load->view("homeCgcont/homeCGcont", $data);
                } else {
                    $this->load->view("home", $data);
                    $viewHomeIsLoaded = true;
                }
            }
        
            if ($this->session->id_perfil == 5 or $this->session->id_perfil == 6 or $this->session->id_perfil == 38 or $this->session->id_perfil == 9 or $this->session->id_perfil == 54) {
                $this->load->view("homeCgcont/homeCGcont", $data);
            }
        }
        
        // CGCONT: 8 = Analista Supervisora / 7 = Responsável Supervisora
        $perfilCGCONT = ($this->session->id_perfil == 7 or $this->session->id_perfil == 8 or $this->session->id_perfil == 2);
        $perfilCGCONTDemandas = ($this->session->id_perfil == 55 or $this->session->id_perfil == 56);
        // CGMRR: 48 = Responsável Supervisora
        $perfilCGMRR = ($this->session->id_perfil_cgmrr == 47 || $this->session->id_perfil_cgmrr == 48 );
        // CGCONT: 8 = Analista Supervisora / 7 = Responsável Supervisora
        $perfilCGPERT = (!empty($this->session->id_perfil_cgpert));
        
        // Case exista mais de um perfil, entrar na tela das diretorias (home).
        if($qntPerfisCOORDENACOES > 1)
        {
            if (!$viewHomeIsLoaded)
            {
                $this->load->view("home", $data);
            }
        }
        else
        {
            if ($perfilCGCONT) {
                $this->load->view("homeCgcont/homeSupervisaoCont/supervisaocontView", $data);
            } elseif ($perfilCGMRR) {
                redirect(base_url("cgmrr/relatorio-supervisao"));
            }
            elseif($perfilCGCONTDemandas)
            {
                $this->load->view("homeCgcont/homeGestaoDemandas/gestaoDemandasView", $data);
            }
        }
        
    }

    public function homePerfil() {
        $this->load->view('perfilUsuario');
    }

    public function workshop() {
        $this->load->view('workshop');
    }

    public function homeCgcont() {
        $data = array('Codigo' => "0", 'CodigoAviso' => "0", 'IdPerfil' => $this->session->id_perfil);
        $this->load->view('homeCgcont/homeCGcont', $data);
    }

    
    public function homeCgmrr() {
        $this->load->view('homeCgmrr/homeCgmrr');
    }

//    public function homeCgpert() {  
//           echo "ok ";die;
////        $this->load->view('homeCgpert/home');
//    }

    public function homeDir() {
        $this->load->view('homeDir/homeDir');
    }

    public function FotoMiniatura() {

        $Dados = $this->Tb_usuario->RecuperaFotoUsuario();

        if (!empty($Dados)) {

            foreach ($Dados as $lista) {
                echo '<img src="/supra/assets/img/users/' . $lista->foto . '" alt="" style="width: 45px; border-radius: 50%;height: 45px;">';
            }
        } else {
            echo '<img src="/supra/assets/img/users/default_user.png" alt="" style="width: 45px; border-radius: 50%;height: 45px;">';
        }
    }

    // public function homeDispeo() {
    //     $data['formProvidencia'] = $this->Form_providencia;
    //     $this->load->view('homeDir/homeDispeo/orcamentodispeoView', $data);
    // }
    // public function homeConfiguracoes() {
    //     $data['formProvidencia'] = $this->Form_providencia;
    //     $this->load->view('homeDir/homeDispeo/configuracoesdispeoView', $data);
    // }
}
