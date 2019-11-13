-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2019 a las 00:23:15
-- Versión del servidor: 10.3.15-MariaDB
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bici_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica_prod`
--

CREATE TABLE `caracteristica_prod` (
  `id_producto` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `imagen` varchar(50) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `precio_venta` decimal(2,0) NOT NULL,
  `precio_compra` decimal(50,0) NOT NULL,
  `stock` varchar(50) COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL,
  `Descripcion` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `avatar` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `avatar`, `password`) VALUES
(0, 'Christian', 'Campranteda', 'campranteda@gmail.com', '', '2y$10$RI1WkQ.aU6ueRft2qcSSCeF5\\/2Olt7wwHKercmOS3ShFCpECWtO92'),
(1, 'juan', 'fratta', 'juan@gmail.com', '', '$2y$10$7ssFwr0sHIQRpk8lr1KzBOMJlzhDshb2PpYsXF9rratSMXHl9Nl8q'),
(3, 'Jose', 'Abdallah', 'jose.abdallah@gmail.com', '', '$2y$10$t7xzYm\\/qTYRrEtOI09wxxueocYT0QVAssVgntdYIflCGosogo2why'),
(4, 'Juan', 'fratta', 'juan@gmail.com', '', '$2y$10$7ssFwr0sHIQRpk8lr1KzBOMJlzhDshb2PpYsXF9rratSMXHl9Nl8q'),
(5, 'optimus', 'prime', 'optimus@prime.com', '', '$2y$10$v4ipf.o6Pxf7fnrdLpKqIOLGd9pK4Z3mxxMe4qr9jNCemqlgBrwKC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
