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
		border: 1px solid #28a745 !important;
		background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
		color: #fff !important;
		font-size: 0.85em !important;
		cursor: pointer;
		text-align: center;
		font-weight: 600;
		padding: 4px 8px !important;
		border-radius: 4px !important;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		transition: all 0.3s ease;
	}
	
	.fc-event:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 8px rgba(0,0,0,0.2);
	}
	
	.fc-title {
		font-size: 1.1em !important;
		display: inline-block;
		background-color: rgba(255,255,255,0.2);
		padding: 2px 8px;
		border-radius: 12px;
		min-width: 30px;
	}
	
	.fc-content {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 4px;
	}
	
	.fc-day-grid-event {
		margin: 2px 3px !important;
	}
	
	.fc-day-number {
		color: #495057;
		font-weight: 500;
	}
	
	.fc-today {
		background-color: #fff9e6 !important;
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

					$cantidadReservas = $fechas[$noRepetirFechas[$j]];
					$titulo = "👥 " . $cantidadReservas;

					echo '{"title":"'.$titulo.'",
						"start":"'.$noRepetirFechas[$j].'",
						"end":"'.$fechaSalida[$j].'"},';									

				}				

			?>

        ]


      });			


</script>
