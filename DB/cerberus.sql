-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2025 a las 09:42:12
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
-- Base de datos: `cerberus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendas`
--

CREATE TABLE `agendas` (
  `contador` int(11) NOT NULL,
  `codigo_agenda` varchar(16) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_agenda` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `contador` int(11) NOT NULL,
  `tipo_documento` varchar(3) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(64) NOT NULL,
  `fk_ficha` varchar(7) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadias_aprendices`
--

CREATE TABLE `estadias_aprendices` (
  `contador` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_fin_estadia` date NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `contador` int(11) NOT NULL,
  `numero_ficha` varchar(7) NOT NULL,
  `nombre_programa` varchar(50) NOT NULL,
  `fecha_fin_ficha` date NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`contador`, `numero_ficha`, `nombre_programa`, `fecha_fin_ficha`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(1, '2714805', 'Analisis y Desarrollo de Software', '2025-05-07', '2025-05-08 20:48:49', '123456789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

CREATE TABLE `funcionarios` (
  `contador` int(11) NOT NULL,
  `tipo_documento` varchar(3) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(64) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `tipo_contrato` varchar(11) NOT NULL,
  `fecha_fin_contrato` date DEFAULT NULL,
  `contrasena` varchar(32) DEFAULT NULL,
  `brigadista` varchar(2) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_ultima_sesion` datetime DEFAULT NULL,
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA',
  `estado_usuario` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`contador`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `rol`, `tipo_contrato`, `fecha_fin_contrato`, `contrasena`, `brigadista`, `fecha_registro`, `fecha_ultima_sesion`, `ubicacion`, `estado_usuario`) VALUES
(2, 'CC', '1234567898', 'Sara', 'Rico', '1234567890', 'sara@gmail.com', 'instructor', 'planta', NULL, NULL, 'si', '2025-05-10 05:54:16', NULL, 'DENTRO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_ingreso`
--

CREATE TABLE `motivos_ingreso` (
  `contador` int(11) NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `contador` int(11) NOT NULL,
  `tipo_movimiento` varchar(7) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fk_vehiculo` varchar(6) DEFAULT NULL,
  `relacion_vehiculo` varchar(11) DEFAULT NULL,
  `puerta_registro` varchar(9) NOT NULL,
  `observacion` varchar(150) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL,
  `grupo_usuario` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`contador`, `tipo_movimiento`, `fk_usuario`, `fk_vehiculo`, `relacion_vehiculo`, `puerta_registro`, `observacion`, `fecha_registro`, `fk_usuario_sistema`, `grupo_usuario`) VALUES
(5, 'ENTRADA', '123456789', NULL, NULL, '', 'peatonal', '2025-05-02 23:31:33', '123456789', 'vigilantes'),
(6, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', '', '2025-05-02 23:32:48', '123456789', 'vigilantes'),
(7, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', '', '2025-05-02 23:34:12', '123456789', 'vigilantes'),
(8, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', '', '2025-05-02 23:34:53', '123456789', 'vigilantes'),
(9, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-02 23:49:54', '123456789', 'vigilantes'),
(10, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', '', '2025-05-02 23:51:34', '123456789', 'vigilantes'),
(11, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-03 00:04:37', '123456789', 'vigilantes'),
(12, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 11:27:26', '123456789', 'vigilantes'),
(13, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 11:40:21', '123456789', 'vigilantes'),
(14, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 11:43:45', '123456789', 'vigilantes'),
(15, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 11:44:32', '123456789', 'vigilantes'),
(16, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 11:49:12', '123456789', 'vigilantes'),
(17, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 12:16:30', '123456789', 'vigilantes'),
(18, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 12:18:35', '123456789', 'vigilantes'),
(19, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 12:21:58', '123456789', 'vigilantes'),
(20, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 13:37:45', '123456789', 'vigilantes'),
(21, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 13:39:14', '123456789', 'vigilantes'),
(22, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 13:39:50', '123456789', 'vigilantes'),
(23, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 13:42:02', '123456789', 'vigilantes'),
(24, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 13:44:11', '123456789', 'vigilantes'),
(25, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-05 13:44:42', '123456789', 'vigilantes'),
(26, 'ENTRADA', '132456647', NULL, NULL, 'peatonal', NULL, '2025-05-08 13:32:43', '123456789', 'visitantes'),
(27, 'ENTRADA', '1234567890', NULL, NULL, 'peatonal', NULL, '2025-05-08 13:37:50', '123456789', 'visitantes'),
(28, 'ENTRADA', '1234567891', NULL, NULL, 'peatonal', NULL, '2025-05-08 13:42:52', '123456789', 'visitantes'),
(29, 'ENTRADA', '1234567892', NULL, NULL, 'peatonal', NULL, '2025-05-08 13:50:48', '123456789', 'visitantes'),
(30, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-09 15:04:01', '123456789', 'vigilantes'),
(31, 'ENTRADA', '12345678900', NULL, NULL, 'peatonal', NULL, '2025-05-09 15:24:28', '123456789', 'visitantes'),
(32, 'ENTRADA', '2323323', NULL, NULL, 'peatonal', NULL, '2025-05-09 15:45:42', '123456789', 'visitantes'),
(33, 'ENTRADA', '34343434', NULL, NULL, 'peatonal', NULL, '2025-05-09 15:50:02', '123456789', 'visitantes'),
(34, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-09 16:02:30', '123456789', 'vigilantes'),
(35, 'ENTRADA', '1114813615', NULL, NULL, 'peatonal', NULL, '2025-05-12 08:59:16', '123456789', 'visitantes'),
(49, 'ENTRADA', '123456789', 'asd123', 'propietario', 'peatonal', 'NULL', '2025-05-14 02:30:46', '123456789', 'vigilantes'),
(50, 'ENTRADA', '1234567890', 'asd123', 'pasajero', 'peatonal', 'NULL', '2025-05-14 02:30:46', '123456789', 'visitantes'),
(51, 'ENTRADA', '123456', 'asd123', 'propietario', 'peatonal', 'NULL', '2025-05-14 02:36:51', '123456789', 'visitantes'),
(52, 'ENTRADA', '12345678907', 'asd123', 'propietario', 'peatonal', 'NULL', '2025-05-14 02:39:29', '123456789', 'visitantes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades_usuarios`
--

CREATE TABLE `novedades_usuarios` (
  `contador` int(11) NOT NULL,
  `tipo_novedad` varchar(21) NOT NULL,
  `puerta_suceso` varchar(9) NOT NULL,
  `puerta_registro` varchar(9) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_suceso` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `novedades_usuarios`
--

INSERT INTO `novedades_usuarios` (`contador`, `tipo_novedad`, `puerta_suceso`, `puerta_registro`, `descripcion`, `fk_usuario`, `fecha_suceso`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(1, 'Salida no registrada', 'ganaderia', 'peatonal', 'no se le registra la salida', '123456789', '2025-05-09 14:51:00', '2025-05-09 15:03:53', '123456789'),
(2, 'Salida no registrada', 'ganaderia', 'peatonal', 'no se le registra la salida', '123456789', '2025-05-09 16:02:00', '2025-05-09 16:02:26', '123456789'),
(3, 'Salida no registrada', 'ganaderia', 'peatonal', 'no se le registra la salida', '1234567890', '2025-05-13 14:18:00', '2025-05-13 14:18:17', '123456789'),
(4, 'Salida no registrada', 'ganaderia', 'peatonal', 'no se le registra la salida', '123456789', '2025-05-13 18:41:00', '2025-05-13 18:41:33', '123456789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades_vehiculos`
--

CREATE TABLE `novedades_vehiculos` (
  `contador` int(11) NOT NULL,
  `tipo_novedad` varchar(50) NOT NULL,
  `puerta_registro` varchar(9) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `fk_vehiculo` varchar(6) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_permanencia_usuarios`
--

CREATE TABLE `permisos_permanencia_usuarios` (
  `contador` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_fin_permiso` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `estado_permiso` varchar(11) NOT NULL DEFAULT 'PENDIENTE',
  `estado_notificacion` varchar(8) NOT NULL DEFAULT 'NO VISTA',
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_permanencia_vehiculos`
--

CREATE TABLE `permisos_permanencia_vehiculos` (
  `contador` int(11) NOT NULL,
  `fk_vehiculo` varchar(6) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_fin_permiso` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `estado_permiso` varchar(11) NOT NULL DEFAULT 'PENDIENTE',
  `estado_notificacion` varchar(8) NOT NULL DEFAULT 'NO VISTA',
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `contador` int(11) NOT NULL,
  `tipo_vehiculo` varchar(2) NOT NULL,
  `numero_placa` varchar(6) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL,
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`contador`, `tipo_vehiculo`, `numero_placa`, `fk_usuario`, `fecha_registro`, `fk_usuario_sistema`, `ubicacion`) VALUES
(13, 'AT', '123ATI', '1114813617', '2025-05-12 15:32:10', '123456789', 'FUERA'),
(15, 'AT', '123ATY', '1114813610', '2025-05-12 15:38:18', '123456789', 'FUERA'),
(18, 'BS', 'ASD229', '1114813615', '2025-05-12 15:42:34', '123456789', 'FUERA'),
(19, 'AT', 'ASD220', '1114813615', '2025-05-12 15:43:10', '123456789', 'FUERA'),
(20, 'AT', 'asw123', '1114813615', '2025-05-13 16:59:32', '123456789', 'FUERA'),
(21, 'AT', 'asw120', '1114813615', '2025-05-13 17:35:52', '123456789', 'FUERA'),
(24, 'AT', 'asd123', '1114813615', '2025-05-13 18:41:57', '123456789', 'FUERA'),
(32, '', 'asd123', '1234567890', '2025-05-14 02:25:08', '123456789', 'FUERA'),
(33, '', 'asd123', '123456789', '2025-05-14 02:30:46', '123456789', 'FUERA'),
(34, '', 'asd123', '123456', '2025-05-14 02:36:51', '123456789', 'FUERA'),
(35, '', 'asd123', '12345678907', '2025-05-14 02:39:29', '123456789', 'FUERA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vigilantes`
--

CREATE TABLE `vigilantes` (
  `contador` int(11) NOT NULL,
  `tipo_documento` varchar(3) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(64) NOT NULL,
  `rol` varchar(15) NOT NULL,
  `contrasena` varchar(32) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_ultima_sesion` datetime NOT NULL,
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA',
  `estado_usuario` varchar(8) NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `vigilantes`
--

INSERT INTO `vigilantes` (`contador`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `rol`, `contrasena`, `fecha_registro`, `fecha_ultima_sesion`, `ubicacion`, `estado_usuario`) VALUES
(2, 'CC', '123456789', 'Sara', 'Rico', '1234567890', 'sara@gmail.com', 'jefe vigilantes', '25d55ad283aa400af464c76d713c07ad', '2025-04-30 05:30:11', '2025-04-30 05:30:11', 'DENTRO', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `contador` int(11) NOT NULL,
  `tipo_documento` varchar(3) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(64) NOT NULL,
  `motivo_ingreso` varchar(150) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `ubicacion` varchar(8) NOT NULL DEFAULT 'FUERA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`contador`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `motivo_ingreso`, `fecha_registro`, `ubicacion`) VALUES
(1, '', '', '', '', '', '', '', '2025-05-08 11:20:55', 'FUERA'),
(2, 'CC', '12133344', '', '', '1234567890', '', 'yyuuyuyyyyuyuy', '2025-05-08 12:17:02', 'FUERA'),
(3, 'CC', '121212122', '', '', '1234567890', 'amerik640@gmail.com', 'yyuuyuyyyyuyuy', '2025-05-08 13:02:30', 'FUERA'),
(4, 'CC', '132456647', 'dfdfddfd', 'fdfdfdfdf', '1234567890', 'amerik640@gmail.com', 'yyuuyuyyyyuyuy', '2025-05-08 13:22:31', 'DENTRO'),
(5, 'CC', '1234567890', 'dfdfddfd', 'fdfdfdfdf', '1234567890', 'amerik640@gmail.com', 'yyuuyuyyyyuyuy', '2025-05-08 13:31:37', 'DENTRO'),
(6, 'CC', '1234567891', 'Sara', 'Rico', '1234567890', 'sara@gmail.com', '', '2025-05-08 13:52:42', 'DENTRO'),
(7, 'CC', '1234567892', 'Sara', 'Rico', '1234567890', 'sara@gmail.com', 'La ficha del aprendiz ha finalizado.', '2025-05-08 13:48:50', 'DENTRO'),
(8, 'CC', '12345678900', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-09 15:49:22', 'DENTRO'),
(9, 'CC', '43434343', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-09 15:48:36', 'FUERA'),
(10, 'CC', '2323323', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-09 15:38:45', 'DENTRO'),
(11, 'CC', '34343434', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-09 15:57:49', 'DENTRO'),
(12, 'CC', '1114813615', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-12 08:13:59', 'DENTRO'),
(13, 'CC', '1114813617', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-12 15:44:08', 'FUERA'),
(14, 'CC', '1114813610', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-12 15:15:38', 'FUERA'),
(15, 'CC', '31314414', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-12 16:22:25', 'FUERA'),
(16, 'CC', '3244555', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-12 16:32:41', 'FUERA'),
(17, 'CC', '13242444', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-12 16:02:43', 'FUERA'),
(18, 'CC', '12345678976', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-13 11:15:45', 'FUERA'),
(19, 'CC', '12345678907', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-13 12:31:01', 'DENTRO'),
(20, 'CC', '123456', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-05-13 19:52:19', 'DENTRO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `estadias_aprendices`
--
ALTER TABLE `estadias_aprendices`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `novedades_vehiculos`
--
ALTER TABLE `novedades_vehiculos`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `permisos_permanencia_usuarios`
--
ALTER TABLE `permisos_permanencia_usuarios`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `permisos_permanencia_vehiculos`
--
ALTER TABLE `permisos_permanencia_vehiculos`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`contador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendas`
--
ALTER TABLE `agendas`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estadias_aprendices`
--
ALTER TABLE `estadias_aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `novedades_vehiculos`
--
ALTER TABLE `novedades_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_permanencia_usuarios`
--
ALTER TABLE `permisos_permanencia_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_permanencia_vehiculos`
--
ALTER TABLE `permisos_permanencia_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
