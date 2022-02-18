<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */

defined('BASEPATH') or exit('No direct script access allowed');

class AtividadesExecutora extends CI_Controller
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

	public function insereAtividadeExecutora()
	{
		if (isset($_FILES['arquivo'])) {
			$arquivo = $_FILES['arquivo'];
			$maxsize = 1024 * 1024 * 5;
			if ($maxsize > $arquivo["size"]) {
				$extensao = @end(explode('.', $arquivo["name"]));
				if (($extensao === "pdf") || ($extensao === "xlsx") || ($extensao === "docx") || ($extensao === "PDF") || ($extensao === "XLSX") || ($extensao === "DOCX")) {

					$dir = FCPATH . "arquivoDaq/arq/";

					$nameArray = explode('.', $arquivo["name"]);

					$nName = count($nameArray) - 1;
					$name = "";
					for ($i = 0; $i < $nName; $i++) {
						$name .= $nameArray[$i] . ".";
					}

					$dados["periodo"] = $this->input->post_get('periodo');
					if ($_REQUEST['tipo_atividade'] == 'Operação') {
						$dados["roteiro"] = "90";
						$dados["id_tela_formulario"] = 23;
					} else if ($_REQUEST['tipo_atividade'] == 'Manutenção') {
						$dados["roteiro"] = "91";
						$dados["id_tela_formulario"] = 24;
					} else if ($_REQUEST['tipo_atividade'] == 'Regularização') {
						$dados["roteiro"] = "92";
						$dados["id_tela_formulario"] = 25;
					} else if ($_REQUEST['tipo_atividade'] == 'Assessoramento Especializado') {
						$dados["roteiro"] = "93";
						$dados["id_tela_formulario"] = 26;
					} else if ($_REQUEST['tipo_atividade'] == 'Conformidade dos Produtos Entregues pela Executora') {
						$dados["roteiro"] = "94";
						$dados["id_tela_formulario"] = 27;
					}
					$dados["idUsuario"] = $this->session->id_usuario_daq;
					$dados["idContrato"] = $this->session->idContrato;

					$dados["desc_arquivo"] = "Atividades da Executora - " . $_REQUEST['tipo_atividade'];

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
					if ($dados["id_arquivo"] !== FALSE) {
						move_uploaded_file($arquivo['tmp_name'], $dir . $nomeArquivo);

						$dados["periodo"] = $this->input->post_get("periodo");
						$this->Tb_telas_validacao->inserir_validacao($dados);

						$retorno["mensagem"] = "Cadastrado com sucesso!";
						$retorno["notify"] = "success";

					} else {
						$retorno["mensagem"] = "Não foi possível enviar o arquivo.";
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

		echo(json_encode($retorno));
	}


	public function recuperAtividadeExecutora()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		if ($_REQUEST['tipo_atividade'] == 'Operação') {
			$dados["roteiro"] = "90";
			$dados["id_tela_formulario"] = 23;
		} else if ($_REQUEST['tipo_atividade'] == 'Manutenção') {
			$dados["roteiro"] = "91";
			$dados["id_tela_formulario"] = 24;
		} else if ($_REQUEST['tipo_atividade'] == 'Regularização') {
			$dados["roteiro"] = "92";
			$dados["id_tela_formulario"] = 25;
		} else if ($_REQUEST['tipo_atividade'] == 'Assessoramento Especializado') {
			$dados["roteiro"] = "93";
			$dados["id_tela_formulario"] = 26;
		} else if ($_REQUEST['tipo_atividade'] == 'Conformidade dos Produtos Entregues pela Executora') {
			$dados["roteiro"] = "94";
			$dados["id_tela_formulario"] = 27;
		}

		$Dados = $this->Tb_arquivo->recuperaArquivo($dados);
		$retorno["data"] = array();

		if (!empty($Dados)) {
			foreach ($Dados as $i => $lista) {

				if (!empty($lista->arquivo)) {
					$nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
				} else {
					$nomeArquivo = $lista->nome_arquivo;
				}

				$arquivo = "<a href='javascript:void(0);' onclick=\"anexoDiario('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";
				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirArquivo(" . $lista->id_arquivo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				$retorno["data"][] = array(
					'ARQUIVO' => $arquivo,
					'NOME' => $lista->nome,
					'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
					'ACAO' => $acao
				);

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '23';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
			}
		} else {
			$dados["id_tela_formulario"] = '23';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($retorno));
	}

	public function excluirArquivo()
	{
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$retorno = $this->Tb_arquivo->excluirArquivo($dados);
		echo(json_encode($retorno));
	}

}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################
