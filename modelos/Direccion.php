<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Dirección
 */
class Direccion 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idpersona, $idparroquia, $direccion)
	{
		$sql = "INSERT INTO direccion (id, idpersona, idparroquia, direccion) VALUES(NULL, '$idpersona', '$idparroquia', '$direccion')";

		return ejecutarConsulta($sql);

	}

	#Método para editar registros
	function editar($idpersona, $idparroquia, $direccion)
	{
		$sql = "UPDATE direccion SET idparroquia = '$idparroquia', direccion = '$direccion' WHERE idpersona = '$idpersona'";

		return ejecutarConsulta($sql);

	}

}