-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 12-05-2025 a las 18:34:55
-- Versión del servidor: 11.7.2-MariaDB-ubu2404
-- Versión de PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prohivedb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `id_anuncio` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `imagen` text NOT NULL,
  `nombre` varchar(144) NOT NULL,
  `texto` text NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'dev'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`id_anuncio`, `id_cliente`, `imagen`, `nombre`, `texto`, `precio`, `estado`) VALUES
(1, 14, 'https://www.aislamos.com/wp-content/uploads/2024/08/facebook.jpg', 'Aislamientos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce semper sapien diam, et imperdiet nisl sagittis in. Sed ut maximus elit. Maecenas convallis ac dui non vehicula.', 200.00, 'dev'),
(2, 14, 'https://www.aislamos.com/wp-content/uploads/2024/08/facebook.jpg', 'Aislamientos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce semper sapien diam, et imperdiet nisl sagittis in. Sed ut maximus elit. Maecenas convallis ac dui non vehicula.', 200.00, 'dev');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `texto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_emisor`, `id_receptor`, `fecha`, `hora`, `texto`) VALUES
(1, 13, 12, '2025-05-07', '22:59:47', 'Se ha detectado un uso fraudulento de ProHive, se procederá a la eliminación de su cuenta.'),
(2, 12, 13, '2025-05-07', '22:59:47', 'Se ha detectado un uso fraudulento de ProHive, se procederá a la eliminación de su cuenta.'),
(3, 12, 14, '2025-05-08', '21:23:47', 'Estoy interesado en vuestros servicios'),
(20, 13, 12, '2025-05-08', '23:27:12', 'hola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `id` int(11) NOT NULL,
  `tipo_nombre` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`id`, `tipo_nombre`) VALUES
(1, 'admin'),
(2, 'comun'),
(3, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `pass`, `tipo_usuario`) VALUES
(12, 'Manuel', 'Caneda Bernárdez', 'manuelcanedab@gmail.com', '25b99bacd5f00970e7f5003b4463b2456c22f73c', 2),
(13, 'Admin', 'Prohive', 'admin@prohive.com', 'bba2d1bec283dd3b90add09797a9235b08069064', 1),
(14, 'Aislamientos', 'Aislamos', 'aislamos@aislamos.com', 'bba2d1bec283dd3b90add09797a9235b08069064', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id_anuncio`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_emisor` (`id_emisor`),
  ADD KEY `id_receptor` (`id_receptor`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `tipo_usuario` (`tipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
