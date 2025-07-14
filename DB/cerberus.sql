-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2025 a las 04:02:59
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

--
-- Volcado de datos para la tabla `agendas`
--

INSERT INTO `agendas` (`contador`, `codigo_agenda`, `titulo`, `motivo`, `fk_usuario`, `fecha_agenda`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(4069, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '12345678988', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4070, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567893', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4071, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567894', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4072, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567895', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4073, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567896', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4074, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567897', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4075, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567898', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4076, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567899', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4077, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567900', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4078, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567901', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4079, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567902', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4080, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567903', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4081, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567904', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4082, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567905', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4083, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567906', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4084, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567907', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4085, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567908', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4086, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567909', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4087, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567910', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4088, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567911', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4089, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567912', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4090, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567913', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4091, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567914', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4092, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567915', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4093, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567916', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4094, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567917', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4095, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567918', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4096, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567919', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4097, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567920', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4098, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567921', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4099, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567922', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4100, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567923', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4101, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567924', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4102, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567925', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4103, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567926', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4104, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567927', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4105, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567928', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4106, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567929', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4107, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567930', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4108, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567931', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4109, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567932', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4110, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567933', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4111, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567934', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4112, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567935', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4113, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567936', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4114, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567937', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4115, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567938', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4116, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567939', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4117, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567940', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4118, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567941', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4119, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567942', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4120, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567943', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4121, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567944', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4122, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567945', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4123, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567946', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4124, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567947', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4125, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567948', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4126, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567949', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4127, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567950', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4128, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567951', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4129, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567952', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4130, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567953', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4131, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567954', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4132, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567955', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4133, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567956', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4134, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567957', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4135, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567958', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4136, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567959', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4137, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567960', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4138, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567961', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4139, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567962', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4140, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567963', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4141, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567964', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4142, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567965', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4143, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567966', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4144, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567967', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4145, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567968', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4146, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567969', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4147, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567970', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4148, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567971', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4149, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567972', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4150, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567973', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4151, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567974', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4152, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567975', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4153, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567976', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4154, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567977', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4155, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567978', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4156, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567979', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4157, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567980', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4158, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567981', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4159, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567982', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4160, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567983', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4161, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567984', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4162, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567985', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4163, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567986', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4164, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567987', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4165, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567988', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4166, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567989', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4167, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567990', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4168, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567991', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4169, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567992', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4170, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567993', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4171, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567994', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4172, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567995', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4173, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567996', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4174, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567997', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4175, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567998', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4176, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234567999', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4177, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568000', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4178, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568001', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4179, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568002', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4180, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568003', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4181, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568004', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4182, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568005', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4183, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568006', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4184, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568007', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4185, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568008', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4186, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568009', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892'),
(4187, 'AG20250712182942', 'Mercado Campesino', 'Fgfgfgfg', '1234568010', '2025-07-12 18:29:00', '2025-07-12 18:29:42', '1234567892');

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
-- Estructura de tabla para la tabla `estadias_aprendices`
--

CREATE TABLE `estadias_aprendices` (
  `contador` int(11) NOT NULL,
  `fk_usuario` varchar(15) NOT NULL,
  `fecha_fin_estadia` date NOT NULL,
  `fecha_registro` datetime NOT NULL,
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
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`contador`, `numero_ficha`, `nombre_programa`, `fecha_fin_ficha`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(6, '2714805', 'Analisis Y Desarrollo De Software', '2025-07-31', '2025-07-03 00:12:39', ''),
(7, '2714806', 'Tecnólogo En Recursos Humanos', '2025-07-07', '2025-07-07 18:03:57', '');

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
(30, 'FUNCIONARIO', 'CC', '1234567892', 'Jeronimo Alexander', 'Pizarro Rodríguez', '1234567890', 'jeronimo@gmail.com', 'SUBDIRECTOR', 'PLANTA', NULL, '25d55ad283aa400af464c76d713c07ad', 'NO', '2025-06-27 05:38:32', '2025-07-13 12:00:56', 'FUERA', 'ACTIVO'),
(32, 'FUNCIONARIO', 'CC', '1234567890', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'COORDINADOR', 'PLANTA', NULL, '25d55ad283aa400af464c76d713c07ad', 'SI', '2025-07-07 17:14:22', '2025-07-08 09:18:36', 'DENTRO', 'ACTIVO'),
(33, 'FUNCIONARIO', 'CC', '1234524231', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'COORDINADOR', 'CONTRATISTA', '2025-07-07', NULL, 'SI', '2025-07-07 17:26:52', '2025-07-08 09:18:36', 'DENTRO', 'INACTIVO'),
(34, 'FUNCIONARIO', 'CC', '12345242300', 'Juan David', 'Restrepo Ramos', '1234567901', 'juan@gmail.com', 'COORDINADOR', 'CONTRATISTA', '2025-07-08', NULL, 'SI', '2025-07-07 17:27:26', '2025-07-08 09:18:36', 'DENTRO', 'INACTIVO'),
(35, 'FUNCIONARIO', 'CC', '1234524230', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'COORDINADOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-07 17:27:55', '2025-07-08 09:18:36', 'DENTRO', 'INACTIVO'),
(37, 'FUNCIONARIO', 'CC', '1234524239', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'COORDINADOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-07 17:28:55', '2025-07-08 09:18:36', 'DENTRO', 'INACTIVO'),
(38, 'FUNCIONARIO', 'CC', '123452423', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-09 22:42:00', NULL, 'DENTRO', NULL),
(39, 'FUNCIONARIO', 'CC', '12345242', 'Juan David', 'Restrepo Ramos', '1234567901', 'juan@gmail.com', 'PERSONAL ADMINISTRATIVO', 'PLANTA', NULL, NULL, 'SI', '2025-07-09 22:42:42', NULL, 'DENTRO', NULL),
(40, 'FUNCIONARIO', 'CC', '1234524', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-09 22:43:40', NULL, 'DENTRO', NULL),
(41, 'FUNCIONARIO', 'CC', '123452423765', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:14:09', NULL, 'FUERA', NULL),
(42, 'FUNCIONARIO', 'CC', '12345242788', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:17:52', NULL, 'FUERA', NULL),
(43, 'FUNCIONARIO', 'CC', '12345242390', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:18:47', NULL, 'FUERA', NULL),
(45, 'FUNCIONARIO', 'CC', '12345242312', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:31:38', NULL, 'FUERA', NULL),
(46, 'FUNCIONARIO', 'CC', '12345242361', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:33:27', NULL, 'FUERA', NULL),
(47, 'FUNCIONARIO', 'CC', '123452436', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:34:48', NULL, 'FUERA', NULL),
(48, 'FUNCIONARIO', 'CC', '234524236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:46:36', NULL, 'FUERA', NULL),
(49, 'FUNCIONARIO', 'CC', '234524231', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:49:45', NULL, 'FUERA', NULL),
(50, 'FUNCIONARIO', 'CC', '4524236', 'Juan David', 'Restrepo Ramos', '1234567890', 'alejandro@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 11:57:56', NULL, 'FUERA', NULL),
(51, 'FUNCIONARIO', 'CC', '524236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:00:55', NULL, 'FUERA', NULL),
(52, 'FUNCIONARIO', 'CC', '4524231', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'PERSONAL ASEO', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:01:51', NULL, 'FUERA', NULL),
(53, 'FUNCIONARIO', 'CC', '12324236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:11:18', NULL, 'FUERA', NULL),
(54, 'FUNCIONARIO', 'CC', '123454236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:14:02', NULL, 'FUERA', NULL),
(55, 'FUNCIONARIO', 'CC', '12345236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:16:42', NULL, 'FUERA', NULL),
(56, 'FUNCIONARIO', 'CC', '1234236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:17:19', NULL, 'FUERA', NULL),
(57, 'FUNCIONARIO', 'CC', '13524236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:18:31', NULL, 'FUERA', NULL),
(58, 'FUNCIONARIO', 'CC', '1234524236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:22:25', NULL, 'FUERA', NULL),
(59, 'FUNCIONARIO', 'CC', '12452436', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:26:37', NULL, 'FUERA', NULL),
(60, 'FUNCIONARIO', 'CC', '12345246', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:48:03', NULL, 'FUERA', NULL),
(61, 'FUNCIONARIO', 'CC', '12342423', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 12:49:19', NULL, 'FUERA', NULL),
(62, 'FUNCIONARIO', 'CC', '123424236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'PERSONAL ADMINISTRATIVO', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 13:01:35', NULL, 'FUERA', NULL),
(63, 'FUNCIONARIO', 'CC', '1234536', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 13:02:44', NULL, 'FUERA', NULL),
(64, 'FUNCIONARIO', 'CC', '123456785', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 13:13:17', NULL, 'FUERA', NULL),
(65, 'FUNCIONARIO', 'CC', '1234567884', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'INSTRUCTOR', 'PLANTA', NULL, NULL, 'SI', '2025-07-12 13:21:40', NULL, 'FUERA', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_ingreso`
--

CREATE TABLE `motivos_ingreso` (
  `contador` int(11) NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `motivos_ingreso`
--

INSERT INTO `motivos_ingreso` (`contador`, `motivo`, `fecha_registro`) VALUES
(4, 'Ddsdsdssdsds', '2025-06-26 13:44:25'),
(5, 'Dfdfdfdf', '2025-07-02 17:14:19'),
(6, 'Matricula', '2025-07-02 23:42:29'),
(7, 'Inscripcion', '2025-07-02 23:55:01'),
(8, 'Hjhjhjh', '2025-07-07 17:16:56'),
(9, 'Rrrrrrrr', '2025-07-11 16:44:15');

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

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`contador`, `codigo_movimiento`, `tipo_movimiento`, `fk_usuario`, `fk_vehiculo`, `relacion_vehiculo`, `puerta_registro`, `observacion`, `fecha_registro`, `fk_usuario_sistema`, `tipo_usuario`) VALUES
(143, 'SP20250713003132', 'SALIDA', '1114813615', NULL, NULL, 'PEATONAL', NULL, '2025-07-13 00:31:32', '123456789', 'VISITANTE'),
(144, 'EV20250713125607', 'ENTRADA', '1114813615', 'ASD123', 'PROPIETARIO', 'PEATONAL', 'entra con cajas', '2025-07-13 12:56:07', '123456789', 'VISITANTE'),
(145, 'SV20250713130656', 'SALIDA', '1114813615', 'ASD123', 'PROPIETARIO', 'PRINCIPAL', 'sale con cajas', '2025-07-13 13:06:56', '123456789', 'VISITANTE'),
(146, 'EP20250713131148', 'ENTRADA', '1114813615', NULL, NULL, 'PRINCIPAL', 'entra con cajas', '2025-07-13 13:11:48', '123456789', 'VISITANTE'),
(147, 'SP20250713132116', 'SALIDA', '1114813615', NULL, NULL, 'PRINCIPAL', 'sale con cajas', '2025-07-13 13:21:16', '123456789', 'VISITANTE'),
(148, 'EP20250713132154', 'ENTRADA', '1114813615', NULL, NULL, 'PRINCIPAL', 'entra con cajas', '2025-07-13 13:21:54', '123456789', 'VISITANTE'),
(149, 'SP20250713132403', 'SALIDA', '1114813615', NULL, NULL, 'PRINCIPAL', 'Sale con cajas', '2025-07-13 13:24:03', '123456789', 'VISITANTE'),
(150, 'EP20250713132545', 'ENTRADA', '1114813615', NULL, NULL, 'PRINCIPAL', 'Sale Con Cajas', '2025-07-13 13:25:45', '123456789', 'VISITANTE'),
(151, 'SP20250713133332', 'SALIDA', '1114813615', NULL, NULL, 'PRINCIPAL', 'Sale con cajas', '2025-07-13 13:33:32', '123456789', 'VISITANTE'),
(152, 'EP20250713133412', 'ENTRADA', '1114813615', NULL, NULL, 'PRINCIPAL', 'éxito caja', '2025-07-13 13:34:12', '123456789', 'VISITANTE'),
(153, 'SP20250713133816', 'SALIDA', '1114813615', NULL, NULL, 'PRINCIPAL', 'Éxito caja', '2025-07-13 13:38:16', '123456789', 'VISITANTE'),
(154, 'EV20250713172215', 'ENTRADA', '1114813615', 'ASD124', 'PROPIETARIO', 'PRINCIPAL', NULL, '2025-07-13 17:22:15', '123456789', 'VISITANTE'),
(155, 'EV20250713172215', 'ENTRADA', '12345678907', 'ASD124', 'PASAJERO', 'PRINCIPAL', NULL, '2025-07-13 17:22:15', '123456789', 'VISITANTE'),
(156, 'SV20250713172302', 'SALIDA', '1114813615', 'ASD124', 'PROPIETARIO', 'PRINCIPAL', NULL, '2025-07-13 17:23:02', '123456789', 'VISITANTE'),
(157, 'SV20250713172302', 'SALIDA', '12345678907', 'ASD124', 'PASAJERO', 'PRINCIPAL', NULL, '2025-07-13 17:23:02', '123456789', 'VISITANTE'),
(158, 'SP20250713172358', 'SALIDA', '1114813615', NULL, NULL, 'PRINCIPAL', NULL, '2025-07-13 17:23:58', '123456789', 'VISITANTE'),
(159, 'EP20250713172431', 'ENTRADA', '1114813615', NULL, NULL, 'PRINCIPAL', NULL, '2025-07-13 17:24:31', '123456789', 'VISITANTE'),
(160, 'EP20250713172518', 'ENTRADA', '1114813615', NULL, NULL, 'PRINCIPAL', NULL, '2025-07-13 17:25:18', '123456789', 'VISITANTE');

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

--
-- Volcado de datos para la tabla `novedades_usuarios`
--

INSERT INTO `novedades_usuarios` (`contador`, `codigo_novedad`, `tipo_novedad`, `puerta_suceso`, `puerta_registro`, `descripcion`, `fk_usuario`, `fecha_suceso`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(33, 'NU20250703185835', 'SALIDA NO REGISTRADA', 'PEATONAL', 'PEATONAL', 'No se le registro la salida', '1114813615', '2025-07-03 18:58:00', '2025-07-03 18:58:35', '123456789'),
(34, 'NU20250703190302', 'ENTRADA NO REGISTRADA', 'PEATONAL', 'PEATONAL', 'No se le registro la entrada', '1114813615', '2025-07-03 19:02:00', '2025-07-03 19:03:02', '123456789'),
(35, 'NU20250711155832', 'SALIDA NO REGISTRADA', 'PEATONAL', 'PRINCIPAL', 'Fgfgfgfgfgf', '1114813615', '2025-07-11 15:58:00', '2025-07-11 15:58:32', '123456789'),
(36, 'NU20250711161238', 'SALIDA NO REGISTRADA', 'PEATONAL', 'PRINCIPAL', 'Ddffdfd', '1114813615', '2025-07-11 16:12:00', '2025-07-11 16:12:38', '123456789'),
(37, 'NU20250711163705', 'ENTRADA NO REGISTRADA', 'PEATONAL', 'PRINCIPAL', 'Ghghghghghgh', '34343434343434', '2025-07-11 16:37:00', '2025-07-11 16:37:05', '123456789'),
(38, 'NU20250713172358', 'ENTRADA NO REGISTRADA', 'PEATONAL', 'PRINCIPAL', 'No se le registro la salida', '1114813615', '2025-07-13 17:23:00', '2025-07-13 17:23:58', '123456789'),
(39, 'NU20250713172518', 'SALIDA NO REGISTRADA', 'PEATONAL', 'PRINCIPAL', 'No se le registro la salida', '1114813615', '2025-07-13 17:24:00', '2025-07-13 17:25:18', '123456789');

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
  `fecha_fin_permiso` datetime DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_atencion` datetime DEFAULT NULL,
  `fk_usuario_atencion` varchar(15) DEFAULT NULL,
  `estado_permiso` varchar(11) NOT NULL DEFAULT 'PENDIENTE',
  `fk_usuario_sistema` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `permisos_usuarios`
--

INSERT INTO `permisos_usuarios` (`contador`, `codigo_permiso`, `tipo_permiso`, `fk_usuario`, `descripcion`, `fecha_fin_permiso`, `fecha_registro`, `fecha_atencion`, `fk_usuario_atencion`, `estado_permiso`, `fk_usuario_sistema`) VALUES
(12, 'PU20250703191922', 'PERMANENCIA', '111481361', 'Requiere permiso para finalizar un trabajo dentro del cab', '2025-07-04 19:07:00', '2025-07-03 19:19:22', '2025-07-03 20:50:31', '1234567892', 'APROBADO', '123456789'),
(13, 'PU20250706164217', 'PERMANENCIA', '111481361', 'Dfdfdfdfdf', '2025-07-07 16:42:00', '2025-07-06 14:42:17', '2025-07-08 12:02:21', '1234567892', 'APROBADO', '123456789'),
(14, 'PU20250708120652', 'PERMANENCIA', '111481361', 'Sasasas', '2025-07-09 12:06:00', '2025-07-08 12:06:52', '2025-07-08 12:07:42', '1234567892', 'APROBADO', '123456789'),
(15, 'PU20250708120714', 'PERMANENCIA', '123456789', 'Rererreer', '2025-07-09 12:07:00', '2025-07-08 12:07:14', '2025-07-08 12:09:03', '1234567892', 'APROBADO', '123456789');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `permisos_vehiculos`
--

INSERT INTO `permisos_vehiculos` (`contador`, `codigo_permiso`, `tipo_permiso`, `fk_vehiculo`, `fk_usuario`, `descripcion`, `fecha_fin_permiso`, `fecha_registro`, `fecha_atencion`, `fk_usuario_atencion`, `estado_permiso`, `fk_usuario_sistema`) VALUES
(5, 'PV20250703192530', 'PERMANENCIA', 'ASD123', '111481361', 'Requiere permiso por falla mecánica del vehículo', '2025-07-04 19:19:00', '2025-07-03 19:25:30', '2025-07-05 17:48:51', '0000-00-00 00:00:00', 'APROBADO', '123456789'),
(6, 'PV20250706115057', 'PERMANENCIA', 'ASD123', '111481361', 'El vehículo presenta fallas mecánicas por lo que requiere un permiso de permanencia', '2025-07-07 11:50:00', '2025-07-06 11:50:57', '2025-07-06 21:38:58', '0000-00-00 00:00:00', 'APROBADO', '123456789'),
(7, 'PV20250708115710', 'PERMANENCIA', 'ASD123', '111481361', 'Falla mecánica del vehículo', '2025-07-09 11:56:00', '2025-07-08 11:57:10', '2025-07-08 11:57:33', '0000-00-00 00:00:00', 'APROBADO', '123456789');

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
(441, 'auto_registrar_funcionario', 'INVITADO'),
(442, 'auto_registrar_vigilante', 'INVITADO'),
(443, 'registrar_visitante', 'INVITADO'),
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
(462, 'registrar_agenda_grupal', 'COORDINADOR'),
(463, 'consultar_movimiento', 'JEFE VIGILANTES'),
(464, 'consultar_movimiento', 'SUBDIRECTOR');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`contador`, `tipo_vehiculo`, `numero_placa`, `fk_usuario`, `fecha_registro`, `fk_usuario_sistema`, `ubicacion`) VALUES
(66, 'AUTOMÓVIL', 'ASD123', '111481361', '2025-07-03 19:01:50', '123456789', 'FUERA'),
(67, 'AUTOMÓVIL', 'GHGYGG', '1114813615', '2025-07-11 15:31:26', '123456789', 'FUERA'),
(68, 'AUTOMÓVIL', 'ASD123', '1114813615', '2025-07-13 12:52:01', '123456789', 'FUERA'),
(69, 'AUTOMÓVIL', 'ASD124', '1114813615', '2025-07-13 17:04:34', '123456789', 'FUERA');

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
  `rol` varchar(15) NOT NULL,
  `contrasena` varchar(32) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_ultima_sesion` datetime NOT NULL,
  `ubicacion` varchar(6) NOT NULL DEFAULT 'FUERA',
  `estado_usuario` varchar(8) NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `vigilantes`
--

INSERT INTO `vigilantes` (`contador`, `tipo_usuario`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `rol`, `contrasena`, `fecha_registro`, `fecha_ultima_sesion`, `ubicacion`, `estado_usuario`) VALUES
(22, 'VIGILANTE', 'CC', '123456789', 'Sara', 'Rico', '1234567890', 'sara@gmail.com', 'JEFE VIGILANTES', '25d55ad283aa400af464c76d713c07ad', '2025-07-03 18:57:36', '2025-07-13 12:51:11', 'DENTRO', 'ACTIVO'),
(24, 'VIGILANTE', 'CC', '123452', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'VIGILANTE RASO', '25d55ad283aa400af464c76d713c07ad', '2025-07-12 15:32:20', '0000-00-00 00:00:00', 'FUERA', 'ACTIVO');

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
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`contador`, `tipo_usuario`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `motivo_ingreso`, `fecha_registro`, `ubicacion`) VALUES
(290, 'VISITANTE', 'CE', '1234567893', 'Daniel', 'Ramos', '1234567891', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(291, 'VISITANTE', 'CE', '1234567894', 'Daniel', 'Ramos', '1234567892', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(292, 'VISITANTE', 'CE', '1234567895', 'Daniel', 'Ramos', '1234567893', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(293, 'VISITANTE', 'CE', '1234567896', 'Daniel', 'Ramos', '1234567894', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(294, 'VISITANTE', 'CE', '1234567897', 'Daniel', 'Ramos', '1234567895', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(295, 'VISITANTE', 'CE', '1234567898', 'Daniel', 'Ramos', '1234567896', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(296, 'VISITANTE', 'CE', '1234567899', 'Daniel', 'Ramos', '1234567897', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(297, 'VISITANTE', 'CE', '1234567900', 'Daniel', 'Ramos', '1234567898', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(298, 'VISITANTE', 'CE', '1234567901', 'Daniel', 'Ramos', '1234567899', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(299, 'VISITANTE', 'CE', '1234567902', 'Daniel', 'Ramos', '1234567900', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(300, 'VISITANTE', 'CE', '1234567903', 'Daniel', 'Ramos', '1234567901', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(301, 'VISITANTE', 'CE', '1234567904', 'Daniel', 'Ramos', '1234567902', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(302, 'VISITANTE', 'CE', '1234567905', 'Daniel', 'Ramos', '1234567903', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(303, 'VISITANTE', 'CE', '1234567906', 'Daniel', 'Ramos', '1234567904', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(304, 'VISITANTE', 'CE', '1234567907', 'Daniel', 'Ramos', '1234567905', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(305, 'VISITANTE', 'CE', '1234567908', 'Daniel', 'Ramos', '1234567906', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(306, 'VISITANTE', 'CE', '1234567909', 'Daniel', 'Ramos', '1234567907', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(307, 'VISITANTE', 'CE', '1234567910', 'Daniel', 'Ramos', '1234567908', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(308, 'VISITANTE', 'CE', '1234567911', 'Daniel', 'Ramos', '1234567909', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(309, 'VISITANTE', 'CE', '1234567912', 'Daniel', 'Ramos', '1234567910', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(310, 'VISITANTE', 'CE', '1234567913', 'Daniel', 'Ramos', '1234567911', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(311, 'VISITANTE', 'CE', '1234567914', 'Daniel', 'Ramos', '1234567912', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(312, 'VISITANTE', 'CE', '1234567915', 'Daniel', 'Ramos', '1234567913', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(313, 'VISITANTE', 'CE', '1234567916', 'Daniel', 'Ramos', '1234567914', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(314, 'VISITANTE', 'CE', '1234567917', 'Daniel', 'Ramos', '1234567915', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(315, 'VISITANTE', 'CE', '1234567918', 'Daniel', 'Ramos', '1234567916', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(316, 'VISITANTE', 'CE', '1234567919', 'Daniel', 'Ramos', '1234567917', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(317, 'VISITANTE', 'CE', '1234567920', 'Daniel', 'Ramos', '1234567918', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(318, 'VISITANTE', 'CE', '1234567921', 'Daniel', 'Ramos', '1234567919', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(319, 'VISITANTE', 'CE', '1234567922', 'Daniel', 'Ramos', '1234567920', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(320, 'VISITANTE', 'CE', '1234567923', 'Daniel', 'Ramos', '1234567921', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(321, 'VISITANTE', 'CE', '1234567924', 'Daniel', 'Ramos', '1234567922', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(322, 'VISITANTE', 'CE', '1234567925', 'Daniel', 'Ramos', '1234567923', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(323, 'VISITANTE', 'CE', '1234567926', 'Daniel', 'Ramos', '1234567924', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(324, 'VISITANTE', 'CE', '1234567927', 'Daniel', 'Ramos', '1234567925', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(325, 'VISITANTE', 'CE', '1234567928', 'Daniel', 'Ramos', '1234567926', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(326, 'VISITANTE', 'CE', '1234567929', 'Daniel', 'Ramos', '1234567927', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(327, 'VISITANTE', 'CE', '1234567930', 'Daniel', 'Ramos', '1234567928', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(328, 'VISITANTE', 'CE', '1234567931', 'Daniel', 'Ramos', '1234567929', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(329, 'VISITANTE', 'CE', '1234567932', 'Daniel', 'Ramos', '1234567930', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(330, 'VISITANTE', 'CE', '1234567933', 'Daniel', 'Ramos', '1234567931', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(331, 'VISITANTE', 'CE', '1234567934', 'Daniel', 'Ramos', '1234567932', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(332, 'VISITANTE', 'CE', '1234567935', 'Daniel', 'Ramos', '1234567933', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(333, 'VISITANTE', 'CE', '1234567936', 'Daniel', 'Ramos', '1234567934', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(334, 'VISITANTE', 'CE', '1234567937', 'Daniel', 'Ramos', '1234567935', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(335, 'VISITANTE', 'CE', '1234567938', 'Daniel', 'Ramos', '1234567936', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(336, 'VISITANTE', 'CE', '1234567939', 'Daniel', 'Ramos', '1234567937', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(337, 'VISITANTE', 'CE', '1234567940', 'Daniel', 'Ramos', '1234567938', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(338, 'VISITANTE', 'CE', '1234567941', 'Daniel', 'Ramos', '1234567939', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(339, 'VISITANTE', 'CE', '1234567942', 'Daniel', 'Ramos', '1234567940', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(340, 'VISITANTE', 'CE', '1234567943', 'Daniel', 'Ramos', '1234567941', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(341, 'VISITANTE', 'CE', '1234567944', 'Daniel', 'Ramos', '1234567942', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(342, 'VISITANTE', 'CE', '1234567945', 'Daniel', 'Ramos', '1234567943', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(343, 'VISITANTE', 'CE', '1234567946', 'Daniel', 'Ramos', '1234567944', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(344, 'VISITANTE', 'CE', '1234567947', 'Daniel', 'Ramos', '1234567945', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(345, 'VISITANTE', 'CE', '1234567948', 'Daniel', 'Ramos', '1234567946', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(346, 'VISITANTE', 'CE', '1234567949', 'Daniel', 'Ramos', '1234567947', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(347, 'VISITANTE', 'CE', '1234567950', 'Daniel', 'Ramos', '1234567948', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(348, 'VISITANTE', 'CE', '1234567951', 'Daniel', 'Ramos', '1234567949', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(349, 'VISITANTE', 'CE', '1234567952', 'Daniel', 'Ramos', '1234567950', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(350, 'VISITANTE', 'CE', '1234567953', 'Daniel', 'Ramos', '1234567951', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(351, 'VISITANTE', 'CE', '1234567954', 'Daniel', 'Ramos', '1234567952', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(352, 'VISITANTE', 'CE', '1234567955', 'Daniel', 'Ramos', '1234567953', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(353, 'VISITANTE', 'CE', '1234567956', 'Daniel', 'Ramos', '1234567954', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(354, 'VISITANTE', 'CE', '1234567957', 'Daniel', 'Ramos', '1234567955', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(355, 'VISITANTE', 'CE', '1234567958', 'Daniel', 'Ramos', '1234567956', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(356, 'VISITANTE', 'CE', '1234567959', 'Daniel', 'Ramos', '1234567957', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(357, 'VISITANTE', 'CE', '1234567960', 'Daniel', 'Ramos', '1234567958', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(358, 'VISITANTE', 'CE', '1234567961', 'Daniel', 'Ramos', '1234567959', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(359, 'VISITANTE', 'CE', '1234567962', 'Daniel', 'Ramos', '1234567960', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(360, 'VISITANTE', 'CE', '1234567963', 'Daniel', 'Ramos', '1234567961', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(361, 'VISITANTE', 'CE', '1234567964', 'Daniel', 'Ramos', '1234567962', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(362, 'VISITANTE', 'CE', '1234567965', 'Daniel', 'Ramos', '1234567963', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(363, 'VISITANTE', 'CE', '1234567966', 'Daniel', 'Ramos', '1234567964', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(364, 'VISITANTE', 'CE', '1234567967', 'Daniel', 'Ramos', '1234567965', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(365, 'VISITANTE', 'CE', '1234567968', 'Daniel', 'Ramos', '1234567966', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(366, 'VISITANTE', 'CE', '1234567969', 'Daniel', 'Ramos', '1234567967', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(367, 'VISITANTE', 'CE', '1234567970', 'Daniel', 'Ramos', '1234567968', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(368, 'VISITANTE', 'CE', '1234567971', 'Daniel', 'Ramos', '1234567969', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(369, 'VISITANTE', 'CE', '1234567972', 'Daniel', 'Ramos', '1234567970', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(370, 'VISITANTE', 'CE', '1234567973', 'Daniel', 'Ramos', '1234567971', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(371, 'VISITANTE', 'CE', '1234567974', 'Daniel', 'Ramos', '1234567972', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(372, 'VISITANTE', 'CE', '1234567975', 'Daniel', 'Ramos', '1234567973', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(373, 'VISITANTE', 'CE', '1234567976', 'Daniel', 'Ramos', '1234567974', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(374, 'VISITANTE', 'CE', '1234567977', 'Daniel', 'Ramos', '1234567975', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(375, 'VISITANTE', 'CE', '1234567978', 'Daniel', 'Ramos', '1234567976', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(376, 'VISITANTE', 'CE', '1234567979', 'Daniel', 'Ramos', '1234567977', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(377, 'VISITANTE', 'CE', '1234567980', 'Daniel', 'Ramos', '1234567978', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(378, 'VISITANTE', 'CE', '1234567981', 'Daniel', 'Ramos', '1234567979', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(379, 'VISITANTE', 'CE', '1234567982', 'Daniel', 'Ramos', '1234567980', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(380, 'VISITANTE', 'CE', '1234567983', 'Daniel', 'Ramos', '1234567981', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(381, 'VISITANTE', 'CE', '1234567984', 'Daniel', 'Ramos', '1234567982', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(382, 'VISITANTE', 'CE', '1234567985', 'Daniel', 'Ramos', '1234567983', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(383, 'VISITANTE', 'CE', '1234567986', 'Daniel', 'Ramos', '1234567984', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(384, 'VISITANTE', 'CE', '1234567987', 'Daniel', 'Ramos', '1234567985', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(385, 'VISITANTE', 'CE', '1234567988', 'Daniel', 'Ramos', '1234567986', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(386, 'VISITANTE', 'CE', '1234567989', 'Daniel', 'Ramos', '1234567987', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(387, 'VISITANTE', 'CE', '1234567990', 'Daniel', 'Ramos', '1234567988', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(388, 'VISITANTE', 'CE', '1234567991', 'Daniel', 'Ramos', '1234567989', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(389, 'VISITANTE', 'CE', '1234567992', 'Daniel', 'Ramos', '1234567990', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(390, 'VISITANTE', 'CE', '1234567993', 'Daniel', 'Ramos', '1234567991', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(391, 'VISITANTE', 'CE', '1234567994', 'Daniel', 'Ramos', '1234567992', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(392, 'VISITANTE', 'CE', '1234567995', 'Daniel', 'Ramos', '1234567993', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(393, 'VISITANTE', 'CE', '1234567996', 'Daniel', 'Ramos', '1234567994', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(394, 'VISITANTE', 'CE', '1234567997', 'Daniel', 'Ramos', '1234567995', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(395, 'VISITANTE', 'CE', '1234567998', 'Daniel', 'Ramos', '1234567996', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(396, 'VISITANTE', 'CE', '1234567999', 'Daniel', 'Ramos', '1234567997', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(397, 'VISITANTE', 'CE', '1234568000', 'Daniel', 'Ramos', '1234567998', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(398, 'VISITANTE', 'CE', '1234568001', 'Daniel', 'Ramos', '1234567999', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(399, 'VISITANTE', 'CE', '1234568002', 'Daniel', 'Ramos', '1234568000', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(400, 'VISITANTE', 'CE', '1234568003', 'Daniel', 'Ramos', '1234568001', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(401, 'VISITANTE', 'CE', '1234568004', 'Daniel', 'Ramos', '1234568002', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(402, 'VISITANTE', 'CE', '1234568005', 'Daniel', 'Ramos', '1234568003', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(403, 'VISITANTE', 'CE', '1234568006', 'Daniel', 'Ramos', '1234568004', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(404, 'VISITANTE', 'CE', '1234568007', 'Daniel', 'Ramos', '1234568005', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(405, 'VISITANTE', 'CE', '1234568008', 'Daniel', 'Ramos', '1234568006', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(406, 'VISITANTE', 'CE', '1234568009', 'Daniel', 'Ramos', '1234568007', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(407, 'VISITANTE', 'CE', '1234568010', 'Daniel', 'Ramos', '1234568008', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(408, 'VISITANTE', 'CE', '1114813615', 'Juan David', 'Restrepo Fernandez', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-02 23:42:29', 'DENTRO'),
(409, 'VISITANTE', 'CC', '111481361', 'Juan David', 'Restrepo Fernandez', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-07-02 23:55:01', 'DENTRO'),
(410, 'VISITANTE', 'CE', '12345678988', 'Daniel', 'Ramos', '1234567890', 'daniel@gmail.com', 'Hjhjhjh', '2025-07-07 17:16:56', 'FUERA'),
(411, 'VISITANTE', 'CC', '12345678888', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'La ficha del aprendiz ha finalizado', '2025-07-07 21:41:47', 'DENTRO'),
(413, 'VISITANTE', 'CC', '1324525252', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:00:27', 'FUERA'),
(414, 'VISITANTE', 'CC', '4343344343', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:11:51', 'DENTRO'),
(415, 'VISITANTE', 'CC', '34343434343434', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:36:34', 'FUERA'),
(416, 'VISITANTE', 'CC', '11148136176', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:37:58', 'FUERA'),
(417, 'VISITANTE', 'CC', '111481361989', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:38:44', 'FUERA'),
(418, 'VISITANTE', 'CC', '1148363536', 'Juan David', 'Ramos Fernandez', '1234567890', 'juan@gmail.com', 'Rrrrrrrr', '2025-07-11 16:44:15', 'FUERA'),
(419, 'VISITANTE', 'CC', '1114813610909', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-07-11 16:45:56', 'FUERA'),
(420, 'VISITANTE', 'CC', '11148136109', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:50:27', 'FUERA'),
(421, 'VISITANTE', 'CC', '1221212213', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:51:51', 'FUERA'),
(422, 'VISITANTE', 'CC', '12212178', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:52:55', 'FUERA'),
(423, 'VISITANTE', 'CC', '232332389', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:54:35', 'FUERA'),
(424, 'VISITANTE', 'CC', '1114813610954', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-11 16:58:51', 'FUERA'),
(425, 'VISITANTE', 'CC', '12345678907', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-13 17:21:24', 'FUERA');

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4188;

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estadias_aprendices`
--
ALTER TABLE `estadias_aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `novedades_vehiculos`
--
ALTER TABLE `novedades_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `permisos_vehiculos`
--
ALTER TABLE `permisos_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `roles_operaciones`
--
ALTER TABLE `roles_operaciones`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
