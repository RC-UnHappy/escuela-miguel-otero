<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Aspecto Fisiológico
 */
class AspectoFisiologico 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idestudiante, $todas_vacunas, $peso, $talla, $alergico)
	{
		$sql = "INSERT INTO aspecto_fisiologico (id, idestudiante, todas_vacunas, peso, talla, alergico) VALUES(NULL, '$idestudiante', '$todas_vacunas', '$peso', '$talla', '$alergico')";

		return ejecutarConsulta($sql);

	}

	#Método para editar registros
	function editar($idestudiante, $vacunas, $peso, $talla, $alergico)
	{
		$sql = "UPDATE aspecto_fisiologico SET todas_vacunas = '$vacunas', peso = '$peso', talla = '$talla', alergico = '$alergico' WHERE idestudiante = '$idestudiante'";

		return ejecutarConsulta($sql);

	}

}