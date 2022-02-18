<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class RNC extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
//		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_relatorio');
		$this->load->model('/Supervisaodaq/Tb_rnc');
		$this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

//----------------------------------------------------------------------------------------------------
	public function populaTipoEixo()
	{
		$DadosServico = $this->Tb_rnc->populaTipoEixo();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_eixo'][$n] = $lista->id_eixo;
			$dados['desc_eixo'][$n] = str_replace("_", " ", $lista->eixo);
			$n++;
		}
		echo(json_encode($dados));
	}

//----------------------------------------------------------------------------------------------------
	public function populaGravidade()
	{
		$DadosServico = $this->Tb_rnc->populaGravidade();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_gravidade'][$n] = $lista->id_gravidade;
			$dados['desc_gravidade'][$n] = str_replace("_", " ", $lista->desc_gravidade);
			$n++;
		}
		echo(json_encode($dados));
	}

//----------------------------------------------------------------------------------------------------
	public function populaNatureza()
	{
		$DadosServico = $this->Tb_rnc->populaNatureza();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_natureza'][$n] = $lista->id_tipo_obra;
			$dados['desc_natureza'][$n] = str_replace("_", " ", $lista->desc_tipo_obra);
			$n++;
		}
		echo(json_encode($dados));
	}

//----------------------------------------------------------------------------------------------------
	public function populaObra()
	{
		$DadosServico = $this->Tb_rnc->populaObra();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_obra'][$n] = $lista->id_obra;
			$dados['desc_obra'][$n] = str_replace("_", " ", $lista->desc_obra);
			$n++;
		}
		echo(json_encode($dados));
	}

//----------------------------------------------------------------------------------------------------
	public function populaPavimento()
	{
		$DadosServico = $this->Tb_rnc->populaPavimento();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_rnc_pavimento'][$n] = $lista->id_rnc_pavimento;
			$dados['desc_rnc_pavimento'][$n] = str_replace("_", " ", $lista->desc_rnc_pavimento);
			$n++;
		}
		echo(json_encode($dados));
	}

//----------------------------------------------------------------------------------------------------
	public function insereRnc()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["grau"] = $this->input->post_get('grau');
		$dados["data_atividade"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_atividade")))));
		$dados["tipoEixo"] = $this->input->post_get('tipoEixo');
		$dados["km"] = str_replace(",", ".", str_replace(".", "", $this->input->post("km")));

		$dados["latitude"] = $this->input->post_get('coord_UTM_N');
		$dados["longitude"] = $this->input->post_get('coord_UTM_E');
		$dados["data_atualizacao"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_atualizacao")))));
		$dados["data_fechamento"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("data_fechamento")))));
		$dados["status_detalhado"] = $this->input->post_get('status_detalhado');
		$dados["sugestao_providencia"] = $this->input->post_get('sugestao_providencia');

		$retorno = $this->Tb_rnc->insereRnc($dados);
		$dados["id_tela_formulario"] = 37;
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo(json_encode($retorno));
	}

//----------------------------------------------------------------------------------------------------
	public function insereNaoAtividade()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;

		$Dados = $this->Tb_rnc->recupera($dados);
		foreach ($Dados as $lista) {
			$dados["id_rnc"] = $lista->id_rnc;
		}

		$retorno = $this->Tb_rnc->insereNaoAtividade($dados);

		$dados["id_tela_formulario"] = 37;
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------
	public function confereAtividade()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["status"] = $this->input->post_get('status');

		$DadosRnc = $this->Tb_rnc->recupera($dados);
		$dados["data"] = array();

		$dadosNaoAtividade = $this->Tb_rnc->confereAtividade($dados);
		if (!empty($DadosRnc)) {
			$dados["situacao"] = 'Com RNC';
		} else if (!empty($dadosNaoAtividade)) {
			$dados["situacao"] = 'Não Atividade';
		} else {
			$dados["situacao"] = 'Sem Registros';
		}
		echo(json_encode($dados));
	}

//----------------------------------------------------------------------------------------------------
	public function recuperaRNC()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["status"] = $this->input->post_get('status');

		$DadosServico = $this->Tb_rnc->recuperaRNC($dados);

		$dados['data'] = array();
		if (!empty($DadosServico)) {
			foreach ($DadosServico as $i => $lista) {
				if ($lista->status == 'Fechado') {
					$atualizar = "<button type='button' class='btn btn-success' href='javascript:void(0);' onclick=\"modalSituacao({$lista->id_rnc},'{$lista->situacao_providencia}')\"; data-toggle='tooltip' title='Atualizar' data-placement='top'><i class='fa fa-check'></i></button>";
				} else {
					$atualizar = "<button type='button' class='btn btn-danger' href='javascript:void(0);' onclick=\"modalSituacao({$lista->id_rnc},'{$lista->situacao_providencia}')\"; data-toggle='tooltip' title='Atualizar' data-placement='top'><i class='fa fa-clipboard'></i></button>";
				}
				if ($lista->foto > 0) {

					$fotos = "<button type='button' class='btn btn-success' href='javascript:void(0);' onclick='fotos(" . $lista->id_rnc . ");' data-toggle='tooltip' title='Fotos' data-placement='top'><i class='fa fa-camera'></i></button>";
				} else {

					$fotos = "<button type='button' class='btn btn-warning' href='javascript:void(0);' onclick='fotos(" . $lista->id_rnc . ");' data-toggle='tooltip' title='Fotos' data-placement='top'><i class='fa fa-camera'></i></button>";
				}
				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='rotaDocRNC(" . $lista->id_rnc . ");' data-toggle='tooltip' title='Imprimir' data-placement='top'><i class='fa fa-print'></i></button>";

				$acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirRNC(" . $lista->id_rnc . "," . $lista->id_providencia . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				if (empty($lista->status)) {
					$lista->status = 'Aberto';
				}
				$dados["data"][] = array(
					'INFRAESTRUTURA' => $lista->nome_eixo,
					'PERIODO' => $lista->periodo,
					'STATUS' => $lista->status,
					'GRAU' => $lista->desc_gravidade,
					'FOTOS' => $fotos,
					'SITUACAO' => $atualizar,
					'DATA_ATUALIZACAO' => $lista->data_atualizacao,
					'USUARIO' => $lista->usuario,
					'ATUALIZACAO' => $lista->ultima_alteracao,
					'ACAO' => $acao
				);

				if($i == count($DadosServico) - 1){
					$dados["id_tela_formulario"] = '37';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->usuario;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
			}
		} else {
			$Dadosrc = $this->Tb_rnc->confereAtividade($dados);
			$dados["data"] = array();

			if (!empty($Dadosrc)) {
				foreach ($Dadosrc as $lista) {
					$dados["data"][] = array(
						'INFRAESTRUTURA' => '',
						'PERIODO' => '',
						'STATUS' => $lista->descricao,
						'KM' => '',
						'NATUREZA' => '',
						'GRAU' => '',
						'FOTOS' => '',
						'SITUACAO' => '',
						'DATA_ATUALIZACAO' => $lista->ultima_alteracao,
						'USUARIO' => $lista->usuario,
						'ATUALIZACAO' => '',
						'ACAO' => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"excluirRNC({$lista->id})\">
                    <i class='fa fa-trash'></i></a>"
					);
				}
			} else {
				$dados["id_tela_formulario"] = '37';
				$dados["periodo"] = $this->input->post_get("periodo");
				$this->Tb_telas_validacao->limparValidacao($dados);
			}
		}
		echo(json_encode($dados));
	}

//--------------------------------------------Providencia----------------------------------------------------------
	public function consultaSugestao()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_rnc"] = $this->input->post_get('id_rnc');
		$dados["status"] = $this->input->post_get('status');

		$DadosRNC = $this->Tb_rnc->consultaSugestao($dados);

		$dados['data'] = array();
		if (!empty($DadosRNC)) {
			foreach ($DadosRNC as $lista) {
				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirProvidencia(" . $lista->id_providencia . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				$dados["data"][] = array(
					'DESCRICAO' => $lista->descricao_providencia,
					'PROVIDENCIA' => $lista->providencia,
					'DATA_ATUALIZACAO' => $lista->data_atualizacao,
					'USUARIO' => $lista->usuario,
					'ATUALIZACAO' => $lista->ultima_alteracao,
					'ACAO' => $acao
				);
			}
		}
		echo(json_encode($dados));
	}

//------------------------------------------------------------------------------------------------------
	public function insereProvidencia()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_rnc"] = $this->input->post_get('id_rnc');
		$dados["situacao_providencia"] = $this->input->post_get('situacao_providencia');
		$dados["data_atualizacao"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dt_atualizacao")))));
		$dados["data_fechamento"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dt_fechamento")))));
		$dados["descricao_providencia"] = $this->input->post_get('descricao');
		$dados["providencia"] = $this->input->post_get('providencia');

		$DadosRNC = $this->Tb_rnc->consultaProvidencia($dados);

		if (!empty($DadosRNC)) {

			$retorno = $this->Tb_rnc->alteraProvidencia($dados);

		} else {
			$retorno = $this->Tb_rnc->insereProvidencia($dados);
		}
		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------
	public function excluirProvidencia()
	{
		$dados["id_providencia"] = $this->input->post_get('id_providencia');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;

		$retorno = $this->Tb_rnc->excluirProvidencia($dados);

		echo(json_encode($retorno));

	}

//------------------------------------------------------------------------------------------------
	public function excluirRNC()
	{
		$dados["id_rnc"] = $this->input->post_get('id_rnc');
		$dados["id_providencia"] = $this->input->post_get('id_providencia');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;

		$retorno = $this->Tb_rnc->excluirRNC($dados);
		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------
	public function excluiratividade()
	{
		$dados["id_rnc"] = $this->input->post_get('id');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;

		$retorno = $this->Tb_rnc->excluiratividade($dados);
		echo(json_encode($retorno));
	}

//----------------------------------------------foto--------------------------------------------------
	public function RecuperaFotos()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_rnc"] = $this->input->post_get("id_rnc");

		$DadosFotos = $this->Tb_rnc->RecuperaFotos($dados);
		$retorno["data"] = array();

		if (!empty($DadosFotos)) {
			$conte = 1;
			foreach ($DadosFotos as $lista) {
				$path_imagem = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $lista->nome_arquivo);
				 $imagem = "<div>";
                                    $imagem .= "    <a href='" . $path_imagem . "' data-fancybox='group'>";
                                    $imagem .= "        <img src='" . $path_imagem . "' alt='img01' width='45%' height='90px'>";
                                    $imagem .= "    </a>";
                                    $imagem .= "    <div>";
                                    $imagem .= "        <small>Clique na foto para ampliar!</small>";
                                    $imagem .= "    </div>";
                                    $imagem .= "</div>";

				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirFoto(" . $lista->id_rnc_foto . "," . $lista->id_arquivo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				$retorno["data"][] = array(
					'conte' => $conte++,
					'foto' => $imagem,
					'nome_arquivo' => $lista->nomeOriginalArquivo,
					'desc_arquivo' => $lista->descricao,
					'data_atualizacao_foto' => $lista->data_atualizacao,
					'desc_nome' => $lista->usuario,
					'ultima_alteracao' => $lista->ultima_alteracao,
					'acao' => $acao
				);
			}
		}
		echo(json_encode($retorno));
	}

//---------------------------------------------------------------------------------------------------------------------
	public function fotos()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_rnc"] = $this->input->post_get("id_rnc");

		$Dados = $this->Tb_rnc->fotos($dados);
		$dados["data"] = array();
		$dados["Situacao"] = "SemFotos";

		if (!empty($Dados)) {
			foreach ($Dados as $lista) {
				$dados["Situacao"] = "ComFotos";
				$dados["data"][] = array(
					'id_rnc' => $lista->id_rnc,
					'id_rnc_foto' => $lista->id_rnc_foto,
					'id_contrato_obra' => $lista->id_contrato_obra,
					'id_arquivo' => $lista->id_arquivo,
					'nomeOriginalArquivo' => $lista->nomeOriginalArquivo,
					'desc_arquivo' => $lista->desc_arquivo,
					'pasta_origem' => $lista->pasta_origem
				);
			}
		}
		echo(json_encode($dados));
	}

//-----------------------------------------------------------------------------------------------------------------
	public function insereFoto()
	{
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_rnc"] = $this->input->post_get("id_rnc");

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

				$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
				$dados["periodo_referencia"] = $this->input->post_get('periodo');
				$dados["desc_arquivo"] = "RNC";
				$dados["nome_arquivo"] = $nomeArquivo;
				$dados["nomeOriginalArquivo"] = $name;
				$dados["tipo_arquivo"] = "Imagem";
				$dados["pasta_origem"] = "arquivo/img";
				$dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq_cgop . "_4";
				$dados["periodo"] = $this->input->post_get("periodo");
				$dados["extencao"] = $extensao;
				$dados["descricao_foto"] = $this->input->post_get("descricao_foto0$i");
				$dados["dta_atualizacao"] = $this->input->post_get('dta_atualizacao');
				$dados["id_rnc"] = $this->input->post_get('id_rnc');

				$dados["id_arquivo"] = $this->Tb_arquivo->insereArquivo($dados);

				if ($dados["id_arquivo"] !== false) {
					move_uploaded_file($arquivo["tmp_name"][$i], $dir . $nomeArquivo);
					$this->Tb_rnc->insereFoto($dados);
						$retorno["mensagem"] = "Cadastrado com sucesso!";
						$retorno["notify"] = "success";
				} else {
					$retorno["mensagem"] = "Não foi possível enviar o arquivo.";
					$retorno["notify"] = "warning";
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

//------------------------------------------------------------------------------------------------------------------------
	public function excluiRnc()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$arquivolocalho = ("application/homeDaq/arquivoDaq/img/" . $nome_arquivo);
		$retorno = unlink($arquivolocalho);

		echo(json_encode($retorno));
	}


//------------------------------------------------------------------------------------------------------------------------
	public function excluirFoto()
	{
		$dados["id_rnc_foto"] = $this->input->post_get('id_rnc_foto');
		$dados["id_arquivo"] = $this->input->post_get('id_arquivo');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;

		$retorno = $this->Tb_rnc->excluirFoto($dados);

		echo(json_encode($retorno));
	}


//------------------------------------------------------------------------------------------------------------------------

	public function btnimpRNC()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_rnc"] = $this->input->post_get("id");
                
		//--------------------------------------------------------
		$DadosContratoObra = $this->Tb_relatorio->DadosContratoDaq($dados);

		$return['nu_contrato_super'] = $DadosContratoObra[0]["nu_contrato_super"];
		$return['empresa_super'] = $DadosContratoObra[0]["empresa_super"];
		$return['n_contrato_obra'] = $DadosContratoObra[0]["numero_contrato"];
		$return['empresa_obra'] = $DadosContratoObra[0]["empresa_obra"];

		$dadoslocalizacao = $this->Tb_relatorio->dadoslocalizacao($dados);
		if (!empty($dadoslocalizacao)) {
			$return['hidrovia_localizacao'] = $dadoslocalizacao[0]["hidrovia_capa"];
			$return['municio_localizacao'] = $dadoslocalizacao[0]["municipio_capa"];
			$return['extensao_localizacao'] = $dadoslocalizacao[0]["extensao_capa"];
		} else {
			$return['hidrovia_localizacao'] = '-';
			$return['municio_localizacao'] = '-';
			$return['extensao_localizacao'] = '-';
		}
		$registronconformidadesrnc = $this->Tb_rnc->imprimirRnc($dados);
		$registronconformidadesrncFoto = $this->Tb_rnc->RecuperaFotosImp($dados);

		$return['registronconformidadesrnc'] = $registronconformidadesrnc;
		$return['registronconformidadesrncFoto'] = $registronconformidadesrncFoto;

		$this->load->view('/supervisaodaq/rnc/Rncbtn', $return);

	}


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT-Falconi AQUAVIARIO
//# Desenvolvedor:Jordana de Alencar
//########################################################################################################################################################################################################################







