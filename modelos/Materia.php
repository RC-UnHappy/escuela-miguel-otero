<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Materia
 */
class Materia
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($materia, $estatus)
	{
		$sql = "INSERT INTO materia (materia, estatus) VALUES('$materia', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idmateria, $materia, $estatus)
	{
		$sql = "UPDATE materia SET materia='$materia', estatus = '$estatus' WHERE id = '$idmateria'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos las materiaes
	function listar()
	{
		$sql = "SELECT * FROM materia";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar una materia
	function mostrar($idmateria)
	{
		$sql = "SELECT * FROM materia WHERE id = '$idmateria'";

		return ejecutarConsultaSimpleFila($sql);
	}

	

	#Método para desactivar materia
	function desactivar($idmateria)
	{
		$sql = "UPDATE materia SET estatus = '0' WHERE id = '$idmateria'";

		return ejecutarConsulta($sql);

	}

	#Método para activar materia
	function activar($idmateria)
	{
		$sql = "UPDATE materia SET estatus = '1' WHERE id = '$idmateria'";

		return ejecutarConsulta($sql);

	}

	#Método para comprobar si existe la materia
	function comprobarmateria($materia)
	{
		$sql = "SELECT materia FROM materia WHERE materia = '$materia'";
		return ejecutarConsulta($sql);
	}
	
}


