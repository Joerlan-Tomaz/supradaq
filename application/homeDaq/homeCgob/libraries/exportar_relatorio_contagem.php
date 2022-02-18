<?php

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("SUPRA")
								 ->setLastModifiedBy("SUPRA")
								 ->setTitle("Exportação $nomeArquivo SUPRA")
								 ->setSubject("")
								 ->setDescription( "" . $nomeArquivo . "| Gerado em:".date('d/m/Y'))
								 ->setKeywords("office 2007")
								 ->setCategory("Test result file");

	try{
		
		$inicioLinha = 2;
		$alfabeto = 'ABCDEFGHIJKLMNOPQRSTUVXZ';

		//FluxoAnual
		$letraTitulo = 0;
		$linhaTitulo = 1;

		foreach($arrFluxoAnual as $fluxoAnual){
			foreach($fluxoAnual as $chave => $valor){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alfabeto[$letraTitulo].$linhaTitulo, $chave);
				$objPHPExcel->getActiveSheet()->getStyle($alfabeto[$letraTitulo].$linhaTitulo)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($alfabeto[$letraTitulo].$linhaTitulo)->getFill()->getStartColor()->setARGB('00A6D6');
				$objPHPExcel->getActiveSheet()->getStyle($alfabeto[$letraTitulo].$linhaTitulo)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
				$objPHPExcel->getActiveSheet()->getStyle($alfabeto[$letraTitulo].$linhaTitulo)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alfabeto[$letraTitulo].$linhaTitulo)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$letraTitulo++;
			}
		}

		$letraValor = 0;
		$linhaValor = 2;

		foreach($arrFluxoAnual as $fluxoAnual){
			foreach($fluxoAnual as $chave => $valor){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alfabeto[$letraValor].$linhaValor, $valor);
				$objPHPExcel->getActiveSheet()->getStyle($alfabeto[$letraValor].$linhaValor)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
				$objPHPExcel->getActiveSheet()->getStyle($alfabeto[$letraValor].$linhaValor)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$letraValor++;
			}
		}

		$objPHPExcel->getActiveSheet()->setTitle('Dados Anula'); /* */

		$objPHPExcel->createSheet();

		//--------------------------------

		//FluxoMensal
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue();
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'UF');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Rodovia');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'KM');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Sentido');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Equipamento');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Ano');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Classe');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Janeiro');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Fevereiro');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Março');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Abril');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Maio');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Junho');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Julho');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Agosto');
		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Setembro');
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Outubro');
		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Novembro');
		$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Dezembro');
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFill()->getStartColor()->setARGB('00A6D6');
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);

		$linhaFM = $inicioLinha;
		foreach($arrFluxoMensal as $key => $temp){
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue();
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$linhaFM, $temp['uf']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$linhaFM, $temp['rodovia']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$linhaFM, $temp['km']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$linhaFM, $temp['sentido']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$linhaFM, $temp['equipamento']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$linhaFM, $temp['ano']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$linhaFM, $temp['classe']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$linhaFM, $temp['janeiro']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$linhaFM, $temp['fevereiro']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$linhaFM, $temp['março']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$linhaFM, $temp['abril']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$linhaFM, $temp['maio']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$linhaFM, $temp['junho']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$linhaFM, $temp['julho']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$linhaFM, $temp['agosto']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$linhaFM, $temp['setembro']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$linhaFM, $temp['outubro']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$linhaFM, $temp['novembro']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$linhaFM, $temp['dezembro']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$linhaFM.':S'.$linhaFM)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$linhaFM.':S'.$linhaFM)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$linhaFM)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//$objPHPExcel->getActiveSheet()->getStyle('H'.$linhaFM.':S'.$linhaFM)->getNumberFormat()->setFormatCode('R$ * 0.00');
			$linhaFM++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Dados Mensal');

		$objPHPExcel->createSheet();

		//--------------------------------

		//FluxoSemanal
		$objPHPExcel->setActiveSheetIndex(2)->setCellValue();
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'UF');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Rodovia');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'KM');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Sentido');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Equipamento');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Ano');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Mês');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Classe');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Semana 1');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Semana 2');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Semana 3');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Semana 4');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Semana 5');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Semana 6');
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFill()->getStartColor()->setARGB('00A6D6');
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$linhaFS = $inicioLinha;
		foreach($arrFluxoSemanal as $key => $temp){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$linhaFS, $temp['uf']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$linhaFS, $temp['rodovia'] );
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$linhaFS, $temp['km']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$linhaFS, $temp['sentido'] );
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$linhaFS, $temp['equipamento']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$linhaFS, $temp['ano']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$linhaFS, $temp['meses']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$linhaFS, $temp['classe']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$linhaFS, $temp['semana 1']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$linhaFS, $temp['semana 2']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$linhaFS, $temp['semana 3']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$linhaFS, $temp['semana 4']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$linhaFS, $temp['semana 5']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$linhaFS, $temp['semana 6']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$linhaFS.':N'.$linhaFS)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$linhaFS.':N'.$linhaFS)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$linhaFS.':N'.$linhaFS)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E:G')->setAutoSize(true);
			$linhaFS++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Dados Semanal');

		$objPHPExcel->createSheet();

		//--------------------------------

		//FluxoHora
		$objPHPExcel->setActiveSheetIndex(3)->setCellValue();
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'UF');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Rodovia');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'KM');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Sentido');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Equipamento');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Ano');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Mês');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Dia');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Classe');
 		$objPHPExcel->getActiveSheet()->setCellValue('J1', '00h-01h');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', '01h-02h');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', '02h-03h');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', '03h-04h');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', '04h-05h');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', '05h-06h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('P1', '06h-07h'); 		
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', '07h-08h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('R1', '08h-09h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('S1', '09h-10h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('T1', '10h-11h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('U1', '11h-12h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('V1', '12h-13h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('X1', '13h-14h'); 	
		$objPHPExcel->getActiveSheet()->setCellValue('W1', '14h-15h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('Y1', '15h-16h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('Z1', '16h-17h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('AA1', '17h-18h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('AB1', '18h-19h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('AC1', '19h-20h'); 	
		$objPHPExcel->getActiveSheet()->setCellValue('AD1', '20h-21h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('AE1', '21h-22h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('AF1', '22h-23h'); 
		$objPHPExcel->getActiveSheet()->setCellValue('AG1', '23h-24h'); 
		$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->getFill()->getStartColor()->setARGB('00A6D6');
		$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$linhaFH = $inicioLinha;
		foreach($arrFluxoHora as $key => $temp4){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$linhaFH, $temp4['uf']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$linhaFH, $temp4['rodovia']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$linhaFH, $temp4['km']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$linhaFH, $temp4['sentido']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$linhaFH, $temp4['equipamento']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$linhaFH, $temp4['ano']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$linhaFH, $temp4['meses']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$linhaFH, $temp4['dia']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$linhaFH, $temp4['classe']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$linhaFH, $temp4['00h-01h']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$linhaFH, $temp4['01h-02h']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$linhaFH, $temp4['02h-03h']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$linhaFH, $temp4['03h-04h']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$linhaFH, $temp4['04h-05h']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$linhaFH, $temp4['05h-06h']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$linhaFH, $temp4['06h-07h']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$linhaFH, $temp4['07h-08h']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$linhaFH, $temp4['08h-09h']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$linhaFH, $temp4['09h-10h']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$linhaFH, $temp4['10h-11h']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$linhaFH, $temp4['11h-12h']);
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$linhaFH, $temp4['12h-13h']);
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$linhaFH, $temp4['13h-14h']);
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$linhaFH, $temp4['14h-15h']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$linhaFH, $temp4['15h-16h']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$linhaFH, $temp4['16h-17h']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$linhaFH, $temp4['17h-18h']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$linhaFH, $temp4['18h-19h']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$linhaFH, $temp4['19h-20h']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$linhaFH, $temp4['20h-21h']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$linhaFH, $temp4['21h-22h']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$linhaFH, $temp4['22h-23h']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$linhaFH, $temp4['23h-24h']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$linhaFH.':AG'.$linhaFH)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$linhaFH.':AG'.$linhaFH)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$linhaFH.':AG'.$linhaFH)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E:G')->setAutoSize(true);
			$linhaFH++;
		} /* */

		$objPHPExcel->getActiveSheet()->setTitle('Dados Diario'); 

		//$objPHPExcel->createSheet();

	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}

	// Define a planilha como ativa sendo a primeira, assim quando abrir o arquivo será a que virá aberta como padrão
	$objPHPExcel->setActiveSheetIndex(0);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'. $nomeArquivo .'"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	// If you're serving to IE over SSL, then the following may be needed
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header('Pragma: public'); // HTTP/1.0
	
	ob_end_clean();

	$objWriter->save('php://output');

?>