# Configuración de URLs por Entorno

## 📋 Resumen

El proyecto ahora detecta automáticamente si estás en **LOCAL** o **PRODUCCIÓN** y usa las URLs correspondientes.

## 🔧 Archivos Modificados

### 1. **config.php** (sin cambios)
Detecta el entorno automáticamente:
```php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    return require 'config.local.php';  // LOCAL
} else {
    return require 'config.prod.php';   // PRODUCCIÓN
}
```

### 2. **config.local.php** ✅ ACTUALIZADO
```php
<?php
return [
    'host' => 'localhost',
    'port' => '', 
    'db'   => 'reservas-hotel',
    'user' => 'root',
    'pass' => '',
    
    // URLs del proyecto LOCAL
    'base_url' => 'http://localhost/marinatours/',
    'site_url' => 'http://localhost/marinatours/',
    'api_url'  => 'http://localhost/marinatours/api/'
];
```

### 3. **config.prod.php** ✅ ACTUALIZADO
```php
<?php
return [
    'host' => 'localhost',
    'port' => '8889',
    'db'   => 'marinatourscarta_database',
    'user' => 'marinatourscarta_user',
    'pass' => 'V@c0812iqMSrC3A*',
    
    // URLs del proyecto PRODUCCIÓN
    'base_url' => 'https://marinatourscartagena.com.co/',
    'site_url' => 'https://marinatourscartagena.com.co/',
    'api_url'  => 'https://marinatourscartagena.com.co/api/'
];
```

### 4. **helpers.php** 🆕 NUEVO
Funciones auxiliares para acceder a las URLs:
```php
base_url();  // Retorna URL base
site_url();  // Retorna URL del sitio
api_url();   // Retorna URL de la API
config('site_url'); // Obtiene cualquier valor del config
```

### 5. **controladores/ruta.controlador.php** ✅ ACTUALIZADO
```php
class ControladorRuta{
    static public function ctrRuta(){
        $config = require __DIR__ . '/../config.php';
        return $config['site_url'];
    }

    static public function ctrServidor(){
        $config = require __DIR__ . '/../config.php';
        return $config['site_url'] . 'backend/';
    }
}
```

### 6. **backend/controladores/ruta.controlador.php** ✅ ACTUALIZADO
```php
class ControladorRuta{
    static public function ctrRuta(){
        $config = require __DIR__ . '/../../config.php';
        return $config['site_url'];
    }

    static public function ctrRutaBackend(){
        $config = require __DIR__ . '/../../config.php';
        return $config['site_url'] . 'backend/';
    }
}
```

### 7. **controladores/procesar_pse.php** ✅ ACTUALIZADO
```php
// ANTES:
$entityurl = "https://marinatourscartagena.com.co/resultado-pago?id=" . $codigoReserva;

// AHORA:
$config = require __DIR__ . '/../config.php';
$entityurl = $config['site_url'] . "resultado-pago?id=" . $codigoReserva;
```

### 8. **vistas/js/brick.js** ✅ ACTUALIZADO
```javascript
// ANTES:
'return': 'https://marinatourscartagena.com.co/'

// AHORA:
'return': $('#urlPrincipal').val()
```

## 🎯 Cómo Funciona

### En LOCAL (localhost):
- Usa `config.local.php`
- URLs: `http://localhost/marinatours/`
- Base de datos: `reservas-hotel`
- Usuario: `root`
- Sin contraseña

### En PRODUCCIÓN (servidor web):
- Usa `config.prod.php`
- URLs: `https://marinatourscartagena.com.co/`
- Base de datos: `marinatourscarta_database`
- Usuario: `marinatourscarta_user`
- Con contraseña

## 📝 Uso en Código PHP

### Opción 1: Usando los controladores existentes
```php
// En cualquier archivo PHP
$ruta = ControladorRuta::ctrRuta(); 
// Local: http://localhost/marinatours/
// Producción: https://marinatourscartagena.com.co/

$servidor = ControladorRuta::ctrServidor();
// Local: http://localhost/marinatours/backend/
// Producción: https://marinatourscartagena.com.co/backend/
```

### Opción 2: Cargando directamente el config
```php
// En cualquier archivo PHP
$config = require __DIR__ . '/config.php'; // Ajusta la ruta según sea necesario
$url = $config['site_url'];
$api = $config['api_url'];
```

### Opción 3: Usando helpers.php (NUEVO)
```php
// Primero incluir el archivo
require_once 'helpers.php';

// Luego usar las funciones
$base = base_url();    // http://localhost/marinatours/ o https://marinatourscartagena.com.co/
$site = site_url();    // Lo mismo que base_url()
$api = api_url();      // URL de la API
$db = config('db');    // Obtiene valor del config
```

## 🌐 Uso en JavaScript

Las URLs ya están disponibles en todos los archivos JavaScript a través de inputs hidden en `plantilla.php`:

```javascript
// Obtener URL principal
var urlPrincipal = $('#urlPrincipal').val();
// Local: http://localhost/marinatours/
// Producción: https://marinatourscartagena.com.co/

// Obtener URL del servidor/backend
var urlServidor = $('#urlServidor').val();
// Local: http://localhost/marinatours/backend/
// Producción: https://marinatourscartagena.com.co/backend/
```

## ✅ Verificación

Para verificar que todo funciona correctamente:

1. **En LOCAL:**
   - Abre: `http://localhost/marinatours/`
   - Verifica que cargue correctamente
   - Prueba el backend: `http://localhost/marinatours/backend/`

2. **En PRODUCCIÓN:**
   - Sube todos los archivos al servidor
   - Abre: `https://marinatourscartagena.com.co/`
   - Verifica que cargue correctamente
   - El sistema automáticamente usará las URLs de producción

## 🚨 IMPORTANTE

**NO NECESITAS CAMBIAR NADA CUANDO SUBAS A PRODUCCIÓN**

El archivo `config.php` detecta automáticamente el entorno basándose en `$_SERVER['SERVER_NAME']`:
- Si es `localhost` → usa `config.local.php`
- Si es cualquier otro dominio → usa `config.prod.php`

## 📌 Notas

- Los archivos `config.local.php` y `config.prod.php` NO deben subirse a control de versiones si contienen contraseñas sensibles
- Puedes agregar más configuraciones según necesites (claves API, tokens, etc.)
- Si necesitas agregar más entornos (staging, development), puedes modificar `config.php`

## 🔐 Seguridad

Si usas Git, agrega al `.gitignore`:
```
config.local.php
config.prod.php
```

Y mantén un archivo de ejemplo:
```
config.local.example.php
config.prod.example.php
```
