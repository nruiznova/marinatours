<?php

require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";

require_once "../controladores/habitaciones.controlador.php";
require_once "../modelos/habitaciones.modelo.php";

class AjaxPagos{

    /*=============================================
	AGERGAR PAGO
	=============================================*/	

	public $idReserva;
	public $monto;
    public $metodo_pago;
    public $usuario;
	// public $recorridoHabitacion; 

	public function ajaxRegistrarPago(){
	
		$datos = array( "id_reserva" => $this->idReserva,
						"monto" => $this->monto,
                        "metodo_pago" => $this->metodo_pago,
                        "usuario" => $this->usuario);

		$respuesta = ControladorReservas::ctrRegistrarPago($datos);
 
		echo json_encode($respuesta);

	}

	/*=============================================
	ELIMINAR PAGO
	=============================================*/	

	public $idEliminarPagos;

	public function ajaxEliminarPago(){

		$respuesta = ControladorReservas::ctrEliminarPago($this->idEliminarPagos);
 
		echo json_encode($respuesta);

	}

}

/*=============================================
AGERGAR PAGO
=============================================*/	

if(isset($_POST["idReserva"])){

	$agregar = new AjaxPagos();
    $agregar -> idReserva = $_POST["idReserva"];
    $agregar -> monto = $_POST["monto"];
    $agregar -> metodo_pago = $_POST["metodo_pago"];
    $agregar -> usuario = $_POST["usuario"];
    $agregar -> ajaxRegistrarPago();
	
}

if(isset($_POST["idEliminarPagos"])){

	$eliminar = new AjaxPagos();
	$eliminar -> idEliminarPagos = $_POST["idEliminarPagos"];
	$eliminar -> ajaxEliminarPago();

}

?>