<?php
/*
 * Carga DIF. 
 * @author Jordana Alencar <jordanaaraujo@falconi.com>
 * @version 1.0 
 */
ini_set('max_execution_time',3600);
class connection {

	public static $conn;

	public static function open($basename) {
		try {
			switch ($basename) {


				case 'supradif':
				$servername = "10.100.10.144\SQLCGMI";
				$instancia = "";
				$porta = "";
				$database = "DEV_SUPRA_DIF";
				$uid = "usr_supra_dif";
				$pwd = "Rf7e3$";
				$conn = new PDO( "sqlsrv:Server={$servername};Database={$database}", $uid, $pwd );
				break;

				case 'sindnit':
				$servername = "10.100.10.144\MSSQL";
				$instancia = "";
				$porta = "";
				$database = "SIMDNIT";
				$uid = "sharepoint_acc_hom";
				$pwd = "spacchom";
				$conn = new PDO( "sqlsrv:Server={$servername};Database={$database}", $uid, $pwd );
				break;
			}

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			return $conn;

		} catch(PDOException $e) {
			echo "Drivers disponiveis: " . implode( ",", PDO::getAvailableDrivers() );
			echo 'ERROR: Error connecting to database ',$e->getMessage();
			die;
		}
	}
}
//--------------------------------------------------------------------------------------------------------------------------------------------
	try {

		$DadosContrato = [];
		$p_sql = connection::open('sindnit')->prepare("SELECT * FROM Dados_Contrato Where DS_MODAL in ('FERROVIARIO') and DS_TIP_CONTRATO like '%OBRA DE ENGENHARIA%'");
		$p_sql->execute();
	//-------------------------------------------------------------------
		$DadosContrato = $p_sql->fetchAll(PDO::FETCH_ASSOC);

		$nuConformatado = array_column($DadosContrato, 'NU_CON_FORMATADO');

		} catch (PDOException $e) {
			print "Ocorreu um erro ao tentar executar esta ação -> Select Simdnit.<br/>". $e->getMessage();
			die;
		}

	try {
			$DadosContratosp = [];
			$psp_sql = connection::open('sindnit')->prepare("SELECT * FROM Dados_Contrato Where DS_MODAL in ('FERROVIARIO') and DS_TIP_CONTRATO like '%SUPERVISAO%'");
			$psp_sql->execute();
		//-------------------------------------------------------------------
			$DadosContratosp = $psp_sql->fetchAll(PDO::FETCH_ASSOC);

			$nuConformatadosp = array_column($DadosContratosp, 'NU_CON_FORMATADO');

		} catch (PDOException $e) {
			print "Ocorreu um erro ao tentar executar esta ação -> Select Simdnit.<br/>". $e->getMessage();
			die;
		}
		
	try {				
			$query = connection::open('supradif')->prepare( "SELECT * FROM CONFER_TB_CONTRATO" );
			$query->execute();
	//-------------------------------------------------------------------
			$DadosContratoCgob = $query->fetchAll(PDO::FETCH_ASSOC);

			$nuConformatadoCgob = array_column($DadosContratoCgob, 'nu_con_formatado');

		} catch (PDOException $e) {
			print "Ocorreu um erro ao tentar executar esta ação -> Select Contrato.<br/>". $e->getMessage();
			die;
		}
		
	try {				
			$query_sp = connection::open('supradif')->prepare( "SELECT * FROM CONFER_TB_CONTRATO_SUPERVISAO" );
			$query_sp->execute();
		//-------------------------------------------------------------------
			$DadosSpCgob = $query_sp->fetchAll(PDO::FETCH_ASSOC);

			$nuSpformatadoCgob = array_column($DadosSpCgob, 'nu_con_formatado');

		} catch (PDOException $e) {
			print "Ocorreu um erro ao tentar executar esta ação -> Select Contrato.<br/>". $e->getMessage();
			die;
		}
		//--------------------------------------------------------------
		$campare = array_diff($nuConformatado, $nuConformatadoCgob);
			$campare_sp = array_diff($nuConformatadosp, $nuSpformatadoCgob);
				$medicao_fdr = array_merge($nuConformatadoCgob, $nuSpformatadoCgob);
		//--------------------------------------------------------------------------------
		$str = "('".implode("','",$campare)."')";
			$str_sp = "('".implode("','",$campare_sp)."')";
				$ctr_values = "('".implode("','",$nuConformatadoCgob)."')";
					$spr_values = "('".implode("','",$nuSpformatadoCgob)."')";
						$me_values = "('".implode("','",$medicao_fdr)."')";

						
//--------------------------------------------------------------------------------
	try {
			$ps_sql = connection::open('sindnit')->prepare("SELECT * FROM Dados_Contrato Where nu_con_formatado in $ctr_values");
			$ps_sql->execute();

			$DadosContratoCgobUp = $ps_sql->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação -> Select Simdnit.<br/>". $e->getMessage();
		die;
	}//--------------------------------------------------------------
	try {
			$sqlk = "UPDATE CONFER_TB_CONTRATO SET  nu_cnpj_cpf = :nu_cnpj_cpf
		  		,sk_contrato = :sk_contrato
		      ,nu_con_formatado = :nu_con_formatado
		      ,sk_contrato_supervisor = :sk_contrato_supervisor
		      ,dt_base = :dt_base
		      ,dt_corrente = :dt_corrente
		      ,dt_termino_vigencia = :dt_termino_vigencia
		      ,dt_aprovacao = :dt_aprovacao
		      ,dt_assinatura = :dt_assinatura
		      ,dt_proposta = :dt_proposta
		      ,dt_publicacao = :dt_publicacao
		      ,dt_inicio = :dt_inicio
		      ,dt_ter_atz = :dt_ter_atz
		      ,dt_ter_prv = :dt_ter_prv
		      ,sk_empresa = :sk_empresa
		      ,no_empresa = :no_empresa
		      ,sk_empresa_supervisor = :sk_empresa_supervisor
		      ,sg_empresa_supervisor = :sg_empresa_supervisor
		      ,sk_fiscal = :sk_fiscal
		      ,nm_fiscal = :nm_fiscal
		      ,ds_grupo_intervencao = :ds_grupo_intervencao
		      ,sk_modal = :sk_modal
		      ,ds_modal = :ds_modal
		      ,modalidade_licitacao = :modalidade_licitacao
		      ,sk_municipio = :sk_municipio
		      ,no_municipio = :no_municipio
		      ,co_municipio = :co_municipio
		      ,no_municipio0 = :no_municipio0
		      ,nu_edital = :nu_edital
		      ,nu_lote_licitacao = :nu_lote_licitacao
		      ,nu_processo = :nu_processo
		      ,ds_objeto = :ds_objeto
		      ,sk_programa = :sk_programa
		      ,nm_programa = :nm_programa
		      ,nu_dia_paralisacao = :nu_dia_paralisacao
		      ,nu_dia_prorrogacao = :nu_dia_prorrogacao
		      ,sk_situacao_contrato = :sk_situacao_contrato
		      ,ds_fas_contrato = :ds_fas_contrato
		      ,co_tip_contrato = :co_tip_contrato
		      ,ds_tip_contrato = :ds_tip_contrato
		      ,sk_tipo_intervencao = :sk_tipo_intervencao
		      ,ds_tip_intervencao = :ds_tip_intervencao
		      ,tipo_licitacao = :tipo_licitacao
		      ,descricao_br = :descricao_br
		      ,sk_uf_unidade_local = :sk_uf_unidade_local
		      ,sg_uf_unidade_local = :sg_uf_unidade_local
		      ,co_uf = :co_uf
		      ,sg_uf = :sg_uf
		      ,sk_unidade_fiscal = :sk_unidade_fiscal
		      ,nm_und_fiscal = :nm_und_fiscal
		      ,sg_und_fiscal = :sg_und_fiscal
		      ,sk_unidade_gestora = :sk_unidade_gestora
		      ,nm_und_gestora = :nm_und_gestora
		      ,sg_und_gestora = :sg_und_gestora
		      ,sk_unidade_local = :sk_unidade_local
		      ,nm_und_local = :nm_und_local
		      ,sg_und_local = :sg_und_local
		      ,sk_unidade_pagamento = :sk_unidade_pagamento
		      ,nm_und_pagamento = :nm_und_pagamento
		      ,sg_und_pagamento = :sg_und_pagamento
		      ,Extensao_Total = :Extensao_Total
		      ,Valor_Inicial = :Valor_Inicial
		      ,Valor_Total_de_Aditivos = :Valor_Total_de_Aditivos
		      ,Valor_Total_de_Reajuste = :Valor_Total_de_Reajuste
		      ,Valor_Inicial_Adit_Reajustes = :Valor_Inicial_Adit_Reajustes
		      ,Valor_Empenhado = :Valor_Empenhado
		      ,Valor_Saldo = :Valor_Saldo
		      ,Valor_Medicao_PI_R = :Valor_Medicao_PI_R
		      ,Valor_PI_Medicao = :Valor_PI_Medicao
		      ,Valor_Reajuste_Medicao = :Valor_Reajuste_Medicao
		      ,Valor_Oficio_Pagamento = :Valor_Oficio_Pagamento
			WHERE nu_con_formatado = :num";
			$sqlup = connection::open('supradif')->prepare("$sqlk");
			$countUpd = 0;
			foreach ($DadosContratoCgobUp as $value):

				$sqlup->bindValue(':nu_cnpj_cpf', $value["NU_CNPJ_CPF"]);
				$sqlup->bindValue(':sk_contrato',$value["SK_CONTRATO"]);
				$sqlup->bindValue(':nu_con_formatado',$value["NU_CON_FORMATADO"]);
				$sqlup->bindValue(':sk_contrato_supervisor',$value["SK_CONTRATO_SUPERVISOR"]);
				$sqlup->bindValue(':dt_base',$value["DT_BASE"]);
				$sqlup->bindValue(':dt_corrente',$value["DT_CORRENTE"]);
				$sqlup->bindValue(':dt_termino_vigencia',$value["DT_TERMINO_VIGENCIA"]);
				$sqlup->bindValue(':dt_aprovacao',$value["DT_APROVACAO"]);
				$sqlup->bindValue(':dt_assinatura',$value["DT_ASSINATURA"]);
				$sqlup->bindValue(':dt_proposta',$value["DT_PROPOSTA"]);
				$sqlup->bindValue(':dt_publicacao',$value["DT_PUBLICACAO"]);
				$sqlup->bindValue(':dt_inicio',$value["DT_INICIO"]);
				$sqlup->bindValue(':dt_ter_atz',$value["DT_TER_ATZ"]);
				$sqlup->bindValue(':dt_ter_prv',$value["DT_TER_PRV"]);
				$sqlup->bindValue(':sk_empresa',$value["SK_EMPRESA"]);
				$sqlup->bindValue(':no_empresa',$value["NO_EMPRESA"]);
				$sqlup->bindValue(':sk_empresa_supervisor',$value["SK_EMPRESA_SUPERVISOR"]);
				$sqlup->bindValue(':sg_empresa_supervisor',$value["SG_EMPRESA_SUPERVISOR"]);
				$sqlup->bindValue(':sk_fiscal',$value["SK_FISCAL"]);
				$sqlup->bindValue(':nm_fiscal',$value["NM_FISCAL"]);
				$sqlup->bindValue(':ds_grupo_intervencao',$value["DS_GRUPO_INTERVENCAO"]);
				$sqlup->bindValue(':sk_modal',$value["SK_MODAL"]);
				$sqlup->bindValue(':ds_modal',$value["DS_MODAL"]);
				$sqlup->bindValue(':modalidade_licitacao',$value["MODALIDADE_LICITACAO"]);
				$sqlup->bindValue(':sk_municipio',$value["SK_MUNICIPIO"]);
				$sqlup->bindValue(':no_municipio',$value["NO_MUNICIPIO"]);
				$sqlup->bindValue(':co_municipio',$value["CO_MUNICIPIO"]);
				$sqlup->bindValue(':no_municipio0',$value["NO_MUNICIPIO0"]);
				$sqlup->bindValue(':nu_edital',$value["NU_EDITAL"]);
				$sqlup->bindValue(':nu_lote_licitacao',$value["NU_LOTE_LICITACAO"]);
				$sqlup->bindValue(':nu_processo',$value["NU_PROCESSO"]);
				$sqlup->bindValue(':ds_objeto',$value["DS_OBJETO"]);
				$sqlup->bindValue(':sk_programa',$value["SK_PROGRAMA"]);
				$sqlup->bindValue(':nm_programa',$value["NM_PROGRAMA"]);
				$sqlup->bindValue(':nu_dia_paralisacao',$value["NU_DIA_PARALISACAO"]);
				$sqlup->bindValue(':nu_dia_prorrogacao',$value["NU_DIA_PRORROGACAO"]);
				$sqlup->bindValue(':sk_situacao_contrato',$value["SK_SITUACAO_CONTRATO"]);
				$sqlup->bindValue(':ds_fas_contrato',$value["DS_FAS_CONTRATO"]);
				$sqlup->bindValue(':co_tip_contrato',$value["CO_TIP_CONTRATO"]);
				$sqlup->bindValue(':ds_tip_contrato',$value["DS_TIP_CONTRATO"]);
				$sqlup->bindValue(':sk_tipo_intervencao',$value["SK_TIPO_INTERVENCAO"]);
				$sqlup->bindValue(':ds_tip_intervencao',$value["ds_tip_intervencao"]);
				$sqlup->bindValue(':tipo_licitacao',$value["TIPO_LICITACAO"]);
				$sqlup->bindValue(':descricao_br',$value["DESCRICAO_BR"]);
				$sqlup->bindValue(':sk_uf_unidade_local',$value["SK_UF_UNIDADE_LOCAL"]);
				$sqlup->bindValue(':sg_uf_unidade_local',$value["SG_UF_UNIDADE_LOCAL"]);
				$sqlup->bindValue(':co_uf',$value["CO_UF"]);
				$sqlup->bindValue(':sg_uf',$value["SG_UF"]);
				$sqlup->bindValue(':sk_unidade_fiscal',$value["SK_UNIDADE_FISCAL"]);
				$sqlup->bindValue(':nm_und_fiscal',$value["NM_UND_FISCAL"]);
				$sqlup->bindValue(':sg_und_fiscal',$value["SG_UND_FISCAL"]);
				$sqlup->bindValue(':sk_unidade_gestora',$value["SK_UNIDADE_GESTORA"]);
				$sqlup->bindValue(':nm_und_gestora',$value["NM_UND_GESTORA"]);
				$sqlup->bindValue(':sg_und_gestora',$value["SG_UND_GESTORA"]);
				$sqlup->bindValue(':sk_unidade_local',$value["SK_UNIDADE_LOCAL"]);
				$sqlup->bindValue(':nm_und_local',$value["NM_UND_LOCAL"]);
				$sqlup->bindValue(':sg_und_local',$value["SG_UND_LOCAL"]);
				$sqlup->bindValue(':sk_unidade_pagamento',$value["SK_UNIDADE_PAGAMENTO"]);
				$sqlup->bindValue(':nm_und_pagamento',$value["NM_UND_PAGAMENTO"]);
				$sqlup->bindValue(':sg_und_pagamento',$value["SG_UND_PAGAMENTO"]);
				$sqlup->bindValue(':Extensao_Total',$value["Extensao_Total"]);
				$sqlup->bindValue(':Valor_Inicial',$value["Valor_Inicial"]);
				$sqlup->bindValue(':Valor_Total_de_Aditivos',$value["Valor_Total_de_Aditivos"]);
				$sqlup->bindValue(':Valor_Total_de_Reajuste',$value["Valor_Total_de_Reajuste"]);
				$sqlup->bindValue(':Valor_Inicial_Adit_Reajustes',$value["Valor_Inicial_Adit_Reajustes"]);
				$sqlup->bindValue(':Valor_Empenhado',$value["Valor_Empenhado"]);
				$sqlup->bindValue(':Valor_Saldo',$value["Valor_Saldo"]);
				$sqlup->bindValue(':Valor_Medicao_PI_R',$value["Valor_Medicao_PI_R"]);
				$sqlup->bindValue(':Valor_PI_Medicao',$value["Valor_PI_Medicao"]);
				$sqlup->bindValue(':Valor_Reajuste_Medicao',$value["Valor_Reajuste_Medicao"]);
				$sqlup->bindValue(':Valor_Oficio_Pagamento',$value["Valor_Oficio_Pagamento"]);
				$sqlup->bindValue(':num',$value["NU_CON_FORMATADO"]);
				$exception = $sqlup->execute();
				$countUpd++;
				endforeach;

			if($exception){
				//$count = $sqlup->rowCount();
					print("Update $countUpd rows CONFER_TB_CONTRATO!<br/>");
			}

		 	    } catch (PDOException $e) {
						    print "Ocorreu um erro ao tentar executar esta ação -> Atualizar Contrato obra.<br/>". $e->getMessage();

					}

	try {	
		$is_sql = connection::open('sindnit')->prepare("SELECT * FROM Dados_Contrato Where nu_con_formatado in $str");
		$is_sql->execute();
//-------------------------------------------------------------------------------------------------------------------------------
		$DadosContratoObrainst = $is_sql->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação -> Select Simdnit.<br/>". $e->getMessage();
		die;
	}//-------------------------------------------------------------------	

	$exceptioobrain = false;
	try {
		$insert_obra = connection::open('supradif')->prepare( "INSERT INTO CONFER_TB_CONTRATO ( nu_cnpj_cpf,sk_contrato,nu_con_formatado,sk_contrato_supervisor,nu_con_formatado_supervisor,dt_base,dt_corrente,dt_termino_vigencia,dt_aprovacao,dt_assinatura,dt_proposta,dt_publicacao,dt_inicio,dt_ter_atz,dt_ter_prv,sk_empresa,no_empresa,sk_empresa_supervisor,sg_empresa_supervisor,sk_fiscal,nm_fiscal,ds_grupo_intervencao,sk_modal,ds_modal,modalidade_licitacao,sk_municipio,no_municipio,co_municipio,no_municipio0,nu_edital,nu_lote_licitacao,nu_processo,ds_objeto,sk_programa,nm_programa,nu_dia_paralisacao,nu_dia_prorrogacao,sk_situacao_contrato,ds_fas_contrato,co_tip_contrato,ds_tip_contrato,sk_tipo_intervencao,ds_tip_intervencao,tipo_licitacao,descricao_br,sk_uf_unidade_local,sg_uf_unidade_local,co_uf,sg_uf,sk_unidade_fiscal,nm_und_fiscal,sg_und_fiscal,sk_unidade_gestora,nm_und_gestora,sg_und_gestora,sk_unidade_local,nm_und_local,sg_und_local,sk_unidade_pagamento,nm_und_pagamento,sg_und_pagamento,Extensao_Total,Valor_Inicial,Valor_Total_de_Aditivos,Valor_Total_de_Reajuste,Valor_Inicial_Adit_Reajustes,Valor_Empenhado,Valor_Saldo,Valor_Medicao_PI_R,Valor_PI_Medicao,Valor_Reajuste_Medicao,Valor_Oficio_Pagamento)  
			VALUES (:nu_cnpj_cpf,:sk_contrato,:nu_con_formatado,:sk_contrato_supervisor,:nu_con_formatado_supervisor,:dt_base,:dt_corrente,:dt_termino_vigencia,:dt_aprovacao,:dt_assinatura,:dt_proposta,:dt_publicacao,:dt_inicio,:dt_ter_atz,:dt_ter_prv,:sk_empresa,:no_empresa,:sk_empresa_supervisor,:sg_empresa_supervisor,:sk_fiscal,:nm_fiscal,:ds_grupo_intervencao,:sk_modal,:ds_modal,:modalidade_licitacao,:sk_municipio,:no_municipio,:co_municipio,:no_municipio0,:nu_edital,:nu_lote_licitacao,:nu_processo,:ds_objeto,:sk_programa,:nm_programa,:nu_dia_paralisacao,:nu_dia_prorrogacao,:sk_situacao_contrato,:ds_fas_contrato,:co_tip_contrato,:ds_tip_contrato,:sk_tipo_intervencao,:ds_tip_intervencao,:tipo_licitacao,:descricao_br,:sk_uf_unidade_local,:sg_uf_unidade_local,:co_uf,:sg_uf,:sk_unidade_fiscal,:nm_und_fiscal,:sg_und_fiscal,:sk_unidade_gestora,:nm_und_gestora,:sg_und_gestora,:sk_unidade_local,:nm_und_local,:sg_und_local,:sk_unidade_pagamento,:nm_und_pagamento,:sg_und_pagamento,:Extensao_Total,:Valor_Inicial,:Valor_Total_de_Aditivos,:Valor_Total_de_Reajuste,:Valor_Inicial_Adit_Reajustes,:Valor_Empenhado,:Valor_Saldo,:Valor_Medicao_PI_R,:Valor_PI_Medicao,:Valor_Reajuste_Medicao,:Valor_Oficio_Pagamento)" );
		$countIns = 0;
		if(!empty($DadosContratoObrainst)){		
		foreach ($DadosContratoObrainst as $value):
			$insert_obra->bindValue(':nu_cnpj_cpf', $value["NU_CNPJ_CPF"]);
			$insert_obra->bindValue(':sk_contrato',$value["SK_CONTRATO"]);
			$insert_obra->bindValue(':nu_con_formatado',$value["NU_CON_FORMATADO"]);
			$insert_obra->bindValue(':sk_contrato_supervisor',$value["SK_CONTRATO_SUPERVISOR"]);
			$insert_obra->bindValue(':nu_con_formatado_supervisor',$value["NU_CON_FORMATADO_SUPERVISOR"]);
			$insert_obra->bindValue(':dt_base',$value["DT_BASE"]);
			$insert_obra->bindValue(':dt_corrente',$value["DT_CORRENTE"]);
			$insert_obra->bindValue(':dt_termino_vigencia',$value["DT_TERMINO_VIGENCIA"]);
			$insert_obra->bindValue(':dt_aprovacao',$value["DT_APROVACAO"]);
			$insert_obra->bindValue(':dt_assinatura',$value["DT_ASSINATURA"]);
			$insert_obra->bindValue(':dt_proposta',$value["DT_PROPOSTA"]);
			$insert_obra->bindValue(':dt_publicacao',$value["DT_PUBLICACAO"]);
			$insert_obra->bindValue(':dt_inicio',$value["DT_INICIO"]);
			$insert_obra->bindValue(':dt_ter_atz',$value["DT_TER_ATZ"]);
			$insert_obra->bindValue(':dt_ter_prv',$value["DT_TER_PRV"]);
			$insert_obra->bindValue(':sk_empresa',$value["SK_EMPRESA"]);
			$insert_obra->bindValue(':no_empresa',$value["NO_EMPRESA"]);
			$insert_obra->bindValue(':sk_empresa_supervisor',$value["SK_EMPRESA_SUPERVISOR"]);
			$insert_obra->bindValue(':sg_empresa_supervisor',$value["SG_EMPRESA_SUPERVISOR"]);
			$insert_obra->bindValue(':sk_fiscal',$value["SK_FISCAL"]);
			$insert_obra->bindValue(':nm_fiscal',$value["NM_FISCAL"]);
			$insert_obra->bindValue(':ds_grupo_intervencao',$value["DS_GRUPO_INTERVENCAO"]);
			$insert_obra->bindValue(':sk_modal',$value["SK_MODAL"]);
			$insert_obra->bindValue(':ds_modal',$value["DS_MODAL"]);
			$insert_obra->bindValue(':modalidade_licitacao',$value["MODALIDADE_LICITACAO"]);
			$insert_obra->bindValue(':sk_municipio',$value["SK_MUNICIPIO"]);
			$insert_obra->bindValue(':no_municipio',$value["NO_MUNICIPIO"]);
			$insert_obra->bindValue(':co_municipio',$value["CO_MUNICIPIO"]);
			$insert_obra->bindValue(':no_municipio0',$value["NO_MUNICIPIO0"]);
			$insert_obra->bindValue(':nu_edital',$value["NU_EDITAL"]);
			$insert_obra->bindValue(':nu_lote_licitacao',$value["NU_LOTE_LICITACAO"]);
			$insert_obra->bindValue(':nu_processo',$value["NU_PROCESSO"]);
			$insert_obra->bindValue(':ds_objeto',$value["DS_OBJETO"]);
			$insert_obra->bindValue(':sk_programa',$value["SK_PROGRAMA"]);
			$insert_obra->bindValue(':nm_programa',$value["NM_PROGRAMA"]);
			$insert_obra->bindValue(':nu_dia_paralisacao',$value["NU_DIA_PARALISACAO"]);
			$insert_obra->bindValue(':nu_dia_prorrogacao',$value["NU_DIA_PRORROGACAO"]);
			$insert_obra->bindValue(':sk_situacao_contrato',$value["SK_SITUACAO_CONTRATO"]);
			$insert_obra->bindValue(':ds_fas_contrato',$value["DS_FAS_CONTRATO"]);
			$insert_obra->bindValue(':co_tip_contrato',$value["CO_TIP_CONTRATO"]);
			$insert_obra->bindValue(':ds_tip_contrato',$value["DS_TIP_CONTRATO"]);
			$insert_obra->bindValue(':sk_tipo_intervencao',$value["SK_TIPO_INTERVENCAO"]);
			$insert_obra->bindValue(':ds_tip_intervencao',$value["ds_tip_intervencao"]);
			$insert_obra->bindValue(':tipo_licitacao',$value["TIPO_LICITACAO"]);
			$insert_obra->bindValue(':descricao_br',$value["DESCRICAO_BR"]);
			$insert_obra->bindValue(':sk_uf_unidade_local',$value["SK_UF_UNIDADE_LOCAL"]);
			$insert_obra->bindValue(':sg_uf_unidade_local',$value["SG_UF_UNIDADE_LOCAL"]);
			$insert_obra->bindValue(':co_uf',$value["CO_UF"]);
			$insert_obra->bindValue(':sg_uf',$value["SG_UF"]);
			$insert_obra->bindValue(':sk_unidade_fiscal',$value["SK_UNIDADE_FISCAL"]);
			$insert_obra->bindValue(':nm_und_fiscal',$value["NM_UND_FISCAL"]);
			$insert_obra->bindValue(':sg_und_fiscal',$value["SG_UND_FISCAL"]);
			$insert_obra->bindValue(':sk_unidade_gestora',$value["SK_UNIDADE_GESTORA"]);
			$insert_obra->bindValue(':nm_und_gestora',$value["NM_UND_GESTORA"]);
			$insert_obra->bindValue(':sg_und_gestora',$value["SG_UND_GESTORA"]);
			$insert_obra->bindValue(':sk_unidade_local',$value["SK_UNIDADE_LOCAL"]);
			$insert_obra->bindValue(':nm_und_local',$value["NM_UND_LOCAL"]);
			$insert_obra->bindValue(':sg_und_local',$value["SG_UND_LOCAL"]);
			$insert_obra->bindValue(':sk_unidade_pagamento',$value["SK_UNIDADE_PAGAMENTO"]);
			$insert_obra->bindValue(':nm_und_pagamento',$value["NM_UND_PAGAMENTO"]);
			$insert_obra->bindValue(':sg_und_pagamento',$value["SG_UND_PAGAMENTO"]);
			$insert_obra->bindValue(':Extensao_Total',$value["Extensao_Total"]);
			$insert_obra->bindValue(':Valor_Inicial',$value["Valor_Inicial"]);
			$insert_obra->bindValue(':Valor_Total_de_Aditivos',$value["Valor_Total_de_Aditivos"]);
			$insert_obra->bindValue(':Valor_Total_de_Reajuste',$value["Valor_Total_de_Reajuste"]);
			$insert_obra->bindValue(':Valor_Inicial_Adit_Reajustes',$value["Valor_Inicial_Adit_Reajustes"]);
			$insert_obra->bindValue(':Valor_Empenhado',$value["Valor_Empenhado"]);
			$insert_obra->bindValue(':Valor_Saldo',$value["Valor_Saldo"]);
			$insert_obra->bindValue(':Valor_Medicao_PI_R',$value["Valor_Medicao_PI_R"]);
			$insert_obra->bindValue(':Valor_PI_Medicao',$value["Valor_PI_Medicao"]);
			$insert_obra->bindValue(':Valor_Reajuste_Medicao',$value["Valor_Reajuste_Medicao"]);
			$insert_obra->bindValue(':Valor_Oficio_Pagamento',$value["Valor_Oficio_Pagamento"]);
			$exceptioobrain = $insert_obra->execute();
			$countIns++;
		endforeach;
		}
		if($exceptioobrain){
			//$count = $insert_obra->rowCount();
			print("Insert $countIns rows CONFER_TB_CONTRATO!<br/>");
		}
	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação -> Inserir Contrato Obra.<br/>". $e->getMessage();

	}

//-------------------------------------------------------------------------------------------------------------------------------------
	try {	
		$spr_sql = connection::open('sindnit')->prepare("SELECT * FROM Dados_Contrato Where nu_con_formatado in $spr_values");
		$spr_sql->execute();

		$DadosSuperCgobUp = $spr_sql->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação -> Select Simdnit.<br/>". $e->getMessage();
		die;
	}//-------------------------------------------------------------------
		try {
			$sqlk = "UPDATE CONFER_TB_CONTRATO_SUPERVISAO SET  nu_cnpj_cpf = :nu_cnpj_cpf
			,sk_contrato = :sk_contrato
			,nu_con_formatado = :nu_con_formatado
			,sk_contrato_supervisor = :sk_contrato_supervisor
			,nu_con_formatado_supervisor = :nu_con_formatado_supervisor
			,dt_base = :dt_base
			,dt_corrente = :dt_corrente
			,dt_termino_vigencia = :dt_termino_vigencia
			,dt_aprovacao = :dt_aprovacao
			,dt_assinatura = :dt_assinatura
			,dt_proposta = :dt_proposta
			,dt_publicacao = :dt_publicacao
			,dt_inicio = :dt_inicio
			,dt_ter_atz = :dt_ter_atz
			,dt_ter_prv = :dt_ter_prv
			,sk_empresa = :sk_empresa
			,no_empresa = :no_empresa
			,sk_empresa_supervisor = :sk_empresa_supervisor
			,sg_empresa_supervisor = :sg_empresa_supervisor
			,sk_fiscal = :sk_fiscal
			,nm_fiscal = :nm_fiscal
			,ds_grupo_intervencao = :ds_grupo_intervencao
			,sk_modal = :sk_modal
			,ds_modal = :ds_modal
			,modalidade_licitacao = :modalidade_licitacao
			,sk_municipio = :sk_municipio
			,no_municipio = :no_municipio
			,co_municipio = :co_municipio
			,no_municipio0 = :no_municipio0
			,nu_edital = :nu_edital
			,nu_lote_licitacao = :nu_lote_licitacao
			,nu_processo = :nu_processo
			,ds_objeto = :ds_objeto
			,sk_programa = :sk_programa
			,nm_programa = :nm_programa
			,nu_dia_paralisacao = :nu_dia_paralisacao
			,nu_dia_prorrogacao = :nu_dia_prorrogacao
			,sk_situacao_contrato = :sk_situacao_contrato
			,ds_fas_contrato = :ds_fas_contrato
			,co_tip_contrato = :co_tip_contrato
			,ds_tip_contrato = :ds_tip_contrato
			,sk_tipo_intervencao = :sk_tipo_intervencao
			,ds_tip_intervencao = :ds_tip_intervencao
			,tipo_licitacao = :tipo_licitacao
			,descricao_br = :descricao_br
			,sk_uf_unidade_local = :sk_uf_unidade_local
			,sg_uf_unidade_local = :sg_uf_unidade_local
			,co_uf = :co_uf
			,sg_uf = :sg_uf
			,sk_unidade_fiscal = :sk_unidade_fiscal
			,nm_und_fiscal = :nm_und_fiscal
			,sg_und_fiscal = :sg_und_fiscal
			,sk_unidade_gestora = :sk_unidade_gestora
			,nm_und_gestora = :nm_und_gestora
			,sg_und_gestora = :sg_und_gestora
			,sk_unidade_local = :sk_unidade_local
			,nm_und_local = :nm_und_local
			,sg_und_local = :sg_und_local
			,sk_unidade_pagamento = :sk_unidade_pagamento
			,nm_und_pagamento = :nm_und_pagamento
			,sg_und_pagamento = :sg_und_pagamento
			,Extensao_Total = :Extensao_Total
			,Valor_Inicial = :Valor_Inicial
			,Valor_Total_de_Aditivos = :Valor_Total_de_Aditivos
			,Valor_Total_de_Reajuste = :Valor_Total_de_Reajuste
			,Valor_Inicial_Adit_Reajustes = :Valor_Inicial_Adit_Reajustes
			,Valor_Empenhado = :Valor_Empenhado
			,Valor_Saldo = :Valor_Saldo
			,Valor_Medicao_PI_R = :Valor_Medicao_PI_R
			,Valor_PI_Medicao = :Valor_PI_Medicao
			,Valor_Reajuste_Medicao = :Valor_Reajuste_Medicao
			,Valor_Oficio_Pagamento = :Valor_Oficio_Pagamento
			WHERE nu_con_formatado = :num";
			$sql_sp = connection::open('supradif')->prepare("$sqlk");
			$qtdUpdSup = 0;
			foreach ($DadosSuperCgobUp as $value):
				$sql_sp->bindValue(':nu_cnpj_cpf', $value["NU_CNPJ_CPF"]);
				$sql_sp->bindValue(':sk_contrato',$value["SK_CONTRATO"]);
				$sql_sp->bindValue(':nu_con_formatado',$value["NU_CON_FORMATADO"]);
				$sql_sp->bindValue(':sk_contrato_supervisor',$value["SK_CONTRATO_SUPERVISOR"]);
				$sql_sp->bindValue(':nu_con_formatado_supervisor',$value["NU_CON_FORMATADO_SUPERVISOR"]);
				$sql_sp->bindValue(':dt_base',$value["DT_BASE"]);
				$sql_sp->bindValue(':dt_corrente',$value["DT_CORRENTE"]);
				$sql_sp->bindValue(':dt_termino_vigencia',$value["DT_TERMINO_VIGENCIA"]);
				$sql_sp->bindValue(':dt_aprovacao',$value["DT_APROVACAO"]);
				$sql_sp->bindValue(':dt_assinatura',$value["DT_ASSINATURA"]);
				$sql_sp->bindValue(':dt_proposta',$value["DT_PROPOSTA"]);
				$sql_sp->bindValue(':dt_publicacao',$value["DT_PUBLICACAO"]);
				$sql_sp->bindValue(':dt_inicio',$value["DT_INICIO"]);
				$sql_sp->bindValue(':dt_ter_atz',$value["DT_TER_ATZ"]);
				$sql_sp->bindValue(':dt_ter_prv',$value["DT_TER_PRV"]);
				$sql_sp->bindValue(':sk_empresa',$value["SK_EMPRESA"]);
				$sql_sp->bindValue(':no_empresa',$value["NO_EMPRESA"]);
				$sql_sp->bindValue(':sk_empresa_supervisor',$value["SK_EMPRESA_SUPERVISOR"]);
				$sql_sp->bindValue(':sg_empresa_supervisor',$value["SG_EMPRESA_SUPERVISOR"]);
				$sql_sp->bindValue(':sk_fiscal',$value["SK_FISCAL"]);
				$sql_sp->bindValue(':nm_fiscal',$value["NM_FISCAL"]);
				$sql_sp->bindValue(':ds_grupo_intervencao',$value["DS_GRUPO_INTERVENCAO"]);
				$sql_sp->bindValue(':sk_modal',$value["SK_MODAL"]);
				$sql_sp->bindValue(':ds_modal',$value["DS_MODAL"]);
				$sql_sp->bindValue(':modalidade_licitacao',$value["MODALIDADE_LICITACAO"]);
				$sql_sp->bindValue(':sk_municipio',$value["SK_MUNICIPIO"]);
				$sql_sp->bindValue(':no_municipio',$value["NO_MUNICIPIO"]);
				$sql_sp->bindValue(':co_municipio',$value["CO_MUNICIPIO"]);
				$sql_sp->bindValue(':no_municipio0',$value["NO_MUNICIPIO0"]);
				$sql_sp->bindValue(':nu_edital',$value["NU_EDITAL"]);
				$sql_sp->bindValue(':nu_lote_licitacao',$value["NU_LOTE_LICITACAO"]);
				$sql_sp->bindValue(':nu_processo',$value["NU_PROCESSO"]);
				$sql_sp->bindValue(':ds_objeto',$value["DS_OBJETO"]);
				$sql_sp->bindValue(':sk_programa',$value["SK_PROGRAMA"]);
				$sql_sp->bindValue(':nm_programa',$value["NM_PROGRAMA"]);
				$sql_sp->bindValue(':nu_dia_paralisacao',$value["NU_DIA_PARALISACAO"]);
				$sql_sp->bindValue(':nu_dia_prorrogacao',$value["NU_DIA_PRORROGACAO"]);
				$sql_sp->bindValue(':sk_situacao_contrato',$value["SK_SITUACAO_CONTRATO"]);
				$sql_sp->bindValue(':ds_fas_contrato',$value["DS_FAS_CONTRATO"]);
				$sql_sp->bindValue(':co_tip_contrato',$value["CO_TIP_CONTRATO"]);
				$sql_sp->bindValue(':ds_tip_contrato',$value["DS_TIP_CONTRATO"]);
				$sql_sp->bindValue(':sk_tipo_intervencao',$value["SK_TIPO_INTERVENCAO"]);
				$sql_sp->bindValue(':ds_tip_intervencao',$value["ds_tip_intervencao"]);
				$sql_sp->bindValue(':tipo_licitacao',$value["TIPO_LICITACAO"]);
				$sql_sp->bindValue(':descricao_br',$value["DESCRICAO_BR"]);
				$sql_sp->bindValue(':sk_uf_unidade_local',$value["SK_UF_UNIDADE_LOCAL"]);
				$sql_sp->bindValue(':sg_uf_unidade_local',$value["SG_UF_UNIDADE_LOCAL"]);
				$sql_sp->bindValue(':co_uf',$value["CO_UF"]);
				$sql_sp->bindValue(':sg_uf',$value["SG_UF"]);
				$sql_sp->bindValue(':sk_unidade_fiscal',$value["SK_UNIDADE_FISCAL"]);
				$sql_sp->bindValue(':nm_und_fiscal',$value["NM_UND_FISCAL"]);
				$sql_sp->bindValue(':sg_und_fiscal',$value["SG_UND_FISCAL"]);
				$sql_sp->bindValue(':sk_unidade_gestora',$value["SK_UNIDADE_GESTORA"]);
				$sql_sp->bindValue(':nm_und_gestora',$value["NM_UND_GESTORA"]);
				$sql_sp->bindValue(':sg_und_gestora',$value["SG_UND_GESTORA"]);
				$sql_sp->bindValue(':sk_unidade_local',$value["SK_UNIDADE_LOCAL"]);
				$sql_sp->bindValue(':nm_und_local',$value["NM_UND_LOCAL"]);
				$sql_sp->bindValue(':sg_und_local',$value["SG_UND_LOCAL"]);
				$sql_sp->bindValue(':sk_unidade_pagamento',$value["SK_UNIDADE_PAGAMENTO"]);
				$sql_sp->bindValue(':nm_und_pagamento',$value["NM_UND_PAGAMENTO"]);
				$sql_sp->bindValue(':sg_und_pagamento',$value["SG_UND_PAGAMENTO"]);
				$sql_sp->bindValue(':Extensao_Total',$value["Extensao_Total"]);
				$sql_sp->bindValue(':Valor_Inicial',$value["Valor_Inicial"]);
				$sql_sp->bindValue(':Valor_Total_de_Aditivos',$value["Valor_Total_de_Aditivos"]);
				$sql_sp->bindValue(':Valor_Total_de_Reajuste',$value["Valor_Total_de_Reajuste"]);
				$sql_sp->bindValue(':Valor_Inicial_Adit_Reajustes',$value["Valor_Inicial_Adit_Reajustes"]);
				$sql_sp->bindValue(':Valor_Empenhado',$value["Valor_Empenhado"]);
				$sql_sp->bindValue(':Valor_Saldo',$value["Valor_Saldo"]);
				$sql_sp->bindValue(':Valor_Medicao_PI_R',$value["Valor_Medicao_PI_R"]);
				$sql_sp->bindValue(':Valor_PI_Medicao',$value["Valor_PI_Medicao"]);
				$sql_sp->bindValue(':Valor_Reajuste_Medicao',$value["Valor_Reajuste_Medicao"]);
				$sql_sp->bindValue(':Valor_Oficio_Pagamento',$value["Valor_Oficio_Pagamento"]);
				$sql_sp->bindValue(':num',$value["NU_CON_FORMATADO"]);
				$exception = $sql_sp->execute();
				$qtdUpdSup++;
			endforeach;

			if($exception){
				//$count = $sql_sp->rowCount();
				print("Update $qtdUpdSup rows CONFER_TB_CONTRATO_SUPERVISORA!<br/>");
			}
		} catch (PDOException $e) {
			print "Ocorreu um erro ao tentar executar esta ação -> Atualizar Contratos Supervisora.<br/>". $e->getMessage();

		}
//------------------------------------------------------------------------------------------------------------------------------------		
	try {	
		$isp_sql = connection::open('sindnit')->prepare("SELECT * FROM Dados_Contrato Where nu_con_formatado in $str_sp");
		$isp_sql->execute();

		$DadosContratoSupinst = $isp_sql->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação -> Select Simdnit.<br/>". $e->getMessage();
		die;
	}//-------------------------------------------------------------------
	$exceptisup = false;
		try {	
			$insert_sup = connection::open('supradif')->prepare( "INSERT INTO CONFER_TB_CONTRATO_SUPERVISAO ( nu_cnpj_cpf,sk_contrato,nu_con_formatado,sk_contrato_supervisor,nu_con_formatado_supervisor,dt_base,dt_corrente,dt_termino_vigencia,dt_aprovacao,dt_assinatura,dt_proposta,dt_publicacao,dt_inicio,dt_ter_atz,dt_ter_prv,sk_empresa,no_empresa,sk_empresa_supervisor,sg_empresa_supervisor,sk_fiscal,nm_fiscal,ds_grupo_intervencao,sk_modal,ds_modal,modalidade_licitacao,sk_municipio,no_municipio,co_municipio,no_municipio0,nu_edital,nu_lote_licitacao,nu_processo,ds_objeto,sk_programa,nm_programa,nu_dia_paralisacao,nu_dia_prorrogacao,sk_situacao_contrato,ds_fas_contrato,co_tip_contrato,ds_tip_contrato,sk_tipo_intervencao,ds_tip_intervencao,tipo_licitacao,descricao_br,sk_uf_unidade_local,sg_uf_unidade_local,co_uf,sg_uf,sk_unidade_fiscal,nm_und_fiscal,sg_und_fiscal,sk_unidade_gestora,nm_und_gestora,sg_und_gestora,sk_unidade_local,nm_und_local,sg_und_local,sk_unidade_pagamento,nm_und_pagamento,sg_und_pagamento,Extensao_Total,Valor_Inicial,Valor_Total_de_Aditivos,Valor_Total_de_Reajuste,Valor_Inicial_Adit_Reajustes,Valor_Empenhado,Valor_Saldo,Valor_Medicao_PI_R,Valor_PI_Medicao,Valor_Reajuste_Medicao,Valor_Oficio_Pagamento)  
				VALUES (:nu_cnpj_cpf,:sk_contrato,:nu_con_formatado,:sk_contrato_supervisor,:nu_con_formatado_supervisor,:dt_base,:dt_corrente,:dt_termino_vigencia,:dt_aprovacao,:dt_assinatura,:dt_proposta,:dt_publicacao,:dt_inicio,:dt_ter_atz,:dt_ter_prv,:sk_empresa,:no_empresa,:sk_empresa_supervisor,:sg_empresa_supervisor,:sk_fiscal,:nm_fiscal,:ds_grupo_intervencao,:sk_modal,:ds_modal,:modalidade_licitacao,:sk_municipio,:no_municipio,:co_municipio,:no_municipio0,:nu_edital,:nu_lote_licitacao,:nu_processo,:ds_objeto,:sk_programa,:nm_programa,:nu_dia_paralisacao,:nu_dia_prorrogacao,:sk_situacao_contrato,:ds_fas_contrato,:co_tip_contrato,:ds_tip_contrato,:sk_tipo_intervencao,:ds_tip_intervencao,:tipo_licitacao,:descricao_br,:sk_uf_unidade_local,:sg_uf_unidade_local,:co_uf,:sg_uf,:sk_unidade_fiscal,:nm_und_fiscal,:sg_und_fiscal,:sk_unidade_gestora,:nm_und_gestora,:sg_und_gestora,:sk_unidade_local,:nm_und_local,:sg_und_local,:sk_unidade_pagamento,:nm_und_pagamento,:sg_und_pagamento,:Extensao_Total,:Valor_Inicial,:Valor_Total_de_Aditivos,:Valor_Total_de_Reajuste,:Valor_Inicial_Adit_Reajustes,:Valor_Empenhado,:Valor_Saldo,:Valor_Medicao_PI_R,:Valor_PI_Medicao,:Valor_Reajuste_Medicao,:Valor_Oficio_Pagamento)" );
			$qtdInsSup = 0;
			if(!empty($DadosContratoSupinst)){	
			foreach ($DadosContratoSupinst as $value):
				$insert_sup->bindValue(':nu_cnpj_cpf', $value["NU_CNPJ_CPF"]);
				$insert_sup->bindValue(':sk_contrato',$value["SK_CONTRATO"]);
				$insert_sup->bindValue(':nu_con_formatado',$value["NU_CON_FORMATADO"]);
				$insert_sup->bindValue(':sk_contrato_supervisor',$value["SK_CONTRATO_SUPERVISOR"]);
				$insert_sup->bindValue(':nu_con_formatado_supervisor',$value["NU_CON_FORMATADO_SUPERVISOR"]);
				$insert_sup->bindValue(':dt_base',$value["DT_BASE"]);
				$insert_sup->bindValue(':dt_corrente',$value["DT_CORRENTE"]);
				$insert_sup->bindValue(':dt_termino_vigencia',$value["DT_TERMINO_VIGENCIA"]);
				$insert_sup->bindValue(':dt_aprovacao',$value["DT_APROVACAO"]);
				$insert_sup->bindValue(':dt_assinatura',$value["DT_ASSINATURA"]);
				$insert_sup->bindValue(':dt_proposta',$value["DT_PROPOSTA"]);
				$insert_sup->bindValue(':dt_publicacao',$value["DT_PUBLICACAO"]);
				$insert_sup->bindValue(':dt_inicio',$value["DT_INICIO"]);
				$insert_sup->bindValue(':dt_ter_atz',$value["DT_TER_ATZ"]);
				$insert_sup->bindValue(':dt_ter_prv',$value["DT_TER_PRV"]);
				$insert_sup->bindValue(':sk_empresa',$value["SK_EMPRESA"]);
				$insert_sup->bindValue(':no_empresa',$value["NO_EMPRESA"]);
				$insert_sup->bindValue(':sk_empresa_supervisor',$value["SK_EMPRESA_SUPERVISOR"]);
				$insert_sup->bindValue(':sg_empresa_supervisor',$value["SG_EMPRESA_SUPERVISOR"]);
				$insert_sup->bindValue(':sk_fiscal',$value["SK_FISCAL"]);
				$insert_sup->bindValue(':nm_fiscal',$value["NM_FISCAL"]);
				$insert_sup->bindValue(':ds_grupo_intervencao',$value["DS_GRUPO_INTERVENCAO"]);
				$insert_sup->bindValue(':sk_modal',$value["SK_MODAL"]);
				$insert_sup->bindValue(':ds_modal',$value["DS_MODAL"]);
				$insert_sup->bindValue(':modalidade_licitacao',$value["MODALIDADE_LICITACAO"]);
				$insert_sup->bindValue(':sk_municipio',$value["SK_MUNICIPIO"]);
				$insert_sup->bindValue(':no_municipio',$value["NO_MUNICIPIO"]);
				$insert_sup->bindValue(':co_municipio',$value["CO_MUNICIPIO"]);
				$insert_sup->bindValue(':no_municipio0',$value["NO_MUNICIPIO0"]);
				$insert_sup->bindValue(':nu_edital',$value["NU_EDITAL"]);
				$insert_sup->bindValue(':nu_lote_licitacao',$value["NU_LOTE_LICITACAO"]);
				$insert_sup->bindValue(':nu_processo',$value["NU_PROCESSO"]);
				$insert_sup->bindValue(':ds_objeto',$value["DS_OBJETO"]);
				$insert_sup->bindValue(':sk_programa',$value["SK_PROGRAMA"]);
				$insert_sup->bindValue(':nm_programa',$value["NM_PROGRAMA"]);
				$insert_sup->bindValue(':nu_dia_paralisacao',$value["NU_DIA_PARALISACAO"]);
				$insert_sup->bindValue(':nu_dia_prorrogacao',$value["NU_DIA_PRORROGACAO"]);
				$insert_sup->bindValue(':sk_situacao_contrato',$value["SK_SITUACAO_CONTRATO"]);
				$insert_sup->bindValue(':ds_fas_contrato',$value["DS_FAS_CONTRATO"]);
				$insert_sup->bindValue(':co_tip_contrato',$value["CO_TIP_CONTRATO"]);
				$insert_sup->bindValue(':ds_tip_contrato',$value["DS_TIP_CONTRATO"]);
				$insert_sup->bindValue(':sk_tipo_intervencao',$value["SK_TIPO_INTERVENCAO"]);
				$insert_sup->bindValue(':ds_tip_intervencao',$value["ds_tip_intervencao"]);
				$insert_sup->bindValue(':tipo_licitacao',$value["TIPO_LICITACAO"]);
				$insert_sup->bindValue(':descricao_br',$value["DESCRICAO_BR"]);
				$insert_sup->bindValue(':sk_uf_unidade_local',$value["SK_UF_UNIDADE_LOCAL"]);
				$insert_sup->bindValue(':sg_uf_unidade_local',$value["SG_UF_UNIDADE_LOCAL"]);
				$insert_sup->bindValue(':co_uf',$value["CO_UF"]);
				$insert_sup->bindValue(':sg_uf',$value["SG_UF"]);
				$insert_sup->bindValue(':sk_unidade_fiscal',$value["SK_UNIDADE_FISCAL"]);
				$insert_sup->bindValue(':nm_und_fiscal',$value["NM_UND_FISCAL"]);
				$insert_sup->bindValue(':sg_und_fiscal',$value["SG_UND_FISCAL"]);
				$insert_sup->bindValue(':sk_unidade_gestora',$value["SK_UNIDADE_GESTORA"]);
				$insert_sup->bindValue(':nm_und_gestora',$value["NM_UND_GESTORA"]);
				$insert_sup->bindValue(':sg_und_gestora',$value["SG_UND_GESTORA"]);
				$insert_sup->bindValue(':sk_unidade_local',$value["SK_UNIDADE_LOCAL"]);
				$insert_sup->bindValue(':nm_und_local',$value["NM_UND_LOCAL"]);
				$insert_sup->bindValue(':sg_und_local',$value["SG_UND_LOCAL"]);
				$insert_sup->bindValue(':sk_unidade_pagamento',$value["SK_UNIDADE_PAGAMENTO"]);
				$insert_sup->bindValue(':nm_und_pagamento',$value["NM_UND_PAGAMENTO"]);
				$insert_sup->bindValue(':sg_und_pagamento',$value["SG_UND_PAGAMENTO"]);
				$insert_sup->bindValue(':Extensao_Total',$value["Extensao_Total"]);
				$insert_sup->bindValue(':Valor_Inicial',$value["Valor_Inicial"]);
				$insert_sup->bindValue(':Valor_Total_de_Aditivos',$value["Valor_Total_de_Aditivos"]);
				$insert_sup->bindValue(':Valor_Total_de_Reajuste',$value["Valor_Total_de_Reajuste"]);
				$insert_sup->bindValue(':Valor_Inicial_Adit_Reajustes',$value["Valor_Inicial_Adit_Reajustes"]);
				$insert_sup->bindValue(':Valor_Empenhado',$value["Valor_Empenhado"]);
				$insert_sup->bindValue(':Valor_Saldo',$value["Valor_Saldo"]);
				$insert_sup->bindValue(':Valor_Medicao_PI_R',$value["Valor_Medicao_PI_R"]);
				$insert_sup->bindValue(':Valor_PI_Medicao',$value["Valor_PI_Medicao"]);
				$insert_sup->bindValue(':Valor_Reajuste_Medicao',$value["Valor_Reajuste_Medicao"]);
				$insert_sup->bindValue(':Valor_Oficio_Pagamento',$value["Valor_Oficio_Pagamento"]);
				$exceptisup = $insert_sup->execute();
				$qtdInsSup++;
			endforeach;
			}
				if($exceptisup){
					//$count = $insert_sup->rowCount();
					print("Insert $qtdInsSup rows CONFER_TB_CONTRATO_SUPERVISORA!<br/>");
				}
		} catch (PDOException $e) {
			print "Ocorreu um erro ao tentar executar esta ação -> Inserir Contratos Supervisao.<br/>". $e->getMessage();

		}
//-----------------------------------------------------------------------------------------------------------------------------		
	try {		
		$dlt_sql = connection::open('supradif')->prepare( "DELETE FROM CONFER_TB_SIAC_MEDICAO_MAIOR " );
		$exception = $dlt_sql->execute();

		if($exception){

			print("Sucesss!!");
		}

	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação.<br/>". $e->getMessage();
		die;
	}

	try {	
		$pl_sql = connection::open('sindnit')->prepare("SELECT NU_CON_FORMATADO, NU_MEDICAO, DT_TERMINO_MEDICAO, DT_PROCESSAMENTO_MEDICAO, VLR_MEDICAO_PI, VLR_REAJUSTE_MEDICAO FROM Dados_Medicao WHERE NU_CON_FORMATADO in $me_values ");
		$exception = $pl_sql->execute();

		$medicao_sindnit = $pl_sql->fetchAll(PDO::FETCH_ASSOC);

		if($exception){
			$count = $pl_sql->rowCount();
			print(" Medição $count rows extraida Simdnit -> Sucess!<br/>");
		}

	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação -> Select Medições.<br/>". $e->getMessage();
		die;
	}

	try {
		$insert_sql = connection::open('supradif')->prepare( "INSERT INTO CONFER_TB_SIAC_MEDICAO_MAIOR (contrato
			,nume_medicao
			,data_termino_medicao
			,data_processamento_medicao
			,valor_pi_medicao
			,valor_reajuste_medicao
		) VALUES (:contrato, :nume_medicao, :data_termino_medicao, :data_processamento_medicao, :valor_pi_medicao, :valor_reajuste_medicao)" );
		$qtdInsMed = 0;
		foreach ($medicao_sindnit as $value):
			$insert_sql->bindValue(':contrato',$value["NU_CON_FORMATADO"]);
			$insert_sql->bindValue(':nume_medicao',$value["NU_MEDICAO"]);
			$insert_sql->bindValue(':data_termino_medicao',$value["DT_TERMINO_MEDICAO"]);
			$insert_sql->bindValue(':data_processamento_medicao',$value["DT_PROCESSAMENTO_MEDICAO"]);
			$insert_sql->bindValue(':valor_pi_medicao',$value["VLR_MEDICAO_PI"]);
			$insert_sql->bindValue(':valor_reajuste_medicao',$value["VLR_REAJUSTE_MEDICAO"]);
			$exceptiond = $insert_sql->execute();
			$qtdInsMed++;
		endforeach;

		if($exceptiond){

			//$count = $insert_sql->rowCount();
			print("Insert $qtdInsMed rows CONFER_TB_MEDICAO_OBRA!<br/>");
		}

	} catch (PDOException $e) {
		print "Ocorreu um erro ao tentar executar esta ação -> Inserir Medições.<br/>". $e->getMessage();
		die;
	}

		
//-------------------------------------------------------------------
?>
