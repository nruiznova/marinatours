<?php

require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";

require_once "../controladores/testimonios.controlador.php";
require_once "../modelos/testimonios.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

	/*=============================================
	Sumar reservas de usuarios
	=============================================*/	

	public $idUsuarioR;

	public function ajaxSumarReservas(){

		$respuesta = ControladorReservas::ctrMostrarReservas("id_usuario", $this->idUsuarioR);

		echo json_encode($respuesta);

	}

	/*=============================================
	Sumar testimonios de usuarios
	=============================================*/	

	public $idUsuarioT;

	public function ajaxSumarTestimonios(){

		$respuesta = ControladorTestimonios::ctrMostrarTestimonios("id_us", $this->idUsuarioT);

		echo json_encode($respuesta);

	}

	/*=============================================
	Eliminar usuarios
	=============================================*/	

	public $idDelete;

	public function ajaxBorrarUsuario(){

		$respuesta = ControladorUsuarios::ctrBorrarUsuario($this->idDelete);

		echo json_encode($respuesta);

	}

}

/*=============================================
Sumar reservas de usuarios
=============================================*/	

if(isset($_POST["idUsuarioR"])){

	$sumaReserva = new AjaxUsuarios();
	$sumaReserva -> idUsuarioR = $_POST["idUsuarioR"];
	$sumaReserva -> ajaxSumarReservas();

}

/*=============================================
Sumar reservas de usuarios
=============================================*/	

if(isset($_POST["idUsuarioT"])){

	$sumaTestimonio = new AjaxUsuarios();
	$sumaTestimonio -> idUsuarioT = $_POST["idUsuarioT"];
	$sumaTestimonio -> ajaxSumarTestimonios();

}

/*=============================================
Eliminar usuarios
=============================================*/	

if(isset($_POST["idDelete"])){

	$borrarUsuario = new AjaxUsuarios();
	$borrarUsuario -> idDelete = $_POST["idDelete"];
	$borrarUsuario -> ajaxBorrarUsuario();

}