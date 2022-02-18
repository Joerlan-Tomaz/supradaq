<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class GarantiasContratuais extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ftp');
        $this->load->model('/Supervisaodaq/Tb_garantias_contratuais');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario_daq)) {
            redirect(base_url());
        }
    }

 //------------------------------------------------------------------------------------

    public function populaTipoGarantia() {
            $DadosServico = $this->Tb_garantias_contratuais->populaTipoGarantia();
            $n = 0;
            foreach ($DadosServico as $lista) {
                $dados['id_tipo_garantia'][$n] = $lista->id_tipo_garantia;
                $dados['desc_tipo_garantia'][$n] = str_replace("_", " ", $lista->desc_tipo_garantia);
                $n++;
            }
            echo (json_encode($dados));
        }



    public function insereGarantiaSeguro() {
        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;

        $dados["num_guia"] = $this->input->post_get('guia');
        $dados["tipo_garantia"] = $this->input->post_get('tipo_garantia');
        $dados["processo"] = $this->input->post_get('processo');
        $dados["valor_garantia"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor_garantia")));
        $dados["inicio_vigencia"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("inicio_vigencia")))));
        $dados["termino_vigencia"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("termino_vigencia")))));
        $dados["data_emissao"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_emissao")))));

        $dados["instituicao"] = $this->input->post_get('financeira_seguradora');
        $dados["num_apolice"] = $this->input->post_get('numero_apolice');
        $dados["desc_objeto"] = $this->input->post_get('objeto');
        $dados["desc_observacao"] = $this->input->post_get('observacao');

        if (empty($dados["id_garantia_seguro"])) {
            $retorno = $this->Tb_garantias_contratuais->insereGarantiaSeguro($dados);
        }
        echo (json_encode($retorno));
                        
    }

     public function recuperaGarantiaSeguro() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');

        $Dados = $this->Tb_garantias_contratuais->recuperaGarantiaSeguro($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
               
                 if ($lista->st == "" or NULL){
                    $lista->st = "Aberto";

                    $providencia = "<button type='button' span class='btn btn-danger' href='javascript:void(0);' onclick =\"modalSituacao({$lista->id_garantia_seguro},'{$lista->st}')\";><i class = 'fa fa-close'></i></span></button>";

                  } 
                  else {
                     $lista->st = "Fechado";

                      $providencia = "<button type='button' span class='btn btn-success' href='javascript:void(0);' onclick =\"modalSituacao({$lista->id_garantia_seguro},'{$lista->st}')\";><i class = 'fa fa-check'></i></span></button>";

                  }
                 $descricao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'recuperaObservacaoObjeto(". $lista->id_garantia_seguro.")'><i class = 'fa fa-eye'></i></button>";
                
                

                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'modalAnexo(". $lista->id_garantia_seguro.")'><i class = 'fa fa-paperclip'></i></button><button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirGarantiaSeguro(". $lista->id_garantia_seguro.")'><i class = 'fa fa-trash'></i></button>";
            
                $retorno["data"][] = array(
                    'guia' => $lista->num_guia,
                    'tipo_garantia' =>  $lista->desc_tipo_garantia,
                    'processo' => $lista->processo,
                    'valor_garantia' => "R$".number_format($lista->valor_garantia,2,",","."),
                    'inicio_vigencia' => $lista->inicio_vigencia,
                    'termino_vigencia' => $lista->termino_vigencia,
                    'data_emissao' => $lista->data_emissao,
                    'observacao' => $descricao,
                    'situacao' => $lista->situacao,
                    'providencia' => $providencia,
                    'usuario' => $lista->nome,
                    'ultima_alteracao' => $lista->ultima_alteracao,
                    'acao' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }
     
    public function anexoGaratias() {
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

        public function recuperaObservacaoObjeto () {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');
        $dados["periodo"] = $this->input->post_get('periodo');

        $DadosServico = $this->Tb_garantias_contratuais->recuperaObservacaoObjeto($dados);

        foreach ($DadosServico as $lista) {
            $dados['objeto']= $lista->desc_objeto; 
            $dados['observacao']= $lista->desc_observacao;     
        }
        echo (json_encode($dados));
    }



    public function insereProvidencia() {
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');

        $dados["situacao"] = $this->input->post_get('situacao');
        $dados["providencia_garantia"] = $this->input->post_get('providencia');
                        
           if (!empty($dados["id_garantia_seguro"])) {
            $this->Tb_garantias_contratuais->insereProvidencia($dados);
        }
        $retorno["situacao"] = $this->input->post_get('situacao');
        echo (json_encode($retorno));
            
    }


     public function recuperaProvidencia() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');
        $dados["st"]= $this->input->post_get('st');

        $Dados = $this->Tb_garantias_contratuais->recuperaProvidencia($dados);   
        $retorno["data"] = Array();

        if (  $dados["st"]=== "Fechado"){
                    $acao = "--";
                }else {foreach ($Dados as $lista) {
                     $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirProvidencia(". $lista->id_providencia_garantia.")'><i class = 'fa fa-trash'></i></button>";
               } }

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                
                // $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirProvidencia(". $lista->id_providencia_garantia.")'><i class = 'fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'status'=> $lista->st,
                    'DESCRICAO' => $lista->providencia,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

   public function excluirGarantiaSeguro() {
        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');
        $dados["id_arquivo"] = $this->input->post_get('id_arquivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_garantias_contratuais->excluirGarantiaSeguro($dados);
        echo (json_encode($retorno));
    }

     public function insereAnexo_old_22092021_1627() {
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
                         
                        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');

                        $dados["periodo"] = $this->input->post_get('periodo');
                        $dados["idContrato"] = $this->session->idContrato;
                        $dados["idUsuario"] = $this->session->id_usuario_daq;

                        
                        $dados["desc_arquivo"] = "GarantiasContratuais";
                        
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
                        $dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq . "_1";
                        $dados["extencao"] = $extensao;


                        $dados["id_arquivo"] = $this->Tb_arquivo->insereArquivo($dados);

                        if ($dados["id_arquivo"] !== FALSE) {
                            move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);

                            $this->Tb_garantias_contratuais->insereAnexo($dados);

                            $config['hostname'] = '10.100.11.158';
                            $config['username'] = 'supradaq';
                            $config['password'] = 'dnit@2020';
                            $config['port']  = 21;
                            $config['debug']  = TRUE;
                            $this->ftp->connect($config);
                            $arquivodestino = "/arquivos/arquivoDaq/arq/".$nomeArquivo;
                            $arquivolocalho = ("arquivoDaq/arq/" . $nomeArquivo);

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

        public function insereAnexo() {
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
                         
                        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');

                        $dados["periodo"] = $this->input->post_get('periodo');
                        $dados["idContrato"] = $this->session->idContrato;
                        $dados["idUsuario"] = $this->session->id_usuario_daq;

                        
                        $dados["desc_arquivo"] = "GarantiasContratuais";
                        
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
                        $dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq . "_1";
                        $dados["extencao"] = $extensao;


                        $dados["id_arquivo"] = $this->Tb_arquivo->insereArquivo($dados);

                        if ($dados["id_arquivo"] !== FALSE) {
                            move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);

                           $retorno=$this->Tb_garantias_contratuais->insereAnexo($dados);

                            

                            
                            
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


     public function recuperaAnexos() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["id_garantia_seguro"] = $this->input->post_get('id_garantia_seguro');

        $Dados = $this->Tb_garantias_contratuais->recuperaAnexos($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                if (!empty($lista->arquivo)) {
                    $nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
               
                $arquivo = "<a href='javascript:void(0);' onclick=\"anexoGaratias('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";

                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirArquivo(". $lista->id_arquivo.")'><i class = 'fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    
                    'ARQUIVO' => $arquivo,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->atualizacao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }
    //------------------------------------------------------------------------------------------------------------------------
    public function excluirGarantias() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        echo (json_encode($retorno));
    }

    public function excluirArquivo() {
        $dados["id_arquivo"] = $this->input->post_get('id_arquivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_garantias_contratuais->excluirArquivo($dados);
        echo (json_encode($retorno));
    }

        public function excluirProvidencia() {
        $dados["id_providencia"] = $this->input->post_get('id_providencia');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_garantias_contratuais->excluirProvidencia($dados);
        echo (json_encode($retorno));
    }

}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################

 
