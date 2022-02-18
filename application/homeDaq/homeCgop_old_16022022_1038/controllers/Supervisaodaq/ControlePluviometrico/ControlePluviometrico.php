<?php
/*
 * Classe controller ControlePluviometrico. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class ControlePluviometrico extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('/Supervisaodaq/Tb_controle_pluviometrico');
		$this->load->model('/Supervisaodaq/Tb_avanco_financeiro');
		$this->load->model('/Supervisaodaq/Tb_licencas_ambientais');
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}


	//-------------------------------------------Insere-----------------------------------------
	public function insereControlePluv()
	{
		$totaldias = $this->input->post_get('totalDias');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;

		for ($j = 1; $j <= $totaldias; $j++) {
			$dia = $j;
			$situacao = $this->input->post_get("cp_manha_$j");

			if (!empty($situacao)) {
				$dados["dia"] = $dia;
				$dados["infraestrutura"] = $this->input->post_get('infraestrutura');
				$dados["situacao"] = ($situacao != 'Selecione') ? $situacao : '';

				$Dados = $this->Tb_controle_pluviometrico->ConsultaControlePluv($dados);
				foreach ($Dados as $lista) {
					$conte_id = $lista->conte_id;
				}
				if ($conte_id == 'N') {
					$retorno = $this->Tb_controle_pluviometrico->insereControlePluv($dados);
				} else {
					$retorno = $this->Tb_controle_pluviometrico->alteraControlePluv($dados);
				}
				$dados["id_tela_formulario"] = 31;
				$dados["periodo"] = $this->input->post_get("periodo");
				$this->Tb_telas_validacao->inserir_validacao($dados);
			}
		}
		echo(json_encode($retorno));
	}


	public function recuperaControlePluv()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["data"] = array();
		$dadosInfras = $this->Tb_licencas_ambientais->populaNomeInfra($dados);
		$data = explode('-',$dados["periodo"]);
		$totaldias = cal_days_in_month(CAL_GREGORIAN, $data[1],$data[0]);

		$dias = array();
		$verificaControle = false;
		foreach ($dadosInfras as $linha => $listaInfra) {
			$dados['infraestrutura'] = $listaInfra->nome_eixo;
			$dadosControlePluv = $this->Tb_controle_pluviometrico->recuperaControlePluv($dados);
			for($i = 1; $i < $totaldias; $i++){
				$color = '#DCDCDC';
				$dias[$i] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="Sem Preenchimento">'. str_pad($i, 2, 0, STR_PAD_LEFT) .'</a>  ';
			}
			$nomeUltimaAlteração = '';
			$dataUltimaAlteração = '';

			if(count($dadosControlePluv) > 0){
				foreach($dadosControlePluv as $diasControle){
					if($diasControle->situacao == null){
						$color = '#DCDCDC';
					}else if($diasControle->situacao == 'Bom'){
						$color = '#ADD8E6';
					}else if($diasControle->situacao == 'Chuva'){
						$color = '#6495ED';
					}else if($diasControle->situacao == 'Impraticável'){
						$color = '#0000CD';
					}else if($diasControle->situacao == 'Instavel'){
						$color = '#20B2AA';
					}else if($diasControle->situacao == 'Não houveram atividades'){
						$color = '#008080';
					}
					$dias[$diasControle->dia] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="'.$diasControle->situacao .'">'. str_pad($diasControle->dia, 2, 0, STR_PAD_LEFT) .'</a>  ';
					$nomeUltimaAlteração = $diasControle->nome;
					$dataUltimaAlteração = $diasControle->ultima_alteracao;
				}
				$verificaControle = false;
			}

			$inserir = "<button type='button' id='editar_$linha' name='editar_$linha' class='btn btn-default' href='javascript:void(0);' onclick='editar(\"" . $listaInfra->nome_eixo . "\")'><i class = 'fas fa-pencil-alt'></i></buttonx>";
			$dados["data"][] = array(
				'infraestrutura' => $listaInfra->nome_eixo,
				'dias' => implode(' ', $dias),
				'nome' => $nomeUltimaAlteração,
				'ultima_alteracao' => $dataUltimaAlteração,
				'acao' => $inserir
			);

			if($linha == count($dadosControlePluv) - 1){
				$dados["id_tela_formulario"] = '43';
				$dados["periodo"] = $this->input->post_get("periodo");
				$dados["nome_usuario"] = $lista->nome;
				$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
				$this->Tb_telas_validacao->inserir_validacao($dados);
			}
		}
		if($verificaControle){
			$dados["id_tela_formulario"] = '31';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($dados));
	}

	public function editarControlePluv(){
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["infraestrutura"] = $this->input->post_get("infraestrutura");

		$dadosControleMes = $this->Tb_controle_pluviometrico->EditarControlePluv($dados);
		$dados["id_tela_formulario"] = 31;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);
		$retorno = array();
		foreach($dadosControleMes as $dadosDia){
			$retorno[$dadosDia->dia] = $dadosDia->situacao;
		}
		echo(json_encode($retorno));
	}

	public function excluirDia()
	{
		$dados["id_controle_pluviometrico"] = $this->input->post_get('id_controle_pluviometrico');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$retorno = $this->Tb_controle_pluviometrico->excluirDia($dados);
		echo(json_encode($retorno));
	}


	public function Recuperadiasmes()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');

		$Dados = $this->Tb_controle_pluviometrico->Recuperadiasmes($dados);


		foreach ($Dados as $lista) {
			$conte = $lista->conte;
		}


		$ano = substr($this->input->post_get("periodo"), 0, 4);
		$mes = substr($this->input->post_get("periodo"), 5, 2);

		$funcao = new DateTime($ano . "-" . $mes);
		$numDias = $funcao->format('t');

		if ($conte == $numDias) {
			$dados["conte"] = true;
		} else {
			$dados["conte"] = false;
		}
		echo(json_encode($dados));
	}

	public function insereNaoAtividade()
	{
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["periodo"] = $this->input->post_get('periodo');
		$retorno = $this->Tb_controle_pluviometrico->insereNaoAtividade($dados);

		$dados["id_tela_formulario"] = 31;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo(json_encode($retorno));
	}

	public function confereAtividade()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');

		$DadosControle = $this->Tb_controle_pluviometrico->recuperaControlePluv($dados);
		$dados["data"] = array();

		$dadosNaoAtividade = $this->Tb_controle_pluviometrico->confereAtividade($dados);
		if (!empty($DadosControle)) {
			$dados["situacao"] = 'Com Atividade';
		} else if (!empty($dadosNaoAtividade)) {
			$dados["situacao"] = 'Sem Atividade';
		} else {
			$dados["situacao"] = 'Sem Registros';
		}
		echo(json_encode($dados));
	}

}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 27/01/2020 13:00
//########################################################################################################################################################################################################################
