<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Usuario
 */
class Telefono
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idpersona, $telefono, $tipo)
	{
		$sql = "INSERT INTO telefono (idpersona, telefono, tipo) VALUES('$idpersona', '$telefono', '$tipo')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idpersona, $telefono, $tipo)
	{
		$sql = "UPDATE telefono SET telefono = '$telefono', tipo = '$tipo' WHERE idpersona = '$idpersona'";

		return ejecutarConsulta($sql);
		
	}

	

}


