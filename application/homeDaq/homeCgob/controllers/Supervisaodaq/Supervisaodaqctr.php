<?php
/*
 * Classe controller Supervisaodaqctr. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Supervisaodaqctr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_contrato_obra');
        $this->load->model('Tb_usuario');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
//----------------------------------------------------View------------------------------------------------------
    public function Tabelacontratoobra(){
      $this->load->view('/supervisaodaq/Tabelacontratoobra/TabelaContratoObraDaq');
    }
    public function InformacoesContrato(){
      $this->load->view('/supervisaodaq/informacaocontrato/InformacoesContratoView');
    }
    public function homeSupervisaoDaq() {
        $dadosusuario = $this->Tb_usuario->recuperaUsuarioSessao();
        
        foreach ($dadosusuario as $lista) {
                $dados["IdPerfil"] = $lista->id_perfil;
        }
        $this->load->view('/homeSupervisaoDaq',$dados);
    }
    public function homeRelatorioSupervisaoDaq() {
        $this->load->view('/supervisaodaq/relatorioSupervisao/RelatorioSupervisaoView');
    }  
    public function homedocumentaoDaq() {
        $this->load->view('/documentacao/homeDocumentacaoView');
    }
    public function homePainelAdm() {
        $this->load->view('/homePainelAdm');
    }
    public function homeDaq() {
        $this->load->view('/homeDaq');
    }
//-----------------------------------------------ConfiguracaoObra-----------------------------------------------
public function homeConfiguracaoObraDaq() {
    $this->load->view('/supervisaodaq/configuracaoobra/ConfiguracaoObraView');
}
    public function retornaConfiguracao(){
        $this->load->view('/supervisaodaq/configuracaoobra/ConfiguracaoObraView');
    }
    public function ArtDaq(){
        $this->load->view('/supervisaodaq/arte/ArtView');
    }
    public function PortariasFiscaisDaq(){
        $this->load->view('/supervisaodaq/portariafiscal/PortariasFiscaisView');
    }
    public function DiagramaPontoPassagemDaq(){
        $this->load->view('/supervisaodaq/diagramapassagem/DiagramaPontoPassagemView');
    }
    public function JustificativaEmpreendimentoDaq(){
        $this->load->view('/supervisaodaq/justificativa/JustificativaEmpreendimentoView');
    }
    public function DadosSegmentoDaq(){
        $this->load->view('/supervisaodaq/dadosegmento/DadosSegmentoView');
    }
    public function MapaSituacaoDaq(){
        $this->load->view('/supervisaodaq/mapasituacao/MapaSituacaoView');
    } 
    public function GeorreferenciamentoDaq(){
        $this->load->view('/supervisaodaq/georreferenciamento/GeorreferenciamentoView');
    } 
    public function PontopassagemDaq(){
        $this->load->view('/supervisaodaq/pontopassagem/PontoPassagemView');
    }   
    public function OcorrenciaProjetoDaq(){
        $this->load->view('/supervisaodaq/ocorrenciaprojeto/OcorrenciaProjetoView');
    }
//------------------------------------------------Cronograma-----------------------------------------------------
public function CronogramasDaq(){
    $this->load->view('/supervisaodaq/cronograma/CronogramasView');
}
    public function CronogramaFinanceiroObra(){
        $this->load->view('/supervisaodaq/cronogramafinanceiro/CronogramaFinanceiroObraView');
    }
    public function CronogramaFisico(){
        $this->load->view('/supervisaodaq/cronogramafisico/CronogramaFisicoView');
    }
//------------------------------------------------GestaoAmbiental------------------------------------------------
public function homeGestaoAmbientalDaq(){
    $this->load->view('/supervisaodaq/gestaoambiental/GestaoAmbientalView');
}
    public function homeLicencasAmbientaisDaq(){
        $this->load->view('/supervisaodaq/licencasambientais/LicencasAmbientaisView');
    }
    
    public function homePbaPaiDaq(){
        $this->load->view('/supervisaodaq/pbapbai/PbaPbaiView');
    }
//--------------------------------------------------PGQ----------------------------------------------------------
public function homePgqDaq(){
    $this->load->view('/supervisaodaq/pgqv/PGQView');
}
//--------------------------------------------------RELATORIO SUPERVISAO-----------------------------------------
public function homeHistoricoObraDaq(){
    $this->load->view('/supervisaodaq/historicoobra/HistoricoObraView');
}

public function homeIntroducaoDaq(){
    $this->load->view('/supervisaodaq/introducao/IntroducaoView');
}

public function homeResumoProjetoDaq(){
    $this->load->view('/supervisaodaq/resumoprojeto/ResumoProjetoView');
}

public function homeRpfoDaq(){
    $this->load->view('/supervisaodaq/rpfo/RpfoView');
}
    //---------------------------------------ATIVIDADE SUPERVISORA----------------------------------------------
    public function homeApresentacaoSupervisoraDaq(){
        $this->load->view('/supervisaodaq/apresentacaosupervisora/ApresentacaoSupervisoraView');
    }
    public function homeSicroDaq(){
        $this->load->view('/supervisaodaq/sicrosupervisao/SicroSupervisoraView');
    }
    public function homeRelacaoMobilizacaoDaq(){
        $this->load->view('/supervisaodaq/mobilizacaosupervisora/MobilizacaoSupervisoraView');
    }
    public function homeAtividadeSupervisoraDaq(){
        $this->load->view('/supervisaodaq/atividadesupervisora/AtividadeSupervisoraView');
    } 
    //---------------------------------------ATIVIDADE CONSTRUTORA---------------------------------------------- 
    public function homeApresentacaoConstrutoraDaq(){
        $this->load->view('/supervisaodaq/apresentacaocontrutora/ApresentacaoConstrutoraView');
    } 
    public function homeSicroconstrucaoDaq(){
        $this->load->view('/supervisaodaq/sicroconstrucao/SicroconstrucaoView');
    }
     public function homeMobilizacaoConstrucaoDaq(){
        $this->load->view('/supervisaodaq/mobilizacaoconstrutora/MobilizacaoConstrutoraView');
    }
     public function homeAtividadeConstrutoraDaq(){
        $this->load->view('/supervisaodaq/atividadeconstrutora/AtividadeConstrutoraView');
    }
     public function homeAtividadeExecutoraOperacaoDaq(){
        $this->load->view('/supervisaodaq/atividadesexecutora/OperacaoView.php');
    }
     public function homeAtividadeExecutoraManutencaoDaq(){
        $this->load->view('/supervisaodaq/atividadesexecutora/ManutencaoView.php');
    }
     public function homeAtividadeExecutoraRegularizacaoDaq(){
        $this->load->view('/supervisaodaq/atividadesexecutora/RegularizacaoView.php');
    }
     public function homeAtividadeExecutoraAssessoramentoDaq(){
        $this->load->view('/supervisaodaq/atividadesexecutora/AssessoramentoEspecializadoView.php');
    }
     public function homeConformidadeDosProdutosEntreguesDaq(){
        $this->load->view('/supervisaodaq/atividadesexecutora/ConformidadeDosProdutosEntreguesView.php');
    }

                    //--------------------------Avanco-------------------------

        public function homeAvancoFinanceiroObraDaq(){
        $this->load->view('/supervisaodaq/avancofinanceiro/AvancoFinanceiroObraView');
        }

        public function homeAvancoFisicoDaq(){
        $this->load->view('/supervisaodaq/avancofisico/AvancoFisicoView');
        }
                    //---------------------------------------------------------

    public function homeAtividadesCriticasaDaq(){
        $this->load->view('/supervisaodaq/atividadecritica/AtividadesCriticasView');
    }
    public function homeControlePluviometricoDaq(){
        $this->load->view('/supervisaodaq/controlepluviometrico/ControlePluviometricoView');
    }
    public function homeDocumentacaoFotograficaDaq(){
        $this->load->view('/supervisaodaq/documentacaofotografica/DocumentacaoFotograficaView');
    }
    public function homeComponenteAmbientalDaq(){
        $this->load->view('/supervisaodaq/componenteambiental/ComponenteAmbientalView');
    } 

            //------------------------------Gestao Qualidade---------------------------
        public function homeEnsaioSupervisaoDaq(){
            $this->load->view('/supervisaodaq/ensaiosupervisao/EnsaioSupervisaoView');
        }
        public function homeEnsaiosConstrucaoDaq(){
            $this->load->view('/supervisaodaq/ensaioconstrucao/EnsaioConstrucaoView');
        }
        public function homeRNCdaq(){
            $this->load->view('/supervisaodaq/rnc/RNCView');
        }
           //---------------------------------------------------------------------------

    public function homeGarantiasContratuaisDaq(){
        $this->load->view('/supervisaodaq/garantiascontratuais/GarantiasContratuaisView');
    }
    public function homeInterferenciasExecutivasDaq(){
        $this->load->view('/supervisaodaq/riscosinterferencia/RiscosInterferenciasView');
    } 
    public function homeDiarioObraDaq(){
        $this->load->view('/supervisaodaq/diariodeobra/DiarioObraView');
    }
//---------------------------------------------------------------------------------
public function homeAtasCorrespondenciasDaq(){
    $this->load->view('/supervisaodaq/atascorrespondencia/AtasCorrespondenciasView');
}
public function homeGestaoTratativaDaq(){
    $this->load->view('/supervisaodaq/gestaotratativa/GestaoTratativaView');
}
public function homeRelatorioMonitoramentoAmbientalDaq(){
	$this->load->view('/supervisaodaq/relatoriomonitoramentoambiental/RelatorioMonitoramentoAmbientalView');
}
public function homeBoletimSemanalDragagemDaq(){
	$this->load->view('/supervisaodaq/boletimsemanaldragagem/BoletimSemanalDragagemView');
}
public function homeRelatorioLevantamentoHidrograficoDaq(){
	$this->load->view('/supervisaodaq/relatoriolevantamentohidrografico/RelatorioLevantamentoHidrograficoView');
}
public function homeRelatorioMensalDragagemDaq(){
	$this->load->view('/supervisaodaq/relatoriomensaldragagem/RelatorioMensalDragagemView');
}
public function homeConclusaoGeralDaq(){
    $this->load->view('/supervisaodaq/conclusaogeral/ConclusaoGeralView');
}
public function homeAnexosDaq(){
    $this->load->view('/supervisaodaq/anexo/AnexosView');
}
public function homeTermoEncerramentoDaq(){
    $this->load->view('/supervisaodaq/termoencerramento/TermoEncerramentoView');
}
public function RelatorioDaq(){
    $this->load->view('/supervisaodaq/relatoriorecibo/RelatorioView');
}
public function DocumentacaoDaq(){
    $this->load->view('/supervisaodaq/documentacao/DocumentacaoView');
}
//----------------------------------------------------------------------------------
    public function RecuperaTabelaContrato(){
        $DadosContrato = $this->Tb_contrato_obra->RecuperaTabelaContrato();
        $retorno["data"] = Array();

        if(!empty($DadosContrato)){
            foreach ($DadosContrato as $lista) {
                if ($lista->situacao == "ATIVO" or $lista->situacao == "ATIVO - AGUARDANDO CONCLUSÃO" or $lista->situacao =="CADASTRADO" or $lista->situacao =="CONCLUÍDO"){
                    $situacao_contrato = "<span class='badge badge-success'>".$lista->situacao."</span>";
            } 

                elseif($lista->situacao == "ENCERRADO" or $lista->situacao == "CANCELADO" ){
                    $situacao_contrato = "<span class='badge badge-danger'>".$lista->situacao."</span>";
            }

                else {
                    $situacao_contrato = "<span class='badge badge-warning'>".$lista->situacao."</span>";
            }
            if ($lista->nu_con_formatado_supervisor == ''){
                $num_super = '- -';
            } else{
                $num_super = $lista->nu_con_formatado_supervisor;
            }
        $retorno["data"][] = array(
            'CONTRATO' => "<b><a href='javascript:void(0);' onclick=passaId(" . $lista->id_contrato.")>" .$lista->contrato."- ".$lista->nomecontrato."</a></b>",
            'SUPERVISORA' => $num_super,
            'BRUF' => $br = "".$lista->sg_uf_unidade_local,
            'STATUS' => $situacao_contrato
            );
        }
    }
    echo (json_encode($retorno));
}
//---------------------------------------------------Session----------------------------------------------------
    public function Adicionasession() {
        $dados["idContrato"] = $this->input->post_get("idContrato");
        $dadosContrato = $this->Tb_contrato_obra->RecuperaDadosContrato($dados);

        foreach ($dadosContrato as $lista) {
          $data_inicial = date('d/m/Y');
          $data_final = $lista->vigencia;

          function geraTimestamp($data) {
                $partes = explode('/', $data);
                return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
            }

            $time_inicial = geraTimestamp($data_inicial);
            $time_final = geraTimestamp($data_final);
            $diferenca = $time_final - $time_inicial;
            $dias = (int)floor( $diferenca / (60 * 60 * 24));
                if($dias<0){
                    $dias = "--";
                }
            $dados["contrato"] = $lista->id_contrato;
            $dados["numero_contrato"] = $lista->numero_contrato;
            $dados["nome_empresa"] = $lista->nome_empresa;
            $dados["valor_total_aditivo"] = $lista->valor_total_aditivo;
            $dados["valor_total_reajuste"] = $lista->valor_total_reajuste;
            $dados["valor_inicial"] = $lista->valor_inicial;
            $dados["valor_total"] = $lista->valor_total;
            $dados["total_medido"] = $lista->total_medido;
            $dados["total_empenhado"] = $lista->total_empenhado;
            $dados["vigencia"] = $lista->vigencia;
            $dados["diasvencer"] = $dias;
            $dados["situacao"] = $lista->situacao;
            $dados["extesao_total"] = $lista->extesao_total;
        }
        $log = array(
            'idContrato' => $dados["contrato"],
            'numero_contrato' => $dados["numero_contrato"], 
            'nome_empresa' => $dados["nome_empresa"],
            'valor_inicial' => $dados["valor_inicial"],
            'valor_total' => $dados["valor_total"],
            'valor_total_aditivo' => $dados["valor_total_aditivo"],
            'valor_total_reajuste' => $dados["valor_total_reajuste"],
            'total_medido' => $dados["total_medido"],
            'total_empenhado' => $dados["total_empenhado"],
            'vigencia' => $dados["vigencia"],
            'diasvencer' => $dados["diasvencer"],
            'situacao' => $dados["situacao"],
            'extesao_total' => $dados["extesao_total"],
        );
            $this->session->set_userdata($log);
        echo (json_encode($dados));
    }

//------------------------------------------------------------------------------------------------------

public function RecuperaContrato(){
    $dados["contrato_busca"] = $this->input->post_get("contrato");
    $Dados = $this->Tb_contrato_obra->RecuperaContrato($dados);
    $retorno["data"] = Array();

      if(!empty($Dados)){

        foreach ($Dados as $lista) {

            if ($lista->situacao == "ATIVO" or $lista->situacao == "ATIVO - AGUARDANDO CONCLUSÃO" or $lista->situacao =="CADASTRADO" or $lista->situacao =="CONCLUÍDO"){
                    $situacao_contrato = "<span class='badge badge-success'>".$lista->situacao."</span>";
            } 

                elseif($lista->situacao == "ENCERRADO" or $lista->situacao == "CANCELADO"){
                    $situacao_contrato = "<span class='badge badge-danger'>".$lista->situacao."</span>";
            }

                else {
                    $situacao_contrato = "<span class='badge badge-warning'>".$lista->situacao."</span>";
            }


            $retorno["data"][] = array(
              'CONTRATO' => "<b><a href='javascript:void(0);' onclick=passaId(" . $lista->id_contrato.")>" .$lista->nu_con_formatado. "-" .$lista->nomecontrato."</a></b>",
              'SUPERVISORA' => $lista->nu_con_formatado_supervisor,
              'BRUF' => $lista->sg_uf_unidade_local,
              'STATUS' => $situacao_contrato
            );
        }
    }
    echo (json_encode($retorno));
}

//------------------------------------------------------------------------------------------------------------------
    public function confereRelatorio() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dadosStatusRelatorio = $this->Tb_contrato_obra->confereRelatorio($dados);
        $id = "";
        $status = "";
        
        if (!empty($dadosStatusRelatorio)) {
            foreach ($dadosStatusRelatorio as $lista) {
                $id = $lista->ID;
                $status = $lista->roteiro_analise;
            }
        }

        switch ($status) {
            case "fechar_relatorio":
                $status = 1;
                break;
            case "liberar_relatorio":
                $status = 2;
                break;
            default :
                $status = 3;
                break;
        }

        echo (json_encode($status));
    }
//-------------------------------------------------------Gestão Ambiental-------------------------------------------

public function confereGestaoAmbiental(){
    $dados["id_contrato_obra"] = $this->session->idContrato;
    $dados["periodo"] = $this->input->post_get("periodo");

    // $periodo = $this->input->post_get("periodo");
    // $dadosperiodo = explode("-", $periodo);
    // $periodoreferencia = ($dadosperiodo[1]."/". $dadosperiodo[0]);

    $dadosContrato = $this->Tb_contrato_obra->confereGestaoAmbiental($dados);
    foreach ($dadosContrato as $lista) {
        // $periodo="Periodo Referência: " .$periodoreferencia. "";

        // $dados['informacao']= $periodo;
        $dados["licenca_ambiental"] = $lista->licenca_ambiental;
        $dados["pba_pbai"] = $lista->pba_pbai;
    }

    echo (json_encode($dados));
}

//-------------------------------------------------Configuracao Obra---------------------------------------------------

public function returnCheckConfiguracao(){
    $dados["id_contrato_obra"] = $this->session->idContrato;
    // $dados["periodo"] = $this->input->post_get("periodo");
    // $periodo = $this->input->post_get("periodo");
    // $dadosperiodo = explode("-", $periodo);
    // $periodoreferencia = ($dadosperiodo[1]."/". $dadosperiodo[0]);

    $dadosConfiguracao = $this->Tb_contrato_obra->returnCheckConfiguracao($dados);
    foreach ($dadosConfiguracao as $lista) {
        // $periodo="Informacao " .$periodoreferencia. "";
        // $dados['informacao']= $periodo;
       // $dados["br"] = ($lista->br != '' || $lista->br != null) ? $lista->br : '';
        $dados["programa"] = $lista->programa;
        $dados["objeto_contratacao"] = $lista->objeto_contratacao;
        $dados["justificativa"] = $lista->justificativa;
        $dados["MapaSituacao"] = $lista->mapa_situacao;
        $dados["georreferenciados"] = $lista->eixos_georreferenciados;
           // $dados["DadosSegmento"] = $lista->dados_segmento;
        $dados["PontoPassagem"] = $lista->ponto_passagem;
        $dados["Ocorrencia"] = $lista->ocorrencias_projeto;
        $dados["Diagramas"] = $lista->diagramas;
        $dados["ART"] = $lista->art_supervisao;
        $dados["PortariasFiscais"] = $lista->portaria_fiscais;
    }

    echo (json_encode($dados));
}
//-------------------------------------------------Cronograma------------------------------------------------------------

public function returncheckCronogramas(){
    $dados["id_contrato_obra"] = $this->session->idContrato;

    $dadosCronograma = $this->Tb_contrato_obra->returncheckCronogramas($dados);
    foreach ($dadosCronograma as $lista) {
        $dados["cronograma_financeiro_obra"] = $lista->cronograma_financeiro_obra;
        $dados["cronograma_fisico"] = $lista->cronograma_fisico;
    }

    echo (json_encode($dados));

}
//----------------------------------------------------------------------------------------------------------------------

	public function baixarModelo() {
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$config['hostname'] = '10.100.11.158';
		$config['username'] = 'supradaq';
		$config['password'] = 'dnit@2020';
		$config['port']   = 21;
		$config['debug']  = TRUE;
		$this->ftp->connect($config);
		$arquivodestino = "/arquivos/arquivoDaq/Modelos/".$nome_arquivo;
		$arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
		$retorno = $this->ftp->download($arquivodestino, $arquivolocalho,'binary');
		$this->ftp->close();

		echo (json_encode($retorno));
	}



}//Fecha Classe
//######################################################################################################################################################################################################################## 
//# DNIT-Falconi AQUAVIARIO
//# Supervisaodaqctr.php
//# Desenvolvedora:Jordana de Alencar
//# Data: 20/10/2019 
//########################################################################################################################################################################################################################
