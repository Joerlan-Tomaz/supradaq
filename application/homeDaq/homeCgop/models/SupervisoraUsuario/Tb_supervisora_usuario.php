<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_supervisora_usuario extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

//-------------------------------------------------------------------------------------------------------
    public function RecuperaSupervisora() {
      $SQL = "";
      $query = $this->db->query($SQL);
      return $query->result();
  }
}//Fecha
//######################################################################################################################################################################################################################## 
//# DNIT - AQUAVIARIO/FERROVIÁRIO
//# Desenvolvedora:Eduardo Rocha Vargas
//# Data: 08/09/2020
//########################################################################################################################################################################################################################


