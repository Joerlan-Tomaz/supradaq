
function limpa_formulário_cep(campoLogradouro, campoMunicipio, campoBairro, campoCodigoBaseUF) {
    // Limpa valores do formulário de cep.
    campoLogradouro.val("");
    campoMunicipio.val("");
    campoBairro.val("");
    campoCodigoBaseUF.val("");
}

function buscaCEPCorreios(campoCEP, campoLogradouro, campoMunicipio, campoBairro, campoCodigoBaseUF) {
    //Nova variável "cep" somente com dígitos.
    var cep = campoCEP.val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
//    if (cep != "") {

    //Expressão regular para validar o CEP.
    var validacep = /^[0-9]{8}$/;

    //Valida o formato do CEP.
    if (validacep.test(cep)) {

        //Preenche os campos com "..." enquanto consulta webservice.
        campoLogradouro.val("...");
        campoMunicipio.val("...");
        campoBairro.val("...");
        campoBairro.val("...");


        //Consulta o webservice viacep.com.br/
        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

            if (!("erro" in dados)) {
                //Atualiza os campos com os valores da consulta.
                campoLogradouro.val(dados.logradouro);
                campoBairro.val(dados.bairro);
                campoMunicipio.val(dados.localidade);


                if (campoCodigoBaseUF[0].tagName == "INPUT") {
                    campoCodigoBaseUF.val(dados.uf);
                } else {
                    campoCodigoBaseUF.each(function () {
                        if ($(this).text() == dados.uf) {
                            $(this).attr("selected", "selected");
                            return;
                        }
                    });
                }



            } //end if.
            else {
                //CEP pesquisado não foi encontrado.
                limpa_formulário_cep(campoLogradouro, campoMunicipio, campoBairro, campoCodigoBaseUF);
                alert("CEP não encontrado.");
            }
        });
    } //end if.
    else {
        //cep é inválido.
        limpa_formulário_cep(campoLogradouro, campoMunicipio, campoBairro, campoCodigoBaseUF);
        alert("Formato de CEP inválido.");
    }
//    } //end if.
//    else {
//        //cep sem valor, limpa formulário.
//        limpa_formulário_cep(campoLogradouro, campoMunicipio, campoBairro, campoCodigoBaseUF);
//    }
}
;
