$(document).ready(function () {
    carregaMeuPerfil();
    carregaMensagemPerfil();
    atualizaMensagemLida();
});

function carregaMeuPerfil() {
    $.ajax({
        type: 'POST',
        url: 'Login/buscaUsuario',
        dataType: 'json',
        success: function (data) {
            $("#exibeFoto").html(data.foto);
            $("#dataUltimoAcessoPerfil").text("Último Acesso: " + data.DATA_ULTIMOACESSO);
            $("#emailPerfil").text(data.email);
            $("#cpfPerfil").text(data.cpf);
            $("#telefonePerfil").text(data.telefone);

            $("#telefoneAdicionalPerfil").text(data.telefone_adicional);
            $("#formacaoPerfil").text(data.titularidade + " - " + data.formacao);
            $("#areaAtuacaoPerfil").text(data.area_atuacao);
            $("#localizacaoPerfil").text(data.localizacao);
            $("#curriculoResumidoPerfil").text(data.curriculo_resumido);

        }
    });
}

function atualizaMensagemLida() {
    $.ajax({
        type: 'POST',
        url: 'Login/atualizaMensagemLida',
        dataType: 'json'
    });
}
//-------------------------------------------------------------------------------------------------
function alterasenhaModal() {
    document.formNovaSenha.reset();
    $("#alterasenhaModal").modal();
}
//-------------------------------------------------------------------------------------------------
function alterarSenha() {
    if ($("#edtAtual").val() == "") {
        $.notify("Por favor, informe a senha atual", 'info');
        $("#edtAtual").focus();
        return false;
    } else if ($("#edtNova").val() == "") {
        $.notify("Por favor, informe sua nova senha", 'info');
        $("#edtNova").focus();
        return false;
    } else if ($("#edtConfirmar").val() == "") {
        $.notify("Por favor, confirme sua nova senha", 'info');
        $("#edtConfirmar").focus();
        return false;
    } else if ($("#edtConfirmar").val() !== $("#edtNova").val()) {
        $.notify("As senhas nao correspondem", 'info');
        document.getElementById('edtConfirmar').style.borderColor = 'red';
        document.getElementById('edtNova').style.borderColor = 'red';
        return false;
    }
    document.getElementById('edtConfirmar').style.borderColor = '#d2d6de';
    document.getElementById('edtNova').style.borderColor = '#d2d6de';
    //---------------- Validação de formulario ---------------------------------
    var serializedData = new FormData();
    serializedData = $("#formNovaSenha").serializeArray();
    //--------------------------------------------------------------------------
    bootbox.confirm("Confirmar operação [ALTERAR SENHA]?", function (result) {
        if (result == true) {
            $.ajax({
                type: 'POST',
                url: 'Login/alterasenha',
                data: serializedData,
                dataType: 'json',
                success: function (data) {
                    $.notify(data.mensagem, data.notify);
                    document.formNovaSenha.reset();
                    $("#alterasenhaModal").modal("hide");
                }, error: function (data) {

                }
            });
        }
    });
}

//-------------------------------------------------------------------------------------------------
function sobreMimModal() {
    //document.formSobreMim.reset();
    //$("#sobreMimModal").modal();

    $.ajax({
        type: 'POST',
        url: 'Login/buscaUsuario',
        dataType: 'json',
        success: function (data) {
            $("#sobreMimModal").modal();
            $('#fileUpload').val("");
            //$("#fileUpload").val(data.foto);
            $("#telefone_adicional").val(data.telefone_adicional);
            $("#titularidade").val(data.titularidade).change();
            $("#formacao").val(data.formacao);
            $("#area_atuacao").val(data.area_atuacao);
            $("#localizacao").val(data.localizacao).change();
            $("#curriculo_resumido").val(data.curriculo_resumido);

        }
    });
}


function alteraSobreMim() {

    var form = new FormData();
    var serializedData = $("#formSobreMim").serializeArray();
    for (i = 0; i < serializedData.length; i++) {
        form.append(serializedData[i].name, serializedData[i].value);
    }
    if ($('#fileUpload').val() == "") {
        form.append('arquivo', $('#fileUpload')[0].files[0]);
    }
    //-----------------------------------------------------------
    bootbox.confirm("Confirmar operação [INSERIR SOBRE MIM]?", function (result) {
        if (result === true) {
            $.ajax({
                type: 'POST',
                url: 'Login/alteraSobreMim',
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $.notify(data.mensagem, data.notify);
                    $('#sobreMimModal').modal('hide');
                    carregaMeuPerfil();
                }, error: function (data) {
                    $.notify('Erro no Envio', "warning");
                }
            });
        }
    });

}

$("#abrirlinhatempo").click(function () {

    $.ajax({
        type: 'POST',
        url: 'Login/LinhaTempo',
        dataType: 'json',
        success: function (data) {

            $("#LinhaTempoPerfil").html("")

            if (data.id != "") {

                var cols = "";
                var icon = "";
                var date = "";
                var title = "";
                var body = "";

                for (var i = 0; i < data.id.length; i++) {

                    if (data.roteiro[i] == '1') {
                        icon = '<i class="fa fa-usd bg-primary"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header"> Resumo </h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '2') {
                        icon = '<i class="fa fa-envelope-o bg-info"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Apresentação Supervisora</h3> ';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '3') {
                        icon = '<i class="fa fa-signal bg-success"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Atividade Executada </h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '4') {
                        icon = '<i class="fa fa-plus bg-warning"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Relação Supervisora </h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '5') {
                        icon = '<i class="fa fa-file-text-o bg-danger"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Apresentação Construtora</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '6') {
                        icon = '<i class="fa fa-road bg-gray"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Avanço Físico</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '7') {
                        icon = '<i class="fa fa-file-text-o bg-warning"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">OAE</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '8') {
                        icon = '<i class="fa fa-warning bg-warning"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Interferência</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '9') {
                        icon = '<i class="fa fa-file-text-o bg-warning"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">RPFO</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '10') {
                        icon = '<i class="fa fa-file-text-o bg-primary"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Resumo Projeto</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '11') {
                        icon = '<i class="fa fa-file-text-o bg-danger"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Relação Construtora</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '12') {
                        icon = '<i class="fa fa-file-text-o bg-info"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Serviços Executados</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '13') {
                        icon = '<i class="fa fa-file-text-o bg-warning"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Atividade Crítica</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '14') {
                        icon = '<i class="fa fa-file-text-o bg-danger"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">RNC</h3>';
                        body = data.contrato[i];
                    }
                    if (data.roteiro[i] == '15') {
                        icon = '<i class="fa fa-camera bg-info"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Documentação Fotográfica</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '16') {
                        icon = '<i class="fa fa-file-text-o bg-primary"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Diário de Obra</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '17') {
                        icon = '<i class="fa fa-flask bg-primary"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Ensaio de Laboratório</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '18') {
                        icon = '<i class="fa fa-umbrella bg-warning"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Controle Pluviometrico</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '19') {
                        icon = '<i class="fa fa-tree bg-success"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Componente Ambiental</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '20') {
                        icon = '<i class="fa fa-file-text-o bg-primary"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Conclusão e Comentário</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '21') {
                        icon = '<i class="fa fa-file-text-o bg-gray"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Atas e Correspondências</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '22') {
                        icon = '<i class="fa fa-check bg-primary"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Conclusão Geral Empreendimento</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '23') {
                        icon = '<i class="fa fa-paperclip bg-info"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Anexo Supervisão</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '24') {
                        icon = '<i class="fa fa-file-text-o bg-primary"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Termo Encerramento</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '25') {
                        icon = '<i class="fa fa-paperclip bg-danger"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Anexo ART</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '26') {
                        icon = '<i class="fa fa-map-marker bg-info"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Georreferenciamento</h3>';
                        body = data.contrato[i];
                    }

                    if (data.roteiro[i] == '27') {
                        icon = '<i class="fa fa-leaf bg-success"></i>';
                        date = data.data_cadastro[i];
                        title = '<h3 class="timeline-header">Licença Ambiental</h3>';
                        body = data.contrato[i];
                    }


                    cols += "<li>";
                    cols += icon;

                    cols += "<div class='timeline-item'>";
                    cols += "<span class='time'><i class='fa fa-clock-o'></i> " + date + "</span>";

                    cols += title;

                    cols += "<div class='timeline-body'>";
                    cols += body;
                    cols += "</div>";

                    cols += "</div>";
                    cols += "</li>";
                }

                cols += "<li><i class='fa fa-clock-o bg-default'></i></li>";

            } else {
                cols = "<div class='row'><div class='col-md-12 text-muted'> <span>Sem Registro.</span></div></div>";
            }

            $("#LinhaTempoPerfil").append(cols)
        }
    });
});


// Aba Mensagem ----------------------------------------------------------------------------------------------------------------
function carregaMensagemPerfil() {
    $.ajax({
        type: 'POST',
        url: 'Login/MensagemPerfil',
        dataType: 'json',
        success: function (data) {

            $("#MensagemPerfil").html("")
            var cols = "";
            if (data.id_mensagem != "") {
                for (var i = 0; i < data.id_mensagem.length; i++) {

                    cols += "<div class='card direct-chat direct-chat-primary collapsed-card' style='background-color: #f4f6f9;'> ";
                    cols += "    <div class='card-header ui-sortable-handle' style='cursor: move;'> <span class='pull-right'> <smal class='text-muted'>  <i class='fa fa-clock-o'></i> " + data.data_cadastro[i] + " <br>Rementente: " + data.remetente[i] + "<br>  Destinatário: " + data.destinatario[i] + "</small></span>";
                    cols += "       <b>" + data.assunto[i] + "</b>";
                    cols += "       <span>" + data.mensagem[i] + "</span>";

                    cols += "        <div class='card-tools'>";
                    cols += "            <button typ'e='button' class='btn btn-tool' data-widget='collapse'>";
                    cols += "                <i class='fa fa-minus'></i>";
                    cols += "            </button>";
                    cols += "        </div>";
                    cols += "    </div>";
                    cols += "    <div class='card-body' style='display: none;'>";
                    cols += "        <div class='direct-chat-messages' style='background-color: white;'>";

                    cols += "<div id='RespostaPerfil" + data.id_mensagem[i] + "'></div>";
                    buscaRespostas(data.id_mensagem[i]);

                    cols += "       </div>";
                    cols += "    </div>";

                    cols += "    <div class='card-footer' style='display: none;'>";
                    cols += "         <form method='post' name='formularioResposta' id='formularioResposta'>";
                    cols += "            <div class='input-group'>";
                    cols += "                <input type='text' placeholder='Escreva uma Resposta ...' class='form-control' id='resposta" + data.id_mensagem[i] + "' name='resposta" + data.id_mensagem[i] + "' >";
                    cols += "                <span class='input-group-append'>";
                    cols += "                   <button type='button' class='btn btn-primary' onclick='GravaResposta(" + data.id_mensagem[i] + ", " + data.id_destinatario[i] + " , " + data.id_remetente[i] + ");'>Enviar</button>";
                    cols += "                </span>";
                    cols += "            </div>";
                    cols += "        </form>";
                    cols += "     </div>";
                    cols += " </div>";

                    //cols += "<div class='card card-default' style='background-color: #f4f6f9;'>";

                    //    cols += "<div class='card-header'>";
                    //        cols += "<h4 class='card-title'>";
                    //            cols += "<a data-toggle='collapse' data-parent='#accordion' href='#collapse"+i+"'>";
                    //                cols += data.assunto[i];
                    //            cols += "</a>";
                    //        cols += "</h4>";
                    //    cols += "</div>";

                    //    cols += "<div id='collapse"+i+"' class='panel-collapse in collapse'>";   
                    //        cols += "<div class='card-body'>";  
                    //            cols += "<small class='text-muted pull-right'>Enviada em - "+data.data_cadastro[i]+"</small>"; 
                    //            cols += "<div class='row text-muted'>";                                
                    //                cols += "<div class='col-md-12'><small>De: "+data.remetente[i]+"</small></div>";
                    //                cols += "<div class='col-md-12'><small>Para: "+data.destinatario[i]+"</small></div>";
                    //            cols += "</div>";  
                    //            cols += data.mensagem[i]; 
                    //        cols += "</div>";
                    //        cols += "<div id='RespostaPerfil"+data.id_mensagem[i]+"' class='card-body'></div>";
                    //        buscaRespostas(data.id_mensagem[i]);
                    //        cols += "<div class='card-footer'>";  
                    //            cols += "<form method='post' name='formularioResposta' id='formularioResposta'>";  
                    //                cols += "<div class='input-group input-group-sm mb-0'>";  
                    //                    cols += "<input class='form-control form-control-sm' id='resposta"+data.id_mensagem[i]+"' name='resposta"+data.id_mensagem[i]+"' placeholder='Resposta'>";  
                    //                    cols += "<div class='input-group-append'>";  
                    //                        cols += "<a href='javascript:void(0);' onclick='GravaResposta("+data.id_mensagem[i]+", "+data.id_destinatario[i]+", "+data.id_remetente[i]+");' class='btn btn-primary'>Salvar</a>"; 
                    //                    cols += "</div>";  
                    //                cols += "</div>";
                    //            cols += "</form>"; 
                    //        cols += "</div>";  
                    //        

                    //    cols += "</div>";   
                    //cols += "</div>";
                }
            } else {
                cols = "<div class='row'><div class='col-md-12 text-muted'> <span>Sem Registro.</span></div></div>";
            }

            $("#MensagemPerfil").append(cols)
        }
    });
}

function buscaRespostas(id_mensagem) {

    $.ajax({
        type: 'POST',
        url: 'Login/PerfilResposta',
        data: {
            id_mensagem: id_mensagem
        },
        dataType: 'json',
        success: function (data) {

            $("#RespostaPerfil" + id_mensagem).html("")
            var cols = "";

            for (var i = 0; i < data.id_resposta.length; i++) {

                if (data.send_by_me[i] == 1) {

                    cols += "             <div class='direct-chat-msg right'>";
                    cols += "                 <div class='direct-chat-info clearfix'>";
                    cols += "                     <span class='direct-chat-name float-right'>" + data.usuario[i] + "</span>";
                    cols += "                     <span class='direct-chat-timestamp float-left'>" + data.data_cadastro[i] + "</span>";
                    cols += "                 </div>";
                    cols += "                 <img class='direct-chat-img' alt='' src='../../../assets/img/users/"+data.foto[i]+"'>";
                    //cols +=                         data.foto[i];
                    cols += "                 <div class='direct-chat-text'>";
                    cols += data.resposta[i];
                    cols += "                 </div>";
                    cols += "             </div>";

                } else {

                    cols += "             <div class='direct-chat-msg'>";
                    cols += "                 <div class='direct-chat-info clearfix'>";
                    cols += "                     <span class='direct-chat-name float-left'>" + data.usuario[i] + "</span>";
                    cols += "                     <span class='direct-chat-timestamp float-right'>" + data.data_cadastro[i] + "</span>";
                    cols += "                 </div>";
                    cols += "                 <img class='direct-chat-img' alt='' src='../../../assets/img/users/"+data.foto[i]+"'>";
                    //cols +=                         data.foto[i];
                    cols += "                 <div class='direct-chat-text'>";
                    cols += data.resposta[i];
                    cols += "                 </div>";
                    cols += "             </div>";

                }






                //cols += "<hr>";  
                //cols += "<small class='text-muted'>"+data.usuario[i]+"</small>";
                //cols += "<small class='text-muted pull-right'>Enviada em - "+data.data_cadastro[i]+"</small><br>";
                //cols += "<button type='button' class='btn btn-default btn-sm pull-right' onclick='excluirResposta("+data.id_resposta[i]+", "+data.id_mensagem[i]+")'><i class='fa fa-trash'></i></button> ";        

                //cols += data.resposta[i]; 

            }

            $("#RespostaPerfil" + id_mensagem).append(cols)
        }
    });
}

function PerfilMensagem() {

    $('#modalPerfilMensagem').modal('show');

    $.ajax({
        type: 'POST',
        url: 'Login/RecuperaRemetente',
        dataType: 'json',
        success: function (data) {
            var remetente = $('select[id=id_usuario_remetente]');
            remetente.html('');
            remetente.append('<option value="" selected >' + data.desc_nome + '</option>');
        }
    });

    $.ajax({
        type: 'POST',
        url: 'Login/RecuperaDestinatario',
        dataType: 'json',
        success: function (data) {
            var destinatario = $('select[id=id_usuario_destinatario]');
            destinatario.html('');
            destinatario.append('<option value="Todos" selected >Selecione</option>');
            for (i = 0; i < data.id_usuario.length; i++) {
                destinatario.append('<option value="' + data.id_usuario[i] + '">' + data.desc_nome[i] + '</option>');

            }
        }
    });

    CKEDITOR.replace('assunto_mensagem', {
        removePlugins: 'toolbar, elementspath, resize',
        height: 50
    });

    CKEDITOR.replace('descricao_mensagem', {
        removePlugins: 'toolbar, elementspath, resize',
        height: 80
    });
}

function gravaPerfilMensagem() {

    bootbox.confirm("Confirmar operação [INSERIR MENSAGEM]?", function (result) {
        if (result === true) {

            var id_usuario_destinatario = $("#id_usuario_destinatario").val();
            var assunto_mensagem = CKEDITOR.instances['assunto_mensagem'].getData();
            var descricao_mensagem = CKEDITOR.instances['descricao_mensagem'].getData();

            $.ajax({
                type: 'POST',
                url: 'Login/insereMensagem',
                data: {
                    id_usuario_destinatario: id_usuario_destinatario,
                    assunto_mensagem: assunto_mensagem,
                    descricao_mensagem: descricao_mensagem
                },
                dataType: 'json',
                success: function (data) {
                    $.notify('Mensagem cadastrada com sucesso', "success");
                    $('#modalPerfilMensagem').modal('hide');
                    carregaMensagemPerfil();
                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                }
            });
        }
    });
}

function GravaResposta(id_mensagem, id_destinatario, id_remetente) {

    bootbox.confirm("Confirmar operação [INSERIR RESPOSTA]?", function (result) {
        if (result === true) {

            var resposta = $("#resposta" + id_mensagem).val();
            $.ajax({
                type: 'POST',
                url: 'Login/insereResposta',
                data: {
                    resposta: resposta,
                    id_mensagem: id_mensagem,
                    id_destinatario: id_destinatario,
                    id_remetente: id_remetente
                },
                dataType: 'json',
                success: function (data) {
                    $.notify('Resposta cadastrada com sucesso', "success");
                    buscaRespostas(id_mensagem);

                }, error: function (data) {
                    $.notify('Falha no cadastro', "warning");
                }
            });
        }
    });
}

function excluirResposta(id_resposta, id_mensagem) {
    bootbox.confirm("Confirmar operação [EXCLUIR MENSAGEM]?", function (result) {
        if (result === true) {

            $.ajax({
                type: 'POST',
                url: 'Login/excluiResposta',
                data: {
                    id_resposta: id_resposta
                },
                dataType: 'json',
                success: function (data) {
                    $.notify('Resposta excluida com sucesso', "success");
                    buscaRespostas(id_mensagem);
                }, error: function (data) {
                    $.notify('Falha na operação', "warning");
                }
            });
        }
    });
}
