<?php

class Conexion {

  static public function conectar() {
    $link = new PDO(
      "mysql:host=localhost;port=8889;dbname=marinatourscarta_database;charset=utf8",
      "marinatourscarta_user",
      "V@c0812iqMSrC3A*"
    );

    // Forzar UTF-8 en la conexión
    $link->exec("SET NAMES utf8");

    return $link;
  }

}
