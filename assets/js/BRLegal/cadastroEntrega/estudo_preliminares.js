function _(el) {
    return document.getElementById(el);
}

function getFaixaDominio() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasEstudoPreliminares/getEntregaEPFaixaDominio",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Tipo'},
                {data: 'Descricao'},
                {data: 'Lado'},
                {data: 'Km'},
                {data: 'Latitude'},
                {data: 'Longitude'},
                {data: 'Situacao'},
                {data: 'DataArquivoF'},
            ]
            insertInTable('#tbl_faixa_dominio', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getCurvas() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasEstudoPreliminares/getEntregaEPCurvas",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Classificação'},
                {data: 'Raio_m'},
                {data: 'Angulo'},
                {data: 'KmInicial'},
                {data: 'LatitudeInicial'},
                {data: 'LongitudeInicial'},
                {data: 'KmFinal'},
                {data: 'LatitudeFinal'},
                {data: 'LongitudeFinal'},
                {data: 'Extensao'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_curvas', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getIntersecoes() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasEstudoPreliminares/getEntregaEPIntersecao",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'KmInicial'},
                {data: 'LatitudeInicial'},
                {data: 'LongitudeInicial'},
                {data: 'KmFinal'},
                {data: 'LatitudeFinal'},
                {data: 'LongitudeFinal'},
                {data: 'Extensao'},
                {data: 'Velocidade'},
                {data: 'Grupo'},
                {data: 'Subdivisao'},
                {data: 'Solucao'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_intersecoes', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getCaracteristicasFisicas() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasEstudoPreliminares/getEntregaEPCaracteristicas",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'KmInicial'},
                {data: 'KmFinal'},
                {data: 'TipoPista'},
                {data: 'UsoSolo'},
                {data: 'PerfilSegmento'},
                {data: 'Classificacao'},
                {data: 'LarguraPista_m'},
                {data: 'LarguraCanteiroCentral_m'},
                {data: 'LarguraAcostamentoDireito_m'},
                {data: 'LarguraAcostamentoEsquerdo_m'},
                {data: 'TipoPavimento'},
                {data: 'Velocidade'},
                {data: 'VDM'},
                {data: 'PercentualVeiculosPesados'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_caracteristicas', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getNeblina() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasEstudoPreliminares/getEntregaEPNeblina",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'KmInicial'},
                {data: 'KmFinal'},
                {data: 'Extensao'},
                {data: 'PeriodoInicial'},
                {data: 'PeriodoFinal'},
                {data: 'DuracaoMedia_mes'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_neblina', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getFuturasMelhorias() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasEstudoPreliminares/getEntregaEPFuturasMelhorias",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'KmInicial'},
                {data: 'KmFinal'},
                {data: 'Extensao'},
                {data: 'TipoIntervencao'},
                {data: 'DataInicio'},
                {data: 'DataTermino'},
                {data: 'DuracaoMedia_dias'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_melhorias', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getRetrorrefletancia() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasEstudoPreliminares/getEntregaEPRetrorrefletancia",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'GeometriaEquipamento_m'},
                {data: 'Local'},
                {data: 'TipoMarcacao'},
                {data: 'Cor'},
                {data: 'Material'},
                {data: 'KmInicial'},
                {data: 'LatitudeInicial'},
                {data: 'LongitudeInicial'},
                {data: 'KmFinal'},
                {data: 'LatitudeFinal'},
                {data: 'LongitudeFinal'},
                {data: 'Extensao'},
                {data: 'Retrorrefletividade_mCd_m2_lx'},
                {data: 'DataMedicao'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_retro', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}