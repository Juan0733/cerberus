-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2025 a las 04:38:27
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
(40, 'consultar_visitantes', 'SUPERVISOR'),
(41, 'consultar_visitante', 'SUPERVISOR'),
(42, 'consultar_agendas', 'VIGILANTE'),
(43, 'consultar_agenda', 'VIGILANTE'),
(44, 'consultar_aprendices', 'VIGILANTE'),
(45, 'consultar_aprendiz', 'VIGILANTE'),
(46, 'consultar_funcionarios', 'VIGILANTE'),
(47, 'consultar_funcionario', 'VIGILANTE'),
(48, 'conteo_total_brigadistas', 'VIGILANTE'),
(49, 'registrar_entrada_peatonal', 'VIGILANTE'),
(50, 'registrar_salida_peatonal', 'VIGILANTE'),
(51, 'registrar_entrada_vehicular', 'VIGILANTE'),
(52, 'registrar_salida_vehicular', 'VIGILANTE'),
(53, 'validar_usuario_apto_entrada', 'VIGILANTE'),
(54, 'validar_usuario_apto_salida', 'VIGILANTE'),
(55, 'registrar_novedad_usuario', 'VIGILANTE'),
(56, 'registrar_novedad_vehiculo', 'VIGILANTE'),
(57, 'conteo_total_usuarios', 'VIGILANTE'),
(58, 'conteo_tipo_usuario', 'VIGILANTE'),
(59, 'cerrar_sesion', 'VIGILANTE'),
(60, 'registrar_vehiculo', 'VIGILANTE'),
(61, 'consultar_vehiculos', 'VIGILANTE'),
(62, 'consultar_vehiculo', 'VIGILANTE'),
(63, 'consultar_propietarios', 'VIGILANTE'),
(64, 'conteo_tipo_vehiculo', 'VIGILANTE'),
(65, 'guardar_puerta', 'VIGILANTE'),
(66, 'consultar_vigilantes', 'VIGILANTE'),
(67, 'consultar_vigilante', 'VIGILANTE'),
(68, 'consultar_puerta', 'VIGILANTE'),
(69, 'consultar_visitantes', 'VIGILANTE'),
(70, 'consultar_visitante', 'VIGILANTE'),
(71, 'registrar_agenda_individual', 'COORDINADOR'),
(72, 'actualizar_agenda', 'COORDINADOR'),
(73, 'eliminar_agenda', 'COORDINADOR'),
(74, 'consultar_agendas', 'COORDINADOR'),
(75, 'consultar_agenda', 'COORDINADOR'),
(76, 'actualizar_aprendiz', 'COORDINADOR'),
(77, 'consultar_aprendices', 'COORDINADOR'),
(78, 'consultar_aprendiz', 'COORDINADOR'),
(79, 'consultar_funcionarios', 'COORDINADOR'),
(80, 'consultar_funcionario', 'COORDINADOR'),
(81, 'conteo_total_brigadistas', 'COORDINADOR'),
(82, 'conteo_total_usuarios', 'COORDINADOR'),
(83, 'conteo_tipo_usuario', 'COORDINADOR'),
(84, 'cerrar_sesion', 'COORDINADOR'),
(85, 'registrar_vehiculo', 'COORDINADOR'),
(86, 'conteo_tipo_vehiculo', 'COORDINADOR'),
(87, 'guardar_puerta', 'COORDINADOR'),
(88, 'consultar_vigilantes', 'COORDINADOR'),
(89, 'consultar_vigilante', 'COORDINADOR'),
(90, 'consultar_visitantes', 'COORDINADOR'),
(91, 'consultar_visitante', 'COORDINADOR'),
(92, 'registrar_agenda_individual', 'SUBDIRECTOR'),
(93, 'actualizar_agenda', 'SUBDIRECTOR'),
(94, 'eliminar_agenda', 'SUBDIRECTOR'),
(95, 'consultar_agendas', 'SUBDIRECTOR'),
(96, 'consultar_agenda', 'SUBDIRECTOR'),
(97, 'actualizar_aprendiz', 'SUBDIRECTOR'),
(98, 'consultar_aprendices', 'SUBDIRECTOR'),
(99, 'consultar_aprendiz', 'SUBDIRECTOR'),
(100, 'registrar_funcionario', 'SUBDIRECTOR'),
(101, 'actualizar_funcionario', 'SUBDIRECTOR'),
(102, 'consultar_funcionarios', 'SUBDIRECTOR'),
(103, 'consultar_funcionario', 'SUBDIRECTOR'),
(104, 'conteo_total_brigadistas', 'SUBDIRECTOR'),
(105, 'consultar_movimientos', 'SUBDIRECTOR'),
(106, 'consultar_movimientos_usuarios', 'SUBDIRECTOR'),
(107, 'generar_pdf_movimientos', 'SUBDIRECTOR'),
(108, 'consultar_novedades_usuario', 'SUBDIRECTOR'),
(109, 'consultar_novedad_usuario', 'SUBDIRECTOR'),
(110, 'consultar_novedades_vehiculo', 'SUBDIRECTOR'),
(111, 'consultar_novedad_vehiculo', 'SUBDIRECTOR'),
(112, 'conteo_total_usuarios', 'SUBDIRECTOR'),
(113, 'conteo_tipo_usuario', 'SUBDIRECTOR'),
(114, 'cerrar_sesion', 'SUBDIRECTOR'),
(115, 'registrar_vehiculo', 'SUBDIRECTOR'),
(116, 'consultar_vehiculos', 'SUBDIRECTOR'),
(117, 'consultar_vehiculo', 'SUBDIRECTOR'),
(118, 'consultar_propietarios', 'SUBDIRECTOR'),
(119, 'eliminar_propietario_vehiculo', 'SUBDIRECTOR'),
(120, 'conteo_tipo_vehiculo', 'SUBDIRECTOR'),
(121, 'registrar_vigilante', 'SUBDIRECTOR'),
(122, 'actualizar_vigilante', 'SUBDIRECTOR'),
(123, 'habilitar_vigilante', 'SUBDIRECTOR'),
(124, 'inhabilitar_vigilante', 'SUBDIRECTOR'),
(125, 'consultar_vigilantes', 'SUBDIRECTOR'),
(126, 'consultar_vigilante', 'SUBDIRECTOR'),
(127, 'consultar_visitantes', 'SUBDIRECTOR'),
(128, 'consultar_visitante', 'SUBDIRECTOR'),
(129, 'registrar_permiso_usuario', 'SUPERVISOR'),
(130, 'aprobar_permiso_usuario', 'SUBDIRECTOR'),
(131, 'desaprobar_permiso_usuario', 'SUBDIRECTOR'),
(132, 'consultar_permisos_usuarios', 'SUPERVISOR'),
(133, 'consultar_permisos_usuarios', 'SUBDIRECTOR'),
(134, 'consultar_permiso_usuario', 'SUBDIRECTOR'),
(135, 'consultar_permiso_usuario', 'SUPERVISOR'),
(136, 'registrar_permiso_vehiculo', 'SUPERVISOR'),
(137, 'aprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(138, 'desaprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(139, 'consultar_permisos_vehiculos', 'SUPERVISOR'),
(140, 'consultar_permiso_vehiculo', 'SUPERVISOR'),
(141, 'consultar_permisos_vehiculos', 'SUBDIRECTOR'),
(142, 'consultar_permiso_vehiculo', 'SUBDIRECTOR'),
(143, 'consultar_notificaciones_permisos_vehiculo', 'SUBDIRECTOR'),
(144, 'consultar_notificaciones_permisos_usuario', 'SUBDIRECTOR'),
(145, 'registrar_agenda_grupal', 'SUBDIRECTOR'),
(146, 'registrar_agenda_grupal', 'COORDINADOR'),
(147, 'consultar_movimiento', 'SUPERVISOR'),
(148, 'consultar_movimiento', 'SUBDIRECTOR'),
(149, 'habilitar_funcionario', 'SUBDIRECTOR'),
(150, 'inhabilitar_funcionario', 'SUBDIRECTOR'),
(151, 'registrar_funcionario', 'COORDINADOR'),
(152, 'actualizar_funcionario', 'COORDINADOR'),
(153, 'habilitar_funcionario', 'COORDINADOR'),
(154, 'inhabilitar_funcionario', 'COORDINADOR'),
(155, 'conteo_total_brigadistas', 'INSTRUCTOR'),
(156, 'conteo_total_usuarios', 'INSTRUCTOR'),
(157, 'conteo_tipo_usuario', 'INSTRUCTOR'),
(158, 'conteo_tipo_vehiculo', 'INSTRUCTOR'),
(159, 'consultar_agendas', 'INSTRUCTOR'),
(160, 'consultar_agenda', 'INSTRUCTOR'),
(161, 'registrar_agenda_individual', 'INSTRUCTOR'),
(162, 'actualizar_agenda', 'INSTRUCTOR'),
(163, 'eliminar_agenda', 'INSTRUCTOR'),
(164, 'consultar_permisos_usuarios', 'INSTRUCTOR'),
(165, 'consultar_permiso_usuario', 'INSTRUCTOR'),
(166, 'registrar_permiso_usuario', 'INSTRUCTOR'),
(167, 'consultar_permisos_usuarios', 'COORDINADOR'),
(168, 'consultar_permiso_usuario', 'COORDINADOR'),
(169, 'registrar_permiso_usuario', 'COORDINADOR'),
(170, 'consultar_permisos_usuarios', 'VIGILANTE'),
(171, 'consultar_permiso_usuario', 'VIGILANTE'),
(172, 'consultar_funcionarios', 'INSTRUCTOR'),
(173, 'registrar_agenda_grupal', 'INSTRUCTOR'),
(174, 'cerrar_sesion', 'INSTRUCTOR'),
(175, 'registrar_vehiculo', 'INSTRUCTOR'),
(176, 'consultar_ultimo_movimiento_usuario', 'SUPERVISOR'),
(177, 'consultar_ultimo_movimiento_usuario', 'VIGILANTE');

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

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
