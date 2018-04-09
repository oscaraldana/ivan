-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-04-2018 a las 00:57:32
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wolves`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `login` varchar(100) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `referido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `nombre`, `login`, `contrasena`, `correo`, `estado`, `referido`) VALUES
(1, 'Ivan Contreras', 'ivancho', '68e18c13237884aa15c9bbc988be74ce', 'correo@loquesea', 1, 1),
(2, 'Mi Nombre', 'admin', '6add84506c86a658bc85038f91e35ce7', 'oealdana', 1, 1),
(3, 'Cliente 2', 'admin2', '6add84506c86a658bc85038f91e35ce7', 'oealdana', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_cliente`
--

CREATE TABLE `cuenta_cliente` (
  `cuenta_cliente_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `cuenta` varchar(100) NOT NULL,
  `titular` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `bitcoin` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuenta_cliente`
--

INSERT INTO `cuenta_cliente` (`cuenta_cliente_id`, `cliente_id`, `banco`, `cuenta`, `titular`, `tipo`, `bitcoin`) VALUES
(1, 1, 'BANCO BBVA COLOMBIA S.A.', '555', '55', 'CORRIENTE', 'iouoiuo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `paquete_id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `rentabilidad` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `valor` varchar(30) NOT NULL,
  `retiro_minimo` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`paquete_id`, `nombre`, `rentabilidad`, `descripcion`, `valor`, `retiro_minimo`, `imagen`) VALUES
(1, 'PRINCIPIANTE', 17, 'Rentabilidad 17%', '100', 150, 'principiante.jpg'),
(2, 'INVERSIONISTA', 18, 'Rentabilidad 18%', '1000', 200, 'aprendiz.jpg'),
(3, 'TRADER', 19, 'Rentabilidad 19%', '2000', 200, 'trader.jpg'),
(4, 'MASTER - VIP', 20, 'Rentabilidad 20%', '5000', 200, 'master-vip.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes_cliente`
--

CREATE TABLE `paquetes_cliente` (
  `paquete_cliente_id` int(11) NOT NULL,
  `paquete_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `referencia_pago` varchar(200) NOT NULL,
  `tipo_pago` varchar(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int(11) NOT NULL,
  `fecha_activacion` datetime DEFAULT NULL,
  `inicia` date DEFAULT NULL,
  `finaliza` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paquetes_cliente`
--

INSERT INTO `paquetes_cliente` (`paquete_cliente_id`, `paquete_id`, `cliente_id`, `referencia_pago`, `tipo_pago`, `fecha_registro`, `estado`, `fecha_activacion`, `inicia`, `finaliza`) VALUES
(1, 3, 1, '255252', 'BITCOIN', '2018-04-03 22:21:06', 3, '2018-01-01 06:00:00', '2018-01-01', '2019-01-01'),
(2, 2, 1, '888888', 'BANCO', '2018-04-03 22:46:07', 1, '2018-01-01 06:00:00', '2018-01-06', '2019-01-01'),
(3, 1, 1, '22222', 'BITCOIN', '2018-04-03 22:20:10', 1, '2018-03-03 14:00:00', '2018-03-05', '2019-03-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retiros_cliente`
--

CREATE TABLE `retiros_cliente` (
  `retiro_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `valor_retiro` varchar(50) NOT NULL,
  `valor_comision` varchar(50) NOT NULL,
  `valor_pagado` varchar(50) NOT NULL,
  `bitcoin` varchar(100) DEFAULT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `cuenta` varchar(100) DEFAULT NULL,
  `tipo_cuenta` varchar(50) DEFAULT NULL,
  `titular` varchar(200) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_pago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `retiros_cliente`
--

INSERT INTO `retiros_cliente` (`retiro_id`, `cliente_id`, `valor_retiro`, `valor_comision`, `valor_pagado`, `bitcoin`, `banco`, `cuenta`, `tipo_cuenta`, `titular`, `estado`, `fecha_solicitud`, `fecha_pago`) VALUES
(1, 1, '774', '38.7', '735.3', '', 'BANCO BBVA COLOMBIA S.A.', '555', 'CORRIENTE', '55', 0, '2018-04-06 20:37:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retiros_paquetes`
--

CREATE TABLE `retiros_paquetes` (
  `retiro_paquete_id` int(11) NOT NULL,
  `retiro_cliente_id` int(11) NOT NULL,
  `paquete_cliente_id` int(11) NOT NULL,
  `valor_retiro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `retiros_paquetes`
--

INSERT INTO `retiros_paquetes` (`retiro_paquete_id`, `retiro_cliente_id`, `paquete_cliente_id`, `valor_retiro`) VALUES
(1, 1, 2, '774');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `cuenta_cliente`
--
ALTER TABLE `cuenta_cliente`
  ADD PRIMARY KEY (`cuenta_cliente_id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`paquete_id`);

--
-- Indices de la tabla `paquetes_cliente`
--
ALTER TABLE `paquetes_cliente`
  ADD PRIMARY KEY (`paquete_cliente_id`);

--
-- Indices de la tabla `retiros_cliente`
--
ALTER TABLE `retiros_cliente`
  ADD PRIMARY KEY (`retiro_id`);

--
-- Indices de la tabla `retiros_paquetes`
--
ALTER TABLE `retiros_paquetes`
  ADD PRIMARY KEY (`retiro_paquete_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cuenta_cliente`
--
ALTER TABLE `cuenta_cliente`
  MODIFY `cuenta_cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `paquete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `paquetes_cliente`
--
ALTER TABLE `paquetes_cliente`
  MODIFY `paquete_cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `retiros_cliente`
--
ALTER TABLE `retiros_cliente`
  MODIFY `retiro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `retiros_paquetes`
--
ALTER TABLE `retiros_paquetes`
  MODIFY `retiro_paquete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
