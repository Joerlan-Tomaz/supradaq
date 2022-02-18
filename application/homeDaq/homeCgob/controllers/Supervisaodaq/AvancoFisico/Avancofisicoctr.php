<?php
/*
 * Classe controller Avancofisicoctr. 
 * @author Jordana de Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, FALCONI | DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Avancofisicoctr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_avanco_fisico');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

//---------------------------------------------------------------------------------------------------------------------- 
//@JordanaAlencar  refiz 500X 
//----------------------------------------------------------------------------------------------------------------------
    
    public function recuperaEixo() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $DadosEixo = $this->Tb_avanco_fisico->recuperaEixo($dados);
        $n = 0;
        if (!empty($DadosEixo)) {
            foreach ($DadosEixo as $lista) {
                $dados['id_eixo'][$n] = $lista->id;
                $dados['eixo'][$n] = str_replace("_", " ", $lista->eixo);
                $n++;
            }
        }else{
            $dados['id_eixo'][$n] = 0;
            $dados['eixo'][$n] = 'Sem Eixo Georreferenciado';
        }
        echo (json_encode($dados));
    }
//------------------------------------------------------------------------------------------------------------------------
    public function recuperaObra() {
        $DadosServico = $this->Tb_avanco_fisico->recuperaObra();
        $n = 0;
        foreach ($DadosServico as $lista) {
            $dados['id_obra'][$n] = $lista->id_tipo_obra;
            $dados['obra'][$n] = str_replace("_", " ", $lista->desc_tipo_obra);
            $n++;
        }
        echo (json_encode($dados));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function recuperaServico() {
        $dados["id_obra"] = $this->input->post_get("id_obra");
        $dados["idContrato"] = $this->session->idContrato;

         $Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
         $dados["versao"] = 0;
         if (!empty($Versao)) {
           foreach ($Versao as $lista) {
                $dados["versao"] = $lista->versao;
            }
        }

        if ($dados["id_obra"] == 1){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraConstrucao($dados); // TROQUEI POR CONSTRUÇÂO PORTUARIA
        }
         if ($dados["id_obra"] == 2){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraDerrocagem($dados); // permanece
        }
         if ($dados["id_obra"] == 3){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraDragagem($dados); // permanece
        }
         if ($dados["id_obra"] == 4){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraDesobstrucao($dados); // permanece
        }
         if ($dados["id_obra"] == 5){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraRecuperacao($dados); // TROQUEI por RECUPERACAO PORTUARIA
        }
         if ($dados["id_obra"] == 6){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraMonitoramento($dados); // TROQUEI por MONITORAMENTO HIDROVIARIO
        }
         if ($dados["id_obra"] == 7){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraNavioHaider($dados); //permanece
        }
         if ($dados["id_obra"] == 8){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraSinalHidro($dados); // OPERACAO
        }
        if ($dados["id_obra"] == 9){
            $dadosServico = $this->Tb_avanco_fisico->recuperaObraEclusas($dados); // OPERACAO
        }
       
        $n = 0;
        if (!empty($dadosServico)) {
        foreach ($dadosServico as $lista) {
            $dados['id_servico'][$n] = $lista->id_obra;
            $dados['servico'][$n] = str_replace("_", " ", $lista->desc_obra);
            $n++;
        }
    }

    else {
            $dados['id_servico'][$n] = 0;
            $dados['servico'][$n] = 'Sem Serviço Publicado Obra';
        }
        echo (json_encode($dados));
    }
//----------------------------------------------------------------------------------
    public function recuperaTipo() {
        $dados["id_servico"] = $this->input->post_get("servico");

        if ($dados["id_servico"] == 16){

                $dadosTipo = $this->Tb_avanco_fisico->recuperaTipoEstruturaNaval($dados);

        } else{
                $dadosTipo = $this->Tb_avanco_fisico->recuperaTipo($dados);
        }

        // $dados = $this->Tb_avanco_fisico->recuperaDesc($dados);
        // $dados["desc_obra"]=$dados[0]["desc_obra"];

        $n = 0;
        foreach ($dadosTipo as $lista) {
            $dados['id_tipo'][$n] = $lista->id_tipo;
            $dados['tipo'][$n] = str_replace("_", " ", $lista->desc_tipo);
            $n++;
        }
        echo (json_encode($dados));
    }
// //---------------------------------------------------------------------------------------------------------------------- 
//     public function recuperaServico() {
//         $dados["id_contrato_obra"] = $this->session->idContrato;
//         $dados["id_eixo"] = $this->input->post_get("id_eixo");
//         $DadosServico = $this->Tb_avanco_fisico->recuperaServico($dados);
//         $n = 0;
//         if (!empty($DadosServico)) {
//             foreach ($DadosServico as $lista) {
//                 $dados['id_servico'][$n] = $lista->id;
//                 $dados['servico'][$n] = str_replace("_", " ", $lista->desc_servico);
//                 $n++;
//             }
//         }else{
//             $dados['id_servico'][$n] = 0;
//             $dados['servico'][$n] = 'Sem Serviço Publicado';
//         }
//         echo (json_encode($dados));
//     }
//----------------------------------------------------------------------------------------------------------------------
     public function avancoaquaviarioatacado () {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["eixo"] = $this->input->post_get("eixo");
        $dados["servico"] = $this->input->post_get("servico");
        $dados["obra"] = $this->input->post_get("obra");
        //$inicial_atacado = min(str_replace(",", ".", $this->input->post("valor_inicial")));
        $final_atacado = max(str_replace(",", ".", $this->input->post("valor_final")));
        //$dados["val_inicial"] =  $inicial_atacado;
        $dados["val_final"] =  $final_atacado;
        $dados["status"] = $this->input->post_get("status");

        $DadosAtacado = $this->Tb_avanco_fisico->avancoaquaviarioatacado($dados);

        if (!empty($DadosAtacado)) {
            foreach ($DadosAtacado as $lista) {
                $conte=$lista->conte_id;
            }
        }
        if($conte > 0){
            $dados["conte_atacado"] = 1;
        
        }
        echo (json_encode($dados));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function AvancoAquaviario_Trecho_Atacado() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");

        $Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
         $dados["versao"] = 0;
         if (!empty($Versao)) {
           foreach ($Versao as $lista) {
                $dados["versao"] = $lista->versao;
            }
        }

        $DadosTrecho = $this->Tb_avanco_fisico->AvancoAquaviario_Trecho_Atacado($dados);   
        $retorno["data"] = Array();

        if (!empty($DadosTrecho)) {
           $linha = 1;
           foreach ($DadosTrecho as $lista) {
            $modal = number_format($lista->val_final,2,",",".").$lista->unidade;
            $acoes_atacado = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'atacadodaqtrash(". $lista->id.")' style='font-size: 13px'><i class = 'fa fa-trash' ></i></button >";
            $acoes_executado = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick=\"modalVisualizarExecutado({$lista->id}, '{$lista->valInicial}' , '{$modal}')\" style='font-size: 13px'><i class = 'fa fa-eye' ></i></button >";
            $acoes_executar = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick=\"modalExecutado({$lista->id},'{$lista->valInicial}','{$modal}','{$lista->unidade}')\" style='font-size: 13px'><i class = 'fa fa-pencil' ></i></button >";
             if ($lista->tipo_obra == ''){
                    $lista->tipo_obra = "--";
                }

            $retorno["data"][] = array(
                'eixo'=>$lista->eixo,
                'obra'=>$lista->desc_obra,
                'servico'=>$lista->servico,
                'tipo'=>$lista->tipo_obra,
                'versao'=>$lista->versao,
                //'val_inicial_atacado'=>$lista->valInicial,
                //'val_final_atacado'=>$lista->valFinal,
                'val_final_atacado'=>number_format($lista->val_final,2,",",".").$lista->unidade,
                'atacado_em'=>$lista->atacado,
                'executado_em'=>$lista->executado,
                'usuario'=>$lista->nome,
                'data'=>$lista->ultima_alteracao,
                'acoes_executar'=>$acoes_executar,
                'acoes_atacado'=>$acoes_atacado,
                'acoes_executado'=>$acoes_executado,
                'status_atacado'=>$lista->status,
                'extensao_atacado'=>$lista->extensao_atacado,
                'id'=> $linha++
            );
        }
    }
    echo (json_encode($retorno));
}
//----------------------------------------------------------------------------------------------------------------------
    public function Cronograma_fisico() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_servico"] = $this->input->post_get("id_servico");
        $dados["id_obra"] = $this->input->post_get("id_obra");
        $dados["final_incluir"] = str_replace(",", ".", str_replace(".", "",$this->input->post("final")));
        $dados["mes"] = date('m',strtotime($this->input->post_get('periodo')));
        $dados["periodo"] = date("Y", strtotime($this->input->post_get("periodo")));
        $dados["periodo_referencia"] = $this->input->post_get("periodo");
       
        $Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
         $dados["versao"] = 0;
         if (!empty($Versao)) {
           foreach ($Versao as $lista) {
                $dados["versao"] = $lista->versao;
            }
        }
         //$dados["conte_executado"] = 'false';
        $Dadosid = $this->Tb_avanco_fisico->Cronograma_fisico($dados);
        $Dadosidav = $this->Tb_avanco_fisico->avancoaquaatacado($dados);

        if(!empty($Dadosid)){
          
            // $valor_inserir = number_format($dados["final_incluir"],2,",",".");
            // $valor_insere = str_replace(",", ".", $valor_inserir) + $Dadosidav[0]["val_atacado"];
            $valor_insere = $dados["final_incluir"] + $Dadosidav[0]["val_atacado"];
            if($valor_insere > $Dadosid[0]["valor"]){
                $retorno["mensagem"] = "A soma dos valores informados deve ser igual a soma dos valores inseridos na ultima versão do [Cronograma Fisico!!]";
                //$retorno["notify"] = "warning";
                die (json_encode($retorno));
            }
             $retorno= true; 
        }
        $retorno= true;
        echo (json_encode($retorno));
    }
//---------------------------------------------------------------------------------------------------
    public function insere_avanco_aquaviario () {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["id_eixo"] = $this->input->post_get("eixo");
        $dados["id_servico"] = $this->input->post_get("servico");
        $dados["id_obra"] = $this->input->post_get("obra");
        $dados["tipo"] = $this->input->post_get("tipo");
        $dados["status"] = $this->input->post_get("status");
        $dados["medicao"] = $this->input->post_get("medicao");
        $dados["mes"] = date('m',strtotime($this->input->post_get('periodo')));
        $campos = $this->input->post_get("qtdeCampos");

        $Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
        $dados["versao"] = 0;
        if (!empty($Versao)) {
           foreach ($Versao as $lista) {
                $dados["versao"] = $lista->versao;
            }
        }

        for ($j = 0; $j < $campos; $j++) {
            //if (!empty($this->input->post("valor_inicial")[$j])) {
               // $dados["atacado_inicial"] = str_replace(",", ".", $this->input->post("valor_inicial")[$j]);
               // $dados["atacado_final"] = str_replace(",", ".", $this->input->post("valor_final")[$j]);
               // $dados["extensao"]= ($dados["atacado_final"]-$dados["atacado_inicial"]);
                if (!empty($this->input->post("valor_final")[$j])) {
                    $dados["atacado_final"] =  str_replace(",", ".", str_replace(".", "", $this->input->post("valor_final")[$j]));
                    $dados["extensao"]= $dados["atacado_final"];//($dados["atacado_final"]-$dados["atacado_inicial"]);
                    $retorno = $this->Tb_avanco_fisico->insere_avanco_aquaviario($dados);
                }
            //}
        }
        die(json_encode($retorno));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function AvancoAquaviario_Trecho_Concluido() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");

        $Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
         $dados["versao"] = 0;
         if (!empty($Versao)) {
           foreach ($Versao as $lista) {
                $dados["versao"] = $lista->versao;
            }
        }

        $DadosConcluido = $this->Tb_avanco_fisico->AvancoAquaviario_Trecho_Concluido($dados);   
        $retorno["data"] = Array();

        if (!empty($DadosConcluido)) {
           $linha = 1;
           foreach ($DadosConcluido as $lista) {
            $vamed = number_format($lista->val_final,2,",",".").$lista->unidade_medida;
            $acoes_executado = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick=\"modalVisualizarExecutadoConcluido({$lista->id}, '{$lista->valInicial}','{$vamed}')\" style='font-size: 13px'><i class = 'fa fa-eye' ></i></button >";
             if ($lista->tipo_obra == ''){
                    $lista->tipo_obra = "--";
                }

            $retorno["data"][] = array(
                'eixo'=>$lista->eixo,
                'obra'=>$lista->desc_obra,
                'servico'=>$lista->servico,
                'tipo'=>$lista->tipo_obra,
                'versao'=>$lista->versao,
                //'val_inicial_atacado'=>$lista->valInicial,
                'val_final_atacado'=>number_format($lista->val_final,2,",",".").$lista->unidade_medida,
                'atacado_em'=>$lista->atacado,
                'executado_em'=>$lista->executado,
                'usuario'=>$lista->nome,
                'data'=>$lista->ultima_alteracao,
                'acoes_executado'=>$acoes_executado
            );
        }
    }
    echo (json_encode($retorno));
}
//----------------------------------------------------------------------------------------------------------------------
    public function conferePeriododaq() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["referencia"] = $this->input->post_get('periodo');
        $dados["id"] = $this->input->post_get('id');
        $dados["data"] = array();
        $DadosPeriodo = $this->Tb_avanco_fisico->conferePeriodo($dados);

        if (!empty($DadosPeriodo)) {
            foreach ($DadosPeriodo as $lista) {
                $referencia = $lista->periodo_referencia;
                $unidade = $lista->unidade_medida;
            }
        }
        if($dados["referencia"] >= $referencia){
            $dados["periodo"] = 'IGUAL';
            $dados["unidade"] = $unidade;
        }else{
            $dados["periodo"] = 'MAIOR';
            $dados["unidade"] = $unidade;
        }
        echo (json_encode($dados));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function recupera_medicao_aquaviario_executado() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["id"] = $this->input->post_get("id_tabular");

        $DadosValorExecutado = $this->Tb_avanco_fisico->recupera_medicao_aquaviario_executado($dados);   
        $retorno["data"] = Array();

        if (!empty($DadosValorExecutado)) {
           foreach ($DadosValorExecutado as $lista) {

            $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'trashmedicaoExecutado(". $lista->id.")' style='font-size: 13px'><i class = 'fa fa-trash' ></i></button >";

            $retorno["data"][] = array(

                
                //'valInicial'=>$lista->valInicial,
                'periodo_referencia'=>$lista->periodo,
                'status'=>$lista->status,
                'valFinal'=>number_format($lista->vf,2,",",".").$lista->med,
                'acoes'=>$acao
            );
        }
    }
    echo (json_encode($retorno));
}
//----------------------------------------------------------------------------------------------------------------------
    public function medicaoexecutadas() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id_avanco"] = $this->input->post_get("id");
        $dados["inicial_executado"] = str_replace(",", ".", $this->input->post("inicial"));
        $dados["final_executado"]= str_replace(",", ".", $this->input->post("final"));
        $dados["periodo"] = $this->input->post_get("periodo");

        $Dadosavanco = $this->Tb_avanco_fisico->MedidaAtacado($dados);
        if (!empty($Dadosavanco)){
            foreach ($Dadosavanco as $lista){
                if ($lista->Inicial_av > $dados["inicial_executado"]){
                    $retorno["mensagem"] = "Ocorreu um erro [A MEDIDA INICIAL INFORMADA NÃO CORRESPONDE AO ATACADO]";
                    $retorno["notify"] = "warning";
                     die (json_encode($retorno));
                }  
                  elseif ($lista->Final_av < $dados["final_executado"]){
                    $retorno["mensagem"] = "Ocorreu um erro [A MEDIDA FINAL INFORMADA NÃO CORRESPONDE AO ATACADO]";
                    $retorno["notify"] = "warning";
                     die (json_encode($retorno));
                }   
            }
        }
        $Dadosexecutado = $this->Tb_avanco_fisico->MedidaExecutado($dados);
        if (!empty($Dadosexecutado)){
            foreach ($Dadosexecutado as $lista){
                if (($lista->Inicial_ex <= $dados["inicial_executado"])&&($dados["inicial_executado"]<$lista->Final_ex)){
                    $retorno["mensagem"] = "Ocorreu um erro [A MEDIDA INICIAL INFORMADA JÁ FOI EXECUTADA]";
                    $retorno["notify"] = "warning"; 
                     die (json_encode($retorno));
                }
                  elseif (($lista->Inicial_ex <= $dados["final_executado"])&&($dados["final_executado"]<=$lista->Final_ex)){
                    $retorno["mensagem"] = "Ocorreu um erro [A MEDIDA FINAL INFORMADA JÁ FOI EXECUTADA]";
                    $retorno["notify"] = "warning";
                     die (json_encode($retorno));
                }
                 else{
                    $retorno= true;
                    die (json_encode($retorno));
                 }   
            } 
        }
                $retorno= true;
            echo (json_encode($retorno));
    }
//----------------------------------------------------------------------------------------------------------------------
        public function medicaoexecutada() {
        $dados["final_executado"]= str_replace(",", ".", str_replace(".", "", $this->input->post("final")));//261758
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id"] = $this->input->post_get("id");

        $Dadostotal = $this->Tb_avanco_fisico->medicaoexecutadatotal($dados);
        //$Dadosavanco = $this->Tb_avanco_fisico->MedidaAtacado($dados);

        if (!empty($Dadostotal)){
        $executado = $dados["final_executado"] + $Dadostotal[0]["extensao_executada"];
                        
                  if ($executado > $Dadostotal[0]["extensao_atacado"]){
                    $retorno["mensagem"] = "Ocorreu um erro [A SOMA NÃO CORRESPONDE AO ATACADO]";
                    $retorno["notify"] = "warning";
                     die (json_encode($retorno));
                  
            }
            $retorno= true;
        }
                $retorno= true;
            echo (json_encode($retorno));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function insere_avanco_aquaviario_executado () {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["medicaoexecutado"] = $this->input->post_get("medicaoexecutado");
        $dados["mes"] = date('m',strtotime($this->input->post_get('periodo')));
        $dados["id_executado"] = $this->input->post_get("id");
        $campos = $this->input->post_get("campos");

        $DadosId = $this->Tb_avanco_fisico->recupera_insere($dados);
        $dados["id"]=$DadosId[0]["id"];
        $dados["id_obra"]=$DadosId[0]["obra"];
       
        for ($j = 0; $j <= $campos; $j++) {
            // if (!empty($this->input->post("executado_inicial")[$j])) {
            //     $dados["inicial"] = str_replace(",", ".", $this->input->post("executado_inicial")[$j]);
            //     $dados["final"] = str_replace(",", ".", $this->input->post("executado_final")[$j]);
            //     $dados["extensao_executado"]= ($dados["final"]-$dados["inicial"]);
             if (!empty($this->input->post("executado_final")[$j])) {
                    $dados["final"] = str_replace(",", ".", str_replace(".", "", $this->input->post("executado_final")[$j]));
                    $dados["extensao_executado"]= $dados["final"];
                    $retorno = $this->Tb_avanco_fisico->insere_avanco_aquaviario_executado($dados);
            }
        }
        echo (json_encode($retorno));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function returnExecutadoaquaviario() {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id"] = $this->input->post_get("id");
        $conte=0;
        $Dadostotal = $this->Tb_avanco_fisico->returnExecutado($dados);
        foreach ($Dadostotal as $lista) {

            if ($lista->extensao_atacado == $lista->extensao_executada){
                $dados["extensao_executada"] = $lista->extensao_executada;
                $this->Tb_avanco_fisico->AtualizaAvanco($dados);
                $conte = 1;
            } 
        }
        if($conte === 1){
            $retorno["concluido"] = 1;
        }else{
            $retorno["concluido"] = 0;
        }  
        echo (json_encode($retorno));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function insere_avanco_aquaviario_executado_anterior () {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["id_eixo"] = $this->input->post_get("eixo");
        $dados["id_servico"] = $this->input->post_get("servico");
        $dados["id_obra"] = $this->input->post_get("obra");
        $dados["tipo"] = $this->input->post_get("tipo");
        $dados["status"] = $this->input->post_get("status");
        $dados["medicao"] = $this->input->post_get("medicao");
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["mes"]= date('m',strtotime($this->input->post_get('periodo')));
        $campos = $this->input->post_get("qtdeCampos");

        $Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
        $dados["versao"] = 0;
        if (!empty($Versao)) {
           foreach ($Versao as $lista) {
                $dados["versao"] = $lista->versao;
            }
        }

        for ($j = 0; $j <= $campos; $j++) {
            //if (!empty($this->input->post("valor_inicial")[$j])) {
                //$dados["inicial_ca"] = $this->input->post("valor_inicial")[$j];
                //$dados["final_ca"] = $this->input->post("valor_final")[$j];
                //$dados["extensao"]= ($dados["final_ca"]-$dados["inicial_ca"]);
                if (!empty($this->input->post("valor_final")[$j])) {
                    $dados["final_ca"] = str_replace(",", ".", str_replace(".", "", $this->input->post("valor_final")[$j]));
                    $dados["extensao"]= $dados["final_ca"];
                    $retorno = $this->Tb_avanco_fisico->insere_avanco_aquaviario_executado_anterior($dados);
                //}
            }
        }
        echo (json_encode($retorno));
    }
//----------------------------------------------------------------------------------------------------------------------
    public function AvancoAquaviario_Trecho_Concluido_Contrato_Anterior() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");

        $Versao = $this->Tb_avanco_fisico->recuperaVersao($dados);
         $dados["versao"] = 0;
         if (!empty($Versao)) {
           foreach ($Versao as $lista) {
                $dados["versao"] = $lista->versao;
            }
        }

        $DadosAnterior = $this->Tb_avanco_fisico->AvancoAquaviario_Trecho_Concluido_Contrato_Anterior($dados);   
        $conte = (count($DadosAnterior));
        $retorno["conte"] =$conte;

        $retorno["data"] = Array();

        if (!empty($DadosAnterior)) {
           $linha = 1;
           foreach ($DadosAnterior as $lista) {

            $acoes= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'trashContratoAnterior(". $lista->id.")' style='font-size: 13px'><i class = 'fa fa-trash' ></i></button >";
            if ($lista->tipo_obra == ''){
                    $lista->tipo_obra = "--";
                }

            $retorno["data"][] = array(
                'eixo'=>$lista->eixo,
                'obra'=>$lista->desc_obra,
                'servico'=>$lista->servico,
                'tipo'=>$lista->tipo_obra,
                'versao'=>$lista->versao,
                //'val_inicial_atacado'=>$lista->valInicial,
                'val_final_atacado'=>number_format($lista->val_final,2,",",".").$lista->unidade_medida,
                'atacado_em'=>$lista->atacado_executado,
                'executado_em'=>$lista->atacado_executado,
                'usuario'=>$lista->nome,
                'data'=>$lista->ultima_alteracao,
                'acoes'=>$acoes,
                'status_atacado'=>$lista->status,
                'extensao_atacado'=>$lista->extensao_atacado_ca,
                'extensao_executado'=>$lista->extensao_executado_ca,
                'id'=> $linha++
            );
        }
    }
    echo (json_encode($retorno));
}

//------------------------------------------------------------------------------------------------------------------------------
    public function trashContratoAnterior(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id"] = $this->input->post_get('id');

        $retorno = $this->Tb_avanco_fisico->trashContratoAnterior($dados);
        echo (json_encode($retorno));
    }

//----------------------------------------------------------------------------------------------------------------------
    public function aquaviario_medicao_executado_concluido() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["id_tabular"] = $this->input->post_get("id_tabular");

        $DadosRecupera = $this->Tb_avanco_fisico->aquaviario_medicao_executado_concluido($dados);   
        $retorno["data"] = Array();

        if (!empty($DadosRecupera)) {
           foreach ($DadosRecupera as $lista) {

            $acoes = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'trashExecutadoConcluido(". $lista->id.", ".$lista->id_tabular.")' style='font-size: 13px'><i class = 'fa fa-trash' ></i></button >";

            $retorno["data"][] = array(
                'valFinal'=>number_format($lista->vf,2,",",".").$lista->med,
                // 'valInicial'=> $lista->valInicial,
                'periodo_referencia'=>$lista->periodo,
                'status'=>$lista->status,
                'acoes'=>$acoes
            );
        }
    }
    echo (json_encode($retorno));
}
//------------------------------------------------------------------------------------------------------------------------------
    public function trashmedicaoExecutado(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id"] = $this->input->post_get('id');
        $retorno = $this->Tb_avanco_fisico->trashmedicaoExecutado($dados);
        echo (json_encode($retorno));

    }
//------------------------------------------------------------------------------------------------------------------------------
    public function trashExecutadoConcluido(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["id"] = $this->input->post_get('id');
        $dados["id_tabular"] = $this->input->post_get('id_tabular');
        $retorno = $this->Tb_avanco_fisico->trashExecutadoConcluido($dados);
        echo (json_encode($retorno));

    }
//------------------------------------------------------------------------------------------------------------------------------   
    // public function medicaoatacada() {
    //     $dados["id_contrato_obra"] = $this->session->idContrato;
    //     $dados["idUsuario"] = $this->session->id_usuario;
    //     $dados["Inicial"] = str_replace(",", ".", $this->input->post("Inicial"));
    //     $dados["Final"]= str_replace(",", ".", $this->input->post("Final"));

    //     $DadosM = $this->Tb_avanco_fisico->recuperametrica($dados);
    //         if (($dados["Inicial"] >= $DadosM[0]["menor"]) && ( $dados["Inicial"] < $DadosM[0]["maior"] )) {
    //                 $retorno["i"] = 0;
    //                 $retorno["retornoInicial"] = true;
    //         } else{
    //                 $retorno["retornoInicial"] = false;
    //                 $retorno["i"] = 0;
    //             }
    //         if (($dados["Final"] > $DadosM[0]["menor"] ) && ($dados["Final"] <= $DadosM[0]["maior"])){
    //                 $retorno["retornoFinal"] = true;
    //                 $retorno["i"] = 0;
    //         } else{
    //                 $retorno["retornoFinal"] = false;
    //                 $retorno["i"] = 0;
    //             }
    //     echo (json_encode($retorno));
    // }

//------------------------------------------------------------------------------------------------------------------------------
    public function RecuperaExecutado() {
        $dados["id_contrato"] = $this->session->idContrato;
        $dados["id"] = $this->input->post_get("id");
        $dados["data"] = array();
        $RecuperaDados = $this->Tb_avanco_fisico->RecuperaExecutado($dados);

        if (!empty($RecuperaDados)) {
            $conte = $RecuperaDados[0]["conte"];
        }
        if($conte == 0){
            $return["conte_executado"] = 'false';
        }else{
            $return["conte_executado"] = 'true';
        }
        echo (json_encode($return));
    }

//---------------------------------------------------------------------------------------------------------------------------
    public function atacadodaqtrash(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_contrato"] = $this->session->idContrato;
        $dados["id"] = $this->input->post_get('id');
        $retorno = $this->Tb_avanco_fisico->atacadodaqtrash($dados);
        echo (json_encode($retorno));
    }
//------------------------------------------------------------------------------------------------------
    public function insere_naohouveatividademes(){
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
        $dados["periodo"] = $this->input->post_get('periodo');
        $retorno = $this->Tb_avanco_fisico->insere_naohouveatividademes($dados);
        echo (json_encode($retorno));
    }
//------------------------------------------------------------------------------------------------------
    public function AvancoAquaviario_naohouveatividademes(){
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["AVANCO"] = false;
        $NaoAtividade = $this->Tb_avanco_fisico->AvancoAquaviario_naohouveatividademes($dados);
        $dados["data"] = array();

        if(!empty($NaoAtividade)){
            $dados["AVANCO"] = true;
            foreach($NaoAtividade as $lista){

                $dados["data"][] = array(
                    'atividademes' => $lista->atividademes,
                    'ultima_alteracao' => $lista->ultima_alteracao,
                    'usuario' => $lista->nome,
                    'acoes' => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"NaoHouveAtividadedaq({$lista->id})\">
                    <i class='fa fa-trash'></i></a>"
                );
            }  
        }
        echo (json_encode($dados));
    }
//-------------------------------------------------------------------------------------------------------------
    public function NaoHouveAtividadedaq(){
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $dados["id_contrato"] = $this->session->idContrato;
        $dados["id"] = $this->input->post_get('id');
        $retorno = $this->Tb_avanco_fisico->NaoHouveAtividadedaq($dados);
        echo (json_encode($retorno));

    }





}//Fecha Classe
//######################################################################################################################################################################################################################## 
//# DNIT - FALCONI - AQUAVIARIO
//# Avancofisicoctr.php
//# Desenvolvedora:Jordana de Alencar
//# Data: 06/06/2020 
//# Data: 03/08/2020 
//########################################################################################################################################################################################################################
