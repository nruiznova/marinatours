<?php
require_once __DIR__ . "/../modelos/reservas.modelo.php"; 

Class ControladorReservas{

	/*=============================================
	Mostrar Reservas
	=============================================*/

	static public function ctrMostrarReservas($valor){ 

		$tabla1 = "habitaciones";
		$tabla2 = "reservas"; 
		$tabla3 = "categorias";

		$respuesta = ModeloReservas::mdlMostrarReservas($tabla1, $tabla2, $tabla3, $valor); 

		return $respuesta;
 
	}  

	/*=============================================
	MOSTRAR PAGOS
	=============================================*/

	static public function ctrMostrarPagos($item, $valor){

		$tabla = "pagos";

		$respuesta = ModeloReservas::mdlMostrarPagos($tabla, $item, $valor);

		return $respuesta;

	}


	/*=============================================
	Mostrar Código Reserva Singular
	=============================================*/
	
	static public function ctrMostrarCodigoReserva($valor){ 

		$tabla = "reservas";		

		$respuesta = ModeloReservas::mdlMostrarCodigoReserva($tabla, $valor);

		return $respuesta;

	}

	/*=============================================
	Guardar Reserva
	=============================================*/
	
	static public function ctrGuardarReserva($datos){

		$tabla = "reservas"; 

		// asignar los asientos

		$acompañantes = array();

		// cantidad de personas

		$descArr = explode(" - ", $datos["descripcion_reserva"]);

		$cantidadPersonas = intval($descArr[1]);

		// traer reservas para ese servicio ese dia

		$reservas = ModeloReservas::mdlMostrarReservaAll($tabla);

		$contReservas = 1;

		foreach ($reservas as $key => $value) {

			if($value["fecha_ingreso"] != "0000-00-00" && $value["fecha_ingreso"] != null){

				if (strpos($value["descripcion_reserva"], $descArr[0]) !== false && date("Y-m-d", strtotime($value["fecha_ingreso"])) == date("Y-m-d", strtotime($datos["fecha_ingreso"]))) {
				
					$descArr1 = explode(" - ", $value["descripcion_reserva"]);
					$cantidadPersonas1 = intval($descArr1[1]);
					$contReservas += $cantidadPersonas1;
					
				}

			}			

		}		 

		for ($i=1; $i <= $cantidadPersonas; $i++) { 

			// $contReservas++;

			if($contReservas > 9){

				$asiento = "0".($contReservas++);

			}else{

				$asiento = "00".($contReservas++);
 
			}
			
			$item = array('asiento' => $asiento);

			array_push($acompañantes, $item);

		}

		// $newAcompañantes = json_encode($acompañantes, JSON_UNESCAPED_UNICODE);
		if(isset($datos["acompañantes"])){
			$listaActual = json_decode($datos["acompañantes"], true);

			foreach ($listaActual as $list => $guest) {
				
				$listaActual[$list]["asiento"] = isset($acompañantes[$list]) ? $acompañantes[$list]["asiento"] : '00' . ($list + 1);

			}

			$datos["acompañantes"] = json_encode($listaActual, JSON_UNESCAPED_UNICODE);
		}
		else{
			$datos["acompañantes"] = json_encode([], JSON_UNESCAPED_UNICODE);
		}

		

		$respuesta = ModeloReservas::mdlGuardarReserva($tabla, $datos);  

		// if($respuesta != ""){

		// 	$tablaTestimonios = "testimonios"; 

		// 	$datos = array("id_res" => $respuesta,
		// 				   "id_us" => $valor["id_usuario"],
		// 				   "id_hab" => $valor["id_habitacion"],
		// 				   "testimonio" => "",
		// 				   "aprobado" => 0);

		// 	$crearTestimonio = ModeloReservas::mdlCrearTestimonio($tablaTestimonios, $datos);

		// 	$traerNotifiaciones = ModeloReservas::mdlMostrarNotificaciones("notificaciones", "reservas");

		// 	$cantidad = $traerNotifiaciones["cantidad"]+1;

		// 	$actualizarNotifiaciones = ModeloReservas::mdlActualizarNotificaciones("notificaciones", "reservas", $cantidad);

		// 	return $crearTestimonio;
		// }

		return $respuesta;

	}

	static public function ctrCrearTestimonio(){

		if(isset($_POST["testimonio"])){

			$tablaTestimonios = "testimonios";

			if($_POST["galeria"] != ""){

				$ruta = array();
				$guardarRuta = array();

				$galeria = json_decode($_POST["galeria"], true);
				
				$directorio = "vistas/img/";
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0755, true); // crea el directorio con permisos
                }


				for($i = 0; $i < count($galeria); $i++){															

					$file = $galeria[$i];
					$pos = strpos($file, ';');
					$type = explode(':', substr($file, 0, $pos))[1];
					$mime = explode('/', $type);

					$pathImage = "vistas/img/".$_POST["nombre"].($i+1).".".$mime[1];			

					$file = substr($file, strpos($file, ',') + 1, strlen($file));
					$dataBase64 = base64_decode($file);
					file_put_contents($pathImage, $dataBase64);	

					array_push($ruta, strtolower($pathImage));						

					array_push($guardarRuta, $ruta[$i]);

				}

			}else{
			    $guardarRuta = array();
			}	 	

			$datos = array("nombre" => $_POST["nombre"],
							"pais" => $_POST["pais"],
							"testimonio" => $_POST["testimonio"],
							"galeria" => json_encode($guardarRuta),
							"aprobado" => 1);

			$crearTestimonio = ModeloReservas::mdlCrearTestimonio($tablaTestimonios, $datos);

			if($crearTestimonio == "ok"){

				echo'<script>

					swal.fire({
							icon:"success",
							title: "GRACIAS POR DEJARNOS TU RESEÑA!",
							text: "La reseña ha sido enviada exitosamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							
					}).then(function(result){

							if(result.value){   
								window.location = "inicio"
							} 
					});

				</script>'; 

			}else{

				echo'<script> 

					swal.fire({
							icon:"error",
							title: "¡CORREGIR!",
							text: "¡Error al enviar el testimonio!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						
					}).then(function(result){

							if(result.value){   
								history.back();
							} 
					});

				</script>';	

			}

		}

	}
 
	/*=============================================
	Mostrar Reservas por usuario
	=============================================*/

	static public function ctrMostrarReservasUsuario($valor){ 

		$tabla = "reservas";

		$respuesta = ModeloReservas::mdlMostrarReservasUsuario($tabla, $valor);

		return $respuesta;
		
	}

	/*=============================================
	Mostrar Testimonios
	=============================================*/

	static public function ctrMostrarTestimonios($item, $valor){

		$tabla1 = "testimonios";
		$tabla2 = "habitaciones";
		$tabla3 = "reservas";
		$tabla4 = "usuarios";

		$respuesta = ModeloReservas::mdlMostrarTestimonios($tabla1, $tabla2, $tabla3, $tabla4, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	Actualizar Testimonio
	=============================================*/

	public function ctrActualizarTestimonio(){

		if(isset($_POST["actualizarTestimonio"])){

			if(preg_match('/^[?\\¿\\!\\¡\\:\\,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["actualizarTestimonio"])){

				$tabla = "testimonios";

				$datos = array("id_testimonio"=>$_POST["idTestimonio"],
							   "testimonio"=>$_POST["actualizarTestimonio"]);

				$respuesta = ModeloReservas::mdlActualizarTestimonio($tabla, $datos);

				if($respuesta == "ok"){

					$traerNotifiaciones = ModeloReservas::mdlMostrarNotificaciones("notificaciones", "testimonios");

					$cantidad = $traerNotifiaciones["cantidad"]+1;

					$actualizarNotifiaciones = ModeloReservas::mdlActualizarNotificaciones("notificaciones", "testimonios", $cantidad);

					echo'<script>

							swal({
									type:"success",
								  	title: "¡CORRECTO!",
								  	text: "El testimonio ha sido actualizado correctamente",
								  	showConfirmButton: true,
									confirmButtonText: "Cerrar"
								  
							}).then(function(result){

									if(result.value){   
									    history.back();
									  } 
							});

						</script>';

				}

			}else{

				echo'<script>

					swal({
							type:"error",
						  	title: "¡CORREGIR!",
						  	text: "¡No se permiten caracteres especiales!",
						  	showConfirmButton: true,
							confirmButtonText: "Cerrar"
						  
					}).then(function(result){

							if(result.value){   
							    history.back();
							  } 
					});

				</script>';	

			}
		
		}

	}

	/*=============================================
	REGISTRAR PAGOS
	=============================================*/

	static public function ctrRegistrarPago($datos){

		$tabla = "pagos";

		$respuesta = ModeloReservas::mdlRegistrarPagos($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	COMPLETAR DATOS RESERVA
	=============================================*/

	static public function ctrCompletarDatosReserva($datos){ 

		$tabla = "reservas";

		// traer los asientos

		$reserva = ModeloReservas::mdlMostrarIdReserva($tabla, $datos["id_reserva"]);

		$asientos = json_decode($reserva["guests"], true);

		// var_dump($asientos);

		$acompañantes = json_decode($datos["acompañantes"], true);

		$newAcompañantes = array();

		foreach ($acompañantes as $key => $value) {
			
			$item = array("nombre" => $value["nombre"],
						  "tipo_documento" => $value["tipo_documento"],
						  "documento" => $value["documento"],
						  "tipo" => $value["tipo"],
						  "nacionalidad" => $value["nacionalidad"],
						  "asiento" => $asientos[$key]["asiento"]);

			array_push($newAcompañantes, $item);

		}

		$newGuests = json_encode($newAcompañantes, JSON_UNESCAPED_UNICODE);

		$datos["acompañantes"] = $newGuests;

		$respuesta = ModeloReservas::mdlCompletarDatos($tabla, $datos);

		return $respuesta;

	}

	static public function ctrVerificarDisponibilidad($idServicio, $fecha) {
        return ModeloReservas::mdlVerificarDisponibilidad($idServicio, $fecha);
    }
    
    public static function ctrGuardarReservaTemporal($datos)
    {
    	return ModeloReservas::mdlGuardarReservaTemporal($datos);
    }

	public static function ctrSaveTrazabilityCode($tx, $codigo_reserva)
    {
    	return ModeloReservas::mdlSaveTrazabilityCode($tx, $codigo_reserva);
    }

	public static function ctrSaveTransactionState($state, $codigo_reserva)
    {
    	return ModeloReservas::mdlSaveTransactionState($state, $codigo_reserva);
    }
}