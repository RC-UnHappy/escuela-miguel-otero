<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de HistorialEstudiantil
 */
class HistorialEstudiantil
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}
 
	#Método para insertar indicador
	function insertar($periodo_escolar, $turno, $grado, $seccion, $cedula_docente, $nombre_docente, $apellido_docente, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante, $fecha_nacimiento_estudiante, $lugar_nacimiento_estudiante, $sexo_estudiante, $literal, $estatus, $observaciones  )
	{
    $sql = "INSERT INTO historial_estudiantil (periodo_escolar, turno, grado, seccion, cedula_docente, nombre_docente, apellido_docente, cedula_estudiante, p_nombre_estudiante, s_nombre_estudiante, p_apellido_estudiante, s_apellido_estudiante, fecha_nacimiento_estudiante, lugar_nacimiento_estudiante, sexo_estudiante, literal, estatus, observaciones, fecha_creacion) VALUES('$periodo_escolar', '$turno', '$grado', '$seccion', '$cedula_docente', '$nombre_docente', '$apellido_docente', '$cedula_estudiante', '$p_nombre_estudiante', '$s_nombre_estudiante', '$p_apellido_estudiante', '$s_apellido_estudiante', '$fecha_nacimiento_estudiante', '$lugar_nacimiento_estudiante', '$sexo_estudiante', '$literal', '$estatus', '$observaciones', NOW() )";

		return ejecutarConsulta($sql);
  }

	#Método para listar 
	function listar($periodo_escolar = null)
	{
    if (!empty($periodo_escolar)) {
      $sql = "SELECT * FROM vista_historial_estudiantil a WHERE periodo_escolar = '$periodo_escolar' ORDER BY periodo_escolar, grado, seccion ASC";
    }
    else {
      $sql = "SELECT * FROM vista_historial_estudiantil a ORDER BY periodo_escolar, grado, seccion ASC";
    }

		return ejecutarConsulta($sql);
  }

  public function datos_reporte($idplanificacion, $lapso, $idestudiante)
  {
    $sql = "SELECT gra.grado, sec.seccion, perdoc.p_nombre, perdoc.p_apellido, p_a.proyecto_aprendizaje, p_a.lapso_academico, personaes.cedula, personaes.p_nombre as p_nombre_estudiante, personaes.s_nombre as s_nombre_estudiante, personaes.p_apellido as p_apellido_estudiante, personaes.s_apellido as s_apellido_estudiante, rec.recomendacion FROM planificacion pla INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id INNER JOIN personal personal ON pla.iddocente = personal.id INNER JOIN persona perdoc ON personal.idpersona = perdoc.id INNER JOIN proyecto_aprendizaje p_a ON pla.id = p_a.idplanificacion AND p_a.lapso_academico = '$lapso' INNER JOIN estudiante est ON est.id = '$idestudiante' INNER JOIN persona personaes ON est.idpersona = personaes.id INNER JOIN recomendacion rec ON pla.id = rec.idplanificacion AND rec.idestudiante = '$idestudiante' AND rec.lapso_academico = '$lapso' WHERE pla.id = '$idplanificacion'";

    return ejecutarConsultaSimpleFila($sql);
  }

  public function fecha_creacion_escuela()
  {
    $sql = "SELECT fecha_fundada FROM institucion";

    return ejecutarConsultaSimpleFila($sql);
  }

  public function traer_turno()
  {
    $sql = "SELECT turno FROM institucion";

    return ejecutarConsultaSimpleFila($sql);
  }

  #destructor de la clase
  public function __destruct()
  {
    cerrarConexion();
  }
	
}


