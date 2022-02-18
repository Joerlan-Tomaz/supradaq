<?php
/*
 * Classe controller. 
 * @author Jordana Alencar<jordanadev2@gmail.com>
 * @version 1.0 
 * @copyright  ©2020, DNIT | AQUAVIARIO. 
 * @subpackage controllers 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Rpfo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ftp');
        $this->load->model('/Supervisaodaq/Tb_rpfo');
        $this->load->model('/Supervisaodaq/Tb_arquivo');
        $this->load->database('DAQ', TRUE);
        $this->load->helper('url');
        if (empty($this->session->id_usuario)) {
            redirect(base_url());
        }
    }

    //----------------------------------------------------------------------------------

    public function recuperaRpfo() {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["id_contrato_obra"] = $this->session->idContrato;

        $Dados = $this->Tb_rpfo->recuperaRpfo($dados);

        $retorno["data"] = Array();
        if (!empty($Dados)) {
            foreach ($Dados as $lista) {
        		$dadosHistorico = $this->Tb_rpfo->recuperaRpfoHistorico($lista->id_rpfo);
        		$local = "";
        		$status = "";
        		if(isset($dadosHistorico)){
        			foreach($dadosHistorico as $historico){
						$local = $historico->local;
						$status = $historico->status;
					}
				}

                $observacao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick = 'modalStatusDetalhado(". $lista->id_rpfo.")'><i class = 'fa fa-eye'></i></button>";

                $acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='gestaoRpfo(" . $lista->id_rpfo . ");' data-toggle='tooltip' title='Gestão' data-placement='top'><i class='fa fa-list'></i></button>";
                $acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='editarRpfo(" . $lista->id_rpfo . ");' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fa fa-pencil'></i></button>";
				$dadosHistorico = $this->Tb_rpfo->recuperaRpfoHistorico($lista->id_rpfo);
				if(empty($dadosHistorico)){
                	$acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirRpfo(" . $lista->id_rpfo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				}

                $retorno["data"][] = array(
                    'RPFO' => $lista->numero_rpfo,
                    'LOCAL' => $local,
                    'STATUS' => $status,
                    'PARECER' => $lista->data_parecer,
                    'OBSERVACAO' =>  $observacao,
                    'USUARIO' => $lista->nome,
                    'ATUALIZACAO' => $lista->ultima_alteracao,
                    'ACAO' => $acao
                );
            }
        }
        else{
        $Dadosrpfo = $this->Tb_rpfo->confereAtividade($dados);
        $retorno["data"] = Array();

        if (!empty($Dadosrpfo)) {
            foreach ($Dadosrpfo as $lista) {
                $retorno["data"][] = array(
                    'ATUALIZACAO'=> $lista->ultima_alteracao,
                    'LOCAL'=> $lista->descricao_atv,
                    'OBSERVACAO'=>"-",
                    'PREVISAO'=> "-",
                    'RPFO'=>"-",
                    'PARECER'=>"-",
                    'STATUS'=>"-",
                    'USUARIO'=> $lista->DESC_NOME,
                    'ACAO' => "<a data-toggle='tooltip' title='Excluir' data-placement='top' class='btn btn-sm btn-default' href='javascript:void(0);' onclick=\"excluirRpfo({$lista->id})\">
                    <i class='fa fa-trash'></i></a>"
                );
            }
        }
    }
        echo (json_encode($retorno));
    }

//----------------------------------------------------------------------------------------------------
    public function insereNaoAtividade(){
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["idUsuario"] = $this->session->id_usuario_daq_cgop;

        $Dados = $this->Tb_rpfo->recupera($dados);
        foreach($Dados as $lista){
            $dados["id_rpfo"] = $lista->id_rpfo;
        }

        $retorno = $this->Tb_rpfo->insereNaoAtividade($dados);
        echo (json_encode($retorno));
    }
//------------------------------------------------------------------------------------------------
    public function confereAtividade(){
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["id_contrato_obra"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get('periodo');
        $dados["status"] = $this->input->post_get('status');

        $Dados = $this->Tb_rpfo->recupera($dados);
        $dados["data"] = array();

        if(!empty($Dados)){
            $dados["situacao"] = 'Com Registro';
        } else if ($Dados = $this->Tb_rpfo->confereAtividade($dados)){

           if (!empty($Dados)) {
            $dados["situacao"] = 'Sem atividade';
        }
    } else if ($v='Sem Registros'){
        $dados["situacao"] = $v;

    }
    echo (json_encode($dados));
}
//------------------------------------------------------------------------------------------------
	public function insereRpfo() {
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["numero_rpfo"] = $this->input->post_get('numero');
		$dados["data_parecer"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("parecerEmissao")))));
		$dados["desc_motivacao"] = $this->input->post_get('motivacao');
		$dados["desc_status_detalhado"] = $this->input->post_get('statusDetalhado');
		$dados["desc_analistas_responsaveis"] = $this->input->post_get('analistasResponsavel');

			if($this->Tb_rpfo->insereRpfo($dados)){
				$retorno["mensagem"] = "Cadastrado com sucesso!";
				$retorno["notify"] = "success";
			}else{
				$retorno["mensagem"] = "Não foi possível realizar o cadastro";
				$retorno["notify"] = "warning";
			}

        echo (json_encode($retorno));
	}
//------------------------------------------------------------------------------------------------------------------------
   
    public function excluiRpfo() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = unlink($arquivolocalho);
        
        echo (json_encode($retorno));
    }


//------------------------------------------------------------------------------------------------
    public function populaLocal() {
        $DadosServico = $this->Tb_rpfo->populaLocal();
        $n = 0;
        foreach ($DadosServico as $lista) {
            $dados['id_local'][$n] = $lista->id_local;
            $dados['desc_local'][$n] = str_replace("_", " ", $lista->desc_local);
            $n++;
        }
        echo (json_encode($dados));
    }

    public function populaStatus() {
        $DadosServico = $this->Tb_rpfo->populaStatus();
        $n = 0;
        foreach ($DadosServico as $lista) {
            $dados['id_status'][$n] = $lista->id_status;
            $dados['desc_status'][$n] = str_replace("_", " ", $lista->desc_status);
            $n++;
        }
        echo (json_encode($dados));
    }
//------------------------------------------------------------------------------------------------
    public function anexoRpfo() {
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $config['hostname'] = '10.100.11.158';
        $config['username'] = 'supradaq';
        $config['password'] = 'dnit@2020';
        $config['port']   = 21;
        $config['debug']  = TRUE;
        $this->ftp->connect($config);
        $arquivodestino = "/arquivos/arquivoDaq/arq/".$nome_arquivo;
        $arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
        $retorno = $this->ftp->download($arquivodestino, $arquivolocalho,'binary');  
        $this->ftp->close();

        echo (json_encode($retorno));
    }

    public function Recupera_Rpfo_edicao() {
        $dados["id_rpfo"] = $this->input->post_get('id_rpfo');
        $dados["idContrato"] = $this->session->idContrato;
        $dados["periodo"] = $this->input->post_get("periodo");
        
        $DadosServico  = $this->Tb_rpfo->recupera_Rpfo_edicao($dados);

          foreach ($DadosServico as $lista) {
      
        $dados['id_rpfo']= $lista->id_rpfo;
        $dados['numero']= $lista->numero_rpfo;
        $dados['previsao']= $lista->data_parecer;
        $dados['motivacao']= $lista->desc_motivacao;
        $dados['status_detalhado']= $lista->desc_status_detalhado;
        $dados['analista_responsavel']= $lista->desc_analistas_responsaveis;
    }
    echo (json_encode($dados));
}

    public function consultaStatusDetalhado () {
        $dados["idContrato"] = $this->session->idContrato;
        $dados["id_rpfo"] = $this->input->post_get('id_rpfo');
        $dados["periodo"] = $this->input->post_get('periodo');

        $DadosServico = $this->Tb_rpfo->consultaObservacao($dados);

        foreach ($DadosServico as $lista) {
          
            $dados['motivacao']= $lista->desc_motivacao;
            $dados['status_detalhado']= $lista->desc_status_detalhado;
            $dados['analista_responsavel']= $lista->desc_analistas_responsaveis;
        }

        echo (json_encode($dados));
    }

    public function excluirRpfo() {
        $dados["id_rpfo"] = $this->input->post_get('id_rpfo');
        $dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		if($this->Tb_rpfo->excluirRpfo($dados)){
			$retorno["mensagem"] = "Excluído com sucesso!";
			$retorno["notify"] = "success";
		}else{
			$retorno["mensagem"] = "Não foi possível excuir o anexo.";
			$retorno["notify"] = "warning";
		}

        echo (json_encode($retorno));
    }


	public function alteraRpfo() {
		$dados["id_rpfo"] = $this->input->post_get('id_rpfo');
		$dados["periodo"] = $this->input->post_get('periodo');
		$dados["idContrato"] = $this->session->idContrato;
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["id_usuario"] = $this->session->id_usuario_daq_cgop;
		$dados["numero_rpfo"] = $this->input->post_get('numero');
		$dados["data_parecer"] = date("Y-m-d", strtotime(str_replace("/", "-", ($this->input->post_get("parecerEmissao")))));
		$dados["desc_motivacao"] = $this->input->post_get('motivacao');
		$dados["desc_status_detalhado"] = $this->input->post_get('statusDetalhado');
		$dados["desc_analistas_responsaveis"] = $this->input->post_get('analistasResponsavel');

		if($this->Tb_rpfo->alteraRpfo($dados)){
			$retorno["mensagem"] = "Cadastrado com sucesso!";
			$retorno["notify"] = "success";
		}else{
			$retorno["mensagem"] = "Não foi possível realizar o cadastro";
			$retorno["notify"] = "warning";
		}

		echo (json_encode($retorno));
	}

//------------------------------------------------------------------------------------------------
	public function insereRpfoHistorico() {
		$dados["id_status"] = $this->input->post_get('status');
		$dados["id_local"] = $this->input->post_get('local');
		$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
		$dados["id_rpfo"] = $this->input->post_get('id_rpfoHistorico');

		if($this->Tb_rpfo->insereRpfoHistorico($dados)){
			$retorno["mensagem"] = "Cadastrado com sucesso!";
			$retorno["notify"] = "success";
		}else{
			$retorno["mensagem"] = "Não foi possível realizar o cadastro";
			$retorno["notify"] = "warning";
		}

		echo (json_encode($retorno));
	}

	public function rpfoRecuperaHistorico() {
		$this->session->id_prfo = $_REQUEST['id_prfo'];
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["id_rpfo"] = $_REQUEST['id_prfo'];

		$dadosHistorico = $this->Tb_rpfo->recuperaRpfoHistorico($dados["id_rpfo"]);
		$Dados = $this->Tb_rpfo->recuperaRpfo($dados);

		$retorno["data"] = Array();
		if (!empty($dadosHistorico)) {
			foreach ($dadosHistorico as $lista) {
				$observacao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='modalStatusDetalhado(". $dados["id_rpfo"].");'><i class = 'fa fa-eye'></i></button>";

				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='anexoRpfo(" . $lista->id_rpfo_historico . ");' data-toggle='tooltip' title='Inserir Anexo' data-placement='top'><i class='fa fa-paperclip'></i></button>";

				$dadosHistorico = $this->Tb_rpfo->recuperaRpfoAnexos($lista->id_rpfo_historico);
				if(empty($dadosHistorico)){
					$acao .= "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirRpfoHistorico(" . $lista->id_rpfo_historico . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				}

				$retorno["data"][] = array(
					'RPFO' => $Dados[0]->numero_rpfo,
					'LOCAL' => $lista->local,
					'STATUS' => $lista->status,
					'OBSERVACAO' =>  $observacao,
					'USUARIO' => $lista->nome,
					'ATUALIZACAO' => $lista->data_alteracao,
					'ACAO' => $acao
				);
			}
		}
		echo (json_encode($retorno));
	}
        public function rpfoInserirArquivo()
	{
		if (isset($_FILES["arquivo"])) {
			$arquivo = $_FILES["arquivo"];
			$maxsize = 1024 * 1024 * 10;
			if ($maxsize > $arquivo["size"]) {
				$extensao = @end(explode(".", $arquivo["name"]));
				if (($extensao === "xlsx") || ($extensao === "XLSX")) {
					$dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

					$nameArray = explode(".", $arquivo["name"]);

					$nName = count($nameArray) - 1;
					$name = "";
					for ($i = 0; $i < $nName; $i++) {
						$name .= $nameArray[$i] . ".";
					}

					$name = substr_replace($name, "", -1);
					$nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";

					$dados["periodo"] = $this->input->post_get('periodo');//nao tinha
					$dados["idContrato"] = $this->session->idContrato;
					$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
					$dados["nome_arquivo"] = $nomeArquivo;
					$dados["desc_arquivo"] = "Anexo_RPFO";
					$dados["nomeOriginalArquivo"] = $name;
					$dados["tipo_arquivo"] = "Excel";
					$dados["pasta_origem"] = "arquivo";
					$dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq_cgop . "_1";
					$dados["extencao"] = $extensao;
					$insert = $this->Tb_arquivo->insereArquivo($dados);
					if ($insert !== false) {
						if(move_uploaded_file($arquivo["tmp_name"], $dir . $nomeArquivo)){
                            $envioArquivoOk = true;
                        } else {
                            $envioArquivoOk = false;
                        }
					}

					if ($envioArquivoOk) {
						$dados["id_rpfo_historico"] = $this->input->post_get('id_rpfo_historico');
						$dados["id_arquivo"] = $insert;
						if ($this->Tb_rpfo->inserirArquivoHistorico($dados)) {
							$retorno["mensagem"] = "Cadastrado com sucesso!";
							$retorno["notify"] = "success";
						} else {
							$retorno["mensagem"] = "Não foi possível efetuar o cadastro.";
							$retorno["notify"] = "warning";
						}
					} else {
						$dados["mensagem"] = "Não foi possível enviar o arquivo.";
						$dados["notify"] = "warning";
					}
				} else {
					$dados["mensagem"] = "Extenção não corresponde";
					$dados["notify"] = "warning";
				}
			} else {
				$dados["mensagem"] = "Arquivo supera o limite de tamanho(5mb)";
				$dados["notify"] = "warning";
			}
		} else {
			$dados["mensagem"] = "Arquivo Vazio";
			$dados["notify"] = "warning";
		}
		echo(json_encode($retorno));
	}
	public function rpfoInserirArquivo_old_28012021_1032() {
		if (isset($_FILES["arquivo"])) {
			$arquivo = $_FILES["arquivo"];
			$maxsize = 1024 * 1024 * 10;
			if ($maxsize > $arquivo["size"]) {
				$extensao = @end(explode(".", $arquivo["name"]));
				if (($extensao === "xlsx")||($extensao === "XLSX")) {
					$dir = FCPATH . "application/homeDaq/arquivoDaq/arq/";

					$nameArray = explode(".", $arquivo["name"]);

					$nName = count($nameArray) - 1;
					$name = "";
					for ($i = 0; $i < $nName; $i++) {
						$name .= $nameArray[$i] . ".";
					}

					$name = substr_replace($name, "", -1);
					$nomeArquivo = mt_rand() . "_" . $this->session->idContrato . ".$extensao";

					$dados["periodo"] = $this->input->post_get('periodo');//nao tinha
					$dados["idContrato"] = $this->session->idContrato;
					$dados["idUsuario"] = $this->session->id_usuario_daq_cgop;
					$dados["nome_arquivo"] = $nomeArquivo;
					$dados["desc_arquivo"] = "Anexo_RPFO";
					$dados["nomeOriginalArquivo"] = $name;
					$dados["tipo_arquivo"] = "Excel";
					$dados["pasta_origem"] = "arquivo";
					$dados["id_upload"] = $this->session->idContrato . "_" . mt_rand() . "_" . $this->session->id_usuario_daq_cgop . "_1";
					$dados["extencao"] = $extensao;
					$insert = $this->Tb_arquivo->insereArquivo($dados);
					if ($insert !== false) {
						move_uploaded_file($arquivo["tmp_name"], $dir . $nomeArquivo);
					}

					/*$config['hostname'] = '10.100.11.158';
					$config['username'] = 'supradaq';
					$config['password'] = 'dnit@2020';
					$config['port']  = 21;
					$config['debug']  = TRUE;
					$this->ftp->connect($config);
					$arquivodestino = "/arquivos/arquivoDaq/arq/".$nomeArquivo;
					$arquivolocalho = ("arquivoDaq/arq/" . $nomeArquivo);*/

					if($this->ftp->upload($arquivolocalho, $arquivodestino, 'binary', 0777)){
						$dados["id_rpfo_historico"] = $this->input->post_get('id_rpfo_historico');
						$dados["id_arquivo"] = $insert;
						if($this->Tb_rpfo->inserirArquivoHistorico($dados)){
							$retorno["mensagem"] = "Cadastrado com sucesso!";
							$retorno["notify"] = "success";
						}else{
							$retorno["mensagem"] = "Não foi possível efetuar o cadastro.";
							$retorno["notify"] = "warning";
						}
						unlink($arquivolocalho);
					} else{
						$dados["mensagem"] = "Não foi possível enviar o arquivo.";
						$dados["notify"] = "warning";
					}

					$this->ftp->close();

				} else {
					$dados["mensagem"] = "Extenção não corresponde";
					$dados["notify"] = "warning";
				}
			} else {
				$dados["mensagem"] = "Arquivo supera o limite de tamanho(5mb)";
				$dados["notify"] = "warning";
			}
		} else {
			$dados["mensagem"] = "Arquivo Vazio";
			$dados["notify"] = "warning";
		}
		echo (json_encode($retorno));
	}

	public function rpfoRecuperaAnexo() {
		$dados["idContrato"] = $this->session->idContrato;
		$dados["id_contrato_obra"] = $this->session->idContrato;
		$dados["id_rpfo_historico"] = $_REQUEST['id_prfoHistorico'];

		$dadosHistorico = $this->Tb_rpfo->recuperaRpfoAnexos($dados["id_rpfo_historico"]);
		$retorno["data"] = Array();
		if (!empty($dadosHistorico)) {
			foreach ($dadosHistorico as $lista) {

				$acao = "<button type='button' class='btn btn-default' href='javascript:void(0);' onclick='excluirAnexo(" . $lista->id_rpfo_anexo . ");' data-toggle='tooltip' title='Excluir' data-placement='top'><i class='fa fa-trash'></i></button>";
				//$arquivo = "<a href='javascript:void(0);' onclick=\"anexoHistorico('{$lista->nome_arquivo}')\">" . $lista->nomeOriginalArquivo . "</a>";
                                $path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $lista->nome_arquivo);
                                $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nomeArquivo . "<a>";
				$retorno["data"][] = array(
					'RPFO' => $this->session->id_prfo,
					'ARQUIVO' => $arquivo,
					'USUARIO' => $lista->nome,
					'ATUALIZACAO' => $lista->data_inclusao,
					'ACAO' => $acao
				);
			}
		}
		echo (json_encode($retorno));
	}

	public function anexoGeo() {
		$nome_arquivo = $this->input->post_get('nome_arquivo');
		$config['hostname'] = '10.100.11.158';
		$config['username'] = 'supradaq';
		$config['password'] = 'dnit@2020';
		$config['port']   = 21;
		$config['debug']  = TRUE;
		$this->ftp->connect($config);
		$arquivodestino = "/arquivos/arquivoDaq/arq/".$nome_arquivo;
		$arquivolocalho = ("arquivoDaq/arq/" . $nome_arquivo);
		$retorno = $this->ftp->download($arquivodestino, $arquivolocalho,'binary');
		$this->ftp->close();

		echo (json_encode($retorno));
	}

	public function excluirRpfoHistorico(){
		if($this->Tb_rpfo->excluirHistorico($_REQUEST['id_rpfoHistorico'])){
			$retorno["mensagem"] = "Excluído com sucesso!";
			$retorno["notify"] = "success";
		}else{
			$retorno["mensagem"] = "Não foi possível excuir o histórico.";
			$retorno["notify"] = "warning";
		}
		echo (json_encode($retorno));
	}

	public function excluirRpfoAnexo(){
		if($this->Tb_rpfo->excluirAnexo($_REQUEST['id_rpfo_anexo'])){
			$retorno["mensagem"] = "Excluído com sucesso!";
			$retorno["notify"] = "success";
		}else{
			$retorno["mensagem"] = "Não foi possível excuir o anexo.";
			$retorno["notify"] = "warning";
		}
		echo (json_encode($retorno));

	}
        public function modelorpfouuu(){
        $nome_arquivo = 'Modelo_RPFO.xlsx';
        $path_arq = base_url('index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $nome_arquivo);
        $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nome_arquivo . "<a>";
        echo (json_encode($arquivo));
    }
    public function modelorpfo(){
        $nome_arquivo = $this->input->post_get('nome_arquivo');
        $path_arq = base_url('/index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' . $nome_arquivo);
        $arquivo = "<a download href=".$path_arq." target='_blank'>" . $nome_arquivo . "<a>";
        echo (json_encode($arquivo));
    }
}//fecha classe
 // * DNIT-SUPRA
 // * Programador: Jordana Alencar
 // * Data: 01/11/19
