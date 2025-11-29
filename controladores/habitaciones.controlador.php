<?php

Class ControladorHabitaciones{


	/*=============================================
	MOSTRAR HABITACIONES
	=============================================*/

	static public function ctrMostrarHabitaciones($item, $valor){ 

		$tabla = "habitaciones";
 
		$respuesta = ModeloHabitaciones::mdlMostrarHabitaciones($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	Mostrar Habitación Singular
	=============================================*/
	
	static public function ctrMostrarHabitacion($valor){

		$tabla = "habitaciones";

		$respuesta = ModeloHabitaciones::mdlMostrarHabitacion($tabla, $valor);

		return $respuesta;
 
	}


}