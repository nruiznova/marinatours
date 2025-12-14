<?php

require_once "conexion.php";

class ModeloPreciosTemporada{

	/*=============================================
	Mostrar precios de temporada
	=============================================*/

	static public function mdlMostrarPreciosTemporada($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fecha_inicio ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha_inicio ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Crear precio de temporada
	=============================================*/

	static public function mdlCrearPrecioTemporada($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_servicio, nombre_temporada, fecha_inicio, fecha_fin, precios, activo) VALUES (:id_servicio, :nombre_temporada, :fecha_inicio, :fecha_fin, :precios, :activo)");

		$stmt->bindParam(":id_servicio", $datos["id_servicio"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_temporada", $datos["nombre_temporada"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":precios", $datos["precios"], PDO::PARAM_STR);
		$stmt->bindParam(":activo", $datos["activo"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	Editar precio de temporada
	=============================================*/

	static public function mdlEditarPrecioTemporada($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_temporada = :nombre_temporada, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, precios = :precios, activo = :activo WHERE id_precio_temporada = :id_precio_temporada");

		$stmt->bindParam(":id_precio_temporada", $datos["id_precio_temporada"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_temporada", $datos["nombre_temporada"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":precios", $datos["precios"], PDO::PARAM_STR);
		$stmt->bindParam(":activo", $datos["activo"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	Eliminar precio de temporada
	=============================================*/

	static public function mdlEliminarPrecioTemporada($tabla, $datos){

		// Log para debugging
		error_log("=== MODELO ELIMINAR ===");
		error_log("Tabla: " . $tabla);
		error_log("ID a eliminar: " . $datos);

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_precio_temporada = :id_precio_temporada");

		$stmt -> bindParam(":id_precio_temporada", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			error_log("Filas afectadas: " . $stmt->rowCount());
			return "ok";
		
		}else{

			error_log("Error SQL: " . print_r($stmt->errorInfo(), true));
			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Obtener precio de temporada por fecha
	=============================================*/

	static public function mdlObtenerPrecioTemporadaPorFecha($tabla, $id_servicio, $fecha){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_servicio = :id_servicio AND fecha_inicio <= :fecha AND fecha_fin >= :fecha AND activo = 1 ORDER BY fecha_inicio DESC LIMIT 1");

		$stmt->bindParam(":id_servicio", $id_servicio, PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	Verificar conflicto de fechas entre temporadas
	=============================================*/

	static public function mdlVerificarConflictoFechas($tabla, $id_servicio, $fecha_inicio, $fecha_fin, $id_excluir = null){

		// Buscar temporadas que se crucen con el rango de fechas proporcionado
		// Se cruzan si: (fecha_inicio <= fecha_fin_nueva) AND (fecha_fin >= fecha_inicio_nueva)
		
		if($id_excluir != null){
			// Al editar, excluir la temporada actual
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_servicio = :id_servicio AND id_precio_temporada != :id_excluir AND ((fecha_inicio <= :fecha_fin AND fecha_fin >= :fecha_inicio)) LIMIT 1");
			$stmt->bindParam(":id_excluir", $id_excluir, PDO::PARAM_INT);
		} else {
			// Al crear, verificar todas las temporadas del servicio
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_servicio = :id_servicio AND ((fecha_inicio <= :fecha_fin AND fecha_fin >= :fecha_inicio)) LIMIT 1");
		}

		$stmt->bindParam(":id_servicio", $id_servicio, PDO::PARAM_INT);
		$stmt->bindParam(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $fecha_fin, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch(); // Retorna la temporada conflictiva o false si no hay conflicto

		$stmt->close();
		$stmt = null;

	}

}
