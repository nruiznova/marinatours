<?php
/**
 * Configuración de correo electrónico
 * Este archivo carga las variables de entorno para el envío de correos
 */

// Cargar variables de entorno desde archivo .env
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorar comentarios
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parsear línea
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Remover comillas si existen
            $value = trim($value, '"\'');
            
            // Establecer variable de entorno si no existe
            if (!array_key_exists($name, $_ENV)) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
    return true;
}

// Cargar archivo .env
$envPath = __DIR__ . '/.env';
loadEnv($envPath);

// Función para obtener configuración de correo
function getMailConfig($key, $default = null) {
    // Intentar obtener de variables de entorno
    $value = getenv($key);
    if ($value !== false) {
        return $value;
    }
    
    // Intentar obtener de $_ENV
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    
    // Intentar obtener de $_SERVER
    if (isset($_SERVER[$key])) {
        return $_SERVER[$key];
    }
    
    // Retornar valor por defecto
    return $default;
}

// Configuración de correo
return [
    'host' => getMailConfig('MAIL_HOST', 'smtp.gmail.com'),
    'port' => getMailConfig('MAIL_PORT', 587),
    'username' => getMailConfig('MAIL_USERNAME', 'reservas.marinatours@gmail.com'),
    'password' => getMailConfig('MAIL_PASSWORD', ''),
    'from_address' => getMailConfig('MAIL_FROM_ADDRESS', 'reservas.marinatours@gmail.com'),
    'from_name' => getMailConfig('MAIL_FROM_NAME', 'Hotel Isla Palma'),
    'encryption' => getMailConfig('MAIL_ENCRYPTION', 'tls'),
    'auth_type' => getMailConfig('MAIL_AUTH_TYPE', 'LOGIN'), // Para Brevo/Sendinblue
];
