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
	function insertar($periodo, $estatus)
	{
		$sql = "INSERT INTO periodo_escolar (periodo, fecha_creacion, estatus) VALUES('$periodo', CURDATE(), $estatus)";

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

	#Método para seleccionar un período escolar 
	function seleccionar($periodo)
	{
		$sql = "SELECT * FROM periodo_escolar WHERE periodo = '$periodo'";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para verificar si hay período activo
	function verificar()
	{
		$sql = "SELECT * FROM periodo_escolar WHERE estatus = 1";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para desactivar un período escolar
	function desactivar($idperiodo)
	{
		$sql = "UPDATE periodo_escolar SET estatus = '0', fecha_finalizacion = CURDATE() WHERE id = '$idperiodo'";

		return ejecutarConsulta($sql);

	}

	#Método para activar un período escolar
	function activar($idperiodo)
	{
		$sql = "UPDATE periodo_escolar SET estatus = '1' WHERE id = '$idperiodo'";

		return ejecutarConsulta($sql);

	}

	#Método para traer el último perido
	function traerultimo()
	{
		$sql = "SELECT * FROM periodo_escolar ORDER BY id DESC LIMIT 1";
		return ejecutarConsultaSimpleFila($sql);
	}
	
}


