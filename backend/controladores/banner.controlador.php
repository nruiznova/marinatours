<?php

class ControladorBanner{

	/*=============================================
	Mostrar Banner
	=============================================*/

	static public function ctrMostrarBanner($item, $valor){

		$tabla = "banner";

		$respuesta = ModeloBanner::mdlMostrarBanner($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	Registro de Banner
	=============================================*/

	public function ctrRegistroBanner(){

		// $directorio = "vistas/img/banner";

		if(isset($_FILES["subirBanner"]["tmp_name"]) && !empty($_FILES["subirBanner"]["tmp_name"])){ 

			$file = $_FILES["subirBanner"]["tmp_name"];
			$pos = strpos($file, ';');
			$type = explode(':', substr($file, 0, $pos))[1];
			$mime = explode('/', $type);

			$aleatorio = mt_rand(100,999);

			$pathImage = "vistas/img/banner/".$aleatorio.".".$mime[1];			

			$file = substr($file, strpos($file, ',') + 1, strlen($file));
			$dataBase64 = base64_decode($file);
			file_put_contents($pathImage, $dataBase64);	
			
			if(file_put_contents($pathImage, $dataBase64)){

			}else{				

				echo'<script>

					swal({
							type:"error",
						  	title: "¡CORREGIR!",
						  	text: "¡No se permiten formatos diferentes a JPG y/o PNG!",
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

			$tabla = "banner";

			$respuesta = ModeloBanner::mdlRegistroBanner($tabla, $pathImage);

			if($respuesta == "ok"){

				echo '<script>

					swal({
						type:"success",
					  	title: "¡CORRECTO!",
					  	text: "¡La imagen del banner ha sido creada exitosamente!",
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
	Editar Banner
	=============================================*/

	public function ctrEditarBanner(){

		if(isset($_POST["idBanner"])){
			
			if(isset($_FILES["editarBanner"]["tmp_name"]) && !empty($_FILES["editarBanner"]["tmp_name"])){				

				$file = $_POST["newBanner"];
				$pos = strpos($file, ';');
				$type = explode(':', substr($file, 0, $pos))[1];
				$mime = explode('/', $type);

				$aleatorio = mt_rand(100,999);

				$pathImage = "vistas/img/banner/".$aleatorio.".".$mime[1];	 	

				$file = substr($file, strpos($file, ',') + 1, strlen($file));
				$dataBase64 = base64_decode($file);
				file_put_contents($pathImage, $dataBase64);	
				
				if(file_put_contents($pathImage, $dataBase64)){

				}else{	

					echo'<script>

						swal({
								type:"error",
							  	title: "¡CORREGIR!",
							  	text: "¡No se permiten formatos diferentes a JPG y/o PNG!",
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

				$tabla = "banner";
				$id = $_POST["idBanner"];

				$respuesta = ModeloBanner::mdlEditarBanner($tabla, $id, $pathImage);

				if($respuesta == "ok"){

					echo '<script>

						swal({
							type:"success",
						  	title: "¡CORRECTO!",
						  	text: "¡La imagen del banner ha sido actualizada!",
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

	}

	/*=============================================
	Eliminar Banner
	=============================================*/

	static public function ctrEliminarBanner($id, $ruta){
		
		unlink("../".$ruta);

		$tabla = "banner";

		$respuesta = ModeloBanner::mdlEliminarBanner($tabla, $id);

		return $respuesta;

	}

}