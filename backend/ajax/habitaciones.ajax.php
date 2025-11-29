<?php

require_once "../controladores/habitaciones.controlador.php";
require_once "../modelos/habitaciones.modelo.php";

class AjaxHabitaciones{

	public $tipo_h;
	public $tipo;
    public $estilo;
	public $ruta;
    public $galeria;
    public $descripcion;
    public $idHabitacion;
    public $galeriaAntigua;
	public $banner;
	public $cupos;
	public $serviciosEnlazados;
	public $precio;
	public $caracteristicas;
	public $lugarSalida;
	public $horaSalida;
	public $incluye;
	public $noIncluye;
	public $recomendaciones;
	public $itinerario;

	/*=============================================
	Nueva habitación
	=============================================*/	

	public function ajaxNuevaHabitacion(){
	
		$datos = array( "tipo_h" => $this->tipo_h,
						"tipo" => $this->tipo,
						"estilo" => $this->estilo,
						"ruta" => $this->ruta,
						"galeria" => $this->galeria,		 				
						"descripcion" => $this->descripcion,
						"banner" => $this->banner,
						"cupos" => $this->cupos,
						"serviciosEnlazados" => $this->serviciosEnlazados,
						"precio" => $this->precio,
						"caracteristicas" => $this->caracteristicas,
						"lugarSalida" => $this->lugarSalida,
						"horaSalida" => $this->horaSalida,
						"incluye" => $this->incluye,
						"noIncluye" => $this->noIncluye,
						"recomendaciones" => $this->recomendaciones,
						"itinerario" => $this->itinerario
						);

		$respuesta = ControladorHabitaciones::ctrNuevaHabitacion($datos);

		echo $respuesta; 

	}

	/*=============================================
	Editar habitación
	=============================================*/	

	public function ajaxEditarHabitacion(){
	
		$datos = array( "idHabitacion" => $this->idHabitacion,
						"tipo_h" => $this->tipo_h,
						"tipo" => $this->tipo,
						"estilo" => $this->estilo,
						"ruta" => $this->ruta,
						"galeria" => $this->galeria,
						"galeriaAntigua" => $this->galeriaAntigua,						
						"descripcion" => $this->descripcion,
						"banner" => $this->banner,
						"cupos" => $this->cupos,
						"serviciosEnlazados" => $this->serviciosEnlazados,
						"precio" => $this->precio,
						"caracteristicas" => $this->caracteristicas,
						"lugarSalida" => $this->lugarSalida,
						"horaSalida" => $this->horaSalida,
						"incluye" => $this->incluye,
						"noIncluye" => $this->noIncluye,
						"recomendaciones" => $this->recomendaciones,
						"itinerario" => $this->itinerario
						);

		$respuesta = ControladorHabitaciones::ctrEditarHabitacion($datos);

		echo $respuesta;

	}

	/*=============================================
	Eliminar habitación
	=============================================*/	

	public $idEliminar;
	public $galeriaHabitacion;
	// public $recorridoHabitacion;

	public function ajaxEliminarHabitacion(){
	
		$datos = array( "idEliminar" => $this->idEliminar,
						"galeriaHabitacion" => $this->galeriaHabitacion);

		$respuesta = ControladorHabitaciones::ctrEliminarHabitacion($datos);

		echo $respuesta;

	}

}

/*=============================================
Guardar habitación
=============================================*/	

if(isset($_POST["tipo"])){

	$habitacion = new AjaxHabitaciones();
	$habitacion -> tipo_h = $_POST["tipo_h"];
	$habitacion -> tipo = $_POST["tipo"];
    $habitacion -> estilo = $_POST["estilo"];
	$habitacion -> ruta = $_POST["ruta"];
    $habitacion -> galeria = $_POST["galeria"]; 
    $habitacion -> galeriaAntigua = $_POST["galeriaAntigua"];
    $habitacion -> banner = $_POST["banner"];
	$habitacion -> cupos = $_POST["cupos"];
	$habitacion -> serviciosEnlazados = $_POST["serviciosEnlazados"];
	$habitacion -> precio = $_POST["precio"];
	$habitacion -> caracteristicas = $_POST["caracteristicas"];
	$habitacion -> lugarSalida = $_POST["lugarSalida"];
	$habitacion -> horaSalida = $_POST["horaSalida"];
	$habitacion -> incluye = $_POST["incluye"];
	$habitacion -> noIncluye = $_POST["noIncluye"];
	$habitacion -> recomendaciones = $_POST["recomendaciones"];
	$habitacion -> itinerario = $_POST["itinerario"];
    $habitacion -> descripcion = $_POST["descripcion"];

    if($_POST["idHabitacion"] != ""){

    	$habitacion -> idHabitacion = $_POST["idHabitacion"];
    	$habitacion -> ajaxEditarHabitacion();

    }else{

    	$habitacion -> ajaxNuevaHabitacion();

    }
  
}

/*=============================================
Eliminar habitación
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxHabitaciones();
    $eliminar -> idEliminar = $_POST["idEliminar"];
    $eliminar -> galeriaHabitacion = $_POST["galeriaHabitacion"];
    // $eliminar -> recorridoHabitacion = $_POST["recorridoHabitacion"];
    $eliminar -> ajaxEliminarHabitacion();
	
}