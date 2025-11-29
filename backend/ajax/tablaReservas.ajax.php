<?php

require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";
require_once "../modelos/categorias.modelo.php";

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

			$item = 'fecha_salida';

			$valor = date("Y-m-d", strtotime($_GET["valor"])); 

		}else{

			$item = $_GET["item"];

			$valor = $_GET["valor"];

		}

		if($_GET["item"] == "all"){

			// $item = $_GET["item"];

			$reservas = ControladorReservas::ctrMostrarReservas(null, null); 

		}else{

			// $item = $_GET["item"];

			$reservas = ControladorReservas::ctrMostrarReservas($item, $valor); 

		}

		if(count($reservas)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ '; 

	 	foreach ($reservas as $key => $value) {
			
			/*=============================================
			ACCIONES
			=============================================*/			

			$info_habitacion = ControladorHabitaciones::ctrMostrarHabitaciones($value["id_habitacion"]);

			$desc = $value["descripcion_reserva"];

			$descArr = explode("-", $desc);

			$personasArr = explode(" ", $descArr[1]);

			$galeria = json_decode($info_habitacion["galeria"], true);

			$imgHabitacion = ControladorRuta::ctrRutaBackend().$galeria[0];
			$infoHabitacion = $value["descripcion_reserva"];
			$pagoReserva = $value["pago_reserva"];
			$pagoActual = "";
			$codigoReserva = $value["codigo_reserva"];
			$fecha = $value["fecha_ingreso"];
			$plan = "";
			$personas = $personasArr[1];
			$firstName = $value["firstName"];
			$lastName = $value["lastName"];
			$tipo_identificacion = $value["tipo_identificacion"];
			$numero_identificacion = $value["numero_identificacion"];
			$celular = $value["celular"];
			$correo = $value["correo"];
			$hospedaje = $value["hospedaje"];
			$abono = $value["abono"];
			$cuotas = $value["cuotas"];
			$montoPagar = $value["montoPagar"];
			$valorCuotas = $value["valorCuotas"];
			$pagoCuotas = $value["pagoCuotas"];

			$estado = '';

			if($value["fecha_ingreso"] != "0000-00-00" && $value["fecha_salida"] != "0000-00-00" && $value["fecha_ingreso"] != null){

				$fechaIngreso = new DateTime($value["fecha_ingreso"]);
				$fechaSalida = new DateTime($value["fecha_salida"]);
				$diff = $fechaIngreso->diff($fechaSalida);
				$dias = $diff->days; 

				if($value["abono"] == "total"){

					$button_eliminar = "<button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown'><i class='fas fa-undo'></i> <b class='ml-2 mr-2'>/</b> <i class='fas fa-times'></i></button> <ul class='dropdown-menu'><li class='dropdown-item eliminarReserva' idReserva='".$value["id_reserva"]."'><a href='#'>Devolver</a></li><li class='dropdown-item anularReserva' idReserva='".$value["id_reserva"]."'><a href='#'>Anular</a></li></ul>";

					// <button class='btn btn-danger btn-sm eliminarReserva' idReserva='".$value["id_reserva"]."'><i class='p-1 fas fa-trash-alt'></i></button>

					$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarReserva' personas='".$personas."' ruta='".$info_habitacion["ruta"]."' data-toggle='modal' data-target='#editarReserva' idReserva='".$value["id_reserva"]."' idHabitacion='".$value["id_habitacion"]."' fechaIngreso='".date("d-m-Y", strtotime($value["fecha_ingreso"]))."' fechaSalida='".date("d-m-Y", strtotime($value["fecha_ingreso"]))."' descripcion='".$value["descripcion_reserva"]."' diasReserva='".$dias."'><i class='p-1 fas fa-pencil-alt text-white'></i></button>".$button_eliminar."</div>";	

				}else{ 

					$button_eliminar = "<button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown'><i class='fas fa-undo'></i> <b class='ml-2 mr-2'>/</b> <i class='fas fa-times'></i></button> <ul class='dropdown-menu'><li class='dropdown-item eliminarReserva' idReserva='".$value["id_reserva"]."'><a href='#'>Devolver</a></li><li class='dropdown-item anularReserva' idReserva='".$value["id_reserva"]."'><a href='#'>Anular</a></li></ul>";

					// <button class='btn btn-danger btn-sm eliminarReserva' idReserva='".$value["id_reserva"]."'><i class='p-1 fas fa-trash-alt'></i></button>

					$acciones = "<div class='btn-group'><button type='button' data-toggle='modal' data-target='#registrarPago' class='btn btn-secondary btnPagoReserva' idReserva='".$value["id_reserva"]."' idHabitacion='".$value["id_habitacion"]."' data='".ControladorRuta::ctrRuta()."index.php?addPayment=true&idHabitacion=".$info_habitacion["id"]."&imgHabitacion=".$imgHabitacion."&infoHabitacion=".$infoHabitacion."&pagoReserva=".$pagoReserva."&pagoActual=".$pagoActual."&idReserva=".$value["id_reserva"]."&codigoReserva=".$codigoReserva."&fechaIngreso=".$fecha."&fechaSalida=".$fecha."&plan=".$plan."&personas=".$personas."&firstName=".$firstName."&lastName=".$lastName."&tipo_identificacion=".$tipo_identificacion."&numero_identificacion=".$numero_identificacion."&celular=".$celular."&correo=".$correo."&hospedaje=".$hospedaje."&abono=".$abono."&cuotas=".$cuotas."&montoPagar=".$montoPagar."&valorCuotas=".$valorCuotas."&pagoCuotas=".$pagoCuotas."'><i class='fas fa-receipt'></i></button><button class='btn btn-warning btn-sm editarReserva' personas='".$personas."' ruta='".$info_habitacion["ruta"]."' data-toggle='modal' data-target='#editarReserva' idReserva='".$value["id_reserva"]."' idHabitacion='".$value["id_habitacion"]."' fechaIngreso='".date("d-m-Y", strtotime($value["fecha_ingreso"]))."' fechaSalida='".date("d-m-Y", strtotime($value["fecha_ingreso"]))."' descripcion='".$value["descripcion_reserva"]."' diasReserva='".$dias."'><i class='p-1 fas fa-pencil-alt text-white'></i></button>".$button_eliminar."</div>";	

				}
				
			}else{

				$acciones = "";					

			}

			if($value["estado"] == 1){

				$estado = "<span class='badge badge-success'>Presente</span>";	

			}else if($value["estado"] == 2){

				$estado = "<span class='badge badge-warning desmarcarEstado' fecha='".$value["fecha_salida"]."' idReserva='".$value["id_reserva"]."'>Anulada</span>";	

			}else if($value["estado"] == 3){

				$estado = "<span class='badge badge-dark desmarcarEstado' fecha='".$value["fecha_salida"]."' idReserva='".$value["id_reserva"]."'>Devolución</span>";

			}
			
			if($value["fecha_ingreso"] < date("Y-m-d") && $value["estado"] == '' || $value["fecha_ingreso"] < date("Y-m-d") && $value["estado"] == 0){
			        
			     $estado = "<span class='badge badge-warning desmarcarEstado' fecha='".$value["fecha_salida"]."' idReserva='".$value["id_reserva"]."'>Anulada</span>";
			    
			}

			$pagos =  ControladorReservas::ctrMostrarPagos("id_reserva", $value["id_reserva"]);	

			if($value["abono"] == "total"){

				$saldo = "<span class='badge badge-success'>Pagada</span>";

			}else{

				$pagado = 0;	
				
				if($value["abono"] == "abono"){

					$pagado += $value["pago_reserva"] / 2;

				}

				if($value["montoPagar"] != ''){

					$pagado = $value["montoPagar"];
					$pagado_metodo_6 = $value["montoPagar"];

				}else{

					$pagado_metodo_6 = 0;

				}
			
				foreach ($pagos as $row => $item) {
					
					$pagado += $item["monto"];

				}

				$saldo_p = $value["pago_reserva"] - $pagado;

				$saldo = "<span class='badge badge-danger'>$ ".number_format($saldo_p)."</span>";

			}			

			$cliente = $value["firstName"]." ".$value["lastName"];		
			
			$guests = json_decode($value["guests"], true);

			$adultos = 0;

			$niños = 0;

			foreach ($guests as $g => $gue) {

				if(isset($gue["tipo"])){

					if($gue["tipo"] == "adulto"){
						$adultos++;
					}else{
						$niños++;
					}

				}								

			}

			// "'.($key+1).'", 

			// vendedor

			if($value["id_usuario"] == "undefined"){

				$vendedor = "Público en general";

			}else{

				$vendedor = $value["id_usuario"];

			}

			$medio_pago = "";
			$pagado_metodo_1 = 0;
			$pagado_metodo_2 = 0;
			$pagado_metodo_3 = 0;
			$pagado_metodo_4 = 0;
			$pagado_metodo_5 = 0;			
			$pagado_metodo_7 = 0;
			$pagado_metodo_8 = 0;

			// listar pagos

			if($value["abono"] == "total"){

				$medio_pago = "Mercadopago";
				$pagado_metodo_6 = $value["pago_reserva"];

			}else if($value["abono"] == "abono"){

				$medio_pago = "Mercadopago";
				$pagado_metodo_6 = $value["pago_reserva"] / 2;

			}else if($value["abono"] == "credito"){

				$medio_pago = "Pago a crédito";

			}

			// buscar los pagos y listarlos

			$pagos = ControladorReservas::ctrMostrarPagos("id_reserva", $value["id_reserva"]);

			// recorrer los metodos de pago y listarlos

			foreach ($pagos as $p => $pay) {
				
				if($pay["metodo_pago"] == "Bancolombia"){

					$pagado_metodo_1 += $pay["monto"];

				}else if($pay["metodo_pago"] == "Efectivo"){

					$pagado_metodo_2 += $pay["monto"];

				}else if($pay["metodo_pago"] == "Davivienda"){

					$pagado_metodo_3 += $pay["monto"];

				}else if($pay["metodo_pago"] == "Nequi"){

					$pagado_metodo_4 += $pay["monto"];

				}else if($pay["metodo_pago"] == "Daviplata"){

					$pagado_metodo_5 += $pay["monto"];

				}else if($pay["metodo_pago"] == "Mercadopago"){

					$pagado_metodo_6 += $pay["monto"];

				}else if($pay["metodo_pago"] == "Payu"){

					$pagado_metodo_7 += $pay["monto"];

				}
				else if($pay["metodo_pago"] == "PSE"){

					$pagado_metodo_8 += $pay["monto"];
					$pagado_metodo_6 = 0; // esto por que se esta llenado la casilla de mercado pago tambien

				}

			}

			// "'.$medio_pago.'",

			$fechas_bloqueadas = ModeloCategorias::mdlMostrarCategorias("fechas_bloqueadas", null, null);

			foreach ($fechas_bloqueadas as $f => $bloq) {
				
				if($value["fecha_ingreso"] >= $bloq["fecha_inicial"] && $value["fecha_ingreso"] <= $bloq["fecha_final"]){

					$acciones = '';

				}else{

					$acciones = $acciones;

				}

			}

			if($value["fecha_ingreso"] == null || $value["fecha_ingreso"] == "0000-00-00"){

				$fechaIng = date("d-m-Y", strtotime($value["fecha_salida"]));

			}else{
				$fechaIng = date("d-m-Y", strtotime($value["fecha_ingreso"]));
			}

			$datosJson.= '[
								
						"'.$acciones.'",
						"'.$estado.'",	
						"'.$value["hospedaje"].'",
						"'.$cliente.'",
						"'.$value["celular"].'",
						"'.$adultos.'",
						"'.$niños.'",
						"$ '.number_format($value["pago_reserva"]).'",
						"'.$saldo.'",						
						"'.$descArr[0].'",
						"'.$vendedor.'",						
						"'.$value["codigo_reserva"].'",
						"'.$fechaIng.'",
						"$ '.number_format($pagado_metodo_1).'",
						"$ '.number_format($pagado_metodo_2).'",
						"$ '.number_format($pagado_metodo_3).'",
						"$ '.number_format($pagado_metodo_4).'",
						"$ '.number_format($pagado_metodo_5).'",
						"$ '.number_format($pagado_metodo_6).'",
						"$ '.number_format($pagado_metodo_7).'",
						"$ '.number_format($pagado_metodo_8).'"
																
				],';

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
