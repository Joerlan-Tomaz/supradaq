<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportExcel
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function lerArquivo($arquivo){

        try{
            $extensao = @end(explode('.', $arquivo['name']));

            if($extensao != 'xlsx' && $extensao != 'xls'){
                throw new Exception('Formato de Arquivo não suportado');
            }

            $leitor = '';
            //instancia a classe de leitura
            if($extensao == 'xlsx'){
                $leitor = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }elseif($extensao == 'xls'){
                $leitor = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }

            $planilha = $leitor->load($arquivo['tmp_name']);
            //pega os dados da planilha em um array
            $dadosDaPlanilha =  $planilha->getActiveSheet()->toArray();

            if($this->dadosVazio($dadosDaPlanilha)){
                throw new Exception('O presente arquivo esta vazio');
            }

            return $this->associarColunasElinhas($dadosDaPlanilha);

        }catch(Exception $e){
            echo $e->getMessage();die;
            // return array('error'=>'Falaha na leitura do arquivo.');
        }
    }   

    private function associarColunasElinhas($dadosDaPlanilha){

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


    private function tratarCamposDaPlanilha($dados){

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

    public function gravarDadosExcel($dadosDaPlanilha, $tabela){
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


    //metodo verifica se o array esta vazio
    private function dadosVazio($dados){
        
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


    private function trataCodificacao($dados){
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
}