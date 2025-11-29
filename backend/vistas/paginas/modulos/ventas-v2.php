<?php 

error_reporting(0);

if(isset($_GET["typeFilter"])){

    if($_GET["typeFilter"] == "month"){

        // seleccionar rango de fechas entre primer y ultimo dia del mes seleccionado

        $month = $_GET["valueFilter"];

        $item = "rango";

        $valor = date("Y-m-01", strtotime($month))."/".date("Y-m-t", strtotime(date("Y-m-01", strtotime($month))));     
        
        // var_dump($valor);

    }if($_GET["typeFilter"] == "year"){

        // seleccionar rango de fechas entre primer y ultimo dia del año seleccionado

        $year = $_GET["valueFilter"];

        $item = "rango";

        $firstDayOfYear = date('Y-m-d', strtotime("first day of january {$year}"));
        $lastDayOfYear = date('Y-m-d', strtotime("last day of december {$year}"));

        $valor = $firstDayOfYear."/".$lastDayOfYear;

    }

}else{

    $item = null;
    $valor = null;

}

$respuesta = ControladorReservas::ctrMostrarReservas($item, $valor);

$arrayFechas = array();
$sumaPagosMes = array();
$arrayTest = array();

foreach ($respuesta as $key => $value){

    if (strpos($value["descripcion_reserva"], 'ISLA PALMA') !== false || strpos($value["descripcion_reserva"], 'isla palma') !== false) {

        if($value["fecha_ingreso"] != null){

            #Capturamos año y mes
            if(isset($_GET["typeFilter"])){

                if($_GET["typeFilter"] == "month"){

                    // get all month days

                    $month = date("m", strtotime($_GET["valueFilter"]));;
                    $year = date("Y", strtotime($_GET["valueFilter"]));;

                    for($d=1; $d<=31; $d++)
                    {
                        $time=mktime(12, 0, 0, $month, $d, $year);          
                        if (date('m', $time)==$month)       
                            $day = date('d', $time);
                            array_push($arrayFechas, $day);
                            #Capturamos las ventas    
                            $arrayVentas = array($day => "0");    
                            
                            #Sumamos los pagos que ocurrieron el mismo mes

                            foreach ($arrayVentas as $key2 => $value2) {

                                $sumaPagosMes[$key2] += $value2;
                                    
                            }
                    }

                    $fecha = date("d", strtotime($value["fecha_ingreso"]));

                    #Capturamos las ventas    
                    $arrayVentas = array($fecha => $value["pago_reserva"]);    
                    
                    #Sumamos los pagos que ocurrieron el mismo mes

                    foreach ($arrayVentas as $key2 => $value2) {

                        $sumaPagosMes[$key2] += $value2;
                            
                    }

                }else if($_GET["typeFilter"] == "year"){

                    for ($i=1; $i < 13; $i++) { 
                        
                        if($i < 10){
                            $month = date("Y-0".$i);
                        }else{
                            $month = date("Y-".$i);
                        }
                        
                        array_push($arrayFechas, $month);

                        #Capturamos las ventas    
                        $arrayVentas = array($month => "0");    
                        
                        #Sumamos los pagos que ocurrieron el mismo mes

                        foreach ($arrayVentas as $key2 => $value2) {

                            $sumaPagosMes[$key2] += $value2;
                                
                        }

                    }

                    $fecha = date("Y-m", strtotime($value["fecha_ingreso"]));

                    #Capturamos las ventas    
                    $arrayVentas = array($fecha => $value["pago_reserva"]);    
                    
                    #Sumamos los pagos que ocurrieron el mismo mes

                    foreach ($arrayVentas as $key2 => $value2) {

                        $sumaPagosMes[$key2] += $value2;
                            
                    }

                }else if($_GET["typeFilter"] == "all"){

                    $fecha = date("Y", strtotime($value["fecha_ingreso"]));

                    #Capturamos las ventas    
                    $arrayVentas = array($fecha => $value["pago_reserva"]);    
                    
                    #Sumamos los pagos que ocurrieron el mismo mes

                    foreach ($arrayVentas as $key2 => $value2) {

                        $sumaPagosMes[$key2] += $value2;
                            
                    }
                    
                }	

            }else{

                $fecha = date("Y", strtotime($value["fecha_ingreso"]));

                #Capturamos las ventas    
                $arrayVentas = array($fecha => $value["pago_reserva"]);    
                
                #Sumamos los pagos que ocurrieron el mismo mes

                foreach ($arrayVentas as $key2 => $value2) {

                    $sumaPagosMes[$key2] += $value2;
                        
                }

            }

            #Introducir las fechas en arrayFechas
            array_push($arrayFechas, $fecha);
            
        }
        
    }
	
}


$noRepetirFechas = array_unique($arrayFechas);

// var_dump($sumaPagosMes);

$get_top = '';

if(isset($_GET["id_s"]) && $_GET["id_s"] != ''){

    $get_top .= '&id_s='.$_GET["id_s"];

}else{

    $id_s = $servicios[0]["id_h"];
    $get_top .= '&id_s='.$id_s;

}

if(isset($_GET["fecha"]) && $_GET["fecha"] != ''){

    $get_top .= '&fecha='.$_GET["fecha"];

}else{

    $fecha = date("Y-m-d", strtotime("+1 day"));
    $get_top .= '&fecha='.$fecha;

}

if(isset($_GET["fecha_total"]) && $_GET["fecha_total"] != ''){

    $get_top .= '&fecha_total='.$_GET["fecha_total"];

}else{

    $fecha_total = date("Y-m-d");
    $get_top .= '&fecha_total='.$fecha_total;

}

?>


<div class="card bg-info m-2">

	<div class="card-header no-border">
		
		<!-- <h3 class="card-title">
			<i class="fas fa-th mr-1"></i>
			Línea de Ventas
		</h3>         -->

        <!-- <div class="form-group pt-5">
            <label>Date range button:</label>
            <div class="input-group">
            <button type="button" class="btn btn-default float-right" id="daterange-btn">
                <i class="far fa-calendar-alt"></i> Rango de fechas
                <i class="fas fa-caret-down"></i>
            </button>
            </div>
        </div> -->

        <div class="form-group" style="width: 365px;">
            <select class="form-control text-uppercase" id="changeFilterVentas" style="background-color: #17a2b8 !important; color: #fff !important">
                <!-- <option value="">-- Seleccione --</option> -->
                 <?php 
                 
                    if(isset($_GET["typeFilter"])){

                        if($_GET["typeFilter"] == "month"){

                            echo'

                            <option value="month" selected>Todos los dias del mes</option>
                            <option value="year">Todos los meses de año</option>
                            <option value="all">Todos los años</option>
                            
                            ';

                        }else if($_GET["typeFilter"] == "year"){

                            echo'

                            <option value="month">Todos los dias del mes</option>
                            <option value="year" selected>Todos los meses de año</option>
                            <option value="all">Todos los años</option>
                            
                            ';

                        }else if($_GET["typeFilter"] == "all"){

                            echo'

                            <option value="month">Todos los dias del mes</option>
                            <option value="year">Todos los meses de año</option>
                            <option value="all" selected>Todos los años</option>
                            
                            ';

                        }

                    }else{

                        echo'

                        <option value="month">Todos los dias del mes</option>
                        <option value="year">Todos los meses de año</option>
                        <option value="all" selected>Todos los años</option>
                        
                        ';

                    }
                 
                 ?>                
            </select>
        </div>

        <?php 
                 
            if(isset($_GET["typeFilter"])){

                if($_GET["typeFilter"] == "month"){

                    echo'

                    <div class="form-group filterVentasMes" style="width: 365px;">            
                        <div class="input-group mb-3">
                            <input type="month" class="form-control dateValue" value="'.$_GET["valueFilter"].'" style="background-color: #17a2b8 !important; color: #fff !important">
                            <div class="input-group-append">
                                <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group filterVentasYear" style="width: 365px; display:none">            
                        <div class="input-group mb-3">
                            <input type="number" class="form-control dateValue" min="1900" max="2099" step="1" value="2025" style="background-color: #17a2b8 !important; color: #fff !important">
                            <div class="input-group-append">
                                <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                                        
                    ';

                }else if($_GET["typeFilter"] == "year"){

                    echo'

                    <div class="form-group filterVentasMes" style="width: 365px; display:none">            
                        <div class="input-group mb-3">
                            <input type="month" class="form-control dateValue" style="background-color: #17a2b8 !important; color: #fff !important">
                            <div class="input-group-append">
                                <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group filterVentasYear" style="width: 365px;">            
                        <div class="input-group mb-3">
                            <input type="number" class="form-control dateValue" value="'.$_GET["valueFilter"].'"  min="1900" max="2099" step="1" value="2025" style="background-color: #17a2b8 !important; color: #fff !important">
                            <div class="input-group-append">
                                <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                                        
                    ';

                }else{

                    echo'
                
                        <div class="form-group filterVentasMes" style="width: 365px; display:none;">            
                            <div class="input-group mb-3">
                                <input type="month" class="form-control dateValue" style="background-color: #17a2b8 !important; color: #fff !important">
                                <div class="input-group-append">
                                    <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group filterVentasYear" style="width: 365px; display:none">            
                            <div class="input-group mb-3">
                                <input type="number" class="form-control dateValue" min="1900" max="2099" step="1" value="2025" style="background-color: #17a2b8 !important; color: #fff !important">
                                <div class="input-group-append">
                                    <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    
                    ';

                }

            }else{

                echo'
                
                    <div class="form-group filterVentasMes" style="width: 365px; display:none;">            
                        <div class="input-group mb-3">
                            <input type="month" class="form-control dateValue" style="background-color: #17a2b8 !important; color: #fff !important">
                            <div class="input-group-append">
                                <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group filterVentasYear" style="width: 365px; display:none">            
                        <div class="input-group mb-3">
                            <input type="number" class="form-control dateValue" min="1900" max="2099" step="1" value="2025" style="background-color: #17a2b8 !important; color: #fff !important">
                            <div class="input-group-append">
                                <span class="input-group-text btn searchDate" style="background-color: #17a2b8 !important; color: #fff !important">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                
                ';

            }

        ?>        

	</div>

	<div class="card-body">
		
		<!-- <div class="chart" id="line-chart-ventas"></div>
        <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas> -->
        <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

	</div>

</div>

<script>

    $(".searchDate").click(function(){

        var type = $("#changeFilterVentas").val()

        var date = $(this).parent().prev(".dateValue").val()

        window.location = "index.php?pagina=inicio-v2<?php echo $get_top; ?>&typeFilter="+type+"&valueFilter="+date;

    })

    $("#changeFilterVentas").change(function(){

        if($(this).val() == 'month'){

            $(".filterVentasMes").show()
            $(".filterVentasYear").hide()

        }else if($(this).val() == 'year'){

            $(".filterVentasMes").hide()
            $(".filterVentasYear").show()

        }else{

            $(".filterVentasMes").hide()
            $(".filterVentasYear").hide()

        }

    }) 

    // Sales graph chart
    var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');

    var salesGraphChartData = {
        labels: [

            <?php 
                
                if($noRepetirFechas != null){

                    foreach($noRepetirFechas as $key){

                        echo '"'.$key.'",';

                    }

                }else{

                    echo '0000-00-00';

                }

            ?>

        ],
        datasets: [
            {
                label: 'Ventas',
                fill: false,
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: [

                    <?php 
                
                        if($noRepetirFechas != null){

                            foreach($noRepetirFechas as $key){

                                echo "".$sumaPagosMes[$key]." ,";

                            }

                        }else{

                            echo '0.00';

                        }

                    ?>

                ]
            }
        ]
    }

    var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                ticks: {
                fontColor: '#efefef'
                },
                gridLines: {
                display: false,
                color: '#efefef',
                drawBorder: false
                }
            }],
            yAxes: [{
            ticks: {
                fontColor: '#fff',
                beginAtZero: true,
                callback: function(value, index, values) {
                if(parseInt(value) >= 1000){
                    return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } else {
                    return '$' + value;
                }
                }
            },
            
            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                }
            }
        }
    }

    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
    })    

</script>