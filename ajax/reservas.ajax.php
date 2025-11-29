<?php

require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";


class AjaxReservas{ 

	/*=============================================
	Traer Reserva Habitación
	=============================================*/

	public $idHabitacion;

	public function ajaxTraerReserva(){ 

		$valor = $this->idHabitacion;

		$respuesta = ControladorReservas::ctrMostrarReservas($valor); 

		echo json_encode($respuesta);

	}

	/*=============================================
	Traer Reserva a través de Código
	=============================================*/

	public $codigoReserva;

	public function ajaxTraerCodigoReserva(){

		$valor = $this->codigoReserva;

		$respuesta = ControladorReservas::ctrMostrarCodigoReserva($valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	Traer Reserva Habitaciones
	=============================================*/

	public $idHabitaciones;
	public $fechaIngreso;
	public $fechaSalida;

	public function ajaxTraerReservas(){

		$valor = $this->idHabitaciones;
		$fechaIngreso = $this->fechaIngreso;
		$fechaSalida = $this->fechaSalida;

		$respuesta = ControladorReservas::ctrMostrarReservas($valor);

		if($respuesta != 0){

			foreach ($respuesta as $key => $value) {

				if($fechaIngreso == $value["fecha_ingreso"] ||
				   $fechaIngreso > $value["fecha_ingreso"] && $fechaIngreso < $value["fecha_salida"] ||
				   $fechaIngreso < $value["fecha_ingreso"] && $fechaSalida > $value["fecha_ingreso"]){

					echo json_encode($value["id_h"]);

					return;

				}
				
			}
		}

		echo json_encode("");

	}


	/*=============================================
	Traer Testimonios
	=============================================*/

	public $id_h;

	public function ajaxTraerTestimonios(){

		$item = "id_hab";
		$valor = $this->id_h;

		$respuesta = ControladorReservas::ctrMostrarTestimonios($item, $valor);

		echo json_encode($respuesta);

	}

	// guardar reserva

	public $codigoReservaNueva;
	public $idHabitacionNueva;
	public $imgHabitacion;
	public $infoHabitacion;
	public $pagoReserva;
	public $id_user;
	public $fechaIngresoNueva;
	public $fechaSalidaNueva;
	public $acompañantes;
	public $firstName;
	public $lastName;
	public $tipo_identificacion;
	public $numero_identificacion;
	public $celular;
	public $correo;
	public $hospedaje;
	public $abono;
	public $cuotas;
	public $montoPagar;
	public $valorCuotas;
	public $pagoCuotas;

	public function crearReserva(){

		$datos = array( "id_habitacion" => $this->idHabitacionNueva,
					"id_usuario" => $this->id_user, 
					"pago_reserva" => $this->pagoReserva,
					"numero_transaccion" => null,
					"codigo_reserva" => $this->codigoReservaNueva,
					"descripcion_reserva" => $this->infoHabitacion,
					"fecha_ingreso" => $this->fechaIngresoNueva,
					"fecha_salida" => $this->fechaSalidaNueva,
					"acompañantes" => $this->acompañantes,
					"firstName" => $this->firstName,
					"lastName" => $this->lastName,
					"tipo_identificacion" => $this->tipo_identificacion,
					"numero_identificacion" => $this->numero_identificacion,
					"celular" => $this->celular,
					"correo" => $this->correo,
					"hospedaje" => $this->hospedaje,
					"abono" => $this->abono,
					"cuotas" => $this->cuotas,
					"montoPagar" => $this->montoPagar,
					"valorCuotas" => $this->valorCuotas,
					"pagoCuotas" => $this->pagoCuotas);

		$respuesta = ControladorReservas::ctrGuardarReserva($datos);  
		
		echo json_encode($respuesta); 					

	}

	

	/*=============================================
	Completar acompañantes reserva
	=============================================*/

	public $idCompletarDatos;
	public $acompañantesCompletarDatos;

	public function completarDatosReserva(){

		$datos = array("id_reserva" => $this->idCompletarDatos,
					   "acompañantes" => $this->acompañantesCompletarDatos);

		$respuesta = ControladorReservas::ctrCompletarDatosReserva($datos);  
		
		echo json_encode($respuesta); 
 
	}


}

/*=============================================
Traer Reserva Habitación
=============================================*/

if(isset($_POST["idHabitacion"])){

	$idHabitacion = new AjaxReservas();
	$idHabitacion -> idHabitacion = $_POST["idHabitacion"];
	$idHabitacion -> ajaxTraerReserva();

}

/*=============================================
Traer Reserva Codigo
=============================================*/

if(isset($_POST["codigoReserva"])){

	$codigoReserva = new AjaxReservas();
	$codigoReserva -> codigoReserva = $_POST["codigoReserva"];
	$codigoReserva -> ajaxTraerCodigoReserva();

}



/*=============================================
Traer Reservas Habitaciones
=============================================*/

if(isset($_POST["idHabitaciones"])){

	$idHabitaciones = new AjaxReservas();
	$idHabitaciones -> idHabitaciones = $_POST["idHabitaciones"];
	$idHabitaciones -> fechaIngreso = $_POST["fechaIngreso"];
	$idHabitaciones -> fechaSalida = $_POST["fechaSalida"];
	$idHabitaciones -> ajaxTraerReservas();

}

/*=============================================
Traer Testimonios
=============================================*/

if(isset($_POST["id_h"])){

	$id_h = new AjaxReservas();
	$id_h -> id_h = $_POST["id_h"];
	$id_h -> ajaxTraerTestimonios();

}

// guardar reserva

if(isset($_POST["codigoReservaNueva"])){

	$nuevaReserva = new ajaxReservas();
	$nuevaReserva -> codigoReservaNueva = $_POST["codigoReservaNueva"];
	$nuevaReserva -> idHabitacionNueva = $_POST["idHabitacionNueva"];
	$nuevaReserva -> imgHabitacion = $_POST["imgHabitacion"];
	$nuevaReserva -> infoHabitacion = $_POST["infoHabitacion"];
	$nuevaReserva -> pagoReserva = $_POST["pagoReserva"];
	$nuevaReserva -> id_user = $_POST["id_user"];
	$nuevaReserva -> fechaIngresoNueva = $_POST["fechaIngresoNueva"];
	$nuevaReserva -> fechaSalidaNueva = $_POST["fechaSalidaNueva"];
	$nuevaReserva -> acompañantes = $_POST["acompañantes"]; 
	$nuevaReserva -> firstName = $_POST["firstName"]; 
	$nuevaReserva -> lastName = $_POST["lastName"];
	$nuevaReserva -> tipo_identificacion = $_POST["tipo_identificacion"];
	$nuevaReserva -> numero_identificacion = $_POST["numero_identificacion"];
	$nuevaReserva -> celular = $_POST["celular"];
	$nuevaReserva -> correo = $_POST["correo"];
	$nuevaReserva -> hospedaje = $_POST["hospedaje"];
	$nuevaReserva -> abono = $_POST["abono"];
	$nuevaReserva -> cuotas = $_POST["cuotas"];
	$nuevaReserva -> montoPagar = $_POST["montoPagar"];
	$nuevaReserva -> valorCuotas = $_POST["valorCuotas"];
	$nuevaReserva -> pagoCuotas = $_POST["pagoCuotas"];
	$nuevaReserva -> crearReserva();

}

// completar datos reserva

if(isset($_POST["idCompletarDatos"])){

	$completarDatos = new ajaxReservas();
	$completarDatos -> idCompletarDatos = $_POST["idCompletarDatos"];
	$completarDatos -> acompañantesCompletarDatos = $_POST["acompañantes"];
	$completarDatos -> completarDatosReserva();

}

/*=============================================
Verificar disponibilidad (nuevo)
=============================================*/

if(isset($_POST["verificarDisponibilidad"])){

    $idServicio = $_POST["idServicio"];
    $fecha = $_POST["fecha"];

    $respuesta = ControladorReservas::ctrVerificarDisponibilidad($idServicio, $fecha);

    echo json_encode($respuesta);
}

// al final del archivo reservas.ajax.php
