<?php

class ControladorRuta{

	static public function ctrRuta(){

		// Cargar configuración dinámica según el entorno
		$config = require __DIR__ . '/../config.php';
		return $config['site_url'];

	}

	static public function ctrServidor(){

		// Cargar configuración dinámica según el entorno
		$config = require __DIR__ . '/../config.php';
		return $config['site_url'] . 'backend/';
	}

}