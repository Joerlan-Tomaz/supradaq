<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Resumoprojeto extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ftp');
        $this->load->model('/Supervisaodaq/Tb_resumo');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
  
    #-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#

    public function insereResumo() {
        if (isset($_FILES['arquivo'])) {
            $arquivo = $_FILES['arquivo'];
            $maxsize = 1024 * 1024 * 5;
            if ($maxsize > $arquivo["size"]) {
                $extensao = @end(explode('.', $arquivo["name"]));
                if (($extensao === "xlsx") || ($extensao === "XLSX")) {

                    $dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

                    $nameArray = explode('.', $arquivo["name"]);

                    $nName = count($nameArray) - 1;
                    $name = "";
                    for ($i = 0; $i < $nName; $i++) {
                        $name .= $nameArray[$i] . ".";
                    }

                    $dados["resumo"] = $this->input->post_get('descricao_resumoProjeto');
                    $dados["id_resumo"] = $this->input->post_get('id_resumo');
                    $dados["periodo"] = $this->input->post_get('periodo');
                    $dados["roteiro"] = "3";
                    $dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
                    $dados["idContrato"] = $this->session->idContrato;
                    
                    $dados["tipo_texto_resumo"] = $this->input->post_get('tipo_texto_resumo');
                    $dados["desc_arquivo"] = $this->input->post_get('tipo_texto_resumo');
                    $dados["tipo_arquivo"] = "Excel";

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

                        $this->Tb_resumo->insereResumoProjeto($dados);

                        
                        
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
            $dados["resumo"] = $this->input->post_get('descricao_resumoProjeto');
            $dados["id_resumo"] = $this->input->post_get('id_resumo');
            $dados["periodo"] = $this->input->post_get('periodo');
            $dados["roteiro"] = "3";
            $dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
            $dados["idContrato"] = $this->session->idContrato;

            $dados["tipo_texto_resumo"] = $this->input->post_get('tipo_texto_resumo');
            $dados["desc_arquivo"] = $this->input->post_get('tipo_texto_resumo');
            $this->Tb_resumo->insereResumoProjeto($dados);
            $retorno["mensagem"] = "Cadastrado com sucesso!";
            $retorno["notify"] = "success";
        }

        if($retorno['notify'] == "success"){
			$dados["id_tela_formulario"] = 15;
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->inserir_validacao($dados);
		}

        echo (json_encode($retorno));
    }

    public function recuperaResumo() {
        $dados["idContrato"] = $this->session->idContrato;
        //$dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "3";
        
        $Dados = $this->Tb_resumo->Recuperaresumoprojeto($dados);   
        $retorno["data"] = Array();
      
        if (!empty($Dados)) {
            foreach ($Dados as $i => $lista) {
                if (!empty($lista->nomeOriginalArquivo)) {
                    $nomeArquivo = $lista->nomeOriginalArquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirArquivo(" . $lista->id_resumo . ",". $lista->id_arquivo .");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                $path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
                $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nomeArquivo . "<a>";
                $retorno["data"][] = array(
                    'RESUMO' => $lista->resumo,
                    'TIPO' => $lista->desc_tipo_obra,
                    'ARQUIVO' =>$arquivo,
                    'NOME' => $lista->nome,
                    'ULTIMA_ALTERACAO' => $lista->ultima_alteracao, 
                    'ACAO' => $acao
                );

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '15';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
            }
		} else {
			$dados["id_tela_formulario"] = '15';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
        echo (json_encode($retorno));
    }
//------------------------------------------------------------------------------------------------------------------------
    public function excluirResumo() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        
        echo (json_encode($retorno));
    }

    public function anexoResumo() {
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


    public function populaTipoTexto() {
        $DadosServico = $this->Tb_resumo->populaTipoTexto();
        $n = 0;
        foreach ($DadosServico as $lista) {
            $dados['id_tipo_pavimento'][$n] = $lista->id_tipo_obra;
            $dados['desc_tipo_pavimento'][$n] = str_replace("_", " ", $lista->desc_tipo_obra);
            $n++;
        }
        echo (json_encode($dados));
    }


} // fecha classe
 // * DNIT-SUPRA
 // * Programador: Jordana Alencar
 // * Data: 01/11/19 17:30
