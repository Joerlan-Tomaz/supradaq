<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class DiagramaPontoPassagem extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	public function insereDiagramaPontoPassagem()
	{
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
				$dados["roteiro"] = "16";
				$dados["idUsuario"] = $this->session->id_usuario_daq;
				$dados["idContrato"] = $this->session->idContrato;

				$dados["desc_arquivo"] = "DiagramaPontoPassagem";

				if (($extensao == "png") || ($extensao === "PNG")) {
					$dados["tipo_arquivo"] = "png";
				} else if (($extensao == "jpg") || ($extensao === "JPG")) {
					$dados["tipo_arquivo"] = "jpg";
				} else if (($extensao == "jpeg") || ($extensao === "JPEG")) {
					$dados["tipo_arquivo"] = "jpeg";
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

					$dados["id_tela_formulario"] = 6;
					$dados["periodo"] = $this->input->post_get("periodo");
					$this->Tb_telas_validacao->inserir_validacao($dados);

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
			$retorno["mensagem"] = "Arquivo Vazio";
			$retorno["notify"] = "warning";

		}

		echo(json_encode($retorno));
	}


	public function recuperaDiagramaPontoPassagem()
	{
		$dados["idContrato"] = $this->session->idContrato;
		//$dados["periodo"] = $this->input->post_get("periodo");
		$dados["roteiro"] = "16";

		$Dados = $this->Tb_arquivo->recuperaArquivo($dados);
		$retorno["data"] = array();

		if (!empty($Dados)) {
			foreach ($Dados as $i => $lista) {

				if (!empty($lista->arquivo)) {
					$nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
				} else {
					$nomeArquivo = $lista->nome_arquivo;
				}

				//$arquivo ="<div>    <a href='index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' data-fancybox='group'>        <img src='index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' width='30%' height='180px'>    </a>    <div>        <small>*Clique na foto para ampliar!</small>    </div></div>";
				$path_imagem = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $lista->nome_arquivo);
				$imagem = "<div>";
				$imagem .= "    <a href=" . $path_imagem . " data-fancybox='group'>";
				$imagem .= "        <img src=" . $path_imagem . " alt='img01' width='30%' height='180px'>";
				$imagem .= "    </a>";
				$imagem .= "    <div>";
				$imagem .= "        <small>Clique na foto para ampliar!</small>";
				$imagem .= "    </div>";
				$imagem .= "</div>";

				$acao = "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick='excluirDiagramaPontoPassagem(" . $lista->id_arquivo . ");'><i class='fa fa-trash'></i></a> 
                    <a data-toggle='tooltip' title='Download' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"anexoDiagrama('{$lista->nome_arquivo}')\"><i class='fa fa-download'></i></a>";

				$retorno["data"][] = array(
					'ARQUIVO' => $imagem,
					'NOME' => $lista->nome,
					'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
					'ACAO' => $acao
				);

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '6';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
			}
		} else {
			$dados["id_tela_formulario"] = '6';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}

		echo(json_encode($retorno));
	}

	public function anexoDiagrama()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$config['hostname'] = '10.100.11.158';
		$config['username'] = 'supradaq';
		$config['password'] = 'dnit@2020';
		$config['port'] = 21;
		$config['debug'] = TRUE;
		$this->ftp->connect($config);
		$arquivodestino = "/arquivos/arquivoDaq/img/" . $nome_arquivo;
		$arquivolocalho = ("arquivoDaq/img/" . $nome_arquivo);
		$retorno = $this->ftp->download($arquivodestino, $arquivolocalho, 'binary');
		$this->ftp->close();
		echo(json_encode($retorno));
	}

	public function excluirDiagramaPontoPassagem()
	{
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$retorno = $this->Tb_arquivo->excluirArquivo($dados);
		echo(json_encode($retorno));
	}

	public function excluirDiagrama()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$arquivolocalho = ("arquivoDaq/img/" . $nome_arquivo);
		$retorno = unlink($arquivolocalho);
		echo(json_encode($retorno));
	}


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
