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
		$sql = "INSERT INTO planificacion (id, idperiodo_escolar, idgrado, idseccion, idambiente, iddocente, cupo, cupo_disponible, estatus) VALUES(NULL, '$idperiodo_escolar', '$idgrado', '$idseccion', '$idambiente', '$iddocente', '$cupo', '$cupo_disponible', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($id, $idgrado, $idseccion, $idambiente, $iddocente, $cupo, $cupo_disponible)
	{
		$sql = "UPDATE planificacion SET idgrado = '$idgrado', idseccion = '$idseccion', idambiente = '$idambiente', iddocente = '$iddocente', cupo = '$cupo', cupo_disponible = '$cupo_disponible' WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}

	#Método para listar 
	function listar($idperiodo)
	{
    if ($idperiodo == 'null') 
      $sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.estatus = 'Activo' ORDER BY g.grado, s.seccion";
    else 
      $sql = "SELECT p.*, pe.periodo, g.grado, s.seccion, a.ambiente, per.idpersona, persona.p_nombre, persona.p_apellido FROM planificacion p INNER JOIN periodo_escolar pe ON p.idperiodo_escolar = pe.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON s.id = p.idseccion INNER JOIN ambiente a ON a.id = p.idambiente INNER JOIN personal per ON per.id = p.iddocente INNER JOIN persona persona ON persona.id = per.idpersona WHERE p.idperiodo_escolar = '$idperiodo' ORDER BY g.grado, s.seccion";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar una planificación
	function mostrar($idplanificacion)
	{
		$sql = "SELECT p.*, g.grado, s.seccion, a.ambiente, pe.p_nombre, pe.p_apellido, per_es.periodo FROM planificacion p  INNER JOIN periodo_escolar per_es ON p.idperiodo_escolar = per_es.id INNER JOIN grado g ON p.idgrado = g.id INNER JOIN seccion s ON p.idseccion = s.id INNER JOIN ambiente a ON p.idambiente = a.id INNER JOIN personal per ON p.iddocente = per.id INNER JOIN persona pe ON per.idpersona = pe.id WHERE p.id = '$idplanificacion'";

		return ejecutarConsultaSimpleFila($sql);
	}

	function seleccionar_inscripciones_por_idplanificacion($idplanificacion)
  {
    $sql = "SELECT id, idplanificacion FROM inscripcion WHERE idplanificacion = '$idplanificacion'";
		return ejecutarConsulta($sql);
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
	function traersecciones($idgrado, $idplanificacion, $idperiodo_escolar)
	{
		if ($idplanificacion != NULL) {
			$sql = "SELECT s.* FROM seccion s WHERE s.estatus = 1 AND s.id NOT IN(SELECT idseccion FROM planificacion WHERE idgrado = '$idgrado' AND id != '$idplanificacion' AND idperiodo_escolar = '$idperiodo_escolar') ORDER BY s.seccion";
		}
		else {
			$sql = "SELECT s.* FROM seccion s WHERE s.estatus = 1 AND s.id NOT IN(SELECT idseccion FROM planificacion WHERE idgrado = '$idgrado' AND idperiodo_escolar = '$idperiodo_escolar') ORDER BY s.seccion";
		}

		return ejecutarConsulta($sql);
	}

	#Método para traer los ambientes que estén disponibles
	function traerambientes($idambiente, $idperiodo_escolar)
	{
		if ($idambiente != NULL) {
      if (empty($idperiodo_escolar)) 
        $sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion WHERE idambiente != $idambiente AND estatus = 'Activo') ORDER BY a.ambiente";
      else
			  $sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion WHERE idambiente != $idambiente AND idperiodo_escolar = '$idperiodo_escolar') ORDER BY a.ambiente";
		}
		else {	
      if (empty($idperiodo_escolar)) 
        $sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion WHERE estatus = 'Activo') ORDER BY a.ambiente";
      else
        $sql = "SELECT a.* FROM ambiente a WHERE a.estatus = 1 AND a.id NOT IN(SELECT idambiente FROM planificacion WHERE idperiodo_escolar = '$idperiodo_escolar') ORDER BY a.ambiente";
		}

		return ejecutarConsulta($sql);
	}

	#Método para traer los docentes
	function traerdocentes($iddocente, $idperiodo_escolar)
	{
		if ($iddocente != NULL) {
      if (empty($idperiodo_escolar)) 
        $sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion WHERE iddocente != $iddocente AND estatus = 'Activo')";
      else {
        $sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion WHERE iddocente != $iddocente AND idperiodo_escolar = '$idperiodo_escolar')";
      }
		}
		else{	
      if (empty($idperiodo_escolar)) 
        $sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion WHERE estatus = 'Activo')";
      else
			  $sql = "SELECT DISTINCT per.id, p.p_nombre, p.p_apellido FROM persona p INNER JOIN personal per ON p.id = per.idpersona WHERE per.cargo LIKE '%Docente%' AND per.estatus = 1 AND per.id NOT IN (SELECT iddocente FROM planificacion WHERE idperiodo_escolar = '$idperiodo_escolar')";
		}

		return ejecutarConsulta($sql);
	}

	#Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id FROM periodo_escolar WHERE estatus = 'Activo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para consultar los cupos de una planificación
	function verificarcupo($idplanificacion, $tipo)
	{
		$sql = "SELECT $tipo FROM planificacion WHERE id = '$idplanificacion'";
		return ejecutarConsultaSimpleFila($sql);
  }
  
  function traer_periodos_escolares()
  {
		$sql = "SELECT * FROM periodo_escolar";
		return ejecutarConsulta($sql);
  }

  function traer_periodos_activo_planificados()
  {
		$sql = "SELECT * FROM periodo_escolar WHERE estatus = 'Activo' OR estatus = 'Planificado'";
		return ejecutarConsulta($sql);
  }
	
}


