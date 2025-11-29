<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../controladores/ruta.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaUsuarios{

	/*=============================================
	Tabla Categorías
	=============================================*/ 

	public function mostrarTabla(){

		$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);

		if(count($usuarios)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($usuarios as $key => $value) {

	 		/*=============================================
			IMAGEN
			=============================================*/	
			if($value["foto"] != ""){

				$foto = "<img src='".$value["foto"]."' class='rounded-circle' width='50px'>";

			}else{

				$foto = "<img src='vistas/img/usuarios/default/default.png' class='rounded-circle' width='50px'>";
			}

			/*=============================================
			CANTIDAD DE RESERVAS
			=============================================*/	

			$reservas = "<div class='sumarReservas' idUsuario='".$value["id_u"]."'>0</div>";
			$testimonios = "<div class='sumarTestimonios' idUsuario='".$value["id_u"]."'>0</div>";

			// "'.($key+1).'",		
			// "'.$foto.'",
			// "'.$value["nombre"].'",
			// "'.$reservas.'",
			// "'.$testimonios.'"

			$acciones = "<button type='button' class='btn btn-info btnCopyLink'  data='".ControladorRuta::ctrRuta()."index.php?user_access=".$value["password"]."'><i class='fas fa-copy'></i></button> <button type='button' class='btn btn-danger btnDeleteUser' idUser='".$value["id_u"]."'><i class='fas fa-trash'></i></button>";

			if($value["nombre"] == "Público en general"){

				$acciones = "<button type='button' class='btn btn-info btnCopyLink'  data='".ControladorRuta::ctrRuta()."index.php?user_access=".$value["password"]."'><i class='fas fa-copy'></i></button>";

			}
			
			$datosJson.= '[																	
						"'.$value["nombre"].'",	
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
Tabla Usuarios
=============================================*/ 

$tabla = new TablaUsuarios();
$tabla -> mostrarTabla();

