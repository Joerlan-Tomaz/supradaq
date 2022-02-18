<?php
/*
 * Classe controller ControlePluviometrico. 
 * @author Jordana Alencar <jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  © 2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class ControlePluviometrico extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('/Supervisaodaq/Tb_controle_pluviometrico');
         $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }


    //-------------------------------------------Insere-----------------------------------------
    public function insereControlePluv() {
        $totaldias = $this->input->post_get('totalDias');
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq;
               
        for ($j = 1; $j <= $totaldias; $j++) {
            $dia = $j;
            $situacao = $this->input->post_get("cp_manha_$j");

            if(!empty($situacao)){
                $dados["dia"] = $dia;
                $dados["situacao"] = $situacao;

                $Dados = $this->Tb_controle_pluviometrico->ConsultaControlePluv($dados);
                foreach ($Dados as $lista) {
                    $conte_id = $lista->conte_id;
                }
                if( $conte_id == 'N'){
                    $retorno=$this->Tb_controle_pluviometrico->insereControlePluv($dados);
                }else{
                    $retorno=$this->Tb_controle_pluviometrico->alteraControlePluv($dados);
                }

                $dia = "";
                $situacao = "";
            }
        }
        echo (json_encode($retorno));
    }



     public function recuperaControlePluv() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        $dados["data"] = Array();
        $Dados = $this->Tb_controle_pluviometrico->recuperaControlePluv($dados);   

        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'excluirDia(".$lista->id_controle_pluviometrico.");'><i class = 'fa fa-trash'></i></button >";
            	if(is_null($lista->situacao)){
					$dados["data"][] = array(
						'DIA' => '--',
						'MANHA' => 'Não Houve Atividade',
						'NOME' => $lista->nome,
						'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
						'ACAO' => $acao
					);
				}else{
					$diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sabado');
					$diasemana_numero = date('w', strtotime($lista->diaSemana));
					$dados["data"][] = array(
						'DIA' => $lista->dia . ' - ' . $diasemana[$diasemana_numero],
						'MANHA' => $lista->situacao,
						'NOME' => $lista->nome,
						'ULTIMA_ALTERACAO' => $lista->ultima_alteracao,
						'ACAO' => $acao
					);
				}
            }
        }
        echo (json_encode($dados));
    }


    public function excluirDia() {
        $dados["id_controle_pluviometrico"] = $this->input->post_get('id_controle_pluviometrico');
        $dados["id_usuario"] = $this->session->id_usuario_daq;
        $retorno = $this->Tb_controle_pluviometrico->excluirDia($dados);
        echo (json_encode($retorno));
    }


    public function Recuperadiasmes () {
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get('periodo');
        
        $Dados = $this->Tb_controle_pluviometrico->Recuperadiasmes($dados);

      
            foreach ($Dados as $lista) {
                $conte=$lista->conte;
            }
        

        $ano=substr($this->input->post_get("periodo"),0,4);
        $mes=substr($this->input->post_get("periodo"),5,2);
    
        $funcao = new DateTime($ano."-".$mes);
        $numDias = $funcao->format('t');

        if($conte == $numDias){
        $dados["conte"] = true;
        }else{
        $dados["conte"] = false;
        }
        echo (json_encode($dados));
    }

	public function insereNaoAtividade(){
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq;
		$dados["periodo"] = $this->input->post_get('periodo');
		$retorno = $this->Tb_controle_pluviometrico->insereNaoAtividade($dados);
		echo (json_encode($retorno));
	}

	public function confereAtividade()
	{
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["periodo"] = $this->input->post_get('periodo');

		$DadosControle = $this->Tb_controle_pluviometrico->recuperaControlePluv($dados);
		$dados["data"] = array();

		$dadosNaoAtividade = $this->Tb_controle_pluviometrico->confereAtividade($dados);
		if (!empty($DadosControle)) {
			$dados["situacao"] = 'Com Atividade';
		} else if (!empty($dadosNaoAtividade)) {
			$dados["situacao"] = 'Sem Atividade';
		} else {
			$dados["situacao"] = 'Sem Registros';
		}
		echo(json_encode($dados));
	}

}//fecha classe//fecha classe
//######################################################################################################################################################################################################################## 
//# DNIT
//# Desenvolvedor:Jordana de Alencar
//# Data: 27/01/2020 13:00
//########################################################################################################################################################################################################################
