<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Permiso
 */
class Permiso 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	protected function insertar($permiso)
	{
		$sql = "INSERT INTO permiso (id, permiso) VALUES(NULL, '$permiso')";

		return ejecutarConsulta($sql);

	}

	#Método para editar registros
	protected function editar($id, $permiso)
	{
		$sql = "UPDATE permiso SET permiso='$permiso' WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}

	#Método para listar los registros
	public function listar()
	{
		$sql = "SELECT * FROM permiso";

		return ejecutarConsulta($sql);
	}
}