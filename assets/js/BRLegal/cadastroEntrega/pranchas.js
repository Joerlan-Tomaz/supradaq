function atualizaSTP() {

    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasPranchas/atualizaSTP",
        data: {user: user, pswd: pswd},
        dataType: "json",
        success: function (data) {
            $("#listPDFPrancha").empty()
            $("#listDWGPrancha").empty()
            for (var i = 0; i < data.length; i++) {
                var arq = data[i];
                arq = arq.substr(2, arq.length)
                var res = arq.substring(arq.length - 3, arq.length);
                if (res === 'pdf') {
                    var body = '<li>';
                    body += '<span class="text">' + arq + '</span>';
                    if(arq == 'pdf_'+name+'.pdf'){
                        body += '<input type="checkbox" value="'+arq+'" name="pdfs" onclick="mostrarSalvarPrnchas()">';
                    } else {
                        body += '&nbsp;renomeie o arquivo conforme nomenclatura acima' 
                    }
                    body += '</li>';
                    $("#listPDFPrancha").append(body)
                }
                if (res === 'dwg') {
                    var body = '<li>';
                    body += '<span class="text">' + arq + '</span>';
                    if(arq == 'dwg_'+name+'.dwg'){
                        body += '<input type="checkbox" value="'+arq+'" name="dwgs" onclick="mostrarSalvarPrnchas()">';
                    } else {
                        body += '&nbsp;renomeie o arquivo conforme nomenclatura acima' 
                    }
                    body += '</li>';
                    $("#listDWGPrancha").append(body)
                }
            }
           
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function mostrarSalvarPrnchas(){
    $('#divSalvarPranchas').show();
}

function salvaPranchas(){
    var pdfs = $.map($("input[name='pdfs']:checked"), function(e,i) {
        return e.value;
    });

    var dwgs = $.map($("input[name='dwgs']:checked"), function(e,i) {
        return e.value;
    });
    
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasPranchas/salvaPranchas",
        data: {
            codEntrega: codEntrega, 
            pdfs: JSON.stringify(pdfs),
            dwgs: JSON.stringify(dwgs)
        },
        dataType: "json",
        success: function (data) {
            alert(data);
        }
    });
}