<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class ComponenteAmbiental extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ftp');
        $this->load->model('/Supervisaodaq/Tb_resumo');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
  
   #-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
   
    public function insereComponenteAmbiental() {
        if (isset($_FILES['arquivo'])) {
            $arquivo = $_FILES['arquivo'];
            $maxsize = 1024 * 1024 * 5;
            if ($maxsize > $arquivo["size"]) {
                $extensao = @end(explode('.', $arquivo["name"]));
                if (($extensao === "pdf") || ($extensao === "xlsx") || ($extensao === "docx") || ($extensao === "PDF") || ($extensao === "XLSX") || ($extensao === "DOCX")) {

                    $dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

                    $nameArray = explode('.', $arquivo["name"]);

                    $nName = count($nameArray) - 1;
                    $name = "";
                    for ($i = 0; $i < $nName; $i++) {
                        $name .= $nameArray[$i] . ".";
                    }

                    $dados["resumo"] = $this->input->post_get('resumoComponenteAmbiental');
                    $dados["periodo"] = $this->input->post_get('periodo');
                    $dados["roteiro"] = "11";
                    $dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
                    $dados["idContrato"] = $this->session->idContrato;

                    
                    $dados["desc_arquivo"] = "ComponenteAmbiental";
                    
                        if(($extensao == "pdf") || ($extensao == "PDF")){
                             $dados["tipo_arquivo"] = "PDF";
                        }
                        else if(($extensao == "docx") || ($extensao == "DOCX") ){
                             $dados["tipo_arquivo"] = "Word";
                        }
                        else if(($extensao == "xlsx") || ($extensao == "XLSX") ){
                             $dados["tipo_arquivo"] = "Excel";
                        }


                    $name = substr_replace($name, '', -1);
                    $nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";
                    $data = new DateTime(str_replace("/", "-", $this->input->post_get("data_ata")));

                    $dados["nome_arquivo"] = $nomeArquivo;
                    $dados["nomeOriginalArquivo"] = $name;
                    $dados["pasta_origem"] = "arquivo";
                    $dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq_cgop . "_1";
                    $dados["extencao"] = $extensao;


                    $dados["id_arquivo"] = $this->Tb_arquivo->insereArquivo($dados);
                    if ($dados["id_arquivo"] !== FALSE) {
                        move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);

                        $this->Tb_resumo->inserePGQ($dados);

                        
                        $retorno["mensagem"] = "Cadastrado com sucesso!";
                        $retorno["notify"] = "success";
                        
                        
                    } else {
                        $retorno["mensagem"] = "Não foi possível realizar o cadastro";
                        $retorno["notify"] = "warning";
                       
                    }
                } else {
                    $retorno["mensagem"] = "Extensão não corresponde";
                    $retorno["notify"] = "warning";
                    
                }
            } else {
                $retorno["mensagem"] = "Arquivo supera o limite de tamanho(5mb)";
                $retorno["notify"] = "warning";
                
            }
        } else {
            $retorno["mensagem"] = "Arquivo Vazio";
            $retorno["notify"] = "warning";
           
        }

        echo (json_encode($retorno));
    }

public function RecuperaComponenteAmbiental() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "11";
        
        $Dados = $this->Tb_resumo->recuperaPGQ($dados);   
        $retorno["data"] = Array();
      
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {

                if (!empty($lista->arquivo)) {
                    $nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                //$arquivo = "<a href='javascript:void(0);' onclick=\"anexoAmbiental('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";
                $arquivo = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $lista->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirArquivo(" . $lista->id_arquivo . ",". $lista->id_resumo .");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'RESUMO' => $lista->resumo,
                    'ARQUIVO' => $arquivo,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao, 
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

    public function anexoAmbiental() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $config['hostname'] = '10.100.11.158';
        $config['username'] = 'supradaq';
        $config['password'] = 'dnit@2020';
        $config['port']   = 21;
        $config['debug']  = TRUE;
        $this->ftp->connect($config);
        $arquivodestino = "/arquivos/arquivoDaq/arq/".$nome_arquivo;
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = $this->ftp->download($arquivodestino, $arquivolocalho,'binary'); 
        $this->ftp->close();
        echo (json_encode($retorno));
    }


    public function excluirArquivo() {
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["id_arquivo"] = $this->input->post_get('id_arquivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
        $retorno = $this->Tb_resumo->excluirArquivo($dados);
        echo (json_encode($retorno));
    }


    public function excluirArq() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("application/homeDaq/arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        echo (json_encode($retorno));
    }
 

} // fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
