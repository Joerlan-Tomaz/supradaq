<?php

class ConsultaContratoSIACModel extends CI_Model {

    private $db2;

    function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('CGPERT', TRUE);
    }

    public function consultaContratoSIAC($dados) {

        $this->db2->query('SET ANSI_NULLS ON;');
        $this->db2->query('SET ANSI_WARNINGS ON;');

        $this->db2->select("*");
        $this->db2->like("NU_CON_FORMATADO", $dados['contrato']);
        $this->db2->from("view_SIAC_DadosContratos");
        $query = $this->db2->get();

        return $query->result();
    }

    public function consultaContratoSIAC_SK_CONTRATO($dados) {


        $SQL = " SELECT [NU_CNPJ_CPF]
                ,[SK_CONTRATO]
                ,[NU_CON_FORMATADO]
                ,[SK_CONTRATO_SUPERVISOR]
                ,[NU_CON_FORMATADO_SUPERVISOR]
                ,[DT_BASE]
                ,[DT_CORRENTE]
                ,[DT_TERMINO_VIGENCIA]
                ,[DT_APROVACAO]
                ,[DT_ASSINATURA]
                ,[DT_PROPOSTA]
                ,[DT_PUBLICACAO]
                ,DT_INICIO = convert(varchar(10),DT_INICIO, 103)
                ,DT_TER_ATZ = convert(varchar(10),DT_TER_ATZ, 103)
                ,[DT_TER_PRV]
                ,[SK_EMPRESA]
                ,[NO_EMPRESA]
                ,[SK_EMPRESA_SUPERVISOR]
                ,[SG_EMPRESA_SUPERVISOR]
                ,[SK_FISCAL]
                ,[NM_FISCAL]
                ,[SK_MODAL]
                ,[DS_MODAL]
                ,[MODALIDADE_LICITACAO]
                ,[NU_EDITAL]
                ,[NU_LOTE_LICITACAO]
                ,[NU_PROCESSO]
                ,[DS_OBJETO]
                ,[SK_PROGRAMA]
                ,[NM_PROGRAMA]
                ,[NU_DIA_PARALISACAO]
                ,[NU_DIA_PRORROGACAO]
                ,[SK_SITUACAO_CONTRATO]
                ,[DS_FAS_CONTRATO]
                ,[CO_TIP_CONTRATO]
                ,[DS_TIP_CONTRATO]
                ,[SK_TIPO_INTERVENCAO]
                ,[ds_tip_intervencao]
                ,[TIPO_LICITACAO]
                ,[DESCRICAO_BR]
                ,[SK_UF_UNIDADE_LOCAL]
                ,[SG_UF_UNIDADE_LOCAL]
                ,[SK_UNIDADE_GESTORA]
                ,[NM_UND_GESTORA]
                ,[SG_UND_GESTORA]
                ,[SK_UNIDADE_LOCAL]
                ,[NM_UND_LOCAL]
                ,[SG_UND_LOCAL]
                ,[Extensao_Total]
                ,[Valor_Inicial]
                ,[Valor_Total_de_Aditivos]
                ,[Valor_Total_de_Reajuste]
                ,[Valor_Inicial_Adit_Rejustes]
                ,[Valor_Empenhado]
                ,[Valor_Saldo]
                ,[Valor_Medicao_PI_R]
                ,[Valor_PI_Medicao]
                ,[Valor_Reajuste_Medicao]
                ,[Valor_Oficio_Pagamento]
                ,PIR = format(PIR,'C','pt-br')
                ,PIV = format(PIV,'C','pt-br')
                FROM view_SIAC_DadosContratos_SK_Contrato where SK_CONTRATO = {$dados['contrato']} ";
        
        $this->db2->query('SET ANSI_NULLS ON;');
        $this->db2->query('SET ANSI_WARNINGS ON;');
        $query = $this->db2->query($SQL);

        return $query->result();
    }

}

?>