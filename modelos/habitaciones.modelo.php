<?php

require_once "conexion.php";

Class ModeloHabitaciones{

	/*=============================================
	MOSTRAR CATEGORIAS-HABITACIONES CON INNER JOIN
	=============================================*/

	static public function mdlMostrarHabitaciones($tabla, $item, $valor){

		if($item != null){

			if($item == 'id_galeria'){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id_galeria ASC LIMIT 1"); 
	
				$stmt -> execute();
	
				return $stmt -> fetch();
	
			}else{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetch();

			}			

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla"); 

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Mostrar Habitacion Singular
	=============================================*/

	static public function mdlMostrarHabitacion($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_h = :id_h");

		$stmt -> bindParam(":id_h", $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	
	}



}