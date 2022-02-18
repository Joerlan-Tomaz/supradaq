//############################################################################ 
//# 
//# DNIT - DAQ
//# Data:16/07/2020 
//# 
//############################################################################
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$().ready(function () {

Recupera_curve_chart();

});
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function monetarioReduzidoold(y) {
  var kb = 1000,
  mb = 1000000,
  gb = 1000000000;

  if (y > gb)
    return "â‰…" + (y / gb).toFixed(2) + " bi";
  else if (y > mb)
    return "â‰…" + (y / mb).toFixed(2) + " mi";
  else if (y > kb)
    return "â‰…" + (y / kb).toFixed(2) + " mil";
  else
    return "â‰…" + (y).toFixed(2);
}

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


function Recupera_curve_chart(){
      $.ajax({
        type: 'POST',
        url: base_url + 'index_cgob.php/RelatorioGraficoDaq',
        dataType: 'json',
        success: function(data){
          
          var data_comum = data.data_comum;
          var charPrevisto = data.charPrevisto;
          var charExecutado = data.charExecutado;

          var cMain  = charPrevisto.map(Number);
          var cMainn  = charExecutado.map(Number);

        //------------------------------------------  
        var chart = new Highcharts.Chart({
                                chart:{
                                    type: 'spline',
                                    animation: false,
                                        renderTo: 'curve_chart',
                                        width: 1000
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
                                    labels:{
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

            //------------------------------------------
   
        }
        
      })
}