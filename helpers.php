<?php

/**
 * Archivo de funciones auxiliares para acceder a la configuración
 */

// Cargar configuración
$config = require 'config.php';

/**
 * Obtiene la URL base del proyecto según el entorno
 * @return string
 */
function base_url() {
    global $config;
    return $config['base_url'];
}

/**
 * Obtiene la URL del sitio según el entorno
 * @return string
 */
function site_url() {
    global $config;
    return $config['site_url'];
}

/**
 * Obtiene la URL de la API según el entorno
 * @return string
 */
function api_url() {
    global $config;
    return $config['api_url'];
}

/**
 * Obtiene cualquier valor de configuración
 * @param string $key
 * @return mixed
 */
function config($key) {
    global $config;
    return isset($config[$key]) ? $config[$key] : null;
}
