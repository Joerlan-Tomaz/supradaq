<script src="<?php echo(base_url('application/homeDaq/homeCgop/assets/js/supervisaodaq/art/artView.js'))?>" type="text/javascript"></script>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ART de Supervisão</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rota_Cgop()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="">DAQ</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);" onclick="rotaSupervisaoDaq()">Painel de Contratos</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">ART de Supervisão</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h2>
                        <font size="3">                        
                        Devem ser anexadas as ART’s de todos os responsáveis técnicos pelo contrato de Supervisão.
							<div class='ocultar'><u>[+/-] Leia mais...</u></div>
                        <div class='mostrar'> 
                            Todas as ART’s deverão ser registradas no Conselho de Classe de Engenharia e estar válidas. Caso haja alteração do responsável técnico, deverá ser apresentada a nova ART e dada baixa nas anteriores, caso seja necessário.
                        </div>
                        </font>
                    </h2>
                    <div class="row">
                        <div class="col-xs-12 col-md-1">
                                <div id="incluir">
                                    <button type="button" name="btnInclusao" id="btnInclusao" class="btn btn-block btn-primary">Incluir</button>
                                </div> 
                                <div> 
                                  <button type="button" name="btnPesquisar" id="btnPesquisar" class='btn btn-block btn-secondary' ><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>   
                                </div>  
                               
                        </div> 
                        <div class="col-xs-12 col-md-1">
                                <div> 
                                  <button type="button" name="btnVoltar" id="btnVoltar" class='btn btn-block btn-secondary'><i class="far fa-arrow-alt-circle-left"></i> Voltar</button>
                                </div>  
                        </div>   
                    
                    </div>   
                </div>
                <div class="card-body">    
                    <div class="row" id="pesquisaART">
                        <div class="col-md-12 table-responsive"><hr>
                            <table id="tableART" class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nº ART</th>
                                        <th>Forma de Registro</th>
                                        <th>Participação Técnica</th>
                                        <th>Data de Registro</th>
                                        <th>Nome do Profissional</th>
                                        <th>Data da Baixa</th>
                                        <th>Arquivo</th>
                                        <th>Usuário</th>                 
                                        <th>Atualização</th>   
                                        <th>Ações</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>                               
                            </table>       
                        </div>                  
                    </div>

                    <div class="row" id="cadastraART" style="display: none;">
                        <div class="col-md-12"><hr>
                            <form method="post" name="formularioConfigART" id="formularioConfigART">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Empresa Contratada</label>
                                            <input type="text" class="form-control" id="config_ART_empresa" name="config_ART_empresa" maxlength='255'placeholder="Empresa Contratada">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nome do Profissional</label>
                                            <input type="text" class="form-control" id="config_ART_nome" name="config_ART_nome" maxlength='255' placeholder="Profissional">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><b>@</b></span>
                                            </div>
                                            <input type="email" class="form-control" id="config_ART_email" name="config_ART_email" maxlength='255'placeholder="Email">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="text" class="form-control" id="config_ART_telefone" name="config_ART_telefone" maxlength='15'placeholder="Telefone">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>CREA Nº</label>
                                            <input type="text" class="form-control" id="config_ART_CREA" name="config_ART_CREA" maxlength='100' placeholder="CREA">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>RNP</label>
                                            <input type="text" class="form-control" id="config_ART_RNP" name="config_ART_RNP" maxlength='100' placeholder="RNP">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Nº ART</label>
                                            <input type="text" class="form-control" id="config_ART_numero" name="config_ART_numero"maxlength='100' placeholder="Nº ART">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>UF Registro</label>
                                            <select class="form-control" name="uf_registro" id="uf_registro">
                                                <option value="">Selecione</option>
                                                <option value="AC">Acre</option>
                                                <option value="AL">Alagoas</option>
                                                <option value="AP">Amapá</option>
                                                <option value="AM">Amazonas</option>
                                                <option value="BA">Bahia</option>
                                                <option value="CE">Ceará</option>
                                                <option value="DF">Distrito Federal</option>
                                                <option value="ES">Espírito Santo</option>
                                                <option value="GO">Goiás</option>
                                                <option value="MA">Maranhão</option>
                                                <option value="MT">Mato Grosso</option>
                                                <option value="MS">Mato Grosso do Sul</option>
                                                <option value="MG">Minas Gerais</option>
                                                <option value="PA">Pará</option>
                                                <option value="PB">Paraíba</option>
                                                <option value="PR">Paraná</option>
                                                <option value="PE">Pernambuco</option>
                                                <option value="PI">Piauí</option>
                                                <option value="RJ">Rio de Janeiro</option>
                                                <option value="RN">Rio Grande do Norte</option>
                                                <option value="RS">Rio Grande do Sul</option>
                                                <option value="RO">Rondônia</option>
                                                <option value="RR">Roraima</option>
                                                <option value="SC">Santa Catarina</option>
                                                <option value="SP">São Paulo</option>
                                                <option value="SE">Sergipe</option>
                                                <option value="TO">Tocantins</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Participação Técnica</label>
                                            <select class="form-control" name="config_ART_participacao_tecnica" id="config_ART_participacao_tecnica">
                                                <option value="">Selecione</option> 
                                                <option value="Individual">Individual</option>
                                                <option value="Coautor">Coautor</option>
                                                <option value="Corresponsável">Corresponsável</option>  
                                                <option value="Equipe">Equipe</option>                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Forma de Registro</label>
                                            <select class="form-control" name="config_ART_forma_registro" id="config_ART_forma_registro">
                                                <option value="">Selecione</option> 
                                                <option value="Inicial">Inicial</option>
                                                <option value="Complementar">Complementar</option>
                                                <option value="Subtituição">Subtituição</option>                                 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Data de Registro</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="config_ART_data" name="config_ART_data" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div>                                                        
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Data da Baixa</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="config_ART_dataBaixa" name="config_ART_dataBaixa" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div>                                                        
                                        </div> 
                                    </div>
                                <div class="col-md-6">
                                    <label>Arquivo ART</label><small> arquivos permitidos: (.pdf)</small>
                                    <div class="input-group date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <input class="form-control" type="file" id="fileUploadConfigART" name="fileUploadConfigART" accept=".pdf">

                                    </div>
                                    <small><i class="fas fa-info-circle"style='color:green'></i> tamanho max(5mb) </small>
                                </div>
                                   
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1" style="margin-top: 15px;">  
                            <button type="button" name="insereConfigART" id="insereConfigART" class="btn btn-block btn-primary">Salvar</button>                           
                        </div> 
                         
                    </div>
                </div> 
                <!-- edição -->
                
                     <div class="row"  id="editarART" style="display: none;">
                        <div class="card-body">  
                        <div class="col-md-12"><hr>
                            <form method="post" name="formularioConfigARTEditar" id="formularioConfigARTEditar">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Empresa Contratada</label>
                                            <input type="text" class="form-control" id="config_ART_empresa_Editar" name="config_ART_empresa_Editar" maxlength='255' placeholder="Empresa Contratada">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nome do Profissional</label>
                                            <input type="text" class="form-control" id="config_ART_nome_Editar" name="config_ART_nome_Editar" maxlength='255'placeholder="Profissional">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="text" class="form-control" id="config_ART_email_Editar" name="config_ART_email_Editar" maxlength='255' placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="text" class="form-control" id="config_ART_telefone_Editar" name="config_ART_telefone_Editar"maxlength='15' placeholder="Telefone">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>CREA Nº</label>
                                            <input type="text" class="form-control" id="config_ART_CREA_Editar" name="config_ART_CREA_Editar" maxlength='100'placeholder="CREA">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>RNP</label>
                                            <input type="text" class="form-control" id="config_ART_RNP_Editar" name="config_ART_RNP_Editar" maxlength='100'placeholder="RNP">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Nº ART</label>
                                            <input type="text" class="form-control" id="config_ART_numero_Editar" name="config_ART_numero_Editar" maxlength='100'placeholder="Nº ART">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>UF Registro</label>
                                            <select class="form-control" name="uf_registro_Editar" id="uf_registro_Editar">
                                                <option value="">Selecione</option>
                                                <option value="AC">Acre</option>
                                                <option value="AL">Alagoas</option>
                                                <option value="AP">Amapá</option>
                                                <option value="AM">Amazonas</option>
                                                <option value="BA">Bahia</option>
                                                <option value="CE">Ceará</option>
                                                <option value="DF">Distrito Federal</option>
                                                <option value="ES">Espírito Santo</option>
                                                <option value="GO">Goiás</option>
                                                <option value="MA">Maranhão</option>
                                                <option value="MT">Mato Grosso</option>
                                                <option value="MS">Mato Grosso do Sul</option>
                                                <option value="MG">Minas Gerais</option>
                                                <option value="PA">Pará</option>
                                                <option value="PB">Paraíba</option>
                                                <option value="PR">Paraná</option>
                                                <option value="PE">Pernambuco</option>
                                                <option value="PI">Piauí</option>
                                                <option value="RJ">Rio de Janeiro</option>
                                                <option value="RN">Rio Grande do Norte</option>
                                                <option value="RS">Rio Grande do Sul</option>
                                                <option value="RO">Rondônia</option>
                                                <option value="RR">Roraima</option>
                                                <option value="SC">Santa Catarina</option>
                                                <option value="SP">São Paulo</option>
                                                <option value="SE">Sergipe</option>
                                                <option value="TO">Tocantins</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Participação Técnica</label>
                                            <select class="form-control" name="config_ART_participacao_tecnica_Editar" id="config_ART_participacao_tecnica_Editar">
                                                <option value="">Selecione</option> 
                                                <option value="Individual">Individual</option>
                                                <option value="Coautor">Coautor</option>
                                                <option value="Corresponsável">Corresponsável</option>  
                                                <option value="Equipe">Equipe</option>                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Forma de Registro</label>
                                            <select class="form-control" name="config_ART_forma_registro_Editar" id="config_ART_forma_registro_Editar">
                                                <option value="">Selecione</option> 
                                                <option value="Inicial">Inicial</option>
                                                <option value="Complementar">Complementar</option>
                                                <option value="Subtituição">Subtituição</option>                                 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Data de Registro</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="config_ART_data_Editar" name="config_ART_data_Editar" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div>                                                        
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Data da Baixa</label>
                                            <div class="input-group date">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="config_ART_dataBaixa_Editar" name="config_ART_dataBaixa_Editar" type="text" data-provide="datepicker" class="datepicker form-control" required="true">                                                   
                                            </div>                                                        
                                        </div> 
                                    </div>
                                  
                                                                      
                                </div>
                            </form>
                        </div>
                        </div>
                        <div class="col-md-1" style="margin-top: 15px;">  
                            <button type="button" name="editarConfigART" id="editarConfigART" class="btn btn-block btn-primary">Editar</button>
                            <input type="hidden" id="editar" name="editar">
                        </div> 
                         
                    </div>
               
                </div>
                
                <iframe id="invisible" style="display:none;"></iframe>
                <!-- fim    -->
            </div>
        </div>
    </section>
</div>
