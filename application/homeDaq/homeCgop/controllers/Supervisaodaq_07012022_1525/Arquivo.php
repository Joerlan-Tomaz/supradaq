<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Arquivo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    public function Modelo() {
        $arq = isset($_REQUEST ['arq']) ? $_REQUEST ['arq'] : NULL;
        $arquivo = FCPATH . "application/homeDaq/arquivoDaq/Modelos/" . $arq;
        
        if (isset($arquivo) && file_exists($arquivo)) { // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch (strtolower(substr(strrchr(basename($arquivo), "."), 1))) { // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo = "application/pdf";
                    break;
                case "exe": $tipo = "application/octet-stream";
                    break;
                case "xlsx": $tipo = "application/octet-stream";
                    break;
                case "zip": $tipo = "application/zip";
                    break;
                case "doc": $tipo = "application/msword";
                    break;
                case "docx": $tipo = "application/msword";
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

    public function DownloadArquivo() {
        $arq = isset($_REQUEST ['arq']) ? $_REQUEST ['arq'] : NULL;
        $arquivo = FCPATH . "application/homeDaq/arquivoDaq/arq/" . $arq;
        if (isset($arquivo) && file_exists($arquivo)) { // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch (strtolower(substr(strrchr(basename($arquivo), "."), 1))) { // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo = "application/pdf";
                    break;
                case "exe": $tipo = "application/octet-stream";
                    break;
                case "xlsx": $tipo = "application/octet-stream";
                    break;
                case "zip": $tipo = "application/zip";
                    break;
                case "doc": $tipo = "application/msword";
                    break;
                case "docx": $tipo = "application/msword";
                    break;
                case "xls": $tipo = "application/vnd.ms-excel";
                    break;
                case "ppt": $tipo = "application/vnd.ms-powerpoint";
                    break;
                case "gif": $tipo = "image/gif";
                    break;
                case "png": $tipo = "image/png";
                    break;
                case "PNG": $tipo = "image/PNG";
                    break;
                case "jpg": $tipo = "image/jpg";
                    break;
                case "JPG": $tipo = "image/JPG";
                    break;    
                case "jpeg": $tipo = "image/jpeg";
                    break;
                case "JPEG": $tipo = "image/JPEG";
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

    public function DownloadArquivoConvenio() {
        $arq = isset($_REQUEST ['arq']) ? $_REQUEST ['arq'] : NULL;
        $arquivo = FCPATH . "application/homeDaq/arquivoDaq/convenios/" . $arq;
        if (isset($arquivo) && file_exists($arquivo)) { // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch (strtolower(substr(strrchr(basename($arquivo), "."), 1))) { // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo = "application/pdf";
                    break;
                case "exe": $tipo = "application/octet-stream";
                    break;
                case "xlsx": $tipo = "application/octet-stream";
                    break;
                case "zip": $tipo = "application/zip";
                    break;
                case "doc": $tipo = "application/msword";
                    break;
                case "docx": $tipo = "application/msword";
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

    public function DownloadArquivoDemanda() {
        $arq = isset($_REQUEST ['arq']) ? $_REQUEST ['arq'] : NULL;
        $arquivo = FCPATH . "application/homeDaq/arquivoDaq/gestaoDemanda/" . $arq;
        if (isset($arquivo) && file_exists($arquivo)) { // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
            switch (strtolower(substr(strrchr(basename($arquivo), "."), 1))) { // verifica a extensão do arquivo para pegar o tipo
                case "pdf": $tipo = "application/pdf";
                    break;
                case "exe": $tipo = "application/octet-stream";
                    break;
                case "xlsx": $tipo = "application/octet-stream";
                    break;
                case "zip": $tipo = "application/zip";
                    break;
                case "doc": $tipo = "application/msword";
                    break;
                case "docx": $tipo = "application/msword";
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

    public function imagem() {
        $img = isset($_REQUEST ['img']) ? $_REQUEST ['img'] : NULL;
        if (!empty($img)) {
            $dir = FCPATH . "application/homeDaq/arquivoDaq/img/" . $img;
            
            if (file_exists($dir)) {
                $exif = exif_imagetype($dir);
                $mime = image_type_to_mime_type($exif); //Pega o mime type do arquivo 
                header("Content-type: {$mime}");
                echo file_get_contents($dir);
            }
        }
    }

    public function imagemConvenio() {
        $img = isset($_REQUEST ['img']) ? $_REQUEST ['img'] : NULL;
        if (!empty($img)) {
            $dir = FCPATH . "application/homeDaq/arquivoDaq/convenios/" . $img;
            if (file_exists($dir)) {
                $exif = exif_imagetype($dir);
                $mime = image_type_to_mime_type($exif); //Pega o mime type do arquivo 
                header("Content-type: {$mime}");
                echo file_get_contents($dir);
            }
        }
    }

    public function downloadImagem() {
        $img = isset($_REQUEST ['img']) ? $_REQUEST ['img'] : NULL;
        $imagem = FCPATH . "application/homeDaq/arquivoDaq/img/" . $img;
        if (isset($imagem) && file_exists($imagem)) { // faz o teste se a variavel não esta vazia e se a imagem realmente existe
            switch (strtolower(substr(strrchr(basename($imagem), "."), 1))) { // verifica a extensão da imagem para pegar o tipo
                case "pdf": $tipo = "application/pdf";
                    break;
                case "exe": $tipo = "application/octet-stream";
                    break;
                case "xlsx": $tipo = "application/octet-stream";
                    break;
                case "zip": $tipo = "application/zip";
                    break;
                case "doc": $tipo = "application/msword";
                    break;
                case "docx": $tipo = "application/msword";
                    break;
                case "xls": $tipo = "application/vnd.ms-excel";
                    break;
                case "ppt": $tipo = "application/vnd.ms-powerpoint";
                    break;
                case "gif": $tipo = "image/gif";
                    break;
                case "png": $tipo = "image/png";
                    break;
                case "PNG": $tipo = "image/PNG";
                    break;
                case "jpg": $tipo = "image/jpg";
                    break;
                case "JPG": $tipo = "image/JPG";
                    break;
                case "mp3": $tipo = "audio/mpeg";
                    break;
                case "jpeg": $tipo = "image/jpeg";
                    break;
                case "JPEG": $tipo = "image/JPEG";
                    break;
                case "php": // deixar vazio por seurança
                case "htm": // deixar vazio por seurança
                case "html": // deixar vazio por seurança
            }
            header("Content-Type: " . $tipo); // informa o tipo da imagem ao navegador
            header("Content-Length: " . filesize($imagem)); // informa o tamanho da imagem ao navegador
            header("Content-Disposition: attachment; filename=" . basename($imagem)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome da imagem
            readfile($imagem); // lê a imagem
            exit; // aborta pós-ações
        }
    }

    public function imagemDefault() {
        $img = isset($_REQUEST ['img']) ? $_REQUEST ['img'] : NULL;
        if (!empty($img)) {
            $dir = FCPATH . "assets/img/users/default_user.png" . $img;
            if (file_exists($dir)) {
                $exif = exif_imagetype($dir);
                $mime = image_type_to_mime_type($exif); //Pega o mime type do arquivo 
                header("Content-type: {$mime}");
                echo file_get_contents($dir);
            }
        }
    }

    public function apresentacao() {
        $img = isset($_REQUEST ['img']) ? $_REQUEST ['img'] : NULL;
        if (!empty($img)) {
            $dir = FCPATH . "application/homeDaq/arquivoDaq/Apresentacao/" . $img;
            if (file_exists($dir)) {
                $exif = exif_imagetype($dir);
                $mime = image_type_to_mime_type($exif); //Pega o mime type do arquivo 
                header("Content-type: {$mime}");
                echo file_get_contents($dir);
            }
        }
    }

    public function DownloadApresentacao() {
        $arq = isset($_REQUEST ['arq']) ? $_REQUEST ['arq'] : NULL;
        $arquivo = FCPATH . "application/homeDaq/arquivoDaq/Apresentacao/" . $arq;
//var_dump($arquivo);
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

}
