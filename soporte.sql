-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-09-2018 a las 00:08:47
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `soporte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `ip` varchar(12) NOT NULL,
  `controlador` varchar(30) NOT NULL,
  `metodo` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`id`, `id_usuario`, `ip`, `controlador`, `metodo`, `fecha`, `hora`) VALUES
(1, 1, '::1', 'login', 'index', '2018-09-10', '16:17:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `enlace` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `titulo`, `enlace`) VALUES
(1, 'Inicio', 'principal'),
(10, 'Administrar Usuarios', 'app'),
(15, 'Pedido/Servicio', 'servicio'),
(16, 'Administrar Servicios', 'admin_servicios'),
(17, 'Supervisor', 'supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permisos` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `permiso` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permisos`, `id_menu`, `id_role`, `permiso`) VALUES
(42, 10, 1, 1),
(43, 15, 3, 1),
(44, 16, 1, 1),
(45, 1, 1, 1),
(46, 1, 3, 1),
(47, 15, 1, 1),
(48, 17, 1, 1),
(49, 17, 4, 1),
(50, 15, 4, 1),
(51, 1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nombre_role` varchar(100) NOT NULL,
  `peso` int(11) NOT NULL,
  `otro_campo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id_role`, `nombre_role`, `peso`, `otro_campo`) VALUES
(1, 'Admin', 1, ''),
(3, 'Usuario', 1, ''),
(4, 'Supervisor', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `pedido` varchar(1000) COLLATE utf8_bin NOT NULL,
  `software` int(11) NOT NULL,
  `hardware` int(11) NOT NULL,
  `funcionamiento` int(11) NOT NULL,
  `otros` varchar(1000) COLLATE utf8_bin NOT NULL,
  `fecha` varchar(100) COLLATE utf8_bin NOT NULL,
  `hora` varchar(100) COLLATE utf8_bin NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_atencion` varchar(50) COLLATE utf8_bin DEFAULT 'No se agrego',
  `hora_atencion` varchar(50) COLLATE utf8_bin NOT NULL,
  `estatus` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'pendiente',
  `imagen_pedido` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `pedido`, `software`, `hardware`, `funcionamiento`, `otros`, `fecha`, `hora`, `id_usuario`, `fecha_atencion`, `hora_atencion`, `estatus`, `imagen_pedido`) VALUES
(1, 'Prueba nuevo formato de correo, al solucionar la solicitud.', 0, 0, 1, '0', '2018-09-28', '09:21:49', 1, '', '', 'solucionado', ''),
(2, 'prueba', 0, 0, 1, '0', '2018-09-28', '13:09:53', 67, '', '', 'solucionado', ''),
(3, '122132', 0, 0, 1, '0', '2018-09-28', '17:03:14', 1, '', '', 'pendiente', ''),
(4, '1545', 0, 0, 0, '0', '2018-09-28', '17:03:18', 1, '', '', 'pendiente', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solucion_servicio`
--

CREATE TABLE `solucion_servicio` (
  `id_solucion` int(11) NOT NULL,
  `observacion` varchar(1000) COLLATE utf8_bin NOT NULL,
  `fecha_solucion` varchar(200) COLLATE utf8_bin NOT NULL,
  `hora_solucion` time NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `imagen_solucion` varchar(200) COLLATE utf8_bin NOT NULL,
  `fecha_inicio` varchar(200) COLLATE utf8_bin NOT NULL,
  `hora_inicio` time NOT NULL,
  `id_usuario_sol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `solucion_servicio`
--

INSERT INTO `solucion_servicio` (`id_solucion`, `observacion`, `fecha_solucion`, `hora_solucion`, `id_servicio`, `imagen_solucion`, `fecha_inicio`, `hora_inicio`, `id_usuario_sol`) VALUES
(1, 'Probando el nuevo formato.', '2018-09-27', '15:23:58', 1, '', '', '12:00:00', 0),
(2, 'Solución, Revisión. prueba de tíldes ', '2018-09-26', '16:00:00', 1, '', '', '12:00:00', 0),
(3, 'Solución, Observación.', '2018-09-25', '16:00:00', 1, '', '', '12:00:00', 0),
(4, 'Ningún. Añadido, Previsualización.', '2018-09-24', '16:00:00', 1, '', '', '12:00:00', 0),
(5, 'prueba de imagen.', '2018-09-23', '16:00:00', 1, '', '', '12:00:00', 67),
(6, 'prueba.', '2018-09-22', '17:57:00', 2, '', '', '15:22:00', 67);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `switch`
--

CREATE TABLE `switch` (
  `id` int(11) NOT NULL,
  `accion` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `login` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `empresa` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `departamento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `login`, `password`, `cedula`, `nombre`, `apellido`, `correo`, `empresa`, `departamento`, `estado`, `id_role`) VALUES
(1, 'admin', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 0, 'SOPORTE ', 'COTEDEM CIA. LTDA', 'soporte@cotedem.com', 'COTEDEM1', 'Root', 1, 1),
(2, 'durvina', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1802832608, 'DARIO ', 'URVINA', 'durvina@cotedem.com', 'COTEDEM', 'Root', 1, 1),
(3, 'agonzalez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1718479890, 'ANA LUCIA', 'GONZALEZ ALULEMA', 'rrhh@ingelcom.com.ec', 'INGELCOM', 'Recursos Humanos', 1, 3),
(4, 'aricaurte', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1715868699, 'ARACELI', 'RICAURTE TOLEDO', 'aricaurte@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(5, 'aolmos', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 503255366, 'ANDRES', 'OLMOS', 'tecsupervisor@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(6, 'cvaldivieso', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1712928884, 'CHRISTIAN ANDRES', 'VALDIVIESO PABON', 'ventas1@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(7, 'cconde', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1709086472, 'CRISTINA', 'CONDE', 'cconde@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(8, 'singelcom', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1802832608, 'DARIO', 'URVINA LOPEZ', 'sistemas@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(9, 'lmuñoz', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1723118178, 'LEONARDO', 'MUÑOZ POZO', 'financiero@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(10, 'dsanguña', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1715904320, 'DAVID', 'SANGUÑA', 'asistentecompras@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(11, 'dgaliano', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1002835815, 'DIEGO ARMANDO', 'GALIANO YEPEZ', 'dgaliano@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(12, 'emoya', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1803394814, 'EDGAR MEDARDO', 'MOYA GUACHI', 'ventas2@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(13, 'garmijo', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1713569737, 'GONZALO ARMANDO', 'ARMIJO CHANGOLUISA', 'garmijo@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(14, 'hgonzalez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1719856377, 'HECTOR PATRICIO', 'GONZALEZ GOMEZ', 'hgonzalez@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(15, 'hmoran', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1723403703, 'HENRY', 'MORAN', 'ecommerce@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(16, 'jconstante', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1708014764, 'JAIME ANTONIO', 'CONSTANTE HERRERA', 'jconstante@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(17, 'jquishpe', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1724420698, 'JOHANA', 'QUISHPE SONGOR', 'contabilidad@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(18, 'jjiron', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1714435334, 'JORGE EDUARDO', 'JIRON PROA?O', 'jjiron@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(19, 'mnolivos', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1710563683, 'MARGARITA DEL ROCIO', 'NOLIVOS SUQUILLO', 'margaritanolivos@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(20, 'malmachi', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1, 'MARLENE', 'ALMACHI', 'miferreteria@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(21, 'mcaiza', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1719371997, 'MAYRA', 'CAIZA', 'asisconta@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(22, 'rzambrano', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1721549010, 'RUBEN ZAMBRANO', 'ZAMBRANO', 'ventas3@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(23, 'squimbiurco', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1714628268, 'SYLVIA', 'QUIMBIURCO', 'cobranzas@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(24, 'vjacome', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 0, 'VICTOR ', 'JACOME', 'vjacome@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(25, 'vzambrano', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1308878188, 'VALERIA', 'ZAMBRANO', 'compras@ingelcom.com.ec', 'INGELCOM', '', 1, 3),
(26, 'aparedes', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1715065403, 'ADRIANA KARINA', 'PAREDES ARCOS', 'aparedes@lexvalor.com', 'LEXVALOR', '', 1, 3),
(27, 'anieto', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1712536810, 'ANA BELEN', 'NIETO', 'anieto@lexvalor.com', 'LEXVALOR', '', 1, 3),
(28, 'achiriboga', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1706926746, 'ANA ELENA', 'CHIRIBOGA LOPEZ', 'achiriboga@lexvalor.com', 'LEXVALOR', 'GERENCIA', 1, 3),
(29, 'arodriguez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 108374111, 'ANA KARINA', 'RODRIGUEZ CORONA', 'arodriguez@lexvalor.com', 'LEXVALOR', '', 1, 3),
(30, 'asanandres', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1717467896, 'ANA MARIA', 'SAN ANDRES', 'asanandres@lexvalor.com', 'LEXVALOR', '', 1, 3),
(31, 'ccarrion', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1001501657, 'CARLOS', 'CARRION', 'ccarrion@lexvalor.com', 'LEXVALOR', '', 1, 3),
(32, 'cecheverria', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1714836077, 'CAROLINA', 'ECHEVERRIA DEL CASTILLO', 'cecheverria@lexvalor.com', 'LEXVALOR', '', 1, 3),
(33, 'calvarez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1720442605, 'CRISTIAN ANDRES', 'ALVAREZ FREIRE', 'calvarez@lexvalor.com', 'LEXVALOR', '', 1, 3),
(34, 'dmorejon', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1721392924, 'DAMIAN ALEJANDRO', 'MOREJON GUERRERO', 'dmorejon@lexvalor.com', 'LEXVALOR', '', 1, 3),
(35, 'dguevara', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1718750068, 'DANIEL', 'GUEVARA DE LOS REYES', 'dguevara@lexvalor.com', 'LEXVALOR', '', 1, 3),
(36, 'dirigoyen', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1715540439, 'DANIELA LUCIA', 'IRIGOYEN SAMANIEGO', 'dirigoyen@lexvalor.com', 'LEXVALOR', '', 1, 3),
(37, 'fmanosalvas', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1707817647, 'FAUSTO FABIAN', 'MANOSALVAS ANGAMARCA', 'fmanosalvas@lexvalor.com', 'LEXVALOR', 'CONTABILIDAD', 1, 3),
(38, 'gcarrasco', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 104433776, 'GABRIELA', 'CARRASCO PUYOL', 'gcarrasco@lexvalor.com', 'LEXVALOR', '', 1, 3),
(39, 'gbermudez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1713584702, 'GEOVANNY', 'BERMUDEZ VEGA', 'gbermudez@lexvalor.com', 'LEXVALOR', '', 1, 3),
(40, 'gerazo', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1707503478, 'GIOVANNI SEGUNDO', 'ERAZO ZAMBRANO', 'gerazo@lexvalor.com', 'LEXVALOR', '', 1, 3),
(41, 'iperez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1750424549, 'INTI MEDARDO', 'PEREZ GUAMAN', 'iperez@lexvalor.com', 'LEXVALOR', '', 1, 3),
(42, 'isamaniego', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1714195565, 'ISABEL', 'SAMANIEGO', 'isamaniego @lexvalor.com', 'LEXVALOR', '', 1, 3),
(43, 'iplascencia', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 176729460, 'IVAN LEANDRO', 'PLASCENCIA MORALES', 'iplascencia@lexvalor.com', 'LEXVALOR', '', 1, 3),
(44, 'jmontero', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1718318072, 'JENIFFER', 'MONTERO QUINTANILLA', 'jmontero@lexvalor.com', 'LEXVALOR', '', 1, 3),
(45, 'jantamba', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1709423501, 'JENNY ALEXANDRA', 'ANTAMBA GOMEZ', 'jantamba@lexvalor.com', 'LEXVALOR', '', 1, 3),
(46, 'jaltamirano', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1725487217, 'JESSICA ALEJANDRA', 'ALTAMIRANO', 'jaltamirano @lexvalor.com', 'LEXVALOR', '', 1, 3),
(47, 'jcornejo', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1718905605, 'JOSE GABRIEL', 'CORNEJO', 'jcornejo@lexvalor.com', 'LEXVALOR', '', 1, 3),
(48, 'jportilla', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1717341976, 'JOSE LUIS', 'PORTILLA', 'jportilla@lexvalor.com', 'LEXVALOR', '', 1, 3),
(49, 'jendara', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1003473988, 'JOSE XAVIER', 'ENDARA MADERA', 'jendara@lexvalor.com', 'LEXVALOR', '', 1, 3),
(50, 'jalmeida', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1714766951, 'JUAN FRANCISCO', 'ALMEIDA GRANJA', 'jalmeida@lexvalor.com', 'LEXVALOR', '', 1, 3),
(51, 'kvillacis', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1707896724, 'KARLA ALEJANDRA', 'VILLACIS ECHEVERRIA', 'kvillacis@lexvalor.com', 'LEXVALOR', '', 1, 3),
(52, 'kvinueza', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1723545057, 'KEVIN ALEXANDER', 'VINUEZA AYALA', 'kvinueza@lexvalor.com', 'LEXVALOR', '', 1, 3),
(53, 'lrueda', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1717994501, 'LORENA', 'RUEDA AYALA', 'lrueda@lexvalor.com', 'LEXVALOR', '', 1, 3),
(54, 'mmorabowen', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1713148680, 'MARCELO', 'MORABOWEN', 'mmorabowen@lexvalor.com', 'LEXVALOR', '', 1, 3),
(55, 'mchiriboga', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1706926738, 'MARGOTH ELIZABETH', 'CHIRIBOGA LOPEZ', 'mchiriboga@lexvalor.com', 'LEXVALOR', '', 1, 3),
(56, 'maguinaga', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1724060965, 'MARIA ANGELES', 'AGUINAGA', 'maguinaga@lexvalor.com', 'LEXVALOR', '', 1, 3),
(57, 'privadeneira', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1715829139, 'MARIA PIA', 'RIVADENEIRA MOSQUERA', 'privadeneira@lexvalor.com', 'LEXVALOR', '', 1, 3),
(58, 'mmoreno', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1003319298, 'MARIELA ALEJANDRA', 'MORENO VACA', 'mmoreno@lexvalor.com', 'LEXVALOR', '', 1, 3),
(59, 'ocorrea', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1723309744, 'OSCAR RUBEN', 'CORREA PEREZ', 'ocorrea@lexvalor.com', 'LEXVALOR', '', 1, 3),
(60, 'pbruzzone', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1712336054, 'PEDRO', 'BRUZZONE MANJARRES', 'pbruzzone@lexvalor.com', 'LEXVALOR', '', 1, 3),
(61, 'rtrujillo', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1717593527, 'RICARDO ANDRES', 'TRUJILLO MOSCO', 'rtrujillo@lexvalor.com', 'LEXVALOR', '', 1, 3),
(62, 'rsuarez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1712026648, 'RUBEN DARIO', 'SUAREZ CHAVEZ', 'rsuarez@lexvalor.com', 'LEXVALOR', '', 1, 3),
(63, 'aerazo', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1721067104, 'RUTH ANAHI', 'ERAZO PASPUEL', 'aerazo@lexvalor.com', 'LEXVALOR', '', 1, 3),
(64, 'schacha', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1716533318, 'SANDRA MIREYA', 'CHACHA BURGOS', 'schacha@lexvalor.com', 'LEXVALOR', '', 1, 3),
(65, 'tguaman', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1725798233, 'TAMIA PAMELA', 'GUAMAN CORONADO', 'tguaman@lexvalor.com', 'LEXVALOR', '', 1, 3),
(66, 'vgomez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1716589146, 'VANESSA CAROLINA', 'GOMEZ MOSQUERA', 'vgomez@lexvalor.com', 'LEXVALOR', '', 1, 3),
(67, 'vargasvargas', '53362d5ea52a28e1a960323ea19b02cb2b828026', 23347025, 'GILBERTO', 'VARGAS', 'SOPORTE@COTEDEM.COM', 'COTEDEM', 'SOPORTE', 1, 1),
(68, 'acadena', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1003255815, 'Ana Belen ', 'Cadena Herrera', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(69, 'bguano', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1713555223, 'Byron Oswaldo ', 'Guano Troya', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(70, 'ccoronel', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1002224036, 'Carlos Andr?s ', 'Coronel Endara', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(71, 'calmeida', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 0, 'Cristina Elizabeth', 'Almeida Vaca', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(72, 'dloor', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 0, 'Diana Del Rocio ', 'Loor Mena', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(73, 'emoreno', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1725276321, 'Emily Gabriela ', 'Moreno Villacreses', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(74, 'gcevallos', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1712085578, 'German ', 'Cevallos Landeta', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(75, 'jjijon', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 915197214, 'Jorge Ricardo? ', 'Jijon Marquez De La Plata', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(76, 'jzarria', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1711040160, 'Josue Alejandro ', 'Zarria Proano', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(77, 'jcastro', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1104957418, 'Jos? Israel', 'Castro Villamagua', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(78, 'msemanate', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 501882567, 'Mariangeles ', 'Semanate Norona', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(79, 'mleon', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 0, 'Mayra Alejandra ', 'Leon Lojan', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(80, 'mbermudez', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 1720921186, 'Michelle ', 'Bermudez Vega', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(81, 'parias', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 602672222, 'Pablo Andres ', 'Arias Aizaga', '@lexvalor.com', 'LEXTAX', '', 1, 3),
(82, 'vchiriboga', 'c0fde5f0f153a4dbe405e2ee0b5259632de16f9b', 0, 'V?ctor Alfredo ', 'Chiriboga Granja', '@lexvalor.com', 'LEXTAX', '', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permisos`),
  ADD KEY `id_menu` (`id_menu`,`id_role`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_menu_2` (`id_menu`),
  ADD KEY `id_role_2` (`id_role`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`),
  ADD KEY `nombre_role` (`nombre_role`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `solucion_servicio`
--
ALTER TABLE `solucion_servicio`
  ADD PRIMARY KEY (`id_solucion`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `switch`
--
ALTER TABLE `switch`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permisos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `solucion_servicio`
--
ALTER TABLE `solucion_servicio`
  MODIFY `id_solucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `switch`
--
ALTER TABLE `switch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solucion_servicio`
--
ALTER TABLE `solucion_servicio`
  ADD CONSTRAINT `solucion_servicio_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
