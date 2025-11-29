<?php

class ControladorReservas{

	/*=============================================
	MOSTRAR USUARIOS-RESERVAS CON INNER JOIN
	=============================================*/

	static public function ctrMostrarReservas($item, $valor){      

		$tabla1 = "usuarios";
		$tabla2 = "reservas"; 

		$respuesta = ModeloReservas::mdlMostrarReservas($tabla1, $tabla2, $item, $valor); 

		return $respuesta;  

	} 

	/*=============================================
	Cambiar Reserva
	=============================================*/

	static public function ctrCambiarReserva($datos){

		$tabla = "reservas";

		$respuesta = ModeloReservas::mdlCambiarReserva($tabla, $datos);

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
	MOSTRAR PAGOS
	=============================================*/

	static public function ctrRegistrarPago($datos){

		$tabla = "pagos";

		$respuesta = ModeloReservas::mdlRegistrarPagos($tabla, $datos);

		return $respuesta;

	}

	static public function ctrBloquearFechas(){

		if(isset($_POST["fecha_inicial"])){

				$tabla = "fechas_bloqueadas";

				$datos = array("fecha_inicial" => $_POST["fecha_inicial"],
							   "fecha_final" => $_POST["fecha_final"],
							   "id" => $_POST["idRango"]);

				// var_dump($datos);

				if($_POST["typeAction"] == "add"){

					$respuesta = ModeloReservas::mdlBloquearFechas($tabla, $datos);

					if($respuesta == "ok"){

						echo '<script>
	
							swal({
								type:"success",
								  title: "¡CORRECTO!",
								  text: "¡Las fechas se bloquearon exitosamente!",
								  showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
							}).then(function(result){
	
									if(result.value){   
										window.location = "administradores";
									  } 
							});
	
						</script>';
	
					}

				}else if($_POST["typeAction"] == "edit"){

					$respuesta = ModeloReservas::mdlEditarFechas($tabla, $datos);

					if($respuesta == "ok"){

						echo '<script>
	
							swal({
								type:"success",
								  title: "¡CORRECTO!",
								  text: "¡Se editó el rango de fechas bloqueadas correctamente!",
								  showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
							}).then(function(result){
	
									if(result.value){   
										window.location = "administradores";
									  } 
							});
	
						</script>';
	
					}

				}else if($_POST["typeAction"] == "del"){

					$respuesta = ModeloReservas::mdlBorrarFechas($tabla, $datos);

					if($respuesta == "ok"){

						echo '<script>
	
							swal({
								type:"success",
								  title: "¡CORRECTO!",
								  text: "¡Se eliminó el rango de fechas bloqueadas correctamente!",
								  showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
							}).then(function(result){
	
									if(result.value){   
										window.location = "administradores";
									  } 
							});
	
						</script>';
	
					}

				}									

			// }

		}

	}

	/*=============================================
	Eliminar pagos
	=============================================*/

	static public function ctrEliminarPago($idReserva){

		$tabla = "pagos";

		$respuesta = ModeloReservas::mdlEliminarPago($tabla, $idReserva);

		return $respuesta; 

	}

	/*=============================================
	Actualizar estado
	=============================================*/
 
	static public function ctrActualizarEstado($datos){ 

		$tabla = "reservas"; 

		$respuesta = ModeloReservas::mdlActualizarEstado($tabla, $datos);
 
		return $respuesta; 

	}

	/*=============================================
	Mostrar cupos de un servicio en una fecha
	=============================================*/

	static public function ctrMostrarCupos($datos){     

		$tabla = "cupos";

		$respuesta = ModeloReservas::mdlMostrarCupos($tabla, $datos); 

		return $respuesta;  

	}
	
	/*=============================================
	Actulizar cupos de un servicio en una fecha
	=============================================*/

	static public function ctrActualizarCupos($datos){     

		$tabla = "cupos";

		$respuesta = ModeloReservas::mdlActualizarCupos($tabla, $datos); 

		return $respuesta;  

	}

}