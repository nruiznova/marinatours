<?php

$config = require_once __DIR__ . '/../../config.php';

Class Conexion{

	static public function conectar(){
		global $config;

		$link = new PDO(
          "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset=utf8",
          $config['user'],
          $config['pass']
        );

		$link->exec("set names utf8");

		return $link;

	}


}