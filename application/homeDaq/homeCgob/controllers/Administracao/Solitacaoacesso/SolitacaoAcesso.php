<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SolitacaoAcesso extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Tb_usuario');
        $this->load->model('Tb_uf');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        $this->load->library('ControleSessao');
        $sessao = new ControleSessao();
        $sessao->verificaSessaoTempo();
    }

    public function recuperaSolicitacaoAcesso() {
        $arquivo = file(FCPATH . "assets/captcha/data/cgob/cgob.txt");
        $dados["data"] = array();
        $count = count($arquivo);
        for ($i = 0; $i < $count; $i++) {
            $linha = $arquivo[$i];
            $lista = explode(";", $linha);
            $dados["email"]=$lista[1];
            $dadosEmail = $this->Tb_usuario->RecuperaEmail($dados);
            
            if (empty($dadosEmail)) {
                $nbr_cpf = $lista[5];
                
                if(!empty( $lista[9])){
                $modal = $lista[9];
                }else{
                $modal='Motivo não informado!' ;   
                }
                
                $parte_um = substr($nbr_cpf, 0, 3);
                $parte_dois = substr($nbr_cpf, 3, 3);
                $parte_tres = substr($nbr_cpf, 6, 3);
                $parte_quatro = substr($nbr_cpf, 9, 2);
                $cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";

                $acao = "<a href='javascript:void(0);'><span class='btn btn-default' title='Motivação'";
                $acao .= "onclick=\"modal_motivacao_acesso('".$modal."')\"><i class='fa fa-navicon'></i></span></a>";
                $acao .= "  ";
                $acao .= "<a href='javascript:void(0);'><span class='btn btn-default' title='Aceitar Acesso'";
                $acao .= "onclick=\"insereUsuario('$i','{$lista[0]}','{$lista[1]}','{$lista[2]}','{$lista[3]}','{$lista[4]}','{$lista[5]}','{$lista[6]}','{$lista[7]}','{$lista[8]}')\"><i class='fa fa-plus'></i></span></a>";
                $acao .= "  ";
                $acao .= "<a href='javascript:void(0);'><span class='btn btn-default' title='Negar Acesso'";
                $acao .= "onclick=\"negaSolicitacao('$i')\"><i class='fa  fa-close'></i></span></a>";

                $dados['data'][] = array(
                    'nome' => $lista[0],
                    'email' => $lista[1],
                    'empresa' => $lista[2],
                    'data' => date('d/m/Y H:s:m', strtotime($lista[4])),
                    'cpf' => $cpf,
                    'telefone' => $lista[6],
                    'coordenacao' => $lista[7],
                    'uf' => $lista[8],
                    'acao' => $acao
                );
            }
        }


        echo (json_encode($dados));
    }

    public function insereUsuario() {
        $dados["id"] = $this->input->post_get('id');
        $dados["nome"] = $this->input->post_get('nome');
        $dados["email"] = $this->input->post_get('email');
        $dados["empresa"] = $this->input->post_get('empresa');
        $dados["codigo"] = $this->input->post_get('codigo');
        $dados["data"] = $this->input->post_get('data');
        $dados["cpf"] = $this->input->post_get('cpf');
        $dados["telefone"] = $this->input->post_get('telefone');
        $dados["coordenacao"] = $this->input->post_get('coordenacao');
        $dados["uf"] = $this->input->post_get('uf');

        $dadosUF = $this->Tb_uf->recuperaUF($dados);
        foreach ($dadosUF as $u) {
            $dados["id_uf"] = $u->id_uf;
        }

        $this->Tb_usuario->insereUsuario($dados);
        $arquivo = file(FCPATH . "assets/captcha/data/cgob/cgob.txt");
        unset($arquivo[$dados["id"]]);

        $arq = fopen(FCPATH . "assets/captcha/data/cgob/cgob.txt", "w");

        foreach ($arquivo as $conteudo) {
            fwrite($arq, $conteudo);
        }
        fclose($arq);
        echo (json_encode($dados));
    }

    public function negaSolicitacao() {
        $dados["id"] = $this->input->post_get('id');
        $arquivo = file(FCPATH . "assets/captcha/data/cgob/cgob.txt");
        unset($arquivo[$dados["id"]]);

        $arq = fopen(FCPATH . "assets/captcha/data/cgob/cgob.txt", "w");

        foreach ($arquivo as $conteudo) {
            fwrite($arq, $conteudo);
        }
        fclose($arq);
        echo (json_encode($dados));
    }

}
