<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class DocumentacaoFotografica extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_fotografica');
		$this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	//------------------------------------------------------------------------------------

	public function insereDocFotografico()
	{

		if (isset($_FILES["arquivo"])) {
			$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
			$arquivo = $_FILES["arquivo"];
			$x = count($arquivo["name"]);

			$dir = FCPATH . "application/homeDaq/arquivoDaq/img/";

			for ($i = 0; $i < $x; $i++) {

				$extensao = @end(explode(".", $arquivo["name"][$i]));
				$nameArray = explode(".", $arquivo["name"][$i]);
				$nName = count($nameArray) - 1;
				$name = "";

				for ($j = 0; $j < $nName; $j++) {
					$name .= $nameArray[$j] . ".";
				}

				$name = substr_replace($name, "", -1);
				$nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";

				$dados["id_doc_fotografica"] = $this->input->post_get('id_doc_fotografica');
				$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
				$dados["periodo_referencia"] = $this->input->post_get('periodo');
				$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
				$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
				$dados["id_contrato_obra"] = $this->session->idContrato;
				$dados["idContrato"] = $this->session->idContrato;

				//campos de inserção tb_arquivo

				$dados["desc_arquivo"] = "Documentação Fotográfica";
				$dados["nome_arquivo"] = $nomeArquivo;
				$dados["nomeOriginalArquivo"] = $name;
				$dados["tipo_arquivo"] = "Imagem";
				$dados["pasta_origem"] = "application/homeDaq/arquivoDaq/img/";
				$dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq_cgop . "_4";
				$dados["periodo"] = $this->input->post_get("periodo");
				$dados["extencao"] = $extensao;

				//campos de inserção tb__fotografica

				$dados["km"] = str_replace(",", ".", $this->input->post_get("km_foto" . $i));
				$dados["latitude"] = $this->input->post_get("utmn_foto" . $i);
				$dados["longitude"] = $this->input->post_get("utme_foto" . $i);
				$dados["estaca"] = $this->input->post_get("estaca_foto" . $i);
				$dados["descricao"] = $this->input->post_get("descricao_foto" . $i);

				$dados["id_arquivo"] = $this->Tb_arquivo->insereArquivo($dados);

				if ($dados["id_arquivo"] !== FALSE) {
					move_uploaded_file($arquivo["tmp_name"][$i], $dir . $nomeArquivo);

					$this->Tb_fotografica->insereDocFotografico($dados);

					$dados["id_tela_formulario"] = 33;
					$dados["periodo"] = $this->input->post_get("periodo");
					$this->Tb_telas_validacao->inserir_validacao($dados);

					$retorno["mensagem"] = "Cadastrado com sucesso!";
					$retorno["notify"] = "success";

				}
			}

			$retorno["mensagem"] = "Arquivo Enviado";
			$retorno["notify"] = "success";

		} else {

			$retorno["mensagem"] = "Arquivo Vazio";
			$retorno["notify"] = "warning";

		}

		echo(json_encode($retorno));

	}


	public function recuperaDocumentacao()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$Dados = $this->Tb_fotografica->recuperaDocumentacao($dados);
		$retorno["data"] = array();
		if (!empty($Dados)) {
			foreach ($Dados as $i => $lista) {
				if (!empty($lista->arquivo)) {
					$nomeArquivo = $lista->arquivo . "." . @end(explode(".", $lista->nome_arquivo));
				} else {
					$nomeArquivo = $lista->nome_arquivo;
				}

				// $arquivo ="<div>    <a href='index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' data-fancybox='group'>        <img src='index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=".$lista->nome_arquivo."' alt='img01' width='100%' >    </a>    <div>        <small>Clique na foto para ampliar!</small>    </div></div>";
				$path_imagem = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $lista->nome_arquivo);
				$imagem = "<div>";
				$imagem .= "    <a href=" . $path_imagem . " data-fancybox='group'>";
				$imagem .= "        <img src=" . $path_imagem . " alt='img01' width='30%' height='180px'>";
				$imagem .= "    </a>";
				$imagem .= "    <div>";
				$imagem .= "        <small>Clique na foto para ampliar!</small>";
				$imagem .= "    </div>";
				$imagem .= "</div>";

				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirDocumentacao(" . $lista->id_documentacao_foto . "," . $lista->id_arquivo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				$retorno["data"][] = array(
					'IMAGEM' => $imagem,
					'KM' => $lista->km,
					'DESCRICAO' => $lista->descricao,
					'USUARIO' => $lista->nome,
					'ATUALIZACAO' => $lista->atualizacao,
					'ACAO' => $acao
				);

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '33';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->atualizacao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
			}
		} else {
			$dados["id_tela_formulario"] = '33';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($retorno));
	}

	public function anexoDoc()
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

	public function excluirDocumentacao()
	{
		$dados["id_documentacao_foto"] = $this->input->post_get('id_documentacao_foto');
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$retorno = $this->Tb_fotografica->excluirDocumentacao($dados);
		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------------------------------
	public function excluirDoc()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$arquivolocalho = ("arquivoDaq/img/" . $nome_arquivo);
		$retorno = unlink($arquivolocalho);
		echo(json_encode($retorno));
	}


	public function getFotosPainelGerencial($dados)
	{
		$Dados = $this->Tb_fotografica->getFotosPainelGerencial();
	}

}
