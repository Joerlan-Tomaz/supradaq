<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Download extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    public function index() {   
        $this->download_core();
    }

    public function cgmrr() {   
        $this->download_core(false);
    }

    public function download_core($cgcont = true) {        
        $arq = isset($_REQUEST ['arq']) ? $_REQUEST ['arq'] : NULL;

        if($cgcont)
            $arquivo = FCPATH . "arquivoCgcont/Documentacao/" . $arq;
        else
            $arquivo = FCPATH . "arquivos/cgmrr/documentacao/" . $arq;

        if (isset($arquivo) && file_exists($arquivo)) { // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch (strtolower(substr(strrchr(basename($arquivo), "."), 1))) { // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo = "application/pdf";
                    break;
                case "exe": $tipo = "application/octet-stream";
                    break;
                case "zip": $tipo = "application/zip";
                    break;
                case "doc": $tipo = "application/msword";
                    break;
                case "xls": $tipo = "application/vnd.ms-excel";
                    break;
                case "ppt": $tipo = "application/vnd.ms-powerpoint";
                    break;
                case "gif": $tipo = "image/gif";
                    break;
                case "png": $tipo = "image/png";
                    break;
                case "jpg": $tipo = "image/jpg";
                    break;
                case "mp3": $tipo = "audio/mpeg";
                    break;
                case "php": // deixar vazio por seurança
                case "htm": // deixar vazio por seurança
                case "html": // deixar vazio por seurança
            }
            header("Content-Type: " . $tipo); // informa o tipo do arquivo ao navegador
            header("Content-Length: " . filesize($arquivo)); // informa o tamanho do arquivo ao navegador
            header("Content-Disposition: attachment; filename=" . basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
            readfile($arquivo); // lê o arquivo
            exit; // aborta pós-ações
        }
    }

    public function reciboRPFO() {
        $dados["id_revisao"] = $this->input->get("revisao");
        $dados["tipo_fase"] = $this->input->get("fase");
        redirect("homeCgcont/Rpfo/Recibo/GeraRecibo/GeraReciboFase?revisao=" . $dados["id_revisao"] . "&fase=" . $dados["tipo_fase"]);
    }

}
