<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Grado
 */
class Grado
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($grado, $estatus)
	{
		$sql = "INSERT INTO grado (grado, estatus) VALUES('$grado', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idgrado, $grado, $estatus)
	{
		$sql = "UPDATE grado SET grado='$grado', estatus = '$estatus' WHERE id = '$idgrado'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos los grados
	function listar()
	{
		$sql = "SELECT * FROM grado";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un grado
	function mostrar($idgrado)
	{
		$sql = "SELECT * FROM grado WHERE id = '$idgrado'";

		return ejecutarConsultaSimpleFila($sql);
	}

	

	#Método para desactivar grado
	function desactivar($idgrado)
	{
		$sql = "UPDATE grado SET estatus = '0' WHERE id = '$idgrado'";

		return ejecutarConsulta($sql);

	}

	#Método para activar grado
	function activar($idgrado)
	{
		$sql = "UPDATE grado SET estatus = '1' WHERE id = '$idgrado'";

		return ejecutarConsulta($sql);

	}

	#Método para comprobar si existe el grado
	function comprobargrado($grado)
	{
		$sql = "SELECT grado FROM grado WHERE grado = '$grado'";
		return ejecutarConsulta($sql);
	}
	
}


