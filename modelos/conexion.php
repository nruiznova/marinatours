<?php

$config = require_once __DIR__ . '/../config.php';

class Conexion {

  static public function conectar() {
    global $config;
    
    $link = new PDO(
      "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset=utf8",
      $config['user'],
      $config['pass']
    );

    // Forzar UTF-8 en la conexión
    $link->exec("SET NAMES utf8");

    return $link;
  }

}
