-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2025 a las 06:47:30
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
(30, 'CC', '1234567892', 'Jeronimo Alexander', 'Pizarro Rodríguez', '1234567890', 'jeronimo@gmail.com', 'SUBDIRECTOR', 'PLANTA', NULL, '25d55ad283aa400af464c76d713c07ad', 'NO', '2025-06-27 05:38:32', '2025-07-01 23:32:00', 'FUERA', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_ingreso`
--

CREATE TABLE `motivos_ingreso` (
  `contador` int(11) NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `motivos_ingreso`
--

INSERT INTO `motivos_ingreso` (`contador`, `motivo`, `fecha_registro`) VALUES
(4, 'Ddsdsdssdsds', '2025-06-26 13:44:25');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
  `fecha_fin_permiso` datetime DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_atencion` datetime DEFAULT NULL,
  `fk_usuario_atencion` varchar(15) DEFAULT NULL,
  `estado_permiso` varchar(11) NOT NULL DEFAULT 'PENDIENTE',
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
  `fecha_fin_permiso` datetime DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_atencion` datetime DEFAULT NULL,
  `fk_usuario_atencion` datetime DEFAULT NULL,
  `estado_permiso` varchar(11) NOT NULL DEFAULT 'PENDIENTE',
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE `roles_permisos` (
  `contador` int(11) NOT NULL,
  `permiso` varchar(100) NOT NULL,
  `rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`contador`, `permiso`, `rol`) VALUES
(297, 'consultar_agendas', 'JEFE VIGILANTES'),
(298, 'consultar_agenda', 'JEFE VIGILANTES'),
(299, 'consultar_aprendices', 'JEFE VIGILANTES'),
(300, 'consultar_aprendiz', 'JEFE VIGILANTES'),
(301, 'consultar_funcionarios', 'JEFE VIGILANTES'),
(302, 'consultar_funcionario', 'JEFE VIGILANTES'),
(303, 'conteo_total_brigadistas', 'JEFE VIGILANTES'),
(304, 'registrar_entrada_peatonal', 'JEFE VIGILANTES'),
(305, 'registrar_salida_peatonal', 'JEFE VIGILANTES'),
(306, 'registrar_entrada_vehicular', 'JEFE VIGILANTES'),
(307, 'registrar_salida_vehicular', 'JEFE VIGILANTES'),
(308, 'validar_usuario_apto_entrada', 'JEFE VIGILANTES'),
(309, 'validar_usuario_apto_salida', 'JEFE VIGILANTES'),
(310, 'consultar_movimientos', 'JEFE VIGILANTES'),
(311, 'generar_pdf_movimientos', 'JEFE VIGILANTES'),
(312, 'registrar_novedad_usuario', 'JEFE VIGILANTES'),
(313, 'consultar_novedades_usuario', 'JEFE VIGILANTES'),
(314, 'consultar_novedad_usuario', 'JEFE VIGILANTES'),
(315, 'registrar_novedad_vehiculo', 'JEFE VIGILANTES'),
(316, 'consultar_novedades_vehiculo', 'JEFE VIGILANTES'),
(317, 'consultar_novedad_vehiculo', 'JEFE VIGILANTES'),
(318, 'consultar_notificaciones_usuario', 'JEFE VIGILANTES'),
(319, 'conteo_total_usuarios', 'JEFE VIGILANTES'),
(320, 'conteo_tipo_usuario', 'JEFE VIGILANTES'),
(321, 'cerrar_sesion', 'JEFE VIGILANTES'),
(322, 'registrar_vehiculo', 'JEFE VIGILANTES'),
(323, 'consultar_vehiculos', 'JEFE VIGILANTES'),
(324, 'consultar_vehiculo', 'JEFE VIGILANTES'),
(325, 'consultar_propietarios', 'JEFE VIGILANTES'),
(326, 'eliminar_propietario_vehiculo', 'JEFE VIGILANTES'),
(327, 'conteo_tipo_vehiculo', 'JEFE VIGILANTES'),
(328, 'consultar_notificaciones_vehiculo', 'JEFE VIGILANTES'),
(329, 'registrar_vigilante', 'JEFE VIGILANTES'),
(330, 'actualizar_vigilante', 'JEFE VIGILANTES'),
(331, 'guardar_puerta', 'JEFE VIGILANTES'),
(332, 'habilitar_vigilante', 'JEFE VIGILANTES'),
(333, 'inhabilitar_vigilante', 'JEFE VIGILANTES'),
(334, 'consultar_vigilantes', 'JEFE VIGILANTES'),
(335, 'consultar_vigilante', 'JEFE VIGILANTES'),
(336, 'consultar_puerta', 'JEFE VIGILANTES'),
(337, 'registrar_visitante', 'JEFE VIGILANTES'),
(338, 'consultar_visitantes', 'JEFE VIGILANTES'),
(339, 'consultar_visitante', 'JEFE VIGILANTES'),
(340, 'consultar_agendas', 'VIGILANTE RASO'),
(341, 'consultar_agenda', 'VIGILANTE RASO'),
(342, 'consultar_aprendices', 'VIGILANTE RASO'),
(343, 'consultar_aprendiz', 'VIGILANTE RASO'),
(344, 'consultar_funcionarios', 'VIGILANTE RASO'),
(345, 'consultar_funcionario', 'VIGILANTE RASO'),
(346, 'conteo_total_brigadistas', 'VIGILANTE RASO'),
(347, 'registrar_entrada_peatonal', 'VIGILANTE RASO'),
(348, 'registrar_salida_peatonal', 'VIGILANTE RASO'),
(349, 'registrar_entrada_vehicular', 'VIGILANTE RASO'),
(350, 'registrar_salida_vehicular', 'VIGILANTE RASO'),
(351, 'validar_usuario_apto_entrada', 'VIGILANTE RASO'),
(352, 'validar_usuario_apto_salida', 'VIGILANTE RASO'),
(353, 'registrar_novedad_usuario', 'VIGILANTE RASO'),
(354, 'registrar_novedad_vehiculo', 'VIGILANTE RASO'),
(355, 'conteo_total_usuarios', 'VIGILANTE RASO'),
(356, 'conteo_tipo_usuario', 'VIGILANTE RASO'),
(357, 'cerrar_sesion', 'VIGILANTE RASO'),
(358, 'registrar_vehiculo', 'VIGILANTE RASO'),
(359, 'consultar_vehiculos', 'VIGILANTE RASO'),
(360, 'consultar_vehiculo', 'VIGILANTE RASO'),
(361, 'consultar_propietarios', 'VIGILANTE RASO'),
(362, 'conteo_tipo_vehiculo', 'VIGILANTE RASO'),
(363, 'guardar_puerta', 'VIGILANTE RASO'),
(364, 'consultar_vigilantes', 'VIGILANTE RASO'),
(365, 'consultar_vigilante', 'VIGILANTE RASO'),
(366, 'consultar_puerta', 'VIGILANTE RASO'),
(367, 'registrar_visitante', 'VIGILANTE RASO'),
(368, 'consultar_visitantes', 'VIGILANTE RASO'),
(369, 'consultar_visitante', 'VIGILANTE RASO'),
(370, 'registrar_agenda_individual', 'COORDINADOR'),
(371, 'actualizar_agenda', 'COORDINADOR'),
(372, 'eliminar_agenda', 'COORDINADOR'),
(373, 'consultar_agendas', 'COORDINADOR'),
(374, 'consultar_agenda', 'COORDINADOR'),
(375, 'registrar_aprendiz', 'COORDINADOR'),
(376, 'actualizar_aprendiz', 'COORDINADOR'),
(377, 'consultar_aprendices', 'COORDINADOR'),
(378, 'consultar_aprendiz', 'COORDINADOR'),
(379, 'consultar_fichas', 'COORDINADOR'),
(380, 'consultar_ficha', 'COORDINADOR'),
(381, 'consultar_funcionarios', 'COORDINADOR'),
(382, 'consultar_funcionario', 'COORDINADOR'),
(383, 'conteo_total_brigadistas', 'COORDINADOR'),
(384, 'conteo_total_usuarios', 'COORDINADOR'),
(385, 'conteo_tipo_usuario', 'COORDINADOR'),
(386, 'cerrar_sesion', 'COORDINADOR'),
(387, 'registrar_vehiculo', 'COORDINADOR'),
(388, 'conteo_tipo_vehiculo', 'COORDINADOR'),
(389, 'guardar_puerta', 'COORDINADOR'),
(390, 'consultar_vigilantes', 'COORDINADOR'),
(391, 'consultar_vigilante', 'COORDINADOR'),
(392, 'registrar_visitante', 'COORDINADOR'),
(393, 'consultar_visitantes', 'COORDINADOR'),
(394, 'consultar_visitante', 'COORDINADOR'),
(395, 'registrar_agenda_individual', 'SUBDIRECTOR'),
(396, 'actualizar_agenda', 'SUBDIRECTOR'),
(397, 'eliminar_agenda', 'SUBDIRECTOR'),
(398, 'consultar_agendas', 'SUBDIRECTOR'),
(399, 'consultar_agenda', 'SUBDIRECTOR'),
(400, 'registrar_aprendiz', 'SUBDIRECTOR'),
(401, 'actualizar_aprendiz', 'SUBDIRECTOR'),
(402, 'consultar_aprendices', 'SUBDIRECTOR'),
(403, 'consultar_aprendiz', 'SUBDIRECTOR'),
(404, 'consultar_fichas', 'SUBDIRECTOR'),
(405, 'consultar_ficha', 'SUBDIRECTOR'),
(406, 'registrar_funcionario', 'SUBDIRECTOR'),
(407, 'actualizar_funcionario', 'SUBDIRECTOR'),
(408, 'consultar_funcionarios', 'SUBDIRECTOR'),
(409, 'consultar_funcionario', 'SUBDIRECTOR'),
(410, 'conteo_total_brigadistas', 'SUBDIRECTOR'),
(411, 'consultar_movimientos', 'SUBDIRECTOR'),
(412, 'consultar_movimientos_usuarios', 'SUBDIRECTOR'),
(413, 'generar_pdf_movimientos', 'SUBDIRECTOR'),
(414, 'consultar_novedades_usuario', 'SUBDIRECTOR'),
(415, 'consultar_novedad_usuario', 'SUBDIRECTOR'),
(416, 'consultar_novedades_vehiculo', 'SUBDIRECTOR'),
(417, 'consultar_novedad_vehiculo', 'SUBDIRECTOR'),
(418, 'conteo_total_usuarios', 'SUBDIRECTOR'),
(419, 'conteo_tipo_usuario', 'SUBDIRECTOR'),
(420, 'cerrar_sesion', 'SUBDIRECTOR'),
(421, 'registrar_vehiculo', 'SUBDIRECTOR'),
(422, 'consultar_vehiculos', 'SUBDIRECTOR'),
(423, 'consultar_vehiculo', 'SUBDIRECTOR'),
(424, 'consultar_propietarios', 'SUBDIRECTOR'),
(425, 'eliminar_propietario_vehiculo', 'SUBDIRECTOR'),
(426, 'conteo_tipo_vehiculo', 'SUBDIRECTOR'),
(427, 'registrar_vigilante', 'SUBDIRECTOR'),
(428, 'actualizar_vigilante', 'SUBDIRECTOR'),
(429, 'habilitar_vigilante', 'SUBDIRECTOR'),
(430, 'inhabilitar_vigilante', 'SUBDIRECTOR'),
(431, 'consultar_vigilantes', 'SUBDIRECTOR'),
(432, 'consultar_vigilante', 'SUBDIRECTOR'),
(433, 'registrar_visitante', 'SUBDIRECTOR'),
(434, 'consultar_visitantes', 'SUBDIRECTOR'),
(435, 'consultar_visitante', 'SUBDIRECTOR'),
(436, 'validar_usuario', 'INVITADO'),
(437, 'validar_contrasena', 'INVITADO'),
(438, 'registrar_aprendiz', 'INVITADO'),
(439, 'consultar_fichas', 'INVITADO'),
(440, 'consultar_ficha', 'INVITADO'),
(441, 'auto_registrar_funcionario', 'INVITADO'),
(442, 'auto_registrar_vigilante', 'INVITADO'),
(443, 'registrar_visitante', 'INVITADO'),
(444, 'consultar_motivos_ingreso', 'INVITADO'),
(445, 'registrar_permiso_usuario', 'JEFE VIGILANTES'),
(446, 'aprobar_permiso_usuario', 'SUBDIRECTOR'),
(447, 'desaprobar_permiso_usuario', 'SUBDIRECTOR'),
(448, 'consultar_permisos_usuarios', 'JEFE VIGILANTES'),
(449, 'consultar_permisos_usuarios', 'SUBDIRECTOR'),
(450, 'consultar_permiso_usuario', 'SUBDIRECTOR'),
(451, 'consultar_permiso_usuario', 'JEFE VIGILANTES'),
(452, 'registrar_permiso_vehiculo', 'JEFE VIGILANTES'),
(453, 'aprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(454, 'desaprobar_permiso_vehiculo', 'SUBDIRECTOR'),
(455, 'consultar_permisos_vehiculos', 'JEFE VIGILANTES'),
(456, 'consultar_permiso_vehiculo', 'JEFE VIGILANTES'),
(457, 'consultar_permisos_vehiculos', 'SUBDIRECTOR'),
(458, 'consultar_permiso_vehiculo', 'SUBDIRECTOR'),
(459, 'consultar_notificaciones_permisos_vehiculo', 'SUBDIRECTOR'),
(460, 'consultar_notificaciones_permisos_usuario', 'SUBDIRECTOR'),
(461, 'registrar_agenda_grupal', 'SUBDIRECTOR'),
(462, 'registrar_agenda_grupal', 'COORDINADOR');

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
  `ubicacion` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3593;

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estadias_aprendices`
--
ALTER TABLE `estadias_aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `novedades_vehiculos`
--
ALTER TABLE `novedades_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `permisos_vehiculos`
--
ALTER TABLE `permisos_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
