<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Lapso Académico
 */
class LapsoAcademico
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idperiodo_escolar, $lapso_academico, $fecha_inicio, $fecha_fin , $estatus)
	{
		$sql = "INSERT INTO lapso_academico (idperiodo_escolar, lapso, fecha_inicio, fecha_fin, estatus) VALUES('$idperiodo_escolar', '$lapso_academico', '$fecha_inicio', '$fecha_fin', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para listar 
	function listar($idperiodo)
	{
		$sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo' ORDER BY lapso ASC";
		return ejecutarConsulta($sql);
	}

	#Método para mostrar un lapso académico
	function mostrar($idlapsoacademico)
	{
		$sql = "SELECT la.*, pe.periodo FROM lapso_academico la INNER JOIN periodo_escolar pe ON la.idperiodo_escolar = pe.id WHERE la.id = '$idlapsoacademico'";

		return ejecutarConsultaSimpleFila($sql);
  }
  
  #Método para editar registros
	function editar($idperiodo, $periodo, $fecha_inicio, $fecha_fin, $estatus)
	{
		$sql = "UPDATE periodo_escolar SET fecha_creacion = '$fecha_inicio', fecha_finalizacion = '$fecha_fin' WHERE id = '$idperiodo'";

		return ejecutarConsulta($sql);
	}

  #Método para activar un lapso académico
	function activar($idlapsoacademico)
	{
		$sql = "UPDATE lapso_academico SET estatus = 'Activo' WHERE id = '$idlapsoacademico'";

		return ejecutarConsulta($sql);
	}

	#Método para desactivar un lapso académico
	function finalizar($idlapsoacademico)
	{
		$sql = "UPDATE lapso_academico SET estatus = 'Finalizado' WHERE id = '$idlapsoacademico'";

		return ejecutarConsulta($sql);
  }

	#Método para traer el último perido
	function traerlapsos($idperiodo)
	{
		$sql = "SELECT * FROM lapso WHERE estatus = 1 AND lapso NOT IN (SELECT lapso FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo') ORDER BY lapso ASC";
		return ejecutarConsulta($sql);
  }

  function verificar_fecha_fin_lapso($lapso, $idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE lapso = '$lapso' AND idperiodo_escolar = '$idperiodo_escolar'";
		return ejecutarConsultaSimpleFila($sql);
  }

  function verificar_fecha_inicio_lapso($lapso, $idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE lapso = '$lapso' AND idperiodo_escolar = '$idperiodo_escolar'";
		return ejecutarConsultaSimpleFila($sql);
  }
  
  function verificar_fecha_fin_ultimo_lapso($idperiodo)
  {
    $sql = "SELECT MAX(lapso) as lapso, fecha_fin FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo' AND estatus = 'Finalizado'";
		return ejecutarConsultaSimpleFila($sql);
  }

  function verificar_por_periodo($periodo)
  {
    $sql = "SELECT * FROM periodo_escolar WHERE periodo = '$periodo'";
    return ejecutarConsultaSimpleFila($sql);
  }

  function verificar_periodo_activo()
  {
    $sql = "SELECT * FROM periodo_escolar WHERE estatus = 'Activo'";
    return ejecutarConsultaSimpleFila($sql);
  }

  function verificar_lapso_activo()
  {
    $sql = "SELECT * FROM lapso_academico WHERE estatus = 'Activo'";
    return ejecutarConsultaSimpleFila($sql);
  }

  function traer_planificaciones_activas()
  {
    $sql = "SELECT * FROM planificacion WHERE estatus = 'Activo'";

    return ejecutarConsulta($sql);
  }

  function traer_total_indicadores($idplanificacion, $lapso)
  {
    $sql = "SELECT COUNT(id) as total FROM indicador WHERE idplanificacion = '$idplanificacion' AND lapso_academico = '$lapso'";

    return ejecutarConsultaSimpleFila($sql);
  }

  
  function traer_inscripciones_planificacion($idplanificacion, $idperiodo_escolar)
  {
    $sql = "SELECT * FROM inscripcion WHERE idplanificacion = '$idplanificacion' AND idperiodo_escolar = '$idperiodo_escolar'";

    return ejecutarConsulta($sql);
  }

  function comprobar_cantidad_indicadores_estudiante($idplanificacion, $idestudiante)
  {
    $sql = "SELECT COUNT(id) as cantidad_notas FROM indicador_nota WHERE idplanificacion = '$idplanificacion' AND idestudiante = '$idestudiante'";

    return ejecutarConsultaSimpleFila($sql);
  }

 public function traerplanificacion($idplanificacion)
  {
      $sql = "SELECT pla.id, gra.grado, sec.seccion, p.p_nombre, p.p_apellido FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE pla.id = '$idplanificacion'";
      return ejecutarConsultaSimpleFila($sql);
  }

 public function traerestudiante($idestudiante)
  {
      $sql = "SELECT per.cedula, per.p_nombre, per.p_apellido FROM estudiante est INNER JOIN persona per ON est.idpersona = per.id WHERE est.id = '$idestudiante'";
      return ejecutarConsultaSimpleFila($sql);
  }
	
}