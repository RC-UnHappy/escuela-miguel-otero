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
	
}


