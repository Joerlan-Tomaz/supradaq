<?php
/*
 * Classe controller ControleFluviometrico.
 * @author Pedro Correia <pedro.correia86@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');
 ini_set('display_errors', 1);
 error_reporting(E_ALL);
class ControleFluviometrico extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('/Supervisaodaq/Tb_controle_fluviometrico');
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
	public function insereControleFluv(){ 
	
		$totaldias = $this->input->post_get('totalDias');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
               
               
              
		for ($j = 1; $j <= $totaldias; $j++) {
			$dia = $j;

			if($this->input->post_get("cp_manha_$j") != 'Selecione' && $this->input->post_get("cp_manha_$j") != '' || $this->input->post_get("cp_tarde_$j") != 'Selecione' && $this->input->post_get("cp_tarde_$j") != ''){  
				$dados["dia"] = $dia;
				$dados["infraestrutura"] = $this->input->post_get('infraestrutura');
				$dados["manha"] = $this->input->post_get("cp_manha_$j");
				$dados["manha_nivel"] = $this->input->post_get("nivel_manha_$j");
				//$dados["jusante_manha"] = $this->input->post_get("jusante_manha_$j");
				$dados["tarde"] = $this->input->post_get("cp_tarde_$j");
				$dados["tarde_nivel"] = $this->input->post_get("nivel_tarde_$j");
				//$dados["jusante_tarde"] = $this->input->post_get("jusante_tarde_$j");

				$Dados = $this->Tb_controle_fluviometrico->ConsultaControleFluv($dados);
				foreach ($Dados as $lista) {
					$conte_id = $lista->conte_id;
				}
				if ($conte_id == 'N') {
					$retorno = $this->Tb_controle_fluviometrico->insereControleFluv($dados);
				} else {
					$retorno = $this->Tb_controle_fluviometrico->alteraControleFluv($dados);
				}
				$dados["id_tela_formulario"] = 32;
				$dados["periodo"] = $this->input->post_get("periodo");
				$this->Tb_telas_validacao->inserir_validacao($dados);
			}
                        if($this->input->post_get("jusante_manha_$j") != 'Selecione' && $this->input->post_get("jusante_manha_$j") != ''){ 
				$dados["dia"] = $dia;
				$dados["infraestrutura"] = $this->input->post_get('infraestrutura');
				//$dados["manha"] = $this->input->post_get("cp_manha_$j");
				$dados["manha_nivel"] = $this->input->post_get("nivel_manha_$j");
				$dados["jusante_manha"] = $this->input->post_get("jusante_manha_$j");
				//$dados["tarde"] = $this->input->post_get("cp_tarde_$j");
				$dados["tarde_nivel"] = $this->input->post_get("nivel_tarde_$j");
				$dados["jusante_tarde"] = $this->input->post_get("jusante_tarde_$j");
                                
                                
				$Dados = $this->Tb_controle_fluviometrico->ConsultaControleFluv($dados);
				foreach ($Dados as $lista) {
					$conte_id = $lista->conte_id;
				}
                                
				if ($conte_id == 'N') { 
					$retorno = $this->Tb_controle_fluviometrico->insereControleFluv($dados);
				} else {
					$retorno = $this->Tb_controle_fluviometrico->alteraControleFluv($dados);                                        
				}
				$dados["id_tela_formulario"] = 32;
				$dados["periodo"] = $this->input->post_get("periodo");
				$this->Tb_telas_validacao->inserir_validacao($dados);
			}
		}
		echo(json_encode($retorno));
	}

	public function recuperaControleFluv(){ 
	
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["data"] = array();
		$dadosInfras = $this->Tb_licencas_ambientais->populaNomeInfra($dados); 
		$data = explode('-',$dados["periodo"]);
		$totaldias = cal_days_in_month(CAL_GREGORIAN, $data[1],$data[0]);

		$diasManha = array();
		$diasTarde = array();
		$verificaControle = false; 
		foreach ($dadosInfras as $linha => $listaInfra) {
			$dados['infraestrutura'] = $listaInfra->nome_eixo;
			$dadosControleFluv = $this->Tb_controle_fluviometrico->recuperaControleFluv($dados);
			for($i = 1; $i <= $totaldias; $i++){
				$color = '#DCDCDC';
				$diasManha[$i] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="Sem Preenchimento">'. str_pad($i, 2, 0, STR_PAD_LEFT) .'</a>  ';
				$diasTarde[$i] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="Sem Preenchimento">'. str_pad($i, 2, 0, STR_PAD_LEFT) .'</a>  ';
                                
			}
                        
			$nomeUltimaAlteração = '';
			$dataUltimaAlteração = '';

			$eclusa = 'não';
			if(count($dadosControleFluv) > 0){
				foreach($dadosControleFluv as $x => $diasControle){
					if($diasControle->manha == NULL or $diasControle->manha == 'Selecione'){
						$color = '#DCDCDC';
					}else if($diasControle->manha == 'Em Operação'){
						$color = '#37bf48';
					}else if($diasControle->manha == 'Fora de Operação'){
						$color = '#c13259';
					}else if($diasControle->manha == 'Não Aplicável'){
						$color = '#7e757d';
					}
					$tooltip = "Nível: " . $diasControle->manha_nivel .'cm';
					if(isset($diasControle->jusante_manha)){
						$eclusa = 'sim';
						$tooltip = "Montante: " . $diasControle->manha_nivel .'(cm) - Jusante: ' . $diasControle->jusante_manha . '(cm)';
					}
					$diasManha[$diasControle->dia] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="'. $tooltip .'">'. str_pad($diasControle->dia, 2, 0, STR_PAD_LEFT) .'</a>  ';

					if($diasControle->tarde == NULL or $diasControle->tarde == 'Selecione'){
						$color = '#DCDCDC';
					}else if($diasControle->tarde == 'Em Operação'){
						$color = '#37bf48';
					}else if($diasControle->tarde == 'Fora de Operação'){
						$color = '#c13259';
					}else if($diasControle->tarde == 'Não Aplicável'){
						$color = '#7e757d';
					}

					$tooltip = "Nível: " . $diasControle->tarde_nivel .'cm';
					if(isset($diasControle->jusante_tarde)){
						$eclusa = 'sim';
						$tooltip = "Montante: " . $diasControle->tarde_nivel .'(cm) - Jusante: ' . $diasControle->jusante_tarde . '(cm)';
					}
					$diasTarde[$diasControle->dia] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="'. $tooltip .'">'. str_pad($diasControle->dia, 2, 0, STR_PAD_LEFT) .'</a>  ';

					$nomeUltimaAlteração = $diasControle->nome;
					$dataUltimaAlteração = $diasControle->ultima_alteracao;
					$verificaControle = false;
				}
			}

			$inserir = "<button type='button' id='editar_$linha' name='editar_$linha' class='btn btn-default' href='javascript:void(0);' onclick='editar(\"" . $listaInfra->nome_eixo . "\",\"" . $eclusa . "\")'><i class = 'fas fa-pencil-alt'></i></buttonx>";
			$dados["data"][] = array(
				'infraestrutura' => $listaInfra->nome_eixo,
				'dias' => 'Infraestrutura - ' . implode(' ', $diasManha) . '</br>' . 'Fábrica de Gelo - ' . implode(' ', $diasTarde),
				'nome' => $nomeUltimaAlteração,
				'ultima_alteracao' => $dataUltimaAlteração,
				'acao' => $inserir
			);
                        if(count($dadosControleFluv) > 0){
			if($x == count($dadosControleFluv) - 1){
				$dados["id_tela_formulario"] = '32';
				$dados["periodo"] = $this->input->post_get("periodo");
				$dados["nome_usuario"] = $nomeUltimaAlteração;
				$dados["data_ultima_alteracao"] = $dataUltimaAlteração;
				$this->Tb_telas_validacao->inserir_validacao($dados);
			}
                        }
		}
		if($verificaControle){
			$dados["id_tela_formulario"] = '32';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($dados));
	}
        public function recuperaControleFluvEclusa(){ 
	
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["data"] = array();
		$dadosInfras = $this->Tb_licencas_ambientais->populaNomeInfra($dados); 
		$data = explode('-',$dados["periodo"]);
		$totaldias = cal_days_in_month(CAL_GREGORIAN, $data[1],$data[0]);

		$diasManha = array();
		$diasTarde = array();
		$verificaControle = false; 
		foreach ($dadosInfras as $linha => $listaInfra) {
			$dados['infraestrutura'] = $listaInfra->nome_eixo;
			$dadosControleFluv = $this->Tb_controle_fluviometrico->recuperaControleFluv($dados);
			for($i = 1; $i <= $totaldias; $i++){
				$color = '#DCDCDC';
				$diasManha[$i] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="Sem Preenchimento">'. str_pad($i, 2, 0, STR_PAD_LEFT) .'</a>  ';
				
                                
			}
                        
			$nomeUltimaAlteração = '';
			$dataUltimaAlteração = '';

			$eclusa = 'não';
			if(count($dadosControleFluv) > 0){
				foreach($dadosControleFluv as $x => $diasControle){
					if($diasControle->jusante_manha == NULL or $diasControle->jusante_manha == 'Selecione'){
						$color = '#DCDCDC';
					}else if($diasControle->jusante_manha == 'Em Operação'){
						$color = '#37bf48';
					}else if($diasControle->jusante_manha == 'Fora de Operação'){
						$color = '#c13259';
					}else if($diasControle->jusante_manha == 'Não Aplicável'){
						$color = '#7e757d';
					}
					$tooltip = "Nível: " . $diasControle->manha_nivel .'cm';
					$diasManha[$diasControle->dia] = '<a class="dias" style="border: 2px solid '.$color.';padding: 2px; background-color: '.$color.'" title="'. $tooltip .'">'. str_pad($diasControle->dia, 2, 0, STR_PAD_LEFT) .'</a>  ';

										

					$nomeUltimaAlteração = $diasControle->nome;
					$dataUltimaAlteração = $diasControle->ultima_alteracao;
					$verificaControle = false;
				}
			}

			$inserir = "<button type='button' id='editar_$linha' name='editar_$linha' class='btn btn-default' href='javascript:void(0);' onclick='editar(\"" . $listaInfra->nome_eixo . "\",\"" . $eclusa . "\")'><i class = 'fas fa-pencil-alt'></i></buttonx>";
			$dados["data"][] = array(
				'infraestrutura' => $listaInfra->nome_eixo,
				'dias' => 'ECLUSA - ' . implode(' ', $diasManha) ,
				'nome' => $nomeUltimaAlteração,
				'ultima_alteracao' => $dataUltimaAlteração,
				'acao' => $inserir
			);
                        if(count($dadosControleFluv) > 0){
			if($x == count($dadosControleFluv) - 1){
				$dados["id_tela_formulario"] = '32';
				$dados["periodo"] = $this->input->post_get("periodo");
				$dados["nome_usuario"] = $nomeUltimaAlteração;
				$dados["data_ultima_alteracao"] = $dataUltimaAlteração;
				$this->Tb_telas_validacao->inserir_validacao($dados);
			}
                        }
		}
		if($verificaControle){
			$dados["id_tela_formulario"] = '32';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}
		echo(json_encode($dados));
	}

	public function editarControleFluv(){
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["infraestrutura"] = $this->input->post_get("infraestrutura");

		$dadosControleMes = $this->Tb_controle_fluviometrico->EditarControleFluv($dados);
		$retorno = array();

		if(count($dadosControleMes) > 0){
			foreach($dadosControleMes as $dadosDia){
				$retorno[$dadosDia->dia]['manha'] = $dadosDia->manha;
				$retorno[$dadosDia->dia]['manha_nivel'] = $dadosDia->manha_nivel;
				$retorno[$dadosDia->dia]['jusante_manha'] = $dadosDia->manha_nivel;
				$retorno[$dadosDia->dia]['tarde'] = $dadosDia->tarde;
				$retorno[$dadosDia->dia]['tarde_nivel'] = $dadosDia->tarde_nivel;
				$retorno[$dadosDia->dia]['jusante_tarde'] = $dadosDia->tarde_nivel;
			}
		}else {
			$data = explode('-',$dados["periodo"]);
			$totaldias = cal_days_in_month(CAL_GREGORIAN, $data[1],$data[0]);

			for($i = 1; $i <= $totaldias; $i++){
				$retorno[$i]['manha'] = "Selecione";
				$retorno[$i]['manha_nivel'] = "";
				$retorno[$i]['jusante_manha'] = "";
				$retorno[$i]['tarde'] = "Selecione";
				$retorno[$i]['tarde_nivel'] = "";
				$retorno[$i]['jusante_tarde'] = "";
			}
		}
		echo(json_encode($retorno));
	}

	public function excluirDia()
	{
		$dados["id_controle_fluviometrico"] = $this->input->post_get('id_controle_fluviometrico');
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$retorno = $this->Tb_controle_fluviometrico->excluirDia($dados);
		echo(json_encode($retorno));
	}


	public function Recuperadiasmes(){ 
               
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');
                
		$Dados = $this->Tb_controle_fluviometrico->Recuperadiasmes($dados);
              
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
		$retorno = $this->Tb_controle_fluviometrico->insereNaoAtividade($dados);

		$dados["id_tela_formulario"] = 32;
		$dados["periodo"] = $this->input->post_get("periodo");
		$this->Tb_telas_validacao->inserir_validacao($dados);

		echo(json_encode($retorno));
	}

	public function confereAtividade(){ 
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');

		$DadosControle = $this->Tb_controle_fluviometrico->recuperaControleFluv($dados); 
		$dados["data"] = array();

		$dadosNaoAtividade = $this->Tb_controle_fluviometrico->confereAtividade($dados);
		if (!empty($DadosControle)) {
			$dados["situacao"] = 'Com Atividade';
		} else if (!empty($dadosNaoAtividade)) {
			$dados["situacao"] = 'Sem Atividade';
		} else {
			$dados["situacao"] = 'Sem Registros';
		}
		echo(json_encode($dados));
	}
        
        public function recuperaStatusControleFluv(){ 
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');

		$Dados = $this->Tb_controle_fluviometrico->recuperaStatusControleFluv($dados); 
		$dados["data"] = array();
                foreach ($Dados as $lista) {
			$dados["statusoperacao"] = $lista->statusoperacao;
		}
               		
		echo(json_encode($dados));
	}

}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Pedro Correia
//# Data: 21/10/2021 11:00
//########################################################################################################################################################################################################################
