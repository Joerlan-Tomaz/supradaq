<?php
/*
 * Classe controller PainelGerencialctr.
 * @author Pedro Correia <pedrocorreia@falconi.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PainelGerencialSupervisaoctr extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ftp');
		$this->load->model('/Supervisaodaq/Tb_contrato_supervisora');
		$this->load->model('/Supervisaodaq/Tb_cronogramafinanceiro');
        $this->load->model('/Supervisaodaq/Tb_apresentacao_supervisora_aditivo');
        $this->load->model('/Supervisaodaq/Tb_art_supervisao');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

	function geraTimestamp($data)
	{
		$partes = explode('/', $data);
		return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
	}

	public function gerencialSupervisaoDados()
	{
		$dados['id_contrato_obra'] = $_REQUEST['id_contrato_obra'];
		$dadosSupervisao = $this->Tb_contrato_supervisora->dadosSupervisoraPainelGerencial($dados);

		if (count($dadosSupervisao) > 0) {
			$data_inicial = date('d/m/Y');
			$data_final = $dadosSupervisao[0]->sup_data_termino_vigencia;

			$time_inicial = $this->geraTimestamp($data_inicial);
			$time_final = $this->geraTimestamp($data_final);
			$diferenca = $time_final - $time_inicial;
			$dias = (int)floor($diferenca / (60 * 60 * 24));
			if ($dias < 0) {
				$dias = "--";
			}
			$dadosSupervisao[0]->sup_dias_vencer = $dias;
		} else {
			$dadosSupervisao = array();
			$dadosSupervisao[0]['statusSupervisao'] = 'N/C';
			$dadosSupervisao[0]['sup_contrato'] = 'N/C';
			$dadosSupervisao[0]['supervisao_nome'] = 'N/C';
			$dadosSupervisao[0]['sup_objetivo'] = 'N/C';
			$dadosSupervisao[0]['sup_regime'] = 'N/C';
			$dadosSupervisao[0]['sup_edital'] = 'N/C';
			$dadosSupervisao[0]['sup_mesBase'] = 'N/C';
			$dadosSupervisao[0]['sup_tp_intervencao'] = 'N/C';
			$dadosSupervisao[0]['sup_assinatura'] = 'N/C';
			$dadosSupervisao[0]['sup_ordem_inicio'] = 'N/C';
			$dadosSupervisao[0]['sup_dias_paralisados'] = 'N/C';
			$dadosSupervisao[0]['sup_dias_aditados'] = 'N/C';
			$dadosSupervisao[0]['sup_data_termino_servico'] = 'N/C';
			$dadosSupervisao[0]['sup_data_termino_vigencia'] = 'N/C';
			$dadosSupervisao[0]['sup_dias_vencer'] = 'N/C';
			$dadosSupervisao[0]['sup_unidade_fiscalizadora'] = 'N/C';
			$dadosSupervisao[0]['sup_fiscal'] = 'N/C';
			$dadosSupervisao[0]['sup_email'] = 'N/C';
			$dadosSupervisao[0]['sup_telefone'] = 'N/C';
		}
		echo(json_encode($dadosSupervisao[0]));
	}

	public function gerencialSupervisaoResumoFinanceiro()
	{
		$dados['id_contrato_obra'] = $_REQUEST['id_contrato_obra'];
		$dadosSupervisaoFinanceiro = $this->Tb_contrato_supervisora->gerencialSupervisaoResumoFinanceiro($dados);

		$dados = array();
        $calculoPizza['valorTotal'] = 0;
		if (!count($dadosSupervisaoFinanceiro) > 0) {
			$dados[0]['sup_valor_pi'] = 'N/C';
			$dados[0]['sup_valor_aditivos'] = 'N/C';
			$dados[0]['sup_reajustamento'] = 'N/C';
			$dados[0]['sup_valor_total'] = 'N/C';
			$dados[0]['sup_valor_medido'] = 'N/C';
			$dados[0]['sup_valor_medido_piar'] = 'N/C';
			$dados[0]['sup_valor_medir'] = 'N/C';
			$dados[0]['sup_total_empenhado'] = 'N/C';
			$dados[0]['sup_saldo_empenhado'] = 'N/C';
			$dados[0]['sup_saldo_empenhar'] = 'N/C';
		} else {
			$dados = array();
			$dados["sup_valor_pi"] = number_format($dadosSupervisaoFinanceiro[0]->valor_pi, 2, ",", ".");
			$dados["sup_valor_aditivos"] = number_format($dadosSupervisaoFinanceiro[0]->aditivos, 2, ",", ".");
			$dados["sup_reajustamento"] = number_format($dadosSupervisaoFinanceiro[0]->reajustamento, 2, ",", ".");
			$dados["sup_valor_total"] = number_format($dadosSupervisaoFinanceiro[0]->valor_total, 2, ",", ".");
			$dados["sup_valor_medido"] = number_format($dadosSupervisaoFinanceiro[0]->total_medido, 2, ",", ".");
			$dados["sup_valor_medido_piar"] = number_format($dadosSupervisaoFinanceiro[0]->total_medido_piar, 2, ",", ".");
			$dados["sup_valor_medir"] = number_format($dadosSupervisaoFinanceiro[0]->valor_total - $dadosSupervisaoFinanceiro[0]->total_medido_piar, 2, ",", ".");
			$dados["sup_total_empenhado"] = number_format($dadosSupervisaoFinanceiro[0]->total_empenhado, 2, ",", ".");
			$dados["sup_saldo_empenhado"] = number_format($dadosSupervisaoFinanceiro[0]->total_empenhado - $dadosSupervisaoFinanceiro[0]->total_medido_piar, 2, ",", ".");
			$dados["sup_saldo_empenhar"] = number_format($dadosSupervisaoFinanceiro[0]->valor_total - $dadosSupervisaoFinanceiro[0]->total_empenhado, 2, ",", ".");

			$dados['sup_valor_pi'] = number_format((float)$dadosSupervisaoFinanceiro[0]->valor_pi, 2, ",", ".");
			$dados['sup_valor_aditivos'] = number_format((float)$dadosSupervisaoFinanceiro[0]->aditivos, 2, ",", ".");
			$dados['sup_reajustamento'] = number_format((float)$dadosSupervisaoFinanceiro[0]->reajustamento, 2, ",", ".");
			$dados['sup_valor_total'] = number_format((float)$dadosSupervisaoFinanceiro[0]->valor_total, 2, ",", ".");

			$dados['sup_valor_pi_pizza'] = (float)$dadosSupervisaoFinanceiro[0]->valor_pi;
			$dados['sup_valor_aditivos_pizza'] = (float)$dadosSupervisaoFinanceiro[0]->aditivos;
			$dados['sup_reajustamento_pizza'] = (float)$dadosSupervisaoFinanceiro[0]->reajustamento;
		}
		echo(json_encode($dados));
	}


	public function gerencialSupervisaoResumoFinanceiroGrafico()
	{
		$dados["id_contrato_obra"] = $this->input->post_get("id_contrato_obra");
		$retorno = $this->Tb_contrato_supervisora->gerencialSupervisaoResumoFinanceiro($dados);
		if (count($retorno) > 0) {
            $total = number_format($retorno[0]->valor_total, 2, ".", "");
			$aEmpenhar = number_format($retorno[0]->total_empenhado, 2, ".", "");
			$dados['empenhado'] = (float)number_format(($aEmpenhar * 100) / $total, 2, ".", "");

			$totalMedido = number_format($retorno[0]->total_medido_piar, 2, ".", "");
			$dados['medido'] = (float)number_format(($totalMedido * 100) / $total, 2, ".", "");

			$medir = number_format($retorno[0]->valor_total - $retorno[0]->total_medido_piar, 2, ".", "");
			$dados['medir'] = (float)number_format(($medir * 100) / $total, 2, ".", "");
		} else {
			$dados['empenhado'] = 0;
			$dados['medido'] = 0;
			$dados['medir'] = 0;
		}

		echo(json_encode($dados));
	}


	public function gerencialSupervisaoResumoCurvaSGrafico()
	{
		$dados["id_contrato_obra"] = $this->input->post_get("id_contrato_obra");
		$montarGrafico = $this->Tb_cronogramafinanceiro->buscadadosgraficoSupervisao($dados);
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

	public function gerencialSupervisaoAditivos(){
        $dados["idContrato"] = $this->input->post_get("id_contrato_obra");
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "19";

        $Dados = $this->Tb_apresentacao_supervisora_aditivo->Tableaditivo($dados);
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                $descricao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick ='modalObjetoMotivacaoAditivoSupervisora(".$lista->id_termo_aditivo.")'><i class = 'fa fa-eye'></i></button >";
                $retorno["data"][] = array(
                    'NUMERO_TERMO'=> $lista->numero_termo,
                    'DATA_ASSINATURA'=> $lista->data_assinatura,
                    'OBJETO_TERMO'=>$descricao,
                    'DIAS_ADITADOS'=>$lista->dias_aditados,
                    'VALOR_ADITADO'=> "R$".number_format($lista->valor_aditado,2,",",".")
                );
            }
        }
        echo (json_encode($retorno));
    }

    public function gerencialSupervisaoArt(){
        $dados["idContrato"] = $this->input->post_get("id_contrato_obra");

        $Dados = $this->Tb_art_supervisao->recuperaART($dados);
        $downlaods = '';
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                if (!empty($lista->nomeOriginalArquivo)) {
                    $nomeArquivo = $lista->nomeOriginalArquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                $arquivo = "<a class=\"btn btn-primary btn-sm\" href='javascript:void(0);' onclick=\"artAnexo('{$lista->nome_arquivo}')\">Download</a>";
                $downlaods .= '<div class="callout callout-info">
                            <h5><i class="fa fa-paperclip"></i>
                                '.$nomeArquivo.'
                            </h5>
                            <span class="time pull-right"><i
                                        class="fa fa-clock-o"></i>'.$lista->ultima_alteracao.'</span>
                            <p>'.$arquivo.'</p>
                        </div>';
                $downlaods .= '';
            }
        }
        echo (json_encode($downlaods));
    }

}//Fecha Classe
//######################################################################################################################################################################################################################## 
//# DNIT-Falconi AQUAVIARIO
//# Supervisaodaqctr.php
//# Desenvolvedora:Pedro Correia
//# Data: 18/01/2021
//########################################################################################################################################################################################################################
