<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tb_rnc extends CI_Model {

    public function __construct()
    {
        parent ::__construct();
        $this->db = $this->load->database('DAQ', TRUE); 
    }

   //---------------------------------------Select-------------------------------------------
    public function populaTipoEixo(){
        $this->db->select("*");
        $this->db->from("CGOB_TB_CONFIG_ITEM_EIXO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function populaGravidade(){
        $this->db->select("*");
        $this->db->from("CGOB_TB_RNC_ITEM_GRAVIDADE");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function populaNatureza(){
        $this->db->select("*");
        //$this->db->from("CGOB_TB_RNC_ITEM_NATUREZA");
        $this->db->from("CGOB_TB_OBRA");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function populaObra(){
        $this->db->select("*");
        $this->db->from("CGOB_TB_RNC_ITEM_OBRA");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }

    public function populaPavimento(){
        $this->db->select("*");
        $this->db->from("CGOB_TB_RNC_ITEM_PAVIMENTO");
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
 
//-------------------------------------------------------------------------------------------------------
    public function insereRnc($dados){
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("id_gravidade", $dados["grau"]);
        $this->db->set("data_registro", $dados["data_atividade"]);
        $this->db->set("nome_eixo", $dados["tipoEixo"]);
        $this->db->set("km", $dados["km"]);
        $this->db->set("latitude", $dados["latitude"]);
        $this->db->set("longitude", $dados["longitude"]);
        if ($dados['data_atualizacao'] != '1969-12-31') {
            $this->db->set("data_atualizacao", $dados["data_atualizacao"]);
            }
        if ($dados['data_fechamento'] != '1969-12-31') {
            $this->db->set("data_fechamento", $dados["data_fechamento"]);
            }
            // if(!empty($dados['data_atualizacao'])){
            //     $this->db->set("data_atualizacao", $dados['data_atualizacao']);
            // }
        $this->db->set("descricao", $dados["status_detalhado"]);
        $this->db->set("sugestao_providencia", $dados["sugestao_providencia"]);
        $this->db->set("id_usuario", $dados["id_usuario"]);
        $this->db->set("data_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("publicar", "S");
        $this->db->set('flag_atividade', 'S');
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_RNC");

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------
    public function recuperaRNC($dados){
        $SQL = "
        SELECT 
        rnc.nome_eixo, 
        rnc.id_rnc, 
        rnc.km, 
        grau.desc_gravidade, 
        (SELECT id_providencia from CGOB_TB_RNC_PROVIDENCIA WHERE id_rnc = rnc.id_rnc) id_providencia,
        (SELECT situacao_providencia from CGOB_TB_RNC_PROVIDENCIA WHERE id_rnc = rnc.id_rnc) situacao_providencia,  
        (SELECT 
        CASE WHEN ( (prov.situacao_providencia IS NULL) OR (prov.situacao_providencia = 'Aberto') ) THEN 'Aberto'
        ELSE 'Fechado' END as status 
        FROM CGOB_TB_RNC_PROVIDENCIA as prov where prov.id_rnc = rnc.id_rnc) status, 
        convert(varchar(10),rnc.data_atualizacao,103) AS data_atualizacao, 
        convert(varchar(10),rnc.periodo_referencia,103) AS periodo, 
        (SELECT desc_nome from TB_USUARIO WHERE id_usuario = rnc.id_usuario) usuario, 
        concat(CONVERT(CHAR(10), rnc.data_alteracao , 103),' ', CONVERT(CHAR(8), rnc.data_alteracao , 114)) AS ultima_alteracao, 
        (SELECT count(foto.id_rnc) FROM CGOB_TB_RNC_FOTO as foto WHERE foto.id_rnc = rnc.id_rnc AND foto.publicar = 'S') foto 
        FROM CGOB_TB_RNC as rnc 
        INNER JOIN CGOB_TB_RNC_ITEM_GRAVIDADE as grau ON grau.id_gravidade = rnc.id_gravidade
        FULL OUTER JOIN CGOB_TB_RNC_PROVIDENCIA as prov on prov.id_rnc = rnc.id_rnc 
        WHERE rnc.publicar = 'S' AND rnc.id_contrato_obra =" .$dados['idContrato']. "
        AND rnc.periodo_referencia='" . $dados["periodo"] . "' 

        ";
//        if (($dados["status"] == "periodoReferencia")) {
//            $SQL .= " AND rnc.periodo_referencia = ('" . $dados["periodo"] . "')";
//        }
        if (($dados["status"] == "Aberto")) {
            $SQL .= " AND prov.situacao_providencia = ('" . $dados["status"] . "') OR prov.situacao_providencia IS NULL ";
        }
        if (($dados["status"] == "Fechado")) {
            $SQL .= " AND prov.situacao_providencia = ('" . $dados["status"] . "') ";
        }
        $SQL .= " ORDER BY rnc.data_alteracao DESC";

        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------
    public function excluirRNC($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_rnc", $dados['id_rnc']);
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->set("publicar", "N");
        $this->db->set("flag_atividade", "N");
        $this->db->set("data_publicar", date("Y-m-d H:i:s"));
        $this->db->update("CGOB_TB_RNC");

        $this->db->where("id_rnc", $dados['id_rnc']);
        $this->db->where("id_providencia", $dados['id_providencia']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->set("situacao_providencia", "Aberto");
        $this->db->update("CGOB_TB_RNC_PROVIDENCIA");

        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------
    public function excluiratividade($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_rnc", $dados['id_rnc']);
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->set("publicar", "N");
        $this->db->set("flag_atividade", "N");
        $this->db->set("data_publicar", date("Y-m-d H:i:s"));
        $this->db->update("CGOB_TB_RNC");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------
    public function recupera($dados){
        $SQL = "
        SELECT
        rnc.id_rnc
        FROM CGOB_TB_RNC AS rnc
        WHERE (rnc.publicar like '%S%' OR rnc.publicar = 'S') and rnc.id_contrato_obra=". $dados['id_contrato_obra'] ."  AND flag_atividade = 'S'
        AND rnc.periodo_referencia='" . $dados["periodo"] . "'
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

//-------------------------------------------------------------------------------------------------------
    public function insereNaoAtividade($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->set('id_contrato_obra', $dados['id_contrato_obra']);
        if (!empty($dados["id_rnc"])) {
            $this->db->set("id_rnc", $dados["id_rnc"]);
        }
        $this->db->set('periodo_referencia', $dados['periodo']);
        $this->db->set('publicar', 'S');
        $this->db->set('flag_atividade', 'N');
        $this->db->set('descricao', 'Não houve Atualização');
        $this->db->set("data_alteracao", date("Y-m-d H:i:s"));
        $this->db->set('id_usuario', $dados['idUsuario']);
        $this->db->insert("CGOB_TB_RNC");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------
    public function confereAtividade($dados){
        $SQL = "
        SELECT rnc.id_rnc,
			   rnc.id_rnc as id,
			   rnc.descricao,
			   usu.desc_nome AS usuario,
			   concat(CONVERT(CHAR(10), rnc.data_alteracao, 103), ' ',
					  CONVERT(CHAR(8), rnc.data_alteracao, 114))  AS ultima_alteracao
		FROM CGOB_TB_RNC as rnc
		INNER JOIN TB_USUARIO as USU
			ON USU.id_usuario = rnc.id_usuario
        WHERE rnc.id_contrato_obra=". $dados['id_contrato_obra'] ." 
        	and rnc.flag_atividade = 'N' 
        	and rnc.publicar = 'S'";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------
    public function consultaSugestao($dados){
        $SQL = "
        SELECT 
        p.id_rnc,
        p.id_providencia,
        p.descricao_providencia,
        p.providencia,
        convert(varchar(10),p.data_atualizacao,103) AS data_atualizacao,
        (SELECT desc_nome from TB_USUARIO WHERE id_usuario = p.id_usuario) usuario,
        concat( CONVERT(CHAR(10), p.ultima_alteracao , 103),' ', CONVERT(CHAR(8), p.ultima_alteracao , 114)) AS ultima_alteracao
        FROM CGOB_TB_RNC_PROVIDENCIA as p
        WHERE p.publicar = 'S'  and p.id_rnc = " .$dados['id_rnc']. " 
        AND p.id_contrato_obra =" .$dados['idContrato']. " 
        ";

        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------
    public function insereProvidencia($dados){
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("id_rnc", $dados["id_rnc"]);
        $this->db->set("id_usuario", $dados["id_usuario"]);
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->set("data_atualizacao", $dados["data_atualizacao"]);
        $this->db->set("data_fechamento", $dados["data_fechamento"]);
        $this->db->set("descricao_providencia", $dados["descricao_providencia"]);
        $this->db->set("providencia", $dados["providencia"]);
        $this->db->set("situacao_providencia", "Fechado");
        $this->db->set("publicar", "S");
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        
        $this->db->insert("CGOB_TB_RNC_PROVIDENCIA");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }

    }
//-------------------------------------------------------------------------------------------------------
    public function alteraProvidencia($dados){
        $this->db->where("id_contrato_obra", $dados["idContrato"]);
        $this->db->where("id_rnc", $dados["id_rnc"]);
        $this->db->set("id_usuario", $dados["id_usuario"]);
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->set("data_atualizacao", $dados["data_atualizacao"]);
        $this->db->set("data_fechamento", $dados["data_fechamento"]);
        $this->db->set("descricao_providencia", $dados["descricao_providencia"]);
        $this->db->set("providencia", $dados["providencia"]);
        $this->db->set("situacao_providencia", "Fechado");
        $this->db->set("publicar", "S");
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        
        $this->db->update("CGOB_TB_RNC_PROVIDENCIA");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------
    public function consultaProvidencia($dados){
        $SQL = "
        SELECT 
        id_rnc,
        id_providencia
        FROM CGOB_TB_RNC_PROVIDENCIA 
        WHERE (publicar = 'N' OR publicar = 'S') AND id_rnc =" .$dados['id_rnc']. " 
        AND id_contrato_obra =" .$dados['idContrato']. " 
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------
    public function excluirProvidencia($dados){
        $this->db->where("id_providencia", $dados['id_providencia']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->set("situacao_providencia", "Aberto");
        $this->db->update("CGOB_TB_RNC_PROVIDENCIA");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------
    public function RecuperaFotos($dados){
        $SQL = "
        SELECT
        ft.id_rnc_foto,
        ft.id_contrato_obra,
        ft.id_rnc,
        ft.id_arquivo,
        a.nome_arquivo,
        a.nomeOriginalArquivo,
        ft.descricao_foto as descricao,
        convert(varchar(10),ft.data_atualizacao,103) AS data_atualizacao,
        (SELECT desc_nome from TB_USUARIO WHERE id_usuario = ft.id_usuario) usuario,
        concat( CONVERT(CHAR(10), ft.ultima_alteracao , 103),' ', CONVERT(CHAR(8), ft.ultima_alteracao , 114)) AS ultima_alteracao
        FROM CGOB_TB_ARQUIVO AS a
        INNER JOIN CGOB_TB_RNC_FOTO AS ft ON ft.id_arquivo = a.id_arquivo AND ft.id_rnc='" . $dados["id_rnc"] . "'
        WHERE ft.publicar = 'S'  
        AND ft.id_contrato_obra=" . $dados["idContrato"] . "
        ";
//echo('<pre>');
//die($SQL);
        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------
    public function fotos($dados){
        $SQL = "
        SELECT 
        ft.id_rnc,
        ft.id_rnc_foto,
        ft.id_contrato_obra,
        ft.id_arquivo,
        a.nomeOriginalArquivo,
        a.desc_arquivo,
        a.pasta_origem
        FROM CGOB_TB_RNC_FOTO AS ft
        INNER JOIN CGOB_TB_ARQUIVO AS a ON ft.id_arquivo = a.id_arquivo
        AND ft.id_contrato_obra=" . $dados["idContrato"] . "
        AND ft.id_rnc='" . $dados["id_rnc"] . "'  
        ";
        $query = $this->db->query($SQL);
        return $query->result();
    }
//-------------------------------------------------------------------------------------------------------
    public function insereFoto($dados){
        $this->db->set("id_rnc", $dados["id_rnc"]);
        $this->db->set("id_contrato_obra", $dados["idContrato"]);
        $this->db->set("id_arquivo", $dados["id_arquivo"]);
        $this->db->set("id_usuario", $dados["idUsuario"]);
        $this->db->set("descricao_foto", $dados["descricao_foto"]);
        $this->db->set("data_atualizacao", $dados["dta_atualizacao"]);
        $this->db->set("id_rnc", $dados["id_rnc"]);
        $this->db->set("publicar", "S");
        $this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
        $this->db->set("periodo_referencia", $dados["periodo"]);
        $this->db->insert("CGOB_TB_RNC_FOTO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return $this->db->insert_id();
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
//-------------------------------------------------------------------------------------------------------
    public function excluirFoto($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $this->db->where("id_rnc_foto", $dados['id_rnc_foto']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_RNC_FOTO");

        $this->db->where("id_arquivo", $dados['id_arquivo']);
        $this->db->set("publicar", "N");
        $this->db->set("data_publicacao", date("Y-m-d H:i:s"));
        $this->db->set("id_usuario_publicar", $dados['id_usuario']);
        $this->db->update("CGOB_TB_ARQUIVO");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }

    }

    public function imprimirRnc($dados){
        $SQL = "
        SELECT 
        cs.nu_con_formatado,
        rnc.latitude,
        rnc.longitude, 
        grau.desc_gravidade,
        rnc.km,
        rnc.descricao, 
        rnc.sugestao_providencia, 
        'Canal de Navegação' as desc_tipo_eixo,
        convert(varchar(10),rnc.data_registro,103) AS data_registro, 
        CASE WHEN  (prov.situacao_providencia IS NULL or prov.situacao_providencia like '' OR prov.situacao_providencia = 'Aberto')  THEN 'Aberto' 
        ELSE 'Fechado' 
        END as status, 
        (select prov.providencia from CGOB_TB_RNC_PROVIDENCIA where id_providencia =(select max (id_providencia) from CGOB_TB_RNC_PROVIDENCIA where (publicar like '%S%' or publicar is NULL) AND id_contrato_obra =" .$dados['idContrato']. " AND periodo_referencia='" . $dados["periodo"] . "')) providencia

       
        
        FROM CGOB_TB_RNC as rnc 
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
    public function RecuperaFotosImp($dados){
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
//-------------------------------------------------------------------------------------------------------


}//classe
