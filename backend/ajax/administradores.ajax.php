<?php

require_once "../controladores/administradores.controlador.php";
require_once "../modelos/administradores.modelo.php";

class AjaxAdministradores{

	/*=============================================
	Editar Administrador
	=============================================*/	

	public $idAdministrador;

	public function ajaxMostrarAdministradores(){ 

		$item = "id";
		$valor = $this->idAdministrador;

		$respuesta = ControladorAdministradores::ctrMostrarAdministradores($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	Activar o desactivar administrador
	=============================================*/	

	public $idAdmin;
	public $estadoAdmin;

	public function ajaxActivarAdministrador(){

		$tabla = "administradores";

		$item1 = "id";
		$valor1 = $this->idAdmin;

		$item2 = "estado";
		$valor2 = $this->estadoAdmin;

		$respuesta = ModeloAdministradores::mdlActualizarAdministrador($tabla, $item1, $valor1, $item2, $valor2);

		echo $respuesta;

	}

	/*=============================================
	Eliminar Administrador
	=============================================*/	

	public $idEliminar;

	public function ajaxEliminarAdministrador(){

		$respuesta = ControladorAdministradores::ctrEliminarAdministrador($this->idEliminar);

		echo $respuesta;

	}

	/*=============================================
	Editar galeria
	=============================================*/	

	public $idGaleria;
	public $galeria;
	public $galeriaAntigua;
	public $nombre;

	public function ajaxEditarGaleria(){

		$datos = array("id_galeria" => $this->idGaleria,
					   "galeria" => $this->galeria,
					   "galeriaAntigua" => $this->galeriaAntigua,
					   "nombre" => $this->nombre);

		$respuesta = ControladorAdministradores::ctrEditarGaleria($datos);

		echo $respuesta;

	}

	/*=============================================
	Agregar seccion
	=============================================*/	

	public $nombreSeccion;

	public function ajaxNuevaSeccion(){ 
		
		$datos = $this->nombreSeccion;

		$respuesta = ControladorAdministradores::ctrNuevaSeccion($datos);

		echo $respuesta;

	}

	/*=============================================
	Eliminar galeria
	=============================================*/	

	public $idDelGaleria;

	public function ajaxEliminarGaleria(){ 
		
		// $datos = ;

		$respuesta = ControladorAdministradores::ctrEliminarGaleria($this->idDelGaleria);

		echo $respuesta;

	}

}

/*=============================================
Editar Administrador
=============================================*/
if(isset($_POST["idAdministrador"])){

	$editar = new AjaxAdministradores();
	$editar -> idAdministrador = $_POST["idAdministrador"];
	$editar -> ajaxMostrarAdministradores();

}

/*=============================================
Activar o desactivar administrador
=============================================*/	

if(isset($_POST["estadoAdmin"])){

	$activarAdmin = new AjaxAdministradores();
	$activarAdmin -> idAdmin = $_POST["idAdmin"];
	$activarAdmin -> estadoAdmin = $_POST["estadoAdmin"];
	$activarAdmin -> ajaxActivarAdministrador();

}

/*=============================================
Eliminar Administrador
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxAdministradores();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarAdministrador();

}

/*=============================================
Editar galeria
=============================================*/	

if(isset($_POST["idGaleria"])){

	$eliminar = new AjaxAdministradores();
	$eliminar -> idGaleria = $_POST["idGaleria"];
	$eliminar -> galeria = $_POST["galeria"];
	$eliminar -> galeriaAntigua = $_POST["galeriaAntigua"];
	$eliminar -> nombre = $_POST["nombre"];
	$eliminar -> ajaxEditarGaleria();

}

/*=============================================
Nueva seccion
=============================================*/	

if(isset($_POST["nombreSeccion"])){

	$eliminar = new AjaxAdministradores();
	$eliminar -> nombreSeccion = $_POST["nombreSeccion"];
	$eliminar -> ajaxNuevaSeccion();

}


/*=============================================
Eliminar galeria
=============================================*/	

if(isset($_POST["idDelGaleria"])){

	$eliminar = new AjaxAdministradores();
	$eliminar -> idDelGaleria = $_POST["idDelGaleria"];
	$eliminar -> ajaxEliminarGaleria();

}