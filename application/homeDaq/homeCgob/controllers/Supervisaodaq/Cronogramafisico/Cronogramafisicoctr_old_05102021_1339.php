<?php
/*
 * Classe controller Cronogramafisicoctr. 
 * @author Jordana de Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, FALCONI | DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Cronogramafisicoctr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_cronograma_fisico');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }
    
//-------------------------------------------------------------------------------------------------------------------------

    public function recuperaEixo() {
       $dados["id_eixo"] = $this->input->post_get("id_eixo");
       $dados["versao"] = $this->input->post_get("versao");
       $dados["id_contrato_obra"] = $this->session->idContrato;
       $dados["idUsuario"] = $this->session->id_usuario_daq;
       $DadosEixo = $this->Tb_cronograma_fisico->recuperaEixo($dados);
       
       $dados[] = Array();
       foreach ($DadosEixo as $lista) {
        $dados["nome"] = ($lista->nome);   
    }
    echo (json_encode($dados));
}
//-------------------------------------------------------------------------------------------------------------------------

    public function CronogramaNaoPublicado() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma_fisico_versao"] = $this->input->post_get("id_cronograma_fisico_versao");      

        $Dados = $this->Tb_cronograma_fisico->CronogramaNaoPublicado($dados);   
        $retorno["data"] = Array();

        $conte = (count($Dados));

        if (!empty($Dados)) {
            $linha = 1;
            $result = 'true';
            foreach ($Dados as $lista) {

                if($lista->publicar <> 0){

                    $servico = $this->Tb_cronograma_fisico->publicar_porcentagem($dados);

                    if (!empty($servico)){

                        $result = $servico[0]["result"];

                    }
                        if ($result == 'false'){
             
                            $publicar = "<button href='javascript:void(0);' onclick='MsgPublicar(" . $linha . "," . $conte . ");' type='button' id='publicado_naopublicado_$linha' name='publicado_naopublicado_$linha' class='btn btn-default' data-toggle='tooltip' title='Cronograma não pode ser publicado se o serviço em porcentagem for menor que 100%.' data-placement='top'><i class = 'far fa-clipboard'></i></buttonx>"; 
                        } else{

                            $publicar = "<button type='button' id='publicado_naopublicado_$linha' name='publicado_naopublicado_$linha' class='btn btn-default'  href='javascript:void(0);' onclick='PublicarCronograma_naopublicado(".$lista->id_cronograma.",".$lista->versao.",".$lista->id_eixo.")' data-toggle='tooltip' title='Publicar cronograma.' data-placement='top'><i class = 'fas fa-clipboard'></i></buttonx>"; 
                        }


                    $detalhar = "<button type='button' id='detalhar_naopublicado_$linha' name='detalhar_naopublicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='DetalhadoNaoPublicado(".$lista->id_cronograma.",".$lista->versao.",".$lista->id_eixo."," . $linha . ",".$conte.")'><i class = 'fa fa-eye'></i></buttonx>";
                    $inserir = "<button type='button' id='inserir_naopublicado_$linha' name='inserir_naopublicado_$linha' class='btn btn-warning' href='javascript:void(0);' onclick='inserirCronograma(". $lista->id_cronograma."," . $lista->versao."," .$lista->id_eixo .")'><i class = 'fas fa-pencil-alt'></i></buttonx>";
                        
                }else{
                    $detalhar = "<button type='button' id='detalhar_naopublicado_$linha' name='detalhar_naopublicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='(".$lista->id_cronograma.",".$lista->versao.",".$lista->id_eixo.")'><i class = 'fa fa-eye'></i></buttonx>";
                    $inserir = "<button type='button' id='inserir_naopublicado_$linha' name='inserir_naopublicado_$linha' class='btn btn-default' href='javascript:void(0);' onclick='inserirCronograma(". $lista->id_cronograma."," . $lista->versao."," .$lista->id_eixo .")'><i class = 'fas fa-pencil-alt'></i></buttonx>";
                    $publicar = "<button type='button' id='publicado_naopublicado_$linha' name='publicado_naopublicado_$linha' class='btn btn-default' data-toggle='tooltip' title='Cronograma não cadastrado.' data-placement='top'><i class = 'far fa-clipboard'></i></buttonx>"; 
                }
                if ($lista->nome == ''){
                    $lista->nome = "--";
                }
                $retorno["data"][] = array(
                    'n'=> $linha++,
                    'eixo'=> $lista->eixo,
                    // 'extensao'=> $lista->extensao,
                    //'inicial_final' => $lista->maior,
                    'versao'=> $lista->versao,
                    'desc_nome'=> $lista->nome,
                    'publicado'=> $lista->publicado, 
                    'detalhar'=> $detalhar,
                    'inserir'=> $inserir,
                    'publicar'=> $publicar
                );
            }
        }
        echo (json_encode($retorno));
    }
//-------------------------------------------------------------------------------------------------------------------------
    public function CronogramaPublicado() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        
        $Dados = $this->Tb_cronograma_fisico->CronogramaPublicado($dados);   
        $retorno["data"] = Array();

        $conte = (count($Dados));

        if (!empty($Dados)) {
            $linha = 1;
            foreach ($Dados as $lista) {
                $detalhar = "<button type='button' id='detalhar_ $linha' name='detalhar_ $linha' class='btn btn-default' href='javascript:void(0);' onclick='DetalhadoPublicado(".$lista->id_cronograma.",".$lista->versao.",".$lista->id_eixo."," . $linha . ",".$conte.")'><i class = 'fa fa-eye'></i></buttonx>";
                $inserir = "<button type='button' id='inserir_1' name='inserir_1' class='btn btn-warning' data-toggle='tooltip' title='Cronograma publicado não pode ser alterado.' data-placement='top'>--</i></buttonx>";
                $publicar = "<button type='button' id='publicado_1' name='publicado_1' class='btn btn-primary'  data-toggle='tooltip' title='Cronograma publicado não pode ser alterado.' data-placement='top'><i class = 'fa fa-ship'></i></buttonx>";

                $retorno["data"][] = array(
                    'n'=> $linha++,
                    'eixo'=> $lista->eixo,
                    // 'extensao'=> $lista->extensao,
                    //'inicial_final'=> $lista->maior,
                    'versao'=> $lista->versao,
                    'desc_nome'=> $lista->nome,
                    'data_cronograma'=> $lista->data_cronograma,
                    'publicado'=> 'Sim',
                    'data_publicar'=> $lista->data_publicacao,
                    'nome_publicar'=> $lista->nome_publi,
                    'detalhar'=> $detalhar,
                    'inserir'=> $inserir,
                    'publicar'=> $publicar
                );
            }
        }
        echo (json_encode($retorno));
    }
//------------------------------------------------------------------------------------------------------------------------
    public function RecuperaObra() {
        $DadosServico = $this->Tb_cronograma_fisico->recuperaObra();
        $n = 0;
        foreach ($DadosServico as $lista) {
            $dados['id_obra'][$n] = $lista->id_tipo_obra;
            $dados['obra'][$n] = str_replace("_", " ", $lista->desc_tipo_obra);
            $n++;
        }
        echo (json_encode($dados));
    }
//-------------------------------------------------------------------------------------------------------------------------
    public function recuperaServico() {
        $dados["id_obra"] = $this->input->post_get("id_obra");

        if ($dados["id_obra"] == 1){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraConstrucao();// TROQUEI POR CONSTRUÇÂO PORTUARIA
        }
         if ($dados["id_obra"] == 2){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraDerrocagem($dados);// permanece
        }
         if ($dados["id_obra"] == 3){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraDragagem($dados);// permanece
        }
         if ($dados["id_obra"] == 4){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraDesobstrucao($dados);//permanece
        }
         if ($dados["id_obra"] == 5){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraRecuperacao($dados); // TROQUEI por RECUPERACAO PORTUARIA
        }
         if ($dados["id_obra"] == 6){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraMonitoramento($dados); // TROQUEI por MONITORAMENTO HIDROVIARIO
        }
         if ($dados["id_obra"] == 7){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraNavioHaider($dados); //permanece
        }
         if ($dados["id_obra"] == 8){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraSinalHidro($dados); // OPERACAO
        }
        if ($dados["id_obra"] == 9){
            $dadosServico = $this->Tb_cronograma_fisico->recuperaObraEclusas($dados); //operacao
        }
       
        $n = 0;
        foreach ($dadosServico as $lista) {
            $dados['id_servico'][$n] = $lista->id_obra;
            $dados['desc_servico'][$n] = str_replace("_", " ", $lista->desc_obra);
            $n++;
        }
        echo (json_encode($dados));
    }
//-------------------------------------------------------------------------------------------------------------------------
    public function recuperaTipo() {
        $dados["id_servico"] = $this->input->post_get("servico");

        if ($dados["id_servico"] == 16){

                $dadosTipo = $this->Tb_cronograma_fisico->recuperaTipoEstruturaNaval($dados);

        } else{
                $dadosTipo = $this->Tb_cronograma_fisico->recuperaTipo($dados);
        }
        // $dados = $this->Tb_cronograma_fisico->recuperaDesc($dados);
        // $dados["desc_obra"]=$dados[0]["desc_obra"];

        $n = 0;
        foreach ($dadosTipo as $lista) {
            $dados['id_tipo'][$n] = $lista->id_tipo;
            $dados['tipo'][$n] = str_replace("_", " ", $lista->desc_tipo);
            $n++;
        }
        echo (json_encode($dados));
    }
//--------------------------------------------------------------------------------------------------------------------------
    public function Validar_Porcentagem () {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_servico"] = $this->input->post_get("id_servico");
        $dados["id_obra"] = $this->input->post_get("id_obra");
        $dados["versao"] = $this->input->post_get("versao");
        $dados["final_incluir"] = str_replace(",", ".", str_replace(".", "", $this->input->post("final")));
         
 
        $Dadosid = $this->Tb_cronograma_fisico->Validar_Porcentagem($dados);

        
        if(!empty($Dadosid)){
           $dados["valor"]=$Dadosid[0]["valor"];

            $valor = $dados["valor"];
    
            $valor_medido = 100 - $valor;

            if($dados["final_incluir"] > $valor_medido){
                $retorno["mensagem"] = "Ocorreu um erro [O valor informado ultrapassa 100%. Verificar valor inserido cronograma fisico!]";
                //$retorno["notify"] = "warning";
                die (json_encode($retorno));
            }
             $retorno= true; 
        }
        $retorno= true;
        echo (json_encode($retorno));
    }
//-------------------------------------------------------------------------------------------------------------------------
    public function insereCronogramaFisico(){
        $dados["id_contrato_obra"] = $this->session->idContrato;  
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["id_eixo"] = $this->input->post_get('id_eixo');

        $DadosCronogramaFisicoVersao = $this->Tb_cronograma_fisico->recuperaVersao($dados);

        if(!empty($DadosCronogramaFisicoVersao)){ 

            foreach ($DadosCronogramaFisicoVersao as $lista) {
                $dados["id_cronograma_fisico_versao"] = $lista->id_cronograma_fisico_versao;
                $dados["versao"] = $lista->versao;
                $dados["id_cronograma"] = $lista->id_cronograma;
                $dados["publicar_cronograma"] = $lista->publicar_cronograma;
            }
            $dados["ano"] = $this->input->post_get("valanoreferente");
            $dados["id_servico"] = $this->input->post_get("servico");
            $dados["id_obra"] = $this->input->post_get("obra");
            $dados["tipo"] = $this->input->post_get("tipo");
            $dados["medicao"] = $this->input->post_get("medicao");

            for ($j = 1; $j <= 12; $j++) {
                if (!empty($this->input->post("mes")[$j])) {
                    $dados["mes"] = $this->input->post("mes")[$j];
                    //$dados["valor_inicial"] = str_replace(",", ".", $this->input->post("valor_inicial")[$j]);
                    $dados["valor_medido"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor_medido")[$j]));
                    if (!empty($this->input->post("valor_medido")[$j])) {
                        $dados["total"]=$dados["valor_medido"];
                        $retorno = $this->Tb_cronograma_fisico->insereCronogramaFisico($dados);
                    }
                }
            }
            die(json_encode($retorno));
        } 
    }  
//-------------------------------------------------------------------------------------------------------------------------
    public function insereCronogramaFisicoNovo(){
        $dados["id_contrato_obra"] = $this->session->idContrato;  
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["id_eixo"] = $this->input->post_get('id_eixo');

        $DadosCronogramaFisicoVersao = $this->Tb_cronograma_fisico->recuperaVersao($dados);

        if(!empty($DadosCronogramaFisicoVersao)){ 

            foreach ($DadosCronogramaFisicoVersao as $lista) {
                $dados["versao"] = $lista->versao;
                $dados["id_cronograma"] = $lista->id_cronograma;
                $dados["publicar_cronograma"] = $lista->publicar_cronograma;
            }
            if($dados["publicar_cronograma"] == 'S') {       
                $dados["versao"] = $dados["versao"] + 1;
                $dados["id_cronograma"] = $dados["id_cronograma"] + 1;

                $Retorno = $this->Tb_cronograma_fisico->insereVersao($dados); 
            }
            $CronogramaFisico = $this->Tb_cronograma_fisico->recuperaVersao($dados);
            foreach ($CronogramaFisico as $lista) {
               $dados["id_cronograma_fisico_versao"] = $lista->id_cronograma_fisico_versao;
           }
           $dados["ano"] = $this->input->post_get("valanoreferente");
           $dados["id_servico"] = $this->input->post_get("servico");
           $dados["id_obra"] = $this->input->post_get("obra");
           $dados["tipo"] = $this->input->post_get("tipo");
           $dados["medicao"] = $this->input->post_get("medicao");

           for ($j = 1; $j <= 12; $j++) {
            if (!empty($this->input->post("mes")[$j])) {
                $dados["mes"] = $this->input->post("mes")[$j];
                //$dados["valor_inicial"] = str_replace(",", ".", $this->input->post("valor_inicial")[$j]);
                $dados["valor_medido"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor_medido")[$j]));
                if (!empty($this->input->post("valor_medido")[$j])) {
                    $dados["total"]=$dados["valor_medido"];

                    $retorno = $this->Tb_cronograma_fisico->insereCronogramaFisico($dados);
                }
            }
        }
        die(json_encode($retorno));
    } 

    if(empty($DadosCronogramaFisicoVersao)){ 
        $dados["id_cronograma"] = 1;
        $dados["versao"] = 1;
        $dados["publicar_cronograma"] = "N";

        $Retorno = $this->Tb_cronograma_fisico->insereVersao($dados);

        $DadosCronogramaFisicoVersao = $this->Tb_cronograma_fisico->recuperaVersao($dados);
        foreach ($DadosCronogramaFisicoVersao as $lista) {
            $dados["versao"] = $lista->versao;
            $dados["id_cronograma"] = $lista->id_cronograma;
            $dados["publicar_cronograma"] = $lista->publicar_cronograma;
            $dados["id_cronograma_fisico_versao"] = $lista->id_cronograma_fisico_versao;
        }
        $dados["ano"] = $this->input->post_get("valanoreferente");
        $dados["id_servico"] = $this->input->post_get("servico");
        $dados["id_obra"] = $this->input->post_get("obra");
        $dados["tipo"] = $this->input->post_get("tipo");
        $dados["medicao"] = $this->input->post_get("medicao");

        for ($j = 1; $j <= 12; $j++) {
            if (!empty($this->input->post("mes")[$j])) {
                $dados["mes"] = $this->input->post("mes")[$j];
                //$dados["valor_inicial"] = str_replace(",", ".", $this->input->post("valor_inicial")[$j]);
                $dados["valor_medido"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor_medido")[$j]));
                if (!empty($this->input->post("valor_medido")[$j])) {
                    $dados["total"]=$dados["valor_medido"];
                    $retorno = $this->Tb_cronograma_fisico->insereCronogramaFisico($dados);
                }
            }
        }
        die(json_encode($dados));
    }     
}    
//-------------------------------------------------------------------------------------------------------------------------
    public function ServicosInseridosAquaviario(){
        $dados["id_contrato_obra"] = $this->session->idContrato;  
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["id_eixo"] = $this->input->post_get('id_eixo');
        $dados["versao"] = $this->input->post_get('versao');

        $DadosItensInseridos = $this->Tb_cronograma_fisico->ServicosInseridosAquaviario($dados);  
        $retorno["data"] = Array();

        if (!empty($DadosItensInseridos)) {
            $linha = 1;
            foreach ($DadosItensInseridos as $lista) {
               
                $excluir = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirItem(" . $lista->id_cronograma_fisico ."," . $lista->id_cronograma ."," . $lista->versao ."," . $lista->id_eixo .");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
                 if ($lista->tipo_obra == ''){
                    $lista->tipo_obra = "--";
                }

                if($lista->id_obra == 3 && $lista->id_servico == 6){

                    if($lista->valor_medido == 1.00){
                        $executora_sim_nao = "Sim";
                        $medida ="--";
                    }
                    if($lista->valor_medido == 2.00){
                        $executora_sim_nao = "Não";
                        $medida ="--";
                    }

                }else{
                    $executora_sim_nao = "--";
                    $medida = number_format($lista->vm,2,",",".").$lista->un;
                }
                

                $retorno["data"][] = array(
                    'conte'=> $linha++,
                    'medida'=> $medida,
                    'obra'=> $lista->desc_obra,
                    'servico'=> $lista->desc_servico,
                    'tipo'=> $lista->tipo_obra,
                    'executora'=>$executora_sim_nao,
                    'mes_ano' => $lista->mes_ano,
                    'publicar'=> $lista->publicar,
                    'usuario'=> $lista->nome,
                    'ultima_alteracao'=> $lista->ultima_alteracao, 
                    'acao'=> $excluir
                );
            }
        }
        echo (json_encode($retorno));
    }
//-------------------------------------------------------------------------------------------------------------------------
public function TotalServicoAquaviario(){
    $dados["id_contrato_obra"] = $this->session->idContrato;
    $dados["id_eixo"] = $this->input->post_get('id_eixo');

    $DadosCronogramaFisicoVersao = $this->Tb_cronograma_fisico->recuperaVersao($dados);

    if(!empty($DadosCronogramaFisicoVersao)){ 
        foreach ($DadosCronogramaFisicoVersao as $lista) {
            $dados["versao"] = $lista->versao;
            $dados["id_cronograma"] = $lista->id_cronograma;
            $dados["idUsuario"] = $this->session->id_usuario_daq;
            $dados["id_contrato_obra"] = $this->session->idContrato;
            $dados["id_eixo"] = $this->input->post_get('id_eixo');
        }
    } else{
            $dados["versao"] = $this->input->post_get('versao');
            $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
            $dados["idUsuario"] = $this->session->id_usuario_daq;
            $dados["id_contrato_obra"] = $this->session->idContrato;
            $dados["id_eixo"] = $this->input->post_get('id_eixo');
        }

        $DadosServico = $this->Tb_cronograma_fisico->TotalServicoAquaviario($dados);
       
           $dados["total"] = $DadosServico[0]["executado_total"];
           //$dados["inicial"] = $DadosServico[0]["valor_inicial"];
           $dados["final"] = $DadosServico[0]["valor_medido"];

        echo (json_encode($dados));
    }
    
//-------------------------------------------------------------------------------------------------------------------------
    public function excluirItem(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["idContrato"] = $this->session->idContrato;
        $dados["id_cronograma_fisico"] = $this->input->post_get('id_cronograma_fisico');

        $retorno = $this->Tb_cronograma_fisico->excluirItem($dados);
        
        echo (json_encode($retorno));
    }

//-------------------------------------------------------------------------------------------------------------------------
    public function RecuperaGeorreferenciamento(){
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_eixo"] = $this->input->post_get('id_eixo');

        $DadosRecuperaGeo = $this->Tb_cronograma_fisico->RecuperaGeorreferenciamento($dados);
        $retorno["data"] = Array();

        foreach ($DadosRecuperaGeo as $lista){
            $retorno["data"][] = array(
                $dados['id_eixo'] = $lista->id_eixo,

            );
        }
        echo (json_encode($retorno));
    }

//-------------------------------------------------------------------------------------------------------------------------
    public function DetalhadoNaoPublicado(){
        $dados["id_contrato_obra"] = $this->session->idContrato;  
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["id_eixo"] = $this->input->post_get('id_eixo');
        $dados["versao"] = $this->input->post_get('versao');

        $DadosItensInseridos = $this->Tb_cronograma_fisico->DetalhadoNaoPublicado($dados); 
        $retorno["data"] = Array();

        if (!empty($DadosItensInseridos)) {
            $linha = 1;
            foreach ($DadosItensInseridos as $lista) {
                  if ($lista->tipo_obra == ''){
                        $lista->tipo_obra = "--";
                    }

                if($lista->id_obra == 3 && $lista->id_servico == 6){

                    if($lista->valor_medido == 1.00){
                        $executora_sim_nao = "Sim";
                        $medida ="--";
                    }
                    if($lista->valor_medido == 2.00){
                        $executora_sim_nao = "Não";
                        $medida ="--";
                    }

                }else{
                    $executora_sim_nao = "--";
                    $medida = number_format($lista->valor_medido,2,",",".").$lista->un;
                }

                $retorno["data"][] = array(
                    'conte'=> $linha++,
                    'obra'=> $lista->desc_obra,
                    'servico'=> $lista->desc_servico,
                    'tipo'=> $lista->tipo_obra,
                    'mes_ano'=> $lista->mes_ano,
                    'executora'=>$executora_sim_nao,
                    'medida' => $medida,
                    'desc_nome'=> $lista->nome,
                    'ultima_alteracao'=> $lista->ultima_alteracao,
                    'versao'=> $lista->versao, 
                    'publicado'=> $lista->publicar, 
                );
            }
        }
        echo (json_encode($retorno));
    }

//-------------------------------------------------------------------------------------------------------------------------
    public function PublicarCronograma_naopublicado(){
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["versao"] = $this->input->post_get('versao');
        $dados["id_eixo"] = $this->input->post_get('id_eixo');
        
        if(isset($dados)){
         $retorno = $this->Tb_cronograma_fisico->PublicarCronograma_naopublicado($dados);

         echo (json_encode($retorno));
     }
 }

//-------------------------------------------------------------------------------------------------------------------------
     public function DetalhadoPublicado(){
        $dados["id_contrato_obra"] = $this->session->idContrato;  
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_cronograma"] = $this->input->post_get('id_cronograma');
        $dados["id_eixo"] = $this->input->post_get('id_eixo');
        $dados["versao"] = $this->input->post_get('versao');

        $DadosItensInseridos = $this->Tb_cronograma_fisico->DetalhadoPublicado($dados);
        $retorno["data"] = Array();

        if (!empty($DadosItensInseridos)) {
            $linha = 1;
            foreach ($DadosItensInseridos as $lista) {
                if ($lista->tipo_obra == ''){
                        $lista->tipo_obra = "--";
                    }

                if($lista->id_obra == 3 && $lista->id_servico == 6){

                    if($lista->valor_medido == 1.00){
                        $executora_sim_nao = "Sim";
                        $medida ="--";
                    }
                    if($lista->valor_medido == 2.00){
                        $executora_sim_nao = "Não";
                        $medida ="--";
                    }

                }else{
                    $executora_sim_nao = "--";
                    $medida = number_format($lista->valor_medido,2,",",".").$lista->un;
                }

                $retorno["data"][] = array(
                    'conte'=> $linha++,
                    'obra'=> $lista->desc_obra,
                    'servico'=> $lista->desc_servico,
                    'tipo'=> $lista->tipo_obra,
                    'mes_ano'=> $lista->mes_ano,
                    'executora'=>$executora_sim_nao,
                    'medida' => $medida,
                    'desc_nome'=> $lista->nome,
                    'ultima_alteracao'=> $lista->ultima_alteracao,
                    'versao'=> $lista->versao, 
                    'publicado'=> $lista->publicar, 
                );
            }
        }
        echo (json_encode($retorno));
    }

//-------------------------------------------------------------------------------------------------------------------------
    public function ContaNaoPublicado(){
        $dados["id_contrato_obra"] = $this->session->idContrato;

        $dadosContrato = $this->Tb_cronograma_fisico->ContaNaoPublicado($dados);
        foreach ($dadosContrato as $lista) {
            $dados['conte_naopublicado']= $lista->conte_naopublicado;  
        }
        echo (json_encode($dados));
    }












}//Fecha Classe
//######################################################################################################################################################################################################################## 
//# DNIT - FALCONI - AQUAVIARIO
//# Cronogramafisicoctr.php
//# Desenvolvedora:Jordana de Alencar
//# Data: 01/04/2020
//########################################################################################################################################################################################################################
