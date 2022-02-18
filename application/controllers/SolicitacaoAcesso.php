<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SolicitacaoAcesso extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Tb_usuario');
        //$this->load->helper('url');
        //if (empty($this->session->id_usuario)) {
        //    redirect(base_url());
        //}
    }

    public function codigoCaptcha() {
        $codigoCaptcha = substr(md5(time()), 0, 9);

        //############ Adiciona na sessão
        $log = array(
            'codigoCaptcha' => $codigoCaptcha
        );
        $this->session->set_userdata($log);

        echo (json_encode($codigoCaptcha));
    }

    public function insereSolicitacao() { 
        
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("Y-m-d H:i:s");

        $name = $this->input->post_get('acesso-nome');
        $email = $this->input->post_get('acesso-email');
        $empresa = $this->input->post_get('acesso-empresa');
        $cpf = $this->input->post_get('acesso-cpf');
        $telefone = $this->input->post_get('acesso-telefone');
        $coordenacao = $this->input->post_get('acesso-coordenacao');
        $captcha = $this->input->post_get('acesso-captcha');
        $uf = $this->input->post_get('acesso-uf');
        $motivo = $this->input->post_get('acesso-motivo');

        $captchaSessao = $this->session->codigoCaptcha;
        
        $name = str_replace('<', '', $name);
        $name = str_replace('>', '', $name);
        $name = str_replace('php', '', $name);
        $name = str_replace('?', '', $name);
        $name = str_replace('script', '', $name);
        $name = str_replace('@', '', $name);
        $name = str_replace('\'', '', $name);

        //-----------------------------------------------------------------------------------------------------------------------------------------------
        $empresa = str_replace('<', '', $empresa);
        $empresa = str_replace('>', '', $empresa);
        $empresa = str_replace('php', '', $empresa);
        $empresa = str_replace('?', '', $empresa);
        $empresa = str_replace('script', '', $empresa);
        $empresa = str_replace('@', '', $empresa);
        $empresa = str_replace('\'', '', $empresa);
        //-----------------------------------------------------------------------------------------------------------------------------------------------
        $email = str_replace('<', '', $email);
        $email = str_replace('>', '', $email);
        $email = str_replace('php', '', $email);
        $email = str_replace('?', '', $email);
        $email = str_replace('script', '', $email);
        $email = str_replace('\'', '', $email);
        //-----------------------------------------------------------------------------------------------------------------------------------------------
        $cpf = str_replace('.', '', $cpf);
        $cpf = str_replace('-', '', $cpf);
        $cpf = str_replace('<', '', $cpf);
        $cpf = str_replace('>', '', $cpf);
        $cpf = str_replace('php', '', $cpf);
        $cpf = str_replace('?', '', $cpf);
        $cpf = str_replace('script', '', $cpf);
        $cpf = str_replace('\'', '', $cpf);
        //-----------------------------------------------------------------------------------------------------------------------------------------------
        $telefone = str_replace('<', '', $telefone);
        $telefone = str_replace('>', '', $telefone);
        $telefone = str_replace('php', '', $telefone);
        $telefone = str_replace('?', '', $telefone);
        $telefone = str_replace('script', '', $telefone);
        $telefone = str_replace('\'', '', $telefone);
        //-----------------------------------------------------------------------------------------------------------------------------------------------
        $motivo = str_replace('<', '', $motivo);
        $motivo = str_replace('>', '', $motivo);
        $motivo = str_replace('php', '', $motivo);
        $motivo = str_replace('?', '', $motivo);
        $motivo = str_replace('script', '', $motivo);
        $motivo = str_replace('\'', '', $motivo);

        function validaCPF($cpf) {

            // Extrai somente os números
            $cpf = preg_replace('/[^0-9]/is', '', $cpf);

            // Verifica se foi informado todos os digitos corretamente
            if (strlen($cpf) != 11) {
                return false;
            }
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
            return true;
        }

        $dadosEmail = $this->Tb_usuario->validar_email($email);

        if (!validaCPF($cpf)) {
            $retorno = 2;
        } else if ($captcha != $captchaSessao) {
            $retorno = 3;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $retorno = 5;
        } else if (!empty($dadosEmail)) {
            $retorno = 4;
        } else {
            if ($coordenacao == 'CGCONT') {
                $quebra = chr(13) . chr(10); //essa é a quebra de linha
                $access = ($name . ';' . $email . ';' . $empresa . ';' . $captcha . ';' . $data . ';' . $cpf . ';' . $telefone . ';' . $coordenacao . ';' . $uf . ';' . $motivo . ';' . $quebra );

                $fp = fopen("assets/captcha/data/cgcont/cgcont.txt", "a");
                $escreve = fwrite($fp, $access);
                fclose($fp);
            }if ($coordenacao == 'CGMRR') {
                $quebra = chr(13) . chr(10); //essa é a quebra de linha 
                $access = ($name . ';' . $email . ';' . $empresa . ';' . $captcha . ';' . $data . ';' . $cpf . ';' . $telefone . ';' . $coordenacao . ';' . $uf . ';' . $motivo . ';' . $quebra );
                
                $fp = fopen("assets/captcha/data/cgmrr/cgmrr.txt", "a");
                $escreve = fwrite($fp, $access);
                fclose($fp);
            }if ($coordenacao == 'CGPERT') {
                $quebra = chr(13) . chr(10); //essa é a quebra de linha
                $access = ($name . ';' . $email . ';' . $empresa . ';' . $captcha . ';' . $data . ';' . $cpf . ';' . $telefone . ';' . $coordenacao . ';' . $uf . ';' . $motivo . ';' . $quebra);

                $fp = fopen("assets/captcha/data/cgpert/cgpert.txt", "a");
                $escreve = fwrite($fp, $access);
                fclose($fp);
            }if ($coordenacao == 'CGOB') { 
                $quebra = chr(13) . chr(10); //essa é a quebra de linha
                $access = ($name . ';' . $email . ';' . $empresa . ';' . $captcha . ';' . $data . ';' . $cpf . ';' . $telefone . ';' . $coordenacao . ';' . $uf . ';' . $motivo . ';' . $quebra);
                
                $fp = fopen("assets/captcha/data/cgob/cgob.txt", "a");
                $escreve = fwrite($fp, $access);
                fclose($fp);
            }if ($coordenacao == 'CGOP') { 
                $quebra = chr(13) . chr(10); //essa é a quebra de linha
                $access = ($name . ';' . $email . ';' . $empresa . ';' . $captcha . ';' . $data . ';' . $cpf . ';' . $telefone . ';' . $coordenacao . ';' . $uf . ';' . $motivo . ';' . $quebra);
                
                $fp = fopen("assets/captcha/data/cgop/cgop.txt", "a");
                $escreve = fwrite($fp, $access);
                fclose($fp);
            }if ($coordenacao == 'CGOFER') {
                $quebra = chr(13) . chr(10); //essa é a quebra de linha
                $access = ($name . ';' . $email . ';' . $empresa . ';' . $captcha . ';' . $data . ';' . $cpf . ';' . $telefone . ';' . $coordenacao . ';' . $uf . ';' . $motivo . ';' . $quebra);

                $fp = fopen("assets/captcha/data/confer/confer.txt", "a");
                $escreve = fwrite($fp, $access);
                fclose($fp);
            }
            $retorno = 1;
        }


        echo (json_encode($retorno));
    }

}
