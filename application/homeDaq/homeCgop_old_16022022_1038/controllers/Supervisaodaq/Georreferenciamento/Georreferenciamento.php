<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Georreferenciamento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->library('ftp');
        $this->load->model("/Supervisaodaq/Tb_configuracao_georreferenciamento");
        $this->load->model("/Supervisaodaq/Tb_configuracao_obra");
        $this->load->model("/Supervisaodaq/Tb_arquivo");
		$this->load->model('/Supervisaodaq/Tb_telas_validacao');
        $this->load->database('DAQ', TRUE);
        $this->load->helper("url");
        $this->load->library("ImportExcelPhpSpout");
        $this->load->library("Excel");
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }


//--------------------------------------------------------------------------------------------
    public function populaHidrovia() {
        $DadosServico = $this->Tb_configuracao_georreferenciamento->populaTipoeixo();
        $n = 0;
        foreach ($DadosServico as $lista) {
            $dados['id_eixo'][$n] = $lista->id_eixo;
            $dados['eixo'][$n] = str_replace("_", " ", $lista->eixo);
            $n++;
        }
        echo (json_encode($dados));
    }


    public function insereArquivoGeorreferenciamento() {
        if (isset($_FILES["arquivo"])) {
            $arquivo = $_FILES["arquivo"];
            $maxsize = 1024 * 1024 * 10;
            if ($maxsize > $arquivo["size"]) {
                $extensao = @end(explode(".", $arquivo["name"]));
                if (($extensao === "xlsx")||($extensao === "XLSX")) {
                    $dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

                    $nameArray = explode(".", $arquivo["name"]);

                    $nName = count($nameArray) - 1;
                    $name = "";
                    for ($i = 0; $i < $nName; $i++) {
                        $name .= $nameArray[$i] . ".";
                    }

                    $name = substr_replace($name, "", -1);
                    $nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";
                    
                    $dados["periodo"] = $this->input->post_get('periodo');//nao tinha
                    $dados["id_contrato_obra"] = $this->session->idContrato;
                    $dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
                    $dados["nome_arquivo"] = $nomeArquivo;
                    $dados["desc_arquivo"] = "Eixo_georreferenciado";
                    $dados["nomeOriginalArquivo"] = $name;
                    $dados["tipo_arquivo"] = "Excel";
                    $dados["pasta_origem"] = "arquivo";
                    $dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq_cgop . "_1";
                    $dados["roteiro"] = "17";
                    $dados["extencao"] = $extensao;
                    $insert = $this->Tb_configuracao_obra->insereConfiguracao_Arquivo($dados);
                    if ($insert !== false) {
                        move_uploaded_file($arquivo["tmp_name"], $dir . $nomeArquivo);
                    }
                    $dadosArquivo = $this->Tb_configuracao_obra->maxID_Arquivo($dados);
                    foreach ($dadosArquivo as $a) {
                        $dados["id_arquivo"] = $a->id_arquivo;
                    }

					$dados["id_tela_formulario"] = 3;
					$this->Tb_telas_validacao->inserir_validacao($dados);
                    $dados["mensagem"] = "Cadastrado com sucesso!";
                    $dados["notify"] = "success";
                    $dados["nomeArquivo"] = $nomeArquivo;
                   
                    } else{
                        $dados["mensagem"] = "Não foi possível enviar o arquivo.";
                        $dados["notify"] = "warning";
                    }
                } else {
                    $dados["mensagem"] = "Extenção não corresponde";
                    $dados["notify"] = "warning";
                }
            } else {
                $dados["mensagem"] = "Arquivo supera o limite de tamanho(5mb)";
                $dados["notify"] = "warning";
            }
        

        echo (json_encode(utf8_converter($dados)));
    }

    public function insereGeorreferenciamento() {
        $dados = $this->input->post("valortbl", TRUE);    //        echo $dados; 
        $dadosComplemento["id_arquivo"] = $this->input->post("id_arquivo");
        $dadosComplemento["id_georreferenciamento_tipo"] = $this->input->post("id_georreferenciamento_tipo");
        $dadosComplemento["id_contrato_obra"] = $this->session->idContrato;
        $dadosComplemento["id_usuario"] = $this->session->id_usuario_daq_cgop;
        $result = $this->Tb_configuracao_georreferenciamento->gravarDadosGeorreferenciamento($dados, $dadosComplemento);
        die(json_encode($result));
    }

    public function recuperaGeorreferenciamento() {
        $dados["id_contrato"] = $this->session->idContrato;
        //$dados["periodo"] = $this->input->post_get("periodo");
        $dados["data"] = array();
        $dadosGeo = $this->Tb_configuracao_georreferenciamento->recuperaGeorreferencimento($dados);

        if (!empty($dadosGeo)) {
            foreach ($dadosGeo as $i => $lista) {
                if (!empty($lista->nomeOriginalArquivo)) {
                    $nomeArquivo = $lista->nomeOriginalArquivo . "." . @end(explode(".", $lista->nome_arquivo));
                } else {
                    $nomeArquivo = $lista->nome_arquivo;
                }
                $detalhes = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick=\"detalhesGeorreferenciamento({$lista->id_arquivo})\"><i class = 'fa fa-eye'></i></button>";
                //$arquivo = "<a href='javascript:void(0);' onclick=\"anexoGeo('{$lista->nome_arquivo}')\">" . $nomeArquivo . "</a>";
                //$arquivo = "<a download href='index_cgob.php/Supervisaodaq/Arquivo/DownloadArquivo?arq=" . $lista->nome_arquivo . "' target='_blank'>" . $nomeArquivo . "<a>";
                $path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
                $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nomeArquivo . "<a>";
                $dados["data"][] = array(
                    "INFRAESTRUTURA" => $lista->nome,
                    "ARQUIVO" => $arquivo,
                    "TOTAL" => $lista->total,
                    "DETALHES" => $detalhes,
                    "NOME" => $lista->desc_nome,
                    "ULTIMA_ALTERACAO" => $lista->ultima_alteracao,
                    "ACAO" => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"excluirGeorreferenciamento({$lista->id_arquivo},'{$nomeArquivo}')\">
                                 <i class='fa fa-trash'></i></a>"
                );

				if($i == count($dadosGeo) - 1){
					$dados["id_tela_formulario"] = '3';
					$dados["periodo"] = $this->input->post_get("periodo");
					$dados["nome_usuario"] = $lista->desc_nome;
					$dados["data_ultima_alteracao"] = $lista->ultima_alteracao;
					$this->Tb_telas_validacao->inserir_validacao($dados);
				}
            }
		} else {
			$dados["id_tela_formulario"] = '3';
			$dados["periodo"] = $this->input->post_get("periodo");
			$this->Tb_telas_validacao->limparValidacao($dados);
		}

        echo (json_encode($dados));
    }

    public function modelogeo() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $path_arq = base_url("index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQMODELO?arq='Modelo_Geo_Eixo_Daq.xlsx'");
        $arquivo = "<a href=".$path_arq." target='_blank'>Modelo_Geo_Eixo_Daq.xlsx<a>";
             
        echo (json_encode($arquivo));
    }

    public function recuperaDetalhesGeorreferenciamento() {
        $dados["id_arquivo"] = $this->input->post_get("id_arquivo");
        $dados["data"] = array();
        $dadosGeo = $this->Tb_configuracao_georreferenciamento->recuperaDetalhesGeorreferenciamento($dados);

        if (!empty($dadosGeo)) {
            foreach ($dadosGeo as $lista) {
                $dados["data"][] = array(
                    "KM" => round($lista->km,2),
                    "LADO" => $lista->fuso,
                    "COORDENADAS" => $lista->coordenadas,
                    "USUARIO" => $lista->desc_nome,
                    "ULTIMA_ALTERACAO" => $lista->ultima_alteracao
                );
            }
        }

        echo (json_encode($dados));
    }

    public function excluirGeorreferenciamento() {
        $dados["id_arquivo"] = $this->input->post_get("id_arquivo");
        $dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
        $retorno = $this->Tb_arquivo->excluirArquivo($dados);
        if ($retorno == true) {
            $retorno = $this->Tb_configuracao_georreferenciamento->excluirGeorreferencimento($dados);
        }

        echo (json_encode($retorno));
    }

    //------------------------------------------------------------------------------------------------------------------------
    public function excluirGeo() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        
        echo (json_encode($retorno));
    }


    public function contagemLinhas() {
        if (!empty($_FILES["arquivo"]["name"])) {
            $arquivo = $_FILES["arquivo"];
            $dadosDaPlanilha = $this->importexcelphpspout->lerArquivo($arquivo);
            $i = 0;
            foreach ($dadosDaPlanilha as $d) {
               // $dados[$i]["eixo"] = $dadosDaPlanilha[$i]["Eixo"];
             //   $dados[$i]["lado"] = $dadosDaPlanilha[$i]["Lado"];
                $dados[$i]["estaca"] = $dadosDaPlanilha[$i]["Estaca"];
                $dados[$i]["fracao_estaca"] = $dadosDaPlanilha[$i]["Fraçãoestaca"];
                $dados[$i]["km"] = $dadosDaPlanilha[$i]["km"];
                $dados[$i]["coordenada_norte"] = $dadosDaPlanilha[$i]["Latitude"];
                $dados[$i]["coordenada_leste"] = $dadosDaPlanilha[$i]["Longitude"];
                $i++;
            }
        } else {
            $dados["mensagem"] = "Arquivo fora do modelo!";
            $dados["notify"] = "warning";
        }
        die(json_encode($dados));
    }

   public function inserirdados(){
    $dadosS["id_arquivo"] = $this->input->post_get("idArquivo");
          date_default_timezone_set('America/Sao_Paulo');
          $ultima_alteracao = date("Y-m-d H:i:s");
        //-------------------------------------------------------------------------------------
           $id_arquivo  = $this->input->post_get("idArquivo");
           $nomeArquivo = $this->input->post_get("nomeArquivo");  
           $eixo      = $this->input->post_get("eixo");
           $nome_eixo = $this->input->post_get("nome_apelido");
           $nome_eixo = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$nome_eixo);
           $nome_eixo = strtoupper($nome_eixo);
        //-------------------------------------------------------------------------------------
            $dir = FCPATH . "application/homeDaq/arquivoDaq/arq/". $nomeArquivo;
            $objPHPExcel = PHPExcel_IOFactory::load ( $dir );
            $objWorksheet = $objPHPExcel->getSheet ( 0 ); 
            $dataArr = array ();
        //-------------------------------------------------------------------------------------
            foreach ( $objWorksheet->getRowIterator () as $row ) {
        $rowIndex = $row->getRowIndex ();
        $cellIterator = $row->getCellIterator ();
        $cellIterator->setIterateOnlyExistingCells ( True ); 
        foreach ( $cellIterator as $cell ) {
            $colIndex = PHPExcel_Cell::columnIndexFromString ( $cell->getColumn () );
            $val = $cell->getValue ();
            $dataArr [$rowIndex] [$colIndex] = $val;
        }
        }//-------------------------------------------------------------------------------------
        $h = $dataArr [1] ;
        if ( count( $h) > 5 ){
            $result["mensagem"] = "Arquivo fora do modelo!";
            $result["notify"] = "warning";
            die(json_encode($result)); 
        }
        //-------------------------------------------------------------------------------------
        if(array_key_exists(5,$h)===false){
            $result["mensagem"] = "Arquivo fora do Modelo!";
            $result["notify"] = "warning";
            die(json_encode($result)); 
        }
        //-------------------------------------------------------------------------------------
        $a = 'KM '; $b = 'X'; $c = 'Y'; $d = 'FUSO UTM'; $e = 'HEMISFÉRIO (N/S)';
        //-------------------------------------------------------------------------------------
        if(array_search($a, $h) != 1 ){
            $result["mensagem"] = "Arquivo fora do Modelo!";
            $result["notify"] = "warning";
            die(json_encode($result));
        }
        if(array_search($b, $h) != 2 ){
            $result["mensagem"] = "Arquivo fora do Modelo!";
            $result["notify"] = "warning";
            die(json_encode($result)); 
        } 
        if(array_search($c, $h) != 3 ){
            $result["mensagem"] = "Arquivo fora do Modelo!";
            $result["notify"] = "warning";
            die(json_encode($result)); 
        } 
        if(array_search($d, $h) != 4 ){
            $result["mensagem"] = "Arquivo fora do Modelo!";
            $result["notify"] = "warning";
            die(json_encode($result)); 
        } 
        if(array_search($e, $h) != 5 ){
            $result["mensagem"] = "Arquivo fora do Modelo!";
            $result["notify"] = "warning";
            die(json_encode($result)); 
        } 
        //--------------------------------------------------------------------------------------
            unset ( $dataArr [1] );
        //--------------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------------
		$inseridos = 0;
		foreach ( $dataArr as $val ) {
        $verificaArray = 0;
			for($i = 1; $i < 6; $i ++)
				if (empty ( $val [$i] ))
					$verificaArray ++;

        if ($verificaArray == 5)
            continue;
               $dados[]=array(
//                        'eixo' => $eixo,
                        'nome_eixo' => $nome_eixo,
                        'id_arquivo' => $id_arquivo,
                        'id_contrato_obra' => $this->session->idContrato,
                        'id_usuario' => $this->session->id_usuario_daq_cgop,
                        'km'=>(!is_null($val ['1'])) ? str_replace(',','.',$val ['1']) : 0,
                        'coordenada_norte'=> str_replace (',','.',$val ['2']),
                        'coordenada_leste'=> str_replace (',','.',$val ['3']),
                        'fuso'=> str_replace (',','.',$val ['4']),
                        'hemisferio'=> $val ['5'],
                        'ultima_alteracao'=>$ultima_alteracao
                     );
               $inseridos ++;
        }

         if($inseridos == 0){
            $result = false;
            $result["mensagem"] = "Não foi possivel Inserir Dados!";
            $result["notify"] = "warning";
          die(json_encode($result));
         }else{
          $this->Tb_configuracao_obra->insereConfiguracao_Arquivoupdate($dadosS);
          $retorno = $this->Tb_configuracao_georreferenciamento->inserirdados($dados);
//          $arquivolocalho = ("arquivoDaq/arq/".$nomeArquivo);
//          unlink($arquivolocalho);
          echo (json_encode($retorno));
         }

                  
   }
#-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
    public function RecuperaNomeEixo() {
        $dados["id_contrato"] = $this->session->idContrato;
        $dados["nome_eixo"] = $this->input->post_get("nome_apelido");
        $dados["data"] = array();
        $Dados = $this->Tb_configuracao_georreferenciamento->RecuperaNomeEixo($dados);

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
               $conte=$lista->conte;
            }
        }
        if($conte > 0){
        $dados["resultado"] = true;
        }else{
        $dados["resultado"] = false;
        }
        echo (json_encode($dados));
    }

}
