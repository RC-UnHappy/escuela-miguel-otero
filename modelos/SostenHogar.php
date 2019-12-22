<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Sosten de Hogar
 */
class SostenHogar 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idestudiante, $sosten)
	{
		$sw = TRUE;
		for ($i=0; $i < count($sosten) ; $i++) { 
			$sql = "INSERT INTO sosten_hogar (id, idestudiante, sosten) VALUES(NULL, '$idestudiante', '$sosten[$i]')";

			ejecutarConsulta($sql) or $sw = FALSE;
		}

		return $sw;

	}

	#Método para eliminar registros
	function eliminar($idestudiante)
	{
		$sql = "DELETE FROM sosten_hogar WHERE idestudiante = '$idestudiante'";

		return ejecutarConsulta($sql);
		
	}

}