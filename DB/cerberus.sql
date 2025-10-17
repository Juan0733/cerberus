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
(31, 'consultar_brigadistas', 'SUPERVISOR'),
(32, 'conteo_total_usuarios', 'SUPERVISOR'),
(33, 'conteo_tipo_usuario', 'SUPERVISOR'),
(34, 'conteo_tipo_vehiculo', 'SUPERVISOR'),
(35, 'cerrar_sesion', 'SUPERVISOR'),
(36, 'eliminar_propietario_vehiculo', 'SUPERVISOR'),
(37, 'guardar_puerta', 'SUPERVISOR'),
(38, 'habilitar_vigilante', 'SUPERVISOR'),
(39, 'inhabilitar_vigilante', 'SUPERVISOR'),
(40, 'registrar_vigilante_individual', 'SUPERVISOR'),
(41, 'registrar_novedad_vehiculo', 'SUPERVISOR'),
(42, 'registrar_permiso_usuario', 'SUPERVISOR'),
(43, 'registrar_novedad_usuario', 'SUPERVISOR'),
(44, 'registrar_permiso_vehiculo', 'SUPERVISOR'),
(45, 'registrar_salida_peatonal', 'SUPERVISOR'),
(46, 'registrar_entrada_vehicular', 'SUPERVISOR'),
(47, 'registrar_salida_vehicular', 'SUPERVISOR'),
(48, 'registrar_vigilante_carga_masiva', 'SUPERVISOR'),
(49, 'registrar_entrada_peatonal', 'SUPERVISOR'),
(50, 'registrar_vehiculo', 'SUPERVISOR'),
(51, 'validar_usuario_apto_entrada', 'SUPERVISOR'),
(52, 'validar_usuario_apto_salida', 'SUPERVISOR'),
(53, 'actualizar_contrasena_usuario', 'VIGILANTE'),
(54, 'consultar_agendas', 'VIGILANTE'),
(55, 'consultar_agenda', 'VIGILANTE'),
(56, 'consultar_aprendices', 'VIGILANTE'),
(57, 'consultar_aprendiz', 'VIGILANTE'),
(58, 'consultar_funcionarios', 'VIGILANTE'),
(59, 'consultar_funcionario', 'VIGILANTE'),
(60, 'consultar_vigilantes', 'VIGILANTE'),
(61, 'consultar_vigilante', 'VIGILANTE'),
(62, 'consultar_puerta', 'VIGILANTE'),
(63, 'consultar_visitantes', 'VIGILANTE'),
(64, 'consultar_visitante', 'VIGILANTE'),
(65, 'consultar_permisos_usuarios', 'VIGILANTE'),
(66, 'consultar_permiso_usuario', 'VIGILANTE'),
(67, 'consultar_ultimo_movimiento_usuario', 'VIGILANTE'),
(68, 'consultar_vehiculos', 'VIGILANTE'),
(69, 'consultar_vehiculo', 'VIGILANTE'),
(70, 'consultar_propietarios', 'VIGILANTE'),
(71, 'consultar_brigadistas', 'VIGILANTE'),
(72, 'conteo_tipo_vehiculo', 'VIGILANTE'),
(73, 'conteo_total_brigadistas', 'VIGILANTE'),
(74, 'conteo_total_usuarios', 'VIGILANTE'),
(75, 'conteo_tipo_usuario', 'VIGILANTE'),
(76, 'cerrar_sesion', 'VIGILANTE'),
(77, 'guardar_puerta', 'VIGILANTE'),
(78, 'registrar_novedad_usuario', 'VIGILANTE'),
(79, 'registrar_novedad_vehiculo', 'VIGILANTE'),
(80, 'registrar_vehiculo', 'VIGILANTE'),
(81, 'registrar_entrada_peatonal', 'VIGILANTE'),
(82, 'registrar_salida_peatonal', 'VIGILANTE'),
(83, 'registrar_entrada_vehicular', 'VIGILANTE'),
(84, 'registrar_salida_vehicular', 'VIGILANTE'),
(85, 'validar_usuario_apto_entrada', 'VIGILANTE'),
(86, 'validar_usuario_apto_salida', 'VIGILANTE'),
(87, 'actualizar_contrasena_usuario', 'COORDINADOR'),
(88, 'actualizar_agenda', 'COORDINADOR'),
(89, 'actualizar_funcionario', 'COORDINADOR'),
(90, 'actualizar_aprendiz', 'COORDINADOR'),
(91, 'consultar_ficha', 'COORDINADOR'),
(92, 'consultar_fichas', 'COORDINADOR'),
(93, 'consultar_agendas', 'COORDINADOR'),
(94, 'consultar_agenda', 'COORDINADOR'),
(95, 'consultar_aprendices', 'COORDINADOR'),
(96, 'consultar_aprendiz', 'COORDINADOR'),
(97, 'consultar_funcionarios', 'COORDINADOR'),
(98, 'consultar_brigadistas', 'COORDINADOR'),
(99, 'conteo_total_brigadistas', 'COORDINADOR'),
(100, 'conteo_total_usuarios', 'COORDINADOR'),
(101, 'conteo_tipo_usuario', 'COORDINADOR'),
(102, 'conteo_tipo_vehiculo', 'COORDINADOR'),
(103, 'consultar_vigilantes', 'COORDINADOR'),
(104, 'consultar_vigilante', 'COORDINADOR'),
(105, 'consultar_visitantes', 'COORDINADOR'),
(106, 'consultar_visitante', 'COORDINADOR'),
(107, 'consultar_permisos_usuarios', 'COORDINADOR'),
(108, 'consultar_permiso_usuario', 'COORDINADOR'),
(109, 'cerrar_sesion', 'COORDINADOR'),
(110, 'eliminar_agenda', 'COORDINADOR'),
(111, 'guardar_puerta', 'COORDINADOR'),
(112, 'habilitar_funcionario', 'COORDINADOR'),
(113, 'inhabilitar_funcionario', 'COORDINADOR'),
(114, 'registrar_funcionario_individual', 'COORDINADOR'),
(115, 'registrar_permiso_usuario', 'COORDINADOR'),
(116, 'registrar_agenda_carga_masiva', 'COORDINADOR'),
(117, 'registrar_aprendiz_individual', 'COORDINADOR'),
(118, 'registrar_aprendiz_carga_masiva', 'COORDINADOR'),
(119, 'registrar_agenda_individual', 'COORDINADOR'),
(120, 'registrar_vehiculo', 'COORDINADOR'),
(121, 'registrar_funcionario_carga_masiva', 'COORDINADOR'),
(122, 'aprobar_permiso_usuario', 'SUBDIRECTOR'),
(123, 'aprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(124, 'actualizar_agenda', 'SUBDIRECTOR'),
(125, 'actualizar_aprendiz', 'SUBDIRECTOR'),
(126, 'actualizar_contrasena_usuario', 'SUBDIRECTOR'),
(127, 'actualizar_funcionario', 'SUBDIRECTOR'),
(128, 'actualizar_vigilante', 'SUBDIRECTOR'),
(129, 'consultar_permisos_usuarios', 'SUBDIRECTOR'),
(130, 'consultar_permiso_usuario', 'SUBDIRECTOR'),
(131, 'consultar_ficha', 'SUBDIRECTOR'),
(132, 'consultar_agendas', 'SUBDIRECTOR'),
(133, 'consultar_agenda', 'SUBDIRECTOR'),
(134, 'consultar_aprendices', 'SUBDIRECTOR'),
(135, 'consultar_aprendiz', 'SUBDIRECTOR'),
(136, 'consultar_funcionarios', 'SUBDIRECTOR'),
(137, 'consultar_funcionario', 'SUBDIRECTOR'),
(138, 'consultar_movimientos', 'SUBDIRECTOR'),
(139, 'consultar_movimientos_usuarios', 'SUBDIRECTOR'),
(140, 'consultar_movimiento', 'SUBDIRECTOR'),
(141, 'consultar_novedades_usuario', 'SUBDIRECTOR'),
(142, 'consultar_novedad_usuario', 'SUBDIRECTOR'),
(143, 'consultar_novedades_vehiculo', 'SUBDIRECTOR'),
(144, 'consultar_novedad_vehiculo', 'SUBDIRECTOR'),
(145, 'consultar_vehiculos', 'SUBDIRECTOR'),
(146, 'consultar_vehiculo', 'SUBDIRECTOR'),
(147, 'consultar_propietarios', 'SUBDIRECTOR'),
(148, 'consultar_vigilantes', 'SUBDIRECTOR'),
(149, 'consultar_vigilante', 'SUBDIRECTOR'),
(150, 'consultar_visitantes', 'SUBDIRECTOR'),
(151, 'consultar_visitante', 'SUBDIRECTOR'),
(152, 'consultar_permisos_vehiculos', 'SUBDIRECTOR'),
(153, 'consultar_permiso_vehiculo', 'SUBDIRECTOR'),
(154, 'consultar_notificaciones_permisos_vehiculo', 'SUBDIRECTOR'),
(155, 'consultar_notificaciones_permisos_usuario', 'SUBDIRECTOR'),
(156, 'consultar_fichas', 'SUBDIRECTOR'),
(157, 'consultar_brigadistas', 'SUBDIRECTOR'),
(158, 'conteo_total_usuarios', 'SUBDIRECTOR'),
(159, 'conteo_tipo_usuario', 'SUBDIRECTOR'),
(160, 'conteo_tipo_vehiculo', 'SUBDIRECTOR'),
(161, 'conteo_total_brigadistas', 'SUBDIRECTOR'),
(162, 'cerrar_sesion', 'SUBDIRECTOR'),
(163, 'desaprobar_permiso_usuario', 'SUBDIRECTOR'),
(164, 'desaprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(165, 'eliminar_agenda', 'SUBDIRECTOR'),
(166, 'generar_pdf_movimientos', 'SUBDIRECTOR'),
(167, 'habilitar_vigilante', 'SUBDIRECTOR'),
(168, 'habilitar_funcionario', 'SUBDIRECTOR'),
(169, 'inhabilitar_vigilante', 'SUBDIRECTOR'),
(170, 'inhabilitar_funcionario', 'SUBDIRECTOR'),
(171, 'registrar_aprendiz_individual', 'SUBDIRECTOR'),
(172, 'registrar_agenda_carga_masiva', 'SUBDIRECTOR'),
(173, 'registrar_aprendiz_carga_masiva', 'SUBDIRECTOR'),
(174, 'registrar_vehiculo', 'SUBDIRECTOR'),
(175, 'registrar_vigilante_individual', 'SUBDIRECTOR'),
(176, 'registrar_funcionario_carga_masiva', 'SUBDIRECTOR'),
(177, 'registrar_funcionario_individual', 'SUBDIRECTOR'),
(178, 'registrar_vigilante_carga_masiva', 'SUBDIRECTOR'),
(179, 'registrar_agenda_individual', 'SUBDIRECTOR'),
(180, 'actualizar_contrasena_usuario', 'INSTRUCTOR'),
(181, 'actualizar_agenda', 'INSTRUCTOR'),
(182, 'consultar_fichas', 'INSTRUCTOR'),
(183, 'consultar_ficha', 'INSTRUCTOR'),
(184, 'consultar_permisos_usuarios', 'INSTRUCTOR'),
(185, 'consultar_permiso_usuario', 'INSTRUCTOR'),
(186, 'consultar_brigadistas', 'INSTRUCTOR'),
(187, 'conteo_total_brigadistas', 'INSTRUCTOR'),
(188, 'conteo_total_usuarios', 'INSTRUCTOR'),
(189, 'conteo_tipo_usuario', 'INSTRUCTOR'),
(190, 'conteo_tipo_vehiculo', 'INSTRUCTOR'),
(191, 'consultar_agendas', 'INSTRUCTOR'),
(192, 'consultar_agenda', 'INSTRUCTOR'),
(193, 'cerrar_sesion', 'INSTRUCTOR'),
(194, 'eliminar_agenda', 'INSTRUCTOR'),
(195, 'registrar_agenda_individual', 'INSTRUCTOR'),
(196, 'registrar_permiso_usuario', 'INSTRUCTOR'),
(197, 'registrar_agenda_carga_masiva', 'INSTRUCTOR'),
(198, 'registrar_vehiculo', 'INSTRUCTOR'),
(199, 'registrar_aprendiz_individual', 'INSTRUCTOR'),
(200, 'registrar_aprendiz_carga_masiva', 'INSTRUCTOR'),
(201, 'consultar_aprendices', 'INSTRUCTOR'),
(202, 'consultar_aprendiz', 'INSTRUCTOR');

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
