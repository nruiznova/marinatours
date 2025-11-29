<?php

require_once "../controladores/banner.controlador.php";
require_once "../modelos/banner.modelo.php";

class TablaBanner{

	/*=============================================
	Tabla Banner
	=============================================*/ 

	public function mostrarTabla(){

		$banner = ControladorBanner::ctrMostrarBanner(null, null);

		if(count($banner)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($banner as $key => $value) {

	 		/*=============================================
			IMAGEN
			=============================================*/	

			if(strpos($value["img"], "mp4") === false){

				$imagen = "<img src='".$value["img"]."' class='img-fluid'>";

			}else{

				$imagen = "<video class='previsualizarVideo' loop muted autoplay style='width:100%;'><source src='".$value["img"]."' type='video/mp4'>Your browser does not support the video tag.</video>";

			}
			
			
			/*=============================================
			ACCIONES
			=============================================*/

			// if($permisos[2]["editar"] == true){

				// <button class='btn btn-danger btn-sm eliminarBanner' idBanner='".$value["id"]."' rutaBanner='".$value["img"]."'><i class='fas fa-trash-alt'></i></button>

				$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarBanner' data-toggle='modal' data-target='#editarBanner' idBanner='".$value["id"]."'><i class='fas fa-pencil-alt text-white'></i></button></div>";

			// }else{

			// 	$acciones = "";

			// }			

			$datosJson.= '[
							
						"'.($key+1).'",
						"'.$imagen.'",
						"'.$acciones.'"
						
				],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Banner
=============================================*/ 

$tabla = new TablaBanner();
$tabla -> mostrarTabla();

