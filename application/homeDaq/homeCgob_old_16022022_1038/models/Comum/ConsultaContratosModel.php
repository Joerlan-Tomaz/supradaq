<?php

class ConsultaContratosModel extends CI_Model 
{
    private $CI;
    
    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function getContratosAndEixos_ws_core(&$error, &$mensagem)
    {
        // CGMRR
        $mensagemCGMRR = null;
        $errorCGMRR = false;
        $respostaContratoCGMRR = array();
        $this->getContratosAndEixosCGMRR($errorCGMRR, $mensagemCGMRR, $respostaContratoCGMRR);
        
        // CGCONT
        $mensagemCGCONT = null;
        $errorCGCONT = false;
        $respostaContratoCGCONT = array();
        $this->getContratosAndEixosCGCONT($errorCGCONT, $mensagemCGCONT, $respostaContratoCGCONT);
        
        $error = $errorCGCONT && $errorCGMRR;
        
        if($errorCGMRR || $errorCGCONT)
            $mensagem = "CGCONT:" . $mensagemCGCONT . ".\r\nCGMRR:" . $mensagemCGMRR;
        
        // TRATAR RESPOSTA
        return array_merge($respostaContratoCGMRR,$respostaContratoCGCONT);
        
    }
    
    private function getContratosAndEixosCGMRR(&$error, &$mensagem, &$respostaContrato)
    {
        $this->load->model('homeCgmrr/tb_contratos');
        $contratos = $this->tb_contratos->getContratos();
        $mensagem = null;
        $error = false;
        if (Count($contratos) == 0) {
            $mensagem = "Nenhum registro encontrado com o(s) parâmetro(s) envido(s).";
            $error = true;
        }

        $i = 0;

        $respostaContrato = array();
        $this->load->model('homeCgmrr/tb_eixos');
        
        foreach ($contratos as $contrato) 
        {
            $eixo = $this->tb_eixos->getEixoByContrato($contrato["id_contrato"]);
            $contrato["eixo"] = $eixo;
            $respostaContrato[] = $contrato;
            $i++;
        }
    }
    
    private function getContratosAndEixosCGCONT(&$error, &$mensagem, &$respostaContrato)
    {
        $error = true;
        $resposta = null;
        $idUsuario = $this->session->id_usuario_daq;
         
        if ($idUsuario) 
        {
            $dados["id_usuario"] = $idUsuario;
            $this->load->model('homeCgcont/Tb_usuario');
            $dados = $this->Tb_usuario->buscaUsuario($dados);
            if(is_array($dados))
            {
                $dados = json_decode(json_encode($dados[0]), True);
                //$dados["id_perfil"] = $dados["ID_PERFIL"];
                $ID_PERFIL_SUPERVISORA_CGCONT = 7;
                $dados["id_perfil"] = $ID_PERFIL_SUPERVISORA_CGCONT;
                $this->load->model('homeCgcont/Supervisaocont/Tb_contrato_obra');
                
                $dados["id_usuario"] = $dados["ID_USUARIO"];
                
                $resposta = $this->Tb_contrato_obra->RecuperaTabelaContrato($dados);
                
                if(!empty($resposta))
                {
                    $resposta = json_decode(json_encode($resposta), True);
                    
                    $qnt = count($resposta);
                    for($i = 0; $i < $qnt; $i++)    
                    {
                        $respostaContrato[$i]["id_contrato"] = $resposta[$i]["id_contrato_obra"];
                        $respostaContrato[$i]["NU_CON_FORMATADO"] = $resposta[$i]["contrato"];
                        $respostaContrato[$i]["NO_EMPRESA"] = $resposta[$i]["construtora"];
                        $respostaContrato[$i]["SG_EMPRESA_SUPERVISOR"] = $resposta[$i]["supervisora"];
                        $respostaContrato[$i]["DESCRICAO_BR"] = $resposta[$i]["br"];
                        $respostaContrato[$i]["DS_FAS_CONTRATO"] = $resposta[$i]["situacao_contrato"];
                        $respostaContrato[$i]["SG_UND_GESTORA"] = "CGCONT";
                        $respostaContrato[$i]["eixo"] = $this->Recupera_eixo_Core();
                    }
                    
                    $error = false;
                    $mensagem = "Sucesso";
                    
                    return $resposta;
                }
                else
                    $mensagem = 'Usuário sem contratos cadastrados.';
            }
            else
            {
                $mensagem = 'Usuário não cadastrado.';
            }
        }
        else
        {
            $mensagem = 'Usuário não cadastrado.';
        }
    }
    
    public function Recupera_eixo_Core() 
    {
        $i = 1;
        $dados = array
        (
            array(
                "id_eixo" =>$i++,
                "descricao" => "Principal"
                ),
            array(
                "id_eixo" =>$i++,
                "descricao" => "Marginal"
                ),
            array(
                "id_eixo" =>$i++,
                "descricao" => "Ramo"
                ),
            array(
                "id_eixo" =>$i++,
                "descricao" => "Acesso"
                ),
            array(
                "id_eixo" =>$i++,
                "descricao" => "Alça"
                ),
            array(
                "id_eixo" =>$i++,
                "descricao" => "Variante"
                ),
                array(
                "id_eixo" =>$i++,
                "descricao" => "Contorno"
                ),
                array(
                "id_eixo" =>$i++,
                "descricao" => "Restauração"
                ),
                array(
                "id_eixo" =>$i++,
                "descricao" => "Secundário"
                )
        );

        return $dados;
    }

}

?>