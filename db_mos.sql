-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2020 a las 22:35:16
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

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
-- Estructura de tabla para la tabla `accion`
--

CREATE TABLE `accion` (
  `id` int(11) NOT NULL,
  `accion` char(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` (`id`, `accion`) VALUES
(1, 'ver'),
(2, 'agregar'),
(3, 'editar'),
(4, 'activar-desactivar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambiente`
--

CREATE TABLE `ambiente` (
  `id` int(11) NOT NULL,
  `ambiente` int(2) UNSIGNED ZEROFILL NOT NULL,
  `capacidad` int(11) NOT NULL,
  `ubicacion` char(12) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ambiente`
--

INSERT INTO `ambiente` (`id`, `ambiente`, `capacidad`, `ubicacion`, `estatus`) VALUES
(1, 01, 0, 'Planta baja', 0),
(2, 02, 25, 'Planta baja', 0),
(3, 03, 30, 'Planta baja', 1),
(4, 04, 30, 'Planta baja', 1),
(5, 06, 30, 'Planta baja', 1),
(6, 07, 30, 'Planta baja', 1),
(7, 08, 35, 'Planta baja', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspecto_fisiologicos`
--

CREATE TABLE `aspecto_fisiologicos` (
  `id` int(11) NOT NULL,
  `idplanificacion` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `peso` float NOT NULL,
  `talla` float NOT NULL,
  `todas_vacunas` tinyint(1) NOT NULL,
  `alergia` tinyint(1) NOT NULL,
  `c` tinyint(1) NOT NULL,
  `alimentos` tinyint(1) NOT NULL,
  `utiles` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspecto_socioeconomico`
--

CREATE TABLE `aspecto_socioeconomico` (
  `id` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `tipo_vivienda` varchar(11) NOT NULL,
  `grupo_familiar` int(11) NOT NULL,
  `ingreso_mensual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletin_final`
--

CREATE TABLE `boletin_final` (
  `id` int(11) NOT NULL,
  `idplanificacion` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `idexpresion_literal` int(11) NOT NULL,
  `descriptivo_final` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canaima`
--

CREATE TABLE `canaima` (
  `id` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `posee_canaima` char(2) NOT NULL,
  `condicion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Estructura de tabla para la tabla `direccion_trabajo`
--

CREATE TABLE `direccion_trabajo` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idparroquia` int(11) DEFAULT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diversidad_funcionals`
--

CREATE TABLE `diversidad_funcionals` (
  `id` int(11) NOT NULL,
  `idaspecto_fisiologico` int(11) NOT NULL,
  `diversidad` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_consignados`
--

CREATE TABLE `documentos_consignados` (
  `id` int(11) NOT NULL,
  `idinscripcion` int(11) NOT NULL,
  `fotocopia_cedula_madre` tinyint(1) NOT NULL,
  `fotocopia_cedula_padre` tinyint(1) NOT NULL,
  `fotocopia_cedula_representante` tinyint(1) NOT NULL,
  `fotos_representante` tinyint(1) NOT NULL,
  `fotocopia_partida_nacimiento` tinyint(1) NOT NULL,
  `fotocopia_cedula_estudiante` tinyint(1) NOT NULL,
  `fotocopia_constancia_vacunas` tinyint(1) NOT NULL,
  `fotos_estudiante` tinyint(1) NOT NULL,
  `boleta_promocion` tinyint(1) NOT NULL,
  `constancia_buena_conducta` tinyint(1) NOT NULL,
  `informe_descriptivo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermedads`
--

CREATE TABLE `enfermedads` (
  `id` int(11) NOT NULL,
  `idaspecto_fisiologico` int(11) NOT NULL,
  `enfermedad` varchar(45) NOT NULL
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
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idmadre` int(11) NOT NULL,
  `idpadre` int(11) DEFAULT NULL,
  `parto_multiple` char(2) NOT NULL,
  `orden_nacimiento` int(11) DEFAULT 1,
  `estatus` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expresion_literal`
--

CREATE TABLE `expresion_literal` (
  `id` int(11) NOT NULL,
  `literal` char(1) NOT NULL,
  `interpretacion` char(255) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `expresion_literal`
--

INSERT INTO `expresion_literal` (`id`, `literal`, `interpretacion`, `estatus`) VALUES
(1, 'A', 'El estudiante superó las expectativas', 1),
(2, 'B', 'El estudiante alcanzó las expectativas', 1),
(3, 'C', 'El estudiante cumplió con las expectativas', 1),
(4, 'D', 'El estudiante presenta dificultades', 1),
(5, 'E', 'El estudiante no alcanzó las expectativas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

CREATE TABLE `grado` (
  `id` int(11) NOT NULL,
  `grado` char(1) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_estudiantil`
--

CREATE TABLE `historial_estudiantil` (
  `id` int(11) NOT NULL,
  `periodo_escolar` char(9) NOT NULL,
  `turno` char(50) NOT NULL,
  `grado` char(2) NOT NULL,
  `seccion` char(2) NOT NULL,
  `cedula_docente` char(14) NOT NULL,
  `nombre_docente` char(30) NOT NULL,
  `apellido_docente` char(30) NOT NULL,
  `cedula_estudiante` char(15) NOT NULL,
  `p_nombre_estudiante` char(30) NOT NULL,
  `s_nombre_estudiante` char(30) NOT NULL,
  `p_apellido_estudiante` char(30) NOT NULL,
  `s_apellido_estudiante` char(30) NOT NULL,
  `fecha_nacimiento_estudiante` date NOT NULL,
  `lugar_nacimiento_estudiante` varchar(100) NOT NULL,
  `sexo_estudiante` char(1) NOT NULL,
  `literal` char(1) NOT NULL,
  `observaciones` text NOT NULL,
  `estatus` char(10) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador`
--

CREATE TABLE `indicador` (
  `id` int(11) NOT NULL,
  `idplanificacion` int(11) NOT NULL,
  `idmateria` int(11) NOT NULL,
  `lapso_academico` char(1) NOT NULL,
  `indicador` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador_nota`
--

CREATE TABLE `indicador_nota` (
  `id` int(11) NOT NULL,
  `idplanificacion` int(11) NOT NULL,
  `idindicador` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `lapso_academico` int(11) NOT NULL,
  `nota` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id` int(11) NOT NULL,
  `idperiodo_escolar` int(11) NOT NULL,
  `idplanificacion` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `idrepresentante` int(11) NOT NULL,
  `parentesco` varchar(100) NOT NULL,
  `plantel_procedencia` varchar(255) DEFAULT NULL,
  `observaciones` text NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `estatus` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion`
--

CREATE TABLE `institucion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `idmunicipio` int(11) NOT NULL,
  `idparroquia` int(11) NOT NULL,
  `idestado` int(11) NOT NULL,
  `telefono` char(12) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `dependencia` varchar(100) NOT NULL,
  `cod_dea` char(10) NOT NULL,
  `cod_estadistico` char(10) NOT NULL,
  `cod_dependencia` char(10) NOT NULL,
  `cod_electoral` char(10) DEFAULT NULL,
  `cod_smee` char(25) NOT NULL,
  `fecha_fundada` date NOT NULL,
  `fecha_bolivariana` date NOT NULL,
  `clase_plantel` varchar(45) NOT NULL,
  `categoria` varchar(45) NOT NULL,
  `condicion_estudio` varchar(45) NOT NULL,
  `tipo_matricula` varchar(45) NOT NULL,
  `turno` varchar(45) NOT NULL,
  `horario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `institucion`
--

INSERT INTO `institucion` (`id`, `nombre`, `direccion`, `idmunicipio`, `idparroquia`, `idestado`, `telefono`, `correo`, `dependencia`, `cod_dea`, `cod_estadistico`, `cod_dependencia`, `cod_electoral`, `cod_smee`, `fecha_fundada`, `fecha_bolivariana`, `clase_plantel`, `categoria`, `condicion_estudio`, `tipo_matricula`, `turno`, `horario`) VALUES
(4, 'Escuela Básica Bolivariana \"Miguel Otero Silva\"', 'FINAL CALLE G QTA. ETAPA URB. LA GOAJIRA CONCENTRADO', 289, 739, 17, '0255-6215634', 'migueloterosilva1971@gmail.com', 'Nacional', 'OD00041808', '180527', '006735407', '', '', '1971-01-16', '2005-01-21', 'CONCENTRADO', 'CIVIL', 'EXTERNADO', 'MIXTO', 'INTEGRAL-MIXTO', '8:00 am / 4:00 pm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lapso`
--

CREATE TABLE `lapso` (
  `id` int(11) NOT NULL,
  `lapso` int(11) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lapso_academico`
--

CREATE TABLE `lapso_academico` (
  `id` int(11) NOT NULL,
  `idperiodo_escolar` int(11) NOT NULL,
  `lapso` char(1) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estatus` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar_nacimiento`
--

CREATE TABLE `lugar_nacimiento` (
  `id` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `idparroquia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `modulo` char(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id`, `modulo`) VALUES
(1, 'ambiente'),
(2, 'escritorio'),
(3, 'estudiante'),
(4, 'gestionar-indicador'),
(5, 'grado'),
(6, 'institucion'),
(7, 'lapso'),
(8, 'lapso-academico'),
(9, 'materia'),
(10, 'modulo'),
(11, 'periodo-escolar'),
(12, 'personal'),
(13, 'pic'),
(14, 'planificacion'),
(15, 'representante'),
(16, 'seccion'),
(17, 'usuario'),
(18, 'accion'),
(19, 'inscripcion'),
(20, 'boletin-parcial'),
(21, 'expresion-literal'),
(22, 'boletin-final'),
(23, 'historial-estudiantil'),
(24, 'aspecto-fisiologico');

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

--
-- Volcado de datos para la tabla `parroquia`
--

INSERT INTO `parroquia` (`id`, `idmunicipio`, `parroquia`) VALUES
(1, 1, 'Alto Orinoco'),
(2, 1, 'Huachamacare Acanaña'),
(3, 1, 'Marawaka Toky Shamanaña'),
(4, 1, 'Mavaka Mavaka'),
(5, 1, 'Sierra Parima Parimabé'),
(6, 2, 'Ucata Laja Lisa'),
(7, 2, 'Yapacana Macuruco'),
(8, 2, 'Caname Guarinuma'),
(9, 3, 'Fernando Girón Tovar'),
(10, 3, 'Luis Alberto Gómez'),
(11, 3, 'Pahueña Limón de Parhueña'),
(12, 3, 'Platanillal Platanillal'),
(13, 4, 'Samariapo'),
(14, 4, 'Sipapo'),
(15, 4, 'Munduapo'),
(16, 4, 'Guayapo'),
(17, 5, 'Alto Ventuari'),
(18, 5, 'Medio Ventuari'),
(19, 5, 'Bajo Ventuari'),
(20, 6, 'Victorino'),
(21, 6, 'Comunidad'),
(22, 7, 'Casiquiare'),
(23, 7, 'Cocuy'),
(24, 7, 'San Carlos de Río Negro'),
(25, 7, 'Solano'),
(26, 8, 'Anaco'),
(27, 8, 'San Joaquín'),
(28, 9, 'Cachipo'),
(29, 9, 'Aragua de Barcelona'),
(30, 11, 'Lechería'),
(31, 11, 'El Morro'),
(32, 12, 'Puerto Píritu'),
(33, 12, 'San Miguel'),
(34, 12, 'Sucre'),
(35, 13, 'Valle de Guanape'),
(36, 13, 'Santa Bárbara'),
(37, 14, 'El Chaparro'),
(38, 14, 'Tomás Alfaro'),
(39, 14, 'Calatrava'),
(40, 15, 'Guanta'),
(41, 15, 'Chorrerón'),
(42, 16, 'Mamo'),
(43, 16, 'Soledad'),
(44, 17, 'Mapire'),
(45, 17, 'Piar'),
(46, 17, 'Santa Clara'),
(47, 17, 'San Diego de Cabrutica'),
(48, 17, 'Uverito'),
(49, 17, 'Zuata'),
(50, 18, 'Puerto La Cruz'),
(51, 18, 'Pozuelos'),
(52, 19, 'Onoto'),
(53, 19, 'San Pablo'),
(54, 20, 'San Mateo'),
(55, 20, 'El Carito'),
(56, 20, 'Santa Inés'),
(57, 20, 'La Romereña'),
(58, 21, 'Atapirire'),
(59, 21, 'Boca del Pao'),
(60, 21, 'El Pao'),
(61, 21, 'Pariaguán'),
(62, 22, 'Cantaura'),
(63, 22, 'Libertador'),
(64, 22, 'Santa Rosa'),
(65, 22, 'Urica'),
(66, 23, 'Píritu'),
(67, 23, 'San Francisco'),
(68, 24, 'San José de Guanipa'),
(69, 25, 'Boca de Uchire'),
(70, 25, 'Boca de Chávez'),
(71, 26, 'Pueblo Nuevo'),
(72, 26, 'Santa Ana'),
(73, 27, 'Bergatín'),
(74, 27, 'Caigua'),
(75, 27, 'El Carmen'),
(76, 27, 'El Pilar'),
(77, 27, 'Naricual'),
(78, 27, 'San Crsitóbal'),
(79, 28, 'Edmundo Barrios'),
(80, 28, 'Miguel Otero Silva'),
(81, 29, 'Achaguas'),
(82, 29, 'Apurito'),
(83, 29, 'El Yagual'),
(84, 29, 'Guachara'),
(85, 29, 'Mucuritas'),
(86, 29, 'Queseras del medio'),
(87, 30, 'Biruaca'),
(88, 31, 'Bruzual'),
(89, 31, 'Mantecal'),
(90, 31, 'Quintero'),
(91, 31, 'Rincón Hondo'),
(92, 31, 'San Vicente'),
(93, 32, 'Guasdualito'),
(94, 32, 'Aramendi'),
(95, 32, 'El Amparo'),
(96, 32, 'San Camilo'),
(97, 32, 'Urdaneta'),
(98, 33, 'San Juan de Payara'),
(99, 33, 'Codazzi'),
(100, 33, 'Cunaviche'),
(101, 34, 'Elorza'),
(102, 34, 'La Trinidad'),
(103, 35, 'San Fernando'),
(104, 35, 'El Recreo'),
(105, 35, 'Peñalver'),
(106, 35, 'San Rafael de Atamaica'),
(107, 36, 'Pedro José Ovalles'),
(108, 36, 'Joaquín Crespo'),
(109, 36, 'José Casanova Godoy'),
(110, 36, 'Madre María de San José'),
(111, 36, 'Andrés Eloy Blanco'),
(112, 36, 'Los Tacarigua'),
(113, 36, 'Las Delicias'),
(114, 36, 'Choroní'),
(115, 37, 'Bolívar'),
(116, 38, 'Camatagua'),
(117, 38, 'Carmen de Cura'),
(118, 39, 'Santa Rita'),
(119, 39, 'Francisco de Miranda'),
(120, 39, 'Moseñor Feliciano González'),
(121, 40, 'Santa Cruz'),
(122, 41, 'José Félix Ribas'),
(123, 41, 'Castor Nieves Ríos'),
(124, 41, 'Las Guacamayas'),
(125, 41, 'Pao de Zárate'),
(126, 41, 'Zuata'),
(127, 42, 'José Rafael Revenga'),
(128, 43, 'Palo Negro'),
(129, 43, 'San Martín de Porres'),
(130, 44, 'El Limón'),
(131, 44, 'Caña de Azúcar'),
(132, 45, 'Ocumare de la Costa'),
(133, 46, 'San Casimiro'),
(134, 46, 'Güiripa'),
(135, 46, 'Ollas de Caramacate'),
(136, 46, 'Valle Morín'),
(137, 47, 'San Sebastían'),
(138, 48, 'Turmero'),
(139, 48, 'Arevalo Aponte'),
(140, 48, 'Chuao'),
(141, 48, 'Samán de Güere'),
(142, 48, 'Alfredo Pacheco Miranda'),
(143, 49, 'Santos Michelena'),
(144, 49, 'Tiara'),
(145, 50, 'Cagua'),
(146, 50, 'Bella Vista'),
(147, 51, 'Tovar'),
(148, 52, 'Urdaneta'),
(149, 52, 'Las Peñitas'),
(150, 52, 'San Francisco de Cara'),
(151, 52, 'Taguay'),
(152, 53, 'Zamora'),
(153, 53, 'Magdaleno'),
(154, 53, 'San Francisco de Asís'),
(155, 53, 'Valles de Tucutunemo'),
(156, 53, 'Augusto Mijares'),
(157, 54, 'Sabaneta'),
(158, 54, 'Juan Antonio Rodríguez Domínguez'),
(159, 55, 'El Cantón'),
(160, 55, 'Santa Cruz de Guacas'),
(161, 55, 'Puerto Vivas'),
(162, 56, 'Ticoporo'),
(163, 56, 'Nicolás Pulido'),
(164, 56, 'Andrés Bello'),
(165, 57, 'Arismendi'),
(166, 57, 'Guadarrama'),
(167, 57, 'La Unión'),
(168, 57, 'San Antonio'),
(169, 58, 'Barinas'),
(170, 58, 'Alberto Arvelo Larriva'),
(171, 58, 'San Silvestre'),
(172, 58, 'Santa Inés'),
(173, 58, 'Santa Lucía'),
(174, 58, 'Torumos'),
(175, 58, 'El Carmen'),
(176, 58, 'Rómulo Betancourt'),
(177, 58, 'Corazón de Jesús'),
(178, 58, 'Ramón Ignacio Méndez'),
(179, 58, 'Alto Barinas'),
(180, 58, 'Manuel Palacio Fajardo'),
(181, 58, 'Juan Antonio Rodríguez Domínguez'),
(182, 58, 'Dominga Ortiz de Páez'),
(183, 59, 'Barinitas'),
(184, 59, 'Altamira de Cáceres'),
(185, 59, 'Calderas'),
(186, 60, 'Barrancas'),
(187, 60, 'El Socorro'),
(188, 60, 'Mazparrito'),
(189, 61, 'Santa Bárbara'),
(190, 61, 'Pedro Briceño Méndez'),
(191, 61, 'Ramón Ignacio Méndez'),
(192, 61, 'José Ignacio del Pumar'),
(193, 62, 'Obispos'),
(194, 62, 'Guasimitos'),
(195, 62, 'El Real'),
(196, 62, 'La Luz'),
(197, 63, 'Ciudad Bolívia'),
(198, 63, 'José Ignacio Briceño'),
(199, 63, 'José Félix Ribas'),
(200, 63, 'Páez'),
(201, 64, 'Libertad'),
(202, 64, 'Dolores'),
(203, 64, 'Santa Rosa'),
(204, 64, 'Palacio Fajardo'),
(205, 65, 'Ciudad de Nutrias'),
(206, 65, 'El Regalo'),
(207, 65, 'Puerto Nutrias'),
(208, 65, 'Santa Catalina'),
(209, 66, 'Cachamay'),
(210, 66, 'Chirica'),
(211, 66, 'Dalla Costa'),
(212, 66, 'Once de Abril'),
(213, 66, 'Simón Bolívar'),
(214, 66, 'Unare'),
(215, 66, 'Universidad'),
(216, 66, 'Vista al Sol'),
(217, 66, 'Pozo Verde'),
(218, 66, 'Yocoima'),
(219, 66, '5 de Julio'),
(220, 67, 'Cedeño'),
(221, 67, 'Altagracia'),
(222, 67, 'Ascensión Farreras'),
(223, 67, 'Guaniamo'),
(224, 67, 'La Urbana'),
(225, 67, 'Pijiguaos'),
(226, 68, 'El Callao'),
(227, 69, 'Gran Sabana'),
(228, 69, 'Ikabarú'),
(229, 70, 'Catedral'),
(230, 70, 'Zea'),
(231, 70, 'Orinoco'),
(232, 70, 'José Antonio Páez'),
(233, 70, 'Marhuanta'),
(234, 70, 'Agua Salada'),
(235, 70, 'Vista Hermosa'),
(236, 70, 'La Sabanita'),
(237, 70, 'Panapana'),
(238, 71, 'Andrés Eloy Blanco'),
(239, 71, 'Pedro Cova'),
(240, 72, 'Raúl Leoni'),
(241, 72, 'Barceloneta'),
(242, 72, 'Santa Bárbara'),
(243, 72, 'San Francisco'),
(244, 73, 'Roscio'),
(245, 73, 'Salóm'),
(246, 74, 'Sifontes'),
(247, 74, 'Dalla Costa'),
(248, 74, 'San Isidro'),
(249, 75, 'Sucre'),
(250, 75, 'Aripao'),
(251, 75, 'Guarataro'),
(252, 75, 'Las Majadas'),
(253, 75, 'Moitaco'),
(254, 76, 'Padre Pedro Chien'),
(255, 76, 'Río Grande'),
(256, 77, 'Bejuma'),
(257, 77, 'Canoabo'),
(258, 77, 'Simón Bolívar'),
(259, 78, 'Güigüe'),
(260, 78, 'Carabobo'),
(261, 78, 'Tacarigua'),
(262, 79, 'Mariara'),
(263, 79, 'Aguas Calientes'),
(264, 80, 'Ciudad Alianza'),
(265, 80, 'Guacara'),
(266, 80, 'Yagua'),
(267, 81, 'Morón'),
(268, 81, 'Yagua'),
(269, 82, 'Tocuyito'),
(270, 82, 'Independencia'),
(271, 83, 'Los Guayos'),
(272, 84, 'Miranda'),
(273, 85, 'Montalbán'),
(274, 86, 'Naguanagua'),
(275, 87, 'Bartolomé Salóm'),
(276, 87, 'Democracia'),
(277, 87, 'Fraternidad'),
(278, 87, 'Goaigoaza'),
(279, 87, 'Juan José Flores'),
(280, 87, 'Unión'),
(281, 87, 'Borburata'),
(282, 87, 'Patanemo'),
(283, 88, 'San Diego'),
(284, 89, 'San Joaquín'),
(285, 90, 'Candelaria'),
(286, 90, 'Catedral'),
(287, 90, 'El Socorro'),
(288, 90, 'Miguel Peña'),
(289, 90, 'Rafael Urdaneta'),
(290, 90, 'San Blas'),
(291, 90, 'San José'),
(292, 90, 'Santa Rosa'),
(293, 90, 'Negro Primero'),
(294, 91, 'Cojedes'),
(295, 91, 'Juan de Mata Suárez'),
(296, 92, 'Tinaquillo'),
(297, 93, 'El Baúl'),
(298, 93, 'Sucre'),
(299, 94, 'La Aguadita'),
(300, 94, 'Macapo'),
(301, 95, 'El Pao'),
(302, 96, 'El Amparo'),
(303, 96, 'Libertad de Cojedes'),
(304, 97, 'Rómulo Gallegos'),
(305, 98, 'San Carlos de Austria'),
(306, 98, 'Juan Ángel Bravo'),
(307, 98, 'Manuel Manrique'),
(308, 99, 'General en Jefe José Laurencio Silva'),
(309, 100, 'Curiapo'),
(310, 100, 'Almirante Luis Brión'),
(311, 100, 'Francisco Aniceto Lugo'),
(312, 100, 'Manuel Renaud'),
(313, 100, 'Padre Barral'),
(314, 100, 'Santos de Abelgas'),
(315, 101, 'Imataca'),
(316, 101, 'Cinco de Julio'),
(317, 101, 'Juan Bautista Arismendi'),
(318, 101, 'Manuel Piar'),
(319, 101, 'Rómulo Gallegos'),
(320, 102, 'Pedernales'),
(321, 102, 'Luis Beltrán Prieto Figueroa'),
(322, 103, 'San José (Delta Amacuro)'),
(323, 103, 'José Vidal Marcano'),
(324, 103, 'Juan Millán'),
(325, 103, 'Leonardo Ruíz Pineda'),
(326, 103, 'Mariscal Antonio José de Sucre'),
(327, 103, 'Monseñor Argimiro García'),
(328, 103, 'San Rafael (Delta Amacuro)'),
(329, 103, 'Virgen del Valle'),
(330, 10, 'Clarines'),
(331, 10, 'Guanape'),
(332, 10, 'Sabana de Uchire'),
(333, 104, 'Capadare'),
(334, 104, 'La Pastora'),
(335, 104, 'Libertador'),
(336, 104, 'San Juan de los Cayos'),
(337, 105, 'Aracua'),
(338, 105, 'La Peña'),
(339, 105, 'San Luis'),
(340, 106, 'Bariro'),
(341, 106, 'Borojó'),
(342, 106, 'Capatárida'),
(343, 106, 'Guajiro'),
(344, 106, 'Seque'),
(345, 106, 'Zazárida'),
(346, 106, 'Valle de Eroa'),
(347, 107, 'Cacique Manaure'),
(348, 108, 'Norte'),
(349, 108, 'Carirubana'),
(350, 108, 'Santa Ana'),
(351, 108, 'Urbana Punta Cardón'),
(352, 109, 'La Vela de Coro'),
(353, 109, 'Acurigua'),
(354, 109, 'Guaibacoa'),
(355, 109, 'Las Calderas'),
(356, 109, 'Macoruca'),
(357, 110, 'Dabajuro'),
(358, 111, 'Agua Clara'),
(359, 111, 'Avaria'),
(360, 111, 'Pedregal'),
(361, 111, 'Piedra Grande'),
(362, 111, 'Purureche'),
(363, 112, 'Adaure'),
(364, 112, 'Adícora'),
(365, 112, 'Baraived'),
(366, 112, 'Buena Vista'),
(367, 112, 'Jadacaquiva'),
(368, 112, 'El Vínculo'),
(369, 112, 'El Hato'),
(370, 112, 'Moruy'),
(371, 112, 'Pueblo Nuevo'),
(372, 113, 'Agua Larga'),
(373, 113, 'El Paují'),
(374, 113, 'Independencia'),
(375, 113, 'Mapararí'),
(376, 114, 'Agua Linda'),
(377, 114, 'Araurima'),
(378, 114, 'Jacura'),
(379, 115, 'Tucacas'),
(380, 115, 'Boca de Aroa'),
(381, 116, 'Los Taques'),
(382, 116, 'Judibana'),
(383, 117, 'Mene de Mauroa'),
(384, 117, 'San Félix'),
(385, 117, 'Casigua'),
(386, 118, 'Guzmán Guillermo'),
(387, 118, 'Mitare'),
(388, 118, 'Río Seco'),
(389, 118, 'Sabaneta'),
(390, 118, 'San Antonio'),
(391, 118, 'San Gabriel'),
(392, 118, 'Santa Ana'),
(393, 119, 'Boca del Tocuyo'),
(394, 119, 'Chichiriviche'),
(395, 119, 'Tocuyo de la Costa'),
(396, 120, 'Palmasola'),
(397, 121, 'Cabure'),
(398, 121, 'Colina'),
(399, 121, 'Curimagua'),
(400, 122, 'San José de la Costa'),
(401, 122, 'Píritu'),
(402, 123, 'San Francisco'),
(403, 124, 'Sucre'),
(404, 124, 'Pecaya'),
(405, 125, 'Tocópero'),
(406, 126, 'El Charal'),
(407, 126, 'Las Vegas del Tuy'),
(408, 126, 'Santa Cruz de Bucaral'),
(409, 127, 'Bruzual'),
(410, 127, 'Urumaco'),
(411, 128, 'Puerto Cumarebo'),
(412, 128, 'La Ciénaga'),
(413, 128, 'La Soledad'),
(414, 128, 'Pueblo Cumarebo'),
(415, 128, 'Zazárida'),
(416, 113, 'Churuguara'),
(417, 129, 'Camaguán'),
(418, 129, 'Puerto Miranda'),
(419, 129, 'Uverito'),
(420, 130, 'Chaguaramas'),
(421, 131, 'El Socorro'),
(422, 132, 'Tucupido'),
(423, 132, 'San Rafael de Laya'),
(424, 133, 'Altagracia de Orituco'),
(425, 133, 'San Rafael de Orituco'),
(426, 133, 'San Francisco Javier de Lezama'),
(427, 133, 'Paso Real de Macaira'),
(428, 133, 'Carlos Soublette'),
(429, 133, 'San Francisco de Macaira'),
(430, 133, 'Libertad de Orituco'),
(431, 134, 'Cantaclaro'),
(432, 134, 'San Juan de los Morros'),
(433, 134, 'Parapara'),
(434, 135, 'El Sombrero'),
(435, 135, 'Sosa'),
(436, 136, 'Las Mercedes'),
(437, 136, 'Cabruta'),
(438, 136, 'Santa Rita de Manapire'),
(439, 137, 'Valle de la Pascua'),
(440, 137, 'Espino'),
(441, 138, 'San José de Unare'),
(442, 138, 'Zaraza'),
(443, 139, 'San José de Tiznados'),
(444, 139, 'San Francisco de Tiznados'),
(445, 139, 'San Lorenzo de Tiznados'),
(446, 139, 'Ortiz'),
(447, 140, 'Guayabal'),
(448, 140, 'Cazorla'),
(449, 141, 'San José de Guaribe'),
(450, 141, 'Uveral'),
(451, 142, 'Santa María de Ipire'),
(452, 142, 'Altamira'),
(453, 143, 'El Calvario'),
(454, 143, 'El Rastro'),
(455, 143, 'Guardatinajas'),
(456, 143, 'Capital Urbana Calabozo'),
(457, 144, 'Quebrada Honda de Guache'),
(458, 144, 'Pío Tamayo'),
(459, 144, 'Yacambú'),
(460, 145, 'Fréitez'),
(461, 145, 'José María Blanco'),
(462, 146, 'Catedral'),
(463, 146, 'Concepción'),
(464, 146, 'El Cují'),
(465, 146, 'Juan de Villegas'),
(466, 146, 'Santa Rosa'),
(467, 146, 'Tamaca'),
(468, 146, 'Unión'),
(469, 146, 'Aguedo Felipe Alvarado'),
(470, 146, 'Buena Vista'),
(471, 146, 'Juárez'),
(472, 147, 'Juan Bautista Rodríguez'),
(473, 147, 'Cuara'),
(474, 147, 'Diego de Lozada'),
(475, 147, 'Paraíso de San José'),
(476, 147, 'San Miguel'),
(477, 147, 'Tintorero'),
(478, 147, 'José Bernardo Dorante'),
(479, 147, 'Coronel Mariano Peraza '),
(480, 148, 'Bolívar'),
(481, 148, 'Anzoátegui'),
(482, 148, 'Guarico'),
(483, 148, 'Hilario Luna y Luna'),
(484, 148, 'Humocaro Alto'),
(485, 148, 'Humocaro Bajo'),
(486, 148, 'La Candelaria'),
(487, 148, 'Morán'),
(488, 149, 'Cabudare'),
(489, 149, 'José Gregorio Bastidas'),
(490, 149, 'Agua Viva'),
(491, 150, 'Sarare'),
(492, 150, 'Buría'),
(493, 150, 'Gustavo Vegas León'),
(494, 151, 'Trinidad Samuel'),
(495, 151, 'Antonio Díaz'),
(496, 151, 'Camacaro'),
(497, 151, 'Castañeda'),
(498, 151, 'Cecilio Zubillaga'),
(499, 151, 'Chiquinquirá'),
(500, 151, 'El Blanco'),
(501, 151, 'Espinoza de los Monteros'),
(502, 151, 'Lara'),
(503, 151, 'Las Mercedes'),
(504, 151, 'Manuel Morillo'),
(505, 151, 'Montaña Verde'),
(506, 151, 'Montes de Oca'),
(507, 151, 'Torres'),
(508, 151, 'Heriberto Arroyo'),
(509, 151, 'Reyes Vargas'),
(510, 151, 'Altagracia'),
(511, 152, 'Siquisique'),
(512, 152, 'Moroturo'),
(513, 152, 'San Miguel'),
(514, 152, 'Xaguas'),
(515, 179, 'Presidente Betancourt'),
(516, 179, 'Presidente Páez'),
(517, 179, 'Presidente Rómulo Gallegos'),
(518, 179, 'Gabriel Picón González'),
(519, 179, 'Héctor Amable Mora'),
(520, 179, 'José Nucete Sardi'),
(521, 179, 'Pulido Méndez'),
(522, 180, 'La Azulita'),
(523, 181, 'Santa Cruz de Mora'),
(524, 181, 'Mesa Bolívar'),
(525, 181, 'Mesa de Las Palmas'),
(526, 182, 'Aricagua'),
(527, 182, 'San Antonio'),
(528, 183, 'Canagua'),
(529, 183, 'Capurí'),
(530, 183, 'Chacantá'),
(531, 183, 'El Molino'),
(532, 183, 'Guaimaral'),
(533, 183, 'Mucutuy'),
(534, 183, 'Mucuchachí'),
(535, 184, 'Fernández Peña'),
(536, 184, 'Matriz'),
(537, 184, 'Montalbán'),
(538, 184, 'Acequias'),
(539, 184, 'Jají'),
(540, 184, 'La Mesa'),
(541, 184, 'San José del Sur'),
(542, 185, 'Tucaní'),
(543, 185, 'Florencio Ramírez'),
(544, 186, 'Santo Domingo'),
(545, 186, 'Las Piedras'),
(546, 187, 'Guaraque'),
(547, 187, 'Mesa de Quintero'),
(548, 187, 'Río Negro'),
(549, 188, 'Arapuey'),
(550, 188, 'Palmira'),
(551, 189, 'San Cristóbal de Torondoy'),
(552, 189, 'Torondoy'),
(553, 190, 'Antonio Spinetti Dini'),
(554, 190, 'Arias'),
(555, 190, 'Caracciolo Parra Pérez'),
(556, 190, 'Domingo Peña'),
(557, 190, 'El Llano'),
(558, 190, 'Gonzalo Picón Febres'),
(559, 190, 'Jacinto Plaza'),
(560, 190, 'Juan Rodríguez Suárez'),
(561, 190, 'Lasso de la Vega'),
(562, 190, 'Mariano Picón Salas'),
(563, 190, 'Milla'),
(564, 190, 'Osuna Rodríguez'),
(565, 190, 'Sagrario'),
(566, 190, 'El Morro'),
(567, 190, 'Los Nevados'),
(568, 191, 'Andrés Eloy Blanco'),
(569, 191, 'La Venta'),
(570, 191, 'Piñango'),
(571, 191, 'Timotes'),
(572, 192, 'Eloy Paredes'),
(573, 192, 'San Rafael de Alcázar'),
(574, 192, 'Santa Elena de Arenales'),
(575, 193, 'Santa María de Caparo'),
(576, 194, 'Pueblo Llano'),
(577, 195, 'Cacute'),
(578, 195, 'La Toma'),
(579, 195, 'Mucuchíes'),
(580, 195, 'Mucurubá'),
(581, 195, 'San Rafael'),
(582, 196, 'Gerónimo Maldonado'),
(583, 196, 'Bailadores'),
(584, 197, 'Tabay'),
(585, 198, 'Chiguará'),
(586, 198, 'Estánquez'),
(587, 198, 'Lagunillas'),
(588, 198, 'La Trampa'),
(589, 198, 'Pueblo Nuevo del Sur'),
(590, 198, 'San Juan'),
(591, 199, 'El Amparo'),
(592, 199, 'El Llano'),
(593, 199, 'San Francisco'),
(594, 199, 'Tovar'),
(595, 200, 'Independencia'),
(596, 200, 'María de la Concepción Palacios Blanco'),
(597, 200, 'Nueva Bolivia'),
(598, 200, 'Santa Apolonia'),
(599, 201, 'Caño El Tigre'),
(600, 201, 'Zea'),
(601, 223, 'Aragüita'),
(602, 223, 'Arévalo González'),
(603, 223, 'Capaya'),
(604, 223, 'Caucagua'),
(605, 223, 'Panaquire'),
(606, 223, 'Ribas'),
(607, 223, 'El Café'),
(608, 223, 'Marizapa'),
(609, 224, 'Cumbo'),
(610, 224, 'San José de Barlovento'),
(611, 225, 'El Cafetal'),
(612, 225, 'Las Minas'),
(613, 225, 'Nuestra Señora del Rosario'),
(614, 226, 'Higuerote'),
(615, 226, 'Curiepe'),
(616, 226, 'Tacarigua de Brión'),
(617, 227, 'Mamporal'),
(618, 228, 'Carrizal'),
(619, 229, 'Chacao'),
(620, 230, 'Charallave'),
(621, 230, 'Las Brisas'),
(622, 231, 'El Hatillo'),
(623, 232, 'Altagracia de la Montaña'),
(624, 232, 'Cecilio Acosta'),
(625, 232, 'Los Teques'),
(626, 232, 'El Jarillo'),
(627, 232, 'San Pedro'),
(628, 232, 'Tácata'),
(629, 232, 'Paracotos'),
(630, 233, 'Cartanal'),
(631, 233, 'Santa Teresa del Tuy'),
(632, 234, 'La Democracia'),
(633, 234, 'Ocumare del Tuy'),
(634, 234, 'Santa Bárbara'),
(635, 235, 'San Antonio de los Altos'),
(636, 236, 'Río Chico'),
(637, 236, 'El Guapo'),
(638, 236, 'Tacarigua de la Laguna'),
(639, 236, 'Paparo'),
(640, 236, 'San Fernando del Guapo'),
(641, 237, 'Santa Lucía del Tuy'),
(642, 238, 'Cúpira'),
(643, 238, 'Machurucuto'),
(644, 239, 'Guarenas'),
(645, 240, 'San Antonio de Yare'),
(646, 240, 'San Francisco de Yare'),
(647, 241, 'Leoncio Martínez'),
(648, 241, 'Petare'),
(649, 241, 'Caucagüita'),
(650, 241, 'Filas de Mariche'),
(651, 241, 'La Dolorita'),
(652, 242, 'Cúa'),
(653, 242, 'Nueva Cúa'),
(654, 243, 'Guatire'),
(655, 243, 'Bolívar'),
(656, 258, 'San Antonio de Maturín'),
(657, 258, 'San Francisco de Maturín'),
(658, 259, 'Aguasay'),
(659, 260, 'Caripito'),
(660, 261, 'El Guácharo'),
(661, 261, 'La Guanota'),
(662, 261, 'Sabana de Piedra'),
(663, 261, 'San Agustín'),
(664, 261, 'Teresen'),
(665, 261, 'Caripe'),
(666, 262, 'Areo'),
(667, 262, 'Capital Cedeño'),
(668, 262, 'San Félix de Cantalicio'),
(669, 262, 'Viento Fresco'),
(670, 263, 'El Tejero'),
(671, 263, 'Punta de Mata'),
(672, 264, 'Chaguaramas'),
(673, 264, 'Las Alhuacas'),
(674, 264, 'Tabasca'),
(675, 264, 'Temblador'),
(676, 265, 'Alto de los Godos'),
(677, 265, 'Boquerón'),
(678, 265, 'Las Cocuizas'),
(679, 265, 'La Cruz'),
(680, 265, 'San Simón'),
(681, 265, 'El Corozo'),
(682, 265, 'El Furrial'),
(683, 265, 'Jusepín'),
(684, 265, 'La Pica'),
(685, 265, 'San Vicente'),
(686, 266, 'Aparicio'),
(687, 266, 'Aragua de Maturín'),
(688, 266, 'Chaguamal'),
(689, 266, 'El Pinto'),
(690, 266, 'Guanaguana'),
(691, 266, 'La Toscana'),
(692, 266, 'Taguaya'),
(693, 267, 'Cachipo'),
(694, 267, 'Quiriquire'),
(695, 268, 'Santa Bárbara'),
(696, 269, 'Barrancas'),
(697, 269, 'Los Barrancos de Fajardo'),
(698, 270, 'Uracoa'),
(699, 271, 'Antolín del Campo'),
(700, 272, 'Arismendi'),
(701, 273, 'García'),
(702, 273, 'Francisco Fajardo'),
(703, 274, 'Bolívar'),
(704, 274, 'Guevara'),
(705, 274, 'Matasiete'),
(706, 274, 'Santa Ana'),
(707, 274, 'Sucre'),
(708, 275, 'Aguirre'),
(709, 275, 'Maneiro'),
(710, 276, 'Adrián'),
(711, 276, 'Juan Griego'),
(712, 276, 'Yaguaraparo'),
(713, 277, 'Porlamar'),
(714, 278, 'San Francisco de Macanao'),
(715, 278, 'Boca de Río'),
(716, 279, 'Tubores'),
(717, 279, 'Los Baleales'),
(718, 280, 'Vicente Fuentes'),
(719, 280, 'Villalba'),
(720, 281, 'San Juan Bautista'),
(721, 281, 'Zabala'),
(722, 283, 'Capital Araure'),
(723, 283, 'Río Acarigua'),
(724, 284, 'Capital Esteller'),
(725, 284, 'Uveral'),
(726, 285, 'Guanare'),
(727, 285, 'Córdoba'),
(728, 285, 'San José de la Montaña'),
(729, 285, 'San Juan de Guanaguanare'),
(730, 285, 'Virgen de la Coromoto'),
(731, 286, 'Guanarito'),
(732, 286, 'Trinidad de la Capilla'),
(733, 286, 'Divina Pastora'),
(734, 287, 'Monseñor José Vicente de Unda'),
(735, 287, 'Peña Blanca'),
(736, 288, 'Capital Ospino'),
(737, 288, 'Aparición'),
(738, 288, 'La Estación'),
(739, 289, 'Páez'),
(740, 289, 'Payara'),
(741, 289, 'Pimpinela'),
(742, 289, 'Ramón Peraza'),
(743, 290, 'Papelón'),
(744, 290, 'Caño Delgadito'),
(745, 291, 'San Genaro de Boconoito'),
(746, 291, 'Antolín Tovar'),
(747, 292, 'San Rafael de Onoto'),
(748, 292, 'Santa Fe'),
(749, 292, 'Thermo Morles'),
(750, 293, 'Santa Rosalía'),
(751, 293, 'Florida'),
(752, 294, 'Sucre'),
(753, 294, 'Concepción'),
(754, 294, 'San Rafael de Palo Alzado'),
(755, 294, 'Uvencio Antonio Velásquez'),
(756, 294, 'San José de Saguaz'),
(757, 294, 'Villa Rosa'),
(758, 295, 'Turén'),
(759, 295, 'Canelones'),
(760, 295, 'Santa Cruz'),
(761, 295, 'San Isidro Labrador'),
(762, 296, 'Mariño'),
(763, 296, 'Rómulo Gallegos'),
(764, 297, 'San José de Aerocuar'),
(765, 297, 'Tavera Acosta'),
(766, 298, 'Río Caribe'),
(767, 298, 'Antonio José de Sucre'),
(768, 298, 'El Morro de Puerto Santo'),
(769, 298, 'Puerto Santo'),
(770, 298, 'San Juan de las Galdonas'),
(771, 299, 'El Pilar'),
(772, 299, 'El Rincón'),
(773, 299, 'General Francisco Antonio Váquez'),
(774, 299, 'Guaraúnos'),
(775, 299, 'Tunapuicito'),
(776, 299, 'Unión'),
(777, 300, 'Santa Catalina'),
(778, 300, 'Santa Rosa'),
(779, 300, 'Santa Teresa'),
(780, 300, 'Bolívar'),
(781, 300, 'Maracapana'),
(782, 302, 'Libertad'),
(783, 302, 'El Paujil'),
(784, 302, 'Yaguaraparo'),
(785, 303, 'Cruz Salmerón Acosta'),
(786, 303, 'Chacopata'),
(787, 303, 'Manicuare'),
(788, 304, 'Tunapuy'),
(789, 304, 'Campo Elías'),
(790, 305, 'Irapa'),
(791, 305, 'Campo Claro'),
(792, 305, 'Maraval'),
(793, 305, 'San Antonio de Irapa'),
(794, 305, 'Soro'),
(795, 306, 'Mejía'),
(796, 307, 'Cumanacoa'),
(797, 307, 'Arenas'),
(798, 307, 'Aricagua'),
(799, 307, 'Cogollar'),
(800, 307, 'San Fernando'),
(801, 307, 'San Lorenzo'),
(802, 308, 'Villa Frontado (Muelle de Cariaco)'),
(803, 308, 'Catuaro'),
(804, 308, 'Rendón'),
(805, 308, 'San Cruz'),
(806, 308, 'Santa María'),
(807, 309, 'Altagracia'),
(808, 309, 'Santa Inés'),
(809, 309, 'Valentín Valiente'),
(810, 309, 'Ayacucho'),
(811, 309, 'San Juan'),
(812, 309, 'Raúl Leoni'),
(813, 309, 'Gran Mariscal'),
(814, 310, 'Cristóbal Colón'),
(815, 310, 'Bideau'),
(816, 310, 'Punta de Piedras'),
(817, 310, 'Güiria'),
(818, 341, 'Andrés Bello'),
(819, 342, 'Antonio Rómulo Costa'),
(820, 343, 'Ayacucho'),
(821, 343, 'Rivas Berti'),
(822, 343, 'San Pedro del Río'),
(823, 344, 'Bolívar'),
(824, 344, 'Palotal'),
(825, 344, 'General Juan Vicente Gómez'),
(826, 344, 'Isaías Medina Angarita'),
(827, 345, 'Cárdenas'),
(828, 345, 'Amenodoro Ángel Lamus'),
(829, 345, 'La Florida'),
(830, 346, 'Córdoba'),
(831, 347, 'Fernández Feo'),
(832, 347, 'Alberto Adriani'),
(833, 347, 'Santo Domingo'),
(834, 348, 'Francisco de Miranda'),
(835, 349, 'García de Hevia'),
(836, 349, 'Boca de Grita'),
(837, 349, 'José Antonio Páez'),
(838, 350, 'Guásimos'),
(839, 351, 'Independencia'),
(840, 351, 'Juan Germán Roscio'),
(841, 351, 'Román Cárdenas'),
(842, 352, 'Jáuregui'),
(843, 352, 'Emilio Constantino Guerrero'),
(844, 352, 'Monseñor Miguel Antonio Salas'),
(845, 353, 'José María Vargas'),
(846, 354, 'Junín'),
(847, 354, 'La Petrólea'),
(848, 354, 'Quinimarí'),
(849, 354, 'Bramón'),
(850, 355, 'Libertad'),
(851, 355, 'Cipriano Castro'),
(852, 355, 'Manuel Felipe Rugeles'),
(853, 356, 'Libertador'),
(854, 356, 'Doradas'),
(855, 356, 'Emeterio Ochoa'),
(856, 356, 'San Joaquín de Navay'),
(857, 357, 'Lobatera'),
(858, 357, 'Constitución'),
(859, 358, 'Michelena'),
(860, 359, 'Panamericano'),
(861, 359, 'La Palmita'),
(862, 360, 'Pedro María Ureña'),
(863, 360, 'Nueva Arcadia'),
(864, 361, 'Delicias'),
(865, 361, 'Pecaya'),
(866, 362, 'Samuel Darío Maldonado'),
(867, 362, 'Boconó'),
(868, 362, 'Hernández'),
(869, 363, 'La Concordia'),
(870, 363, 'San Juan Bautista'),
(871, 363, 'Pedro María Morantes'),
(872, 363, 'San Sebastián'),
(873, 363, 'Dr. Francisco Romero Lobo'),
(874, 364, 'Seboruco'),
(875, 365, 'Simón Rodríguez'),
(876, 366, 'Sucre'),
(877, 366, 'Eleazar López Contreras'),
(878, 366, 'San Pablo'),
(879, 367, 'Torbes'),
(880, 368, 'Uribante'),
(881, 368, 'Cárdenas'),
(882, 368, 'Juan Pablo Peñalosa'),
(883, 368, 'Potosí'),
(884, 369, 'San Judas Tadeo'),
(885, 370, 'Araguaney'),
(886, 370, 'El Jaguito'),
(887, 370, 'La Esperanza'),
(888, 370, 'Santa Isabel'),
(889, 371, 'Boconó'),
(890, 371, 'El Carmen'),
(891, 371, 'Mosquey'),
(892, 371, 'Ayacucho'),
(893, 371, 'Burbusay'),
(894, 371, 'General Ribas'),
(895, 371, 'Guaramacal'),
(896, 371, 'Vega de Guaramacal'),
(897, 371, 'Monseñor Jáuregui'),
(898, 371, 'Rafael Rangel'),
(899, 371, 'San Miguel'),
(900, 371, 'San José'),
(901, 372, 'Sabana Grande'),
(902, 372, 'Cheregüé'),
(903, 372, 'Granados'),
(904, 373, 'Arnoldo Gabaldón'),
(905, 373, 'Bolivia'),
(906, 373, 'Carrillo'),
(907, 373, 'Cegarra'),
(908, 373, 'Chejendé'),
(909, 373, 'Manuel Salvador Ulloa'),
(910, 373, 'San José'),
(911, 374, 'Carache'),
(912, 374, 'La Concepción'),
(913, 374, 'Cuicas'),
(914, 374, 'Panamericana'),
(915, 374, 'Santa Cruz'),
(916, 375, 'Escuque'),
(917, 375, 'La Unión'),
(918, 375, 'Santa Rita'),
(919, 375, 'Sabana Libre'),
(920, 376, 'El Socorro'),
(921, 376, 'Los Caprichos'),
(922, 376, 'Antonio José de Sucre'),
(923, 377, 'Campo Elías'),
(924, 377, 'Arnoldo Gabaldón'),
(925, 378, 'Santa Apolonia'),
(926, 378, 'El Progreso'),
(927, 378, 'La Ceiba'),
(928, 378, 'Tres de Febrero'),
(929, 379, 'El Dividive'),
(930, 379, 'Agua Santa'),
(931, 379, 'Agua Caliente'),
(932, 379, 'El Cenizo'),
(933, 379, 'Valerita'),
(934, 380, 'Monte Carmelo'),
(935, 380, 'Buena Vista'),
(936, 380, 'Santa María del Horcón'),
(937, 381, 'Motatán'),
(938, 381, 'El Baño'),
(939, 381, 'Jalisco'),
(940, 382, 'Pampán'),
(941, 382, 'Flor de Patria'),
(942, 382, 'La Paz'),
(943, 382, 'Santa Ana'),
(944, 383, 'Pampanito'),
(945, 383, 'La Concepción'),
(946, 383, 'Pampanito II'),
(947, 384, 'Betijoque'),
(948, 384, 'José Gregorio Hernández'),
(949, 384, 'La Pueblita'),
(950, 384, 'Los Cedros'),
(951, 385, 'Carvajal'),
(952, 385, 'Campo Alegre'),
(953, 385, 'Antonio Nicolás Briceño'),
(954, 385, 'José Leonardo Suárez'),
(955, 386, 'Sabana de Mendoza'),
(956, 386, 'Junín'),
(957, 386, 'Valmore Rodríguez'),
(958, 386, 'El Paraíso'),
(959, 387, 'Andrés Linares'),
(960, 387, 'Chiquinquirá'),
(961, 387, 'Cristóbal Mendoza'),
(962, 387, 'Cruz Carrillo'),
(963, 387, 'Matriz'),
(964, 387, 'Monseñor Carrillo'),
(965, 387, 'Tres Esquinas'),
(966, 388, 'Cabimbú'),
(967, 388, 'Jajó'),
(968, 388, 'La Mesa de Esnujaque'),
(969, 388, 'Santiago'),
(970, 388, 'Tuñame'),
(971, 388, 'La Quebrada'),
(972, 389, 'Juan Ignacio Montilla'),
(973, 389, 'La Beatriz'),
(974, 389, 'La Puerta'),
(975, 389, 'Mendoza del Valle de Momboy'),
(976, 389, 'Mercedes Díaz'),
(977, 389, 'San Luis'),
(978, 390, 'Caraballeda'),
(979, 390, 'Carayaca'),
(980, 390, 'Carlos Soublette'),
(981, 390, 'Caruao Chuspa'),
(982, 390, 'Catia La Mar'),
(983, 390, 'El Junko'),
(984, 390, 'La Guaira'),
(985, 390, 'Macuto'),
(986, 390, 'Maiquetía'),
(987, 390, 'Naiguatá'),
(988, 390, 'Urimare'),
(989, 391, 'Arístides Bastidas'),
(990, 392, 'Bolívar'),
(991, 407, 'Chivacoa'),
(992, 407, 'Campo Elías'),
(993, 408, 'Cocorote'),
(994, 409, 'Independencia'),
(995, 410, 'José Antonio Páez'),
(996, 411, 'La Trinidad'),
(997, 412, 'Manuel Monge'),
(998, 413, 'Salóm'),
(999, 413, 'Temerla'),
(1000, 413, 'Nirgua'),
(1001, 414, 'San Andrés'),
(1002, 414, 'Yaritagua'),
(1003, 415, 'San Javier'),
(1004, 415, 'Albarico'),
(1005, 415, 'San Felipe'),
(1006, 416, 'Sucre'),
(1007, 417, 'Urachiche'),
(1008, 418, 'El Guayabo'),
(1009, 418, 'Farriar'),
(1010, 441, 'Isla de Toas'),
(1011, 441, 'Monagas'),
(1012, 442, 'San Timoteo'),
(1013, 442, 'General Urdaneta'),
(1014, 442, 'Libertador'),
(1015, 442, 'Marcelino Briceño'),
(1016, 442, 'Pueblo Nuevo'),
(1017, 442, 'Manuel Guanipa Matos'),
(1018, 443, 'Ambrosio'),
(1019, 443, 'Carmen Herrera'),
(1020, 443, 'La Rosa'),
(1021, 443, 'Germán Ríos Linares'),
(1022, 443, 'San Benito'),
(1023, 443, 'Rómulo Betancourt'),
(1024, 443, 'Jorge Hernández'),
(1025, 443, 'Punta Gorda'),
(1026, 443, 'Arístides Calvani'),
(1027, 444, 'Encontrados'),
(1028, 444, 'Udón Pérez'),
(1029, 445, 'Moralito'),
(1030, 445, 'San Carlos del Zulia'),
(1031, 445, 'Santa Cruz del Zulia'),
(1032, 445, 'Santa Bárbara'),
(1033, 445, 'Urribarrí'),
(1034, 446, 'Carlos Quevedo'),
(1035, 446, 'Francisco Javier Pulgar'),
(1036, 446, 'Simón Rodríguez'),
(1037, 446, 'Guamo-Gavilanes'),
(1038, 448, 'La Concepción'),
(1039, 448, 'San José'),
(1040, 448, 'Mariano Parra León'),
(1041, 448, 'José Ramón Yépez'),
(1042, 449, 'Jesús María Semprún'),
(1043, 449, 'Barí'),
(1044, 450, 'Concepción'),
(1045, 450, 'Andrés Bello'),
(1046, 450, 'Chiquinquirá'),
(1047, 450, 'El Carmelo'),
(1048, 450, 'Potreritos'),
(1049, 451, 'Libertad'),
(1050, 451, 'Alonso de Ojeda'),
(1051, 451, 'Venezuela'),
(1052, 451, 'Eleazar López Contreras'),
(1053, 451, 'Campo Lara'),
(1054, 452, 'Bartolomé de las Casas'),
(1055, 452, 'Libertad'),
(1056, 452, 'Río Negro'),
(1057, 452, 'San José de Perijá'),
(1058, 453, 'San Rafael'),
(1059, 453, 'La Sierrita'),
(1060, 453, 'Las Parcelas'),
(1061, 453, 'Luis de Vicente'),
(1062, 453, 'Monseñor Marcos Sergio Godoy'),
(1063, 453, 'Ricaurte'),
(1064, 453, 'Tamare'),
(1065, 454, 'Antonio Borjas Romero'),
(1066, 454, 'Bolívar'),
(1067, 454, 'Cacique Mara'),
(1068, 454, 'Carracciolo Parra Pérez'),
(1069, 454, 'Cecilio Acosta'),
(1070, 454, 'Cristo de Aranza'),
(1071, 454, 'Coquivacoa'),
(1072, 454, 'Chiquinquirá'),
(1073, 454, 'Francisco Eugenio Bustamante'),
(1074, 454, 'Idelfonzo Vásquez'),
(1075, 454, 'Juana de Ávila'),
(1076, 454, 'Luis Hurtado Higuera'),
(1077, 454, 'Manuel Dagnino'),
(1078, 454, 'Olegario Villalobos'),
(1079, 454, 'Raúl Leoni'),
(1080, 454, 'Santa Lucía'),
(1081, 454, 'Venancio Pulgar'),
(1082, 454, 'San Isidro'),
(1083, 455, 'Altagracia'),
(1084, 455, 'Faría'),
(1085, 455, 'Ana María Campos'),
(1086, 455, 'San Antonio'),
(1087, 455, 'San José'),
(1088, 456, 'Donaldo García'),
(1089, 456, 'El Rosario'),
(1090, 456, 'Sixto Zambrano'),
(1091, 457, 'San Francisco'),
(1092, 457, 'El Bajo'),
(1093, 457, 'Domitila Flores'),
(1094, 457, 'Francisco Ochoa'),
(1095, 457, 'Los Cortijos'),
(1096, 457, 'Marcial Hernández'),
(1097, 458, 'Santa Rita'),
(1098, 458, 'El Mene'),
(1099, 458, 'Pedro Lucas Urribarrí'),
(1100, 458, 'José Cenobio Urribarrí'),
(1101, 459, 'Rafael Maria Baralt'),
(1102, 459, 'Manuel Manrique'),
(1103, 459, 'Rafael Urdaneta'),
(1104, 460, 'Bobures'),
(1105, 460, 'Gibraltar'),
(1106, 460, 'Heras'),
(1107, 460, 'Monseñor Arturo Álvarez'),
(1108, 460, 'Rómulo Gallegos'),
(1109, 460, 'El Batey'),
(1110, 461, 'Rafael Urdaneta'),
(1111, 461, 'La Victoria'),
(1112, 461, 'Raúl Cuenca'),
(1113, 447, 'Sinamaica'),
(1114, 447, 'Alta Guajira'),
(1115, 447, 'Elías Sánchez Rubio'),
(1116, 447, 'Guajira'),
(1117, 462, 'Altagracia'),
(1118, 462, 'Antímano'),
(1119, 462, 'Caricuao'),
(1120, 462, 'Catedral'),
(1121, 462, 'Coche'),
(1122, 462, 'El Junquito'),
(1123, 462, 'El Paraíso'),
(1124, 462, 'El Recreo'),
(1125, 462, 'El Valle'),
(1126, 462, 'La Candelaria'),
(1127, 462, 'La Pastora'),
(1128, 462, 'La Vega'),
(1129, 462, 'Macarao'),
(1130, 462, 'San Agustín'),
(1131, 462, 'San Bernardino'),
(1132, 462, 'San José'),
(1133, 462, 'San Juan'),
(1134, 462, 'San Pedro'),
(1135, 462, 'Santa Rosalía'),
(1136, 462, 'Santa Teresa'),
(1137, 462, 'Sucre (Catia)'),
(1138, 462, '23 de enero'),
(1139, 282, 'Agua Blanca'),
(1140, 463, 'Parroquia - Afganistán'),
(1141, 464, 'Parroquia - Islas Gland'),
(1142, 465, 'Parroquia - Albania'),
(1143, 466, 'Parroquia - Alemania'),
(1144, 467, 'Parroquia - Andorra'),
(1145, 468, 'Parroquia - Angola'),
(1146, 469, 'Parroquia - Anguilla'),
(1147, 470, 'Parroquia - Antártida'),
(1148, 471, 'Parroquia - Antigua y Barbuda'),
(1149, 472, 'Parroquia - Antillas Holandesas'),
(1150, 473, 'Parroquia - Arabia Saudí'),
(1151, 474, 'Parroquia - Argelia'),
(1152, 475, 'Parroquia - Argentina'),
(1153, 476, 'Parroquia - Armenia'),
(1154, 477, 'Parroquia - Aruba'),
(1155, 478, 'Parroquia - Australia'),
(1156, 479, 'Parroquia - Austria'),
(1157, 480, 'Parroquia - Azerbaiyán'),
(1158, 481, 'Parroquia - Bahamas'),
(1159, 482, 'Parroquia - Bahréin'),
(1160, 483, 'Parroquia - Bangladesh'),
(1161, 484, 'Parroquia - Barbados'),
(1162, 485, 'Parroquia - Bielorrusia'),
(1163, 486, 'Parroquia - Bélgica'),
(1164, 487, 'Parroquia - Belice'),
(1165, 488, 'Parroquia - Benin'),
(1166, 489, 'Parroquia - Bermudas'),
(1167, 490, 'Parroquia - Bhután'),
(1168, 491, 'Parroquia - Bolivia'),
(1169, 492, 'Parroquia - Bosnia y Herzegovina'),
(1170, 493, 'Parroquia - Botsuana'),
(1171, 494, 'Parroquia - Isla Bouvet'),
(1172, 495, 'Parroquia - Brasil'),
(1173, 496, 'Parroquia - Brunéi'),
(1174, 497, 'Parroquia - Bulgaria'),
(1175, 498, 'Parroquia - Burkina Faso'),
(1176, 499, 'Parroquia - Burundi'),
(1177, 500, 'Parroquia - Cabo Verde'),
(1178, 501, 'Parroquia - Islas Caimán'),
(1179, 502, 'Parroquia - Camboya'),
(1180, 503, 'Parroquia - Camerún'),
(1181, 504, 'Parroquia - Canadá'),
(1182, 505, 'Parroquia - República Centroafricana'),
(1183, 506, 'Parroquia - Chad'),
(1184, 507, 'Parroquia - República Checa'),
(1185, 508, 'Parroquia - Chile'),
(1186, 509, 'Parroquia - China'),
(1187, 510, 'Parroquia - Chipre'),
(1188, 511, 'Parroquia - Isla de Navidad'),
(1189, 512, 'Parroquia - Ciudad del Vaticano'),
(1190, 513, 'Parroquia - Islas Cocos'),
(1191, 514, 'Parroquia - Colombia'),
(1192, 515, 'Parroquia - Comoras'),
(1193, 516, 'Parroquia - República Democrática del Congo'),
(1194, 517, 'Parroquia - Congo'),
(1195, 518, 'Parroquia - Islas Cook'),
(1196, 519, 'Parroquia - Corea del Norte'),
(1197, 520, 'Parroquia - Corea del Sur'),
(1198, 521, 'Parroquia - Costa de Marfil'),
(1199, 522, 'Parroquia - Costa Rica'),
(1200, 523, 'Parroquia - Croacia'),
(1201, 524, 'Parroquia - Cuba'),
(1202, 525, 'Parroquia - Dinamarca'),
(1203, 526, 'Parroquia - Dominica'),
(1204, 527, 'Parroquia - República Dominicana'),
(1205, 528, 'Parroquia - Ecuador'),
(1206, 529, 'Parroquia - Egipto'),
(1207, 530, 'Parroquia - El Salvador'),
(1208, 531, 'Parroquia - Emiratos Árabes Unidos'),
(1209, 532, 'Parroquia - Eritrea'),
(1210, 533, 'Parroquia - Eslovaquia'),
(1211, 534, 'Parroquia - Eslovenia'),
(1212, 535, 'Parroquia - España'),
(1213, 536, 'Parroquia - Islas ultramarinas de Estados Uni'),
(1214, 537, 'Parroquia - Estados Unidos'),
(1215, 538, 'Parroquia - Estonia'),
(1216, 539, 'Parroquia - Etiopía'),
(1217, 540, 'Parroquia - Islas Feroe'),
(1218, 541, 'Parroquia - Filipinas'),
(1219, 542, 'Parroquia - Finlandia'),
(1220, 543, 'Parroquia - Fiyi'),
(1221, 544, 'Parroquia - Francia'),
(1222, 545, 'Parroquia - Gabón'),
(1223, 546, 'Parroquia - Gambia'),
(1224, 547, 'Parroquia - Georgia'),
(1225, 548, 'Parroquia - Islas Georgias del Sur y Sandwich'),
(1226, 549, 'Parroquia - Ghana'),
(1227, 550, 'Parroquia - Gibraltar'),
(1228, 551, 'Parroquia - Granada'),
(1229, 552, 'Parroquia - Grecia'),
(1230, 553, 'Parroquia - Groenlandia'),
(1231, 554, 'Parroquia - Guadalupe'),
(1232, 555, 'Parroquia - Guam'),
(1233, 556, 'Parroquia - Guatemala'),
(1234, 557, 'Parroquia - Guayana Francesa'),
(1235, 558, 'Parroquia - Guinea'),
(1236, 559, 'Parroquia - Guinea Ecuatorial'),
(1237, 560, 'Parroquia - Guinea-Bissau'),
(1238, 561, 'Parroquia - Guyana'),
(1239, 562, 'Parroquia - Haití'),
(1240, 563, 'Parroquia - Islas Heard y McDonald'),
(1241, 564, 'Parroquia - Honduras'),
(1242, 565, 'Parroquia - Hong Kong'),
(1243, 566, 'Parroquia - Hungría'),
(1244, 567, 'Parroquia - India'),
(1245, 568, 'Parroquia - Indonesia'),
(1246, 569, 'Parroquia - Irán'),
(1247, 570, 'Parroquia - Iraq'),
(1248, 571, 'Parroquia - Irlanda'),
(1249, 572, 'Parroquia - Islandia'),
(1250, 573, 'Parroquia - Israel'),
(1251, 574, 'Parroquia - Italia'),
(1252, 575, 'Parroquia - Jamaica'),
(1253, 576, 'Parroquia - Japón'),
(1254, 577, 'Parroquia - Jordania'),
(1255, 578, 'Parroquia - Kazajstán'),
(1256, 579, 'Parroquia - Kenia'),
(1257, 580, 'Parroquia - Kirguistán'),
(1258, 581, 'Parroquia - Kiribati'),
(1259, 582, 'Parroquia - Kuwait'),
(1260, 583, 'Parroquia - Laos'),
(1261, 584, 'Parroquia - Lesotho'),
(1262, 585, 'Parroquia - Letonia'),
(1263, 586, 'Parroquia - Líbano'),
(1264, 587, 'Parroquia - Liberia'),
(1265, 588, 'Parroquia - Libia'),
(1266, 589, 'Parroquia - Liechtenstein'),
(1267, 590, 'Parroquia - Lituania'),
(1268, 591, 'Parroquia - Luxemburgo'),
(1269, 592, 'Parroquia - Macao'),
(1270, 593, 'Parroquia - ARY Macedonia'),
(1271, 594, 'Parroquia - Madagascar'),
(1272, 595, 'Parroquia - Malasia'),
(1273, 596, 'Parroquia - Malawi'),
(1274, 597, 'Parroquia - Maldivas'),
(1275, 598, 'Parroquia - Malí'),
(1276, 599, 'Parroquia - Malta'),
(1277, 600, 'Parroquia - Islas Malvinas'),
(1278, 601, 'Parroquia - Islas Marianas del Norte'),
(1279, 602, 'Parroquia - Marruecos'),
(1280, 603, 'Parroquia - Islas Marshall'),
(1281, 604, 'Parroquia - Martinica'),
(1282, 605, 'Parroquia - Mauricio'),
(1283, 606, 'Parroquia - Mauritania'),
(1284, 607, 'Parroquia - Mayotte'),
(1285, 608, 'Parroquia - México'),
(1286, 609, 'Parroquia - Micronesia'),
(1287, 610, 'Parroquia - Moldavia'),
(1288, 611, 'Parroquia - Mónaco'),
(1289, 612, 'Parroquia - Mongolia'),
(1290, 613, 'Parroquia - Montserrat'),
(1291, 614, 'Parroquia - Mozambique'),
(1292, 615, 'Parroquia - Myanmar'),
(1293, 616, 'Parroquia - Namibia'),
(1294, 617, 'Parroquia - Nauru'),
(1295, 618, 'Parroquia - Nepal'),
(1296, 619, 'Parroquia - Nicaragua'),
(1297, 620, 'Parroquia - Níger'),
(1298, 621, 'Parroquia - Nigeria'),
(1299, 622, 'Parroquia - Niue'),
(1300, 623, 'Parroquia - Isla Norfolk'),
(1301, 624, 'Parroquia - Noruega'),
(1302, 625, 'Parroquia - Nueva Caledonia'),
(1303, 626, 'Parroquia - Nueva Zelanda'),
(1304, 627, 'Parroquia - Omán'),
(1305, 628, 'Parroquia - Países Bajos'),
(1306, 629, 'Parroquia - Pakistán'),
(1307, 630, 'Parroquia - Palau'),
(1308, 631, 'Parroquia - Palestina'),
(1309, 632, 'Parroquia - Panamá'),
(1310, 633, 'Parroquia - Papúa Nueva Guinea'),
(1311, 634, 'Parroquia - Paraguay'),
(1312, 635, 'Parroquia - Perú'),
(1313, 636, 'Parroquia - Islas Pitcairn'),
(1314, 637, 'Parroquia - Polinesia Francesa'),
(1315, 638, 'Parroquia - Polonia'),
(1316, 639, 'Parroquia - Portugal'),
(1317, 640, 'Parroquia - Puerto Rico'),
(1318, 641, 'Parroquia - Qatar'),
(1319, 642, 'Parroquia - Reino Unido'),
(1320, 643, 'Parroquia - Reunión'),
(1321, 644, 'Parroquia - Ruanda'),
(1322, 645, 'Parroquia - Rumania'),
(1323, 646, 'Parroquia - Rusia'),
(1324, 647, 'Parroquia - Sahara Occidental'),
(1325, 648, 'Parroquia - Islas Salomón'),
(1326, 649, 'Parroquia - Samoa'),
(1327, 650, 'Parroquia - Samoa Americana'),
(1328, 651, 'Parroquia - San Cristóbal y Nevis'),
(1329, 652, 'Parroquia - San Marino'),
(1330, 653, 'Parroquia - San Pedro y Miquelón'),
(1331, 654, 'Parroquia - San Vicente y las Granadinas'),
(1332, 655, 'Parroquia - Santa Helena'),
(1333, 656, 'Parroquia - Santa Lucía'),
(1334, 657, 'Parroquia - Santo Tomé y Príncipe'),
(1335, 658, 'Parroquia - Senegal'),
(1336, 659, 'Parroquia - Serbia y Montenegro'),
(1337, 660, 'Parroquia - Seychelles'),
(1338, 661, 'Parroquia - Sierra Leona'),
(1339, 662, 'Parroquia - Singapur'),
(1340, 663, 'Parroquia - Siria'),
(1341, 664, 'Parroquia - Somalia'),
(1342, 665, 'Parroquia - Sri Lanka'),
(1343, 666, 'Parroquia - Suazilandia'),
(1344, 667, 'Parroquia - Sudáfrica'),
(1345, 668, 'Parroquia - Sudán'),
(1346, 669, 'Parroquia - Suecia'),
(1347, 670, 'Parroquia - Suiza'),
(1348, 671, 'Parroquia - Surinam'),
(1349, 672, 'Parroquia - Svalbard y Jan Mayen'),
(1350, 673, 'Parroquia - Tailandia'),
(1351, 674, 'Parroquia - Taiwán'),
(1352, 675, 'Parroquia - Tanzania'),
(1353, 676, 'Parroquia - Tayikistán'),
(1354, 677, 'Parroquia - Territorio Británico del Océano Í'),
(1355, 678, 'Parroquia - Territorios Australes Franceses'),
(1356, 679, 'Parroquia - Timor Oriental'),
(1357, 680, 'Parroquia - Togo'),
(1358, 681, 'Parroquia - Tokelau'),
(1359, 682, 'Parroquia - Tonga'),
(1360, 683, 'Parroquia - Trinidad y Tobago'),
(1361, 684, 'Parroquia - Túnez'),
(1362, 685, 'Parroquia - Islas Turcas y Caicos'),
(1363, 686, 'Parroquia - Turkmenistán'),
(1364, 687, 'Parroquia - Turquía'),
(1365, 688, 'Parroquia - Tuvalu'),
(1366, 689, 'Parroquia - Ucrania'),
(1367, 690, 'Parroquia - Uganda'),
(1368, 691, 'Parroquia - Uruguay'),
(1369, 692, 'Parroquia - Uzbekistán'),
(1370, 693, 'Parroquia - Vanuatu'),
(1371, 694, 'Parroquia - Vietnam'),
(1372, 695, 'Parroquia - Islas Vírgenes Británicas'),
(1373, 696, 'Parroquia - Islas Vírgenes de los Estados Uni'),
(1374, 697, 'Parroquia - Wallis y Futuna'),
(1375, 698, 'Parroquia - Yemen'),
(1376, 699, 'Parroquia - Yibuti'),
(1377, 700, 'Parroquia - Zambia'),
(1378, 701, 'Parroquia - Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_escolar`
--

CREATE TABLE `periodo_escolar` (
  `id` int(11) NOT NULL,
  `periodo` varchar(9) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  `estatus` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `cedula` varchar(14) NOT NULL,
  `p_nombre` varchar(20) NOT NULL,
  `s_nombre` varchar(20) DEFAULT NULL,
  `p_apellido` varchar(20) NOT NULL,
  `s_apellido` varchar(20) DEFAULT NULL,
  `genero` varchar(1) DEFAULT NULL,
  `f_nac` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `f_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `cargo` varchar(45) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_directivo`
--

CREATE TABLE `personal_directivo` (
  `id` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `idperiodo_escolar` int(11) NOT NULL,
  `cargo` varchar(45) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pic`
--

CREATE TABLE `pic` (
  `id` int(11) NOT NULL,
  `idperiodo_escolar` int(11) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `estatus` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planificacion`
--

CREATE TABLE `planificacion` (
  `id` int(11) NOT NULL,
  `idperiodo_escolar` int(11) NOT NULL,
  `idgrado` int(11) NOT NULL,
  `idseccion` int(11) NOT NULL,
  `idambiente` int(11) NOT NULL,
  `iddocente` int(11) NOT NULL,
  `cupo` int(11) NOT NULL,
  `cupo_disponible` int(11) NOT NULL,
  `estatus` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `planificacion`
--

INSERT INTO `planificacion` (`id`, `idperiodo_escolar`, `idgrado`, `idseccion`, `idambiente`, `iddocente`, `cupo`, `cupo_disponible`, `estatus`) VALUES
(1, 1, 1, 1, 3, 13, 30, 29, 'Finalizado'),
(2, 1, 2, 1, 4, 14, 30, 29, 'Finalizado'),
(3, 2, 2, 2, 3, 13, 30, 29, 'Finalizado'),
(4, 2, 3, 1, 4, 14, 30, 29, 'Finalizado'),
(5, 3, 3, 1, 3, 13, 30, 28, 'Finalizado'),
(10, 4, 3, 1, 4, 13, 30, 29, 'Finalizado'),
(11, 4, 4, 1, 3, 14, 30, 29, 'Finalizado'),
(12, 5, 4, 1, 3, 13, 30, 29, 'Finalizado'),
(13, 5, 5, 1, 4, 14, 30, 29, 'Finalizado'),
(14, 6, 9, 1, 3, 13, 30, 29, 'Finalizado'),
(15, 6, 5, 1, 4, 14, 30, 28, 'Finalizado'),
(16, 7, 5, 1, 3, 13, 30, 29, 'Finalizado'),
(17, 7, 9, 1, 5, 14, 30, 30, 'Finalizado'),
(18, 8, 9, 1, 3, 13, 30, 30, 'Finalizado'),
(19, 9, 2, 2, 5, 13, 30, 28, 'Finalizado'),
(20, 10, 3, 2, 4, 13, 30, 28, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_aprendizaje`
--

CREATE TABLE `proyecto_aprendizaje` (
  `id` int(11) NOT NULL,
  `idplanificacion` int(11) NOT NULL,
  `lapso_academico` char(1) NOT NULL,
  `proyecto_aprendizaje` char(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendacion`
--

CREATE TABLE `recomendacion` (
  `id` int(11) NOT NULL,
  `idplanificacion` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `lapso_academico` char(1) NOT NULL,
  `recomendacion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representante`
--

CREATE TABLE `representante` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `instruccion` varchar(20) DEFAULT NULL,
  `oficio` varchar(45) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id` int(11) NOT NULL,
  `seccion` char(1) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sosten_hogar`
--

CREATE TABLE `sosten_hogar` (
  `id` int(11) NOT NULL,
  `idestudiante` int(11) NOT NULL,
  `sosten` varchar(10) NOT NULL
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `usuario` char(50) NOT NULL,
  `clave` char(64) NOT NULL,
  `rol` char(13) NOT NULL,
  `intentos_fallidos` char(1) NOT NULL,
  `estatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `idpersona`, `usuario`, `clave`, `rol`, `intentos_fallidos`, `estatus`) VALUES
(1, 1, 'administrador', 'b20b0f63ce2ed361e8845d6bf2e59811aaa06ec96bcdb92f9bc0c5a25e83c9a6', 'Administrador', '0', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_modulo_accion`
--

CREATE TABLE `usuario_modulo_accion` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idmodulo` int(11) NOT NULL,
  `idaccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario_modulo_accion`
--

INSERT INTO `usuario_modulo_accion` (`id`, `idusuario`, `idmodulo`, `idaccion`) VALUES
(4291, 1, 18, 1),
(4292, 1, 1, 1),
(4293, 1, 1, 2),
(4294, 1, 1, 3),
(4295, 1, 1, 4),
(4296, 1, 24, 1),
(4297, 1, 24, 2),
(4298, 1, 24, 3),
(4299, 1, 22, 1),
(4300, 1, 22, 2),
(4301, 1, 22, 3),
(4302, 1, 20, 1),
(4303, 1, 20, 2),
(4304, 1, 20, 3),
(4305, 1, 2, 1),
(4306, 1, 3, 1),
(4307, 1, 3, 2),
(4308, 1, 3, 3),
(4309, 1, 3, 4),
(4310, 1, 21, 1),
(4311, 1, 21, 2),
(4312, 1, 21, 3),
(4313, 1, 21, 4),
(4314, 1, 4, 1),
(4315, 1, 4, 2),
(4316, 1, 4, 3),
(4317, 1, 4, 4),
(4318, 1, 5, 1),
(4319, 1, 5, 2),
(4320, 1, 5, 3),
(4321, 1, 5, 4),
(4322, 1, 23, 1),
(4323, 1, 23, 2),
(4324, 1, 23, 3),
(4325, 1, 23, 4),
(4326, 1, 19, 1),
(4327, 1, 19, 2),
(4328, 1, 19, 3),
(4329, 1, 19, 4),
(4330, 1, 6, 1),
(4331, 1, 6, 3),
(4332, 1, 7, 1),
(4333, 1, 7, 2),
(4334, 1, 7, 4),
(4335, 1, 8, 1),
(4336, 1, 8, 2),
(4337, 1, 8, 3),
(4338, 1, 8, 4),
(4339, 1, 9, 1),
(4340, 1, 9, 2),
(4341, 1, 9, 3),
(4342, 1, 9, 4),
(4343, 1, 10, 1),
(4344, 1, 11, 1),
(4345, 1, 11, 2),
(4346, 1, 11, 3),
(4347, 1, 11, 4),
(4348, 1, 12, 1),
(4349, 1, 12, 2),
(4350, 1, 12, 3),
(4351, 1, 12, 4),
(4352, 1, 13, 1),
(4353, 1, 13, 2),
(4354, 1, 13, 3),
(4355, 1, 13, 4),
(4356, 1, 14, 1),
(4357, 1, 14, 2),
(4358, 1, 14, 3),
(4359, 1, 14, 4),
(4360, 1, 15, 1),
(4361, 1, 15, 2),
(4362, 1, 15, 3),
(4363, 1, 15, 4),
(4364, 1, 16, 1),
(4365, 1, 16, 2),
(4366, 1, 16, 3),
(4367, 1, 16, 4),
(4368, 1, 17, 1),
(4369, 1, 17, 2),
(4370, 1, 17, 3),
(4371, 1, 17, 4),
(4372, 6, 24, 1),
(4373, 6, 24, 2),
(4374, 6, 24, 3),
(4375, 6, 22, 1),
(4376, 6, 22, 2),
(4377, 6, 22, 3),
(4378, 6, 20, 1),
(4379, 6, 20, 2),
(4380, 6, 20, 3),
(4381, 6, 2, 1),
(4382, 6, 4, 1),
(4383, 6, 4, 2),
(4384, 6, 4, 3),
(4385, 6, 4, 4),
(4386, 6, 19, 1),
(4387, 6, 19, 2),
(4388, 6, 19, 3),
(4389, 6, 19, 4),
(4390, 5, 24, 1),
(4391, 5, 24, 2),
(4392, 5, 24, 3),
(4393, 5, 22, 1),
(4394, 5, 22, 2),
(4395, 5, 22, 3),
(4396, 5, 20, 1),
(4397, 5, 20, 2),
(4398, 5, 20, 3),
(4399, 5, 4, 1),
(4400, 5, 4, 2),
(4401, 5, 4, 3),
(4402, 5, 4, 4),
(4403, 5, 19, 1),
(4404, 5, 19, 2),
(4405, 5, 19, 3),
(4406, 5, 19, 4);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_historial_estudiantil`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_historial_estudiantil` (
`id` int(11)
,`periodo_escolar` char(9)
,`turno` char(50)
,`grado` char(2)
,`seccion` char(2)
,`cedula_docente` char(14)
,`nombre_docente` char(30)
,`apellido_docente` char(30)
,`cedula_estudiante` char(15)
,`p_nombre_estudiante` char(30)
,`s_nombre_estudiante` char(30)
,`p_apellido_estudiante` char(30)
,`s_apellido_estudiante` char(30)
,`fecha_nacimiento_estudiante` date
,`lugar_nacimiento_estudiante` varchar(100)
,`sexo_estudiante` char(1)
,`literal` char(1)
,`observaciones` text
,`estatus` char(10)
,`fecha_creacion` datetime
,`fecha_actualizacion` datetime
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_historial_estudiantil`
--
DROP TABLE IF EXISTS `vista_historial_estudiantil`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_historial_estudiantil`  AS  select `historial_estudiantil`.`id` AS `id`,`historial_estudiantil`.`periodo_escolar` AS `periodo_escolar`,`historial_estudiantil`.`turno` AS `turno`,`historial_estudiantil`.`grado` AS `grado`,`historial_estudiantil`.`seccion` AS `seccion`,`historial_estudiantil`.`cedula_docente` AS `cedula_docente`,`historial_estudiantil`.`nombre_docente` AS `nombre_docente`,`historial_estudiantil`.`apellido_docente` AS `apellido_docente`,`historial_estudiantil`.`cedula_estudiante` AS `cedula_estudiante`,`historial_estudiantil`.`p_nombre_estudiante` AS `p_nombre_estudiante`,`historial_estudiantil`.`s_nombre_estudiante` AS `s_nombre_estudiante`,`historial_estudiantil`.`p_apellido_estudiante` AS `p_apellido_estudiante`,`historial_estudiantil`.`s_apellido_estudiante` AS `s_apellido_estudiante`,`historial_estudiantil`.`fecha_nacimiento_estudiante` AS `fecha_nacimiento_estudiante`,`historial_estudiantil`.`lugar_nacimiento_estudiante` AS `lugar_nacimiento_estudiante`,`historial_estudiantil`.`sexo_estudiante` AS `sexo_estudiante`,`historial_estudiantil`.`literal` AS `literal`,`historial_estudiantil`.`observaciones` AS `observaciones`,`historial_estudiantil`.`estatus` AS `estatus`,`historial_estudiantil`.`fecha_creacion` AS `fecha_creacion`,`historial_estudiantil`.`fecha_actualizacion` AS `fecha_actualizacion` from `historial_estudiantil` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion`
--
ALTER TABLE `accion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ambiente`
--
ALTER TABLE `ambiente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ambiente` (`ambiente`);

--
-- Indices de la tabla `aspecto_fisiologicos`
--
ALTER TABLE `aspecto_fisiologicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idinscripcion` (`idplanificacion`),
  ADD KEY `idestudiante` (`idestudiante`);

--
-- Indices de la tabla `aspecto_socioeconomico`
--
ALTER TABLE `aspecto_socioeconomico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idestudiante` (`idestudiante`);

--
-- Indices de la tabla `boletin_final`
--
ALTER TABLE `boletin_final`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idplanificacion` (`idplanificacion`),
  ADD KEY `idestudiante` (`idestudiante`),
  ADD KEY `idexpresion_literal` (`idexpresion_literal`);

--
-- Indices de la tabla `canaima`
--
ALTER TABLE `canaima`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idestudiante` (`idestudiante`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `direccion_persona_idx` (`idpersona`),
  ADD KEY `direccion_parroquia_idx` (`idparroquia`);

--
-- Indices de la tabla `direccion_trabajo`
--
ALTER TABLE `direccion_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersona` (`idpersona`),
  ADD KEY `idparroquia` (`idparroquia`);

--
-- Indices de la tabla `diversidad_funcionals`
--
ALTER TABLE `diversidad_funcionals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idaspecto_fisiologico` (`idaspecto_fisiologico`);

--
-- Indices de la tabla `documentos_consignados`
--
ALTER TABLE `documentos_consignados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idinscripcion` (`idinscripcion`);

--
-- Indices de la tabla `enfermedads`
--
ALTER TABLE `enfermedads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idaspecto_fisiologico` (`idaspecto_fisiologico`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_pais_idx` (`idpais`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersona` (`idpersona`),
  ADD KEY `idmadre` (`idmadre`),
  ADD KEY `idpadre` (`idpadre`);

--
-- Indices de la tabla `expresion_literal`
--
ALTER TABLE `expresion_literal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grado`
--
ALTER TABLE `grado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grado` (`grado`);

--
-- Indices de la tabla `historial_estudiantil`
--
ALTER TABLE `historial_estudiantil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `indicador`
--
ALTER TABLE `indicador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idplanificacion` (`idplanificacion`),
  ADD KEY `idmateria` (`idmateria`);

--
-- Indices de la tabla `indicador_nota`
--
ALTER TABLE `indicador_nota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idindicador` (`idindicador`),
  ADD KEY `idestudiante` (`idestudiante`),
  ADD KEY `idplanificacion` (`idplanificacion`),
  ADD KEY `lapso` (`lapso_academico`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idplanificacion` (`idplanificacion`),
  ADD KEY `idestudiante` (`idestudiante`),
  ADD KEY `idrepresentante` (`idrepresentante`),
  ADD KEY `idperiodo_escolar` (`idperiodo_escolar`);

--
-- Indices de la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idmunicipio` (`idmunicipio`),
  ADD KEY `idparroquia` (`idparroquia`),
  ADD KEY `idestado` (`idestado`);

--
-- Indices de la tabla `lapso`
--
ALTER TABLE `lapso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lapso_academico`
--
ALTER TABLE `lapso_academico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idperiodo_escolar` (`idperiodo_escolar`);

--
-- Indices de la tabla `lugar_nacimiento`
--
ALTER TABLE `lugar_nacimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idestudiante` (`idestudiante`),
  ADD KEY `idparroquia` (`idparroquia`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersona` (`idpersona`);

--
-- Indices de la tabla `personal_directivo`
--
ALTER TABLE `personal_directivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersonal` (`idpersonal`),
  ADD KEY `idperiodo_escolar` (`idperiodo_escolar`);

--
-- Indices de la tabla `pic`
--
ALTER TABLE `pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idperiodo_escolar` (`idperiodo_escolar`);

--
-- Indices de la tabla `planificacion`
--
ALTER TABLE `planificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idperiodo_escolar_periodo_escolar` (`idperiodo_escolar`),
  ADD KEY `idambiente_ambiente` (`idambiente`),
  ADD KEY `idgrado_grado` (`idgrado`),
  ADD KEY `idseccion_seccion` (`idseccion`),
  ADD KEY `iddocente_personal` (`iddocente`);

--
-- Indices de la tabla `proyecto_aprendizaje`
--
ALTER TABLE `proyecto_aprendizaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idplanificacion` (`idplanificacion`);

--
-- Indices de la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idplanificacion` (`idplanificacion`),
  ADD KEY `idestudiante` (`idestudiante`);

--
-- Indices de la tabla `representante`
--
ALTER TABLE `representante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpersona` (`idpersona`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seccion` (`seccion`);

--
-- Indices de la tabla `sosten_hogar`
--
ALTER TABLE `sosten_hogar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idestudiante` (`idestudiante`);

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
  ADD KEY `idpersona` (`idpersona`);

--
-- Indices de la tabla `usuario_modulo_accion`
--
ALTER TABLE `usuario_modulo_accion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idmodulo` (`idmodulo`),
  ADD KEY `idaccion` (`idaccion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion`
--
ALTER TABLE `accion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ambiente`
--
ALTER TABLE `ambiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `aspecto_fisiologicos`
--
ALTER TABLE `aspecto_fisiologicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aspecto_socioeconomico`
--
ALTER TABLE `aspecto_socioeconomico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `boletin_final`
--
ALTER TABLE `boletin_final`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `canaima`
--
ALTER TABLE `canaima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direccion_trabajo`
--
ALTER TABLE `direccion_trabajo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `diversidad_funcionals`
--
ALTER TABLE `diversidad_funcionals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos_consignados`
--
ALTER TABLE `documentos_consignados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfermedads`
--
ALTER TABLE `enfermedads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expresion_literal`
--
ALTER TABLE `expresion_literal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `grado`
--
ALTER TABLE `grado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_estudiantil`
--
ALTER TABLE `historial_estudiantil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `indicador`
--
ALTER TABLE `indicador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `indicador_nota`
--
ALTER TABLE `indicador_nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `institucion`
--
ALTER TABLE `institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lapso`
--
ALTER TABLE `lapso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lapso_academico`
--
ALTER TABLE `lapso_academico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lugar_nacimiento`
--
ALTER TABLE `lugar_nacimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1379;

--
-- AUTO_INCREMENT de la tabla `periodo_escolar`
--
ALTER TABLE `periodo_escolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_directivo`
--
ALTER TABLE `personal_directivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pic`
--
ALTER TABLE `pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planificacion`
--
ALTER TABLE `planificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proyecto_aprendizaje`
--
ALTER TABLE `proyecto_aprendizaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `representante`
--
ALTER TABLE `representante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sosten_hogar`
--
ALTER TABLE `sosten_hogar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `telefono`
--
ALTER TABLE `telefono`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_modulo_accion`
--
ALTER TABLE `usuario_modulo_accion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4407;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aspecto_fisiologicos`
--
ALTER TABLE `aspecto_fisiologicos`
  ADD CONSTRAINT `aspecto_fisiologicos_ibfk_1` FOREIGN KEY (`idplanificacion`) REFERENCES `planificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aspecto_fisiologicos_ibfk_2` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `aspecto_socioeconomico`
--
ALTER TABLE `aspecto_socioeconomico`
  ADD CONSTRAINT `aspecto_socieconomico_estudiante` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `boletin_final`
--
ALTER TABLE `boletin_final`
  ADD CONSTRAINT `boletin_final_ibfk_1` FOREIGN KEY (`idplanificacion`) REFERENCES `planificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletin_final_ibfk_2` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletin_final_ibfk_3` FOREIGN KEY (`idexpresion_literal`) REFERENCES `expresion_literal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `canaima`
--
ALTER TABLE `canaima`
  ADD CONSTRAINT `canaima_estudiante` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_parroquia` FOREIGN KEY (`idparroquia`) REFERENCES `parroquia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `direccion_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `direccion_trabajo`
--
ALTER TABLE `direccion_trabajo`
  ADD CONSTRAINT `direccion_trabajo_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `direccion_trabajo_ibfk_2` FOREIGN KEY (`idparroquia`) REFERENCES `parroquia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `diversidad_funcionals`
--
ALTER TABLE `diversidad_funcionals`
  ADD CONSTRAINT `diversidad_funcionals_ibfk_1` FOREIGN KEY (`idaspecto_fisiologico`) REFERENCES `aspecto_fisiologicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos_consignados`
--
ALTER TABLE `documentos_consignados`
  ADD CONSTRAINT `documentos_consignados_ibfk_1` FOREIGN KEY (`idinscripcion`) REFERENCES `inscripcion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `enfermedads`
--
ALTER TABLE `enfermedads`
  ADD CONSTRAINT `enfermedads_ibfk_1` FOREIGN KEY (`idaspecto_fisiologico`) REFERENCES `aspecto_fisiologicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estado`
--
ALTER TABLE `estado`
  ADD CONSTRAINT `estado_pais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_idmadre_estudiante_rf_id_persona` FOREIGN KEY (`idmadre`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idpadre_estudiante_rf_id_persona` FOREIGN KEY (`idpadre`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idpersona_estudiante_rf_id_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `indicador`
--
ALTER TABLE `indicador`
  ADD CONSTRAINT `indicador_ibfk_1` FOREIGN KEY (`idplanificacion`) REFERENCES `planificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `indicador_ibfk_2` FOREIGN KEY (`idmateria`) REFERENCES `materia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `indicador_nota`
--
ALTER TABLE `indicador_nota`
  ADD CONSTRAINT `indicador_nota_ibfk_1` FOREIGN KEY (`idindicador`) REFERENCES `indicador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `indicador_nota_ibfk_2` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `indicador_nota_ibfk_3` FOREIGN KEY (`idplanificacion`) REFERENCES `planificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `idestudiante_estudiante` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idperiodo_escolar` FOREIGN KEY (`idperiodo_escolar`) REFERENCES `periodo_escolar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idplanificacion_planificacion` FOREIGN KEY (`idplanificacion`) REFERENCES `planificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idrepresentante_representante` FOREIGN KEY (`idrepresentante`) REFERENCES `representante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD CONSTRAINT `idestado_estado` FOREIGN KEY (`idestado`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idmunicipio_municipio` FOREIGN KEY (`idmunicipio`) REFERENCES `municipio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idparroquia_parroquia` FOREIGN KEY (`idparroquia`) REFERENCES `parroquia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lapso_academico`
--
ALTER TABLE `lapso_academico`
  ADD CONSTRAINT `lapso_academico_ibfk_1` FOREIGN KEY (`idperiodo_escolar`) REFERENCES `periodo_escolar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lugar_nacimiento`
--
ALTER TABLE `lugar_nacimiento`
  ADD CONSTRAINT `lugar_nacimiento_estudiante` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parroquia_idparroquia` FOREIGN KEY (`idparroquia`) REFERENCES `parroquia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `idpersona_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal_directivo`
--
ALTER TABLE `personal_directivo`
  ADD CONSTRAINT `personal_directivo_ibfk_1` FOREIGN KEY (`idperiodo_escolar`) REFERENCES `periodo_escolar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_directivo_ibfk_2` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pic`
--
ALTER TABLE `pic`
  ADD CONSTRAINT `fk_idperiodo_escolar_pic_references_id_periodo_escolar` FOREIGN KEY (`idperiodo_escolar`) REFERENCES `periodo_escolar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `planificacion`
--
ALTER TABLE `planificacion`
  ADD CONSTRAINT `idambiente_ambiente` FOREIGN KEY (`idambiente`) REFERENCES `ambiente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iddocente_personal` FOREIGN KEY (`iddocente`) REFERENCES `personal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idgrado_grado` FOREIGN KEY (`idgrado`) REFERENCES `grado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idperiodo_escolar_periodo_escolar` FOREIGN KEY (`idperiodo_escolar`) REFERENCES `periodo_escolar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idseccion_seccion` FOREIGN KEY (`idseccion`) REFERENCES `seccion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto_aprendizaje`
--
ALTER TABLE `proyecto_aprendizaje`
  ADD CONSTRAINT `proyecto_aprendizaje_ibfk_1` FOREIGN KEY (`idplanificacion`) REFERENCES `planificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recomendacion`
--
ALTER TABLE `recomendacion`
  ADD CONSTRAINT `recomendacion_ibfk_1` FOREIGN KEY (`idplanificacion`) REFERENCES `planificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recomendacion_ibfk_2` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `representante`
--
ALTER TABLE `representante`
  ADD CONSTRAINT `representante_persona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sosten_hogar`
--
ALTER TABLE `sosten_hogar`
  ADD CONSTRAINT `sosten_hogar_estudiante` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `persona_telefono` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_modulo_accion`
--
ALTER TABLE `usuario_modulo_accion`
  ADD CONSTRAINT `usuario_modulo_accion_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_modulo_accion_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_modulo_accion_ibfk_3` FOREIGN KEY (`idaccion`) REFERENCES `accion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
