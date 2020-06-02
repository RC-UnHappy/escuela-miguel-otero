<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Período Escolar
 */
class PeriodoEscolar
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($periodo, $fecha_inicio, $fecha_fin, $estatus)
	{
		$sql = "INSERT INTO periodo_escolar (periodo, fecha_creacion, fecha_finalizacion, estatus) VALUES('$periodo', '$fecha_inicio', '$fecha_fin', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para listar 
	function listar()
	{
		$sql = "SELECT * FROM periodo_escolar ORDER BY periodo DESC";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un período escolar
	function mostrar($idperiodo)
	{
		$sql = "SELECT * FROM periodo_escolar WHERE id = '$idperiodo'";

		return ejecutarConsultaSimpleFila($sql);
  }
  
  #Método para editar registros
	function editar($idperiodo, $periodo, $fecha_inicio, $fecha_fin, $estatus)
	{
		$sql = "UPDATE periodo_escolar SET fecha_creacion = '$fecha_inicio', fecha_finalizacion = '$fecha_fin' WHERE id = '$idperiodo'";

		return ejecutarConsulta($sql);
	}

	#Método para seleccionar un período escolar 
	function seleccionar($periodo)
	{
		$sql = "SELECT * FROM periodo_escolar WHERE periodo = '$periodo'";

		return ejecutarConsultaSimpleFila($sql);
  }
  
  #Método para activar un período escolar
	function activar($idperiodo)
	{
		$sql = "UPDATE periodo_escolar SET estatus = 'Activo', fecha_creacion = CURDATE() WHERE id = '$idperiodo'";

		return ejecutarConsulta($sql);
	}

	#Método para desactivar un período escolar
	function finalizar($idperiodo)
	{
		$sql = "UPDATE periodo_escolar SET estatus = 'Finalizado', fecha_finalizacion = CURDATE() WHERE id = '$idperiodo'";

		return ejecutarConsulta($sql);
  }

	#Método para traer el último perido
	function traerultimo()
	{
		$sql = "SELECT * FROM periodo_escolar ORDER BY id DESC LIMIT 1";
		return ejecutarConsultaSimpleFila($sql);
  }
  
  function verificar_ultimo_finalizado()
  {
    $sql = "SELECT * FROM periodo_escolar WHERE estatus = 'Finalizado' ORDER BY id DESC LIMIT 1";
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

  public function comprobar_lapsos_finalizados($idperiodo)
  {
    $sql = "SELECT COUNT(id) AS lapsos_finalizados FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo' AND estatus = 'Finalizado'";

    return ejecutarConsultaSimpleFila($sql);
  }

  public function comprobar_todos_lapsos_periodo($idperiodo)
  {
    $sql = "SELECT COUNT(id) AS todo_lapsos FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo'";
    return ejecutarConsultaSimpleFila($sql);
  }

  public function verificar_lapso_activo()
  {
    $sql = "SELECT * FROM lapso_academico WHERE estatus = 'Activo'";
    return ejecutarConsultaSimpleFila($sql);
  }

  function verificarUltimoLapso($idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' ORDER BY id DESC LIMIT 1";
		return ejecutarConsultaSimpleFila($sql);
  }

  function getActiveSchedules()
  {
    $sql = "SELECT * FROM planificacion WHERE estatus = 'Activo'";

    return ejecutarConsulta($sql);
  }

  function getRegistrationsByScheduleId(int $scheduleId)
  {
    $sql = "SELECT * FROM inscripcion WHERE idplanificacion = '$scheduleId'";

    return ejecutarConsulta($sql);
  }

  public static function verifyFinalReportCardByStudent(int $studentId, int $scheduleId)
  {

	$sql = "SELECT * FROM boletin_final WHERE idestudiante = '$studentId' AND idplanificacion = '$scheduleId'";

	return ejecutarConsultaSimpleFila($sql);

  }

  public static function getScheduleData($scheduleId)
  {
  	$sql = "SELECT pla.id, gra.grado, sec.seccion, p.p_nombre, p.p_apellido FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE pla.id = '$scheduleId'";

  	return ejecutarConsultaSimpleFila($sql);
  }

  /**
   * Obtiene todos los estudiantes que pertenezcan a una planificación
   * @param type $studentsId 
   * @return type resource
   */
  public function getStudentsData($studentsId)
  {
  	$studentsId = implode(',', $studentsId);

  	$sql = "SELECT per.cedula, per.p_nombre, per.p_apellido FROM estudiante est INNER JOIN persona per ON est.idpersona = per.id WHERE est.id IN('$studentsId')";

	return ejecutarConsulta($sql);

  }

  public function traerultimolapso($idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' ORDER BY id DESC LIMIT 1";

    return ejecutarConsultaSimpleFila($sql);
  }

  public function finalizarpic($idperiodo_activo)
  {
    $sql = "UPDATE pic SET estatus = 'Finalizado' WHERE idperiodo_escolar = '$idperiodo_activo'";

    return ejecutarConsulta($sql);
  }	

  public function finalizarplanificaciones($idperiodo_activo)
  {
    $sql = "UPDATE planificacion SET estatus = 'Finalizado' WHERE idperiodo_escolar = '$idperiodo_activo'";

    return ejecutarConsulta($sql);
  }

}


