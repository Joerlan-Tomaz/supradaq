<?php
/*
 * Classe controller Relatorioctr. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, | DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Relatorioctr extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_relatorio');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora_aditivo');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora_localizacao');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora_tecnico');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_paralisacao_reinicio');
		$this->load->model('/Supervisaodaq/Tb_cronogramafinanceiro');
		$this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_construtora');
		$this->load->model('/Supervisaodaq/Tb_garantias_contratuais');
		$this->load->model('/Supervisaodaq/Tb_AtasCorrespondencia');
		$this->load->model('/Supervisaodaq/Tb_garantias_contratuais');
		$this->load->model('/Supervisaodaq/Tb_resumo');
		$this->load->model('/Supervisaodaq/Tb_cronograma_fisico');
		$this->load->model('/Supervisaodaq/Tb_pba_pbai');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_construtora_aditivo');
		$this->load->model('/Supervisaodaq/Tb_analise_relatorio');
		$this->load->model('/Supervisaodaq/Tb_apresentacao_construtora_localizacao');
		$this->load->model('/Supervisaodaq/Tb_art_supervisao');
		$this->load->model('/Supervisaodaq/Tb_licencas_ambientais');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

//----------------------------------------------------------------------------------------------------------
	public function ResultadoElabracaoRelatorioDaqq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		//-----------------------------------------------------------------
		$ElaboracaoRelatorioDaq = $this->Tb_relatorio->DadosImpressaoRelatorioDaq($dados);

		$retorno["data"] = array();
		foreach ($ElaboracaoRelatorioDaq as $elaboracao) {

			$retorno["data"][] = array(
				$dadosS["qtd_fechado"] = $elaboracao->id_modulo
			);
		}
		$counts = $retorno["data"];
		print_r(sizeof($counts));
		echo json_encode($retorno);
	}

	public function ResultadoAnaliseEstrruturalRelatorioDaq()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$AnaliseEstruturalRelatorioDaq = $this->Tb_relatorio->ResultadoAnaliseEstruturalRelatorioDaq($dados);

		foreach ($AnaliseEstruturalRelatorioDaq as $analiseestrutural) {
			# code...
			$dados['status_aceite_perifil'] = $analiseestrutural->validaperfilfical;
			$dados['analise_fiscal_perfil'] = $analiseestrutural->validaperfilanalise;

		}
		echo json_encode($dados);
	}

	public function finalizarelatoriodaq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_perfil_analise"] = $this->session->id_perfil_daq;
		//print_r( $dados["id_perfil_analise"]);
		//-----------------------------------------------------------------
		// if (!empty($dados["id_perfil_analise"]) and $dados["id_perfil_analise"]== 14 ) {
		//     $retorno = $this->Tb_relatorio->finalizar_Relatorio($dados);
		// } else {
		//       $retorno["mensagem"] = "[Não possui perfil para conclusão. Solicite ao responsável do sistema.]";
		//         //$retorno["notify"] = "warning";
		//         die (json_encode($retorno));
		// }
		$retorno = $this->Tb_relatorio->finalizar_Relatorio($dados);
		echo(json_encode($retorno));
	}

	//-----------------------------------------------------------------
	public function validaperfil()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_perfil_analise"] = $this->session->id_perfil_daq;
		//print_r( $dados["id_perfil_analise"]);
		//-----------------------------------------------------------------
		if (empty($dados["id_perfil_analise"]) || $dados["id_perfil_analise"] != 2) {
			$retorno["mensagem"] = "[Não possui perfil para conclusão e envio do relatorio. Solicite ao responsável.]";
			//$retorno["notify"] = "warning";
			die (json_encode($retorno));
		}
		$retorno = true;
		echo(json_encode($retorno));
	}

//-----------------------------------------------------------------
	public function validaRecibodaq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get("periodo");
		$resultadorecibo = $this->Tb_analise_relatorio->AndamentoReciboDaq($dados);
		//-----------------------------------------------------------------
		$var1 = 0;
		$var2 = 0;
		if (!empty($resultadoelaboracao)) {
			foreach ($resultadoelaboracao as $imprimir) {

				$a = array("id_aceite" => "aprovado", "perfil" => 2);
				$b = array("id_aceite" => "aprovado", "perfil" => 3);

				$c = array_diff($a, $imprimir);
				$d = array_diff($b, $imprimir);


				if (empty($c)) {

					$var1++;

				}
				if (empty($d)) {
					$var2++;

				}

			}
			if ($var1 == 0 and $var2 == 0) {

				$return["mensagem"] = "[Sem recibo.]";
				die (json_encode($return));
			}
		}

	}

//----------------------------------------------------------------------------------------------------------

	public function returnelaboracaodaq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get("periodo");

		$resultadoelaboracao = $this->Tb_relatorio->AndamentoDaq($dados);

		$var1 = 0;
		$var2 = 0;
		if (!empty($resultadoelaboracao)) {
			foreach ($resultadoelaboracao as $imprimir) {

				$a = array("id_aceite" => "aprovado", "perfil" => 2);
				$b = array("id_aceite" => "aprovado", "perfil" => 3);

				$c = array_diff($a, $imprimir);
				$d = array_diff($b, $imprimir);

				if (empty($c)) {
					$var1++;
				}
				if (empty($d)) {
					$var2++;
				}
			}
			if ($var1 > 0 and $var2 > 0) {
				$dados['data'] = "Aprovado";
				die (json_encode($dados));
			}
		}

		$AndamentoanaliseDaq = $this->Tb_relatorio->AndamentoanaliseDaq($dados);
		$aceite = '';
		$roteiro = '';
		$perfil = '';

		if (!empty($AndamentoanaliseDaq) and ($var1 == 0 || $var2 == 0)) {
			foreach ($AndamentoanaliseDaq as $andamento) {

				$aceite = $andamento->id_aceite;
				$roteiro = $andamento->roteiro_analise;
				$perfil = $this->session->id_perfil_daq;
				$dados['aceite'] = $aceite;
				$dados['perfil'] = $perfil;

				//---------------------------------------------------------------
				if ($aceite == "aprovado" && $perfil == 2) {

					$dados['data'] = "aguardando_analise_fiscal";
				}
				if ($aceite == "retificado") {

					$dados['data'] = "liberar_relatorio";
				}
				if ($aceite == "reprovado" && $perfil == 2) {

					$dados['data'] = "ReprovadoAnalista";
				}
				//-----------------------------------------------------------------
				if ($aceite == "aprovado" && $perfil == 3) {

					$dados['data'] = "aguardando_analise_analista";
				}
				if ($aceite == "retificado") {

					$dados['data'] = "liberar_relatorio";
				}
				if ($aceite == "reprovado" && $andamento->perfil == 3) {

					$dados['data'] = "ReprovadoFiscal";
				}
				if ($aceite == "reprovado" && $andamento->perfil == 11) {

					$dados['data'] = "ReprovadoFiscalEstrutural";
				}
				//-----------------------------------------------------------------
				if ($aceite == "aguardando análise") {

					$dados['data'] = "aguardando_analise";
				}
				//-----------------------------------------------------------------
				if (($aceite == "em analise")) {

					$dados['data'] = "fechar_relatorio";
				}
			}
		} else {
			$dados['data'] = "Elaboracao";
		}

		# code...
		echo json_encode($dados);
	}

//----------------------------------------------------------------------------------------------------------
	public function ResultadoElaboracaoRelatorioDaqq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		//-----------------------------------------------------------------
		$ElaboracaoRelatorioDaq = $this->Tb_relatorio->DadosImpressaoRelatorioDaq($dados);

		$retorno["data"] = array();
		foreach ($ElaboracaoRelatorioDaq as $elaboracao) {

			$retorno["data"][] = array(
				$dadosS["qtd_fechado"] = $elaboracao->id_modulo
			);
		}
		$counts = $retorno["data"];
		print_r(sizeof($counts));
		echo json_encode($retorno);
	}

	public function ResultadoElaboracaoRelatorioDaq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		//-----------------------------------------------------------------
		$ElaboracaoRelatorioDaq = $this->Tb_relatorio->DadosImpressaoRelatorioDaq($dados);
		$j = 0;
		$retorno = array();
		if (!empty($ElaboracaoRelatorioDaq)) {
			foreach ($ElaboracaoRelatorioDaq as $elaboracao) {

				$retorno["relaboracao"][$j] = $elaboracao->id_modulo;

				$j++;
			}
			$counts = array_unique($retorno["relaboracao"]);
			$dados["relaboracao"] = sizeof($counts);
		} else {
			$dados["relaboracao"] = 0;
		}
		echo json_encode($dados);
	}

//------------------------------------------------------------------------------
	public function DadosVersaoRelatorioContratoDaq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$VersaoRelatorioContratoDaq = $this->Tb_relatorio->VersaoRelatorioContratoDaq($dados);
		//-------------------------------------------------------------------------------------
		$dataano = date("Y", strtotime($this->input->post_get("periodo")));
		$datames = date('m', strtotime($this->input->post_get('periodo')));

		//$datames = strtoupper(strftime('%B', strtotime($this->input->post_get("periodo"))));
		$mes_extenso = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
			'07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
		$periodo_referencia = strtoupper($mes_extenso["$datames"]) . "/" . $dataano;

		foreach ($VersaoRelatorioContratoDaq as $versao) {

			$dados["contrato"] = $versao->contrato;
			$dados["supervisora"] = $versao->supervisora;
			$dados["uf"] = $versao->uf;
			$dados["versao"] = "Versão -";
			$dados["rp"] = "RELATÓRIO PERIÓDICO - RP -" . $periodo_referencia;
		}
		echo json_encode($dados);
	}

//-------------------------------------------------------------------------------------
	public function curvasdaq()
	{

		$dados["id_contrato_obra"] = $this->session->idContrato;
		$montarGrafico = $this->Tb_cronogramafinanceiro->buscadadosgrafico($dados);
//-----------------------------------------------------------------
		$j = 0;
		$Dados = array();
		$grafico_executado = 0;
		$grafico_previsto = 0;
		//--------------------------------------------------------
		foreach ($montarGrafico as $montarGraficovalores) {

			$Dados['data_comum'][$j] = $montarGraficovalores->medicao;
			//----------------------------------------------------------------
			$grafico_executado = $montarGraficovalores->valor_pi_medicao;
			$grafico_previsto = $montarGraficovalores->valor_previsto;
			$Dados['charPrevisto'][$j] = round($grafico_previsto, 2);
			$Dados['charExecutado'][$j] = round($grafico_executado, 2);

			$j++;
		}
		echo(json_encode($Dados));
	}


	public function DadosModulosRelatorioDaq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["id"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$num = 1;

		$lista = array('14' => 'Justificativa do Empreendimento', '15' => 'Mapa de Situação', '3' => 'Resumo do Projeto', '24' => 'RPFO - Revisão de projetos em fase de obra', '16' => 'Diagrama de Pontos de Passagem e de Ocorrências de Projeto', '1' => 'Histórico da Obra', '2' => 'Introdução', '19' => 'Apresentação Supervisora', '22' => 'Relação de Mobilização da Supervisora', '9' => 'Atividades da Supervisora', '18' => 'Apresentação Construtora', '23' => 'Relação de Mobilização da Construtora', '12' => 'Atividades da Construtora', '25' => 'Acompanhamento financeiro', '26' => 'Acompanhamento físico', '10' => 'Análise Crítica Cronogramas', '27' => 'Controle pluviométrico', '13' => 'Documentação Fotográfica', '11' => 'Monitoramento Ambiental', '6' => 'Ensaios Construção', '7' => 'Ensaios Supervisão', '28' => 'Registro de não conformidade (RNC)', '29' => 'Gestão Jurídica,Garantias e Seguros', '30' => 'Riscos e Interferências', '31' => 'Diário de Obra', '32' => 'Atas e Correspondências', '33' => 'Gestão de Tratativas', '5' => 'Conclusão e Comentários', '34' => 'Termo de Encerramento', '8' => 'Anexos');
		$ImpressaoRelatorioDaq = $this->Tb_relatorio->DadosImpressaoRelatorioDaq($dados);
		$array = json_decode(json_encode($ImpressaoRelatorioDaq), true);
		$total = count($array);

		$arr = [];
		for ($j = 0; $j < $total; $j++) {
			$a = $array[$j]['id_modulo'];
			array_push($arr, $a);
		}

		foreach ($lista as $id => $var) {

			if (array_search($id, $arr) !== false) {
				$key = array_search($id, $arr);
				$usuario = $array[$key]['usuario'];
				$alteracao = $array[$key]['ultima_alteracao'];

				$acao = "<a data-toggle='tooltip' title='Status Análise' data-placement='top' style='font-size:20px'>
                                     <i class=' fa fa-check-circle' style='color:green'></i></a>";

			} else {
				$usuario = '- - -';
				$alteracao = '- - -';
				$acao = "<a data-toggle='tooltip' title='Status Análise' data-placement='top' style='font-size:20px'>
                                     <i class=' fa fa-check-circle' style='color:#9E9E9E'></i></a>";

			}

			$dados['data'][] = array(
				"cont" => $num++,
				"modulo" => $var,
				"nome" => $usuario,
				"data" => $alteracao,
				"acao" => $acao
			);
		}

		echo(json_encode($dados));
	}


	public function ResultadoElaboracaoRelatorioDaqs()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$ElaboracaoRelatorioDaq = $this->Tb_relatorio->ResultadoElaboracaoRelatorioDaq($dados);

		foreach ($ElaboracaoRelatorioDaq as $elaboracao) {
			# code...
			$dados['conte_fechado'] = 2;

		}
		echo json_encode($dados);
	}

	public function ResultadoConclusaoRelatorioDaq()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$ConclusaoRelatorioDaq = $this->Tb_relatorio->ResultadoConclusaoRelatorioDaq($dados);

		foreach ($ConclusaoRelatorioDaq as $conclusao) {
			# code...
			$dados['status_relatorio'] = $conclusao->status_relatorio;

		}
		echo json_encode($dados);
	}

	public function returnTecnicodaq()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$AnaliseTecnicaRelatorioDaq = $this->Tb_analise_relatorio->returnTecnicodaq($dados);
		$retorno["data"] = array();

		if (!empty($AnaliseTecnicaRelatorioDaq)) {
			$linha = 1;
			foreach ($AnaliseTecnicaRelatorioDaq as $lista) {

				//-------------------------------------------------------------------------------------
				$dataano = date("Y", strtotime($lista->periodo));
				$datames = date('m', strtotime($lista->periodo));

				$mes_extenso = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
					'07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
				$periodo_referencia = $mes_extenso["$datames"] . "/" . $dataano;


				$retorno["data"][] = array(
					'cont' => $linha,
					'modulo' => $lista->modulo,
					'motivo' => $lista->desc_analise,
					'referencia' => $periodo_referencia,
					'data' => $lista->ultima_alteracao,
					'responsavel' => $lista->nome
				);
				$linha++;
			}
		}
		echo(json_encode($retorno));

	}

	public function returnEstruturaldaq()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$AnaliseEstruturalRelatorioDaq = $this->Tb_analise_relatorio->returnEstruturaldaq($dados);
		$retorno["data"] = array();

		if (!empty($AnaliseEstruturalRelatorioDaq)) {
			$linha = 1;
			foreach ($AnaliseEstruturalRelatorioDaq as $lista) {

				//-------------------------------------------------------------------------------------
				$dataano = date("Y", strtotime($lista->periodo));
				$datames = date('m', strtotime($lista->periodo));

				$mes_extenso = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
					'07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
				$periodo_referencia = $mes_extenso["$datames"] . "/" . $dataano;

				$retorno["data"][] = array(
					'cont' => $linha,
					'modulo' => $lista->modulo,
					'motivo' => $lista->desc_analise,
					'referencia' => $periodo_referencia,
					'data' => $lista->ultima_alteracao,
					'responsavel' => $lista->nome
				);
				$linha++;
			}
		}
		echo(json_encode($retorno));
	}

//-----------------------------------------------------------------------------------------------------------
	public function returnrecibodaq()
	{
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$dataano = date("Y", strtotime($this->input->post_get("periodo")));
		$datames = date('m', strtotime($this->input->post_get('periodo')));
		//--------------------------------------------------------
		$mes_extenso = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
			'07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
		$periodo_referencia = strtoupper($mes_extenso["$datames"]) . "/" . $dataano;

		$DadosRecibo['DadosHistorico'] = $this->Tb_analise_relatorio->recuperarHistoricoAnalises($dados);
		$DadosAnaliseRelatorio = $this->Tb_analise_relatorio->recuperaContratoAnalise($dados);
		$DadosRecibo['DadosRelatorioDaq'] = $this->Tb_relatorio->DadosImpressaoRelatorioDaq($dados);
		$DadosRecibo['periodo'] = $periodo_referencia;


		$DadosContratoObra = $this->Tb_relatorio->DadosContratoDaq($dados);

		# code...
		$DadosRecibo['nu_contrato_super'] = $DadosContratoObra[0]["nu_contrato_super"];

		$DadosRecibo['empresa_super'] = $DadosContratoObra[0]["empresa_super"];

		$DadosRecibo['n_contrato_obra'] = $DadosContratoObra[0]["numero_contrato"];

		$DadosRecibo['empresa_obra'] = $DadosContratoObra[0]["empresa_obra"];

		$DadosRecibo['periodo_referencia'] = $periodo_referencia;
		$DadosRecibo['Valor_Inicial_Adit_Reajustes'] = number_format($DadosContratoObra[0]["Valor_Inicial_Adit_Reajustes"], 2, ",", ".");

		$dadoslocalizacao = $this->Tb_relatorio->dadoslocalizacao($dados);

		if (!empty($dadoslocalizacao)) {
			$DadosRecibo['hidrovia_localizacao'] = $dadoslocalizacao[0]["hidrovia_capa"];
			$DadosRecibo['municio_localizacao'] = $dadoslocalizacao[0]["municipio_capa"];
			$DadosRecibo['extensao_localizacao'] = $dadoslocalizacao[0]["extensao_capa"];
		} else {
			$DadosRecibo['hidrovia_localizacao'] = '-';
			$DadosRecibo['municio_localizacao'] = '-';
			$DadosRecibo['extensao_localizacao'] = '-';
		}


		if (!empty($DadosAnaliseRelatorio)) {
			foreach ($DadosAnaliseRelatorio as $lista) {

				//echo date('d/m/Y', $lista->fechamento);

				$DadosRecibo['fechamento'] = "RELATÓRIO PERIÓDICO - RP - " . $lista->fechamento;
				$DadosRecibo['versao'] = $lista->versao . ".0";

			}
		} else {

			$DadosRecibo['fechamento'] = "RELATÓRIO PERIÓDICO - RP -";
			$DadosRecibo['versao'] = "0.0";

		}
		$this->load->view('/supervisaodaq/relatorio/ReciboSupervisao', $DadosRecibo);
	}

	public function ResultadoImprimirRelatorioDaq()
	{
		$dados["id_contrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");

		$ImprimirRelatorioDaq = $this->Tb_relatorio->ResultadoImprimirRelatorioDaq($dados);

		foreach ($ImprimirRelatorioDaq as $imprimir) {
			# code...
			$dados['status_aceite_fiscal'] = $imprimir->status_aceite_fiscal;
			$dados['analise_fiscal'] = $imprimir->analise_fiscal;
			$dados['analise_cord'] = $imprimir->analise_cord;
			$dados['roteiro'] = $imprimir->roteiro;

		}
		echo json_encode($dados);
	}


//----------------------------------------
	public function returnRelatorioDaq()
	{
		$dados["periodo"] = $this->input->post_get("periodo");

		if (!empty($this->input->post_get("id"))) {
			$dados["id_contrato_obra"] = $this->input->post_get("id");
			$dados["idContrato"] = $this->input->post_get("id");
		} else {
			$dados["id_contrato_obra"] = $this->session->idContrato;
			$dados["idContrato"] = $this->session->idContrato;
		}
		$this->session->set_userdata($dados);
		//-------------------------------------------------------------------------------------
		$dataano = date("Y", strtotime($this->input->post_get("periodo")));
		$datames = date('m', strtotime($this->input->post_get('periodo')));
		$return['mes'] = date('m', strtotime($this->input->post_get('periodo')));
		$return['ano'] = date('y', strtotime($this->input->post_get('periodo')));
		$return['referencia'] = strtotime($this->input->post_get('periodo'));
		//$datames = strtoupper(strftime('%B', strtotime($this->input->post_get("periodo"))));
		$mes_extenso = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
			'07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
		$periodo_referencia = strtoupper($mes_extenso["$datames"]) . "/" . $dataano;

		//------------------------------------------------------------------------------------------
		$DadosContratoObra = $this->Tb_relatorio->DadosContratoDaq($dados);

		# code...
		$return['nu_contrato_super'] = $DadosContratoObra[0]["nu_contrato_super"];

		$return['empresa_super'] = $DadosContratoObra[0]["empresa_super"];

		$return['n_contrato_obra'] = $DadosContratoObra[0]["numero_contrato"];

		$return['empresa_obra'] = $DadosContratoObra[0]["empresa_obra"];

		$return['periodo_referencia'] = $periodo_referencia;
		$return['Valor_Inicial_Adit_Reajustes'] = number_format($DadosContratoObra[0]["Valor_Inicial_Adit_Reajustes"], 2, ",", ".");


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

		$dadosTermo = $this->Tb_relatorio->DadoTermoEncerramento($dados);

		if (!empty($dadosTermo)) {
			$return['relatorio_supervisao'] = $dadosTermo[0]["relatorio_supervisao"];
		} else {
			$return['relatorio_supervisao'] = '-';

		}

		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//

		$JustificativaDeEmpreendimento = $this->Tb_relatorio->JustificativaDeEmpreendimento($dados);

		if (!empty($JustificativaDeEmpreendimento)) {
			$return['resumo_justificativa'] = $JustificativaDeEmpreendimento[0]["resumo_justificativa"];
		} else {
			$return['resumo_justificativa'] = '<div class="alert alert-danger" role="alert">[1. JUSTIFICATIVA E APRESENTAÇÃO DO EMPREENDIMENTO] não cadastrado!</div>';
		}
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$mapasituacao = $this->Tb_relatorio->mapasituacao($dados);

		if (!empty($mapasituacao)) {
			$return['mapa_situacao'] = $mapasituacao[0]["mapa_situacao"];
		} else {
			$return['mapa_situacao_nao_cadastrado'] = '<div class="alert alert-danger" role="alert">[2. MAPA DE SITUAÇÃO] não cadastrado!</div>';
		}
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$resumoprojeto = $this->Tb_relatorio->resumoprojeto($dados);

		if (!empty($resumoprojeto)) {
			foreach ($resumoprojeto as $key) {

				if ($key->tipo_resumo == 1) {
					$return['reumo_projeto_obra'] = '3.1 Construção Portuária';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 2) {
					$return['reumo_projeto_obra'] = '3.1 Derrocagem';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 3) {
					$return['reumo_projeto_obra'] = '3.1 Dragagem';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 4) {
					$return['reumo_projeto_obra'] = '3.1 Desobstrução';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 5) {
					$return['reumo_projeto_obra'] = '3.1 Recuperação Portuária';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 6) {
					$return['reumo_projeto_obra'] = '3.1 Monitoramento Hidroviário';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 7) {
					$return['reumo_projeto_obra'] = '3.1 Remoção do Navio';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 8) {
					$return['reumo_projeto_obra'] = '3.1 Implantação de Sinalização em Hidrovias';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 9) {
					$return['reumo_projeto_obra'] = '3.1 Recuperação Eclusas e Barragens';
					$return['reumo_projeto_obra_especifica'] = $key->resumo_projeto;
				}

				if (empty($return['reumo_projeto_obra_especifica'])) {
					$return['reumo_projeto_obra_especifica'] = '<div class="alert alert-danger" role="alert">[3.1 RESUMO PROJETO] não cadastrado!</div>';
				}
				if (empty($return['reumo_projeto_obra'])) {
					$return['reumo_projeto_obra'] = '3.1 Não cadastrado';
				}
				if (empty($return['Dragagem'])) {
					$return['Dragagem'] = '<div class="alert alert-danger" role="alert">[3.3 Dragagem] não cadastrado!</div>';
				}
				if (empty($return['desobstrucao_presenca_vegetacao'])) {
					$return['desobstrucao_presenca_vegetacao'] = '<div class="alert alert-danger" role="alert">[3.4 Desobstrução] não cadastrado!</div> ';
				}
				if (empty($return['dragagem_portos_maritimos'])) {
					$return['dragagem_portos_maritimos'] = '<div class="alert alert-danger" role="alert">[3.5 Recuperação Portuária] não cadastrado!</div> ';
				}
				if (empty($return['construcao_estacao_passageiro'])) {
					$return['construcao_estacao_passageiro'] = '<div class="alert alert-danger" role="alert">[3.6 Monitoramento Hidroviário] não cadastrado!</div> ';
				}
				if (empty($return['remocao_navio_haider'])) {
					$return['remocao_navio_haider'] = '<div class="alert alert-danger" role="alert">[3.7 Remoção do Navio ] não cadastrado!</div> ';
				}
				if (empty($return['implantacao_sinalizacao_hidrovias'])) {
					$return['implantacao_sinalizacao_hidrovias'] = '<div class="alert alert-danger" role="alert">[3.8 Implantação de Sinalização em Hidrovias] não cadastrado!</div> ';
				}
				if (empty($return['obras_em_clusas'])) {
					$return['obras_em_clusas'] = '<div class="alert alert-danger" role="alert">[3.9 Recuperação Eclusas e Barragens] não cadastrado!</div> ';
				}
			}
		} else {
			$return['reumo_projeto_obra_especifica'] = '<div class="alert alert-danger" role="alert">[3.1 RESUMO PROJETO] não cadastrado!</div>';
			$return['reumo_projeto_obra'] = '3.1 Não cadastrado';
			$return['Dragagem'] = '<div class="alert alert-danger" role="alert">[3.3 Dragagem] não cadastrado!</div>';
			$return['desobstrucao_presenca_vegetacao'] = '<div class="alert alert-danger" role="alert">[3.4 Desobstrução] não cadastrado!</div> ';
			$return['dragagem_portos_maritimos'] = '<div class="alert alert-danger" role="alert">[3.5 Recuperação Portuária] não cadastrado!</div> ';
			$return['construcao_estacao_passageiro'] = '<div class="alert alert-danger" role="alert">[3.6 Monitoramento Hidroviário] não cadastrado!</div> ';
			$return['remocao_navio_haider'] = '<div class="alert alert-danger" role="alert">[3.7 Remoção do Navio ] não cadastrado!</div> ';
			$return['implantacao_sinalizacao_hidrovias'] = '<div class="alert alert-danger" role="alert">[3.8 Implantação de Sinalização em Hidrovias] não cadastrado!</div> ';
			$return['obras_em_clusas'] = '<div class="alert alert-danger" role="alert">[3.9 Recuperação Eclusas e Barragens] não cadastrado!</div> ';

		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//

		$resumorpfo = $this->Tb_relatorio->resumoRpfo($dados);

		if (!empty($resumorpfo)) {
			$return['resumo_rpfo'] = $resumorpfo[0]["resumo_rpfo"];
		} else {
			$return['resumo_rpfo'] = '<div class="alert alert-danger" role="alert">[3.10 REVISÕES DE PROJETO EM FASE DE OBRAS - RPFO] - Não houve atividade no mês </div>';
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//

		$diagramaOcorrencia = $this->Tb_relatorio->diagramaOcorrencia($dados);

		if (!empty($diagramaOcorrencia)) {
			$return['diagrama_ocorrencia_pp'] = $diagramaOcorrencia[0]["diagrama_ocorrencia_pp"];
		} else {
			$return['diagrama_ocorrencia_pp_nao_cadastrado'] = '<div class="alert alert-danger" role="alert">[4. DIAGRAMA DE OCORRÊNCIAS E PONTOS DE PASSAGEM] não cadastrado!</div>';
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$historicoObra = $this->Tb_relatorio->historicoObra($dados);

		if (!empty($historicoObra)) {
			$return['historico_obra'] = $historicoObra[0]["historico_obra"];
		} else {
			$return['historico_obra'] = '<div class="alert alert-danger" role="alert">[5. HISTÓRICO] não cadastrado!</div>';
		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$introducaoObra = $this->Tb_relatorio->introducaoObra($dados);

		if (!empty($introducaoObra)) {
			$return['introducao_obra'] = $introducaoObra[0]["introducao_obra"];
		} else {
			$return['introducao_obra'] = '<div class="alert alert-danger" role="alert">[6. INTRODUÇÃO] não cadastrado!</div> ';
		}
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$apresentacaoSupervisora = $this->Tb_apresentacao_supervisora->RecuperaApresentacaoSupervisora($dados);

		if (!empty($apresentacaoSupervisora)) {

			foreach ($apresentacaoSupervisora as $lista) {

				if ($lista->publi_result == '') {
					$lista->publi_result = "- -";
				}
				if ($lista->publi_dou == '') {
					$lista->publi_dou = "- -";
				}

				$data_base = $lista->data_base;
				$contrato = $lista->contrato;
				$empresa = $lista->nome_empresa;
				$processo_base = $lista->processo_adm;
				$objeto = $lista->objeto;
				$localizacao = $lista->localizacao;

				$data_assinatura = $lista->data_ass;
				$ordem_inicial = $lista->ordem_inicial;
				$prazo_inicial = $lista->prazo_inicial;
				$termino_inicial = $lista->data_inicial_term;
				$termino_atualizada = $lista->dt_termino_atualizada;

				$data_publicacao = $lista->publi_dou;
				$publicacao_licitacao_DOU = $lista->publi_result;

				$dias_aditados = $lista->dias_aditados;
				$dias_paralisados = $lista->total_paralisados;
				$valor_PI = "R$" . number_format($lista->valor_pi_contrato, 2, ",", ".");
				$valor_aditado = "R$" . number_format($lista->valor_total_aditado, 2, ",", ".");
				$valor_reajuste = "R$" . number_format($lista->valor_reajuste, 2, ",", ".");
				$valor_atualizado = "R$" . number_format($lista->valor_atz_pir, 2, ",", ".");
			}

			$return['apresentacao_supervisora'] =
				"<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive'>
                        <h3>
                            <strong>Informações Contratuais</strong>
                        </h3>
                        
                        <table class='tabela bordaCompleta' style='width: 100%;'>
                            <tr>
                                <td class='bold'>Contrato Construção</td>
                                <td>$contrato</td>
                            </tr>
                            <tr>
                                <td style='width: 50%;'' class='bold'>Empresa</td>
                                <td style='width: 50%;'>$empresa</td>
                            </tr>
                            <tr>
                                <td class='bold'>Processo Administrativo Base</td>
                                <td>$processo_base</td>
                            </tr>
                            <tr>
                                <td class='bold'>Objeto</td>
                                <td>$objeto</td>            
                            </tr>
                            <tr>
                                <td class='bold'>Data Base</td>
                                <td>$data_base</td>
                            </tr>
                            <tr>
                                <td class='bold'>Data Publicação da Licitação no DOU</td>
                                <td> $data_publicacao </td>
                            </tr>
                            <tr>
                                <td class='bold'>Data da publicação do resultado da licitação no DOU</td>
                                <td> $publicacao_licitacao_DOU  </td>
                            </tr>
                            <tr>
                                <td class='bold'>Data Assinatura</td>
                                <td>$data_assinatura</td>
                            </tr>
                            <tr>
                                <td class='bold'>Ordem de Inicio Serviços</td>
                               <td>$ordem_inicial</td>
                            </tr>
                            <tr>
                                <td class='bold'>Prazo Inicial de Execução</td>
                                <td>$prazo_inicial</td>
                            </tr>
                            <tr>
                                <td class='bold'>Data Inicial de Término Contrato</td>
                                <td>$termino_inicial</td>
                            </tr>
                            <tr>
                                <td class='bold'>Total dias Aditados</td>
                               <td>$dias_aditados</td>
                            </tr>
                            <tr>
                                <td class='bold'>Total dias Paralisados</td>
                                <td>$dias_paralisados </td>
                            </tr>
                            <tr>
                                <td class='bold'>Data de Término Atualizada</td>
                                <td>$termino_atualizada</td>
                            </tr>
                            <tr>
                                <td class='bold'>Valor a PI do contrato</td>
                               <td> $valor_PI</td>
                            </tr>
                            <tr>
                                <td class='bold'>Valor Total Aditado do Contrato</td>
                               <td> $valor_aditado</td>
                            </tr>
                            <tr>
                                <td class='bold'>Valor de Reajuste do Contrato</td>
                                <td> $valor_reajuste</td>
                            </tr>
                            <tr>
                                <td class='bold'>Valor Atualizado do Contrato(PI+A+R)</td>
                                <td> $valor_atualizado</td>
                            </tr>
                    </table>
            </div> ";

		} else {
			$return['apresentacao_supervisora'] = '<div class="alert alert-danger" role="alert">[7.1 APRESENTAÇÃO DA SUPERVISORA] não cadastrado!</div>';
		}
//-------------------------------------------------------------------------------------------- 

		$dados['contrato_fiscalizado'] = 'Supervisão';
		$return['apresentacao_supervisora_fiscais'] = $this->Tb_apresentacao_supervisora->recuperaPortariasFiscais($dados);

//--------------------------------------------------------------------------------------------

		$return['apresentacao_supervisora_aditivos'] = $this->Tb_apresentacao_supervisora_aditivo->Tableaditivo($dados);

//-------------------------------------------------------------------------------------------- 

		$return['apresentacao_supervisora_localizacao'] = $this->Tb_apresentacao_supervisora_localizacao->Tablelocalizacao($dados);

//-------------------------------------------------------------------------------------------- 

		//$DadosR['apresentacao_supervisora_localizacao'] = $this->Tb_apresentacao_supervisora_localizacao->Tablelocalizacao($dados);

//--------------------------------------------------------------------------------------------

		$return['apresentacao_supervisora_resposavel'] = $this->Tb_apresentacao_supervisora_tecnico->recuperaART($dados);

//--------------------------------------------------------------------------------------------
		$dadoSuper["roteiro"] = 19;
		$dadoSuper["idContrato"] = $this->session->idContrato;
		$dadoSuper["periodo"] = $this->input->post_get("periodo");
		$return['apresentacao_supervisora_paralisacao'] = $this->Tb_apresentacao_paralisacao_reinicio->tableAsParalisacaoReinicio($dadoSuper);
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$return['Mobilizacao_SICRO_Supervisora_Pessoal'] = $this->Tb_relatorio->Mobilizacao_SICRO_Supervisora_Pessoal($dados);
		$return['Mobilizacao_SICRO_SUpervisora_Equipamento'] = $this->Tb_relatorio->Mobilizacao_SICRO_SUpervisora_Equipamento($dados);
		$return['Mobilizacao_SICRO_SUpervisora_Materiais'] = $this->Tb_relatorio->Mobilizacao_SICRO_SUpervisora_Materiais($dados);
		$return['Mobilizacao_SICRO_SUpervisora_Atividade_Auxiliares'] = $this->Tb_relatorio->Mobilizacao_SICRO_SUpervisora_Atividade_Auxiliares($dados);
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
//--------------------------------------------------------------------------------------------
		$AtividadeSupervisora = $this->Tb_relatorio->AtividadeSupervisora($dados);

		if (!empty($AtividadeSupervisora)) {
			$return['atividadesupervisoraexecutada'] = $AtividadeSupervisora[0]["atividade_supervisora"];
		} else {
			$return['atividadesupervisoraexecutada'] = '<div class="alert alert-danger" role="alert">[7.3 ATIVIDADES EXECUTADAS PELA SUPERVISORA] não cadastrado!</div>  ';
		}
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$dados['contrato_fiscalizado'] = 'Obra';
		$return['apresentacao_construtora'] = $this->Tb_apresentacao_construtora->RecuperaApresentacaoConstrutora($dados);
		$return['apresentacao_construtora_fiscais'] = $this->Tb_apresentacao_construtora->recuperaPortariasFiscais($dados);
		$return['apresentacao_construtora_aditivo'] = $this->Tb_apresentacao_construtora_aditivo->Tableaditivo($dados);
		$return['apresentacao_construtora_localizacao'] = $this->Tb_apresentacao_construtora_localizacao->Tablelocalizacao($dados);

		$dadoCons["roteiro"] = 18;
		$dadoCons["idContrato"] = $this->session->idContrato;
		$dadoCons["periodo"] = $this->input->post_get("periodo");
		$return['apresentacao_contrutora_paralisacao'] = $this->Tb_apresentacao_paralisacao_reinicio->tableAsParalisacaoReinicio($dadoCons);
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$return['Mobilizacao_SICRO_Construtora_Pessoal'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Pessoal($dados);
		$return['Mobilizacao_SICRO_Construtora_Equipamento'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Equipamento($dados);
		$return['Mobilizacao_SICRO_Construtora_Materiais'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Materiais($dados);
		$return['Mobilizacao_SICRO_Construtora_Atividade_Auxiliares'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Atividade_Auxiliares($dados);
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$AtividadeConstrutora = $this->Tb_relatorio->AtividadeConstrutora($dados);

		if (!empty($AtividadeConstrutora)) {
			$return['atividadeconstrutoraexecutada'] = $AtividadeConstrutora[0]["atividade_construtora"];
		} else {
			$return['atividadeconstrutoraexecutada'] = '<div class="alert alert-danger" role="alert">[8.3 ATIVIDADES EXECUTADAS PELA CONSTRUTORA] não cadastrado!</div> ';
		}
		$return['acpfisicoavancocronograma'] = $this->Tb_cronograma_fisico->acompanhementofisico($dados);
		$return['anoacompanhemtofisico'] = $this->Tb_cronograma_fisico->anoacompanhemtofisico($dados);
		$analiseCriticaCronograma = $this->Tb_relatorio->analiseCriticaCronograma($dados);

		if (!empty($analiseCriticaCronograma)) {
			$return['analise_critica_cronograma'] = $analiseCriticaCronograma[0]["analise_critica_cronograma"];
		} else {
			$return['analise_critica_cronograma'] = '<div class="alert alert-danger" role="alert">[8.5 ANÁLISE CRÍTICA DOS CRONOGRAMAS] não cadastrado!</div>';
		}
		$return['acpfinanceiroavancocronograma'] = $this->Tb_cronogramafinanceiro->acompanhamentofinanceiro($dados);
		$return['anoacompanhemtofinanceiro'] = $this->Tb_cronogramafinanceiro->anoacompanhentofinanceiro($dados);
		$return['acompanhamentofinanceirov'] = $this->Tb_cronogramafinanceiro->acompanhamentofinanceirov($dados);
		$return['dadosresumoavancofisico'] = $this->Tb_cronogramafinanceiro->dadosresumoavancofisico($dados);
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$controlePluviometrico = $this->Tb_relatorio->controlePluviometrico($dados);
		$controlePluviometricototal = $this->Tb_relatorio->controlePluviometricototal($dados);

		$return['total_dias'] = "";
		$return['status_dia'] = "";
		$return['total_bom'] = "-";
		$return['total_instavel'] = "-";
		$return['total_chuva'] = "-";
		$return['total_imp'] = "-";
		$return['total_nhouveatividade'] = "-";

		foreach ($controlePluviometricototal as $controlePluviometricototal) {

			if ($controlePluviometricototal->situacao == 'Bom') {
				$return['total_bom'] = $controlePluviometricototal->qtd;
			}
			if ($controlePluviometricototal->situacao == 'Chuva') {
				$return['total_chuva'] = $controlePluviometricototal->qtd;
			}

			if ($controlePluviometricototal->situacao == 'Instavel') {
				$return['total_instavel'] = $controlePluviometricototal->qtd;
			}

			if ($controlePluviometricototal->situacao == 'Impraticável') {
				$return['total_imp'] = $controlePluviometricototal->qtd;
			}

			if ($controlePluviometricototal->situacao == 'Não houveram atividades') {
				$return['total_nhouveatividade'] = $controlePluviometricototal->qtd;
			}

		}
		foreach ($controlePluviometrico as $keycontrolePluviometrico) {
			# code...
			$situacao = $keycontrolePluviometrico->situacao;
			$return['total_dias'] .= "<td>" . $keycontrolePluviometrico->dia . "</td>";

			if ($situacao == 'Bom') {
				$return['status_dia'] .= "<td class='pluviometricoB'>B</td>";
			}
			if ($situacao == 'Chuva') {
				$return['status_dia'] .= "<td class='pluviometricoC'>C</td>";
			}
			if ($situacao == 'Impraticável') {
				$return['status_dia'] .= "<td class='pluviometricoI'>I</td>";
			}
			if ($situacao == 'Instavel') {
				$return['status_dia'] .= "<td class='pluviometricoIS'>S</td>";
			}
			if ($situacao == 'Não houveram atividades') {
				$return['status_dia'] .= "<td class='pluviometricoNA'>N/A</td>";
			}
		}
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//

		$return['DocumentacaoFotografica'] = $this->Tb_relatorio->DocumentacaoFotografica($dados);
		$return['LicencasAmbientais'] = $this->Tb_licencas_ambientais->recuperaLicencasAmbientais($dados);

		$EnsaioConstrutora = $this->Tb_relatorio->EnsaioConstrutora($dados);

		if (!empty($EnsaioConstrutora)) {
			$return['EnsaioConstrutora'] = $EnsaioConstrutora[0]["EnsaioConstrutora"];
		} else {
			$return['EnsaioConstrutora'] = ' <div class="alert alert-danger" role="alert">[15.1 ENSAIOS DE LABORATÓRIO DA CONSTRUTORA] não cadastrado!</div>';
		}
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//

		$EnsaioSupervisora = $this->Tb_relatorio->EnsaioSupervisora($dados);

		if (!empty($EnsaioSupervisora)) {
			$return['EnsaioSupervisora'] = $EnsaioSupervisora[0]["EnsaioSupervisora"];
		} else {
			$return['EnsaioSupervisora'] = ' <div class="alert alert-danger" role="alert">[15.2 ENSAIOS DE LABORATÓRIO DA SUPERVISORA] não cadastrado!</div>';
		}
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$RecuperaPGQ = $this->Tb_relatorio->RecuperaPGQ($dados);

		if (!empty($RecuperaPGQ)) {
			$return['resumo_pgq'] = $RecuperaPGQ[0]["resumo_pgq"];
		} else {
			$return['resumo_pgq'] = '<div class="alert alert-danger" role="alert">[15.4 PLANO DE VERIFICAÇÃO DA EFETIVIDADE DA GESTÃO DA QUALIDADE (PGQ)] não cadastrado!</div>';
		}
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$return['RNC'] = $this->Tb_relatorio->RecuperaRNC($dados);
		$return['GarantiasSeguros'] = $this->Tb_relatorio->GarantiasSeguros($dados);
		$return['RiscosInterferencias'] = $this->Tb_relatorio->RiscosInterferencias($dados);
		$return['AtasCorrespondencias'] = $this->Tb_relatorio->AtasCorrespondencias($dados);

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//

		$return['GestaoTratativas'] = $this->Tb_relatorio->GestaoTratativas($dados);

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//

		$ConclusaoComentarios = $this->Tb_relatorio->ConclusaoComentarios($dados);

		if (!empty($ConclusaoComentarios)) {
			$return['resumo_conclusao'] = $ConclusaoComentarios[0]["resumo_conclusao_comentario"];
		} else {
			$return['resumo_conclusao'] = '<div class="alert alert-danger" role="alert">[21. CONCLUSÃO E COMENTÁRIOS] não cadastrado!</div> ';
		}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//

		$TermoEncerramento = $this->Tb_relatorio->TermoEncerramento($dados);

		if (!empty($TermoEncerramento)) {
			$return['texto_encerramento'] = $TermoEncerramento[0]["texto_encerramento"];
		} else {
			$return['texto_encerramento'] = '<div class="alert alert-danger" role="alert">[22. TERMO DE ENCERRAMENTO] não cadastrado!</div>';
		}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
		$dadoResumo["id_contrato_obra"] = $this->session->idContrato;
		$dadoResumo["idContrato"] = $this->session->idContrato;
		$dadoResumo["periodo"] = $this->input->post_get("periodo");
		$dadoResumo["roteiro"] = "3";
		$resumoprojetoanexo = $this->Tb_resumo->Recuperaresumoprojeto($dadoResumo);
		$return['resumoprojetoAnexo'] = $resumoprojetoanexo;

		$rpfoprojetoanexo = $this->Tb_relatorio->consultaObservacao($dados);
		$return['rpfoprojetoAnexo'] = $rpfoprojetoanexo;

		$dadoMoni["id_contrato_obra"] = $this->session->idContrato;
		$dadoMoni["idContrato"] = $this->session->idContrato;
		$dadoMoni["periodo"] = $this->input->post_get("periodo");
		$dadoMoni["roteiro"] = "11";
		$monitoramentoanexo = $this->Tb_resumo->recuperaPGQ($dadoMoni);
		$return['monitoramentoAnexo'] = $monitoramentoanexo;

		$pbapbaianexo = $this->Tb_pba_pbai->recuperaPbaPbai($dados);
		$return['pbapbaiAnexo'] = $pbapbaianexo;

		$licencasambientaisanexo = $this->Tb_licencas_ambientais->recuperaLicencasAmbientais($dados);
		$return['licencasambientaisAnexo'] = $licencasambientaisanexo;

		$artvigentesanexo = $this->Tb_art_supervisao->recuperaART($dados);
		$return['artvigentesAnexo'] = $artvigentesanexo;

		$dadosu["id_contrato_obra"] = $this->session->idContrato;
		$dadosu["idContrato"] = $this->session->idContrato;
		$dadosu["periodo"] = $this->input->post_get("periodo");
		$dadosu["roteiro"] = "7";
		$ensaiodelaboratoriosupervisoraanexo = $this->Tb_resumo->recuperaPGQ($dadosu);
		$return['ensaiodelaboratoriosupervisorAanexo'] = $ensaiodelaboratoriosupervisoraanexo;

		$dadolabc["id_contrato_obra"] = $this->session->idContrato;
		$dadolabc["idContrato"] = $this->session->idContrato;
		$dadolabc["periodo"] = $this->input->post_get("periodo");
		$dadolabc["roteiro"] = "6";
		$ensaiodelaboratorioconstrutoraanexo = $this->Tb_resumo->recuperaPGQ($dadolabc);
		$return['ensaiodelaboratorioconstrutoraAnexo'] = $ensaiodelaboratorioconstrutoraanexo;

		$dadosd["id_contrato_obra"] = $this->session->idContrato;
		$dadosd["idContrato"] = $this->session->idContrato;
		$dadosd["periodo"] = $this->input->post_get("periodo");
		$dadosd["roteiro"] = "31";
		$infodiariodeobraanexo = $this->Tb_arquivo->recuperaArquivo($dadosd);
		$return['infodiariodeobraAnexo'] = $infodiariodeobraanexo;

		$portariafiscaisquadroanexo = $this->Tb_relatorio->PortariasFiscaisanexo($dados);
		$return['portariafiscaisquadroAnexo'] = $portariafiscaisquadroanexo;

		$dadoan["id_contrato_obra"] = $this->session->idContrato;
		$dadoan["idContrato"] = $this->session->idContrato;
		$dadoan["periodo"] = $this->input->post_get("periodo");
		$dadoan["roteiro"] = "8";
		$infodemaisanexos = $this->Tb_arquivo->recuperaArquivo($dadoan);
		$return['infodemaisanexos'] = $infodemaisanexos;

		$recuperaAnexosGaratias = $this->Tb_relatorio->recuperaAnexosGaratias($dados);
		$return['infoGarantiasSeguros'] = $recuperaAnexosGaratias;

		$registronconformidadesrncanexo = $this->Tb_relatorio->recuperaRNCAnexo($dados);
		$return['registronconformidadesrncanexo'] = $registronconformidadesrncanexo;

		$registronconformidadesrncfotoanexo = $this->Tb_relatorio->RecuperaFotosAnexo($dados);
		$return['registronconformidadesrncfotoanexo'] = $registronconformidadesrncfotoanexo;

		$atascorrespondenciasanexo = $this->Tb_AtasCorrespondencia->recuperaAtasCorrespondencias($dados);
		$return['atascorrespondenciasAnexo'] = $atascorrespondenciasanexo;
		$this->load->view('/supervisaodaq/relatorio/Relatorio', $return);
	}

//--------------------------------------------------------------------------------------------
	public function anexoDownload_old()
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
        
        public function anexoDownload() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $retorno = $nome_arquivo;
        echo(json_encode($retorno));
    }
public function excluiranexorelatorio() {
        $retorno = true;
        echo(json_encode($retorno));
    }
	public function excluiranexorelatorio_old()
	{
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
//		$retorno = unlink($arquivolocalho);
		echo(json_encode($arquivolocalho));
	}

//--------------------------------------------------------------------------------------------
}
