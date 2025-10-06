-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2025 a las 03:57:46
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
  `rol_usuario_sistema` varchar(20) NOT NULL,
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
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA',
  `rol_usuario_sistema` varchar(20) NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
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
  `fecha_registro` datetime NOT NULL,
  `rol_usuario_sistema` varchar(20) NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
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
  `estado_usuario` varchar(8) DEFAULT NULL,
  `rol_usuario_sistema` varchar(20) DEFAULT NULL,
  `fk_usuario_sistema` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`contador`, `tipo_usuario`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `rol`, `tipo_contrato`, `fecha_fin_contrato`, `contrasena`, `brigadista`, `fecha_registro`, `fecha_ultima_sesion`, `ubicacion`, `estado_usuario`, `rol_usuario_sistema`, `fk_usuario_sistema`) VALUES
(1, 'FUNCIONARIO', 'CC', '1234567892', 'Heberth Hernando ', 'Garcia Tamayo', '1234567890', 'hgarciat@sena.edu.co', 'SUBDIRECTOR', 'PLANTA', NULL, '25d55ad283aa400af464c76d713c07ad', 'NO', '2025-09-23 03:55:28', NULL, 'FUERA', 'ACTIVO', NULL, NULL);

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
  `rol_usuario_sistema` varchar(20) NOT NULL,
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
  `rol_usuario_sistema` varchar(20) NOT NULL,
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
  `rol_usuario_sistema` varchar(20) NOT NULL,
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
  `rol_usuario_autorizacion` varchar(20) DEFAULT NULL,
  `fk_usuario_autorizacion` varchar(15) DEFAULT NULL,
  `estado_permiso` varchar(11) NOT NULL,
  `rol_usuario_sistema` varchar(20) NOT NULL,
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
  `rol_usuario_autorizacion` varchar(20) DEFAULT NULL,
  `fk_usuario_autorizacion` datetime DEFAULT NULL,
  `estado_permiso` varchar(11) NOT NULL DEFAULT 'PENDIENTE',
  `rol_usuario_sistema` varchar(20) NOT NULL,
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
(1, 'actualizar_contrasena_usuario', 'SUPERVISOR'),
(2, 'actualizar_vigilante', 'SUPERVISOR'),
(3, 'consultar_agendas', 'SUPERVISOR'),
(4, 'consultar_agenda', 'SUPERVISOR'),
(5, 'consultar_aprendices', 'SUPERVISOR'),
(6, 'consultar_aprendiz', 'SUPERVISOR'),
(7, 'consultar_funcionarios', 'SUPERVISOR'),
(8, 'consultar_funcionario', 'SUPERVISOR'),
(9, 'conteo_total_brigadistas', 'SUPERVISOR'),
(10, 'consultar_permisos_usuarios', 'SUPERVISOR'),
(11, 'consultar_movimiento', 'SUPERVISOR'),
(12, 'consultar_ultimo_movimiento_usuario', 'SUPERVISOR'),
(13, 'consultar_permiso_usuario', 'SUPERVISOR'),
(14, 'consultar_permisos_vehiculos', 'SUPERVISOR'),
(15, 'consultar_permiso_vehiculo', 'SUPERVISOR'),
(16, 'consultar_movimientos', 'SUPERVISOR'),
(17, 'consultar_vigilantes', 'SUPERVISOR'),
(18, 'consultar_vigilante', 'SUPERVISOR'),
(19, 'consultar_puerta', 'SUPERVISOR'),
(20, 'consultar_visitantes', 'SUPERVISOR'),
(21, 'consultar_visitante', 'SUPERVISOR'),
(22, 'consultar_novedades_usuario', 'SUPERVISOR'),
(23, 'consultar_novedad_usuario', 'SUPERVISOR'),
(24, 'consultar_novedades_vehiculo', 'SUPERVISOR'),
(25, 'consultar_novedad_vehiculo', 'SUPERVISOR'),
(26, 'consultar_vehiculos', 'SUPERVISOR'),
(27, 'consultar_vehiculo', 'SUPERVISOR'),
(28, 'consultar_propietarios', 'SUPERVISOR'),
(29, 'consultar_notificaciones_usuario', 'SUPERVISOR'),
(30, 'consultar_notificaciones_vehiculo', 'SUPERVISOR'),
(31, 'conteo_total_usuarios', 'SUPERVISOR'),
(32, 'conteo_tipo_usuario', 'SUPERVISOR'),
(33, 'conteo_tipo_vehiculo', 'SUPERVISOR'),
(34, 'cerrar_sesion', 'SUPERVISOR'),
(35, 'eliminar_propietario_vehiculo', 'SUPERVISOR'),
(36, 'guardar_puerta', 'SUPERVISOR'),
(37, 'habilitar_vigilante', 'SUPERVISOR'),
(38, 'inhabilitar_vigilante', 'SUPERVISOR'),
(39, 'registrar_vigilante_individual', 'SUPERVISOR'),
(40, 'registrar_novedad_vehiculo', 'SUPERVISOR'),
(41, 'registrar_permiso_usuario', 'SUPERVISOR'),
(42, 'registrar_novedad_usuario', 'SUPERVISOR'),
(43, 'registrar_permiso_vehiculo', 'SUPERVISOR'),
(44, 'registrar_salida_peatonal', 'SUPERVISOR'),
(45, 'registrar_entrada_vehicular', 'SUPERVISOR'),
(46, 'registrar_salida_vehicular', 'SUPERVISOR'),
(47, 'registrar_vigilante_carga_masiva', 'SUPERVISOR'),
(48, 'registrar_entrada_peatonal', 'SUPERVISOR'),
(49, 'registrar_vehiculo', 'SUPERVISOR'),
(50, 'validar_usuario_apto_entrada', 'SUPERVISOR'),
(51, 'validar_usuario_apto_salida', 'SUPERVISOR'),
(52, 'actualizar_contrasena_usuario', 'VIGILANTE'),
(53, 'consultar_agendas', 'VIGILANTE'),
(54, 'consultar_agenda', 'VIGILANTE'),
(55, 'consultar_aprendices', 'VIGILANTE'),
(56, 'consultar_aprendiz', 'VIGILANTE'),
(57, 'consultar_funcionarios', 'VIGILANTE'),
(58, 'consultar_funcionario', 'VIGILANTE'),
(59, 'consultar_vigilantes', 'VIGILANTE'),
(60, 'consultar_vigilante', 'VIGILANTE'),
(61, 'consultar_puerta', 'VIGILANTE'),
(62, 'consultar_visitantes', 'VIGILANTE'),
(63, 'consultar_visitante', 'VIGILANTE'),
(64, 'consultar_permisos_usuarios', 'VIGILANTE'),
(65, 'consultar_permiso_usuario', 'VIGILANTE'),
(66, 'consultar_ultimo_movimiento_usuario', 'VIGILANTE'),
(67, 'consultar_vehiculos', 'VIGILANTE'),
(68, 'consultar_vehiculo', 'VIGILANTE'),
(69, 'consultar_propietarios', 'VIGILANTE'),
(70, 'conteo_tipo_vehiculo', 'VIGILANTE'),
(71, 'conteo_total_brigadistas', 'VIGILANTE'),
(72, 'conteo_total_usuarios', 'VIGILANTE'),
(73, 'conteo_tipo_usuario', 'VIGILANTE'),
(74, 'cerrar_sesion', 'VIGILANTE'),
(75, 'guardar_puerta', 'VIGILANTE'),
(76, 'registrar_novedad_usuario', 'VIGILANTE'),
(77, 'registrar_novedad_vehiculo', 'VIGILANTE'),
(78, 'registrar_vehiculo', 'VIGILANTE'),
(79, 'registrar_entrada_peatonal', 'VIGILANTE'),
(80, 'registrar_salida_peatonal', 'VIGILANTE'),
(81, 'registrar_entrada_vehicular', 'VIGILANTE'),
(82, 'registrar_salida_vehicular', 'VIGILANTE'),
(83, 'validar_usuario_apto_entrada', 'VIGILANTE'),
(84, 'validar_usuario_apto_salida', 'VIGILANTE'),
(85, 'actualizar_contrasena_usuario', 'COORDINADOR'),
(86, 'actualizar_agenda', 'COORDINADOR'),
(87, 'actualizar_funcionario', 'COORDINADOR'),
(88, 'actualizar_aprendiz', 'COORDINADOR'),
(89, 'consultar_ficha', 'COORDINADOR'),
(90, 'consultar_fichas', 'COORDINADOR'),
(91, 'consultar_agendas', 'COORDINADOR'),
(92, 'consultar_agenda', 'COORDINADOR'),
(93, 'consultar_aprendices', 'COORDINADOR'),
(94, 'consultar_aprendiz', 'COORDINADOR'),
(95, 'consultar_funcionarios', 'COORDINADOR'),
(96, 'consultar_funcionario', 'COORDINADOR'),
(97, 'conteo_total_brigadistas', 'COORDINADOR'),
(98, 'conteo_total_usuarios', 'COORDINADOR'),
(99, 'conteo_tipo_usuario', 'COORDINADOR'),
(100, 'conteo_tipo_vehiculo', 'COORDINADOR'),
(101, 'consultar_vigilantes', 'COORDINADOR'),
(102, 'consultar_vigilante', 'COORDINADOR'),
(103, 'consultar_visitantes', 'COORDINADOR'),
(104, 'consultar_visitante', 'COORDINADOR'),
(105, 'consultar_permisos_usuarios', 'COORDINADOR'),
(106, 'consultar_permiso_usuario', 'COORDINADOR'),
(107, 'cerrar_sesion', 'COORDINADOR'),
(108, 'eliminar_agenda', 'COORDINADOR'),
(109, 'guardar_puerta', 'COORDINADOR'),
(110, 'habilitar_funcionario', 'COORDINADOR'),
(111, 'inhabilitar_funcionario', 'COORDINADOR'),
(112, 'registrar_funcionario_individual', 'COORDINADOR'),
(113, 'registrar_permiso_usuario', 'COORDINADOR'),
(114, 'registrar_agenda_carga_masiva', 'COORDINADOR'),
(115, 'registrar_aprendiz_individual', 'COORDINADOR'),
(116, 'registrar_aprendiz_carga_masiva', 'COORDINADOR'),
(117, 'registrar_agenda_individual', 'COORDINADOR'),
(118, 'registrar_vehiculo', 'COORDINADOR'),
(119, 'registrar_funcionario_carga_masiva', 'COORDINADOR'),
(120, 'aprobar_permiso_usuario', 'SUBDIRECTOR'),
(121, 'aprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(122, 'actualizar_agenda', 'SUBDIRECTOR'),
(123, 'actualizar_aprendiz', 'SUBDIRECTOR'),
(124, 'actualizar_contrasena_usuario', 'SUBDIRECTOR'),
(125, 'actualizar_funcionario', 'SUBDIRECTOR'),
(126, 'actualizar_vigilante', 'SUBDIRECTOR'),
(127, 'consultar_permisos_usuarios', 'SUBDIRECTOR'),
(128, 'consultar_permiso_usuario', 'SUBDIRECTOR'),
(129, 'consultar_ficha', 'SUBDIRECTOR'),
(130, 'consultar_agendas', 'SUBDIRECTOR'),
(131, 'consultar_agenda', 'SUBDIRECTOR'),
(132, 'consultar_aprendices', 'SUBDIRECTOR'),
(133, 'consultar_aprendiz', 'SUBDIRECTOR'),
(134, 'consultar_funcionarios', 'SUBDIRECTOR'),
(135, 'consultar_funcionario', 'SUBDIRECTOR'),
(136, 'consultar_movimientos', 'SUBDIRECTOR'),
(137, 'consultar_movimientos_usuarios', 'SUBDIRECTOR'),
(138, 'consultar_movimiento', 'SUBDIRECTOR'),
(139, 'consultar_novedades_usuario', 'SUBDIRECTOR'),
(140, 'consultar_novedad_usuario', 'SUBDIRECTOR'),
(141, 'consultar_novedades_vehiculo', 'SUBDIRECTOR'),
(142, 'consultar_novedad_vehiculo', 'SUBDIRECTOR'),
(143, 'consultar_vehiculos', 'SUBDIRECTOR'),
(144, 'consultar_vehiculo', 'SUBDIRECTOR'),
(145, 'consultar_propietarios', 'SUBDIRECTOR'),
(146, 'consultar_vigilantes', 'SUBDIRECTOR'),
(147, 'consultar_vigilante', 'SUBDIRECTOR'),
(148, 'consultar_visitantes', 'SUBDIRECTOR'),
(149, 'consultar_visitante', 'SUBDIRECTOR'),
(150, 'consultar_permisos_vehiculos', 'SUBDIRECTOR'),
(151, 'consultar_permiso_vehiculo', 'SUBDIRECTOR'),
(152, 'consultar_notificaciones_permisos_vehiculo', 'SUBDIRECTOR'),
(153, 'consultar_notificaciones_permisos_usuario', 'SUBDIRECTOR'),
(154, 'consultar_fichas', 'SUBDIRECTOR'),
(155, 'conteo_total_usuarios', 'SUBDIRECTOR'),
(156, 'conteo_tipo_usuario', 'SUBDIRECTOR'),
(157, 'conteo_tipo_vehiculo', 'SUBDIRECTOR'),
(158, 'conteo_total_brigadistas', 'SUBDIRECTOR'),
(159, 'cerrar_sesion', 'SUBDIRECTOR'),
(160, 'desaprobar_permiso_usuario', 'SUBDIRECTOR'),
(161, 'desaprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(162, 'eliminar_agenda', 'SUBDIRECTOR'),
(163, 'generar_pdf_movimientos', 'SUBDIRECTOR'),
(164, 'habilitar_vigilante', 'SUBDIRECTOR'),
(165, 'habilitar_funcionario', 'SUBDIRECTOR'),
(166, 'inhabilitar_vigilante', 'SUBDIRECTOR'),
(167, 'inhabilitar_funcionario', 'SUBDIRECTOR'),
(168, 'registrar_aprendiz_individual', 'SUBDIRECTOR'),
(169, 'registrar_agenda_carga_masiva', 'SUBDIRECTOR'),
(170, 'registrar_aprendiz_carga_masiva', 'SUBDIRECTOR'),
(171, 'registrar_vehiculo', 'SUBDIRECTOR'),
(172, 'registrar_vigilante_individual', 'SUBDIRECTOR'),
(173, 'registrar_funcionario_carga_masiva', 'SUBDIRECTOR'),
(174, 'registrar_funcionario_individual', 'SUBDIRECTOR'),
(175, 'registrar_vigilante_carga_masiva', 'SUBDIRECTOR'),
(176, 'registrar_agenda_individual', 'SUBDIRECTOR'),
(177, 'actualizar_contrasena_usuario', 'INSTRUCTOR'),
(178, 'actualizar_agenda', 'INSTRUCTOR'),
(179, 'consultar_fichas', 'INSTRUCTOR'),
(180, 'consultar_ficha', 'INSTRUCTOR'),
(181, 'consultar_permisos_usuarios', 'INSTRUCTOR'),
(182, 'consultar_permiso_usuario', 'INSTRUCTOR'),
(183, 'consultar_funcionarios', 'INSTRUCTOR'),
(184, 'conteo_total_brigadistas', 'INSTRUCTOR'),
(185, 'conteo_total_usuarios', 'INSTRUCTOR'),
(186, 'conteo_tipo_usuario', 'INSTRUCTOR'),
(187, 'conteo_tipo_vehiculo', 'INSTRUCTOR'),
(188, 'consultar_agendas', 'INSTRUCTOR'),
(189, 'consultar_agenda', 'INSTRUCTOR'),
(190, 'cerrar_sesion', 'INSTRUCTOR'),
(191, 'eliminar_agenda', 'INSTRUCTOR'),
(192, 'registrar_agenda_individual', 'INSTRUCTOR'),
(193, 'registrar_permiso_usuario', 'INSTRUCTOR'),
(194, 'registrar_agenda_carga_masiva', 'INSTRUCTOR'),
(195, 'registrar_vehiculo', 'INSTRUCTOR'),
(196, 'registrar_aprendiz_individual', 'INSTRUCTOR'),
(197, 'registrar_aprendiz_carga_masiva', 'INSTRUCTOR'),
(198, 'consultar_aprendices', 'INSTRUCTOR'),
(199, 'consultar_aprendiz', 'INSTRUCTOR');

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
  `rol_usuario_sistema` varchar(20) NOT NULL,
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
  `estado_usuario` varchar(8) NOT NULL DEFAULT 'ACTIVO',
  `rol_usuario_sistema` varchar(20) NOT NULL,
  `fk_usuario_sistema` varchar(15) NOT NULL
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
  `ubicacion` varchar(8) NOT NULL DEFAULT 'FUERA',
  `rol_usuario_sistema` varchar(20) DEFAULT NULL,
  `fk_usuario_sistema` varchar(15) DEFAULT NULL
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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

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
