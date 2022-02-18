
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ImportExcelInterface Class
 *
 * Interface para classes importadoras de Excel
 *
 */
interface ImportExcelInterface {


	/**
	 * le o arquivo e transforma em array de dados tratados
	 */
    function lerArquivo($arquivo);   

	/**
	 * Pega valores da primeira linha que correspondem aos nomes das colunas da tabela no bd.
	 */
    function associarColunasElinhas($dadosDaPlanilha);

	/**
	 * tratamento dos campos limpeza e troca de , por .
	 */
	function tratarCamposDaPlanilha($dados);

	/**
	 * pega o array $dadosDaplanilha e insere na $tabela <string>
	 */
	function gravarDadosExcel($dadosDaPlanilha, $tabela);
	
    /**
	  * metodo verifica se o array esta vazio
	  */
    function dadosVazio($dados);

	/**
	 * trata 0 e null
	 */
    function trataCodificacao($dados);

}
	