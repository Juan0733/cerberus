-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2025 a las 04:22:52
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

--
-- Volcado de datos para la tabla `agendas`
--

INSERT INTO `agendas` (`contador`, `codigo_agenda`, `titulo`, `motivo`, `fk_usuario`, `fecha_agenda`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(3593, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567892', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3594, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567893', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3595, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567894', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3596, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567895', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3597, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567896', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3598, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567897', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3599, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567898', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3600, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567899', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3601, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567900', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3602, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567901', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3603, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567902', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3604, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567903', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3605, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567904', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3606, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567905', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3607, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567906', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3608, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567907', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3609, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567908', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3610, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567909', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3611, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567910', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3612, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567911', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3613, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567912', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3614, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567913', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3615, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567914', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3616, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567915', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3617, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567916', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3618, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567917', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3619, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567918', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3620, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567919', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3621, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567920', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3622, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567921', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3623, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567922', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3624, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567923', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3625, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567924', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3626, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567925', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3627, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567926', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3628, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567927', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3629, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567928', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3630, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567929', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3631, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567930', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3632, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567931', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3633, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567932', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3634, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567933', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3635, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567934', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3636, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567935', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3637, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567936', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3638, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567937', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3639, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567938', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3640, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567939', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3641, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567940', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3642, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567941', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3643, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567942', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3644, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567943', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3645, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567944', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3646, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567945', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3647, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567946', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3648, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567947', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3649, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567948', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3650, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567949', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3651, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567950', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3652, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567951', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3653, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567952', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3654, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567953', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3655, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567954', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3656, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567955', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3657, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567956', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3658, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567957', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3659, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567958', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3660, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567959', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3661, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567960', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3662, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567961', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3663, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567962', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3664, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567963', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3665, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567964', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3666, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567965', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3667, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567966', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3668, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567967', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3669, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567968', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3670, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567969', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3671, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567970', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3672, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567971', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3673, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567972', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3674, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567973', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3675, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567974', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3676, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567975', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3677, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567976', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3678, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567977', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3679, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567978', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3680, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567979', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3681, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567980', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3682, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567981', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3683, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567982', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3684, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567983', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3685, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567984', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3686, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567985', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3687, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567986', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3688, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567987', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3689, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567988', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3690, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567989', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3691, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567990', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3692, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567991', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3693, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567992', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3694, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567993', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3695, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567994', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3696, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567995', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3697, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567996', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3698, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567997', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3699, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567998', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3700, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234567999', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3701, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568000', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3702, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568001', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3703, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568002', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3704, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568003', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3705, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568004', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3706, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568005', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3707, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568006', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3708, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568007', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3709, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568008', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3710, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568009', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892'),
(3711, 'AG20250702171423', 'Mercado Campesino', 'Dfdfdfdf', '1234568010', '2025-07-02 17:14:00', '2025-07-02 17:14:23', '1234567892');

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

--
-- Volcado de datos para la tabla `aprendices`
--

INSERT INTO `aprendices` (`contador`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `telefono`, `correo_electronico`, `fk_ficha`, `fecha_registro`, `ubicacion`) VALUES
(6, 'CC', '1234524236', 'Juan David', 'Restrepo Fernandez', '1234567890', 'juan@gmail.com', '2714805', '2025-07-03 00:12:39', 'FUERA');

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
(6, '2714805', 'Analisis Y Desarrollo De Software', '2025-07-31', '2025-07-03 00:12:39', '');

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
(30, 'CC', '1234567892', 'Jeronimo Alexander', 'Pizarro Rodríguez', '1234567890', 'jeronimo@gmail.com', 'SUBDIRECTOR', 'PLANTA', NULL, '25d55ad283aa400af464c76d713c07ad', 'NO', '2025-06-27 05:38:32', '2025-07-03 21:20:19', 'FUERA', 'ACTIVO');

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
(4, 'Ddsdsdssdsds', '2025-06-26 13:44:25'),
(5, 'Dfdfdfdf', '2025-07-02 17:14:19'),
(6, 'Matricula', '2025-07-02 23:42:29'),
(7, 'Inscripcion', '2025-07-02 23:55:01');

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
(116, 'ENTRADA', '1114813615', NULL, NULL, 'PEATONAL', NULL, '2025-07-03 18:58:06', '123456789', 'visitantes'),
(117, 'ENTRADA', '1114813615', NULL, NULL, 'PEATONAL', NULL, '2025-07-03 18:58:42', '123456789', 'visitantes'),
(118, 'ENTRADA', '111481361', 'ASD123', 'PROPIETARIO', 'PEATONAL', 'NULL', '2025-07-02 19:01:59', '123456789', 'visitantes'),
(119, 'SALIDA', '1114813615', NULL, NULL, 'PEATONAL', NULL, '2025-07-03 19:02:23', '123456789', 'visitantes'),
(120, 'SALIDA', '1114813615', NULL, NULL, 'PEATONAL', NULL, '2025-07-03 19:03:05', '123456789', 'visitantes');

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

--
-- Volcado de datos para la tabla `novedades_usuarios`
--

INSERT INTO `novedades_usuarios` (`contador`, `codigo_novedad`, `tipo_novedad`, `puerta_suceso`, `puerta_registro`, `descripcion`, `fk_usuario`, `fecha_suceso`, `fecha_registro`, `fk_usuario_sistema`) VALUES
(33, 'NU20250703185835', 'SALIDA NO REGISTRADA', 'PEATONAL', 'PEATONAL', 'No se le registro la salida', '1114813615', '2025-07-03 18:58:00', '2025-07-03 18:58:35', '123456789'),
(34, 'NU20250703190302', 'ENTRADA NO REGISTRADA', 'PEATONAL', 'PEATONAL', 'No se le registro la entrada', '1114813615', '2025-07-03 19:02:00', '2025-07-03 19:03:02', '123456789');

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

--
-- Volcado de datos para la tabla `permisos_usuarios`
--

INSERT INTO `permisos_usuarios` (`contador`, `codigo_permiso`, `tipo_permiso`, `fk_usuario`, `descripcion`, `fecha_fin_permiso`, `fecha_registro`, `fecha_atencion`, `fk_usuario_atencion`, `estado_permiso`, `fk_usuario_sistema`) VALUES
(12, 'PU20250703191922', 'PERMANENCIA', '111481361', 'Requiere permiso para finalizar un trabajo dentro del cab', '2025-07-04 19:07:00', '2025-07-03 19:19:22', '2025-07-03 20:50:31', '1234567892', 'APROBADO', '123456789');

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

--
-- Volcado de datos para la tabla `permisos_vehiculos`
--

INSERT INTO `permisos_vehiculos` (`contador`, `codigo_permiso`, `tipo_permiso`, `fk_vehiculo`, `fk_usuario`, `descripcion`, `fecha_fin_permiso`, `fecha_registro`, `fecha_atencion`, `fk_usuario_atencion`, `estado_permiso`, `fk_usuario_sistema`) VALUES
(5, 'PV20250703192530', 'PERMANENCIA', 'ASD123', '111481361', 'Requiere permiso por falla mecánica del vehículo', '2025-07-04 19:19:00', '2025-07-03 19:25:30', NULL, NULL, 'PENDIENTE', '123456789');

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

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`contador`, `tipo_vehiculo`, `numero_placa`, `fk_usuario`, `fecha_registro`, `fk_usuario_sistema`, `ubicacion`) VALUES
(66, 'AUTOMÓVIL', 'ASD123', '111481361', '2025-07-03 19:01:50', '123456789', 'DENTRO');

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
(22, 'CC', '123456789', 'Sara', 'Rico', '1234567890', 'sara@gmail.com', 'JEFE VIGILANTES', '25d55ad283aa400af464c76d713c07ad', '2025-07-03 18:57:36', '2025-07-03 21:10:16', 'FUERA', 'ACTIVO');

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
(290, 'CE', '1234567893', 'Daniel', 'Ramos', '1234567891', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(291, 'CE', '1234567894', 'Daniel', 'Ramos', '1234567892', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(292, 'CE', '1234567895', 'Daniel', 'Ramos', '1234567893', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(293, 'CE', '1234567896', 'Daniel', 'Ramos', '1234567894', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(294, 'CE', '1234567897', 'Daniel', 'Ramos', '1234567895', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(295, 'CE', '1234567898', 'Daniel', 'Ramos', '1234567896', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(296, 'CE', '1234567899', 'Daniel', 'Ramos', '1234567897', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(297, 'CE', '1234567900', 'Daniel', 'Ramos', '1234567898', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(298, 'CE', '1234567901', 'Daniel', 'Ramos', '1234567899', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(299, 'CE', '1234567902', 'Daniel', 'Ramos', '1234567900', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(300, 'CE', '1234567903', 'Daniel', 'Ramos', '1234567901', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(301, 'CE', '1234567904', 'Daniel', 'Ramos', '1234567902', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(302, 'CE', '1234567905', 'Daniel', 'Ramos', '1234567903', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(303, 'CE', '1234567906', 'Daniel', 'Ramos', '1234567904', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(304, 'CE', '1234567907', 'Daniel', 'Ramos', '1234567905', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(305, 'CE', '1234567908', 'Daniel', 'Ramos', '1234567906', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(306, 'CE', '1234567909', 'Daniel', 'Ramos', '1234567907', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(307, 'CE', '1234567910', 'Daniel', 'Ramos', '1234567908', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(308, 'CE', '1234567911', 'Daniel', 'Ramos', '1234567909', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(309, 'CE', '1234567912', 'Daniel', 'Ramos', '1234567910', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(310, 'CE', '1234567913', 'Daniel', 'Ramos', '1234567911', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(311, 'CE', '1234567914', 'Daniel', 'Ramos', '1234567912', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(312, 'CE', '1234567915', 'Daniel', 'Ramos', '1234567913', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:19', 'FUERA'),
(313, 'CE', '1234567916', 'Daniel', 'Ramos', '1234567914', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(314, 'CE', '1234567917', 'Daniel', 'Ramos', '1234567915', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(315, 'CE', '1234567918', 'Daniel', 'Ramos', '1234567916', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(316, 'CE', '1234567919', 'Daniel', 'Ramos', '1234567917', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(317, 'CE', '1234567920', 'Daniel', 'Ramos', '1234567918', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(318, 'CE', '1234567921', 'Daniel', 'Ramos', '1234567919', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(319, 'CE', '1234567922', 'Daniel', 'Ramos', '1234567920', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(320, 'CE', '1234567923', 'Daniel', 'Ramos', '1234567921', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(321, 'CE', '1234567924', 'Daniel', 'Ramos', '1234567922', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(322, 'CE', '1234567925', 'Daniel', 'Ramos', '1234567923', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(323, 'CE', '1234567926', 'Daniel', 'Ramos', '1234567924', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(324, 'CE', '1234567927', 'Daniel', 'Ramos', '1234567925', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(325, 'CE', '1234567928', 'Daniel', 'Ramos', '1234567926', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(326, 'CE', '1234567929', 'Daniel', 'Ramos', '1234567927', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(327, 'CE', '1234567930', 'Daniel', 'Ramos', '1234567928', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(328, 'CE', '1234567931', 'Daniel', 'Ramos', '1234567929', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(329, 'CE', '1234567932', 'Daniel', 'Ramos', '1234567930', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(330, 'CE', '1234567933', 'Daniel', 'Ramos', '1234567931', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(331, 'CE', '1234567934', 'Daniel', 'Ramos', '1234567932', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(332, 'CE', '1234567935', 'Daniel', 'Ramos', '1234567933', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(333, 'CE', '1234567936', 'Daniel', 'Ramos', '1234567934', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(334, 'CE', '1234567937', 'Daniel', 'Ramos', '1234567935', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(335, 'CE', '1234567938', 'Daniel', 'Ramos', '1234567936', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(336, 'CE', '1234567939', 'Daniel', 'Ramos', '1234567937', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(337, 'CE', '1234567940', 'Daniel', 'Ramos', '1234567938', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(338, 'CE', '1234567941', 'Daniel', 'Ramos', '1234567939', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(339, 'CE', '1234567942', 'Daniel', 'Ramos', '1234567940', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(340, 'CE', '1234567943', 'Daniel', 'Ramos', '1234567941', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:20', 'FUERA'),
(341, 'CE', '1234567944', 'Daniel', 'Ramos', '1234567942', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(342, 'CE', '1234567945', 'Daniel', 'Ramos', '1234567943', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(343, 'CE', '1234567946', 'Daniel', 'Ramos', '1234567944', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(344, 'CE', '1234567947', 'Daniel', 'Ramos', '1234567945', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(345, 'CE', '1234567948', 'Daniel', 'Ramos', '1234567946', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(346, 'CE', '1234567949', 'Daniel', 'Ramos', '1234567947', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(347, 'CE', '1234567950', 'Daniel', 'Ramos', '1234567948', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(348, 'CE', '1234567951', 'Daniel', 'Ramos', '1234567949', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(349, 'CE', '1234567952', 'Daniel', 'Ramos', '1234567950', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(350, 'CE', '1234567953', 'Daniel', 'Ramos', '1234567951', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(351, 'CE', '1234567954', 'Daniel', 'Ramos', '1234567952', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(352, 'CE', '1234567955', 'Daniel', 'Ramos', '1234567953', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(353, 'CE', '1234567956', 'Daniel', 'Ramos', '1234567954', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(354, 'CE', '1234567957', 'Daniel', 'Ramos', '1234567955', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(355, 'CE', '1234567958', 'Daniel', 'Ramos', '1234567956', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(356, 'CE', '1234567959', 'Daniel', 'Ramos', '1234567957', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(357, 'CE', '1234567960', 'Daniel', 'Ramos', '1234567958', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(358, 'CE', '1234567961', 'Daniel', 'Ramos', '1234567959', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(359, 'CE', '1234567962', 'Daniel', 'Ramos', '1234567960', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(360, 'CE', '1234567963', 'Daniel', 'Ramos', '1234567961', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(361, 'CE', '1234567964', 'Daniel', 'Ramos', '1234567962', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(362, 'CE', '1234567965', 'Daniel', 'Ramos', '1234567963', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(363, 'CE', '1234567966', 'Daniel', 'Ramos', '1234567964', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(364, 'CE', '1234567967', 'Daniel', 'Ramos', '1234567965', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(365, 'CE', '1234567968', 'Daniel', 'Ramos', '1234567966', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(366, 'CE', '1234567969', 'Daniel', 'Ramos', '1234567967', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(367, 'CE', '1234567970', 'Daniel', 'Ramos', '1234567968', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:21', 'FUERA'),
(368, 'CE', '1234567971', 'Daniel', 'Ramos', '1234567969', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(369, 'CE', '1234567972', 'Daniel', 'Ramos', '1234567970', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(370, 'CE', '1234567973', 'Daniel', 'Ramos', '1234567971', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(371, 'CE', '1234567974', 'Daniel', 'Ramos', '1234567972', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(372, 'CE', '1234567975', 'Daniel', 'Ramos', '1234567973', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(373, 'CE', '1234567976', 'Daniel', 'Ramos', '1234567974', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(374, 'CE', '1234567977', 'Daniel', 'Ramos', '1234567975', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(375, 'CE', '1234567978', 'Daniel', 'Ramos', '1234567976', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(376, 'CE', '1234567979', 'Daniel', 'Ramos', '1234567977', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(377, 'CE', '1234567980', 'Daniel', 'Ramos', '1234567978', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(378, 'CE', '1234567981', 'Daniel', 'Ramos', '1234567979', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(379, 'CE', '1234567982', 'Daniel', 'Ramos', '1234567980', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(380, 'CE', '1234567983', 'Daniel', 'Ramos', '1234567981', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(381, 'CE', '1234567984', 'Daniel', 'Ramos', '1234567982', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(382, 'CE', '1234567985', 'Daniel', 'Ramos', '1234567983', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(383, 'CE', '1234567986', 'Daniel', 'Ramos', '1234567984', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(384, 'CE', '1234567987', 'Daniel', 'Ramos', '1234567985', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(385, 'CE', '1234567988', 'Daniel', 'Ramos', '1234567986', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(386, 'CE', '1234567989', 'Daniel', 'Ramos', '1234567987', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(387, 'CE', '1234567990', 'Daniel', 'Ramos', '1234567988', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(388, 'CE', '1234567991', 'Daniel', 'Ramos', '1234567989', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(389, 'CE', '1234567992', 'Daniel', 'Ramos', '1234567990', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(390, 'CE', '1234567993', 'Daniel', 'Ramos', '1234567991', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(391, 'CE', '1234567994', 'Daniel', 'Ramos', '1234567992', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(392, 'CE', '1234567995', 'Daniel', 'Ramos', '1234567993', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(393, 'CE', '1234567996', 'Daniel', 'Ramos', '1234567994', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(394, 'CE', '1234567997', 'Daniel', 'Ramos', '1234567995', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(395, 'CE', '1234567998', 'Daniel', 'Ramos', '1234567996', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:22', 'FUERA'),
(396, 'CE', '1234567999', 'Daniel', 'Ramos', '1234567997', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(397, 'CE', '1234568000', 'Daniel', 'Ramos', '1234567998', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(398, 'CE', '1234568001', 'Daniel', 'Ramos', '1234567999', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(399, 'CE', '1234568002', 'Daniel', 'Ramos', '1234568000', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(400, 'CE', '1234568003', 'Daniel', 'Ramos', '1234568001', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(401, 'CE', '1234568004', 'Daniel', 'Ramos', '1234568002', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(402, 'CE', '1234568005', 'Daniel', 'Ramos', '1234568003', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(403, 'CE', '1234568006', 'Daniel', 'Ramos', '1234568004', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(404, 'CE', '1234568007', 'Daniel', 'Ramos', '1234568005', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(405, 'CE', '1234568008', 'Daniel', 'Ramos', '1234568006', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(406, 'CE', '1234568009', 'Daniel', 'Ramos', '1234568007', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(407, 'CE', '1234568010', 'Daniel', 'Ramos', '1234568008', 'daniel@gmail.com', 'Dfdfdfdf', '2025-07-02 17:14:23', 'FUERA'),
(408, 'CE', '1114813615', 'Juan David', 'Restrepo Fernandez', '1234567890', 'juan@gmail.com', 'Matricula', '2025-07-02 23:42:29', 'FUERA'),
(409, 'CC', '111481361', 'Juan David', 'Restrepo Fernandez', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-07-02 23:55:01', 'DENTRO');

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3712;

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estadias_aprendices`
--
ALTER TABLE `estadias_aprendices`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `novedades_vehiculos`
--
ALTER TABLE `novedades_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos_usuarios`
--
ALTER TABLE `permisos_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `permisos_vehiculos`
--
ALTER TABLE `permisos_vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
