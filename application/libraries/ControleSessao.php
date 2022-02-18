<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ControleSessao
{

//    public function __construct() {
//        parent::__construct();
//        $this->load->database();
//        $this->load->model('Tb_usuario');
//        $this->load->helper('url');
//        $this->load->library('session');
//    }

    public function verificaSessaoExpirada()
    {
        $CI = & get_instance();
        $CI->load->library('session');
        if (empty($CI->session->id_usuario))
        {
            $dados["data"] = date('Y-m-d H:i:s');
            $CI->session->sess_destroy();
            redirect(base_url());
        }
    }

    public function verificaSessaoTempo()
    {
        $CI = & get_instance();
        $CI->load->database();
        $CI->load->model('Tb_usuario');
        $CI->load->library('session');
        $time = $this->tempoSessaoPerfil();
        if ($time > 0)
        {
            $retorno = $CI->Tb_usuario->recuperaUsuarioSessao();
            foreach ($retorno as $r)
            {
                if ($r->timestamp < (time() - $time))
                {
                    $dados["data"] = date('Y-m-d H:i:s', $r->timestamp);
                    $CI->Tb_usuario->finalizaSessao($dados);
                    $CI->session->sess_destroy();
                    redirect(base_url());
                }
            }
        } else
        {
            $CI->Tb_usuario->iniciaSessaoUpdate();
        }
//        if (empty($this->session->id_usuario))
//        {
//            redirect(base_url("/Login"));
//        }
    }

    private function tempoSessaoPerfil()
    {
        $CI = & get_instance();
        $CI->load->library('session');
        $time = 0;
//        switch ($CI->session->id_usuario) {
//            case 1560:
//                $time = 20;
//                break;
//            case 1861:
//                $time = 20;
//                break;
//        }

        return $time;
    }

}
