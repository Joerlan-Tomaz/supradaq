function getSH1() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPESH1",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Codigo'},
                {data: 'Posicao'},
                {data: 'LadoSeccionada'},
                {data: 'LarguraFaixa_m'},
                {data: 'LatitudeInicial'},
                {data: 'LongitudeInicial'},
                {data: 'KmInicial'},
                {data: 'LatitudeFinal'},
                {data: 'LongitudeFinal'},
                {data: 'KmFinal'},
                {data: 'TracoCadencia_m'},
                {data: 'EspacamentoCadencia_m'},
                {data: 'Material'},
                {data: 'Espessura_mm'},
                {data: 'Extensao'},
                {data: 'Area_m2'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_sh1', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getSH2() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPESH2",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Descricao'},
                {data: 'Corpo'},
                {data: 'Refletivo'},
                {data: 'CorRefletivo'},
                {data: 'LatitudeInicial'},
                {data: 'LongitudeInicial'},
                {data: 'KmInicial'},
                {data: 'LatitudeFinal'},
                {data: 'LongitudeFinal'},
                {data: 'KmFinal'},
                {data: 'Extensao'},
                {data: 'LocalImplantacao'},
                {data: 'Cadencia'},
                {data: 'Quantidade_und'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_sh2', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getSH3() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPESH3",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Sigla'},
                {data: 'Descricao'},
                {data: 'Cor'},
                {data: 'Latitude'},
                {data: 'Longitude'},
                {data: 'Km'},
                {data: 'Material'},
                {data: 'Espessura_mm'},
                {data: 'Area_m2'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_sh3', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getSH4() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPESH4",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'CorCorpo'},
                {data: 'CorRefletivo'},
                {data: 'LatitudeInicial'},
                {data: 'LongitudeInicial'},
                {data: 'KmInicial'},
                {data: 'LatitudeFinal'},
                {data: 'LongitudeFinal'},
                {data: 'KmFinal'},
                {data: 'Extensao'},
                {data: 'LocalImplantacao'},
                {data: 'Quantidade_und'},
                {data: 'Espaçamento_m'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_sh4', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getSV1() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPESV1",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'CodigoEntregaPESV1'},
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'TipoPlaca'},
                {data: 'CodigoPlaca'},
                {data: 'Velocidade'},
                {data: 'Km'},
                {data: 'Lado'},
                {data: 'Posicao'},
                {data: 'Latitude'},
                {data: 'Longitude'},
                {data: 'Detalhamento'},
                {data: 'TipoSuporte'},
                {data: 'QuantidadeSuporte'},
                {data: 'TipoSecaoSuporte'}
            ]
            insertInTable('#tbl_sv1', data, columns)
            getSV1_2()
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getSV1_2() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPESV1",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'CodigoEntregaPESV1'},
                {data: 'SecaoSuporte_mm'},
                {data: 'TipoSubstrato'},
                {data: 'TipoPeliculaFundo'},
                {data: 'CorPeliculaFundo'},
                {data: 'RetrorrefletanciaPeliculaFundo_cd_lux_m_2'},
                {data: 'TipoPeliculaLegendaOrla'},
                {data: 'CorPeliculaOrla'},
                {data: 'RetrorrefletanciaPeliculaLegendaOrla_cd_lux_m_2'},
                {data: 'SI'},
                {data: 'Lado_m'},
                {data: 'Altura_m'},
                {data: 'Area_m'},
                {data: 'Situacao'},
                {data: 'Solucao'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_sv1_2', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getSV2() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPESV2",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Tipo'},
                {data: 'AlturaLivre_m'},
                {data: 'VaoHorizontal_m'},
                {data: 'Km'},
                {data: 'Lado'},
                {data: 'Latitude'},
                {data: 'Longitude'},
                {data: 'Situacao'},
                {data: 'Solucao'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_sv2', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getDS1() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPEDS1",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'CodigoEntregaPEDS2'},
                {data: 'CodigoEntrega'},
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Tramo'},
                {data: 'KmInicial'},
                {data: 'LatitudeIncial'},
                {data: 'LongitudeInicial'},
                {data: 'KmFinal'},
                {data: 'LatitudeFinal'},
                {data: 'LongitudeFinal'},
                {data: 'Lado'},
                {data: 'QuantidadeLaminas'},
                {data: 'ComprimentoTotal_m'}            
            ]
            insertInTable('#tbl_ds1', data, columns)
            getDS1_2()
        },
        error: function (data) {
            console.log(data);
        },
    })
}

function getDS1_2() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPEDS1",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'CodigoEntregaPEDS2'},       
                {data: 'DistanciaObjetoFixo_m'},
                {data: 'Risco'},
                {data: 'Velocidade'},
                {data: 'VDM'},
                {data: 'PercentVeiculosPesados'},
                {data: 'Geometria'},
                {data: 'NivelContencao'},
                {data: 'EN13172'},
                {data: 'NCHRP350'},
                {data: 'EspacoTrabalho'},
                {data: 'TerminalEntrada'},
                {data: 'TerminalSaida'},
                {data: 'Situacao'},
                {data: 'Solucao'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_ds1_2', data, columns)

        },
        error: function (data) {
            console.log(data);
        },
    })
}


function getDS2() {
    $.ajax({
        type: 'POST',
        url: base_url + "homeCgmrr/BRLegal/CadastroEntregasProjetoExecucao/getEntregaPEDS2",
        data: {CodigoEntrega: CodigoEntrega},
        dataType: "json",
        success: function (data) {
            var columns = [
                {data: 'Rodovia'},
                {data: 'SNV'},
                {data: 'Dispositivo'},
                {data: 'Tipo'},
                {data: 'km'},
                {data: 'Latitude'},
                {data: 'Longitude'},
                {data: 'Lado'},
                {data: 'Funcao'},
                {data: 'Velocidade'},
                {data: 'NivelEnsaioEN13172'},
                {data: 'NivelEnsaioNCHRP350'},
                {data: 'Situacao'},
                {data: 'Solucao'},
                {data: 'DataArquivoF'}
            ]
            insertInTable('#tbl_ds2', data, columns)
        },
        error: function (data) {
            console.log(data);
        },
    })
}