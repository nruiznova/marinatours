<?php

require_once "../controladores/habitaciones.controlador.php";
require_once "../modelos/habitaciones.modelo.php";
require_once "../controladores/preciosTemporada.controlador.php";
require_once "../modelos/preciosTemporada.modelo.php";


class AjaxHabitaciones{

	public $ruta;

	public function ajaxTraerHabitacion(){

		$valor = $this->ruta;

		$respuesta = ControladorHabitaciones::ctrMostrarHabitaciones("ruta", $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	Obtener precio por fecha (considerando temporadas)
	=============================================*/

	public $id_servicio;
	public $fecha_reserva;

	public function ajaxObtenerPrecioPorFecha(){

		$id_servicio = $this->id_servicio;
		$fecha = $this->fecha_reserva;

		$respuesta = ControladorPreciosTemporada::ctrObtenerPrecioUsuario($id_servicio, null, $fecha);

		echo json_encode($respuesta);

	}
 
}

if(isset($_POST["ruta"])){

	$ruta = new AjaxHabitaciones();
	$ruta -> ruta = $_POST["ruta"];
	$ruta -> ajaxTraerHabitacion();

}

/*=============================================
Obtener precio por fecha
=============================================*/

if(isset($_POST["id_servicio"]) && isset($_POST["fecha_reserva"])){

	$precio = new AjaxHabitaciones();
	$precio -> id_servicio = $_POST["id_servicio"];
	$precio -> fecha_reserva = $_POST["fecha_reserva"];
	$precio -> ajaxObtenerPrecioPorFecha();

}

