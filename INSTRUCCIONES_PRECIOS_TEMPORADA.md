# Sistema de Precios por Temporada - Marina Tours

## Instalación

### 1. Crear la tabla en la base de datos

Ejecutar el siguiente script SQL en phpMyAdmin o su cliente MySQL preferido:

```sql
-- Ubicación del archivo: backend/sql/precios_temporada.sql

CREATE TABLE IF NOT EXISTS `precios_temporada` (
  `id_precio_temporada` int(11) NOT NULL AUTO_INCREMENT,
  `id_servicio` int(11) NOT NULL,
  `nombre_temporada` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `precios` text NOT NULL COMMENT 'JSON con precios por tipo de usuario',
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_precio_temporada`),
  KEY `id_servicio` (`id_servicio`),
  KEY `fecha_inicio` (`fecha_inicio`),
  KEY `fecha_fin` (`fecha_fin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Uso del Sistema

### Acceder al Gestor de Temporadas

1. Ingresar al panel de administración
2. Ir a la sección **Servicios**
3. Hacer clic en el botón **"Gestionar precios por temporada"** (botón azul/info)

### Crear una Nueva Temporada

1. En el modal que se abre, seleccionar un servicio de la lista de la izquierda
2. Hacer clic en el botón **"Nueva Temporada"**
3. Completar el formulario:
   - **Nombre de la temporada**: Ej. "Temporada Alta Navidad 2025"
   - **Fecha de inicio**: 26/12/2025
   - **Fecha de fin**: 06/01/2026
   - **Estado**: Activar o desactivar la temporada
   - **Precios por tipo de usuario**:
     - Marcar "Visible" para cada tipo de usuario que tendrá precio especial
     - Ingresar precio para adultos
     - Ingresar precio para niños
     - Marcar opciones de crédito y abono si aplica

4. Hacer clic en **"Guardar Temporada"**

### Editar una Temporada

1. Seleccionar el servicio de la lista
2. En la tabla de temporadas, hacer clic en el botón de editar (icono lápiz)
3. Modificar los datos necesarios
4. Guardar cambios

### Eliminar una Temporada

1. Seleccionar el servicio de la lista
2. En la tabla de temporadas, hacer clic en el botón de eliminar (icono papelera)
3. Confirmar la eliminación

### Activar/Desactivar Temporadas

- Al editar una temporada, desmarcar "Temporada activa" para deshabilitarla temporalmente sin eliminarla
- Las temporadas inactivas no se aplicarán en las reservas del frontend

## Funcionamiento Automático

### Prioridad de Precios

El sistema aplica precios según el siguiente orden de prioridad:

1. **Precio de Temporada Activa**: Si existe una temporada activa para la fecha de reserva
2. **Precio Base del Servicio**: Si no hay temporada activa para esa fecha

### En el Frontend

Cuando un usuario realiza una reserva:

1. El sistema verifica automáticamente si la fecha seleccionada está dentro de una temporada activa
2. Si existe temporada activa, muestra los precios de esa temporada
3. Si no existe temporada, muestra los precios base del servicio
4. Los precios se aplican según el tipo de usuario (registrado o público)

### Ejemplo de Uso

**Escenario**: Temporada Alta de Navidad

- **Servicio**: Tour Isla del Encanto
- **Temporada**: Navidad y Año Nuevo 2025
- **Fechas**: 26 de diciembre 2025 al 6 de enero 2026
- **Precio Normal**: $150,000 adultos / $100,000 niños
- **Precio Temporada**: $200,000 adultos / $130,000 niños

**Resultado**:
- Usuario reserva para el 28 de diciembre → Se aplica precio de temporada ($200,000)
- Usuario reserva para el 15 de enero → Se aplica precio normal ($150,000)

## Características Especiales

### Múltiples Temporadas

- Se pueden crear múltiples temporadas para un mismo servicio
- Las temporadas pueden solaparse (el sistema selecciona la más reciente)
- Cada temporada puede tener diferentes precios para diferentes tipos de usuario

### Precios Diferenciados

- Cada tipo de usuario puede tener precios distintos en la temporada
- Se puede configurar visibilidad independiente por tipo de usuario
- Se mantienen las opciones de crédito y abono 50%

### Reportes y Control

- Las temporadas activas se muestran con badge verde
- Las temporadas inactivas se muestran con badge gris
- Se puede consultar el historial de temporadas configuradas

## Archivos Modificados

### Backend
- `/backend/sql/precios_temporada.sql` - Script de creación de tabla
- `/backend/modelos/preciosTemporada.modelo.php` - Modelo de datos
- `/backend/controladores/preciosTemporada.controlador.php` - Lógica de negocio
- `/backend/ajax/preciosTemporada.ajax.php` - Peticiones AJAX
- `/backend/vistas/js/preciosTemporada.js` - Interfaz JavaScript
- `/backend/vistas/paginas/servicios.php` - Vista con modales
- `/backend/vistas/plantilla.php` - Inclusión de scripts
- `/backend/index.php` - Carga de controladores

### Frontend
- `/modelos/preciosTemporada.modelo.php` - Modelo para consultas
- `/controladores/preciosTemporada.controlador.php` - Lógica de aplicación
- `/vistas/paginas/modulos/info-reservas.php` - Uso de precios de temporada
- `/index.php` - Carga de controladores

## Solución de Problemas

### No se ven los precios de temporada en el frontend

1. Verificar que la temporada esté marcada como "Activa"
2. Confirmar que las fechas de la temporada incluyen la fecha de reserva
3. Revisar que los precios estén correctamente configurados

### Error al crear temporada

1. Verificar que la tabla `precios_temporada` exista en la base de datos
2. Confirmar que todos los campos requeridos estén completos
3. Asegurar que la fecha de fin sea posterior a la fecha de inicio

### Los precios no cambian automáticamente

1. Verificar que la fecha de reserva se esté enviando correctamente
2. Revisar los logs de PHP para errores
3. Confirmar que los archivos del modelo y controlador estén incluidos en index.php

## Soporte

Para reportar problemas o solicitar mejoras, contactar al equipo de desarrollo.
