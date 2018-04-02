-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-04-2018 a las 20:52:23
-- Versión del servidor: 5.6.30-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `wolves`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `login` varchar(100) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `referido` int(11) NOT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `nombre`, `login`, `contrasena`, `correo`, `estado`, `referido`) VALUES
(1, 'Ivan Contreras', 'ivancho', '68e18c13237884aa15c9bbc988be74ce', '', 1, 1),
(2, 'Mi Nombre', 'admin', '6add84506c86a658bc85038f91e35ce7', 'oealdana', 1, 1),
(3, 'Cliente 2', 'admin2', '6add84506c86a658bc85038f91e35ce7', 'oealdana', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE IF NOT EXISTS `paquetes` (
  `paquete_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `valor` varchar(30) NOT NULL,
  PRIMARY KEY (`paquete_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
