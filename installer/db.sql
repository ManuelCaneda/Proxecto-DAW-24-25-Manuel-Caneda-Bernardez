SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+02:00";

CREATE USER IF NOT EXISTS 'prohive'@'localhost' IDENTIFIED BY 'abc123.';
GRANT ALL PRIVILEGES ON *.* TO 'prohive'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;

--
-- Base de datos: `prohivedb`
--
CREATE DATABASE IF NOT EXISTS `prohivedb`;
USE `prohivedb`;

CREATE TABLE `anuncios` (
  `id_anuncio` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `imagen` text NOT NULL,
  `nombre` varchar(144) NOT NULL,
  `texto` text NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'dev'
);

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`id_anuncio`, `id_cliente`, `imagen`, `nombre`, `texto`, `precio`, `estado`) VALUES
(20, 28, 'https://fondosmil.co/fondo/69434.jpg', 'Diseñador Gráfico', 'Diseñador Gráfico barato.', 40.00, 'publicado'),
(21, 28, 'https://img.freepik.com/free-photo/social-media-marketing-concept-marketing-with-applications_23-2150063140.jpg?semt=ais_hybrid&w=740', 'Community Manager para RRSS', 'Community Manager muy profesional que puede encargarse de las redes sociales de cualquier empresa.', 900.00, 'publicado'),
(2, 14, 'https://elements-resized.envatousercontent.com/elements-video-cover-images/8efa2297-74d2-4a9c-95f3-b301d8de6d40/video_preview/video_preview_0000.jpg?w=500&cf_fit=cover&q=85&format=auto&s=45fd9d8f7372b36a7523f7c180f4f089566189429b039ef44b18302586da380f', 'Pintor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce semper sapien diam, et imperdiet nisl sagittis in. Sed ut maximus elit. Maecenas convallis ac dui non vehicula.', 800.00, 'publicado'),
(18, 14, 'https://img.freepik.com/foto-gratis/imagen-primer-plano-programador-trabajando-su-escritorio-oficina_1098-18707.jpg', 'Desarrollador Web', 'Desarrollador Web Full Stack a tu disposición para la creación de todo tipo de páginas web.', 250.00, 'publicado'),
(23, 14, 'https://wallpapers.com/images/featured/arquitecto-qjoj7tv6wnvtvumo.jpg', 'Arquitecto', 'Arquitecto cualificado para realizar cualquier tipo de construcción', 2000.00, 'publicado'),
(22, 28, 'https://afrihub.com/assets/img/pc/python.png', 'Programador de Python', 'Programador sénior especializado en Python-', 500.00, 'publicado');

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
);

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_emisor`, `id_receptor`, `fecha`, `hora`, `texto`) VALUES
(63, 13, 14, '2025-05-25', '14:22:06', 'Este mensaje es una simple prueba'),
(91, 14, 13, '2025-05-28', '13:59:15', 'jelou');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `id` int(11) NOT NULL,
  `tipo_nombre` varchar(30) NOT NULL
);

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
  `tipo_usuario` int(11) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `horario_invierno` varchar(255) DEFAULT NULL,
  `horario_verano` varchar(255) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `pass`, `tipo_usuario`, `direccion`, `horario_invierno`, `horario_verano`) VALUES
(13, 'Admin', 'Prohive', 'admin@prohive.com', 'bba2d1bec283dd3b90add09797a9235b08069064', 1, NULL, NULL, NULL),
(14, 'Cliente', 'Dos', 'cliente2@prohive.com', 'bba2d1bec283dd3b90add09797a9235b08069064', 3, 'Lg. O Pazo, 10 – Mosteiro 6637 – Meis (Pontevedra)', '8:00h – 16:00h (Lunes a Viernes)', '7:00h – 15:00h (Lunes a Viernes)'),
(26, 'John', 'Doe', 'usuario1@prohive.com', 'bba2d1bec283dd3b90add09797a9235b08069064', 2, NULL, NULL, NULL),
(27, 'Jane', 'Doe', 'usuario2@prohive.com', 'bba2d1bec283dd3b90add09797a9235b08069064', 2, NULL, NULL, NULL),
(28, 'Cliente', 'Uno', 'cliente1@prohive.com', 'bba2d1bec283dd3b90add09797a9235b08069064', 3, 'Villalonga, Sanxenxo', '09:00h – 14:00h (Lunes a Viernes)', '8:00h – 13:00h (Lunes a Viernes)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int(11) NOT NULL,
  `id_anuncio` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `puntuacion` tinyint(4) NOT NULL CHECK (`puntuacion` between 1 and 5),
  `texto` text DEFAULT NULL
);

--
-- Volcado de datos para la tabla `valoraciones`
--

INSERT INTO `valoraciones` (`id`, `id_anuncio`, `id_usuario`, `puntuacion`, `texto`) VALUES
(1, 2, 14, 1, 'Horripilante.'),
(3, 2, 12, 3, 'Decente'),
(4, 2, 12, 4, 'Bien!'),
(5, 2, 14, 5, 'Excelente anuncio!'),
(20, 18, 12, 1, 'Un servicio horrible.'),
(21, 22, 26, 4, 'Un poco caro, pero muy profesional.');

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
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;