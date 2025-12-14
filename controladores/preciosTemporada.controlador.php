<?php

class ControladorPreciosTemporada{

	/*=============================================
	Obtener precios considerando temporada
	=============================================*/

	static public function ctrObtenerPreciosConTemporada($id_servicio, $fecha_reserva, $precios_base){

		// Si no hay fecha, retornar precios base
		if(empty($fecha_reserva)){
			return $precios_base;
		}

		$tabla = "precios_temporada";

		// Buscar precio de temporada activo para esta fecha
		$temporada = ModeloPreciosTemporada::mdlObtenerPrecioTemporadaPorFecha($tabla, $id_servicio, $fecha_reserva);

		// Si hay temporada activa, usar esos precios
		if($temporada && !empty($temporada["precios"])){
			return json_decode($temporada["precios"], true);
		}

		// Si no hay temporada, retornar precios base
		return $precios_base;

	}

	/*=============================================
	Obtener precio de servicio para un tipo de usuario (considerando temporadas)
	=============================================*/

	static public function ctrObtenerPrecioUsuario($id_servicio, $tipo_usuario = null, $fecha = null){

		// Si no se proporciona fecha, usar fecha actual
		if($fecha == null){
			$fecha = date('Y-m-d');
		}

		// Obtener el servicio
		$habitacion = ControladorHabitaciones::ctrMostrarHabitaciones("id_h", $id_servicio);
		
		if(!$habitacion){
			return null;
		}

		// Obtener precios base del servicio
		$precios_base = json_decode($habitacion["precio"], true);

		// Determinar el tipo de usuario
		if($tipo_usuario == null){
			if(isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok"){
				$tipo_usuario = $_SESSION["nombre"];
			}else{
				$tipo_usuario = "Público en general";
			}
		}

		// Obtener precios considerando temporada
		$precios = self::ctrObtenerPreciosConTemporada($id_servicio, $fecha, $precios_base);

		// Buscar precio para el tipo de usuario
		$resultado = [
			"precio" => 0,
			"precioKids" => 0,
			"visibilidad" => false,
			"temporada" => false,
			"nombre_temporada" => null
		];

		foreach ($precios as $item) {
			if($item["usuario"] == $tipo_usuario){
				if($item["visibilidad"] == "true"){
					$resultado["precio"] = $item["precio"];
					$resultado["precioKids"] = isset($item["precioKids"]) ? $item["precioKids"] : 0;
					$resultado["visibilidad"] = true;
					
					// Verificar si es precio de temporada
					if($precios !== $precios_base){
						$tabla = "precios_temporada";
						$temporada = ModeloPreciosTemporada::mdlObtenerPrecioTemporadaPorFecha($tabla, $id_servicio, $fecha);
						if($temporada){
							$resultado["temporada"] = true;
							$resultado["nombre_temporada"] = $temporada["nombre_temporada"];
						}
					}
				}
				break;
			}
		}

		return $resultado;

	}

}
