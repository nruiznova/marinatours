<?php 

// Obtener todos los servicios de Isla Palma
$servicios = array();
$serviciosAll = ControladorHabitaciones::ctrMostrarHabitaciones(null);

foreach ($serviciosAll as $row => $item) {
    if (strpos($item["estilo"], 'ISLA PALMA') !== false || strpos($item["estilo"], 'isla palma') !== false) {
        array_push($servicios, $item["id_h"]);
    }
}

$traerReservas = ControladorReservas::ctrMostrarReservas(null, null);

$descripcion = array();
$fechaIngreso = array();
$fechaSalida = array();

foreach ($traerReservas as $key => $value) {

    // Verificar que sea un servicio de Isla Palma
    if (in_array($value["id_habitacion"], $servicios)) {
        
        // Excluir reservas anuladas (estado=2) y con devolución (estado=3)
        if(isset($value["estado"]) && ($value["estado"] == 2 || $value["estado"] == 3)){
            continue; // Saltar esta reserva
        }
	
        array_push($descripcion, $value["descripcion_reserva"]);	
        array_push($fechaIngreso, $value["fecha_ingreso"]);
        array_push($fechaSalida, $value["fecha_salida"]);

    }
}

?>

<style>
	.fc-event {
		border: none !important;
		background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
		color: #fff !important;
		font-size: 0.95em !important;
		cursor: pointer;
		text-align: center;
		font-weight: 700;
		padding: 6px 10px !important;
		border-radius: 6px !important;
		box-shadow: 0 2px 6px rgba(40, 167, 69, 0.3);
		transition: all 0.3s ease;
		white-space: nowrap;
		overflow: visible !important;
	}
	
	.fc-event:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 10px rgba(40, 167, 69, 0.5);
		background: linear-gradient(135deg, #218838 0%, #1ea87a 100%) !important;
	}
	
	.fc-title {
		font-size: 1.2em !important;
		letter-spacing: 0.5px;
	}
	
	.fc-content {
		display: flex;
		align-items: center;
		justify-content: center;
		white-space: nowrap;
	}
	
	.fc-day-grid-event {
		margin: 4px auto !important;
		width: fit-content !important;
		min-width: 60px;
	}
	
	/* Hacer que los eventos no se extiendan horizontalmente */
	.fc-day-grid-event .fc-content {
		display: inline-block;
		width: auto;
	}
	
	.fc-day-number {
		color: #495057;
		font-weight: 600;
		padding: 8px;
	}
	
	.fc-today {
		background-color: #fff9e6 !important;
	}
	
	.fc-day-top {
		text-align: center;
	}
	
	/* Centrar eventos en las celdas del día */
	.fc-day-grid-container {
		text-align: center;
	}
	
	.fc-content-skeleton td {
		text-align: center;
	}
	
	/* Mejorar apariencia del header */
	.fc-toolbar h2 {
		font-size: 1.5em;
		color: #495057;
		font-weight: 600;
	}
	
	.fc-button {
		background-color: #007bff !important;
		border-color: #007bff !important;
		text-transform: capitalize;
	}
	
	.fc-button:hover {
		background-color: #0056b3 !important;
		border-color: #0056b3 !important;
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

				// Array para contar personas por fecha de ingreso
				$reservasPorFecha = array();

				// Recorrer todas las reservas y sumar personas por fecha
				for($i = 0; $i < count($descripcion); $i++){

					// Saltar si no hay fecha de ingreso válida
					if(empty($fechaIngreso[$i]) || $fechaIngreso[$i] == '0000-00-00' || $fechaIngreso[$i] == null){
						continue;
					}

					$desc = $descripcion[$i];
					$descArr = explode("-", $desc);

					// Tomar el último elemento que contiene el número de personas
					$ultimoElemento = trim($descArr[count($descArr) - 1]);
					$cantidad_personas = intval($ultimoElemento);

					// Usar fecha_ingreso como clave para agrupar
					$fecha = $fechaIngreso[$i];

					if(isset($reservasPorFecha[$fecha])){
						$reservasPorFecha[$fecha]['personas'] += $cantidad_personas;
						$reservasPorFecha[$fecha]['reservas']++;
					}else{
						$reservasPorFecha[$fecha] = array(
							'personas' => $cantidad_personas,
							'reservas' => 1
						);
					}
				}			
				
				// Generar eventos para cada fecha única
				foreach($reservasPorFecha as $fecha => $datos){
					$cantidadPersonas = $datos['personas'];
					$cantidadReservas = $datos['reservas'];
					$titulo = "👥 " . $cantidadPersonas;

					echo '{"title":"'.$titulo.'",
						"start":"'.$fecha.'",
						"allDay":true},';									
				}				

			?>

        ]


      });			


</script>
