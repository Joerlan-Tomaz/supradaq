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
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */

$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['cgmrr'] = 'homeCgmrr/HomeCgmrr';
$route['cgmrr/home'] = 'homeCgmrr/HomeCgmrr';
$route['cgmrr/relatorio-supervisao'] = 'homeCgmrr/RelatorioSupervisao';
$route['cgmrr/relatorio-supervisao/(:num)'] = 'homeCgmrr/RelatorioSupervisao/contrato/$1';
$route['cgmrr/relatorio-supervisao/configuracao-obra'] = 'homeCgmrr/RelatorioSupervisao/configuracaoObra';
$route['cgmrr/relatorio-supervisao/configuracao-obra/art'] = 'homeCgmrr/RelatorioSupervisao/art';
$route['cgmrr/relatorio-supervisao/configuracao-obra/art-download'] = 'homeCgmrr/Arquivo/arquivoART';


//arquivo boletim de desempenho
$route['cgmrr/relatorio-supervisao/configuracao-obra/boletim-desempenho'] = 'homeCgmrr/Arquivo/Modelo';
$route['cgmrr/relatorio-supervisao/configuracao-obra/eixo'] = 'homeCgmrr/RelatorioSupervisao/eixos';
$route['cgmrr/relatorio-supervisao/gera-excel-eixos'] = 'homeCgmrr/Arquivo/downloadEixos';
$route['cgmrr/relatorio-supervisao/resumo/checklist'] = 'homeCgmrr/Resumo/checklist';
$route['cgmrr/relatorio-supervisao/checklist/get-all-checklist'] = 'homeCgmrr/Resumo/getAllChecklist';
$route['cgmrr/relatorio-supervisao/checklist/get-checklist'] = 'homeCgmrr/Resumo/getChecklist';
$route['cgmrr/relatorio-supervisao/checklist/remove-checklist'] = 'homeCgmrr/Resumo/removeChecklist';
$route['cgmrr/relatorio-supervisao/resumo/avanco-fisico'] = 'homeCgmrr/Resumo/avancoFisico';
$route['cgmrr/relatorio-supervisao/consideracoes-tecnicas/resumo'] = 'homeCgmrr/ConsideracoesTecnicas/resumo';
$route['cgmrr/relatorio-supervisao/consideracoes-tecnicas/recursos-mobilizados'] = 'homeCgmrr/ConsideracoesTecnicas/recursosMobilizados';
$route['cgmrr/relatorio-supervisao/consideracoes-tecnicas/execucao-servicos'] = 'homeCgmrr/ConsideracoesTecnicas/execucaoServicos';
$route['cgmrr/relatorio-supervisao/consideracoes-tecnicas/instalacoes'] = 'homeCgmrr/ConsideracoesTecnicas/instalacoes';

$route['cgmrr/relatorio-supervisao/boletim-desempenho'] = 'homeCgmrr/MonitoramentoPadraoDesempenho/BoletimDesempenho';
$route['cgmrr/relatorio-supervisao/boletim-desempenho/modelo'] = 'homeCgmrr/Arquivo/Modelo';

$route['cgmrr/relatorio-supervisao/auditoria'] = 'homeCgmrr/MonitoramentoPadraoDesempenho/Auditoria';
// $route['cgmrr/relatorio-supervisao/cond-manutencao'] = 'homeCgmrr/MonitoramentoPadraoDesempenho/CondManutencao';
// $route['cgmrr/relatorio-supervisao/cond-pavimento'] = 'homeCgmrr/MonitoramentoPadraoDesempenho/CondPavimento';
$route['cgmrr/relatorio-supervisao/rnc'] = 'homeCgmrr/RegistrosNaoConformidade';
$route['cgmrr/relatorio-supervisao/rnc/resumo'] = 'homeCgmrr/RegistrosNaoConformidade/resumo';
$route['cgmrr/relatorio-supervisao/crema/rnc/get-historico'] = 'homeCgmrr/RegistrosNaoConformidade/getHistoricoRnc';
$route['cgmrr/relatorio-supervisao/crema/rnc/get-historico/(:num)'] = 'homeCgmrr/RegistrosNaoConformidade/getHistoricoRnc/$1';

$route['cgmrr/relatorio-supervisao/documentacao-fotografica/fotos-obra'] = 'homeCgmrr/DocumentacaoFotografica';
$route['cgmrr/relatorio-supervisao/documentacao-fotografica/adicionar-fotos'] = 'homeCgmrr/DocumentacaoFotografica/addFotos';
$route['cgmrr/relatorio-supervisao/documentacao-fotografica/adicionar-descricao'] = 'homeCgmrr/DocumentacaoFotografica/addDescricao';
$route['cgmrr/relatorio-supervisao/documentacao-fotografica/remover-foto'] = '/homeCgmrr/DocumentacaoFotografica/remover';
$route['cgmrr/relatorio-supervisao/crema/resumo'] = 'homeCgmrr/Crema/resumo';
$route['cgmrr/relatorio-supervisao/crema/condicao-pavimento'] = 'homeCgmrr/Crema/condicoesPavimentoCrema';
$route['cgmrr/relatorio-supervisao/crema/condicao-manutencao'] = 'homeCgmrr/Crema/condicoesManutencaoCrema';


//arquivo configuração obra boletim de desempenho
$route['cgmrr/relatorio-supervisao/crema/boletim-desempenho-recuperaBoletimDesempenho'] = 'homeCgmrr/Crema/recuperaBoletimDesempenho';

$route['cgmrr/relatorio-supervisao/controle-tecnologico/resumo'] = 'homeCgmrr/ControleTecnologico/resumo';
$route['cgmrr/relatorio-supervisao/controle-tecnologico/ensaios-laboratorio-obra'] = 'homeCgmrr/ControleTecnologico/ensaioLaboratorioObra';
$route['cgmrr/relatorio-supervisao/controle-tecnologico/ensaios-laboratorio-obra-laudo'] = 'homeCgmrr/ControleTecnologico/ensaioLaboratorioObraLaudo';
$route['cgmrr/relatorio-supervisao/controle-tecnologico/ensaios-laboratorio-supervisao'] = 'homeCgmrr/ControleTecnologico/ensaioLaboratorioSupervisao';
$route['cgmrr/relatorio-supervisao/controle-tecnologico/ensaios-laboratorio-supervisao-laudo'] = 'homeCgmrr/ControleTecnologico/ensaioLaboratorioSupervisaoLaudo';
$route['cgmrr/relatorio-supervisao/anexos/docs-recebidos'] = 'homeCgmrr/Anexos/DocumentosRecebidos';
$route['cgmrr/relatorio-supervisao/anexos/docs-emitidos'] = 'homeCgmrr/Anexos/DocumentosEmitidos';
$route['cgmrr/relatorio-supervisao/termo-encerramento'] = 'homeCgmrr/TermoEncerramento/index';
$route['cgmrr/relatorio-supervisao/imprimir'] = 'homeCgmrr/Encerramento/index';
$route['cgmrr/relatorio-supervisao/home'] = 'homeCgmrr/relatorioSupervisao/index';
$route['cgmrr/relatorio-supervisao/panela-remendo'] = 'homeCgmrr/Crema/panela_remendo';
$route['cgmrr/relatorio-supervisao/imprimirRelatorio'] = "/homeCgmrr/Encerramento/imprimirMin";
$route['cgmrr/relatorio-supervisao/resultado-Analise/estrutural'] = "/homeCgmrr/Encerramento/resultadoAnalise/estrutural";
$route['cgmrr/relatorio-supervisao/resultado-Analise/tecnica'] = "/homeCgmrr/Encerramento/resultadoAnalise/tecnica";

$route['cgmrr/paineis-gerenciais'] = 'homeCgmrr/Supervisaocgmrr/PainelGerencial/Painelgerencial/index';
$route['cgmrr/paineis-gerenciais/painelgerencial'] = '/homeCgmrr/Supervisaocgmrr/Supervisaomrrctr/PainelGerencial';
$route['cgmrr/paineis-gerenciais/getContratosAll'] = '/homeCgmrr/Supervisaocgmrr/PainelGerencial/Painelgerencial/getContratosAll';

$route['cgmrr/analise'] = "/homeCgmrr/AnaliseRelatorio/Analise";
$route['cgmrr/analise/finalizar'] = "/homeCgmrr/AnaliseRelatorio/Analise/finalizarRelatorio";
$route['cgmrr/analise/adicionar-status'] = "/homeCgmrr/AnaliseRelatorio/Analise/addStatus";
$route['cgmrr/analise/home'] = "homeCgmrr/AnaliseRelatorio/Home";
$route['cgmrr/analise-relatorio/crema/get-historico-contexto'] = "homeCgmrr/AnaliseRelatorio/Home/getHistoricoContexto";
$route['cgmrr/analise-relatorio/crema/set-periodo-referencia'] = "homeCgmrr/AnaliseRelatorio/Home/setPeriodoReferenciaAnalise";
$route['cgmrr/analise-relatorio/crema/reabrir-relatorio'] = "homeCgmrr/AnaliseRelatorio/Analise/reabrirRelatorio";



$route['cgmrr/sistema/perfis'] = "homeCgmrr/Sistema/Perfis";
$route['cgmrr/sistema/contratos'] = "homeCgmrr/Sistema/Contratos";
$route['cgmrr/sistema/submodulos'] = "homeCgmrr/Sistema/HomeSistema/subModulos";
$route['cgmrr/sistema/usuarios'] = "homeCgmrr/Sistema/Usuarios";
$route['cgmrr/sistema/home'] = "homeCgmrr/Sistema/HomeSistema";
$route['cgmrr/sistema/gruposcontratos'] = "homeCgmrr/Sistema/Contratos/gruposContratos";
$route['cgmrr/sistema/gruposcontratos/(:num)'] = 'homeCgmrr/Sistema/Contratos/gruposContratos/$1';
$route['cgmrr/sistema/contratos'] = "homeCgmrr/Sistema/Contratos";
$route['cgmrr/sistema/contratos/get-contratos'] = "homeCgmrr/Sistema/Contratos/getContratos";
$route['cgmrr/sistema/contratos/get-grupo-contratos'] = "homeCgmrr/Sistema/Contratos/getGruposContratos";
$route['cgmrr/sistema/contratos/get-grupo-contratos/(:num)'] = "homeCgmrr/Sistema/Contratos/getGruposContratos/$1";
$route['cgmrr/sistema/contratos/get-vinculo-grupo'] = "homeCgmrr/Sistema/Contratos/getVinculoGrupo";
$route['cgmrr/sistema/contratos/get-vinculo-contrato/(:num)'] = "homeCgmrr/Sistema/Contratos/getVinculoContrato/$1";
$route['cgmrr/sistema/contratos/get-usuarios/(:num)'] = "homeCgmrr/Sistema/Contratos/getUsuarios/$1";
$route['cgmrr/sistema/contratos/add-grupo'] = "homeCgmrr/Sistema/Contratos/addGrupo";
$route['cgmrr/sistema/contratos/set-usuario'] = "homeCgmrr/Sistema/Contratos/setUsuario";
$route['cgmrr/sistema/contratos/remove-usuario'] = "homeCgmrr/Sistema/Contratos/removeUsuario";
$route['cgmrr/sistema/contratos/save-contrato'] = "homeCgmrr/Sistema/Contratos/setContrato";

$route['cgmrr/configuracoes/reabrir-contrato'] = "homeCgmrr/ConfiguracoesCgmrr/ReabrirConfiguracaoObra";
$route['cgmrr/configuracoes/restart-pass'] = "homeCgmrr/ConfiguracoesCgmrr/ResetarSenhaTemporariamente";
$route['cgmrr/configuracoes/restart-pass/(:num)'] = "homeCgmrr/ConfiguracoesCgmrr/ResetarSenhaTemporariamente/$1";


$route['cgmrr/rnc/problemas-e-tipos'] = 'homeCgmrr/RegistrosNaoConformidade/getProblemasAndTipos';

////////////////////////////
//////////////////////////// WS
////////////////////////////
//////////
// CGMRR
//////////
//  Gerais
$route['cgmrr/getcontratos_ws'] = 'homeCgmrr/RelatorioSupervisao/getContratos_ws';
$route['cgmrr/getcontratosandeixos_ws'] = 'homeCgmrr/RelatorioSupervisao/getContratosAndEixos_ws';

//  RNC
$route['cgmrr/rnc/problemas-e-tipos_ws'] = 'homeCgmrr/RegistrosNaoConformidade/getProblemasAndTipos_ws';
$route['cgmrr/rnc/addrnc_ws'] = 'homeCgmrr/RegistrosNaoConformidade/addRnc_ws';
$route['cgmrr/rnc/addstatus_ws'] = 'homeCgmrr/RegistrosNaoConformidade/addStatus_ws';
$route['cgmrr/rnc/getallHistoricornc_ws'] = 'homeCgmrr/RegistrosNaoConformidade/getAllHistoricoRnc_ws';
$route['cgmrr/rnc/getoptionsstatusrnc_ws'] = 'homeCgmrr/RegistrosNaoConformidade/getOptionsStatusRnc_ws';
//  Avanço Físico
$route['cgmrr/avancofisico/getsolucoes_ws'] = 'homeCgmrr/Resumo/getSolucoes_ws';
$route['cgmrr/avancofisico/addavancofisico_ws'] = 'homeCgmrr/Resumo/addAvancoFisico_ws';
$route['cgmrr/avancofisico/getavancofisico_ws'] = 'homeCgmrr/Resumo/getAllAvancoFisico_ws';


//Atlas CGMRR
$route['atlas_ObterAtlas'] = 'homeCgmrr/Atlas/Atlas/ObterAtlas';




/////////////
/////IMR
////////////


// Usuário
$route['imr/usuario/combo_contrato']          = 'homeImr/UsuarioImr/comboContrato';
$route['imr/usuario/combo_nivel_cargo']       = 'homeImr/UsuarioImr/comboNivelCargo';
$route['imr/usuario/combo_cargo']             = 'homeImr/UsuarioImr/comboCargo';
$route['imr/usuario/combo_empresa']           = 'homeImr/UsuarioImr/comboEmpresa';
$route['imr/usuario/editar_usuario']          = 'homeImr/UsuarioImr/dadosUsuario';
$route['imr/usuario/adicionar_usuario']       = 'homeImr/UsuarioImr/inserirUsuario';
$route['imr/usuario/busca_dados_usuario']     = 'homeImr/UsuarioImr/dadosUsuario';
$route['imr/usuario/combo_usuario']           = 'homeImr/UsuarioImr/comboUsuario';

// Relatório
$route['imr/relatorio/listar_relatorios']     = 'homeImr/RelatorioImr/listagemTodosRelatorios';
$route['imr/relatorio/editar_tarefa']         = 'homeImr/RelatorioImr/editarTarefa';
$route['imr/relatorio/editar_atividade']      = 'homeImr/RelatorioImr/editarAtividade';
$route['imr/relatorio/excluir_tarefa']        = 'homeImr/RelatorioImr/excluirTarefa';
$route['imr/relatorio/excluir_atividade']     = 'homeImr/RelatorioImr/excluirAtividade';
$route['imr/relatorio/detalhar_tarefas']      = 'homeImr/RelatorioImr/detalheTarefas';
$route['imr/relatorio/detalhar_atividades']   = 'homeImr/RelatorioImr/detalheAtividades';
$route['imr/relatorio/cadastro_tarefa']       = 'homeImr/RelatorioImr/cadastroTarefa';
$route['imr/relatorio/cadastro_atividade']    = 'homeImr/RelatorioImr/cadastroAtividade';
$route['imr/relatorio/combo_resultado']       = 'homeImr/RelatorioImr/comboResultado';


// Analisar 
$route['imr/analise/adicionar_status']        = 'homeImr/AnalisarImr/AdicionarStatus';
$route['imr/analise/finalizar_analise']       = 'homeImr/AnalisarImr/finalizarAnalise';
$route['imr/analise/listar_relatorios']       = 'homeImr/AnalisarImr/listagemTodosRelatoriosAnalisar';
$route['imr/validar/preenche_atividade']      = 'homeImr/AnalisarImr/buscaAtividade';
$route['imr/validar/finalizar_preencher']     = 'homeImr/AnalisarImr/FinalizarAnalisePreencher';


/////////////
/////FIM IMR
////////////


//////////
// CGCONT
//////////
//  CGPLAN
$route['cgcont/dadosgerais/cgplan/recupera_contratos_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaContratoWs';
$route['cgcont/dadosgerais/cgplan/recupera_localizacao_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaLocalizacaoWs';
$route['cgcont/dadosgerais/cgplan/recupera_cronograma_fisico_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaCronogramaFisicoWs';
$route['cgcont/dadosgerais/cgplan/recupera_avanco_fisico_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaAvancoFisicoWs';
$route['cgcont/dadosgerais/cgplan/recupera_cronograma_financeiro_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaCronogramaFinanceiroWs';
$route['cgcont/dadosgerais/cgplan/recupera_avanco_financeiro_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaAvancoFinanceiroWs';
$route['cgcont/dadosgerais/cgplan/recupera_medicao_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaMedicaoWs';
$route['cgcont/dadosgerais/cgplan/recupera_empenho_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaEmpenhoWs';
$route['cgcont/dadosgerais/cgplan/recupera_idfin_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaIdfnWs';
$route['cgcont/dadosgerais/cgplan/recupera_aditivo_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaAditivoWs';
$route['cgcont/dadosgerais/cgplan/recupera_profissionais_supervisoras_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaProfissionaisSupervisoraWs';
$route['cgcont/dadosgerais/cgplan/recupera_equipamentos_supervisoras_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaEquipamentosSupervisoraWs';
$route['cgcont/dadosgerais/cgplan/recupera_profissionais_obras_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaProfissionaisObraWs';
$route['cgcont/dadosgerais/cgplan/recupera_equipamentos_obras_ws'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt_ws/RecuperaEquipamentosObraWs';



//  Avanço Físico
$route['cgcont/avancofisico/obra/inserir_avancofisico_obra_ws'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr_ws/insere_avancofisico_obra_ws';
$route['cgcont/avancofisico/obra/recupera_avanco_ws'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr_ws/Recupera_avanco_ws';
$route['cgcont/avancofisico/obra/recupera_eixo_ws'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr_ws/Recupera_eixo_ws';
$route['cgcont/avancofisico/obra/recupera_status_ws'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr_ws/Recupera_status_ws';
$route['cgcont/avancofisico/obra/recupera_servico_ws'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr_ws/Recupera_servico_ws';
$route['cgcont/avancofisico/obra/recupera_lado_ws'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr_ws/Recupera_lado_ws';
$route['cgcont/avancofisico/obra/recuperar_todos_atributos'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr_ws/Recuperar_atributos_avanco_fisico_ws';

//  RNC
$route['cgcont/rnc/addstatus_ws'] = 'homeCgcont/Supervisaocont/RNC/RNC_ws/insereAcompanhamentoProvidencia';
$route['cgcont/rnc/addrnc_ws'] = 'homeCgcont/Supervisaocont/RNC/RNC_ws/insereRnc';
$route['cgcont/rnc/getallHistoricornc_ws'] = 'homeCgcont/Supervisaocont/RNC/RNC_ws/recuperaRNCws';
$route['cgcont/rnc/getoptionsstatusrnc_ws'] = 'homeCgcont/Supervisaocont/RNC/RNC_ws/statusRnc';
$route['cgcont/rnc/problemas-e-tipos_ws'] = 'homeCgcont/Supervisaocont/RNC/RNC_ws/getProblemasAndTipos_ws';

//  Risco e Interferencias
$route['cgcont/riscoInterferencia/getoptionsstatusriscos_ws'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia_ws/statusRiscoInterferencia';
$route['cgcont/riscoInterferencia/inserir_risco_interferencia_ws'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia_ws/insereInterferencia';

//  Documentação Fotográfica
$route['cgcont/documentacaoFotografica/insereDocumentacaoFotografica'] = 'homeCgcont/Supervisaocont/DocumentacaoFotografica/DocumentacaoFotografica_ws/insereDocFotografico';

//  Gestão de Tratativa
$route['cgcont/gestaoTratativa/getOrigemResponsavel'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa_ws/origemResponsavel';
$route['cgcont/gestaoTratativa/inserir_gestao_tratativa_ws'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa_ws/insereGestaoTratativa';
$route['cgcont/gestaoTratativa/getallGestaoTratativa'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa_ws/recuperaGestaoTratativa';
$route['cgcont/gestaoTratativa/inserir_providencia'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa_ws/insereProvidencia';
$route['cgcont/administracao'] = '/homeCgcont/HomeCgcont/homeAdministracao';

//  Diagrama Unifilar 3D
$route['cgcont/unifilar3d/gerar'] = '/homeCgcont/Unifilar3D/Unifilar3D/MontarDiagramaUnifilar_ws';
//$route['cgcont/unifilar3d/eixo'] = '/homeCgcont/Unifilar3D/Unifilar3D/RecuperaEixo';

//############################################################################## 
//# INICIO
//# DNIT
//# Rotas CGCONT
//# Desenvolvedor:Sergio Ricardo 
//# Data:01/10/2018 13:49
//# 
//############################################################################## 
//Imprimir Relatório
//imprimirrelatorioView.js
$route['imprimir_rotaImprimirRelatorio'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/ImprimirRelatorio';
$route['imprimir_RecuperaAnalise'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaAnalise';
$route['imprimir_HistoricoAnaliseEstruturada'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaHistoricoAnaliseEstruturada';
$route['imprimir_HistoricoAnaliseTecnica'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaHistoricoAnaliseTecnica';
$route['imprimir_elaboracao'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_elaboracao';
$route['imprimir_conclusao'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_elaboracao';
$route['imprimir_analisetecnica'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_analise_tecnica';
$route['imprimir_analiseestrutural'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_analise_estrutural';
$route['imprimir_imprimir'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_imprimir';
$route['imprimir_dadosContrato'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaDadosContratoVersaoRelatorio';
$route['imprimir_aguardandoanalise'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Aguardandoanalise';
$route['imprimir_Concluirrelatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Concluirrelatorio';
$route['imprimir_GerarResultadoEstrutural'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaHistoricoAnalise';
$route['imprimir_GerarResultadoTecnico'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaHistoricoAnalise';
$route['imprimir_Liberarrelatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Liberarrelatorio';
$route['imprimir_dadosRelatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaRelatorio';
$route['imprimir_Recupera_roteiro'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_roteiro';
$route['imprimir_GerarRecibo'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_valida_recibo';
$route['imprimir_Recupera_valida_liberar_relatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/Recupera_valida_liberar_relatorio';
//Relatório Versão 1 do Supra
$route['imprimir_rotaImprimirRelatorioAntigo'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/ImprimirRelatorioAntigo';
$route['imprimir_antigo_RecuperaAnalise'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/RecuperaAnalise';
$route['imprimir_antigo_HistoricoAnaliseEstruturada'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/RecuperaHistoricoAnaliseEstruturada';
$route['imprimir_antigo_HistoricoAnaliseTecnica'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/RecuperaHistoricoAnaliseTecnica';
$route['imprimir_antigo_elaboracao'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_elaboracao';
$route['imprimir_antigo_conclusao'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_elaboracao';
$route['imprimir_antigo_analisetecnica'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_analise_tecnica';
$route['imprimir_antigo_analiseestrutural'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_analise_estrutural';
$route['imprimir_antigo_imprimir'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_imprimir';
$route['imprimir_antigo_dadosContrato'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/RecuperaDadosContratoVersaoRelatorio';
$route['imprimir_antigo_aguardandoanalise'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Aguardandoanalise';
$route['imprimir_antigo_Concluirrelatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Concluirrelatorio';
$route['imprimir_antigo_GerarResultadoEstrutural'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/RecuperaHistoricoAnalise';
$route['imprimir_antigo_GerarResultadoTecnico'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/RecuperaHistoricoAnalise';
$route['imprimir_antigo_Liberarrelatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Liberarrelatorio';
$route['imprimir_antigo_dadosRelatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/RecuperaRelatorio';
$route['imprimir_antigo_Recupera_roteiro'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_roteiro';
$route['imprimir_antigo_GerarRecibo'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_valida_recibo';
$route['imprimir_antigo_Recupera_valida_liberar_relatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioantigoctr/Recupera_valida_liberar_relatorio';

################################################################################
//RELATÓRIO DE SUPERVISÃO DE OBRAS
//relatoriosupervisaoview.js
$route['Recupera_curve_chart'] = '/homeCgcont/Supervisaocont/Relatorio/Relatorioctr/RecuperaCurvaS';
################################################################################
//ANÁLISE DE RELATÓRIOS
//anliserelatorio.js
$route['RecuperaContratoAnalise'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/RecuperaContratoAnalise';
$route['Redireciona_inicio_analise'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/grava_inicio_analise';
$route['dadosContrato'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/RecuperaDadosContratoVersaoRelatorio';
$route['dadosRelatorio'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/RecuperaDadosAnalise';
$route['btnGravarAceite'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/grava_nao_aceite';
$route['RecuperaHistorico'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/RecuperaHistorico';
$route['AbreModalEditarAnalise'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/Recupera_motivo';
$route['btnAlteraAceite'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/Altera_aceite';
$route['Redireciona_excluir_analise'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/Exclui_aceite';
$route['btnGravarSatisfacao'] = 'homeCgcont/AnaliseRelatorio/Analiserelatorioctr/Concluiranalise';

################################################################################
//Avanço Físico de Pista
$route['avancofisico_rotaAvancoFisicoPista'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/AvancoFisicoPista';
$route['avancofisico_tableAvancoFisico'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_avanco_trecho_atacado';
$route['avancofisico_tableAvancoFisicoConcluidos'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_avanco_trecho_concluido';
$route['avancofisico_table_naohouveatividademes'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_naohouveatividademes';
$route['avancofisico_table_naohouveatividademes_table'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_naohouveatividademes';
$route['avancofisico_modalExecutado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/RecuperaPeriodo';
$route['avancofisico_tableExecutados'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/recupera_km_executado';
$route['avancofisico_modalVisualizarExecutado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/recupera_km_executado';
$route['avancofisico_modalVisualizarExecutadoConcluido'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/recupera_km_executado_concluido';
$route['avancofisico_insereavancofisicoexecutado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/insere_avancofisico_obra_executado';
$route['avancofisico_btnInclusao'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_eixo';
$route['avancofisico_eixo'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_servico';
$route['avancofisico_status'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_avanco_atacado';
$route['avancofisico_RecuperaAtacado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/RecuperaAtacado';
$route['avancofisico_insereAvancoFisicoObra_RecuperaAtacado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/RecuperaAtacado';
$route['avancofisico_insereAvancoFisicoObra'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/insere_avancofisico_obra';
$route['avancofisico_btnNoAtividade'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/insere_naohouveatividademes';
$route['avancofisico_verificaKMAtacado'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr/verificaKM';
$route['avancofisico_NaoPublicarExecutado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/NaoPublicarExecutado';
$route['avancofisico_ExcluirExecutado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/NaoPublicarExecutado';
$route['avancofisico_ExcluirExecutadoConcluido'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/NaoPublicarExecutado';
$route['avancofisico_NaoPublicar_RecuperaExecutado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/RecuperaExecutado';
$route['avancofisico_NaoPublicar_NaoPublicar'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/NaoPublicar';
$route['avancofisico_excluirNaoHouveAtividadeMes'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/NaoPublicarAtividade';
$route['avancofisico_insereavancofisicoexecutadoanterior_RecuperaAtacado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/RecuperaAtacado';
$route['avancofisico_insereavancofisicoexecutadoanterior_insere_avancofisico_obra_executado_anterior'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/insere_avancofisico_obra_executado_anterior';
$route['avancofisico_NaoPublicarContratoAnterior'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/NaoPublicarContratoAnterior';
$route['avancofisico_tableAvancoFisicoContratoAnterior_Recupera_avanco_trecho_concluido_contrato_anterior'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_avanco_trecho_concluido_contrato_anterior';
$route['avancofisico_tableAvancoFisicoContratoAnterior_Recupera_avanco_trecho_concluido_contrato_anterior_Recupera_avanco_trecho_concluido_contrato_anterior'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/Recupera_avanco_trecho_concluido_contrato_anterior';
$route['avancofisico_RecuperaTotalExecutado'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/RecuperaTotalExecutado';
$route['avancofisico_RecuperaNomeApelido'] = 'homeCgcont/Supervisaocont/Avancofisicopista/Avancofisicopistactr/RecuperaNomeApelido';
################################################################################
//justificativaempreendimentoView.js
$route['justificativaempreendimento_insereJustificativa'] = 'homeCgcont/Supervisaocont/JustificativaEmpreendimentos/JustificativaEmpreendimentos/insereResumo';
$route['justificativaempreendimento_btnVoltar'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/retornaConfiguracao';
$route['justificativaempreendimento_recuperaJustificativa'] = 'homeCgcont/Supervisaocont/JustificativaEmpreendimentos/JustificativaEmpreendimentos/recuperaJustificativa';
$route['justificativaempreendimento_excluirJustificativa'] = 'homeCgcont/Supervisaocont/JustificativaEmpreendimentos/JustificativaEmpreendimentos/excluirResumo';
$route['justificativaempreendimento_editarJustificativa'] = 'homeCgcont/Supervisaocont/JustificativaEmpreendimentos/JustificativaEmpreendimentos/editarResumo';
################################################################################
//Gestão de Tratativas
$route['recuperaGestaoTratativa_rotaGestaoTratativa'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/GestaoTratativa';
$route['recuperaGestaoTratativa_insereJustificativa'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/recuperaGestaoTratativa';
$route['recuperaGestaoTratativa_excluirGestaoTratativa'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/excluirGestaoTratativa';
$route['recuperaGestaoTratativa_populaOrigem'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/populaOrigem';
$route['recuperaGestaoTratativa_populaOrigemEditar'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/populaOrigemEditar';
$route['recuperaGestaoTratativa_populaResponsaveis'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/populaResponsaveis';
$route['recuperaGestaoTratativa_populaResponsaveisEditar'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/populaResponsaveisEditar';
$route['recuperaGestaoTratativa_modalStatus'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/modalStatus';
$route['recuperaGestaoTratativa_modalSituacao'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/recuperaProvidencia';
$route['recuperaGestaoTratativa_excluirProvidencia'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/excluirProvidencia';
$route['recuperaGestaoTratativa_insereProvidencia'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/insereProvidencia';
$route['recuperaGestaoTratativa_editarGestaoTratativa'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/RecuperaeditarGestaoTratativa';
$route['recuperaGestaoTratativa_editar'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/editar';
$route['recuperaGestaoTratativa_insereGestaoTratativa'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/insereGestaoTratativa';
$route['recuperaGestaoTratativa_Habilitabtnatividade'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/Habilitabtnatividade';
$route['recuperaGestaoTratativa_btnNoAtividade'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/insereNaoAtividade';
$route['recuperaGestaoTratativa_table_naohouveatividademes'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/Recupera_naohouveatividademes';
$route['recuperaGestaoTratativa_excluirNaoHouveAtividadeMes'] = 'homeCgcont/Supervisaocont/GestaoTratativa/GestaoTratativa/NaoPublicarAtividade';
################################################################################
//historicoView.js
$route['historico_insereHistorico'] = 'homeCgcont/Supervisaocont/Historico/Historico/insereResumo';
$route['historico_btnNoAtividade'] = 'homeCgcont/Supervisaocont/Historico/Historico/insereNaoAtividade';
$route['historico_recuperaHistoricoObra'] = 'homeCgcont/Supervisaocont/Historico/Historico/recuperaResumo';
$route['historico_editarResumo'] = 'homeCgcont/Supervisaocont/Historico/Historico/editarResumo';
$route['historico_excluirHistorico'] = 'homeCgcont/Supervisaocont/Historico/Historico/excluirResumo';
$route['historico_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/Historico/Historico/recuperaResumo';
$route['historico_btnRecuperaUltimo'] = 'homeCgcont/Supervisaocont/Historico/Historico/RecuperaUltimo';
################################################################################
#Análise Crítica Crong.
//atividadescriticasView.js
$route['atividadescriticas_insereAtividadesCriticas'] = 'homeCgcont/Supervisaocont/AtividadesCriticas/AtividadesCriticas/insereAtividadeCritica';
$route['atividadescriticas_excluirAtividadesCriticas'] = 'homeCgcont/Supervisaocont/AtividadesCriticas/AtividadesCriticas/excluirResumo';
$route['atividadescriticas_recuperaAtividadesCriticas'] = 'homeCgcont/Supervisaocont/AtividadesCriticas/AtividadesCriticas/RecuperaAtividadesCriticas';
$route['atividadescriticas_editarAtividadesCriticas'] = 'homeCgcont/Supervisaocont/AtividadesCriticas/AtividadesCriticas/editarResumo';
$route['atividadescriticas_btnRecuperaUltimo'] = 'homeCgcont/Supervisaocont/AtividadesCriticas/AtividadesCriticas/RecuperaUltimo';
################################################################################
#Gestão Jurídica.
//gestaojuridicaView.js
$route['gestaojuridica_btnNoAtividade'] = 'homeCgcont/Supervisaocont/LicencasAmbientais/LicencasAmbientais/insereNaoAtividade';
$route['gestaojuridica_fileUploadanexo'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/insereAnexo';
$route['gestaojuridica_recuperagestao'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/recuperagestao';
$route['gestaojuridica_excluirArquivo'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/excluirArquivo';
$route['gestaojuridica_excluir'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/excluir';
$route['gestaojuridica_RecuperaGestaoEditar'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/RecuperagestaoEditar';
$route['gestaojuridica_RecuperaLicencaDetalhar'] = 'homeCgcont/Supervisaocont/LicencasAmbientais/LicencasAmbientais/RecuperaLicencaEditar';
$route['gestaojuridica_editarGestao'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/editargestao';
$route['gestaojuridica_populaTipoLicenca'] = 'homeCgcont/Supervisaocont/LicencasAmbientais/LicencasAmbientais/populaTipoLicenca';
$route['gestaojuridica_populaTipoLicencaEditar'] = 'homeCgcont/Supervisaocont/LicencasAmbientais/LicencasAmbientais/populaTipoLicenca';
$route['gestaojuridica_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/LicencasAmbientais/LicencasAmbientais/recuperaLicencasAmbientais';
$route['gestaojuridica_uploadArquivo'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/recuperaAnexo';
$route['gestaojuridica_inseregestao'] = 'homeCgcont/Supervisaocont/GestaoJuridica/Gestaojuridicacrt/inseregestaojuridica';
################################################################################
#Atas e Correspondências.
//atascorrespondenciasView.js
$route['atascorrespondencias_insereAtasCorrespondencias'] = 'homeCgcont/Supervisaocont/AtasCorrespondencia/AtasCorrespondencia/insereAtasCorrespondencias';
$route['atascorrespondencias_recuperaAtaCorrespondencia'] = 'homeCgcont/Supervisaocont/AtasCorrespondencia/AtasCorrespondencia/recuperaAtasCorrespondencias';
$route['atascorrespondencias_excluirArquivo'] = 'homeCgcont/Supervisaocont/AtasCorrespondencia/AtasCorrespondencia/excluirArquivo';
$route['atascorrespondencias_table_naohouveatividademes'] = 'homeCgcont/Supervisaocont/AtasCorrespondencia/AtasCorrespondencia/Recupera_naohouveatividademes';
$route['atascorrespondencias_Recupera_naohouveatividademes'] = 'homeCgcont/Supervisaocont/AtasCorrespondencia/AtasCorrespondencia/Recupera_naohouveatividademes';
$route['atascorrespondencias_excluirNaoHouveAtividadeMes'] = 'homeCgcont/Supervisaocont/AtasCorrespondencia/AtasCorrespondencia/NaoPublicar';
$route['atascorrespondencias_btnNoAtividade'] = 'homeCgcont/Supervisaocont/AtasCorrespondencia/AtasCorrespondencia/insere_naohouveatividademes';
################################################################################
#avanço OAE.
//avancofisicooaeView.js
$route['avancofisicooae_verificaCronograma'] = 'homeCgcont/Supervisaocont/Cronogramafisicooae/Cronogramafisicooaectr/recuperarCronograma';
$route['avancofisicooae_tableDetalhesCronograma'] = 'homeCgcont/Supervisaocont/Cronogramafisicooae/Cronogramafisicooaectr/recuperarCronograma';
$route['avancofisicooae_pesquisaOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_config_oae';
$route['avancofisicooae_populaTipoOAE'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_tipo_oae';
$route['avancofisicooae_Recupera_config_oae'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_config_oae';
$route['avancofisicooae_Recupera_avanco_acumulado'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_avanco_acumulado';
$route['avancofisicooae_Recupera_avanco_acumulado_previsto'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_avanco_acumulado_previsto';
$route['avancofisicooae_Recupera_oae'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_oae';
$route['avancofisicooae_Recupera_oae_tunel'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_oae_tunel';
$route['avancofisicooae_Recupera_oae_tunel_2'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_oae_tunel';
$route['avancofisicooae_Recupera_avanco_trecho'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_avanco_trecho';
$route['avancofisicooae_excluirOAE'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/NaoPublicar';
$route['avancofisicooae_excluirOAEtunel'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/NaoPublicarTunel';
$route['avancofisicooae_excluirNaoHouveAtividadeMes'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/NaoPublicar';
$route['avancofisicooae_insereAvancoFisicoOae'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_avanco_acumulado';
$route['avancofisicooae_insereAvancoFisicoOae_2'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/insere_avancofisico_oae';
$route['avancofisicooae_insereAvancoFisicoOaeTunel'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/insere_avancofisico_oae_tunel';
$route['avancofisicooae_btnNoAtividade'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/insere_naohouveatividademes';
$route['avancofisicooae_table_naohouveatividademes'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_naohouveatividademes';
$route['avancofisicooae_table_naohouveatividademes_2'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_naohouveatividademes';
$route['avancofisicooae_Recupera_dados_trecho'] = 'homeCgcont/Supervisaocont/Avancofisicooae/Avancofisicooaectr/Recupera_dados_trecho';
$route['avancofisicooae_OAEConst'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelOAEConst';
################################################################################
#Controle Pluviométrico.
//controlepluviometricoView.js
$route['controlepluviometrico_insereControlePluviometrico'] = 'homeCgcont/Supervisaocont/ControlePluviometrico/ControlePluviometrico/insereControlePluv';
$route['controlepluviometrico_recuperaControlePluv'] = 'homeCgcont/Supervisaocont/ControlePluviometrico/ControlePluviometrico/recuperaControlePluv';
$route['controlepluviometrico_excluirDia'] = 'homeCgcont/Supervisaocont/ControlePluviometrico/ControlePluviometrico/excluirDia';
$route['controlepluviometrico_Recuperadiasmes'] = 'homeCgcont/Supervisaocont/ControlePluviometrico/ControlePluviometrico/Recuperadiasmes';
################################################################################
#RPFO

$route['rpfo_buscaRevisao'] = 'homeCgcont/Rpfo/HomeRpfo/buscaRevisao';
$route['rpfo_recuperaTabelaContrato'] = 'homeCgcont/Rpfo/HomeRpfo/recuperaTabelaContrato';
$route['rpfo_recuperaOptionsContrato'] = 'homeCgcont/Rpfo/HomeRpfo/recuperaOptionsContrato';
$route['rpfo_buscaContratos'] = 'homeCgcont/Rpfo/HomeRpfo/buscaContratos';
$route['rpfo_buscaContratoId'] = 'homeCgcont/Rpfo/HomeRpfo/buscaContratoId';
$route['rpfo_insereContratoSessao'] = 'homeCgcont/Rpfo/HomeRpfo/insereContratoSessao';
$route['rpfo_recuperaRpfo'] = 'homeCgcont/Rpfo/HomeRpfo/recuperaRpfo';
$route['rpfo_buscaHistorico'] = 'homeCgcont/Rpfo/HomeRpfo/buscaHistorico';
$route['rpfo_consultaValorTotal'] = 'homeCgcont/Rpfo/HomeRpfo/consultaValorTotal';
$route['rpfo_consultarAbaProcedimento'] = 'homeCgcont/Rpfo/HomeRpfo/consultarAbaProcedimento';
$route['rpfo_populaFaseRevisao'] = 'homeCgcont/Rpfo/HomeRpfo/populaFaseRevisao';

$route['rpfo_confereConfiguracao'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/confereConfiguracao';
$route['rpfo_limpaIdRevisaoSessao'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/limpaIdRevisaoSessao';
$route['rpfo_buscaRevisaoPlanilhaServico'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/buscaRevisaoPlanilhaServico';
$route['rpfo_consultaItensDisciplinasPlanServico'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/consultaItensDisciplinasPlanServico';
$route['rpfo_consultaDisciplinasRevisaoConfig'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/consultaDisciplinasRevisaoConfig';
$route['rpfo_consultaValorDisciplinasConfig'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/consultaValorDisciplinas';
$route['rpfo_consultaAreaExploracaoConfig'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/consultaAreaExploracao';
$route['rpfo_insereRevisaoConfg'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/insereRevisaoConfg';
$route['rpfo_buscaRevisaoHistorico'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/buscaRevisaoHistorico';
$route['rpfo_consultaDisciplinasContratoConfig'] = 'homeCgcont/Rpfo/Configuracao/Configuracaoctr/consultaDisciplinasContratoConfig';

$route['rpfo_consultaStatusFaseRPFO'] = 'homeCgcont/Rpfo/Painel/Painel/consultaStatusFaseRPFO';
$route['rpfo_buscaelaboracao'] = 'homeCgcont/Rpfo/Elaboracao/Elaboracaoctr/buscaelaboracao';
$route['rpfo_buscaMotivacao'] = 'homeCgcont/Rpfo/Elaboracao/Motivacao/Motivacaoctr/buscaMotivacao';
$route['rpfo_buscaoMotivacaoVersaoAnt'] = 'homeCgcont/Rpfo/Elaboracao/Motivacao/Motivacaoctr/buscaoMotivacaoVersaoAnt';
$route['rpfo_buscaResumo'] = 'homeCgcont/Rpfo/Elaboracao/Resumo/Resumoctr/buscaResumo';
$route['rpfo_buscaoResumoVersaoAnt'] = 'homeCgcont/Rpfo/Elaboracao/Resumo/Resumoctr/buscaoResumoVersaoAnt';
$route['rpfo_buscaProcesso'] = 'homeCgcont/Rpfo/Elaboracao/ProcessoSei/ProcessoSeictr/buscaProcesso';
$route['rpfo_buscaVersaoProcesso'] = 'homeCgcont/Rpfo/Elaboracao/ProcessoSei/ProcessoSeictr/buscaVersaoProcesso';
$route['rpfo_consultaItensRevisao'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/consultaItensRevisao';
$route['rpfo_consultaAreaExploracao'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/consultaAreaExploracao';
$route['rpfo_consultaValorDisciplinas'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/consultaValorDisciplinas';
$route['rpfo_consultaItensRevisaoTotal'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/consultaItensRevisaoTotal';
$route['rpfo_insereRevisao'] = 'homeCgcont/Rpfo/Elaboracao/Elaboracaoctr/insereRevisao';
$route['rpfo_finalizaElaboracao'] = 'homeCgcont/Rpfo/Elaboracao/Elaboracaoctr/finalizaElaboracao';
$route['rpfo_rotaDisciplina'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr';
$route['rpfo_consultaDisciplinasContrato'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/consultaDisciplinasContrato';
$route['rpfo_consultaItensDisciplinas'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/consultaItensDisciplinas';
$route['rpfo_populaDisciplina'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/populaDisciplina';
$route['rpfo_consultaDisciplinasRevisao'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/consultaDisciplinasRevisao';
$route['rpfo_insereDisciplinaRevisao'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/insereDisciplinaRevisao';
$route['rpfo_excluirDisciplinaRevisao'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/excluirDisciplinaRevisao';
$route['rpfo_populaMotivacao'] = 'homeCgcont/Rpfo/Elaboracao/Motivacao/Motivacaoctr/populaMotivacao';
$route['rpfo_insereItemDisciplina'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/insereItemDisciplina';
$route['rpfo_excluiItemDisciplina'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/excluiItemDisciplina';
$route['rpfo_insereValorDisciplina'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/insereValorDisciplina';
$route['rpfo_populaAreaExploracao'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/populaAreaExploracao';
$route['rpfo_excluiValorDisciplina'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/excluiValorDisciplina';
$route['rpfo_insereAreaExploracao'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/insereAreaExploracao';
$route['rpfo_excluiCoordenadaArea'] = 'homeCgcont/Rpfo/Elaboracao/ItensDisciplina/ItensDisciplinactr/excluiCoordenadaArea';
$route['rpfo_insereMotivacao'] = 'homeCgcont/Rpfo/Elaboracao/Motivacao/Motivacaoctr/insereMotivacao';
$route['rpfo_excluiMotivacao'] = 'homeCgcont/Rpfo/Elaboracao/Motivacao/Motivacaoctr/excluiMotivacao';
$route['rpfo_buscaParecerCtd'] = 'homeCgcont/Rpfo/Elaboracao/Parecer/ParecerCircunstanciadoctr/buscaParecerCtd';
$route['rpfo_buscaoParecVersaoAnt'] = 'homeCgcont/Rpfo/Elaboracao/Parecer/ParecerCircunstanciadoctr/buscaoParecVersaoAnt';
$route['rpfo_insereParecerCtd'] = 'homeCgcont/Rpfo/Elaboracao/Parecer/ParecerCircunstanciadoctr/insereParecerCtd';
$route['rpfo_excluiParecerCtd'] = 'homeCgcont/Rpfo/Elaboracao/Parecer/ParecerCircunstanciadoctr/excluiParecerCtd';
$route['rpfo_insereProcesso'] = 'homeCgcont/Rpfo/Elaboracao/ProcessoSei/ProcessoSeictr/insereProcesso';
$route['rpfo_excluiProcesso'] = 'homeCgcont/Rpfo/Elaboracao/ProcessoSei/ProcessoSeictr/excluiProcesso';
$route['rpfo_consultarProcedimento'] = 'homeCgcont/Rpfo/Elaboracao/ProcessoSei/ProcessoSeictr/consultarProcedimento';
$route['rpfo_insereResumo'] = 'homeCgcont/Rpfo/Elaboracao/Resumo/Resumoctr/insereResumo';
$route['rpfo_excluiResumo'] = 'homeCgcont/Rpfo/Elaboracao/Resumo/Resumoctr/excluiResumo';
$route['rpfo_buscaSituacao'] = 'homeCgcont/Rpfo/Elaboracao/SituacaoObra/SituacaoObractr/buscaSituacao';
$route['rpfo_buscaoSituacaoVersaoAnt'] = 'homeCgcont/Rpfo/Elaboracao/SituacaoObra/SituacaoObractr/buscaoSituacaoVersaoAnt';
$route['rpfo_insereSituacao'] = 'homeCgcont/Rpfo/Elaboracao/SituacaoObra/SituacaoObractr/insereSituacao';
$route['rpfo_excluiSituacao'] = 'homeCgcont/Rpfo/Elaboracao/SituacaoObra/SituacaoObractr/excluiSituacao';
$route['rpfo_buscaFinanceiroContrato'] = 'homeCgcont/Rpfo/Elaboracao/SituacaoObra/SituacaoObractr/buscaFinanceiroContrato';
$route['rpfo_recuperaGrafDadosFinanc'] = 'homeCgcont/Rpfo/Elaboracao/SituacaoObra/SituacaoObractr/recuperaGrafDadosFinanc';
$route['rpfo_recuperaFinanceiroContrato'] = 'homeCgcont/Rpfo/Elaboracao/SituacaoObra/SituacaoObractr/recuperaFinanceiroContrato';

$route['rpfo_consultaParecer'] = 'homeCgcont/Rpfo/Painel/Painel/consultaParecer';
$route['rpfo_consultaTotalRpfoContrato'] = 'homeCgcont/Rpfo/Painel/Painel/consultaTotalRpfoContrato';
$route['rpfo_consultaAreaExploracaoPainel'] = 'homeCgcont/Rpfo/Painel/Painel/consultaAreaExploracao';
$route['rpfo_consultaValorDisciplinasPainel'] = 'homeCgcont/Rpfo/Painel/Painel/consultaValorDisciplinas';
$route['rpfo_populaContrato'] = 'homeCgcont/Rpfo/Painel/Painel/populaContrato';
$route['rpfo_populaBR'] = 'homeCgcont/Rpfo/Painel/Painel/populaBR';
$route['rpfo_RPFOCadastradas'] = 'homeCgcont/Rpfo/Painel/Painel/RPFOCadastradas';
$route['rpfo_consultaRPFO'] = 'homeCgcont/Rpfo/Painel/Painel/consultaRPFO';
$route['rpfo_reflexoFinanceiro'] = 'homeCgcont/Rpfo/Painel/Painel/reflexoFinanceiro';

$route['rpfo_ReciboRPFO'] = 'homeCgcont/Rpfo/Recibo/GeraRecibo/ReciboRPFO';
$route['rpfo_buscaUsuarios'] = 'homeCgcont/Rpfo/Usuarios/Usuariosctr/buscaUsuarios';
$route['rpfo_alteraPerfil'] = 'homeCgcont/Rpfo/Usuarios/Usuariosctr/alteraPerfil';

$route['rpfo_buscaAprovacaoFiscal'] = 'homeCgcont/Rpfo/AprovacaoFiscal/AprovacaoFiscalctr/buscaAprovacaoFiscal';
$route['rpfo_selecionaFase2'] = 'homeCgcont/Rpfo/AprovacaoFiscal/AprovacaoFiscalctr/selecionaFase2';
$route['rpfo_AprovarFase2'] = 'homeCgcont/Rpfo/AprovacaoFiscal/AprovacaoFiscalctr/AprovarFase2';
$route['rpfo_ReprovarFase2'] = 'homeCgcont/Rpfo/AprovacaoFiscal/AprovacaoFiscalctr/ReprovarFase2';
$route['rpfo_buscaChefeServicoConst'] = 'homeCgcont/Rpfo/ChefeServicoConst/ChefeServicoConstctr/buscaChefeServicoConst';
$route['rpfo_selecionaFase3'] = 'homeCgcont/Rpfo/ChefeServicoConst/ChefeServicoConstctr/selecionaFase3';
$route['rpfo_AprovarFase3'] = 'homeCgcont/Rpfo/ChefeServicoConst/ChefeServicoConstctr/AprovarFase3';
$route['rpfo_ReprovarFase3'] = 'homeCgcont/Rpfo/ChefeServicoConst/ChefeServicoConstctr/ReprovarFase3';
$route['rpfo_buscaAprovacaoCoordenacao'] = 'homeCgcont/Rpfo/AprovacaoCoordenacao/AprovacaoCoordenacaoctr/buscaAprovacaoCoordenacao';
$route['rpfo_selecionaFase4'] = 'homeCgcont/Rpfo/AprovacaoCoordenacao/AprovacaoCoordenacaoctr/selecionaFase4';
$route['rpfo_AprovarFase4'] = 'homeCgcont/Rpfo/AprovacaoCoordenacao/AprovacaoCoordenacaoctr/AprovarFase4';
$route['rpfo_ReprovarFase4'] = 'homeCgcont/Rpfo/AprovacaoCoordenacao/AprovacaoCoordenacaoctr/ReprovarFase4';
$route['rpfo_buscaSuperintendente'] = 'homeCgcont/Rpfo/Superintendente/Superintendentectr/buscaSuperintendente';
$route['rpfo_selecionaFase5'] = 'homeCgcont/Rpfo/Superintendente/Superintendentectr/selecionaFase5';
$route['rpfo_AprovarFase5'] = 'homeCgcont/Rpfo/Superintendente/Superintendentectr/AprovarFase5';
$route['rpfo_ReprovarFase5'] = 'homeCgcont/Rpfo/Superintendente/Superintendentectr/ReprovarFase5';
$route['rpfo_buscaAnaliseTecnica'] = 'homeCgcont/Rpfo/AnaliseTecnica/AnaliseTecnicactr/buscaAnaliseTecnica';
$route['rpfo_selecionaFase6'] = 'homeCgcont/Rpfo/AnaliseTecnica/AnaliseTecnicactr/selecionaFase6';
$route['rpfo_aprovarFase6'] = 'homeCgcont/Rpfo/AnaliseTecnica/AnaliseTecnicactr/aprovarFase6';
$route['rpfo_ReprovarFase6'] = 'homeCgcont/Rpfo/AnaliseTecnica/AnaliseTecnicactr/ReprovarFase6';
$route['rpfo_buscaAprovacaoCoodSetorial'] = 'homeCgcont/Rpfo/AprovacaoCoodSetorial/AprovacaoCoodSetorialctr/buscaAprovacaoCoodSetorial';
$route['rpfo_selecionaFase7'] = 'homeCgcont/Rpfo/AprovacaoCoodSetorial/AprovacaoCoodSetorialctr/selecionaFase7';
$route['rpfo_AprovarFase7'] = 'homeCgcont/Rpfo/AprovacaoCoodSetorial/AprovacaoCoodSetorialctr/AprovarFase7';
$route['rpfo_ReprovarFase7'] = 'homeCgcont/Rpfo/AprovacaoCoodSetorial/AprovacaoCoodSetorialctr/ReprovarFase7';
$route['rpfo_buscaUnidadeGestora'] = 'homeCgcont/Rpfo/UnidadeGestora/UnidadeGestoractr/buscaUnidadeGestora';
$route['rpfo_selecionaFase8'] = 'homeCgcont/Rpfo/UnidadeGestora/UnidadeGestoractr/selecionaFase8';
$route['rpfo_AprovarFase8'] = 'homeCgcont/Rpfo/UnidadeGestora/UnidadeGestoractr/AprovarFase8';
$route['rpfo_ReprovarFase8'] = 'homeCgcont/Rpfo/UnidadeGestora/UnidadeGestoractr/ReprovarFase8';
$route['rpfo_PendenteFase8'] = 'homeCgcont/Rpfo/UnidadeGestora/UnidadeGestoractr/PendenteFase8';

$route['rpfo_buscaDocumento'] = 'homeCgcont/Rpfo/DocumentoSei/DocumentoSeictr/buscaDocumento';
$route['rpfo_insereDocumento'] = 'homeCgcont/Rpfo/DocumentoSei/DocumentoSeictr/insereDocumento';
$route['rpfo_excluiDocumento'] = 'homeCgcont/Rpfo/DocumentoSei/DocumentoSeictr/excluiDocumento';

$route['rpfo_insereDisciplina'] = 'homeCgcont/Rpfo/Disciplinas/Disciplinasctr/insereDisciplina';
$route['rpfo_excluiDisciplina'] = 'homeCgcont/Rpfo/Disciplinas/Disciplinasctr/excluiDisciplina';
$route['rpfo_consultaDisciplinas'] = 'homeCgcont/Rpfo/Disciplinas/Disciplinasctr/consultaDisciplinas';

$route['rpfo_relatorioRevisao_sessao'] = 'homeCgcont/Rpfo/Relatorio/RelatorioRpfo/relatorioRevisaoSessao';
$route['rpfo_relatorioRevisao'] = 'homeCgcont/Rpfo/Relatorio/RelatorioRpfo/relatorio';
$route['rpfo_relatorioRevisao_grafico_legenda'] = 'homeCgcont/Rpfo/Relatorio/RelatorioRpfo/buscaFinanceiroContrato';
$route['rpfo_relatorioRevisao_grafico'] = 'homeCgcont/Rpfo/Relatorio/RelatorioRpfo/RelatorioRecuperaGrafDadosFinanc';
$route['rpfo_relatorioGeral'] = 'homeCgcont/Rpfo/Relatorio/RelatorioRpfo/rotaRelatorioGeral';

################################################################################
#RPFO SUPERVISÃO
//rpfoView.js
$route['rpfoSupervisao_recuperaRpfo'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/recuperaRpfo';
$route['rpfoSupervisao_excluirRpfo'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/excluirRpfo';
$route['rpfoSupervisao_populaRPFO'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/populaRPFO';
$route['rpfoSupervisao_populaLocal'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/populaLocal';
$route['rpfoSupervisao_populaStatus'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/populaStatus';
$route['rpfoSupervisao_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/recuperaRpfo';
$route['rpfoSupervisao_modalStatusDetalhado'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/consultaStatusDetalhado';
$route['rpfoSupervisao_insereRPFO'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/insereRpfo';
$route['rpfoSupervisao_editarRpfo'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/Recupera_rpfoSupervisao_edicao';
$route['rpfoSupervisao_alteraRPFO'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/alteraRpfo';
$route['rpfoSupervisao_btnNoAtividade'] = 'homeCgcont/Supervisaocont/Rpfo/Rpfo/insereNaoAtividade';

################################################################################
#RPFO GESTÃO.
//rpfogestaoView.js
$route['rpfogestao_recuperaRpfo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/recuperaRpfo';
$route['rpfogestao_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/recuperaRpfo';
$route['rpfogestao_insereRPFO'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/insereRpfo';
$route['rpfogestao_editarRpfo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/Recupera_Rpfo_edicao';
$route['rpfogestao_alterarRPFO'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/alterarRpfo';
$route['rpfogestao_populaLocal'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/populaLocal';
$route['rpfogestao_populaStatus'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/populaStatus';
$route['rpfogestao_excluirRpfo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/excluirRpfo';
$route['rpfogestao_excluirgestaoRpfo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/excluirgestaoRpfo';
$route['rpfogestao_Anexo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/Recuperastatus';
$route['rpfogestao_Anexo_2'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/recuperaanexoGestaorpfo';
$route['rpfogestao_recuperaGestaorpfo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/recuperaGestaorpfo';
$route['rpfogestao_inseregestaoRPFO'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/inseregestaoRpfo';
$route['rpfogestao_insereAnexo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/insereAnexo';
$route['rpfogestao_excluirArquivo'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/excluirArquivo';
$route['rpfogestao_modalStatusDetalhado'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/consultaStatusDetalhado';
$route['rpfogestao_btnNoAtividade'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/insereNaoAtividade';
$route['rpfogestao_excluirNaoHouveAtividadeMes'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/NaoPublicar';
$route['rpfogestao_table_naohouveatividademes'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/Recupera_naohouveatividademes';
$route['rpfogestao_table_naohouveatividademes_2'] = 'homeCgcont/Supervisaocont/Rpfogestao/Rpfogestaoctr/Recupera_naohouveatividademes';
################################################################################
#Riscos e Interferências.
$route['riscosinterferencias_rotaInterferenciasExecutivas'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/RiscosInterferencias';
$route['riscosinterferencias_recupera_TipoInterferencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recupera_TipoInterferencia';
$route['riscosinterferencias_recupera_TipoInterferenciaEditar'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recupera_TipoInterferencia';
$route['riscosinterferencias_recupera_Classificacao'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaClassificacao';
$route['riscosinterferencias_recupera_ClassificacaoEditar'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaClassificacao';
$route['riscosinterferencias_recupera_GrauImpacto'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaGrauImpacto';
$route['riscosinterferencias_recupera_GrauImpactoEditar'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaGrauImpacto';
$route['riscosinterferencias_populaTipoEixo'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/populaTipoEixo';
$route['riscosinterferencias_populaTipoEixoEditar'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/populaTipoEixo';
$route['riscosinterferencias_recuperaInterferencias'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaInterferencia';
$route['riscosinterferencias_excluirInterferencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/excluirInterferencia';
$route['riscosinterferencias_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/confereNaoAtividade';
$route['riscosinterferencias_recuperaDescricao'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaDescricao';
$route['riscosinterferencias_descricaoInterferencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaAtualizacao';
$route['riscosinterferencias_recuperaAtualizacao'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaAtualizacao';
$route['riscosinterferencias_Recuperaprovidencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/consultaProvidenciaInterferencia';
$route['riscosinterferencias_atualizarInterferencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/atualizarInterferencia';
$route['riscosinterferencias_btnInsereFecharInterferencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/interferenciaSanada';
$route['riscosinterferencias_recuperaProvidencias'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/consultaProvidencia';
$route['riscosinterferencias_excluirProvidencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/excluirProvidencia';
$route['riscosinterferencias_recuperaBr'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaBr';
$route['riscosinterferencias_recuperaBrEditar'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/recuperaBr';
$route['riscosinterferencias_carregaGrauImpacto'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/carregaGrauImpacto';
$route['riscosinterferencias_CarregaFormulario'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/CarregaFormulario';
$route['riscosinterferencias_populaLado'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/populaLado';
$route['riscosinterferencias_insereInterferencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/insereInterferencia';
$route['riscosinterferencias_editarInterferencia'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/editarInterferencia';
$route['riscosinterferencias_btnNoAtividade'] = 'homeCgcont/Supervisaocont/RiscoInterferencia/RiscoInterferencia/insereNaoAtividade';
################################################################################
#Painel Gerencial
$route['painelgerencial_rotaPainelGerencial'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/PainelGerencial';
$route['painelgerencial_Recupera_ctr'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/Recupera_ctr';
$route['painelgerencial_RecuperaGrafDadosFinanc'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafDadosFinanc';
$route['painelgerencial_RecuperaGrafCurvaS'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafCurvaS';
$route['painelgerencial_Grafico_Rodovia'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaTipoEixo';
$route['painelgerencial_Grafico_Rodovia_Lado'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaTipoLado';
$route['painelgerencial_Grafico_OAE_Construcao'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaTipoEixoConstrucao';
$route['painelgerencial_Grafico_OAE_Restauracao'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaTipoEixoRestauracao';
$route['painelgerencial_changeUf'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/Recupera_br';
$route['painelgerencial_Recupera_contrato'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/Recupera_contrato';
$route['painelgerencial_changeBr'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/Recupera_contrato';
$route['painelgerencial_PainelRodovia'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelRodovia';
$route['painelgerencial_PainelIDFin'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafIdfin';
$route['painelgerencial_PainelMedicao'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelMedicoes';
$route['painelgerencial_PainelEmpenhoRAP'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelEmpenhos';
$route['painelgerencial_TablePainelEmpenhosSoma'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelEmpenhosSoma';
$route['painelgerencial_TablePainelEmpenhosSomaSupervisora'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelEmpenhosSomaSupervisora';
$route['painelgerencial_TablePainelRap'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelRap';
$route['painelgerencial_TablePainelRapSoma'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelRapSoma';
$route['painelgerencial_TablePainelRapSomaSupervisora'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelRapSomaSupervisora';
$route['painelgerencial_PainelFotos'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelFotos';
$route['painelgerencial_imagem'] = '/homeCgcont/Arquivo/imagem';
$route['painelgerencial_downloadImagem'] = 'homeCgcont/Arquivo/downloadImagem';
$route['painelgerencial_grafico_obra_oae_constr'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafOAEConst';
$route['painelgerencial_PainelOAEConst'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelOAEConst';
$route['painelgerencial_carregarGraficosOAEConst'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelOAEConst';
$route['painelgerencial_grafico_obra_oae_rest'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafOAERest';
$route['painelgerencial_PainelOAERest'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelOAERest';
$route['painelgerencial_carregarGraficosOAERest'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelOAERest';
$route['painelgerencial_grafico_obra_rodovias'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafRodovia';
$route['painelgerencial_RecuperaEixoLado'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaEixoLado';
$route['painelgerencial_Grafico_Rodovia_Lado'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaTipoLado';
$route['painelgerencial_downloadGestaodeRiscos'] = 'homeCgcont/Supervisaocont/Painelgerencial/GestaodeRiscosExportaExcel';
$route['painelgerencial_painel_obra_mensagem'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelMensagem';
$route['painelgerencial_TableResumoPainelGerencial'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableResumoPainelGerencial';
$route['painelgerencial_insereResumoPainelGerencial'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/insereResumoPainelGerencial';
$route['painelgerencial_excluiResumoPainelGerencial'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/excluiResumoPainelGerencial';
$route['painelgerencial_RecuperaResumo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaResumo';
$route['painelgerencial_RecuperaRemetente'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaRemetente';
$route['painelgerencial_RecuperaDestinatario'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaDestinatario';
$route['painelgerencial_gravaPainelMensagem'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/insereMensagem';
$route['painelgerencial_buscaRespostas'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelResposta';
$route['painelgerencial_GravaResposta'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/insereResposta';
$route['painelgerencial_excluirResposta'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/excluiResposta';
$route['painelgerencial_RecuperaAditivoOrganizador'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaAditivoOrganizador';
$route['painelgerencial_RecuperaGrafObraAditivo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafObraAditivo';
$route['painelgerencial_TableObraAditivo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableObraAditivo';
$route['painelgerencial_downloadAditivo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/downloadAditivo';
$route['painelgerencial_painel_obra_ambiental'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableObraAmbiental';
$route['painelgerencial_painel_obra_interferencias'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableObraInterferencias';
$route['painelgerencial_painel_obra_riscos'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableObraRiscos';
$route['painelgerencial_painel_obra_riscos_assunto'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableObraRiscosAssunto';
$route['painelgerencial_painel_obra_riscos_providencia'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableObraRiscosProvidencia';
$route['painelgerencial_dadosRelatorio'] = 'homeCgcont/Supervisaocont/ImprimirRelatorio/Imprimirrelatorioctr/RecuperaRelatorio';
$route['painelgerencial_PainelLinhaTempo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelLinhaTempo';
$route['painelgerencial_PainelLinhaTempo_2'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/PainelLinhaTempo';
$route['painelgerencial_painel_obra_curvas'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaCurvaSObraSupervGerenc';
$route['painelgerencial_RecuperaFinancSupervisao'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaFinancSupervisao';
$route['painelgerencial_RecuperaCurvaSSupervisao'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaCurvaSSupervisao';
$route['painelgerencial_TableContratosSupervisao'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableContratosSupervisao';
$route['painelgerencial_painel_superv_aditivos'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafSupervAditivo';
$route['painelgerencial_TableSupervAditivo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableSupervAditivo';
$route['painelgerencial_PainelMedicaoSupervisora'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelMedicoesSupervisora';
$route['painelgerencial_PainelEmpenhoRAPSupervisora'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelEmpenhosSupervisora';
$route['painelgerencial_tableRap'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelRapSupervisora';
$route['painelgerencial_RecuperaFinancGerenciamento'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaFinancGerenciamento';
$route['painelgerencial_RecuperaCurvaSGerenciamento'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaCurvaSGerenciamento';
$route['painelgerencial_tableGerenciamentoResumo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableContratosGerenciamento';
$route['painelgerencial_tableGerenciamentoNovoResumo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableContratosGerenciamentoNovo';
$route['painelgerencial_painel_gerenc_aditivos'] = 'homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafGerencAditivo';
$route['painelgerencial_tableGerencAditivo'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TableGerencAditivo';
$route['painelgerencial_PainelMedicaoGerenciadora'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelMedicoesGerenciadora';
$route['painelgerencial_PainelEmpenhoRAPGerenciadora'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelEmpenhosGerenciadora';
$route['painelgerencial_TablePainelRapGerenciadora'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelRapGerenciadora';
$route['painelgerencial_termoContratualOrganizador'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/downloadTermoContrato';
$route['painelgerencial_editalOrganizador'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/downloadEdital';
$route['painelgerencial_PainelSegmento'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelSegmento';
$route['painelgerencial_unifilar3D'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaUnifilar3D';

//convenio
$route['painelgerencial_RecuperaGrafDadosFinancConvenio'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafDadosFinancConvenio';
$route['painelgerencial_grafico_obra_rodovias_convenio'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafRodoviaConvenio';
$route['painelgerencial_PainelRodovia_convenio'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/TablePainelRodoviaConvenio';
$route['painelgerencial_PainelIDFin_convenio'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaGrafIdfinConvenio';

################################################################################
#painel gerencial VGEO
$route['painelgerencialVGEO_RecuperaConvenio'] = '/homeCgcont/Supervisaocont/PainelGerencial/Painelgerencial/RecuperaConvenio';
################################################################################
#RNC.
$route['rnc_insereRncFotografico'] = 'homeCgcont/Supervisaocont/RNC/RNC/insereArquivo';
$route['rnc_btnNoAtividade'] = 'homeCgcont/Supervisaocont/RNC/RNC/insereNaoAtividade';
$route['rnc_recuperaRNC'] = 'homeCgcont/Supervisaocont/RNC/RNC/recuperaRNC';
$route['rnc_excluirRNC'] = 'homeCgcont/Supervisaocont/RNC/RNC/excluirRNC';
$route['rnc_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/RNC/RNC/confereAtividade';
$route['rnc_rotaDocRNC'] = 'homeCgcont/Supervisaocont/RNC/RNC/insereIdSessao';
$route['rnc_fotos'] = 'homeCgcont/Supervisaocont/RNC/RNC/fotos';
$route['rnc_alteraFoto'] = 'homeCgcont/Supervisaocont/RNC/RNC/alteraFoto';
$route['rnc_modalSituacao'] = 'homeCgcont/Supervisaocont/RNC/RNC/consultaSugestao';
$route['rnc_excluirSugestao'] = 'homeCgcont/Supervisaocont/RNC/RNC/excluirSugestao';
$route['rnc_recupera_servico'] = 'homeCgcont/Supervisaocont/RNC/RNC/recupera_servico';
$route['rnc_populaTipoEixo'] = 'homeCgcont/Supervisaocont/RNC/RNC/populaTipoEixo';
$route['rnc_populaLado'] = 'homeCgcont/Supervisaocont/RNC/RNC/populaLado';
$route['rnc_insereRnc'] = 'homeCgcont/Supervisaocont/RNC/RNC/insereRnc';
$route['rnc_btnInsereSolucaoRNC'] = 'homeCgcont/Supervisaocont/RNC/RNC/insereProvidencia';
$route['rnc_RecuperaFotos'] = 'homeCgcont/Supervisaocont/RNC/RNC/RecuperaFotos';
$route['rnc_excluirFoto'] = 'homeCgcont/Supervisaocont/RNC/RNC/excluirFoto';
$route['rnc_editarRNCdescricaovazia'] = 'homeCgcont/Supervisaocont/RNC/RNC/RecuperaDescricaoVazia';
$route['rnc_btnEditarRNC'] = 'homeCgcont/Supervisaocont/RNC/RNC/editarDescricaoRnc';

################################################################################
#DOCRNC.
$route['docrnc_consultaDocRNC'] = 'Supervisaocont/RNC/RNC/recuperaDocRNC';
$route['docrnc_confereNaoAtividade'] = 'Supervisaocont/RNC/RNC/recuperaRNC';
################################################################################
#Avanço Financeiro 
$route['avancofinanceiro_Recupera_AvancoFinanceiro'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroSupervisao/AvancoFinanceiroSupervisao/recuperaAvancoFinanceiro';
$route['avancofinanceiro_confereCronogramaFinanceiro'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroSupervisao/AvancoFinanceiroSupervisao/confereCronograma';
$route['avancofinanceiro_insereAvancoFinanceiroSupervisao'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroSupervisao/AvancoFinanceiroSupervisao/insereAvancoFinanceiro';
$route['avancofinanceiro_recuperaCronogramaDetalhado'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroSupervisao/AvancoFinanceiroSupervisao/recuperaCronograma';
$route['avancofinanceiro_recuperaDetalhesValores'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroSupervisao/AvancoFinanceiroSupervisao/recuperaDetalhesValores';
$route['avancofinanceiro_excluirAvancoFinanceiro'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroSupervisao/AvancoFinanceiroSupervisao/excluirAvancoFinanceiro';
################################################################################
#Avanço Financeiro da Obra.
$route['avancofinanceiroobra_btnPublicar'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/publicarAvancoFinceiro';
$route['avancofinanceiroobra_popula_eixo_servico'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroSupervisao/AvancoFinanceiroSupervisao/popula_eixo_servico';
$route['avancofinanceiroobra_saldos'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/saldoMedicao';
$route['avancofinanceiroobra_Recupera_AvancoFinanceiro'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/recuperaAvancoFinanceiro';
$route['avancofinanceiroobra_recuperaMedicoes'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/recuperaMedicoes';
$route['avancofinanceiroobra_confereAvancoFinanceiro'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/recuperaMedicoes';
$route['avancofinanceiroobra_confereCronogramaFinanceiroObra'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/confereCronograma';
$route['avancofinanceiroobra_insereAvancoFinanceiroObra'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/insereAvancoFinanceiro';
$route['avancofinanceiroobra_recuperaCronogramaDetalhado'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/recuperaCronograma';
$route['avancofinanceiroobra_excluirAvancoFinanceiro'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/excluirAvancoFinanceiro';
$route['avancofinanceiroobra_btnNoAtividade'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/insereNaoAtividade';
$route['avancofinanceiroobra_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/AvancoFinanceiroObra/AvancoFinanceiroObra/recuperaAvancoFinanceiro';
################################################################################
#Eixos Georreferenciados.
$route['georreferenciamento_recuperaGeorreferenciamento'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamentocrt/recuperaGeorreferenciamento';
$route['georreferenciamento_excluirGeorreferenciamento'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamentocrt/excluirGeorreferenciamento';
$route['georreferenciamento_detalhesGeorreferenciamento'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamentocrt/recuperaDetalhesGeorreferenciamento';
$route['georreferenciamento_fileUploadConfigGeorreferenciamento'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamentocrt/RecuperaNomeEixo';
$route['georreferenciamento_insereArquivoGeorreferenciamento'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamentocrt/insereArquivoGeorreferenciamento';
$route['georreferenciamento_btnInsere'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamentocrt/inserirdados';
$route['georreferenciamento_btnVoltar'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/retornaConfiguracao';
$route['georreferenciamento_rotaGeorreferenciamento'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/Georreferenciamento';
$route['georreferenciamento_rotaGeo'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/Geo';
################################################################################
#Cronograma Físico Pista
$route['cronogramafisicopista_rotaCronogramaFisico'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/CronogramaFisico';
$route['cronogramafisicopista_publicar'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/publicar';
$route['cronogramafisicopista_recuperaCronograma'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/recuperaCronograma';
$route['cronogramafisicopista_RecuperaSevico'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/recuperaServico';
$route['cronogramafisicopista_RecuperaSevicoNovo'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/recuperaServico';
$route['cronogramafisicopista_RecuperaEixoLado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/recuperaEixoLado';
$route['cronogramafisicopista_RecuperaLadoNovo'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaLado';
$route['cronogramafisicopista_insereCronogramaFisico'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/insereCronogramaFisico';
$route['cronogramafisicopista_insereCronogramaFisicoNovo'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/insereCronogramaFisicoNovo';
$route['cronogramafisicopista_insereCronogramaFisicoVersao'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/insereCronogramaFisicoVersao';
$route['cronogramafisicopista_excluirItem'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/excluirAvanco';
$route['cronogramafisicopista_populaTipoEixo'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamento/populaTipoEixo';
$route['cronogramafisicopista_verificaCronograma'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/recuperaCronograma';
$route['cronogramafisicopista_Recupera_Cronograma_Eixo'] = 'homeCgcont/Supervisaocont/Avancofisicoobra/Avancofisicoobractr/Recupera_informacaoes_avanco';
$route['cronogramafisicopista_table_visualizar_cronogramafisico_eixo'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/Recupera_Cronograma_Eixo';
$route['cronogramafisicopista_RecuperaEixo'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/recuperaEixo';
$route['cronogramafisicopista_RecuperaLado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/recuperaLado';
$route['cronogramafisicopista_RecuperaPlanejadoAcumuladoServico'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaPlanejadoAcumuladoServico';
$route['cronogramafisicopista_RecuperaItensInseridos'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaItensInseridos';
$route['cronogramafisicopista_table_visualizar_cronogramaagrupado_naopublicado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaCronogramaAgrupado_naopublicado';
$route['cronogramafisicopista_table_visualizar_cronogramaagrupado_publicado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaCronogramaAgrupado_publicado';
$route['cronogramafisicopista_RecuperaDetalhado_naopublicado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaDetalhado_naopublicado';
$route['cronogramafisicopista_RecuperaDetalhado_publicado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaDetalhado_publicado';
$route['cronogramafisicopista_RecuperaeditarCronograma'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaeditarCronograma';
$route['cronogramafisicopista_btn_salvaredicao'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/editarCronograma';
$route['cronogramafisicopista_excluirAvanco'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/excluirAvanco';
$route['cronogramafisicopista_ContaNaoPublicado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/ContaNaoPublicado';
$route['cronogramafisicopista_PublicarCronograma_naopublicado'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/publicar';
$route['cronogramafisicopista_PublicarCronograma'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/publicar';
$route['cronogramafisicopista_RecuperaGeo'] = 'homeCgcont/Supervisaocont/Cronogramafisico/Cronogramafisicoctr/RecuperaGeo';
################################################################################
#Apresentação Construtora
$route['apresentacaoconstrutora_rotaApresentacaoConstrutora'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/ApresentacaoConstrutora';
$route['apresentacaoconstrutora_RecuperaApresentacaoConstrutora'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Apresentacaoconstrutora/RecuperaApresentacaoConstrutora';
$route['apresentacaoconstrutora_Tableaditivo'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Aditivo/Tableaditivo';
$route['apresentacaoconstrutora_recuperaPortariasFiscais'] = 'homeCgcont/Supervisaocont/PortariasFiscais/PortariasFiscais/recuperaPortariasFiscais';
$route['apresentacaoconstrutora_Tablelocalizacao'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Localizacao/Tablelocalizacao';
$route['apresentacaoconstrutora_Tableresponsaveltecnico'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Responsaveltecnico/Tableresponsaveltecnico';
$route['apresentacaoconstrutora_tableAsParalisacaoReinicio'] = 'homeCgcont/Supervisaocont/ParalisacaoReinicio/ParalisacaoReinicioctr/tableAsParalisacaoReinicio';
$route['apresentacaoconstrutora_tableAsApostila'] = 'homeCgcont/Supervisaocont/Apostila/Apostilactr/tableAsApostila';
$route['apresentacaoconstrutora_atualizaConstrutora'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Apresentacaoconstrutora/RecuperaApresentacaoConstrutora';
$route['apresentacaoconstrutora_abreApresentacao'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Apresentacaoconstrutora/RecuperaApresentacaoConstrutora';
$route['apresentacaoconstrutora_gravaApresentacao'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Apresentacaoconstrutora/insereApresentacaoconstrutora';
$route['apresentacaoconstrutora_gravaAditivo'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Aditivo/insereAditivo';
$route['apresentacaoconstrutora_excluirAditivo'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Aditivo/excluirAditivo';
$route['apresentacaoconstrutora_gravaFiscal'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Fiscal/insereFiscal';
$route['apresentacaoconstrutora_excluirFiscal'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Fiscal/excluirFiscal';
$route['apresentacaoconstrutora_gravaLocalizacao'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Localizacao/insereLocalizacao';
$route['apresentacaoconstrutora_excluirLocalizacao'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Localizacao/excluirLocalizacao';
$route['apresentacaoconstrutora_gravaResponsavelTecnico'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Responsaveltecnico/insereResponsavelTecnico';
$route['apresentacaoconstrutora_excluirResponsaveltecnico'] = 'homeCgcont/Supervisaocont/Apresentacaoconstrutora/Responsaveltecnico/excluirResponsaveltecnico';
$route['apresentacaoconstrutora_modalObjetoMotivacaoAditivo'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Aditivo/recuperaObjetoTermo';
$route['apresentacaoconstrutora_btgravaParalisacaoreinicio'] = 'homeCgcont/Supervisaocont/ParalisacaoReinicio/ParalisacaoReinicioctr/insereParalisacaoReinicioConstrucao';
$route['apresentacaoconstrutora_btgravaApostila'] = 'homeCgcont/Supervisaocont/Apostila/Apostilactr/insereApostilaConstrucao';
$route['apresentacaoconstrutora_excluirParalisacaoReinicio'] = 'homeCgcont/Supervisaocont/ParalisacaoReinicio/ParalisacaoReinicioctr/excluirParalisacaoReinicio';
$route['apresentacaoconstrutora_excluirApostila'] = 'homeCgcont/Supervisaocont/Apostila/Apostilactr/excluirApostila';
################################################################################
#Mapa de Situação
$route['mapasituacao_rotaMapaSituacao'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/MapaSituacao';
$route['mapasituacao_fileUploadConfigMapa'] = 'homeCgcont/Supervisaocont/MapaSituacao/MapaSituacao/insereMapaSituacao';
$route['mapasituacao_btnVoltar'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/retornaConfiguracao';
$route['mapasituacao_recuperaMapaSituacao'] = 'homeCgcont/Supervisaocont/MapaSituacao/MapaSituacao/recuperaMapaSituacao';
$route['mapasituacao_excluirMapaSituacao'] = 'homeCgcont/Supervisaocont/MapaSituacao/MapaSituacao/excluirMapaSituacao';
################################################################################
#home
$route['home_rotaRPFO'] = 'homeCgcont/HomeCgcont/homeRpfo';
$route['home_rotaSupervisao'] = 'homeCgcont/HomeCgcont/homeSupervisaoCont';
$route['home_rotaMapaSituacao'] = 'homeCgcont/HomeCgcont/homeMapaSituacao';
$route['home_rotaDocumentacao'] = 'homeCgcont/HomeCgcont/homeDocumentacao';
$route['home_rotaApresentacao'] = 'homeCgcont/HomeCgcont/homeApresentacao';
$route['home_rotaQRCode'] = 'homeCgcont/HomeCgcont/homeQRCode';
$route['home_rotaGestaoDemandas'] = 'homeCgcont/HomeCgcont/homeGestaoDemandas';
$route['home_rotaControleProjeto'] = 'homeCgcont/HomeCgcont/homeControleProjeto';
$route['home_rotaBriefing'] = 'homeCgcont/HomeCgcont/homeBriefing';
$route['home_rotaAnaliseRelatorio'] = 'homeCgcont/HomeCgcont/homeAnaliseRelatorio';
$route['home_rotaPaineisGerenciais'] = 'homeCgcont/HomeCgcont/homePaineisGerenciais';
$route['home_validaKM'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/validaKM';
$route['cgcont/biblioteca'] = 'homeCgcont/HomeCgcont/homeBiblioteca';
// $route['cgcont/cipi'] = 'homeCgcont/HomeCgcont/homeCipi';
$route['cgcont/avancar'] = 'homeCgcont/HomeCgcont/homeAvancar';
$route['cgcont/config-supervisora'] = 'homeCgcont/HomeCgcont/homeConfigSupervisora';
$route['cgcont/administracao'] = 'homeCgcont/HomeCgcont/homeAdministracao';
// $route['cgcont/paineis-gerenciais'] = 'homeCgcont/HomeCgcont/homePaineisGerenciais';
$route['cgcont/ambiente-gestao'] = 'homeCgcont/HomeCgcont/homeAmbienteGestao';
$route['cgcont/ambiente-de-gestao'] = 'homeCgcont/HomeCgcont/homeAmbienteDeGestao';
// $route['cgcont/empreendimento'] = 'homeCgcont/HomeCgcont/homeEmpreendimento';
// $route['cgcont/convenio'] = 'homeCgcont/HomeCgcont/homeConvenio';

################################################################################
#Apresentação Supervisora
$route['apersentacao_supervisora_rotaApresentacaoSupervisora'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/ApresentacaoSupervisora';
$route['apersentacao_supervisora_RecuperaApresentacaoSupervisora'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Apresentacaosupervisora/RecuperaApresentacaoSupervisora';
$route['apersentacao_supervisora_Tableaditivo'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Aditivo/Tableaditivo';
$route['apersentacao_supervisora_recuperaPortariasFiscais'] = 'homeCgcont/Supervisaocont/PortariasFiscais/PortariasFiscais/recuperaPortariasFiscais';
$route['apersentacao_supervisora_Tablelocalizacao'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Localizacao/Tablelocalizacao';
$route['apersentacao_supervisora_Tableresponsaveltecnico'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Responsaveltecnico/Tableresponsaveltecnico';
$route['apersentacao_supervisora_tableAsParalisacaoReinicio'] = 'homeCgcont/Supervisaocont/ParalisacaoReinicio/ParalisacaoReinicioctr/tableAsParalisacaoReinicio';
$route['apersentacao_supervisora_tableAsApostila'] = 'homeCgcont/Supervisaocont/Apostila/Apostilactr/tableAsApostila';
$route['apersentacao_supervisora_recuperaART'] = 'homeCgcont/Supervisaocont/ART/ART/recuperaARTold';
$route['apersentacao_supervisora_atualizaSupervisora'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Apresentacaosupervisora/RecuperaApresentacaoSupervisora';
$route['apersentacao_supervisora_abreApresentacao'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Apresentacaosupervisora/RecuperaApresentacaoSupervisora';
$route['apersentacao_supervisora_gravaApresentacao'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Apresentacaosupervisora/insereApresentacaosupervisora';
$route['apersentacao_supervisora_gravaAditivo'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Aditivo/insereAditivo';
$route['apersentacao_supervisora_excluirAditivoNew'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Aditivo/excluirAditivoNew';
$route['apersentacao_supervisora_gravaFiscal'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Fiscal/insereFiscal';
$route['apersentacao_supervisora_excluirFiscal'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Fiscal/excluirFiscal';
$route['apersentacao_supervisora_gravaLocalizacao'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Localizacao/insereLocalizacao';
$route['apersentacao_supervisora_excluirLocalizacao'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Localizacao/excluirLocalizacao';
$route['apersentacao_supervisora_gravaResponsavelTecnico'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Responsaveltecnico/insereResponsavelTecnico';
$route['apersentacao_supervisora_excluirResponsaveltecnico'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Responsaveltecnico/excluirResponsaveltecnico';
$route['apersentacao_supervisora_modalObjetoMotivacaoAditivo'] = 'homeCgcont/Supervisaocont/Apresentacaosupervisora/Aditivo/recuperaObjetoTermo';
$route['apersentacao_supervisora_btgravaParalisacaoreinicio'] = 'homeCgcont/Supervisaocont/ParalisacaoReinicio/ParalisacaoReinicioctr/insereParalisacaoReinicio';
$route['apersentacao_supervisora_btgravaApostila'] = 'homeCgcont/Supervisaocont/Apostila/Apostilactr/insereApostilaSupervisora';
$route['apersentacao_supervisora_excluirParalisacaoReinicio'] = 'homeCgcont/Supervisaocont/ParalisacaoReinicio/ParalisacaoReinicioctr/excluirParalisacaoReinicio';
$route['apersentacao_supervisora_excluirApostila'] = 'homeCgcont/Supervisaocont/Apostila/Apostilactr/excluirApostila';
################################################################################
//Ensaios Supervisão
$route['ensaios_supervisao_rotaEnsaiosLaboratorio'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/EnsaiosLaboratorio';
$route['ensaios_supervisao_insereEnsaioLaboratorio'] = 'homeCgcont/Supervisaocont/EnsaiosLaboratoriais/EnsaiosLaboratoriais/insereEnsaioLaboratorio';
$route['ensaios_supervisao_btnNoAtividade'] = 'homeCgcont/Supervisaocont/EnsaiosLaboratoriais/EnsaiosLaboratoriais/insereNaoAtividade';
$route['ensaios_supervisao_recuperaEnsaios'] = 'homeCgcont/Supervisaocont/EnsaiosLaboratoriais/EnsaiosLaboratoriais/recuperaEnsaiosLaboratorio';
$route['ensaios_supervisao_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/EnsaiosLaboratoriais/EnsaiosLaboratoriais/recuperaEnsaiosLaboratorio';
$route['ensaios_supervisao_excluirArquivo'] = 'homeCgcont/Supervisaocont/EnsaiosLaboratoriais/EnsaiosLaboratoriais/excluirArquivo';
################################################################################
//Ensaios Construção
$route['ensaios_construcao_rotaEnsaiosConstrucao'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/EnsaioConstrucao';
$route['ensaios_construcao_insereEnsaioLaboratorio'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/insereEnsaioLaboratorio';
$route['ensaios_construcao_btnNoAtividade'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/insereNaoAtividade';
$route['ensaios_construcao_recuperaEnsaios'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/recuperaEnsaiosLaboratorio';
$route['ensaios_construcao_confereNaoAtividade'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/recuperaEnsaiosLaboratorio';
$route['ensaios_construcao_excluirArquivo'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/excluirArquivo';
################################################################################
//Cadastro de OAE
$route['cadastro_oae_rotaConfigOAE'] = 'homeCgcont/Supervisaocont/Supervisaocontctr/ConfiguracaoOAE';
$route['cadastro_oae_tableConfigOAECadastradas'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_config_oae';
$route['cadastro_oae_gravaConfigOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/gravaconfigoae';
$route['cadastro_oae_tableRecuperaTrecho'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_trecho';
$route['cadastro_oae_Recupera_tipo_oae'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_tipo_oae';
$route['cadastro_oae_Recupera_tipo_oae_trecho'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_tipo_oae_trecho';
$route['cadastro_oae_Recupera_tipo_intervencao'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_tipo_intervencao';
$route['cadastro_oae_Recupera_tipo_intervencao_trecho'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_tipo_intervencao';
$route['cadastro_oae_Recupera_concepcao_projeto'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_concepcao_projeto';
$route['cadastro_oae_Recupera_oae_fundacao'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_oae_fundacao';
$route['cadastro_oae_Recupera_oae_estrutura'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_oae_estrutura';
$route['cadastro_oae_Recupera_oae_local'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_oae_local';
$route['cadastro_oae_pesquisarOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_config_oae';
$route['cadastro_oae_EditarConfigOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/editarconfigoae';
$route['cadastro_oae_tableAnexos'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/RecuperaAnexoOAE';
$route['cadastro_oae_insereAnexo'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/insereAnexo';
$route['cadastro_oae_excluirArquivo'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/excluirArquivo';
$route['cadastro_oae_gravaTrechoOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/gravaTrechoOAE';
$route['cadastro_oae_excluirTrecho'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/excluirTrecho';
$route['cadastro_oae_naoPossuiOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/naoPossuiOAE';
$route['cadastro_oae_excluirOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/excluirOAE';
$route['cadastro_oae_editarOAE'] = 'homeCgcont/Supervisaocont/Configoae/Configoaectr/Recupera_config_oae_edicao';
$route['cadastro_oae_populaTipoEixoOAE'] = 'homeCgcont/Supervisaocont/Georreferenciamento/Georreferenciamento/populaTipoEixo';
################################################################################
//home
$route['home_rotaCgcont'] = 'Home/homeCgcont';
$route['home'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/insereEnsaioLaboratorio';
$route['home'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/insereNaoAtividade';
$route['home'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/recuperaEnsaiosLaboratorio';
$route['home'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/recuperaEnsaiosLaboratorio';
$route['home'] = 'homeCgcont/Supervisaocont/EnsaioConstrucao/EnsaioConstrucao/excluirArquivo';
################################################################################
//Empreendimento
$route['empreendimento_rotaEmpreendimento'] = '/homeCgcont/HomeCgcont/homeEmpreendimento';
$route['empreendimento_Recupera_uf'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recupera_uf';
$route['empreendimento_Recupera_br'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recupera_br';
$route['empreendimento_Recupera_empreendimento'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recupera_empreendimento';
$route['empreendimento_Recupera_dados_empreendimento'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recupera_dados_empreendimento';
$route['empreendimento_Recupera_fotos'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recupera_fotos';
$route['empreendimento_RecuperaGrafCurvaS'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaGrafCurvaS';
$route['empreendimento_Recupera_financeiro'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recupera_financeiro';
$route['empreendimento_Recupera_avanco'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recupera_avanco';
$route['empreendimento_grafico_obra_oae_constr'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaGrafOAEConst';
$route['empreendimento_Medicao'] = '/homeCgcont/Empreendimento/Empreendimentoctr/TablePainelMedicoes';
$route['empreendimento_RecuperaAtivos'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaAtivos';
$route['empreendimento_RecuperaPessoasMobilizadas'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaPessoasMobilizadas';
$route['empreendimento_RecuperaFinanceiro'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaFinanceiro';
$route['empreendimento_RecuperaQuadroFinanceiro'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaQuadroFinanceiro';
$route['empreendimento_RecuperaGrafDadosFinanc'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaGrafDadosFinanc';
$route['empreendimento_RecuperaExtensao'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaExtensao';
$route['empreendimento_RecuperaUnifilar3D'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaUnifilar3D';
$route['empreendimento_RecuperaContratoMapa'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaContratoMapa';
$route['empreendimento_Recuperaavancototal'] = '/homeCgcont/Empreendimento/Empreendimentoctr/Recuperaavancototal';
$route['empreendimento_grafico_obra_oae_constr_pizza'] = '/homeCgcont/Empreendimento/Empreendimentoctr/RecuperaGrafOAEConstPizza';
################################################################################
//Gerenciamento
$route['gerenciamento_rotaGerenciamento'] = '/homeCgcont/HomeCgcont/homeGerenciamento';
$route['gerenciamento_rotaRelatoriosGerenciamento'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/homeRelatoriosGerenciamento';
$route['gerenciamento_passaId'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/Adicionasession';
$route['gerenciamento_InformacoesContrato'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/InformacoesContrato';
$route['gerenciamento_confereMenu'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/ConfereMenu';
$route['gerenciamento_confereMenuModal'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/ConfereMenuModal';
$route['gerenciamento_rotaVinculardisciplina'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/VincularDisciplina';
$route['gerenciamento_rotaIncluirDocumento'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/Recuperadocumento';
$route['gerenciamento_rotaIncluirProjeto'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/RecuperaProjeto';
$route['gerenciamento_rotaListaEntrega'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/RecuperaListaEntrega';
$route['gerenciamento_rotaResumoEntrega'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/RecuperaResumoEntrega';
$route['gerenciamento_rotaArquivo'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/Arquivos';
$route['gerenciamento_Recuperatabelacontratos'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/Tabelacontratoobra';
$route['gerenciamento_search_btn'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/RecuperaContrato';
$route['gerenciamento_RecuperaTabelaContrato'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/RecuperaTabelaContrato';
$route['gerenciamento_recuperaAnexo'] = 'homeCgcont/Gerenciamento/Arquivosctr/RecuperaAnexos';
$route['gerenciamento_insereAnexos'] = 'homeCgcont/Gerenciamento/Arquivosctr/insereAnexo';
$route['gerenciamento_excluirArquivo'] = 'homeCgcont/Gerenciamento/Arquivosctr/excluirArquivo';
$route['gerenciamento_confereRelatorio'] = 'homeCgcont/Gerenciamento/Arquivosctr/confereRelatorio';
$route['home_rotaAnaliseRelatorioGerenciamento'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/homeAnaliseRelatorioGerenciamento';

//Gerenciamento imprimir
$route['gerenciamento_rotaImprimir'] = 'homeCgcont/Gerenciamento/Gerenciamentoctr/Imprimir';
$route['gerenciamento_RecuperaAnalise'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaAnalise';
$route['gerenciamento_HistoricoAnaliseEstruturada'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnaliseEstruturada';
$route['gerenciamento_HistoricoAnaliseTecnica'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnaliseTecnica';
$route['gerenciamento_elaboracao'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_elaboracao';
$route['gerenciamento_conclusao'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_elaboracao';
$route['gerenciamento_analisetecnica'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_analise_tecnica';
$route['gerenciamento_analiseestrutural'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_analise_estrutural';
$route['gerenciamento_imprimir'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_imprimir';
$route['gerenciamento_dadosContrato'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaDadosContratoVersaoRelatorio';
$route['gerenciamento_aguardandoanalise'] = 'homeCgcont/Gerenciamento/Imprimirctr/Aguardandoanalise';
$route['gerenciamento_Concluirrelatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/Concluirrelatorio';
$route['gerenciamento_GerarResultadoEstrutural'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnalise';
$route['gerenciamento_GerarResultadoTecnico'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnalise';
$route['gerenciamento_Liberarrelatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/Liberarrelatorio';
$route['gerenciamento_dadosRelatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaRelatorio';
$route['gerenciamento_Recupera_roteiro'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_roteiro';
$route['gerenciamento_GerarRecibo'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_valida_recibo';
$route['gerenciamento_Recupera_valida_liberar_relatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_valida_liberar_relatorio';
$route['gerenciamento_imprimir_rotaImprimirRelatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/ImprimirRelatorio';
$route['gerenciamento_imprimir_RecuperaAnalise'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaAnalise';
$route['gerenciamento_imprimir_HistoricoAnaliseEstruturada'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnaliseEstruturada';
$route['gerenciamento_imprimir_HistoricoAnaliseTecnica'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnaliseTecnica';
$route['gerenciamento_imprimir_elaboracao'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_elaboracao';
$route['gerenciamento_imprimir_conclusao'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_elaboracao';
$route['gerenciamento_imprimir_analisetecnica'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_analise_tecnica';
$route['gerenciamento_imprimir_analiseestrutural'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_analise_estrutural';
$route['gerenciamento_imprimir_imprimir'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_imprimir';
$route['gerenciamento_imprimir_dadosContrato'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaDadosContratoVersaoRelatorio';
$route['gerenciamento_imprimir_aguardandoanalise'] = 'homeCgcont/Gerenciamento/Imprimirctr/Aguardandoanalise';
$route['gerenciamento_imprimir_Concluirrelatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/Concluirrelatorio';
$route['gerenciamento_imprimir_GerarResultadoEstrutural'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnalise';
$route['gerenciamento_imprimir_GerarResultadoTecnico'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaHistoricoAnalise';
$route['gerenciamento_imprimir_Liberarrelatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/Liberarrelatorio';
$route['gerenciamento_imprimir_dadosRelatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/RecuperaRelatorio';
$route['gerenciamento_imprimir_Recupera_roteiro'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_roteiro';
$route['gerenciamento_imprimir_GerarRecibo'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_valida_recibo';
$route['gerenciamento_imprimir_Recupera_valida_liberar_relatorio'] = 'homeCgcont/Gerenciamento/Imprimirctr/Recupera_valida_liberar_relatorio';
################################################################################
//ANÁLISE DE RELATÓRIOS GERENCIAMENTO
//anliserelatorio.js
$route['gerenciamento_analise_RecuperaContratoAnalise'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/RecuperaContratoAnalise';
$route['gerenciamento_analise_Redireciona_inicio_analise'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/grava_inicio_analise';
$route['gerenciamento_analise_dadosContrato'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/RecuperaDadosContratoVersaoRelatorio';
$route['gerenciamento_analise_dadosRelatorio'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/RecuperaDadosAnalise';
$route['gerenciamento_analise_btnGravarAceite'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/grava_nao_aceite';
$route['gerenciamento_analise_RecuperaHistorico'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/RecuperaHistorico';
$route['gerenciamento_analise_AbreModalEditarAnalise'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/Recupera_motivo';
$route['gerenciamento_analise_btnAlteraAceite'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/Altera_aceite';
$route['gerenciamento_analise_Redireciona_excluir_analise'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/Exclui_aceite';
$route['gerenciamento_analise_btnGravarSatisfacao'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/Concluiranalise';
$route['gerenciamento_analise_analise_recuperaAnexo'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/RecuperaAnexos';
$route['gerenciamento_analise_btnGravarPontuacao'] = 'homeCgcont/AnaliseRelatorioGerenciamento/Analiserelatorioctr/grava_pontuacao';
$route['gerenciamento_analise_recuperaAnexo'] = 'homeCgcont/Gerenciamento/Arquivosctr/RecuperaAnexos';


################################################################################
#GESTÃO DE DEMANDAS.
$route['cgcont/gestao-demandas/busca-pendente'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/buscaPendente';
$route['cgcont/gestao-demandas/busca-andamento'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/buscaAndamento';
$route['cgcont/gestao-demandas/busca-concluida'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/buscaConcluida';
$route['cgcont/gestao-demandas/busca-demandas-completas'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/buscaDemandasCompletas';

$route['cgcont/gestao-demandas/recupera-coordenacao-usuario'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaCoordenacaoUsuario';
$route['cgcont/gestao-demandas/info-demanda-usuario'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaUsuario';
$route['cgcont/gestao-demandas/recupera-dados-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/recuperaDadosFiltro';
$route['cgcont/gestao-demandas/recupera-contrato'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaContrato';
$route['cgcont/gestao-demandas/recupera-rodovia'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaRodovia';
$route['cgcont/gestao-demandas/recupera-responsavel'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaResponsavel';
$route['cgcont/gestao-demandas/recupera-niveis'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaNiveis';
$route['cgcont/gestao-demandas/recupera-processo-SEI'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaProcessoSEI';
$route['cgcont/gestao-demandas/recupera-tipo-demanda'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaTipoDemanda';
$route['cgcont/gestao-demandas/recupera-responsavel-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaResponsavelFiltro';
$route['cgcont/gestao-demandas/recupera-processo-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaProcessoFiltro';
$route['cgcont/gestao-demandas/recupera-contrato-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaContratoFiltro';
$route['cgcont/gestao-demandas/recupera-coordenacao-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaCoordenacaoFiltro';
$route['cgcont/gestao-demandas/recupera-assunto-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaAssuntoFiltro';
$route['cgcont/gestao-demandas/recupera-rodovia-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaRodoviaFiltro';
$route['cgcont/gestao-demandas/recupera-uf-filtro'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaUfFiltro';
$route['cgcont/gestao-demandas/recupera-usuarios'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaUsuarios';
$route['cgcont/gestao-demandas/recupera-user-coordenacoes'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaUserCoordenacoes';
$route['cgcont/gestao-demandas/recupera-coordenacoes'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaCoordenacoes';
$route['cgcont/gestao-demandas/recupera-responsaveis'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaResponsaveis';
$route['cgcont/gestao-demandas/insere_relacionamento'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_relacionamento';
$route['cgcont/gestao-demandas/insere_coordenacao_setor'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_coordenacao_setor';
$route['cgcont/gestao-demandas/editar_assunto'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/editar_assunto';
$route['cgcont/gestao-demandas/insere_assunto'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_assunto';
$route['cgcont/gestao-demandas/recupera_editar_assunto'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/recuperaEditarAssunto';
$route['cgcont/gestao-demandas/exclui_assunto'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/excluiAssunto';
$route['cgcont/gestao-demandas/insere_edicao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_edicao';
$route['cgcont/gestao-demandas/insere_etapa_1'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_etapa_1';
$route['cgcont/gestao-demandas/Recupera_setoriais'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaSetoriais';
$route['cgcont/gestao-demandas/insere_etapa_2'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_etapa_2';
$route['cgcont/gestao-demandas/exclui_demanda'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/exclui_demanda';
$route['cgcont/gestao-demandas/insere_etapa_3'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_etapa_3';
$route['cgcont/gestao-demandas/insere_comentario'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_comentario';
$route['cgcont/gestao-demandas/exclui_comentario'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/exclui_comentario';
$route['cgcont/gestao-demandas/busca_comentario'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/buscaComentario';
$route['cgcont/gestao-demandas/insere_concluir'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_concluir';
$route['cgcont/gestao-demandas/insere_concluir_todos'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_concluir_todos';
$route['cgcont/gestao-demandas/insere_reprovar'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_reprovar';
$route['cgcont/gestao-demandas/insere_reatribuicao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_reatribuicao';
$route['cgcont/gestao-demandas/insere_paralisacao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_paralisacao';
$route['cgcont/gestao-demandas/insere_reabrir'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/insere_reabrir';
$route['cgcont/gestao-demandas/recupera_linha_tempo_post_it'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaLinhaTempoPostIt';
$route['cgcont/gestao-demandas/recupera_organograma'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaOrganograma';
$route['cgcont/gestao-demandas/acompanhamento_especial'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/acompanhamento_especial';
$route['cgcont/gestao-demandas/recupera_demandas'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaDemandas';
$route['cgcont/gestao-demandas/recupera_usuario_coordenacao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaUsuarioCoordenacao';
$route['cgcont/gestao-demandas/recupera_coordenacao_setor'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaCoordenacaoSetor';
$route['cgcont/gestao-demandas/recupera_assunto'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaAssunto';
$route['cgcont/gestao-demandas/exclui_relacionamento_user_coord'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/excluiRelacionamentoUserCoord';
$route['cgcont/gestao-demandas/exclui_setor_coord'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/excluiSetorCoord';
$route['cgcont/gestao-demandas/busca_dados_edicao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/buscaDadosEdicao';
$route['cgcont/gestao-demandas/graf_demandas_setor'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/grafDemandasSetor';
$route['cgcont/gestao-demandas/graf_assunto_setor'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/grafAssuntoSetor';
$route['cgcont/gestao-demandas/graf_tempo_execucao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/grafTempoExecucao';
$route['cgcont/gestao-demandas/graf_assunto_prazo'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/grafAssuntoPrazo';
$route['cgcont/gestao-demandas/info_demanda_regiao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaRegiao';
$route['cgcont/gestao-demandas/info_demanda_pendentes'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaPendentes';
$route['cgcont/gestao-demandas/info_demanda_andamento'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaAndamento';
$route['cgcont/gestao-demandas/info_demanda_concluida'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaConcluida';
$route['cgcont/gestao-demandas/info_demanda_paralisada'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaParalisada';
$route['cgcont/gestao-demandas/info_demanda_vencendo'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaVencendo';
$route['cgcont/gestao-demandas/info_demanda_sem_conclusao'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/infoDemandaSemConclusao';
$route['cgcont/gestao-demandas/graf_demanda_analista'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/grafDemandaAnalista';
$route['cgcont/gestao-demandas/recupera_info_demanda'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/RecuperaInfoDemanda';
$route['cgcont/gestao-demandas/graf_etapa_dias'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/grafEtapaDias';
$route['cgcont/gestao-demandas/demandas_exporta_excel'] = 'homeCgcont/GestaoDemandas/DemandasExportaExcel/index';
$route['cgcont/gestao-demandas/relatorio_demanda'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/relatorioDemanda';


################################################################################
#SIAMED (Organizador)

$route['assessoria_org/gestao-medicoes'] = 'homeDir/HomeDir/homeOrganizadorProcessos';
$route['assessoria_org/gestao-medicoes/painel-financeiro/gerar-excel-financeiro'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/FinanceiroMedExportaExcel';
$route['assessoria_org/gestao-medicoes/painel-processos/gerar-excel-processos'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/ProcessosExportaExcel';
$route['assessoria_org/gestao-medicoes/inserir-contrato'] = 'homeDir/OrganizadorProcessos/CadastroContrato/CadastroContrato/insereContrato';
$route['assessoria_org/gestao-medicoes/contrato/datatable-contrato'] = 'homeDir/OrganizadorProcessos/CadastroContrato/CadastroContrato/RecuperaContrato';
$route['assessoria_org/gestao-medicoes/manutencao/carga-contrato'] = 'homeDir/OrganizadorProcessos/CadastroContrato/CargaContrato/lerLinhasContrato';
$route['assessoria_org/gestao-medicoes/manutencao/carga-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/CargaMedicao/lerLinhasCargaMedicao';
$route['assessoria_org/gestao-medicoes/medicao/inserir-comentario-med-por-med'] = 'homeDir/OrganizadorProcessos/Medicao/CadastroComentario/insereComentarioMedPorMed';
$route['assessoria_org/gestao-medicoes/medicao/inserir-comentario'] = 'homeDir/OrganizadorProcessos/Medicao/CadastroComentario/insereComentario';
$route['assessoria_org/gestao-medicoes/medicao/inserir-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/CadastroMedicao/insereCadastroMedicao';
$route['assessoria_org/gestao-medicoes/medicao/inserir-pendencia'] = 'homeDir/OrganizadorProcessos/Medicao/CadastroPendencia/inserePendencia';
$route['assessoria_org/gestao-medicoes/medicao/popula-pendencia'] = 'homeDir/OrganizadorProcessos/Medicao/CadastroPendencia/populaPendencia';
$route['assessoria_org/gestao-medicoes/medicao/inserir-pendencia-siamed'] = 'homeDir/OrganizadorProcessos/Medicao/CadastroPendencia/inserePendenciaSIAMED';
$route['assessoria_org/gestao-medicoes/medicao/inserir-restricoes'] = 'homeDir/OrganizadorProcessos/Medicao/CadastroRestricoes/insereRestricoes';
$route['assessoria_org/gestao-medicoes/medicao/editar-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarMedicao';
$route['assessoria_org/gestao-medicoes/medicao/incluir-data-autuacao-click'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/incluirDataAutuacaoClick';
$route['assessoria_org/gestao-medicoes/medicao/incluir-data-autuacao-click-medpormed'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/incluirDataAutuacaoClickMedPorMed';
$route['assessoria_org/gestao-medicoes/medicao/retorno-medicao-superintendencia'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarRetornoSuperintendencia';
$route['assessoria_org/gestao-medicoes/medicao/retorno-medicao-superintendencia-med-por-med'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarRetornoSuperintendenciaMedporMed';
$route['assessoria_org/gestao-medicoes/medicao/assumir-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarAssumirMedicao';
$route['assessoria_org/gestao-medicoes/medicao/assumir-medicao-por-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarAssumirMedicaoPorMedicao';
$route['assessoria_org/gestao-medicoes/medicao/redistribuir-medicao-superintendencia'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarRedistribuirMedSuperintendencia';
$route['assessoria_org/gestao-medicoes/medicao/cancelar-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/cancelarMedicao';
$route['assessoria_org/gestao-medicoes/medicao/remover-cancelamento-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/removerCancelamentoMedicao';
$route['assessoria_org/gestao-medicoes/medicao/cancelar-medicao-med-por-med'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/cancelarMedicaoPorMedicao';
$route['assessoria_org/gestao-medicoes/medicao/remover-cancelamento-medicao-med-por-med'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/removerCancelamentoMedicaoPorMedicao';
$route['assessoria_org/gestao-medicoes/medicao/editar-medicao-med-por-med'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarMedicaoPorMedicao';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-financeiro-valor-total'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioFinanceiro/RecuperaRelatorioFinanceiroTotal';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-financeiro-valor-CGCONT'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioFinanceiro/RecuperaFinanceiroTotalCGCONT';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-financeiro-valor-CGMRR'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioFinanceiro/RecuperaFinanceiroTotalCGMRR';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-financeiro-valor-CGPERT'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioFinanceiro/RecuperaFinanceiroTotalCGPERT';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-financeiro-grafico'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioFinanceiro/RecuperaResumoFinanceiroMed';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-financeiro-table'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioFinanceiro/RecuperaRelatorioFinanceiro';
$route['assessoria_org/gestao-medicoes/relatorio/relatorio-processos-retorno'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioProcessos/RecuperaRelatorioRetorno';
$route['assessoria_org/gestao-medicoes/relatorio/relatorio-processos-financeiro'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioProcessos/RecuperaRelatorioProcessosFinanceiro';
$route['assessoria_org/gestao-medicoes/relatorio/relatorio-processos-financeiro-grafico'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioProcessos/RecuperaGraficoProcessosFinanceiro';
$route['assessoria_org/gestao-medicoes/relatorio/grafico-conferentes'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioProcessos/RecuperaGraficoProcessosConferentes';
$route['assessoria_org/gestao-medicoes/relatorio/relatorio-datatable-conferentes'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioProcessos/RecuperaDatatableConferentes';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-pendencias-total'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioPendencias/RecuperaRelatorioTodasMedicoes';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-pendencias-quantidade-pend'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioPendencias/RecuperaRelatorioTodasMedicoesComPendencia';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-pendencias-financeiro-total'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioPendencias/RecuperaFinanceiroTotal';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-pendencias-financeiro-total_pend'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioPendencias/RecuperaFinanceiroTotalPendencias';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-grafico-proporcao-pendencias'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioPendencias/RecuperaProporcaoPendencias';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-grafico-tipo-pendencias'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioPendencias/RecuperaGrafTipoPendencias';
$route['assessoria_org/gestao-medicoes/medicao/relatorio-datatable-pendencias'] = 'homeDir/OrganizadorProcessos/PainelGerencialOrganizador/RelatorioPendencias/RecuperaDatatablePendencias';
$route['assessoria_org/gestao-medicoes/distribuir/inserir-protocolar-medicao'] = 'homeDir/OrganizadorProcessos/ProtocolarMedicao/CadastroProtocolarMedicao/insereProtocoloMedicao';
$route['assessoria_org/gestao-medicoes/distribuir/inserir-distribuir-med-cgpert'] = 'homeDir/OrganizadorProcessos/ProtocolarMedicao/CadastroProtocolarMedicao/insereDistribuirMedCgpert';
$route['assessoria_org/gestao-medicoes/pesquisa/pesquisar-contrato'] = 'homeDir/OrganizadorProcessos/Organizador/resultado';
$route['assessoria_org/gestao-medicoes/rota-atividades-usuario'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorAtividadesUsuario';
$route['assessoria_org/gestao-medicoes/medicao/rota-dados-medicao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorDadosMedicao';
$route['assessoria_org/gestao-medicoes/medicao/rota-dados-medicao-por-medicao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorDadosMedicaoPorMedicao';
$route['assessoria_org/gestao-medicoes/medicao/rota-dados-contrato'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorDadosContrato';
$route['assessoria_org/gestao-medicoes/manutencao/rota-manutencao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorManutencao';
$route['assessoria_org/gestao-medicoes/manutencao/rota-administrar-usuarios'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorAdministrarUsuarios';
$route['assessoria_org/gestao-medicoes/medicao/rota-reatribuir-medicao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorReatribuirMedicao';
$route['assessoria_org/gestao-medicoes/manutencao/datatable-administrar-usuarios'] = 'homeDir/OrganizadorProcessos/Usuario/OrganizadorUsuarioCampos/RecuperaAdmUsuarios';
$route['assessoria_org/gestao-medicoes/manutencao/editar-administrar-usuarios'] = 'homeDir/OrganizadorProcessos/Usuario/OrganizadorUsuarioCampos/editarPerfilPermissao';
$route['assessoria_org/gestao-medicoes/manutencao/adm-usuarios-perfil'] = 'homeDir/OrganizadorProcessos/Usuario/OrganizadorUsuarioCampos/RecuperaDadosUsuariosPerfil';
$route['assessoria_org/gestao-medicoes/manutencao/editar-perfil-usuario'] = 'homeDir/OrganizadorProcessos/Usuario/OrganizadorUsuarioCampos/editarPerfilUsuario';
$route['assessoria_org/gestao-medicoes/manutencao/rota-administrar-unidades'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorAdministrarUnidades';
$route['assessoria_org/gestao-medicoes/medicao/rota-efetuar-baixa-medicoes'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorEfetuarBaixaMedicoes';
$route['assessoria_org/gestao-medicoes/medicao/rota-efetuar-carga-medicao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorEfetuarCarga';
$route['assessoria_org/gestao-medicoes/medicao/rota-efetuar-carga-contrato'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorCargaContrato';
$route['assessoria_org/gestao-medicoes/medicao/rota-gerenciamento-financeiro'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorGerenciamentoFinanceiro';
$route['assessoria_org/gestao-medicoes/medicao/rota-gerenciamento-processos'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorGerenciamentoProcessos';
$route['assessoria_org/gestao-medicoes/medicao/rota-gerenciamento-pendencias'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorGerenciamentoPendencias';
$route['assessoria_org/gestao-medicoes/contrato/rota-cadastro-contrato'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorCadastroContrato';
$route['assessoria_org/gestao-medicoes/monitoramentos/rota-monitoramentos'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorMonitoramentos';
$route['assessoria_org/gestao-medicoes/rota-cadastro-relatorio'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorCadastroRelatorio';
$route['assessoria_org/gestao-medicoes/rota-mapa-situacao-organizador'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorMapaSituacao';
$route['assessoria_org/gestao-medicoes/orcamento/rota-orcamento'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorOrcamento';
$route['assessoria_org/gestao-medicoes/rota-painel-controle'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorPainelControle';
$route['assessoria_org/gestao-medicoes/medicao/rota-distribuir-med-cgpert'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorDistribuirMedCgpert';
$route['assessoria_org/gestao-medicoes/rota-medicoes-produtividade'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorProdutividade';
$route['assessoria_org/gestao-medicoes/rota-consultar-medicao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorConsultarMedicao';
$route['assessoria_org/gestao-medicoes/medicao/rota-relatorio-medicao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorRelatorioMedicao';
$route['assessoria_org/gestao-medicoes/medicao/rota-redistribuir'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorRedistribuir';
$route['assessoria_org/gestao-medicoes/medicao/redistribuir-medicao'] = 'homeDir/OrganizadorProcessos/Medicao/EditarMedicao/editarRedistribuirMedicao';
$route['assessoria_org/gestao-medicoes/rota-consultar-ISSQN'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorConsultarISSQN';
$route['assessoria_org/gestao-medicoes/rota-distribuicao-medicao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorDistribuicaoMedicao';
$route['assessoria_org/gestao-medicoes/rota-orientacoes-internas'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorOrientacoesInternas';
$route['assessoria_org/gestao-medicoes/rota-pesquisar-documento'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorPesquisarDocumento';
$route['assessoria_org/gestao-medicoes/rota-cadastrar-documento'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorCadastrarDocumento';
$route['assessoria_org/gestao-medicoes/rota-processos-administrativos'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorProcessosAdministrativos';
$route['assessoria_org/gestao-medicoes/rota-numerar-documento'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorNumerarDocumento';
$route['assessoria_org/gestao-medicoes/rota-modelo-documento'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorModeloDocumento';
$route['assessoria_org/gestao-medicoes/rota-codigo-barras'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorCodigoBarras';
$route['assessoria_org/gestao-medicoes/rota-digitalizar-processo'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorDigitalizarProcesso';
$route['assessoria_org/gestao-medicoes/rota-patrimonios-processo'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorPatrimoniosProcesso';
$route['assessoria_org/gestao-medicoes/orcamento/rota-dotacoes-orcamentarias'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorDotacoesOrcamentarias';
$route['assessoria_org/gestao-medicoes/orcamento/rota-credito-disponivel-dotacao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorCreditoDisponivelDotacao';
$route['assessoria_org/gestao-medicoes/orcamento/rota-contingenciamento-credito'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoContingenciamentoCredito';
$route['assessoria_org/gestao-medicoes/orcamento/rota-empenhos-nao-vinculado'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoEmpenhosNaoVinculados';
$route['assessoria_org/gestao-medicoes/orcamento/rota-empreendimentos'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoEmpreendimentos';
$route['assessoria_org/gestao-medicoes/orcamento/rota-fornecedores'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoFornecedores';
$route['assessoria_org/gestao-medicoes/orcamento/rota-autorizacoes'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoAutorizacoes';
$route['assessoria_org/gestao-medicoes/orcamento/rota-quadros-confeccao'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoQuadrosConfeccao';
$route['assessoria_org/gestao-medicoes/orcamento/rota-registrar-autorizacao'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoRegistrarAutorizacao';
$route['assessoria_org/gestao-medicoes/orcamento/rota-quadros'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoQuadros';
$route['assessoria_org/gestao-medicoes/orcamento/rota-SMCO'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoSMCO';
$route['assessoria_org/gestao-medicoes/orcamento/rota-vinculacao-SIAC'] = 'homeDir/OrganizadorProcessos/Organizador/orcamentoVinculacaoSIAC';
$route['assessoria_org/gestao-medicoes/orcamento/rota-programacao'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorProgramacao';
$route['assessoria_org/gestao-medicoes/orcamento/rota-instrumentos'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorInstrumentos';
$route['assessoria_org/gestao-medicoes/orcamento/rota-exibir-informacoes-instumento'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorExibirInformacoesInstumento';
$route['assessoria_org/gestao-medicoes/orcamento/rota-cadastro-instrumento'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorCadastroInstrumento';
$route['assessoria_org/gestao-medicoes/orcamento/rota-solicitacao-empenho'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorSolicitacaoEmpenho';
$route['assessoria_org/gestao-medicoes/orcamento/rota-autorizacao-empenho'] = 'homeDir/OrganizadorProcessos/Organizador/organizadorAutorizacaoEmpenho';

################################################################################
#AVANCAR.
$route['cgcont/avancar/lista-atualizacoes'] = 'homeCgcont/Avancar/Avancar/listaAtualizacoes';
$route['cgcont/avancar/recuperar'] = 'homeCgcont/Avancar/Avancar/recuperar';
$route['cgcont/avancar/add-doc'] = 'homeCgcont/Avancar/Avancar/addDoc';
$route['cgcont/avancar/lista-regioes'] = 'homeCgcont/Avancar/Avancar/listaRegioes';
$route['cgcont/avancar/lista-br'] = 'homeCgcont/Avancar/Avancar/listaBr';
$route['cgcont/avancar/lista-estado-lote'] = 'homeCgcont/Avancar/Avancar/listaEstadoLote';
$route['cgcont/avancar/lista-empreendimento'] = 'homeCgcont/Avancar/Avancar/listaEmpreendimento';
$route['cgcont/avancar/atualizar-planilha'] = 'homeCgcont/Avancar/Avancar/atualizarPlanilha';
$route['cgcont/avancar/exporta-avancar'] = 'homeCgcont/Avancar/ExportaAvancar';
$route['cgcont/avancar/exporta-avancar-red'] = 'homeCgcont/Avancar/ExportaAvancarRed';

################################################################################
# CIPI - Ministérios
$route['cgcont/cipi/get_data'] = 'homeCgcont/Cipi/Cipi/get_data';
$route['cgcont/cipi/send_data'] = 'homeCgcont/Cipi/Cipi/send_data_to_cipi';
$route['cgcont/cipi/download'] = 'homeCgcont/Cipi/DownloadCipi';
$route['cgcont/cipi/get_transmissoes'] = 'homeCgcont/Cipi/Cipi/get_transmissoes';

################################################################################
# UNIFILAR
$route['unifilar3D_detalheOAE'] = 'homeCgcont/Unifilar3D/Unifilar3D/RecuperaDetalheOAE';

################################################################################
#BRIEFING.
$route['cgcont/briefing/insere-briefing'] = 'homeCgcont/Briefing/Briefing/insereBriefing';
$route['cgcont/briefing/unifilar3D'] = 'homeCgcont/Briefing/Briefing/RecuperaUnifilar3D';
$route['cgcont/briefing/adiciona-session'] = 'homeCgcont/Briefing/Briefing/Adicionasession';
$route['cgcont/briefing/recupera-contrato'] = 'homeCgcont/Briefing/Briefing/RecuperaContrato';
$route['cgcont/briefing/recupera-briefing'] = 'homeCgcont/Briefing/Briefing/recuperaBriefing';
$route['cgcont/briefing/fotos'] = 'homeCgcont/Briefing/Briefing/fotos';
$route['cgcont/briefing/briefing-sessao'] = 'homeCgcont/Briefing/Briefing/briefingSessao';
$route['cgcont/briefing/excluir-briefing'] = 'homeCgcont/Briefing/Briefing/excluirBriefing';
$route['cgcont/briefing/rota-briefing'] = 'homeCgcont/Briefing/Briefing/rotaBriefing';

################################################################################
#Ata Eletrônica
$route['cgcont/ata-eletronica/recupera-ata-coord-classificacao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaAtaCoordClassificacao';
$route['cgcont/ata-eletronica/recupera-ata'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaAta';
$route['cgcont/ata-eletronica/recupera-calendario'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaCalendario';
$route['cgcont/ata-eletronica/recupera-assunto'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaAssunto';
$route['cgcont/ata-eletronica/recupera-classificacao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaClassificacao';
$route['cgcont/ata-eletronica/recupera-coordenacao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaCoordenacao';
$route['cgcont/ata-eletronica/recupera-processo'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaProcesso';
$route['cgcont/ata-eletronica/recupera-contrato'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaContrato';
$route['cgcont/ata-eletronica/recupera-rodovia'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaRodovia';
$route['cgcont/ata-eletronica/recupera-participante'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaParticipante';
$route['cgcont/ata-eletronica/insere-reuniao'] = 'homeAtaEletronica/HomeAtaEletronica/insere_reuniao';
$route['cgcont/ata-eletronica/recupera-linha-tempo-reuniao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaLinhaTempoReuniao';
$route['cgcont/ata-eletronica/recupera-linha-tempo-coord-classificacao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaLinhaTempoCoordClassificacao';
$route['cgcont/ata-eletronica/recupera-lista-tratativa'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaListaTratativa';
$route['cgcont/ata-eletronica/recupera-table-tratativa'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableTratativa';
$route['cgcont/ata-eletronica/editar-tratativa'] = 'homeAtaEletronica/HomeAtaEletronica/editar_tratativa';
$route['cgcont/ata-eletronica/insere-tratativa'] = 'homeAtaEletronica/HomeAtaEletronica/insere_tratativa';
$route['cgcont/ata-eletronica/recupera-tratativa'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTratativa';
$route['cgcont/ata-eletronica/excluir-tratativa'] = 'homeAtaEletronica/HomeAtaEletronica/excluir_tratativa';
$route['cgcont/ata-eletronica/recupera-table-providencia'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableProvidencia';
$route['cgcont/ata-eletronica/editar-providencia'] = 'homeAtaEletronica/HomeAtaEletronica/editar_providencia';
$route['cgcont/ata-eletronica/insere-providencia'] = 'homeAtaEletronica/HomeAtaEletronica/insere_providencia';
$route['cgcont/ata-eletronica/recupera-providencia'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaProvidencia';
$route['cgcont/ata-eletronica/excluir-providencia'] = 'homeAtaEletronica/HomeAtaEletronica/excluir_providencia';
$route['cgcont/ata-eletronica/recupera-table-observacao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableObservacao';
$route['cgcont/ata-eletronica/editar-observacao'] = 'homeAtaEletronica/HomeAtaEletronica/editar_observacao';
$route['cgcont/ata-eletronica/insere-observacao'] = 'homeAtaEletronica/HomeAtaEletronica/insere_observacao';
$route['cgcont/ata-eletronica/recupera-observacao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaObservacao';
$route['cgcont/ata-eletronica/excluir-observacao'] = 'homeAtaEletronica/HomeAtaEletronica/excluir_observacao';
$route['cgcont/ata-eletronica/concluir-reuniao'] = 'homeAtaEletronica/HomeAtaEletronica/concluir_reuniao';
$route['cgcont/ata-eletronica/concluir-providencia'] = 'homeAtaEletronica/HomeAtaEletronica/concluir_providencia';
$route['cgcont/ata-eletronica/recupera-table-classificacao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableClassificacao';
$route['cgcont/ata-eletronica/recupera-table-assunto'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableAssunto';
$route['cgcont/ata-eletronica/editar-classificacao'] = 'homeAtaEletronica/HomeAtaEletronica/editar_classificacao';
$route['cgcont/ata-eletronica/insere-classificacao'] = 'homeAtaEletronica/HomeAtaEletronica/insere_classificacao';
$route['cgcont/ata-eletronica/editar-assunto'] = 'homeAtaEletronica/HomeAtaEletronica/editar_assunto';
$route['cgcont/ata-eletronica/insere-assunto'] = 'homeAtaEletronica/HomeAtaEletronica/insere_assunto';
$route['cgcont/ata-eletronica/recupera-table-ata-eletronica'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableAtaEletronica';
$route['cgcont/ata-eletronica/graf-classificacao'] = 'homeAtaEletronica/HomeAtaEletronica/grafClassificacao';
$route['cgcont/ata-eletronica/info-total-ata'] = 'homeAtaEletronica/HomeAtaEletronica/infoTotalAta';
$route['cgcont/ata-eletronica/info-providencia-concluida'] = 'homeAtaEletronica/HomeAtaEletronica/infoProvidenciaConcluida';
$route['cgcont/ata-eletronica/info-providencia-niniciada'] = 'homeAtaEletronica/HomeAtaEletronica/infoProvidenciaNIniciada';
$route['cgcont/ata-eletronica/info-providencia-vencida'] = 'homeAtaEletronica/HomeAtaEletronica/infoProvidenciaVencida';
$route['cgcont/ata-eletronica/recupera-table-info-providencia'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableInfoProvidencia';
$route['cgcont/ata-eletronica/recupera-reuniao'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaReuniao';
$route['cgcont/ata-eletronica/insere-agrupar'] = 'homeAtaEletronica/HomeAtaEletronica/insere_agrupar';
$route['cgcont/ata-eletronica/recupera-table-agrupar'] = 'homeAtaEletronica/HomeAtaEletronica/RecuperaTableAgrupar';
$route['cgcont/ata-eletronica/excluir-agrupamento'] = 'homeAtaEletronica/HomeAtaEletronica/excluir_agrupamento';
$route['cgcont/ata-eletronica/relatorio-reuniao'] = 'homeAtaEletronica/HomeAtaEletronica/RelatorioReuniao';

################################################################################
#QR CODE.
$route['cgcont/qr-code/recupera-contrato'] = 'homeCgcont/QRCode/QRCode/RecuperaContrato';
$route['cgcont/qr-code/recupera-dados-contrato'] = 'homeCgcont/QRCode/QRCode/RecuperaDadosContrato';

################################################################################
#ANOTAÇÕES.
$route['cgcont/anotacoes'] = 'homeCgcont/HomeCgcont/homeHistorico';

$route['cgcont/anotacoes/recupera-br'] = 'homeCgcont/Historico/Historico/Recupera_br';
$route['cgcont/anotacoes/recupera-contrato'] = 'homeCgcont/Historico/Historico/Recupera_contrato';
$route['cgcont/anotacoes/nota-historico'] = 'homeCgcont/Historico/Historico/NotaHistorico';
$route['cgcont/anotacoes/nota-usuario'] = 'homeCgcont/Historico/Historico/NotaUsuario';
$route['cgcont/anotacoes/insere-historico'] = 'homeCgcont/Historico/NotaHistorico/insere_historico';
$route['cgcont/anotacoes/busca-anotacoes'] = 'homeCgcont/Historico/Historico/buscaAnotacoes';
$route['cgcont/anotacoes/busca-comentario'] = 'homeCgcont/GestaoDemandas/GestaoDemandas/buscaComentario';
$route['cgcont/anotacoes/excluir-historico'] = 'homeCgcont/Historico/NotaHistorico/excluirHistorico';
$route['cgcont/anotacoes/detalhe-painel-gerencial'] = 'homeCgcont/Historico/Historico/detalhePainelGerencial';
$route['cgcont/anotacoes/usuario/insere-historico'] = 'homeCgcont/Historico/NotaUsuario/insere_historico';
$route['cgcont/anotacoes/usuario/busca-historico'] = 'homeCgcont/Historico/NotaUsuario/buscaHistorico';
$route['cgcont/anotacoes/usuario/excluir-historico'] = 'homeCgcont/Historico/NotaUsuario/excluirHistorico';

################################################################################
#AMBIENTE DE GESTÃO.
$route['cgcont/ambiente-de-gestao/obra/recupera-tipo-intervencao'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTipoIntervencao';
$route['cgcont/ambiente-de-gestao/painel/recupera-tipo-intervencao'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaTipoIntervencao';
$route['cgcont/ambiente-de-gestao/detalhe-painel-gerencial'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/detalhePainelGerencial';
$route['cgcont/ambiente-de-gestao/recupera-table-br-uf'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableBrUf';
$route['cgcont/ambiente-de-gestao/recupera-table-valor-vigente'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableValorVigente';
$route['cgcont/ambiente-de-gestao/recupera-table-termino-prevista'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableTerminoPrevista';
$route['cgcont/ambiente-de-gestao/recupera-table-saldo-empenho'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableSaldoEmpenho';
$route['cgcont/ambiente-de-gestao/recupera-table-saldo-empenho-RAP'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableSaldoEmpenhoRAP';
$route['cgcont/ambiente-de-gestao/recupera-table-a-medir'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableAMedir';
$route['cgcont/ambiente-de-gestao/recupera-graf-terraplanagem'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaGrafTerraplanagem';
$route['cgcont/ambiente-de-gestao/recupera-graf-revestimento'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaGrafRevestimento';
$route['cgcont/ambiente-de-gestao/recupera-table-relatorio'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableRelatorio';
$route['cgcont/ambiente-de-gestao/recupera-table-qtd-obras-supervisora'] = 'homeCgcont/AmbienteGestao/AmbienteGestao/RecuperaTableQtdObrasSupervisora';

$route['cgcont/ambiente-de-gestao/financeiro/recupera-tipo-intervencao'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaTipoIntervencao';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-situacao'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaSituacao';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-custo-medio-real'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaCustoMedioReal';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-custo-medio-real-ano'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaCustoMedioRealAno';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-execucao-orcamentaria-empenho'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaExecucaoOrcamentariaEmpenho';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-execucao-financeira-medicao'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaExecucaoFinanceiraMedicao';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-resumo-contratos'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaResumoContratos';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-situacao-orcamento'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaSituacaoOrcamento';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-situacao-orcamento-estado'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaSituacaoOrcamentoEstado';
$route['cgcont/ambiente-de-gestao/financeiro/recupera-table-financeiro-v2'] = 'homeCgcont/AmbienteGestao/Financeiro/RecuperaTableFinanceiro_v2';
$route['cgcont/ambiente-de-gestao/financeiro/financeiro-exporta-excel'] = 'homeCgcont/AmbienteGestao/FinanceiroExportaExcel';

$route['cgcont/ambiente-de-gestao/obra/recupera-contratos-convenios'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaContratosConvenios';
$route['cgcont/ambiente-de-gestao/obra/recupera-situacao-contratos'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaSituacaoContratos';
$route['cgcont/ambiente-de-gestao/obra/recupera-programas'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaProgramas';
$route['cgcont/ambiente-de-gestao/obra/recupera-modalidade-licitacao'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaModalidadeLicitacao';
$route['cgcont/ambiente-de-gestao/obra/recupera-contratos-assinados-cgcont'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaContratosAssinadosCgcont';
$route['cgcont/ambiente-de-gestao/obra/recupera-contratos-obra-paralisados'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaContratosObraParalisados';
$route['cgcont/ambiente-de-gestao/obra/recupera-contratos-rescindidos'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaContratosRescindidos';
$route['cgcont/ambiente-de-gestao/obra/recupera-contratos-vencendo'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaContratosVencendo';
$route['cgcont/ambiente-de-gestao/obra/recupera-contratos-aditivados'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaContratosAditivados';
$route['cgcont/ambiente-de-gestao/obra/recupera-licenca-ambientais'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaLicencasAmbientais';
$route['cgcont/ambiente-de-gestao/obra/recupera-execucao-contrato'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaExecucaoContrato';
$route['cgcont/ambiente-de-gestao/obra/recupera-aditamento-contrato'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaAditamentoContrato';
$route['cgcont/ambiente-de-gestao/obra/recupera-paralisacao-contrato'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaParalisacaoContrato';
$route['cgcont/ambiente-de-gestao/obra/recupera-avanco-fisico-pista'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaAvancoFisicoPista';
$route['cgcont/ambiente-de-gestao/obra/recupera-revestimento'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaRevestimento';
$route['cgcont/ambiente-de-gestao/obra/recupera-terraplanagem'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTerraplanagem';
$route['cgcont/ambiente-de-gestao/obra/recupera-avanco-fisico-OAE'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaAvancoFisicoOAE';
$route['cgcont/ambiente-de-gestao/obra/recupera-table-avanco-fisico'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTableAvancoFisico';
$route['cgcont/ambiente-de-gestao/obra/recupera-table-assinados-mes'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTableAssinadosMes';
$route['cgcont/ambiente-de-gestao/obra/recupera-table-paralisados'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTableParalisados';
$route['cgcont/ambiente-de-gestao/obra/recupera-table-rescindido'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTableRescindido';
$route['cgcont/ambiente-de-gestao/obra/recupera-table-finalizado-60dias'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTableFinalizado60dias';
$route['cgcont/ambiente-de-gestao/obra/recupera-table-aditamento'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTableAditamento';
$route['cgcont/ambiente-de-gestao/obra/recupera-table-licenciamento'] = 'homeCgcont/AmbienteGestao/Obra/RecuperaTableLicenciamento';
$route['cgcont/ambiente-de-gestao/obra-exporta-excel'] = 'homeCgcont/AmbienteGestao/ObraExportaExcel';

$route['cgcont/ambiente-de-gestao/painel/recupera-pavimentadas'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaPavimentadas';
$route['cgcont/ambiente-de-gestao/painel/recupera-nao-pavimentadas'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaNaoPavimentadas';
$route['cgcont/ambiente-de-gestao/painel/recupera-num-contratos'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaNumContratos';
$route['cgcont/ambiente-de-gestao/painel/recupera-total-contratado'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaTotalContratado';
$route['cgcont/ambiente-de-gestao/painel/recupera-pessoas-mobilizadas'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaPessoasMobilizadas';
$route['cgcont/ambiente-de-gestao/painel/recupera-custo-km'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaCustoKm';
$route['cgcont/ambiente-de-gestao/painel/recupera-total-pista-dupla'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaTotalPistaDupla';
$route['cgcont/ambiente-de-gestao/painel/recupera-total-pista-simples'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaTotalPistaSimples';
$route['cgcont/ambiente-de-gestao/painel/recupera-resumo-financeiro'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaResumoFinanceiro';
$route['cgcont/ambiente-de-gestao/painel/recupera-malha-contratos-cgcont'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaMalhaContratosCgcont';
$route['cgcont/ambiente-de-gestao/painel/recupera-maiores-contratos'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaMaioresContratos';
$route['cgcont/ambiente-de-gestao/painel/recupera-real-contratado'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaRealContratado';
$route['cgcont/ambiente-de-gestao/painel/recupera-historico-pista-duplicada'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaHistoricoPistaDuplicada';
$route['cgcont/ambiente-de-gestao/painel/recupera-historico-pista-simples'] = 'homeCgcont/AmbienteGestao/Painel/RecuperaHistoricoPistaSimples';

$route['cgcont/ambiente-de-gestao/supervisao/recupera-empresas-supervisoras'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaEmpresasSupervisoras';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-supervisoras-contratadas'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaSupervisorasContratadas';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-super-ativas-obras-para'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaSuperAtivasObrasPara';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-vencem-60dias'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaVencem60Dias';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-obras-supervisao'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaObrasSupervisao';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-taxa-recebimento'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaTaxaRecebimento';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-recebidos-prazo'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaRecebidosPrazo';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-taxa-aceitacao'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaTaxaAceitacao';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-dias-analise-relatorio'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaDiasAnaliseRelatorio';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-situacao-relatorios'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaSituacaoRelatorios';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-table-todas-supervisoras'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaTableTodasSupervisoras';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-superv-atraso'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaSupervAtraso';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-superv-reanalise'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaSupervReanalise';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-tbl-supervisoras-contratadas'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaTblSupervisorasContratadas';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-tbl-sup-ativas-obras-paralisadas'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaTblSupAtivasObrasParalisadas';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-tbl-sup-vencem-60dias'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaTblSupVencem60dias';
$route['cgcont/ambiente-de-gestao/supervisao/recupera-tbl-obra-sem-supervisao'] = 'homeCgcont/AmbienteGestao/Supervisao/RecuperaTblObrasemSupervisao';


$route['cgcont/ambiente-de-gestao/empreendimento/Recupera-br'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_br';
$route['cgcont/ambiente-de-gestao/empreendimento/Recupera-empreendimento'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_empreendimento';
$route['cgcont/ambiente-de-gestao/empreendimento/Recupera-contratos-paralisam-mes'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_contratos_paralisam_mes';
$route['cgcont/ambiente-de-gestao/empreendimento/tabelaParalisado'] = 'homeCgcont/AmbienteGestao/Empreendimento/RecuperaTableParalisado';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-contratos-vencendo-mes'] = 'homeCgcont/AmbienteGestao/Empreendimento/RecuperaContratosVencendoMes';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-table-finalizado-mes'] = 'homeCgcont/AmbienteGestao/Empreendimento/RecuperaTableFinalizadoMes';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-contratos-recurso-finalizar'] = 'homeCgcont/AmbienteGestao/Empreendimento/RecuperaContratosRecursoFinalizar';
$route['cgcont/ambiente-de-gestao/empreendimento/tabelaRecursoFinalizar'] = 'homeCgcont/AmbienteGestao/Empreendimento/tabelaRecursoFinalizar';
$route['cgcont/ambiente-de-gestao/empreendimento/tabelaEmpreendimento'] = 'homeCgcont/AmbienteGestao/Empreendimento/tabelaEmpreendimento';
$route['cgcont/ambiente-de-gestao/empreendimento/Recupera-contratos-falta-10-finalizar'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_contratos_falta_10_finalizar';
$route['cgcont/ambiente-de-gestao/empreendimento/tabelaRecursoFinalizarFalta10'] = 'homeCgcont/AmbienteGestao/Empreendimento/tabelaRecursoFinalizarFalta10';
$route['cgcont/ambiente-de-gestao/empreendimento/Recupera-contratos-falta-20-finalizar'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_contratos_falta_20_finalizar';
$route['cgcont/ambiente-de-gestao/empreendimento/tabelaRecursoFinalizarFalta20'] = 'homeCgcont/AmbienteGestao/Empreendimento/tabelaRecursoFinalizarFalta20';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-meta-acumulado-mes'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_meta_acumulado_mes';
$route['cgcont/ambiente-de-gestao/empreendimento/Recupera-acumulado-mes-loa'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_acumulado_mes_loa';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-meta-oae'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_meta_oae';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-grafico-loa'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_grafico_loa';
$route['cgcont/ambiente-de-gestao/empreendimento/Recupera-grafico-ploa'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_grafico_ploa';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-grafico-meta-fisica'] = 'homeCgcont/AmbienteGestao/Empreendimento/Recupera_grafico_meta_fisica';
$route['cgcont/ambiente-de-gestao/empreendimento/recupera-table-financeiro-v2'] = 'homeCgcont/AmbienteGestao/Empreendimento/RecuperaTableFinanceiro_v2';



################################################################################
#CONFIG SUPERVISORA.
$route['cgcont/config-supervisora/recupera-br-filtro'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/RecuperaBrFiltro';
$route['cgcont/config-supervisora/recupera-status-filtro'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/RecuperaStatusFiltro';
$route['cgcont/config-supervisora/recupera-contrato-supervisao'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/RecuperaContratoSupervisao';
$route['cgcont/config-supervisora/recupera-contrato-gerenciamento'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/RecuperaContratoGerenciamento';
$route['cgcont/config-supervisora/recupera-programa'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/RecuperaPrograma';
$route['cgcont/config-supervisora/contagem-linhas'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/contagemLinhas';
$route['cgcont/config-supervisora/upload-config-supervisora'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/uploadConfigSupervisora';
$route['cgcont/config-supervisora/apaga-todos-publicarN'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/ApagaTodosPublicarN';
$route['cgcont/config-supervisora/recupera-config-supervisora'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/RecuperaConfigSupervisora';
$route['cgcont/config-supervisora/recupera-contrato-obra'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/RecuperaContratoObra';
$route['cgcont/config-supervisora/inserir-config-supervisora'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/inserirConfigSupervisora';
$route['cgcont/config-supervisora/editar-config-supervisora'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/editarConfigSupervisora';
$route['cgcont/config-supervisora/excluir-config-supervisora'] = 'homeCgcont/ConfigSupervisora/ConfigSupervisora/excluirConfigSupervisora';
$route['cgcont/config-supervisora/exporta-config-supervisora'] = 'homeCgcont/ConfigSupervisora/ExportaConfigSupervisora';

################################################################################
#ADMINISTRACAO.
$route['cgcont/administracao/altera-usuario/recupera-altera-dados'] = 'homeCgcont/Administracao/AlteraUsuario/AlteraUsuario/recuperaAlteraDados';
$route['cgcont/administracao/altera-usuario/recupera-dados-usuario'] = 'homeCgcont/Administracao/AlteraUsuario/AlteraUsuario/recuperaDadosUsuario';
$route['cgcont/administracao/altera-usuario/alterar-dados-usuario'] = 'homeCgcont/Administracao/AlteraUsuario/AlteraUsuario/alterarDadosUsuario';

$route['cgcont/administracao/atualiza-perfil-permissoes/recupera-atualiza-perfil-permissao'] = 'homeCgcont/Administracao/AtualizaPerfilPermissoes/AtualizaPerfilPermissoes/recuperaAtualizaPerfilPermissao';
$route['cgcont/administracao/atualiza-perfil-permissoes/altera-perfil-permissao'] = 'homeCgcont/Administracao/AtualizaPerfilPermissoes/AtualizaPerfilPermissoes/alteraPerfilPermissao';

$route['cgcont/administracao/cgplan/recupera-contrato'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaContrato';
$route['cgcont/administracao/cgplan/recupera-localizacao'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaLocalizacao';
$route['cgcont/administracao/cgplan/recupera-cronograma-fisico'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaCronogramaFisico';
$route['cgcont/administracao/cgplan/recupera-avanco-fisico'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaAvancoFisico';
$route['cgcont/administracao/cgplan/recupera-cronograma-financeiro'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaCronogramaFinanceiro';
$route['cgcont/administracao/cgplan/recupera-avanco-financeiro'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaAvancoFinanceiro';
$route['cgcont/administracao/cgplan/recupera-medicao'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaMedicao';
$route['cgcont/administracao/cgplan/recupera-empenho'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaEmpenho';
$route['cgcont/administracao/cgplan/recupera-idfn'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaIdfn';
$route['cgcont/administracao/cgplan/recupera-aditivo'] = 'homeCgcont/Administracao/Cgplan/Cgplancrt/RecuperaAditivo';

$route['cgcont/administracao/cod-sicro/popula-itens'] = 'homeCgcont/Administracao/CodSicro/CodSicroctr/populaItens';
$route['cgcont/administracao/cod-sicro/recupera-itens'] = 'homeCgcont/Administracao/CodSicro/CodSicroctr/recuperaItens';
$route['cgcont/administracao/cod-sicro/insere-itens-relacionados'] = 'homeCgcont/Administracao/CodSicro/CodSicroctr/insereItensRelacionados';
$route['cgcont/administracao/cod-sicro/detalhe-relacao-obra'] = 'homeCgcont/Administracao/CodSicro/CodSicroctr/detalheRelacaoObra';

$route['cgcont/administracao/mapa-situacao/recupera-mapa-situacao'] = 'homeCgcont/Administracao/MapaSituacao/MapaSituacaoctr/recuperaMapaSituacao';
$route['cgcont/administracao/mapa-situacao/insere-mapas-de-situacao'] = 'homeCgcont/Administracao/MapaSituacao/MapaSituacaoctr/insereMapasDeSituacao';

$route['cgcont/administracao/nova-supervisora/recupera-nova-supervisora'] = 'homeCgcont/Administracao/NovaSupervisora/NovaSupervisora/recuperaNovaSupervisora';
$route['cgcont/administracao/nova-supervisora/insere-nova-supervisora'] = 'homeCgcont/Administracao/NovaSupervisora/NovaSupervisora/insereNovasupervisora';

$route['cgcont/administracao/relaciona-grupo-contrato/recupera-grupo-contrato'] = 'homeCgcont/Administracao/RelacionaGrupoContrato/RelacionaGrupoContrato/recuperaGrupoContrato';
$route['cgcont/administracao/relaciona-grupo-contrato/insere-novo-grupo-contrato'] = 'homeCgcont/Administracao/RelacionaGrupoContrato/RelacionaGrupoContrato/insereNovoGrupoContrato';
$route['cgcont/administracao/relaciona-grupo-contrato/recupera-contrato-relacionados'] = 'homeCgcont/Administracao/RelacionaGrupoContrato/RelacionaGrupoContrato/recuperaContratoRelacionados';
$route['cgcont/administracao/relaciona-grupo-contrato/insere-contratos-supervisora'] = 'homeCgcont/Administracao/RelacionaGrupoContrato/RelacionaGrupoContrato/insereContratosSupervisora';

$route['cgcont/administracao/relaciona-usuario-contrato/recupera-relacao-usuario-contrato'] = 'homeCgcont/Administracao/RelacionaUsuarioContrato/RelacionaUsuarioContrato/recuperaRelacaoUsuarioContrato';
$route['cgcont/administracao/relaciona-usuario-contrato/insere-relacao-grupo-usuario'] = 'homeCgcont/Administracao/RelacionaUsuarioContrato/RelacionaUsuarioContrato/insereRelacaoGrupoUsuario';
$route['cgcont/administracao/relaciona-usuario-contrato/recupera-contratos-supervisora'] = 'homeCgcont/Administracao/RelacionaUsuarioContrato/RelacionaUsuarioContrato/recuperaContratosSupervisora';
$route['cgcont/administracao/relaciona-usuario-contrato/insere-relacao-contrato-usuario'] = 'homeCgcont/Administracao/RelacionaUsuarioContrato/RelacionaUsuarioContrato/insereRelacaoContratoUsuario';
$route['cgcont/administracao/relaciona-usuario-contrato/excluir-relacao-contrato-usuario'] = 'homeCgcont/Administracao/RelacionaUsuarioContrato/RelacionaUsuarioContrato/excluirRelacaoContratoUsuario';

$route['cgcont/administracao/resetar-bloquear-senha/recupera-reset-bloqueio-senha'] = 'homeCgcont/Administracao/ResetarBloquearSenha/ResetarBloquearSenha/recuperaResetBloqueioSenha';
$route['cgcont/administracao/resetar-bloquear-senha/reseta-senha'] = 'homeCgcont/Administracao/ResetarBloquearSenha/ResetarBloquearSenha/resetaSenha';
$route['cgcont/administracao/resetar-bloquear-senha/bloqueia-acesso'] = 'homeCgcont/Administracao/ResetarBloquearSenha/ResetarBloquearSenha/bloqueiaAcesso';

$route['cgcont/administracao/solitacao-acesso/recupera-solicitacao-acesso'] = 'homeCgcont/Administracao/Solitacaoacesso/SolitacaoAcesso/recuperaSolicitacaoAcesso';
$route['cgcont/administracao/solitacao-acesso/insere-usuario'] = 'homeCgcont/Administracao/Solitacaoacesso/SolitacaoAcesso/insereUsuario';
$route['cgcont/administracao/solitacao-acesso/nega-solicitacao'] = 'homeCgcont/Administracao/Solitacaoacesso/SolitacaoAcesso/negaSolicitacao';

$route['cgcont/administracao/cadastro-telas/recupera-modulo'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/recuperaModulo';
$route['cgcont/administracao/cadastro-telas/recupera-sistema'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/recuperaSistema';
$route['cgcont/administracao/cadastro-telas/insere-coordenacao'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/insereCoordenacao';
$route['cgcont/administracao/cadastro-telas/recupera-coordenacao'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/recuperaCoordenacao';
$route['cgcont/administracao/cadastro-telas/excluir-coordenacao'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/excluirCoordenacao';
$route['cgcont/administracao/cadastro-telas/insere-modulo'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/insereModulo';
$route['cgcont/administracao/cadastro-telas/insere-sistema'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/insereSistema';
$route['cgcont/administracao/cadastro-telas/insere-tela'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/insereTela';
$route['cgcont/administracao/cadastro-telas/recupera-tela'] = 'homeCgcont/Administracao/CadastroTelas/CadastroTelas/recuperaTela';

$route['cgcont/administracao/usuario-online/busca-usuarios'] = 'homeCgcont/Administracao/UsuarioOnline/UsuarioOnline/buscaUsuarios';

//############################################################################## 
//# FIM
//# DNIT
//# Rotas CGCONT
//# Desenvolvedor:Sergio Ricardo 
//# Data:01/10/2018 13:49
//# 
//##############################################################################

//////////
// COMUM
//////////
$route['geral/getcontratos_ws'] = 'Comum/consultaContratos/consultaContrato';
//#########################################################################

