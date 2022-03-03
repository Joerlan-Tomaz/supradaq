<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PortariasFiscais extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_portaria_fiscais');
		$this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	public function populaUF()
	{
		$DadosServico = $this->Tb_portaria_fiscais->populaUF();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_uf'][$n] = $lista->id_uf;
			$dados['estado'][$n] = str_replace("_", " ", $lista->estado);
			$n++;
		}
		echo(json_encode($dados));
	}

	public function populaTitularidade()
	{
		$DadosServico = $this->Tb_portaria_fiscais->populaTitularidade();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_titularidade'][$n] = $lista->id_titularidade;
			$dados['titularidade'][$n] = str_replace("_", " ", $lista->titularidade);
			$n++;
		}
		echo(json_encode($dados));
	}


	public function inserePortariasFiscais()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["unidade_local"] = $this->input->post_get('unidade_local');
		$dados["num_portaria"] = $this->input->post_get('n_portaria');
		$dados["contrato_fiscalizado"] = $this->input->post_get('contrato_fiscalizado');
		$dados["titularidade"] = $this->input->post_get('titularidade');
		$dados["nome_fiscal"] = $this->input->post_get('nome');
		$dados["email"] = $this->input->post_get('email');
		$dados["telefone"] = $this->input->post_get('telefone');
		$dados["status"] = $this->input->post_get('status');

		if (isset($_FILES['arquivo'])) {
			$arquivo = $_FILES['arquivo'];
			$maxsize = 1024 * 1024 * 5;
			if ($maxsize > $arquivo["size"]) {
				$extensao = @end(explode('.', $arquivo["name"]));
				if (($extensao === "pdf") || ($extensao === "PDF")) {

					$dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";
					$nameArray = explode('.', $arquivo["name"]);
					$nName = count($nameArray) - 1;
					$name = "";
					for ($i = 0; $i < $nName; $i++) {
						$name .= $nameArray[$i] . ".";
					}
					$dados["data_portaria"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_portaria")))));
					$dados["desc_arquivo"] = "Portarias Fiscais";
					$dados["tipo_arquivo"] = "PDF";

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
					}
				} else {
					$retorno["mensagem"] = "Extensão não corresponde";
					$retorno["notify"] = "warning";
				}
			} else {
				$retorno["mensagem"] = "Arquivo supera o limite de tamanho(5mb)";
				$retorno["notify"] = "warning";
			}
		}

		$this->Tb_portaria_fiscais->inserePortariasFiscais($dados);
		$dados["id_tela_formulario"] = 8;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);
		$retorno["mensagem"] = "Cadastrado com sucesso!";
		$retorno["notify"] = "success";

		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------------------------------
	public function excluirPortaria()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$arquivolocalho = ("application/homeDaq/arquivoDaq/arq/" . $nome_arquivo);
		$retorno = unlink($arquivolocalho);

		echo(json_encode($retorno));
	}

	public function recuperaPortariasFiscais()
	{
		$dados["idContrato"] = $this->session->idContrato;
		//$dados["periodo"] = $this->input->post_get("periodo");

		$Dados = $this->Tb_portaria_fiscais->recuperaPortariasFiscais($dados);
		$retorno["data"] = array();

		if (!empty($Dados)) {
			foreach ($Dados as $i => $lista) {
				if (!empty($lista->arquivo)) {
					$nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
				} else {
					$nomeArquivo = $lista->nome_arquivo;
				}

				//$arquivo = "<a href='javascript:void(0);' onclick=\"anexoPortarias('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";
				// $arquivo = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $lista->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
				$path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
				$arquivo = "<a download href=" . $path_arq . " target='_blank'>" . $nomeArquivo . "<a>";
				//$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'editarPortariasFiscais(" . $lista->id_portaria_fiscal . "," . $lista->id_arquivo . ")'><i class = 'fa fa-pencil'></i></button >";
				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirPortariasFiscais(" . $lista->id_portaria_fiscal . "," . $lista->id_arquivo . ")'><i class = 'fa fa-trash'></i></button >";

				if ($lista->contrato_fiscalizado == 'Supervisão') {
					$contrato = "" . $lista->numero_supervisora . "-" . $lista->contrato_fiscalizado . "";
				}
				if ($lista->contrato_fiscalizado == 'Operação') {
					$contrato = "" . $lista->nu_con_formatado . "-" . $lista->contrato_fiscalizado . "";
				}
				$retorno["data"][] = array(

					'nomeFiscal' => $lista->nome_fiscal,
					'email' => $lista->email,
					'telefone' => $lista->telefone,
					'titularidade' => $lista->titularidade,
					'contrato' => $contrato,
					'data_portaria' => $lista->portaria,
					'arquivo' => $arquivo,
					'ultima_alteracao' => $lista->atualizacao,
					'usuario' => $lista->nome,
					'acao' => $acao
				);

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '8';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->atualizacao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
			}
		} else {
			$dados["id_tela_formulario"] = '8';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($retorno));
	}

	public function anexoPortarias()
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

	public function excluirPortariasFiscais()
	{
		$dados["id_portaria_fiscal"] = $this->input->post_get('id_portaria_fiscal');
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$retorno = $this->Tb_portaria_fiscais->excluirPortariasFiscais($dados);
		echo(json_encode($retorno));
	}

	public function buscarDadsoPortariasFiscais()
	{
		$dados["id_portaria_fiscal"] = $this->input->post_get('id_portaria_fiscal');
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$retorno = $this->Tb_portaria_fiscais->recuperaPortariasFiscais($dados);
		echo(json_encode($retorno[0]));
	}


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//######################################################################################################################################################################################################################## 
  
