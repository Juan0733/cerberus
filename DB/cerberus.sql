-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2025 a las 23:15:09
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
(2522, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567892', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2523, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567893', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2524, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567894', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2525, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567895', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2526, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567896', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2527, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567897', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2528, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567898', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2529, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567899', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2530, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567900', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2531, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567901', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2532, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567902', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2533, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567903', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2534, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567904', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2535, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567905', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2536, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567906', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2537, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567907', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2538, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567908', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2539, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567909', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2540, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567910', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2541, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567911', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2542, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567912', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2543, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567913', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2544, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567914', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2545, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567915', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2546, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567916', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2547, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567917', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2548, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567918', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2549, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567919', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2550, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567920', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2551, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567921', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2552, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567922', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2553, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567923', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2554, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567924', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2555, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567925', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2556, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567926', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2557, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567927', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2558, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567928', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2559, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567929', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2560, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567930', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2561, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567931', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2562, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567932', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2563, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567933', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2564, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567934', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2565, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567935', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2566, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567936', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2567, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567937', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2568, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567938', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2569, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567939', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2570, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567940', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2571, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567941', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2572, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567942', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2573, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567943', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2574, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567944', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2575, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567945', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2576, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567946', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2577, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567947', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2578, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567948', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2579, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567949', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2580, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567950', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2581, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567951', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2582, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567952', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2583, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567953', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2584, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567954', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2585, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567955', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2586, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567956', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2587, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567957', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2588, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567958', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2589, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567959', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2590, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567960', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2591, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567961', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2592, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567962', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2593, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567963', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2594, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567964', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2595, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567965', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2596, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567966', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2597, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567967', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2598, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567968', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2599, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567969', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2600, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567970', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2601, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567971', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2602, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567972', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2603, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567973', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2604, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567974', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2605, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567975', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2606, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567976', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2607, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567977', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2608, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567978', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2609, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567979', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2610, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567980', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2611, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567981', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2612, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567982', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2613, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567983', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2614, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567984', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2615, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567985', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2616, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567986', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2617, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567987', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2618, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567988', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2619, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567989', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2620, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567990', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2621, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567991', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2622, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567992', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2623, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567993', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2624, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567994', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2625, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567995', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2626, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567996', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2627, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567997', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2628, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567998', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2629, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234567999', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2630, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568000', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2631, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568001', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2632, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568002', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2633, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568003', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2634, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568004', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2635, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568005', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2636, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568006', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2637, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568007', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2638, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568008', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2639, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568009', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789'),
(2640, 'AG20250624112319', 'Mercado Campesino', 'dssdsdss', '1234568010', '2025-06-24 11:23:00', '2025-06-24 11:23:19', '123456789');

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
(2, 'CC', '123456789090', 'Alejandro', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', '2714805', '2025-06-16 19:38:56', 'FUERA'),
(3, 'CC', '123456789098', 'Alejandro', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', '2714805', '2025-06-16 19:39:45', 'FUERA'),
(4, 'CC', '123456789097', 'Juan David', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', '2714805', '2025-06-16 19:44:36', 'FUERA'),
(5, 'CC', '12345242300', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', '2714805', '2025-06-24 03:58:03', 'FUERA');

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
(5, '2714805', 'Analisis Y Desarrollo De Software', '2025-12-31', '2025-06-24 04:00:02', '');

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
(13, 'CC', '1234567890', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(14, 'CC', '1234567899', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(16, 'CC', '12345678902', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(17, 'CC', '12345678901', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(18, 'CC', '12345678908', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(19, 'CC', '123456789077', 'Juan David', 'Restrepo Perez', '1234567890', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(20, 'CC', '123456789055', 'Juan David', 'Restrepo Perez', '1234567897', 'juan@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-05-19 18:00:00', NULL, 'DENTRO', NULL),
(22, 'CC', '12345678888', 'Alejandro', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', 'personal administrativo', 'planta', NULL, NULL, 'SI', '2025-06-19 14:18:57', NULL, 'FUERA', NULL),
(23, 'CC', '12345678887', 'Alejandro', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-06-19 14:20:42', NULL, 'FUERA', NULL),
(24, 'CC', '12345678885', 'Alejandro', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', 'instructor', 'planta', NULL, NULL, 'SI', '2025-06-19 14:22:58', NULL, 'FUERA', NULL),
(25, 'CC', '12345678884', 'Alejandro', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', 'coordinador', 'planta', NULL, '25d55ad283aa400af464c76d713c07ad', 'SI', '2025-06-19 14:30:16', NULL, 'FUERA', 'ACTIVO'),
(26, 'CC', '1234524231', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'coordinador', 'contratista', '2025-06-28', '25d55ad283aa400af464c76d713c07ad', 'SI', '2025-06-21 16:23:48', NULL, 'FUERA', 'ACTIVO'),
(27, 'CC', '1234524236', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'coordinador', 'planta', NULL, '25f9e794323b453885f5181f1b624d0b', 'SI', '2025-06-21 16:28:43', NULL, 'FUERA', 'INACTIVO');

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
(1, 'Inscripcion', '2025-06-16 11:38:08'),
(2, 'fggfgfgf', '2025-06-22 16:34:46'),
(3, 'fffddfdf', '2025-06-23 13:25:38');

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
(72, 'ENTRADA', '123456789', 'ASD123', 'propietario', 'peatonal', 'NULL', '2025-04-19 13:25:03', '123456789', 'vigilantes'),
(73, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:46:31', '123456789', 'vigilantes'),
(74, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:46:43', '123456789', 'vigilantes'),
(75, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:46:51', '123456789', 'vigilantes'),
(76, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:46:57', '123456789', 'vigilantes'),
(77, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:47:03', '123456789', 'vigilantes'),
(78, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:47:09', '123456789', 'vigilantes'),
(79, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:47:23', '123456789', 'vigilantes'),
(80, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:48:46', '123456789', 'vigilantes'),
(81, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:48:51', '123456789', 'vigilantes'),
(82, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:48:57', '123456789', 'vigilantes'),
(83, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:49:04', '123456789', 'vigilantes'),
(84, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:49:12', '123456789', 'vigilantes'),
(85, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-20 21:49:19', '123456789', 'vigilantes'),
(86, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-22 12:30:58', '123456789', 'vigilantes'),
(87, 'SALIDA', '1234567890', NULL, NULL, 'peatonal', NULL, '2025-05-22 14:20:29', '123456789', 'funcionarios'),
(88, 'ENTRADA', '1234567890', NULL, NULL, 'peatonal', NULL, '2025-05-25 22:26:20', '123456789', 'funcionarios'),
(89, 'ENTRADA', '1234567890', NULL, NULL, 'peatonal', NULL, '2025-05-25 22:27:27', '123456789', 'funcionarios'),
(90, 'SALIDA', '1234567890', 'DFD345', 'Propietario', 'peatonal', NULL, '2025-05-25 22:28:07', '123456789', 'funcionarios'),
(91, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-27 09:47:23', '123456789', 'vigilantes'),
(92, 'ENTRADA', '123456789', NULL, NULL, '', NULL, '2025-05-27 13:38:26', '', 'vigilantes'),
(93, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-28 11:30:47', '123456789', 'vigilantes'),
(94, 'ENTRADA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-28 12:50:03', '123456789', 'vigilantes'),
(95, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-28 15:56:44', '123456789', 'vigilantes'),
(96, 'ENTRADA', '123456789', 'FF3030', 'Propietario', 'peatonal', 'NULL', '2025-05-28 15:57:21', '123456789', 'vigilantes'),
(97, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-05-30 18:35:12', '123456789', 'vigilantes'),
(98, 'ENTRADA', '123456789', 'DFD345', 'Propietario', 'peatonal', 'NULL', '2025-05-30 18:36:09', '123456789', 'vigilantes'),
(99, 'ENTRADA', '1234567890', 'DFD345', 'Propietario', 'peatonal', 'NULL', '2025-05-30 18:36:52', '123456789', 'funcionarios'),
(100, 'ENTRADA', '121222', NULL, NULL, 'peatonal', NULL, '2025-06-02 09:30:08', '123456789', 'visitantes'),
(101, 'ENTRADA', '1234567890', 'ASD123', 'Propietario', 'peatonal', 'NULL', '2025-06-12 15:18:55', '123456789', 'funcionarios'),
(102, 'ENTRADA', '123456789', 'ASD123', 'Propietario', 'peatonal', 'NULL', '2025-06-12 15:19:56', '123456789', 'vigilantes'),
(103, 'ENTRADA', '123456789', 'ASD123', 'Propietario', 'peatonal', 'NULL', '2025-06-12 15:35:41', '123456789', 'vigilantes'),
(104, 'ENTRADA', '123456789', 'ASD123', 'Propietario', 'peatonal', 'NULL', '2025-06-12 15:50:53', '123456789', 'vigilantes'),
(105, 'ENTRADA', '123456789', 'ASD123', 'Propietario', 'peatonal', 'NULL', '2025-06-12 16:03:37', '123456789', 'vigilantes'),
(106, 'SALIDA', '123456789', NULL, NULL, 'peatonal', NULL, '2025-06-12 16:03:58', '123456789', 'vigilantes');

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
(21, '', 'SALIDA NO REGISTRADA', 'ganaderia', 'peatonal', 'dfdfdfdfdf', '1234567890', '2025-05-25 22:26:00', '2025-05-25 22:27:24', '123456789'),
(22, '', 'SALIDA NO REGISTRADA', 'ganaderia', 'peatonal', 'sdssdsdss', '1234567890', '2025-06-10 16:11:00', '2025-06-10 16:11:25', '123456789'),
(23, '', 'SALIDA NO REGISTRADA', 'ganaderia', 'peatonal', 'jhjhjhjhj', '123456789', '2025-06-12 15:19:00', '2025-06-12 15:19:46', '123456789'),
(24, '', 'SALIDA NO REGISTRADA', 'ganaderia', 'peatonal', 'hjhhjhj', '123456789', '2025-06-12 15:35:00', '2025-06-12 15:35:35', '123456789'),
(25, '', 'SALIDA NO REGISTRADA', 'ganaderia', 'peatonal', 'hjhhhhh', '123456789', '2025-06-12 15:49:00', '2025-06-12 15:49:20', '123456789'),
(26, '', 'SALIDA NO REGISTRADA', 'principal', 'peatonal', 'jkkkkkjj', '123456789', '2025-06-12 16:03:00', '2025-06-12 16:03:31', '123456789');

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
  `tipo_vehiculo` varchar(10) NOT NULL,
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
(52, 'Automóvil', 'DFD345', '123456789', '2025-05-30 18:35:49', '123456789', 'DENTRO'),
(54, 'Automóvil', 'ASDWER', '1114813615', '2025-06-06 09:28:26', '123456789', 'FUERA'),
(55, 'Automóvil', 'ASSSSS', '1114813615', '2025-06-06 09:34:11', '123456789', 'FUERA'),
(56, 'Automóvil', 'ASDERT', '1114813615', '2025-06-06 09:36:40', '123456789', 'FUERA'),
(58, '', 'ASD123', '123456789', '2025-06-12 15:19:56', '123456789', 'DENTRO'),
(59, 'Automóvil', 'ASD123', '1114813615', '2025-06-23 13:22:23', '123456789', 'FUERA'),
(61, 'Automóvil', 'ASD123', '434343434443', '2025-06-23 14:24:52', '123456789', 'FUERA');

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
(2, 'CC', '123456789', 'Sara', 'Rico', '123456789', 'alejandro@gmail.com', 'jefe vigilantes', '25d55ad283aa400af464c76d713c07ad', '2025-04-30 05:30:11', '2025-04-30 05:30:11', 'FUERA', 'ACTIVO'),
(16, 'CC', '1234567891', 'Alejandro', 'Restrepo Fernandez', '1234567890', 'alejandro@gmail.com', 'vigilante raso', '25d55ad283aa400af464c76d713c07ad', '2025-06-16 12:39:27', '0000-00-00 00:00:00', 'FUERA', 'INACTIVO'),
(17, 'CC', '1234567901', 'Alejandro', 'Restrepo Fernandez', '1234567901', 'alejandro@gmail.com', 'vigilante raso', '25d55ad283aa400af464c76d713c07ad', '2025-06-16 12:40:12', '0000-00-00 00:00:00', 'FUERA', 'ACTIVO'),
(18, 'CC', '1234567902', 'Alejandro', 'Restrepo Fernandez', '1234567901', 'alejandro@gmail.com', 'vigilante raso', '25d55ad283aa400af464c76d713c07ad', '2025-06-16 12:41:27', '0000-00-00 00:00:00', 'FUERA', 'INACTIVO'),
(19, 'CC', '1234567903', 'Alejandro', 'Restrepo Fernandez', '1234567901', 'alejandro@gmail.com', 'vigilante raso', '25f9e794323b453885f5181f1b624d0b', '2025-06-16 12:42:14', '0000-00-00 00:00:00', 'FUERA', 'ACTIVO');

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
(25, 'CC', '121212120', 'Juan David', 'Perez Hernandez', '1234567889', 'Juan@gmail.com', '', '2025-05-24 22:30:33', 'FUERA'),
(26, 'CC', '121212121', 'Juan David', 'Perez Hernandez', '1234567890', 'Juan@gmail.com', '', '2025-05-24 22:30:33', 'FUERA'),
(27, 'CC', '121212122', 'Juan David', 'Perez Hernandez', '1234567891', 'Juan@gmail.com', '', '2025-05-24 22:30:33', 'FUERA'),
(28, 'CC', '121212123', 'Juan David', 'Perez Hernandez', '1234567892', 'Juan@gmail.com', '', '2025-05-24 22:31:33', 'FUERA'),
(29, 'CC', '121212124', 'Juan David', 'Perez Hernandez', '1234567893', 'Juan@gmail.com', '', '2025-05-24 22:31:33', 'FUERA'),
(30, 'CC', '121212125', 'Juan David', 'Perez Hernandez', '1234567894', 'Juan@gmail.com', '', '2025-05-24 22:31:33', 'FUERA'),
(31, 'CC', '121212126', 'Juan David', 'Perez Hernandez', '1234567895', 'Juan@gmail.com', '', '2025-05-24 22:31:33', 'FUERA'),
(32, 'CC', '1245454', 'Juan David', 'Perez Hernandez', '1234567890', 'Juan@gmail.com', 'Reunion de deportistas en el CAB', '2025-05-26 09:02:17', 'FUERA'),
(33, 'CC', '1245455', 'Juan David', 'Perez Hernandez', '1234567891', 'Juan@gmail.com', 'Reunion de deportistas en el CAB', '2025-05-26 09:03:17', 'FUERA'),
(34, 'CC', '123456565', 'Juan David', 'Perez Hernandez', '1234567890', 'Jeronimo@gmail.com', 'evento deportivo en el CAB', '2025-05-26 09:54:38', 'FUERA'),
(36, 'CC', '121222', 'Juan David', 'Perez Hernandez', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-06-01 21:56:06', 'DENTRO'),
(37, 'CC', '1114813615', 'Juan David', 'Perez Hernandez', '1234567890', 'juan@gmail.com', 'Evento deportivo que reúne a todos los sena del valle', '2025-06-03 09:39:05', 'FUERA'),
(47, 'CE', '1234567904', 'Juan David', 'Perez Hernandez', '1234567902', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(48, 'CE', '1234567905', 'Juan David', 'Perez Hernandez', '1234567903', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(49, 'CE', '1234567906', 'Juan David', 'Perez Hernandez', '1234567904', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(50, 'CE', '1234567907', 'Juan David', 'Perez Hernandez', '1234567905', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(51, 'CE', '1234567908', 'Juan David', 'Perez Hernandez', '1234567906', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(52, 'CE', '1234567909', 'Juan David', 'Perez Hernandez', '1234567907', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(53, 'CE', '1234567910', 'Juan David', 'Perez Hernandez', '1234567908', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(54, 'CE', '1234567911', 'Juan David', 'Perez Hernandez', '1234567909', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(55, 'CE', '1234567912', 'Juan David', 'Perez Hernandez', '1234567910', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(56, 'CE', '1234567913', 'Juan David', 'Perez Hernandez', '1234567911', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(57, 'CE', '1234567914', 'Juan David', 'Perez Hernandez', '1234567912', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(58, 'CE', '1234567915', 'Juan David', 'Perez Hernandez', '1234567913', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:20:45', 'FUERA'),
(59, 'CE', '1234567916', 'Juan David', 'Perez Hernandez', '1234567914', 'daniel@gmail.com', 'evento que reune a toda la comunidad', '2025-06-04 19:21:45', 'FUERA'),
(60, 'CE', '1234567917', 'Daniel', 'Ramos', '1234567915', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(61, 'CE', '1234567918', 'Daniel', 'Ramos', '1234567916', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(62, 'CE', '1234567919', 'Daniel', 'Ramos', '1234567917', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(63, 'CE', '1234567920', 'Daniel', 'Ramos', '1234567918', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(64, 'CE', '1234567921', 'Daniel', 'Ramos', '1234567919', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(65, 'CE', '1234567922', 'Daniel', 'Ramos', '1234567920', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(66, 'CE', '1234567923', 'Daniel', 'Ramos', '1234567921', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(67, 'CE', '1234567924', 'Daniel', 'Ramos', '1234567922', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(68, 'CE', '1234567925', 'Daniel', 'Ramos', '1234567923', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(69, 'CE', '1234567926', 'Daniel', 'Ramos', '1234567924', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(70, 'CE', '1234567927', 'Daniel', 'Ramos', '1234567925', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(71, 'CE', '1234567928', 'Daniel', 'Ramos', '1234567926', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:58:12', 'FUERA'),
(72, 'CE', '1234567929', 'Daniel', 'Ramos', '1234567927', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(73, 'CE', '1234567930', 'Daniel', 'Ramos', '1234567928', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(74, 'CE', '1234567931', 'Daniel', 'Ramos', '1234567929', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(75, 'CE', '1234567932', 'Daniel', 'Ramos', '1234567930', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(76, 'CE', '1234567933', 'Daniel', 'Ramos', '1234567931', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(77, 'CE', '1234567934', 'Daniel', 'Ramos', '1234567932', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(78, 'CE', '1234567935', 'Daniel', 'Ramos', '1234567933', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(79, 'CE', '1234567936', 'Daniel', 'Ramos', '1234567934', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(80, 'CE', '1234567937', 'Daniel', 'Ramos', '1234567935', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:59:12', 'FUERA'),
(81, 'CE', '1234567938', 'Daniel', 'Ramos', '1234567936', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(82, 'CE', '1234567939', 'Daniel', 'Ramos', '1234567937', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(83, 'CE', '1234567940', 'Daniel', 'Ramos', '1234567938', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(84, 'CE', '1234567941', 'Daniel', 'Ramos', '1234567939', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(85, 'CE', '1234567942', 'Daniel', 'Ramos', '1234567940', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(86, 'CE', '1234567943', 'Daniel', 'Ramos', '1234567941', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(87, 'CE', '1234567944', 'Daniel', 'Ramos', '1234567942', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(88, 'CE', '1234567945', 'Daniel', 'Ramos', '1234567943', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(89, 'CE', '1234567946', 'Daniel', 'Ramos', '1234567944', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(90, 'CE', '1234567947', 'Daniel', 'Ramos', '1234567945', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:00:13', 'FUERA'),
(91, 'CE', '1234567948', 'Daniel', 'Ramos', '1234567946', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(92, 'CE', '1234567949', 'Daniel', 'Ramos', '1234567947', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(93, 'CE', '1234567950', 'Daniel', 'Ramos', '1234567948', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(94, 'CE', '1234567951', 'Daniel', 'Ramos', '1234567949', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(95, 'CE', '1234567952', 'Daniel', 'Ramos', '1234567950', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(96, 'CE', '1234567953', 'Daniel', 'Ramos', '1234567951', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(97, 'CE', '1234567954', 'Daniel', 'Ramos', '1234567952', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(98, 'CE', '1234567955', 'Daniel', 'Ramos', '1234567953', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(99, 'CE', '1234567956', 'Daniel', 'Ramos', '1234567954', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(100, 'CE', '1234567957', 'Daniel', 'Ramos', '1234567955', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(101, 'CE', '1234567958', 'Daniel', 'Ramos', '1234567956', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:01:13', 'FUERA'),
(102, 'CE', '1234567959', 'Daniel', 'Ramos', '1234567957', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(103, 'CE', '1234567960', 'Daniel', 'Ramos', '1234567958', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(104, 'CE', '1234567961', 'Daniel', 'Ramos', '1234567959', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(105, 'CE', '1234567962', 'Daniel', 'Ramos', '1234567960', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(106, 'CE', '1234567963', 'Daniel', 'Ramos', '1234567961', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(107, 'CE', '1234567964', 'Daniel', 'Ramos', '1234567962', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(108, 'CE', '1234567965', 'Daniel', 'Ramos', '1234567963', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(109, 'CE', '1234567966', 'Daniel', 'Ramos', '1234567964', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(110, 'CE', '1234567967', 'Daniel', 'Ramos', '1234567965', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(111, 'CE', '1234567968', 'Daniel', 'Ramos', '1234567966', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(112, 'CE', '1234567969', 'Daniel', 'Ramos', '1234567967', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(113, 'CE', '1234567970', 'Daniel', 'Ramos', '1234567968', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(114, 'CE', '1234567971', 'Daniel', 'Ramos', '1234567969', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(115, 'CE', '1234567972', 'Daniel', 'Ramos', '1234567970', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(116, 'CE', '1234567973', 'Daniel', 'Ramos', '1234567971', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(117, 'CE', '1234567974', 'Daniel', 'Ramos', '1234567972', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:02:13', 'FUERA'),
(118, 'CE', '1234567975', 'Daniel', 'Ramos', '1234567973', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(119, 'CE', '1234567976', 'Daniel', 'Ramos', '1234567974', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(120, 'CE', '1234567977', 'Daniel', 'Ramos', '1234567975', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(121, 'CE', '1234567978', 'Daniel', 'Ramos', '1234567976', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(122, 'CE', '1234567979', 'Daniel', 'Ramos', '1234567977', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(123, 'CE', '1234567980', 'Daniel', 'Ramos', '1234567978', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(124, 'CE', '1234567981', 'Daniel', 'Ramos', '1234567979', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(125, 'CE', '1234567982', 'Daniel', 'Ramos', '1234567980', 'daniel@gmail.com', 'dsdsds', '2025-06-06 12:03:13', 'FUERA'),
(126, 'CE', '1234567983', 'Daniel', 'Ramos', '1234567981', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(127, 'CE', '1234567984', 'Daniel', 'Ramos', '1234567982', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(128, 'CE', '1234567985', 'Daniel', 'Ramos', '1234567983', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(129, 'CE', '1234567986', 'Daniel', 'Ramos', '1234567984', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(130, 'CE', '1234567987', 'Daniel', 'Ramos', '1234567985', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(131, 'CE', '1234567988', 'Daniel', 'Ramos', '1234567986', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(132, 'CE', '1234567989', 'Daniel', 'Ramos', '1234567987', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(133, 'CE', '1234567990', 'Daniel', 'Ramos', '1234567988', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(134, 'CE', '1234567991', 'Daniel', 'Ramos', '1234567989', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(135, 'CE', '1234567992', 'Daniel', 'Ramos', '1234567990', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(136, 'CE', '1234567993', 'Daniel', 'Ramos', '1234567991', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(137, 'CE', '1234567994', 'Daniel', 'Ramos', '1234567992', 'daniel@gmail.com', 'fdfdfdfd', '2025-06-06 13:53:54', 'FUERA'),
(138, 'CE', '1234567995', 'Daniel', 'Ramos', '1234567993', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:50:00', 'FUERA'),
(139, 'CE', '1234567996', 'Daniel', 'Ramos', '1234567994', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(140, 'CE', '1234567997', 'Daniel', 'Ramos', '1234567995', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(141, 'CE', '1234567998', 'Daniel', 'Ramos', '1234567996', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(142, 'CE', '1234567999', 'Daniel', 'Ramos', '1234567997', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(143, 'CE', '1234568000', 'Daniel', 'Ramos', '1234567998', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(144, 'CE', '1234568001', 'Daniel', 'Ramos', '1234567999', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(145, 'CE', '1234568002', 'Daniel', 'Ramos', '1234568000', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(146, 'CE', '1234568003', 'Daniel', 'Ramos', '1234568001', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:51:00', 'FUERA'),
(147, 'CE', '1234568004', 'Daniel', 'Ramos', '1234568002', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:52:00', 'FUERA'),
(148, 'CE', '1234568005', 'Daniel', 'Ramos', '1234568003', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:52:00', 'FUERA'),
(149, 'CE', '1234568006', 'Daniel', 'Ramos', '1234568004', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:52:00', 'FUERA'),
(150, 'CE', '1234568007', 'Daniel', 'Ramos', '1234568005', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:52:00', 'FUERA'),
(151, 'CE', '1234568008', 'Daniel', 'Ramos', '1234568006', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:52:00', 'FUERA'),
(152, 'CE', '1234568009', 'Daniel', 'Ramos', '1234568007', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:52:00', 'FUERA'),
(153, 'CE', '1234568010', 'Daniel', 'Ramos', '1234568008', 'daniel@gmail.com', 'gfffgfgff', '2025-06-06 14:52:00', 'FUERA'),
(154, 'CC', '34343434', 'Juan', 'Restrepo', '1234567890', 'juan@gmail.com', 'matricula', '2025-06-13 23:37:45', 'FUERA'),
(155, 'CC', '1114813619', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'matricula', '2025-06-16 11:23:18', 'FUERA'),
(156, 'CC', '1114813617', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'matricula', '2025-06-16 11:25:03', 'FUERA'),
(157, 'CC', '1114813616', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'matricula', '2025-06-16 11:26:40', 'FUERA'),
(158, 'CC', '1114813612', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-06-16 11:28:32', 'FUERA'),
(159, 'CC', '1114813613', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-06-16 11:38:08', 'FUERA'),
(160, 'CC', '1114813611', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-06-16 11:38:49', 'FUERA'),
(161, 'CE', '1234567892', 'Daniel', 'Ramos', '1234567890', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(162, 'CE', '1234567893', 'Daniel', 'Ramos', '1234567891', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(163, 'CE', '1234567894', 'Daniel', 'Ramos', '1234567892', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(164, 'CE', '1234567895', 'Daniel', 'Ramos', '1234567893', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(165, 'CE', '1234567896', 'Daniel', 'Ramos', '1234567894', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(166, 'CE', '1234567897', 'Daniel', 'Ramos', '1234567895', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(167, 'CE', '1234567898', 'Daniel', 'Ramos', '1234567896', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(168, 'CE', '1234567900', 'Daniel', 'Ramos', '1234567898', 'daniel@gmail.com', 'fggfgfgf', '2025-06-22 16:34:46', 'FUERA'),
(169, 'CC', '111481361555', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'fffddfdf', '2025-06-23 13:25:38', 'FUERA'),
(170, 'CC', '434343434443', 'Juan David', 'Restrepo Ramos', '1234567890', 'juan@gmail.com', 'Inscripcion', '2025-06-23 14:24:49', 'FUERA');

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2641;

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `motivos_ingreso`
--
ALTER TABLE `motivos_ingreso`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `novedades_usuarios`
--
ALTER TABLE `novedades_usuarios`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `vigilantes`
--
ALTER TABLE `vigilantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
