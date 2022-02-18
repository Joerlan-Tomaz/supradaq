<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class AtasCorrespondencia extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_AtasCorrespondencia');
		$this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	//------------------------------------------------------------------------------------
	public function insereAtasCorrespondencias()
	{
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


					$dados["tipo"] = $this->input->post_get('tipo_documento');
					$dados["numero_documento"] = $this->input->post_get('num_documento');
					$dados["assunto"] = $this->input->post_get('assunto');

					$dados["data_atividade"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_ata")))));

					$dados["desc_atas_correspondecia"] = $this->input->post_get('status_detalhado');

					$dados["desc_arquivo"] = $this->input->post_get('tipo_documento');

					if (($extensao == "pdf") || ($extensao == "PDF")) {
						$dados["tipo_arquivo"] = "PDF";
					} else if (($extensao == "docx") || ($extensao == "DOCX")) {
						$dados["tipo_arquivo"] = "Word";
					} else if (($extensao == "xlsx") || ($extensao == "XLSX")) {
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

					$this->Tb_AtasCorrespondencia->insereAtasCorrespondencias($dados);

					$dados["id_tela_formulario"] = 41;
					$dados["periodo"] = $this->input->post_get("periodo");
					$this->Tb_telas_validacao->inserir_validacao($dados);

					$retorno["mensagem"] = "Cadastrado com sucesso!";
					$retorno["notify"] = "success";

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

		echo(json_encode($retorno));
	}


	public function recuperaAtasCorrespondencias()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$Dados = $this->Tb_AtasCorrespondencia->recuperaAtasCorrespondencias($dados);
		$retorno["data"] = array();

		if (!empty($Dados)) {
			foreach ($Dados as $i => $lista) {
				if (!empty($lista->nomeOriginalArquivo)) {
					$nomeArquivo = $lista->nomeOriginalArquivo . "." . @end(explode(".", $lista->nome_arquivo));
				} else {
					$nomeArquivo = $lista->nome_arquivo;
				}
				//$arquivo = "<a href='javascript:void(0);' onclick=\"AtasAnexo('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";
                                $arquivo = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $lista->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirArquivo(" . $lista->id_atas_correspondencias . "," . $lista->id_arquivo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				$retorno["data"][] = array(
					'TIPO_DOCUMENTO' => $lista->tipo_documento,
					'DOCUMENTO' => $lista->numero_documento,
					'RESUMO' => $lista->assunto,
					'ARQUIVO' => $arquivo,
					'NOME' => $lista->nome,
					'ULTIMA_ALTERACAO' => $lista->atualizacao,
					'ACAO' => $acao
				);

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '41';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->atualizacao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
			}
		} else {
			$dados["id_tela_formulario"] = '41';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($retorno));
	}

	public function AtasAnexo()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$config['hostname'] = '10.100.11.158';
		$config['username'] = 'supradaq';
		$config['password'] = 'dnit@2020';
		$config['port'] = 21;
		$config['debug'] = TRUE;
		$this->ftp->connect($config);
		$arquivodestino = "/arquivos/arquivoDaq/arq/" . $nome_arquivo;
		$arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
		$retorno = $this->ftp->download($arquivodestino, $arquivolocalho, 'binary');
		$this->ftp->close();

		echo(json_encode($retorno));
	}

	public function excluirArquivo()
	{
		$dados["id_atas_correspondencias"] = $this->input->post_get('id_atas_correspondencias');
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$retorno = $this->Tb_AtasCorrespondencia->excluirArquivo($dados);
		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------------------------------
	public function excluirAtas()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
		$retorno = unlink($arquivolocalho);

		echo(json_encode($retorno));
	}

	public function insereNaoAtividade(){
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get('periodo');
		$retorno = $this->Tb_AtasCorrespondencia->insereNaoAtividade($dados);

		$dados["id_tela_formulario"] = 41;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo (json_encode($retorno));
	}

	public function naoHouveAtividade(){
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["atas"] = false;
		$dados["possuiAtas"] = false;
		$NaoAtividade = $this->Tb_AtasCorrespondencia->buscaNaoAtividade($dados);
		$dados["data"] = array();

		if(!empty($NaoAtividade)){
			$dados["atas"] = true;
			foreach($NaoAtividade as $lista){
				$dados["data"][] = array(
					'atividademes' => $lista->atividademes,
					'ultima_alteracao' => $lista->ultima_alteracao,
					'usuario' => $lista->nome,
					'acoes' => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"excluirNaoAtividade({$lista->id})\">
                    <i class='fa fa-trash'></i></a>"
				);
			}
		}

		if($dados["atas"] == false){
			if(count($this->Tb_AtasCorrespondencia->recuperaAtasCorrespondencias($dados)) > 0){
				$dados["possuiAtas"] = true;
			}
		}
		echo (json_encode($dados));
	}

	public function excluirNaoAtividade(){
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["id"] = $this->input->post_get('id');
		$retorno = $this->Tb_AtasCorrespondencia->excluirNaoAtividade($dados);
		echo (json_encode($retorno));
	}

}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
