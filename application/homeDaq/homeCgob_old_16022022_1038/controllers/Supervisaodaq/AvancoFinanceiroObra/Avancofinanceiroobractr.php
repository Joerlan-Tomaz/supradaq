<?php
/*
 * Classe controller Avancofinanceiroobractr. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Avancofinanceiroobractr extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('/Supervisaodaq/Tb_avanco_financeiro');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function RecuperaMedicaoNaopublicado()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$DadosMedicao = $this->Tb_avanco_financeiro->RecuperaMedicaoNaopublicado($dados);
		$retorno["data"] = array();

		$conte = (count($DadosMedicao));

		if (!empty($DadosMedicao)) {
			$linha = 1;
			foreach ($DadosMedicao as $lista) {

				if ($lista->publicar_versao <> 1) {

					if ($lista->valor_pi_medicao == $lista->valor && $lista->valor <> 0) {
						$publicar = "<button type='button' id='publicado_naopublicado_$linha' name='publicado_naopublicado_$linha' class='btn btn-default'  href='javascript:void(0);' onclick='PublicarNaopublicado(" . $lista->numemedicao . "," . $linha . "," . $conte . ")' data-toggle='tooltip' title='Publicar Avanço.' data-placement='top'><i class = 'fa fa-ship'></i></buttonx>";
					} else {
						$publicar = "<button href='javascript:void(0);' onclick='MsgPublicar(" . $lista->numemedicao . "," . $linha . "," . $conte . ");' type='button' id='publicar_naopublicado_$linha' name='publicar_naopublicado_$linha' class='btn btn-default'  data-toggle='tooltip' title='Não permitido! Para ação [PUBLICAR], o [Valor Lançado] deve ser igual ao [Valor Medição]' data-placement='top'>--</buttonx>";
					}

					$detalhar = "<button type='button' id='detalhar_naopublicado_$linha' name='detalhar_naopublicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaDetalhadoNaopublicado(" . $lista->numemedicao . "," . $linha . "," . $conte . ")'><i class = 'fa fa-eye'></i></buttonx>";

					$inserir = "<button type='button' title='Necessário Publicar Cronograma Financeiro!' id='inserir_naopublicado_$linha' name='inserir_naopublicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaincluirAvanco(" . $lista->numemedicao . "," . $linha . "," . $conte . ")'><i class = 'fas fa-pencil-alt'></i></buttonx>";


					$retorno["data"][] = array(
						'nume_medicao' => $lista->numemedicao,
						'mes_referencia' => $lista->data_termino_medicao,
						'valor_medicao' => "R$" . number_format($lista->valor_pi_medicao, 2, ",", "."),
						'data_processamento_medicao' => $lista->data_processamento_medicao,
						'valor_lancado' => "R$" . number_format($lista->valor, 2, ",", "."),
						'publicado' => "Não",
						'detalhar' => $detalhar,
						'incluir' => $inserir,
						'publicar' => $publicar
					);
					$linha++;
				}
			}
		}
		echo(json_encode($retorno));
	}

//----------------------------------------------------------------------------------------------------------------------------
	public function recuperaObra()
	{
		$DadosServico = $this->Tb_avanco_financeiro->recuperaObra();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_obra'][$n] = $lista->id_tipo_obra;
			$dados['obra'][$n] = str_replace("_", " ", $lista->desc_tipo_obra);
			$n++;
		}
		echo(json_encode($dados));
	}

//---------------------------------------------------------------------------------
	public function recuperaServico()
	{
		$dados["id_obra"] = $this->input->post_get("id_obra");
		$dados["idContrato"] = $this->session->idContrato;

		$Versao = $this->Tb_avanco_financeiro->recuperaVersao($dados);
		$dados["versao"] = 0;
		if (!empty($Versao)) {
			foreach ($Versao as $lista) {
				$dados["versao"] = $lista->versao;
			}
		}

		if ($dados["id_obra"] == 1) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraConstrucao($dados); // TROQUEI POR CONSTRUÇÂO PORTUARIA
		}
		if ($dados["id_obra"] == 2) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraDerrocagem($dados); // permanece
		}
		if ($dados["id_obra"] == 3) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraDragagem($dados); // permanece
		}
		if ($dados["id_obra"] == 4) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraDesobstrucao($dados); // permanece
		}
		if ($dados["id_obra"] == 5) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraRecuperacao($dados); // TROQUEI por RECUPERACAO PORTUARIA
		}
		if ($dados["id_obra"] == 6) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraMonitoramento($dados); // TROQUEI por MONITORAMENTO HIDROVIARIO
		}
		if ($dados["id_obra"] == 7) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraNavioHaider($dados); //permanece
		}
		if ($dados["id_obra"] == 8) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraSinalHidro($dados); // OPERACAO
		}
		if ($dados["id_obra"] == 9) {
			$dadosServico = $this->Tb_avanco_financeiro->recuperaObraEclusas($dados); // OPERACAO
		}

		$n = 0;
		if (!empty($dadosServico)) {
			foreach ($dadosServico as $lista) {
				$dados['id_servico'][$n] = $lista->id_obra;
				$dados['servico'][$n] = str_replace("_", " ", $lista->desc_obra);
				$n++;
			}
		} else {
			$dados['id_servico'][$n] = 0;
			$dados['servico'][$n] = 'Sem Serviço Publicado Obra';
		}
		echo(json_encode($dados));
	}

//------------------------------------------------------------------------
	public function recuperaTipo()
	{
		$dados["id_servico"] = $this->input->post_get("servico");

		if ($dados["id_servico"] == 16) {

			$dadosTipo = $this->Tb_avanco_financeiro->recuperaTipoEstruturaNaval($dados);

		} else {
			$dadosTipo = $this->Tb_avanco_financeiro->recuperaTipo($dados);
		}


		$n = 0;
		foreach ($dadosTipo as $lista) {
			$dados['id_tipo'][$n] = $lista->id_tipo;
			$dados['tipo'][$n] = str_replace("_", " ", $lista->desc_tipo);
			$n++;
		}
		echo(json_encode($dados));
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function RecuperaMedicaoNumeMedicao()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["numemedicao"] = $this->input->post_get("numemedicao");

		$DadosMedicao = $this->Tb_avanco_financeiro->RecuperaMedicaoNumeMedicao($dados);
		$retorno["data"] = array();

		if (!empty($DadosMedicao)) {
			$linha = 1;
			foreach ($DadosMedicao as $lista) {

				$retorno["data"][] = array(
					'n' => $linha++,
					'nume_medicao' => $lista->numemedicao,
					'mes_referencia' => $lista->data_termino_medicao,
					'valor_medicao' => "R$" . number_format($lista->valor_pi_medicao, 2, ",", "."),
					'data_processamento_medicao' => $lista->data_processamento_medicao,
					'valor_lancado' => "R$" . number_format($lista->valor, 2, ",", ".")
				);
			}
		}
		echo(json_encode($retorno));
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function insereAvanco()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["numemedicao"] = $this->input->post_get("numemedicao");

		$dadomedicao = $this->Tb_avanco_financeiro->nu_medicao($dados);

		$dados["id_servico"] = $this->input->post_get("servico");
		$dados["id_obra"] = $this->input->post_get("obra");
		$dados["tipo"] = $this->input->post_get("tipo");
		$dados["valor"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor")));
		$dados["mes"] = $dadomedicao[0]["mes_medicao"];
		$dados["ano"] = $dadomedicao[0]["ano_medicao"];

		$retorno = $this->Tb_avanco_financeiro->insereAvanco($dados);
		echo(json_encode($retorno));
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function RecuperaDetalhado()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["numemedicao"] = $this->input->post_get("numemedicao");
		$excluir = $this->input->post_get("excluir");

		$DadosDetalhado = $this->Tb_avanco_financeiro->RecuperaDetalhado($dados);
		$retorno["data"] = array();

		if (!empty($DadosDetalhado)) {
			$linha = 1;
			foreach ($DadosDetalhado as $lista) {

				if ($excluir == 1) {
					$acao = "<button type='button' id='excluir_$linha' name='excluir_$linha' class='btn btn-default' href='javascript:void(0);' onclick='ExcluirAvancoExterno(" . $lista->id . ");'><i class = 'fa fa-trash'></i></buttonx>";
				} elseif ($excluir == 2) {
					$acao = "<button type='button' id='excluir_$linha' name='excluir_$linha' class='btn btn-default' href='javascript:void(0);' onclick='ExcluirAvancoInterno(" . $lista->id . ");'><i class = 'fa fa-trash'></i></buttonx>";
				} else {
					$acao = "<button type='button' id='excluir_$linha' name='excluir_$linha' class='btn btn-default'>--</buttonx>";
				}
				if ($lista->tipo_obra == '') {
					$lista->tipo_obra = "--";
				}
				$retorno["data"][] = array(
					'n' => $linha++,
					'obra' => $lista->desc_obra,
					'servico' => $lista->desc_servico,
					'tipo' => $lista->tipo_obra,
					'valor' => "R$" . number_format($lista->valor, 2, ",", "."),
					'desc_nome' => $lista->nome,
					'ultima_alteracao' => $lista->ultima_alteracao,
					'acao' => $acao
				);
			}
		}
		echo(json_encode($retorno));
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function RecuperaMedicaopublicado()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$DadosMedicao = $this->Tb_avanco_financeiro->RecuperaMedicaopublicado($dados);
		$retorno["data"] = array();

		$conte = (count($DadosMedicao));

		if (!empty($DadosMedicao)) {
			$linha = 1;
			foreach ($DadosMedicao as $lista) {

				$detalhar = "<button type='button' id='detalhar_publicado_$linha' name='detalhar_publicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='RecuperaDetalhadoPublicado(" . $lista->numemedicao . "," . $linha . "," . $conte . ");'><i class = 'fa fa-eye'></i></buttonx>";

				$incluir = "<button type='button' id='inserir_publicado_$linha' name='inserir_publicado_$linha' class='btn btn-default'>--</buttonx>";
				$publicar = "<button type='button' id='publicar_publicado_$linha' name='publicar_publicado_$linha' class='btn btn-default'>--</buttonx>";


				$retorno["data"][] = array(
					'nume_medicao' => $lista->numemedicao,
					'mes_referencia' => $lista->data_termino_medicao,
					'valor_medicao' => "R$" . number_format($lista->valor_pi_medicao, 2, ",", "."),
					'data_processamento_medicao' => $lista->data_processamento_medicao,
					'valor_lancado' => "R$" . number_format($lista->valor, 2, ",", "."),
					'publicado' => "Sim",
					'detalhar' => $detalhar,
					'incluir' => $incluir,
					'publicar' => $publicar
				);
				$linha++;
			}
		}
		echo(json_encode($retorno));
	}

//----------------------------------------------------------------------------------------------------------------------------

	public function PublicarNaopublicado()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["numemedicao"] = $this->input->post_get("numemedicao");
		$dados["id_avanco_financeiro_publicar"] = $this->input->post_get('id_avanco_financeiro_publicar');

		if (isset($dados)) {
			$retorno = $this->Tb_avanco_financeiro->PublicarNaopublicado($dados);

			echo(json_encode($retorno));
		}

	}

//----------------------------------------------------------------------------------------------------------------------------
	public function excluirAvanco()
	{
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["id"] = $this->input->post_get('id');

		$retorno = $this->Tb_avanco_financeiro->excluirAvanco($dados);

		echo(json_encode($retorno));

	}


}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT-Falconi
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/04/2020 15:00
//########################################################################################################################################################################################################################
