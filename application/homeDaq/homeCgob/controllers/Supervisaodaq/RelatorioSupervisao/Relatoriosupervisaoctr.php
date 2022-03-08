<?php
/*
 * Classe controller Relatoriosupervisaoctr. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Relatoriosupervisaoctr extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('/Supervisaodaq/Tb_analise_relatorio');
		$this->load->model('/Supervisaodaq/Tb_relatorio');
                $this->load->model('Tb_usuario');
		$this->load->database('DAQ', TRUE);
		$this->load->helper('url');
		if (empty($this->session->id_usuario)) {
			redirect(base_url());
		}
	}

//---------------------------------------------------------------------------------------------------------------------------------
	public function recuperaContrato_ol()
	{
		//$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["uf"] = $this->input->post_get("uf");
		$DadosAnaliseRelatorio = $this->Tb_analise_relatorio->recuperaContrato($dados);
		$retorno["data"] = array();
		$n = 1;
		if (!empty($DadosAnaliseRelatorio)) {
			foreach ($DadosAnaliseRelatorio as $lista) {
//------------------------------------------------------------------------------
				$relatorio = '';
				$aceite = '';
				$roteiro_analise = '';
				$ultima_alteracao = '';
				$nome = '';
				$perfil = '';
				$fechamento = '';
				$versao = 0;
				//------------------------------------------------------------------------------
				$dados["id"] = $lista->id_contrato;
				$status = $this->Tb_analise_relatorio->recuperaStatus($dados);
				if (!empty($status)) {
					foreach ($status as $s) {
						$relatorio = $s->relatorio;
						$aceite = $s->aceite;
						$roteiro_analise = $s->roteiro_analise;
						$ultima_alteracao = $s->ultima_alteracao;
						$nome = $s->nome;
						$perfil = $s->perfil;
						$fechamento = $s->fechamento;
						$versao = $s->versao;
					}
				}
				//------------------------------------------------------------------------------
				if (($relatorio == "") or ($aceite == "andamento" && $roteiro_analise == "fechar_relatorio" && $perfil == "analista")) {
					$status_versao = "Aguardando Análise - [" . $versao . "]";
					$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>
                     
                    <a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\">
                     <i class='fa fa-print'style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"iniciarAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o'style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px'>
                     <i class=' fas fa-user'style='color:grey'></i></a>
            ";
				}


				if (($aceite == "andamento" && $perfil == "") or ($aceite == "Aceite" && $perfil == "")) {
					$status_versao = "Em Análise - [" . $versao . "]";
					$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top'style='font-size:20px' href='javascript:void(0);' onclick=\"\">
            <i class='fa fa-tachometer'style='color:grey'></i></a>
                     
                    <a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print' style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px'  href='javascript:void(0);' onclick=\"inserirAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o' style='color:#FFC107'></i></a>

                    <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px'>
                 <i class='fas fa-user-edit' style='color:#FFC107'></i></a>
                          
            ";

				}
				if ($aceite == "Retificado") {
					$status_versao = "Reprovado - [" . $versao . "]";
					$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>
                     
                    <a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print' style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px'  href='javascript:void(0);' onclick=\"inserirAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o' style='color:red'></i></a>

                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
                     <i class='fas fa-thumbs-down' style='color:red'></i></a>
                ";

				}

				if ($aceite == "conclusao" && $roteiro_analise == "fechar_relatorio") {
					$status_versao = "Aprovado - [" . $versao . "]";
					$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"><i class='fa fa-tachometer' style='color:grey'></i></a>
                     
                    <a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print' style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' style='font-size:20px' data-placement='top' href='javascript:void(0);' onclick=\"continuarAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o' style='color:green''></i></a>

                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
                     <i class=' fas fa-thumbs-up' style='color:green'></i></a><a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:16px'> [$ultima_alteracao/$nome]</a>
            ";

				}
				if ($fechamento == '') {
					$fechamento = "--";
				}
				$retorno["data"][] = array(
					'historico' => $n++,
					'contrato' => $lista->contrato,
					'supervisora' => $lista->nu_con_formatado_supervisor,
					'bruf' => $lista->bruf,
					'fechamento' => $fechamento,
					'status' => $status_versao,
					'acoes' => $acao
				);
			}
		}
		echo(json_encode($retorno));
	}


	public function validarAprovar()
	{
		$dados["id"] = $this->input->post_get("id_contrato");
		$dados["periodo"] = $this->input->post_get("periodo");
		$dadosStatusAnalise = $this->Tb_analise_relatorio->confereStatusAnalise($dados);

		$status = $dadosStatusAnalise[0]["result"];

		if ($status == 0) {
			$return = 1;
		} else {
			$return = 2;
		}

		echo(json_encode($return));
	}

//-----------------------------------------------------------------
	public function validarInserir()
	{
		$dados["id"] = $this->input->post_get("id_contrato");
		$dados["idUsuario"] = $this->session->id_usuario_daq;
                $dadosusuario = $this->Tb_usuario->recuperaUsuarioSessao();
                foreach ($dadosusuario as $lista) {
                        $perfil = $lista->id_perfil;
                }
		$dados["idperfil"] = $perfil;

		$DadosValidar = $this->Tb_analise_relatorio->validar($dados);

		$valida = $DadosValidar[0]["id"];
		//-----------------------------------------------------------------
//		if ($valida == 0 and $dados["idperfil"] != 2) {
//			$retorno["mensagem"] = "[A primeira análise deve ser estrutural.]";
//
//			die (json_encode($retorno));
//		}

		$retorno = true;
		echo(json_encode($retorno));
	}

//--------------------------------------------------------------------------------------------------------------------------
	public function recuperaContrato()
	{
		//$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["uf"] = $this->input->post_get("uf");

		$DadosAnaliseRelatorio = $this->Tb_analise_relatorio->recuperaContratoAnalise($dados);
		$retorno["data"] = array();
		$n = 1;
		if (!empty($DadosAnaliseRelatorio)) {
			foreach ($DadosAnaliseRelatorio as $lista) {

				$relatorio = $lista->relatorio;
				$aceite = $lista->aceite;
				$roteiro_analise = $lista->roteiro_analise;
				$ultima_alteracao = $lista->ultima_alteracao;
				$nome = $lista->nome;
				$perfil = $lista->perfil;
				$fechamento = $lista->fechamento;
				$versao = $lista->versao;
				$status_versao = '';
				$acao = "";

				//------------------------------------------------------------------------------
				if (($relatorio == "") or ($aceite == "aguardando análise" && $roteiro_analise == "fechar_relatorio" && $perfil == 2)) {
					$status_versao = "Aguardando Análise - [" . $versao . "]";

					if (is_array($this->session->permissao_telas_daq) && count($this->session->permissao_telas_daq) > 0) {
						foreach ($this->session->permissao_telas_daq as $acesso) {
							if ($acesso->tela == 'Menu Painéis Gerenciais') {
								$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>";
							}
						}
					}

					$acao .= "<a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print'style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"iniciarAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o'style='color:grey'></i></a>
                     
                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
                     <i class=' fas fa-thumbs-up' style='color:green'></i></a><a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:16px'> [$ultima_alteracao/$nome]</a>";
				}


//				if (($aceite == "em analise" && $perfil == 3) or ($aceite == "em analise" && $perfil == 2)) {
//					$status_versao = "Em Análise - [" . $versao . "]";
//
//					if (count($this->session->permissao_telas_daq) > 0) {
//						foreach ($this->session->permissao_telas_daq as $acesso) {
//							if ($acesso->tela == 'Menu Painéis Gerenciais') {
//								$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>";
//							}
//						}
//					}
//
//					$acao .= "<a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
//                     <i class='fa fa-print' style='color:grey'></i></a>
//
//                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px'  href='javascript:void(0);' onclick=\"inserirAnalise({$lista->id_contrato})\">
//                     <i class='fa fa-dot-circle-o' style='color:#FFC107'></i></a>
//
//                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
//                     <i class=' fas fa-thumbs-up' style='color:green'></i></a><a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:16px'> [$ultima_alteracao/$nome]</a>";
//				}

				if ($aceite == "retificado") {
					$status_versao = "Retificado - [" . $versao . "]";

					if (is_array($this->session->permissao_telas_daq) && count($this->session->permissao_telas_daq) > 0) {
						foreach ($this->session->permissao_telas_daq as $acesso) {
							if ($acesso->tela == 'Menu Painéis Gerenciais') {
								$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>";
							}
						}
					}

					$acao .= "<a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print' style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px'  href='javascript:void(0);' onclick=\"inserirAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o' style='color:#FFC107'></i></a>

                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
                     </a><a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:16px'> [$ultima_alteracao/$nome]</a>";
				}

				if ($aceite == "aprovado" && $roteiro_analise == "fechar_relatorio") {
					$status_versao = "Aprovado - [" . $versao . "]";

					if (is_array($this->session->permissao_telas_daq) && count($this->session->permissao_telas_daq) > 0) {
						foreach ($this->session->permissao_telas_daq as $acesso) {
							if ($acesso->tela == 'Menu Painéis Gerenciais') {
								$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>";
							}
						}
					}

					$acao .= "<a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print' style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' style='font-size:20px' data-placement='top' href='javascript:void(0);' onclick=\"continuarAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o' style='color:green''></i></a>

                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
                     <i class=' fas fa-thumbs-up' style='color:green'></i></a>
                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:16px'> [$ultima_alteracao/$nome]</a>";
				}

				if ($aceite == "reprovado" && $roteiro_analise == "fechar_relatorio") {
					$status_versao = "Reprovado - [" . $versao . "]";
					if (is_array($this->session->permissao_telas_daq) && count($this->session->permissao_telas_daq) > 0) {
						foreach ($this->session->permissao_telas_daq as $acesso) {
							if ($acesso->tela == 'Menu Painéis Gerenciais') {
								$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>";
							}
						}
					}

					$acao .= "<a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print' style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' style='font-size:20px' data-placement='top' href='javascript:void(0);' onclick=\"continuarAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o' style='color:red''></i></a>

                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
                     <i class=' fas fa-thumbs-down' style='color:red'></i></a>
                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:16px'> [$ultima_alteracao/$nome]</a>";
				}

				if (($aceite == "em analise" && $roteiro_analise == "fechar_relatorio")) {
					$status_versao = "Em Análise - [" . $versao . "]";
					if (is_array($this->session->permissao_telas_daq) && count($this->session->permissao_telas_daq) > 0) {
						foreach ($this->session->permissao_telas_daq as $acesso) {
							if ($acesso->tela == 'Menu Painéis Gerenciais') {
								$acao = " <a data-toggle='tooltip' title='Painel Gerencial' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"\"> <i class='fa fa-tachometer'style='color:grey'></i></a>";
							}
						}
					}

					$acao .= "<a data-toggle='tooltip' title='Impressão' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"retornaRelatorio({$lista->id_contrato})\">
                     <i class='fa fa-print' style='color:grey'></i></a>

                     <a data-toggle='tooltip' title='Confirmação' data-placement='top' style='font-size:20px'  href='javascript:void(0);' onclick=\"inserirAnalise({$lista->id_contrato})\">
                     <i class='fa fa-dot-circle-o' style='color:#FFC107'></i></a>
                     
                     <a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:20px'>
                     </a><a data-toggle='tooltip' title='Status' data-placement='top' style='font-size:16px'> [$ultima_alteracao/$nome]</a>";
				}

				$retorno["data"][] = array(
					'historico' => $n++,
					'contrato' => $lista->contrato,
					'supervisora' => $lista->nu_con_formatado_supervisor,
					'bruf' => $lista->bruf,
					'fechamento' => $fechamento,
					'status' => $status_versao,
					'acoes' => $acao
				);
			}
		}
		echo(json_encode($retorno));
	}

//--------------------------------------------------------------------------------------------------------------------------
	public function DadosVersaoRelatorioContratoDaq()
	{
		//$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_contrato_obra"] = $this->input->post_get("id_contrato");
		$VersaoRelatorioContratoDaq = $this->Tb_relatorio->VersaoRelatorioContratoDaq($dados);
//------------------------------------------------------------------------------
		$dataano = date("Y", strtotime($this->input->post_get("periodo")));
		$datames = date('m', strtotime($this->input->post_get('periodo')));

		$mes_extenso = array('01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
			'07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro');
		$periodo_referencia = strtoupper($mes_extenso["$datames"]) . "/" . $dataano;

		foreach ($VersaoRelatorioContratoDaq as $versao) {
			//------------------------------------------------------------------------------
			$dados["contrato"] = $versao->contrato;
			$dados["supervisora"] = $versao->supervisora;
			$dados["uf"] = $versao->uf;
			$dados["versao"] = "Versão -";
			$dados["rp"] = "RELATÓRIO PERIÓDICO - RP -" . $periodo_referencia;
		}
		echo json_encode($dados);
	}

//------------------------------------------------------------------------------
	public function DadosModulosRelatorioDaq()
	{
		//$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_contrato_obra"] = $this->input->post_get("id_contrato");
		$dados["id"] = $this->input->post_get("id_contrato");
		$id_contrato = $dados["id_contrato_obra"];
		$ImpressaoRelatorioDaq = $this->Tb_relatorio->DadosImpressaoRelatorioDaq($dados);
		//------------------------------------------------------------------------------
		$num = 1;
		if (!empty($ImpressaoRelatorioDaq)) {
			foreach ($ImpressaoRelatorioDaq as $imprimir) {

				$aceite = '';
				$dados["id_modulo"] = $imprimir->id_modulo;
				$status = $this->Tb_analise_relatorio->recuperaStatusModulo($dados);
				if (!empty($status)) {
					foreach ($status as $s) {
						$aceite = $s->aceite;
						$id = $s->relatorio;
					}
				}
				if ($aceite == "retificado") {

					$acao = " <a data-toggle='tooltip' title='Status Análise' data-placement='top' style='font-size:20px'>
                                 <i class=' fas fa-thumbs-down' style='color:#FFC107'></i></a>
            <a type = 'button' data-toggle='tooltip' title='Editar' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"EditarAnalise({$imprimir->id_modulo},'{$imprimir->modulo}',{$id_contrato})\"> <i class='fas fa-pen-square' style='color:#FFC107'></i></a>
             <a type='button' data-toggle='tooltip' title='Excluir Não aceite' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick = 'ExcluirRetificado(" . $id . ")'><i class = 'fa fa-trash' style='color:#FFC107' ></i></a>";

				} else {
					$acao = " <a data-toggle='tooltip' title='Status Análise' data-placement='top' style='font-size:20px'>
                                 <i class=' fas fa-thumbs-up' style='color:green'></i></a>
            <a type = 'button' data-toggle='tooltip' title='Editar' data-placement='top' style='font-size:20px' href='javascript:void(0);' onclick=\"EditarAnalise({$imprimir->id_modulo},'{$imprimir->modulo}',{$id_contrato})\"> <i class='fas fa-pen-square' style='color:green'></i></a>
             <a type='button' data-toggle='tooltip' title='Excluir Não aceite' data-placement='top' style='font-size:20px'  href='javascript:void(0);' onclick = 'ExcluirRetificado()'><i class = 'fa fa-trash' style='color:green' ></i></a>";
				}
				$dados['data'][] = array(
					"cont" => $num++,
					"modulo" => $imprimir->modulo,
					"nome" => $imprimir->usuario,
					"data" => $imprimir->ultima_alteracao,
					"acao" => $acao

				);
			}
		} else {
			$dados['data'][] = array(
				"cont" => "",
				"modulo" => "Preencher todos os módulos",
				"nome" => "",
				"data" => "",
				"acao" => ""

			);
		}
		echo(json_encode($dados));
	}

//------------------------------------------------------------------------------
	public function confirmacaoAnalise()
	{
		$dados["id_contrato"] = $this->input->post_get('id_contrato');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["aceite"] = "em analise";
		$dados["roteiro"] = "fechar_relatorio";
		$dados["idUsuario"] = $this->session->id_usuario_daq;
                $dadosusuario = $this->Tb_usuario->recuperaUsuarioSessao();
                foreach ($dadosusuario as $lista) {
                        $dados["id_perfil_analise"] = $lista->id_perfil;
                }
		$retorno = $this->Tb_analise_relatorio->insereResumo($dados);
		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------
	public function EditarAnalise()
	{
		$dados["id_modulo"] = $this->input->post_get('id_modulo');
		$dados["id_contrato_obra"] = $this->input->post_get('id_contrato');
		$DadosRelatorio = $this->Tb_analise_relatorio->recuperaAnaliseEdit($dados);
		//print_r($DadosRelatorio);
		if (!empty($DadosRelatorio)) {
			foreach ($DadosRelatorio as $r) {
				$dados["id_relatorio"] = $r->id_relatorio;
				$dados["id_aceite"] = $r->id_aceite;
				$dados["resumo"] = $r->desc_analise_aceite;
			}
		}
		echo(json_encode($dados));
	}

//------------------------------------------------------------------------------
	public function insere_editar_aceite()
	{
		$dados["id_modulo"] = $this->input->post_get('id_modulo');
		$dados["modulo"] = $this->input->post_get('descModuloEditar');
		$dados["id_relatorio"] = $this->input->post_get('id_relatorio');
		$dados["id_contrato"] = $this->input->post_get('id_contrato');
		$dados["aceite"] = $this->input->post_get('aceite');
		$dados["resumo"] = $this->input->post_get('descEditarMotivoAnalise');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["emailanalise"] = $this->session->email;
		$dados["nomeanalise"] = $this->session->desc_nome;
		$dados["perfil_usuario"] = $this->session->perfil_usuario;
                $dadosusuario = $this->Tb_usuario->recuperaUsuarioSessao();
                foreach ($dadosusuario as $lista) {
                        $dados["id_perfil_analise"] = $lista->id_perfil;
                }
		
		$dados["date"] = date('d/m/Y \à\s H:i:s');
		$email = $this->Tb_analise_relatorio->recuperaDados($dados);
		//die($dados["perfil_usuario"]);
//		$emailsupervisor = $email[0]["EMAIL"];

		if ($dados["aceite"] == "Aceite") {
			$dados["roteiro"] = "fechar_relatorio";
		} else {
			$dados["roteiro"] = "liberar_relatorio";
		}

		// if (!empty($dados["id_relatorio"])) {
		//     $retorno = $this->Tb_analise_relatorio->alteraResumo($dados);
		// } else {
		// }
		// $this->email->from("", 'SUPRA-DAQ');
		// $this->email->subject("RELATÓRIO DE SUPERVISÃO AQUAVIÁRIA");
		// //$this->email->reply_to("email_de_resposta@dominio.com");
		// $this->email->to($emailsupervisor);
		// //$this->email->to("jordanaaraujo@falconi.com");
		// //$this->email->cc("jordanaaraujo@falconi.com");
		// //$this->email->bcc('email_copia_oculta@dominio.com');
		// $this->email->message($this->load->view('homeDaq/relatorioSupervisao/RelatorioeditView',$dados, true));
		// $this->email->set_mailtype('html');
		// $this->email->send();
		//------------------------------------------------------------------------------
		$retorno = $this->Tb_analise_relatorio->insereResumo($dados);
		echo(json_encode($retorno));
	}

	public function email()
	{
		$this->load->view('HomeCgdaq/relatorioSupervisao/RelatorioeditView');
	}

//------------------------------------------------------------------------------
	public function recuperarHistoricoAnalises()
	{
		$dados["periodo"] = $this->input->post_get("periodo");
		$dados["id_contrato_obra"] = $this->input->post_get("id_contrato");

		$DadosHistorico = $this->Tb_analise_relatorio->recuperarHistoricoAnalises($dados);
		$retorno["data"] = array();
		$num = 1;
		if (!empty($DadosHistorico)) {
			foreach ($DadosHistorico as $lista) {
				if (!empty($lista->periodo)) {
					$datames = strftime('%B', strtotime($lista->periodo));
					$dataano = date("Y", strtotime($lista->periodo));
				} else {
					$datames = "-";
					$dataano = "-";
				}
				$retorno["data"][] = array(
					'cont' => $num++,
					'referencia' => $datames . "/" . $dataano,
					'aceite' => $lista->aceite,
					'analise' => $lista->desc_analise,
					'modulo' => $lista->modulo,
					'nome' => $lista->nome,
					'perfil' => $lista->perfil,
					'data' => $lista->ultima_alteracao
				);
			}
		}
		echo(json_encode($retorno));
	}

//------------------------------------------------------------------------------
	public function insereConclusao()
	{
		$dados["id_contrato"] = $this->input->post_get('id_contrato_concluir');
		$dados["aceite"] = $this->input->post_get('aceite');
		$dados["roteiro"] = "fechar_relatorio";
		$dados["resumo"] = $this->input->post_get('descfinalizarMotivoAnalise');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dadosusuario = $this->Tb_usuario->recuperaUsuarioSessao();
		foreach ($dadosusuario as $lista) {
			$perfil = $lista->id_perfil;
		}
		$dados["id_perfil_analise"] = $perfil;
		$retorno = $this->Tb_analise_relatorio->insereResumo($dados);

		if ($this->input->post_get('aceite') == 'reprovado') {
			$dados["resumo"] = "Relatório reaberto.";
			$dados["aceite"] = "reaberto";
			$dados["roteiro"] = "liberar_relatorio";
			$retorno = $this->Tb_analise_relatorio->insereResumo($dados);
		}

		echo(json_encode($retorno));
	}

	//------------------------------------------------------------------------------
	public function ExcluirRetificado()
	{
		$dados["id"] = $this->input->post_get('id');
		$dados["id_usuario"] = $this->session->id_usuario_daq;
		$retorno = $this->Tb_analise_relatorio->ExcluirRetificado($dados);
		echo(json_encode($retorno));
	}

//---------------------------------------------------------------------------------------------------------------------------------
	public function Relatorioanalise()
	{
		// $dados["id_contrato_obra"] = $this->session->idContrato;
		// $dados["idContrato"] = $this->session->idContrato;
		$dados["id_contrato_obra"] = $this->input->post_get("id_contrato");
		$dados["idContrato"] = $this->input->post_get("id_contrato");
		$dados["periodo"] = $this->input->post_get("periodo");
		//-------------------------------------------------------------------------------------
		$dataano = date("Y", strtotime($this->input->post_get("periodo")));
		$datames = strftime('%B', strtotime($this->input->post_get("periodo")));

		$periodo_referencia = $datames . "/" . $dataano;

		//------------------------------------------------------------------------------------------
		$DadosContrato = $this->Tb_relatorio->DadosContratoDaq($dados);

		foreach ($DadosContrato as $dadoscontrato) {
			# code...
			$DadosR['hidrovia'] = $dadoscontrato->hidrovia;
			$DadosR['trecho'] = $dadoscontrato->trecho;
			$DadosR['subtrecho'] = $dadoscontrato->subtrecho;
			$DadosR['extensao'] = $dadoscontrato->extensao;
			$DadosR['empresa'] = $dadoscontrato->empresa;
			$DadosR['n_contrato'] = $dadoscontrato->numero_contrato;
			$DadosR['periodo_referencia'] = $periodo_referencia;
			$DadosR['Valor_Inicial_Adit_Reajustes'] = number_format($dadoscontrato->Valor_Inicial_Adit_Reajustes, 2, ",", ".");

		}
		$JustificativaDeEmpreendimento = $this->Tb_relatorio->JustificativaDeEmpreendimento($dados);

		if (!empty($JustificativaDeEmpreendimento)) {
			$DadosR['resumo_justificativa'] = $JustificativaDeEmpreendimento[0]["resumo_justificativa"];
		} else {
			$DadosR['resumo_justificativa'] = '<div class="alert alert-danger" role="alert">[1. JUSTIFICATIVA E APRESENTAÇÃO DO EMPREENDIMENTO] não cadastrado!</div>';
		}
		$mapasituacao = $this->Tb_relatorio->mapasituacao($dados);
		if (!empty($mapasituacao)) {
			$DadosR['mapa_situacao'] = $mapasituacao[0]["mapa_situacao"];
		} else {
			$DadosR['mapa_situacao_nao_cadastrado'] = '<div class="alert alert-danger" role="alert">[2. MAPA DE SITUAÇÃO] não cadastrado!</div>';
		}
		$resumoprojeto = $this->Tb_relatorio->resumoprojeto($dados);
		if (!empty($resumoprojeto)) {
			foreach ($resumoprojeto as $key) {

				if ($key->tipo_resumo == 1) {
					$DadosR['IP4'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 2) {
					$DadosR['derrocamento'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 3) {
					$DadosR['Dragagem'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 4) {
					$DadosR['desobstrucao_presenca_vegetacao'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 5) {
					$DadosR['dragagem_portos_maritimos'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 6) {
					$DadosR['construcao_estacao_passageiro'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 7) {
					$DadosR['remocao_navio_haider'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 8) {
					$DadosR['implantacao_sinalizacao_hidrovias'] = $key->resumo_projeto;
				}
				if ($key->tipo_resumo == 9) {
					$DadosR['obras_em_clusas'] = $key->resumo_projeto;
				}

				if (empty($DadosR['IP4'])) {
					$DadosR['IP4'] = '<div class="alert alert-danger" role="alert">[3.1 Construção Portuária] não cadastrado!</div>';
				}
				if (empty($DadosR['derrocamento'])) {
					$DadosR['derrocamento'] = '<div class="alert alert-danger" role="alert">[3.2 Derrocagem] não cadastrado!</div>';
				}
				if (empty($DadosR['Dragagem'])) {
					$DadosR['Dragagem'] = '<div class="alert alert-danger" role="alert">[3.3 Dragagem] não cadastrado!</div>';
				}
				if (empty($DadosR['desobstrucao_presenca_vegetacao'])) {
					$DadosR['desobstrucao_presenca_vegetacao'] = '<div class="alert alert-danger" role="alert">[3.4 Desobstrução] não cadastrado!</div> ';
				}
				if (empty($DadosR['dragagem_portos_maritimos'])) {
					$DadosR['dragagem_portos_maritimos'] = '<div class="alert alert-danger" role="alert">[3.5 Recuperação Portuária] não cadastrado!</div> ';
				}
				if (empty($DadosR['construcao_estacao_passageiro'])) {
					$DadosR['construcao_estacao_passageiro'] = '<div class="alert alert-danger" role="alert">[3.6 Monitoramento Hidroviário] não cadastrado!</div> ';
				}
				if (empty($DadosR['remocao_navio_haider'])) {
					$DadosR['remocao_navio_haider'] = '<div class="alert alert-danger" role="alert">[3.7 Remoção do Navio ] não cadastrado!</div> ';
				}
				if (empty($DadosR['implantacao_sinalizacao_hidrovias'])) {
					$DadosR['implantacao_sinalizacao_hidrovias'] = '<div class="alert alert-danger" role="alert">[3.8 Implantação de Sinalização em Hidrovias] não cadastrado!</div> ';
				}
				if (empty($DadosR['obras_em_clusas'])) {
					$DadosR['obras_em_clusas'] = '<div class="alert alert-danger" role="alert">[3.9 Recuperação Eclusas e Barragens] não cadastrado!</div> ';
				}
			}
		} else {
			$DadosR['IP4'] = '<div class="alert alert-danger" role="alert">[3.1 Construção Portuária] não cadastrado!</div>';
			$DadosR['derrocamento'] = '<div class="alert alert-danger" role="alert">[3.2 Derrocagem] não cadastrado!</div>';
			$DadosR['Dragagem'] = '<div class="alert alert-danger" role="alert">[3.3 Dragagem] não cadastrado!</div>';
			$DadosR['desobstrucao_presenca_vegetacao'] = '<div class="alert alert-danger" role="alert">[3.4 Desobstrução] não cadastrado!</div> ';
			$DadosR['dragagem_portos_maritimos'] = '<div class="alert alert-danger" role="alert">[3.5 Recuperação Portuária] não cadastrado!</div> ';
			$DadosR['construcao_estacao_passageiro'] = '<div class="alert alert-danger" role="alert">[3.6 Monitoramento Hidroviário] não cadastrado!</div> ';
			$DadosR['remocao_navio_haider'] = '<div class="alert alert-danger" role="alert">[3.7 Remoção do Navio ] não cadastrado!</div> ';
			$DadosR['implantacao_sinalizacao_hidrovias'] = '<div class="alert alert-danger" role="alert">[3.8 Implantação de Sinalização em Hidrovias] não cadastrado!</div> ';
			$DadosR['obras_em_clusas'] = '<div class="alert alert-danger" role="alert">[3.9 Recuperação Eclusas e Barragens] não cadastrado!</div> ';

		}


		$resumorpfo = $this->Tb_relatorio->resumoRpfo($dados);

		if (!empty($resumorpfo)) {
			$DadosR['resumo_rpfo'] = $resumorpfo[0]["resumo_rpfo"];
		} else {
			$DadosR['resumo_rpfo'] = '<div class="alert alert-danger" role="alert">[3.10 REVISÕES DE PROJETO EM FASE DE OBRAS - RPFO] não cadastrado!</div>';
		}


		$diagramaOcorrencia = $this->Tb_relatorio->diagramaOcorrencia($dados);

		if (!empty($diagramaOcorrencia)) {
			$DadosR['diagrama_ocorrencia_pp'] = $diagramaOcorrencia[0]["diagrama_ocorrencia_pp"];
		} else {
			$DadosR['diagrama_ocorrencia_pp_nao_cadastrado'] = '<div class="alert alert-danger" role="alert">[4. DIAGRAMA DE OCORRÊNCIAS E PONTOS DE PASSAGEM] não cadastrado!</div>';
		}


		$historicoObra = $this->Tb_relatorio->historicoObra($dados);

		if (!empty($historicoObra)) {
			$DadosR['historico_obra'] = $historicoObra[0]["historico_obra"];
		} else {
			$DadosR['historico_obra'] = '<div class="alert alert-danger" role="alert">[5. HISTÓRICO] não cadastrado!</div>';
		}


		$introducaoObra = $this->Tb_relatorio->introducaoObra($dados);

		if (!empty($introducaoObra)) {
			$DadosR['introducao_obra'] = $introducaoObra[0]["introducao_obra"];
		} else {
			$DadosR['introducao_obra'] = '<div class="alert alert-danger" role="alert">[6. INTRODUÇÃO] não cadastrado!</div> ';
		}


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
				$valor_PI = number_format($lista->valor_pi_contrato, 2, ",", ".");
				$valor_aditado = number_format($lista->valor_total_aditado, 2, ",", ".");
				$valor_reajuste = number_format($lista->valor_reajuste, 2, ",", ".");
				$valor_atualizado = number_format($lista->valor_atz_pir, 2, ",", ".");
			}

			$DadosR['apresentacao_supervisora'] =
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
                               <td>$valor_PI</td>
                            </tr>
                            <tr>
                                <td class='bold'>Valor Total Aditado do Contrato</td>
                               <td>$valor_aditado</td>
                            </tr>
                            <tr>
                                <td class='bold'>Valor de Reajuste do Contrato</td>
                                <td>$valor_reajuste</td>
                            </tr>
                            <tr>
                                <td class='bold'>Valor Atualizado do Contrato(PI+A+R)</td>
                                <td>$valor_atualizado</td>
                            </tr>
                    </table>
            </div> ";

		} else {
			$DadosR['apresentacao_supervisora'] = '<div class="alert alert-danger" role="alert">[7.1 APRESENTAÇÃO DA SUPERVISORA] não cadastrado!</div>';
		}
//-------------------------------------------------------------------------------------------- 
		$dados['contrato_fiscalizado'] = 'Supervisão';
		$DadosR['apresentacao_supervisora_fiscais'] = $this->Tb_apresentacao_supervisora->recuperaPortariasFiscais($dados);
//--------------------------------------------------------------------------------------------
		$DadosR['apresentacao_supervisora_aditivos'] = $this->Tb_apresentacao_supervisora_aditivo->Tableaditivo($dados);
//-------------------------------------------------------------------------------------------- 
		$DadosR['apresentacao_supervisora_localizacao'] = $this->Tb_apresentacao_supervisora_localizacao->Tablelocalizacao($dados);
//-------------------------------------------------------------------------------------------- 

		//$DadosR['apresentacao_supervisora_localizacao'] = $this->Tb_apresentacao_supervisora_localizacao->Tablelocalizacao($dados);

//--------------------------------------------------------------------------------------------
		$DadosR['apresentacao_supervisora_resposavel'] = $this->Tb_apresentacao_supervisora_tecnico->recuperaART($dados);
//--------------------------------------------------------------------------------------------
		$dadoSuper["roteiro"] = 19;
		$DadosR['apresentacao_supervisora_paralisacao'] = $this->Tb_apresentacao_paralisacao_reinicio->tableAsParalisacaoReinicio($dadoSuper);

		$DadosR['Mobilizacao_SICRO_Supervisora_Pessoal'] = $this->Tb_relatorio->Mobilizacao_SICRO_Supervisora_Pessoal($dados);
		$DadosR['Mobilizacao_SICRO_SUpervisora_Equipamento'] = $this->Tb_relatorio->Mobilizacao_SICRO_SUpervisora_Equipamento($dados);
		$DadosR['Mobilizacao_SICRO_SUpervisora_Materiais'] = $this->Tb_relatorio->Mobilizacao_SICRO_SUpervisora_Materiais($dados);
		$DadosR['Mobilizacao_SICRO_SUpervisora_Atividade_Auxiliares'] = $this->Tb_relatorio->Mobilizacao_SICRO_SUpervisora_Atividade_Auxiliares($dados);

		$AtividadeSupervisora = $this->Tb_relatorio->AtividadeSupervisora($dados);

		if (!empty($AtividadeSupervisora)) {
			$DadosR['atividade_supervisora'] = $AtividadeSupervisora[0]["atividade_supervisora"];
		} else {
			$DadosR['atividade_supervisora'] = '<div class="alert alert-danger" role="alert">[7.3 ATIVIDADES EXECUTADAS PELA SUPERVISORA] não cadastrado!</div>  ';
		}
		$DadosR['apresentacao_construtora'] = $this->Tb_apresentacao_construtora->RecuperaApresentacaoConstrutora($dados);
		$DadosR['apresentacao_construtora_fiscais'] = $this->Tb_apresentacao_construtora->recuperaPortariasFiscais($dados);
		$DadosR['apresentacao_construtora_aditivo'] = $this->Tb_apresentacao_construtora_aditivo->Tableaditivo($dados);
		$DadosR['apresentacao_construtora_localizacao'] = $this->Tb_apresentacao_construtora_localizacao->Tablelocalizacao($dados);

		$dadoCons["roteiro"] = 18;
		$DadosR['apresentacao_contrutora_paralisacao'] = $this->Tb_apresentacao_paralisacao_reinicio->tableAsParalisacaoReinicio($dadoCons);

		$DadosR['Mobilizacao_SICRO_Construtora_Pessoal'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Pessoal($dados);
		$DadosR['Mobilizacao_SICRO_Construtora_Equipamento'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Equipamento($dados);
		$DadosR['Mobilizacao_SICRO_Construtora_Materiais'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Materiais($dados);
		$DadosR['Mobilizacao_SICRO_Construtora_Atividade_Auxiliares'] = $this->Tb_relatorio->Mobilizacao_SICRO_Construtora_Atividade_Auxiliares($dados);


		$AtividadeConstrutora = $this->Tb_relatorio->AtividadeConstrutora($dados);

		if (!empty($AtividadeConstrutora)) {
			$DadosR['atividade_construtora'] = $AtividadeConstrutora[0]["atividade_construtora"];
		} else {
			$DadosR['atividade_construtora'] = '<div class="alert alert-danger" role="alert">[8.3 ATIVIDADES EXECUTADAS PELA CONSTRUTORA] não cadastrado!</div> ';
		}

		$analiseCriticaCronograma = $this->Tb_relatorio->analiseCriticaCronograma($dados);

		if (!empty($analiseCriticaCronograma)) {
			$DadosR['analise_critica_cronograma'] = $analiseCriticaCronograma[0]["analise_critica_cronograma"];
		} else {
			$DadosR['analise_critica_cronograma'] = '<div class="alert alert-danger" role="alert">[8.5 ANÁLISE CRÍTICA DOS CRONOGRAMAS] não cadastrado!</div>';
		}

		$controlePluviometrico = $this->Tb_relatorio->controlePluviometrico($dados);

		$DadosR['total_dias'] = "";
		$DadosR['status_dia'] = "";

		foreach ($controlePluviometrico as $keycontrolePluviometrico) {
			# code...
			$situacao = $keycontrolePluviometrico->situacao;
			$DadosR['total_dias'] .= "<td>" . $keycontrolePluviometrico->dia . "</td>";

			if ($situacao == 'Bom') {
				$DadosR['status_dia'] .= "<td class='pluviometricoB'></td>";
			}
			if ($situacao == 'Chuva') {
				$DadosR['status_dia'] .= "<td class='pluviometricoC'></td>";
			}
			if ($situacao == 'Impraticável') {
				$DadosR['status_dia'] .= "<td class='pluviometricoI'></td>";
			}
			if ($situacao == 'Instavel') {
				$DadosR['status_dia'] .= "<td>-</td>";
			}
			if ($situacao == 'Não houveram atividades') {
				$DadosR['status_dia'] .= "<td>-</td>";
			}
		}


		$DadosR['DocumentacaoFotografica'] = $this->Tb_relatorio->DocumentacaoFotografica($dados);
		$DadosR['LicencasAmbientais'] = $this->Tb_licencas_ambientais->recuperaLicencasAmbientais($dados);

		$EnsaioConstrutora = $this->Tb_relatorio->EnsaioConstrutora($dados);

		if (!empty($EnsaioConstrutora)) {
			$DadosR['EnsaioConstrutora'] = $EnsaioConstrutora[0]["EnsaioConstrutora"];
		} else {
			$DadosR['EnsaioConstrutora'] = ' <div class="alert alert-danger" role="alert">[11.1 ENSAIOS DE LABORATÓRIO DA CONSTRUTORA] não cadastrado!</div>';
		}

		$EnsaioSupervisora = $this->Tb_relatorio->EnsaioSupervisora($dados);

		if (!empty($EnsaioSupervisora)) {
			$DadosR['EnsaioSupervisora'] = $EnsaioSupervisora[0]["EnsaioSupervisora"];
		} else {
			$DadosR['EnsaioSupervisora'] = ' <div class="alert alert-danger" role="alert">[11.2 ENSAIOS DE LABORATÓRIO DA SUPERVISORA] não cadastrado!</div>';
		}

		$RecuperaPGQ = $this->Tb_relatorio->RecuperaPGQ($dados);

		if (!empty($RecuperaPGQ)) {
			$DadosR['resumo_pgq'] = $RecuperaPGQ[0]["resumo_pgq"];
		} else {
			$DadosR['resumo_pgq'] = '<div class="alert alert-danger" role="alert">[11.3 PLANO DE VERIFICAÇÃO DA EFETIVIDADE DA GESTÃO DA QUALIDADE (PVEGQ)] não cadastrado!</div>';
		}

		$DadosR['GarantiasSeguros'] = $this->Tb_relatorio->GarantiasSeguros($dados);
		$DadosR['RiscosInterferencias'] = $this->Tb_relatorio->RiscosInterferencias($dados);
		$DadosR['AtasCorrespondencias'] = $this->Tb_relatorio->AtasCorrespondencias($dados);
		$DadosR['GestaoTratativas'] = $this->Tb_relatorio->GestaoTratativas($dados);
		$ConclusaoComentarios = $this->Tb_relatorio->ConclusaoComentarios($dados);

		if (!empty($ConclusaoComentarios)) {
			$DadosR['resumo_conclusao'] = $ConclusaoComentarios[0]["resumo_conclusao_comentario"];
		} else {
			$DadosR['resumo_conclusao'] = '<div class="alert alert-danger" role="alert">[16. CONCLUSÃO E COMENTÁRIOS] não cadastrado!</div> ';
		}

		$TermoEncerramento = $this->Tb_relatorio->TermoEncerramento($dados);

		if (!empty($TermoEncerramento)) {
			$DadosR['texto_encerramento'] = $TermoEncerramento[0]["texto_encerramento"];
		} else {
			$DadosR['texto_encerramento'] = '<div class="alert alert-danger" role="alert">[17. TERMO DE ENCERRAMENTO] não cadastrado!</div>';
		}

	}
//-------------------------------------------------------------------------------------------- 


}//Fecha
