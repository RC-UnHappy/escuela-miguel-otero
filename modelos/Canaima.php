<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Canaima
 */
class Canaima 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idestudiante, $posee_canaima, $condicion)
	{
		$sql = "INSERT INTO canaima (id, idestudiante, posee_canaima, condicion) VALUES(NULL, '$idestudiante', '$posee_canaima', '$condicion')";

		return ejecutarConsulta($sql);

	}

	#Método para editar registros
	function editar($idestudiante, $posee_canaima, $condicion)
	{
		$sql = "UPDATE canaima SET posee_canaima = '$posee_canaima', condicion= '$condicion' WHERE idestudiante = '$idestudiante'";

		return ejecutarConsulta($sql);
		
	}

}