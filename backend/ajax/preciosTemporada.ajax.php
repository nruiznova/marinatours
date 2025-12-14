<?php

require_once "../controladores/preciosTemporada.controlador.php";
require_once "../modelos/preciosTemporada.modelo.php";

class AjaxPreciosTemporada{

	/*=============================================
	Mostrar precios de temporada por servicio
	=============================================*/

	public $idServicioTemporada;

	public function ajaxMostrarPreciosTemporada(){

		$item = "id_servicio";
		$valor = $this->idServicioTemporada;

		$respuesta = ControladorPreciosTemporada::ctrMostrarPreciosTemporada($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	Obtener un precio de temporada
	=============================================*/

	public $idPrecioTemporada;

	public function ajaxObtenerPrecioTemporada(){

		$item = "id_precio_temporada";
		$valor = $this->idPrecioTemporada;

		$respuesta = ControladorPreciosTemporada::ctrMostrarPreciosTemporada($item, $valor);

		if($respuesta && count($respuesta) > 0){
			echo json_encode($respuesta[0]);
		} else {
			echo json_encode(array("error" => "No se encontró la temporada"));
		}

	}

}

/*=============================================
Mostrar precios de temporada por servicio
=============================================*/

if(isset($_POST["idServicioTemporada"])){

	$temporadas = new AjaxPreciosTemporada();
	$temporadas -> idServicioTemporada = $_POST["idServicioTemporada"];
	$temporadas -> ajaxMostrarPreciosTemporada();

}

/*=============================================
Obtener un precio de temporada
=============================================*/

if(isset($_POST["idPrecioTemporada"])){

	$temporada = new AjaxPreciosTemporada();
	$temporada -> idPrecioTemporada = $_POST["idPrecioTemporada"];
	$temporada -> ajaxObtenerPrecioTemporada();

}

/*=============================================
Eliminar precio de temporada
=============================================*/

if(isset($_POST["idEliminarTemporada"])){

	$tabla = "precios_temporada";
	$datos = $_POST["idEliminarTemporada"];
	
	// Log para debugging
	error_log("=== ELIMINANDO TEMPORADA ===");
	error_log("ID recibido: " . $datos);

	$respuesta = ModeloPreciosTemporada::mdlEliminarPrecioTemporada($tabla, $datos);

	echo json_encode($respuesta);

}
