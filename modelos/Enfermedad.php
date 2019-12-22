<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Enfermedad
 */
class Enfermedad 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idestudiante, $enfermedad)
	{
		$sw = TRUE;
		for ($i=0; $i < count($enfermedad) ; $i++) { 
			$sql = "INSERT INTO enfermedad (id, idestudiante, enfermedad) VALUES(NULL, '$idestudiante', '$enfermedad[$i]')";

			ejecutarConsulta($sql) or $sw = FALSE;
		}

		return $sw;
	}

	#Método para eliminar registros
	function eliminar($idestudiante)
	{
		$sql = "DELETE FROM enfermedad WHERE idestudiante = '$idestudiante'";

		return ejecutarConsulta($sql);	
	}

}