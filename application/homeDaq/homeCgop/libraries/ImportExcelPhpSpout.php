<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once APPPATH . '/libraries/ImportExcelAbstract.php';

class ImportExcelPhpSpout extends ImportExcelAbstract {

    /**
     * le o arquivo e transforma em array de dados tratados
     */
    public function lerArquivo($arquivo) {
        try {

            $type = Box\Spout\Common\Type::XLSX;
            $reader = Box\Spout\Reader\ReaderFactory::create($type);

            $reader->open($arquivo['tmp_name']);

            $dadosDaPlanilha = [];

            foreach ($reader->getSheetIterator() as $sheet) {
                // only read data from 1st sheet
                if ($sheet->getIndex() === 0) { // index is 0-based
                    foreach ($sheet->getRowIterator() as $row) {
                        // do something with the row
                        if ($row[0] !== '' && $row[1] !== '')
                            array_push($dadosDaPlanilha, $row);
                    }
                    break; // no need to read more sheets
                }
            }

            $reader->close();

//            $dadosDaPlanilha = array_chunk($dadosDaPlanilha, 50);


            $dadosDaPlanilha = $this->associarColunasElinhas($dadosDaPlanilha);
            
  
            return $dadosDaPlanilha;
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
            // return array('error'=>'Falaha na leitura do arquivo.');
        }
    }

    public function dividirDadosArray($arr, $max) {

        $arrayOfArrays = [];
        for ($i = 0; $i < count($arr); $i += $max) {
            array_push($arrayOfArrays, array_slice($arr, $i, $i + $max));
        }
        return $arrayOfArrays;
    }

}
