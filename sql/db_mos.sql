-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2019 a las 22:15:07
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_mos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `idparroquia` int(11) DEFAULT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `idpais` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `idpais`, `estado`) VALUES
(1, 232, 'Amazonas'),
(2, 232, 'Anzoátegui'),
(3, 232, 'Apure'),
(4, 232, 'Aragua'),
(5, 232, 'Barinas'),
(6, 232, 'Bolívar'),
(7, 232, 'Carabobo'),
(8, 232, 'Cojedes'),
(9, 232, 'Delta Amacuro'),
(10, 232, 'Falcón'),
(11, 232, 'Guárico'),
(12, 232, 'Lara'),
(13, 232, 'Mérida'),
(14, 232, 'Miranda'),
(15, 232, 'Monagas'),
(16, 232, 'Nueva Esparta'),
(17, 232, 'Portuguesa'),
(18, 232, 'Sucre'),
(19, 232, 'Táchira'),
(20, 232, 'Trujillo'),
(21, 232, 'Vargas'),
(22, 232, 'Yaracuy'),
(23, 232, 'Zulia'),
(24, 232, 'Distrito Capital'),
(25, 232, 'Dependencias Federales'),
(26, 1, 'Estado - Afganistán'),
(27, 2, 'Estado - Islas Gland'),
(28, 3, 'Estado - Albania'),
(29, 4, 'Estado - Alemania'),
(30, 5, 'Estado - Andorra'),
(31, 6, 'Estado - Angola'),
(32, 7, 'Estado - Anguilla'),
(33, 8, 'Estado - Antártida'),
(34, 9, 'Estado - Antigua y Barbuda'),
(35, 10, 'Estado - Antillas Holandesas'),
(36, 11, 'Estado - Arabia Saudí'),
(37, 12, 'Estado - Argelia'),
(38, 13, 'Estado - Argentina'),
(39, 14, 'Estado - Armenia'),
(40, 15, 'Estado - Aruba'),
(41, 16, 'Estado - Australia'),
(42, 17, 'Estado - Austria'),
(43, 18, 'Estado - Azerbaiyán'),
(44, 19, 'Estado - Bahamas'),
(45, 20, 'Estado - Bahréin'),
(46, 21, 'Estado - Bangladesh'),
(47, 22, 'Estado - Barbados'),
(48, 23, 'Estado - Bielorrusia'),
(49, 24, 'Estado - Bélgica'),
(50, 25, 'Estado - Belice'),
(51, 26, 'Estado - Benin'),
(52, 27, 'Estado - Bermudas'),
(53, 28, 'Estado - Bhután'),
(54, 29, 'Estado - Bolivia'),
(55, 30, 'Estado - Bosnia y Herzegovina'),
(56, 31, 'Estado - Botsuana'),
(57, 32, 'Estado - Isla Bouvet'),
(58, 33, 'Estado - Brasil'),
(59, 34, 'Estado - Brunéi'),
(60, 35, 'Estado - Bulgaria'),
(61, 36, 'Estado - Burkina Faso'),
(62, 37, 'Estado - Burundi'),
(63, 38, 'Estado - Cabo Verde'),
(64, 39, 'Estado - Islas Caimán'),
(65, 40, 'Estado - Camboya'),
(66, 41, 'Estado - Camerún'),
(67, 42, 'Estado - Canadá'),
(68, 43, 'Estado - República Centroafricana'),
(69, 44, 'Estado - Chad'),
(70, 45, 'Estado - República Checa'),
(71, 46, 'Estado - Chile'),
(72, 47, 'Estado - China'),
(73, 48, 'Estado - Chipre'),
(74, 49, 'Estado - Isla de Navidad'),
(75, 50, 'Estado - Ciudad del Vaticano'),
(76, 51, 'Estado - Islas Cocos'),
(77, 52, 'Estado - Colombia'),
(78, 53, 'Estado - Comoras'),
(79, 54, 'Estado - República Democrática del Congo'),
(80, 55, 'Estado - Congo'),
(81, 56, 'Estado - Islas Cook'),
(82, 57, 'Estado - Corea del Norte'),
(83, 58, 'Estado - Corea del Sur'),
(84, 59, 'Estado - Costa de Marfil'),
(85, 60, 'Estado - Costa Rica'),
(86, 61, 'Estado - Croacia'),
(87, 62, 'Estado - Cuba'),
(88, 63, 'Estado - Dinamarca'),
(89, 64, 'Estado - Dominica'),
(90, 65, 'Estado - República Dominicana'),
(91, 66, 'Estado - Ecuador'),
(92, 67, 'Estado - Egipto'),
(93, 68, 'Estado - El Salvador'),
(94, 69, 'Estado - Emiratos Árabes Unidos'),
(95, 70, 'Estado - Eritrea'),
(96, 71, 'Estado - Eslovaquia'),
(97, 72, 'Estado - Eslovenia'),
(98, 73, 'Estado - España'),
(99, 74, 'Estado - Islas ultramarinas de Estados Unidos'),
(100, 75, 'Estado - Estados Unidos'),
(101, 76, 'Estado - Estonia'),
(102, 77, 'Estado - Etiopía'),
(103, 78, 'Estado - Islas Feroe'),
(104, 79, 'Estado - Filipinas'),
(105, 80, 'Estado - Finlandia'),
(106, 81, 'Estado - Fiyi'),
(107, 82, 'Estado - Francia'),
(108, 83, 'Estado - Gabón'),
(109, 84, 'Estado - Gambia'),
(110, 85, 'Estado - Georgia'),
(111, 86, 'Estado - Islas Georgias del Sur y Sandwich de'),
(112, 87, 'Estado - Ghana'),
(113, 88, 'Estado - Gibraltar'),
(114, 89, 'Estado - Granada'),
(115, 90, 'Estado - Grecia'),
(116, 91, 'Estado - Groenlandia'),
(117, 92, 'Estado - Guadalupe'),
(118, 93, 'Estado - Guam'),
(119, 94, 'Estado - Guatemala'),
(120, 95, 'Estado - Guayana Francesa'),
(121, 96, 'Estado - Guinea'),
(122, 97, 'Estado - Guinea Ecuatorial'),
(123, 98, 'Estado - Guinea-Bissau'),
(124, 99, 'Estado - Guyana'),
(125, 100, 'Estado - Haití'),
(126, 101, 'Estado - Islas Heard y McDonald'),
(127, 102, 'Estado - Honduras'),
(128, 103, 'Estado - Hong Kong'),
(129, 104, 'Estado - Hungría'),
(130, 105, 'Estado - India'),
(131, 106, 'Estado - Indonesia'),
(132, 107, 'Estado - Irán'),
(133, 108, 'Estado - Iraq'),
(134, 109, 'Estado - Irlanda'),
(135, 110, 'Estado - Islandia'),
(136, 111, 'Estado - Israel'),
(137, 112, 'Estado - Italia'),
(138, 113, 'Estado - Jamaica'),
(139, 114, 'Estado - Japón'),
(140, 115, 'Estado - Jordania'),
(141, 116, 'Estado - Kazajstán'),
(142, 117, 'Estado - Kenia'),
(143, 118, 'Estado - Kirguistán'),
(144, 119, 'Estado - Kiribati'),
(145, 120, 'Estado - Kuwait'),
(146, 121, 'Estado - Laos'),
(147, 122, 'Estado - Lesotho'),
(148, 123, 'Estado - Letonia'),
(149, 124, 'Estado - Líbano'),
(150, 125, 'Estado - Liberia'),
(151, 126, 'Estado - Libia'),
(152, 127, 'Estado - Liechtenstein'),
(153, 128, 'Estado - Lituania'),
(154, 129, 'Estado - Luxemburgo'),
(155, 130, 'Estado - Macao'),
(156, 131, 'Estado - ARY Macedonia'),
(157, 132, 'Estado - Madagascar'),
(158, 133, 'Estado - Malasia'),
(159, 134, 'Estado - Malawi'),
(160, 135, 'Estado - Maldivas'),
(161, 136, 'Estado - Malí'),
(162, 137, 'Estado - Malta'),
(163, 138, 'Estado - Islas Malvinas'),
(164, 139, 'Estado - Islas Marianas del Norte'),
(165, 140, 'Estado - Marruecos'),
(166, 141, 'Estado - Islas Marshall'),
(167, 142, 'Estado - Martinica'),
(168, 143, 'Estado - Mauricio'),
(169, 144, 'Estado - Mauritania'),
(170, 145, 'Estado - Mayotte'),
(171, 146, 'Estado - México'),
(172, 147, 'Estado - Micronesia'),
(173, 148, 'Estado - Moldavia'),
(174, 149, 'Estado - Mónaco'),
(175, 150, 'Estado - Mongolia'),
(176, 151, 'Estado - Montserrat'),
(177, 152, 'Estado - Mozambique'),
(178, 153, 'Estado - Myanmar'),
(179, 154, 'Estado - Namibia'),
(180, 155, 'Estado - Nauru'),
(181, 156, 'Estado - Nepal'),
(182, 157, 'Estado - Nicaragua'),
(183, 158, 'Estado - Níger'),
(184, 159, 'Estado - Nigeria'),
(185, 160, 'Estado - Niue'),
(186, 161, 'Estado - Isla Norfolk'),
(187, 162, 'Estado - Noruega'),
(188, 163, 'Estado - Nueva Caledonia'),
(189, 164, 'Estado - Nueva Zelanda'),
(190, 165, 'Estado - Omán'),
(191, 166, 'Estado - Países Bajos'),
(192, 167, 'Estado - Pakistán'),
(193, 168, 'Estado - Palau'),
(194, 169, 'Estado - Palestina'),
(195, 170, 'Estado - Panamá'),
(196, 171, 'Estado - Papúa Nueva Guinea'),
(197, 172, 'Estado - Paraguay'),
(198, 173, 'Estado - Perú'),
(199, 174, 'Estado - Islas Pitcairn'),
(200, 175, 'Estado - Polinesia Francesa'),
(201, 176, 'Estado - Polonia'),
(202, 177, 'Estado - Portugal'),
(203, 178, 'Estado - Puerto Rico'),
(204, 179, 'Estado - Qatar'),
(205, 180, 'Estado - Reino Unido'),
(206, 181, 'Estado - Reunión'),
(207, 182, 'Estado - Ruanda'),
(208, 183, 'Estado - Rumania'),
(209, 184, 'Estado - Rusia'),
(210, 185, 'Estado - Sahara Occidental'),
(211, 186, 'Estado - Islas Salomón'),
(212, 187, 'Estado - Samoa'),
(213, 188, 'Estado - Samoa Americana'),
(214, 189, 'Estado - San Cristóbal y Nevis'),
(215, 190, 'Estado - San Marino'),
(216, 191, 'Estado - San Pedro y Miquelón'),
(217, 192, 'Estado - San Vicente y las Granadinas'),
(218, 193, 'Estado - Santa Helena'),
(219, 194, 'Estado - Santa Lucía'),
(220, 195, 'Estado - Santo Tomé y Príncipe'),
(221, 196, 'Estado - Senegal'),
(222, 197, 'Estado - Serbia y Montenegro'),
(223, 198, 'Estado - Seychelles'),
(224, 199, 'Estado - Sierra Leona'),
(225, 200, 'Estado - Singapur'),
(226, 201, 'Estado - Siria'),
(227, 202, 'Estado - Somalia'),
(228, 203, 'Estado - Sri Lanka'),
(229, 204, 'Estado - Suazilandia'),
(230, 205, 'Estado - Sudáfrica'),
(231, 206, 'Estado - Sudán'),
(232, 207, 'Estado - Suecia'),
(233, 208, 'Estado - Suiza'),
(234, 209, 'Estado - Surinam'),
(235, 210, 'Estado - Svalbard y Jan Mayen'),
(236, 211, 'Estado - Tailandia'),
(237, 212, 'Estado - Taiwán'),
(238, 213, 'Estado - Tanzania'),
(239, 214, 'Estado - Tayikistán'),
(240, 215, 'Estado - Territorio Británico del Océano Índi'),
(241, 216, 'Estado - Territorios Australes Franceses'),
(242, 217, 'Estado - Timor Oriental'),
(243, 218, 'Estado - Togo'),
(244, 219, 'Estado - Tokelau'),
(245, 220, 'Estado - Tonga'),
(246, 221, 'Estado - Trinidad y Tobago'),
(247, 222, 'Estado - Túnez'),
(248, 223, 'Estado - Islas Turcas y Caicos'),
(249, 224, 'Estado - Turkmenistán'),
(250, 225, 'Estado - Turquía'),
(251, 226, 'Estado - Tuvalu'),
(252, 227, 'Estado - Ucrania'),
(253, 228, 'Estado - Uganda'),
(254, 229, 'Estado - Uruguay'),
(255, 230, 'Estado - Uzbekistán'),
(256, 231, 'Estado - Vanuatu'),
(257, 233, 'Estado - Vietnam'),
(258, 234, 'Estado - Islas Vírgenes Británicas'),
(259, 235, 'Estado - Islas Vírgenes de los Estados Unidos'),
(260, 236, 'Estado - Wallis y Futuna'),
(261, 237, 'Estado - Yemen'),
(262, 238, 'Estado - Yibuti'),
(263, 239, 'Estado - Zambia'),
(264, 240, 'Estado - Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id` int(11) NOT NULL,
  `idestado` int(11) NOT NULL,
  `municipio` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id`, `idestado`, `municipio`) VALUES
(1, 1, 'Alto Orinoco'),
(2, 1, 'Atabapo'),
(3, 1, 'Atures'),
(4, 1, 'Autana'),
(5, 1, 'Manapiare'),
(6, 1, 'Maroa'),
(7, 1, 'Río Negro'),
(8, 2, 'Anaco'),
(9, 2, 'Aragua'),
(10, 2, 'Manuel Ezequiel Bruzual'),
(11, 2, 'Diego Bautista Urbaneja'),
(12, 2, 'Fernando Peñalver'),
(13, 2, 'Francisco Del Carmen Carvajal'),
(14, 2, 'General Sir Arthur McGregor'),
(15, 2, 'Guanta'),
(16, 2, 'Independencia'),
(17, 2, 'José Gregorio Monagas'),
(18, 2, 'Juan Antonio Sotillo'),
(19, 2, 'Juan Manuel Cajigal'),
(20, 2, 'Libertad'),
(21, 2, 'Francisco de Miranda'),
(22, 2, 'Pedro María Freites'),
(23, 2, 'Píritu'),
(24, 2, 'San José de Guanipa'),
(25, 2, 'San Juan de Capistrano'),
(26, 2, 'Santa Ana'),
(27, 2, 'Simón Bolívar'),
(28, 2, 'Simón Rodríguez'),
(29, 3, 'Achaguas'),
(30, 3, 'Biruaca'),
(31, 3, 'Muñóz'),
(32, 3, 'Páez'),
(33, 3, 'Pedro Camejo'),
(34, 3, 'Rómulo Gallegos'),
(35, 3, 'San Fernando'),
(36, 4, 'Atanasio Girardot'),
(37, 4, 'Bolívar'),
(38, 4, 'Camatagua'),
(39, 4, 'Francisco Linares Alcántara'),
(40, 4, 'José Ángel Lamas'),
(41, 4, 'José Félix Ribas'),
(42, 4, 'José Rafael Revenga'),
(43, 4, 'Libertador'),
(44, 4, 'Mario Briceño Iragorry'),
(45, 4, 'Ocumare de la Costa de Oro'),
(46, 4, 'San Casimiro'),
(47, 4, 'San Sebastián'),
(48, 4, 'Santiago Mariño'),
(49, 4, 'Santos Michelena'),
(50, 4, 'Sucre'),
(51, 4, 'Tovar'),
(52, 4, 'Urdaneta'),
(53, 4, 'Zamora'),
(54, 5, 'Alberto Arvelo Torrealba'),
(55, 5, 'Andrés Eloy Blanco'),
(56, 5, 'Antonio José de Sucre'),
(57, 5, 'Arismendi'),
(58, 5, 'Barinas'),
(59, 5, 'Bolívar'),
(60, 5, 'Cruz Paredes'),
(61, 5, 'Ezequiel Zamora'),
(62, 5, 'Obispos'),
(63, 5, 'Pedraza'),
(64, 5, 'Rojas'),
(65, 5, 'Sosa'),
(66, 6, 'Caroní'),
(67, 6, 'Cedeño'),
(68, 6, 'El Callao'),
(69, 6, 'Gran Sabana'),
(70, 6, 'Heres'),
(71, 6, 'Piar'),
(72, 6, 'Angostura (Raúl Leoni)'),
(73, 6, 'Roscio'),
(74, 6, 'Sifontes'),
(75, 6, 'Sucre'),
(76, 6, 'Padre Pedro Chien'),
(77, 7, 'Bejuma'),
(78, 7, 'Carlos Arvelo'),
(79, 7, 'Diego Ibarra'),
(80, 7, 'Guacara'),
(81, 7, 'Juan José Mora'),
(82, 7, 'Libertador'),
(83, 7, 'Los Guayos'),
(84, 7, 'Miranda'),
(85, 7, 'Montalbán'),
(86, 7, 'Naguanagua'),
(87, 7, 'Puerto Cabello'),
(88, 7, 'San Diego'),
(89, 7, 'San Joaquín'),
(90, 7, 'Valencia'),
(91, 8, 'Anzoátegui'),
(92, 8, 'Tinaquillo'),
(93, 8, 'Girardot'),
(94, 8, 'Lima Blanco'),
(95, 8, 'Pao de San Juan Bautista'),
(96, 8, 'Ricaurte'),
(97, 8, 'Rómulo Gallegos'),
(98, 8, 'San Carlos'),
(99, 8, 'Tinaco'),
(100, 9, 'Antonio Díaz'),
(101, 9, 'Casacoima'),
(102, 9, 'Pedernales'),
(103, 9, 'Tucupita'),
(104, 10, 'Acosta'),
(105, 10, 'Bolívar'),
(106, 10, 'Buchivacoa'),
(107, 10, 'Cacique Manaure'),
(108, 10, 'Carirubana'),
(109, 10, 'Colina'),
(110, 10, 'Dabajuro'),
(111, 10, 'Democracia'),
(112, 10, 'Falcón'),
(113, 10, 'Federación'),
(114, 10, 'Jacura'),
(115, 10, 'José Laurencio Silva'),
(116, 10, 'Los Taques'),
(117, 10, 'Mauroa'),
(118, 10, 'Miranda'),
(119, 10, 'Monseñor Iturriza'),
(120, 10, 'Palmasola'),
(121, 10, 'Petit'),
(122, 10, 'Píritu'),
(123, 10, 'San Francisco'),
(124, 10, 'Sucre'),
(125, 10, 'Tocópero'),
(126, 10, 'Unión'),
(127, 10, 'Urumaco'),
(128, 10, 'Zamora'),
(129, 11, 'Camaguán'),
(130, 11, 'Chaguaramas'),
(131, 11, 'El Socorro'),
(132, 11, 'José Félix Ribas'),
(133, 11, 'José Tadeo Monagas'),
(134, 11, 'Juan Germán Roscio'),
(135, 11, 'Julián Mellado'),
(136, 11, 'Las Mercedes'),
(137, 11, 'Leonardo Infante'),
(138, 11, 'Pedro Zaraza'),
(139, 11, 'Ortíz'),
(140, 11, 'San Gerónimo de Guayabal'),
(141, 11, 'San José de Guaribe'),
(142, 11, 'Santa María de Ipire'),
(143, 11, 'Sebastián Francisco de Miranda'),
(144, 12, 'Andrés Eloy Blanco'),
(145, 12, 'Crespo'),
(146, 12, 'Iribarren'),
(147, 12, 'Jiménez'),
(148, 12, 'Morán'),
(149, 12, 'Palavecino'),
(150, 12, 'Simón Planas'),
(151, 12, 'Torres'),
(152, 12, 'Urdaneta'),
(179, 13, 'Alberto Adriani'),
(180, 13, 'Andrés Bello'),
(181, 13, 'Antonio Pinto Salinas'),
(182, 13, 'Aricagua'),
(183, 13, 'Arzobispo Chacón'),
(184, 13, 'Campo Elías'),
(185, 13, 'Caracciolo Parra Olmedo'),
(186, 13, 'Cardenal Quintero'),
(187, 13, 'Guaraque'),
(188, 13, 'Julio César Salas'),
(189, 13, 'Justo Briceño'),
(190, 13, 'Libertador'),
(191, 13, 'Miranda'),
(192, 13, 'Obispo Ramos de Lora'),
(193, 13, 'Padre Noguera'),
(194, 13, 'Pueblo Llano'),
(195, 13, 'Rangel'),
(196, 13, 'Rivas Dávila'),
(197, 13, 'Santos Marquina'),
(198, 13, 'Sucre'),
(199, 13, 'Tovar'),
(200, 13, 'Tulio Febres Cordero'),
(201, 13, 'Zea'),
(223, 14, 'Acevedo'),
(224, 14, 'Andrés Bello'),
(225, 14, 'Baruta'),
(226, 14, 'Brión'),
(227, 14, 'Buroz'),
(228, 14, 'Carrizal'),
(229, 14, 'Chacao'),
(230, 14, 'Cristóbal Rojas'),
(231, 14, 'El Hatillo'),
(232, 14, 'Guaicaipuro'),
(233, 14, 'Independencia'),
(234, 14, 'Lander'),
(235, 14, 'Los Salias'),
(236, 14, 'Páez'),
(237, 14, 'Paz Castillo'),
(238, 14, 'Pedro Gual'),
(239, 14, 'Plaza'),
(240, 14, 'Simón Bolívar'),
(241, 14, 'Sucre'),
(242, 14, 'Urdaneta'),
(243, 14, 'Zamora'),
(258, 15, 'Acosta'),
(259, 15, 'Aguasay'),
(260, 15, 'Bolívar'),
(261, 15, 'Caripe'),
(262, 15, 'Cedeño'),
(263, 15, 'Ezequiel Zamora'),
(264, 15, 'Libertador'),
(265, 15, 'Maturín'),
(266, 15, 'Piar'),
(267, 15, 'Punceres'),
(268, 15, 'Santa Bárbara'),
(269, 15, 'Sotillo'),
(270, 15, 'Uracoa'),
(271, 16, 'Antolín del Campo'),
(272, 16, 'Arismendi'),
(273, 16, 'García'),
(274, 16, 'Gómez'),
(275, 16, 'Maneiro'),
(276, 16, 'Marcano'),
(277, 16, 'Mariño'),
(278, 16, 'Península de Macanao'),
(279, 16, 'Tubores'),
(280, 16, 'Villalba'),
(281, 16, 'Díaz'),
(282, 17, 'Agua Blanca'),
(283, 17, 'Araure'),
(284, 17, 'Esteller'),
(285, 17, 'Guanare'),
(286, 17, 'Guanarito'),
(287, 17, 'Monseñor José Vicente de Unda'),
(288, 17, 'Ospino'),
(289, 17, 'Páez'),
(290, 17, 'Papelón'),
(291, 17, 'San Genaro de Boconoíto'),
(292, 17, 'San Rafael de Onoto'),
(293, 17, 'Santa Rosalía'),
(294, 17, 'Sucre'),
(295, 17, 'Turén'),
(296, 18, 'Andrés Eloy Blanco'),
(297, 18, 'Andrés Mata'),
(298, 18, 'Arismendi'),
(299, 18, 'Benítez'),
(300, 18, 'Bermúdez'),
(301, 18, 'Bolívar'),
(302, 18, 'Cajigal'),
(303, 18, 'Cruz Salmerón Acosta'),
(304, 18, 'Libertador'),
(305, 18, 'Mariño'),
(306, 18, 'Mejía'),
(307, 18, 'Montes'),
(308, 18, 'Ribero'),
(309, 18, 'Sucre'),
(310, 18, 'Valdéz'),
(341, 19, 'Andrés Bello'),
(342, 19, 'Antonio Rómulo Costa'),
(343, 19, 'Ayacucho'),
(344, 19, 'Bolívar'),
(345, 19, 'Cárdenas'),
(346, 19, 'Córdoba'),
(347, 19, 'Fernández Feo'),
(348, 19, 'Francisco de Miranda'),
(349, 19, 'García de Hevia'),
(350, 19, 'Guásimos'),
(351, 19, 'Independencia'),
(352, 19, 'Jáuregui'),
(353, 19, 'José María Vargas'),
(354, 19, 'Junín'),
(355, 19, 'Libertad'),
(356, 19, 'Libertador'),
(357, 19, 'Lobatera'),
(358, 19, 'Michelena'),
(359, 19, 'Panamericano'),
(360, 19, 'Pedro María Ureña'),
(361, 19, 'Rafael Urdaneta'),
(362, 19, 'Samuel Darío Maldonado'),
(363, 19, 'San Cristóbal'),
(364, 19, 'Seboruco'),
(365, 19, 'Simón Rodríguez'),
(366, 19, 'Sucre'),
(367, 19, 'Torbes'),
(368, 19, 'Uribante'),
(369, 19, 'San Judas Tadeo'),
(370, 20, 'Andrés Bello'),
(371, 20, 'Boconó'),
(372, 20, 'Bolívar'),
(373, 20, 'Candelaria'),
(374, 20, 'Carache'),
(375, 20, 'Escuque'),
(376, 20, 'José Felipe Márquez Cañizalez'),
(377, 20, 'Juan Vicente Campos Elías'),
(378, 20, 'La Ceiba'),
(379, 20, 'Miranda'),
(380, 20, 'Monte Carmelo'),
(381, 20, 'Motatán'),
(382, 20, 'Pampán'),
(383, 20, 'Pampanito'),
(384, 20, 'Rafael Rangel'),
(385, 20, 'San Rafael de Carvajal'),
(386, 20, 'Sucre'),
(387, 20, 'Trujillo'),
(388, 20, 'Urdaneta'),
(389, 20, 'Valera'),
(390, 21, 'Vargas'),
(391, 22, 'Arístides Bastidas'),
(392, 22, 'Bolívar'),
(407, 22, 'Bruzual'),
(408, 22, 'Cocorote'),
(409, 22, 'Independencia'),
(410, 22, 'José Antonio Páez'),
(411, 22, 'La Trinidad'),
(412, 22, 'Manuel Monge'),
(413, 22, 'Nirgua'),
(414, 22, 'Peña'),
(415, 22, 'San Felipe'),
(416, 22, 'Sucre'),
(417, 22, 'Urachiche'),
(418, 22, 'José Joaquín Veroes'),
(441, 23, 'Almirante Padilla'),
(442, 23, 'Baralt'),
(443, 23, 'Cabimas'),
(444, 23, 'Catatumbo'),
(445, 23, 'Colón'),
(446, 23, 'Francisco Javier Pulgar'),
(447, 23, 'Páez'),
(448, 23, 'Jesús Enrique Losada'),
(449, 23, 'Jesús María Semprún'),
(450, 23, 'La Cañada de Urdaneta'),
(451, 23, 'Lagunillas'),
(452, 23, 'Machiques de Perijá'),
(453, 23, 'Mara'),
(454, 23, 'Maracaibo'),
(455, 23, 'Miranda'),
(456, 23, 'Rosario de Perijá'),
(457, 23, 'San Francisco'),
(458, 23, 'Santa Rita'),
(459, 23, 'Simón Bolívar'),
(460, 23, 'Sucre'),
(461, 23, 'Valmore Rodríguez'),
(462, 24, 'Libertador'),
(463, 26, 'Municipio - Afganistán'),
(464, 27, 'Municipio - Islas Gland'),
(465, 28, 'Municipio - Albania'),
(466, 29, 'Municipio - Alemania'),
(467, 30, 'Municipio - Andorra'),
(468, 31, 'Municipio - Angola'),
(469, 32, 'Municipio - Anguilla'),
(470, 33, 'Municipio - Antártida'),
(471, 34, 'Municipio - Antigua y Barbuda'),
(472, 35, 'Municipio - Antillas Holandesas'),
(473, 36, 'Municipio - Arabia Saudí'),
(474, 37, 'Municipio - Argelia'),
(475, 38, 'Municipio - Argentina'),
(476, 39, 'Municipio - Armenia'),
(477, 40, 'Municipio - Aruba'),
(478, 41, 'Municipio - Australia'),
(479, 42, 'Municipio - Austria'),
(480, 43, 'Municipio - Azerbaiyán'),
(481, 44, 'Municipio - Bahamas'),
(482, 45, 'Municipio - Bahréin'),
(483, 46, 'Municipio - Bangladesh'),
(484, 47, 'Municipio - Barbados'),
(485, 48, 'Municipio - Bielorrusia'),
(486, 49, 'Municipio - Bélgica'),
(487, 50, 'Municipio - Belice'),
(488, 51, 'Municipio - Benin'),
(489, 52, 'Municipio - Bermudas'),
(490, 53, 'Municipio - Bhután'),
(491, 54, 'Municipio - Bolivia'),
(492, 55, 'Municipio - Bosnia y Herzegovina'),
(493, 56, 'Municipio - Botsuana'),
(494, 57, 'Municipio - Isla Bouvet'),
(495, 58, 'Municipio - Brasil'),
(496, 59, 'Municipio - Brunéi'),
(497, 60, 'Municipio - Bulgaria'),
(498, 61, 'Municipio - Burkina Faso'),
(499, 62, 'Municipio - Burundi'),
(500, 63, 'Municipio - Cabo Verde'),
(501, 64, 'Municipio - Islas Caimán'),
(502, 65, 'Municipio - Camboya'),
(503, 66, 'Municipio - Camerún'),
(504, 67, 'Municipio - Canadá'),
(505, 68, 'Municipio - República Centroafricana'),
(506, 69, 'Municipio - Chad'),
(507, 70, 'Municipio - República Checa'),
(508, 71, 'Municipio - Chile'),
(509, 72, 'Municipio - China'),
(510, 73, 'Municipio - Chipre'),
(511, 74, 'Municipio - Isla de Navidad'),
(512, 75, 'Municipio - Ciudad del Vaticano'),
(513, 76, 'Municipio - Islas Cocos'),
(514, 77, 'Municipio - Colombia'),
(515, 78, 'Municipio - Comoras'),
(516, 79, 'Municipio - República Democrática del Congo'),
(517, 80, 'Municipio - Congo'),
(518, 81, 'Municipio - Islas Cook'),
(519, 82, 'Municipio - Corea del Norte'),
(520, 83, 'Municipio - Corea del Sur'),
(521, 84, 'Municipio - Costa de Marfil'),
(522, 85, 'Municipio - Costa Rica'),
(523, 86, 'Municipio - Croacia'),
(524, 87, 'Municipio - Cuba'),
(525, 88, 'Municipio - Dinamarca'),
(526, 89, 'Municipio - Dominica'),
(527, 90, 'Municipio - República Dominicana'),
(528, 91, 'Municipio - Ecuador'),
(529, 92, 'Municipio - Egipto'),
(530, 93, 'Municipio - El Salvador'),
(531, 94, 'Municipio - Emiratos Árabes Unidos'),
(532, 95, 'Municipio - Eritrea'),
(533, 96, 'Municipio - Eslovaquia'),
(534, 97, 'Municipio - Eslovenia'),
(535, 98, 'Municipio - España'),
(536, 99, 'Municipio - Islas ultramarinas de Estados Uni'),
(537, 100, 'Municipio - Estados Unidos'),
(538, 101, 'Municipio - Estonia'),
(539, 102, 'Municipio - Etiopía'),
(540, 103, 'Municipio - Islas Feroe'),
(541, 104, 'Municipio - Filipinas'),
(542, 105, 'Municipio - Finlandia'),
(543, 106, 'Municipio - Fiyi'),
(544, 107, 'Municipio - Francia'),
(545, 108, 'Municipio - Gabón'),
(546, 109, 'Municipio - Gambia'),
(547, 110, 'Municipio - Georgia'),
(548, 111, 'Municipio - Islas Georgias del Sur y Sandwich'),
(549, 112, 'Municipio - Ghana'),
(550, 113, 'Municipio - Gibraltar'),
(551, 114, 'Municipio - Granada'),
(552, 115, 'Municipio - Grecia'),
(553, 116, 'Municipio - Groenlandia'),
(554, 117, 'Municipio - Guadalupe'),
(555, 118, 'Municipio - Guam'),
(556, 119, 'Municipio - Guatemala'),
(557, 120, 'Municipio - Guayana Francesa'),
(558, 121, 'Municipio - Guinea'),
(559, 122, 'Municipio - Guinea Ecuatorial'),
(560, 123, 'Municipio - Guinea-Bissau'),
(561, 124, 'Municipio - Guyana'),
(562, 125, 'Municipio - Haití'),
(563, 126, 'Municipio - Islas Heard y McDonald'),
(564, 127, 'Municipio - Honduras'),
(565, 128, 'Municipio - Hong Kong'),
(566, 129, 'Municipio - Hungría'),
(567, 130, 'Municipio - India'),
(568, 131, 'Municipio - Indonesia'),
(569, 132, 'Municipio - Irán'),
(570, 133, 'Municipio - Iraq'),
(571, 134, 'Municipio - Irlanda'),
(572, 135, 'Municipio - Islandia'),
(573, 136, 'Municipio - Israel'),
(574, 137, 'Municipio - Italia'),
(575, 138, 'Municipio - Jamaica'),
(576, 139, 'Municipio - Japón'),
(577, 140, 'Municipio - Jordania'),
(578, 141, 'Municipio - Kazajstán'),
(579, 142, 'Municipio - Kenia'),
(580, 143, 'Municipio - Kirguistán'),
(581, 144, 'Municipio - Kiribati'),
(582, 145, 'Municipio - Kuwait'),
(583, 146, 'Municipio - Laos'),
(584, 147, 'Municipio - Lesotho'),
(585, 148, 'Municipio - Letonia'),
(586, 149, 'Municipio - Líbano'),
(587, 150, 'Municipio - Liberia'),
(588, 151, 'Municipio - Libia'),
(589, 152, 'Municipio - Liechtenstein'),
(590, 153, 'Municipio - Lituania'),
(591, 154, 'Municipio - Luxemburgo'),
(592, 155, 'Municipio - Macao'),
(593, 156, 'Municipio - ARY Macedonia'),
(594, 157, 'Municipio - Madagascar'),
(595, 158, 'Municipio - Malasia'),
(596, 159, 'Municipio - Malawi'),
(597, 160, 'Municipio - Maldivas'),
(598, 161, 'Municipio - Malí'),
(599, 162, 'Municipio - Malta'),
(600, 163, 'Municipio - Islas Malvinas'),
(601, 164, 'Municipio - Islas Marianas del Norte'),
(602, 165, 'Municipio - Marruecos'),
(603, 166, 'Municipio - Islas Marshall'),
(604, 167, 'Municipio - Martinica'),
(605, 168, 'Municipio - Mauricio'),
(606, 169, 'Municipio - Mauritania'),
(607, 170, 'Municipio - Mayotte'),
(608, 171, 'Municipio - México'),
(609, 172, 'Municipio - Micronesia'),
(610, 173, 'Municipio - Moldavia'),
(611, 174, 'Municipio - Mónaco'),
(612, 175, 'Municipio - Mongolia'),
(613, 176, 'Municipio - Montserrat'),
(614, 177, 'Municipio - Mozambique'),
(615, 178, 'Municipio - Myanmar'),
(616, 179, 'Municipio - Namibia'),
(617, 180, 'Municipio - Nauru'),
(618, 181, 'Municipio - Nepal'),
(619, 182, 'Municipio - Nicaragua'),
(620, 183, 'Municipio - Níger'),
(621, 184, 'Municipio - Nigeria'),
(622, 185, 'Municipio - Niue'),
(623, 186, 'Municipio - Isla Norfolk'),
(624, 187, 'Municipio - Noruega'),
(625, 188, 'Municipio - Nueva Caledonia'),
(626, 189, 'Municipio - Nueva Zelanda'),
(627, 190, 'Municipio - Omán'),
(628, 191, 'Municipio - Países Bajos'),
(629, 192, 'Municipio - Pakistán'),
(630, 193, 'Municipio - Palau'),
(631, 194, 'Municipio - Palestina'),
(632, 195, 'Municipio - Panamá'),
(633, 196, 'Municipio - Papúa Nueva Guinea'),
(634, 197, 'Municipio - Paraguay'),
(635, 198, 'Municipio - Perú'),
(636, 199, 'Municipio - Islas Pitcairn'),
(637, 200, 'Municipio - Polinesia Francesa'),
(638, 201, 'Municipio - Polonia'),
(639, 202, 'Municipio - Portugal'),
(640, 203, 'Municipio - Puerto Rico'),
(641, 204, 'Municipio - Qatar'),
(642, 205, 'Municipio - Reino Unido'),
(643, 206, 'Municipio - Reunión'),
(644, 207, 'Municipio - Ruanda'),
(645, 208, 'Municipio - Rumania'),
(646, 209, 'Municipio - Rusia'),
(647, 210, 'Municipio - Sahara Occidental'),
(648, 211, 'Municipio - Islas Salomón'),
(649, 212, 'Municipio - Samoa'),
(650, 213, 'Municipio - Samoa Americana'),
(651, 214, 'Municipio - San Cristóbal y Nevis'),
(652, 215, 'Municipio - San Marino'),
(653, 216, 'Municipio - San Pedro y Miquelón'),
(654, 217, 'Municipio - San Vicente y las Granadinas'),
(655, 218, 'Municipio - Santa Helena'),
(656, 219, 'Municipio - Santa Lucía'),
(657, 220, 'Municipio - Santo Tomé y Príncipe'),
(658, 221, 'Municipio - Senegal'),
(659, 222, 'Municipio - Serbia y Montenegro'),
(660, 223, 'Municipio - Seychelles'),
(661, 224, 'Municipio - Sierra Leona'),
(662, 225, 'Municipio - Singapur'),
(663, 226, 'Municipio - Siria'),
(664, 227, 'Municipio - Somalia'),
(665, 228, 'Municipio - Sri Lanka'),
(666, 229, 'Municipio - Suazilandia'),
(667, 230, 'Municipio - Sudáfrica'),
(668, 231, 'Municipio - Sudán'),
(669, 232, 'Municipio - Suecia'),
(670, 233, 'Municipio - Suiza'),
(671, 234, 'Municipio - Surinam'),
(672, 235, 'Municipio - Svalbard y Jan Mayen'),
(673, 236, 'Municipio - Tailandia'),
(674, 237, 'Municipio - Taiwán'),
(675, 238, 'Municipio - Tanzania'),
(676, 239, 'Municipio - Tayikistán'),
(677, 240, 'Municipio - Territorio Británico del Océano Í'),
(678, 241, 'Municipio - Territorios Australes Franceses'),
(679, 242, 'Municipio - Timor Oriental'),
(680, 243, 'Municipio - Togo'),
(681, 244, 'Municipio - Tokelau'),
(682, 245, 'Municipio - Tonga'),
(683, 246, 'Municipio - Trinidad y Tobago'),
(684, 247, 'Municipio - Túnez'),
(685, 248, 'Municipio - Islas Turcas y Caicos'),
(686, 249, 'Municipio - Turkmenistán'),
(687, 250, 'Municipio - Turquía'),
(688, 251, 'Municipio - Tuvalu'),
(689, 252, 'Municipio - Ucrania'),
(690, 253, 'Municipio - Uganda'),
(691, 254, 'Municipio - Uruguay'),
(692, 255, 'Municipio - Uzbekistán'),
(693, 256, 'Municipio - Vanuatu'),
(694, 257, 'Municipio - Vietnam'),
(695, 258, 'Municipio - Islas Vírgenes Británicas'),
(696, 259, 'Municipio - Islas Vírgenes de los Estados Uni'),
(697, 260, 'Municipio - Wallis y Futuna'),
(698, 261, 'Municipio - Yemen'),
(699, 262, 'Municipio - Yibuti'),
(700, 263, 'Municipio - Zambia'),
(701, 264, 'Municipio - Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `iso` char(2) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `iso`, `pais`) VALUES
(1, 'AF', 'Afganistán'),
(2, 'AX', 'Islas Gland'),
(3, 'AL', 'Albania'),
(4, 'DE', 'Alemania'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antártida'),
(9, 'AG', 'Antigua y Barbuda'),
(10, 'AN', 'Antillas Holandesas'),
(11, 'SA', 'Arabia Saudí'),
(12, 'DZ', 'Argelia'),
(13, 'AR', 'Argentina'),
(14, 'AM', 'Armenia'),
(15, 'AW', 'Aruba'),
(16, 'AU', 'Australia'),
(17, 'AT', 'Austria'),
(18, 'AZ', 'Azerbaiyán'),
(19, 'BS', 'Bahamas'),
(20, 'BH', 'Bahréin'),
(21, 'BD', 'Bangladesh'),
(22, 'BB', 'Barbados'),
(23, 'BY', 'Bielorrusia'),
(24, 'BE', 'Bélgica'),
(25, 'BZ', 'Belice'),
(26, 'BJ', 'Benin'),
(27, 'BM', 'Bermudas'),
(28, 'BT', 'Bhután'),
(29, 'BO', 'Bolivia'),
(30, 'BA', 'Bosnia y Herzegovina'),
(31, 'BW', 'Botsuana'),
(32, 'BV', 'Isla Bouvet'),
(33, 'BR', 'Brasil'),
(34, 'BN', 'Brunéi'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'CV', 'Cabo Verde'),
(39, 'KY', 'Islas Caimán'),
(40, 'KH', 'Camboya'),
(41, 'CM', 'Camerún'),
(42, 'CA', 'Canadá'),
(43, 'CF', 'República Centroafricana'),
(44, 'TD', 'Chad'),
(45, 'CZ', 'República Checa'),
(46, 'CL', 'Chile'),
(47, 'CN', 'China'),
(48, 'CY', 'Chipre'),
(49, 'CX', 'Isla de Navidad'),
(50, 'VA', 'Ciudad del Vaticano'),
(51, 'CC', 'Islas Cocos'),
(52, 'CO', 'Colombia'),
(53, 'KM', 'Comoras'),
(54, 'CD', 'República Democrática del Congo'),
(55, 'CG', 'Congo'),
(56, 'CK', 'Islas Cook'),
(57, 'KP', 'Corea del Norte'),
(58, 'KR', 'Corea del Sur'),
(59, 'CI', 'Costa de Marfil'),
(60, 'CR', 'Costa Rica'),
(61, 'HR', 'Croacia'),
(62, 'CU', 'Cuba'),
(63, 'DK', 'Dinamarca'),
(64, 'DM', 'Dominica'),
(65, 'DO', 'República Dominicana'),
(66, 'EC', 'Ecuador'),
(67, 'EG', 'Egipto'),
(68, 'SV', 'El Salvador'),
(69, 'AE', 'Emiratos Árabes Unidos'),
(70, 'ER', 'Eritrea'),
(71, 'SK', 'Eslovaquia'),
(72, 'SI', 'Eslovenia'),
(73, 'ES', 'España'),
(74, 'UM', 'Islas ultramarinas de Estados Unidos'),
(75, 'US', 'Estados Unidos'),
(76, 'EE', 'Estonia'),
(77, 'ET', 'Etiopía'),
(78, 'FO', 'Islas Feroe'),
(79, 'PH', 'Filipinas'),
(80, 'FI', 'Finlandia'),
(81, 'FJ', 'Fiyi'),
(82, 'FR', 'Francia'),
(83, 'GA', 'Gabón'),
(84, 'GM', 'Gambia'),
(85, 'GE', 'Georgia'),
(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 'GH', 'Ghana'),
(88, 'GI', 'Gibraltar'),
(89, 'GD', 'Granada'),
(90, 'GR', 'Grecia'),
(91, 'GL', 'Groenlandia'),
(92, 'GP', 'Guadalupe'),
(93, 'GU', 'Guam'),
(94, 'GT', 'Guatemala'),
(95, 'GF', 'Guayana Francesa'),
(96, 'GN', 'Guinea'),
(97, 'GQ', 'Guinea Ecuatorial'),
(98, 'GW', 'Guinea-Bissau'),
(99, 'GY', 'Guyana'),
(100, 'HT', 'Haití'),
(101, 'HM', 'Islas Heard y McDonald'),
(102, 'HN', 'Honduras'),
(103, 'HK', 'Hong Kong'),
(104, 'HU', 'Hungría'),
(105, 'IN', 'India'),
(106, 'ID', 'Indonesia'),
(107, 'IR', 'Irán'),
(108, 'IQ', 'Iraq'),
(109, 'IE', 'Irlanda'),
(110, 'IS', 'Islandia'),
(111, 'IL', 'Israel'),
(112, 'IT', 'Italia'),
(113, 'JM', 'Jamaica'),
(114, 'JP', 'Japón'),
(115, 'JO', 'Jordania'),
(116, 'KZ', 'Kazajstán'),
(117, 'KE', 'Kenia'),
(118, 'KG', 'Kirguistán'),
(119, 'KI', 'Kiribati'),
(120, 'KW', 'Kuwait'),
(121, 'LA', 'Laos'),
(122, 'LS', 'Lesotho'),
(123, 'LV', 'Letonia'),
(124, 'LB', 'Líbano'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lituania'),
(129, 'LU', 'Luxemburgo'),
(130, 'MO', 'Macao'),
(131, 'MK', 'ARY Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MY', 'Malasia'),
(134, 'MW', 'Malawi'),
(135, 'MV', 'Maldivas'),
(136, 'ML', 'Malí'),
(137, 'MT', 'Malta'),
(138, 'FK', 'Islas Malvinas'),
(139, 'MP', 'Islas Marianas del Norte'),
(140, 'MA', 'Marruecos'),
(141, 'MH', 'Islas Marshall'),
(142, 'MQ', 'Martinica'),
(143, 'MU', 'Mauricio'),
(144, 'MR', 'Mauritania'),
(145, 'YT', 'Mayotte'),
(146, 'MX', 'México'),
(147, 'FM', 'Micronesia'),
(148, 'MD', 'Moldavia'),
(149, 'MC', 'Mónaco'),
(150, 'MN', 'Mongolia'),
(151, 'MS', 'Montserrat'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Níger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Isla Norfolk'),
(162, 'NO', 'Noruega'),
(163, 'NC', 'Nueva Caledonia'),
(164, 'NZ', 'Nueva Zelanda'),
(165, 'OM', 'Omán'),
(166, 'NL', 'Países Bajos'),
(167, 'PK', 'Pakistán'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestina'),
(170, 'PA', 'Panamá'),
(171, 'PG', 'Papúa Nueva Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Perú'),
(174, 'PN', 'Islas Pitcairn'),
(175, 'PF', 'Polinesia Francesa'),
(176, 'PL', 'Polonia'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'GB', 'Reino Unido'),
(181, 'RE', 'Reunión'),
(182, 'RW', 'Ruanda'),
(183, 'RO', 'Rumania'),
(184, 'RU', 'Rusia'),
(185, 'EH', 'Sahara Occidental'),
(186, 'SB', 'Islas Salomón'),
(187, 'WS', 'Samoa'),
(188, 'AS', 'Samoa Americana'),
(189, 'KN', 'San Cristóbal y Nevis'),
(190, 'SM', 'San Marino'),
(191, 'PM', 'San Pedro y Miquelón'),
(192, 'VC', 'San Vicente y las Granadinas'),
(193, 'SH', 'Santa Helena'),
(194, 'LC', 'Santa Lucía'),
(195, 'ST', 'Santo Tomé y Príncipe'),
(196, 'SN', 'Senegal'),
(197, 'CS', 'Serbia y Montenegro'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leona'),
(200, 'SG', 'Singapur'),
(201, 'SY', 'Siria'),
(202, 'SO', 'Somalia'),
(203, 'LK', 'Sri Lanka'),
(204, 'SZ', 'Suazilandia'),
(205, 'ZA', 'Sudáfrica'),
(206, 'SD', 'Sudán'),
(207, 'SE', 'Suecia'),
(208, 'CH', 'Suiza'),
(209, 'SR', 'Surinam'),
(210, 'SJ', 'Svalbard y Jan Mayen'),
(211, 'TH', 'Tailandia'),
(212, 'TW', 'Taiwán'),
(213, 'TZ', 'Tanzania'),
(214, 'TJ', 'Tayikistán'),
(215, 'IO', 'Territorio Británico del Océano Índico'),
(216, 'TF', 'Territorios Australes Franceses'),
(217, 'TL', 'Timor Oriental'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad y Tobago'),
(222, 'TN', 'Túnez'),
(223, 'TC', 'Islas Turcas y Caicos'),
(224, 'TM', 'Turkmenistán'),
(225, 'TR', 'Turquía'),
(226, 'TV', 'Tuvalu'),
(227, 'UA', 'Ucrania'),
(228, 'UG', 'Uganda'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistán'),
(231, 'VU', 'Vanuatu'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Islas Vírgenes Británicas'),
(235, 'VI', 'Islas Vírgenes de los Estados Unidos'),
(236, 'WF', 'Wallis y Futuna'),
(237, 'YE', 'Yemen'),
(238, 'DJ', 'Yibuti'),
(239, 'ZM', 'Zambia'),
(240, 'ZW', 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquia`
--

CREATE TABLE `parroquia` (
  `id` int(11) NOT NULL,
  `idmunicipio` int(11) NOT NULL,
  `parroquia` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL,
  `permiso` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id`, `permiso`) VALUES
(1, 'Escritorio'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `p_nombre` varchar(20) NOT NULL,
  `s_nombre` varchar(20) DEFAULT NULL,
  `p_apellido` varchar(20) NOT NULL,
  `s_apellido` varchar(20) DEFAULT NULL,
  `genero` varchar(1) NOT NULL,
  `f_nac` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `f_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `cedula`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `genero`, `f_nac`, `email`, `f_creacion`) VALUES
(32, 'V-27693822', 'Alexis', 'Manuel', 'Cáceres', 'Romero', 'M', '1998-06-23', 'alexiscaceresxt_16@hotmail.com', '2019-09-01 21:12:23'),
(33, 'V-9841143', 'Alexis', 'Jose', 'Cáceres', '', 'M', '1967-10-28', 'alexis@gmail.com', '2019-09-01 21:17:08'),
(34, 'V-11693822', 'Ana', 'Maria', 'Romero', 'Cáceres', 'M', '1970-07-25', 'ana@gmail.com', '2019-09-01 21:21:43'),
(35, 'V-27693821', 'Alexis', 'Manuel', 'Cáceres', 'Romero', 'M', '1998-06-23', 'alexiscaceresxt_16@hotmail.com', '2019-09-03 19:39:26'),
(36, 'V-10636774', 'Francia', '', 'Chacón', '', 'F', '1965-09-23', 'francia@gmail.com', '2019-09-05 19:41:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p_seguridad`
--

CREATE TABLE `p_seguridad` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representante`
--

CREATE TABLE `representante` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `instruccion` varchar(20) NOT NULL,
  `oficio` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono`
--

CREATE TABLE `telefono` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `telefono` char(12) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL COMMENT 'M - Móvil\nF - Fijo '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `telefono`
--

INSERT INTO `telefono` (`id`, `idpersona`, `telefono`, `tipo`) VALUES
(7, 32, '0416-2692642', 'M'),
(8, 32, '0255-6630637', 'F'),
(9, 34, '0416-3065905', 'M'),
(10, 35, '0416-2692642', 'M'),
(11, 35, '0255-6630637', 'F'),
(12, 36, '0426-7573749', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `img` varchar(45) DEFAULT NULL,
  `i_fallidos` int(1) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `idpersona`, `usuario`, `clave`, `rol`, `img`, `i_fallidos`, `estatus`) VALUES
(32, 32, 'V-27693822', '12c982f01a06faab4cee68edf173444ca07b1b47971aa75ca677e4e3f3678612', 'Personal', '', 0, 1),
(33, 33, 'V-9841143', '16e7af1e5f0a0303a29ae76fd6e291eb7958bcc019da41036442696a9812f1b5', 'Personal', '', 0, 1),
(34, 34, 'V-11693822', '7e5d343ee1bddc34b4d237acb45c389c46fbb07fb432c1625115a19b1d819b6c', 'Personal', '', 0, 1),
(35, 35, 'V-27693821', '2ca5cb85ebe30a4dea810c6721609b8419169246f438e39b0a790a3813abbf01', 'Personal', '', 0, 1),
(36, 36, 'V-10636774', '08003141207df43a59548eeef14c384aa46f45d8ca208fbd56aa64b3f422d297', 'Docente', '', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idpermiso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`id`, `idusuario`, `idpermiso`) VALUES
(35, 32, 1),
(36, 32, 2),
(37, 33, 1),
(38, 33, 2),
(39, 34, 1),
(40, 34, 2),
(41, 35, 1),
(42, 36, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `u_respuesta`
--

CREATE TABLE `u_respuesta` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpregunta` int(11) NOT NULL,
  `respuesta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `direccion_persona_idx` (`idpersona`),
  ADD KEY `direccion_parroquia_idx` (`idparroquia`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_pais_idx` (`idpais`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipio_estado_idx` (`idestado`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `iso_UNIQUE` (`iso`);

--
-- Indices de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parroquia_municipio_idx` (`idmunicipio`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`);

--
-- Indices de la tabla `p_seguridad`
--
ALTER TABLE `p_seguridad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `representante`
--
ALTER TABLE `representante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersona` (`idpersona`);

--
-- Indices de la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_telefono_idx` (`idpersona`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  ADD KEY `usuario_persona_idx` (`idpersona`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_idx` (`idusuario`),
  ADD KEY `permiso_idx` (`idpermiso`);

--
-- Indices de la tabla `u_respuesta`
--
ALTER TABLE `u_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `respuesta_usuario_idx` (`idusuario`),
  ADD KEY `rusuario_pregunta_idx` (`idpregunta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=702;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `p_seguridad`
--
ALTER TABLE `p_seguridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `representante`
--
ALTER TABLE `representante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `telefono`
--
ALTER TABLE `telefono`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `u_respuesta`
--
ALTER TABLE `u_respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_parroquia` FOREIGN KEY (`idparroquia`) REFERENCES `parroquia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `direccion_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estado`
--
ALTER TABLE `estado`
  ADD CONSTRAINT `estado_pais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `municipio_estado` FOREIGN KEY (`idestado`) REFERENCES `estado` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD CONSTRAINT `parroquia_municipio` FOREIGN KEY (`idmunicipio`) REFERENCES `municipio` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `representante`
--
ALTER TABLE `representante`
  ADD CONSTRAINT `representante_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `persona_telefono` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `u_respuesta`
--
ALTER TABLE `u_respuesta`
  ADD CONSTRAINT `rusuario_pregunta` FOREIGN KEY (`idpregunta`) REFERENCES `p_seguridad` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rusuario_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
