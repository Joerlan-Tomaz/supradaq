<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_apresentacao_construtora extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


	//---------------------------------------------------------------------------------------
    public function RecuperaApresentacao($dados) {
          $SQL = "
            SELECT 
                c.id_contrato_obra, 
                c.nu_con_formatado as contrato, 
                c.no_empresa as nome_empresa,
                c.nu_processo as processo_adm, 
                c.ds_objeto as objeto,
                (CONVERT(CHAR(10),(CAST(c.dt_base AS DATE)),103))as data_base,
                c.sg_uf_unidade_local as localizacao,
                (CONVERT(CHAR(10),(CAST(c.dt_assinatura AS DATE)),103))as data_ass,
                (CONVERT(CHAR(10),(CAST(c.dt_inicio AS DATE)),103))as ordem_inicial,
                c.co_municipio as prazo_inicial,
                (CONVERT(CHAR(10),(CAST(c.dt_ter_prv AS DATE)),103))as data_inicial_term,
                c.nu_dia_prorrogacao as dias_aditados, 
                c.nu_dia_paralisacao as total_paralisados,
                (CONVERT(CHAR(10),(CAST(c.dt_ter_atz AS DATE)),103))as dt_termino_atualizada,
                c.Valor_Inicial as valor_pi_contrato, 
                c.Valor_Total_de_Aditivos as valor_total_aditado, 
                c.Valor_Total_de_Reajuste as valor_reajuste, 
                c.Valor_Inicial_Adit_Reajustes valor_atz_pir,
                (SELECT  convert(varchar(10),data_publi_dou,103) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA 
                WHERE id_apresentacao = (SELECT MAX(id_apresentacao) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA) AND id_contrato_obra = ".$dados['id_contrato_obra'].") publi_dou,
                (SELECT  convert(varchar(10),data_publi_dou_result,103) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA 
                WHERE id_apresentacao = (SELECT MAX(id_apresentacao) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA) AND id_contrato_obra = ".$dados['id_contrato_obra'].") publi_result
            FROM CGOB_TB_CONTRATO_OBRA AS c
            WHERE c.id_contrato_obra= ". $dados['id_contrato_obra']."
            ";

            $query = $this->db->query($SQL);
            return $query->result();
    }

        public function RecuperaApresentacaoConstrutora($dados) {
        $SQL = "
        SELECT  
        cs.nu_con_formatado as contrato,
        CASE WHEN (ca.nome_empresa is null or ca.nome_empresa like '') THEN
            cs.NO_EMPRESA 
            ELSE ca.nome_empresa
        END as nome_empresa,
        CASE WHEN (ca.num_processo_adm is null or ca.num_processo_adm like '') THEN
            cs.NU_PROCESSO 
            ELSE ca.num_processo_adm
        END as processo_adm,
        CASE WHEN (ca.objeto is null or ca.objeto like '') THEN
            cs.DS_OBJETO 
            ELSE ca.objeto
        END as objeto,
        CASE WHEN (ca.data_base is null or ca.data_base like '') THEN
            (CONVERT(CHAR(10),(CAST(cs.DT_BASE AS DATE)),103))
            ELSE (CONVERT(CHAR(10),(CAST(ca.data_base AS DATE)),103))
        END as data_base,
        CASE WHEN (ca.localizacao is null or ca.localizacao like '') THEN
            cs.SG_UND_LOCAL 
            ELSE ca.localizacao 
        END as localizacao,
        CASE WHEN (ca.data_assinatura is null or ca.data_assinatura like '') THEN
            (CONVERT(CHAR(10),(CAST(cs.DT_ASSINATURA AS DATE)),103))
            ELSE (CONVERT(CHAR(10),(CAST(ca.data_assinatura AS DATE)),103))
        END as data_ass,
        CASE WHEN (ca.ordem_inicio_servicos is null or ca.ordem_inicio_servicos like '') THEN
            (CONVERT(CHAR(10),(CAST(cs.DT_INICIO AS DATE)),103))
            ELSE (CONVERT(CHAR(10),(CAST(ca.ordem_inicio_servicos AS DATE)),103))
        END as ordem_inicial,
        CASE WHEN (ca.prazo_inicial_execucao is null or ca.prazo_inicial_execucao like '') THEN
            cs.NU_DIA_PRORROGACAO 
            ELSE ca.prazo_inicial_execucao 
        END as prazo_inicial,
        CASE WHEN (ca.data_inicial_termino is null or ca.data_inicial_termino like '') THEN
            (CONVERT(CHAR(10),(CAST(cs.DT_ASSINATURA AS DATE)),103))
            ELSE (CONVERT(CHAR(10),(CAST(ca.data_inicial_termino AS DATE)),103))
        END as data_inicial_term,
        CASE WHEN (ca.total_dias_aditados is null or ca.total_dias_aditados like '') THEN
            cs.NU_DIA_PRORROGACAO 
            ELSE ca.total_dias_aditados
        END as dias_aditados,
        CASE WHEN (ca.total_dias_paralisados is null or ca.total_dias_paralisados like '') THEN
            cs.NU_DIA_PARALISACAO 
            ELSE ca.total_dias_paralisados
        END as total_paralisados,
        CASE WHEN (ca.data_term_atualizada is null or ca.data_term_atualizada like '') THEN
            (CONVERT(CHAR(10),(CAST(cs.DT_TER_ATZ AS DATE)),103))
            ELSE (CONVERT(CHAR(10),(CAST(ca.data_term_atualizada AS DATE)),103))
        END as dt_termino_atualizada,
        CASE WHEN (ca.valor_pi_contrato is null or ca.valor_pi_contrato like '') THEN
            cs.Valor_Inicial 
            ELSE ca.valor_pi_contrato
        END as valor_pi_contrato,
        CASE WHEN (ca.valor_total_aditado is null or ca.valor_total_aditado like '') THEN
            cs.Valor_Total_de_Aditivos 
            ELSE ca.valor_total_aditado
        END as valor_total_aditado,
        CASE WHEN (ca.valor_reajuste_contrato is null or ca.valor_reajuste_contrato like '') THEN
            cs.Valor_Total_de_Reajuste 
            ELSE ca.valor_reajuste_contrato
        END as valor_reajuste,
        CASE WHEN (ca.valor_atualizado is null or ca.valor_atualizado like '') THEN
            cs.Valor_Inicial_Adit_Reajustes 
            ELSE ca.valor_atualizado
        END as valor_atz_pir,
        CASE WHEN (ca.data_publi_dou is null or ca.data_publi_dou like '') THEN
            ' - - '
            ELSE convert(varchar(10),ca.data_publi_dou,103) 
        END as publi_dou,
        CASE WHEN (ca.data_publi_dou_result is null or ca.data_publi_dou_result like '') THEN
            ' - - '
            ELSE convert(varchar(10),ca.data_publi_dou_result,103)
        END as publi_result
            FROM Dados_Contrato AS cs
            INNER JOIN CGOB_TB_CONTRATO_OBRA AS co ON co.nu_con_formatado = cs.NU_CON_FORMATADO
            FULL OUTER JOIN  CGOB_TB_APRESENTACAO_CONSTRUTORA AS ca ON 
                 ca.id_apresentacao = (SELECT MAX(id_apresentacao) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA WHERE id_contrato_obra = ".$dados['id_contrato_obra'].") 
                WHERE co.id_contrato_obra= ". $dados['id_contrato_obra']."
            ";
      // echo('<pre>');
      // die($SQL);
      $query = $this->db->query($SQL);
      return $query->result();
    }


    public function RecuperaApresentacaoConstrutoral($dados) {
          $SQL = "
                SELECT 
                co.id_contrato_obra, 
                co.nu_con_formatado as contrato, 
                c.nome_empresa as nome_empresa,
                c.num_processo_adm as processo_adm, 
                c.objeto as objeto,
                (CONVERT(CHAR(10),(CAST(c.data_base AS DATE)),103))as data_base,
                c.localizacao as localizacao,
                (CONVERT(CHAR(10),(CAST(c.data_assinatura AS DATE)),103))as data_ass,
                (CONVERT(CHAR(10),(CAST(c.ordem_inicio_servicos AS DATE)),103))as ordem_inicial,
                (CONVERT(CHAR(10),(CAST(c.prazo_inicial_execucao AS DATE)),103))as prazo_inicial,
                (CONVERT(CHAR(10),(CAST(c.data_inicial_termino AS DATE)),103))as data_inicial_term,
                c.total_dias_aditados as dias_aditados, 
                c.total_dias_paralisados as total_paralisados,
                (CONVERT(CHAR(10),(CAST(c.data_term_atualizada AS DATE)),103))as dt_termino_atualizada,
                c.valor_pi_contrato as valor_pi_contrato, 
                c.valor_total_aditado as valor_total_aditado, 
                c.valor_reajuste_contrato as valor_reajuste, 
                c.valor_atualizado valor_atz_pir,
                convert(varchar(10),c.data_publi_dou,103) as publi_dou,
                convert(varchar(10),c.data_publi_dou_result,103) publi_result
            
            FROM CGOB_TB_CONTRATO_OBRA AS co
            FULL OUTER JOIN  CGOB_TB_APRESENTACAO_CONSTRUTORA AS c ON co.id_contrato_obra = c.id_contrato_obra AND
                 c.id_apresentacao = (SELECT MAX(id_apresentacao) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA WHERE id_contrato_obra = ".$dados['id_contrato_obra'].") 
                WHERE co.id_contrato_obra=". $dados['id_contrato_obra']."
            ";
        
            $query = $this->db->query($SQL);
        return $query->result();
    }
    //---------------------------------------------------------------------------------------
    public function insereApresentacaoconstrutora($dados) {
            date_default_timezone_set("America/Sao_Paulo");
            $this->db->set("id_contrato_obra", $dados["idContrato"]);
            $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
            $this->db->set("id_usuario", $dados["idUsuario"]);

            if ($dados['data_base'] != '1969-12-31') {
            $this->db->set("data_base", $dados["data_base"]);
            }
            if (!empty($dados["nome_empresa"])) {
            $this->db->set("nome_empresa", $dados["nome_empresa"]);
            }
            if (!empty($dados["num_processo_adm"])) {
            $this->db->set("num_processo_adm", $dados["num_processo_adm"]);
            }
            if (!empty($dados["objeto"])) {
            $this->db->set("objeto", $dados["objeto"]);
            }
            if ($dados['data_assinatura'] != '1969-12-31') {
            $this->db->set("data_assinatura", $dados["data_assinatura"]);
            }
            if ($dados['ordem_inicio_servicos'] != '1969-12-31') {
            $this->db->set("ordem_inicio_servicos", $dados["ordem_inicio_servicos"]);
            }
            if ($dados['prazo_inicial_execucao'] != '1969-12-31') {
            $this->db->set("prazo_inicial_execucao", $dados["prazo_inicial_execucao"]);
            }
            if ($dados['data_inicial_termino'] != '1969-12-31') {
            $this->db->set("data_inicial_termino", $dados["data_inicial_termino"]);
            }
            if ($dados['data_term_atualizada'] != '1969-12-31') {
            $this->db->set("data_term_atualizada", $dados["data_term_atualizada"]);
            }
            if ($dados['data_publi_dou'] != '1969-12-31') {
            $this->db->set("data_publi_dou", $dados["data_publi_dou"]);
            }
            if ($dados['data_publi_dou_result'] != '1969-12-31') {
            $this->db->set("data_publi_dou_result", $dados["data_publi_dou_result"]);
            }
            if (!empty($dados["total_dias_aditados"])) {
            $this->db->set("total_dias_aditados", $dados["total_dias_aditados"]);
            }
            if (!empty($dados["total_dias_paralisados"])) {
            $this->db->set("total_dias_paralisados", $dados["total_dias_paralisados"]);
            }
             if (!empty($dados["valor_pi_contrato"])) {
            $this->db->set("valor_pi_contrato", $dados["valor_pi_contrato"]);
            }
             if (!empty($dados["valor_total_aditado"])) {
            $this->db->set("valor_total_aditado", $dados["valor_total_aditado"]);
            }
             if (!empty($dados["valor_reajuste_contrato"])) {
            $this->db->set("valor_reajuste_contrato", $dados["valor_reajuste_contrato"]);
            }
             if (!empty($dados["valor_atualizado"])) {
            $this->db->set("valor_atualizado", $dados["valor_atualizado"]);
            }

            $this->db->set("publicar", "S");
            $this->db->set("periodo_referencia", $dados["periodo"]);
            $this->db->insert("CGOB_TB_APRESENTACAO_CONSTRUTORA");
            $this->db->trans_complete();
            if ($this->db->trans_status() === true) {
                $this->db->trans_commit();
                return $this->db->insert_id();
            } else {
                $this->db->trans_rollback();
                return false;
            }
     }

 //-----------------------------------------------------------------------------------------------
    public function recuperaPortariasFiscaisp($dados){
        $SQL = "
        SELECT
            uf.estado,
            pf.nome_fiscal,
            pf.email, 
            pf.telefone, 
            tit.titularidade,
            CASE
            WHEN pf.publicar = 'N' THEN 'Não Vigente'
            WHEN pf.publicar = 'S' THEN 'Vigente'
            END as publicar
        FROM CGOB_TB_PORTARIA_FISCAIS AS pf
        INNER JOIN CGOB_TB_UF AS uf ON uf.id_uf = pf.id_uf
        INNER JOIN CGOB_TB_TITULARIDADE AS tit ON tit.id_titularidade = pf.id_titularidade
        WHERE pf.id_contrato_obra = " . $dados["idContrato"] . "
        AND (pf.publicar = 'S' or pf.publicar is NULL)
        AND pf.contrato_fiscalizado = '" . $dados["contrato_fiscalizado"] . " '
        ";

         $SQL .= " ORDER BY pf.ultima_alteracao DESC";

        $query = $this->db->query($SQL);
        return $query->result();
    }
 //-----------------------------------------------------------------------------------------------
    public function recuperaPortariasFiscais($dados){
        $SQL = "
        SELECT
            uf.estado,
            pf.nome_fiscal,
            pf.email, 
            pf.telefone, 
            tit.titularidade,
            CASE
            WHEN pf.publicar = 'N' THEN 'Não Vigente'
            WHEN pf.publicar = 'S' THEN 'Vigente'
            END as publicar
        FROM CGOB_TB_PORTARIA_FISCAIS AS pf
        INNER JOIN CGOB_TB_UF AS uf ON uf.id_uf = pf.id_uf
        INNER JOIN CGOB_TB_TITULARIDADE AS tit ON tit.id_titularidade = pf.id_titularidade
        WHERE pf.id_contrato_obra = " . $dados["idContrato"] . "
        AND (pf.publicar = 'S' or pf.publicar is NULL)
        AND pf.contrato_fiscalizado = '" . $dados["contrato_fiscalizado"] . " '
        ";

         $SQL .= " ORDER BY pf.ultima_alteracao DESC";

        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function recuperaSelectHidrovia(){
        $SQL = "SELECT hidrovia FROM CGOB_TB_HIDROVIAS";
        $query = $this->db->query($SQL);
        return $query->result();
    }











}//fechaclass
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 13/01/2019 13:00
//########################################################################################################################################################################################################################
