<?php
require_once (APPPATH.'/libraries/ImportExcelInterface.php');

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportExcelAbstract implements ImportExcelInterface
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }
	
	/**
	 * le o arquivo e transforma em array de dados tratados
	 */
    function lerArquivo($arquivo){
    }   

	/**
	 * Pega valores da primeira linha que correspondem aos nomes das colunas da tabela no bd.
	 */
    function associarColunasElinhas($dadosDaPlanilha){

        try{
            
            $dados = array();
            $quantidadeColunas = 0;
            $colunas;//pega o nome das colunas
    
            for($linha=0; $linha < count($dadosDaPlanilha); $linha++){
                //considera que a primeira linha são as colunas
                if($linha == 0){
    
                    //Pegando o nome das colunas e elimina colunas em Branco
                    $colunas = array_filter($dadosDaPlanilha[$linha]);
                    
                    array_walk_recursive($colunas, function(&$item, $key){
                        //Eliminando espacos nos nomes das colunas
                        $item = trim($item);
                        $item = str_replace(' ','',$item);
                    });
                    
                    $quantidadeColunas = count($colunas);
                    continue;
                }
                
                //pega o valor de cada linha de acordo com a quantidade de colunas
                $linhaAtual = array();
                for($i=0; $i < $quantidadeColunas; $i++){
                    $linhaAtual[] = $dadosDaPlanilha[$linha][$i];
                }
                
                //se a linha estiver vazia pula para a proxima
                if(empty(array_filter($linhaAtual))){
                    continue;
                } 
                
                //associa colunas e linhas
                $dados[] = array_combine($colunas,$linhaAtual);                
            }
            return $this->tratarCamposDaPlanilha($dados);


            //throw new Exception('Erro ao associar colunas e linhas');

        }catch(Exception $e){

            echo $e->getMessage();die;
        }
    }


	/**
	 * limpeza e troca de , por .
	 */
    function tratarCamposDaPlanilha($dados){

        try{ 
            array_walk_recursive($dados, function(&$item, $key){
                if(strpos($item, '%') !== false){
                    $item = trim(str_replace(array('%'),array(''), $item));
                }
                if(strpos($item, 'R$') !== false){
                    $item = trim(str_replace(array(',','R$','(',')'),array('','','-',''), $item));
                }
                if(strpos($item, '$') !== false){
                    $item = trim(str_replace(array(',','$','(',')'),array('','','-',''), $item));
                }
                if(preg_match('/^(0?[1-9]|1[012])\/([012]?[1-9]|[12]0|3[01])\/([0-9]{4})$/', $item)){
                    $data  = explode('/',$item);
                    if($data[0] < 10){
                        $data[0] = '0'.$data[0];
                    }
                    if($data[1] < 10){
                        $data[1] = '0'.$data[1];
                    }
                    $item = $data[2].'-'.$data[0].'-'.$data[1]; 
                }
                if($item === null || $item === ''){
                    $item = '';
                }
            });

            return utf8_converter($dados);

            //throw new Exception('Erro ao tratrar os campos do arquivo.');

        }catch(Exception $e){

            echo $e->getMessage();die;

        }
    }

	/**
	 * pega o array $dadosDaplanilha e insere na $tabela <string>
	 */
    function gravarDadosExcel($dadosDaPlanilha, $tabela){
        try{
            if($this->dadosVazio($dadosDaPlanilha)){
                throw new Exception('Erro: Dados enviados estão em branco.');
            }

            $this->CI->load->model('comum/ImportExcelModel');
            $result = $this->CI->ImportExcelModel->insertDadosExcel($this->trataCodificacao($dadosDaPlanilha),$tabela);

            if(!$result){
                throw new Exception('Erro: Não foi possivel inserir os dados no banco de Dados.');
            }
            
        }catch(Exception $e){
            echo $e->getMessage();die;
        }
    }


    /**
	 * metodo verifica se o array esta vazio
	 */
    function dadosVazio($dados){
        
        $confereCampos = array();
        $vazio = false;
        foreach($dados as $dado){
            $confereCampos[] = array_filter($dado);
        }
        if(empty(array_filter($confereCampos))){
            $vazio = true;
        }else{
            $vazio = false;
        }
        unset($confereCampos);
        return $vazio;
    }


	/**
	 * verifica valor null e 0
	 */
    function trataCodificacao($dados){
        array_walk_recursive($dados, function(&$item, $key){
            if($item === ""){
                $item = null;
            }elseif(is_numeric($item)){
                $item += 0;
            }else{
                $item = utf8_decode($item);
            }
        });	
        return $dados;
    }

    
    public function dividirDadosArray($arr, $max) {

        $arrayOfArrays = [];
        for ($i = 0; $i < count($arr); $i += $max) {
            array_push($arrayOfArrays, array_slice($arr, $i, $i + $max));
        }
        return $arrayOfArrays;
    }
}
