-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2025 a las 05:52:08
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
(11, 'CC', '1234567890', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(12, 'CC', '1234567890', 'Juan David', 'Restrepo Perez', '1234567897', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(13, 'CC', '1234567890', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(14, 'CC', '1234567899', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(15, 'CC', '1234567893', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(16, 'CC', '12345678902', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(17, 'CC', '12345678901', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(18, 'CC', '12345678908', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(19, 'CC', '123456789077', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(20, 'CC', '123456789055', 'Juan David', 'Restrepo Perez', '1234567897', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL);

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
(71, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-19 11:33:26', '123456789', 'vigilantes'),
(72, 'ENTRADA', '123456789', 'ASD123', 'propietario', 'peatonal', 'NULL', '2025-04-19 13:25:03', '123456789', 'vigilantes');

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
  `fk_usuario_involucrado` varchar(15) NOT NULL,
  `fk_usuario_autoriza` varchar(15) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `novedades_vehiculos`
--

INSERT INTO `novedades_vehiculos` (`contador`, `tipo_novedad`, `puerta_registro`, `descripcion`, `fk_vehiculo`, `fk_usuario_involucrado`, `fk_usuario_autoriza`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(1, 'VEHICULO PRESTADO', 'peatonal', 'dfdfdfdfdf', 'fg300', '12345678901', '1114813615', '2025-05-17 17:03:15', '123456789');

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
(49, 'AT', 'ASD123', '123456789', '2025-05-19 13:24:42', '123456789', 'DENTRO');

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `novedades_vehiculos`
--
ALTER TABLE `novedades_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
