<?php
require_once (APPPATH.'/libraries/ImportExcelAbstract.php');

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportExcelPhpOffice extends ImportExcelAbstract
{	
	/**
	 * le o arquivo e transforma em array de dados tratados
	 */
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
    
    public function lerArquivo2($arquivo){

        try{
            $extensao = @end(explode('.', $arquivo));

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

            $planilha = $leitor->load($arquivo);
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

}
