<?php

require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";

require_once "../controladores/habitaciones.controlador.php";
require_once "../controladores/ruta.controlador.php";
require_once "../modelos/habitaciones.modelo.php";

class TablaReservas{

	/*=============================================
	Tabla Reservas
	=============================================*/ 

	public function mostrarTabla(){

		// var_dump($_GET);

		if($_GET["item"] == 'fecha_ingreso'){

			$valor = date("Y-m-d", strtotime($_GET["valor"])); 

		}else{

			$valor = $_GET["valor"];

		}

		if($_GET["item"] == "all"){

			$reservas = ControladorReservas::ctrMostrarReservas(null, null); 

		}else{

			$reservas = ControladorReservas::ctrMostrarReservas($_GET["item"], $valor); 

		}

		if(count($reservas)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ '; 

	 	foreach ($reservas as $key => $value) {					
			
			$guests = json_decode($value["guests"], true);			

			foreach ($guests as $g => $gue) {

                $tipo = '';

				if(isset($gue["tipo"])){

					if($gue["tipo"] == 'kid'){
						$tipo = "Niño";
					}else{
						$tipo = "Adulto";
					}

				}

				if(isset($gue["nacionalidad"])){

					$nac = $gue["nacionalidad"];

				}else{

					$nac = '';

				}
				
				if(isset($gue["asiento"])){

					$asiento = $gue["asiento"];

				}else{

					$asiento = '';

				}

				if(isset($gue["nombre"])){

					$nombre = $gue["nombre"];
					$tipo_documento = $gue["tipo_documento"];
					$documento = $gue["documento"];

				}else{

					$nombre = '';
					$tipo_documento = '';
					$documento = '';

				}

				$estado = '';

				if($value["estado"] == 1){

					$estado = "<span class='badge badge-success'>Presente</span>";	
	
				}else if($value["estado"] == 2){
	
					$estado = "<span class='badge badge-warning'>Anulada</span>";	
	
				}else if($value["estado"] == 3){
	
					$estado = "<span class='badge badge-dark'>Cancelada</span>";
	
				}

                $datosJson.= '[
													
                        "'.$value["codigo_reserva"].'",
                        "'.$nombre.'",
                        "'.$tipo_documento.'",                
                        "'.$documento.'",  
                        "'.$tipo.'",
						"'.$asiento.'",
						"'.$nac.'",
						"'.$estado.'"
                        
                ],';				
                
			}						

		}

		$datosJson = substr($datosJson, 0, -1);
 
		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Reservas
=============================================*/ 

$tabla = new TablaReservas();
$tabla -> mostrarTabla();
