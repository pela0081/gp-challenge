-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: database:3306
-- Tiempo de generación: 06-02-2023 a las 23:03:54
-- Versión del servidor: 8.0.32
-- Versión de PHP: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tenis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `habilidad` tinyint(1) NOT NULL,
  `fuerza` tinyint UNSIGNED NOT NULL,
  `velocidad` tinyint UNSIGNED NOT NULL,
  `reaccion` tinyint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `nombre`, `tipo`, `habilidad`, `fuerza`, `velocidad`, `reaccion`) VALUES
(1, 'Roger Federer', 0, 98, 87, 94, 96),
(2, 'Rafael Nadal', 0, 93, 94, 91, 96),
(3, 'Pete Sampras', 0, 90, 87, 94, 96),
(4, 'David Nalbandian', 0, 96, 88, 79, 89),
(5, 'Diego Schwartzman', 0, 88, 78, 96, 96),
(6, 'Novak Djokovic', 0, 90, 96, 92, 94),
(7, 'Andy Murray', 0, 84, 87, 94, 96),
(8, 'Juan Martin Del Potro', 0, 85, 99, 86, 84),
(9, 'Gabriela Sabatini', 0, 0, 0, 0, 0),
(10, 'Monica Seles', 0, 0, 0, 0, 0),
(11, 'Martina Navratilova', 0, 0, 0, 0, 0),
(12, 'Steffi Graf', 1, 80, 80, 80, 80),
(13, 'Serena Williams', 1, 80, 80, 80, 80),
(14, 'Virginia Wade', 1, 80, 80, 80, 80),
(15, 'Venus Williams', 1, 80, 80, 80, 80),
(16, 'Arantxa Sánchez Vicario', 1, 80, 80, 80, 80),
(17, 'Lindsay Davenport', 1, 80, 80, 80, 80),
(18, 'Conchita Martinez', 1, 80, 80, 80, 80),
(19, 'Guillermo Vilas', 0, 80, 80, 80, 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id` int UNSIGNED NOT NULL,
  `torneo_id` int UNSIGNED NOT NULL,
  `jugador1_id` int UNSIGNED NOT NULL,
  `jugador2_id` int UNSIGNED NOT NULL,
  `ganador_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `torneo_id`, `jugador1_id`, `jugador2_id`, `ganador_id`) VALUES
(1, 2, 4, 5, 5),
(2, 2, 2, 1, 2),
(3, 2, 3, 7, 3),
(4, 2, 6, 8, 8),
(5, 2, 5, 3, 5),
(6, 2, 8, 2, 2),
(7, 2, 5, 2, 2),
(8, 3, 6, 5, 6),
(9, 3, 1, 7, 7),
(10, 3, 2, 3, 3),
(11, 3, 8, 4, 4),
(12, 3, 6, 3, 3),
(13, 3, 4, 7, 7),
(14, 3, 7, 3, 3),
(15, 4, 8, 6, 6),
(16, 4, 5, 7, 5),
(17, 4, 1, 4, 1),
(18, 4, 3, 2, 2),
(19, 4, 2, 1, 1),
(20, 4, 6, 5, 6),
(21, 4, 6, 1, 6),
(22, 1, 6, 5, 6),
(23, 1, 3, 4, 3),
(24, 1, 7, 1, 1),
(25, 1, 8, 2, 8),
(26, 1, 3, 6, 6),
(27, 1, 8, 1, 1),
(28, 1, 1, 6, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE `torneos` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` tinyint UNSIGNED NOT NULL,
  `ganador_id` int UNSIGNED DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `torneos`
--

INSERT INTO `torneos` (`id`, `nombre`, `tipo`, `ganador_id`, `fecha_creacion`, `fecha_fin`) VALUES
(1, 'Grand Slam', 0, 6, '2023-02-06 23:01:09', '2023-02-06 23:01:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;