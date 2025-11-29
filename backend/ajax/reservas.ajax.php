<?php

require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";

class AjaxReservas{

	/*=============================================
	Mostrar Reservas
	=============================================*/	

	public $idHabitacion;

	public function ajaxMostrarReservas(){ 

		$respuesta = ControladorReservas::ctrMostrarReservas("id_habitacion", $this->idHabitacion);

		echo json_encode($respuesta);
 
	}

	/*=============================================
	Mostrar Reservar por un dato
	=============================================*/	

	public $idReservaMostrar;

	public function ajaxMostrarReserva(){ 

		$respuesta = ControladorReservas::ctrMostrarReservas("codigo_reserva", $this->idReservaMostrar);

		echo json_encode($respuesta);
 
	}

	/*=============================================
	Mostrar Pagos 
	=============================================*/	

	public $idReservaPago;

	public function ajaxMostrarPagos(){ 

		$respuesta = ControladorReservas::ctrMostrarPagos("id_reserva", $this->idReservaPago);

		echo json_encode($respuesta);
 
	}

	/*=============================================
	Cambiar Reservas
	=============================================*/	 

	public $idReserva;
	public $fecha_ingreso;
	// public $personas;
	public $firstName;
	public $lastName;
	public $tipo_identificacion;
	public $numero_identificacion;
	public $celular;
	public $correo;

	public function ajaxCambiarReserva(){

		$datos = array("id_reserva" => $this->idReserva,
					   "fecha_ingreso" => date("Y-m-d", strtotime($this->fecha_ingreso)),
						"firstName" => $this->firstName,
						"lastName" => $this->lastName,
						"tipo_identificacion" => $this->tipo_identificacion,
						"numero_identificacion" => $this->numero_identificacion,
						"celular" => $this->celular,
						"correo" => $this->correo);

		$respuesta = ControladorReservas::ctrCambiarReserva($datos);
 
		echo $respuesta;
 
	}

	/*=============================================
	Actualizar estado reserva
	=============================================*/	

	public $idReservaStatus;
	public $status;

	public function ajaxActualizarEstado(){

		$datos = array("id_reserva" => $this->idReservaStatus,
						"estado" => $this->status);

		$respuesta = ControladorReservas::ctrActualizarEstado($datos);

		echo $respuesta;

	}

	/*=============================================
	Actualizar estado reserva (desmarcar)
	=============================================*/	

	public $idDesmarcarStatus;
	public $desmarcarStatus;
	public $fechaStatus;

	public function ajaxDesmarcarEstado(){

		$datos = array("id_reserva" => $this->idDesmarcarStatus,
						"estado" => $this->desmarcarStatus,
					    "fecha_ingreso" => $this->fechaStatus);

		$respuesta = ControladorReservas::ctrActualizarEstado($datos);

		echo $respuesta;

	}

	/*=============================================
	Mostrar cupos de un servicio en una fecha
	=============================================*/	

	public $serviciosCupos;
	public $fechaCupos;

	public function ajaxMostrarCupos(){ 

		$datos = array("servicios" => $this->serviciosCupos,
					   "fecha" => $this->fechaCupos);

		$respuesta = ControladorReservas::ctrMostrarCupos($datos);

		echo json_encode($respuesta);
 
	}

	/*=============================================
	Actualizar cupos de un servicio en una fecha
	=============================================*/

	public $ajustarServicioCupos;
	public $ajustarFechaCupos;
	public $ajustarCupos;

	public function ajaxActualizarCupos(){ 

		$datos = array("servicios" => $this->ajustarServicioCupos,
					   "fecha" => $this->ajustarFechaCupos,
					   "cupos" => $this->ajustarCupos);

		$respuesta = ControladorReservas::ctrActualizarCupos($datos);

		echo json_encode($respuesta);
 
	}


}

/*=============================================
Mostrar Reservas
=============================================*/	

if(isset($_POST["idHabitacion"])){

	$editar = new AjaxReservas();
	$editar -> idHabitacion = $_POST["idHabitacion"];
	$editar -> ajaxMostrarReservas();

}

/*=============================================
Mostrar Reservas por dato
=============================================*/	

if(isset($_POST["idReservaMostrar"])){

	$editar = new AjaxReservas();
	$editar -> idReservaMostrar = $_POST["idReservaMostrar"];
	$editar -> ajaxMostrarReserva();

}

/*=============================================
Mostrar Pagos
=============================================*/	

if(isset($_POST["idReservaPago"])){

	$editar = new AjaxReservas();
	$editar -> idReservaPago = $_POST["idReservaPago"];
	$editar -> ajaxMostrarPagos();

}

/*=============================================
Cambiar Reservas
=============================================*/	

if(isset($_POST["idReserva"])){

	$guardar = new AjaxReservas();
	$guardar -> idReserva = $_POST["idReserva"];
	$guardar -> fecha_ingreso = $_POST["fecha_ingreso"];
	$guardar -> firstName = $_POST["firstName"];
	$guardar -> lastName = $_POST["lastName"];
	$guardar -> tipo_identificacion = $_POST["tipo_identificacion"];
	$guardar -> numero_identificacion = $_POST["numero_identificacion"];
	$guardar -> celular = $_POST["celular"];
	$guardar -> correo = $_POST["correo"];
	$guardar -> ajaxCambiarReserva();

}

/*=============================================
Actualizar estado 
=============================================*/	

if(isset($_POST["status"])){

	$cambiarEstado = new AjaxReservas();
	$cambiarEstado -> status = $_POST["status"];
	$cambiarEstado -> idReservaStatus = $_POST["idReservaStatus"];
	$cambiarEstado -> ajaxActualizarEstado();

} 

/*=============================================
Actualizar estado (desmarcar)
=============================================*/	

if(isset($_POST["idDesmarcarStatus"])){

	$cambiarEstado = new AjaxReservas();
	$cambiarEstado -> desmarcarStatus = $_POST["desmarcarStatus"];
	$cambiarEstado -> idDesmarcarStatus = $_POST["idDesmarcarStatus"];
	$cambiarEstado -> fechaStatus = $_POST["fechaStatus"];
	$cambiarEstado -> ajaxDesmarcarEstado();

} 

/*=============================================
Mostrar cupos de un servicio en una fecha
=============================================*/	

if(isset($_POST["serviciosCupos"])){

	$verCupos = new AjaxReservas();
	$verCupos -> serviciosCupos = $_POST["serviciosCupos"];
	$verCupos -> fechaCupos = $_POST["fechaCupos"];
	$verCupos -> ajaxMostrarCupos();

}

/*=============================================
Actualizar cupos de un servicio en una fecha
=============================================*/	

if(isset($_POST["ajustarServicioCupos"])){

	$actualizarCupos = new AjaxReservas();
	$actualizarCupos -> ajustarServicioCupos = $_POST["ajustarServicioCupos"];
	$actualizarCupos -> ajustarFechaCupos = $_POST["ajustarFechaCupos"];
	$actualizarCupos -> ajustarCupos = $_POST["ajustarCupos"];
	$actualizarCupos -> ajaxActualizarCupos();

}