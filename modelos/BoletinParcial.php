<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de BoletinParcial
 */
class BoletinParcial
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}
 
	#Método para insertar indicador
	function insertar($idplanificacion, $idestudiantes, $lapso_academico, $notas)
	{
    $sw = TRUE;
    if (!empty($notas)) {
      foreach ($notas as $key => $value) {
        $sql = "INSERT INTO indicador_nota (idplanificacion, idindicador, idestudiante, lapso_academico, nota) VALUES('$idplanificacion', '$key', '$idestudiantes', '$lapso_academico', '$value')" or $sw = FALSE;   
        ejecutarConsulta($sql);   
      }
    }
    else {
      $sw = FALSE;
    } 
		return $sw;
  }
  
  #Método para eliminar todos los indicadores de un estudiante
	function eliminar_indicadores($idplanificacion, $idestudiantes, $lapso_academico)
	{  
    $sql = "DELETE FROM indicador_nota WHERE idplanificacion = '$idplanificacion' AND idestudiante = '$idestudiantes' AND lapso_academico = '$lapso_academico'";            

		return ejecutarConsulta($sql); 
	}
  
  #Método para insertar la recomendación 
  function insertar_recomendacion($idplanificacion, $idestudiantes, $lapso_academico, $recomendacion)
  {
    $sql = "INSERT INTO recomendacion (idplanificacion, idestudiante, lapso_academico, recomendacion) VALUES('$idplanificacion', '$idestudiantes' ,'$lapso_academico', '$recomendacion')";
    
    return ejecutarConsulta($sql);
  }

  #Método para insertar la recomendación 
  function editar_recomendacion($idrecomendacion, $recomendacion)
  {
    $sql = "UPDATE recomendacion SET recomendacion = '$recomendacion' WHERE id = '$idrecomendacion'";
    
    return ejecutarConsulta($sql);
  }

	#Método para listar 
	function listar($idplanificacion, $lapso, $idestudiantes)
	{
      $sql = "SELECT in_no.*, ma.materia, ind.indicador FROM indicador_nota in_no INNER JOIN indicador ind ON in_no.idindicador = ind.id INNER JOIN materia ma ON ind.idmateria = ma.id WHERE in_no.idplanificacion = '$idplanificacion' AND in_no.lapso_academico = '$lapso' AND in_no.idestudiante = '$idestudiantes' ORDER BY ma.materia";

		return ejecutarConsulta($sql);
  }
  
  #Método para traer la recomendación de un estudiante
	function traerrecomendacion($idplanificacion, $idestudiantes, $lapso_en_curso)
	{
		$sql = "SELECT * FROM recomendacion WHERE idplanificacion = '$idplanificacion' AND idestudiante = '$idestudiantes' AND lapso_academico = '$lapso_en_curso'";

		return ejecutarConsultaSimpleFila($sql);
	}


	function seleccionar_lapsos_finalizados($idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' AND estatus = 'Finalizado'";
		return ejecutarConsulta($sql);
  }

	#Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id, periodo FROM periodo_escolar WHERE estatus = 'Activo'";
		return ejecutarConsultaSimpleFila($sql);
	}

  #Método para mostrar las planificaciones activas
  public function traerplanificaciones()
  {
      $sql = "SELECT pla.id, gra.grado, sec.seccion, p.p_nombre, p.p_apellido FROM planificacion pla INNER JOIN grado gra ON gra.id = pla.idgrado INNER JOIN seccion sec ON sec.id = idseccion INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona p ON per.idpersona = p.id WHERE pla.estatus = 'Activo'";
      return ejecutarConsulta($sql);
  }

  #Método para mostrar los estudiantes de una planificación
  public function traerestudiantes($idplanificacion)
  {
    $sql = "SELECT ins.idestudiante, per.p_nombre, per.s_nombre, per.p_apellido, per.s_apellido FROM inscripcion ins INNER JOIN estudiante est ON ins.idestudiante = est.id INNER JOIN persona per ON est.idpersona = per.id  WHERE ins.idplanificacion = '$idplanificacion'";
    return ejecutarConsulta($sql);
  }

  #Método para listar los indicadores según la planificación y lapso
  public function listarindicadores($idplanificacion, $lapso)
  {
      $sql = "SELECT ind.*, mat.materia FROM indicador ind INNER JOIN materia mat ON ind.idmateria = mat.id WHERE idplanificacion = '$idplanificacion' AND ind.lapso_academico = '$lapso' ORDER BY mat.materia ASC";
      return ejecutarConsulta($sql);
  }

  #Método para traer el lapso activo
  public function traerlapsoencurso($idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' AND estatus = 'Activo'";
    
    return ejecutarConsulta($sql);
  }

  #Método para mostrar los lapsos para el select que actualiza la tabla
  public function traerlapsosgeneral($idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' ORDER BY lapso ASC";
    return ejecutarConsulta($sql);
  }

  public function seleccionar_notas_estudiante($idestudiantes, $idplanificacion, $lapso_en_curso)
  {
    $sql = "SELECT * FROM indicador_nota WHERE idestudiante = '$idestudiantes' AND idplanificacion = '$idplanificacion' AND lapso_academico = '$lapso_en_curso'";
   
    return ejecutarConsulta($sql);
  }

  public function datos_reporte($idplanificacion, $lapso, $idestudiante)
  {
    $sql = "SELECT gra.grado, sec.seccion, perdoc.p_nombre, perdoc.p_apellido, p_a.proyecto_aprendizaje, p_a.lapso_academico, personaes.cedula, personaes.p_nombre as p_nombre_estudiante, personaes.s_nombre as s_nombre_estudiante, personaes.p_apellido as p_apellido_estudiante, personaes.s_apellido as s_apellido_estudiante, rec.recomendacion FROM planificacion pla INNER JOIN grado gra ON pla.idgrado = gra.id INNER JOIN seccion sec ON pla.idseccion = sec.id INNER JOIN personal personal ON pla.iddocente = personal.id INNER JOIN persona perdoc ON personal.idpersona = perdoc.id INNER JOIN proyecto_aprendizaje p_a ON pla.id = p_a.idplanificacion AND p_a.lapso_academico = '$lapso' INNER JOIN estudiante est ON est.id = '$idestudiante' INNER JOIN persona personaes ON est.idpersona = personaes.id INNER JOIN recomendacion rec ON pla.id = rec.idplanificacion AND rec.idestudiante = '$idestudiante' AND rec.lapso_academico = '$lapso' WHERE pla.id = '$idplanificacion'";

    return ejecutarConsultaSimpleFila($sql);
  }

  public function datos_institucion()
  {
    $sql = "SELECT * FROM institucion";

    return ejecutarConsultaSimpleFila($sql);
  }
	
}


