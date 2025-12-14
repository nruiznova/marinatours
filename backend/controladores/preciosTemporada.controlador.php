<?php

class ControladorPreciosTemporada{

	/*=============================================
	Mostrar precios de temporada
	=============================================*/

	static public function ctrMostrarPreciosTemporada($item, $valor){

		$tabla = "precios_temporada";

		$respuesta = ModeloPreciosTemporada::mdlMostrarPreciosTemporada($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	Crear precio de temporada
	=============================================*/

	static public function ctrCrearPrecioTemporada(){

		if(isset($_POST["id_servicio_temporada"]) && 
		   (!isset($_POST["id_precio_temporada_editar"]) || empty($_POST["id_precio_temporada_editar"])) &&
		   isset($_POST["nombre_temporada"]) &&
		   isset($_POST["fecha_inicio_temporada"]) &&
		   isset($_POST["fecha_fin_temporada"]) &&
		   isset($_POST["precios_temporada"])){

			error_log("=== CREANDO NUEVA TEMPORADA ===");
			error_log("ID Servicio: " . $_POST["id_servicio_temporada"]);
			error_log("Nombre: " . $_POST["nombre_temporada"]);

			$tabla = "precios_temporada";

			// Verificar conflicto de fechas
			$conflicto = ModeloPreciosTemporada::mdlVerificarConflictoFechas(
				$tabla, 
				$_POST["id_servicio_temporada"], 
				$_POST["fecha_inicio_temporada"], 
				$_POST["fecha_fin_temporada"]
			);

			if($conflicto){
				echo'<script>
				swal({
					  type: "error",
					  title: "Error: Conflicto de fechas",
					  text: "Las fechas se cruzan con la temporada \''.$conflicto["nombre_temporada"].'\' ('.$conflicto["fecha_inicio"].' al '.$conflicto["fecha_fin"].')",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  })
				</script>';
				return;
			}

			$datos = array("id_servicio" => $_POST["id_servicio_temporada"],
						   "nombre_temporada" => $_POST["nombre_temporada"],
						   "fecha_inicio" => $_POST["fecha_inicio_temporada"],
						   "fecha_fin" => $_POST["fecha_fin_temporada"],
						   "precios" => $_POST["precios_temporada"],
						   "activo" => isset($_POST["activo_temporada"]) ? 1 : 0);

			$respuesta = ModeloPreciosTemporada::mdlCrearPrecioTemporada($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "¡La temporada ha sido guardada correctamente!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "servicios";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	Editar precio de temporada
	=============================================*/

	static public function ctrEditarPrecioTemporada(){

		if(isset($_POST["id_precio_temporada_editar"]) &&
		   !empty($_POST["id_precio_temporada_editar"]) &&
		   isset($_POST["nombre_temporada"]) &&
		   isset($_POST["fecha_inicio_temporada"]) &&
		   isset($_POST["fecha_fin_temporada"]) &&
		   isset($_POST["precios_temporada"]) &&
		   isset($_POST["id_servicio_temporada"])){

			// Debug
			error_log("=== EDITANDO TEMPORADA ===");
			error_log("ID: " . $_POST["id_precio_temporada_editar"]);
			error_log("Nombre: " . $_POST["nombre_temporada"]);

			$tabla = "precios_temporada";

			// Verificar conflicto de fechas (excluyendo la temporada actual)
			$conflicto = ModeloPreciosTemporada::mdlVerificarConflictoFechas(
				$tabla, 
				$_POST["id_servicio_temporada"], 
				$_POST["fecha_inicio_temporada"], 
				$_POST["fecha_fin_temporada"],
				$_POST["id_precio_temporada_editar"] // Excluir esta temporada de la verificación
			);

			if($conflicto){
				echo'<script>
				swal({
					  type: "error",
					  title: "Error: Conflicto de fechas",
					  text: "Las fechas se cruzan con la temporada \''.$conflicto["nombre_temporada"].'\' ('.$conflicto["fecha_inicio"].' al '.$conflicto["fecha_fin"].')",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  })
				</script>';
				return;
			}

			$datos = array("id_precio_temporada" => $_POST["id_precio_temporada_editar"],
						   "nombre_temporada" => $_POST["nombre_temporada"],
						   "fecha_inicio" => $_POST["fecha_inicio_temporada"],
						   "fecha_fin" => $_POST["fecha_fin_temporada"],
						   "precios" => $_POST["precios_temporada"],
						   "activo" => isset($_POST["activo_temporada"]) ? 1 : 0);

			$respuesta = ModeloPreciosTemporada::mdlEditarPrecioTemporada($tabla, $datos);
			
			error_log("Respuesta del modelo: " . $respuesta);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "¡La temporada ha sido actualizada correctamente!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "servicios";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	Eliminar precio de temporada
	=============================================*/

	static public function ctrEliminarPrecioTemporada(){

		if(isset($_GET["idPrecioTemporada"])){

			$tabla = "precios_temporada";
			$datos = $_GET["idPrecioTemporada"];

			$respuesta = ModeloPreciosTemporada::mdlEliminarPrecioTemporada($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "¡La temporada ha sido eliminada correctamente!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "servicios";

								}
							})

				</script>';

			}		

		}

	}

	/*=============================================
	Obtener precio de temporada por fecha
	=============================================*/

	static public function ctrObtenerPrecioTemporadaPorFecha($id_servicio, $fecha){

		$tabla = "precios_temporada";

		$respuesta = ModeloPreciosTemporada::mdlObtenerPrecioTemporadaPorFecha($tabla, $id_servicio, $fecha);

		return $respuesta;

	}

}
