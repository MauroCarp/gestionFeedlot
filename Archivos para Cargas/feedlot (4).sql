-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-11-2020 a las 18:12:39
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `feedlot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `causas`
--

DROP TABLE IF EXISTS `causas`;
CREATE TABLE IF NOT EXISTS `causas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `causa` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `causas`
--

INSERT INTO `causas` (`id`, `causa`) VALUES
(1, 'NEUMO'),
(2, 'TERNERO'),
(3, 'OVERO'),
(4, 'VACA '),
(5, 'SIN DIAGN'),
(6, 'RECHAZO'),
(7, 'CAPADA'),
(8, '1Âº SEMANA'),
(9, 'ACIDOSIS'),
(10, 'SIN HALLAZGO'),
(11, 'ACCIDENTE'),
(12, 'ENFERMERIA'),
(13, 'INTOXICADO'),
(14, 'PERROS'),
(15, 'CALOR'),
(16, 'BOSA'),
(17, 'CAMPO'),
(18, 'DIGESTIVO'),
(19, 'MUERTE SUBITA'),
(20, 'TEMPORAL'),
(21, 'RAYO'),
(22, 'TIO'),
(23, 'INFECCION'),
(24, 'HEMORRAGIA'),
(25, 'INFARTO'),
(26, 'FLACO'),
(27, 'GOLPES'),
(28, 'PROLACSO'),
(29, 'INGRESO'),
(30, 'AHOGADO'),
(31, 'MANCHA'),
(32, 'RESPIRATORIO'),
(33, 'BARRO'),
(34, 'SACRIF/FASSANO'),
(35, 'SACRIFICADO'),
(36, ''),
(37, '1 SEMANA'),
(38, 'DETALLE PROX.PLANILLA'),
(39, 'PROLAPSO'),
(40, 'SOBRE CARGA'),
(41, 'MAL ESTADO'),
(42, 'SIST.NERVIOSO'),
(43, 'GANCRENA PATAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

DROP TABLE IF EXISTS `egresos`;
CREATE TABLE IF NOT EXISTS `egresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(100) NOT NULL,
  `tropa` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `IDE` varchar(150) DEFAULT NULL,
  `LID` varchar(150) DEFAULT NULL,
  `proveedor` varchar(150) DEFAULT NULL,
  `numeroDTE` int(10) DEFAULT NULL,
  `origen` varchar(150) DEFAULT NULL,
  `gdmTotal` varchar(10) DEFAULT NULL,
  `gpvTotal` varchar(10) DEFAULT NULL,
  `diasTotal` int(10) DEFAULT NULL,
  `estadoTropa` varchar(150) DEFAULT NULL,
  `estado` varchar(150) DEFAULT NULL,
  `statusDate` date DEFAULT NULL,
  `grupo` varchar(150) DEFAULT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `sexo` varchar(150) DEFAULT NULL,
  `destino` varchar(100) DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `notas` varchar(200) DEFAULT NULL,
  `caravanaValida` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `egresos`
--

INSERT INTO `egresos` (`id`, `feedlot`, `tropa`, `fecha`, `hora`, `IDE`, `LID`, `proveedor`, `numeroDTE`, `origen`, `gdmTotal`, `gpvTotal`, `diasTotal`, `estadoTropa`, `estado`, `statusDate`, `grupo`, `raza`, `sexo`, `destino`, `peso`, `notas`, `caravanaValida`) VALUES
(1, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:52:32', '982 126053809514', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 453, 'Sin Registro', 0),
(2, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:52:52', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 566, 'Sin Registro', 0),
(3, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:53:09', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 491, 'Sin Registro', 0),
(4, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:53:30', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 492, 'Sin Registro', 0),
(5, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:53:51', '982 126058229242', NULL, 'Salvucci', 2240, 'Corrientes', '1,57', '198', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 530, 'Sin Registro', 0),
(6, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:54:16', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 562, 'Sin Registro', 0),
(7, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:54:35', '982 126058225616', NULL, 'Salvucci', 6550, 'Gral belgrano bs as', '1,57', '137', 87, NULL, NULL, NULL, NULL, 'Angus', 'Macho', 'Cotrol prueva', 530, 'Sin Registro', 0),
(8, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:58:39', '982 126058229040', NULL, 'Salvucci', 4918, 'Formosa', '2,09', '228', 109, NULL, NULL, NULL, NULL, 'Cruza', 'Macho', 'Fasano', 516, 'Sin Registro', 0),
(9, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:59:05', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 592, 'Sin Registro', 0),
(10, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '14:59:26', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 465, 'Sin Registro', 0),
(11, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:03:13', '982 126053809262', NULL, 'Salvucci', 2240, 'Corrientes', '0,71', '89', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 457, 'Sin Registro', 0),
(12, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:03:26', '982 126058225000', NULL, 'Salvucci', 2240, 'Corrientes', '1,37', '172', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 538, 'Sin Registro', 0),
(13, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:03:41', '982 126058225503', NULL, 'Salvucci', 4918, 'Formosa', '1,04', '113', 109, NULL, NULL, NULL, NULL, 'Cruza', 'Macho', 'Fasano', 491, 'Sin Registro', 0),
(14, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:03:56', '982 126053792931', NULL, 'Fassano', 8631, 'Goya c.tes', '1,77', '156', 88, NULL, NULL, NULL, NULL, 'Braford', 'Macho', 'Fasano', 471, 'Sin Registro', 0),
(15, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:04:42', '982 126058224746', NULL, 'Salvucci', 3897, 'Corrientes', '1,45', '177', 122, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 524, 'Sin Registro', 0),
(16, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:05:02', '982 126058229311', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 532, 'Sin Registro', 0),
(17, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:05:18', '982 126058229674', NULL, 'Salvucci', 2240, 'Corrientes', '1,3', '164', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 516, 'Sin Registro', 0),
(18, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:05:35', '982 126058229741', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 476, 'Sin Registro', 0),
(19, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:06:06', '982 126058225628', NULL, 'Fassano', 8638, 'Corrientes', '1,31', '230', 175, NULL, NULL, NULL, NULL, 'Braford', 'Macho', 'Fasano', 514, 'Sin Registro', 0),
(20, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:06:30', '982 126058224772', NULL, 'Salvucci', 2240, 'Corrientes', '1,44', '181', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 520, 'Sin Registro', 0),
(21, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:06:54', '982 126053808497', NULL, 'Salvucci', 3897, 'Corrientes', '1,76', '215', 122, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 534, 'Sin Registro', 0),
(22, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:07:12', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 508, 'Sin Registro', 0),
(23, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:08:25', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 492, 'Sin Registro', 0),
(24, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:09:24', '982 126058228803', NULL, 'Fassano', 5626, 'Santa fe', '1,47', '239', 163, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 477, 'Sin Registro', 0),
(25, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:10:01', '982 126058224783', NULL, 'Fassano', 8638, 'Corrientes', '1,14', '199', 175, NULL, NULL, NULL, NULL, 'Braford', 'Macho', 'Fasano', 471, 'Sin Registro', 0),
(26, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:10:24', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 504, 'Sin Registro', 0),
(27, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:11:05', '982 126058225526', NULL, 'Salvucci', 3897, 'Corrientes', '1,48', '181', 122, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 536, 'Sin Registro', 0),
(28, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:11:31', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 500, 'Sin Registro', 0),
(29, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:11:59', '982 126058229624', NULL, 'Salvucci', 2240, 'Corrientes', '1,13', '143', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 506, 'Sin Registro', 0),
(30, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:12:17', '982 126053792555', NULL, 'Salvucci', 2240, 'Corrientes', '1,13', '142', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 518, 'Sin Registro', 0),
(31, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:14:34', '982 126058225245', NULL, 'Fassano', 8631, 'Goya c.tes', '1,3', '114', 88, NULL, NULL, NULL, NULL, 'Braford', 'Macho', 'Fasano', 562, 'Sin Registro', 0),
(32, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:15:01', 'Sin Registro', NULL, 'Sin Registro', 0, 'Sin Registro', '0', '0', 0, NULL, NULL, NULL, NULL, 'Sin Registro', 'Sin Registro', 'Sin Registro', 477, 'Sin Registro', 0),
(33, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:15:55', '982 126053792704', NULL, 'Salvucci', 3897, 'Corrientes', '1,7', '207', 122, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 534, 'Sin Registro', 0),
(34, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', '15:16:23', '982 126058229191', NULL, 'Salvucci', 2240, 'Corrientes', '1', '126', 126, NULL, NULL, NULL, NULL, 'Hereford', 'Macho', 'Fasano', 524, 'Sin Registro', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulas`
--

DROP TABLE IF EXISTS `formulas`;
CREATE TABLE IF NOT EXISTS `formulas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `agua` float NOT NULL,
  `precio` float NOT NULL,
  `p1` varchar(150) DEFAULT NULL,
  `por1` float DEFAULT NULL,
  `p2` varchar(150) DEFAULT NULL,
  `por2` float DEFAULT NULL,
  `p3` varchar(150) DEFAULT NULL,
  `por3` float DEFAULT NULL,
  `p4` varchar(150) DEFAULT NULL,
  `por4` float DEFAULT NULL,
  `p5` varchar(150) DEFAULT NULL,
  `por5` float DEFAULT NULL,
  `p6` varchar(150) DEFAULT NULL,
  `por6` float DEFAULT NULL,
  `p7` varchar(150) DEFAULT NULL,
  `por7` float DEFAULT NULL,
  `p8` varchar(150) DEFAULT NULL,
  `por8` float DEFAULT NULL,
  `p9` varchar(150) DEFAULT NULL,
  `por9` float DEFAULT NULL,
  `p10` varchar(150) DEFAULT NULL,
  `por10` float DEFAULT NULL,
  `p11` varchar(150) DEFAULT NULL,
  `por11` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `formulas`
--

INSERT INTO `formulas` (`id`, `fecha`, `nombre`, `tipo`, `agua`, `precio`, `p1`, `por1`, `p2`, `por2`, `p3`, `por3`, `p4`, `por4`, `p5`, `por5`, `p6`, `por6`, `p7`, `por7`, `p8`, `por8`, `p9`, `por9`, `p10`, `por10`, `p11`, `por11`) VALUES
(1, '2020-11-19', 'Formula 1', 'Tipo1', 0, 1.6, '2', 40, '1', 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE IF NOT EXISTS `ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(100) NOT NULL,
  `tropa` varchar(150) DEFAULT NULL,
  `adpv` float DEFAULT 0,
  `renspa` varchar(150) DEFAULT NULL,
  `LID` varchar(150) DEFAULT NULL,
  `IDE` varchar(100) DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `sexo` varchar(50) DEFAULT NULL,
  `numDTE` varchar(100) DEFAULT NULL,
  `estadoTropa` varchar(100) DEFAULT NULL,
  `estadoAnimal` varchar(150) DEFAULT NULL,
  `origen` varchar(100) DEFAULT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `notas` varchar(500) DEFAULT NULL,
  `corral` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `destino` varchar(150) DEFAULT NULL,
  `estado` varchar(150) DEFAULT NULL,
  `statusDate` date DEFAULT NULL,
  `grupo` varchar(150) DEFAULT NULL,
  `caravanaValida` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `feedlot`, `tropa`, `adpv`, `renspa`, `LID`, `IDE`, `peso`, `raza`, `sexo`, `numDTE`, `estadoTropa`, `estadoAnimal`, `origen`, `proveedor`, `notas`, `corral`, `fecha`, `hora`, `destino`, `estado`, `statusDate`, `grupo`, `caravanaValida`) VALUES
(1, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225418', 367, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:54:14', NULL, NULL, NULL, NULL, 0),
(2, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225563', 336, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:54:28', NULL, NULL, NULL, NULL, 0),
(3, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225078', 320, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:54:53', NULL, NULL, NULL, NULL, 0),
(4, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058228853', 322, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:55:05', NULL, NULL, NULL, NULL, 0),
(5, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126053808464', 370, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:55:24', NULL, NULL, NULL, NULL, 0),
(6, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126053808447', 341, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:55:39', NULL, NULL, NULL, NULL, 0),
(7, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058229391', 370, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:55:53', NULL, NULL, NULL, NULL, 0),
(8, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225152', 324, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '08:56:07', NULL, NULL, NULL, NULL, 0),
(9, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126053808739', 354, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:02:20', NULL, NULL, NULL, NULL, 0),
(10, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225554', 324, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:03:31', NULL, NULL, NULL, NULL, 0),
(11, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058229490', 362, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:03:51', NULL, NULL, NULL, NULL, 0),
(12, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126053809619', 327, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:04:05', NULL, NULL, NULL, NULL, 0),
(13, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225038', 363, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:04:19', NULL, NULL, NULL, NULL, 0),
(14, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058229100', 292, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:04:47', NULL, NULL, NULL, NULL, 0),
(15, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225206', 245, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:05:21', NULL, NULL, NULL, NULL, 0),
(16, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126053792661', 326, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:05:34', NULL, NULL, NULL, NULL, 0),
(17, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126053792551', 343, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:05:52', NULL, NULL, NULL, NULL, 0),
(18, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058224941', 328, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:06:04', NULL, NULL, NULL, NULL, 0),
(19, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058229904', 336, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:10:27', NULL, NULL, NULL, NULL, 0),
(20, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126053809397', 370, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:10:41', NULL, NULL, NULL, NULL, 0),
(21, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225127', 331, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:10:55', NULL, NULL, NULL, NULL, 0),
(22, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058228376', 337, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:11:07', NULL, NULL, NULL, NULL, 0),
(23, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058228835', 317, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:11:27', NULL, NULL, NULL, NULL, 0),
(24, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058229461', 339, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:11:40', NULL, NULL, NULL, NULL, 0),
(25, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058229096', 355, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:11:59', NULL, NULL, NULL, NULL, 0),
(26, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', 0, '', NULL, '982 126058225135', 284, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-09-16', '09:12:16', NULL, NULL, NULL, NULL, 0),
(27, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225418', 367, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:54:14', NULL, NULL, NULL, NULL, 0),
(28, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225563', 336, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:54:28', NULL, NULL, NULL, NULL, 0),
(29, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225078', 320, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:54:53', NULL, NULL, NULL, NULL, 0),
(30, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058228853', 322, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:55:05', NULL, NULL, NULL, NULL, 0),
(31, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126053808464', 370, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:55:24', NULL, NULL, NULL, NULL, 0),
(32, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126053808447', 341, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:55:39', NULL, NULL, NULL, NULL, 0),
(33, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058229391', 370, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:55:53', NULL, NULL, NULL, NULL, 0),
(34, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225152', 324, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '08:56:07', NULL, NULL, NULL, NULL, 0),
(35, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126053808739', 354, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:02:20', NULL, NULL, NULL, NULL, 0),
(36, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225554', 324, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:03:31', NULL, NULL, NULL, NULL, 0),
(37, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058229490', 362, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:03:51', NULL, NULL, NULL, NULL, 0),
(38, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126053809619', 327, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:04:05', NULL, NULL, NULL, NULL, 0),
(39, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225038', 363, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:04:19', NULL, NULL, NULL, NULL, 0),
(40, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058229100', 292, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:04:47', NULL, NULL, NULL, NULL, 0),
(41, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225206', 245, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:05:21', NULL, NULL, NULL, NULL, 0),
(42, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126053792661', 326, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:05:34', NULL, NULL, NULL, NULL, 0),
(43, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126053792551', 343, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:05:52', NULL, NULL, NULL, NULL, 0),
(44, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058224941', 328, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:06:04', NULL, NULL, NULL, NULL, 0),
(45, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058229904', 336, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:10:27', NULL, NULL, NULL, NULL, 0),
(46, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126053809397', 370, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:10:41', NULL, NULL, NULL, NULL, 0),
(47, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225127', 331, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:10:55', NULL, NULL, NULL, NULL, 0),
(48, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058228376', 337, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:11:07', NULL, NULL, NULL, NULL, 0),
(49, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058228835', 317, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:11:27', NULL, NULL, NULL, NULL, 0),
(50, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058229461', 339, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:11:40', NULL, NULL, NULL, NULL, 0),
(51, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058229096', 355, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:11:59', NULL, NULL, NULL, NULL, 0),
(52, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', 0, '', NULL, '982 126058225135', 284, 'Braford', 'Hembra', '9515', NULL, 'Regular', 'Vera santa fe', 'Fassano', '', '21', '2020-08-10', '09:12:16', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

DROP TABLE IF EXISTS `insumos`;
CREATE TABLE IF NOT EXISTS `insumos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(130) NOT NULL,
  `insumo` varchar(150) NOT NULL,
  `precio` float NOT NULL,
  `porceMS` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id`, `feedlot`, `insumo`, `precio`, `porceMS`, `fecha`) VALUES
(1, 'Acopiadora Hoteleria', 'Maiz', 2, 80, '2020-11-19'),
(2, 'Acopiadora Hoteleria', 'Cascara de Mani', 1, 100, '2020-11-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(120) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `feedlot`, `tipo`) VALUES
(11, 'SuperRural', 'balanza'),
(12, 'Acopiadora Pampeana', 'balanza'),
(13, 'Acopiadora Hoteleria', 'balanza\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mixer_cargas`
--

DROP TABLE IF EXISTS `mixer_cargas`;
CREATE TABLE IF NOT EXISTS `mixer_cargas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archivo` varchar(100) DEFAULT NULL,
  `mixer` varchar(150) DEFAULT NULL,
  `id_carga` int(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ingrediente` varchar(150) DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `ideal` int(10) DEFAULT NULL,
  `id_receta` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mixer_cargas`
--

INSERT INTO `mixer_cargas` (`id`, `archivo`, `mixer`, `id_carga`, `fecha`, `hora`, `ingrediente`, `cantidad`, `ideal`, `id_receta`) VALUES
(1, 'mixer2.xlsx', 'mixer2', 0, '2020-06-15', '09:46:00', 'CascaraMani     ', 600, NULL, NULL),
(2, 'mixer2.xlsx', 'mixer2', 0, '2020-06-15', '09:46:00', 'Maiz            ', 4560, NULL, NULL),
(3, 'mixer2.xlsx', 'mixer2', 0, '2020-06-15', '09:46:00', 'Concentrado     ', 590, NULL, NULL),
(4, 'mixer2.xlsx', 'mixer2', 1, '2020-06-15', '10:52:00', 'CascaraMani     ', 610, NULL, NULL),
(5, 'mixer2.xlsx', 'mixer2', 1, '2020-06-15', '10:52:00', 'Maiz            ', 4700, NULL, NULL),
(6, 'mixer2.xlsx', 'mixer2', 1, '2020-06-15', '10:52:00', 'Concentrado     ', 640, NULL, NULL),
(7, 'mixer2.xlsx', 'mixer2', 1, '2020-06-15', '11:27:00', 'CascaraMani     ', 0, NULL, NULL),
(8, 'mixer2.xlsx', 'mixer2', 1, '2020-06-15', '11:27:00', 'Maiz            ', 0, NULL, NULL),
(9, 'mixer2.xlsx', 'mixer2', 1, '2020-06-15', '11:27:00', 'Concentrado     ', 0, NULL, NULL),
(10, 'mixer2.xlsx', 'mixer2', 2, '2020-06-15', '11:54:00', 'CascaraMani     ', 600, NULL, NULL),
(11, 'mixer2.xlsx', 'mixer2', 2, '2020-06-15', '11:54:00', 'Maiz            ', 4510, NULL, NULL),
(12, 'mixer2.xlsx', 'mixer2', 2, '2020-06-15', '11:54:00', 'Concentrado     ', 630, NULL, NULL),
(13, 'mixer2.xlsx', 'mixer2', 3, '2020-06-25', '10:58:00', 'CascaraMani     ', 590, NULL, NULL),
(14, 'mixer2.xlsx', 'mixer2', 3, '2020-06-25', '10:58:00', 'Maiz            ', 4510, NULL, NULL),
(15, 'mixer2.xlsx', 'mixer2', 3, '2020-06-25', '10:58:00', 'Concentrado     ', 610, NULL, NULL),
(16, 'mixer2.xlsx', 'mixer2', 3, '2020-06-25', '11:28:00', 'CascaraMani     ', 10, NULL, NULL),
(17, 'mixer2.xlsx', 'mixer2', 3, '2020-06-25', '11:28:00', 'Maiz            ', 0, NULL, NULL),
(18, 'mixer2.xlsx', 'mixer2', 3, '2020-06-25', '11:28:00', 'Concentrado     ', 0, NULL, NULL),
(19, 'mixer2.xlsx', 'mixer2', 4, '2020-06-25', '12:00:00', 'CascaraMani     ', 590, NULL, NULL),
(20, 'mixer2.xlsx', 'mixer2', 4, '2020-06-25', '12:00:00', 'Maiz            ', 4520, NULL, NULL),
(21, 'mixer2.xlsx', 'mixer2', 4, '2020-06-25', '12:00:00', 'Concentrado     ', 620, NULL, NULL),
(22, 'mixer2.xlsx', 'mixer2', 4, '2020-06-25', '13:45:00', 'CascaraMani     ', 10, NULL, NULL),
(23, 'mixer2.xlsx', 'mixer2', 4, '2020-06-25', '13:45:00', 'Maiz            ', 0, NULL, NULL),
(24, 'mixer2.xlsx', 'mixer2', 4, '2020-06-25', '13:45:00', 'Concentrado     ', 0, NULL, NULL),
(25, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:17:00', 'CascaraMani     ', 0, NULL, NULL),
(26, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:17:00', 'Maiz            ', 0, NULL, NULL),
(27, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:17:00', 'Concentrado     ', 0, NULL, NULL),
(28, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:17:00', 'CascaraMani     ', 0, NULL, NULL),
(29, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:17:00', 'Maiz            ', 0, NULL, NULL),
(30, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:17:00', 'Concentrado     ', 0, NULL, NULL),
(31, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:18:00', 'CascaraMani     ', 600, NULL, NULL),
(32, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:18:00', 'Maiz            ', 4560, NULL, NULL),
(33, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:18:00', 'Concentrado     ', 630, NULL, NULL),
(34, 'mixer2.xlsx', 'mixer2', 6, '2020-07-02', '15:15:00', 'CascaraMani     ', 600, NULL, NULL),
(35, 'mixer2.xlsx', 'mixer2', 6, '2020-07-02', '15:15:00', 'Maiz            ', 4500, NULL, NULL),
(36, 'mixer2.xlsx', 'mixer2', 6, '2020-07-02', '15:15:00', 'Concentrado     ', 610, NULL, NULL),
(37, 'mixer2.xlsx', 'mixer2', 7, '2020-07-02', '16:29:00', 'CascaraMani     ', 600, NULL, NULL),
(38, 'mixer2.xlsx', 'mixer2', 7, '2020-07-02', '16:29:00', 'Maiz            ', 4540, NULL, NULL),
(39, 'mixer2.xlsx', 'mixer2', 7, '2020-07-02', '16:29:00', 'Concentrado     ', 610, NULL, NULL),
(40, 'mixer2.xlsx', 'mixer2', 8, '2020-07-08', '11:05:00', 'CascaraMani     ', 600, NULL, NULL),
(41, 'mixer2.xlsx', 'mixer2', 8, '2020-07-08', '11:05:00', 'Maiz            ', 4530, NULL, NULL),
(42, 'mixer2.xlsx', 'mixer2', 8, '2020-07-08', '11:05:00', 'Concentrado     ', 620, NULL, NULL),
(43, 'mixer2.xlsx', 'mixer2', 9, '2020-07-08', '12:05:00', 'CascaraMani     ', 580, NULL, NULL),
(44, 'mixer2.xlsx', 'mixer2', 9, '2020-07-08', '12:05:00', 'Maiz            ', 4530, NULL, NULL),
(45, 'mixer2.xlsx', 'mixer2', 9, '2020-07-08', '12:05:00', 'Concentrado     ', 620, NULL, NULL),
(46, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '12:58:00', 'CascaraMani     ', 590, NULL, NULL),
(47, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '12:58:00', 'Maiz            ', 4540, NULL, NULL),
(48, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '12:58:00', 'Concentrado     ', 610, NULL, NULL),
(49, 'mixer2.xlsx', 'mixer2', 11, '2020-07-15', '10:26:00', 'CascaraMani     ', 610, NULL, NULL),
(50, 'mixer2.xlsx', 'mixer2', 11, '2020-07-15', '10:26:00', 'Maiz            ', 4530, NULL, NULL),
(51, 'mixer2.xlsx', 'mixer2', 11, '2020-07-15', '10:26:00', 'Concentrado     ', 600, NULL, NULL),
(52, 'mixer2.xlsx', 'mixer2', 12, '2020-07-15', '12:01:00', 'CascaraMani     ', 610, NULL, NULL),
(53, 'mixer2.xlsx', 'mixer2', 12, '2020-07-15', '12:01:00', 'Maiz            ', 4520, NULL, NULL),
(54, 'mixer2.xlsx', 'mixer2', 12, '2020-07-15', '12:01:00', 'Concentrado     ', 610, NULL, NULL),
(55, 'mixer2.xlsx', 'mixer2', 13, '2020-07-15', '16:13:00', 'CascaraMani     ', 630, NULL, NULL),
(56, 'mixer2.xlsx', 'mixer2', 13, '2020-07-15', '16:13:00', 'Maiz            ', 4510, NULL, NULL),
(57, 'mixer2.xlsx', 'mixer2', 13, '2020-07-15', '16:13:00', 'Concentrado     ', 620, NULL, NULL),
(58, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '11:45:00', 'CascaraMani     ', 90, NULL, NULL),
(59, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '11:45:00', 'Maiz            ', 0, NULL, NULL),
(60, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '11:45:00', 'Concentrado     ', 0, NULL, NULL),
(61, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '11:47:00', 'CascaraMani     ', 600, NULL, NULL),
(62, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '11:47:00', 'Maiz            ', 4580, NULL, NULL),
(63, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '11:47:00', 'Concentrado     ', 660, NULL, NULL),
(64, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '14:44:00', 'CascaraMani     ', 0, NULL, NULL),
(65, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '14:44:00', 'Maiz            ', 0, NULL, NULL),
(66, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '14:44:00', 'Concentrado     ', 0, NULL, NULL),
(67, 'mixer2.xlsx', 'mixer2', 15, '2020-07-22', '15:43:00', 'CascaraMani     ', 620, NULL, NULL),
(68, 'mixer2.xlsx', 'mixer2', 15, '2020-07-22', '15:43:00', 'Maiz            ', 4520, NULL, NULL),
(69, 'mixer2.xlsx', 'mixer2', 15, '2020-07-22', '15:43:00', 'Concentrado     ', 610, NULL, NULL),
(70, 'mixer2.xlsx', 'mixer2', 16, '2020-07-22', '16:51:59', 'CascaraMani     ', 620, NULL, NULL),
(71, 'mixer2.xlsx', 'mixer2', 16, '2020-07-22', '16:51:59', 'Maiz            ', 4520, NULL, NULL),
(72, 'mixer2.xlsx', 'mixer2', 16, '2020-07-22', '16:51:59', 'Concentrado     ', 600, NULL, NULL),
(73, 'mixer2.xlsx', 'mixer2', 17, '2020-07-29', '11:41:00', 'CascaraMani     ', 620, NULL, NULL),
(74, 'mixer2.xlsx', 'mixer2', 17, '2020-07-29', '11:41:00', 'Maiz            ', 4500, NULL, NULL),
(75, 'mixer2.xlsx', 'mixer2', 17, '2020-07-29', '11:41:00', 'Concentrado     ', 610, NULL, NULL),
(76, 'mixer2.xlsx', 'mixer2', 18, '2020-07-29', '15:27:00', 'CascaraMani     ', 640, NULL, NULL),
(77, 'mixer2.xlsx', 'mixer2', 18, '2020-07-29', '15:27:00', 'Maiz            ', 4510, NULL, NULL),
(78, 'mixer2.xlsx', 'mixer2', 18, '2020-07-29', '15:27:00', 'Concentrado     ', 600, NULL, NULL),
(79, 'mixer2.xlsx', 'mixer2', 19, '2020-07-29', '16:47:59', 'CascaraMani     ', 600, NULL, NULL),
(80, 'mixer2.xlsx', 'mixer2', 19, '2020-07-29', '16:47:59', 'Maiz            ', 4520, NULL, NULL),
(81, 'mixer2.xlsx', 'mixer2', 19, '2020-07-29', '16:47:59', 'Concentrado     ', 600, NULL, NULL),
(82, 'mixer2.xlsx', 'mixer2', 20, '2020-09-29', '17:32:59', 'CascaraMani     ', 610, NULL, NULL),
(83, 'mixer2.xlsx', 'mixer2', 20, '2020-09-29', '17:32:59', 'Agua            ', 250, NULL, NULL),
(84, 'mixer2.xlsx', 'mixer2', 20, '2020-09-29', '17:32:59', 'Maiz            ', 4630, NULL, NULL),
(85, 'mixer2.xlsx', 'mixer2', 20, '2020-09-29', '17:32:59', 'Concentrado     ', 610, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mixer_descargas`
--

DROP TABLE IF EXISTS `mixer_descargas`;
CREATE TABLE IF NOT EXISTS `mixer_descargas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archivo` varchar(100) DEFAULT NULL,
  `mixer` varchar(150) NOT NULL,
  `id_carga` int(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `lote` varchar(150) DEFAULT NULL,
  `cantidad` int(10) DEFAULT NULL,
  `animales` int(10) DEFAULT NULL,
  `operario` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mixer_descargas`
--

INSERT INTO `mixer_descargas` (`id`, `archivo`, `mixer`, `id_carga`, `fecha`, `hora`, `lote`, `cantidad`, `animales`, `operario`) VALUES
(1, 'mixer2.xlsx', 'mixer2', 0, '2020-06-15', '10:26:00', 'Lote 2          ', 5890, NULL, ''),
(2, 'mixer2.xlsx', 'mixer2', 1, '2020-06-15', '11:29:00', 'Lote 2          ', 6030, NULL, ''),
(3, 'mixer2.xlsx', 'mixer2', 2, '2020-06-15', '12:31:00', 'Lote 2          ', 5840, NULL, ''),
(4, 'mixer2.xlsx', 'mixer2', 3, '2020-06-25', '11:30:00', 'Lote 2          ', 5730, NULL, ''),
(5, 'mixer2.xlsx', 'mixer2', 4, '2020-06-25', '13:45:00', 'Lote 2          ', 5760, NULL, ''),
(6, 'mixer2.xlsx', 'mixer2', 5, '2020-06-25', '14:49:00', 'Lote 2          ', 5670, NULL, ''),
(7, 'mixer2.xlsx', 'mixer2', 6, '2020-07-02', '15:59:00', 'Lote 2          ', 5740, NULL, ''),
(8, 'mixer2.xlsx', 'mixer2', 7, '2020-07-02', '16:59:00', 'Lote 2          ', 5740, NULL, ''),
(9, 'mixer2.xlsx', 'mixer2', 8, '2020-07-08', '11:37:00', 'Lote 2          ', 5730, NULL, ''),
(10, 'mixer2.xlsx', 'mixer2', 9, '2020-07-08', '12:33:00', 'Lote 2          ', 5770, NULL, ''),
(11, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 2          ', 0, NULL, ''),
(12, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 2          ', 0, NULL, ''),
(13, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 3          ', 0, NULL, ''),
(14, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 4          ', 0, NULL, ''),
(15, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 5          ', 0, NULL, ''),
(16, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 6          ', 0, NULL, ''),
(17, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 7          ', 0, NULL, ''),
(18, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 8          ', 0, NULL, ''),
(19, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 9          ', 0, NULL, ''),
(20, 'mixer2.xlsx', 'mixer2', 10, '2020-07-08', '13:25:00', 'Lote 2          ', 5730, NULL, ''),
(21, 'mixer2.xlsx', 'mixer2', 11, '2020-07-15', '11:02:00', 'Lote 2          ', 5750, NULL, ''),
(22, 'mixer2.xlsx', 'mixer2', 12, '2020-07-15', '14:35:59', 'Lote 2          ', 5670, NULL, ''),
(23, 'mixer2.xlsx', 'mixer2', 13, '2020-07-15', '17:06:00', 'Lote 2          ', 5750, NULL, ''),
(24, 'mixer2.xlsx', 'mixer2', 14, '2020-07-22', '14:46:00', 'Lote 2          ', 5820, NULL, ''),
(25, 'mixer2.xlsx', 'mixer2', 15, '2020-07-22', '16:15:00', 'Lote 2          ', 5750, NULL, ''),
(26, 'mixer2.xlsx', 'mixer2', 16, '2020-07-22', '17:19:00', 'Lote 2          ', 5590, NULL, ''),
(27, 'mixer2.xlsx', 'mixer2', 17, '2020-07-29', '14:47:00', 'Lote 2          ', 5680, NULL, ''),
(28, 'mixer2.xlsx', 'mixer2', 18, '2020-07-29', '16:01:00', 'Lote 2          ', 5690, NULL, ''),
(29, 'mixer2.xlsx', 'mixer2', 19, '2020-07-29', '17:15:00', 'Lote 2          ', 5690, NULL, ''),
(30, 'mixer2.xlsx', 'mixer2', 20, '2020-09-29', '18:23:00', 'Lote 150        ', 50, NULL, ''),
(31, 'mixer2.xlsx', 'mixer2', 20, '2020-09-29', '18:23:00', 'Lote 150        ', 5890, NULL, ''),
(32, 'mixer2.xlsx', 'mixer2', 20, '2020-09-29', '18:23:00', 'Lote 151        ', 5870, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mixer_recetas`
--

DROP TABLE IF EXISTS `mixer_recetas`;
CREATE TABLE IF NOT EXISTS `mixer_recetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_receta` int(10) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `tiempoMezcla` varchar(100) DEFAULT NULL,
  `ingrediente1` varchar(10) DEFAULT NULL,
  `cantidad1` int(10) DEFAULT NULL,
  `ingrediente2` varchar(100) DEFAULT NULL,
  `cantidad2` int(10) DEFAULT NULL,
  `ingrediente3` varchar(100) DEFAULT NULL,
  `cantidad3` int(10) DEFAULT NULL,
  `ingrediente4` varchar(100) DEFAULT NULL,
  `cantidad4` int(10) DEFAULT NULL,
  `ingrediente5` varchar(100) DEFAULT NULL,
  `cantidad5` int(10) DEFAULT NULL,
  `ingrediente6` varchar(100) DEFAULT NULL,
  `cantidad6` int(50) DEFAULT NULL,
  `ingrediente7` varchar(100) DEFAULT NULL,
  `cantidad7` int(10) DEFAULT NULL,
  `ingrediente8` varchar(100) DEFAULT NULL,
  `cantidad8` int(10) DEFAULT NULL,
  `ingrediente9` varchar(100) DEFAULT NULL,
  `cantidad9` int(10) DEFAULT NULL,
  `ingrediente10` varchar(100) DEFAULT NULL,
  `cantidad10` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `muertes`
--

DROP TABLE IF EXISTS `muertes`;
CREATE TABLE IF NOT EXISTS `muertes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IDE` varchar(150) DEFAULT NULL,
  `LID` varchar(150) DEFAULT NULL,
  `feedlot` varchar(150) NOT NULL,
  `tropa` varchar(150) DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `raza` varchar(150) DEFAULT NULL,
  `sexo` varchar(150) DEFAULT NULL,
  `proveedor` varchar(150) DEFAULT NULL,
  `corral` int(10) DEFAULT NULL,
  `origen` varchar(150) DEFAULT NULL,
  `notas` varchar(150) DEFAULT NULL,
  `gdmTotal` float DEFAULT NULL,
  `gpvTotal` float DEFAULT NULL,
  `totalDias` int(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estadoTropa` varchar(150) DEFAULT NULL,
  `estado` varchar(150) DEFAULT NULL,
  `statusDate` date DEFAULT NULL,
  `grupo` varchar(150) DEFAULT NULL,
  `causaMuerte` varchar(150) DEFAULT NULL,
  `caravanaValida` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `muertes`
--

INSERT INTO `muertes` (`id`, `IDE`, `LID`, `feedlot`, `tropa`, `peso`, `raza`, `sexo`, `proveedor`, `corral`, `origen`, `notas`, `gdmTotal`, `gpvTotal`, `totalDias`, `fecha`, `hora`, `estadoTropa`, `estado`, `statusDate`, `grupo`, `causaMuerte`, `caravanaValida`) VALUES
(1, '982 126058229827', NULL, 'Acopiadora Hoteleria', 'Muerto enfermeria', 0, NULL, 'Macho', 'Tito', 7, 'Nogoya', NULL, NULL, NULL, 96, '2020-05-17', '14:45:00', NULL, NULL, NULL, NULL, 'Respiratorio', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operarios`
--

DROP TABLE IF EXISTS `operarios`;
CREATE TABLE IF NOT EXISTS `operarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raciones`
--

DROP TABLE IF EXISTS `raciones`;
CREATE TABLE IF NOT EXISTS `raciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `turno` varchar(100) NOT NULL,
  `operario` varchar(150) NOT NULL,
  `formula` varchar(150) NOT NULL,
  `corral` int(20) NOT NULL,
  `kilos` float DEFAULT NULL,
  `redondeo` varchar(150) DEFAULT NULL,
  `redondeoAgua` int(11) DEFAULT NULL,
  `margen` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razas`
--

DROP TABLE IF EXISTS `razas`;
CREATE TABLE IF NOT EXISTS `razas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raza` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `razas`
--

INSERT INTO `razas` (`id`, `raza`) VALUES
(1, 'Braford'),
(2, 'Hereford'),
(3, 'Sin Registro'),
(4, 'Angus'),
(5, 'Cruza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registroegresos`
--

DROP TABLE IF EXISTS `registroegresos`;
CREATE TABLE IF NOT EXISTS `registroegresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(150) DEFAULT NULL,
  `tropa` varchar(150) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` int(100) DEFAULT NULL,
  `pesoPromedio` float DEFAULT NULL,
  `destino` varchar(150) DEFAULT NULL,
  `gmdPromedio` float DEFAULT NULL,
  `gpvPromedio` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registroegresos`
--

INSERT INTO `registroegresos` (`id`, `feedlot`, `tropa`, `fecha`, `cantidad`, `pesoPromedio`, `destino`, `gmdPromedio`, `gpvPromedio`) VALUES
(1, 'Acopiadora Hoteleria', 'Salida gordo  fasano', '2020-09-14', 34, 511.15, NULL, 0.59, 100.32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registroingresos`
--

DROP TABLE IF EXISTS `registroingresos`;
CREATE TABLE IF NOT EXISTS `registroingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(150) NOT NULL,
  `tropa` varchar(150) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` int(100) DEFAULT NULL,
  `pesoPromedio` float DEFAULT NULL,
  `renspa` varchar(150) DEFAULT NULL,
  `adpv` float DEFAULT NULL,
  `estado` varchar(150) DEFAULT NULL,
  `proveedor` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registroingresos`
--

INSERT INTO `registroingresos` (`id`, `feedlot`, `tropa`, `fecha`, `cantidad`, `pesoPromedio`, `renspa`, `adpv`, `estado`, `proveedor`) VALUES
(1, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', '2020-09-16', 26, 333.96, '', 0, 'Regular', 'Fassano'),
(2, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', '2020-08-10', 26, 333.96, '', 0, 'Regular', 'Fassano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registroinsumo`
--

DROP TABLE IF EXISTS `registroinsumo`;
CREATE TABLE IF NOT EXISTS `registroinsumo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insumo` varchar(150) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `porceMS` float DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registroinsumo`
--

INSERT INTO `registroinsumo` (`id`, `insumo`, `precio`, `porceMS`, `fecha`) VALUES
(1, 'Maiz', 2, 80, '2020-11-19'),
(2, 'Cascara de Mani', 1, 100, '2020-11-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registromuertes`
--

DROP TABLE IF EXISTS `registromuertes`;
CREATE TABLE IF NOT EXISTS `registromuertes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(150) NOT NULL,
  `tropa` varchar(150) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` int(100) DEFAULT NULL,
  `causaMuerte` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registromuertes`
--

INSERT INTO `registromuertes` (`id`, `feedlot`, `tropa`, `fecha`, `cantidad`, `causaMuerte`) VALUES
(1, 'Acopiadora Hoteleria', 'Muerto enfermeria', '2020-05-17', 1, 'Respiratorio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedlot` varchar(150) NOT NULL,
  `tropa` varchar(150) NOT NULL,
  `fechaIngreso` date DEFAULT NULL,
  `animales` int(11) DEFAULT 0,
  `operario` varchar(150) DEFAULT NULL,
  `operario1` varchar(150) DEFAULT NULL,
  `operario2` varchar(150) DEFAULT NULL,
  `operario3` varchar(150) DEFAULT NULL,
  `procedimiento` varchar(150) NOT NULL DEFAULT '',
  `fechaRealizado` date DEFAULT NULL,
  `fechaMetafilaxis` date DEFAULT NULL,
  `metafilaxis` tinyint(1) NOT NULL DEFAULT 0,
  `fechaVacuna` date DEFAULT NULL,
  `vacuna` tinyint(1) NOT NULL DEFAULT 0,
  `fechaRefuerzo` date DEFAULT NULL,
  `refuerzo` tinyint(1) NOT NULL DEFAULT 0,
  `notificado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `feedlot`, `tropa`, `fechaIngreso`, `animales`, `operario`, `operario1`, `operario2`, `operario3`, `procedimiento`, `fechaRealizado`, `fechaMetafilaxis`, `metafilaxis`, `fechaVacuna`, `vacuna`, `fechaRefuerzo`, `refuerzo`, `notificado`) VALUES
(1, 'Acopiadora Hoteleria', 'Ingreso fasano corral 21', '2020-09-16', 26, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, 0, NULL, 0, 0),
(2, 'Acopiadora Hoteleria', 'Ingreso fasano corral 3', '2020-08-10', 26, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoformula`
--

DROP TABLE IF EXISTS `tipoformula`;
CREATE TABLE IF NOT EXISTS `tipoformula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipoformula`
--

INSERT INTO `tipoformula` (`id`, `tipo`) VALUES
(1, 'Tipo1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
