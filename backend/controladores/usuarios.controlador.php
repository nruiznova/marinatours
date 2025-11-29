<?php

class ControladorUsuarios{


	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR USUARIOS
	=============================================*/

	static public function ctrCrearUsuario(){

		if(isset($_POST["nombreUsuarioModal"])){

			// if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["nombreUsuarioModal"])  ){

			   	$enlace = md5(uniqid($$_POST["nombreUsuarioModal"], true));

				$tabla = "usuarios";

				$datos = array("nombre" => $_POST["nombreUsuarioModal"],
							   "password" =>  $enlace,
							   "email" => $enlace);

				
				$respuesta = ModeloUsuarios::mdlCrearUsuario($tabla, $datos);						

				if($respuesta == "ok"){

					echo'<script>

						swal({
								type:"success",
									title: "¡CORRECTO!",
									text: "El usuario ha sido creado correctamente",
									showConfirmButton: true,
								confirmButtonText: "Cerrar"
								
						}).then(function(result){

								if(result.value){   
									window.location = "usuarios";
									} 
						});

					</script>';

				}				

			// }

		}

	}

	/*=============================================
	ELIMINAR USUARIOS
	=============================================*/

	static public function ctrBorrarUsuario($id){			

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlEliminarUsuarios($tabla, $id);

		return $respuesta;

	}

} 