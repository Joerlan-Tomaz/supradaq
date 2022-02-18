<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_solicitacao_acesso extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

//-------------------------------------------------------------------------------------------------------
    public function RecuperaSolicitacaoAcesso() {
        $SQL = "
            SELECT 
                ID_SOLICITACAO as id_solicitacao
                ,NOME as nome
                ,EMAIL as email
                ,EMPRESA as empresa
                ,CPF as cpf
                ,TELEFONE as telefone
                ,COORDENACAO as coordenacao
                ,SA.id_uf as id_uf
                ,UF.estado as ds_estado
                ,DS_MOTIVO as motivo
            FROM TB_SOLICITACAO_ACESSO AS SA
            INNER JOIN CGOB_TB_UF AS UF ON SA.id_uf = UF.id_uf
            WHERE STATUS_SOLICITACAO = 'PENDENTE'
        ";
      $query = $this->db->query($SQL);
      return $query->result();
  }
}//Fecha
//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO/FERROVIÁRIO
//# Desenvolvedora:Eduardo Rocha Vargas
//# Data: 08/09/2020
//########################################################################################################################################################################################################################


