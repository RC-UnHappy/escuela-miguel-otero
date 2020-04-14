-- Base de datos: `nomina`
create database nomina;
use nomina;

CREATE TABLE `personal` (
  `cedula` int(8) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `edad` int(2) NOT NULL,
  `sexo` char(20) NOT NULL,
  `fecha_n` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `personal`(cedula,nombre,edad,sexo,fecha_n) VALUES (20390624, 'pedro perez', 22, 'Masculino', '2012-03-05');
INSERT INTO `personal`(cedula,nombre,edad,sexo,fecha_n) VALUES (20387902, 'rafael toro', 35, 'Masculino', '2012-03-30');
INSERT INTO `personal`(cedula,nombre,edad,sexo,fecha_n) VALUES (15070571, 'gloria ', 29, 'Femenino', '2006-03-16');
INSERT INTO `personal`(cedula,nombre,edad,sexo,fecha_n) VALUES (14677190, 'robert', 34, 'Masculino', '2015-03-20');
INSERT INTO `personal`(cedula,nombre,edad,sexo,fecha_n) VALUES (7599130, 'tobias', 40, 'Masculino', '2018-03-30');
INSERT INTO `personal`(cedula,nombre,edad,sexo,fecha_n) VALUES (19998894, 'luis', 45, 'Masculino', '2022-03-24');
