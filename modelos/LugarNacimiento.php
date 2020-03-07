<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Lugar Nacimiento
 */
class LugarNacimiento
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idestudiante, $idparroquia)
	{
		$sql = "INSERT INTO lugar_nacimiento (id, idestudiante, idparroquia) VALUES(NULL, '$idestudiante', '$idparroquia')";

		return ejecutarConsulta($sql);

	}

	#Método para editar registros
	function editar($idestudiante, $idparroquia)
	{
		$sql = "UPDATE lugar_nacimiento SET idparroquia = '$idparroquia' WHERE idestudiante = '$idestudiante'";

		return ejecutarConsulta($sql);
		
	}

	/**
	 * Método para verificar si un estudiante tiene un registro en la tabla lugar de nacimiento
	 *
	 * @param integer $idestudiante
	 * @return void
	 */
	function verificar($idestudiante)
	{
		$sql = "SELECT * FROM lugar_nacimiento WHERE idestudiante = '$idestudiante'";

		return ejecutarConsultaSimpleFila($sql);
	}

}