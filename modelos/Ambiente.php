<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Ambiente
 */
class Ambiente
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($ambiente, $estatus)
	{
		$sql = "INSERT INTO ambiente (ambiente, estatus) VALUES('$ambiente', '$estatus')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idambiente, $ambiente, $estatus)
	{
		$sql = "UPDATE ambiente SET ambiente='$ambiente', estatus = '$estatus' WHERE id = '$idambiente'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos los ambientes
	function listar()
	{
		$sql = "SELECT * FROM ambiente";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un ambiente
	function mostrar($idambiente)
	{
		$sql = "SELECT * FROM ambiente WHERE id = '$idambiente'";

		return ejecutarConsultaSimpleFila($sql);
	}

	

	#Método para desactivar ambiente
	function desactivar($idambiente)
	{
		$sql = "UPDATE ambiente SET estatus = '0' WHERE id = '$idambiente'";

		return ejecutarConsulta($sql);

	}

	#Método para activar ambiente
	function activar($idambiente)
	{
		$sql = "UPDATE ambiente SET estatus = '1' WHERE id = '$idambiente'";

		return ejecutarConsulta($sql);

	}

	#Método para comprobar si existe el ambiente
	function comprobarambiente($ambiente)
	{
		$sql = "SELECT ambiente FROM ambiente WHERE ambiente = '$ambiente'";
		return ejecutarConsulta($sql);
	}
	
}


