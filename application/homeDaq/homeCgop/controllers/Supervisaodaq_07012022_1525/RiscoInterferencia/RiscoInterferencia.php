<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class RiscoInterferencia extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('/Supervisaodaq/Tb_riscos_interferencias');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	//------------------------------------------------------------------------------------

	public function recupera_TipoInterferencia()
	{
		$DadosServico = $this->Tb_riscos_interferencias->popula_TipoInterferencia();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_tipo_interferencia'][$n] = $lista->id_tipo_interferencia;
			$dados['desc_tipo'][$n] = str_replace("_", " ", $lista->desc_tipo);
			$n++;
		}
		echo(json_encode($dados));
	}

	public function recuperaClassificacao()
	{
		$DadosServico = $this->Tb_riscos_interferencias->recuperaClassificacao();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_classificacao'][$n] = $lista->id_classificacao;
			$dados['desc_classificacao'][$n] = str_replace("_", " ", $lista->desc_classificacao);
			$n++;
		}
		echo(json_encode($dados));
	}


	public function recuperaGrauImpacto()
	{
		$DadosServico = $this->Tb_riscos_interferencias->recuperaGrauImpacto();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_grau_impacto'][$n] = $lista->id_grau_impacto;
			$dados['desc_grau_impacto'][$n] = str_replace("_", " ", $lista->desc_grau_impacto);
			$n++;
		}
		echo(json_encode($dados));
	}


	public function populaTipoEixo()
	{
		$DadosServico = $this->Tb_riscos_interferencias->populaTipoEixo();
		$n = 0;
		foreach ($DadosServico as $lista) {
			$dados['id_tipo_eixo'][$n] = $lista->id_eixo;
			$dados['desc_tipo_eixo'][$n] = str_replace("_", " ", $lista->eixo);
			$n++;
		}
		echo(json_encode($dados));
	}

//-----------------------------------------------------------------------------------------------------------------
	public function insereInterferencia()
	{
		$dados["id_riscos_interferencias"] = $this->input->post_get('id_riscos_interferencias');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;

		$dados["assunto"] = $this->input->post_get('descricao');
		$dados["km_inicial"] = str_replace(",", ".", str_replace(".", "", $this->input->post("kmInicial")));
		$dados["km_final"] = str_replace(",", ".", str_replace(".", "", $this->input->post("kmFinal")));

		$dados["resumo"] = $this->input->post_get('resumoInterferencias');
		$dados["providencia"] = $this->input->post_get('providencia');

		$dados["tipoInterferencia"] = $this->input->post_get('tipoInterferencia');
		$dados["classificacao"] = $this->input->post_get('classificacao');
		$dados["grauImpacto"] = $this->input->post_get('grauImpacto');
		$dados["br"] = $this->input->post_get('br');
		$dados["efeito"] = $this->input->post_get('efeito');
		$dados["tipoEixo"] = $this->input->post_get('tipoEixo');
		$dados["impactoCusto"] = $this->input->post_get('impactoCusto');
		$dados["impactoPrazo"] = $this->input->post_get('impactoPrazo');
		$dados["previsao_solucao"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("previsaoSolucao")))));
		$dados["data_limite"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("dataLimite")))));

		$retorno = $this->Tb_riscos_interferencias->insereInterferencia($dados);

		$dados["id_tela_formulario"] = 39;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo(json_encode($retorno));

	}

//-------------------------------------------------------------------------------------------------------------------
	public function recuperaNaoAtividade()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["risco"] = false;
		$NaoAtividade = $this->Tb_riscos_interferencias->recuperaRiscosAtividade($dados);
		$dados["data"] = array();

		if (!empty($NaoAtividade)) {
			$dados["risco"] = true;
			foreach ($NaoAtividade as $i => $lista) {

				$dados["data"][] = array(
					'atividademes' => $lista->atividademes,
					'ultima_alteracao' => $lista->ultima_alteracao,
					'usuario' => $lista->nome,
					'acoes' => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"NaoHouveAtividadedaq({$lista->id})\">
                    <i class='fa fa-trash'></i></a>"
				);

				$dados["id_tela_formulario"] = '39';
				$dados["periodo"] = $this->input->post_get("periodo");
				$dados["nome_usuario"] = $lista->nome;
				$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
				$this->Tb_telas_validacao->inserir_validacao($dados);
			}
		}
		echo(json_encode($dados));
	}

	//-------------------------------------------------------------------------------------------------------------------

	public function recuperaInterferencia()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$Dados = $this->Tb_riscos_interferencias->recuperaInterferencia($dados);
		$retorno["data"] = array();

		if (!empty($Dados)) {
			$linha = 1;
			foreach ($Dados as $i => $lista) {

				$resumo = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'descricaoInterferencia(" . $lista->id_riscos_interferencias . ")'><i class = 'fa fa-eye'></i></button >";

				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='recuperaInterferenciaEditar(" . $lista->id_riscos_interferencias . "," . $linha . ")'><i class = 'fa fa-pencil'></i></button > <button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirInterferencia(" . $lista->id_riscos_interferencias . ")'><i class = 'fa fa-trash'></i></button >";

				$km = "(" . $lista->km_inicial . ") ao (" . $lista->km_final . ")";

				$retorno["data"][] = array(
					'CONTE' => $linha,
					'TIPO' => $lista->desc_tipo,
					'GRAU_IMPACTO' => $lista->desc_grau_impacto,
					'CLASSIFICACAO' => $lista->desc_classificacao,
					'EIXO' => $lista->desc_tipo_eixo,
					'BR' => $lista->br,
					'KMINICIAL' => str_replace(".", ",", $lista->km_inicial),
					'KMFIM' => str_replace(".", ",", $lista->km_final),
					'PREVISAO_SOLUCAO' => $lista->previsao_solucao,
					'DATA_LIMITE' => $lista->data_limite,
					'RESUMO' => $resumo,
					'USUARIO' => $lista->nome,
					'ATUALIZACAO' => $lista->ultima_alteracao,
					'ACAO' => $acao
				);

				if($i == count($Dados) - 1){
					$dados["id_tela_formulario"] = '39';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->nome;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
				$linha = $linha + 1;
			}
		} else {
			$dados["id_tela_formulario"] = '39';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($retorno));
	}

	//----------------------------------------------------------------------------------------------------------------------------------------

	public function consultaDescricaoInterferencia()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_riscos_interferencias"] = $this->input->post_get('id_riscos_interferencias');
		$dados["periodo"] = $this->input->post_get('periodo');

		$DadosServico = $this->Tb_riscos_interferencias->descricaoInterferencia($dados);

		foreach ($DadosServico as $lista) {
			$dados['descricao'] = $lista->resumo;
			$dados['providencia'] = $lista->providencia;
		}
		echo(json_encode($dados));
	}

	//----------------------------------------------------------------------------------------------------------------------------------------

	public function RecuperaInterferenciaEditar()
	{

		$dados["id_riscos_interferencias"] = $this->input->post_get('id_riscos_interferencias');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$DadosServico = $this->Tb_riscos_interferencias->RecuperaInterferenciaEditar($dados);

		foreach ($DadosServico as $lista) {

			$dados['descricao'] = $lista->assunto;

			$dados['kmInicial'] = number_format($lista->km_inicial, 2, ",", ".");
			$dados['kmFinal'] = number_format($lista->km_final, 2, ",", ".");

			$dados['resumo'] = $lista->resumo;
			$dados['providencia'] = $lista->providencia;
			$dados['previsao_solucao'] = $lista->previsao_solucao;
			$dados['data_limite'] = $lista->data_limite;

			$dados['desc_tipo_risco_interferenciar'] = $lista->id_tipo_interferencia;
			$dados['desc_classificacao'] = $lista->id_classificacao;
			$dados['desc_grau_impacto'] = $lista->id_grau_impacto;
			$dados['brEditar'] = $lista->br;
			$dados['efeito'] = $lista->efeito_interferencia;
//			$dados['desc_eixo'] = $lista->id_tipo_eixo;
			$dados['impacto_custo'] = $lista->impacto_custo;
			$dados['impacto_prazo'] = $lista->impacto_prazo;
		}
		echo(json_encode($dados));
	}


	public function editarInterferencia()
	{
		$dados["id_riscos_interferencias"] = $this->input->post_get('id');
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;

		$dados["assunto"] = $this->input->post_get('descricaoEditar');
		$dados["km_inicial"] = str_replace(",", ".", str_replace(".", "", $this->input->post("kmInicialEditar")));
		$dados["km_final"] = str_replace(",", ".", str_replace(".", "", $this->input->post("kmFinalEditar")));

		$dados["resumo"] = $this->input->post_get('resumoInterferenciasEditar');
		$dados["providencia"] = $this->input->post_get('providenciaEditar');

		$dados["tipoInterferenciaEditar"] = $this->input->post_get('tipoInterferenciaEditar');
		$dados["classificacaoEditar"] = $this->input->post_get('classificacaoEditar');
		$dados["grauImpactoEditar"] = $this->input->post_get('grauImpactoEditar');

		$dados["br"] = $this->input->post_get('brEditar');
		$dados["efeito_interferencia"] = $this->input->post_get('efeitoEditar');
		$dados["tipoEixoEditar"] = $this->input->post_get('tipoEixoEditar');
		$dados["impacto_custo"] = $this->input->post_get('impactoCustoEditar');
		$dados["impacto_prazo"] = $this->input->post_get('impactoPrazoEditar');


		$dados["previsao_solucao"] = $this->input->post_get('previsaoSolucaoEditar');
		$dados["data_limite"] = $this->input->post_get('dataLimiteEditar');

		$retorno = $this->Tb_riscos_interferencias->editarInterferencia($dados);

		$dados["id_tela_formulario"] = 39;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo(json_encode($retorno));
	}


//-------------------------------------------------------------------------------------------------------------

	public function excluirInterferencia()
	{
		$dados["id_riscos_interferencias"] = $this->input->post_get('id_riscos_interferencias');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$retorno = $this->Tb_riscos_interferencias->excluirInterferencia($dados);
		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------------
	public function insereNaoAtividade()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["periodo"] = $this->input->post_get('periodo');
		$retorno = $this->Tb_riscos_interferencias->insereNaoAtividadeRiscos($dados);

		$dados["id_tela_formulario"] = 39;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo(json_encode($retorno));
	}

//-------------------------------------------------------------------------------------------------------------
	public function NaoHouveAtividadedaq()
	{
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["id"] = $this->input->post_get('id');
		$retorno = $this->Tb_riscos_interferencias->NaoHouveAtividadedaq($dados);
		echo(json_encode($retorno));

	}

}//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 01/11/2019 13:00
//########################################################################################################################################################################################################################

 
