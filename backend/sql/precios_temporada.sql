-- Tabla para gestionar precios por temporada de servicios
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
