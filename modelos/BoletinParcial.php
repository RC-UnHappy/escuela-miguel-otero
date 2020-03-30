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
		return $sw;
	}
  
  #Método para insertar la recomendación 
  function insertar_recomendacion($idplanificacion, $idestudiantes, $lapso_academico, $recomendacion)
  {
    $sql = "INSERT INTO recomendacion (idplanificacion, idestudiante, lapso_academico, recomendacion) VALUES('$idplanificacion', '$idestudiantes' ,'$lapso_academico', '$recomendacion')";
    
    return ejecutarConsulta($sql);
  }

	#Método para editar registros
	function editar($idindicador, $idplanificacion_indicador, $idmateria_indicador, $lapso_indicador, $indicador)
	{
		$sql = "UPDATE indicador SET indicador = '$indicador' WHERE id = '$idindicador'";

		return ejecutarConsulta($sql);

  }
  
  #Método para editar registros
	function editar_proyecto_aprendizaje($idproyecto_aprendizaje, $proyecto_aprendizaje)
	{
		$sql = "UPDATE proyecto_aprendizaje SET proyecto_aprendizaje = '$proyecto_aprendizaje' WHERE id = '$idproyecto_aprendizaje'";

		return ejecutarConsulta($sql);

	}

	#Método para listar 
	function listar($idplanificaciones, $lapsos)
	{
    if (!empty($lapsos)) 
      $sql = "SELECT ind.*, ma.materia FROM indicador ind INNER JOIN materia ma ON ind.idmateria = ma.id WHERE ind.idplanificacion = '$idplanificaciones' AND ind.lapso_academico = '$lapsos' ORDER BY lapso_academico, ma.materia ASC";
    else 
      $sql = "SELECT ind.*, ma.materia FROM indicador ind INNER JOIN materia ma ON ind.idmateria = ma.id WHERE ind.idplanificacion = '$idplanificaciones' ORDER BY lapso_academico ASC";

		return ejecutarConsulta($sql);
  }
  
	#Método para listar los proyectos de aprendizaje
	function listarproyectoaprendizaje($idplanificacion)
	{
    $sql = "SELECT * FROM proyecto_aprendizaje WHERE idplanificacion = '$idplanificacion'";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un indicador
	function mostrar($idindicador)
	{
		$sql = "SELECT ind.*, g.grado, s.seccion, ma.materia, pe.p_nombre, pe.p_apellido FROM indicador ind  INNER JOIN planificacion pla ON ind.idplanificacion = pla.id INNER JOIN grado g ON pla.idgrado = g.id INNER JOIN seccion s ON pla.idseccion = s.id INNER JOIN materia ma ON ind.idmateria = ma.id INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona pe ON per.idpersona = pe.id WHERE ind.id = '$idindicador'";

		return ejecutarConsultaSimpleFila($sql);
  }
  
  #Método para mostrar un proyecto de aprendizaje
	function mostrarproyectoaprendizaje($idproyecto_aprendizaje)
	{
		$sql = "SELECT pa.*, g.grado, s.seccion, pe.p_nombre, pe.p_apellido FROM proyecto_aprendizaje pa  INNER JOIN planificacion pla ON pa.idplanificacion = pla.id INNER JOIN grado g ON pla.idgrado = g.id INNER JOIN seccion s ON pla.idseccion = s.id INNER JOIN personal per ON pla.iddocente = per.id INNER JOIN persona pe ON per.idpersona = pe.id WHERE pa.id = '$idproyecto_aprendizaje'";

		return ejecutarConsultaSimpleFila($sql);
	}


	function seleccionar_lapsos_finalizados($idperiodo_escolar)
  {
    $sql = "SELECT * FROM lapso_academico WHERE idperiodo_escolar = '$idperiodo_escolar' AND estatus = 'Finalizado'";
		return ejecutarConsulta($sql);
  }

	#Método para eliminar un indicador
	function eliminar($idindicador)
	{
		$sql = "DELETE FROM indicador WHERE id = $idindicador";

		return ejecutarConsulta($sql);
	}

	#Método para traer el id del período escolar activo
	function consultarperiodo()
	{
		$sql = "SELECT id FROM periodo_escolar WHERE estatus = 'Activo'";
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

  // function comprobar_proyecto_aprendizaje($idplanificacion_indicador, $lapso_indicador)
  // {
  //   $sql = "SELECT proyecto_aprendizaje FROM proyecto_aprendizaje WHERE idplanificacion = '$idplanificacion_indicador' AND lapso_academico =  '$lapso_indicador'";
  //   return ejecutarConsultaSimpleFila($sql);
  // }

  public function seleccionar_notas_estudiante($idestudiantes, $idplanificacion, $lapso_en_curso)
  {
    $sql = "SELECT * FROM indicador_nota WHERE idestudiante = '$idestudiantes' AND idplanificacion = '$idplanificacion' AND lapso_academico = '$lapso_en_curso'";
   
    return ejecutarConsulta($sql);
  }
	
}


