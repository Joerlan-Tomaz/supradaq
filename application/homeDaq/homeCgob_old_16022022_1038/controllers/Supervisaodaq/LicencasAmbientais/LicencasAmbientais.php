<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class LicencasAmbientais extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ftp');
        $this->load->model('/Supervisaodaq/Tb_licencas_ambientais');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    //-------------------------------------------------------------------------------------------

     public function populaTipoLicenca() {
            $DadosServico = $this->Tb_licencas_ambientais->populaTipoLicenca();
            $n = 0;
            foreach ($DadosServico as $lista) {
                $dados['id_tipo_licenca'][$n] = $lista->id_tipo_licenca;
                $dados['desc_tipo_licenca'][$n] = str_replace("_", " ", $lista->desc_tipo_licenca);
                $n++;
            }
            echo (json_encode($dados));
        }

     public function insereLicencasAmbientais() {
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

                        $dados["periodo"] = $this->input->post_get('periodo');
                        $dados["idContrato"] = $this->session->idContrato;
                        $dados["idUsuario"] = $this->session->id_usuario_daq;

                        $dados["num_licenca_ambiental"] = $this->input->post_get('licenca');
                        $dados["tipo"] = $this->input->post_get('tipo');
                        $dados["orgao_emissor"] = $this->input->post_get('orgaoEmissor');

                        $dados["data_emissao"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataEmissao")))));
                        $dados["inicio_vigencia"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("inicioVigencia")))));
                        $dados["termino_vigencia"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("terminoVigencia")))));

                        $dados["data_solicitacao"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataSolicitacaoRenovacao")))));

                        $dados["renovacao_solicitada"] = $this->input->post_get('solicitacaoDataRenovacao');

                        $dados["resumo_licenca_ambiental"] = $this->input->post_get('status_detalhado');
                        $dados["condicionantes_ambientais"] = $this->input->post_get('condicionantes_ambientais');
                        
                        $dados["desc_arquivo"] = $this->input->post_get('tipo');
                        
                        if(($extensao == "pdf") || ($extensao == "PDF")){
                             $dados["tipo_arquivo"] = "PDF";
                        }
                        else if(($extensao == "docx") || ($extensao == "DOCX") ){
                             $dados["tipo_arquivo"] = "Word";
                        }
                        else if(($extensao == "xlsx") || ($extensao == "XLSX") ){
                             $dados["tipo_arquivo"] = "Excel";
                        }
                        //$dados["roteiro"] = "LicencasAmbientais";

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

                            $this->Tb_licencas_ambientais->insereLicencasAmbientais($dados);
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
//------------------------------------------------------------------------------------------------------------------------


    public function recuperaLicencasAmbientais() {
        $dados["idContrato"] = $this->session->idContrato;
        //$dados["periodo"] = $this->input->post_get("periodo");

        $Dados = $this->Tb_licencas_ambientais->recuperaLicencasAmbientais($dados);   
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                if (!empty($lista->nomeOriginalArquivo)) {
                    $nomeArquivo = $lista->nomeOriginalArquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                
                //$arquivo = "<a href='javascript:void(0);' onclick=\"anexoLicencas('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";
               // $arquivo = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $lista->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
                $path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
                $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nomeArquivo . "<a>";

                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaLicencaEditar(" . $lista->id_licenca_ambiental . ");' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fa fa-pencil'></i></button>";
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirArquivo(" . $lista->id_licenca_ambiental .",". $lista->id_arquivo .");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $retorno["data"][] = array(
                    'LICENCA' => $lista->licenca,
                    'TIPO' => $lista->tipo,
                    'DATA_VIGENCIA' => $lista->vigencia,
                    'SOLICITACAO_RENOVACAO_CADASTRO' => $lista->solicitadarenovada,
                    'OBSERVACAO' => $lista->resumo,
                    'ARQUIVO' => $arquivo,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->atualizacao,
                    'ACAO' => $acao
                );
            }
        }
        echo (json_encode($retorno));
    }

    public function anexoLicencas() {
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

    public function RecuperaLicencaEditar() {

            $dados["id_licenca_ambiental"] = $this->input->post_get('id_licenca_ambiental');
            $dados["idContrato"] = $this->session->idContrato;
            $dados["periodo"] = $this->input->post_get("periodo");
            
            $DadosServico  = $this->Tb_licencas_ambientais->RecuperaLicencaEditar($dados);
        
              foreach ($DadosServico as $lista) {
          
            $dados['id_licenca_ambiental']= $lista->id_licenca_ambiental;
            $dados['licenca']= $lista->num_licenca_ambiental;
            $dados['tipo']= $lista->id_tipo_licenca;
            $dados['orgao_emissor']= $lista->orgao_emissor;
            $dados['emissao']= $lista->data_emissao;
            $dados['termino_vigencia']= $lista->termino_vigencia;
            $dados['data_vigencia']= $lista->inicio_vigencia;
            $dados['solicitacao_renovacao_cadastro']= $lista->renovacao_solicitada;
            $dados['data_solicitacao_renovacao']= $lista->data_solicitacao;
            $dados['observacoes']= $lista->resumo_licenca_ambiental;
            $dados['condicionantes_ambientais']= $lista->condicionantes_ambientais;
        }
        echo (json_encode($dados));
    }

    public function editarLicencaAmbiental() {

        $dados["id_licenca_ambiental"] = $this->input->post_get('id_licenca_ambiental');
        $dados["idUsuario"] = $this->session->id_usuario_daq;

        $dados["num_licenca_ambiental"] = $this->input->post_get('licenca');
        $dados["tipo"] = $this->input->post_get('tipo');
        $dados["orgao_emissor"] = $this->input->post_get('orgaoEmissor');
        $dados["data_emissao"] = $this->input->post_get('dataEmissao');
        $dados["inicio_vigencia"] = $this->input->post_get('inicioVigencia');
        $dados["termino_vigencia"] = $this->input->post_get('terminoVigencia');
        $dados["renovacao_solicitada"] = $this->input->post_get('solicitacaoDataRenovacao');
        $dados["data_solicitacao"] = $this->input->post_get('dataSolicitacaoRenovacao');

        $dados["resumo_licenca_ambiental"] = $this->input->post_get('status_detalhado');
        $dados["condicionantes_ambientais"] = $this->input->post_get('condicionantes_ambientais');
                        
        //$dados["desc_arquivo"] = $this->input->post_get('tipo');
    
        $retorno = $this->Tb_licencas_ambientais->editarLicencaAmbiental($dados);
       
        echo (json_encode($retorno));

    }
    
    public function excluirLicensas() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        
        echo (json_encode($retorno));
    }

    public function excluirArquivo() {
        $dados["id_licenca_ambiental"] = $this->input->post_get('id_licenca_ambiental');
        $dados["id_arquivo"] = $this->input->post_get('id_arquivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_licencas_ambientais->excluirArquivo($dados);
        echo (json_encode($retorno));
    }


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//######################################################################################################################################################################################################################## 
  
