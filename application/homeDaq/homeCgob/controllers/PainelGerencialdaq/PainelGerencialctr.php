<?php
/*
 * Classe controller PainelGerencialctr.
 * @author Pedro Correia <pedrocorreia@falconi.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PainelGerencialctr extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ftp');
        $this->load->model('/Supervisaodaq/Tb_contrato_obra');
        $this->load->model('/Supervisaodaq/Tb_resumo');
        $this->load->model('/Supervisaodaq/Tb_fotografica');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->model('/Supervisaodaq/Tb_cronogramafinanceiro');
        $this->load->model('/Supervisaodaq/Tb_cronograma_fisico');
        $this->load->model('/Supervisaodaq/Tb_relatorio');
        $this->load->model('/Supervisaodaq/Tb_licencas_ambientais');
        $this->load->model('/Supervisaodaq/Tb_avanco_financeiro');
        $this->load->model('/Supervisaodaq/Tb_avanco_fisico');
        $this->load->model('/Supervisaodaq/Tb_dados_contrato');
        $this->load->model('/Supervisaodaq/Tb_apresentacao_construtora_aditivo');
        $this->load->model('Tb_usuario');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    public function homePainelGerencial()
    {
       $dados['id_usuario'] = $this->session->id_usuario_daq;
        $dadosUsuario = $this->Tb_usuario->buscaUsuario($dados);
        
         foreach ($dadosUsuario as $lista) {
                $view['id_perfil'] = $lista->ID_PERFIL;
                
            }
         $this->load->view('/painelgerencialdaq/homePainelGerencialView',$view);
        //$this->load->view('/painelgerencialdaq/homePainelGerencialView');
    }

    public function buscarSelectUf()
    {
        $uf = $this->Tb_contrato_obra->BuscaUf();
        $select = array();
        if (is_array($uf)) {
            foreach ($uf as $id => $dados) {
                $select[$id]['id'] = $dados->uf;
                $select[$id]['label'] = $dados->uf . " - " . $dados->estado;
            }
        }
        echo(json_encode($select));
    }

    public function buscarSelectContratos()
    {
        $contratosPorUf = $this->Tb_contrato_obra->ListaContratosPorUf($_REQUEST['uf']);

        $select = array();
        if (is_array($contratosPorUf)) {
            foreach ($contratosPorUf as $id => $dados) {
                $select[$id]['id'] = $dados->id_contrato;
                $select[$id]['label'] = $dados->contrato . ' - ' . $dados->nomecontrato;
            }
        }
        echo(json_encode($select));
    }

    public function gerencialObraContrato()
    {
        $dadosContrato = $this->Tb_contrato_obra->dadosContratoPainelGerencial();

        $data_inicial = date('d/m/Y');
        $data_final = $dadosContrato[0]->dataTerminoVigencia;

        $time_inicial = $this->geraTimestamp($data_inicial);
        $time_final = $this->geraTimestamp($data_final);
        $diferenca = $time_final - $time_inicial;
        $dias = (int)floor($diferenca / (60 * 60 * 24));
        if ($dias < 0) {
            $dias = "--";
        }
        $dadosContrato[0]->diasVencer = $dias;

		$log = array(
			'idContrato' => $_REQUEST['id_contrato_obra'],
		);
		$this->session->set_userdata($log);

        echo(json_encode($dadosContrato[0]));
    }

    function geraTimestamp($data)
    {
        $partes = explode('/', $data);
        return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    }

    public function gerencialObraResumo()
    {
        $dados['idContrato'] = $_REQUEST['id_contrato_obra'];
        $dados['roteiro'] = 3;
        $dadosResumo = $this->Tb_resumo->Recuperaresumo($dados);
        if (!isset($dadosResumo[count($dadosResumo) - 1])) {
            $dadosResumo[0]['resumo'] = '';
            $dadosResumo[0]['ultima_alteracao'] = '';
        }
        echo(json_encode($dadosResumo[0]));
    }

    public function gerencialObraInserirResumo(){
		$dados["resumo"] = $this->input->post_get('resumo');
		$dados["periodo"] = date('Y-m') . "-01";
		$dados["roteiro"] = "3";
		$dados["idUsuario"] = $this->session->id_usuario;
		$dados["idContrato"] = 513;

		echo(json_encode($this->Tb_resumo->insereResumo($dados)));
	}

    public function gerencialObraDadosFotos()
    {
        $dados['id_contrato_obra'] = $_REQUEST['id_contrato_obra'];
        $retorno = $this->Tb_fotografica->getQtdFotosMesPainelGerencial($dados);

        foreach($retorno as $i => $fotos){
			$mes = $this->verificaMes($fotos->mes, 'N');
			$retorno[$i]->mesAno = $mes . '/' . $fotos->ano;
		}
        echo(json_encode($retorno));
    }
    
    public function gerencialObraFotosPeriodo() {
        $dados['id_contrato_obra'] = $_REQUEST['id_contrato_obra'];
        $dados['periodo'] = '' . $_REQUEST['periodo'];
        $retorno = $this->Tb_fotografica->getFotosPeriodoPainelGerencial($dados);

        foreach ($retorno as $i => $foto) {
            $path_imagem = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=' . $foto->nome_arquivo);
            $imagem = "<div>";
            $imagem .= "    <a href=".$path_imagem." data-fancybox='group'>";
            $imagem .= "        <img src=".$path_imagem." alt='img01' width='30%' height='180px'>";
            $imagem .= "    </a>";
            $imagem .= "    <div>";
            $imagem .= "        <small>Clique na foto para ampliar!</small>";
            $imagem .= "    </div>";
            $imagem .= "</div>";
            $mes = $this->verificaMes($foto->mes, 'N');
            $retorno[$i]->mesAno = $mes . '/' . $foto->ano;
            $retorno[$i]->miniatura = $imagem;
            $retorno[$i]->link = "<a class='btn btn-block btn-default btn-sm' data-toggle='tooltip' title='Download' data-placement='bottom' href='index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051?img=" . $foto->nome_arquivo . "' download=''><i class='fa fa-fw fa-download'></i></a>";
        }
        echo(json_encode($retorno));
    }
    
    public function gerencialObraFotosPeriodo_old_24112021_1037()
    {
        $dados['id_contrato_obra'] = $_REQUEST['id_contrato_obra'];
        $dados['periodo'] = '' . $_REQUEST['periodo'];
        $retorno = $this->Tb_fotografica->getFotosPeriodoPainelGerencial($dados);

        foreach ($retorno as $i => $foto) {
			$mes = $this->verificaMes($foto->mes, 'N');
			$retorno[$i]->mesAno = $mes . '/' . $foto->ano;
            $retorno[$i]->miniatura = "<a href='70bc1de8a077e52493d9c41ffaa3c051?img=" . $foto->nome_arquivo . "' data-fancybox='group'> <img src='70bc1de8a077e52493d9c41ffaa3c051?img=" . $foto->nome_arquivo . "' alt='img01' width='25%' height='150px'></a>";
            $retorno[$i]->link = "<a class='btn btn-block btn-default btn-sm' data-toggle='tooltip' title='Download' data-placement='bottom' href='70bc1de8a077e52493d9c41ffaa3c051?img=" . $foto->nome_arquivo . "' download=''><i class='fa fa-fw fa-download'></i></a>";
        }

        echo(json_encode($retorno));
    }

    public function gerencialObraResumoFinanceiro()
    {
        $dados["idContrato"] = $this->input->post_get("id_contrato_obra");
        $retorno = $this->Tb_contrato_obra->RecuperaGerencialObraFinanceiro($dados);

        $dados = array();
        $dados["valor_pi"] = number_format($retorno[0]->valor_pi, 2, ",", ".");
        $dados["aditivos"] = number_format($retorno[0]->aditivos, 2, ",", ".");
        $dados["reajustamento"] = number_format($retorno[0]->reajustamento, 2, ",", ".");
        $dados["valor_total"] = number_format($retorno[0]->valor_total, 2, ",", ".");
        $dados["total_medido"] = number_format($retorno[0]->total_medido, 2, ",", ".");
        $dados["total_medido_piar"] = number_format($retorno[0]->total_medido_piar, 2, ",", ".");
        $dados["valor_medir"] = number_format($retorno[0]->valor_total - $retorno[0]->total_medido_piar, 2, ",", ".");
        $dados["total_empenhado"] = number_format($retorno[0]->total_empenhado, 2, ",", ".");
        $dados["saldo_empenhado"] = number_format($retorno[0]->saldo_empenhado, 2, ",", ".");
        $dados["a_empenhar"] = number_format($retorno[0]->valor_total - $retorno[0]->total_empenhado, 2, ",", ".");

        $dados['cal_valor_pi'] = (float)$retorno[0]->valor_pi;
        $dados['cal_aditivos'] = (float)$retorno[0]->aditivos;
        $dados['cal_reajustamento'] = (float)$retorno[0]->reajustamento;
        $dados['cal_valor_total'] = (float)$retorno[0]->valor_total;

        echo(json_encode($dados));
    }

    public function gerencialObraAditivos(){
        $dados["idContrato"] = $this->input->post_get("id_contrato_obra");
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["roteiro"] = "18";

        $Dados = $this->Tb_apresentacao_construtora_aditivo->Tableaditivo($dados);
        $retorno["data"] = Array();

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
                $descricao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick ='modalObjetoMotivacaoAditivo(".$lista->id_termo_aditivo.")'><i class = 'fa fa-eye'></i></button >";
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

    public function gerencialObraResumoFinanceiroGrafico()
    {
        $dados["idContrato"] = $this->input->post_get("id_contrato_obra");
        $retorno = $this->Tb_contrato_obra->RecuperaGerencialObraFinanceiro($dados);

        if (count($retorno) > 0) {
            $total = number_format($retorno[0]->valor_total, 2, ".", "");
            $aEmpenhar = number_format($retorno[0]->total_empenhado, 2, ".", "");
            $dados['empenhado'] = (float)number_format(($aEmpenhar * 100) / $total, 2, ".", "");

            $medido = number_format($retorno[0]->total_medido_piar, 2, ".", "");
            $dados['medido'] = (float)number_format(($medido * 100) / $total, 2, ".", "");

            $medir = number_format($retorno[0]->valor_total - $retorno[0]->total_medido_piar, 2, ".", "");
            $dados['medir'] = (float)number_format(($medir * 100) / $total, 2, ".", "");
        } else {
            $dados['empenhado'] = 0;
            $dados['medido'] = 0;
            $dados['medir'] = 0;
        }

        echo(json_encode($dados));
    }


    public function gerencialObraResumoCurvaSGrafico()
    {
        $dados["id_contrato_obra"] = $this->input->post_get("id_contrato_obra");
        $montarGrafico = $this->Tb_cronogramafinanceiro->buscadadosgrafico($dados);
        $j = 0;
        $Dados = array();
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

    public function gerencialObraResumoCurvaSIDFinGrafico(){
        $dados['id_contrato_obra'] = $this->input->post_get("id_contrato_obra");
        $acompanhamentofinanceirov = $this->Tb_cronogramafinanceiro->acompanhamentofinanceiro($dados);
        $anoacompanhemtofinanceiro = $this->Tb_cronogramafinanceiro->anoacompanhentofinanceiro($dados);

        $acumuladoMensal = 0;
        $acumuladoConcluido = 0;
        $acumuladoTotal = 0;
        if(!empty($anoacompanhemtofinanceiro)){
            foreach ($acompanhamentofinanceirov as $acompanhamentofisico_key) {
                if($acompanhamentofisico_key->ano === $anoacompanhemtofinanceiro[(count($anoacompanhemtofinanceiro) - 1)]->ano){
                    for($mes = 01; $mes <= 12; $mes++) {
                        $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                        $dados = get_object_vars($acompanhamentofisico_key);
                        $mensal = 'previsto_' . $mes;
                        $concluido = 'concluido_' . $mes;

                        $acumuladoMensal = $acumuladoMensal + $dados[$mensal];
                        $acumuladoConcluido = $acumuladoConcluido + $dados[$concluido];
                        $acumuladoTotal = $acumuladoTotal + round(@($acumuladoConcluido / $acumuladoMensal),2);
                        $ultimoMes = ($acumuladoMensal > 0 && $acumuladoConcluido > 0) ? round($acumuladoConcluido / $acumuladoMensal,2) : 0;
                    }
                }
            }
        }

        echo(json_encode($ultimoMes));
    }
//------------------------------------------------------------------------------

    public function RecuperaGrafIdfin() {
        
        $ano= date("Y");
        $mes= date("m");
        $periodo=($ano.'-'.$mes.'-01');
        $dados["periodo"]= $periodo;
        $dados["idContrato"] = $this->session->idContrato;

        $DadosIdfin = $this->Tb_contrato_obra->RecuperaIdfin($dados);

        foreach ($DadosIdfin as $lista) {
            $dados ['indice'] = $lista->IDFIN;
        }


        echo (json_encode($dados));
    }
#------------------------------------------------------------------------------#
//------------------------------------------------------------------------------
public function TablePainelEmpenhos() {
        $dados["idContrato"] = $this->session->idContrato;

        $DadosEmpenhos = $this->Tb_contrato_obra->RecuperaEmpenhos($dados);

        $dados["data"] = array();
        foreach ($DadosEmpenhos as $lista) {
            $dados['data'][] = array(
                'NOTA' => $lista->nota_empenho,
                'EMISSAO' => $lista->data_emissao_empenho,
                'INICIAL' => number_format($lista->valor_empenho_inicial, 2, ',', '.'),
                'AJUSTE' => number_format($lista->valor_empenho_ajuste, 2, ',', '.'),
                'CONSUMIDO' => number_format($lista->valor_empenho_consumido, 2, ',', '.'),
                'SALDO' => number_format($lista->valor_empenho_saldo, 2, ',', '.')
            );
        }

        echo (json_encode($dados));
    }
public function TablePainelEmpenhosSupervisora() {
        $dados["idContrato"] = $this->session->idContrato;
        $DadosSupervisora = $this->Tb_contrato_obra->RecuperaDadosSupervisora($dados);
        foreach ($DadosSupervisora as $lista) {
            $dados["nu_con_formatado_supervisor"]=$lista->nu_con_formatado_supervisor;
            
        }    
        $DadosEmpenhos = $this->Tb_contrato_obra->RecuperaEmpenhosSupervisora($dados);

        $dados["data"] = array();
        foreach ($DadosEmpenhos as $lista) {
            $dados['data'][] = array(
                'NOTA' => $lista->nota_empenho,
                'EMISSAO' => $lista->data_emissao_empenho,
                'INICIAL' => number_format($lista->valor_empenho_inicial, 2, ',', '.'),
                'AJUSTE' => number_format($lista->valor_empenho_ajuste, 2, ',', '.'),
                'CONSUMIDO' => number_format($lista->valor_empenho_consumido, 2, ',', '.'),
                'SALDO' => number_format($lista->valor_empenho_saldo, 2, ',', '.')
            );
        }

        echo (json_encode($dados));
    }    
public function TablePainelEmpenhosSoma() {
        $dados["idContrato"] = $this->session->idContrato;

        $DadosEmpenhos = $this->Tb_contrato_obra->RecuperaEmpenhosSoma($dados);

        $dados["data"] = array();
        foreach ($DadosEmpenhos as $lista) {
            $dados ['somavalor_empenho_inicial'] = number_format($lista->somavalor_empenho_inicial, 2, ',', '.');   
            $dados ['somavalor_empenho_ajuste'] = number_format($lista->somavalor_empenho_ajuste, 2, ',', '.');  
            $dados ['somavalor_empenho_consumido'] = number_format($lista->somavalor_empenho_consumido, 2, ',', '.');  
            $dados ['somavalor_empenho_saldo'] = number_format($lista->somavalor_empenho_saldo, 2, ',', '.');  
        }

        echo (json_encode($dados));
    }
public function TablePainelEmpenhosSomaSupervisora() {
        $dados["idContrato"] = $this->session->idContrato;
        $DadosSupervisora = $this->Tb_contrato_obra->RecuperaDadosSupervisora($dados);
        foreach ($DadosSupervisora as $lista) {
            $dados["nu_con_formatado_supervisor"]=$lista->nu_con_formatado_supervisor;
            
        }   
          
        $DadosEmpenhos = $this->Tb_contrato_obra->RecuperaEmpenhosSomaSupervisora($dados);

        $dados["data"] = array();
        foreach ($DadosEmpenhos as $lista) {
            $dados ['somavalor_empenho_inicial'] = number_format($lista->somavalor_empenho_inicial, 2, ',', '.');   
            $dados ['somavalor_empenho_ajuste'] = number_format($lista->somavalor_empenho_ajuste, 2, ',', '.');  
            $dados ['somavalor_empenho_consumido'] = number_format($lista->somavalor_empenho_consumido, 2, ',', '.');  
            $dados ['somavalor_empenho_saldo'] = number_format($lista->somavalor_empenho_saldo, 2, ',', '.');  
        }

        echo (json_encode($dados));
    }    
    public function TablePainelMedicoes() {
        $dados["idContrato"] = $this->session->idContrato;

        $DadosMedicoes = $this->Tb_contrato_obra->RecuperaMedicoes($dados);

        $dados["data"] = array();
        foreach ($DadosMedicoes as $lista) {
            $dados['data'][] = array(
                'N_MEDICAO' => $lista->nume_medicao,
                'PROCESSAMENTO' => $lista->data_processamento_medicao,
                'TERMINO' => $lista->data_termino_medicao,
                'VALOR_PI' => number_format($lista->valor_pi_medicao, 2, ',', '.'),
                'VALOR_REAJUSTE' => number_format($lista->valor_reajuste_medicao, 2, ',', '.'),
                'TOTAL' => number_format(($lista->valor_pi_medicao + $lista->valor_reajuste_medicao), 2, ',', '.')
            );
        }

        echo (json_encode($dados));
    } 
    public function TablePainelMedicoesSupervisora() {
        $dados["idContrato"] = $this->session->idContrato;
        $DadosSupervisora = $this->Tb_contrato_obra->RecuperaDadosSupervisora($dados);
        foreach ($DadosSupervisora as $lista) {
            $dados["nu_con_formatado_supervisor"]=$lista->nu_con_formatado_supervisor;
            
        }
        $DadosMedicoes = $this->Tb_contrato_obra->RecuperaMedicoesSupervisora($dados);

        $dados["data"] = array();
        foreach ($DadosMedicoes as $lista) {
            $dados['data'][] = array(
                'N_MEDICAO' => $lista->nume_medicao,
                'PROCESSAMENTO' => $lista->data_processamento_medicao,
                'TERMINO' => $lista->data_termino_medicao,
                'VALOR_PI' => number_format($lista->valor_pi_medicao, 2, ',', '.'),
                'VALOR_REAJUSTE' => number_format($lista->valor_reajuste_medicao, 2, ',', '.'),
                'TOTAL' => number_format(($lista->valor_pi_medicao + $lista->valor_reajuste_medicao), 2, ',', '.')
            );
        }

        echo (json_encode($dados));
    } 
    public function TablePainelRap() {
        $dados["idContrato"] = $this->session->idContrato;

        $DadosRap = $this->Tb_contrato_obra->RecuperaRap($dados);

        $dados["data"] = array();
        foreach ($DadosRap as $lista) {
            $dados['data'][] = array(
                'NOTA' => $lista->nota_empenho,
                'EMISSAO' => $lista->data_emissao_empenho,
                'INICIAL' => number_format($lista->valor_empenho_inicial, 2, ',', '.'),
                'AJUSTE' => number_format($lista->valor_empenho_ajuste, 2, ',', '.'),
                'CONSUMIDO' => number_format($lista->valor_empenho_consumido, 2, ',', '.'),
                'SALDO' => number_format($lista->valor_empenho_saldo, 2, ',', '.')
            );
        }

        echo (json_encode($dados));
    }
    public function TablePainelRapSupervisora() {
        $dados["idContrato"] = $this->session->idContrato;
          $DadosSupervisora = $this->Tb_contrato_obra->RecuperaDadosSupervisora($dados);
        foreach ($DadosSupervisora as $lista) {
            $dados["nu_con_formatado_supervisor"]=$lista->nu_con_formatado_supervisor;
            
        }   
        $DadosRap = $this->Tb_contrato_obra->RecuperaRapSupervisora($dados);

        $dados["data"] = array();
        foreach ($DadosRap as $lista) {
            $dados['data'][] = array(
                'NOTA' => $lista->nota_empenho,
                'EMISSAO' => $lista->data_emissao_empenho,
                'INICIAL' => number_format($lista->valor_empenho_inicial, 2, ',', '.'),
                'AJUSTE' => number_format($lista->valor_empenho_ajuste, 2, ',', '.'),
                'CONSUMIDO' => number_format($lista->valor_empenho_consumido, 2, ',', '.'),
                'SALDO' => number_format($lista->valor_empenho_saldo, 2, ',', '.')
            );
        }

        echo (json_encode($dados));
    }
    public function TablePainelRapSoma() {
        $dados["idContrato"] = $this->session->idContrato;

        $DadosRap = $this->Tb_contrato_obra->RecuperaRapSoma($dados);

        $dados["data"] = array();
        foreach ($DadosRap as $lista) {
            $dados ['somarap_valor_empenho_inicial'] = number_format($lista->somarap_valor_empenho_inicial, 2, ',', '.');   
            $dados ['somarap_valor_empenho_ajuste'] = number_format($lista->somarap_valor_empenho_ajuste, 2, ',', '.');  
            $dados ['somarap_valor_empenho_consumido'] = number_format($lista->somarap_valor_empenho_consumido, 2, ',', '.');  
            $dados ['somarap_valor_empenho_saldo'] = number_format($lista->somarap_valor_empenho_saldo, 2, ',', '.');  
        }

        echo (json_encode($dados));
    }
    public function TablePainelRapSomaSupervisora() {
        $dados["idContrato"] = $this->session->idContrato;
         $DadosSupervisora = $this->Tb_contrato_obra->RecuperaDadosSupervisora($dados);
        foreach ($DadosSupervisora as $lista) {
            $dados["nu_con_formatado_supervisor"]=$lista->nu_con_formatado_supervisor;
            
        }      
        $DadosRap = $this->Tb_contrato_obra->RecuperaRapSomaSupervisora($dados);

        $dados["data"] = array();
        foreach ($DadosRap as $lista) {
            $dados ['somarap_valor_empenho_inicial'] = number_format($lista->somarap_valor_empenho_inicial, 2, ',', '.');   
            $dados ['somarap_valor_empenho_ajuste'] = number_format($lista->somarap_valor_empenho_ajuste, 2, ',', '.');  
            $dados ['somarap_valor_empenho_consumido'] = number_format($lista->somarap_valor_empenho_consumido, 2, ',', '.');  
            $dados ['somarap_valor_empenho_saldo'] = number_format($lista->somarap_valor_empenho_saldo, 2, ',', '.');  
        }

        echo (json_encode($dados));
    }
//------------------------------------------------------------------------------    

    public function gerencialObraResumoCurvaSMedicaoGrafico() {
        $dados["id_contrato_obra"] = $this->input->post_get("id_contrato_obra");

        $DadosMedicao = $this->Tb_avanco_financeiro->RecuperaMedicaopublicado($dados);

        $tabela = "<table class='tabela bordaCompleta deslocarEsquerda table80' style='width: 100%;'>";
        $tabela .= '<thead class="center fundoCinzaCabecalho">
						<tr>
							<th>Nº Medição</th>
							<th>Processamento Medição</th>
							<th>Término Medição</th>
							<th>Valor PI</th>
							<th>Valor Reajuste</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>';
        $retorno["data"] = Array();
        if (!empty($DadosMedicao)) {
            $linha = 1;
            foreach ($DadosMedicao as $lista) {
                $tabela .= '<tr>';
                $tabela .= '<td>'.$lista->numemedicao.'</td>';
                $tabela .= '<td>'.$lista->data_processamento_medicao.'</td>';
                $tabela .= '<td>'.$lista->data_termino_medicao.'</td>';
                $tabela .= '<td>R$ '.number_format($lista->valor_pi_medicao,2,",",".").'</td>';
                $tabela .= '<td>R$ '.number_format($lista->valor,2,",",".").'</td>';
                $tabela .= '<td>R$ '.number_format($lista->valor_pi_medicao+$lista->valor,2,",",".").'</td>';
                $tabela .= '</tr>';
            }
        }else{
            $tabela .= "<tr class='center'><div class='alert alert-danger' role='alert'>Medição - não cadastrada!</div></tr>";
        }
        $tabela .= '</tbody>
					</table>';

        echo json_encode($tabela);
    }
    public function gerencialObraResumoCurvaSTabelaFisico() {
        $dados['id_contrato_obra'] = $this->input->post_get("id_contrato_obra");
        $acpfisicoavancocronograma = $this->Tb_cronograma_fisico->acompanhementofisico($dados);
        $anoacompanhemtofisico = $this->Tb_cronograma_fisico->anoacompanhemtofisico($dados);

        $tabela = "<table class='tabela bordaCompleta deslocarEsquerda table80' style='width: 100%;'>";
        if (empty($anoacompanhemtofisico)) {
            $tabela .= "<tr class='center'><div class='alert alert-danger' role='alert'>ACOMPANHAMENTO FISICO - não cadastrado!</div></tr>";
        } else {
            foreach ($anoacompanhemtofisico as $anoacompanhemtofisico_key) {
                $tabela .= '<thead class="center fundoCinzaCabecalho">
					<tr>
						<td colspan="3">Canal de Navegação</td>                         
						<td colspan="12">ACOMPANHAMENTO FÍSICO</td>
						<td rowspan="2">TOTAL</td>
					</tr>
					<tr>
						<td >CÓD</td>
						<td colspan="2">OBRA/SERVIÇO</td>';
                for ($mes = 1; $mes <= 12; $mes++) {
                    $mostraMes = $this->verificaMes($mes);
                    $ano = date('Y');
                    $tabela .= '<td>' . $mostraMes . '/' . $anoacompanhemtofisico_key->ano . '</td>';
                }
                $tabela .= '</tr></thead>';
                foreach ($acpfisicoavancocronograma as $acompanhamentofisico_key) {
                    if ($acompanhamentofisico_key->ano === $anoacompanhemtofisico_key->ano) {

                        $servicoobraacompanhamento = $acompanhamentofisico_key->servico;
                        $unidademedida = $acompanhamentofisico_key->unidade_medida;

                        $tabela .= '<tbody>
							<tr>
								<td class="center" rowspan="2"><?=$j++?></td>
								<td rowspan="2"><b>' . $servicoobraacompanhamento . '</b></td>
								<td>
									<div>
										Previsto Mensal
									</div>
									<br>
									<div>
										Concluido Mensal
									</div>
									<hr>
									<div>
										Previsto Acumulado
									</div><br>
									<div>
										Realizado Acumulado
									</div>
								</td>';
                        $acumuladoMensal = 0;
                        $acumuladoConcluido = 0;
                        for ($mes = 01; $mes <= 12; $mes++) {
                            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                            $dados = get_object_vars($acompanhamentofisico_key);
                            $mensal = 'previsto_' . $mes;
                            $concluido = 'concluido_' . $mes;

                            $acumuladoMensal = $acumuladoMensal + $dados[$mensal];
                            $acumuladoConcluido = $acumuladoConcluido + $dados[$concluido];

                            $tabela .= '<td>';
                            $tabela .= '<div class="tagAzul">';
                            $tabela .= number_format($dados[$mensal], 2, ",", ".") . $unidademedida;
                            $tabela .= '</div><br>';
                            $tabela .= '<div class="tagVerdeClaro">';
                            $tabela .= number_format($dados[$concluido], 2, ",", ".") . $unidademedida;
                            $tabela .= '</div><hr>';
                            $tabela .= '<div class="tagAzul">';
                            $tabela .= number_format($acumuladoMensal, 2, ",", ".") . $unidademedida;
                            $tabela .= '</div><br>';
                            $tabela .= '<div class="tagVerdeClaro">';
                            $tabela .= number_format($acumuladoConcluido, 2, ",", ".") . $unidademedida;
                            $tabela .= '</div>';
                            $tabela .= '</td>';
                        }
                        $tabela .= '<td>';
                        $tabela .= '<div class="tagAzul">';
                        $tabela .= number_format($acumuladoMensal, 2, ",", ".") . $unidademedida;
                        $tabela .= '</div><br>';
                        $tabela .= '<div class="tagVerdeClaro">';
                        $tabela .= number_format($acumuladoConcluido, 2, ",", ".") . $unidademedida;
                        $tabela .= '</div><hr>';
                        $tabela .= '<div class="tagAzul">';
                        $tabela .= number_format($acumuladoMensal, 2, ",", ".") . $unidademedida;
                        $tabela .= '</div><br>';
                        $tabela .= '<div class="tagVerdeClaro">';
                        $tabela .= number_format($acumuladoConcluido, 2, ",", ".") . $unidademedida;
                        $tabela .= '</div>';
                        $tabela .= '</td>';
                        $tabela .= '</tr>';
                        $tabela .= '<tr>
                            <td>
                                <div>
                                    A Concluir
                                </div>
                            </td>';
                        $restanteconcluirAcumulado = 100;
                        for ($mes = 01; $mes <= 12; $mes++) {
                            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                            $dados = get_object_vars($acompanhamentofisico_key);
                            $mensal = 'previsto_' . $mes;
                            $concluido = 'concluido_' . $mes;

                            $tabela .= '<td>
								<div class="tagDefault">';
                            if ($dados[$concluido] >= $dados[$mensal]) {
                                $restanteconcluir = ($dados[$concluido] - $dados[$mensal]);
                            }
                            if ($dados[$mensal] >= $dados[$concluido]) {
                                $restanteconcluir = ($dados[$mensal] - $dados[$concluido]);
                            }
                            $tabela .= number_format($restanteconcluir, 2, ",", ".") . $unidademedida;
                            $tabela .= '</div>
								</td>';
                            $restanteconcluirAcumulado = $acumuladoMensal - $acumuladoConcluido;
                        }
                        $tabela .= '<td>
							<div class="nameDefault">' . number_format($restanteconcluirAcumulado, 2, ",", ".") . $unidademedida . '</div>
							</td>
						</tr>';

                        $tabela .= '<tr>';
                        $tabela .= '<td>
                                <div>
                                    
                                </div>
                            </td>
                             <td colspan="2">
                                <div>
                                    IDFis (Índice de Desempenho Físico)
                                </div>
                            </td>';
                        $acumuladoMensal = 0;
                        $acumuladoConcluido = 0;
                        $acumuladoTotal = 0;
                        for ($mes = 01; $mes <= 12; $mes++) {
                            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                            $dados = get_object_vars($acompanhamentofisico_key);
                            $mensal = 'previsto_' . $mes;
                            $concluido = 'concluido_' . $mes;

                            $acumuladoMensal = $acumuladoMensal + $dados[$mensal];
                            $acumuladoConcluido = $acumuladoConcluido + $dados[$concluido];
                            if ($acumuladoMensal > 0) {
                                $acumuladoTotal = $acumuladoTotal + round($acumuladoConcluido / $acumuladoMensal, 2);
                            } else {
                                $acumuladoTotal = 0;
                            }

                            $tabela .= '<td>';
                            $tabela .= ($acumuladoMensal > 0 && $acumuladoConcluido > 0) ? round($acumuladoConcluido / $acumuladoMensal, 2) : 0;
                            $tabela .= '</td>';
                        }
                        $tabela .= '<td>';
                        $tabela .= round($acumuladoTotal, 2);
                        $tabela .= '</td>';
                        $tabela .= '</tr>';
                    }
                }
            }
            $tabela .= '</table>';
        }

        echo json_encode($tabela);
    }

    public function gerencialObraResumoCurvaSTabelaFisico_old_24112021_1022(){ 
        $dados['id_contrato_obra'] = $this->input->post_get("id_contrato_obra");
        $acpfisicoavancocronograma = $this->Tb_cronograma_fisico->acompanhementofisico($dados);
        $anoacompanhemtofisico = $this->Tb_cronograma_fisico->anoacompanhemtofisico($dados);

        $tabela = "<table class='tabela bordaCompleta deslocarEsquerda table80' style='width: 100%;'>";
        if(empty($anoacompanhemtofisico)){
            $tabela .= "<tr class='center'><div class='alert alert-danger' role='alert'>ACOMPANHAMENTO FISICO - não cadastrado!</div></tr>";
        }else{
            foreach ($anoacompanhemtofisico as $anoacompanhemtofisico_key){ 
                $tabela .= '<thead class="center fundoCinzaCabecalho">
					<tr>
						<td colspan="3">Canal de Navegação</td>                         
						<td colspan="12">ACOMPANHAMENTO FÍSICO</td>
						<td rowspan="2">TOTAL</td>
					</tr>
					<tr>
						<td >CÓD</td>
						<td colspan="2">OBRA/SERVIÇO</td>';
                for($mes = 1; $mes <= 12; $mes++) {
                    $mostraMes = $this->verificaMes($mes);
                    $ano = date('Y');
                    $tabela .= '<td>'.$mostraMes.'/'.$anoacompanhemtofisico_key->ano.'</td>';
                }
                $tabela .= '</tr></thead>';
                foreach ($acpfisicoavancocronograma as $acompanhamentofisico_key) {
                   
                    if($acompanhamentofisico_key->ano === $anoacompanhemtofisico_key->ano){
                       
                        $servicoobraacompanhamento = $acompanhamentofisico_key->servico;
                        $unidademedida= $acompanhamentofisico_key->unidade_medida;

                        $tabela .= '<tbody>
							<tr>
								<td class="center" rowspan="2"><?=$j++?></td>
								<td rowspan="2"><b>'.$servicoobraacompanhamento.'</b></td>
								<td>
									<div>
										Previsto Mensal
									</div>
									<br>
									<div>
										Concluido Mensal
									</div>
									<hr>
									<div>
										Previsto Acumulado
									</div><br>
									<div>
										Realizado Acumulado
									</div>
								</td>';
                        $acumuladoMensal = 0;
                        $acumuladoConcluido = 0;
                        for($mes = 01; $mes <= 12; $mes++) {
                            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                            $dados = get_object_vars($acompanhamentofisico_key);
                            $mensal = 'previsto_'.$mes;
                            $concluido = 'concluido_'.$mes;

                            $acumuladoMensal = $acumuladoMensal + $dados[$mensal];
                            $acumuladoConcluido = $acumuladoConcluido + $dados[$concluido];

                            $tabela .= '<td>';
                            $tabela .= '<div class="tagAzul">';
                            $tabela .= number_format($dados[$mensal],2,",",".").$unidademedida;
                            $tabela .= '</div><br>';
                            $tabela .= '<div class="tagVerdeClaro">';
                            $tabela .= number_format($dados[$concluido],2,",",".").$unidademedida;
                            $tabela .= '</div><hr>';
                            $tabela .= '<div class="tagAzul">';
                            $tabela .= number_format($acumuladoMensal,2,",",".").$unidademedida;
                            $tabela .= '</div><br>';
                            $tabela .= '<div class="tagVerdeClaro">';
                            $tabela .= number_format($acumuladoConcluido,2,",",".").$unidademedida;
                            $tabela .= '</div>';
                            $tabela .= '</td>';
                        }
                        $tabela .= '<td>';
                        $tabela .= '<div class="tagAzul">';
                        $tabela .= number_format($acumuladoMensal,2,",",".").$unidademedida;
                        $tabela .= '</div><br>';
                        $tabela .= '<div class="tagVerdeClaro">';
                        $tabela .= number_format($acumuladoConcluido,2,",",".").$unidademedida;
                        $tabela .= '</div><hr>';
                        $tabela .= '<div class="tagAzul">';
                        $tabela .= number_format($acumuladoMensal,2,",",".").$unidademedida;
                        $tabela .= '</div><br>';
                        $tabela .= '<div class="tagVerdeClaro">';
                        $tabela .= number_format($acumuladoConcluido,2,",",".").$unidademedida;
                        $tabela .= '</div>';
                        $tabela .= '</td>';
                        $tabela .= '</tr>';
                        $tabela .= '<tr>
                            <td>
                                <div>
                                    A Concluir
                                </div>
                            </td>';
                        $restanteconcluirAcumulado = 100;
                        for($mes = 01; $mes <= 12; $mes++) {
                            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                            $dados = get_object_vars($acompanhamentofisico_key);
                            $mensal = 'previsto_' . $mes;
                            $concluido = 'concluido_' . $mes;

                            $tabela .= '<td>
								<div class="tagDefault">';
                            if($dados[$concluido] >= $dados[$mensal]){
                                $restanteconcluir = ($dados[$concluido] - $dados[$mensal]);
                            }
                            if($dados[$mensal] >= $dados[$concluido]){
                                $restanteconcluir = ($dados[$mensal] - $dados[$concluido]);
                            }
                            $tabela .= number_format($restanteconcluir,2,",",".").$unidademedida;
                            $tabela .= '</div>
								</td>';
                            $restanteconcluirAcumulado = $acumuladoMensal - $acumuladoConcluido;
                        }
                        $tabela .= '<td>
							<div class="nameDefault">'.number_format($restanteconcluirAcumulado,2,",",".").$unidademedida.'</div>
							</td>
						</tr>';

                        $tabela .= '<tr>';
                        $tabela .= '<td>
                                <div>
                                    
                                </div>
                            </td>
                             <td colspan="2">
                                <div>
                                    IDFis (Índice de Desempenho Físico)
                                </div>
                            </td>';
                        $acumuladoMensal = 0;
                        $acumuladoConcluido = 0;
                        $acumuladoTotal = 0;
                        for($mes = 01; $mes <= 12; $mes++) {
                            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                            $dados = get_object_vars($acompanhamentofisico_key);
                            $mensal = 'previsto_' . $mes;
                            $concluido = 'concluido_' . $mes;

                            $acumuladoMensal = $acumuladoMensal + $dados[$mensal];
                            $acumuladoConcluido = $acumuladoConcluido + $dados[$concluido];
                            if($acumuladoMensal > 0 ){
                            $acumuladoTotal = $acumuladoTotal + round($acumuladoConcluido / $acumuladoMensal,2);
                            }else{
                             $acumuladoTotal=0;   
                            }

                            $tabela .= '<td>';
                            $tabela .= ($acumuladoMensal > 0 && $acumuladoConcluido > 0) ? round($acumuladoConcluido / $acumuladoMensal,2) : 0;
                            $tabela .= '</td>';
                        }
                        $tabela .= '<td>';
                        $tabela .= round($acumuladoTotal,2);
                        $tabela .= '</td>';
                        $tabela .= '</tr>';
                        $tabela .= '</table>';
                    }
                }
            }
        }
        
        echo json_encode($tabela);
    }

    public function gerencialObraResumoCurvaSTabelaFinanceiro(){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $dados['id_contrato_obra'] = $this->input->post_get("id_contrato_obra");

        $DadosContratoObra = $this->Tb_relatorio->DadosContratoDaq($dados);
        $DadosRecibo['Valor_Inicial_Adit_Reajustes']  = number_format($DadosContratoObra[0]["Valor_Inicial_Adit_Reajustes"],2,",",".");
        $anoacompanhemtofinanceiro = $this->Tb_cronogramafinanceiro->anoacompanhentofinanceiro($dados);
        $acpfinanceiroavancocronograma = $this->Tb_cronogramafinanceiro->acompanhamentofinanceiro($dados);
        $acompanhamentofinanceirov = $this->Tb_cronogramafinanceiro->acompanhamentofinanceirov($dados);

        $tabela = '';
        $tabela .= '<table class="tabela bordaCompleta deslocarEsquerda table80" style="width: 100%;">';

        $j=1;
        if(empty($anoacompanhemtofinanceiro)){
            $tabela .= '<tr class="center">
				<div class="alert alert-danger" role="alert">ACOMPANHAMENTO FINANCEIRO - não cadastrado!</div>
			</tr>';
        }else {
            if (!empty($anoacompanhemtofinanceiro)) {
                foreach ($anoacompanhemtofinanceiro as $anoacompanhentofinanceiro_key) {
                    $tabela .= '<table class="tabela bordaCompleta deslocarEsquerda table80" style="width: 100%;">
									<thead class="center fundoCinzaCabecalho">
										<tr>
											<td colspan="3">VALOR TOTAL VIGENTE(PI+A) R$ '.$DadosRecibo['Valor_Inicial_Adit_Reajustes'].'</td>                         
											<td colspan="12">CRONOGRAMA FINANCEIRO (em milhares de reais)</td>
											<td rowspan="2">TOTAL(R$)</td>
										</tr>';
                    $tabela .= '<tr>
									<td>CÓD</td>
									<td colspan="2">OBRA/SERVIÇO</td>';
                    for($mes = 1; $mes <= 12; $mes++) {
                        $mostraMes = $this->verificaMes($mes);
                        $ano = date('Y');
                        $tabela .= '<td>'.$mostraMes.'/'.$anoacompanhentofinanceiro_key->ano.'</td>';
                    }
                    $tabela .= '</tr>
						</thead>
				 	<tbody>';
                    foreach ($acpfinanceiroavancocronograma as $acompanhamentofisico_key) {
                        if ($acompanhamentofisico_key->ano === $anoacompanhentofinanceiro_key->ano) {
                            $unidademedida = '';
                            $servicoobraacompanhamento= $acompanhamentofisico_key->servico;

                            $tabela .= '<tr>
											<td class="center" rowspan="1">'.$j++.'</td>
											<td rowspan="1"><b>'.$servicoobraacompanhamento.'</b></td>
											<td>
												<div>
													Previsto Mensal
												</div>
												<br>
												<div>
													Concluido Mensal
												</div>
												<hr>
												<div>
													Previsto Acumulado
												</div><br>
												<div>
													Realizado Acumulado
												</div>
											</td>';
                            $acumuladoMensal = 0;
                            $acumuladoConcluido = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'previsto_'.$mes;
                                $concluido = 'concluido_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];
                                $acumuladoConcluido = $acumuladoConcluido + $dados[$concluido];

                                $tabela .= '<td>';
                                $tabela .= '<div class="tagAzul">';
                                $tabela .= number_format($dados[$mensal],2,",",".").$unidademedida;
                                $tabela .= '</div><br>';
                                $tabela .= '<div class="tagVerdeClaro">';
                                $tabela .= number_format($dados[$concluido],2,",",".").$unidademedida;
                                $tabela .= '</div><hr>';
                                $tabela .= '<div class="tagAzul">';
                                $tabela .= number_format($acumuladoMensal,2,",",".").$unidademedida;
                                $tabela .= '</div><br>';
                                $tabela .= '<div class="tagVerdeClaro">';
                                $tabela .= number_format($acumuladoConcluido,2,",",".").$unidademedida;
                                $tabela .= '</div>';
                                $tabela .= '</td>';
                            }
                            $tabela .= '<td>';
                            $tabela .= '<div class="tagAzul">';
                            $tabela .= number_format($acumuladoMensal,2,",",".").$unidademedida;
                            $tabela .= '</div><br>';
                            $tabela .= '<div class="tagVerdeClaro">';
                            $tabela .= number_format($acumuladoConcluido,2,",",".").$unidademedida;
                            $tabela .= '</div><hr>';
                            $tabela .= '<div class="tagAzul">';
                            $tabela .= number_format($acumuladoMensal,2,",",".").$unidademedida;
                            $tabela .= '</div><br>';
                            $tabela .= '<div class="tagVerdeClaro">';
                            $tabela .= number_format($acumuladoConcluido,2,",",".").$unidademedida;
                            $tabela .= '</div>';
                            $tabela .= '</td>';
                            $tabela .= '</tr>';
                            $tabela .= '<tr>';
                        }
                    }
                    foreach ($acompanhamentofinanceirov as $acompanhamentofisico_key) {
                        if($acompanhamentofisico_key->ano===$anoacompanhentofinanceiro_key->ano) {
//							$breakrealizado = $mes;

                            $tabela .= '<tr>
											<td rowspan="9" style ="transform: rotate(270deg)" >SERVIÇOS CONSOLIDADOS</td>               
											<td rowspan="4">
												<div>
													Valor Previsto Mensal
												</div><br>
												<div>
													Valor Executado Mensal
												</div><br>
												<div>
													Valor Previsto Acumulado
												</div><br>
												<div>
													Valor Exec. Acumulado
												</div>
											</td>';
                            $tabela .= '<td rowspan="4">(R$ em milhares)</td>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'previsto_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($dados[$mensal]).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';

                            $tabela .= '<tr>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'executado_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($dados[$mensal]).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';

                            $tabela .= '<tr>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'previsto_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';

                            $tabela .= '<tr>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'executado_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($dados[$mensal]).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';
                            // -------------------------- PORCENTAGEM --------------------------------------
                            $tabela .= '<tr>
											<td rowspan="4">
												<div>
													Percent. Previsto 
												</div><br>
												<div>
													Percent. Executado 
												</div><br>
												<div>
													Percent. Previsto Acumulado
												</div><br>
												<div>
													Percent. Exec. Acumulado
												</div>
											</td>';
                            $tabela .= '<td rowspan="4">%</td>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'percentprev_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($dados[$mensal]).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';

                            $tabela .= '<tr>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'percentex_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($dados[$mensal]).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';

                            $tabela .= '<tr>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'percentprev_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';

                            $tabela .= '<tr>';
                            $acumuladoMensal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'percentex_'.$mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];

                                $tabela .= '<td>'.intval($dados[$mensal]).'</td>';
                            }
                            $tabela .= '<td>'.intval($acumuladoMensal).'</td>';
                            $tabela .= '</tr>';
//							------------------------------------ IDFIN --------------------------------------
                            $tabela .= '<tr>
											<td rowspan="4">
												<div>
													IDFin (Índice de Desempenho Financeiro)
												</div><br>
											   
											</td>';
                            $tabela .= '<td rowspan="4"></td>';
                            $acumuladoMensal = 0;
                            $acumuladoConcluido = 0;
                            $acumuladoTotal = 0;
                            for($mes = 01; $mes <= 12; $mes++) {
                                $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
                                $dados = get_object_vars($acompanhamentofisico_key);
                                $mensal = 'previsto_' . $mes;
                                $concluido = 'executado_' . $mes;

                                $acumuladoMensal = $acumuladoMensal + $dados[$mensal];
                                $acumuladoConcluido = $acumuladoConcluido + $dados[$concluido];
                                $acumuladoTotal = $acumuladoTotal + round(@($acumuladoConcluido / $acumuladoMensal),2);

                                $tabela .= '<td>';
                                $tabela .= ($acumuladoMensal > 0 && $acumuladoConcluido > 0) ? round($acumuladoConcluido / $acumuladoMensal,2) : 0;
                                $tabela .= '</td>';
                            }
                            $tabela .= '<td>';
                            $tabela .= round($acumuladoTotal,2);
                            $tabela .= '</td>';
                            $tabela .= '</tr>';
                        }
                    }
                }
            }
        }
        $tabela .= '</table>';

        echo json_encode($tabela);
    }

    public function gerencialObraAmbiental(){
        $dados['idContrato'] = $this->input->post_get("id_contrato_obra");
        $LicencasAmbientais = $this->Tb_licencas_ambientais->recuperaLicencasAmbientais($dados);

        $tabela = '';
        $tabela .= '<table class="tabela bordaCompleta" style="width: 100%;">
                <tbody>';
        if(empty($LicencasAmbientais)){
            $tabela .= '<tr class="center">
							<div class="alert alert-danger" role="alert">MONITORAMENTO AMBIENTAL - não cadastrado!</div>   
						</tr>';
        }else{
            $tabela .= '<thead class="center fundoCinzaCabecalho">
                            <tr>
                                <td colspan="8">LICENÇAS AMBIENTAIS VIGENTES</td>
                            </tr>
                            <tr>
                                <td>Nº</td>
                                <td>Tipo</td>
                                <td>Órgão Emissor</td>
                                <td>Data Emissão</td>
                                <td>Vigência</td>
                                <td>Resumo</td>
                                <td>Condicionantes</td>
                            </tr>       

                        </thead>';
            foreach ($LicencasAmbientais as $key) {
                $LICENCAVIGENTE =$key->licenca;
                $TIPOVIGENTE =$key->tipo;
                $EMISSORVIGENTE =$key->orgao_emissor;
                $DATAVIGENTE =$key->data_emissao;
                $TERMINOVIGENTE=$key->termino_vigencia;
                $VIGENCIA=$key->vigencia;
                $REUMOAMBIENTAL=$key->resumo;
                $CONDICIONANTEVIGENTE=$key->condicionantes_ambientais;
                $tabela .= '<tr>
							<td>'.$LICENCAVIGENTE.'</td>
							<td>'.$TIPOVIGENTE.'</td>
							<td>'.$EMISSORVIGENTE.'</td>   
							<td>'.$DATAVIGENTE.'</td>
							<td>'.$VIGENCIA.'</td>   
							<td>'.$REUMOAMBIENTAL.'</td>
							<td>'.$CONDICIONANTEVIGENTE.'</td>                        
						</tr>';
            }
        }
        $tabela .= '</tbody>
                </table>';

        echo json_encode($tabela);
    }


    public function gerencialObraInterferencias(){
        $dados['idContrato'] = $this->input->post_get("id_contrato_obra");
        $riscosInterferencias = $this->Tb_relatorio->RiscosInterferencias($dados);

        $tabela = '<table class="tabela bordaCompleta" style="width: 100%">
                    <tbody>';
        if(empty($riscosInterferencias)){
            $tabela .= '<tr class="center">
							<div class="alert alert-danger" role="alert">GESTÃO DE RISCOS E INTERFERÊNCIAS - Não houve atividade no mês</div>  
						</tr>';
        } else {
            $tabela .= '<thead class="fundoCinzaCabecalho">
							<tr class="center">
								<td>Tipo</td>   
								<td>Classificação</td>  
								<td>Descrição</td>  
								<td>Km Inicial</td> 
								<td>Km Final</td>   
								<td>Grau de Impacto</td>    
								<td>Previsão de Solução</td>    
								<td>Data Limite</td>    
								<td>Impacto em custo?</td>                          
								<td>Impacto em prazo?</td>  
							</tr>
						</thead>';
            foreach ($riscosInterferencias as $key) {
                $custo = ($key->impacto_custo === 1) ? "Sim" : "Não";
                $prazo = ($key->impacto_prazo === 1) ? "Sim" : "Não";
                $tabela .= '<tr class="center">
								<td>'.$key->desc_tipo.'</td>
								<td>'.$key->desc_classificacao.'</td>
								<td>'.$key->resumo.'</td>
								<td>'.$key->km_inicial.'</td>
								<td>'.$key->km_final.'</td>
								<td>'.$key->desc_grau_impacto.'</td>
								<td>'.$key->previsao_solucao.'</td>
								<td>'.$key->data_limite.'</td>
								<td>'.$custo.'</td>
								<td>'.$prazo.'</td>
							</tr>';
            }
        }
        $tabela .= '</tbody>
                    </table>';

        echo json_encode($tabela);
    }

    public function verificaMes($mes, $abrev = 'S'){
        switch ($mes){
            case 1:
                $mes = 'Jan';
                $mesCompleto = 'Janeiro';
                break;
            case 2:
                $mes = 'Fev';
                $mesCompleto = 'Fevereiro';
                break;
            case 3:
                $mes = 'Mar';
                $mesCompleto = 'Março';
                break;
            case 4:
                $mes = 'Abr';
                $mesCompleto = 'Abril';
                break;
            case 5:
                $mes = 'Mai';
                $mesCompleto = 'Maio';
                break;
            case 6:
                $mes = 'Jun';
                $mesCompleto = 'Junho';
                break;
            case 7:
                $mes = 'Jul';
                $mesCompleto = 'Julho';
                break;
            case 8:
                $mes = 'Ago';
                $mesCompleto = 'Agosto';
                break;
            case 9:
                $mes = 'Set';
                $mesCompleto = 'Setembro';
                break;
            case 10:
                $mes = 'Out';
                $mesCompleto = 'Outubro';
                break;
            case 11:
                $mes = 'Nov';
                $mesCompleto = 'Novembro';
                break;
            case 12:
                $mes = 'Dez';
                $mesCompleto = 'Dezembro';
                break;
        }

		$retorno = ($abrev == 'S') ? $mes : $mesCompleto;
        return $retorno;
    }

    public function gerencialObraHidrovia(){
		$dados["idContrato"] = $this->input->post_get("id_contrato_obra");
		$dados["id_contrato_obra"] = $this->input->post_get("id_contrato_obra");
		$dados["periodo"] = $this->input->post_get("periodo");

		$Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
		$dados["versao"] = 0;
		if (!empty($Versao)) {
			foreach ($Versao as $lista) {
				$dados["versao"] = $lista->versao;
			}
		}
        $DadosInicio = $this->Tb_dados_contrato->adicionaDadosInicio($dados);
        $retorno = '';
        foreach ($DadosInicio as $lista) {
            $retorno .= '<div class=\'row align-items-center\'>
                <div class=\'col-xs-4 col-sm-4 col-md-2 col-lg-2\'>
                <small class=\'progress-title\'><b>'.$lista->nome_obra .' - '. $lista->nome_servico .'</b></small>
                </div>
                <div class=\'col-xs-4 col-sm-4 col-md-8 col-lg-8\'>
                    <div class=\'progress progress-sm active\'>
                        <div class=\'progress-bar bg-primary progress-bar-striped\' role=\'progressbar\' aria-valuenow=\'.000000\' aria-valuemin=\'0\' aria-valuemax=\'100\' style=\'width: '.$lista->valor_cronograma .'%\'>
                           <span class=\'sr-only\'>'.$lista->valor_cronograma .'</span>
                        </div>
                    </div>
                </div>
                <div class=\'col-xs-4 col-sm-4 col-md-2 col-lg-2\'>
                    <small class=\'progress-number pull-right\'>'.$lista->atacado .''. $lista->unidade_medida .' </small>
                </div>
                </div>';
            $retorno .= '<br>';
        }
        echo (json_encode($retorno));
    }

	public function gerencialObraResumoCurvaSTabelaEmpenho(){
		$dados['id_contrato_obra'] = $this->input->post_get("id_contrato_obra");
		$dadosEmpenho = $this->Tb_cronogramafinanceiro->recuperaEmpenho($dados);

		$tabela = "<h2>Empenho</h2>";
		$tabela .= "<table class='tabela bordaCompleta deslocarEsquerda table80' style='width: 100%;'>";
		$tabela .= '<thead class="center fundoCinzaCabecalho">
					<tr>
						<th>Nota</th>
						<th>Emissão</th>
						<th>Inicial</th>
						<th>Ajuste</th>
						<th>Consumido</th>
						<th>Saldo</th>
					</tr>
				</thead>
				<tbody>';
		$retorno["data"] = Array();
		if (!empty($dadosEmpenho)) {
			foreach ($dadosEmpenho as $lista) {
				$countEmpenhos = 0;
				if(date( 'Y', strtotime($lista['DT_EMISSAO_EMPENHO']) ) >= date("Y")){
					$tabela .= '<tr>';
					$tabela .= '<td>'.$lista['NOTA_EMPENHO'].'</td>';
					$tabela .= '<td>'.$lista['DT_EMISSAO_EMPENHO'].'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_INICIAL'],2,",",".").'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_AJUSTES'],2,",",".").'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_CONSUMIDO'],2,",",".").'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_SALDO'],2,",",".").'</td>';
					$tabela .= '</tr>';
					$countEmpenhos++;
				}
			}
		}else{
			$tabela .= "<tr class='center'><div class='alert alert-danger' role='alert'>Empenho - não cadastrada!</div></tr>";
		}
		if($countEmpenhos == 0){
			$tabela .= "<tr class='center'><td colspan='6'> Nenhum Registro Encontrado </td></tr>";
		}
		$tabela .= '</tbody> </table>';


		$tabela .= "</br>";
		$tabela .= "<h2>RAP</h2>";
		$tabela .= "<table class='tabela bordaCompleta deslocarEsquerda table80' style='width: 100%;'>";
		$tabela .= '<thead class="center fundoCinzaCabecalho">
					<tr>
						<th>Nota</th>
						<th>Emissão</th>
						<th>Inicial</th>
						<th>Ajuste</th>
						<th>Consumido</th>
						<th>Saldo</th>
					</tr>
				</thead>
				<tbody>';
		$retorno["data"] = Array();
		if (!empty($dadosEmpenho)) {
			foreach ($dadosEmpenho as $lista) {
				$countRAP = 0;
				if(date( 'Y', strtotime($lista['DT_EMISSAO_EMPENHO']) ) < date("Y")){
					$tabela .= '<tr>';
					$tabela .= '<td>'.$lista['NOTA_EMPENHO'].'</td>';
					$tabela .= '<td>'.$lista['DT_EMISSAO_EMPENHO'].'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_INICIAL'],2,",",".").'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_AJUSTES'],2,",",".").'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_CONSUMIDO'],2,",",".").'</td>';
					$tabela .= '<td>'.number_format($lista['VLR_EMPENHO_SALDO'],2,",",".").'</td>';
					$tabela .= '</tr>';
					$countRAP++;
				}
			}
		}else{
			$tabela .= "<tr class='center'><div class='alert alert-danger' role='alert'>RAP - não cadastrada!</div></tr>";
		}
		if($countRAP == 0){
			$tabela .= "<tr class='center'><td colspan='6'> Nenhum Registro Encontrado </td></tr>";
		}
		$tabela .= '</tbody> </table>';

		echo json_encode($tabela);
	}

}//Fecha Classe
//######################################################################################################################################################################################################################## 
//# DNIT-Falconi AQUAVIARIO
//# Supervisaodaqctr.php
//# Desenvolvedora:Pedro Correia
//# Data: 18/01/2021
//########################################################################################################################################################################################################################
