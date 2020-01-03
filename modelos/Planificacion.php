<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de planificación
 */
class Planificacion
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idperiodo_escolar, $idgrado, $idseccion, $idambiente, $iddocente, $cupo, $estatus)
	{
		$sql = "INSERT INTO planificacion (id, idperiodo_escolar, idgrado, idseccion, idambiente, iddocente, cupo, estatus) VALUES(NULL, '$idperiodo_escolar', '$idgrado', '$idseccion', '$idambiente', '$iddocente', '$cupo', $estatus)";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idseccion, $seccion, $estatus)
	{
		$sql = "UPDATE seccion SET seccion='$seccion', estatus = '$estatus' WHERE id = '$idseccion'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos las secciones
	function listar()
	{
		$sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.estatus = 1 ORDER BY g.grado, s.seccion";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar una planificación
	function mostrar($idplanificacion)
	{
		$sql = "SELECT p.*, g.grado, s.seccion, a.ambiente, pe.p_nombre, pe.p_apellido FROM planificacion p  INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON p.idseccion = s.id INNER JOIN ambiente a ON p.idambiente = a.id INNER JOIN personal per ON p.iddocente = per.id INNER JOIN persona pe ON per.idpersona = pe.id WHERE p.id = '$idplanificacion'";

		return ejecutarConsultaSimpleFila($sql);
	}

	

	#Método para desactivar ambiente
	function desactivar($idseccion)
	{
		$sql = "UPDATE seccion SET estatus = '0' WHERE id = '$idseccion'";

		return ejecutarConsulta($sql);

	}

	#Método para activar ambiente
	function activar($idseccion)
	{
		$sql = "UPDATE seccion SET estatus = '1' WHERE id = '$idseccion'";

		return ejecutarConsulta($sql);

	}

	#Método para traer los grados que estén disponibles
	function traergrados()
	{
		$sql = "SELECT * FROM grado WHERE estatus = 1";
		return ejecutarConsulta($sql);
	}

	#Método para traer las secciones que estén disponibles
	function traersecciones($idgrado)
	{
		$sql = "SELECT s.* FROM seccion s WHERE s.estatus = 1 AND s.id NOT IN(SELECT idseccion FROM planificacion WHERE idgrado = '$idgrado') ORDER BY s.seccion";

		return ejecutarConsulta($sql);
	}

	#Método para traer los ambientes que estén disponibles
	function traerambientes()
	{
		$sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion) ORDER BY a.ambiente";

		return ejecutarConsulta($sql);
	}

	#Método para traer las secciones que estén disponibles
	function traerdocentes()
	{
		$sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion)";

		return ejecutarConsulta($sql);
	}

	#Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id FROM periodo_escolar WHERE estatus = 1";
		return ejecutarConsultaSimpleFila($sql);
	}
	
}


