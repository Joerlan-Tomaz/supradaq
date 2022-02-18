/*
 * DNIT
 * Programador:Pedro Correia
 * Data:05/09/2019 14:04
 * */
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$(document).ready(function () {
	CKEDITOR.replace("textoResumo", {height: 200});
    $('#dadosContratos').hide();
//------------------------------------------------------------------------------
// Cores para grafico apple watch 
    if (!Highcharts.theme) {
        Highcharts.setOptions({
            chart: {
                backgroundColor: 'white'
            },
            colors: ['#6495ed', '#f45b5b', '#0CCDD6', '#0CCDD6', '#2b908f'],
            title: {
                style: {
                    color: 'silver'
                }
            },
            tooltip: {
                style: {
                    color: 'silver'
                }
            }
        });
    }

    function renderIcons() {

        // Move icon
        if (!this.series[0].icon) {
            this.series[0].icon = this.renderer.path(['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8])
                    .attr({
                        'stroke': '#303030',
                        'stroke-linecap': 'round',
                        'stroke-linejoin': 'round',
                        'stroke-width': 2,
                        'zIndex': 10
                    })
                    .add(this.series[2].group);
        }
        this.series[0].icon.translate(
                this.chartWidth / 2 - 10,
                this.plotHeight / 2 - this.series[0].points[0].shapeArgs.innerR -
                (this.series[0].points[0].shapeArgs.r - this.series[0].points[0].shapeArgs.innerR) / 2
                );

        // Exercise icon
        if (!this.series[1].icon) {
            this.series[1].icon = this.renderer.path(
                    ['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8,
                        'M', 8, -8, 'L', 16, 0, 8, 8]
                    )
                    .attr({
                        'stroke': '#ffffff',
                        'stroke-linecap': 'round',
                        'stroke-linejoin': 'round',
                        'stroke-width': 2,
                        'zIndex': 10
                    })
                    .add(this.series[2].group);
        }
        this.series[1].icon.translate(
                this.chartWidth / 2 - 10,
                this.plotHeight / 2 - this.series[1].points[0].shapeArgs.innerR -
                (this.series[1].points[0].shapeArgs.r - this.series[1].points[0].shapeArgs.innerR) / 2
                );

        // Stand icon
        if (!this.series[2].icon) {
            this.series[2].icon = this.renderer.path(['M', 0, 8, 'L', 0, -8, 'M', -8, 0, 'L', 0, -8, 8, 0])
                    .attr({
                        'stroke': '#303030',
                        'stroke-linecap': 'round',
                        'stroke-linejoin': 'round',
                        'stroke-width': 2,
                        'zIndex': 10
                    })
                    .add(this.series[2].group);
        }

        this.series[2].icon.translate(
                this.chartWidth / 2 - 10,
                this.plotHeight / 2 - this.series[2].points[0].shapeArgs.innerR -
                (this.series[2].points[0].shapeArgs.r - this.series[2].points[0].shapeArgs.innerR) / 2
                );
            $(".spinner").blur(function () {
               $(this).spinner("destroy");
            });
    }

//------------------------------------------------------------------------------    
    //--------------------------------------------------------------------------------------------------------------------------------------
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialSelectUf',
        type: 'POST',
        dataType: 'json',
        data: {uf: this.value},
        success: function (obj) {
            if (obj != null) {
                // var data = obj.data;
                var selectbox = $('#uf_filtro');
                selectbox.find('option').remove();
                $('<option>').val('').text('Selecione.. ').appendTo(selectbox);
                $.each(obj, function (i, d) {
                    $('<option>').val(d.id).text(d.label).appendTo(selectbox);
                });
            }
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
    //---------------------------------------------------------------------------------------------------------------------------------------
    $('#uf_filtro').on('change', function () {
        $('#dadosContratos').hide();
        $.ajax({
            url: base_url + 'index_cgob.php/gerencialSelectContratos',
            type: 'POST',
            dataType: 'json',
            data: {uf: this.value},
            success: function (obj) {
                if (obj != null) {
                    // var data = obj.data;
                    var selectbox = $('#contrato_filtro');
                    selectbox.find('option').remove();
                    $('<option>').val('').text('Selecione.. ').appendTo(selectbox);
                    $.each(obj, function (i, d) {
                        $('<option>').val(d.id).text(d.label).appendTo(selectbox);
                    });
                }
            }, error: function (data) {
                $.notify('Falha no cadastro', "warning");
            }
        });
    });

    $('#contrato_filtro').on('change', function () {
        if (this.value != '') {
            $('#id_contrato_obra').val(this.value);
            populaDadosAbaObra(this.value);
            populaDadosAbaObraResumo(this.value);
            populaDadosAbaObraAmbiental(this.value);
            populaDadosAbaObraInterferencias(this.value);
            populaDadosAbaObraFotos(this.value);
            populaDadosAbaObraHidrovia(this.value);
            populaDadosAbaObraFinanceiro(this.value);
            montaGraficoObraResumoFinanceiroGrafico(this.value);
            montaGraficoObraResumoCurvaSGrafico(this.value);
            montaTabelaObraResumoAditivos(this.value);

            $('#dadosContratos').show();
        } else {
            $('#dadosContratos').hide();
        }
    });

    $('#painel_supervisao').on('click', function () {
        if ($('#id_contrato_obra').val() != '') {
            populaDadosAbaSupervisao($('#id_contrato_obra').val());
            populaDadosAbaSupervisaoResumoFinanceiro($('#id_contrato_obra').val());
            montaTabelaSupervisaoResumoAditivos($('#id_contrato_obra').val());
            montaTabelaSupervisaoResumoArt($('#id_contrato_obra').val());
            montaGraficoSupervisaoResumoFinanceiroGrafico($('#id_contrato_obra').val());
            montaGraficoSupervisaoResumoCurvaSGrafico($('#id_contrato_obra').val());
            $('#dadosContratos').show();
        } else {
            $('#dadosContratos').hide();
        }
    });

	$('#salvarResumo').on('click', function () {
		var resumo = $.trim($("#textoResumo").val());
		if(resumo){
			$.ajax({
				url: base_url + 'index_cgob.php/gerencialObraInserirResumo',
				type: 'POST',
				dataType: 'json',
				data: {id_contrato_obra: $('#id_contrato_obra').val(), resumo: resumo},
				success: function (obj) {
					$.notify('Resumo inserido com sucesso', "success");
					populaDadosAbaObraResumo($('#id_contrato_obra').val());
					$('#modalObraResumo').modal('hide');
				}, error: function (data) {
					$.notify('Falha no cadastro', "warning");
				}
			});
		}else{
			alert('Insira o texto do resumo!');
		}
	});

//------------------------------------------------------------------------------

$('#painel_obra_relatorio').on('click', function () {
         var id = $("#id_contrato_obra").val();
         
        //-------------------------------------------------------
	$("#painel_obra_relatorio").show();
        //------------------------------------------------------- 
        $('#datepicker').datepicker({
            format: "MM yyyy",
            startView: 1,
            minViewMode: 1,
            language: "pt-BR",
            autoclose: true
        });
        //-------------------------------------------------------  
        var dt = new Date();
        var myDate = new Date();
        myDate.setMonth(myDate.getMonth() - 1);
        $("#datepicker").datepicker("setDate", myDate);
        //-------------------------------------------------------
        $('#elaboracao').hide();
        $('#correcao').hide();
        $('#aguardandoanalise').hide();
        $('#aguardandoanaliseFiscal').hide();
        $('#aguardandoanaliseResponsavel').hide();
        $('#resultadotecnico').hide();
        $('#resultadoestrutural').hide();
        $("#GerarRecibo").hide();
        $("#GerarResultadoTecnico").hide();
        $("#GerarResultadoEstrutural").hide();
        $('#Concluirrelatorio').hide();
        //-------------------------------------------------------
        elaboracaorelatorio(id);
	//-------------------------------------------------------
	$("#searchdate").click(function () {
		elaboracaorelatorio(id);
	});
	//-------------------------------------------------------
	$("#GerarResultadoEstrutural").click(function () {
		GerarResultadoEstrutural(id);
	});
	//-------------------------------------------------------
	$("#GerarResultadoTecnico").click(function () {
		GerarResultadoTecnico(id);
	});
	//-------------------------------------------------------
	$("#GerarResultado").click(function () {
		GerarResultado(id);
	});
	$('#datepicker').on("changeDate", function () {
		elaboracaorelatorio(id);
	});
	//-------------------------------------------------------
	$("#Concluirrelatorio").click(function () {
		finalizarRelatorio(id);
	});
});

//------------------------------------------------------------------------------
});

function populaDadosAbaObra(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraContrato',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#nu_con_formatado').html(obj.nu_con_formatado);
            $('#no_empresa').html(obj.no_empresa);
            $('#municipioUf').html(obj.municipioUf);
            $('#objetivo_contrato').html(obj.ds_objeto);
            $('#modalidade').html(obj.modalidade_licitacao);
            $('#nu_edital').html(obj.nu_edital);
            $('#mesBase').html(obj.mesBase);
            $('#tipoIntervencao').html(obj.ds_grupo_intervencao);
            $('#assinatura').html(obj.assinatura);
            $('#ordemInicio').html(obj.ordemInicio);
            $('#diasParalisados').html(obj.nu_dia_paralisacao);
            $('#diasAditados').html(obj.nu_dia_prorrogacao);
            $('#dataTerminoServico').html(obj.dataTerminoServico);
            $('#dataTerminoVigencia').html(obj.dataTerminoVigencia);
            $('#diasVencer').html(obj.diasVencer);
            $('#unidadeFiscalizadora').html(obj.sg_und_fiscal + ' - ' + obj.nm_und_fiscal);
            $('#fiscal').html(obj.nome_fiscal);
            $('#email').html(obj.email);
            $('#telefone').html(obj.telefone);
            $('#pba').html(obj.pba);
            $('#pbai').html(obj.pbai);
            $('#hidrovia').html(obj.hidrovia);
            $('#supervisao').html(obj.nu_con_formatado_supervisor);

        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function populaDadosAbaObraFinanceiro(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraResumoFinanceiro',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#valor_pi').html(obj.valor_pi);
            $('#aditivos').html(obj.aditivos);
            $('#reajustamento').html(obj.reajustamento);
            $('#valor_total').html(obj.valor_total);
            $('#total_medido').html(obj.total_medido);
            $('#total_medido_piar').html(obj.total_medido_piar);
            $('#valor_medir').html(obj.valor_medir);
            $('#total_empenhado').html(obj.total_empenhado);
            $('#saldo_empenhado').html(obj.saldo_empenhado);
            $('#a_empenhar').html(obj.a_empenhar);

            $('#obra_valor_pi').html(obj.valor_pi);
            $('#obra_valor_aditivos').html(obj.aditivos);
            $('#obra_reajustamento').html(obj.reajustamento);
            $('#obra_valor_total').html(obj.valor_total);

            Highcharts.chart('ObraAditivoPizza', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{point.name}: {point.y}<b>({point.percentage:.1f}%)</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
					}
				},
                series: [{
                    colorByPoint: true,
                    data: [{
                        name: 'Valor Pi',
                        y: obj.cal_valor_pi,
						sliced: true,
						selected: true,
						color: '#f45b5b'
                    }, {
                        name: 'Aditivos',
                        y: obj.cal_aditivos,
						color: '#0ccdd6'
                    }, {
                        name: 'Reajustamento',
                        y: obj.cal_reajustamento,
						color: '#6495ed'
                    }]
                }]
            });
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function populaDadosAbaObraResumo(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraResumo',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#resumo').html(obj.resumo);
            $('#dataResumo').attr({
                "title" : obj.ultima_alteracao
            });
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function populaDadosAbaObraFotos(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraDadosFotos',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            var mesFoto = '';
            $.each(obj, function (i, d) {
                mesFoto = mesFoto + ' <div class="col-md-2 col-sm-6 col-xs-12"\n' +
                    'href="javascript:void(0);"\n' +
                    'onclick="mostraModalFotos(' + id_contrato_obra + ',\'' + d.periodo_referencia + '\');">\n' +
                    '<div class="info-box">\n' +
                    '<span class="info-box-icon bg-info"><i\n' +
                    'class="fa fa-camera"></i></span>\n' +
                    '<div class="info-box-content">\n' +
                    '<span class="info-box-number">' + d.mesAno + '</span>\n' +
                    '<span class="info-box-text">' + d.qtd + ' Fotos</span>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div> ';
            });
            $('#periodoFotos').html(mesFoto);
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

//------------------------------------------------------------------------------
function mostraModalFotos(id_contrato_obra, periodo) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraFotosPeriodo',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra, periodo: '' + periodo},
        success: function (obj) {
            var modalFotos = '';
            $.each(obj, function (i, d) {
                $('#tituloFotos').html(d.mesAno);
                modalFotos = modalFotos + '<div class="row">' +
                    '<div class="col-xs-12 col-sm-12 col-md-3"><small>Estaca</small><br><b>' + d.estaca + '</b></div>' +
                    '<div class="col-xs-12 col-sm-12 col-md-3"><small>Data</small><br><b>' + d.atualizacao + '</b></div>' +
                    '<div class="col-xs-12 col-sm-12 col-md-3"><small>Fuso</small><br><b> - </b></div>' +
                    '<div class="col-xs-12 col-sm-12 col-md-3">' +
                    '<div class="row" style="text-align: center;">' +
                    '<div class="col-md-12"><small>Coordenadas</small></div>' +
                    '<div class="col-md-6"><small>N</small><br><b>' + d.latitude + '</b></div>' +
                    '<div class="col-md-6"><small>E</small><br><b>' + d.longitude + '</b></div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-xs-12 col-sm-12 col-md-12"><small>Descrição</small><br><b>' + d.descricao + '</b></div>' +
                    '</div>' +
                    d.miniatura +
                    '<div class="row">' +
                    '<div class="col-md-1 offset-md-9">' + d.link + '</div></div>' +
                    '</div>' +
                    '<hr>' +
                    '';
            });
            $('#carouselFotos').html(modalFotos);
            $("#modalPainelFotos").modal("show");
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function montaGraficoObraResumoFinanceiroGrafico(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraResumoFinanceiroGrafico',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            Highcharts.chart('graficoFinanceiro', {
                chart: {
                    type: 'solidgauge',
                    height: '110%',
                    events: {
                        render: renderIcons
                    }
                },

                title: {
                    text: '',
                    style: {
                        fontSize: '24px'
                    }
                },

                tooltip: {
                    borderWidth: 0,
                    backgroundColor: 'none',
                    shadow: false,
                    style: {
                        fontSize: '16px'
                    },
                    valueSuffix: '%',
                    pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
                    positioner: function (labelWidth) {
                        return {
                            x: (this.chart.chartWidth - labelWidth) / 2,
                            y: (this.chart.plotHeight / 2) - 25
                        };
                    }
                },

                pane: {
                    startAngle: 0,
                    endAngle: 360,
                    background: [{ // Track for Move
                        outerRadius: '112%',
                        innerRadius: '88%',
                        backgroundColor: Highcharts.color('#6495ed')
                            .setOpacity(0.3)
                            .get(),
                        borderWidth: 0
                    }, { // Track for Exercise
                        outerRadius: '87%',
                        innerRadius: '63%',
                        backgroundColor: Highcharts.color('#f45b5b')
                            .setOpacity(0.3)
                            .get(),
                        borderWidth: 0
                    }, { // Track for Stand
                        outerRadius: '62%',
                        innerRadius: '38%',
                        backgroundColor: Highcharts.color('#0ccdd6')
                            .setOpacity(0.3)
                            .get(),
                        borderWidth: 0
                    }]
                },

                yAxis: {
                    min: 0,
                    max: 100,
                    lineWidth: 0,
                    tickPositions: []
                },

                plotOptions: {
                    solidgauge: {
                        dataLabels: {
                            enabled: false
                        },
                        linecap: 'round',
                        stickyTracking: false,
                        rounded: true
                    }
                },

                series: [{
                    name: 'Empenhado',
                    data: [{
                        color: '#6495ed',
                        radius: '112%',
                        innerRadius: '88%',
                        y: obj.empenhado
                    }]
                }, {
                    name: 'Medido (PI + A + R)',
                    data: [{
                        color: '#f45b5b',
                        radius: '87%',
                        innerRadius: '63%',
                        y: obj.medido
                    }]
                }, {
                    name: 'Valor a Medir',
                    data: [{
                        color: '#0ccdd6',
                        radius: '62%',
                        innerRadius: '38%',
                        y: obj.medir
                    }]
                }]
            });
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function renderIcons() {

    // Move icon
    if (!this.series[0].icon) {
        this.series[0].icon = this.renderer.path(['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8])
            .attr({
                stroke: '#303030',
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
                'stroke-width': 2,
                zIndex: 10
            })
            .add(this.series[2].group);
    }
    this.series[0].icon.translate(
        this.chartWidth / 2 - 10,
        this.plotHeight / 2 - this.series[0].points[0].shapeArgs.innerR -
        (this.series[0].points[0].shapeArgs.r - this.series[0].points[0].shapeArgs.innerR) / 2
    );

    // Exercise icon
    if (!this.series[1].icon) {
        this.series[1].icon = this.renderer.path(
            ['M', -8, 0, 'L', 8, 0, 'M', 0, -8, 'L', 8, 0, 0, 8,
                'M', 8, -8, 'L', 16, 0, 8, 8]
        )
            .attr({
                stroke: '#ffffff',
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
                'stroke-width': 2,
                zIndex: 10
            })
            .add(this.series[2].group);
    }
    this.series[1].icon.translate(
        this.chartWidth / 2 - 10,
        this.plotHeight / 2 - this.series[1].points[0].shapeArgs.innerR -
        (this.series[1].points[0].shapeArgs.r - this.series[1].points[0].shapeArgs.innerR) / 2
    );

    // Stand icon
    if (!this.series[2].icon) {
        this.series[2].icon = this.renderer.path(['M', 0, 8, 'L', 0, -8, 'M', -8, 0, 'L', 0, -8, 8, 0])
            .attr({
                stroke: '#303030',
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
                'stroke-width': 2,
                zIndex: 10
            })
            .add(this.series[2].group);
    }

    this.series[2].icon.translate(
        this.chartWidth / 2 - 10,
        this.plotHeight / 2 - this.series[2].points[0].shapeArgs.innerR -
        (this.series[2].points[0].shapeArgs.r - this.series[2].points[0].shapeArgs.innerR) / 2
    );
};

function montaGraficoObraResumoCurvaSGrafico(id_contrato_obra) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/gerencialObraResumoCurvaSGrafico',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (data) {

            var data_comum = data.data_comum;
            var charPrevisto = data.charPrevisto;
            var charExecutado = data.charExecutado;

            var cMain = charPrevisto;
            var cMainn = charExecutado;

            //------------------------------------------
            var chart = new Highcharts.Chart({
                chart: {
                    type: 'spline',
                    animation: false,
                    renderTo: 'grafico_obra_curva_s'
                },
                exporting: {
                    fallbackToExportServer: false,
                    enabled: false
                },
                title: {
                    text: '',
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            align: 'right',
                            style: {'fontSize': '9px'},
                            enabled: true,
                            //format: {point.color};z-index:100;'>{point.y:,.2f}</font>",
                            useHTML: true,
                            valuePrefix: 'R$ ',
                            formatter: function () {
                                return "<font style='color:" + this.color + ";z-index:100;'>" + monetarioReduzido(this.y) + "</font>";
                            }
                        }
                    }
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: data_comum
                },
                yAxis: {
                    title: {
                        text: 'Valores Acumulados (R$)'
                    },
                    labels: {
                        formatter: EscalaMonetarioReduzido
                    }
                },
                tooltip: {
                    valuePrefix: 'R$ ',
                    shared: true
                },
                colors: ['#058DC7', '#6f0b6c'],
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    floating: true,
                    y: -300,
                    x: 100,
                    borderWidth: 1,
                    backgroundColor: 'white'
                },
                series: [{
                    name: 'Valor Previsto (PI)',
                    data: cMain
                }, {
                    name: 'Valor Executado (PI)',
                    data: cMainn
                }]
            });
        }
    });

    function monetarioReduzido(y) {
        var kb = 1000,
            mb = 1000000,
            gb = 1000000000;

        if (y > gb)
            return "≅" + (y / gb).toFixed(2) + " bi";
        else if (y > mb)
            return "≅" + (y / mb).toFixed(2) + " mi";
        else if (y > kb)
            return "≅" + (y / kb).toFixed(2) + " mil";
        else
            return "≅" + (y).toFixed(2);
    }

    function EscalaMonetarioReduzido() {
        var maxElement = this.axis.max,
            kb = 1000,
            mb = 1000000,
            gb = 1000000000;

        if (maxElement > gb)
            return "R$ " + (this.value / gb).toFixed(0) + " bi";
        else if (maxElement > mb)
            return "R$ " + (this.value / mb).toFixed(0) + " mi";
        else if (maxElement > kb)
            return "R$ " + (this.value / kb).toFixed(0) + " mil";
        else
            return "R$ " + (this.value);
    }
}


function montaTabelaObraResumoAditivos(id_contrato_obra) {
    var table = $('#tableObraAditivo').DataTable();
    table.destroy();
    //Apresentação Supervisora table Aditivo------------------------------------
    $('#tableObraAditivo').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/gerencialObraAditivos",
        "fnServerParams": function (aoData) {
            aoData.push(
                {"name": "id_contrato_obra", "value": id_contrato_obra}
            );
        },
        "aoColumns": [
            {data: 'NUMERO_TERMO', "sClass": "text-center", "width": "15%"},
            {data: 'DATA_ASSINATURA', "sClass": "text-center", "width": "10%"},
            {data: 'OBJETO_TERMO', "sClass": "text-center", "width": "10%"},
            {data: 'VALOR_ADITADO', "sClass": "text-center", "width": "10%"},
            {data: 'DIAS_ADITADOS', "sClass": "text-center", "width": "10%"},
        ]
    });
}

// ---------------------------------------------------------------------------------------------
// -----------------------------------SUPERVISAO------------------------------------------------
// ---------------------------------------------------------------------------------------------
function populaDadosAbaSupervisao(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialSupervisaoDados',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#statusSupervisao').html(obj.statusSupervisao);
            $('#sup_contrato').html(obj.sup_contrato);
            $('#supervisao_nome').html(obj.supervisao_nome);
            $('#sup_objetivo').html(obj.sup_objetivo);
            $('#sup_regime').html(obj.sup_regime);
            $('#sup_edital').html(obj.sup_edital);
            $('#sup_mesBase').html(obj.sup_mesBase);
            $('#sup_tp_intervencao').html(obj.sup_tp_intervencao);
            $('#sup_assinatura').html(obj.sup_assinatura);
            $('#sup_ordem_inicio').html(obj.sup_ordem_inicio);
            $('#sup_dias_paralisados').html(obj.sup_dias_paralisados);
            $('#sup_dias_aditados').html(obj.sup_dias_aditados);
            $('#sup_data_termino_servico').html(obj.sup_data_termino_servico);
            $('#sup_data_termino_vigencia').html(obj.sup_data_termino_vigencia);
            $('#sup_dias_vencer').html(obj.sup_dias_vencer);
            $('#sup_unidade_fiscalizadora').html(obj.sup_unidade_fiscalizadora);
            $('#sup_fiscal').html(obj.sup_fiscal);
            $('#sup_email').html(obj.sup_email);
            $('#sup_telefone').html(obj.sup_telefone);

        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function populaDadosAbaSupervisaoResumoFinanceiro(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialSupervisaoResumoFinanceiro',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#sup_valor_pi').html(obj.sup_valor_pi);
            $('#sup_valor_aditivos').html(obj.sup_valor_aditivos);
            $('#sup_reajustamento').html(obj.sup_reajustamento);
            $('#sup_valor_total').html(obj.sup_valor_total);
            $('#sup_valor_medido').html(obj.sup_valor_medido);
            $('#sup_valor_medido_piar').html(obj.sup_valor_medido_piar);
            $('#sup_valor_medir').html(obj.sup_valor_medir);
            $('#sup_total_empenhado').html(obj.sup_total_empenhado);
            $('#sup_saldo_empenhado').html(obj.sup_saldo_empenhado);
            $('#sup_saldo_empenhar').html(obj.sup_saldo_empenhar);

            $('#sup_aditivo_valor_pi').html(obj.sup_valor_pi);
            $('#sup_aditivo_aditivos').html(obj.sup_valor_aditivos);
            $('#sup_aditivo_reajustamento').html(obj.sup_reajustamento);
            $('#sup_aditivo_valor_total').html(obj.sup_valor_total);

            Highcharts.chart('SupervisaoAditivoPizza', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
					pointFormat: '{point.name}: {point.y}<b>({point.percentage:.1f}%)</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
                    }
                },
                series: [{
                    name: ' ',
                    colorByPoint: true,
                    data: [{
                        name: 'Valor Pi',
                        y: obj.sup_valor_pi_pizza,
						sliced: true,
						selected: true,
						color: '#f45b5b'
                    }, {
                        name: 'Aditivos',
                        y: obj.sup_valor_aditivos_pizza,
						color: '#0ccdd6'
                    }, {
                        name: 'Reajustamento',
                        y: obj.sup_reajustamento_pizza,
						color: '#6495ed'
                    }]
                }]
            });
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function montaTabelaSupervisaoResumoAditivos(id_contrato_obra) {
    //Apresentação Supervisora table Aditivo------------------------------------
    var table = $('#tableSupervAditivo').DataTable();
    table.destroy();
    $('#tableSupervAditivo').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/gerencialSupervisaoAditivos",
        "fnServerParams": function (aoData) {
            aoData.push(
                {"name": "id_contrato_obra", "value": id_contrato_obra}
            );
        },
        "aoColumns": [
            {data: 'NUMERO_TERMO', "sClass": "text-center", "width": "15%"},
            {data: 'DATA_ASSINATURA', "sClass": "text-center", "width": "10%"},
            {data: 'OBJETO_TERMO', "sClass": "text-center", "width": "10%"},
            {data: 'VALOR_ADITADO', "sClass": "text-center", "width": "10%"},
            {data: 'DIAS_ADITADOS', "sClass": "text-center", "width": "10%"},
        ]
    });
}

function montaGraficoSupervisaoResumoFinanceiroGrafico(id_contrato_obra) {
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialSupervisaoResumoFinanceiroGrafico',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            Highcharts.chart('graficoSupervisaoFinanceiro', {
                chart: {
                    type: 'solidgauge',
                    height: '110%',
                    events: {
                        render: renderIcons
                    }
                },

                title: {
                    text: '',
                    style: {
                        fontSize: '24px'
                    }
                },

                tooltip: {
                    borderWidth: 0,
                    backgroundColor: 'none',
                    shadow: false,
                    style: {
                        fontSize: '16px'
                    },
                    valueSuffix: '%',
                    pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
                    positioner: function (labelWidth) {
                        return {
                            x: (this.chart.chartWidth - labelWidth) / 2,
                            y: (this.chart.plotHeight / 2) - 25
                        };
                    }
                },

                pane: {
                    startAngle: 0,
                    endAngle: 360,
                    background: [{ // Track for Move
                        outerRadius: '112%',
                        innerRadius: '88%',
                        backgroundColor: Highcharts.color('#6495ed')
                            .setOpacity(0.3)
                            .get(),
                        borderWidth: 0
                    }, { // Track for Exercise
                        outerRadius: '87%',
                        innerRadius: '63%',
                        backgroundColor: Highcharts.color('#f45b5b')
                            .setOpacity(0.3)
                            .get(),
                        borderWidth: 0
                    }, { // Track for Stand
                        outerRadius: '62%',
                        innerRadius: '38%',
                        backgroundColor: Highcharts.color('#0ccdd6')
                            .setOpacity(0.3)
                            .get(),
                        borderWidth: 0
                    }]
                },

                yAxis: {
                    min: 0,
                    max: 100,
                    lineWidth: 0,
                    tickPositions: []
                },

                plotOptions: {
                    solidgauge: {
                        dataLabels: {
                            enabled: false
                        },
                        linecap: 'round',
                        stickyTracking: false,
                        rounded: true
                    }
                },

                series: [{
                    name: 'Empenhado',
                    data: [{
                        color: '#6495ed',
                        radius: '112%',
                        innerRadius: '88%',
                        y: obj.empenhado
                    }]
                }, {
                    name: 'Medido (PI + A + R)',
                    data: [{
                        color: '#f45b5b',
                        radius: '87%',
                        innerRadius: '63%',
                        y: obj.medido
                    }]
                }, {
                    name: 'Valor a Medir',
                    data: [{
                        color: '#0ccdd6',
                        radius: '62%',
                        innerRadius: '38%',
                        y: obj.medir
                    }]
                }]
            });
        }, error: function (data) {
            $.notify('Falha no cadastro', "warning");
        }
    });
}

function montaGraficoSupervisaoResumoCurvaSGrafico(id_contrato_obra) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/gerencialSupervisaoResumoCurvaSGrafico',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (data) {

            var data_comum = data.data_comum;
            var charPrevisto = data.charPrevisto;
            var charExecutado = data.charExecutado;

            var cMain = charPrevisto;
            var cMainn = charExecutado;

            //------------------------------------------
            var chart = new Highcharts.Chart({
                chart: {
                    type: 'spline',
                    animation: false,
                    renderTo: 'grafico_supervisao_curva_s'
                },
                exporting: {
                    fallbackToExportServer: false,
                    enabled: false
                },
                title: {
                    text: '',
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            align: 'right',
                            style: {'fontSize': '9px'},
                            enabled: true,
                            //format: {point.color};z-index:100;'>{point.y:,.2f}</font>",
                            useHTML: true,
                            valuePrefix: 'R$ ',
                            formatter: function () {
                                return "<font style='color:" + this.color + ";z-index:100;'>" + monetarioReduzido(this.y) + "</font>";
                            }
                        }
                    }
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: data_comum
                },
                yAxis: {
                    title: {
                        text: 'Valores Acumulados (R$)'
                    },
                    labels: {
                        formatter: EscalaMonetarioReduzido
                    }
                },
                tooltip: {
                    valuePrefix: 'R$ ',
                    shared: true
                },
                colors: ['#058DC7', '#6f0b6c'],
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    floating: true,
                    y: -300,
                    x: 100,
                    borderWidth: 1,
                    backgroundColor: 'white'
                },
                series: [ {
                    name: 'Valor Executado (PI)',
                    data: cMainn
                }]
            });
        }
    });

    function monetarioReduzido(y) {
        var kb = 1000,
            mb = 1000000,
            gb = 1000000000;

        if (y > gb)
            return "≅" + (y / gb).toFixed(2) + " bi";
        else if (y > mb)
            return "≅" + (y / mb).toFixed(2) + " mi";
        else if (y > kb)
            return "≅" + (y / kb).toFixed(2) + " mil";
        else
            return "≅" + (y).toFixed(2);
    }

    function EscalaMonetarioReduzido() {
        var maxElement = this.axis.max,
            kb = 1000,
            mb = 1000000,
            gb = 1000000000;

        if (maxElement > gb)
            return "R$ " + (this.value / gb).toFixed(0) + " bi";
        else if (maxElement > mb)
            return "R$ " + (this.value / mb).toFixed(0) + " mi";
        else if (maxElement > kb)
            return "R$ " + (this.value / kb).toFixed(0) + " mil";
        else
            return "R$ " + (this.value);
    }
}
//------------------------------------------------------------------------------
function PainelIDFin() {

    $('#modalPainelIDFin').modal('show');

    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/painelgerencial_PainelIDFin',
        dataType: 'json',
        success: function (data) {
            if (data.indice != null) {

                var indice = parseFloat(data.indice);
                $("span[id='val_indice']").text(indice.toFixed(2));

                $('#grafico_obra_idfin').highcharts({
                    chart: {
                        type: 'gauge',
                        height: 200,
                        backgroundColor: "#ffffff"
                    },
                    title: {
                        text: null
                    },
                    pane: [{
                            startAngle: -90,
                            endAngle: 90,
                            background: null,
                            center: ['50%', '90%'],
                            size: 300
                        }],
                    tooltip: {
                        enabled: false
                    },
                    exporting: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    },
                    yAxis: [{
                            min: 0.1,
                            max: 10,
                            type: 'logarithmic',
                            minorTickInterval: null,
                            tickLength: 0,
                            labels: {
                                y: 100000
                            },
                            plotBands: [{
                                    from: 0,
                                    to: 1,
                                    color: '#C02316', //Vermelho
                                    innerRadius: '100%',
                                    outerRadius: '110%'
                                }, {
                                    from: 1,
                                    to: 10,
                                    color: '#23C016', //Verde
                                    innerRadius: '100%',
                                    outerRadius: '110%'
                                }]
                        }],
                    plotOptions: {
                        gauge: {
                            dataLabels: {
                                enabled: false
                            },
                            dial: {
                                radius: '100%'
                            }
                        }
                    },
                    series: [{
                            data: [indice]
                        }]
                });
            } else {
                $("span[id='val_indice']").text("Sem registro.");
            }
            $(".spinner").blur(function () {
               $(this).spinner("destroy");
            });
        }
    });
    $(".spinner").blur(function () {
        $(this).spinner("destroy");
     });
}

//------------------------------------------------------------------------------
function PainelIDFin_old_11112021_0844(){
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraResumoCurvaSIDFinGrafico',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: $('#id_contrato_obra').val()},
        success: function (obj) {
            $('#modalPainelIDFin').modal('show');
            Highcharts.chart('graficoIDFin', {
                chart: {
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                title: {
                    text: ''
                },
                pane: {
                    startAngle: -90,
                    endAngle: 90,
                    background: [{
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0},
                            stops: [
                                [0, '#FFF']
                            ]
                        },
                        borderWidth: 0,
                        outerRadius: '109%'
                    }, {
                        // default background
                    }, {
                        backgroundColor: '#DDD',
                        borderWidth: 10,
                        outerRadius: '105%',
                        innerRadius: '103%'
                    }]
                },

                // the value axis
                yAxis: {
                    min: 0,
                    max: 2,

                    labels: {
                        step: 2,
                        rotation: 'auto'
                    },
                    title: {
                        text: ''
                    },
                    plotBands: [{
                        from: 0,
                        to: 1,
                        color: '#c02316' // vermelho
                    }, {
                        from: 1,
                        to: 2,
                        color: '#23c016' // verde
                    }]
                },

                series: [{
                    name: '',
                    data: [obj]
                }]

            });
        }, error: function (data) {
            $.notify('Falha no retorno dos dados', "warning");
        }
    });
}

//------------------------------------------------------------------------------
function PainelMedicao() {

    $('#modalPainelMedicao').modal('show');

    $('#tableMedicoes').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": true,
        "destroy": true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/painelgerencial_PainelMedicao",
        "aoColumns": [
            {data: 'N_MEDICAO'},
            {data: 'PROCESSAMENTO'},
            {data: 'TERMINO'},
            {data: 'VALOR_PI'},
            {data: 'VALOR_REAJUSTE'},
            {data: 'TOTAL'}
        ]
    });
    $(".spinner").blur(function () {
        $(this).spinner("destroy");
     });
}
//------------------------------------------------------------------------------
function PainelMedicaoSupervisora() {

    $('#modalPainelMedicaoSupervisora').modal('show');

    $('#tableMedicoesSupervisora').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": true,
        "destroy": true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/painelgerencial_PainelMedicaoSupervisora",
        "aoColumns": [
            {data: 'N_MEDICAO'},
            {data: 'PROCESSAMENTO'},
            {data: 'TERMINO'},
            {data: 'VALOR_PI'},
            {data: 'VALOR_REAJUSTE'},
            {data: 'TOTAL'}
        ]
    });
    $(".spinner").blur(function () {
        $(this).spinner("destroy");
     });
}
//------------------------------------------------------------------------------
function PainelMedicao_old_11112021_1006(){
    $('#modalPainelMedicao').modal('show');

    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraResumoCurvaSMedicaoGrafico',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: $('#id_contrato_obra').val()},
        success: function (obj) {
            $('#tabelaMedicoes').html(obj);
        }, error: function (data) {
            $.notify('Erro ao ler dados da Curva S', "warning");
        }
    });
}

function PainelFisico(){
    $('#modalPainelFisico').modal('show');
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraResumoCurvaSTabelaFisico',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: $('#id_contrato_obra').val()},
        success: function (obj) {
            $('#tabelaAvancoFisico').html(obj);
        }, error: function (data) {
            $.notify('Erro ao ler dados do Acompanhamento Físico', "warning");
        }
    });
}

function PainelFinanceiro(){
    $('#modalPainelFinanceiro').modal('show');
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraResumoCurvaSTabelaFinanceiro',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: $('#id_contrato_obra').val()},
        success: function (obj) {
            $('#tabelaAcompanhamentoFinanceiro').html(obj);
        }, error: function (data) {
            $.notify('Erro ao ler dados do Acomapnhamento Financeiro', "warning");
        }
    });

}

function populaDadosAbaObraAmbiental(id_contrato_obra){
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraAmbiental',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#tableObraAmbiental').html(obj);
        }, error: function (data) {
            $.notify('Erro ao ler dados Ambientais', "warning");
        }
    });
}

function populaDadosAbaObraInterferencias(id_contrato_obra){
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraInterferencias',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#tableObraInterferencias').html(obj);
        }, error: function (data) {
            $.notify('Erro ao ler dados da Interferência', "warning");
        }
    });
}

function populaDadosAbaObraHidrovia(id_contrato_obra){
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialObraHidrovia',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#painelHidrovia').html(obj);
        }, error: function (data) {
            $.notify('Erro ao ler dados da Hidrovia', "warning");
        }
    });
}

//------------------------------------------------------------------------------
function modalObjetoMotivacaoAditivo(id_termo_aditivo) {
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/modalObjetoMotivacaoAditivoDaq',
		data: {id_termo_aditivo: id_termo_aditivo},
		dataType: 'json',
		success: function (data) {
			$("#objeto_modal").html(data.objeto);
			$("#motivacao_modal").html(data.motivacao);
			$("#modalObjetoMotivacaoAditivo").modal("show");
		}
	});
}
//------------------------------------------------------------------------------
function modalObjetoMotivacaoAditivoSupervisora(id_termo_aditivo) {
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/modalAditivoSupDaq',
        data: {id_termo_aditivo: id_termo_aditivo},
        dataType: 'json',
        success: function (data) {
            $("#objeto_modal").html(data.objeto);
            $("#motivacao_modal").html(data.motivacao);
            $("#modalObjetoMotivacaoAditivo").modal("show");
        }
    });
}

function montaTabelaSupervisaoResumoArt(id_contrato_obra){
    $.ajax({
        url: base_url + 'index_cgob.php/gerencialSupervisaoArt',
        type: 'POST',
        dataType: 'json',
        data: {id_contrato_obra: id_contrato_obra},
        success: function (obj) {
            $('#superv_art').html(obj);
        }, error: function (data) {
            $.notify('Erro ao ler dados ART\'s', "warning");
        }
    });
}

//------------------------------------------------------------------------------
function artAnexo_old_24112021_1215(nome_arquivo) {
    $.ajax({
        url: base_url + 'index_cgob.php/artAnexo',
        type: 'POST',
        data: {nome_arquivo: nome_arquivo},
        success: function (data) {
            var arquivo = base_url+'/arquivoDaq/arq/'+nome_arquivo;
            var anchor = document.createElement('a');
            anchor.setAttribute("download", nome_arquivo);
            anchor.setAttribute("href", arquivo);
            anchor.click();
            $.notify('Download!', "success");
            artexcluir(nome_arquivo);
        }, error: function (data) {
            $.notify('Falha no download!', "warning");
        }
    });
}
function artAnexo(nome_arquivo) {
	$.ajax({
		url: base_url + 'index_cgob.php/artAnexo',
		type: 'POST',
		data: {nome_arquivo: nome_arquivo},
		success: function (data) {
			var arquivo = base_url + 'index_cgob.php/70bc1de8a077e52493d9c41ffaa3c051ARQ?arq=' + nome_arquivo;
			var anchor = document.createElement('a');
			anchor.setAttribute("download", nome_arquivo);
			anchor.setAttribute("href", arquivo);
			anchor.click();
			$.notify('Download!', "success");
//            artexcluir(nome_arquivo);
		}, error: function (data) {
			$.notify('Falha no download!', "warning");
		}
	});
}

function inserirResumo(){
	$('#modalObraResumo').modal('show');
}
//------------------------------------------------------------------------------
function PainelEmpenhoRAP() {            

    $('#modalPainelEmpenhoRAP').modal('show');
    
    
    $('#tableEmpenhos').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "destroy": true,
        "pageLength": 10,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/painelgerencial_PainelEmpenhoRAP",
        "aoColumns": [
            {data: 'NOTA'},
            {data: 'EMISSAO'},
            {data: 'INICIAL'},
            {data: 'AJUSTE'},
            {data: 'CONSUMIDO'},
            {data: 'SALDO'}
        ]
    });
    
    
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/painelgerencial_TablePainelEmpenhosSoma',
        dataType: 'json',
        success: function (data) {
           $(".somavalor_empenho_inicial").text(data.somavalor_empenho_inicial);
           $(".somavalor_empenho_ajuste").text(data.somavalor_empenho_ajuste); 
           $(".somavalor_empenho_consumido").text(data.somavalor_empenho_consumido); 
           $(".somavalor_empenho_saldo").text(data.somavalor_empenho_saldo); 
           $(".spinner").blur(function () {
               $(this).spinner("destroy");
            });
        }
    });
    
    

    $('#tableRap').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "destroy": true,
        "pageLength": 10,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/painelgerencial_TablePainelRap",
        "aoColumns": [
            {data: 'NOTA'},
            {data: 'EMISSAO'},
            {data: 'INICIAL'},
            {data: 'AJUSTE'},
            {data: 'CONSUMIDO'},
            {data: 'SALDO'}
        ]
    });
    
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/painelgerencial_TablePainelRapSoma',
        dataType: 'json',
        success: function (data) {
           $(".somarap_valor_empenho_inicial").text(data.somarap_valor_empenho_inicial);
           $(".somarap_valor_empenho_ajuste").text(data.somarap_valor_empenho_ajuste); 
           $(".somarap_valor_empenho_consumido").text(data.somarap_valor_empenho_consumido); 
           $(".somarap_valor_empenho_saldo").text(data.somarap_valor_empenho_saldo); 
           $(".spinner").blur(function () {
               $(this).spinner("destroy");
            });
        }
    });
    $(".spinner").blur(function () {
        $(this).spinner("destroy");
     });
}
//------------------------------------------------------------------------------
function PainelEmpenhoRAPSupervisora() {            

    $('#modalPainelEmpenhoRAPSupervisora').modal('show');
    
    
    $('#tableEmpenhosSupervisora').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "destroy": true,
        "pageLength": 10,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/painelgerencial_PainelEmpenhoRAPSupervisora",
        "aoColumns": [
            {data: 'NOTA'},
            {data: 'EMISSAO'},
            {data: 'INICIAL'},
            {data: 'AJUSTE'},
            {data: 'CONSUMIDO'},
            {data: 'SALDO'}
        ]
    });
    
    
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/painelgerencial_TablePainelEmpenhosSomaSupervisora',
        dataType: 'json',
        success: function (data) {
           $(".somavalor_empenho_inicial").text(data.somavalor_empenho_inicial);
           $(".somavalor_empenho_ajuste").text(data.somavalor_empenho_ajuste); 
           $(".somavalor_empenho_consumido").text(data.somavalor_empenho_consumido); 
           $(".somavalor_empenho_saldo").text(data.somavalor_empenho_saldo); 
           $(".spinner").blur(function () {
               $(this).spinner("destroy");
            });
        }
    });
    
    

    $('#tableRapSupervisora').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "bPaginate": false,
        "destroy": true,
        "pageLength": 10,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "pageLength": 10,
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "sAjaxSource": base_url + "index_cgob.php/painelgerencial_TablePainelRapSupervisora",
        "aoColumns": [
            {data: 'NOTA'},
            {data: 'EMISSAO'},
            {data: 'INICIAL'},
            {data: 'AJUSTE'},
            {data: 'CONSUMIDO'},
            {data: 'SALDO'}
        ]
    });
    
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/painelgerencial_TablePainelRapSomaSupervisora',
        dataType: 'json',
        success: function (data) {
           $(".somarap_valor_empenho_inicial").text(data.somarap_valor_empenho_inicial);
           $(".somarap_valor_empenho_ajuste").text(data.somarap_valor_empenho_ajuste); 
           $(".somarap_valor_empenho_consumido").text(data.somarap_valor_empenho_consumido); 
           $(".somarap_valor_empenho_saldo").text(data.somarap_valor_empenho_saldo); 
           $(".spinner").blur(function () {
               $(this).spinner("destroy");
            });
        }
    });
    $(".spinner").blur(function () {
        $(this).spinner("destroy");
     });
}
//------------------------------------------------------------------------------
function PainelEmpenho(){
	$('#modalPainelEmpenho').modal('show');
	$.ajax({
		url: base_url + 'index_cgob.php/gerencialObraResumoCurvaSTabelaEmpenho',
		type: 'POST',
		dataType: 'json',
		data: {id_contrato_obra: $('#id_contrato_obra').val()},
		success: function (obj) {
			$('#tabelaEmpenho').html(obj);
		}, error: function (data) {
			$.notify('Erro ao ler dados do Empenho', "warning");
		}
	});
}
//------------------------------------------------------------------------------
function elaboracaorelatorio(id) {
	if (document.getElementById) {
		var dt = $("#datepicker").datepicker('getDate');
		if (dt.toString() == "Invalid Date") {
			$("#datepicker").datepicker("setDate", new Date());
			return;
		}

		var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";

	}
	dadosContrato(termo,id);
	$.ajax({
		type: 'POST',
		url: base_url + 'index_cgob.php/RelatorioElaboracaoDaq?periodo=' + termo+'&id='+id,
		dataType: 'json',
		success: function (data) {
			botaoRelatorio(id);
			if (data.data == 'Aprovado') {
				$('#Concluirrelatorio').hide();
				$('#aguardandoanalise').hide();
				$('#analise').hide();
				$('.analisetecnica').removeClass('nao_preenchido').addClass('aprovado');
				$('.analisetecnica').removeClass('reprovado').addClass('aprovado');
				$('.impressora').removeClass('nao_preenchido').addClass('aprovado');
				$('.impressora').removeClass('reprovado').addClass('aprovado');
				$('#GerarResultadoTecnico').show();
				$('#Liberarrelatorio').hide();
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
				$('#elaboracao').hide();
				botaoRecibo();
				$('#aguardandoanaliseFiscal').hide();
				$('#aguardandoanaliseResponsavel').hide();
			}
			if (data.data == 'Reprovado') {
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
				$('#elaboracao').hide();
				$('#analise').hide();
				$('#Concluirrelatorio').hide();
				$('#aguardandoanalise').hide();
				$('.analisetecnica').removeClass('nao_preenchido').addClass('reprovado');
				$('.impressora').removeClass('nao_preenchido').addClass('reprovado');
				$('#GerarResultadoTecnico').show();
				$('#Liberarrelatorio').show();
				$('#aguardandoanaliseFiscal').hide();
				$('#aguardandoanaliseResponsavel').hide();
			}
			if(data.data == 'ReprovadoFiscal' || data.data == 'ReprovadoFiscalEstrutural'){
				if(data.data == 'ReprovadoFiscal'){
					$('#GerarResultadoTecnico').show();
					$('.analisetecnica').removeClass('nao_preenchido').addClass('reprovado');
				}else{
					$('#GerarResultadoEstrutural').show();
					$('.analiseestrutural').removeClass('nao_preenchido').addClass('reprovado');
				}
				$('#Concluirrelatorio').hide();
				$('#aguardandoanalise').hide();
				// $('.analisetecnica').removeClass('nao_preenchido').addClass('reprovado');
				// $('#GerarResultadoTecnico').show();
				$('#analise').hide();
				$('#Liberarrelatorio').show();
				$('.impressora').removeClass('nao_preenchido').addClass('reprovado');
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
				$('#aguardandoanaliseFiscal').hide();
				if(data.perfil == 2){
					$('#Concluirrelatorio').show();
				}
			}
			if (data.data == 'liberar_relatorio') {
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('#correcao').show();
				$('#analise').hide();
				$('#aguardandoanalise').hide();
				$('#GerarResultadoTecnico').show();
				if(data.qtdAceite == 31){
					$('#Concluirrelatorio').show();
				}
				$('#elaboracao').hide();
				$('#GerarRecibo').hide();
				$('#aguardandoanaliseFiscal').hide();
				$('#aguardandoanaliseResponsavel').hide();
			}
			if (data.data == 'fechar_relatorio') {
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('#correcao').hide();
				$('#analise').show();
				$('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido');
				$('.analisetecnica').removeClass('reprovado').addClass('nao_preenchido');
				$('#GerarResultadoTecnico').hide();
				$('#Liberarrelatorio').hide();
				$('#aguardandoanalise').show();
				$('#Concluirrelatorio').hide();
				$('#elaboracao').hide();
				$('#aguardandoanaliseFiscal').hide();
				$('#aguardandoanaliseResponsavel').hide();
			}
			if (data.data == 'Elaboracao') {
				if(data.qtdAceite == 31){
					$('#Concluirrelatorio').show();
				}
				elaboracao();
			}
			if (data.data == 'aguardando_analise') {
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('#correcao').hide();
				$('#analise').hide();
				$('#GerarResultadoTecnico').hide();
				$('#aguardandoanaliseFiscal').show();
				$('#aguardandoanaliseResponsavel').hide();
				$('#Concluirrelatorio').hide();
				$('#elaboracao').hide();
			}
			if(data.data == 'aguardando_analise_analista'){
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('.analisetecnica').removeClass('nao_preenchido').addClass('aprovado');
				$('.analisetecnica').removeClass('reprovado').addClass('aprovado');
				$('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido');
				$('.analiseestrutural').removeClass('reprovado').addClass('nao_preenchido');
				$('#Concluirrelatorio').hide();
				$('#correcao').hide();
				$('#aguardandoanaliseResponsavel').show();
				$('#aguardandoanaliseFiscal').hide();
				// $('#GerarRelatorio').hide();
			}
			if(data.data == null){
				$('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
				$('.analisetecnica').removeClass('nao_preenchido').addClass('aprovado');
				$('.analiseestrutural').removeClass('nao_preenchido').addClass('aprovado');
				$('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
				$('.impressora').removeClass('nao_preenchido').addClass('aprovado');
				$('#GerarResultadoTecnico').show();
				$('#GerarResultadoEstrutural').show();
			}
		}, error: function (data) {
			$.notify('Falha recuperar relatorio', "warning");
                       // console.log(data);
		}
	});
}
function dadosContrato() {
    if (document.getElementById) {
        var dt = $("#datepicker").datepicker("getDate");
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    $.ajax({
        type: 'POST',
        url:base_url + 'index_cgob.php/RelatorioVersaoDaq',
        data: {
            periodo: termo
        },
        dataType: 'json',
        success: function (data) {
            val_contrato = data.contrato;
            var label_contrato = val_contrato;
            $('.label_contrato').text(label_contrato);
            //---------------------------------------------
            val_supervisora = data.supervisora;
            var label_supervisora = val_supervisora;
            $('.label_supervisora').text(label_supervisora);
            //----------------------------------------------
            val_rp = data.rp;
            var label_rp = val_rp;
            $('.label_rp').text(label_rp);
            //----------------------------------------------
            val_versao = data.versao;
            var label_versao = val_versao;
            $('.label_versao').text(label_versao);
            //----------------------------------------------
            val_uf = data.uf;
            var label_uf = val_uf;
            $('.label_uf').text(label_uf);
            //----------------------------------------------
            dadosRelatorio(termo)
            
        }, error: function (data) {
            $.notify('Falha', "warning");
            
        }
    });
}
function botaoRelatorio(){
	$('#botaoRelatorio').html('<button type="button" onclick = "GerarRelatorio()" name="GerarRelatorio" id="GerarRelatorio" type="button" class="btn btn-xs btn-block btn-sm btn-primary">Relatório</button>');
}


function dadosRelatorio() {

        if (document.getElementById) {
        var dt = $("#datepicker").datepicker("getDate");
        if (dt.toString() == "Invalid Date") {
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }
        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    
    var table = $('#tableRelatorio').DataTable();
    table.destroy();
    //---------------------------------------------------------
    $('#tableRelatorio').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "paging": false,
        "sAjaxSource": base_url + "index_cgob.php/RelatorioModulosDaq",
        "fnServerParams":
        function (aoData) {
            aoData.push(
                    {"name": "periodo", "value": termo}
            );
        },
        "aoColumns": [
            {data: 'cont'},
            {data: 'modulo'},
            {data: 'nome'},
            {data: 'data'},
            {data: 'acao',"sClass": "text-center"}

        ]
    });
}
function elaboracao(termo) {

var dt = $("#datepicker").datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    //--------------------------------------------------
    $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioResultadoDaq',
        data: {periodo: termo},
        dataType: 'json',
        success: function (data) {
           
             if (data.relaboracao >= 1 & data.relaboracao < 28) {
                $('.elaboracao').removeClass('nao_preenchido').addClass('emelaboracao');
                $('.elaboracao').removeClass('aprovado').addClass('emelaboracao');
                $('.conclusao').removeClass('aprovado').addClass('nao_preenchido');
                $('#aguardandoanalise').hide();
                $('#aguardandoanaliseFiscal').hide();
                $('#aguardandoanaliseResponsavel').hide();  
                // $('#GerarRelatorio').hide();
                $("#GerarRecibo").hide();  
                $('#Concluirrelatorio').hide();
                $('#correcao').hide();
                
            }
            if(data.relaboracao < 28){
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.impressora').removeClass('aprovado').addClass('nao_preenchido'); 
                $('#GerarResultadoEstrutural').hide();
                $('#GerarResultadoTecnico').hide();
                // $('#GerarRelatorio').hide();
                $("#GerarRecibo").hide();
                $('#aguardandoanalise').hide();
                $('#aguardandoanaliseFiscal').hide();
                $('#aguardandoanaliseResponsavel').hide();  
                $('#Liberarrelatorio').hide();
                $('#elaboracao').show();
                $('#correcao').hide();  
            }
            if (data.relaboracao >= 28) {
                $('.elaboracao').removeClass('nao_preenchido').addClass('aprovado');
                $('.conclusao').removeClass('nao_preenchido').addClass('aprovado');
                $('.elaboracao').removeClass('emelaboracao').addClass('aprovado');
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('reprovado').addClass('nao_preenchido'); 
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analisetecnica').removeClass('reprovado').addClass('nao_preenchido');
				if(data.perfil == 2){
					$('#Concluirrelatorio').show();
				}
                $('#elaboracao').hide();
                $('#GerarRecibo').hide();
                $('#GerarResultadoTecnico').hide();
                $('#GerarResultadoEstrutural').hide();  
                $('#Liberarrelatorio').hide();             
            }
            if(data.relaboracao == 0){
                $('.elaboracao').removeClass('nao_preenchido').addClass('nao_preenchido');
                $('.elaboracao').removeClass('aprovado').addClass('nao_preenchido');
                $('.elaboracao').removeClass('emelaboracao').addClass('nao_preenchido');
                $('.analisetecnica').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.analiseestrutural').removeClass('aprovado').addClass('nao_preenchido'); 
                $('.conclusao').removeClass('aprovado').addClass('nao_preenchido');
                $('.conclusao').removeClass('nao_preenchido').addClass('nao_preenchido');
                $('.impressora').removeClass('aprovado').addClass('nao_preenchido'); 
                $('#GerarResultadoEstrutural').hide();
                $('#GerarResultadoTecnico').hide();
                $('#GerarRecibo').hide();
                // $('#GerarRelatorio').hide();
                $('#aguardandoanalise').hide(); 
                $('#aguardandoanaliseFiscal').hide(); 
                $('#Liberarrelatorio').hide();
                $('#elaboracao').hide();  
                $('#correcao').hide();  
                $('#Concluirrelatorio').hide(); 
                $('#aguardandoanaliseResponsavel').hide();
            }
            
        }, error: function (data) {
            $.notify('Falha ', "warning");
            
        }
    });
}
function GerarResultadoEstrutural(){
    if(document.getElementById){
        var dt = $( "#datepicker" ).datepicker('getDate');
        if (dt.toString() == "Invalid Date"){
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }

        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1)>9? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    //---------------------------------------------------------
    $("#ModalResultadoAnalise").modal(); 
    //---------------------------------------------------------
    var table = $('#HistoricoAnalise').DataTable();
    table.destroy();
    //---------------------------------------------------------
    $('#HistoricoAnalise').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "paging": false,
        "sAjaxSource": base_url + "index_cgob.php/RelatorioResultadoEstruturalDaq",
        "fnServerParams":
                function (aoData) {
                    aoData.push(
                            {"name": "periodo", "value": termo}
                    );
                },
        "aoColumns": [
            {data: 'cont'},
            {data: 'modulo'},
            {data: 'motivo'},
            {data: 'referencia'},
            {data: 'data'},
            {data: 'responsavel'}

        ]
    });
}
//#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
function GerarResultadoTecnico(){
    if(document.getElementById){
        var dt = $( "#datepicker" ).datepicker('getDate');
        if (dt.toString() == "Invalid Date"){
            $("#datepicker").datepicker("setDate", new Date());
            return;
        }

        var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1)>9? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";
    }
    //---------------------------------------------------------
    $("#ModalResultadoAnalise").modal(); 
    //---------------------------------------------------------
    var table = $('#HistoricoAnalise').DataTable();
    table.destroy();
    //---------------------------------------------------------
    $('#HistoricoAnalise').dataTable({
        "bProcessing": false,
        "bFilter": false,
        "bInfo": false,
        "bLengthChange": false,
        "paging": false,
        "sAjaxSource": base_url + "index_cgob.php/RelatorioResultadoTecnicoDaq",
        "fnServerParams":
                function (aoData) {
                    aoData.push(
                            {"name": "periodo", "value": termo}
                    );
                },
        "aoColumns": [
            {data: 'cont'},
            {data: 'modulo'},
            {data: 'motivo'},
            {data: 'referencia'},
            {data: 'data'},
            {data: 'responsavel'}

        ]
    });
}
//-----------------------------------------------------------------------
function returnRelatorio() { 

    var dt = $("#datepicker").datepicker('getDate');
    if (dt.toString() == "Invalid Date") {
        $("#datepicker").datepicker("setDate", new Date());
        return;
    }
    var termo = dt.getFullYear() + "-" + ((dt.getMonth() + 1) > 9 ? (dt.getMonth() + 1) : "0" + (dt.getMonth() + 1)) + "-01";    
  
    
        jan = window.open(base_url + 'index_cgob.php/ImpressaoRelatorioDaq?periodo=' + termo, 'jan', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=100, LEFT=left, WIDTH=800, HEIGHT=500');
}
//------------------------------------------------------------------------------
function GerarRelatorio(){ 
        returnRelatorio();
}