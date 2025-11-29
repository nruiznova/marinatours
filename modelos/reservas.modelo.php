<?php

require_once "conexion.php";

Class ModeloReservas{

	/*=============================================
	MOSTRAR HABITACIONES-RESERVAS-CATEGORIAS CON INNER JOIN
	=============================================*/
	
	static public function mdlMostrarReservas($tabla1, $tabla2, $tabla3, $valor){  

		$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.*, $tabla3.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_h = $tabla2.id_habitacion INNER JOIN $tabla3 ON $tabla1.tipo_h = $tabla3.id  WHERE id_h = :id_h");

		$stmt -> bindParam(":id_h", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Mostrar Codigo Reserva Singular
	=============================================*/

	static public function mdlMostrarCodigoReserva($tabla, $valor){ 

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE codigo_reserva LIKE :codigo_reserva");

		$codigo = "".$valor."";

		$stmt -> bindParam(":codigo_reserva", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	
	}

	/*=============================================
	Mostrar todas las reservas
	=============================================*/

	static public function mdlMostrarReservaAll($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		// $stmt -> bindParam(":codigo_reserva", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	
	}

	/*=============================================
	Mostrar id Reserva Singular
	=============================================*/

	static public function mdlMostrarIdReserva($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_reserva = :id_reserva");

		$stmt -> bindParam(":id_reserva", $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

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
	Guardar Reserva
	=============================================*/

	static public function mdlGuardarReserva($tabla, $datos){ 

		$connection = Conexion::conectar();
		$stmt = $connection->prepare("INSERT INTO $tabla(id_habitacion, id_usuario, pago_reserva, numero_transaccion, codigo_reserva, descripcion_reserva, fecha_ingreso, fecha_salida, guests, firstName, lastName ,tipo_identificacion ,numero_identificacion ,celular ,correo ,hospedaje ,abono ,cuotas ,montoPagar ,valorCuotas ,pagoCuotas) VALUES (:id_habitacion, :id_usuario, :pago_reserva, :numero_transaccion, :codigo_reserva, :descripcion_reserva, :fecha_ingreso, :fecha_salida, :guests, :firstName, :lastName, :tipo_identificacion, :numero_identificacion, :celular, :correo, :hospedaje, :abono, :cuotas, :montoPagar, :valorCuotas, :pagoCuotas)");

		$fecha_ingreso = date("Y-m-d", strtotime($datos["fecha_ingreso"]));
		$fecha_salida = date("Y-m-d", strtotime($datos["fecha_salida"]));

		$stmt->bindParam(":id_habitacion", $datos["id_habitacion"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":pago_reserva", $datos["pago_reserva"], PDO::PARAM_STR);
		$stmt->bindParam(":numero_transaccion", $datos["numero_transaccion"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_reserva", $datos["codigo_reserva"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion_reserva", $datos["descripcion_reserva"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_ingreso", $fecha_ingreso, PDO::PARAM_STR);
		$stmt->bindParam(":fecha_salida", $fecha_salida, PDO::PARAM_STR);
		$stmt->bindParam(":guests", $datos["acompañantes"], PDO::PARAM_STR);
		$stmt->bindParam(":firstName", $datos["firstName"], PDO::PARAM_STR);
		$stmt->bindParam(":lastName", $datos["lastName"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_identificacion", $datos["tipo_identificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":numero_identificacion", $datos["numero_identificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":hospedaje", $datos["hospedaje"], PDO::PARAM_STR);
		$stmt->bindParam(":abono", $datos["abono"], PDO::PARAM_STR);
		$stmt->bindParam(":cuotas", $datos["cuotas"], PDO::PARAM_STR);
		$stmt->bindParam(":montoPagar", $datos["montoPagar"], PDO::PARAM_STR);
		$stmt->bindParam(":valorCuotas", $datos["valorCuotas"], PDO::PARAM_STR);
		$stmt->bindParam(":pagoCuotas", $datos["pagoCuotas"], PDO::PARAM_STR);

		if($stmt->execute()){

			// $id = $connection->lastInsertId();

			// return $id;

			return "ok";

		}else{

			return "error"; 
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	Mostrar Reservas por Usuario
	=============================================*/

	static public function mdlMostrarReservasUsuario($tabla, $valor){ 

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario ORDER BY id_reserva DESC LIMIT 5");

		$stmt -> bindParam(":id_usuario", $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
		
	}

	/*=============================================
	Crear testimonio Vacío
	=============================================*/
	static public function mdlCrearTestimonio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, pais, galeria, testimonio, aprobado) VALUES (:nombre, :pais, :galeria, :testimonio, :aprobado)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt->bindParam(":galeria", $datos["galeria"], PDO::PARAM_STR);
		$stmt->bindParam(":testimonio", $datos["testimonio"], PDO::PARAM_STR);
		$stmt->bindParam(":aprobado", $datos["aprobado"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok"; 

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	Mostrar testimonios
	=============================================*/

	static public function mdlMostrarTestimonios($tabla1, $tabla2, $tabla3, $tabla4, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.*, $tabla3.*,  $tabla4.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_hab = $tabla2.id_h INNER JOIN $tabla3 ON $tabla1.id_res = $tabla3.id_reserva INNER JOIN $tabla4 ON $tabla1.id_us = $tabla4.id_u WHERE $item = :$item ORDER BY id_testimonio DESC");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	Mostrar testimonios
	=============================================*/

	static public function mdlMostrarTestimoniosCompletos($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT  *FROM $tabla ORDER BY id_testimonio DESC");

		// $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	Actualizar testimonio
	=============================================*/

	static public function mdlActualizarTestimonio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET testimonio = :testimonio WHERE id_testimonio = :id_testimonio");

		$stmt -> bindParam(":testimonio", $datos["testimonio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_testimonio", $datos["id_testimonio"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	Mostrar Notificaciones
	=============================================*/

	static public function mdlMostrarNotificaciones($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tipo = :tipo");

		$stmt -> bindParam(":tipo", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	
	}

	/*=============================================
	Actualizar notificaciones
	=============================================*/

	static public function mdlActualizarNotificaciones($tabla, $tipo, $cantidad){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cantidad = :cantidad WHERE tipo = :tipo");

		$stmt -> bindParam(":cantidad", $cantidad, PDO::PARAM_STR);
		$stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);

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
	Completar datos reserva
	=============================================*/

	static public function mdlCompletarDatos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET guests = :guests WHERE id_reserva = :id_reserva");

		$stmt -> bindParam(":guests", $datos["acompañantes"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_reserva", $datos["id_reserva"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlVerificarDisponibilidad($idServicio, $fecha) {
		$pdo = Conexion::conectar();
	
		// 1. Obtener datos del servicio
		$stmt = $pdo->prepare("SELECT cupos, serviciosEnlazados FROM habitaciones WHERE id_h = ?");
		$stmt->execute([$idServicio]);
		$servicio = $stmt->fetch(PDO::FETCH_ASSOC);
	
		if (!$servicio) {
			return ['error' => 'Servicio no encontrado'];
		}
	
		$cupos = (int)$servicio['cupos'];
		$serviciosRelacionados = explode(";", $servicio['serviciosEnlazados']);
		$serviciosRelacionados[] = $idServicio;
		$serviciosRelacionados = array_unique($serviciosRelacionados);
	
		// 2. Obtener todas las reservas para esos servicios en la fecha
		$inQuery = implode(',', array_fill(0, count($serviciosRelacionados), '?'));
		$stmtRes = $pdo->prepare("SELECT descripcion_reserva FROM reservas WHERE id_habitacion IN ($inQuery) AND fecha_ingreso = ?");
		$stmtRes->execute(array_merge($serviciosRelacionados, [$fecha]));
		$reservas = $stmtRes->fetchAll(PDO::FETCH_ASSOC);
	
		$totalReservadas = 0;
	
		foreach ($reservas as $reserva) {
			preg_match_all('/\d+/', $reserva['descripcion_reserva'], $matches);
			foreach ($matches[0] as $num) {
				$totalReservadas += (int)$num;
			}
		}
	
		return [
			'cupos_totales' => $cupos,
			'personas_reservadas' => $totalReservadas,
			'disponibles' => max(0, $cupos - $totalReservadas)
		];
	}
	
	public static function mdlObtenerDatosTemporales($codigo)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM reservas_temporales WHERE codigo_reserva = :codigo");
        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

	public static function mdlObtenerReservasPendientes()
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM reservas_temporales WHERE transactionState = 'PENDING' AND updated <= (NOW() - INTERVAL 3 MINUTE)");

		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    public static function mdlGuardarReservaTemporal($datos)
    {
        $connection = Conexion::conectar();
        $tabla = 'reservas_temporales';
		$stmt = $connection->prepare("INSERT INTO $tabla(id_habitacion, id_usuario, pago_reserva, numero_transaccion, codigo_reserva, descripcion_reserva, fecha_ingreso, fecha_salida, guests, firstName, lastName ,tipo_identificacion ,numero_identificacion ,celular ,correo ,hospedaje ,abono ,cuotas ,montoPagar ,valorCuotas ,pagoCuotas, transactionState) VALUES (:id_habitacion, :id_usuario, :pago_reserva, :numero_transaccion, :codigo_reserva, :descripcion_reserva, :fecha_ingreso, :fecha_salida, :guests, :firstName, :lastName, :tipo_identificacion, :numero_identificacion, :celular, :correo, :hospedaje, :abono, :cuotas, :montoPagar, :valorCuotas, :pagoCuotas, :transactionState)");

		$fecha_ingreso = date("Y-m-d", strtotime($datos["fecha_ingreso"]));
		$fecha_salida = date("Y-m-d", strtotime($datos["fecha_salida"]));

		$stmt->bindParam(":id_habitacion", $datos["id_habitacion"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":pago_reserva", $datos["pago_reserva"], PDO::PARAM_STR);
		$stmt->bindParam(":numero_transaccion", $datos["numero_transaccion"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_reserva", $datos["codigo_reserva"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion_reserva", $datos["descripcion_reserva"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_ingreso", $fecha_ingreso, PDO::PARAM_STR);
		$stmt->bindParam(":fecha_salida", $fecha_salida, PDO::PARAM_STR);
 		$stmt->bindParam(":guests", $datos["acompañantes"], PDO::PARAM_STR);
		$stmt->bindParam(":firstName", $datos["firstName"], PDO::PARAM_STR);
		$stmt->bindParam(":lastName", $datos["lastName"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_identificacion", $datos["tipo_identificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":numero_identificacion", $datos["numero_identificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":hospedaje", $datos["hospedaje"], PDO::PARAM_STR);
		$stmt->bindParam(":abono", $datos["abono"], PDO::PARAM_STR);
		$stmt->bindParam(":cuotas", $datos["cuotas"], PDO::PARAM_STR);
		$stmt->bindParam(":montoPagar", $datos["montoPagar"], PDO::PARAM_STR);
		$stmt->bindParam(":valorCuotas", $datos["valorCuotas"], PDO::PARAM_STR);
		$stmt->bindParam(":pagoCuotas", $datos["pagoCuotas"], PDO::PARAM_STR);
		$stmt->bindParam(":transactionState", $datos["transactionState"], PDO::PARAM_STR);

		if($stmt->execute()){
			return $connection->lastInsertId();

		}else{
			return "error"; 
		}

		$stmt->close();
		$stmt = null;
    }
	
	static public function mdlBorrarReservaTemporal($codigo_reserva) {
		$stmt = Conexion::conectar()->prepare(
			"DELETE FROM reservas_temporales WHERE codigo_reserva = :codigo_reserva"
		);
		$stmt->bindParam(":codigo_reserva", $codigo_reserva, PDO::PARAM_STR);
		return $stmt->execute();
	}

	static public function mdlSaveTrazabilityCode($tx, $codigo_reserva){
		$stmt = Conexion::conectar()->prepare("UPDATE reservas_temporales SET numero_transaccion = :numero_transaccion WHERE codigo_reserva = :codigo_reserva");
		$stmt -> bindParam(":numero_transaccion", $tx, PDO::PARAM_STR);
		$stmt->bindParam(":codigo_reserva", $codigo_reserva, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());
		}
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlSaveTransactionState($state, $codigo_reserva) {
		$stmt = Conexion::conectar()->prepare("UPDATE reservas_temporales SET transactionState = :transactionState, updated = NOW() WHERE codigo_reserva = :codigo_reserva");

		$stmt->bindParam(":transactionState", $state, PDO::PARAM_STR);
		$stmt->bindParam(":codigo_reserva", $codigo_reserva, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			echo "\nPDO::errorInfo():\n";
			print_r($stmt->errorInfo());
		}

		$stmt = null;
	}

}