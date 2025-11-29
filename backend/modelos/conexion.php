<?php

Class Conexion{

	static public function conectar(){

		$link = new PDO(
          "mysql:host=localhost;port=8889;dbname=marinatourscarta_database;charset=utf8",
          "marinatourscarta_user",
          "V@c0812iqMSrC3A*"
        );

		$link->exec("set names utf8");

		return $link;

	}


}