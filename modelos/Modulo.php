<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Modulo
 */
class Modulo
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para listar todos los módulos
	function listar()
	{
		$sql = "SELECT * FROM modulo";

		return ejecutarConsulta($sql);
	}
	
}


