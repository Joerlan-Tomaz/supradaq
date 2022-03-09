<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  | example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  | https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  | $route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  | $route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  | $route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples: my-controller/index -> my_controller/index
  |   my-controller/my-method -> my_controller/my_method
 */

$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ---------------------GERAL-----------------------------------------------------------------------------------------
$route['JbnsgCdGG-1h4IXjlVTT3w'] = 'Home/home';
$route['L-nk35tmdwwbkJHiufA9Rw'] = 'Home/homePerfil';
$route['sax06gu0XKFsklBxlSnO1A'] = 'Login/alterasenha';


//--------------DAQ----------------------------------------------------------------------------------------------------
//---Load------
$route['HomeGeral'] = 'Home/home';
$route['HomePerfil'] = 'Home/homePerfil';
$route['HomeDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeDaq';
$route['HomeSupervisaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeSupervisaoDaq';
$route['HomeRelatorioDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeRelatorioSupervisaoDaq';
$route['HomeDocumentacaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homedocumentaoDaq';
$route['HomePainelDaq'] = '/Supervisaodaq/Supervisaodaqctr/homePainelAdm';
$route['homePainelGerencial'] = '/PainelGerencialdaq/PainelGerencialctr/homePainelGerencial';
$route['homeModelos'] = '/Supervisaodaq/Arquivo/Modelos';
//------------------------------------------------------------------------------------------------------------------
$route['ContratoDaq'] = '/Supervisaodaq/Supervisaodaqctr/Tabelacontratoobra';
$route['ContratoInfoDaq'] = '/Supervisaodaq/Supervisaodaqctr/InformacoesContrato';
//---Load------
$route['ConfiguracaoObraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeConfiguracaoObraDaq';
$route['ArtDaq'] = '/Supervisaodaq/Supervisaodaqctr/ArtDaq';
$route['PortariaFiscalDaq'] = '/Supervisaodaq/Supervisaodaqctr/PortariasFiscaisDaq';
$route['DiagramaPontoPassagemDaq'] = '/Supervisaodaq/Supervisaodaqctr/DiagramaPontoPassagemDaq';
$route['JustificativaDaq'] = '/Supervisaodaq/Supervisaodaqctr/JustificativaEmpreendimentoDaq';
$route['MapaSituacaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/MapaSituacaoDaq';
$route['GeorreferenciamentoDaq'] = '/Supervisaodaq/Supervisaodaqctr/GeorreferenciamentoDaq';
$route['PontopassagemDaq'] = '/Supervisaodaq/Supervisaodaqctr/PontopassagemDaq';
$route['OcorrenciaProjetoDaq'] = '/Supervisaodaq/Supervisaodaqctr/OcorrenciaProjetoDaq';

$route['CronogramasDaq'] = '/Supervisaodaq/Supervisaodaqctr/CronogramasDaq';
$route['CronogramasFinanceiroDaq'] = '/Supervisaodaq/Supervisaodaqctr/CronogramaFinanceiroObra';
$route['CronogramasFisicoDaq'] = '/Supervisaodaq/Supervisaodaqctr/CronogramaFisico';

$route['GestaoAmbientalDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeGestaoAmbientalDaq';
$route['LicencasAmbientaisDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeLicencasAmbientaisDaq';
$route['PbaPaiDaq'] = '/Supervisaodaq/Supervisaodaqctr/homePbaPaiDaq';

$route['PgqDaq'] = '/Supervisaodaq/Supervisaodaqctr/homePgqDaq';

$route['HistoricoObraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeHistoricoObraDaq';
$route['IntroducaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeIntroducaoDaq';
$route['ResumoProjetoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeResumoProjetoDaq';
$route['RpfoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeRpfoDaq';

$route['ApresentacaoSupervisoraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeApresentacaoSupervisoraDaq';
$route['SicroSupervisoraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeSicroDaq';
$route['MobilizacaoSupervisoraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeRelacaoMobilizacaoDaq';
$route['AtividadeSupervisoraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtividadeSupervisoraDaq';

$route['ApresentacaoConstrutoraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeApresentacaoConstrutoraDaq';
$route['SicroconstrucaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeSicroconstrucaoDaq';
$route['MobilizacaoConstrucaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeMobilizacaoConstrucaoDaq';
$route['AtividadeConstrutoraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtividadeConstrutoraDaq';
$route['AtividadeExecutoraOperacaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtividadeExecutoraOperacaoDaq';
$route['AtividadeExecutoraManutencaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtividadeExecutoraManutencaoDaq';
$route['AtividadeExecutoraRegularizacaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtividadeExecutoraRegularizacaoDaq';
$route['AtividadeExecutoraAssessoramentoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtividadeExecutoraAssessoramentoDaq';
$route['ConformidadeDosProdutosEntreguesDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeConformidadeDosProdutosEntreguesDaq';

$route['AvancoFinanceiroObraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAvancoFinanceiroObraDaq';
$route['AvancoFisicoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAvancoFisicoDaq';

$route['AtividadesCriticasaDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtividadesCriticasaDaq';
$route['ControlePluviometricoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeControlePluviometricoDaq';
$route['DocumentacaoFotograficaDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeDocumentacaoFotograficaDaq';
$route['ComponenteAmbientalDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeComponenteAmbientalDaq';

$route['EnsaioSupervisaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeEnsaioSupervisaoDaq';
$route['EnsaiosConstrucaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeEnsaiosConstrucaoDaq';
$route['RNCdaq'] = '/Supervisaodaq/Supervisaodaqctr/homeRNCdaq';

$route['GarantiasContratuaisDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeGarantiasContratuaisDaq';
$route['InterferenciasRiscosDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeInterferenciasExecutivasDaq';
$route['DiarioObraDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeDiarioObraDaq';

$route['AtasCorrespondenciasDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAtasCorrespondenciasDaq';
$route['GestaoTratativaDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeGestaoTratativaDaq';
$route['RelatorioMonitoramentoAmbientalDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeRelatorioMonitoramentoAmbientalDaq';
$route['ConclusaoGeralDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeConclusaoGeralDaq';

$route['AnexosHomeDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeAnexosDaq';
$route['TermoEncerramentoHomeDaq'] = '/Supervisaodaq/Supervisaodaqctr/homeTermoEncerramentoDaq';
$route['RelatorioImprimirHomeDaq'] = '/Supervisaodaq/Supervisaodaqctr/RelatorioDaq';
$route['DocumentacaoHomeDaq'] = '/Supervisaodaq/Supervisaodaqctr/DocumentacaoDaq';

//------------------------------------------------------------------------------------------------------------------
$route['TabelaContratoDaq'] = '/Supervisaodaq/Supervisaodaqctr/RecuperaTabelaContrato';
$route['ContratoSessionDaq'] = '/Supervisaodaq/Supervisaodaqctr/Adicionasession';
$route['ConfereRelatorioDaq'] = '/Supervisaodaq/Supervisaodaqctr/confereRelatorio';
$route['ContratoRecuperaDaq'] = '/Supervisaodaq/Supervisaodaqctr/RecuperaContrato';
//------------------------------------------------------------------------------------------------------------------
$route['ConfiguracaoMenuDaq'] = '/Supervisaodaq/Supervisaodaqctr/retornaConfiguracao';
$route['returnCheckGestaoAmbientalDaq'] = '/Supervisaodaq/Supervisaodaqctr/confereGestaoAmbiental';
$route['returnCheckConfiguracaoDaq'] = '/Supervisaodaq/Supervisaodaqctr/returnCheckConfiguracao';
$route['returnCheckCronogramasDaq'] = '/Supervisaodaq/Supervisaodaqctr/returncheckCronogramas';
//------------------------------------------------------------------------------------------------------------------
//---Load------
$route['insereAnexoDaq'] = '/Supervisaodaq/Anexo/Anexo/insereAnexo';
$route['RecuperaAnexosDaq'] = '/Supervisaodaq/Anexo/Anexo/RecuperaAnexos';
$route['excluirArquivoDaq'] = '/Supervisaodaq/Anexo/Anexo/excluirArquivo';

$route['RecuperaApresentacaoConstrutoraDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Apresentacaoconstrutora/RecuperaApresentacaoConstrutora';
$route['RetornaAditivoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Aditivo/Tableaditivo';
$route['RetornaPortariasFiscaisDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Apresentacaoconstrutora/recuperaPortariasFiscais';
$route['RetornoSelectHidrovia'] = '/Supervisaodaq/Apresentacaoconstrutora/Apresentacaoconstrutora/recuperaSelectHidrovia';
$route['RetornaLocalizacaoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Localizacao/Tablelocalizacao';
$route['RetornaResponsaveltecnicoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Responsaveltecnico/Tableresponsaveltecnico';
$route['RetornaParalisacaoReinicioDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/ParalisacaoReinicioctr/tableAsParalisacaoReinicio';
$route['insereApresentacaoconstrutoraDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Apresentacaoconstrutora/insereApresentacaoconstrutora';
$route['insereAditivoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Aditivo/insereAditivo';
$route['excluirAditivoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Aditivo/excluirAditivo';
$route['insereLocalizacaoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Localizacao/insereLocalizacao';
$route['excluirLocalizacaoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Localizacao/excluirLocalizacao';
$route['insereResponsavelTecnicoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Responsaveltecnico/insereResponsavelTecnico';
$route['excluirResponsaveltecnicoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Responsaveltecnico/excluirResponsaveltecnico';
$route['modalObjetoMotivacaoAditivoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/Aditivo/modalObjetoMotivacaoAditivo';
$route['insereParalisacaoReinicioConstrucaoDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/ParalisacaoReinicioctr/insereParalisacaoReinicioConstrucao';
$route['excluirParalisacaoReinicioDaq'] = '/Supervisaodaq/Apresentacaoconstrutora/ParalisacaoReinicioctr/excluirParalisacaoReinicio';

$route['RecuperaApresentacaoSupervisoraDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Apresentacaosupervisora/RecuperaApresentacaoSupervisora';
$route['SupervisoraAditivoDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Aditivo/Tableaditivo';
$route['SupervisoraFiscaisDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Apresentacaosupervisora/recuperaPortariasFiscais';
$route['SupervisoraLocalizacaoDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Localizacao/Tablelocalizacao';
$route['SupervisoraRespTecnicoDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Responsaveltecnico/Tableresponsaveltecnico';
$route['SupervisoraReinicioDaq'] = '/Supervisaodaq/Apresentacaosupervisora/ParalisacaoReinicioctr/tableAsParalisacaoReinicio';
$route['insereApresentacaosupervisoraDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Apresentacaosupervisora/insereApresentacaosupervisora';
$route['insereAditivosupervisoraDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Aditivo/insereAditivo';
$route['excluirAditivoSupervioraDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Aditivo/excluirAditivo';
$route['insereLocalizacaoSupervisoraDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Localizacao/insereLocalizacao';
$route['excluirLocalizacaoSupervisoraDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Localizacao/excluirLocalizacao';
$route['insereRespTecnicoSupDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Responsaveltecnico/insereResponsavelTecnico';
$route['excluirResptecnicoSupDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Responsaveltecnico/excluirResponsaveltecnico';
$route['modalAditivoSupDaq'] = '/Supervisaodaq/Apresentacaosupervisora/Aditivo/modalObjetoMotivacaoAditivo';
$route['insereReinicioSupervisaoDaq'] = '/Supervisaodaq/Apresentacaosupervisora/ParalisacaoReinicioctr/insereParalisacaoReinicioSupervisao';
$route['excluirReinicioSupDaq'] = '/Supervisaodaq/Apresentacaosupervisora/ParalisacaoReinicioctr/excluirParalisacaoReinicio';

$route['insereARTdaq'] = '/Supervisaodaq/Art/Art/insereART';
$route['recuperaARTDaq'] = '/Supervisaodaq/Art/Art/recuperaART';
$route['excluirARTDaq'] = '/Supervisaodaq/Art/Art/excluirART';
$route['populaUFDaq'] = '/Supervisaodaq/Art/Art/populaUF';
$route['ArtEditarDaq'] = '/Supervisaodaq/Art/Art/RecuperaEditaART';
$route['EditarArtDaq'] = '/Supervisaodaq/Art/Art/editarART';

$route['AtasCorrespondenciaInseredaq'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/insereAtasCorrespondencias';
$route['retornaAtasCorrespondenciasDaq'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/recuperaAtasCorrespondencias';
$route['AtasExcluirDaq'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/excluirArquivo';
$route['AtasNaoAtividadeDaq'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/naoHouveAtividade';
$route['AtasInsereNaoAtividadeDaq'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/insereNaoAtividade';
$route['AtasExcluirNaoAtividadeDaq'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/excluirNaoAtividade';

$route['AtividadesConstInsereDaq'] = '/Supervisaodaq/AtividadesConstrutora/AtividadesConstrutora/insereAtividadesConstrutora';
$route['AtividadeConstExcluirDaq'] = '/Supervisaodaq/AtividadesConstrutora/AtividadesConstrutora/excluirAtividadeConstrutora';
$route['AtividadesConstRecuperaDaq'] = '/Supervisaodaq/AtividadesConstrutora/AtividadesConstrutora/RecuperaAtividadesConstrutora';
$route['AtividadeConstEditarDaq'] = '/Supervisaodaq/AtividadesConstrutora/AtividadesConstrutora/editarAtividadeConstrutora';

$route['AtividadeCriticaInsereDaq'] = '/Supervisaodaq/AtividadesCriticas/AtividadesCriticas/insereAtividadeCritica';
$route['AtividadesCriticasExcluiDaq'] = '/Supervisaodaq/AtividadesCriticas/AtividadesCriticas/excluirAtividadesCriticas';
$route['AtividadesCriticasRecuperaDaq'] = '/Supervisaodaq/AtividadesCriticas/AtividadesCriticas/RecuperaAtividadesCriticas';
$route['AtividadesCriticasEditarDaq'] = '/Supervisaodaq/AtividadesCriticas/AtividadesCriticas/editarAtividadesCriticas';

$route['AtividadeSupInsereDaq'] = '/Supervisaodaq/AtividadeSupervisora/AtividadeSupervisora/insereAtividadeSupervisora';
$route['AtividadeSupExcluirDaq'] = '/Supervisaodaq/AtividadeSupervisora/AtividadeSupervisora/excluirAtividadeSupervisora';
$route['AtividadeSupRetornaDaq'] = '/Supervisaodaq/AtividadeSupervisora/AtividadeSupervisora/RecuperaAtividadeSupervisora';
$route['AtividadeSupEditarDaq'] = '/Supervisaodaq/AtividadeSupervisora/AtividadeSupervisora/editarAtividadeSupervisora';

$route['MonitoramentoInsereDaq'] = '/Supervisaodaq/ComponenteAmbiental/ComponenteAmbiental/insereComponenteAmbiental';
$route['MonitoramentoRetornaDaq'] = '/Supervisaodaq/ComponenteAmbiental/ComponenteAmbiental/RecuperaComponenteAmbiental';
$route['MonitoramentoExcluirDaq'] = '/Supervisaodaq/ComponenteAmbiental/ComponenteAmbiental/excluirArquivo';
$route['MonitoramentoNaoAtividadeDaq'] = '/Supervisaodaq/ComponenteAmbiental/ComponenteAmbiental/insereNaoAtividade';
$route['MonitoramentoConfereAtvDaq'] = '/Supervisaodaq/ComponenteAmbiental/ComponenteAmbiental/confereAtividade';

$route['RelatorioMonitoramentoAmbientalInsereDaq'] = '/Supervisaodaq/RelatorioMonitoramentoAmbiental/RelatorioMonitoramentoAmbiental/insereRelatorioMonitoramentoAmbiental';
$route['RelatorioMonitoramentoAmbientalRetornaDaq'] = '/Supervisaodaq/RelatorioMonitoramentoAmbiental/RelatorioMonitoramentoAmbiental/recuperaRelatorioMonitoramentoAmbiental';
$route['RelatorioMonitoramentoAmbientalExcluirDaq'] = '/Supervisaodaq/RelatorioMonitoramentoAmbiental/RelatorioMonitoramentoAmbiental/excluirRelatorioMonitoramentoAmbiental';

$route['ConclusaoInsereDaq'] = '/Supervisaodaq/ConclusaoGeral/ConclusaoGeral/insereConclusaoGeral';
$route['ConclusaoRetornaDaq'] = '/Supervisaodaq/ConclusaoGeral/ConclusaoGeral/RecuperaConclusaoGeral';
$route['ConclusaoExcluirDaq'] = '/Supervisaodaq/ConclusaoGeral/ConclusaoGeral/excluirResumo';

$route['ControlePluvInsereDaq'] = '/Supervisaodaq/ControlePluviometrico/ControlePluviometrico/insereControlePluv';
$route['ControlePluvRecuperaDaq'] = '/Supervisaodaq/ControlePluviometrico/ControlePluviometrico/recuperaControlePluv';
$route['ControlePluvExcluirDaq'] = '/Supervisaodaq/ControlePluviometrico/ControlePluviometrico/excluirDia';
$route['ControlePluvDiaDaq'] = '/Supervisaodaq/ControlePluviometrico/ControlePluviometrico/Recuperadiasmes';
$route['ControlePluvNaoAtividadeDaq'] = '/Supervisaodaq/ControlePluviometrico/ControlePluviometrico/insereNaoAtividade';
$route['ControlePluvConfereAtvDaq'] = '/Supervisaodaq/ControlePluviometrico/ControlePluviometrico/confereAtividade';

$route['DiagramaPPInsereDaq'] = '/Supervisaodaq/DiagramaPontoPassagem/DiagramaPontoPassagem/insereDiagramaPontoPassagem';
$route['DiagramaPPRecuperaDaq'] = '/Supervisaodaq/DiagramaPontoPassagem/DiagramaPontoPassagem/recuperaDiagramaPontoPassagem';
$route['DiagramaPPExcluirDaq'] = '/Supervisaodaq/DiagramaPontoPassagem/DiagramaPontoPassagem/excluirDiagramaPontoPassagem';

$route['DiarioObraInsereDaq'] = '/Supervisaodaq/DiarioObra/DiarioObra/insereDiarioObra';
$route['DiarioObraRecuperaDaq'] = '/Supervisaodaq/DiarioObra/DiarioObra/recuperaDiarioObra';
$route['DiarioObraExcluirDaq'] = '/Supervisaodaq/DiarioObra/DiarioObra/excluirArquivo';

$route['DocFotograficoInsereDaq'] = '/Supervisaodaq/DocumentacaoFotografica/DocumentacaoFotografica/insereDocFotografico';
$route['DocFotograficoRecuperaDaq'] = '/Supervisaodaq/DocumentacaoFotografica/DocumentacaoFotografica/recuperaDocumentacao';
$route['DocFotograficoExcluirDaq'] = '/Supervisaodaq/DocumentacaoFotografica/DocumentacaoFotografica/excluirDocumentacao';

$route['EnsaioConsInsereDaq'] = '/Supervisaodaq/EnsaioConstrucao/EnsaioConstrucao/insereEnsaioLaboratorio';
$route['EnsaioConsRecuperaDaq'] = '/Supervisaodaq/EnsaioConstrucao/EnsaioConstrucao/recuperaEnsaiosLaboratorio';
$route['EnsaioConsExcluirDaq'] = '/Supervisaodaq/EnsaioConstrucao/EnsaioConstrucao/excluirArquivo';

$route['EnsaioSupInsereDaq'] = '/Supervisaodaq/EnsaiosLaboratoriais/EnsaiosLaboratoriais/insereEnsaioLaboratorio';
$route['EnsaioSupInsereNHADaq'] = '/Supervisaodaq/EnsaiosLaboratoriais/EnsaiosLaboratoriais/insereNaoAtividade';
$route['EnsaioSupRecuperaDaq'] = '/Supervisaodaq/EnsaiosLaboratoriais/EnsaiosLaboratoriais/recuperaEnsaiosLaboratorio';
$route['EnsaioSupExcluirDaq'] = '/Supervisaodaq/EnsaiosLaboratoriais/EnsaiosLaboratoriais/excluirArquivo';

$route['GarantiaSeguroInsereDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/insereGarantiaSeguro';
$route['GarantiaSeguroInsereProvDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/insereProvidencia';
$route['GarantiaSeguroInsereAnxDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/insereAnexo';
$route['GarantiaSeguroTipoDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/populaTipoGarantia';
$route['GarantiaSeguroRecuperaDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/recuperaGarantiaSeguro';
$route['GarantiaSeguroObsObjDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/recuperaObservacaoObjeto';
$route['GarantiaSeguroExcluirDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/excluirGarantiaSeguro';
$route['GarantiaSeguroRecuperaProvDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/recuperaProvidencia';
$route['GarantiaSeguroExcluiProvDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/excluirProvidencia';
$route['GarantiaSeguroRecuperaAnxDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/recuperaAnexos';
$route['GarantiaSeguroExluiAnxDaq'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/excluirArquivo';

$route['GestaoTratativaInsereDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/insereGestaoTratativa';
$route['GestaoTratativaInsereProvDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/insereProvidencia';
$route['GestaoTratativaInsereAtividadeDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/insereNaoAtividade';
$route['GestaoTratativaRecuperaDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/recuperaGestaoTratativa';
$route['GestaoTratativaExcluirDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/excluirGestaoTratativa';
$route['GestaoTratativaOriginDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/populaOrigem';
$route['GestaoTratativaRespDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/populaResponsaveis';
$route['GestaoTratativaModalDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/modalStatus';
$route['GestaoTratativaRecuperaProvDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/recuperaProvidencia';
$route['GestaoTratativaExcluirProvDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/excluirProvidencia';
$route['GestaoTratativaNaoAtividadeDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/gestao_tratativaNaoAtv';
$route['GestaoTratativaNaoAtvDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/NaoHouveAtividadedaq';
$route['GestaoTratativaEditarDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/editarGestaoTratativa';
$route['GestaoTratativaReturnEditarDaq'] = '/Supervisaodaq/GestaoTratativa/GestaoTratativa/ReturnEditarGestaoTratativa';

$route['ResumoInsereDaq'] = '/Supervisaodaq/Historico/Historico/insereResumo';
$route['ResumoRecuperaDaq'] = '/Supervisaodaq/Historico/Historico/recuperaResumo';
$route['ResumoEditarDaq'] = '/Supervisaodaq/Historico/Historico/editarResumo';
$route['ResumoExcluirDaq'] = '/Supervisaodaq/Historico/Historico/excluirResumo';

$route['DadosInicioDaq'] = '/Supervisaodaq/DadosContrato/Dadoscontratoctr/adicionaDadosInicio';

$route['IntroducaoInsereDaq'] = '/Supervisaodaq/Introducao/Introducao/insereResumo';
$route['IntroducaoRecuperaDaq'] = '/Supervisaodaq/Introducao/Introducao/recuperaResumo';
$route['IntroducaoEditarDaq'] = '/Supervisaodaq/Introducao/Introducao/editarResumo';
$route['IntroducaoExcluirDaq'] = '/Supervisaodaq/Introducao/Introducao/excluirResumo';

$route['JustificativaInsereDaq'] = '/Supervisaodaq/JustificativaEmpreendimentos/JustificativaEmpreendimentos/insereResumo';
$route['JustificativaRecuperaDaq'] = '/Supervisaodaq/JustificativaEmpreendimentos/JustificativaEmpreendimentos/recuperaJustificativa';
$route['JustificativaExcluirDaq'] = '/Supervisaodaq/JustificativaEmpreendimentos/JustificativaEmpreendimentos/excluirResumo';
$route['JustificativaEditarDaq'] = '/Supervisaodaq/JustificativaEmpreendimentos/JustificativaEmpreendimentos/editarResumo';

$route['LicencasAmbientaisInsereDaq'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/insereLicencasAmbientais';
$route['LicencasAmbientaisRecuperaDaq'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/recuperaLicencasAmbientais';
$route['LicencasAmbientaisExcluirDaq'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/excluirArquivo';
$route['LicencasAmbientaisRecEditarDaq'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/RecuperaLicencaEditar';
$route['LicencasAmbientaisEditarDaq'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/editarLicencaAmbiental';
$route['LicencasAmbientaisTipoDaq'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/populaTipoLicenca';

$route['MapaSituacaoInsereDaq'] = '/Supervisaodaq/MapaSituacao/MapaSituacao/insereMapaSituacao';
$route['MapaSituacaoRecuperaDaq'] = '/Supervisaodaq/MapaSituacao/MapaSituacao/recuperaMapaSituacao';
$route['MapaSituacaoExcluirDaq'] = '/Supervisaodaq/MapaSituacao/MapaSituacao/excluirArquivo';

$route['MobilizacaoConstrutoraExcluiDaq'] = '/Supervisaodaq/MobilizacaoConstrutora/MobilizacaoConstrutoractr/trashsupervisora';
$route['MobilizacaoConstrutoraRetornaDaq'] = '/Supervisaodaq/MobilizacaoConstrutora/MobilizacaoConstrutoractr/RecuperaMobilizacaoConstrucao';
$route['MobilizacaoConstrutoraGravaDaq'] = '/Supervisaodaq/MobilizacaoConstrutora/MobilizacaoConstrutoractr/GravaRelacao';
$route['MobilizacaoConstrutoraItemDaq'] = '/Supervisaodaq/MobilizacaoConstrutora/MobilizacaoConstrutoractr/Recupera_item_cadastro';
$route['MobilizacaoConstrutoraRelacaoDaq'] = '/Supervisaodaq/MobilizacaoConstrutora/MobilizacaoConstrutoractr/RecuperaRelacaoMobilizacao_Construcao';

$route['MobilizacaoSupervisoraRecuperaDaq'] = '/Supervisaodaq/MobilizacaoSupervisora/MobilizacaoSupervisoractr/RecuperaMobilizacaoSupervisora';
$route['MobilizacaoSupervisoraGravaDaq'] = '/Supervisaodaq/MobilizacaoSupervisora/MobilizacaoSupervisoractr/GravaRelacao';
$route['MobilizacaoSupervisoraExcluiDaq'] = '/Supervisaodaq/MobilizacaoSupervisora/MobilizacaoSupervisoractr/trashconstrutora';
$route['MobilizacaoSupervisoraItemDaq'] = '/Supervisaodaq/MobilizacaoSupervisora/MobilizacaoSupervisoractr/Recupera_item_cadastro';
$route['MobilizacaoSupervisoraRelacaoDaq'] = '/Supervisaodaq/MobilizacaoSupervisora/MobilizacaoSupervisoractr/RecuperaRelacaoMobilizacao_Supervisora';

$route['PbaPbaiRecuperaDaq'] = '/Supervisaodaq/PbaPbai/PbaPbai/recuperaPbaPbai';
$route['PbaPbaiExcluirDaq'] = '/Supervisaodaq/PbaPbai/PbaPbai/excluirPbaPbai';
$route['PbaPbaiTipoPbaDaq'] = '/Supervisaodaq/PbaPbai/PbaPbai/populaPba';
$route['PbaPbaiTipoPbaiDaq'] = '/Supervisaodaq/PbaPbai/PbaPbai/populaPbai';
$route['PbaPbaiEditarDaq'] = '/Supervisaodaq/PbaPbai/PbaPbai/Recupera_editarPbaPbai';
$route['PbaPbaiInsereDaq'] = '/Supervisaodaq/PbaPbai/PbaPbai/inserePbaPbai';

$route['PGQInsereDaq'] = '/Supervisaodaq/PGQ/PGQ/inserePGQ';
$route['PGQRecuperaDaq'] = '/Supervisaodaq/PGQ/PGQ/recuperaPGQ';
$route['PGQExcluirDaq'] = '/Supervisaodaq/PGQ/PGQ/excluirArquivo';
$route['70bc1de8a077e52493d9c41ffaa3c051'] = '/Supervisaodaq/Arquivo/imagem';
$route['70bc1de8a077e52493d9c41ffaa3c051ARQ'] = '/Supervisaodaq/Arquivo/DownloadArquivo';
$route['70bc1de8a077e52493d9c41ffaa3c051ARQMODELO'] = '/Supervisaodaq/Arquivo/Modelo';
$route['PontoPassagemRecuperaDaq'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/recuperaPontoPassagem';
$route['PontoPassagemExcluiDaq'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/excluirArquivo';
$route['PontoPassagemDetalhesDaq'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/recuperaDetalhesPontoPassagem';
$route['PontoPassagemInsereDaq'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/insereArquivoPontoPassagem';
$route['PontoPassagemInsereDadosDaq'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/inserirdados';

$route['PortariasFiscaisInsereDaq'] = '/Supervisaodaq/PortariasFiscais/PortariasFiscais/inserePortariasFiscais';
$route['PortariasFiscaisRecuperaDaq'] = '/Supervisaodaq/PortariasFiscais/PortariasFiscais/recuperaPortariasFiscais';
$route['PortariasFiscaisExcluiDaq'] = '/Supervisaodaq/PortariasFiscais/PortariasFiscais/excluirPortariasFiscais';
$route['PortariasFiscaisUfDaq'] = '/Supervisaodaq/PortariasFiscais/PortariasFiscais/populaUF';
$route['PortariasFiscaisTitularidadeDaq'] = '/Supervisaodaq/PortariasFiscais/PortariasFiscais/populaTitularidade';

$route['ResumoProjetoinsereDaq'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/insereResumo';
$route['ResumoProjetoRecuperaDaq'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/recuperaResumo';
$route['ResumoProjetoEditarDaq'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/editarResumo';
$route['ResumoProjetoExcluirDaq'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/excluirArquivo';
$route['ResumoProjetoTipoDaq'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/populaTipoTexto';
$route['ResumoProjetoNHADaq'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/insereNaoAtividade';

$route['InterferenciaInsereDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/insereInterferencia';
$route['InterferenciaEditarDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/editarInterferencia';
$route['InterferenciaTipoDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/recupera_TipoInterferencia';
$route['InterferenciaTipoClassDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/recuperaClassificacao';
$route['InterferenciaTipoGrauDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/recuperaGrauImpacto';
$route['InterferenciaTipoEixoDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/populaTipoEixo';
$route['InterferenciaRecuperaDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/recuperaInterferencia';
$route['InterferenciaExcluirDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/excluirInterferencia';
$route['InterferenciaDescricaoDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/consultaDescricaoInterferencia';
$route['InterferenciaRecuperaEditarDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/RecuperaInterferenciaEditar';
$route['InterferenciaInsereAtvDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/insereNaoAtividade';
$route['InterferenciaRecuperaAtvDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/recuperaNaoAtividade';
$route['InterferenciaAtvDaq'] = '/Supervisaodaq/RiscoInterferencia/RiscoInterferencia/NaoHouveAtividadedaq';

$route['RncInsereFotoDaq'] = '/Supervisaodaq/RNC/RNC/insereFoto';
$route['RncNaoAtividadeDaq'] = '/Supervisaodaq/RNC/RNC/insereNaoAtividade';
$route['RncRecuperaDaq'] = '/Supervisaodaq/RNC/RNC/recuperaRNC';
$route['RncExcluirDaq'] = '/Supervisaodaq/RNC/RNC/excluirRNC';
$route['RncExcluiAtvDaq'] = '/Supervisaodaq/RNC/RNC/excluiratividade';
$route['RncExcluiProvDaq'] = '/Supervisaodaq/RNC/RNC/excluirProvidencia';
$route['RncConfereAtvDaq'] = '/Supervisaodaq/RNC/RNC/confereAtividade';
$route['RncIsereIdDaq'] = '/Supervisaodaq/RNC/RNC/insereIdSessao';
$route['RncFotosDaq'] = '/Supervisaodaq/RNC/RNC/fotos';
$route['RncConsultaSugestaoDaq'] = '/Supervisaodaq/RNC/RNC/consultaSugestao';
$route['RncGravidadeDaq'] = '/Supervisaodaq/RNC/RNC/populaGravidade';
$route['RncNaturezaDaq'] = '/Supervisaodaq/RNC/RNC/populaNatureza';
$route['RncObraDaq'] = '/Supervisaodaq/RNC/RNC/populaObra';
$route['RncPavimentoDaq'] = '/Supervisaodaq/RNC/RNC/populaPavimento';
$route['RncEixoDaq'] = '/Supervisaodaq/RNC/RNC/populaTipoEixo';
$route['RncInsereDaq'] = '/Supervisaodaq/RNC/RNC/insereRnc';
$route['RncInsereProvidenciaDaq'] = '/Supervisaodaq/RNC/RNC/insereProvidencia';
$route['RncRecuperaFotoDaq'] = '/Supervisaodaq/RNC/RNC/RecuperaFotos';
$route['RncExcluirFotoDaq'] = '/Supervisaodaq/RNC/RNC/excluirFoto';
$route['RncImpDaq'] = '/Supervisaodaq/RNC/RNC/btnimpRNC';

$route['RpfoinsereNaoAtividadeDaq'] = '/Supervisaodaq/Rpfo/Rpfo/insereNaoAtividade';
$route['RpfoRecuperaDaq'] = '/Supervisaodaq/Rpfo/Rpfo/recuperaRpfo';
$route['RpfoExcluirDaq'] = '/Supervisaodaq/Rpfo/Rpfo/excluirRpfo';
$route['RpfoLocalDaq'] = '/Supervisaodaq/Rpfo/Rpfo/populaLocal';
$route['RpfoStatusDaq'] = '/Supervisaodaq/Rpfo/Rpfo/populaStatus';
$route['RpfoConfereAtvDaq'] = '/Supervisaodaq/Rpfo/Rpfo/confereAtividade';
$route['RpfoStatusDetalhadoDaq'] = '/Supervisaodaq/Rpfo/Rpfo/consultaStatusDetalhado';
$route['RpfoInsereDaq'] = '/Supervisaodaq/Rpfo/Rpfo/insereRpfo';
$route['RpfoEdicaoDaq'] = '/Supervisaodaq/Rpfo/Rpfo/Recupera_Rpfo_edicao';
$route['RpfoAlteraDaq'] = '/Supervisaodaq/Rpfo/Rpfo/alteraRpfo';
$route['RpfoRecuperaHistorico'] = '/Supervisaodaq/Rpfo/Rpfo/rpfoRecuperaHistorico';
$route['RpfoInsereHistorico'] = '/Supervisaodaq/Rpfo/Rpfo/insereRpfoHistorico';
$route['RpfoExcluirHistorico'] = '/Supervisaodaq/Rpfo/Rpfo/excluirRpfoHistorico';
$route['RpfoRecuperaAnexo'] = '/Supervisaodaq/Rpfo/Rpfo/rpfoRecuperaAnexo';
$route['RpfoInserirArquivo'] = '/Supervisaodaq/Rpfo/Rpfo/rpfoInserirArquivo';
$route['RpfoExcluirAnexo'] = '/Supervisaodaq/Rpfo/Rpfo/excluirRpfoAnexo';
$route['RpfoModelo'] = '/Supervisaodaq/Rpfo/Rpfo/modelorpfo';


$route['SicroSupervisoraItemDaq'] = '/Supervisaodaq/SicroSupervisora/SicroSupervisoractr/Recupera_item_cadastro';
$route['SicroSupervisoraRelacaoItemDaq'] = '/Supervisaodaq/SicroSupervisora/SicroSupervisoractr/Recupera_relacao_item_cadastro';
$route['SicroSupervisoraCadastraItemDaq'] = '/Supervisaodaq/SicroSupervisora/SicroSupervisoractr/CadastrarItem';

$route['SicroConstrutoraRecuperaItemDaq'] = '/Supervisaodaq/Sicroconstrucao/Sicroconstrucaoctr/Recupera_item_cadastro';
$route['SicroConstrutoraRelacaoItemDaq'] = '/Supervisaodaq/Sicroconstrucao/Sicroconstrucaoctr/Recupera_relacao_item_cadastro';
$route['SicroConstrutoraCadastraItemDaq'] = '/Supervisaodaq/Sicroconstrucao/Sicroconstrucaoctr/CadastrarItem';

$route['TermoEncerramentoTextoDaq'] = '/Supervisaodaq/TermoEncerramento/TermoEncerramento/textoPadrao';
$route['TermoEncerramentoInsereDaq'] = '/Supervisaodaq/TermoEncerramento/TermoEncerramento/insereTermoEncerramento';
$route['TermoEncerramentoExcluirDaq'] = '/Supervisaodaq/TermoEncerramento/TermoEncerramento/excluirTermoEncerramento';
$route['TermoEncerramentoRecuperaDaq'] = '/Supervisaodaq/TermoEncerramento/TermoEncerramento/RecuperaTermoEncerramento';
$route['TermoEncerramentoEditarDaq'] = '/Supervisaodaq/TermoEncerramento/TermoEncerramento/EditarTermoEncerramento';

$route['OcorrenciaProjetoContagemDaq'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/contagemLinhas';
$route['OcorrenciaProjetoRecuperaDaq'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/recuperaOcorrenciaProjeto';
$route['OcorrenciaProjetoExcluirDaq'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/excluirArquivo';
$route['OcorrenciaProjetoDetalhesDaq'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/recuperaDetalhesOcorrenciaProjeto';
$route['OcorrenciaProjetoInsereDaq'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/insereArquivoOcorrencia';
$route['OcorrenciaProjetoInsereDadosDaq'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/inserirdados';

$route['GeorreferenciamentoRetornoDaq'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/recuperaGeorreferenciamento';
$route['GeorreferenciamentoExcluirDaq'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/excluirGeorreferenciamento';
$route['GeorreferenciamentoDetalhesDaq'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/recuperaDetalhesGeorreferenciamento';
$route['GeorreferenciamentoNomeEixoDaq'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/RecuperaNomeEixo';
$route['GeorreferenciamentoinsereDaq'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/insereArquivoGeorreferenciamento';
$route['GeorreferenciamentoHidroviaDaq'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/populaHidrovia';
$route['GeorreferenciamentoDadosDaq'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/inserirdados';
$route['GeorreferenciamentoModelo'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/modelogeo';

$route['AvancoFinNaoPublicadoDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/RecuperaMedicaoNaopublicado';
$route['AvancoFinPublicadoDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/RecuperaMedicaopublicado';
$route['AvancoFinNumMedicaoDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/RecuperaMedicaoNumeMedicao';
$route['AvancoFinDetalhadoDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/RecuperaDetalhado';
$route['AvancoFinObraDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/recuperaObra';
$route['AvancoFinServicoDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/recuperaServico';
$route['AvancoFinTipoDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/recuperaTipo';
$route['AvancoFinInsereDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/insereAvanco';
$route['AvancoFinExcluirDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/ExcluirAvanco';
$route['AvancoFinPublicarDaq'] = '/Supervisaodaq/AvancoFinanceiroObra/Avancofinanceiroobractr/PublicarNaopublicado';

$route['AvancoFisicoAtacadoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/AvancoAquaviario_Trecho_Atacado';
$route['AvancoFisicoConcluidoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/AvancoAquaviario_Trecho_Concluido';
$route['AvancoFisicoAtividadeDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/AvancoAquaviario_naohouveatividademes';
$route['AvancoFisicoPeriodoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/conferePeriododaq';
$route['AvancoFisicoExecutadoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/recupera_medicao_aquaviario_executado';
$route['AvancoFisicoExConcluidoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/aquaviario_medicao_executado_concluido';
$route['AvancoFisicoInsereExecutadoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/insere_avanco_aquaviario_executado';
$route['AvancoFisicoEixoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/recuperaEixo';
$route['AvancoFisicoObraDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/recuperaObra';
$route['AvancoFisicoServicoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/recuperaServico';
$route['AvancoFisicoTipoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/recuperaTipo';
$route['AvancoFisicoVerificaAtacDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/avancoaquaviarioatacado';
$route['AvancoFisicoInsereAtacadoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/insere_avanco_aquaviario';
$route['AvancoFisicoCronValidaDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/Cronograma_fisico';
$route['AvancoFisicoInsereAtividadeDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/insere_naohouveatividademes';
$route['AvancoFisicoMedidaExecDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/medicaoexecutada';
$route['AvancoFisicoTrashExecDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/trashmedicaoExecutado';
$route['AvancoFisicoTrashConcluiDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/trashExecutadoConcluido';
$route['AvancoFisicoRetornExecutadoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/RecuperaExecutado';
$route['AvancoFisicoTrashAtacadoDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/atacadodaqtrash';
$route['AvancoFisicoTrashAtividadeDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/NaoHouveAtividadedaq';
$route['AvancoFisicoInsereAnteriorDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/insere_avanco_aquaviario_executado_anterior';
$route['AvancoFisicoTrashAnteriorDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/trashContratoAnterior';
$route['AvancoFisicoRecuperaAnteriorDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/AvancoAquaviario_Trecho_Concluido_Contrato_Anterior';
$route['AvancoFisicoValidaExecDaq'] = '/Supervisaodaq/AvancoFisico/Avancofisicoctr/returnExecutadoaquaviario';

$route['anexorecupera'] = '/Supervisaodaq/Anexo/Anexo/anexorecupera';
$route['anexoEnsaiosup'] = '/Supervisaodaq/EnsaiosLaboratoriais/EnsaiosLaboratoriais/anexoEnsaiosup';
$route['anexoEnsaio'] = '/Supervisaodaq/EnsaioConstrucao/EnsaioConstrucao/anexoEnsaio';
$route['anexoResumo'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/anexoResumo';
$route['anexoMapas'] = '/Supervisaodaq/MapaSituacao/MapaSituacao/anexoMapas';
$route['recuperareinicio'] = '/Supervisaodaq/Apresentacaoconstrutora/ParalisacaoReinicioctr/recuperareinicio';
$route['recuperaReinicio'] = '/Supervisaodaq/Apresentacaosupervisora/ParalisacaoReinicioctr/recuperaReinicio';
$route['artAnexo'] = '/Supervisaodaq/Art/Art/artAnexo';
$route['AtasAnexo'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/AtasAnexo';
$route['anexoAmbiental'] = '/Supervisaodaq/ComponenteAmbiental/ComponenteAmbiental/anexoAmbiental';
$route['anexoDiagrama'] = '/Supervisaodaq/DiagramaPontoPassagem/DiagramaPontoPassagem/anexoDiagrama';
$route['anexoDiario'] = '/Supervisaodaq/DiarioObra/DiarioObra/anexoDiario';
$route['anexoDoc'] = '/Supervisaodaq/DocumentacaoFotografica/DocumentacaoFotografica/anexoDoc';
$route['anexoGaratias'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/anexoGaratias';
$route['anexoGeo'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/anexoGeo';
$route['ModeloGeo'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/ModeloGeo';
$route['anexoLicencas'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/anexoLicencas';
$route['anexoProjeto'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/anexoProjeto';
$route['ModeloOcorrenciaProjeto'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/ModeloOcorrenciaProjeto';
$route['anexoPbaPbai'] = '/Supervisaodaq/PbaPbai/PbaPbai/anexoPbaPbai';
$route['anexoPontoPass'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/anexoPontoPass';
$route['ModeloPontoPassagem'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/ModeloPontoPassagem';
$route['anexoPortarias'] = '/Supervisaodaq/PortariasFiscais/PortariasFiscais/anexoPortarias';
$route['anexoRnc'] = '/Supervisaodaq/RNC/RNC/anexoRnc';
$route['anexoRpfo'] = '/Supervisaodaq/Rpfo/Rpfo/anexoRpfo';
$route['anexoDownload'] = '/Supervisaodaq/Relatorio/Relatorioctr/anexoDownload';
$route['excluiranexorelatorio'] = '/Supervisaodaq/Relatorio/Relatorioctr/excluiranexorelatorio';
$route['excluiranexo'] = '/Supervisaodaq/Anexo/Anexo/excluiranexo';


$route['excluirLicensas'] = '/Supervisaodaq/LicencasAmbientais/LicencasAmbientais/excluirLicensas';
$route['excluirMapas'] = '/Supervisaodaq/MapaSituacao/MapaSituacao/excluirMapas';
$route['excluirparalizacao'] = '/Supervisaodaq/Apresentacaoconstrutora/ParalisacaoReinicioctr/excluirparalizacao';
$route['excluirReinicio'] = '/Supervisaodaq/Apresentacaosupervisora/ParalisacaoReinicioctr/excluirReinicio';
$route['artexcluir'] = '/Supervisaodaq/Art/Art/artexcluir';
$route['excluirAtas'] = '/Supervisaodaq/AtasCorrespondencia/AtasCorrespondencia/excluirAtas';
$route['excluirArq'] = '/Supervisaodaq/ComponenteAmbiental/ComponenteAmbiental/excluirArq';
$route['excluirDiagrama'] = '/Supervisaodaq/DiagramaPontoPassagem/DiagramaPontoPassagem/excluirDiagrama';
$route['excluirDiario'] = '/Supervisaodaq/DiarioObra/DiarioObra/excluirDiario';
$route['excluirDoc'] = '/Supervisaodaq/DocumentacaoFotografica/DocumentacaoFotografica/excluirDoc';
$route['excluirEnsaio'] = '/Supervisaodaq/EnsaioConstrucao/EnsaioConstrucao/excluirEnsaio';
$route['excluirEnsaioSup'] = '/Supervisaodaq/EnsaiosLaboratoriais/EnsaiosLaboratoriais/excluirEnsaioSup';
$route['excluirGarantias'] = '/Supervisaodaq/GarantiasContratuais/GarantiasContratuais/excluirGarantias';
$route['excluirGeo'] = '/Supervisaodaq/Georreferenciamento/Georreferenciamento/excluirGeo';
$route['excluirOcorrecia'] = '/Supervisaodaq/OcorrenciaProjeto/OcorrenciaProjeto/excluirOcorrecia';
$route['excluirPba'] = '/Supervisaodaq/PbaPbai/PbaPbai/excluirPba';
$route['excluirPgq'] = '/Supervisaodaq/PGQ/PGQ/excluirPgq';
$route['excluirpp'] = '/Supervisaodaq/PontoPassagem/PontoPassagem/excluirpp';
$route['excluirPortaria'] = '/Supervisaodaq/PortariasFiscais/PortariasFiscais/excluirPortaria';
$route['excluirResumo'] = '/Supervisaodaq/Resumoprojeto/Resumoprojeto/excluirResumo';
$route['excluiRnc'] = '/Supervisaodaq/RNC/RNC/excluiRnc';
$route['excluiRpfo'] = '/Supervisaodaq/Rpfo/Rpfo/excluiRpfo';

$route['CronogramaFinanceiroRetornaDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/recuperaCronograma';
$route['CronogramaFinanceiroPublicarDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/PublicarCronograma_naopublicado';
$route['CronogramaFinanceiroEditarDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/RecuperaeditarCronograma';
$route['CronogramaFinanceiroSaldoDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/recuperaSaldo';
$route['CronogramaFinanceiroObraDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/RecuperaObra';
$route['CronogramaFinanceiroVersaoDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/Recuperadadosversao';
$route['CronogramaFinanceiroInsereDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/insereCronogramaFinanceiroObra';
$route['CronogramaFinanceiroInsereVersaoDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/insereCronogramaFinanceiroObraVersao';
$route['CronogramaFinanceiroTrashavanDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/excluirAvanco';
$route['CronogramaFinanceiroGravaEditaDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/editarCronograma';
$route['CronogramaFinanceiroNpublicadoDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/RecuperaCronogramaAgrupado_naopublicado';
$route['CronogramaFinanceiroPublicadoDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/RecuperaCronogramaAgrupado_publicado';
$route['CronogramaFinanceiroContaNDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/ContaNaoPublicado';
$route['CronogramaFinanceiroServicoDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/recuperaServico';
$route['CronogramaFinanceiroTipoDaq'] = '/Supervisaodaq/Cronogramafinanceiroobra/Cronogramafinanceiroobractr/recuperaTipo';

$route['CronogramaFisicoObraDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/RecuperaObra';
$route['CronogramaFisicoServicoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/recuperaServico';
$route['CronogramaFisicoTipoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/recuperaTipo';
$route['CronogramaFisicoInsereDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/insereCronogramaFisico';
$route['CronogramaFisicoVPorcentDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/Validar_Porcentagem';
$route['CronogramaFisicoInsereNovoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/insereCronogramaFisicoNovo';
$route['CronogramaFisicoItemExcluiDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/excluirItem';
$route['CronogramaFisicoEixoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/recuperaEixo';
$route['CronogramaFisicoTotalDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/TotalServicoAquaviario';
$route['CronogramaFisicoRetornaServicoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/ServicosInseridosAquaviario';
$route['CronogramaFisicoRetornaItensDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/RetornaServiçosPreencher';
$route['CronogramaFisicoPublicadoNDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/CronogramaNaoPublicado';
$route['CronogramaFisicoPublicadoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/CronogramaPublicado';
$route['CronogramaFisicoDetalhadoNPDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/DetalhadoNaoPublicado';
$route['CronogramaFisicoDetalhadoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/DetalhadoPublicado';
$route['CronogramaFisicoContaDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/ContaNaoPublicado';
$route['CronogramaFisicoPublicarDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/PublicarCronograma_naopublicado';
$route['CronogramaFisicoGeoDaq'] = '/Supervisaodaq/Cronogramafisico/Cronogramafisicoctr/RecuperaGeorreferenciamento';

$route['AnaliseContratoDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/recuperaContrato';
$route['AnaliseConfirmarDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/confirmacaoAnalise';
$route['AnaliseVersaoDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/DadosVersaoRelatorioContratoDaq';
$route['AnaliseModulosDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/DadosModulosRelatorioDaq';
$route['AnaliseEditarDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/EditarAnalise';
$route['AnaliseInsereEditarDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/insere_editar_aceite';
$route['AnaliseHistoricoDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/recuperarHistoricoAnalises';
$route['AnaliseConclusaoDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/insereConclusao';
$route['AnalisePerfilDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/validarInserir';
$route['ConfereAnaliseDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/validarAprovar';

$route['ImpressaoRelatorioDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/returnRelatorioDaq';
$route['AnaliseExcluirDaq'] = '/Supervisaodaq/RelatorioSupervisao/Relatoriosupervisaoctr/ExcluirRetificado';

$route['RelatorioGraficoDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/curvasdaq';
$route['RelatorioResultadoDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/ResultadoElaboracaoRelatorioDaq';
$route['RelatorioConclusaoDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/ResultadoConclusaoRelatorioDaq';
$route['RelatorioTecnicaDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/ResultadoAnaliseTecnicaRelatorioDaq';
$route['RelatorioEstruturalDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/ResultadoAnaliseEstruturalRelatorioDaq';
$route['RelatorioImprimirDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/ResultadoImprimirRelatorioDaq';
$route['RelatorioVersaoDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/DadosVersaoRelatorioContratoDaq';
$route['RelatorioModulosDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/DadosModulosRelatorioDaq';
$route['RelatorioValidaDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/validaperfil';
$route['RelatorioFinalizarDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/finalizarelatoriodaq';
$route['RelatorioReciboDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/returnrecibodaq';
$route['RelatorioResultadoModalDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/ResultadoSupervisao';
$route['RelatorioElaboracaoDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/returnelaboracaodaq';
$route['RelatorioResultadoEstruturalDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/returnEstruturaldaq';
$route['RelatorioResultadoTecnicoDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/returnTecnicodaq';
$route['ReciboValidaDaq'] = '/Supervisaodaq/Relatorio/Relatorioctr/validaRecibodaq';

$route['gerencialSelectContratos'] = '/PainelGerencialdaq/PainelGerencialctr/buscarSelectContratos';
$route['gerencialSelectUf'] = '/PainelGerencialdaq/PainelGerencialctr/buscarSelectUf';
$route['gerencialObraContrato'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraContrato';
$route['gerencialObraResumoFinanceiro'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoFinanceiro';
$route['gerencialObraResumo'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumo';
$route['gerencialObraInserirResumo'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraInserirResumo';
$route['gerencialObraHidrovia'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraHidrovia';
$route['gerencialObraAmbiental'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraAmbiental';
$route['gerencialObraInterferencias'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraInterferencias';
$route['gerencialObraDadosFotos'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraDadosFotos';
$route['gerencialObraFotosPeriodo'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraFotosPeriodo';
$route['gerencialObraAditivos'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraAditivos';

$route['gerencialObraResumoFinanceiroGrafico'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoFinanceiroGrafico';
$route['gerencialObraResumoCurvaSGrafico'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoCurvaSGrafico';
$route['gerencialObraResumoCurvaSIDFinGrafico'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoCurvaSIDFinGrafico';
$route['painelgerencial_PainelIDFin'] = '/PainelGerencialdaq/PainelGerencialctr/RecuperaGrafIdfin';
$route['gerencialObraResumoCurvaSMedicaoGrafico'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoCurvaSMedicaoGrafico';
$route['painelgerencial_PainelMedicao'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelMedicoes';
$route['painelgerencial_PainelMedicaoSupervisora'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelMedicoesSupervisora';
$route['gerencialObraResumoCurvaSTabelaFisico'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoCurvaSTabelaFisico';
$route['gerencialObraResumoCurvaSTabelaFinanceiro'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoCurvaSTabelaFinanceiro';
$route['gerencialObraResumoCurvaSTabelaEmpenho'] = '/PainelGerencialdaq/PainelGerencialctr/gerencialObraResumoCurvaSTabelaEmpenho';
$route['painelgerencial_PainelEmpenhoRAP'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelEmpenhos';
$route['painelgerencial_PainelEmpenhoRAPSupervisora'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelEmpenhosSupervisora';
$route['painelgerencial_TablePainelEmpenhosSoma'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelEmpenhosSoma';
$route['painelgerencial_TablePainelEmpenhosSomaSupervisora'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelEmpenhosSomaSupervisora';
$route['painelgerencial_TablePainelRap'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelRap';
$route['painelgerencial_TablePainelRapSupervisora'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelRapSupervisora';
$route['painelgerencial_TablePainelRapSoma'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelRapSoma';
$route['painelgerencial_TablePainelRapSomaSupervisora'] = '/PainelGerencialdaq/PainelGerencialctr/TablePainelRapSomaSupervisora';


$route['gerencialSupervisaoDados'] = '/PainelGerencialdaq/PainelGerencialSupervisaoctr/gerencialSupervisaoDados';
$route['gerencialSupervisaoResumoFinanceiro'] = '/PainelGerencialdaq/PainelGerencialSupervisaoctr/gerencialSupervisaoResumoFinanceiro';
$route['gerencialSupervisaoAditivos'] = '/PainelGerencialdaq/PainelGerencialSupervisaoctr/gerencialSupervisaoAditivos';
$route['gerencialSupervisaoArt'] = '/PainelGerencialdaq/PainelGerencialSupervisaoctr/gerencialSupervisaoArt';
$route['gerencialSupervisaoResumoFinanceiroGrafico'] = '/PainelGerencialdaq/PainelGerencialSupervisaoctr/gerencialSupervisaoResumoFinanceiroGrafico';
$route['gerencialSupervisaoResumoCurvaSGrafico'] = '/PainelGerencialdaq/PainelGerencialSupervisaoctr/gerencialSupervisaoResumoCurvaSGrafico';

$route['painelAdmRecuperaPerfil'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfil/recuperaPerfil';
$route['painelAdmInserirPerfil'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfil/painelAdmInserirPerfil';
$route['painelAdmInserirTela'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfil/painelAdmInserirTela';
$route['painelAdmTelas'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfil/painelAdmTelas';
$route['painelAdmVincularPerfilTela'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfil/painelAdmVincularPerfilTela';
$route['painelAdmPopulaPerfil'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissao/populaPerfil';
$route['painelAdmRecuperaInfoUsuario'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissao/RecuperaInfoUsuario';
$route['painelAdmBuscaContratosUsuario'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissao/buscaContratosUsuario';
$route['painelAdmPopulaSupervisora'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissao/populaSupervisora';
$route['painelAdmAlteraPerfilPermissao'] = '/PainelAdm/AtualizaSupPerfilPermissao/AtualizaSupPerfilPermissao/alteraPerfilPermissao';

$route['AtividadeExecutoraInsereDaq'] = '/Supervisaodaq/AtividadesExecutora/AtividadesExecutora/insereAtividadeExecutora';
$route['AtividadeExecutoraRecuperaDaq'] = '/Supervisaodaq/AtividadesExecutora/AtividadesExecutora/recuperAtividadeExecutora';
$route['AtividadeExecutoraExcluirDaq'] = '/Supervisaodaq/AtividadesExecutora/AtividadesExecutora/excluirArquivo';

$route['baixarModelo'] = '/Supervisaodaq/Supervisaodaqctr/baixarModelo';

$route['DadosSegmentoInserirResumo'] = '/Supervisaodaq/DadosSegmento/DadosSegmento/insereResumo';
$route['DadosSegmentoRecuperaResumo'] = '/Supervisaodaq/DadosSegmento/DadosSegmento/recuperaResumo';
$route['DadosSegmentoModalStatus'] = '/Supervisaodaq/DadosSegmento/DadosSegmento/modalStatus';
$route['DadosSegmentoEditarResumo'] = '/Supervisaodaq/Historico/Historico/editarResumo';
$route['DadosSegmentoExcluirResumo'] = '/Supervisaodaq/DadosSegmento/DadosSegmento/excluirResumo';

$route['RecuperaSupervisora'] = '/PainelAdm/NovaSupervisora/NovaSupervisora/RecuperaSupervisora';
$route['insereNovasupervisora'] = '/PainelAdm/NovaSupervisora/NovaSupervisora/insereNovasupervisora';

$route['solicitacaoacesso_table_solicitacao_acesso'] = '/PainelAdm/Solitacaoacesso/SolitacaoAcesso/RecuperaSolicitacaoAcesso';
$route['solicitacaoacesso_insereUsuario'] = '/PainelAdm/Solitacaoacesso/SolitacaoAcesso/insereUsuario';
$route['solicitacaoacesso_'] = '/Supervisaodaq/AtividadesExecutora/AtividadesExecutora/excluirArquivo';
$route['solicitacaoacesso_negaSolicitacao'] = '/PainelAdm/Solitacaoacesso/SolitacaoAcesso/negaSolicitacao';

//--------------DAQ----------------------------------------------------------------------------------------------------
