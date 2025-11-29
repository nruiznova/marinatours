<?php

require_once __DIR__ . "/../modelos/token.modelo.php";   // Modelo para guardar/leer token en DB
require_once __DIR__ . "/../api/PSEAccessToken.php"; 

class ControladorTokenPSE {
  static public function obtenerToken() {
    $token = ModeloToken::obtenerToken();
    if ($token) {
      $expira = intval($token["issued_at_seconds"]) + intval($token["expires_in"]);
      if (time() < $expira) {
        // Token sigue vigente
        return [
          'access_token' => $token["access_token"]
        ];
      }
    }

    // Token no existe o ya expiró → pedir nuevo
    $api = new PSEAccessToken();
    $nuevo = $api->getToken();

    if ($nuevo && isset($nuevo["access_token"])) {
      ModeloToken::guardarToken(
        $nuevo["access_token"], 
        $nuevo["expires_in"], 
        $nuevo["issued_at"] // milisegundos desde API
      );
      return [
        'access_token' => $nuevo["access_token"]
      ];
    }

    return  [
      'returnCode' => $nuevo['ErrorCode'],
      'errorDetails' => $nuevo['Error'],
    ]; 
  }
}
