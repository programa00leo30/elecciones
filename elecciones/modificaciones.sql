
-- creacion de la tabla registros.

CREATE TABLE IF NOT EXISTS `registros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) NOT NULL,
  `tiempo` datetime NOT NULL,
  `accion` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- correccion de registros de la tabla totalmesas:
TRUNCATE TABLE `TotalMesas` ;

INSERT INTO `TotalMesas` (`id`, `idCiudad`, `TotalMesas`, `idEleccion`, `min`, `max`) 
VALUES
(1, 1, 28, 1, 827, 851),
(2, 2, 1, 1, 384, 384),
(3, 3, 145, 1, 43, 187),
(4, 4, 1, 1, 188, 192),
(5, 5, 24, 1, 402, 425),
(6, 6, 57, 1, 449, 505),
(7, 7, 5, 1, 444, 448),
(8, 8, 15, 1, 388, 401),
(9, 9, 1, 1, 318, 318),
(10, 10, 3, 1, 40, 42),
(11, 11, 1, 1, 256, 256),
(12, 12, 1, 1, 793, 793),
(13, 13, 2, 1, 386, 387),
(14, 14, 61, 1, 257, 317),
(15, 15, 12, 1, 340, 351),
(16, 17, 64, 1, 193, 255),
(17, 18, 39, 1, 1, 39),
(18, 19, 32, 1, 352, 383),
(19, 20, 16, 1, 426, 441),
(20, 21, 287, 1, 506, 792),
(21, 22, 34, 1, 794, 826),
(22, 23, 1, 1, 385, 385),
(23, 24, 2, 1, 442, 443),
(24, 16, 21, 1, 319, 339);

-- correccion de registros tabla partidos.
TRUNCATE TABLE `listas` ;
-- correccion de registros tabla partidos.
TRUNCATE TABLE `partidos` ;

INSERT INTO `partidos` (`id`, `NroLista`, `AgrupacionPolitica`, `img`, `activo`) VALUES
(1, 502, 'FRENTE PARA LA VICTORIA', 'img/fpv.png', 0),
(2, 503, 'UNION PARA VIVIR MEJOR CAMBIEMOS', 'img/upvm.png', 0),
(3, 13, 'Movimiento al Socialismo', NULL, 1),
(4, 38, 'Movimiento Socialista de los Trabajadores', '', 1),
(5, 47, 'Coalición Cívica - Afirmación para una República Igualitaria(ARI)', NULL, 1),
(6, 54, 'Partido de la Victoria', NULL, 1),
(7, 501, 'IZQUIERDA AL FRENTE POR EL SOCIALISMO ', 'img/izqalfrente.png', 0),
(8, 64, 'PRO - Propuesta Republicana ', NULL, 1),
(9, 67, 'Kolina', NULL, 1),
(10, 83, 'PROYECTO SUR', 'img/proyectosur.png', 0),
(11, 504, 'FRENTE DE IZQUIERDA Y LOS TRABAJADORES', 'img/frentedeizq.png', 0),
(12, 164, 'Encuentro Ciudadano', NULL, 1),
(13, 176, 'FRENTE RENOVADOR ', 'img/1provincia.png', 0);

INSERT INTO `listas` (`id`, `NroLista`, `idPartido`, `nombre`) VALUES
(12, 83, 10, 'MEJOR ES HACER'),
(13, 176, 13, '1PROVINCIA'),
(14, 502, 1, 'UNIDOS POR SANTA CRUZ'),
(15, 502, 1, 'SOMOS SANTA CRUZ'),
(16, 503, 2, 'INTEGRACION CIUDADANA'),
(17, 503, 2, 'JUNTOS POR UN CAMBIO'),
(18, 503, 2, 'EL CAMINO DEL CAMBIO'),
(19, 504, 11, '1 ROJA'),
(20, 501, 7, 'UNIDAD');
