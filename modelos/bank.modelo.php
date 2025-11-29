<?php

require_once "conexion.php";

class ModeloBanksPSE {

	/* Borrar bancos previos */
	static public function borrarBancos() {
		$stmt = Conexion::conectar()->prepare("DELETE FROM pse_bancos");
		return $stmt->execute();
	}

	/* Insertar un banco */
	static public function insertarBanco($codigo, $nombre) {
		$stmt = Conexion::conectar()->prepare(
			"INSERT INTO pse_bancos (financial_institute_code, financial_institute_name, updated_at) 
				VALUES (:codigo, :nombre, NOW())"
		);
		$stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		return $stmt->execute();
	}

	/* Listar bancos guardados */
	static public function obtenerBancos() {
		$stmt = Conexion::conectar()->prepare("SELECT * FROM pse_bancos ORDER BY financial_institute_name ASC");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function obtenerBancosByID($code)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM pse_bancos WHERE financial_institute_code = :code");
        $stmt->bindParam(":code", $code, PDO::PARAM_STR);
        
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
