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
	function insertar($idperiodo_escolar, $idgrado, $idseccion, $idambiente, $iddocente, $cupo, $cupo_disponible, $estatus)
	{
		$sql = "INSERT INTO planificacion (id, idperiodo_escolar, idgrado, idseccion, idambiente, iddocente, cupo, cupo_disponible, estatus) VALUES(NULL, '$idperiodo_escolar', '$idgrado', '$idseccion', '$idambiente', '$iddocente', '$cupo', '$cupo_disponible', $estatus)";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($id, $idgrado, $idseccion, $idambiente, $iddocente, $cupo, $cupo_disponible)
	{
		$sql = "UPDATE planificacion SET idgrado = '$idgrado', idseccion = '$idseccion', idambiente = '$idambiente', iddocente = '$iddocente', cupo = '$cupo', cupo_disponible = '$cupo_disponible' WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}

	#Método para listar 
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

	

	#Método para eliminar planificación
	function eliminar($idplanificacion)
	{
		$sql = "DELETE FROM planificacion WHERE id = $idplanificacion";

		return ejecutarConsulta($sql);

	}

	#Método para traer los grados que estén disponibles
	function traergrados()
	{
		$sql = "SELECT * FROM grado WHERE estatus = 1";
		return ejecutarConsulta($sql);
	}

	#Método para traer las secciones que estén disponibles
	function traersecciones($idgrado, $idplanificacion)
	{
		if ($idplanificacion != NULL) {
			$sql = "SELECT s.* FROM seccion s WHERE s.estatus = 1 AND s.id NOT IN(SELECT idseccion FROM planificacion WHERE idgrado = '$idgrado' AND id != '$idplanificacion') ORDER BY s.seccion";
		}
		else {
			$sql = "SELECT s.* FROM seccion s WHERE s.estatus = 1 AND s.id NOT IN(SELECT idseccion FROM planificacion WHERE idgrado = '$idgrado') ORDER BY s.seccion";
		}

		return ejecutarConsulta($sql);
	}

	#Método para traer los ambientes que estén disponibles
	function traerambientes($idambiente)
	{
		if ($idambiente != NULL) {
			$sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion WHERE idambiente != $idambiente) ORDER BY a.ambiente";
		}
		else {	
			$sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion) ORDER BY a.ambiente";
		}

		return ejecutarConsulta($sql);
	}

	#Método para traer los docentes
	function traerdocentes($iddocente)
	{
		if ($iddocente != NULL) {
			$sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion WHERE iddocente != $iddocente)";
		}
		else{	
			$sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion)";
		}

		return ejecutarConsulta($sql);
	}

	#Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id FROM periodo_escolar WHERE estatus = 1";
		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para consultar los cupos de una planificación
	function verificarcupodisponible($idplanificacion)
	{
		$sql = "SELECT cupo FROM planificacion WHERE id = '$idplanificacion'";
		return ejecutarConsultaSimpleFila($sql);
	}
	
}


