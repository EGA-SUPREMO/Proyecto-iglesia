-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2025 a las 19:50:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- CREATE USER 'test'@'localhost' IDENTIFIED BY '1234';
-- GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost' WITH GRANT OPTION;
-- FLUSH PRIVILEGES;


CREATE DATABASE gestion_parroquial_db;
USE gestion_parroquial_db;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion parroquial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(30) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `nombre_usuario`, `password`) VALUES
(1, 'admin', '$2y$10$IppRaChWUZrkHweK4.S0guzkgupP.jg8caavQlIM4kG77lEceYnDS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feligreses`

CREATE TABLE `feligreses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primer_nombre` VARCHAR(50) NOT NULL,
  `segundo_nombre` VARCHAR(50),
  `primer_apellido` VARCHAR(50) NOT NULL,
  `segundo_apellido` VARCHAR(50),
  `fecha_nacimiento` DATE DEFAULT NULL,
  `localidad` VARCHAR(50) DEFAULT NULL,
  `municipio` VARCHAR(50) DEFAULT NULL,
  `estado` VARCHAR(50) DEFAULT NULL,
  `pais` VARCHAR(50) DEFAULT NULL,
  `cedula` int(9) UNSIGNED,
  `nacionalidad` VARCHAR(1) DEFAULT 'V',
  `partida_de_nacimiento` varchar(30) UNIQUE DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT chk_nacionalidad
  CHECK (nacionalidad IN ('V', 'E')),
  CONSTRAINT unique_nacionalidad_cedula 
    UNIQUE (`nacionalidad`, `cedula`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `parentescos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_padre` INT NOT NULL,
  `id_hijo` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_padre`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`id_hijo`) REFERENCES `feligreses`(`id`)
) ENGINE=InnoDB;

ALTER TABLE `parentescos`
ADD UNIQUE KEY `idx_parentesco_unico` (`id_padre`, `id_hijo`);

ALTER TABLE `parentescos`
ADD CONSTRAINT `chk_no_auto_padre` CHECK (`id_padre` != `id_hijo`);

--
-- Volcado de datos para la tabla `feligreses`
--

--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `id` int(11) NOT NULL,
  `objeto_de_peticion_id` int(11) DEFAULT NULL,
  `realizado_por_id` int(11) NOT NULL,
  `tipo_de_intencion_id` int(11) DEFAULT NULL,
  `servicio_id` int(11) NOT NULL,
  `fecha_inicio` DATETIME NOT NULL,
  `fecha_fin` DATETIME NOT NULL,
  `creado_en` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE tipo_de_intencion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion TEXT NOT NULL
);

INSERT INTO tipo_de_intencion (nombre, descripcion) VALUES
('Acción de Gracias', 'Intención ofrecida para agradecer a Dios por favores recibidos, bendiciones, logros o acontecimientos especiales.'),
('Salud', 'Intención dirigida a pedir por la recuperación o el bienestar físico, mental o espiritual de una persona.'),
('Aniversario', 'Intención ofrecida para conmemorar un aniversario de matrimonio, ordenación, fallecimiento u otro acontecimiento importante.'),
('Difunto', 'Intención dedicada al eterno descanso del alma de una persona fallecida.')
;

CREATE TABLE `misas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_hora` DATETIME UNIQUE NOT NULL,
  `permite_intenciones` BOOLEAN NOT NULL DEFAULT 1,
  `creado_en` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `categoria_de_servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) UNIQUE NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `id_categoria`, `descripcion`) VALUES
(1, 'Intención de Misa Comunitaria', 1, 'Celebración eucarísticacon una intención específica solicitada por un fiel (por un difunto, por la salud, etc.).'),
(2, 'Fe de Bautizo', 2, 'Constancia de fe de bautizo.'),
(3, 'Comunion', 2, 'Constancia de la primera comunión.'),
(4, 'Confirmacion', 2, 'Constancia de confirmación.'),
(5, 'Matrimonio', 2, 'Constancia de matrimonio.');

INSERT INTO `categoria_de_servicios` (`id`, `nombre`) VALUES
(1, 'Misa'),
(2, 'Documentos');


CREATE TABLE `objetos_de_peticion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) UNIQUE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sacerdotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) UNIQUE NOT NULL,
  `vivo` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `constancia_de_fe_de_bautizo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_bautizo` DATE NOT NULL,
  `feligres_bautizado_id` INT(11) UNIQUE NOT NULL,
  `padre_id` INT(11) NOT NULL,
  `madre_id` INT(11) NOT NULL,
  `padrino_nombre` varchar(100) NOT NULL,
  `madrina_nombre` varchar(100) NOT NULL,
  `observaciones` TEXT DEFAULT NULL,
  `ministro_id` INT(11) NOT NULL,
  `ministro_certifica_id` INT(11) NOT NULL,
  `numero_libro` INT(10) NOT NULL,
  `numero_pagina` INT(10) NOT NULL,
  `numero_marginal` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feligres_bautizado_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`padre_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`madre_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`ministro_id`) REFERENCES `sacerdotes`(`id`),
  FOREIGN KEY (`ministro_certifica_id`) REFERENCES `sacerdotes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE constancia_de_fe_de_bautizo
ADD CONSTRAINT chk_numeros_registro_positivos
CHECK (numero_libro > 0 AND numero_pagina > 0 AND numero_marginal > 0);

ALTER TABLE constancia_de_fe_de_bautizo
ADD CONSTRAINT chk_roles_familiares_distintos
CHECK (feligres_bautizado_id <> padre_id AND feligres_bautizado_id <> madre_id AND padre_id <> madre_id);

ALTER TABLE constancia_de_fe_de_bautizo
ADD CONSTRAINT uq_registro_sacramental
UNIQUE (numero_libro, numero_pagina, numero_marginal);

CREATE TABLE `constancia_de_comunion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `feligres_id` INT(11) UNIQUE NOT NULL,
  `fecha_comunion` DATE NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feligres_id`) REFERENCES `feligreses`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `constancia_de_confirmacion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_confirmacion` DATE NOT NULL,
  `feligres_confirmado_id` INT(11) UNIQUE NOT NULL,
  `padre_1_id` INT(11) NOT NULL,
  `padre_2_id` INT(11) NOT NULL,
  `padrino_nombre` varchar(100) NOT NULL,
  `ministro_id` INT(11) NOT NULL,
  `numero_libro` INT(10) NOT NULL,
  `numero_pagina` INT(10) NOT NULL,
  `numero_marginal` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`feligres_confirmado_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`padre_1_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`padre_2_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`ministro_id`) REFERENCES `sacerdotes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE constancia_de_confirmacion
ADD CONSTRAINT chk_numeros_registro_positivos_confirmacion
CHECK (numero_libro > 0 AND numero_pagina > 0 AND numero_marginal > 0);

ALTER TABLE constancia_de_confirmacion
ADD CONSTRAINT chk_roles_familiares_distintos_confirmacion
CHECK (feligres_confirmado_id <> padre_1_id AND feligres_confirmado_id <> padre_2_id AND padre_1_id <> padre_2_id);

ALTER TABLE constancia_de_confirmacion
ADD CONSTRAINT uq_registro_sacramental
UNIQUE (numero_libro, numero_pagina, numero_marginal);


CREATE TABLE `constancia_de_matrimonio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `contrayente_1_id` INT(11) NOT NULL,
  `contrayente_2_id` INT(11) NOT NULL,
  `fecha_matrimonio` DATE NOT NULL,
  `testigo_1_nombre` varchar(100) NOT NULL,
  `testigo_2_nombre` varchar(100) NOT NULL,
  `ministro_id` INT(11) NOT NULL,
  `numero_libro` INT(10) NOT NULL,
  `numero_pagina` INT(10) NOT NULL,
  `numero_marginal` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`contrayente_1_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`contrayente_2_id`) REFERENCES `feligreses`(`id`),
  FOREIGN KEY (`ministro_id`) REFERENCES `sacerdotes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE constancia_de_matrimonio
ADD CONSTRAINT chk_numeros_registro_positivos_matrimonio
CHECK (numero_libro > 0 AND numero_pagina > 0 AND numero_marginal > 0);

ALTER TABLE constancia_de_matrimonio
ADD CONSTRAINT chk_roles_matrimonio_distintos
CHECK (
    contrayente_1_id <> contrayente_2_id
);

ALTER TABLE constancia_de_matrimonio
ADD CONSTRAINT uq_registro_sacramental
UNIQUE (numero_libro, numero_pagina, numero_marginal);


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);


--
-- Indices de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objeto_de_peticion_id` (`objeto_de_peticion_id`),
  ADD KEY `realizado_por_id` (`realizado_por_id`),
  ADD KEY `tipo_de_intencion_id` (`tipo_de_intencion_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

ALTER TABLE `categoria_de_servicios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `categoria_de_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `tipo_de_intencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- Restricciones para tablas volcadas
--


ALTER TABLE `feligreses`
ADD CONSTRAINT `chk_cedula_partida_nacimiento` CHECK (
    `cedula` IS NOT NULL OR `partida_de_nacimiento` IS NOT NULL
);
--
-- Filtros para la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD CONSTRAINT `peticiones_ibfk_2` FOREIGN KEY (`objeto_de_peticion_id`) REFERENCES `objetos_de_peticion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_3` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_4` FOREIGN KEY (`tipo_de_intencion_id`) REFERENCES `tipo_de_intencion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peticiones_ibfk_5` FOREIGN KEY (`realizado_por_id`) REFERENCES `administrador` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT chk_fechas_peticion CHECK (fecha_inicio <= fecha_fin),
  ADD CONSTRAINT `chk_intencion_y_participantes` CHECK (
      (`tipo_de_intencion_id` IS NOT NULL AND `objeto_de_peticion_id` IS NOT NULL)
      OR
      (`tipo_de_intencion_id` IS NULL AND `objeto_de_peticion_id` IS NULL)
  ),
  ADD CONSTRAINT `chk_tipo_de_intencion_servicio` CHECK (
    (`servicio_id` != 1 AND `tipo_de_intencion_id` IS NULL) OR
    (`servicio_id` = 1 AND `tipo_de_intencion_id` IS NOT NULL)
  );

ALTER TABLE `peticiones`
ADD COLUMN `constancia_de_fe_de_bautizo_id` INT NULL,
ADD COLUMN `constancia_de_confirmacion_id` INT NULL,
ADD COLUMN `constancia_de_comunion_id` INT NULL,
ADD COLUMN `constancia_de_matrimonio_id` INT NULL,
ADD FOREIGN KEY (`constancia_de_fe_de_bautizo_id`) REFERENCES `constancia_de_fe_de_bautizo` (`id`),
ADD FOREIGN KEY (`constancia_de_confirmacion_id`) REFERENCES `constancia_de_confirmacion` (`id`),
ADD FOREIGN KEY (`constancia_de_comunion_id`) REFERENCES `constancia_de_comunion` (`id`),
ADD FOREIGN KEY (`constancia_de_matrimonio_id`) REFERENCES `constancia_de_matrimonio` (`id`);

ALTER TABLE `peticiones`
ADD UNIQUE KEY (`constancia_de_fe_de_bautizo_id`),
ADD UNIQUE KEY (`constancia_de_confirmacion_id`),
ADD UNIQUE KEY (`constancia_de_comunion_id`),
ADD UNIQUE KEY (`constancia_de_matrimonio_id`);

ALTER TABLE `peticiones`
  ADD CONSTRAINT `chk_servicio_constancias` CHECK (
    (`servicio_id` = 2 AND `constancia_de_fe_de_bautizo_id` IS NOT NULL AND `constancia_de_comunion_id` IS NULL AND `constancia_de_confirmacion_id` IS NULL AND `constancia_de_matrimonio_id` IS NULL) OR
    (`servicio_id` = 3 AND `constancia_de_comunion_id` IS NOT NULL AND `constancia_de_fe_de_bautizo_id` IS NULL AND `constancia_de_confirmacion_id` IS NULL AND `constancia_de_matrimonio_id` IS NULL) OR
    (`servicio_id` = 4 AND `constancia_de_confirmacion_id` IS NOT NULL AND `constancia_de_fe_de_bautizo_id` IS NULL AND `constancia_de_comunion_id` IS NULL AND `constancia_de_matrimonio_id` IS NULL) OR
    (`servicio_id` = 5 AND `constancia_de_matrimonio_id` IS NOT NULL AND `constancia_de_fe_de_bautizo_id` IS NULL AND `constancia_de_comunion_id` IS NULL AND `constancia_de_confirmacion_id` IS NULL) OR
    (`servicio_id` NOT IN (2, 3, 4, 5) AND `constancia_de_fe_de_bautizo_id` IS NULL AND `constancia_de_comunion_id` IS NULL AND `constancia_de_confirmacion_id` IS NULL AND `constancia_de_matrimonio_id` IS NULL)
);

ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_de_servicios` (`id`) ON DELETE CASCADE;

--
-- Volcado de datos para la tabla `peticiones`
--

CREATE TABLE `peticion_misa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `peticion_id` int(11) NOT NULL,
  `misa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`peticion_id`) REFERENCES `peticiones`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`misa_id`) REFERENCES `misas`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `idx_peticion_misa_unica` (`peticion_id`, `misa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
