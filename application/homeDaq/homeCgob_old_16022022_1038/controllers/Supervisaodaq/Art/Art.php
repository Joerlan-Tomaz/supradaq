<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Art extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ftp');
        $this->load->model('/Supervisaodaq/Tb_art_supervisao');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    //------------------------------------------------------------------------------------

    public function populaUF() {
            $DadosServico = $this->Tb_art_supervisao->populaUF();
            $n = 0;
            foreach ($DadosServico as $lista) {
                $dados['id_uf'][$n] = $lista->id_uf;
                $dados['estado'][$n] = str_replace("_", " ", $lista->estado);
                $n++;
            }
            echo (json_encode($dados));
        }


    public function insereART() {
                if (isset($_FILES['arquivo'])) {
                    $arquivo = $_FILES['arquivo'];
                    $maxsize = 1024 * 1024 * 5;
                    if ($maxsize > $arquivo["size"]) {
                        $extensao = @end(explode('.', $arquivo["name"]));
                        if (($extensao === "pdf")||($extensao === "PDF")) {

                            $dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

                            $nameArray = explode('.', $arquivo["name"]);

                            $nName = count($nameArray) - 1;
                            $name = "";
                            for ($i = 0; $i < $nName; $i++) {
                                $name .= $nameArray[$i] . ".";
                            }

                            $dados["periodo"] = $this->input->post_get('periodo');
                            $dados["idContrato"] = $this->session->idContrato;
                            $dados["idUsuario"] = $this->session->id_usuario_daq;

                            $dados["uf_registro"] = $this->input->post_get('uf_registro');
                            $dados["nome_empresa"] = $this->input->post_get('config_ART_empresa');
                            $dados["nome_profissional"] = $this->input->post_get('config_ART_nome');
                            $dados["email_art"] = $this->input->post_get('config_ART_email');
                            $dados["tel_art"] = $this->input->post_get('config_ART_telefone');
                            $dados["num_crea"] = $this->input->post_get('config_ART_CREA');
                            $dados["rnp_art"] = $this->input->post_get('config_ART_RNP');
                            $dados["num_art"] = $this->input->post_get('config_ART_numero');
                            $dados["forma_registro"] = $this->input->post_get('config_ART_forma_registro');
                            $dados["participacao_tecnica"] = $this->input->post_get('config_ART_participacao_tecnica');
                           
                            $dados["data_registro"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("config_ART_data")))));
                             
                            $dados["data_baixa"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("config_ART_dataBaixa")))));
                        
                            $dados["desc_arquivo"] = "Art Supervisao";

                            $dados["tipo_arquivo"] = "PDF";
                           
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

                                $this->Tb_art_supervisao->insereART($dados);
                                $retorno["mensagem"] = "Cadastrado com sucesso!";
                                $retorno["notify"] = "success";

                                                           
                            } else {
                                $retorno["mensagem"] = "Não foi possível realizar o cadastro";
                                $retorno["notify"] = "warning";
                                
                            }
                            
                        } else {
                            $retorno["mensagem"] = "Arquivo vazio ou extensão não corresponde";
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

//------------------------------------------------------------------------------------------------------------------------
        public function recuperaART() {
        $dados["idContrato"] = $this->session->idContrato;
        //$dados["periodo"] = $this->input->post_get("periodo");

        $Dados = $this->Tb_art_supervisao->recuperaART($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {

                 if (!empty($lista->nomeOriginalArquivo)) {
                    $nomeArquivo = $lista->nomeOriginalArquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                //$arquivo = "<a href='javascript:void(0);' onclick=\"artAnexo('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";
                 //$arquivo = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $lista->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
                 $path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
                $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nomeArquivo . "<a>";
                
                // <button type='button' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaEditaART(".$lista->id_art_supervisao.",".$lista->id_arquivo.");' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fa fa-pencil'></i></button>
                 if(!empty($lista->data_baixa)){
                    $acao= "<button type='button' class='btn btn-default' data-toggle='tooltip' title='Dar Baixa desabilitado' data-placement='top'>- -</button>"; 
                    $baixa=$lista->data_baixa;
                 }else{
                   $acao =" <button type='button' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaDarBaixaART(".$lista->id_art_supervisao.");' data-toggle='tooltip' title='Dar Baixa' data-placement='top'><i class='fa fa-check'></i></button>";
                   $baixa = "<span class='badge badge-danger'> -- / -- / -- </span>";
                 }
                $acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaDetalharART(".$lista->id_art_supervisao.",".$lista->id_arquivo.");' data-toggle='tooltip' title='Detalhar' data-placement='top'><i class='fa fa-eye'></i></button>";
                $acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirART(".$lista->id_art_supervisao.",".$lista->id_arquivo.");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'ARQUIVO' => $arquivo,
                    'FORMAREGISTRO' => $lista->forma_registro,
                    'DATABAIXA' => $baixa,
                    'DATAREGISTRO' => $lista->data_registro,
                    'NOMEPROFISSIONAL' => $lista->nome_profissional,
                    'N_ART' => $lista->num_art,
                    'PARTICIPACAOTECNICA' => $lista->participacao_tecnica,
                    'USUARIO' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

    public function artAnexo() {
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

       public function RecuperaEditaART() {

            $dados["id_art_supervisao"] = $this->input->post_get('id_art_supervisao');
            $dados["idContrato"] = $this->session->idContrato;
            $dados["periodo"] = $this->input->post_get("periodo");
            
            $DadosServico  = $this->Tb_art_supervisao->RecuperaEditaART($dados);
        
              foreach ($DadosServico as $lista) {
          
            $dados['id_art_supervisao']= $lista->id_art_supervisao;
            $dados['empresaContratada']= $lista->nome_empresa;
            $dados['nome_art']= $lista->nome_profissional;
            $dados['email']= $lista->email_art;
            $dados['telefone']= $lista->tel_art;
            $dados['CREA']= $lista->num_crea;
            $dados['RPN']= $lista->rnp_art;
            $dados['n_ART']= $lista->num_art;
            $dados['id_uf']= $lista->estado;
            $dados['ParticipacaoTecnica']= $lista->participacao_tecnica;
            $dados['formaRegistro']= $lista->forma_registro;
            $dados['dataRegistro']= $lista->data_registro;
            $dados['data_baixa']= $lista->data_baixa;
        }
        echo (json_encode($dados));
    }


     public function editarART() {

        $dados["id_art_supervisao"] = $this->input->post_get('id_art_supervisao');
        $dados["idUsuario"] = $this->session->id_usuario_daq;

        $dados["id_codigo_uf"] = $this->input->post_get('uf_registro_Editar');
        $dados["nome_empresa"] = $this->input->post_get('config_ART_empresa_Editar');
        $dados["nome_profissional"] = $this->input->post_get('config_ART_nome_Editar');
        $dados["email_art"] = $this->input->post_get('config_ART_email_Editar');
        $dados["tel_art"] = $this->input->post_get('config_ART_telefone_Editar');
        $dados["num_crea"] = $this->input->post_get('config_ART_CREA_Editar');
        $dados["rnp_art"] = $this->input->post_get('config_ART_RNP_Editar');
        $dados["num_art"] = $this->input->post_get('config_ART_numero_Editar');
        $dados["participacao_tecnica"] = $this->input->post_get('config_ART_participacao_tecnica_Editar');

        $dados["forma_registro"] = $this->input->post_get('config_ART_forma_registro_Editar');
        $dados["data_baixa"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("config_ART_dataBaixa_Editar")))));
        $dados["data_registro"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("config_ART_data_Editar")))));
        
                    
    
        $retorno = $this->Tb_art_supervisao->editarART($dados);
       
        echo (json_encode($retorno));

    }

       public function excluirART() {
        $dados["id_art_supervisao"] = $this->input->post_get('id_art_supervisao');
        $dados["id_arquivo"] = $this->input->post_get('id_arquivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_art_supervisao->excluirART($dados);
        echo (json_encode($retorno));
    }

    public function artexcluir() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        echo (json_encode($retorno));
    }
















}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
