-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-07-2017 a las 13:59:42
-- Versión del servidor: 5.6.36-log
-- Versión de PHP: 5.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `c0740032_algo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE IF NOT EXISTS `candidatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `idCargo` int(11) NOT NULL COMMENT 'tipo y nro de dni',
  PRIMARY KEY (`id`),
  KEY `idCargo` (`idCargo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Truncar tablas antes de insertar `candidatos`
--

TRUNCATE TABLE `candidatos`;
--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`id`, `nombre`, `apellido`, `idCargo`) VALUES
(1, 'Daniel', 'Peralta', 2),
(2, 'Osvaldo "Colo" ', 'Perez', 3),
(3, 'Eduardo', 'Costa', 2),
(4, 'Ana Maria', 'Ianni', 2),
(5, 'Julio ', 'Gutiérrez', 2),
(6, 'Carlos ', 'Prades', 2),
(7, 'Jose', 'Blassiotto', 2),
(8, 'Emilio ', 'Poliak', 2),
(9, 'Miguel', 'Del Plá', 2),
(10, 'Juan', ' Vázquez', 3),
(11, 'Claudio ', 'Silva', 3),
(12, 'Roxana ', 'Reyes', 3),
(13, 'Pablo "Pato"', 'Fadul', 3),
(14, 'Sandro ', 'Levín', 3),
(15, 'Olga', 'Reinoso', 3),
(16, 'Gustavo', ' Nauto', 3),
(17, 'Omar', 'Latini', 3),
(19, 'Sandro ', 'Levín', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatosEnLista`
--

CREATE TABLE IF NOT EXISTS `candidatosEnLista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCandidato` int(11) NOT NULL,
  `idLista` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idCandidato` (`idCandidato`,`idLista`),
  KEY `idLista` (`idLista`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Truncar tablas antes de insertar `candidatosEnLista`
--

TRUNCATE TABLE `candidatosEnLista`;
--
-- Volcado de datos para la tabla `candidatosEnLista`
--

INSERT INTO `candidatosEnLista` (`id`, `idCandidato`, `idLista`) VALUES
(1, 1, 12),
(2, 2, 12),
(3, 3, 17),
(20, 3, 18),
(4, 4, 14),
(5, 5, 15),
(6, 6, 16),
(7, 7, 13),
(8, 8, 20),
(9, 9, 19),
(10, 10, 14),
(11, 11, 15),
(12, 12, 17),
(13, 13, 16),
(14, 14, 18),
(15, 15, 13),
(16, 16, 20),
(17, 17, 19),
(19, 19, 18);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `CandidatosPorPartido`
--
CREATE TABLE IF NOT EXISTS `CandidatosPorPartido` (
`idPartido` int(11)
,`idLista` int(11)
,`id` int(11)
,`nombre` varchar(40)
,`apellido` varchar(40)
,`idCargo` int(11)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Truncar tablas antes de insertar `cargos`
--

TRUNCATE TABLE `cargos`;
--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `nombre`, `activo`) VALUES
(1, 'Presidente de la Nacion', 1),
(2, 'Senador Nacional', 0),
(3, 'Diputado Nacional', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE IF NOT EXISTS `ciudad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `habitantes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Truncar tablas antes de insertar `ciudad`
--

TRUNCATE TABLE `ciudad`;
--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id`, `nombre`, `habitantes`) VALUES
(1, '28 de Noviembre', 6643),
(2, 'Bajo Caracoles', 0),
(3, 'Caleta Olivia', 66904),
(4, 'Cañadón Seco', 0),
(5, 'Com. L. Piedra Buena', 0),
(6, 'El Calafate', 23565),
(7, 'El Chaltén', 0),
(8, 'Gobernador Gregores', 8920),
(9, 'Gobernador Moyano', 0),
(10, 'Jaramillo', 0),
(11, 'Koluel Kaike', 0),
(12, 'La Esperanza', 0),
(13, 'Lago Posadas', 0),
(14, 'Las Heras', 21995),
(15, 'Los Antiguos', 0),
(16, 'Perito Moreno', 0),
(17, 'Pico Truncado', 23205),
(18, 'Pto. Deseado', 13921),
(19, 'Pto. San Julián', 9863),
(20, 'Pto. Santa Cruz', 0),
(21, 'Río Gallegos', 106920),
(22, 'Río Turbio', 6279),
(23, 'Tamel Aike', 0),
(24, 'Tres Lagos', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Truncar tablas antes de insertar `departamentos`
--

TRUNCATE TABLE `departamentos`;
--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`) VALUES
(1, 'Lago Buenos Aires'),
(2, 'Corpen Aike'),
(3, 'Deseado'),
(4, 'Lago Argentino'),
(5, 'Magallanes'),
(6, 'Rio Chico'),
(7, 'Güer Aike');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Distrito`
--

CREATE TABLE IF NOT EXISTS `Distrito` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `habitantes` int(11) DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncar tablas antes de insertar `Distrito`
--

TRUNCATE TABLE `Distrito`;
--
-- Volcado de datos para la tabla `Distrito`
--

INSERT INTO `Distrito` (`id`, `nombre`, `habitantes`) VALUES
(1, 'Buenos Aires', 0),
(2, 'Ciudad Autónoma de Buenos Aire', 0),
(3, 'Catamarca', 0),
(4, 'Córdoba', 0),
(5, 'Corrientes', 0),
(6, 'Chaco', 0),
(7, 'Chubut', 0),
(8, 'Entre Ríos', 0),
(9, 'Formosa', 0),
(10, 'Jujuy', 0),
(11, 'La Pampa', 0),
(12, 'La Rioja', 0),
(13, 'Mendoza', 0),
(14, 'Misiones', 0),
(15, 'Neuquén', 0),
(16, 'Río Negro', 0),
(17, 'Salta', 0),
(18, 'San Juan', 0),
(19, 'San Luis', 0),
(20, 'Santa Cruz', 246090),
(21, 'Santa Fé', 0),
(22, 'Santiago del Estero', 0),
(23, 'Tierra del Fuego ', 0),
(24, 'Tucumán', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eleciones`
--

CREATE TABLE IF NOT EXISTS `Eleciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Truncar tablas antes de insertar `Eleciones`
--

TRUNCATE TABLE `Eleciones`;
--
-- Volcado de datos para la tabla `Eleciones`
--

INSERT INTO `Eleciones` (`id`, `descripcion`) VALUES
(1, 'SENADORES Y DIPUTADOS 2017');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `EnLista`
--
CREATE TABLE IF NOT EXISTS `EnLista` (
`id` int(11)
,`idPart` int(11)
,`NroPartido` int(11)
,`AgrupacionPolitica` text
,`NroLista` int(5)
,`nombre` varchar(50)
,`Senador` bigint(1)
,`diputado` bigint(1)
,`SenadorCandiato` bigint(11)
,`DiputadoCandiato` bigint(11)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas`
--

CREATE TABLE IF NOT EXISTS `listas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NroLista` int(5) NOT NULL,
  `idPartido` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `idPartido` (`idPartido`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Truncar tablas antes de insertar `listas`
--

TRUNCATE TABLE `listas`;
--
-- Volcado de datos para la tabla `listas`
--

INSERT INTO `listas` (`id`, `NroLista`, `idPartido`, `nombre`) VALUES
(12, 83, 10, 'MEJOR ES HACER'),
(13, 176, 13, '1PROVINCIA'),
(14, 502, 1, 'UNIDOS POR SANTA CRUZ'),
(15, 1, 1, 'SOMOS SANTA CRUZ'),
(16, 503, 2, 'INTEGRACION CIUDADANA'),
(17, 12, 2, 'JUNTOS POR UN CAMBIO'),
(18, 503, 2, 'EL CAMINO DEL CAMBIO'),
(19, 504, 11, 'PARTIDO OBRERO'),
(20, 501, 7, 'IZQUIERDA AL FRENTE POR EL SOCIALISMO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE IF NOT EXISTS `mesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `tiempo` time NOT NULL,
  `idElecion` int(11) NOT NULL DEFAULT '1',
  `TotalVontantes` int(11) DEFAULT NULL,
  `Votantes` int(11) DEFAULT NULL,
  `idDistrito` int(11) DEFAULT '20' COMMENT 'provincia',
  `idseccion` int(11) NOT NULL,
  `idCircuito` int(11) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `VotosBlancos` int(11) DEFAULT NULL,
  `VotosNulos` int(11) DEFAULT NULL,
  `VotosRecurridos` int(11) DEFAULT NULL,
  `VotosInpugnados` int(11) DEFAULT NULL,
  `enEdicion` varchar(1) DEFAULT 'N' COMMENT 'No, Si, Cargada',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `idprovincia` (`idDistrito`,`idseccion`,`idCircuito`,`idMesa`),
  KEY `idseccion` (`idseccion`),
  KEY `idCircuito` (`idCircuito`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

--
-- Truncar tablas antes de insertar `mesa`
--

TRUNCATE TABLE `mesa`;
--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id`, `fecha`, `tiempo`, `idElecion`, `TotalVontantes`, `Votantes`, `idDistrito`, `idseccion`, `idCircuito`, `idMesa`, `VotosBlancos`, `VotosNulos`, `VotosRecurridos`, `VotosInpugnados`, `enEdicion`) VALUES
(1, '2017-07-06', '17:07:58', 1, 14, 8, 20, 7, 21, 21, 5, 5, 5, 5, 'N'),
(33, '2017-07-10', '02:07:58', 1, 0, 0, 20, 7, 21, 32, 0, 0, 0, 0, ''),
(35, '2017-07-08', '02:07:21', 1, 0, 0, 20, 7, 21, 29, 0, 0, 0, 0, ''),
(37, '2017-07-10', '02:07:14', 1, 0, 0, 20, 7, 21, 121, 0, 0, 0, 0, ''),
(39, '2017-07-10', '02:07:10', 1, 0, 0, 20, 7, 21, 31, 0, 0, 0, 0, ''),
(48, '2017-07-10', '01:07:04', 1, 0, 0, 20, 7, 21, 132, 0, 0, 0, 0, ''),
(50, '2017-07-10', '18:07:03', 1, 1500, 1296, 20, 7, 21, 344, 50, 0, 450, 0, 'S'),
(51, '2017-07-08', '12:07:15', 1, 100, 200, 20, 7, 21, 300, 30, 0, 0, 0, 'S'),
(52, '2017-07-10', '01:07:44', 1, 500, 0, 20, 7, 21, 256, 0, 0, 0, 0, ''),
(53, '2017-07-08', '14:07:40', 1, 0, 0, 20, 7, 21, 30, 0, 0, 0, 0, ''),
(60, '2017-07-08', '21:07:27', 1, 200, 50, 20, 7, 21, 200, 0, 0, 0, 0, 'S'),
(62, '2017-07-10', '01:07:49', 1, 320, 320, 20, 7, 21, 1, 5, 5, 5, 5, ''),
(70, '2017-07-08', '15:07:46', 1, 320, 210, 20, 7, 21, 12, 12, 12, 12, 12, 'S'),
(71, '2017-07-08', '15:07:48', 1, 160, 95, 20, 7, 21, 122, 2, 0, 1, 1, 'S'),
(74, '2017-07-08', '19:07:58', 1, 150, 85, 20, 7, 21, 23, 3, 5, 2, 1, 'S'),
(83, '2017-07-10', '01:07:02', 1, 150, 150, 20, 7, 21, 2, 45, 45, 45, 45, ''),
(90, '2017-07-09', '19:07:12', 1, 23, 11, 20, 7, 21, 6, 2, 3, 1, 5, 'S'),
(102, '2017-07-10', '15:07:44', 1, 1600, 520, 20, 7, 21, 3, 16, 4, 23, 1, 'S'),
(106, '2017-07-10', '16:07:25', 1, 106, 106, 20, 7, 21, 4, 15, 15, 15, 15, 'S'),
(108, '2017-07-10', '17:07:45', 1, 160, 160, 20, 7, 21, 5, 16, 16, 16, 16, 'S'),
(111, '2017-07-10', '17:07:06', 1, 120, 98, 20, 7, 21, 7, 47, 43, 45, 2, 'S'),
(112, '2017-07-10', '18:07:15', 1, 2500, 2300, 20, 7, 21, 8, 56, 23, 2, 1, 'S'),
(113, '2017-07-10', '16:07:51', 1, NULL, NULL, 20, 7, 21, 9, NULL, NULL, NULL, NULL, 'S'),
(114, '2017-07-10', '16:07:42', 1, NULL, NULL, 20, 7, 21, 10, NULL, NULL, NULL, NULL, 'S'),
(115, '2017-07-10', '17:07:43', 1, 26, 26, 20, 7, 21, 11, 21, 2, 2, 2, 'S'),
(119, '2017-07-10', '17:07:25', 1, 12, 12, 20, 7, 21, 13, 15, 15, 15, 15, 'S'),
(121, '2017-07-10', '17:07:06', 1, 180, 26, 20, 7, 21, 14, 5, 5, 5, 16, 'S'),
(122, '2017-07-10', '18:07:32', 1, 15, 15, 20, 7, 21, 15, 15, 15, 15, 15, 'S'),
(123, '2017-07-10', '18:07:00', 1, 160, 8, 20, 7, 21, 16, 82, 2, 2, 2, 'S'),
(124, '2017-07-10', '17:07:14', 1, 26, 26, 20, 7, 21, 17, 26, 17, 17, 17, 'S'),
(125, '2017-07-10', '18:07:06', 1, 18, 18, 20, 7, 21, 18, 18, 18, 18, 18, 'S'),
(126, '2017-07-10', '18:07:06', 1, 5, 5, 20, 7, 21, 19, 5, 5, 0, 5, 'S'),
(127, '2017-07-10', '18:07:47', 1, 20, 20, 20, 7, 21, 20, 20, 20, 20, 20, 'S'),
(129, '2017-07-10', '17:07:08', 1, 150, 16, 20, 7, 21, 22, 8, 8, 8, 8, 'S'),
(131, '2017-07-10', '17:07:57', 1, 172, 36, 20, 7, 21, 24, 46, 5, 2, 1, 'S'),
(134, '2017-07-10', '18:07:15', 1, 25, 25, 20, 7, 21, 25, 25, 25, 25, 25, 'S'),
(135, '2017-07-10', '18:07:59', 1, 587, 425, 20, 7, 21, 165, 5, 2, 1, 0, 'S'),
(136, '2017-07-12', '00:07:17', 1, 2343, 2343, 20, 7, 21, 324, 3, 4, 5, 6, 'S'),
(137, '2017-07-12', '01:07:49', 1, 460, 250, 20, 7, 22, 1, 25, 16, 1, 1, 'S'),
(166, '2017-07-13', '01:07:27', 1, NULL, NULL, 20, 7, 21, 154, NULL, NULL, NULL, NULL, 'S'),
(167, '2017-07-13', '01:07:26', 1, 200, 30, 20, 7, 21, 34, 0, 0, 0, 0, 'S'),
(171, '2017-07-13', '02:07:56', 1, NULL, NULL, 20, 7, 21, 89, NULL, NULL, NULL, NULL, 'S'),
(173, '2017-07-13', '02:07:09', 1, 0, 0, 20, 7, 21, 90, 0, 0, 0, 0, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesadetalle`
--

CREATE TABLE IF NOT EXISTS `mesadetalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMesa` int(11) NOT NULL,
  `idlista` int(11) NOT NULL,
  `idCargo` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `idUnico` (`idMesa`,`idlista`,`idCargo`),
  KEY `idMesa` (`idMesa`),
  KEY `idLista` (`idlista`),
  KEY `idCargo` (`idCargo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1698 ;

--
-- Truncar tablas antes de insertar `mesadetalle`
--

TRUNCATE TABLE `mesadetalle`;
--
-- Volcado de datos para la tabla `mesadetalle`
--

INSERT INTO `mesadetalle` (`id`, `idMesa`, `idlista`, `idCargo`, `cantidad`) VALUES
(60, 33, 15, 2, 26),
(68, 33, 20, 3, 5),
(69, 33, 19, 3, 1),
(70, 33, 18, 3, 7),
(71, 33, 17, 3, 8),
(72, 33, 16, 3, 8),
(73, 33, 15, 3, 3),
(74, 33, 14, 3, 1),
(75, 33, 13, 3, 12),
(76, 33, 12, 3, 12),
(77, 33, 20, 2, 15),
(78, 33, 19, 2, 15),
(79, 33, 17, 2, 25),
(80, 33, 16, 2, 23),
(82, 33, 14, 2, 45),
(83, 33, 13, 2, 32),
(84, 33, 12, 2, 78),
(524, 35, 20, 2, 30),
(525, 35, 19, 2, 40),
(526, 35, 17, 2, 56),
(527, 35, 16, 2, 30),
(528, 35, 15, 2, 88),
(529, 35, 14, 2, 45),
(530, 35, 13, 2, 99),
(531, 35, 12, 2, 23),
(532, 35, 20, 3, 10),
(533, 35, 19, 3, 50),
(534, 35, 18, 3, 100),
(535, 35, 17, 3, 100),
(536, 35, 16, 3, 99),
(537, 35, 15, 3, 77),
(538, 35, 14, 3, 66),
(539, 35, 13, 3, 88),
(540, 35, 12, 3, 30),
(558, 37, 20, 2, 0),
(559, 37, 19, 2, 0),
(560, 37, 17, 2, 0),
(561, 37, 16, 2, 0),
(562, 37, 15, 2, 0),
(563, 37, 14, 2, 0),
(564, 37, 13, 2, 0),
(565, 37, 12, 2, 135),
(566, 37, 20, 3, 0),
(567, 37, 19, 3, 0),
(568, 37, 18, 3, 0),
(569, 37, 17, 3, 0),
(570, 37, 16, 3, 0),
(571, 37, 15, 3, 0),
(572, 37, 14, 3, 0),
(573, 37, 13, 3, 0),
(574, 37, 12, 3, 135),
(592, 1, 20, 2, 3),
(593, 1, 19, 2, 3),
(594, 1, 17, 2, 3),
(595, 1, 16, 2, 3),
(596, 1, 15, 2, 3),
(597, 1, 14, 2, 3),
(598, 1, 13, 2, 3),
(599, 1, 12, 2, 3),
(600, 1, 20, 3, 3),
(601, 1, 19, 3, 3),
(602, 1, 18, 3, 3),
(603, 1, 17, 3, 3),
(604, 1, 16, 3, 3),
(605, 1, 15, 3, 3),
(606, 1, 14, 3, 3),
(607, 1, 13, 3, 3),
(608, 1, 12, 3, 3),
(609, 48, 20, 2, 12),
(610, 48, 19, 2, 12),
(611, 48, 17, 2, 12),
(612, 48, 16, 2, 12),
(613, 48, 15, 2, 12),
(614, 48, 14, 2, 12),
(615, 48, 13, 2, 12),
(616, 48, 12, 2, 12),
(617, 48, 20, 3, 12),
(618, 48, 19, 3, 12),
(619, 48, 18, 3, 12),
(620, 48, 17, 3, 12),
(621, 48, 16, 3, 12),
(622, 48, 15, 3, 12),
(623, 48, 14, 3, 12),
(624, 48, 13, 3, 12),
(625, 48, 12, 3, 12),
(643, 39, 20, 2, 15),
(644, 39, 19, 2, 15),
(645, 39, 17, 2, 15),
(646, 39, 16, 2, 15),
(647, 39, 15, 2, 15),
(648, 39, 14, 2, 15),
(649, 39, 13, 2, 15),
(650, 39, 12, 2, 15),
(651, 39, 20, 3, 15),
(652, 39, 19, 3, 15),
(653, 39, 18, 3, 15),
(654, 39, 17, 3, 15),
(655, 39, 16, 3, 15),
(656, 39, 15, 3, 15),
(657, 39, 14, 3, 15),
(658, 39, 13, 3, 15),
(659, 39, 12, 3, 15),
(660, 50, 20, 2, 40),
(661, 50, 19, 2, 50),
(662, 50, 17, 2, 50),
(663, 50, 16, 2, 30),
(664, 50, 15, 2, 0),
(665, 50, 14, 2, 0),
(666, 50, 13, 2, 0),
(667, 50, 12, 2, 0),
(668, 50, 20, 3, 50),
(669, 50, 19, 3, 50),
(670, 50, 18, 3, 50),
(671, 50, 17, 3, 0),
(672, 50, 16, 3, 20),
(673, 50, 15, 3, 10),
(674, 50, 14, 3, 0),
(675, 50, 13, 3, 0),
(676, 50, 12, 3, 0),
(677, 51, 20, 2, 10),
(678, 51, 19, 2, 0),
(679, 51, 17, 2, 30),
(680, 51, 16, 2, NULL),
(681, 51, 15, 2, NULL),
(682, 51, 14, 2, NULL),
(683, 51, 13, 2, NULL),
(684, 51, 12, 2, NULL),
(685, 51, 20, 3, 1),
(686, 51, 19, 3, 20),
(687, 51, 18, 3, 30),
(688, 51, 17, 3, 30),
(689, 51, 16, 3, NULL),
(690, 51, 15, 3, NULL),
(691, 51, 14, 3, NULL),
(692, 51, 13, 3, NULL),
(693, 51, 12, 3, NULL),
(694, 52, 20, 2, 100),
(695, 52, 19, 2, 130),
(696, 52, 17, 2, 159),
(697, 52, 16, 2, 52),
(698, 52, 15, 2, 86),
(699, 52, 14, 2, 24),
(700, 52, 13, 2, 1),
(701, 52, 12, 2, 300),
(702, 52, 20, 3, 66),
(703, 52, 19, 3, 80),
(704, 52, 18, 3, 169),
(705, 52, 17, 3, 200),
(706, 52, 16, 3, 86),
(707, 52, 15, 3, 100),
(708, 52, 14, 3, 76),
(709, 52, 13, 3, 0),
(710, 52, 12, 3, 450),
(728, 53, 20, 2, 15),
(729, 53, 19, 2, 15),
(730, 53, 17, 2, 15),
(731, 53, 16, 2, 15),
(732, 53, 15, 2, 15),
(733, 53, 14, 2, 15),
(734, 53, 13, 2, 15),
(735, 53, 12, 2, 15),
(736, 53, 20, 3, 15),
(737, 53, 19, 3, 15),
(738, 53, 18, 3, 15),
(739, 53, 17, 3, 15),
(740, 53, 16, 3, 15),
(741, 53, 15, 3, 15),
(742, 53, 14, 3, 15),
(743, 53, 13, 3, 16),
(744, 53, 12, 3, 15),
(762, 70, 20, 2, 50),
(763, 70, 19, 2, 50),
(764, 70, 17, 2, 50),
(765, 70, 16, 2, 50),
(766, 70, 15, 2, 50),
(767, 70, 14, 2, 50),
(768, 70, 13, 2, 50),
(769, 70, 12, 2, 50),
(770, 70, 20, 3, 50),
(771, 70, 19, 3, 50),
(772, 70, 18, 3, 50),
(773, 70, 17, 3, 50),
(774, 70, 16, 3, 50),
(775, 70, 15, 3, 50),
(776, 70, 14, 3, 50),
(777, 70, 13, 3, 50),
(778, 70, 12, 3, 5),
(796, 71, 20, 2, 25),
(797, 71, 19, 2, 15),
(798, 71, 17, 2, 16),
(799, 71, 16, 2, 38),
(800, 71, 15, 2, 21),
(801, 71, 14, 2, 32),
(802, 71, 13, 2, 18),
(803, 71, 12, 2, 78),
(804, 71, 20, 3, 12),
(805, 71, 19, 3, 15),
(806, 71, 18, 3, 13),
(807, 71, 17, 3, 13),
(808, 71, 16, 3, 46),
(809, 71, 15, 3, 16),
(810, 71, 14, 3, 12),
(811, 71, 13, 3, 23),
(812, 71, 12, 3, 16),
(830, 74, 20, 2, 12),
(831, 74, 19, 2, 5),
(832, 74, 17, 2, 6),
(833, 74, 16, 2, 52),
(834, 74, 15, 2, 11),
(835, 74, 14, 2, 15),
(836, 74, 13, 2, 15),
(837, 74, 12, 2, 15),
(838, 74, 20, 3, 11),
(839, 74, 19, 3, 23),
(840, 74, 18, 3, 13),
(841, 74, 17, 3, 12),
(842, 74, 16, 3, 21),
(843, 74, 15, 3, 23),
(844, 74, 14, 3, 15),
(845, 74, 13, 3, 15),
(846, 74, 12, 3, 15),
(864, 60, 20, 2, 0),
(865, 60, 19, 2, 0),
(866, 60, 17, 2, 0),
(867, 60, 16, 2, 0),
(868, 60, 15, 2, 0),
(869, 60, 14, 2, 0),
(870, 60, 13, 2, 0),
(871, 60, 12, 2, 0),
(872, 60, 20, 3, 0),
(873, 60, 19, 3, 0),
(874, 60, 18, 3, 0),
(875, 60, 17, 3, 0),
(876, 60, 16, 3, 0),
(877, 60, 15, 3, 0),
(878, 60, 14, 3, 0),
(879, 60, 13, 3, 0),
(880, 60, 12, 3, 0),
(898, 83, 20, 2, 12),
(899, 83, 19, 2, 0),
(900, 83, 17, 2, 16),
(901, 83, 16, 2, 0),
(902, 83, 15, 2, 12),
(903, 83, 14, 2, 12),
(904, 83, 13, 2, 0),
(905, 83, 12, 2, 0),
(906, 83, 20, 3, 15),
(907, 83, 19, 3, 0),
(908, 83, 18, 3, 15),
(909, 83, 17, 3, 12),
(910, 83, 16, 3, 0),
(911, 83, 15, 3, 12),
(912, 83, 14, 3, 12),
(913, 83, 13, 3, 0),
(914, 83, 12, 3, 0),
(932, 89, 20, 2, 2),
(933, 89, 19, 2, 2),
(934, 89, 17, 2, 2),
(935, 89, 16, 2, 2),
(936, 89, 15, 2, 2),
(937, 89, 14, 2, 2),
(938, 89, 13, 2, 2),
(939, 89, 12, 2, 2),
(940, 89, 20, 3, 2),
(941, 89, 19, 3, 2),
(942, 89, 17, 3, 2),
(943, 89, 16, 3, 2),
(944, 89, 15, 3, 2),
(945, 89, 14, 3, 2),
(946, 89, 13, 3, 2),
(947, 89, 12, 3, 2),
(964, 90, 20, 2, 15),
(965, 90, 19, 2, 68),
(966, 90, 17, 2, 68),
(967, 90, 16, 2, 68),
(968, 90, 15, 2, 68),
(969, 90, 14, 2, 6),
(970, 90, 13, 2, 6),
(971, 90, 12, 2, 68),
(972, 90, 20, 3, 32),
(973, 90, 19, 3, 68),
(974, 90, 18, 3, 68),
(975, 90, 17, 3, 68),
(976, 90, 16, 3, 68),
(977, 90, 15, 3, 68),
(978, 90, 14, 3, 6),
(979, 90, 13, 3, 6),
(980, 90, 12, 3, 68),
(998, 62, 20, 2, 5),
(999, 62, 19, 2, 5),
(1000, 62, 17, 2, 8),
(1001, 62, 16, 2, 8),
(1002, 62, 15, 2, 8),
(1003, 62, 14, 2, 8),
(1004, 62, 13, 2, 8),
(1005, 62, 12, 2, 6),
(1006, 62, 20, 3, 5),
(1007, 62, 19, 3, 5),
(1008, 62, 18, 3, 5),
(1009, 62, 17, 3, 8),
(1010, 62, 16, 3, 8),
(1011, 62, 15, 3, 12),
(1012, 62, 14, 3, 8),
(1013, 62, 13, 3, 8),
(1014, 62, 12, 3, 8),
(1151, 102, 20, 2, 15),
(1152, 102, 19, 2, 21),
(1153, 102, 17, 2, 15),
(1154, 102, 16, 2, 2),
(1155, 102, 15, 2, 4),
(1156, 102, 14, 2, 0),
(1157, 102, 13, 2, 0),
(1158, 102, 12, 2, 2),
(1159, 102, 20, 3, 18),
(1160, 102, 19, 3, 15),
(1161, 102, 18, 3, 2),
(1162, 102, 17, 3, 1),
(1163, 102, 16, 3, 0),
(1164, 102, 15, 3, 1),
(1165, 102, 14, 3, 12),
(1166, 102, 13, 3, 1),
(1167, 102, 12, 3, 1),
(1185, 119, 20, 2, 15),
(1186, 119, 19, 2, 15),
(1187, 119, 17, 2, 15),
(1188, 119, 16, 2, 15),
(1189, 119, 15, 2, 15),
(1190, 119, 14, 2, 15),
(1191, 119, 13, 2, 15),
(1192, 119, 12, 2, 15),
(1193, 119, 20, 3, 15),
(1194, 119, 19, 3, 15),
(1195, 119, 18, 3, 15),
(1196, 119, 17, 3, 15),
(1197, 119, 16, 3, 15),
(1198, 119, 15, 3, 15),
(1199, 119, 14, 3, 15),
(1200, 119, 13, 3, 15),
(1201, 119, 12, 3, 15),
(1236, 106, 20, 2, 16),
(1237, 106, 19, 2, 16),
(1238, 106, 17, 2, 16),
(1239, 106, 16, 2, 16),
(1240, 106, 15, 2, 16),
(1241, 106, 14, 2, 16),
(1242, 106, 13, 2, 16),
(1243, 106, 12, 2, 16),
(1244, 106, 20, 3, 16),
(1245, 106, 19, 3, 16),
(1246, 106, 18, 3, 16),
(1247, 106, 17, 3, 16),
(1248, 106, 16, 3, 16),
(1249, 106, 15, 3, 16),
(1250, 106, 14, 3, 16),
(1251, 106, 13, 3, 16),
(1252, 106, 12, 3, 16),
(1287, 108, 20, 2, 16),
(1288, 108, 19, 2, 16),
(1289, 108, 17, 2, 16),
(1290, 108, 16, 2, 6),
(1291, 108, 15, 2, 52),
(1292, 108, 14, 2, 31),
(1293, 108, 13, 2, 32),
(1294, 108, 12, 2, 135),
(1295, 108, 20, 3, 16),
(1296, 108, 19, 3, 16),
(1297, 108, 18, 3, 16),
(1298, 108, 17, 3, 6),
(1299, 108, 16, 3, 4),
(1300, 108, 15, 3, 21),
(1301, 108, 14, 3, 31),
(1302, 108, 13, 3, 13),
(1303, 108, 12, 3, 351),
(1304, 111, 20, 2, 8),
(1305, 111, 19, 2, 5),
(1306, 111, 17, 2, 5),
(1307, 111, 16, 2, 2),
(1308, 111, 15, 2, 1),
(1309, 111, 14, 2, 8),
(1310, 111, 13, 2, 5),
(1311, 111, 12, 2, 24),
(1312, 111, 20, 3, 7),
(1313, 111, 19, 3, 3),
(1314, 111, 18, 3, NULL),
(1315, 111, 17, 3, 1),
(1316, 111, 16, 3, NULL),
(1317, 111, 15, 3, 3),
(1318, 111, 14, 3, NULL),
(1319, 111, 13, 3, NULL),
(1320, 111, 12, 3, 1),
(1321, 129, 20, 2, 8),
(1322, 129, 19, 2, 8),
(1323, 129, 17, 2, 8),
(1324, 129, 16, 2, 8),
(1325, 129, 15, 2, 8),
(1326, 129, 14, 2, 8),
(1327, 129, 13, 2, 8),
(1328, 129, 12, 2, 8),
(1329, 129, 20, 3, 8),
(1330, 129, 19, 3, 8),
(1331, 129, 18, 3, 8),
(1332, 129, 17, 3, 8),
(1333, 129, 16, 3, 8),
(1334, 129, 15, 3, 8),
(1335, 129, 14, 3, 8),
(1336, 129, 13, 3, 8),
(1337, 129, 12, 3, 8),
(1338, 131, 20, 2, 8),
(1339, 131, 19, 2, 3),
(1340, 131, 17, 2, 8),
(1341, 131, 16, 2, 85),
(1342, 131, 15, 2, 3),
(1343, 131, 14, 2, 4),
(1344, 131, 13, 2, 2),
(1345, 131, 12, 2, 2),
(1346, 131, 20, 3, 2),
(1347, 131, 19, 3, 5),
(1348, 131, 18, 3, 74),
(1349, 131, 17, 3, 3),
(1350, 131, 16, 3, 8),
(1351, 131, 15, 3, NULL),
(1352, 131, 14, 3, 1),
(1353, 131, 13, 3, 4),
(1354, 131, 12, 3, 1),
(1355, 124, 20, 2, 17),
(1356, 124, 19, 2, 17),
(1357, 124, 17, 2, 17),
(1358, 124, 16, 2, 1),
(1359, 124, 15, 2, 7),
(1360, 124, 14, 2, NULL),
(1361, 124, 13, 2, 13),
(1362, 124, 12, 2, 22),
(1363, 124, 20, 3, 17),
(1364, 124, 19, 3, 171),
(1365, 124, 18, 3, 17),
(1366, 124, 17, 3, 17),
(1367, 124, 16, 3, 71),
(1368, 124, 15, 3, 1),
(1369, 124, 14, 3, 22),
(1370, 124, 13, 3, NULL),
(1371, 124, 12, 3, 2),
(1372, 115, 20, 2, 2),
(1373, 115, 19, 2, 1),
(1374, 115, 17, 2, 1),
(1375, 115, 16, 2, NULL),
(1376, 115, 15, 2, 22),
(1377, 115, 14, 2, 2),
(1378, 115, 13, 2, 2),
(1379, 115, 12, 2, 2),
(1380, 115, 20, 3, 2),
(1381, 115, 19, 3, NULL),
(1382, 115, 18, 3, 2),
(1383, 115, 17, 3, 213),
(1384, 115, 16, 3, 1),
(1385, 115, 15, 3, 1),
(1386, 115, 14, 3, 2),
(1387, 115, 13, 3, 2),
(1388, 115, 12, 3, 2),
(1389, 125, 20, 2, 18),
(1390, 125, 19, 2, 18),
(1391, 125, 17, 2, 18),
(1392, 125, 16, 2, 18),
(1393, 125, 15, 2, NULL),
(1394, 125, 14, 2, NULL),
(1395, 125, 13, 2, NULL),
(1396, 125, 12, 2, NULL),
(1397, 125, 20, 3, 18),
(1398, 125, 19, 3, 18),
(1399, 125, 18, 3, 18),
(1400, 125, 17, 3, 18),
(1401, 125, 16, 3, 81),
(1402, 125, 15, 3, NULL),
(1403, 125, 14, 3, NULL),
(1404, 125, 13, 3, NULL),
(1405, 125, 12, 3, NULL),
(1406, 122, 20, 2, 15),
(1407, 122, 19, 2, 15),
(1408, 122, 17, 2, 15),
(1409, 122, 16, 2, 1),
(1410, 122, 15, 2, 51),
(1411, 122, 14, 2, 5),
(1412, 122, 13, 2, 1),
(1413, 122, 12, 2, NULL),
(1414, 122, 20, 3, 15),
(1415, 122, 19, 3, 15),
(1416, 122, 18, 3, 15),
(1417, 122, 17, 3, 15),
(1418, 122, 16, 3, 51),
(1419, 122, 15, 3, 51),
(1420, 122, 14, 3, 1),
(1421, 122, 13, 3, 21),
(1422, 122, 12, 3, 31),
(1423, 134, 20, 2, 25),
(1424, 134, 19, 2, 25),
(1425, 134, 17, 2, 25),
(1426, 134, 16, 2, 252),
(1427, 134, 15, 2, NULL),
(1428, 134, 14, 2, NULL),
(1429, 134, 13, 2, 3),
(1430, 134, 12, 2, NULL),
(1431, 134, 20, 3, 25),
(1432, 134, 19, 3, 25),
(1433, 134, 18, 3, 25),
(1434, 134, 17, 3, 25),
(1435, 134, 16, 3, 525),
(1436, 134, 15, 3, NULL),
(1437, 134, 14, 3, 21),
(1438, 134, 13, 3, 2),
(1439, 134, 12, 3, 21),
(1440, 127, 20, 2, 20),
(1441, 127, 19, 2, 20),
(1442, 127, 17, 2, 2020),
(1443, 127, 16, 2, 2),
(1444, 127, 15, 2, 22),
(1445, 127, 14, 2, NULL),
(1446, 127, 13, 2, NULL),
(1447, 127, 12, 2, NULL),
(1448, 127, 20, 3, 20),
(1449, 127, 19, 3, 20),
(1450, 127, 18, 3, 20),
(1451, 127, 17, 3, 0),
(1452, 127, 16, 3, 2),
(1453, 127, 15, 3, 0),
(1454, 127, 14, 3, NULL),
(1455, 127, 13, 3, NULL),
(1456, 127, 12, 3, NULL),
(1457, 126, 20, 2, 5),
(1458, 126, 19, 2, 5),
(1459, 126, 17, 2, 5),
(1460, 126, 16, 2, 5),
(1461, 126, 15, 2, 1),
(1462, 126, 14, 2, 1),
(1463, 126, 13, 2, 2),
(1464, 126, 12, 2, 1),
(1465, 126, 20, 3, 5),
(1466, 126, 19, 3, 5),
(1467, 126, 18, 3, 5),
(1468, 126, 17, 3, 5),
(1469, 126, 16, 3, NULL),
(1470, 126, 15, 3, 2),
(1471, 126, 14, 3, 21),
(1472, 126, 13, 3, 1),
(1473, 126, 12, 3, 1),
(1474, 123, 20, 2, 2),
(1475, 123, 19, 2, 2),
(1476, 123, 17, 2, 21),
(1477, 123, 16, 2, 12),
(1478, 123, 15, 2, 21),
(1479, 123, 14, 2, 12),
(1480, 123, 13, 2, 32),
(1481, 123, 12, 2, 21),
(1482, 123, 20, 3, NULL),
(1483, 123, 19, 3, 132),
(1484, 123, 18, 3, 1),
(1485, 123, 17, 3, 2),
(1486, 123, 16, 3, 1),
(1487, 123, 15, 3, 2),
(1488, 123, 14, 3, 1),
(1489, 123, 13, 3, 1),
(1490, 123, 12, 3, 21),
(1491, 135, 20, 2, 12),
(1492, 135, 19, 2, 8),
(1493, 135, 17, 2, 1),
(1494, 135, 16, 2, 3),
(1495, 135, 15, 2, 1),
(1496, 135, 14, 2, 2),
(1497, 135, 13, 2, 2),
(1498, 135, 12, 2, 1),
(1499, 135, 20, 3, 5),
(1500, 135, 19, 3, 4),
(1501, 135, 18, 3, 8),
(1502, 135, 17, 3, 2),
(1503, 135, 16, 3, 2),
(1504, 135, 15, 3, 45),
(1505, 135, 14, 3, 3),
(1506, 135, 13, 3, 15),
(1507, 135, 12, 3, 22),
(1542, 112, 20, 2, 15),
(1543, 112, 19, 2, 12),
(1544, 112, 17, 2, 2),
(1545, 112, 16, 2, 5),
(1546, 112, 15, 2, 2),
(1547, 112, 14, 2, NULL),
(1548, 112, 13, 2, NULL),
(1549, 112, 12, 2, 3),
(1550, 112, 20, 3, 15),
(1551, 112, 19, 3, 3),
(1552, 112, 18, 3, NULL),
(1553, 112, 17, 3, 31),
(1554, 112, 16, 3, 1),
(1555, 112, 15, 3, 1),
(1556, 112, 14, 3, 12),
(1557, 112, 13, 3, 2),
(1558, 112, 12, 3, 2),
(1559, 136, 20, 2, 87),
(1560, 136, 19, 2, 87),
(1561, 136, 17, 2, 87),
(1562, 136, 16, 2, 78),
(1563, 136, 15, 2, 7),
(1564, 136, 14, 2, 87),
(1565, 136, 13, 2, 8),
(1566, 136, 12, 2, 87),
(1567, 136, 20, 3, 87),
(1568, 136, 19, 3, 87),
(1569, 136, 18, 3, 87),
(1570, 136, 17, 3, 8),
(1571, 136, 16, 3, 78),
(1572, 136, 15, 3, 87),
(1573, 136, 14, 3, 87),
(1574, 136, 13, 3, 7),
(1575, 136, 12, 3, 87),
(1610, 137, 20, 2, 20),
(1611, 137, 19, 2, 20),
(1612, 137, 17, 2, 20),
(1613, 137, 16, 2, 20),
(1614, 137, 15, 2, 20),
(1615, 137, 14, 2, 20),
(1616, 137, 13, 2, 20),
(1617, 137, 12, 2, 20),
(1618, 137, 20, 3, 15),
(1619, 137, 19, 3, 15),
(1620, 137, 18, 3, 20),
(1621, 137, 17, 3, 15),
(1622, 137, 16, 3, 15),
(1623, 137, 15, 3, 15),
(1624, 137, 14, 3, 15),
(1625, 137, 13, 3, 15),
(1626, 137, 12, 3, 15),
(1646, 137, 18, 2, 0),
(1662, 162, 20, 2, 0),
(1663, 162, 19, 2, 0),
(1664, 162, 18, 2, 0),
(1665, 162, 17, 2, 0),
(1666, 162, 16, 2, 0),
(1667, 162, 15, 2, 0),
(1668, 162, 14, 2, 0),
(1669, 162, 13, 2, 0),
(1670, 162, 12, 2, 0),
(1671, 162, 20, 3, 0),
(1672, 162, 19, 3, 0),
(1673, 162, 18, 3, 0),
(1674, 162, 17, 3, 0),
(1675, 162, 16, 3, 0),
(1676, 162, 15, 3, 0),
(1677, 162, 14, 3, 0),
(1678, 162, 13, 3, 0),
(1679, 162, 12, 3, 0),
(1680, 163, 20, 2, 0),
(1681, 163, 19, 2, 0),
(1682, 163, 18, 2, 0),
(1683, 163, 17, 2, 0),
(1684, 163, 16, 2, 0),
(1685, 163, 15, 2, 0),
(1686, 163, 14, 2, 0),
(1687, 163, 13, 2, 0),
(1688, 163, 12, 2, 0),
(1689, 163, 20, 3, 0),
(1690, 163, 19, 3, 0),
(1691, 163, 18, 3, 0),
(1692, 163, 17, 3, 0),
(1693, 163, 16, 3, 0),
(1694, 163, 15, 3, 0),
(1695, 163, 14, 3, 0),
(1696, 163, 13, 3, 0),
(1697, 163, 12, 3, 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `PartEnLista`
--
CREATE TABLE IF NOT EXISTS `PartEnLista` (
`idPart` int(11)
,`NroPartido` int(11)
,`AgrupacionPolitica` text
,`id` int(11)
,`NroLista` int(5)
,`nombre` varchar(50)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NroLista` int(11) NOT NULL,
  `AgrupacionPolitica` text NOT NULL,
  `img` varchar(20) DEFAULT NULL,
  `activo` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Truncar tablas antes de insertar `partidos`
--

TRUNCATE TABLE `partidos`;
--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `NroLista`, `AgrupacionPolitica`, `img`, `activo`) VALUES
(1, 2, 'FRENTE PARA LA VICTORIA', 'img/fpv.png', 0),
(2, 3, 'UNION PARA VIVIR MEJOR CAMBIEMOS', 'img/upvm.png', 0),
(3, 13, 'Movimiento al Socialismo', NULL, 1),
(4, 38, 'Movimiento Socialista de los Trabajadores', '', 1),
(5, 47, 'Coalición Cívica - Afirmación para una República Igualitaria(ARI)', NULL, 1),
(6, 54, 'Partido de la Victoria', NULL, 1),
(7, 61, 'IZQUIERDA AL FRENTE POR EL SOCIALISMO ', 'img/izqalfrente.png', 0),
(8, 64, 'PRO - Propuesta Republicana ', NULL, 1),
(9, 67, 'Kolina', NULL, 1),
(10, 83, 'PROYECTO SUR', 'img/proyectosur.png', 0),
(11, 154, 'FRENTE DE IZQUIERDA Y LOS TRABAJADORES', 'img/frentedeizq.png', 0),
(12, 164, 'Encuentro Ciudadano', NULL, 1),
(13, 176, 'FRENTE RENOVADOR ', 'img/1provincia.png', 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `SubEnLista`
--
CREATE TABLE IF NOT EXISTS `SubEnLista` (
`idCargo` int(11)
,`idLista` int(11)
,`idCandidato` int(11)
,`candiato` varchar(82)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TotalMesas`
--

CREATE TABLE IF NOT EXISTS `TotalMesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCiudad` int(11) NOT NULL,
  `TotalMesas` int(5) NOT NULL,
  `idEleccion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCiudad` (`idCiudad`),
  KEY `idEleccion` (`idEleccion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Truncar tablas antes de insertar `TotalMesas`
--

TRUNCATE TABLE `TotalMesas`;
--
-- Volcado de datos para la tabla `TotalMesas`
--

INSERT INTO `TotalMesas` (`id`, `idCiudad`, `TotalMesas`, `idEleccion`) VALUES
(1, 1, 28, 1),
(2, 2, 1, 1),
(3, 3, 145, 1),
(4, 4, 1, 1),
(5, 5, 24, 1),
(6, 6, 57, 1),
(7, 7, 5, 1),
(8, 8, 15, 1),
(9, 9, 1, 1),
(10, 10, 3, 1),
(11, 11, 1, 1),
(12, 12, 1, 1),
(13, 13, 2, 1),
(14, 14, 61, 1),
(15, 15, 12, 1),
(16, 17, 64, 1),
(17, 18, 39, 1),
(18, 19, 32, 1),
(19, 20, 16, 1),
(20, 21, 287, 1),
(21, 22, 34, 1),
(22, 23, 1, 1),
(23, 24, 2, 1),
(24, 16, 21, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `usr` varchar(30) NOT NULL,
  `pas` varchar(40) NOT NULL,
  `activo` varchar(2) NOT NULL DEFAULT 'si',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usr` (`usr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usr`, `pas`, `activo`) VALUES
(1, 'administrador', 'adm', 'adm', 'si'),
(2, 'Leandro Morala', '25026562', 'ñadkfjñalkdjñflakjsd', 'si'),
(3, 'Andres Markic', '33621082', 'adjlajdhflakjhsdkl', 'si');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `votosMesas`
--
CREATE TABLE IF NOT EXISTS `votosMesas` (
`fecha` date
,`tiempo` time
,`TotalVotantes` int(11)
,`idDistrito` int(11)
,`idSeccion` int(11)
,`idCircuito` int(11)
,`VotosBlancos` int(11)
,`VotosNulos` int(11)
,`VotosRecurridos` int(11)
,`VotosInpugnados` int(11)
,`idlista` int(11)
,`idCargo` int(11)
,`Votos` decimal(32,0)
,`SUmino` bigint(21)
,`SUman` bigint(21)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `CandidatosPorPartido`
--
DROP TABLE IF EXISTS `CandidatosPorPartido`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `CandidatosPorPartido` AS select `p`.`id` AS `idPartido`,`l`.`id` AS `idLista`,`c`.`id` AS `id`,`c`.`nombre` AS `nombre`,`c`.`apellido` AS `apellido`,`c`.`idCargo` AS `idCargo` from (`partidos` `p` left join (`listas` `l` left join (`candidatosEnLista` `e` left join `candidatos` `c` on((`e`.`idCandidato` = `c`.`id`))) on((`l`.`id` = `e`.`idLista`))) on((`p`.`id` = `l`.`idPartido`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `EnLista`
--
DROP TABLE IF EXISTS `EnLista`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `EnLista` AS select `listas`.`id` AS `id`,`listas`.`idPart` AS `idPart`,`listas`.`NroPartido` AS `NroPartido`,`listas`.`AgrupacionPolitica` AS `AgrupacionPolitica`,`listas`.`NroLista` AS `NroLista`,`listas`.`nombre` AS `nombre`,max(if((`f`.`idCargo` = 2),1,0)) AS `Senador`,max(if((`f`.`idCargo` = 3),1,0)) AS `diputado`,max(if((`f`.`idCargo` = 2),`f`.`idCandidato`,0)) AS `SenadorCandiato`,max(if((`f`.`idCargo` = 3),`f`.`idCandidato`,0)) AS `DiputadoCandiato` from (`PartEnLista` `listas` left join `SubEnLista` `f` on((`listas`.`id` = `f`.`idLista`))) group by `listas`.`id`;

-- --------------------------------------------------------

--
-- Estructura para la vista `PartEnLista`
--
DROP TABLE IF EXISTS `PartEnLista`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `PartEnLista` AS select `f`.`id` AS `idPart`,`f`.`NroLista` AS `NroPartido`,`f`.`AgrupacionPolitica` AS `AgrupacionPolitica`,`listas`.`id` AS `id`,`listas`.`NroLista` AS `NroLista`,`listas`.`nombre` AS `nombre` from (`listas` left join `partidos` `f` on((`f`.`id` = `listas`.`idPartido`))) group by `listas`.`id`;

-- --------------------------------------------------------

--
-- Estructura para la vista `SubEnLista`
--
DROP TABLE IF EXISTS `SubEnLista`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `SubEnLista` AS select `d`.`idCargo` AS `idCargo`,`c`.`idLista` AS `idLista`,`d`.`id` AS `idCandidato`,concat(`d`.`nombre`,', ',`d`.`apellido`) AS `candiato` from (`candidatosEnLista` `c` left join `candidatos` `d` on((`d`.`id` = `c`.`idCandidato`))) group by `c`.`idLista`,`d`.`idCargo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `votosMesas`
--
DROP TABLE IF EXISTS `votosMesas`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `votosMesas` AS select `mesa`.`fecha` AS `fecha`,`mesa`.`tiempo` AS `tiempo`,`mesa`.`TotalVontantes` AS `TotalVotantes`,`mesa`.`idDistrito` AS `idDistrito`,`mesa`.`idseccion` AS `idSeccion`,`mesa`.`idCircuito` AS `idCircuito`,`mesa`.`VotosBlancos` AS `VotosBlancos`,`mesa`.`VotosNulos` AS `VotosNulos`,`mesa`.`VotosRecurridos` AS `VotosRecurridos`,`mesa`.`VotosInpugnados` AS `VotosInpugnados`,`mesadetalle`.`idlista` AS `idlista`,`mesadetalle`.`idCargo` AS `idCargo`,sum(`mesadetalle`.`cantidad`) AS `Votos`,count(`mesadetalle`.`cantidad`) AS `SUmino`,count(`mesa`.`id`) AS `SUman` from (`mesa` left join `mesadetalle` on((`mesa`.`id` = `mesadetalle`.`idMesa`))) group by `mesa`.`idDistrito`,`mesa`.`idseccion`,`mesa`.`idCircuito`,`mesadetalle`.`idCargo`,`mesadetalle`.`idlista`;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD CONSTRAINT `candidatos_ibfk_1` FOREIGN KEY (`idCargo`) REFERENCES `cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `listas`
--
ALTER TABLE `listas`
  ADD CONSTRAINT `listas_ibfk_1` FOREIGN KEY (`idPartido`) REFERENCES `partidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD CONSTRAINT `mesa_ibfk_1` FOREIGN KEY (`idDistrito`) REFERENCES `Distrito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mesa_idfk_3` FOREIGN KEY (`idCircuito`) REFERENCES `ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `TotalMesas`
--
ALTER TABLE `TotalMesas`
  ADD CONSTRAINT `TotalMesas_ibfk_1` FOREIGN KEY (`idCiudad`) REFERENCES `ciudad` (`id`),
  ADD CONSTRAINT `TotalMesas_ibfk_2` FOREIGN KEY (`idEleccion`) REFERENCES `Eleciones` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
