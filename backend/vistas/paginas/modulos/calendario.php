<?php 

$traerReservas = ControladorReservas::ctrMostrarReservas(null, null);

$descripcion = array();
$fechaIngreso = array();
$fechaSalida = array();

foreach ($traerReservas as $key => $value) {
	
	array_push($descripcion, $value["descripcion_reserva"]);	
	array_push($fechaIngreso, $value["fecha_ingreso"]);
	array_push($fechaSalida, $value["fecha_salida"]);
}

?>

<style>
	.fc-event {
		border: 1px solid #3a87ad !important; /* default BORDER color */
		background-color: #3a87ad !important; /* default BACKGROUND color */
		color: #fff !important;               /* default TEXT color */
		font-size: 1.85em;            /* EDIT HERE */
		cursor: default;
		text-align: center;
		font-weight: bold;
	}
</style>

<div class="card card-primary card-outline">

	<div class="card-header">

		<h5 class="m-0">Reservas del mes</h5>

	</div>

	<div class="card-body">

		<div id="calendarIndex"></div>
		<a href="reservas" class="btn btn-primary mt-3">Ver reservas</a>

	</div>

</div>

<script>

// $('.fc-event').css('font-size', '1.85em !important');
// $('.fc-title').css('font-size', '1.85em !important');
// $('.fc-time').css('font-size', '1.85em');
// $('.fc-event-content, .fc-event-time').css('font-size', '1.85em');

var fechaActual = new Date();
var mes = ("0"+Number(fechaActual.getMonth()+1)).slice(-2);
var dia = ("0"+fechaActual.getDate()).slice(-2);
	
	 $('#calendarIndex').fullCalendar({
	    defaultDate:fechaActual.getFullYear()+"-"+mes+"-"+dia,
        header: {
          left: 'prev',
          center: 'title',
          right: 'next'
        },
        events:[

			<?php

				$fechas = array();

				for($i = 0; $i < count($descripcion); $i++){

					$desc = $descripcion[$i];

					$descArr = explode(" - ", $desc);

					$personasArr = explode(" ", $descArr[1]);

					$cantidad_personas = intval($personasArr[0]);

					// var_dump(cantidad_personas);

					if(isset($fechas[$fechaIngreso[$i]])){

						$fechas[$fechaIngreso[$i]] = $fechas[$fechaIngreso[$i]] + $cantidad_personas;			

					}else{

						$fechas[$fechaIngreso[$i]] = $cantidad_personas;

					}

				}		
				
				$noRepetirFechas = array_unique($fechaIngreso);							

				for($j = 0; $j < count($descripcion); $j++){

					echo '{"title":"'.$fechas[$noRepetirFechas[$j]].'",
						"start":"'.$noRepetirFechas[$j].'",
						"end":"'.$fechaSalida[$j].'",
						"color": "#FFCC29"},';									

				}				

			?>

        ]


      });			


</script>
