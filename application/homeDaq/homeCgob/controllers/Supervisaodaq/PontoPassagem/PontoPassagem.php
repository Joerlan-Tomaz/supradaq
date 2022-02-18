<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PontoPassagem extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library('ftp');
		$this->load->model("/Supervisaodaq/Tb_ponto_passagem");
		$this->load->model("/Supervisaodaq/Tb_configuracao_obra");
		$this->load->model("/Supervisaodaq/Tb_arquivo");
		$this->load->database('DAQ', TRUE);
		$this->load->helper("url");
		$this->load->library("ImportExcelPhpSpout");
		$this->load->library("Excel");
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	public function insereArquivoPontoPassagem()
	{
		if (isset($_FILES["arquivo"])) {
			$arquivo = $_FILES["arquivo"];
			$maxsize = 1024 * 1024 * 10;
			if ($maxsize > $arquivo["size"]) {
				$extensao = @end(explode(".", $arquivo["name"]));
				if (($extensao === "xlsx") || ($extensao === "XLSX")) {
					$dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

					$nameArray = explode(".", $arquivo["name"]);

					$nName = count($nameArray) - 1;
					$name = "";
					for ($i = 0; $i < $nName; $i++) {
						$name .= $nameArray[$i] . ".";
					}

					$name = substr_replace($name, "", -1);
					$nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";

					$dados["periodo"] = $this->input->post_get('periodo');//nao tinha
					$dados["id_contrato_obra"] = $this->session->idContrato;
					$dados["id_usuario"] = $this->session->id_usuario_daq;
					$dados["nome_arquivo"] = $nomeArquivo;
					$dados["desc_arquivo"] = "Ponto_Passagem";
					$dados["nomeOriginalArquivo"] = $name;
					$dados["tipo_arquivo"] = "Excel";
					$dados["pasta_origem"] = "arquivo";
					$dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq . "_1";
					$dados["roteiro"] = "20";
					$dados["extencao"] = $extensao;
					$insert = $this->Tb_configuracao_obra->insereConfiguracao_Arquivo($dados);
					if ($insert !== false) {
						move_uploaded_file($arquivo["tmp_name"], $dir . $nomeArquivo);
						$dados["mensagem"] = "Cadastrado com sucesso!";
						$dados["notify"] = "success";
						$dados["nomeArquivo"] = $nomeArquivo;
					} else {
						$dados["mensagem"] = "Não foi possível enviar o arquivo.";
						$dados["notify"] = "warning";
					}
					$dadosArquivo = $this->Tb_configuracao_obra->maxID_Arquivo($dados);
					foreach ($dadosArquivo as $a) {
						$dados["id_arquivo"] = $a->id_arquivo;
					}

				} else {
					$dados["mensagem"] = "Extenção não corresponde";
					$dados["notify"] = "warning";
				}
			} else {
				$dados["mensagem"] = "Arquivo supera o limite de tamanho(5mb)";
				$dados["notify"] = "warning";
			}
		} else {
			$dados["mensagem"] = "Arquivo Vazio";
			$dados["notify"] = "warning";
		}

		echo(json_encode(utf8_converter($dados)));
	}

	public function recuperaPontoPassagem()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		//$dados["periodo"] = $this->input->post_get("periodo");
		$dados["data"] = array();
		$dadosGeo = $this->Tb_ponto_passagem->recuperaPontoPassagem($dados);

		if (!empty($dadosGeo)) {
			foreach ($dadosGeo as $lista) {
				if (!empty($lista->nomeOriginalArquivo)) {
					$nomeArquivo = $lista->nomeOriginalArquivo . "." . @end(explode(".", $lista->nome_arquivo));
				} else {
					$nomeArquivo = $lista->nome_arquivo;
				}
				$detalhes = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'detalhesPontoPassagem(" . $lista->id_arquivo . ")'><i class = 'fa fa-eye'></i></button>";
				//$arquivo = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $lista->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
                                 $path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
                                 $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nomeArquivo . "<a>";
				$dados["data"][] = array(
					"ARQUIVO" => $arquivo,
					"TOTAL" => $lista->total,
					"DETALHES" => $detalhes,
					"NOME" => $lista->desc_nome,
					"ULTIMA_ALTERACAO" => $lista->ultima_alteracao,
					"ACAO" => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"excluirPontoPassagem({$lista->id_arquivo},'{$nomeArquivo}')\">
                                 <i class='fa fa-trash'></i></a>"
				);
			}
		}

		echo(json_encode($dados));
	}

//------------------------------------------------------------------------------------------------------------------------

	public function recuperaDetalhesPontoPassagem()
	{
		$dados["id_arquivo"] = $this->input->post_get("id_arquivo");
		$dados["data"] = array();
		$dadosGeo = $this->Tb_ponto_passagem->detalhesPontoPassagem($dados);

		if (!empty($dadosGeo)) {
			foreach ($dadosGeo as $lista) {
				$dados["data"][] = array(
					"NOME" => $lista->nome,
					"TIPO" => $lista->tipo,
					"KM" => round($lista->km, 2),
					"ESTACA" => $lista->estaca,
					"COORDENADAS" => $lista->coordenadas,
					"USUARIO" => $lista->desc_nome,
					"ULTIMA_ALTERACAO" => $lista->ultima_alteracao
				);
			}
		}

		echo(json_encode($dados));
	}

	public function excluirArquivo()
	{
		$dados["id_arquivo"] = $this->input->post_get("id_arquivo");
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$retorno = $this->Tb_arquivo->excluirArquivo($dados);
		if ($retorno == true) {
			$retorno = $this->Tb_ponto_passagem->excluirPontoPassagem($dados);
		}

		echo(json_encode($retorno));
	}

	public function contagemLinhas()
	{
		if (!empty($_FILES["arquivo"]["name"])) {
			$arquivo = $_FILES["arquivo"];
			$dadosDaPlanilha = $this->importexcelphpspout->lerArquivo($arquivo);
			$i = 0;
			foreach ($dadosDaPlanilha as $d) {
				$dados[$i]["nome"] = $dadosDaPlanilha[$i]["nome"];
				$dados[$i]["tipo"] = $dadosDaPlanilha[$i]["tipo"];
				$dados[$i]["estaca"] = $dadosDaPlanilha[$i]["Estaca"];
				$dados[$i]["fracao_estaca"] = $dadosDaPlanilha[$i]["Fraçãoestaca"];
				$dados[$i]["km"] = $dadosDaPlanilha[$i]["km"];
				$dados[$i]["coordenada_norte"] = $dadosDaPlanilha[$i]["Latitude"];
				$dados[$i]["coordenada_leste"] = $dadosDaPlanilha[$i]["Longitude"];
				$i++;
			}
		} else {
			$dados["mensagem"] = "Arquivo fora do modelo!";
			$dados["notify"] = "warning";
		}
		die(json_encode($dados));
	}

	public function inserirdados()
	{
		$dadosS["id_arquivo"] = $this->input->post_get("idArquivo");
		date_default_timezone_set('America/Sao_Paulo');
		$ultima_alteracao = date("Y-m-d H:i:s");
		//-------------------------------------------------------------------------------------
		$id_arquivo = $this->input->post_get("idArquivo");
		$nomeArquivo = $this->input->post_get("nomeArquivo");
		$dir = FCPATH . "application/homeDaq/arquivoDaq/arq/$nomeArquivo";
		$objPHPExcel = PHPExcel_IOFactory::load($dir);
		$objWorksheet = $objPHPExcel->getSheet(0);
		$dataArr = array();
		//-------------------------------------------------------------------------------------
		foreach ($objWorksheet->getRowIterator() as $row) {
			$rowIndex = $row->getRowIndex();
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(True);
			foreach ($cellIterator as $cell) {
				$colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
				$val = $cell->getValue();
				$dataArr [$rowIndex] [$colIndex] = $val;
			}
		}//-------------------------------------------------------------------------------------
		$h = $dataArr [1];

		if (count($h) > 7) {
			$result["mensagem"] = "Arquivo fora do modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		//-------------------------------------------------------------------------------------
		if (array_key_exists(7, $h) === false) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		//-------------------------------------------------------------------------------------
		$a = 'Nome ';
		$b = 'Tipo';
		$c = 'ESTACA';
		$d = 'FRAÇÃO DE ESTACA';
		$e = 'Km';
		$f = 'LATITUDE';
		$g = 'LONGITUDE';
		//-------------------------------------------------------------------------------------
		if (array_search($a, $h) != 1) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		if (array_search($b, $h) != 2) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		/*if (array_search($c, $h) != 3) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		if (array_search($d, $h) != 4) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}*/
		if (array_search($e, $h) != 5) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		if (array_search($f, $h) != 6) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		if (array_search($g, $h) != 7) {
			$result["mensagem"] = "Arquivo fora do Modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		}
		//--------------------------------------------------------------------------------------
		unset ($dataArr [1]);
		//--------------------------------------------------------------------------------------

		//--------------------------------------------------------------------------------------
		$inseridos = 0;
		foreach ($dataArr as $val) {
			$verificaArray = 0;
			for ($i = 1; $i < 7; $i++)
				if (empty ($val [$i]))
					$verificaArray++;

			if ($verificaArray == 6)
				continue;


			$dados[] = array(
				'id_arquivo' => $id_arquivo,
				'id_contrato_obra' => $this->session->idContrato,
				'id_usuario' => $this->session->id_usuario,
				'nome' => $val ['1'],
				'tipo' => $val ['2'],
				'estaca' => str_replace(',', '.', $val ['3']),
				'fracao_estaca' => str_replace(',', '.', $val ['4']),
				'km' => str_replace(',', '.', $val ['5']),
				'coordenada_norte' => str_replace(',', '.', $val ['6']),
				'coordenada_leste' => str_replace(',', '.', $val ['7']),
				'ultima_alteracao' => $ultima_alteracao
			);
			$inseridos++;


		}
		if ($inseridos == 0) {
			$result = false;
			$result["mensagem"] = "Arquivo fora do modelo!";
			$result["notify"] = "warning";
			die(json_encode($result));
		} else {
			$insert = $this->Tb_configuracao_obra->insereConfiguracao_Arquivoupdate($dadosS);
			$retorno = $this->Tb_ponto_passagem->inserirdados($dados);
			$arquivolocalho = ("arquivoDaq/arq/" . $nomeArquivo);
//          unlink($arquivolocalho);
			echo(json_encode($retorno));

		}
	}

#-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
	public function RecuperaNomeEixo()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["nome_eixo"] = $this->input->post_get("nome_apelido");
		$dados["data"] = array();
		$Dados = $this->Tb_configuracao_georreferenciamento->RecuperaNomeEixo($dados);

		if (!empty($Dados)) {
			foreach ($Dados as $lista) {
				$conte = $lista->conte;
			}
		}
		if ($conte > 0) {
			$dados["resultado"] = true;
		} else {
			$dados["resultado"] = false;
		}
		echo(json_encode($dados));
	}

}

