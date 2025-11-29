<?php

class ControladorAdministradores{

	/*=============================================
	Ingreso Administradores
	=============================================*/

	public function ctrIngresoAdministradores(){ 

		if(isset($_POST["ingresoUsuario"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingresoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingresoPassword"])){

			   	$encriptarPassword = crypt($_POST["ingresoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			   	$tabla = "administradores";
			    $item = "usuario";
			    $valor = $_POST["ingresoUsuario"];

				$respuesta = ModeloAdministradores::mdlMostrarAdministradores($tabla, $item, $valor);
				
				if($respuesta["usuario"] == $_POST["ingresoUsuario"] && $respuesta["password"] == $encriptarPassword){

					if($respuesta["estado"] == 1){

						$_SESSION["validarSesionBackend"] = "ok";
				 		$_SESSION["idBackend"] = $respuesta["id"];
						$_SESSION["permisos"] = $respuesta["permisos"];

				 		echo '<script>

							window.location = "'.$_SERVER["REQUEST_URI"].'";

				 		</script>';

			 		}else{

			 			echo "<div class='alert alert-danger mt-3 small'>ERROR: El usuario está desactivado</div>";

			 		}

				}else{

					echo "<div class='alert alert-danger mt-3 small'>ERROR: Usuario y/o contraseña incorrectos</div>";
				}	

			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";

			}

		}

	}

	/*=============================================
	Mostrar Administradores
	=============================================*/

	static public function ctrMostrarAdministradores($item, $valor){

		$tabla = "administradores";

		$respuesta = ModeloAdministradores::mdlMostrarAdministradores($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	Registro de administrador
	=============================================*/

	public function ctrRegistroAdministrador(){

		if(isset($_POST["registroNombre"])){

			if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["registroNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["registroPassword"])){

			   	$encriptarPassword = crypt($_POST["registroPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "administradores";

				$datos = array("nombre" => $_POST["registroNombre"],
							   "usuario" =>  $_POST["registroUsuario"],
							   "password" => $encriptarPassword,
							   "perfil" => $_POST["registroPerfil"],
							   "permisos" => $_POST["listaPermisos"],
							   "estado" => 0);

				
				$respuesta = ModeloAdministradores::mdlRegistroAdministradores($tabla, $datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El administrador ha sido creado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    window.location = "administradores";
								  } 
						});

					</script>';

				}


			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
			}

		}


	}

	/*=============================================
	Editar administrador
	=============================================*/

	public function ctrEditarAdministrador(){

		if(isset($_POST["editarNombre"])){

			if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["editarNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarUsuario"])){

			   	if($_POST["editarPassword"] != ""){

			   		if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

			   			$password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');  			

			   		}else{

			   			echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";

			   			return;

			   		}

			   	}else{

			   		$password = $_POST["passwordActual"];
			   	}

				$tabla = "administradores";

				$datos = array("id"=> $_POST["editarId"],
							   "nombre" => $_POST["editarNombre"],
							   "usuario" =>  $_POST["editarUsuario"],
							   "password" => $password,
							   "permisos" => $_POST["listaPermisosEditar"],
							   "perfil" => $_POST["editarPerfil"]);
				
				$respuesta = ModeloAdministradores::mdlEditarAdministrador($tabla, $datos);
				
				if($respuesta == "ok"){

					echo'<script>

						swal({
								type:"success",
							  	title: "¡CORRECTO!",
							  	text: "El administrador ha sido editado correctamente",
							  	showConfirmButton: true,
								confirmButtonText: "Cerrar"
							  
						}).then(function(result){

								if(result.value){   
								    window.location = "administradores";
								  } 
						});

					</script>';

				}


			}else{

				echo "<div class='alert alert-danger mt-3 small'>ERROR: No se permiten caracteres especiales</div>";
			}

		}

	}

	/*=============================================
	Eliminar Administrador
	=============================================*/

	static public function ctrEliminarAdministrador($id){

		$tabla = "administradores";

		$respuesta = ModeloAdministradores::mdlEliminarAdministrador($tabla, $id);

		return $respuesta;

	}

	/*=============================================
	Editar galeria
	=============================================*/

	static public function ctrEditarGaleria($datos){

		$tabla = "galeria";

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

		$traerHabitacion = ModeloAdministradores::mdlMostrarAdministradores("galeria", "id_galeria", $datos["id_galeria"]);

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

				$directorio = "../vistas/img/galeria";	

				array_push($ruta, strtolower($directorio."/".$datos["nombre"].$aleatorio.".".$mime[1]));

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

		$datos["galeria"] = json_encode($guardarRuta);

		$respuesta = ModeloAdministradores::mdlEditarGaleria($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	Nueva seccion
	=============================================*/

	static public function ctrNuevaSeccion($data){

		$tabla = "galeria";

		$datos = array("nombre" => $data,
					   "galeria" => "[]");

		$respuesta = ModeloAdministradores::mdlNuevaSeccion($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	Eliminar galeria
	=============================================*/

	static public function ctrEliminarGaleria($id){

		$tabla = "galeria";

		// $datos = $data;

		$respuesta = ModeloAdministradores::mdlEliminarGaleria($tabla, $id);

		return $respuesta;

	}

}