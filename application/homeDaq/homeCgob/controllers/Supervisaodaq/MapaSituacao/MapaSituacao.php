<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class MapaSituacao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

     public function insereMapaSituacao_old_02072021_1051() {
        if (isset($_FILES['arquivo'])) {
            $arquivo = $_FILES['arquivo'];
       
                $extensao = @end(explode('.', $arquivo["name"]));
                if (($extensao === "jpeg") || ($extensao === "png") || ($extensao === "jpg") || ($extensao === "JPEG") || ($extensao === "PNG") || ($extensao === "JPG")) {
                    $dir = FCPATH . "arquivoDaq/img/";

                    $nameArray = explode('.', $arquivo["name"]);

                    $nName = count($nameArray) - 1;
                    $name = "";
                    for ($i = 0; $i < $nName; $i++) {
                        $name .= $nameArray[$i] . ".";
                    }

                    $dados["periodo"] = $this->input->post_get('periodo');
                    $dados["roteiro"] = "15";
                    $dados["idUsuario"] = $this->session->id_usuario_daq;
                    $dados["idContrato"] = $this->session->idContrato;
                    
                    $dados["desc_arquivo"] = "MapaSituacao";

                    if(($extensao == "png") || ($extensao === "PNG")){
                             $dados["tipo_arquivo"] = "png";
                        }
                        else if(($extensao == "jpg") || ($extensao === "JPG")){
                             $dados["tipo_arquivo"] = "jpg";
                        }
                        else if(($extensao == "jpeg") || ($extensao === "JPEG")){
                             $dados["tipo_arquivo"] = "jpeg";
                        }

                    $name = substr_replace($name, '', -1);
                    $nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";
                   

                    $dados["nome_arquivo"] = $nomeArquivo;
                    $dados["nomeOriginalArquivo"] = $name;
                    $dados["pasta_origem"] = "arquivo";
                    $dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq . "_1";
                    $dados["extencao"] = $extensao;


                    $dados["id_arquivo"] = $this->Tb_arquivo->insereArquivo($dados);
                    if ($dados["id_arquivo"] !== FALSE) {
                        move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);

                        // $this->Tb_resumo->insereDiarioObra($dados);
                    }
                        $config['hostname'] = '10.100.11.158';
                        $config['username'] = 'supradaq';
                        $config['password'] = 'dnit@2020';
                        $config['port']  = 21;
                        $config['debug']  = TRUE;
                        $this->ftp->connect($config);
                        $arquivodestino = "/arquivos/arquivoDaq/img/".$nomeArquivo;
                        $arquivolocalho = ("arquivoDaq/img/" . $nomeArquivo);

                        if($this->ftp->upload($arquivolocalho, $arquivodestino, 'binary', 0777)){
                        $retorno["mensagem"] = "Cadastrado com sucesso!";
                        $retorno["notify"] = "success";
                        unlink($arquivolocalho);
                        } else{
                            $retorno["mensagem"] = "Não foi possível enviar o arquivo.";
                            $retorno["notify"] = "warning";
                        }

                        $this->ftp->close();
                        
                } else {
                    $retorno["mensagem"] = "Extensão não corresponde";
                    $retorno["notify"] = "warning";
                    
                }

        } else {
            $retorno["mensagem"] = "Arquivo Vazio";
            $retorno["notify"] = "warning";
            
        }

        echo (json_encode($retorno));
    }
#------------------------------------------------------------------------------#
 public function insereMapaSituacao() {
        if (isset($_FILES['arquivo'])) {
            $arquivo = $_FILES['arquivo'];
       
                $extensao = @end(explode('.', $arquivo["name"]));
                if (($extensao === "jpeg") || ($extensao === "png") || ($extensao === "jpg") || ($extensao === "JPEG") || ($extensao === "PNG") || ($extensao === "JPG")) {
                    $dir = FCPATH . "application/homeDaq/arquivoDaq/img/";

                    $nameArray = explode('.', $arquivo["name"]);

                    $nName = count($nameArray) - 1;
                    $name = "";
                    for ($i = 0; $i < $nName; $i++) {
                        $name .= $nameArray[$i] . ".";
                    }

                    $dados["periodo"] = $this->input->post_get('periodo');
                    $dados["roteiro"] = "15";
                    $dados["idUsuario"] = $this->session->id_usuario_daq;
                    $dados["idContrato"] = $this->session->idContrato;
                    
                    $dados["desc_arquivo"] = "MapaSituacao";

                    if(($extensao == "png") || ($extensao === "PNG")){
                             $dados["tipo_arquivo"] = "png";
                        }
                        else if(($extensao == "jpg") || ($extensao === "JPG")){
                             $dados["tipo_arquivo"] = "jpg";
                        }
                        else if(($extensao == "jpeg") || ($extensao === "JPEG")){
                             $dados["tipo_arquivo"] = "jpeg";
                        }

                    $name = substr_replace($name, '', -1);
                    $nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";
                   

                    $dados["nome_arquivo"] = $nomeArquivo;
                    $dados["nomeOriginalArquivo"] = $name;
                    $dados["pasta_origem"] = "arquivo";
                    $dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq . "_1";
                    $dados["extencao"] = $extensao;


                    $dados["id_arquivo"] = $this->Tb_arquivo->insereArquivo($dados);
                    if ($dados["id_arquivo"] !== FALSE) {
                        move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);

                       
                    }
                        
                        $retorno["mensagem"] = "Cadastrado com sucesso!";
                        $retorno["notify"] = "success";
                        
                        } else{
                            $retorno["mensagem"] = "Não foi possível enviar o arquivo.";
                            $retorno["notify"] = "warning";
                        }

                        
                        
                } else {
                    $retorno["mensagem"] = "Arquivo Vazio";
            $retorno["notify"] = "warning";
                    
                }

        

        echo (json_encode($retorno));
    }
#------------------------------------------------------------------------------#    


    public function anexoMapas() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $config['hostname'] = '10.100.11.158';
        $config['username'] = 'supradaq';
        $config['password'] = 'dnit@2020';
        $config['port']   = 21;
        $config['debug']  = TRUE;
        $this->ftp->connect($config);
        $arquivodestino = "/arquivos/arquivoDaq/img/".$nome_arquivo;
        $arquivolocalho = ("arquivoDaq/img/" . $nome_arquivo);
        $retorno = $this->ftp->download($arquivodestino, $arquivolocalho,'binary');   
        $this->ftp->close();

        echo (json_encode($retorno));
    }

    public function recuperaMapaSituacao_old_02072021_1109() {
        $dados["idContrato"] = $this->session->idContrato;
        //$dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "15";
        
        $Dados = $this->Tb_arquivo->recuperaArquivo($dados);   
        $retorno["data"] = Array();
      
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {

                 if (!empty($lista->arquivo)) {
                    $nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                $nome_arquivo = $lista->nome_arquivo;
                $config['hostname'] = '10.100.11.158';
                $config['username'] = 'supradaq';
                $config['password'] = 'dnit@2020';
                $config['port']   = 21;
                $config['debug']  = TRUE;
                $this->ftp->connect($config);
                $arquivodestino = "/arquivos/arquivoDaq/img/".$nome_arquivo;
                $arquivolocalho = ("arquivoDaq/img/" . $nome_arquivo);
                $this->ftp->download($arquivodestino, $arquivolocalho,'binary');   
                $this->ftp->close();
                       
                $arquivo ="<div> <a href='70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' data-fancybox='group'> <img src='70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' alt='img01' width='30%' height='180px'></a> <div> <small>Clique na foto para ampliar!</small></div></div>";

                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirArquivo(". $lista->id_arquivo .");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'ARQUIVO' => $arquivo,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao, 
                    'ACAO' => $acao
                );
            }
        }


        echo (json_encode($retorno));
    }
#-------------------------------------------------------------------------------#
public function recuperaMapaSituacao() {
        $dados["idContrato"] = $this->session->idContrato;
        //$dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "15";
        
        $Dados = $this->Tb_arquivo->recuperaArquivo($dados);   
        $retorno["data"] = Array();
        
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {

                if (!empty($lista->arquivo)) {
                    $nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                                       
                // $arquivo ="<div> <a href='70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' data-fancybox='group'> <img src='70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' alt='img01' width='30%' height='180px'></a> <div> <small>Clique na foto para ampliar!</small></div></div>";
                /*$imagem = "<div>";
                $imagem .= "    <a href='index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=" . $lista->nome_arquivo . "' data-fancybox='group'>";
                $imagem .= "        <img src='index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=" . $lista->nome_arquivo . "' alt='img01' width='30%' height='180px'>";
                $imagem .= "    </a>";
                $imagem .= "    <div>";
                $imagem .= "        <small>Clique na foto para ampliar!</small>";
                $imagem .= "    </div>";
                $imagem .= "</div>";*/
                $path_imagem = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $lista->nome_arquivo);
                $imagem = "<div>";
                $imagem .= "    <a href=".$path_imagem." data-fancybox='group'>";
                $imagem .= "        <img src=".$path_imagem." alt='img01' width='30%' height='180px'>";
                $imagem .= "    </a>";
                $imagem .= "    <div>";
                $imagem .= "        <small>Clique na foto para ampliar!</small>";
                $imagem .= "    </div>";
                $imagem .= "</div>";
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirArquivo(". $lista->id_arquivo .");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'ARQUIVO' => $imagem,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao, 
                    'ACAO' => $acao
                );
            }
        }


        echo (json_encode($retorno));
    }
#-------------------------------------------------------------------------------#    

    public function excluirMapas() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/img/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        
        echo (json_encode($retorno));
    }

      public function excluirArquivo() {
        $dados["id_arquivo"] = $this->input->post_get('id_arquivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_arquivo->excluirArquivo($dados);
        echo (json_encode($retorno));
    }


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
