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
		//verifica se já não foi cadastrado para o período que não houve atividade
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["roteiro"] = "11";
		$DadosNaoAtividade = $this->Tb_resumo->confereNaoAtividade($dados);
		if(!empty($DadosNaoAtividade)){
			$retorno["mensagem"] = "Monitoramento ambiental não pode ser incluído, pois já existe um registro que não houve atividade no período";
			$retorno["notify"] = "warning";
			echo (json_encode($retorno));
			die;
		}

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
                    $dados["idUsuario"] = $this->session->id_usuario_daq;
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
                    $dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq . "_1";
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
                if($lista->resumo == 'Não Houve Atividade' && empty($lista->id_arquivo)){
					$lista->id_arquivo = 0;
				}
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

    public function excluirArquivo() {
        $dados["id_resumo"] = $this->input->post_get('id_resumo');
        $dados["id_arquivo"] = $this->input->post_get('id_arquivo');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_resumo->excluirArquivo($dados);
        echo (json_encode($retorno));
    }


    public function excluirArq() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        echo (json_encode($retorno));
    }

	public function insereNaoAtividade(){
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["roteiro"] = "11";
		$retorno = $this->Tb_resumo->insereNaoAtividade($dados);
		echo (json_encode($retorno));
	}

	public function confereAtividade()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["roteiro"] = "11";

		$DadosControle = $this->Tb_resumo->recuperaPGQ($dados);
		$dados["data"] = array();

		$dadosNaoAtividade = $this->Tb_resumo->confereAtividade($dados);
		if (!empty($DadosControle)) {
			$dados["situacao"] = $dadosNaoAtividade[0]->situacao;
		} else {
			$dados["situacao"] = 'Sem Registros';
		}
		echo(json_encode($dados));
	}

} // fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
