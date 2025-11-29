<?php

require_once "conexion.php";

class ModeloReservas{

	/*=============================================
	MOSTRAR USUARIOS-RESERVAS CON INNER JOIN
	=============================================*/

	static public function mdlMostrarReservas($tabla1, $tabla2, $item, $valor){

		if($item != null && $valor != null){

			if($item == "rango"){ 

				$fechas = explode("/", $valor);

				$fechaInicial = $fechas[0];

				$fechaFinal = $fechas[1];

				if($fechaInicial == $fechaFinal){

					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla2 WHERE DATE_FORMAT(fecha_ingreso, '%Y-%m-%d') LIKE :fecha");
		
					$valor_like = '%' . $fechaFinal . '%'; 

					$stmt -> bindParam(":fecha", $valor_like, PDO::PARAM_STR); 
		
					$stmt -> execute();
		
					return $stmt -> fetchAll();
		
				}else{
		
					$fechaActual = new DateTime();
					$fechaActual ->add(new DateInterval("P1D"));
					$fechaActualMasUno = $fechaActual->format("Y-m-d"); 
		
					$fechaFinal2 = new DateTime($fechaFinal);
					$fechaFinal2 ->add(new DateInterval("P1D"));
					$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");
		
					if($fechaFinalMasUno == $fechaActualMasUno){

						// 
						// DATE_FORMAT(fecha_ingreso, '%Y-%m-%d')
		
						$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla2 WHERE DATE_FORMAT(fecha_ingreso, '%Y-%m-%d') BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
		
					}else{		
		
						$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla2 WHERE DATE_FORMAT(fecha_ingreso, '%Y-%m-%d') BETWEEN '$fechaInicial' AND '$fechaFinal'");
		
					}
				
					$stmt -> execute();
		
					return $stmt -> fetchAll();
		
				}

			}else{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla2 WHERE $item LIKE :$item");

				$valor_like = '%' . $valor . '%'; 

				$stmt -> bindParam(":".$item, $valor_like, PDO::PARAM_STR); 

				$stmt -> execute();

				return $stmt -> fetchAll();

			} 						

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla2 ORDER BY $tabla2.id_reserva DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*============================================= 
	Cambiar reserva
	=============================================*/

	static public function mdlCambiarReserva($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_ingreso = :fecha_ingreso, firstName = :firstName, lastName = :lastName, tipo_identificacion = :tipo_identificacion, numero_identificacion = :numero_identificacion, celular = :celular, correo = :correo WHERE id_reserva = :id_reserva");

		$stmt->bindParam(":fecha_ingreso", $datos["fecha_ingreso"], PDO::PARAM_STR);
		$stmt->bindParam(":firstName", $datos["firstName"], PDO::PARAM_STR);
		$stmt->bindParam(":lastName", $datos["lastName"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_identificacion", $datos["tipo_identificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":numero_identificacion", $datos["numero_identificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_reserva", $datos["id_reserva"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR PAGOS
	=============================================*/

	static public function mdlMostrarPagos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id_pago DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id_pago DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}


	/*============================================= 
	REGISTRAR PAGO
	=============================================*/

	static public function mdlRegistrarPagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_reserva, monto, metodo_pago, usuario) VALUES (:id_reserva, :monto, :metodo_pago, :usuario)");

		$stmt->bindParam(":id_reserva", $datos["id_reserva"], PDO::PARAM_INT);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*============================================= 
	BLOQUEAR FECHAS
	=============================================*/

	static public function mdlBloquearFechas($tabla, $datos){ 

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (fecha_inicial, fecha_final) VALUES (:fecha_inicial, :fecha_final)");

		$stmt->bindParam(":fecha_inicial", $datos["fecha_inicial"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*============================================= 
	Cambiar rango
	=============================================*/

	static public function mdlEditarFechas($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_inicial = :fecha_inicial, fecha_final = :fecha_final WHERE id = :id");

		$stmt->bindParam(":fecha_inicial", $datos["fecha_inicial"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);		
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Eliminar rango
	=============================================*/

	static public function mdlBorrarFechas($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Eliminar pagos
	=============================================*/

	static public function mdlEliminarPago($tabla, $idReserva){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_reserva = :id_reserva");

		$stmt -> bindParam(":id_reserva", $idReserva, PDO::PARAM_INT);
		// $stmt -> bindParam(":metodo_pago", "Mercadopago", PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*============================================= 
	Actualizar estado
	=============================================*/

	static public function mdlActualizarEstado($tabla, $datos){

		if($datos["estado"] == 3){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_ingreso = :fecha_ingreso, estado = :estado WHERE id_reserva = :id_reserva");

			$fecha_ingreso = NULL;

			$stmt->bindParam(":fecha_ingreso", $fecha_ingreso, PDO::PARAM_STR);	
			$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);	
			$stmt->bindParam(":id_reserva", $datos["id_reserva"], PDO::PARAM_INT);

		}else{

			// var_dump($datos);

			if(isset($datos["fecha_ingreso"])){

				$fecha_ingreso = date("Y-m-d", strtotime($datos["fecha_ingreso"]));

				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, fecha_ingreso = :fecha_ingreso WHERE id_reserva = :id_reserva");

				$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);	
				$stmt->bindParam(":fecha_ingreso", $fecha_ingreso, PDO::PARAM_STR);	
				$stmt->bindParam(":id_reserva", $datos["id_reserva"], PDO::PARAM_INT);


			}else{

				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id_reserva = :id_reserva");

				$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);	
				$stmt->bindParam(":id_reserva", $datos["id_reserva"], PDO::PARAM_INT);

			}									

		}			

		if($stmt -> execute()){

			return "ok";

		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Mostrar cupos de un servicio en una fecha
	=============================================*/

	static public function mdlMostrarCupos($tabla, $datos){		

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE servicios = :servicios AND fecha = :fecha ORDER BY id_cupo DESC");

		$stmt -> bindParam(":servicios", $datos["servicios"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();		

		$stmt -> close();

		$stmt = null;

	}

	/*============================================= 
	Actulizar cupos de un servicio en una fecha
	=============================================*/

	static public function mdlActualizarCupos($tabla, $datos){ 

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (servicios, fecha, cupos) VALUES (:servicios, :fecha, :cupos)");

		$stmt->bindParam(":servicios", $datos["servicios"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":cupos", $datos["cupos"], PDO::PARAM_STR);

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