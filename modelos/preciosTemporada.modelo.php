<?php

require_once "conexion.php";

class ModeloPreciosTemporada{

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

}
