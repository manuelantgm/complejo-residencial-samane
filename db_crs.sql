-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 01-04-2026 a las 20:10:40
-- Versión del servidor: 9.1.0
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_crs`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_comercial` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `direccion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `rnc` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `banco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `tipo_cuenta` int DEFAULT NULL,
  `numero_cuenta` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre_comercial`, `direccion`, `telefono`, `descripcion`, `email`, `rnc`, `banco`, `tipo_cuenta`, `numero_cuenta`, `img`, `status`) VALUES
(1, 'JUNTA DE VECINOS ALTOS DE LOS SAMANES, INC', 'Carretera Licey, #51, Santiago, Rep. Dom.', '(849) 394-7647', 'Junta De vecinos', 'altosdelossamanesrd@gmail.com', '430391123', 'Banco Popular', 1, '842553489', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contracts`
--

DROP TABLE IF EXISTS `contracts`;
CREATE TABLE IF NOT EXISTS `contracts` (
  `id_contract` int NOT NULL AUTO_INCREMENT,
  `id_employee` int NOT NULL,
  `contract_type` enum('fijo','temporal','practicante') CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id_contract`),
  KEY `id_employee` (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days`
--

DROP TABLE IF EXISTS `days`;
CREATE TABLE IF NOT EXISTS `days` (
  `id_day` int NOT NULL AUTO_INCREMENT,
  `day` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_day`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `days`
--

INSERT INTO `days` (`id_day`, `day`, `start_time`, `end_time`, `status`) VALUES
(1, 'Lunes', '00:00:00', '00:00:00', 1),
(2, 'Martes', '00:00:00', '00:00:00', 1),
(3, 'Miércoles', '00:00:00', '00:00:00', 1),
(4, 'Jueves', '00:00:00', '00:00:00', 1),
(5, 'Viernes', '00:00:00', '00:00:00', 1),
(6, 'Sábado', '00:00:00', '00:00:00', 1),
(7, 'Domingo', '00:00:00', '00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id_employee` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `names` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_names` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identification` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_type` int NOT NULL,
  `ocupation_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_employee`),
  UNIQUE KEY `uq_employees_identification` (`identification`),
  UNIQUE KEY `identification` (`identification`),
  UNIQUE KEY `passport` (`passport`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id_employee`, `user_id`, `names`, `last_names`, `identification`, `passport`, `employee_type`, `ocupation_id`, `created_at`, `status`) VALUES
(1, 1, 'JORGE', 'MENDOZA', '40265925646', '', 1, 3, '2026-03-31 20:27:45', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_workdays`
--

DROP TABLE IF EXISTS `employee_workdays`;
CREATE TABLE IF NOT EXISTS `employee_workdays` (
  `id_workday` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `day_id` tinyint NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_workday`),
  UNIQUE KEY `uq_employee_day` (`employee_id`,`day_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `employee_workdays`
--

INSERT INTO `employee_workdays` (`id_workday`, `employee_id`, `day_id`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(11, 1, 1, '08:27:00', '16:30:00', '2026-04-01 15:03:54', '2026-04-01 15:03:54'),
(12, 1, 2, '13:00:00', '18:00:00', '2026-04-01 15:03:54', '2026-04-01 15:03:54'),
(13, 1, 3, '08:47:00', '17:00:00', '2026-04-01 15:03:54', '2026-04-01 15:03:54'),
(14, 1, 4, '08:00:00', '12:00:00', '2026-04-01 15:03:54', '2026-04-01 15:03:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `families`
--

DROP TABLE IF EXISTS `families`;
CREATE TABLE IF NOT EXISTS `families` (
  `id_family` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `relationship` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_family`),
  KEY `id_person` (`user_id`),
  KEY `person_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `families`
--

INSERT INTO `families` (`id_family`, `user_id`, `relationship`, `status`) VALUES
(1, 1, 'HIJO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

DROP TABLE IF EXISTS `modulo`;
CREATE TABLE IF NOT EXISTS `modulo` (
  `idmodulo` bigint NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idmodulo`),
  KEY `titulo` (`titulo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Dashboard', 'Tablero principal', 1),
(2, 'Usuarios', 'Usuarios del sistema', 1),
(3, 'Familiares', 'Todas las cuentas', 1),
(4, 'Empleados', 'Pagos y/o cobros', 1),
(5, 'Visitas', 'Generar, editar y consultar factaruas', 1),
(6, 'Vehiculos', 'Procesos contables', 1),
(7, 'Configuracion', 'Configuracion, perfil empresarial', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocupations`
--

DROP TABLE IF EXISTS `ocupations`;
CREATE TABLE IF NOT EXISTS `ocupations` (
  `id_ocupation` int NOT NULL AUTO_INCREMENT,
  `ocupation` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_ocupation`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ocupations`
--

INSERT INTO `ocupations` (`id_ocupation`, `ocupation`, `status`) VALUES
(1, 'Domestica', 1),
(2, 'Chofer', 1),
(3, 'Jardinero', 1),
(4, 'Mensajero', 1),
(5, 'Electricista', 1),
(6, 'Plomero', 1),
(7, 'Veterinario', 1),
(8, 'Arquitecto', 1),
(9, 'Ingeniero', 1),
(10, 'Maestro constructor', 1),
(11, 'Pintor', 1),
(12, 'Supervisor de area', 1),
(13, 'Picero', 1),
(14, 'Carpintero', 1),
(15, 'Soldador', 1),
(16, 'Yesero', 1),
(17, 'Instalador de ventanas y puert', 1),
(18, 'Instalador de pisos y cerámica', 1),
(19, 'Montador de estructuras metáli', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `idpermiso` bigint NOT NULL AUTO_INCREMENT,
  `rolid` bigint NOT NULL,
  `moduloid` bigint NOT NULL,
  `r` int NOT NULL DEFAULT '0',
  `w` int NOT NULL DEFAULT '0',
  `u` int NOT NULL DEFAULT '0',
  `d` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idpermiso`),
  KEY `rolid` (`rolid`),
  KEY `moduloid` (`moduloid`),
  KEY `moduloid_2` (`moduloid`),
  KEY `rolid_2` (`rolid`),
  KEY `rolid_3` (`rolid`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(25, 1, 1, 1, 1, 1, 1),
(26, 1, 2, 1, 1, 1, 1),
(27, 1, 3, 1, 1, 1, 1),
(28, 1, 4, 1, 1, 1, 1),
(29, 1, 5, 1, 1, 1, 1),
(30, 1, 6, 0, 0, 0, 0),
(31, 1, 7, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persons`
--

DROP TABLE IF EXISTS `persons`;
CREATE TABLE IF NOT EXISTS `persons` (
  `id_person` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `legal_age` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_id` int NOT NULL,
  `home_number` int NOT NULL,
  `passport` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('familia','empleado','visita') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_person`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `persons`
--

INSERT INTO `persons` (`id_person`, `user_id`, `legal_age`, `name`, `last_name`, `identification`, `street_id`, `home_number`, `passport`, `phone`, `type`, `email`, `password`, `status`) VALUES
(1, 1, 1, 'MANUEL ANTONIO', 'GOMEZ MARTINEZ', '21656265626', 1, 35, NULL, '18097530275', 'familia', 'manuelantg@email.com', '732b6ed2a4fc9237558144ffa22debf8dfa3385c563b696b10cdf53c9d4c89d9', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `idpost` bigint NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `contenido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `portada` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `datecreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ruta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idpost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `idrol` bigint NOT NULL AUTO_INCREMENT,
  `nombrerol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Super administrador', 'Acceso a todo el sistema', 1),
(2, 'Administrador', 'Encargado de mantenimiento', 1),
(3, 'Propietario', 'Todos los propietarios', 1),
(4, 'Contable', 'Contador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stages`
--

DROP TABLE IF EXISTS `stages`;
CREATE TABLE IF NOT EXISTS `stages` (
  `id_stage` int NOT NULL AUTO_INCREMENT,
  `stage` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_stage`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `stages`
--

INSERT INTO `stages` (`id_stage`, `stage`, `status`) VALUES
(1, 'Los Samanes', 1),
(2, 'Samanes Residences', 1),
(3, 'Altos De Los Samanes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `streets`
--

DROP TABLE IF EXISTS `streets`;
CREATE TABLE IF NOT EXISTS `streets` (
  `id_street` int NOT NULL AUTO_INCREMENT,
  `street` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `stage_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_street`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `streets`
--

INSERT INTO `streets` (`id_street`, `street`, `stage_id`, `status`) VALUES
(1, 'El Guayacan', 1, 1),
(2, 'Las Amapolas', 1, 1),
(3, 'Las Lilas', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_family`
--

DROP TABLE IF EXISTS `user_family`;
CREATE TABLE IF NOT EXISTS `user_family` (
  `id_user_family` int NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint NOT NULL,
  `id_person` int NOT NULL,
  `relationship` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id_user_family`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_person` (`id_person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuario` bigint NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `nombres` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `apellidos` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `telefono` bigint NOT NULL,
  `email_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `direccion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `stage_id` int NOT NULL,
  `calleid` int NOT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `rolid` bigint NOT NULL,
  `image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT 'default_profile.jpg',
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idusuario`),
  KEY `calleid` (`calleid`),
  KEY `rolid` (`rolid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `identificacion`, `nombres`, `apellidos`, `telefono`, `email_user`, `password`, `direccion`, `stage_id`, `calleid`, `token`, `rolid`, `image`, `datecreated`, `status`) VALUES
(1, '03104828524', 'MANUEL ANT', 'GOMEZ', 18297645536, 'info@gomezsys.net', 'e7c091165805a5da6b24b5b60e350834d700ee9dbc3088ea24d299dfc8cbd1c2', 'Santiago, Rep. Dom.', 1, 1, NULL, 1, 'default_profile.jpg', '2024-04-17 11:53:58', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE IF NOT EXISTS `visits` (
  `id_visit` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `names` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_names` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `identification` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_visit`),
  KEY `id_person` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `visits`
--

INSERT INTO `visits` (`id_visit`, `user_id`, `names`, `last_names`, `identification`, `passport`, `status`) VALUES
(1, 1, 'CARLOS', 'MENDEZ', '03104828524', '', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `families`
--
ALTER TABLE `families`
  ADD CONSTRAINT `families_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `persons` (`id_person`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`moduloid`) REFERENCES `modulo` (`idmodulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `persons_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
