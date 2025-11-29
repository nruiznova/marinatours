<?php

require_once "conexion.php"; // tu clase para conectar a la DB

class ModeloToken {
  static public function obtenerToken() {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM pse_token ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  static public function guardarToken($access_token, $expires_in, $issued_at_ms) {
    $issued_at = intval($issued_at_ms / 1000);
    $stmt = Conexion::conectar()->prepare(
      "INSERT INTO pse_token(access_token, expires_in, issued_at_seconds, created_at) 
       VALUES(:access_token, :expires_in, :issued_at_seconds, NOW())"
    );
    $stmt->bindParam(":access_token", $access_token, PDO::PARAM_STR);
    $stmt->bindParam(":expires_in", $expires_in, PDO::PARAM_INT);
    $stmt->bindParam(":issued_at_seconds", $issued_at, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
