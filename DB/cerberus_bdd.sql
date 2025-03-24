-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2024 a las 14:04:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cerberus_bdd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendas`
--

CREATE TABLE `agendas` (
  `contador_agendas` int(12) NOT NULL,
  `id_agendas` varchar(11) DEFAULT NULL,
  `titulo_agenda` varchar(64) DEFAULT NULL,
  `descripcion_agenda` varchar(132) DEFAULT NULL,
  `num_documento_persona` varchar(16) DEFAULT NULL,
  `fecha_hora_registro` datetime DEFAULT NULL,
  `fecha_hora_agenda` datetime DEFAULT NULL,
  `placa_vehiculo` varchar(7) DEFAULT NULL,
  `tipo_vehiculo` varchar(10) DEFAULT NULL,
  `estado_agenda` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_personas`
--

CREATE TABLE `agenda_personas` (
  `id_agenda_grupal` int(11) NOT NULL,
  `id_agenda` int(11) NOT NULL,
  `num_identificacion_persona` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `contador_aprediz` int(11) NOT NULL,
  `tipo_documento` varchar(5) NOT NULL,
  `num_identificacion` varchar(16) NOT NULL,
  `nombres` varchar(64) NOT NULL,
  `apellidos` varchar(64) NOT NULL,
  `correo` varchar(88) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `estado` varchar(9) NOT NULL DEFAULT 'INACTIVO',
  `num_ficha_fk` varchar(9) NOT NULL,
  `fecha_hora_ultimo_ingreso` datetime NOT NULL,
  `permanencia` varchar(9) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `forma_de_ingreso` varchar(6) NOT NULL,
  `id_ultimo_reporte` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `aprendices`
--

INSERT INTO `aprendices` (`contador_aprediz`, `tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `estado`, `num_ficha_fk`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_registro`, `forma_de_ingreso`, `id_ultimo_reporte`) VALUES
(1, 'CC', '1109186720', 'asdf', 'sdfg', 'cvbvbn', '', 'ACTIVO', '', '2024-09-28 23:48:44', '', '2024-09-28 23:48:44', '', ''),
(2, '', '', '', '', '', '', 'ACTIVO', '', '2024-09-28 23:48:44', '', '2024-09-28 23:48:44', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `contador_id_eventos` int(12) NOT NULL,
  `id_eventos` int(11) DEFAULT NULL,
  `persona_que_autoriza` varchar(16) DEFAULT NULL,
  `fecha_hora_registro` datetime DEFAULT NULL,
  `estado_permiso` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `contador_ficha` int(11) NOT NULL,
  `num_ficha` varchar(9) NOT NULL,
  `fecha_inicio_ficha` date NOT NULL,
  `fecha_fin_ficha` date NOT NULL,
  `estado_ficha` varchar(8) NOT NULL,
  `fecha_registro_ficha` date NOT NULL,
  `nombre_programa` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

CREATE TABLE `funcionarios` (
  `contador_funcionario` int(11) NOT NULL,
  `tipo_documento` varchar(5) NOT NULL,
  `num_identificacion` varchar(16) NOT NULL,
  `credencial` varchar(32) DEFAULT NULL,
  `nombres` varchar(64) NOT NULL,
  `apellidos` varchar(64) NOT NULL,
  `correo` varchar(88) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `tipo_contrato` varchar(11) NOT NULL,
  `rol_usuario` varchar(3) NOT NULL,
  `estado` varchar(9) NOT NULL,
  `fecha_hora_ultimo_ingreso` datetime NOT NULL,
  `permanencia` varchar(9) NOT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `num_id_usuario_que_registra` varchar(16) NOT NULL,
  `fecha_finalizacion_contrato` datetime DEFAULT NULL,
  `forma_de_ingreso` varchar(6) NOT NULL,
  `id_ultimo_reporte` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`contador_funcionario`, `tipo_documento`, `num_identificacion`, `credencial`, `nombres`, `apellidos`, `correo`, `telefono`, `tipo_contrato`, `rol_usuario`, `estado`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_hora_registro`, `num_id_usuario_que_registra`, `fecha_finalizacion_contrato`, `forma_de_ingreso`, `id_ultimo_reporte`) VALUES
(1, 'CC', '1109186726', '', 'Kathryn', 'Merchan Sua', 'kathrynmerchan242005@gmail.com', '3233439713', 'contratista', 'SB', 'ACTIVO', '2024-09-26 22:51:55', 'FUERA', '2024-09-26 22:51:55', '', NULL, '', ''),
(25, 'TI', '11091867', '', 'Asdasdsad', 'Asdasdsad', 'asdasd@ss.ssd', '1234567339', 'CT', 'SB', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-09-28 19:48:56', '1109186726', '2024-10-12 00:00:00', '', ''),
(26, 'TI', '1109186757', '', 'Asdasdsad', 'Asdasdsad', 'asdasd@ss.ssd', '1234567339', 'PT', 'SB', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-09-28 19:49:36', '1109186726', NULL, '', ''),
(27, 'CC', '1254152', '', 'ghjklkj', 'kjhgf', 'oiuygf@hgf.tfd', '3216549875', 'PT', 'CO', 'ACTIVO', '2024-09-29 19:17:15', 'FUERA', '2024-09-29 19:17:15', '1109186726', NULL, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_ingreso`
--

CREATE TABLE `motivo_ingreso` (
  `contador_MOTIVO` int(12) NOT NULL,
  `titulo_motivo` varchar(35) DEFAULT NULL,
  `fecha_registro_motivo` datetime DEFAULT NULL,
  `parmenencia` varchar(7) DEFAULT NULL,
  `fecha_de_registro` datetime DEFAULT NULL,
  `usuario_de_reporte` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades_e_s`
--

CREATE TABLE `novedades_e_s` (
  `contador_id_novedad` int(12) NOT NULL,
  `fecha_hora_novedad` datetime DEFAULT NULL,
  `descripcion_agenda` varchar(132) DEFAULT NULL,
  `usuario_registro_novedad` varchar(16) DEFAULT NULL,
  `puerta_de_novedad` varchar(7) DEFAULT NULL,
  `tipo_novedad` varchar(7) DEFAULT NULL,
  `num_identificacion_causante` varchar(16) DEFAULT NULL,
  `id_reporte_ingreso_salida` varchar(16) DEFAULT NULL,
  `puerta_registro_novedad` varchar(9) DEFAULT NULL,
  `fecha_de_siceso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades_permanencia`
--

CREATE TABLE `novedades_permanencia` (
  `contador_novedades` int(12) NOT NULL,
  `num_identificacion_persona` varchar(16) DEFAULT NULL,
  `fecha_hora_novedad` datetime DEFAULT NULL,
  `descripcion_novedad` varchar(120) DEFAULT NULL,
  `usuario_registro_novedad` varchar(16) DEFAULT NULL,
  `puerta_registro_novedad` varchar(9) DEFAULT NULL,
  `tipo_novedad` varchar(7) DEFAULT NULL,
  `num_identificacion_causante` varchar(16) DEFAULT NULL,
  `estado_novedad` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_de_s_e_articulos`
--

CREATE TABLE `permisos_de_s_e_articulos` (
  `contador_id_articulos` int(12) NOT NULL,
  `persona_que_autoriza` varchar(16) DEFAULT NULL,
  `tipo_permiso` varchar(8) DEFAULT NULL,
  `num_identificacion_persona` varchar(16) DEFAULT NULL,
  `identificacion_articulos` varchar(25) DEFAULT NULL,
  `feche_de_registro_del_permiso` datetime DEFAULT NULL,
  `usuario_de_reporte` varchar(15) DEFAULT NULL,
  `estado_permiso` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_de_s_e_menores`
--

CREATE TABLE `permisos_de_s_e_menores` (
  `contador_id_persona` int(12) NOT NULL,
  `persona_o_menos_doc` varchar(15) DEFAULT NULL,
  `id_permiso_menosres` varchar(16) DEFAULT NULL,
  `eps_persona_menor` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_de_s_e_personas`
--

CREATE TABLE `permisos_de_s_e_personas` (
  `contador_id_permisos` int(12) NOT NULL,
  `persona_que_autoriza` varchar(16) DEFAULT NULL,
  `tipo_permiso` varchar(8) DEFAULT NULL,
  `num_identificacion_persona` varchar(16) DEFAULT NULL,
  `descripsion` varchar(255) DEFAULT NULL,
  `feche_de_registro_del_permiso` datetime DEFAULT NULL,
  `estado_permiso` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_de_s_e_p_menores`
--

CREATE TABLE `permisos_de_s_e_p_menores` (
  `contador_id_articulos` int(12) NOT NULL,
  `id_permisos_menores` int(11) DEFAULT NULL,
  `persona_que_autoriza` varchar(16) DEFAULT NULL,
  `fecha_hora_registro` datetime DEFAULT NULL,
  `motivo_ingreso` varchar(50) DEFAULT NULL,
  `estado_permiso` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_entrada_salida`
--

CREATE TABLE `reporte_entrada_salida` (
  `contador_reporte` int(12) NOT NULL,
  `id_reporte` varchar(14) NOT NULL,
  `tipo_reporte` varchar(7) DEFAULT NULL,
  `id_reporte_relacion` varchar(14) NOT NULL,
  `num_identificacion_persona` varchar(20) NOT NULL,
  `fecha_hora_reporte` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_de_reporte` varchar(50) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `rol_usuario` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `reporte_entrada_salida`
--

INSERT INTO `reporte_entrada_salida` (`contador_reporte`, `id_reporte`, `tipo_reporte`, `id_reporte_relacion`, `num_identificacion_persona`, `fecha_hora_reporte`, `usuario_de_reporte`, `observacion`, `rol_usuario`) VALUES
(1, 'RP241118083012', 'ENTRADA', 'RV241119101545', '1112038485', '2024-11-18 08:30:12', '1112038489', 'OBSERVACION', 'VS'),
(2, 'RP241120083012', 'ENTRADA', 'RP241120093012', '1112038485', '2024-11-20 08:30:00', '1112038489', 'OBSERVACION', 'VS'),
(3, 'RP241120093012', 'SALIDA', 'RP241120083012', '1112038485', '2024-11-20 09:30:00', '1112038489', 'OBSERVACION', 'VS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_entrada_salida_vehicular`
--

CREATE TABLE `reporte_entrada_salida_vehicular` (
  `contador_reporte` int(12) NOT NULL,
  `id_reporte` varchar(14) NOT NULL,
  `tipo_de_reporte` varchar(7) DEFAULT NULL,
  `id_reporte_relacion` varchar(14) NOT NULL,
  `num_identificacion_persona` varchar(16) DEFAULT NULL,
  `fecha_hora_reporte` datetime DEFAULT NULL,
  `usuario_de_reporte` varchar(16) DEFAULT NULL,
  `rol_en_el_vehiculo` varchar(15) DEFAULT NULL,
  `placa_vehiculo` varchar(7) DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `rol_usuario` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `reporte_entrada_salida_vehicular`
--

INSERT INTO `reporte_entrada_salida_vehicular` (`contador_reporte`, `id_reporte`, `tipo_de_reporte`, `id_reporte_relacion`, `num_identificacion_persona`, `fecha_hora_reporte`, `usuario_de_reporte`, `rol_en_el_vehiculo`, `placa_vehiculo`, `observacion`, `rol_usuario`) VALUES
(1, 'RV241119101545', 'SALIDA', 'RP241118083012', '1112038485', '2024-11-19 10:15:45', '1112038489', 'PASAJERO', 'MPO01D', 'OBSERVACION', 'VS'),
(2, 'RV241121101545', 'ENTRADA', 'RV241122101545', '1112038485', '2024-11-21 10:15:45', '1112038489', 'CONDUCTOR', 'MPO01D', 'OBSERVACION', 'VS'),
(3, 'RV241122101545', 'SALIDA', 'RV241121101545', '112038485', '2024-11-22 10:15:45', '1112038489', 'PASAJERO', 'DZO01X', 'OBSERVACION', 'VS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_personas`
--

CREATE TABLE `vehiculos_personas` (
  `contador_vehiculo` int(11) NOT NULL,
  `placa_vehiculo` varchar(6) NOT NULL,
  `tipo_vehiculo` varchar(10) NOT NULL,
  `num_identificacion_persona` varchar(16) NOT NULL,
  `fecha_hora_ultimo_ingreso` datetime NOT NULL,
  `permanencia` varchar(9) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `num_id_usuario_que_registra` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `vehiculos_personas`
--

INSERT INTO `vehiculos_personas` (`contador_vehiculo`, `placa_vehiculo`, `tipo_vehiculo`, `num_identificacion_persona`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_registro`, `num_id_usuario_que_registra`) VALUES
(1, 'MPO01D', 'MT', '1112038485', '2024-10-04 14:40:36', 'FUERA', '2024-10-04 14:40:36', '1112038489'),
(2, 'DZO01X', 'MC', '1112038485', '2024-10-04 17:11:49', 'FUERA', '2024-10-04 17:11:49', '1112038489'),
(3, 'MPO01D', 'MT', '1112038485', '2024-10-04 14:40:36', 'FUERA', '2024-10-04 14:40:36', '1112038489'),
(4, 'PLH005', 'BS', '89653163', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:40:59', ''),
(5, 'PLH005', 'BS', '89653163589', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:45:21', ''),
(6, 'PLH005', 'BS', '16451468', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:50:37', ''),
(7, 'PLH009', 'CM', '896586563', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:52:48', ''),
(8, 'DSA457', 'CM', '4986415134', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:24:24', ''),
(9, 'DSA457', 'BS', '49864516', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:25:39', ''),
(10, 'DSA458', 'BS', '499564516', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:26:08', ''),
(11, 'TRE452', 'AT', '64643164', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:36:11', ''),
(12, 'TRE452', 'BS', '64654152', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:36:58', ''),
(13, 'UTR475', 'CM', '9865163156', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:38:55', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vigilantes`
--

CREATE TABLE `vigilantes` (
  `contador_vigilante` int(11) NOT NULL,
  `tipo_documento` varchar(5) NOT NULL,
  `num_identificacion` varchar(16) DEFAULT NULL,
  `credencial` varchar(32) NOT NULL,
  `nombres` varchar(64) DEFAULT NULL,
  `apellidos` varchar(64) DEFAULT NULL,
  `correo` varchar(88) DEFAULT NULL,
  `telefono` varchar(13) DEFAULT NULL,
  `estado` varchar(9) DEFAULT NULL,
  `rol_usuario` varchar(2) DEFAULT NULL,
  `fecha_sesion` datetime DEFAULT NULL,
  `fecha_ultima_sesion` datetime DEFAULT NULL,
  `fecha_hora_ultimo_ingreso` datetime DEFAULT NULL,
  `permanencia` varchar(9) DEFAULT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `forma_de_ingreso` varchar(6) NOT NULL,
  `id_ultimo_reporte` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `vigilantes`
--

INSERT INTO `vigilantes` (`contador_vigilante`, `tipo_documento`, `num_identificacion`, `credencial`, `nombres`, `apellidos`, `correo`, `telefono`, `estado`, `rol_usuario`, `fecha_sesion`, `fecha_ultima_sesion`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_hora_registro`, `forma_de_ingreso`, `id_ultimo_reporte`) VALUES
(1, 'CC', '1112038489', '25d55ad283aa400af464c76d713c07ad', 'Vigilante Jefe', 'Prueba', 'ningun@correo.co', '3000000000', 'ACTIVO', 'JV', NULL, NULL, NULL, 'DENTRO', '2024-10-01 21:01:49', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `contador_visitante` int(11) NOT NULL,
  `tipo_documento` varchar(5) NOT NULL,
  `num_identificacion` varchar(16) NOT NULL,
  `nombres` varchar(64) NOT NULL,
  `apellidos` varchar(64) NOT NULL,
  `correo` varchar(88) DEFAULT NULL,
  `telefono` varchar(13) NOT NULL,
  `estado` varchar(9) NOT NULL DEFAULT 'INACTIVO',
  `fecha_hora_ultimo_ingreso` datetime NOT NULL,
  `permanencia` varchar(9) NOT NULL DEFAULT 'FUERA',
  `fecha_hora_registro` datetime NOT NULL,
  `forma_de_ingreso` varchar(6) NOT NULL,
  `id_ultimo_reporte` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`contador_visitante`, `tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `estado`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_hora_registro`, `forma_de_ingreso`, `id_ultimo_reporte`) VALUES
(2, 'CC', '1112038485', 'Dilan Dazo', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '2024-09-26 00:14:57', 'DENTRO', '2024-09-26 00:14:57', 'PEATON', 'RP241118083012'),
(3, 'CC', '123456', 'Dilan', 'Zapata', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-10-01 08:47:16', '', ''),
(4, 'CC', '1112038486', 'Dilan', 'Zapata', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-10-01 18:16:03', '', ''),
(5, 'CC', '1112038488', 'Yon', 'Obregon', 'yonobregon.pro@gmail.com', '3215623910', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-10-05 21:05:38', '', ''),
(6, 'CC', '1112038481', 'Dilan', 'Zapata', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-02 15:11:56', '', ''),
(7, 'CC', '1112140000', 'Juan', 'Navia', 'juannavia@gmail.com', '3053058585', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-02 15:27:14', '', ''),
(8, 'CC', '110918543484', 'Kat', 'Mer', 'kat@gamil.com', '3233439713', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-02 15:48:13', '', ''),
(9, 'CC', '3645679854', 'Jero', 'Pizarro', 'marinjeronimo44@gmail.com', '3154598499', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-02 17:46:18', '', ''),
(10, 'PS', '616464649', 'Jejejsvs', 'Whjsjsjsbd', 'marinjeronimo44@gmail.com', '3155485784', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-07 11:05:54', '', ''),
(11, 'CC', '789456123', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:32:53', '', ''),
(12, 'CC', '798465132', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:35:23', '', ''),
(13, 'CC', '89653163', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:40:59', '', ''),
(14, 'CC', '89653163589', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:45:21', '', ''),
(15, 'CC', '16451468', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:50:37', '', ''),
(16, 'CC', '896586563', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:52:48', '', ''),
(17, 'PS', '79651321', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 07:53:42', '', ''),
(18, 'CC', '4986415134', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:24:24', '', ''),
(19, 'CC', '49864516', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:25:39', '', ''),
(20, 'CC', '499564516', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:26:08', '', ''),
(21, 'CC', '64643164', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:36:11', '', ''),
(22, 'CC', '64654152', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:36:58', '', ''),
(23, 'CC', '9865163156', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 08:38:55', '', ''),
(24, 'CC', '9865156', 'Dilan Adrian', 'Zapata Ortiz', 'dilanadrianzapataortiz26@gmail.com', '3169000133', 'ACTIVO', '0000-00-00 00:00:00', 'FUERA', '2024-11-15 14:09:44', '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`contador_agendas`);

--
-- Indices de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD PRIMARY KEY (`contador_aprediz`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`contador_id_eventos`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`contador_ficha`);

--
-- Indices de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`contador_funcionario`);

--
-- Indices de la tabla `motivo_ingreso`
--
ALTER TABLE `motivo_ingreso`
  ADD PRIMARY KEY (`contador_MOTIVO`);

--
-- Indices de la tabla `novedades_e_s`
--
ALTER TABLE `novedades_e_s`
  ADD PRIMARY KEY (`contador_id_novedad`);

--
-- Indices de la tabla `novedades_permanencia`
--
ALTER TABLE `novedades_permanencia`
  ADD PRIMARY KEY (`contador_novedades`);

--
-- Indices de la tabla `permisos_de_s_e_articulos`
--
ALTER TABLE `permisos_de_s_e_articulos`
  ADD PRIMARY KEY (`contador_id_articulos`);

--
-- Indices de la tabla `permisos_de_s_e_menores`
--
ALTER TABLE `permisos_de_s_e_menores`
  ADD PRIMARY KEY (`contador_id_persona`);

--
-- Indices de la tabla `permisos_de_s_e_personas`
--
ALTER TABLE `permisos_de_s_e_personas`
  ADD PRIMARY KEY (`contador_id_permisos`);

--
-- Indices de la tabla `permisos_de_s_e_p_menores`
--
ALTER TABLE `permisos_de_s_e_p_menores`
  ADD PRIMARY KEY (`contador_id_articulos`);

--
-- Indices de la tabla `reporte_entrada_salida`
--
ALTER TABLE `reporte_entrada_salida`
  ADD PRIMARY KEY (`contador_reporte`);

--
-- Indices de la tabla `reporte_entrada_salida_vehicular`
--
ALTER TABLE `reporte_entrada_salida_vehicular`
  ADD PRIMARY KEY (`contador_reporte`);

--
-- Indices de la tabla `vehiculos_personas`
--
ALTER TABLE `vehiculos_personas`
  ADD PRIMARY KEY (`contador_vehiculo`);

--
-- Indices de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  ADD PRIMARY KEY (`contador_vigilante`);

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`contador_visitante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendas`
--
ALTER TABLE `agendas`
  MODIFY `contador_agendas` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `contador_aprediz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `contador_id_eventos` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `contador_ficha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `contador_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `motivo_ingreso`
--
ALTER TABLE `motivo_ingreso`
  MODIFY `contador_MOTIVO` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `novedades_e_s`
--
ALTER TABLE `novedades_e_s`
  MODIFY `contador_id_novedad` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `novedades_permanencia`
--
ALTER TABLE `novedades_permanencia`
  MODIFY `contador_novedades` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_de_s_e_articulos`
--
ALTER TABLE `permisos_de_s_e_articulos`
  MODIFY `contador_id_articulos` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_de_s_e_menores`
--
ALTER TABLE `permisos_de_s_e_menores`
  MODIFY `contador_id_persona` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_de_s_e_personas`
--
ALTER TABLE `permisos_de_s_e_personas`
  MODIFY `contador_id_permisos` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_de_s_e_p_menores`
--
ALTER TABLE `permisos_de_s_e_p_menores`
  MODIFY `contador_id_articulos` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_entrada_salida`
--
ALTER TABLE `reporte_entrada_salida`
  MODIFY `contador_reporte` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reporte_entrada_salida_vehicular`
--
ALTER TABLE `reporte_entrada_salida_vehicular`
  MODIFY `contador_reporte` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vehiculos_personas`
--
ALTER TABLE `vehiculos_personas`
  MODIFY `contador_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador_vigilante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador_visitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
