<?php
/*
 * Classe model Tb_dados_contrato. 
 * @authorJordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage CI_Model 
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_dados_contrato extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

//-------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------
    public function adicionaDadosInicio($dados) {
        $SQL = "
        SELECT
            af.id_obra,
            af.id_servico,
            af.unidade_medida,
            CASE
                WHEN af.id_obra = 1 THEN 'Construção Portuária'
                WHEN af.id_obra = 2 THEN 'Derrocagem'
                WHEN af.id_obra = 3 THEN 'Dragagem'
                WHEN af.id_obra = 4 THEN 'Desobstrução'
                WHEN af.id_obra = 5 THEN 'Recuperação Portuária'
                WHEN af.id_obra = 6 THEN 'Monitoramento Hidroviário'
                WHEN af.id_obra = 7 THEN 'Remoção Navio'
                WHEN af.id_obra = 8 THEN 'Implantação de Sinalização em Hidrovias'
                WHEN af.id_obra = 9 THEN 'Recuperação Eclusas e Barragens'
            END nome_obra, 
            CASE 
                WHEN af.id_obra = 1 THEN (SELECT i.desc_obra FROM CGOB_TB_OBRA_CONSTRUCAO AS i WHERE af.id_servico = i.id_obra)
                WHEN af.id_obra = 2 THEN (SELECT od.desc_obra FROM CGOB_TB_OBRA_DERROCAMENTO AS od WHERE af.id_servico = od.id_obra)
                WHEN af.id_obra = 3 THEN (SELECT odra.desc_obra FROM CGOB_TB_OBRA_DRAGAGEM AS odra WHERE af.id_servico = odra.id_obra)
                WHEN af.id_obra = 4 THEN (SELECT odes.desc_obra FROM CGOB_TB_OBRA_DESOBSTRUCAO AS odes WHERE af.id_servico = odes.id_obra)
                WHEN af.id_obra = 5 THEN (SELECT opm.desc_obra FROM CGOB_TB_OBRA_RECUPERACAO AS opm WHERE af.id_servico = opm.id_obra)
                WHEN af.id_obra = 6 THEN (SELECT ocp.desc_obra FROM CGOB_TB_OBRA_MONITORAMENTO AS ocp WHERE af.id_servico = ocp.id_obra)
                WHEN af.id_obra = 7 THEN (SELECT onh.desc_obra FROM CGOB_TB_OBRA_REMOCAO_NAVIO_HAIDER AS onh WHERE af.id_servico = onh.id_obra)
                WHEN af.id_obra = 8 THEN (SELECT osh.desc_obra FROM CGOB_TB_OBRA_IMPLANTACAO_SINAL_HIDRO AS osh WHERE af.id_servico = osh.id_obra)
                WHEN af.id_obra = 9 THEN (SELECT oe.desc_obra FROM CGOB_TB_OBRA_ECLUSAS AS oe WHERE af.id_servico = oe.id_obra)
            END AS nome_servico,
            SUM(af.valor_medido) as valor_cronograma,


            (SELECT SUM(val_final) FROM CGOB_TB_AVANCO_FISICO WHERE publicar like '%S%'AND id_contrato_obra = '" . $dados["idContrato"] . "' AND servico = af.id_servico AND obra = af.id_obra AND versao ='" . $dados["versao"] . "') as atacado

        FROM CGOB_TB_CRONOGRAMA_FISICO AS af


        WHERE (af.publicar = 'S' or af.publicar is NULL) AND af.unidade_medida not in ('SN') AND af.id_contrato_obra = '" . $dados["idContrato"] . "' AND af.versao ='" . $dados["versao"] . "'
        group by af.id_servico, af.id_obra, af.unidade_medida
        ";
        //die($SQL);
        $SQL .= " ORDER BY af.id_servico ";
        $query = $this->db->query($SQL);
        return $query->result();
}
       // (SELECT SUM(val_final) FROM CGOB_TB_AVANCO_FISICO WHERE publicar like '%S%'AND id_contrato_obra = '" . $dados["idContrato"] . "' AND servico = af.id_servico AND obra = af.id_obra AND ultima_alteracao = (SELECT MAX (ultima_alteracao) FROM CGOB_TB_AVANCO_FISICO WHERE publicar = 'S' AND id_contrato_obra = '" . $dados["idContrato"] . "') AND servico = af.id_servico AND obra = af.id_obra) as atacado
//-------------------------------------------------------------------------------------------------------

}//Fecha Classe
//######################################################################################################################################################################################################################## 
//# DNIT Falconi-AQUAVIARIO
//# @Jordana Alencar
//# Data: 01/06/2020 13:00
//# Data: 04/08/2020 06:00
//########################################################################################################################################################################################################################
