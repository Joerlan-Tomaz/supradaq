//######################################################################################################################################################################################################################## 
//# DNIT-Falconi AQUAVIARIO
//# info.js
//# Desenvolvedora:Jordana de Alencar
//# Data: 06/06/2020 19:00
//# Data: 04/08/2020 06:00
//########################################################################################################################################################################################################################
//------------------------------------------------------------------------------
 adicionaDadosInicio();
//------------------------------------------------------------------------------
 function adicionaDadosInicio(){  
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_url + 'index_cgob.php/DadosInicioDaq',
        success: function (data) { 
        var objeto = data;
    //-----------------------------------------------------------------------------------------
        for (j = 0; j < objeto["data"]["length"] ; j++) {
            unidade_medida = objeto["data"][j][6];
            if(unidade_medida != '%'){
                var metricaprevista = ((((objeto["data"][j][2])/(objeto["data"][j][5]))* 100));
                var metricaatacado = ((((objeto["data"][j][3])/(objeto["data"][j][5]))* 100));
                //var metricaconcluido = ((((objeto["data"][j][4])/(objeto["data"][j][5]))* 100));
            }
            if(unidade_medida == '%'){

                var metricaprevista = ((objeto["data"][j][2]));
                var metricaatacado = ((objeto["data"][j][3]));
            }
        //--------------------------------------------------------------------------------------
            var cols = "";
                cols += "<div class='col-md-6'>";
                cols += "    <div class='card'>";
                cols += "        <div class='card-header'>";
                cols += "            <h5 class='card-title' id=titleservico'>"+(objeto["data"][j][0])+" - "+(objeto["data"][j][1])+" </h5>";
                cols += "       </div>";    
                cols += "       <div class='card-body'>";
                cols += "           <div class='row align-items-center'>";
                cols += "               <div class='col-xs-4 col-sm-4 col-md-2 col-lg-2'>";
                cols += "                    <small class='progress-title'><b>Previsto</b></small>";
                cols += "                </div>";
                cols += "                <div class='col-xs-4 col-sm-4 col-md-8 col-lg-8'>";
                cols += "                    <div class='progress progress-sm active'>";
                cols += "                        <div class='active progress-bar progress-bar-striped progress-cinza' role='progressbar' aria-valuenow='.000000' aria-valuemin='0' aria-valuemax='100' style='width:"+metricaprevista+"%'>";
                cols += "                            <span class='sr-only'>."+metricaprevista+" % Complete</span>";
                cols += "                        </div>";
                cols += "                    </div>";
                cols += "                </div>";
                cols += "                <div class='col-xs-4 col-sm-4 col-md-2 col-lg-2'>";
                cols += "                    <small class='progress-number pull-right'>"+(objeto["data"][j][2])+""+(objeto["data"][j][6])+" </small>";
                cols += "                </div>";
                cols += "            </div>";
                cols += "            <div class='row align-items-center'>";
                cols += "                <div class='col-xs-4 col-sm-4 col-md-2 col-lg-2'>";
                cols += "                    <small class='progress-title'><b>Concluído</b></small>";
                cols += "                </div>";
                cols += "                <div class='col-xs-4 col-sm-4 col-md-8 col-lg-8'>";
                cols += "                    <div class='progress progress-sm active'>";
                cols += "                        <div class='progress-bar bg-primary progress-bar-striped' role='progressbar' aria-valuenow='.000000' aria-valuemin='0' aria-valuemax='100' style='width: "+metricaatacado+"%'>";
                cols += "                           <span class='sr-only'>."+metricaatacado+"% Complete</span>";
                cols += "                        </div>";
                cols += "                    </div>";
                cols += "                </div>";
                cols += "                <div class='col-xs-4 col-sm-4 col-md-2 col-lg-2'>";
                cols += "                    <small class='progress-number pull-right'>"+(objeto["data"][j][3])+""+(objeto["data"][j][6])+" </small>";
                cols += "                </div>";
                cols += "            </div>";
                cols += "        </div>";
                cols += "    </div>";
                cols += "</div>";

                $("#campo").append(cols);
            }
        }
    });
}  
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------