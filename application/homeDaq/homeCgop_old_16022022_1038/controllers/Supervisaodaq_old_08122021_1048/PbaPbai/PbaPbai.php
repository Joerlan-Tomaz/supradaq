<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PbaPbai extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_pba_pbai');
		$this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	//------------------------------------------------------------------------------------

	public function populaPba()
	{
		$DadosServico = $this->Tb_pba_pbai->populaPba();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_pba'][$n] = $lista->id_pba;
			$dados['desc_pba'][$n] = str_replace("_", " ", $lista->desc_pba);
			$n++;
		}
		echo(json_encode($dados));
	}

	public function populaPbai()
	{
		$DadosServico = $this->Tb_pba_pbai->populaPbai();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_pbai'][$n] = $lista->id_pbai;
			$dados['desc_pbai'][$n] = str_replace("_", " ", $lista->desc_pbai);
			$n++;
		}
		echo(json_encode($dados));
	}

	public function inserePbaPbai()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;

		$dados["descricao"] = $this->input->post_get('descricao');
		$dados["tipo"] = $this->input->post_get('tipo');
		$dados["nome_infraestrutura"] = $this->input->post_get('nome_infraestrutura');
		$dados["status"] = $this->input->post_get('status');

		if (isset($_FILES['arquivo'])) {
			$arquivo = $_FILES['arquivo'];
			$maxsize = 1024 * 1024 * 5;
			if ($maxsize > $arquivo["size"]) {
				$extensao = @end(explode('.', $arquivo["name"]));
				if (($extensao === "pdf") || ($extensao === "docx") || ($extensao === "PDF") || ($extensao === "DOCX")) {
					$dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

					$nameArray = explode('.', $arquivo["name"]);

					$nName = count($nameArray) - 1;
					$name = "";
					for ($i = 0; $i < $nName; $i++) {
						$name .= $nameArray[$i] . ".";
					}
					$dados["desc_arquivo"] = "PbaPbai";

					if (($extensao == "pdf") || ($extensao == "PDF")) {
						$dados["tipo_arquivo"] = "PDF";
					} else if (($extensao == "docx") || ($extensao == "DOCX")) {
						$dados["tipo_arquivo"] = "Word";
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
					move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);

				} else {
					$retorno["mensagem"] = "Extensão não corresponde";
					$retorno["notify"] = "warning";

				}
			} else {
				$retorno["mensagem"] = "Arquivo supera o limite de tamanho(5mb)";
				$retorno["notify"] = "warning";

			}
		}

		if ($this->Tb_pba_pbai->inserePbaPbai($dados)) {
			$dados["id_tela_formulario"] = 12;
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->inserir_validacao($dados);

			$retorno["mensagem"] = "Cadastrado com sucesso!";
			$retorno["notify"] = "success";
		} else {
			$retorno["mensagem"] = "Não foi possível realizar o cadastro";
			$retorno["notify"] = "warning";
		}

		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------------------------------
	public function excluirPba()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
		$retorno = unlink($arquivolocalho);

		echo(json_encode($retorno));
	}

	//------------------------------RECUPERA-----------------------------------------------------

	public function recuperaPbaPbai()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$Dados = $this->Tb_pba_pbai->recuperaPbaPbai($dados);
		$retorno["data"] = array();

		if (!empty($Dados)) {
			foreach ($Dados as $i => $lista) {
				if (!empty($lista->arquivo)) {
					$nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
				} else {
					$nomeArquivo = $lista->nome_arquivo;
				}
				$path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
				$arquivo = "<a download href=" . $path_arq . " target='_blank'>" . $nomeArquivo . "<a>";
				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='editarPbaPbai(" . $lista->id_pba_pbai . "," . $lista->id_arquivo . ");' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fa fa-pencil'></i></button>";
				$acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirPbaPbai(" . $lista->id_pba_pbai . "," . $lista->id_arquivo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				$retorno["data"][] = array(
					'NOME_INFRAESTRUTURA' => $lista->nome_infraestrutura,
					'RESUMO' => $lista->descricao,
					'TIPO' => $lista->tipo,
					'STATUS' => $lista->status,
					'ARQUIVO' => $arquivo,
					'NOME' => $lista->nome,
					'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
					'ACAO' => $acao
				);

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '12';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
			}
		} else {
			$dados["id_tela_formulario"] = '12';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($retorno));
	}

	public function anexoPbaPbai()
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

//------------------------------RECUPERA-EDITAR----------------------------------------------------

	public function Recupera_editarPbaPbai()
	{

		$dados["id_pba_pbai"] = $this->input->post_get('id_pba_pbai');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$DadosServico = $this->Tb_pba_pbai->recuperaPbaPbai($dados);

		foreach ($DadosServico as $lista) {

			$dados['id_pba_pbai'] = $lista->id_pba_pbai;
			$dados['tipo'] = $lista->tipo;
			$dados['status'] = $lista->status;
			$dados['descricao'] = $lista->descricao;
			$dados['nomearquivo'] = $lista->arquivo;
		}
		echo(json_encode($dados));
	}

//------------------------------EXCLUIR-----------------------------------------------------

	public function excluirPbaPbai()
	{
		$dados["id_pba_pbai"] = $this->input->post_get('id_pba_pbai');
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$retorno = $this->Tb_pba_pbai->excluirPbaPbai($dados);
		echo(json_encode($retorno));
	}


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
