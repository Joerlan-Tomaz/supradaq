<?php
/*
 * Carga Local.
 * @author Pedro Henrique <pedrocorreia@falconi.com>
 * @version 1.0 
 */
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 3600);

class connection
{

	public static $conn;
	public static function open($basename)
	{
		try {
			switch ($basename) {
				case 'supradaq':
					$servername = "10.100.10.144\SQLCGMI";
					$instancia = "";
					$porta = "";
					$database = "DEV_SUPRA_DAQ";
					$uid = "usr_supra_daq";
					$pwd = "2e53w1";
					$conn = new PDO("sqlsrv:Server={$servername};Database={$database}", $uid, $pwd);
					break;

				case 'supradif':
					$servername = "10.100.10.144\SQLCGMI";
					$instancia = "";
					$porta = "";
					$database = "DEV_SUPRA_DIF";
					$uid = "usr_supra_dif";
					$pwd = "Rf7e3$";
					$conn = new PDO("sqlsrv:Server={$servername};Database={$database}", $uid, $pwd);
					break;

				case 'localdaq':
					$servername = "localhost";
					$instancia = "";
					$porta = "";
					$database = "LOCAL_DAQ";
					$uid = "";
					$pwd = "";
					$conn = new PDO("sqlsrv:Server={$servername};Database={$database}");
					break;

				case 'localdif':
					$servername = "localhost";
					$instancia = "";
					$porta = "";
					$database = "LOCAL_DIF";
					$uid = "";
					$pwd = "";
					$conn = new PDO("sqlsrv:Server={$servername};Database={$database}");
					break;
			}

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;

		} catch (PDOException $e) {
			echo "Drivers disponiveis: " . implode(",", PDO::getAvailableDrivers());
			echo 'ERROR: Error connecting to database ', $e->getMessage();
			die;
		}
	}
}
$bases[0]['server'] = 'supradaq';
$bases[0]['local'] = 'localdaq';
$bases[0]['db'] = 'LOCAL_DAQ';
$bases[1]['server'] = 'supradif';
$bases[1]['local'] = 'localdif';
$bases[1]['db'] = 'LOCAL_DIF';

foreach ($bases as $base){
	try {
		$p_sql = connection::open($base['server'])->prepare("SELECT * FROM information_schema.tables ORDER BY TABLE_NAME");
		$p_sql->execute();
		//-------------------------------------------------------------------
		$tabelasDAQ = $p_sql->fetchAll(PDO::FETCH_ASSOC);

		foreach($tabelasDAQ as $tabela){
			//Limpa a tabela
			$p_sql = connection::open($base['local'])->prepare("DROP TABLE IF EXISTS {$tabela['TABLE_NAME']}");
			$p_sql->execute();

			//Colunas da tabela
			$p_sql = connection::open($base['server'])->prepare("sp_columns {$tabela['TABLE_NAME']}");
			$p_sql->execute();
			$colunasTabela = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			$create = "CREATE TABLE {$tabela['TABLE_NAME']} (";
			foreach($colunasTabela as $i => $coluna){
				$create .= "{$coluna['COLUMN_NAME']} ";

				if($coluna['TYPE_NAME'] == 'int identity'){
					$create .= "int";
				}elseif($coluna['TYPE_NAME'] == 'varchar'){
					$create .= "varchar({$coluna['PRECISION']})";
				}elseif($coluna['TYPE_NAME'] == 'decimal'){
					$create .= "decimal({$coluna['PRECISION']},{$coluna['SCALE']})";
				}else{
					$create .= "{$coluna['TYPE_NAME']}";
				}

				if(count($colunasTabela) - 1 != $i){
					$create .= ", ";
				}
			}
			$create .= ")";

			$criarTabela = connection::open($base['local'])->prepare($create);
			$exceptioobra = $criarTabela->execute();

			//Busca Dados Tabela
			//Colunas da tabela
			$p_sql = connection::open($base['server'])->prepare("SELECT * FROM {$tabela['TABLE_NAME']}");
			$p_sql->execute();
			$dadosTabela = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			$p_sql = connection::open($base['server'])->prepare("sp_columns {$tabela['TABLE_NAME']}");
			$p_sql->execute();
			$colunasTabela = $p_sql->fetchAll(PDO::FETCH_ASSOC);

			//Insere dados Local
			$qtd = 0;
			foreach($dadosTabela as $d => $dados){
				$col = 0;
				$insertColunas = array();
				$insertValores = array();
				foreach($dados as $dl => $dadoLinha){
					if($dadoLinha != NULL){
						$insertColunas[] = $colunasTabela[$col]['COLUMN_NAME'];
						if($colunasTabela[$col]['TYPE_NAME'] == 'varchar'
							OR $colunasTabela[$col]['TYPE_NAME'] == 'text'
							OR $colunasTabela[$col]['TYPE_NAME'] == 'char'
							OR $colunasTabela[$col]['TYPE_NAME'] == 'date'
							OR $colunasTabela[$col]['TYPE_NAME'] == 'datetime'){
							$dadoLinha = str_replace("'",'´', $dadoLinha);
							$insertValores[] = "'{$dadoLinha}'";
						}else{
							$insertValores[] = $dadoLinha;
						}
					}
					$col++;
				}
				$insert = "INSERT INTO {$tabela['TABLE_NAME']}(" . implode($insertColunas,',') . ") VALUES(" . implode($insertValores,',') . ")";
				$insert_dados = connection::open($base['local'])->prepare($insert);
				$exceptioobra = $insert_dados->execute();

				$qtd++;
			}

			echo "Tabela {$tabela['TABLE_NAME']} Atualizada;";
			echo "<br>";
			echo "Inseridos {$qtd} Registros;";
			echo "<hr>";
		}

	}catch (PDOException $e){
		echo '<pre>';
		var_dump($e);
		echo '</pre>';
		die;
	}
}

//--------------------------------------------------------------------------------------------------------------------------------------------
?>
