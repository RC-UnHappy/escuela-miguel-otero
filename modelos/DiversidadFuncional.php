<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Diversidad Funcional
 */
class DiversidadFuncional 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idestudiante, $diversidad)
	{	
		$sw = TRUE;

		if ($diversidad != '') {
			for ($i=0; $i < count($diversidad) ; $i++) { 
				$sql = "INSERT INTO diversidad_funcional (id, idestudiante, diversidad) VALUES(NULL, '$idestudiante', '$diversidad[$i]')";
	
				ejecutarConsulta($sql) or $sw = FALSE;
			}
		}

		return $sw;

	}

	#Método para eliminar registros
	function eliminar($idestudiante)
	{
		$sql = "DELETE FROM diversidad_funcional WHERE idestudiante = '$idestudiante'";

		return ejecutarConsulta($sql);
		
	}

}