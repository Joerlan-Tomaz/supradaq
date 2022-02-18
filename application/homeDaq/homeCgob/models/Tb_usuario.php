<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Tb_usuario extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('DAQ', TRUE);
	}

	public function populaPerfil()
	{
		$SQL = "SELECT *
            FROM TB_PERFIL u 
            ORDER BY desc_perfil";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function populaSupervisora()
	{
		$this->db->select("*");
		$this->db->where("grupo", "SUPERVISORA");
		$this->db->from("TB_SUPERVISORA");
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

	public function validar_login($email, $senha)
	{
		$SQL = "
            SELECT 
                u.empresa,
                u.fechar_relatorio,
                u.flag_primeiro_acesso,
                u.ID_PERFIL,
                u.ID_PERFIL_DAQ,
                 (select coordenacao from tb_perfil where id_perfil=u.ID_PERFIL) coordenacao,
                 (select desc_perfil from tb_perfil where id_perfil=u.ID_PERFIL_DAQ) perfil_usuario,
                u.CODI_SENHA,
                u.DESC_NOME,
                u.ID_USUARIO,
                u.id_uf,
                CONCAT (CONVERT(VARCHAR(10),u.data_ultimoacesso, 1),' ',CONVERT(VARCHAR(10), u.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO,
                u.FLAG_ALTERASENHA,
                u.email
            FROM tb_usuario u 
            WHERE email LIKE '$email'
            AND CODI_SENHA = '$senha'";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function validar_email($email)
	{
		$SQL = "
            SELECT                
                email 
            FROM tb_usuario 
            WHERE email like '%$email%'
            ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function buscaUsuario($dados)
	{
		$SQL = "
            SELECT 
                u.empresa,
                u.fechar_relatorio,
                u.flag_primeiro_acesso,
                u.ID_PERFIL,
            	(select coordenacao from tb_perfil where id_perfil=u.ID_PERFIL) coordenacao,
                (select desc_perfil from tb_perfil where id_perfil=u.ID_PERFIL_DAQ) perfil_usuario,
                u.CODI_SENHA,
                u.DESC_NOME,
                u.ID_USUARIO,
                u.ID_PERFIL_DAQ,
                u.ID_PERFIL_DIF,
                CONCAT (CONVERT(VARCHAR(10),u.data_ultimoacesso, 103),' ',CONVERT(VARCHAR(10), u.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO
                ,u.FLAG_ALTERASENHA
                ,u.email 
                ,u.cpf
                ,u.TELEFONE
                ,u.id_organizador
                ,u.id_uf
                ,(SELECT TOP 1 ONLINE from TB_HISTORICOLOGIN WHERE ID_USUARIO = u.id_usuario order by ID_HISTORICOLOGIN desc) as online
                ,(select telefone FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario) ) as telefone_adicional
                ,(select titulo FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario)) as titularidade
                ,(select formacao FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario)) as formacao
				,(select area_atuacao FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario) ) as area_atuacao
				,(select localizacao FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario) ) as localizacao
				,(select nota FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario) ) as curriculo_resumido
				,(select foto FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario) ) as foto
				,(select id_upload FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario AND id_usuarioperfil = (select MAX(id_usuarioperfil) FROM TB_USUARIO_PERFIL WHERE id_usuario = u.id_usuario) ) as id_upload
            FROM tb_usuario u 
            WHERE u.ID_USUARIO = " . $dados["id_usuario"];
               // echo('<pre>');
               // die($SQL);
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaQtdMensagem()
	{
		$SQL = "        
                SELECT
                    COUNT(s.flag_lido) qtdMensagem
                    FROM 
                    MSG_SAIDA s 
                    where s.flag_lido='N' AND S.id_destinatario = " . $this->session->id_usuario_daq . "
                    and s.id_roteiro=2 
                group by s.id_destinatario,s.flag_lido

            union all

                SELECT
                    COUNT(r.flag_lido) resposta
                    FROM 
                    MSG_RESPOSTA r 
                    where r.flag_lido='N' AND r.id_destinatario = " . $this->session->id_usuario_daq . " 
                group by r.id_destinatario,r.flag_lido";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaFotoUsuario()
	{
		$SQL = "
        SELECT 
            id_upload
        FROM 
        TB_USUARIO_PERFIL U 
        WHERE id_usuario = " . $this->session->id_usuario_daq . "
            AND id_upload is not null 
            AND id_usuarioperfil = (select MAX(id_usuarioperfil) 
                                    FROM TB_USUARIO_PERFIL WHERE id_usuario =  U.id_usuario
                                    AND id_upload is not null)";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function insereUsuario($dados)
	{
		$this->db->set("CODI_SENHA", md5(0001));
		$this->db->set("DESC_NOME", $dados['nome']);
		$this->db->set("EMAIL", $dados["email"]);
		$this->db->set("TELEFONE", $dados["telefone"]);
		$this->db->set("FLAG_ALTERASENHA", "N");
		$this->db->set("FLAG_PRIMEIRO_ACESSO", "N");
		$this->db->set("cpf", $dados["cpf"]);
		$this->db->set("empresa", $dados["empresa"]);
		$this->db->set("id_uf", $dados["id_uf"]);
		$this->db->insert("TB_USUARIO");
		return true;
	}

	public function buscaUsuarios()
	{
		$SQL = "
            SELECT
                usuario.id_usuario
                ,usuario.ID_PERFIL
                ,perfilUsuario.desc_perfil
                ,sup.supervisora
                ,usuario.fechar_relatorio
                ,usuario.retificar_relatorio
                ,sup.id_supervisora
                ,DESC_NOME
                ,CODI_SENHA
                ,EMAIL
                ,empresa
                ,perfilRPFO.id_perfil AS id_perfil_rpfo
                ,perfil.desc_perfil AS desc_perfil_rpfo
                ,cpf
                ,TELEFONE
                ,FLAG_ALTERASENHA
                ,CONCAT (CONVERT(VARCHAR(10),usuario.data_ultimoacesso, 103),' ',CONVERT(VARCHAR(10), usuario.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO
                ,online.timestamp
                ,online.prazoSenha
                ,(CASE 
                    WHEN ((online.timestamp + 3600) < " . time() . "  or online.timestamp is null)  then 'N'  
                    WHEN ((online.timestamp + 600) > " . time() . " )  then 'S'
                    WHEN ((online.timestamp + 600) < " . time() . " AND (online.timestamp + 3600) > " . time() . ")  then 'A'
		END) AS online
            FROM TB_USUARIO AS usuario

            LEFT JOIN rpfo_perfil_usuario AS perfilRPFO
            ON usuario.id_usuario = perfilRPFO.id_usuario_rpfo

            LEFT JOIN TB_PERFIL AS perfil
            ON perfil.id_perfil = perfilRPFO.id_perfil
            
            LEFT JOIN TB_PERFIL AS perfilUsuario
            ON perfilUsuario.id_perfil = usuario.ID_PERFIL
            
            LEFT JOIN TB_USUARIO_ONLINE AS online
            ON online.id_usuario = usuario.id_usuario
            
            LEFT JOIN TB_SUPERVISORA AS sup
            ON usuario.id_supervisora = sup.id_supervisora
        ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function validaSenha($dados)
	{
		$SQL = "
            SELECT 
                u.empresa,
                u.fechar_relatorio,
                u.flag_primeiro_acesso,
                u.ID_PERFIL,
                u.CODI_SENHA,
                u.DESC_NOME,
                u.ID_USUARIO,
                CONCAT (CONVERT(VARCHAR(10),u.data_ultimoacesso, 1),' ',CONVERT(VARCHAR(10), u.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO,
                u.FLAG_ALTERASENHA
                ,u.email 
            FROM tb_usuario u 
            WHERE u.ID_USUARIO = '" . $dados["id_usuario"] . "' 
            AND CODI_SENHA = '" . $dados["edtAtual"] . "'";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function alteraSenha($dados)
	{
		$this->db->where("ID_USUARIO", $dados['id_usuario']);
		$this->db->set("CODI_SENHA", $dados["senhaNova"]);
		$this->db->set("FLAG_ALTERASENHA", "N");
		$this->db->update("TB_USUARIO");
		return true;
	}

	public function historicoLogin()
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->set("id_usuario", $this->session->id_usuario_daq);
		$this->db->set("NUME_IP", $this->input->ip_address());
		$this->db->set("DATA_HISTORICOLOGIN", date("Y-m-d H:i:s"));
		$this->db->set("ONLINE", "S");
		$this->db->insert("TB_HISTORICOLOGIN");
		return true;
	}

	public function alteraUltimoAcesso()
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_usuario", $this->session->id_usuario_daq);
		$this->db->set("DATA_ULTIMOACESSO", date("Y-m-d H:i:s"));
		$this->db->update("TB_USUARIO");
		return true;
	}

	public function finalizaSessao($dados)
	{
		$SQL = "
            UPDATE TB_HISTORICOLOGIN
                SET DATA_HISTORICOFIMLOGIN = '" . $dados["data"] . "', 
                ONLINE = 'N' 
                WHERE ID_HISTORICOLOGIN = (SELECT MAX(ID_HISTORICOLOGIN) FROM TB_HISTORICOLOGIN WHERE ID_USUARIO = " . $this->session->id_usuario_daq . ")
                ";
		$query = $this->db->query($SQL);
		// return (json_encode($query->result(), true));
		// return $sql;
	}

	public function insereSobreMim($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');

		$this->db->set("id_usuario", $dados['id_usuario']);
		$this->db->set("telefone", $dados['telefone']);
		$this->db->set("formacao", $dados['formacao']);
		$this->db->set("titulo", $dados['titularidade']);
		$this->db->set("area_atuacao", $dados['area_atuacao']);
		$this->db->set("localizacao", $dados['localizacao']);
		$this->db->set("nota", $dados['curriculo_resumido']);
		$this->db->set("foto", $dados['foto']);
		$this->db->set("id_upload", $dados['id_upload']);
		$this->db->set("data_cadastro", date("Y-m-d H:i:s"));

		$this->db->insert("TB_USUARIO_PERFIL");
		return true;
	}

	public function alteraSobreMim($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_usuario", $dados['id_usuario']);
		$this->db->set("telefone", $dados['telefone']);
		$this->db->set("formacao", $dados['formacao']);
		$this->db->set("titulo", $dados['titularidade']);
		$this->db->set("area_atuacao", $dados['area_atuacao']);
		$this->db->set("localizacao", $dados['localizacao']);
		$this->db->set("nota", $dados['curriculo_resumido']);
		if (!empty($dados['foto'])) {
			$this->db->set("foto", $dados['foto']);
			$this->db->set("id_upload", $dados['id_upload']);
		}
		$this->db->set("data_cadastro", date("Y-m-d H:i:s"));
		$this->db->update("TB_USUARIO_PERFIL");
		return true;
	}

	public function RecuperaLinhaTempo()
	{
		$SQL = "
        SELECT 
                rel.supervisora,fiscal,motivo,idrelatorio,aceite,id,rel.id_contrato_obra,data as data_cadastro,nome,roteiro, c.contrato
                , CASE
                    WHEN roteiro = 'Resumo'                         THEN 1
                    WHEN roteiro = 'Apresentacao_Supervisora'       THEN 2
                    WHEN roteiro = 'Atividade_Executada'            THEN 3
                    WHEN roteiro = 'RELACAO SUPERVISORA'            THEN 4
                    WHEN roteiro = 'Apresentacao_Construtora'       THEN 5
                    WHEN roteiro = 'AVANCO FISICO'                  THEN 6
                    WHEN roteiro = 'OAE'                            THEN 7
                    WHEN roteiro = 'INTERFERENCIA'                  THEN 8
                    WHEN roteiro = 'RPFO'                           THEN 9
                    WHEN roteiro = 'Resumo_Projeto'                 THEN 10
                    WHEN roteiro = 'RELACAO CONSTRUTORA'            THEN 11
                    WHEN roteiro = 'Servicos_Executados'            THEN 12
                    WHEN roteiro = 'Atividade_Critica'              THEN 13
                    WHEN roteiro = 'RNC'                            THEN 14
                    WHEN roteiro = 'Documentacao_Fotografica'       THEN 15
                    WHEN roteiro = 'Diario_Obra'                    THEN 16
                    WHEN roteiro = 'Ensaio_Laboratorio'             THEN 17
                    WHEN roteiro = 'Controle pluviometrico'         THEN 18
                    WHEN roteiro = 'Componente_Ambiental'           THEN 19
                    WHEN roteiro = 'Conclusao_Comentario'           THEN 20
                    WHEN roteiro = 'Atas_Correspondencias'          THEN 21
                    WHEN roteiro = 'Conclusao_Geral_Empreendimento' THEN 22
                    WHEN roteiro = 'Anexo_Supervisao'               THEN 23
                    WHEN roteiro = 'Termo_Encerramento'             THEN 24
                    WHEN roteiro = 'Anexo_Art'                      THEN 25
                    WHEN roteiro = 'Georeferenciamento'             THEN 26
                    WHEN roteiro = 'Licenca_Ambiental'              THEN 27
                    end 'id_roteiro'

        FROM (
            SELECT
                (select supervisora  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=r.roteiro))supervisora,
                (select fiscal  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=r.roteiro))fiscal,
                (select motivo  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=r.roteiro))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=r.roteiro))idrelatorio,
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=r.roteiro))aceite 
                ,r.id_resumo id
                ,r.id_contrato_obra
                ,r.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = r.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), r.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), r.ultima_alteracao, 114)
                    ) AS DATA
                ,r.roteiro
            FROM tb_resumo r
            WHERE r.id_resumo = (
                    SELECT max(id_resumo)
                    FROM tb_resumo
                    WHERE roteiro = r.roteiro
                        AND periodo_referencia = r.periodo_referencia
                        AND id_contrato_obra = r.id_contrato_obra
                    )
            
            UNION
            
            SELECT 
                (select supervisora  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=fs.id_contrato_obra and periodo_referencia=fs.periodo_referencia and modulo=('RELACAO SUPERVISORA')))supervisora,
                (select fiscal  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=fs.id_contrato_obra and periodo_referencia=fs.periodo_referencia and modulo=('RELACAO SUPERVISORA')))fiscal,
                (select motivo  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=fs.id_contrato_obra and periodo_referencia=fs.periodo_referencia and modulo=('RELACAO SUPERVISORA')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=fs.id_contrato_obra and periodo_referencia=fs.periodo_referencia and modulo=('RELACAO SUPERVISORA')))idrelatorio, 
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=fs.id_contrato_obra and periodo_referencia=fs.periodo_referencia and modulo=('RELACAO SUPERVISORA')))aceite  
                ,fs.id_funcionario_supervisora
                ,fs.id_contrato_obra
                ,fs.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = fs.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), ultima_alteracao, 114)
                    ) AS DATA
                ,'4'
            FROM TB_FUNCIONARIO_SUPERVISORA fs
            WHERE fs.id_funcionario_supervisora = (
                    SELECT max(id_funcionario_supervisora)
                    FROM TB_FUNCIONARIO_SUPERVISORA
                    WHERE periodo_referencia = fs.periodo_referencia
                        AND id_contrato_obra = fs.id_contrato_obra
                    )
            
            UNION
            
            SELECT
                (select supervisora from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=a.id_contrato_obra and periodo_referencia=a.periodo_referencia and modulo=('AVANCO FISICO')))supervisora,
                (select fiscal from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=a.id_contrato_obra and periodo_referencia=a.periodo_referencia and modulo=('AVANCO FISICO')))fiscal,
                (select motivo from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=a.id_contrato_obra and periodo_referencia=a.periodo_referencia and modulo=('AVANCO FISICO')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=a.id_contrato_obra and periodo_referencia=a.periodo_referencia and modulo=('AVANCO FISICO')))idrelatorio, 
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=a.id_contrato_obra and periodo_referencia=a.periodo_referencia and modulo=('AVANCO FISICO')))aceite 
                ,a.id_avanco_fisico
                ,a.id_contrato_obra
                ,a.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = a.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), a.ultima_atualizacao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), a.ultima_atualizacao, 114)
                    ) AS DATA
                ,'6'
            FROM TB_AVANCO_FISICO a
            WHERE a.id_avanco_fisico = (
                    SELECT max(id_avanco_fisico)
                    FROM TB_AVANCO_FISICO
                    WHERE periodo_referencia = a.periodo_referencia
                        AND id_contrato_obra = a.id_contrato_obra
                    )
            
            UNION
            
            SELECT
                (select supervisora from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=o.id_contrato_obra and periodo_referencia=o.periodo_referencia and modulo=('OAE')))supervisora, 
                (select fiscal from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=o.id_contrato_obra and periodo_referencia=o.periodo_referencia and modulo=('OAE')))fiscal,
                (select motivo from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=o.id_contrato_obra and periodo_referencia=o.periodo_referencia and modulo=('OAE')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=o.id_contrato_obra and periodo_referencia=o.periodo_referencia and modulo=('OAE')))idrelatorio,
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=o.id_contrato_obra and periodo_referencia=o.periodo_referencia and modulo=('OAE')))aceite  
                ,o.id_oae
                ,o.id_contrato_obra
                ,o.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = o.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), o.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), o.ultima_alteracao, 114)
                    ) AS DATA
                ,'7'
            FROM tb_oae o
            WHERE o.id_oae = (
                    SELECT max(id_oae)
                    FROM TB_OAE
                    WHERE periodo_referencia = o.periodo_referencia
                        AND id_contrato_obra = o.id_contrato_obra
                    )
            
            UNION
            
            SELECT
                (select motivo from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=i.id_contrato_obra and periodo_referencia=i.periodo_referencia and modulo=('INTERFERENCIA')))supervisora,
                (select fiscal from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=i.id_contrato_obra and periodo_referencia=i.periodo_referencia and modulo=('INTERFERENCIA')))fiscal,
                (select motivo from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=i.id_contrato_obra and periodo_referencia=i.periodo_referencia and modulo=('INTERFERENCIA')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=i.id_contrato_obra and periodo_referencia=i.periodo_referencia and modulo=('INTERFERENCIA')))idrelatorio,
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=i.id_contrato_obra and periodo_referencia=i.periodo_referencia and modulo=('INTERFERENCIA')))aceite  
                ,i.id_interferencia
                ,i.id_contrato_obra
                ,i.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = i.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), i.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), i.ultima_alteracao, 114)
                    ) AS DATA
                ,'8'
            FROM tb_interferencia i
            WHERE i.id_interferencia = (
                    SELECT max(id_interferencia)
                    FROM TB_interferencia
                    WHERE periodo_referencia = i.periodo_referencia
                        AND id_contrato_obra = i.id_contrato_obra
                    )
            
            UNION
            
            SELECT
                (select supervisora from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=('RPFO')))supervisora,
                (select fiscal from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=('RPFO')))fiscal,
                (select motivo from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=('RPFO')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=('RPFO')))idrelatorio, 
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=r.id_contrato_obra and periodo_referencia=r.periodo_referencia and modulo=('RPFO')))aceite 
                ,r.id_rpfo
                ,r.id_contrato_obra
                ,r.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = r.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), r.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), r.ultima_alteracao, 114)
                    ) AS DATA
                ,'9'
            FROM tb_rpfo r
            WHERE r.id_RPFO = (
                    SELECT max(id_rpfo)
                    FROM TB_rpfo
                    WHERE periodo_referencia = r.periodo_referencia
                        AND id_contrato_obra = r.id_contrato_obra
                    )
            
            UNION
            
            SELECT
                (select supervisora from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=ro.id_contrato_obra and periodo_referencia=ro.periodo_referencia and modulo=('RELACAO CONSTRUTORA')))supervisora,	
                (select fiscal from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=ro.id_contrato_obra and periodo_referencia=ro.periodo_referencia and modulo=('RELACAO CONSTRUTORA')))fiscal,
                (select motivo from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=ro.id_contrato_obra and periodo_referencia=ro.periodo_referencia and modulo=('RELACAO CONSTRUTORA')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=ro.id_contrato_obra and periodo_referencia=ro.periodo_referencia and modulo=('RELAAO CONSTRUTORA')))idrelatorio,
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=ro.id_contrato_obra and periodo_referencia=ro.periodo_referencia and modulo=('RELACAO CONSTRUTORA')))aceite
                ,ro.id_relacao_obra_qtd
                ,ro.id_contrato_obra
                ,ro.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = ro.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), ro.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), ro.ultima_alteracao, 114)
                    ) AS DATA
                ,'11'
            FROM tb_relacao_obra_qtd ro
            WHERE ro.id_relacao_obra_qtd = (
                    SELECT max(id_relacao_obra_qtd)
                    FROM TB_RELACAO_OBRA_QTD
                    WHERE periodo_referencia = ro.periodo_referencia
                        AND id_contrato_obra = ro.id_contrato_obra
                    )
            
            UNION
            
            SELECT
                (select supervisora  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=rnc.id_contrato_obra and periodo_referencia=rnc.periodo_referencia and modulo=('RNC')))supervisora,
                (select fiscal  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=rnc.id_contrato_obra and periodo_referencia=rnc.periodo_referencia and modulo=('RNC')))fiscal,		
                (select motivo  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=rnc.id_contrato_obra and periodo_referencia=rnc.periodo_referencia and modulo=('RNC')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=rnc.id_contrato_obra and periodo_referencia=rnc.periodo_referencia and modulo=('RNC')))idrelatorio,
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=rnc.id_contrato_obra and periodo_referencia=rnc.periodo_referencia and modulo=('RNC')))aceite 
                ,rnc.id_regnconformidade
                ,rnc.id_contrato_obra
                ,rnc.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = rnc.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), rnc.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), rnc.ultima_alteracao, 114)
                    ) AS DATA
                ,'14'
            FROM tb_regnconformidade rnc
            WHERE rnc.id_regnconformidade = (
                    SELECT max(id_regnconformidade)
                    FROM TB_REGNCONFORMIDADE
                    WHERE periodo_referencia = rnc.periodo_referencia
                        AND id_contrato_obra = rnc.id_contrato_obra
                    )
            UNION
            
            SELECT
                (select supervisora  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=cp.id_contrato_obra and periodo_referencia=cp.periodo_referencia and modulo=('CONTROLE PLUVIOMETRICO')))supervisora,
                (select motivo  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=cp.id_contrato_obra and periodo_referencia=cp.periodo_referencia and modulo=('CONTROLE PLUVIOMETRICO')))fiscal,
                (select motivo  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=cp.id_contrato_obra and periodo_referencia=cp.periodo_referencia and modulo=('CONTROLE PLUVIOMETRICO')))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=cp.id_contrato_obra and periodo_referencia=cp.periodo_referencia and modulo=('CONTROLE PLUVIOMETRICO')))idrelatorio,
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=cp.id_contrato_obra and periodo_referencia=cp.periodo_referencia and modulo=('CONTROLE PLUVIOMETRICO')))aceite 
                ,cp.id_controle_pluviometrico
                ,cp.id_contrato_obra
                ,cp.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = cp.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), cp.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), cp.ultima_alteracao, 114)
                    ) AS DATA
                ,'18'
            FROM tb_controle_pluviometrico cp
            WHERE cp.id_controle_pluviometrico = (
                    SELECT max(id_controle_pluviometrico)
                    FROM TB_CONTROLE_PLUVIOMETRICO
                    WHERE periodo_referencia = cp.periodo_referencia
                        AND id_contrato_obra = cp.id_contrato_obra
                    )		
            
            UNION
            
            SELECT
                (select supervisora from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=arq.id_contrato_obra and periodo_referencia=arq.periodo_referencia and modulo=arq.roteiro))supervisora,
                (select fiscal  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=arq.id_contrato_obra and periodo_referencia=arq.periodo_referencia and modulo=arq.roteiro))fiscal,
                (select motivo  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=arq.id_contrato_obra and periodo_referencia=arq.periodo_referencia and modulo=arq.roteiro))motivo,
                (select id_relatorio  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=arq.id_contrato_obra and periodo_referencia=arq.periodo_referencia and modulo=arq.roteiro))idrelatorio,
                (select aceite  from tb_relatorio  where id_relatorio = (select max(id_relatorio) from tb_relatorio where id_contrato_obra=arq.id_contrato_obra and periodo_referencia=arq.periodo_referencia and modulo=arq.roteiro))aceite
                ,arq.id_arquivo id
                ,arq.id_contrato_obra
                ,arq.periodo_referencia
                ,(
                    SELECT desc_nome
                    FROM tb_usuario
                    WHERE id_usuario = arq.id_usuario
                    ) nome
                ,CONCAT (
                    CONVERT(CHAR(10), arq.ultima_alteracao, 103)
                    ,' '
                    ,CONVERT(CHAR(8), arq.ultima_alteracao, 114)
                    ) AS DATA
                ,arq.roteiro
            FROM tb_arquivo arq
            WHERE arq.roteiro not in('RNC') and arq.id_arquivo = (
                    SELECT max(id_arquivo)
                    FROM tb_arquivo
                    WHERE roteiro = arq.roteiro
                        AND periodo_referencia = arq.periodo_referencia
                        AND id_contrato_obra = arq.id_contrato_obra
                    )
            ) rel
        INNER JOIN TB_CONTRATO_OBRA c ON rel.id_contrato_obra = c.id_contrato_obra
        WHERE 1=1 AND nome = (select desc_nome from tb_usuario where id_usuario = " . $this->session->id_usuario_daq . ")
        ORDER BY convert(datetime, data, 103) DESC";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaMensagemPerfil()
	{
		$SQL = "
        SELECT ME.id_mensagem,
            U_REM.DESC_NOME AS remetente,
            U_REM.id_usuario as id_remetente,
            assunto,
            mensagem,
            CONCAT( CONVERT(CHAR(10),  data_cadastro , 103),' ', CONVERT(CHAR(8),  data_cadastro , 114)) as data_cadastro, 
            U_DES.DESC_NOME AS destinatario,
            U_DES.id_usuario as id_destinatario,
            id_roteiro,
            flag_lido,
            CONCAT( CONVERT(CHAR(10),  data_lido , 103),' ', CONVERT(CHAR(8),  data_lido , 114)) as data_lido
        FROM MSG_ENTRADA ME
        JOIN MSG_SAIDA MS ON ME.id_mensagem = MS.id_mensagem
        JOIN TB_USUARIO U_REM ON ME.id_remetente = U_REM.id_usuario
        JOIN TB_USUARIO U_DES ON MS.id_destinatario = U_DES.id_usuario
        WHERE MS.id_destinatario = " . $this->session->id_usuario . " or U_REM.id_usuario = " . $this->session->id_usuario_daq . "
        AND id_roteiro = 2
        ORDER BY data_cadastro DESC";

		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaRemetente()
	{
		$SQL = "
            SELECT id_usuario
                ,desc_nome          
            FROM TB_USUARIO
            where 1 = 1 AND id_usuario = " . $this->session->id_usuario_daq;
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function RecuperaDestinatario()
	{
		$SQL = "
        SELECT DISTINCT U.id_usuario, U.desc_nome
        FROM TB_USUARIO U 
        WHERE CODI_SENHA <> '0001'
        AND id_usuario <> " . $this->session->id_usuario_daq . "
        AND DESC_NOME is not null
        ORDER BY desc_nome ASC";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	#---------- Validações de Usuario e sessão --------------------------------#

	public function iniciaSessaoInsert()
	{
		$this->db->set("timestamp", time());
		$this->db->set("primeiroLogin", time());
		$this->db->set("prazoSenha", time());
		$this->db->set("ip", $this->input->ip_address());
		$this->db->set("id_usuario", $this->session->id_usuario_daq);
		$this->db->insert("TB_USUARIO_ONLINE");
		return true;
	}

	public function iniciaSessaoUpdate()
	{
		$this->db->where("id_usuario", $this->session->id_usuario_daq);
		$this->db->set("ip", $this->input->ip_address());
		$this->db->set("timestamp", time());
		$this->db->update("TB_USUARIO_ONLINE");
		return true;
	}

	public function novoPrazo()
	{
		$this->db->where("id_usuario", $this->session->id_usuario_daq);
		$this->db->set("ip", $this->input->ip_address());
		$this->db->set("prazoSenha", time());
		$this->db->update("TB_USUARIO_ONLINE");
		return true;
	}

	public function expiraPrazoSenha()
	{
		$this->db->where("id_usuario", $this->session->id_usuario_daq);
		$this->db->set("FLAG_ALTERASENHA", "S");
		$this->db->update("TB_USUARIO");
		return true;
	}

	public function recuperaUsuariosSessao()
	{
		$SQL = "SELECT * FROM TB_USUARIO_ONLINE where id_usuario = " . $this->session->id_usuario_daq . "";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function recuperaUsuarioSessao()
	{
		
            $SQL = "
            SELECT 
                U.id_usuario
                ,u.DESC_NOME
                ,u.FLAG_ALTERASENHA
                ,U.id_perfil
            FROM  TB_USUARIO AS U
            

            WHERE id_usuario = " . $this->session->id_usuario_daq;
            
            
            $SQL_old_26072021_1126 = "
            SELECT timestamp
                ,ip
                ,o.id_usuario
                ,u.DESC_NOME
                ,u.FLAG_ALTERASENHA
                ,primeiroLogin
                ,prazoSenha
                ,id_perfil
            FROM TB_USUARIO_ONLINE as o

            LEFT JOIN TB_USUARIO AS U
            ON o.id_usuario = u.id_usuario

            WHERE o.id_usuario = " . $this->session->id_usuario_daq;
                
                //echo('<pre>');
                //die($SQL);
                
		$query = $this->db->query($SQL);
		return $query->result();
	}
        public function recuperaPerfilUsuarioSessao()
	{
		
            $SQL = "
            SELECT 
                U.id_perfil
            FROM  TB_USUARIO AS U
            

            WHERE id_usuario = " . $this->session->id_usuario_daq;
            
            
            
                
               // echo('<pre>');
               // die($SQL);
                
		$query = $this->db->query($SQL);
		return $query->result();
	}


	public function RecuperaPerfilResposta($dados)
	{
		$SQL = "
            SELECT id_resposta
                    ,id_mensagem
                    ,resposta
                    ,U.DESC_NOME AS usuario
                    ,U.id_usuario AS id_usuario
                    ,publicar
                    ,CONCAT( CONVERT(CHAR(10),  data_cadastro , 103),' ', CONVERT(CHAR(8),  data_cadastro , 114)) as data_cadastro
                    ,(SELECT ID_UPLOAD FROM TB_USUARIO_PERFIL WHERE id_upload = (SELECT MAX(id_upload) FROM TB_USUARIO_PERFIL UP WHERE U.id_usuario = UP.id_usuario)) id_upload
            FROM MSG_RESPOSTA MR
            JOIN TB_USUARIO U ON MR.id_usuario = U.id_usuario
            WHERE id_mensagem = " . $dados["id_mensagem"] . "
                    AND publicar = 'S'";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	#---------- Gestão de Acesso-----------------------------------------------#

	public function resetaSenha($dados)
	{
		$this->db->where("id_usuario", $dados["id_usuario"]);
		$this->db->set("CODI_SENHA", md5(123456));
		$this->db->set("FLAG_ALTERASENHA", "S");
		$this->db->update("TB_USUARIO");
		return true;
	}

	public function bloqueiaAcesso($dados)
	{
		$this->db->where("id_usuario", $dados["id_usuario"]);
		$this->db->set("CODI_SENHA", md5(0001));
		$this->db->set("ID_PERFIL", "");
		$this->db->set("FLAG_ALTERASENHA", "S");
		$this->db->update("TB_USUARIO");
		return true;
	}

	#---------- Nova Supervisora ----------------------------------------------#

	public function buscaUsuarioFiscal()
	{
		$SQL = "
            SELECT
                usuario.id_usuario
                ,usuario.ID_PERFIL
                ,perfilUsuario.desc_perfil
                ,DESC_NOME
                ,CODI_SENHA
                ,EMAIL
                ,empresa
                ,perfilRPFO.id_perfil AS id_perfil_rpfo
                ,perfil.desc_perfil AS desc_perfil_rpfo
                ,cpf
                ,TELEFONE
                ,CONCAT (CONVERT(VARCHAR(10),usuario.data_ultimoacesso, 103),' ',CONVERT(VARCHAR(10), usuario.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO
                ,sup.id_supervisora
		,sup.supervisora
            FROM TB_USUARIO AS usuario

            LEFT JOIN rpfo_perfil_usuario AS perfilRPFO
            ON usuario.id_usuario = perfilRPFO.id_usuario_rpfo

            LEFT JOIN TB_PERFIL AS perfil
            ON perfil.id_perfil = perfilRPFO.id_perfil
            
            LEFT JOIN TB_PERFIL AS perfilUsuario
            ON perfilUsuario.id_perfil = usuario.ID_PERFIL
            
            LEFT JOIN TB_SUPERVISORA AS sup
            ON usuario.id_supervisora = sup.id_supervisora
            
            WHERE usuario.ID_PERFIL in ('5','6')
        ";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	#---------- Dados usuário -------------------------------------------------#

	public function alterarDadosUsuario($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_usuario", $dados["id_usuario"]);
		$this->db->set("DESC_NOME", $dados["nome"]);
		$this->db->set("EMAIL", $dados["email"]);
		$this->db->set("cpf", $dados["cpf"]);
		$this->db->set("TELEFONE", $dados["telefone"]);
		$this->db->set("empresa", $dados["empresa"]);
		$this->db->set("id_usuario_alteracao", $this->session->id_usuario_daq);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->update("TB_USUARIO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function alteraPerfilPermissao($dados,$sistema)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_usuario", $dados["id_usuario_PerfilPermissao"]);
		$this->db->set("ID_PERFIL", $dados["perfil_atualizaPerfil"]);
		if($sistema == 'DAQ'){
			$this->db->set("id_perfil_daq", $dados["perfil_atualizaPerfil"]);
		}else{
			$this->db->set("id_perfil_dif", $dados["perfil_atualizaPerfil"]);
		}
		$this->db->set("id_supervisora", $dados["supervisora_atualizaPerfil"]);
		$this->db->set("id_usuario_alteracao", $this->session->id_usuario_daq);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		if ($dados["supervisora_atualizaPerfil"] != '') {
			$this->db->set("id_supervisora", $dados["supervisora_atualizaPerfil"]);
		}
		$this->db->update("TB_USUARIO");

		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	public function alteraPerfilGrupo($dados)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$this->db->where("id_usuario", $dados["id_usuario"]);
		$this->db->set("id_supervisora", $dados["id_supervisora"]);
		$this->db->set("id_usuario_alteracao", $this->session->id_usuario_daq);
		$this->db->set("ultima_alteracao", date("Y-m-d H:i:s"));
		$this->db->update("TB_USUARIO");
		$this->db->trans_complete();
		if ($this->db->trans_status() === true) {
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
	public function RecuperaEmail($dados)
	{
		$SQL = "select email from tb_usuario where email='" . $dados["email"] . "'";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
	public function RecuperaInfoUsuario()
	{
		$SQL = "
            SELECT USU.id_usuario,
                   USU.DESC_NOME, 
				   USU.EMAIL, 
				   '' as desc_perfil, 
				   '' as no_empresa, 
				   USU.empresa,
                   usu.id_perfil_daq,
                   usu.id_perfil_dif
			FROM TB_USUARIO USU";
		$query = $this->db->query($SQL);
		return $query->result();
	}

	public function buscaSupervisoraUsuario()
	{
		$SQL = "SELECT DISTINCT id_contrato_supervisora 
					FROM CGOB_TB_CONTRATO_SUPERVISORA cs
				INNER JOIN CGOB_TB_CONTRATO_OBRA co 
				    ON co.nu_con_formatado_supervisor = cs.nu_con_formatado
				INNER JOIN TB_USUARIO_CONTRATO_OBRA uco 
				    ON uco.id_contrato_obra = co.id_contrato_obra
				WHERE id_usuario = {$_REQUEST['id_usuario']}
					AND ativo = 'S'
				GROUP BY id_contrato_supervisora";
		$query = $this->db->query($SQL);
		return $query->result();
	}
#-------------------------------------------------------------------------------#
#Responsável : Sergio Ricardo
#Data:08/07/2021
#FAVOR NÃO ALTERAR.
#-------------------------------------------------------------------------------#        
public function RecuperaDadosDaqParaAcessoSupra($dados)
	{
		$SQL = "
            SELECT 
                u.empresa,
                u.fechar_relatorio,
                u.flag_primeiro_acesso,
                u.ID_PERFIL,
                u.ID_PERFIL_DAQ,
                 (select coordenacao from tb_perfil where id_perfil=u.ID_PERFIL) coordenacao,
                 (select desc_perfil from tb_perfil where id_perfil=u.ID_PERFIL_DAQ) perfil_usuario,
                u.CODI_SENHA,
                u.DESC_NOME,
                u.ID_USUARIO,
                u.id_uf,
                CONCAT (CONVERT(VARCHAR(10),u.data_ultimoacesso, 1),' ',CONVERT(VARCHAR(10), u.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO,
                u.FLAG_ALTERASENHA,
                u.email,u.cpf,u.telefone
            FROM tb_usuario u 
            WHERE id_usuario = {$_REQUEST['id_usuario_PerfilPermissao']}";
		$query = $this->db->query($SQL);
		return $query->result();
}

public function RecuperaDadosGestaoSupra($dados){
    $this->db = $this->load->database('default', TRUE);
		$SQL = "
            SELECT 
                u.empresa,
                u.fechar_relatorio,
                u.flag_primeiro_acesso,
                u.ID_PERFIL,
                u.CODI_SENHA,
                u.DESC_NOME,
                u.ID_USUARIO,
                u.id_uf,
                CONCAT (CONVERT(VARCHAR(10),u.data_ultimoacesso, 1),' ',CONVERT(VARCHAR(10), u.data_ultimoacesso, 108)) AS DATA_ULTIMOACESSO,
                u.FLAG_ALTERASENHA,
                u.email,u.cpf,u.telefone
            FROM tb_usuario u 
            WHERE id_usuario_daq = {$_REQUEST['id_usuario_PerfilPermissao']}";
		$query = $this->db->query($SQL);
		return $query->result();
	} 

public function insereUsuarioAcessoSupra($dados) {
        $this->db = $this->load->database('default', TRUE);
        $this->db->set("CODI_SENHA", md5(123456));
        $this->db->set("DESC_NOME", $dados['nome']);
        $this->db->set("EMAIL", $dados["email"]);
        $this->db->set("TELEFONE", $dados["telefone"]);
        $this->db->set("FLAG_ALTERASENHA", "S");
        $this->db->set("FLAG_PRIMEIRO_ACESSO", "S");
        $this->db->set("cpf", $dados["cpf"]);
        $this->db->set("empresa", $dados["empresa"]);
        $this->db->set("id_uf", $dados["id_uf"]);
        $this->db->set("id_perfil", 14);
        $this->db->set("id_usuario_daq", $dados["id_usuario"]);
        $this->db->insert("TB_USUARIO");
         $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }        
#------------------------------------------------------------------------------#        
        
}
