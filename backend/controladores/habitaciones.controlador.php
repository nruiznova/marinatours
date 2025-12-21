<?php

class ControladorHabitaciones{

	/*=============================================
	MOSTRAR CATEGORIAS-HABITACIONES CON INNER JOIN
	=============================================*/

	static public function ctrMostrarHabitaciones($valor){

		$tabla1 = "categorias";
		$tabla2 = "habitaciones";

		$respuesta = ModeloHabitaciones::mdlMostrarHabitaciones($tabla1, $tabla2, $valor);

		return $respuesta;

	}

	/*=============================================
	Nueva habitación
	=============================================*/

	static public function ctrNuevaHabitacion($datos){

		// if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["estilo"]) && 
		//    preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descripcion"]) 
		//    && preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["banner"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["precio"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["caracteristicas"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["lugarSalida"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["horaSalida"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["incluye"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["noIncluye"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["recomendaciones"]) &&
		// 	preg_match('/^[\/\=\\&\\$\\;\\_\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["itinerario"])
		//    ){

			// Validar orden
			$tabla = "habitaciones";
			
			// Obtener total de servicios actuales
			$totalServicios = ModeloHabitaciones::mdlContarHabitaciones($tabla);
			$cantidadServicios = $totalServicios["total"];
			
			// El orden máximo permitido es cantidadServicios + 1 (el nuevo servicio)
			if(!isset($datos["orden"]) || $datos["orden"] == '' || $datos["orden"] > ($cantidadServicios + 1) || $datos["orden"] < 1){
				
				return "error_orden";
			}

			// Si el orden ya existe, mover los demás servicios
			$servicioConOrdenDeseado = ModeloHabitaciones::mdlObtenerHabitacionPorOrden($tabla, $datos["orden"]);
			
			if($servicioConOrdenDeseado){
				// Incrementar el orden de todos los servicios >= al orden deseado
				$conexion = Conexion::conectar();
				$stmt = $conexion->prepare("UPDATE $tabla SET orden = orden + 1 WHERE orden >= :orden");
				$stmt->bindParam(":orden", $datos["orden"], PDO::PARAM_INT);
				$stmt->execute();
			}

			// banner	
			
			$file = $datos["banner"];
			$pos = strpos($file, ';');
			$type = explode(':', substr($file, 0, $pos))[1];
			$mime = explode('/', $type);

			$aleatorio = mt_rand(100,999);

			$directorio = "../vistas/img/".$datos["tipo"]."/banner/";

			if (!file_exists($directorio)) {
				mkdir($directorio, 0777, true);
			}

			$pathImage = "../vistas/img/".$datos["tipo"]."/banner/".$aleatorio.".".$mime[1];			

			$file = substr($file, strpos($file, ',') + 1, strlen($file));
			$dataBase64 = base64_decode($file);
			file_put_contents($pathImage, $dataBase64);	
			
			if(file_put_contents($pathImage, $dataBase64)){

			}else{				

				echo'<script>

						swal({
								type:"error",
							  	title: "¡CORREGIR!",
							  	text: "¡Error al subir el banner hfcdfh",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    history.back();
								  } 
						});

				</script>';

				return;
			}

			// galeria

		   	if($datos["galeria"] != ""){

			   	$ruta = array();
			   	$guardarRuta = array();

				$galeria = json_decode($datos["galeria"], true);

				for($i = 0; $i < count($galeria); $i++){					

					list($ancho, $alto) = getimagesize($galeria[$i]);

					$nuevoAncho = $ancho;
					$nuevoAlto = $alto;

					// datos de la imagen

					$file = $galeria[$i];
					$pos = strpos($file, ';');
					$type = explode(':', substr($file, 0, $pos))[1];
					$mime = explode('/', $type);

					$file = substr($file, strpos($file, ',') + 1, strlen($file));
					$dataBase64 = base64_decode($file);

					/*=============================================
					Creamos el directorio donde vamos a guardar la imagen
					=============================================*/

					$directorio = "../vistas/img/".$datos["tipo"];	

					if (!file_exists($directorio)) {

						mkdir($directorio, 0755);

					}					

					array_push($ruta, strtolower($directorio."/".$datos["estilo"].($i+1).".jpg"));

					// $origen = imagecreatefromjpeg($galeria[$i]);

					// $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);	

					// imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					// imagejpeg($destino, $ruta[$i]);	
					
					file_put_contents($ruta[$i], $dataBase64);	

					array_push($guardarRuta, substr($ruta[$i], 3));

				}


			}else{

				echo'<script>

						swal({
								type:"error", 
							  	title: "¡CORREGIR!",
							  	text: "¡La galería no puede estar vacía",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    history.back();
								  } 
						});

				</script>';

				return;
			}			

			$tabla = "habitaciones";

			$datos = array("tipo_h" => $datos["tipo_h"],
							"estilo" => $datos["estilo"],
							"ruta" => $datos["ruta"],
							"galeria" => json_encode($guardarRuta),							
							"descripcion_h" => $datos["descripcion"],
							"banner" => $pathImage,
							"cupos" => $datos["cupos"],
							"serviciosEnlazados" => $datos["serviciosEnlazados"],
							"precio" => $datos["precio"],
							"caracteristicas" => $datos["caracteristicas"],
							"lugarSalida" => $datos["lugarSalida"],
							"horaSalida" => $datos["horaSalida"],
							"incluye" => $datos["incluye"],
							"noIncluye" => $datos["noIncluye"],
							"recomendaciones" => $datos["recomendaciones"],
							"itinerario" => $datos["itinerario"]
							);

			$respuesta = ModeloHabitaciones::mdlNuevaHabitacion($tabla, $datos);

			// actualizar servicios enlazados

			$lastId = ModeloHabitaciones::getLastId($tabla);

			$enlazados = explode(";", $datos["serviciosEnlazados"]);						

			foreach ($enlazados as $value) {

				$item1 = "cupos";
				$valor1 = $datos["cupos"];

				$enlazadosArr =  explode(";", $datos["serviciosEnlazados"]);

				array_push($enlazadosArr, strval($lastId["id_h"]));

				if (($key = array_search($value, $enlazadosArr)) !== false) {
					unset($enlazadosArr[$key]);
				}		
				
				//var_dump($enlazadosArr);

				$item2 = "id_h";				
				$valor2 = $value;				

				$actualizarCupos = ModeloHabitaciones::mdlActualizarHabitacion($tabla, $item1, $valor1, $item2, $valor2);

				$item3 = "serviciosEnlazados";				
				$valor3 = implode(";", $enlazadosArr);								

				$actualizarServicios = ModeloHabitaciones::mdlActualizarHabitacion($tabla, $item3, $valor3, $item2, $valor2);

			}

			return $respuesta; 

		// }else{

		// 	echo '<script>

		// 			swal({

		// 				type:"error",
		// 				title: "¡CORREGIR!",
		// 				text: "¡No se permiten caracteres especiales en ninguno de los campos!",
		// 				showConfirmButton: true,
		// 				confirmButtonText: "Cerrar"

		// 			}).then(function(result){

		// 				if(result.value){

		// 					history.back();

		// 				}

		// 			});	

		// 		</script>';
		// }

	}

	/*=============================================
	Editar habitación
	=============================================*/

	static public function ctrEditarHabitacion($datos){

		// if(preg_match('/^[-\\_\\a-zA-Z0-9]+$/', $datos["estilo"]) && 
		//    preg_match('/^[\/\=\\&\\$\\;\\_\\-\\|\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descripcion"])){
		   	
			// banner

			if($datos["banner"] != ''){

				$file = $datos["banner"];
				$pos = strpos($file, ';');
				$type = explode(':', substr($file, 0, $pos))[1];
				$mime = explode('/', $type);				

				$aleatorio = mt_rand(100,999);

				$pathImage = "../vistas/img/".$datos["tipo"]."/banner/".$aleatorio.".".$mime[1];

				$files = glob('../vistas/img/'.$datos["tipo"].'/banner/*'); // get all file names
                foreach($files as $item){ // iterate files
                  if(is_file($item)) {
                    unlink($item); // delete file
                  }
                }

				$file = substr($file, strpos($file, ',') + 1, strlen($file));
				$dataBase64 = base64_decode($file);
				file_put_contents($pathImage, $dataBase64);	
				
				if(file_put_contents($pathImage, $dataBase64)){

				}else{

					// var_dump(file_exists($pathImage));

					echo'<script>

							swal({
									type:"error",
									title: "¡CORREGIR!",
									text: "¡Error al subir el banner",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
								
							}).then(function(result){

									if(result.value){   
										history.back();
									} 
							});

					</script>';

					return;
				}

			}else{

				$habitacion = ControladorHabitaciones::ctrMostrarhabitaciones($datos["idHabitacion"]);
				$pathImage = $habitacion["banner"];

			}

			//Validamos que la galería no venga vacía

		   	if($datos["galeriaAntigua"] == "" && $datos["galeria"] == ""){

				echo'<script>

						swal({
								type:"error",
							  	title: "¡CORREGIR!",
							  	text: "¡La galería no puede estar vacía",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    history.back();
								  } 
						});

				</script>';

				return;
			}

			//Eliminar las fotos de la galería de la carpeta

			$traerHabitacion = ModeloHabitaciones::mdlMostrarHabitaciones("categorias", "habitaciones", $datos["idHabitacion"]);

			if($datos["galeriaAntigua"] != ""){	

				$galeriaBD = json_decode($traerHabitacion["galeria"], true);

				$galeriaAntigua = explode("," , $datos["galeriaAntigua"]);

				$guardarRuta = $galeriaAntigua;
		
				$borrarFoto = array_diff($galeriaBD, $galeriaAntigua);

				foreach ($borrarFoto as $key => $valueFoto){
						
					unlink("../".$valueFoto);

				}

			}else{


				$galeriaBD = json_decode($traerHabitacion["galeria"], true);

				foreach ($galeriaBD as $key => $valueFoto){

					unlink("../".$valueFoto);

				}

				
			}
		   	
		   	// Cuando vienen fotos nuevas

		   	if($datos["galeria"] != ""){

			   	$ruta = array();
			   	$guardarRuta = array();

				$galeria = json_decode($datos["galeria"], true);
				$galeriaAntigua = explode("," , $datos["galeriaAntigua"]);

				for($i = 0; $i < count($galeria); $i++){

					list($ancho, $alto) = getimagesize($galeria[$i]);

					$nuevoAncho = $ancho;
					$nuevoAlto = $alto;

					$aleatorio = mt_rand(100,999); 

					// datos de la imagen

					$file = $galeria[$i];
					$pos = strpos($file, ';');
					$type = explode(':', substr($file, 0, $pos))[1];
					$mime = explode('/', $type);

					$file = substr($file, strpos($file, ',') + 1, strlen($file));
					$dataBase64 = base64_decode($file);

					/*=============================================
					Creamos el directorio donde vamos a guardar la imagen
					=============================================*/

					$directorio = "../vistas/img/".$datos["tipo"];	

					if (!file_exists($directorio)) {
						mkdir($directorio, 0777, true);
					}

					array_push($ruta, strtolower($directorio."/".$datos["estilo"].$aleatorio.".".$mime[1]));

					// $origen = imagecreatefromjpeg($galeria[$i]); 

					// $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);	

					// imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					// imagejpeg($destino, $ruta[$i]);	

					file_put_contents($ruta[$i], $dataBase64);	

					array_push($guardarRuta, substr($ruta[$i], 3));

				}

				// Agregamos las fotos antiguas

				if($datos["galeriaAntigua"] != ""){

					foreach ($galeriaAntigua as $key => $value) {
						
						array_push($guardarRuta, $value);
					}

				}

			}			

			$tabla = "habitaciones";

			// Validar y manejar el intercambio de órdenes ANTES de guardar
			// Obtener total de servicios
			$totalServicios = ModeloHabitaciones::mdlContarHabitaciones($tabla);
			$cantidadServicios = $totalServicios["total"];
			
			// Validar que el orden no sea mayor a la cantidad de servicios ni menor a 1
			if(!isset($datos["orden"]) || $datos["orden"] == '' || $datos["orden"] > $cantidadServicios || $datos["orden"] < 1){
				
				return "error_orden";
			}

			// Obtener el orden actual de este servicio
			$ordenActual = ModeloHabitaciones::mdlObtenerOrdenActual($tabla, $datos["idHabitacion"]);
			
			// Si el orden cambió y ya existe otro servicio con ese orden
			if($ordenActual && $ordenActual["orden"] != $datos["orden"]){
				
				// Buscar si hay otro servicio con el orden que queremos asignar
				$servicioConOrdenDeseado = ModeloHabitaciones::mdlObtenerHabitacionPorOrden($tabla, $datos["orden"]);
				
				// Si existe otro servicio con ese orden, intercambiar
				if($servicioConOrdenDeseado && $servicioConOrdenDeseado["id_h"] != $datos["idHabitacion"]){
					
					// Asignar el orden actual al otro servicio
					ModeloHabitaciones::mdlActualizarHabitacion($tabla, "orden", $ordenActual["orden"], "id_h", $servicioConOrdenDeseado["id_h"]);
					
				}
			}

			$datos = array( "id_h" => $datos["idHabitacion"],
							"tipo_h" => $datos["tipo_h"],
							"estilo" => $datos["estilo"],
							"ruta" => $datos["ruta"],
							"galeria" => json_encode($guardarRuta),				 			
							"descripcion_h" => $datos["descripcion"],
							"banner" => $pathImage,
							"cupos" => $datos["cupos"],
							"orden" => $datos["orden"],
							"serviciosEnlazados" => $datos["serviciosEnlazados"],
							"precio" => $datos["precio"],
							"caracteristicas" => $datos["caracteristicas"],
							"lugarSalida" => $datos["lugarSalida"],
							"horaSalida" => $datos["horaSalida"],
							"incluye" => $datos["incluye"],
							"noIncluye" => $datos["noIncluye"],
							"recomendaciones" => $datos["recomendaciones"],
							"itinerario" => $datos["itinerario"]
							);

			$respuesta = ModeloHabitaciones::mdlEditarHabitacion($tabla, $datos);

			// recorrer todos los servicios y actualizar los enlazados y los cupos

			$enlazados = explode(";", $datos["serviciosEnlazados"]);

			// actualizar cupos disponibles de servicios relacionados

			foreach ($enlazados as $value) {
				
				$actualizarCupos = ModeloHabitaciones::mdlActualizarHabitacion($tabla, "cupos", $datos["cupos"], "id_h", $value);

			}

			// actualizar servicios relacionados			

			foreach ($enlazados as $value) {
				
				$info = ModeloHabitaciones::mdlMostrarHabitaciones("categorias", $tabla, $value);

				if(isset($info["serviciosEnlazados"])){

					$serviciosActuales = explode(";", $info["serviciosEnlazados"]);				

					// enlazar el enlzado con el actual

					if (($key = array_search($datos["id_h"], $serviciosActuales)) !== false) {					
					}else{
						array_push($serviciosActuales, $datos["id_h"]);
					}

					$actualizarServicios = ModeloHabitaciones::mdlActualizarHabitacion($tabla, "serviciosEnlazados", implode(";", $serviciosActuales), "id_h", $value);

				}				

			}

			return $respuesta; 

		// }else{

		// 	echo '<script>

		// 			swal({

		// 				type:"error",
		// 				title: "¡CORREGIR!",
		// 				text: "¡No se permiten caracteres especiales en ninguno de los campos!",
		// 				showConfirmButton: true,
		// 				confirmButtonText: "Cerrar"

		// 			}).then(function(result){

		// 				if(result.value){

		// 					history.back();

		// 				}

		// 			});	

		// 		</script>';
		// }


	}

	/*=============================================
	Eliminar Habitación
	=============================================*/

	static public function ctrEliminarHabitacion($datos){
		
		// Eliminamos fotos de la galería

		$galeriaHabitacion = explode("," , $datos["galeriaHabitacion"]);

		foreach ($galeriaHabitacion as $key => $value) {
			
			unlink("../".$value);
		
		}

		// Eliminamos imagen 360°

		// unlink("../".$datos["recorridoHabitacion"]);	

		$tabla = "habitaciones";

		$respuesta = ModeloHabitaciones::mdlEliminarHabitacion($tabla, $datos["idEliminar"]);

		return $respuesta;

	}


}