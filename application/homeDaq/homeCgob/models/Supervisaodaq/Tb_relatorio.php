<?php
/*
 * Classe model Tb_relatorio. 
 * @author Jordana de Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage model 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_relatorio extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }


//------------------------------------------GERAR RELATORIO--------------------------------------------
    public function DadosContratoDaq($dados) {
        $SQL = "
        SELECT  
        co.nu_con_formatado as numero_contrato,
        co.no_empresa as empresa_obra,
         CASE WHEN (cs.nu_con_formatado is null or cs.nu_con_formatado like '') THEN
                    '- - '
                    ELSE cs.nu_con_formatado
                END as nu_contrato_super,

        CASE WHEN (cs.no_empresa is null or cs.no_empresa like '') THEN
                    '- - '
                    ELSE cs.no_empresa
                END as empresa_super,
        co.Valor_Inicial_Adit_Reajustes
        FROM CGOB_TB_CONTRATO_OBRA AS co
        full outer join CGOB_TB_CONTRATO_SUPERVISORA as cs ON co.nu_con_formatado_supervisor = cs.nu_con_formatado
        WHERE co.id_contrato_obra = ".$dados["id_contrato_obra"]."
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    public function dadoslocalizacao($dados) {
        $SQL = "
          SELECT
           CASE WHEN (l.hidrovia is null or l.hidrovia like '') THEN
             '--' 
            ELSE l.hidrovia
            END as hidrovia_capa,
            CASE WHEN (l.km_final is null or l.km_final like '') THEN
             '--' 
            ELSE l.km_final
            END as municipio_capa,
            CASE WHEN (l.extensao is null or l.extensao like '') THEN
             '--' 
            ELSE l.extensao
            END as extensao_capa
            FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO AS l
        WHERE (l.publicar like '%S%' or l.publicar is NULL) AND l.id_localizacao = (SELECT MAX(id_localizacao) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO  where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."') 
        ";

        $query = $this->db->query($SQL);
        return $query->result_array();
    }


    public function DadoTermoEncerramento($dados){
        $SQL = "
        SELECT
            relatorio_supervisao
            FROM CGOB_TB_TERMO_ENCERRAMENTO 
            WHERE  id_termo = (SELECT MAX(id_termo) FROM CGOB_TB_TERMO_ENCERRAMENTO  where publicar like '%S%' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."') 
       
        ";
       
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//-----------------------------------------------------------------------------------
    public function finalizar_Relatorio($dados) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->db->set("id_contrato_obra", $dados["id_contrato_obra"]);
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("id_aceite", "aguardando análise");
        $this->db->set("roteiro_analise", "fechar_relatorio");
        $this->db->set("perfil", $dados["id_perfil_analise"]);      
        $this->db->set("publicar", "S");
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_HISTORICO_RELATORIO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            //return $this->db->insert_id();;
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-----------------------------------------------------------------------------------
    public function JustificativaDeEmpreendimentoperiodo($dados) {
        $SQL = "
        SELECT 
           resumo as resumo_justificativa
           FROM CGOB_TB_RESUMO 
        WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('14') AND publicar = 'S' 
        AND id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND id_roteiro in ('14')) 
            ";

        if (!empty($dados["periodo"])) {
            $SQL .= " AND periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//-----------------------------------------------------------------------------------
    public function JustificativaDeEmpreendimento($dados) {
        $SQL = "
        SELECT 
           resumo as resumo_justificativa
           FROM CGOB_TB_RESUMO 
        WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('14') AND publicar = 'S' 
        AND id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND id_roteiro in ('14')) 
            ";

        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//----------------------------------------------------------------------------------
    public function mapasituacaoperiodo($dados) {
        $SQL = "
          SELECT
            nome_arquivo as mapa_situacao
            FROM CGOB_TB_ARQUIVO 
            WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND roteiro in ('15') AND publicar = 'S' AND id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO  where publicar = 'S'AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' AND roteiro in ('15')) 
            ";
    
        if (!empty($dados["periodo"])) {
            $SQL .= " AND periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//----------------------------------------------------------------------------------
    public function mapasituacao($dados) {
        $SQL = "
          SELECT
            nome_arquivo as mapa_situacao
            FROM CGOB_TB_ARQUIVO 
            WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND roteiro in ('15') AND publicar = 'S' AND id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO  where publicar = 'S'AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' AND roteiro in ('15')) 
            ";
    
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//-----------------------------------------------------------------------------------
    public function resumoprojeto($dados) {
        $SQL = "
        SELECT id_tipo_pavimento as tipo_resumo, 
        max(resumo) as resumo_projeto 
        FROM CGOB_TB_RESUMO WHERE 
        publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND id_roteiro in ('3') 
        
        group by id_tipo_pavimento
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }


    public function resumoRpfoperiodo($dados) {
        $SQL = "
        SELECT desc_motivacao as resumo_rpfo
        FROM CGOB_TB_RPFO 
        WHERE 
        id_rpfo = (SELECT MAX(id_rpfo) FROM CGOB_TB_RPFO  
        where publicar = 'S'AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."')
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    public function resumoRpfo($dados) {
        $SQL = "
        SELECT desc_motivacao as resumo_rpfo
        FROM CGOB_TB_RPFO 
        WHERE 
        id_rpfo = (SELECT MAX(id_rpfo) FROM CGOB_TB_RPFO  
        where publicar = 'S'AND id_contrato_obra = ". $dados["id_contrato_obra"] ." )
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    public function diagramaOcorrenciaperiodo($dados) {
        $SQL = "
          SELECT
            nome_arquivo as diagrama_ocorrencia_pp
            FROM CGOB_TB_ARQUIVO 
            WHERE id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO  where publicar = 'S'AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' AND roteiro in ('16')) 
            ";
    
        if (!empty($dados["periodo"])) {
            $SQL .= " AND periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    public function diagramaOcorrencia($dados) {
        $SQL_old_21122021_0934 = "
          SELECT
            nome_arquivo as diagrama_ocorrencia_pp
            FROM CGOB_TB_ARQUIVO 
            WHERE id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO  where publicar = 'S'AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' AND roteiro in ('16')) 
            ";
        $SQL = "
          SELECT
            nome_arquivo as diagrama_ocorrencia_pp
            FROM CGOB_TB_ARQUIVO 
            WHERE  publicar = 'S'AND id_contrato_obra = '". $dados["id_contrato_obra"] ."' AND roteiro in ('16') 
            ";
        //echo('<pre>');
        //die($SQL);
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    public function historicoObra($dados) {
        $SQL = "
        SELECT 
        resumo as historico_obra 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND id_roteiro in ('1'))    
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    public function introducaoObra($dados) {
        $SQL = "
        SELECT 
        resumo as introducao_obra 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('2'))      
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//-------------------------------------------------------------------------------------------------------
    public function AndamentoanaliseDaq($dados) {
        $SQL = "
        SELECT 
            id_aceite,
            roteiro_analise,
            perfil 
        FROM CGOB_TB_HISTORICO_RELATORIO
              WHERE id_relatorio_edit = (SELECT MAX(id_relatorio_edit) FROM CGOB_TB_HISTORICO_RELATORIO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."') 
      ";
      //echo('<pre>');
      //die($SQL);
      $query = $this->db->query($SQL);
      return $query->result();
    }

    //-------------------------------------------------------------------------------------------------------
    public function AndamentoDaq($dados) {
        $SQL = "
        SELECT 
            id_aceite,
            perfil 
        FROM CGOB_TB_HISTORICO_RELATORIO
              WHERE publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."'
      and id_aceite in('aprovado') and 
              perfil in('2','3')
      ";
      //echo('<pre>');
      //die($SQL);
      $query = $this->db->query($SQL);
      return $query->result_array();
    }

// public function RecuperarelacaosupervisoraSicroTESTE($dados) {
//         $SQL = "
//           SELECT
//             sr.id_sicro_quantidade_sr as id,
//             s.cod_sicro,
//             s.item,
//             s.tipo,
//             sr.qtd_proprio,
//             sr.qtd_terceiro,
//             COALESCE(sr.qtd_proprio,0) + COALESCE(sr.qtd_terceiro,0) as total_mes,
//             concat( CONVERT(CHAR(10),sr.ultima_alteracao , 103),' ', CONVERT(CHAR(8),sr.ultima_alteracao , 114)) AS ultima_alteracao,
//             u.DESC_NOME as nome
//             FROM CGOB_TB_SICRO AS s
//             INNER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro = sr.id_sicro
//             INNER JOIN TB_USUARIO AS u ON u.id_usuario = sr.id_usuario
           
//         WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%PESSOAL DE OBRA%'  AND sr.periodo_referencia = '" . $dados["periodo"] . "' AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
   
// UNION

//           SELECT
//             sr.id_sicro_quantidade_sr as id,
//             s.cod_sicro,
//             s.item,
//             s.tipo,
//             sr.qtd_proprio,
//             sr.qtd_terceiro,
//             COALESCE(sr.qtd_proprio,0) + COALESCE(sr.qtd_terceiro,0) as total_mes,
//             concat( CONVERT(CHAR(10),sr.ultima_alteracao , 103),' ', CONVERT(CHAR(8),sr.ultima_alteracao , 114)) AS ultima_alteracao,
//             u.DESC_NOME as nome
//             FROM CGOB_TB_SICRO AS s
//             INNER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro = sr.id_sicro
//             INNER JOIN TB_USUARIO AS u ON u.id_usuario = sr.id_usuario
           
//         WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%PESSOAL DE OBRA%' AND sr.periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        
//         ";

// die($SQL);     
//         $query = $this->db->query($SQL);
//         return $query->result();
//     }

//     public function Mobilizacao_SICRO_Supervisora_Pessoal($dados) {
//         $SQL = "
//           SELECT
//             sr.id_sicro_quantidade_sr as id,
//             s.cod_sicro,
//             s.item,
//             s.tipo,
//             sr.periodo_referencia,
//             CASE
//                 WHEN sr.periodo_referencia =  dateadd(m,-1,'" . $dados["periodo"] . "') THEN sr.qtd_proprio END qtd_proprio_anterior,
//             CASE
//                 WHEN sr.periodo_referencia =  dateadd(m,-1,'" . $dados["periodo"] . "') THEN sr.qtd_terceiro END qtd_terceiro_anterior,
//             CASE
//                 WHEN sr.periodo_referencia =  dateadd(m,-1,'" . $dados["periodo"] . "') THEN COALESCE(sr.qtd_proprio,0) + COALESCE(sr.qtd_terceiro,0) END total_anterior,
//             CASE 
//                 WHEN sr.periodo_referencia = '" . $dados["periodo"] . "' THEN  sr.qtd_proprio END qtd_proprio_atual,
//             CASE 
//                 WHEN sr.periodo_referencia = '" . $dados["periodo"] . "' THEN  sr.qtd_terceiro END qtd_terceiro_atual,
//             CASE 
//                 WHEN sr.periodo_referencia = '" . $dados["periodo"] . "' THEN  COALESCE(sr.qtd_proprio,0) + COALESCE(sr.qtd_terceiro,0) END total_atual,
            
//             concat( CONVERT(CHAR(10),sr.ultima_alteracao , 103),' ', CONVERT(CHAR(8),sr.ultima_alteracao , 114)) AS ultima_alteracao,
//             u.DESC_NOME as nome
//             FROM CGOB_TB_SICRO AS s
//             INNER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro = sr.id_sicro
//             INNER JOIN TB_USUARIO AS u ON u.id_usuario = sr.id_usuario
           
//         WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%PESSOAL DE OBRA%'  AND (sr.periodo_referencia = '" . $dados["periodo"] . "' OR sr.periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')) AND sr.id_contrato_obra =  ". $dados["id_contrato_obra"] ."
   
//         ";

// die($SQL);
//         $query = $this->db->query($SQL);
//         return $query->result();
//     }
//---------------------------------------------7.2 RELAÇÃO DE MOBILIZAÇÃO DA SUPERVISORA -----------------------------------------------------
public function Mobilizacao_SICRO_Supervisora_Pessoal($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora)  total_atual
        FROM CGOB_TB_SICRO_RELACAO_SR AS s 

        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro_supervisora = sr.id_sicro_supervisora 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%PESSOAL DE OBRA%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_supervisora
        ";

        $query = $this->db->query($SQL);
        return $query->result();
    }

public function Mobilizacao_SICRO_SUpervisora_Equipamento($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora)  total_atual
        FROM CGOB_TB_SICRO_RELACAO_SR AS s 

        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro_supervisora = sr.id_sicro_supervisora 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%EQUIPAMENTO%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_supervisora
        ";

        $query = $this->db->query($SQL);
        return $query->result();
    }

public function Mobilizacao_SICRO_SUpervisora_Materiais($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora)  total_atual
        FROM CGOB_TB_SICRO_RELACAO_SR AS s 

        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro_supervisora = sr.id_sicro_supervisora 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%MATERIAIS%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_supervisora
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

public function Mobilizacao_SICRO_SUpervisora_Atividade_Auxiliares($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_supervisora = s.id_sicro_supervisora)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE_SR WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_supervisora = s.id_sicro_supervisora)  total_atual
        FROM CGOB_TB_SICRO_RELACAO_SR AS s 

        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE_SR AS sr ON s.id_sicro_supervisora = sr.id_sicro_supervisora 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%ATIVIDADES AUXILIARES%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_supervisora
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//---------------------------------------------RELAÇÃO DE MOBILIZAÇÃO DA SUPERVISORA AQUAVIARIO-------------------------------------------------
    
public function AtividadeSupervisora($dados) {
    $SQL = "
    SELECT 
    resumo as atividade_supervisora 
    FROM CGOB_TB_RESUMO WHERE 
    id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('9'))       
    ";
    $query = $this->db->query($SQL);
    return $query->result_array();
}
//------------------------------------------------------------CONSTRUTORA---------------->RELAÇÃO DE MOBILIZAÇÃO DA CONSTRUTORA 
public function Mobilizacao_SICRO_Construtora_Pessoal($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao)  total_atual
        FROM CGOB_TB_SICRO_RELACAO AS s 
        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE AS sr ON s.id_sicro_construcao = sr.id_sicro_construcao 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%PESSOAL DE OBRA%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_construcao
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

public function Mobilizacao_SICRO_Construtora_Equipamento($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao)  total_atual
        FROM CGOB_TB_SICRO_RELACAO AS s 
        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE AS sr ON s.id_sicro_construcao = sr.id_sicro_construcao 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%EQUIPAMENTO%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_construcao
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

public function Mobilizacao_SICRO_Construtora_Materiais($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao)  total_atual
        FROM CGOB_TB_SICRO_RELACAO AS s 

        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE AS sr ON s.id_sicro_construcao = sr.id_sicro_construcao 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%MATERIAIS%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_construcao
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

public function Mobilizacao_SICRO_Construtora_Atividade_Auxiliares($dados) {
    $SQL ="
        SELECT 
        DISTINCT (s.cod_sicro), 
        s.item, 
        s.tipo, 
        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "') and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_anterior, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_anterior,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = dateadd(m,-1,'" . $dados["periodo"] . "')and id_sicro_construcao = s.id_sicro_construcao)  total_anterior,

        (SELECT COALESCE(qtd_proprio,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_proprio_atual, 
        (SELECT COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao) qtd_terceiro_atual,
        (SELECT COALESCE(qtd_proprio,0) + COALESCE(qtd_terceiro,0) FROM CGOB_TB_SICRO_QUANTIDADE WHERE periodo_referencia = '" . $dados["periodo"] . "' and id_sicro_construcao = s.id_sicro_construcao)  total_atual
        FROM CGOB_TB_SICRO_RELACAO AS s 

        FULL OUTER JOIN CGOB_TB_SICRO_QUANTIDADE AS sr ON s.id_sicro_construcao = sr.id_sicro_construcao 
        WHERE (sr.publicar like '%S%' or sr.publicar is NULL) AND s.item like '%ATIVIDADES AUXILIARES%' 
        AND sr.id_contrato_obra = ". $dados["id_contrato_obra"] ."
        group by 
        s.cod_sicro, 
        s.item, 
        s.tipo,
        sr.qtd_proprio,
        sr.qtd_terceiro,
        s.id_sicro_construcao
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//------------------------------------------------------------------------------------------------------------------------------
    public function AtividadeConstrutora($dados) {
        $SQL = "
        SELECT 
        resumo as atividade_construtora 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('12'))      
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//--------------------------------------------------------------------------------------------------------------------------------
    public function analiseCriticaCronograma($dados) {
        $SQL = "
        SELECT 
        resumo as analise_critica_cronograma 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('10'))     
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//---------------------------------------------------------------------------------------------------------
    public function controlePluviometrico($dados) {
        $SQL = "
        SELECT 
        dia,
        situacao 
        FROM CGOB_TB_CONTROLE_PLUVIOMETRICO WHERE 
        publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."'      
        "; 
        $SQL .= " ORDER BY dia ";

        $query = $this->db->query($SQL);
        return $query->result();
    }
    public function controlePluviometricototal($dados) {
        $SQL = "SELECT situacao, count(situacao) as qtd
            FROM CGOB_TB_CONTROLE_PLUVIOMETRICO WHERE 
        publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' 
        group by situacao
     ";
         $query = $this->db->query($SQL);
        return $query->result();
    }
//--------------------------------------------------------------------------------------------------------
    public function DocumentacaoFotografica($dados) {
        $SQL = "
        SELECT 
        f.km,
        f.latitude,
        f.longitude,
        f.estaca,
        arq.nome_arquivo,
        f.descricao,
        concat( CONVERT(CHAR(10),f.ultima_alteracao , 103),' ', CONVERT(CHAR(8),f.ultima_alteracao , 114)) AS atualizacao
        FROM CGOB_TB_FOTOGRAFICA  as f
        INNER JOIN CGOB_TB_ARQUIVO as arq ON f.id_arquivo = arq.id_arquivo
        WHERE f.publicar = 'S' AND f.id_contrato_obra = ". $dados["id_contrato_obra"] ." AND f.periodo_referencia = '". $dados["periodo"] ."'      
        "; 
        $query = $this->db->query($SQL);
        return $query->result();
    }
//------------------------------------------------------------------------------------------------------------------------------
    public function EnsaioConstrutora($dados) {
        $SQL = "
        SELECT 
        resumo as EnsaioConstrutora 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('6'))      
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//------------------------------------------------------------------------------------------------------------------------------
    public function EnsaioSupervisora($dados) {
        $SQL = "
        SELECT 
        resumo as EnsaioSupervisora 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('7'))       
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//------------------------------------------------------------------------------------------------------------------------------
    public function RecuperaPGQ($dados) {
        $SQL = "
        SELECT 
        resumo as resumo_pgq 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('4'))       
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//------------------------------------------------------------------------------------------------------------------------
    public function GarantiasSeguros($dados) {
        $SQL = "
          SELECT
            r.num_guia ,
            g.desc_tipo_garantia,
            r.processo ,
            r.valor_garantia,
            r.instituicao,
            r.num_apolice,
            r.situacao,
            r.desc_observacao,
            r.desc_objeto,
            convert(varchar(10),r.inicio_vigencia,103) AS inicio_vigencia,
            convert(varchar(10),r.termino_vigencia,103) AS termino_vigencia,
            convert(varchar(10),r.data_emissao,103) AS data_emissao
            FROM CGOB_TB_GARANTIAS_SEGUROS AS r
            INNER JOIN CGOB_TB_TIPO_GARANTIA AS g ON g.id_tipo_garantia = r.id_tipo_garantia
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------------------
    public function RiscosInterferencias($dados) {
        $SQL = "
          SELECT
            convert(varchar(10),r.previsao_solucao,103) AS previsao_solucao,
            convert(varchar(10),r.data_limite,103) AS data_limite,
            r.km_inicial,
            r.km_final,
            r.impacto_custo,
            r.impacto_prazo,
            t.desc_tipo,
            i.desc_grau_impacto,
            c.desc_classificacao,
            r.resumo,
            r.providencia
            FROM CGOB_TB_RISCOS_INTERFERENCIAS AS r
            INNER JOIN CGOB_TB_RISCOS_ITEM_TIPO AS t ON t.id_tipo_interferencia = r.id_tipo_interferencia
            INNER JOIN CGOB_TB_RISCOS_ITEM_GRAU_IMPACTO AS i ON i.id_grau_impacto = r.id_grau_impacto
            INNER JOIN CGOB_TB_RISCOS_ITEM_CLASSIFICACAO AS c ON c.id_classificacao = r.id_classificacao     
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }
 
        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------------------------
    public function AtasCorrespondencias($dados) {
        $SQL = "
          SELECT
            l.desc_atas_correspondecia,
            l.numero_documento,
            l.tipo_documento,
            convert(varchar(10),l.data_atividade,103) AS data_atividade,
            l.assunto
            FROM CGOB_TB_ATAS_CORRESPONDENCIAS AS l
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND l.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $query = $this->db->query($SQL);
        return $query->result();
    }
//---------------------------------------------------------------------------------------------------------------------
    public function GestaoTratativas($dados) {
        $SQL = "
          SELECT
            convert(varchar(10),r.data_solicitacao,103) AS data_solicitacao,
            convert(varchar(10),r.data_pactuada,103) AS data_pactuada,
            convert(varchar(10),r.nova_data_pactuada,103) AS nova_data_pactuada,
            convert(varchar(10),r.data_termino,103) AS data_termino,
            r.assunto_tratativa,
            s.desc_origem as origem,
            l.desc_responsavel as responsavel,
            r.status_gestao as status,
            (SELECT MAX(providencia) FROM CGOB_TB_PROVIDENCIA where id_gestao_tratativa = r.id_gestao_tratativa ) as providencia,  
            (SELECT top 1 status FROM CGOB_TB_PROVIDENCIA 
            WHERE id_gestao_tratativa = r.id_gestao_tratativa 
            ) as st
            FROM CGOB_TB_GESTAO_TRATATIVAS AS r
            INNER JOIN CGOB_TB_ORIGEM AS s ON s.id_origem = r.id_origem
            INNER JOIN CGOB_TB_RESPONSAVEL AS l ON l.id_responsavel = r.id_responsavel
    
        WHERE (r.publicar like '%S%' or r.publicar is NULL)
        ";

        if (!empty($dados["idContrato"])) {
            $SQL .= " AND r.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        if (!empty($dados["periodo"])) {
            $SQL .= " AND r.periodo_referencia = '" . $dados["periodo"] . "' ";
        }

        $SQL .= " ORDER BY r.ultima_alteracao DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }
//----------------------------------------------------------------------------------------------------------------------
    public function ConclusaoComentarios($dados) {
        $SQL = "
        SELECT 
        resumo as resumo_conclusao_comentario 
        FROM CGOB_TB_RESUMO WHERE 
        id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('5'))        
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//--------------------------------------------------------------------------------------------------------------------
    public function TermoEncerramento($dados) {
        $SQL = "
        SELECT 
        texto_encerramento  
        FROM CGOB_TB_TERMO_ENCERRAMENTO WHERE 
        id_termo = (SELECT MAX(id_termo) FROM CGOB_TB_TERMO_ENCERRAMENTO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND periodo_referencia = '". $dados["periodo"] ."')          
        ";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }
//----------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------
    public function VersaoRelatorioContratoDaq($dados) {
        $SQL = "
            SELECT
                CONCAT(co.nu_con_formatado, ' - ', co.no_empresa)contrato,
                CONCAT(co.nu_con_formatado_supervisor ,' - ', cs.no_empresa) as supervisora,
                co.descricao_br as uf
               
        FROM CGOB_TB_CONTRATO_OBRA as co
        full outer join CGOB_TB_CONTRATO_SUPERVISORA as cs ON co.nu_con_formatado_supervisor = cs.nu_con_formatado
        WHERE  co.id_contrato_obra = " . $dados["id_contrato_obra"] . " 

        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------------------
        public function recuperaRNC($dados){
        $SQL = "
        SELECT 
        concat(rnc.latitude,' / ',rnc.longitude)as ref, 
        nat.desc_natureza, grau.desc_gravidade, 
        'Canal de Navegação' as desc_tipo_eixo,
        convert(varchar(10),rnc.data_registro,103) AS data_registro, 
        CASE WHEN  (prov.situacao_providencia IS NULL or prov.situacao_providencia like '' OR prov.situacao_providencia = 'Aberto')  THEN 'Aberto' 
        ELSE 'Fechado' 
        END as status, 
         CASE WHEN (rnc.data_fechamento is null or rnc.data_fechamento like '') THEN
                    CASE when (prov.data_fechamento is null or prov.data_fechamento like '') then '- -' 
                    ELSE convert(varchar(10),prov.data_fechamento,103) end 
                    ELSE convert(varchar(10),rnc.data_fechamento,103) 
                END as dtfechamento,

                 CASE WHEN (rnc.data_atualizacao is null or rnc.data_atualizacao like '') THEN
                 CASE when (prov.data_atualizacao is null or prov.data_atualizacao like '') then '- -' 
                 ELSE
                    convert(varchar(10),prov.data_atualizacao,103) end
                    ELSE  convert(varchar(10),rnc.data_atualizacao,103)  
                END as dtatualizacao,
        concat(CONVERT(CHAR(10), rnc.data_alteracao , 103),' ', CONVERT(CHAR(8), rnc.data_alteracao , 114)) AS ultima_alteracao
        FROM CGOB_TB_RNC as rnc 
        INNER JOIN CGOB_TB_RNC_ITEM_NATUREZA as nat ON nat.id_natureza = rnc.id_natureza 
        INNER JOIN CGOB_TB_RNC_ITEM_GRAVIDADE as grau ON grau.id_gravidade = rnc.id_gravidade 
        FULL OUTER JOIN CGOB_TB_RNC_PROVIDENCIA as prov on prov.id_rnc = rnc.id_rnc
        WHERE rnc.publicar = 'S' AND rnc.id_contrato_obra =" .$dados['idContrato']. "
        AND rnc.periodo_referencia='" . $dados["periodo"] . "' 

        ";
   
        $query = $this->db->query($SQL);
        return $query->result();
    }
//-----------------------------------------------------------------------------------------------------------------------
    public function DadosImpressaoRelatorioDaq($dados) {
        $SQL = " 
            SELECT 
            14 as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('14'))
                union
            SELECT 
            15 as id_modulo,
            res.id_arquivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 15) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ARQUIVO as res 
            WHERE res.id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND roteiro in ('15'))

                union
            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('1'))
            
                union
            SELECT 
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('2'))

                union

            SELECT 
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('3'))

                union

            SELECT
            24 as id_modulo, 
            res.id_rpfo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 24) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RPFO as res 
            WHERE res.id_rpfo = (SELECT MAX(id_rpfo) FROM CGOB_TB_RPFO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            id_modulo,
            id_relatorio,
            modulo,
            ultima_alteracao,
            usuario
            FROM (
            SELECT
            (SELECT id_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as id_modulo, 
            res.id_termo_aditivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO as res 
            WHERE res.id_termo_aditivo = (SELECT MAX(id_termo_aditivo) FROM CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia <= '". $dados["periodo"] ."') 

             UNION

            SELECT
            (SELECT id_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as id_modulo, 
            res.id_localizacao as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_SUPERVISORA_LOCALIZACAO as res 
            WHERE res.id_localizacao = (SELECT MAX(id_localizacao) FROM CGOB_TB_APRESENTACAO_SUPERVISORA_LOCALIZACAO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia <= '". $dados["periodo"] ."') 

             UNION

            SELECT
            (SELECT id_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as id_modulo, 
            res.id_art_supervisao as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ART_SUPERVISAO as res 
            WHERE res.id_art_supervisao = (SELECT MAX(id_art_supervisao) FROM CGOB_TB_ART_SUPERVISAO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia <= '". $dados["periodo"] ."')
            )supervisora 
            
                union

            SELECT 
            22 as id_modulo, 
            res.id_sicro_quantidade_sr as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 22) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_SICRO_QUANTIDADE_SR as res 
            WHERE res.id_sicro_quantidade_sr = (SELECT MAX(id_sicro_quantidade_sr) FROM CGOB_TB_SICRO_QUANTIDADE_SR 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            res.id_roteiro as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('9'))

                union

            SELECT
            id_modulo,
            id_relatorio,
            modulo,
            ultima_alteracao,
            usuario
            FROM (
            SELECT
            18 as id_modulo,  
            res.id_termo_aditivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 18) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_ADITIVO as res 
            WHERE res.id_termo_aditivo = (SELECT MAX(id_termo_aditivo) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_ADITIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia <= '". $dados["periodo"] ."') 

             UNION

            SELECT
            18 as id_modulo, 
            res.id_localizacao as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 18) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO as res 
            WHERE res.id_localizacao = (SELECT MAX(id_localizacao) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia <= '". $dados["periodo"] ."') 
            )construtora 

                union

            SELECT
            23 as id_modulo, 
            res.id_sicro_quantidade as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 23) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_SICRO_QUANTIDADE as res 
            WHERE res.id_sicro_quantidade = (SELECT MAX(id_sicro_quantidade) FROM CGOB_TB_SICRO_QUANTIDADE 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('12'))

                union

            SELECT
            25 as id_modulo,  
            res.id_avanco_financeiro as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 25) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_AVANCO_FINANCEIRO as res 
            WHERE res.id_avanco_financeiro = (SELECT MAX(id_avanco_financeiro) FROM CGOB_TB_AVANCO_FINANCEIRO 
            where publicar = 'S' AND publicar_versao  = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            26 as id_modulo, 
            res.id_avanco_fisico as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 26) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_AVANCO_FISICO as res 
            WHERE res.id_avanco_fisico = (SELECT MAX(id_avanco_fisico) FROM CGOB_TB_AVANCO_FISICO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT 
            res.id_roteiro as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('10') AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            27 as id_modulo, 
            res.id_controle_pluviometrico as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 27) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_CONTROLE_PLUVIOMETRICO as res 
            WHERE res.id_controle_pluviometrico = (SELECT MAX(id_controle_pluviometrico) FROM CGOB_TB_CONTROLE_PLUVIOMETRICO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            13 as id_modulo, 
            res.id_documentacao_foto as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 13) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_FOTOGRAFICA as res 
            WHERE res.id_documentacao_foto = (SELECT MAX(id_documentacao_foto) FROM CGOB_TB_FOTOGRAFICA 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('11') )

                union

            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('7'))

                union

            SELECT 
            res.id_roteiro as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('6'))

                union

            SELECT
            28 as id_modulo, 
            res.id_rnc as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 28) as modulo, 
            concat( CONVERT(CHAR(10),res.data_alteracao , 103),' ', CONVERT(CHAR(8),res.data_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RNC as res 
            WHERE res.id_rnc = (SELECT MAX(id_rnc) FROM CGOB_TB_RNC 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            29 as id_modulo, 
            res.id_garantia_seguro as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 29) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_GARANTIAS_SEGUROS as res 
            WHERE res.id_garantia_seguro = (SELECT MAX(id_garantia_seguro) FROM CGOB_TB_GARANTIAS_SEGUROS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            30 as id_modulo, 
            res.id_riscos_interferencias as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 30) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RISCOS_INTERFERENCIAS as res 
            WHERE res.id_riscos_interferencias = (SELECT MAX(id_riscos_interferencias) FROM CGOB_TB_RISCOS_INTERFERENCIAS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            31 as id_modulo, 
            res.id_arquivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 31) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ARQUIVO as res 
            WHERE res.id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND roteiro in ('31'))

                union

            SELECT
            32 as id_modulo, 
            res.id_atas_correspondencias as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 32) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ATAS_CORRESPONDENCIAS as res 
            WHERE res.id_atas_correspondencias = (SELECT MAX(id_atas_correspondencias) FROM CGOB_TB_ATAS_CORRESPONDENCIAS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT 
            33 as id_modulo,
            res.id_gestao_tratativa as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 33) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_GESTAO_TRATATIVAS as res 
            WHERE res.id_gestao_tratativa = (SELECT MAX(id_gestao_tratativa) FROM CGOB_TB_GESTAO_TRATATIVAS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT 
            5 as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('5'))

                union

            SELECT 
            8 as id_modulo,
            res.id_arquivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 8) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ARQUIVO as res 
            WHERE res.id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND roteiro in ('8'))

                union

            SELECT
            34 as id_modulo, 
            res.id_termo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 34) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_TERMO_ENCERRAMENTO as res 
            WHERE res.id_termo = (SELECT MAX(id_termo) FROM CGOB_TB_TERMO_ENCERRAMENTO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

 			union

            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('35') )
            ";
        $SQL_OLD_20122021 = " 
            SELECT 
            14 as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('14'))
                union
            SELECT 
            15 as id_modulo,
            res.id_arquivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 15) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ARQUIVO as res 
            WHERE res.id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND roteiro in ('15'))

                union
            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('1'))
            
                union
            SELECT 
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('2'))

                union

            SELECT 
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('3'))

                union

            SELECT
            24 as id_modulo, 
            res.id_rpfo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 24) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RPFO as res 
            WHERE res.id_rpfo = (SELECT MAX(id_rpfo) FROM CGOB_TB_RPFO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            id_modulo,
            id_relatorio,
            modulo,
            ultima_alteracao,
            usuario
            FROM (
            SELECT
            (SELECT id_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as id_modulo, 
            res.id_termo_aditivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO as res 
            WHERE res.id_termo_aditivo = (SELECT MAX(id_termo_aditivo) FROM CGOB_TB_APRESENTACAO_SUPERVISORA_ADITIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."') 

             UNION

            SELECT
            (SELECT id_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as id_modulo, 
            res.id_localizacao as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_SUPERVISORA_LOCALIZACAO as res 
            WHERE res.id_localizacao = (SELECT MAX(id_localizacao) FROM CGOB_TB_APRESENTACAO_SUPERVISORA_LOCALIZACAO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."') 

             UNION

            SELECT
            (SELECT id_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as id_modulo, 
            res.id_art_supervisao as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 19) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ART_SUPERVISAO as res 
            WHERE res.id_art_supervisao = (SELECT MAX(id_art_supervisao) FROM CGOB_TB_ART_SUPERVISAO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')
            )supervisora 
            
                union

            SELECT 
            22 as id_modulo, 
            res.id_sicro_quantidade_sr as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 22) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_SICRO_QUANTIDADE_SR as res 
            WHERE res.id_sicro_quantidade_sr = (SELECT MAX(id_sicro_quantidade_sr) FROM CGOB_TB_SICRO_QUANTIDADE_SR 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            res.id_roteiro as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('9'))

                union

            SELECT
            id_modulo,
            id_relatorio,
            modulo,
            ultima_alteracao,
            usuario
            FROM (
            SELECT
            18 as id_modulo,  
            res.id_termo_aditivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 18) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_ADITIVO as res 
            WHERE res.id_termo_aditivo = (SELECT MAX(id_termo_aditivo) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_ADITIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."') 

             UNION

            SELECT
            18 as id_modulo, 
            res.id_localizacao as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 18) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO as res 
            WHERE res.id_localizacao = (SELECT MAX(id_localizacao) FROM CGOB_TB_APRESENTACAO_CONSTRUTORA_LOCALIZACAO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."') 
            )construtora 

                union

            SELECT
            23 as id_modulo, 
            res.id_sicro_quantidade as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 23) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_SICRO_QUANTIDADE as res 
            WHERE res.id_sicro_quantidade = (SELECT MAX(id_sicro_quantidade) FROM CGOB_TB_SICRO_QUANTIDADE 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('12'))

                union

            SELECT
            25 as id_modulo,  
            res.id_avanco_financeiro as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 25) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_AVANCO_FINANCEIRO as res 
            WHERE res.id_avanco_financeiro = (SELECT MAX(id_avanco_financeiro) FROM CGOB_TB_AVANCO_FINANCEIRO 
            where publicar = 'S' AND publicar_versao  = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            26 as id_modulo, 
            res.id_avanco_fisico as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 26) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_AVANCO_FISICO as res 
            WHERE res.id_avanco_fisico = (SELECT MAX(id_avanco_fisico) FROM CGOB_TB_AVANCO_FISICO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT 
            res.id_roteiro as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('10') AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            27 as id_modulo, 
            res.id_controle_pluviometrico as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 27) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_CONTROLE_PLUVIOMETRICO as res 
            WHERE res.id_controle_pluviometrico = (SELECT MAX(id_controle_pluviometrico) FROM CGOB_TB_CONTROLE_PLUVIOMETRICO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            13 as id_modulo, 
            res.id_documentacao_foto as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 13) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_FOTOGRAFICA as res 
            WHERE res.id_documentacao_foto = (SELECT MAX(id_documentacao_foto) FROM CGOB_TB_FOTOGRAFICA 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('11') )

                union

            SELECT
            res.id_roteiro as id_modulo, 
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('7'))

                union

            SELECT 
            res.id_roteiro as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('6'))

                union

            SELECT
            28 as id_modulo, 
            res.id_rnc as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 28) as modulo, 
            concat( CONVERT(CHAR(10),res.data_alteracao , 103),' ', CONVERT(CHAR(8),res.data_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RNC as res 
            WHERE res.id_rnc = (SELECT MAX(id_rnc) FROM CGOB_TB_RNC 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            29 as id_modulo, 
            res.id_garantia_seguro as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 29) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_GARANTIAS_SEGUROS as res 
            WHERE res.id_garantia_seguro = (SELECT MAX(id_garantia_seguro) FROM CGOB_TB_GARANTIAS_SEGUROS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            30 as id_modulo, 
            res.id_riscos_interferencias as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 30) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RISCOS_INTERFERENCIAS as res 
            WHERE res.id_riscos_interferencias = (SELECT MAX(id_riscos_interferencias) FROM CGOB_TB_RISCOS_INTERFERENCIAS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT
            31 as id_modulo, 
            res.id_arquivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 31) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ARQUIVO as res 
            WHERE res.id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND roteiro in ('31'))

                union

            SELECT
            32 as id_modulo, 
            res.id_atas_correspondencias as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 32) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ATAS_CORRESPONDENCIAS as res 
            WHERE res.id_atas_correspondencias = (SELECT MAX(id_atas_correspondencias) FROM CGOB_TB_ATAS_CORRESPONDENCIAS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT 
            33 as id_modulo,
            res.id_gestao_tratativa as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 33) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_GESTAO_TRATATIVAS as res 
            WHERE res.id_gestao_tratativa = (SELECT MAX(id_gestao_tratativa) FROM CGOB_TB_GESTAO_TRATATIVAS 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

                union

            SELECT 
            5 as id_modulo,
            res.id_resumo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = res.id_roteiro) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_RESUMO as res 
            WHERE res.id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND id_roteiro in ('5'))

                union

            SELECT 
            8 as id_modulo,
            res.id_arquivo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 8) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_ARQUIVO as res 
            WHERE res.id_arquivo = (SELECT MAX(id_arquivo) FROM CGOB_TB_ARQUIVO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."' AND roteiro in ('8'))

                union

            SELECT
            34 as id_modulo, 
            res.id_termo as id_relatorio, 
            (SELECT desc_roteiro FROM CGOB_TB_ROTEIRO WHERE id_roteiro = 34) as modulo, 
            concat( CONVERT(CHAR(10),res.ultima_alteracao , 103),' ', CONVERT(CHAR(8),res.ultima_alteracao , 114)) AS ultima_alteracao, 
            (SELECT desc_nome FROM TB_USUARIO WHERE id_usuario = res.id_usuario) AS usuario 
            FROM CGOB_TB_TERMO_ENCERRAMENTO as res 
            WHERE res.id_termo = (SELECT MAX(id_termo) FROM CGOB_TB_TERMO_ENCERRAMENTO 
            where publicar = 'S' AND id_contrato_obra = " . $dados["id_contrato_obra"] . " AND periodo_referencia = '". $dados["periodo"] ."')

            ";
       // echo('<pre>');
       // die($SQL);
        $query = $this->db->query($SQL);
        return $query->result();
    }
    //-------------------------------------------------------------------------------------------------------
     public function consultaObservacao($dados) {
        $SQL = "
          SELECT
            r.numero_rpfo,
            r.ultima_alteracao,
            r.desc_analistas_responsaveis,
            a.nomeOriginalArquivo,
            a.nome_arquivo
            FROM CGOB_TB_RPFO_ANEXO AS ax
            INNER JOIN CGOB_TB_RPFO_HISTORICO AS h ON h.id_rpfo_historico = ax.id_rpfo_historico
            INNER JOIN CGOB_TB_RPFO AS r ON h.id_rpfo = r.id_rpfo
            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = ax.id_arquivo
        where(r.publicar like '%S%' or r.publicar is NULL) 
          AND r.flag_atividade = 'S' 
          AND ax.data_exclusao IS NULL
          AND r.id_contrato_obra = " . $dados["id_contrato_obra"] ;
       //echo('<pre>');
       //die($SQL);
        $query = $this->db->query($SQL);
        return $query->result();
    }

        public function PortariasFiscaisanexo($dados) {
        $SQL = "
          SELECT
            l.id_portaria_fiscal,
            c.nu_con_formatado,
            CASE WHEN (c.nu_con_formatado_supervisor is null or c.nu_con_formatado_supervisor like '') THEN
                    '/' 
                    ELSE c.nu_con_formatado_supervisor
                END as numero_supervisora,
            l.nome_fiscal,
            l.email,
            l.telefone,
            s.titularidade,
            l.contrato_fiscalizado,
            l.num_portaria,
            uf.estado,
            convert(varchar(10),l.data_portaria,103) AS portaria,
            a.id_arquivo,
            a.nome_arquivo,
            a.nomeOriginalArquivo as arquivo,
            u.DESC_NOME as nome,
            concat( CONVERT(CHAR(10),l.ultima_alteracao , 103),' ', CONVERT(CHAR(8),l.ultima_alteracao , 114)) AS atualizacao
            FROM CGOB_TB_PORTARIA_FISCAIS AS l
            INNER JOIN TB_USUARIO AS u ON u.id_usuario = l.id_usuario
            INNER JOIN CGOB_TB_UF AS uf ON uf.id_uf = l.id_uf
            INNER JOIN CGOB_TB_TITULARIDADE AS s ON s.id_titularidade = l.id_titularidade
            INNER JOIN CGOB_TB_ARQUIVO AS a ON a.id_arquivo = l.id_arquivo
            INNER JOIN CGOB_TB_CONTRATO_OBRA AS c ON c.id_contrato_obra = l.id_contrato_obra
        WHERE (l.publicar like '%S%' or l.publicar is NULL)
        ";
       
        if (!empty($dados["idContrato"])) {
            $SQL .= " AND l.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

        $SQL .= " ORDER BY l.ultima_alteracao DESC";
       
        $query = $this->db->query($SQL);
        return $query->result();
    }


    public function recuperaAnexosGaratias($dados) {
        $SQL = "
          SELECT
            r.id_arquivo,
            r.nome_arquivo,
            r.nomeOriginalArquivo as arquivo,
            tg.desc_tipo_garantia as tipo,
            concat( CONVERT(CHAR(10),r.ultima_alteracao , 103),' ', CONVERT(CHAR(8),r.ultima_alteracao , 114)) AS atualizacao
            FROM CGOB_TB_GARANTIAS_SEGUROS AS g
            INNER JOIN CGOB_TB_TIPO_GARANTIA AS tg ON tg.id_tipo_garantia = g.id_tipo_garantia
            INNER JOIN CGOB_TB_ARQUIVO AS r on r.id_garantia_seguro = g.id_garantia_seguro
          
            WHERE (r.publicar like '%S%' or r.publicar is NULL) and (g.publicar like '%S%' or g.publicar is NULL) AND g.periodo_referencia = '". $dados["periodo"] ."' 
        ";

  
                if (!empty($dados["idContrato"])) {
            $SQL .= " AND g.id_contrato_obra = '" . $dados["idContrato"] . "' ";
        }

       
        $query = $this->db->query($SQL);
        return $query->result();
    }

        public function recuperaRNCAnexo($dados){
        $SQL = "
        SELECT 
        cs.nu_con_formatado,
        rnc.latitude,
        rnc.longitude, 
        nat.desc_tipo_obra, 
        grau.desc_gravidade,
        rnc.km,
        rnc.descricao, 
        'Canal de Navegação' as desc_tipo_eixo,
        convert(varchar(10),rnc.data_registro,103) AS data_registro, 
        CASE WHEN  (prov.situacao_providencia IS NULL or prov.situacao_providencia like '' OR prov.situacao_providencia = 'Aberto')  THEN 'Aberto' 
        ELSE 'Fechado' 
        END as status, 
        (select prov.providencia from CGOB_TB_RNC_PROVIDENCIA where id_providencia =(select max (id_providencia) from CGOB_TB_RNC_PROVIDENCIA where (publicar like '%S%' or publicar is NULL) AND id_contrato_obra =" .$dados['idContrato']. " AND periodo_referencia='" . $dados["periodo"] . "')) providencia

       
        
        FROM CGOB_TB_RNC as rnc 
        INNER JOIN CGOB_TB_OBRA as nat ON nat.id_tipo_obra = rnc.id_natureza 
        INNER JOIN CGOB_TB_RNC_ITEM_GRAVIDADE as grau ON grau.id_gravidade = rnc.id_gravidade 
        FULL OUTER JOIN CGOB_TB_RNC_PROVIDENCIA as prov on prov.id_rnc = rnc.id_rnc


        full outer join CGOB_TB_CONTRATO_OBRA as cs ON 
         cs.id_contrato_obra = rnc.id_contrato_obra


        WHERE (rnc.publicar like '%S%' or rnc.publicar is NULL) AND rnc.id_contrato_obra =" .$dados['idContrato']. "

        AND rnc.periodo_referencia='" . $dados["periodo"] . "' and rnc.id_rnc =(select max(id_rnc) from CGOB_TB_RNC where (publicar like '%S%' or publicar is NULL) AND id_contrato_obra =" .$dados['idContrato']. " AND periodo_referencia='" . $dados["periodo"] . "')
        
        ";
   
        $query = $this->db->query($SQL);
        return $query->result();
    }


public function RecuperaFotosAnexo($dados){
        $SQL = "
        SELECT
        a.nome_arquivo,
        a.nomeOriginalArquivo,
        ft.descricao_foto as descricao,
        convert(varchar(10),ft.data_atualizacao,103) AS data_atualizacao,
        (SELECT desc_nome from TB_USUARIO WHERE id_usuario = ft.id_usuario) usuario,
        concat( CONVERT(CHAR(10), ft.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ft.ultima_alteracao , 114)) AS ultima_alteracao
        FROM CGOB_TB_ARQUIVO AS a
        INNER JOIN CGOB_TB_RNC_FOTO AS ft ON ft.id_arquivo = a.id_arquivo AND ft.id_rnc = (select max(id_rnc) from CGOB_TB_RNC where (publicar like '%S%' or publicar is NULL) AND id_contrato_obra =" .$dados['idContrato']. " AND periodo_referencia='" . $dados["periodo"] . "')
        WHERE ft.publicar like '%S%' 
        AND ft.id_contrato_obra=" . $dados["idContrato"] . "
        ";

        $query = $this->db->query($SQL);
        return $query->result();
    }

	//-----------------------------------------------------------------------------------
	public function relatorioMonitoramentoAmbiental($dados) {
		$SQL = "
        SELECT 
           resumo as texto_relatorio_monitoramento_ambiental,
               flag_atividade
           FROM CGOB_TB_RESUMO 
        WHERE id_contrato_obra = " . $dados["id_contrato_obra"] . " AND id_roteiro in ('35') AND publicar = 'S' 
        AND id_resumo = (SELECT MAX(id_resumo) FROM CGOB_TB_RESUMO where publicar = 'S' AND id_contrato_obra = ". $dados["id_contrato_obra"] ." AND id_roteiro in ('35')) 
            ";

		if (!empty($dados["periodo"])) {
			$SQL .= " AND periodo_referencia = '" . $dados["periodo"] . "' ";
		}

		$query = $this->db->query($SQL);
		return $query->result_array();
	}

}//fecha classe Relatorio

//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO
//# Desenvolvedora:Jordana de Alencar
//# Data: 2020 
//########################################################################################################################################################################################################################
