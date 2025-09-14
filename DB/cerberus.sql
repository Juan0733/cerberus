-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2025 a las 00:05:36
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `contador` int(11) NOT NULL,
  `tipo_usuario` varchar(8) NOT NULL DEFAULT 'APRENDIZ',
  `tipo_documento` varchar(3) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(64) NOT NULL,
  `fk_ficha` varchar(7) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `contador` int(11) NOT NULL,
  `numero_ficha` varchar(7) NOT NULL,
  `nombre_programa` varchar(50) NOT NULL,
  `fecha_fin_ficha` date NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

CREATE TABLE `funcionarios` (
  `contador` int(11) NOT NULL,
  `tipo_usuario` varchar(11) NOT NULL DEFAULT 'FUNCIONARIO',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`contador`, `tipo_usuario`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `rol`, `tipo_contrato`, `fecha_fin_contrato`, `contrasena`, `brigadista`, `fecha_registro`, `fecha_ultima_sesion`, `ubicacion`, `estado_usuario`) VALUES
(1, 'FUNCIONARIO', 'CC', '1234567892', 'Heberth Hernando ', 'Garcia Tamayo', '1234567890', 'hgarciat@sena.edu.co', 'SUBDIRECTOR', 'PLANTA', NULL, '25d55ad283aa400af464c76d713c07ad', 'NO', '2025-07-20 02:51:05', '2025-08-31 06:42:48', 'FUERA', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_ingreso`
--

CREATE TABLE `motivos_ingreso` (
  `contador` int(11) NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `contador` int(11) NOT NULL,
  `codigo_movimiento` varchar(16) NOT NULL,
  `tipo_movimiento` varchar(7) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fk_vehiculo` varchar(6) DEFAULT NULL,
  `relacion_vehiculo` varchar(11) DEFAULT NULL,
  `puerta_registro` varchar(9) NOT NULL,
  `observacion` varchar(150) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL,
  `tipo_usuario` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades_usuarios`
--

CREATE TABLE `novedades_usuarios` (
  `contador` int(11) NOT NULL,
  `codigo_novedad` varchar(16) NOT NULL,
  `tipo_novedad` varchar(21) NOT NULL,
  `puerta_suceso` varchar(9) NOT NULL,
  `puerta_registro` varchar(9) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_suceso` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades_vehiculos`
--

CREATE TABLE `novedades_vehiculos` (
  `contador` int(11) NOT NULL,
  `codigo_novedad` varchar(16) NOT NULL,
  `tipo_novedad` varchar(50) NOT NULL,
  `puerta_registro` varchar(9) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `fk_vehiculo` varchar(6) NOT NULL,
  `fk_usuario_involucrado` varchar(15) NOT NULL,
  `fk_usuario_autoriza` varchar(15) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_usuarios`
--

CREATE TABLE `permisos_usuarios` (
  `contador` int(11) NOT NULL,
  `codigo_permiso` varchar(16) NOT NULL,
  `tipo_permiso` varchar(50) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_fin_permiso` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_autorizacion` datetime DEFAULT NULL,
  `fk_usuario_autorizacion` varchar(15) DEFAULT NULL,
  `estado_permiso` varchar(11) NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_vehiculos`
--

CREATE TABLE `permisos_vehiculos` (
  `contador` int(11) NOT NULL,
  `codigo_permiso` varchar(16) NOT NULL,
  `tipo_permiso` varchar(50) NOT NULL,
  `fk_vehiculo` varchar(6) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_fin_permiso` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_autorizacion` datetime DEFAULT NULL,
  `fk_usuario_autorizacion` datetime DEFAULT NULL,
  `estado_permiso` varchar(11) NOT NULL DEFAULT 'PENDIENTE',
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_operaciones`
--

CREATE TABLE `roles_operaciones` (
  `contador` int(11) NOT NULL,
  `operacion` varchar(100) NOT NULL,
  `rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `roles_operaciones`
--

INSERT INTO `roles_operaciones` (`contador`, `operacion`, `rol`) VALUES
(1, 'consultar_agendas', 'SUPERVISOR'),
(2, 'consultar_agenda', 'SUPERVISOR'),
(3, 'consultar_aprendices', 'SUPERVISOR'),
(4, 'consultar_aprendiz', 'SUPERVISOR'),
(5, 'consultar_funcionarios', 'SUPERVISOR'),
(6, 'consultar_funcionario', 'SUPERVISOR'),
(7, 'conteo_total_brigadistas', 'SUPERVISOR'),
(8, 'registrar_entrada_peatonal', 'SUPERVISOR'),
(9, 'registrar_salida_peatonal', 'SUPERVISOR'),
(10, 'registrar_entrada_vehicular', 'SUPERVISOR'),
(11, 'registrar_salida_vehicular', 'SUPERVISOR'),
(12, 'validar_usuario_apto_entrada', 'SUPERVISOR'),
(13, 'validar_usuario_apto_salida', 'SUPERVISOR'),
(14, 'consultar_movimientos', 'SUPERVISOR'),
(15, 'registrar_novedad_usuario', 'SUPERVISOR'),
(16, 'consultar_novedades_usuario', 'SUPERVISOR'),
(17, 'consultar_novedad_usuario', 'SUPERVISOR'),
(18, 'registrar_novedad_vehiculo', 'SUPERVISOR'),
(19, 'consultar_novedades_vehiculo', 'SUPERVISOR'),
(20, 'consultar_novedad_vehiculo', 'SUPERVISOR'),
(21, 'consultar_notificaciones_usuario', 'SUPERVISOR'),
(22, 'conteo_total_usuarios', 'SUPERVISOR'),
(23, 'conteo_tipo_usuario', 'SUPERVISOR'),
(24, 'cerrar_sesion', 'SUPERVISOR'),
(25, 'registrar_vehiculo', 'SUPERVISOR'),
(26, 'consultar_vehiculos', 'SUPERVISOR'),
(27, 'consultar_vehiculo', 'SUPERVISOR'),
(28, 'consultar_propietarios', 'SUPERVISOR'),
(29, 'eliminar_propietario_vehiculo', 'SUPERVISOR'),
(30, 'conteo_tipo_vehiculo', 'SUPERVISOR'),
(31, 'consultar_notificaciones_vehiculo', 'SUPERVISOR'),
(32, 'registrar_vigilante', 'SUPERVISOR'),
(33, 'actualizar_vigilante', 'SUPERVISOR'),
(34, 'guardar_puerta', 'SUPERVISOR'),
(35, 'habilitar_vigilante', 'SUPERVISOR'),
(36, 'inhabilitar_vigilante', 'SUPERVISOR'),
(37, 'consultar_vigilantes', 'SUPERVISOR'),
(38, 'consultar_vigilante', 'SUPERVISOR'),
(39, 'consultar_puerta', 'SUPERVISOR'),
(40, 'registrar_visitante', 'SUPERVISOR'),
(41, 'consultar_visitantes', 'SUPERVISOR'),
(42, 'consultar_visitante', 'SUPERVISOR'),
(43, 'consultar_agendas', 'VIGILANTE'),
(44, 'consultar_agenda', 'VIGILANTE'),
(45, 'consultar_aprendices', 'VIGILANTE'),
(46, 'consultar_aprendiz', 'VIGILANTE'),
(47, 'consultar_funcionarios', 'VIGILANTE'),
(48, 'consultar_funcionario', 'VIGILANTE'),
(49, 'conteo_total_brigadistas', 'VIGILANTE'),
(50, 'registrar_entrada_peatonal', 'VIGILANTE'),
(51, 'registrar_salida_peatonal', 'VIGILANTE'),
(52, 'registrar_entrada_vehicular', 'VIGILANTE'),
(53, 'registrar_salida_vehicular', 'VIGILANTE'),
(54, 'validar_usuario_apto_entrada', 'VIGILANTE'),
(55, 'validar_usuario_apto_salida', 'VIGILANTE'),
(56, 'registrar_novedad_usuario', 'VIGILANTE'),
(57, 'registrar_novedad_vehiculo', 'VIGILANTE'),
(58, 'conteo_total_usuarios', 'VIGILANTE'),
(59, 'conteo_tipo_usuario', 'VIGILANTE'),
(60, 'cerrar_sesion', 'VIGILANTE'),
(61, 'registrar_vehiculo', 'VIGILANTE'),
(62, 'consultar_vehiculos', 'VIGILANTE'),
(63, 'consultar_vehiculo', 'VIGILANTE'),
(64, 'consultar_propietarios', 'VIGILANTE'),
(65, 'conteo_tipo_vehiculo', 'VIGILANTE'),
(66, 'guardar_puerta', 'VIGILANTE'),
(67, 'consultar_vigilantes', 'VIGILANTE'),
(68, 'consultar_vigilante', 'VIGILANTE'),
(69, 'consultar_puerta', 'VIGILANTE'),
(70, 'registrar_visitante', 'VIGILANTE'),
(71, 'consultar_visitantes', 'VIGILANTE'),
(72, 'consultar_visitante', 'VIGILANTE'),
(73, 'registrar_agenda_individual', 'COORDINADOR'),
(74, 'actualizar_agenda', 'COORDINADOR'),
(75, 'eliminar_agenda', 'COORDINADOR'),
(76, 'consultar_agendas', 'COORDINADOR'),
(77, 'consultar_agenda', 'COORDINADOR'),
(78, 'registrar_aprendiz', 'COORDINADOR'),
(79, 'actualizar_aprendiz', 'COORDINADOR'),
(80, 'consultar_aprendices', 'COORDINADOR'),
(81, 'consultar_aprendiz', 'COORDINADOR'),
(82, 'consultar_funcionarios', 'COORDINADOR'),
(83, 'consultar_funcionario', 'COORDINADOR'),
(84, 'conteo_total_brigadistas', 'COORDINADOR'),
(85, 'conteo_total_usuarios', 'COORDINADOR'),
(86, 'conteo_tipo_usuario', 'COORDINADOR'),
(87, 'cerrar_sesion', 'COORDINADOR'),
(88, 'registrar_vehiculo', 'COORDINADOR'),
(89, 'conteo_tipo_vehiculo', 'COORDINADOR'),
(90, 'guardar_puerta', 'COORDINADOR'),
(91, 'consultar_vigilantes', 'COORDINADOR'),
(92, 'consultar_vigilante', 'COORDINADOR'),
(93, 'registrar_visitante', 'COORDINADOR'),
(94, 'consultar_visitantes', 'COORDINADOR'),
(95, 'consultar_visitante', 'COORDINADOR'),
(96, 'registrar_agenda_individual', 'SUBDIRECTOR'),
(97, 'actualizar_agenda', 'SUBDIRECTOR'),
(98, 'eliminar_agenda', 'SUBDIRECTOR'),
(99, 'consultar_agendas', 'SUBDIRECTOR'),
(100, 'consultar_agenda', 'SUBDIRECTOR'),
(101, 'registrar_aprendiz', 'SUBDIRECTOR'),
(102, 'actualizar_aprendiz', 'SUBDIRECTOR'),
(103, 'consultar_aprendices', 'SUBDIRECTOR'),
(104, 'consultar_aprendiz', 'SUBDIRECTOR'),
(105, 'registrar_funcionario', 'SUBDIRECTOR'),
(106, 'actualizar_funcionario', 'SUBDIRECTOR'),
(107, 'consultar_funcionarios', 'SUBDIRECTOR'),
(108, 'consultar_funcionario', 'SUBDIRECTOR'),
(109, 'conteo_total_brigadistas', 'SUBDIRECTOR'),
(110, 'consultar_movimientos', 'SUBDIRECTOR'),
(111, 'consultar_movimientos_usuarios', 'SUBDIRECTOR'),
(112, 'generar_pdf_movimientos', 'SUBDIRECTOR'),
(113, 'consultar_novedades_usuario', 'SUBDIRECTOR'),
(114, 'consultar_novedad_usuario', 'SUBDIRECTOR'),
(115, 'consultar_novedades_vehiculo', 'SUBDIRECTOR'),
(116, 'consultar_novedad_vehiculo', 'SUBDIRECTOR'),
(117, 'conteo_total_usuarios', 'SUBDIRECTOR'),
(118, 'conteo_tipo_usuario', 'SUBDIRECTOR'),
(119, 'cerrar_sesion', 'SUBDIRECTOR'),
(120, 'registrar_vehiculo', 'SUBDIRECTOR'),
(121, 'consultar_vehiculos', 'SUBDIRECTOR'),
(122, 'consultar_vehiculo', 'SUBDIRECTOR'),
(123, 'consultar_propietarios', 'SUBDIRECTOR'),
(124, 'eliminar_propietario_vehiculo', 'SUBDIRECTOR'),
(125, 'conteo_tipo_vehiculo', 'SUBDIRECTOR'),
(126, 'registrar_vigilante', 'SUBDIRECTOR'),
(127, 'actualizar_vigilante', 'SUBDIRECTOR'),
(128, 'habilitar_vigilante', 'SUBDIRECTOR'),
(129, 'inhabilitar_vigilante', 'SUBDIRECTOR'),
(130, 'consultar_vigilantes', 'SUBDIRECTOR'),
(131, 'consultar_vigilante', 'SUBDIRECTOR'),
(132, 'registrar_visitante', 'SUBDIRECTOR'),
(133, 'consultar_visitantes', 'SUBDIRECTOR'),
(134, 'consultar_visitante', 'SUBDIRECTOR'),
(135, 'validar_usuario', 'INVITADO'),
(136, 'validar_contrasena', 'INVITADO'),
(137, 'registrar_aprendiz', 'INVITADO'),
(138, 'auto_registrar_funcionario', 'INVITADO'),
(139, 'auto_registrar_vigilante', 'INVITADO'),
(140, 'registrar_visitante', 'INVITADO'),
(141, 'registrar_permiso_usuario', 'SUPERVISOR'),
(142, 'aprobar_permiso_usuario', 'SUBDIRECTOR'),
(143, 'desaprobar_permiso_usuario', 'SUBDIRECTOR'),
(144, 'consultar_permisos_usuarios', 'SUPERVISOR'),
(145, 'consultar_permisos_usuarios', 'SUBDIRECTOR'),
(146, 'consultar_permiso_usuario', 'SUBDIRECTOR'),
(147, 'consultar_permiso_usuario', 'SUPERVISOR'),
(148, 'registrar_permiso_vehiculo', 'SUPERVISOR'),
(149, 'aprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(150, 'desaprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(151, 'consultar_permisos_vehiculos', 'SUPERVISOR'),
(152, 'consultar_permiso_vehiculo', 'SUPERVISOR'),
(153, 'consultar_permisos_vehiculos', 'SUBDIRECTOR'),
(154, 'consultar_permiso_vehiculo', 'SUBDIRECTOR'),
(155, 'consultar_notificaciones_permisos_vehiculo', 'SUBDIRECTOR'),
(156, 'consultar_notificaciones_permisos_usuario', 'SUBDIRECTOR'),
(157, 'registrar_agenda_grupal', 'SUBDIRECTOR'),
(158, 'registrar_agenda_grupal', 'COORDINADOR'),
(159, 'consultar_movimiento', 'SUPERVISOR'),
(160, 'consultar_movimiento', 'SUBDIRECTOR'),
(161, 'habilitar_funcionario', 'SUBDIRECTOR'),
(162, 'inhabilitar_funcionario', 'SUBDIRECTOR'),
(163, 'registrar_funcionario', 'COORDINADOR'),
(164, 'actualizar_funcionario', 'COORDINADOR'),
(165, 'habilitar_funcionario', 'COORDINADOR'),
(166, 'inhabilitar_funcionario', 'COORDINADOR'),
(167, 'conteo_total_brigadistas', 'INSTRUCTOR'),
(168, 'conteo_total_usuarios', 'INSTRUCTOR'),
(169, 'conteo_tipo_usuario', 'INSTRUCTOR'),
(170, 'conteo_tipo_vehiculo', 'INSTRUCTOR'),
(171, 'consultar_agendas', 'INSTRUCTOR'),
(172, 'consultar_agenda', 'INSTRUCTOR'),
(173, 'registrar_agenda_individual', 'INSTRUCTOR'),
(174, 'actualizar_agenda', 'INSTRUCTOR'),
(175, 'eliminar_agenda', 'INSTRUCTOR'),
(176, 'consultar_permisos_usuarios', 'INSTRUCTOR'),
(177, 'consultar_permiso_usuario', 'INSTRUCTOR'),
(178, 'registrar_permiso_usuario', 'INSTRUCTOR'),
(179, 'consultar_permisos_usuarios', 'COORDINADOR'),
(180, 'consultar_permiso_usuario', 'COORDINADOR'),
(181, 'registrar_permiso_usuario', 'COORDINADOR'),
(182, 'consultar_permisos_usuarios', 'VIGILANTE'),
(183, 'consultar_permiso_usuario', 'VIGILANTE'),
(184, 'consultar_funcionarios', 'INSTRUCTOR'),
(185, 'registrar_agenda_grupal', 'INSTRUCTOR'),
(186, 'cerrar_sesion', 'INSTRUCTOR'),
(187, 'registrar_vehiculo', 'INSTRUCTOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `contador` int(11) NOT NULL,
  `tipo_vehiculo` varchar(10) NOT NULL,
  `numero_placa` varchar(6) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL,
  `ubicacion` varchar(6) NOT NULL,
  `estado_propiedad` varchar(8) NOT NULL DEFAULT 'ACTIVA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vigilantes`
--

CREATE TABLE `vigilantes` (
  `contador` int(11) NOT NULL,
  `tipo_usuario` varchar(9) NOT NULL DEFAULT 'VIGILANTE',
  `tipo_documento` varchar(3) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(64) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `contrasena` varchar(32) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_ultima_sesion` datetime DEFAULT NULL,
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA',
  `estado_usuario` varchar(8) NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `contador` int(11) NOT NULL,
  `tipo_usuario` varchar(9) NOT NULL DEFAULT 'VISITANTE',
  `tipo_documento` varchar(3) NOT NULL,
  `numero_documento` varchar(15) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(64) NOT NULL,
  `motivo_ingreso` varchar(150) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `ubicacion` varchar(8) NOT NULL DEFAULT 'FUERA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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
-- Indices de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `permisos_vehiculos`
--
ALTER TABLE `permisos_vehiculos`
  ADD PRIMARY KEY (`contador`);

--
-- Indices de la tabla `roles_operaciones`
--
ALTER TABLE `roles_operaciones`
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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `novedades_vehiculos`
--
ALTER TABLE `novedades_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos_vehiculos`
--
ALTER TABLE `permisos_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles_operaciones`
--
ALTER TABLE `roles_operaciones`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
