<?php

require_once "conexion.php";

class ModeloHabitaciones{

	/*=============================================
	MOSTRAR CATEGORIAS-HABITACIONES CON INNER JOIN
	=============================================*/

	static public function mdlMostrarHabitaciones($tabla1, $tabla2, $valor){

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id = $tabla2.tipo_h WHERE id_h = :id_h");

			$stmt -> bindParam(":id_h", $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id = $tabla2.tipo_h ORDER BY $tabla2.id_h DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Nueva habitación
	=============================================*/

	static public function mdlNuevaHabitacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(tipo_h, estilo, ruta, galeria, banner, cupos, serviciosEnlazados, precio, caracteristicas, lugarSalida, horaSalida, incluye, noIncluye, recomendaciones, itinerario, descripcion_h) VALUES (:tipo_h, :estilo, :ruta, :galeria, :banner, :cupos, :serviciosEnlazados, :precio, :caracteristicas, :lugarSalida, :horaSalida, :incluye, :noIncluye, :recomendaciones, :itinerario, :descripcion_h)");

		$stmt->bindParam(":tipo_h", $datos["tipo_h"], PDO::PARAM_STR);
		$stmt->bindParam(":estilo", $datos["estilo"], PDO::PARAM_STR);
		$stmt->bindParam(":ruta", $datos["ruta"], PDO::PARAM_STR);
		$stmt->bindParam(":galeria", $datos["galeria"], PDO::PARAM_STR);		
		$stmt->bindParam(":descripcion_h", $datos["descripcion_h"], PDO::PARAM_STR);
		$stmt->bindParam(":banner", $datos["banner"], PDO::PARAM_STR);
		$stmt->bindParam(":cupos", $datos["cupos"], PDO::PARAM_STR);
		$stmt->bindParam(":serviciosEnlazados", $datos["serviciosEnlazados"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":caracteristicas", $datos["caracteristicas"], PDO::PARAM_STR);
		$stmt->bindParam(":lugarSalida", $datos["lugarSalida"], PDO::PARAM_STR);
		$stmt->bindParam(":horaSalida", $datos["horaSalida"], PDO::PARAM_STR);
		$stmt->bindParam(":incluye", $datos["incluye"], PDO::PARAM_STR);
		$stmt->bindParam(":noIncluye", $datos["noIncluye"], PDO::PARAM_STR);
		$stmt->bindParam(":recomendaciones", $datos["recomendaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":itinerario", $datos["itinerario"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	Editar habitación
	=============================================*/

	static public function mdlEditarHabitacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET tipo_h = :tipo_h, estilo = :estilo, ruta = :ruta, galeria = :galeria, banner = :banner, cupos = :cupos, serviciosEnlazados = :serviciosEnlazados, precio = :precio, caracteristicas = :caracteristicas, lugarSalida = :lugarSalida, horaSalida = :horaSalida, incluye = :incluye, noIncluye = :noIncluye, recomendaciones = :recomendaciones, itinerario = :itinerario, descripcion_h = :descripcion_h WHERE id_h = :id_h");

		$stmt->bindParam(":id_h", $datos["id_h"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_h", $datos["tipo_h"], PDO::PARAM_STR);
		$stmt->bindParam(":estilo", $datos["estilo"], PDO::PARAM_STR);
		$stmt->bindParam(":ruta", $datos["ruta"], PDO::PARAM_STR);
		$stmt->bindParam(":galeria", $datos["galeria"], PDO::PARAM_STR);		
		$stmt->bindParam(":descripcion_h", $datos["descripcion_h"], PDO::PARAM_STR);
		$stmt->bindParam(":banner", $datos["banner"], PDO::PARAM_STR);
		$stmt->bindParam(":cupos", $datos["cupos"], PDO::PARAM_STR);
		$stmt->bindParam(":serviciosEnlazados", $datos["serviciosEnlazados"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":caracteristicas", $datos["caracteristicas"], PDO::PARAM_STR);
		$stmt->bindParam(":lugarSalida", $datos["lugarSalida"], PDO::PARAM_STR);
		$stmt->bindParam(":horaSalida", $datos["horaSalida"], PDO::PARAM_STR);
		$stmt->bindParam(":incluye", $datos["incluye"], PDO::PARAM_STR);
		$stmt->bindParam(":noIncluye", $datos["noIncluye"], PDO::PARAM_STR);
		$stmt->bindParam(":recomendaciones", $datos["recomendaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":itinerario", $datos["itinerario"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR HABITACION
	=============================================*/

	static public function mdlActualizarHabitacion($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	// get las id

	static public function getLastId($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT id_h FROM $tabla ORDER BY id_h DESC");		

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Eliminar habitacion
	=============================================*/

	static public function mdlEliminarHabitacion($tabla, $id){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_h = :id_h");

		$stmt -> bindParam(":id_h", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

}